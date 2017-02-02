<?php

// Escapando todos os helpers do WordPress
add_filter('the_content', 'wp_kses_post');
add_filter('the_title', 'esc_html');
add_filter('the_excerpt', 'esc_html');
add_filter('the_permalink', 'esc_url');

add_filter('get_the_content', 'wp_kses_post');
add_filter('get_the_title', 'esc_html');
add_filter('get_the_excerpt', 'esc_html');
add_filter('get_the_permalink', 'esc_url');

function clear_nbsp($content){
  return str_replace("<p>&nbsp;</p>","", $content);
}

add_filter('the_content', 'clear_nbsp');

// Allow iframe tags within editor
function allow_multisite_tags( $multisite_tags ){
    $multisite_tags['iframe'] = array(
        'src' => true,
        'width' => true,
        'height' => true,
        'align' => true,
        'class' => true,
        'name' => true,
        'id' => true,
        'frameborder' => true,
        'seamless' => true,
        'srcdoc' => true,
        'sandbox' => true,
        'allowfullscreen' => true
    );
    return $multisite_tags;
}
add_filter('wp_kses_allowed_html','allow_multisite_tags', 1);

// Allow HTML emails
add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

function remove_footer_admin () {
  echo 'Nome do cliente - Todos direitos reservados';
}

add_filter('admin_footer_text', 'remove_footer_admin');

add_filter( 'update_footer', 'change_footer_version', 9999 );

function change_footer_version() {
  return '1.0';
}

// remove Admin bar
add_filter('show_admin_bar', 'show_admin_bar_cb');
if ( ! function_exists( 'show_admin_bar_cb' ) ) {
  function show_admin_bar_cb(){
    return false;
  }
}

// REMOVE VERSION NUMBERS FROM CSS AND JS SRC ----------------------------------
add_filter( 'style_loader_src', 'wp_remove_versions', 9999 );
add_filter( 'script_loader_src', 'wp_remove_versions', 9999 );
function wp_remove_versions( $src ) {
  if ( strpos( $src, 'ver=' ) ) {
    $src = remove_query_arg( 'ver', $src );
  }
  return $src;
}

// REMOVE VERSION NUMBERS FROM ALL HTML, COMMENTS AND TAGS IN HEAD ----------------------------------
add_filter( 'get_the_generator_html', '__return_false' );
add_filter( 'get_the_generator_xhtml', '__return_false' );
add_filter( 'get_the_generator_atom', '__return_false' );
add_filter( 'get_the_generator_rss2', '__return_false' );
add_filter( 'get_the_generator_rdf', '__return_false' );
add_filter( 'get_the_generator_comment', '__return_false' );
add_filter( 'get_the_generator_export', '__return_false' );


function register_button( $buttons ) {
   array_push( $buttons, "|", "regulamento" );
   array_push( $buttons, null, "box_promocao" );
   return $buttons;
}
function add_plugin( $plugin_array ) {
   $plugin_array['regulamento'] = get_template_directory_uri() . '/admin/js/shortcodes-regulamento.js';
   $plugin_array['box_promocao'] = get_template_directory_uri() . '/admin/js/shortcodes-box_promocao.js';
   return $plugin_array;
}

function my_recent_posts_button() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'add_plugin' );
      add_filter( 'mce_buttons', 'register_button' );
   }

}
add_action('init', 'my_recent_posts_button');



add_filter('manage_promocao_posts_columns', 'bs_promocao_table_head');
function bs_promocao_table_head( $defaults ) {
    $defaults['promocao']  = 'Sortear';
    $defaults['relatorio']  = 'Relatório';
    return $defaults;
}

add_action( 'manage_promocao_posts_custom_column', 'bs_promocao_table_content', 10, 2 );

function bs_promocao_table_content( $column_name, $post_id ) {
    if ($column_name == 'promocao') {
      echo '<a href="'. str_replace('/site', '', get_permalink( get_page_by_title( "Sorteio" ) ) ) ."?pro=".$post_id . '" class="button" target="_blank">Sorteio</a>';
    }
    if ($column_name == 'relatorio') {
      echo '<a href="'. admin_url( "admin-post.php?action=print.csv&type=todos-cadastrados&promocaoID={$post_id}" ) . '" class="button" target="_blank">Gerar relatório</a>';
    }

}

// A ordenação da listagem de programação deve ser por ordem alfabética.
add_action( 'pre_get_posts', 'alvorada_pre_get_posts'); 
function alvorada_pre_get_posts($query) {
  if( is_post_type_archive( 'programacao' ) ):
    $query->set( 'order', 'ASC' );
    $query->set( 'orderby', 'title' );
  endif;    
};
