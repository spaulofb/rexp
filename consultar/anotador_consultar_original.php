<?php 
//   Iniciando conexao - CONSULTAR ANOTADOR
/*
    EDITANDO: LAFB/SPFB110903.0934

    REXP - CONSULTAR ANOTADOR

 
    LAFB/SPFB110901.2219
*/
//  ==============================================================================================
//  ATENCAO: SENDO EDITADO POR LAFB/SPFB  - CONSULTAR ANOTADOR
//  ==============================================================================================
//
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

///  Variavel recebida do script/arquivo - inicia_conexao.php 
$_SESSION["m_horiz"] = $array_projeto;
///
$usuario_conectado = $_SESSION["usuario_conectado"];
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
/// $_SESSION['time_exec']=180000;
//
///  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
///
?>
<!DOCTYPE html >
<html lang="pt-br"  >
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Consultar Anotador</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script  language="javascript"  type="text/javascript"  charset="utf-8" >
/* <![CDATA[ */
///   JavaScript Document
///
var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
///
///   Corrigindo acentuacao
charset="UTF-8";
///
///  variavel quando ocorrer Erros
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
///
///   funcrion acentuarAlerts - para corrigir acentuacao
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
//********************************************************
//
/*   PARA ALTERAR SENHA       */
function enviando_dados(source,val,string_array) {
   ///
    /// Verificando se a function exoc existe
    if( typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe");
    }
    ///  
    ///  Verificando variaveis
    if( typeof(source)=="undefined" ) var source=""; 
    if( typeof(val)=="undefined" ) var val=""; 
    if( typeof(string_array)=="undefined" ) var string_array=""; 
    ///
        if( typeof val=="string" ) val_upper=val.toUpperCase();
    
    /// Verifica se a variavel e uma string
    var source_maiusc=""; var source_array_pra_string="";  
    if( typeof source=='string' ) {
        ///  source = trim(string_array);
        ///  string.replace - Melhor forma para eliminiar espaços no comeco e final da String/Variavel
        source = source.replace(/^\s+|\s+$/g,"");        
        source_maiusc = source.toUpperCase();     
        var pos = source.indexOf(",");     
        if( pos!=-1 ) {  
            ///  Criando um Array 
            var array_source = source.split(",");
            var teste_cadastro = array_source[1];
            var  pos = teste_cadastro.search("incluid");
        }
    }  else if( typeof source=='number' && isFinite(source) )  {
          source = source.value;                
    } else if(source instanceof Array) {
          //  esse elemento definido como Array
          var source_array_pra_string=src.join("");
    }
    ///
    var opcao = source.toUpperCase();
     /****  
          Define o caminho HTTP    -  20180228
     ***/  
     var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
     var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";           
    
////  alert(" CONTINUAR anotador_consultar.js/137 --- INICIO --- source = "+opcao+" -- val = "+val+" -string_array = "+string_array);

    ///  Caso NAO selecionou Projeto
    if( string_array=="" &&  opcao=="PROJETO" && val.toUpperCase()=="PROJETO" ) {
         ///  Caso string_array estiver  nula
         if( string_array.length<1 )  {
              ///  Retornar na pagina - reset 
              location.href=pagina_local;
              return;
         }
    } 
    ///
    if( ( typeof(string_array)!='undefined') && ( opcao=="PROJETO" || opcao=="LISTA" )  ) {
        if( document.getElementById('resultado_anotador') ) {
           document.getElementById('resultado_anotador').style.display="none";    
        }
        var m_id_type  = document.getElementById("projeto").type;
        var m_id_title = document.getElementById("projeto").title;
        var m_id_name  = document.getElementById("projeto").name;
        if( m_id_type=="select-one" ) {  
             var m_id_value = trim(document.getElementById(m_id_name).value);
             if( m_id_value=="" ) {
                   document.getElementById("label_msg_erro").style.display="block";
                   var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center;'>";
                   msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                   var final_msg_erro = "&nbsp;</span></span>";
                   m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                   document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                   document.getElementById(m_id_name).focus();
                   return;
                   ////
             } else {
                  ///  Desativando IDs 
                  exoc("anotacao_escolhida",0);                   
                  exoc("resultado_anotador",0);
                  exoc("div_out",0);
                  ///
             }
        } 
    }
    ///  Utilizando Navegador 
    var browser="";
    if( typeof navegador=="function" ) {
         var browser=navegador();
    }  
    ///
    var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+escape(string_array)+"&navegador="+browser; 
         
    /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca - AJAX   */    
    if( !myConn ) {
          alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    ///
    ///  Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
   ///   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    var receber_dados = "srv_mostraanotador.php";
    ///
     var inclusao = function (oXML) { 
                     ///  Recebendo os dados do arquivo ajax
                     ///  Importante ter trim no  oXML.responseText para tirar os espacos
                     var m_dados_recebidos = trim(oXML.responseText);
                     var lnip = m_dados_recebidos.search(/Nenhum|ERRO:/i);

 ///  alert(" anotador_consultar.php/261 ---> lnip = "+lnip+"  <<<---  opcao = "+opcao+" <<<---  source="+source+" -- val = "+val+"  -- string_array = "+string_array+"  -- \r\n m_dados_recebidos = "+m_dados_recebidos);                                                        

                     ///  Caso ocorreu erro
                     if( parseInt(lnip)!=-1 ) {
                         /*   Caso receber esses dados - centro da pagina:
                                   Nenhuma Anota&ccedil;&atilde;o desse Projeto 
                                   IMPORTANTE: javascript regular expression                             
                         */
                         /// if( m_dados_recebidos.search(/Nenhuma/i)==-1  ) {
                         if( m_dados_recebidos.search(/Nenhuma\s{1,}([A-Za-z&;$#@()*%!]+)\s{1,}desse\s{1,}projeto/i)==-1  ) {    
                              ///  Ativando ID mensagem de erro
                              exoc("label_msg_erro",1,m_dados_recebidos);
                              return;                   
                         }
                     }
                     ////
                     if(  opcao=="CONJUNTO" ) { 
                            var m_elementos = "instituicao|unidade|depto|setor|bloco|sala";
                            var new_elements = m_elementos.split("|");
                            //// Desativando alguns campos
                            document.getElementById("label_msg_erro").style.display="none";
                            if( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                                  limpar_campos(new_elements);
                            } else if( cpo_ant.toUpperCase()=="SALA" ) {
                                  n_sel_opc = 0;
                                  cpo_ant="instituicao";      
                            }
                            ///  Verificando se tem proximo campo ou chegou no Final
                            if( prox_cpo.length>0 ) {
                                 ///  Ativando a tag td com o campo
                                 var id_cpo = "td_"+prox_cpo;
                                 document.getElementById("tab_de_bens").innerHTML= "";
                                 var lsinstituicao = m_dados_recebidos.search(/Institui??o/i);  
                                 var pos = m_dados_recebidos.search(/Nenhum|Erro/i);  
                                 if( pos != -1 )  {
                                     if( lsinstituicao  == -1 )  {
                                           limpar_campos(new_elements);
                                           /// Voltar para o inicio da tag Select
                                           document.getElementById('instituicao').options[0].selected=true;
                                           document.getElementById('instituicao').options[0].selectedIndex=0;
                                           document.getElementById(id_cpo).style.display="none";
                                           mensg_erro(m_dados_recebidos,"label_msg_erro");
                                           ///  Erro limpar font ID = tab_de_bens  - display: none
                                           if( document.getElementById('tab_de_bens') ) {
                                              document.getElementById('tab_de_bens').style.display="none";  
                                           } 
                                           document.getElementById('instituicao').focus();
                                     }  
                                 } else if( pos == -1 ) {
                                      if( n_sel_opc<=m_array_length ) {
                                           /*
                                            document.getElementById(id_cpo).style.display="block";
                                            document.getElementById(id_cpo).innerHTML=m_dados_recebidos;
                                            */
                                           ///  Ativando ID id_cpo
                                           exoc(id_cpo,1,m_dados_recebidos);                   
                                           ///               
                                      }
                                 }
                            }
                     } else if( opcao=="LISTA" ) {
                            /*
                               if( document.getElementById('div_pagina') ) {
                                     document.getElementById('div_pagina').style.display="block";    
                                     document.getElementById('div_pagina').innerHTML=m_dados_recebidos;      
                               } 
                               */
                            ///  Ativando ID div_pagina
                            exoc("div_pagina",1,m_dados_recebidos);                   
                            ///               
                     } else if( opcao=="DETALHES" ) {
                            /// Recebendo dados da Anotacao
                            var myArguments = trim(m_dados_recebidos);
                            /*     
                              if ( showmodal != null)  {                                                                                                                
                                   var array_modal = showmodal.split("#");
                                   if( document.getElementById('div_form')  ) {
                                         if( document.getElementById('id_body')  ) {
                                              document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                         }    
                                         document.getElementById('div_form').innerHTML=showmodal;
                                   }                                                                                           
                              } 
                            */         
                            if( window.showModalDialog) { 
                                   var showmodal = window.showModalDialog("myArguments_anotacao.php",myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                            } else {
                                   ///  Ativando ID anotacao_escolhida
                                   exoc("anotacao_escolhida",1,myArguments);                   
                            }
                            ///
                     } else if( opcao=="DESCARREGAR"  ) {
                           ///
                           var srv_ret = trim(m_dados_recebidos);
                           ///  var array_arq = srv_ret.split("%");
                           var array_arq = srv_ret.split("%#sepa%#rar%#");
                           /// IMPORTANTE:  Abrir Arquivo PDF - Acentuacao comandos escape e decodeURIComponent - Javascript
                           ///  var acertaacentuacao=escape("\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar");
                           ///
                           var acertaacentuacao="\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar";
                           /// 
                           alert(decodeURIComponent(acertaacentuacao));
                           ///  Baixar arquivo Anotacao de um Projeto  
                           self.location.href=raiz_central+"includes/baixar_anotacao.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);                      
                           /// self.location.href=raiz_central+"includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                           ///
                     } else {
                           ////
                           var pos = m_dados_recebidos.search(/UPLOAD/i);
                              
 ///  alert(" anotador_consultar.php/287 ---> ELSE  pos = "+pos+"  ---  opcao = "+opcao+" <<<---  source="+source+" -- val = "+val+"  -- string_array = "+string_array);                                                               
 
                           if( pos != -1 )  {
                               ///
                               var srv_ret = trim(m_dados_recebidos);
                               ///  var array_arq = srv_ret.split("%");
                               var array_arq = srv_ret.split("%#sepa%#rar%#");
                              
                               /// IMPORTANTE:  Abrir Arquivo PDF - Acentuacao comandos escape e decodeURIComponent - Javascript
                               ///  var acertaacentuacao=escape("\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar");
                               ///
                               var acertaacentuacao="\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar";
                               /// 
                               alert(decodeURIComponent(acertaacentuacao));
                               ///  Baixar arquivo Anotacao de um Projeto  
                               self.location.href=raiz_central+"includes/baixar_anotacao.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);                      
                               /// self.location.href=raiz_central+"includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                               ///
                               ///
                           } else {
                                var pos = m_dados_recebidos.search(/Nenhum|ERRO:/i);
                                if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";
                                document.getElementById('label_msg_erro').style.display="none";    
                                if( document.getElementById('resultado_anotador') ) {
                                     document.getElementById('resultado_anotador').style.display="block";    
                                     ///  document.getElementById('div_form').setAttribute("style","padding-top: 2px; text-align: center;font-size: medium;");
                                     document.getElementById('resultado_anotador').innerHTML=m_dados_recebidos;      
                                }                                  
                           }
                     }
           }; 
           /* 
              aqui ? enviado mesmo para pagina receber.php 
               usando metodo post, + as variaveis, valores e a funcao   */
  ///         if( opcao=="DESCARREGAR" ) {      
    ///           var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
       
        var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
        /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
            porisso eu coloquei return false no form o php enviar sozinho             */
       ///
       return;
}  
///  FINAL da Function enviar_dados_cad para AJAX 
///
/* ]]> */
</script>
<?php
///     Alterado em 20170925   
///   require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

///   Consultar - Anotador
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php 
$incluir_arq=trim($_SESSION["incluir_arq"]);
include("{$incluir_arq}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$incluir_arq}includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Consultar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Mensagem de ERRO e Titulo    -->
<?php 
////   IP do usuario conectado
if ( isset($_SERVER["REMOTE_ADDR"]) )    {
    $usuario_ip = $_SERVER["REMOTE_ADDR"];
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
    $usuario_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    $usuario_ip = $_SERVER["HTTP_CLIENT_IP"];
}
///  IPS permitidos  
$ips_permitidos = array("143.107.143.231","143.107.143.232","189.123.108.225",$usuario_ip);
if( ! in_array($usuario_ip, $ips_permitidos) ) {
    ?>
    <script type="text/javascript">
       /* <![CDATA[ */
       alert("P?gina em constru??o")       
      /* ]]> */
   </script>
   <?php
   echo "<p style='text-align: center; font-size: medium;' >P&aacute;gina em constru&ccedil;&atilde;o</p>";
   exit();
}
//
//     Verificano o PA - Privilegio de Acesso
//   INVES de superusuario e?  super
//  if( ( $_SESSION["permit_pa"]>$array_pa['superusuario']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {    
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {  
     /// Para incluir nas mensagens
     /// include_once("../includes/msg_ok_erro_final.php");
     ////      
?>
<div id="div_form" class="div_form" style="overflow: auto;" >
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" style="text-align: center; width:100%;font-size: medium; font-weight: bold;" >Selecione o Projeto:&nbsp;
</p>
</div>
<div class="div_select_projeto"  >
     <?php 
         ///  $elemento=5; $elemento2=6;
           /////  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
  ////           include("php_include/ajax/includes/conectar.php");            
           $sem_projeto=utf8_decode("Esse {$_SESSION["usuario_pa_nome"]} n&atilde;o tem Projeto para adicionar Anotador.");
           ///
           $nerro=0;
           # IMPORTANTE: Aqui esta o segredo
           mysql_query("SET NAMES 'utf8'");
           mysql_query('SET character_set_connection=utf8');
           mysql_query('SET character_set_client=utf8');
           mysql_query('SET character_set_results=utf8');
           ///
           /* Exemplo do resultado  do  Permissao de Acesso - criando array - arquivo array_menu.php
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
           ***/
           if( $_SESSION["permit_pa"]<=$array_pa['orientador']  ) {
                 $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo, "
                      ." b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b  where a.codigousp=b.autor and "
                      ." b.autor=".$usuario_conectado." order by b.titulo "; 
                 ///     
                 $result_projeto = mysql_query($sqlcmd);               
                 ///
                 if( ! $result_projeto ) {
                     /*  $msg_erro .="Selecionando os projetos autorizados para esse {$_SESSION["usuario_pa_nome"]}. db/mysql:&nbsp; ";
                         echo   $msg_erro.mysql_error().$msg_final;  */
                      ///  Parte do Class                
                      echo $funcoes->mostra_msg_erro("Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]}. db/mysql:&nbsp; ".mysql_error());
                      $nerro=1;     
                 }
                 ///  Numero de projetos desse Autor           
                 $m_linhas = $n_projetos=mysql_num_rows($result_projeto);
                 ///  Verificando se NAO tem Projeto
                 if( intval($n_projetos)<1 ) {
                      /*  $msg_erro .=$sem_projeto.$msg_final;
                         echo   $msg_erro; */
                      ///  Parte da Class        
                      ///  echo $funcoes->mostra_msg_erro($sem_projeto);
                      $msg_erro .=$sem_projeto.$msg_final;  
                      echo $msg_erro;               
                      $nerro=1;     
                 }
                 ///
           } else {
                ///  die('Esse Usu&aacute;rio não tem Projeto');                 
                /*  $msg_erro .=$sem_projeto.$msg_final;
                echo   $msg_erro; */
                ////  echo $funcoes->mostra_msg_erro($sem_projeto);
                $msg_erro .=$sem_projeto.$msg_final;  
                echo $msg_erro;               
                $nerro=1;     
           }
           ///                  
           /// Verifica se NAO teve Erro
           if( intval($nerro)<1 ) {
                ///     
                /*
                  while( $linha=mysql_fetch_assoc($result_projeto) ) {
                        $arr_cnc["fonterec"][]=htmlentities($linha['fonterec']);
                        $arr_cnc["fonteprojid"][]=  ucfirst(htmlentities($linha['fonteprojid']));
                        $arr_cnc["titulo"][]=$linha['titulo'];
                        $arr_cnc["cip"][]=$linha['cip'];
                        $arr_cnc["autor_nome"][]=$linha['nome'];
                        $arr_cnc["anotacao"][]=$linha['anotacao'];
                        ///  $arr_cnc["anotacao"][]=$linha['anotacao']+1;
                   }
                   */
                ///  $count_arr_cnc = count($arr_cnc["fonterec"])-1;
                ///  Identifica??o da Fonte de Recurso
                ///  $m_linhas = mysql_num_rows($result_projeto);
                ///
               ?>
                 <select name="projeto" id="projeto" class="Busca_letrai" title="Identifica&ccedil;&atilde;o do Projeto" 
                  onchange="javascript: enviando_dados('projeto',this.id,this.value)" >
                   <?php
                       ///  Verificando registro
                       if( intval($m_linhas)<1 ) {
                            $autor="== Nenhum encontrado ==";
                       } else {
                           ?>
                            <option value="" >Selecione o Projeto que corresponde ao Anotador&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                            <?php
                               ///
                               while( $linha=mysql_fetch_assoc($result_projeto) ) {
                                      $_SESSION["cip"]=$linha['cip'];
                                      $_SESSION["anotacao_numero"]=$linha['anotacao']+1;
                                      $autor_nome = $linha['nome'];  
                                      $fonterec=htmlentities($linha['fonterec']);
                                      $fonteprojid=ucfirst(htmlentities($linha['fonteprojid']));         
                                      //  PARTES do Titulo do Projeto - dividindo em sete partes 
                                      $partes_antes=6;          
                                      $projeto_titulo_parte="";
                                      $palavras_titulo = explode(" ",trim($linha['titulo']));
                                      $contador_palavras=count($palavras_titulo);
                                      for( $i=0; $i<$contador_palavras; $i++  ) {
                                           $projeto_titulo_parte .="{$palavras_titulo[$i]} ";
                                           if( $i==$partes_antes and $contador_palavras>$partes_antes  ) {
                                                $projeto_titulo_parte=trim($projeto_titulo_parte);
                                                $tamanho_campo=strlen($projeto_titulo_parte);
                                                if( intval($tamanho_campo)>40  ) $projeto_titulo_parte.="...";
                                             ///   $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
                                                break;
                                           }
                                      }
                                      ///  Definindo Titulo do Projeto
                                      $titulo_projeto="";
                                      if( strlen(trim($fonterec))>=1  ) {
                                           $titulo_projeto.= $fonterec."/";
                                      }
                                      if( strlen(trim($fonteprojid))>=1  ) {
                                          $titulo_projeto.= $fonteprojid.": ";
                                      }
                                      //  $titulo_projeto .= $titulo;
                                      $titulo_projeto .= trim($projeto_titulo_parte);
                                      ///  Usando esse option para incluir espaco sobre linhas
                                      ///  echo  "<option value='' disabled ></option>";                  
                                      ////  echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >";
                                      $lccip=$linha['cip'];
                                      echo "<option  value='$lccip' title='Orientador do Projeto: $autor_nome' >";
                                      /* IMPORTANTE: Detectar codificacao  de caracteres  - 20171005   */
                                      $codigo_caracter=mb_detect_encoding($titulo_projeto);
                                      /// if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
                                           ////  echo  htmlentities($titulo_projeto)."&nbsp;&nbsp;</option>";   
                                          ///// echo  utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";   
                                           echo  $titulo_projeto."&nbsp;&nbsp;</option>";   
                                          /**
                                      } else {
                                           echo htmlentities($titulo_projeto)."&nbsp;&nbsp;</option>"; 
                                      }
                                      */
                                      ///           
                               }       
                               ///
                           ?>
                           </select>
                          <?php 
                           if( isset($result_projeto) ) mysql_free_result($result_projeto); 
                            ///   
                       }
                       ///
           }
           ///
           ?>  
           <!-- Final da Num_USP/Nome Responsavel  -->     
         <span  id="resultado_anotador" style="margin-top: 0px;  top: 0px;  display:none; width: 100%; text-align: center; overflow:hidden;" ></span>            
</div>
<div  style="position:relative;  display:flex; ">
<!-- id div_out  -->
<section style="float: left;width:100%;" >
<article id="div_out"  class="div_out"  style="width:100%; overflow: auto;">
</article>
<!-- Final - id div_out  -->
<!--  ID - Anotacao escolhida -->
<article  id="anotacao_escolhida" >
</article>
</section>
<!-- Final - Anotacao escolhida -->
</div>
</div>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("{$_SESSION["incluir_arq"]}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>