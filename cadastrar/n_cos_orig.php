<?php
//
//  Campos das Tabelas projeto e experimento
//   Acertando caso tenha coresponsaveis/colaboradores/coautores
for( $i=0; $i<$count_array_temp; $i++ ) {
      //  ncoautor - na tabela projeto feito pelo num de coresponsaveis
     if( stristr($array_temp[$i],"ncoautor") )  {
            unset($array_temp[$i]); unset($array_t_value[$i]);
     } else {
	       // Criando um novo array
 	       $new_cpo_nome[] = $array_temp[$i]; 
		   $new_cpo_val[]=$array_t_value[$i];
	 }
     //
}
/**  FInal - for( $i=0; $i<$count_array_temp; $i++ ) {  */
//
/**  Depois de alterado os arrays: $array_temp e $array_t_value  */
//  $count_array_temp = sizeof($array_temp);
$cntarr = sizeof($new_cpo_nome);
unset($array_temp); unset($array_t_value);
//
for( $i=0; $i<$cntarr; $i++ ) {
      //
      /**
      *    $msg_erro .= "<br>  $i = ".$array_temp[$i]."  -  ".$array_t_value[$i]." - ".$cntarr;
      */
	 $array_temp[$i] = $new_cpo_nome[$i]; 
     $array_t_value[$i] = $new_cpo_val[$i];
     //
}
//
$cntarr = sizeof($array_temp);
//
?>
