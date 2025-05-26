<?php
//   AJAX - ALTERAR PROJETO - 20120803
//   Faz parte do arquivo projeto_alterar.php
//
///  Funcao para busca com acentos
function stringParaBusca($str) {
    /// Transformando tudo em min?sculas
    $str = trim(strtolower($str));

    /// Tirando espa?os extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
    while ( strpos($str,"  ") )
        $str = str_replace("  "," ",$str);
    
    /// Agora, vamos trocar os caracteres perigosos "?,?..." por coisas limpas "a"
    $caracteresPerigosos = array ("?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","!","?",",","?","?","-","\"","\\","/");
    $caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
    $str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
    
    //Agora que não temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
    //vamos montar a express?o regular para o MySQL
    $caractresSimples = array("a","e","i","o","u","c");
    $caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
    $str = str_replace($caractresSimples,$caractresEnvelopados,$str);
    $caracteresParaRegExp = array(
        "(a|?|?|?|?|?|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|?|?|?|?|?|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
        "(e|?|?|?|?|&eacute;|&egrave;|&euml;|&ecirc;|?|?|?|?|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
        "(i|?|?|?|?|&iacute;|&igrave;|&iuml;|&icirc;|?|?|?|?|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
        "(o|?|?|?|?|?|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|?|?|?|?|?|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
        "(u|?|?|?|?|&uacute;|&ugrave;|&uuml;|&ucirc;|?|?|?|?|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
        "(c|?|?|&ccedil;|&Ccedil;)" );
    $str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
    
    //Trocando espa?os por .*
    $str = str_replace(" ",".*",$str);
    
    //Retornando a String finalizada!
    return $str;
}
//
//  Funcao para minuscula para Maiuscula
function stringParaBusca2($str) {
 /*
     $a1 ="????????????????????????????";
     $a1_len = strlen($a1);
     $a2 ="????????????????????????????";
     //  $pessoa_nome2=trim($pessoa_nome);
    for( $i=0; $i<$a1_len; $i++ ) {
          $char1[]=substr($a1,$i,1);
            $char2[]=substr($a2,$i,1);
    }
    $m_count = count($char1);
    $texto=$str;
    for( $x=0; $x<$m_count ; $x++ ) {
        //   $str = str_replace($char1[$x],$char2[$x],$str);
         // First check if there is a "5" at position 0.
        $offset = 0; // initial offset is 0
        $fiveCounter = 0;
        if( strpos($str, $char1[$x])==0 ) continue;

       // Check the rest of the string for 5's
       while( $offset=strpos($str, $char1[$x],$offset+1) ) {
           $texto=substr_replace($texto,$char2[$x],$offset,1); 
           $chars .=  $char1[$x]." - ";        
       }
     //     $str = str_replace($char1,$char2,$str);
        //  $texto .= "<br>  - $str ".$char1." - ".$char2;
    
    
    }
  */
    //  Usar para substituir caracteres com acentos para Maiuscula
   $substituir = array(
                        '/&aacute;/i' => '?',
                        '/&Eacute;/i' => '?',
                        '/&Iacute;/i' => '?',
                        '/&Oacute;/i' => '?',
                        '/&Uacute;/i' => '?',
                        '/&Atilde;/i' => '?',
                        '/&Otilde;/i' => '?',
                        '/&Acirc;/i' => '?',
                        '/&Ecirc;/i' => '?',
                        '/&Icirc;/i' => '?',
                        '/&Ocirc;/i' => '?',
                        '/&Ucirc;/i' => '?',
                        '/&Ccedil;/i' => '?',
                        '/&Agrave;/i' => '?'
                        );
    
    
    
    //  $texto =strtoupper($str);
   $substituir0 = array(
                        '/?/' => '&aacute;',
                        '/?/' => '&eacute;',
                        '/?/' => '&iacute;',
                        '/?/' => '&oacute;',
                        '/?/' => '&uacute;',
                        '/?/' => '&atilde;',
                        '/?/' => '&otilde;',
                        '/?/' => '&acirc;',
                        '/?/' => '&ecirc;',
                        '/?/' => '&icirc;',
                        '/?/' => '&ocirc;',
                        '/?/' => '&ucirc;',
                        '/?/' => '&ccedil;',
                        '/?/' => '&Aacute;',
                        '/?/' => '&Eacute;',
                        '/?/' => '&Iacute;',
                        '/?/' => '&Oacute;',
                        '/?/' => '&Uacute;',
                        '/?/' => '&Atilde;',
                        '/?/' => '&Otilde;',
                        '/?/' => '&Acirc;',
                        '/?/' => '&Ecirc;',
                        '/?/' => '&Icirc;',
                        '/?/' => '&Ocirc;',
                        '/?/' => '&Ucirc;',
                        '/?/' => '&Ccedil;',
                        '/?/' => '&agrave;',
                        '/?/' => '&Agrave;'
                        );

/*
    $substituir2 = array('/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',                        
                        '/?/' => '?',                        
                        '/?/' => '?',                                                
                        '/?/' => '?',                                                                        
                        '/?/' => '?',                                                                                                
                        '/?/' => '?'
                    );
                    */
                    
        $substituir2 = array('?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',                        
                        '?' => '?',                        
                        '?' => '?',                                                
                        '?' => '?',                                                                        
                        '?' => '?',                                                                                                
                        '?' => '?'
                    );
                    
                        
  // $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
   $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);

    return $texto;
    
}

ob_start(); /* Evitando warning */
//  Verificando se SESSION_START - ativado ou desativado
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
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');

//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
///
///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');

///   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
// extract: Importa variáveis para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

////  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   Final - Mensagens para enviar 
///
///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= utf8_decode("Sessão incluir_arq não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
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
if( isset($_SESSION["usuario_conectado"]) ) {
    $orientador = $_SESSION["usuario_conectado"];   
    $usuario_conectado= $_SESSION["usuario_conectado"];
}
//// Verificando -  Conexao 
$elemento=5; $elemento2=6;
//// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     
/// require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
require_once('php_include/ajax/includes/tabela_pa.php');
///
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];        
//
//  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
$funcoes=new funcoes();
// $funcoes->usuario_pa_nome();
// $_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
//
// Para incluir nas mensagens
//  include_once("../includes/msg_ok_erro_final.php");
//   Definindo a variavel usuario para mensagem
//  $usuario="Orientador"; 
///  if( $_SESSION["permit_pa"]!=$array_pa['orientador'] ) $usuario="Usu&aacute;rio"; 
///      
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");    

$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP    
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
///   Para acertar a acentuacao - utf8_encode
///   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source);
$source_upper=strtoupper($_SESSION["source"]);
if( isset($val) ) $val_upper=strtoupper(trim($val));
///
///  Arquivo da tabela de consulta projeto - importante
$arq_tab_alterar_projeto="{$incluir_arq}includes/tabela_altera_projeto.php"; 
///
///  SAIR do Programa
if( $source_upper=="SAIR" ) {
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
///
///  Mostrar  Projeto para Alterar
////  Mostrar todas as anotacoes de um Projeto
///// if( $source_upper=="TODOS" or $source_upper=="BUSCA_PROJ" ) {
if( $source_upper=="TODOS"  ) {
       /// Definindo SESSION
       if( ! isset($_SESSION['selecionados']) ) $_SESSION['selecionados']="";
       ///
       $permit_orientador = (int) $_SESSION["permit_pa"];  
       if( $_SESSION["permit_pa"]>=$array_pa["anotador"] ) {
            $texto_erro = "&nbsp;Procedimento n&atilde;o autorizado.<br>"
                  ."N&atilde;o consta como Orientador ou Superior";
            ///  echo  $msg_erro;
            echo  $funcoes->mostra_msg_erro($texto_erro);                         
            exit();
       }
       ///    
       $_SESSION["table_alterar_projeto"] = "$bd_2.temp_alterar_projeto";
       $sql_temp = "DROP TABLE IF EXISTS   ".$_SESSION["table_alterar_projeto"]."    ";  
       $drop_result = mysql_query($sql_temp); 
       if( ! $drop_result  ) {
           /// die('ERRO: Falha removendo a tabela '.$_SESSION["table_alterar_projeto"].' - '.mysql_error());         
            /* $msg_erro .= "Removendo a Tabela {$_SESSION["table_alterar_projeto"]} - db/mysql:&nbsp; ".mysql_error();
              echo $msg_erro.$msg_final;   */
            echo $funcoes->mostra_msg_erro("Removendo a Tabela {$_SESSION["table_alterar_projeto"]} - db/mysql:&nbsp; ".mysql_error());
            exit();       
       }
       $_SESSION["selecionados"]=""; $where_cond="";
       ///  Selecionar os Projetos de acordo com o opcao - Alterado em 20180418
       /***
       $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION['table_consultar_projeto']."   ";
       $sqlcmd .= "SELECT a.numprojeto as nr, a.titulo as Titulo, "
                 ." b.nome as Autor, a.cip as Detalhes, "
                 ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as Data, "
                 ." a.relatproj as Arquivo FROM $bd_2.projeto a, $bd_1.pessoa b  "
                 ." WHERE a.autor=b.codigousp   ";
        ***/
        /// Contador de linhas - resultado do Select/Mysql
       mysql_query("SET @xnr:=0");
       $table_alterar_projeto=$_SESSION["table_alterar_projeto"];
       $sqlcmd ="CREATE TABLE  IF NOT EXISTS $table_alterar_projeto ";       
       $sqlcmd .= "SELECT @xnr:=@xnr+1 as nr, numprojeto as NP, left(trim(titulo),80) as Titulo,  "
            ."(SELECT descricao from $bd_2.objetivo WHERE codigo=$bd_2.projeto.objetivo ) as objetivo_descricao, "    
            ." fonterec as Fonte_Recurso, fonteprojid as Identificacao,"
            ."concat(substr(datainicio,9,2),'/',substr(datainicio,6,2),'/',substr(datainicio,1,4)) as inicio, "    
            ."concat(substr(datafinal,9,2),'/',substr(datafinal,6,2),'/',substr(datafinal,1,4)) as final, "             
            ." coresponsaveis as Coresp,  anotacao, cip FROM $bd_2.projeto  ";
       
/****
       $sqlcmd .= "SELECT  @xnr:=@xnr+1 as nr, a.titulo as Titulo, "
                 ." b.nome as Autor, a.cip as Detalhes, "
                 ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as Data, "
                 ." a.relatproj as Arquivo FROM $bd_2.projeto a, $bd_1.pessoa b  "
                 ." WHERE a.autor=b.codigousp   ";
****/                 
       /// 
       if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"];           
       if( isset($array_pa['orientador']) ) $orientador=$array_pa['orientador'];   
       if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
           ///  Verificano se o Usuario conectado no programa REXP 
          if( isset($_SESSION["usuario_conectado"]) ) {
              $usuario_conectado = $_SESSION["usuario_conectado"];       
          }                      
          /// Modificado em 20180327
           ///  $where_cond = " and  a.autor=$orientador ";    
           $where_cond = "  WHERE autor=$usuario_conectado ";    
       } else {
           $where_cond .= "";                   
       }
       ///
       ///  Variavel caracteres maiusculos  - SWITCH
       switch ($source_upper) {
           case "TODOS":
                 $_SESSION['selecionados']=" - <b>Total</b>";
                 break;
           case "BUSCA_PROJ":
                  $where_cond .= "   WHERE autor=$usuario_conectado and  cip=$val ";
                  break;    
           default:
                 $where_cond .= "";
                 break;
        }
        ///
        if( strtoupper($val)=="ORDENAR" ) {
             ///  $m_array=preg_replace('/cip/i', 'a.cip', $m_array);              
             //// $m_array=preg_replace('/NoMe/i', 'b.nome', $m_array);             
              $m_array=preg_replace('/titulo/i', 'Titulo', $m_array);             
              ///  $m_array=preg_replace('/datainicio/i', 'a.datainicio', $m_array);             
             $sqlcmd .= $where_cond." order by $m_array  "; 
        } else {
             $sqlcmd .= $where_cond." order by cip desc";    
        }
        ///  Execuntando o mysql_query
        $result_alterar_projeto = mysql_query($sqlcmd);
        if( ! $result_alterar_projeto ) {
            /// die('ERRO: Falha consultando a tabela anota&ccedil;&atilde;o  - op&ccedil;&atilde;o='.$opcao.' - '.mysql_error());
            /* $msg_erro .= "&nbsp;Criando a Tabela  {$_SESSION['table_consultar_projeto']} - db/mysql:&nbsp; ";
            echo  $msg_erro.mysql_error().$msg_final; */
             echo $funcoes->mostra_msg_erro("Criando a Tabela {$_SESSION["table_alterar_projeto"]}&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());                        
             exit();
        }       
        ////
        ///  Selecionando todos os registros da Tabela temporaria de consulta Anotacoes
        $query2 = "SELECT * from  {$_SESSION["table_alterar_projeto"]} ";
        $resultado_outro = mysql_query($query2);                                    
        if( ! $resultado_outro ) {
             ///  die("ERRO: Selecionando os Projetos - mysql =  ".$cip.mysql_error());  
             /*  $msg_erro .= "&nbsp;Selecionando os Projetos - db/mysql:&nbsp; ".mysql_error().$msg_final;
              echo  $msg_erro;  */
             echo $funcoes->mostra_msg_erro("Selecionando os Projetos -&nbsp;db/mysql:&nbsp;".mysql_error());            
             exit();
        }         
        ///  Total de registros
        $_SESSION["total_regs"] = $n_regs_projeto = mysql_num_rows($resultado_outro);
        ///  Caso NAO encontrou Projeto        
        if( intval($n_regs_projeto)<1 ) {
             /// $msg_erro .= "INICIA&nbsp;N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.FINAL".$msg_final;
             ///  echo  $msg_erro;
             echo $funcoes->mostra_msg_erro("N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.");
             exit();            
        }
        ///
        ///  Pegando os nomes dos campos do primeiro Select
        ///  Obtem o n?mero de campos do resultado
        $num_fields=mysql_num_fields($resultado_outro);  
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
        */  
        $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> Projeto " : $lista_usuario="<b>".$_SESSION['total_regs']."</b> Projetos ";     
        $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px;' >";
        $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
        ///  Buscando a pagina para listar os registros        
        $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
        if( isset($_SESSION["ucfirst_data"]) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
        $_SESSION["pagina"]=0;
        $_SESSION["m_function"]="alterar_projeto" ;  $_SESSION["conjunto"]="Projeto#@=".$usuario_conectado."#@=";
        $_SESSION["opcoes_lista"] = "{$arq_tab_alterar_projeto}?pagina=";
        require_once("{$arq_tab_alterar_projeto}");  
        if( isset($cip) ) unset($cip);
        ///
        exit();
        ///
}
/******  Final - if( $source_upper=="TODOS"  )   ******/
///
///  if( $source_upper=="TODOS" or $source_upper=="BUSCA_PROJ" ) {
if(  $source_upper=="BUSCA_PROJ" ) {
    ///
    $cip = (int) $val; 
    $opcao=$source_upper;  $where_cond="";
    $_SESSION["selecionados"]="";
    ///  Selecionar os Projetos de acordo com o op??o
    $sqlcmd = "SELECT a.numprojeto, a.titulo, a.objetivo, a.fonterec, a.fonteprojid, a.anotacao, "
             ."a.autor as autor_codigousp, b.nome as autor_nome, a.cip as Detalhes,  a.coresponsaveis, "
             ."concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as datainicio, "    
             ."concat(substr(a.datafinal,9,2),'/',substr(a.datafinal,6,2),'/',substr(a.datafinal,1,4)) as datafinal, "        
             ." a.relatproj as Arquivo FROM $bd_2.projeto a, $bd_1.pessoa b  "
             ." WHERE a.autor=b.codigousp   ";
    /// 
    switch ($opcao) {
       case "TODOS":
           if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
                $where_cond = " and  a.autor=$orientador ";    
           }
           $where_cond .= "";
           break;
       case "BUSCA_PROJ":
          //  $where_cond .= " and  cip=$val ";
          $where_cond .= " and  cip=$cip ";
          break;    
       default:
          $where_cond .= "";
    }
    $sqlcmd .= $where_cond." order by a.cip desc";
    ///
    /// Executando Select/MySQL
    /////   Utilizado pelo Mysql/PHP - IMPORTANTE       
    /***
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    ***/
    /***
    *    O charset UTF-8  uma recomendacao, 
    *    pois cobre quase todos os caracteres e 
    *    símbolos do mundo
    ***/
     mysql_set_charset('utf8');
    ///                         
    $result_alterar_projeto = mysql_query($sqlcmd);
    if( ! $result_alterar_projeto ) {
         /*   $msg_erro .= "Falha consultando a tabela anota&ccedil;&atilde;o  - op&ccedil;&atilde;o=".$opcao.' - '.mysql_error().$msg_final;  
            echo $msg_erro;   */            
          echo $funcoes->mostra_msg_erro("&nbsp;Consultando as Tabelas projeto e pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());
          exit();
    }       
    $n_regs=mysql_num_rows($result_alterar_projeto);
    // Caso encontador o Projeto
    if( intval($n_regs)==1 ) {
           //  Definindo os nomes dos campos recebidos do MYSQL SELECT
           if( isset($array_nome) ) unset($array_nome);
           $array_nome=mysql_fetch_array($result_alterar_projeto);
           ///   Campos e Valores do resultado do Select/MySQL
           foreach( $array_nome as $chave_cpo => $valor_cpo ) {
                  $$chave_cpo=$valor_cpo;   
           }
           $_SESSION["coresponsaveis"]=$coresponsaveis;
           $_SESSION["cip"]=$Detalhes;  ///   variavel Detalhes como cip
           $Arquivo=mysql_result($result_alterar_projeto,0,"Arquivo");
    } else {
        /* $msg_erro .= "Projeto n&atilde;o encontrado.".$msg_final;  
        echo $msg_erro; */     
        echo $funcoes->mostra_msg_erro("Projeto n&atilde;o encontrado.");                 
        exit();        
    }
    $_SESSION["autor_codigousp"]=$autor_codigousp;    
    if( isset($result_alterar_projeto) ) mysql_free_result($result_alterar_projeto); 
    ///
    ///  Arquivo do Projeto em PDF
    if( ! isset($Arquivo) ) $Arquivo="";
    $_SESSION["relatproj_arq"]=$Arquivo;
    ///
    $total_cols=4;    
    ////
    //// FORM --->>>  accept-charset='utf-8' <<<---  Utilizado pelo Mysql/PHP - IMPORTANTE -20180615      
?>
<form  accept-charset="utf-8"  name="form_alterar_projeto" id="form_alterar_projeto" enctype="multipart/form-data"   method="post" 
   style="overflow: hidden;border: 2px solid #000000; height: 100%;" >
   <div  class="td_inicio1"  style="vertical-align: middle;text-align: left;overflow: hidden;"  >
      <label title="Orientador do Projeto" >Orientador:&nbsp;</label>
      <!-- N. Funcional USP - Autor/Orientador -->
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >&nbsp;<?php echo $autor_nome;?>&nbsp;</span>
         <input type="hidden" id="autor"  name="autor" value="<?php echo $autor_codigousp;?>" >
         <input type="hidden" id="cip"  name="cip" value="<?php echo  $_SESSION["cip"];?>" >
      <span  class="td_inicio1" style="vertical-align: middle;text-align: left;"   >
      <label>Nr. do Projeto:&nbsp;</label>
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" title='N&uacute;mero do Projeto' >&nbsp;<?php echo $numprojeto;?>&nbsp;</span>
         <input type="hidden" id="numprojeto"  name="numprojeto" value="<?php echo $numprojeto;?>" >
      </span>
   </div>

   <!--  Titulo do Projeto  -->
   <div  class="td_inicio1"  style="text-align: left;vertical-align: top;   background-color: #32CD99; " >
      <label for="titulo"  style="vertical-align: top; color:#000000; background-color: #32CD99; cursor:pointer;" ><span class="asteristico" >*</span>&nbsp;T&iacute;tulo:&nbsp;
        <textarea rows="3" cols="90" name="titulo" id="titulo" required="required"  onKeyPress="javascript:limita_textarea('titulo');" 
           title='Digitar T&iacute;tulo do Projeto' style="cursor: pointer; overflow:auto;" 
            onblur="javascript: alinhar_texto(this.id,this.value);"  >
            <?php echo  $titulo;?>
        </textarea>
      </label>      
   </div>
   <!-- Final -  Titulo do Projeto  -->                 

   <!--  Objetivo  -->
   <div  class="td_inicio1" style="vertical-align: middle; text-align: left;" >
          <label for="objetivo"  style=" cursor:pointer;" title="Objetivo do Projeto" ><span class="asteristico" >*</span>&nbsp;Objetivo:&nbsp;</label>
         <?php 
            /// Objetivo
            $sqlcmd  = "SELECT  codigo,descricao FROM $bd_2.objetivo  order by codigo "; 
            $result_objetivo = mysql_query($sqlcmd);
            if( ! $result_objetivo ) {
                /* $msg_erro .= "Falha consultando a tabela objetivo  - db/mysql: ".mysql_error().$msg_final;  
                echo $msg_erro; */                          
                echo $funcoes->mostra_msg_erro("Consultando a Tabela objetivo  - db/mysql:&nbsp; ".mysql_error());
                exit();
            }        
          ?>
            <!-- Objetivo  -->
            <SELECT  name="objetivo" id="objetivo" class="td_select" required="required"  title="Selecionar Objetivo"   >                   
              <?php
                $m_linhas = mysql_num_rows($result_objetivo);
                while( $linha=mysql_fetch_array($result_objetivo) ) {       
                      $codigo_objetivo = $linha['codigo'];
                      $objetivo_selected = "";                      
                      if ( $codigo_objetivo==$objetivo ) $objetivo_selected = "selected='selected'";
                      echo "<option $objetivo_selected  value=".htmlentities($linha['codigo'])." >"
                           .ucfirst(htmlentities($linha['descricao']))."&nbsp;</option>" ;
                }
                ?>
        </select>
    </div>
   <!--  Final - Objetivo  -->

   <!--  Fonte de Recurso -->
    <div class="detalhes1" style="text-align: left; vertical-align: middle;overflow: hidden;"  >
       <label for="fonterec" style="vertical-align: middle; cursor: pointer;" title="Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)"   >Fonte Principal de Recursos:&nbsp;</label>
        <input type="text" name="fonterec" value="<?php echo $fonterec;?>"  id="fonterec" size="30" maxlength="16" 
           title='Digitar Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)'  
            onblur="javascript: alinhar_texto(this.id,this.value); soLetrasMA(this.id)"  style="cursor: pointer;"  />
    </div>
    <!-- Final - Fonte de Recurso -->

    <!-- fonteprojid - Nr. do Processo  -->
     <div class="detalhes1"  style="text-align: left; vertical-align: middle;" >
          <label for="fonteprojid" style="vertical-align: middle; cursor: pointer;" title="Nr. Processo"  >Nr. Processo:&nbsp;</label>
            <input type="text" name="fonteprojid"   id="fonteprojid"  value="<?php echo $fonteprojid;?>"    size="36" maxlength="24" title='Digitar Nr. Processo'  style="cursor: pointer;"   onblur="javascript: alinhar_texto(this.id,this.value)" />
     </div>
       <!-- Final - fonteprojid -->


      <!-- Data inicio do Projeto -->
      <div class="detalhes1" style="text-align: left; vertical-align: middle;"  >
            <label for="datainicio" style="vertical-align: middle; cursor: pointer;" title="Data de Início do Projeto" >Data in&iacute;cio:&nbsp;</label>
                <input type="text" name="datainicio"  pattern="\d{1,2}/\d{1,2}/\d{4}"  id="datainicio"  value="<?php echo $datainicio;?>"  size="14" maxlength="14" title="Digitar Data in&iacute;cio - exemplo: 01/01/1998"   style="cursor: pointer;"   onkeyup="formata(this,event);"  onkeydown="javascript: backspace(event,this)" />
          <!-- Final - Data inicio do Projeto -->
          <!-- Data Final do Projeto -->
                <label for="datafinal" style="vertical-align: middle; cursor: pointer;" title="Data Final do Projeto" >Data final:&nbsp;</label>
                <input type="text" name="datafinal" pattern="\d{1,2}/\d{1,2}/\d{4}"  id="datafinal"  value="<?php echo $datafinal;?>"  size="12" maxlength="10" title="Digitar Data Final - exemplo: 01/01/1998"  style="cursor: pointer;"    onkeyup="formata(this,event);"  onkeydown="javascript: backspace(event,this)"   onblur="javascript: verificadatas('datainicio','datafinal',document.getElementById('datainicio').value,document.getElementById('datafinal').value)"   />
                <input type="hidden" id="arq_pdf"  name="arq_pdf" value="<?php echo $_SESSION["relatproj_arq"];?>" >
        </div>
          <!-- Final - Data Final do Projeto -->
          
        <div class="detalhes1" style="text-align: left; vertical-align: middle;" >
        <!-- Arquivo do Relatorio do Projeto  -->
         <span  style="vertical-align: middle; " >
             <label for="fonteprojid" style="vertical-align: middle; cursor: pointer;" >Arquivo do Projeto:&nbsp;</label>
         </span>
         <span  style='padding-left: 5px; vertical-align: middle; color: #FFFFFF; font-weight: bold; border: none;;overflow: auto; ' >
              <?php  echo  "{$_SESSION["relatproj_arq"]}"?>
         </span>
           <!-- Final - arquivo relatorio do projeto -->
       </div>
                
       <!-- Numero de Coautores -->
         <div class="detalhes1" style="text-align: left; vertical-align: middle;"  >
            <label for="coresponsaveis" >N&uacute;mero de Co-Respons&aacute;veis:&nbsp;</label>
               <input type="text" name="coresponsaveis" id="coresponsaveis" value="<?php echo $coresponsaveis;?>" size="5"   maxlength="3" title='Digitar  N&uacute;mero de Co-Respons&aacute;veis'  style="cursor: pointer;" 
                 onKeyup="javascript: n_coresponsaveis(this,event); " value=""   onblur="javascript: if( this.value<1 ) exoc('incluindo_coresponsaveis',0);" />&nbsp;
               <input  type="button" onclick="javascript: altera_projeto('coresponsaveis','<?php echo $_SESSION["coresponsaveis"];?>');"  id="busca_coresponsaveis" 
                title='Clicar'  style="cursor: pointer; width: 110px;"  value="Modificar"  class="botao3d" >
          </div>
          <!-- Final - Numero de Coautores -->                    


        <!-- Inclusao de Coautores - caso tenha no Projeto - fica Oculto sem Coresponsaveis -->
        <div align="center" >
            <div id="incluindo_coresponsaveis"  style=" text-align: justify;display: block; background-color: #FFFFFF;" ></div>
        </div>
        <!-- Final - Nomes dos Coautores -->
        
     <div  id="iddivcoresp" style="margin-left: 0px;  height: auto; width: auto;overflow: auto;">
     <?php 
       ///  Caso de Coresponsaveis maior que Zero
       if(  intval($coresponsaveis)>0  ) {
           /// Nomes dos Coresponsaveis na Tabela CORESPPROJ 
           if( isset($sqlcmd) ) unset($sqlcmd);
           /////   Utilizado pelo Mysql/PHP        
            mysql_query("SET NAMES 'utf8'");
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');
            ///                         
           $sqlcmd = "SELECT a.nome as nome_coresponsavel,a.codigousp as codigousp_coresp  "
                        ." FROM $bd_1.pessoa a, $bd_2.corespproj b  WHERE  "
                       ." a.codigousp=b.coresponsavel  and b.projetoautor=$autor_codigousp and  b.projnum=$numprojeto ";
           ///
           $result_corespproj=mysql_query($sqlcmd);
           if( ! $result_corespproj ) {
                /* $msg_erro .= "Falha consultando as tabelas pessoa e corespproj  - db/mysql: ".mysql_error().$msg_final;  
                echo $msg_erro;  */
                echo $funcoes->mostra_msg_erro("Consultando as Tabelas pessoa e corespproj  -&nbsp;db/mysql:&nbsp;".mysql_error());
                exit();
           } 
           ///  Numero de coresponsaveis pelo Projeto          
           $num_coresponsav=mysql_num_rows($result_corespproj);
           $val= (int) $coresponsaveis; $n_cores=0;
           //  Caso variavel val ser imprar entao colspan=1                   
           $impar_ou_par=(int) $val%2;
           $m_co = "Co-resp.";
           if( $source_upper=="COLABS" )    $m_co = "Colab.";
           $x_float2 = (float) (.5);  $acrescentou=0;
           $n_tr = (float) ($val/2);
           if( ! is_int($n_tr) ) {
               $n_tr=$n_tr+$x_float2;
               $acrescentou=1;
           }
           ///  $n_y=0;$texto=0; $n_tr= (int) $val;
           $n_y=0;$texto=0; $n_tr= (int) $n_tr; 
           ?>
           <table style="text-align: left; margin: 0px;" >
           <?php
           for( $x=1; $x<=$n_tr; ++$x ) {
               ?>
               <tr>
               <?php
               $n_y=$texto; $n_td=4;
               $n_tot=$n_td/2;
               for( $y=1; $y<=$n_tot ; ++$y ) {
                   $texto=$n_y+$y; $colspan=2;
                   ///  Caso variavel val ser imprar entao colspan=1                   
                   if( $y>=$val and $impar_ou_par==1 ) $colspan=1;
                   if( ( $acrescentou==1 ) and  ( $texto>$val ) ) {                         
                         continue;
                   } else  {
                       ?>
                        <td class="detalhes1"  style="text-align: left; color: #000000;" >
                           &nbsp;
                      <?php
                          echo "$m_co $texto:&nbsp;";
                   }
                   $n_tot2=1; 
                   for( $z=1; $z<=$n_tot2 ; $z++ ) {         
                         $coresp_nome = trim(mysql_result($result_corespproj,$n_cores,"nome_coresponsavel"));
                         $codigousp_coresp = mysql_result($result_corespproj,$n_cores,"codigousp_coresp");
                         echo "<input type=\"hidden\"  id=\"ncoautor[$n_cores]\" name=\"ncoautor[$n_cores]\" value=\"$codigousp_coresp\"  >";
                         echo "<span style='color:#FFFFFF;'>".$coresp_nome."</span>";
                       ?>
                     </td>
                   <?php                      
                     $n_cores++;
                   } 
                  /// Final do If TD  - numero USP/Coautor
               }
               ?>
               </tr>
               <?php
           }            
           ?>
           </table>
           <?php
       }  
       ///  FINAL - IF coresponsaveis>0  
     ?>
     </div>     
     
     <div class="detalhes1" style="text-align: left;"  >
     <!-- Nr. de Anotacoes do Projeto  -->
         <span  style="vertical-align: middle; text-align: left;"  >
             <label for="fonteprojid" style="vertical-align: middle; cursor: pointer;" >Nr. de Anota&ccedil;&otilde;es do Projeto:&nbsp;</label>
         </span>
         <span style='vertical-align: middle; background-color: #FFFFFF; color: #000000;  padding: 1px 2px 1px 2px; font-weight: bold;  border: 1px solid #000000' >
             <?php  echo  $anotacao;?>
         </span>
     <!-- Final - numero de anotacoes do projeto -->
     </div>               
     

      <!--  TAGS  type reset e button  -->                 
      <div class="reset_button" >
        <!-- Cancelar -->    
         <span>
           <button  type="button" name="cancelar" id="cancelar" class="botao3d"                  onClick="javascript: altera_projeto('BUSCA_PROJ','LIMPAR');" 
            title="Cancelar"  acesskey="C" >    
              Cancelar&nbsp;<img src="../imagens/limpar.gif" alt="Cancelar" style="vertical-align:text-bottom;" >
           </button>
         </span>
         <!-- Final - Cancelar -->                  
         <!-- Alterar -->                  
         <span>
            <button  type="button" name="alterar" id="alterar"  class="botao3d"  onClick="javascript: altera_projeto('SUBMETER','PROJETO',this.form);"  title="Alterar"  acesskey="A" >    
                Alterar&nbsp;<img src="../imagens/enviar.gif" alt="Alterar"  style="vertical-align:text-bottom;"  >
            </button>
          </span>  
         <!-- Final - Alterar -->                              
      </div>
      <!--  FINAL - TAGS  type reset e  submit  -->                   
  </form>
  <?php    
}    
///  FINAL - IF  Mostrar  Projeto para Alterar
//
//  Serve tanto para o arquivo projeto  quanto para o experimento
///  if(  ( $source_upper=="COAUTORES" ) or  ( $source_upper=="COLABS" ) ) {	
if(  ( $source_upper=="CORESPONSAVEIS" ) or  ( $source_upper=="COLABS" ) ) {	
    ///  $m_co = "Co-responsaveis";
    /// $m_co = "Co-resp.";
   $m_co = "Co-resp.";
   ///  if( $source_upper=="COLABS" )    $m_co = "Colaboradores";
   if( $source_upper=="COLABS" ) $m_co = "Colab.";
   /*   Atrapalha e muito essa programacao orientada a objeto
        include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
       $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ");
   */
   ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
   $result=mysql_query("Select codigousp,nome,categoria from $bd_1.pessoa  order by nome ");
   if( ! $result ) {
         /// die('ERRO: Select pessoa - falha: '.mysql_error());  
         echo $funcoes->mostra_msg_erro("&nbsp;Select pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());            
         exit();
   }
   ///  Numero de pessoas cadastradas
   $m_linhas = mysql_num_rows($result);
   if( intval($m_linhas)<1 ) {
       ///  echo "Nenhum encontrado";
       echo $funcoes->mostra_msg_erro("Nenhum encontrado");                   
       exit();      
   }
   ///  PRECISA DESSE WHILE e a variavel count_arr
   while($linha=mysql_fetch_assoc($result)) {
         $arr["codigousp"][]=htmlentities($linha['codigousp']);
         $arr["nome"][]=  ucfirst(htmlentities($linha['nome']));
         $arr["categoria"][]=$linha['categoria'];
    }
    $count_arr = count($arr["codigousp"])-1;    
   //
   ?>
  <table class="table_inicio"  align="center" width="100"  cellpadding="1" border="2" cellspacing="1" style="font-weight:normal; text-align: center; background-color: #FFFFFF; margin: 0px; padding: 0px;vertical-align: middle; "  >      
     <?php 
          $x_float2 = (float) (.5);  $acrescentou=0;
          $n_tr = (float) ($val/2);  $impar_ou_par=0;
          if(  ! is_int($n_tr) ) {
              $n_tr=$n_tr+$x_float2;
              $acrescentou=1;
          }
           //  $n_y=0;$texto=0; $n_tr= (int) $val;
		   $n_y=0;$texto=0; $n_tr= (int) $n_tr;
          for( $x=1; $x<=$n_tr; $x++ ) {
               echo "<tr style='margin: 0px; padding: 0px;vertical-align: middle;' >";
               $n_y=$texto; $n_td=4;
               $n_tot=$n_td/2;  $colspan=2;
               //  Caso variavel val ser imprar entao colspan=1                   
               if( ! isset($y) ) $y=0;
               
               if( $y>=$val and $impar_ou_par==1 ) $colspan=1;
               for( $y=1; $y<=$n_tot ; $y++ ) {
                   $texto=$n_y+$y;
                   if( ( $acrescentou==1 ) and  ( $texto>$val ) ) {
                         continue;
                   } else  {
                         echo  "<td class='detalhes1'   colspan=$colspan   "
						       ." style='color: #000000; background-color: #FFFFFF; vertical-align: middle;' >"
                                 ."&nbsp;$m_co $texto:</td>";
                   }
                   $n_tot2=1;
                   for( $z=1; $z<=$n_tot2 ; $z++ ) {
                        ?>
                        <td class="detalhes1" colspan="2" style="text-align: left;color: #000000; background-color: #FFFFFF; vertical-align: middle; "   >
                        <!-- N. Funcional USP - COautor ou Colaborador  -->
                       <select name="ncoautor_novo[<?php echo $texto;?>]" id="ncoautor_novo[<?php echo $texto;?>]"  class="td_select"    style="overflow:auto;font-size: small;"  title="<?php echo "$m_co $texto"; ?>"  >  
                       <?php
                     if( intval($m_linhas)<1 ) {
                            echo "<option value='' >== Nenhum encontrado ==</option>";
                      } else {
                          echo "<option value='' >== Selecionar ==</option>";
                          ///  CONTINUACAO do WHILE acima e a variavel count_arr
                           for( $jk=0; $jk<=$count_arr; $jk++ ) {
                               $m_codigousp = htmlentities($arr["codigousp"][$jk]);
                               $m_categ = "Categ.: ".$arr["categoria"][$jk];    
                               //  $m_nome=ucfirst(htmlentities($arr["nome"][$jk]));                      
                               $m_nome=ucfirst(html_entity_decode($arr["nome"][$jk]));  
                                if( $m_codigousp>=1 ) {
                                    echo "<option  value=".$m_codigousp." >".$m_nome;
                                    echo  "&nbsp;-&nbsp;".$m_categ."&nbsp;</option>" ;
                                }       
                           }
                      ?>
                      </select>
                      <?php
                      }  /// Final do IF da variavel m_linhas
                      /// Final da Num_USP/Coautor
                    ?>  
                   </td>
                    <?php                      
                  } 
                  /// Final do If TD  - numero USP/Coautor
               }
               echo "</tr>";
           }            
     ?>
  </table>
  <?php
    exit();
} 
////  FINAL - IF  $source_upper=="CORESPONSAVEIS"  or $source_upper=="COLABS" 
///
///   Recebendo os dados do FORM para alterar Projeto   
if( $val_upper=="PROJETO" ) {
    /*	 
         AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
		 e de depois usa o  - html_entity_decode 
    */
      ///  Recebendo dados do FORM e Inserindo
     ///  nas Tabelas ANOTACAO e  PROJETO
     unset($array_temp); unset($array_t_value); 
     unset($arr_nome_val); unset($count_array_temp);
     unset($_SESSION["codigousp_novo"]);
     $cpo_final="alterar";
      ////
     $incluir_arq=$_SESSION["incluir_arq"];
     include("{$incluir_arq}includes/dados_campos_form_alterar_auto.php");            
     ////
     ///  $campo_nome = htmlentities(utf8_decode($campos_nome));
     $campo_nome = $_SESSION["campos_nome"];
     /// $campo_value = htmlentities(utf8_decode($campo_value));
     $campo_value = $_SESSION["campos_valor"];
     ///
     ///  Verificando campos 
     $m_regs=0;
     ///  Vericando se o Codigo/USP se ja esta cadastrado na Tabela pessoa
     if( isset($_SESSION["autor_codigousp"]) ) $arr_nome_val['codigousp']=$_SESSION["autor_codigousp"];
     if( ! isset($arr_nome_val['codigousp']) ) $arr_nome_val['codigousp']="";
     $arr_nome_val['codigousp'] = (int) trim($arr_nome_val['codigousp']);
     ///  Definindo os nomes dos campos recebidos do FORM
     foreach(  $arr_nome_val as $key => $value ) {
             $$key =  $value;
     } 
     ///      
     ///  $datainicio=$arr_nome_val["datainicio"];
     ///   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
     $m_titulo=strtoupper(trim($titulo));
	 $m_fonterec=strtoupper(trim($fonterec));	
     $m_fonteprojid=strtoupper(trim($fonteprojid));    
	 $_SESSION["numprojeto"]=strtoupper(trim($numprojeto));
	 ///   MELHOR JEITO PRA ACERTAR O CAMPO NOME
     //   function para caracteres com acentos passando para Maiusculas
     ///  '/&aacute;/i' => '?',
	/*
    $m_titulo = stringParaBusca2($m_titulo);
    $fonterec = stringParaBusca2($fonterec);    
    $m_autor=stringParaBusca2($m_autor);
    $m_titulo =html_entity_decode(trim($m_titulo));
    $fonterec =html_entity_decode(trim($fonterec));
    $fonteprojid=strtoupper(trim($arr_nome_val['fonteprojid']));    
    $m_autor =html_entity_decode(trim($m_autor));    
    */   
     //  Corrigir onde tiver strtotime - usado somente para ingles       
     $data_de_hoje = date('d/m/Y');
     $data_de_hoje = explode('/',$data_de_hoje);
     $time_atual = mktime(0, 0, 0,$data_de_hoje[1], $data_de_hoje[0], $data_de_hoje[2]);     
     /*   Usa a fun??o criada e pega o timestamp das duas datas:
          Verificando as datas recebidas datainicio e datafinal
     */
     $time_inicial="";
     if( isset($datainicio) ) {
          if( strlen(trim($datainicio))>5 ) {
             $m_datainicio=$datainicio;              
          }
          if( strlen(trim($datainicio))>=1 and  strlen(trim($datainicio))<6 ) { 
              /*  $msg_erro .= "Data inicial inv&aacute;lida  ".$datainicio.$msg_final;
              echo $msg_erro;  */     
              echo $funcoes->mostra_msg_erro("Data inicial inv&aacute;lida $datainicio");                          
              exit();   
          }        
     }
     $m_final="";
     if( isset($datainicio) ) {     
         /* Converter Data PHP para Mysql   */
         ///  if( $dt_inicio>$dt_atual ) {
          if( strlen(trim($datafinal))>5 ) {
              $m_final=$datafinal;         
          }
          if( strlen(trim($datafinal))>=1 and  strlen(trim($datafinal))<6 ) { 
               /* $msg_erro .= "Data final inv&aacute;lida  ".$datafinal.$msg_final;
              echo $msg_erro;  */
               echo $funcoes->mostra_msg_erro("Data final inv&aacute;lida  $datafinal");
               exit();   
          }                  
     }
     //
     ///  Verificando se foi digitado o campo com a Data inicio do Projeto   
     if( ! isset($m_datainicio) ) {
         // $m_datainicio="--";
          $m_datainicio="0000-00-00";
     } else {
         //  if( strlen(trim($m_datainicio))<10 ) $m_datainicio="--";
         if( strlen(trim($m_datainicio))<10 ) $m_datainicio="0000-00-00";
     }
     if( ! isset($datafinal) ) {
          ///  $datafinal="--";
          $datafinal="0000-00-00";
     } else {
         if( strlen(trim($datafinal))<10 )  $datafinal="0000-00-00";
     }
     ///  $time_final = geraTimestamp($data_final);
     ///  Variavel para incluir na Tabela anotador no campo PA
     $lnpa = $_SESSION["permit_pa"];
     
     /***
          Verifica a SESSION  relatproj_arq
           referente ao arquivo do Projeto formato PDF
      ***/
     if( ! isset($_SESSION["relatproj_arq"]) ) {
         /*   $msg_erro .= "Data final inv&aacute;lida  ".$datafinal.$msg_final;
              echo $msg_erro; 
         */
         echo $funcoes->mostra_msg_erro("SESSION relatproj_arq desativada. Corrigir.");
         exit(); 
     }
     ///  Essa session $_SESSION["relatproj_arq"] veio do FORM igual ao campo da tabela Projeto 
     //   Nome do arquivo gravado na Pasta do Autor do Projeto
     ///   importante trocar de session
     $_SESSION["relatproj_orig"] = $relatproj = $_SESSION["relatproj_arq"];
     unset($_SESSION["relatproj_arq"]);
     ///  if( $dt_inicio>$dt_atual ) {
     /*
    if( $time_inicial>$time_atual ) {
        $msg_erro .= "Data do in&iacute;cio do Projeto posterior a data atual.  Corrigir".$msg_final;
        echo $msg_erro;
        exit();
    }
    */
 	/* Converter Data PHP para Mysql   */
     ///  Verificando campos 
	 ///  coresponsaveis para incluir na Tabela corespproj
     $m_erro=0;
     ///  Verifica numero de coresponsaveis
	 if( intval($coresponsaveis)>=1 ) {
	     $n_coresponsaveis=explode(",",$m_array);
	     $count_coresp = count($n_coresponsaveis);
         ///  Tambem pode ser usado
         /// $count_coresp = $coresponsaveis;
	     for( $z=0; $z<$count_coresp ; $z++ ) {
		    if( strlen($n_coresponsaveis[$z])<1 ) {
		         $m_erro=1;
			     break;
			} 
		 }                
	 }
     /*  Desativado o numero de Co-Responsaveis - nao e necessario    
    	if( $m_erro==1 ) {
	        $msg_erro .= "&nbsp;Falta incluir co-respons&aacute;vel.".$msg_final;
            echo $msg_erro;
		    exit();
    	}   
 	 */
	  mysql_select_db($db_array[$elemento]);
      ///  PHP ? Remover os espa?os em excesso de uma string/variavel - exemplo: nome
      ///   $pessoa_nome = trim(preg_replace('/ +/',' ',$pessoa_nome));
      if( isset($_SESSION["cip"]) ) $cip=$_SESSION["cip"];
      /* 
         Verificando duplicata Projeto 
         os campos (objetivo, fonterec, fonteprojid, autor e m_datainicio) 
    */   
      if( isset($cip) and strlen(trim($cip)<1) ) {
           $parte=" objetivo={$objetivo}  and  "
                     ." trim(fonterec)=trim('".$fonterec."')  and  "
                     ." trim(fonteprojid)=trim('".$fonteprojid."') and "
                     ." autor=".$autor." and datainicio='$m_datainicio' and numprojeto!=$numprojeto ";
      } else {
           $parte=" objetivo={$objetivo}  and  "
                     ." trim(fonterec)=trim('".$fonterec."')  and  "
                     ." trim(fonteprojid)=trim('".$fonteprojid."') and "
                     ." autor=".$autor." and datainicio='$m_datainicio' and cip!=$cip ";
      }
      ///
      $sql_cmd="SELECT  cip,autor,titulo as titulo_outro, numprojeto as projeto_outro  "
                     ." FROM $bd_2.projeto WHERE $parte ";
      ////	
      $result=mysql_query($sql_cmd);			 
      /// Verificando se houve erro no Select Tabdla Usuario
      if( ! $result ) {
          /* $msg_erro .= "Select tabela projeto - falha: ".mysql_error().$msg_final;
          echo $msg_erro;  */        
          echo $funcoes->mostra_msg_erro("Select Tabela projeto -&nbsp;db/mysql:&nbsp;".mysql_error());                      
          exit();            
      } 
      /// Total de Registros 
      $m_regs=mysql_num_rows($result);
      if( intval($m_regs)>=1 ) {
           $outro_titulo=mysql_result($result,0,"titulo_outro");
           $projeto_outro=mysql_result($result,0,"projeto_outro");
           if( isset($result) ) mysql_free_result($result);
           ///
           $result=mysql_query("SELECT  descricao FROM $bd_2.objetivo "
                     ." WHERE  codigo={$objetivo}  ");
           ///                 
           /// Verificando se houve erro no Select Tabela Usuario
           if( ! $result ) {
               /*  $msg_erro .= "Select tabela objetivo - falha: ".mysql_error().$msg_final;
                  echo $msg_erro;  */
               echo $funcoes->mostra_msg_erro("Select Tabela objetivo -&nbsp;db/mysql:&nbsp;".mysql_error());
               exit();            
           }  
           $descricao=mysql_result($result,0,"descricao");
           ///   Caso existe outro projeto com os mesmos dados
           $texto_erro = "&nbsp;Existe outro Projeto&nbsp;nr.&nbsp;{$projeto_outro}&nbsp;<br>"
                       ."com esse T&iacute;tulo:&nbsp;{$outro_titulo}<br>"
                       ."j&aacute; est&aacute; cadastrado com esses dados&nbsp;(Autor, Objetivo, Fonte, Nr. Processo, Data In&iacute;cio).";                       
           ///  echo $msg_erro;
           echo $funcoes->mostra_msg_erro($texto_erro);                      
     	   exit();
      } else {
     	  ///  Continuacao Tabela Projeto para Alterar 
          /*   MELHOR jeito de acertar a acentuacao - html_entity_decode    */	
	       if( isset($result) ) mysql_free_result($result);
           ///  Caso tenha coautores/coresponsaveis no Projeto
           ///  include("n_cos.php");
           ///
           $n_erro=0;
                  
           /// CIP do Projeto
           if( isset($_SESSION["cip"]) ) $cip=$_SESSION["cip"];
           ///  START a transaction - ex. procedure    
           mysql_query('DELIMITER &&'); 
           mysql_query('begin'); 
           //  Execute the queries 
           mysql_select_db($db_array[$elemento]);
           //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
           //   - Use mysql_select_db() ou mysql_query()
           mysql_query("LOCK TABLES $bd_2.projeto UPDATE, $bd_2.corespproj DELETE, $bd_2.corespproj UPDATE ");
           ///  $sqlcmd="UPDATE $bd_2.projeto  (".$_SESSION["campos_nome"].") values(".$_SESSION["campos_valor"].") ";       
           $sqlcmd="UPDATE $bd_2.projeto SET  "
                      ." titulo='$titulo',objetivo=$objetivo,coresponsaveis=$coresponsaveis,"
                      ."fonterec='$fonterec',fonteprojid='$fonteprojid',"
                      ."datainicio='$datainicio',datafinal='$datafinal' "
                      ." WHERE cip=$cip  ";       
           ///           
           $success=mysql_query($sqlcmd); 
           ///  Complete the transaction 
           if( $success ) { 
                 ///  Cadastrando na tabela corespproj os coresponsaveis
                 if( ! isset($count_coresp) ) $count_coresp=-1;
                 ///  if( intval($x)<1 ) {
                 ///  Removendo os co-responsaveis
                 $delete_coresproj = mysql_query("DELETE from $bd_2.corespproj 
                                                    WHERE projetoautor=$autor and projnum=$numprojeto ");
                 ///
                 if( ! $delete_coresproj ) {
                      $n_erro=1; 
                      $result=false;
                      ///  $msg_erro .="Falha DELETE FROM coresproj -  ERRO#2 = ".mysql_error().$msg_final;
                      echo $funcoes->mostra_msg_erro("&nbsp;DELETE FROM corespproj -&nbsp;db/mysql:&nbsp;".mysql_error());
                      mysql_query('rollback'); 
                 }                           
                 ///  }
                 ///    
                 for( $x=0; $x<$count_coresp; $x++ ) {
                       ///  Caso NAO houve erro
                       if( intval($n_erro)<1 ) {
                            /// Inserindo os co-responsaveis
                            $result=mysql_query("INSERT INTO $bd_2.corespproj  "
                                    ." values(".$autor.", ".$numprojeto.", ".$n_coresponsaveis[$x].")");
                            ///         
                            if( ! $result ) {
                                 $n_erro=1;
                                 $texto_erro ="&nbsp;CORESP. n&atilde;o foi cadastrado (autor/projeto/coresp). ERRO#3 = ".$autor.", ".$numprojeto.", ".$n_coresponsaveis[$x];
                                 echo $funcoes->mostra_msg_erro($texto_erro."&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());
                                 mysql_query('rollback'); 
                                 break;
                            }                            
                       }
                 }
                 ///  Caso tenha sucess/result
                 if( $result )  mysql_query('commit');                                  
           } else {
                 $n_erro=1;
                 ///  $msg_erro .="&nbsp;Projeto <b>N&Atilde;O</b> foi alterado. ERRO#1 = ".mysql_error().$msg_final;                 
                 echo $funcoes->mostra_msg_erro("&nbsp;Projeto <b>N&Atilde;O</b> foi alterado - db/mysql:&nbsp; ".mysql_error());
                 mysql_query('rollback'); 
           }  
           ///
           /// Final do IF success              
           mysql_query("UNLOCK  TABLES");
           mysql_query('end'); 
           mysql_query('DELIMITER');
           //  Correto para comparar tem que ser com  == 
           /*
           if( $n_erro==1 ) {
                echo $msg_erro;               
           } else {
           */
           if( intval($n_erro)<1 ) {
                ///  Incluindo arquivo para a Anotacao do Projeto 
                ///  projeto, autor/orientador e numero da anotacao
                /// $projeto_cip=mysql_result($result_proj,0,"cip");       
                ///  mysql_free_result($result_proj);                       
                $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario  
                $sqlcmd="UPDATE $bd_2.anotador SET pa=$lnpa,data='$data_atual'  WHERE cip=$cip ";
                $res_anotador=mysql_query($sqlcmd); 
                if( $res_anotador )  {
                     ///  Nome do autor do Projeto alterado
                     $sql_cmd="SELECT  nome from $bd_1.pessoa  WHERE codigousp=$autor ";
                     $res_autor_nome=mysql_query($sql_cmd); 
                     if( ! $res_autor_nome ) {
                        /* $msg_erro .="&nbsp;Nome do autor do Projeto. ERRO#1 = ".mysql_error().$msg_final;                 
                        echo $msg_erro;   */ 
                         echo $funcoes->mostra_msg_erro("&nbsp;Nome do autor do Projeto -&nbsp;db/mysql:&nbsp;".mysql_error());
                    } else {
                         $nome_autor_projeto = htmlentities(trim(mysql_result($res_autor_nome,0,"nome")));
                         /// Antes
                         /*
                          $msg_ok .="<p class='titulo_alterar' >Projeto $numprojeto do autor $nome_autor_projeto foi alterado.<br><br>";
                          $msg_ok .="Arquivo:&nbsp; $relatproj original em formato PDF (Substituir?)</p>".$msg_final;
                          echo  $msg_ok."falta_arquivo_pdf".$numprojeto."&".$autor."&".$relatproj;
                          */
                         ///  Depois com Class  -  20120803   
                         $texto_ok ="<p class='titulo_alterar' >Projeto $numprojeto do autor $nome_autor_projeto foi alterado.<br><br>";
                         $texto_ok .="Arquivo:&nbsp; {$_SESSION["relatproj_orig"]} original em formato PDF (Substituir?)</p>";
                         $texto_ok .="falta_arquivo_pdf".$numprojeto."&".$autor."&".$_SESSION["relatproj_orig"];
                         echo $funcoes->mostra_msg_ok($texto_ok);
                           ///  echo  $msg_ok."falta_arquivo_pdf".$numprojeto."&".$autor."&".$relatproj;
                          /// Efetiva a transa??o nos duas tabelas (anotacao e projeto)                                             
                    }
                } else {
                    /* $msg_erro .="&nbsp;Anotador <b>N&Atilde;O</b> foi cadastrado.".mysql_error().$msg_final;
                        echo $msg_erro;    */                               
                     echo $funcoes->mostra_msg_erro("&nbsp;Anotador <b>N&Atilde;O</b> foi cadastrado -&nbsp;db/mysql:&nbsp;".mysql_error());            
                }                   
           }
    }  
    ////  Final  - IF da variavel  m_regs
    exit();                          
	/***  FINAL IF TABELA projeto  -  BD  REXP   ***/
} elseif( $val_upper=="PESSOAL" ) {
     ///  Tabela pessoa - BD PESSOAL
    /*	 
         Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
		 OU para MYSQL  tem que ser html_entity_decode
    */	
 	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp);
     $i_codigousp =-1;
	 for( $i=0; $i<$count_array_temp; $i++ ) {
         $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
         // Salvando a posi??o do campo codigousp para criar codigo <0 para usuario de fora da USP
         if (strtoupper(trim($array_temp[$i]))=="CODIGOUSP") $i_codigousp=$i;
     }
	 //  Verificando campos 
    $elemento=5;  $m_regs=0;
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    //  Vericando se o Codigo/USP se ja esta cadastrado na Tabela pessoa
	mysql_select_db($db_array[$elemento]);
    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
    /*
        $arr_nome_val['codigousp'] = strlen(trim($arr_nome_val['codigousp']))>0 ? $arr_nome_val['codigousp'] : 0;    
    */  
    if( ! isset($arr_nome_val['codigousp']) ) $arr_nome_val['codigousp']=0;
    //
    if ( $arr_nome_val['codigousp']==0) {
        $result=mysql_query("SELECT min(codigousp) as codigo_ult  FROM  $bd_1.pessoa where codigousp<0 ") ;
        if( ! $result ) {
            // die("Falha erro no Select/Atribuir codigoUSP".mysql_error());
            echo $funcoes->mostra_msg_erro("Select/Atribuir codigoUSP - db/mysql:&nbsp; ".mysql_error());
            exit();
        }
        $m_regs=mysql_num_rows($result);
        if ($m_regs>0) {
            $codigo_prx = mysql_result($result,0,'codigo_ult');
        } 
        if (!isset($codigo_prx)) {
            $codigo_prx = 0;
        }
        $codigo_prx += -1;
        mysql_free_result($result);
        $arr_nome_val['codigousp'] = $codigo_prx;
        if( $i_codigousp<0 ) {
            //  die("ERRO: Falha inesperada criando um NOVO codigo USP.");
            echo $funcoes->mostra_msg_erro("Falha inesperada criando um NOVO codigo USP.");
            exit();            
        }
        $array_t_value[$i_codigousp] = $codigo_prx;
    }
    
	$result_usu=mysql_query("SELECT codigousp,nome FROM $bd_1.pessoa where codigousp=".$arr_nome_val['codigousp']) ;
	if( ! $result_usu ) {
		//  die("Falha erro no Select".mysql_error());
        echo $funcoes->mostra_msg_erro("Select da Tabela pessoa - db/mysql:&nbsp; ".mysql_error());
        exit();          
	}
    $m_regs=mysql_num_rows($result_usu);
    mysql_free_result($result_usu);
    if(  $m_regs>=1 ) {
            /* $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;".$arr_nome_val['codigousp']." j&aacute; est&aacute; cadastrado.".$msg_final;
           echo $msg_erro; */

           echo $funcoes->mostra_msg_erro("&nbsp;Esse C&oacute;digo:&nbsp;{$arr_nome_val['codigousp']} j&aacute; est&aacute; cadastrado.");
           exit();                      
    } else {
           //   Vericando se o NOme se ja esta cadastrado  na Tabela pessoa
           //   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
           //    Remover os espacos do nome deixando apenas um entre as palavras
           $arr_nome_val['nome'] = trim(preg_replace('/ +/',' ',$arr_nome_val['nome']));            
           //   ACERTAR O CAMPO NOME, retirando acentua??o e passando para maiusculas
           $pessoa_nome=stringParaBusca2(strtoupper(trim($arr_nome_val['nome'])));
           //  
           //  Acertando ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
           $pessoa_nome=html_entity_decode(trim($pessoa_nome)); 
           mysql_select_db($db_array[$elemento]);
           //  SESSION abaixo para ser usada no include
           $_SESSION["tabela"]="pessoa";          
           include("dados_recebidos_arq_ajax.php");  
           //
           //  INSERINDO 
           //  Start a transaction - ex. procedure			   
           mysql_query('DELIMITER &&'); 
           mysql_query('begin'); 
           //
           $success=mysql_query("insert into $bd_1.pessoa  (".$cpo_nome.") values(".$cpo_valor.") "); 
           //  Complete the transaction 
           if ( $success ) { 
               mysql_query('commit'); 
               /* $msg_ok .="<p class='titulo_usp'>&nbsp;".$arr_nome_val['nome']." foi cadastrado.</p>".$msg_final;
               echo $msg_ok; */
               
              echo $funcoes->mostra_msg_ok("<p class='titulo_usp'>&nbsp;{$arr_nome_val['nome']} foi cadastrado.</p>");

           } else { 
               mysql_query('rollback'); 
               /*
               $msg_erro .="&nbsp;".$arr_nome_val['nome']." n&atilde;o foi cadastrado.".$msg_final;
               echo $msg_erro;	     */
               
               echo $funcoes->mostra_msg_erro("&nbsp;{$arr_nome_val['nome']}&nbsp;n&atilde;o foi cadastrado.");               
           } 
           mysql_query('end'); 
           mysql_query('DELIMITER'); 
	}
	//  Final - Tabela pessoa 
    exit();
}  elseif( $val_upper=="USUARIO" ) {
     //  Tabela usuario - BD PESSOAL  Tabela usuario
     //
     unset($array_temp); unset($array_t_value); $m_erro=0;
     //    Dados vindo de um FORM   
     include("../includes/dados_campos_form.php");
     $conta =  sizeof($array_temp);
     //  Verificando campos 
    //  Verificando Login e Senha 
    if( strtoupper(trim($arr_nome_val['login']))==strtoupper(trim($arr_nome_val['senha']))  ) {
        /* $msg_erro .= "ERRO:  Usuário/Login e Senha iguais - corrigir ".$msg_final;
         echo  $msg_erro;  */
         
         echo $funcoes->mostra_msg_erro("&nbsp;Usu&aacute;rio/Login e Senha iguais - corrigir");               
         exit(); 
    }
	 //  Verificando campos 
	//  Verificando se nao existe Usuario com esse login  na Tabela usuario
    $result_usu = mysql_query("SELECT login FROM $bd_1.usuario WHERE "
                        ."  trim(login)=trim('".$arr_nome_val['login']."')");
    if ( ! $result_usu ) {
         /*  $msg_erro .= "&nbsp;Usu&aacute;rio:&nbsp;".$arr_nome_val[login]." - falha no mysql/query:".mysql_error().$msg_final;
         echo $msg_erro;  */
         
         echo $funcoes->mostra_msg_erro("Select da Tabela usuario. &nbsp;Usu&aacute;rio:&nbsp;{$arr_nome_val[login]} - db/mysql:&nbsp; ".mysql_error());         
         exit();
    }
    $m_regs = mysql_num_rows($result_usu);
	mysql_free_result($result_usu);
	if(  $m_regs>=1 ) {
         /* $msg_erro .= "&nbsp;Usu&aacute;rio:&nbsp;".$arr_nome_val['login']." j&aacute; cadastrado.".$msg_final;
         echo $msg_erro;  */
         
         echo $funcoes->mostra_msg_erro("&nbsp;Usu&aacute;rio:&nbsp;{$arr_nome_val['login']} j&aacute; cadastrado.");         
         exit();         
	} 
    //  SESSION Tabela para ser usada no include: dados_recebidos_arq_ajax.php
    //  DEsativando
    if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
    if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
    //  Acertando os campos para inserir dados
    $_SESSION["tabela"]="usuario";
    include("dados_recebidos_arq_ajax.php");
    //	
    mysql_select_db($db_array[$elemento]);
    $n_pa = trim($arr_nome_val['pa']);
    //  foreach( $array_usuarios as $key =>$valor ) {
    foreach( $array_pa as $key =>$valor ) {        
          if( $n_pa==$valor  ) {
               $nome_key = $key;
               break;
          }
    }
    //  START  a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    //  Execute the queries 
    //  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
    //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
    //   - Use mysql_select_db() ou mysql_query()
    // Gera a ativação de codigo com 6 digitos
    $activ_code = rand(100000,999999);

    // echo "cpo_nome=".$cpo_nome."<br>  cpo_valor=".$cpo_valor."<br><br>";
    // exit();
    $success=mysql_query("insert into  usuario "
                ."  (".$cpo_nome.",activation_code) values(".$cpo_valor.",'$activ_code') "); 
    //  Complete the transaction 
    if ( $success ) { 
        /*  $msg_ok .="<p class='titulo_usp'>Usu&aacute;rio:&nbsp;"
        .$arr_nome_val['login']." foi cadastrado.</p>".$msg_final;  */
        
        echo $funcoes->mostra_msg_ok("<p class='titulo_usp'>Usu&aacute;rio:&nbsp;{$arr_nome_val['login']} foi cadastrado.</p>");
        $m_erro=0;      
        mysql_query('commit'); 
    } else { 
        /* $msg_erro .="Usu&aacute;rio:&nbsp;"
        .$arr_nome_val['login']." n&atilde;o foi cadastrado.".$msg_final;
        echo $msg_erro;   */
        
        echo $funcoes->mostra_msg_erro("Usu&aacute;rio:&nbsp;{$arr_nome_val['login']} n&atilde;o foi cadastrado - db/mysql:&nbsp; ".mysql_error()); 
        $m_erro=1;      
        mysql_query('rollback'); 
    }
    mysql_query('end'); 
    mysql_query('DELIMITER');
    // 
    if( $m_erro<1 ) {
        $res_email = mysql_query("Select e_mail from $bd_1.pessoa where codigousp=".$arr_nome_val['codigousp']." ");
        if( ! $res_email ) {
            //  die("ERRO: Select pessoa campo e_mail falha: ".mysql_error());
            
            echo $funcoes->mostra_msg_erro("Select Tabela pessoa - db/mysql:&nbsp; ".mysql_error());           
        }  else {
            $usr_email=html_entity_decode(trim(mysql_result($res_email,0,'e_mail')));
            $data['senha'] = $arr_nome_val['senha'];
            mysql_freeresult($res_email);
            //
            $host  = $_SERVER['HTTP_HOST'];
            $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
            $user=$arr_nome_val['codigousp'];
            $m_local="ativar.php?user=".$user."&activ_code=".$activ_code;
            /*
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br>"
            ."<a href='http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code'  title='Clicar' >"
            ."http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code</a>"; 
            */
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br>"
                     ."<a href='$retornar$m_local'  title='Clicar' >$retornar$m_local</a>"; 
            //
            //  $host_upper = strtoupper($host);           
            $host_lower = strtolower($host);                     
            //  $assunto =html_entity_decode("Redefini??o de senha");    
            $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
            $corpo ="RGE/SISTAM - Anota??o<br>";
            $corpo .="$host_lower<br><br>";    
            $corpo .=html_entity_decode("Seu cadastro como ".ucfirst($nome_key)." foi realizado.<br>Detalhes do seu registro\r\n");                    
            $user_name = html_entity_decode($arr_nome_val['login']); 
            $headers1  = "MIME-Version: 1.0\n";
            //  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
            $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
            $headers1 .= "X-Priority: 3\n";
            $headers1 .= "X-MSMail-Priority: Normal\n";
            $headers1 .= "X-Mailer: php\n";
            //  $headers1 .= "Return-Path: xxx@...\n";
            // $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
            // $headers1 .= "Return-Path: bezerralaf@gmail.com; spfbezer@fmrp.usp.br \n";
            $headers1 .= "Return-Path: {$_SESSION["gemac"]} \n";
            
            //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
            //  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
            $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
            
            $message = "$corpo ...\n<br><br>
            Usuário: $user_name<br>
            Email: $usr_email \n<br>
            Senha: $data[senha] \n<br>

            Código de ativação: $activ_code \n<br><br>

            $a_link<br><br>

            ______________________________________________________<br>
            Esta é uma mensagem automática.<br> 
            *** não responda a este EMAIL ****
            ";
            mail($usr_email, stripslashes(utf8_encode($assunto)), $message,$headers1);

            //                          
            /*    $msg_ok .= "<p>Sua senha foi redefinida e uma nova senha foi enviada para seu endere?o de e-mail.<br>"
            ."<a href='$retornar' title='Clicar' >Retornar</a></p>";                         
            */
             /*  $msg_ok .= "<p>Mensagem de Acesso enviada para o email:  $usr_email<br></p>";                         
            echo  $msg_ok; */
            
            echo $funcoes->mostra_msg_ok("<p>Mensagem de Acesso enviada para o email:  $usr_email<br></p>");
        }
    }
    exit();                  
}	 
#
ob_end_flush(); /* limpar o buffer */
#
?>