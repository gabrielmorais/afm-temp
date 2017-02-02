<?php

// ADD META TAGS ON THE HEADER ----------------------------------
add_action( 'theme_meta', 'meta_cb' );
if (!function_exists('meta_cb')){
  function meta_cb(){
    echo "<meta charset='".get_bloginfo('charset')."'>\n";
    echo "<meta name='description' content='".get_bloginfo('description')."'>\n";
    echo "<meta name='author' content='3bits'>\n";
    echo "<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>\n";
    echo "<meta name='viewport' content='initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />\n";
    //echo "<meta name='viewport' content='width=1024' />\n"; // for testing purpose
  }
}
//load meta in header section by calling theme_meta()
function theme_meta(){
  do_action('theme_meta');
}


// FILTER wp_title() FOR BETTER SEO ----------------------------------
add_filter( 'wp_title', 'theme_wp_title', 10, 2 );
if(!function_exists('theme_wp_title')){
  function theme_wp_title( $title, $sep) {

    global $paged, $page;
    
    if ( is_feed() ) return $title;
    // Add the site name.
    $name = get_bloginfo( 'name' );
    
    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    
    // find the type of index page this is
    if ( $site_description && ( is_home() || is_front_page() ) ) $title = "$title $name $sep $site_description";
    elseif( is_category() ) $title = "$title Category $sep $name";
    elseif( is_tag() ) $title = "$title Tag $sep $name";
    elseif( is_author() ) $title = "$title  Author $sep $name";
    elseif( is_year() || is_month() || is_day() ) $title = "$title Archives $sep $name";
    else $title = "$title $name $sep $site_description";  
    
    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
      $title = "$title $name $sep " . sprintf( __( 'Page %s', TX_DOMAIN ), max( $paged, $page ) );
    
    return $title;
     
  }
}

$args_pagina_principal = array(
  'page_title' => 'Página principal',
  'capability' => 'edit_posts'
);
acf_add_options_page( $args_pagina_principal );

$args_publicidade = array(
  'page_title' => 'Publicidade',
  'capability' => 'edit_posts'
);
acf_add_options_page( $args_publicidade );

$args_configuracoes = array(
  'page_title' => 'Configurações do site',
  'capability' => 'edit_posts'
);
acf_add_options_page( $args_configuracoes );


add_theme_support( 'menus' );

add_image_size( 'destaque-listagem', 360, 271, array( 'center', 'center' ) ); 
add_image_size( 'musica-home', 360, 395, array( 'center', 'center' ) ); 
add_image_size( 'conteudo-home', 750, 395, array( 'center', 'center' ) ); 
add_image_size( 'avatar-colunista', 300, 300, array( 'center', 'center' ) ); 
add_image_size( 'listagem-programa', 696, 339, array( 'center', 'center' ) ); 
add_image_size( 'listagem-conteudo', 565, 423, array( 'center', 'center' ) ); 

add_shortcode('promocao_box', 'box_promocoes_interna');

function box_promocoes_interna() {
  ob_start();
  include THEME_PATH . '/includes/box-promocoes.php';
  $file = ob_get_contents();
  ob_end_clean();
  return $file;
}

add_shortcode('regulamento', 'regulamento');

function regulamento() {
  ob_start();
  include THEME_PATH . '/includes/regulamento.php';
  $file = ob_get_contents();
  ob_end_clean();
  return $file;
}

add_shortcode('promocao', 'promocao');

function promocao( $atts ) {
  ob_start();
  include THEME_PATH . '/includes/promocao.php';
  $file = ob_get_contents();
  ob_end_clean();
  return $file;
}

// Remove a categoria "Sem categoria" da listagem
function get_the_term_list_without_uncategorized( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {
    $terms = get_the_terms( $id, $taxonomy );
    $uncategorized = 1;
 
    if ( is_wp_error( $terms ) )
        return $terms;
 
    if ( empty( $terms ) )
        return false;
 
    $links = array();
 
    foreach ( $terms as $term ) {
        if ($term->term_id != $uncategorized) {
          $link = get_term_link( $term, $taxonomy );
          if ( is_wp_error( $link ) ) {
              return $link;
          }
          $links[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';
        }
    }
 
    /**
     * Filters the term links for a given taxonomy.
     *
     * The dynamic portion of the filter name, `$taxonomy`, refers
     * to the taxonomy slug.
     *
     * @since 2.5.0
     *
     * @param array $links An array of term links.
     */
    $term_links = apply_filters( "term_links-{$taxonomy}", $links );
 
    return $before . join( $sep, $term_links ) . $after;
}

// Lista todas as categorias, mas sem a categoria "Sem categoria"
function the_terms_without_uncategorized( $id, $taxonomy, $before = '', $sep = ', ', $after = '' ) {
    $term_list = get_the_term_list_without_uncategorized( $id, $taxonomy, $before, $sep, $after );
 
    if ( is_wp_error( $term_list ) )
        return false;

    /**
     * Filters the list of terms to display.
     *
     * @since 2.9.0
     *
     * @param array  $term_list List of terms to display.
     * @param string $taxonomy  The taxonomy name.
     * @param string $before    String to use before the terms.
     * @param string $sep       String to use between the terms.
     * @param string $after     String to use after the terms.
     */
    echo apply_filters( 'the_terms', $term_list, $taxonomy, $before, $sep, $after );
}

// Banner de publicidade do Google
function alvorada_google_ad( $width=263, $height=250 ) {

?>

    <script type="text/javascript">
      google_ad_client = "ca-pub-7312481615032270";
      google_ad_slot = "4064446148";
      google_ad_width = <?php echo $width; ?>;
      google_ad_height = <?php echo $height; ?>;
    </script>

    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>

<?php

}

// Retorna um objeto com todos os dados do usuário Alvorada
function alvorada_get_user( $userID ) {
  static $users = array();
  if ( isset($users[ $userID ]) ) {
    return $users[ $userID ];
  }

  $args = array(
    'include' => array($userID),
    'fields' => array('ID', 'user_login', 'user_email', 'user_nicename', 'display_name')
  );
  $rawUser = get_users( $args );
  if (!$rawUser) {
    return;
  }

  $user = $rawUser[0];
  $meta = get_user_meta( $user->ID );
  if ($meta['email'] && count($meta['email'])) {
    $user->user_email = (string) $meta['email'][0];
  }

  $fields = array('nome', 'sobrenome', 'email', 'sexo', 'cpf', 'nascimento', 'endereco', 'cidade', 'cep', 'estado', 'telefone', 'celular');
  foreach ($fields as $key) {
    $user->$key = (string) count($meta[ $key ]) ? $meta[ $key ][0] : '';
  }

  $users[ $userID ] = $user;
  return $user;
}

// Retorna um objeto com todos os dados do usuário Alvorada mais as promoções que já participou
function alvorada_get_user_promocao( $userID ) {
  $user = alvorada_get_user( $userID );
  if ( $user && !$user->promocoes ) {
    $user->promocoes = get_minhas_promocoes( $userID );
  }
  return $user;
}

// Retorna uma lista de participantes válidos
function alvorada_participantes_validos( $participantes, $promocaoID ) {
  $lista = array();
  foreach ($participantes as $participante) {
    $valido = alvorada_valido( $participante, $promocaoID, $erro );
    if ($valido) {
      $lista[ $participante->ID ] = $participante;
    }
  }
  return $lista;
}

// Verifica se o participantes é válido. Estão aptos a serem sorteados na promoção pessoas que:
//  - Não ganharam nos últimos 3 meses
//  - Possuem cadastro com e-mail e telefone atualizados
//  - CPF válido.
function alvorada_valido( $participante, $promocaoID, &$erro=NULL ) {
  $erro = "";

  // Telefone válido
  if ( !$participante->celular ) {
    $erro = "Celular inválido {$participante->celular}";
    return false;
  }

  // E-mail válido
  if ( !$participante->user_email || !is_email( $participante->user_email ) ) {
    $erro = "E-mail inválido {$participante->user_email}";
    return false;
  }

  // CPF Válido
  if ( !validaCPF( $participante->cpf ) ) {
    $erro = "CPF inválido {$participante->cpf}";
    return false;
  }
  
  // Não ganhou nos últimos 3 meses
  if ( ganhou_ultimos_meses($participante, $promocaoID) ) {
    $erro = "Ganhou nos últimos meses";
    return false;
  }

  return true;
}

// Verifica se o usuário ganhou alguma promoção nos últimos {$numMonths} meses, ignorando a que está participando atualmente
function ganhou_ultimos_meses( $participante, $promocaoAtual, $numMonths=3 ) {
  $monthsAgo = strtotime( "-{$numMonths} month" );
  $userID = $participante->ID;

  // Verifica todas as promoções
  foreach ($participante->promocoes as $id => $promocao) {
    $post = $promocao->post;

    // Verifica se é a promoção atual
    if ( $post->ID == $promocaoAtual ) {
      continue;
    }

    // Verifica se é uma promoção válida
    if ( $promocao->status == 'encerrada' && count($promocao->ganhadores) ) {
      $ganhadores = $promocao->ganhadores;
      $encerramento = $promocao->encerramento;
      $ganhou = in_array( $userID, $ganhadores );

      // Se o participante ganhou e a data de encerramento é menor que 3 meses atrás
      if ($ganhou && $encerramento > $monthsAgo) {
        return true;
      }
    }
  }

  return false;
}

// Retorno padronizado dos relatorios
function alvorada_fn_return( $name, $data ) {
  $date = date('d-m-Y');
  $filename = "{$name}-{$date}.csv";

  return (object) array(
    'data' => $data,
    'filename' => $filename
  );
}

// Força o conteúdo do CSV para Download
function alvorada_dump_csv( $result ) {
  header("Content-type: application/x-msdownload", true, 200);
  header("Content-Disposition: attachment; filename={$result->filename}");
  header("Pragma: no-cache");
  header("Expires: 0");

  print( $result->data );
}

// Valida um CPF
// Fonte: http://www.geradorcpf.com/script-validar-cpf-php.htm
function validaCPF( $cpf=null ) {
 
    // Verifica se um número foi informado
    if(empty($cpf)) {
        return false;
    }
 
    // Elimina possivel mascara
    $cpf = ereg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
     
    // Verifica se o numero de digitos informados é igual a 11 
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências invalidas abaixo 
    // foi digitada. Caso afirmativo, retorna falso
    else if ($cpf == '00000000000' || 
        $cpf == '11111111111' || 
        $cpf == '22222222222' || 
        $cpf == '33333333333' || 
        $cpf == '44444444444' || 
        $cpf == '55555555555' || 
        $cpf == '66666666666' || 
        $cpf == '77777777777' || 
        $cpf == '88888888888' || 
        $cpf == '99999999999') {
        return false;
     // Calcula os digitos verificadores para verificar se o
     // CPF é válido
     } else {   
         
        for ($t = 9; $t < 11; $t++) {
             
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
 
        return true;
    }
}

// Valida um CPF e verifica se é único
function validoUnicoCPF( $cpf ) {
  if ( !validaCPF( $cpf ) ) {
    return false;
  }

  $user_query = new WP_User_Query( array( 'meta_key' => 'cpf', 'meta_value' => $cpf ) );
  return empty( $user_query->results );
}

// Debuga uma ou mais variáveis
if ( ! function_exists( 'dump' ) ) {
  function dump() {
    $args = func_get_args();
    echo "<pre>";
    foreach ($args as $arg) {
      print_r($arg);
      echo ' ';
    }
    echo "</pre>";
  }
}

// Debuga uma ou mais variáveis e para a execução
if ( ! function_exists( 'ddump' ) ) {
  function ddump() {
    $args = func_get_args();
    call_user_func_array('dump', $args);
    die();
  }
}

// Envia e-mail para os ganhadores
function alvorada_email_ganhadores( $lista, $promocaoID ) {
  $promocao = alvorada_get_promocao( $promocaoID );
  foreach($lista as $userID) {
    $ganhador = alvorada_get_user( $userID );
    $to = $ganhador->user_email;
    $subject = $promocao->post->post_title .' - Alvorada FM';
    $nome = $ganhador->user_nicename;
    $body = utf8_decode( $promocao->email_ganhador );
    $template = include( 'includes/emails/emkt-ganhador.php' );
    $message = utf8_encode($template);

    wp_mail( $to, $subject, $message );
  }
}

// Envia e-mail para o novo usuário
function alvorada_email_novo( $user_id ) {
  $user = get_userdata( $user_id );
  $user_email = stripslashes($user->user_email);
  $nome = get_field( 'nome', "user_{$user_id}" );
  $nome = $nome ? utf8_decode($nome) : stripslashes($user->user_nicename);
  $template = include( 'includes/emails/emkt-cadastro.php' );
  $message = utf8_encode( $template );
  $subject = 'Cadastro no Espaço Alvorada';

  wp_mail($user_email, $subject, $message);
}

//* Password reset activation E-mail -> Body
add_filter( 'retrieve_password_message', 'wpse_retrieve_password_message', 10, 2 );
function wpse_retrieve_password_message( $message, $key ){
    $user_data = '';
    // If no value is posted, return false
    if( ! isset( $_POST['user_login'] )  ){
            return '';
    }
    // Fetch user information from user_login
    if ( strpos( $_POST['user_login'], '@' ) ) {
        $user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }
    if( ! $user_data  ){
        return '';
    }

    $user = alvorada_get_user( $user_data->ID );
    $user_login = $user->user_login;
    
    $nome = $user->nome;
    $url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    $template = include( 'includes/emails/emkt-perdeusenha.php' );

    return $template;
}
