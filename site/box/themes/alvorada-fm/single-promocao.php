<?php

the_post();

if( isset( $_POST ) && ! empty( $_POST['resposta'] ) ) {
	$participantes_promocao = get_field( 'participantes_promocao', $post->ID );
	if( ! empty( $participantes_promocao ) ) {
		$participantes = json_decode( $participantes_promocao, true );
		if ( !is_array($participantes) ) {
			$participantes = array();
		}
	} else {
		$participantes = array();
	}

	$participantes[ get_current_user_id() ] = array( 'resposta' => $_POST['resposta'] );
	$votos = json_encode( $participantes );
	update_field( 'participantes_promocao', $votos, $post->ID );
	wp_redirect( get_permalink().'#box-promocao' );
}

get_header(); ?>

<div class="inner">
<section class="megabanner">
			<div class="carousel slide" id="megabanner">
				<div class="carousel-inner">
					<?php

					$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

					?>
					<div class="item active" style="background-image: url(<?php echo $thumbnail ?>); background-position: center <?php echo get_field( 'alinhamento_da_imagem' ) ?>;">
						<!-- <img alt="Carousel Bootstrap First" src=""> -->
						<div class="carousel-caption">
						<div class="container">
							<div>
							<h4 class="gradient-text">
								<?php the_title(); ?>
							</h4>
							<p>
								<a href="<?php the_permalink(); ?>"><?php echo get_field( 'resumo' ) ?></a>
							</p>
							<p class="data-content">
								<a href="<?php the_permalink(); ?>"><?php echo get_field( 'data_do_evento' ) ?></a>
							</p>
							<p class="local-content">
								<a style="font-weight:100" href="<?php the_permalink(); ?>"><?php echo get_field( 'local_do_evento' ) ?></a>
							</p>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
</section>
<div class="tag-inner"><div class="container pRelative"><a class="tag <?php echo join(' ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'slugs' ) ) ); ?>"><?php echo join(' | ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'names' ) ) ); ?></a></div></div>

<article class="the-content interna-promocoes">
	<div class="container">
		<div class="row">
			<div class="col-md-8 ">

			<div class="conteudo">

				<?php the_content(); ?>

			</div>

			</div>
			<aside class="col-md-3 col-md-offset-1">
			<!-- <h3><?php echo date( 'd F', get_field( 'data_final_promocao' ) ) ?></h3> -->
			<div class="share-box">
				<p>Compartilhar</p>
				<p class="textcenter">
						<a data-url="<?php the_permalink(); ?>" data-title="Eu já estou participando. Participe você também desta promoção: <?php the_title(); ?>" data-network="facebook" href="" class="social facebook share-link"><i class="fa fa-facebook"></i></a>
						<a data-url="<?php the_permalink(); ?>" data-title="Eu já estou participando. Participe você também desta promoção: <?php the_title(); ?>" data-network="twitter" href="" class="social twitter share-link"><i class="fa fa-twitter"></i></a>
				</p>
			</div>

			<div class="publicidades">
				<a href=""><img alt="" src="<?php echo IMG_URL ?>bose.jpg"></a>
			</div>

			</aside>
		</div>
	</div>
</article>

<?php
$postId = $post->ID;
$args_outras_promocoes = array(
	'post_type' 		=> 'promocao',
	'posts_per_page' 	=> 3,
	'meta_key'			=> 'status',
	'meta_value'		=> 'aberta',
	'post__not_in' => array( $postId )

);

$promocoes_relacionadas = new WP_Query( $args_outras_promocoes );

if( $promocoes_relacionadas->have_posts() ) :

?>
<section class="listagem listagem-promocoes outros-conteudos" style="margin-top:0;">

		<div class="container">
		<div class="row">
		<div class="col-md-12">
			<h2 class="gradient-text">VEJA OUTRAS PROMOÇÕES</h2>
		</div>


		<?php while( $promocoes_relacionadas->have_posts() ) : $promocoes_relacionadas->the_post();

						$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>

		<div class="col-md-4 item hvr-shadow-radial">
			<div class="image " style="background-image:url(<?php echo $thumbnail ?>)">
					<div class="hover">
	<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="social facebook share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="social twitter share-link"><i class="fa fa-twitter"></i></a>
						<a href="<?php the_permalink(); ?>" class="search hvr-grow"><i class="fa fa-search"></i></a>
						<div class="after"><a href="<?php the_permalink(); ?>"></a></div>
					</div>
					<!-- <img class="img-responsive" alt="Bootstrap Image Preview" src="assets/images/skank.jpg" /> -->
			</div>
			<div class="content">
			<a class="tag <?php echo join(' ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'slugs' ) ) ); ?>"><?php echo join(' | ', wp_get_post_terms( $post->ID, 'categoria-de-promocao', array( 'fields' => 'names' ) ) ); ?></a>
			<h3>
				<?php the_title( ); ?>
			</h3>
			<?php echo get_field( 'resumo', $post->ID ) ?>
				<div class="footer">
					<p>PARTICIPE ATÉ<br><b><?php echo date( 'd-m', strtotime( get_field( 'data_final_promocao' ) ) ) ?> - <?php echo sanitize_text_field( get_field( 'horario_final_promocao' ) ); ?></b></p>
					<p class="textcenter">
					<a href="<?php the_permalink(); ?>" class="btn btn-default">
						Participe
					</a>
					</p>
				</div>
			</div>
		</div>

		<?php endwhile; ?>

		<div class="clearfix">
		<p class="textcenter"><a class="btn btn-style-2">VEJA MAIS</a></p>
		</div>

		</div>
	</div>
</section>

<?php endif; ?>

<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer();
