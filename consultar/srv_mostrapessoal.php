<?php
//  AJAX da opcao CONSULTAR PESSOAS 
//
//  LAFB180606.1740
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
//
$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";
//
$msg_final="</span></span>";
/**   Final - Mensagens para enviar   */
// 
//  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     //
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
//  Verificando POST  grupous
if( ! isset($_POST['grupous']) ) {
     //
     /**   $msg_erro .= utf8_decode("Sessão incluir_arq não está ativa.").$msg_final;  */
     $msg_erro .= "POST grupous não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
     //
}
$opcao = $_POST['grupous'];
//
//  Variavel POST dados
if( isset($_POST['dados']) ) {
    $dados=$_POST['dados'];
} else {
   if( ! isset($dados) ) $dados="";    
}
//  Variavel com letras maiusculas      
$dados_maiusc = strtoupper(trim($dados));
///
///  Conectar 
$elemento=6;  $elemento2=5;
include("php_include/ajax/includes/conectar.php");     
//
//  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
//      
//  Variavel com letras maiusculas      
$opcao_maiusc = strtoupper(trim($opcao));
//
//  Arquivo da tabela de consulta pessoal - importante
$arq_tab_consulta_pessoal="{$_SESSION["incluir_arq"]}includes/tabela_de_consulta_pessoal.php";
//
//  Vericando - caso Variavel opcao  NAO for LISTA
//  if( strtoupper($opcao)!='LISTA' ) {




if( $opcao_maiusc=='ORDENAR' or $dados_maiusc=="BUSCA_LETRAI" ) { 
    //
    $_SESSION["table_temporaria"] = $bd_2.".temp_consultar_pessoal";
    $table_temporaria = $_SESSION["table_temporaria"];
    //
    //  Removendo tabela temporaria
    $sql_temp = "DROP TABLE IF EXISTS $table_temporaria ";
    $result_usuarios=mysqli_query($conex,$sql_temp);
    if( ! $result_usuarios ) {
        //
        // die('ERRO: '.mysqli_error($conex)));  
        $msg_erro .= "&nbsp;DROP TABLE IF EXISTS {$table_temporaria}:";
        $msg_erro .= "&nbsp;db/mysqli&nbsp;";
        $msg_erro .= mysqli_error($conex).$msg_final;
        echo $msg_erro;  
        exit();          
   }   
   /**  Final - if( ! $result_usuarios ) {   */
   //
   //  Caso for uma letra somente
   //  $testcase=trim($opcao);
   $dados=trim($opcao);   
   $parte_login="";
   //
   //  Variavel alfabetica


/** 
echo "ERRO: LINHA139 -->> srv_mostrapessoal  -->>  \$dados = $dados <<-->> \$opcao_maiusc = $opcao_maiusc <<-- <br>"
            ." -->>  \$dados_maiusc = $dados_maiusc <<--<br/> \$xtd = $xtd \n";
exit();
 */



   if( ctype_alpha($dados) ) {
        //
        //  if( strlen(trim($opcao))==1 ) {
        // $letra=strtoupper(trim($opcao));
        // if( ! preg_match("/TODOS|TODAS/i",$dados) )  {
        if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) ) {
             //
             //  Caso tenha escolhido uma Letra do Login/Usuario por EMAIL
             if( strlen($dados)>1) {
                  //
                  // $letra_login=" upper(a.login) like '$letra%'  and  ";
                  // $letra_login=" upper(b.e_mail) like '$letra%'  and  ";
                  $email=trim($opcao);
                  $parte_login=" WHERE  e_mail='$email' ";
             }      
             //
             //  Caso tenha escolhido uma Letra do Login/Usuario
             if( strlen($dados)==1) {
                   /// ALterado em 20170609
                   if( strlen($dados)==1 ) {
                       $letra="$dados";
                   } elseif( strlen($opcao)==1 ) {
                       $letra=trim($opcao);  
                   }    
                   $parte_login=" WHERE upper(nome) like '$letra%'  ";
                   //
             }    
             //
        }    
        //
    //  } elseif( ctype_digit($dados) ) {
    } elseif( is_numeric($dados) ) {
        /**
        *     Variavel $opcao numerica
        *  Alterado em 20250610
        *    $parte_login=" WHERE codigousp=$opcao   ";
        */
        $parte_login=" WHERE codigousp=$dados ";
        //
    } 
    //
    //  Caso variavel NULA
    $xlen= strlen(trim($parte_login));

/**  
echo "ERRO: srv_mostrapessoal/192  -->> OK  \$dados = $dados <<-->> \$opcao_maiusc = $opcao_maiusc <<-- <br>"
            ." -->> \$parte_login = $parte_login  <<-->>  \$dados_maiusc = $dados_maiusc <<--<br/> \$xlen = $xlen \n";
exit();
 */


    if( intval($xlen)<1 ) {
        //
        //  Caso variavel SEM SER  TODOS ou TODAS
        if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) )  {
              $msg_erro .= "&nbsp;Falha grave na variavel".$msg_final;
              echo $msg_erro;  
              exit();          
        }
        //     
    }   
    /**  Final - if( intval($xlen)<1 ) {  */
    //
    $_SESSION["selecionados"]="";
    /**
    *    O charset UTF-8  uma recomendacao, 
    *    pois cobre quase todos os caracteres e 
    *    símbolos do mundo
    */
    mysqli_set_charset($conex,'utf8');
    //
    //  Selecionar os usuarios de acordo com a opcao
    $sqlcmd = "CREATE TABLE IF NOT EXISTS  $table_temporaria  "
           ." SELECT codigousp,nome,categoria,e_mail "
           ." FROM  $bd_2.pessoa  $parte_login  ";
    //
    //   Mostrar todos usuarios      
    //  if( strtoupper($opcao)=="TODOS" ) {
    //   if( preg_match("/TODOS|TODAS|ordenar/i",$opcao) ) {   
    if( ! preg_match("/tod(a|o)s?|ordenar/ui",$dados) ) {
        //
        $_SESSION["selecionados"] = " - <b>Total</b>";
        //
        // Caso variavel $m_array esteja definida 
        if( isset($m_array) ) {
            //
            $lent= strlen(trim($m_array));
            if( $lent>0 ) {
                 //
                 $m_array=preg_replace('/categoria/ui', 'categoria', $m_array);             
                 $m_array=preg_replace('/nome/ui', 'nome', $m_array);             
                 $m_array=preg_replace('/sexo/ui', 'sexo', $m_array);             
                 $m_array=preg_replace('/unidade/ui', 'unidade', $m_array);             
                 $m_array=preg_replace('/setpr/ui', 'setor', $m_array);             
                 $sqlcmd .=" order by $m_array  "; 
            } 
            /**  Final - if( $lent>0 ) {  */
            // 
        } else {
             //// $sqlcmd .=" order by c.codigo,b.nome  ";    
             $sqlcmd .=" order by nome  ";    
        }
        //
   } else {
        //
        //  Mostrar apenas as pessoas selecionados pela Letra inicial
        $_SESSION["selecionados"] = "";        
        $sqlcmd .=" order by nome asc";
        //
   }
   //
   // Executando  procedimento
   $result_usuarios=mysqli_query($conex,$sqlcmd);   
   //                
   if( ! $result_usuarios ) {
         //
        // die('ERRO: Criando uma Tabela Temporaria: '.mysqli_error($conex)));  
        $msg_erro .= "&nbsp;Criando uma Tabela Temporaria:&nbsp;db/mysql&nbsp;";
        $msg_erro .= mysqli_error($conex).$msg_final;
        echo $msg_erro;  
         exit();          
   } 
   //
   /***
    *    O charset UTF-8  uma recomendacao, 
    *    pois cobre quase todos os caracteres e 
    *    símbolos do mundo
    ***/
   mysqli_set_charset($_SESSION["conex"],'utf8');
   //
   //  Selecionando todos os registros da Tabela temporaria
   $query2 = "SELECT * from  $table_temporaria  ";
   $result_outro = mysqli_query($conex,$query2);                                    
   if( ! $result_outro ) {
         ///  die('ERRO: Selecionando os Usu&aacute;rios: '.mysqli_error($conex));  
        $msg_erro .= "&nbsp;Selecionando as pessoas:&nbsp;db/mysql&nbsp;".mysqli_error($conex).$msg_final;
        echo $msg_erro;  
        exit();          
   }    
   //   
   //  Pegando os nomes dos campos do primeiro Select
   $num_fields=mysqli_num_fields($result_outro);  //  Obtem o numero de Campos do resultado
   $td_menu = $num_fields+1;   



echo "ERRO: srv_mostrapessoal/293  -->>  \$dados = $dados  -->> \$opcaoup = $opcaoup<br />\n "
       ."<br> \$num_fields = $num_fields <br /> \$td_menu = $td_menu \n";
exit();





   // 
   //  Total de registros
   $total_regs=$_SESSION["total_regs"] = mysql_num_rows($result_outro);
   $total_regs===1 ? $lista_usuario=" <b>1</b> pessoa " : $lista_usuario="<b>$total_regs</b> pessoas ";     
   $_SESSION["titulo"]= "<p class='titulo_consulta' style='text-align: left; margin-right: 4px; padding: 0px;' >";
   $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
   //  Buscando a pagina para listar os registros        
   $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
   if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
   $_SESSION["pagina"]=0;
   /*
        Function do Javascript - no arquivo pessoal_consultar.php
   */     
   $_SESSION["m_function"]="consulta_mostrapes";    
   //// $_SESSION["opcoes_lista"] = "../includes/tabela_de_consulta_usuarios.php?pagina=";
   $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_pessoal}?pagina=";
   /// require_once("../includes/tabela_de_consulta_usuarios.php");                      
   require_once("{$arq_tab_consulta_pessoal}");                      
   /////
} elseif( $opcao_maiusc=='LISTA' ) {
    /*  Dados enviandos pelo arquivo pessoal_cadastrar.php 
         - javascript function consulta_mostrapes
    */
    $_SESSION["pagina"]= (int) $dados;
    /// include("../includes/tabela_de_paginacao.php");                      
    /// include("{$incluir_arq}includes/tabela_de_paginacao.php");                      
    $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_pessoal}?pagina=";
    /// require_once("../includes/tabela_de_consulta_usuarios.php");                      
    require_once("{$arq_tab_consulta_pessoal}");                      
    ///
} elseif( $opcao_maiusc=='MOSTRAR' ) {
    ///  Pagina da lista das pessoas
    $_SESSION["pagina"] = $m_array;
    ///
    /***
    *    O charset UTF-8  uma recomendacao, 
    *    pois cobre quase todos os caracteres e 
    *    símbolos do mundo
    ***/
    mysql_set_charset('utf8');
    ///
    ///  Mostrar dados da Pessoa selecionada    
   $sqlcmd = "SELECT * FROM  $bd_2.pessoa  WHERE codigousp=$dados ";
   $result_outro = mysqli_query($conex,$sqlcmd);                                    
   if( ! $result_outro ) {
       ///  die('ERRO: Selecionando os Usu&aacute;rios: '.mysqli_error($conex));  
      $msg_erro .= "&nbsp;Selecionando dados da pessoa:&nbsp;db/mysql&nbsp;".mysqli_error($conex).$msg_final;
      echo $msg_erro;  
      exit();          
   }  
   ///      
   ///  Definindo os nomes e dados dos campos recebidos 
   $arr_nome_val=mysql_fetch_array($result_outro);
   foreach(  $arr_nome_val as $key => $value ) $$key = $value;
    ///
    ?>
    <p class="titulo_usp" style="border-top: .2em solid #000000;" >Dados da Pessoa</p>
    
    <div class="td_inicio1" style="text-align: left;overflow: hidden;"  >
      <!-- N. Funcional USP - Pessoa -->
      <p>
      <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
      C&oacute;digo/USP:&nbsp;
      <span class='td_inicio1' style="padding-left:2px; padding:0 .5em 0 .5em; background-color:#FFFFFF; color:#000000;" >
        <?php echo "$codigousp";?></span>
      </span>
      <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
      Nome:&nbsp;
      <span class='td_inicio1' style="border:none; padding:0 .5em 0 .5em; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$nome";?></span>
     </span>
     </p>
     <!-- Final - N. Funcional USP e Nome - Pessoa -->    
     <!-- CPF - Pessoa -->
     <p>
     <span class="td_inicio1" style="text-align: left;color:#0B0B61;" >
      CPF:&nbsp;
      <span class='td_inicio1' style="border:none; padding:0 .5em 0 .5em; background-color:#FFFFFF; color:#000000;" >
        <?php echo "$cpf";?></span>
     </span>
     </p>
     <!-- Final - CPF - Pessoa -->
     <?php
        ///  Selecionando a Categoria
         $sqlcat = "SELECT descricao as cat FROM $bd_2.categoria WHERE codigo=\"$categoria\" ";
         $result_cat = mysqli_query($conex,$sqlcat);
         $nregs=mysql_num_rows($result_cat);
         $cat="";
         ///  Caso encontrou categoria
         if( intval($nregs)>0 ) $cat=mysql_result($result_cat,0,"cat");
         ///
         header('Content-type: text/html; charset=utf-8');
         ///                                   
     ?>
     <!-- Categoria - Pessoa -->
     <p>
     <span class="td_inicio1" style="text-align: left;color:#0B0B61;" >
      Categoria:&nbsp;
      <span class='td_inicio1' style="border:none; padding:0 .5em 0 .5em; background-color:#FFFFFF; color:#000000;" >
        <?php echo "$cat";?></span>
     </span>
     <!-- Final - Categoria - Pessoa -->
     <!-- Instituicao/Unidade?Depto/Setor/Bloco - Pessoa -->
      <p>
      <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
        Instituição:&nbsp;
      <span class='td_inicio1' style="border:none; padding:0 .5em 0 .5em; background-color:#FFFFFF; color:#000000;" >
        <?php echo "$instituicao";?></span>
      </span>
      <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
      Unidade:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$unidade";?></span>
     </span>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
      Departamento:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$depto";?></span>
     </span>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
      Setor:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$setor";?></span>
     </span>
     </p>
     <!-- Final - Instituicao/Unidade?Depto/Setor - Pessoa -->    
     <!-- Bloco/Sala/Salatipo - Pessoa -->    
     <p>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
       Bloco:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$bloco";?></span>
     </span>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
       Sala:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$sala";?></span>
     </span>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
       Sala tipo:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$salatipo";?></span>
     </span>
     </p>
     <!-- Final - Bloco/Sala/Salatipo - Pessoa -->   

     <!-- Telefone/Ramal - Pessoa -->    
     <p>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
       Telefone:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$fone";?></span>
     </span>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
       Ramal:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$ramal";?></span>
     </span>
     </p>
     <!-- Final - Telefone/Ramal - Pessoa -->   
     
     <!-- E_MAIL - Pessoa -->    
     <p>
     <span  class="td_inicio1" style="text-align: left;color:#0B0B61;" >
       E_mail:&nbsp;
      <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" >
         <?php echo "$e_mail";?></span>
     </span>
     <br/>
     </p>
     <!-- Final - E_MAIL - Pessoa -->   
     <!-- Retornar pra Lista - Pessoa -->   
     <p>
          <button  type="submit"  name="retornar" id="retornar" onclick="javascript: consulta_mostrapes('Lista','<?php echo "{$_SESSION["pagina"]}";?>');" 
           class="botao3d" style="cursor: pointer; "  title="Retornar"  acesskey="R"  alt="Retornar" >    
      Retornar
     </button>
     </p>
     <!-- Final - Retornar pra Lista - Pessoa -->   
     
   </div>
   <?php
    ///
}  
#
ob_end_flush(); 
#
?>