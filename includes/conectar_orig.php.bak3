<?php
///
///       Atualizado em 20210304
///  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
}     
///
/// Conexo ao banco de dados e validando  o login
$db_array = array( 1=> "ajax", "genetica_bl_c", "patrimonio",
             "downloads", "pessoal","rexp","cadastro","login_senha",
             "busca","alunos","testando","grupoemail");
///
///  $con_host = 'sol.fmrp.usp.br';
$con_host = 'localhost';
$con_user=  'soldbm';
/// $con_pass= '@%!_sol_dbm';
$con_pass= 'lexus2P5W1!';


/***
     $lnkcon= mysql_connect('sol.fmrp.usp.br', 'soldbm','@%!_sol_dbm' ) 
           or     die("ERRO/Acesso sgbd.");
***/
///  Verificando o acesso a conexao-  atualizado 20191122 
///  $lnkcon= mysql_connect($con_host, $con_user,$con_pass ) or die("ERRO/Acesso sgbd.");
/// $lnkcon= mysql_pconnect($con_host, $con_user,$con_pass ) or die("ERRO/Acesso sgbd.");
$conex = $_SESSION["conex"] = $lnkcon= mysqli_connect($con_host, $con_user,$con_pass );
///
/// Verificando Conexao 
if( mysqli_connect_errno() )  {
    ///
    /// Ocorreu erro Conexao MYSQLI - mysqli_connect
    $txt="<b>ERRO</b>: Falha grave conexao MYSQLI Server  - mysqli_connect - db/mysqli&nbsp; Corrigir<br/>";
    ///
    $_SESSION["erro"] = "$txt".mysqli_connect_error();
    echo "{$_SESSION["erro"]}";
    ///
    $m_erro = TRUE; 
    exit(); 
}
///   Conexao sucesso 
///
///  $lnkdb = mysql_select_db($db_array[$elemento], $lnkcon) or die("ERRO/Conectar  bd");
///
/// Enviando para um arquivo com as variaveis  das Tabelas 
$bd_1=$db_array[$elemento];
if( isset($elemento2) ) $bd_2=$db_array[$elemento2];
$_SESSION["bd_1"]=$bd_1;
///
?>
