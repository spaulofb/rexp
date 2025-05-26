<?php
//  AJAX da opcao CONSULTAR
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
// extract: Importa variáveis para a tabela de símbolos a partir de um array 
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

if( ! isset($val) ) $val="";
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
    //  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
    echo  "http://www-gen.fmrp.usp.br/";
    exit();
    #
}

if( $opcao_maiusc=="ANOTACAO" and strtoupper(trim($val))!="EXCLUIR"  ) {
   //  Essa PARTE vem do arquivo  -  myArguments_remover.php
   $m_projeto = $m_array[0]; $m_anotacao = $m_array[1];
   $sqlcmd = "SELECT a.numero as nr, a.alteraant as altera_nr, a.autor as anotador, "
             ."concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anot, "
             ."a.testemunha1, a.testemunha2, "
             ." a.titulo as tit_anotacao, a.relatext as arquivado_como,  "
             ." b.autor as autor_projeto, b.titulo as tit_projeto  FROM rexp.anotacao a, rexp.projeto b "
             ." Where ( a.projeto=b.cip ) and a.projeto=$m_projeto  and  a.numero=$m_anotacao ";
    //
    $result_anotacao_rm = mysql_query($sqlcmd);
    if( ! $result_anotacao_rm ) {
        mysql_free_result($result_anotacao_rm);
        $msg_erro .="Falha consultando a tabela anota&ccedil;&atilde;o  - ".mysql_error().$msg_final;
        echo   $msg_erro;
        exit();
    }       
   //  $anotador = mysql_result($result_anotacao_rm,0,"anotador");
   // $m_testemunha1 = mysql_result($result_anotacao_rm,0,"testemunha1");
   //   $m_testemunha2 = mysql_result($result_anotacao_rm,0,"testemunha2");
    //  Definindo os nomes dos campos das Tabelas selecionadas no Mysql - Select
    //      
    $array_nome=mysql_fetch_array($result_anotacao_rm);
    foreach(  $array_nome as $key => $value ) {
         $$key=$value;
    }
    //  Passando as variaveis para SESSION
    $_SESSION["autor_projeto"]=$autor_projeto; $_SESSION["projeto"]=$m_projeto; 
    $_SESSION["anotacao"]=$m_anotacao;  $_SESSION["arquivado_como"]=$arquivado_como;  
    //   Formulario da Anotacao para Excluir
    $msg_ok .= "<table align='center' >";
    $msg_ok .= "<tr><td>Excluir essa Anota&ccedil;&atilde;o desse Projeto?</td></tr>";
    $msg_ok .= "</table>".$msg_final;
    echo  $msg_ok;
    $_SESSION["cols"]=4; $td1_width="35";  $tr_heigth="26px";
    ?>
    <table class="table_inicio" border="0"  cols="<?php echo $_SESSION["cols"];?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; "  >
     <tr style="text-align: left; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
      <td class="td_inicio3"  width="<?php echo $td1_width;?>"  style="text-align: right; font-size: small; vertical-align: middle;" colspan="1"  >
      <label title="Anotador"   >Anotador:&nbsp;</label>
      </td>
      <td class="td_inicio3"  style="text-align: left;  background-color: #FFFFFF;" colspan="<?php echo $_SESSION['cols']-1;?>"  >
        <!-- N. Funcional USP/Matricula - Autor/ANOTADOR -->
        <?php 
            //  Verificando se sseion_start - ativado ou desativado
            if(!isset($_SESSION)) {
                session_start();
            }
            $elemento=5; $elemento2=6;
            include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
            $res_anotador = mysql_query("SELECT codigousp,nome,categoria FROM $bd_1.pessoa where "
            ."   codigousp=$anotador order by nome "); 
            if( ! $res_anotador ) {
                mysql_free_result($res_anotador);
                $msg_erro .="Select Tabela  pessoa - db/mysql: ".mysql_error().$msg_final;  
                echo $msg_erro;
                exit();                
            }
            //  Cod/Num_USP/Autor/Anotador
            $m_linhas = mysql_num_rows($res_anotador);
            if ( $m_linhas<1 ) {
                $autor="== Nenhum encontrado ==";
            } else {
                $_SESSION["anotador_codigousp"]=mysql_result($res_anotador,0,"codigousp");
                $anotador_nome=mysql_result($res_anotador,0,"nome");
                $anotador_categoria=mysql_result($res_anotador,0,"categoria");                    
                mysql_free_result($res_anotador); 
            }
            // Final da Num_USP/Nome Autor/Anotador
           //  Nome do Anotador do Projeto
           echo "<span style='color: #000000; font-size: small;' >$anotador_nome</span>";           
       ?>  
       <input type="hidden" name="autor" id="autor"  value="<?php echo $_SESSION["anotador_codigousp"];?>" />
   </td>
   </tr>
    
    <tr style="text-align: left;"  >
      <td  class="td_inicio1" colspan="4" style="text-align: left;  background-color: #32CD99; " >
        <span class="titulo_pequeno"  style="vertical-align: top; cursor:pointer;" title="Título do Projeto"   >
              T&iacute;tulo do Projeto:&nbsp;</span>
              <div align="justify" style="overflow: auto; width: 100%;">
                  <textarea cols="90" rows="3" disabled="disabled" style="background-color: #FFFFFF; color: #000000;" ><?php echo nl2br($tit_projeto);?></textarea>                   
              </div>                    
      </td>
   </tr>

   <tr style="text-align: left; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
     <td class="td_inicio3"  colspan="1" style="font-size: small;  text-align: right; color:#000000; " >Anota&ccedil;&atilde;o#&nbsp;</td>
     <td  class="td_inicio3" id="nr_anotacao" style="width: 34px; font-size: small; background-color:#FFFFFF; color: #000000;"  ><?php echo $nr;?></td>
     <!--  Data da Anotacao  -->
       <td class="td_inicio3" style="font-size: small; padding-left: 8px; text-align: left; background-color:#FFFFFF; color:#000000;"  >Data:&nbsp;<?php echo $data_anot;?></td>
    </tr>
     <tr>
     <td class="td_inicio1" colspan="<?php echo $_SESSION['cols'];?>" >
     <table style="text-align: left;margin: 0px; padding: 0px;" width="100%"  >
      <tr style="text-align: left;"  >
        <td  class="td_inicio1" colspan="4" style="text-align: left;  background-color: #32CD99; " >
          <span class="titulo_pequeno"  style=" vertical-align: top; cursor:pointer;"   >T&iacute;tulo da Anota&ccedil;&atilde;o:&nbsp;
          </span>
             <div align="justify" style="overflow: auto; width: 100%;">
             <textarea cols="90" rows="3" disabled="disabled" style="background-color: #FFFFFF; color: #000000;" ><?php echo nl2br($tit_anotacao);?></textarea>               
             </div>                    
       </td>
     </tr>

   </table>
    </td>
    </tr>
    
     <tr>
       <!--  Altera ou Complementa o Projeto.  Nulo ou zero, caso negativo. -->
        <td id="sn_altera_complementa"   class="td_inicio1" style="text-align: left;" colspan="<?php echo $_SESSION["cols"]/2;?>"  >
    </td>
      <td  id="td_altera_complementa" class="td_inicio1"  style="text-align:left; "  colspan="<?php echo $_SESSION["cols"]/2;?>" >
      </td>

       <!--  FINAL - Indicador de continuação do experimento -->        
          </tr>

    <tr style="text-align: left; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
    <td  class="td_inicio3"  width="<?php echo $td1_width;?>"  colspan="1"  >
      <label for="testemunha1"  style="text-align: right; font-size: small; vertical-align:bottom; cursor: pointer;"  title="Código da Testemunha (1) da realização " >Testemunha (1):&nbsp;</label>
      </td>
      <td class="td_inicio3"  style="text-align: left;  background-color: #FFFFFF;" colspan="<?php echo $_SESSION['cols']-1;?>"  >
        <!-- Código da Testemunha (1) da realização -->
        <?php 
            $elemento=5;
            include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");    
            $result2=mysql_query("SELECT codigousp,nome as testemunha1_nome,categoria FROM pessoa where codigousp=$testemunha1 order by nome ");
            //  Código da Testemunha (1) da realização 
            $testemunhas_result = $result2;
           //  include("testemunhas.php"); 
           echo "<span style='color: #000000; font-size: small;' >".mysql_result($result2,0,'testemunha1_nome')."</span>";           
            mysql_free_result($result2); 
           // FINAL - Código da Testemunha (1) da realização 
         ?>  
        </td>
        </tr>
        
    <tr style="text-align: left; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
    <td  class="td_inicio3"  width="<?php echo $td1_width;?>"  colspan="1"  >
      <label for="testemunha2"  style="text-align: right; font-size: small; vertical-align:bottom; cursor: pointer;"  title="Código da Testemunha (2) da realização "  >Testemunha (2):&nbsp;</label>
      </td>
      <td class="td_inicio3"  style="text-align: left;  background-color: #FFFFFF;" colspan="<?php echo $_SESSION['cols']-1;?>"  >
        <!-- Código da Testemunha (2) da realização -->
        <?php 
            $elemento=5;
            $result=mysql_query("SELECT codigousp,nome as testemunha2_nome,categoria FROM pessoa where codigousp=$testemunha2 order by nome ");
             //  Código da Testemunha (2) da realização 
             $testemunhas_result = $result;
             //  include("testemunhas.php"); 
             echo "<span style='color: #000000; font-size: small;' >".mysql_result($result,0,'testemunha2_nome')."</span>";           
             mysql_free_result($result); 
             // FINAL - Código da Testemunha (2) da realização 
           ?>  
         </td>
       </tr>
   <tr style="text-align: left; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
   <td class="td_inicio3" colspan="<?php echo $_SESSION['cols'];?>" >
   <table style="text-align: left;margin: 0px; padding: 0px;" width="100%" border="0"  >
    <tr style="text-align: left;  border: none; vertical-align: middle; height:<?php echo $tr_heigth;?>; "  >
    <td  class="td_inicio1"  width="<?php echo $td1_width;?>"  style="font-size: small;vertical-align: middle;"    >
      <label for="arquivo_anotacao"  style="font-weight: bold; text-align: right; cursor: pointer;"  title="Arquivo da Anotação"  >Arquivo da Anota&ccedil;&atilde;o:&nbsp;</label>
      </td>
      <td class="td_inicio3"  style="text-align: left; font-size: small; background-color: #FFFFFF;"  >
        <!-- Arquivo da Anotacao -->
         <span style='background-color: #FFFFFF; color: #000000; font-weight: bold; ' ><?php  echo  $arquivado_como;?></span>           
         </td>
       </tr>
     </table>
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
//  Excluir a ANOTACAO escolhida
if( $opcao_maiusc=="EXCLUIR" and  strtoupper(trim($val))=="ANOTACAO" ) {
// if( $opcao_maiusc=="ANOTACAO" and strtoupper(trim($val))=="EXCLUIR"  ) {
     //  Essa PARTE vem do arquivo  -  myArguments_remover.php
     $m_projeto=$_SESSION["projeto"]; $m_anotacao = $_SESSION["anotacao"]; 
     $anotador = $_SESSION["anotador_codigousp"];
     //  Arquivo da Anotacao do Projeto - escolhido para excluir
     $arquivado_como = trim($_SESSION["arquivado_como"]);
     // $dir É O DIRETORIO ONDE IRÁ LISTAR 
     //   onde   A: Autor do Projeot  -  variavel val = anotacao
     $m_autor_projeto=$_SESSION["autor_projeto"];
     $dir= '../doctos_img/A'.$m_autor_projeto."/$val";
     $remover_arq = $dir."/".$arquivado_como;
     $dh  = opendir($dir);
     $exempt = array('.','..'); $conta_arq=0;
     //  Removendo o arquivo PDF
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
         } else echo $dir.' n&atilde;o existe'; 
     }
     //  FINAL removendo o arquivo PDF
     //  Removendo o registro da anotacao
     $delcmd = mysql_query("DELETE FROM $bd_2.anotacao  WHERE autor=$anotador and "
                    ."   projeto=$m_projeto  and  numero=$m_anotacao ");
     if( ! $delcmd ) {
         mysql_free_result($delcmd);
         $msg_erro .="Falha removendo uma anota&ccedil;&atilde;o da Tabela anotacao - db/mysql: ".mysql_error().$msg_final;  
         echo $msg_erro;
         exit();                
     }
   exit();       
} //  FInal depois EXCLUIR a anotacao
#
ob_end_flush(); /* limpar o buffer */
#  
?>
