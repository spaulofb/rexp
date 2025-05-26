<?php
/*
*   REXP - REGISTRO DE EXPERIMENTO
*   
*   OTIMIZAR ESSE MODULO INCLUINDO ONDE ? necessário
 */
//  Caso session_start desativada  - Ativar
if( ! isset($_SESSION)) {
   session_start();
}
/*********  Parte principal iniciando as paginas do programa    ******/
//
// Funciona em todas as versoes
ini_set('include_path', '/var/www/cgi-bin/');
//  
//  Zerando variavel de erro
$n_erro=0;
// 
/**  HOST mais a pasta principal do site - host_pasta   */
if( ! isset($_SESSION["host_pasta"]) ) {
     //
     /**  $msg_erro .= utf8_decode("Sessão host_pasta não está ativa.").$msg_final;   */  
     $msg_erro .= "Sessão host_pasta não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$host_pasta=trim($_SESSION["host_pasta"]);
if( strlen($host_pasta)<1 ) $n_erro=2;
///
/***
*    Caso NAO houve ERRO  
*/
if( intval($n_erro)<1 )  {
    //
    //  DEFININDO A PASTA PRINCIPAL 
    //  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
    //  Verificando SESSION  pasta_raiz
    if( ! isset($_SESSION["pasta_raiz"]) ) {
         $msg_erro .= "Sessão pasta_raiz não está ativa.".$msg_final;  
         echo $msg_erro;
         $n_erro=1;
    } else {
        //
        $pasta_raiz=trim($_SESSION["pasta_raiz"]);        
        ///  
        ///  USUARIO CONECTADO - CODIGO USP
        if( ! isset($_SESSION["usuario_conectado"]) ) {
             $msg_erro .= "Sessão usuario_conectado não está ativa.".$msg_final;  
             echo $msg_erro;
             $n_erro=1;
        } else {
            /// Usuario conectado
             $usuario_conectado = $_SESSION["usuario_conectado"];            
             ///
            ///  Definindo http ou https - IMPORTANTE
            ///  Verificando protocolo do Site  http ou https   
            $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
            $_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
            $raiz_central=$_SESSION["url_central"];
            ///
            ///    MENU HORIZONTAL
            ///  include("../includes/array_menu.php");
            include("{$incluir_arq}includes/array_menu.php");
            if( isset($_SESSION["array_pa"]) ) {
                 $array_pa = $_SESSION["array_pa"];    
                 ///  Permissao do aprovador       
                 $permit_aprovador = $array_pa['aprovador'];
                 ///  Permissao do orientador
                 $permit_orientador = $array_pa['orientador'];
                  ///  Permissao do anotador       
                 $pa_anotador = $permit_anotador = $array_pa['anotador'];
                /* Exemplo do resultado  do  Permissao de Acesso - criando array
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
            }
            ///
            ///  Verifica desktop ou aparelho movel - retorna estilo css
            if( ! isset($_SESSION["dirprincipal"]) ) {
                 $msg_erro .= "Sessão usuario_conectado não está ativa.".$msg_final;  
                 echo $msg_erro;
                 $n_erro=1;
            } else {
                if( file_exists("{$_SESSION["dirprincipal"]}detectar_mobile.php") ) {
                     include_once("{$_SESSION["dirprincipal"]}detectar_mobile.php"); 
                     $estilocss = $_SESSION["estilocss"];
                } else {
                     $msg_erro .= "Arquivo {$_SESSION["dirprincipal"]}detectar_mobile.php não existe.";
                     $msg_erro .= $msg_final;  
                     echo $msg_erro;
                     $n_erro=1;
                }
            }
            ///
        }
        ///
    }
    ///
}
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
    ///  Alterado em 20180621
     $msg_erro .= "<br/>Ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
#
/********* Final -  Parte principal iniciando as paginas do programa    ******/
#
//  require_once('/var/www/cgi-bin/php_include/ajax/includes/desativando_vars.php');
// include('/var/www/cgi-bin/php_include/ajax/includes/desativando_vars.php');
#
#  TESTANDO
$elemento=5; $elemento2=6;

/*  EVITAR ESSA FORMA DE USO:
     @require_once('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
     include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
*/
////  FORMA ADEQUADA:
////  require_once("php_include/ajax/includes/conectar.php");
require_once("php_include/ajax/includes/conectar.php");
//
$aval_teste = "Projeto_RExp";
//  @require_once('/var/www/cgi-bin/php_include/ajax/includes/avaliando_ajax.php');
//   include('/var/www/cgi-bin/php_include/ajax/includes/avaliando_ajax.php');
include('php_include/ajax/includes/verificando.php');
/*  
     Consulta verifica se existe usuario
       com o login  e a senha            
*/
if( $_SESSION["total"]==1 ) { 
	// @require_once('file:///H|/php_include/ajax/includes/class.MySQL.php');
	$_POST['val_tm']=1; unset($_SESSION["total"]);
 //   $_SESSION[login_down]= $login_down; $_SESSION[senha_down]=$senha_down;  $_SESSION["n_upload"]="ativando";
    $_SESSION["n_upload"]="ativando";
    //  Variavel para HTTP
    $http_host="";
    if( isset($_SESSION["http_host"]) ) $http_host=$_SESSION["http_host"];
    ///
} else {
    session_destroy();
    exit();
}	
//
///
/***    INCLUINDO CLASS - 
* 
*    Alterado em 20250108
*       Deprecated: __autoload() is deprecated, 
*             use spl_autoload_register() 
****/
///    IMPORTANTE: variavel de erro
$php_errormsg="";
///     Class para funcoes de mensagens 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");
if( strlen(trim($php_errormsg))>0  )  {
    echo "ERRO: OCORREU UM ERRO ".$php_errormsg;
    exit();
}
$autoload = new Autoload();
$funcoes=new funcoes();
//
// functions PHP
require_once("{$_SESSION["incluir_arq"]}includes/functions.php");
//
?>
