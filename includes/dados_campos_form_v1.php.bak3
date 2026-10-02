<?php
//    Dados vindo de um FORM 
set_time_limit(0);
/*     
     AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
      e de depois usa o  - html_entity_decode 
*/
$campo_nome = htmlentities(utf8_decode($campo_nome));
$campo_value = htmlentities(utf8_decode($campo_value));
$campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));      

////  array_temp  -  com os nomes dos campos
$array_temp = explode(",",$campo_nome);        
//  Contando o numero de campos de dados recebidos
$count_array_temp = sizeof($array_temp);         
$array_value = explode(",",$campo_value);
for( $w=0; $w<$count_array_temp; $w++ ) {
      $array_t_value[]=html_entity_decode(trim($array_value[$w]));  
} 
// for( $i=0; $i<$count_array_temp; $i++ ) $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
$i_codigousp =-1;
for( $i=0; $i<$count_array_temp; $i++ ) {
    //
    //  Caso o campo for redigitar_senha
    if (strtoupper(trim($array_temp[$i]))=="REDIGITAR_SENHA") continue;
    $arr_nome_val[$array_temp[$i]]=html_entity_decode(trim($array_t_value[$i]));   
    //
    /** Salvando a posi??o do campo codigousp para criar codigo <0 para usuario de fora da USP  */
    if (strtoupper(trim($array_temp[$i]))=="CODIGOUSP") $i_codigousp=$i;
    //   
}
?>
