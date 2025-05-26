<?php
//  AJAX da opcao CONSULTAR  - Servidor PHP para mostrar Anotacoes do PROJETO
//
//  LAFB&SPFB110908.1151
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
///  header("content-type: application/x-javascript; charset=iso-8859-1");
header("Content-Type: text/html; charset=ISO-8859-1",true);
///  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');

///
/// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
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
///  Par?metros de controle para esse processo:
if( isset($_POST['cip']) ) $cip = $_POST['cip'];
if( isset($_SESSION["usuario_conectado"]) ) $anotador = $_SESSION["usuario_conectado"];
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado = $_SESSION["usuario_conectado"];
if( isset($_POST['grupoanot']) ) $opcao = $_POST['grupoanot'];
if( isset($_POST['op_selcpoid']) ) $op_selcpoid = $_POST['op_selcpoid'];
if( isset($_POST['op_selcpoval']) ) $op_selcpoval = $_POST['op_selcpoval'];
///
//// Verificando -  Conexao 
$elemento=5; $elemento2=6;
//// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     

///  HOST mais a pasta principal do site - host_pasta
$host_pasta="";
if( isset($_SESSION["host_pasta"]) ) {
     $host_pasta=$_SESSION["host_pasta"];  
} else {
     $msg_erro .= "Sessão host_pasta não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
/// 
///  DEFININDO A PASTA PRINCIPAL 
/////  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
///  Verificando SESSION  pasta_raiz
if( ! isset($_SESSION["pasta_raiz"]) ) {
     $msg_erro .= "Sessão pasta_raiz não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
///
///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
require_once('php_include/ajax/includes/tabela_pa.php');
///  Conjunto de arrays 
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];         
///
///  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
$funcoes=new funcoes();

///  Arquivo da tabela de consulta projeto - importante
$arq_tab_consulta_anotacao="{$incluir_arq}includes/tabela_consulta_anotacao_nova.php";
///
/// $funcoes->usuario_pa_nome();
/// $_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
//
$opcao_maiusc =strtoupper(trim($opcao)); 
///  UPLOAD -  do Servidor para maquina local
if( $opcao_maiusc=="DESCARREGAR" )  {
    /// Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
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
    ///
    
        
 echo "ERRO: anotacao_nova_ajax/111  - <b>1</b> - \$opcao_maiusc = $opcao_maiusc -- \$val = $val ";
 exit();        
        
    
    
       
    /// $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
    if( ! isset($_SESSION["projeto_autor"]) )   $projeto_autor=""; 
    if( isset($_SESSION["projeto_autor"]) )   $projeto_autor = trim($_SESSION["projeto_autor"]); 
    //  $pasta = "../doctos_img/A".$m_array[0];
    $pasta = "../doctos_img/A".$projeto_autor;
    $pasta .= "/".$m_array[1]."/";     
    ///  $output = shell_exec('for arq in `ls '.$pasta.'/*.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done');    
    ///  $host  = "http://".$_SERVER['HTTP_HOST']; 
    $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
    $host  = $protocolo."://".$_SERVER['HTTP_HOST']; 
    $arquivo = trim($val);
       
    if( ! file_exists("{$pasta}".$arquivo) ) {
         /* $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
         echo $msg_erro;  
         */
         echo  $funcoes->mostra_msg_erro("&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor");         
    }  else {
         echo $pasta."%".$arquivo;  
    } 
    exit();     
}
///
///
///  Mostrar todas as anotacoes de um Projeto
if( $opcao_maiusc=="TODOS" )  {
        /*  ANTERIOR SENDO ALTERADA EM 20120229
                    $sqlcmd = "SELECT numero as n, alteraant as altera_n, autor as anotador, data, testemunha1, testemunha2, "
                    ."titulo, relatext as arquivado_em FROM $bd_2.anotacao  ";
            $where_cond = " WHERE projeto=".$cip." and autor=".$anotador;
            switch ($opcao) 
            {
            case "TODOS":
                $where_cond .= "";
                break;
            default:
                $where_cond .= "";
            }
            //  $sqlcmd .= $where_cond." order by titulo";
            $sqlcmd .= $where_cond." order by numero";
            //
            $result = mysql_query($sqlcmd);
        */
        /// Criando uma tabela Temporaria para consultar ANOTACOES de um Projeto 
        $_SESSION["table_consultar_anotacao"] = "$bd_2.temp_consultar_anotacao";
        $table_consultar_anotacao = $_SESSION["table_consultar_anotacao"];
        ///  Removendo tabela temporaria caso exista
        $sql_temp = "DROP TABLE IF EXISTS  $table_consultar_anotacao  ";  
        $drop_result = mysql_query($sql_temp); 
        if( ! $drop_result  ) {
            ///  NAO USAR DIE  TEM  FALHA
            ///  die('ERRO: Falha consultando a tabela '.$_SESSION["table_consultar_anotacao"].' - '.mysql_error());         
            /* $msg_erro .= "Consultando a tabela ".$_SESSION["table_consultar_anotacao"]." - Falha: ".mysql_error().$msg_final;
            echo $msg_erro; */            
            echo $funcoes->mostra_msg_erro("Removendo a Tabela $table_consultar_anotacao -&nbsp;db/mysql:&nbsp;".mysql_error());            
            exit();        
        }
        $_SESSION["selecionados"]="";
        if( isset($_SESSION["permit_pa"]) ) $permit_pa = $_SESSION["permit_pa"];
        if( isset($array_pa['orientador']) ) $orientador = $array_pa['orientador'];
       //// 
        ///  Selecionar os usuarios de acordo com o opcao - Criando Tabela Temporaria
        $sqlcmd ="CREATE TABLE  IF NOT EXISTS $table_consultar_anotacao  ";
        ///  Alterado em 20180604  --
        $sqlcmd .= "SELECT c.numprojeto, a.numero as nr, a.alteraant as Altera, a.cia, "
                 ."  a.alteradapn as Alterada, a.titulo as Titulo, b.nome as Autor, "
                 ."  c.titulo as projeto_titulo, concat($cip,'#',a.numero) as Detalhes, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo, c.autor as projeto_autor,  "
                 ." space(10) as Alterar, space(10) as Excluir "
                 ." FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
                
        ///  if( $_SESSION["permit_pa"]==$_SESSION['array_usuarios']['orientador'] )  {
        if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
             $where_cond = "  a.projeto=$cip   ";    
        } else {
             ///  } else   $where_cond = "  a.projeto=".$cip." and a.autor=".$usuario_conectado;
             $where_cond = "  a.projeto=".$cip." and a.autor=".$anotador;         
        }  
        ///
        $sqlcmd .= $where_cond." order by a.numero desc";
        ///  Executando o mysql_query 
        $result_consult_anotacao = mysql_query($sqlcmd);
        if( ! $result_consult_anotacao ) {
             /*  $msg_erro .= "Criando a Tabela {$_SESSION["table_consultar_anotacao"]} 
                - Falha: ".mysql_error().$msg_final;
                 echo $msg_erro; 
             */               
             echo $funcoes->mostra_msg_erro("Criando a tabela $table_consultar_anotacao -&nbsp;db/mysql:&nbsp;".mysql_error());            
             exit();        
        } 
        ///  Selecionando todos os registros da Tabela temporaria de consulta Anotacoes
        $table_consultar_anotacao=$_SESSION["table_consultar_anotacao"];
        $query2 = "SELECT *  FROM $table_consultar_anotacao ";
        $resultado_outro = mysql_query($query2);                                    
        if( ! $resultado_outro ) {
             /* $msg_erro .= "Selecionando as Anota&ccedil;&otilde;es do Projeto  - Falha: ".mysql_error().$msg_final;
             echo $msg_erro;    */     
             echo $funcoes->mostra_msg_erro("Selecionando as Anota&ccedil;&otilde;es do Projeto -&nbsp;db/mysql:&nbsp;".mysql_error());
             exit();
        } 
        ///  Desativando SESSION
        if( isset($_SESSION["anotacao_numero_nova"]) ) unset($_SESSION["anotacao_numero_nova"]);        

        ///  Total de registros
        $_SESSION["total_regs"] = $total_regs = mysql_num_rows($resultado_outro);
        $xmesg="";
        ///  Caso não tenha nenhuma Anotacao desse Projeto
        if( intval($total_regs)<1 ) {
            /*  $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto.".$msg_final;
            echo $msg_erro;   */
            ///  Caso queria incluir Nova Anotacao
            $_SESSION["anotacao_nova"]=$cip; 
            $_SESSION["anotacao_numero_nova"]=1;
            if( isset($permit_pa) ) {
                if( intval($permit_pa)==50 ) $xmesg="desse Anotador";
            }
            ////  echo  $funcoes->mostra_msg_erro("Nenhuma Anota&ccedil;&atilde;o $xmesg para esse Projeto.");            
            $paragrafo="<p style='text-align: center;font-size:medium;color:#FF0000;' >";
            $paragrafo_final="</p>";
            $xmesg= $paragrafo."Esse Projeto não tem Anota&ccedil;&atilde;o $xmesg".$paragrafo_final;      
            echo $xmesg;      
            exit();
        } 
        ///
        ///  Pegando os nomes dos campos do primeiro Select
        $num_fields=mysql_num_fields($resultado_outro);  ///  Obtem o numero de campos do resultado
        $projeto_titulo = mysql_result($resultado_outro,0,"projeto_titulo");
        $projeto_autor = mysql_result($resultado_outro,0,"projeto_autor");
        $_SESSION["projeto_autor"] = $projeto_autor; 
        $td_menu = $num_fields+1;   
        $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> Anota&ccedil;&atilde;o " : $lista_usuario="<b>".$_SESSION['total_regs']."</b> Anota&ccedil;&otilde;es ";     
        $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; '  >";
        $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
        //  Buscando a pagina para listar os registros        
        $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
        if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag;
        $_SESSION["pagina"]=0; $_SESSION["cip"]=$cip;
        $_SESSION["m_function"]="remove_anotacao" ;  $_SESSION["conjunto"]="Anotacao#@=".$usuario_conectado."#@=".$cip;
        $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_anotacao}?pagina=";
        require_once("{$arq_tab_consulta_anotacao}");
        ////
} elseif( $opcao_maiusc=="DETALHES" )  {
    ///  ANOTACAO A VARIAVEL val = array 
    
        
 echo "ERRO: anotacao_nova_ajax/284  - <b>3</b> - \$opcao_maiusc = $opcao_maiusc -- \$val = $val ";
 exit();        
        
    
    
    
    if( strpos($val,"#")!==false ) $array_proj_anot = explode("#",$val);
    if( isset($array_proj_anot) ) {
        $cip=$array_proj_anot[0];
        $anotacao=$array_proj_anot[1];        
    }
    //  Selecionando Projeto
     $sqlcmd  = "SELECT a.numprojeto, a.titulo as  titulo_projeto, b.nome as autor_projeto,  "
                ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as data_projeto "
                ." FROM $bd_2.projeto a, $bd_1.pessoa b WHERE a.cip=$cip and a.autor=b.codigousp  ";
     $resultado_projeto = mysql_query($sqlcmd);
     if( ! $resultado_projeto ) {
          // die("ERRO: Selecionando Projeto: cip = ".$cip." - ".mysql_error());  
             /* $msg_erro .= "Selecionando Tabela projeto  - db/mysql:&nbsp; ".mysql_error().$msg_final;
             echo $msg_erro; */

            echo $funcoes->mostra_msg_erro("Selecionando Tabela projeto  - db/mysql:&nbsp; ".mysql_error());            
             exit();
     }         
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     $array_nome=mysql_fetch_array($resultado_projeto);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     if( isset($resultado_projeto) )  mysql_free_result($resultado_projeto);     
      /*    
      a.numero as nr, a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as T?tulo, b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
         
     CAMPOS ABAIXO DO PROJETO: 
    $campos = "&nbsp; anotacao_nova_ajax.php/192 -   \$numprojeto = $numprojeto -- \$titulo_projeto  = $titulo_projeto <br> ";
    $campos .= "\$autor_projeto =  $autor_projeto - \$data_projeto = $data_projeto  -- \$anotacao = $anotacao ";       
        //
         
        */
     //  Selecionando a ANOTACAO do Projeto        
    $sqlcmd = "SELECT  a.numero as numero_anotacao, a.alteraant as altera, a.alteradapn as alterada, "
                 ." a.titulo as titulo_anotacao, a.testemunha1, a.testemunha2, b.nome as autor_anotacao,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anotacao, "
                 ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b "
                 ." WHERE a.autor=b.codigousp and a.projeto=$cip and a.numero=$anotacao  ";                
     $resultado_anotacao = mysql_query($sqlcmd);
     if( ! $resultado_anotacao ) {
          /* $msg_erro .= "Selecionando Anota&ccedil;&atilde;o $anotacao do  Projeto: ".$numprojeto." - ".mysql_error().$msg_final;  
          echo $msg_erro;  */
          
          echo $funcoes->mostra_msg_erro("Selecionando Anota&ccedil;&atilde;o $anotacao do Projeto: $numprojeto - db/mysql:&nbsp; ".mysql_error());            
          exit();
     }         
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     if( isset($array_nome) ) unset($array_nome);
     $array_nome=mysql_fetch_array($resultado_anotacao);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     mysql_free_result($resultado_anotacao);
     //  Selecionando os Nomes das Testemunhas da ANOTACAO
     if( strlen(trim($testemunha1))>=1 or strlen(trim($testemunha2))>=1  ) {
         if( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))>=1 ) {
             $in = " in($testemunha1,$testemunha2)";
         } elseif( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))<1 ) {
             $in = " in($testemunha1)";
         } elseif( strlen(trim($testemunha1))<1 and strlen(trim($testemunha2))>=1 ) {
               $in = " in($testemunha2)";
         } 
         //  Selecionando as Testemunhas da Anotacao          
         $cmd_sql = "SELECT codigousp as cod_testemunha, nome as nome_testemunha  FROM  $bd_1.pessoa where codigousp $in ";
         $res_testemunhas = mysql_query($cmd_sql);
         if( ! $res_testemunhas ) {
             /* $msg_erro .= "Selecionando testesmunhas da  Anota&ccedil;&atilde;o. mysql = ".mysql_error().$msg_final;  
             echo $msg_erro;  */
             
             echo $funcoes->mostra_msg_erro("Selecionando testesmunhas da Anota&ccedil;&atilde;o - db/mysql:&nbsp; ".mysql_error());
             exit();
         }        
         $num_regs = mysql_num_rows($res_testemunhas); $testemunhas="";
         for( $ntest=0 ; $ntest<$num_regs ; $ntest++ ) {
              $nome_testemunha[$ntest]= mysql_result($res_testemunhas,$ntest,"nome_testemunha");              
              $x_testemunha = (int) $ntest+1;
              $testemunhas .="<p style='text-align:center;font-size: medium;'>"
                    ."<b>Testemunha$x_testemunha</b>:&nbsp;".$nome_testemunha[$ntest]."</p>";              
         }
     }
     ///   Projeto
     $confirmar0 ="<p style='text-align:center;font-size: medium;'>"
                     ."<b>Anota&ccedil;&atilde;o $numero_anotacao do Projeto $numprojeto </b><br>"
                     ."<b>Autor do Projeto</b>: $autor_projeto</p>";
     $confirmar0 .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo do Projeto</b>:<br>"                
                 ."$titulo_projeto </div>";
     $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                    ."<b>Data in&iacute;cio do Projeto</b>:&nbsp;$data_projeto </p>";
     // Anotacao do Projeto                    
     $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                 ."<b>Anota&ccedil;&atilde;o</b>: $numero_anotacao<br>"
                 ."<b>Anotador</b>: $autor_anotacao  </p>";
     $confirmar0 .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo da Anota&ccedil;&atilde;o</b>:<br>"                
                 ."$titulo_anotacao</div>";                                     
     $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                    ."<b>Data da Anota&ccedil;&atilde;o</b>:&nbsp;$data_anotacao </p>";                 
     $confirmar0 .= $testemunhas;                    
     $confirmar1 =$confirmar0."<div style='width: 100%; text-align: center;'>";                                         
     $confirmar1 .="<button  class='botao3d_menu_vert' style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: limpar_form();' >Ok";                                  
     $confirmar1 .="</button></div>";                                         
     echo $confirmar1;               
}
#
ob_end_flush(); 
#
?>