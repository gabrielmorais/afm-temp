<?php get_header(); ?>

<?php

$args_relampago = array(
	'post_type' 	=> 'promocao',
	'tax_query' 	=> array(
		array(
			'taxonomy' 	=> 'categoria-de-promocao',
			'field' 	=> 'slug',
			'terms'		=> 'promocao-relampago'
		)
	),
	'meta_key' 			=> 'destaque',
	'meta_query'		=> array(
		'AND',
		array(
			'key' => 'destaque',
			'value' => 1,
			'compare' => '='
		),
		array(
			'key' => 'status',
			'value' => 'aberta',
			'compare' => '='
		)
	),
	'posts_per_page' 	=> 5,
    'date_query'    => array(
        array(
        	'year' 	=> date('Y'),
        	'month'	=> date('m'),
        	'day'	=> date('d')
        )
    )
);

$promocoes_relampago = new WP_Query( $args_relampago );

/*echo '<pre>';
print_r( $promocoes_relampago );
echo '</pre>';*/

if( $promocoes_relampago->have_posts() ) :

?>

<section class="banner-promocoes">
	<div class="container pRelative">
			<div class="carousel slide slide-banner-promocoes hvr-float-shadow" id="banner-promocoes" ><!-- data-ride="carousel" -->
				<div class="carousel-inner">
					<?php
					$count_relampago = 1;
					while( $promocoes_relampago->have_posts() ) :
						$promocoes_relampago->the_post();
						$thumb_relampago = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'destaque-listagem' );
					?>
						<div class="item <?php echo ( $count_relampago == 1 ) ? 'active' : '' ?>">
							<div class="image pRelative">
							<a href="<?php the_permalink(); ?>"><img alt="Carousel Bootstrap First" src="<?php echo $thumb_relampago[0] ?>"></a>
								<p><a class="tag" href="<?php the_permalink(); ?>">PROMOÇÃO RELÂMPAGO</a></p>
							</div>
							<div class="carousel-caption">
								<h4>
									<a href="<?php the_permalink(); ?>" class="link-refresh"><?php the_title(); ?></a>
								</h4>
								<p>
									<a href="<?php the_permalink(); ?>" class="link-refresh">
									<?php echo wp_trim_words( get_field( 'resumo' ), 17 ); ?></a>
								</p>
								<p class="orange data"><?php echo sanitize_text_field( the_field( 'data_do_evento' ) ); ?> <br> <span class="uppercase"><b><?php echo sanitize_text_field( the_field( 'local_do_evento' ) ); ?></b></span></p>

								<p class="textcenter share-promo promocao-relampago-home">
									<a href="<?php the_permalink(); ?>" class="btn btn-default link-refresh">Participe</a>
									<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="share-link"><i class="fa fa-twitter"></i></a>
									<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="share-link"><i class="fa fa-facebook"></i></a>
								</p>

							</div>
						</div>
					<?php $count_relampago++; endwhile; ?>
				</div>

				<?php if( $promocoes_relampago->found_posts > 1 ) : ?>

					<a class="left carousel-control" href="#banner-promocoes" data-slide="prev">
						<span class="glyphicon glyphicon-menu-left"></span>
					<!-- 	<span class="glyphicon glyphicon-menu-left"></span> -->
					</a>

					<a class="right carousel-control" href="#banner-promocoes" data-slide="next">

						<span class="glyphicon glyphicon-menu-right"></span>
					</a>

				<?php endif; ?>

			</div>
	</div>
</section>

<?php endif; ?>

<?php

$promocoes_banner = get_field( 'promocoes', 'option' );
shuffle($promocoes_banner );
if( ! empty( $promocoes_banner ) ) :

?>

<section class="megabanner"
data-reorder="true"
data-reorder-target-id="banner-promocoes"
data-reorder-target=".banner-promocoes"
data-reorder-dir="down">
			<div class="carousel slide" id="megabanner" data-ride="carousel">

				<div class="carousel-inner">

					<?php
					$count_banner = 1;
					foreach( $promocoes_banner as $promocao ) :

					?>

					<div class="item <?php echo ( $count_banner == 1 ) ? 'active' : null; ?>" style="background-image: url(<?php echo esc_url( $promocao['imagem'] ) ?>)">

						<button onclick=" window.open('<?php echo esc_url( $promocao['link'] ) ?>','_blank');">

						<div class="carousel-caption">
							<div class="container">
								<div>

									<?php if( ! empty( $promocao['categoria'][0]->name ) ) : ?>
									<a class="tag" href="javascript: void(0)"><?php echo sanitize_text_field( $promocao['categoria'][0]->name ); ?></a>
									<?php endif; ?>

									<?php if( ! empty( $promocao['titulo'] ) ) : ?>
									<h4>
										<a href="javascript: void(0)" class="gradient-text"><?php echo sanitize_text_field( $promocao['titulo'] ); ?></a>
									</h4>
									<?php endif; ?>

									<?php if( ! empty( $promocao['descricao'] ) ) : ?>
									<p>
										<a href="javascript: void(0)"><?php echo sanitize_text_field( $promocao['descricao'] ); ?></a>
									</p>
									<?php endif; ?>

									<?php if( ! empty( $promocao['data'] ) ) : ?>
										<a href="javascript: void(0)"><p class="data uppercase"><?php echo sanitize_text_field( $promocao['data'] ); ?></p></a>
									<?php endif; ?>

									<?php if( ! empty( $promocao['local'] ) ) : ?>
										<a href="javascript: void(0)"><p class="local uppercase"><?php echo sanitize_text_field( $promocao['local'] ); ?></p></a>
									<?php endif; ?>

								</div>

							</div>

						</div>
						</button>


					</div>

					<?php $count_banner++; endforeach; ?>

				</div>
				<div class="container pRelative">
				<?php if (count( $promocoes_banner ) > 1) : ?>
				<ol class="carousel-indicators">


					<li class="active" data-slide-to="0" data-target="#megabanner"></li>
					<?php

					for( $i = 1; $i < count( $promocoes_banner ); $i++ ) :
					?>
						<li data-slide-to="<?php echo $i ?>" data-target="#megabanner"></li>
					<?php endfor; ?>
				</ol>
			<?php endif; ?>
				</div>

				<?php if( count( $promocoes_banner ) > 1 ) : ?>
					 <a class="left carousel-control home-banner-control" href="#megabanner" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span></a>
					<a class="right carousel-control home-banner-control" href="#megabanner" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span></a>
				<?php endif; ?>

			</div>


</section>

<?php endif; ?>
<?php

$publicidade_home = get_publicidades( 728 );

if( ! empty( $publicidade_home ) ) {

    array_rand( $publicidade_home, 1 );

?>

    <section class="publicidade">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a class="hvr-shadow-radial" href="<?php echo $publicidade_home[0]['link'] ?>" class="hvr-shadow-radial"><img alt="" src="<?php echo $publicidade_home[0]['imagem'] ?>" /></a>
                </div>
            </div>
        </div>
    </section>

<?php

}

?>


<section class="previsao-do-tempo">
	<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>
				Clima em BH <span id="icon-tempo" class="chuva"></span>  max <span class="max-tempo"></span>°  min <span class="min-tempo"></span>° <img class="fr" src="<?php echo IMG_URL ?>tempo-clima-pucminas.png">
			</h3>
		</div>
	</div>
	</div>
</section>


<?php

$terms_home = get_field( 'terms_home', 'option' );

$args_noticias_home = array(
	'post_type' => 'conteudo',
	'posts_per_page' => 4,
	'orderby'=> 'rand',
	'tax_query' => array(
		array(
			'taxonomy' 	=> 'category',
			'terms' 	=> $terms_home
		)
	),
	'meta_query' => array(
		array(
			'key' => 'destaque',
			'value' => 1
		)
	)
);

$conteudo_musical = get_field( 'conteudo_musical', 'option' );

$args_musicais_home = array(
	'post_type' => 'conteudo',
	'posts_per_page' => 3,
	'tax_query' => array(
		array(
			'taxonomy' 	=> 'category',
			'terms' 	=> $conteudo_musical
		)
	),
	'meta_query' => array(
		array(
			'key' => 'destaque',
			'value' => 1
		)
	)
);

$noticias_home = new WP_Query( $args_noticias_home );

$musicais_home = new WP_Query( $args_musicais_home );

/*echo '<pre>';
print_r( $noticias_home );
echo '</pre>';*/


if( $noticias_home->have_posts() ) :

	foreach( $noticias_home->posts as $post ) {
		$news[] = $post;
	}

?>
<section class="destaques">

<div class="container">


		<?php

		$thumb_first = wp_get_attachment_image_src( get_post_thumbnail_id( $news[0]->ID), 'conteudo-home' );

//print_r($thumb_first);

		if ( ! empty( $thumb_first ) ){
			//echo "tem imagem";
			?>
				<div class="row">
					<div class="col-md-8 with-image">

						<div class="image">
							<a href="<?php echo get_permalink( $news[0]->ID ); ?>" class="link-refresh">
								<img alt="<?php echo sanitize_text_field( $news[0]->post_title ); ?>" src="<?php echo $thumb_first[0] ?>">
							</a>
						</div>

						<div class="infos">
							<p class="data"><?php echo get_the_date( 'd/M', $news[0]->ID ); ?> <?php the_terms_without_uncategorized( $news[0]->ID, array( 'taxonomy' => 'category' ), '<span>|</span>' ); ?></p>
							<h3>
								<a href="<?php echo get_permalink( $news[0]->ID ); ?>" class="link-refresh"><?php echo sanitize_text_field( $news[0]->post_title ); ?></a>
							</h3>
							<p>
								<a href="<?php echo get_permalink( $news[0]->ID ); ?>" class="link-refresh"><?php echo wp_trim_words( $news[0]->post_content, 25 ); ?></a>
							</p>

							<p class="footer">
							<a href="<?php echo get_permalink( $news[0]->ID ); ?>" class="link-refresh">LEIA MAIS</a>
							<a data-url="<?php echo get_permalink( $news[0]->ID ); ?>" data-title="<?php echo sanitize_text_field( $news[0]->post_title ); ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
							<a data-url="<?php echo get_permalink( $news[0]->ID ); ?>" data-title="<?php echo sanitize_text_field( $news[0]->post_title ); ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>
							</p>
						</div>

					</div>
					<div class="col-md-4 col-destaques-carousel">


						<div class="carousel slide" id="slider-destaque">
							<?php  if($musicais_home->found_posts > 1) : ?>
							<ol class="carousel-indicators">
								<li class="active" data-slide-to="0" data-target="#slider-destaque">
								</li>

								<?php for( $i = 1; $i < $musicais_home->found_posts; $i++ ) : ?>
									<li data-slide-to="<?php echo $i ?>" data-target="#slider-destaque">
								</li>
								<?php endfor;  ?>
							</ol>
							<?php endif; ?>
							<div class="carousel-inner">

								<?php
								$count_musicais = 1;
								while( $musicais_home->have_posts() ) : $musicais_home->the_post();
								?>

								<div class="item <?php echo ( $count_musicais == 1 ) ? 'active' : '' ?>">
									<div class="image pRelative">
										<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'musica-home' );  ?>
										<img alt="<?php the_title(); ?>" src="<?php echo $thumb[0] ?>" />
									</div>
									<div class="carousel-caption">
										<p class="data"><?php echo get_the_date( 'd M', $news[0]->ID ); ?> <?php the_terms_without_uncategorized( get_the_ID(), array( 'taxonomy' => 'category' ), '<span>|</span>' ); ?></p>
										<h4>
											<a href="<?php the_permalink(); ?>" class="link-refresh"><?php the_title(); ?></a>
										</h4>
										<p>
											<a href="<?php the_permalink(); ?>" class="link-refresh"><?php echo wp_trim_words( get_the_content(), 10 ); ?></a>
										</p>

										<p class="footer">
										<a href="<?php the_permalink(); ?>" class="link-refresh">LEIA MAIS</a>
										<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
										<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>
										</p>

									</div>
								</div>

								<?php $count_musicais++; endwhile; ?>

							</div>
						</div>
						<?php  if($musicais_home->found_posts > 1) : ?>
						<a class="left carousel-control white" href="#slider-destaque" data-slide="prev"><span class="glyphicon glyphicon-menu-left"></span></a> <a class="right carousel-control white" href="#slider-destaque" data-slide="next"><span class="glyphicon glyphicon-menu-right"></span></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<?php unset( $news[0] ); if( ! empty( $news ) ) foreach( $news as $new ) : ?>
						<div class="col-md-4 noticia">
							<p class="data"><?php echo get_the_date( 'd M', $new->ID ); ?> <?php the_terms_without_uncategorized( $new->ID, array( 'taxonomy' => 'category' ), '<span>|</span>' ); ?></p>
							<h4>
								<a href="<?php echo get_permalink( $new->ID ); ?>" class="link-refresh"><?php echo sanitize_text_field( $new->post_title ); ?></a>
							</h4>
							<p>
								<a href="<?php echo get_permalink( $new->ID ); ?>" class="link-refresh"><?php echo wp_trim_words( $new->post_content, 20 ); ?></a>
							</p>

							<p class="footer">
							<a href="<?php echo get_permalink( $new->ID ); ?>" class="link-refresh">LEIA MAIS</a>
							<a data-url="<?php echo get_permalink( $new->ID ); ?>" data-title="<?php echo sanitize_text_field( $new->post_title ); ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
							<a data-url="<?php echo get_permalink( $new->ID ); ?>" data-title="<?php echo sanitize_text_field( $new->post_title ); ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>
							</p>
						</div>
					<?php endforeach; ?>
				</div>
			<?php
		}else{
			//echo "Nao tem imagem";
			?>
				<div class="row">
					<div class="col-md-8 padding0">
							<div class="col-md-12 no-image">

							<div class="infos">
								<p class="data"><?php echo get_the_date( 'd/M', $news[0]->ID ); ?> <?php the_terms_without_uncategorized( $news[0]->ID, array( 'taxonomy' => 'category' ), '<span>|</span>' ); ?></p>
								<h3>
									<a href="<?php echo get_permalink( $news[0]->ID ); ?>" class="link-refresh"><?php echo sanitize_text_field( $news[0]->post_title ); ?></a>
								</h3>
								<p>
									<a href="<?php echo get_permalink( $news[0]->ID ); ?>" class="link-refresh"><?php echo wp_trim_words( $news[0]->post_content, 25 ); ?></a>
								</p>

								<p class="footer">
								<a href="<?php echo get_permalink( $news[0]->ID ); ?>" class="link-refresh">LEIA MAIS</a>
								<a data-url="<?php echo get_permalink( $news[0]->ID ); ?>" data-title="<?php echo sanitize_text_field( $news[0]->post_title ); ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
								<a data-url="<?php echo get_permalink( $news[0]->ID ); ?>" data-title="<?php echo sanitize_text_field( $news[0]->post_title ); ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>
								</p>
							</div>

							</div>
							<?php unset( $news[0] ); unset( $news[3] ); if( ! empty( $news ) ) foreach( $news as $new ) : ?>
								<div class="col-md-6 noticia">
									<p class="data"><?php echo get_the_date( 'd M', $new->ID ); ?> <?php the_terms_without_uncategorized( $new->ID, array( 'taxonomy' => 'category' ), '<span>|</span>' ); ?></p>
									<h4>
										<a href="<?php echo get_permalink( $new->ID ); ?>" class="link-refresh"><?php echo sanitize_text_field( $new->post_title ); ?></a>
									</h4>
									<p>
										<a href="<?php echo get_permalink( $new->ID ); ?>" class="link-refresh"><?php echo wp_trim_words( $new->post_content, 20 ); ?></a>
									</p>

									<p class="footer">
										<a href="<?php echo get_permalink( $new->ID ); ?>" class="link-refresh">LEIA MAIS</a>
										<a data-url="<?php echo get_permalink( $new->ID ); ?>" data-title="<?php echo sanitize_text_field( $new->post_title ); ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
										<a data-url="<?php echo get_permalink( $new->ID ); ?>" data-title="<?php echo sanitize_text_field( $new->post_title ); ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>
									</p>
								</div>
							<?php endforeach; ?>
					</div>

					<div class="col-md-4">

												<div class="carousel slide" id="slider-destaque">
												<?php  if($musicais_home->found_posts > 1) : ?>
							<ol class="carousel-indicators">
								<li class="active" data-slide-to="0" data-target="#slider-destaque">
								</li>

								<?php for( $i = 1; $i < $musicais_home->found_posts; $i++ ) : ?>
									<li data-slide-to="<?php echo $i ?>" data-target="#slider-destaque">
								</li>
								<?php endfor;  ?>
							</ol>
							<?php endif; ?>
							<div class="carousel-inner">

								<?php
								$count_musicais = 1;
								while( $musicais_home->have_posts() ) : $musicais_home->the_post();
								?>

								<div class="item <?php echo ( $count_musicais == 1 ) ? 'active' : '' ?>">
									<div class="image pRelative">
										<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'musica-home' ); ?>

										<img alt="<?php the_title(); ?>" src="<?php echo $thumb[0] ?>" />
									</div>
									<div class="carousel-caption">
										<p class="data"><?php echo get_the_date( 'd M', $news[0]->ID ); ?> <?php the_terms_without_uncategorized( get_the_ID(), array( 'taxonomy' => 'category' ), '<span>|</span>' ); ?></p>
										<h4>
											<a href="<?php the_permalink(); ?>" class="link-refresh"><?php the_title(); ?></a>
										</h4>
										<p>
											<a href="<?php the_permalink(); ?>" class="link-refresh"><?php echo wp_trim_words( get_the_content(), 15 ); ?></a>
										</p>

										<p class="footer">
										<a href="<?php the_permalink(); ?>" class="link-refresh">LEIA MAIS</a>
										<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
										<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>
										</p>

									</div>
								</div>

								<?php $count_musicais++; endwhile; ?>

							</div>
						</div>
						<?php  if($musicais_home->found_posts > 1) : ?>
						<a class="left carousel-control white" href="#slider-destaque" data-slide="prev"><span class="glyphicon glyphicon-menu-left"></span></a> <a class="right carousel-control white" href="#slider-destaque" data-slide="next"><span class="glyphicon glyphicon-menu-right"></span></a>
						<?php endif; ?>
					</div>
				</div>

			<?php
		}

		?>



	<div class="row">
		<div class="col-md-12 textcenter">
			<a href="<?php echo get_post_type_archive_link( 'conteudo' ); ?>" class="veja-mais btn btn-default btn-style-2 link-refresh">
				veja mais
			</a>
		</div>
	</div>

</div>

</section>

<?php endif; ?>

<?php

// Lista de colunistas salvo na parte de "Página principal"
$colunistas = get_field( 'colunistas', 'option' );
shuffle( $colunistas );

// Para colocar a classe "active"
$count_colunista = 1;

?>

<?php if( ! empty( $colunistas ) ) : ?>

<section class="chamada-colunista">
	<div class="row">
		<div class="container controls">
			<div class="cont">
				<a class="left carousel-control " href="#slider-colunistas" data-slide="prev"><span class="glyphicon glyphicon-menu-left"></span></a>
				<a class="right carousel-control" href="#slider-colunistas" data-slide="next"><span class="glyphicon glyphicon-menu-right"></span></a>
			</div>
		</div>

		<div class="col-md-12">
			<div class="carousel slide" id="slider-colunistas">
				<div class="carousel-inner">
			<?php foreach( $colunistas as $colunista ) : ?>
				<?php
					$nome_colunista = get_the_title( $colunista->ID );
					$descricao_colunista = wp_trim_words(  $colunista->post_content , 15 );
					$avatar_colunista = get_field( 'avatar', $colunista->ID );
					$bg_colunista = wp_get_attachment_url( get_post_thumbnail_id( $colunista->ID ) );
					$link_colunista = get_post_type_archive_link( 'programacao' ).'?col='.$colunista->ID;

					$args_conteudo_colunista = array(
						'post_type' => 'conteudo',
						'posts_per_page' => 1,
						'meta_key' => 'colunista',
						'meta_value' => $colunista->ID
					);
					$conteudo_colunista = new WP_Query( $args_conteudo_colunista );
				?>

				<?php if( $conteudo_colunista->have_posts() ) : ?>
					<div class="item <?php echo ( $count_colunista == 1 ) ? 'active' : null ?>">
					<?php while( $conteudo_colunista->have_posts() ) : $conteudo_colunista->the_post(); ?>
						<div class="container container-content">
							<div class="col-md-6">
								<div class="img-topo">
									<a href="<?php the_permalink(); ?>" class="link-refresh"><?php the_post_thumbnail( 'listagem-programa' ); ?></a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="carousel-caption">
									<p class="data"><?php the_date( 'd M' ) ?> <?php the_terms_without_uncategorized( get_the_ID(), 'category', '<span>|</span>' ); ?></p>
									<h4><a href="<?php the_permalink(); ?>" class="link-refresh"><?php the_title(); ?></a></h4>
									<p><a href="<?php the_permalink(); ?>" class="link-refresh"><?php echo wp_trim_words( get_the_content(), 15 ); ?></a></p>

									<p class="footer">
										<a href="<?php the_permalink(); ?>" class="link-refresh">VER MAIS</a>
										<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
										<a data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>
									</p>
								</div>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata();  ?>

						<div class="col-md-4">&nbsp;</div>
						<div class="col-md-8 col-perfil-colunista">
							<div class="perfil-colunista textcenter">
								<div class="infos">
									<div class="img hvr-bounce-out" style="background-image: url(<?php echo $avatar_colunista['sizes']['avatar-colunista'] ?>)"><a href="<?php echo $link_colunista ?>"><span  style="width:100%;height:100%;display:block"></span></a></div>
									<div class="text">
										<p><span>Colunista</span></p>
										<h4><?php echo $nome_colunista ?></h4>
										<p><?php echo $descricao_colunista; ?></p>
										<p class="footer">
											<a href="<?php echo $link_colunista ?>" class="link-refresh">OUÇA OS PROGRAMAS</a>

										<a data-url="<?php echo $link_colunista ?>" data-title="<?php echo $nome_colunista ?>" data-network="facebook" href="" class="mleft15 social share-link"><i class="fa fa-facebook"></i></a>
										<a data-url="<?php echo $link_colunista ?>" data-title="<?php echo $nome_colunista ?>" data-network="twitter" href="" class="mleft15 social share-link"><i class="fa fa-twitter"></i></a>

										</p>
									</div>
								</div>
								<div class="bg"><span></span><img alt="" src="<?php echo $bg_colunista ?>"></div>
							</div>
						</div>
					</div><!-- .item -->

					<?php $count_colunista++; endif; endforeach;  ?>
				</div><!-- .carousel-inner -->
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php

$banners_home = get_field( 'banners_meio_home', 'option' );

if( ! empty( $banners_home ) ) :

	if( count( $banners_home ) == 1 ) {
		$class_banner = '12';
	} else if( count( $banners_home ) == 2 ) {
		$class_banner = '6';
	} else if( count( $banners_home ) == 3 ) {
		$class_banner = '4';
	}

?>

<section class="banners">
	<div class="container">
		<div class="row">
			<?php foreach( $banners_home as $banner_home ) : ?>
				<div class="col-md-<?php echo $class_banner  ?> ">
					<?php
						if( ! empty( $banner_home['url'] ) ) :
					?>

						<a target="_blank" href="<?php echo $banner_home['url'] ?>" target="_blank"><img alt="<?php echo $banner_home['nome'] ?>" src="<?php echo $banner_home['imagem'] ?>"></a>

					<?php else : ?>
						<img alt="<?php echo $banner_home['nome'] ?>" src="<?php echo $banner_home['imagem'] ?>">
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php endif; ?>

<?php

$args_eventos_home = array(
	'post_type' 		=> 'evento',
	'posts_per_page' 	=> 4,
	'meta_key' 			=> 'datas_0_data',
	'orderby'			=> 'meta_value',
	'meta_query'		=> array(
		array(
			'key' 		=> 'datas_0_data',
			'value' 	=> date( 'Y-m-d' ),
			'compare'	=> '>=',
			'type'		=> 'DATE'
		)
	)
);

$eventos_home = new WP_Query( $args_eventos_home );

if( $eventos_home->have_posts() ) :
$array_rev = array_reverse($eventos_home->posts);
$eventos_home->posts = $array_rev;
?>

<section class="eventos">
	<div class="container">
	<div class="row">
		<h2 class="gradient-text">EVENTOS</h2>
		<div class="col-md-12">
			<div class="carousel slide" id="slider-eventos">
				<?php if ($eventos_home->post_count  > 1 ){ ?>
				<ol class="carousel-indicators">
					<li class="active" data-slide-to="0" data-target="#slider-eventos"></li>
					<?php if( count( $eventos_home->posts ) > 1 ) : for( $i = 1; $i < count( $eventos_home->posts ); $i++ ) : ?>
						<li class="" data-slide-to="<?php echo $i ?>" data-target="#slider-eventos"></li>
					<?php endfor; endif; ?>
				</ol>
				<?php } ?>

				<div class="carousel-inner">

					<?php $current_evento = 1; while( $eventos_home->have_posts() ) : $eventos_home->the_post(); $data_do_evento = get_field( 'datas', get_the_ID() ) ?>
					<div class="item <?php echo ( $current_evento == 1 ) ? 'active' : null ?>">
						<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'listagem-conteudo' ); ?>
						<?php $evento_title = get_the_title(); ?>
						<div class="image"><a href="<?php the_permalink(); ?>"><img alt="Carousel Bootstrap First" src="<?php echo $thumbnail[0] ?>"></a></div>

						<div class="carousel-caption">
							<p class="data"> <?php the_terms_without_uncategorized( get_the_ID(), array( 'taxonomy' => 'categoria' ), '' ); ?></p>
							<h4>
							<a href="<?php the_permalink(); ?>"><?php echo date_i18n( 'd \d\e F', strtotime( $data_do_evento[0]['data'] ) ); ?></a>
							</h4>
							<p style="padding-top:10px;">
								<a href="<?php the_permalink(); ?>" class="link-refresh"><?php echo $evento_title; ?></a>
							</p>

							<p class="footer">
								<a href="<?php echo esc_url( get_post_type_archive_link( 'evento' ) ); ?>" class="link-refresh">VEJA TODOS</a>

										<a data-url="<?php the_permalink(); ?>" data-title="<?php echo $evento_title; ?>" data-network="facebook" href="" class="fr mleft15 social share-link"><i class="fa fa-facebook"></i></a>
										<a data-url="<?php the_permalink(); ?>" data-title="<?php echo $evento_title; ?>" data-network="twitter" href="" class="fr social share-link"><i class="fa fa-twitter"></i></a>


							</p>

						</div>
					</div>
					<?php $current_evento++; endwhile; ?>

				</div>
				<?php if( $current_evento > 2 ) : ?>
					<a class="left carousel-control" href="#slider-eventos" data-slide="prev">
						<span class="glyphicon glyphicon-menu-left"></span></a>
					<a class="right carousel-control" href="#slider-eventos" data-slide="next">
						<span class="glyphicon glyphicon-menu-right"></span></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	</div>
</section>

<?php endif; ?>

<?php

$args_jukebox = array(
	'post_type' => 'musica',
	'posts_per_page' => 1
);

$musicas_jukebox = new WP_Query( $args_jukebox );

if( $musicas_jukebox->have_posts() ) :

$jukebox = $musicas_jukebox->post;

$descricao_jukebox = get_field( 'texto_para_a_playlist', 'option' );
$musicas = get_field( 'musicas', $jukebox->ID );

/*echo '<pre>';
print_r( $musicas );
echo '</pre>';*/

if( ! empty( $musicas ) ) :

	$first = ( count( $musicas ) / 2 );

	$first = ceil( $first );

	$last = ( count( $musicas ) - $first );


?>

<section class="jukebox">
	<div class="container">
	<div class="row">
		<div class="col-md-9 jukebox-content" >
			<div class="row">
				<div class="col-md-5">
					<h3 class="gradient-text">
						PLAYLIST
					</h3>
				</div>
				<div class="col-md-7 sugira">
					<a href="" class="tip"  data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Aqui você pode sugerir a sua música favorita"><img src="<?php echo IMG_URL ?>tip.png" /></a>
					<input class="busca sugestao" type="text" name="" placeholder="Sugira uma música">
					<span class="erro erro-sugestao" style="display: none;">Digite o nome da música</span>
					<input class="enviar send_sugestao" type="submit" name="" value="Enviar" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p class="subtitulo">
					<?php echo $descricao_jukebox; ?>
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 musicas_voto">
					<ul>
						<?php for( $i = 0; $i < $first; $i++ ) : ?>
							<li title="<?php echo $musicas[$i]['musica'] . ' - ' .$musicas[$i]['artista']; ?>">
								<div class="player-jukebox">
									<a href="#" class="fechar"><i class="fa fa-close"></i></a>
									<div class="fl num">
										<b><?php echo $i+1 ?>.</b>
									</div>
								</div>
								<b><?php echo $i+1; ?>.</b>
								<input id="option_<?php echo $i; ?>" type="checkbox" name="musicas" value="<?php echo $musicas[$i]['id'] ?>">
								<label for="option_<?php echo $i; ?>"><span><span></span></span></label>
								<div class="inline-block play" >
									<a href="" class="jukebox-play hvr-pulse-grow" data-title="<?php echo $musicas[$i]['musica'] ?> <br><span><?php echo $musicas[$i]['artista'] ?>" data-src="<?php echo $musicas[$i]['arquivo'] ?>">	<img src="<?php echo IMG_URL ?>icon-ao-vivo.png" width="27">
									</a>
								</div>
								<?php if ( strlen($musicas[$i]['musica']) > 17 ) { echo mb_substr($musicas[$i]['musica'],0,16)."..."; } else { echo $musicas[$i]['musica']; }; ?>
								<?php //echo $musicas[$i]['musica'] ?>

								/ <span><?php echo $musicas[$i]['artista'] ?></span>
							</li>
						<?php endfor; ?>
					</ul>
				</div>
				<?php if( $last ) : ?>
					<div class="col-md-6 musicas_voto">
							<ul>
							<?php for( $i = $first; $i < count( $musicas ); $i++ ) : ?>
								<li title="<?php echo $musicas[$i]['musica'] . ' - ' .$musicas[$i]['artista']; ?>">
									<div class="player-jukebox">
										<a href="#" class="fechar"><i class="fa fa-close"></i></a>
										<div class="fl num">
											<b><?php echo $i+1 ?>.</b>
										</div>
									</div>
									<b><?php echo $i+1; ?>.</b>
									<input id="option_<?php echo $i; ?>" type="checkbox" name="musicas" value="<?php echo $musicas[$i]['id'] ?>">
									<label for="option_<?php echo $i; ?>"><span><span></span></span></label>
									<div class="inline-block play" >
										<a href="" class="jukebox-play hvr-pulse-grow" data-title="<?php echo $musicas[$i]['musica'] ?> <br><span><?php echo $musicas[$i]['artista'] ?></span>" data-src="<?php echo $musicas[$i]['arquivo'] ?>">	<img src="<?php echo IMG_URL ?>icon-ao-vivo.png" width="27">
										</a>
									</div>
									<?php if ( strlen($musicas[$i]['musica']) > 17 ) { echo mb_substr($musicas[$i]['musica'],0,16)."..."; } else { echo $musicas[$i]['musica']; }; ?>
									/ <span><?php echo $musicas[$i]['artista'] ?></span>
								</li>
							<?php endfor; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<div class="row">
				<div class="col-md-12 textcenter container-votar">
					<span class="erro erro-votacao" style="display: none;">Selecione uma ou mais músicas</span>
					<button type="button" class="btn btn-default btn-style-2 votar-home" data-jukebox="<?php echo $jukebox->ID ?>">
						VOTAR
					</button>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="row">
			<div class="item-a col-xs-12 col-sm-6 col-md-12">
				<?php

				$publicidades = get_publicidades( 293 );

				if( ! empty( $publicidades ) ) {
					array_rand( $publicidades, 1 );

				?>

						<a href="<?php echo $publicidades[0]['link'] ?>" target="_blank">
							<img alt="<?php echo $publicidades[0]['link']; ?>" style="width: 250px;
    margin: 0 auto;
    display: block;" src="<?php echo $publicidades[0]['imagem'] ?>" />
						</a>

				<?php
				}
				//  Se tiver banner ativo cadastrado no site vale ele, se não tiver ativo entra automaticamente o do Google.
				else {

					?>
					  <div>
					    <div>
					    <div align="center">
					    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					    <!-- Cabeçalho da página inicial -->
					    <ins class="adsbygoogle"
					    style="display:inline-block;width:263px;height:250px"
					    data-ad-client="ca-pub-7312481615032270"
					    data-ad-slot="1236068945"></ins>
					    <script>
					    (adsbygoogle = window.adsbygoogle || []).push({});
					    </script>
					    </div>
					    </div>
					  </div>

					<?php

				}
				?>


			</div>
			<div class="item-b col-xs-12 col-sm-6 col-md-12"><a href=""><img alt="" style="width: 250px;
    margin: 0 auto;
    display: block;" src="<?php echo IMG_URL ?>app-pub.jpg"></a></div>
			</div>
		</div>
	</div>
	</div>
</section>


<?php endif; endif; ?>


<section class="colunistas">
	<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Colunistas</h3>
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" style="display:none">
    <filter id="greyscale">
     <feColorMatrix type="matrix" values="0.3333 0.3333 0.3333 0 0
                                          0.3333 0.3333 0.3333 0 0
                                          0.3333 0.3333 0.3333 0 0
                                          0      0      0      1 0"/>
    </filter>
</svg>

			<div>
			  <div class="cycle-slideshow"
				data-allow-wrap="true"
				data-cycle-log="false"
				data-cycle-carousel-visible="4"
				data-cycle-fx="carousel"
				data-cycle-slides=".item"
				data-cycle-next=".right-colunistas"
				data-cycle-prev=".left-colunistas"
				data-cycle-timeout="5000"
				data-cycle-speed="300"
				data-cycle-pause-on-hover="true">
				<div class="container">
				<?php
				$count_carousel_colunistas = 1;
				shuffle($colunistas);
				foreach( $colunistas as $colunista ) :

				$link = get_post_type_archive_link( 'programacao' ).'?col='.$colunista->ID;
				?>
				    <div class="item <?php //echo ( $count_carousel_colunistas == 1 ) ? 'active' : null; ?>">
				      <div>
				      <a href="<?php echo $link; ?>" alt="<?php echo get_the_title( $colunista->ID ); ?>">
				      		<span class="text"><b><?php echo get_the_title( $colunista->ID ); ?></b></span>
				      		<img src="<?php $avatar2 = get_field( 'avatar', $colunista->ID ); echo $avatar2['sizes']['avatar-colunista'] ?>" class="img-responsive lena-desaturate">
				      </a>
				      </div>
				    </div>
				<?php $count_carousel_colunistas++; endforeach; ?>

			  </div>
			  </div>
				<a class="left-colunistas"><i class="glyphicon glyphicon-menu-left"></i></a>
				<a class="right-colunistas"><i class="glyphicon glyphicon-menu-right"></i></a>
			</div>
			</div>

	</div>
	</div>
</section>

<?php get_footer(); ?>