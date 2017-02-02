<?php

/**
 * HELPER FUNCTIONS
 */


function get_publicidades( $layout ) {
	$publicidades = get_field( 'publicidade', 'option' );

	foreach( $publicidades as $publicidade ) {
		if( ( strtotime( $publicidade['data_de_inicio'] ) <= strtotime( date( 'Y-m-d' ) ) ) && ( strtotime( $publicidade['data_de_final'] ) >= strtotime( date( 'Y-m-d' ) ) ) ) {
			if( $publicidade['layout'] == $layout ) {
				$publicidades_ativas[] = $publicidade;
			} 			
		}
	}

	if( empty( $publicidades_ativas ) ) {
		return false;
	} else {
		return $publicidades_ativas;
	}
}

// Retorna todas as promoções, ou apenas a de promocaoID
function alvorada_get_promocao( $promocaoID=NULL ) {
	// Salva a lista de promoções na memória para ser utilizada depois
	static $lista;

	if ( !$lista ) {
		$args_promocoes = array(
			'post_type' => 'promocao',
			'posts_per_page' => -1
		);

		$promocoes = new WP_Query( $args_promocoes );
		$lista = array();

		if( $promocoes->have_posts() ) {
			foreach($promocoes->posts as $post) {
				$status_promocao = get_field( 'status', $post->ID );
				$status_ganhador = get_field( 'ganhador', $post->ID );
				$email_ganhador = get_field( 'email_ganhador', $post->ID );
				$tipo = get_field( 'tipo', $post->ID );
				$data_encerramento = get_field( 'data_final_promocao', $post->ID );
				$horario_final_promocao = get_field( 'horario_final_promocao', $post->ID );
				$timestamp_encerramento = strtotime( $data_encerramento . ' ' . $horario_final_promocao . ':00' );

				$participantes_promocao = get_field( 'participantes_promocao', $post->ID );
				$participantes = ( ! empty( $participantes_promocao ) ) ? json_decode( $participantes_promocao, true ) :  null;

				$ganhadores = get_field( 'ganhadores', $post->ID );
				$ganhadores = ( ! empty( $ganhadores ) ) ? json_decode( $ganhadores, true ) : array();

				$post->status = $status_promocao;
				$lista[ $post->ID ] = (object) array(
					'post' => $post,
					'status' => $status_promocao,
					'ganhador' => $status_ganhador,
					'tipo' => $tipo,
					'encerramento' => $timestamp_encerramento,
					'ganhadores' => $ganhadores,
					'participantes' => $participantes,
					'email_ganhador' => $email_ganhador
				);
			}
		}
	}

	if ($promocaoID) {
		return $lista[ $promocaoID ];
	}

	return $lista;
}

// Retorna todas as promoções do usuário
function get_minhas_promocoes( $userID ) {
	$lista = alvorada_get_promocao();
	$promocoes_minhas = array();

	foreach ($lista as $postID => $promocao) {
		$participantes = $promocao->participantes;
		$post = $promocao->post;

		if( $participantes ) {
			if( array_key_exists( $userID, $participantes ) ) {
				$promocoes_minhas[] = $promocao;
			} 
		}
	}

	return $promocoes_minhas;
}
