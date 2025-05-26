<?php
//  Pasta cadastrar
//  Dados recebido do FORM
    /** 
    *     AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
	*	 e de depois usa o  - html_entity_decode 
    */
	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp); 
	 for( $i=0; $i<$count_array_temp; $i++ ) {
             $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
	 } 
	 //
?>