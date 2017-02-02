<?php get_header(); the_post(); ?>



<div class="inner">
<?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>
<?php if (empty($thumbnail)):?>
<section class="header-simples">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<h2 class="gradient-text"><?php the_title(); ?></h2>
				</div>
				<div class="col-md-5">
					<a href="" class="fr social share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
					<a href="" class="fr social share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
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


			<div class="conteudo">

				<?php the_content(); ?>


			</div>

			</div>
			<aside class="col-md-3 col-md-offset-1">

			<div class="share-box">
				<p>Compartilhar</p>
				<p class="textcenter">
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="share-link"><i class="fa fa-twitter"></i></a>
				</p>
			</div>



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



<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer() ?>