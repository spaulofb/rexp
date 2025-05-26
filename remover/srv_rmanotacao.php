<?php
//  AJAX da opcao Remover  - Servidor PHP para remover Anotacao do PROJETO
//  esse arquivo faz parte do anotacao_remover.php
//
//  LAFB&SPFB120803.1151
#
ob_start(); /* Evitando warning */
//
//  Verificando se session_start - ativado ou desativado
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
///
//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

/*
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";
*/

///   Para acertar a acentuacao
///  $_POST = array_map(utf8_decode, $_POST);
///  extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

///  Verificando SESSION incluir_arq - 20180612
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo "Sess?o incluir_arq não est? ativa.";
    exit();
}
///  DEFININDO A PASTA PRINCIPAL 
/////  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
///  Verificando SESSION  pasta_raiz
if( ! isset($_SESSION["pasta_raiz"]) ) {
     $msg_erro .= utf8_decode("Sess?o pasta_raiz não est? ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
$pasta_raiz=$_SESSION["pasta_raiz"];
///
///  Definindo http ou https
///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
///  Parametros de controle para esse processo:
if( isset($_POST['cip']) ) $cip= $_POST['cip'];
if( isset($_SESSION["usuario_conectado"]) ) $anotador = $_SESSION["usuario_conectado"];
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado= $_SESSION["usuario_conectado"];
if( isset($_POST['grupoanot']) ) $opcao = strtoupper(trim($_POST['grupoanot']));
if( isset($_POST['op_selcpoid']) ) $op_selcpoid = $_POST['op_selcpoid'];
if( isset($_POST['op_selcpoval']) ) $op_selcpoval= $_POST['op_selcpoval'];
if( isset($_POST['nr_anotacao']) ) $nr_anotacao = $_POST['nr_anotacao'];
///
/// Conectar 
$elemento=5; $elemento2=6;
include("php_include/ajax/includes/conectar.php");
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];        
//
///  INCLUINDO CLASS - 
////  require_once('../includes/autoload_class.php');  
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
// $funcoes->usuario_pa_nome();
// $_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
//
///  UPLOAD -  do Servidor para maquina local

if( isset($idopcao) ) {
    if( ! isset($opcao) or strlen(trim($opcao))<1 ) $opcao=$idopcao;
}
///
$opcao_maiusc=strtoupper(trim($opcao));
///
///  Arquivo da tabela de remover anotacao - importante
$arq_tab_rm_anotacao="{$incluir_arq}includes/tabela_de_remocao_anotacao.php"; 
///
///  SAIR do Programa
if( $opcao_maiusc=="SAIR" ) {
    /// Eliminar todas as variaveis de sessions
    $_SESSION=array();
    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($login_down) ) unset($login_down); 
    if( isset($senha_down) )  unset($senha_down); 
    //
    ///  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
    response.setHeader("Pragma", "no-cache"); 
    response.setHeader("Cache-Control", "no-cache"); 
    response.setDateHeader("Expires",0); 
    ///  echo  "http://www-gen.fmrp.usp.br/";
    exit();
}
/// Final - SAIR do programa
///
///
if( $opcao_maiusc=="DESCARREGAR" )  {
    // Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
    set_time_limit(0);
    $post_array = array("grupoanot","val","m_array");
    for( $i=0; $i<count($post_array); $i++ ) {
        $xyz = $post_array[$i];
        //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
        $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
        if ( isset($_POST[$xyz]) ) {
            $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
            if ( $pos1 === false ) {
                ///  $$xyz=trim($_POST[$xyz]);
                ///   Para acertar a acentuacao - utf8_encode
                $$xyz = utf8_decode(trim($_POST[$xyz])); 
            } else {
                $$xyz = explode($div_array_por,$_POST[$xyz]);   
            }
        }
    }    
    /// $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
    $pasta = "../doctos_img/A".$m_array[0];
    $pasta .= "/".$m_array[1]."/";     
    //  $output = shell_exec('for arq in `ls '.$pasta.'/*.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done');    
    ///  Definindo http ou https
    ///  Definindo http ou https - IMPORTANTE
    ///  Verificando protocolo do Site  http ou https   
    $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
    ///
    $host  = $protocolo."://".$_SERVER['HTTP_HOST']; 
    $arquivo = trim($val);
    ///
    if( ! file_exists("{$pasta}".$arquivo) ) {
        /* $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
         echo $msg_erro;  */
       echo  $funcoes->mostra_msg_erro("&nbsp;Esse Arquivo: ".$arquivo." n&atilde;o tem no Servidor");
    } else {
        echo $pasta."%".$arquivo;  
    } 
    ///
    unset($opcao);
    exit();     
    ///
} elseif( $opcao_maiusc=="BUSCA_PROJ" ) {
     ///  Verifica se existe ANOTACOES para o PROJETO escolhido
      $sqlcmd = "SELECT anotacao as nanotacoes FROM  $bd_2.projeto  "
                 ." WHERE cip=$val  ";
      ///           
      $result_consult_anotacao = mysql_query($sqlcmd);
      if( ! $result_consult_anotacao ) {
            echo $funcoes->mostra_msg_erro("Selecionando ".utf8_decode("anota??o")." na tabela  -&nbsp;db/mysql:&nbsp;".mysql_error());            
            exit();        
      }
      ///  Numero de Anotacoes 
      $nanotacoes= (int) mysql_result($result_consult_anotacao,0,0);  
      if( intval($nanotacoes)<1 ) {
            echo $funcoes->mostra_msg_erro("Nenhuma anota&ccedil;&atilde;o desse Projeto.");            
            exit();        
      } 
      ///
} elseif( preg_match("/^TODOS|ordenar/i",$opcao_maiusc) ) {
    ///
    ///  Mostrar todas as anotacoes de um Projeto
   $table_remover = $_SESSION["table_remover"] = "$bd_2.temp_remover_anotacao";
   $sql_temp = "DROP TABLE IF EXISTS  $table_remover  ";  
   $drop_result = mysql_query($sql_temp); 
   if( ! $drop_result  ) {
        /// 
        /// Parte do Class
        echo $funcoes->mostra_msg_erro("Removendo a Tabela {$_SESSION["table_remover"]} -&nbsp;db/mysql:&nbsp;".mysql_error());
        exit();                      
   }
   $_SESSION["selecionados"]="";
   /// Numero do CIP - Codigo de Identificacao do Projeto
   $alterar=FALSE;
   if( ! isset($cip) ) {
       $alterar=TRUE;
   } elseif( intval($cip)<1 ) {
       $alterar=TRUE;
   }
   if( $alterar ) {
       if( isset($val) ) {
           $cip=$val;             
       } else {
           echo $funcoes->mostra_msg_erro(utf8_decode("Variiável val não definida - corrigir."));
           exit();        
       }
   }
   /// 
   ///  Selecionar a anotacao para remover
    /// Contador de linhas - resultado do Select/Mysql
    mysql_query("SET @xnr:=0");
    ///   Criando a tabela temporaria
    $sqlcmd ="CREATE TABLE  IF NOT EXISTS $table_remover ";
    /*
    $sqlcmd .= "SELECT a.numero as nr, a.alteraant as Altera, alteradapn as Alterada, "
        ." a.titulo as titulo, b.nome as Anotador,   "
        ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as daata, "
       ." concat($cip,'#',a.numero) as Detalhes,  "
        ." a.relatext as Arquivo, c.autor as projeto_autor  "   
        ."  c.autor as projeto_autor  "
        ." FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c  "
        ."  WHERE  a.autor=b.codigousp and  c.cip=$cip and   ";
        
    */   
    $sqlcmd .= "SELECT  @xnr:=@xnr+1 as nr, a.numero as cia, a.titulo as titulo, "
        ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data, "
  /***      ." concat($cip,'#',a.numero) as Detalhes,  "
        ." a.relatext as Arquivo, c.autor as projeto_autor  "    ***/
        ."  alteradapn as Alterada   "
        ." FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c  "
        ."  WHERE  a.autor=b.codigousp and  c.cip=$cip and   ";
    ///    
     /***
        *      Alterado em 20181023
        *      Super, Chefe e Vice     
     ***/
     if( $_SESSION["permit_pa"]<$array_pa['aprovador'] )  {
          $where_cond = "  a.projeto=$cip   ";    
     } elseif( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
          $where_cond = "  a.projeto=$cip   ";    
     } else {
          $where_cond = "  a.projeto=".$cip." and a.autor=".$anotador;         
     }  
     ////
    ///  $sqlcmd .= $where_cond." order by a.numero desc";
    if( ! isset($m_array) ) {
         $sqlcmd .= $where_cond." order by a.numero desc";            
    } else {
         if( strlen(trim($m_array))>0 ) {
              $m_array=str_replace("Data","data",$m_array);
              $m_array=str_replace("Titulo","titulo",$m_array);
              $sqlcmd .= $where_cond." order by $m_array";               
         }
    }
    ///
    /// Executando mysql_query
    $result_rmanotacao = mysql_query($sqlcmd);
    if( ! $result_rmanotacao ) {
       ///  die('ERRO: Falha consultando a tabela anota&ccedil;&atilde;o  - op&ccedil;&atilde;o='.$opcao.' - '.mysql_error().$orientador);
        echo $funcoes->mostra_msg_erro("Consultando a Tabela anota&ccedil;&atilde;o -&nbsp;db/mysql:&nbsp;".mysql_error());            
        exit();        
    }       
    ///
    ///  Selecionando todos os registros da Tabela temporaria
    $query2 = "SELECT * from  ".$_SESSION["table_remover"]."  ";
    $result_outro = mysql_query($query2);                                    
    if( ! $result_outro ) {
         /// die("ERRO: Selecionando as Anota&ccedil;&otilde;es do Projeto  - ".mysql_error());  
         echo $funcoes->mostra_msg_erro("Selecionando as anota&ccedil;&otilde;es do Projeto  -&nbsp;db/mysql:&nbsp;".mysql_error());     
         exit();                 
    }        
    ///  Pegando os nomes dos campos do primeiro Select
    $num_fields=mysql_num_fields($result_outro);  ///  Obtem o numero de campos do resultado
    $td_menu = $num_fields+1;   
    ///  Total de registros
    $_SESSION["total_regs"]=$total_regs = mysql_num_rows($result_outro);

/***
  echo  "ERRO: srv_rmanotacao/280   -->>  \$total_regs = $total_regs -- \$opcao_maiusc = $opcao_maiusc --- \$val = $val <br> -->> \$bd_1 = $bd_1  --- \$bd_2 = $bd_2  ";
  exit();
***/
  
    /// Caso numero de registros menor que 1
    if( intval($total_regs)<1 ) {
        /*    $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto ".$msg_final;        
            echo $msg_erro;  
        ***/
         echo $funcoes->mostra_msg_erro("&nbsp;Nenhuma anota&ccedil;&atilde;o para esse Projeto.");
         exit();
    }   
    ///    
    $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> Anota&ccedil;&atilde;o " : $lista_usuario="<b>".$_SESSION['total_regs']."</b> Anota&ccedil;&otilde;es ";     
    $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal;' >";
    $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
    ///  Buscando a pagina para listar os registros        
    $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
    if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag;
    $_SESSION["pagina"]=0;
    $_SESSION["m_function"]="remove_anotacao" ;  $_SESSION["conjunto"]="Anotacao#@=".$usuario_conectado."#@=".$cip;
    $_SESSION["opcoes_lista"] = "{$arq_tab_rm_anotacao}?pagina=";
    require_once("{$arq_tab_rm_anotacao}");                      
    ///
    if( isset($opcao) ) unset($opcao);
    exit();
    ///
} elseif( $opcao_maiusc=="REMOVER" ) {
     ///   Fomrulario para recemover Anotacao
     if( ! isset($_POST['nr_anotacao']) ) {
            $nr_anotacao=0;   
     }
     ///
     ///  Verificando Anotacoes
     if( intval($nr_anotacao)<1  ) {
          echo  utf8_decode("ERRO: Anotação inválida.");
     } else {
         ///  Seleciona a Anotacao para Remover
         $sqlcmd = "SELECT a.cia, a.numero as nr, a.alteraant as altera_nr, a.autor as anotador, "
             ."concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anot, "
                      ."a.testemunha1, a.testemunha2, "
                      ." a.titulo as tit_anotacao, a.relatext as arquivado_como,  "
                      ." b.autor as autor_projeto, b.titulo as tit_projeto "
                      ." FROM rexp.anotacao a, rexp.projeto b "
                      ." WHERE ( a.projeto=b.cip ) and a.projeto=$cip  and  a.numero=$nr_anotacao ";
         ///
         $result_anotacao_rm = mysql_query($sqlcmd);
         ///
         if( ! $result_anotacao_rm ) {
             if( isset($result_anotacao_rm) ) mysql_free_result($result_anotacao_rm);
             echo  $funcoes->mostra_msg_erro("Falha consultando a tabela anota&ccedil;&atilde;o  -&nbsp;db/mysql:&nbsp;".mysql_error());                  
         } else {
             ///
             ///  Clicar o Formulario da Anotacao para ser excluida     
             $array_nome=mysql_fetch_array($result_anotacao_rm);
             foreach( $array_nome as $key => $value ) {
                      $$key=$value;
             }
             ///  Passando as variaveis para SESSION
             $_SESSION["autor_projeto"]=$autor_projeto; $_SESSION["projeto"]=$cip; 
             $_SESSION["anotacao"]=$nr_anotacao;  $_SESSION["arquivado_como"]=$arquivado_como;  
             ///   Formulario da Anotacao para Excluir
             $texto1="<div class='caixa_box' style='width:auto;padding: .6em 0 .6em 0;' >";
             $texto1.="Excluir essa anota&ccedil;&atilde;o desse Projeto?";
             $texto1.="</div>";
             echo $texto1;
             $_SESSION["cols"]=4; $td1_width="35";  $tr_heigth="26px";
             ////          
          ?>
          
          
 <!-- div - ate antes do Cancelar e  Remover -->            
  <div class="parte_inicial" >
    
    <!-- ANOTADOR E ANOTACAO -->
        <div class="div_nova" style="vertical-align: middle;padding: .3em 0 .3em 0; " >
             <span>
                 <label title="Anotador" >Anotador:&nbsp;</label>
             </span>
                <!-- N. Funcional USP/Matricula - Autor/ANOTADOR -->
            <?php 
              ///  Selecionando Anotador
              $res_anotador = mysql_query("SELECT codigousp,nome,categoria FROM $bd_1.pessoa "
                                    ." WHERE codigousp=$anotador order by nome "); 
              ///                                    
              if( ! $res_anotador ) {
                 echo  $funcoes->mostra_msg_erro("Select Tabela  pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());                  
                  exit();                
              }
              ///  Cod/Num_USP/Autor/Anotador
              $m_linhas = mysql_num_rows($res_anotador);
              if( intval($m_linhas)<1 ) {
                  $autor="== Nenhum encontrado ==";
              } else {
                  $_SESSION["anotador_codigousp"]=mysql_result($res_anotador,0,"codigousp");
                  $anotador_nome=mysql_result($res_anotador,0,"nome");
                  $anotador_categoria=mysql_result($res_anotador,0,"categoria");                    
                  if( isset($res_anotador))  mysql_free_result($res_anotador);
              }
              /// Final da Num_USP/Nome Autor/Anotador
              ///  Nome do Anotador do Projeto
              echo "<span style='color: #FFFFFF; padding-right:1em;' >"
                    ."$anotador_nome</span>"; 
              ///
              ///  SESSION cadigo usp do Anotador
              $anotador_codigousp = $_SESSION["anotador_codigousp"];
              ///      
         ?>  
          <!--  Nr. da Anotacao  -->       
          <span style="background-color: #FFFFFF; color: #000000; border: 1px solid #000000;" >Anota&ccedil;&atilde;o#&nbsp;
            <?php echo $nr;?>
            <!--  Data da Anotacao  -->
             &nbsp;-&nbsp;Data:&nbsp;<?php echo $data_anot;?>
         </span>
         <input type="hidden" name="autor" id="autor" value="<?php echo $anotador_codigousp;?>" />
      </div>
    <!-- Final - ANOTADOR E ANOTACAO -->
    
    <!-- Titulo do Projeto -->
      <div class="div_nova" >
         <div style="overflow: auto; width: 98%; padding: .3em;">
             <label class="titulo_pequeno"  style=" vertical-align: top;" >
                 T&iacute;tulo do Projeto:&nbsp;
             </label>
             <textarea rows="3" disabled="disabled" ><?php echo nl2br($tit_projeto);?></textarea>
         </div>                    
      </div>
   <!-- Final - Titulo do Projeto -->

   <!--  Titulo da Anotacao  -->
      <div class="div_nova" >
         <div style="overflow: auto; width: 98%; padding: .3em;">
             <label class="titulo_pequeno"  style=" vertical-align: top;" >
                  T&iacute;tulo da Anota&ccedil;&atilde;o:&nbsp;
              </label>
              <textarea rows="3" disabled="disabled" >
                   <?php echo nl2br($tit_anotacao);?>
              </textarea>
         </div>                    
      </div>
   <!-- Final - Titulo da Anotacao  -->
    
    <!-- Arquivo da Anotacao -->
    <div class="div_nova" style="margin: .2em 0 .2em 0;" >
       <span>
          <label for="fonteprojid" >Arquivo da Anota&ccedil;&atilde;o:&nbsp;</label>
       </span>
        <span class="arquivado_como" >
             <?php echo $arquivado_como;?>
        </span>           
    </div>
    <!-- Final - Arquivo da Anotacao -->    


  <hr class="hr_new" >    
   
   <!--  TESTEMUNHAS - 1 e 2  -->   
    <div class="div_nova" >
      <label title="Testemunha (1)" >Testemunha (1):&nbsp;</label>   
        <!-- Codigo da Testemunha (1) da realizacao -->
        <?php 
            ///  Selecionando a Testemunha (1)
            $test1="SELECT codigousp,nome as testemunha1_nome,categoria 
                     FROM $bd_1.pessoa WHERE codigousp=$testemunha1 order by nome ";
            ///         
            $result1=mysql_query($test1);
            ///  Codigo da Testemunha (1) da realizacao 
            if( ! $result1 )  {
                echo  $funcoes->mostra_msg_erro("Select Tabela pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());                  
                exit();                
            }
            ///  Se Testemunha (1) encontrado
            $test1_nome="";
            $n_test1=mysql_num_rows($result1);
            if( $n_test1==1 ) $test1_nome = mysql_result($result1,0,'testemunha1_nome');
            
            ///  include("testemunhas.php"); 
            echo "<span style='color: #FFFFFF; padding-top:0; vertical-align:text-top; ' >$test1_nome</span>";           
            ///
            if( isset($result1) ) mysql_free_result($result1); 
            /// FINAL - Codigo da Testemunha (1) da realizacao 
         ?>  
    </div>  
    <div class="div_nova"   >
      <label title="Testemunha (2)" >Testemunha (2):&nbsp;</label>   
      <!-- Codigo da Testemunha (2) da realizacao -->
       <?php 
          ///  Selecionando a Testemunha (2)
          $test2="SELECT codigousp,nome as testemunha2_nome,categoria 
                     FROM $bd_1.pessoa WHERE codigousp=$testemunha2 order by nome ";
          ///           
          $result=mysql_query($test2);
          ///  Codigo da Testemunha (2) da realizacao 
          if( ! $result )  {
               echo  $funcoes->mostra_msg_erro("Select Tabela pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());                  
               exit();                
          }
          /// $testemunhas_result = $result;
          ///  Se Testemunha (1) encontrado
          $test2_nome="";
          $n_test2=mysql_num_rows($result);
          if( $n_test2==1 ) $test2_nome = mysql_result($result,0,'testemunha2_nome');
          
          ///  include("testemunhas.php"); 
          echo "<span style='color: #FFFFFF;' >$test2_nome</span>";
          ///
          if( isset($result) )  mysql_free_result($result); 
          /// FINAL - Codigo da Testemunha (2) da realizacao 
      ?>  
    </div>    
  <!--  Final - Testemunhas 1 e 2  -->    

 
 </div>
<!-- Final - div - ate antes do Cancelar e  Remover -->  
      

 <!--  TAGS  type submit - opcoes:  excluir e cancelar  --> 
   <div class="reset_button" >
     <!-- Cancelar -->                  
       <span>
           <button type="submit" name="cancelar" id="cancelar"  class="botao3d" 
             onclick="javascript: location.reload();"  title="Cancelar"  acesskey="C" alt="Cancelar" >
       Cancelar&nbsp;<img src="../imagens/enviar.gif"  alt="Cancelar" >
           </button>
        </span>   
        <!-- Final - Cancelar -->
        <!-- Excluir -->                  
        <span>
           <button name="excluir" id="excluir"  type="submit" onclick="javascript: remove_anotacao('anotacao','Excluindo','<?php echo $cia;?>');"  class="botao3d"  title="Remover" 
            acesskey="R"  alt="Remover" >    
      Remover&nbsp;<img src="../imagens/limpar.gif" alt="Remover" >
          </button>
        </span>  
        <!-- Final - Excluir -->
     </div>
     <!--  FINAL - TAGS  type reset e  submit  -->       
   </div>
   
   <!--  FINAL DO FORMULARIO PARA REMOVER ANOTACAO  -->                
   <?php
         ///
         }               
         ///         
     }
     ///  FINAL - if( intval($nr_anotacao)<1  )
     ///
} elseif( $opcao_maiusc=="EXCLUINDO"  && strtoupper(trim($op_selcpoval))=="ANOTACAO"  ) {
        /*
             Remover uma ANOTACAO de um Projeto
        */  
       /// Caso Ativa SESSION anotacao_cip_altexc  desativar
       if( isset($_SESSION["anotacao_cip_altexc"]) ) {
           unset($_SESSION["anotacao_cip_altexc"]);
       }    
       ///
      ///  Codigo de Identificacao da Anotacao - cia
      if( ! isset($cia) ) {
          $cia=0;             
      }
      ///  Verificando o
      if( intval($cia)<1 ) {
           /// Faltando cia
           echo $funcoes->mostra_msg_erro(utf8_decode("Faltando a CIA (Código de Identificação da Anotação)"));
     } else {
          ///
          ///  Seleciona a Anotacao para Remover  -- MySQL/Select
          $sqlcmd = "SELECT a.cia, a.numero as nr, a.alteraant as altera_nr, a.autor as anotador, "
                          ."concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anot, "
                          ."a.testemunha1, a.testemunha2, "
                          ." a.titulo as tit_anotacao, a.relatext as arquivado_como,  "
                          ." b.autor as autor_projeto, b.titulo as tit_projeto "
                          ." FROM $bd_2.anotacao a, $bd_2.projeto b "
                          ." WHERE ( a.projeto=b.cip ) and a.cia=$cia ";
          ///
          $result_anotacao_rm = mysql_query($sqlcmd);
          if( ! $result_anotacao_rm ) {
               if( isset($result_anotacao_rm) ) mysql_free_result($result_anotacao_rm);
               echo  $funcoes->mostra_msg_erro("Falha consultando a tabela anota&ccedil;&atilde;o  -&nbsp;db/Mysql:&nbsp;".mysql_error());                  
          } else {
               ///  Clicar o Formulario da Anotacao para ser excluida     
               $array_nome=mysql_fetch_array($result_anotacao_rm);
               foreach( $array_nome as $key => $value ) {
                         $$key=$value;
               }
          }
          ///
          ///  Essa PARTE vem do arquivo  -  myArguments_remover.php
          $m_projeto=$_SESSION["projeto"]; $m_anotacao = $_SESSION["anotacao"]; 
          $anotador = $_SESSION["anotador_codigousp"];
          ///
           ///  Arquivo da Anotacao do Projeto - escolhido para excluir
           ///  $arquivado_como = trim($_SESSION["arquivado_como"]);
             
           /// $dir ? O DIRETORIO ONDE IR? LISTAR 
           ///   onde   A: Autor do Projeot  -  variavel val = anotacao
           $m_autor_projeto=$_SESSION["autor_projeto"];
          ///
          /// Definindo o caminho do arquivo dessa anotacao que sera removido tambem
          $val=strtolower(trim($op_selcpoval));
          $dir= '../doctos_img/A'.$m_autor_projeto."/$val";
          $remover_arq = $dir."/".$arquivado_como;
          $dh  = opendir($dir);
          $exempt = array('.','..'); $conta_arq=0;
          ///
          ///  Removendo o arquivo PDF
          while( false !== ($filename = readdir($dh))) {
                 if( in_array(strtolower($filename),$exempt) ) continue;
                 $filename_maiusc = strtoupper(trim($filename));
                 $conta_arq++;
                 if( ( substr($filename_maiusc,-3,3)=="PDF") && ( $filename_maiusc==strtoupper(trim($arquivado_como)) ) ) {
                        /// Removendo o arquivo da ANOTACAO
                        unlink(trim($remover_arq)); 
                        $conta_arq--;             
                  }           
          }
          ///  Caso NAO TENHA mais ARQUIVOS na PASTA remove-la tambem
          if( intval($conta_arq)<1 ) {
              if( is_dir($dir) ) { 
                  rmdir($dir); 
              } else {
                  echo $dir.' n&atilde;o existe';    
              }
          }
          ///  FINAL removendo o arquivo PDF
          ///
          ///  Start a transaction - ex. procedure 
         $lnerro=0;
         $tabela="anotacao";
         $commit="commit";   
         mysql_query('DELIMITER &&'); 
         mysql_query('begin'); 
         //  Execute the queries          
         //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
         mysql_query("LOCK TABLES $bd_2.$tabela  DELETE ");
         ///
         ///  Removendo o registro da anotacao
         $sqlcmd = "DELETE from $bd_2.$tabela  WHERE cia=$cia ";
         $res_reg =  mysql_query($sqlcmd);
         if( ! $res_reg  ) $lnerro=1;
         ///
         if( intval($lnerro)>=1 ) {
              echo $funcoes->mostra_msg_erro("&nbsp;Removendo registro. Cancelado -&nbsp;db/mysql:&nbsp;".mysql_error());
              $commit="rollback";
         }    
         ///                  
         mysql_query($commit);
         mysql_query("UNLOCK  TABLES");
         ///  Complete the transaction 
         mysql_query('end'); 
         mysql_query('DELIMITER');
         ///  Removido
         if( intval($lnerro)<1 ) {
              ////   echo $funcoes->mostra_msg_ok("&nbsp;Removido.");
              ////   Diminuir o numero de Anotacoes no Projeto
             ///  Verifica se existe ANOTACOES para o PROJETO escolhido
              $sqlcmd = "SELECT anotacao FROM  $bd_2.projeto  WHERE cip=$m_projeto ";
              ///           
              $result_consult_anotacao = mysql_query($sqlcmd);
              if( ! $result_consult_anotacao ) {
                    echo $funcoes->mostra_msg_erro("Selecionando ".utf8_decode("anota??o")." na tabela Projeto -&nbsp;db/mysql:&nbsp;".mysql_error());            
                    exit();        
              }
              ///  Numero de Anotacoes 
              $nanotacoes=mysql_result($result_consult_anotacao,0,0);  
              if( intval($nanotacoes)>0 ) {
                    $nanotacoes=$nanotacoes-1;
                    $tabela="projeto";
                    $commit="commit";   
                    mysql_query('DELIMITER &&'); 
                    mysql_query('begin'); 
                    //  Execute the queries          
                    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
                    mysql_query("LOCK TABLES $bd_2.$tabela  UPDATE ");
                    ///
                    ///  Removendo o registro da anotacao
                    $sqlcmd = "UPDATE $bd_2.$tabela SET anotacao=$nanotacoes  WHERE cip=$m_projeto ";
                    $res_reg =  mysql_query($sqlcmd);
                    if( ! $res_reg ) {
                        echo $funcoes->mostra_msg_erro("&nbsp;Diminuindo total de anotações do Projeto. Cancelado -&nbsp;db/mysql:&nbsp;".mysql_error());
                         $commit="rollback";
                    }    
                    ///                  
                    mysql_query($commit);
                    mysql_query("UNLOCK  TABLES");
                    ///  Complete the transaction 
                    mysql_query('end'); 
                    mysql_query('DELIMITER');
                    ///
                    ///  Mensagem de aviso da remocao da Anotacao
                    $txt =  'Anotação: '.$tit_anotacao.' removida era parte do Projeto: '.$tit_projeto;
                    echo $txt;
                    ///
              }
             ///
         }
         ///
      }  
      /// Final do IF  isset(cia)
}
#
ob_end_flush(); 
#
?>