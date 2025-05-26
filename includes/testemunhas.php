<?php
/**
*      Arquivo testemunhas.php
*   v20250521
* 
*  Verificando caso tiver testemunha na Anotacao 
*/
if( ! isset($testemunha_selec) ) {
      $testemunha_selec="";  
} 
//
//  Tag Select para selecionar uma Testemunha
$m_linhas = mysqli_num_rows($testemunhas_result);
//
/** Verifica Nr. de Registros   */
if( intval($m_linhas)<1 ) {
     echo "<option value='' >== Nenhum encontrado ==</option>";
} else {
    //
     echo "<option value='' >== Selecionar ==</option>";
     //
     while($linha=mysqli_fetch_array($testemunhas_result)) {       
          ///
          if( $linha['codigousp']==$testemunha_selec  ) { 
              $selected_testemunha="selected='selected'";
          } else {
              $selected_testemunha="";                                        
          }
          //
          /**  Caso Variavel MAIOR 1  */
		  if( $linha['codigousp']>=1 ) {
              //
			  /**  $testemunha_categ = "Categ.: ".$linha["categoria"];	
               *  $testemunha_categ = "Categ.: ".htmlentities($linha["categoria"],ENT_QUOTES,"UTF-8");  
               */
              $testemunha_categ = htmlentities($linha["categoria"],ENT_QUOTES,"UTF-8");
              //
              /**
              echo "<option $selected_testemunha value=".htmlentities($linha['codigousp'])." >";
              */
              echo "<option $selected_testemunha value=".$linha['codigousp']." >";
              //
              /**   echo  ucfirst(htmlentities($linha['nome']));  */
              /** echo  htmlentities($linha['nome'],ENT_QUOTES,"UTF-8");   */
              echo  $linha["nome"];
              echo  "&nbsp;-&nbsp;".$testemunha_categ."&nbsp;</option>" ;
              ///
		  }
          /**  Final - if( $linha['codigousp']>=1 ) {  */
          //	  
     }
     /**  Final - while($linha=mysqli_fetch_array($testemunhas_result)) {  */
     //
}
//	 
?>			   