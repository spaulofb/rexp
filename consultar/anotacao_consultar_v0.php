<?php 
/*   REXP - CONSULTAR ANOTA??O DE PROJETO
*   
*   REQUISITO: O Usuário deve ter PA>0 e PA<=50 
* 
*   LAFB&SPFB110908.1629
*/
//  ==============================================================================================
//  ATENCAO: SENDO EDITADO POR LAFB  - CONSULTAR ANOTACAO
//  ==============================================================================================
//
// Dica: #*funciona?*# Se o que quer ? apenas for?ar uma visualiza??o direta no navegador use
// header("Content-Disposition: inline; filename=\"nome_arquivo.pdf\";"); 
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
///
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
/// $_SESSION['time_exec']=180000;
///
////  INCLUINDO CLASS - 
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
?>
<!DOCTYPE html >
<html lang="pt-br"  >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<meta NAME="ROBOTS" CONTENT="NONE"> 
<meta HTTP-EQUIV="Expires" CONTENT="-1" >
<meta NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Consultar Anotação</title>
<!--  <script type="text/javascript"  language="javascript"   src="../includes/dochange.php" ></script> -->
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script  language="javascript"  type="text/javascript" >
/***
          Javascript Document 
          
    Define o caminho HTTP  -  20180416
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
///   JavaScript Document
///
/****  
    Define o caminho HTTP  -  20180416
***/  
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
///   funcrion acentuarAlerts
/// Criando a function  acentuarAlerts(mensagem)
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
/*********  Final  -- function acentuarAlerts(mensagem)   ********/
///
///  Verifica se foi selecionado o Projeto
function ativar(projeto_selec) {
    /// Verificando parametro projeto_selec
    if( typeof(projeto_selec)=='undefined' ) var projeto_selec="";
    projeto_selec = trim(projeto_selec);
    /**
    if( document.getElementById("div_out") )  {
         document.getElementById("div_out").innerHTML="";
         document.getElementById("div_out").style.display="none";      
    }
     ***/
    ///  Ocultando ID  e utilizando na tag input comando onkeypress
    exoc("div_out",0);  
    ///
    if( document.getElementById("div_form") ) {
        if( document.getElementById("div_form").style.display="none"  ) {
             document.getElementById("div_form").style.display="block";                    
        }     
    } 
    ///
    ////  Ativando ID id_anotacao - caso exista
    if( document.getElementById("id_anotacao") ) {
        if( document.getElementById("id_anotacao").style.display="none"  ) {
            document.getElementById("id_anotacao").style.display="block";   
        }     
         /// Caso exista ID ordernar - Ativar
         if( document.getElementById("ordenar") ) {
             if( document.getElementById("ordenar").style.display="none"  ) {
                 document.getElementById("ordenar").style.display="block";   
             }     
         }
         ///  
    }
    ///
}
/******  FINAL -  function  ativar(projeto_selec)  ********************/
///
///  Function da consulta/anotacao - Ajax
function consulta_mostraanot(idselecproj, idopcao,string_array) {
//
//  Selecionar as ANOTA??ES DE PROJETOS de acordo com a op??o (todos ou pelo campo desejado)
//
//  LAFB/SPFB110831.1127
//  LAFB/SPFB110909.0917
//
//  Parametros:
//      idselecproj = Identifica??o do Select de escolha do projeto
//      idopcao     = Identifica??o da Op??o de sele??o das Anota??es (TODOS, select (ano_incio, ano_final, anota??o)
//
///  Prepara os par?metros para ativação do srv_php
/// Determina qual opcao do Select <idselecproj> foi selecionada:
///
   /// Verificando se a function exoc existe 
    if( typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
    ///  
    var poststr="";
    ///  Verificando variaveis
    if( typeof(idselecproj)=="undefined" ) {
          var tcopcao=""; 
          var idselecproj="";  
    } 
    if( typeof(idopcao)=="undefined" ) {
          var val="";
          var idopcao="";   
    } 
    if( typeof(string_array)=="undefined" ) var string_array=""; 
    ///
    if( typeof(idopcao)=='string' ) {
         var idopcao=trim(idopcao);
    }
     /****  
          Define o caminho HTTP    -  20180228
     ***/  
     var raiz_central="<?php echo $_SESSION["url_central"];?>";       
     var pagina_local="<?php echo $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";           
    
 ///  alert(" anotacao_consultar.php/210 -  idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array)      

    /// tag Select para desativar o campo Select ordenar
    var quantidade=idselecproj.search(/BUSCA_PROJ|busca_porcpo/i);
    if( quantidade!=-1 ) {
        ///  Caso idopcao estiver  nula
        if( idopcao.length<1 )  {
            ///  Retornar na pagina - reset 
            location.href=pagina_local;
             return;
        }
        ///
        if( document.getElementById("ordenar") ) {
              document.getElementById("ordenar").selectedIndex="0";
              document.getElementById("ordenar").style.display="none";            
        }  
    }    
    
    /// BOTAO - TODAS ANOTACOES
    if( idselecproj.toUpperCase()=="TODAS" ) {
        var lcopcao = idopcao.toUpperCase();
        var quantidade= lcopcao.search(/TODOS|TODAS/i);
        if( quantidade!=-1 ) {
            if( document.getElementById("ordenar") ) {
                 document.getElementById("ordenar").style.display="block";            
            } else {
                 alert("Faltando document.getElementById(\"ordenar\") ");           
            }
            /*
            if( document.getElementById("busca_proj") ) {
                  document.getElementById("busca_proj").selectedIndex="0";
            } 
            */
            ///
            return;
        }
    }
    //// 
    ///  if( idselecproj!="DESCARREGAR" &&  idselecproj!="DETALHES" ) {
   var buscar=idselecproj.search(/DESCARREGAR|DETALHES|BUSCA_PROJ|Ordenar/i);       
   ///  Caso NAO encontrou nenhum dos tres nomes 
   if( buscar==-1 ) {
       if( typeof(idopcao)=='undefined' ) var op_selanot="";
       if( typeof(idopcao)!='undefined' ) var op_selanot=idopcao.toUpperCase();
       if( op_selanot=="TODOS" ) {
           var op_selcpoid = "";
           var op_selcpoval = "";
           var doc_elemto = document.getElementById(idselecproj);    
           var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
           var op_projcod = op_selecionada.value;
           var op_projdesc = op_selecionada.text;
       } else {
           var doc_elemto = document.getElementById(idopcao);    
           var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
           var op_selcpoid = op_selecionada.text;
           var op_selcpoval = op_selecionada.value;
       }        
    }    
    /// 
          
    /*   Iniciando o AJAX para selecionar os usuarios desejados  */
    var xAJAX_mostraanot = new XHConn();
        
    if( !xAJAX_mostraanot ) {
          alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    ///
    /// Define o procedimento para processamento dos resultados dp srv_php
    var fndone_mostraanot = function (oXML) { 
           ///  Recebendo o resultado do php/ajax
           var srv_ret = oXML.responseText;
           var lnip = srv_ret.search(/Nenhum|ERRO:/i);
          
////  alert(" anotacao_consultar.php/279 -  2)  idselecproj = "+idselecproj+"\r\n lnip = "+lnip+" - Recebendo resultado do srv_ret = "+srv_ret);

          ///  Caso NAO encontrado - Nenhum|ERRO 
           if( lnip==-1 ) {
                ///
                if( idselecproj.toUpperCase()=="DESCARREGAR" ) {
                      srv_ret = trim(srv_ret);
                      ////  var array_arq = srv_ret.split("%");
                      var array_arq = srv_ret.split("%#sepa%#rar%#");
                      
                      /// IMPORTANTE:  Abrir Arquivo PDF - Acentuacao comandos escape e decodeURIComponent - Javascript
                      ///  var acertaacentuacao=escape("\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar");
                      ///
                      var acertaacentuacao="\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar";
                      alert(decodeURIComponent(acertaacentuacao));

                      self.location.href=raiz_central+"includes/baixar_anotacao.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);                      
                     /// self.location.href=raiz_central+"includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                      ///
                } else if( idselecproj.toUpperCase()=="DETALHES" ) {
                          var myArguments = trim(srv_ret);
                          ///     var showmodal =  window.showModalDialog("myArguments_anotacao.php?myArguments="+myArguments,myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;"); 
                          if( window.showModalDialog) { 
                                var showmodal =  window.showModalDialog("myArguments_anotacao.php",myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                          } else {
                                ///  Ativando ID anotacao_escolhida
                                exoc("anotacao_escolhida",1,myArguments);                   
                          }
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
                } else  if( idselecproj.toUpperCase()=="BUSCA_PROJ" ) {
                        ///  Ativando function ativar
                       ativar(srv_ret);
                } else  if( idselecproj.search(/Ordenar/i)!=-1 ) {
                       ///  Mostrar Anotacoes 
                      ///  Ativando ID div_out - enviando dados
                       exoc("div_out",1,srv_ret);           
                      ///
                } else {
                      ///  Mostrar dados da Anotacao escolhida
                     ///  Ativando ID anotacao_escolhida - enviando dados
                     exoc("anotacao_escolhida",1,srv_ret);           
                     ///
               }
          } else {
               ////
               ///  ATUALIZADO EM 20170602
               if( idselecproj.toUpperCase()=="TODOS" || idselecproj.toUpperCase()=="BUSCA_PROJ" ) {
                    /// Separando a mensagem recebida
                    var pos1 = srv_ret.search(/INICIA/i);
                    var pos2 = srv_ret.search(/FINAL/i);
                    if( pos1!=-1 && pos1!=-2  ) {
                         srv_ret = srv_ret.replace(/ERRO:|CORRIGIR_ERRO:|INICIA|FINAL/ig,"");
                    }
               }
               ///  Ocutando ID id_anotacao - CASO EXISTA
               if( document.getElementById("id_anotacao") ) {
                    if( document.getElementById("id_anotacao").style.display="block"  ) {
                          document.getElementById("id_anotacao").style.display="none";   
                    }     
               }
               ///  document.getElementById('label_msg_erro').style.display="block";
               ///  document.getElementById('label_msg_erro').innerHTML=srv_ret;
               ///  Ativando ID mensagem de erro
               exoc("label_msg_erro",1,srv_ret);                   
               ///
           }; 
    };
    /// 
    ///  Define o servidor PHP para consulta do banco de dados
    var srv_php = "srv_mostraanotacao.php";
    var poststr = new String("");
    /*
    if( idselecproj.toUpperCase()=="DETALHES" ) {
        alert(" Final  anotacao_consultar.php/170 -  idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array)      
    } */
        
    ///  DESCARREGAR - UPLOAD abrindo o arquivo pdf e  Detalhes da Anotacao do Projeto

    /// if( idselecproj.toUpperCase()=="DESCARREGAR" || idselecproj.toUpperCase()=="DETALHES" ) {
    var encontrado=idselecproj.search(/DESCARREGAR|DETALHES|BUSCA_PROJ|ordenar/i);    
    ///  Caso encontrou um dos tres nomes 
    if( encontrado!=-1 ) {
         var browser="";
         if( typeof navegador=="function" ) {
              var browser=navegador();
         }  
         ///
         if( idselecproj.toUpperCase()=="DESCARREGAR" ) {
             /// IMPORTANTE: variavel val com aspas simples - arquivo com simbolos e acentos
             var idopcao= idopcao.replace("$", "\\$");
             var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array)+"&navegador="+browser;            
         } else {
              var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array)+"&navegador="+browser;                
         }
         ///
    } else {
         var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoanot="+encodeURIComponent(op_selanot)+"&op_selcpoid="
                +encodeURIComponent(op_selcpoid)+"&op_selcpoval=" +encodeURIComponent(op_selcpoval);
    }

 /// alert("anotacao_consultar/448  -  poststr="+poststr)

    xAJAX_mostraanot.connect(srv_php, "POST", poststr, fndone_mostraanot);   
    ///
}
/***********    Final - function da consulta/anotacao   ***********************/
///
</script>
<?php
///     Alterado em 20170925 - MENU   
///   require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

///   Consultar Anotacao
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}
///  Definindo TITULO da pagina
$_SESSION["m_titulo"]="Anota&ccedil;&atilde;o";
///   
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);"  >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$incluir_arq}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
///  Functions em PHP - 20171004 - importante
include("{$incluir_arq}includes/functions.php");
///
///  Parte do Menu - array -  arquivo  array_menu.php
include("{$incluir_arq}includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro" >
</div>
<p class="titulo_usp" >Consultar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Mensagem de ERRO e Titulo    -->
<?php
//     Verificano o PA - Privilegio de Acesso
// if( ( $permit_pa>$_SESSION['array_usuarios']['superusuario']  and $permit_pa<=$permit_anotador ) ) {    
if( ( $permit_pa>$array_pa['super']  and $permit_pa<=$permit_anotador ) ) {        
    // Para incluir nas mensagens
    //  include_once("../includes/msg_ok_erro_final.php");
    //
    //   Definindo a variavel usuario para mensagem
    //  $usuario="Orientador"; 
    //  if( $_SESSION["permit_pa"]!=$array_pa['orientador'] ) $usuario="Usu&aacute;rio"; 
    //    
?>
<div id="div_form" class="div_form" style="overflow:auto;" >
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" style="text-align: center; width:100%;font-size:medium;font-weight: bold;" >Selecione o Projeto:&nbsp;
</p>
</div>
<?php 
/// Selecionando o Projeto do Orientador/Usuario
# Aqui está o segredo
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
*/
///  ALTERADO EM 20180607 -  Importante
if( $permit_pa<$permit_aprovador ) {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b WHERE a.codigousp=b.autor and "
        ." b.cip in (select distinct cip FROM  $bd_2.anotador )"
        ."  order by b.titulo ";
    
} elseif( $permit_pa<=$permit_orientador and $permit_pa>=$permit_aprovador ) {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b  WHERE a.codigousp=b.autor and "
        ." a.codigousp=".$usuario_conectado." order by b.titulo ";
} else {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." b.cip in (select distinct cip from $bd_2.anotador "
        ." WHERE codigo=".$usuario_conectado.")  order by b.titulo ";
}
$result = mysql_query($sqlcmd); 
///  Verificando se houve erro no Select/MySql                  
if( ! $result ) {
    //  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
    /* $msg_erro .= "Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} - db/mysql:&nbsp; ".mysql_error();
    echo $msg_erro.$msg_final;  */            
    //  Parte do Class                
    echo $funcoes->mostra_msg_erro("Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} - db/mysql:&nbsp; ".mysql_error());
    exit();                  
}
///  Numero de Projetos Selecionados
$nprojetos = mysql_num_rows($result);
if( intval($nprojetos)<1 ) {
     ?>
     <script type="text/javascript">
          var usuario_pa_nome="<?php echo  $_SESSION["usuario_pa_nome"];?>";       
          var srv_ret = "N&atilde;o existe Projeto vinculado a esse "+usuario_pa_nome+".";
          ///  Mostrar erro no ID label_msg_erro
           /* 
               document.getElementById('label_msg_erro').style.display="block";
               document.getElementById('label_msg_erro').innerHTML=srv_ret;
           */
           exoc("label_msg_erro",1,srv_ret);  
     </script>     
   <?php
} else {
///
///   Ordernar por:
?>
<div class="div_select_busca"  >
<select name="busca_proj" id="busca_proj"  class="Busca_letrai"  title="Selecione o Projeto para Busca de Anota&ccedil;&otilde;es" 
   onchange="javascript: consulta_mostraanot(this.id,this.value)"  >
    <!-- Identificacao do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
    <?php 
        /// Verifica se NAO tem projeto  ou 
        if( intval($nprojetos)<1 ) {
              echo "<option value='' >N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.</option>";
        } else {
              echo "<option value='' >Selecione o Projeto a ser acessado por esse {$_SESSION["usuario_pa_nome"]} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
              ////
              while( $linha=mysql_fetch_assoc($result) ) {
                        $_SESSION["cip"]=$linha['cip'];
                        $_SESSION["anotacao_numero"]=$linha['anotacao']+1;
                        $autor_nome = $linha['nome'];
                        /*  Desativado por nao ter valores nos campos fonterec e fonteprojid
                        $titulo_projeto = htmlentities($linha['fonterec'])."/".ucfirst(htmlentities($linha['fonteprojid']))
                                          .": ".$linha['titulo'];   */
                        $fonterec=htmlentities($linha['fonterec']);
                        $fonteprojid=  ucfirst(htmlentities($linha['fonteprojid']));         
                         ///  PARTES do Titulo do Projeto - dividindo em sete partes 
                         $partes_antes=6;
                         $projeto_titulo_parte="";
                         $palavras_titulo = explode(" ",trim($linha['titulo']));
                         $contador_palavras=count($palavras_titulo);
                         for( $i=0; $i<$contador_palavras; $i++  ) {
                               $projeto_titulo_parte .="{$palavras_titulo[$i]} ";
                               if( $i==$partes_antes and $contador_palavras>$partes_antes  ) {
                                    $projeto_titulo_parte=trim($projeto_titulo_parte);
                                    $tamanho_campo=strlen($projeto_titulo_parte);
                                    if( $tamanho_campo>40  ) $projeto_titulo_parte.="...";
                                  ///  $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
                                    break;
                               }
                         }
                         ///  Definindo o Titulo do Projeto
                         $titulo_projeto="";
                         if( strlen(trim($fonterec))>=1  ) {
                               $titulo_projeto.= $fonterec."/";
                         }
                         if( strlen(trim($fonteprojid))>=1  ) {
                              $titulo_projeto.= $fonteprojid.": ";
                         }
                         $titulo_projeto .= trim($projeto_titulo_parte);                    
                        ///  Usando esse option para incluir espaco sobre linhas
                        ///  echo  "<option value='' disabled ></option>";                  
                        /*
                        echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >"
                               .utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";   
                        */
                        echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >";
                        /* IMPORTANTE: Detectar codificacao  de caracteres  - 20171005   */
                        $codigo_caracter=mb_detect_encoding($titulo_projeto);
                      ///  if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
                            //// echo utf8_decode(htmlentities($titulo_projeto))."&nbsp;&nbsp;</option>";
                           ///     echo  htmlentities("$titulo_projeto")."&nbsp;&nbsp;</option>";
                                echo  $titulo_projeto."&nbsp;&nbsp;</option>";
                             /// echo utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";  ///
                             /***
                        } else {
                            echo  $titulo_projeto."&nbsp;&nbsp;</option>";                                  
                        }
                        ***/
                        ////    
              }
        }
        ?>
        </select>
</div>
<?php
///   Conectar - CODIGO/USP
///  $elemento=5; $elemento2=6;
///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
//
//  Selecionar as anota??es de projeto pelo campo desejado
$opcao_cpos = Array("ano_inicio","ano_final","anotacao") ;
$opcao_ncpos = count($opcao_cpos);                
//
///  Salvar letrais iniciais em um conjunto para facilitar a busca
////   $m_anotacoes=utf8_decode("Anotações");
$m_anotacoes="Anotações";
///
?>
<div id="id_anotacao" style="display: none;text-align: center;" >
<p class="titulo_usp"   >
Mostrar&nbsp;<?php echo $m_anotacoes;?>&nbsp;</p>
<div align="center" style="padding-top:0px; padding-bottom: 5px;margin-left: 40%;margin-right: 40%;" >
 <!-- tag Select para ordenar  -->
<select  title="Ordernar"  id="ordenar" class="ordenar"   onchange="javascript:  consulta_mostraanot('ordenar',busca_proj.value,this.value)"  >
<option  value=""  >Ordenar por</option>
<option  value="data asc"  >Data - asc</option>
<option  value="data desc"  >Data - desc</option>
<option  value="titulo asc"  >Título - asc</option>
<option  value="titulo desc"  >Título - desc</option>
</select>
<!--  Final - tag Select para ordenar  -->
</div>   
<p class="titulo_usp2" style="margin-bottom: 0;padding-bottom: 0;font-weight: bold;" >Lista de Anota&ccedil;&otilde;es desse Projeto</p>
<?php
    }
   ///  FINAL - if( intval($nprojetos)<1 )  
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
<div  style="position:relative;  display:flex; ">
<!-- id div_out  -->
<section style="float: left;width:100%;" >
<article id="div_out" style="width:100%; overflow: auto; ">
</article>
<!-- Final - id div_out  -->
<!--  ID - Anotacao escolhida -->
<article  id="anotacao_escolhida" >
</article>
</section>
<!-- Final - Anotacao escolhida -->
</div>
</div>
<!-- Final - id id_anotacao -->
</div>
<!-- Final div_form  -->
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


