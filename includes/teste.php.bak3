<?php
//
//  Caso SESSION_START desativada  - Ativar  
if(!isset($_SESSION)) {
   session_start();
}
//
/**
*     Arquivo para a Tag Select das Tabelas: Instituicao, Unidade, Depto, pessoa, categoria
*/
$num_campos=mysqli_num_fields($result);
//
// Verificando Nr. de Campos 
if( intval($num_campos)==1 ) {
     $cpo_nome_descr=mysqli_field_name($result,0);        
} elseif( intval($num_campos)>1 ) {
     $codigo_sigla=mysqli_field_name($result,0);
     $cpo_nome_descr=mysqli_field_name($result,1);
}
////

$_SESSION["msgr"] = "LINHA/14 -->> \$num_campos = $num_campos -->> \$cpo_nome_descr = $cpo_nome_descr ";
return;


?>
