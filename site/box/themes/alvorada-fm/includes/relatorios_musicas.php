<?php /*

Relatório de Músicas

*/

// Relatório de músicas
function alvorada_relatorio_musicas() {
	ob_start();
	$output = fopen("php://output", "w");

	// Post ID da música
	$musica_id = $_GET['musica_id'];

	// columns
	fputcsv($output, array(
		utf8_decode( 'Título' ),
		'Artista',
		utf8_decode( 'Música' ),
		'Votos'
	) );

	if ($musica_id) {
		$query = new WP_Query( array(
			'posts_per_page' => 1,
			'post_type' => 'musica',
			'ignore_sticky_posts' => false,
			'post__in' => array( $musica_id )
		) );
	
		if ( $query->have_posts() ) {
			$query->the_post();

			$musicas = get_field( 'musicas' );
			$title = utf8_decode( get_the_title() );

			foreach( $musicas as $musica ) {
				$musica = (object) $musica;
				fputcsv($output, array(
					$title,
					utf8_decode( $musica->artista ),
					utf8_decode( $musica->musica ),
					$musica->votos
				) );
			}
		
			wp_reset_postdata();
		}
	}

	$data = ob_get_contents();
	fclose($output);
	ob_end_clean();

	return alvorada_fn_return( "musicas", $data );
}

// SETUP

// Add column
add_filter('manage_musica_posts_columns', function ( $defaults ) {
	$defaults['relatorio']  = 'Relatório';
	return $defaults;
} );

// Add link
add_action( 'manage_musica_posts_custom_column', function ( $column_name, $post_id ) {
	if ($column_name == 'relatorio') {
		$url = admin_url( "admin-post.php?action=print_musicas.csv&musica_id={$post_id}" );
		echo "<a href=\"{$url}\" target=\"_blank\" class=\"button\">Gerar relatório</a>";
	}
}, 10, 2 );

// Add actions for CSV download
add_action( 'admin_post_print_musicas.csv', function () {
	// Check that the user is allowed to update options
	if (!current_user_can('manage_options')) {
		wp_die('You do not have sufficient permissions to access this page.');
	}

	$debug = false;
	$result = alvorada_relatorio_musicas();

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
