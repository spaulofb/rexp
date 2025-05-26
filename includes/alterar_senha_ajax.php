<?php
//   Arquivo para CADASTRAR 
//
//  Funcao para busca com acentos
function stringParaBusca($str) {
    //Transformando tudo em min?sculas
    $str = trim(strtolower($str));

    //Tirando espa?os extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
    while ( strpos($str,"  ") )
        $str = str_replace("  "," ",$str);
    
    //Agora, vamos trocar os caracteres perigosos "?,?..." por coisas limpas "a"
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
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');

//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

///
ini_set('default_charset','UTF-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///
extract($_POST, EXTR_OVERWRITE); 
///
///  Verificando SESSION incluir_arq - 20180605
$n_erro=0;
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
    ///  echo $msg_erro;
    ///  exit();
    echo   $msg_erro;
    exit();
}
$incluir_arq=trim($_SESSION["incluir_arq"]);

//  Conjunto de arrays 
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");

/// Conjunto de Functions
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");    

$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    ///  Verificar strings com simbolos: # ou ,   para transformar em array PHP    
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if ( isset($_POST[$xyz]) ) {
	    $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
	   if( $pos1===false ) {
	        ///  $$xyz=trim($_POST[$xyz]);
		    ///   Para acertar a acentuacao - utf8_encode
            $$xyz = utf8_decode(trim($_POST[$xyz])); 
	   } else {
            $$xyz = explode($div_array_por,$_POST[$xyz]);  
       } 
	}
}
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=$source;

if( strtoupper($source)=="SAIR" ) {
    // Eliminar todas as variaveis de sessions
    $_SESSION = array();
    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($senha_down) )  unset($senha_down); 
	//
	//  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
    response.setHeader("Pragma", "no-cache"); 
    response.setHeader("Cache-Control", "no-cache"); 
    response.setDateHeader("Expires",0); 
	//  echo  "http://www-gen.fmrp.usp.br/";
	#
	exit();
	#
}
//  
//    Alterando a senha do usuario/login
if( strtoupper($val)=="SENHA" ) {
     //  Recebendo dados do FORM e Inserindo
     //  na Tabela pessoal.usuario
     unset($array_temp); unset($array_t_value); 
     unset($arr_nome_val); unset($count_array_temp);
     //
     include("dados_campos_form_alterar.php");
    //   Vericando se o LOGIN/USUSAIO se ja esta cadastrado na Tabela usuario
    $m_usuario_arr = array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
    $m_senha_arr = array('SENHA','PASSWD','PASSWORD');
    //  Definindo os nomes dos campos recebidos do FORM
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
          $$chave =  $valor;         
     }
     //
            
    //  Verificando Login e Senha 
    if( $upper_login==strtoupper(trim($arr_nome_val['senha']))  ) {
         $msg_erro .= "ERRO:  Usuário/Login e Senha s&atilde;o iguais - corrigir ".$msg_final;
         echo  $msg_erro;
         exit(); 
    }
    //
    // Usuario Conectado para mudar a Senha
    if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado = $_SESSION["usuario_conectado"];
    //
    $elemento=5;  $lnerro=0; $m_regs=0;
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    mysql_select_db($db_array[$elemento]);
    $_SESSION['tabela']=$bd_1.".usuario";
    //  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    //  Execute the queries          
    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
    mysql_query("LOCK TABLES ".$_SESSION['tabela']." UPDATE  ");
    /*!40000 UPDATE TABLE usuario DISABLE KEYS */;            
   // $res_usuario = "UPDATE ".$_SESSION['tabela']." SET  senha=password('$senha') WHERE trim(login)='$login'  "; 
   $res_usuario = "UPDATE ".$_SESSION['tabela']." SET  senha=password('$senha') WHERE codigousp=$usuario_conectado  "; 
    //                  
    $sqlcmd =  mysql_query($res_usuario);      
    if( $sqlcmd ) { 
         ///  Concluindo as tabelas para Orientador Novo para ser aceito pelo Aprovador
         $msg_ok .="<span style='font-size:large; color:#000000; padding: 0 0 1em 0;'>"
                       ."<b>SENHA alterada.</b><br/></span>".$msg_final;
        mysql_query('commit'); 
        echo $msg_ok;                    
    } else { 
        ///  mysql_error() - para saber o tipo do erro
        $msg_erro .="&nbsp;Falha Alterar SENHA - ".mysql_error().$msg_final;
        mysql_query('rollback'); 
        echo $msg_erro; 
        $lnerro=1;        
    }           
    /*!40000 UPDATE TABLE usuario ENABLE KEYS */;
    mysql_query("UNLOCK  TABLES");
    //  Complete the transaction 
    mysql_query('end'); 
    mysql_query('DELIMITER');         
    //
    if( $lnerro<1 ) {
        $_SESSION["senha_down"]=$senha ;   
        $senha_down =$senha ;
    }        
    exit();
}
//
ob_end_flush(); /* limpar o buffer */
#
?>