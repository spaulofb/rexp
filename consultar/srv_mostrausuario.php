<?php
//  AJAX da opcao CONSULTAR  - Servidor PHP para mostrar Usuário
//
//  LAFB110831.1740
#
ob_start(); /* Evitando warning */
//
//  Verificando se session_start - ativado ou desativado
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
//  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
// Final - Mensagens para enviar
//
//  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     ///  $msg_erro .= utf8_decode("Sessão incluir_arq não está ativa.").$msg_final;  
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
//
/**
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
*/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");
//
//  Conexao MYSQLI
$conex = $_SESSION["conex"];
//
$opcao = $_POST['grupous'];
//
/**   Conectar - atualizado em 20250528  */ 
$elemento=6; $elemento2=5;
include("php_include/ajax/includes/conectar.php");   
//

/**  
echo "ERRO: srv_mostrausuario/77  -->> NOVO -->>  \$bd_1 = $bd_1  <<-->>   \$bd_2 = $bd_2  <br />\n";
exit();
 */



//  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
//      
//  Variavel com letras maiusculas      
$opcao_maiusc = strtoupper(trim($opcao));
//
//  Arquivo da tabela de consulta usuario - importante
$arq_tab_consulta_usuario="{$incluir_arq}includes/tabela_de_consulta_usuarios.php"; 
//
if( isset($opcao) ) {
    $opcao = trim($opcao);
    $opcaoup= strtoupper($opcao);
} else {
    $opcao = "";
}
//


/**
echo "ERRO: srv_mostrausuario/105  -->> \$opcaoup = $opcaoup  <<-->>  \$val = $val   -->>  \$bd_1 = $bd_1  -->>  \$bd_2 = $bd_2  <br />\n";
exit();
 */



// Vericando - caso Variavel opcao  NAO for LISTA
if( $opcaoup!='LISTA' ) {
   //
   /**  Remover Tabela Temporaria   
    * $_SESSION["table_temporaria"] = $bd_2.".temp_consultar_usuario"; 
   */
   $_SESSION["table_temporaria"] = "$bd_2.temp_consultar_usuario";
   $table_temporaria = $_SESSION["table_temporaria"];
   $sql_temp = "DROP TABLE IF EXISTS  {$table_temporaria} ";
   $result_usuarios=mysqli_query($_SESSION["conex"],$sql_temp);
   if( ! $result_usuarios ) {
        die('ERRO: '.mysqli_error($_SESSION["conex"]));  
   }   
   //
   //  Caso for uma letra somente
   $dados=trim($val);
   $parte_login="";
   //
   //  Variavel alfabetica
   if( ctype_alpha($dados) ) {
       //
       /** if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) ) { */ 
       if( ! preg_match("/tod(a|o)s?|ordenar/ui",$dados) ) {
            //
            /**   Caso tenha escolhido uma Letra do Login/Usuario por EMAIL  */
            if( strlen($dados)>1) {
                 //
                 // $letra_login=" upper(a.login) like '$letra%'  and  ";
                 // $letra_login=" upper(b.e_mail) like '$letra%'  and  ";
                 $email=trim($opcao);
                 $parte_login=" b.e_mail='$email'  and  ";
                 //
            }
            /**  Final - if( strlen($dados)>1) { */
            //      
            /**   Caso tenha escolhido uma Letra do Login/Usuario  */
            if( strlen($dados)==1) {
                //
                if( strlen($dados)==1 ) {
                    //
                    $letra="$dados";
                } elseif( strlen($opcao)==1 ) {
                    $letra=trim($opcao);  
                }
                //    
                $parte_login=" upper(b.nome) like '$letra%'  and  "; 
                //
            }    
            /**  Final - if( strlen($dados)==1) { */
            //
       }
       /**  Final - if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) )  {  */    
       //
   } 
   /**  Final - if( ctype_alpha($dados) ) { */ 
   //
   /**   Caso for uma variavel numerica   */ 
   //  if( ctype_digit($dados) ) {  
   if( is_numeric($dados) ) {    
       /**
        *     Variavel $opcao numerica
        *  Alterado em 20250609
        *   $parte_login=" a.codigousp=$opcao  and  ";
        */
        $parte_login=" a.codigousp=$dados  and  ";
        //
   }  
   /**  Final - if( ctype_digit($dados) )  {  */
   //

/**  
echo "ERRO: srv_mostrausuario/179  -->>  \$opcao = $opcao  <<-->> 1)  \$parte_login =<b> $parte_login  </b><<-- <br>" 
           ."  -->> \$opcaoup = $opcaoup  <<-->>  \$val = $val   -->>  \$bd_1 = $bd_1  "
           ." -->>  \$bd_2 = $bd_2  <br />\n";
exit();
 */




   //  Caso variavel NULA
   $xlen= strlen(trim($parte_login));
   if( intval($xlen)<1 ) {
        //
        /**  Caso variavel SEM SER TODOS ou TODAS  
         * if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) )  {
        */ 
        if( ! preg_match("/tod(a|o)s?|ordenar/ui",$dados) ) {
             //
             $msg_erro .= "&nbsp;Falha grave na variavel.".$msg_final;
             echo $msg_erro;  
             exit();          
        }   
        /**  Final - if( ! preg_match("/tod(a|o)s?/ui",$dados) ) {  */
        //  
   }   
   /**  Final - if( intval($xlen)<1 ) {  */
   //
   $_SESSION["selecionados"]="";
   //
   /**   Selecionar os usuarios de acordo com a opcao  */
   // 
   //  Alterado em 20250528
   /**
   *      $sqlcmd="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_temporaria"]." "
   *      ." SELECT a.codigousp,a.login,b.nome,b.categoria,c.descricao as pa,b.e_mail "
   *      ." FROM $bd_2.usuario a, $bd_2.pessoa b, $bd_1.pa c "
   *      ." WHERE $parte_login a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$_SESSION["permit_pa"] ;
   */      
   /**  Criando uma Tabela Temporaria   */
   $table_temporaria = $_SESSION["table_temporaria"];
   $sqlcmd="CREATE TABLE IF NOT EXISTS  $table_temporaria ";
   $sqlcmd.=" SELECT a.codigousp,a.login,b.nome,b.categoria,c.descricao as pa,b.e_mail "
         ." FROM $bd_2.usuario a, $bd_2.pessoa b, $bd_1.pa c "
         ." WHERE $parte_login a.codigousp=b.codigousp and a.pa=c.codigo ";
   //      

/**  
echo "ERRO: srv_mostrausuario/1228  -->>  \$dados = $dados  -->> \$opcaoup = $opcaoup<br />\n "
       ."<br> \$sqlcmd = $sqlcmd<br />\n";
exit();
 */


   //
   //  Mostrar todos usuarios      
   //  if( $opcaoup=="TODOS" ) {
   if( preg_match("/tod(a|o)s?/ui",$opcaoup) ) {
        //       
        //  $sqlcmd .= " order by b.nome";
        //  $sqlcmd .= " order by a.login";
        if( strlen(trim($m_array))>0 ) {
             $m_array=preg_replace('/categoria/i', 'categoria', $m_array);             
             $m_array=preg_replace('/nome/i', 'nome', $m_array);             
             $sqlcmd .=" order by $m_array  "; 
        }  else {
             $sqlcmd .=" order by c.codigo,b.nome  ";    
        }
        //
        // $_SESSION["selecionados"] = "<b>Todos</b>";
        $_SESSION["selecionados"] = " - <b>Total</b>";
        //
   } else {
       //
       //  Mostrar apenas os usuarios selecionados pela Letra inicial
       //  $sqlcmd .=" and upper(substr(b.nome,1,1))='".$opcao."'  order by b.nome, a.login";
       //  $sqlcmd .=" and upper(substr(b.nome,1,1))='".$opcao."'  order by  a.login";
       //  $sqlcmd .=" and upper(substr(b.nome,1,1))='".$opcao."'  order by c.codigo,b.nome ";
       //  $_SESSION["selecionados"] = " - come&ccedil;ando com <b>".strtoupper($opcao)."</b>";        
       $sqlcmd .=" order by c.codigo,b.nome ";
       $_SESSION["selecionados"] = "";        
       //
   }
   //


/**  
echo "ERRO: srv_mostrausuario/267  -->>  \$dados = $dados  -->> \$_SESSION[selecionados] = {$_SESSION["selecionados"]}<br/>\n "
       ."<br> \$sqlcmd = $sqlcmd<br />\n";
exit();
 */



   //  Executando o Create Table
   $result_usuarios=mysqli_query($_SESSION["conex"],$sqlcmd);      
   //                  
   if( ! $result_usuarios ) {
         //
         // die('ERRO: Criando uma Tabela Temporaria: '.mysql_error());  
         $msg_erro .= "&nbsp;Criando uma Tabela Temporaria:&nbsp;db/mysqli&nbsp;";
         $msg_erro .= mysqli_error($_SESSION["conex"]).$msg_final;
         echo $msg_erro;  
         exit();          
   } 
   //
   /**  Desativar variavel  */
   if( isset($result_usuarios) ) {
       unset($result_usuarios);
   }
   //
   //  Selecionando todos os registros da Tabela temporaria
   $query2 = "SELECT * FROM {$table_temporaria} ";
   $result_outro = mysqli_query($_SESSION["conex"],$query2);                                    
   if( ! $result_outro ) {
         //
         // die('ERRO: Selecionando os Usu&aacute;rios: '.mysql_error());  
         $msg_erro .= "&nbsp;Selecionando os Usu&aacute;rios:&nbsp;db/mysqli&nbsp;";
         $msg_erro .= mysqli_error($_SESSION["conex"]).$msg_final;
         echo $msg_erro;  
         exit();          
   }        
   //
   /**   Pegando os nomes dos campos do primeiro Select  */
   // 3. Obter o número de campos (colunas)
   $num_fields = $result_outro->field_count;
   //
   $td_menu = $num_fields+1;   
   //

/**  
echo "ERRO: srv_mostrausuario/311  -->>  \$dados = $dados  -->> \$opcaoup = $opcaoup<br />\n "
       ."<br> \$num_fields = $num_fields <br /> \$td_menu = $td_menu \n";
exit();
 */


   //
   //  Total de registros
   $_SESSION["total_regs"] = mysqli_num_rows($result_outro);
   $total_regs= (int) $_SESSION["total_regs"];
   //
   if( $total_regs==1 ) {
        //
        $lista_usuario=" <b>1</b> usu&aacute;rio ";
        //
   } else {
        //
        $lista_usuario="<b>$total_regs</b> usu&aacute;rios ";
        //
   }
   //
   $_SESSION["titulo"]= "<p class='titulo' style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal; '>";
   $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
   //
   //  Buscando a pagina para listar os registros        
   $_SESSION["num_rows"]=$_SESSION["total_regs"];  
   $_SESSION["name_c_id0"]="codigousp";    
   //
   if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
   /**
    *  SESSION pagina - Paginacao da tabela de consulta de usuarios
   */
   $_SESSION["pagina"]=0;
   //
   $_SESSION["m_function"]="consulta_mostraus";   
   //
   /**  Variavel de controle para a tabela de consulta de usuarios  */
   //
   $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_usuario}?pagina=";
   //

/**  
echo "ERRO: srv_mostrausuario/353  -->>  \$_SESSION[opcoes_lista] = {$_SESSION["opcoes_lista"]}  <br />\n "
       ."<br> \$num_fields = $num_fields <br /> \$td_menu = $td_menu \n";
exit();
 */




   require_once("{$arq_tab_consulta_usuario}");                      
   //
} else {
    //


     
echo "ERRO: srv_mostrausuario/261  -->> ELSE -->> ANTES  -->> \$opcaoup = $opcaoup<br />\n";
exit();




    /*  Dados enviandos pelo arquivo usuario_consultar.php 
         - javascript function consulta_mostraus(tcopcao,dados)
    */
    /// Vericando - caso Variavel opcao para LISTA
    if( ! isset($valor) ) {
        if( isset($val) ) $valor=$val;  
    } 
    $_SESSION["pagina"]= (int) $valor;
    /// include("../includes/tabela_de_paginacao.php");                      
    ///  include("{$incluir_arq}includes/tabela_de_paginacao.php");                      
    $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_usuario}?pagina=";
    /// require_once("../includes/tabela_de_consulta_usuarios.php");                      
    require_once("{$arq_tab_consulta_usuario}");                      
    ///
}  
#
ob_end_flush(); 
#
?>