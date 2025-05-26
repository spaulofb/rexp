<?php
//  AJAX da opcao Remover  - Servidor PHP para remover PROJETO
//  esse arquivo faz parte do projeto_remover.php
//
//  LAFB&SPFB120119.1151
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
//
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

//  Par?metros de controle para esse processo:
if( isset($_POST['cip']) ) $cip=$_POST['cip'];
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado= $_SESSION["usuario_conectado"];
if( isset($_POST['grupoproj']) ) $opcao= strtoupper(trim($_POST['grupoproj']));
if( isset($_POST['op_selcpoid']) )  $op_selcpoid=$_POST['op_selcpoid'];
if( isset($_POST['op_selcpoval']) ) $op_selcpoval = $_POST['op_selcpoval'];
//
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
     $msg_erro .= utf8_decode("Sessão incluir_arq não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
///
///  DEFININDO A PASTA PRINCIPAL 
/////  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
///  Verificando SESSION  pasta_raiz
if( ! isset($_SESSION["pasta_raiz"]) ) {
     $msg_erro .= utf8_decode("Sessão pasta_raiz não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
$pasta_raiz=$_SESSION["pasta_raiz"];
///
///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
///   Conectar
$elemento=5; $elemento2=6;
///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     
//// require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
require_once('php_include/ajax/includes/tabela_pa.php');
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    
      
///  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
$opcao_maiusc="";
if( isset($opcao) ) $opcao_maiusc=strtoupper(trim($opcao));
///
///  Arquivo da tabela de consulta projeto - importante
$arq_tab_rm_projeto="{$incluir_arq}includes/tabela_remove_projeto.php";
///
////  Mostrar todas as anotacoes de um Projeto
///
if( $opcao_maiusc=="TODOS" or $opcao_maiusc=="BUSCA_PROJ" ) {
         /// Definindo SESSION
         if( ! isset($_SESSION['selecionados']) ) $_SESSION['selecionados']="";
        ///  Criando uma tabela Temporaria para consultar PROJETO
        $_SESSION["table_remover_projeto"] = "$bd_2.temp_remover_projeto";
        $table_remover_projeto = $_SESSION["table_remover_projeto"];
        ///
        $sql_temp = "DROP TABLE IF EXISTS  $table_remover_projeto ";  
        $drop_result = mysql_query($sql_temp); 
        if( ! $drop_result  ) {
            /// die('ERRO: Falha consultando a tabela '.$_SESSION["table_remover_projeto"].' - '.mysql_error());         
            /*  $msg_erro .= "Removendo a Tabela {$_SESSION["table_remover_projeto"]} - db/mysql:&nbsp; ".mysql_error();
            echo $msg_erro.$msg_final;  */
            
            echo $funcoes->mostra_msg_erro("Removendo a Tabela $table_remover_projeto - db/mysql:&nbsp; ".mysql_error());            
            exit();       
        }
        $_SESSION["selecionados"]=""; $where_cond="";
        ///  Selecionar os Projetos de acordo com o opcao - Alterado em 20180418
        /***
        $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_remover_projeto"]."   ";
        $sqlcmd .= "SELECT a.numprojeto as nr, a.titulo as titulo, "
                 ." b.nome as Autor, a.cip, "
                 ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as Data, "
                 ." a.relatproj as Arquivo FROM $bd_2.projeto a, $bd_1.pessoa b  "
                 ." WHERE a.autor=b.codigousp   ";
        ***/
        /// Contador de linhas - resultado do Select/Mysql
        mysql_query("SET @xnr:=0");
        $sqlcmd ="CREATE TABLE  IF NOT EXISTS $table_remover_projeto  ";
        $sqlcmd .= "SELECT  @xnr:=@xnr+1 as nr, a.numprojeto as np, a.titulo as titulo, "
                 ." a.autor as codautor,  b.nome as Autor,  "
                 ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as Data, "
                 ." a.cip, a.relatproj as Arquivo FROM $bd_2.projeto a, $bd_1.pessoa b  "
                 ." WHERE a.autor=b.codigousp   ";
        //// 
        ///  Switch        
        switch ($opcao) {
           case "TODOS":
                  ///
                  if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"];   
                  ///  Permissao do orientador        
                  if( isset($array_pa['orientador']) ) $orientador=$array_pa['orientador'];  
                  ///  Verificando  usuario_conectado
                  $autor_cod=9999999;
                  if( isset($_SESSION["usuario_conectado"]) ) $autor_cod=$_SESSION["usuario_conectado"];  
                  ///
                  if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
                        $where_cond = "";
                        if(  intval($autor_cod)<>9999999 ) {
                             /// $where_cond = " and  a.autor=$orientador ";         
                             $where_cond = " and  a.autor=$autor_cod ";         
                        }
                        ///
                  } else {
                       $where_cond .= "";                   
                  }
                  $_SESSION['selecionados']=" - <b>Total</b>";
                  break;
           case "BUSCA_PROJ":
                  $where_cond .= " and  cip=$val ";
                  break;    
           default:
                 $where_cond .= "";
                 break;
        }
        ///
        $table_remover_projeto=$_SESSION["table_remover_projeto"];
        
        /// Verificando a variavel ORDENAR ou  NAO
        if( strtoupper($val)=="ORDENAR" ) {
             $m_array=preg_replace('/cip/i', 'a.cip', $m_array);              
             //// $m_array=preg_replace('/NoMe/i', 'b.nome', $m_array);             
             $m_array=preg_replace('/titulo/i', 'titulo', $m_array);             
             $m_array=preg_replace('/datainicio/i', 'a.datainicio', $m_array);             
             $sqlcmd .= $where_cond." order by $m_array  "; 
        } else {
             $sqlcmd .= $where_cond." order by a.cip desc";    
        }
        ////
        ///  Execuntando o mysql_query
        $result_consult_projeto = mysql_query($sqlcmd);
        if( ! $result_consult_projeto ) {
            // die('ERRO: Falha consultando a tabela anota&ccedil;&atilde;o  - op&ccedil;&atilde;o='.$opcao.' - '.mysql_error());
            /* $msg_erro .= "&nbsp;Criando a Tabela  {$_SESSION["table_remover_projeto"]} - db/mysql:&nbsp; ";
            echo  $msg_erro.mysql_error().$msg_final; */
             echo $funcoes->mostra_msg_erro("Criando a Tabela $table_remover_projeto&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());                        
             exit();
        }       
        ////
        ///  Selecionando todos os registros da Tabela temporaria de consulta Anotacoes
        $query2 = "SELECT * from  ".$_SESSION["table_remover_projeto"]."  ";
        $resultado_outro = mysql_query($query2);                                    
        if( ! $resultado_outro ) {
             ////  die("ERRO: Selecionando os Projetos - mysql =  ".$cip.mysql_error());  
            /*  $msg_erro .= "&nbsp;Selecionando os Projetos - db/mysql:&nbsp; ".mysql_error().$msg_final;
              echo  $msg_erro;  */
            echo $funcoes->mostra_msg_erro("Selecionando os Projetos - db/mysql:&nbsp;".mysql_error());            
            exit();
        }         
        //
        ////  Total de registros
        $n_regs_projeto = mysql_num_rows($resultado_outro);
        ///  Caso NAO encontrou Projeto        
        if( intval($n_regs_projeto)<1 ) {
             // $msg_erro .= "INICIA&nbsp;N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.FINAL".$msg_final;
            //  echo  $msg_erro;
              echo $funcoes->mostra_msg_erro("N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.FINAL");
              exit();            
        }
        ///
        $_SESSION["total_regs"] = $n_regs_projeto;       
        ///  Pegando os nomes dos campos do primeiro Select
        $num_fields=mysql_num_fields($resultado_outro);  //  Obt?m o n?mero de campos do resultado
        ///  $projeto_titulo = mysql_result($resultado_outro,0,"Titulo");
        $td_menu = $num_fields+1;   
         ///  Total de registros
        /*
        $_SESSION["total_regs"] = mysql_num_rows($resultado_outro);
        if( $_SESSION["total_regs"]<1 ) {
            $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto:&nbsp;<br>$projeto_titulo".$msg_final;
            echo $msg_erro;
            exit();
        } 
               Alterado em 20170926  --  ver em  arquivo  srv_mostraprojeto.php
        */  
        $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b>&nbsp;Projeto&nbsp;" : $lista_usuario="<b>".$_SESSION['total_regs']."</b>&nbsp;Projetos&nbsp;";     
        $_SESSION["titulo"]= "<p class='titulo_consulta'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px;'  >";
        $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
        //  Buscando a pagina para listar os registros        
        $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
        if( isset($_SESSION["ucfirst_data"]) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
        $_SESSION["pagina"]=0;
        $_SESSION["m_function"]="remove_projeto" ;  $_SESSION["conjunto"]="Projeto#@=".$usuario_conectado."#@=";
        $_SESSION["opcoes_lista"] = "{$arq_tab_rm_projeto}?pagina=";
        require_once("{$arq_tab_rm_projeto}");  
        if( isset($cip) ) unset($cip);
        ////
}
///
/// ALterado em 20170926
//// if( $opcao_maiusc=="BUSCA_PROJ_ANTERIOR" )  {
if( $opcao_maiusc=="REMOVER" )  {
    //// Usuario Conectado    
    if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado = $_SESSION["usuario_conectado"];
    ///  Selecionando Projeto para ser removido 
    $sqlcmd = "SELECT a.autor as autor_codigousp, a.numprojeto, a.titulo, a.objetivo, a.coresponsaveis as n_coresponsaveis, "
            ." a.fonterec, a.fonteprojid, b.nome as orientador ,"
            ."concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as inicio, "    
            ."concat(substr(a.datafinal,9,2),'/',substr(a.datafinal,6,2),'/',substr(a.datafinal,1,4)) as final, "             
            ."  a.anotacao, a.relatproj  as arquivado_como  "
            ." FROM $bd_2.projeto a, $bd_1.pessoa b ";
    ///    
    if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
        $where_cond = " WHERE a.autor=$usuario_conectado and a.autor=b.codigousp and a.cip=$cip " ;    
    } else {
        $where_cond = " WHERE a.autor=b.codigousp and a.cip=$cip ";  
    }  
    
    ///  $sqlcmd .= $where_cond." order by datainicio desc";
    $sqlcmd .= $where_cond." order by numprojeto desc"; 
    $result_rmprojeto = mysql_query($sqlcmd);
    if( ! $result_rmprojeto ) {
        /*  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysql: ".mysql_error().$msg_final;  
        echo $msg_erro;  */
        echo $funcoes->mostra_msg_erro("Consultando as Tabelas projeto e pessoa  -&nbsp;db/mysql:&nbsp;".mysql_error());
        exit();
    }
    ///  Nr. de Projetos       
    $n_regs=mysql_num_rows($result_rmprojeto);
    /// Caso encontador o Projeto
    if( intval($n_regs)==1 ) {
           //  Definindo os nomes dos campos recebidos do MYSQL SELECT
           if( isset($array_nome) ) unset($array_nome);
           $array_nome=mysql_fetch_array($result_rmprojeto);
           foreach( $array_nome as $chave_cpo => $valor_cpo ) $$chave_cpo=$valor_cpo;
           ///                        
    } else {
        /* $msg_erro .= "Projeto n&atilde;o encontrado.".$msg_final;  
        echo $msg_erro; */
        echo $funcoes->mostra_msg_erro("Projeto n&atilde;o encontrado");        
        exit();        
    }
    if( $result_rmprojeto )  mysql_free_result($result_rmprojeto);    
    ///  Tabela objetivo - descricao
    $sqlcmd = "SELECT descricao from $bd_2.objetivo  WHERE codigo=$objetivo ";
    $result_objetivo = mysql_query($sqlcmd);
    if( ! $result_objetivo ) {
        /*  $msg_erro .= "Falha consultando a tabela objetivo  - db/mysql: ".mysql_error().$msg_final;  
        echo $msg_erro;  */
        echo $funcoes->mostra_msg_erro("Consultando a Tabela objetivo - db/mysql:&nbsp;".mysql_error());        
        exit();
    }        
    $objetivo=mysql_result($result_objetivo,0,"descricao");
    $_SESSION["conjunto"]="Projeto#@=".$usuario_conectado."#@=$numprojeto#@=$cip";
    $conjunto=$_SESSION["conjunto"];
    ///  Tabela anotacao - total de anotacoes desse projeto
    $sqlcmd = "SELECT count(projeto) as n_anotacao from $bd_2.anotacao  WHERE projeto=$cip  ";
    $result_anotacao = mysql_query($sqlcmd);
    if( ! $result_anotacao ) {
        /*   $msg_erro .= "Falha consultando a tabela anotacao  - db/mysql: ".mysql_error().$msg_final; 
        echo $msg_erro;  */        
        echo $funcoes->mostra_msg_erro("Consultando a Tabela anotacao - db/mysql:&nbsp;".mysql_error());
        exit();
    }  
    ///  Numero de Anotacoes desse Projeto
    $n_anotacao=0;
    if( mysql_num_rows($result_anotacao)>0 ) $n_anotacao=mysql_result($result_anotacao,0,0);
    ///  Nome do autor do Projeto para ser removido          
    if( isset($orientador) ) $_SESSION["autor_projeto_nome"]=$orientador;
    ///
/***    
    echo  "ERRO: srv_rmprojeto/306 -->> projeto: $numprojeto  --- \$arquivado_como = $arquivado_como --- \$n_anotacao= = $n_anotacao=  ---- \$orientador = $orientador  ";
    exit();
    ***/
    
  ?>
<form name="form_remover_projeto" id="form_remover_projeto" 
  enctype="multipart/form-data"   method="post" >
<!-- div - ate antes do Cancelar e  Remover -->  
 <div class="parte_inicial" >
       <div class="div_nova" style="vertical-align: middle;padding: .3em 0 .3em 0; " >
           <span>
              <label title="Orientador do Projeto" >Orientador:&nbsp;</label>
           </span>
              <!-- N. Funcional USP - Autor/Orientador -->
              <span  title="Nome do Autor Respons&aacute;vel do Projeto" >
                  &nbsp;<?php echo $orientador;?>&nbsp;
              </span>
              <span style="vertical-align: middle;">
              <!-- Nr. do Projeto -->
                 <label>Nr. do Projeto:&nbsp;</label>
              </span>                   
                 <span title='N&uacute;mero do Projeto' >
                      &nbsp;<?php echo $numprojeto;?>&nbsp;
                 </span>
        </div>

        <div class="div_nova" >
          <!-- Titulo do Projeto -->
          <div style="overflow: auto; width: 98%; padding: .3em;">
             <label class="titulo_pequeno"  style=" vertical-align: top;" >
                 T&iacute;tulo:&nbsp;
             </label>
             <textarea rows="3" disabled="disabled" ><?php echo nl2br($titulo);?></textarea>
          </div>                    
          <!-- Final - Titulo do Projeto -->
        </div>
        
       <div class="div_nova"  >
          <!-- Objetivo -->
           <span>
               <label for="objetivo"  title="Objetivo do Projeto" >Objetivo:&nbsp;</label>
           </span>    
           <span title="Objetivo" >
                <?php echo $objetivo;?>
           </span>
        </div>


       <div class="div_nova"   >
           <!--  Fonte de Recurso -->
           <span>
               <label for="fonterec" title="Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)" >Fonte Principal de Recursos:&nbsp;</label>
           </span>
           <span>
               <?php echo $fonterec;?>
           </span>
           <!-- Final - Fonte de Recurso -->
        </div>
        
        <div class="div_nova" >
           <!-- fonteprojid  -->
           <span>
               <label for="fonteprojid" >
                  Identifica&ccedil;&atilde;o do Projeto na Fonte de Recursos:&nbsp;
               </label>
           </span>
           <span>
               <?php echo $fonteprojid;?>
           </span>
           <!-- Final - fonteprojid -->
        </div>

        <div class="div_nova" >
           <!-- Data inicio do Projeto -->
           <span>
               <label for="datainicio"  title="Data de In?cio do Projeto" >
                   Data in&iacute;cio:&nbsp;
               </label>
           </span>
           <span  >
                <?php echo $inicio;?>
           </span>
           <!-- Final - Data inicio do Projeto -->
           <!-- Data Final do Projeto -->
           <span>
               <label for="datafinal" title="Data Final do Projeto">Data final:&nbsp;</label>
           </span>
           <span   >
               <?php echo $final;?>
           </span>
           <!-- Final - Data Final do Projeto -->
        </div>

        <div class="div_nova" style="margin: 0;padding: 0;" >
           <!-- Numero de Coautores -->
           <span style="float: left; clear: both; margin-top:.2em; " >
               <label for="n_coresponsaveis" >N&uacute;mero de Co-Respons&aacute;veis:&nbsp;</label>
               <?php echo $n_coresponsaveis;?>
           </span>

           <?php
               /// Verifica o nr. de coresponsaveis
              if( intval($n_coresponsaveis)>0  ) {
                  /// Nomes dos Coresponsaveis na Tabela CORESPPROJ 
                  if( isset($sqlcmd) ) unset($sqlcmd);
                  $sqlcmd = "SELECT a.nome as nome_coresponsavel "
                               ." FROM $bd_1.pessoa a, $bd_2.corespproj b "
                               ." WHERE  a.codigousp=b.coresponsavel and "
                               ." b.projetoautor=$autor_codigousp and  b.projnum=$numprojeto ";
                  ///
                  $result_corespproj=mysql_query($sqlcmd);
                  if( ! $result_corespproj ) {
                      echo $funcoes->mostra_msg_erro("Consultando as Tabelas pessoa e corespproj -&nbsp;db/mysql:&nbsp;".mysql_error());
                      exit();
                  } 
                  /// Nr. de Coresponsaveis
                  $array_cores = mysql_num_rows($result_corespproj);
                  for( $y=0;  $y<$array_cores; $y++ ) {
                       $zy=$y+1;
                     ?>
                       <span style="float: left; clear: both; margin: 0 0 .2em 0;padding: 0 0 0 3px;">
                           <label for="coresponsavel_<?php echo $zy?>" >
                                Co-Respons&aacute;vel_<?php echo $zy?>:&nbsp;
                           </label>
                             <?php echo mysql_result($result_corespproj,$y,"nome_coresponsavel");?>
                       </span>
                     <?php
                  }
              }   
              $objetivo=mysql_result($result_objetivo,0,"descricao");
              ?>
              <!-- Final - Numero de Coautores -->
        </div>

        <div class="div_nova" style="margin: .2em 0 .2em 0;" >
           <!-- Arquivo do Relatorio do Projeto  -->
           <span>
               <label for="fonteprojid" >Arquivo do Projeto:&nbsp;</label>
           </span>
           <span class="arquivado_como" >
                 <?php  echo  $arquivado_como;?>
             </span>           
          <!-- Final - arquivo relatorio do projeto -->
        </div>

        <div class="div_nova" style="margin: .3em 0 .3em 0;" >
           <!-- Nr. de Anotacoes do Projeto  -->
           <span>
               <label for="fonteprojid" >Nr. de Anota&ccedil;&otilde;es do Projeto:&nbsp;</label>
           </span>
            <span style="margin-left: 0; padding: 1px 4px 1px 4px; font-weight: bold;  border: 1px solid #000000;" >
                 <?php  echo  $n_anotacao;?>
            </span>           
           <!-- Final - numero de anotacoes do projeto -->
        </div>               

  </div>
  <!-- Final - div - ate antes do Cancelar e  Remover -->  

        <div class="reset_button"  style="float: left; clear: both; margin: .3em 0 .3em;"  >
           <!--  TAGS  type reset e  submit  --> 
              <!-- Cancelar -->                  
                <span>
                  <button type="button" name="cancelar" id="cancelar" 
                      onClick="javascript: remove_projeto('BUSCA_PROJ','LIMPAR');" 
                       class="botao3d"  title="Cancelar"  acesskey="C"  >    
                       Cancelar&nbsp;<img src="../imagens/limpar.gif" alt="Cancelar" >
                   </button>
                </span>
                <!-- Final - Cancelar -->
                <!-- Remover -->                  
                <span>
                   <button type="button"  name="remover" id="remover" class="botao3d" 
                       onClick="javascript: remove_projeto('REMOVER_PROJETO','<?php echo $conjunto;?>');"  title="Remover"  acesskey="R" >    
                       Remover&nbsp;<img src="../imagens/enviar.gif" alt="Remover" >
                   </button>
                </span>
              <!-- Final - Remover -->
           <!--  FINAL - TAGS  type reset e  submit  -->
        </div>
        
        

   </form>
  <?php    
    exit();
    ///
} else if( $opcao_maiusc=="REMOVER_PROJETO" ) {
     ///  REMOVER PROJETO
    if( isset($val) ) {
       $array_proj = explode('#@=',$val);
       $orientador=$array_proj[1];
       $numprojeto=$array_proj[2];   
       $cip=$array_proj[3];
    } else {
        /*  $msg_erro .= "Falha na variavel: val ".$msg_final;  
        echo $msg_erro;  */
        echo $funcoes->mostra_msg_erro("&nbsp;Falha na variavel: val ");                
        exit();       
    }
    ///  Verificando a permissao de acesso do Usuario
    ///  para remover um Projeto
    $where_cond="";
    if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
        $where_cond="  numprojeto=$numprojeto and autor=$orientador  ";
    } else if( $_SESSION["permit_pa"]<$array_pa['orientador'] )  {
        $where_cond="  cip=$cip ";
    }  else {
         /*  $msg_erro .="SEM PERMISS&Atilde;O PARA EXCLUIR PROJETO".$msg_final;
         echo  $msg_erro;     */
         echo $funcoes->mostra_msg_erro("&nbsp;SEM PERMISS&Atilde;O PARA EXCLUIR PROJETO");                         
         exit();           
    }
    ///
    ///  SELECIONANDO os dados do Projeto/Anotacoes para serem removidos
    $sqlcmd = "SELECT a.codigousp,a.nome as autor_projeto_nome,b.cip,b.autor,b.fonterec,b.fonteprojid,"
                 ."b.numprojeto,b.titulo as titulo_projeto,b.anotacao,b.coresponsaveis,"
                 ." b.relatproj as Arquivo, "
                 ."concat(substr(datainicio,9,2),'/',substr(datainicio,6,2),'/',substr(datainicio,1,4)) as data_inicio_projeto , "
                 ."(Select count(cip) as n_anot from $bd_2.anotador where cip=$cip  ) as n_anot  "     
                 ."  FROM $bd_1.pessoa a, $bd_2.projeto b  WHERE {$where_cond} "; 
    ///                 
    $result_projeto = mysql_query($sqlcmd);                   
    if( ! $result_projeto ) {
         //  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
         /*   $msg_erro .= "Selecionando o Projeto para ser removido - db/mysql: ".mysql_error().$msg_final;  
         echo $msg_erro;  */
         echo $funcoes->mostra_msg_erro("Selecionando o Projeto para ser removido -&nbsp;db/mysql:&nbsp;".mysql_error());
         exit();                   
    }
    ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array - IMPORTANTE
    $array_projeto_cpos=mysql_fetch_array($result_projeto);
    foreach( $array_projeto_cpos as $chave_proj => $valor_proj ) {
             $$chave_proj=$valor_proj;
    }                  
    if( isset($result_projeto) )  mysql_free_result($result_projeto);     
    $autor_projeto_cod="";
    if( isset($autor) ) $autor_projeto_cod=$autor;
    ///
    $coresp_dados="";
    if( intval($coresponsaveis)>=1 ) {
         if( intval($coresponsaveis)==1 ) $tit_coresp="Corespons&aacute;vel";
         if( intval($coresponsaveis)>1 ) $tit_coresp="Corespons&aacute;veis";
         /// Precisa iniciar zerando variavel @contador_regs
         $result_set=mysql_query("set @contador_regs=0;");
         if( ! $result_set ) {
              /* $msg_erro .= "set @contador_regs=0; -  db/mysql:  ".mysql_error().$msg_final;            
              echo  $msg_erro;  */
              echo $funcoes->mostra_msg_erro("set @contador_regs=0; -&nbsp;db/mysql:&nbsp;".mysql_error());
              exit();
         }   
         ///  MySQL/Select      
         $result_coresp=mysql_query("SELECT @contador_regs:=@contador_regs+1 as n, "
                   ." b.nome as coresponsavel_nome FROM $bd_2.corespproj  a, "
                   ." $bd_1.pessoa b  WHERE a.projetoautor=$autor_projeto_cod and "
                   ." a.projnum=$numprojeto and "
                   ." b.codigousp=a.coresponsavel order by b.nome ");
         ///          
         if( ! $result_coresp ) {
               /* $msg_erro .= "Select tabelas corespproj e pessoa -  db/mysql:  ".mysql_error().$msg_final;            
              echo  $msg_erro;  */              
              echo $funcoes->mostra_msg_erro("Select Tabelas corespproj e pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());              
              exit();
         }         
         $coresp_dados .="<div style='text-align:center;font-size: medium; overflow: auto;'>";
         $coresp_dados .="<p style='text-align:center;font-size:small;font-weight:bold;margin:0;' >"
                        ."<b>$tit_coresp:</b></p>";                              
         $nregs_coresp = mysql_num_rows($result_coresp);
         for( $nc=0; $nc<$nregs_coresp; $nc++ ) {
              ///  $n=mysql_result($result_coresp,$nc,"n");
              $n=$nc+1;
              $coresponsavel_nome=mysql_result($result_coresp,$nc,"coresponsavel_nome");
              $coresp_dados .="<span style='text-align:center;font-size: medium;'>"
                     ."$n)&nbsp;$coresponsavel_nome</span><br>";                                              
         }                           
         $coresp_dados .="</div>";
         ///                        
    } 
    /// FINAL - IF( $coresponsaveis>=1 ) { 
     
    ///  Selecionando as ANOTACOES do PROJETO        
    $sqlcmd = "SELECT  a.numero as numero_anotacao, a.titulo as titulo_anotacao,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anotacao "
                 ." FROM $bd_2.anotacao a, $bd_1.pessoa b "
                 ." WHERE a.autor=b.codigousp and a.projeto=$cip  ";                
    ///             
    $resultado_anotacao = mysql_query($sqlcmd);
    if( ! $resultado_anotacao ) {
          /* $msg_erro .= "Selecionando Anota&ccedil;&otilde;es do Projeto: ".$numprojeto." - db/mysql - ".mysql_error();
        echo $msg_erro.$msg_final;  */
          echo $funcoes->mostra_msg_erro("Selecionando Anota&ccedil;&otilde;es do Projeto: {$numprojeto} -&nbsp;db/mysql:&nbsp;".mysql_error());
          exit();
    }         
    ///    
    ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
    if( isset($array_nome) ) unset($array_nome);
    $num_anotacoes = mysql_num_rows($resultado_anotacao);
    /// Caminho da pasta principal
    $incluir_arq="../";
    if( isset($_SESSION["incluir_arq"]) ) {
        if( strlen(trim($_SESSION["incluir_arq"])) ) {
            $incluir_arq = $_SESSION["incluir_arq"];
        }
    }
    $anotacoes="";
    ////
    $texto_anotacoes="";
    ///  Verificando o numero de Anotacoes desse Projeto
    if( intval($num_anotacoes)>=1 ) {
         $anotacoes ="<div style='width: 100%; overflow: auto;'  >";
         /*  Mostra Anotacao por Anotacao - Desativado
          while( $reg_anot=mysql_fetch_array($resultado_anotacao) ) {
              // Anotacao do Projeto                            
              $anotacoes .="<p style='text-align:center;font-size: medium;'>"
                 ."<b>Anota&ccedil;&atilde;o</b>:&nbsp;".$reg_anot['numero_anotacao']."&nbsp;-&nbsp;"
                 ."<b>Data da Anota&ccedil;&atilde;o</b>:&nbsp;".$reg_anot['data_anotacao']."</p>";
              $anotacoes .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo da Anota&ccedil;&atilde;o</b>:<br>"                
                 .$reg_anot['titulo_anotacao']."</div>";                                     
          }
          */
          $anotacoes .="<p style='text-align:center;font-size: medium;'>";
          $anotacoes .="Total de Anota&ccedil;&otilde;es desse Projeto:&nbsp;".$num_anotacoes."</p>";
          $anotacoes .="</div>" ;
          if( intval($num_anotacoes)==1 ) $texto_anotacoes="&nbsp;e uma Anota&ccedil;&atilde;o";
          if( intval($num_anotacoes)>1 ) $texto_anotacoes="&nbsp;e $num_anotacoes Anota&ccedil;&otilde;es";
          
    }  
    ///  FINAL - Selecionando os dados do Projeto
    ///
    ///   INICIANDO - REMOVENDO  nas pastas os Arquivos do Projeto e Anotacoes        
    /// $dir_proj_total="../doctos_img/A".$orientador."/projeto/P".$numprojeto."_*";
     $dir_proj_total=$incluir_arq."doctos_img/A".$orientador."/projeto/P".$numprojeto."_*";

    ///  $dir_autor="/var/www/html/rexp/doctos_img/A{$orientador}";
    $dir_autor=$incluir_arq."doctos_img/A{$orientador}";
    $output_anot = null; $retorno_anot = -1;
    ///  $dir_anot="../doctos_img/A{$orientador}/anotacao/";
    $dir_anot=$incluir_arq."doctos_img/A{$orientador}/anotacao/";
    
     /// $dir_anota_total="../doctos_img/A".$orientador."/anotacao/P".$numprojeto."A*";
    $dir_anota_total=$incluir_arq."doctos_img/A".$orientador."/anotacao/P".$numprojeto."A*";
    /// Endere?o do Diret?rio Local
    $diretorio = getcwd(); 
    /// Abre o Diret?rio
    $ponteiro  = opendir($dir_autor);
    /// Monta os vetores com os itens encontrados na pasta
    while( $nome_itens = readdir($ponteiro)) $itens[] = $nome_itens;
    /// Ordena o vetor de itens
    sort($itens);
    /// Percorre o vetor para fazer a separacao entre arquivos e pastas
    $contador_itens = count($itens);
    $pastas= array(); $arquivos=array();
    $dir_pontos = array('.','..'); 
    for( $i=0; $i<$contador_itens; $i++ ) {
          /// retira "./" e "../" para que retorne apenas pastas e arquivos
          ///  if( $listar!="." && $listar!="..") { 
          ///  if( $itens[$i]!="." && $itens[$i]!="..") { 
          if( in_array(strtolower($itens[$i]),$dir_pontos) ) continue;
          /// checa se o tipo de arquivo encontrado ? uma pasta                    
          ///  $dir_autor_pasta=$dir_autor."/".$listar;
          $dir_autor_pasta=$dir_autor."/".$itens[$i];
          ///  if( is_dir($listar) ) { 
          if( is_dir($dir_autor_pasta) ) { 
                /// caso VERDADEIRO adiciona o item ? vari?vel de pastas
                /// $pastas[]=$itens[$i];    
                /// abrindo um diretorio  = opendir(dir);
               $ponteiro  = opendir($dir_autor_pasta);
               /// Monta os vetores com os itens encontrados na pasta
               while( $nome_itens = readdir($ponteiro) ) {
                    ///   $itens[] = $nome_itens;
                    $arquivos[]=$dir_autor_pasta."/".$nome_itens;   
               } 
          } 
          ///
    }
    ///
    $remover_arquivo=array();
    ///  Total de  dados no array
    $contador_itens=count($arquivos);  $n_anotacoes=0;
    for( $i=0; $i<$contador_itens; $i++ ) {
           /// if( $arquivos[$i]!="." && $arquivos[$i]!="..") { 
           if( in_array(strtolower($arquivos[$i]),$dir_pontos) ) continue;
           ///  Verificando um arquivo PROJETO
           $arq_projeto= "/\/P{$numprojeto}\_/";
           $res_proj=preg_match($arq_projeto,$arquivos[$i]);
           if( $res_proj )  $remover_arquivo[]=$arquivos[$i];
           ///  Verificando os arquivos Anotacoes do PROJETO
           $arqs_anot="/\/P{$numprojeto}A([0-9]{1,10})/";
           $res_anot=preg_match($arqs_anot,$arquivos[$i]);
           if( $res_anot ) {
               $remover_arquivo[]=$arquivos[$i];
               $n_anotacoes++;   
           }
           ///
    }       
    /// Numero de arquivos para Remover
    $num_arqs = count($remover_arquivo);   
    if( intval($num_arqs)>0 ) {
        foreach( $remover_arquivo as $chave_array => $valor_array ) {
             ///  Removendo um arquivo
             if( file_exists($valor_array) )  unlink($valor_array);        
        }       
    }
    ///  FINAL da  remocao dos arquivos Projeto e as anotacoes   
    ///  Nome do Autor do Projeto   
    $autor_projeto_nome="";
    if( isset($_SESSION["autor_projeto_nome"]) )  $autor_projeto_nome=$_SESSION["autor_projeto_nome"];
/*   
    $msg_erro .= "srv_rmprojeto.php/275 -   \$cip = $cip -  \$numprojeto = $numprojeto -  <br>
      \$n_anotacoes = $n_anotacoes  - \$where_cond = $where_cond -  <br> 
      \$autor_projeto_nome = $autor_projeto_nome  ++  \$orientador =$orientador <br>
      \$titulo_projeto = $titulo_projeto -  \$data_inicio_projeto = $data_inicio_projeto  ".$msg_final;  
        echo $msg_erro; 
        exit();       
        */
    $lnerro=0;
    ///  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    ///  Execute the queries          
    ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
    mysql_query("LOCK TABLES $bd_2.projeto DELETE, $bd_2.anotacao DELETE, $bd_2.anotador DELETE ");
    /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;         
    ///  Removendo o anotador do Projeto  
    $sqlcmd = "DELETE from $bd_2.anotador  WHERE cip=$cip  ";
    ///                  
    $res_anotador =  mysql_query($sqlcmd);
    if( $res_anotador ) { 
         ///  Removendo as anotacoes do Projeto
         if( intval($n_anotacoes)>0 ) {
             /// Deletando Anotacoes desse Projeto
             $sqlcmd= "DELETE  from $bd_2.anotacao WHERE projeto=$cip "; 
             ///                  
             $res_anotacao =mysql_query($sqlcmd);      
             if( ! $res_anotacao ) { 
                 ///  mysql_error() - para saber o tipo do erro
                 /* $msg_erro .="&nbsp;Removendo anota&ccedil;&atilde;o do Projeto da Tabela anotacao  - db/mysql:&nbsp; "
                               .mysql_error().$msg_final;
                    echo $msg_erro;  */                    
                 echo $funcoes->mostra_msg_erro("&nbsp;Removendo anota&ccedil;&atilde;o do Projeto da Tabela anotacao  -&nbsp;db/mysql:&nbsp;".mysql_error());
                 $lnerro=1;
             }                
         }
         ///  Removendo o Projeto
         if( intval($lnerro)<1 ) {
             $sqlcmd= "DELETE from $bd_2.projeto WHERE {$where_cond} "; 
             ///                  
             $res_projeto =mysql_query($sqlcmd);      
             if( ! $res_projeto ) { 
                 ///  mysql_error() - para saber o tipo do erro
                 /* $msg_erro .="&nbsp;Removendo o Projeto $numprojeto do Autor $autor_projeto_nome  - db/mysql:&nbsp; "
                               .mysql_error().$msg_final;
                    echo $msg_erro;  */                           
                  echo $funcoes->mostra_msg_erro("&nbsp;Removendo o Projeto $numprojeto do Autor $autor_projeto_nome  -&nbsp;db/mysql:&nbsp;".mysql_error());                    
                  $lnerro=1;
             }                               
         }    
         ///
    } else { 
        ///  mysql_error() - para saber o tipo do erro
        /* $msg_erro .="&nbsp;Removendo anotador do Projeto da Tabela anotador - db/mysql:&nbsp; ".mysql_error().$msg_final;
              echo $msg_erro; */           
         echo $funcoes->mostra_msg_erro("&nbsp;Removendo anotador do Projeto $numprojeto da Tabela anotador -&nbsp;db/mysql:&nbsp;".mysql_error());                    
         $lnerro=1;        
    }       
    ///
    if( intval($lnerro)<1 ) {
        ///  Finalizando 
        mysql_query('commit'); 
    } else {
        /// Cancelando
        mysql_query('rollback');  
    }  
   /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
    mysql_query("UNLOCK  TABLES");
    ///  Complete the transaction 
    mysql_query('end'); 
    mysql_query('DELIMITER');         
    ///  Caso Tabela acima foi aceita incluir dados na outra abaixo
    ///   MENSAGEM FINAL - Projeto e Anotacoes - Removido
    $confirmar0 ="<hr>";
    $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                     ."<b>Projeto $numprojeto foi removido{$texto_anotacoes}.</b><br>"
                     ."<b>Autor do Projeto</b>: $autor_projeto_nome</p>";
    $confirmar0 .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo do Projeto</b>:<br>"                
                 ."$titulo_projeto </div>";
    $confirmar0 .="<p style='text-align:center;font-size:small;padding-top:1em;'>"
                    ."<b>Data in&iacute;cio do Projeto</b>:&nbsp;$data_inicio_projeto </p>";
    $confirmar0 .="<p style='text-align:center;font-size: small;  margin-top:4px;'>"
                    ."<b>Arquivo do Projeto</b>:&nbsp;$Arquivo</p>";  
                    
    $confirmar0 .=$coresp_dados."<br/>";
    $confirmar0 .=$anotacoes;                   
    $confirmar1 =$confirmar0."<br>";
    $confirmar1 .="<div style='width: 100%; text-align: center;'>";                                         
    $confirmar1 .="<button class='botao3d_menu_vert' title='Clicar'  style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: remove_projeto(\"reiniciar_pagina\");' >Retornar";                                  
    $confirmar1 .="</button></div>";                                         
    echo $confirmar1;               

    /*  FINAL - REMOVENDO UM PROJETO/ANOTACOES   */
    exit();     
    ///   
} elseif( $opcao_maiusc=="TODOS_ANTERIOR" ) {
    ////
   $permit_orientador = (int) $_SESSION["permit_pa"];  
   if( $_SESSION["permit_pa"]>=$array_pa["anotador"] ) {
       $texto_erro = "&nbsp;Procedimento n&atilde;o autorizado.<br>"
                ."N&atilde;o consta como Orientador ou Superior";
       //  echo  $msg_erro;
       echo  $funcoes->mostra_msg_erro($texto_erro);                         
       exit();
   }
   //    
   $_SESSION["table_remover"] = "$bd_2.temp_remover_projeto";
   $sql_temp = "DROP TABLE IF EXISTS   ".$_SESSION["table_remover"]."    ";  
   $drop_result = mysql_query($sql_temp); 
   if( ! $drop_result  ) {
       // die('ERRO: Falha removendo a tabela '.$_SESSION["table_remover"].' - '.mysql_error());         
        /* $msg_erro .= "Removendo a Tabela {$_SESSION["table_remover"]} - db/mysql:&nbsp; ".mysql_error();
        echo $msg_erro.$msg_final;   */
        echo $funcoes->mostra_msg_erro("Removendo a Tabela {$_SESSION["table_remover"]} - db/mysql:&nbsp; ".mysql_error());
        exit();       
   }
   $_SESSION["selecionados"]="";
   //  Selecionar um Projeto para remover
   /*
   $sqlcmd .= "SELECT numprojeto as nr, alteraant as altera_nr, autor as orientador, "
             ."concat(substr(data,9,2),'/',substr(data,6,2),'/',substr(data,1,4)) as data_anot, "
             ."testemunha1, testemunha2, "
             ." titulo, relatext as arquivado_como FROM rexp.projeto  ";
     */
    //
    /*
        $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_remover"]."   ";
    $sqlcmd .= "SELECT numprojeto as n, titulo as T?tulo, objetivo, coresponsaveis as Coresp, "
            ." fonterec as Fonte_Recurso, fonteprojid as Identifica??o,"
            ."concat(substr(datainicio,9,2),'/',substr(datainicio,6,2),'/',substr(datainicio,1,4)) as inicio, "    
            ."concat(substr(datafinal,9,2),'/',substr(datafinal,6,2),'/',substr(datafinal,1,4)) as final, "             
            ."  anotacao as Anota??o, relatproj as Relat?rio FROM $bd_2.projeto  ";
    */
    $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_remover"]."   ";
    $sqlcmd .= "SELECT numprojeto as n, titulo as T?tulo,  "
            ."(SELECT descricao from $bd_2.objetivo WHERE codigo=$bd_2.projeto.objetivo ) as objetivo_descricao, "    
            ." fonterec as Fonte_Recurso, fonteprojid as Identifica??o,"
            ."concat(substr(datainicio,9,2),'/',substr(datainicio,6,2),'/',substr(datainicio,1,4)) as inicio, "    
            ."concat(substr(datafinal,9,2),'/',substr(datafinal,6,2),'/',substr(datafinal,1,4)) as final, "             
            ." coresponsaveis as Coresp,  anotacao as Anotacao, cip FROM $bd_2.projeto  ";
    //    
    if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
        $where_cond = " WHERE autor=$usuario_conectado";    
    } else   $where_cond = "";  
    //  $sqlcmd .= $where_cond." order by datainicio desc";
    $sqlcmd .= $where_cond." order by numprojeto desc";
    //
    $result_rmprojeto = mysql_query($sqlcmd);
    if( ! $result_rmprojeto ) {
         //  die('ERRO: Falha consultando a tabela projeto  - op&ccedil;&atilde;o='.$opcao.' - '.mysql_error().$orientador);  
         /* $msg_erro .= "Consultando a tabela projeto  - op&ccedil;&atilde;o={$opcao} - ".mysql_error().$msg_final;
         echo  $msg_erro;     */         
         echo $funcoes->mostra_msg_erro("Criando a Tabela {$_SESSION["table_remover"]} - db/mysql:&nbsp; ".mysql_error());
         exit();           
    }       
    //  Selecionando todos os registros da Tabela temporaria
   $query2 = "SELECT * from  ".$_SESSION["table_remover"]."  ";
   $result_outro = mysql_query($query2);                                    
   if( ! $result_outro ) {
         //  die("ERRO: Selecionando o(s) Projeto(s)  - ".mysql_error());  
         /* $msg_erro .= "Selecionando o(s) Projeto(s) - db/mysql".mysql_error().$msg_final;
         echo  $msg_erro;  */   
         echo $funcoes->mostra_msg_erro("Criando a Tabela {$_SESSION["table_remover"]} - db/mysql:&nbsp; ".mysql_error());
         exit();           
   }        
   //  Pegando os nomes dos campos do primeiro Select
   $num_fields=mysql_num_fields($result_outro);  //  Obt?m o n?mero de campos do resultado
   $td_menu = $num_fields+1;   
   //  Total de registros
   $_SESSION["total_regs"] = mysql_num_rows($result_outro);
   if( $_SESSION["total_regs"]<1 ) {
        /* $msg_erro .= "&nbsp;Nenhum Projeto encontrado".$msg_final;
        echo $msg_erro;  */
        echo $funcoes->mostra_msg_erro("&nbsp;Nenhum Projeto encontrado");        
        exit();
   }   
   /*
      Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array - IMPORTANTE
   $array_nome=mysql_fetch_array($result_outro);
   foreach( $array_nome as $key => $value ) {
              $$key=$value;
              
              echo "<br> $key = $value ";
     }                  
   */
   $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b>&nbsp;Projeto&nbsp;" : $lista_usuario="<b>".$_SESSION['total_regs']."</b>&nbsp;Projetos&nbsp;";     
   $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; '  >";
   $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
   //  Buscando a pagina para listar os registros        
   $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
   if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
   $_SESSION["pagina"]=0;
   ////  $_SESSION["m_function"]="remove_projeto" ;  $_SESSION["conjunto"]="Projeto#@=".$usuario_conectado."#@=".$cip;
   $_SESSION["m_function"]="remove_projeto" ;  $_SESSION["conjunto"]="Projeto#@=".$usuario_conectado."#@=";
   $_SESSION["opcoes_lista"] = "{$_SESSION["incluir_arq"]}includes/tabela_de_remocao.php?pagina=";
   require_once("{$_SESSION["incluir_arq"]}includes/tabela_de_remocao.php");    
   ///                  
}
#
ob_end_flush(); 
#
?>