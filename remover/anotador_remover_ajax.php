<?php
// 
///  Arquivo para REMOVER - PROJETO/ANOTADOR  -  ajax 
//
//  Biblioteca para uso do programa
//
//
function isEmail($email) {
    return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}
///  Funcao para busca com acentos
if( ! function_exists("stringParaBusca") ) {
    function stringParaBusca($str) {
        //Transformando tudo em minúsculas
        $str = trim(strtolower($str));

        //Tirando espaços extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
        while ( strpos($str,"  ") )
            $str = str_replace("  "," ",$str);
        
        //Agora, vamos trocar os caracteres perigosos "ã,á..." por coisas limpas "a"
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
        
        //Retornando a String finalizada!
        return $str;
    }
}    
///
///  Funcao para minuscula para Maiuscula
if( ! function_exists("stringParaBusca2") ) {
    function stringParaBusca2($str) {
     /*
         $a1 ="àáâãäåæçèéêëìíîïñòóôõöøùúûüý";
         $a1_len = strlen($a1);
         $a2 ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝ";
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

    /*
        $substituir2 = array('/á/' => 'Á',
                            '/é/' => 'É',
                            '/í/' => 'Í',
                            '/ó/' => 'Ó',
                            '/ú/' => 'Ú',
                            '/ã/' => 'Ã',
                            '/õ/' => 'Õ',
                            '/â/' => 'Â',
                            '/ê/' => 'Ê',
                            '/î/' => 'Î',
                            '/ô/' => 'Ô',
                            '/û/' => 'Û',
                            '/ç/' => 'Ç',
                            '/ñ/' => 'Ñ',
                            '/ò/' => 'Ò',
                            '/ò/' => 'Ò',                        
                            '/ö/' => 'Ö',                        
                            '/ø/' => 'Ø',                                                
                            '/ù/' => 'Ù',                                                                        
                            '/ü/' => 'Ü',                                                                                                
                            '/ý/' => 'Ý'
                        );
                        */
                        
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
                        
                            
       /// $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
        $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);
        ///
        return $texto;
        /// 
    }
}    
////    
ob_start(); /* Evitando warning */
//  Verificando se SESSION_START - ativado ou desativado
if( ! isset($_SESSION) ) {
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
/// header("Content-Type: text/html; charset=UTF-8",true);

//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');

//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');

//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
///  extract: Importa variáveis para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
///
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
///  Definindo http ou https
///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
///  Conjunto de arrays 
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    

/// Conjunto de Functions
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");    
///
$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP    
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) {
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
$e_mailinf = "  ";   /// Verificar ponto mais adequado para usar = pegar como parâmetro
///
///   Para acertar a acentuacao - utf8_encode
///   $source = utf8_decode($source); $val = utf8_decode($val); 
if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source);
$source_upper=strtoupper($_SESSION["source"]);
///  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
$funcoes=new funcoes();
///
if( $source_upper=="SAIR" ) {
    /// Eliminar todas as variaveis de sessions
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
/**********   SAIR DO PROGRAMA  **********/
///
if( $source_upper=="PROJETO" ) {
    ///
    ///  Usuario Orientador/Chefe/Vice - conectado
    if( ! isset($_SESSION["usuario_conectado"]) ) {
           $msg_erro .= utf8_decode("Session usuario_conectado não existe.").$msg_final;
           echo $msg_erro;               
           exit();                                          
    }   
    ///  Autor do Projeto  - codigo
    $projeto_autor_cod=$_SESSION["usuario_conectado"];              
    
    ///  <!--  Anotador/NOME -->      
    ///  Elementos para Bancos de Dados
    ///    $elemento=5; $elemento2=6;
    ///    include("php_include/ajax/includes/conectar.php");
    # Aqui está o segredo
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    ///
    ////   Incluir todos os anotadores e superiores (orientadores, etc)  //** ALTERANDO:LAFB110916.1515 **//
    $sqlcmd = "SELECT 'Outro_PA' as tipo_pa, a.nome, a.codigousp,a.categoria, a.e_mail, b.cip "
                 ." FROM $bd_1.pessoa a, $bd_2.anotador b WHERE b.cip=$val and a.codigousp=b.codigo "
                 ." and b.codigo!=$projeto_autor_cod "
                 ." order by a.nome";
    ///                        
    $result = mysql_query($sqlcmd); 
    if( !$result ) {
         ///  die("ERRO: PRG/l&oacute;gica - select pessoa X usuario = Anotador. Informe SISTAM/REXP.".mysql_error());
         echo $funcoes->mostra_msg_erro("ERRO: PRG/l&oacute;gica - select pessoa X usuario = Anotador. Informe SISTAM/REXP&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());
         exit();       
    }
    /// Numero de Anotadores desse Projeto para sererem  desativado/excluido
    $m_linhas = mysql_num_rows($result);
    ////   <!--  tag select para selecionar o Anotador para o Projeto selecionado -->
    ////  IMPORTANTE: para retornar como tag Select sempre incluir a tag <div> - 20180518
    ?>
      <select  name="sel_anotador"  id="sel_anotador"  class="td_select" required="required" 
          style="float: left;clear: both;"
           title="Selecione Anotador"  onchange="javascript: enviar_dados_anotador('codigousp',this.value)" >            
       <?php
          ////  if( intval($m_linhas)<1 || intval($nprojetos)<1) {
          if( intval($m_linhas)<1 ) {
              echo "<option value='' >Anotador N&atilde;o Dispon&iacute;vel.</option>";
          } else {
            ?>
              <option value="" >Selecione Anotador para remover do projeto</option>
            <?php         
               /// Usando arquivo com while e htmlentities
               ///  include("../includes/tag_select_tabelas.php");
               $e_mailname=mysql_field_name($result,3);
               $codigo_sigla=mysql_field_name($result,2);
               $cpo_nome_descr=mysql_field_name($result,1);
               $cpo_tipo_pa = mysql_field_name($result,0);
               if( isset($separador) ) unset($separador);
               while( $linha=mysql_fetch_array($result) ) {       
                      ///  htmlentities - o melhor para transferir na Tag Select
                      $sigla= htmlentities($linha[$codigo_sigla]);  
                      ///  $nome= htmlentities($linha[$cpo_nome_descr]);
                      $tipo_pa = htmlentities($linha[$cpo_tipo_pa]);
                      $e_mail = htmlentities($linha[$e_mailname]);
                      if( ! isset($separador) ) {
                           $separador = $tipo_pa;
                      }
                      if ($separador!= $tipo_pa) {
                           echo "<option  value='' >================================</option>" ;
                           $separador = $tipo_pa;
                      }
                      /*  IMPORTANTE:  na tag SELECT  htmlentities($linha[$cpo_nome_descr],ENT_QUOTES,"UTF-8")  */
                      $ln_codigousp=$linha["codigousp"];
                      $anotador_descr=$linha[$cpo_nome_descr];
                      $codigo_caracter=mb_detect_encoding($anotador_descr);
                      if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
                            //// echo utf8_decode(htmlentities($titulo_projeto))."&nbsp;&nbsp;</option>";
                            ///     echo  htmlentities("$titulo_projeto")."&nbsp;&nbsp;</option>";
                            ///   echo  $titulo_projeto."&nbsp;&nbsp;</option>";
                            ////  echo "<option value=".$ln_codigousp." title='Clicar' >1)".utf8_encode($anotador_descr);
                            echo "<option value=".$ln_codigousp." title='Clicar' >".htmlentities($linha[$cpo_nome_descr],ENT_QUOTES,"UTF-8");
                        } else {
                            echo "<option value=".$ln_codigousp." title='Clicar' >".$anotador_descr;
                        }
                        echo "</option>" ;
                        ///
               }
               ///   echo "<option  value='-999999999'  title='Clicar'  >* Outro (Digite o Nome/E-mail nos cpos. seguintes:)</option>" ;
            ?>
            </select>
            <?php
                 if( isset($result) ) mysql_free_result($result); 
          }
          ///
    ///  <!-- Final - Anotador/Nome -->
   exit();
}
///
///    CODIGOUSP para verificar se a pessoa tem e_mail
if( $source_upper=="CODIGOUSP" ) {      
    $anotador_codigousp=$val;
    // Conectar
    $elemento=5;$elemento2=6;
    include("php_include/ajax/includes/conectar.php"); 
    //  Verificando se o Anotador tem email - (Valido)
    $sqlcmd = "SELECT e_mail,nome from $bd_1.pessoa WHERE codigousp=$anotador_codigousp ";
    $resultado = mysql_query($sqlcmd);
    if( ! $resultado ) {
          $msg_erro .=' Falha na consulta da pessoa -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
         echo $msg_erro;               
         exit();                                          
    }
    /// Verifica se encontrou o novo Anotador
    $nregs = mysql_num_rows($resultado);
    if( intval($nregs)>0) {
        $anotador_e_mail=mysql_result($resultado,0,"e_mail");
        $ver_e_mail="(E_mail:$anotador_e_mail)";
    } else {
        $anotador_e_mail="E_mail ainda n&atilde;o cadastrado.";
        $ver_e_mail="E_mail ainda n&atilde;o cadastrado.";
    }
    ///
    if( ! isEmail($anotador_e_mail) ) {
        $msg_erro .="Anotador ainda N&Atilde;O tem E_MAIL v&aacute;lido cadastrado($ver_e_mail). Providencie Corre&ccedil;&atilde;o.";
        $msg_erro .="%";
        $msg_erro .="<table class='table_inicio' align='center' cellpadding='1' border='2' cellspacing='1' style='font-weight:normal; background-color: #FFFFFF; margin: 0px; padding: 0px;vertical-align: middle; '  >";
        $msg_erro .="<tr>";
        $msg_erro .="<td class='td_inicio1' style='vertical-align: middle;' >";
        $msg_erro .="<label for='nome' style='vertical-align: middle; cursor: pointer;' >Nome:&nbsp;</label>";
        $msg_erro .="</td>";
        $msg_erro .="<td class='td_inicio2' >";
        $msg_erro .="<input type='text' name='nome' id='nome' size='85'  maxlength='64' title='Digitar Nome/Anotador' onblur='javascript: alinhar_texto(this.id,this.value)'  autocomplete='off'  style='cursor: pointer; '  />";
        $msg_erro .="</td></tr>";
        echo $msg_erro.$msg_final;                     
    } else {
        $_SESSION["anotador_nome"]=$anotador_nome=trim(mysql_result($resultado,0,"nome"));
        ////
        $codigo_caracter=mb_detect_encoding($anotador_nome);
        if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
              /// echo utf8_decode(htmlentities($titulo_projeto))."&nbsp;&nbsp;</option>";
              ///     echo  htmlentities("$titulo_projeto")."&nbsp;&nbsp;</option>";
             ///   echo  $titulo_projeto."&nbsp;&nbsp;</option>";
             ///  echo "<option value=".$ln_codigousp." title='Clicar' >1)".utf8_encode($anotador_descr);
             /// $_SESSION["anotador_nome"]=$anotador_nome=htmlentities($anotador_nome,ENT_QUOTES,"UTF-8");
             $_SESSION["anotador_nome"]=$anotador_nome;
        }
        ///
        echo  "$anotador_nome#$anotador_e_mail";
        ///
    }    
    exit();
}
///
///    Tabela do ANOTADOR  cadastrado pelo Orientador  -  variavel val
if( strtoupper($val)=="ANOTADOR" ) {      
     /****  Recebendo dados do FORM e Inserindo
             nas Tabelas ANOTACAO e  PROJETO          ***/
     unset($array_temp); unset($array_t_value); $m_erro="";
     $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario     
     ///  $pa_anotador = $_SESSION["array_usuarios"]["anotador"];                 
     $pa_anotador = $array_pa["anotador"];
     include("{$_SESSION["incluir_arq"]}includes/dados_campos_form.php");   
     ///      
     foreach( $arr_nome_val as $key => $value ) {
              $$key=$value;  
      }
      ///
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
       ///
       /// Nome do Anotador para remover do Projeto selecionado
       if( isset($_SESSION["anotador_nome"]) ) {
           ////  $anotador_nome = utf8_decode($_SESSION["anotador_nome"]);
           ///  $anotador_nome = trim($_SESSION["anotador_nome"]);
           $_SESSION["anotador_nome"] = $anotador_nome = htmlentities($_SESSION["anotador_nome"],ENT_QUOTES,"UTF-8");
       } else {
           /// $nome = "";
           /// $anotador_nome = utf8_decode($arr_nome_val["nome"]);
           $_SESSION["anotador_nome"] = $anotador_nome = trim($arr_nome_val["nome"]);
       }
       ////  Variavel do e_mail do Anotador a ser removido
       $anotador_email = $arr_nome_val["e_mail"];
       ///
       ///  Verificando pela funcao isEmail  se  o e_mail e valido 
       if( ! isEmail($anotador_email) ) {
           $msg_erro .="E_MAIL informado: $anotador_email n&atilde;o &eacute; v&aacute;lido. Re-digite.".$msg_final;
           echo $msg_erro;                     
           exit();
       }    
       ///
       /// Verificar se a pessoa indicada já consta como anotador (na tabela anotador)
       $sqlcmd = "SELECT  anotador_ci as usuario_ci FROM $bd_2.anotador  "
                   ." WHERE codigo=$lncodigousp and cip=$lnprojeto ";
       ///           
       $resultado = mysql_query($sqlcmd);
       if( ! $resultado ) {
           $msg_erro .='Falha na consulta do anotador -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
           echo $msg_erro;               
           exit();                                          
       } 
      /// Numero de participantes
      $nregs_participante=mysql_num_rows($resultado);
      if( intval($nregs_participante)==1 ) {
           $usuario_ci=mysql_result($resultado,0,"usuario_ci");           
      } 
      ///
     ///  Indica que o anotador está aprovado (autorizado) para usar o REXP
      $aprovado = 1;   
      ///  Usuario Orientador/Chefe
      if( ! isset($_SESSION["usuario_conectado"]) ) {
           $msg_erro .= utf8_decode("Session usuario_conectado não existe.").$msg_final;
           echo $msg_erro;               
           exit();                                          
      }   
      ////  Autor do Projeto  ou   Chefe/Responsavel 
      $projeto_autor_cod=$codigo_ativa=$_SESSION["usuario_conectado"];              
     ///
     /** Exemplo do resultado  do  Permissao de Acesso - criando array
          +-------------+--------+
          | descricao   | codigo |
          +-------------+--------+
          | super       |      0 | 
          | chefe       |     10 | 
          | vice        |     15 | 
          | aprovador   |     20 | 
          | orientador |     30 | 
          | anotador    |     50 | 
          +-------------+--------+
      **/
     if( ! isset($pa_anotador) ) {
          $msg_erro .= utf8_decode("Variável pa_anotador não existe.").$msg_final;
          echo $msg_erro;               
          exit();                                          
     }
     $pa = $pa_anotador;
     $codigo = $lncodigousp;
     ///
      ///  Verificando  url_central
      if( ! isset($_SESSION["url_central"]) ) {
          ///  Definindo http ou https - IMPORTANTE
          ///  Verificando protocolo do Site  http ou https   
          $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
          $_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
          $raiz_central=$_SESSION["url_central"];
          ///
      }
      $url_central = $_SESSION["url_central"];
      ///
      $session_tabela = $_SESSION["tabela"];
      $n_erro=0;
      
      
  echo  "ERRO:  anotador_remover_ajax/580  --->>> CONTINUAR  <<<--- \$_SESSION[anotador_nome] = {$_SESSION["anotador_nome"]} --- anotador_nome = $anotador_nome ";
  exit();      
      
      /*
             REMOVER ANOTADOR DE PROJETO
      */
      ///  Iniciar uma transaction - ex. procedure    
      mysql_query('DELIMITER &&'); 
      mysql_query('begin'); 
      ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
      ///  mysql_query("LOCK TABLES $bd_1.pessoa UPDATE");
      mysql_query("LOCK TABLES $bd_1.anotador DELETE");    
     /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;
     ///
     /// mysql_query("LOCK TABLES pessoal.pessoa UPDATE");
      $sqlcmd = "DELETE FROM $bd_2.anotador WHERE codigo=$lncodigousp and cip=$lnprojeto  ";
      $resultado = mysql_query($sqlcmd);
      if( ! $resultado ) {
          $msg_erro .='Delete tabela anotador -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
          mysql_query('rollback'); 
          $n_erro=1;
          echo $msg_erro;               
      } else {
          mysql_query('commit');  
      }
      /// mysql_query("UNLOCK  TABLES");
      mysql_query("UNLOCK  TABLES");
      mysql_query('end'); 
      mysql_query('DELIMITER');
      ///  Ocorreu erro
      if( intval($n_erro)>0 ) {
          ///  Ocorreu ERRO para remover Anotador/Projeto na tabela anotador
          exit();
      }
      ///
      ///   Verifica se é necessário incluir registro do anotador na tabela usuário
     /***
   $sqlcmd = "SELECT aprovado from $bd_1.usuario where  codigousp=$lncodigousp ";
   $resultado = mysql_query($sqlcmd);
   if( ! $resultado ) {
        $msg_erro .=' Falha na consulta do anotador na tabela usuario: db/mysql= '.mysql_error().$msg_final;  
        echo $msg_erro;               
        exit();                                          
   } 
   $nregs=mysql_num_rows($resultado);
   ***/
   
      ///  Caso NAO ocorreu erro
      ///   Verifica se é necessário incluir registro do anotador na tabela participante
      $sqlcmd = "SELECT aprovado from $bd_2.participante WHERE  codigousp=$lncodigousp and "
                  ."  pa=$pa_anotador and usuario_ci=$usuario_ci and codigo_ativa=$projeto_autor_cod ";
      ///
      $resultado = mysql_query($sqlcmd);
      if( ! $resultado ) {
          $msg_erro .='Falha na consulta do anotador na tabela participante -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
          echo $msg_erro;               
          exit();                                          
      } 
      ///   Incluir registro do anotador na tabela anotador
      //***mysql_query("LOCK TABLES rexp.anotador WRITE");
      ///  Chave auto incremento
      $cip = $lnprojeto;
      $codigo = $lncodigousp;
      $data =  date("Y-m-d H:i:s");
      /// Controlar o envio de senha pelo e_mail do anotador, caso seja nova.
      $senha = "";        
      $n_erro=0;
     
      /// Numero de participante desse Anotador 
      $nregs=mysql_num_rows($resultado);
      if( intval($nregs)>0 ) {
          ///
          ///  Iniciar uma transaction - ex. procedure    
          mysql_query('DELIMITER &&'); 
          mysql_query('begin'); 
          ///  Execute the queries 
          mysql_select_db($db_array[$elemento]);
          ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
          mysql_query("LOCK TABLES $bd_2.participante  DELETE");
          ////   
          $sqlcmd = "DELETE FROM  $bd_2.participante WHERE  codigousp=$lncodigousp and "
                  ."  pa=$pa_anotador and usuario_ci=$usuario_ci and codigo_ativa=$projeto_autor_cod ";
          ///        
          $resultado = mysql_query($sqlcmd);
          /// Verificando se houve erro ou nao
          if( ! $resultado ) {
                $msg_erro .='Removendo anotador da tabela participante -&nbsp;db/mysql:&nbsp;'.mysql_error().$msg_final;  
                $n_erro=1;
                mysql_query('rollback'); 
                //***mysql_query("UNLOCK  TABLES");
                echo $msg_erro;               
          } else {
               /// Executando
               mysql_query('commit'); 
          }
          ///
          /// Concluir a transaction
          //***mysql_query("UNLOCK  TABLES");
          mysql_query('commit'); 
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
     ////   IMPORTANTE: excelente para acentuacao da tag SELECT -  e tb  htmlentities        
     mysql_query("SET NAMES 'utf8' ");
     mysql_query("SET character_set_connection=utf8");
     mysql_query("SET character_set_client=utf8");
     mysql_query("SET character_set_results=utf8");
    
     ///  Buscar o Titulo do Projeto e dados do Orientador/Chefe
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
     ///  Dados do Projeto e do Orientador
     $projeto_titulo = mysql_result($resultado,0,"titulo");
     $projeto_numero = mysql_result($resultado,0,"numprojeto");
     $projeto_autor = mysql_result($resultado,0,"nome_autor");
     $orientador_email = mysql_result($resultado,0,"orientador_email");    
     ///
     ///  $m_local = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
     $url_central=$_SESSION["url_central"];    
     $m_local = html_entity_decode("$url_central");
     ///
     /*************  INICIANDO ENVIO DE  EMAIL    ******************************/
     ///
     ///  $m_local = html_entity_decode($_SESSION['url_folder']);
     $a_link = "***** CONEXÃO DE REMOÇÃO *****\n<br><a href='$m_local'  title='Clicar' >$m_local</a>"; 
     ///
     $assunto =html_entity_decode("RGE/SISTAM/REXP - Removendo Anotador");    
     ///  $corpo ="RGE/SISTAM/REXP - Permissão para Anotador do Projeto $projeto_numero <br>(Orientador: $projeto_autor)";
     $corpo ="RGE/SISTAM/REXP - Registro de Anotações<br/>Remoção de Anotador: "
             ."<br/>Projeto: $projeto_numero - $projeto_titulo<br/>(Orientador: $projeto_autor)"
             ."<br/><br/>Anotador:&nbsp;".$anotador_nome;
     /// 
     $headers1  = "MIME-Version: 1.0\n";
     $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
     ///  $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
     $headers1 .= "X-Priority: 3\n";
     $headers1 .= "X-MSMail-Priority: Normal\n";
     $headers1 .= "X-Mailer: php\n";
   ///  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
   ///  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
   ///  From e  Bcc  (Para e Copia Oculta)                    
     $headers1 .= "From: $projeto_autor <$orientador_email>\r\n";                    
   ///  $headers1 .= "Bcc: gemac@genbov.fmrp.usp.br\r\n"; 
   ///  $headers1 .= "Bcc: bezerralaf@gmail.com; spfbezer@fmrp.usp.br\r\n";                   
   ///  $headers1 .= "Bcc: {$_SESSION["gemac"]} \r\n";                   
     $headers1 .= "Bcc: $gemac_email \r\n";                   
   /// $headers1 .= "Bcc: bezerralaf@gmail.com; spfbezer@gmail.com  \r\n";                   
   
     $message = "$corpo\n<br><br>

     $a_link<br><br>

     ______________________________________________________<br/>
     Esta é uma mensagem automática.<br> 
     *** Não responda a este EMAIL ****
     ";
   
   /// if ( mail($aprovador_email, stripslashes(utf8_encode($assunto)), $message,$headers1)  ) {
   /// SEMPRE TESTAR O COMANDO MAIL -  SE A MENSAGEM FOI ENVIADA  
   ///  $envio = mail($anotador_email, $assunto, $message,$headers1,"-r".$emailsender);  
     $emailsender="$orientador_email";
     ///  Enviando mensagem para o Anotador Removido
     $envio = mail($anotador_email, $assunto, $message,$headers1,"-r".$emailsender);
     
     ////  Mensagem enviada pra visualizar na  Tela
     ////
     ini_set('default_charset', 'UTF8');
      ///
     ///   Enviando mensagem 
     if( $envio ) {
         $msg_ok .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; '>"
                 ."<br/>&nbsp;&nbsp;Mensagem enviada para Anotador removido desse Projeto: <b>$projeto_titulo</b>:<br/>"
                 ."<br/>&nbsp;Anotador:&nbsp;<b>".$anotador_nome."</b><br/>E_mail:&nbsp;".$anotador_email."<br/><br/></span>".$msg_final;
         echo  $msg_ok;                        
     } else {
         $msg_erro .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; '>"
                 ."Mensagem <b>N&Atilde;O</b> foi enviada para Anotador removido desse Projeto: <b>$projeto_titulo</b>:<br/>"
                 ."<br/>&nbsp;Anotador:&nbsp;<b>".$anotador_nome."</b><br/>E_mail:&nbsp;".$anotador_email."<br/><br/></span>".$msg_final;
         echo  $msg_erro;              
     }   
     ///
     ///  Final - enviar a mensagem por email
}    
#
ob_end_flush(); /* limpar o buffer */
#
?>