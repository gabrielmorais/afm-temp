
<?php
	// if (!isset($_GET['access'])){
	// 	 $redir = "//".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
	// 	 $redir = str_replace('/site', '', $redir);
	// 	 echo $redir;
	// 	header("Location: ".$redir);
	// }
 ?>

<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <?php theme_meta(); ?>

  <title><?php wp_title( '|', true, 'right' ); ?></title>

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

  <?php wp_head(); ?>
</head>
<?php
    setlocale(LC_ALL, NULL);
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
?>
<body <?php body_class(); ?>>
<!-- update test deploy bot (13)-->

<?php

if( is_post_type_archive( 'promocao' ) || is_singular( 'promocao' ) ) {
	$active = 'promocao';
} else if( is_post_type_archive( 'evento' ) || is_singular( 'evento' ) ) {
	$active = 'evento';
} else if( is_post_type_archive( 'conteudo' ) || is_singular( 'conteudo' ) ) {
	$active = 'conteudo';
} else if( is_post_type_archive( 'programacao' ) || is_singular( 'programacao' ) || is_tax( 'assunto' ) ) {
	$active = 'programacao';
}


 ?>

<div id="container-frame">

<div id="teste" data-title="<?php wp_title( '|', true, 'right' ); ?>" data-url="<?php echo str_replace( '?url=1', '', get_permalink() ); ?>">



						<div class="search-div first">
						<div class="container">
							<form class="navbar-form navbar-left" role="" action="/site">
							<div class="form-group">
								<input type="text" class="form-control" name="s" placeholder="Buscar por...">
							</div>
							<button type="submit" class="btn btn-default">
								<i class="fa fa-search"></i>
							</button>
						</form>
						</div>
						</div>
<header>
	<div class="container">


	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">

					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
					</button> <a class="navbar-brand link-refresh" href="<?php echo WP_HOME ?>">
						<img src="<?php echo IMG_URL ?>logo-alvorada-fm.png">
					</a>
					<a href="" class="play-icon-mobile"><img src="<?php echo IMG_URL ?>play.gif"></a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav top">
						<li class="entrar">
								<?php
								if ( is_user_logged_in() ) {
									$current_user = wp_get_current_user();
									?>
									<a href="<?php echo get_permalink( get_page_by_title( 'Espaço Alvorada' ) ); ?>">
									<?php
									$nome_logado = esc_html( get_field('nome' , "user_{$current_user->data->ID}")  );
									$nome_logado = explode(" ", $nome_logado);
									$nome_logado = "Oi, ".$nome_logado[0];
									$nome_logado = str_pad($nome_logado, 31, "=", STR_PAD_LEFT);
									$nome_logado = explode("Oi,", $nome_logado);
									echo "<span style='visibility:hidden'>".$nome_logado[0]."</span><i class='fa fa-user'></i>Oi," . $nome_logado[1];
									?>
									</a>
									<?php
								} else {
									?>
									<a href="<?php echo get_permalink( get_page_by_title( 'Espaço Alvorada' ) ); ?>" class="link-refresh"><span style="visibility:hidden">Entrar no</span> Meu espaço Alvorada <img src="<?php echo IMG_URL ?>tip.png" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<?php echo strip_tags( get_field( 'informacao_topo_da_pagina', 'option' ) ) ?>"></a>
									<?php
								}
								?>
						</li>
						<li>
							<a href="<?php echo get_post_type_archive_link( 'pergunta' ); ?>" class="link-refresh">Dúvidas Frequentes</a>
						</li>
						<li>
							<a href="<?php echo get_permalink( get_page_by_title( 'fale conosco' ) ); ?>" class="link-refresh">Fale Conosco</a>
						</li>
						<li class="social first">
							<a href="https://www.facebook.com/Alvorada94.9/" target="_blank"><i class="fa fa-facebook"></i></a>
						</li>
						<li class="social">
							<a href="https://twitter.com/RadioAlvorada" target="_blank"><i class="fa fa-twitter"></i></a>
						</li>
						<li class="social">
							<a href="https://www.instagram.com/alvoradafm/" target="_blank"><i class="fa fa-instagram"></i></a>
						</li>
						<li class="search-btn">
							<a href="#"><i class="fa fa-search"></i></a>
						</li>
					</ul>

					<ul class="nav navbar-nav bot" data-reorder="true" data-reorder-target="ul.top" data-reorder-target-id="" data-reorder-dir="down">

						<div class="search-div second">
							<form class="navbar-form navbar-left" role="search" action="/">
							<div class="form-group">
								<input type="text" class="form-control" name="s" placeholder="Buscar por...">
							</div>
							<button type="submit" class="btn btn-default">
								<i class="fa fa-search"></i>
							</button>
						</form>
						</div>




						<li class="<?php echo ( $active == 'programacao' ) ? 'active' : null; ?>" data-reorder="true" data-reorder-target=".alvorada-ao-vivo" data-reorder-target-id="" data-reorder-dir="up">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'programacao' ) ); ?>" class="link-refresh">Programação</a>
						</li>
						<li class="<?php echo ( $active == 'evento' ) ? 'active' : null; ?>" >
							<a href="<?php echo esc_url( get_post_type_archive_link( 'evento' ) ); ?>" class="link-refresh">Eventos</a>
						</li>
						<li class="<?php echo ( $active == 'promocao' ) ? 'active' : null; ?>" >
							<a href="<?php echo esc_url( get_post_type_archive_link( 'promocao' ) ) ?>" class="link-refresh">Promoções</a>
						</li>
						<li class="<?php echo ( $active == 'conteudo' ) ? 'active' : null; ?>" >
							<a href="<?php echo esc_url( get_post_type_archive_link( 'conteudo' ) ); ?>" class="link-refresh">Mais conteúdo</a>
						</li>
						<li class="alvorada-ao-vivo">
							<a href="#" class="gradient-text"><img class="play-icon gif-icon" src="<?php echo IMG_URL ?>play.gif"><img class="play-icon png-icon" src="<?php echo IMG_URL ?>player.png">Alvorada Ao Vivo</a>
						</li>
					</ul>
				</div>

			</nav>
		</div>
	</div>
	</div>
</header>
<div class="opacity"></div>
