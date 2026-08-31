<?php
//
//  Verificando se sseion_start - ativado ou desativado
if( !isset($_SESSION)) {
     session_start();
}
//

if( isset($_SESSION["elemento"]) )  $elemento =  (int) $_SESSION["elemento"];
if( isset($_SESSION["elemento2"]) )  $elemento2 =  (int) $_SESSION["elemento2"];
 
// Aqui fazemos a conexo ao banco e dados e validamos o login

$db_array = array( 1=> "ajax", "genetica_bl_c", "patrimonio", "downloads", "pessoal","rexp","cadastro","login_senha","busca","alunos");

/***
     IMPORTANTE:  Para host sol.fmrp.usp.br  precisa:
                   [root@sol patrimonio]# sudo setsebool -P httpd_can_network_connect 1
                                  $dbhost = $con_host = 'sol.fmrp.usp.br';
***/
$dbhost = $con_host = 'localhost';
$dbuser =  $con_user=  'soldbm';
/// $dbuserpwd = $con_pass= '@%!_sol_dbm';
$dbuserpwd = $con_pass = 'lexus2P5W1!';


/*** 
    $lnkcon= mysql_connect('sol.fmrp.usp.br', 'soldbm','@%!_sol_dbm' ) 
     or     die("ERRO/Acesso sgbd.");
***/
//  Verificando o acesso a conexao 
//  $lnkcon= mysql_connect($con_host, $con_user,$con_pass );
///  $lnkcon= mysql_connect($con_host, $con_user,$con_pass );
/***
      Alterado em 20191122  - usando MYSQLI Server 
***/
$conex = $_SESSION["conex"] = $lnkcon = mysqli_connect($dbhost,$dbuser,$dbuserpwd);
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
/// $lnkdb3 = mysql_select_db($db_array[$elemento], $lnkcon);
$lnkdb3 = mysqli_select_db($lnkcon,$db_array[$elemento]);
///
/// Verificando Banco de Dados - BD/DB 
if( mysqli_error($_SESSION["conex"]) ) {
    $txt = "ERRO: Conectando Banco de Dados - BD/DB. Falha: ";
    echo $txt.mysqli_error($_SESSION["conex"]);
    exit();
} 
///  Sucesso: Conectando Banco de Dados - BD/DB.  
///
/// Enviando para um arquivo com as variaveis  das Tabelas 
$bd_1=$db_array[$elemento];
if( isset($elemento2) ) {
       $bd_2=$db_array[$elemento2];
}
///   Select/MYSQLI
$cmdsql="SELECT lower(substring_index(substring_index(descricao,'-',1),' ',1)) as descricao, "
          ." codigo from $bd_2.pa order by codigo ";
///   
/// $resultado_pa=mysql_query($cmdsql);
$resultado_pa = mysqli_query($conex, $cmdsql);
///
/// if( ! $resultado_pa  ) {
if( mysqli_error($_SESSION["conex"]) ) {
    ///   die('ERRO: SELECT participante/pessoa: '.mysql_error());
   die('ERRO: SELECT participante/pessoa: '.mysqli_error($_SESSION["conex"]));
}
///
/// while( $row = mysql_fetch_array($resultado_pa, MYSQL_ASSOC)) {
while( $row = mysqli_fetch_array($resultado_pa) ) {
       /// 
        $descricao=$row["descricao"];
        $array_pa[$descricao]=$row["codigo"];
}
///
if( isset($resultado_pa) )  mysqli_free_result($resultado_pa);
$_SESSION['array_pa']=$array_pa;
///
?>
            
