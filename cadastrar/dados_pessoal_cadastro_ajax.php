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
///
///  Dados vindo do FORMULARIO e criando arrays
$m_erro=0;
if( isset($array_temp) ) unset($array_temp); 
if( isset($array_t_val) ) unset($array_t_val);
if( isset($count_array_temp) ) unset($count_array_temp);
if( isset($arr_nome_val) ) unset($arr_nome_val);
///
$cpo_final="cancelar";
///
/*** A \b no padr?o indica um limite de palavra, portanto, apenas as distintas
  * A palavra "web" ? correspondida, e nem uma palavra parcial como "webbing" ou "cobweb" 
       mas aceita simbolos como ,web,   ,web 
***/
///
if( preg_match("/\bweb\b/i",$cpo_final) ) {
    $campo_nome = substr($campo_nome,0,strpos($campo_nome,",$cpo_final"));      
}
//
/**  $campo_nome = substr($campo_nome,0,strlen($campo_nome)-1);  */    
//  array_temp  -  com os nomes dos campos
$array_temp = explode(",",$campo_nome);        
///
/***   ATUALIZADO EM  20250127
*    Contando o numero de campos de dados recebidos
*  $count_array_temp = sizeof($array_temp);
*/
$cntarr = sizeof($array_temp);
//
/// $campo_value = utf8_decode($campo_value);  
$campo_value = "{$campo_value}";  
//
//  $campo_value =  $campo_value; 
$array_value = explode(",",$campo_value);
//
//  
for( $w=0; $w<$cntarr; $w++ ) {
    $array_t_val[] = trim($array_value[$w]);   
}
/**  Final - for( $w=0; $w<$cntarr; $w++ ) {  */
//  
///  DEsativando
if( isset($_SESSION["campos_nome"]) ) {
      unset($_SESSION["campos_nome"]);  
} 
if( isset($_SESSION["campos_valor"]) ) {
     unset($_SESSION["campos_valor"]);  
} 
///
///  Banco de Dados - BD/DB
if( ! isset($_SESSION["bd_1"]) ) {
    echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
    exit();
}
$bd_1 = $_SESSION["bd_1"];   
///
/**
if( isset($_SESSION["bd"]) ) {
    $dbtb = $_SESSION["bd"].".".$_SESSION["tabela"];
    unset($_SESSION["bd"]);
} else {
   $dbtb = $_SESSION["tabela"];    
}
*/
/**  Verificar Tabela principal   */
if( ! isset($_SESSION["tabela"]) ) {
    echo $funcoes->mostra_msg_erro("Falha na Tabela principal - corrigir.");    
    exit();
}
$tabela = $_SESSION["tabela"];   
//
///  Select/MySQLI  
$txt="SELECT * FROM  {$bd_1}.$tabela limit 1";
$rsql = mysqli_query($_SESSION["conex"],"$txt");
//  if( ! $rsql ) {
if( mysqli_error($_SESSION["conex"]) ) {    
     //     
     //  die('Select '.$tabela.' - falha: '.mysql_error());
     $_SESSION["erro"] = "Select $tabela  - db/mysqli:&nbsp;".mysqli_error($conex);
     return;
     //
}
//
//   Campos da Tabela 
$fields = mysqli_num_fields($rsql);
//
//   Nr. Registros
$rows   = mysqli_num_rows($rsql);
//
//     Nome da Tabela
//  $table  = mysqli_field_table($rsql, 0);
$fieldinfo=mysqli_fetch_field_direct($rsql,0);
$table  = $fieldinfo->table;
///
$nome_cpo_coord_ou_orient="";
///
///  Mostrar a estrutura dos campos da Tabela
$query = "DESCRIBE {$bd_1}.$tabela ";
$result = mysqli_query($_SESSION["conex"],$query);
/// Verifica
if( mysqli_error($_SESSION["conex"]) ) {     
    //     
    $terr="Falha no select da Tabela principal - db/Mysqli:&nbsp;".mysqli_error($conex); 
    ////$_SESSION["erro"] =  $funcoes->mostra_msg_erro("$txt".mysqli_error($_SESSION["conex"]));
    $_SESSION["erro"] = "$terr";    
    ///
    return;
}
///
/** IMPORTANTE:  mysqli_fetch_array para dois campos (codigo,descricao)  */
$xecho = "";
//
while( $row = $result->fetch_array() )  {
       ///
       $name  = $row['Field'];
       $xtype  =  $row['Type'];
       ////  $type  =   substr($xtype,0,strpos($xtype,'('));
       ///
       /// IMPORTANTE:  Ex.1
       $nrpos=strpos($xtype,'(');
       if( $nrpos ) {
           $type = substr($xtype,0,$nrpos);
       } else {
           $type=$xtype;
       }
       /// 
       /// IMPORTANTE:  Ex.2
       /***
       $busca="\(";
       $type = $xtype;
       ///  Caso TYPE encontrado simbolo ( 
       if( preg_match("/$busca/ui",$xtype) ) {
           $type = substr($xtype,0,strpos($xtype,'('));      
       }
       ****/
       $name_type[$name]=$type;
       ///                           
}
/**   Final - while( $row = $result->fetch_array() )  {  */
//
$campos=""; $campos_nome=""; 
$campos_val=""; $campos_valor="";
$_SESSION['campos_total']="";
//
//
/** Arrays dos Types de Tabela Mysqli - numeric, string, boolean   etc...  */
//    Numeric Data Types
$nm_array = array("INT", "TINYINT",  "SMALLINT", "MEDIUMINT", "BIGINT", "FLOAT", "DOUBLE", "DECIMAL");
//
//    Date and Time Types
$dt_array = array("DATE", "DATETIME", "TIMESTAMP", "TIME", "YEAR");
//
//    String Types
$tx_array = array("CHAR",  "VARCHAR", "BLOB",  "TEXT",  "TINYBLOB",  "TINYTEXT",  
                  "MEDIUMBLOB",  "MEDIUMTEXT", "LONGBLOB",  "LONGTEXT", "ENUM");     
//
//   Boolean
$bo_array = array("boolean");




/**
echo "ERRO: LINHA/176-->> \$bd_1  = $bd_1  <<-->>  \$array_temp = ".count($array_temp)
    ."  <<-->> \$array_value = ".count($array_value)."  -->> \$rows = $rows ";
exit();
     */



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

for( $i=0; $i<$cntarrtmp; $i++ ) {
     //
     //  Removendo o campo para confirmar senha
     $uparr=strtoupper(trim($array_temp[$i]));
     if( $uparr=="REDIGITAR_SENHA" ) continue;
     //
     //  NOVO CHEFE
     if( $uparr=="NOVO_CHEFE" ) continue;
     //
     //  Removendo o campo para confirmar senha
     if( preg_match("/M_SALVAR/i",$uparr) ) continue;
     if( preg_match("/M_CANCELAR/i",$uparr) ) continue;
     $ar_tmp=trim(strtoupper($array_temp[$i]));
     if( preg_match("/M_FORNECEDOR|situacaoatual|m_botao_atributo/ui",$ar_tmp) ) continue;
     //
     $campos = $array_temp[$i];
     $cpo_val=trim($array_t_val[$i]);
     $campos = (string) $campos;
     //
     $ntyc = strtoupper($name_type[$campos]);
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
           //
           /**
           *   $campos_val = "password("."'$cpo_val'".")";
           */
           $cpo_val=sha1($cpo_val);
           $campos_val = "trim("."'$cpo_val'".")";
          // 
     } else {
          //
          //  Verificando o Tipo do Campo da Tabela
          //   alterado em 20250127
          //  if( $name_type[$campos]=='string' ) {
          if( in_array(strtoupper($name_type[$campos]),$tx_array) ) {    
              //
              //  $cpo_val=utf8_decode($cpo_val);
              //  clean_spaces - procedure para limpar espacos duplicados
              $campos_val= "clean_spaces(\"$cpo_val\") ";
              /**
              *     ATUALIZADO EM  20210216
              */
              //    Variavel com os parametros do preg_match
              $sg_dept="/^codidfin|^sigla";
              $sg_dept.="|^idfin|^codfin/ui";
              //
              preg_match("$sg_dept",$campos,$ngdept);
              if( count($ngdept)>0 ) {
                   $sigla="$cpo_val";
              }
              //    
              // $campos_val= "acentos_upper('$cpo_val') ";
              //
              //  } elseif( $name_type[$campos]=='int' ) {
           } elseif( $ntyc=='INT' ) {
               //
               $campos_val= (int) $cpo_val;  
           }  elseif( $ntyc=='DECIMAL' or $ntyc=='DECIMAL' or $ntyc=='DOUBLE'  ) {
                $campos_val= $cpo_val;  
           }
           //
           /**    Modificando o campo  Data do PHP  para o formato Date do Mysql  */
           $stt=strtoupper(trim($table));
           //
           /**  if( ( $name_type[$campos]=='date' or $name_type[$campos]=='datetime')  ) {  */
           if( ( $ntyc=='DATE' or $ntyc=='DATETIME')  ) {    
                 //
                 //  Verificando se nao e a  Tabela ANOTACAO e NAO e a PROJETO     
                 if( $stt!="USUARIO" and $stt!="PROJETO" ) {
                     //
                     //  $m_array= array("ANOTACAO","ORIENTADOR","ANOTADOR");
                     $m_array= array("ANOTACAO","ORIENTADOR");
                     //
                     //  if( strtoupper($val)!="ANOTACAO"  ) {
                     $cpo_val=substr($cpo_val,6,4)."-".substr($cpo_val,3,2)."-".substr($cpo_val,0,2);
                     //
                     //  if( in_array(strtoupper($val),$m_array) ) {
                     if( in_array($val,$m_array) ) {
                         //
                         $timestampInSeconds = $_SERVER['REQUEST_TIME'];
                         if( $name_type[$campos]=='datetime' ) {
                             //
                             $cpo_val=date("Y-m-d H:i:s", $timestampInSeconds);  
                         }
                         //
                     }
                     /**   Final - if( in_array($val,$m_array) ) {  */
                     //
                 } elseif( $stt=="PROJETO" and $name_type[$campos]=='date' ) {
                     //
                     if( strlen(trim($cpo_val))<3 ) {
                          $cpo_val='0000-00-00';
                     } elseif( strlen(trim($cpo_val))>=3 ) {
                          $cpo_val=implode("-",array_reverse(explode("/",$cpo_val)));
                     }
                     //        
                 } 
                 $campos_val= "'$cpo_val'";  
                 //                 
           }        
           /**    Final - if( ( $ntyc=='DATE' or $ntyc=='DATETIME')  ) { */
           //
      }     
      //
      //  $_SESSION[campos_total].=$campos."=".$campos_val;
      if( $i<$cntarrtmp ) {
            $campos_nome .= $campos.",";
            $campos_valor .= $campos_val.",";  
            ////  $_SESSION[campos_total].=",";
            $arr_nome_val["$campos"]=$campos_val;
      }
      /**   Final - if( $i<$cntarrtmp ) {  */
      ///
}
/**  Final - for( $i=0; $i<$cntarrtmp; $i++ ) {  */
//
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