<?php
  
  
   // Calculando pagina anterior
    $menos = $pagina - 1;

    // Calculando pagina posterior
    $mais = $pagina + 1;

    $pgs = ceil($total_regs/$maximo);
    // $pgs = 10;
    if( $pgs>10 ) $pgs=10;
    
    //  Total de paginas
    $_SESSION["numero_de_pags"] = (int) ($total_regs/$maximo);
    $_SESSION["valor_com_pags"] = (int) ($_SESSION["numero_de_pags"]*$maximo);
    if( $_SESSION["valor_com_pags"]<$total_regs ) $_SESSION["numero_de_pags"]++;
    
    if( $pgs > 1 ) {
        $td_menu=$td_menu*2;
        $pagina_atual = 'http://www-gen.fmrp.usp.br/rexp/consultar/tabela_selecionada.php';
        $font_size_family="font-size: small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace;"; 
        echo "<tr style='width: 100%; text-align: center;  margin-bottom: 0px;  padding-bottom: 0px; '  >";
        echo   "<td class='table_td' colspan=".$td_menu." style='text-align: center; '  align='center' >";
        echo  '<table border="0"  cellpadding="1"  cellspacing="0"  align="center" style="margin-top: 0px; padding-top: 0px; " >';    
        echo "<tr  style='padding: 0px;' >";
        echo  "<td style='".$font_size_family."' >";
        // Mostragem de pagina
        //  Pagina inicial
         if( $total_regs>0 && $menos>0 ) {
                $iniciando="0";
                echo "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$iniciando\");'  "
                ." class='texto_paginacao' style='cursor: pointer;' alt='Clicar'  >in&iacute;cio</a>&nbsp;";
         }  
          //  Pagina anterior
        if($menos>0) {
           // echo "<a href=\"?pagina=$menos&seed=$seed\" class='texto_paginacao'>anterior</a> ";
           // echo "<a href=\"$pagina_atual?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
           // echo "<a href=\"?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
           echo  "<a href='javascript: $m_function(\"Lista\",\"$menos\");' "
                  ." class='texto_paginacao'  title='Clicar' >anterior</a>&nbsp;";
        }
        
        // Listando as paginas
        $n_pags=8;
        if( $_SESSION["valor_com_pags"]==$pagina ) {
                $pag_id=$pagina-$n_pags;
                if ( $pag_id<1 ) $pag_id=1;
        } else $pag_id=$pagina;
        for($i=1;$i <= $n_pags; $i++) {
                $pag_id++;
                if( $pag_id<=$_SESSION["numero_de_pags"] ) {
                      if( $pag_id != $pagina) {
                            echo  "<a href='javascript: $m_function(\"Lista\",\"$pag_id\");' "
                                 ." class='texto_paginacao'  title='Clicar' >"
                                 ."$pag_id</a>&nbsp;";
                      } else echo "&nbsp;<span class='texto_paginacao_pgatual'>".$pag_id."</span>&nbsp;";
                }     
        }
        // Proxima pagina
        //  if($mais <= $pgs) {
        if( $mais<=$_SESSION["numero_de_pags"] || ($inicio+$maximo)<$total_regs ) {
            echo  "<a href='javascript: $m_function(\"Lista\",\"$mais\");'   "
                  ." class='texto_paginacao'  title='Clicar'  >pr&oacute;xima</a>&nbsp;";
        }
        //  Ultima pagina
        $ultima_pagina = (int) $_SESSION["pagina_final"];
        if ( $ultima_pagina!=$pagina && ($inicio+$maximo)<$total_regs ) {
             echo  "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$ultima_pagina\");'   "
                   ." class='texto_paginacao'   title='Clicar'  >final</a>";
        }
        echo "</td></tr></table>";
        echo "</td></tr>";
    }  // Final - if \$pgs
    echo "</TABLE>"; 

  
  
?>
