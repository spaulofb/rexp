<?php
//
//  Formulario Esqueci a Senha
//
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // sempre modificada
header("Pragma: no-cache"); // HTTP/1.0
header("Cache: no-cache");
//  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
// Força a recarregamento do site toda vez que o navegador entrar na página
header("http-equiv='Cache-Control' content='no-store, no-cache, must-revalidate'");
//  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0")
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//
//   Definindo a Raiz do Projeto
$_SESSION["pasta_raiz"]='/rexp/';
//
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML XMLNS="http://www.w3.org/1999/xhtml">
<HEAD>
<title>Ativar Permissão de Acesso</title>
<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=ISO-8859-1" />
<META http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE"> 
<META HTTP-EQUIV="Expires" CONTENT="-1" >
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<META http-equiv="imagetoolbar" content="no">  
<script type="text/javascript">
//
//  Javascript - 20100621
/*
     Aumentando a Janela no tamanho da resolucao do video
*/
self.moveTo(-4,-4);
//  self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
//  self.resizeTo(1000,1000);
self.focus();
//   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
if ( screen.width<1024 ) {
    alert("A resolução da tela do seu monitor para esse site é\n RECOMENDÁVEL no mínimo  1024x768 ")
}
//
</script>
<style  type="text/css"   >
.p_justify { text-align: justify; }
.sem_scroll { overflow: hidden; top: 0; left: 10px; margin-top:0; padding: 0px;    }
</style>
<link  type="text/css"  rel="stylesheet" href="css/estilo.css" />
<link  type="text/css"  rel="stylesheet" href="css/styles.css" />
<script  type="text/javascript" src="js/XHConn.js" ></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript"  src="js/formata_data.js"  ></script>
<script type="text/javascript" src="js/dados_recebidos.js"></script>  
</head>
<body   onload="refreshimg('label_msg_erro','msg_erro');"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"  >
<?php
//  require para o Navegador que nao tenha ativo o Javascript
require("js/noscript.php");
$cod_acesso="Digitar Código de Ativação de Acesso";
$tit_email="Digitar Email";
//
?>
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<div style="vertical-align: middle; background-color: #00FF00; border: 2px double #000000; height: 32px;" >
</div>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<label  id="label_msg_erro" style="display:none; position: relative;width: 100%; text-align: center; overflow:hidden;" >
    <font  id="msg_erro" style="position:  relative; "  ></font>
</label>
<p class='titulo_usp' style="font-size: larger;  padding-left: 10px; margin: 2px; text-align: left; overflow:hidden;" ><b>Ativação de Acesso do Usuário</b></p>   
<h3 class="titlehdr" style="margin: 4px;" ></h3>
<p style="margin-left: 10px; margin-bottom: 0px; padding-bottom: 0px; bottom: 0px;" >Para ativar sua conta de acesso (usuário/login) será necessário informar os dados a seguir:<br>
</p>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr>
    <td  valign="top">
    <!--  <form action="activate.php" method="post" name="actForm" id="actForm" > -->
     <form  method="post" name="actForm" id="actForm"  onsubmit="javascript: enviar_dados('submeter','AUTORIZAR',document.actForm); return false; "   >
        <table width="85%" border="0" cellpadding="4" cellspacing="4" class="loginform"  style="margin-top: 0px; top:0px; padding-top: 0px;">
           <tr  > 
            <td width="20%"  style="vertical-align: text-top;"  ><label for="email" style="cursor: pointer;"  title="<?php echo $tit_email;?>"  >E_mail Cadastrado:</label>
            </td>
            <td  style="vertical-align: top;" >
            <input  type="text"  name="user_email" id="user_email" class="required email"  size="85"  maxlength="64"  title="<?php echo $tit_email;?>" onKeyUp="this.value=trim(this.value);"  onblur="javascript: alinhar_texto(this.id,this.value); " autocomplete="off"   > 
            
             </td>
          </tr>          
          <tr> 
            <td><label for="activ_code" style="cursor: pointer;" title="<?php  echo  $cod_acesso;?>"   >Código de ativação:</label>
            </td>
            <td><input  type="password"   name="activ_code"  id="activ_code" class="required"  size="25" maxlength="10"  title="<?php  echo  $cod_acesso;?>"  onKeyUp="this.value=trim(this.value);"  onblur="javascript: alinhar_texto(this.id,this.value);" autocomplete="off"  >
            <input  type="hidden"  name="codigousp" id="codigousp"  value="<?php echo $_GET[user];?>"  />
            </td>
          </tr>
          <tr> 
           <td  align="center"  style="text-align: left; border:none; ">
              <button type="submit"  name="enviar" id="enviar"    class="botao3d"  style="cursor: pointer; "  title="Enviar"  acesskey="E"  alt="Enviar"   >    
      Enviar&nbsp;<img src="imagens/enviar.gif" alt="Enviar"  style="vertical-align:text-bottom; cursor: pointer;"  >
             </button>
           </td>
          </tr>
        </table>
      </form>
      </td>
  </tr>
</table>
</div>
<!-- Final Corpo -->
<!-- Rodape -->
<div id="rodape"  >
<?php include_once("includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
