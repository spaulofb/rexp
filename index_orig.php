<?php
//  Verificando se sseion_start - ativado ou desativado

/// session_save_path('/home/gemac/tmp'); 
if( !isset($_SESSION)) {
     session_start();
}
////
ini_set('default_charset','UTF-8');

//  Navegador permitido
require_once('php_include/ajax/includes/navegador_permitido.php');
//*************************************************************************
///  DEFININDO A PASTA PRINCIPAL - alterado em 20171010
///     $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
///     $_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
/****
///   Definindo caminho http_host e pasta principal 
****/

$_SESSION["url_central"]="";
////  rexp_responsivo para teste - Origianl rexp
//// $_SESSION["pasta_raiz"]='/rexp_responsivo/';
$_SESSION["pasta_raiz"]='/rexp/';
$pasta_raiz=$_SESSION["pasta_raiz"];
///
///   Atualizado 20180928 
///  Diretorio principal exe /var/www/html/aqui
///  $dir_principal=__DIR__;

///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
///
/// $url_script = $_SERVER['SCRIPT_URI'] ;
$url_script = './';
//
// int strrpos ( string $haystack , string $needle [, int $offset = 0 ] )
$pos = strrpos($url_script, "/");
if( $pos===false ) {   //// note: three equal signs
    // not found...
    echo "Falha de l&oacute;gica.";
    exit;
}
//  string substr ( string $string , int $start [, int $length ] )
$url_folder = substr($url_script,0,$pos) ;
$_SESSION['url_folder']=$url_folder;

///
///  IMPORTANTE: para acentuacao em php/jsvascript 
header("Content-Type: text/html; charset=utf-8");

///  Titulo do Cabecalho - Topo
$_SESSION["titulo_cabecalho"]="Registro de Anota&ccedil;&atilde;o";
//
$parte1 = "9c75%";                                   
$_SESSION['parte1'] = $parte1;
$_POST['parte1'] = $parte1;
$_SESSION['parte2'] = "9c75%";  
$_POST['parte2'] = $parte1;
//  $http_host = $_SERVER["HTTP_HOST"];
//  $http_host = str_replace('_','-',$http_host);
//  $http_host = str_replace('-','_',$http_host);

// $site="http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"]."authent_user.php";

$site = $_SESSION['url_folder']."/authent_user.php";
// header("Location: $site");
unset($_SESSION["m_horiz"]);
///
///   Alterado em 20171031
$incluir_arq=$_SESSION["incluir_arq"]="/var/www/html{$_SESSION["pasta_raiz"]}";
//// $_SESSION["incluir_arq"]=$incluir_arq;

///
$_SESSION["host_pasta"]="";
if( isset($_SESSION["url_central"]) ) $_SESSION["host_pasta"] = $_SESSION["url_central"] ;
$host_pasta=$_SESSION["host_pasta"];
///
///
///  Verifica desktop ou aparelho movel - retorna estilo css
include_once("detectar_mobile.php"); 
$estilocss = $_SESSION["estilocss"];
///
///  Verifica caso for MOBILE
$_SESSION["lcportrait"]=$lcportrait="";
if( strtoupper(trim($estilocss))=="ESTILO_MOBILE.CSS"  ) {
    ///  Verifica caso for PORTRAIT 
    $_SESSION["lcportrait"]="<script>if( window.matchMedia(\"(orientation: portrait)\").matches ) document.write('portrait')</script>";
    ////  Caso for Portrait
    if( strtoupper(trim($_SESSION["lcportrait"]))=="PORTRAIT" ) {
        $lcportrait=$_SESSION["lcportrait"];
    }
}
///
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
<meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
<meta name="author" content="SPFB&LAFB" />
<!--  <meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">  -->
<meta http-equiv="PRAGMA"  content="NO-CACHE">
<!--  <meta name="ROBOTS" content="NONE">  -->
<meta name="ROBOTS" content="ALL" > 
<meta http-equiv="Expires"  content="0" >
<meta name="GOOGLEBOT"  content="NOARCHIVE"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--  <meta name="viewport" content="width=device-width, initial-scale=1.0">  -->
<meta name="viewport" content="device-width, initial-scale=1, maximum-scale=1.5">
<title>REXP - Projeto</title>
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<!--  <meta http-equiv="REFRESH"  content="900;URL=http://<?php echo $_SESSION["http_host"];?>" >  -->
<!-- <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  /> -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<link rel="stylesheet"  href="<?php echo $host_pasta;?>css/fonts.css" type="text/css" >
<script type="text/javascript" src="<?php echo $host_pasta;?>js/functions.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!--  <script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script> -->
<script type="text/javascript">
/*
     Aumentando a Janela no tamanho da resolucao do video
     Melhor jeito para todos os navegadores
     fazer logo quando inicia a pagina
*/
self.moveTo(-4,-4);
self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
// self.resizeTo(1000,1000);
//  Melhor maneira para os Navegadores IE, Google Chrome
// void(outerWidth=1024);  
// void(outerHeight=768);
// self.resizeTo(1024, 768);
// window.outerHeight = 768; 
// window.outerWidth = 1024; 

// self.menubar.visible=false;
// self.toolbar.visible=false;
/*
self.locationbar.visible=false;
self.personalbar.visible=false;
self.scrolling.visible=false;
self.statusbar.visible=false;
*/
self.focus();
//
///   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
/// if ( screen.width<1024 ) {
///    alert("A resolução da tela do seu monitor para esse site não\n RECOMENDÁVEL no mínimo 1024768 ")
/// }
///  
//  Iniciando o Programa
function iniciar(enviado) {
    //    document.myform.submit();    Antes era esse
   
    //  Navegador/Browser utilizado
    var navegador =navigator.appName;
    var pos = navegador.search(/microsoft/gi);
    //  Mudando de pagina
 //    var LARGURA = screen.width;
     var LARGURA = 1024;
     var ALTURA = screen.height;        
    //   pos!=-1 -  Navegador Microsoft
    //  if( pos!=-1 ){
 //   if(self.location==top.location) self.location=enviado;
    //  Verificando o Navegador
      var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
      var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
      var navegador =navigator.appName;
      var is_microsoft = navegador.search(/microsoft/gi);
      //  if( pos!=-1 ) {
      //  if( navegador.search(/microsoft/gi)!=-1 ) {      

      if( is_firefox!=-1 ) {
          //  window.open('','_parent','');window.close(); 
          //  netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserWrite");
          //  var abertura=window.open(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");
          var abertura=window.open(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,fullscreen=yes,left=0,top=0,maximize:yes,screenX=0,screenY=0");
//        location.replace(enviado);
        
          window.open('','_self');
          window.close();
          /*   window.opener=null; 
              window.close();            */
           //   window.open('','_parent','');self.close();    
           //    window.opener=null; 
          //  window.close();            
      } else if( is_chrome!=-1  ) {
          // alert(" index_navegador.php/98 -  chrome")
              
          //     var abertura=window.open(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");
          //   var abertura=window.open(enviado,"Projetos","type=fullWindow,closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,fullscreen=yes,left=0,top=0,maximize:yes,screenX=0,screenY=0");
          location.replace(enviado); 
             // abertura.moveTo(0,0);
             //  abertura.focus();
          //      window.opener=null; 
          //    window.close();            
      }  else if( is_microsoft!=-1  ) {
            /// var abertura=window.open(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");
            var abertura=window.open(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,fullscreen=yes,left=0,top=0,maximize:yes,screenX=0,screenY=0");
            window.open('','_parent','');window.close();                  
            /// window.open('http://www-gen.fmrp.usp.br','_parent','');window.close(); 
            setTimeout("",125000);
      }
 
    
  //  location.replace(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");
    //  Abrindo nova pagina
    // abertura.creator=self;
    //  Sair do Site fechando a Janela
  //    window.open('http://www-gen.fmrp.usp.br','_parent','');window.close(); 
      return;  
}
//  Voltar para o site do Depto
function dochange(ativar,m_onload)  {
  //
  var ativar_maiusc = ativar.toUpperCase();
  /*
       SAIR DO SITE
  */
  if( ativar.toUpperCase()=="SAIR" ) {
      // top.location.href="http://www-gen.fmrp.usp.br/";
      //  Sair do Site fechando a Janela
      var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
      var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
      var navegador =navigator.appName;
      var pos = navegador.search(/microsoft/gi);
      //  if( pos!=-1 ) {
      //  if( navegador.search(/microsoft/gi)!=-1 ) {        
      if( is_firefox!=-1 ) {
           //  Sair da pagina e ir para o Site da FMRP/USP
           location.replace($_SESSION['url_folder']);                
           // window.open('','_parent','');window.close();    
            //  window.opener=null; 
            //  window.close();            
      } else if( is_chrome!=-1  || pos!=-1  ) {
              window.opener=null; 
              window.close();            
      }
      //  Caso navegador for google chrome
      /*
      if( is_chrome!=-1  ) {
          window.open('', '_self', ''); // bug fix
          window.close();                            
      } else {
         var is_microsoft =  navigator.appName.toLowerCase().indexOf('microsoft'); 
         //  Caso navegador for microsoft
         if( is_microsoft!=-1 ) {
             window.open('','_parent','');
             window.close();                                                
         } else {
            top.location.href="http://www-gen.fmrp.usp.br/"; 
         }
      }
      */
      return;  
  }  
}
//
//  Conectando
function conectando() {
    //  var newwindow=window.open('http://sol.fmrp.usp.br/rexp/authent_user.php','REXP','resizable=no,toolbar=no,status=no,menubar=no,scrollbars=no,top=1,width=800,height=100');  
    //  var newwindow=window.open('http://sol.fmrp.usp.br/rexp/authent_user.php','REXP','resizable=no,toolbar=no,status=no,menubar=no,scrollbars=no,top=1,left=1,fullscreen=yes');  
    ///
    self.location = 'authent_user.php';
    return;
    
    if(window.focus) { newwindow.focus(); }
    /*  Navegador/Browser utilizado
         var navegador =navigator.appName;
         var pos = navegador.search(/microsoft/gi);
      */ 
      //  Sair do Site fechando a Janela
      var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
      var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
      var navegador =navigator.appName;
      var pos = navegador.search(/microsoft/gi);
      //  if( pos!=-1 ) {
      //  if( navegador.search(/microsoft/gi)!=-1 ) {        
      // if( is_firefox!=-1 ) {
           //  Sair da pagina e ir para o Site da FMRP/USP
      //     location.replace('http://www.fmrp.usp.br/');                
     // } else if( is_chrome!=-1  || pos!=-1  ) {
              //  window.opener=null; 
              //  window.close();         
              window.opener="X";
              window.open('','_parent','')
              window.close();   
     // }
   //    self.close();
   // return false;
    return;
}
//
</script>
</head>
<body onload="javascript: if(window.opener){ window.opener.close();}"  id="id_body" oncontextmenu="return false"   onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"   >
<?php
//  require para o Navegador que nao tenha ativo o Javascript
require("{$_SESSION["incluir_arq"]}js/noscript.php");
///
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
////  $_SESSION["m_horiz"] = $array_sair;
?>
<!-- PAGINA -->
<div class="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho">
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal_index.php");
///
?>
<!-- Final do MENU  -->
<!-- CORPO -->
<section id="corpo"   >
<div  id="label_msg_erro"  >
</div>
<!-- Iniciar o Programa -->
<!--  Final do Iniciar Programa -->
<header class="header_title"  >
    <p><?php echo htmlentities(utf8_decode("Sistemas Técnicos Administrativos - Registro de Anotações (SISTAM/REXP)"));?></p>
</header>
<section class="section_index"  >
<!--  Iniciando Texto -->
<a name="topo"></a>
<h1>Objetivo</h1>
<p>O Registro de Anotações foi proposto pela chefia do Departamento de Genética com o propósito de se criar um
repositório de registro de anotações de experimentos relativos aos projetos de
pesquisas coordenados pelos docentes e pesquisadores vinculados a esse departamento.
Trata-se de um aplicativo desenvolvido para computador, utilizando-se dos
recursos da rede internet, que visa facilitar a introdução, armazenamento e
consulta dos respectivos dados das anotações e projetos através de qualquer
computador que tenha acesso a internet, sendo, porém restrito a usuários
previamente cadastrados.</p>

<h1>Instruções Básicas e Requisitos</h1>
<p  >Considerando-se que o dado relevante a ser registrado (armazenado) é a anotação, seguem recomendações e
requisitos para a introdução da mesma:</p>
<p   >- A <b>anotação</b> deve ser elaborada com objetividade, rigor e segundo normas técnicas e metodológicas, a partir dos
dados e eventos observados durante experimento realizado pelo autor
(aluno/pesquisador/técnico). O documento original da anotação deve ser mantido
em poder do autor e servirá para gerar um arquivo em formato <b>PDF</b> (obrigatório). O arquivo PDF deverá
apresentar alta qualidade (legível em sua totalidade) e poderá ser obtido
através da digitalização ou <b>preferencialmente</b>
através de um <b>editor de texto de boa qualidade</b>, com recursos gráficos de estilos de fontes, parágrafos e imagens.</p>
<h1>Requisitos para cadastrar uma anotação:</h1>
<p   ><span>1.</span>Deve existir previamente um <b>projeto </b>cadastrado pelo <b>orientador, </b>que corresponde a essa
anotação,</p>
<p   ><span>2.</span>Deve existir previamente um <b>anotador </b>cadastrado pelo <b>orientador ou superior, </b>que terá
permissão para fazer anotação ao referido <b>projeto</b>,</p>
<p ><span>3.</span>Orientador de projeto - deve ter sido previamente autorizado (cadastrado) pelo chefe
de departamento como <b>usuário</b> que terá acesso ao aplicativo. Podendo cadastrar projetos e anotadores,</p>
<p ><span>4.</span>Anotador - deve ter sido previamente autorizado (cadastrado) pelo orientador de projetos (ou superiores) como <b>usuário</b> que terá acesso ao aplicativo.
Podendo somente cadastrar anotações.</p>
<p ><span>5.</span>Usuário – deve ter sido previamente autorizado (cadastrado) pelo orientador de projetos (ou superiores) como <b>pessoa</b> que terá acesso ao aplicativo.<br/>
Para cada <b>usuário</b> será atribuído um <b>PA</b> (privilegio de acesso: chefe,
vice-chefe, orientador e anotador), bem como um código de login e senha. Esses
atributos determinarão quais recursos estarão disponíveis ao usuário.</p>
<p ><span>6.</span>Pessoa – deve ter sido previamente
cadastrado em razão do vinculo com o departamento e facilitação de outros
cadastros (qualificação de usuário) para o aplicativo.</p>
</section>
<!--  FINAL da div class section_navegador  -->
<!-- Ir para o topo da pagina -->
<div class="topo_pagina">
<a href="#topo"   >
 <img  title="Início da página" src="imagens/enviar.gif"  border="2"  style="cursor: pointer;" >
</a>
</div>
<!-- Final -- Ir para o topo da pagina -->
</section>
<!-- Final Corpo -->
<!-- Rodape -->
<div id="rodape" >
<?php include_once("{$_SESSION["incluir_arq"]}includes/rodape_index.php");?>
</div>
<!-- Final do Rodape -->
<!-- Final da PAGINA -->
</body>
</html>
