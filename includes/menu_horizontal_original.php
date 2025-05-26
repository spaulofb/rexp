<?php
/*   -- MENU HORIZONTAL --   */
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}	
///                         
/// Alterado em 20120912 - function authent_user.php - doaction antes era dochange
if( ! isset($_SESSION["function"]) ) $_SESSION["function"]="dochange";
///
?>
<!-- MENU HORIZONTAL -->
<div class="menu_principal"  id="menu_principal" style="z-index:99; position: relative; "  >
<ul class="otimizacaositesbusca otimizacaositesbuscam"  style="float:right; width: 99%; "  >
  <?php
      /**************************************************
      /// Alterando acentos em UTF-8  - alterado em 20171005
      ***********************************************///
      $map = array(
                    'á' => 'a',
                    'à' => 'a',
                    'ã' => 'a',
                    'â' => 'a',
                    'é' => 'e',
                    'ê' => 'e',
                    'è' => 'e',                    
                    'í' => 'i',
                    'ì' => 'i',                    
                    'ó' => 'o',
                    'ô' => 'o',
                    'õ' => 'o',
                    'ò' => 'o',                    
                    'ú' => 'u',
                    'ü' => 'u',
                    'ç' => 'c',
                    'Á' => 'A',
                    'À' => 'A',
                    'Ã' => 'A',
                    'Â' => 'A',
                    'É' => 'E',
                    'Ê' => 'E',
                    'Í' => 'I',
                    'Ó' => 'O',
                    'Ô' => 'O',
                    'Õ' => 'O',
                    'Ú' => 'U',
                    'Ü' => 'U',
                    'Ç' => 'C',
                    'Ñ' => 'N',
                    'ñ' => 'n',
                    'Ý' => 'Y',
                    'ý' => 'y'
      );
      ///  Final - Array acentos
      ///
      $m_horiz = $_SESSION["m_horiz"];
      $count_m_horiz = count($m_horiz);
      ///
	 for( $opcoes_pri=0; $opcoes_pri<$count_m_horiz; $opcoes_pri++ ) {
		 if ( is_array($m_horiz[$opcoes_pri])==1 ) {
		     //  Sub-menu 1
             ///  Alterado em 20171004 - utf8_decode
			 $sub_menu1 = utf8_decode($m_horiz[$opcoes_pri][0]) ;
			 $sub_menu1_count = count($m_horiz[$opcoes_pri]);
		     echo  "<li class='otimizacaositesbuscai' >"
			       ."<a class='otimizacaositesbuscai' href='#' >".$sub_menu1."</a>";
	         echo "<ul class='otimizacaositesbuscam' >";
			 for( $opcoes_submenu=1; $opcoes_submenu<$sub_menu1_count; $opcoes_submenu++ ) { 
			      $m_sub = $m_horiz[$opcoes_pri][$opcoes_submenu];
                  $m_sub = strtr($m_sub, $map);
                  ////  Copia sem acentos
                  ////  $sub_menu1_copia= 
                  ///
		  		  if ( is_array($m_horiz[$opcoes_pri][$opcoes_submenu] )!=1 ) {
                      ///
				       echo  "<li  class='otimizacaositesbuscai' >";
                       echo  "<a class='otimizacaositesbuscai' "
							."  onclick='javascript: {$_SESSION["function"]}(\"$sub_menu1\",\"$m_sub\");'  title='Clicar' >"
     						."<span>".$m_sub."</span></a>"; 
	     			   echo  "</li>";
				  } else if ( is_array($m_horiz[$opcoes_pri][$opcoes_submenu] )==1 ) {
			  		       ///  Sub-menu 2
                           ///  Alterado em 20171004 - utf8_decode
                  		   $sub_menu2 = utf8_decode($m_horiz[$opcoes_pri][$opcoes_submenu][0]);
			               $sub_menu2_count = count($m_horiz[$opcoes_pri][$opcoes_submenu]);
						   echo  "<li class='otimizacaositesbuscai' >";
						   echo  "<a class='otimizacaositesbuscai' href='#' >"
							     ."<span>".$sub_menu2."</span></a>";
	        			   echo "<ul class='otimizacaositesbuscam' >";
						   for( $submenu_2=1; $submenu_2<$sub_menu2_count ; $submenu_2++ ) {
		      			        $m_sub2 = $m_horiz[$opcoes_pri][$opcoes_submenu][$submenu_2];
                                $m_sub2 = strtr($m_sub2, $map);
						        echo  "<li  class='otimizacaositesbuscai' >"
        				            ."<a class='otimizacaositesbuscai' "
									." onclick='javascript: {$_SESSION["function"]}(\"$sub_menu2\",\"$m_sub2\");'  title='Clicar' >"
			  						.$m_sub2."</a>"; 
			     			    echo  "</li>";
						   } 				     
    	   	  			 echo "</ul>";
            			 echo "</li>";				 
				  }
			 }
 		     echo "</ul>";
			 echo "</li>";
		 } elseif (is_array($m_horiz[$opcoes_pri])<1 ) { 
               ////  Alterado em 20171004 - utf8_decode
 		       $m_sub = utf8_decode($m_horiz[$opcoes_pri]); 
               $m_sub = strtr($m_sub, $map);
 		       echo  "<li class='otimizacaositesbuscai'  >";
               if( strtoupper(trim($m_sub))=="SAIR" )  {
                   echo  "<a class='otimizacaositesbuscai'  href='#'  "
                           ."  style='background-color:#FFFFFF; color:#000000;'  " 
                          ."  onclick='javascript: {$_SESSION["function"]}(\"$m_sub\");' "
                          ." title='Clicar' >"
                          .$m_sub."</a></li>";
               } else {
                   echo  "<a class='otimizacaositesbuscai'  href='#'  "
                          ."  onclick='javascript: {$_SESSION["function"]}(\"$m_sub\");' "
                          ." title='Clicar' >"
                          .$m_sub."</a></li>";
               }
               ///
		 }
	 }
	?>
</ul>
</div>
<!-- Final do MENU  -->
