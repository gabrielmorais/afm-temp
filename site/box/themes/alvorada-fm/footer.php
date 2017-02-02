<?php include( 'includes/lb-info.php' ); ?>

<footer>
  <div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="row">
        <div class="col-xs-6 col-md-6">
          <ul class="coluna-a">
            <li>
              <a href="<?php echo esc_url( get_post_type_archive_link( 'programacao' ) ); ?>" class="link-refresh">Programação</a>
            </li>
            <li>
              <a href="<?php echo esc_url( get_post_type_archive_link( 'evento' ) ); ?>" class="link-refresh">Eventos</a>
            </li>
            <li>
              <a href="<?php echo esc_url( get_post_type_archive_link( 'promocao' ) ) ?>" class="link-refresh">Promoções</a>
            </li>
            <li>
              <a href="<?php echo esc_url( get_post_type_archive_link( 'conteudo' ) ); ?>" class="link-refresh">Mais Conteúdo</a>
            </li>



          </ul>
        </div>
        <div class="col-xs-6 col-md-6 ">
          <ul class="coluna-b">
            <li>
              <a href="<?php echo get_permalink( get_page_by_title( 'alvorada fm' ) ); ?>">Alvorada FM</a>
            </li>
            <li>
              <a href="<?php echo get_permalink( get_page_by_title( 'download app' ) ); ?>">Download App</a>
            </li>
            <li>
              <a href="<?php echo get_permalink( get_page_by_title( 'anuncie' ) ); ?>">Anuncie</a>
            </li>
            <li>
              <a href="<?php echo get_post_type_archive_link( 'pergunta' ); ?>" class="link-refresh">Dúvidas Frequentes</a>
            </li>
            <li>
              <a href="<?php echo get_permalink( get_page_by_title( 'fale conosco' ) ); ?>" class="link-refresh">Fale conosco</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 logo">
          <img alt="Alvorada FM" src="<?php echo IMG_URL ?>logo-alvorada-fm-white.png">
        </div>
      </div>
    </div>
    <div class="col-md-5 parceiros">
      <h3>
        Parceiros
      </h3>
      <div class="list-parceiros">

       <a href="http://www.otempo.com.br" target="_blank"><img alt="Bootstrap Image Preview" src="<?php echo IMG_URL ?>parceiros-o-tempo.png"></a>
           <a href="http://pucminastempoclima.com.br/" target="_blank"><img alt="Bootstrap Image Preview" src="<?php echo IMG_URL ?>parceiros-clima.png"></a>
           </div>

      <p>&nbsp;</p>
      <h3 >
        Redes Sociais
      </h3>
      <a href="https://www.facebook.com/Alvorada94.9/" target="_blank" class="social"><i class="fa fa-facebook"></i></a>
      <a href="https://twitter.com/RadioAlvorada" class="social mleft15" target="_blank"><i class="fa fa-twitter"></i></a>
      <a href="https://www.instagram.com/alvoradafm/" class="social mleft15" target="_blank"><i class="fa fa-instagram"></i></a>
    </div>
    <div class="col-md-3 endereco">
      <h3>
        Endereço
      </h3>
      <address>
        Av. Raja Gabaglia, 3100<br>
        3º andar, Estoril
      </address>
      <h3>
        Atendimento ao ouvinte
      </h3>
      <p>
      55 31 2122-2525
        </p>
      <h3>
        Comercial
      </h3>
      <p>
      55 31 2122-2547
      </p>
    </div>
  </div>
  </div>
</footer>

</div><!-- TESTE -->


</div><!-- conainer-frame -->


<div class="mask-total"></div>

<?php //include( 'includes/player.php' ); ?>


    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', enviroment.GA, 'auto');
      ga('send', 'pageview');


    </script>


    <?php wp_footer(); ?>

    <?php if(isset($_GET['filtros'])) : ?>
    <script type="text/javascript">
          jQuery("html,body").animate({
          scrollTop: jQuery(".filtros").offset().top+"px"
        })
    </script>
    <?php endif; ?>

    <?php if(isset($_GET['col'])) : ?>
    <script type="text/javascript">
          jQuery("html,body").animate({
          scrollTop: jQuery(".listagem").offset().top+"px"
        })
    </script>
    <?php endif; ?>


    <script type="text/javascript">
    if ( jQuery("body").hasClass("category")  ) {
           jQuery("html,body").animate({
          scrollTop: jQuery(".filtros").offset().top+"px"
        })
         }
    </script>
    <?php
    global $wp;
    $current_url = home_url(add_query_arg(array(),$wp->request));

    $current_url = str_replace('/site', '', $current_url);

    ?>
<script type="text/javascript">
setTimeout(function(){
     if (jQuery("body").attr("id") == 'iframe-loaded'){
     }else{
        redir = '<?php echo $current_url; ?>';
        redir = redir.replace("/site","")
        parent.window.location.href = redir;
     }
}, 1000);
</script>
<script>
  $( document ).ready(function() {

  parent.change_url( '<?php echo wp_title() ?>', '<?php echo $current_url ?>' );

});
  $( window ).load(function() {

  parent.change_url( '<?php echo wp_title() ?>', '<?php echo $current_url ?>' );

  parent.enviroment = enviroment;

});
</script>


  </body>
</html>
