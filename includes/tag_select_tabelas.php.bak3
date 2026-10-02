<?php
//
//  Caso SESSION_START desativada  - Ativar  
if(!isset($_SESSION)) {
   session_start();
}
//
/**
*     Arquivo para a Tag Select das Tabelas: Instituicao, Unidade, Depto, pessoa, categoria
*/
$num_campos=mysqli_num_fields($result);
//
// Verificando Nr. de Campos 
if( intval($num_campos)==1 ) {
     $cpo_nome_descr=mysqli_field_name($result,0);        
} elseif( intval($num_campos)>1 ) {
     $codigo_sigla=mysqli_field_name($result,0);
     $cpo_nome_descr=mysqli_field_name($result,1);
}
//

/****
$_SESSION["msgr"] = "LINHA/14 -->> \$num_campos = $num_campos -->> \$cpo_nome_descr = $cpo_nome_descr ";
return;
*****/

header('Content-Type: text/html; charset=utf-8');
// ini_set('default_charset', 'UTF-8');
//
while( $linha=mysqli_fetch_array($result)) {       
       //
       //  htmlentities - o melhor para transferir na Tag Select  
	   //  $nome=urlencode(trim($linha[$cpo_nome_descr]));  
       //  $nome = htmlentities($linha[$cpo_nome_descr]);
       //  Alterado em 20170302
       $nome = $linha[$cpo_nome_descr];
       // $nome = html_entity_decode($linha[$cpo_nome_descr]);
       //  $nome = htmlspecialchars($linha[$cpo_nome_descr]);
       // $nome = $linha[$cpo_nome_descr];
       $titnm = $nome;
       if( intval($num_campos)>1 ) {
           //
           $sigla= htmlentities($linha[$codigo_sigla]);  
           $valsig=urlencode($linha[$codigo_sigla]);
           echo "<option  value=\"$valsig\" title=\"$sigla - $titnm\"  >";
           //
           $descricao = $sigla;         
           //
       } 
       //
       if( intval($num_campos)==1 ) {
           /**
           *   echo  "<option  value=".urlencode(htmlspecialchars($nome))."  title=".$nome."  >";
           */
           $descricao = $nome;         
           // 
           echo  "<option  value=\"$nome\" title=\"$titnm\" >";
       }    
       //
       if( isset($_SESSION["onsubmit_tabela"]) ) {
          //
          /**   Alterado em 20250109  - Em vez de nome passando para sigla    
          *   if( strtoupper(trim($_SESSION["onsubmit_tabela"]))=="PESSOAL" ) $descricao = $nome; 
          */
          // 
          $onstb = strtoupper(trim($_SESSION["onsubmit_tabela"]));  
          if( $onstb=="PESSOAL" ) {
              //
              if( isset($_SESSION["siglaounome"]) ) {
                  $siglaounome=$_SESSION["siglaounome"];
                  if( strtoupper($siglaounome)=="CATEGORIA" ) {
                       $descricao = $nome;   
                  } 
              }
              //
          }
          /** Final - if( $onstb=="PESSOAL" ) {  */
          //
       }
       /** Final - if( isset($_SESSION["onsubmit_tabela"]) ) {  */
       // 
       /**   Detectar codificacao de caracteres     */
       $codigo_caracter=mb_detect_encoding($descricao);
       if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
            /**
            *       Converter  para  UFT-8
            *    Alterado em 20250109
            *  echo  htmlentities($descricao,ENT_QUOTES,"UTF-8")."</option>";
            */
            echo  "$descricao</option>";
           //
       } else {
           echo  "$descricao</option>";    
       }
       //           
}
/**  Final - while( $linha=mysqli_fetch_array($result)) {  */
//
?>