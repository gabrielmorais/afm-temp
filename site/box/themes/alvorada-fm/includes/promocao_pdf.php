<?php /*

PDF da Promoção

*/

// RELATÓRIOS

// Exibe o PDF
function alvorada_promocao_pdf( $promocaoID, $userID ) {
	$use_pdf = false;
	$promocao = alvorada_get_promocao( $promocaoID );
	$user = alvorada_get_user( $userID );

	$logo = get_site_url() . "/box/themes/alvorada-fm/assets/images/logo-alvorada-fm.png";
	$title = utf8_decode($promocao->post->post_title);
	$resumo = utf8_decode( get_field( 'texto_do_documento', $promocaoID ) );
	$data = utf8_decode( get_field( 'data_resumida', $promocaoID ) );
	$premio = utf8_decode( get_field( 'premio', $promocaoID ) );
	$premio_desc = utf8_decode( get_field( 'descricao_do_premio', $promocaoID ) );

   	$template = include( 'htmls/promocao_pdf.php' );
   	$message = utf8_encode($template);

   	if ( $use_pdf ) {
		include TEMPLATEPATH . '/mpdf60/mpdf.php';
		$mpdf = new mPDF();
		$mpdf->debug = true;
		$mpdf->showImageErrors = true;
		$mpdf->WriteHTML( $message );
		return $mpdf;
	}

	// Retorna o HTML se não estiver usando o PDF
	return $message;
}

// SETUP

// Add actions for PDF download
add_action( 'admin_post_promocao.pdf', function () {
	// Check that the user is allowed to update options
	if (!current_user_can('manage_options')) {
		wp_die('You do not have sufficient permissions to access this page.');
	}

	$promocaoID = $_GET['promocaoID'];
	$userID = $_GET['userID'];

	$result = alvorada_promocao_pdf( $promocaoID, $userID );
	if ( is_a( $result, 'MPDF' ) ) {
		$result->Output();
	}
	else {
		echo $result;
	}

	exit;
} );
