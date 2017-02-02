<?php get_header(); the_post(); ?>

<?php $states = get_field_object('estado', "user_1" ); ?>
<?php $eu_quero = get_field('eu_quero' ); ?>
<div class="inner fale-conosco">
	<section class="content-fale-conosco">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<h2 class="gradient-text">Fale Conosco</h2>
					<p><?php echo wp_trim_words( get_the_content(), 200 ) ?></p>

					<form class="row" id="fale-conosco" method="post" action="#">
						<fieldset >
							<label class="col-md-2">Nome *</label>
							<input class="col-md-10 name" type="text" name="nome" data-msg-required="Campo obrigatório" required />
						</fieldset>
						<fieldset >
							<label class="col-md-2">Sobrenome *</label>
							<input class="col-md-10 lastname" type="text" name="sobrenome" data-msg-required="Campo obrigatório" required />
						</fieldset>
						<fieldset >
							<label class="col-md-2">E-mail *</label>
							<input class="col-md-10 email" type="email" name="email" data-msg-required="Campo obrigatório" required />
						</fieldset>
						<fieldset>
							<label class="col-md-2">Cidade</label>
							<input class="col-md-6 city" type="text" name="cidade" />
							<label class="col-md-2 text-center">Estado</label>
							<div class="col-md-2" style="padding: 0 3px;">
								<select class="selectBoxIt state" name="estado">
									<option value="">(UF)</option>
								<?php foreach( $states['choices'] as $uf ) : ?>
									<option <?php echo $data['estado'] == $uf ? 'selected' : ''; ?> value="<?php echo $uf ?>"><?php echo $uf ?></option>
								<?php endforeach; ?>
								</select>
							</div>
						</fieldset>

						<div class="row other">
							<fieldset class="col-md-8">
								<label class="col-md-3">Eu quero *</label>
								<div class="col-md-9" style="padding: 0 3px;">
									<select class="selectBoxIt subject selectBoxIt" data-msg-required="Campo obrigatório" name="assunto" required>
										<option>Selecione um assunto</option>
									<?php foreach($eu_quero as $n => $option) : ?>
										<option value="<?php echo $n + 1; ?>" data-key="<?php echo $option['chave']; ?>" <?php if( isset($_GET['assunto']) && $_GET['assunto'] == $option['chave'] ) { echo "selected" ;} ?>  data-email="<?php echo $option['e-mail']; ?>"><?php echo $option['titulo']; ?></option>
									<?php endforeach; ?>
									</select>
								</div>
							</fieldset>
							<fieldset class="col-md-4 curriculo-box" style="display:none;">
								<label class="col-md-5">Currículo</label>
								<div class="col-md-7">
										<input type="file" name="curriculo" class="jfilestyle" data-theme="blue" data-input="false" data-buttonText="Anexar"/>
								</div>

							</fieldset>
						</div>

						<fieldset>
							<label class="col-md-2">Mensagem *</label>
							<textarea class="col-md-10 message" name="mensagem" data-msg-required="Campo obrigatório" required></textarea>
						</fieldset>
						<fieldset class="row">
								<div class="col-md-7 pRelative">
									<div class="inline-block confirmacao-newsletter">
									  <input id="option" type="checkbox" name="field" value="option" checked="checked">
									  <label for="option"><span><span></span></span></label>
									  	Aceito receber novidades da Alvorada FM
									</div>
								</div>
								<div class="col-md-5"><input type="submit" name="" value="enviar" class="btn"></div>

						</fieldset>
					</form>

				</div>
				<aside class="col-md-3 col-md-offset-1">
				<h5>Endereço</h5>
				<p class="small">Av. Raja Gabáglia, 3.100 <br> 3 andar Estoril</p>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3750.1095045582056!2d-43.95976128447625!3d-19.96189654445839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa697eca1258b4d%3A0x3d8e7dfda128c8bc!2sAv.+Raja+Gab%C3%A1glia%2C+3100+-+Estoril%2C+Belo+Horizonte+-+MG%2C+30350-540!5e0!3m2!1spt-BR!2sbr!4v1469133001601" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
				<h5>Atendimento ao ouvinte</h5>
				<p class="small">55 31 2122-2525</p>
				<h5>Comercial</h5>
				<p class="small">55 31 2122-2547</p>
				<h5>Redes sociais</h5>
				<p class="social">
					<a href="https://www.facebook.com/Alvorada94.9/" target="_blank"><i class="fa fa-facebook"></i></a>
					<a href="https://twitter.com/RadioAlvorada" target="_blank"><i class="fa fa-twitter"></i></a>
					<a href="https://www.instagram.com/alvoradafm/" target="_blank"><i class="fa fa-instagram"></i></a>
				</p>
				</aside>
			</div>
		</div>
	</section>


<?php get_template_part( 'includes/footer', 'internas' ); ?>

</div>

<?php get_footer(); ?>