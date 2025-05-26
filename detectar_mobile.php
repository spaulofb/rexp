<?php
/***
*    Detectar aparelho movel - Mobile
* 
*/
///  Verificando se sseion_start - ativado ou desativado
if( !isset($_SESSION)) {
     session_start();
}
///
$mobile = FALSE;
$user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
///
foreach( $user_agents as $user_agent ) {
     if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
           $mobile = TRUE;
           $modelo    = $user_agent;
           break;
     }
}
/// Verifica o aplicativo movel
if( $mobile ) {
    /// echo "<p>Acesso feito via <b>".strtolower($modelo)."</b></P.";
    $_SESSION["estilocss"]="estilo_mobile.css";
} else {
    /// echo "Acesso feito via <b>computador</b>";
    $_SESSION["estilocss"]="estilo.css";
}
///
?>
