<?php

// Callback para o cadastro do usuário
function cadastro_usuario() {
  if( ! wp_verify_nonce( $_POST['cadastro_usuario_nonce'], 'cadastro_usuario' ) ) {
    exit('Erro de validação contra robô. Tente novamente');
  }

  // Monta uma lista de campos para passar para a URL, caso haja erro
  $query = array();
  $fields = array('nome', 'sobrenome', 'email', 'sexo', 'cpf', 'nascimento', 'endereco', 'cidade', 'cep', 'estado', 'telefone', 'celular');
  foreach($fields as $field) {
    $query[$field] = $_POST[$field];
  }

  // Verifica CPF
  $cpf = $_POST['cpf'];
  if ( ! validoUnicoCPF( $cpf ) ) {
    $query['erro'] = 'CPF já foi utilizado';
    return cadastro_usuario_redirect( $query );
  }

  // Verifica o e-mail
  $email = $_POST['email'];
  if ( email_exists( $email ) ) {
    $query['erro'] = 'Este e-mail já foi utilizado!';
    return cadastro_usuario_redirect( $query );
  }

  // Tenta inserir o usuário
  $userdata = array(
      'user_login'   => $_POST['email'],
      'user_email'   => $_POST['email'],
      'user_pass'    => $_POST['password'],
      'first_name'   => $_POST['nome'],
      'last_name'   => $_POST['sobrenome'],
      'display_name' => "{$_POST['nome']} {$_POST['sobrenome']}"
  );
  $result = wp_insert_user( $userdata ) ;

  // Verifica se é erro e retorna para a tela de cadastro com a mensagem de erro
  if ( is_wp_error( $result ) ) {
    $errors = $result->errors;
    $message = '';
    foreach( $errors as $key => $error ) {
      $message .= join(' ', $error) ." ";
    }
    $query['erro'] = $message;
    return cadastro_usuario_redirect( $query );
  }

  //On success
  $user_id = $result;
  foreach($fields as $field) {
    update_field( $field, $_POST[$field], "user_{$user_id}" );
  }

  // Cria data de alteração de dados
  update_field( 'data_dados_cadastrais', time(), "user_{$user_id}" );

  // Envia e-mail de boas-vindas
  alvorada_email_novo( $user_id );

  // Loga e Redireciona para o Espaço Alvorada
  $creds = array(
    'user_login'    => $_POST['email'],
    'user_password' => $_POST['password']
  );
  wp_signon( $creds, false );
  cadastro_usuario_redirect();
}

// Callback para a alteração dos dados do usuário
function alteracao_dados_usuario() {
  if( ! wp_verify_nonce( $_POST['alteracao_dados_usuario_nonce'], 'alteracao_dados_usuario' ) ) {
    exit('Erro de validação contra robô. Tente novamente');
  }

  $user_id = get_current_user_id();

  if( isset( $_POST['email'] ) && ! empty( $_POST['email'] ) ) {
    // Os campos de CPF e Nome nunca poderão ser atualizados, então eles estarão ‘desativados’ na página de edição. 
    $fields = array('sexo', 'nascimento', 'endereco', 'cidade', 'cep', 'estado', 'telefone', 'celular');
    foreach($fields as $field) {
      update_field( $field, $_POST[$field], "user_{$user_id}" );
    }

    // Atualiza o e-mail
    if( ! empty( $_POST['email'] ) ) {
      update_field( 'email', $_POST['email'], "user_{$user_id}" );
      wp_update_user( array( 'ID' => $user_id, 'user_email' => $_POST['email'] ) );
    }

    // Atualiza a senha
    if( ! empty( $_POST['password'] ) && ( $_POST['password'] == $_POST['passwd2'] ) ) {
      // wp_set_password( $_POST['password'], $user_id ); Este código desconecta o usuário
      $userdata['ID'] = $user_id; 
      $userdata['user_pass'] = $_POST['password'];
      wp_update_user( $userdata );
    }

    // Atualiza data de alteração de senha
    update_field( 'data_dados_cadastrais', time(), "user_{$user_id}" );

    cadastro_usuario_redirect( array( 'mensagem' => 'Dados atualizados com sucesso!' ));
  }
}

// Verifica a data de alteração de dados
// A cada 6 meses, quando o usuário logar, o site irá solicitar que ele atualize os dados cadastrais: e-mail, endereço e telefone.
function alvorada_dados_alterados() {
  $user_id = get_current_user_id();
  $months = strtotime("-6 months");
  $date = get_field( 'data_dados_cadastrais', "user_{$user_id}" );
  return $months > $date;
}

// Redireciona o usuário
function cadastro_usuario_redirect( $query='' ) {
  if ( $query ) {
    $query = '?' . http_build_query( $query );
  }

  $url = get_bloginfo( 'url' ) . '/espaco-alvorada/' . $query;
  wp_redirect( $url );
  exit;
}

// Formulário de cadastro e alteração de dados do usuário
function alvorada_formulario_usuario( $data=NULL, $alterar=false ) {
  if ($data == NULL || !is_array($data)) {
    $data = $_GET;
  }

  $sexo = array(
    'masculino' => 'Masculino',
    'feminino' => 'Feminino'
  );
  $states = get_field_object('estado', "user_1" );
  $disabled = ($alterar ? 'disabled="disabled"' : '');
  $pwdRequired = ($alterar ? '' : 'required')

?>
          <?php if ( $_GET['erro'] ) : ?>
          <fieldset>
            <label class="error"><?php echo $_GET['erro']; ?></label>
          </fieldset>
          <?php endif; ?>
            <fieldset class="col-md-6">
              <label>Nome *</label>
              <input type="text" name="nome" data-msg-required="Campo obrigatório" value="<?php echo $data['nome']; ?>" <?php echo $disabled; ?> required />
            </fieldset>
            <fieldset class="col-md-6">
              <label>Sobrenome *</label>
              <input type="text" name="sobrenome" data-msg-required="Campo obrigatório" value="<?php echo $data['sobrenome']; ?>" <?php echo $disabled; ?> required />
            </fieldset>
            <fieldset class="col-md-9">
              <label>E-mail *</label>
              <input type="email" name="email" data-msg-required="Campo obrigatório" value="<?php echo $data['email']; ?>" required />
            </fieldset>
            <fieldset class="col-md-3">
              <label>Sexo *</label>
              <select id="sexoSelect" class="selectBoxIt" data-msg-required="Campo obrigatório" name="sexo" required>
                <option value=""></option>
                <?php foreach( $sexo as $key => $nome ) : ?>
                  <option <?php echo $data['sexo'] == $key ? 'selected' : ''; ?> value="<?php echo $key ?>"><?php echo $nome ?></option>
                <?php endforeach; ?>
              </select>
            </fieldset>
            <fieldset class="col-md-7">
              <label>CPF *</label>
              <input type="text" name="cpf" data-msg-required="Campo obrigatório" value="<?php echo $data['cpf']; ?>" <?php echo $disabled; ?> required class="cpf"  />
            </fieldset>
            <fieldset class="col-md-5">
              <label>Data de Nascimento *</label>
              <input type="text" name="nascimento" data-msg-required="Campo obrigatório" value="<?php echo $data['nascimento']; ?>" required class="date-mask"  />
            </fieldset>
            <fieldset class="col-md-12">
              <label>Endereço</label>
              <input type="text" name="endereco" value="<?php echo $data['endereco']; ?>"  />
            </fieldset>
            <fieldset class="col-md-6">
              <label>Cidade</label>
              <input type="text" name="cidade" value="<?php echo $data['cidade']; ?>"  />
            </fieldset>
            <fieldset class="col-md-3">
              <label>Estado</label>
              <select class="selectBoxIt" name="estado">
                <option value="">(UF)</option>
                <?php foreach( $states['choices'] as $uf ) : ?>
                  <option <?php echo $data['estado'] == $uf ? 'selected' : ''; ?> value="<?php echo $uf ?>"><?php echo $uf ?></option>
                <?php endforeach; ?>
              </select>
            </fieldset>
            <fieldset class="col-md-3">
              <label>CEP</label>
              <input type="text" name="cep" value="<?php echo $data['cep']; ?>"  class="cep" />
            </fieldset>
            <fieldset class="col-md-6">
              <label>Telefone</label>
              <input type="text" name="telefone" value="<?php echo $data['telefone']; ?>" class="phone" />
            </fieldset>
            <fieldset class="col-md-6">
              <label>Celular *</label>
              <input type="text" name="celular" data-msg-required="Campo obrigatório" value="<?php echo $data['celular']; ?>" required class="phone" />
            </fieldset>
            <fieldset class="col-md-6">
              <label>Senha *</label>
              <input type="password" data-msg-required="Campo obrigatório" name="password" class="passwd" id="passwd" <?php echo $pwdRequired; ?> />
            </fieldset>
            <fieldset class="col-md-6">
              <label>Repetir senha *</label>
              <input type="password" name="passwd2" class="passwd2" data-msg-required="Campo obrigatório" data-msg-equalto="Os campos de senha devem ser iguais" data-msg-passwd2="Os campos de senha devem ser iguais" <?php echo $pwdRequired; ?> />
            </fieldset>
<?php

}
