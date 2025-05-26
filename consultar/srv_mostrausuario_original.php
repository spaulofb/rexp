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
// set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

//  header("content-type: application/x-javascript; charset=iso-8859-1");
header("Content-Type: text/html; charset=ISO-8859-1",true);
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

//
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
///
////  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
//// Final - Mensagens para enviar

///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     ///  $msg_erro .= utf8_decode("Sessão incluir_arq não está ativa.").$msg_final;  
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
///
$opcao = $_POST['grupous'];
///
///  Conectar 
$elemento=6; $elemento2=5;
include("php_include/ajax/includes/conectar.php");   

///  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
////      
////  Variavel com letras maiusculas      
$opcao_maiusc = strtoupper(trim($opcao));

///  Arquivo da tabela de consulta usuario - importante
$arq_tab_consulta_usuario="{$incluir_arq}includes/tabela_de_consulta_usuarios.php"; 

/// Vericando - caso Variavel opcao  NAO for LISTA
if( strtoupper($opcao)!='LISTA' ) {
   ///
   $_SESSION["table_temporaria"] = $bd_2.".temp_consultar_usuario";
   $sql_temp = "DROP TABLE IF EXISTS  {$_SESSION["table_temporaria"]} ";
   $result_usuarios=mysql_query($sql_temp);
   if( ! $result_usuarios ) {
        die('ERRO: '.mysql_error());  
   }   
   ///  Caso for uma letra somente
   $dados=trim($val);
   $parte_login="";
   ///  Variavel alfabetica
   if( ctype_alpha($dados) ) {
       ////  if( strlen(trim($opcao))==1 ) {
       /// $letra=strtoupper(trim($opcao));
        if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) )  {
             ///  Caso tenha escolhido uma Letra do Login/Usuario por EMAIL
              if( strlen($dados)>1) {
                    /// $letra_login=" upper(a.login) like '$letra%'  and  ";
                    //// $letra_login=" upper(b.e_mail) like '$letra%'  and  ";
                    $email=trim($opcao);
                    $parte_login=" b.e_mail='$email'  and  ";
              }      
              ///  Caso tenha escolhido uma Letra do Login/Usuario
              if( strlen($dados)==1) {
                    /// ALterado em 20170609
                    if( strlen($dados)==1 ) {
                         $letra="$dados";
                    } elseif( strlen($opcao)==1 ) {
                         $letra=trim($opcao);  
                    }    
                    $parte_login=" upper(b.nome) like '$letra%'  and  ";
              }    
              ///
        }    
       ////
    } elseif( ctype_digit($dados) )  {
          ///  Variavel $opcao numerica
          $parte_login=" a.codigousp=$opcao  and  ";
    }
    ///
    ///  Caso variavel NULA
    if( strlen(trim($parte_login))<1 ) {
        ////  Caso variavel SEM SER  TODOS ou TODAS
        if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) )  {
              $msg_erro .= "&nbsp;Falha grave na variavel.".$msg_final;
              echo $msg_erro;  
              exit();          
        }     
    }   
    ///
   $_SESSION["selecionados"]="";
   ///  Selecionar os usuarios de acordo com a opcao
   /*
   $sqlcmd="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_temporaria"]." "
         ." SELECT a.codigousp,a.login,b.nome,b.categoria,c.descricao as pa,b.e_mail "
         ." FROM $bd_2.usuario a, $bd_2.pessoa b, $bd_1.pa c "
         ." WHERE $letra_login a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$_SESSION["permit_pa"] ;
    */     
    ////  Alterado em 20180808
    /***
   $sqlcmd="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_temporaria"]." "
         ." SELECT a.codigousp,a.login,b.nome,b.categoria,c.descricao as pa,b.e_mail "
         ." FROM $bd_2.usuario a, $bd_2.pessoa b, $bd_1.pa c "
         ." WHERE $parte_login a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$_SESSION["permit_pa"] ;
   **/      
   $sqlcmd="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_temporaria"]." "
         ." SELECT a.codigousp,a.login,b.nome,b.categoria,c.descricao as pa,b.e_mail "
         ." FROM $bd_2.usuario a, $bd_2.pessoa b, $bd_1.pa c "
         ." WHERE $parte_login a.codigousp=b.codigousp and a.pa=c.codigo ";
   ///      
   ///   MOstrar todos usuarios      
   if( strtoupper($opcao)=="TODOS"){
        //  $sqlcmd .= " order by b.nome";
        //  $sqlcmd .= " order by a.login";
        if( strlen(trim($m_array))>0 ) {
             $m_array=preg_replace('/categoria/i', 'categoria', $m_array);             
             $m_array=preg_replace('/nome/i', 'nome', $m_array);             
             $sqlcmd .=" order by $m_array  "; 
        }  else {
             $sqlcmd .=" order by c.codigo,b.nome  ";    
        }
        /// $_SESSION["selecionados"] = "<b>Todos</b>";
        $_SESSION["selecionados"] = " - <b>Total</b>";
   } else {
        ///  Mostrar apenas os usuarios selecionados pela Letra inicial
        ///  $sqlcmd .=" and upper(substr(b.nome,1,1))='".$opcao."'  order by b.nome, a.login";
        ///  $sqlcmd .=" and upper(substr(b.nome,1,1))='".$opcao."'  order by  a.login";
        ///  $sqlcmd .=" and upper(substr(b.nome,1,1))='".$opcao."'  order by c.codigo,b.nome ";
        ///  $_SESSION["selecionados"] = " - come&ccedil;ando com <b>".strtoupper($opcao)."</b>";        
        $sqlcmd .=" order by c.codigo,b.nome ";
        $_SESSION["selecionados"] = "";        
   }
   ///  Executando o Create Table
   $result_usuarios=mysql_query($sqlcmd);      
   ////                  
   if( ! $result_usuarios ) {
         /// die('ERRO: Criando uma Tabela Temporaria: '.mysql_error());  
         $msg_erro .= "&nbsp;Criando uma Tabela Temporaria:&nbsp;db/mysql&nbsp;".mysql_error().$msg_final;
         echo $msg_erro;  
         exit();          
   } 
   ///  Selecionando todos os registros da Tabela temporaria
   $query2 = "SELECT * FROM {$_SESSION["table_temporaria"]} ";
   $result_outro = mysql_query($query2);                                    
   if( ! $result_outro ) {
         /// die('ERRO: Selecionando os Usu&aacute;rios: '.mysql_error());  
         $msg_erro .= "&nbsp;Selecionando os Usu&aacute;rios:&nbsp;db/mysql&nbsp;".mysql_error().$msg_final;
        echo $msg_erro;  
        exit();          
   }        
   ///  Pegando os nomes dos campos do primeiro Select
   $num_fields=mysql_num_fields($result_outro);   /// Obt?m o n?mero de campos do resultado
   $td_menu = $num_fields+1;   
   ///  Total de registros
   $_SESSION["total_regs"] = mysql_num_rows($result_outro);
   $total_regs=$_SESSION["total_regs"];
   $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> usu&aacute;rio " : $lista_usuario="<b>$total_regs</b> usu&aacute;rios ";     
   /// $_SESSION["titulo"]= "<p class='titulo_consulta'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; '    >";
   $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal; '  >";
   $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
   //  Buscando a pagina para listar os registros        
   $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
   if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
   $_SESSION["pagina"]=0;
   $_SESSION["m_function"]="consulta_mostraus";   
   //// $_SESSION["opcoes_lista"] = "../includes/tabela_de_consulta_usuarios.php?pagina=";
   $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_usuario}?pagina=";
   /// require_once("../includes/tabela_de_consulta_usuarios.php");                      
   require_once("{$arq_tab_consulta_usuario}");                      
   ////
} else {
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