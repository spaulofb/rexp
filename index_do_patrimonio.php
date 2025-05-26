<?php
//  
//  Require para o Navegador que nao tenha ativo o Javascript
//   Posicao do arquivo noscript.php tem que ser depois da tag  BODY
require("js/noscript.php");
//
$php_errormsg='';
//  include "../inc/navegador_usado.php";
//   Verifica qual navegador esta sendo usado
$useragent = $_SERVER["HTTP_USER_AGENT"];
if ( preg_match('|MSIE ([0-9]{1,2}.[0-9]{1,2})|',$useragent,$matched) ) {
  //    echo "Esse navegador  e' IE ";
    $keynum = "window.event.keyCode";
} else  {   
 //   echo "Esse navegador nao e'  IE ";
  $keynum = "e.which";
}  
//
$_SESSION['keynum']  = $keynum;
if ( ! empty($php_errormsg) ) {
    echo "<br>ERRO NA BUSCA<br>";
    exit();
}
//  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
}
$_SESSION["pasta_raiz"]="";
$_SESSION["http_host"]="";
if( isset($_SESSION["pasta_raiz"]) ) unset($_SESSION["pasta_raiz"]);
if( isset($_SESSION["http_host"]) ) unset($_SESSION["http_host"]);
//
include "php_include/patrimonio/campos_php.php";

//  Navegador usado permitido - Patrimonio
// $_SESSION["pasta_raiz"]='/gemac/patrimonio/';
/// $_SESSION["pasta_raiz"]="/gemac/patrimonio2/";
$_SESSION["pasta_raiz"]='/gemac/patrimonio/';

//  require_once('/var/www/php_include/ajax/includes/navegador_usado.php');
include('php_include/patrimonio/library/navegador_usado.php');
//
$_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
$raiz_central= $_SESSION["url_central"]."index_navegador.php";
//  header("Location: $raiz_central");
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<script type="text/javascript" >
/* <![CDATA[ */
function conectar() {
    //  Enviando como GET a variavel pasta_raiz
  window.location.replace("<?php echo  $raiz_central."?pasta_raiz={$_SESSION["pasta_raiz"]}";?>");
  return;
}
/* ]]> */
</script>
</head>
<body onload="javascript: conectar();" >
<?php
// header("location: $raiz_central");
//  exit;

?>
</body>
</html>