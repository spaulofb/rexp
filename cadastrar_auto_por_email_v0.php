<?php 
/*   REXP - CADASTRAR NOVO ORIENTADOR
* 
*   LAFB&SPFB110906.1146 - Incluindo campo PA - Atualizado em 20181026
* 
*/
///  ==============================================================================================
///
///  Verificando se sseion_start - ativado ou desativado
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

/****************************************  
*       ATUALIZADO EM  20181026
********************************************/
///
extract($_POST, EXTR_OVERWRITE); 
///
////  Navegador permitido
////require_once('/var/www/cgi-bin/php_include/ajax/includes/navegador_permitido.php');
require_once('php_include/ajax/includes/navegador_permitido.php');

///  Verificando SESSION incluir_arq - 20180618
$n_erro=0; $incluir_arq="";

////  path e arquivo local
$dirarq=$_SERVER['SCRIPT_FILENAME'];
 
////  Arquivo local
$arqlocal =  basename(__FILE__);
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
////   require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");
///  zerando variavel de erro
$n_erro=0;
///  HOST mais a pasta principal do site - host_pasta
if( ! isset($_SESSION["host_pasta"]) ) {
     $msg_erro .= utf8_decode("Sessão host_pasta não está ativa.").$msg_final;  
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
         $msg_erro .= "Sessão pasta_raiz não está ativa.".$msg_final;  
         echo $msg_erro;
         $n_erro=1;
    } else {
        $pasta_raiz=trim($_SESSION["pasta_raiz"]);        
        ///  
        ///  Definindo http ou https - IMPORTANTE
        ///  Verificando protocolo do Site  http ou https   
        $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
        $raiz_central=$_SESSION["url_central"];
        ///
        ///    MENU HORIZONTAL
        ///  include("../includes/array_menu.php");
        include("{$incluir_arq}includes/array_menu.php");
        if( isset($_SESSION["array_pa"]) ) {
             $array_pa = $_SESSION["array_pa"];    
             ///  Permissao do aprovador       
             $permit_aprovador = $array_pa['aprovador'];
             ///  Permissao do orientador
             $permit_orientador = $array_pa['orientador'];
              ///  Permissao do anotador       
             $pa_anotador = $permit_anotador = $array_pa['anotador'];
            /* Exemplo do resultado  do  Permissao de Acesso - criando array
                  +-------------+--------+
                  | descricao   | codigo |
                  +-------------+--------+
                  | super       |      0 | 
                  | chefe       |     10 | 
                  | vice        |     15 | 
                  | aprovador   |     20 | 
                  | orientador |     30 | 
                  | anotador    |     50 | 
                  +-------------+--------+
            */
        }
        ///
        ///  Verifica desktop ou aparelho movel - retorna estilo css
        if( ! isset($_SESSION["dirprincipal"]) ) {
             $msg_erro .= "Sessão usuario_conectado não está ativa.".$msg_final;  
             echo $msg_erro;
             $n_erro=1;
        } else {
            if( file_exists("{$_SESSION["dirprincipal"]}detectar_mobile.php") ) {
                 include_once("{$_SESSION["dirprincipal"]}detectar_mobile.php"); 
                 $estilocss = $_SESSION["estilocss"];
            } else {
                 $msg_erro .= "Arquivo {$_SESSION["dirprincipal"]}detectar_mobile.php não existe.";
                 $msg_erro .= $msg_final;  
                 echo $msg_erro;
                 $n_erro=1;
            }
        }
        ///
    }
    ///
}
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
    ///  Alterado em 20180621
     $msg_erro .= "<br/>Ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
///
///    MENU HORIZONTAL
$elemento=5; $elemento2=6;
//  PA - Ususarios 
///  require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) {
   $array_pa=$_SESSION["array_pa"];      
   $_POST["array_pa"]=$_SESSION["array_pa"];       
} 
///
///  $_SESSION["m_horiz"] = $array_sair;
$_SESSION["m_horiz"] = $array_voltar;
///
$pagina_atual="http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"]."cadastrar_auto_por_email.php";
//
//  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
///
/// $_SESSION['time_exec']=180000;
///  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
///
?>
<!DOCTYPE html>
<html lang="pt-BR" >
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
<title>Cadastrar Novo Orientador</title>
<!--  <script type="text/javascript"  language="javascript"   src="includes/dochange.php" ></script>  -->
<script type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js"  ></script>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<!--  <link rel="stylesheet"  href="<?php echo $host_pasta;?>css/fonts.css" type="text/css" >  -->
<script type="text/javascript" src="<?php echo $host_pasta;?>js/functions.js" ></script>
<!--  <script  type="text/javascript"  src="<?php echo $host_pasta;?>js/cadastrar_auto_por_email.js" ></script>  -->
<!--  Parte do Modal -->
<script> 
  var cssPath ="modal/themes/"
</script>
<link type="text/css" href="<?php echo $host_pasta;?>modal/themes/default.css" rel="stylesheet"  ></link> 
<link type="text/css" href="<?php echo $host_pasta;?>modal/themes/alphacube.css" rel="stylesheet" ></link>
<script type="text/javascript" src="<?php echo $host_pasta;?>modal/javascripts/prototype.js"> </script>
<script type="text/javascript" src="<?php echo $host_pasta;?>modal/javascripts/effects.js"> </script>
<script type="text/javascript" src="<?php echo $host_pasta;?>modal/javascripts/window.js"> </script>
<script type="text/javascript" src="<?php echo $host_pasta;?>modal/javascripts/window_effects.js"> </script>
<script type="text/javascript" src="<?php echo $host_pasta;?>modal/javascripts/debug.js"> </script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!--  <script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script>  -->
<style type="text/css" >
.alphacube_buttons input {
      width:40%;
}
</style>
<script type="text/javascript">
/* <![CDATA[ */
/*
             JavaScript Document
     Aumentando a Janela no tamanho da resolucao do video
     Melhor jeito para todos os navegadores
     fazer logo quando inicia a pagina
*/
self.moveTo(-4,-4);
self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
//  self.resizeTo(1000,1000);
self.focus();
///
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
charset="utf-8";
///
///  variavel quando ocorrer Erros ou apenas enviar mensagem
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
/******  Final -  variavel quando ocorrer Erros ou apenas enviar mensagem  ****/
///
///   funcrion acentuarAlerts - para corrigir acentuacao
///  Criando a function  acentuarAlerts(mensagem)
function acentuarAlerts(mensagem) {
    ///  Paulo Tolentino
    ///  Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));
    ///
    mensagem = mensagem.replace('á', '\u00e1');
    mensagem = mensagem.replace('à', '\u00e0');
    mensagem = mensagem.replace('â', '\u00e2');
    mensagem = mensagem.replace('ã', '\u00e3');
    mensagem = mensagem.replace('ä', '\u00e4');
    mensagem = mensagem.replace('Á', '\u00c1');
    mensagem = mensagem.replace('À', '\u00c0');
    mensagem = mensagem.replace('Â', '\u00c2');
    mensagem = mensagem.replace('Ã', '\u00c3');
    mensagem = mensagem.replace('Ä', '\u00c4');
    mensagem = mensagem.replace('é', '\u00e9');
    mensagem = mensagem.replace('è', '\u00e8');
    mensagem = mensagem.replace('ê', '\u00ea');
    mensagem = mensagem.replace('ê', '\u00ea');
    mensagem = mensagem.replace('É', '\u00c9');
    mensagem = mensagem.replace('È', '\u00c8');
    mensagem = mensagem.replace('Ê', '\u00ca');
    mensagem = mensagem.replace('Ë', '\u00cb');
    mensagem = mensagem.replace('í', '\u00ed');
    mensagem = mensagem.replace('ì', '\u00ec');
    mensagem = mensagem.replace('î', '\u00ee');
    mensagem = mensagem.replace('ï', '\u00ef');
    mensagem = mensagem.replace('Í', '\u00cd');
    mensagem = mensagem.replace('Ì', '\u00cc');
    mensagem = mensagem.replace('Î', '\u00ce');
    mensagem = mensagem.replace('Ï', '\u00cf');
    mensagem = mensagem.replace('ó', '\u00f3');
    mensagem = mensagem.replace('ò', '\u00f2');
    mensagem = mensagem.replace('ô', '\u00f4');
    mensagem = mensagem.replace('õ', '\u00f5');
    mensagem = mensagem.replace('ö', '\u00f6');
    mensagem = mensagem.replace('Ó', '\u00d3');
    mensagem = mensagem.replace('Ò', '\u00d2');
    mensagem = mensagem.replace('Ô', '\u00d4');
    mensagem = mensagem.replace('Õ', '\u00d5');
    mensagem = mensagem.replace('Ö', '\u00d6');
    mensagem = mensagem.replace('ú', '\u00fa');
    mensagem = mensagem.replace('ù', '\u00f9');
    mensagem = mensagem.replace('û', '\u00fb');
    mensagem = mensagem.replace('ü', '\u00fc');
    mensagem = mensagem.replace('Ú', '\u00da');
    mensagem = mensagem.replace('Ù', '\u00d9');
    mensagem = mensagem.replace('Û', '\u00db');
    mensagem = mensagem.replace('ç', '\u00e7');
    mensagem = mensagem.replace('Ç', '\u00c7');
    mensagem = mensagem.replace('ñ', '\u00f1');
    mensagem = mensagem.replace('Ñ', '\u00d1');
    mensagem = mensagem.replace('&', '\u0026');
    mensagem = mensagem.replace('\'', '\u0027');
    ///
    return mensagem;
    ///
}
/*****************  Final  -- function acentuarAlerts(mensagem)   ***************************/
///
///
function dochange(source,val) {
    /// Verificando se a function exoc existe 
    if(typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
        /****  
         Define o caminho HTTP    -  20180605
    ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";     
    ///
    var lcopcao = source.toUpperCase();
    if( lcopcao=="VOLTAR" ) {
      // top.location.href="http://www-gen.fmrp.usp.br/rexp/authent_user.php";
       // top.location.href="http://sol.fmrp.usp.br/rexp/";
       /////  top.location.href="index.php";
       top.location.href=raiz_central;
       return;     
    }  
    ///
    /*
       SAIR DO SITE
   */
   if( lcopcao=="SAIR" ) {
       //  top.location.href="http://www-gen.fmrp.usp.br/";
       //      return;  
      // top.location.href="http://www-gen.fmrp.usp.br/";
      //  Sair do Site fechando a Janela
      var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
      var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
      var navegador =navigator.appName;
      var pos = navegador.search(/microsoft/gi);
      //  if( pos!=-1 ) {
      //  if( navegador.search(/microsoft/gi)!=-1 ) {        
      if( is_firefox!=-1 ) {
           ///  Sair da pagina e ir para o Site da FMRP/USP
           location.replace('http://www.fmrp.usp.br/');                
           /// window.open('','_parent','');window.close();    
            ///  window.opener=null; 
            ///  window.close();            
      } else if( is_chrome!=-1  || pos!=-1  ) {
              window.opener=null; 
              window.close();            
      }
      return;
   }  
  //
}
/// 
/* ]]> */
</script>
<?php
/****       Arquivo javascript em PHP       ***/
///  
include("{$_SESSION["incluir_arq"]}js/cadastrar_auto_por_email_js.php");
///
$_SESSION["n_upload"]="ativando";
//  Para fazer mudar de pagina no Menu
//  require_once("includes/dochange.php");
//   CADASTRAR NOVO ORIENTADOR
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//
?>
</head>
<body  id="id_body"   oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$incluir_arq}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<div>
<?php
// Menu Horizontal
// Alterado em 20120912 - Voltar a function como dochange
$_SESSION["function"]="dochange";
//
include("{$incluir_arq}includes/menu_horizontal.php");    
////   include("includes/menu_horizontal_index.php");
//
?>
</div>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<?php 
///   
$_SESSION["cols"]=4;	
///  Tabela PESSOA mas passa como PESSOAL
$_SESSION["onsubmit_tabela"]="PESSOAL";

///   IP do usuario conectado
if ( isset($_SERVER["REMOTE_ADDR"]) )    {
    $usuario_ip = $_SERVER["REMOTE_ADDR"];
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
    $usuario_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    $usuario_ip = $_SERVER["HTTP_CLIENT_IP"];
} 
//  $ips_permitidos = array("143.107.143.231","143.107.143.232","189.123.108.225",$usuario_ip);
$ips_permitidos = array("143.107.143.231","143.107.143.232","189.123.108.225",$usuario_ip);
//  if( $indice ) {
if( ! in_array($usuario_ip, $ips_permitidos) ) {
    ?>
    <script type="text/javascript">
       /* <![CDATA[ */
       alert("P?gina em constru??o")       
      /* ]]> */
   </script>
   <?php
   echo "<p style='text-align: center; font-size: medium;' >P&aacute;gina em constru&ccedil;&atilde;o</p>";
   echo "<p style='text-align: center; font-size: x-small;' >";
   ?>
   <a  href="<?php echo $host_pasta;?>authent_user.php"  name="voltar" id="voltar"   class="botao3d"  style="font-size: 10px; height: 160px; cursor: pointer; "  title="Voltar"  acesskey="V"  alt="Voltar" >    
      Voltar&nbsp;<img src="imagens/enviar.gif" alt="Voltar"   style="vertical-align:text-bottom;"  >
   </a>
   <?php
   echo "</p>";
   exit();
}
$_SESSION["m_titulo"]="orientador";
//  @require_once('../inicia_conexao.php');  once = somente uma vez
//  include('inicia_conexao.php');
//
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
//  Formatando a Data no formato para o Mysql
$dia = date("d");
$mes = date("m");
$ano = date("Y"); 
$ano_validade=$ano+2;
$_SESSION['datacad']="$ano-$mes-$dia";
$_SESSION['datavalido']="$ano_validade-12-31";
$_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|salatipo|sala";        
$vars_ambiente=$_SESSION["VARS_AMBIENTE"];   
//
//  PA:  superusuario,  chefe,  subchefe, orientador, anotador  -  Tabela PA
//  if( $_SESSION["permit_pa"]<=$array_pa['orientador']  ) {
# 
?>
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Solicita&ccedil;&atilde;o de Cadastro para&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?>&nbsp;de Projeto</p>
</section>
<!-- Final - Mensagem de ERRO e Titulo    -->
<h3 class="titlehdr" style="margin: 4px;" ></h3>
<div id="div_form" class="div_form" style="overflow:auto; background-color: #FFFFFF;" >
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main" style="background-color: #FFFFFF;" >
  <tr>
    <td  valign="top">
        <table width="99%" border="0" cellpadding="4" cellspacing="4" class="loginform"  style="margin-top: 0px; top:0px; padding-top: 0px;">
          <tr style="height: 3em;"  > 
            <td class="td_inicio1" style="vertical-align: middle; font-size: medium; cursor: pointer;"  >
              <!--  EMAIL -->
               <label for="e_mail" style="cursor: pointer;"  title="Digitar seu E_MAIL" >Digitar seu E_MAIL:&nbsp;</label>
              </td>
               <td  class="td_inicio2" style="vertical-align: middle;" >
                  <input type="text" name="e_mail"  id="e_mail"   size="80"  maxlength="64" 
                   title="Digitar seu E_MAIL"   autocomplete="off" style="height: 1.6em;"  />
                  <!-- Final - EMAIL -->
               </td>
             </tr>    
         
             <tr> 
               <td  align="center"  style="text-align: left; ">
                  <button  type="submit"  name="continuar" id="enviar" class="botao3d"  style="cursor: pointer; width: 160px; font-size: medium;"  title="Continuar"  acesskey="C" 
                   alt="Continuar"  onclick="javascript: campos_obrigatorios('e_mail',e_mail.value)" >
      Continuar&nbsp;<img src="imagens/enviar.gif" alt="Enviar"  style="vertical-align:text-bottom;"  >
                   </button>
                </td>
             </tr>            
       </table>
   </td>
</tr>  
</table>
<!-- DIV  id form_novo_orientador - oculto -->
<div id="form_novo_orientador" align="left" style="margin-top: 0px; padding: 0px; width:100%; overflow:hidden; height: 100%; display: none; position:relative;" >
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  onsubmit="javascript: enviando_dados('submeter','orientador_novo',document.form1); return false;"  >
  <table class="table_inicio" cols="<?php echo $_SESSION["cols"];?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; overflow:hidden;"  >
      <tr style="margin: 0px; padding: 0px; "  >
	   <td    class="td_inicio1" style="text-align: left; margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	      <table style="text-align: left;margin: 0px; padding: 0px;"  >
		   <tr>
	       <td  class="td_inicio1" style="border: none;  vertical-align: middle; text-align: left;padding-right: 7px;" colspan="2"  >
		   <!-- CODIGO/USP - digitar -->           
      <label for="codigousp" style="vertical-align: middle; padding-bottom: 2px;cursor: pointer;">C&oacute;digo/USP:&nbsp;</label>
       <!--  permite apenas numeros -  javascript: mascara(this,soNumeros) -->
	  <input type="text" name="codigousp"   id="codigousp"   size="22"  maxlength="16"  value="0" onfocus="javascript:  document.getElementById('label_msg_erro').style.display='none';"  onkeyup="javascript: this.value=trim(this.value); mascara(this,soNumeros) "   onblur="javascript: alinhar_texto(this.id,this.value); campos_obrigatorios('campos_obrigatorios',this.id,this.value)" autocomplete="off"  style="cursor: pointer;"  />
      <span class="example" >** Digitar caso tenha (sem digito), sen?o digite 0</span>
			 </td>
          <!-- Final - CODIGO/USP -->
         </tr>
         <tr>
            <!--  Nome da Pessoa -->
	       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" colspan="2"  >
              <label for="nome" style="vertical-align: middle; padding-bottom: 1px;cursor: pointer;" title="Nome"   >Nome:&nbsp;</label>
			  <input type="text" name="nome"   id="nome"   size="85"  maxlength="64" title='Digitar Nome'  onblur="javascript: alinhar_texto(this.id,this.value); " autocomplete="off"  style="cursor: pointer;"  />
			 </td>
          <!-- Final - Nome -->
          <!-- SEXO -->
	       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
             <label for="sexo" style="vertical-align: middle; padding-bottom: 1px;cursor: pointer;" title="Sexo"  >Sexo:&nbsp;</label>
			  <select name="sexo"   id="sexo"   title="Selecionar Sexo"    >
  			     <option value="" >Selecione... </option>
			     <option value="F" >Feminino</option>
   			     <option value="M" >Masculino</option>
			 </select>   
             <!-- Final - Sexo -->
			 </td>
            </tr>
          </table>
		  </td>
		  </tr>

        <tr align="left"  >
            <!--  CPF  -->
              <td  class="td_inicio1" style="text-align: left; vertical-align: middle; "    >
                 <label for="cpf" style="vertical-align: middle; cursor: pointer;" title="Digitar CPF"   >CPF:&nbsp;</label>
              <input type="text" name="cpf" id="cpf" onkeydown="javascript: backspace(event,this)"  onKeyUp="javascript: mascara_cpf(this.value,event)"  maxlength="14" SIZE="15"  title='Digitar CPF'  autocomplete="off"  style="cursor: pointer;"  />
          <!-- Final - CPF -->
          <!--  PASSAPORTE -->
              <label for="passaporte" style="padding-left: 4px; vertical-align: middle; cursor: pointer;" title="Digitar passaporte"   >PASSAPORTE:&nbsp;</label>
              <input type="text" name="passaporte"   id="passaporte"   size="22"  maxlength="16"   onKeyUp="this.value=trim(this.value);"   onblur="javascript: alinhar_texto(this.id,this.value)" autocomplete="off"  style="cursor: pointer;"  />
             </td>
          <!-- Final - PASSAPORTE -->
             <td  class="td_inicio1" style="vertical-align: middle; text-align: left;"  colspan="<?php echo $_SESSION["cols"]/2;?>" >
          <?php
              ///  CATEGORIA => Cargo/Fun??o
              $elemento=5;
              ///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");    
              include("php_include/ajax/includes/conectar.php");                    
              $result=mysql_query("SELECT codigo,descricao FROM pessoal.categoria order by codigo ");
              ///          
              if( ! $result ) {
                   $msg_erro  .= "Select Tabela categoria - db/mysql:&nbsp;".mysql_error().$msg_final;
                   echo  $msg_erro;
                   exit();                                                        
              }              
          ?>
          <span class="td_informacao2"  >
              <label for="categoria"  style="vertical-align: middle; cursor: pointer;" title="Categoria"    >Categoria:</label>
              <select name="categoria" class="td_select"   id="categoria"  title="Selecionar Categoria"  onblur="javascript: campo_n_vazio(this.id,'label_msg_erro');"   >            
                  <?php
                      //  Categoria
                      $m_linhas = mysql_num_rows($result);
                      if ( $m_linhas<1 ) {
                          echo "<option value='' >Nenhuma Categoria definida.</option>";
                      } else {
                      ?>
                      <option value='' >Selecione...</option>
                      <?php
                          // Usando arquivo com while e htmlentities
                          include("includes/tag_select_tabelas.php");
                      ?>
                  </select>
              </span>
              <?php
                  mysql_free_result($result); 
              }
              // FINAL - Categoria
          ?>  
        </td>
       </tr>
		  
      <tr syle="margin: 0px; padding: 0px; line-height: 10px; "  >
        <!--    ESSA PARTE DESATIVADA 
        <td class="td_inicio1" style="vertical-align: middle; text-align: left;"  colspan="<?php echo $_SESSION["cols"]/2;?>"  >
          <?php
              //  PA => Privilegio de acesso
              $elemento=6;      // Selecionando o BD rexp
              include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");                    
              $result=mysql_query("SELECT codigo,descricao FROM rexp.pa order by codigo ");
              if ( ! $result ) {
                   mysql_free_result($result);
                   die("ERRO: Select Tabela pa - ".mysql_error());
              }              
          ?>
          <span class="td_informacao2"  >
              <label for="pa"  style="vertical-align: middle; cursor: pointer;" title="Categoria"    >PA:</label>
              <select name="pa" class="td_select"   id="pa"  title="Selecionar PA (privilegio de acesso)"   >            
                  <?php
                      //  PA
                      $m_linhas = mysql_num_rows($result);
                      if ( $m_linhas<1 ) {
                          echo "<option value='' >Nenhum PA definido.</option>";
                      } else {
                      ?>
                      <option value='' >Selecione... </option>
                      <?php
                          // Usando arquivo com while e htmlentities
                          include("includes/tag_select_tabelas.php");
                      ?>
                  </select>
              </span>
              <?php
                  mysql_free_result($result); 
              }
              // FINAL - PA
          ?>  
        </td>
        -->
      </tr>	
		
	   <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td  class="td_inicio1" style="border: none;text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	      <table style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
		   <tr  >
	       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;"  >
 	    	<?php
				   //  INSTITUICAO
	             $elemento=3;
	            include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");				    
                //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_query()
				//  $result=mysql_db_query($db_array[$elemento],"SELECT sigla,nome FROM $bd_1.instituicao order by nome ");
                $result=mysql_query("SELECT sigla,nome FROM $bd_1.instituicao order by nome ");
                if ( ! $result ) {
                     mysql_free_result($result);
                     $msg_erro  .= "Select Tabela instituicao - db/mysql: ".mysql_error().$msg_final;
                     echo  $msg_erro;
                     exit();                    
                }
		     ?>
            <label for="instituicao"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Institui&ccedil;&atilde;o"   >Institui&ccedil;&atilde;o:</label>
			   <br /><br />
                 <select name="instituicao" class="td_select" id="instituicao"  onchange="javascript: enviando_dados('CONJUNTO',this.value,this.name+'|'+'<?php echo $vars_ambiente;?>');"  onblur="javascript: campo_n_vazio(this.id,'label_msg_erro');"   style="padding: 1px;" title="Institui&ccedil;&atilde;o"  >			
			   <?php
  				  //  INSTITUICAO
                 $m_linhas = mysql_num_rows($result);
                 if ( $m_linhas<1 ) {
                        echo "<option value='' >Nenhuma Institui&ccedil;&atilde;o encontrada.</option>";
                 } else {
				   ?>
 		           <option value='' >Selecione...</option>
					<?php
				     // Usando arquivo com while e htmlentities
 					 include("includes/tag_select_tabelas.php");
					 ?>
                     <option value='Outra' >Outra</option>
	              </select>
	               </span>
					<?php
                    mysql_free_result($result); 
                  }
 				  // Final da Unidade
				  ?>
			  </td>				  
				   <?php
				   $td_campos_array = explode("|",$_SESSION["VARS_AMBIENTE"]);
				   /* Dica sobre o count ou sizeof 
				      Evite de usar for($i=0; $i < count($_linhas); $i++. Use: 
                           $total = count($_linhas); 
				           for($i=0; $i < $total; $i++) 
                      Pois o for sempre ir? executar a fun??o count, 
					  pesando na velocidade do seu programa. 
                   */ 
				   // Nao comeca no Zero porque ja tem o primeiro campo acima - UNIDADE
				   $total_array = count($td_campos_array);
				   for( $x=1; $x<$total_array; $x++ ) {
	   				    $id_td = "td_".$td_campos_array[$x];
				   		echo  "<td  nowrap='nowrap'  class='td_inicio1' style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;display:none; '   "
						        ."   name=\"$id_td\"    id=\"$id_td\"    >";
				        echo '</td>';
					}
					?> 

	    </tr>	
		</table>
		</td>
		</tr>
		
		
      <tr syle="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td    class="td_inicio1" style="vertical-align: middle; text-align: left;"  colspan="<?php echo $_SESSION["cols"];?>"  >
   	      <!-- font indicando bens encontrados -->
             <font id="tab_de_bens" style="display: none;"  ></font>			  
   	      <!-- Final - font indicando bens encontrados -->		   
	    </td>
	  </tr>    
		
      <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td  class="td_inicio1" style="border: none; text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	      <table style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
		   <tr style="border: none;" >
           <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
           <!-- Telefone - digitar -->
      <label for="fone" style="vertical-align: middle;cursor: pointer;"  title="Telefone" >Telefone (dd)-fone:&nbsp;</label>
      <input type="text" name="fone"  id="fone" class="required" size="30"  maxlength="25" title="Digitar Telefone somente n&uacute;mero incluindo dd "  onkeypress="javascript: mascara(this,telefone);"  onblur="javascript:  exoc('label_msg_erro',0,'');  campo_n_vazio(this.id,'label_msg_erro');"  >
               <!-- Final - Telefone -->
             </td>     

	       <td  class="td_inicio1" style=" vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
		   <!-- RAMAL - digitar -->
      <label for="ramal" style="vertical-align: middle;cursor: pointer;"  title="Ramal" >Ramal:&nbsp;</label>
	  <input type="text" name="ramal"   id="ramal"   size="16"  maxlength="10" onKeyUp="this.value=trim(this.value);"   onblur="javascript: alinhar_texto(this.id,this.value); campo_n_vazio(this.id,'label_msg_erro');"  autocomplete="off"  style="cursor: pointer;"  />
			   <!-- Final - Ramal -->
               <!-- PA do Orientador -->
               <input type="hidden"  name="pa" id="pa" value="<?php echo $array_pa['orientador'];?>" />
               <!-- Final do PA do Orientador -->
               <!-- EMAIL dentro do FORM - depois do campo E_MAIL (e_mail) -->
               <input type="hidden"  name="email" id="email"  />
               <!-- Final do EMAIL do FORM -->
             </td>     
            </tr>
          </table>
		  </td>
		  </tr>  

      <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
       <td  class="td_inicio1" style="border: none; text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
          <table style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
            <tr valign="middle"  >
              <td  class="td_inicio1"  width="50%" height="70" >
                  <img  id="codigo_img"  src="imagens/senhav0.gif"  height="80"  width="100%" style="vertical-align: middle"   />
                  <input type="hidden"  id="magica" name="magica" value=""  />
                  </td>
                <td class="td_inicio2" style="vertical-align:middle;"    >
                  <label  for="confirm" class="label_campos" >C&oacute;digo:&nbsp;</label>
                  <input align="left" name="confirm" type="text" id="confirm" size="8"
               maxlength="5"   onfocus="javascript: id_conteudo('liga','Digitar c&oacute;digo com 5 caracteres');"
               onblur="javascript: id_conteudo('','');"  title="Digitar c&oacute;digo com 5 caracteres"    autocomplete="off"   style="cursor:pointer;"  tabindex="3"    />        
              </td>
            </tr>
          </table>
        </td>
       </tr>
          

           <!--  TAGS  Type Reset e  Submit  --> 
           <tr align="center" style="border: 2px solid #000000; vertical-align:top; line-height: 0px;" >
             <td colspan="<?php echo $_SESSION["cols"];?>" align="CENTER" nowrap style=" padding: 1px; text-align:center; border: none; line-height:0px;">
			  <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; line-height: 0px; margin:0px; padding: 2px 0 2px 0; border: none; vertical-align: top; " >
			    <tr style="border: none;">
				<td  align="CENTER" nowrap style="text-align:center; border:none;" >
			   <button name="limpar" id="limpar"  type="reset" onclick="javascript: document.getElementById('msg_erro').style.display='none';"  class="botao3d" style="cursor: pointer; "  title="Limpar"  acesskey="L"  alt="Limpar"     >    
      Limpar <img src="imagens/limpar.gif" alt="Limpar" style="vertical-align:text-bottom;" >
   </button>
		      </td>
              <!-- Enviar -->                  
			   <td  align="center"  style="text-align: center; border:none; ">
			   <button  type="submit"  name="enviar" id="enviar" class="botao3d"  style="cursor: pointer; "  title="Enviar"  acesskey="E"  alt="Enviar"      >    
      Enviar&nbsp;<img src="imagens/enviar.gif" alt="Enviar"  style="vertical-align:text-bottom;"  >
   </button>
			  </td>
              <!-- Final -Enviar -->
			   </tr>
              <!--  FINAL - TAGS  type reset e  submit  -->
			  </table>
			  </td>
            </tr>
         </table>
   </form>
</div>
<!--  FINAL --- DIV  id form_novo_orientador - oculto -->
<?php
////  Alterado em 20120224
/*
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
*/
?>
</div>
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
