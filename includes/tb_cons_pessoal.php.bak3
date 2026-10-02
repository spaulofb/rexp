<?php
//
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//

//  Conexao com o banco:  Consultar Pessoas  - 20180606
/****  Verificando essa SESSAO importante 
//       Caso NAO exista criar - alterado em 20171031
****/
if( ! isset($_SESSION["url_central"]) ) {
    echo  utf8_decode("ERRO: falha grave sessão url_central não existe.");
    exit();
}
$url_central = $_SESSION["url_central"];
///
///  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";
//
$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";
//
$msg_final="</span></span>";
/**  Final - Mensagens para enviar  */
//
/** 
*    Exibindo a Tabela de Consulta do Pessoal
*/
$campos_query = "*";
//
/**
 *  Conexao Mysqli
 */ 
$conex = $_SESSION["conex"];
//
// Declaracao da pagina inicial
$pagina = $_SESSION["pagina"];
//
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo "ERRO: Sessão incluir_arq não está ativa.";
    exit();
}
//
/** Caso variavel for MENOR que 1  */
if( intval($pagina)<1 ) {
    $pagina="1";
}
/**  Final - if( intval($pagina)<1 ) { */
//
//  Maximo de registros por pagina
//  $maximo = 16;
$maximo=10;
//
// Calculando o registro inicial
$inicio = $pagina - 1;
$inicio = $maximo * $inicio;
//
//  Variaveis recebidos e criando absoletos
if( isset($_SESSION["num_rows"]) ) {
    //
    if( intval($_SESSION["num_rows"])>=1 ) {
        //
         unset($_SESSION["num_rows"]);
	     /**    Conta os resultados no total da minha query
	     *    $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
	     *    $query    = mysqli_query($conex,$strCount);                              
        */
	    $_SESSION["row"]  = mysqli_fetch_array($result_outro);
	    $_SESSION["total_regs"] = mysqli_num_rows($result_outro);
	    $_SESSION["passou"]=1; $total_regs = $_SESSION["total_regs"];
        for( $z=1; $z<99999 ; $z++ ) {
              $valor_final[$z] = $z*$maximo;
              if( $valor_final[$z]>$total_regs ) {
                     $_SESSION["pagina_final"] = $maximo-($valor_final[$z]-$total_regs);
			         $_SESSION["pagina_final"] = $total_regs-$_SESSION["pagina_final"];
 			         $_SESSION["pagina_final"] = (int) ($_SESSION["pagina_final"]/$maximo)+1;
                     break;
              }
              //
         }
         /**  Final - for( $z=1; $z<99999 ; $z++ ) { */
         //
    }
    //
}  
/**  Final - if( isset($_SESSION["num_rows"]) ) { */
//
/**   \$row = array  e  \$total_regs = total_regs de registros encontrados  */
// 
$row=$_SESSION["row"]; 
$total_regs = $_SESSION["total_regs"];
//
$usuario_conectado = $_SESSION["usuario_conectado"];
//



/**  
echo "ERRO: LINHA104 -->> tb_cons_pessoal  -->> \$row = $row   -->>  \$usuario_conectado = $usuario_conectado <<-- <br>"
            ." -->>  \$total_regs = $total_regs <<--<br/>\n";
exit();
 */



//
// Verifica Total de registros
if( intval($total_regs)<1 ) {
    echo "<p class='titulo_usp' >Nenhum registro encontrado.</p>";
} else {
    //
    //  Tabela temporaria
    /**
    *    Verificando SESSION  table_temporaria  - 20250611
    */   
    if( ! isset($_SESSION["table_temporaria"]) ) {
        //
        $terr="Falha SESSION table_temporaria não definida.";
        echo $funcoes->mostra_msg_erro(utf8_decode("$terr"));    
        exit();
    }
    $table_temporaria = $_SESSION["table_temporaria"];
    //
    // Definindo as variaveis
    $num_fields=0; $m_ordenar="nome"; 
    $max_length="";
    //
    //  IMPORTANTE: essa parte abaixo para acentuacao  PHP/MySQL - 20190118
    ini_set('default_charset','utf8');
    mysqli_set_charset($_SESSION["conex"],'utf8');
    //
    /**
     *   Select/MYSQLI - Selecionando os campos da tabela temporaria
     *    Utilizando no Select/MYSQLI  utf8
     */
    //
    $strQuery="SELECT $campos_query  FROM  $table_temporaria  LIMIT $inicio,$maximo";    
	$query = mysqli_query($conex,$strQuery);
    if( ! $query ) {
         //
         //  die('ERRO: Sem resultado - Select - falha: '.mysqli_error($conex));   
         $msg_erro .= "&nbsp;Select $table_temporaria - falha:&nbsp;db/mysqli:&nbsp;";
         $msg_erro .= mysqli_error($conex).$msg_final;
         echo $msg_erro;  
         exit();          
    }
    //
    //  Nr. de registros
    $num_rows = mysqli_num_rows($query);
    //
    //   Pegando os nomes dos campos  do primeiro Select
    $num_fields=mysqli_num_fields($query);  ///  Obtem o numero de campos do resultado
    $td_menu = $num_fields+1;          
    //      
    /**   Parte tentando pegar o tamanho maior da coluna (campo)   */
    for( $i = 0;$i<$num_fields; $i++) {  ///  Pega o nome dos campos
         //
         $fields[] = mysqli_field_name($query,$i);
         ///  Pegando o maximo do espaco ocupado de cada campo 
         ///  vindo do primeiro Select - $query
         $max_length.= " MAX(LENGTH(TRIM($fields[$i]))) as campo$i ";
         if( $i<($num_fields-1) ) $max_length.= ", "; 
    }
    /**  Final - for( $i = 0;$i<$num_fields; $i++) {  */
    //
    /***
    *    O charset UTF-8  uma recomendacao, 
    *    pois cobre quase todos os caracteres e 
    *    símbolos do mundo
    ***/
     mysqli_set_charset($conex,'utf8');
     //
     ///  $sqlcmd="SELECT ".$max_length." FROM  ".$_SESSION["table_temporaria"]."   ";
     $sqlcmd="SELECT ".$max_length." FROM  $table_temporaria ";
     $result_max_length = mysqli_query($conex,$sqlcmd);          
     ////
     if( ! $result_max_length ) {  
          /**
          *    die('ERRO: Select maximo tamanho dos campos da tb  $temp_tabela - falha: '.mysqli_error($conex));
          */
          // 
          $msg_erro .= "&nbsp;Select maximo tamanho dos campos da tabela  $table_temporaria - falha:&nbsp;db/mysqli&nbsp;";
          $msg_erro .= mysqli_error($conex).$msg_final;
          echo $msg_erro;  
          exit();          
     }    
     /// Nr. de digitos desse elemento
     $num_rows = (int) strlen(trim($num_rows)); 
     $campo_n=2;   
     //


/**  
echo "ERRO: LINHA188 -->> tb_cons_pessoal  -->> CHEGA <<-- \$row = $row   -->>  \$usuario_conectado = $usuario_conectado <<-- <br>"
            ." -->>  \$num_rows =<b> $num_rows </b> <<-->>  \$total_regs = $total_regs <<--<br/>\n";
exit();
 */



     /**   Como repetir uma string ou caractere 
     *       um numero determinado de vezes      
     */
     $n_simbolo = "&nbsp;"; 
     $n_simbolo = str_repeat($n_simbolo,$num_rows);
     if( intval($num_rows)<=1 ) $n_simbolo = "";
     //  FINAL do tamanho do campo
     //
     // Iniciando TABELA de dados
     /**   opcionalmente, imprimir um cabe?alho em negrito na parte superior da tabela  */
     // 
     /**  
     *  $font_size_family="font-size: x-small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace; ";
     *  $font_size_family.=" padding: 3px; empty-cells: show; "; 
     */
     //  $m_function="enviando_dados";    
     $m_function=$_SESSION["m_function"];
     //  echo "<div id='div_pagina' style='width: 99%; height: 100%;' >";
     echo '<div class="tb_consulta" >';
     //    echo $_SESSION["titulo"];
     /**   echo "<table style='margin-left: 3px; border: 0px solid #000000;' cellpadding='1' cellspacing='2' >";  */
     // 
     echo "<table>";
     echo "<caption>{$_SESSION["titulo"]}</caption>";    
     echo "<tr>"; 
     for( $coln = 0; $coln < $num_fields; $coln++ ) {
          //
          $field_name = $fields[$coln];
          echo "<th align='LEFT'  class='font_size_family'  "
                 ." style='background-color: #00FF00;' >"
                 .ucfirst($field_name)."</th>";
          // 
     }
     /**  Final - for( $coln = 0; $coln < $num_fields; $coln++ ) { */
    echo "</tr>";
    //
    // print the body of the table
    $conta_linha=0; $sem_link=0;
    while( $linha = mysqli_fetch_row($query)) {
        /// link        
         ?>       
        <tr align="left" id="tr_itemOn" class="itemOn"  style="cursor: none;" onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  >
        <?php
        //
        $fnup="";
        for( $coln=0; $coln<$num_fields; $coln++) {
            //
            $field_name = $fields[$coln];
            //
            // Codigo da Pessoa
            $codpessoa=mysqli_result($query,$conta_linha,"codigousp");
            //
            $fnup=strtoupper(trim($field_name));
            if( $fnup=='RELATEXT' ) {
                //
                /**  
                 *  $valor=htmlentities(trim(mysqli_result($query,$conta_linha,"relatext")));                   
                 */
                $valor=trim(mysqli_result($query,$conta_linha,"relatext"));                   
                //
                $valor = substr($valor,strpos($valor,"_")+1,strlen(trim($valor)));      
                //
                $m_relatext=$linha[$coln]; $sem_link=1;
                //
            } else {
                $valor=$linha[$coln]; $sem_link=0;                                          
            }
            /***
            if( intval($sem_link)==1 ) {
                 echo   "<a href='javascript: $m_function(\"DESCARREGAR\",\"$m_relatext\",\"$usuario_conectado#anotacao\")' "
                          ." id='m_selecionado' class='link_href' title='Clicar para selecionar Anota&ccedil;&atilde;o'  >";                
            }
            ***/
           ?>
             <td  id="tr_itemOn" class="itemOn"  onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);" 
                    style="text-align: <?php echo $text_align;?>; white-space:nowrap; font-weight: bold; border: 1px solid #000000; <?php echo $font_size_family;?> ">                
                <?php  
                  //
                  $mpagina = $_SESSION["pagina"];
                  $cmdhtml = "<a href='#' onclick='javascript: $m_function(\"MOSTRAR\",\"$codpessoa\",\"$mpagina\"); return true;'  class='linkum'   "
                        ."  title='Clicar'  style='color:#000000; text-align: center; vertical-align:top; line-height:normal;' >";  
                  // $cmdhtml .=utf8_decode($valor)." XX</a>";
                  $cmdhtml .="{$valor}</a>";
                  echo $cmdhtml;
                  //
                ?>
                </td>
           <?php          
            ///  if( intval($sem_link)==1 ) echo "</a>";                               
        }  
        /**  Final - for( $coln=0; $coln<$num_fields; $coln++) { */
        //
    ?>
      </tr>
    <?php
       $conta_linha++;
    }
    //
    // Calculando pagina anterior
    $menos = $pagina - 1;
    //
    // Calculando pagina posterior
    $mais = $pagina + 1;
    //
    $pgs = ceil($total_regs/$maximo);
    /// $pgs = 10;
    if( intval($pgs)>10 ) $pgs=10;
    
    //  Total de paginas
    $_SESSION["numero_de_pags"] = (int) ($total_regs/$maximo);
    $_SESSION["valor_com_pags"] = (int) ($_SESSION["numero_de_pags"]*$maximo);
    if( $_SESSION["valor_com_pags"]<$total_regs ) {
          $_SESSION["numero_de_pags"]++;
    } 
    //
    /** Nr. de paginas  */
    $npgs = (int) $_SESSION["numero_de_pags"];
    //
    /**  Caso variavel MAIOR que 1  */
    if( intval($pgs)>1 ) {
        //
        $td_menu=$td_menu*2;
        //
        $font_size_family="font-size: small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace;"; 
        echo "<tr style='width: 100%; text-align: center;  margin-bottom: 0px;  padding-bottom: 0px; '  >";
        echo   "<td class='table_td' colspan=".$td_menu." style='text-align: center; '  align='center' >";
        echo  '<table border="0"  cellpadding="1"  cellspacing="0"  align="center" style="margin-top: 0px; padding-top: 0px; " >';    
        echo "<tr  style='padding: 0px;' >";
        echo  "<td style='".$font_size_family."' >";
        //
        //   Mostragem de pagina
        //  Pagina inicial
        if( intval($total_regs)>0 && intval($menos)>0 ) {
                $iniciando="0";
                echo "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$iniciando\");'  "
                ." class='texto_paginacao' style='cursor: pointer;padding-rigth:4px;' alt='Clicar' >"
                ."in&iacute;cio</a>&nbsp;";
         }  
        ///  Pagina anterior
        if( intval($menos)>0 ) {
            /// echo "<a href=\"?pagina=$menos&seed=$seed\" class='texto_paginacao'>anterior</a> ";
            /// echo "<a href=\"$pagina_atual?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
            /// echo "<a href=\"?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
            echo  "<a href='javascript: $m_function(\"Lista\",\"$menos\");' "
                  ." class='texto_paginacao' style='cursor: pointer;padding:0 2px 0 2px;' title='Clicar' >"
                  ."anterior</a>&nbsp;";
        }
        
        /// Listando as paginas
        $n_pags=8;
        if( $_SESSION["valor_com_pags"]==$pagina ) {
            $pag_id=$pagina-$n_pags;
            if( intval($pag_id)<1 ) {
                $pag_id=1;   
            }
        } else {
            $pag_id=$pagina;   
        }
        //
        for( $i=1; $i <= $n_pags; $i++ ) {
             $pag_id++;
             if( $pag_id<=$npgs ) {
                 //
                 if( $pag_id != $pagina) {
                      echo  "<a href='javascript: $m_function(\"Lista\",\"$pag_id\");' "
                               ." class='texto_paginacao' style='padding:0 5px 0 5px;' title='Clicar' >"
                               ."$pag_id</a>&nbsp;";
                      ///           
                 } else {
                     echo  "&nbsp;<span class='texto_paginacao_pgatual' style='padding:0 3px 0 3px;' >"
                              .$pag_id."</span>&nbsp;";   
                 } 
                 //
             }     
             /**  Final - if( $pag_id<=$npgs ) {  */
             //
        }
        /**  Final - for( $i=1; $i <= $n_pags; $i++ ) {  */
        //
        // Proxima pagina
        //  if($mais <= $pgs) {
        if( $mais<=$npgs || ($inicio+$maximo)<$total_regs ) { 
             //
             $_SESSION["valor"]=$mais;
             echo  "<a href='javascript: $m_function(\"Lista\",\"$mais\");'   "
                  ." class='texto_paginacao' style='padding:0 1px 0 1px;'  title='Clicar' >"
                  ."pr&oacute;xima</a>&nbsp;";
             //
        }
        ///  Ultima pagina
        $ultima_pagina = (int) $_SESSION["pagina_final"];
        if ( $ultima_pagina!=$pagina && ($inicio+$maximo)<$total_regs ) {
             $_SESSION["valor"]=$ultima_pagina;
             echo  "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$ultima_pagina\");'   "
                   ." class='texto_paginacao' style='padding-left: 4px;' title='Clicar' >"
                   ."final</a>";
        }
        echo "</td></tr></table>";
        echo "</td></tr>"; 
        //
    }  
    /**  Final - if( intval($pgs)>1 ) {  */
    //
    echo "</table>"; 
    echo "</div>";
    //
    echo '<!--  FINAL da Tabela de dados  -->';    
    //
    exit();
    //
}
//
?>