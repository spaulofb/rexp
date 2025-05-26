<?php
//
#
ob_start(); /* Evitando warning */
#
session_start();
#
// set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

//  header("content-type: application/x-javascript; charset=tis-620");
header("content-type: application/x-javascript; charset=iso-8859-1");
header("Content-Type: text/html; charset=ISO-8859-1",true);
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
//
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
/// Mensagens para enviar 
$msg_erro = "<span class='texto_normal' style='color: #FF0000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #000000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
/// Final - Mensagens para enviar 

///
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
///
////  Conjunto de arrays 
include_once("{$incluir_arq}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    
///

$post_array = array("data","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if ( isset($_POST[$xyz]) ) {
	    $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
	    if( $pos1===false ) {
	        ///  $$xyz=trim($_POST[$xyz]);
		    ///   Para acertar a acentuacao - utf8_encode
            $$xyz = utf8_decode(trim($_POST[$xyz])); 
	    } else  $$xyz = explode($div_array_por,$_POST[$xyz]);
	}
}
//
//   Para acertar a acentuacao - utf8_encode
//   $data = utf8_decode($data); $val = utf8_decode($val); 


////  Serve tanto para o arquivo projeto  quanto para o experimento
if( isset($data) )  $data_upper=strtoupper(trim($data));

////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
if( ( $data_upper=="COAUTORES" ) or  ( $data_upper=="COLABS" ) ) {	
    ///
    $m_co="Co-autor";
    if( strtoupper(trim($data))=="COLABS" ) $m_co="Colaboradores";
    ///  Cod/Num_USP/Coautor
    $elemento=5;
    /*   Atrapalha e muito essa programacao orientada a objeto
        include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
       $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ");
   */
    ///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    include("php_include/ajax/includes/conectar.php");
    $result = mysql_query("select codigousp,nome,categoria from pessoa  order by nome ");
    /// Verificar erro
    if( ! $result ) {
          ///  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
          /*   $msg_erro .= "Selecionando o Projeto para ser removido - db/mysql: ".mysql_error().$msg_final;  
           echo $msg_erro;  */
          echo $funcoes->mostra_msg_erro("Selecionando pessoa&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());
          exit();                   
    }
    ///  Numero de Coautores
    $m_linhas = mysql_num_rows($result);
    if( intval($m_linhas)<1 ) {
         /// 
        echo $funcoes->mostra_msg_erro("Nenhum Coautor encontrado");
        exit();      
    }
    ///   $array_rows = mysql_fetch_array($result);
    ///  $array_linhas = count($array_rows);
    ///  $array_rows = mysql_fetch_assoc($result);
    ///  for ( $jk=0 ; $jk<$m_linhas ; $jk++) {
    while($linha=mysql_fetch_assoc($result)) {
          $arr["codigousp"][]=htmlentities($linha['codigousp']);
          $arr["nome"][]=  ucfirst(htmlentities($linha['nome']));
          $arr["categoria"][]=$linha['categoria'];
    }
    $count_arr = count($arr["codigousp"])-1;
   ?>
  <table class="table_inicio"  align="center" width="100"  cellpadding="2" border="2" cellspacing="2" style="font-weight:normal; text-align: center; background-color: #FFFFFF; "  >      
     <?php 
      /*
          $x_float2 = (float) (.5);  $acrescentou=0;
          $n_tr = (float) ($val/2);
          if(  ! is_int($n_tr) ) {
              $n_tr=$n_tr+$x_float2;
              $acrescentou=1;
          }
        */
          $n_y=0;$texto=0; $n_tr= (int) $val;
          for( $x=1; $x<=$n_tr; $x++ ) {
               $n_y=$texto;
               echo "<tr>";
               $n_td=2;
               $n_tot=$n_td/2;
               for( $y=1; $y<=$n_tot ; $y++ ) {
                   $texto=$n_y+$y;
                   if( ( $acrescentou==1 ) and  ( $texto>$val ) ) {
                         echo "<td class='td_inicio1' >&nbsp;</td>";    
                         echo "<td class='td_inicio1' >&nbsp;</td>"; 
                         continue;
                   } else  {
                         echo  "<td class='td_inicio1' style='color: #000000; background-color: #FFFFFF;' >"
                                 ."&nbsp;$m_co $texto:</td>";
                   }
                   $n_tot2=1;
                   for( $z=1; $z<=$n_tot2 ; $z++ ) {
                        ?>
                        <td class="td_inicio1" style="text-align: left;color: #000000; background-color: #FFFFFF;" >
                        <!-- N. Funcional USP - COautor ou Colaborador  -->
                       <select name="ncoautor[<?php echo $texto;?>]" id="ncoautor[<?php echo $texto;?>]" class="td_select"    style="overflow:auto;font-size: small;"  >  
                       <?php
                     if( intval($m_linhas)<1 ) {
                            echo "<option value='' >== Nenhum encontrado ==</option>";
                      } else {
                      echo "<option value='' >== Selecionar ==</option>";
                     // for ( $jk=0 ; $jk<$m_linhas ; $jk++) {
                      for( $jk=0; $jk<=$count_arr; $jk++ ) {
                           echo "<option  value=".$arr["codigousp"][$jk]." >&nbsp;";
                           echo  $arr["codigousp"][$jk]."&nbsp;-&nbsp;";
                           echo  $arr["nome"][$jk];
                           echo  "&nbsp;-&nbsp;".$arr["categoria"][$jk]."&nbsp;&nbsp;</option>" ;
                      }
                      ?>
                      </select>
                      <?php
                          mysql_free_result($result); 
                      }
                      // Final da Num_USP/Coautor
                    ?>  
                   </td>
                    <?php                      
                  } // Final do If TD  - numero USP/Coautor
               }
               echo "</tr>";
           }            
     ?>
  </table>
  <?php
     exit();
}
#
ob_end_flush(); /* limpar o buffer */
#
?>