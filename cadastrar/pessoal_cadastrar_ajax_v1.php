<?php
/**
*    Arquivo para CADASTRAR -  PESSOAL
*  v20250513 
*/
//  Funcao para busca com acentos
function stringParaBusca($str) {
    //
    // Transformando tudo em minúsculas
    $str = trim(strtolower($str));
    //
    /**
    *     Tirando espaços extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
    */
    while ( strpos($str,"  ") )
        $str = str_replace("  "," ",$str);
    //
    /// Agora, vamos trocar os caracteres perigosos "ã,á..." por coisas limpas "a"
    $caracteresPerigosos = array ("Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","!","?",",","“","”","-","\"","\\","/");
    $caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
    $str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
    
    /* Agora que não temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
          vamos montar a expressão regular para o MySQL                                             */
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
    
    //  Retornando a String finalizada!
    return $str;
    //
}
/**   Final - function stringParaBusca($str) {  */
//
//  Funcao para minuscula para Maiuscula
function stringParaBusca2($str) {
    //
    /**  Usar para substituir caracteres com acentos para Maiuscula  */
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
   //
   return $texto;
   //
}  
/**   Final - function stringParaBusca2($str) {  */
//
ob_start();  /** Evitando warning */
//
//  Caso SESSION_START desativado - Ativar
if( !isset($_SESSION) ) {
   session_start();
}
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
/**
 *     Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
 *   setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
 */
// 
/**  Definindo include_path padrao no php.ini  */ 
//  ini_set('include_path', '/var/www/cgi-bin/');
//
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
//  extract: Importa variáveis para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
//
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
//
//  Verificando SESSION incluir_arq - 20250109
$n_erro=0; 
$incluir_arq="";
if( ! isset($_SESSION["incluir_arq"]) ) {
    //
    $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
    //  echo $msg_erro;
    //  exit();
    $n_erro=1;
} else {
    $incluir_arq=trim($_SESSION["incluir_arq"]);    
}
if( strlen($incluir_arq)<1 )  $n_erro=1;
///
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
     $msg_erro .= "Erro ocorrido na parte: $n_erro.".$msg_final;  
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
//  Conjunto de arrays 
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
//
if( isset($_SESSION["array_pa"]) ) {
      $array_pa = $_SESSION["array_pa"];      
} 
//
// Conjunto de Functions
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");    
//
$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
     //
     $xyz = $post_array[$i];
     /**  Verificar strings com simbolos: # ou ,   para transformar em array PHP  */
     $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
     if( isset($_POST[$xyz]) ) {
	     $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
 	     if( $pos1 === false ) {
    	     //  $$xyz=trim($_POST[$xyz]);
	    	 //   Para acertar a acentuacao - utf8_encode
             $$xyz = utf8_decode(trim($_POST[$xyz])); 
    	 } else {
             $$xyz = explode($div_array_por,$_POST[$xyz]);  
         }
         // 
	 }
     //
}
/**  Final - for( $i=0; $i<count($post_array); $i++ ) {  */
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 
if( ! isset($val) ) $val="";
if( strtoupper($val)=="SAIR" ) {
      $source=$val;  
} 
//
/**  Verificando variavel   */
if( ! isset($source) ) {
    $source="";  
} 
//
/** Caso variavel $source for String */
$source_upper=""; 
if( is_string($source) ) {
    $_SESSION["source"]=trim($source);
    $source_upper=strtoupper($_SESSION["source"]);
}
//
$val_upper="";
if( isset($val) ) {
    /** Caso variavel  for String  */
    if( is_string($val) ) {
        $val_upper=strtoupper(trim($val));      
    }
} 
/**  Final - if( isset($val) ) {  */
//
//   Sair 
if( $source_upper=="SAIR" ) {
    //
    // Eliminar todas as variaveis de sessions
    $_SESSION=array();
    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($login_down) ) unset($login_down); 
    if( isset($senha_down) )  unset($senha_down); 
	//
    response.setHeader("Pragma", "no-cache"); 
    response.setHeader("Cache-Control", "no-cache"); 
    response.setDateHeader("Expires",0); 
    //
	exit();
    //
}
/**  Final - if( $source_upper=="SAIR" ) {  */
//
//
if( $source_upper=="CONJUNTO" ) {
     //
     // PARTE PARA MUDANCA DE CAMPO - IMPORTANTE
	 $n_cpo = (int) $n_cpo; 
     $cpo_final = (int) $cpo_final;
     //
     $m_vars_ambiente = $_SESSION['VARS_AMBIENTE'];   
     //  
     if( isset($m_array) ) {
         if( ! is_array($m_array) ) {
              $m_array = explode(",",$m_array);            
         }
     } else {
         $m_array="";
     }
     //
     /** Caso variavel NAO ativa - Ativar  */
     if( ! isset($_SESSION["key"]) ) {
          $_SESSION["key"]=0;      
     } 
     //
     //  Inicio do IF principal
     
/**
     echo "ERRO: LINHA/342 -->> intval($n_cpo) <= intval($cpo_final)  ";
     exit();
 */
     
	 if( intval($n_cpo) <= intval($cpo_final) ) {  
         //
         /**
         *   $cpo_where = ""; 
         *   $cpo_where_upper="";
         */
         $cpowh = "";
         $cpowh_up="";
         //
         /** Caso variavel for Array */
         if( is_array($m_array) ) {
              //
              /** Nome da Tabela executada  */
              $cpowh = trim($m_array[0]);
              //
              /** Nome do primeiro campo da Tabela */
              $pricpotbant = end($m_array);
              //
              /** Copia do Array principal das Tabelas e etc...   */
              $cparr = $m_array;
              /**  Retirando o primeiro elemento - nome da Tabela */
              unset($cparr[0]);
              //
              /***  Tabela anterior  */
              $tbant = $cpowh;


              /** Caso for o Ultimo elemento do Array $m_array */
              if( preg_match("/^sala$/ui",$tbant) ) {
                    return;     
              }
              //



              
              /**
              *     ANTES
              *   if( $val_upper=="FMRP" ) {
              *           echo "ERRO: ANTES -->>  1) \$cpowh = $cpowh  <<-->> \$val = $val -->> \$m_array  gettype = ".gettype($m_array);     
              *    }
              */
              //
              
              
              
              /**
              *   Caso Array exista
              */
              if( isset($_SESSION["arrcpos"]) ) {
                  $arrcpos = $_SESSION["arrcpos"];  
              } 
              /**
              if( isset($_SESSION["nmcpopri"]) ) {
                   $cpowh = $_SESSION["nmcpopri"];  
              } 
              */
              
              /** Qual é a chave desse elemento no Array   */
              $xkey = array_search("$pricpotbant",$arrcpos);
              //
              //  $_SESSION["select_cpo"]="sigla";
              if( $xkey ) {
                  /**  Tabelas  */
                  if( isset($arrcpos[$xkey+1]) ) {
                      $_SESSION["select_cpo"]=$arrcpos[$xkey+1];    
                  }
              } else {
                  //
                  /**  Procurando campo da Tabela no Array    */
                  $zkey = array_search("$pricpotbant",$cparr);
                  /**
                  *     Campos da Tabela 
                  */
                  if( isset($cparr[$zkey+1]) ) {
                      $_SESSION["select_cpo"]=$cparr[$zkey+1];    
                  }
                  //
              }
              //
              $cpowh_up=strtoupper($cpowh);
              //
              //
         }
         /**  Final - if( is_array($m_array) ) { */
         //
         if( is_string($m_array) ) {
             echo "ERRO: \$m_array =$m_array ";
             exit();
         }    
         //
         /**  Desativando Arrays  */
         unset($_SESSION['cponm1']);
         unset($_SESSION['cpoval1']);
         //
         //          
         if( $_POST["idnmtb"] ) {
             //
             //  Nome dos campos das Tabelas 
             $idnmtb = explode(',',$_POST["idnmtb"]);
             $lnidnmtb = count($idnmtb); 
             //
             $idvltb = explode(',',$_POST["idvltb"]);
             //
             for( $chave=0; $chave<$lnidnmtb; $chave++ ) {
                   //
                   // echo $row["Field"] . "<br>";
                   $nomecpo=$idnmtb[$chave];
                   $_SESSION['cponm1'][$chave]=$nomecpo;
                   //
                   $valc = $idvltb[$chave];
                   $_SESSION['cpoval1'][$chave]="{$valc}";
                   //
                   if( preg_match("/setor|codsetor|idsetor|sigla|sigsetor/ui",$nomecpo)  )  {
                      /// Nome da coluna  codigo SETOR  da Tabela  
                      $_SESSION['cponm1'][$chave] = $_SESSION["codidseto"];
                  }
                  ///
                  if( preg_match("/instituicao|idinst|^codinst/ui",$nomecpo)  )  {
                      /// Nome da coluna  INSTITUICAO  da Tabela  
                      $_SESSION['cponm1'][$chave] = $_SESSION["codidinst"];          
                  }
                  //
                  if( preg_match("/unidade|^codunid|idunid/ui",$nomecpo)  )  {
                      /// Nome da coluna UNIDADE  da Tabela  
                      $_SESSION['cponm1'][$chave] = $_SESSION["codidunid"];          
                  }
                  //
                  if( preg_match("/departamento|^depto|^coddept|iddept/ui",$nomecpo)  )  {
                      /// Nome da coluna DEPTO/DEPARTAMENTO da Tabela  
                      $_SESSION['cponm1'][$chave] = $_SESSION["codiddept"];          
                  }
                  ///
             }
             /**  Final - for( $chave=0; $chave<$lnidnmtb; $chave++ ) { */
             //
           
         }   
         /**  Final - if( $_POST["idnmtb"] ) {  */
         // 
         //
		 /**  $pos_encontrada = array_search($cpowh,$m_array);  */
		 //  Definindo a posicao para o proximo campo 
         $_SESSION["key"]= (int) $_SESSION["key"]+1;                  
    	 $ttarray=sizeof($m_array);
         //
		 //  if( strtoupper($cpowh)=="INSTITUICAO" ) {
         //   if( $cpowh_up=="INSTITUICAO" ) {
         if( preg_match("/instituicao|codinst|idinst/ui",$cpowh_up) ) {
              //
              $i=2;  
              /**
              *   unset($_SESSION['cponm1']);
              *    unset($_SESSION['cpoval1']);
              */
              //
              $_SESSION["key"]=0;     
              //         
		 } else {
             //
             $i=0;
             for( $j=1; $j<$ttarray; $j++ ) {
                  /**  Elemento do Array */
                  $elm_a=$m_array[$j];
                //  if( $cpowh==$m_array[$j] ) {
                  if( $tbant==$m_array[$j] ) {
                      $i=$j+1;             
                      break;
                  }
             }
             /**  Final - for( $j=1; $j<$ttarray; $j++ ) {  */
             //
			 //  Verifica se esse campo ja foi selecionado no array
			 //  remover o anterior
             if( $_SESSION['cponm1'] ) {
                  //
                  $total = sizeof($_SESSION['cponm1']); 
			      for( $ver=0; $ver<$total ; $ver++ ) {
                       //
                       if( $cpowh==$_SESSION['cponm1'][$ver] or $j<$total  ) {
                            $_SESSION["key"]=$ver;  // Importante depois de achar duplicata
					        for( $ver; $ver<$total ; $ver++ ) {
                                 unset($_SESSION['cponm1'][$ver]);
                                 unset($_SESSION['cpoval1'][$ver]);        
						    }							   
					   }
                       //  
				  }
                  /**  Final - for( $ver=0; $ver<$total ; $ver++ ) {  */
                  //
			 }
             /**   Final - if( $_SESSION['cponm1'] ) { */
             //
		 }
		 ///
         $table_atual = ""; 
         if( isset($m_array[$i]) ) $table_atual = $m_array[$i];
         $tb_up = strtoupper(trim($table_atual));
         //
         $val_upper=strtoupper($val); 
         //
         /**
         *    Criando ARRAY
         */
		 $array2 = array("bloco","salatipo","sala");
         //
		 //  Precisava passar a variavel 
		 if( $cpowh_up=="SALA" ) $table_atual="sala";	
         $chave = $_SESSION["key"];
         //
         $_SESSION["conjunto"].="$val ";
         //  
         //  Precisava passar a variavel 
         //  Mudando a variavel - $table_atual       
         
         
      /**  if( $cpowh_up=="INSTITUICAO" && strtoupper(trim($table_atual))=="SALATIPO"  ) {  */
         if( $cpowh_up=="INSTITUICAO" && $tb_up=="SALATIPO"  ) {
              //
              //   if(  strtoupper(trim($table_atual))=="SALATIPO"  ) {
              $msg_erro .= "-> cadastrar_auto_ajax.php/305  - FALHA GRAVE ";
              echo  $msg_erro;   
              exit();
         } 
         /**  Final - if( $cpowh_up=="INSTITUICAO" && $tb_up=="SALATIPO"  ) {  */                                    
         //
         $select_cpo=$_SESSION["select_cpo"];
         //

       //  if( $tb_up=="BLOCO" || $tb_up=="SALATIPO" || $tb_up=="SALA" ) { 
         if( preg_match("/BLOCO|SALATIPO|^SALA$/ui",$tb_up) ) {     
              //
              $select_cpo=$_SESSION["select_cpo"]=$table_atual; 
              $table_atual="bem"; 
              $apagaressavar="";
         }                              
         /**  Final - if( preg_match("/BLOCO|SALATIPO|^SALA$/ui",$tb_up) ) {  */ 
         //

                                                       

//  if( $val_upper=="GEMAC" ) {
/**
if(strtoupper($pricpotbant)=="BLOCO" ) {                           
   echo  "ERRO: pessoal_cadastrar_ajax/440  -->>   \$table_atual = $table_atual  <<-->>  \$n_cpo = $n_cpo <<-- "
       ." <br> -->> \$cpo_final =<b> $cpo_final </b>   "
       ."  -->> \$m_vars_ambiente = $m_vars_ambiente  <<--  \$source = $source <<-->>  \$val = $val  "
       ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up  -->>  \$select_cpo =<b> $select_cpo </b>";
     exit();
}
*/



         //
         $_SESSION["where"]="";            
         $ttarrays = sizeof($_SESSION['cponm1']);        
         for( $row = 0; $row < $ttarrays; $row++) {
              //
              // Nome do campo da Tabela
              $p1 = $_SESSION['cponm1'][$row];
              //
              //  Valor recebido
              $p2 = $_SESSION['cpoval1'][$row];
              //
              
              
              //  Campos da Tabela bem
              // if( $tb_up=="SALATIPO" || $tb_up=="SALA" ) {       
               if( preg_match("/SALATIPO|^SALA$/ui",$tb_up)  ) {       
                   /**
                   *  $_SESSION["where"].= " upper(trim(".$_SESSION['cponm1'][$row]."))  like ";
                   */
                   $_SESSION["where"].= " acentos_upper(".$p1.") like ";
                   $_SESSION["where"].=  " acentos_upper(\"$p2%\")  ";
              } else {
                   $_SESSION["where"].= " acentos_upper(".$p1.")=";
                   $_SESSION["where"].=  " acentos_upper(\"$p2\") ";
              }      
              //
              if( $row<($ttarrays-1) ) $_SESSION["where"].=  " and ";
              //
         }
         /**  Final - for( $row = 0; $row < $ttarrays; $row++) {  */
         //
         $where=$_SESSION["where"];     
         //


/**  if( strtoupper($cpowh)=="INSTITUICAO" ) {   */  
//  if( strtoupper($cpowh)=="UNIDADE" ) {        
/**
if(strtoupper($pricpotbant)=="BLOCO" ) {   

if( strtoupper($cpowh)=="INSTITUICAO" ) { 
   echo  "667 -  \$select_cpo = $select_cpo  -<br> \$where = $where  <br>"
         ." - \$table_atual = $table_atual  <<-->>  \$n_cpo = $n_cpo <<-- "
       ." <br>  \$cpo_final =<b> $cpo_final </b> \$_SESSION[codidseto] = {$_SESSION["codidseto"]}   "
       ."  <br>> \$m_vars_ambiente = $m_vars_ambiente  <br>  \$source = $source <<-->>  \$val = $val  "
       ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up -->>   \$select_cpo = $select_cpo  <br>";
}
*/


         
            
         //
	     //  Selecionando campo 	
         //  elemento define o bd_1  e o elemento2  o  bd_2
         $elemento=3;
         include("php_include/ajax/includes/conectar.php");	
         //
         /**  Array  */
         $tabs_sig_nome= array("instituicao","unidade","depto","setor");			    
	     $nome_cpo="";
         if( in_array($table_atual,$tabs_sig_nome) ) {
              $nome_cpo="nome,";   
         }
         /**
         *   mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query() 
         *     $result=mysql_query("SELECT ".$_SESSION["select_cpo"].", $nome_cpo count(*) FROM "
         *   ." $table_atual where ".$_SESSION["where"]."  group by 1 order by  ".$_SESSION["select_cpo"]);
         */
         //  Selecionando Banco de Dados/DB
         mysqli_select_db($_SESSION["conex"],$bd_1);                  
         /**  Definindo    
         *    "utf8": UTF-8, um dos conjuntos de caracteres mais comuns para suportar diferentes idiomas.
         */  
         //  mysqli_set_charset($conex,'latin1');
         mysqli_set_charset($conex,'utf8');
         //
         $slcup = strtoupper(trim($select_cpo));
         //
         
         /**
echo  "ERRO: pessoal_cadastrar_ajax/527  -->>  SEGUINDO  \$select_cpo = $select_cpo  <<-- \$where = $where  <<-->>  \$table_atual = $table_atual  <<-->>  \$n_cpo = $n_cpo <<-- "
       ." <br> -->> \$cpo_final =<b> $cpo_final </b>   "
       ." <br>   -->>  \$slcup =<b>  $slcup </b> <<-->> \$m_vars_ambiente = $m_vars_ambiente  <<--  \$source = $source <<-->>  \$val = $val  "
       ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up -->>   \$select_cpo = $select_cpo  ";
exit();
  */

         
         
         
      //   if( $slcup=="SALATIPO" || $slcup=="SALA" ) { 
      //   if( preg_match("/SALATIPO|^SALA$/ui",$slcup)  ) {                    
         /***  Alterado em 20250109
           *      Function no Mysql para retirar acentos na COLUNA definida               
         ***/
         // 
         $ordenar=" ORDER BY $select_cpo ";         
         /** Caso for o penulltimo elemento do Array $m_array */
         if( preg_match("/^salatipo$/ui",$tbant) ) {
              $ordenar=" ORDER BY  CAST($select_cpo AS UNSIGNED) asc ";         
         }
         //
         // Select/MYSQLI - principal
         $sqlcmd="SELECT remove_accents($select_cpo) as $select_cpo, $nome_cpo count(*) ";
         $sqlcmd.=" FROM  $bd_1.$table_atual ";
         $sqlcmd.=" WHERE $where  collate latin1_swedish_ci GROUP BY 1 $ordenar ";
         //
         
         

//              if( $val_upper=="FMRP" ) {
/**  if( strtoupper($cpowh)=="INSTITUICAO" ) {  
if(strtoupper($pricpotbant)=="BLOCO" ) {                             
   echo  "ERRO:  pessoal_cadastrar_ajax/743  -->>  \$sqlcmd = $sqlcmd <<--<br>"
         ."  \$select_cpo = $select_cpo  <<-- \$where = $where  <<-->>  \$table_atual = $table_atual  <<-->>  \$n_cpo = $n_cpo <<-- "
         ." <br> -->> \$cpo_final =<b> $cpo_final </b>   "
         ." <br>   -->>  \$slcup =<b>  $slcup </b> <<-->> \$m_vars_ambiente = $m_vars_ambiente  <<--  \$source = $source <<-->>  \$val = $val  "
         ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up -->>   \$select_cpo = $select_cpo  "
         ." <br> \$sqlcmd = $sqlcmd ";

     exit();
 }
   */           

         
         
         
         
         //  Select/MYSQLI
         $result=mysqli_query($conex,$sqlcmd);
         // Caso houver ERRO
         if( ! $result ) {
             //
             /**
             *    $terr='ERRO: Select - falha:&nbsp;db/mysqli:&nbsp;';
             *    die("$terr".mysql_error());  
             */
              $terr='Select remove_accents - falha:&nbsp;db/mysqli:&nbsp;';
              echo $funcoes->mostra_msg_erro("$terr".mysqli_error($_SESSION["conex"])); 
              exit();
         } 
         /**  Final - if( ! $result ) {  */
         //
         //  Nome do primeiro campo da Tabela 
         $nmcpopri  = mysqli_field_name($result,0);                 
         $_SESSION["nmcpopri"]=$nmcpopri;
         //         
         //  Verifica Tabela 
         /**  Caso Tabela for bem alterar variavel */
         if( strtoupper($table_atual)=="BEM" ) {
              $table_atual=$_SESSION["select_cpo"];   
         } 
         //
         //  Nr. Regitros
         $m_linhas = mysqli_num_rows($result);
         //


         //     if( $val_upper=="FMRP" ) {
     //    if( $val_upper=="C" ) {
/**
        if( $val_upper=="GEMAC" ) { 
if(strtoupper($pricpotbant)=="BLOCO" ) {                                         
echo  "ERRO: pessoal_cadastrar_ajax/631  -->>  \$sqlcmd = $sqlcmd <<--<br>"
     ."  \$select_cpo = $select_cpo  <<-- \$where = $where  <<-->>  \$table_atual =<b> $table_atual </b> <<-->>  \$n_cpo = $n_cpo <<-- "
       ." <br> -->> \$cpo_final =<b> $cpo_final </b> \$nome_cpo = $nome_cpo  "
       ." <br> -->> \$slcup =<b>  $slcup </b> <<-->> \$m_vars_ambiente = $m_vars_ambiente  <<--  \$source = $source <<-->>  \$val = $val  "
       ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up -->>   \$select_cpo = $select_cpo  "
       ." <br> \$m_linhas = <b>$m_linhas</b> -->>  \$nmcpopri = $nmcpopri ";

 exit();
              }
*/              

         



		 //
         $_SESSION["table_atual"]=$table_atual;
         //
         $cp_table_atual=$table_atual; 
         //
         $cp_cpowh=$cpowh;
         //
         if( strtoupper($tb_up)=="INSTITUICAO" ) {
              $cp_table_atual="instituição";
         } 
         //
         if( preg_match("/instituicao|codinst|idinst/ui",$cpowh_up) ) { 
                 $cp_cpowh="Instituição";
         }
         if( $tb_up=="DEPTO" ) $cp_table_atual="departamento";
         if( strtoupper($cpowh_up)=="DEPTO" ) $cp_cpowh="departamento";  
         if( strtoupper($tbant)=="SALATIPO" ) $cp_cpowh="SalaTipo";  
         if( strtoupper($tbant)=="SETOR" ) $cp_cpowh="Setor";  
         // 
         /**  Caso nenhum registro encontrado  */
        if( intval($m_linhas)<1 )  {
               /** echo "==== Nenhum(a) <b>".ucfirst($table_atual)."</b> desse(a) <b>"
               *                      .ucfirst($cpowh)."</b> ====";    
               */
               echo "==== Nenhum(a) <b>".ucfirst($cp_table_atual)."</b> desse(a) "
                                     .ucfirst($cp_cpowh)."&nbsp;(<b>$val</b>)";    
               exit();
        }  
        /**  FInal if( intval($m_linhas)<1 )  {  */
        //
		//  Executar IF quando nao for o ultimo campo
        
/**
   echo  "ERRO: pessoal_cadastrar_ajax/608  -->>  \$m_linhas = $m_linhas  <<-- \$where = $where  <<-->>  \$table_atual = $table_atual  <<-->>  \$n_cpo = $n_cpo <<-- "
       ." <br> -->> \$cpo_final =<b> $cpo_final </b> \$i = $i  <<<---    "
       ."  -->> \$m_vars_ambiente = $m_vars_ambiente  <<--  \$source = $source <<-->>  \$val = $val  "
       ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up -->>   \$select_cpo = $select_cpo  ";
   exit();
*/
        
        
        
        //
        if( intval($i) < intval($cpo_final) ) {
                //

/**                
echo  "ERRO: pessoal_cadastrar_ajax/621  -->> DENTRO  \$m_linhas = $m_linhas  <<-- \$where = $where  <<-->>  \$table_atual = $table_atual  <<-->>  \$n_cpo = $n_cpo <<-- "
       ." <br> -->> \$cpo_final =<b> $cpo_final </b> \$i = $i  <<<---  \$nome_cpo = $nome_cpo  "
       ."  -->> \$m_vars_ambiente = $m_vars_ambiente  <<--  \$source = $source <<-->>  \$val = $val  "
       ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up -->>   \$select_cpo = $select_cpo  ";
exit();
   */             
                
                
		     ?>
            <span class="td_informacao2"  >
             <label for="<?php echo $table_atual;?>" >&nbsp;<?php echo ucfirst($table_atual);?>:</label><br />
             <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviar_dados_cad('CONJUNTO',this.value,this.name+'|'+'<?php echo $m_vars_ambiente;?>'+'|'+'<?php echo $nmcpopri;?>');" style="padding: 1px;" >            
             <?php
                 //
          	     //  acrescentando opcoes
	             echo "<option value='' >&nbsp;Selecionar&nbsp;</option>";
                 //  WHILE  DA TAG SELECT    
                 //  while( $linha=mysqli_fetch_array($result) ) {   
                 while( $linha=$result->fetch_array(MYSQLI_BOTH) ) {   
                         //
      				     //  Desativando selected - opcao que fica selecionada
                         /**
                         *    $value = urlencode($linha["sigla"]);
                         *    $nome = trim(htmlentities($linha["sigla"]));
                         */
                         $value = urlencode($linha[0]);
                         if( isset($linha["nome"]) ) {
                             $nome = trim(htmlentities($linha["nome"]));    
                         }
                         /**  Final - if( isset($linha["nome"]) ) {  */
                         //
                         $inst_selected = "";
                         $traco="";
                         //
                          $se_sigla=""; $se_nome="";
						  if( strlen($nome_cpo)>1 ) {
                              //
                              //  htmlentities - o melhor para transferir na Tag Select
                              /**
                              *   if( isset($linha["sigla"]) ) $se_sigla= htmlentities($linha["sigla"]);  
                              *   if( isset($linha["nome"]) ) $se_nome= htmlentities($linha["nome"]); 
                              */
                              if( isset($linha[0]) ) $se_sigla= $linha[0];  
                              if( isset($linha["nome"]) ) $se_nome= $linha["nome"]; 
                              //
                              $traco="-";                  
                              // 
                          } else {
                              $se_sigla=$value;
                          }    
                          //
                          // $title_sigla=$se_sigla."&nbsp;".$traco."&nbsp;".$se_nome;
                          $title_sigla="title";
     
/**                     
echo  "ERRO: pessoal_cadastrar_ajax/688  -->> DENTRO   \$title_sigla = $title_sigla <<-- \$m_linhas = $m_linhas  <<-- \$where = $where  <<-->>  \$table_atual = $table_atual  <<-->>  \$n_cpo = $n_cpo <<-- "
       ." <br> -->> \$cpo_final =<b> $cpo_final </b> \$i = $i  <<<---    "
       ."  -->> \$m_vars_ambiente = $m_vars_ambiente  <<--  \$source = $source <<-->>  \$val = $val  "
       ."<br> \$ttarray = $ttarray  -->> \$cpowh_up = $cpowh_up -->>   \$select_cpo = $select_cpo  ";
   */
                

     
     
                          echo  "<option $inst_selected   value=".$value."  >";
                          //  echo  htmlentities($nome,ENT_QUOTES,"UTF-8")."</option>" ;
                          echo  "$se_sigla</option>";
                          echo "</option>";
                          ///  echo  $nome."&nbsp;</option>" ;
                          //
   	              }  
                  /**   Final - while( $linha=$result->fetch_array(MYSQLI_BOTH) ) {  */
                  //
	       	  ?>
	          </select>
	          </span>
			  <?php
                  //
                 /**  Desativar variavel   */ 
                 if( isset($result) ) {
                     //  mysqli_free_result($result);   
                     unset($result);   
                     //
                 } 
                 /**  Final - if( isset($result) ) { */
                 //
    	         // Final do SELECT
                 if( strtoupper(trim($_SESSION["select_cpo"]))=="SALA" ) {
                       $cpo_final=0; $n_cpo=0; unset($m_array); 
                       unset($m_linhas); unset($source);
                       unset($_SESSION["where"]); 
                       unset($_SESSION["select_cpo"]);  
                       //
                 }
                 //
                 exit();
                 //
          } 
          /**  Final - if( intval($i) < intval($cpo_final) ) {  */
          //
     }  
     ///  Final do IF principal
     //
}
/**  Final - if( $source_upper=="CONJUNTO" ) { */
//
/**
*   Serve tanto para o arquivo projeto  quanto para o experimento
*/
//   Campo para Novo Chefe 
if( $source_upper=="NOVO_CHEFE" ) {
     //
     /**  Conexao/MySQLI   */
     $conex = $_SESSION["conex"];
     //
     //  elemento define o bd_1  
     $m_linhas=0; $bd_1="";
     
/**     
     echo "ERRO: pessoal_cadastrar_ajax/1033  -->> \$source_upper = $source_upper -->> \$val = $val ";
     exit();
     */
     
     //
     if( strlen(trim($val))>0 ) {
         //
   //      $elemento=5;
    //     include("php_include/ajax/includes/conectar.php");        
         //
         /**  Conexao/MYSQLI  */
         $conex = $_SESSION["conex"];
         //
         //  Banco de Dados - BD/DB
         if( ! isset($_SESSION["bd_1"]) ) {
             //
             echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
             exit();
         }
         $bd_1 = $_SESSION["bd_1"];   
         //
         /**
         *    $sqlcmd="SELECT distinct codigousp,nome FROM  $bd_1.pessoa  where categoria like 'DOC%'  COLLATE latin1_swedish_ci  order by nome "; 
         */      
         //  Selecionando o banco de dados
         $resultadobd=mysqli_select_db($conex,"$bd_1");
         if( ! $resultadobd  ) {
              //
              // or die(mysql_error());
             $msg_erro .="&nbsp;Select db falha: db/mysql ";
             $msg_erro .= mysqli_error($_SESSION["conex"]).$msg_final;  
             echo $msg_erro;  
             exit();
         } 
         //          
         $conex->set_charset('utf8');
         //  
         //  Selecionando chefes
         $sqlcmd="SELECT distinct nome FROM  $bd_1.chefe ";
         $sqlcmd.="  WHERE acentos_upper(nome) like acentos_upper(\"$val%\") order by nome  "; 
         $result = mysqli_query($conex,$sqlcmd);
         //
         // Verifica se houve erro
         if( ! $result ) {
             //
             // die('ERRO: Select tabela pessoa - falha: '.mysql_error());  
             $msg_erro .="&nbsp;Select tabela chefe: db/mysqli ";
             $msg_erro .= mysqli_error($_SESSION["conex"]).$msg_final;  
             echo $msg_erro;  
             exit();
         }
         //
         //  Nr. de Chefe/Orientador
         $m_linhas = mysqli_num_rows($result);
         
/**     
     echo "ERRO: pessoal_cadastrar_ajax/1091  -->> \$source_upper = $source_upper -->> \$val = $val  -->>  \$m_linhas = $m_linhas ";
     exit();
 */    
         
         
         //  Verifica Nr. de Registros 
         if( intval($m_linhas)>0 ) {
             //
             $cpo_nome_descr=mysqli_field_name($result,0);        
             //
             ?>
             <select id="tmpnovochefe" class="cposelup"
                 onchange="document.getElementById('<?php echo $source;?>').value=this.value;"  >
                  <option value='' >Selecione...</option>   
                     <?php
                         //
                         //  Chefe/Orientador
                         //  Usando arquivo com while e htmlentities
                         $_SESSION["siglaounome"]="CATEGORIA";
                         //
                         include("{$_SESSION["incluir_arq"]}includes/tag_select_tabelas.php");
                         //
                         $_SESSION["siglaounome"]="";
                         //
                       ?>
                     <!--  Final do Select chefe  -->
                     </select>
                  <?php
         }
         /**  Final - if( intval($m_linhas)>0 ) {  */
              //
     }
     /**  Final - if( strlen(trim($val))>0 ) {  */
     //  
     exit();
     //
}   
/**  Final - if( $source_upper=="NOVO_CHEFE" ) { */ 
//   
//  Tabela pessoa - BD PESSOAL
if( $val_upper=="PESSOAL" ) {
     //
     //  Verificando campos -- CONECTANDO
     $elemento=5;  $m_regs=0;
     include("php_include/ajax/includes/conectar.php");
     //
     /**	 
     *    Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
	 *	 OU para MYSQL  tem que ser html_entity_decode
     */	
 	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $cntarrtmp = sizeof($array_temp);
     $i_codigousp=-1;
     //
     $cntx= count($array_temp);
     for( $za=0;$za<$cntx;$za++ ) {
            $zcponmelm = strtoupper(trim($array_temp[$za]));
            //
            /**  Nome da Pessoa   */
            if( preg_match("/^nome/ui",$zcponmelm) ) {                        
                 $nomepessoa=trim("{$array_t_value[$za]}");    
                 break;
            }
            //
     }
     //
     
/**     
  echo "ERRO:  LINHA/1165  -->> INICIO  \$nomepessoa = $nomepessoa <<-->> \$source_upper =$source_upper  <<-->>  \$val_upper = $val_upper  ";
  exit();
   */  





     /**   ALTERADO EM 20250122
     *   for( $i=0; $i<$cntarrtmp; $i++ ) {
     *          $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
     *          // Salvando a posição do campo codigousp para criar codigo <0 para usuario de fora da USP
     *         if( strtoupper(trim($array_temp[$i]))=="CODIGOUSP" ) $i_codigousp=$i;
     *    }
     */
     //  Caso novo_chefe solicitado
     $novo_chefeHTML="";
     for( $i=0; $i<$cntarrtmp; $i++ ) {
          //
         ////  Caso encontrado
         $arrtmpup = strtoupper(trim($array_temp[$i]));
         if( $arrtmpup=="NOVO_CHEFE" ) {
             //
               //  Alterado em 20170301
               //  $novo_chefe=stringParaBusca2($array_t_value[$i]);
               $novo_chefe=trim($array_t_value[$i]);
               $novo_chefeHTML=trim($array_t_value[$i]);
               //  $descricao =utf8_decode($novo_chefe);
               break;  
         }
         /**  Final - if( $arrtmpup=="NOVO_CHEFE" ) {  */
         //
     }
     /**   Final - for( $i=0; $i<$cntarrtmp; $i++ ) {  */
     //
     /**     Detectar codificação de caracteres    */
     if( isset($novo_chefe) ) {
         //
         $codigo_caracter=mb_detect_encoding($novo_chefe);
         if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
              //  Converter  para  UFT-8
              $novo_chefe=html_entity_decode($novo_chefe, ENT_QUOTES, "UTF-8");
              //
         }         
         //
     }
     /**  Final - if( isset($novo_chefe) ) { */
     //           
     /**    SESSION do Banco de Dados 
      *   abaixo para ser usada no include  
      */
     $bd_1="pessoal";         
     $_SESSION["bd"]=$bd_1;         
     //
     /**  Tabela principal  */
     $_SESSION["tabela"]="pessoa"; 
     //
     //  Definindo SESSION
     $_SESSION["erro"]="";
     //
     //  INCLUDE   
     $_SESSION["respx"]="";
     include("dados_pessoal_cadastro_ajax.php");  
     //
     //   Verificando ERRO
     if( strlen(trim($_SESSION["erro"]))>0 ) {
           echo  $funcoes->mostra_msg_erro("{$_SESSION["erro"]}");
           exit();
     }
     /**  Final - if( strlen(trim($_SESSION["erro"]))>0 ) {  */
     //
     /** 
     *   Verificando o numero de elementos 
     *     no array $arr_nome_val  
     */
     //
     if( isset($arr_nome_val) ) {
          //
          $cntarrtmp=sizeof($arr_nome_val);
          //
          /**   Definindo os nomes dos campos recebidos do FORM  */
          $nelem=0;
          foreach( $arr_nome_val as $elemento => $valor ) {
                    $$elemento = $valor;
                    $nmcpoup=strtoupper($elemento);
                    //
                    /**  COdigo da Pessoa   */
                    //  if( $nmcpoup=="CODIGOUSP" ) {
                    if( preg_match("/^codigo/ui",$nmcpoup) ) {                        
                         $i_codigousp=$nelem;    
                         $codigousp=$valor;    
                    }
                    //
                    ++$nelem;
                    //
          } 
          //
     } else {
         //
         $msg_erro .="&nbsp;Array arr_nome_val n&atilde;o foi definido.".$msg_final;
         echo $msg_erro;         
         exit();              
     }  
     //
     /**  Conexao MYSQLI  */
     $conex =  $_SESSION["conex"];
     //
     /**  COdigo USP  */
     $anvcod = intval($arr_nome_val["codigousp"]);
     
/**
  echo "ERRO:  LINHA/1183  -->> \$anvcod =<b> $anvcod </b> <<-->> \$cntarrtmp = $cntarrtmp <<- <br>"
               ."  ->> \$source_upper =$source_upper  <<-->>  \$val_upper = $val_upper  ";
  exit();
   */
     
     
     //
     /**  CASO  NAO tenha codigo USP sera criado   */
     if( intval($anvcod)==0 ) {          
         /** 
         *     Caso for novo codigousp
         */
         //  Selecionar todos os usuarios menor que  ZERO/0 
         $proc="SELECT min(codigousp) as codigo_ult  FROM  $bd_1.pessoa where codigousp<0 ";
         $result=$conex->query("$proc") ;
         if( ! $result ) {
             die("Falha erro no Select/Atribuir codigoUSP".mysqli_error($_SESSION["conex"]));
         }
         //  Nr. Registros
         $m_regs=mysqli_num_rows($result);
         if( intval($m_regs)>0 ) {
             $codigo_prx = mysqli_result($result,0,'codigo_ult');
         } 
         /**  Final - if( intval($m_regs)>0 ) {  */
         //
         if( ! isset($codigo_prx) ) {
             $codigo_prx = 0;
         }
         $codigo_prx += -1;
         //
         /**  Desativar variavel  */
         if( isset($result) ) {
               mysqli_free_result($result);  
         } 
         //
         $arr_nome_val["codigousp"] = $codigo_prx;
         if( intval($i_codigousp)<0 ) {
              die("ERRO: Falha inesperada criando um NOVO codigo USP.");
         }
         //
         //   Alterado em 20250127
         //   $array_t_value["$i_codigousp"] = $codigo_prx;
         $arr_nome_val["codigousp"] = $codigo_prx;
         $codigousp = $codigo_prx;
         //
         /**
             Corrigir array elemento codigousp da pessoa sendo cadastrada
         */
          $campo_nome=explode(",",$campo_nome);
          $cnt_arcponome=count($campo_nome);
          $campo_value=explode(",",$campo_value);
          for( $nc=0;$nc<$cnt_arcponome; $nc++ ) {
               $upcpnm=strtoupper(trim($campo_nome[$nc]));
               /**  if( strtoupper($campo_nome[$nc])=="CODIGOUSP" ) { */
               if( preg_match("/^codigo/ui",$upcpnm) ) {
                     $campo_value[$nc]=$codigousp;          
               }
               //
          }
          //
          //  Caso houver excesso de elementos no array  $campo_value
          //  O mesmo volume de elementos dos dois arrays
          $campo_value = array_slice($campo_value, 0, $cnt_arcponome); 
          $campo_nome=implode(",",$campo_nome);
          $campo_value=implode(",",$campo_value);
          if( array_key_exists("codigousp", $arr_nome_val) ) {
               $arr_nome_val["codigousp"]=$codigousp;  
          }
          //
     }
     /**   Final - if( intval($arr_nome_val["codigousp"])==0 ) {   */
     //
     //  VERIFICANDO se essa pessoa ja tem cadastro
     $cdg = (int) $arr_nome_val["codigousp"];
     $proc="SELECT codigousp,nome FROM $bd_1.pessoa WHERE codigousp=$cdg ";
	 $result_usu=$conex->query("$proc") ;
	 if( ! $result_usu ) {
		  die("Falha erro no Select".mysqli_error($_SESSION["conex"]));
	 }
     //  Nr. de Registros
     $m_regs=mysqli_num_rows($result_usu);
     if( isset($result_usu) ) {
          mysqli_free_result($result_usu);  
     } 
     /**  Final - if( isset($result_usu) ) {  */
     //
     // Verifica o total de registros
     if( intval($m_regs)>=1 ) {
        //
         /**  Pessoa JA Cadastrada  */
         $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;";
         $msg_erro .= $arr_nome_val["codigousp"]." j&aacute; est&aacute; cadastrado.".$msg_final;
         echo $msg_erro;
         exit();
     } 
     /**    Final - if( intval($m_regs)>=1 ) {  */
     //
     /**
     *     Vericando se o NOME se ja esta cadastrado  na Tabela pessoa
     *    IMPORTANTE: no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim 
     *     REMOVER os espacos do nome deixando apenas um entre as palavras
     *   $arr_nome_val['nome'] = trim(preg_replace('/ +/',' ',$arr_nome_val['nome']));            
     *    $pessoa_nome=html_entity_decode(strtoupper(trim($arr_nome_val['nome'])));
     *    ACERTAR O CAMPO NOME, retirando acentuação e passando para maiusculas
     *  $pessoa_nome=stringParaBusca2(strtoupper(trim($arr_nome_val['nome'])));
     */
     //  
     /**  Acertando ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
     *     $pessoa_nome=html_entity_decode(trim($pessoa_nome)); 
     * 
     *   SESSION abaixo para ser usada no INCLUDE - organiza dados com a Tabela
     */
     // Banco de Dados principal 
  //   $_SESSION["bd"]=$bd_1;         
     //
     //  Tabela principal
//     $_SESSION["tabela"]="pessoa"; 
     //
     //  CORRIGIR DADOS E RETORNAR  
     include("dados_pessoal_cadastro_ajax.php");  
     //
     //  Caso tenha o codigousp  alterar o array $arr_nome_val
     if( array_key_exists("codigousp", $arr_nome_val) ) {
         $arr_nome_val["codigousp"]=$codigousp;  
     }
     //
     
/**
  echo "ERRO:  LINHA/1281  -->> \$anvcod =<b> $anvcod </b> <<-->> \$cntarrtmp = $cntarrtmp <<- <br>"
               ."  ->> \$source_upper =$source_upper  <<-->>  \$val_upper = $val_upper  "
               ."<br> \$codigo_prx = $codigo_prx  -->>  \$codigousp = $codigousp  ";
  exit();
 */
     
     
     //  Selecionando o banco de dados
     $resultadobd=mysqli_select_db($conex,"$bd_1");
     if( ! $resultadobd  ) {
         //
         // or die(mysql_error());
         $msg_erro .="&nbsp;Select db falha: db/mysql ";  
         $msg_erro .=mysqli_error($_SESSION["conex"]).$msg_final;
         echo $msg_erro;  
         exit();
     }
     /**  Final - if( ! $resultadobd  ) {   */
     //
     /**  Conexao/MYSQLI  */
     $conex = $_SESSION["conex"];
     //
     $conex->set_charset("utf8");           
     ///       
     /**  Definindo os nomes dos campos recebidos do FORM  */
     foreach( $arr_nome_val as $xchave => $xvalor ) {
             $$xchave = $xvalor;  
     } 
     //
     /**
     *   CASO a variabel chefe  - NAO esteja ativa
     */
     $regronovochefe=0;
     
     
/**
  echo "ERRO:  LINHA/1359  -->>   \$anvcod = $anvcod  <<-->>  \$m_regs = $m_regs  <<-->>  \$cntarrtmp = $cntarrtmp <<- <br>"
               ."  ->> \$bd_1 = $bd_1  <<-- \$codigo_prx =<b> $codigo_prx </b> <<--  <br>"
               ." ->> \$tabela = $tabela  <<-->>  \$source_upper = $source_upper  <<-->>  \$val_upper = $val_upper  "
               ."<br>\$codigousp = $codigousp  -->> \$chefe =<b>  $chefe </b> "
               ."<br>  \$cpo_nome =  $campo_nome  \r\n  -->> \$campo_value =  $cpo_valor ";
  exit();
   */
     
     
     
     if( ! isset($chefe) ) {
         //
         //   Incluir novo chefe na LISTA  
         /**  Caso  declarado  no FORM o campo novo_chefe  */
         if( isset($novo_chefe) ) {
             //
             //   $novo_chefe=trim($novo_chefe);
             $temparray = explode(" ",$novo_chefe);
             $numelems=count($temparray);
             if( intval($numelems)<2 ) {
                 //
                 // or die(mysql_error());
                 $msg_erro .="&nbsp;Nome do novo chefe inválido. $novo_chefe ";  
                 echo $msg_erro;  
                 exit();
             }
             //
             /**
             *          Verifica se esse Chefe existe
             *     $sqlcmd=mysql_query("SELECT nome from $bd_1.chefe WHERE  trim(nome)=trim(\"$novo_chefe\")  ");
             */
             // 
             //  Select/MYSQLI              
             $proc="SELECT nome,chefecodusp from $bd_1.chefe "; 
             $proc.="  WHERE  upper(clean_spaces(nome))=upper(clean_spaces('".$novo_chefe."')) ";
             $proc.=" COLLATE latin1_swedish_ci  order by nome ";
             //
             $sqlcmd=$conex->query("$proc");
             if( ! $sqlcmd ) {
                  die("Falha no Select tabela chefe ".mysqli_error($_SESSION["conex"]));
             }
             //
             // Nr. do ultimo chefecodusp
             $regs=mysqli_num_rows($sqlcmd);
             if( intval($regs)>0 ) {
                  //
                  /**  Caso chefe encontrado na tabela chefe  */
                  $chefe=mysqli_result($sqlcmd,0,"chefecodusp");
                  //
             } else {
                 //
                 //  Incluir novo chefe na LISTA  
                 $proc="SELECT min(chefecodusp) as codigo_ult_chefe  ";
                 $proc.="  FROM  $bd_1.chefe where chefecodusp<0  ";
                 $result=$conex->query("$proc") ;
                 //                     
                 if( ! $result ) {
                     //
                     die("Falha no Select/min chefecodUSP".mysqli_error($conex));
                     //
                 }
                 //
                 // Nr do ultimo chefecodusp
                 $numregs=mysqli_num_rows($result);
                 if( intval($numregs)>0 ) {
                    $ultcod_chefe=mysqli_result($result,0,"codigo_ult_chefe");
                 }
                 // 
                 if( !isset($ultcod_chefe) ) {
                     $ultcod_chefe = -1;
                 } else {
                     $ultcod_chefe += -1;                
                 }
                 //
                 /**  Desativar variavel  */
                 if( isset($result) ) {
                      mysqli_free_result($result);  
                 } 
                 //
                 $chefecodusp = $ultcod_chefe;
                 $chefe=$chefecodusp;
                 //

/**                 
  echo "ERRO:  pessoal_cadastrar_ajax/1522 -->> \$chefecodusp = <b> $chefecodusp  </b>  <<--"
                   ."  <br>  -->> \$chefe =  <b> $chefe  </b>   \-->> \$novo_chefe =<span style='color:red;font-weight:bold;'>$novo_chefe</span> ";
  exit();                 
  */
    
                 //
                 //  Inserindo novo Chefe  
                 $n_erro=0;
                 /**
                 *    INSERIR O NOVO CHEFE
                 */
                 //  START a transaction - ex. procedure    
                 $commit="commit";
                 mysqli_query($_SESSION["conex"],'DELIMITER &&'); 
                 mysqli_query($_SESSION["conex"],'begin'); 
                 //
                 //      Execute the queries 
                 //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
                 //   - Use mysql_select_db() ou mysql_query()
                 //  mysql_query("LOCK TABLES $bd_1.chefe WRITE ");
                 mysqli_query($_SESSION["conex"],"LOCK TABLES $bd_1.chefe INSERT ");
                 $sqlcmd="INSERT into $bd_1.chefe (chefecodusp,nome) ";
                 $sqlcmd.=" values($chefecodusp,'$novo_chefe') ";
                 $success=$_SESSION["conex"]->query($sqlcmd); 
                 //
                 //  Complete the transaction 
                 if( mysqli_error($_SESSION["conex"]) ) {                            
                      //
                      // Ocorreu erro
                      $n_erro=1;
                      //  mysql_query('rollback'); 
                      $commit="rollback";
                      $txt="Inserindo dados na Tabela chefe - db/mysqli:&nbsp;";
                      echo $funcoes->mostra_msg_erro("$txt".mysqli_error($conex));
                      //
                 }
                 //              
                 /*!40000 ALTER TABLE  ENABLE KEYS */
                 mysqli_query($_SESSION["conex"],$commit);
                 mysqli_query($_SESSION["conex"],"UNLOCK  TABLES");
                 //  Complete the transaction 
                 mysqli_query($_SESSION["conex"],'end'); 
                 mysqli_query($_SESSION["conex"],'DELIMITER');
                 //
                 //  SLEEP - tempo de espera em segundos
                 sleep(1);
                 //
                 if( intval($n_erro)>0 ) {
                     //
                     $msg_erro .="Esse chefe &nbsp;".$novo_chefeHTML." n&atilde;o foi cadastrado.";
                     $msg_erro .=$msg_final;
                     echo $msg_erro;         
                     exit();    
                 } else {
                     //
                     // Confirmando cadastrado o novo chefe
                     $isqlcmd=$conex->query("SELECT * FROM $bd_1.chefe WHERE chefecodusp=$chefecodusp "); 
                     ///
                     if( ! $isqlcmd ) {
                         die("Falha no Select tabela chefe pesquisa cadastrado ".mysqli_error($conex));
                     }
                     /// Nr de Registros
                     $regronovochefe=mysqli_num_rows($isqlcmd);
                     ///     
                 }
                 /**  Final do INSERT novo CHEFE   */
                 //
             }
             //
             /**
             *   Corrigir array elemento novo_chefe para chefe
             */
             $campo_nome=explode(",",$campo_nome);
             $cnt_arcponome=count($campo_nome);
             $campo_value=explode(",",$campo_value);
             for( $nc=0;$nc<$cnt_arcponome; $nc++ )  {
                   if( strtoupper($campo_nome[$nc])=="NOVO_CHEFE" ) {
                         $campo_nome[$nc]="chefe";
                         $campo_value[$nc]=$chefe;          
                   }
                   //
             }
             /**  Final - for( $nc=0;$nc<$cnt_arcponome; $nc++ )  {  */
             //
             //  Caso houver excesso de elementos no array  $campo_value
             //  O mesmo volume de elementos dos dois arrays
             $campo_value = array_slice($campo_value, 0, $cnt_arcponome); 
             $campo_nome=implode(",",$campo_nome);
             $campo_value=implode(",",$campo_value);
             //                  
         }
         /**  Final - if( isset($novo_chefe) ) { */
         //
         //  SESSION abaixo para ser usada no INCLUDE - organiza dados com a Tabela
         $campo_nome = htmlentities(utf8_decode($campo_nome));
         $campo_value = htmlentities(utf8_decode($campo_value));
         $array_temp = explode(",",$campo_nome);
         $array_t_value = explode(",",$campo_value);
         $cntarrtmp = sizeof($array_temp);
         $_SESSION["tabela"]="pessoa"; $_SESSION["bd"]=$bd_1;    
         //     
         include("dados_pessoal_cadastro_ajax.php");  
         //
     } 
     /**  Final - if( ! isset($chefe) ) {  */
     //
     /**  IMPORTANTE - essa parte para configurar novamente as variaveis 
     *            $cpo_nome  e  $cpo_valor
     */
     /**  SESSION abaixo para ser usada no INCLUDE - organiza dados com a Tabela  */
         
     /**
     $campo_nome = htmlentities(utf8_decode($campo_nome));
     $campo_value = htmlentities(utf8_decode($campo_value));
     $array_temp = explode(",",$campo_nome);
     $array_t_value = explode(",",$campo_value);
     $cntarrtmp = sizeof($array_temp);
     $_SESSION["tabela"]="pessoa"; $_SESSION["bd"]=$bd_1;    
     */
     //     
     //  include("dados_pessoal_cadastro_ajax.php");  
     //
     //  INSERINDO NOVA PESSOA
     $n_erro=0;
     //
     //   IMPORTANTE: Converter  para  UFT-8 - PHP para MYSQL
     $cpo_valor=html_entity_decode($cpo_valor, ENT_QUOTES, "UTF-8");
         
         
/**
   echo "ERRO: LINHA/1625 -->> \$bd_1 = $bd_1  <<-->>  \$source = $source e \$val = $val //"
         ." <br>//  $regronovochefe <-- \$cpo_nome =  $campo_nome  \r\n  -->> \$campo_value =  $cpo_valor  "
         ." <br> /// \$nome = $nome  ".$arr_nome_val['nome']."  -->>  \$nomepessoa  = ".$nomepessoa;
   exit();        
 */
         
         
     //   
     //  Start a transaction - ex. procedure               
     mysqli_query($conex,'DELIMITER &&'); 
     mysqli_query($conex,'begin'); 
     /**  mysqli_query($conex,"LOCK TABLES $bd_1.pessoa WRITE ");  */
     mysqli_query($conex,"LOCK TABLES $bd_1.pessoa INSERT "); 
     //
     /** INSERIR PESSOA NA TABELA pessoa   */
     $proc="INSERT INTO $bd_1.pessoa  (".$cpo_nome.") values(".$cpo_valor.") ";
     //
     

/**
         $msg_erro .="<span style='font-size: large;padding:.8em 0 .8em 0;'>";
         $msg_erro .="$proc</span>".$msg_final;
         echo $msg_erro;         
exit();     
   */  
     
     $success=mysqli_query($conex,"{$proc}"); 
     //
     $terr="";
     if( mysqli_error($_SESSION["conex"]) ) $terr=mysqli_error($conex);
     //
     //  Complete the transaction 
     if( $success ) { 
         //
         /**  Confirmar inclusao  */
         mysqli_query($conex,'commit'); 
         // 
         $msg_ok .="<span style='font-size: large;padding:.8em 0 .8em 0;'>";
         $msg_ok .="$nomepessoa foi cadastrado.</span>".$msg_final;
         echo $msg_ok;
     } else {
         // 
         $n_erro=1;
         /** Cancelando inclusao  */
         mysqli_query($conex,'rollback'); 
         //
         $msg_erro .="<span style='font-size: large;padding:.8em 0 .8em 0;'>";
         $msg_erro .="$nomepessoa n&atilde;o foi cadastrado.</span><br>$terr<br>";
         $msg_erro .="$msg_final";
         echo $msg_erro;         
         //
     }
     // 
     mysqli_query($conex,"UNLOCK  TABLES");
     mysqli_query($conex,'end'); 
     mysqli_query($conex,'DELIMITER'); 
     //
          /**
           if( intval($n_erro)<1 ) {       
                ///   Incluir novo chefe na Tabela Pessoa
                if( isset($novo_chefe) ) {
                       ///  Start a transaction - ex. procedure               
                       mysql_query('DELIMITER &&'); 
                       mysql_query('begin'); 
                       mysql_query("LOCK TABLES $bd_1.pessoa WRITE ");
                       ///
                       $success=mysql_query("update $bd_1.pessoa set chefe=$chefecodusp  WHERE codigousp=$codigousp "); 
                       //  Complete the transaction 
                       if( $success ) { 
                           mysql_query('commit'); 
                       } else { 
                           mysql_query('rollback'); 
                           $msg_erro .="&nbsp;Chefe n&atilde;o foi cadastrado.".$msg_final;
                           echo $msg_erro;         
                       } 
                       mysql_query("UNLOCK  TABLES");
                       mysql_query('end'); 
                       mysql_query('DELIMITER'); 
                       ///
                }    
           } 
           */   
   //
}	 
/**   Final - if( $val_upper=="PESSOAL" ) {  */
//
#
ob_end_flush(); /* limpar o buffer */
#
?>