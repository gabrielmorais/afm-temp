<?php

// Verifica se o admin está logado
if( ! is_super_admin( get_current_user_id() ) ) {
	get_header();
	exit( 'Você precisa ser admin para usar esta página!' );
} 

// Pega o ID da promoção
$promocaoID = $_GET['pro'];
if( empty( $promocaoID ) ) {
	exit( 'Deve informar um id de promoção' );
}

// Atualiza ganhadores e encerra a promoção
if( isset( $_GET['ganhadores'] ) && ! empty( $_GET['ganhadores'] ) ) {
	$lista = explode(',', $_GET['ganhadores']);
	$ganhadores = json_encode( $lista, true );

	if ( is_array($lista) ) {
		alvorada_email_ganhadores( $lista, $promocaoID );
	}

	update_field( 'ganhadores', $ganhadores, $promocaoID );
	update_field( 'ganhador', 1, $promocaoID );
	update_field( 'status', 'encerrada', $promocaoID );

	wp_redirect( get_permalink()."?pro=".$promocaoID );
	exit;
}

get_header();

$promocao = get_post( $promocaoID );
$status = get_field( 'status', $promocao );
$tipo = get_field( 'tipo', $promocao );

// Verifica se a promoção já foi encerrada
if( $status != 'encerrada' ) {
	get_header();
	exit( 'esta promocao ainda está aberta' );
}

$categorias_promocao = wp_get_post_terms( $promocao->ID, 'categoria-de-promocao' );
if( $categorias_promocao[0]->slug == 'promocao-relampago' ) {
	$class_has_bold = 'bolt';
}

$participantes = get_field( 'participantes_promocao', $promocao->ID );

//print_r( $participantes ); exit;

/*if( get_field( 'ganhador', $promocao ) )
	exit('Promoção já encerrada com ganhadores');*/

if( ! empty( $participantes ) ) {
	$participantes = json_decode( $participantes, true );
} else {
	exit('Nenhum participante para esta promoção.');
}

global $winners;

$winners = get_field('numero_de_ganhadores', $promocao->ID) ;
?>


<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>Sorteio</h2>
			<?php

					// Ganhador é só uma flag para se existe ou não ganhador já?
					if( get_field( 'ganhador', $promocao ) ) {
						$ganhadores = get_field( 'ganhadores', $promocao );
						$ganhadores = json_decode( $ganhadores, 1 );
					}

					$ativo = empty( $ganhadores );

					// Se não existe ganhadores, exibe o botão de notificar e encerrar a promoção
					if( $ativo ) :
					?>		
						<div class="textcenter">
							<a class="veja-mais notificar-ganhadores btn btn-default btn-style-2"  data-id="<?php echo $_GET['pro'] ?>" data-url="<?php echo get_permalink(); ?>" style="margin: 0 auto 40px; ">Notificar Ganhadores e encerrar a promoção</a>
						</div>
					<?php  endif; ?>

			<table class="table table-hover <?php echo $class_has_bold  ?>" data-winners="<?php echo $winners ?>">				
				<thead>
					<tr>
						<th>Nome</th>
						<th>Resposta</th>
						<th>Válido?</th>
						<th>Ganhador?</th>
					<?php if ( !$ativo ) : ?>
						<th>PDF</th>
					<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php

					// Cria uma list de IDs aleatóriamente, até o número de máximo de ganhadores
					function shuffle_assoc($list) { 
					  if ( !is_array( $list ) ) {
					  	return $list;
					  }

					  $count_shuffle = 1;
					  $keys = array_keys($list); 
					  shuffle($keys);

					  $random = array(); 
					  foreach ($keys as $key) { 
					  	global $winners; // numero_de_ganhadores

					  	if( $count_shuffle <= $winners ) {
					    	$random[] = $key; 
					  	}
					    $count_shuffle++;
					  }
					  return $random; 
					}

					foreach($participantes as $id => $resposta) {
						$participantes[ $id ] = alvorada_get_user_promocao( $id );
						if ($participantes[ $id ]) {
							$participantes[ $id ]->resposta = $resposta['resposta'];
						}
					}

					$validos = alvorada_participantes_validos($participantes, $promocao->ID);

					// Lista de IDs "ganhadores". Array é gerado aleatóriamente até "$winners" participantes
					$participantes_shuffle = shuffle_assoc( $validos );

					foreach( $participantes as $id => $participante ) :
						$ehValido = isset( $validos[ $id ] );

					?>
					<tr>
						<td><?php echo $participante->user_nicename; ?></td>
						<td><?php echo $participante->resposta; ?> </td>
						<td><?php echo $ehValido ? '<b>Sim</b>' : 'Não' ?> </td>
						<td>
							<div class="inline-block cb">
							<?php 
								$checked = '';
								$disabled = '';
								$showPDF = false;

								// Existem ganhadores já e a promoção está encerrada?
								if( isset( $ganhadores ) ) {
									$disabled = 'disabled="true"'; // Desabilita os checkboxes
									$checked = ( in_array($id, $ganhadores) ) ? 'checked' : ''; // Marca o checkbox do ganhador

									if (!$ativo) {
										$showPDF = in_array($id, $ganhadores);
									}
								}
								// Verifica se o tipo é sorteio. No caso do concurso cultural faz-se apenas a validação e mostra todos os participantes.
								else if ($tipo == 'sorteio') {
									// A promoção não tem ganhadores ainda, marca o checkbox de acordo com a lista aleatória
									$checked = ( in_array($id, $participantes_shuffle) ) ? 'checked' : '';
									if (!$ativo) {
										$showPDF = true;
									}
								}
							?>
				              <input <?php echo $checked; ?> id="option_<?php echo $id ?>" <?php echo $disabled; ?> class="ganhador" type="checkbox" name="option_<?php echo $id ?>" value="<?php echo $id ?>">
				              <label for="option_<?php echo $id ?>"><span><span></span></span></label>
            				</div>
						</td>
					<?php if ( $showPDF ) : ?>
						<td><a href="<?php echo admin_url( "admin-post.php?action=promocao.pdf&promocaoID={$promocaoID}&userID={$id}" ); ?>" target="_blank">Download</a></td>
					<?php endif; ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th>Nome</th>
						<th>Resposta</th>
						<th>Válido?</th>
						<th>Ganhador?</th>
					<?php if ( !$ativo ) : ?>
						<th>PDF</th>
					<?php endif; ?>
					</tr>
				</tfoot>
			</table>
		</div>

		<p>Existem <?php echo count($participantes); ?> paticipante(s) sendo <?php echo count($validos); ?> válido(s).</p>
		<?php if ( !count($validos) ) : ?>
			<p>Obs.: Não existem participantes válidos</p>
		<?php endif; ?>

		<?php
		// Se não existe ganhadores, exibe o botão de notificar e encerrar a promoção
		if( $ativo ) :
		?>
			<div class="textcenter">
				<a class="veja-mais notificar-ganhadores btn btn-default btn-style-2"  data-id="<?php echo $_GET['pro'] ?>" data-url="<?php echo get_permalink(); ?>" style="margin: 0 auto 40px; ">Notificar Ganhadores e encerrar a promoção</a>
			</div>
		<?php else: ?>
		<div class="textcenter">
			<a class="btn btn-default" target="_blank" href="<?php echo admin_url( "admin-post.php?action=print.csv&type=todos-cadastrados&promocaoID={$promocaoID}" ); ?>">Gerar relatório</a>
		</div>
		<br />

		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>