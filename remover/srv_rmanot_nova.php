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
//
//   Para acertar a acentuacao
// $_POST = array_map(utf8_decode, $_POST);
// extract: Importa variáveis para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

//  Parâmetros de controle para esse processo:
if( isset($_POST['cip']) ) $cip = $_POST['cip'];
if( isset($_SESSION["usuario_conectado"]) ) {
   $anotador = $_SESSION["usuario_conectado"];
   $usuario_conectado = $_SESSION["usuario_conectado"];      
} elseif( ! isset($_SESSION["usuario_conectado"]) ) {
   $anotador = "";
   $usuario_conectado = "";          
}
if( isset($_POST['grupoanot']) ) {
   $opcao = $_POST['grupoanot'];   
}  else if( ! isset($_POST['grupoanot']) ) $opcao="" ;
//
if( isset($_POST['op_selcpoid']) ) {
   $op_selcpoid = $_POST['op_selcpoid'];   
} else if( ! isset($_POST['op_selcpoid']) ) $op_selcpoid="" ;
//
if( isset($_POST['op_selcpoval']) ) {
   $op_selcpoval = $_POST['op_selcpoval'];   
} else if( ! isset($_POST['op_selcpoval']) )  $op_selcpoval="" ;

/*
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";
$msg_final="</span></span>";
*/
// Conectar 
$elemento=5; $elemento2=6;
include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];        
//
//  INCLUINDO CLASS - 
require_once('../includes/autoload_class.php');  
$funcoes=new funcoes();
// $funcoes->usuario_pa_nome();
// $_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
//
//  UPLOAD -  do Servidor para maquina local
if( $opcao=="DESCARREGAR" )  {
    // Define o tempo máximo de execução em 0 para as conexões lentas
    set_time_limit(0);
    $post_array = array("grupoanot","val","m_array");
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
    // $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
    $pasta = "../doctos_img/A".$m_array[0];
    $pasta .= "/".$m_array[1]."/";     
    //  $output = shell_exec('for arq in `ls '.$pasta.'/*.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done');    
    $host  = "http://".$_SERVER['HTTP_HOST']; 
    $arquivo = trim($val);
       
    if( ! file_exists("{$pasta}".$arquivo) ) {
         /* $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
         echo $msg_erro;  */
         
         echo  $funcoes->mostra_msg_erro("&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor");                  
    }  else   echo $pasta."%".$arquivo;
    exit();     
} elseif( $opcao=="TODOS" ) {
    //
   $_SESSION["table_remover"] = "$bd_2.temp_remover_anotacao";
   $sql_temp = "DROP TABLE IF EXISTS   ".$_SESSION["table_remover"]."    ";  
   $drop_result = mysql_query($sql_temp); 
   if( ! $drop_result  ) {
        // die('ERRO: Falha removendo a tabela '.$_SESSION["table_remover"].' - '.mysql_error());  
        // Parte do Class
        echo $funcoes->mostra_msg_erro("Removendo a Tabela {$_SESSION["table_remover"]} - db/mysql:&nbsp; ".mysql_error());
        exit();                      
   }
   $where_cond="";
   //  SESSION do arquivo tabela_consulta_anotacao_nova.php
   if( isset($_SESSION["anotacao_cip_altexc"]) ) {
        $cip = $_SESSION["anotacao_cip_altexc"];
        if( isset($_SESSION["nr"]) ) $n_anotacao= (int) $_SESSION["nr"];
        $where_cond .= " a.numero=$n_anotacao and ";    
        $arq_selecionado=' a.relatext as Arquivo, ';
   }              
   $_SESSION["selecionados"]="";
   //  Selecionar a anotacao para remover
   $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_remover"]."   ";
/*   $sqlcmd .= "SELECT numero as nr, alteraant as altera_nr, autor as anotador, "
             ."concat(substr(data,9,2),'/',substr(data,6,2),'/',substr(data,1,4)) as data_anot, "
             ."testemunha1, testemunha2, "
             ." titulo, relatext as arquivado_como FROM $bd_2.anotacao  ";
*/             
    //
    /*
    $sqlcmd .= "SELECT a.numero as nr,  a.alteraant as Altera, alteradapn as Alterada, a.titulo as Título, b.nome as Anotador,   "
        ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
        ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b WHERE a.autor=b.codigousp and  ";
    */        
    $sqlcmd .= "SELECT a.numero as nr,  a.alteraant as Altera, alteradapn as Alterada, "
        ." a.titulo as Título, b.nome as Anotador, $arq_selecionado  "
        ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data "
        ." FROM $bd_2.anotacao a, $bd_1.pessoa b WHERE a.autor=b.codigousp and  ";

    //  if( $_SESSION["permit_pa"]==$_SESSION['array_usuarios']['orientador'] )  {
    if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
        $where_cond .= "  a.projeto=$cip   ";    
    } else   $where_cond .= "  a.projeto=".$cip." and a.autor=".$usuario_conectado;
    
    $sqlcmd .= $where_cond." order by a.numero desc";
    //
    $result_rmanotacao = mysql_query($sqlcmd);
    if( ! $result_rmanotacao ) {
       //  die('ERRO: Falha consultando a tabela anota&ccedil;&atilde;o  - op&ccedil;&atilde;o='.$opcao.' - '.mysql_error().$orientador);
        echo $funcoes->mostra_msg_erro("Consultando a Tabela anota&ccedil;&atilde;o - db/mysql:&nbsp; ".mysql_error());        
        exit();        
    }       
    //  Selecionando todos os registros da Tabela temporaria
   $query2 = "SELECT * from  ".$_SESSION["table_remover"]."  ";
   $result_outro = mysql_query($query2);                                    
   if( ! $result_outro ) {
        // die("ERRO: Selecionando as Anota&ccedil;&otilde;es do Projeto  - ".mysql_error());  
        echo $funcoes->mostra_msg_erro("Selecionando as Anota&ccedil;&otilde;es do Projeto  - db/mysql:&nbsp; ".mysql_error());
        exit();                 
   }        
   //  Pegando os nomes dos campos do primeiro Select
   $num_fields=mysql_num_fields($result_outro);  //  Obtém o número de campos do resultado
   $td_menu = $num_fields+1;   
   //  Total de registros
   $_SESSION["total_regs"] = mysql_num_rows($result_outro);
   if( $_SESSION["total_regs"]<1 ) {
       /* $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto ".$msg_final;        
        echo $msg_erro;  */
        echo $funcoes->mostra_msg_erro("INICIA&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto.FINAL");            
        exit();
   }   
   $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> Anota&ccedil;&atilde;o " : $lista_usuario="<b>".$_SESSION['total_regs']."</b> Anota&ccedil;&otilde;es ";     
   $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; '  >";
   $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
   //  Buscando a pagina para listar os registros        
   $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
   if( isset($titulo_pag) )  $_SESSION["ucfirst_data"]=$titulo_pag;
   $_SESSION["pagina"]=0;
   $_SESSION["m_function"]="remove_anotacao" ;  $_SESSION["conjunto"]="Anotacao#@=".$usuario_conectado."#@=".$cip;
   if( isset($_SESSION["anotacao_cip_altexc"]) ) {
        $m_nr="";
        if( isset($_SESSION["nr"]) ) $m_nr=$_SESSION["nr"];
        $selecionado=$m_nr;        
        if( isset($arq_selecionado) ) $m_relatext=mysql_result($result_outro,0,"Arquivo");
        //  $m_function(\"REMOVER\",\"$m_relatext\",\"$conjunto#@=$selecionado\")
        //  $a_link = "$usuario_conectado#anotacao#$cip#$m_nr";
        //  $dados_enviar = "ANOTACAO_NOVA,ANOTACAO,$a_link";
        
        //  $dados_enviar="REMOVER".","."{$m_relatext}".","."{$conjunto}"."#@="."{$selecionado}";
        $dados_enviar="REMOVER,";
        
      
 /*echo " srv_rmanot_nova.php/185  -- \$opcao = $opcao  --  \$cip = $cip -- <br>"
       ." \$where_cond = $where_cond  ---  \$arq_selecionado = $arq_selecionado  - \$n_anotacao =  $n_anotacao  <br>"
       ."   \$_SESSION[conjunto] =  ".$_SESSION["conjunto"]." -- \$_SESSION[anotacao_cip_altexc] =  ".$_SESSION["anotacao_cip_altexc"]
       ."  -- \$dados_enviar = $dados_enviar  ;*/
       $dados_enviar.= "{$m_relatext},"."{$_SESSION["conjunto"]}#@={$selecionado}";
       echo $dados_enviar;
       exit();    
   } else{
        $_SESSION["opcoes_lista"] = "../includes/tabela_de_remocao_anotacao.php?pagina=";
        require_once("../includes/tabela_de_remocao_anotacao.php");                      
   }        
   exit();
}
#
ob_end_flush(); 
#
?>