<?php 
/*
    EDITANDO: LAFB/SPFB110903.0934

    REXP - CONSULTAR PESSOAL  
 
    LAFB/SPFB120220.2219
*/
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
// include('inicia_conexao.php');
extract($_POST, EXTR_OVERWRITE); 

///  HOST mais a pasta principal do site
$host_pasta="";
if( isset($_SESSION["host_pasta"]) ) $host_pasta=$_SESSION["host_pasta"];
///
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo "Sessão incluir_arq não está ativa.";
    exit();
}
///
include("{$incluir_arq}inicia_conexao.php");
////
//    MENU HORIZONTAL
include("{$incluir_arq}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    
$_SESSION["m_horiz"] = $array_projeto;
//
///   Caminho da pagina local
$pagina_local =  "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]="Registro de Anotação";
/// $_SESSION['time_exec']=180000;
?>
<!DOCTYPE html >
<html lang="pt-br" >
<head>
<meta charset="utf-8" />
<meta name="author" content="SPFB/LAFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<title>REXP - Consultar Pessoal</title>
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">
<!-- <script type="text/javascript"  language="javascript"   src="../includes/dochange.php" ></script>  -->
<link  type="text/css"  href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script>
<script  language="javascript"  type="text/javascript" >
//
///  Dados para enviar em pagina AJAX
function consulta_mostrapes(tcopcao,val,string_array) {
//
//  Selecionar os Usuários de acordo com a op??o (todos ou pela primeira letra)
//
//  LAFB/SPFB110831.1127
//
         
 /////  alert("  pessoal_consultar.php/123 -->>>>  tcopcao = "+tcopcao+" - val = "+val+" - string_array = "+string_array);    

    /// Verificando se a function exoc existe
    if(typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe");
    }
    ///
     ///  Verificando variaveis
    ///  Verificando variaveis
    if( typeof(tcopcao)=="undefined" ) var tcopcao=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";  
    /// Variavel estilo maiuscula
    var lcopcao = tcopcao.toUpperCase();
         
 ///  alert("  pessoal_consultar.php/123 --  tcopcao = "+tcopcao+" - val = "+val+" - string_array = "+string_array);    
    
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
    // Define o procedimento para processamento dos resultados dp srv_php
    var fndone_mostraus = function (oXML) { 
           ///  Recebendo o resultado do php/ajax
           var srv_ret = oXML.responseText;
            var lnip = srv_ret.search(/Nenhum|ERRO:/i);
            if( lnip==-1 ) {
                 if( lcopcao=="LISTA" ) {
                      if( document.getElementById('div_pagina') ) {
                           ///  Mostrar dados no ID div_pagina
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
                     ////  document.getElementById('div_out').innerHTML=srv_ret;                 
                     ///  Mostrar dados no ID  div_out
                     exoc("div_out",1,srv_ret);  
                     ////  
                 }    
             } else {
                  ///  Mostrar erro no ID label_msg_erro
                  /* 
                     document.getElementById('label_msg_erro').style.display="block";
                     document.getElementById('label_msg_erro').innerHTML=srv_ret;
                  */
                  exoc("label_msg_erro",1,srv_ret);  
             }; 
             ///
    };
    /// 
    //  Define o servidor PHP para consulta do banco de dados
    var srv_php = "srv_mostrapessoal.php";
    var poststr = new String("");
    //// var poststr = "grupous="+encodeURIComponent(lcopcao)+"&valor="+encodeURIComponent(dados);
    var poststr = "grupous="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
    
  //// alert("Ativando srv_mostraus com poststr="+poststr)

    xAJAX_mostraus.connect(srv_php, "POST", poststr, fndone_mostraus);   
}
</script>
<?php
///  Arquivo javascript em PHP
////  
include("{$_SESSION["incluir_arq"]}js/pessoal_consultar_js.php");
////
///  Alterado em 20171023
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

///   CONSULTAR PESSOAL
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//
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
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<!--  Mensagem de ERRO e Titulo  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Consultar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Mensagem de ERRO e Titulo  -->
<?php 
//     Verificano o PA - Privilegio de Acesso
//  if( ( $_SESSION["permit_pa"]>$_SESSION['array_usuarios']['superusuario']  and $_SESSION["permit_pa"]<=$_SESSION['array_usuarios']['orientador'] ) ) {    
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {    
    ?>
<div id="div_form" class="div_form" style="overflow:auto;" >
<?php
//  CODIGO/USP
$elemento=5;
include("php_include/ajax/includes/conectar.php");     
//
///  Selecionar os usuarios pela primeira letra do nome
$sqlcmd = "SELECT upper(substr(nome,1,1)) as letra1,count(*) as n "
    ." FROM pessoal.pessoa  group by 1";
$result = mysql_query($sqlcmd);
if( ! $result ) {
    die('ERRO: Falha consultando a tabela pessoa  - letra inicial: '.mysql_error());  
}       
$lnletras = mysql_num_rows($result);                
//
//  Salvar letrais iniciais em um conjunto para facilitar a busca
?>
<!-- Todas pessoas -->
<div style="display: flex;"  >
 <div class='titulo_usp' style='margin-left: 40%; padding:2px 0 2px 2px; vertical-align: bottom;font-weight: bold;font-size:large;  '>Mostrar:&nbsp;
 <span style="vertical-align:top;font-size: medium;  " >
<input type='button' id='todos' class='botao3d'  value='Todos' 
    title='Selecionar todos'  onclick='javascript:  consulta_mostrapes("Todos")' >
</span>
</div>
<!-- tag Select para ordenar  -->
<select  title="Ordernar" id="ordenar" class="ordenar"  onchange="javascript: consulta_mostrapes('ordenar',todos.value,this.value)" >
<option  value=""  >ordenar por</option>
<option  value="categoria asc"  >Categoria - asc</option>
<option  value="categoria desc" >Categoria - desc</option>
<option  value="nome asc"  >Nome - asc</option>
<option  value="nome desc" >Nome - desc</option>
<option  value="sexo asc"  >Sexo - asc</option>
<option  value="sexo desc" >Sexo - desc</option>
<option  value="unidade asc"  >Unidade - asc</option>
<option  value="unidade desc"  >Unidade - desc</option>
<option  value="unidade,setor asc"  >Unidade,Setor - asc</option>
<option  value="unidade,setor desc"  >Unidade,Setor - desc</option>
</select>
</div>
<!--  Final - Todas pessoas -->
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" style="text-align: center;width:100%;font-size:medium;font-weight: bold;" >ou pela letra inicial:&nbsp;
</p>
</div>
<div style="text-align: center;padding-top:0px; padding-bottom: 5px;" >
<select name="Busca_letrai" id="Busca_letrai" class="Busca_letrai" title="Selecionar pessoa pela letra inicial" onchange="javascript:  consulta_mostrapes(this.value)" >
<?php
   if( intval($lnletras)<1 ) {
          echo "<option value='' >== Nenhum Usu&aacute;rio encontrado ==</option>";
   } else {
?>
<option value="" >== Selecionar Pessoa pela letra inicial ==</option>
<?php
       ///  Com um ou mais registros 
       while( $linha=mysql_fetch_array($result) ) {       
             ///  htmlentities - corrige poss?veis falhas de acentuacao de code page
             $letra= htmlentities($linha["letra1"]);  
             echo "<option  value=".urlencode($letra)."  title='Clicar para Busca'  >".$letra."</option>" ;
       }
?>
</select>
<?php
      if( isset($result) )  mysql_free_result($result); 
  }
?>   
</div>
<p class='titulo_usp' style='margin: 0px; padding: 0px; line-height:normal; '  ><b>Lista do Pessoal</b></p>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
<div id="div_out" class="div_out" >
</div>
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("../includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>