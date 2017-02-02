<div id="box-promocao">
<?php

global $post;

$user_id = get_current_user_id();

$status_promocao = get_field( 'status', get_the_ID() );

$status_ganhador = get_field( 'ganhador', get_the_ID() );

if( $user_id ) {

	$participantes_promocao = get_field( 'participantes_promocao', $post->ID );

	if( ! empty( $participantes_promocao ) ) {
		$participantes = json_decode( $participantes_promocao, true );
	} else {
		$participantes = null;
	}

	if( $participantes ) {

		if( array_key_exists( $user_id, $participantes ) ) {
			$participando = true;
		} else {
			$participando = false;
		}
	}

	if( $status_promocao == 'aberta' ) { // Promoção aberta
	
		if( ! $participando ) {	
		?>
			<div class="destaque-interno box-acesso-promocao">
				<h4>Participe da promoção</h4>
				<p>Para participar dessa promoção você precisa de: fazer o seu login, curtir nossa página e responder a pergunta.</p>
				<p>RESPONDA A PERGUNTA:</p>
				<?php echo get_field( 'pergunta_para_promocao', $post->ID ) ?>
				<div class="row">
				<div class="col-md-12">
					<form method="POST" action="">
						<textarea name="resposta" id="resposta_promocao" ></textarea>
						<div id="charNum" style="float: right;"></div>
						<div>
							<div class="inline-block cb">
							  <input id="option" type="checkbox" name="field" value="option">
							  <label for="option"><span><span></span></span></label>
							  	Li e concordo com os termos
							</div>
						</div>
						<div class="alert alert-danger msg_return">
							<span class="inner"></span>
						</div>
						<input type="submit" class="btn btn-submit" value="ENVIAR" />
					</form>
				</div>

				</div>
			</div> 
		<?php
		} else {
		?>
			<div class="destaque-interno box-acesso-promocao">
				<h4>Participe da promoção</h4>
				<p>Você já está participando da promoção,<br> BOA SORTE!!</p>
			</div>
		<?php
		}
	} else { // Promoção encerrada


	
		if( ! $participando ) {	

			if( $status_ganhador ) {
			?>
				<div class="destaque-interno box-acesso-promocao">
					<h4>Vencedores<br><br></h4>
					<div class="row">
						<?php

						$ganhadores = get_field( 'ganhadores', get_the_ID() );
						$ganhadores = json_decode( $ganhadores ) ;
						?>
						
						<?php
						foreach( $ganhadores as $ganhador  ) {
						?>
							<div class="col-md-6"><p><b><?php echo get_field( 'nome', "user_{$ganhador}" ) ?></b></p></div>
						<?php
						}
						?>
					</div>
					<div >
						<p class="small">* Os vencedores receberão um comunicação por email. Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec .</p>
					</div>
				</div>
			<?php
			} else {
			?>
				<div class="destaque-interno box-acesso-promocao">
					<h4>Promoção encerrada</h4>
					<p>Aguarde em breve o resultado será divulgado.</p>
				</div>
			<?php
			}
		} else {
			if( $status_ganhador ) {
			?>
				<div class="destaque-interno box-acesso-promocao">
					<h4>Vencedores<br><br></h4>
					<div class="row">
						<?php

						$ganhadores = get_field( 'ganhadores', get_the_ID() );
						$ganhadores = json_decode( $ganhadores ) ;
						?>
						
						<?php
						foreach( $ganhadores as $ganhador  ) {
						?>
							<div class="col-md-6"><p><b><?php echo get_field( 'nome', "user_{$ganhador}" ) ?></b></p></div>
						<?php
						}
						?>
					</div>
					<div >
						<p class="small">* Os vencedores receberão um comunicação por email. Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec .</p>
					</div>
				</div>
			<?php
			} else {
			?>
				<div class="destaque-interno box-acesso-promocao">
					<h4>Promoção encerrada</h4>
					<p>Você já está participando da promoção,<br> BOA SORTE!!</p>
				</div>
			<?php
			}
		}
	}

 
} else { // not logged

	if( $status_promocao == 'aberta' ) { // Promoção aberta
	?>
		<div class="destaque-interno">
			<h4>PARTICIPE</h4>
			<p>Para participar dessa promoção você precisa:</p>
			<div class="row">
				<div class="col-md-6">
					<h5>Entrar no espaço alvorada</h5>
					<form method="POST" action="<?php echo wp_login_url( get_permalink() ); ?>">
						<input type="text" name="log" placeholder="usuário / e-mail" />
						<input type="password" name="pwd" placeholder="senha" />
						<input type="submit" name="" value="Entrar" class="btn" />
					</form>
					<p class="acoes">
						<a href="<?php ?>">Esqueci minha senha</a>
						<br>
						<a href="<?php echo get_permalink( get_page_by_title( 'Espaço Alvorada' ) ); ?>">Não tem cadastro?</a>
					</p>
				</div>
				<div class="col-md-6 pRelative">
					<i class="fa fa-plus"></i>
					<h5 class="textcenter">Curtir nossa página no facebook</h5>
					<p class="textcenter"><iframe src="https://www.facebook.com/plugins/like.php?href=http://www.alvoradafm.com.br/promocao&width=60&layout=box_count&action=like&show_faces=false&share=false&height=65&appId=<?php echo FACEBOOK_APP_ID; ?>" width="60" height="65" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></p>
				</div>
			</div>
		</div>
	<?php 
	} else { // Promoção encerrada
		if( $status_ganhador ) {
		?>
			<div class="destaque-interno box-acesso-promocao">
				<h4>Vencedores<br><br></h4>
				<div class="row">
					<div class="col-md-6"><p><b>João dos Santos</b></p></div>
				</div>
				<div >
					<p class="small">* Os vencedores receberão um comunicação por email. Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec .</p>
				</div>
			</div>
		<?php
		} else {
		?>
			<div class="destaque-interno box-acesso-promocao">
				<h4>Promoção encerrada</h4>
				<p>Aguarde em breve o resultado será divulgado.</p>
			</div>
		<?php
		}
	}
} //Verificação se logado 


?>

</div>

<!-- <div class="destaque-interno box-acesso-promocao">
	<h4>Participe da promoção</h4>
	<p>Para participar dessa promoção você precisa de: fazer o seu login, curtir nossa página e responder a pergunta.</p>
	<p>Você já está participando da promoção,<br> BOA SORTE!!</p>
</div> -->

<!-- <div class="destaque-interno box-acesso-promocao">
	<h4>Participe da promoção</h4>
	<p>Para participar dessa promoção você precisa de: fazer o seu login, curtir nossa página e responder a pergunta.</p>
	<p>RESPONDA A PERGUNTA:</p>
	<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor?  onsequat</p>
	<div class="row">
	<div class="col-md-12">
		<form>
			<textarea></textarea>
			<div>
			<div class="inline-block cb">
			  <input id="option" type="checkbox" name="field" value="option">
			  <label for="option"><span><span></span></span></label>
			  	Li e concordo com os termos
			</div>
			</div>
			<input type="submit" class="btn btn-submit" value="ENVIAR" />
		</form>
	</div>

	</div>
</div> -->

<!-- <div class="destaque-interno box-acesso-promocao">
	<h4>CONFIRMADO</h4>
	<p>Cruze os dedos, você já está participando da promoção,<br>BOA SORTE.</p>
</div> -->




<!-- <div class="destaque-interno box-acesso-promocao">
	<h4>Promoção encerrada</h4>
	<p>Aguarde em breve o resultado será divulgado.</p>
</div> -->







<!-- 	<div class="destaque-interno box-acesso-promocao">
		<h4>Participe da promoção</h4>
		<p>Para participar dessa promoção você precisa de: fazer o seu login, curtir nossa página e responder a pergunta.</p>
		<p>Você já está participando da promoção,<br> BOA SORTE!!</p>
	</div>
	
	<div class="destaque-interno box-acesso-promocao">
		<h4>Participe da promoção</h4>
		<p>Para participar dessa promoção você precisa de: fazer o seu login, curtir nossa página e responder a pergunta.</p>
		<p>RESPONDA A PERGUNTA:</p>
		<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor?  onsequat</p>
		<div class="row">
			<div class="col-md-12">
				<form>
					<textarea></textarea>
					<div>
					<div class="inline-block cb">
					  <input id="option" type="checkbox" name="field" value="option">
					  <label for="option"><span><span></span></span></label>
					  	Li e concordo com os termos
					</div>
					</div>
					<input type="submit" class="btn btn-submit" value="ENVIAR" />
				</form>
			</div>
		</div>
	</div>

 -->

