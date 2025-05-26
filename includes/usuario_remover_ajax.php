<?php
//  AJAX da opcao REMOVER USUARIO
#
ob_start(); /* Evitando warning */
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
// set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

//  header("content-type: application/x-javascript; charset=tis-620");
//  header("content-type: application/x-javascript; charset=iso-8859-1");
header("Content-Type: text/html; charset=ISO-8859-1",true);
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
//
//   Para acertar a acentuacao - Erro
// $_POST = array_map(utf8_decode, $_POST);
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; text-align: center;' >";

$msg_final="</span></span>";

//  Conjunto de arrays 
include_once("array_menu.php");
// Conjunto de Functions
include("../script/stringparabusca.php");        

$_SESSION["showmodal"]="acessado";
/*  EVITAR ESSA FORMA DE USO:
     @require_once('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
     include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
*/
//  FORMA ADEQUADA:
$elemento=5; $elemento2=6;
//  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
require_once("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
include('/var/www/cgi-bin/php_include/ajax/includes/verificando.php');

if( $_SESSION["total"]==1 ) $tudo_certo="OK";
$contador = count($post_array);
$n_arrays=0;
//
for( $i=0; $i< $contador; $i++ ) {
    $xyz = $post_array[$i];
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
    if ( isset($_POST[$xyz]) ) {
        if( $xyz=="m_array"  )  {
            $pos0 = stripos(trim($_POST[$xyz]),'#@=');
            $pos0 = (int) $pos0;
            if( $pos0>-1  ) {
                $div_array_por = "#@=";
            } else  $div_array_por = "#" ;  
        } else {
            $div_array_por = ",";
        }
        $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
       if ( $pos1===false ) {
           //  $$xyz=trim($_POST[$xyz]);
           //   Para acertar a acentuacao - utf8_encode
           $$xyz = utf8_decode(trim($_POST[$xyz])); 
       } else  {
           $$xyz = explode($div_array_por,$_POST[$xyz]);
       }
    }
}
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=$source;     
$opcao_maiusc = strtoupper(trim($source)); 

if( $opcao_maiusc=="SAIR"  ||  $tudo_certo!=="OK"  ) {
    // Eliminar todas as variaveis de sessions
    $_SESSION = array();

    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($senha_down) )  unset($senha_down); 
    //
    response.setHeader("Pragma", "no-cache"); 
    response.setHeader("Cache-Control", "no-cache"); 
    response.setDateHeader("Expires",0); 
    //  echo  "http://www-gen.fmrp.usp.br/";
    exit();
    #
}

if( $opcao_maiusc=="USUARIO" ) {
    //  Essa PARTE vem do arquivo  -  myArguments_remover_usuario.php
    //  Selecionado usuario (dados) 
    $sqlcmd = "SELECT b.nome,b.e_mail,b.categoria "
            ."  FROM $bd_1.usuario a, $bd_1.pessoa b "
            ."  WHERE a.codigousp=b.codigousp and a.codigousp=".$val;
    $result_usuario = mysql_query($sqlcmd);
    if( ! $result_usuario ) {
          $msg_erro .= "Consultando Usu&aacute;rio das tabelas usuario e pessoa. Falha db/mysql: ".mysql_error().$msg_final;  
          echo $msg_erro;
          exit();            
    }
    $array_nome=mysql_fetch_array($result_usuario);
    foreach(  $array_nome as $key => $value ) {
         $$key=$value;
    }
    //  Passando as variaveis para SESSION
    $_SESSION["usuario_selecionado_rm"]=$val; 
    //   Formulario da Anotacao para Excluir
    $msg_ok .= "<table align='center' >";
    $msg_ok .= "<tr><td>Excluir esse Usu&aacute;rio/Participante?</td></tr>";
    $msg_ok .= "</table>".$msg_final;
    echo  $msg_ok;
    $_SESSION["cols"]=4; $td1_width="35";  $tr_heigth="30px";
    ?>
    <table class="table_inicio" border="0"  cols="<?php echo $_SESSION["cols"];?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; "  >
     <tr style="text-align: left; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
      <td class="td_inicio3"  width="<?php echo $td1_width;?>"  style="text-align: right; font-size: small; vertical-align: middle;" colspan="1"  >
      <label title="Usuario"   >Usu&aacute;rio:&nbsp;</label>
      </td>
      <td class="td_inicio3"  style="text-align: left;  background-color: #FFFFFF;" colspan="<?php echo $_SESSION['cols']-1;?>"  >
        <!-- N. Funcional USP/Matricula - Autor/ANOTADOR -->
        <?php 
           //  Nome do Usuario
           echo "<span style='color: #000000; font-size: small;' >$nome</span>";           
       ?>  
       <input type="hidden" name="usuario" id="usuario"  value="<?php echo $_SESSION["usuario_selecionado_rm"];?>" />
   </td>
   </tr>

   <tr style="text-align: left; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
      <td class="td_inicio3"  width="<?php echo $td1_width;?>"  style="text-align: right; font-size: small; vertical-align: middle;" colspan="1"  >
      <label title="E_MAIL"   >E_Mail:&nbsp;</label>
      </td>
      <td class="td_inicio3"  style="text-align: left;  background-color: #FFFFFF;" colspan="<?php echo $_SESSION['cols']-1;?>"  >
        <!-- E_MAIL/Usuario -->
        <?php 
           //  Nome do Usuario
           echo "<span style='color: #000000; font-size: small;' >$e_mail</span>";           
       ?>  
       <input type="hidden" name="e_mail" id="e_mail"  value="<?php echo $e_mail;?>" />
   </td>
   </tr>

    
          <!--  TAGS  type submit - opcoes:  excluir e cancelar  --> 
           <tr align="center" style="border: 2px solid #000000; vertical-align:top;  line-height:0px;" >
             <td colspan="<?php echo $_SESSION["cols"];?>" align="CENTER" nowrap style=" padding: 1px; text-align:center; border: none; line-height:0px;">
              <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; line-height: 0px; margin:0px; border: none; vertical-align: top; " >
                <tr style="border: none;">
                  <!-- Excluir -->                  
                <td  align="CENTER" nowrap style="text-align:center; border:none;" >
               <button name="excluir" id="excluir"  type="submit" onclick="javascript: Init('anotacao','Excluir');"  class="botao3d" style="cursor: pointer; "  title="Excluir"  acesskey="E"  alt="Excluir"     >    
      Excluir <img src="../imagens/limpar.gif" alt="Excluir" style="vertical-align:text-bottom;" >
       </button>
        <!-- Final - Excluir -->
                  </td>
                  <!-- Cancelar -->                  
               <td  align="center"  style="text-align: center; border:none; ">
               <button name="cancelar" id="cancelar"   type="submit"  class="botao3d" onclick="javascript: limpar_form('cancelar');"  style="cursor: pointer; "  title="Cancelar"  acesskey="C"  alt="Cancelar"     >    
      Cancelar&nbsp;<img src="../imagens/enviar.gif" alt="Cancelar"  style="vertical-align:text-bottom;"  >
   </button>
              </td>
              <!-- Final - Cancelar -->
               </tr>
              <!--  FINAL - TAGS  type reset e  submit  -->
              </table>
             </td>
          </tr>
        </table>
      <?php
         
    exit();  
}  //  Final  do  IF ANOTACAO -  escolhido a anotacao para remover
//  Excluir USUARIO escolhido
if( $opcao_maiusc=="EXCLUIR" and  strtoupper(trim($val))=="USUARIO" ) {
    
   $m_usuario=$val; unset($projeto);
   $sqlcmd = "SELECT cip,numprojeto,autor FROM $bd_2.projeto  "
             ." WHERE autor=$m_usuario ";
   //          
    $result_usuario_rm = mysql_query($sqlcmd);
    if( ! $result_usuario_rm ) {
        $msg_erro .="Falha consultando a tabela anota&ccedil;&atilde;o  - ".mysql_error().$msg_final;
        echo   $msg_erro;
        exit();
    }       
    $n_regs=mysql_num_rows($result_usuario_rm);
    $n_campos = mysql_num_fields($result_usuario_rm);
    if( $n_regs>=1 ) {
        for( $x=0; $x<$n_regs; $x++ ) {
            for( $y=0; $y<$n_campos; $y++ ) {
                $nome= mysql_field_name($result_usuario_rm,$y);    
                $projeto[$nome][$x]=mysql_result($result_usuario_rm,$x,$y);
            }
        }
    }
    //  Array  projeto TEM  cip,numprojeto,autor 
    
   
   
/*   if( isset($projeto) ) {
        //  Start a transaction - ex. procedure    
          mysql_query('DELIMITER &&'); 
          mysql_query('begin'); 
          //  Execute the queries          
          //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
          mysql_query("LOCK TABLES  $bd_2.anotacao DELETE, $bd_2.anotador DELETE,  $bd_2.corespproj DELETE,  $bd_2.participante DELETE ");
             //  DELETE   
          $res_usuario="DELETE from $bd_2.anotacao  WHERE autor=$m_usuario  ";
           $sqlcmd =  mysql_query($res_usuario);
           if( $sqlcmd ) {  // Tabela anotacao
               $res_pessoa="DELETE  from  $bd_2.anotador  WHERE codigo=$m_usuario "; 
               $sqlcmd =mysql_query($res_pessoa);      
               if( $sqlcmd ) { // Tabela anotador
                   $res_pessoa="DELETE  from  $bd_2.corespproj  WHERE projetoautor=$m_usuario "; 
                   $sqlcmd =mysql_query($res_pessoa);      
                   if( $sqlcmd ) {  // Tabela corespproj
                       $res_pessoa="DELETE  from  $bd_2.participante  WHERE codigousp=$m_usuario "; 
                       $sqlcmd =mysql_query($res_pessoa);      
                       if( $sqlcmd ) {  // Tabela participante
                           $res_pessoa="DELETE  from  $bd_2.projeto  WHERE autor=$m_usuario "; 
                           $sqlcmd =mysql_query($res_pessoa);      
                           if( $sqlcmd ) {  // Tabela projeto
                                mysql_query('commit'); 
                                $lnerro=0;
                           } else {
                               $msg_erro .="&nbsp;Falha Tabela projeto delete - ".mysql_error().$msg_final;
                               $lnerro=1;                                                      
                           }     
                       } else {
                            $msg_erro .="&nbsp;Falha Tabela corespproj delete - ".mysql_error().$msg_final;
                            $lnerro=1;                       
                       }
                   } else {
                        $msg_erro .="&nbsp;Falha Tabela corespproj delete - ".mysql_error().$msg_final;
                        $lnerro=1;                          
                   }        
               } else { 
                    //  mysql_error() - para saber o tipo do erro
                    $msg_erro .="&nbsp;Falha Tabela anotador delete - ".mysql_error().$msg_final;
                    $lnerro=1;
               }                
           } else { 
              //  mysql_error() - para saber o tipo do erro
              $msg_erro .="&nbsp;Falha Tabela anotacao delete - ".mysql_error().$msg_final;             
              $lnerro=1;        
           }       
           if( $lnerro==1 ) mysql_query('rollback'); 
           mysql_query("UNLOCK  TABLES");
           //  Complete the transaction 
           mysql_query('end'); 
           mysql_query('DELIMITER');         
           if( $lnerro==1 ) {
              echo $msg_erro; 
              exit();               
           }
    }  // FINAL do IF ISSET projeto
 */
    $array_nome=mysql_fetch_array($result_usuario_rm);
    foreach(  $array_nome as $key => $value ) {
         $$key=$value;
    }
    
    
    
    
    
     //  Essa PARTE vem do arquivo  -  myArguments_remover.php
     $m_projeto=$_SESSION["projeto"]; $m_anotacao = $_SESSION["anotacao"]; 
     $anotador = $_SESSION["anotador_codigousp"];
     //  Arquivo da Anotacao do Projeto - escolhido para excluir
     $arquivado_como = trim($_SESSION["arquivado_como"]);
     // $dir ? O DIRETORIO ONDE IR? LISTAR 
     //   onde   A: Autor do Projeot  -  variavel val = anotacao
     $m_autor_projeto=$_SESSION["autor_projeto"];
     $dir= '../doctos_img/A'.$m_autor_projeto."/$val";
     $remover_arq = $dir."/".$arquivado_como;
     $dh  = opendir($dir);
     $exempt = array('.','..'); $conta_arq=0;
     while( false !== ($filename = readdir($dh))) {
        if( in_array(strtolower($filename),$exempt) ) continue;
        $filename_maiusc = strtoupper(trim($filename));
        $conta_arq++;
        if( ( substr($filename_maiusc,-3,3)=="PDF") && ( $filename_maiusc==strtoupper(trim($arquivado_como)) ) ) {
             unlink(trim($remover_arq)); $conta_arq--;             
        }           
     }
     //  Caso NAO tenha mais arquivos na Pasta remove-la tambem
     if( $conta_arq<1 ) {
         if( is_dir($dir) ) { 
            rmdir($dir); 
         } else echo $dir.' does not exists'; 
     }
     //
     $delcmd = mysql_query("DELETE FROM $bd_2.anotacao "
                    ." WHERE autor=$anotador and "
                    ."   projeto=$m_projeto  and  numero=$m_anotacao ");
     if( ! $delcmd ) {
         mysql_free_result($delcmd);
         $msg_erro .="Falha removendo uma anota&ccedil;&atilde;o da Tabela anotacao - db/mysql: ".mysql_error().$msg_final;  
         echo $msg_erro;
         exit();                
     }     
} //  FInal depois EXCLUIR a anotacao
#
ob_end_flush(); /* limpar o buffer */
#  
?>
