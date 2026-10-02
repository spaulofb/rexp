<?php
//  Pasta cadastrar
//  Dados recebido do FORM
    /** 
    *     AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
	*	 e de depois usa o  - html_entity_decode 
    */
	 $campo_nome = htmlentities(mb_convert_encoding($campo_nome, 'ISO-8859-1', 'UTF-8'));
	 $campo_value = htmlentities(mb_convert_encoding($campo_value, 'ISO-8859-1', 'UTF-8'));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp); 
	 for( $i=0; $i<$count_array_temp; $i++ ) {
             $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
	 } 
	 //
?>