<?php
//   Arquivo para CADASTRAR 
//
//  Biblioteca para uso do programa
//
//
function isEmail($email) {
    return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}
///  Funcao para busca com acentos
if( ! function_exists("stringParaBusca") ) {  
    //
    function stringParaBusca($str) {
        //
        // Transformando tudo em minúsculas
        $str = trim(strtolower($str));

        //Tirando espaços extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
        while ( strpos($str,"  ") )
            $str = str_replace("  "," ",$str);
        //
        /**  Agora, vamos trocar os caracteres perigosos "ã,á..." por coisas limpas "a"  */ 
        $caracteresPerigosos = array ("Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","!","?",",","“","”","-","\"","\\","/");
        $caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
        $str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
        
        //Agora que não temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
        //vamos montar a expressão regular para o MySQL
        $caractresSimples = array("a","e","i","o","u","c");
        $caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
        $str = str_replace($caractresSimples,$caractresEnvelopados,$str);
        $caracteresParaRegExp = array(
            "(a|ã|á|à|ä|â|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|Ã|Á|À|Ä|Â|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
            "(e|é|è|ë|ê|&eacute;|&egrave;|&euml;|&ecirc;|É|È|Ë|Ê|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
            "(i|í|ì|ï|î|&iacute;|&igrave;|&iuml;|&icirc;|Í|Ì|Ï|Î|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
            "(o|õ|ó|ò|ö|ô|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|Õ|Ó|Ò|Ö|Ô|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
            "(u|ú|ù|ü|û|&uacute;|&ugrave;|&uuml;|&ucirc;|Ú|Ù|Ü|Û|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
            "(c|ç|Ç|&ccedil;|&Ccedil;)" );
        $str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
        
        //Trocando espaços por .*
        $str = str_replace(" ",".*",$str);
        
        // Retornando a String finalizada!
        return $str;
        //
    }
    //
}    
///
///  Funcao para minuscula para Maiuscula
if( ! function_exists("stringParaBusca2") ) {
    function stringParaBusca2($str) { 
         //
         //  Usar para substituir caracteres com acentos para Maiuscula
         $substituir = array(
                            '/&aacute;/i' => 'Á',
                            '/&Eacute;/i' => 'É',
                            '/&Iacute;/i' => 'Í',
                            '/&Oacute;/i' => 'Ó',
                            '/&Uacute;/i' => 'Ú',
                            '/&Atilde;/i' => 'Ã',
                            '/&Otilde;/i' => 'Õ',
                            '/&Acirc;/i' => 'Â',
                            '/&Ecirc;/i' => 'Ê',
                            '/&Icirc;/i' => 'Î',
                            '/&Ocirc;/i' => 'Ô',
                            '/&Ucirc;/i' => 'Û',
                            '/&Ccedil;/i' => 'Ç',
                            '/&Agrave;/i' => 'À'
                            );  
        //
        //  $texto =strtoupper($str);
        $substituir0 = array(
                            '/á/' => '&aacute;',
                            '/é/' => '&eacute;',
                            '/í/' => '&iacute;',
                            '/ó/' => '&oacute;',
                            '/ú/' => '&uacute;',
                            '/ã/' => '&atilde;',
                            '/õ/' => '&otilde;',
                            '/â/' => '&acirc;',
                            '/ê/' => '&ecirc;',
                            '/î/' => '&icirc;',
                            '/ô/' => '&ocirc;',
                            '/û/' => '&ucirc;',
                            '/ç/' => '&ccedil;',
                            '/Á/' => '&Aacute;',
                            '/É/' => '&Eacute;',
                            '/Í/' => '&Iacute;',
                            '/Ó/' => '&Oacute;',
                            '/Ú/' => '&Uacute;',
                            '/Ã/' => '&Atilde;',
                            '/Õ/' => '&Otilde;',
                            '/Â/' => '&Acirc;',
                            '/Ê/' => '&Ecirc;',
                            '/Î/' => '&Icirc;',
                            '/Ô/' => '&Ocirc;',
                            '/Û/' => '&Ucirc;',
                            '/Ç/' => '&Ccedil;',
                            '/à/' => '&agrave;',
                            '/À/' => '&Agrave;'
                            );  
        //
        $substituir2 = array('á' => 'Á',
                            'é' => 'É',
                            'í' => 'Í',
                            'ó' => 'Ó',
                            'ú' => 'Ú',
                            'ã' => 'Ã',
                            'õ' => 'Õ',
                            'â' => 'Â',
                            'ê' => 'Ê',
                            'î' => 'Î',
                            'ô' => 'Ô',
                            'û' => 'Û',
                            'ç' => 'Ç',
                            'ñ' => 'Ñ',
                            'ò' => 'Ò',
                            'ò' => 'Ò',                        
                            'ö' => 'Ö',                        
                            'ø' => 'Ø',                                                
                            'ù' => 'Ù',                                                                        
                            'ü' => 'Ü',                                                                                                
                            'ý' => 'Ý'
                        );
        //
        /**    $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);   */
        $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);
        ///
        return $texto;
        // 
    }
    //
}    
//    
ob_start(); /* Evitando warning */
//  Verificando se SESSION_START - ativado ou desativado
if( ! isset($_SESSION) ) {
    session_start();
}
//
/**     Verificar a Mensagem de Erro  
 *  Crucial ter as configurações de erro ativadas
*/ 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//
//  set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//
// Defina os cabeçalhos de controle de cache
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-type: text/html; charset=utf-8");
//
/**  Colocar as datas do Cadastro do Usuario e a validade   */  
date_default_timezone_set('America/Sao_Paulo');
//
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
//  setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
//
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
/**  extract: Importa variáveis para a tabela de símbolos a partir de um array   */ 
extract($_POST, EXTR_OVERWRITE);  
//
// Mensagens para enviar 
$msg_erro = "<span class='texto_normal' style='color: #FF0000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #000000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
// Final - Mensagens para enviar 
//
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
     $incluir_arq=$_SESSION["incluir_arq"];  
} else {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
//
/**
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
*/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");
//
//  Verificando -  Conexao 
$elemento=5; $elemento2=6;
// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
require_once("php_include/ajax/includes/conectar.php");     
//
//  HOST mais a pasta principal do site - host_pasta
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
$_SESSION["protocolo"]=$protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"]=$url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
///  Conjunto de arrays 
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    

/// Conjunto de Functions
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");    

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
$e_mailinf = "  ";   /// Verificar ponto mais adequado para usar = pegar como parâmetro
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 
if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source);
$source_upper=strtoupper($_SESSION["source"]);
///  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
///
if( $source_upper=="SAIR" ) {
    // Eliminar todas as variaveis de sessions
    $_SESSION=array();
    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($login_down) ) unset($login_down); 
    if( isset($senha_down) )  unset($senha_down); 
	//
	//  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
    response.setHeader("Pragma", "no-cache"); 
    response.setHeader("Cache-Control", "no-cache"); 
    response.setDateHeader("Expires",0); 
	//  echo  "http://www-gen.fmrp.usp.br/";
	exit();
}
//    CODIGOUSP para verificar se a pessoa tem e_mail
if( $source_upper=="CODIGOUSP" ) {      
    $anotador_codigousp=$val;
    /// Conectar
    /*
    $elemento=5;$elemento2=6;
    include("php_include/ajax/includes/conectar.php"); 
    */
    
    ///  Verificando se o Anotador tem email - (Valido)
    $sqlcmd = "SELECT e_mail,nome from $bd_1.pessoa WHERE codigousp=$anotador_codigousp ";
    $resultado = mysql_query($sqlcmd);
    if( ! $resultado ) {
          $msg_erro .=' Falha na consulta da pessoa: db/mysql= '.mysql_error().$msg_final;  
         echo $msg_erro;               
         exit();                                          
    }
    ///  Caso ANOTADOR NAO tenha cadastro na tabela pessoa
    if( $val==-999999999 ) {
        $anotador_nome = $_SESSION["anotador_nome"] = "";
    }    
    ///
    /// Verifica se encontrou o novo Anotador
    $nregs = mysql_num_rows($resultado);
    if( intval($nregs)>0) {
        $anotador_e_mail=mysql_result($resultado,0,"e_mail");
        $ver_e_mail="(E_mail:$anotador_e_mail)";
        $_SESSION["anotador_nome"] = $anotador_nome = mysql_result($resultado,0,"nome");
    } else {
         $anotador_e_mail="E_mail ainda n&atilde;o cadastrado.";
         $ver_e_mail="E_mail ainda n&atilde;o cadastrado.";   
         /**
         $msg_erro .="<span class='td_inicio1'>Anotador N&Atilde;O cadastrado. Providencie Corre&ccedil;&atilde;o.<span>";
         echo $msg_erro.$msg_final;                     
         exit();
         ***/
         ///
    }
    ///
    /// Verifica se o Anotador esta cadastrado ou faltando E_Mail
    if( ! isEmail($anotador_e_mail) ) {
        if( strlen(trim($anotador_nome))<1 ) {
           $msg_erro .="<span class='td_inicio1'>Anotador <b>N&Atilde;O</b> cadastrado. Digitar Nome e E_mail. Providencie Corre&ccedil;&atilde;o.<span>"; 
        } else {
           $msg_erro .="<span class='td_inicio1'>Anotador ainda <b>N&Atilde;O</b> tem E_MAIL v&aacute;lido cadastrado ($ver_e_mail). Providencie Corre&ccedil;&atilde;o.<span>";
        }
        ///          

            $msg_erro .="%";
            $msg_erro .="<table class='table_inicio' cellpadding='1' border='2' cellspacing='1' style='font-weight:normal; background-color: #FFFFFF; margin: 0px; padding: 0px;vertical-align: middle; '  >";
            $msg_erro .="<tr>";
            $msg_erro .="<td  class='td_inicio1' style='vertical-align: middle;' >";
            $msg_erro .="<label for='nome' style='vertical-align: middle; cursor: pointer;' >Nome:&nbsp;</label>";
            $msg_erro .="</td>";
            $msg_erro .="<td class='nome' style='vertical-align: middle;' >";
            $msg_erro .="<input type=\"text\" name=\"nome\" id=\"nome\" class=\"nome\"  size=\"70\" maxlength=\"64\" " 
                        ." value=\"$anotador_nome\" title=\"Digitar Nome/Anotador\" "
                        ." onblur=\"javascript: alinhar_texto(this.id,this.value)\"  "
                        ." autocomplete=\"off\"  style=\"cursor: pointer;\"  />";
            ///            
            $msg_erro .="</td></tr>";
            echo $msg_erro.$msg_final;                     
    } else {
            $anotador_nome=mysql_result($resultado,0,"nome");
            $_SESSION["anotador_nome"]=trim($anotador_nome);
            echo utf8_decode("$anotador_nome#$anotador_e_mail");
    }    
    exit();
}
//
//    Tabela do ANOTADOR  cadastrado pelo Orientador  -  variavel val
if( strtoupper($val)=="ANOTADOR" ) {      
     ///  Recebendo dados do FORM e Inserindo
     ///  nas Tabelas ANOTACAO e PROJETO
     unset($array_temp); unset($array_t_value); $m_erro="";
     $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario     
     //  $pa_anotador = $_SESSION["array_usuarios"]["anotador"];                 
     $pa_anotador = $array_pa["anotador"];
     include("{$_SESSION["incluir_arq"]}includes/dados_campos_form.php");   
     ///
     foreach( $arr_nome_val as $key => $value ) {
              $$key=$value;  
     }
     if( isset($_SESSION["gemac"]) ) {
          $gemac_email=$_SESSION["gemac"];
     } else {
         $msg_erro .="E_MAIL gemac n&atilde;o &eacute; v&aacute;lido. Re-digite.".$msg_final;
         echo $msg_erro;                     
         exit();
     }
     ///
     $_SESSION["tabela"]="anotador";
     ///   CAMPOS do FORM anotador_cadastrar.php
     $lnprojeto = $arr_nome_val["projeto"]; 
     $lncodigousp = (int) $arr_nome_val["codigousp"];
     /// if( isset($arr_nome_val["nome"]) ) {
     if( isset($_SESSION["anotador_nome"]) ) {
          /// $anotador_nome = html_entity_decode($_SESSION["anotador_nome"]);
          $_SESSION["anotador_nome"] = $anotador_nome = htmlentities($_SESSION["anotador_nome"],ENT_QUOTES,"UTF-8");
     } else {
          /// $nome = "";
         $_SESSION["anotador_nome"] = $anotador_nome = $arr_nome_val["nome"];
     }
     ///
     $e_mailinf = $arr_nome_val["e_mail"];
     ///  Verificando pela funcao isEmail  se  o e_mail e valido 
     if( !isEmail($e_mailinf) ) {
         $msg_erro .="E_MAIL  informado:$e_mailinf n&atilde;o &eacute; v&aacute;lido. Re-digite.".$msg_final;
         echo $msg_erro;                     
         exit();
     }  
     ///
     ///  Usuario Orientador/Chefe
     if( ! isset($_SESSION["usuario_conectado"]) ) {
           $msg_erro .= utf8_decode("Session usuario_conectado não existe.").$msg_final;
           echo $msg_erro;               
           exit();                                          
     }   
     ////  Autor do Projeto  ou   Chefe/Responsavel 
     $projeto_autor_cod=$codigo_ativa=$_SESSION["usuario_conectado"];              
     ///          
     /// Verificar se a pessoa indicada já consta como anotador (na tabela anotador)
     $sqlcmd = "SELECT * from $bd_2.anotador WHERE codigo=$lncodigousp and cip=$lnprojeto ";
     $resultado = mysql_query($sqlcmd);
     if( ! $resultado ) {
          $msg_erro .='Falha na consulta do anotador -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
          echo $msg_erro;               
          exit();                                          
     }
     ///  Nr. de Projetos de desse Anotador
     $nregs=mysql_num_rows($resultado);
     if( intval($nregs)==1 ) {
         $msg_erro .="Anotador j&aacute; est&aacute; cadastrado nesse Projeto.".$msg_final;
         echo $msg_erro;               
         exit();                                          
     }  
     ///
     ///   Verifica se é necessário incluir registro do anotador na tabela pessoa
     ///
     if( $lncodigousp==-999999999 ) {
         ///    Remover os espacos do nome deixando apenas um entre as palavras
         /***  
         *     IMPORTANTE: alterado em 20180727
         *         toda parte de acentuacao PHP?MYSQL
         *      mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - 
                 Use mysql_select_db() ou mysql_query()
          ***/   
          ini_set('default_charset','utf8');
         ///
         $_SESSION["anotador_nome"] = $anotador_nome = $nome = utf8_encode(trim(preg_replace('/ +/',' ',$nome)));
         $nome_tmp = str_replace(' ','',$nome);
        /// Verificar se é duplicata
        ///  Verificar local onde ativar esses comandos de acentuação:              
                  /***
            *    O charset UTF-8  uma recomendacao, 
            *    pois cobre quase todos os caracteres e 
            *    símbolos do mundo
         ***/
         mysql_set_charset('utf8');
         ///
         $sqlcmd = "SELECT codigousp from $bd_1.pessoa WHERE
               replace(nome,' ','')='$nome_tmp' or e_mail='$e_mailinf' ; ";
        ///
        $resultado = mysql_query($sqlcmd);
        if( ! $resultado ) {
            $msg_erro .='Falha na busca do anotador/nome na tabela pessoa -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
            echo $msg_erro;               
            exit();                                          
        }
        ///
        /// Nr. de pessoas
        $nregs = mysql_num_rows($resultado);
        if( intval($nregs)>0  ) {
            if( isset($resultado) ) mysql_free_result($resultado);
            $msg_erro .="NOME/E_mail em Duplicata (j&aacute; existe uma pessoa com esse nome ou e_mail). Corrija.".$msg_final;  
            echo $msg_erro;               
            exit();
        }
        // Incluir o novo anotador na tabela pessoal.pessoa
        //      OBS. Atribuir ao CODIGOUSP e CPF um valor provisorio baseado no relogio do servidor
        $timeus = microtime(true)*100;
        $codigoprov = -(900000000 + (int) (fmod($timeus*1000,100000000)));
        $cpf = $codigoprov;
        $n_erro=0;
        ///
        ///  Iniciar uma transaction - ex. procedure    
        mysql_query('DELIMITER &&'); 
        mysql_query('begin'); 
        ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
         mysql_query("LOCK TABLES $bd_1.pessoa INSERT");
        /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;
        ///
        mysql_set_charset('utf8');
        $sqlcmd = "INSERT $bd_1.pessoa(codigousp,nome,categoria,cpf,e_mail) values($codigoprov,'$anotador_nome','OUT',$cpf,'$e_mailinf' )";
        $resultado = mysql_query($sqlcmd);
        if( ! $resultado ) {
             $msg_erro .='Falha na inclus&atilde;o do cadastro do anotador na tabela pessoal.pessoa -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
             mysql_query('rollback'); 
             $n_erro=1;
             echo $msg_erro;                 
        } else {
              mysql_query('commit');  
        }
        mysql_query("UNLOCK  TABLES");
        mysql_query('end'); 
        mysql_query('DELIMITER');
        ///  Ocorreu erro
        if( intval($n_erro)>0 ) {
            exit();
        }    
        ///
        /// Atualizar o codigousp como sendo o codigo unico da tabela pessoal.pessoa 
        $sqlcmd = "Select iupessoa from $bd_1.pessoa where codigousp=$codigoprov ";
        $resultado = mysql_query($sqlcmd);
        if( ! $resultado ) {
            $msg_erro .='Falha na busca do cadastro do anotador na tabela pessoal.pessoa -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
            echo $msg_erro;               
            exit();                                          
        } 
        $nregs = mysql_num_rows($resultado);
        if( intval($nregs)>0  ) {
            $lncodigousp = - mysql_result($resultado,0,"iupessoa");
        } else {
            $msg_erro .='Falha na busca do cadastro do anotador na tabela pessoal.pessoa -&nbsp;db/mysql:&nbsp;'.$msg_final;  
            echo $msg_erro;               
            exit();                                          
        }
        $sqlcmd = "UPDATE $bd_1.pessoa set codigousp=$lncodigousp where codigousp=$codigoprov";
        $resultado = mysql_query($sqlcmd);
        if( ! $resultado ) {
            $msg_erro .='Falha na altera&ccedil;&atilde;o do CODIGOUSP do anotador na tabela pessoal.pessoa -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
            echo $msg_erro;               
            exit();                                          
        }
        ///
   }   
   ///   
   ///   Verificar se a pessoa indicada como anotador tem o respectivo e_mail
   $sqlcmd = "SELECT e_mail from $bd_1.pessoa WHERE codigousp=$lncodigousp ";
   $resultado = mysql_query($sqlcmd);
   if( ! $resultado ) {
        $msg_erro .='Falha na consulta do cadastro (pessoa) do anotador -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
        echo $msg_erro;               
        exit();                                          
    } 
    ///  Verificando se encontrou e_mail
    $nregs = mysql_num_rows($resultado);
    if( intval($nregs)>0 ) {
        $e_mail = mysql_result($resultado,0,"e_mail");    
        /// Verificar se e_mail é válido
        if( ! isEmail($e_mail) ) {
            $e_mail="E_mail inválido. Corrigir.";
        }  
     } else {
         $e_mail="E_mail inválido. Corrigir.";
     }
     /// Atualizar todas as tabelas necessárias ao uso do anotador:
     ///  pessoa(e_mail, se necessário=alterado);
     ///  usuario(novo, se não existir);
     ///  participante(novo, se não existir);
     ///  anotador(novo)
     ///
      $session_tabela = $_SESSION["tabela"];
      $n_erro=0;
      ///  Iniciar uma transaction - ex. procedure    
      mysql_query('DELIMITER &&'); 
      mysql_query('begin'); 
      ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
      mysql_query("LOCK TABLES $bd_1.pessoa UPDATE");
      /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;
      ///
      ///   VERIFICA se necessario ALTERAR o e_mail do anotador
      if( $e_mailinf<>$e_mail ) {
          $e_mail = $e_mailinf;
          /// mysql_query("LOCK TABLES pessoal.pessoa UPDATE");
          $sqlcmd = "UPDATE $bd_1.pessoa SET e_mail = '".$e_mailinf."' WHERE codigousp=$lncodigousp ";
          $resultado = mysql_query($sqlcmd);
          if( ! $resultado ) {
              /// Ocorreu ERRO - MySQL  UPDATE
              $msg_erro .='UPDATE pessoa set e_mail -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
              mysql_query('rollback'); 
              $n_erro=1;
              echo $msg_erro;               
          } else {
              mysql_query('commit');  
          }
          /// mysql_query("UNLOCK  TABLES");
      }
      mysql_query("UNLOCK  TABLES");
      mysql_query('end'); 
      mysql_query('DELIMITER');
      ///  Ocorreu erro
      if( intval($n_erro)>0 ) {
           exit();
      }
      ///
      ///   Verifica se é necessário incluir registro do anotador na tabela usuário
      $sqlcmd = "SELECT aprovado FROM $bd_1.usuario WHERE codigousp=$lncodigousp ";
      $resultado = mysql_query($sqlcmd);
      /// Verifica se houve ERRO - MySQL SELECT
      if( ! $resultado ) {
           $msg_erro .='Falha na consulta do anotador na tabela usuario -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
           echo $msg_erro;               
           exit();                                          
      } 
      $nregs=mysql_num_rows($resultado);
      /// Controlar o envio de senha pelo e_mail do anotador, caso seja nova.
      $senha = "";      
      
      ///  Caso Anotador NAO consta na Tabela usuario  
      if( intval($nregs)<1 ) {
          /// Anotador ainda NAO foi incluído no usuário
          /// Entao, iniciar todos os campos necessário a tabela usuário:
          $nposi = strpos($e_mail, "@");       // Extraindo o login do e_mail
          /// Note: use ===. because the position of 'a' was the 0th (first) character.
         if( $nposi === false || $nposi==0) {
              $msg_erro .='E_MAIL inv&aacute;lido = '.$e_mailinf.$msg_final;  
              echo $msg_erro;               
              exit();                                          
          }
          ///  Gerando dados do ususario/anotador
          $login = substr($e_mail,0,$nposi);
          $senha = trim(substr($login,0,4)).trim(rand(0,99999));
          $datacad = date("Y-m-d");
          $odata = new DateTime($datacad);  
          ///  echo $odata->format('d/m/Y')."<br><br>";  
          ///  adiciona 1 semana na data  
          ///  $odata->modify('+1 week');  
          ///   echo $odata->format('d/m/Y')."<br><br>";  
          ///   remove 14 dias da data  
          ///  $odata->modify('-14 days');  
          $odata->modify('+730 days');
          $datavalido = $odata->format('Y-m-d');
          $codigoprov = $lncodigousp;
          $pa = $pa_anotador;
          ///
          /// Indica que o anotador está aprovado (autorizado) para usar o REXP
          $aprovado = 1;                 
          $activation_code = 0;
          $n_erro=0;
          /***
                     Incluindo anotador na tabela usuario
          **/
          mysql_query('DELIMITER &&'); 
          mysql_query('begin'); 
          ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
          mysql_query("LOCK TABLES $bd_1.usuario INSERT");
          //
          /// mysql_query("LOCK TABLES pessoal.usuario WRITE");
          $sqlcmd = "INSERT $bd_1.usuario values('$login',password('$senha'),'$datacad','$datavalido',$codigoprov,$pa,$aprovado,$activation_code )";
          $resultado = mysql_query($sqlcmd);
          if( ! $resultado ) {
              ///  Ocorreu ERRO -  MySQL INSERT 
              $msg_erro .='Incluindo anotador na tabela usuario -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
              mysql_query('rollback'); 
              $n_erro=1;
          } else {
              mysql_query('commit');  
          }
          mysql_query("UNLOCK  TABLES");
          mysql_query('end'); 
          mysql_query('DELIMITER');
          ///  Ocorreu erro
          if( intval($n_erro)>0 ) {
               echo $msg_erro;               
               exit();
          }
          ///          
         ///  mysql_query("UNLOCK  TABLES");
      }  
      /****  Final - Caso Anotador NAO consta na Tabela usuario     ******/
      ///
      ///   Verifica se é necessário incluir registro do anotador na tabela participante
      $sqlcmd = "SELECT aprovado from $bd_2.participante "
                ."  WHERE codigousp=$lncodigousp and pa=$pa_anotador  and codigo_ativa=$projeto_autor_cod ";
      ///                
      $resultado = mysql_query($sqlcmd);
      if( ! $resultado ) {
          $msg_erro .='Falha na consulta do anotador na tabela participante -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
          echo $msg_erro;               
          exit();                                          
      } 
      /// Numero de registros do Select da Tabela particiapnte
      $nregs=mysql_num_rows($resultado);
      if( intval($nregs)<1 ) {
          /// Anotador ainda NAO foi incluído na tabela participante
          /// Entao, iniciar todos os campos necessário a tabela participante:
          $usuario_ci = 0;
          $codigoprov = $lncodigousp;
          $datacad = date("Y-m-d");
          $odata = new DateTime($datacad);  
          $odata->modify('+730 days');
          $datavalido = $odata->format('Y-m-d');
          $pa = $pa_anotador;
          $codigo_ativa = $_SESSION["usuario_conectado"];
          $aprovado = 1;        /// Indica que o anotador está aprovado (autorizado) para usar o REXP
          $chefe = 0;
          ///
          $n_erro=0;
          ///  Iniciar uma transaction - ex. procedure    
          mysql_query('DELIMITER &&'); 
          mysql_query('begin'); 
          mysql_query("LOCK TABLES $bd_2.participante INSERT ");
          ////   
          $sqlcmd = "INSERT $bd_2.participante values($usuario_ci,$codigoprov,'$datacad','$datavalido',$pa,$codigo_ativa,$aprovado,$chefe )";
          $resultado = mysql_query($sqlcmd);
          if( ! $resultado ) {
              $msg_erro .='Incluindo anotador na tabela participante -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
              echo $msg_erro;               
              $num_erro=1;
              /// Ocorreu erro - cancelando
              mysql_query('rollback'); 
          }  else {
              ///  inserindo participante - ok
              mysql_query('commit'); 
          }
          ///
          /// Concluir a transaction
          //***mysql_query("UNLOCK  TABLES");
          mysql_query('end'); 
          mysql_query('DELIMITER');            
          ///  Ocorreu erro
          if( intval($n_erro)>0 ) {
              exit();                                                 
          }
          /// 
         /// mysql_query("UNLOCK  TABLES");
   }  
   ///
   ///   Incluir registro do anotador na tabela anotador
   ///***mysql_query("LOCK TABLES rexp.anotador WRITE");
   $anotador_ci = 0;        // Chave auto incremento
   $cip = $lnprojeto;
   $codigo = $lncodigousp;
   $pa = $pa_anotador;
   $data =  date("Y-m-d H:i:s");
   ///
   $n_erro=0;
   /***          Incluindo Anotador     
           Iniciar uma transaction - ex. procedure    
   ***/
   mysql_query('DELIMITER &&'); 
   mysql_query('begin'); 
   ///  Execute the queries 
   mysql_select_db($db_array[$elemento]);
   ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
   mysql_query("LOCK TABLES $bd_2.anotador INSERT ");
   ////   
   $sqlcmd = "INSERT into $bd_2.anotador values($anotador_ci,$cip,$codigo,$pa,'$data')";
   $resultado = mysql_query($sqlcmd);
   if( ! $resultado ) {
       $msg_erro .='Incluindo anotador na tabela anotador -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
       $n_erro=1;
       mysql_query('rollback'); 
       //***mysql_query("UNLOCK  TABLES");
       echo $msg_erro;               
   } else {
       mysql_query('commit'); 
   }
   /// Concluir a transaction
   //*** mysql_query("UNLOCK  TABLES");
   mysql_query('end'); 
   mysql_query('DELIMITER');            
   ///  Ocorreu erro
   if( intval($n_erro)>0 ) {
       exit();                                                 
   }
   ///
   ///  Enviar e_mail ao anotador informando aprovação para uso do REXP
   ///
   ///  Buscar o e_mail do Orientador que está cadastrando esse anotador
   $codigoprov = $_SESSION["usuario_conectado"];
   $sqlcmd = "SELECT  e_mail FROM  $bd_1.pessoa WHERE codigousp=$codigoprov";
   $resultado = mysql_query($sqlcmd);
   if( ! $resultado ) {
        $msg_erro .='Buscando o e_mail do orientador do projeto na tabela pessoa -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
        echo $msg_erro;               
        exit();                                          
   } 
   ///  Numero de registros
   $nregs_e_mail=mysql_num_rows($resultado);
   if( intval($nregs_e_mail)<1 ) {
        $msg_erro .='Buscando o e_mail do orientador do projeto na tabela pessoa não encontrado.'.$msg_final;  
        echo $msg_erro;               
        exit();                                          
   } 
   ///
   ///  Variavel de e_mail Orientador do Projeto selecionado
   $e_mailorientador = mysql_result($resultado,0,"e_mail");
   ///
    ///   IMPORTANTE: excelente para acentuacao da tag SELECT -  e tb  htmlentities        
    mysql_query("SET NAMES 'utf8' ");
    mysql_query("SET character_set_connection=utf8");
    mysql_query("SET character_set_client=utf8");
    mysql_query("SET character_set_results=utf8");
    
   ///  Buscar o Titulo do Projeto autorizado para uso do Anotador
   $sqlcmd = "SELECT a.titulo,a.numprojeto,b.nome as nome_autor,b.e_mail as orientador_email "
             ." FROM $bd_2.projeto as a, $bd_1.pessoa b "
             ." WHERE cip=$lnprojeto and a.autor=b.codigousp ";
   ///
   $resultado = mysql_query($sqlcmd);
   if( ! $resultado ) {
        $msg_erro .='Buscando o titulo do projeto na tabela projeto -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
        echo $msg_erro;               
        exit();                                          
   } 
  ///  Numero de registros
   $nregs=mysql_num_rows($resultado);
   if( intval($nregs)<1 ) {
        $msg_erro .='Buscando dados do projeto e do orientador não encontrado.'.$msg_final;  
        echo $msg_erro;               
        exit();                                          
   } 
   ///  Anotador Nome para ser incluido 
   $anotador_nome=$_SESSION["anotador_nome"];
       
   ///  Dados do Projeto e do Orientador
   $projeto_titulo = mysql_result($resultado,0,"titulo");
   $projeto_numero = mysql_result($resultado,0,"numprojeto");
   $projeto_autor = mysql_result($resultado,0,"nome_autor");
   $orientador_email = mysql_result($resultado,0,"orientador_email");    
    ///
    if( strlen(trim($senha))<1 ){
        $senha="Usar a mesma senha anteriormente criada.";
    } 
    $senha_criada=$senha.'<br/><br/>';
    if( isset($e_mail) ) {
        $anotador_email=$e_mail;  /// $e_mailinf;        
    } else {
       if( isset($arr_nome_val["e_mail"]) ) $anotador_email=$arr_nome_val["e_mail"];
    }   
    ///
    $user=$codigoprov;
    ///  Alterado em 20180711            
    ini_set('default_charset','UTF-8');
    ///  Definindo http ou https
    $url_central=$_SESSION["url_central"];
    ////  $m_local = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
    $m_local = html_entity_decode("$url_central");
    //  $m_local = html_entity_decode($_SESSION['url_folder']);
    $a_link = "***** CONEXÃO DE ATIVAÇÂO *****\n<br><a href='$m_local'  title='Clicar' >$m_local</a>"; 
    ///
    ////  $assunto =html_entity_decode("RGE/SISTAM/REXP - Permissão para Anotador");    
    $assunto ="RGE/SISTAM/REXP - Permissão para Anotador";    
    
    ///  $corpo ="RGE/SISTAM/REXP - Permissão para Anotador do Projeto $projeto_numero <br>(Orientador: $projeto_autor)";
    $corpo ="RGE/SISTAM/REXP - Registro de Anotações<br/>Autorização para Anotador: "
             ."<br/>Projeto: $projeto_numero - $projeto_titulo<br/>(Orientador: $projeto_autor)"
             ."<br/><br/>Anotador:&nbsp;".$anotador_nome."<br/>Senha:&nbsp;$senha_criada";
    ///       
    /// $corpo .="$host_lower/rexp<br><br>";
    $headers1  = "MIME-Version: 1.0\n";
    ///  Alterado em 20180711            
    $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
    ///  $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
    $headers1 .= "X-Priority: 3\n";
    $headers1 .= "X-MSMail-Priority: Normal\n";
    $headers1 .= "X-Mailer: php\n";
  //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
   //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
   //  From e  Bcc  (Para e Copia Oculta)                    
   $headers1 .= "From: $projeto_autor <$orientador_email>\r\n";                    
   //  $headers1 .= "Bcc: gemac@genbov.fmrp.usp.br\r\n"; 
   //  $headers1 .= "Bcc: bezerralaf@gmail.com; spfbezer@fmrp.usp.br\r\n";                   
   ///  $headers1 .= "Bcc: {$_SESSION["gemac"]} \r\n";                   
   $headers1 .= "Bcc: $gemac_email \r\n";                   
   /// $headers1 .= "Bcc: bezerralaf@gmail.com; spfbezer@gmail.com  \r\n";                   
   
   $message = "$corpo\n<br><br>

   $a_link<br><br>

   ______________________________________________________<br>
   Esta é uma mensagem automática.<br> 
   *** Não responda a este EMAIL ****
   ";
   
   //if ( mail($aprovador_email, stripslashes(utf8_encode($assunto)), $message,$headers1)  ) {
   // SEMPRE TESTAR O COMANDO MAIL -  SE A MENSAGEM FOI ENVIADA  
   //  $envio = mail($anotador_email, $assunto, $message,$headers1,"-r".$emailsender);  
   $emailsender="$orientador_email";
    ///  Enviando mensagem para o novo anotador
    //// $envio = mail($anotador_email, $assunto, $message,$headers1,"-r".$emailsender);
    ///   $envio = mail($anotador_email, $assunto, $message,$headers1,"-f".$emailsender);
    $envio = mail($anotador_email, $assunto, $message,$headers1,"-r".$emailsender);
        ///  Alterado em 20180711            
    ini_set('default_charset','UTF-8');
   ///
////   $_SESSION["anotador_nome"]= $anotador_nome = utf8_encode($anotador_nome);
   ///
   ///  Enviando mensagem na tela 
   if( $envio ) {
       $msg_ok .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; '>"
                 ."<br>&nbsp;&nbsp;Mensagem enviada para o novo Anotador cadastrado nesse Projeto:<br/><b>$projeto_titulo</b>:<br/>"
                 ."<br/>&nbsp;Anotador:&nbsp;<b>".$anotador_nome."</b><br/>E_mail:&nbsp;".$e_mail."<br><br></span>".$msg_final;
       echo $msg_ok;                        
   } else {
       $msg_erro .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; '>"
                 ."Mensagem <b>N&Atilde;O</b> foi enviada para o novo Anotador cadastrado nesse Projeto:<br/><b>$projeto_titulo</b>:<br/>"
                 ."<br/>&nbsp;Anotador:&nbsp;<b>".$anotador_nome."</b><br/>E_mail:&nbsp;".$e_mail."<br/><br/></span>".$msg_final;
       echo $msg_erro;              
    }
    ///    Final - enviar a mensagem por email
    /// 
}    
#
ob_end_flush(); /* limpar o buffer */
#
?>