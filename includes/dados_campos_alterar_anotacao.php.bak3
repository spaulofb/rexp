<?php
///    Dados vindo de um FORM  
 set_time_limit(0);
 /*     
      AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
         e de depois usa o  - html_entity_decode 
 */
///  Verificando se session_start - ativado ou desativado
if( !isset($_SESSION) ) {
   session_start();
}
//
$campo_nome = htmlentities(utf8_decode($campo_nome));
$campo_value = htmlentities(utf8_decode($campo_value));
$campo_nome = substr($campo_nome,0,strpos($campo_nome,",$cpo_final"));      
///
///  $campo_nome = substr($campo_nome,0,strlen($campo_nome)-1);      
///    array_temp  -  com os nomes dos campos
$array_temp = explode(",",$campo_nome);        
///  Contando o numero de campos de dados recebidos
$count_array_temp = sizeof($array_temp);         
$array_value = explode(",",$campo_value);
for( $w=0; $w<$count_array_temp; $w++ ) $array_t_value[]=html_entity_decode(trim($array_value[$w]));
/// for( $i=0; $i<$count_array_temp; $i++ ) $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
$i_codigousp =-1;  unset($campos_nome);  unset($campos_value); 
$campos_nome="";$campos_value=""; 
for( $i=0; $i<$count_array_temp; $i++ ) {
        $val_incluir = html_entity_decode(trim($array_t_value[$i]));
        ///
        ///  CPF - sem pontos e traco 
        if( strtoupper(trim($array_temp[$i]))=="CPF" ) {
            $val_incluir=trim(preg_replace('/[.-]+/','',$val_incluir));
        } elseif( preg_match("/data/i",$array_temp[$i]) ) {
           $pos_encontradas=preg_match("/[-]+/",$array_temp[$i]);  
           if( $pos_encontradas<0 ) {
                 $val_incluir=trim(preg_replace('/[.\/]+/','-',$val_incluir));    
                 $val_incluir=substr($val_incluir,6,4)."-".substr($val_incluir,3,2)."-".substr($val_incluir,0,2);            
           }
        } 
        $arr_nome_val[$array_temp[$i]]=$val_incluir;   
        /// Salvando a posi??o do campo codigousp para criar codigo <0 para usuario de fora da USP
        if (strtoupper(trim($array_temp[$i]))=="CODIGOUSP") $i_codigousp=$i;
        //  Incluindo nas variaveis campos_nome e campos_valor
        if( $i<$count_array_temp ) { 
            $campos_nome .= trim($array_temp[$i]).",";
            $campos_value .= $val_incluir.",";  
            ///  $_SESSION[campos_total].=",";
        }  
}
///
$_SESSION["campos_nome"] = substr($campos_nome,0,strlen($campos_nome)-1);
$_SESSION['campos_value'] = substr($campos_value,0,strlen($campos_value)-1);
///
$_SESSION["i_codigousp"]= (int) $i_codigousp;
///
?>
