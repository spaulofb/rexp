<?php
//  Verificando se sseion_start - ativado ou desativado

// session_save_path('/home/gemac/tmp'); 
if( !isset($_SESSION)) {
     session_start();
}

//  Navegador permitido
require_once('php_include/ajax/includes/navegador_permitido.php');
//
// $url_script = $_SERVER['SCRIPT_URI'] ;
$url_script = './';
//
// int strrpos ( string $haystack , string $needle [, int $offset = 0 ] )
$pos = strrpos($url_script, "/");
if( $pos === false) { /// note: three equal signs
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
$_SESSION["titulo_cabecalho"]="Registro de Anotação";
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
///  Verifica desktop ou aparelho movel - retorna estilo css - alterado 20181120
include_once("{$_SESSION["dirprincipal"]}detectar_mobile.php"); 
$estilocss = $_SESSION["estilocss"];
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<!--  <meta http-equiv="REFRESH"  content="900;URL=http://<?php echo $_SESSION["http_host"];?>" >  -->
<link type="text/css" href="css/estilo.css" rel="stylesheet"  />
<script type="text/javascript" src="js/functions.js" ></script>
<script type="text/javascript" src="js/resize.js" ></script>
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
//   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
if ( screen.width<1024 ) {
    alert("A resolução da tela do seu monitor para esse site é\n RECOMENDÁVEL no mínimo  1024x768 ")
}
//  
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
              // var abertura=window.open(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");
              var abertura=window.open(enviado,"Projetos","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,fullscreen=yes,left=0,top=0,maximize:yes,screenX=0,screenY=0");
              window.open('','_parent','');window.close();                  
           // window.open('http://www-gen.fmrp.usp.br','_parent','');window.close(); 
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
    // "<?php echo $_SESSION['url_folder'];?>"
    //
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
<style type='text/css'>
.paragrafo_justificado { text-align: justify; }
</style>
</head>
<body onload="javascript: if(window.opener){ window.opener.close();}"  id="id_body" oncontextmenu="return false"   onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"   >
<?php
//  require para o Navegador que nao tenha ativo o Javascript
require("js/noscript.php");
//
include_once("includes/array_menu.php");
//  $_SESSION["m_horiz"] = $array_sair;
?>
<!-- PAGINA -->
<div class="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho">
<?php include("script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("includes/menu_horizontal_index.php");
?>
<!-- Final do MENU  -->
<!-- CORPO -->
<div id="corpo" style="text-align: center; width: 100%; overflow:hidden ;"  >
<div  id="label_msg_erro" style="display:none; position: relative;width: 100%; text-align: center; overflow:hidden;" >
</div>
<!-- Iniciar o Programa -->
<div style="position: fixed; margin-top:5px; text-align: right; top: 146px;  padding-left: 864px;"  >
<input type="button" style="font-size: 18px; font-weight: bold;  border-bottom-color: #44ff00; border-bottom-width: 5px; cursor: pointer;" title="Clicar" value="Ativar" accesskey="A" onclick="javascript: conectando();" \> 
</div>
<!--  Final do Iniciar Programa -->
<header class="header_title" style="border: none;" >
    <p ><b>Sistemas Técnicos Administrativos – Registro de Anotações (SISTAM/REXP)</b></p>
</header>
<section class="section_navegador" >
<!--  Iniciando Texto -->
<p ><a name="topo"><b>Objetivo</b></a></p>                                                                                                      
<p class="paragrafo_justificado" >O Registro de Anotações foi proposto pela chefia do Departamento de Genética com o propósito de se criar um
repositório de registro de anotações de experimentos relativos aos projetos de
pesquisas coordenados pelos docentes e pesquisadores vinculados a esse departamento.
Trata-se de um aplicativo desenvolvido para computador, utilizando-se dos
recursos da rede internet, que visa facilitar a introdução, armazenamento e
consulta dos respectivos dados das anotações e projetos através de qualquer
computador que tenha acesso a internet, sendo, porém restrito a usuários
previamente cadastrados.</p>


<p><b>Instruções Básicas e Requisitos</b></p>

<p class="paragrafo_justificado" >Considerando-se que o dado relevante a ser registrado (armazenado) é a anotação, seguem recomendações e
requisitos para a introdução da mesma:</p>

<p class="paragrafo_justificado"  >- A <b>anotação</b> deve ser elaborada com objetividade, rigor e segundo normas técnicas e metodológicas, a partir dos
dados e eventos observados durante experimento realizado pelo autor
(aluno/pesquisador/técnico). O documento original da anotação deve ser mantido
em poder do autor e servirá para gerar um arquivo em formato <b>PDF</b> (obrigatório). O arquivo PDF deverá
apresentar alta qualidade (legível em sua totalidade) e poderá ser obtido
através da digitalização ou <b>preferencialmente</b>
através de um <b>editor de texto de boa qualidade</b>, com recursos gráficos de estilos de fontes, parágrafos e imagens.</p>


<p>- <b>Requisitos para cadastrar uma</b> <b>anotação:</b></p>

<p><b>1. </b>Deve existir previamente um <b>projeto </b>cadastrado pelo <b>orientador, </b>que corresponde a essa
anotação,</p>

<p><b>2. </b>Deve existir previamente um <b>anotador </b>cadastrado pelo <b>orientador ou superior, </b>que terá
permissão para fazer anotação ao referido <b>projeto</b>,</p>

<p><b>3.<span>  </span>Orientador de projeto </b>– deve ter sido previamente autorizado (cadastrado) pelo chefe
de departamento como <b>usuário</b> que terá acesso ao aplicativo. Podendo cadastrar projetos e anotadores,</p>

<p><b >4. Anotador </b>– deve ter sido previamente autorizado (cadastrado) pelo orientador de projetos (ou superiores) como <b
style='mso-bidi-font-weight:normal'>usuário</b> que terá acesso ao aplicativo.
Podendo somente cadastrar anotações.</p>

<p><b>5. Usuário </b>– deve ter sido previamente autorizado (cadastrado) pelo orientador de projetos (ou superiores) como <b>pessoa</b> que terá acesso ao aplicativo.</p>

<p>Para cada <b>usuário</b> será atribuído um <b>PA</b> (privilegio de acesso: chefe,
vice-chefe, orientador e anotador), bem como um código de login e senha. Esses
atributos determinarão quais recursos estarão disponíveis ao usuário.</p>

<p><b>6. Pessoa </b>– deve ter sido previamente
cadastrado em razão do vinculo com o departamento e facilitação de outros
cadastros (qualificação de usuário) para o aplicativo.</p>
<div align="right">
<a href="#topo"   ><img  title="Início da página" src="imagens/enviar.gif"  border="2" style="cursor: pointer;" ></a>
</div>
</section>
</div>      
<!-- Final Corpo -->
<!-- Rodape -->
<div id="rodape"  >
<?php include_once("includes/rodape_index.php"); ?>
</div>
<!-- Final do Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
