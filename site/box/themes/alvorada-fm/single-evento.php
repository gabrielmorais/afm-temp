<?php get_header(); the_post(); ?>
<div class="inner">
			<?php

				$datas_banner = get_field( 'datas', $banner->ID );

				$str_data = null;

				if( count( $datas_banner ) == 1 ) {
					$str_data = strftime( '%d de %B', strtotime( $datas_banner[0]['data'] ) );
				} else if( count( $datas_banner ) == 2 ) {
					$ultima_data = $datas_banner[ count( $datas_banner ) - 1 ]['data'];
					$str_data = 'De '. strftime( '%d de %B', strtotime( $datas_banner[0]['data'] ) ) . ' a '. strftime( '%d de %B', strtotime( $ultima_data ) );
				} else if( count( $datas_banner ) > 2 ) {
					foreach( $datas_banner as $data ) {
						$str_data .= '<br>' . strftime( '%d de %B', strtotime( $data['data'] ) );
					}
				}
			?>
<section class="megabanner">
			<div class="carousel slide" id="megabanner">

				<div class="carousel-inner">
					<?php $thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>
					<div class="item active" style="background-image: url(<?php echo $thumbnail ?>); background-position: center <?php echo get_field( 'alinhamento_da_imagem' ) ?>;">
						<!-- <img alt="Carousel Bootstrap First" src=""> -->
						<div class="carousel-caption">
						<div class="container">
							<div class="evento-content">
							<h4 class="gradient-text">
								<?php the_title() ?>
							</h4>

							<?php
								$data_resumida = get_field('data_resumida');
								if ( isset($data_resumida) ){
							 ?>
							<p class="data-banner"><?php echo $data_resumida; ?></p>
							<?php
							}
							?>
							</div>

						</div>

						</div>
					</div>
				</div>
			</div>


</section>


<article class="the-content interna-eventos">
	<div class="container">
		<div class="row">
			<div class="col-md-8 ">

			<div class="conteudo">

				<?php the_content(); ?>

				<p class="textcenter">
				<?php $comprar_ingresso = get_field( 'comprar_ingresso' ); ?>
				<?php $promocao = get_field( 'promocao' ); ?>

				<?php if( ! empty( $comprar_ingresso ) ) : ?>
					<a href="<?php echo $comprar_ingresso; ?>" target="_blank" class="btn btn-style-2">Comprar ingresso</a>
				<?php endif; ?>

				<?php if( ! empty( $promocao ) ) : ?>
					<a href="<?php the_permalink( $promocao->ID ); ?>" class="btn btn-style-2">Participe da promoção</a>
				<?php endif; ?>
				</p>

			</div>

			</div>
			<aside class="col-md-3 col-md-offset-1">



			<h3><?php echo $data_resumida; ?></h3>
			<div class="share-box">
				<p>Compartilhar</p>
				<p class="textcenter">
				<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="share-link"><i class="fa fa-facebook"></i></a>
				<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="share-link"><i class="fa fa-twitter"></i></a>
				</p>
			</div>


			</aside>
		</div>
	</div>
</article>


<?php
$post_id = get_the_ID();
$categorias = wp_get_post_terms( get_the_ID(), 'categoria', $args );


foreach( $categorias as $categoria )
	$new_categorias[] = $categoria->term_id;


$categorias = $new_categorias;


$args_outros = array(
	'post_type' => 'evento',
	'post__not_in' => array($post_id),
	'posts_per_page' => 3,
	'tax_query' =>
		array(
			array(
				'taxonomy' => 'categoria',
				'terms' => $categorias
			)
		)
);

$outros_eventos = new WP_Query( $args_outros );

if( $outros_eventos->have_posts() ) :

?>

<section class="listagem listagem-eventos outros-conteudos">

		<div class="container">
		<div class="row">
		<div class="col-md-12">
			<h2 class="gradient-text">VEJA OUTROS EVENTOS</h2>
		</div>

		<?php

		while( $outros_eventos->have_posts() ) : $outros_eventos->the_post();

			$datas = get_field( 'datas', get_the_ID() );

			$str_data = null;

			if( count( $datas ) == 1 ) {
				$str_data = strftime( '%d de %B', strtotime( $datas[0]['data'] ) );
			} else if( count( $datas ) == 2 ) {
				$ultima_data = $datas[ count( $datas ) - 1 ]['data'];
				$str_data = 'De '. strftime( '%d de %B', strtotime( $datas[0]['data'] ) ) . ' a '. strftime( '%d de %B', strtotime( $ultima_data ) );
			} else if( count( $datas ) > 2 ) {
				$count_nene = 1;
				foreach( $datas as $data ) {
					$init_string = ( $count_nene != 1 ) ? ' | ' : '';
					$str_data .=  $init_string . strftime( '%d de %B', strtotime( $data['data'] ) );
					$count_nene++;
				}
			}
		?>
			<div class="col-md-4 item hvr-shadow-radial">
				<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'listagem-conteudo' ); ?>
				<div class="image " style="background-image:url(<?php echo $thumbnail[0] ?>)">
							<div class="hover">
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="social facebook share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="social twitter share-link"><i class="fa fa-twitter"></i></a>
								<a href="<?php the_permalink(); ?>" class="search hvr-grow"><i class="fa fa-search"></i></a>
								<div class="after"><a href="<?php the_permalink(); ?>"></a></div>
							</div>
						<!-- <img class="img-responsive" alt="Bootstrap Image Preview" src="assets/images/skank.jpg" /> -->
				</div>
				<div class="content">
					<p class="header clearfix textleft">
						<?php the_terms_without_uncategorized( get_the_ID(), array( 'taxonomy' => 'categoria' ) ); ?>
					</p>
				<h3>
					<?php the_title(); ?>
				</h3>
				<p>
				<?php echo wp_trim_words( get_the_content(), 15 ); ?>
				</p>
					<div class="footer">
						<p class="participe-ate"><a href="" data-toggle="tooltip" data-placement="top" title="<?php echo $str_data; ?>">DATAS</a></p>
						<p class="textcenter">
						<a href="<?php the_permalink(); ?>" class="btn btn-default">
							Leia mais
						</a>
						</p>
					</div>
				</div>
			</div>
		<?php endwhile; ?>

		<p class="textcenter"><a class="btn btn-style-2" href="<?php echo get_post_type_archive_link( 'evento' ); ?>">VEJA MAIS</a></p>

		</div>
	</div>
</section>

<?php endif; //have outros ?>


<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer() ?>