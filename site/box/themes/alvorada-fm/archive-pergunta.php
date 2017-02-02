<?php get_header() ?>

<div class="inner faq">
	<section class="faq-content">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<h2 class="gradient-text">Perguntas Frequentes</h2>
					<p><?php //echo wp_trim_words( get_field( 'chamada_perguntas_frequentes', 'option' ), 50 ) ?>
						Surgiram muitas dúvidas por aí? Conheça as perguntas mais frequentes na hora de participar das nossas promoções, dúvidas sobre a programação, dicas do nosso site e muito mais. Se a dúvida permanecer te ajudamos a resolver nas nossas redes sociais ou pelo <a href="/fale-conosco">Fale Conosco</a>.
					</p>
					<br />
					<div class="input-search pRelative">
						<form action="<?php echo get_post_type_archive_link( 'pergunta' ); ?>" action="get">
							<input type="text" value="" name="s" class="termo" placeholder="BUSCA POR PALAVRAS-CHAVE">
							<div class="submit">
							<i class="fa fa-search"></i>
							<input type="submit" value="" />

						</div>
						</form>
					</div>
					<p class="upper"><b>Ou navegue pelas perguntas abaixo:</b></p>
					<ul class="list">
						<?php foreach( $posts as $post ) : the_post(); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title( ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<aside class="col-md-3 col-md-offset-1">

					<?php

					$publicidades = get_publicidades( 293 );

					if( ! empty( $publicidades ) ) {
						array_rand( $publicidades, 1 );;

					?>

						<div class="publicidades">
							<a href="<?php echo $publicidades[0]['link'] ?>"><img alt="Bootstrap Image Preview" src="<?php echo $publicidades[0]['imagem'] ?>"></a>
						</div>

					<?php
					}
					//  Se tiver banner ativo cadastrado no site vale ele, se não tiver ativo entra automaticamente o do Google.
					else {

						alvorada_google_ad( 306, 250 );

					}

					?>

						<div class="publicidades">
							<a href=""><img alt="" src="<?php echo IMG_URL ?>app-pub.jpg"></a>
						</div>


				</aside>
			</div>
		</div>
	</section>



<?php get_footer() ?>