<?php
/**
*   Dados da Tabela pessoal  - ATUALIZADO  EM 20250124
*   Sao os campos(dados) enviados de um FORM para o arquivo AJAX  
*/
////  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///
///  Dados vindo do FORMULARIO e criando arrays
$m_erro=0;
if( isset($array_temp) ) unset($array_temp); 
if( isset($array_t_value) ) unset($array_t_value);
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
///
///  $campo_nome = substr($campo_nome,0,strlen($campo_nome)-1);      
///  array_temp  -  com os nomes dos campos
$array_temp = explode(",",$campo_nome);        
///
/***   ATUALIZADO EM  20210217  
    Contando o numero de campos de dados recebidos
****/
$count_array_temp = sizeof($array_temp);
/// $campo_value = utf8_decode($campo_value);  
$campo_value = "{$campo_value}";  
///
///  $campo_value =  $campo_value; 
$array_value = explode(",",$campo_value);
///
///  for( $w=0; $w<$count_array_temp; $w++ ) $array_t_value[]=html_entity_decode(trim($array_value[$w]));
///  for( $w=0; $w<$count_array_temp; $w++ ) $array_t_value[]=utf8_decode(trim($array_value[$w]));
for( $w=0; $w<$count_array_temp; $w++ ) {
      $array_t_value[] = trim($array_value[$w]);   
}
///  
///  $array_t_value[]=html_entity_decode(trim($array_value[$w]));
for( $i=0; $i<$count_array_temp; $i++ ) {
      $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];   
}
//  Final criando arrays  
//
///  DEsativando
if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
///
///  Banco de Dados - BD/DB
if( ! isset($_SESSION["bd_1"]) ) {
    echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
    exit();
}
$bd_1 = $_SESSION["bd_1"];   
///
///  Tabela 
$session_tabela = $_SESSION["tabela"];
///
/***    CONEXAO     ****/
$conex = $_SESSION["conex"];
///
///  Select/MySQLI  -  atualizado em 20210609
$txt="SELECT * FROM  {$bd_1}.$session_tabela limit 1";
$result_tabela = mysqli_query($_SESSION["conex"],"$txt");
///  if( ! $result_tabela ) {
if( mysqli_error($_SESSION["conex"]) ) {         
   ///  die('Select '.$session_tabela.' - falha: '.mysql_error());
    $_SESSION["erro"] = "Select $session_tabela  - db/mysqli:&nbsp;".mysqli_error($conex);
    return;
}
///   Campos da Tabela 
$fields = mysqli_num_fields($result_tabela);
///   Registros da Tabela 
$rows   = mysqli_num_rows($result_tabela);
///
/// Nome da Tabela
/// $table  = mysqli_field_table($result_tabela, 0);
$fieldinfo=mysqli_fetch_field_direct($result_tabela,0);
$table  = $fieldinfo->table;
///
/***  echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
    echo "The table has the following fields:\n";
***/	
$nome_cpo_coord_ou_orient="";
///
///  Mostrar a estrutura dos campos da Tabela
$query = "DESCRIBE {$bd_1}.$session_tabela ";
$result = mysqli_query($_SESSION["conex"],$query);
//
/// Verifica
if( mysqli_error($_SESSION["conex"]) ) {         
    $txt="Falha no select da Tabela $tabpri - db/Mysqli:&nbsp;".mysqli_error($conex); 
    ////$_SESSION["erro"] =  $funcoes->mostra_msg_erro("$txt".mysqli_error($_SESSION["conex"]));
    $_SESSION["erro"] = "$txt";    
    ///
    return;
}
///
/// IMPORTANTE:  mysqli_fetch_array para dois campos (codigo,descricao)
$xecho = "";
/// while( $row = mysqli_fetch_array($result,MYSQL_BOTH)) {

///  $qr = 

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
///
$campos=""; $campos_nome=""; $campos_val=""; $campos_valor="";
$_SESSION['campos_total']="";
///
///  Alterando o Array $array_temp - Como:  orientador|coordenador
if( preg_match("/^projeto$/i",$session_tabela) ) {
    for( $oc=0; $oc<$count_array_temp; $oc++ ) {
        if( preg_match("/(orientador|coordenador)/i",$array_temp[$oc])  ) {
             $array_temp[$oc]=$nome_cpo_coord_ou_orient;
        }
    }
}
///	

/****
$_SESSION["erro"] = "ERRO: LINHA/131  ---    $count_array_temp  ---- array_t_value = ". count($array_t_value)."  -  ". implode(' ', $array_t_value);
return;
 ***/

///
//// Arrays dos Types de Tabela Mysqli - numeric, string, boolean   etc...
///    Numeric Data Types
$nm_array = array("INT", "TINYINT",  "SMALLINT", "MEDIUMINT", "BIGINT", "FLOAT", "DOUBLE", "DECIMAL");
///    Date and Time Types
$dt_array = array("DATE", "DATETIME", "TIMESTAMP", "TIME", "YEAR");
///    String Types
$tx_array = array("CHAR",  "VARCHAR", "BLOB",  "TEXT",  "TINYBLOB",  "TINYTEXT",  
                  "MEDIUMBLOB",  "MEDIUMTEXT", "LONGBLOB",  "LONGTEXT", "ENUM");     
///   Boolean
$bo_array = array("boolean");

///   for principal para os dados recebidos
for( $i=0; $i<$count_array_temp; $i++ ) {
     //
      //  Removendo o campo para confirmar senha
      if( trim(strtoupper($array_temp[$i]))=="REDIGITAR_SENHA" ) continue;
      if( preg_match("/M_SALVAR/i",trim(strtoupper($array_temp[$i]))) ) continue;
      if( preg_match("/M_CANCELAR/i",trim(strtoupper($array_temp[$i]))) ) continue;
      $ar_tmp=trim(strtoupper($array_temp[$i]));
      if( preg_match("/M_FORNECEDOR|situacaoatual|m_botao_atributo/i",$ar_tmp) ) continue;
      $campos = $array_temp[$i];
 /////     $cpo_val = utf8_decode($array_t_value[$i]);
      $cpo_val = $array_t_value[$i];
	  $campos = (string) $campos;
      ///
      $ntyc = strtoupper($name_type[$campos]);
      
/***
$_SESSION["erro"] .= "ERRO: LINHA/151 - \$name_type[$campos] = {$name_type[$campos]} <<<---  \$cpo_val = $cpo_val --  \$campos = $campos -->> ".$array_temp[$i]."<br/>";
***/
      
	  if( trim(strtoupper($array_temp[$i]))=="SENHA" ) {
	       ///  $campos_val = "password("."'$cpo_val'".")";
           $cpo_val=sha1($cpo_val);
           $campos_val = "trim("."'$cpo_val'".")";
	  } else {
	       /// Verificando o Tipo do Campo da Tabela
           ///   alterado em 20191017
	       ///  if( $name_type[$campos]=='string' ) {
           if( in_array(strtoupper($name_type[$campos]),$tx_array) ) {    
                 ///  $cpo_val=utf8_decode($cpo_val);
                 ///  clean_spaces - procedure para limpar espacos duplicados
                 $campos_val= "clean_spaces(\"$cpo_val\") ";
                 /****
                 *     ATUALIZADO EM  20210216
                 ****/
                 ///    Variavel com os parametros do preg_match
                 $sg_dept="/^codidfin|^sigla";
                 $sg_dept.="|^idfin|^codfin/ui";
                 ///
                 preg_match("$sg_dept",$campos,$ngdept);
                 if( count($ngdept)>0 ) {
                      $sigla="$cpo_val";
                 }
                 ///    
                 /// $campos_val= "acentos_upper('$cpo_val') ";
                 ///
             ///  } elseif( $name_type[$campos]=='int' ) {
           } elseif( $ntyc=='INT' ) {
                 $campos_val= (int) $cpo_val;  
           }  elseif( $ntyc=='DECIMAL' or $ntyc=='DECIMAL' or $ntyc=='DOUBLE'  ) {
                 $campos_val= $cpo_val;  
           }
	       ///  Modificando o campo  Data do PHP  para o formato Date do Mysql
           $stt=strtoupper(trim($table));
	       ////  if( ( $name_type[$campos]=='date' or $name_type[$campos]=='datetime')  ) {
           if( ( $ntyc=='DATE' or $ntyc=='DATETIME')  ) {    
                    ///  Verificando se nao e a  Tabela ANOTACAO e NAO e a PROJETO     
                    if( $stt!="USUARIO" and $stt!="PROJETO" ) {
                         ///  $m_array= array("ANOTACAO","ORIENTADOR","ANOTADOR");
                         $m_array= array("ANOTACAO","ORIENTADOR");
                         ///  if( strtoupper($val)!="ANOTACAO"  ) {
                         $cpo_val=substr($cpo_val,6,4)."-".substr($cpo_val,3,2)."-".substr($cpo_val,0,2);
                          ///  if( in_array(strtoupper($val),$m_array) ) {
                          if( in_array($val,$m_array) ) {
                               $timestampInSeconds = $_SERVER['REQUEST_TIME'];
                               if( $name_type[$campos]=='datetime' ) {
                                   $cpo_val=date("Y-m-d H:i:s", $timestampInSeconds);  
                               }
                          }
                          ///
                    } elseif( $stt=="PROJETO" and $name_type[$campos]=='date' ) {
                         if( strlen(trim($cpo_val))<3 ) {
                                 $cpo_val='0000-00-00';
                         } elseif( strlen(trim($cpo_val))>=3 ) {
                                $cpo_val=implode("-",array_reverse(explode("/",$cpo_val)));
                         }        
                    } 
                    $campos_val= "'$cpo_val'";  
                    ///                 
               }		
		///  if( $name_type[$campos]=='datetime') $campos_val= "'$cpo_val'";
	  }	 
	  ///
	  ///  $_SESSION[campos_total].=$campos."=".$campos_val;
	  if( $i<$count_array_temp ) {
	      $campos_nome .= $campos.",";
	      $campos_valor .= $campos_val.",";  
	      ///  $_SESSION[campos_total].=",";
          ///  $_SESSION["erro"] .= $campos_valor;
	  }
}
///
$_SESSION["campos_nome"] = substr($campos_nome,0,strlen($campos_nome)-1);
$_SESSION["campos_valor"] = substr($campos_valor,0,strlen($campos_valor)-1);
///
///   ALTERADO EM 20210217  
///  $_SESSION["campos_valor"]=html_entity_decode(trim($_SESSION["campos_valor"]), ENT_QUOTES);  

/***  $_SESSION["campos_valor"] = html_entity_decode(trim($_SESSION["campos_valor"]), ENT_QUOTES, 'UTF-8');
  ***/
///
$cpo_nome=$_SESSION["campos_nome"];
////
/****     ATUALIZADO  EM   20210217     ****/
///  $cpo_valor = utf8_encode($_SESSION["campos_valor"]);
$cpo_valor = "{$_SESSION["campos_valor"]}";
///
if (isset($result_tabela)) {
    mysqli_free_result($result_tabela);
}
///
/***
$_SESSION["erro"] .= "ERRO: LINHA/200  \$campos_nome = $campos_nome   --->> \$campos_valor = $campos_valor   <<<---- \$cpo_nome = $cpo_nome  <>  \$cpo_valor = $cpo_valor    <<<<-----   array_t_value = ". count($array_t_value)."  -  ". implode('-', $array_t_value);
return;
***/
///
?>