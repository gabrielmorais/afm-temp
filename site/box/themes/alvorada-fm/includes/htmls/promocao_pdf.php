<?php

return <<<HEREDOC
<body>
  <style>
    p, td {
      font-size: 11pt;
      font-family: serif;
    }
    table {
      border: 1px solid #000;
    }
    th { 
      margin: 0px;
      padding: 20px 5px;
      border-bottom: 1px solid #000;
      border-right: 1ps solid #000;
      background-color: 
    }
    .last {
      border-right: 0 none;
    }
    td {
      padding: 20px 5px;
      border-right: 1ps solid #000;
    }
    .page {
      width: 800px;
      margin: 0 auto;
    }
  </style>
  <div class="page">
    <img src="{$logo}" width="269" height="26" />
    <h1>{$title}</h1>
    <p>{$resumo}</p>
    <table width="100%">
      <thead>
      <tr>
        <th>DATA</th>
        <th>PRÊMIO</th>
        <th>NOME</th>
        <th>CPF</th>
        <th>TELEFONE</th>
        <th class="last">E-MAIL</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>{$data}</td>
        <td>{$premio}</td>
        <td>{$user->nome} {$user->sobrenome}</td>
        <td>{$user->cpf}</td>
        <td>{$user->celular}</td>
        <td class="last">{$user->user_email}</td>
      </tr>
      </tbody>
    </table>

    <p><b>Ganhador (a) da Promoção:</b></p>
    <p>Recebi:  (   ) {$premio_desc}</p>
    <p>Nome:  ______________________________________________________________</p>
    <p>RG: _______________________________   CPF:  _____________ -  _____</p>
    <p>Assinatura: __________________________________________________________</p>
  </div>
</body>
HEREDOC;
