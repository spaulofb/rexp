<?php
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//  Conexão com o banco:
    
/*
mysql_connect("localhost","desenvolvimento","12345");
mysql_select_db("test");

// Informações da query. No caso, "SELECT * FROM produtos WHERE EXIBIR=1 ORDER BY RAND()"
$campos_query = "*";
$final_query  = "FROM produtos WHERE EXIBIR=1";
*/
$campos_query = "*";

// Declaração da pagina inicial
$pagina = $_SESSION["pagina"];

// if( $pagina=="") {
if( $pagina<1 ) {
    $pagina="1";
}
//  Maximo de registros por pagina
//  $maximo = 16;
$maximo=10;

// Calculando o registro inicial
$inicio = $pagina - 1;
$inicio = $maximo * $inicio;
//  Variaveis recebidos e criando absoletos
if ( $_SESSION["num_rows"]>=1 ) {
    unset($_SESSION["num_rows"]);
	// Conta os resultados no total da minha query
	//  $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
	//  $query    = mysql_query($strCount);
	$_SESSION["row"]  = mysql_fetch_array($result_outro);
	$_SESSION["total_regs"] = mysql_num_rows($result_outro);
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
//  \$row = array  e  \$total_regs = total_regs de registros encontrados
$row=$_SESSION["row"]; $total_regs = $_SESSION["total_regs"];

$usuario_conectado = $_SESSION["usuario_conectado"];

if( $total_regs<=0 ) {
    echo "<p  class='titulo_usp'  >Nenhum registro encontrado.</p>";
} else {
    // if( !isset($_GET["seed"]) ) {
       //   $seed = rand();   // Caso ainda nao exista uma semente, cria a semente via PHP.
    // } else {
        /* Caso ja exista uma semente, 
		   utiliza a que foi passada na url. (o addslashes é por questão de segurança) */
	   //  $seed = addslashes($_GET["seed"]);
    // }
    //  $strQuery   = "SELECT $campos_query $final_query ORDER BY RAND($seed) LIMIT $inicio,$maximo";  
	//  $strQuery   = "SELECT $campos_query from  $temp_usuario ORDER BY RAND($seed) LIMIT $inicio,$maximo";  
    //  Conexão com o banco:
    include('../inicia_conexao.php');

    $m_linhas=0; $num_fields=0; $m_ordenar="nome";    
    
	$strQuery="SELECT $campos_query from  ".$_SESSION['table_temp_usu']."  LIMIT $inicio,$maximo";  
	$query      = mysql_query($strQuery);
    if( ! $query ) {
       die('ERRO: Sem resultado - Select - falha: '.mysql_error());   
    }
    $m_linhas = mysql_num_rows($query);
    //   Pegando os nomes dos campos  do primeiro Select
    $num_fields=mysql_num_fields($query);  //  Obtem o número de campos do resultado
    $td_menu = $num_fields+1;                
    
    //  Parte tentando pegar o tamanho maior da coluna (campo)
    for( $i = 0;$i<$num_fields; $i++) { //  Pega o nome dos campos
         $fields[] = mysql_field_name($query,$i);
         //  Pegando o maximo do espaco ocupado de cada campo 
         //  vindo do primeiro Select - $query
         $max_length.= " MAX(LENGTH(TRIM($fields[$i]))) as campo$i ";
         if( $i<($num_fields-1) ) $max_length.= ", "; 
     }
     //   Selecionando o maximo espaco ocupado em cada campo da tabela
     $sqlcmd="SELECT ".$max_length." FROM    ".$_SESSION['table_temp_usu']."   ";
     $result_max_length = mysql_query($sqlcmd);          
     //
     if ( ! $result_max_length ) {
          mysql_free_result($result_max_length);
          die('ERRO: Select maximo tamanho dos campos da tb  $temp_tabela - falha: '.mysql_error());                  
     }    
     
     $num_rows = mysql_num_rows($query);
     $num_rows = (int) strlen(trim($num_rows)); 
     $campo_n=2;
     /*  Como repetir uma string ou caractere 
            um número determinado de vezes      */
     $n_simbolo = "&nbsp;";    $n_simbolo = str_repeat($n_simbolo,$num_rows);
     if( $num_rows<=1 ) $n_simbolo = "";
     //  FINAL do tamanho do campo
    
     // Iniciando TABELA de dados
      // opcionalmente, imprimir um cabeçalho em negrito na parte superior da tabela
    $font_size_family="font-size: x-small; font-family: Arial, Helvetica, Times, Courier, Georgia, monospace; ";
    $font_size_family.=" padding: 3px; empty-cells: show; "; 
    //  $m_function="enviando_dados";    
    $m_function=$_SESSION["m_function"];
    echo "<div id='div_pagina' style='margin-left: 1px; width: 99%; height: 100%;' >";
    echo $_SESSION["titulo"];
    echo "<TABLE style='margin-left: 3px; border: 0px solid #000000;' cellpadding='1' cellspacing='2' >";
    echo "<TR>";
    for($column_num = 0; $column_num < $num_fields; $column_num++) {
            $field_name = $fields[$column_num];
            echo "<TH ALIGN='LEFT' "
                ." style='background-color: #00FF00; border: 1px solid #000000; $font_size_family ' >"
                .ucfirst($field_name)."</TH>";
    }
    echo "</TR>";
    // print the body of the table
    $conta_linha=0; $sem_link=0;
    while( $linha = mysql_fetch_row($query)) {
        // link        
         ?>       
        <tr align="left"  id="tr_itemOn" class="itemOn"  VALIGN="TOP" style="cursor: pointer; " onmouseover="javascript: mouse_over_menu(this);"  onmouseout="javascript: mouse_out_menu(this);"  >
        <?php
        for( $column_num=0; $column_num<$num_fields; $column_num++) {
            $field_name = $fields[$column_num];
            if( strtoupper($field_name)=='RELATEXT' ) {
                $valor=htmlentities(trim(mysql_result($query,$conta_linha,"relatext")));                   
                $valor = substr($valor,strpos($valor,"_")+1,strlen(trim($valor)));      
                $m_relatext=$linha[$column_num]; $sem_link=1;
            } else {
                $valor=$linha[$column_num]; $sem_link=0;                                          
            }
            if( $sem_link==1 ) {
                 echo   "<a href='javascript: $m_function(\"DESCARREGAR\",\"$m_relatext\",\"$usuario_conectado#anotacao\")' "
                          ." id='m_selecionado' class='link_href' title='Clicar para selecionar Anota&ccedil;&atilde;o'  >";                
            }
           ?>
            <td  style='white-space:nowrap; font-weight: bold; border: 1px solid #000000; <?php echo $font_size_family;?>  '><?php  echo $valor;?></td>
           <?php          
            if( $sem_link==1 ) echo "</a>";                               
        }
    ?>
      </tr>
    <?php
      $conta_linha++;
    }

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
    echo "</div>";
    ?>
    <!--  FINAL da Tabela de dados  -->
    <?php
    exit();
}
?>