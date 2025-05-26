<?php
/**
 *   Sao os campos(dados) enviados de um FORM para o arquivo AJAX
 */
//  Verificando se sseion_start - ativado ou desativado
if( !isset($_SESSION) ) {
   session_start();
}
//
//
/**     Verificar a Mensagem de Erro  
 *  Crucial ter as configurações de erro ativadas
*/ 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//
/**
*          IMPORTANTE
*      Alterado em 20200116
*   function para definir Type/Tipo do campo da Tabela
*/
if( ! function_exists("getColumnDataType") ) {    
///     
    function getColumnDataType($info) {
         ///
        ///  DEFAULT DATA TYPES
        $mysql_data_type_hash = array(
        1=>'tinyint',
        2=>'smallint',
        3=>'int',
        4=>'float',
        5=>'double',
        7=>'timestamp',
        8=>'bigint',
        9=>'mediumint',
        10=>'date',
        11=>'time',
        12=>'datetime',
        13=>'year',
        16=>'bit',
        //252 is currently mapped to all text and blob types (MySQL 5.0.51a)
        253=>'varchar',
        254=>'char',
        246=>'decimal'
        );
        ///
        return $mysql_data_type_hash[$info];
        ///
    }
    ///
}
/***   Final  -  function getColumnDataType($info) {  */
//
//  Conexao MYSQLI
$conex = $_SESSION["conex"];
//
//  Banco de Dados/DB
if( isset($_SESSION["bd"]) ) {
    $session_tabela = $_SESSION["bd"].".".$_SESSION["tabela"];
    unset($_SESSION["bd"]);
} else {
   $session_tabela = $_SESSION["tabela"];    
}
// 
//  Select/MYSQLI
$proc="SELECT * FROM  $session_tabela limit 1 ";
$result_tabela = mysqli_query($conex,"$proc");
if( ! $result_tabela ) {
    die('Select '.$session_tabela.' - falha: '.mysqli_error($conex));
    exit();
}
/**  FInal - if( ! $result_tabela ) {  */
//
//  Nr. de Campos
$fields = mysqli_num_fields($result_tabela);
//
//  Nr. de Registros
$rows   = mysqli_num_rows($result_tabela);
//
//   Obtem informacoes do primeiro campo
//  $table  = mysql_field_table($result_tabela, 0);
//
// Obtém o tipo de dados como string
/**
*    $tipo_campo = getColumnDataType($tbcpotype); 
*    echo "ERRO: LINHA/85  -->>     Tipo de dados do campo 'idade': <b>" . $tipo_campo."</b>";
*    exit();
*/    

/**  echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
*    echo "The table has the following fields:\n";
*/	
///  Verificando o Tipo do Campo da Tabela
If( isset($name_type) ) unset($name_type);
for( $i=0; $i < $fields; $i++ ) {
    //
    //  Campo 
    $xfield = mysqli_fetch_field_direct($result_tabela, $i); 
    $table  = $xfield->table;
    //
    //   Nome do Campo
    $name = $xfield->name;
    //
    //   Tipo do Campo
    // $tbcpotype=$table->type;
    $type=$xfield->type;
    $tbcpotype = getColumnDataType($type); 
    //
    /** 
    $type  = mysql_field_type($result_tabela, $i);
    $name  = mysql_field_name($result_tabela, $i);
    $len   = mysql_field_len($result_tabela, $i);
    $flags = mysql_field_flags($result_tabela, $i);
    */
    //
	$name_type[$name]=$tbcpotype;
    //  echo $type . " " . $name . " " . $len . " " . $flags . "\n";
    //
}
/**  FInal - for( $i=0; $i < $fields; $i++ ) {   */
//
$campos=""; $campos_nome=""; $campos_val=""; $campos_valor="";
$_SESSION['campos_total']="";
//
//  DESATIVANDO
if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
//
//    
/** 
 *     Arrays dos Types de Tabela Mysqli - numeric, string, boolean   etc...
 */
//    Numeric Data Types
$nm_array = array("INT", "TINYINT",  "SMALLINT", "MEDIUMINT", "BIGINT", "FLOAT", "DOUBLE", "DECIMAL");
//    Date and Time Types
$dt_array = array("DATE", "DATETIME", "TIMESTAMP", "TIME", "YEAR");
//    String Types
$tx_array = array("CHAR",  "VARCHAR", "BLOB",  "TEXT",  "TINYBLOB",  "TINYTEXT",  
                  "MEDIUMBLOB",  "MEDIUMTEXT", "LONGBLOB",  "LONGTEXT", "ENUM");     
///   Boolean
$bo_array = array("boolean");
//
$_SESSION["mensagerro"]="ERRO: ";
for( $i=0; $i<$count_array_temp; $i++ ) {
     //
     //  Removendo o campo para confirmar senha
     if( isset($array_temp[$i]) ) {
         //
         if( trim(strtoupper($array_temp[$i]))=="REDIGITAR_SENHA" ) continue;    
         //
         ///  Novo Chefe
         if( trim(strtoupper($array_temp[$i]))=="NOVO_CHEFE" ) continue;
         //
     } else {
         continue;
     }
     ///
     $campos = $array_temp[$i];
     $cpo_val=trim($array_t_value[$i]);
	 $campos = (string) $campos;
     //
     /**   TIpo do Campo - formato Maiusculo  */
     $ntyc="";
     if( strtoupper($name_type[$campos]) ) {
          $ntyc=strtoupper($name_type[$campos]);
      }
      //
     ///  Campo - Autor 
     if( strtoupper($campos)=="AUTOR"  ) {
            $_POST["autor_cod"]=$cpo_val; 
            $_SESSION["autor_cod"]=$cpo_val;
     }
     /**  Final - if( strtoupper($campos)=="AUTOR"  ) {  */
     //
     //
     //  Campo - numero do Projeto
     if( strtoupper($campos)=="NUMPROJETO" ) {  
         //
         $_POST["nprojexp"]=$cpo_val; 
         $_SESSION["nprojexp"]=$cpo_val;
     }
     //   
     ///    
	  if( trim(strtoupper($array_temp[$i]))=="SENHA" ) {
	       $campos_val = "password("."'$cpo_val'".")";
	  } else {
          //
	      //   if( $name_type[$campos]=='string' ) {
          if( in_array($ntyc,$tx_array) ) {    
              //
              //  $campos_val= "'$cpo_val'";
              //  clean_spaces - procedure do MySql  - limpar espacos
               $campos_val= "mysql.clean_spaces('$cpo_val') ";
               //

		  }  elseif( $ntyc=='INT' ) {
                 //  Campo Numerico
                 $campos_val= (int) $cpo_val;  
          }  elseif( $ntyc=='DECIMAL' or $ntyc=='DECIMAL' or $ntyc=='DOUBLE'  ) {
                 //
                 $campos_val= $cpo_val;  
          }
          //
          /**  Nome do Campo em Maiuscula  */
          $stt=strtoupper(trim($table));
          //
    	  /**  Modificando o campo  DATA do PHP  para o formato Date do Mysqli   */
	    /**  if( ($name_type[$campos]=='date' or $name_type[$campos]=='datetime')  ) {  */
          if( ( $ntyc=='DATE' or $ntyc=='DATETIME')  ) {    
              //
              //  Se nao da Tabela pessoal.usuario
              //  Verificando se nao e? a  Tabela ANOTACAO      
              //  if( $stt!="USUARIO" and $stt!="PROJETO" ) {
              if( $stt!="USUARIO" ) {
                  //
                  //  $m_array= array("ANOTACAO","ORIENTADOR","ANOTADOR");
                  $m_array= array("ANOTACAO","ORIENTADOR");
                  //  if( strtoupper($val)!="ANOTACAO"  ) {
                  //
                  if( strlen($cpo_val)>=10 ) {
                       //
                       $posbarra=strpos($cpo_val,"/");
                       $postraco=strpos($cpo_val,"-");
                       if( intval($posbarra)==2 or intval($postraco)==2 ) {
                           $cpo_val=substr($cpo_val,6,4)."-".substr($cpo_val,3,2)."-".substr($cpo_val,0,2);
                       }
                       //
                  }
                  /**  Final - if( strlen($cpo_val)>=10 ) {  */
                  //

                  /**  
echo "ERRO: LINHA233 -->> \$val = $val <<-->>  \$ntyc = $ntyc   ";
exit();
   */

                  if( in_array(strtoupper($val),$m_array) ) {
                      //
                      $timestampInSeconds = $_SERVER['REQUEST_TIME'];
                      if( $name_type[$campos]=='datetime' ) {   
                           $cpo_val=date("Y-m-d H:i:s", $timestampInSeconds);    
                      }
                      // 
                  }
                  //
              }
              /**  Final - if( $stt!="USUARIO"  and $stt!="PROJETO" ) {   */
              //

              ///
              $campos_val= "'$cpo_val'";                   
              //
		  }
          /**  Final - if( ( $ntyc=='DATE' or $ntyc=='DATETIME')  ) {   */
          //		
	  }	 
	  //
	  //  $_SESSION[campos_total].=$campos."=".$campos_val;
	  if( $i<$count_array_temp ) {
          //
	      $campos_nome .= $campos.",";
	      $campos_valor .= $campos_val.",";  
		  ///  $_SESSION[campos_total].=",";
          $arr_nome_val["$campos"]=$campos_val;
          //
	  }
      /**  Final - if( $i<$count_array_temp ) {  */
      //
}
/**  Final - for( $i=0; $i<$count_array_temp; $i++ ) {  */
//
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

/**          
  echo "ERRO: LINHA/215   -->>  \$stt = $stt -->> \$_SESSION[campos_nome] = {$_SESSION["campos_nome"]} <br>"
           ."\$_SESSION[campos_valor] = {$_SESSION["campos_valor"]}  ";
  exit();          
*/          

//  Desativar Variavel
if( isset($result_tabela) ) {
      unset($result_tabela);  
} 
/**  Final - if( isset($result_tabela) ) {  */
//

/** 

$_SESSION["xres"].="ERRO: REQUIRE_ONCE147 -->> ANTES DO <<--  \$fields = $fields  <<-->>  \$rows = $rows  <<--  ";
return;

 */

//
?>
