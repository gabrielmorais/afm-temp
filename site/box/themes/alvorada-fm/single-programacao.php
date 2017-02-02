<?php get_header(); the_post(); ?>
<?php $programacaoID = get_the_ID(); ?>
<div class="inner">
<section class="megabanner">
			<div class="carousel slide" id="megabanner">

				<div class="carousel-inner">
				<?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>
					<div class="item active" style="background-image: url(<?php echo $thumbnail ?>)">
						<!-- <img alt="Carousel Bootstrap First" src=""> -->
						<div class="carousel-caption">
						<div class="container">
							<div>
							<h4 class="gradient-text">
								<?php the_title(); ?>
							</h4>
							<p><?php

			$apresentador = get_field( 'apresentador' );
			if( ! empty( $apresentador ) ) :
			?>
				<p>por <?php echo $apresentador->post_title; ?></p>
			<?php
			endif;
							?></p>
							</div>

						</div>

						</div>
					</div>

				</div>
			</div>


</section>


<article class="the-content programacao-interna">
	<div class="container">
		<div class="row">
			<div class="col-md-8 ">

			<?php
			$patrocinadores = get_field( 'patrocinio' );

			if( ! empty( $patrocinadores ) ) :

			?>

				<div class="header">
					<p class="patrocinio">Patrocínio</p>
					<?php
					foreach( $patrocinadores as $patrocinador ) :

					?>
						<img src="<?php echo $patrocinador['logo'] ?>" alt="<?php echo $patrocinador['nome'] ?>">
					<?php endforeach; ?>
				</div>

				<?php endif; ?>

				<div class="conteudo">
					<?php the_content(); ?>
				</div>

				<?php

				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$terms = get_field( 'categorias_de_conteudos' );

				$args_programas = array(
					'post_type' => 'conteudo',
					'posts_per_page' => 5,
					'paged' => $paged,
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'terms' => $terms
						)
					)
				);

				$programas = new WP_Query( $args_programas );

				global $wp_query;
				$wp_query = NULL;
				$wp_query = $programas;
			  	$programas->in_the_loop = true;

				/*echo '<pre>';
				print_r( $programas );
				echo '</pre>';*/


				if( $programas->have_posts() ) :

				?>

				<div class="conteudo">
					<h2>Programas</h2>
				</div>

				<?php


				while( $programas->have_posts() ) : $programas->the_post();
				?>
				<div class="conteudo artigo clearfix">
					<div class="header">
						<p><?php the_field( 'data' ) ?></p>
						<h5><?php the_title() ?></h5>
					</div>
					<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'listagem-programa' ); ?>
					<p><img src="<?php echo $thumbnail[0] ?>"></p>

					<p><?php echo wp_trim_words( $post->post_content, 100 ); ?></p>
					<p><a href="<?php the_permalink(); ?>">Leia mais</a></p>
					<?php the_field( 'audio' ) ?>

					<div class="share">
						<p>
							COMPARTILHAR
		<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="social facebook share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="social twitter share-link"><i class="fa fa-twitter"></i></a>
						</p>
					</div>

				</div>

				<?php endwhile;  ?>


				<div class="paginate">

					<div class="col-md-12 textcenter">
					<?php if(function_exists('wp_paginate')) {
					    wp_paginate();
					}
					?>

				</div>
			</div>


			<?php endif; ?>



			<?php wp_reset_query(); ?>

			</div>
			<aside class="col-md-3 col-md-offset-1">

<!-- 				<div class="gostou clearfix">
					<h4><span class="fl">Gostou desse<br> programa?</span>
						<a href="" class="fr"><i class="fa fa-thumbs-up"></i></a>
						<a href="" class="fr"><i class="fa fa-thumbs-down"></i></a>

					</h4>
				</div> -->

				<ul class="horarios">
					<h4>Horários</h4>
					<?php the_field( 'horarios_completo' ) ?>
				</ul>

				<?php $args_archive = array(
					'type'            => 'monthly',
					'limit'           => '',
					'format'          => 'html',
					'before'          => '',
					'after'           => '',
					'show_post_count' => false,
					'echo'            => 1,
					'order'           => 'DESC',
			        'post_type'       => 'programacao'
				);
				?>

				<?php

				if ( $programas->post_count > 0){
					?>
					<ul class="arquivo">
						<h4>Arquivo</h4>
						<?php 	wp_get_archives( $args_archive );  ?>
					</ul>
					<?php
				}
				 ?>


				<?php

				$publicidades = get_publicidades( 293 );

				if( ! empty( $publicidades ) ) {
					array_rand( $publicidades, 1 );

				?>

					<div class="publicidades">
						<a href="<?php echo $publicidades[0]['link'] ?>"><img alt="Bootstrap Image Preview" src="<?php echo IMG_URL ?>bose.jpg"></a>
					</div>

				<?php
				}
				?>
				<?php if( ! empty( $apresentador ) ) : ?>
				<div class="fale-com">
				<h4>Fale com o colunista</h4>
				<p>Envie sua sugestão ou tire sua dúvida com o nosso colunista.</p>

				<?php $name_apresentador = get_field( 'apresentador' ); ?>
				<?php $name_apresentador = sanitize_title($name_apresentador->post_title); ?>
				<p><a href="<?php echo get_permalink( get_page_by_title( 'fale conosco' ) ); ?>?assunto=<?php echo strtolower(str_replace(' ', '-', $name_apresentador)); ?>" class="btn btn-default">Enviar</a></p>
				</div>
			<?php endif; ?>

			</aside>
		</div>
	</div>
</article>


<?php

$taxonomies = wp_get_post_terms( $post->ID, 'assunto', array( 'fields' => 'ids' ) );

$args_outros_programas = array(
	'post_type' => 'programacao',
	'post__not_in' => array( $programacaoID ),
	'tax_query' => array(
		array(
			'taxonomy' => 'assunto',
			'fields' => 'term_id',
			'terms' => array( join( '', $taxonomies ) )
		)
	),
	'posts_per_page' => 3,
	'orderby' => 'rand'
);

$outros_programas = new WP_Query( $args_outros_programas );

/*echo '<pre>';
print_r( $outros_programas );
echo '</pre>';*/

if( $outros_programas->have_posts() ) :

?>

<section class="listagem listagem-programacao outros-conteudos">

		<div class="container">
		<div class="row">
		<div class="col-md-12">
			<h2 class="gradient-text">OUÇA OUTROS PROGRAMAS</h2>
		</div>

		<?php while( $outros_programas->have_posts() ) : $outros_programas->the_post();


			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'destaque-listagem' );
		 ?>

		<div class="col-md-4 item hvr-shadow-radial">
			<div class="image " style="background-image:url(<?php echo $thumbnail[0] ?>)">
					<div class="hover">
						<a href="" class="social facebook"><i class="fa fa-facebook"></i></a>
						<a href="" class="social twitter"><i class="fa fa-twitter"></i></a>
						<a class="search hvr-grow" href="<?php the_permalink(); ?>"><i class="fa fa-search"></i></a>
						<div class="after"><a href="<?php the_permalink(); ?>"></a></div>
					</div>
					<!-- <img class="img-responsive" alt="Bootstrap Image Preview" src="assets/images/skank.jpg" /> -->
			</div>
			<div class="content">
			<h3>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<?php
			$apresentador = get_field( 'apresentador' );
			if( ! empty( $apresentador ) ) :

			?>
				<p>por <?php echo $apresentador ?></p>
			<?php endif; ?>
			<p>
			<a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( $post->post_content, 15 ); ?></a>
			</p>
				<div class="footer">
					<p class="participe-ate"><b><?php the_field( 'horario_do_programa' ) ?></b></p>
					<p class="textcenter">
					<a href="<?php the_permalink(); ?>" class="btn btn-default">
						Saiba mais
					</a>
					</p>
				</div>
			</div>
		</div>

		<?php endwhile ?>
		<div class="clearfix">
		<p class="textcenter"><a class="btn btn-style-2" href="<?php echo get_post_type_archive_link( 'conteudo' ); ?>">VEJA MAIS</a></p>
		</div>
		</div>
	</div>
</section>

<?php endif; ?>


<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>
<?php get_footer(); ?>