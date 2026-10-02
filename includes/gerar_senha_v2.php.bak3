<?php
/**
*        Criando uma nova senha
* Ataulizando em 20250326
*/
//  function GenPwd($length = 7) {
function GenPwd($length = 8) {
    //
    //  Conexao MYSQLI
    $conex = $_SESSION["conex"];
    //
    $password = "";
    $possible = "0123456789bcdfghjkmnpqrstvwxyz"; // nenhuma vogal
    $i = 0; 
    while( $i<$length) { 
         //
         $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
         //   Abaixo para nao criar senha com duplicatas
         //  Caso nao encontrou na variavel password algum caracter da char acrescentar
         if( ! strstr($password, $char) ) { 
                 $password .= $char;
                 $i++;
         }
         //
    }
    /**  Final - while( $i<$length) {   */
    //
    $m_pwd = strtoupper(trim($password));
    //
    //  Verificando Senha 
    $proc="SELECT login,codigousp FROM  usuario WHERE ";
    $proc.=" upper(trim(senha))=password('$m_pwd')  ";
    $verificar_senha=mysqli_query($_SESSION["conex"],"$proc");
    //
    if( ! $verificar_senha  ) {
        die("ERRO: Select verificar_senha&nbsp;-&nbsp;db/mysql:&nbsp;".mysqli_error($conex));
    } 
    //
    // Nr. de senhas 
    $n_senhas=mysqli_num_rows($verificar_senha);
    //
    if( intval($n_senhas)>=1 ) {  
         //     
         //  Desativar variavel  
         if( isset($verificar_senha) ) {
               mysqli_free_result($verificar_senha); 
         }  
         //
         GenPwd();
    }
    /**  Final - if( intval($n_senhas)>=1 ) {  */
    //
    return $password;
    //
} 
/**   Final - function GenPwd($length = 8) {  */
//
?>
