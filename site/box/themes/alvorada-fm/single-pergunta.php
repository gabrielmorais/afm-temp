<?php get_header(); the_post(); ?>
<div class="inner faq">
	<section class="faq-content">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<h2 class="gradient-text">Perguntas Frequentes</h2>

					<div class="input-search pRelative">
						<form action="<?php echo get_post_type_archive_link( 'pergunta' ); ?>" action="get">
							<input type="text" value="" name="s" class="termo" placeholder="BUSCA POR PALAVRAS-CHAVE">
							<div class="submit">
							<i class="fa fa-search"></i>
							<input type="submit" value="" />

						</div>
						</form>
					</div>

					<h3><?php the_title(); ?></h3>

					<?php the_content(); ?>

					<div class="input-search pRelative"></div>

					<p class="upper"><b>Ou navegue pelas perguntas abaixo:</b></p>
					<ul class="list">
						<?php

						$perguntaID = get_the_ID();
						$perguntas_frequentes = new WP_Query( array(
							'post_type' => 'pergunta',
							'posts_per_page' => -1,
							'post__not_in' => array( $perguntaID )
						) );


						foreach( $perguntas_frequentes->posts as $post ) {
						?>
						<li><a href="<?php echo get_permalink( $post ); ?>"><?php echo get_the_title( $post ); ?></a></li>
						<?php } ?>
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
					?>



					<?php

					$publicidades = get_publicidades( 267 );

					if( ! empty( $publicidades ) ) {
						array_rand( $publicidades, 1 );;

					?>

						<div class="publicidades">
							<a href="<?php echo $publicidades[0]['link'] ?>"><img alt="Bootstrap Image Preview" src="<?php echo $publicidades[0]['imagem'] ?>"></a>
						</div>

					<?php
					}
					?>
				</aside>
			</div>
		</div>
	</section>

<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer(); ?>