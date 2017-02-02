<?php

// XSS HTTP/HTTPS Sanitization

add_action('init', 'xssHandling');

function xssHandling() {
  foreach(array($_GET, $_POST, $_REQUEST) as $httpConst) XSSSanitization( $httpConst );
}

function XSSSanitization(&$param) {
  if(!is_array( $param ) && is_string( $param ) ) $param = filter_var($param, FILTER_SANITIZE_STRING);
  else if( is_array( $param ) ) foreach( $param as $key => $value ) XSSSanitization( $param[$key] );
}

// MANAGE MENU ----------------------------------
add_action('admin_menu', 'remove_menus');
function remove_menus() {
  remove_menu_page('index.php'); // Dashboard
  remove_menu_page('edit.php'); // Posts
  remove_menu_page('edit-comments.php'); // Comments
}

// SET CUSTOM LOGO TO LOGIN FORM ----------------------------------
add_action( 'login_head', 'custom_login_logo' );
function custom_login_logo() {
  $logo = '__logo-alvorada-fm.png';
  if(!is_null($logo)) {
    echo '<style type="text/css">
      h1 a {
        background-size: 100% auto !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        margin-bottom: 40px !important;
        background-color: #F1F1F1 !important;
        background-blend-mode: multiply !important;
        background-image:url('.get_bloginfo('template_directory').'/assets/images/'.$logo.') !important; }
      </style>';
    }
}

// FIX TOP MENU GAP ----------------------------------
add_action( 'admin_head', 'clean_ui' );
function clean_ui() {
  echo '
    <style type="text/css">
      #adminmenu { margin-top: 0 !important; }
      #adminmenu .wp-first-item { display: none; }
      .wp-menu-separator { display: none !important; }
    </style>
  ';
}

// REMOVE DASHBOARD WIDGETS ----------------------------------
remove_action('welcome_panel', 'wp_welcome_panel'); //remove WordPress Welcome Panel
add_action('admin_init', 'remove_dashboard_widgets');
function remove_dashboard_widgets() {
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // At a Glance
  remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); // Quick Draft
  remove_meta_box('dashboard_primary', 'dashboard', 'core'); // WordPress News
  remove_meta_box('dashboard_secondary', 'dashboard', 'core'); // WordPress News
  remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core'); // Drafts Widget
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'core'); // Incoming Links Widget
  remove_meta_box('dashboard_plugins', 'dashboard', 'core'); // Plugins Widget
}

// DASHBOARD REDIRECT ----------------------------------
add_action( 'wp_dashboard_setup', 'dashboard_redirect' );
function dashboard_redirect() {
  echo "<script>window.location = '/wp-admin/edit.php?post_type=page';</script>";
}

// REMOVE UPDATE NAG ----------------------------------
add_action('admin_menu','wphidenag');
function wphidenag() {
  remove_action( 'admin_notices', 'update_nag', 3);
}

// REMOVE WORDPRESS JUNKS ----------------------------------
remove_action( 'wp_head', 'wp_generator' );     //  wordpress version from header
remove_action( 'wp_head', 'rsd_link' );       // link to Really Simple Discovery service endpoint
remove_action( 'wp_head', 'wlwmanifest_link' );   // link to Windows Live Writer manifest file
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'start_post_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action( 'template_redirect', 'wp_shortlink_header', 11 ); // Remove WordPress Shortlinks from HTTP Headers

// MOVE JAVASCRIPTS FROM HEADER TO FOOTER TO SPEED PAGE LOADING ----------------------------------
// remove_action('wp_head', 'wp_print_scripts');
// remove_action('wp_head', 'wp_print_head_scripts', 9);
// remove_action('wp_head', 'wp_enqueue_scripts', 1);
// add_action('wp_footer', 'wp_print_scripts', 5);
// add_action('wp_footer', 'wp_enqueue_scripts', 2);
// add_action('wp_footer', 'wp_print_head_scripts', 5);


// ENQUEUE STYLES ON HEAD FOR FRONT END. ----------------------------------
add_action( 'wp_enqueue_scripts', 'enqueue_styles_cb', 11 );
if (!function_exists('enqueue_styles_cb')){
  function enqueue_styles_cb() {
    // then load our main stylesheet
    wp_enqueue_style( 'theme-style', CSS_URL . "style.css" );
  }
}

// ENQUEUE SCRIPTS AT THE END FOR FRONT END. ----------------------------------
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_cb' );
if (!function_exists('enqueue_scripts_cb')){
  function enqueue_scripts_cb() {
    if (!is_admin()) {
      // add JavaScript to pages with the comment form to enable threaded comments
      if (is_singular() AND comments_open() AND (get_option('thread_comments') === 1)) {
        wp_enqueue_script('comment-reply');
      }

      // register JavaScript files
      wp_register_script( 'main-js', JS_URL.'app.min.js', false, '1.0', true );

      //load all scripts at once
      wp_enqueue_script( array('main-js' ));
    }
  }
}

function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('new-content');
}

add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );

function admin_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}

add_action('admin_head', 'admin_color_scheme');

/**
 * NONCE / AJAX
 */

add_action( 'wp_enqueue_scripts', 'secure_enqueue_script' );

function secure_enqueue_script() {
  wp_register_script( 'secure-ajax-access', esc_url( add_query_arg( array( 'environment' => 1 ), site_url() ) ) );
  wp_enqueue_script( 'secure-ajax-access' );
}

add_action( 'template_redirect', 'securely_inject_localized_vars' );

function securely_inject_localized_vars() {
  if ( !isset( $_GET[ 'environment' ] ) ) return;

  $localized_vars = array(
    'xhr_url'             => admin_url('admin-ajax.php'),
    'FACEBOOK_APP_ID'     => FACEBOOK_APP_ID,
    'FACEBOOK_TAB_URL'    => FACEBOOK_TAB_URL,
    'FACEBOOK_CANVAS_URL' => FACEBOOK_CANVAS_URL,
    'GA'                  => GA,
    'IMG_URL'             => IMG_URL,
    'WP_SITEURL'          => WP_SITEURL,
    'send_vote_nonce'     => wp_create_nonce('send_vote_nonce'),
    'save_sugestao_nonce' => wp_create_nonce('save_sugestao_nonce'),
    'send_fale_nonce'     => wp_create_nonce('send_fale_nonce'),
    'vote_player_nonce'   => wp_create_nonce('vote_player_nonce'),
    'nonce_name'          => wp_create_nonce('nonce_name') // Create nonce key and add expose it to javascript, duplicate this line for each nonce key needed.
  );

  $localized_var_array = array();
  foreach( $localized_vars as $var => $value ) $localized_var_array[] = esc_js( $var ) . " : '" . esc_js( $value ) . "'";

  header("Content-type: application/x-javascript");
  printf( 'var %s = {%s};', 'enviroment', implode( ',', $localized_var_array ) );
  exit;
}

add_ajax_nonce_action('send_vote');
add_ajax_nonce_action('send_sugestao');
add_ajax_nonce_action('send_fale');
add_ajax_nonce_action('cadastro_usuario');
add_ajax_nonce_action('alteracao_dados_usuario');
add_ajax_nonce_action('vote_player');

/**
 * Add two actions for each custom action request using nonce validation
 * @param String $action The name of custon action
 * @return Void
 */
function add_ajax_nonce_action($action) {
  add_action('wp_ajax_nopriv_'.$action, $action);
  add_action('wp_ajax_'.$action, $action);
}

/**
 * Custom action for handle xhr request using nonce validation
 * @return Void
 */
function action_name() {
  check_ajax_referer( 'nonce_name', 'nonce' ); // First argument is nonce variable name coming from xhr request and the second always is nonce.
  die();
}


// Pre get para promoções
function pre_get_promocoes( $query ) {
    if ( $query->is_main_query() && $query->is_post_type_archive( 'promocao' ) && ! is_admin() ) {
      $meta_query = array(
        array(
          'key' => 'data_final_promocao',
          'value' => date( 'Y-m-d', strtotime( '-30 days' ) ),
          'compare' => '>',
          'type' => 'DATE'
        )
      );

      $query->set( 'meta_query', $meta_query );
      $query->set( 'posts_per_page', 8 );

      $query->set( 'orderby', 'status' );
      $query->set( 'order', 'DESC' );
    }
}
add_action( 'pre_get_posts', 'pre_get_promocoes' );

// Pre get para Conteúdos
function pre_get_conteudos( $query ) {
    if ( $query->is_main_query() && $query->is_post_type_archive( 'conteudo' ) && ! is_admin() ) {
      if( isset( $_GET['filtros'] ) && ! empty( $_GET['filtros'] ) ) {
        $filtros = explode( ',', $_GET['filtros'] );


        $tax_query = array(
          array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $filtros
          )
        );

        $query->set( 'tax_query', $tax_query );

      }

      $query->set( 'posts_per_page', 8 );

      if( isset( $_GET['col'] ) && ! empty( $_GET['col'] ) ) {

        $query->set( 'meta_key', 'colunista' );
        $query->set( 'meta_value', $_GET['col'] );
        $query->set( 'posts_per_page', -1 );
      }

    }
}
add_action( 'pre_get_posts', 'pre_get_conteudos' );


// Pre get para programação
function pre_get_programacao( $query ) {

    if ( $query->is_main_query() && $query->is_post_type_archive( 'programacao' ) && ! is_admin() ) {

      if( isset( $_GET['col'] ) && ! empty( $_GET['col'] ) ) {

        $query->set( 'meta_key', 'apresentador' );
        $query->set( 'meta_value', $_GET['col'] );
        $query->set( 'posts_per_page', -1 );
      }

    }
}
add_action( 'pre_get_posts', 'pre_get_programacao' );

// Pre get para Eventos
function pre_get_eventos( $query ) {
    if ( $query->is_main_query() && $query->is_post_type_archive( 'evento' ) && ! is_admin() ) {
      if( isset( $_GET['filtros'] ) && ! empty( $_GET['filtros'] ) ) {
        $filtros = explode( ',', $_GET['filtros'] );


        $tax_query = array(
          array(
            'taxonomy' => 'categoria',
            'field' => 'term_id',
            'terms' => $filtros
          )
        );

        $query->set( 'tax_query', $tax_query );

      }

      global $wpdb;

      $rows = $wpdb->get_results($wpdb->prepare(
          "
          SELECT PT.ID
          FROM {$wpdb->prefix}posts PT
          INNER JOIN {$wpdb->prefix}postmeta PM ON PT.ID = PM.post_id
          WHERE PM.meta_key LIKE %s
              AND CAST(PM.meta_value AS DATE) >= CURDATE()
              AND PT.post_type = 'evento'
          AND PT.post_status = 'publish'
          GROUP BY PT.ID
          ",
          'datas_%_data'
      ));


      foreach ($rows as $value) {
        $posts_in[] = $value->ID;
      }

      if( empty( $posts_in ) ) {
        $posts_in = array( -20000 );
      }

      $query->set( 'post__in', $posts_in );
      $query->set( 'posts_per_page', 8 );

    }
}
add_action( 'pre_get_posts', 'pre_get_eventos' );

function send_vote() {
  if( ! wp_verify_nonce( $_POST['_nonce'], 'send_vote_nonce' ) ) {
    exit( '403' );
  }

  $jukebox = $_POST['jukebox'];

  $votes = array(
    'jukebox' => $_POST['jukebox']
  );

  $musicas_db = get_field( 'field_57c475745eb1a', $jukebox );

  foreach( $musicas_db as $key => $musica ) {
    if( in_array( $musica['id'], $_POST['votes'] ) ) {
      $musica['votos'] = ( $musica['votos'] + 1 );
    }
    unset( $musica['arquivo'] );
    $new_musicas[] = $musica;
  }

  update_field( 'field_57c475745eb1a', $new_musicas, $jukebox );

  exit('200');
}

function custom_admin_js() {
    echo '"<script type="text/javascript">

    jQuery(document).ready(function() {
      jQuery("td[data-name=votos] input").attr("readonly", true);
    });

    </script>"';

    $url = THEME_URL.'/admin/js/shortcodes-regulamento.js';
    echo '"<script type="text/javascript" src="'. $url . '"></script>"';
    $url = THEME_URL.'/admin/js/shortcodes-box_promocao.js';
    echo '"<script type="text/javascript" src="'. $url . '"></script>"';

}
add_action('admin_footer', 'custom_admin_js');

function send_sugestao() {
  if( ! wp_verify_nonce( $_POST['_nonce'], 'save_sugestao_nonce' ) ) {
    exit( '403' );
  }

  $to = 'artistico@alvoradafm.com.br';
  $subject = 'Sugestão de música enviada pelo site';
  $body = utf8_decode( '<p>Sugestão: '. $_POST['sugestao'] .'</p>' ); 
  $headers = array();

  $template = include( 'includes/emails/emkt-sugestaodemusica.php' );
  $message = utf8_encode($template);

  // $headers[] = 'Contato Avlvorada <contato@alvoradafm.com.br>';
  // $headers[] = 'Cc: Alvorada FM <alvorada@alvoradafm.com.br>';

  if( wp_mail( $to, $subject, $message, $headers ) ) {
    echo '200';
  } else {
    echo '500';
  }

  exit;

}

function send_fale() {
  if( ! wp_verify_nonce( $_POST['_nonce'], 'send_fale_nonce' ) ) {
    exit('403');
  }

  $action = $_POST['action'];
  $_nonce = $_POST['_nonce'];
  $nome = $_POST['nome'];
  $sobrenome = $_POST['sobrenome'];
  $email = $_POST['email'];
  $cidade = $_POST['cidade'];
  $estado = $_POST['estado'];
  $subject = $_POST['subject'];
  $to = $_POST['to_email'];
  $mensagem = $_POST['mensagem'];
  $curriculo = $_FILES['curriculo'];

  $body = <<<HEREDOC
    <p><b>Nome</b>: {$nome} {$sobrenome}</p>
    <p><b>E-mail</b>: {$email}</p>
    <p><b>Cidade</b>: {$cidade} - {$estado}</p>
    <p><b>Mensagem</b>: {$mensagem}</p>

HEREDOC;

  $attachment_id = media_handle_upload( 'curriculo', 0 );
  if ( !is_wp_error( $attachment_id ) ) {
    $url = wp_get_attachment_url( $attachment_id );
    $body .= '<p>'. utf8_decode( 'Arquivo do currículo' ) .':</p><p><a href="'. $url .'" target="_blank">Download</a></p>';
  }

  $template = include( 'includes/emails/emkt-faleconosco.php' );
  $message = utf8_encode($template);

  wp_mail( $to, $subject, $message );
  exit('200');
}

// Votação do Player
function vote_player() {
  if( ! wp_verify_nonce( $_POST['_nonce'], 'vote_player_nonce' ) ) {
    exit( '403' );
  }

  $votes = get_field( 'player_vote', 'option' );
  $votes = json_decode( $votes, 1 );

  if( ! empty( $votes ) ) {
    $new_array = $votes;
  }

  if( $_POST['yes'] == 1 ) {
    $current_vote = array( $_POST['song'], $_POST['artist'], 1, 0 );
  } else {
    $current_vote = array( $_POST['song'], $_POST['artist'], 0, 1 );
  }

  //$votes[] = $current_vote;
  $new_array[] = $current_vote;

  update_field( 'player_vote', json_encode( $new_array ), 'option' );

  echo 200;

  exit;
}

// Verifica se o usuário está na edição de páginas. Quando o usuário não é admin, ele cai
// nesssa página após o login e recebe a mensagem "Trapaceando, é? Sem permissão para
// editar posts deste tipo de post."
add_action('admin_init', function () {
  global $pagenow;

  if( $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'page' ) {
    $roles = wp_get_current_user()->roles;

    // Colunista e Jornalista
    if ( in_array('colunista', $roles) || in_array('jornalismo', $roles) ) {
      wp_redirect( admin_url('/edit.php?post_type=conteudo', 'http'), 301 );
      exit;
    }

    // Artístico
    if ( in_array('artistico', $roles) ) {
      wp_redirect( admin_url('/edit.php?post_type=musica', 'http'), 301 );
      exit;
    }
  }
} );

// Relatórios de Promoção -------------------------
include_once 'includes/relatorios_promocoes.php';
//-------------------------------------------------

// Relatórios de Músicas --------------------------
include_once 'includes/relatorios_musicas.php';
//-------------------------------------------------

// Relatórios da Playlist -------------------------
include_once 'includes/relatorios_playlist.php';
//-------------------------------------------------

// PDFs da Promoção -------------------------------
include_once 'includes/promocao_pdf.php';
//-------------------------------------------------

// PDFs da Promoção -------------------------------
include_once 'includes/cadastro_usuario.php';
//-------------------------------------------------
