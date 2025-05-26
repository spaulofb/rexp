<?php
/*
    Formulario Esquecia a Senha 
    alterado em 20170707
******************************************************************/    
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // sempre modificada
header("Pragma: no-cache"); // HTTP/1.0
header("Cache: no-cache");
//  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
// For?a a recarregamento do site toda vez que o navegador entrar na p?gina
header("http-equiv='Cache-Control' content='no-store, no-cache, must-revalidate'");
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

///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= utf8_decode("Sess?o incluir_arq não est? ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
///
////  Navegador permitido
////require_once('/var/www/cgi-bin/php_include/ajax/includes/navegador_permitido.php');
require_once('php_include/ajax/includes/navegador_permitido.php');
///  HOST mais a pasta principal do site - host_pasta
$host_pasta="";
if( isset($_SESSION["host_pasta"]) ) {
     $host_pasta=$_SESSION["host_pasta"];  
} else {
     $msg_erro .= utf8_decode("Sess?o host_pasta não est? ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
///
///  DEFININDO A PASTA PRINCIPAL 
if( isset($_SESSION["pasta_raiz"]) ) {
    $pasta_raiz=$_SESSION["pasta_raiz"];         
} else {
    $pasta_raiz=$_SESSION["pasta_raiz"]="/rexp/";     
}
///  Definindo http ou https
///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
////    MENU HORIZONTAL
include("{$incluir_arq}includes/array_menu.php");
//  $_SESSION["m_horiz"] = $array_sair;
$_SESSION["m_horiz"] = $array_voltar;
//   Definindo a Raiz do Projeto
//  $_SESSION["pasta_raiz"]='/rexp/';
//  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anota??o");
///
////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
<meta charset="utf-8" >
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="pragma" content="no-cache">
<meta name="robots" content="none"> 
<meta http-equiv="Expires" content="-1" >
<meta name="googlebot" content="noarchive"> 
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<title>Esqueci a Senha</title>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js"  ></script>
<link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />
<link rel="stylesheet"  href="<?php echo $host_pasta;?>css/fonts.css" type="text/css" >
<script type="text/javascript" src="<?php echo $host_pasta;?>js/functions.js" ></script>
<script type='text/javascript' src='<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1'></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script>
<script type="text/javascript">
///
///  Javascript - 20100621
/*
     Aumentando a Janela no tamanho da resolucao do video
     Melhor jeito para todos os navegadores
     fazer logo quando inicia a pagina
*/
self.moveTo(-4,-4);
self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
//  self.resizeTo(1000,1000);
self.focus();
//
///   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
/***
if ( screen.width<1024 ) {
    alert("A resolução da tela do seu monitor para esse site ?\n RECOMEND?VEL no m?nimo  1024x768 ")
}
****/
///
</script>
<style  type="text/css"   >
.p_justify { text-align: justify; }
.sem_scroll { overflow: hidden; top: 0; left: 10px; margin-top:0; padding: 0px;    }
</style>
<?php
////  Arquivo  js principal
include("{$_SESSION["incluir_arq"]}js/esqueci_senha_js.php");    
?>
</head>
<body   onload="javascript: refreshimg('label_msg_erro','msg_erro'); cpo1_focus(document.senForm)"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"  >
<?php
//  require para o Navegador que nao tenha ativo o Javascript
require("{$_SESSION["incluir_arq"]}js/noscript.php");
//  $_SESSION[onsubmit_tabela]="PESSOAL";      
$tit_email = "Digitar seu Email";
//
?>
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
// Alterado em 20120912 - Voltar a function como dochange
$_SESSION["function"]="dochange";
//
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
////  include("includes/menu_horizontal_index.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro" >
</div>
<p class="titulo_usp" >Esqueci a Senha</p>
</section>
<!-- Final - Mensagem de ERRO e Titulo    -->
<h3 class="titlehdr" style="margin: 4px;" ></h3>
    <section>
      <article class="anotacaoarticle1"  >
<p style="margin-left: 10px; margin-bottom: 0px; padding-bottom: 0px; bottom: 0px;" >Indique o seu e-mail cadastrado para receber nova senha.</p>
</article>
</section>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr>
    <td  valign="top">
     <!--  <form action="esqueci_senha.php" method="post" name="actForm" id="actForm" >  -->
      <form  method="post" name="senForm" id="senForm"  onsubmit="javascript: enviar_dados('submeter','SENHA',document.senForm); return false;"   >
        <table width="99%" border="0" cellpadding="4" cellspacing="4" class="loginform"  style="margin-top: 0px; top:0px; padding-top: 0px;">
           <tr  > 
            <td class="td_inicio1" width="14%"  style="vertical-align: text-top;"  >
            <label for="email" style="cursor: pointer; text-align: right;"  title='<?php echo $tit_email;?>' >Seu email:&nbsp;</label>
            </td>
            <td  class="td_inicio2" style="vertical-align: top;" >
            <input  type="text"  name="user_email" id="user_email" class="required email"  size="80"  maxlength="64"  title='<?php  echo  $tit_email;?>' onKeyUp="this.value=trim(this.value);"  onkeydown="javascript: backspace(event,this)"  onblur="javascript: alinhar_texto(this.id,this.value); "  autocomplete="off"   > 
            </td>
          </tr>    
          
          <tr> 
           <td  align="center"  style="text-align: left; border:none; ">
              <button type="submit"  name="enviar" id="enviar"    class="botao3d"  style="cursor: pointer; "  title="Enviar"  acesskey="E"  alt="Enviar"   >    
         Enviar&nbsp;<img src="imagens/enviar.gif" alt="Enviar"  style="vertical-align:text-bottom; cursor: pointer;"  >
      </button>
            </td>
          </tr>
        </table>
      </form>
     </td>
  </tr>
</table>
</div>
<!-- Final Corpo -->
<!-- Rodape -->
<div id="rodape"  >
<?php include_once("{$incluir_arq}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
