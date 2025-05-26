<?php
///  AJAX da opcao CONSULTAR  ANOTADOR
#
ob_start(); /* Evitando warning */
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // sempre modificada
header("Pragma: no-cache"); // HTTP/1.0
header("Cache: no-cache");
//  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
// For?a a recarregamento do site toda vez que o navegador entrar na p?gina
header("http-equiv='Cache-Control' content='no-store, no-cache, must-revalidate'");
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

//  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0")
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
///
ini_set('default_charset','UTF-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];

//
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
///
///  Conjunto de arrays 
include_once("{$incluir_arq}includes/array_menu.php");
// Conjunto de Functions
include("{$incluir_arq}script/stringparabusca.php");        

$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if ( isset($_POST[$xyz]) ) {
        $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
       if ( $pos1 === false ) {
           //  $$xyz=trim($_POST[$xyz]);
           //   Para acertar a acentuacao - utf8_encode
           $$xyz = utf8_decode(trim($_POST[$xyz])); 
       } else  $$xyz = explode($div_array_por,$_POST[$xyz]);
    }
}
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source); 
$source_maiusc=strtoupper(trim($source));
///
///  INCLUINDO CLASS - 
////  require_once('../includes/autoload_class.php');  
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
///  Arquivo da tabela de consulta anotador - importante
$arq_tab_consulta_anotador="{$incluir_arq}includes/tabela_anotador_selecionada.php";

///  
if( $source_maiusc=="SAIR" ) {
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
} elseif( $source_maiusc=="PROJETO" )  {
  /*
   $msg_erro .= "-->>  DENTRO DO IF PROJETO - \$source = $source  -  \$val = $val  -  \$m_array =  $m_array  ";
   echo  $msg_erro;
   exit();      
    */
    $elemento=5; $elemento2=6;
    //// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
    include("php_include/ajax/includes/conectar.php");  
    # IMPORTANTE: Aqui esta o segredo
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    ///
    ///  Select/MySQL
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.autor,b.fonterec,b.fonteprojid,"
                 ."b.numprojeto,b.titulo,b.anotacao,b.coresponsaveis,"
                 ."concat(substr(datainicio,9,2),'/',substr(datainicio,6,2),'/',substr(datainicio,1,4)) as inicio_data , "
                 ."(select count(cip) as n_anot from $bd_2.anotador where cip=".$m_array."  ) as n_anot  "     
                 ."  FROM $bd_1.pessoa a, $bd_2.projeto b  where a.codigousp=b.autor and "
                 ." b.cip=".$m_array." order by b.titulo "; 
    ///                 
    $result_projeto = mysql_query($sqlcmd);               
    ///                  
    if( ! $result_projeto ) {
          die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
     }
     //   Vericando se o LOGIN/USUSAIO se ja esta cadastrado na Tabela usuario
    $m_usuario_arr = array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
    $m_senha_arr = array('SENHA','PASSWD','PASSWORD');
    $array_email = array("EMAIL","E_MAIL","USER_EMAIL","EMAIL_USER");
    ///  Definindo os nomes dos campos recebidos do FORM
    ///    foreach( $arr_nome_val as $chave => $valor )  { 
    while ( $arr_nome_val = mysql_fetch_array($result_projeto,MYSQL_ASSOC) ) { 
       foreach( $arr_nome_val as $chave => $valor )  { 
           $campo_nome = strtoupper($chave);
           if( in_array($campo_nome,$m_usuario_arr) ) {
                $login = trim($valor);
                $upper_login = (string) strtoupper($valor);
           }                
           if( in_array($campo_nome,$m_senha_arr) ) {
                $senha = $valor;
                $upper_senha = (string) strtoupper($valor);
           }
           if( in_array($campo_nome,$array_email) ) {
              $e_mail = $valor;
              $upper_email = (string) strtoupper($valor);
           }                         
           $$chave =  $valor;         
       }
   }         
   ///
  ///  PHP ? Remover os espa?os em excesso de uma string/variavel - exemplo: nome
  $titulo = nl2br(trim(preg_replace('/ +/',' ',$titulo)));
  /// 
  ///  Alterado 20181113
  ?>
  <table class="table_inicio_anot"  cellpadding="2"  cellspacing="2" >
    <tr style="vertical-align: middle;  margin: 1px; padding: 2px; line-height: 10px; height: 30px; "  >
        <td  class="td_inicio1" style="vertical-align: middle; text-align: left;"  colspan="1"  >
           <label title="Orientador do Projeto" >Orientador:&nbsp;</label>
           <span class='td_inicio1' style="padding-right: 10px;  border:none; background-color:#FFFFFF; color:#000000; cursor: pointer;" title='Nome do Autor Respons?vel do Projeto' >&nbsp;<?php echo $nome;?>
           </span>
          </td>
       </tr>
       <tr style="width: 1005; background-color: #32CD99;">
          <td colspan="1"  style="width: 1005;" >
             <!--  Nr. Projeto  -->
                <span class="td_inicio1" style="float: left; padding-left: 2px; color: #000000; " >
                    Projeto:&nbsp;
                </span>
                <span class='td_inicio1' style="float: left; width: 1.2em;  padding-left: .4em; background-color:#FFFFFF; color:#000000;"  title='N&uacute;mero do Projeto' >
                    <?php echo $numprojeto;?>&nbsp;
                </span>
             <!--  Final - Nr. Projeto  -->
                <!-- Data inicio do Projeto -->
                 <span class="td_inicio1" style="float: left; padding-left: .6em; color: #000000;" title="Data do In?cio do Projeto" >
                      Data in&iacute;cio:&nbsp;
                 </span>
                 <span class='td_inicio1' style="float: left; background-color:#FFFFFF; color:#000000;" title="Data do In&iacute;cio do Projeto" >
                      &nbsp;&nbsp;<?php echo $inicio_data;?>&nbsp;
                 </span>
              <!-- Final - Data inicio do Projeto -->
          </td>
       </tr>
       <tr style="text-align: left;"  >
        <!--  Titulo do Projeto -->
          <td  class="td_inicio1" colspan="4" style="text-align: left;  background-color: #32CD99; " >
               <label for="titulo"  style="vertical-align: top; color:#000000; background-color: #32CD99; cursor:pointer;" title="T?tulo do Projeto" >T&iacute;tulo:&nbsp;</label>
              <div class="anotador_titulo" >
              <?php echo $titulo;?>
              </div>      
          </td>
       </tr>
        <tr  >
        <!--  Fonte de Recurso -->
        <td  class="td_inicio1" style="text-align: left; vertical-align: middle; "  colspan="1"   >
            <label for="fonterec" style="text-align: left; vertical-align: middle; cursor: pointer;" title="Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)"   >Fonte Principal de Recursos:&nbsp;</label>
            <span class='td_inicio1' style="vertical-align: middle; padding: .2em; border:none; background-color:#FFFFFF; color:#000000; cursor: pointer;" title='Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)' >&nbsp;<?php echo $fonterec;?>&nbsp;
            </span>
            <!-- Final - Fonte de Recurso -->
        </td>
        </tr>
        <tr style="text-align: left;"  >
          <td class="td_inicio1" style="text-align: left; vertical-align: middle;" colspan="1" >
            <!-- Nr de Coresponsaveis -->
            <label for="coresponsaveis" style="text-align: left; vertical-align: middle; cursor: pointer;" title="Nr. Co-Respons&aacute;veis" >Nr. Co-Respons&aacute;veis:&nbsp;</label>
            <span class='td_inicio1' style="vertical-align: middle; padding-left: .2em; border:none; background-color:#FFFFFF; color:#000000; cursor: pointer; " title='Nr. Co-Respons&aacute;veis' >
                 &nbsp;&nbsp;<?php echo $coresponsaveis;?>&nbsp;
            </span>
            <?php
               /// tag Select do nr. de coresponsaveris do Projeto
                if( intval($coresponsaveis)>=1 ) {
                    /*  $sqlcmd = "SELECT a.nome as nome_coresp "
                        ."  FROM pessoal.pessoa a, rexp.corespproj b  "
                        ."  where a.codigousp=".$coresponsaveis." and  "
                        ."  b.projnum=".$numprojeto." order by a.nome "; 
                    */ 
                    $sqlcmd = "SELECT a.nome as nome_coresp,a.codigousp,b.projnum  "
                               ." FROM $bd_1.pessoa a, $bd_2.corespproj b where "
                               ."  a.codigousp=b.coresponsavel  and  b.projnum=$numprojeto and  b.projetoautor='$autor' ";
                    ///                                    
                    $result_coresp = mysql_query($sqlcmd);               
                    ///                  
                    if( ! $result_coresp ) {
                        die('ERRO: Selecionando os Co-Respons&aacute;veis: '.mysql_error());  
                    }                        
                    ///  mysql_free_result($result_coresp);
                    $regs = mysql_num_rows($result_coresp);
                    ?>                  
                   <span class="td_informacao2" style="margin-left: .4em;"  >                    
                   <select class="td_select" style="vertical-align: middle; font-weight: bold; margin: 0px; padding: .3em;"  title="Co-Respons&aacute;veis"  >            
                  <?php
                     ///  
                     echo "<option value='' >Co-Respons&aacute;veis</option>";
                     while( $linha=mysql_fetch_array($result_coresp) ) {   ///  WHILE  DA TAG SELECT    
                            echo  "<option  title='Co-Respons&aacute;vel'  >";
                            echo  $linha['nome_coresp']."&nbsp;</option>" ;
                     }  
                     /// FIM DO WHILE
                  ?>
                  </select>
                  </span>
               <?php
                    if( isset($result_coresp) ) mysql_free_result($result_coresp); 
                }          
            ?>
          </td>
        </tr>
        <?php
        ///  Verificando se tem anotacoes/anotadores 
        if( intval($anotacao)<1  ) {
              /*  Importante essa parte aparecer no corpo da pagina/centro   */   
                echo  "<tr>"
                      ."<td  class='td_inicio1' style='text-align: left; vertical-align: middle;' >";
                $msg_ok .= "Nenhuma Anota&ccedil;&atilde;o desse Projeto";
                echo  $msg_ok.$msg_final;
                echo "</td>";
                echo "</tr>";
         } 
         ?>   
     </table>           
   <?php
    ///  Verificando se tem anotacoes/anotadores 
    if( intval($anotacao)>=1  ) {
          ////                  
          $table_consultar_anotador = $_SESSION["table_temp_anotador"] = "$bd_2.temp_consultar_anotador";
          //  $sql_temp = "DROP TEMPORARY TABLE IF EXISTS   ".$_SESSION["table_temp_anotador"]."    ";
          $sql_temp = "DROP TABLE IF EXISTS  $table_consultar_anotador   ";
          $result_anotadores=mysql_query($sql_temp);
          if( ! $result_anotadores ) {
               /// die('ERRO: '.mysql_error());  
               echo $funcoes->mostra_msg_erro("DROP TABLE IF EXISTS $table_consultar_anotador - db/mysql:&nbsp;".mysql_error());            
               exit();
          }                                          
          ////
/*          $sqlcmd = "CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_temp_anotador"]."   "
                     ." SELECT a.nome as Anotador, b.numero as nr,b.alteraant as altera_nr, b.titulo as T?tulo_Anota??o,  "
                     ."concat(substr(b.data,9,2),'/',substr(b.data,6,2),'/',substr(b.data,1,4)) as Data,  "
                     ."b.relatext as Arquivo FROM $bd_1.pessoa a , $bd_2.anotacao b  WHERE "
                     ."  a.codigousp=b.autor and b.projeto=$cip order by b.data desc ";
                     
          $sqlcmd  = "CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_temp_anotador"]."   ";
          $sqlcmd .= "SELECT a.numero as nr,b.nome as Anotador, a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as Titulo_Anotacao,  c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and a.projeto=$cip and c.cip=$cip order by a.data desc ";
                     

  */
          ///
          mysql_query("SET @xnr:=0");
          $sqlcmd  = "CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_temp_anotador"]."   ";
          $sqlcmd .= "SELECT @xnr:=@xnr+1 as nr, a.numero as na, b.nome as Anotador, "
                 ." a.titulo as Titulo_Anotacao,  c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, a.autor as anotadorcod, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo,  c.autor as projeto_autor "
                 ." FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and a.projeto=$cip and c.cip=$cip order by a.data desc ";
          ///       
          $result_anotadores = mysql_query($sqlcmd);                                    
          ///                  
          if( ! $result_anotadores ) {
                 ///  die('ERRO: Criando uma Tabela Temporaria: '.mysql_error());  
               echo $funcoes->mostra_msg_erro("Criando uma Tabela Temporaria - db/mysql:&nbsp; ".mysql_error());            
               exit();
          } 
          ///// SELECT ALL from many-to-many table where a match is found
          $query2 = "SELECT * from  ".$_SESSION["table_temp_anotador"]."  ";
         $resultado_outro = mysql_query($query2);                                    
         if( ! $resultado_outro ) {
              /* $msg_erro .= "Selecionando as Anota&ccedil;&otilde;es do Projeto  - Falha: ".mysql_error().$msg_final;
                 echo $msg_erro;    */     
              echo $funcoes->mostra_msg_erro("Selecionando as Anota&ccedil;&otilde;es do Projeto -&nbsp;db/mysql:&nbsp;".mysql_error());
              exit();
         }         
         ////  Total de registros
         $_SESSION["total_regs"] = $total_regs = mysql_num_rows($resultado_outro);
         if( intval($total_regs)<1 ) {
              /*  $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto.".$msg_final;
                echo $msg_erro; */
               echo $funcoes->mostra_msg_erro("Nenhuma Anota&ccedil;&atilde;o para esse Projeto.");
               exit();
         } 
         ////  Pegando os nomes dos campos do primeiro Select
         $num_fields=mysql_num_fields($resultado_outro);  ///  Obtem o numero de campos do resultado   
         $td_menu = $num_fields+1;
         $projeto_titulo = mysql_result($resultado_outro,0,"projeto_titulo");
         $projeto_autor = mysql_result($resultado_outro,0,"projeto_autor");
         $_SESSION["projeto_autor"] = $projeto_autor; 
         ////  Total de registros
         $total_regs=$_SESSION["total_regs"];
         $_SESSION['total_regs']==1 ? $lista_anotador=" <b>uma</b> Anota&ccedil;&atilde;o " : $lista_anotador="<b>".$total_regs."</b> Anota&ccedil;&otilde;es ";     
         $_SESSION["titulo"]= "<p class='titulo' style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal; '  >";
         $_SESSION["titulo"].= "Lista de $lista_anotador</p>"; 
         $_SESSION["selecionados"] = "<b>Todos</b>";
         if( strtoupper($val)!=="TODOS" ) $_SESSION["selecionados"] = "come&ccedil;ando com <b>".strtoupper($val[0])."</b>";
         //  Buscando a pagina para listar os registros        
         $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
         if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
         $_SESSION["pagina"]=0;
         /// $_SESSION["opcoes_lista"] = "../consultar/tabela_anotador_selecionada.php?pagina=";
         $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_anotador}?pagina=";
         ////         
         ///  require_once("../consultar/tabela_anotador_selecionada.php");                      
         require_once("{$arq_tab_consulta_anotador}");                      
         ////
         exit();
  }   
  ////  
} elseif( $source_maiusc=="DETALHES" )  {  
  /*  Conectando    */
    $elemento=5; $elemento2=6;
    include("php_include/ajax/includes/conectar.php");            
    
     //  ANOTACAO A VARIAVEL val = array 
    if( strpos($val,"#")!==false ) $array_proj_anot = explode("#",$val);
    if( isset($array_proj_anot) ) {
        $cip=$array_proj_anot[0];
        $anotacao=$array_proj_anot[1];        
    }
    # IMPORTANTE: Aqui esta o segredo
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    ///
    ///  Selecionando Projeto
     $sqlcmd  = "SELECT a.numprojeto, a.titulo as  titulo_projeto, b.nome as autor_projeto,  "
       ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as data_projeto "
                ." FROM $bd_2.projeto a, $bd_1.pessoa b WHERE a.cip=$cip and a.autor=b.codigousp  ";
     $resultado_projeto = mysql_query($sqlcmd);
     if( ! $resultado_projeto ) {
         //// die("ERRO: Selecionando Projeto: cip = ".$cip." - ".mysql_error());  
          echo $funcoes->mostra_msg_erro("Selecionando Projeto: cip = ".$cip." - db/mysql:&nbsp;".mysql_error());
          exit();
     }         
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     $array_nome=mysql_fetch_array($resultado_projeto);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     if( isset($resultado_projeto) ) mysql_free_result($resultado_projeto);     
      /*    
      a.numero as nr, a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as T?tulo, b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
         
        CAMPOS ABAIXO DO PROJETO: 
      */
     ////
    ////  Selecionando a ANOTACAO do Projeto        
    $sqlcmd = "SELECT  a.numero as numero_anotacao, a.alteraant as altera, a.alteradapn as alterada, "
                 ." a.titulo as titulo_anotacao, a.testemunha1, a.testemunha2, b.nome as autor_anotacao,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anotacao, "
                 ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b "
                 ." WHERE a.autor=b.codigousp and a.projeto=$cip and a.numero=$anotacao  ";                
     $resultado_anotacao = mysql_query($sqlcmd);
     if( ! $resultado_anotacao ) {
          $msg_erro .= "Selecionando Anota&ccedil;&atilde;o $anotacao do  Projeto: ".$numprojeto." -  db/mysql:&nbsp;".mysql_error().$msg_final;  
          echo $msg_erro;
          exit();
     }         
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     if( isset($array_nome) ) unset($array_nome);
     $array_nome=mysql_fetch_array($resultado_anotacao);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     //  Selecionando os Nomes das Testemunhas da ANOTACAO
     if( strlen(trim($testemunha1))>=1 or strlen(trim($testemunha2))>=1  ) {
         if( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))>=1 ) {
               $in =" in($testemunha1,$testemunha2)";
         } elseif( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))<1 ) {
               $in =" in($testemunha1)";
         } elseif( strlen(trim($testemunha1))<1 and strlen(trim($testemunha2))>=1 ) {
               $in =" in($testemunha2)";
         } 
         ///  Selecionando as Testemunhas da Anotacao          
         $cmd_sql = "SELECT codigousp as cod_testemunha, nome as nome_testemunha "
                  ." FROM  $bd_1.pessoa where codigousp $in ";
         $res_testemunhas = mysql_query($cmd_sql);
         if( ! $res_testemunhas ) {
             $msg_erro .= "Selecionando testesmunhas da  Anota&ccedil;&atilde;o. mysql =  db/mysql:&nbsp;".mysql_error().$msg_final;  
             echo $msg_erro;
             exit();
         }        
         $testemunhas="";
         /////  Numero de registros
         $num_regs = mysql_num_rows($res_testemunhas); 
         for( $ntest=0 ; $ntest<$num_regs ; $ntest++ ) {
              $nome_testemunha[$ntest]= mysql_result($res_testemunhas,$ntest,"nome_testemunha");
              $x_testemunha = (int) $ntest+1;
              $testemunhas .="<p class='testemunhas' >"
                    ."<b>Testemunha$x_testemunha</b>:&nbsp;".$nome_testemunha[$ntest]."</p>";
              ///                    
         }
     }
     ////   Projeto e Anotacao
     $confirmar0 ="<div class='confirmar0' >";
     $confirmar0 .="<p class='autorprojeto' >"
                     ."<b>Anota&ccedil;&atilde;o $numero_anotacao do Projeto $numprojeto </b><br>"
                     ."<b>Autor do Projeto</b>: $autor_projeto<br/>";
     ///
     $confirmar0 .="<br/><b>T&iacute;tulo do Projeto</b>:";
     $confirmar0 .="<br>"."$titulo_projeto</p>";
     ///
     $confirmar0 .="<p class='dtiniproj' >"
                    ."<b>Data in&iacute;cio do Projeto</b>:&nbsp;$data_projeto </p>";
     ///               
     /// Anotacao do Projeto                    
     $confirmar0 .="<p class='anotacaon' >"
                 ."<b>Anota&ccedil;&atilde;o</b>: $numero_anotacao<br>"
                 ."<b>Anotador</b>: $autor_anotacao  </p>";
     ///            
     $confirmar0 .="<p  class='titanotacao' >"
                 ."<b>T&iacute;tulo da Anota&ccedil;&atilde;o</b>:<br>"                
                 ."$titulo_anotacao</p>";  
     ///                                               
     $confirmar0 .="<p class='dtanotacao' >"
                    ."<b>Data da Anota&ccedil;&atilde;o</b>:&nbsp;$data_anotacao </p>";
     $confirmar0 .="<p class='arqanotacao' >"
                    ."<b>Arquivo da Anota&ccedil;&atilde;o</b>:&nbsp;$Arquivo</p>";  
     ///               
     $confirmar0 .= $testemunhas;                    
     /*
     $confirmar1 =$confirmar0."<div style='width: 100%; text-align: center;'>";                                         
     $confirmar1 .="<button  class='botao3d_menu_vert' style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: limpar_form();' >Ok";                                  
     $confirmar1 .="</button></div>";  
     */
     ///  Verifica qual é o navegador
     if( isset($navegador) ) {
            $confirmar1 =$confirmar0;
            if( strtoupper($navegador)!="CHROME" ) {
                $confirmar1 .="<div style='width: 100%; text-align: center;'>";
                $confirmar1 .="<button class='botao3d_menu_vert'  style='text-align:center; cursor: pointer;'  onclick='javascript: limpar_form();' >Ok";
                $confirmar1 .="</button></div>";                  
            }
            ////                                       
           echo $confirmar1."</div>";               
     } else {
            ///  Precisa da variavel navegador - que indentifica
            echo $funcoes->mostra_msg_erro("Faltando a variavel navegador.");
     }    
     ///
} elseif( $source_maiusc=="LISTA" )  {
         $_SESSION["pagina"]= (int) $val;
          include("{$incluir_arq}consultar/tabela_anotador_selecionada.php");                      
}
///
///  UPLOAD -  do Servidor para maquina local
if( $source_maiusc=="DESCARREGAR" )  {
     ///  UPLOAD -  do Servidor para maquina local
    /// Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
    set_time_limit(0);
    $post_array = array("grupoanot","val","m_array");
    for( $i=0; $i<count($post_array); $i++ ) {
        $xyz = $post_array[$i];
        //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
        $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
        if ( isset($_POST[$xyz]) ) {
            $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
            if( $pos1 === false ) {
                ///  $$xyz=trim($_POST[$xyz]);
                ///   Para acertar a acentuacao - utf8_encode
                /// $$xyz = utf8_decode(trim($_POST[$xyz])); 
                 $$xyz = trim($_POST[$xyz]); 
            } else {
                $$xyz = explode($div_array_por,$_POST[$xyz]);  
            } 
        }
    }      
    ///
    // $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
/***
    $pasta = "../doctos_img/A".$m_array[0];
    $pasta .= "/".$m_array[1]."/";     
***/
    
    ///  Verificar se variavel m_array definida como ARRAY
    /// $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
    if( ! isset($_SESSION["projeto_autor"]) )   $projeto_autor=""; 
    if( isset($_SESSION["projeto_autor"]) )   $projeto_autor = trim($_SESSION["projeto_autor"]);
    ///
    ///  Verificando Permissao de Acesso do USUARIO
    /* Exemplo do resultado  do  Permissao de Acesso 
          - criando array
          +-------------+--------+
          | descricao   | codigo |
          +-------------+--------+
          | super       |      0 | 
          | chefe       |     10 | 
          | vice        |     15 | 
          | aprovador   |     20 | 
          | orientador  |     30 | 
          | anotador    |     50 | 
          +-------------+--------+
    ****/
    ///  Caso for super,chefe ou vice
    ///
 
    ///  $pasta = "../doctos_img/A".$m_array[0];
    ///  $pasta = "../doctos_img/A".$projeto_autor;
    $pasta = "{$_SESSION["incluir_arq"]}doctos_img/A".$projeto_autor;
    $pasta .= "/".$m_array[1]."/";     
    
/// echo  "ERRO:  srv_mostraanotador/534  --->>   \$pasta = $pasta   --- \$pasta2 = $pasta2   ";
///   exit();
    
    
    ///  $output = shell_exec('for arq in `ls '.$pasta.'/*.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done');    
    ///  Definindo http ou https
    ///  Definindo http ou https - IMPORTANTE
    ///  Verificando protocolo do Site  http ou https   
    $_SESSION["protocolo"] = $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
    $host  = $protocolo."://".$_SERVER['HTTP_HOST']; 
    ///
        setlocale(LC_ALL,'pt_BR.UTF8');
    mb_internal_encoding('UTF8'); 
    mb_regex_encoding('UTF8');
    ///  Arquivo do Projeto
    header('Content-Type: text/html; charset=utf-8');
    if( ! ini_set('default_charset', 'utf-8') ) {
         ini_set('default_charset', 'utf-8');
    } 
    ////
    /// Arquivo da Anotacao do Projeto - 20180913
    $val = utf8_decode(trim($val)); 
    $arquivo = trim($val);
   ///  $arquivo = trim($arq_anotacao);
    $dir_arq="{$pasta}{$arquivo}";
 
///  echo "ERRO:  srv_mostraanotador/476  -- {$pasta} ---  $arquivo  --->>>   $dir_arq ";
///  exit();    

    ///
    ///  if( ! file_exists("{$pasta}".$arquivo) ) {
    $resultado=file_exists("$dir_arq");
    if( ! $resultado ) {
        $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
        echo $msg_erro;  
    } else {
        ///  SESSIONs para diretorio e arquivo - Anotacao do Projeto
        ///  echo $pasta."%".$arquivo;  
        $_SESSION["arquivo_anotacao"]=utf8_encode($arquivo);
        $_SESSION["pasta_arq_anotacao"]=$pasta;
        ////  echo $pasta."%#sepa%#rar%#{$arquivo}"; 
        echo  "{$_SESSION["pasta_arq_anotacao"]}%#sepa%#rar%#{$_SESSION["arquivo_anotacao"]}"; 
        ///
    } 
    ///
    exit();     
    ///  
} 
/*******  Final -  UPLOAD -  do Servidor para maquina local  *******/
///
if( $source_maiusc=="SUBMETER" )  {
     // Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
     include 'dbc.php';
     //
     set_time_limit(0); $m_erro=0;
     /*     
         AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
           e de depois usa o  - html_entity_decode 
     */
     unset($array_temp); unset($array_t_value);  $m_erro=0;
     unset($arr_nome_val); unset($count_array_temp);
     //  Arquivo importante definindo o array  \$arr_nome_val
     include("dados_campos_form_cadastrar_auto.php");
     //  Array de emails
     $array_email = array("EMAIL","E_MAIL","USER_EMAIL","EMAIL_USER");
     foreach( $arr_nome_val as $chave => $valor )  {
           $upper_email = strtoupper($chave);
           if( in_array($upper_email,$array_email) ) {
                 $key = $chave;
                 $upper_email = (string) strtoupper($valor);
                 break;
           }                         
     }
     //  Definindo os nomes dos campos recebidos do FORM
     foreach(  $arr_nome_val as $key => $value ) {
          $$key =  $value;
     }
   
   /*
     $msg_erro .= "\$campo_nome = $campo_nome  --- \$campo_value = $campo_value <br>"
             ."---> \$val = $val -- \$sn = $sn <br> \$e_mail = $e_mail - "
             ." \$upper_email = $upper_email -  \$pa = $pa - \$codigousp = $codigousp  - \$activation_code = $activation_code "; 
     echo $msg_erro;
     exit();
     */
   

     if( strtoupper($val)=="ORIENTADOR_NOVO" ) {
         $m_erro="";   $lnerro=0;
         //  Verifica se novo Orientador NAO foi aprovado  ou foi 
         if( strtoupper(trim($sn))=="NAO"  ) {
              $_SESSION['tabela']="pessoal.usuario";
              //  Start a transaction - ex. procedure    
              mysql_query('DELIMITER &&'); 
              mysql_query('begin'); 
              //  Execute the queries          
              //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
              mysql_query("LOCK TABLES ".$_SESSION['tabela']." DELETE, pessoal.pessoa DELETE ");
              /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;         
              //  DELETE   
              $res_usuario = "DELETE from ".$_SESSION['tabela']."  WHERE codigousp=$codigousp  ";
               //                  
               $sqlcmd =  mysql_query($res_usuario);
               if( $sqlcmd ) { 
                   mysql_free_result($sqlcmd);
                   $_SESSION['tabela']="pessoal.pessoa";
                   $res_pessoa= "DELETE  from ".$_SESSION['tabela']." WHERE codigousp=$codigousp "; 
                   //                  
                   $sqlcmd =  mysql_query($res_pessoa);      
                   if( $sqlcmd ) { 
                        //  Concluindo as tabelas para Orientador Novo para ser aceito pelo Aprovador
                        $msg_ok .="<span style='text-align:center; color: #000000;'>"
                                 ."<br>Orientador $nome n&atilde;o foi aceito pelo Aprovador.<br></span>".$msg_final;
                        mysql_query('commit'); 
                        echo $msg_ok;                    
                   } else { 
                        //  mysql_error() - para saber o tipo do erro
                        $msg_erro .="&nbsp;Falha Tabela pessoa delete - ".mysql_error().$msg_final;
                        mysql_query('rollback'); 
                        echo $msg_erro;         
                        $lnerro=1;
                   }                
               } else { 
                  //  mysql_error() - para saber o tipo do erro
                  $msg_erro .="&nbsp;Falha Cadastrar novo Orientador $nome - ".mysql_error().$msg_final;
                  mysql_query('rollback'); 
                  echo $msg_erro; 
                  $lnerro=1;        
               }       
               /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
               mysql_query("UNLOCK  TABLES");
               //  Complete the transaction 
               mysql_query('end'); 
               mysql_query('DELIMITER');         
               //  Caso Tabela acima foi aceita incluir dados na outra abaixo
               mysql_free_result($sqlcmd);
               //   Mandar mensagem para o novo Orientador - cancelado
               if( $lnerro<1 ) {
                   $novo_orientador=$e_mail;
                   $host  = $_SERVER['HTTP_HOST'];
                   $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
                   $user=$arr_nome_val['codigousp'];
                   //  $m_local="ativar_orientador.php?user=".$user."&activ_code=".$activ_code."&pa=".$pa;
                   $m_local="ativar_orientador.php?user=".$user."&activation_code=".$activation_code;
                   $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$retornar$m_local'  title='Clicar' >"
                             ."$retornar$m_local</a>"; 
                   //  $host_upper = strtoupper($host);           
                   $host_lower = strtolower($host);           
                   //  $assunto =html_entity_decode("Redefini??o de senha");    
                   //  $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
                   $assunto =html_entity_decode("RGE/SISTAM - Permiss?o para Orientador - Cancelada");    
                   
                   $corpo ="RGE/SISTAM - Permiss?o para Orientador - Cancelada<br>";
                   $corpo .="$host_lower<br><br>";    
                   $corpo .=html_entity_decode("Permiss&atilde;o como Orientador de Projeto.<br>N&atilde;o foi aprovada.\r\n");                    
                   $headers1  = "MIME-Version: 1.0\n";
                   //  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
                   $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
                   $headers1 .= "X-Priority: 3\n";
                   $headers1 .= "X-MSMail-Priority: Normal\n";
                   $headers1 .= "X-Mailer: php\n";
                   //  $headers1 .= "Return-Path: xxx@...\n";
                   //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
                   $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";
                   
                   //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
                   //  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
                   $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
                   
                   $message = "$corpo\n<br><br>
                   Nome: $nome<br>
                   Usuário: $login<br>
                   
                   ______________________________________________________<br>
                   Esta é uma mensagem automática.<br> 
                   *** não responda a este EMAIL ****
                   ";
                   mail($novo_orientador, $assunto, $message,$headers1);
                   //
               }
             //    FINAL _ NAO APROVANDO NOVO ORIENTADOR                   
         } elseif( strtoupper(trim($sn))=="SIM" ) {
             $rs_check = mysql_query("Select  a.codigousp,a.login,a.pa,a.aprovado,b.e_mail,b.nome from "
                    ." pessoal.usuario a,  pessoal.pessoa b where  "
                    ." trim(a.codigousp)=$codigousp and "
                    ."  upper(trim(b.e_mail))='$upper_email'  and  a.codigousp=b.codigousp  ");
             //                       
             // Verificando se houve erro no Select Tabdla Usuario
             if( ! $rs_check ) {
                mysql_free_result($rs_check);
                die("ERRO: Select pessoal.usuario e campos  - ".mysql_error());
             }  
             $num = mysql_num_rows($rs_check);
             $n_pa = mysql_result($rs_check,0,pa);
             $nome = mysql_result($rs_check,0,nome);
             $cpo_aprovado = mysql_result($rs_check,0,aprovado);
             //  Coincidir com linha encontrada com 1 ou mais resultados - o Usuário ? autenticado
             if ( $num<=0 ) { 
                $m_erro = "N?o existe Usuário/login com o referido codigo de ativação.";
             } elseif( $cpo_aprovado>0 ) {   
                   $msg_ok .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; '>"
                           ."<br>&nbsp;&nbsp;Esse Orientador:<br>"
                             ."<br>&nbsp;&nbsp;<b>".$nome."</b> e e_mail:&nbsp;<b>".$e_mail."</b> j&aacute est&aacute; cadastrado</span>".$msg_final;
                   echo $msg_ok;                                 
             }  else {
                $m_login= trim(mysql_result($rs_check,0,login));                   
                //  Criando nova Senha
                $new_pwd = GenPwd();
                // defina o campo aprovou (approved) como 1 e tb activation_code para Ativar a Conta
                $_SESSION['tabela']="pessoal.usuario";
                //  Start a transaction - ex. procedure    
                mysql_query('DELIMITER &&'); 
                mysql_query('begin'); 
                //  Execute the queries          
                mysql_query("LOCK TABLES ".$_SESSION['tabela']." UPDATE  ");
                $sqlcmd = "UPDATE  ".$_SESSION['tabela']." SET aprovado='1',"
                        ." activation_code=$activation_code,datacad='$datacad',datavalido='$datavalido',senha=password('$new_pwd') "
                        ."  WHERE  trim(codigousp)=$codigousp   ";
                $rs_activ = mysql_query($sqlcmd);     
                // Verificando se houve erro no update            
                if( ! $rs_activ ) {
                     mysql_free_result($rs_activ);
                     $m_erro = "N?o foi poss?vel efetivar o usuario/login. ".mysql_error();
                     mysql_query('rollback'); 
                } else {
                     mysql_query('commit'); 
                }
                mysql_query("UNLOCK  TABLES");
                //  Complete the transaction 
                mysql_query('end'); 
                mysql_query('DELIMITER');         
                mysql_free_result($rs_activ);                            
                //   Mandar mensagem para o novo Orientador - caso nao tenha erro
                if( strlen(trim($m_erro))<1 ) {  // Enviar a mensagem por email
                     $orientador_email=$e_mail;
                     $host  = $_SERVER['HTTP_HOST'];
                     //  $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
                     $m_local = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
                     $user=$codigousp;
                     //  $m_local="ativar_orientador.php?user=".$user."&activ_code=".$activ_code."&pa=".$pa;
                     //  $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$retornar$m_local'  title='Clicar' >"
                     $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$m_local'  title='Clicar' >$m_local</a>"; 
                     //  $host_upper = strtoupper($host);           
                     $host_lower = strtolower($host);           
                     //  $assunto =html_entity_decode("Redefini??o de senha");    
                     //  $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
                     //  $assunto =html_entity_decode("RGE/SISTAM - Permiss?o para Orientador");    
                     $assunto ="RGE/SISTAM - Permiss?o para Orientador - Aprovado";    
                     $corpo ="RGE/SISTAM - Permiss?o para Orientador - Aprovado<br>";
                     $corpo .="$host_lower<br><br>";    
                     $corpo .=html_entity_decode("Aprovado como Orientador de Projeto.<br>Detalhes abaixo para acessar (Usu&aacute;rio/Senha).\r\n");                    
                     $headers1  = "MIME-Version: 1.0\n";
                     //  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
                     $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
                     $headers1 .= "X-Priority: 3\n";
                     $headers1 .= "X-MSMail-Priority: Normal\n";
                     $headers1 .= "X-Mailer: php\n";
                     //  $headers1 .= "Return-Path: xxx@...\n";
                     //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
                     $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";

                     //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
                     //  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
                     $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
                     
                     $message = "$corpo\n<br><br>
                     Nome: $nome<br>
                     Usuário: $m_login<br>
                     Senha: $new_pwd\n<br><br>

                     Clicar no link abaixo para acessar\n<br>

                     $a_link<br><br>

                     ______________________________________________________<br>
                     Esta é uma mensagem automática.<br> 
                     *** não responda a este EMAIL ****
                     ";
                     //  mail($orientador_email, stripslashes(utf8_encode($assunto)), $message,$headers1);
                     mail($orientador_email, $assunto, $message,$headers1);
                     //
                     $msg_ok .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; '>"
                             ."<br>&nbsp;&nbsp;Mensagem enviada para o novo Orientador:<br>"
                             ."<br>&nbsp;&nbsp;<b>".$nome."</b> no email informado:&nbsp;".$e_mail."</span>".$msg_final;
                     echo $msg_ok;                
                }  //  Final do enviar a mensagem por email
             }
             //            
          }  //   Final - do sim ou nao da aprovacao do novo Orientador   
          //
          //  Caso foi encontrado erro         
         if( strlen(trim($m_erro))>=1 ) {
              $msg_erro .= $m_erro.$msg_final; 
              echo $msg_erro;
         }
    }  //  FINAL do IF Permitir/Autorizar o acesso do usuario novo ORIENTADOR
    exit(); 
   //    
} 
#
ob_end_flush(); /* limpar o buffer */
#  
?>
