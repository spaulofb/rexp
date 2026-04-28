<?php
//
//  Verificando se session_start - ativado ou desativado
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
// Final - Mensagens para enviar
//
/**  CONEXAO/MYSQLI  */
$conex = $_SESSION["conex"];
//
/**
 *    2. Force o MySQLi a falar UTF-8
*             Muitas vezes o erro nasce na conexão. Logo após o seu mysqli_connect, adicione esta linha. 
*             Ela força o banco a entregar os dados já no formato correto para a página:
 */
mysqli_set_charset($conex, "utf8");
//
/**   Verificando essa SESSAO importante - URL principal
 *   Caso NAO exista criar - alterado em 20180614
 */
if( ! isset($_SESSION["url_central"]) ) {
    echo  "ERRO: falha grave SESSION url_central inexistente.";
    exit();
}
$url_central = $_SESSION["url_central"];
//
//  Conexao com o banco:
$campos_query = "*";
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
//  Verifica se pagina menor que 1
if( intval($pagina)<1 ) {
    $pagina="1";
}
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
     // if ( $_SESSION["num_rows"]>=1 ) {
     if( intval($_SESSION["num_rows"])>=1 ) {
          unset($_SESSION["num_rows"]);
          /// Conta os resultados no total da minha query
          ///  $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
          ///  $query    = mysqli_query($strCount);
          //  $_SESSION["row"]  = mysqli_fetch_array($resultado_outro);
          $_SESSION["row"] = mysqli_fetch_array($resultado_outro);
          //  $_SESSION["total_regs"] = mysqli_num_rows($resultado_outro);
          $_SESSION["total_regs"] = mysqli_num_rows($resultado_outro);
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
          /**   Final - for( $z=1; $z<99999 ; $z++ ) {  */
          //
    }
    //
}
/**  Final - if( isset($_SESSION["num_rows"]) ) {  */   
// 
//  \$row = array  e  \$total_regs = total_regs de registros encontrados
$row=$_SESSION["row"]; $total_regs = $_SESSION["total_regs"];
if( isset($_SESSION["usuario_conectado"]) ) {
     $usuario_conectado=$_SESSION["usuario_conectado"];
} 
//
// Verifica se variavel total_regs menou ou igual a 0 (ZERO)
if( intval($total_regs)<=0 ) {
    echo "<p  class='titulo_usp'  >Nenhum registro encontrado.</p>";
} else {
     /***
           Verificando SESSION  table_temporaria  -  20180810
    ***/   
    if( ! isset($_SESSION["table_consultar_anotacao"]) ) {
         $merr="Falha SESSION table_consultar_anotacao não definida.";
         echo $funcoes->mostra_msg_erro("$merr");
         exit();
    }
    $table_temporaria = $_SESSION["table_consultar_anotacao"];
    //
    // Definindo as variaveis
    $num_fields=0; $m_ordenar="nome"; $max_length="";
     /// 
    $strQuery="SELECT $campos_query from  $table_temporaria  LIMIT $inicio,$maximo";  
    $query      = mysqli_query($_SESSION["conex"],$strQuery);
    if( ! $query ) {
         ////  die('ERRO: Sem resultado - Select - falha: '.mysqli_error());   
         $msg_erro .= "&nbsp;Select - falha:&nbsp;db/mysql:&nbsp;";
         $msg_erro .= mysqli_error($_SESSION["conex"]).$msg_final;
         echo $msg_erro;  
         exit();          
    }
    //  Nr. de registros
    $num_rows = mysqli_num_rows($query);
    //
    //   Pegando os nomes dos campos  do primeiro Select
    $num_fields=mysqli_num_fields($query);  //  Obtem o numero de campos do resultado
    $td_menu = $num_fields+1;      
     //
     $max_length = "";
     $fields = array(); // Inicializa o array para NAO dar erro
     for( $i = 0; $i < $num_fields; $i++) {
          //
          // Pega as informações do campo atual (corrigido para MySQLi)
          $finfo = mysqli_fetch_field_direct($query, $i);
          $nome_do_campo = $finfo->name;
          $fields[] = $nome_do_campo;
          //
          // Monta a string SQL para pegar o tamanho máximo do conteúdo
          // Usamos alias (campo0, campo1...) para facilitar a leitura depois
          $max_length .= " MAX(LENGTH(TRIM(`$nome_do_campo`))) as campo$i ";
          //
          // Adiciona vírgula se não for o último campo
          if( $i < ($num_fields - 1)) {
              $max_length .= ", ";
          }
          // 
          // Verifica se o campo é o 'codautor'
          if ($nome_do_campo == "codautor") {
              $ncodautor = $nome_do_campo;
          }
          //
    }
    /**  Final - for( $i = 0; $i < $num_fields; $i++) {  */
    //
     /**   Selecionando o maximo espaco ocupado em cada campo da tabela   */
     $temp_tabela=$_SESSION["table_consultar_anotacao"];
     ////  $sqlcmd="SELECT ".$max_length." FROM    ".$_SESSION["table_consultar_anotacao"]."   ";
     $sqlcmd="SELECT ".$max_length." FROM  $temp_tabela  ";     
     $result_max_length = mysqli_query($_SESSION["conex"],$sqlcmd);          
     if( ! $result_max_length ) {
          //
          //  die('ERRO: Select maximo tamanho dos campos da tb  $temp_tabela - falha: '.mysqli_error());                  
          $msg_erro .= "&nbsp;Select maximo tamanho dos campos da tabela  $temp_tabela - falha:&nbsp;db/mysqli&nbsp;";
          $msg_erro .= mysqli_error($_SESSION["conex"]);
          echo $msg_erro.$msg_final;  
          exit();          
          //
     }      
     
     /** 
     $num_rows = mysqli_num_rows($query);
     $num_rows = (int) strlen(trim($num_rows)); 
    */


     $campo_n=2;
     /**   Como repetir uma string ou caractere 
            um n?mero determinado de vezes      
  
     $n_simbolo = "&nbsp;"; 
     $n_simbolo = str_repeat($n_simbolo,$num_rows);
     if( intval($num_rows)<=1 ) $n_simbolo = "";
  
  
    */
     ///  FINAL do tamanho do campo
    
     /// Iniciando TABELA de dados
     /// opcionalmente, imprimir um cabe?alho em negrito na parte superior da tabela
    /***
    $font_size_family="font-size: x-small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace; ";
    $font_size_family.=" padding: 3px; empty-cells: show; border-collapse: collapse "; 
     ***/

    //
    //  Atualizado 20260414
    //  $m_function="enviando_dados";    
    // $m_function=$_SESSION["m_function"];  DESATIVADO 20260414
    //
    //  $campos_fora = array("ARQUIVO","DATA","PROJETO_TITULO","AUTOR","PROJETO_AUTOR");    
    $campos_fora = array("ARQUIVO","PROJETO_TITULO","AUTOR","PROJETO_AUTOR","ALTERA","ALTERADA");    
    $cabecalho_array = array("DATA","DETALHES");
    $align_right_array=array("CIA","NR","NUMPROJETO","NA");


    /**  
echo "ERRO: LINHA/163 -->> tabela_consulta_anotacao.php  -->>  \$opcao_maiusc = $opcao_maiusc  <<-->>  "
        ." \$total_regs = $total_regs  -- \$alterar = $alterar -- \$projeto_autor = $projeto_autor  <br>  -->>"
       ." \$_SESSION[protocolo] = {$_SESSION["protocolo"]} E  \$_SESSION[url_central] = {$_SESSION["url_central"]}   "
       ."<br>  -->> \$num_rows = $num_rows  <<-->>  \$total_regs = $total_regs  <<-- \$td_menu =<b> $td_menu </b> "
        ."<br>  -->> \$m_function = $m_function  <<-- \$campos_fora = ".gettype($campos_fora)
    ." <<--  <strong> {$url_central} E {$_SESSION["titulo"]} </strong>  -->> \$cabecalho_array = ".gettype($cabecalho_array)." -->>  \$align_right_array=<b>".gettype($align_right_array)."</b> ";
exit();
 */




    ////    
/***    echo '<div class="tb_consulta" >';
    echo "<table>";
    echo "<caption>{$_SESSION["titulo"]}</caption>";
***/    
    ///
    echo "<div id='div_pagina' class='div_pagina' style='margin-left: 1px; width: 99%; height: 100%;' >";
    //
    echo $_SESSION["titulo"];
    //
    // 1. Defina as traduções dos nomes das colunas aqui (Mais fácil de manter)
    $nomes_amigaveis = [
        'TITULO'     => 'Título',
        'NUMPROJETO' => 'Nr/Projeto',
        'NR'         => 'Nr',
        'NA'         => 'NA'
    ];
    //
    echo "<table class='div_pagina' style='margin-left: 3px;' cellpadding='1' cellspacing='2'>";
    echo "<tr>";
    //
    for( $ncol = 0; $ncol < $num_fields; $ncol++ ) {
        //
        $field_name = $fields[$ncol];
        $field_name_upper = strtoupper(trim($field_name));
        //
        // Pula os campos ignorados
        if (in_array($field_name_upper, $campos_fora)) continue;
        //
        // 2. Define o alinhamento
        $text_align = "left";
        if( $field_name_upper == 'DETALHES' || in_array($field_name_upper, $cabecalho_array)) {
            $text_align = "center";
        }
        //
        // 3. Busca o nome amigável ou usa o original formatado
        $label = isset($nomes_amigaveis[$field_name_upper]) 
                ? $nomes_amigaveis[$field_name_upper] 
                : ucfirst($field_name);
        //
        // Se realmente precisar tratar encoding, faça aqui:
        // $label = mb_convert_encoding($label, "UTF-8"); 
        //
        // 4. Imprime o TH (Unificado)
        echo "<th class='font_size_family' style='text-align: $text_align; background-color: #00FF00; border: 1px solid #000000;'>";
        echo htmlspecialchars($label);
        echo "</th>";
        //
    }
    /**   Final - for( $ncol = 0; $ncol < $num_fields; $ncol++ ) {   */
    echo "</tr>";
    //
    // print the body of the table
    //  $conjunto = $_SESSION["conjunto"];
     // $conta_linha=0; $sem_link=0;
    //
    while( $linha = mysqli_fetch_assoc($query) ) { // fetch_assoc é mais fácil que row
        //   
        echo "<tr align='left' class='font_size'>";
        //
        for( $ncol = 0; $ncol < $num_fields; $ncol++ ) {
            //
            $field_name = $fields[$ncol];
            $field_name_upper = strtoupper(trim($field_name));
            $valor_original = $linha[$field_name]; // Pega o valor pela chave (nome da coluna)
            // 
            if (in_array($field_name_upper, $campos_fora)) continue; 
            //
            // 1. Definição de Alinhamento
            $text_align = "left";
            if( $field_name_upper == 'DATA' || $field_name_upper == 'DETALHES') $text_align = "center";
            if( in_array($field_name_upper, $align_right_array)) $text_align = "right";
            //

            // 2. Lógica para TÍTULO
            if( preg_match("/ITULO|TÍTULO/i", $field_name_upper)) {
                $detalhes_val = trim($linha['Detalhes'] ?? '');
                $arquivo_val = trim($linha['Arquivo'] ?? '');
                
                // Tratamento de caracteres (Simplificado)
                $titulo_exibir = (mb_detect_encoding($valor_original) != "UTF-8") 
                                ? htmlentities($valor_original) 
                                : $valor_original;

                $conteudo = "<a href='#' onclick='consulta_mostraanot(\"DESCARREGAR\",\"$arquivo_val\",\"$usuario_conectado#anotacao#$detalhes_val\"); return true;' class='linkum' title='Clicar'>
                                <span style='font-size:larger;'>$titulo_exibir</span>
                            </a>";
                $classe_td = "class='itemOn'";
                //
            } 
            
            // 3. Lógica para DETALHES
            else if( $field_name_upper == 'DETALHES' ) {
                $detalhes_val = trim($linha['Detalhes'] ?? '');
                $conteudo = "<a href='#' onclick='consulta_mostraanot(\"DETALHES\",\"$valor_original\",\"$usuario_conectado#anotacao#$detalhes_val\"); return true;' class='linkum'>
                                <img src='../imagens/enviar.gif' alt='Detalhes'>
                            </a>";
                $classe_td = "class='itemOn'";
            } 
            
            // 4. Outros campos
            else {
                $conteudo = $valor_original;
                $classe_td = "";
            }
            //
            // Impressão Única da Célula
            echo "<td $classe_td 
                    onmouseover='mouse_over_menu(this);' 
                    onmouseout='mouse_out_menu(this);' 
                    style='text-align: $text_align; white-space: nowrap; padding: .3em; font-weight: bold; border: 1px solid #000000;'>";
            //
            echo $conteudo;
            echo "</td>";
            //
        }
        /**   Final - for( $ncol = 0; $ncol < $num_fields; $ncol++ ) {  */
        //
        echo "</tr>";
        //
        //  $conta_linha++;
        //
    }  
    /**   Final - while( $linha = mysqli_fetch_assoc($query) ) {   */
    //

/**  
echo "ERRO: LINHA/341 -->> tabela_consulta_anotacao.php  -->>  \$opcao_maiusc = $opcao_maiusc  <<-->>  "
        ." \$total_regs = $total_regs  -- \$alterar = $alterar -- \$projeto_autor = $projeto_autor  <br>  -->>"
       ." \$_SESSION[protocolo] = {$_SESSION["protocolo"]} E  \$_SESSION[url_central] = {$_SESSION["url_central"]}   "
       ."<br>  -->> \$num_rows = $num_rows  <<-->>  \$total_regs = $total_regs  <<-- \$td_menu =<b> $td_menu </b> "
        ."<br>  -->> \$m_function = $m_function  <<-- \$campos_fora = ".gettype($campos_fora)
    ." <<--  <strong> {$url_central} E {$_SESSION["titulo"]} </strong>  -->> \$cabecalho_array = ".gettype($cabecalho_array)." -->>  \$align_right_array=<b>".gettype($align_right_array)."</b> ";
exit();
 */




    // Calculando pagina anterior
    $menos = $pagina - 1;

    /// Calculando pagina posterior
    $mais = $pagina + 1;

    $pgs = ceil($total_regs/$maximo);
    /// $pgs = 10;
    if( intval($pgs)>10 ) $pgs=10;
    //
    //  Total de paginas
    $_SESSION["numero_de_pags"] = (int) ($total_regs/$maximo);
    $_SESSION["valor_com_pags"] = (int) ($_SESSION["numero_de_pags"]*$maximo);
    if( $_SESSION["valor_com_pags"]<$total_regs ) $_SESSION["numero_de_pags"]++;
    //







    //  Maior que 1
    if( intval($pgs)>1 ) {
        //
        $td_menu=$td_menu*2;
        $pagina_atual = "{$url_central}consultar/tabela_selecionada.php";
        $font_size_family="font-size: small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace;"; 
        echo "<tr style='width: 100%; text-align: center;  margin-bottom: 0px;  padding-bottom: 0px; '  >";
        echo   "<td class='table_td' colspan=".$td_menu." style='text-align: center; '  align='center' >";
        echo  '<table border="0"  cellpadding="1"  cellspacing="0"  align="center" style="margin-top: 0px; padding-top: 0px; " >';    
        echo "<tr  style='padding: 0px;' >";
        echo  "<td style='".$font_size_family."' >";
        /// Mostragem de pagina
        ///  Pagina inicial
         if( intval($total_regs)>0 && intval($menos)>0 ) {
                $iniciando="0";
                echo "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$iniciando\");'  "
                ." class='texto_paginacao' style='cursor: pointer;' alt='Clicar'  >in&iacute;cio</a>&nbsp;";
         }  
         ///  Pagina anterior
        if( intval($menos)>0 ) {    
           // echo "<a href=\"?pagina=$menos&seed=$seed\" class='texto_paginacao'>anterior</a> ";
           // echo "<a href=\"$pagina_atual?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
           // echo "<a href=\"?pagina=$menos\" class='texto_paginacao'>anterior</a>&nbsp;";
           echo  "<a href='javascript: $m_function(\"Lista\",\"$menos\");' "
                  ." class='texto_paginacao'  title='Clicar' >anterior</a>&nbsp;";
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
        for($i=1;$i <= $n_pags; $i++) {
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
        /// Proxima pagina
        ///  if($mais <= $pgs) {
        if( $mais<=$_SESSION["numero_de_pags"] || ($inicio+$maximo)<$total_regs ) {
            echo  "<a href='javascript: $m_function(\"Lista\",\"$mais\");'   "
                  ." class='texto_paginacao'  title='Clicar'  >pr&oacute;xima</a>&nbsp;";
        }
        ///  Ultima pagina
        $ultima_pagina = (int) $_SESSION["pagina_final"];
        if( $ultima_pagina!=$pagina && ($inicio+$maximo)<$total_regs ) {
             echo  "&nbsp;<a href='javascript: $m_function(\"Lista\",\"$ultima_pagina\");'   "
                   ." class='texto_paginacao'   title='Clicar'  >final</a>";
        }
        echo "</td></tr></table>";
        echo "</td></tr>";
    }  
    /// Final - if \$pgs
    echo "</table>"; 
    echo "</div>";
    ///
    /// '<!--  FINAL da Tabela de dados  -->';
    ///
    exit();
}
?>