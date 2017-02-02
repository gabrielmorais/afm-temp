<?php get_header();

?>

<div class="inner">
<?php


$count_banner1 = 1;
foreach( $posts as $post ) {
	if( $count_banner1 > 3 ) {
		continue;
	} else {
		$banners[] = $post;
	}
}

if( ! empty( $banners ) ) : ?>

<?php
shuffle($banners);
?>


<section class="megabanner promocoes mega-eventos">

			<div class="carousel slide megabanner-slider" id="megabanner" >

				<div class="carousel-inner">

					<?php
					$count_banner = 1;

					foreach( $banners as $banner ) :


						$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $banner->ID ) );


						$datas_banner = get_field( 'data_destaque', $banner->ID );


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

						<div class="item <?php echo ( $count_banner == 1 ) ? 'active' : '' ?>" >
							<!-- <img alt="Carousel Bootstrap First" src=""> -->
							<div class="carousel-caption" style="background-image: url(<?php echo $thumbnail ?>); background-position: center <?php echo get_field( 'alinhamento_da_imagem' ) ?>;">

							<div class="container">
								<div>
								<h4 class="gradient-text">
									EVENTOS
								</h4>
								</div>

							</div>

							</div>
							<div class="info-promocao full">
						<section class="chamada">
							<div class="container">
								<div class="row ">
									<div class="col-md-8">
										<h3 class="full">
											<?php echo $banner->post_title ?>

										</h3>
										<p>
											<b><?php echo get_field( 'data_resumida'); ?></b> <br>
											<?php echo wp_trim_words( $banner->post_content, 15 ); ?>
										</p>
									</div>

									<div class="col-md-2">
										<a href="<?php echo get_permalink( $banner->ID ); ?>" class="btn btn-default btn-style-2">
											SAIBA MAIS
										</a>
									</div>
										<div class="col-md-2 socials">
											<a href="" class="fr twitter share-link" data-url="<?php echo get_permalink( $banner->ID ); ?>" data-title="<?php echo $banner->post_title ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
											<a href="" class="fr share-link" data-url="<?php echo get_permalink( $banner->ID ); ?>" data-title="<?php echo $banner->post_title ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
										</div>
								</div>
								</div>
							</section>
							</div>
						</div>

					<?php $count_banner++; endforeach; ?>

				</div>
				<?php if( count($banners)>1)  : ?>
				<div class="container pRelative">
					<ol class="carousel-indicators">
						<li class="active" data-slide-to="0" data-target="#megabanner">
						</li>
						<?php for( $i = 1; $i < count( $banners ); $i++ ) : ?>
							<li data-slide-to="<?php echo $i ?>" data-target="#megabanner">
							</li>
						<?php endfor; ?>
					</ol>
				</div>
				<?php endif; ?>
<!--
				 <a class="left carousel-control" href="#megabanner" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left"></span></a>
				<a class="right carousel-control" href="#megabanner" data-slide="next">
				<span class="glyphicon glyphicon-menu-right"></span></a> -->
			</div>

<!-- <div class="container pRelative">
	<p class="tip-como-participar"><a href="" data-toggle="tooltip" data-placement="top" title="Lorem ipsum dolor sit amet lorem"><img src="assets/images/tip.png"></a></p>
</div> -->
</section>

<?php endif; ?>

<section class="filtros filtro-eventos">
<div class="container">
	<div class="row">
<!-- 		<div class="col-sm-6 col-md-4">
			<select class="selectBoxIt">
				<option>Escolha uma data</option>
				<option>Opção 2</option>
			</select>
		</div> -->

		<div class="col-sm-6 col-md-4">
			<select class="selectBoxIt filtro-evento">
				<option>Escolha uma Categoria</option>
				<?php

				$terms = get_terms( 'categoria', array(
				    'hide_empty' => true,
		    		'exclude' => array(1),
				) );
				foreach( $terms as $term ) : ?>
					<option value="<?php echo $term->term_id ?>"><?php echo $term->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="row row-termo-evento hide">&nbsp;</div>
		<div class="col-sm-6 col-md-8 pRelative termo-evento">
			<form action="<?php echo get_post_type_archive_link( 'evento' ); ?>" method="get">
				<input type="text" name="s" class="termo" placeholder="BUSCA POR EVENTO">
				<div class="submit">
					<i class="fa fa-search"></i>
					<input type="submit" value="" />
				</div>
			</form>
		</div>

		<?php

		if( isset( $_GET['filtros'] ) && ! empty( $_GET['filtros'] ) ) {

			$filtros = $_GET['filtros'];
			$filtros = explode( ',', $filtros );
			$filtros = array_unique ( $filtros );

			echo '<input type="hidden" class="tax_conteudos" value="' . implode( ',', $filtros ) . '" />';
		}

		?>

		<input type="hidden" class="url-conteudo" value="<?php echo get_post_type_archive_link( 'evento' ); ?>">

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
</div>
</section>

<?php

if( have_posts() ) :

$current_post = 1;

$publicidades = get_publicidades( 267 );

if( ! empty( $publicidades ) ) {
	array_rand( $publicidades, 1 );
}

?>

<section class="listagem listagem-eventos">

		<div class="container">
		<div class="row">

		<?php



		while( have_posts() ) : the_post();

			$datas = get_field( 'datas' );


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

			<div class="col-md-4 item ">
			<div class="hvr-shadow-radial">
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
					<?php the_title() ?>
				</h3>
				<p>
				<?php echo wp_trim_words( $post->post_content, 15 ); ?>
				</p>
					<div class="footer">
						<p class="participe-ate"><?php echo the_field('data_resumida');  ?></p>
						<p class="textcenter">
						<a href="<?php the_permalink(); ?>" class="btn btn-default">
							Leia mais
						</a>
						</p>
					</div>
				</div>
			</div>
			</div>

			<?php

			if( count($wp_query->posts) > 5 && $current_post == 5 ):
				if( ! empty( $publicidades ) ) :
			?>
				<div class="col-md-4 item propaganda">
					<a href="<?php echo $publicidades[0]['link'] ?>">
						<img src="<?php echo $publicidades[0]['imagem'] ?>">
					</a>
				</div>
			<?php
				endif;
			endif;
			?>

		<?php $current_post++; endwhile; ?>

		<?php
		if( count($wp_query->posts) < 5 ) :
			if( ! empty( $publicidades ) ) :
		?>
			<div class="col-md-4 item propaganda">
				<a href="<?php echo $publicidades[0]['link'] ?>">
					<img src="<?php echo $publicidades[0]['imagem'] ?>">
				</a>
			</div>
		<?php endif; endif; ?>

		</div>
	</div>
</section>
<?php else : ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<p>Nenhum evento programado. :/</p>
			</div>
		</div>
	</div>
<?php endif; ?>


<?php get_template_part( 'pagination', 'default' ); ?>

<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer() ?>