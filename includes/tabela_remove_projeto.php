<?php
//// Iniciando as SESSION´s
if(!isset($_SESSION)) {
   session_start();
}
///
////  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";

/*
    Exibindo a Tabela de Consulta do Pessoal
*/
$campos_query = "*";

// Declara??o da pagina inicial
$pagina = $_SESSION["pagina"];
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo  utf8_decode("ERRO: Sessão incluir_arq não está ativa.");
    exit();
}
///
if( intval($pagina)<1 ) {
    $pagina=1;
}
//  Maximo de registros por pagina
//  $maximo = 16;
$maximo=10;

// Calculando o registro inicial
$inicio = $pagina - 1;
$inicio = $maximo * $inicio;
////  Variaveis recebidos e criando absoletos
if( isset($_SESSION["num_rows"]) ) {
     if( intval($_SESSION["num_rows"])>=1 ) {
        unset($_SESSION["num_rows"]);
	    // Conta os resultados no total da minha query
	    //  $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
	    //  $query    = mysql_query($strCount);
	    $_SESSION["row"]  = mysql_fetch_array($resultado_outro);
	    $_SESSION["total_regs"] = mysql_num_rows($resultado_outro);
	    $_SESSION["passou"]=1; $total_regs = $_SESSION["total_regs"];
        for( $z=1; $z<99999 ; $z++ ) {
               $valor_final[$z] = $z*$maximo;
               if( $valor_final[$z]>$total_regs ) {
                        $_SESSION["pagina_final"] = $maximo-($valor_final[$z]-$total_regs);
			            $_SESSION["pagina_final"] = $total_regs-$_SESSION["pagina_final"];
 			            $_SESSION["pagina_final"] = (int) ($_SESSION["pagina_final"]/$maximo)+1;
                         break;
               }
         }
    }
}    
//  \$row = array  e  \$total_regs = total_regs de registros encontrados
$row=$_SESSION["row"]; $total_regs = $_SESSION["total_regs"];
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado=$_SESSION["usuario_conectado"];
///
if( intval($total_regs)<=0 ) {
    echo "<p  class='titulo_usp'  >Nenhum registro encontrado.</p>";
} else {
    ////
    ///  Conexao com o banco:
    if( ! isset($_SESSION["table_remover_projeto"])  ) {
         $msg_erro .= utf8_decode("&nbsp;Sessão table_remover_projeto não definida - falha:&nbsp;db/mysql&nbsp;").$msg_final;
         echo $msg_erro;  
         exit();    
    }
    $temp_tabela=$_SESSION["table_remover_projeto"];    
    /// Definindo as variaveis
    $num_fields=0; $m_ordenar="nome"; $max_length="";
     /// 
	$strQuery="SELECT $campos_query FROM  $temp_tabela  LIMIT $inicio,$maximo";  
	$query = mysql_query($strQuery);
    if( ! $query ) {
         ///   die('ERRO: Sem resultado - Select - falha: '.mysql_error());   
         $msg_erro .= "&nbsp;Sem resultado - Select - falha:&nbsp;db/mysql&nbsp;";
         $msg_erro .= mysql_error().$msg_final;
         echo $msg_erro;  
         exit();          
    }
    ///  Numero de registros
    $num_rows = mysql_num_rows($query);
    ///   Pegando os NOMES dos campos  do primeiro Select
    $num_fields=mysql_num_fields($query);  ////  Obtem o n?mero de campos do resultado
    $td_menu = $num_fields+1;           

    ///  Parte tentando pegar o tamanho maior da coluna (campo)
    $max_length="";
    for( $i = 0;$i<$num_fields; $i++) { //  Pega o nome dos campos
         $fields[] = mysql_field_name($query,$i);
         //  Pegando o maximo do espaco ocupado de cada campo 
         //  vindo do primeiro Select - $query
         $max_length.= " MAX(LENGTH(TRIM($fields[$i]))) as campo$i ";
         if( $i<($num_fields-1) ) $max_length.= ", "; 
         if( $fields[$i]=="codautor" ) $ncodautor=$fields[$i];
     }
     ///
     /// $sqlcmd="SELECT ".$max_length." FROM  ".$_SESSION['table_remove_projeto']."   ";
     $sqlcmd="SELECT ".$max_length." FROM  $temp_tabela  ";
     $result_max_length = mysql_query($sqlcmd);          
     ///
     if( ! $result_max_length ) {
          ////  die('ERRO: Select maximo tamanho dos campos da tb  table_remove_projeto - falha: '.mysql_error());
          $msg_erro .= "&nbsp;Select maximo tamanho dos campos da tabela  $temp_tabela - falha:&nbsp;db/mysql&nbsp;";
          $msg_erro .= mysql_error().$msg_final;
          echo $msg_erro;  
          exit();          
     }    
     /// Numero de digitos desse elemento
     $num_rows = (int) strlen(trim($num_rows)); 
     $campo_n=2;
     
     /*  Como repetir uma string ou caractere 
            um n?mero determinado de vezes      */
     $n_simbolo = "&nbsp;"; 
     $n_simbolo = str_repeat($n_simbolo,$num_rows);
     if( intval($num_rows)<=1 ) $n_simbolo = "";
     ///  FINAL do tamanho do campo
    
     /// Iniciando TABELA de dados
     /// opcionalmente, imprimir um cabe?alho em negrito na parte superior da tabela
     /***
     $font_size_family="font-size: x-small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace; ";
     $font_size_family.=" padding: 3px; empty-cells: show; border-collapse: collapse "; 
    ***/
     ///  
     $m_function=$_SESSION["m_function"];
     ////  $campos_fora = array("ARQUIVO","DATA","AUTOR");
     ///  $campos_fora = array("ARQUIVO","AUTOR");
     $campos_fora = array("ARQUIVO","AUTOR","CODAUTOR","CIP");
     $cabecalho_array = array("DATA","DETALHES");
     $align_right_array=array("CIP","NP","NR","NUMPROJETO");
     $lncodautor="";
     ////
     /***
         echo '<div class="tb_consulta" >';
         echo "<table>";
         echo "<caption>{$_SESSION["titulo"]}</caption>";
         echo "<tr>";
     ***/
    echo "<div id='div_pagina' class='div_pagina' style='margin-left: 1px; width: 99%; height: 100%;' >";
    echo $_SESSION["titulo"];
    echo "<table class='div_pagina' style='margin-left: 3px;' cellpadding='1' cellspacing='2' >";
    echo "<tr>";
    for( $column_num = 0; $column_num < $num_fields; $column_num++ ) {
          $field_name = $fields[$column_num]; $text_align="left";
          $field_name_upper=strtoupper(trim($field_name));
          ///  if( $field_name_upper=='ARQUIVO' or $field_name_upper=='DATA' or $field_name_upper=='DETALHES' ) $text_align="center";
         if( in_array($field_name_upper,$campos_fora) ) continue;
         if( $field_name_upper=='NR' ) $field_name="Nr";
         if( $field_name_upper=='CIP' ) $field_name="CIP";
          if( $field_name_upper=='NP' ) $field_name="NP";
         if(  in_array($field_name_upper,$cabecalho_array) ) $text_align="center";          
          ///  if( $field_name_upper=='DETALHES' ) $text_align="center";         
          //// if( preg_match("/^Nr{1}$|^N$|^NUM$/i",$field_name) ) {
         if( preg_match("/^Nr{1}$|^N$|^Np{1}$|^NUM$|^CIP$/i",$field_name) ) {
               echo "<th class='font_size_family' style='text-align: $text_align; background-color: #00FF00; border: 1px solid #000000;' >"
                     .ucfirst($field_name)."</th>";             
          } else {
               $field_name=preg_replace("/titulo/i","Título",$field_name);
               /// if( strtoupper(trim($field_name))=="DETALHES" ) $field_name="Remover" ;
               if( strtoupper(trim($field_name))=="CIP" ) $field_name="Remover" ;
               $procedimento=" text-align: $text_align; background-color: #00FF00; border: 1px solid #000000;";
               if( preg_match("/^Titulo|Título/i",$field_name) ) {
                    /// $field_name="Título/Projeto";
                    $field_name="Título";
                    $text_align="left";
                    $procedimento=" text-align: $text_align; background-color: #00FF00; border: 1px solid #000000;";                        
               }   
               echo  "<th class=\"font_size_family\" style=\"$procedimento\" >";
               echo  utf8_decode(ucfirst($field_name))."</th>";             
             ///       
          }
     }
     echo "</tr>";
     /// print the body of the table
     $conjunto = $_SESSION["conjunto"];
     $conta_linha=0; $sem_link=0;
     while( $linha = mysql_fetch_row($query) ) {
          //// link        
         ?>       
        <tr align="left" class="font_size" >
        <?php
        $n_index=0;
        for( $column_num=0; $column_num<$num_fields; $column_num++) {
            $text_align="left";  
            $field_name = trim($fields[$column_num]);
            $field_name_upper = strtoupper($field_name);             
            if( in_array($field_name_upper,$campos_fora) ) continue;
            ///  if( strtoupper($field_name)=='relatproj' ) {
            if( $column_num<1 ) $selecionado=$linha[$column_num];
            if( $field_name_upper=='NR' ) $field_name="Nr";
            if( $field_name_upper=='CIP' ) $field_name="CIP";
            ////   if( strtoupper($field_name)=='ARQUIVADO_COMO' ) {
            if( intval($column_num)<1 ) $selecionado=$linha[$column_num];
            ////   if( strtoupper($field_name)=='ARQUIVADO_COMO' ) {
            if( $ncodautor=="codautor" ) {
                 $lncodautor=mysql_result($query,$conta_linha,"codautor");
            } 
           ///  if( $field_name_upper=='TITULO' ) {
            if( preg_match("/ITULO|TÍTULO/i",$field_name_upper) ) {
                ///  $valor=htmlentities(trim(mysql_result($query,$conta_linha,"relatproj")));
                /// $valor=htmlentities(trim(mysql_result($query,$conta_linha,"Arquivo")));                                   
                $valor=htmlentities(trim(mysql_result($query,$conta_linha,"cip")));                                   
                $m_relatproj=$linha[$column_num];  $sem_link=1;
                $titulo=$linha[$column_num];
                ////  Titulo do Projeto
                ?>                        
                <td id="tr_itemOn" class="itemOn" onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  style="text-align: left; white-space: nowrap;  padding: .3em; font-weight: bold; border: 1px solid #000000;" >
                <?php
                  $cmdhtml = "<a href='#' onclick='javascript: remove_projeto(\"REMOVER\",\"$valor\",\"$usuario_conectado#projeto\");return true;'  "
                        ."  id='relatproj'  class='linkum'   title='Clicar'  "
                        ."  style=' text-align: center; vertical-align:top; line-height:normal;' >";  
                  $cmdhtml .="<span style='font-size:larger; ' >$titulo</span>";
                  $cmdhtml .="</a>";
                  echo $cmdhtml;
                ?>  
                </td>
              <?php    
            /// else if - preg_match procurando palavras na variavel $field_name_upper
            } else if( preg_match('/^(CIP|DATA)$/i', trim($field_name_upper)) ) {
                  /// 
                  /// Clicar para mostrar detalhes
                  $n_index=$n_index+1;
                  //// $array_valor[$n_index]=$valor=htmlentities(trim(mysql_result($query,$conta_linha,"Detalhes")));
                  $array_valor[$n_index]=$valor_cip=htmlentities(trim(mysql_result($query,$conta_linha,"cip")));
                  ////$array_valor[$n_index]=$valor=htmlentities(trim(mysql_result($query,$conta_linha,"$field_name")));
                  $text_align="center";
                  $imagem="<img src='../imagens/enviar.gif' alt='Remover Projeto'  title='Clicar' style='text-align: center; vertical-align:text-bottom;'  >";  
                ?>                        
                <td id="tr_itemOn" class="itemOn" onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  style="text-align: <?php echo $text_align;?>; white-space: nowrap;  padding: .3em; font-weight: bold; border: 1px solid #000000;" >
                <?php
                  if( $field_name_upper=='CIP' ) {
                      ?>
                      <img  src="../imagens/enviar.gif"  alt="Remover Projeto"  title='Clicar'
                  style="text-align: center; vertical-align:text-bottom; cursor:pointer; " 
                  onclick="javascript: remove_projeto('REMOVER','<?php echo $valor_cip;?>','<?php echo "$usuario_conectado#projeto";?>');return true;"  >
                      <?php
                  } else {
                     $valor_cpo=htmlentities(trim(mysql_result($query,$conta_linha,"$field_name")));
                     $cmdhtml2 = "<a href='#' onclick='javascript: remove_projeto(\"REMOVER\",\"$valor_cip\",\"$usuario_conectado#projeto\");return true;'  "
                        ."  id='detalhes'  class='linkum'   title='Clicar'  "
                        ."  style=' text-align: center; vertical-align:top; line-height:normal;' >";  
                     $cmdhtml2 .="$valor_cpo</a>";
                     echo  $cmdhtml2;
                  }  
                ?>
                </td>                     
                <?php                
                  ////                
            } else {
                ///  Numero da sequencia dos registros
                $valor=$linha[$column_num];    
                ///  $text_align="right";
                /// Encontrar campo nesse array
                if( in_array("$field_name_upper",$align_right_array) )  $text_align="right";
                /// 
                ?>           
                <td style="text-align: <?php echo $text_align;?>; background-color: #FFFFFF;  padding: .3em; font-weight: bold; border: 1px solid #000000;" >                
                <?php  echo $valor;?></td>
                <?php                
            }   
        }  
        //// Final do For
        ?>
        </tr>
       <?php
       $conta_linha++;
    }  
    ///  Final do WHILE

    /// Calculando pagina anterior
    $menos = $pagina - 1;

    /// Calculando pagina posterior
    $mais = $pagina + 1;

    $pgs = ceil($total_regs/$maximo);
    /// $pgs = 10;
    if( intval($pgs)>10 ) $pgs=10;
    
    ///  Total de paginas
    $_SESSION["numero_de_pags"] = (int) ($total_regs/$maximo);
    $_SESSION["valor_com_pags"] = (int) ($_SESSION["numero_de_pags"]*$maximo);
    if( $_SESSION["valor_com_pags"]<$total_regs ) $_SESSION["numero_de_pags"]++;
    
    ///  Maior que 1
    if( intval($pgs)>1 ) {
        $td_menu=$td_menu*2;
        $pagina_atual = 'http://www-gen.fmrp.usp.br/rexp/consultar/tabela_selecionada.php';
        $font_size_family="font-size: small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace;"; 
        echo "<tr style='width: 100%; text-align: center;  margin-bottom: 0px;  padding-bottom: 0px; '  >";
        echo   "<td class='table_td' colspan=".$td_menu." style='text-align: center; '  align='center' >";
        echo  '<table border="0"  cellpadding="1"  cellspacing="0"  align="center" style="margin-top: 0px; padding-top: 0px; " >';    
        echo "<tr  style='padding: 0px;' >";
        echo  "<td style='".$font_size_family."' >";
        /// Mostragem de pagina
        ///  Pagina inicial
         if(  intval($total_regs)>0 &&  intval($menos)>0 ) {
              $iniciando="0";
              echo "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$iniciando\");'  "
                ." class='texto_paginacao' style='cursor: pointer;' alt='Clicar' >in&iacute;cio</a>&nbsp;";
         }  
         ///  Pagina anterior
        if( intval($menos)>0 ) {
             /// echo "<a href=\"?pagina=$menos&seed=$seed\" class='texto_paginacao'>anterior</a> ";
             /// echo "<a href=\"$pagina_atual?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
             /// echo "<a href=\"?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
             echo  "<a href='javascript: $m_function(\"Lista\",\"$menos\");' "
                     ." class='texto_paginacao' title='Clicar' >anterior</a>&nbsp;";
        }
        
        /// Listando as paginas
        $n_pags=8;
        if( $_SESSION["valor_com_pags"]==$pagina ) {
             $pag_id=$pagina-$n_pags;
             if( intval($pag_id)<1 ) $pag_id=1;
        } else {
            $pag_id=$pagina;   
        }
        ///
        for( $i=1; $i<=$n_pags; $i++) {
                $pag_id++;
                if( $pag_id<=$_SESSION["numero_de_pags"] ) {
                      if( $pag_id != $pagina) {
                          echo  "<a href='javascript: $m_function(\"Lista\",\"$pag_id\");' "
                                  ." class='texto_paginacao'  title='Clicar' >"
                                  ."$pag_id</a>&nbsp;";
                      } else {
                          echo  "&nbsp;<span class='texto_paginacao_pgatual'>".$pag_id."</span>&nbsp;";   
                      }
                }     
        }
        ///
        /// Proxima pagina
        //  if($mais <= $pgs) {
        if( $mais<=$_SESSION["numero_de_pags"] || ( $inicio+$maximo)<$total_regs ) {
            $_SESSION["valor"]=$mais;
            echo  "<a href='javascript: $m_function(\"Lista\",\"$mais\");'   "
                  ." class='texto_paginacao'  title='Clicar'  >pr&oacute;xima</a>&nbsp;";
        }
        ///
        //  Ultima pagina
        $ultima_pagina = (int) $_SESSION["pagina_final"];
        if( $ultima_pagina!=$pagina && ($inicio+$maximo)<$total_regs ) {
             $_SESSION["valor"]=$ultima_pagina;            
             echo  "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$ultima_pagina\");'   "
                   ." class='texto_paginacao'   title='Clicar'  >final</a>";
        }
        echo "</td></tr></table>";
        echo "</td></tr>";
    }  
    /// Final - if \$pgs
    echo "</table>"; 
    echo "</div>";
    ///    echo "</div>";
    ///  <!--  FINAL da Tabela de dados  -->
}
?>