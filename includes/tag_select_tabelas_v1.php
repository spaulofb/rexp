<?php
//
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
   $cpo_nome_descr=mysql_field_name($result,0);        
} elseif( intval($num_campos)>1 ) {
     $codigo_sigla=mysql_field_name($result,0);
     $cpo_nome_descr=mysql_field_name($result,1);
}
//


$_SESSION["msgr"] = "LINHA/14 -->> \$num_campos = $num_campos -->> \$cpo_nome_descr = $cpo_nome_descr ";
return;



//
while($linha=mysql_fetch_array($result)) {       
      ///  htmlentities - o melhor para transferir na Tag Select  
	  ////  $nome=urlencode(trim($linha[$cpo_nome_descr]));  
       ///  $nome = htmlentities($linha[$cpo_nome_descr]);
       ///  Alterado em 20170302
       $nome = $linha[$cpo_nome_descr];
        //// $nome = html_entity_decode($linha[$cpo_nome_descr]);
      ///  $nome = htmlspecialchars($linha[$cpo_nome_descr]);
      /// $nome = $linha[$cpo_nome_descr];
      if( intval($num_campos)>1 ) {
          $sigla= htmlentities($linha[$codigo_sigla]);  
           echo "<option  value=".urlencode($linha[$codigo_sigla])."  "
              ."  title='$sigla - $nome'  >";
           $descricao = $sigla;         
      } 
      if( intval($num_campos)==1 ) {
         ///  echo  "<option  value=".urlencode(htmlspecialchars($nome))."  title=".$nome."  >";
          echo  "<option  value='$nome' title='$nome' >";
          ///// $descricao = $nome;         
           $descricao = $nome;         
      }    
     ////
     if( isset($_SESSION["onsubmit_tabela"]) ) {
         /*   Alterado em 20170123  - Em vez de nome passando para sigla    */
         ///  if( strtoupper(trim($_SESSION["onsubmit_tabela"]))=="PESSOAL" ) $descricao = $nome; 
        ////// $descricao = $sigla; 
         if( strtoupper(trim($_SESSION["onsubmit_tabela"]))=="PESSOAL" ) {
             if( isset($_SESSION["siglaounome"]) ) {
                 $siglaounome=$_SESSION["siglaounome"];
                 if( strtoupper($siglaounome)=="CATEGORIA" )  $descricao = $nome; 
             }
         }
     } 
     /*     Detectar codificaÃ§Ã£o de caracteres            */
     $codigo_caracter=mb_detect_encoding($descricao);
     if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
           ///  Converter  para  UFT-8
            ///  Alterado em 20170302
           echo  htmlentities($descricao,ENT_QUOTES,"UTF-8")."</option>";
           ////
     } else {
          echo  "$descricao</option>";    
     }
     ///           
}
?>