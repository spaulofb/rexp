<?php
//   Arquivo para CADASTRAR PARTICIPANTE
//
//  Funcao para busca com acentos
function stringParaBusca($str) {
    //
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
//
//  Funcao para minuscula para Maiuscula
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
                    
                        
  // $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
   $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);

    return $texto;
    
}
///  FINAL --- Funcao para minuscula para Maiuscula
///
/*  Exemplo do resultado  do  Permissao de Acesso - criando array
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
*/
///
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
/// header("content-type: application/x-javascript; charset=iso-8859-1");
///  header("Content-Type: text/html; charset=ISO-8859-1",true);
header('Content-type: text/html; charset=utf-8');

//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');

////
// extract: Importa variáveis para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
///
//// Mensagens para enviar
$msg_erro ="<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_erro .="ERRO: <span style='color: #FF0000; text-align: center;' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar
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
if( ! isset($_SESSION["url_central"]) ) {
    $msg_erro .= "Sessão url_central não está ativa.".$msg_final;  
    echo $msg_erro;
    exit();
}
$url_central=$_SESSION["url_central"];
///
////  Conjunto de arrays 
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
	       ///  $$xyz=trim($_POST[$xyz]);
		   ///   Para acertar a acentuacao - utf8_encode
           $$xyz = utf8_decode(trim($_POST[$xyz])); 
	   } else {
           $$xyz = explode($div_array_por,$_POST[$xyz]);   
       }
	}
    //
}
/**  Final - for( $i=0; $i<count($post_array); $i++ ) {  */
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 
if( ! isset($val) ) $val="";
if( strtoupper($val)=="SAIR" ) $source=$val;

if( ! isset($source) ) $source="";
$_SESSION["source"]=trim($source);
$source_upper=strtoupper($_SESSION["source"]);
//
$val_upper="";
if( ! isset($val) ) {
    $val="";
} elseif( isset($val) ) {
    //
    //  Caso variavel for String
    if( is_string($val) ) {
        $val_upper=strtoupper($val);  
    }
    // 
}
//
//  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
///
///  SAINDO  
if( $source_upper=="SAIR" ) {
    //
    /// Eliminar todas as variaveis de sessions
    $_SESSION = array();
    
    /// Alterado em 20190329
    session_unset();
    /// session_destroy();
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
//
///
///  Selecionando Participante do Projeto e o e_mail
if( $source_upper=="PARTICIPANTE" ) {  
     //
     $elemento=5;
     //  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
     include("php_include/ajax/includes/conectar.php");
     //
     $proc="SELECT  e_mail FROM $bd_1.pessoa WHERE  codigousp=$val";
     $res_pessoa=mysqli_query($_SESSION["conex"],"$proc");
     //                          
     if( ! $res_pessoa ) {
         //
         die('ERRO: Selecionando Participante - falha:&nbsp;db/mysqli:&nbsp;'.mysqli_error($conex));  
         exit();
     }
     //  Nr. de pessoas soliciatadas
     $n_regs=mysqli_num_rows($res_pessoa);
     //
     
/***        
 echo  "ERRO: participante_cadastrar_ajax/339  -->> \$source_upper = $source_upper  <br>"
                ." -->>  \$n_regs = $n_regs  ";
 exit();    
****/    
     
     
     
     // Caso Nenhum registro
     if( intval($n_regs)<1  ) {
          ///  $msg_erro .="Nenhum encontrado";
         $msg_erro .="Nenhum encontrado".$msg_final; 
         echo $msg_erro; 
         //
         exit();
         //
     } 
     /**   Final - if( intval($n_regs)<1  ) {  */
     //
     //  $partes = mysql_result($res_pessoa,0,"e_mail")."#";    
     $partes = mysqli_result($res_pessoa,0,"e_mail")."#";    
     ///
     $proc="SELECT senha as senha_usu, pa as pa_usu, aprovado as aprovado_usu ";
     $proc.=" FROM $bd_1.usuario WHERE codigousp=$val ";
     ///          
     $resultado_usuario=$conex->query($proc);                       
     /// Caso houve ERRO no SELECT
     if( ! $resultado_usuario ) {
         /**  $msg_erro .="&nbsp;Select tabela usuario: db/mysql ".mysql_error().$msg_final;  
         *    echo $msg_erro;   
         */
          $terr="&nbsp;Select tabela usuario&nbsp;-&nbsp;db/mysqli:&nbsp;";
          echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
          exit();
     }
     // Nr. de registros
     $n_usu = mysqli_num_rows($resultado_usuario);
     //
     $aprovado_usu=9;
     //
     /** Caso NAO esteja cadastrado na Tabela usuario  */
     if( intval($n_usu)<1 ) {
          $partes .="block"; 
     } else {
         //
         // Caso esteja cadastrado na Tabela usuario
         /**  $partes .="none#".mysqli_result($resultado_usuario,0,"senha_usu");   
        *   Codigo do PA
         */
         $xpa=mysqli_result($resultado_usuario,0,"pa_usu");
         //
         $elemento=6;
         //  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
         include("php_include/ajax/includes/conectar.php");
         //
         //
         $proc="SELECT descricao FROM $bd_1.pa WHERE codigo=$xpa ";
         ///          
         $rsql=$conex->query($proc);                       
         /// Caso houve ERRO no SELECT
         if( ! $rsql ) {
             /**  $msg_erro .="&nbsp;Select tabela usuario: db/mysql ".mysql_error().$msg_final;  
             *    echo $msg_erro;   
             */
              $terr="&nbsp;Select tabela pa&nbsp;-&nbsp;db/mysqli:&nbsp;";
              echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
              exit();
         }
         // 
         // Descicao do PA
         $padesc=mysqli_result($rsql,0,"descricao");
         //

/**         
   echo "ERRO: LINHA/388  -->> \$bd_1 = $bd_1  -->>  ".$_SESSION["bd_1"]." -->>  $xpa = $padesc  ";
   exit();        
   */
         
         $partes .="none#".mysqli_result($resultado_usuario,0,"senha_usu"); 
         $partes .="#$padesc";
         //
     } 
     ///  Enviando os dados - Array com #
     echo $partes;
     //
     if( isset($resultado_usuario) ) {
         mysqli_free_result($resultado_usuario);  
     } 
     //
     exit();
     //
} 
/**   Final - if( $source_upper=="PARTICIPANTE" ) {   */
//
//  Gerar Senha para o Participante  
if( $source_upper=="GERAR_SENHA" ) {  
    //     
    //  Selecionando o BD
    $elemento=5;
    //
    // include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
     include("php_include/ajax/includes/conectar.php");
     //
     /** Variaveis $elemento = $bd_1  e  $elemento2 = $bd_2   */
     /** Banco de Dados/DB   */
     $conex->select_db($bd_1);
     //
     //  Gerando a Senha para usuario que NAO tenha
     include("{$_SESSION["incluir_arq"]}includes/gerar_senha.php");
     //
     //  Criando nova Senha
     $new_pwd = GenPwd();
     $pwd_reset = trim($new_pwd);
     //
     echo $pwd_reset;
     ///
}
/**  Final - if( $source_upper=="GERAR_SENHA" ) {   */
//
//  Instituicao, Unidade e demais
if( $source_upper=="CONJUNTO" )  {
    //  
    // PARTE PARA MUDANCA DE CAMPO - IMPORTANTE
    $n_cpo = (int) $n_cpo;
    $cpo_final = (int) $cpo_final;
    if( ! is_array($m_array) ) $m_array  = explode(",",$m_array);
    //
    
        
 echo  "ERRO: participante_cadastrar_ajax/404  -->> \$source_upper = $source_upper  -->> $n_cpo<=$cpo_final  ";
 exit();    
    
    
    
    
     if( $n_cpo<=$cpo_final ) { //  Inicio do IF principal
         //
         $cpo_where = $m_array[0];
         //
         //  $pos_encontrada = array_search($cpo_where,$m_array);
         //  Definindo a posicao para o proximo campo 
         $_SESSION[key]++;         
         $total_array=sizeof($m_array);
         for( $j=1; $j<=$total_array; $j++ ) {
             if( $cpo_where==$m_array[$j] )  $i=$j+1; 
         }
         //
         if( strtoupper($cpo_where)=="INSTITUICAO" ) {
              //
              $i=2;  unset($_SESSION[campos_dados1]);
              unset($_SESSION[campos_dados2]);
              $_SESSION[key]=0;              
         } else {
             //
             //  Verifica se esse campo ja foi selecionado no array
             //  remover o anterior
             if( $_SESSION[campos_dados1] ) {
                  //
                  $total = sizeof($_SESSION[campos_dados1]); 
                  for( $ver=0; $ver<$total ; $ver++ ) {
                      //
                      $xses=$_SESSION[campos_dados1][$ver];
                      if( $cpo_where==$xses or $j<$total  ) {
                          //
                           $_SESSION["key"]=$ver;  // Importante depois de achar duplicata
                           for( $ver; $ver<$total ; $ver++ ) {
                                unset($_SESSION[campos_dados1][$ver]);
                                unset($_SESSION[campos_dados2][$ver]);        
                           }                               
                           //
                      }
                      /**  Final - if( $cpo_where==$xses or $j<$total  ) { */
                      //  
                  }
                  /**  Final - for( $ver=0; $ver<$total ; $ver++ ) {  */
                  //
             }
             /**   Final - if( $_SESSION[campos_dados1] ) {  */
             //
         }
         //
         ///
         $table_atual = $m_array[$i]; $upper_val=strtoupper($val);
         $_SESSION[select_cpo]="sigla";
         $array2 = array("bloco","salatipo","sala");
         //
         //  Precisava passar a variavel 
         if( strtoupper($cpo_where)=="SALA" ) $table_atual="sala";    
         $chave = $_SESSION[key];
         $_SESSION[campos_dados1][$chave]=$cpo_where;
         $_SESSION[campos_dados2][$chave]=$val;
         //  
         //  Precisava passar a variavel 
         
         
    /**     if( strtoupper($table_atual)=="BLOCO" || strtoupper($table_atual)=="SALATIPO" || strtoupper($table_atual)=="SALA" ){  */   
         if( preg_match('/^BLOCO$|^SALATIPO$|^SALA$/ui',$table_atual) ) {                 
              //
              //  Mudando a variavel - $table_atual
              $_SESSION["select_cpo"]=$table_atual; 
              $table_atual="bem"; 
         }
         /**  Final - if( preg_match('/^BLOCO$|^SALATIPO$|^SALA$/ui',$table_atual) ) {    */
         //                         
         $_SESSION[where]="";            
         $total_arrays = sizeof($_SESSION[campos_dados1]);        
         for( $row = 0; $row < $total_arrays; $row++) {
              $_SESSION["where"].= " upper(trim(".$_SESSION[campos_dados1][$row]."))=";
              $p2 = $_SESSION[campos_dados2][$row];
              $p2 = trim(urldecode($p2));
              $_SESSION[where].=  " \"$p2\" ";
              if( $row<($total_arrays-1) ) $_SESSION[where].=  " and ";
              //
         }
         /**   Final - for( $row = 0; $row < $total_arrays; $row++) {  */
         //
         // Selecionando campo     
         $elemento=3;
         //
         //  IMPORTANTE: definido caminho do arquivo php.ini  cgi-bin
         include("php_include/ajax/includes/conectar.php");    
         //
         $tabs_sig_nome= array("instituicao","unidade","depto","setor");                
         $nome_cpo="";
         if( in_array($table_atual,$tabs_sig_nome) ) $nome_cpo="nome,";
         //
         /**
          *     mysql_db_query - Esta funcao e obsoleta, nao use esta funcao 
          *                    - Use mysql_select_db() ou mysql_query()
         */
         $where = $_SESSION["where"];
         $select_cpo="{$_SESSION["select_cpo"]}";
         $proc="SELECT $select_cpo, $nome_cpo count(*) FROM ";
         $proc.=" $table_atual WHERE  $where  group by 1 order by $select_cpo  ";
         $result=mysqli_query($_SESSION["conex"],"$proc"); 
         //
         if( ! $result ) {
              //
              //  die('ERRO: Select - falha: '.mysql_error());
              $terr="&nbsp;Select - falha&nbsp;-&nbsp;db/mysqli:&nbsp;";
              echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
              exit();
         }
         //  Nr. de registros 
         $m_linhas = mysqli_num_rows($result);
         //
         if( strtoupper($table_atual)=="BEM" ) {
              $table_atual=$_SESSION["select_cpo"];   
         } 
         //
         $_SESSION["table_atual"]=$table_atual;
         $cp_table_atual=$table_atual; $cp_cpo_where=$cpo_where;
         if( strtoupper($cp_table_atual)=="INSTITUICAO" ) $cp_table_atual="instituição";
         if( strtoupper($cp_cpo_where)=="INSTITUICAO" ) $cp_cpo_where="instituição";
         if( strtoupper($cp_table_atual)=="DEPTO" ) $cp_table_atual="departamento";
         if( strtoupper($cp_cpo_where)=="DEPTO" ) $cp_cpo_where="departamento";  
         // 
         if( intval($m_linhas)<1 )  {
               /** echo "==== Nenhum(a) <b>".ucfirst($table_atual)."</b> desse(a) <b>"
               *                      .ucfirst($cpo_where)."</b> ====";    
               */
               echo "==== Nenhum(a) <b>".ucfirst($cp_table_atual)."</b> desse(a) <b>"
                                     .ucfirst($cp_cpo_where)."</b> ====";    
               exit();
        }  
        /**  Final - if( intval($m_linhas)<1 )  {  */
        //
        /**  Executar IF quando nao for o ultimo campo  */
        if( $i<$cpo_final ) {
                ?>
             <span class="td_informacao2"  >
             <label for="<?php echo $table_atual;?>" style="cursor:pointer;" >&nbsp;<?php echo ucfirst($table_atual);?>:</label><br /><br />
                <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviar_dados_cad('CONJUNTO',this.value,this.name+'|'+'<?php echo $_SESSION[VARS_AMBIENTE];?>');" style="padding: 1px;" title="<?php echo ucfirst($cp_table_atual);?>"  >            
             <?php
                 //
                 //  acrescentando opcoes
                 echo "<option value='' >&nbsp;Selecionar&nbsp;</option>";
                 //
                 ///  WHILE  DA TAG SELECT    
                 while( $linha=mysqli_fetch_array($result) ) {  
                         //
                         //  Desativando selected - opcao que fica selecionada
                         if( $linha['sigla'] ) {
                             //
                             $value = urlencode($linha['sigla']);
                             $nome = trim(htmlentities($linha['sigla']));
                         } elseif( in_array($table_atual,array("bloco","salatipo","sala")) ) {
                              //
                              $select_cpo=$_SESSION["select_cpo"];
                              //  $value = urlencode($linha[$select_cpo]);
                              $value = trim(htmlentities($linha[$select_cpo]));
                              $nome = trim(htmlentities($linha[$select_cpo]));                          
                         }
                         //
                         $inst_selected = ""; 
                         $traco="";
                         if( strlen($nome_cpo)>1 ) {
                             //
                             //  htmlentities - o melhor para transferir na Tag Select
                             $se_sigla= htmlentities($linha[sigla]);  
                             $se_nome= htmlentities($linha[nome]); 
                             $traco="-";                  
                         }
                         //      
                          echo  "<option $inst_selected   value=".$value."  title='$se_sigla $traco $se_nome'  >&nbsp;";
                          echo  $nome."&nbsp;</option>" ;
                          //
                 }  
                 /**   Final - while( $linha=mysqli_fetch_array($result) ) {   */
                 //
               ?>
              </select>
              </span>
          <?php
              //
              //  Desativando variaveis
              if( isset($result_tb_temp1) )  mysqli_free_result($result_tb_temp1); 
              if( isset($result) )  mysqli_free_result($result); 
              //
              // Final do SELECT
          } 
          /**   Final - if( $i<$cpo_final ) {  */
          //
     }  
     /**   Final - if( $n_cpo<=$cpo_final ) {  */
     //
     exit();
     //
}
/**   Final - if( $source_upper=="CONJUNTO" )  {  */
//
 //  CADASTRANDO o Participante do Projeto   
if( $val_upper=="PARTICIPANTE" ) {    
     //   
     //  Tabela usuario 
     if( isset($array_temp) )  unset($array_temp); 
     if( isset($array_t_value) ) unset($array_t_value); 
     //
     $m_erro=0;
     //
     //  Dados vindo de um FORM   
     include("{$_SESSION["incluir_arq"]}includes/dados_campos_form.php");
     //
     //  $conta =  sizeof($array_temp); 
     //   Vericando se o LOGIN/USUSAIO se ja esta cadastrado na Tabela usuario
     $m_usuario_arr = array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
     $m_senha_arr = array('SENHA','PASSWD','PASSWORD');
     $array_email = array("EMAIL","E_MAIL","USER_EMAIL","EMAIL_USER");
     //
     //  Definindo os nomes dos campos e valores recebidos do FORM
     foreach( $arr_nome_val as $key => $value ) {
              //
              $$key = $value;
              $campo_nome = strtoupper($key);
              //
              if( in_array($campo_nome,$m_usuario_arr) ) {
                  $login = trim($value);
                  $upper_login = (string) strtoupper($value);
              }                
              if( in_array($campo_nome,$m_senha_arr) ) {
                  $senha = $value;
                  $upper_senha = (string) strtoupper($value);
              }
              if( in_array($campo_nome,$array_email) ) {
                  $e_mail = $value; $login = substr($e_mail,0,strpos($e_mail,'@'));
                  $upper_e_mail = (string) strtoupper($value);
              }                         
              //
     }
     /**  FInal - foreach(  $arr_nome_val as $key => $value ) {  */
     //
     //
     //  Verificando campos 
     $elemento=5; $elemento2=6;
     //
     /**  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");  */      
     include("php_include/ajax/includes/conectar.php");
     //
     /**  Array - PA - SESSION array_pa do arquivo inicia_conexao.php   */
     $array_pa=$_SESSION["array_pa"]; 
     $n_pa = trim($arr_nome_val['pa']);
     foreach( $array_pa as $chave => $valor )  { 
          //
          if( $n_pa==$valor  ) {
                $descr_pa = $chave;
                break;
          }
          //         
      }
      /**   Final - foreach( $array_pa as $chave => $valor )  {   */
      ///
      $where = " upper(trim(a.e_mail))=\"$upper_e_mail\"  and "; 
      //
      ///  IMPORTANTE:  para acentuacao entre MySql e PHP
      /***          
          mysql_query("SET NAMES 'utf8'");
          mysql_query('SET character_set_connection=utf8');
          mysql_query('SET character_set_client=utf8');
          mysql_query('SET character_set_results=utf8');
        ***/
      //  Executando Select/MySQL
      //   Utilizado pelo Mysql/PHP - IMPORTANTE -20180615      
      /***
          *    O charset UTF-8  uma recomendacao, 
          *    pois cobre quase todos os caracteres e 
          *    símbolos do mundo
      ***/
      //  Conexao MYSQLI
      $conex = $_SESSION["conex"];
      //
      //  Selecionando Banco de Dados/DB
      mysqli_select_db($_SESSION["conex"],$bd_2);                  
      //
      mysqli_set_charset($conex,'utf8');
      //   
      //  SELECT da Tabela participante
      $sqlcmd="SELECT a.codigousp,a.e_mail,c.aprovado,c.pa,  ";
      $sqlcmd.="(Select nome from $bd_1.pessoa WHERE codigousp=$codigousp ) as nome_pessoa from  ";
      $sqlcmd.=" $bd_1.pessoa a, $bd_1.usuario b, $bd_2.participante c  WHERE  ";
      $sqlcmd.=" $where  a.codigousp=b.codigousp and a.codigousp=c.codigousp and c.pa=$pa  ";
      ///

/**        
 echo  "ERRO: participante_cadastrar_ajax/804  -->>  \$sqlcmd = $sqlcmd  <<-->> \$where = $where  <<--  <br>"
         ."  -->> \$source_upper = $source_upper  <<--  <br>  -->>  \$n_regs = <b> $n_regs </b> <br>"
       ."  ->> \$val_upper = $val_upper -->>  \$m_erro = $m_erro  ";
 exit();    
   */ 
      



      $resultado_pessoa = mysqli_query($_SESSION["conex"],$sqlcmd); 
      if( ! $resultado_pessoa ) {
           //
           // die('ERRO: SELECT Usu&aacute;rio/Paticipante: '.mysql_error());
           $terr="&nbsp;SELECT usu&aacute;rio/paticipante&nbsp;-&nbsp;db/mysqli:&nbsp;";
           echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
           exit();
      }
      ///  Nr. de registros
      $n_regs = mysqli_num_rows($resultado_pessoa);
      ///
      $aprovado="";
      //
      // Caso Participante foi encontrado
      if( intval($n_regs)==1 ) {
          //
          $aprovado= (int) mysqli_result($resultado_pessoa,0,"aprovado");  
          $nome = mysqli_result($resultado_pessoa,0,"nome_pessoa");
          //  
          if( intval($aprovado)==1 ) {
               //
               $msg_erro .="Participante:&nbsp;$nome j&aacute; cadastrado e aprovado<br>como ";
               $msg_erro .=ucfirst($descr_pa).".".$msg_final;
               //
          } else if( intval($aprovado)<1 ) {
               //
               $msg_erro .="Participante:&nbsp;$nome j&aacute; cadastrado mas ainda ";
               $msg_erro .=" <b>n&atilde;o</b> foi aprovado como ";
               $msg_erro .=ucfirst($descr_pa).".<br>Consultar Aprovador".$msg_final;            
               //
          } 
          //
          // Mensagem de Erro
          echo $msg_erro;   
          //
          $m_erro=1;  
          //        
          exit();
          ///        
      } 
      /**  Final - if( intval($n_regs)==1 ) {  */
      //
      //  Desativando variavel  
      if( isset($resultado_pessoa) ) unset($resultado_pessoa);
      //
      //  IMPORTANTE:  para acentuacao entre MySql e PHP
       $conex->query("SET NAMES 'utf8'");
       $conex->query('SET character_set_connection=utf8');
       $conex->query('SET character_set_client=utf8');
       $conex->query('SET character_set_results=utf8');
       //
       $conex->set_charset("utf8");
       //
      ///  MySqli - Select encontrar pessoa cadastrada  
      
      
      $sqlcmd = "SELECT nome as nome_pessoa FROM $bd_1.pessoa ";
      $sqlcmd .=" WHERE codigousp=$codigousp "; 
      $resultado_pessoa = mysqli_query($_SESSION["conex"],"$sqlcmd");                       
      /// Caso houve erro
      if( ! $resultado_pessoa ) {
           //
           // die('ERRO: SELECT Usu&aacute;rio/Paticipante: '.mysql_error());  
           $terr="&nbsp;SELECT pessoa&nbsp;-&nbsp;db/mysqli:&nbsp;";
           echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
           exit();
      }
      //
      /**  Nome do Novo Participante para ser incluido  */
      $nome = mysqli_result($resultado_pessoa,0,"nome_pessoa");
      $participante_cadast=0;
      //
      /** Caso variavel $resultado_pessoa ativa - desativando  */
      if( isset($resultado_pessoa) ) {
          mysqli_free_result($resultado_pessoa);  
      } 
      /// MySql - Select
      $sqlcmd = "SELECT senha as senha_usu, pa as pa_usu, aprovado as aprovado_usu ";
      $sqlcmd .=" FROM $bd_1.usuario WHERE codigousp=$codigousp ";
      $resultado_usuario=mysqli_query($_SESSION["conex"],"$sqlcmd");                       
      /// Caso houve erro
      if( ! $resultado_usuario ) {
           //
           // die('ERRO: SELECT Usu&aacute;rio/Paticipante: '.mysql_error());
           $terr="&nbsp;SELECT usuario&nbsp;-&nbsp;db/mysqli:&nbsp;";
           echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
           exit();
      }
      /// Nr. de registros
      $n_usu = mysqli_num_rows($resultado_usuario);
      $aprovado_usu=9;
      //
      
/**        
 echo  "ERRO: participante_cadastrar_ajax/804  -->>  \$nome = $nome  ---  \$n_usu = $n_usu  <<-- <br>"
         ."  -->> \$source_upper = $source_upper  <<--  <br>  -->>  \$n_regs = <b> $n_regs </b> <br>"
       ."  ->> \$val_upper = $val_upper -->>  \$m_erro = $m_erro  ";
 exit();    
 */
 
      ///  Caso encontrado 
      if( intval($n_usu)==1  ) {
          //
           ///    $senha_usu=mysql_result($resultado_usuario,0,"senha_usu");
           ///    $pa_usu=mysql_result($resultado_usuario,0,"pa_usu");
           ///    $aprovado_usu=mysql_result($resultado_usuario,0,"aprovado_usu");
           /****
                Definindo os nomes dos campos e valores recebidos do 
                   MYSQL SELECT - mysql_fetch_array - IMPORTANTE
            ***/
           $array_usuario=mysqli_fetch_array($resultado_usuario);
           foreach( $array_usuario as $chave_usuario => $valor_usuario ) {
                    $$chave_usuario=$valor_usuario;
           }       
           ///
           if( intval($aprovado_usu)<=1 ) {
               //
               // MySqli - Select descricao do pa do participante     
               $proc="SELECT descricao FROM $bd_2.pa  WHERE codigo=$pa_usu ";
               $executar=mysqli_query($_SESSION["conex"],"$proc");  
               //
               // Caso houve erro
               if( ! $executar ) {
                    //
                    $terr="&nbsp;SELECT pa descrição&nbsp;-&nbsp;db/mysqli:&nbsp;";
                    echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
                    ///
                    exit();
                    //
               }
               //
               // Selecionando a descricao do PA do Participante
               $pa_descr_cadastrado=mysqli_result($executar,0,0);
               //
               //  Participante tem PA cadastrado na tabela usuario
               /**
                 $msg_erro .="Participante:&nbsp;"
                         .utf8_encode($nome)." j&aacute; cadastrado e aprovado<br>como "
                         .utf8_encode(ucfirst($pa_descr_cadastrado)).".".$msg_final;
               */
               $msg_new=$msg_ok;
               $msg_new .="Participante: $nome já cadastrado e aprovado como ";
               $msg_new .=ucfirst($pa_descr_cadastrado).".";
               //    
               echo  html_entity_decode($msg_new).$msg_final;    
               $m_erro=1;  
               $usuario_inserir=0;
               //
           } 
           /**  Final - if( intval($aprovado_usu)<=1 ) {  */
           ///  
      } else {
          $usuario_inserir=1;  
      }         
      /// if( isset($resultado_usuario) )  mysql_free_result($resultado_usuario);
      if( isset($resultado_usuario) ) {
           unset($resultado_usuario);  
      } 
      ///
      //
          

/**
  $temptxt = "ERRO: 934) \$bd_1 = $bd_1 e \$bd_2 = $bd_2   <<--<br> \$campo_nome = ".substr($campo_nome,-50)." <br/> \$campo_value = ".substr($campo_value,-50)."  <br/>  ";
  $temptxt .=" \$_SESSION[pasta_raiz] = {$_SESSION["pasta_raiz"]} ou  \$_SESSION[pagina_local] = {$_SESSION["pagina_local"]} ";
   $temptxt .=" <br> ( values('$login',password('$senha'),'$datacad','$datavalido',$codigousp,$pa,1) ";      
  $temptxt .="<br/> \$senha = $senha -->>  \$m_erro =<b> $m_erro </b> \$nome = $nome  <<-->> \$descr_pa = $descr_pa ";
  echo  $temptxt;
  exit();      
*/
     
     
    //// Caso NAO houve erro - INSERIR PARTICIPANTE
    if( intval($m_erro)<1 ) {
         //
         $success="";    
         //
         //  SELECT da Tabela participante -  NOME
         if( isset($m_array) ) $codigousp=$m_array;
         $sqlcmd = "SELECT nome FROM $bd_1.pessoa  WHERE codigousp=$codigousp ";
         ///
         $resultado_pessoa = $conex->query("$sqlcmd"); 
         if( ! $resultado_pessoa ) {
              //
              /**  die('ERRO: SELECT Usu&aacute;rio/Paticipante: '.mysql_error());  */
              $terr="&nbsp;SELECT nome do usu&aacute;rio&nbsp;-&nbsp;db/mysqli:&nbsp;";
              echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
              exit();
         }
         //  Nome do Participante
         $nome = mysqli_result($resultado_pessoa,0,"nome");
         ///
         if( ! isset($activ_code) ) $activ_code=0;
         //
         //
         ///  START  a transaction - ex. procedure    
         mysqli_query($_SESSION["conex"],'DELIMITER &&'); 
         $commit="commit";
         mysqli_query($_SESSION["conex"],'begin'); 
         //
         //  Execute the queries 
         //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
         //   - Use mysql_select_db() ou mysql_query()
         //  mysql_query("LOCK TABLES  $bd_1.usuario  INSERT, $bd_2.participante INSERT ");
         mysqli_query($_SESSION["conex"],"LOCK TABLES  $bd_1.usuario  INSERT, $bd_2.participante INSERT ");
         //
         // Gera a ativação de codigo com 6 digitos
         if( intval($usuario_inserir)==1 ) {
             //
             /** $success=mysql_query("insert into  $bd_1.usuario "
              *      ."  (".$cpo_nome.",activation_code) values(".$cpo_valor.",'$activ_code') "); 
             */
             $success=mysqli_query($_SESSION["conex"],"INSERT INTO $bd_1.usuario "
                     ."  (login,senha,datacad,datavalido,codigousp,pa,aprovado,activation_code) "
                     ."  values('$login',password('$senha'),'$datacad','$datavalido',$codigousp,$pa,1,'$activ_code') ");
             //                                          
             if( ! $success ) {
                  //
                  //  Ocorreu ERRO
                  $commit="rollback";  
                  $m_erro=1;
             } else {
                mysqli_query($_SESSION["conex"],$commit); 
             }
             // 
         }
         /**  Final - if( intval($usuario_inserir)==1 ) {  */
         //
         //  Caso ocorreu erro
         if( intval($m_erro)==1  ) {
             //
             // Mensagem de erro
             $msg_erro .="Usu&aacute;rio:&nbsp;$nome n&atilde;o foi cadastrado como ";
             $msg_erro .=ucfirst($descr_pa).".<br>Falha:&nbsp;db/mysqli:&nbsp;";
             $msg_erro .=mysqli_error($conex).$msg_final;
             echo $msg_erro;               
             //
         } else { 
             //
             //  Inserindo novo participante          
             $success=mysqli_query($_SESSION["conex"],"insert into  $bd_2.participante "
                         ."  (codigousp,datacad,datavalido,pa,codigo_ativa,aprovado) "
                         ."  values($codigousp,'$datacad','$datavalido',$pa,'$activ_code',1) ");
             //                                          
             if( ! $success ) {
                 //
                 // Caso ocorreu ERRO
                 $commit="rollback";  
                 $m_erro=1;
                 $msg_erro .="Participante:&nbsp;$nome n&atilde;o foi cadastrado como ";
                 $msg_erro .=ucfirst($descr_pa).".<br>Falha:&nbsp;db/mysqli:&nbsp;";
                 $msg_erro .=mysqli_error($conex).$msg_final;
                 echo $msg_erro;   
                 //            
             } else {
                //          
                /***
                *   $msg_ok .="<p class='titulo_usp'>Participante:&nbsp;"
                *         .$nome." foi cadastrado como ".ucfirst($descr_pa).".<br>";                     
                *   $msg_ok .="</p>".$msg_final;
                ***/
                $msg_ok .="<br/><span style='color:#F00FFF;padding:.8em 0 .8em 0;font-size:large;'>";
                $msg_ok .="Participante:&nbsp;$nome foi cadastrado como ";
                $msg_ok .=ucfirst($descr_pa).".<br>";                     
                $msg_ok .="</span>".$msg_final;     
                ///
             }
             //
         }                  
         /*!40000 ALTER TABLE  ENABLE KEYS */;
         mysqli_query($_SESSION["conex"],$commit);
         mysqli_query($_SESSION["conex"],"UNLOCK  TABLES");
         ///  Complete the transaction 
         mysqli_query($_SESSION["conex"],'end'); 
         mysqli_query($_SESSION["conex"],'DELIMITER');
         /// 
    }
    /**  Final - if( intval($m_erro)<1 ) {  */
    //   
 
 
     
    //   Caso NAO houve erro enviar EMAIL
    if( intval($m_erro)<1 ) {
        //
        //  Alterado em 20180710
        ini_set('default_charset','UTF-8');
            //    
            /// $usr_email=html_entity_decode($e_mail);
            $host  = $_SERVER['HTTP_HOST'];
            $url_central=$_SESSION["url_central"];
            $retornar = html_entity_decode("$url_central");
            $user=$codigousp;
            $m_local="ativar.php?user=".$user."&activ_code=".$activ_code;
            /*
            $a_link = "***** CONEXÃO DE ATIVAÇÂO *****\n<br>"
            ."<a href='http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code'  title='Clicar' >"
            ."http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code</a>"; 
            */
            $a_link = "***** CONEXÃO DE ATIVAÇÂO ***** Endereço (URL) de Acesso\n<br>"
                     ."<a href='$retornar'  title='Clicar' >$retornar</a>";             
            ///
            ///  $host_upper = strtoupper($host);           
            $host_lower = strtolower($host);                     
            ///  $assunto =html_entity_decode("Redefinição de senha");    
           // $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentificação");    
            $assunto="RGE/SISTAM - Detalhes da Autentificação";    
            $corpo = "RGE/SISTAM - Permissão para ".ucfirst($descr_pa)."<br>";
            ///  $corpo .="$host_lower/rexp<br><br>";    
         ///   $corpo .=html_entity_decode("Seu cadastro como ".ucfirst($descr_pa)." foi realizado.<br>Detalhes do seu registro\r\n");                    
            $corpo .="Seu cadastro como ".ucfirst($descr_pa)." foi realizado.<br>Detalhes do seu registro\r\n";
            ///  $user_name = html_entity_decode($arr_nome_val['login']); 
            $headers1  = "MIME-Version: 1.0\n";
            ///  Alterado em 20180710            
            $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
            ///  $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
            $headers1 .= "X-Priority: 3\n";
            $headers1 .= "X-MSMail-Priority: Normal\n";
            $headers1 .= "X-Mailer: php\n";
            //  $headers1 .= "Return-Path: xxx@...\n";
            //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
            $headers1 .= "Return-Path: {$_SESSION["gemac"]} \n";
            
            //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
            // $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
            $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";  
     ////            $a_link = utf8_decode("$a_link");

            ///
            if( intval($usuario_inserir)==1 ) {
                $senha_criada="Usar a mesma senha, caso esqueceu, clicar em: Esqueceu a senha?<br/>";
                $senha_criada.= "Senha Provisória altere no primeiro acesso em Alterar -> Senha \n<br><br>";
                $senha_criada .="Senha: $senha \n<br>";
                $message = "$corpo ...\n<br><br>
                Usuário/Email: $e_mail \n<br>
                $senha_criada \n<br>

                $a_link<br><br>

                ______________________________________________________<br>
                Esta é uma mensagem automática.<br> 
                *** Não responda a este EMAIL ****
                ";
            } else {
                $message = "$corpo ...\n<br><br>
                Usuário/Email: $e_mail \n<br><br>

                $a_link<br><br>

                ______________________________________________________<br>
                Esta é uma mensagem automática.<br> 
                *** Não responda a este EMAIL ****
                ";                
            }
            ///  mail($usr_email, stripslashes(utf8_encode($assunto)), $message,$headers1);
            ///  Enviando mensagem para o participante
            $envio = mail($e_mail, stripslashes($assunto), $message, $headers1);
            ///  Enviando mensagem na tela 
            if( $envio ) {
                 /// Enviado
                 $msg_ok .= "<p>Mensagem de Acesso enviada para o email:  $e_mail<br></p>";
                 echo  $msg_ok;
            } else {
                /// Falha no envio
                 $msg_erro .= "<p><b>Falha</b>: na mensagem de Acesso enviada para o email:  $e_mail<br></p>";
                 echo  $msg_erro;
            }


            //                          
            /*    $msg_ok .= "<p>Sua senha foi redefinida e uma nova senha foi enviada para seu endereço de e-mail.<br>"
            ."<a href='$retornar' title='Clicar' >Retornar</a></p>";                         
            */
    }
    ///

    
        

}    
/**   Final - if( strtoupper($val)=="PARTICIPANTE" ) {   */ 
#
//
ob_end_flush();   /** limpar o buffer */
#
?>