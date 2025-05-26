<?php
//   Sao os campos(dados) enviados de um FORM para o arquivo AJAX
//
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//  Dados vindo do FORMULARIO e criando arrays
$m_erro=0;
if( isset($array_temp) ) unset($array_temp); 
if( isset($array_t_value) ) unset($array_t_value);
if( isset($count_array_temp) ) unset($count_array_temp);
if( isset($arr_nome_val) ) unset($arr_nome_val);
//
$cpo_final="cancelar";
/* A \b no padrão indica um limite de palavra, portanto, apenas as distintas
  * A palavra "web" é correspondida, e nem uma palavra parcial como "webbing" ou "cobweb" 
       mas aceita simbolos como ,web,   ,web 
*/
if( preg_match("/\bweb\b/i",$cpo_final) ) {
    $campo_nome = substr($campo_nome,0,strpos($campo_nome,",$cpo_final"));      
}
//
//  $campo_nome = htmlentities(utf8_decode($campo_nome));
//  $campo_value = htmlentities(utf8_decode($campo_value));


//  $campo_nome = substr($campo_nome,0,strlen($campo_nome)-1);      
//  array_temp  -  com os nomes dos campos
$array_temp = explode(",",$campo_nome);        
//  Contando o numero de campos de dados recebidos
$count_array_temp = sizeof($array_temp); 
$array_value = explode(",",$campo_value);
// for( $w=0; $w<$count_array_temp; $w++ ) $array_t_value[]=html_entity_decode(trim($array_value[$w]));
for( $w=0; $w<$count_array_temp; $w++ ) $array_t_value[]=utf8_decode(trim($array_value[$w]));
//  $array_t_value=utf8_decode_all($array_value);
//  $array_t_value[]=html_entity_decode(trim($array_value[$w]));
for( $i=0; $i<$count_array_temp; $i++ ) $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
//  Final criando arrays  
//
//  DEsativando
if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
//
$session_tabela = $_SESSION["tabela"];
$result_tabela = mysql_query("SELECT * FROM  {$_SESSION["bd_1"]}.$session_tabela limit 1");
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
$nome_cpo_coord_ou_orient="";
// Verificando o Tipo do Campo da Tabela
for ($i=0; $i < $fields; $i++) {
    $type  = mysql_field_type($result_tabela, $i);
    $name  = mysql_field_name($result_tabela, $i);
    if( preg_match("/^projeto$/i",$session_tabela) ) {
        if( preg_match("/(orientador|coordenador)/i",$name)  ) {
            $nome_cpo_coord_ou_orient=$name;
        }
    }
    $len   = mysql_field_len($result_tabela, $i);
    $flags = mysql_field_flags($result_tabela, $i);
	$name_type[$name]=$type;
    //  echo $type . " " . $name . " " . $len . " " . $flags . "\n";
}
//
//
$campos=""; $campos_nome=""; $campos_val=""; $campos_valor="";
$_SESSION['campos_total']="";
//
//  Alterando o Array $array_temp - Como:  orientador|coordenador
if( preg_match("/^projeto$/i",$session_tabela) ) {
    for( $oc=0; $oc<$count_array_temp; $oc++ ) {
        if( preg_match("/(orientador|coordenador)/i",$array_temp[$oc])  ) {
             $array_temp[$oc]=$nome_cpo_coord_ou_orient;
        }
    }
}
//
for( $i=0; $i<$count_array_temp; $i++ ) {
      //  Removendo o campo para confirmar senha
      if( trim(strtoupper($array_temp[$i]))=="REDIGITAR_SENHA" ) continue;
      if( preg_match("/M_SALVAR/i",trim(strtoupper($array_temp[$i]))) ) continue;
      if( preg_match("/M_CANCELAR/i",trim(strtoupper($array_temp[$i]))) ) continue;
      if( preg_match("/M_FORNECEDOR|situacaoatual|m_botao_atributo/i",trim(strtoupper($array_temp[$i]))) ) continue;
      $campos = $array_temp[$i];
      $cpo_val=$array_t_value[$i];
	  $campos = (string) $campos;
	  if( trim(strtoupper($array_temp[$i]))=="SENHA" ) {
	       //  $campos_val = "password("."'$cpo_val'".")";
           $cpo_val=sha1($cpo_val);
           $campos_val = "trim("."'$cpo_val'".")";
	  } else  {
	       // Verificando o Tipo do Campo da Tabela
	       if( $name_type[$campos]=='string' ) {
              //  $cpo_val=utf8_decode($cpo_val);
              //  clean_spaces - procedure para limpar espacos duplicados
              $campos_val= "clean_spaces('$cpo_val') ";
              //
		   } elseif( $name_type[$campos]=='int' ) {
              $campos_val= (int) $cpo_val;  
           } 
		   //  Modificando o campo  Data do PHP  para o formato Date do Mysql
		   if( ($name_type[$campos]=='date' or $name_type[$campos]=='datetime')  ) {
              //  Verificando se nao e´ a  Tabela ANOTACAO e NAO e´ a PROJETO     
              if( strtoupper(trim($table))!="USUARIO" and strtoupper(trim($table))!="PROJETO" ) {
                   //  $m_array= array("ANOTACAO","ORIENTADOR","ANOTADOR");
                   $m_array= array("ANOTACAO","ORIENTADOR");
                   //  if( strtoupper($val)!="ANOTACAO"  ) {
                   $cpo_val=substr($cpo_val,6,4)."-".substr($cpo_val,3,2)."-".substr($cpo_val,0,2);
                   //  if( in_array(strtoupper($val),$m_array) ) {
                   if( in_array($val,$m_array) ) {
                       $timestampInSeconds = $_SERVER['REQUEST_TIME'];
                       if( $name_type[$campos]=='datetime' ) $cpo_val=date("Y-m-d H:i:s", $timestampInSeconds);  
                   }
              } elseif( strtoupper(trim($table))=="PROJETO" and $name_type[$campos]=='date' ) {
                      if( strlen(trim($cpo_val))<3 ) {
                         $cpo_val='0000-00-00';
                     } elseif( strlen(trim($cpo_val))>=3 ) {
                         $cpo_val=implode("-",array_reverse(explode("/",$cpo_val)));
                     }        
              } 
              $campos_val= "'$cpo_val'";                   
		   }		
		   //  if( $name_type[$campos]=='datetime') $campos_val= "'$cpo_val'";
	  }	 
	  //
	  //  $_SESSION[campos_total].=$campos."=".$campos_val;
	  if( $i<$count_array_temp ) {
	        $campos_nome .= $campos.",";
			$campos_valor .= $campos_val.",";  
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
//
?>