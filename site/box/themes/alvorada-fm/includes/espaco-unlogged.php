<?php

$redirect = get_permalink( get_page_by_title( 'Espaço Alvorada' ) );

?>

		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<h2 class="gradient-text">Espaço Alvorada</h2>
					<p>O Espaço Alvorada foi feito pra você. Aqui você vai conferir as promoções que participou quais foi o ganhador, além de poder alterar seus dados de cadastro sempre que precisar. Faça seu cadastro completo e acesse.<br><br></p>
				</div>
				<div class="col-md-4">&nbsp;</div>
				</div>
				<div class="row">
				<div class="col-md-4 login-box">
				<h3>Já possuo cadastro</h3>
					<form class="login" method="POST" action="<?php echo wp_login_url( $redirect  ); ?>">
						<fieldset>
							<input type="text" name="log" placeholder="usuário / e-mail" class="col-md-12">
						</fieldset>
						<fieldset>
							<input type="password" name="pwd" placeholder="senha" class="col-md-12">
						</fieldset>
						<fieldset>
							<a class="esqueci" href="<?php echo wp_lostpassword_url( $redirect  ); ?>">Esqueci minha senha</a>
						</fieldset>
						<fieldset>
							<input type="submit" name="" value="ENTRAR" class="btn btn-default">
						</fieldset>
					</form>
				</div>

				<div class="col-md-7 col-md-offset-1 pRelative container-cadastro">
					<h3 class="dark">Não tem cadastro?</h3>
					<form class="row cadastro" method="post" action="<?php echo admin_url( 'admin-ajax.php', 'cadastro_usuario' ); ?>">
						<?php wp_nonce_field( 'cadastro_usuario', 'cadastro_usuario_nonce', get_permalink() ); ?>
						<input type="hidden" name="action" value="cadastro_usuario" >
							<?php alvorada_formulario_usuario(); ?>
						<fieldset class="col-md-12">
							<div class="row">
								<div class="col-md-7">
									<div class="inline-block confirmacao-newsletter">
									  <input id="option" type="checkbox" name="field" value="option" checked>
									  <label for="option"><span><span></span></span></label>
									  	Aceito receber novidades da Alvorada FM
									</div>
								</div>
								<div class="col-md-5"><input type="submit" name="" value="ENVIAR" class="btn btn-default"></div>
							</div>
						</fieldset>
					</form>
				</div>

			</div>
		</div>