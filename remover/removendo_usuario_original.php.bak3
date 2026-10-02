<?php
/*****  Removendo USUARIO e seus Projetos e Anotacoes
        20170817
****/
///  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///
$lnerro=0;
///  Start a transaction - ex. procedure    
mysqli_query('DELIMITER &&'); 
mysqli_query('begin'); 
//  Execute the queries          
////  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysqli_query()
mysqli_query("LOCK TABLES $bd_1.usuario  DELETE, $bd_2.participante DELETE,  $bd_2.anotador DELETE ");
/*!40000 ALTER TABLE `orientador` DISABLE KEYS */;         
///  Removendo o anotador do Projeto  
$sqlcmd = "DELETE from $bd_2.anotador  WHERE codigo=$cod_usuario  ";
//                  
$res_anotador =  mysqli_query($_SESSION["conex"],$sqlcmd);
if( $res_anotador ) { 
     /***
          Removendo participante
    */
    $sqlcmd= "DELETE from $bd_2.participante WHERE codigousp=$cod_usuario "; 
    ///                  
    $res_anotacao =mysqli_query($_SESSION["conex"],$sqlcmd);      
    if( ! $res_anotacao ) { 
           echo $funcoes->mostra_msg_erro("&nbsp;Removendo participante&nbsp;-db/mysql:&nbsp;".mysqli_error($_SESSION["conex"]));
            $lnerro=1;
     }                
     ///
     ///  Removendo o usuario da tabela usuario
     if( intval($lnerro)<1 ) {
          $sqlcmd= "DELETE from $bd_1.usuario WHERE codigousp=$cod_usuario "; 
          ///                  
          $res_projeto =mysqli_query($_SESSION["conex"],$sqlcmd);      
          if( ! $res_projeto ) { 
                ///  mysqli_error($_SESSION["conex"]) - para saber o tipo do erro
                /*    $msg_erro .="&nbsp;Removendo o Projeto $numprojeto do Autor - db/mysql:&nbsp; "
                      .mysqli_error($_SESSION["conex"]).$msg_final;
                     echo $msg_erro;  
                */                           
                echo $funcoes->mostra_msg_erro("&nbsp;Removendo o usuário&nbsp;-&nbsp;db/mysql:&nbsp;".mysqli_error($_SESSION["conex"]));                    
                $lnerro=1;
          }                               
     }    
     ////
} else { 
      //  mysqli_error($_SESSION["conex"]) - para saber o tipo do erro
      /* $msg_erro .="&nbsp;Removendo anotador do Projeto da Tabela anotador - db/mysql:&nbsp; ".mysqli_error($_SESSION["conex"]).$msg_final;
      echo $msg_erro; */           
      echo $funcoes->mostra_msg_erro("&nbsp;Removendo anotador&nbsp;-&nbsp;db/mysql:&nbsp;".mysqli_error($_SESSION["conex"]));
      $lnerro=1;        
}       
///
if( intval($lnerro)<1 ) {
    ///  Usuario/Anotador?participante foi removido - sem projetos
    mysqli_query('commit'); 
} else {
    ///  Caso tenha ocorrido erros
    mysqli_query('rollback');  
}  
////
/*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
mysqli_query("UNLOCK  TABLES");
//  Complete the transaction 
mysqli_query('end'); 
mysqli_query('DELIMITER');         
////
///  FINAL IMPORTANTE PASSAR RESULTADO PARA ESSA SESSAO
///
$_SESSION["lnerro"]=$lnerro;
///
?>