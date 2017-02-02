<?php  
/* 
Template Name: Custom WordPress Password Reset
*/
 
get_header()
?>


<div class="inner fale-conosco">
	<section class="content-fale-conosco">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<h2 class="gradient-text">Resetar Senha</h2>
					<?php the_content(); ?>

				</div>
				<aside class="col-md-3 col-md-offset-1">
				<h5>Endereço</h5>
				<p class="small">Av. Raja Gabáglia, 3.100 <br> 3 andar Estoril</p>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3750.1095045582056!2d-43.95976128447625!3d-19.96189654445839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa697eca1258b4d%3A0x3d8e7dfda128c8bc!2sAv.+Raja+Gab%C3%A1glia%2C+3100+-+Estoril%2C+Belo+Horizonte+-+MG%2C+30350-540!5e0!3m2!1spt-BR!2sbr!4v1469133001601" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
				<h5>Atendimento ao ouvinte</h5>
				<p class="small">55 31 234 3434</p>
				<h5>Comercial</h5>
				<p class="small">55 31 234 3434</p>
				<h5>Redes sociais</h5>
				<p class="social">
					<a href=""><i class="fa fa-facebook"></i></a>
					<a href=""><i class="fa fa-twitter"></i></a>
					<a href=""><i class="fa fa-instagram"></i></a>
				</p>
				</aside>
			</div>
		</div>
	</section>


<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer(); ?>