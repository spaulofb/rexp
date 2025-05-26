<?php
/**
*    Sao os campos(dados) enviados de um FORM para o arquivo AJAX
*/
//  Caso sseion_start desativada - Ativar 
if( !isset($_SESSION) ) {
    session_start();
}
//
/**  Conexao MYSQLI  */
$conex = $_SESSION["conex"]; 
//           
//  DEsativando
if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
///
if( isset($_SESSION["bd"]) ) {
    $dbtb = $_SESSION["bd"].".".$_SESSION["tabela"];
    unset($_SESSION["bd"]);
} else {
   $dbtb = $_SESSION["tabela"];    
}
//
//   Select/MYSQLI  
$rsqltb = $conex->query("SELECT * FROM $dbtb limit 1");
if( ! $rsqltb ) {
    die('Select $dbtb - falha: '.mysqli_error($conex)); 
    exit();
}
/**  Nr. de Campos da Tabela  */
$fields = mysqli_num_fields($rsqltb);
//
/**  Nr. de registros  */
$rows   = mysqli_num_rows($rsqltb);
//
//  $table  = mysqli_field_table($rsqltb, 0);


/** Obter informacoes de cada campo da Tabela */
//  $fieldinfo = $rsqltb->fetch_fields();
$fieldinfo = $rsqltb->fetch_fields();
foreach( $fieldinfo as $val ) {
    //
    /** Exibir nome do campo e a tabela associada  */
    $table = $val -> table;
    //
    /** Nome do campo da Tabela  */
    $name  = $val->name;
    //
    //  Tipo do Campo
    $type  = $val->type;
    $name_type[$name]=$type;
    //   
}
/**   Final - foreach( $fieldinfo as $val ) {  */
//


/**  Final - while( $field = $rsqltb->fetch_fields() ) {  */
//





/**  
*     echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
*     echo "The table has the following fields:\n";
*/    
///  Verificando o Tipo do Campo da Tabela
/**
for ($i=0; $i < $fields; $i++) {
    $type  = mysql_field_type($rsqltb, $i);
    $name  = mysql_field_name($rsqltb, $i);
    $len   = mysql_field_len($rsqltb, $i);
    $flags = mysql_field_flags($rsqltb, $i);
    $name_type[$name]=$type;
}
*/
//
$campos=""; $campos_nome=""; $campos_val=""; $campos_valor="";
$_SESSION['campos_total']="";
//
//  DEsativando
if( isset($_SESSION["campos_nome"]) ) {
    unset($_SESSION["campos_nome"]);  
} 
if( isset($_SESSION["campos_valor"]) ) {
    unset($_SESSION["campos_valor"]);  
} 
//


$_SESSION["respx"] =  "ERRO:  LINHA/107  -->> \$fields = $fields <<-->>  \$rows = $rows   <<--";
$_SESSION["respx"] .=  " <br>  \$table = <b> $table</b> \$cntarrtmp = $cntarrtmp  <<--  ";
$_SESSION["respx"] .=  " <br>  \$name = $name  -->>  \$type = $type -->>  ".$name_type[$name];
echo "{$_SESSION["respx"]}";
  exit();




for( $i=0; $i<$cntarrtmp; $i++ ) {
     //
     //  Removendo o campo para confirmar senha
     $uparr=strtoupper(trim($array_temp[$i]));
     if( $uparr=="REDIGITAR_SENHA" ) continue;
     //
     //  NOVO CHEFE
     if( $uparr=="NOVO_CHEFE" ) continue;
     //
     $campos = $array_temp[$i];
     $cpo_val=trim($array_t_value[$i]);
     $campos = (string) $campos;
     //
     //  Campo - Autor 
     $upcpo=strtoupper(trim($campos));      
     if( $upcpo=="AUTOR"  ) {
            $_POST["autor_cod"]=$cpo_val; 
            $_SESSION["autor_cod"]=$cpo_val;
      }
      //
      //  Campo - numero do Projeto
     if( $upcpo=="NUMPROJETO" ) {  
         $_POST["nprojexp"]=$cpo_val; 
         $_SESSION["nprojexp"]=$cpo_val;
     }  
     // 
     //    
     if( $uparr=="SENHA" ) {
           $campos_val = "password("."'$cpo_val'".")";
     } else {
         //
         // Verificando o Tipo do Campo da Tabela
         if( $name_type[$campos]=='int' ) {
               $campos_val= (int) $cpo_val;  
         } 
         //
         if( $name_type[$campos]=='string' ) {
               $campos_val= "'$cpo_val'";
         }
         //
         /**  Modificando o campo  Data do PHP  para o formato Date do Mysql  */
         if( ($name_type[$campos]=='date' or $name_type[$campos]=='datetime')  ) {
               //
               //  Se nao da Tabela pessoal.usuario
              //  Verificando se nao e´ a  Tabela ANOTACAO      
              if( strtoupper(trim($table))!="USUARIO" ) {
                   //  $m_array= array("ANOTACAO","ORIENTADOR","ANOTADOR");
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
      ////
      ////  $_SESSION[campos_total].=$campos."=".$campos_val;
      if( $i<$cntarrtmp ) {
            $campos_nome .= $campos.",";
            $campos_valor .= $campos_val.",";  
            ////  $_SESSION[campos_total].=",";
            $arr_nome_val["$campos"]=$campos_val;
      }
      ///
}
///
$_SESSION["campos_nome"] = substr($campos_nome,0,strlen($campos_nome)-1);
$_SESSION["campos_valor"] = substr($campos_valor,0,strlen($campos_valor)-1);
////    
$_SESSION["campos_valor"]=html_entity_decode(trim($_SESSION["campos_valor"]));  ////  179
////
$cpo_nome=$_SESSION["campos_nome"];
$cpo_valor= $_SESSION["campos_valor"];

if( isset($rsqltb) ) mysql_free_result($rsqltb);
////
?>