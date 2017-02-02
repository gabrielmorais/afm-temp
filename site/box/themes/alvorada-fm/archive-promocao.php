<?php get_header(); ?>

<div class="inner">


<?php

$args_destaques = array(
	'posts_per_page' => -1,
	'post_type' => 'promocao',
	'tax_query' => array(
		array(
			'taxonomy' => 'categoria-de-promocao',
			'field' => 'slug',
			'terms' => array( 'ouvinte-vip', 'promocao' )
		)
	),
	'meta_key' => 'status',
	'meta_value' => 'aberta',
	'orderby' => 'rand'
);

$promocoes_destaque = new WP_Query( $args_destaques );

?>


<?php
if( ! $promocoes_destaque->have_posts() ) :

?>

<!-- Variação sem megabanner -->
<section class="header-simples">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<h2 class="gradient-text">Promoções</h2>
				</div>
				<div class="col-md-5">
					<a href="" class="fr social share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
					<a href="" class="fr social share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
				</div>
			</div>
		</div>
</section>

<?php else : ?>


<section class="megabanner promocoes">

			<div class="carousel slide megabanner-slider" id="megabanner" >

				<div class="carousel-inner">

					<?php
					$count_destaques = 0;

					while( $promocoes_destaque->have_posts() ) : $promocoes_destaque->the_post();

						$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

					?>

					<div class="item <?php echo ( $count_destaques == 0 ) ? 'active' : null ?>" >
						<div class="carousel-caption" style="background-image: url(<?php echo $thumbnail ?>); background-position: center <?php echo get_field( 'alinhamento_da_imagem' ) ?>;">
							<div class="container">
								<div>
									<h4 class="gradient-text">
										<?php echo the_title(); ?>
									</h4>
								</div>
							</div>
						</div>
						<div class="info-promocao">
							<section class="chamada">
								<div class="container">
									<a class="tag <?php echo join(' ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'slugs' ) ) ); ?>"><?php echo join(' | ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'names' ) ) ); ?></a>
									<div class="row ">
										<div class="col-md-4">
											<h3>
												<?php echo the_title(); ?>
											</h3>
											<?php echo get_field( 'resumo', $post->ID ) ?>
										</div>
										<div class="col-md-4 textcenter participe-ate">
											<p>PARTICIPE ATÉ<br><b><?php echo date( 'd-m', strtotime( get_field( 'data_final_promocao' ) ) ) ?> - <?php echo sanitize_text_field( get_field( 'horario_final_promocao' ) ); ?></b></p>
										</div>
										<div class="col-md-2">
											<a href="<?php the_permalink(); ?>" class="btn btn-default btn-style-2">
												PARTICIPE
											</a>
										</div>
										<div class="col-md-2 socials">
											<a href="" class="fr twitter share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
											<a href="" class="fr share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>

					<?php $count_destaques++; endwhile; ?>


				</div>

				<?php

				if( $promocoes_destaque->have_posts() && (count($promocoes_destaque->posts)>1) ) :
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

<div class="container pRelative">
	<p class="tip-como-participar"><a href="">Como participar das promoções <img src="<?php echo IMG_URL ?>tip.png" data-toggle="tooltip" data-placement="bottom" title="<?php echo get_field( 'informacao_como_participar', 'option' ) ?>"></a>
</div>
</section>

<?php endif; ?>


<?php


if( have_posts() ) :


?>

<section class="listagem listagem-promocoes">

		<div class="container">
		<div class="row">

		<?php
		global $propaganda;
		$propaganda = true.
		$count_promocoes = 1;

		$publicidades = get_publicidades( 267 );

		if( ! empty( $publicidades ) ) {
			array_rand( $publicidades, 1 );
		}

/*		echo '<pre>';
		var_dump( $publicidades );
		echo '</pre>';*/


		while( have_posts() ) : the_post();

			$data_encerramento = get_field( 'data_final_promocao' );

			$horario_final_promocao = get_field( 'horario_final_promocao' );

			if( strtotime( $data_encerramento . ' ' . $horario_final_promocao . ':00' ) < strtotime( current_time( 'mysql' ) ) ) {
				$encerrado = true;
				$status_promocao = get_field( 'status' );
				if( $status_promocao == 'aberta' ) {
					update_field( 'status', 'encerrada' );
				}
			} else {
				$encerrado = false;
			}


			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'destaque-listagem' );

		?>
		<div class="col-md-4 item">
				<div class="hvr-shadow-radial">
			<div class="image " style="background-image:url(<?php echo $thumbnail[0]  ?>)">
					<div class="hover">
						<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="social facebook share-link"><i class="fa fa-facebook"></i></a>
						<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="social twitter share-link"><i class="fa fa-twitter"></i></a>
						<a href="<?php the_permalink(); ?>" class="search hvr-grow"><i class="fa fa-search"></i></a>
						<div class="after"><a href="<?php the_permalink(); ?>"></a></div>
					</div>
					<!-- <img class="img-responsive" alt="Bootstrap Image Preview" src="assets/images/skank.jpg" /> -->
			</div>
			<div class="content">

			<?php
			if( $encerrado ) :

			?>
				<a class="tag encerrado">Promoção encerrada</a>
			<?php else : ?>
				<a class="tag <?php echo join(' ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'slugs' ) ) ); ?>"><?php echo join(' | ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'names' ) ) ); ?></a>

			<?php endif; ?>
			<h3>
				<?php the_title(); ?>
			</h3>
			<?php echo get_field( 'resumo' ); ?>
				<div class="footer">
					<p class="participe-ate"><?php echo ( ! $encerrado ) ? 'PARTICIPE ATÉ' : 'PROMOÇÃO ENCERRADA EM'; ?><br><b><?php echo date( 'd-m', strtotime( $data_encerramento ) ) ?> - <?php echo sanitize_text_field( $horario_final_promocao ); ?></b></p>
					<p class="textcenter">
					<?php
					if( ! $encerrado ) :
					?>
						<a href="<?php the_permalink(); ?>" class="btn btn-default">
							Participe
						</a>

					<?php else : ?>

						<a href="<?php the_permalink(); ?>" class="btn btn-default">
							Confira o Resultado
						</a>

					<?php endif; ?>
					</p>
				</div>
			</div>
			</div>
		</div>

		<?php

		if( $count_promocoes == 5 && count( $posts >= 5 ) ) :
			$propaganda = false;
			if( ! empty( $publicidades ) ) :
		?>
			<div class="col-md-4 item propaganda primeira-verificacao">
				<a href="<?php echo $publicidades[0]['link'] ?>">
					<img src="<?php echo $publicidades[0]['imagem'] ?>">
				</a>
			</div>
		<?php endif; endif; ?>

		<?php $count_promocoes++; endwhile; ?>


		<?php

		if( $propaganda ) :
			if( ! empty( $publicidades ) ) :
		?>
			<div class="col-md-4 item propaganda segunda-verificacao">
				<a href="<?php echo $publicidades[0]['link'] ?>">
					<img src="<?php echo $publicidades[0]['imagem'] ?>">
				</a>
			</div>
		<?php endif; endif;  ?>

		</div>
	</div>
</section>

<?php else : ?>

	<p>Nenhuma Promoção para ser mostrada.</p>

<?php endif; ?>

<?php get_template_part( 'pagination', 'default' ); ?>

<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer();
