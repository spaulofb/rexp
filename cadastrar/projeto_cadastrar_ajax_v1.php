<?php
//
//   Arquivo para CADASTRAR  - AJAX
//
//    INICIANDO FUNCTIONS
//    Funcao para busca com acentos
if( ! function_exists("stringParaBusca") ) {
    //
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
        
        // Trocando espaços por .*
        $str = str_replace(" ",".*",$str);
        //
        // Retornando a String finalizada!
        return $str;
        //
    }
    /**  Final - function stringParaBusca($str) {  */
    //
}    
/**   Final - if( ! function_exists("stringParaBusca") ) {  */
//
//  Funcao para minuscula para Maiuscula  
if( ! function_exists("stringParaBusca2") ) {
    //
    function  stringParaBusca2($str) {
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
        //  $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
        $texto = preg_replace(array_keys($substituir),array_values($substituir),$str);
        /// 
        return $texto;
        // 
    }
    //
}    
///
/**  function_exists - verifica se a  function function NAO esta ativa  */
if( ! function_exists("ValidaData") ) {
     //
     // Verificando a Data 
     function ValidaData($dat) {
           //
            ///  Verificando formato da Data com barra
            if( preg_match("/\//",$dat) ) {
                 $data = explode("/","$dat"); ///  Divide  a string $dat em pedados, usando / como referência
            }
            ///  Verificando formato da Data com hifen
            if( preg_match("/\-/",$dat) ) {
                 $data = explode("-","$dat"); ///  Divide  a string $dat em pedados, usando - como referência
            }
            $res=1;  ///  1 = true (valida)
            $coluna1=$data[0];
            if( strlen($coluna1)<3 ) {
                $d = $data[0];
                $m = $data[1];
                $y = $data[2];
            } elseif( strlen($coluna1)==4 ) {
                $y = $data[0];
                $m = $data[1];
                $d = $data[2];
            }
            if( intval($y)>2100 ) $res=0;  ///  0 = false (vinalida)
            /*
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];
              */
           /// Veerifica se a data é válida!
            /// 1 = true (válida)
             /// 0 = false (inválida)
             //// if( intval($res)==1 )  $res = checkdate($m,$d,$y);
            if( intval($res)==1 ) {
                 $res = checkdate($m,$d,$y); 
            }  
            ///
            /*
               if( $res==1 ) {
                    echo "<br/>data ok! dia=$d - mes=$m - ano=$y ";
               } else {
                     echo "<br/>data inválida!";
               }
              */ 
            ////
            return $res;
     }
     /**  Final - function ValidaData($dat) { */
     //
}
/**  Final - if( ! function_exists("ValidaData") ) {  */
//  FINALIZANDO AS FUNCTIONS
//
//
//  INICIANDO  A PAGINA AJAX
ob_start();  /** Evitando warning */
//
//  Verificando se SESSION_START - ativado ou desativado
if(!isset($_SESSION)) {
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
///   Final - Mensagens para enviar 
///
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
// Verificando -  Conexao 
$elemento=5; $elemento2=6;
//// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     
//
//  require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
require_once("php_include/ajax/includes/tabela_pa.php");
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
//
//  DEFININDO A PASTA PRINCIPAL 
//  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
//  Verificando SESSION  pasta_raiz
if( ! isset($_SESSION["pasta_raiz"]) ) {
     $msg_erro .= "Sessão pasta_raiz não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
/**  Final - if( ! isset($_SESSION["pasta_raiz"]) ) {   */
//
//  Verificando SESSION  url_central - Alterado em 20180803
if( ! isset($_SESSION["url_central"]) ) {
     $msg_erro .= "Sessão url_central não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$raiz_central=$_SESSION["url_central"];
//
//  Conjunto de arrays 
// include_once("../includes/array_menu.php");
require_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    
//
//   Conjunto de Functions
//  require_once("../includes/functions.php");    
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");  
//
//  Definindo as variaveis
$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP    
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if ( isset($_POST[$xyz]) ) {
	    $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
	   if( $pos1===false ) {
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
/**   $source = utf8_decode($source); $val = utf8_decode($val);   */
if( strtoupper($val)=="SAIR" ) $source=$val;
//
$_SESSION["source"]=trim($source);
$source_upper=strtoupper($_SESSION["source"]);
//
$val_upper="";
if( isset($val) ) {
    if( is_string($val) ) {
          $val_upper=strtoupper(trim($val));
    }  
} 
//
//  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
//
//  Sair do Programa
if( $source_upper=="SAIR" ) {
    //
    ///  Eliminar todas as variaveis de sessions
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
/**
 *     Serve tanto para o arquivo projeto  quanto para o experimento
 *    if(  ( $source_upper=="COAUTORES" ) or  ( $source_upper=="COLABS" ) ) {	
 */
if( ( $source_upper=="CORESPONSAVEIS" ) or  ( $source_upper=="COLABS" ) ) {	
     //
     //  $m_co = "Co-responsáveis";
     // $m_co = "Co-resp.";
     $m_co = "Co-resp.";
     //  if( $source_upper=="COLABS" )    $m_co = "Colaboradores";
     if( $source_upper=="COLABS" ) $m_co = "Colab.";
     //
     //  Cod/Num_USP/Coautor
     $elemento=5;
     /**   Atrapalha e muito essa programacao orientada a objeto
     *    include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
     *   $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ");
     */
     /**  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");  */
     require_once("php_include/ajax/includes/conectar.php");
     //
     //  mysql_select_db($db_array[$elemento]); 
     //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
     //  
     //  Conexao MYSQLI
     $conex = $_SESSION["conex"];
     //
     //  mysql_query("SET NAMES 'utf8'");
     //  mysql_query('SET character_set_connection=utf8');
     //  mysql_query('SET character_set_client=utf8');
     //  mysql_query('SET character_set_results=utf8');
     //
     mysqli_set_charset($conex,'utf8');
     //   
     //  SELECT/MYSQLI 
     $proc="SELECT codigousp,nome,categoria FROM $bd_1.pessoa  order by nome ";                       
     $result=mysqli_query($_SESSION["conex"],"$proc");
     //
     if( ! $result ) {
         //
         // die('ERRO: Select pessoa - falha: '.mysql_error());  
         $terr="Select tabela pessoa falha&nbsp;-&nbsp;db/mysqli:&nbsp;";
         echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex));
         exit();   
     }
     //
     // Numero de registros
     $m_linhas = mysqli_num_rows($result);
     //

/**  
    echo "ERRO: projeto_cadastrar_ajax/459  -->> SEGUE   \$m_linhas = {$m_linhas}  ";
    exit();
 */


     //  
     if( intval($m_linhas)<1 ) {
         echo "Nenhum encontrado";
         exit();      
     }
     /**  Final - if( intval($m_linhas)<1 ) {  */
     //
     // Definindo alguns campos
     while( $linha=mysqli_fetch_assoc($result) ) {
           //
           $arr["codigousp"][]=htmlentities($linha['codigousp']);
           $arr["nome"][]=  ucfirst(htmlentities($linha['nome']));
           $arr["categoria"][]=$linha['categoria'];
           //
     }
     /**  Final - while( $linha=mysqli_fetch_assoc($result) ) {  */
     //
     $count_arr = count($arr["codigousp"])-1;	 
     $x_float2 = (float) (.5);  $acrescentou=0;
     $n_tr = (float) ($val/2);
     if( ! is_int($n_tr) ) {
          $n_tr=$n_tr+$x_float2;
          $acrescentou=1;
     }
     /**  Final - if( ! is_int($n_tr) ) {  */
     //
     //  $n_y=0;$texto=0; $n_tr= (int) $val;
     $n_y=0;$texto=0; $n_tr= (int) $n_tr;
     for( $x=1; $x<=$n_tr; $x++ ) {
          //
          $n_y=$texto; $n_td=4;
          ///  if( $n_tr==1 ) $n_td=2;
          /// $n_td=2;
          $n_tot=$n_td/2;
          for( $y=1; $y<=$n_tot; $y++ ) {
               //
               $texto=$n_y+$y;
               if( ( $acrescentou==1 ) and  ( $texto>$val ) ) {
                    ////  echo "<td class='td_inicio1' >&nbsp;</td>"; 
                    continue;
               }
               //
               $n_tot2=1;
               for( $z=1; $z<=$n_tot2 ; $z++ ) {
                    //
                ?>
                   <article class="projetoarticle3" >
                      <label for="ncoautor[<?php echo $texto;?>]"  >&nbsp;<?php echo "$m_co $texto";?>:</label>
                      <span>
                        <!-- N. Funcional USP - COautor ou Colaborador  -->
                       <select name="ncoautor[<?php echo $texto;?>]" id="ncoautor[<?php echo $texto;?>]"  class="td_select" 
                               style="overflow:auto;font-size: small;"  title="<?php echo "$m_co $texto"; ?>"  >  
                     <?php
                        //
                        if( intval($m_linhas)<1 ) {
                             echo "<option value='' >== Nenhum encontrado ==</option>";
                        } else {
                             //
                             echo "<option value='' >== Selecionar ==</option>";
                            /// for ( $jk=0 ; $jk<$m_linhas ; $jk++) {
                            for( $jk=0; $jk<=$count_arr; $jk++ ) {
                                 //
					             // $m_codigousp = htmlentities($arr["codigousp"][$jk]);
                                 $m_codigousp = htmlentities($arr["codigousp"][$jk]);
                                 $m_categoria=$arr["categoria"][$jk];
				                 $m_categ = "Categ.: ".html_entity_decode(utf8_decode($m_categoria));	
                                 //
                                 //  $m_nome=ucfirst(htmlentities($arr["nome"][$jk]));		   		   
                                 //  $m_nome=ucfirst(html_entity_decode($arr["nome"][$jk]));  
                                 $m_nome=trim($arr["nome"][$jk]);
                                 /**  IMPORTANTE: comando para para converter acentos 
                                 *        html_entity_decode(utf8_decode($m_nome))
                                 */
                                 echo "<option  value=".$m_codigousp." >".html_entity_decode(utf8_decode($m_nome));
                                 echo  "&nbsp;-&nbsp;".$m_categ."&nbsp;</option>" ;
                                 ///
                            }
                            /**  Final - for( $jk=0; $jk<=$count_arr; $jk++ ) {  */
                            //
                      ?>
                      </select>
                      <?php
                      }
                      /// Final da Num_USP/Coautor
                      //
                      ?>  
                   </span>
                   </article>
                      <?php                      
                  }
                  /**  Final - for( $z=1; $z<=$n_tot2 ; $z++ ) {  */
                  //
          }
          /**  Final - for( $y=1; $y<=$n_tot; $y++ ) {  */
          //
     } 
     /**  Final - for( $x=1; $x<=$n_tr; $x++ ) {  */           
     //
     exit();
     //
}   
/**  FINAL do IF  $source_upper=="CORESPONSAVEIS"  or   $source_upper=="COLABS"   */
//
//  Cadastrar um PROJETO  
if( $val_upper=="PROJETO" ) {    
     /**     
     *    AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
     *    e de depois usa o  - html_entity_decode 
    */

//  $nocego="ERRO: linha582  ";

     $campo_nome = htmlentities(utf8_decode($campo_nome));
     //

 //   $nocego.=" 1)  \$campo_nome = $campo_nome <br> \$campo_value = $campo_value <br>";

     /**  
      *    $campo_value = htmlentities(utf8_decode($campo_value));
     *   Procurar palavra enviar
      */
     $busca=stripos($campo_nome,",enviar");
     //
     /**  Array nome dos campos  */
     $array_temp = explode(",",$campo_nome);
     //
     /**  Array valor dos campos  */
     $array_t_value = explode(",",$campo_value);
     //
     if( $busca !== false) {
         //
         /** Procurando elemento no Array de Nomes  */
         $buscaelm="enviar";
         $chaveEncontrada = array_search($buscaelm,$array_temp);
         //
         /**   Remove os elementos do índice de corte até o final do array  */  
         $arrayFiltrado1 = array_splice($array_temp, 0, $chaveEncontrada);
         //
         /**
          *   Encontrado remover o último elemento dos Arrays
         */
         /**   echo "A substring '$busca' (case-insensitive) foi encontrada na posição: " . $posicao;  */ 
         //
         // Atualiza variavel $campo_nome
         $campo_nome = implode(",",$arrayFiltrado1);
         //
         /**  Array nome dos campos  */
         unset($array_temp);
         $array_temp = explode(",",$campo_nome);
         //
         //
         // Remove os elementos do índice de corte até o final do array
         $arrayFiltrado2 = array_splice($array_t_value, 0, $chaveEncontrada);
         //
         // Atualiza variavel $campo_value
         $campo_value = implode(",",$arrayFiltrado2);
         /**  Array valor dos campos  */
         unset($array_t_value);
         $array_t_value = explode(",",$campo_value);
         //
     }  
     /**  Final - if( $busca !== false) {  */
     //

     /**  
      *   $nocego.="-->> 2)  \$campo_nome = $campo_nome <br> \$campo_value = $campo_value <br>";
      *      echo  "{$nocego}";
      *      exit();
      */
     //    $campo_nome = substr($campo_nome,0,$busca);   
     //
     //  Nr. de elementos dos Arrays      
     $lennmcps=count($array_temp);
     // 
     $lenvalcps=count($array_t_value);
     //

/**  
echo  "ERRO: linha598  -->>  \$busca = $busca  -->> \$lennmcps = $lennmcps -->> \$lenvalcps = $lenvalcps  ";
exit();
 */


     /**  Nr. de elementos do Array - Nomes campos  */
     $count_array_temp = sizeof($array_temp);
     //
     for( $i=0; $i<$count_array_temp; $i++ ) {
          $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];  
     } 
     //
     //   Vericando se o Nome se ja esta cadastrado  na Tabela usuario
     /**   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim  */
     $m_titulo=strtoupper(trim($arr_nome_val['titulo']));
     $fonterec=strtoupper(trim($arr_nome_val['fonterec']));    
     $fonteprojid=strtoupper(trim($arr_nome_val['fonteprojid']));    
     $m_autor=strtoupper(trim($arr_nome_val['autor']));
     $_SESSION["numprojeto"]=strtoupper(trim($arr_nome_val['numprojeto']));
     //
     //   MELHOR JEITO PRA ACERTAR O CAMPO NOME
     /**    function para caracteres com acentos passando para Maiusculas  */ 
     //  '/&aacute;/i' => 'Á',
     //  $m_texto=strtoupper($pessoa_nome);
     $m_titulo = stringParaBusca2($m_titulo);
     $fonterec = stringParaBusca2($fonterec);    
     $m_autor=stringParaBusca2($m_autor);
     $m_titulo =html_entity_decode(trim($m_titulo));
     $fonterec =html_entity_decode(trim($fonterec));
     $fonteprojid=strtoupper(trim($arr_nome_val['fonteprojid']));    
     $m_autor =html_entity_decode(trim($m_autor));
     //
     /**  Corrigir onde tiver strtotime - usado somente para ingles     */
     $data_de_hoje = date('d/m/Y');
     $data_de_hoje = explode('/',$data_de_hoje);
     $time_atual = mktime(0, 0, 0,$data_de_hoje[1], $data_de_hoje[0], $data_de_hoje[2]);
     //
     // Usa a função criada e pega o timestamp das duas datas:
     $time_inicial="";
     $m_datainicio=""; 
     $m_datafinal="";
     if( isset($arr_nome_val["datainicio"]) ) {
           //
          if( strlen(trim($arr_nome_val["datainicio"]))>5 ) {
              //
              /// Divide a string $datainicio em pedados, usando / como referência
              ///    $dt_inicio = explode('/',$arr_nome_val["datainicio"]);
   
              ///  $time_inicial = mktime(0, 0, 0,$dt_inicio[1], $dt_inicio[0], $dt_inicio[2]);            
              $m_datainicio=trim($arr_nome_val['datainicio']);
              /// Veerifica se a data é válida!
              ///  1 = true (válida)
              //   0 = false (inválida)
              $res=1;
              if( preg_match("/\//",$m_datainicio)  ) {
                    $n_barra=substr_count($m_datainicio,"/");
                    $m_datainicio=preg_replace('/\//','-',$m_datainicio);
                    if( intval($n_barra)<>2  ) $res=0;
              } 
              ///            
              //  sleep(3);
              //
              if( preg_match("/\-/",$m_datainicio)  ) { 
                    $n_hifen=substr_count($m_datainicio,"-");
                    if( intval($n_hifen)<>2 ) $res=0;  
              } 
              //   
              /** Caso NAO ocorreu erroa acima executar function  */
              if( intval($res)==1 ) $res=ValidaData($m_datainicio);
              //
              ///  Verificando formato da Data com barra
              ///  Ocorreu ERRO
              if( intval($res)<1 ) {
                   //
                   $msg_erro .= "Data inicial inv&aacute;lida  ";
                   $msg_erro .= $arr_nome_val["datainicio"].$msg_final;
                   echo $msg_erro;
                   exit();   
              }
              /**  Final - if( intval($res)<1 ) {  */
              //
          }
          /**  Final - if( strlen(trim($arr_nome_val["datainicio"]))>5 ) {  */
          //
          // IF abaixo Correto
          $nanv= (int) strlen(trim($arr_nome_val["datainicio"]));
          if( intval($nanv)>=1 and intval($nanv)<6 ) { 
                //
                $msg_erro .= "Data inicial inv&aacute;lida  ";
                $msg_erro .= $arr_nome_val["datainicio"].$msg_final;
                echo $msg_erro;
                exit();   
          } 
          /**  Final - if( $nanv>=1 and $nanv<6 ) {   */
          //       
     }
     /**  Final - if( isset($arr_nome_val["datainicio"]) ) {  */
     //


/**  
     $sumx = count($array_t_value);
     echo "ERRO: LINHA/703  -->> \$campo_nome = $campo_nome <<--  "
          ."<br>    -->> \$campo_value = $campo_value   <br> -->> SESSION[numprojeto] = {$_SESSION["numprojeto"]}  "
          ."  -->>  \$count_array_temp = $count_array_temp  -->> \$sumx = $sumx -->> ERRO:";

     exit();
 */


     ////
     $m_final="";
     if( isset($arr_nome_val["datafinal"]) ) {     
         //
         /** Converter Data PHP para Mysql   */
         if( strlen(trim($arr_nome_val['datafinal']))>5 ) {
              //
              //  $m_final=$arr_nome_val['datafinal'];
              // Divide a string $datainicio em pedados, usando / como referência
              //  $m_final=explode('/',$arr_nome_val["datafinal"]);
              $m_datafinal=trim($arr_nome_val['datafinal']);
              //
              // Veerifica se a data é válida!
              //  1 = true (válida)
              //   0 = false (inválida)
              $res=1;
              if( preg_match("/\//",$m_datafinal)  ) {
                    //
                    $n_barra=substr_count($m_datafinal,"/");
                    $m_datafinal=preg_replace('/\//','-',$m_datafinal);
                    if( intval($n_barra)<>2  ) $res=0;
                    //
              } 
              /**  Final - if( preg_match("/\//",$m_datafinal)  ) {  */
              //            
              //  sleep(3);
              //
              if( preg_match("/\-/",$m_datafinal)  ) { 
                   $n_hifen=substr_count($m_datafinal,"-");
                   if( intval($n_hifen)<>2 ) $res=0;  
              }
              //    
              // Caso NAO ocorreu erro acima executar function
              if( intval($res)==1 ) $res=ValidaData($m_datafinal);
              //
              //  Verificando formato da Data com barra
              //  Ocorreu ERRO
              if( intval($res)<1 ) {
                    $msg_erro .= "Data final inv&aacute;lida  ";
                    $msg_erro .= $arr_nome_val['datafinal'].$msg_final;
                    echo $msg_erro;
                    exit();   
              }
              /**  Final - if( intval($res)<1 ) {  */
              //    
          }
          /**  Final - if( strlen(trim($arr_nome_val['datafinal']))>5 ) {  */
          //
          //// IF abaixo Correto
          $znx=strlen(trim($arr_nome_val["datafinal"]));
          if( intval($znx)>=1 and intval($znx)<6 ) { 
               $msg_erro .= "Data final inv&aacute;lida  ".$arr_nome_val["datafinal"].$msg_final;
               echo $msg_erro;
               exit();   
          }                  
          /**  Final - if( $znx>=1 and $znx<6 ) {   */
          //
     }
     /**   Final - if( isset($arr_nome_val["datafinal"]) ) { */
     //
     //  $time_final = geraTimestamp($data_final);
     /// $dt_atual= strtotime($data_de_hoje);
     ///  $dt_inicio= strtotime($arr_nome_val["datainicio"]);
     ///  Variavel para incluir na Tabela anotador no campo PA
     $lnpa = $_SESSION["permit_pa"];
     //


/**  
     $sumx = count($array_t_value);
     echo "ERRO: LINHA/783  -->> \$lnpa = $lnpa <br> \$campo_nome = $campo_nome <<--  "
          ."<br>    -->> \$campo_value = $campo_value   <br> -->> SESSION[numprojeto] = {$_SESSION["numprojeto"]}  "
          ."  -->>  \$count_array_temp = $count_array_temp  -->> \$sumx = $sumx -->> ERRO:";

     exit();
 */



     //  Verificando campos 
     /**   coresponsaveis para incluir na Tabela corespproj  */ 
     $m_erro=0;
     if( isset($arr_nome_val["coresponsaveis"]) ) {
         //
         $coresponsaveis =$arr_nome_val["coresponsaveis"];  
         if(  intval($coresponsaveis)>=1 ) {
             //
             /**  COnvertendo String em um Array   */
             if( isset($m_array) ) {
                 //
                 $n_coresponsaveis=explode(",",$m_array);   
                 $count_coresp = count($n_coresponsaveis);
                 for( $z=0; $z<$count_coresp ; $z++ ) {
                      //
                      if( strlen($n_coresponsaveis[$z])<1 ) {
                           $m_erro=1;
                           break;
                      }
                      // 
                 }      
                 //
             } else {
                $m_erro=1;
             }
             //
         }
         /**  Final - if( $coresponsaveis>=1 ) {  */
         //
         if( intval($m_erro)==1 ) {
              //
              $msg_erro .= "&nbsp;Falta incluir co-respons&aacute;vel.".$msg_final;
              echo $msg_erro;
              exit();
              //
         }      
         /**  Final - if( $m_erro==1 ) {  */
         //
     }
     /**  Final - if( isset($arr_nome_val["coresponsaveis"]) ) {  */
     //    

/**  
echo "ERRO: LINHA863  -->>  \$count_coresp = $count_coresp  ";
exit();
 */


     //
     $elemento=5; $elemento2=6; $m_regs=0;
     /**  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");  */
     require_once("php_include/ajax/includes/conectar.php");
     //
     //  Conexao MYSQLI
     $conex = $_SESSION["conex"];
     //
     //**  Verificando se foi digitado o campo com a Data inicio do Projeto  */
     if( ! isset($m_datainicio) ) {
         //
         // $m_datainicio="--";
         $m_datainicio="0000-00-00";
     } else {
         if( strlen(trim($m_datainicio))<10 ) {
            ///  $m_datainicio="--";
            $m_datainicio="0000-00-00";
         }
         //
     }
     //
     $objetivo = $arr_nome_val["objetivo"];
     //



/**  
     $sumx = count($array_t_value);
     echo "ERRO: LINHA828  -->> \$objetivo = $objetivo  -- \$lnpa = $lnpa <br>"
          ."  \$campo_nome = $campo_nome <<--  "
          ."<br>    -->> \$campo_value = $campo_value   <br>"
          ."  \$count_coresp = $count_coresp  -->> SESSION[numprojeto] = {$_SESSION["numprojeto"]}  "
          ."  -->>  \$count_array_temp = $count_array_temp  -->> \$sumx = $sumx -->> ERRO:";

     exit();
 */



     /** 
     *    Verificando duplicata Projeto 
     *    os campos (objetivo, fonterec, fonteprojid, autor e m_datainicio) 
     */  
     $proc="SELECT  cip,autor,titulo as titulo_outro, numprojeto as projeto_outro  "; 
     $proc.=" FROM $bd_2.projeto WHERE ";
     $proc.=" objetivo={$objetivo}  and  ";
     $proc.=" trim(fonterec)=trim('".$fonterec."')  and  ";
     $proc.=" trim(fonteprojid)=trim('".$fonteprojid."') and ";
     $proc.="  autor=".$m_autor." and datainicio='$m_datainicio'  ";
     $result=$conex->query("$proc");
     //                 
     // Verificando se houve erro no Select Tabdla Usuario
     if( ! $result ) {
          //
         $msg_erro .= "Select Tabela projeto - Falha: ";
         $msg_erro .= mysqli_error($conex).$msg_final;
         echo $msg_erro;
         exit();
    }  
    ///  Nr. de registros    
    $m_regs=mysqli_num_rows($result);
    //
    

/**  
  echo "ERRO: LINHA819  -->> \$m_regs = $m_regs  <<-->>  \$objetivo = $objetivo  <<-- <BR>"
              ." -->  \$m_datainicio = $m_datainicio  --   \$m_datafinal = $m_datafinal ";
  exit();        
 */
    
    
    //
    /**   Verificando se encontrou DUPLICATAS  */
    if( intval($m_regs)>=1 ) {
        //
        $outro_titulo=mysqli_result($result,0,"titulo_outro");
        $projeto_outro=mysqli_result($result,0,"projeto_outro");
        //
        /**  Desativando variavel  */
        if( isset($result) ) {
            //  mysqli_free_result($result);  
             unset($result);  
        } 
        /**  Final - if( isset($result) ) { */
        //
        /**  Select/MYSQLI  */
        $proc="SELECT  descricao FROM $bd_2.objetivo WHERE  codigo={$objetivo}  ";
        $result=mysqli_query($_SESSION["conex"],"$proc");
        //                 
        // Verificando se houve erro no Select Tabdla Usuario
        if( ! $result ) {
            /**
            *   $msg_erro .= "Select tabela objetivo - falha: ".mysql_error().$msg_final;
            *   echo $msg_erro;
            */
            $proc="Select tabela objetivo falha&nbsp;-&nbsp;db/mysqli:&nbsp;";
            echo $funcoes->mostra_msg_erro("$proc".mysqli_error($_SESSION["conex"]));
            exit();            
        }
        /**  Final - if( ! $result ) {  */
        //  
        $descricao=mysqli_result($result,0,"descricao");
        //
        ///   Caso existe outro projeto com os mesmos dados
        $msg_erro .= "&nbsp;Existe outro Projeto&nbsp;nr.&nbsp;{$projeto_outro}&nbsp;<br>"
                       ."com esse T&iacute;tulo:&nbsp;{$outro_titulo}<br>"
                       ."j&aacute; est&aacute; cadastrado com esses dados&nbsp;";
        $msg_erro .= "(Autor, Objetivo, Fonte, Nr. Processo, Data In&iacute;cio).".$msg_final;
        echo $msg_erro;
        //
        exit();
        //
     } else {
         //
         //  Continuacao Tabela projeto - BD PESSOAL
         /**   MELHOR jeito de acertar a acentuacao - html_entity_decode    */    
         //  Caso tenha coautores/coresponsaveis no Projeto
         //  include("n_cos.php");
         require_once("n_cos.php");
         //
         //  SESSION abaixo para ser usada no include
         $_SESSION["tabela"]="$bd_2.projeto";
         //
         /**    Arquivo importante codificar dados  
         *   Atualizado em 20250516
         *   include("dados_recebidos_arq_ajax.php"); 
         */
         //
         /**    Arquivo importante codificar dados  
         *   Atualizado em 20250516
         *   include("dados_recebidos_arq_ajax.php"); 
         */

//  $_SESSION["xres"]="ERRO: passou -->>  ";

         //  include("dds_rcbs_arq_ajax_proj.php");
         require_once("dds_rcbs_arq_ajax_proj.php");
         //
         /**          INSERIR USUARIO  
         *     mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
         */
         ///
         $proc="SELECT codigousp FROM $bd_1.usuario WHERE codigousp=$m_autor ";
         $result_usu = mysqli_query($_SESSION["conex"],"$proc");
         //
         /** Verificando se houve erro no Select Tabdla Usuario  */
          if( ! $result_usu ) {
              $terr="&nbsp; Select Tabela usuario  -&nbsp;db/mysqli:&nbsp;";
              $msg_erro .= "$terr".mysqli_error($_SESSION["conex"]).$msg_final;
              echo $msg_erro;
              exit();
          }
          //
          /// Numero de registros  
          $m_regs = mysqli_num_rows($result_usu); 
          //

          
/**  
         $sumx = count($array_t_value);
     echo "ERRO: LINHA993  -->> VER ROTINAS PODE SER <<-- CONTINUAR "
        ." <br> \$bd_2 = $bd_2  <<-- <br> -->>  \$cpo_nome = $cpo_nome <<--  "
          ."<br>    -->> \$cpo_valor = $cpo_valor   <br> -->> SESSION[numprojeto] = {$_SESSION["numprojeto"]}  "
          ."  -->>  \$count_array_temp = $count_array_temp  -->> \$sumx = $sumx <br>"
          ."  -->>  \$array_temp = count </b> ".count($array_temp)." -->>   \$count_coresp = $count_coresp  "           
          ."<br> \$arr_nome_val[coresponsaveis] = {$arr_nome_val["coresponsaveis"]} ";
     exit();
 */


          //
          //  Verficando Orientador
          if( intval($m_regs)<1 ) { 
              $msg_erro .= "Orientador n&atilde;o cadastrado.".$msg_final;
              echo $msg_erro;
          } else {
              //
              if( isset($_SESSION["numprojeto"]) ) {
                   $numprojeto=$_SESSION["numprojeto"];  
              } 
              //
              $n_erro=0;
              ///           
              //   mysqli_query($_SESSION["conex"],"SET NAMES 'utf8'");
              //   mysql_query('SET character_set_connection=utf8');
              //   mysql_query('SET character_set_client=utf8');
              //   mysql_query('SET character_set_results=utf8');
              //
              mysqli_set_charset($conex,'utf8');
              //   
              $campos_nome=$_SESSION["campos_nome"];
              ///  $campos_valor=utf8_decode($_SESSION["campos_valor"]);
              /**  IMPORTANTE:  html_entity_decode para variavel PHP para MySql  */
              $campos_valor=html_entity_decode($_SESSION["campos_valor"], ENT_QUOTES, "UTF-8");
              //
              //   $campos_valor=$_SESSION["campos_valor"];
              //
              //  Execute the queries 
              //  mysql_select_db($db_array[$elemento]);
              $conex->select_db($db_array[$elemento]);
              //
              
/**  
  echo "ERRO: LINHA902  -->> \$m_regs = $m_regs  <<-->>  VER  \$objetivo = $objetivo  <<-- "
       ."  <br>  \$m_datainicio = $m_datainicio  --    \$m_datafinal = $m_datafinal -->>  ".$db_array[$elemento]."<<--***";
  exit();        
   */

              
              
              //  START a transaction - ex. procedure    
              mysqli_query($_SESSION["conex"],'DELIMITER &&'); 
              mysqli_query($_SESSION["conex"],'begin'); 
              //
              //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
              //   - Use mysql_select_db() ou mysql_query()
              $_SESSION["conex"]->query("LOCK TABLES $bd_2.projeto WRITE, $bd_2.corespproj WRITE ");
              //
              /**  IMPORTANTE: usar utf8_encode enviar dados do PHP para MySql  */
           /**   $sqlcmd="INSERT into $bd_2.projeto  (".$campos_nome.") values(".utf8_encode($campos_valor).") ";  
            *    $sqlcmd="INSERT into $bd_2.projeto  (\"$campos_nome\") values(\"$campos_valor\") "; 
           */
               $sqlcmd="INSERT into $bd_2.projeto  (".$cpo_nome.") values(".$cpo_valor.") ";
              //
              //  $sqlcmd="INSERT into $bd_2.projeto  ($campos_nome) values($campos_valor) ";
              $success=mysqli_query($_SESSION["conex"],$sqlcmd); 
              //
              //  Complete the transaction 
              if( $success ) { 
                  //
                  /**   Cadastrando na tabela corespproj os coresponsaveis    */
                  //  
                  if( isset($count_coresp) ) {
                      //
                      if( intval($count_coresp)>=1  ) {
                            //
                            //
                            for( $x=0; $x<$count_coresp;  $x++ ) {
                                 //
                                 $ncod_resp=$n_coresponsaveis[$x];
                                 $proc="INSERT into $bd_2.corespproj values(".$m_autor.", ".$numprojeto.", ".$ncod_resp.")";
                                 $result=mysqli_query($_SESSION["conex"],"$proc");
                                 if( !$result ) {
                                      //
                                      $n_erro=1; 
                                      $xcrsp=0;
                                      if( isset($n_coresponsaveis[$x]) ) {
                                          $xcrsp = $n_coresponsaveis[$x];
                                      }
                                      $proc="&nbsp;CORESP. n&atilde;o foi cadastrado (autor/projeto/coresp):";
                                      $msg_erro .="$proc".$m_autor.", ".$_SESSION["numprojeto"].", ";
                                      $msg_erro .="$xcrsp".mysqli_error($_SESSION["conex"]).$msg_final;
                                      //
                                      //  Cancelar inclusao
                                      mysqli_query($_SESSION["conex"],'rollback'); 
                                      echo  $msg_erro;
                                      //
                                }
                                //
                           }  
                           /**  Final - for( $x=0; $x<$count_coresp;  $x++ ) {  */
                           //
                      } 
                      /**  Final - if( intval($count_coresp)>=1  ) {  */                          
                      // 
                  }
                  /**  Final - if( isset($count_coresp) ) {  */
                  //
                  /**  Caso NAO houve ERRO  */
                  if( intval($n_erro)<1 ) {
                      ///  Permitir inclusao
                      mysqli_query($_SESSION["conex"],'commit');                                  
                  }
                  //
              } else {
                 //
                 $n_erro=1;
                 //  Cancelar inclusao
                 mysqli_query($_SESSION["conex"],'rollback'); 
              }
              //              
              mysqli_query($_SESSION["conex"],"UNLOCK  TABLES");
              mysqli_query($_SESSION["conex"],'end'); 
              mysqli_query($_SESSION["conex"],'DELIMITER');
              ///
              if( intval($n_erro)==1 ) {
                  $proc="&nbsp;Projeto <b>N&Atilde;O</b> foi cadastrado. ERRO#1 = ";
                  $msg_erro .="$proc".mysqli_error($_SESSION["conex"]).$msg_final;
                  echo $msg_erro;               
              } else {
                  //
                  //  IINCLUINDO arquivo para a Anotacao do Projeto 
                  //  projeto, autor/orientador e numero da anotacao
                  $m_regs=0;
                  //
                  //  Select/Mysqli
                  $proc="SELECT  cip,autor,numprojeto FROM $bd_2.projeto WHERE ";
                  $proc.=" autor=$m_autor and numprojeto=$numprojeto  ";                               
                  $result_proj=mysqli_query($_SESSION["conex"],"$proc");
                  ///               
                  if( ! $result_proj  ) {
                      $proc="&nbsp; Select Tabela projeto  -&nbsp;db/mysqli:&nbsp;";
                      $msg_erro .= "$proc".mysqli_error($_SESSION["conex"]).$msg_final;
                      echo $msg_erro;
                      exit();
                      //
                  }
                  //                                    
                  ///  Nr. de registros               
                  $m_regs=mysqli_num_rows($result_proj);
                  ///
                  if( intval($m_regs)==1 ) {
                      //
                       $projeto_cip=mysqli_result($result_proj,0,"cip");       
                       //
                       if( isset($result_proj) ) {
                            mysqli_free_result($result_proj);  
                       } 
                       //
                       ///  Variavel para a data e hora atual                       
                       $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario  
                       //
                       ///  START a transaction - ex. procedure    
                       mysqli_query($_SESSION["conex"],'DELIMITER &&'); 
                       mysqli_query($_SESSION["conex"],'begin'); 
                       //
                       //  Execute the queries 
                       mysqli_query($_SESSION["conex"],"LOCK TABLES $bd_2.anotador WRITE ");
                       //
                       $sqlcmd="INSERT into $bd_2.anotador (cip,codigo,pa,data) ";
                       $sqlcmd.=" values($projeto_cip,$m_autor,$lnpa,'$data_atual')"; 
                       $res_anotador=mysqli_query($_SESSION["conex"],$sqlcmd); 
                       //
                       if( $res_anotador ) {
                           //
                           mysqli_query($_SESSION["conex"],'commit');       
                           //
                           /**   Enviando a mensagem para depois Incluir o relatorio em formato PDF   */
                           // 
                           $msg_ok .="<p class=\"titulo_usp\" >";
                           $msg_ok .="&nbsp;Para concluir o Projeto.<br/>Enviar o arquivo em formato PDF.</p>".$msg_final;
                           $msg_ok .="falta_arquivo_pdf".$numprojeto."&".$m_autor;
                           echo $msg_ok;
                           //
                       } else {
                           //
                           /**  Ocorreu ERRO  */
                           //
                           mysqli_query($_SESSION["conex"],'rollback');                             
                           //
                           $msg_erro .="&nbsp;Anotador <b>N&Atilde;O</b> foi cadastrado.";
                           $msg_erro .= mysqli_error($_SESSION["conex"]).$msg_final;
                           echo $msg_erro;                                   
                           //
                       }                   
                       //
                       mysqli_query($_SESSION["conex"],"UNLOCK  TABLES");
                       mysqli_query($_SESSION["conex"],'end'); 
                       mysqli_query($_SESSION["conex"],'DELIMITER');
                       ///
                  } else {
                      //
                      /**  Ocorreu ERRO  */
                      $terr="&nbsp;Projeto <b>N&Atilde;O</b> encontrado.";
                      $msg_erro .="$terr".mysqli_error($_SESSION["conex"]).$msg_final;
                      echo $msg_erro;                                   
                      //
                  }
                  //
              }
              ///  FINAL -  TABELA PROJETO  -  BD  REXP
              //
          }
          //                     
     }
     ///
}  
/**  Final - if( $val_upper=="PROJETO" ) {    */
///  
ob_end_flush(); /* limpar o buffer */
///
?>