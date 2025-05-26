<?php
//   Arquivo para CADASTRAR 
//
//  Funcao para busca com acentos
function stringParaBusca($str) {
    // Transformando tudo em min?sculas
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
    
    /// Retornando a String finalizada!
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
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}

ob_start(); /* Evitando warning */
// set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

///  header("content-type: application/x-javascript; charset=tis-620");
///  header("content-type: application/x-javascript; charset=iso-8859-1");
/// header("Content-Type: text/html; charset=ISO-8859-1",true);
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');

//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
ini_set('default_charset','UTF-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///  Verificando SESSION incluir_arq
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
///   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

///  Conjunto de arrays 
include_once("{$incluir_arq}includes/array_menu.php");
//
// Conjunto de Functions
require_once("{$incluir_arq}includes/functions.php");    
if( isset($val) ) $val_upper=strtoupper(trim($val)); 
///
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
///   Para acertar a acentuacao - utf8_encode
///   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;
$source=trim($source);
$_SESSION["source"]=$source;
///  Converter para maiuscula
$opcao=strtoupper($source);
//
//  Selecionando a Tabela dos  PA?s   
$elemento=5; $elemento2=6;
/// require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) {
   $array_pa=$_SESSION["array_pa"];      
   $_POST["array_pa"]=$_SESSION["array_pa"];       
} 
////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
if( $opcao=="SAIR" ) {
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
} elseif( $opcao=="IMAGEM" ) {
   /*   Processando Codigo     */
   if( isset($m_onload)  ) {
        if( strtoupper($m_onload)=="OK"   ) {
              /*
             $ls = "ls -Rx imagens/img_temp/* ";
             $ver = shell_exec($ls);
             $ver = explode("imagens/img_temp/",$ver);
             $length = count($ver);
             $ver_array="";
             if( $length==60 ) {
                 $metade = $length/2;
                 for( $i=0; $i < $metade; $i++ ) {
                     $arquivo_rm = "imagens/img_temp/".$ver[$i]; 
                     $rm = "rm -f $arquivo_rm";
                     shell_exec($rm);
                 } 
             }
             */
              ///  $rm = "find imagens/img_temp/  -name 'senha*.gif' -cmin 1 -exec rm -rf {} ";
              ///  shell_exec($rm);
              ///   IMPORTANTE: Na Pasta para imagens criadas tem  que ser do usuario e grupo  -  apache.apache
              $rm = "/usr/bin/find imagens/img_temp/  -name  'senha_*.gif' -cmin +40 -delete ";
              shell_exec($rm);
              ///
              $loop = true;
              while( $loop ) {
                   /// $date_brazilian = date("Ymd").time(); 
                   $time_start = microtime(true);
                   $date_brazilian = gmdate("Ymd").$time_start; 
                  //   IMPORTANTE: Na Pasta para imagens criadas tem  que ser do usuario e grupo  -  apache.apache
                  $arqimagem =  "imagens/img_temp/senha_".$date_brazilian.".gif";
                  $loop = file_exists($arqimagem);
              }
              ///
              //// @include("/var/www/cgi-bin/php_include/ajax/codigo/codimage_ajax.php"); 
              @include("php_include/ajax/codigo/codimage_ajax.php"); 
              exit();
        }       
  } 
  ///
} elseif( $opcao=="E_MAIL" )  {        
        /***   PRIMEIRA PARTE DO ARQUIVO cadastrar_auto_por_email.php   ***/
           
        /// Selecionando campos     
        $elemento=5;$elemento2=6;
        ///  require_once("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");         
        require_once("php_include/ajax/includes/conectar.php");         
        ////  Obtendo o pa do Orientador - para criar um NOVO
        if( isset($_SESSION["array_pa"]) ) {
            $array_pa=$_SESSION["array_pa"];    
            $orientador_pa=$array_pa["orientador"];                            
        } 
        $upper_e_mail=strtoupper(trim($val));
        $where = " upper(trim(a.e_mail))='$upper_e_mail'  and "; 
       ////  MySql - Select - procurando orientador
       $sqlcmd = "SELECT a.codigousp,a.nome,a.cpf,a.e_mail,a.sexo,b.login,b.aprovado,c.pa from  "
                  ." $bd_1.pessoa a, $bd_1.usuario b, $bd_2.participante c where  "
                  ." $where  a.codigousp=b.codigousp and a.codigousp=c.codigousp and c.pa=".$orientador_pa;
        ///
       $result_usu = mysql_query($sqlcmd);   
       if( ! $result_usu ) {
             $msg_erro .= "SELECT tabelas pessoa, usuario e participante -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final; 
            echo $msg_erro;
            exit();
       }
       ///  numero de registros
       $n_regs = mysql_num_rows($result_usu);
       if( intval($n_regs)==1 ) {
          //  Dados Resultado das Tabelas acima  pessoa, usuario e participante
          /*
             $aprovado=mysql_result($result_usu,0,"aprovado");   
             $sexo=mysql_result($result_usu,0,"sexo");   
             $e_mail=mysql_result($result_usu,0,"e_mail");   
             $codigousp=mysql_result($result_usu,0,"codigousp");   
          */
           ///  Definindo os nomes dos campos recebidos do MYSQL SELECT
           if( isset($array_nome) ) unset($array_nome);
           $array_nome=mysql_fetch_array($result_usu);
           foreach( $array_nome as $chave_cpo => $valor_cpo ) $$chave_cpo=$valor_cpo;
       }
       ///  incluindo arquivo orientador_ja_cadastrado.php
       require_once("orientador_ja_cadastrado.php");      
       ///
       exit();
       //// 
} elseif( $opcao=="CAMPOS_OBRIGATORIOS" )  {    
       ///  Definindo variavel de erro
      $m_erro="";
     // Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
      include('dbc.php');
      //   Vericando os campos  recebidos pelo FORM
     $m_usuario_arr = array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
     $m_senha_arr = array('SENHA','PASSWD','PASSWORD');
     $array_email = array("EMAIL","E_MAIL","USER_EMAIL","EMAIL_USER");
     $array_cpos = array("CODIGOUSP","NOME","CPF","LOGIN","E_MAIL");   
    $upper_cpo=strtoupper(trim($val)); 
    if( in_array($upper_cpo,$array_cpos) ) {
        if( $upper_cpo=="CODIGOUSP" ) {
             $m_array = (int) trim($m_array);
             $where = " b.codigousp=$m_array  and "; 
             //  Verifica o CODIGOUSP - obrigado digitar 0 case no tenha
             if( strlen($m_array)<1 ) $m_erro="Caso não tenha o Código/USP ? necessário digirar 0"; 
        } elseif($upper_cpo=="NOME" ) {
            $m_array = (string) $m_array;
            //  PHP ? Remover os espa?os em excesso de uma string/variavel - exemplo: nome
            $m_array = trim(preg_replace('/ +/',' ',$m_array));            
             //   ACERTAR O CAMPO NOME, retirando acentua??o e passando para maiusculas
           $upper_nome=stringParaBusca2(strtoupper(trim($m_array)));
           //  Acertando ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
           $where = " upper(trim(a.nome))='$upper_nome'  and "; 
        }  elseif($upper_cpo=="CPF" ) {
             $m_array=preg_replace('/[.-]+/','',$m_array);
             $where = " trim(a.cpf)='$m_array'  and "; 
        }  elseif($upper_cpo=="LOGIN" ) {
              $m_array = (string) $m_array;
              $upper_login=strtoupper(trim($m_array));
              $where = " upper(trim(b.login))='$upper_login'  and "; 
        // }  elseif($upper_cpo=="E_MAIL" ) {                         
        }  elseif( in_array($nome_campo,$array_email) ) {
              $m_array = (string) $m_array;
              //  Validar Email
              if( ( ! isEmail($arr_nome_val[email]) )  and ( strlen(trim($m_erro))<1  )   ) {
                  $m_erro= "Endere&ccedil;o de email inv&aacute;lido";                     
              } else {
                 $upper_e_mail=strtoupper(trim($m_array));
                 $where = " upper(trim(a.e_mail))='$upper_e_mail'  and ";                  
              }
        }  
        //  Verifica se houve erro nos campos        
        if( strlen(trim($m_erro))>=1 ) {
              $msg_erro .= $m_erro.$msg_final; 
              echo $msg_erro;
              exit();
        }
        $tipo_val = gettype($m_array);
        //   Obtendo o pa do Orientador - para criar um novo
        //       $orientador_pa = $_SESSION["array_usuarios"]["orientador"];   
        if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];    
        $orientador_pa=$array_pa["orientador"];                                 
        /*
        $msg_erro .= " cadastrar_auto_por_email_ajax.php/332 -  \$orientador_pa = $orientador_pa ";
        echo  $msg_erro;
        exit();      
          */
                        
        // Selecionando campos     
        $elemento=5;$elemento2=6;
        /// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php"); 
        include("php_include/ajax/includes/conectar.php"); 
     /*      
        $sqlcmd = "SELECT a.codigousp,a.nome,a.cpf,a.e_mail,a.sexo,b.login,b.aprovado from  "
                  ." pessoal.pessoa a, pessoal.usuario b where  "
                  ." $where  a.codigousp=b.codigousp and b.pa=$orientador_pa ";
    */
       $sqlcmd = "SELECT a.codigousp,a.nome,a.cpf,a.e_mail,a.sexo,b.login,b.aprovado,c.pa from  "
                  ." $bd_1.pessoa a, $bd_1.usuario b, $bd_2.participante c where  "
                  ." $where  a.codigousp=b.codigousp and a.codigousp=c.codigousp and c.pa=".$orientador_pa;
        ///
        /*
        $cmdsql="SELECT a.pa FROM rexp.participante a, pessoal.pessoa b "
             ." WHERE (a.codigousp=b.codigousp ) and trim(b.e_mail)=\"$usuario_email\" order by a.pa  ";

    $resultado_pa=mysql_query($cmdsql);
    if( ! $resultado_pa  ) {
        mysql_free_result($resultado_pa);
        die('ERRO: SELECT participante/pessoa: '.mysql_error());
        exit();  
    }                                 
            */   
       $result_usu = mysql_query($sqlcmd);               
       if( ! $result_usu ) {
           $msg_erro .= "SELECT Usu&aacute;rio/Orientador -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
           echo $msg_erro;
           exit();  
       }
       $n_regs = 0;
       $n_regs = mysql_num_rows($result_usu);
       require_once("orientador_ja_cadastrado.php");
    }
    ///  echo  $msg_erro;
    exit();    
    ///
} elseif( $opcao=="CONJUNTO" )  {
     /// PARTE PARA MUDANCA DE CAMPO - IMPORTANTE
	 $n_cpo = (int) $n_cpo; $cpo_final = (int) $cpo_final;
     unset($m_linhas); $m_vars_ambiente = $_SESSION['VARS_AMBIENTE'];
	 if( ! is_array($m_array) ) $m_array  = explode(",",$m_array);
     if( ! isset($_SESSION["key"]) ) $_SESSION["key"]=0;
	 if( $n_cpo<=$cpo_final ) { //  Inicio do IF principal
	     $cpo_where=$m_array[0];
		 //  $pos_encontrada = array_search($cpo_where,$m_array);
		 //  Definindo a posicao para o proximo campo 
         $_SESSION["key"]= (int) $_SESSION["key"]+1;		 
		 $total_array=sizeof($m_array);
		 if( strtoupper($cpo_where)=="INSTITUICAO" ) {
		      $i=2;  unset($_SESSION['campos_dados1']);
			  unset($_SESSION['campos_dados2']);
              $_SESSION["key"]=0;			  
		 } else {
             $i=0;
              for( $j=1; $j<$total_array; $j++ ) {
                  if( $cpo_where==$m_array[$j] ) {
                      $i=$j+1;             
                      break;
                  }
            
              }
			 //  Verifica se esse campo ja foi selecionado no array
			 //  remover o anterior
			 if( $_SESSION['campos_dados1'] ) {
			      $total = sizeof($_SESSION['campos_dados1']); 
			      for( $ver=0; $ver<$total ; $ver++ ) {
				      if( $cpo_where==$_SESSION['campos_dados1'][$ver] or $j<$total  ) {
					       $_SESSION["key"]=$ver;  // Importante depois de achar duplicata
					       for( $ver; $ver<$total ; $ver++ ) {
						        unset($_SESSION['campos_dados1'][$ver]);
						        unset($_SESSION['campos_dados2'][$ver]);		
						   }							   
					  }  
				  }
			 }
		 }
		 //
         $table_atual = $m_array[$i]; $upper_val=strtoupper($val); 
         $_SESSION["select_cpo"]="sigla";
		 $array2 = array("bloco","salatipo","sala");
		 //  Precisava passar a variavel 
		 if( strtoupper($cpo_where)=="SALA" ) $table_atual="sala";	
		 $chave = $_SESSION["key"];
	     $_SESSION['campos_dados1'][$chave]=$cpo_where;
         $_SESSION['campos_dados2'][$chave]=$val;
         //
		//  Precisava passar a variavel 
        //  Mudando a variavel - $table_atual       
       if( strtoupper(trim($cpo_where))=="INSTITUICAO" && strtoupper(trim($table_atual))=="SALATIPO"  ) {
       //   if(  strtoupper(trim($table_atual))=="SALATIPO"  ) {
           $msg_erro .= "-> cadastrar_auto_ajax.php/305  - FALHA GRAVE ";
           echo  $msg_erro;   
           exit();
       }
       $select_cpo=$_SESSION["select_cpo"];
       if( strtoupper($table_atual)=="BLOCO" || strtoupper($table_atual)=="SALATIPO" || strtoupper($table_atual)=="SALA" ) { 
               $_SESSION["select_cpo"]=$table_atual; 
               $select_cpo=$_SESSION["select_cpo"];
               $table_atual="bem"; 
               $apagaressavar="";
	   } 						
	   $_SESSION["where"]="";			
	   $total_arrays = sizeof($_SESSION['campos_dados1']);		
	   for( $row = 0; $row < $total_arrays; $row++) {
		     $_SESSION["where"].= " upper(trim(".$_SESSION['campos_dados1'][$row]."))=";
			 $p2 = $_SESSION['campos_dados2'][$row];
			 $_SESSION["where"].=  " \"$p2\" ";
			 if( $row<($total_arrays-1) ) $_SESSION["where"].=  " and ";
		}
        $where=$_SESSION["where"];
	    // Selecionando campo 	
       $elemento=3;
       include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");	
	   $tabs_sig_nome= array("instituicao","unidade","depto","setor");			    
	   $nome_cpo="";
	   if( in_array($table_atual,$tabs_sig_nome) ) $nome_cpo="nome,";          
       
      //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
 	/*
       $result=mysql_query("SELECT ".$_SESSION["select_cpo"].", $nome_cpo count(*) FROM "
    			         ." $table_atual where ".$_SESSION["where"]."  group by 1 order by  ".$_SESSION["select_cpo"]);
                          
       */
       //  $sqlcmd="SELECT $select_cpo, $nome_cpo count(*) FROM  $table_atual where $where   group by 1  order by $select_cpo ";
       $sqlcmd="SELECT $select_cpo, $nome_cpo count(*) FROM  $table_atual where $where  group by 1 order by $select_cpo ";
       $result=mysql_query($sqlcmd);
		if( strtoupper($table_atual)=="BEM" ) $table_atual=$_SESSION["select_cpo"]; 
  	    if( ! $result ) {
           $msg_erro .= "SELECT tabela $table_atual -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
           echo $msg_erro;
           exit();  
        }
        $m_linhas = mysql_num_rows($result);
		//
		$_SESSION["table_atual"]=$table_atual;
		$cp_table_atual=$table_atual; $cp_cpo_where=$cpo_where;
		if( strtoupper($cp_table_atual)=="INSTITUICAO" ) $cp_table_atual="institui??o";
		if( strtoupper($cp_cpo_where)=="INSTITUICAO" ) $cp_cpo_where="institui??o";
		if( strtoupper($cp_table_atual)=="DEPTO" ) $cp_table_atual="departamento";
		if( strtoupper($cp_cpo_where)=="DEPTO" ) $cp_cpo_where="departamento";  
        // 
		if( $m_linhas<1 )  {
		       /* echo "==== Nenhum(a) <b>".ucfirst($table_atual)."</b> desse(a) <b>"
									 .ucfirst($cpo_where)."</b> ====";	*/
		       echo "==== Nenhum(a) <b>".ucfirst($cp_table_atual)."</b> desse(a) <b>"
									 .ucfirst($cp_cpo_where)."</b> ====";	
		       exit();
	    }  //  Final do IF - m_linhas<1						   
		//  Executar IF quando nao for o ultimo campo
		if( $i<$cpo_final ) {
				?>
	         <span class="td_informacao2"  >
		     <label for="<?php echo $table_atual;?>" style="cursor:pointer;" >&nbsp;<?php echo ucfirst($table_atual);?>:</label><br /><br />
           <!--  Tag Select com title para ser verificada          	     
             <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviando_dados('CONJUNTO',this.value,this.name+'|'+'<?php echo $m_vars_ambiente;?>');" style="padding: 1px;" title="<?php echo ucfirst($cp_table_atual);?>"  >			
            -->
             <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviando_dados('CONJUNTO',this.value,this.name+'|'+'<?php echo $m_vars_ambiente;?>');" style="padding: 1px;" >            
             <?php
          	     //  acrescentando opcoes
	             echo "<option value='' >Selecionar&nbsp;</option>";
                 while( $linha=mysql_fetch_array($result) ) {   //  WHILE  DA TAG SELECT    
    				      //  Desativando selected - opcao que fica selecionada
						  if( isset($linha["sigla"]) ) {
			    			     $value = urlencode($linha["sigla"]);
								 $nome = trim(htmlentities($linha["sigla"]));
						  } elseif( in_array($table_atual,array("bloco","salatipo","sala")) ) {
						         $select_cpo=$_SESSION["select_cpo"];
			    			     //  $value = urlencode($linha[$select_cpo]);
								 $value = trim(htmlentities($linha[$select_cpo]));
								 $nome = trim(htmlentities($linha[$select_cpo]));						  
						  }
				          $inst_selected = "";	$traco="";
                          $se_sigla=""; $se_nome="";
						  if( strlen($nome_cpo)>1 ) {
						      //  htmlentities - o melhor para transferir na Tag Select
                              if( isset($linha["sigla"]) ) $se_sigla= htmlentities($linha["sigla"]);  
                          	  if( isset($linha["nome"]) ) $se_nome= htmlentities($linha["nome"]); 
							  $traco="-";				  
						  }	  
                          $title_sigla=$se_sigla."&nbsp;".$traco."&nbsp;".$se_nome;
	                      echo  "<option $inst_selected   value=".$value."  title=".$title_sigla." >";
               		      echo  $nome."&nbsp;</option>" ;
   	              }  // FIM DO WHILE
	       	  ?>
	          </select>
	          </span>
			  <?php
                 mysql_free_result($result); 
    	         // Final do SELECT
                 if( strtoupper(trim($_SESSION["select_cpo"]))=="SALA" ) {
                       $cpo_final=0; $n_cpo=0; unset($m_array); unset($m_linhas); unset($source);
                       unset($_SESSION["where"]);  unset($_SESSION["select_cpo"]);
                 }
		  } else {
		     //  Executando o Mysql Select do ultimo campo
			 unset($m_linhas); 
		  } //  FINAL DO - IF i < cpo_final
     }  ///  Final do IF principal 
     exit();
}
///  Serve tanto para o arquivo projeto  quanto para o experimento
///  Primeira PARTE da TABELA ANOTACAO
///    Tabela do ORIENTADOR 
if( strtoupper($val)=="ORIENTADOR_NOVO" ) {
      ///  Definindo a variavel de ERRO
      $m_erro="";
      //  Conectar
      // Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
     //   include('dbc_novo_orientador.php');
      $elemento=5; $elemento2=6; 
      /// require_once("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
      require_once("php_include/ajax/includes/conectar.php");
      require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
      ///
      if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];    
     ///  Recebendo dados do FORM e Inserindo
     ///  nas Tabelas ANOTACAO e  PROJETO
     if( isset($array_temp) )  unset($array_temp); 
     if( isset($array_t_value) ) unset($array_t_value); 
     if( isset($arr_nome_val) ) unset($arr_nome_val); 
     if( isset($count_array_temp) ) unset($count_array_temp);
     if( isset($_SESSION["codigousp_novo"]) )  unset($_SESSION["codigousp_novo"]);
     ///
     include_once("dados_campos_form_cadastrar_auto.php");
     //  Verificando campos 
     $m_regs=0;
    //  Vericando se o Codigo/USP se ja esta cadastrado na Tabela pessoa
    $arr_nome_val['codigousp'] = (int) trim($arr_nome_val['codigousp']);
    //  Definindo os nomes dos campos recebidos do FORM
    foreach(  $arr_nome_val as $key => $value ) $$key =  $value;
     //
     //  Verificando o Codigo de Imagem
    if ( $magica!==$confirm ) {
        $msg_erro .= "O c&oacute;digo est&aacute; errado";
        echo  $msg_erro;   
        exit();
    }
    $codigousp_length = strlen($arr_nome_val['codigousp']);
    
    if( $codigousp_length<1  ) {
         $m_erro="&nbsp;Caso não tenha o Código/USP ? necessário digirar 0"; 
    } elseif( $codigousp_length==1 ) {
         //  CRIANDO um novo CODIGOUSP do Orientador
         include("novo_codigousp_orientador.php");
         //  SESSION recebida do arquivo  ->  novo_codigousp_orientador.php
         if( isset($_SESSION["codigousp_novo"]) ) $codigousp=$_SESSION["codigousp_novo"];
         
    }  elseif( $codigousp_length>1 ) {
        $m_erro="Verificar o codigousp se existi.";
    }   
    ///  Verifica erro
    if( strlen(trim($m_erro))<1 ) {
         ///  Verificando resultado do arquivo - novo_codigousp.php
         ///   Vericando se o LOGIN/USUSAIO se ja esta cadastrado na Tabela usuario
         $m_usuario_arr = array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
         $m_senha_arr = array('SENHA','PASSWD','PASSWORD');
         $array_email = array("EMAIL","E_MAIL","E-MAIL","USER_EMAIL","EMAIL_USER");
         //  Definindo os nomes dos campos recebidos do FORM
         // //  while ( $arr_nome_val = mysql_fetch_array($result_projeto,MYSQL_ASSOC) ) { 
         foreach( $arr_nome_val   as $chave => $valor )  { 
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
                   ///  function do arquivo dbc.php  isEmail
                   preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU',$e_mail) ? $m_erro="" : $m_erro= "Endere&ccedil;o de email inv&aacute;lido";
                   if( strlen(trim($m_erro))<1 ) {
                        $array_login = explode("@",$e_mail);
                        $login_novo=$array_login[0];
                        $upper_email = (string) strtoupper($valor);
                   }     
               }                         
               $$chave=$valor;         
          }     
    }
    ///  Verifica se houve erro nos campos        
    if( strlen(trim($m_erro))>=1 ) {
          $msg_erro .= $m_erro.$msg_final; 
          echo $msg_erro;
          exit();
    }
    /***  Verificando se nao existe Usuario/Novo Orientador 
          Vericando se o NOme se ja esta cadastrado  na Tabela pessoa
          Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
    ****/
    ///   ACERTAR O CAMPO NOME, retirando acentua??o e passando para maiusculas
    ///    Remover os espacos do nome deixando apenas um entre as palavras
    $nome = trim(preg_replace('/ +/',' ',$nome));
    $pessoa_nome=stringParaBusca2(strtoupper(trim($nome)));
    ///  
    ///  Acertando ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
    $pessoa_nome=html_entity_decode(trim($pessoa_nome)); 
    ///  PHP ? Remover os espa?os em excesso de uma string/variavel - exemplo: nome
    $pessoa_nome = trim(preg_replace('/ +/',' ',$pessoa_nome));
    mysql_select_db($db_array[$elemento]);
    ///  SESSION abaixo para ser usada no include
    $_SESSION['tabela']="pessoa";
    ///  Verificando cadastro na tabela pessoa - nome ou e_mail
    $res_email=mysql_query("SELECT codigousp,nome,e_mail FROM $bd_1.pessoa WHERE "
               ." ( replace(upper(trim(nome)),'  ',' ')='$pessoa_nome' or  "
               ."  upper(trim(e_mail))='$upper_email' or  "
               ."  trim(cpf)='$cpf' ) and codigousp=$codigousp ");
     ///        
     if( ! $res_email ) {
           $msg_erro .= "Falha no Select pessoa campo nome ou e_mail -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
            echo $msg_erro;
            exit();
     }
     $lnregs = mysql_num_rows($res_email);                   
     $dup=0;
     if( intval($lnregs)==1 ) {
          $dup=$lnregs;
          $msg_erro .= "J&aacute existe cadastro com "
                       ."Nome:&nbsp;".trim($nome)." OU E_Mail:&nbsp;".trim($e_mail)." OU CPF:&nbsp;".$cpf;
     } elseif( $lnregs>1 ) {
           $dup=$lnregs;
           $msg_erro .= "J&aacute existem pessoas cadastradas com mesmo Nome OU E_Mail OU CPF";
     } 
     if( isset($res_email) ) mysql_free_result($res_email);
     /// Verificando se existe Duplicata
     if( intval($dup)>=1 ) {
           print $msg_erro;
           exit();
     }
     ///  codigousp - recebido do arquivo novo_codigousp_orientador.php     
     if( isset($_SESSION["codigousp_novo"]) )  $codigousp = $_SESSION["codigousp_novo"];     
     ///  $instituicao_e_outros=array('$instituicao','$unidade','$depto','$setor','$bloco','$sala','$salatipo'); 
     $instituicao_e_outros=array('instituicao','unidade','depto','setor','bloco','sala','salatipo'); 
     foreach( $instituicao_e_outros as $chaves => $n_valor  ) {
           if( ! isset($$n_valor) ) $$n_valor="";
     }
     //  ramal definido como inteiro porisso caso vazio acrescentar ZERO
     if( strlen(trim($ramal))<1 ) $ramal = (int) 0;
     /// Gera a ativação de codigo com 6 digitos
     $activation_code = rand(100000,999999);
     ///
     $lnerro=0;
     ///  Verificando Banco de Dados
     if( isset($bd_1) ) {
         ///  Selecionando o Banco de Dados
          mysql_select_db($bd_1);  
          $_SESSION['tabela']=$bd_1.'.pessoa';
     } else {
           $msg_erro .= "Variável do banco de dados não definida. Corrigir.".$msg_final;
           echo $msg_erro;
           exit();
     }
     ///
     if( strlen(trim($categoria))<3 ) $categoria="OUT";      
      // Mostrando os campos que foram enviados pelo FORM
      /*
         $msg_erro .= " cadastrar_auto_por_email_ajax.php/671  - <br>"
             ." \$codigousp = $codigousp - \$cpf = $cpf - \$passaporte = $passaporte -  "
             ." \$nome = $nome - \$sexo = $sexo - \$categoria = $categoria  <br>"
             ." \$fone = $fone - \$ramal = $ramal -  \$e_mail = $e_mail ".$msg_final; 
          echo $msg_erro;
          exit();
       */
      //   ALTERADO em 20120228
      //  START a transaction - ex. procedure nas Tabelas pessoa, usuario e participante   
      mysql_query('DELIMITER &&'); 
      $commit = "commit";
      mysql_query('begin'); 
      //  Execute the queries          
      //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
      mysql_query("LOCK TABLES ".$_SESSION['tabela']." WRITE, $bd_1.usuario WRITE, $bd_2.participante WRITE ");
      /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;        
      //  login feito pelo e_mail    
      $login=$login_novo;          
      //  INSERT - Caso nao esteja cadastrado na Tabela Pessoa
      $res_pessoa = "INSERT into ".$_SESSION['tabela'];
      $res_pessoa .="  (codigousp,cpf,passaporte,nome,sexo,categoria,instituicao,unidade,depto,setor,bloco,sala,salatipo,fone,ramal,e_mail)  "
              ." values($codigousp,'$cpf','$passaporte','$nome','$sexo','$categoria','$instituicao','$unidade','$depto','$setor','$bloco','$sala','$salatipo','$fone',$ramal,'$e_mail') "; 
      ///                  
      $sqlcmd =  mysql_query($res_pessoa);      
      if( $sqlcmd ) { 
           //  INSERT - Tabela usuario
           $_SESSION['tabela']="$bd_1.usuario";
           $res_usuario= "INSERT into ".$_SESSION['tabela']." (login,codigousp,pa) values('$login',$codigousp,$pa) "; 
           //                  
           $sqlcmd =  mysql_query($res_usuario);      
           if( $sqlcmd ) { 
                ///  Concluindo as tabelas para Orientador Novo para ser aceito pelo Aprovador
                $commit = "commit";
                ///  INSERT - Tabela participante
                $res_part= "INSERT into  $bd_2.participante  (codigousp,pa)  values($codigousp,$pa) ";                     
                $sucesso=mysql_query($res_part);      
                if( $sucesso ) { 
                    $msg_ok  .="<span style='text-align:center; color: #000000;'>"
                            ."<br>Orientador <b>$nome</b>. Encaminhado para o <b>Aprovador</b>.<br>"
                            ."<br>Caso aprovado, receberá e_mail com instru&ccedil;&otilde;es.</span>".$msg_final;
                   ///
                } else {
                    /// Ocorreu ERRO/FALHA
                     $commit = "rollback";
                     $msg_erro .="&nbsp;Falha Tabela participante insert -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
                     $lnerro=1;                        
                }
           } else { 
                /// Ocorreu ERRO/FALHA
                $commit = "rollback";
                $msg_erro .="&nbsp;Falha Tabela usuario insert -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
                $lnerro=1;
           }                
      } else { 
           ///  mysql_error() - para saber o tipo do erro
           $commit = "rollback";
           $msg_erro .="&nbsp;Falha Cadastrar Orientador $nome -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
           ///  mysql_query('rollback');          
           $lnerro=1;        
      }           
      //   Mandar mensagem para o Aprovador - caso nao tenha erro
      if( intval($lnerro)<1 ) {
              /*!40000 ALTER TABLE `orientador` ENABLE KEYS */
              mysql_query($commit);
              mysql_query("UNLOCK  TABLES");
              //  Complete the transaction 
              mysql_query('end'); 
              mysql_query('DELIMITER');         
              //  Caso Tabela acima foi aceita incluir dados na outra abaixo
             //  Verificando descricao na  tabela categoria 
            $categoria = strtoupper(trim($categoria));
            $res_categoria=mysql_query("SELECT descricao FROM pessoal.categoria where "
                      ." upper(trim(codigo))='$categoria' ");
            ///        
            if( ! $res_categoria ) {
                  $msg_erro .="&nbsp;erro no Select categoria campo codigo -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
                  echo $msg_erro;
                  exit();                  
            }          
            $num_linhas=mysql_num_rows($res_categoria);  
            if( intval($num_linhas)<1 ) {
                 $descr_categ = "Outra";
            } else {
                $descr_categ = mysql_result($res_categoria,0,"descricao")."&nbsp;($categoria)"; 
            }
            if( isset($res_categoria) ) mysql_free_result($res_categoria);
            ///  Aprovador para o Novo Orientador
            ///  $aprovador_email="gemac@genbov.fmrp.usp.br";
            $aprovador_email="{$_SESSION["gemac"]}";
            $host  = $_SERVER['HTTP_HOST'];
            $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
            $user=$codigousp;
            ///  $m_local="ativar_orientador.php?user=".$user."&activ_code=".$activ_code."&pa=".$pa;
            ///  $m_local="ativar_orientador.php?user=".$user."&activation_code=".$activation_code;
            $m_local="ativar_orientador_por_email.php?user=".$user."&activation_code=".$activation_code;
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$retornar$m_local'  title='Clicar' >"
                     ."$retornar$m_local</a>"; 
            ///  $host_upper = strtoupper($host);           
            $host_lower = strtolower($host);           
            ///  $assunto =html_entity_decode("Redefini??o de senha");    
            ///  $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
            $assunto =html_entity_decode("RGE/SISTAM - Permissão para Orientador");    
            $corpo ="RGE/SISTAM - Permissão para Orientador<br>";
            $corpo .="$host_lower/rexp<br><br>";
            $corpo .=html_entity_decode("O usuário abaixo solicita permiss&atilde;o como Orientador de Projeto.<br>Providenciar an&aacute;lise e aprova&ccedil;&atilde;o, se for devida.\r\n");                    
            $headers1  = "MIME-Version: 1.0\n";
            ///  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
            $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
            $headers1 .= "X-Priority: 3\n";
            $headers1 .= "X-MSMail-Priority: Normal\n";
            $headers1 .= "X-Mailer: php\n";
            ///  $headers1 .= "Return-Path: xxx@...\n";
            ///  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
            $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";
           
            ///  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
            ///  From e  Bcc  (Para e Copia Oculta)                    
            ///  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
            $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
           
            ///   $headers1 .= "Bcc: spaulfb@hotmail.com\r\n";                    
            $message = "$corpo\n<br><br>
            Nome: $nome<br>
            Usuário/Email: $e_mail<br>
            Categoria: $descr_categ\n<br>
           
            Telefone: $fone \n<br>

            Código de ativação: $activation_code \n<br><br>

            $a_link<br><br>

           ______________________________________________________<br>
           Esta é uma mensagem automática.<br> 
           *** Não responda a este EMAIL ****
           ";
           
           /// if ( mail($aprovador_email, stripslashes(utf8_encode($assunto)), $message,$headers1)  ) {
           if ( mail($aprovador_email, $assunto, $message,$headers1)  ) {
                $msg_ok .="<br>Email enviado com sucesso para o Aprovador!";
           } else {
                $msg_ok .="<br>Ocorreu um erro durante o envio da mensagem para o email do Aprovador.";
           }
           echo $msg_ok.$msg_final;               
      } else  echo $msg_erro;
   exit();
}
//
//   Tabela do ANOTADOR  cadastrado pelo Orientador  -  variavel source
if( $opcao=="ANOTADOR" ) {
    if( strtoupper(trim($val))=="CODIGOUSP" ) {
           if( strtoupper(trim($m_array))=="OUTRO"  ) {
                echo  "usuario,e_mail| | ";   
           } else {
                $elemento=6;
                /// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
                include("php_include/ajax/includes/conectar.php");
                mysql_select_db($db_array[$elemento]);
                ///
                $res_pessoa=mysql_query("SELECT  e_mail,"
                                       ."(select login from pessoal.usuario where codigousp=".$m_array." ) "
                                       ." as login  FROM  pessoal.pessoa where  "
                                       ."   codigousp=".$m_array);
                //                          
                if( ! $res_pessoa ) {
                    die('ERRO: Select pessoal.pessoa -&nbsp;db/Mysql:&nbsp;'.mysql_error());  
                }
                echo  'usuario,e_mail|'.mysql_result($res_pessoa,0,login)."|".mysql_result($res_pessoa,0,e_mail);
                if( isset($res_pessoa) ) mysql_free_result($res_pessoa);
           }
           exit();        
    }
}
//    Tabela do ANOTADOR  cadastrado pelo Orientador  -  variavel val
if( strtoupper($val)=="ANOTADOR" ) {      
     ///  Recebendo dados do FORM e Inserindo
     ///  nas Tabelas ANOTACAO e  PROJETO
     if( isset($array_temp) ) unset($array_temp); 
     if( isset($array_t_value) ) unset($array_t_value); 
     $m_erro="";
     $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario     
     if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];                 
     //  $pa_anotador = $_SESSION["array_usuarios"]["anotador"];                 
     $pa_anotador=$array_pa["anotador"];                  
     //// include("../includes/dados_campos_form.php");   
     include("{$incluir_arq}includes/dados_campos_form.php");   
     
     ////  SESSION abaixo para ser usada no include
    $elemento=6;
    // include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    include("php_include/ajax/includes/conectar.php");
    mysql_select_db($db_array[$elemento]);
    $_SESSION['tabela']="anotador";
    //   CAMPOS do FORM anotador_cadastrar.php
    $lnprojeto = $arr_nome_val["projeto"]; $lncodigousp = $arr_nome_val["codigousp"];
    $sqlcmd = "Select codigo,(select nome from pessoal.pessoa where codigousp=$lncodigousp ) as nome "
               ." from rexp.anotador where codigo=$lncodigousp and cip=$lnprojeto ";
    $resultado = mysql_query($sqlcmd);
    if( ! $resultado ) {
          die('ERRO: Select tabelas anotador e pessoa -&nbsp;db/Mysql:&nbsp;'.mysql_error());  
     } 
     $nregs=mysql_num_rows($resultado);
     if( intval($nregs)==1 ) {
         $nome_anotador=mysql_result($resultado,0,"nome");
         $msg_erro .="&nbsp;Esse Anotador: $nome_anotador j&aacute; est&aacute; cadastrado nesse Projeto.".$msg_final;
         echo $msg_erro;               
         exit();                                          
     }  
     //
    ///  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    //  Execute the queries 
    mysql_select_db($db_array[$elemento]);
   //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
   mysql_query("LOCK TABLES ".$_SESSION['tabela']." WRITE  ");
   /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;
   $res_coord = mysql_query("insert into ".$_SESSION['tabela']." (cip,codigo,pa,data) "
            ."  values($lnprojeto,$lncodigousp,$pa_anotador,'$data_atual') "); 
   /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
   mysql_query("UNLOCK  TABLES");
   //  Complete the transaction 
   if ( $res_coord ) { 
    $lnprojeto = $arr_nome_val["projeto"]; $lncodigousp = $arr_nome_val["codigousp"];
    $sqlcmd = "Select codigo,(select nome from pessoal.pessoa where codigousp=$lncodigousp ) as nome "
               ." from rexp.anotador where codigo=$lncodigousp and cip=$lnprojeto ";
    $resultado = mysql_query($sqlcmd);
    if( ! $resultado ) {
          die('ERRO: Select tabelas anotador e pessoa apos INSERT -&nbsp;db/Mysql:&nbsp;'.mysql_error());  
     } 
     $nregs=mysql_num_rows($resultado);
     if( intval($nregs)==1 ) {
         $nome_anotador=mysql_result($resultado,0,"nome");
         $msg_ok .="<p class='titulo_usp'><br>Anotador:<b> $nome_anotador </b> cadastrado com <b>sucesso</b> nesse Projeto</p><br>".$msg_final;
         echo  $msg_ok;
     }
   } else { 
        ////  mysql_error() - para saber o tipo do erro
        $msg_erro .="&nbsp;Anotador <b>N&Atilde;O</b> foi cadastrado -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
        mysql_query('rollback'); 
        echo $msg_erro;         
   }
   mysql_query('end'); 
   mysql_query('DELIMITER');         
   exit();
}
//    
if( strtoupper($val)=="PROJETO" ) {
    /*	 
         AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
		 e de depois usa o  - html_entity_decode 
    */
	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp);
	 for( $i=0; $i<$count_array_temp; $i++ )   $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
	 //
    //   Vericando se o NOme se ja esta cadastrado  na Tabela usuario
    //   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
	$m_titulo=strtoupper(trim($arr_nome_val['titulo']));
	$fonterec=strtoupper(trim($arr_nome_val['fonterec']));	
    $fonteprojid=strtoupper(trim($arr_nome_val['fonteprojid']));    
	$m_autor=strtoupper(trim($arr_nome_val['autor']));
	$_SESSION["numprojeto"]=strtoupper(trim($arr_nome_val['numprojeto']));
	//   MELHOR JEITO PRA ACERTAR O CAMPO NOME
    //   function para caracteres com acentos passando para Maiusculas
    //  '/&aacute;/i' => '?',
	//  $m_texto=strtoupper($pessoa_nome);
    $m_titulo = stringParaBusca2($m_titulo);
    $fonterec = stringParaBusca2($fonterec);	
	$m_autor=stringParaBusca2($m_autor);
    $m_titulo =html_entity_decode(trim($m_titulo));
	$fonterec =html_entity_decode(trim($fonterec));
    $fonteprojid=strtoupper(trim($arr_nome_val['fonteprojid']));    
    $m_autor =html_entity_decode(trim($m_autor));
    
     ///  Corrigir onde tiver strtotime - usado somente para ingles           
     $data_de_hoje = date('d/m/Y');
     $data_de_hoje = explode('/',$data_de_hoje);
     $time_atual = mktime(0, 0, 0,$data_de_hoje[1], $data_de_hoje[0], $data_de_hoje[2]);
     // $dt_inicio= strtotime($arr_nome_val["datainicio"]);
     $dt_inicio = explode('/',$arr_nome_val["datainicio"]);
     $time_inicial = mktime(0, 0, 0,$dt_inicio[1], $dt_inicio[0], $dt_inicio[2]);  
     //  Variavel para incluir na Tabela anotador no campo PA
     $lnpa = $_SESSION["permit_pa"];
    if( $time_inicial>$time_atual ) {
        $msg_erro .= "Data do in&iacute;cio do Projeto posterior a data atual.  Corrigir".$msg_final;
        echo $msg_erro;
        exit();
    }
 	/* Converter Data PHP para Mysql   */
	$m_datainicio=$arr_nome_val['datainicio'];
	$m_datainicio=substr($m_datainicio,6,4)."-".substr($m_datainicio,3,2)."-".substr($m_datainicio,0,2);
    $m_final=$arr_nome_val['datafinal'];
    $m_final=substr($m_final,6,4)."-".substr($m_final,3,2)."-".substr($m_final,0,2);
    //  Verificando campos 
	//  coresponsaveis para incluir na Tabela corespproj
	$m_erro=0;
    $val_coresp= (int) $arr_nome_val[coresponsaveis];
	if( intval($val_coresp)>=1 ) {
	    $n_coresponsaveis=explode(",",$m_array);
		$count_coresp = count($n_coresponsaveis);
		for( $z=0; $z<$count_coresp ; $z++ ) {
		    if( strlen($n_coresponsaveis[$z])<1 ) {
			    $m_erro=1;
				break;
			} 
		}
	}
	if( $m_erro==1 ) {
	      $msg_erro .= "&nbsp;Falta incluir co-respons&aacute;vel.".$msg_final;
          echo $msg_erro;
		  exit();
	}
	//
	$elemento=6; $m_regs=0;
    //// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    include("php_include/ajax/includes/conectar.php");
	mysql_select_db($db_array[$elemento]);
	$result=mysql_query("SELECT  cip,autor FROM projeto WHERE "
	                 ." trim(fonterec)=trim('".$fonterec."')  and  "
					 ." trim(fonteprojid)=trim('".$fonteprojid."') and "
                     ." autor=".$m_autor." and datainicio='$m_datainicio'  ");
     ///                
	/////  Verificar MySql - Select				 
    if( ! $result ) {
        ///  Ocorreu erro no MySql - Select   
        $msg_erro .="&nbsp;erro no Select tabela projeto -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
        echo $msg_erro;
        exit();                  
    }             
    ///  Numero de registros    
	$m_regs=mysql_num_rows($result);
    if(  $m_regs>=1 ) {
          $msg_erro .= "&nbsp;Projeto (autor, fonte, processo_no., data_inicio):&nbsp; j&aacute; est&aacute; cadastrado.".$msg_final;
          echo $msg_erro;
		  exit();
    } elseif( ! $result ) {
          mysql_free_result($result);
          die('ERRO: Select projeto -&nbsp;db/Mysql:&nbsp;'.mysql_error());  
 	} else {
    	  //  Continuacao Tabela projeto - BD PESSOAL
          /*   MELHOR jeito de acertar a acentuacao - html_entity_decode    */	
	      mysql_free_result($result);
          //  Caso tenha coautores/coresponsaveis no Projeto
          include("n_cos.php");
		  //  SESSION abaixo para ser usada no include
	      $_SESSION['tabela']="projeto";
          include("dados_recebidos_arq_ajax.php");  
		  //  Verificando o numero de coresponsaveis/coautores
		  //  INSERIR USUARIO  
    	  mysql_select_db($db_array[$elemento]);
	      //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
		  $result_usu = mysql_query("select codigo from usuario where   codigo='$m_autor'   ");
		  $m_regs = mysql_num_rows($result_usu); 
          if ( $m_regs<1 ) { 
                $n_erro=0;
                //  Start a transaction - ex. procedure    
                mysql_query('DELIMITER &&'); 
                mysql_query('begin'); 
                //  Execute the queries 
                mysql_select_db($db_array[$elemento]);
                //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
                //   - Use mysql_select_db() ou mysql_query()
                $sqlcmd="insert into rexp.projeto  (".$_SESSION["campos_nome"].") values(".$_SESSION["campos_valor"].") ";       
                $success=mysql_query($sqlcmd); 
                //  Complete the transaction 
                if ( $success ) { 
                      //  Cadastrando na tabela corespproj os coresponsaveis
                      for( $x=0; $x<$count_coresp;  $x++ ) {
                           $result=mysql_query("insert into corespproj values(".$m_autor.", ".$_SESSION["numprojeto"].", ".$n_coresponsaveis[$x].")");
                           if( !$result ) {
                                mysql_query('rollback'); 
                                $msg_erro .="&nbsp;CORESP. n&atilde;o foi cadastrado (autor/projeto/coresp):".$m_autor.", ".$_SESSION["numprojeto"].", ".$n_coresponsaveis[$x].mysql_error().$msg_final;
                                mysql_query('rollback'); 
                                echo  $msg_erro;
                           }
                     }
                    if( $result ) {
                         mysql_free_result($result);                           
                         mysql_query('commit');                                  
                    } else { 
                        $n_erro=1;
                        mysql_free_result($result);
                        mysql_query('rollback'); 
                    }
                } else {
                    $n_erro=1;
                    mysql_free_result($success);
                    mysql_query('rollback'); 
                }              
                mysql_query('end'); 
                mysql_query('DELIMITER');
                mysql_free_result($success);
                if( $n_erro==1 ) {
                     $msg_erro .="&nbsp;Projeto <b>N&Atilde;O</b> foi cadastrado -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
                     echo $msg_erro;               
                     exit();                                  
                } else {
                     //  Incluindo arquivo para a Anotacao do Projeto 
                    //  projeto, autor/orientador e numero da anotacao
                    $m_regs=0;
                    $result_proj=mysql_query("SELECT  cip,autor FROM projeto WHERE "
                     ." trim(fonterec)=trim('".$fonterec."')  and  "
                     ." trim(fonteprojid)=trim('".$fonteprojid."') and "
                     ." autor=".$m_autor." and datainicio='$m_datainicio' and datafinal='$m_final'  ");
                    //                 
                    $m_regs=mysql_num_rows($result);
                    if( $m_regs=1 ) {
                        $projeto_cip=mysql_result($result_proj,0,"cip");       
                         mysql_free_result($result_proj);                       
                         $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario  
                         $sqlcmd="insert into rexp.anotador (cip,codigo,pa,data) values($projeto_cip,$m_autor,$lnpa,'$data_atual')";
                         $res_anotador=mysql_query($sqlcmd); 
                         if( $res_anotador )  {
                              $msg_ok .="<p class='titulo_usp'>&nbsp;Para concluir o Projeto enviar o arquivo em formato PDF.</p>".$msg_final;
                              echo  $msg_ok."falta_arquivo_pdf".$_SESSION["numprojeto"]."&".$m_autor;
                             // Efetiva a transa??o nos duas tabelas (anotacao e projeto)                                    
                         } else {
                            mysql_free_result($res_anotador);
                            $msg_erro .="&nbsp;Anotador <b>N&Atilde;O</b> foi cadastrado -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
                            echo $msg_erro;                                   
                            exit();
                         }                   
                    } else {
                         $msg_erro .="&nbsp;Projeto <b>N&Atilde;O</b> encontrado -&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
                         echo $msg_erro;                                   
                         exit();                          
                    }
                }
                //  FINAL -  TABELA PROJETO  -  BD  REXP
          }
    }
	//  FINAL IF TABELA projeto  -  BD  REXP
} elseif( strtoupper($val)=="PESSOAL" ) {
     //  Tabela pessoa - BD PESSOAL
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
    
    $arr_nome_val['codigousp'] = strlen(trim($arr_nome_val['codigousp']))>0 ? 
            $arr_nome_val['codigousp'] : 0;    
     ////
    $valor_tmp= (int) $arr_nome_val['codigousp'];       
    if( intval($valor_tmp)==0) {
        ///   MySql - Select 
        $result=mysql_query("SELECT min(codigousp) as codigo_ult  FROM  pessoal.pessoa where codigousp<0 ") ;
        if( ! $result ) {
            die("Falha erro no Select/Atribuir codigoUSP -&nbsp;db/Mysql:&nbsp;".mysql_error());
        }
        $m_regs=mysql_num_rows($result);
        if( intval($m_regs)>0) {
            $codigo_prx = mysql_result($result,0,'codigo_ult');
        } 
        if( ! isset($codigo_prx) ) {
            $codigo_prx=0;
        }
        $codigo_prx += -1;
        if( isset($result) ) mysql_free_result($result);
        $arr_nome_val['codigousp'] = $codigo_prx;
        if( intval($i_codigo)<0  ) {
            die("ERRO: Falha inesperada criando um NOVO codigo USP.");
        }
        $array_t_value[$i_codigousp] = $codigo_prx;
    }
    ///   MySql - Select 
	$result_usu=mysql_query("SELECT codigousp,nome FROM pessoal.pessoa where codigousp=".$arr_nome_val['codigousp']) ;
	if( ! $result_usu ) {
		  die("Falha erro no Select -&nbsp;db/Mysql:&nbsp;".mysql_error());
	}
    $m_regs=mysql_num_rows($result_usu);
    if( isset($result_usu) ) mysql_free_result($result_usu);
    ///  Verificando se existi outro codigo na Tabela pessoa
    if( intval($m_regs)>=1 ) {
           $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;".$arr_nome_val['codigousp']." j&aacute; est&aacute; cadastrado.".$msg_final;
           echo $msg_erro;
    } else {
           /***  Vericando se o NOme se ja esta cadastrado  na Tabela pessoa
                Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
           ***/
           ///   ACERTAR O CAMPO NOME, retirando acentua??o e passando para maiusculas
           $pessoa_nome=stringParaBusca2(strtoupper(trim($arr_nome_val['nome'])));
           //  
           //  Acertando ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
           $pessoa_nome=html_entity_decode(trim($pessoa_nome)); 
           /// Selecionando o Banco de Dados
           mysql_select_db($db_array[$elemento]);
           ////  SESSION abaixo para ser usada no include
           $_SESSION['tabela']="pessoa";
           
           include("dados_recebidos_arq_ajax.php");  
           ///
           ///  INSERINDO 
           ///  Start a transaction - ex. procedure			   
           mysql_query('DELIMITER &&'); 
           mysql_query('begin'); 
           ///
           $success=mysql_query("insert into pessoal.pessoa "
                        ."  (".$cpo_nome.") values(".$cpo_valor.") "); 
           ///  Complete the transaction 
           if( $success ) { 
                mysql_query('commit'); 
                $msg_ok .="<p class='titulo_usp'>&nbsp;"
                        .$arr_nome_val[nome]." foi cadastrado.</p>".$msg_final;
                echo $msg_ok;
           } else { 
                /// Ocorreu erro
                mysql_query('rollback'); 
                $msg_erro .="&nbsp;".$arr_nome_val[nome]." n&atilde;o foi cadastrado -&nbsp;db/Mysql:&nbsp;".$msg_final;
                echo $msg_erro;	     
           } 
           mysql_query('end'); 
           mysql_query('DELIMITER'); 
	}
    if( isset($sucess) ) mysql_free_result($sucess);		  
	////  Final - Tabela pessoa 
}  elseif( strtoupper($val)=="USUARIO" ) {
     ///  Tabela usuario - BD PESSOAL  Tabela usuario
     ///
     if( isset($array_temp) )  unset($array_temp); 
     if( isset($array_t_value) ) unset($array_t_value); 
     if( isset($arr_nome_val) ) unset($arr_nome_val); 
     $m_erro=0;
     ///    Dados vindo de um FORM   
     ///  include("../includes/dados_campos_form.php");
     include("{$incluir_arq}includes/dados_campos_form.php");
     ////
     $conta =  sizeof($array_temp);
     /*
        for( $f=0; $f<$conta;  $f++ )  {
             $msg_erro = $array_temp[$f]." = ".$array_t_value[$f];        
             echo   "<br>".$msg_erro;
     }
   */
      //
     //  Verificando campos 
    $elemento=5; $elemento2=6; 
    ///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    include("php_include/ajax/includes/conectar.php");
    ///  Verificando Login e Senha 
    if( strtoupper(trim($arr_nome_val['login']))==strtoupper(trim($arr_nome_val['senha']))  ) {
         $msg_erro .= "ERRO:  Usuário/Login e Senha iguais - corrigir ".$msg_final;
         echo  $msg_erro;
         exit(); 
    }
	///  Verificando campos 
	///  Verificando se nao existe Usuario com esse login  na Tabela usuario
    $result_usu = mysql_query("SELECT   login  FROM  $bd_1.usuario where "
                        ."  trim(login)=trim('".$arr_nome_val['login']."')");
    if( ! $result_usu ) {
        $msg_erro .= "&nbsp;Usu&aacute;rio:&nbsp;".$arr_nome_val[login]."&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
         echo $msg_erro;
         exit();
    }
    $m_regs = mysql_num_rows($result_usu);
	if( isset($result_usu) ) mysql_free_result($result_usu);
	if( intval($m_regs)>=1 ) {
         $msg_erro .= "&nbsp;Usu&aacute;rio:&nbsp;".$arr_nome_val[login]." j&aacute; cadastrado.".$msg_final;
         echo $msg_erro;
	} 
    ///  SESSION Tabela para ser usada no include: dados_recebidos_arq_ajax.php
    ///  DEsativando
    if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
    if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
    ///  Acertando os campos para inserir dados
    ///  Verificando Banco de Dados
     if( isset($bd_1) ) {
         ///  Selecionando o Banco de Dados e a tabela
          $_SESSION['tabela']="$bd_1.usuario";
     } else {
           $msg_erro .= "Variável do banco de dados não definida. Corrigir.".$msg_final;
           echo $msg_erro;
           exit();
     }
     ///  incluindo arquivo dados_recebidos_arq_ajax.php 
    include("dados_recebidos_arq_ajax.php");
    ///	Selecionando o Banco de Dados
    mysql_select_db($db_array[$elemento]);
    $n_pa = trim($arr_nome_val['pa']);
    ///
    if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];    
    ///  foreach( $array_usuarios as $key =>$valor ) {
    foreach( $array_pa as $key =>$valor ) {
             if( $n_pa==$valor  ) {
                  $nome_key = $key;
                  break;
            }
    }
    ///  START  a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    /***  Execute the queries 
          $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
          mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
           Use mysql_select_db() ou mysql_query()
           Gera a ativação de codigo com 6 digitos           
    *****/
    $activ_code = rand(100000,999999);

    /// echo "cpo_nome=".$cpo_nome."<br>  cpo_valor=".$cpo_valor."<br><br>";
    /// MySql - Insert
    $success=mysql_query("insert into $bd_1.usuario (".$cpo_nome.",activation_code) values(".$cpo_valor.",'$activ_code') "); 
    ///  Complete the transaction 
    if( $success ) { 
         $msg_ok .="<p class='titulo_usp'>Usu&aacute;rio:&nbsp;"
                   .$arr_nome_val['login']." foi cadastrado.</p>".$msg_final;
         $m_erro=0;      
         mysql_query('commit'); 
    } else { 
        /// Ocorreu um erro
        $msg_erro .="Usu&aacute;rio:&nbsp;"
        .$arr_nome_val['login']." n&atilde;o foi cadastrado&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
        echo $msg_erro;   
        $m_erro=1;      
        mysql_query('rollback'); 
    }
    mysql_query('end'); 
    mysql_query('DELIMITER');
    /// 
    if( intval($m_erro)<1 ) {
        ///  MySql - Select 
        $res_email = mysql_query("Select e_mail from pessoal.pessoa where codigousp=".$arr_nome_val['codigousp']." ");
        if( ! $res_email ) {
            die("ERRO: Select pessoa campo e_mail&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error());
        }  else {
            $usr_email=html_entity_decode(trim(mysql_result($res_email,0,'e_mail')));
            $data['senha'] = $arr_nome_val['senha'];
            if( isset($res_email) ) mysql_freeresult($res_email);
            ///
            $host  = $_SERVER['HTTP_HOST'];
            $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
            $user=$arr_nome_val['codigousp'];
            $m_local="ativar.php?user=".$user."&activ_code=".$activ_code;
            /*
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br>"
            ."<a href='http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code'  title='Clicar' >"
            ."http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code</a>"; 
            */
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$retornar$m_local'  title='Clicar' >"
                    ."$retornar$m_local</a>"; 
            ////
            $host_upper = strtoupper($host);           
            ///  $assunto =html_entity_decode("Redefini??o de senha");    
            $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentificação");    
            $corpo=html_entity_decode("Seu cadastro como ".ucfirst($nome_key)." foi realizado.<br>Detalhes do seu registro\r\n");                    
            $user_name = html_entity_decode($arr_nome_val['login']); 
            $headers1  = "MIME-Version: 1.0\n";
            //  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
            $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
            $headers1 .= "X-Priority: 3\n";
            $headers1 .= "X-MSMail-Priority: Normal\n";
            $headers1 .= "X-Mailer: php\n";
            ///  $headers1 .= "Return-Path: xxx@...\n";
            ///  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
            $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";
            
            ///  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
            /// $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
            $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
            
            $message = "$corpo ...\n<br><br>
            Usuário: $user_name<br>
            Email: $usr_email \n<br>
            Senha: $data[senha] \n<br>

            Código de ativação: $activ_code \n<br><br>

            $a_link<br><br>

            RGE/SISTAM - Anotação<br>
            $host_upper<br><br>
            ______________________________________________________<br>
            Esta é uma resposta automática.<br> 
            *** Não responder a este EMAIL ****
            ";
           /// mail($usr_email, stripslashes(utf8_encode($assunto)), $message,$headers1);
           if ( mail($usr_email, stripslashes(utf8_encode($assunto)), $message,$headers1)  ) {
                $msg_ok .="<p>Mensagem de Acesso enviada para o email:  $usr_email<br></p>";
           } else {
                $msg_ok .="<br>Ocorreu um erro durante o envio da mensagem para o email:  $usr_email";
           }
           ///  Enivar mensagem
           echo $msg_ok.$msg_final;               
          ////                        
           /*    $msg_ok .= "<p>Sua senha foi redefinida e uma nova senha foi enviada para seu endere?o de e-mail.<br>"
               ."<a href='$retornar' title='Clicar' >Retornar</a></p>";                         
           */
            ///  $msg_ok .= "<p>Mensagem de Acesso enviada para o email:  $usr_email<br></p>";                         
            ///  echo  $msg_ok;
        }
    }
}	 
#
ob_end_flush(); /* limpar o buffer */
#
?>