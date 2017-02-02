<?php /*
REGRA DA PROMOÇÃO

Estão aptos a serem sorteados na promoção pessoas que não ganharam nos últimos 3 meses, possuem cadastro com e-mail e telefone atualizados e cpf válido.

RELATÓRIOS

Deverá ter a possibilidade de gerar relatórios em Excel dos usuários cadastrados no banco por:

a)	Todos cadastrados
b)	Participantes por promoção
c)	Por usuários (os que mais participam, o tipo de promoção que participam, etc)

Campos do relatório:

a)	Todos os campos preenchidos no cadastro
b)	Promoções que participou
c)	Promoções que ganhou

*/

// RELATÓRIOS

// Lista todos os cadastrados
function alvorada_todos_cadastrados() {
	ob_start();
  	$output = fopen("php://output", "w");

  	// columns
	fputcsv($output, array(
		// Dados da Promoção
		'Promocao', 'Status', 'Tipo', 'Data final', 'Data do Evento', 'Local do Evento', 'No de Ganhadores',

		// Dados do Usuário 
		'Ganhador', 'ID do Usuario', 'E-mail', 'Usuario', 'Nome', 'Sobrenome', 'Sexo', 'CPF', 
		'Nascimento', 'Telefone', 'Celular', 'Endereco', 'Cidade', 'Estado', 'CEP', 'Resposta'
	));

	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'promocao'
	);

	$promocaoID = $_GET['promocaoID'];
	if ( $promocaoID ) {
		$args['post__in'] = array($promocaoID);
	}

	$promocoes = new WP_Query( $args );
	if ( $promocoes->have_posts() ) {
		while ( $promocoes->have_posts() ) {
			$promocoes->the_post();

			$participantes = get_field( 'participantes_promocao' );
			$status = get_field( 'status' );
			$tipo = get_field( 'tipo' );
			$ganhador = get_field( 'ganhador' );
			$data_final_promocao = get_field( 'data_final_promocao' );
			$horario_final_promocao = get_field( 'horario_final_promocao' );
			$data_do_evento = get_field( 'data_do_evento' );
			$local_do_evento = get_field( 'local_do_evento' );
			$numero_de_ganhadores = get_field( 'numero_de_ganhadores' );

			$title = utf8_decode( get_the_title() );
			$data_final = $data_final_promocao .' '. $horario_final_promocao;

			if ( $participantes ) {
				$participantes = json_decode( $participantes, true );
				$ganhadores = get_field( 'ganhadores' );
				if ( $ganhadores ) {
					$ganhadores = json_decode( $ganhadores ) ;
				}
			
				foreach ($participantes as $userID => $resposta) {
					$user = alvorada_get_user( $userID );
					$row = NULL;

					// Verifica se o usuário existe
					if ($user) {
						$ehGanhador = is_array($ganhadores) && in_array($user->ID, $ganhadores) ? 'Sim' : '';
						$resposta = ($resposta ? $resposta['resposta'] : '');

						$row = array(
							$title,
							$status,
							$tipo,
							$data_final,
							$data_do_evento,
							$local_do_evento,
							$numero_de_ganhadores,
							$ehGanhador,
							$user->ID,
							$user->user_email,
							$user->display_name,
							utf8_decode( $user->nome ),
							utf8_decode( $user->sobrenome ),
							utf8_decode( $user->sexo ),
							$user->cpf,
							$user->nascimento,
							$user->telefone,
							$user->celular,
							utf8_decode( $user->endereco ),
							utf8_decode( $user->cidade ),
							$user->cep,
							utf8_decode( $user->estado ),
							utf8_decode( $resposta )
						);
					}
			
					if ( is_array($row) ) {
						fputcsv($output, $row);
					}
				}	
			}

		}
		wp_reset_postdata();
	}

	$data = ob_get_contents();
	fclose($output);
	ob_end_clean();

	return alvorada_fn_return( 'todos-cadastrados', $data );
}

// SETUP

// create custom plugin settings menu
add_action('admin_menu', function () {
  //create new top-level menu
  add_submenu_page('edit.php?post_type=promocao', 'Relatórios das Promoções', 'Relatórios', 'manage_options', 'relatorios_promocoes', 'alvorada_relatorios_promocoes' );
} );

// Verifica se é admin e exibe o HTML da página de relatórios
function alvorada_relatorios_promocoes() {
	// Check that the user is allowed to update options
	if (!current_user_can('manage_options')) {
		wp_die('You do not have sufficient permissions to access this page.');
	}

	include "relatorios/promocao.php";
}

// Add actions for CSV download
add_action( 'admin_post_print.csv', function () {
	// Check that the user is allowed to update options
	if (!current_user_can('manage_options')) {
		wp_die('You do not have sufficient permissions to access this page.');
	}

	// Lista de relatórios disponíveis
	$available = array(
		'todos-cadastrados' => 'alvorada_todos_cadastrados',
		'por-promocao' => '',
		'usuarios-participaram' => '',
		'tipo-de-promocao' => ''
	);
	$type = $_GET['type'];
	$fn = $available[ $type ];
	$debug = false;

	if ($fn) {
		$result = call_user_func( $fn );

		if ($debug) {
			// Exibe como texto na tela
			header("Content-type: text/plain", true, 200);
			print( $result->data );
		}
		else {
			// Força o download
			alvorada_dump_csv( $result );
		}

    	exit();
	}
} );
