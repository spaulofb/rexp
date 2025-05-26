<?php
/**
*   REXP - REGISTRO DE EXPERIMENTO - ANOTACAO DE PROJETO
* 
*       MODULO: index 
*  
*   LAFB/SPFB110827.1708 - CorreÃ§Ãµes gerais

*/
//  Caso sseion_start desativado - Ativar
if( !isset($_SESSION)) {
     session_start();
}
//
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

///  Verificando SESSION incluir_arq - 20180801
$incluir_arq="";
////  path e arquivo local
$dirarq=$_SERVER['SCRIPT_FILENAME'];
 
////  Arquivo local
$arqlocal =  basename(__FILE__);
$_SESSION["dirprincipal"] = $dirprincipal = str_replace($arqlocal,'',$dirarq);
///
///   Atualizado 20180928 - Correto
///  Diretorio principal exe /var/www/html/aqui
///  $dirprincipal=__DIR__;

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
////  Navegador permitido
require_once('php_include/ajax/includes/navegador_permitido.php');
//*************************************************************************
///  HOST mais a pasta principal do site - host_pasta
$host_pasta="";
if( isset($_SESSION["host_pasta"]) ) {
     $host_pasta=$_SESSION["host_pasta"];  
} else {
     $msg_erro .= utf8_decode("Sessão host_pasta não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
///
///  DEFININDO A PASTA PRINCIPAL 
///  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
///  $_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
$pasta_raiz=$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
/// extract: Importando variÃ¡veis POST para a tabela de sÃ­mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE); 
///
$eliminar=0;
if( isset($parte1) &&  isset($parte2) ) {
    if( $parte1!=$parte2 ) $eliminar=1;
}
if( $eliminar==1 ) exit();
// Eliminar todas as variaveis de sessions
if( ! isset($_POST["userid"]) ) {
  //  $_SESSION = array();
    //  session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_down) ) unset($login_down); 
    if( isset($senha_down) ) unset($senha_down); 
    if( isset($parte1) ) unset($parte1); 
    if( isset($parte2) ) unset($parte2); 

    /*
    if( isset($_POST) ) {
       $_POST = array();
       unset($_POST);     
    } 
    */     
}
//  PA - Ususarios 
$elemento=5; $elemento2=6;
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) {
     $array_pa=$_SESSION["array_pa"];      
     $_POST["array_pa"]=$_SESSION["array_pa"];       
}
 
///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");

///  MENU Horizontal - Voltar
include("{$incluir_arq}includes/array_menu.php");
$_SESSION["m_horiz"] = $array_voltar;
//
/**
    IMPORTANTE: EMAIL GEMAC  atual - 20190329
URGENTE:  Servidor de Email GENBOV SOMENE ENVIA MENSAGEM
    FOI DESATIVADO PELA USP -  SERVIDOR AGORA GOOGLE
*/
/***
     $_POST["gemac"]=$_SESSION["gemac"]="gemacadm@genbov.fmrp.usp.br";
     $_POST["gemac"]=$_SESSION["gemac"]="gemac@sol.fmrp.usp.br";
    $_POST["gemac"] = $_SESSION["gemac"] = "gemac@genbov.fmrp.usp.br";
***/
$_POST["gemac"] = $_SESSION["gemac"] = "spfbezer@gmail.com";

///
////  INICIANDO COOMO CAMINHO PRINCIPAL - ATENCAO
///
///  Verifica desktop ou aparelho movel - retorna estilo css
include_once("{$_SESSION["dirprincipal"]}detectar_mobile.php"); 
$estilocss = $_SESSION["estilocss"];
///
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
<!--  <meta charset="utf-8" />  -->
<meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
<meta name="author" content="SPFB&LAFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="all" > 
<meta http-equiv="Expires" content="0" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta http-equiv="refresh"  content="1900" >
<!--   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Anota&ccedil;&atilde;o de Projeto</title>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js"  ></script>
<!-- <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<link rel="stylesheet"  href="<?php echo $host_pasta;?>css/fonts.css" type="text/css" >
<script type="text/javascript" src="<?php echo $host_pasta;?>js/functions.js" ></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!-- <script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script> -->
<style type="text/css" >
input{
       border: 1px solid #CCCCCC; 
      cursor:pointer;
      padding:1px;
 }
fieldset,#inclusao   {
      margin:0px auto;
      width:25%;
}

#inclusao  {
	    margin:0px auto;
    	font-size: x-small; font-weight: bold;
        width:50%;
}
</style>
<script type="text/javascript"  >
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
//   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
/// if ( screen.width<1024 ) {
///      alert("A resolução da tela do seu monitor para esse site não\n RECOMENDÁVEL mínimo 1024x768 ")
/// }
///
charset="utf-8";
///
///   Verificando se o POP-UP esta desativado
//  var pop = window.open("about:blank","_blank","width=10,height=100,top=0,left=0");
/*
var pop = window.open("testa_popup.html","_blank","width=10,height=100,top=0,left=0");
if( null==pop || true==pop.closed) {
  h = 1;
  // document.write("ATENÃ?Ã?O! Eliminador de popups!");
  alert("ATENÇÃO! Desativar Bloqueador de POP-UP para esse Site.");
} 
***/
/****  
   Definindo as  variaveis globais  -  20171020

        Define o caminho HTTP
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
///
///    Function doaction - primcipal
function doaction(tcaction,procedimento)  {
/*
      Funcao Principal para preparaÃ§Ã£o da aÃ§Ã£o necessÃ¡ria para enviar dados via AJAX

        tcaction = {"Submit";"Reset"}
*/
    /// Verificando se a function exoc existe 
    if( typeof exoc=="function" ) {
          ///  Ocultando ID  e utilizando na tag input comando onkeypress
          exoc("label_msg_erro",0);  
    } else {
         alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
         return;        
    }
    ///
    ///  Verificando variavel
    var erro=0;
    if( typeof(raiz_central)=="undefined" ) erro=1;
    if( parseInt(erro)<1  ) {
        var trimstr=trim(raiz_central);
        var xlen=trimstr.length;
        if( parseInt(xlen)<3 ) erro=1;  
    }
    ///
    if( parseInt(erro)>0 ) {
          alert("ERRO: falha grave SESSION. Consultar administrador.");
          return;
    }
    ///
    if( typeof(tcaction)=="undefined" ) {
         var tcaction="";   
         alert("ERRO: falha grave. Consultar desenvolvedor.");
         return;
    } 
    var lcaction = tcaction.toUpperCase();
    var poststr="";
    ///
    if( typeof(procedimento)=="undefined" )  var procedimento="";
    ///
  
 /// alert(" LINHA/242/authent_user.php  -  DESKTOP  --   teste tcaction = "+tcaction+"  - lcaction =  "+lcaction+" \r\n procedimento = "+procedimento);  

    ///
    switch (lcaction) {
        /// Desativado em 20160921
        /*
       case "SAIR":
            ///  Sair do Site fechando a Janela
            var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
            var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
            var navegador =navigator.appName;
            var pos = navegador.search(/microsoft/gi);
            if( is_firefox!=-1 ) {
                  ///  Sair da pagina e ir para o Site da FMRP/USP
                  location.replace('reiniciar.php');                
             } else if( is_chrome!=-1  || pos!=-1  ) {
                 location.replace('reiniciar.php');                
                  window.open('', '_self', ''); // bug fix
                  window.close();            
             }
             return;
             break;
         */
       case "NOVOCODIGO":  
           ///  Novo Codigo para a pagina inicial
        
           ///  list.removeChild(list.childNodes[0]);
           ///  dynamically add an image and set its attribute
           if( ! document.getElementById("div_imagem_codigo")  ) {
                alert("ERRO: falta incluir a tag DIV id div_imagem_codigo ");
                return;
           }
           ///
           var list = document.getElementById("div_imagem_codigo");
           /// Caso tenha  elementos dessa div_imagem_codigo      
           if( list.hasChildNodes()) {
                ///    list.removeChild(list.childNodes[0]);
                /// Get the first child node of an <ul> element
                var item = document.getElementById("imagem_codigo");
                /// var item = document.getElementById("myLista").childNodes[0];
               ///  Removendo element
               item.parentNode.removeChild(item);
               ///    
           } 
           ///  location.replace(raiz_central+"authent_user.php");   
           var poststr="opcao="+encodeURIComponent("CAPTCHA_CRIAR");
           /*  
            Criando a classe de conexÃ£o AJAX  
        */
           var myConn = new XHConn();
           if( !myConn ) {
                alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
                return false;
           }
           ///
           ///   Para¢metro identificando o procedimento a ser executado pelo AJAX:
           var receber_dados = "captcha_criar.php";
           /// var receber_dados = "captcha_ajax.php";
           ///
           ///  Funcao de processamento de resultados do AJAX:
           var inclusao = function(oXML) { 
                  var dados_recebidos =  oXML.responseText;
                  var pos = dados_recebidos.search(/Nenhum|Erro/i);  
                  ///  Caso houve erro
                  if( pos!=-1 ) {
                       ///  Ocultando ID
                       exoc("conteudo",0,""); 

                       ///  Ocultando ID
                       exoc("inclusao",0,""); 

                       /// MOSTRANDO - mensagem recebeida
                       exoc("label_msg_erro",1,dados_recebidos);
                       return;
                  }
                  ///  Enviando o codigo
                      
                  ///  document.getElementById("imagem_codigo").src=dados_recebidos;
                  ///  document.getElementById("imagem_codigo").setAttribute('src',dados_recebidos);
                  var list = document.getElementById("div_imagem_codigo");
                  /// Reiniciando o elemento 
                  var img=document.createElement("img");
                  img.src="captcha_ajax.php";
                  img.id="imagem_codigo";
                  img.alt='C&oacute;digo captcha';
                  img.title='C&oacute;digo captcha';
                  img.height="36";
                  img.width="128";
                  ///  Incluindo imagem na DIV
                  list.appendChild(img);
                  ///
                 ///  Limpando campo  ID confirm
                  if(  document.getElementById("confirm") ) {
                       document.getElementById("confirm").value=""; 
                       document.getElementById("confirm").focus();
                  }
                  ///
           };              
           /*  enviando para pagina receber.php usando metodo post, + as variaveis, valores e a funcao   */
           ///  myConn.connect("receber.php", "POST", poststr, inclusao); 
           myConn.connect(receber_dados, "POST", poststr, inclusao); 
           break;
       case "VOLTAR":  
           ///  Voltar para a pagina inicial
           location.replace(raiz_central);                
           return;      
           break;
       case "SUBMIT":
           ////      
           if( procedimento=="captcha_criar" ) {
                ///
                var poststr="opcao="+encodeURIComponent(lcaction)+
                     "&procedimento="+encodeURIComponent(procedimento);
           } else {
                ///  Verificando campos para enviar dados
                ///    Usuario/EMail -  id: userid
                var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                msg_erro += "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";
                var msg_final="</span></span>";
                var m_erro="";
                if( document.getElementById("userid") ) {
                     var elemento=document.getElementById("userid");
                     var m_login_down = trim(document.getElementById("userid").value);
                     var login_length=m_login_down.length;
                     ///  Caso esteja vazio o  campo
                     if( parseInt(login_length)<1 ) {
                          m_erro="faltando digitar o email.";
                     } else {
                          ///  EMAIL ou CODIGOUSP  -  Verificar
                          var pos_email=m_login_down.search(/@/);
                          ///
                          if( pos_email!=-1 ) {
                               ///  Caso for EMAIL 
                               ///  Verificando se email valido
                               var emailRE = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                               if( ! emailRE.test(m_login_down) ) var m_erro="EMAIL incorreto";
                               ///
                          }
                          ////  Alterado em 20191122
                          /***
                           else {
                              
                               /// var m_login_down = parseInt(m_login_down);
                          }
                          ****/
                     }
                     ///
                } else {
                     var m_erro="id userid NÃO encontrado.";
                }
                /// Final - verificando Usuario/EMail/CodigoUSP 
                ///
                /// Caso NAO houve erro
                if( m_erro.length<1 ) {
                    ///    SENHA - id: userpassword
                    if( document.getElementById("userpassword") ) {             
                          var elemento=document.getElementById("userpassword");
                          var m_senha_down = trim(document.getElementById("userpassword").value);                     
                          var senha_length=m_senha_down.length;
                          ///  Caso esteja vazio o  campo
                          if( parseInt(senha_length)<1 ) {
                               m_erro="faltando digitar a senha.";
                          }      
                    } else {
                         var m_erro="id userpassword NÃO encontrado.";
                    }
                    ///
                }                  
                ///  Final do teste da SENHA 

                /// Caso NAO houve erro
                if( m_erro.length<1 ) {
                    ///  CODIGO - id: confirm
                    if( document.getElementById("confirm") ) {
                         var elemento = document.getElementById("confirm");     
                         var m_confirm = trim(document.getElementById("confirm").value);                     
                         var confirm_length=m_confirm.length;
                         ///  Caso esteja vazio o  campo
                         if( parseInt(confirm_length)<1 ) {
                             ///  var m_erro="faltando digitar o c&oacute;digo.";
                             var m_erro="faltando digitar o código.";
                         }      
                    }  else {
                        var m_erro="id confirm NÃO encontrado.";
                    }
                    /// 
                }
                ///  Final do teste do confirm - codigo
                /// Caso houve erro
                if( m_erro.length>0 ) {
                     /// Mensagens de erros
                     alert(acentuarAlerts("ERRO: "+m_erro));    
                     ///
                     /// MOSTRANDO - mensagem recebeida
                     msg_erro +=m_erro+msg_final;
                     exoc("label_msg_erro",1,msg_erro);
                     elemento.focus();
                     return;                 
                }
               ///
               ///   var m_cod_img = document.getElementById("magica").value;  
               /*
             var poststr="login_down="+encodeURIComponent(m_login_down)+
                   "&senha_down="+encodeURIComponent(m_senha_down)+"&codigo_down="+
                   encodeURIComponent(m_confirm)+"&m_onload="+encodeURIComponent(lcaction)+
                   "&m_cod_img="+encodeURIComponent(m_cod_img);
             */      
               var poststr="login_down="+encodeURIComponent(m_login_down)+
                      "&senha_down="+encodeURIComponent(m_senha_down)+"&codigo_down="+
                      encodeURIComponent(m_confirm)+"&m_onload="+encodeURIComponent(lcaction);
               ///   
               var id_incluir = "inclusao";
               ///
           }
          /*  
                Criando a classe de conexÃ£o AJAX  
           */
           var myConn = new XHConn();
           if( !myConn ) {
                alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
                return false;
           }
           ///
           ///   ParÃ¢metro identificando o procedimento a ser executado pelo AJAX:
           var receber_dados = "authent_user_ajax.php";
           ///
               
  ////   alert(" authent_user/470  -- poststr = "+poststr);               
           
           ///  Funcao  de processamento de resultados do AJAX:
           var inclusao = function(oXML) { 
                 ///
                 var dados_recebidos =  oXML.responseText;
                 var pos = dados_recebidos.search(/Nenhum|Erro/i);  
                 
///  alert(" authent_user.php/455  - pos = "+pos+"  - teste tcaction = "+tcaction+"  - lcaction =  "+lcaction+" \r\n procedimento = "+procedimento); 
                  
            
                 ///  Caso houve erro
                 if( pos!=-1 ) {
                      ///  Caso reiniciar  a  pagina
                      var pos = dados_recebidos.search(/Reiniciar|reiniciar/i);
                      if( pos!=-1 ) {  
                             /// MOSTRANDO - mensagem recebeida
                             exoc("label_msg_erro",1,dados_recebidos);
                             ///
                             ///  Voltar para a pagina inicial
                             location.replace(raiz_central+authent_user.php);                
                             return;      
                      }    
                      ///  Ocultando ID
                      exoc("conteudo",0,""); 
                      /*
                  if( document.getElementById('conteudo') ) {
                      document.getElementById('conteudo').style.display="none";
                      document.getElementById('conteudo').innerHTML="";
                  }
                  */
                      ///  Ocultando ID
                      exoc("inclusao",0,""); 
                      ///
                     /*
                  if( document.getElementById('inclusao') ) {
                      document.getElementById('inclusao').style.display="none";
                      document.getElementById('inclusao').innerHTML="";                                       
                 }
                   */  
                     /// MOSTRANDO - mensagem recebeida
                     exoc("label_msg_erro",1,dados_recebidos);
                     /*
                    document.getElementById('label_msg_erro').style.display="block";
                    document.getElementById('label_msg_erro').innerHTML=dados_recebidos;
                 */
                     return;
                 }
                 ///  FINAL - Caso houve erro
                 ///
                 ///  Enviando o codigo
                 if( procedimento=="captcha_criar" ) {            
                      document.getElementById("magica").value=dados_recebidos;
                 } else {
                      var pos_iniciar = dados_recebidos.search(/iniciando/i);
                      if( pos_iniciar!=-1 ) {
                           id_conteudo("Iniciar","iniciar",dados_recebidos);    
                      } else {
                          ///
                          var pos = dados_recebidos.search(/logar/i);
                          if( pos==-1 ) {
                               /*
                            document.getElementById('inclusao').style.display="block";
                            document.getElementById('inclusao').innerHTML= dados_recebidos;    
                         */
                               /// MOSTRANDO - mensagem recebeida
                               exoc("inclusao",1,dados_recebidos);
                    
                               ///  Verificando se tem erros nos campos 
                               var poserro = dados_recebidos.search(/ERRO:|NENHUM/i);
                               ///  Encontrou ERRO                                           
                               if( poserro!=-1 ) {
                                    if( document.getElementById("userid") ) {
                                         document.getElementById("userid").onfocus();   
                                    }
                               }
                               ///
                          } else {
                              ///  Ocultando ID conteudo 
                              exoc("conteudo",0,""); 
                              ///
                              /// MOSTRANDO - mensagem recebeida
                              exoc("inclusao",1,dados_recebidos);
                               ///
                          }                                
                      }                             
                }
           };              
           /*  enviando para pagina receber.php usando metodo post, + as variaveis, valores e a funcao   */
           ///  myConn.connect("receber.php", "POST", poststr, inclusao); 
           myConn.connect(receber_dados, "POST", poststr, inclusao); 
           break;
           ///
       case "RESET":
            ///
  
  ///// alert("doaction/RESET="+lcaction)  ;

           var poststr = "m_onload="+encodeURIComponent(m_onload);
           var id_incluir = "codigo_img";
           document.getElementById("codigo_img").src = "imagens/loading.gif";
          /*  
            Criando a classe de conexÃ£o AJAX  
        */
           var myConn = new XHConn();
           if( !myConn ) {
                alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
                return false;
           }
           ///
           ///   ParÃ¢metro identificando o procedimento a ser executado pelo AJAX:
           var receber_dados = "authent_user_ajax.php";
           ///
           ///  Funcao  de processamento de resultados do AJAX:
           var inclusao = function (oXML) { 
                  var palavras = oXML.responseText;
                                           
            /// alert("authent_user.php/152  -- palavrras =  "+palavras);

                  var partes= palavras.split("#");
                  var cod_img_src = partes[0];  var cod_img_value = partes[1];
                  ///  document.getElementById('codigo_img').src = oXML.responseText; 
                  ///  document.getElementById("codigo_img").src = partes[0] ;
                  ///  document.getElementById("codigo_img").setAttribute('src',partes[0]);
                  document.getElementById("codigo_img").setAttribute('src',cod_img_src);
                  ///  document.getElementById("codigo_img").src = partes[0] ;
                  ///  aqui a input hidden de id="dados" recebe um valor 
                  ///  dinÃ¢micamente  via cÃ³digo Javascript:  cria um objeto de
                   /// referÃªncia Ã  tag input hidden
                   if( document.getElementById("magica")  ) {
                         var objetoDados = document.getElementById("magica");
                        ///  altera o atributo value desta tag
                        ///  objetoDados.value = partes[1]; 
                        objetoDados.value = cod_img_value;                                    
                   }
                   return;
           }; 
          /*  enviando para pagina receber.php usando metodo post, + as variaveis, valores e a funcao   */
           ///  var conectando_dados = myConn.connect("receber.php", "POST", poststr, inclusao);   
           var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
           ///  sleep(5000);
           break;
           ///
       default:
           alert("CASE/default"+lcaction) ;
           break;
           ///
    }  
    ///  Final do switch
} 
/// FInal da function doaction
//
///  
function pa_selecionado(opcao,valor) {
    ///
    var ativar_maiusc = opcao.toUpperCase();
    var m_teste = valor.toUpperCase();
    ///
  
//// alert("LINHA/528 -- function  pa_selecionado(opcao,valor) - ativar_maiusc = "+ativar_maiusc);    

    ///  Definindo variavel com dados recebidos
    poststr="";
    if( ativar_maiusc=="PA_SELECIONADO" ) {
         var m_login_down = document.getElementById("userid").value;
         var m_senha_down = document.getElementById("userpassword").value;        
         var poststr="opcao="+encodeURIComponent(ativar_maiusc)+"&permit_pa="+encodeURIComponent(valor)+"&login_down="+
                encodeURIComponent(m_login_down)+"&senha_down="+encodeURIComponent(m_senha_down);      
         /// var id_incluir = "inclusao";
       
         ///  alert("LINHA/528 -- function  pa_selecionado(opcao,valor) "+poststr);  
    }
  
    /*  aqui eu chamo a class  */
    var myConn = new XHConn();
        
    /* Um alerta informando da nÃ£o inclusÃ£o da biblioteca  */
     if( !myConn ) {
          alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
          return false;
     }
     ///  Ocultando ID
     exoc("label_msg_erro",0,""); 
     ///
    /*
       ATENCAO/IMPORTANTE:  
        var receber_dados = pa_selecionado_ajax.php -> Depois que selecionou um PA dos varios
   */     
     var receber_dados = "pa_selecionado_ajax.php";
     ///
     
//// alert("LINHA/528 -- function  pa_selecionado(opcao,valor) - poststr = = "+poststr+"  -- receber_dados = "+receber_dados);         
     
     ///
     var inclusao = function (oXML) { 
             ///  Recebendo dados do arquivo AJAX
             var dados_recebidos =  oXML.responseText;
             var pos = dados_recebidos.search(/Nenhum|Erro/i);  
             ///

   ////  alert("LINHA/693 -- function  pa_selecionado(opcao,valor) - pos = "+pos+"  -- <br/> dados_recebidos =  "+dados_recebidos);         
 
             if( pos!=-1 ) {
                  ///  Mostrando dados recebidos
                  exoc("label_msg_erro",1,dados_recebidos); 
                  /*
                     document.getElementById('label_msg_erro').style.display="block";
                     document.getElementById('label_msg_erro').innerHTML=dados_recebidos;
                  */
             } else {
                  ///  Verificando se PA foi selecionado
                  if(  ativar_maiusc=="PA_SELECIONADO" ) {
                        var pos = dados_recebidos.search(/iniciando/i);
                        if( pos != -1 ) {
                              ///  document.getElementById('inclusao').innerHTML= oXML.responseText;
                             id_conteudo("Iniciar","iniciar",dados_recebidos);    
                        }     
                  }                      
             }
     };              
    /* aqui Ã© enviado mesmo para pagina receber methodo post,+ as variaveis, valores e informar onde vai atualizar */
     ///  myConn.connect("receber.php", "POST", poststr, inclusao); 
 
  //// alert("pa_selecionado#308 - func_exec="+receber_dados+"  - poststr= "+poststr+"  -- inclusao="+inclusao);
 
     myConn.connect(receber_dados, "POST", poststr, inclusao); 
     /*  uma coisa legal nesse script se o usuario nÃ£o tive suporte a JavaScript  
       porisso eu coloquei return false no form o php enviar sozinho */
     return;     
}  ///  FINAL  - Function PA_SELECIONADO
///
///  Limpar campos
function limpar_campos(tipo) {
    var tipo_maiusc= tipo.toUpperCase();
   	var elements = document.getElementsByTagName("input");
    for (var i = 0; i < elements.length; i++) {
	        var m_id_name = elements.item(i).name;
	        var m_id_type = elements[i].type;
            if(( typeof m_id_name=='undefined' ) || ( typeof m_id_type=='undefined' ) ) continue;
    	    if ( m_id_type=='button' || m_id_type=='image' || m_id_type=='reset' || m_id_type=='submit'  ) continue;
        	var m_id_value =  elements[i].value;
            //  LIMPAR todos os campos ou  usar o  TRIM
			if( tipo=="limpar" ) {
				document.getElementById(m_id_name).value="";
				//  document.getElementById(m_id_name).value="";
			} else if( tipo=="trim" ) {
				document.getElementById(m_id_name).value=trim(document.getElementById(m_id_name).value);
			}
	} 
    //  Limpar essas - DIVs 
    if(  document.getElementById("conteudo") ) document.getElementById("conteudo").style.display="none";
    if(  document.getElementById("inclusao") ) document.getElementById("inclusao").style.display="none";    
	if( tipo_maiusc=="TRIM" ) return true;
	if( tipo_maiusc=="LIMPAR" ) {
       if( document.getElementById("userid") ) document.getElementById("userid").focus();         
    }
	return false;
}   
//
//   Function Verificar  popup bloqueado
function _hasPopupBlocker(poppedWindow) {
    var result = false;
    try {
        if (typeof poppedWindow == 'undefined') {
            /// Safari with popup blocker... leaves the popup window handle undefined
            result = true;
            alert("1 - result = "+result)
        } else if( poppedWindow && poppedWindow.closed ) {
            // This happens if the user opens and closes the client window...
            // Confusing because the handle is still available, but it's in a "closed" state.
            // We're not saying that the window is not being blocked, we're just saying
            // that the window has been closed before the test could be run.
            result = false;
            alert("2 - result = "+result)
        } else if( poppedWindow && poppedWindow.test) {
            // This is the actual test. The client window should be fine.
            result = false;
            alert("3 - result = "+result)
        } else if( poppedWindow==null ) {
            //  poppedWindow nulo
            result = true;
            alert("4 - result = "+result)
        }
         ///
    } catch (err) {
        /// if (console) {
        ///    console.warn("Could not access popup window", err);
        ///  }
    }
    ///
    return result;
}
/******   Final  -  function _hasPopupBlocker(poppedWindow)    ***/
///
///
function id_conteudo(ativ_desat,mensag,m_dados) {
     ///  Navegador/Browser utilizado
    var navegador =navigator.appName;
    var pos = navegador.search(/microsoft/gi);
    document.getElementById("conteudo").innerHTML="";
    if( ativ_desat=="liga" ) document.getElementById("conteudo").innerHTML=mensag;

    var ativ_desat_upper = ativ_desat.toUpperCase();
    ///  Depois qdo foi ACEITO o USUARIO
    if( ativ_desat_upper=="INICIAR" ) {
        var caminho_http="";
        limpar_campos("limpar");
        ////  Verificar  e desativar ID form
        if( document.getElementById("form") ) {
            ///  Ocultando ID
            exoc("form",0,""); 
        }      
        /*
        document.getElementById("form").innerHTML="";  //  Deu Certo
        document.getElementById("form").style.display="none";  //  Deu Certo	
        document.getElementById("conteudo").style.display="none";  //  Deu Certo	
         */
        //  Mudando de pagina
        var http_host = m_dados.split("#");
        var LARGURA = screen.width;
        var ALTURA = screen.height;
        var caminho_http=http_host[1];    
        /* Caso o navegador nao for microsoft
           var navegador =navigator.appName;
           var pos = navegador.search(/microsoft/gi);
         */           
         var navegador_usado="<?php echo $_SESSION["navegador"];?>";
         var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
         var is_microsoft = navegador_usado.search(/microsoft|ie/gi);
         
         ///  Verificando se o navegador eÂ´ IE ou CHROME
         ///  if( is_chrome!=-1  || is_microsoft!=-1  ) {
         if(  navegador_usado.toUpperCase()=="CHROME"  || navegador_usado.toUpperCase()=="IE"  ) {
             
////             alert(" CONTINUAR - LINHA/694 -  NAVEGADOR IE OU CHROME"+http_host[1]);
            
               location.replace(http_host[1]); 
               return;
         } else {
    
/*                        
                 alert("LINHA/488 -->> navegador_usado = "+navegador_usado+"  \r\n --caminho_http = "+caminho_http+"   -->>>  ativ_desat = "+ativ_desat+" - mensag = "+mensag+" - m_dados = "+m_dados)        
                  return;
  */                     
                       //  alert(" http_host[1] = "+http_host[1])
                       window.location.replace(http_host[1]);
                     
                       //     window.open('http://www-gen.fmrp.usp.br','_parent','');window.close(); 
                       // } else {
                        //   window.close();
                       //    var win_new = window.open(http_host[1]); 
                       //    win_new.focus();            
                       // }   
                        return;  
         }
    }	
}
///
</script>
</head>
<body id="body"  onload="javascript: cpo1_focus(document.form);"    oncontextmenu="return false"   
    onselectstart="return false"  ondragstart="return false"  
    onkeydown="javascript: no_backspace(event);"     >
<?php
//  require para o Navegador que nao tenha ativo o Javascript
require("{$_SESSION["incluir_arq"]}js/noscript.php");
//
///  DESATIVADO em 20160921 - Menu Sair
/*
   include_once("includes/array_menu.php");
   $_SESSION["m_horiz"] = $array_sair;
*/
///
if( strtoupper(trim($_SESSION["estilocss"]))=="ESTILO_MOBILE.CSS" ) {
    require("login_senha_mobile.php");
} else {
   require("login_senha.php"); 
}
///
?>
</body>
</html>