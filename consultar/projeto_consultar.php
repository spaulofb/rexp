<?php 
/*   REXP - CONSULTAR PROJETO
*   
*   REQUISITO: O usuario deve ter PA>0 e PA<=30
* 
*   SPFB&LAFB110908.0959
*/
//  ==============================================================================================
//  PROJETO CONSULTAR
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
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado = $_SESSION["usuario_conectado"];
///

///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
/// $_SESSION['time_exec']=180000;

///  Mensagens
///  include_once("../mensagens.php");
include_once("{$incluir_arq}mensagens.php");
///
//  Definindo valores nas variaveis
if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"]; 
///
///  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
/*
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$usuario_pa_nome=$funcoes->usuario_pa_nome;
*/ 
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
<html lang="pt-br" >
<head>
<meta charset="utf-8" />
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Consultar Projeto</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!--  <script type="text/javascript"  src="../js/projeto_consultar.js" ></script>  -->
<script  language="javascript"  type="text/javascript" >
///
///   JavaScript Document
///
/****  
    Define o caminho HTTP  -  20180416
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
charset="utf-8";
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
///   function  acentuarAlerts - para corrigir acentuacao
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
/*************  Final  -- function acentuarAlerts(mensagem)   ************/
///
///  Function principal para aquivo AJAX
function consulta_mostraproj(tcopcao,val,string_array) {
//
//  Selecionar os PROJETOS de acordo com a op??o (todos ou pelo campo desejado)
//
//  LAFB/SPFB110831.1127
///
    /// Verificando se a function exoc existe
    if( typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe");
    }
    ///  Desativando ID  projeto_escolhido
    exoc("projeto_escolhido",0,"");                   
    ///
     ///  Verificando variaveis
    if( typeof(tcopcao)=="undefined" ) var tcopcao=""; 
    if( typeof(val)=="undefined" ) var val=""; 
    if( typeof(string_array)=="undefined" ) var string_array=""; 
     /****  
          Define o caminho HTTP    -  20180228
     ***/  
     var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
     var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";           
    
 ///  alert("  projeto_consultar.php/123 -- INICIO --  tcopcao = "+tcopcao+" -  val = "+val+" - string_array = "+string_array);    
    
    /// BOTAO - TODOS
    var lcopcao = tcopcao.toUpperCase();
    var quantidade= lcopcao.search(/TODOS|TODAS/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("ordenar") ) {
            ///  Incluido em 20180419
           //// var melement=document.getElementById("ordenar");
           var stdis= document.getElementById("ordenar");
           if( stdis.style.display==="none" || stdis.style.display==="" ) {
                document.getElementById("ordenar").style.display="block";
            }             
            document.getElementById("ordenar").selectedIndex="0";            
        } else {
             alert("Faltando document.getElementById(\"ordenar\") ");           
        }
        if( document.getElementById("busca_proj") ) {
              document.getElementById("busca_proj").selectedIndex="0";
        } 
        ///  Desativando ID  div_out
        exoc("div_out",1,"");                   
        ///
        return;
    }
    /// tag Select para Ordenar o Botao Todos - Importante - 20180419
    var quantidade=lcopcao.search(/ORDENAR/i);
    if( quantidade!=-1 ) {
         var tmp=val;
         var val=lcopcao;
         var lcopcao=tmp;
         ///  var string_array=string_array.replace(" ","");      
        if( document.getElementById("busca_proj") ) {
            document.getElementById("busca_proj").selectedIndex="0";
        }    
        if( document.getElementById("busca_porcpo") ) {
            document.getElementById("busca_porcpo").selectedIndex="0";
        }    
        ///
    } 
    ///  
    /// tag Select para desativar outros campos
    var quantidade=lcopcao.search(/BUSCA_PROJ/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("busca_porcpo") ) {
              document.getElementById("busca_porcpo").selectedIndex="0";
        }    
    }
    /// tag Select para desativar outros campos
    var quantidade=lcopcao.search(/busca_porcpo/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("busca_proj") ) {
              document.getElementById("busca_proj").selectedIndex="0";
        }    
    }
    /// tag Select para desativar o campo Select ordenar
    var quantidade=lcopcao.search(/BUSCA_PROJ|busca_porcpo/i);
    if( quantidade!=-1 ) {
         ///  Caso variavel val estiver  nula
         if( val.length<1 )  {
             ///  Retornar na pagina - reset 
             location.href=pagina_local;
              return;
         }
        /// 
        if( document.getElementById("ordenar") ) {
            ///  Incluido em 20180419
           var melement=document.getElementById("ordenar");
           if( melement.style.display==="block" || melement.style.display==="" ) {
                document.getElementById("ordenar").selectedIndex="0";
                document.getElementById("ordenar").style.display="none";            
            }
        }  
    }
    ///    
    /*   Iniciando o AJAX para selecionar os usuarios desejados  */
    var xAJAX_mostraproj = new XHConn();
        
    if ( !xAJAX_mostraproj ) {
        var msgtxt=acentuarAlerts("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor."); 
        ////  alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
         alert(msgtxt);
         return false;
    }
    ///
    //// Define o procedimento para processamento dos resultados dp srv_php
    var fndone_mostraproj = function (oXML) { 
          //  Recebendo o resultado do php/ajax
          var srv_ret = oXML.responseText;
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);
          
 ///  alert(" projeto_consultar/308 -->> lnip = "+lnip+" <<--- lcopcao = "+lcopcao+" -  val = "+val+" - string_array = "+string_array+" \r\n\r Recebendo resultado do srv_mostraproj ="+srv_ret);
          
          if( lnip==-1 ) {
            if( lcopcao=="DESCARREGAR" ) {
                 srv_ret = trim(srv_ret);
                 ///
                 var array_arq = srv_ret.split("%#sepa%#rar%#");
                 /// window.document.location.toString() - mostra caminho pagina local
                /*
                var urlr = window.document.location.toString(); 
                var caminho=urlr.substring(0,urlr.indexOf("consultar"));
                caminho +="includes/baixar.php?pasta="+array_arq[0]+"&file="+array_arq[1];
                */
                 ///  Mensagem para mostrar o arquivo do Projeto
                 ///  alert("\r\nCaso o Internet Explorer bloqueie o download, fa?a o seguinte:\r\n\r\n Op??o - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Op??es do Internet Explorer e clique na aba Seguran?a.\r\n 2 - Clique no bot?o N?vel Personalizado e dentro de Configura??es de Seguran?a, localize o recurso Downloads \r\n3 - Em: Aviso autom?tico para downloads de arquivo e selecione Habilitar")
                 var msgtxt=acentuarAlerts("\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar");    
                 alert(msgtxt);
                 
  ///     alert(" array_arq[1] =  "+array_arq[1]+"  \r\n\r unescape = "+unescape(array_arq[1]));                         
                 /***
                 self.location.href=raiz_central+"includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                 ***/
                 self.location.href=raiz_central+"includes/baixar.php?pasta="+unescape(array_arq[0])+"&file="+unescape(array_arq[1]);
                 ///
             } else if( lcopcao=="DETALHES" ) {
                  var myArguments = trim(srv_ret);
                 ///   var showmodal =  window.showModalDialog("myArguments_anotacao.php?myArguments="+myArguments,myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                  if( window.showModalDialog) { 
                      var showmodal = window.showModalDialog("myArguments_projeto.php",myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                  } else {
                      ///  Ativando ID projeto_escolhido
                      exoc("projeto_escolhido",1,myArguments);                   
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
             } else {
                 if( lcopcao=="TODOS" ) {
                     if( document.getElementById('busca_proj') ) {
                         document.getElementById('busca_proj').options[0].selected=true;
                         document.getElementById('busca_proj').options[0].selectedIndex=0;                   
                     }
                 }     
                 ///  document.getElementById('label_msg_erro').style.display="block";    
                 /// document.getElementById('div_out').style.display="none";
                 document.getElementById('div_out').innerHTML=srv_ret;                
             }
          } else {
               if( lcopcao=="TODOS"  || lcopcao=="BUSCA_PROJ" )  {
                    /// Separando a mensagem recebida
                    var pos1 = srv_ret.search(/INICIA/i);
                    var pos2 = srv_ret.search(/FINAL/i);
                    if( pos1!=-1 && pos1!=-2  ) {
                         srv_ret = srv_ret.replace(/ERRO:|CORRIGIR_ERRO:|INICIA|FINAL/ig,"");                      
                    }
               }
               /*
                  document.getElementById('label_msg_erro').style.display="block";
                  document.getElementById('label_msg_erro').innerHTML=srv_ret;
                */
                 ///  Ativando ID mensagem de erro
                 exoc("label_msg_erro",1,srv_ret);                   
                ///               
           }; 
    };
    /// 
    ///  Define o servidor PHP para consulta do banco de dados
    var srv_php = "srv_mostraprojeto.php";
    var poststr = new String("");
    ///  DESCARREGAR - UPLOAD abrindo o arquivo pdf    
    
////  alert("---->>>  LINHA/390 --- lcopcao = "+lcopcao+"  -- val = "+val+"  -- string_array = "+string_array);
    
    ///  if( lcopcao=="DESCARREGAR"  ) {
    if( lcopcao.toUpperCase()=="DESCARREGAR" || lcopcao.toUpperCase()=="DETALHES"   ) {
           var browser="";
           if( typeof navegador=="function" ) {
                var browser=navegador();
           }  
           ///
           var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array)+"&navegador="+browser; 
           ///
    } else {
   ///      var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val);    
           var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
    }                                                             
    ///  Enviando dados para o arquivo AJAX
    xAJAX_mostraproj.connect(srv_php, "POST", poststr, fndone_mostraproj);   
    ///
}
/**********  FINAL -  function consulta_mostraproj(tcopcao,val,string_array) {  ***********/
///
</script>
<?php
///     Alterado em 20170925   
///   require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

////   Consultar - PROJETO
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$incluir_arq}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$incluir_arq}includes/menu_horizontal.php");
//
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
// if( ( $_SESSION["permit_pa"]>$_SESSION['array_usuarios']['superusuario']  and $_SESSION["permit_pa"]<=$_SESSION['array_usuarios']['orientador'] ) ) {    
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {    
     // Para incluir nas mensagens
  //   include_once("../includes/msg_ok_erro_final.php");
     //   Definindo a variavel usuario para mensagem
  //   $usuario="Orientador"; 
  //   if( $_SESSION["permit_pa"]!=$array_pa['orientador'] ) $usuario="Usu&aacute;rio"; 
     //      
?>
<!-- Iniciando div - div_form  -->
<div id="div_form" class="div_form" style="overflow:auto;" >
<?php
//  CODIGO/USP
$elemento=5; $elemento2=6;
include("php_include/ajax/includes/conectar.php");     
//
//  Selecionar os projetos pelo campo desejado
$opcao_cpos = Array("fonterec","objetivo","ano_inicio","ano_final","anotacao") ;
$opcao_ncpos = count($opcao_cpos);                
///
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
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." b.cip in (select distinct cip FROM  $bd_2.anotador )"
        ."  order by b.titulo ";
    
} elseif( $permit_pa<=$permit_orientador and $permit_pa>=$permit_aprovador ) {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b WHERE a.codigousp=b.autor and "
        ." a.codigousp=".$usuario_conectado." order by b.titulo ";
} else {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." b.cip in (select distinct cip FROM  $bd_2.anotador "
        ." WHERE codigo=".$usuario_conectado.")  order by b.titulo ";
}
$result_cons_proj = mysql_query($sqlcmd); 
///                  
if( ! $result_cons_proj ) {
 //   die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
    $msg_erro .= "Selecionando os projetos autorizados para esse {$_SESSION["usuario_pa_nome"]}.&nbsp;db/mysql:&nbsp;".mysql_error().$msg_final;
    echo $msg_erro;
    exit();
}
///  Numero de Projetos Selecionados
$nprojetos = mysql_num_rows($result_cons_proj);
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
<div style="display: flex; "  >
 <div class='titulo_usp' style='margin-left: 30%; padding:2px 0 2px 2px; font-weight: bold;font-size:large;  '>
   Mostrar:&nbsp;
   <span style="font-size: medium;  " >
  <input type='button' id='todos' class='botao3d'  value='Todos' title='Selecionar todos'  onclick='consulta_mostraproj("Todos")' >
</span>
<span class="span_ord_proj" >
<!-- tag Select para ordenar  -->
<select   title="Ordernar"  id="ordenar"  class="ordenar"  onchange="javascript:  consulta_mostraproj('ordenar',todos.value,this.value)"  >
<option  value=""  >ordenar por</option>
<option  value="datainicio asc"  >Data início - asc</option>
<option  value="datainicio desc"  >Data início - desc</option>
<option  value="datafinal asc"  >Data final - asc</option>
<option  value="datafinal desc"  >Data final - desc</option>
<option  value="titulo asc"  >Título - asc</option>
<option  value="titulo desc"  >Título - desc</option>
</select>
</span>
</div>
</div>  
<?php
}
///  Final - if( intval($nprojetos)<1 ) {  
?>
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" >Selecionar:</p>
</div>
<div  class="div_select_busca"  >
<select  name="busca_proj" id="busca_proj"   class="Busca_letrai"  title="Selecione o Projeto"  onchange="javascript:  consulta_mostraproj('busca_proj',this.value)"  >
    <!-- Identifica??o do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
<?php    
if( intval($nprojetos)<1 ) {
      $opcao_msg="N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.";
      echo "<option value='' >N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.</option>";
} else {
   ///  
   echo "<option value='' style='cursor:pointer;' >Projeto a ser acessado por esse {$_SESSION["usuario_pa_nome"]}</option>";
   while( $linha=mysql_fetch_assoc($result_cons_proj) ) {
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
                    if( $tamanho_campo>40  ) $projeto_titulo_parte.="...";
              //      $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
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
          echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >";
          /* IMPORTANTE: Detectar codificacao  de caracteres  - 20171005   */
          $codigo_caracter=mb_detect_encoding($titulo_projeto);
          /// if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
               ////  echo  htmlentities($titulo_projeto)."&nbsp;&nbsp;</option>";   
               ///  echo  utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";   
               echo  $titulo_projeto."&nbsp;&nbsp;</option>";   
              /**
          } else {
               echo htmlentities($titulo_projeto)."&nbsp;&nbsp;</option>"; 
          }
          */
          ///           
   }       
   if( isset($result_cons_proj) ) mysql_free_result($result_cons_proj); 
}            
?>                
</select>
</div>
<p class="titulo_usp" >Lista dos Projetos</p>
<!-- Tabela dos Projetos  -->
<div id="div_out"  style="margin: 0 auto; width: 100%; overflow:auto; height:auto; ">
</div>
<!--  Final  -  Tabela dos Projetos  -->
<!--  Projeto escolhido -->
 <div class='titulo_usp2' id="projeto_escolhido" style='text-align: justify;display: none;margin-top:0;padding-top:.2em;padding-bottom:.2em;'>
</div>
<!-- Final - Projeto escolhido -->
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
<!-- Final - div - div_form  -->
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


