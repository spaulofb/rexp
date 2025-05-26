<?php
/** 
*   REXP - REGISTRO DE EXPERIMENTO - ANOTACAO DE PROJETO
* 
*       MODULO: index 
*  
*   LAFB/SPFB250508.1708 - Correcoes gerais
*/
//  Caso sseion_start desativado - Ativar
if( !isset($_SESSION) ) {
     session_start();
}
//
///  Definindo a variavel action
$action = "";
if( isset($_SESSION["action"]) ) {
    $action = trim($_SESSION["action"]); 
}
///
if( ! isset($_SESSION["len_val"]) ) $_SESSION["len_val"]=0; 
$len_val = $_SESSION["len_val"];
//
//  $http_host = $_SERVER["HTTP_HOST"];
$http_host = $_SESSION["http_host"];
$pasta_raiz = $_SESSION["pasta_raiz"];
//
//
if( intval($len_val)>1 ) { 
    //	
    if( $action=="downloads" or  $action=="projetos" ) {
          $action="iframes.php";
    } elseif(  $action=="projetos_rexp" ) {
          //
         $action="menu.php";
         /**   echo  "Iniciando#http://".$_SERVER["HTTP_HOST"]."/rexp3/".$action;  */ 
         $caminho = $http_host.$pasta_raiz.$action;
         ///
         echo  'Iniciando#http://'."{$caminho}";
         exit();
    } else {
         $action="menu.php";
    }
    //
    //  Iniciando o programa
    $form_id_name = "iniciando"; 
    $submit_id_name = "iniciar";
    $value="Clique para ".$submit_id_name; 
    $title=ucfirst(strtolower($submit_id_name));
    $acesskey = $title; 
    $function_fim ="id_conteudo";
    //
} else {
    //
    //  Usando o botao Sair - Fecha o programa    
    $form_id_name = "saindo"; 
    $action='http://'."$http_host" ; 
    //
    // $submit_id_name = "sair";
    $value="Clique para ".$submit_id_name; 
    $title=ucfirst(strtolower($submit_id_name));
    $acesskey = $title;  
    $function_fim ="id_sair";
    //
}
//
$msg_form  = "<p>&nbsp;</p>";	
$msg_form .=  '<h2 class="aviso" >';
$msg_form .=  "<form id='$form_id_name' name='$form_id_name' method='post' action='$action'  >";
$msg_form .= "<input type='submit' class='botao3d_iniciando' tabindex='1'  ";
$msg_form .= " style='cursor: pointer; border:none;' name='$submit_id_name' ";
$msg_form .= "  id='$submit_id_name'  title='$title'  acesskey='$acesskey'  ";
$msg_form .= " value='$value' onmouseout='javascript:  $function_fim(\"$title\",\"$submit_id_name\");'    ";
$msg_form .= " alt='$title'  onmouseover='javascript:  $function_fim(\"$title\",\"$submit_id_name\");'  ";
$msg_form .= "  onfocus='javascript:  $function_fim(\"$title\",\"$submit_id_name\");' ";  
$msg_form .= "  onclick='javascript:  $function_fim(\"$title\",\"$submit_id_name\");'    /> "; 
$msg_form .= "</form>";
$msg_form .= "</h2>";
$msg_form .= "<script type='text/javascript' >document.getElementById('$submit_id_name').click()</script>";
//
echo $msg_form;
//

/**
 *   $_SESSION["resto"] = "  exec_ie_firefox.php/29  -->> \$len_val = $len_val <<-- <br>  "; 
 *    echo $_SESSION["resto"];   
 */




?>
