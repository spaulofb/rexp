<?php 
/*   REXP - ALTERAR SENHA  
*   
*   REQUISITO: Alterar a senha usuario/login
* 
*   SPFB&LAFB180615.1610    
*/
//  ==============================================================================================
///  ALTERA SENHA 
//  ==============================================================================================
//
//  Verificando se session_start - ativado ou desativado
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
///   Definindo a sessao 
if( ! isset($_SESSION["projeto_autor_nome"]) ) $_SESSION["projeto_autor_nome"]="";
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
<html lang="pt-br" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="pt-br" />
<meta name="author" content="Sebasti?o Paulo" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Alterar senha</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<!--  <script type="text/javascript"  src="<?php echo $host_pasta;?>js/anotacao_cadastrar.js" ></script>  -->
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!-- <script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script> -->
<?php
/***    Arquivo javascript em PHP - alterado em 20171024
***/  
include("{$_SESSION["incluir_arq"]}js/alterar_senha_js.php");
///

$_SESSION["n_upload"]="ativando";
///  Para fazer mudar de pagina no Menu  -  alterado em 20171023
/// require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");   
require("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);" >
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
<?php 
///   ALTERAR SENHA
if (isset($_GET["m_titulo"])) {
    if( strlen(trim($_GET["m_titulo"]))>1 )  $_SESSION['m_titulo']=$_GET["m_titulo"];  
}
if (isset($_POST["m_titulo"])) {
    if( strlen(trim($_POST["m_titulo"]))>1 )  $_SESSION['m_titulo']=$_POST["m_titulo"];      
}
///				  
?>
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro" >
</div>
<p class="titulo_usp" >Alterar Senha do C&oacute;digo de Acesso (Usu&aacute;rio/Login)</p>
</section>
<!-- Final - Mensagem de ERRO e Titulo    -->
<!--  DIV -  id="div_form" class="div_form"   -->
<div id="div_form" class="div_form" style="overflow:auto;" >
<?php
///   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
$dia = date("d");
$mes = date("m");
$ano = date("Y"); 
$ano_validade=$ano+2;
$_SESSION['datacad']="$ano-$mes-$dia";
$_SESSION['datavalido']="$ano_validade-12-31";
///
?>
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: enviando_dados('submeter','SENHA',document.form1); return false"  >
  <table class="table_inicio" cols="4" style="font-weight:normal; color: #000000; border: none;" >      
     <tr>
        <!--  Usuario para conectar -->
           <td class="td_inicio1" style="vertical-align: middle; "  colspan="1" >
               <label for="login" style="vertical-align: middle; cursor: pointer;" title="Código do Usuário(Login)"   >Usu&aacute;rio(Login):&nbsp;</label>
           </td>
		   <td class="td_inicio2" colspan="3" >
			  <input type="text" name="login" id="login"  size="60"  maxlength="76"  style="cursor: pointer;"  
                 value="<?php echo $_SESSION['login_down']; ?>" autocomplete="off"  readonly="readonly" disabled="disabled" />
		   </td>
            <!-- Final - Usuario -->
     </tr>    

     <tr style="border: none;" >
       <!--  Verificando a Senha  -->  
       <td>&nbsp;</td>
       <td>
         <div id="div_forca_senha" name="div_forca_senha" style="background-color: rgb(255, 255, 255); width: 326px; margin:3px 0 3px 0;">Qualidade da Senha</div>
       </td>
     </tr>
          
     <tr class="td_inicio2" > 
        <!-- Incluir senha e redigitar_senha  --> 
        <td class="td_inicio1" >
           <label for="senha" style="cursor: pointer;" >Nova Senha:&nbsp;</label>
        </td>
        <td class="td_inicio1"  style="text-align: left;" >
           <input  type="password" class="required password" name="senha" id="senha" title="Digitar Senha (8 a 10 caracteres)" size="25" maxlength="12"  onKeyUp="this.value=trim(this.value);  verificaForca(this);"  onblur="javascript: alinhar_texto(this.id,this.value);  exoc('label_msg_erro',0,'');"  autocomplete="off"   > 
             <span class="example">(8 a 10 caracteres)</span>
        </td>
     </tr>
     <tr class="td_inicio2" > 
        <td class="td_inicio1" >
          <label for="redigitar_senha" style="cursor: pointer;" >Redigitar Senha:&nbsp;</label>
        </td>
        <td class="td_inicio1"  style="text-align: left;" >
           <input  type="password" name="redigitar_senha"  id="redigitar_senha" class="required password" title="Redigitar Senha (8 a 10 caracteres)" size="25" maxlength="12"  onKeyUp="this.value=trim(this.value);  verificaForca(this);"  onblur="javascript: alinhar_texto(this.id,this.value); exoc('label_msg_erro',0,'');"  autocomplete="off"  >
        </td>
        <!-- Final -  Incluir senha e redigitar_senha  -->
     </tr>

     
     <!--  TAGS  type reset e  submit  --> 
     <tr>
       <td colspan="3"  class="td_inicio1" >
           <div class="reset_button"  >    
              <!-- Cancelar -->                                
               <span>
                <button  type="button" name="limpar" id="limpar"  class="botao3d" style="cursor: pointer;"  
                   onclick="javascript: enviando_dados('reset','<?php echo $pagina_local;?>'); return false;"  title="Cancelar" acesskey="C"  alt="Cancelar" >    
                  Cancelar&nbsp;<img src="../imagens/limpar.gif" alt="Cancelar" >
                </button>
                </span>
                <span>
                <!-- Final - Cancelar -->
               <!-- Alterar -->                                
               <button  type="submit"  name="enviar" id="enviar"  class="botao3d"  style="cursor: pointer; "  title="Alterar"  acesskey="A"  alt="Alterar" >    
                  Alterar&nbsp;<img src="../imagens/enviar.gif" alt="Alterar" >
               </button>
              </span> 
               <!-- Final - Alterar -->
      </td>
     </tr>
      <!--  FINAL - TAGS  type reset e submit  -->
   </table>
</form>
</div>
<!--  Final - id="div_form" class="div_form"   -->
</div>
 <!-- Final - Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("{$_SESSION["incluir_arq"]}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
