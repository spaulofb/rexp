<?php
/*
*   LOTERIA JOGOS - INICIANDO
* 
*       MODULO: index 
*  
*   SPFB110827.1708 - Correlacoes gerais

*/
///  Verificando se sseion_start - ativado ou desativado
if( !isset($_SESSION)) {
     session_start();
}
///
///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');
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
/***   Final -  Mensagens para enviar   ***/
///
////  Navegador permitido
require_once('navegador_permitido.php');
//*************************************************************************
///
$_SESSION["url_central"]="";
////  Pasta original
$_SESSION["pasta_raiz"]='/jogos/';
$pasta_raiz=$_SESSION["pasta_raiz"];
///
///  Diretorio principal exe /var/www/html/aqui
///  $dir_principal=__DIR__;
///
$_SESSION["dir_principal"] = $dir_principal =__DIR__;
$ultcaracter=substr(trim($dir_principal),-1);
if( $ultcaracter<>"/" ) $_SESSION["dir_principal"] = $dir_principal = $dir_principal."/";
///
///  Atualizado - 20180928
///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
///  $_SESSION["protocolo"] = $protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false) ? 'http' : 'https';
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
///
///   Definindo caminho URL
$_SESSION["host_pasta"]="";
if( isset($_SESSION["url_central"]) ) $_SESSION["host_pasta"] = $_SESSION["url_central"] ;
$host_pasta=$_SESSION["host_pasta"];
///
/// $url_script = $_SERVER['SCRIPT_URI'] ;
$url_script = './';
//
// int strrpos ( string $haystack , string $needle [, int $offset = 0 ] )
$pos = strrpos($url_script, "/");
if( $pos===false ) {   //// note: three equal signs
    /// not found...
    echo "Falha de l&oacute;gica.";
    exit;
}
//  string substr ( string $string , int $start [, int $length ] )
$url_folder = substr($url_script,0,$pos) ;
$_SESSION['url_folder']=$url_folder;
///
///
///  IMPORTANTE: para acentuacao em php/jsvascript 
header("Content-Type: text/html; charset=utf-8");
///
///  HOST mais a pasta principal do site - host_pasta
$host_pasta="";
if( isset($_SESSION["host_pasta"]) ) {
     $host_pasta=$_SESSION["host_pasta"];  
} else {
     $msg_erro .= utf8_decode("Sessão host_pasta não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
/// IMPORTANTE:   $dir_principal melhor do que $host_pasta

///
$lc_estilo="{$host_pasta}css/estilo.css";
///
///   Iniciando pagina HTML5
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
<!--  <meta charset="utf-8" />  -->
<meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
<meta name="author" content="SPFB" />
<meta name="language" content="pt-br" />
<meta http-equiv="cache-control"   content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<link rel="shortcut icon"  href="imagens/lj.ico"  type="image/x-icon" />  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Loteria - Jogos</title>
<link  type="text/css"  href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />
<script type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js"  ></script>
<!--  <link  type="text/css"  href="<?php echo $host_pasta;?>css/fonts.css"   rel="stylesheet" >  -->
<script type="text/javascript" src="<?php echo $host_pasta;?>js/functions.js" ></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script>
<style type="text/css"  >
.aumentar_texto { font-size: large;                    
}
.diminuir_texto {  font-size: small;
}

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
<script type="text/javascript">
/*
     Aumentando a Janela no tamanho da resolucao do video
*/
self.moveTo(-4,-4);
//  self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
//  self.resizeTo(1000,1000);
self.focus();
//
//   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
/***
if ( screen.width<1024 ) {
    alert("A resolução da tela do seu monitor para esse site é\n RECOMENDÁVEL no mínimo  1024x768 ")
}
***/
///
///
charset="utf-8";
///
/****  
   Definindo as  variaveis globais  -  20171020

        Define o caminho HTTP
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
///

///
//    Funcoes do Javascript - 20160420  
//
///   Corrigindo acentuacao
///
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
}
/********    Final - function acentuarAlerts  *********************/
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
  
  ///  alert(" LINHA/242/authent_user.php  -  DESKTOP  --   teste tcaction = "+tcaction+"  - lcaction =  "+lcaction+" \r\n procedimento = "+procedimento);  

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
                ///   Verificando campos para enviar dados
                ///    Usuario - id: userid
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
                          m_erro="faltando digitar o usuário.";
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
                /// Enviar dados para o arquivo AJAX
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
           var receber_dados = "autenticar_ajax.php";
           ///
               
               
    alert(" authent_user/500  ------>>> AQUI OKOK --- tcaction = "+tcaction+"  -- procedimento = "+procedimento);                              
  ////   alert(" authent_user/470  -- poststr = "+poststr);               
           
           ///  Funcao  de processamento de resultados do AJAX:
           var inclusao = function(oXML) { 
                 ///
                 var dados_recebidos =  oXML.responseText;
                 var pos = dados_recebidos.search(/Nenhum|Erro/i);  
                 ///  Caso houve erro
                 if( pos!=-1 ) {
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
                      
    alert(" loterica_login/513  ------>>>  pos_iniciar = "+ pos_iniciar+"  <<<--- tcaction = "+tcaction+"  -- procedimento = "+procedimento);                                   
                      
                      if( pos_iniciar!=-1 ) {
                           id_conteudo("Iniciar","iniciar",dados_recebidos);    
                      } else {
                          ///
                          alert("Corrigir erro: "+dados_recebidos);
                          /// MOSTRANDO - mensagem recebeida
                          exoc("label_msg_erro",1,dados_recebidos);
                          ///                                                  
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
                  ///  dinamicamente  via codigo Javascript:  cria um objeto de
                   /// refereªncia  tag input hidden
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
/*********   FInal - function doaction    *********/
///
/// mudar campo com tecla ENTER
function tecla_enter(e,elementid) {
    var e = (e)? e : event;
    /// var t =(e.target)? e.target : e.srcElement;
    if( e.keyCode==13 ) {
       e.keyCode = 9;
         return document.getElementById(elementid).focus();
    }
    if(/* t.type=="text" && */ e.keyCode==13) e.keyCode = 9;
} 

//   Somente numeros - correto 20101008
function numerico(event) {
        /*    var e = (e)? e : event;
        tecla = e.keyCode; */
        var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
        var tecla = keyCode;

        /* Vamos utilizar o objeto event para identificar 
        quais teclas est?o sendo pressionadas. */
        if( !(tecla >= 48 && tecla <= 57 ) && !( tecla==13 ) ) {
                /* A propriedade keyCode revela o Código ASCII da tecla pressionada. 
                Sabemos que os n?meros de 0 a 9 est?o compreendidos entre 
                os valores 48 e 57 da tabela referida. Ent?o, caso os valores 
                não estejam(!) neste intervalo, a fun??o retorna falso para quem
                a chamou. */
                alert("Digitar somente números")                
                return false;
        }
}
//  Verificar a dezena digitada
var jogos_loteria = new Array(["DUPLASENA",6,50],["LOTOFACIL",15,25],["MEGASENA",6,60],["QUINA",5,99]);
var juntando_dezenas = new Array();
function  dez_digitada(e,m_id_name,valor,jogo) {
      // INICIANDO:  Inciar ou Conferir - limpar variavel juntando_dezenas
      if ( e=="limpar_array" ) {
          if ( typeof(juntando_dezenas) != 'undefined' ) {
             if ( juntando_dezenas.length>0 ) {
                elementos_do_array = juntando_dezenas.length;
                for( limpando=0; limpando<=elementos_do_array; limpando++) {
                    juntando_dezenas.shift();
                }
             }    
          }
          return;
      }
      var e = (e)? e : event;
      tecla = e.keyCode;
      if ( e.keyCode==9  )  {
             e.keyCode=0; 
             e.returnValue=false;
             return false;
      }
      for ( i=0; i<jogos_loteria.length; i++ ) {
               if( jogos_loteria[i][0]==jogo.toUpperCase() ) {
                    var numeros_dez = jogos_loteria[i][1];
                    var qta_de_dezenas = jogos_loteria[i][2];
               }
      }
      if( e.keyCode==13 ) {
              // if( typeof(juntando_dezenas)== 'undefined' ) {
                if ( valor<1 ) {
                    alert("Falta digitar número na "+m_id_name)
                    return document.getElementById(m_id_name).focus();
              }  
              if ( !( jogo.toUpperCase()=="QUINA" ) ) {
                  var erro_encontrado = 1;              
                  for ( x=1 ; x<=qta_de_dezenas; x++ ) {
                      if(  valor==x ) {
                        erro_encontrado = 0;
                        break;
                      }    
                  }
              } else  var erro_encontrado=0;
              if ( erro_encontrado==1 ) {
                  alert("Esse número "+valor+" não tem na "+jogo)
                  return document.getElementById(m_id_name).focus();
              }
              var duplicata = 0;
              var numero_dezena = parseInt(m_id_name.substring(6,m_id_name.length));
              if( juntando_dezenas.length<1 ) {
                    juntando_dezenas[parseInt(m_id_name.slice(6))-1]=valor;
              }    else if( juntando_dezenas.length>=1 ) {
                  if( numero_dezena>1 ) {
                         for( nx=0; nx<juntando_dezenas.length; nx++) {
                          if( juntando_dezenas[nx]==valor ) duplicata++;
                        }
                  }    
              }
              if( duplicata>=1 ) {
                    alert("Corrigir duplicata. Número = "+valor)
                    return document.getElementById(m_id_name).focus();
              }
              var nova_dezena = parseInt(m_id_name.slice(6))+1;      
             e.returnValue=true;
             if ( parseInt(nova_dezena)<=parseInt(numeros_dez) ) {
                 juntando_dezenas.push(valor);
                 document.getElementById("dezena"+nova_dezena).focus();
             } else if( parseInt(nova_dezena)>parseInt(numeros_dez) ) {
                   e.keyCode=9; 
                     e.returnValue=true; 
                  return document.getElementById("incluir").click();
             }
             return;
      }
}
//
function adicionar(div_inputs, subdivisoes, jogo,cartao_numero,arq) {
    ///  Para Adicionar cartoes no arquivo ou senao para Conferir 
    var dezenas = "";
       var elements = document.getElementById(div_inputs).getElementsByTagName("*");
    var m_name_recebido = "";
    for (var i = 0; i < elements.length; i++) {
            var m_id_name = elements.item(i).name;
            var m_id_type = elements[i].type;
            if(( typeof m_id_name=='undefined' ) || ( typeof m_id_type=='undefined' ) ) continue;
            if ( m_id_type=='button' ) continue;
            var m_id_value =  elements[i].value;
            if ( m_id_value<1 ) {
                alert("Falta digitar número na "+m_id_name)
                document.getElementById(m_id_name).focus();
                return false;
            } else {
                 if( i>=1 ) dezenas +=",";
                  //  dezenas += m_id_value.toString();
                 dezenas += m_id_value;
            }
    } 
    var array_incluir = new Array(div_inputs,jogo,cartao_numero,arq);
      dochange(array_incluir,dezenas);
    return;
}
//
function inc_exc(div_inputs, subdivisoes, jogo,arq,valor_select) {
  //   var nome_arquivo = trim(document.getElementById(arq).value);
     var nome_arquivo_type = document.getElementById(arq).type;
     if ( nome_arquivo_type=="text" ) {
           var nome_arquivo = trim(document.getElementById(arq).value);
     } else if( nome_arquivo_type=="select-one" ) {
           var nome_arquivo = valor_select;
           arq="arquivo";
     }
   var pos_nome_arquivo = nome_arquivo.search("."+jogo);
   if ( pos_nome_arquivo != -1 ) nome_arquivo = nome_arquivo.substring(0,pos_nome_arquivo);
   if ( nome_arquivo=="" ) {
      alert("Faltou digitar o nome do arquivo para "+div_inputs)
      document.getElementById(arq).value=nome_arquivo;
      return  document.getElementById(arq).focus();
   }
    nome_arquivo = nome_arquivo+"."+jogo;
    var array_incluir = new Array(div_inputs,jogo,arq);
    dochange(array_incluir,nome_arquivo.toLowerCase());
    return; 
}
///
///
var valor_opcao_jogo="";
function opcao(nome_id,valor) {
    document.getElementById("label_msg_erro").style.display="";     
    document.getElementById("label_msg_erro").innerHTML="";
    if( nome_id=="opcao_jogo" ) {
         document.getElementById("label_texto1").style.display="none";         
         valor_opcao_jogo=valor;
    } else if( nome_id=="opcao" ) {
         var valor = new Array(valor_opcao_jogo,valor);
    }
    //  array = [nome_tabela_id,m_element];
    dochange(nome_id,valor);
    return;
}
//
function limpar_div(div, subdivs)  {
    //  Limpando os objetos
   //  document.getElementById("unidade").selectedIndex = 0;
   document.getElementById("label_msg_erro").style.display="none";
   limpar_elements('opcao_de_jogo', true);
   exoc('label_texto1',0);           
}
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
    ///  Limpar essas - DIVs 
    if(  document.getElementById("conteudo") ) document.getElementById("conteudo").style.display="none";
    if(  document.getElementById("inclusao") ) document.getElementById("inclusao").style.display="none";    
    if( tipo_maiusc=="TRIM" ) return true;
    if( tipo_maiusc=="LIMPAR" ) {
       if( document.getElementById("userid") ) document.getElementById("userid").focus();         
    }
    return false;
}   
/*****************  Final - function limpar_campos   ************************/
///
/***
var i=0;
function exoc(id,i) {
   if( i==0 ) {
       document.getElementById(id).style.display="none";
       return  ;
   }
   if( i==1 ) {
       document.getElementById(id).style.display="block";
       i=0;
       return  ;
   }
}
***/
///
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
    if(  document.getElementById("conteudo") ) {
        document.getElementById("conteudo").innerHTML="";  
         if( ativ_desat=="liga" ) document.getElementById("conteudo").innerHTML=mensag;
    }
    ///
  


  ///  var ativ_desat_upper = ativ_desat.toUpperCase();
    ///  Depois qdo foi ACEITO o USUARIO
   //// if( ativ_desat_upper=="INICIAR" ) {
    if( m_dados.search(/#/)!=-1 ) {
        var caminho_http="";
        limpar_campos("limpar");
        ////  Verificar  e desativar ID form
        if( document.getElementById("form") ) {
            ///  Ocultando ID
            exoc("form",0,""); 
        } 
        ///
        ///  Mudando de pagina
        var http_host = m_dados.split("#");
        var LARGURA = screen.width;
        var ALTURA = screen.height;
        var caminho_http=http_host[1];   
        var autorizado=http_host[2];
        /* 
            Caso o navegador nao for microsoft
             var navegador =navigator.appName;
              var pos = navegador.search(/microsoft/gi);
         */           
         var navegador_usado="<?php echo $_SESSION["navegador"];?>";
         var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
         var is_microsoft = navegador_usado.search(/microsoft|ie/gi);
         
         ///  Verificando se o navegador eÂ´ IE ou CHROME
         ///  if( is_chrome!=-1  || is_microsoft!=-1  ) {
        if( parseInt(autorizado)==1 ) {
            if( navegador_usado.toUpperCase()=="CHROME"  || navegador_usado.toUpperCase()=="IE"  ) {
                 ///
                 location.replace(http_host[1]); 
                 return;
            } else {
                 ///  alert(" http_host[1] = "+http_host[1])
                 window.location.replace(http_host[1]);
                 ///   window.close();
                 ///    var win_new = window.open(http_host[1]); 
                 ///    win_new.focus();            
                 ///   
                 return;  
            }        
        }
         ///
    } else {
        alert("FALHA GRAVE. INDEFINIDO.");
    }   
}
/****************  Final - function id_conteudo    ***************************/
///
///
///   Aumentar ou diminuir tamanho do texto
function tamanho_texto(tam_texto) {
    var divs = document.getElementsByTagName('div');
    if ( divs.length>=1 )     {
        tam_texto=="aumentar" ?  x_texto="Aumentando" :  x_texto="Diminuindo";
        alert(x_texto+" o tamanho do texto")
        for(var x = 0; x < divs.length ; x++) {
            var _divs = divs[x];
            if (  tam_texto=="aumentar" ) {
               ///    _divs.className = "aumentar_texto";
               document.body.style.fontSize="large";
            } else if (  tam_texto=="diminuir" ) {
               ///    _divs.className = "diminuir_texto";
                document.body.style.fontSize="x-small";
            }
        }
    }
}
//
</script>
<!--  <script type="text/javascript"  src="js/alinhar_texto.js" ></script>    -->          
</head>
<!--  <body  onload="limpar_elements('opcao_de_jogo', true)"  >  -->
<body id="body"  onload="javascript: cpo1_focus(document.form);"    oncontextmenu="return false"   
    onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);" >
    <?php
///  require para o Navegador que nao tenha ativo o Javascript
require("{$_SESSION["dir_principal"]}js/noscript.php");
///
?>
<!--    <label  id="label_msg_erro" style="display:none; position: relative; text-align: center;" ></label>   -->
<!-- PAGINA -->
<div class="pagina_ini"  >
<!-- CORPO -->
<div class="corpo_iniciando"   >
<!-- Cabecalho -->
<div >
<p style="position:relative; text-align:center; font-weight:bold; font-size: x-large; color:#0000CC; border: .2em double #000000;" >Loteria Jogos</p>
</div>
<!-- Final - Cabecalho -->    
<!-- Recebe mensagens -->
<div  id="label_msg_erro"  style="display:none;" >
 </div>
<!-- Final - Recebe mensagens -->
<!-- Section - class section_inicio  -->   
<section class="section_inicio" style="background-color:#000000;"  >
   <article  class="article_inicio" >
       <div class="usuario_senha" style="vertical-align:bottom; "  >    
          <!--  Digitar  Usuario/EMail -->
             <label for="userid" class="label_campos" title="Digitar usuário" ><span>Usu&aacute;rio:</span></label>
              <input type="text" name="userid"  id="userid" style="width: 100px;" maxlength="12" required="required"  
               onkeypress="myFunction();this.value=this.value.replace(/\s+/g,'');" 
               onfocus="javascript: id_conteudo('liga','Digitar usuário');"   autocomplete="off" 
                   onblur="this.value=this.value.replace(/\s+/g,'');" tabindex="1" 
                   autofocus="autofocus"  title="Digitar usuário"  />
               <!-- Final -  Digitar  Usuario -->     
            </div>        
            <div class="usuario_senha"  >    
               <!-- Digitar Senha -->
               <label for="userpassword" class="label_campos" ><span>Senha:</span></label>
                  <input type="password" name="userpassword"   id="userpassword" size="16" maxlength="14" 
                   onfocus="javascript: id_conteudo('liga','Digitar senha');"  required="required" 
                     onkeypress="myFunction();this.value=this.value.replace(/\s+/g,'');"   autocomplete="off" 
                         onblur="this.value=this.value.replace(/\s+/g,'');"  tabindex="2"  title='Digitar senha'  />  
                <!-- Final - Digitar Senha -->       
            </div>    
     </article>   
     <article  class="article_inicio" >
          <div id="div_imagem_codigo" >
             <!-- Imagem do Codigo  -->
             <img src="captcha_criar.php" id="imagem_codigo"  alt="C&oacute;digo captcha" height="36" width="128" />
         </div>   
         <div class="article_div" >       
            <input type="hidden"  id="magica" name="magica" value=""  />
                <label for="confirm" class="label_campos" ><span>C&oacute;digo:</span></label>
                <input type="text"  name="confirm"  id="confirm"  style="width: 90px;" required="required"
                  onfocus="javascript: id_conteudo('liga','Digitar c&oacute;digo com 5 caracteres');"
                 onkeypress="myFunction();this.value=this.value.replace(/\s+/g,'');"   
                 autocomplete="off"   style="cursor:pointer;margin-left:10px;"   tabindex="3" 
                 onblur="javascript: id_conteudo('','');"  title="Digitar c&oacute;digo com 5 caracteres" />
            <!-- Reiniciar imagem -->
            <input type="reset"  name="novocodigo"  id="novocodigo"  class="botao3d" 
                    style="width: auto; font-size:smaller;font-weight: normal;"  title="Novo c&oacute;digo" 
                      value="Novo c&oacute;digo"  alt="Novo c&oacute;digo"  
                     onclick="javascript: doaction(this.name); return false;" acesskey="N" />
            <!-- Final - Imagem do Codigo  -->         
         </div>
          

        <div class="limpar_enviar"  >
            <!-- RESET/SUBMIT -->
              <input type="reset"  class="botao3d"   name="limpar" id="limpar" style="width: auto; font-size: small;"  
                  title="Limpar"  acesskey="L"  value="Limpar"  alt="Limpar" 
                   onfocus="javascript: limpar_campos('limpar','Limpar');"  onclick="javascript: doaction('RESET');" />
              <input type="submit"  name="enviar"  id="enviar" class="botao3d"  style="width: auto; font-size: small;"
                  acesskey="E"  value="Enviar"  tabindex="4"  alt="Enviar" 
                  onfocus="javascript: id_conteudo('liga','Enviar');" 
                  onclick="javascript: doaction('SUBMIT'); return false;"  title="Enviar"  />                  
            <!-- Final - RESET/SUBMIT -->                  
        </div>
   
     </article>
</section>          
<!-- Final - Section - class section_inicio  -->   
</div>
<!-- Final Corpo -->
<!-- Rodape -->
<div id="rodape"  >
<?php 
///  Rodape
include_once("{$_SESSION["dir_principal"]}includes/rodape_index.php"); 
?>
</div>
<!-- Final do Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>