<?php
//   Sao os campos(dados) enviados de um FORM para o arquivo AJAX
//
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//
$result_tabela = mysql_query("SELECT * FROM ".$_SESSION["tabela"]."   limit 1");
if( ! $result_tabela ) {
    mysql_free_result($result_tabela);
   die('Sem resultado - Select - falha: '.mysql_error());
   exit();
}
$fields = mysql_num_fields($result_tabela);
$rows   = mysql_num_rows($result_tabela);
$table  = mysql_field_table($result_tabela, 0);
/*  echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
    echo "The table has the following fields:\n";
*/	
// Verificando o Tipo do Campo da Tabela
for ($i=0; $i < $fields; $i++) {
    $type  = mysql_field_type($result_tabela, $i);
    $name  = mysql_field_name($result_tabela, $i);
    $len   = mysql_field_len($result_tabela, $i);
    $flags = mysql_field_flags($result_tabela, $i);
	$name_type[$name]=$type;
    //  echo $type . " " . $name . " " . $len . " " . $flags . "\n";
}
//
$campos=""; $campos_val="";
$_SESSION["campos_total"]="";
for( $i=0; $i<$count_array_temp; $i++ ) {
      //  Removendo o campo para confirmar senha
      if( trim(strtoupper($array_temp[$i]))=="REDIGITAR_SENHA" ) continue;
      $campos = $array_temp[$i];
      $cpo_val=$array_t_value[$i];
	  $campos = (string) $campos;
	  if( trim(strtoupper($array_temp[$i]))=="SENHA" ) {
	       $campos_val = "password("."'$cpo_val'".")";
	  } else  {
	       // Verificando o Tipo do Campo da Tabela
           if( $name_type[$campos]=='int' ) $campos_val= (int) $cpo_val;
	       if( $name_type[$campos]=='string' ) $campos_val= "'$cpo_val'";
		   if( $name_type[$campos]=='date') $campos_val= "'$cpo_val'";
		   if( $name_type[$campos]=='datetime') $campos_val= "'$cpo_val'";
	  }	 
	  //
	  $_SESSION["campos_total"].=$campos."=".$campos_val;
	  if( $i<$count_array_temp ) {
	           /* $campos .=",";
			      $campos_val.=",";  */
				  $_SESSION["campos_total"].=",";
	  }
}
$_SESSION["campos_total"] = substr($_SESSION["campos_total"],0,strlen($_SESSION["campos_total"])-1);
//	
//  $_SESSION["campos_total"]=utf8_decode($_SESSION["campos_total"]); //  Total deu 186 caracteres
//  $_SESSION["campos_total"]=urldecode($_SESSION["campos_total"]);   //  Total deu 186 caracteres
//  MELHOR MANEIRA DE CONSERTAR ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
$_SESSION["campos_total"]=html_entity_decode(trim($_SESSION["campos_total"]));  //  179
//
mysql_free_result($result_tabela);
//
?>