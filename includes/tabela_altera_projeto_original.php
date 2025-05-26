<?php
///  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///  Conexaao com o banco:  alterar um Projeto   
//
/****  Verificando essa SESSAO importante 
//       Caso NAO exista criar - alterado em 20180614
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

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
/// Final - Mensagens para enviar

$campos_query = "*";

/// Declaracao da pagina inicial
$pagina = $_SESSION["pagina"];
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo "ERRO: Sessão incluir_arq não está ativa.";
    exit();
}
///
// if( $pagina=="") {
if( intval($pagina)<1 ) {
    $pagina="1";
}
//  Maximo de registros por pagina
//  $maximo = 16;
$maximo=10;

// Calculando o registro inicial
$inicio = $pagina - 1;
$inicio = $maximo * $inicio;
//  Variaveis recebidos e criando absoletos
if( isset($_SESSION["num_rows"]) ) {
    /// if ( $_SESSION["num_rows"]>=1 ) {
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
///  \$row = array  e  \$total_regs = total_regs de registros encontrados
$row=$_SESSION["row"]; $total_regs = $_SESSION["total_regs"];
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado=$_SESSION["usuario_conectado"];

if( intval($total_regs)<=0 ) {
    echo "<p  class='titulo_usp'  >Nenhum registro encontrado.</p>";
} else {
    ///
    ///  $strQuery   = "SELECT $campos_query $final_query ORDER BY RAND($seed) LIMIT $inicio,$maximo";  
	///  $strQuery   = "SELECT $campos_query from  $temp_usuario ORDER BY RAND($seed) LIMIT $inicio,$maximo";  
    /***
           Verificando SESSION  table_temp_editar  -  20171121
    ***/   
    if( ! isset($_SESSION["table_alterar_projeto"]) ) {
        echo $funcoes->mostra_msg_erro(utf8_decode("Falha SESSION table_alterar_projeto não definida."));    
        exit();
    }
    ///  Tabela Temporaria
    $table_alterar_projeto = $_SESSION["table_alterar_projeto"];
    ///
    $num_fields=0; $m_ordenar="nome";    
    ///  Selecionando os campos da Tabela Temporaria
    ///     Executando Select/MySQL
    ///   Utilizado pelo Mysql/PHP - IMPORTANTE 20180614      
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    ///                         
	$strQuery="SELECT $campos_query  FROM  $table_alterar_projeto  LIMIT $inicio,$maximo";  
	$query = mysql_query($strQuery);
    if( ! $query ) {
         /// die('ERRO: Sem resultado - Select - falha: '.mysql_error());  
         $msg_erro .= "&nbsp;Sem resultado - Select - falha:&nbsp;db/mysql&nbsp;".mysql_error().$msg_final;
         echo $msg_erro;  
         exit();          
    }
    /// Numero de registros
    $num_rows = mysql_num_rows($query);
    ///   Pegando os nomes dos campos  do primeiro Select
    $num_fields=mysql_num_fields($query);  //  Obtem o n?mero de campos do resultado
    $td_menu = $num_fields+1;                
    
    ///  Parte tentando pegar o tamanho maior da coluna (campo)
    $max_length="";
    for( $i = 0;$i<$num_fields; $i++) { //  Pega o nome dos campos
         $fields[] = mysql_field_name($query,$i);
         //  Pegando o maximo do espaco ocupado de cada campo 
         //  vindo do primeiro Select - $query
         $max_length.= " MAX(LENGTH(TRIM($fields[$i]))) as campo$i ";
         if( $i<($num_fields-1) ) $max_length.= ", "; 
     }
     ///   Selecionando o maximo espaco ocupado em cada campo da tabela
     $sqlcmd="SELECT ".$max_length." FROM  $table_alterar_projeto  ";
     $result_max_length = mysql_query($sqlcmd);          
     ///
     if( ! $result_max_length ) {
         /// die('ERRO: Select maximo tamanho dos campos da tabela  table_alterar_projeto - falha: '.mysql_error());
          $msg_erro .= "&nbsp;Select maximo tamanho dos campos da tabela  $table_alterar_projeto - falha:&nbsp;db/mysql&nbsp;".mysql_error();
          echo $msg_erro.$msg_final;  
          exit();                 
     }    
     /// 
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
    $font_size_family="font-size: x-small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace; ";
    $font_size_family.=" padding: 3px; empty-cells: show; border-collapse: collapse "; 
    ///  $m_function="enviando_dados";    
    $m_function=$_SESSION["m_function"];
    ///  NAO incluir esses Campos na Tabela 
    $campos_fora = array("ARQUIVO","DATA","AUTOR","OBJETIVO_DESCRICAO","FONTE_RECURSO","IDENTIFICACAO","CORESP","FINAL","CIP");
    echo "<div id='div_pagina' style='margin-left: 1px; width: 99%; height: 100%;' >";
    echo $_SESSION["titulo"];
    echo "<TABLE style='width: 100%; margin-left: 3px; border: 0px solid #000000;' cellpadding='1' cellspacing='2' >";
    echo "<tr>";
    for( $column_num = 0; $column_num < $num_fields; $column_num++ ) {
          $field_name = $fields[$column_num]; $text_align="left";
          $field_name_upper=strtoupper(trim($field_name));
          //  if( $field_name_upper=='ARQUIVO' or $field_name_upper=='DATA' or $field_name_upper=='DETALHES' ) $text_align="center";
          if( in_array($field_name_upper,$campos_fora) ) continue;
          if( $field_name_upper=='DETALHES' ) $text_align="center";
          echo "<th  align='left' "
                ." style='text-align: $text_align; background-color: #00FF00; border: 1px solid #000000; $font_size_family '>"
                .ucfirst($field_name)."</th>";
          ///      
    }
    echo "</tr>";
    /// print the body of the table
    $conjunto = $_SESSION["conjunto"];
    $conta_linha=0; $sem_link=0;
    while( $linha = mysql_fetch_row($query)) {
        // link 
        $cip= (int) mysql_result($query,$conta_linha,"cip");                                   
         ?>       
        <tr align="left" valign="top"  >
        <?php
        $n_index=0;
        for( $column_num=0; $column_num<$num_fields; $column_num++ ) {
            $text_align="left";  
            $field_name_upper = strtoupper(trim($fields[$column_num]));             
            if( in_array($field_name_upper,$campos_fora) ) continue;
            ///  if( strtoupper($field_name)=='relatproj' ) {
            if( $column_num<1 ) $selecionado=$linha[$column_num];
            ///   if( strtoupper($field_name)=='ARQUIVADO_COMO' ) {
            if( $field_name_upper=='TITULO' ) {
                 /// $valor=htmlentities(trim(mysql_result($query,$conta_linha,"Arquivo")));                                   
                $m_relatproj=$linha[$column_num];  $sem_link=1;
                $titulo=$linha[$column_num];
                ?>                        
                <td id="tr_itemOn" class="itemOn" onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);" 
                  style="text-align: left; white-space:nowrap; font-weight: bold; border: 1px solid #000000; <?php echo $font_size_family;?> ">
                <?php
                  $cmdhtml = "<a href='#' onclick='javascript: altera_projeto(\"busca_proj\",\"$cip\",\"$usuario_conectado#projeto\");return true;'  id='relatproj'  class='linkum'   "
                        ."  title='Clicar'  style='color:#000000; text-align: center; vertical-align:top; line-height:normal;' >";  
                  $cmdhtml .="$titulo</a>";
                  echo $cmdhtml;
                ?>  
                </td>
              <?php    
            } else {
                $valor=$linha[$column_num];    
                ?>                        
                <td  id="tr_itemOn" class="itemOn"  onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);" 
                    style="text-align: <?php echo $text_align;?>; white-space:nowrap; font-weight: bold; border: 1px solid #000000; <?php echo $font_size_family;?> ">                
                <?php  
                  $cmdhtml = "<a href='#' onclick='javascript: altera_projeto(\"busca_proj\",\"$cip\",\"$usuario_conectado#projeto\");return true;'  class='linkum'   "
                        ."  title='Clicar'  style='color:#000000; text-align: center; vertical-align:top; line-height:normal;' >";  
                  $cmdhtml .=$valor."</a>";
                  echo $cmdhtml;
                ?>
                </td>
                <?php                
            }   
        }  
        /// Final - for( $column_num=0; $column_num<$num_fields; $column_num++ )
        ?>
        </tr>
       <?php
       $conta_linha++;
    }  
    ///  Final do WHILE

    /// Calculando pagina anterior
    $menos = $pagina - 1;

    // Calculando pagina posterior
    $mais = $pagina + 1;

    $pgs = ceil($total_regs/$maximo);
    
    /// $pgs = 10;
    if( intval($pgs)>10 ) $pgs=10;
    
    ///  Total de paginas
    $_SESSION["numero_de_pags"] = (int) ($total_regs/$maximo);
    $_SESSION["valor_com_pags"] = (int) ($_SESSION["numero_de_pags"]*$maximo);
    if( $_SESSION["valor_com_pags"]<$total_regs ) $_SESSION["numero_de_pags"]++;
    ///
    if( intval($pgs)>1 ) {
        $td_menu=$td_menu*2;
         //// $pagina_atual = 'http://www-gen.fmrp.usp.br/rexp/consultar/tabela_selecionada.php';
        $font_size_family="font-size: small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace;"; 
        echo "<tr style='width: 100%; text-align: center;  margin-bottom: 0px;  padding-bottom: 0px; '  >";
        echo   "<td class='table_td' colspan=".$td_menu." style='text-align: center; '  align='center' >";
        echo  '<table border="0"  cellpadding="1"  cellspacing="0"  align="center" style="margin-top: 0px; padding-top: 0px; " >';    
        echo "<tr  style='padding: 0px;' >";
        echo  "<td style='".$font_size_family."' >";
        ///  Mostragem de pagina
        ///  Pagina inicial
        if( intval($total_regs)>0 && intval($menos)>0 ) {
             $iniciando="0";
             echo  "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$iniciando\");'  "
                  ." class='texto_paginacao' style='cursor: pointer;' alt='Clicar' >in&iacute;cio</a>&nbsp;";
        }  
        ///  Pagina anterior
        if( intval($menos)>0  ) {
            /// echo "<a href=\"?pagina=$menos&seed=$seed\" class='texto_paginacao'>anterior</a> ";
            /// echo "<a href=\"$pagina_atual?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
            /// echo "<a href=\"?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
            echo  "<a href='javascript: $m_function(\"Lista\",\"$menos\");' "
                   ." class='texto_paginacao'  title='Clicar' >anterior</a>&nbsp;";
        }
        ///
        /// Listando as paginas
        $n_pags=8;
        if( $_SESSION["valor_com_pags"]==$pagina ) {
            $pag_id=$pagina-$n_pags;
            if( intval($pag_id)<1 ) $pag_id=1;
        } else {
            $pag_id=$pagina;    
        }
        ///
        for( $i=1;$i <= $n_pags; $i++ ) {
             $pag_id++;
             if( $pag_id<=$_SESSION["numero_de_pags"] ) {
                  if( $pag_id != $pagina) {
                       echo  "<a href='javascript: $m_function(\"Lista\",\"$pag_id\");' "
                                 ." class='texto_paginacao'  title='Clicar' >"
                                 ."$pag_id</a>&nbsp;";
                  } else {
                       echo "&nbsp;<span class='texto_paginacao_pgatual'>".$pag_id."</span>&nbsp;";    
                  }
             }     
        }
        ///
        /// Proxima pagina
        ///  if($mais <= $pgs) {
        if( $mais<=$_SESSION["numero_de_pags"] || ($inicio+$maximo)<$total_regs ) {
            echo  "<a href='javascript: $m_function(\"Lista\",\"$mais\");'   "
                   ." class='texto_paginacao'  title='Clicar'  >pr&oacute;xima</a>&nbsp;";
        }
        ///
        ///  Ultima pagina
        $ultima_pagina = (int) $_SESSION["pagina_final"];
        if( $ultima_pagina!=$pagina && ($inicio+$maximo)<$total_regs ) {
             echo  "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$ultima_pagina\");' "
                   ." class='texto_paginacao'   title='Clicar'  >final</a>";
        }
        echo "</td></tr></table>";
        echo "</td></tr>";
    }  
    /// Final - if \$pgs
    echo "</TABLE>"; 
    echo "</div>";
  ///    <!--  FINAL da Tabela de dados  -->
    exit();
}
///
?>