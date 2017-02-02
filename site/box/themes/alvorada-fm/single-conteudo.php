<?php get_header(); the_post(); ?>



<div class="inner">
<?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>
<?php if (empty($thumbnail)):?>
<section class="megabanner no-bg-image">
			<div class="carousel slide" id="megabanner">

				<div class="carousel-inner">


					<div class="item active" style="background-image: url(<?php echo $thumbnail ?>); background-position: center <?php echo get_field( 'alinhamento_da_imagem' ) ?>;">
						<!-- <img alt="Carousel Bootstrap First" src=""> -->
						<div class="carousel-caption">
						<div class="container">
							<div>
							<h4 class="gradient-text">
								<?php the_title(); ?>
							</h4>
							<p><?php the_field( 'data' ) ?></p>
														<p>
								<?php echo wp_trim_words( $post->post_content, 15 ); ?>
							</p>

							<p class="social-banner">
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="share-link"><i class="fa fa-twitter"></i></a>
							</p>
							</div>

						</div>

						</div>
					</div>

				</div>
			</div>


</section>
<?php else: ?>
<section class="megabanner">
			<div class="carousel slide" id="megabanner">

				<div class="carousel-inner">
					<?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>

					<div class="item active" style="background-image: url(<?php echo $thumbnail ?>); background-position: center <?php echo get_field( 'alinhamento_da_imagem' ) ?>;">
						<!-- <img alt="Carousel Bootstrap First" src=""> -->
						<div class="carousel-caption">
						<div class="container">
							<div>
							<h4 class="gradient-text">
								<?php the_title(); ?>
							</h4>
							<p><?php the_field( 'data' ) ?></p>
														<p>
								<?php echo wp_trim_words( $post->post_content, 15 ); ?>
							</p>

														<p class="social-banner">
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="share-link"><i class="fa fa-twitter"></i></a>
							</p>
							</div>

						</div>

						</div>
					</div>

				</div>
			</div>


</section>
<?php endif; ?>

<article class="the-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 ">

			<div class="header">

				<?php
				$colunista = get_field( 'colunista' );

				if( ! empty( $colunista ) ) :

				?>

					<p>Texto por</p>
					<h5><a href=""><?php echo $colunista->post_title; ?></a></h5>

				<?php endif; ?>
				<p><?php the_terms_without_uncategorized( get_the_ID(), 'category' ) ?><!-- <a href="">Categoria 1</a>,<a href="">Categoria 2</a> --></p>
			</div>

			<div class="conteudo">

				<?php the_content(); ?>


				<?php

				$galeria = get_field( 'galeria' );

				if( ! empty( $galeria ) ) :

/*					echo '<pre>';
					print_r( $galeria );
					echo '</pre>';*/
					$count_galeria = 1;
				?>

					<div class="carousel slide" id="slider" data-ride="carousel">
						<div class="carousel-inner">

							<?php foreach( $galeria as $imagem ) : ?>
								<div class="item <?php echo ( $count_galeria == 1 )? 'active' : null; ?>">
									<div class="image pRelative">
									<img alt="Carousel Bootstrap First" src="<?php echo $imagem['url'] ?>">
									</div>
								</div>
							<?php $count_galeria++; endforeach ?>
						</div>

						<a class="left carousel-control" href="#slider" data-slide="prev">
							<span class="glyphicon glyphicon-menu-left"></span>
						</a>
						<a class="right carousel-control" href="#slider" data-slide="next">
							<span class="glyphicon glyphicon-menu-right"></span>
						</a>
					</div>

				<?php endif; ?>


			</div>


			<?php if( ! empty( $colunista ) ) : ?>
				<div class="autor">
					<div class="infos">
						<?php


						$avatar = get_field( 'avatar', $colunista->ID ); $avatar = $avatar['sizes']['avatar-colunista'];

						?>
						<div class="img hvr-rotate" style="background-image: url(<?php echo $avatar ?>)"><a href="" style="width:100%;height:100%;display:block"></a></div>
						<div class="text">
							<p><span>Colunista</span></p>
							<h4><a href=""><?php echo $colunista->post_title ?></a></h4>
							<p><?php echo $colunista->post_content; ?></p>
							<p class="footer">
								<a href="<?php echo get_post_type_archive_link( 'conteudo' ).'?col='.$colunista->ID; ?>">SAIBA MAIS</a>
							</p>
						</div>
					</div>
				</div>
			<?php endif; ?>

			</div>
			<aside class="col-md-3 col-md-offset-1">

			<div class="share-box">
				<p>Compartilhar</p>
				<p class="textcenter">
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="share-link"><i class="fa fa-twitter"></i></a>
				</p>
			</div>

			<ul class="categorias">
				<?php
				$terms = get_terms( array( 'taxonomy' => 'category', 'exclude' => array(1) ) );

				foreach( $terms as $term ) :
				?>
					<li><a href="<?php echo get_term_link( $term, 'category' ); ?>"><span>&bull;</span><?php echo $term->name ?></a></li>
				<?php endforeach; ?>
			</ul>


				<?php

				$publicidades = get_publicidades( 293 );

				if( ! empty( $publicidades ) ) {
					array_rand( $publicidades, 1 );;

				?>

					<div class="publicidades">
						<a href="<?php echo $publicidades[0]['link'] ?>"><img alt="" src="<?php echo $publicidades[0]['imagem'] ?>"></a>
					</div>

				<?php
				}
				?>
			</aside>
		</div>
	</div>
</article>


<?php
$post_categories = wp_get_post_categories( get_the_ID() );

$args_conteudo_colunista = array(
	'post_type' => 'conteudo',
	'posts_per_page' => 2,
	'meta_key' => 'colunista',
	'meta_value' => $colunista->ID,
	'category__in' => $post_categories,
	'orderby' => 'rand',
	'date_query' => array(
		array(
			'column' => 'post_date_gmt',
			'after' => '1 month ago',
		),
		array(
			'column' => 'post_modified_gmt',
			'after' => '1 month ago',
		),
	)
);

$conteudo_colunista = new WP_Query( $args_conteudo_colunista );

/*echo '<pre>';
print_r( $conteudo_colunista );
echo '</pre>';*/
?>

<section class="listagem listagem-simples outros-conteudos">

		<div class="container">
		<div class="row">
		<div class="col-md-12">
			<h2 class="gradient-text">VEJA OUTROS CONTEÚDOS</h2>
		</div>

		<?php
		while( $conteudo_colunista->have_posts() ) : $conteudo_colunista->the_post(); ?>

			<div class="col-md-6 item hvr-shadow-radial">
			<?php
			if (has_post_thumbnail()) :
			?>
				<div class="image ">
							<div class="hover">
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="social facebook share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="social twitter share-link"><i class="fa fa-twitter"></i></a>
								<a href="<?php the_permalink(); ?>" class="search hvr-grow"><i class="fa fa-search"></i></a>
								<div class="after"><a href="<?php the_permalink(); ?>"></a></div>
							</div>
						<?php the_post_thumbnail( 'listagem-conteudo', array( 'class' => 'img-responsive' ) ); ?>
				</div>
			<?php endif; ?>
				<div class="content">
				<p class="header clearfix">
					<span class="fl"><?php the_date( 'd/M' ) ?></span>
							<span class="fr">

								<?php the_terms_without_uncategorized( get_the_ID(), array( 'taxonomy' => 'category' ) ); ?>

							</span>
				</p>
				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<p>
				<a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_content(), 20 ); ?></a>
				</p>
				<p class="textcenter">
				<a href="<?php the_permalink(); ?>" class="btn btn-default">
					Leia Mais
				</a>
				</p>
				</div>
			</div>

		<?php endwhile; ?>

		<p class="textcenter"><a class="btn btn-style-2">VEJA MAIS</a></p>

		</div>
	</div>
</section>

<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer() ?>