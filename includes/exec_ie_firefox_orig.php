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

$_SESSION["resto"] = " CONTINUAR exec_ie_firefox.php    FLÇKAJSFLÇKAJLÇKAFJLÇAJA <br>  ";
echo $_SESSION["resto"];  


?>
