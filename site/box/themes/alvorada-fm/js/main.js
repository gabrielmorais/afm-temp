// Fonte: http://pt.stackoverflow.com/questions/44061/usando-jquery-validation-engine-e-valida%C3%A7%C3%A3o-de-cpf
jQuery.validator.addMethod("cpf", function(value, element) {
   value = jQuery.trim(value);

    value = value.replace('.','');
    value = value.replace('.','');
    cpf = value.replace('-','');
    while(cpf.length < 11) cpf = "0"+ cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i=0; i<11; i++){
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
    b = 0;
    c = 11;
    for (y=0; y<10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

    return this.optional(element) || retorno;

}, "Informe um CPF válido");

/**
 * Emulate FormData for some browsers
 * MIT License
 * (c) 2010 François de Metz
 */
(function(w) {
    if (w.FormData)
        return;
    function FormData() {
        this.fake = true;
        this.boundary = "--------FormData" + Math.random();
        this._fields = [];
    }
    FormData.prototype.append = function(key, value) {
        this._fields.push([key, value]);
    }
    FormData.prototype.toString = function() {
        var boundary = this.boundary;
        var body = "";
        this._fields.forEach(function(field) {
            body += "--" + boundary + "\r\n";
            // file upload
            if (field[1].name) {
                var file = field[1];
                body += "Content-Disposition: form-data; name=\""+ field[0] +"\"; filename=\""+ file.name +"\"\r\n";
                body += "Content-Type: "+ file.type +"\r\n\r\n";
                body += file.getAsBinary() + "\r\n";
            } else {
                body += "Content-Disposition: form-data; name=\""+ field[0] +"\";\r\n\r\n";
                body += field[1] + "\r\n";
            }
        });
        body += "--" + boundary +"--";
        return body;
    }
    w.FormData = FormData;
})(window);

window.sr = ScrollReveal();

// Add class to <html> if ScrollReveal is supported
if (sr.isSupported()) {
document.documentElement.classList.add('sr');
}
$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="popover"]').popover();
})

// var playIcon = setInterval(function(){
//   $(".play-icon").toggleClass("hover")
// },1000)



// -->>> Cria clone para reorganizar conteúdo - display controlado via css, ativação via attr data
$("*[data-reorder=true]").each(function(){
 var target = $(this).data("reorder-target"),
        dir = $(this).data("reorder-dir");
        if ($(this).data('reorder-target-id')){
            id = $(this).data('reorder-target-id');
        }else{
          id = "false";
        }

 var clone = $(target).clone("true","true");
 var newid = Math.floor((Math.random() * 168909) + 1);
        $(target).addClass("reorder-original")

        if (dir == "down"){
        clone.insertAfter($(this)).addClass("reorder-clone").find("*[id="+id+"]").each(function(id){
         $(this).attr("id","id"+newid)
        }).find(".carousel-control").each(function(){
          $(this).attr("href","#id"+newid)
        });
      }else{
        clone.insertBefore($(this)).addClass("reorder-clone").find("*[id="+id+"]").each(function(id){
         $(this).attr("id","id"+newid)
        }).find(".carousel-control").each(function(){
          $(this).attr("href","#id"+newid)
        });
      }
})
//--

//----JUKEBOX-----
var player_html = '<div id="jukebox-player"> <div id="jquery_jplayer_1" class="jp-jplayer"></div> <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player"> <div class="jp-type-single"> <div class="jp-gui jp-interface"> <div class="jp-controls"> <button class="jp-play" role="button" tabindex="0">play</button> <!-- <button class="jp-stop" role="button" tabindex="0">stop</button> --> </div> <div class="jp-progress" style="display:none"> <div class="jp-seek-bar"> <div class="jp-play-bar"></div> </div> </div> <div class="jp-volume-controls"> <button class="jp-mute" role="button" tabindex="0">mute</button> <button class="jp-volume-max" role="button" tabindex="0">max volume</button> <div class="jp-volume-bar"> <div class="jp-volume-bar-value"></div> </div> </div> <div class="jp-time-holder" style="display:none"> <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div> <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div> <div class="jp-toggles"> <button class="jp-repeat" role="button" tabindex="0">repeat</button> </div> </div> </div> <div class="jp-details"> <div class="jp-title" aria-label="title">&nbsp;</div> </div> <div class="jp-no-solution"> <span>Update Required</span> To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>. </div> </div> </div> </div>';

$(".jukebox-content input:disabled").next("label").css("visibility","hidden")

$(".player-jukebox .fechar").on("click",function(e){
  e.preventDefault();
  $(".player-jukebox").fadeOut();
  $("#jukebox-player").remove();
})

$(".jukebox-play").on("click",function(e){
  e.preventDefault();

  if ($("#jukebox-player").length > 0){
      $(".player-jukebox").fadeOut();
      $("#jukebox-player").remove();
  }

  var player_jukebox = $(this).parent().parent().find(".player-jukebox");

  $(player_html).insertAfter(player_jukebox.find(".num"));

  player_jukebox.fadeIn();

  var src = $(this).data("src"),
        titulo = $(this).data("title");
  $("#jquery_jplayer_1").jPlayer({
    ready: function () {
      $(this).jPlayer("setMedia", {
        title: titulo,
        mp3: src
      }).jPlayer("play");
    },
    //swfPath: "../../dist/jplayer",// !!!!!change this directory
    supplied: "mp3",
    wmode: "window",
    useStateClassSkin: true,
    autoBlur: false,
    smoothPlayBar: true,
    keyEnabled: true,
    remainingDuration: true,
    toggleDuration: true
  });

  jukebox_status = 1;

})
//----------------------



$(".navbar-toggle").on("click",function(){
  $(".opacity").fadeToggle();
})

// Botão de alternar pesquisa
$(".search-btn").on("click",function(e){
  e.preventDefault();

  if ($(this).hasClass("ativo")){
    $(this).find("i").attr("class", "fa fa-search")
     ///$("div.opacity").fadeOut();
    $(".search-div.first").slideUp(200);
  }else{
    $(this).find("i").attr("class", "fa fa-close")
    //$("div.opacity").fadeIn();
    $(".search-div.first").slideDown(200);
    $(".search-div input").focus();
  }

  $(this).toggleClass("ativo");

});

// Formulário de pesquisa
// Formulário da página de pesquisa e formulários do header
$('form[role="search"]').on('submit', function(e) {
  var form = $(this),
      url = form.prop('action') +'site/?'+ form.serialize();

      //console.log( url ); return false;

  if (parent) {
    e.preventDefault();
    parent.change_url( 'Busca', url );

    // É necesário recarregar a página, o History não pega a alteração da query string

    window.location.reload()
  }
});

// Carousel
$('#myCarousel .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i=0;i<2;i++) {
    next=next.next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }

    next.children(':first-child').clone().appendTo($(this));
  }
});

$(window).load(function(){
  $(window).resize(function(){
    $("header .top").css("width", $("header .bot").width() - $(".navbar-header").width()+"px")
  });

})



$(document).ready(function(){

$(".navbar-collapse li a").on("click",function(){
  if (  $(".navbar-collapse").hasClass("in") ){
    $(".navbar-toggle").trigger("click")
  }
})

var share = {
  init: function() {
    jQuery('.share-link').on('click', function(e) {
      e.preventDefault();
      share.do_share(this);
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

share.init();



var showBanner = setTimeout(function(){
  $(".carousel .item").addClass("initbg");
  clearInterval(showBanner);
},1000)

sr.reveal('.destaques .with-image', { duration: 1500, origin: 'left' }, 50);
sr.reveal('.destaques #slider-destaque', { duration: 1500, origin: 'right' }, 50);
sr.reveal('.destaques .noticia', { duration: 2000 }, 150);

$( '.filtro-programacao' ).on( 'change', function() {
  location.href = $(this).val() ;
} );


if ( $(".megabanner.no-bg-image").length > 0 ){
  $(".megabanner.no-bg-image").css("height", $(".megabanner.no-bg-image").find(".carousel .container>div").height() + 100 + "px")
}



$( '.filtro-conteudo, .filtro-evento' ).on( 'change', function() {

  var current_click_tax = $(this).val();

  if( current_click_tax == 0 ) {
    return false;
  }

  var tax_conteudos = $( '.tax_conteudos' ).val();

  if( tax_conteudos !== undefined ) {
    tax_conteudos = tax_conteudos.split( ',' );
  } else {
    tax_conteudos = [];
  }



  if( $.inArray( current_click_tax, tax_conteudos ) != -1 ) {
    return false;
  } else {
    tax_conteudos.push( $(this).val() );
    window.location.href = $( '.url-conteudo' ).val()+'/?filtros='+tax_conteudos;
  }

} );

$(".lb-info .close").on("click",function(event){
  event.preventDefault();
  $(".lb-info").fadeOut();
})

$( '.remove-filtro-conteudo, .filtro-evento option' ).on( 'click', function( e ) {
  e.preventDefault();
  var tax_conteudos = $( '.tax_conteudos' ).val();

  tax_conteudos = tax_conteudos.split( ',' );

  var current_delete = $(this).data('id');

  function limpaArray( taxonomy ) {
    return parseInt( taxonomy ) != parseInt( current_delete );
  }

  var new_tax_conteudos = tax_conteudos.filter( limpaArray );

  var url_new = $( '.url-conteudo' ).val()+'/?filtros='+new_tax_conteudos.join();

  window.location.href = url_new;

});

$( '.votar-home' ).on( 'click', function() {
    var val = [];
    $('.jukebox-content input[type=checkbox]:checked').each(function(i){
      val[i] = $(this).val();
    });

    var botao_voto = $(this);



    var jukebox = $( this ).data( 'jukebox' );

    if( val.length > 0 ) {


      if( localStorage.votos == undefined ) {
        localStorage.votos = null;
      }

      var votos_cache = localStorage.votos.split(',');

      var votos_ajax = [];

      val.forEach( function( voto ) {
        if( votos_cache.indexOf( voto ) == -1 ) {
          votos_ajax.push( voto );
        }
      } );
    } else {
      botao_voto.attr( 'disabled', false );
      $('.erro-votacao').fadeIn();
      setTimeout(function(){
        $('.erro-votacao').fadeOut();
      }, 2000);
      return false;
    }

    if( votos_ajax.length > 0 ) {

      botao_voto.attr( 'disabled', 'disabled' );
      var data_vote = {
        'action'  : 'send_vote',
        '_nonce'  : enviroment.send_vote_nonce,
        'votes'   : votos_ajax,
        'jukebox' : jukebox
      };
      $.ajax({
        url       : enviroment.xhr_url,
        data      : data_vote,
        type      : 'POST',
        dataType  : 'JSON',
        success: function( response ) {
          $( '.lb-info' ).find( '.msg_head' ).html( 'Obrigado.' );
          $( '.lb-info' ).fadeIn().find( '.msg_body' ).html( 'Voto efetuado com sucesso!' );
          botao_voto.attr( 'disabled', false );
        }
      });
    } else {
      $( '.lb-info' ).find( '.msg_head' ).html( 'Atenção.' );
      $( '.lb-info' ).fadeIn().find( '.msg_body' ).html( 'Você já votou nestas músicas.' );
    }

    localStorage.setItem( 'votos', val );

    atualiza_votos();


} );

function atualiza_votos() {
  if( localStorage.votos != undefined ) {
    if ($( '.musicas_voto input[name=musicas]' ).length>0){
      var musicas_voto = $( '.musicas_voto input[name=musicas]' );

      var votos_cache = localStorage.votos.split(',');

      musicas_voto.each(function() {
        object_id = $( this ).val();

        if( votos_cache.indexOf( object_id ) != -1 ) {
          $( this ).attr( 'disabled', true ).attr( 'checked', true );
        }
      });

    }
  }
  $(".jukebox-content input:disabled").next("label").css("visibility","hidden")
}

atualiza_votos();

$( '.send_sugestao' ).on( 'click', function(evt) {
  evt.preventDefault();

  var botao_sugestao = $(this);

  var sugestao = $( '.sugestao' ).val();

  if( sugestao != '' && sugestao != null ) {

    $.ajax({
      dataType  : 'JSON',
      method     : 'POST',
      url       : enviroment.xhr_url,
      data      : {
        'action' : 'send_sugestao',
        '_nonce' : enviroment.save_sugestao_nonce,
        'sugestao' : sugestao
      },
      crossDomain : true,
      success : function( response ){
        if( response == '200' ) {
          $( '.lb-info' ).find( '.msg_head' ).html( 'Obrigado.' );
          $( '.lb-info' ).fadeIn().find( '.msg_body' ).html( 'Sua sugestão foi enviada com sucesso.' );
          $( '.sugestao' ).val(null);
        }else{
          $( '.erro-sugestao' ).text('Não foi possível enviar a sugestão.').fadeIn();
          setTimeout(function() {
            $('.erro-sugestao').fadeOut();
          }, 2000);
        }
      }
    });
  } else {
    $( '.erro-sugestao' ).text("Digite o nome da música.").fadeIn();
    setTimeout(function() {
      $('.erro-sugestao').fadeOut();
    }, 2000);
  }


});

$("h3.editar-meus-dados").on("click",function(e){
  e.preventDefault();
  $("form.cadastro-logado").slideToggle();
  $(this).find("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down")
})

$("h3.ver-promos").on("click",function(e){
  e.preventDefault();
  $(".lista-promo").slideToggle();
  $(this).find("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down")
})

// Formulário de Fale conosco
var faleConosco = $( '#fale-conosco' );
faleConosco.validate({
  submitHandler: function() {
    var formData = new FormData( faleConosco[0] ),
        subject = faleConosco.find( '.subject option:checked' );

    formData.append('action', 'send_fale');
    formData.append('_nonce', enviroment.send_fale_nonce);
    formData.append('subject', subject.html());
    formData.append('to_email', subject.data('email'));

    $.ajax({
      method      : 'POST',
      url         : enviroment.xhr_url,
      processData : false,  // tell jQuery not to process the data
      contentType : false,  // tell jQuery not to set contentType
      data        : formData,
      success : function( response ){
        if( response == '200' ) {
          $( '.lb-info' ).find( '.msg_head' ).html( 'Obrigado.' );
          $( '.lb-info' ).fadeIn().find( '.msg_body' ).html( 'Seu contato foi enviado com sucesso.' );
          $( '.sugestao' ).val(null);
        } else if( response == '404' ) {
          $( '.lb-info' ).find( '.msg_head' ).html( 'Desculpe.' );
          $( '.lb-info' ).fadeIn().find( '.msg_body' ).html( 'Sua sugestão não foi enviada. Tente novamente mais tarde.' );
          $( '.sugestao' ).val(null);
        }
        return false;
      }
    });
  }
});

// Exibe campo de arquivo se selecionar a opção do currículo
$( '.subject' ).on( 'change', function() {
  var opt = $(this).find(":selected");

  if( opt.data('key') == 'curriculo' ) {
    $( '.curriculo-box' ).show();
  } else {
    $( '.curriculo-box' ).hide();
  }
} )

if ( $(".tax-assunto").length > 0 ){
      jQuery("html,body").animate({
      scrollTop: jQuery(".filtro-programacao").offset().top+"px"
    })
}

$( '.box-acesso-promocao .btn-submit' ).on( 'click', function() {
  if( $( '#resposta_promocao' ).val().length < 1 ) {
    setTimeout( function() {
       $( '.box-acesso-promocao .msg_return' ).fadeOut();
    }, 5000 );
    $( '.box-acesso-promocao .msg_return' ).fadeIn().find('span.inner').html( 'Você deve responder a pergunta acima.' );
    return false;
  }
  if( ! $( '.box-acesso-promocao #option' ).is( ':checked' ) ) {
    setTimeout( function() {
       $( '.box-acesso-promocao .msg_return' ).fadeOut();
    }, 5000 );
    $( '.box-acesso-promocao .msg_return' ).fadeIn().find('span.inner').html( 'Você deve aceit ar os termos para participar.' );
    return false;
  }
} );

$( '.notificar-ganhadores' ).on( 'click', function() {
  var botao_url = $( this ).data( 'url' );
  var promocao = $( this ).data( 'id' );
  if( confirm( 'Deseja mesmo informar estes ganhadores e encerrar a promoção?' ) ) {
    ganhadores = [];

    $( '.ganhador:checked' ).each(function(){
      ganhadores.push( $(this).val() );
    });

    if( ganhadores.length < 1 ) {
      alert( 'Nenhum ganhador selecionado' );
      return false;
    } else {
      window.location.href = botao_url + '?ganhadores=' + ganhadores + '&pro='+ promocao;
    }

  } else {
    return false;
  }
} );

// Formulário de cadastro e alterar dados
  $("select").selectBoxIt({
     theme: "jquerymobile"
  });

});

$(".phone").mask("(99) 9999-9999?9");
$(".cpf").mask("999.999.999-99");
$(".cep").mask("99.999-999");
$(".date-mask").mask("99/99/9999");

$( '#alterar-dados, .cadastro' ).validate({
  ignore:'',
  rules: {
    cpf: { cpf: true, required: true },
    passwd2: {
      equalTo: "#passwd"
    },
  },
  messages: {
    cpf: { cpf: 'CPF inválido' },
    equalTo: "Os valores devem ser iguais."
  },
  errorPlacement: function(error, element) {
    if (element.hasClass('selectBoxIt') ) {
      error.insertAfter( "#" + element.attr('id') + "SelectBoxItContainer" );
    } else {
      error.insertAfter(element);
    }
  }
});

(function() {
    var ev = new $.Event('classadded'),
        orig = $.fn.addClass;
    $.fn.addClass = function() {
        $(this).trigger(ev, arguments);
        return orig.apply(this, arguments);
    }
})();

$('select.selectBoxIt').on('classadded', function(ev, newClasses) {
  var element = $(this),
      box = $( "#" + element.attr('id') + "SelectBoxItContainer" ),
      classes = newClasses.split(' ');

  if ( $.inArray( 'error', classes) != -1 ) {
    box.removeClass('valid').addClass('error');
  }
  else if ( $.inArray( 'valid', classes) != -1 ) {
    box.removeClass('error').addClass('valid');
  }
});

$('#resposta_promocao').keyup(function () {
  var max = 200;
  var len = $(this).val().length;
  if (len >= max) {
    var str_final = $(this).val();
    str_final = str_final.substring(0, max);
    $(this).val( str_final );
    $('#charNum').text(' Você chegou o limite de caracteres').css( 'color', 'red' );
  } else {
    var char = max - len;
    $('#charNum').text(char + ' caracteres restantes').css( 'color', 'white' );
  }
});

if( $( '.table-hover' ).hasClass( 'bolt' ) ) {
  var winners = $('.table-hover').data('winners');

  Math.floor((Math.random() * 10) + 1);


}


$.ajax( {
  'url' : 'http://pucminastempoclima.com.br/previsoes/alvoradaXml',
  'dataType' : 'xml',
  success: function( response ) {
    $( '.max-tempo' ).html( $( response ).find('dt').first().find( 'tmax' ).html() );
    $( '.min-tempo' ).html( $( response ).find('dt').first().find( 'tmin' ).html() );
    var condicao = $( response ).find('dt').first().find( 'condicao' ).html();

    switch(condicao){
      case 'C' : var icone = 'chuva'; break;
      case 'PN': var icone = 'parcialmente-nublado'; break;
      case 'N' : var icone = 'nublado'; break;
      case 'E' : var icone = 'ensolarado'; break;
      case 'PC' : var icone = 'pancadas-de-chuva'; break;
      case 'TC' : var icone = 'chuvas-com-trovoadas'; break;
    }


    $( '#icon-tempo' ).toggleClass(icone)
  },
  error: function(){
      $(".previsao-do-tempo").hide();
  }
} );

// Exibe, ou esconde, o player
$(".alvorada-ao-vivo a, .play-icon-mobile").on("click",function(e){
  e.preventDefault();
  parent.player_total();
});


/*function change_page( url ) {
  $('.mask-total').fadeIn();

  href = url;

  $('#container-frame').load(href+' #teste', function( response ){

    $.getScript( enviroment.WP_SITEURL+'/box/themes/alvorada-fm/js/main.js');

   $('.mask-total').fadeOut();


     jQuery("html,body").animate({
      scrollTop: 0
    })


  });
}*/


