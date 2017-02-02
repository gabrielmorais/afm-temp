<div id="player-box" class="">
<div class="container">

<div class="col-xs-3 col-md-3 col-cover">
  <img class="img-responsive cover" src="<?php echo $img_url; ?>cover.png">
  <!-- <img src="<?php echo IMG_URL ?>appstore.png" class="appstore "> -->
</div>
<div class="col-xs-6 col-md-6 player-container">

    <div class="col-xs-5 col-md-5 text-left col-alvorada-agora">
    <div class="song-info full">
      <h3>ALVORADA AGORA</h3>
      <p class="music-name"><span>carregando música...</span></p>
      <p class="artist-name">carregando artista...</p>
    </div>
    <div class="song-info min">
      <h3>TOCANDO AGORA NA ALVORADA FM</h3>
      <p class="music-name marquee"><span>carregando &bull; <b class="artist">música...</b></span></p>
    </div>
    <!-- PLAYER CONTENT -->
        <div class="player-content">
          <div id="jquery_jplayer_2" class="jp-jplayer"></div>
          <div id="jp_container_1" class="jp-audio-stream" role="application" aria-label="media player">
            <div class="jp-type-single">
              <div class="jp-gui jp-interface">
                <div class="jp-volume-controls">
                  <button class="jp-mute" role="button" tabindex="0">mute</button>
                  <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                  <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                  </div>
                </div>
                <div class="jp-controls">
                  <button class="jp-play" role="button" tabindex="0">play</button>
                </div>
              </div>
              <div class="jp-details">
                <div class="jp-title" aria-label="title">&nbsp;</div>
              </div>
              <div class="jp-no-solution">
                <span>Update Required</span>
                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
              </div>
            </div>
          </div>
        </div>
    <!-- - -->
    </div>

      <div class="col-xs-7 col-md-7 col-compartilhe">
        <div class="row central">
          <p class="compartilhe">Compartilhe <br> <a href="" class="social facebook share-link-social" data-url="http://<?php echo $_SERVER['HTTP_HOST']; ?>" data-title="Alvorada FM" data-network="facebook"><i class="fa fa-facebook"></i></a><a class="social facebook share-link-social" href="" data-url="http://<?php echo $_SERVER['HTTP_HOST']; ?>" data-title="Alvorada FM" data-network="twitter" ><i class="fa fa-twitter"></i></a></p>

          <div class="col-md-6 col-tocar">
            <a href="" class="tocar-menos"><img src="<?php echo $img_url; ?>hand-down.png"><br>Tocar menos</a>
          </div>
                    <div class="col-md-6 col-tocar">
            <a href="" class="tocar-mais"><img src="<?php echo $img_url; ?>hand-up.png"><br>Tocar mais</a>
          </div>
          <div class="col-md-12 playlist-history prev">
            <p class="text-center heading">Música anterior</p>
            <p class="text-center music">Virtual Insanity</p>
            <p class="text-center artist">JAMIROQUAI</p>
          </div>
        </div>
      </div>

</div>

<div class="col-xs-3 col-md-3 ad">
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
</div>



</div>
<a class="fechar"> <img class="fa-close" src="<?php echo $img_url; ?>/fechar-player.png"></a>
<a class="exibicao"><img class="fa-chevron-up" src="<?php echo $img_url; ?>/max-player.png"><img class="fa-chevron-down" src="<?php echo $img_url; ?>/min-player.png"><!-- <i class="fa fa-chevron-up"></i> --><!-- <i class="fa fa-chevron-down"></i> -->  </a>

</div>