<?php
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
//// Final - Mensagens para enviar

/*
    Exibindo a Tabela de Consulta do Projeto
*/
$campos_query = "*";
//
//
/**
 *  Conexao Mysqli
 */ 
$conex = $_SESSION["conex"];
//
// Declaracao da pagina inicial
$pagina = $_SESSION["pagina"];
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo "ERRO: Sessão incluir_arq não está ativa.";
    exit();
}
//
if( intval($pagina)<1 ) {
    $pagina=1;
}
//
//  Maximo de registros por pagina
//  $maximo = 16;
$maximo=10;
//
//  Calculando o registro inicial
$inicio = $pagina - 1;
$inicio = $maximo * $inicio;
//
//  Variaveis recebidos e criando absoletos
if( isset($_SESSION["num_rows"]) ) {  
     //
     if( intval($_SESSION["num_rows"])>=1 ) {
        //
        unset($_SESSION["num_rows"]);
        //
	    // Conta os resultados no total da minha query
	    //  $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
	    //  $query    = mysqli_query($conex,$strCount);
	    $_SESSION["row"]  = mysqli_fetch_array($resultado_outro);
	    $_SESSION["total_regs"] = mysqli_num_rows($resultado_outro);
	    $_SESSION["passou"]=1; 
        $total_regs = $_SESSION["total_regs"];
        //
        for( $z=1; $z<99999 ; $z++ ) {
               $valor_final[$z] = $z*$maximo;
               if( $valor_final[$z]>$total_regs ) {
                        $_SESSION["pagina_final"] = $maximo-($valor_final[$z]-$total_regs);
			            $_SESSION["pagina_final"] = $total_regs-$_SESSION["pagina_final"];
 			            $_SESSION["pagina_final"] = (int) ($_SESSION["pagina_final"]/$maximo)+1;
                         break;
               }
        }
        /**  Final - for( $z=1; $z<99999 ; $z++ ) { */
        //
    }  
    /**  Final - if( intval($_SESSION["num_rows"])>=1 ) {  */
    //
}    
/**  Final - if( isset($_SESSION["num_rows"]) ) {  */
//
/**
 *   \$row = array  e  \$total_regs = total_regs de registros encontrados
 */
$row=$_SESSION["row"]; 
$total_regs = $_SESSION["total_regs"];
if( isset($_SESSION["usuario_conectado"]) ) {
     $usuario_conectado=$_SESSION["usuario_conectado"];
} 
//
// Verificando o total de registros
if( intval($total_regs)<=0 ) {
    echo "<p  class='titulo_usp'  >Nenhum registro encontrado.</p>";
} else {
    // 
    //  Conexao com a Tabeala Temporaria para consulta
    /**
    *       Verificando SESSION  table_temporaria  -  20180810
    *   if( ! isset($_SESSION['table_consultar_projeto']) ) {
    */   
    if( ! isset($_SESSION['tb_cons_proj']) ) {    
        $terr="Falha SESSION tb_cons_proj não definida.";
        echo $funcoes->mostra_msg_erro(utf8_decode("$terr"));
        exit();
    }
    $table_temporaria = $_SESSION['tb_cons_proj'];  
    //
    // Definindo as variaveis
    $num_fields=0; $m_ordenar="nome"; 
    $max_length="";
    // 
    /**   IMPORTANTE: essa parte abaixo para acentuacao  PHP/MySQL - 20250623  */
    ini_set('default_charset','utf8');
    mysqli_set_charset($_SESSION["conex"],'utf8');
    //
    /**
     *   Select/MYSQLI - Selecionando os campos da tabela temporaria
     *    Utilizando no Select/MYSQLI  utf8
     */
    $strQuery="SELECT $campos_query FROM  $table_temporaria  LIMIT $inicio,$maximo";  
	$query = mysqli_query($conex,$strQuery);
    if( ! $query ) {
        //
        //   die('ERRO: Sem resultado - Select - falha: '.mysqli_error($onex));   
        $msg_erro .= "&nbsp;Select - falha:&nbsp;db/mysqli:&nbsp;";
        $msg_erro .= mysqli_error($onex).$msg_final;
        echo $msg_erro;  
        exit();          
        //
    }
    ///  Nr. de registros
    $num_rows = mysqli_num_rows($query);
    //
    // Pegando os NOMES dos campos do primeiro Select
    $num_fields=mysqli_num_fields($query);  //  Obtem o numero de campos do resultado
    $td_menu = $num_fields+1;                
    //
    //  Parte tentando pegar o tamanho maior da coluna (campo)
    $max_length="";
    for( $i = 0;$i<$num_fields; $i++) {  //  Pega o nome dos campos
         //
         $fields[] = mysqli_field_name($query,$i);
         //  Pegando o maximo do espaco ocupado de cada campo 
         //  vindo do primeiro Select - $query
         $max_length.= " MAX(LENGTH(TRIM($fields[$i]))) as campo$i ";
         if( $i<($num_fields-1) ) $max_length.= ", "; 
         if( $fields[$i]=="codautor" ) $ncodautor=$fields[$i];
         //
    }
    /**  Final - for( $i = 0;$i<$num_fields; $i++) {  */
    //
    /**   Selecionando o maximo espaco ocupado em cada campo da tabela  */
    $temp_tabela=$_SESSION['tb_cons_proj'];
    //
    /**  $sqlcmd="SELECT ".$max_length." FROM  ".$_SESSION['tb_cons_proj']."   ";  */
    $sqlcmd="SELECT ".$max_length." FROM  $temp_tabela  ";
    $result_max_length = mysqli_query($conex,$sqlcmd);          
    //
    if( ! $result_max_length ) {
        //
        //  die('ERRO: Select maximo tamanho dos campos da tb  tb_cons_proj - falha: '.mysqli_error($onex));
        $terr="&nbsp;Select maximo tamanho dos campos da tabela  $temp_tabela - falha:&nbsp;db/mysqli&nbsp;";
        $msg_erro .= "$terr";
        echo $msg_erro.$msg_final;  
        exit();          
    }
    //    
    $num_rows = (int) strlen(trim($num_rows)); 
    $campo_n=2;
    //

/**  
echo "ERRO: tabela_consulta_projeto/162  -->> \$num_fields = $num_fields <<--  \$num_rows =<b> $num_rows </b>  <br>"
        ."   -->> \$tb_cons_proj = $tb_cons_proj <<-->>  \$bd_1 = $bd_1  <<-- <br>"
        ."  -->>   \$bd_2 = $bd_2  <br />  \$strQuery = $strQuery  ";
exit();
 */




    /**    Como repetir uma string ou caractere 
    *       um numero determinado de vezes      
    */
    $n_simbolo = "&nbsp;"; 
    $n_simbolo = str_repeat($n_simbolo,$num_rows);
    //
    if( intval($num_rows)<=1 ) $n_simbolo = "";
    //  FINAL do tamanho do campo
    //
    /**  
    *       Iniciando TABELA de dados
    *   opcionalmente, imprimir um cabe?alho em negrito na parte superior da tabela
    *    $font_size_family="font-size: x-small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace; ";
    *    $font_size_family.=" padding: 3px; empty-cells: show; border-collapse: collapse "; 
    *     $m_function="enviando_dados";    
    */
    $m_function=$_SESSION["m_function"];
    //
    // $campos_fora = array("ARQUIVO","DATA","AUTOR");
    //  $campos_fora = array("ARQUIVO","AUTOR","CODAUTOR","NR","CIP");
    $campos_fora = array("ARQUIVO","AUTOR","CODAUTOR","CIP");
    $cabecalho_array = array("DATA","DETALHES");
    $align_right_array=array("CIP","NP","NR","NUMPROJETO");
    $lncodautor="";
    //
    //  echo "<div id='div_pagina' style='text-align:center;backgroun-color:#000;' >";
    //  echo $_SESSION["titulo"];
    //  echo "<table style='width: auto; border: 0px solid #000000;text-align:center;'  >";
    echo "<div id='div_pagina' class='div_pagina' style='margin-left: 1px; width: 99%; height: 100%;' >";
    echo $_SESSION["titulo"];
    echo "<table  class='div_pagina'  style='margin-left: 3px;' cellpadding='1' cellspacing='2' >";
    echo "<tr>";
    for( $ncols = 0; $ncols < $num_fields; $ncols++ ) {  
          //
          $field_name = $fields[$ncols]; $text_align="left";
          $field_name_upper=strtoupper(trim($field_name));  
          /**
           *   if( $field_name_upper=='ARQUIVO' or $field_name_upper=='DATA' or $field_name_upper=='DETALHES' ) $text_align="center";
          */
          if( in_array($field_name_upper,$campos_fora) ) continue;
          if( $field_name_upper=='NR' ) $field_name="Nr";
          if( $field_name_upper=='CIP' ) $field_name="CIP";
          //
          // if( $field_name_upper=='NP' ) $field_name="CIP";
          if( $field_name_upper=='NP' ) $field_name="NP";
          if(  in_array($field_name_upper,$cabecalho_array) ) $text_align="center";
          //  if( $field_name_upper=='DETALHES' ) $text_align="center";         
          if( preg_match("/^Nr{1}$|^N$|^Np{1}$|^NUM$|^CIP$/i",$field_name) ) {
               echo "<th  class='font_size_family' style='text-align: $text_align; background-color: #00FF00; border: 1px solid #000000;' >"
                     ."$field_name</th>";          
          } else {
              //
              //  Autor do Projeto pelo Codigo/USP
              $field_name=preg_replace("/codautor/i","Autor",$field_name);
              $procedimento=" text-align: $text_align; background-color: #00FF00; border: 1px solid #000000;";
              if( preg_match("/^Titulo|Título/i",$field_name) ) {
                   //
                   // $field_name="Título/Projeto";
                   $field_name="Título";
                   $text_align="left";
                   $procedimento=" text-align: $text_align; background-color: #00FF00; border: 1px solid #000000;";                        
                   //
              } 
              //   
              echo "<th class='font_size_family' style=\"$procedimento\" >";                 
              //  echo   utf8_decode(ucfirst($field_name))."</th>";        
                echo  ucfirst($field_name)."</th>";        
              //     
          }
          //
    }
    echo "</tr>";  
    //
    // print the body of the table
    $conjunto = $_SESSION["conjunto"];
    $conta_linha=0; $sem_link=0;
    //  while( $linha = mysqli_fetch_row($query)) {
    while( $linha = $query->fetch_array(MYSQLI_NUM) ) {
          // link        
         ?>       
        <tr align="left" class="font_size" >
      <?php
        //
        $n_index=0;
        //
        if( isset($ncols) ) unset($ncols);
        //
        // Coluna por Coluna da Tabela
        for( $ncols=0; $ncols<$num_fields; $ncols++) {
            //
            $text_align="left";  
            $field_name_upper = strtoupper(trim($fields[$ncols]));             
            //
            if( in_array($field_name_upper,$campos_fora) ) continue;
            if( $field_name_upper=='NR' ) $field_name="Nr";
            if( $field_name_upper=='CIP' ) $field_name="CIP";
            //
            //  if( strtoupper($field_name)=='relatproj' ) {
            if( intval($ncols)<1 ) $selecionado=$linha[$ncols];
            //
            //   if( strtoupper($field_name)=='ARQUIVADO_COMO' ) {
            if( $ncodautor=="codautor" ) {
                /**
                 *   Dados do campo codautor
                 */
                 $lncodautor=mysqli_result($query,$conta_linha,"codautor");
            } 
            //
            //  if( $field_name_upper=='TITULO' or $field_name_upper=='AUTOR' ) {
            //  if( $field_name_upper=='TITULO' or $field_name_upper=='DATA' ) {
            //  if( $field_name_upper=='TITULO'  ) {
            if( preg_match("/ITULO|TÍTULO/ui",$field_name_upper) ) {
                /** 
                 *    $valor=htmlentities(trim(mysqli_result($query,$conta_linha,"relatproj")));
                 *   $valor=htmlentities(trim(mysqli_result($query,$conta_linha,"Arquivo")));
                 */
                $valor=trim(mysqli_result($query,$conta_linha,"Arquivo"));
                $m_relatproj=$linha[$ncols]; 
                $sem_link=1;
                $titulo=$linha[$ncols];
                //
                //  Titulo do Projeto
                ?>                        
                <td id="tr_itemOn" class="itemOn" onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  style="text-align: left; white-space: nowrap; padding: .3em; font-weight: bold; border: 1px solid #000000;" >
                <?php
                   //
                   $pt2="$usuario_conectado#projeto#$lncodautor";
                   $cmdhtml = "<a href='#' onclick='javascript: consulta_mostraproj(\"DESCARREGAR\",\"$valor\",\"$pt2\");return true;'  "
                        ."  id='relatproj'  class='linkum'  title='Clicar'  "
                        ."  style='text-align: center; vertical-align:top; line-height:normal;' >";  
                   $cmdhtml .="<span>";
                   //
                   /**  IMPORTANTE: Detectar codificacao  de caracteres  - 20250623  */
                   $codigo_caracter=mb_detect_encoding($titulo);
                   $encoding = mb_detect_encoding($titulo, 'UTF-8, ISO-8859-1', true);
                   //      
                   //   if( trim(strtoupper($codigo_caracter))!="UTF8" ) {  
                   /** 
                   if( $encoding !== 'UTF-8' ) {  
                       $cmdhtml .=htmlentities($titulo)."</span>";
                   } else {
                       $cmdhtml .="$titulo</span>";
                   }
                   */
                   $cmdhtml .="$titulo</span>"; 
                   //           
                   $cmdhtml .="</a>";
                   echo $cmdhtml;
                   //
                ?>  
                </td>
              <?php   
                // 
            } else if( $field_name_upper=='DETALHES'  ) {
                   //
                   // $array_valor[$n_index]=$linha[$ncols];
                   // Clicar para mostrar detalhes
                   $n_index=$n_index+1;
                   $array_valor[$n_index]=$valor=trim(mysqli_result($query,$conta_linha,"Detalhes"));
                   $text_align="center";
                   $imagem="<img src='../imagens/enviar.gif' alt='Mostrar detalhes dessa Anotação'  style='text-align: center; vertical-align:text-bottom;'  >";  
                   //
                ?>                        
                <td id="tr_itemOn" class="itemOn" onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  style="text-align: <?php echo $text_align;?>; white-space: nowrap; padding: .3em; font-weight: bold; border: 1px solid #000000;" >
                <img src="../imagens/enviar.gif" alt="Mostrar detalhes dessa Anotação"  style="text-align: center; vertical-align:text-bottom; cursor:pointer; "  onclick="javascript: consulta_mostraproj('DETALHES','<?php echo $array_valor[$n_index];?>','<?php echo "$usuario_conectado#projeto#$lncodautor";?>');return true;"  >
                 </td>                     
                <?php    
                  //            
                  $cmdhtml2 = "<a href='#' onclick='javascript: consulta_mostraproj(\"DETALHES\",\"$valor\",\"$usuario_conectado#projeto#$lncodautor\");return true;'  "
                        ."  id='detalhes'  class='linkum'  title='Clicar' "
                        ."  style=' text-align: center; vertical-align:top; line-height:normal;' >";  
                  $cmdhtml2 .=$imagem." - $valor</a>";
                  //// echo $cmdhtml2;                  
            } else {
                //
                //  Numero da sequencia dos registros
           ////     $text_align="right";
                $valor=$linha[$ncols];    
                /**
                *     if( $field_name_upper=='NUMPROJETO' )  $text_align="right";
                *     if( $field_name_upper=='NR' )  $text_align="right";
                */
                // Encontrar campo nesse array
                if( in_array("$field_name_upper",$align_right_array) )  $text_align="right";
                /// 
                ?>           
                <td style="text-align: <?php echo $text_align;?>; white-space: nowrap; padding: .3em; font-weight: bold; border: 1px solid #000000;" >                
                <?php  echo "$valor";?>
                </td>
                <?php                
            }   
            //
        }  
        /**  Final - for( $ncols=0; $ncols<$num_fields; $ncols++) { */  
        //
       ?>
        </tr>
       <?php
       $conta_linha++;
       //
    }  
    /**  Final - while( $linha = mysqli_fetch_row($query)) {  */
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
    //
    //  Total de paginas
    $_SESSION["numero_de_pags"] = (int) ($total_regs/$maximo);
    $_SESSION["valor_com_pags"] = (int) ($_SESSION["numero_de_pags"]*$maximo);
    if( $_SESSION["valor_com_pags"]<$total_regs ) {
            $_SESSION["numero_de_pags"]++; 
    } 
    //
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
        //
        echo "<tr style='width: 100%;text-align: center; margin-bottom: 0px; padding-bottom: 0px;' >";
        echo "<td class='table_td' colspan=".$td_menu." style='text-align: center;' align='center' >";
        echo  '<table border="0"  cellpadding="1"  cellspacing="0"  align="center" style="margin-top: 0px; padding-top: 0px; " >';    
        echo "<tr  style='padding: 0px;' >";
        echo  "<td style='".$font_size_family."' >";
        //
        // Mostragem de pagina
        ///  Pagina inicial
         if( intval($total_regs)>0 &&  intval($menos)>0 ) {
                $iniciando="0";
                echo "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$iniciando\");'  "
                ." class='texto_paginacao' style='cursor: pointer;' alt='Clicar'  >in&iacute;cio</a>&nbsp;";
         }  
         //
         //  Pagina anterior
        if( intval($menos)>0 ) {
             //
             // echo "<a href=\"?pagina=$menos&seed=$seed\" class='texto_paginacao'>anterior</a> ";
             // echo "<a href=\"$pagina_atual?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
             // echo "<a href=\"?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
             echo  "<a href='javascript: $m_function(\"Lista\",\"$menos\");' "
                     ." class='texto_paginacao'  title='Clicar' >anterior</a>&nbsp;";  
             //
        }
        /**  Final - if( intval($menos)>0 ) { */
        //
        //  Listando as paginas
        $n_pags=8;
        if( $_SESSION["valor_com_pags"]==$pagina ) {
            $pag_id=$pagina-$n_pags;
            if( intval($pag_id)<1 ) $pag_id=1;
        } else {
            $pag_id=$pagina;   
        }
        //
        for( $i=1; $i<=$n_pags; $i++) {
             $pag_id++;
             //
             if( $pag_id<=$npgs ) {
                 if( $pag_id != $pagina) {
                     echo  "<a href='javascript: $m_function(\"Lista\",\"$pag_id\");' "
                               ." class='texto_paginacao'  title='Clicar' >"
                               ."$pag_id</a>&nbsp;";
                 } else {
                      echo "&nbsp;<span class='texto_paginacao_pgatual'>".$pag_id."</span>&nbsp;";   
                 }
                 //
             }     
             //
        }  
        /**  Final - for( $i=1; $i<=$n_pags; $i++) { */
        //
        /// Proxima pagina
        //  if($mais <= $pgs) {
        if( $mais<=$npgs || ( $inicio+$maximo)<$total_regs ) {
            echo  "<a href='javascript: $m_function(\"Lista\",\"$mais\");'   "
                  ." class='texto_paginacao'  title='Clicar'  >pr&oacute;xima</a>&nbsp;";
        }
        //
        //  Ultima pagina
        $ultima_pagina = (int) $_SESSION["pagina_final"];
        if( $ultima_pagina!=$pagina && ($inicio+$maximo)<$total_regs ) {
             //
             echo  "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$ultima_pagina\");'   "
                   ." class='texto_paginacao'   title='Clicar'  >final</a>";
        }
        //
        echo "</td></tr></table>";
        echo "</td></tr>";
    } 
    /**  Final - if( intval($pgs)>1 ) {  */
    //
    echo "</table>"; 
    echo "</div>";
    // 
    ///  <!--  FINAL da Tabela de dados  -->
}  
//
?>
