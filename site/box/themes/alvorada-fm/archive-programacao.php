<?php get_header(); ?>
<div class="inner">

<?php
$image = get_field( 'banner_programacao', 'option' ) ;

$thumbnail = $image[url];

if (!$thumbnail){
	?>
<!-- Variação sem megabanner -->
<section class="header-simples">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<h2 class="gradient-text">PROGRAMAÇÃO</h2>
				</div>
				<div class="col-md-5">
					<a href="" class="fr social share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="twitter"><i class="fa fa-twitter"></i></a>
					<a href="" class="fr social share-link" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-network="facebook"><i class="fa fa-facebook"></i></a>
				</div>
			</div>
		</div>
</section>
	<?php
}else{
?>




<section class="megabanner">

			<div class="carousel slide megabanner-slider" id="megabanner" >

				<div class="carousel-inner">

					<div class="item active" style="background-image: url(<?php echo $thumbnail; ?>)">
						<!-- <img alt="Carousel Bootstrap First" src=""> -->
						<div class="carousel-caption">
						<div class="container">
							<div>
							<h4 class="gradient-text">
								PROGRAMAÇÃO
							</h4>
							</div>

						</div>

						</div>
					</div>

				</div>

			</div>

</section>
<?php
}
 ?>

<?php

$terms = get_terms( 'assunto', array(
    'hide_empty' => true,
	'exclude' => array(1),
) );

/*echo '<pre>';
print_r( $terms );
echo '</pre>';*/

if( ! empty( $terms ) ) :

?>

<section class="filtros">
<div class="container">
	<div class="row">
		<div class="col-md-4">
		<select class="selectBoxIt filtro-programacao">
			<option>Escolha um assunto</option>
			<?php foreach( $terms as $term ) : ?>
				<option value="<?php echo get_term_link( $term->term_id, 'assunto' ) ?>"><?php echo $term->name ?></option>
			<?php endforeach; ?>
		</select>
		</div>

	</div>
</div>
</section>

<?php endif; ?>


<?php if( have_posts() ) : ?>

<section class="listagem listagem-programacao">

	<?php get_template_part( 'loop', 'programacao' ); ?>

</section>
<?php get_template_part( 'pagination', 'default' ); ?>
<?php else: ?>
<section class="listagem listagem-programacao">
<div class="container">
<?php echo "Nenhum programa relacionado ao colunista foi encontrado."; ?>
</div>
</section>
<?php endif; ?>



<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>


<?php get_footer();
