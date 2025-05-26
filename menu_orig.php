<?php
/*   
*   REXP - REGISTRO DE EXPERIMENTO
* 
*   MODULO: Iniciando conexao   
* 
*/
///  @require_once('inicia_conexao.php');  once = somente uma vez
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
///
///
////  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // sempre modificada
///  header("Pragma: no-cache"); // HTTP/1.0
///   header("Cache: no-cache");
//  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
// For?a a recarregamento do site toda vez que o navegador entrar na p?gina
////   header("http-equiv='Cache-Control' content='no-store, no-cache, must-revalidate'");
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

//  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0")
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
///
ini_set('default_charset','UTF-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///
extract($_POST, EXTR_OVERWRITE); 
///
///  Verificando SESSION incluir_arq - 20180618
$n_erro=0; $incluir_arq="";

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
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
     $msg_erro .= "Erro ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
/***
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
***/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");

///  Variavel recebida do script/arquivo - inicia_conexao.php 
$_SESSION["m_horiz"] = $array_projeto;
///
//   Definindo a Raiz do Projeto
//  $_SESSION["pasta_raiz"]='/rexp/';
$_SESSION["pasta_docs"]="doctos_img";
//
///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]= utf8_decode("Registro de Anotação") ;

/// $_SESSION['time_exec']=180000;

//
/// Alterado em 20120912 - Voltar a function como dochange
$_SESSION["function"]="dochange";
//
//  $_SESSION[http_host]= "http://".$_SERVER["HTTP_HOST"]."/rexp/";
///  $_SESSION["http_host"]= "http://".$_SERVER["HTTP_HOST"].$_SESSION["pasta_raiz"];
///  $_SESSION["url_central"] = $_SESSION["http_host"];
///   $http_host=$_SESSION["http_host"];
////  $_SESSION["url_central"] = $_SESSION["http_host"];
$php_errormsg='';
/*** 
     Alterado em 20171010
***/
if( isset($_SESSION["url_central"]) ) {
     $http_host = @trim($_SESSION["url_central"]);     
} else {
    echo "<p style='background-color: #000000;color:#FFFFFF;font-size:large;'> ERRO: grave falha na session url_central. Contato com Administrador.</p>";
    exit();
}
///
if( ! empty($php_errormsg) ) {
    $http_host="../";
}
///
///  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
///
///  SESSEION para Alterar o Excluir ANotacao
if( isset($_SESSION["anotacao_cip_altexc"]) ) unset($_SESSION["anotacao_cip_altexc"]); 
////
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
<meta charset="utf-8" />
<meta name="author" content="SPFB&LAFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<!--  <meta http-equiv="Expires" content="-1" >  -->
<!--  <meta http-equiv="Expires" content="0" >  -->
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Projeto</title>
<!-- <script type="text/javascript"  language="javascript"   src="includes/domenu.php" ></script>  -->
<!-- <script type="text/javascript"  language="javascript"   src="js/domenu.js" ></script> -->
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js" ></script>
<script type='text/javascript' src='<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1'></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!-- <script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script> -->
<?php
///
$_SESSION['n_upload']="ativando";

///   Incluido em  20170925
////  Functions em PHP
require("{$_SESSION["incluir_arq"]}includes/functions.php");

////  Para mudar de pagina no MENU usando domenu.php ou dochange.php
require("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);" >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho  -->
<div id="cabecalho" style="z-index:2;" >
<?php 
///  Cabecalho
include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");
///
?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
///
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<img src="<?php echo $_SESSION["url_central"];?>imagens/anotando_menor.png" style="width:100%;height: auto; overflow-x: hidden; overflow-y: auto;vertical-align: middle; " />    
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape" >
<?php 
///  Rodape
include("{$_SESSION["incluir_arq"]}includes/rodape_index.php"); 
///
?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
