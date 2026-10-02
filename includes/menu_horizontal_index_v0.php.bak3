<?php
    /*   -- MENU HORIZONTAL --   */
	
?>
<!-- MENU HORIZONTAL -->
<!--  <div style="position: relative; top: 38px; margin-left: 0px; left: 0px"   >  -->
<div class="menu_principal"  id="menu_principal" style="z-index:99;position: relative;"  >
<ul class="otimizacaositesbusca otimizacaositesbuscam"  style="float:right; width: 99%; " >
   <?php
      $m_horiz = "";
      if( isset($_SESSION["m_horiz"]) ) $m_horiz=$_SESSION["m_horiz"];
      if( is_array($m_horiz) ) {
         $count_m_horiz = count($m_horiz);         
      } else  $count_m_horiz = (int) strlen(trim($m_horiz));
      ////
      if( intval($count_m_horiz)>=1 ) {         
              ///
             for( $opcoes_pri=0; $opcoes_pri<$count_m_horiz; $opcoes_pri++ ) {
                 if ( is_array($m_horiz[$opcoes_pri])==1 ) {
                     //  Sub-menu 1
                     $sub_menu1 = $m_horiz[$opcoes_pri][0];
                     $sub_menu1_count = count($m_horiz[$opcoes_pri]);
                     echo  "<li class='otimizacaositesbuscai' >"
                           ."<a class='otimizacaositesbuscai' href='#' >".$sub_menu1."</a>";
                     echo "<ul class='otimizacaositesbuscam' >";
                     for( $opcoes_submenu=1; $opcoes_submenu<$sub_menu1_count; $opcoes_submenu++ ) { 
                          $m_sub = $m_horiz[$opcoes_pri][$opcoes_submenu];
                            if ( is_array($m_horiz[$opcoes_pri][$opcoes_submenu] )!=1 ) {
                               echo  "<li  class='otimizacaositesbuscai' >"
                                    ."<a class='otimizacaositesbuscai' "
                                    ."  onclick='javascript: dochange(\"$sub_menu1\",\"$m_sub\");'  title='Clicar' >"
                                     ."<span>".$m_sub."</span></a>"; 
                                echo  "</li>";
                          } else if ( is_array($m_horiz[$opcoes_pri][$opcoes_submenu] )==1 ) {
                                     //  Sub-menu 2
                                     $sub_menu2 = $m_horiz[$opcoes_pri][$opcoes_submenu][0];
                                   $sub_menu2_count = count($m_horiz[$opcoes_pri][$opcoes_submenu]);
                                   echo  "<li class='otimizacaositesbuscai' >"
                                         ."<a class='otimizacaositesbuscai' href='#' >"
                                         ."<span>".$sub_menu2."</span></a>";
                                   echo "<ul class='otimizacaositesbuscam' >";
                                   for( $submenu_2=1; $submenu_2<$sub_menu2_count ; $submenu_2++ ) {
                                          $m_sub2 = $m_horiz[$opcoes_pri][$opcoes_submenu][$submenu_2];
                                        echo  "<li  class='otimizacaositesbuscai' >"
                                            ."<a class='otimizacaositesbuscai' "
                                            ." onclick='javascript: dochange(\"$sub_menu2\",\"$m_sub2\");'  title='Clicar' >"
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
                        $m_sub = $m_horiz[$opcoes_pri]; 
                        echo  "<li class='otimizacaositesbuscai'  >";
                       echo  "<a class='otimizacaositesbuscai' "
                              ."  onclick='javascript: dochange(\"$m_sub\");'  title='Clicar' >"
                              .$m_sub."</a></li>";
                 }
             }            
      } else {
          echo  "<li class='otimizacaositesbuscai' style='height:25px;'  ><a class='otimizacaositesbuscai'  onclick='javascript: conectando();'  title='Clicar' sty?e=' cursor: pointer;'>Ativar</a></li>";          
      }
    ?>
</ul>
</div>
<!-- Final do MENU  -->
