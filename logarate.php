<?php
/*   
*   REXP - REGISTRO DE EXPERIMENTO
* 
*   MODULO: Iniciando conexao   
* 
*/
//  @require_once('inicia_conexao.php');  once = somente uma vez
//  Verificando se session_start - ativado ou desativado
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
include("{$_SESSION["incluir_arq"]}inicia_conexao.php");
////
////    MENU HORIZONTAL
include("includes/array_menu.php");
//
$_SESSION["m_horiz"] = $array_projeto;

////   Definindo a Raiz do Projeto
///  $_SESSION["pasta_raiz"]='/rexp/';
////  $_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
////  $_SESSION["url_central"] = $_SESSION["http_host"];
$php_errormsg='';
/*** 
     Alterado em 20171010
***/
if( isset($_SESSION["url_central"]) ) {
     $http_host = @trim($_SESSION["url_central"]);     
} else {
    echo "<p style='background-color: #000000;color:#FFFFFF;font-size:large;'> ERRO: grave falha na session url_central. Contato com Administrador.</p>";
    exit();
}
///
if( ! empty($php_errormsg) ) {
    $http_host="../";
}
///
////   Caminho da pagina local -- http e arquivo
////  $pagina_local="http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
$_SESSION["protocolo"] = $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$host         = $_SERVER['HTTP_HOST'];
$UrlAtual     = $protocolo . '://' . $host;
$pagina_local=$UrlAtual.$_SERVER['PHP_SELF'];
////
//  Titulo do Cabecalho - Topo
///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]="Registro de Anotação";
///
/// $_SESSION['time_exec']=180000;
?>
<!DOCTYPE html>
<html lang="pt-BR" >
<head>
<meta charset="UTF-8" />
<meta name="author" content="SPFB&LAFB" />
<meta http-equiv="Cache-Control"  content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA"  content="NO-CACHE">
<meta name="ROBOTS"  content="NONE"> 
<!--  <meta HTTP-EQUIV="Expires" CONTENT="-1" >  -->
<!--  <meta HTTP-EQUIV="Expires" CONTENT="0" >  -->
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<title>REXP - Alterar usu&aacute;rio</title>
<link rel="shortcut icon"  href="<?php echo $host_pasta;?>imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no" />  
<link  type="text/css"  href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script>
<?php
$_SESSION['n_upload']="ativando";
///  $_SESSION["http_host"]= "http://sol.fmrp.usp.br".$_SESSION["pasta_raiz"];

$_SESSION["http_host"]= $_SESSION['url_folder'];

///  Para mudar de pagina no MENU
///  include("{$_SESSION["incluir_arq"]}includes/dochange.php");
require_once("{$_SESSION["incluir_arq"]}includes/domenu.php");
//
?>
</head>
<body  id="logar_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"      >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho  -->
<div id="cabecalho" style="z-index:2;" >
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >

<!--  Mensagem de ERRO     -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Logar</p>
</section>
<!--  inicio - div div_form  -->
<div id="div_form" class="div_form" style="overflow:auto;" >
<section width="100%" border="1" cellspacing="2" cellpadding="1" height="100%" style="vertical-align: middle;" >
    <article>
     <div  class="titulo_usp" align="center"  style="padding: 2px 0 2px 0;  font-size: medium;" >LOGANDO COMO:</div>
    </article>
    <article>
     <div  class="titulo_usp" align="center"  style="padding: 2px 0 2px 0;  font-size: medium;" >
     <?php
       ///  Conectando
      $elemento=5; $elemento2=6;
      require_once("php_include/ajax/includes/conectar.php");
      $array_pa=$_SESSION["array_pa"];
      /* Exemplo do resultado  do  Permissao de Acesso - $array_pa
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
       ///
    $usuario_conectado = $_SESSION["usuario_conectado"];
    $cmdsql="SELECT a.pa FROM $bd_2.participante a, $bd_1.pessoa b "
             ." WHERE (a.codigousp=b.codigousp ) and a.codigousp=\"$usuario_conectado\" order by a.pa  ";
    ////   
    $resultado_pa=mysql_query($cmdsql);
    if( ! $resultado_pa  ) {
        $msg_erro .= "SELECT participante/pessoa: ".mysql_error().$msg_final;
        echo $msg_erro;
        exit();  
    }
    ///  Numero de registros
    $regs = mysql_num_rows($resultado_pa);
    ///  Verificando o numero de registros    
       ///  Verificando o numero de registros    
    if( intval($regs)>1 ) {
         ///  $num_pas = count($array_usuarios);         
         $num_pas= (int) count($array_pa); 
        ///
        ?>
        <table width="100%" border="1" cellspacing="2" cellpadding="1" height="100%" style="margin-top: 2px; vertical-align: top; border: 2px double #000000; ">
        <tr align="center" style="margin-top: 2px; vertical-align: top; text-align: center; " >
         <td>
        <span  class="td_inicio1" style="background-color: #FFFFFF; color: #000000; border: none;"  >Selecione para logar como:&nbsp;&nbsp;
        <select name="permit_pa"  id="permit_pa"  class="td_select"  onchange="javascript:  dochange('pa_selecionado',this.value);"  title="Selecionar Privil&eacute;gio de Acesso (PA)"  >            
        <option value="" >Selecione</option>
        <?php
         while( $linha=mysql_fetch_array($resultado_pa) ) {       
                $codigo_pa= (int) $linha["pa"];
               foreach( $array_pa as $chave => $valor )  { 
                      $campo_nome = ucfirst($chave);
                      $valor= (int) $valor;
                      if( $valor==$codigo_pa ) {
                           echo "<option  value=".$valor." title='Clicar'  >";
                           $codigo_caracter=mb_detect_encoding($campo_nome);
                           if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
                                echo  htmlentities($campo_nome)."&nbsp;</option>";
                           } else {
                                echo  $campo_nome."&nbsp;</option>" ;
                           }
                      }                
                }
         }   
        ?>
        </select>
        </span>
        </td>
        </tr>
        </table>
        <?php
          /// Desativando variavel 
         if( isset($resultado_pa) )  mysql_free_result($resultado_pa);
         ///   
         ///     
    } else if( intval($regs)==1 ) {
         /*  Caso o total seja zero sair com exit() 
             destroy qualquer session                */
         ///  include("php_include/ajax/includes/sair.php");        
         $permit_pa=mysql_result($resultado_pa,0,"pa");    
         $cmdsql="SELECT a.descricao,b.nome FROM rexp.pa a, pessoal.pessoa b  "
                ." WHERE a.codigo=$permit_pa and b.codigousp=\"$usuario_conectado\"  ";
          ///   
          $res_pa_descr=mysql_query($cmdsql);
          if( ! $res_pa_descr  ) {
               die('ERRO: SELECT pa/permissao de acesso '.mysql_error());
               exit();  
           }
           $regs = mysql_num_rows($res_pa_descr);
           $descricao_pa = mysql_result($res_pa_descr,0,"descricao"); 
           $nome_do_usuario = mysql_result($res_pa_descr,0,"nome"); 
           /// Tabela abaixo do arquivo logar.php  - (Chefe, Orientador, Anotador e etc...)
         ?>
          <table width="100%" border="1" cellspacing="2" cellpadding="1" height="100%">
             <tr>
               <td class="titulo_usp" align="center"  style="width: 100%;  font-size: 30px;" ><?php echo $descricao_pa;?></td>
             </tr>
             <tr>
                <td class="titulo_usp" align="center"  style="width: 100%; font-size: 24px; overflow: auto;" ><?php echo $nome_do_usuario;?></td>
             </tr>
           </table>
          <?php                        
    }       
    ////       
     ?>
     </div>
    </article>
</section>
</div>
<!-- Final  - div div_form  -->
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"   >
<?php include_once("includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
