<?php
///  Alterado em 20180725
///  require('../inicia_conexao.php');
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

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
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
    ///  echo $msg_erro;
    ///  exit();
    $n_erro=1;
} else {
    $incluir_arq=trim($_SESSION["incluir_arq"]);    
}
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

///
/// Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
set_time_limit(0);

///  $pasta = '/tmp/spfbezer';
/*  $regs = explode("/",$_GET['file']);
   $pasta = "/".$regs[1]."/".$regs[2]."/";
   $_GET['file']=str_ireplace($pasta,"",$_GET['file']);

   Convertendo arquivo com letras maiusculas para minusculas:
     
   for arq in `ls *.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done
   ou
    for arq in `ls *.*`; do mv $arq `echo $arq | tr  A-Z a-z`; done
*/
///
if( isset($_GET["pasta"]) ) {
  $pasta = $_GET["pasta"];    
} elseif( isset($_POST["pasta"]) ) {
   $pasta =  $_POST["pasta"]; 
}
///  Verificando $_GET['file']
///
/// if( ! isset($_SESSION["arquivo_projeto"]) ) {
if( ! isset($_SESSION["arquivo_anotacao"]) ) {
   /// $msg_erro .= "GET file não está ativa.".$msg_final;  
   $msg_erro .= "SESSION arquivo_anotacao não está ativa.".$msg_final;   
   echo $msg_erro;
   exit();
} else {
   /// 
   ini_set('default_charset', 'UTF8');
   ///
   ///  IMPORTANTE: utf8_decode para acentuacao e simbolos - 20180730
   ///  $file = "{$_GET["file"]}";
   $file = utf8_decode("{$_SESSION["arquivo_anotacao"]}");
   /// $caminho_arquivo="{$pasta}{$_GET["file"]}";
   $caminho_arquivo="{$pasta}{$file}";
   ///
}
////
/// $resultado=@file_exists("{$pasta}".preg_replace('\\','',$file));
$resultado=@file_exists("{$caminho_arquivo}");

//// echo "ERRO: baixar_anotacao/86 --- \$resultado =  $resultado  =====  {$_SESSION["arquivo_projeto"]}  <<<--->>>   \$caminho_arquivo =  $caminho_arquivo --->>>- \$file = $file   ".$_GET["file"];
///  echo "ERRO: baixar_anotacao/86 ---<p> \$resultado =<b>  $resultado  </b></p><<<=== \$caminho_arquivo = $caminho_arquivo <br/>  {$_SESSION["arquivo_projeto"]}  <<<--->>>  \$file = $file   ".$_GET["file"];
///  exit();

////  Verifica se o arquivo EXISTE
///  if( file_exists("{$caminho_arquivo}") ) {
if( $resultado ) {
     /*** 
        $type = filetype("{$pasta}{$file}");
        $size = filesize("{$pasta}{$file}");
     ***/   
     ///   $type = filetype("{$pasta}".preg_replace('\\','',$file));
     $type = filetype("{$caminho_arquivo}");
     ///   $size = filesize("{$pasta}".preg_replace('\\','',$file));   
     $size = filesize("{$caminho_arquivo}");
     header("Pragma: public");  /// required
     header("Expires: 0");
     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
     header("Cache-Control: private",false); // required for certain browsers 
     header("Content-Description: File Transfer");
     header('Content-Type: text/plain; charset=ISO-8859-1');
     header("Content-type: application/save");
	 header("Content-Type: {$type}");
	 header("Content-Length: {$size}");
     header('Content-Disposition: attachment; filename='. basename("{$caminho_arquivo}"));
 	 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
     header('Pragma: public');
     header('Expires: 0');

     ///  readfile("{$pasta}{$file}");
     readfile("{$caminho_arquivo}");
	 exit();	
} else {
   $msg_erro .= "Esse arquivo {$file} não existe.".$msg_final;  
   echo $msg_erro;
   exit();
}

?>