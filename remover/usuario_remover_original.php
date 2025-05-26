<?php 
/*   Iniciando conexao - REMOVER USUARIO   */
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
///
?>
<!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8" />
<meta name="author" content="SPFB/LAFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Remover Usu&aacute;rio</title>
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
/****
          Arquivo javascript em PHP
*****/  
include("{$_SESSION["incluir_arq"]}js/usuario_remover_js.php");
///
///  Para fazer mudar de pagina no Menu - alterado em 20171023
/// require_once("{$incluir_arq}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

////   REMOVER  USUARIO
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
///
?>
</head>
<body id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"  onkeydown="javascript: no_backspace(event);" >
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
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<!--  Mensagem de ERRO e titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Remover&nbsp;Usuário</p>
</section>
<!-- Final - Mensagem de ERRO e titulo  -->
<p class='titulo_usp' style="overflow:hidden;" >
<span style="color: #FF0000;" >Caso removido perder&aacute; todos seus Projetos.</span></p>
<?php 
///	 Verificando o PA  --- alterado em 20180608
//// if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {                    
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<$array_pa['orientador'] ) ) {                    
///    
?>
<div id="div_form"  class="div_form" >
<?php
//   Conectar
///  $elemento=5; $elemento2=6;
/////  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
///  include("php_include/ajax/includes/conectar.php");     
///
///  Usuario conectado - codigo
$usuario_conectado=$_SESSION["usuario_conectado"];

///  Selecionar os usuarios para remover - alterado em 20180608
/***
$sqlcmd = "SELECT upper(substr(b.nome,1,1)) as letra1,count(*) as n "
      ." FROM $bd_1.usuario a, $bd_1.pessoa b, $bd_2.pa c "
      ." WHERE a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$array_pa['aprovador'] 
      ." group by 1";
***/      
$sqlcmd = "SELECT upper(substr(b.nome,1,1)) as letra1,count(*) as n "
      ." FROM $bd_1.usuario a, $bd_1.pessoa b, $bd_2.pa c "
      ." WHERE a.codigousp=b.codigousp and a.pa=c.codigo and a.codigousp!=$usuario_conectado  " 
      ." group by 1";
///
$result = mysql_query($sqlcmd);
if( ! $result ) {
    ///    $msg_erro .= "Falha consultando as tabelas usuario, pessoa e pa - letra inicial: ".mysql_error().$msg_final;  
    ///  echo $msg_erro;
    echo $funcoes->mostra_msg_erro("Falha consultando as tabelas usuario, pessoa e pa - letra inicial -&nbsp;db/mysql:&nbsp;".mysql_error());
    exit();
}       
///  Numero de usuarios
$lnletras = mysql_num_rows($result);                
///
//  Salvar letrais iniciais em um conjunto para facilitar a busca
?>
<!-- Todas pessoas -->
<div style="display: flex;"  >
<div class='titulo_usp' style='margin-left: 30%; padding:2px 0 2px 2px; font-weight: bold;font-size:large;' >
Mostrar:&nbsp;
 <span style="font-size: medium;" >
<input type='button' id='todos'  name='todos' class='botao3d'  value='Todos' 
    title='Selecionar todos'  onclick='javascript:  remove_usuario("Todos")' >
</span>
<span class="span_ord_proj" >
<!-- tag Select para ordenar  -->
<select  title="Ordernar" id="ordenar" class="ordenar" 
   onchange="javascript: remove_usuario('ordenar',todos.value,this.value)" >
<option  value=""  >ordenar por</option>
<option  value="datavalido asc"  >Data de Validade - asc</option>
<option  value="datavalido desc" >Data de Validade - desc</option>
<option  value="nome asc"  >Nome - asc</option>
<option  value="nome desc" >Nome - desc</option>
</select>
</span>
</div>
</div>
<!--  Final - Todas pessoas/usuarios -->
<!--  Selecionar usuario pela letra inicial do nome  -->
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" style="text-align: center;width:100%;font-size:medium;font-weight: bold;" >ou pela letra inicial do Nome:&nbsp;</p>
</div>
<div style="text-align: center;padding-top:0px; padding-bottom: 5px;" >
<select name="Busca_letrai" id="Busca_letrai" class="Busca_letrai"  title="Selecionar usu&aacute;rio pela letra inicial do nome" 
  onchange="javascript: remove_usuario(this.id,this.value)"  style="font-size:medium;" >
<?php
    if( intval($lnletras)<1 ) {
        echo "<option value='' >== Nenhum usu&aacute;rio encontrado ==</option>";
    } else {
        ///  Selecionar os usuarios pela primeira letra do nome
?>
<!--  <option value="" >=== Selecionar Usu&aacute;rio pela Letra Inicial ===</option>  -->
<option value="" >== Selecionar usu&aacute;rio pelo nome ==</option>
<?php
    while( $linha=mysql_fetch_array($result) ) {       
         ////  htmlentities - corrige poss?veis falhas de acentua??o de code page
          $letra= htmlentities($linha["letra1"]);  
          echo "<option  value=".urlencode($letra)."  title='Clicar para Busca' >".$letra."</option>" ;
    }
?>
</select>
<?php
       if( isset($result) ) mysql_free_result($result); 
    }
?>
</div> 
<!--  Final - Selecionar usuario pela letra inicial do nome  -->
<p class='titulo_usp' style='margin: 0px; padding: 0px; line-height:normal; '  ><b>Lista dos Usu&aacute;rios</b> <span style="font-size: 10px; ">- (de menor PA)</span></p>
<!--  Usuario escolhido -->
<div class='titulo_usp' id="usuario_remove" style='text-align: justify;display: none;margin-top:0;padding-top:.2em;padding-bottom:.2em;'>
</div>
<!-- Final - Usuario escolhido -->
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
<?php include_once("{$incluir_arq}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>