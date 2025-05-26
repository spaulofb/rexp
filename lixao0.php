<?php
///  AJAX da opcao Alterar  - Servidor PHP para alterar Anotacao do PROJETO
///
///  LAFB&SPFB110908.1151
#
ob_start(); /* Evitando warning */
///
///  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
/// set IE read from page only not read from cache
///  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

///  header("content-type: application/x-javascript; charset=tis-620");
///  header("content-type: application/x-javascript; charset=iso-8859-1");
header("Content-Type: text/html; charset=ISO-8859-1",true);
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');
///
/// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
///
////  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
/// Final - Mensagens para enviar 

$pasta_raiz = $_SESSION["pasta_raiz"]='/rexp/';

$_SESSION["dir_principal"] = $dir_principal =__DIR__;
$ultcaracter=substr(trim($dir_principal),-1);
if( $ultcaracter<>"/" ) $_SESSION["dir_principal"] = $dir_principal = $dir_principal."/";
///

echo "1)  \$pasta_raiz = $pasta_raiz  --- <br/> \$dir_principal = $dir_principal  ";

$array=explode("$pasta_raiz","$dir_principal");

print_r($array);
$len_pasta_raiz=strlen($pasta_raiz);
$pos=strrpos($dir_principal,$pasta_raiz);
$pos=$pos+$len_pasta_raiz;
$texto=substr($dir_principal,$pos);
echo "<br/><b> $pos </b>  --->>>  $texto";


#
?>