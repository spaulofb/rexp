<?php
 //    Dados vindo de um FORM  
 set_time_limit(0);
 /*     
    AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
    e de depois usa o  - html_entity_decode 
 */
 //  Verificando se session_start - ativado ou desativado
if( !isset($_SESSION) ) {
   session_start();
}
///
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

///
$campo_nome = htmlentities(utf8_decode($campo_nome));
$campo_value = htmlentities(utf8_decode($campo_value));
$campo_nome = substr($campo_nome,0,strpos($campo_nome,",$cpo_final"));      
if( strtoupper(trim($cpo_final))=="ALTERAR"  )  {
    ///
     $n_coresp_novo = strpos($campo_nome,",ncoautor_novo");
   
//  $m_echo =  "1) \$n_coresp_novo = $n_coresp_novo - <br> \$campo_nome = $campo_nome <br>";
   
   if(  intval($n_coresp_novo)>0 ) {
      // $campo_nome = substr($campo_nome,0,strpos($campo_nome,",ncoautor[]"));                 
      /// $campo_nome = substr($campo_nome,0,strpos($campo_nome,",ncoautor[")); 
       $campo_nome = substr($campo_nome,0,strpos($campo_nome,",ncoautor"));                  
   }
  /* 
   $array_cpo_nome=explode(",",$campo_nome);
   $m_echo .=  "2) \$n_coresp_novo = $n_coresp_novo - <br> \$campo_nome = $campo_nome <br>";
   
   foreach( $array_cpo_nome as $chave1 => $valor_res ) {
      $m_echo .=  "\r\n  $chave1 =  $valor_res ";  
   }
   
   
   echo $m_echo;
    */
}
//
//  $campo_nome = substr($campo_nome,0,strlen($campo_nome)-1);      
//  array_temp  -  com os nomes dos campos
$array_cpos_nomes = explode(",",$campo_nome);        
//  Contando o numero de campos de dados recebidos
$count_array_nomes = sizeof($array_cpos_nomes);         
$array_value = explode(",",$campo_value);
for( $w=0; $w<$count_array_nomes; $w++ ) $array_valores[]=html_entity_decode(trim($array_value[$w]));
// for( $i=0; $i<$count_array_nomes; $i++ ) $arr_nome_val[$array_cpos_nomes[$i]]=$array_t_value[$i];
$i_codigousp=-1;  
if( isset($campos_nome) ) unset($campos_nome);  
if( isset($campos_valor) )unset($campos_valor); 
$campos_nome="";$campos_valor=""; 
////
for( $i=0; $i<$count_array_nomes; $i++ ) {
          ///
         $valor_incluir = html_entity_decode(trim($array_valores[$i]));
        //  CPF - sem pontos e traco 
        if( strtoupper(trim($array_cpos_nomes[$i]))=="CPF" ) {
            $valor_incluir=trim(preg_replace('/[.-]+/','',$valor_incluir));
        } elseif( preg_match("/data/i",$array_cpos_nomes[$i]) ) {
            $valor_incluir=trim(preg_replace('/[.\/]+/','-',$valor_incluir));    
            $valor_incluir=substr($valor_incluir,6,4)."-".substr($valor_incluir,3,2)."-".substr($valor_incluir,0,2);            
        } 
        ////
        $arr_nome_val[$array_cpos_nomes[$i]]=$valor_incluir;   
        // Salvando a posi??o do campo codigousp para criar codigo <0 para usuario de fora da USP
        if (strtoupper(trim($array_cpos_nomes[$i]))=="CODIGOUSP") $i_codigousp=$i;
         //  Incluindo nas variaveis campos_nome e campos_valor
        if( intval($i)<$count_array_nomes ) { 
             $campos_nome .= trim($array_cpos_nomes[$i]).",";
             $campos_valor .= $valor_incluir.",";  
            //  $_SESSION[campos_total].=",";
        }     
    
}
//  $_SESSION[campos_total] = substr($_SESSION[campos_total],0,strlen($_SESSION[campos_total])-1);
$_SESSION["campos_nome"] = substr($campos_nome,0,strlen($campos_nome)-1);
$_SESSION["campos_valor"] = substr($campos_valor,0,strlen($campos_valor)-1);
//    
//  $_SESSION[campos_total]=utf8_decode($_SESSION[campos_total]); //  Total deu 186 caracteres
//  $_SESSION[campos_total]=urldecode($_SESSION[campos_total]);   //  Total deu 186 caracteres
//  MELHOR MANEIRA DE CONSERTAR ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
//  $_SESSION[campos_total]=html_entity_decode(trim($_SESSION[campos_total]));  //  179
$_SESSION["campos_valor"]=html_entity_decode(trim($_SESSION["campos_valor"]));  //  179
//
$cpo_nome=$_SESSION["campos_nome"];
$cpo_valor= $_SESSION["campos_valor"];
//
if( isset($result_tabela) ) mysql_free_result($result_tabela);
$_SESSION["i_codigousp"]= (int) $i_codigousp;

$_SESSION["nomes_cpos"]= $campos_nome."+++++".$count_array_nomes."---".count($array_valores);

///
?>