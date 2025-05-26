<?php
/***
*    Detectar aparelho movel - Mobile
* 
*/
$mobile = FALSE;
$user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");

foreach($user_agents as $user_agent){
 if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
    $mobile = TRUE;
$modelo    = $user_agent;
break;
 }
}

if ($mobile){
  echo "<p>Acesso feito via <b>".strtolower($modelo)."</b></P.";
}else{
  echo "Acesso feito via <b>computador</b>";
}
///
?>
