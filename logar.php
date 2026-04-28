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
//
//
/**  CONEXAO/MYSQLI  */
$conex = $_SESSION["conex"];
//
/***
*    Caso NAO houve ERRO  
***/
if( intval($n_erro)<1 )  {
    //
    //   CONECTANDO
    include("{$_SESSION["incluir_arq"]}inicia_conexao.php");
    //
    //  HOST mais a pasta principal do site - host_pasta
    if( ! isset($_SESSION["host_pasta"]) ) {
         $msg_erro .= utf8_decode("Sessão host_pasta não está ativa.").$msg_final;  
         echo $msg_erro;
         exit();
    }  
    /**  Final - if( ! isset($_SESSION["host_pasta"]) ) {   */
    $host_pasta=trim($_SESSION["host_pasta"]);
    if( strlen($host_pasta)<1 ) $n_erro=2;
    //
    /**
    *    Caso NAO houve ERRO  
    */
    if( intval($n_erro)<1 ) {
        //
        //  DEFININDO A PASTA PRINCIPAL 
        //  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
        //  Verificando SESSION  pasta_raiz
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
            //
            $array_pa = $_SESSION["array_pa"];   
            //  Permissao do anotador    
            $permit_anotador = $array_pa['anotador'];
            ///  Permissao do orientador
            $permit_orientador = $array_pa['orientador'];
            //
        }
        //
        //  Verifica desktop ou aparelho movel - retorna estilo css
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
///   Definindo a Raiz do Projeto
///  $_SESSION["pasta_raiz"]='/rexp/';
///  $_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
///  $_SESSION["url_central"] = $_SESSION["http_host"];
$php_errormsg='';
/*** 
     Alterado em 20180511
***/
///   Caminho da pagina local
$pagina_local=$_SESSION["protocolo"]."://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]= utf8_decode("Registro de Anotação") ;
///
/// $_SESSION['time_exec']=180000;
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
<meta charset="UTF-8" />
<meta name="author" content="SPFB&LAFB" />
<meta http-equiv="Cache-Control"  content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA"  content="NO-CACHE">
<meta name="ROBOTS"  content="NONE"> 
<!--  <meta HTTP-EQUIV="Expires" CONTENT="-1" >  -->
<!--  <meta HTTP-EQUIV="Expires" CONTENT="0" >  -->
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Alterar usu&aacute;rio</title>
<link rel="shortcut icon"  href="<?php echo $host_pasta;?>imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no" />  
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!-- <script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script> -->
<?php
//
$_SESSION['n_upload']="ativando";
//
//  $_SESSION["http_host"]= $_SESSION['url_folder'];

///  Para mudar de pagina no MENU
///  include("{$_SESSION["incluir_arq"]}includes/dochange.php");
include("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>          
</head>
<body  id="logar_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"      >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho  -->
<div id="cabecalho" style="z-index:2;" >
<?php  
//
 //  include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");
 require("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");
 //
 ?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
/**  
 *     MENU HORIZONTAL
 */
//  include("includes/menu_horizontal.php");
require_once("includes/menu_horizontal.php");
//
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
     <div class="titulo_usp"  style="margin: 1em 0 .2em 0; text-align: center; font-size: medium;" >LOGANDO COMO:</div>
   </article>
    <article>
     <div  class="titulo_usp" align="center"  style="padding: 2px 0 2px 0;  font-size: medium;" >
     <?php
       //
       //  Conectando
      $elemento=5; $elemento2=6;
      require_once("php_include/ajax/includes/conectar.php");
      $array_pa=$_SESSION["array_pa"];
      /**  Exemplo do resultado  do  Permissao de Acesso - $array_pa
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
     //
    $usuario_conectado = $_SESSION["usuario_conectado"];
    $cmdsql="SELECT a.pa FROM $bd_2.participante a, $bd_1.pessoa b "
             ." WHERE (a.codigousp=b.codigousp ) and a.codigousp=\"$usuario_conectado\" ";
    $cmdsql.=" order by a.pa  ";         
    //   
    $resultado_pa=$conex->query($cmdsql);
    if( ! $resultado_pa  ) {
        $msg_erro .= "SELECT participante/pessoa: ".mysqli_error($_SESSION["conex"]).$msg_final;
        echo $msg_erro;
        exit();  
    }
    //  Nr. de registros
    $regs = mysqli_num_rows($resultado_pa);
    //
    //  Verificando o nr. de registros    
    if( intval($regs)>1 ) {
         //
         //  $num_pas = count($array_usuarios);         
         $num_pas= (int) count($array_pa); 
        //
      ?>
        <table width="100%" border="1" cellspacing="2" cellpadding="1" height="100%" style="margin-top: 2px; vertical-align: top; border: 2px double #000000; ">
        <tr align="center" style="margin-top: 2px; vertical-align: top; text-align: center; " >
         <td>
        <span  class="td_inicio1" style="background-color: #FFFFFF; color: #000000; border: none;"  >Selecione para logar como:&nbsp;&nbsp;
        <select name="permit_pa"  id="permit_pa"  class="td_select"  onchange="javascript:  dochange('pa_selecionado',this.value);"  title="Selecionar Privil&eacute;gio de Acesso (PA)"  >            
        <option value="" >Selecione</option>
        <?php
          //
          // 1. Mudamos para mysqli_fetch_assoc para acessar as colunas pelo nome
          while( $linha = mysqli_fetch_assoc($resultado_pa)) {
               //
               $codigo_pa = (int) $linha["pa"];
               //
               foreach ($array_pa as $chave => $valor) {
                    //
                    $valor_int = (int) $valor;
                    //
                    // 2. Comparação direta (usando === para boa prática no PHP 8)
                    if( $valor_int === $codigo_pa) {
                    $campo_nome = ucfirst($chave);
                    //
                    // 3. No PHP 8.3 e com banco em UTF8, a detecção manual de encoding é desnecessária.
                    // Usamos htmlspecialchars para proteger o HTML de caracteres especiais.
                    $nome_seguro = htmlspecialchars($campo_nome, ENT_QUOTES, 'UTF-8');
                    //
                    // 4. Saída formatada com aspas duplas para facilitar a leitura
                    echo "<option value=\"{$valor_int}\" title=\"Clicar\">";
                    echo "{$nome_seguro}&nbsp;</option>";
                    }
               }
               //
          }
          /**  Final - while( $linha = mysqli_fetch_assoc($resultado_pa)) { */
          //
        ?>
        </select>
        </span>
        </td>
        </tr>
        </table>
        <?php
           //
           // Desativando variavel 
           if( isset($resultado_pa) ) {
              unset($resultado_pa);
           } 
           //   
          //     
    } else if( intval($regs)==1 ) {
         //
         /**  Caso o total seja zero sair com exit()   */
         ///  include("php_include/ajax/includes/sair.php");        
         $permit_pa=mysql_result($resultado_pa,0,"pa"); 
         # Aqui está o segredo
         /**   IMPORTANTE: para evitar problemas de acentuacao   */ 
          mysqli_set_charset($_SESSION["conex"], "utf8mb4");
          //
          //
          $cmdsql="SELECT a.descricao,b.nome FROM rexp.pa a, pessoal.pessoa b  ";
          $cmdsql.=" WHERE a.codigo=$permit_pa and b.codigousp=\"$usuario_conectado\"  ";
          ///   
          $res_pa_descr=$conex->query($cmdsql);
          if( ! $res_pa_descr  ) {
               die('ERRO: SELECT pa/permissao de acesso '.mysqli_error($_SESSION["conex"]));
               exit();  
           }
           // Nr. de Registros
           $regs = mysqli_num_rows($res_pa_descr);
           //
           $descricao_pa = mysqli_result($res_pa_descr,0,"descricao"); 
           $nome_do_usuario = mysqli_result($res_pa_descr,0,"nome"); 
           //
           // Tabela abaixo do arquivo logar.php  - (Chefe, Orientador, Anotador e etc...)
           //
         ?>
          <table width="100%" border="1" cellspacing="2" cellpadding="1" height="100%">
             <tr>
               <td class="titulo_usp" align="center" style="width: 100%; font-size: 30px;" ><?php echo $descricao_pa;?></td>
             </tr>
             <tr>
                <td class="titulo_usp" align="center" style="width: 100%; font-size: 24px; overflow: auto;" ><?php echo  $nome_do_usuario;?></td>
             </tr>
           </table>
          <?php                        
            //
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
<?php require_once("includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
