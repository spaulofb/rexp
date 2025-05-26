<?php
/**
*   REXP - REGISTRO DE EXPERIMENTO - ANOTA??O DE PROJETO
* 
*       MODULO: index_ajax - complemento AJAX do index 
*  
*   LAFB/SPFB250509.1736 - Corre??es gerais
*/
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///
/*** Evitando warning ***/
ob_start(); 
#
/*
if( isset($_SESSION["login_down"]) ) unset($_SESSION["login_down"]);
if( isset($_SESSION["senha_down"]) ) unset($_SESSION["senha_down"]);
if( isset($_SESSION["total"]) )  unset($total);
*/
/* N?o gravar em cache */
#
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=iso-8859-1");
#
///
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");
//
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
///
ini_set('default_charset','UTF-8');
//
// Funciona em todas as versoes
ini_set('include_path', '/var/www/cgi-bin/');
//  
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
// extract: Importando vari?veis POST para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE); 

$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
//
//    Varios arrays
// include("includes/array_menu.php");
require_once("includes/array_menu.php");
//
$elemento=5; $elemento2=6;
require_once("php_include/ajax/includes/conectar.php");
//
$m_erro=0;
/// Verificando login
if( ! isset($login_down) ) {
    $msg_erro .= utf8_decode("Falha na variavel login_down - Corrigir").$msg_final;   
    $m_erro++;
} else {
    if( ! isset($senha_down) ) {
        $msg_erro .= utf8_decode("Falha na variavel senha_down - Corrigir").$msg_final;   
        $m_erro++;
    }
}
//
//  Caso houve erro
if(  intval($m_erro)>0 ) {
    echo $msg_erro;
    exit(); 
}  
/**  Final - if(  intval($m_erro)>0 ) { */
//
//  SESSIONs login e senha
$_SESSION['login_down'] = $login_down;
$_SESSION['senha_down'] = $senha_down;
//
//  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
    //
    /**   Path/DIR - Caminho do Diretorio principal local INEXISTENTE  */  
    $msg_erro .= "Falha grave SESSION incluir_arq  - Corrigir".$msg_final;   
    echo $msg_erro;
    exit();
    ///
}
/**   Path/DIR - Caminho do Diretorio principal  local   */  
$incluir_arq = $_SESSION["incluir_arq"];
//

//  Alterado em 20250509
/**   login ou e_mail -  Tabela pessoal.usuario(login) e pessoal.pessoa(e_mail)  */ 
// if( strpos($login_down,'@')===false ) {
if( strpos($login_down,'@') ) {
     //
     //  Caso  variavel for E_MAIL
     //  $email=$login_down;
     $testar_login=strtoupper(trim($login_down));
     $_SESSION['user_cond'] =" upper(trim(b.e_mail))='$testar_login'";   
     //
} else {
    //
    //  Variavel pode ser codigousp ou login
    $testar_login =  trim($login_down);
    //
    // Caso variavel for numerica - codigousp
    if( is_numeric($testar_login) ) {
        //
        //  login  como  codigousp da Tabela usuario
        $testar_login = (int) trim($login_down);
        $_SESSION['user_cond']  =" a.codigousp=$testar_login ";          
        //
    } else {
        //
        // login - variavel como string
        $_SESSION['user_cond']  =" a.login=\"$testar_login\" ";    
        //
    }  
    //
}
//
//
$email=$login_down;
$mail_correcto=0;
//
//  Verificando Tabelas - login e senha
// include('php_include/ajax/includes/verificando.php');
require_once('php_include/ajax/includes/verificando.php');
//
/** 
*  Consulta verifica se existe usuario
*      com o login_down passado e senha          
*/
if( ! isset($_SESSION["total"]) ) {
    $_SESSION["total"]="";  
}
$stotal=$_SESSION["total"];
//
// Verificando variavel $opcao
$opcao_up="";
if( isset($opcao) ) {
    $opcao_up=strtoupper(trim($opcao));
}
/**  Final - if( isset($opcao) ) {  */
//
/**  Caso variavel IGUAL a  1  */
if( intval($stotal)==1 ) {    
    ///
   if( $opcao_up=="PA_SELECIONADO" ) {  
        //
        if( isset($_SESSION["n_login_down"])  )  {
            $len_val = strlen(trim($_SESSION["n_login_down"]));          
            $_SESSION["login_down"]=trim($_SESSION["n_login_down"]);               
        } elseif( isset($_SESSION["login_down"])  )  {
            $len_val = strlen(trim($_SESSION["login_down"]));          
            $_SESSION["login_down"]=trim($_SESSION["login_down"]);                           
        }  
        //        
        if( isset($_SESSION["n_senha_down"]) ) {
            $_SESSION["senha_down"] = trim($_SESSION["n_senha_down"]);        
        } elseif( isset($_SESSION["senha_down"]) ) {
            $_SESSION["senha_down"] = trim($_SESSION["senha_down"]);        
        }    
        $_SESSION["permit_pa"]=$permit_pa; 
        //
        /**  Armazenando as Variaveis nas SESSIONs */
        if( isset($total) ) unset($total); 
        if( isset($_SESSION["total"]) ) unset($_SESSION["total"]);
        //
        //  unset($login_down);    unset($senha_down);    unset($codigo_down);
        $navegador = $_SERVER["HTTP_USER_AGENT"];
        $pos = strpos($_SERVER["HTTP_USER_AGENT"],'MSIE');
        if( isset($parte1) ) unset($parte1); 
        if( isset($parte2) ) unset($parte2); 
        //
        //  Alterado em 20160923
        if( isset($_POST) ) {
           ///  $_POST = array(); unset($_POST);     
           unset($_POST);     
        }  
        ///
        $_SESSION["len_val"]=$len_val;
        $_SESSION["action"]="projetos_rexp";
        //
        /**   
        *   Atualizado em 20250513
        *
        *     Funciona em todas as versoes
        *    ini_set('include_path', '/var/www/cgi-bin/');
        *     include('php_include/ajax/includes/exec_ie_firefox.php');     
        */  
        require_once("{$_SESSION["incluir_arq"]}includes/exec_ie_firefox.php");
        //
        exit();
       //        
   }
   /**   Final - if( $opcao_up=="PA_SELECIONADO" ) {   */
   //
} else if( intval($stotal)<>1 ) {
    //
    //  session_destroy();    
    /** 
     *   Caso o total seja zero sair com exit() 
     *     destroy qualquer session                
    */
    include("php_include/ajax/includes/sair.php");        
    //
}
#
ob_end_flush(); /* limpar o buffer */
#
?>
