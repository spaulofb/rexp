<?php
///
//   Criando uma nova senha
//  function GenPwd($length = 7) {
function GenPwd($length = 8) {
  $password = "";
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; // nenhuma vogal
  $i = 0; 
  while( $i<$length) { 
     $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
     //   Abaixo para nao criar senha com duplicatas
     //  Caso nao encontrou na variavel password algum caracter da char acrescentar
     if( ! strstr($password, $char) ) { 
        $password .= $char;
        $i++;
     }
  }
  $m_pwd = strtoupper(trim($password));
  ///
  ///  Verificando Senha 
  $verificar_senha=mysql_query("SELECT login,codigousp FROM  usuario WHERE "
                              ." upper(trim(senha))=password('$m_pwd')  ");
  ///
  if( ! $verificar_senha  ) {
       die("ERRO: Select verificar_senha&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());
  } 
  /// Numero de senhas 
  $n_senhas=mysql_num_rows($verificar_senha);
  if( intval($n_senhas)>=1 ) {
      if( isset($verificar_senha) )  mysql_free_result($verificar_senha);
      ///
      GenPwd();
  }                     
  return $password;
} 
?>
