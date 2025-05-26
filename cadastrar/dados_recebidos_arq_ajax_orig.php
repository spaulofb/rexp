<?php
//   Sao os campos(dados) enviados de um FORM para o arquivo AJAX
//
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//
//  DEsativando
if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
///
if( isset($_SESSION["bd"]) ) {
    $session_tabela = $_SESSION["bd"].".".$_SESSION["tabela"];
    unset($_SESSION["bd"]);
} else {
   $session_tabela = $_SESSION["tabela"];    
}
///
$result_tabela = mysql_query("SELECT * FROM ".$session_tabela." limit 1");
if( ! $result_tabela ) {
    die('Select '.$session_tabela.' - falha: '.mysql_error());
    exit();
}

$fields = mysql_num_fields($result_tabela);
$rows   = mysql_num_rows($result_tabela);
$table  = mysql_field_table($result_tabela, 0);
/*  echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
    echo "The table has the following fields:\n";
*/	
///  Verificando o Tipo do Campo da Tabela
for ($i=0; $i < $fields; $i++) {
    $type  = mysql_field_type($result_tabela, $i);
    $name  = mysql_field_name($result_tabela, $i);
    $len   = mysql_field_len($result_tabela, $i);
    $flags = mysql_field_flags($result_tabela, $i);
	$name_type[$name]=$type;
    //  echo $type . " " . $name . " " . $len . " " . $flags . "\n";
}
///
$campos=""; $campos_nome=""; $campos_val=""; $campos_valor="";
$_SESSION['campos_total']="";
//  DEsativando
if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
///
$_SESSION["mensagerro"]="ERRO: ";
for( $i=0; $i<$count_array_temp; $i++ ) {
      //  Removendo o campo para confirmar senha
      if( trim(strtoupper($array_temp[$i]))=="REDIGITAR_SENHA" ) continue;
      ///  Novo Chefe
      if( trim(strtoupper($array_temp[$i]))=="NOVO_CHEFE" ) continue;
      ///
      $campos = $array_temp[$i];
      $cpo_val=trim($array_t_value[$i]);
	  $campos = (string) $campos;
      ///  Campo - Autor 
      if( strtoupper($campos)=="AUTOR"  ) {
            $_POST["autor_cod"]=$cpo_val; 
            $_SESSION["autor_cod"]=$cpo_val;
      }
      ///  Campo - numero do Projeto
     if( strtoupper($campos)=="NUMPROJETO" ) {  
            $_POST["nprojexp"]=$cpo_val; 
            $_SESSION["nprojexp"]=$cpo_val;
     }   
     ///    
	  if( trim(strtoupper($array_temp[$i]))=="SENHA" ) {
	       $campos_val = "password("."'$cpo_val'".")";
	  } else  {
	       // Verificando o Tipo do Campo da Tabela
           if( $name_type[$campos]=='int' ) $campos_val= (int) $cpo_val;
	       if( $name_type[$campos]=='string' ) {
                    ///  $campos_val= "'$cpo_val'";
                   ///  clean_spaces - procedure do MySql  - limpar espacos
                    $campos_val= "clean_spaces('$cpo_val') ";
			}
		   //  Modificando o campo  Data do PHP  para o formato Date do Mysql
		   if( ($name_type[$campos]=='date' or $name_type[$campos]=='datetime')  ) {
		       //  Se nao da Tabela pessoal.usuario
              //  Verificando se nao e? a  Tabela ANOTACAO      
              if( strtoupper(trim($table))!="USUARIO" ) {
                    ///  $m_array= array("ANOTACAO","ORIENTADOR","ANOTADOR");
                    $m_array= array("ANOTACAO","ORIENTADOR");
                    ///  if( strtoupper($val)!="ANOTACAO"  ) {
                   
                    if( strlen($cpo_val)>=10 ) {
                         $posbarra=strpos($cpo_val,"/");
                         $postraco=strpos($cpo_val,"-");
                         if( intval($posbarra)==2 or intval($postraco)==2 ) {
                              $cpo_val=substr($cpo_val,6,4)."-".substr($cpo_val,3,2)."-".substr($cpo_val,0,2);
                         }
                    }
                    //
                    if( in_array(strtoupper($val),$m_array) ) {
                        $timestampInSeconds = $_SERVER['REQUEST_TIME'];
                        if( $name_type[$campos]=='datetime' ) $cpo_val=date("Y-m-d H:i:s", $timestampInSeconds);  
                    }
                  
              }
              ///
              $campos_val= "'$cpo_val'";                   
		   }		
		   //  if( $name_type[$campos]=='datetime') $campos_val= "'$cpo_val'";
	  }	 
	  //
	  //  $_SESSION[campos_total].=$campos."=".$campos_val;
	  if( $i<$count_array_temp ) {
	        $campos_nome .= $campos.",";
			$campos_valor .= $campos_val.",";  
			////  $_SESSION[campos_total].=",";
            $arr_nome_val["$campos"]=$campos_val;
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
///
$cpo_nome=$_SESSION["campos_nome"];
$cpo_valor= $_SESSION["campos_valor"];
///
if( isset($result_tabela) ) mysql_free_result($result_tabela);
////
?>