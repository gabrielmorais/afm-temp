<?php

$count_programacao = 1;

$publicidades = get_publicidades( 267 );

if( ! empty( $publicidades ) ) {
	array_rand( $publicidades, 1 );
}
?>

		<div class="container">
		<div class="row">


		<?php

		while( have_posts() ) : the_post();

			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'destaque-listagem' );
		?>
		<div class="col-md-4 item ">
		<div class="hvr-shadow-radial">

			<div class="image " style="background-image:url(<?php echo $thumbnail[0] ?>)">
				<div class="hover">
					<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="social facebook share-link"><i class="fa fa-facebook"></i></a>
					<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="social twitter share-link"><i class="fa fa-twitter"></i></a>
					<a href="<?php the_permalink(); ?>" class="search hvr-grow link-refresh"><i class="fa fa-search"></i></a>
					<div class="after"><a href="<?php the_permalink(); ?>"></a></div>
				</div>
			</div>
			<div class="content">
			<h3>
				<a href="<?php the_permalink(); ?>" class="link-refresh"><?php the_title(); ?></a>
			</h3>
			<?php
			$apresentador = get_field( 'apresentador' );
			//var_dump($apresentador);
			if( ! empty( $apresentador ) ) :

			?>
				<p>por <?php echo $apresentador->post_title; ?></p>
			<?php endif; ?>
			<p>
			<a href="<?php the_permalink(); ?>" class="link-refresh"><?php the_field( 'breve_descritivo' ) ?></a>
			</p>
				<div class="footer">
					<p class="participe-ate"><b><?php the_field( 'horario_do_programa' ) ?></b>
					</p>
					<p class="textcenter">
					<a href="<?php the_permalink(); ?>" class="link-refresh btn btn-default">
						Saiba mais
					</a>
					</p>
				</div>
			</div>
		</div>
		</div>


		<?php
		if( $count_programacao == 5 && count( $posts >= 5 ) ) :
			if( ! empty( $publicidades ) ) :
		?>
			<div class="col-md-4 item propaganda">
				<a href="<?php echo $publicidades[0]['link'] ?>" target="_blank">
					<img src="<?php echo $publicidades[0]['imagem'] ?>">
				</a>
			</div>
		<?php endif; endif; ?>

		<?php endwhile; $count_programacao++; ?>


		<?php
		if( count( $posts < 5 ) ) :
			if( ! empty( $publicidades ) ) :
		?>
			<div class="col-md-4 item propaganda">
				<a href="<?php echo $publicidades[0]['link'] ?>" target="_blank">
					<img src="<?php echo $publicidades[0]['imagem'] ?>">
				</a>
			</div>
		<?php endif; endif; ?>

		</div>
	</div>
