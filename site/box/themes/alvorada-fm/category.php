<?php get_header(); ?>


<div class="inner">

<?php

$args_destaques = array(
	'post_type' => 'conteudo',
	'meta_key' => 'destaque',
	'meta_value' => 1,
	'post_per_page' => 5
);

$destaques = new WP_Query( $args_destaques );

/*echo '<pre>';
print_r( $destaques );
echo '</pre>';*/

if( $destaques->have_posts() ) :

?>

<section class="megabanner promocoes">

			<div class="carousel slide megabanner-slider" id="megabanner" >

				<div class="carousel-inner">

					<?php
					$count_destaques = 0;

					while( $destaques->have_posts() ) : $destaques->the_post();

						$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

					?>

					<div class="item <?php echo ( $count_destaques == 0 ) ? 'active' : null ?>" >
						<div class="carousel-caption" style="background-image: url(<?php echo $thumbnail ?>)">
							<div class="container">
								<div>
									<h4 class="gradient-text">
										Conteúdos
									</h4>
								</div>
							</div>
						</div>
						<div class="info-promocao">
							<section class="chamada">
								<div class="container">
									<div class="row ">
										<div class="col-md-8">
											<h3>
												<?php the_title(); ?>
											</h3>
											<p>
												<?php echo wp_trim_words( get_the_content(), 20 ); ?>
											</p>
										</div>
										<div class="col-xs-6 col-md-2">

											<a href="<?php the_permalink(); ?>" class="btn btn-default btn-style-2">
												LEIA MAIS
											</a>
										</div>
										<div class="col-xs-6 col-md-2 socials">
											<a href="" class="fr twitter"><i class="fa fa-twitter"></i></a>
											<a href="" class="fr"><i class="fa fa-facebook"></i></a>
										</div>
									</div>
									</div>
								</section>

						</div>
					</div>

					<?php $count_destaques++; endwhile; ?>


				</div>

				<?php

				if( $destaques->have_posts() ) :
				?>

					<div class="container pRelative">
						<ol class="carousel-indicators">
							<li class="active" data-slide-to="0" data-target="#megabanner"></li>
							<?php

							for ($i=1; $i < $count_destaques; $i++) {
							?>
								<li data-slide-to="<?php echo $i; ?>" data-target="#megabanner"></li>
							<?php
							}
							?>
						</ol>
					</div>
				<?php endif; ?>
<!--
				 <a class="left carousel-control" href="#megabanner" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left"></span></a>
				<a class="right carousel-control" href="#megabanner" data-slide="next">
				<span class="glyphicon glyphicon-menu-right"></span></a> -->
			</div>

</section>
<?php endif; ?>



<section class="filtros scrolling">
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4">

		<?php
		$terms = get_terms( 'category', array(
		    'hide_empty' => true,
		    'exclude' => array(1),
		) );
		?>

		<select class="selectBoxIt filtro-conteudo">
			<option value="0">Escolha uma categoria</option>
			<?php foreach( $terms as $term ) : ?>
				<option <?php echo (get_queried_object()->term_id == $term->term_id ) ? 'selected' : '' ?> value="<?php echo $term->term_id ?>"><?php echo $term->name ?></option>
			<?php endforeach; ?>
		</select>

		<?php

		if( isset( $_GET['filtros'] ) && ! empty( $_GET['filtros'] ) ) {

			$filtros = $_GET['filtros'];
			$filtros = explode( ',', $filtros );
			$filtros = array_unique ( $filtros );

			echo '<input type="hidden" class="tax_conteudos" value="' . implode( ',', $filtros ) . '" />';
		}

		?>

		<input type="hidden" class="url-conteudo" value="<?php echo get_post_type_archive_link( 'conteudo' ); ?>">
		</div>
<!-- 		<div class="col-sm-6 col-md-8 pRelative">
				<input type="text" name="" class="termo" placeholder="BUSCA POR EVENTO">
				<div class="submit">
					<i class="fa fa-search"></i>
					<input type="submit" value="" />
				</div>
		</div> -->
		</div>
		<?php if( ! empty( $filtros ) ) : ?>
			<div class="row">
				<div class="col-md-12 tags clearfix">
					<?php


					foreach( $filtros as $filtro ) :
						$termo = get_term_by( 'id', $filtro, 'category' );
					?>
						<span><?php echo $termo->name ?> <a href="" data-id="<?php echo $filtro ?>" class="hvr-float remove-filtro-conteudo"><i class="fa fa-close"></i></a></span>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

</div>
</section>

<?php
if( have_posts() ) :

?>

<section class="listagem listagem-simples">

		<div class="container">
		<div class="row" >
		<div class="grid" data-masonry='{ "itemSelector": ".grid-item" }'>

			<?php while( have_posts() ) : the_post(); ?>

				<div class="grid-item">
					<div class="item">
					<div class="hvr-shadow-radial">
						<?php
						if( has_post_thumbnail(  ) ) :

						?>
						<div class="image ">
								<div class="hover">
									<a href="" class="social facebook"><i class="fa fa-facebook"></i></a>
									<a href="" class="social twitter"><i class="fa fa-twitter"></i></a>
									<a class="search hvr-grow" href="<?php the_permalink(); ?>"><i class="fa fa-search"></i></a>
									<div class="after"><a href="<?php the_permalink(); ?>"></a></div>
								</div>
								<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'listagem-conteudo' ); ?>
								<img class="img-responsive" alt="" src="<?php echo $thumbnail[0] ?>" />
						</div>
					<?php endif; ?>
						<div class="content">
						<p class="header clearfix">
							<span class="fl"><?php the_field( 'data' ) ?></span>
							<span class="fr">

								<?php the_terms_without_uncategorized( get_the_ID(), array( 'taxonomy' => 'category' ) ); ?>

							</span>
						</p>
						<h3>
							<a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
						</h3>
						<p>
						<a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( $post->post_content, 20 ); ?></a>
						</p>
						<p class="textcenter">
						<a href="<?php the_permalink(); ?>" class="btn btn-default">
							Leia Mais
						</a>
						</p>
						</div>
					</div>
					</div>
				</div>

			<?php endwhile; ?>



		</div>
		</div>
	</div>
</section>

<?php endif; ?>


<?php get_template_part( 'pagination', 'default' ); ?>

<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer();
