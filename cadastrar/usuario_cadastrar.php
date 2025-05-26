<?php 
/*   REXP - CADASTRAR USUARIO   
*   
*   REQUISITO: O usuario deve ter PA>0 e PA<=30
* 
*   SPFB&LAFB110825.1610    - Inclusao de Tipos de PA (Supervisor, chefe, ... anotador)
*   SPFB&LAFB110906.1527
*/
//  ==============================================================================================
///    ATENCAO: SENDO EDITADO POR LAFB
//  ==============================================================================================
///
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
      ///  Alterado em 20180621
     $msg_erro .= "<br/>Ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
/***
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
***/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");
///
///  Variavel recebida do script/arquivo - inicia_conexao.php 
$_SESSION["m_horiz"] = $array_projeto;
///
/// $_SESSION['time_exec']=180000;
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]= utf8_decode("Registro de Anotação") ;
///
////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
?>
<!DOCTYPE html>
<html lang="pt-BR" >
<head>
<meta charset="UTF-8" />
<meta name="author" content="Sebasti?o Paulo" />
<META http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE"> 
<META HTTP-EQUIV="Expires" CONTENT="-1" >
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<META http-equiv="imagetoolbar" content="no">  
<title>REXP - Cadastrar Usuário</title>
<link  type="text/css"  href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/cad_proj_expe.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script>
<?php
$_SESSION["n_upload"]="ativando";
/****
*         Alterado em 20171004
  ///    require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
***/
require_once("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"   >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("../script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("../includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo" >
<?php 
//   CADASTRAR USUARIO
if (isset($_GET["m_titulo"])) {
    if( strlen(trim($_GET["m_titulo"]))>1 )  $_SESSION['m_titulo']=$_GET["m_titulo"];  
}
if (isset($_POST["m_titulo"])) {
    if( strlen(trim($_POST["m_titulo"]))>1 )  $_SESSION['m_titulo']=$_POST["m_titulo"];      
}
//				  
?>
<label  id="label_msg_erro" style="display:none; position: relative;width: 100%; text-align: center; overflow:hidden;" >
   <font  ></font>
</label>
<p class='titulo_usp' style="overflow: hidden; height: 20px; padding-top:2px; padding-bottom: 4px;" ><b>Cadastrar Participante de Projeto de acordo com categoria (PA) de Acesso </b></p>
<div id="div_form" style="width:100%; overflow:auto; height: 416px; ">
<?php
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
$dia = date("d");
$mes = date("m");
$ano = date("Y"); 
$ano_validade=$ano+2;
$_SESSION['datacad']="$ano-$mes-$dia";
$_SESSION['datavalido']="$ano_validade-12-31";
//
//  Verificando permissao para acesso por Orientador ou Superior
//
if( ( $_SESSION["permit_pa"]>$_SESSION['array_usuarios']['superusuario']  and $_SESSION["permit_pa"]<=$_SESSION['array_usuarios']['orientador'] ) ) {    
  ?>
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: enviar_dados_cad('submeter','USUARIO',document.form1); return false"  >
  <table class="table_inicio" cols="4" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; border: none;"  >

          <tr  >
                <!-- Codigo/USP -->
              <td  class="td_inicio1"  style="vertical-align: middle; "  >
                 <label for="codigousp" style="vertical-align: middle; cursor: pointer;" title="Participante de Projeto"   >Participante:&nbsp;</label>
              </td  >
		     <td class="td_inicio2" >
			    <?php
				   //  Sele??o do Participante:
                   if (!isset($_SESSION)) {
                        session_start();    
                   }
                   $elemento=5;
                   include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");			
   		           $result = mysql_query("SELECT codigousp,nome,categoria FROM pessoa  order by nome "); 
                  //  CODIGO/Num_USP
                  $m_linhas = mysql_num_rows($result);				
				?>
               <select name="codigousp" class="td_select"   id="codigousp"  title="Selecionar C&oacute;digo"   >			
                 <?php
				  if ( $m_linhas<1 ) {
                        echo "<option value='' >Nenhum Participante encontrado.</option>";
                 } else {
				   ?>
 		           <option value="" >Selecione...</option>
					<?php
   		    		     // Usando arquivo com while e htmlentities
	    				 //  include("../includes/tag_select_tabelas.php");
						$codigo_sigla=mysql_field_name($result,0);
						$cpo_nome_descr=mysql_field_name($result,1);
                        while($linha=mysql_fetch_array($result)) {       
                            //  htmlentities - o melhor para transferir na Tag Select
                            $sigla= htmlentities($linha[$codigo_sigla]);  
                  	        $nome= htmlentities($linha[$cpo_nome_descr]);  
                            echo "<option  value=".urlencode($linha[$codigo_sigla])."  "
                     		        ."  title='Clicar'  >";
                                    echo  $nome."</option>" ;
                        }

					 ?>
	             </select>
					<?php
                    mysql_free_result($result); 
                  }
				  ?>   
			 </td>
          <!-- Final - Codigo -->
            </tr>

<!--        Inicio do Bloco de entrada do PA -->
          <tr  >
              <td  class="td_inicio1"  style="vertical-align: middle; "  >
                 <label for="pa" style="vertical-align: middle; cursor: pointer;" title="PA=Privilegio de Acesso"   >Categoria (PA):&nbsp;</label>
              </td  >
             <td class="td_inicio2" >
                <?php
                   //  Sele??o do Participante:
                   if (!isset($_SESSION)) {
                        session_start();    
                   }
                   $elemento=5;
                   include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
                   $result = mysql_query("SELECT codigo,descricao FROM rexp.pa where "
                             ."  codigo>".$_SESSION["permit_pa"]." order by codigo "); 
                   //          
                   if ( ! $result ) {
                        mysql_free_result($result);
                        die("ERRO: Inesperado no mysql/query pa=".mysql_error());
                   }
                  $m_linhas = mysql_num_rows($result);                
                ?>
               <select name="pa"  id="pa"  class="td_select"   title="Selecionar PA"   >            
                 <?php
                  if ( $m_linhas<1 ) {
                        echo "<option value='' >Sem Permiss&atilde;o para criar Usuário.</option>";
                 } else {
                   ?>
                    <option value="" >Selecione...</option>
                    <?php
                        $codigo_idt=mysql_field_name($result,0);
                        $descricao_idt=mysql_field_name($result,1);
                        while($linha=mysql_fetch_array($result)) {       
                            //  htmlentities - o melhor para transferir na Tag Select
                            $codigo_val= htmlentities($linha[$codigo_idt]);  
                            $descricao_val= htmlentities($linha[$descricao_idt]);  
                            echo "<option  value=".urlencode($codigo_val)." title='Clicar'  >";
                            echo  $descricao_val."</option>" ;
                        }
                     ?>
                 </select>
                 <?php
                    mysql_free_result($result); 
                  }
                  ?>   
             </td>
            </tr>
<!--        Final do Bloco de entrada do PA -->
            
          <tr  >
            <!--  Usuario para conectar -->
              <td  class="td_inicio1" style="vertical-align: middle; "  colspan="1"   >
                 <label for="login" style="vertical-align: middle; cursor: pointer;" title="Código do Usuário(Login)"   >Usu&aacute;rio(Login)/e-mail:&nbsp;</label>
              </td  >
			  <td class="td_inicio2"  colspan="3"  >
			  <input type="text" name="login"   id="login"   size="80"  maxlength="64" title='Digitar Usuário/e-mail: no m?nimo 8 caracteres'  onkeyup="javascript: down_char(this.id);this.value=trim(this.value);"  onblur="javascript: alinhar_texto(this.id,this.value)" autocomplete="off"  style="cursor: pointer;"  />
			 </td>
          <!-- Final - Usuario -->
            </tr>




     <tr style="border: none;" >
       <!--  Verificando a Senha  -->
       <td>&nbsp;</td>
       <td>
         <div id="div_forca_senha" name="div_forca_senha" style="background-color: rgb(255, 255, 255); width: 326px; height: auto;">&nbsp;</div>
       </td>
     </tr>

          
     <tr class="td_inicio2" > 
        <!-- Incluir senha e redigitar_senha  --> 
        <td class="td_inicio1" >
           <label for="senha" style="cursor: pointer;"  >Senha:&nbsp;</label>
        </td>
        <td class="td_inicio1"  style="text-align: left;"  >
           <input  type="password" class="required password" name="senha" id="senha" title="Digitar Senha (8 a 10 caracteres)" size="25" maxlength="12"  onKeyUp="this.value=trim(this.value);  verificaForca(this);"  onblur="javascript: alinhar_texto(this.id,this.value);  exoc('label_msg_erro',0.'');"  autocomplete="off"   > 
          <span class="example">(8 a 10 caracteres)</span>
            <input type="hidden" name="datacad" id="datacad" value="<?php echo $_SESSION['datacad'];?>"  />
            <input type="hidden" name="datavalido" id="datavalido" value="<?php echo $_SESSION['datavalido'];?>"  />
        </td>
     </tr>
     <tr class="td_inicio2" > 
        <td class="td_inicio1" >
          <label for="redigitar_senha" style="cursor: pointer;"  >Redigitar Senha:&nbsp;</label>
        </td>
        <td class="td_inicio1"  style="text-align: left;" >
           <input  type="password" name="redigitar_senha"  id="redigitar_senha" class="required password" title="Redigitar Senha (8 a 10 caracteres)" size="25" maxlength="12"  onKeyUp="this.value=trim(this.value);  verificaForca(this);"  onblur="javascript: alinhar_texto(this.id,this.value); exoc('label_msg_erro',0,'');"  autocomplete="off"  >
        </td>
        <!-- Final -  Incluir senha e redigitar_senha  -->
     </tr>

          
          
         <!--  TAGS  type reset e  submit  --> 
        <tr  style="border: 1px solid #000000; width: 100%; vertical-align:top;  line-height:0px;" >
          <td colspan="4"  class="td_inicio1" nowrap style="background-color: #FFFFFF; padding: 1px; line-height:0px;">
             <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; line-height: 0px; margin:0px; padding: 2px 0 2px 0; border: none; vertical-align: top; " >
			    <tr style="border: none;">
				<td  align="CENTER" nowrap style="text-align:center; border:none;" >
			   <button name="limpar" id="limpar"  type="reset" onclick="javascript: document.getElementById('msg_erro').style.display='none';"  class="botao3d" style="cursor: pointer; "  title="Limpar"  acesskey="L"  alt="Limpar"     >    
      Limpar <img src="../imagens/limpar.gif" alt="Limpar" style="vertical-align:text-bottom;" >
   </button>
               <!-- Enviar -->				  
			      </td>
			   <td  align="center"  style="text-align: center; border:none; ">
			   <button name="enviar" id="enviar"   type="submit"  class="botao3d"  style="cursor: pointer; "  title="Enviar"  acesskey="E"  alt="Enviar"     >    
      Enviar&nbsp;<img src="../imagens/enviar.gif" alt="Enviar"  style="vertical-align:text-bottom;"  >
   </button>
			  </td>
              <!-- Final -Enviar -->
			   </tr>
              <!--  FINAL - TAGS  type reset e  submit  -->
			  </table>
			  </td>
            </tr>
         </table>
</form>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
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
