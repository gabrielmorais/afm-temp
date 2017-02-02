jQuery( document ).ready( function() {
   if( jQuery('.mce-panel').length > 0 ) {
       (function() {
         tinymce.create('tinymce.plugins.box_promocao', {
            init : function(ed, url) {
               ed.addButton('box_promocao', {
                  title : 'Inserir box_promocao na página',
                  image : 'http://vignette3.wikia.nocookie.net/mafiawars/images/7/7f/Icon_experience_16x16.png/revision/latest?cb=20100817190232',
                  onclick : function() {
                     ed.execCommand('mceInsertContent', false, '[promocao_box]');
                  }
               });
            },
            createControl : function(n, cm) {
               return null;
            },
            getInfo : function() {
               return {
                  longname : "Adicionar Box de promoções",
                  author : 'Guilherme Braune Brero',
                  authorurl : 'http://3bits.net',
                  infourl : '',
                  version : "1.0"
               };
            }
         });
         tinymce.PluginManager.add('box_promocao', tinymce.plugins.box_promocao);
      })();  
   }
})

