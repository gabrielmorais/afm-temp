<?php

the_post();

$user_id = get_current_user_id();
if ( $_GET['mensagem'] ) {
	$mensagem = $_GET['mensagem'];
}

$alterada = alvorada_dados_alterados();
$mensagem = ($alterada ? 'Por favor, confirme se o seu e-mail, endereço e telefone estão atualizados.' : '');

?>
		<div class="container">

				<div class="row">
				<div class="col-md-8">
					<h2 class="gradient-text">Espaço Alvorada</h2>

					<?php the_content(); ?>

					<h3 class="editar-meus-dados">Editar meus dados <i class="fa fa-angle-down"></i></h3>
					<?php echo $mensagem ? "<h4>{$mensagem}</h4>" : ''; ?>
					<form class="row cadastro cadastro-logado" id="alterar-dados" method="post" action="<?php echo admin_url( 'admin-ajax.php', 'alteracao_dados_usuario' ); ?>">
						<?php wp_nonce_field( 'alteracao_dados_usuario', 'alteracao_dados_usuario_nonce', get_permalink() ); ?>
						<input type="hidden" name="action" value="alteracao_dados_usuario" >
<?php $user_data = (array) alvorada_get_user( $user_id ); ?>
<?php alvorada_formulario_usuario( $user_data, true ); ?>
						<fieldset class="col-md-12">
							<div class="row">
								<div class="col-md-7">

								</div>
								<div class="col-md-5"><input type="submit" name="" value="ATUALIZAR" class="btn"></div>
							</div>
						</fieldset>
					</form>

					<?php

					$minhas_promocoes = get_minhas_promocoes( get_current_user_id() );

					if( ! empty( $minhas_promocoes ) ) {
					?>

						<div class="minhas-promocoes">
							<h3 class="ver-promos">Minhas promoções <i class="fa fa-angle-down"></i></h3>
							<div class="lista-promo">
							<table>
								<tr>
								    <th width="50%">Promoção</th>
								    <th width="20%">Status</th>
								    <th width="30%">Resultado</th>
								  </tr>
								  <?php

								  foreach( $minhas_promocoes as $promocao ) {
								  	$promocao = $promocao->post;

								  ?>
									  <tr>
									    <td><p><?php echo $promocao->post_title ?></p></td>
									    <td><p class="<?php echo ( $promocao->status == 'aberta' ) ? 'orange' : null; ?>"><?php echo ucwords( $promocao->status ) ?></p></td>
									    <?php
									    if( $promocao->ganhador ) {
									    ?>
								    		<td><p class="ganhou">Parabéns você ganhou<br><a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="<?php echo strip_tags(get_field('texto_de_resposta', $promocao->ID)); ?>">Veja como retirar seu prêmio</a></p></td>
									    <?php
									    } else {
									    ?>
									    	<td><p class="orange">-</p></td>
									    <?php
									    }
									    ?>
									  </tr>
								  <?php
								  }
								  ?>
<!-- 								  <tr>
								    <td><p>Lorem ipsum dolor sit amet</p></td>
								    <td><p>Encerrada</p></td>
								    <td><p class="ganhou">Parabéns você ganhou<br><a href="">Veja como retirar seu prêmio</a></p></td>
								  </tr> -->
							</table>
							</div>
						</div>

					<?php
					}

					?>

					<div>
						<a class="btn desconectar btn-default" href="<?php echo wp_logout_url( get_permalink( get_page_by_title( 'Espaço Alvorada' ) ) ); ?>">Desconetar</a>
					</div>


				</div>

				<?php

				$publicidades = get_publicidades( 267 );

				if( ! empty( $publicidades ) ) {
					array_rand( $publicidades, 1 );
				}

				?>

				<aside class="col-md-3 col-md-offset-1">

					<?php
						if( ! empty( $publicidades ) ) :
					?>
						<div class="col-md-4 item propaganda">
							<a href="<?php echo $publicidades[0]['link'] ?>">
								<img src="<?php echo $publicidades[0]['imagem'] ?>">
							</a>
						</div>
					<?php endif; ?>
				</aside>
			</div>
		</div>