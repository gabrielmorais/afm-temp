
<html lang="pt-BR" prefix="og: http://ogp.me/ns#" class="no-js sr"><head>
  <meta charset="UTF-8">
<meta name="description" content="Você sabe porque ouve">
<meta name="author" content="3bits">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

  <title>Alvorada FM - Você sabe porque ouve</title>


<link rel="stylesheet" id="theme-style-css" href="//<?php echo $_SERVER['HTTP_HOST']?>/site/box/themes/alvorada-fm/assets/css/style.css" type="text/css" media="all">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script type="text/javascript" src="//<?php echo $_SERVER['HTTP_HOST']?>/site/wp-includes/js/jquery/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="//<?php echo $_SERVER['HTTP_HOST']?>/site/box/plugins/historyjs/js/jquery.history.js"></script>
    <script type="text/javascript" src="//<?php echo $_SERVER['HTTP_HOST']?>/site/box/themes/alvorada-fm/js/vendor/jquery.jplayer.min.js"></script>

    <style type="text/css">
     body{
         height: 100%;
         background-image: url("//<?php echo $_SERVER['HTTP_HOST']?>/site/box/themes/alvorada-fm/assets/images/loadsimple.gif");
         background-repeat: no-repeat;
         background-position: center 50px;
         background-size: 150px;
     }
    </style>

</head>


<body>
<!-- deploy update -->
<iframe src="//<?php echo $_SERVER['HTTP_HOST'].'/site'. $_SERVER['REQUEST_URI'] ?>" frameborder="0" id="conteudo" width="100%" style="display: block; height: 100%;"></iframe>

<?php $img_url  = "//".$_SERVER['HTTP_HOST']."/site/box/themes/alvorada-fm/assets/images/";  ?>
<?php include( 'site/box/themes/alvorada-fm/includes/player.php' ); ?>
<?php include( 'site/box/themes/alvorada-fm/includes/lb-info.php' ); ?>

<script>



var share_social = {
  init: function() {
    jQuery('.share-link-social').on('click', function(e) {
      e.preventDefault();
      share_social.do_share(this);
    });
  },
  do_share: function(element) {
    button = jQuery(element);
    url = button.data('url');
    title = button.data('title');
    network = button.data('network');

    switch (network) {
      case 'facebook':
        shareURL = 'http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[url]=' + url;
        break;
      case 'twitter':
        shareURL = 'http://twitter.com/share?url=' + url + '&text=' + title;
        break;
      case 'linkedin':
        shareURL = 'https://www.linkedin.com/shareArticle?mini=true&url=' + url + '&title=' + title + '&summary=&source=';
        break;
    }

    window.open(shareURL, 'sharer', 'toolbar=0,status=0,width=548,height=325');

  }
};

share_social.init();

function generate_date() {
    d = new Date();
    n = d.getTime();
    return n;
};

var player = {
  remanining : 0,
  active: false,
  get_ultimas : function( url ) {
	    if( player.active == false ) {
	      return false;
	    }
	    returns = $.getJSON( 'http://api1.stationbr.com/services/music/playingcomultimas?_='+generate_date(), function() {
    	}).done(function( data ) {
	      current_song = data.list[0];
	      $('.music-name').html( current_song.music );
	      $('.artist-name').html( current_song.artist );
	      $('.img-responsive.cover').attr( 'src', current_song.cover );

	      prev_song = data.list[1];
	      $('.playlist-history.prev .music').html( prev_song.music );
	      $('.playlist-history.prev .artist').html( prev_song.artist );

        // Quando é propaganda, vem com o valor menor que 10
	      if( data.remaining > 10 ) {
	        player.remanining = data.remaining;
	      } else {
	        player.remanining = 10;
	      }
	      player.do_time( ( player.remanining * 1000 ) );

        // Ativa os botões de "tocar mais" e "tocar menos"
        $( '.tocar-mais, .tocar-menos' ).removeClass( 'inactive' )
    	});
  },
  do_time: function( time ) {
    setTimeout(function() {
      player.get_ultimas( player.url_ultimas );
    }, time );
  },
  vote: function( song, artist, yes, no ) {
    if( $( '.tocar-mais, .tocar-menos' ).hasClass( 'inactive' ) ) {
      return false;
    }
    $.ajax({
      'url': enviroment.xhr_url,
      'dataType'  : 'JSON',
      'method'     : 'POST',
      'data': {
        'action' : 'vote_player',
        'song': song,
        'artist': artist,
        'yes' : yes,
        'no' : no,
        '_nonce' : enviroment.vote_player_nonce
      },
      success: function( response ) {
        if( response == 200 ) {
          $( '.lb-info' ).find( '.msg_head' ).html( 'Obrigado.' );
          $( '.lb-info' ).fadeIn().find( '.msg_body' ).html( 'Seu voto foi enviado com sucesso.' );

          // Desativa os botões
          $( '.tocar-mais, .tocar-menos' ).addClass( 'inactive' );
        }
      }
    });
  }
};


$('.tocar-mais').on( 'click', function(evt) {
  evt.preventDefault();
  player.vote( $( '.song-info .music-name' ).html(), $( '.song-info .artist-name' ).html(), 1, 0 );
} );

$('.tocar-menos').on( 'click', function(evt) {
  evt.preventDefault();
  player.vote( $( '.song-info .music-name' ).html(), $( '.song-info .artist-name' ).html(), 0, 1 );
} );



function player_total() {
  if (  $("#player-box").hasClass('minimizado') || $("#player-box").hasClass('maximizado')  ){
      $("#player-box .exibicao").trigger("click");
  }else{
    $("#player-box .player-container").addClass("col-xs-6 col-md-6").removeClass("col-md-12 col-xs-12");
    $("#player-box .col-alvorada-agora").removeClass("col-md-9 col-xs-9").addClass("col-xs-5 col-md-5");
    $("#player-box .col-compartilhe").removeClass("col-md-3 col-xs-3").addClass("col-md-7 col-xs-7");
    $("#player-box .col-cover").show();
    var stream = {
        title: "ABC Jazz",
        mp3: "http://st3.stationbr.com:8000/alvoradafm64?1476390567368.aac"
      },
      ready = false;

    $("#jquery_jplayer_2").jPlayer({
        ready: function (event) {
          ready = true;
          $(this).jPlayer("setMedia", stream);
          $(this).jPlayer("play");
            },
            pause: function() {
              $(this).jPlayer("clearMedia");
            },
            error: function(event) {
              if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
                // Setup the media stream again and play it.
                $(this).jPlayer("setMedia", stream).jPlayer("play");
              }
            },
            swfPath: "../dist/jplayer",
            supplied: "mp3",
            preload: "none",
            wmode: "window",
            useStateClassSkin: true,
            autoBlur: false,
            keyEnabled: true
    });


    $("#player-box").addClass("maximizado");
    $(".jp-play").trigger( 'click' );
    player.active = true;
    setTimeout(function(){
      var height_player = $( '#player-box' ).height();
      $("#conteudo").contents().find("footer").css("margin-bottom",height_player+"px")
    },1000)
    player.get_ultimas( player.url_ultimas );
  }
}

          	$("#player-box .fechar").on("click",function(e){
                    e.preventDefault();
                    $("#player-box").removeClass("maximizado minimizado");
                    //$("#player-box .player-container").removeClass("col-md-9");
                    player.active = false;
                    player.get_ultimas( player.url_ultimas );
                    $("#jquery_jplayer_2").jPlayer("destroy");
                          setTimeout(function(){
                            var height_player = $( '#player-box' ).height();
                            $("#conteudo").contents().find("footer").css("margin-bottom","0px")
                          },1000)
          	})

		$("#player-box .exibicao").on("click",function(e){
		    e.preventDefault();
		    if( $("#player-box").hasClass("maximizado") ){
        		      $("#player-box").attr("class","minimizado")
        		      $("#player-box .player-container").removeClass("col-xs-6 col-md-6").addClass("col-md-12 col-xs-12");
        		      $("#player-box .col-alvorada-agora").removeClass("col-xs-5 col-md-5").addClass("col-md-9 col-xs-9");
        		      $("#player-box .col-compartilhe").addClass("col-md-3 col-xs-3").removeClass("col-md-7 col-xs-7");
        		      $("#player-box .col-cover").hide();

                        	setTimeout(function(){
                        		var height_player = $( '#player-box' ).height();
                        		$("#conteudo").contents().find("footer").css("margin-bottom",height_player+"px")
                        	},1000)
      		    }else{
          		      $("#player-box").attr("class","maximizado");
                          $("#player-box .player-container").addClass("col-xs-6 col-md-6").removeClass("col-md-12 col-xs-12");
          		      $("#player-box .col-alvorada-agora").removeClass("col-md-9 col-xs-9").addClass("col-xs-5 col-md-5");
          		      $("#player-box .col-compartilhe").removeClass("col-md-3 col-xs-3").addClass("col-md-7 col-xs-7");
          		      $("#player-box .col-cover").show();
                    	setTimeout(function(){
                    		var height_player = $( '#player-box' ).height();
                    		$("#conteudo").contents().find("footer").css("margin-bottom",height_player+"px")
                    	},1000)
      		    }
		})

    function change_url( title, url ) {
      History.replaceState(null, title, url );
      jQuery("iframe#conteudo").contents().find("body").attr("id","iframe-loaded") ;
    }


   jQuery(window).load(function(){
     jQuery("iframe#conteudo").contents().find("body").attr("id","iframe-loaded") ;
   })

    // Fecha o box de mensagem de sucesso de voto
    $(".lb-info .close").on("click",function(event){
      event.preventDefault();
      $(".lb-info").fadeOut();
    });


</script>

</body>
</html>