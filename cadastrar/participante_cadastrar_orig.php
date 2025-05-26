<?php 
/*   REXP - CADASTRAR USUARIO   
*   
*   REQUISITO: O usuÃ¡rio deve ter PA>0 e PA<=30
* 
*   SPFB&LAFB110825.1610    - InclusÃ£o de Tipos de PA (Supervisor, chefe, ... anotador)
*   SPFB&LAFB110906.1527
*/
//  ==============================================================================================
////  ATENCAO: SENDO EDITADO POR LAFB - CADASTRAR PARTICIPANTE/REXP MESMO QUE USUARIO/REXP
//  ==============================================================================================
///
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
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
// $_SESSION['time_exec']=180000;
///
////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
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
<meta charset="utf-8"/>
<meta name="author" content="Sebastião Paulo" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Cadastrar Participante</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script  type="text/javascript" >
/* <![CDATA[ */
function limpa_msg_erro() {
    document.getElementById("label_msg_erro").style.display="none";
}
/* ]]> */
</script>
<?php
///  Arquivo javascript em PHP
///
include("{$_SESSION["incluir_arq"]}js/participante_cadastrar_js.php");
///
$_SESSION["n_upload"]="ativando";
/****
*    Alterado em 20171023
***/
require_once("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" >
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
<div  id="corpo" >
<?php 
//   CADASTRAR  PARTICPANTE
if (isset($_GET["m_titulo"])) {
    if( strlen(trim($_GET["m_titulo"]))>1 )  $_SESSION['m_titulo']=$_GET["m_titulo"];  
}
if (isset($_POST["m_titulo"])) {
    if( strlen(trim($_POST["m_titulo"]))>1 )  $_SESSION['m_titulo']=$_POST["m_titulo"];      
}
///				  
?>                                                                                                       <!--  Mensagem de ERRO     -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<!--  Titulo da pagina  -->
<p class='titulo_usp' >Cadastrar Participante de Projeto <br/>de acordo com categoria (PA) de Acesso</p>
</section>
<!-- Final - Mensagem de ERRO     -->
<div id="div_form"  class="div_form" >
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
//  if( ( $_SESSION["permit_pa"]>$_SESSION['array_usuarios']['superusuario']  and $_SESSION["permit_pa"]<=$_SESSION['array_usuarios']['orientador'] ) ) {    
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {    
  ?>
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: enviar_dados_cad('submeter','PARTICIPANTE',document.form1); return false"  >
 <!-- div - ate antes do Limpar e Enviar -->
 <div class="parte_inicial" >
     <div class="div_nova"   >
        <!-- Participante/Codigo/USP -->
       <span>
          <label for="codigousp"  title="Participante de Projeto" >Participante:&nbsp;</label>
       </span>
        <span>
          <?php
               ///   Participante
               $elemento=5;
              ///   include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
              include("php_include/ajax/includes/conectar.php");
              ///  IMPORTANTE:  para acentuacao entre MySql e PHP
              /***          
                  mysql_query("SET NAMES 'utf8'");
                  mysql_query('SET character_set_connection=utf8');
                  mysql_query('SET character_set_client=utf8');
                  mysql_query('SET character_set_results=utf8');
                ***/
              ///  Executando Select/MySQL
              ///   Utilizado pelo Mysql/PHP - IMPORTANTE -20180615      
              /***
                  *    O charset UTF-8  uma recomendacao, 
                  *    pois cobre quase todos os caracteres e 
                  *    símbolos do mundo
              ***/
              mysql_select_db($bd_1);
              mysql_set_charset('utf8');                     
              ///         
              ///  Mysql - Select listando pessoas
              $result = mysql_query("SELECT codigousp,nome,categoria FROM  $bd_1.pessoa  order by nome "); 
               if( ! $result ) {
                    die('ERRO: Select - falha:&nbsp;db/mysql:&nbsp;'.mysql_error());
                    exit();
               }
              ///  CODIGO/Num_USP - numero de registros
              $m_linhas = mysql_num_rows($result);    
               ///  Caso Participante NAO encontrado
              if( intval($m_linhas)<1 ) {
                    echo "Nenhum Participante encontrado.";
              } 
             ///
            ?>
              <select  name="codigousp"  id="codigousp"  title="Selecionar" 
                 onchange="javascript: enviar_dados_cad('Participante',this.value);" 
                  required="required" >            
                    <option value='' >Selecione...</option>
                 <?php
                   ///
                   /// Usando arquivo com while e htmlentities
                   ///  include("../includes/tag_select_tabelas.php");
                    $codigo_sigla=mysql_field_name($result,0);
                    $cpo_nome_descr=mysql_field_name($result,1);
                    /// while( $linha=mysql_fetch_array($result) ) {       
                    for( $nx=0; $nx<$m_linhas; $nx++ ) {
                         ///  htmlentities - o melhor para transferir na Tag Select
                         /// $sigla= htmlentities($linha[$codigo_sigla]);  
                         $sigla=  mysql_result($result,$nx,$codigo_sigla);  
                         /// $codusp=urlencode($linha[$codigo_sigla]);
                         /// $codusp=$linha[$codigo_sigla];
                          ///  IMPORTANTE:  criar sempre outra variavel - OK
                          /// $nome_participante=htmlentities($nome_descr);
                          ///  $nome_participante=utf8_decode(mysql_result($result,$nx,$cpo_nome_descr));
                           $nome_participante=mysql_result($result,$nx,$cpo_nome_descr);
                           echo "<option  value='$sigla' title='Clicar'  >$nome_participante</option>" ;
                           /// echo  htmlentities($linha[$cpo_nome_descr],ENT_QUOTES,"UTF-8")."&nbsp;&nbsp;</option>" ;
                           /// echo  $linha[$cpo_nome_descr]."&nbsp;&nbsp;</option>" ;
                    }
                    /// Final - for
                    if( isset($result) )  mysql_free_result($result); 
               ?>
            </select>
        </span>
        <!-- Final - Participante/Codigo/USP -->
     </div>
     
     <div class="div_nova" >
          <span>
             <label for="pa"  title="PA=Privilegio de Acesso" >Categoria (PA):&nbsp;</label>
          </span>
           <span>
                 <?php
                   ///   Selecionar PA
                   $elemento=5;
                   /////  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
                   include("php_include/ajax/includes/conectar.php");
                    ///                         
                   $result = mysql_query("SELECT codigo,descricao FROM rexp.pa where "
                             ."  codigo>".$_SESSION["permit_pa"]." order by codigo "); 
                   ///          
                   if( ! $result ) {
                        die("ERRO: Inesperado no pa -&nbsp;db/mysql:&nbsp;".mysql_error());
                   }
                   /// Numero de registros
                  $m_linhas = mysql_num_rows($result);                
                   ///
                ?>
               <select name="pa"  id="pa"  class="td_select" title="Selecionar PA (Permiss&atilde;o de Acesso)" required="required"  >            
                 <?php
                  if( intval($m_linhas)<1 ) {
                        echo "<option value='' >Sem Permiss&atilde;o para criar usuário.</option>";
                 } else {
                   ?>
                    <option value="" >Selecione...</option>
                    <?php
                        $codigo_idt=mysql_field_name($result,0);
                        $cpo_descricao_idt=mysql_field_name($result,1);
                        while($linha=mysql_fetch_array($result)) {       
                             ///  htmlentities - o melhor para transferir na Tag Select
                             $codigo_val= htmlentities($linha[$codigo_idt]);  
                             //// $descricao_val= htmlentities($linha[$descricao_idt]);  
                             ////  $descricao_val= $linha[$descricao_idt];  
                             $desc_idt=htmlentities($linha[$cpo_descricao_idt],ENT_QUOTES,"UTF-8");
                             echo "<option  value=".urlencode($codigo_val)." title='Clicar' >$desc_idt</option>" ;
                        }
                 }      
                 ?>
                </select>
                 <?php
                       /// Desativando
                       if( isset($result) ) unset($result); 
                  ?>   
             </span>         
         <!--  Final do Bloco de entrada do PA -->
      </div>
       
       
      <div class="div_nova" >
            <!--  Usuario para conectar -->
            <span>
            <label for="email_participante" style="float: left; height: auto; padding-top: .2em;" >Usu&aacute;rio (Login) Email:&nbsp;</label>       
            </span>
            <!-- STYLE/CSS dentro do arquivo participante_cadastrar_js.php - atualizado em 20181203 -->
            <span id="email_participante"  style="display: none;" ></span>            
                 <input type="hidden" name="e_mail" id="e_mail"  value="" required="required"  />
                 <input type="hidden" name="datacad" id="datacad" value="<?php echo $_SESSION['datacad'];?>"  />
                 <input type="hidden" name="datavalido" id="datavalido" value="<?php echo $_SESSION['datavalido'];?>"  />
            <!-- Final - Usuario -->
       </div>
       
       
      <div class="div_nova" >
           <table border="0" id="tab_senha" cellpadding="0" cellspacing="0" style="width: 100%; display: none;" >
     <tr style="border: none;" >
       <!--  Verificando a Senha  -->
       <td>&nbsp;</td>
       <td>
         <div id="div_forca_senha" name="div_forca_senha" style="width: 326px; height: auto;">&nbsp;</div>
       </td>
     </tr>

          
     <tr class="td_inicio2" > 
        <!-- Incluir senha e redigitar_senha  --> 
        <td class="td_inicio1" >
           <label for="senha" style="cursor: pointer;"  >Senha:&nbsp;</label>
        </td>
        <td class="td_inicio1"  style="text-align: left;"  >
           <input  type="password" class="required password" name="senha" id="senha" title="Digitar Senha (8 a 10 caracteres)" size="25" maxlength="12"  onKeyUp="this.value=trim(this.value);  verificaForca(this);"  onblur="javascript: alinhar_texto(this.id,this.value);  exoc('label_msg_erro',0,'');"  autocomplete="off"   >       
             <span class="example">(8 a 10 caracteres)</span>
               <span style="padding-left: 15px;" >
                   <input  type="button"  id="gerar_senha"   onclick="javascript: enviar_dados_cad('GERAR_SENHA');"  title='Clicar'  style="cursor: pointer; width: 110px;"  value="Gerar senha" 
                                    class="botao3d"   >
            </span>
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
    </table>
  </div>   
 
 </div>
 <!-- Final - div - ate antes do Limpar e Enviar -->

          <!--  TAGS  type reset e  submit  -->                                              
          <div class="reset_button" >
                <!-- Limpar campos -->        
                  <span>          
                   <button  type="button"  name="limpar" id="limpar"  class="botao3d"    
                     onclick="javascript: enviar_dados_cad('reset','<?php echo $pagina_local;?>'); return false;"  
                       title="Limpar"  acesskey="L"  alt="Limpar" >    
               Limpar&nbsp;<img src="../imagens/limpar.gif" alt="Limpar"  >
                      </button>
                  </span> 
                  <!-- Final - Limpar  -->
                  <!-- Enviar -->                  
                  <span>
                     <button  type="submit"  name="enviar" id="enviar" class="botao3d"  
                      title="Enviar"  acesskey="E"  alt="Enviar"     >    
               Enviar&nbsp;<img src="../imagens/enviar.gif" alt="Enviar"  >
                      </button>
                  </span>
                  <!-- Final -Enviar -->
          </div>
          <!--  FINAL - TAGS  type reset e  submit  -->
        
</form>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
<!-- Final  div_form -->
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
