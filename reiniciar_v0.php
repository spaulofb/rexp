<?php
//
ini_set('include_path', '/var/www/cgi-bin/');
set_include_path('/var/www/cgi-bin/');

//  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
}
//
/// Verificando conexao
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
///  require_once("php_include/patrimonio/conectando.php");

/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

///
ini_set('default_charset','UTF-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

///  Verificando SESSION incluir_arq
$n_erro=0;
///  Verificando SESSION incluir_arq - 20180801
$incluir_arq="";
////  path e arquivo local
$dirarq=$_SERVER['SCRIPT_FILENAME'];
 
////  Arquivo local
$arqlocal =  basename( __FILE__ );
$_SESSION["dirprincipal"] = $dirprincipal = str_replace($arqlocal,'',$dirarq);
///
///   Atualizado 20180928 - Correto
///  Diretorio principal exe /var/www/html/aqui
///  $dir_principal=__DIR__;
///
///
///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
   /***
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
     ***/
    ////  path e arquivo local
    $_SESSION["incluir_arq"]= $_SESSION["dirprincipal"];
    ///
}
$incluir_arq=$_POST["incluir_arq"] = $_SESSION["incluir_arq"];
///
if( strlen($incluir_arq)<1 ) $n_erro=1;
///
/***
*    Caso NAO houve ERRO  
***/
if( intval($n_erro)<1 )  {
    ////   CONECTANDO
    include("{$_SESSION["incluir_arq"]}inicia_conexao.php");
    ///
    ///  HOST mais a pasta principal do site - host_pasta
    if( ! isset($_SESSION["host_pasta"]) ) {
         $msg_erro .= utf8_decode("SESSION host_pasta desativada.").$msg_final;  
         echo $msg_erro;
         exit();
    }
    $host_pasta=trim($_SESSION["host_pasta"]);
    if( strlen($host_pasta)<1 ) $n_erro=2;
    ///
    /***
    *    Caso NAO houve ERRO  
    */
    if( intval($n_erro)<1 )  {
        ///  DEFININDO A PASTA PRINCIPAL 
        /////  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
        ///  Verificando SESSION  pasta_raiz
        if( ! isset($_SESSION["pasta_raiz"]) ) {
             $msg_erro .= utf8_decode("SESSION pasta_raiz desativada.").$msg_final;  
             echo $msg_erro;
             exit();
        }
        $pasta_raiz=trim($_SESSION["pasta_raiz"]);
        ///
        ///  Definindo http ou https - IMPORTANTE
        ///  Verificando protocolo do Site  http ou https   
        $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
        $raiz_central=$_SESSION["url_central"];
        ///
    }
    ////    
}
/******  FINAL - if( intval($n_erro)<1 ) **********************/  
///
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
     $msg_erro .= "Erro ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
///
///  $_SESSION['array_usuarios'] = $array_usuarios;  // CORRIGIDO:LAFB110825.2215
$elemento=5; $elemento2=6;
/*  NUNCA USAR ISSO
    @require_once('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
    include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
*/
include("php_include/patrimonio/limpar_tbs_tmp.php");
///
if( isset($_SESSION['m_conexao']) ) {
   $m_conexao = $_SESSION['m_conexao'] ;    
} else {
   if( isset($m_conexao) ) {
      $_SESSION['m_conexao'] = $m_conexao;  
   } else  $m_conexao="";
}
//
if( isset($_SESSION['dbname']) ) {
   $dbname = $_SESSION['dbname'] ;    
} else {
   if( isset($dbname) ) {
      $_SESSION['dbname'] = $dbname;  
   } else  $dbname="";
}
//
//  Remover as tabelas temporarias do usuario conectado
//  somente qdo iniciar e qdo sair
///  include("script/remover_table_temp.php");
//  include("php_include/patrimonio/remover_table_temp.php");

//
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(),'', time()-42000, '/');
}
///
///  Desativar todas as SESSIONS - 20190329
session_unset();
///  session_destroy();
clearstatcache();

///
//  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
//
if( isset($_SESSION["userid"]) ) unset($_SESSION["userid"]);
if( isset($userid) )  unset($userid);
if( isset($_SESSION["userpassword"]) )  unset($_SESSION["userpassword"]);
if( isset($userpassword) )   unset($userpassword);
if( isset($default_dbname) ) unset($default_dbname);
if( isset($user_tablename) )  unset($user_tablename);
//
if( isset($n_registro) ) unset($n_registro);
if( isset($n_ip) ) unset($n_ip);
if( isset($temp_x_y) ) unset($temp_x_y);
if( isset($confirm) ) unset($confirm);
if( isset($codigo) ) unset($codigo);
//
/*
//  Desativando vari&aacute;veis
session_cache_expire(1);
//
$_SESSION['retornou'] = 'S';
ob_start();
header("Location: http://sol.fmrp.usp.br/gemac/patrimonio/?retornou=S");
ob_end_flush(); 
ob_end_clean(); 

echo  "<script type='text/javascript' >"; 
echo "self.close()";
echo  "</script>";
*/
$http_host = "http://".$_SERVER["HTTP_HOST"];
$_SESSION["http_host"] = $http_host;
//
?>
<!DOCTYPE html>
<html lang="pt-BR" >
<head>
<meta charset="UTF-8" />
<TITLE>Window Closer</TITLE>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE"> 
<META HTTP-EQUIV="Expires" CONTENT="-1" >
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<script language="JavaScript" type="text/javascript" >
function site_depto() {
  // top.close()
 /*   window.open('','_parent','');
   window.close(newWindow);
   window.close();  */
   /*
   window.open("", "_parent");
   window.opener = "";
   window.close();
   */
   window.location
}
//  Saindo do Navegador
function sair() {
    var xhttp_host='<?php echo $_SESSION["http_host"];?>';
    parent.location.href=xhttp_host;          
    window.open('', '_self', ''); // bug fix
    window.close();
}
//
</script>
</HEAD>
<!--  <BODY ONLOAD="javascript: site_depto()">  -->
<body  >
<!--  <form action="http://sol.fmrp.usp.br"  method="post" target="_parent" >  -->
<script language="JavaScript" type="text/javascript" >
//
//  Saindo do Navegador
var xhttp_host='<?php echo $_SESSION["http_host"];?>';
parent.location.href=xhttp_host;          
window.open('', '_self', ''); // bug fix
window.close();
//
</script>
</BODY>
</HTML>

