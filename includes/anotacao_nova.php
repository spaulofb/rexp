<?php 
/*   REXP - CONSULTAR ANOTA??O DE PROJETO
*   
*   REQUISITO: O Usuário deve ter PA>0 e PA<=50 
* 
*   LAFB&SPFB110908.1629
*/
//  ==============================================================================================
//  ATEN??O: SENDO EDITADO POR SPFB/20170920 --  incluces/anotacao_nova.php
//  ==============================================================================================
//
// Dica: #*funciona?*# Se o que quer ? apenas for?ar uma visualiza??o direta no navegador use
// header("Content-Disposition: inline; filename=\"nome_arquivo.pdf\";"); 
///
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

/// include('inicia_conexao.php');
extract($_POST, EXTR_OVERWRITE); 

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///  HOST mais a pasta principal do site
$host_pasta="";
if( isset($_SESSION["host_pasta"]) ) $host_pasta=$_SESSION["host_pasta"];

///
///  Verificando SESSION incluir_arq
$n_erro=0;
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=trim($_SESSION["incluir_arq"]);
if( strlen($incluir_arq)<1 ) $n_erro=1;
///
/***
*    Caso NAO houve ERRO  
***/
if( intval($n_erro)<1 )  {
    ////   CONECTANDO
    include("{$_SESSION["incluir_arq"]}inicia_conexao.php");
    ///
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
             exit();
        }
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
            ///  Permissao do anotador    
             $permit_anotador = $array_pa['anotador'];
             ///  Permissao do orientador
             $permit_orientador = $array_pa['orientador'];
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
    ////    
}
/******  FINAL - if( intval($n_erro)<1 ) **********************/  
///
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
     $msg_erro .= "Erro ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
///
$_SESSION["m_horiz"] = $array_projeto;
///
///  SESSEION para Alterar o Excluir ANotacao
if( isset($_SESSION["anotacao_cip_altexc"]) ) unset($_SESSION["anotacao_cip_altexc"]); 
////
$usuario_conectado = $_SESSION["usuario_conectado"];
if( isset($_SESSION["permit_pa"]) ) $permit_pa = $_SESSION["permit_pa"];
///
//   Caminho da pagina local
$pagina_local=$_SESSION["protocolo"]."://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]= utf8_decode("Registro de Anotação") ;

/// $_SESSION['time_exec']=180000;
///
///  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
////
$_SESSION["m_titulo"]="Anotações";
$_SESSION["anotacao_numero"]=0;
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="pt-br" />
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<title>Projeto</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script  language="javascript"  type="text/javascript" >
///
charset="utf-8";
///
// /  Javascript - 20171020
/****  
   Definindo as  variaveis globais  -  20171020

        Define o caminho HTTP
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
///
///
function consulta_mostraanot(idselecproj, idopcao,string_array){
    /***
         Selecionar as ANOTACOES DE PROJETOS de acordo
         com a opcao (todos ou pelo campo desejado)
    
        LAFB/SPFB110831.1127
        LAFB/SPFB110909.0917

       Parametros:
          idselecproj = Identifica??o do Select de escolha do projeto
          idopcao     = Identificacao da Opcao o de selecaodas Anotacoes (TODOS, select (ano_incio, ano_final, anotacao)
    ***/
    //  Prepara os par?metros para ativação do srv_php
    /// Determina qual opcao do Select <idselecproj> foi selecionada:
    /// Verificando se a function exoc existe
    if( typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe. Corrigir");
        return
    }
    ///
    

//// alert(" anotacao_nova.php/217  --  INICIANDO  -  idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array)  
    
    
    var poststr="";
    ///  Verificando variaveis
    if( typeof(idselecproj)=="undefined" ) var idselecproj=""; 
    if( typeof(idopcao)=="undefined" ) {
         var op_selanot="";
         var idopcao=""; 
    } 
    if( typeof(string_array)=="undefined" ) var string_array=""; 
    
    /// Verificando variavel string_array existe
    if( typeof string_array=="undefined" ) {
         var string_array="";
    }
    var nr_anotacao=0;
    /// Verifica se a variavel e uma string    
    if( typeof(idselecproj)=='string' ) {
        /***  string.replace - Melhor forma para eliminiar 
              espacos no comeco e final da String/Variavel
        ***/    
        var idselecproj = idselecproj.replace(/^\s+|\s+$/g,""); 
    }
    ///
    if( typeof(idopcao)=='string' ) {
        /***  string.replace - Melhor forma para eliminiar 
              espacos no comeco e final da String/Variavel
        ***/    
        var idopcao = idopcao.replace(/^\s+|\s+$/g,""); 
        var op_selanot=idopcao.toUpperCase();
    }
    ///
    if( typeof(string_array)=='string' ) {
         ///  src = trim(string_array);
         ///  string.replace - Melhor forma para eliminiar espacos no comeco e 
         ///                   final da String/Variavel
         var string_array = string_array.replace(/^\s+|\s+$/g,"");        
         var string_array_maiusc = string_array.toUpperCase();     
         var pos = string_array.indexOf("#@=");   
         if( pos!=-1 ) {  
              ///  Criando um Array 
              var array_string_array = string_array.split("#@=");
              if( array_string_array.length==4 ) {
                   /// cip = codigo da ident. do Projeto
                   var  op_projcod=array_string_array[2];  
                   ///  Numero da anotacao do Projeto
                   var  nr_anotacao=array_string_array[3];  
              } 
              /*   var teste_cadastro = array_string_array[1];
                    var  pos = teste_cadastro.search("incluid");
              */
         }
    }  else if( typeof(string_array)=='number' && isFinite(string_array) )  {
           var string_array = string_array.value;                
    } else if(string_array instanceof Array) {
          ///  esse elemento definido como Array
    }
    /****  
         Define o caminho HTTP    -  20180509
     ***/  
     var protocolo="<?php echo $_SESSION["protocolo"];?>";
     var raiz_central="<?php echo $_SESSION["url_central"];?>";       
     var pagina_local=protocolo+"<?php echo  "://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];?>"; 
     ///
    /// Procurando Alterar ou Excluir 
    var ultimos_cpos = idselecproj.search(/Alterar|Excluir|NOVA|NOVA_ANOTACAO/i);
    

 alert(" anotacao_nova.php/286 ---   ultimos_cpos = "+ ultimos_cpos+"  ---  pagina_local = "+pagina_local+"   \r\n  idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array);  
    
    
    //// ALterado em 20181023
    if( ultimos_cpos!=-1  ) {
        if( idselecproj.toUpperCase()=="ALTERAR" ) {
             ///  
            //// top.location.href=raiz_central+"alterar/anotacao_alterar_nova.php";
            top.location.href=raiz_central+"alterar/anotacao_alterar.php";
             ///
        } else if( idselecproj.toUpperCase()=="EXCLUIR" ) {
             ///
             /// top.location.href=raiz_central+"remover/anotacao_remover_nova.php";           
             top.location.href=raiz_central+"remover/anotacao_remover.php";           
             ///
        /// } else if( idselecproj.toUpperCase()=="NOVA_ANOTACAO" ) {
        } else if( idselecproj.search(/NOVA|NOVA_ANOTACAO/i)!=-1 ) {
             ////  Cadastrar NOVA Anotacao
             ////   top.location.href=raiz_central+"cadastrar/anotacao_cadastrar.php?cad_dados_anotacao('anotacao','projeto')";           
              top.location.href=raiz_central+"cadastrar/anotacao_cadastrar_nova.php";             
             ///
        }    
        return;
        ///
    }
    /// 
    ///  Recebido da pagina includes/tabela_consulta_anotacao_nova.php 
    /**
    if( idselecproj.toUpperCase()=="NOVA" ) {
           ///  alert("anotacao_nova.php/89  - IF NOVA  -  idopcao = "+idopcao)
           top.location.href=raiz_central+"cadastrar/anotacao_cadastrar_nova.php?cad_dados_anotacao('anotacao','projeto')";
           return;        
    }
    **/
    ///
    if( idselecproj.toUpperCase()!="DESCARREGAR" &&  idselecproj.toUpperCase()!="DETALHES" ) {
           /// 
           
/////  alert(" anotacao_nova/LINHA/275  --- idselecproj = "+idselecproj+" --- op_selanot =  "+op_selanot);           
           
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
           ///        
    }    
    ////  Verificando o campo da tag Select para escolher Projeto
    if( document.getElementById("busca_proj") ) {
        var cpo_val = document.getElementById("busca_proj").value;
        if( cpo_val=="" ) {
             ///  ERRO
             var m_id_title="Selecione primeiro o Projeto";
             document.getElementById("label_msg_erro").style.display="block";
             document.getElementById("label_msg_erro").innerHTML="";
             var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
             msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
             var final_msg_erro = "&nbsp;</span></span>";
             var m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
             msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
             document.getElementById("label_msg_erro").innerHTML=msg_erro;    
             return false;
        }
        ///
    }
          
    /*   Iniciando o AJAX para selecionar os usuarios desejados  */
    var xAJAX_mostraanot = new XHConn();
    if( !xAJAX_mostraanot ) {
         alert("XMLHTTP/AJAX não dispon?vel. Tente um navegador mais novo ou melhor.");
         return false;
    }
    ///
    /****   Define o procedimento para processamento dos resultados dp srv_php   ***/
    var fndone_mostraanot = function (oXML) { 
          ///  Recebendo o resultado do php/ajax
          if( document.getElementById("nova_anotacao") ) {
                document.getElementById("nova_anotacao").style.display="none";
          } 
          var srv_ret = oXML.responseText;
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);
          
 alert(" anotacao_nova.php/125 - idselecproj = "+idselecproj+" - lnip = "+lnip+"  /r/n/n Recebendo resultado do srv_mostraanot="+srv_ret)
          
          /// 
          if( lnip==-1 ) {
             if( idselecproj.toUpperCase()=="DESCARREGAR" ) {
                   alert("\r\nCaso o Internet Explorer bloqueie o download, fa?a o seguinte:\r\n\r\n Op??o - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Op??es do Internet Explorer e clique na aba Seguran?a.\r\n 2 - Clique no bot?o N?vel Personalizado e dentro de Configura??es de Seguran?a, localize o recurso Downloads \r\n3 - Em: Aviso autom?tico para downloads de arquivo e selecione Habilitar")
                   srv_ret = trim(srv_ret);
                   var array_arq = srv_ret.split("%");
                   self.location.href="../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]); 
                   ////  Botao para Nova Anotacao  -  aparecer
                   if( document.getElementById("nova_anotacao") ) {
                        document.getElementById("nova_anotacao").style.display="block";               
                   } 
             } else  if( idselecproj.toUpperCase()=="DETALHES" ) {               
                   ///  alert("  anotacao_consultar.php/135  myArguments = "+myArguments)                
                    ///     var showmodal =  window.showModalDialog("myArguments_anotacao_nova.php?myArguments="+myArguments,myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                  var myArguments = trim(srv_ret);
                  var showmodal =  window.showModalDialog("myArguments_anotacao_nova.php",myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                   ///  Botao para Nova Anotacao  -  aparecer
                   if( document.getElementById("nova_anotacao") ) {
                        document.getElementById("nova_anotacao").style.display="block";  
                   } 
             } else {
                  /****
                  if( document.getElementById("id_anotacao") ) {
                       document.getElementById("id_anotacao").style.display="block";                      
                  }
                  ***/
                  ///  Ativando ID  e utilizando na tag input comando onkeypress
                  exoc("id_anotacao",1);  
                  ///    
                  ////  document.getElementById('label_msg_erro').style.display="block";    
                  if( document.getElementById("nova_anotacao") ) {
                      document.getElementById("nova_anotacao").style.display="block";   
                  }
                  //// document.getElementById('div_out').style.display="none";
                  if( document.getElementById("div_out") ) {
                      document.getElementById("div_out").style.display="block";                  
                      ///  Verifica se Nenhuma Anotacao foi encontrada 
                      var lnip = srv_ret.search(/Nenhuma/i); 
                      if( lnip!=-1  ) {
                          exoc("label_msg_erro",1,srv_ret);  
                      } else {
                          document.getElementById('div_out').innerHTML=srv_ret;                          
                      }
                      ///
                  }                 
                  return;
             }
          } else if( lnip!=-1 ) {   
              ///  Enviando mensagem de erro ID label_msg_erro
              exoc("label_msg_erro",1,srv_ret);  
              return;
          };
          ///  Tinha um ELSE aqui
    };
    /// 
    ///  Define o servidor PHP para consulta do banco de dados
    var srv_php = "anotacao_nova_ajax.php";
    var poststr = new String("");
    ///
    ///  DESCARREGAR - UPLOAD abrindo o arquivo pdf e  Detalhes da Anotacao do Projeto
    if( idselecproj.toUpperCase()=="DESCARREGAR" || idselecproj.toUpperCase()=="DETALHES"   ) {
       var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
    }  else {
        var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoanot="+encodeURIComponent(op_selanot)+"&op_selcpoid="
                +encodeURIComponent(op_selcpoid)+"&op_selcpoval=" +encodeURIComponent(op_selcpoval) ;
    }

 /// alert("Ativando srv_mostraanot com poststr="+poststr)
    xAJAX_mostraanot.connect(srv_php, "POST", poststr, fndone_mostraanot);   
}
/// 
</script>
<?php
///  Alterado em 20171004
///  require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

///     Consultar Anotacao
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}
//   
?>
</head>
<body  id="id_body" oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);"  >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div id="corpo"  >
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Lista de&nbsp;Anotações</p>
</section>
<!-- Final - Mensagem de ERRO e Titulo  -->
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
if( $permit_pa<=$permit_orientador ) {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." a.codigousp=".$usuario_conectado." order by b.titulo ";
} else {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." b.cip in (select distinct cip from $bd_2.anotador "
        ." where codigo=".$usuario_conectado.")  order by b.titulo ";
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
///
?>
<div class="div_select_busca"  >
<select name="busca_proj" id="busca_proj"  title="Selecione o Projeto para Busca de Anota&ccedil;&otilde;es" 
    onchange="javascript: consulta_mostraanot('busca_proj', 'TODOS')"   >
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
                                    if( $tamanho_campo>40  ) $projeto_titulo_parte.="...";
                                  //  $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
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
<p class='titulo_usp2'  >Lista de Anota&ccedil;&otilde;es do Projeto</p>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
<!--  Recebe os dados - Tabela -->
<div id="div_out" style="width:100%; overflow: hidden; ">
</div>
<!--  Nova Anotacao - Botao  -->
<div id="nova_anotacao" style="width:100%; overflow: hidden; margin-top: 2px;" >
  <p style="margin-top: 0px; vertical-align: middle; " align="center"  >
      <button  type="submit"  name="nova" id="nova" class="botao3d" 
         style="cursor: pointer; width: 140px;" title="Nova Anotação"  acesskey="N"  
         alt="Nova Anotação"  onclick="javascript: consulta_mostraanot(this.id, 'NOVA_ANOTACAO')" >    
        Nova&nbsp;anotação&nbsp;
        <img src="../imagens/enviar.gif"  alt="Nova Anotação"  style="vertical-align:middle;" >
     </button>
  </p>
</div>
<!--  Final -  Nova Anotacao - Botao  -->
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
