<?php /*

Relatório das Playlists

*/

// Relatório do player
function alvorada_relatorio_player() {
	ob_start();
	$output = fopen("php://output", "w");

	// columns
	fputcsv($output, array(
		'Artista',
		utf8_decode( 'Música' ),
		'Votos a favor',
		'Votos contra',
		'Total de votos'
	) );

	$votes = get_field( 'player_vote', 'option' );
	if ( $votes ) {
		$votes = json_decode( $votes );
		$data = array();

		foreach($votes as $index => $vote) {
			$music = $vote[0];
			$artist = $vote[1];
			$yes = $vote[2];
			$no = $vote[3];

			// Cria uma chave para calcular todas as músicas por artistas
			$key = sanitize_title( $music .' '. $artist );

			// Se ainda não existe, cria com os valores padrões
			if ( !isset($data[ $key ])) {
				$data[ $key ] = array($artist, $music, 0, 0, 0);
			}

			$data[ $key ][2] += $yes; // Número de votos a favor
			$data[ $key ][3] += $no;  // Número de  votos contra
			$data[ $key ][4] += $yes + $no; // Total
		}

		// Adiciona o contador para o arquivo CSV
		foreach($data as $index => $row) {
			fputcsv($output, $row);
		}
	}

	$data = ob_get_contents();
	fclose($output);
	ob_end_clean();

	return alvorada_fn_return( 'player', $data );
}

// SETUP

// create custom plugin settings menu
add_action('admin_menu', function () {
  //create new top-level menu
  add_submenu_page('edit.php?post_type=musica', 'Player', 'Player', 'manage_options', 'relatorios_player', 'alvorada_relatorios_player' );
} );

// Verifica se é admin e exibe o HTML da página de relatórios
function alvorada_relatorios_player() {
	// Check that the user is allowed to update options
	if (!current_user_can('manage_options')) {
		wp_die('You do not have sufficient permissions to access this page.');
	}

	include "relatorios/player.php";
}

// Add actions for CSV download
add_action( 'admin_post_print_player.csv', function () {
	// Check that the user is allowed to update options
	if (!current_user_can('manage_options')) {
		wp_die('You do not have sufficient permissions to access this page.');
	}

	$debug = false;
	$result = alvorada_relatorio_player();

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
} );