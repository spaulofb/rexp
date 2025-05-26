<?php
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///  Conexao com o banco:  Anotacoes de um Projeto - 20180221
///
/****  Verificando essa SESSAO importante 
//       Caso NAO exista criar - alterado em 20171031
****/
if( ! isset($_SESSION["url_central"]) ) {
    echo  utf8_decode("ERRO: falha grave sessão url_central não existe.");
    exit();
}
$url_central = $_SESSION["url_central"];
///
////  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
////  Final - Mensagens para enviar

///  Conex?o com o banco:
    
/*
mysql_connect("localhost","desenvolvimento","12345");
mysql_select_db("test");

// Informa??es da query. No caso, "SELECT * FROM produtos WHERE EXIBIR=1 ORDER BY RAND()"
$campos_query = "*";
$final_query  = "FROM produtos WHERE EXIBIR=1";
*/
$campos_query = "*";
$_SESSION["anotacao_cip_altexc"]="";
///
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo "ERRO: Sessão incluir_arq não está ativa.";
    exit();
}
///
/// Declaracao  da pagina inicial
$pagina = $_SESSION["pagina"];

/// if( $pagina=="") {
if( $pagina<1 ) {
    $pagina="1";
}
///  Maximo de registros por pagina
///  $maximo = 16;
$maximo=10;

// Calculando o registro inicial
$inicio = $pagina - 1;
$inicio = $maximo * $inicio;

///  Variaveis recebidos e criando absoletos
///  Variaveis recebidos e criando obsoletos
if( isset($_SESSION["num_rows"]) ) {
    if ( $_SESSION["num_rows"]>=1 ) {
        unset($_SESSION["num_rows"]);
        // Conta os resultados no total da minha query
        //  $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
        //  $query    = mysql_query($strCount);
     ///   $_SESSION["row"]  = mysql_fetch_array($result_outro);
     ///   $_SESSION["total_regs"] = mysql_num_rows($result_outro);
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
////  \$row = array  e  \$total_regs = total_regs de registros encontrados
////  $row=$_SESSION["row"]; 
$total_regs = $_SESSION["total_regs"];

$usuario_conectado = $_SESSION["usuario_conectado"];

if( intval($total_regs)<=0 ) {    
    echo "<p  class='titulo_usp'  >Nenhum registro encontrado.</p>";
} else {
    // if( !isset($_GET["seed"]) ) {
       //   $seed = rand();   // Caso ainda nao exista uma semente, cria a semente via PHP.
    // } else {
        /* Caso ja exista uma semente, 
		   utiliza a que foi passada na url. (o addslashes ? por quest?o de seguran?a) */
	   //  $seed = addslashes($_GET["seed"]);
    // }
    //  $strQuery   = "SELECT $campos_query $final_query ORDER BY RAND($seed) LIMIT $inicio,$maximo";  
	//  $strQuery   = "SELECT $campos_query from  $temp_usuario ORDER BY RAND($seed) LIMIT $inicio,$maximo";  
    //  Conex?o com o banco:
    ///  include('../inicia_conexao.php');
    /***
           Verificando SESSION  table_temp_editar  -  20180530
    ***/   
    if( ! isset($_SESSION["table_consultar_anotacao"]) ) {
        echo $funcoes->mostra_msg_erro(utf8_decode("Falha SESSION table_consultar_anotacao não definida."));    
        exit();
    }
    ///  Tabela Temporaria 
    $table_consultar_anotacao=$_SESSION["table_consultar_anotacao"];
    
    $m_linhas=0; $num_fields=0; $m_ordenar="nome";    
     ///
	$strQuery="SELECT $campos_query  FROM  $table_consultar_anotacao LIMIT $inicio,$maximo";  
	$query      = mysql_query($strQuery);
    if( ! $query ) {
       die('ERRO: Sem resultado - Select - falha: '.mysql_error());   
    }
    //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array - IMPORTANTE
    /*  $array_projeto_cpos=mysql_fetch_array($query);
       foreach( $array_projeto_cpos as $chave_proj => $valor_proj ) {
              echo " $chave_proj = $valor_proj  <br>";
       }                  
       exit();
    */
    $num_rows = mysql_num_rows($query);
    ///   Pegando os nomes dos campos  do primeiro Select
    $num_fields=mysql_num_fields($query);  ///  Obtem o n?mero de campos do resultado
    $td_menu = $num_fields+1;                
    
    //  Parte tentando pegar o tamanho maior da coluna (campo)
    $max_length="";
    for( $i = 0;$i<$num_fields; $i++) { //  Pega o nome dos campos
         $fields[] = mysql_field_name($query,$i);
         //  Pegando o maximo do espaco ocupado de cada campo 
         //  vindo do primeiro Select - $query
         $max_length .= " MAX(LENGTH(TRIM($fields[$i]))) as campo$i ";
         if( $i<($num_fields-1) ) $max_length.= ", "; 
     }
     ///   Selecionando o maximo espaco ocupado em cada campo da tabela
     $sqlcmd="SELECT ".$max_length." FROM    ".$_SESSION["table_consultar_anotacao"]."   ";
     $result_max_length = mysql_query($sqlcmd);          
     ///
     if ( ! $result_max_length ) {
          die('ERRO: Select maximo tamanho dos campos da tb  $temp_tabela - falha:&nbsp;db/mysql&nbsp;'.mysql_error());                  
          exit();
     }        
     ///  Numero de registros
     $num_rows = (int) strlen(trim($num_rows)); 
     $campo_n=2;
     /*  Como repetir uma string ou caractere 
            um n?mero determinado de vezes      */
     $n_simbolo = "&nbsp;"; $n_simbolo = str_repeat($n_simbolo,$num_rows);
     if( $num_rows<=1 ) $n_simbolo = "";
     ///  FINAL do tamanho do campo
    
    ///  Alterado 20120720
    ///  $campos_fora = array("ARQUIVO","DATA","PROJETO_TITULO","AUTOR","PROJETO_AUTOR");    
    $campos_fora = array("ARQUIVO","PROJETO_TITULO","AUTOR","PROJETO_AUTOR","ALTERA","ALTERADA","CIA");
    ///    
    $ar_cps_final_tab= array("ALTERAR","EXCLUIR");
    $cabecalho_array = array("DATA","DETALHES","$ar_cps_final_tab[0]","$ar_cps_final_tab[1]");
    $array_cps_largura= array("NUMPROJETO" => 66, "NR" => 76, "TITULO" => 560, "DETALHES" => 58, "DATA" => 68, "$ar_cps_final_tab[0]" => 52, "$ar_cps_final_tab[1]" => 52 );
    
    ///   Usando  DIVs e  duas Tabelas --  primeiro Div scrollTable 
    /// Iniciando TABELA de dados
    /// opcionalmente, imprimir um cabe?alho em negrito na parte superior da tabela
    $font_size_family="font-size: x-small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace; ";
    $font_size_family.=" padding: 3px; empty-cells: show; "; 
    ///
    ///  Importante para acentuacao
    ini_set('default_charset', 'UTF8');
    ///
    ///  $m_function="enviando_dados";    
    $m_function=$_SESSION["m_function"];
    ////  echo "<div class='scrollTable' style='height: 270px; ' >";
    echo "<div id='div_pagina' style='margin-left: 1px; width: 99%; height: 100%;' >";
    echo $_SESSION["titulo"];
    ////  echo "<TABLE class='header' style='margin-bottom: 0px;' >";
    echo "<TABLE style='width: 100%; margin-left: 3px; border: 0px solid #000000;' cellpadding='1' cellspacing='2' >";
    echo "<tr>";
    for( $column_num = 0; $column_num < $num_fields; $column_num++) {
            $field_name = $fields[$column_num]; $text_align="left";
            $field_name_upper=strtoupper(trim($field_name));
            //  if( $field_name_upper=='ARQUIVO' or $field_name_upper=='DATA' or $field_name_upper=='DETALHES' ) $text_align="center";
            if( in_array($field_name_upper,$campos_fora) ) continue;
            /***
            $font_size='';
            if(  in_array($field_name_upper,$cabecalho_array) ) {
                $text_align="center";  $font_size='font-size: x-small;';             
            } 
            ***/
            if( $field_name_upper=='TITULO' ) $field_name="Título/Anotação";
            //// if( $field_name_upper=='NUMPROJETO' ) $field_name="Nr/Projeto";
            if( $field_name_upper=='NUMPROJETO' ) $field_name="Projeto";
            ///   if( $field_name_upper=='NR' ) $field_name="Nr/Anota??o";
            if( $field_name_upper=='NR' ) $field_name="Anotação";
         ////   if(  array_key_exists($field_name_upper,$array_cps_largura) ) $cpo_largura=$array_cps_largura[$field_name_upper];
         /***   echo "<TH ALIGN=\"LEFT\" style=\" $font_size text-align: $text_align; width: {$cpo_largura}px;\">"
                    .ucfirst($field_name)."</TH>";
                    ***/
            echo "<th align='LEFT' "
                ." style='text-align: $text_align; background-color: #00FF00; border: 1px solid #000000; $font_size_family ' >"
                .ucfirst($field_name)."</th>";
            ///    
    }
    ////  echo "<th  >&nbsp;</th>";
    echo "</tr>";
 ///   echo  "</TABLE>";
///    echo "<div class='scroller' style='height: 240px; border: 1px solid  #000080; top: 0px; margin-top: 0px; ' >"; 
///    echo "<TABLE  >";
    // print the body of the table
    $conjunto = $_SESSION["conjunto"];
    $conta_linha=0; $sem_link=0;
    while( $linha = mysql_fetch_row($query)) {
        /// link        
         ?>       
        <tr align="left"  id="tr_itemOn" class="itemOn"  style="cursor: pointer;"  onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  >
        <?php
        for( $column_num=0; $column_num<$num_fields; $column_num++) {
            $text_align="left";  
            $field_name_upper = strtoupper(trim($fields[$column_num]));             
            ///
            ///  Codigo de Identificacao da Anotacao
            $_SESSION["cia"] = (int) mysql_result($query,$conta_linha,"cia");
            ///
            if( in_array($field_name_upper,$campos_fora) ) continue;
            if( array_key_exists($field_name_upper,$array_cps_largura) ) {
                 $cpo_largura=$array_cps_largura[$field_name_upper];   
            }
            ///
            ///  Numero da Anotacao do Projeto acima
            $_SESSION["nr"] = $nr = (int) mysql_result($query,$conta_linha,"nr");
            
            ////  $_SESSION["anotacao_cip_altexc"]=$_SESSION["cip"];                  
            $_SESSION["anotacao_cip_altexc"]="Anotacao#@=".$_SESSION["usuario_conectado"]."#@=".$_SESSION["cip"]."#@=".$nr; 
            $anotacao_cip_altexc=$_SESSION["anotacao_cip_altexc"];
            ///

            
            
            ///  if( strtoupper($field_name)=='RELATEXT' ) {
            if( intval($column_num)<1 ) $selecionado=$linha[$column_num];
            ///   if( strtoupper($field_name)=='ARQUIVADO_COMO' ) {
            ///  TITULO da Anotacao
            if( $field_name_upper=='TITULO' ) {
                ///  $valor=htmlentities(trim(mysql_result($query,$conta_linha,"relatext")));         
                $valor=htmlentities(trim(mysql_result($query,$conta_linha,"Arquivo")));
                /// $valor = substr($valor,strpos($valor,"_")+1,strlen(trim($valor)));
                ///  $valor="<img src='../imagens/enviar.gif' alt='Enviar Arquivo'  style='text-align: center; vertical-align:text-bottom;'  >";
                $m_relatext=$linha[$column_num];  $sem_link=1;
               ///   $titulo=$linha[$column_num];
                
                //  PARTES do Titulo do Projeto - dividindo em sete partes 
                $partes_antes=9;
                $titulo="";
                $palavras_titulo = explode(" ",trim($linha[$column_num]));
                $contador_palavras=count($palavras_titulo);
                for( $i=0; $i<$contador_palavras; $i++  ) {
                     $titulo .="{$palavras_titulo[$i]} ";
                     if( $i==$partes_antes and $contador_palavras>$partes_antes  ) {
                          $titulo=trim($titulo);
                          $tamanho_campo=strlen($titulo);
                          if( $tamanho_campo>40  ) $titulo.="...";
                          ///  $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
                          break;
                     }
                }
                ?>                        
                <td id="tr_itemOn" class="itemOn" onmouseover="javascript: mouse_over_menu(this);" 
                  onmouseout="javascript: mouse_out_menu(this);" style="text-align: left; white-space:nowrap;" >
                <?php
                  $cmdhtml = "<a href='#' onclick='javascript: consulta_mostraanot(\"DESCARREGAR\",\"$valor\",\"$usuario_conectado#anotacao\");return true;'  "
                        ."  id='relattext'  class='linkum'   "
                        ."  title='Clicar'  style='text-align: center; line-height:normal;font-size:medium;' >";  
                  $cmdhtml .=htmlentities($titulo)."</a>";
                  $cmdhtml .="</td>";
                  echo $cmdhtml;
                  ///
            } else if( $field_name_upper=='DETALHES' ) {
                  $valor=$linha[$column_num]; $text_align="center";
                  $detalhes="<img src='../imagens/enviar.gif' alt='Mostrar detalhes dessa Anota??o'  style='text-align: center; vertical-align:text-bottom;'  >";  
                ?>                        
                <td id="tr_itemOn" class="itemOn" onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  style="text-align: <?php echo $text_align;?>; white-space:nowrap; " >
                <?php
                  $cmdhtml2 = "<a href='#' onclick='javascript: consulta_mostraanot(\"DETALHES\",\"$valor\",\"$usuario_conectado#anotacao\");return true;' id='detalhes'  class='linkum'  "
                        ."  title='Clicar'  style=' text-align: center; line-height:normal;' >";  
                  $cmdhtml2 .=$detalhes."</a>";
                  $cmdhtml2 .="</td>";
                  echo $cmdhtml2;                                                    
                  ///
            } else {
                $valor=$linha[$column_num]; 
                $font_size=""; $padding_right="";              
                if(  in_array($field_name_upper,$cabecalho_array)  ) {
                    $text_align="center"; $font_size="font-size: small;";
                }
                if( $field_name_upper=='NUMPROJETO' or $field_name_upper=='NR' ) {
                    $text_align="right"; $padding_right="padding-right: .5em;"; 
                    $font_size='font-size: small; font-weight: bold;';
                } 
                echo "<td id=\"tr_itemOn\" class=\"itemOn\" onmouseover=\"javascript: mouse_over_menu(this);\"  onmouseout=\"javascript: mouse_out_menu(this);\"  
                      style=\"$padding_right $font_size text-align: $text_align; white-space:nowrap;\" >";
                if(  in_array($field_name_upper,$ar_cps_final_tab) ) {
                    ///
                    ///  Opcoes para Alterar e Excluir Anotacao
                    $valor=$_SESSION["cip"]."#".htmlentities(trim(mysql_result($query,$conta_linha,"nr")));   
                    ///
                    ///  Codigo de Identificacao da Anotacao
                    ///  $_SESSION["cia"] = (int) mysql_result($query,$conta_linha,"cia");
                    /*    $cmdhtml2 = "<a href='#' onclick='javascript: consulta_mostraanot(\"$field_name_upper\",\"$valor\",\"$usuario_conectado#anotacao\");return true;' id='$field_name_upper'  class='linkum'  "
                        ."  title='$field_name_upper'  style=' text-align: center; vertical-align:top; line-height:normal;' >";  
                  */      
                    $img="../imagens/".substr(strtolower($field_name_upper),0,1).".ico";
                  /***                     
                    $cmdhtml2 ="<img title='".ucfirst(strtolower($field_name_upper))."' alt='".ucfirst(strtolower($field_name_upper))."'  src=\"$img\" onclick='javascript: consulta_mostraanot(\"$field_name_upper\",\"$valor\",\"$usuario_conectado\"); return true;' style='cursor: pointer;' >";
                    ***/
                    $cmdhtml2 ="<img title='".ucfirst(strtolower($field_name_upper))."' alt='".ucfirst(strtolower($field_name_upper))."'  src=\"$img\" onclick='javascript: consulta_mostraanot(\"$field_name_upper\",\"$valor\",\"$anotacao_cip_altexc\"); return true;' style='cursor: pointer;' >";
                    ///                    
                    ///  $cmdhtml2 .="</a>";
                    echo  $cmdhtml2;
                } else {
                    echo "{$valor}";  
                } 
                echo "</td>";                
            }   
        }  
        //// Final do For
        ?>

        </tr>
       <?php
       $conta_linha++;
    }  
    ////  Final -  while( $linha = mysql_fetch_row($query)) 
    echo "</TABLE>";    
    echo  "</div>";       
    ///  PARTE DA  VERSAO ANTERIOR - encontra no arquivo reservado.php
    $cip = $_SESSION["cip"];
    $_SESSION["anotacao_nova"]=$cip;
    /// 
    ///  <!--  FINAL da Tabela de dados  -->
    exit();
}
?>