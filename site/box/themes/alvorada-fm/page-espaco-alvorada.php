<?php get_header(); ?>



<div class="inner fale-conosco espaco-alvorada">
	<section class="content-fale-conosco ">

		<?php

		if( is_user_logged_in() ) {
			get_template_part( 'includes/espaco', 'logged' );
		} else {
			get_template_part( 'includes/espaco', 'unlogged' );
		}

		?>

	</section>

<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer(); ?>