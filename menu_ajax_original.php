<?php
///
/*  Exemplo do resultado  do  Permissao de Acesso - criando array
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
///  session_start();
ob_start(); /* Evitando warning */
///  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
#
/// set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

///  header("content-type: application/x-javascript; charset=tis-620");
header("content-type: application/x-javascript; charset=iso-8859-1");
header("Content-Type: text/html; charset=ISO-8859-1",true);
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
///
// extract: Importa variáveis para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
///
//// Mensagens para enviar
$msg_erro ="<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_erro .="ERRO: <span style='color: #FF0000; text-align: center;' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar
///
///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
///
////  Conjunto de arrays 
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    

/// Conjunto de Functions
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");  
///
$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) {
	    $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
	   if( $pos1 === false ) {
	       ///  $$xyz=trim($_POST[$xyz]);
		   ///   Para acertar a acentuacao - utf8_encode
           $$xyz = utf8_decode(trim($_POST[$xyz])); 
	   } else {
           $$xyz = explode($div_array_por,$_POST[$xyz]);  
       } 
	}
}
///
//   Para acertar a acentuacao - utf8_encode
//  $source = utf8_decode($source); $val = utf8_decode($val);

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source);
$_SESSION["showmodal"]="";
$source_maiusc = strtoupper($_SESSION["source"]);
///
////
$php_errormsg='';
/*** 
     Alterado em 20171020
***/
///  Verificando caminho http e pasta principal
if( isset($_SESSION["url_central"]) ) {
     $http_host = $url_central = @trim($_SESSION["url_central"]);     
} else {
    echo "<p style='background-color: #000000;color:#FFFFFF;font-size:large;'>ERRO: grave falha na session url_central. Contato com Administrador.</p>";
    exit();
}
///
if( ! empty($php_errormsg) ) {
    $http_host="../";
}
///
///  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
if( strtoupper($source)=="SAIR" ) {
    //  Verificando se sseion_start - ativado ou desativado
    if(!isset($_SESSION)) {
         session_start();
    }
    /// Eliminar todas as variaveis de sessions
    $_SESSION = array();

    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($login_down) ) unset($login_down);     
    if( isset($senha_down) )  unset($senha_down); 
    //
	//  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
    response.setHeader("Pragma", "no-cache"); 
    response.setHeader("Cache-Control", "no-cache"); 
    response.setDateHeader("Expires", 0 ); 

    //	echo  'http://www-gen.fmrp.usp.br/';
	#
	exit();
	#
} 
///
if( $source_maiusc=="LOGAR" ) {
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
}    
///   Depois que foi Selecionado o PA do IF LOGAR  - acima
if( $source_maiusc=="PA_SELECIONADO" ) {
     ///  header("Location: menu.php");
     $_SESSION["permit_pa"] = (int) $val;
     if( isset($_SESSION["url_central"]) )  echo $_SESSION["url_central"];
     exit();
}    
///
$menu_opcoes = array("cadastrar","consultar"); 
///  if( strtoupper($source)=="CADASTRAR" ) {
if( in_array(strtolower($source),$menu_opcoes) ) {
    $diretorio=strtolower($source);
   if( strtoupper($val)=="PROJETO" ) {
  	   $_SESSION["n_upload"]="ativando";
       //  include("cadastrar/projeto_cadastrar.php");
	   //  echo "cadastrar/projeto_cadastrar.php";
	   echo  "$diretorio/projeto_$diretorio.php";
       exit();  
   } if( strtoupper($val)=="EXPERIMENTO" ) {
  	   $_SESSION["n_upload"]="ativando";
   	   echo  "$diretorio/experimento_$diretorio.php";
       exit();  
   }	      
} 
// if ( $array_menu[$source]=="Home") {
if ( $source_maiusc=="NOME") {
     $parte="Home";
	// $tabela = include_once("includes/tabela1.php");    Nao deu certo aparece o numero 1
	 header("Location: includes/home.php");
     ///
} elseif( $source=="Quem Somos" ) {
     $parte="Quem Somos";
     @require_once("includes/quem_somos.php");
	  ///
} elseif( $source_maiusc=="CONSULTORIA" ) {
     $parte="Consultoria";
	 $msg_ok = "<p style='text-align: center; font-size: 100%; font-family: Verdana, Arial, Times; font-weight: bold;'>"
            ." \$source = $source - \$source[0] = ".$source[0]."   ---  \$val = $val  -  \$val[0] = ".$val[0]."<br>";
	 $msg_ok .= " \$parte = $parte </p>";
	 $_SESSION["msg_ok"] = $msg_ok;
 	 ///  header("Location: includes/tabela1.php/");
	 include("includes/tabela1.php");
	 ///
} elseif( in_array($source,$pessoal_array) ) {	 
	  if( $source==$pessoal_array[1] ) $_POST["a_cod"]=1;
      include("gen_bl_c/consulta.php");
	 /// 
}
///   Dados do menu vertical - Menu_Vertical
if( $source=="menu_vertical" ) {
    ///  Verifica se esta no array - 
    if( in_array($val,$$m_array) ) {
       if( strtoupper(trim($val))=="HOME" ) {
	        $parte="Home";
	        header("Location: includes/home.php");
	   }
    }
}
#
ob_end_flush(); /* limpar o buffer */
#
?>