<?php 
/*   Iniciando conexao - CONSULTAR USUARIO   */
#
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
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
/// $_SESSION['time_exec']=180000;
///
////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
?>
<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8" />
<meta name="author" content="SPFB/LAFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Consultar Usu&aacute;rio</title>
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
///  Arquivo javascript em PHP
////  
include("{$_SESSION["incluir_arq"]}js/usuario_consultar_js.php");
///
?>
<script  language="javascript"  type="text/javascript" >
///
///   JavaScript Document
///
/****  
    Define o caminho HTTP  -  20180808
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
function consulta_mostraus(tcopcao,val,string_array){
//
//  Selecionar os Usuários de acordo com a op??o (todos ou pela primeira letra)
//
//  LAFB/SPFB110831.1127
//
    /// Verificando se a function exoc existe
    if(typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe");
    }
    ///
    ///  Verificando variaveis
    if( typeof(tcopcao)=="undefined" ) var tcopcao=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";  
    ///
    var lcopcao = tcopcao.toUpperCase();
    /****  
           Define o caminho HTTP    -  20180719
    ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       

     
 ////   alert("  usuario_consultar.php/123 --  tcopcao = "+tcopcao+" - val = "+val+" - string_array = "+string_array);    
    
    /// BOTAO - TODOS
    var lcopcao = tcopcao.toUpperCase();
    var quantidade= lcopcao.search(/TODOS|TODAS/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("ordenar") ) {
             document.getElementById("ordenar").style.display="block";            
        } else {
             alert("Faltando document.getElementById(\"ordenar\") ");           
        }
        if( document.getElementById("Busca_letrai") ) {
              document.getElementById("Busca_letrai").selectedIndex="0";
        } 
        ///  Desativando ID  div_out
        exoc("div_out",1,"");                   
        ///
        return;
    }
    /// tag Select para Ordenar o Botao Todos
    var quantidade=lcopcao.search(/ORDENAR/i);
    if( quantidade!=-1 ) {
         var tmp=val;
         var val=lcopcao;
         var lcopcao=tmp;
         ///  var string_array=string_array.replace(" ","");      
        if( document.getElementById("Busca_letrai") ) {
              document.getElementById("Busca_letrai").selectedIndex="0";
        }    
        ///
    }   
    //// 
    /// tag Select para desativar o campo Select ordenar
    var quantidade=lcopcao.search(/BUSCA_PROJ|busca_porcpo|Busca_letrai/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("ordenar") ) {
              document.getElementById("ordenar").selectedIndex="0";
              document.getElementById("ordenar").style.display="none";            
        }  
    }    
    
    /*   Iniciando o AJAX para selecionar os usuarios desejados  */
    var xAJAX_mostraus = new XHConn();
        
    if ( !xAJAX_mostraus ) {
          alert("XMLHTTP/AJAX não dispon?vel. Tente um navegador mais novo ou melhor.");
          return false;
    }
    ///
    ///  Define o procedimento para processamento dos resultados dp srv_php
    var fndone_mostraus = function(oXML) { 
          //  Recebendo o resultado do php/ajax
          var srv_ret = oXML.responseText;
          ///
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);
          
 ////  alert("usuario_consultar.php/112  ---  lnip="+lnip+" --->>>  lcopcao="+lcopcao+" --val = "+val+" <<<---  \r\n srv_ret =  "+srv_ret);   
          
          if( lnip==-1 ) {
             if( lcopcao=="LISTA" ) {
                 if( document.getElementById('div_pagina') ) {
                       ////  document.getElementById('div_pagina').style.display="block";    
                       ///  document.getElementById('div_form').setAttribute("style","padding-top: 2px; text-align: center;font-size: medium;");
                       ////  document.getElementById('div_pagina').innerHTML=srv_ret;      
                       ///  Mostrar dados no ID label_msg_erro
                       exoc("div_pagina",1,srv_ret);  
                 }                      
             } else {
                  if( lcopcao=="TODOS" ) {    
                     if( document.getElementById('Busca_letrai') )  {
                         document.getElementById('Busca_letrai').options[0].selected=true;
                         document.getElementById('Busca_letrai').options[0].selectedIndex=0;    
                     }
                  }    
                 ///  document.getElementById('label_msg_erro').style.display="none";    
                 document.getElementById('div_out').innerHTML=srv_ret;                 
             }    
          } else {
                 ///  Mostrar erro no ID label_msg_erro
                 /* 
                   document.getElementById('label_msg_erro').style.display="block";
                   document.getElementById('label_msg_erro').innerHTML=srv_ret;
                 */
                 exoc("label_msg_erro",1,srv_ret);  
           }; 
    };
    // 
    //  Define o servidor PHP para consulta do banco de dados
    /// var srv_php = "srv_mostraus.php";
    var srv_php = "srv_mostrausuario.php";
    var poststr = new String("");
    var poststr = "grupous="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 

  /// alert("Ativando srv_mostraus com poststr="+poststr)

    xAJAX_mostraus.connect(srv_php, "POST", poststr, fndone_mostraus);  
    //// 
}
</script>

<?php
///     Alterado em 20170925   
///   require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

////   CONSULTAR USUARIO
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
/// Alterado em 20171005
$_SESSION["m_titulo"]="Usuário";
///
?>
</head>
<body  id="id_body"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
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
//
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<!--  Mensagem de ERRO     -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Consultar&nbsp;Usuário</p>
</section>
<?php 
//	 Verificano o PA - Privilegio de Acesso
//  if( ( $_SESSION["permit_pa"]>$_SESSION['array_usuarios']['superusuario']  and $_SESSION["permit_pa"]<=$_SESSION['array_usuarios']['orientador'] ) ) {    
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {         
?>
<div id="div_form" class="div_form" style="overflow:auto;" >
<?php
///  CODIGO/USP
$elemento=5;
include("php_include/ajax/includes/conectar.php");     
///
///  Selecionar os usuarios pela primeira letra do nome e o codigousp
/*
$sqlcmd = "SELECT upper(substr(b.nome,1,1)) as letra1,a.codigousp,b.e_mail "
    ." FROM pessoal.usuario a, pessoal.pessoa b, rexp.pa c "
    ." WHERE a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$_SESSION["permit_pa"];
*/
///  Selecionar os usuarios pela primeira letra do nome
///  Alterado em 20180808
/***
$sqlcmd = "SELECT upper(substr(b.nome,1,1)) as letra1,count(*) as n "
    ." FROM pessoal.usuario a, pessoal.pessoa b, rexp.pa c "
    ." where a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$_SESSION["permit_pa"] 
    ." group by 1";
***/
$sqlcmd = "SELECT upper(substr(b.nome,1,1)) as letra1,count(*) as n "
    ." FROM pessoal.usuario a, pessoal.pessoa b, rexp.pa c "
    ." where a.codigousp=b.codigousp and a.pa=c.codigo  group by 1";
///
$result = mysql_query($sqlcmd);
if( ! $result ) {
    die('ERRO: Falha consultando as tabelas usuario, pessoa e pa - letra inicial:&nbsp;db/mysql:&nbsp;'.mysql_error());  
}       
$lnletras = mysql_num_rows($result);                
///
//  Salvar letrais iniciais em um conjunto para facilitar a busca
?>
<!-- Todas pessoas -->
<div style="display: flex;"  >
 <div class='titulo_usp' style='margin-left: 30%; padding:2px 0 2px 2px; font-weight: bold;font-size:large;' >
   Mostrar:&nbsp;
   <span style="font-size: medium;  " >
  <input type='button' id='todos' class='botao3d'  value='Todos' title='Selecionar todos'  onclick='javascript: consulta_mostraus("Todos")' >
</span>
  <span class="span_ord_proj" >
<!-- tag Select para ordenar  -->
<select   title="Ordernar"  id="ordenar"  class="ordenar"  onchange="javascript: consulta_mostraus('ordenar',todos.value,this.value)"  >
<option  value=""  >ordenar por</option>
<option  value="categoria asc"  >Categoria - asc</option>
<option  value="categoria desc" >Categoria - desc</option>
<option  value="nome asc"  >Nome - asc</option>
<option  value="nome desc" >Nome - desc</option>
</select>
</span>
</div>
</div>   
<!--  Final - Todas pessoas/usuarios -->
<!--  Selecionar usuario pela letra inicial do nome  -->
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_lista"  >ou pela letra inicial do Nome:&nbsp;</p>
</div>
<div class="div_select_busca" >
<select name="Busca_letrai" id="Busca_letrai" class="Busca_letrai" title="Selecionar usu&aacute;rio pela letra inicial do nome" 
    onchange="javascript:  consulta_mostraus(this.id,this.value)" >
<?php
    if( intval($lnletras)<1 ) {
        echo "<option value='' >Nenhum usu&aacute;rio encontrado</option>";
    } else {
?>
<!--  <option value="" >Selecionar Usu&aacute;rio pela Letra Inicial</option>  -->
<option value="" >Selecionar usu&aacute;rio pelo nome</option>
<?php
    while( $linha=mysql_fetch_array($result) ) {       
         ///  htmlentities - corrige possiveis falhas de acentuacao de code page
         $letra= htmlentities($linha["letra1"]);  
         $lncodigousp=$linha["codigousp"];  
         $lnemail=$linha["e_mail"];
         /*
          echo "<option  value=".urlencode($letra)."  "
                ."  title='Clicar para Busca'  >".$letra."</option>" ;
          */
          echo "<option  value=".urlencode($letra)."  title='Clicar para busca'  >".$letra."</option>" ;
          ////  echo "<option  value=".$lncodigousp."  title='Clicar para Busca'  >".$lnemail."</option>" ;
         ///
    }
?>
</select>
<?php
       if( isset($result) ) mysql_free_result($result); 
    }
?>
</div>   
<p class="titulo_lista" >Lista dos Usu&aacute;rios&nbsp;<span style="font-size: 12px; ">-&nbsp;(de menor PA)</span></p>
<?php
} else {
   echo  "<p class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
<div id="div_out" class="div_out" >
</div>
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