<?php
///  AJAX da opcao Alterar  - Servidor PHP para alterar Anotacao do PROJETO
///
///  LAFB&SPFB110908.1151
#
ob_start(); /* Evitando warning */
///
///  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
/// set IE read from page only not read from cache
///  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

///  header("content-type: application/x-javascript; charset=tis-620");
///  header("content-type: application/x-javascript; charset=iso-8859-1");
header("Content-Type: text/html; charset=ISO-8859-1",true);
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');
///
/// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
///
////  Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
/// Final - Mensagens para enviar 


///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= utf8_decode("Sessão incluir_arq não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];

///   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
$_SESSION["data_de_hoje"]=date("d/m/Y");
$data_de_hoje = $_SESSION["data_de_hoje"];
///
///  Par?metros de controle para esse processo:
if( isset($_POST['cip']) ) $cip = $_POST['cip'];
if( isset($_SESSION["usuario_conectado"]) ) {
     $anotador = $_SESSION["usuario_conectado"];
     $usuario_conectado = $_SESSION["usuario_conectado"];      
} elseif( ! isset($_SESSION["usuario_conectado"]) ) {
     $anotador = "";
     $usuario_conectado = "";          
}
///
if( isset($_POST['grupoanot']) ) {
   $opcao = $_POST['grupoanot'];   
}  else {
    if( ! isset($_POST['grupoanot']) ) $opcao="" ;   
}
///
if( isset($_POST['op_selcpoid']) ) {
   $op_selcpoid = $_POST['op_selcpoid'];   
} else {
   if( ! isset($_POST['op_selcpoid']) ) $op_selcpoid="" ;   
}
///
if( isset($_POST['op_selcpoval']) ) {
   $op_selcpoval = $_POST['op_selcpoval'];   
} else if( ! isset($_POST['op_selcpoval']) ) {
   $op_selcpoval="" ;  
} 
///
/// Conectando
$elemento=5; $elemento2=6;
////  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     
require_once("php_include/ajax/includes/tabela_pa.php");
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];        
///
//  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///  
$opcao_maiusc =strtoupper(trim($opcao)); 
///  Arquivo da tabela de consulta projeto - Importante
$arq_tab_altera_anotacao="{$incluir_arq}includes/tabela_altera_anotacao.php";
///
if( $opcao_maiusc=="DESCARREGAR" or $opcao_maiusc=="SUBSTITUIR"  )  {
    /// Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
    set_time_limit(0);
    $post_array = array("grupoanot","val","m_array");
    for( $i=0; $i<count($post_array); $i++ ) {
        $xyz = $post_array[$i];
        ///  Verificar strings com simbolos: # ou ,   para transformar em array PHP
        $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
        if ( isset($_POST[$xyz]) ) {
            $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
            if( $pos1===false ) {
                ///  $$xyz=trim($_POST[$xyz]);
                ///   Para acertar a acentuacao - utf8_encode
                $$xyz = utf8_decode(trim($_POST[$xyz])); 
            } else {
                 $$xyz = explode($div_array_por,$_POST[$xyz]);   
            }
        }
    }    
    ///  
    ///  UPLOAD -  do Servidor para maquina local
    if( $opcao_maiusc=="DESCARREGAR" )  {
         ///  Projeto
        $cip=$m_array[2];
        ///  Anotacao
        $n_anotacao=$val;
        //  Selecionando os dados da Anotacao do Projeto escolhida
        $sqlcmd0 = "SELECT a.numero, a.alteraant, a.alteradapn, a.autor, "
                     ." a.titulo as titulo_anotacao, a.testemunha1, a.testemunha2,     "
                     ." concat($cip,'#',a.numero) as Detalhes, b.nome as Anotador, "
                     ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                     ." a.relatext  FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                     ." WHERE a.autor=b.codigousp and  a.projeto=$cip and a.numero=$n_anotacao ";
        ///
        ///   Executando Select/MySQL
        ///   Utilizado pelo Mysql/PHP - IMPORTANTE -20180615      
        /***
        *    O charset UTF-8  uma recomendacao, 
        *    pois cobre quase todos os caracteres e 
        *    símbolos do mundo
        ***/
         mysql_set_charset('utf8');
        ///                         
        $result_consult_anotacao = mysql_query($sqlcmd0);
        if( ! $result_consult_anotacao ) {
            /* $msg_erro .= "Consultando a tabela anota&ccedil;&atilde;o  - Falha: ".mysql_error().$msg_final;
                echo $msg_erro;  */
            echo $funcoes->mostra_msg_erro("&nbsp;Consultando a tabela anota&ccedil;&atilde;o  -&nbsp;db/mysql:&nbsp;".mysql_error());
            exit();        
        } 
        ///  Definindo os nomes dos campos das Tabelas selecionadas no Mysql - mysql_fetch_array - IMPORTANTE
        $n_regs = mysql_num_rows($result_consult_anotacao);
        if( intval($n_regs)>=1  ) {
            $array_nome0=mysql_fetch_array($result_consult_anotacao);
            foreach( $array_nome0 as $cpo_nome => $cpo_valor ) {
                 $$cpo_nome=$cpo_valor;
            }
            unset($array_nome0);
        }
        ///  Anotador da Anotacao do Projeto
        if( isset($autor) ) $_SESSION["anotador_codigousp"]=$autor;
        ///  Nome do arquivo da Anotacao
        if( isset($relatext) ) $_SESSION["arquivado_como"]=$arquivado_como=$relatext;
        ///
        $sqlcmd1 = "SELECT autor as autor_projeto, titulo as projeto_titulo,  "
                  ." fonterec, fonteprojid, numprojeto FROM $bd_2.projeto "
                  ."  WHERE cip=$cip  ";
        ///                  
        $sqlcmd2 = mysql_query($sqlcmd1);
        if( ! $sqlcmd2 ) {
            /* $msg_erro .= "Consultando a tabela projeto - Falha: ".mysql_error().$msg_final;
            echo $msg_erro;  */
             echo $funcoes->mostra_msg_erro("&nbsp;Consultando a Tabela projeto -&nbsp;db/mysql:&nbsp;".mysql_error());
             exit();        
        }
        // 
        $autor_projeto=mysql_result($sqlcmd2,0,"autor_projeto");
        $_SESSION["autor_projeto"]=$autor_projeto;
        $_SESSION["numprojeto"]=mysql_result($sqlcmd2,0,"numprojeto");
        $projeto_titulo=mysql_result($sqlcmd2,0,"projeto_titulo");
        $fonterec=mysql_result($sqlcmd2,0,"fonterec");
        $fonteprojid=mysql_result($sqlcmd2,0,"fonteprojid");   
        $_SESSION["projeto_cip"]=$cip;
        // Numero da Anotacao do Projeto
        if( isset($n_anotacao) ) $_SESSION["n_anotacao"]=$n_anotacao;
        if( isset($relatext) ) $_SESSION["relatext_orig"]=$relatext;    
        //  PARTES do Titulo do Projeto - dividindo em sete partes - IMPORTANTE
        $partes_antes=6;
        $projeto_titulo_parte="";
        $palavras_titulo = explode(" ",trim($projeto_titulo));
        $contador_palavras=count($palavras_titulo);
        for( $i=0; $i<$contador_palavras; $i++  ) {
             $projeto_titulo_parte .="{$palavras_titulo[$i]} ";
             if( $i==$partes_antes and $contador_palavras>$partes_antes  ) {
                  $projeto_titulo_parte=trim($projeto_titulo_parte);
                  $tamanho_campo=strlen($projeto_titulo_parte);
                  if( $tamanho_campo>40  ) $projeto_titulo_parte.="...";
                  //  $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
                  break;
             }
        }
        $titulo_projeto="";
        if( strlen(trim($fonterec))>=1  ) {
            $titulo_projeto.= $fonterec."/";
        }
        if( strlen(trim($fonteprojid))>=1  ) {
            $titulo_projeto.= $fonteprojid.": ";
        }
        $titulo_projeto .= trim($projeto_titulo_parte);
        ///
        $cmdsql= "Select nome as nome_autor_projeto FROM $bd_1.pessoa WHERE codigousp=$autor_projeto  ";
        $res_cmdsql = mysql_query($cmdsql);
        if( ! $res_cmdsql ) {
            echo $funcoes->mostra_msg_erro("Select Tabela pessoa  campo codigousp -&nbsp;db/mysql:&nbsp;".mysql_error());
            exit();                
        }
        $n_registros=mysql_num_rows($res_cmdsql);
        //  Nome do Autor do Projeto dessa Anotacao
        if( $n_registros==1  ) {
            $_SESSION["nome_autor_projeto"]=mysql_result($res_cmdsql,0,"nome_autor_projeto");    
        }   
        //  Data e Hora de hoje
        $_SESSION["datetime"]=date('Y-m-d H:i:s');
        ///
       //// FORM --->>>  accept-charset='utf-8' <<<---  Utilizado pelo Mysql/PHP - IMPORTANTE -20180615      
    ?>
    <form accept-charset="utf-8"  name="form_alterar_anotacao" id="form_alterar_anotacao"  enctype="multipart/form-data"  method="post" > 

<!-- div - ate antes do Cancelar e  Remover -->            
  <div class="parte_inicial" >
    
    
<!-- ANOTADOR ANTERIOR -->
      <div class="div_nova" >
         <span>
            <label title="Anotador" >Anotador anterior:&nbsp;</label>
         </span>
         <span class="span_div_nova" >
                 <?php echo $Anotador;?>
           </span>
          <input type="hidden" name="autor" id="autor" size="80" maxlength="86" value="<?php echo $usuario_conectado;?>" />
           <?php
            if( $_SESSION["permit_pa"]==$array_pa['orientador'] ) {
                if( $autor!=$usuario_conectado ) {
                    echo  "&nbsp;&nbsp;&nbsp;<button  type=\"button\" name=\"substituir\" id=\"substituir\"  class=\"botao3d\"  onClick=\"javascript: consulta_alteraranot('SUBSTITUIR','ANOTADOR',$usuario_conectado);\"  style=\"cursor: pointer; width: 140px; \"  title=\"Substituir Anotador\"  acesskey=\"S\" >";    
                    echo  "Substituir&nbsp;Anotador</button>";
                }
            }
           ?>

      </div>
   <!-- Final - ANOTADOR ANTERIOR -->

    <!-- Titulo do Projeto -->
      <div class="div_nova" >
         <div style="overflow: auto; width: 98%; padding: .3em;">
             <label class="titulo_pequeno"  style=" vertical-align: top;" >
                 T&iacute;tulo do Projeto:&nbsp;
             </label>
             <textarea rows="3" disabled="disabled"  name="projeto_titulo"  ><?php echo nl2br($projeto_titulo);?></textarea>
         </div>                    
      </div>
   <!-- Final - Titulo do Projeto -->
    



       <table class="table_inicio" cols="<?php echo $cols;?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; "  >
        <tr class="td_inicio1" >
         <td class="td_inicio1"  colspan="2" style="text-align: right; background-color:#FFFFFF; color:#000000;" >Anota&ccedil;&atilde;o#</td>
         <!--  Nr. Anotacao 
            <td id="nr_anotacao" class="td_inicio1"  style="vertical-align:middle; text-align: left;  background-color:#FFFFFF; color:#000000; " >&nbsp; 
            </td>
         -->
         <td id="nr_anotacao" class="td_inicio1" style="text-align: left; background-color:#FFFFFF; color:#000000;"  >
             <?php echo $n_anotacao?>
         </td>
         <!--  Data da Anotacao  -->
           <td class="td_inicio1" style="text-align: left; color:#000000; vertical-align: middle; "  >&nbsp;Data anterior:&nbsp;<span style="vertical-align: middle; background-color: #FFFFFF; color: #000000; ">&nbsp;<?php echo $Data;?>&nbsp;</span>&nbsp;&nbsp;<img align="middle" src="../imagens/seta1_direita.gif" style="vertical-align: middle;" >&nbsp;&nbsp;Data de hoje:&nbsp;<span style="vertical-align: middle; background-color: #FFFFFF; color: #000000;">&nbsp;<?php echo $_SESSION["data_de_hoje"];?>&nbsp;</span></td>
        </tr>
       </table>

    <!-- Titulo da Anotacao -->
      <div class="div_nova" >
         <div style="overflow: auto; width: 98%; padding: .3em;">
             <label class="titulo_pequeno"  style=" vertical-align: top;" >
                  T&iacute;tulo da Anota&ccedil;&atilde;o:&nbsp;
              </label>
              <textarea rows="3" cols="90" name="titulo" id="titulo" onKeyPress="javascript: limita_textarea('titulo');"  title="Digitar T&iacute;tulo da Anota&ccedil;&atilde;o" style="vertical-align: top;cursor: pointer; overflow:auto;" onblur="javascript: alinhar_texto(this.id,this.value)"  ><?php  echo $titulo_anotacao;?></textarea>     
         </div>                    
      </div>
   <!-- Final - Titulo da Anotacao -->

    <!-- Arquivo da Anotacao -->
    <div class="div_nova" style="margin: .2em 0 .2em 0;" >
       <span>
          <label>Arquivo da Anota&ccedil;&atilde;o:&nbsp;</label>
       </span>
        <span class="arquivado_como" >
             <?php echo $arquivado_como;?>
        </span>           
    </div>
    <!-- Final - Arquivo da Anotacao -->    
    
   <hr class="hr_new" >    

<!--  TESTEMUNHAS - 1 e 2  -->   
    <div class="div_nova" >
      <span>
      <label title="Testemunha (1)" >Testemunha (1):&nbsp;</label>   
      </span>
            <!-- Codigo da Testemunha (1) da realizacao  -->
            <?php 
                /// Select para a Testemunha 1    
                $result2=mysql_query("SELECT codigousp,nome,categoria FROM  $bd_1.pessoa order by nome ");
                if( ! $result2 ) {
                    /* $msg_erro .= "SELECT Tabela pessoa -  db/mysql: ".mysql_error().$msg_final;
                    echo $msg_erro;  */
                    echo $funcoes->mostra_msg_erro("SELECT Tabela pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());                
                    exit();  
                }
            ?>
            <select  class="td_select" name="testemunha1" id="testemunha1"  onfocus="javascript: document.getElementById('label_msg_erro').style.display='none';" title="Código da Testemunha (1) da realização" >
            <?php
                 ///  Código da Testemunha (1) da realiza??o 
                 if( isset($testemunha1) ) $testemunha_selec=$testemunha1;
                 $testemunhas_result = $result2;
                 include("{$_SESSION["incluir_arq"]}includes/testemunhas.php"); 
              ?>
              </select>
              <!-- Final - Codigo da Testemunha (1) -->
       </div>
       
       <div class="div_nova" >
          <span>
              <label title="Testemunha (2)" >Testemunha (2):&nbsp;</label>   
          </span>    
            <!-- Codigo da Testemunha (2) da realizacao  -->
                   <?php 
                //  mysql_db_query -  essa funcao esta desativada usar mysql_query
                //  $result=mysql_db_query($db_array[$elemento],"SELECT codigousp,nome,categoria FROM pessoa order by nome ");
                // Select para a Testemunha 2                
                $result=mysql_query("SELECT codigousp,nome,categoria FROM $bd_1.pessoa order by nome ");
                if( ! $result ) {
                   /* $msg_erro .= "SELECT Tabela pessoa -  db/mysql: ".mysql_error().$msg_final;
                    echo $msg_erro;  */
                    echo $funcoes->mostra_msg_erro("SELECT Tabela pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());                
                    exit();  
                }
            ?>
            <select name="testemunha2" id="testemunha2" class="td_select" title="Código da Testemunha (2) da realização" >
            <?php
                   ///  Código da Testemunha (2) da realiza??o 
                   if( isset($testemunha2) ) $testemunha_selec=$testemunha2;
                   $testemunhas_result = $result;
                   include("{$_SESSION["incluir_arq"]}includes/testemunhas.php"); 
              ?>
              </select>
              <!-- Final - Codigo da Testemunha (2) -->
              <input type="hidden" id="data" name="data" value="<?php echo $_SESSION["datetime"];?>"/>
       </div>
       
       
<!-- Final - TESTEMUNHAS - 1 e 2  -->       
      
 
 </div>
<!-- Final - div - ate antes do Cancelar e  Remover -->  
      

   <!--  BUTTON - Cancelar e Alterar  -->    
        <div class="reset_button"  >    
           <!-- Cancelar -->                  
            <span>
               <button  type="button" name="cancelar" id="cancelar"  class="botao3d"   
                   onClick="javascript: consulta_alteraranot('CANCELAR','LIMPAR');" 
                  title="Cancelar"  acesskey="C"  >    
                    Cancelar&nbsp;<img src="../imagens/limpar.gif" alt="Cancelar" >
               </button>
           </span>
           <!-- Final - Cancelar -->
           <!-- Alterar -->                  
             <span>
                 <button type="button" name="alterar" id="alterar"  class="botao3d" 
                   onClick="javascript: consulta_alteraranot('SUBMETER','ANOTACAO',this.form);"     title="Alterar"  acesskey="A" >    
                    Alterar&nbsp;<img src="../imagens/enviar.gif" alt="Alterar" >
                </button>
             </span>
            <!-- Final - Alterar -->
        </div>
        <!--  FINAL - BUTTON - Cancelar e Alterar  -->
      </form>
    <?php  
     /**    
         $msg_erro .= "  srv_alteraranot.php/53 -- \$numero = $numero - \$autor = $autor - \$grupoanot = $grupoanot -  \$val =  $val  - <br>"
             ." \m_array = $m_array - \$m_array[0] = ".$m_array[0]." - \$m_array[1] = ".$m_array[1]." - \$m_array[2] = {$m_array[2]} "
             ."<br> \$n_regs = $n_regs   ";
         echo $msg_erro;
      **/
      exit();   
      ///  
   }  
   /// Final  - if( $opcao_maiusc=="DESCARREGAR" )  { 
   ///
}
/******  Final  -- if( $opcao_maiusc=="DESCARREGAR" or $opcao_maiusc=="SUBSTITUIR"  )   *****/
///
///  Botao Busca Projeto
if( $opcao_maiusc=="BUSCA_PROJ" )  {
     ///  Verifica se existe ANOTACOES para o PROJETO escolhido
      $sqlcmd = "SELECT sum(anotacao) as nanotacoes FROM  $bd_2.projeto  "
                 ." WHERE cip=$val  ";
      $result_consult_anotacao = mysql_query($sqlcmd);
      if( ! $result_consult_anotacao ) {
            echo $funcoes->mostra_msg_erro("Selecionando Anotação na tabela  -&nbsp;db/mysql:&nbsp;".mysql_error());            
            exit();        
      } 
      $nanotacoes=mysql_result($result_consult_anotacao,0,0);     
      if( intval($nanotacoes)<1 ) {
            echo $funcoes->mostra_msg_erro("Nenhuma Anotação desse Projeto.");
      } 
      exit();        
      ///
}
/*****   Final - if( $opcao_maiusc=="BUSCA_PROJ" )  *****/
///
///  SUBSTITUIR O ANOTADOR PELO ORIENTADOR
if( $opcao_maiusc=="SUBSTITUIR"  )  {
     // variaveis que recebidas   grupoanot,val,m_array
     //  SESSAO para salvar o codigousp do Anotador Substituto
     $_SESSION["anotador_substituto_codigousp"]=$m_array;    
     //  Selecionando os dados da Anotacao do Projeto escolhida
     $sqlcmd1 = "SELECT nome as anotador_substituto_nome "
                 ." FROM $bd_1.pessoa  WHERE codigousp={$_SESSION["anotador_substituto_codigousp"]}  ";

     //
     $resultado_anotador_nome = mysql_query($sqlcmd1);
     if( ! $resultado_anotador_nome ) {
        /* $msg_erro .= "Consultando a tabela pessoa nome do anotador  - Falha: ".mysql_error().$msg_final;
        echo $msg_erro;  */
        
        echo $funcoes->mostra_msg_erro("&nbsp;Consultando a Tabela pessoa campo nome do anotador  - db/mysql:&nbsp; "
                                         .mysql_error());
        exit();        
     } 
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     $array_nome_anotador=mysql_fetch_array($resultado_anotador_nome);
     foreach( $array_nome_anotador as $anotador_chave => $anotador_valor ) {
              $$anotador_chave=$anotador_valor;
     }             
     if( isset($anotador_substituto_nome) ) $_SESSION["anotador_substituto_nome"]=$anotador_substituto_nome;
     if( ! isset($anotador_substituto_nome) ) $_SESSION["anotador_substituto_nome"]="";
     //
     echo $_SESSION["anotador_substituto_codigousp"]."#".$_SESSION["anotador_substituto_nome"];         
     exit();    
}
/*********  Final - SUBSTITUIR O ANOTADOR PELO ORIENTADOR   ****/
///
///  Mostrar todas as anotacoes de um Projeto
if( preg_match("/^TODOS|ordenar/i",$opcao_maiusc) )  {
        /*  ANTERIOR SENDO ALTERADA EM 20120229
                    $sqlcmd = "SELECT numero as n, alteraant as altera_n, autor as anotador, data, testemunha1, testemunha2, "
                    ."titulo, relatext as arquivado_em FROM $bd_2.anotacao  ";
            $where_cond = " WHERE projeto=".$cip." and autor=".$anotador;
            switch ($opcao) 
            {
            case "TODOS":
                $where_cond .= "";
                break;
            default:
                $where_cond .= "";
            }
            //  $sqlcmd .= $where_cond." order by titulo";
            $sqlcmd .= $where_cond." order by numero";
            //
            $result = mysql_query($sqlcmd);
        */
        /// Criando uma tabela Temporaria para consultar ANOTACOES de um Projeto 
        $table_alterar_anotacao = $_SESSION["table_alterar_anotacao"] = "$bd_2.temp_alterar_anotacao";
        ///  Removendo uma tabela temporaria  caso exista
        $sql_temp = "DROP TABLE IF EXISTS  $table_alterar_anotacao  ";  
        $drop_result = mysql_query($sql_temp); 
        if( ! $drop_result  ) {
            //  NAO USAR DIE  TEM  FALHA
            //  die('ERRO: Falha consultando a tabela '.$_SESSION["table_alterar_anotacao"].' - '.mysql_error());         
            /* $msg_erro .= "Consultando a tabela ".$_SESSION["table_alterar_anotacao"]." - Falha: ".mysql_error().$msg_final;
            echo $msg_erro; */
            echo $funcoes->mostra_msg_erro("&nbsp;Removendo a Tabela $table_alterar_anotacao -&nbsp;db/mysql:&nbsp;"
                                           .mysql_error());
            ////                                           
            exit();        
        }
        ////
        $_SESSION["selecionados"]="";
        /// Numero do CIP - Codigo de Identificacao do Projeto
        $alterar=FALSE;
        if( ! isset($cip) ) {
            $alterar=TRUE;
        } elseif( intval($cip)<1 ) {
            $alterar=TRUE;
        }
        if( $alterar ) {
            if( isset($val) ) {
                $cip=$val;             
            }  else {
                 echo $funcoes->mostra_msg_erro(utf8_decode("Variável val não definida corrigir."));            
                 exit();        
            }
        }
        //// 
        ///  Selecionar os usuarios de acordo com o op??o
       //// $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_alterar_anotacao"]."   ";
        /*  Alterado 2012/07/20
        $sqlcmd .= "SELECT a.numero as nr, a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as T?tulo, b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo, c.autor as projeto_autor FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
       */  
       /***
       $sqlcmd .= "SELECT a.numero as nr, a.alteraant as Altera, a.alteradapn as Alterada, "
                 ." a.titulo as T?tulo, c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, b.nome as Anotador, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo, c.autor as projeto_autor FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
        ****/         
        /// Contador de linhas - resultado do Select/Mysql
        mysql_query("SET @xnr:=0");
        $sqlcmd ="CREATE TABLE  IF NOT EXISTS $table_alterar_anotacao  ";
        $sqlcmd .= "SELECT @xnr:=@xnr+1 as nr, a.numero as NA, a.titulo as titulo, "
                 ."  b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data, "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." a.relatext as Arquivo, c.autor as projeto_autor FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
         ///        
        ///  if( $_SESSION["permit_pa"]==$_SESSION['array_usuarios']['orientador'] )  {
        if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
                $where_cond = "  a.projeto=$cip   ";    
        } else {
             ////  } else   $where_cond = "  a.projeto=".$cip." and a.autor=".$usuario_conectado;            
             $where_cond = "  a.projeto=".$cip." and a.autor=".$anotador;         
        }  
        ////
        ///  $sqlcmd .= $where_cond." order by a.numero desc";
        if( ! isset($m_array) ) {
             $sqlcmd .= $where_cond." order by a.numero desc";            
        } else {
             if( strlen(trim($m_array))>0 ) {
                  $m_array=str_replace("Data","data",$m_array);
                  $m_array=str_replace("Titulo","titulo",$m_array);
                  $sqlcmd .= $where_cond." order by $m_array";               
             }
        }
        ///
        ///  Executando Criando uma Tabela Temporaria
        $result_consult_anotacao = mysql_query($sqlcmd);
        if( ! $result_consult_anotacao ) {
            /*  $msg_erro .= "Consultando a tabela anota&ccedil;&atilde;o  - Falha: ".mysql_error().$msg_final;
               echo $msg_erro;  */               
             echo $funcoes->mostra_msg_erro("Consultando as Tabelas anota&ccedil;&atilde;o, pessoa e projeto  -&nbsp;db/mysql:&nbsp;".mysql_error());
             exit();        
        }
        /// 
        ///  Selecionando todos os registros da Tabela temporaria de consulta Anotacoes
        $query2 = "SELECT * FROM  $table_alterar_anotacao  ";
        $resultado_outro = mysql_query($query2);                                    
        if( ! $resultado_outro ) {
             /*  $msg_erro .= "Selecionando as Anota&ccedil;&otilde;es do Projeto  - Falha: ".mysql_error().$msg_final;
             echo $msg_erro;        */             
             echo $funcoes->mostra_msg_erro("Selecionando as Anota&ccedil;&otilde;es do Projeto -&nbsp;db/mysql:&nbsp;".mysql_error());
             exit();
        }         
        ///  Total de registros
        $_SESSION["total_regs"] = $total_regs = mysql_num_rows($resultado_outro);
        if( intval($total_regs)<1 ) {
            /* $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto.".$msg_final;
            echo $msg_erro; */            
             echo $funcoes->mostra_msg_erro("Nenhuma Anota&ccedil;&atilde;o para esse Projeto.");
             exit();
        }   
        ///  Pegando os nomes dos campos do primeiro Select
        $num_fields=mysql_num_fields($resultado_outro);  ///  Obtem o numero de campos do resultado
        $projeto_titulo = mysql_result($resultado_outro,0,"projeto_titulo");
        $_SESSION["projeto_autor"] = $projeto_autor = mysql_result($resultado_outro,0,"projeto_autor");                         
        $td_menu = $num_fields+1;   
        $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> Anota&ccedil;&atilde;o " : $lista_usuario="<b>".$_SESSION['total_regs']."</b> Anota&ccedil;&otilde;es ";     
        $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal; '  >";
        $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
        //  Buscando a pagina para listar os registros        
        $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
        if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag;
        $_SESSION["pagina"]=0;
        $_SESSION["m_function"]="consulta_alteraranot" ;  
        /// 
        $_SESSION["conjunto"]="Anotacao#@=".$usuario_conectado."#@=".$cip;
        $_SESSION["opcoes_lista"] = "{$arq_tab_altera_anotacao}?pagina=";
        require_once("{$arq_tab_altera_anotacao}");                      
        ///
        exit();
        ////
}
/*********  Final -  Mostrar todas as anotacoes de um Projeto   **********/
///
///  ANOTACAO ESCOLHIDA -  DETALHES
if( $opcao_maiusc=="DETALHES" )  {
    ///  ANOTACAO A VARIAVEL val = array 
    if( strpos($val,"#")!==false ) $array_proj_anot = explode("#",$val);
    if( isset($array_proj_anot) ) {
        $cip=$array_proj_anot[0];
        $anotacao=$array_proj_anot[1];        
    }
    ///  Selecionando Projeto
     $sqlcmd  = "SELECT a.numprojeto, a.titulo as  titulo_projeto, b.nome as autor_projeto,  "
                ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as data_projeto "
                ." FROM $bd_2.projeto a, $bd_1.pessoa b WHERE a.cip=$cip and a.autor=b.codigousp  ";
     ///
     $resultado_projeto = mysql_query($sqlcmd);
     if( ! $resultado_projeto ) {
          /// die("ERRO: Selecionando Projeto: cip = ".$cip." - ".mysql_error());  
          echo $funcoes->mostra_msg_erro("Select Tabelas projeto e pessoa campos cip e autor - db/mysql:&nbsp;".mysql_error());
          exit();
     }         
     ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     $array_nome=mysql_fetch_array($resultado_projeto);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     ////  Desativando variavel mysql
     if( isset($resultado_projeto) ) mysql_free_result($resultado_projeto); 
     /*    
      a.numero as nr, a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as T?tulo, b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
         
     CAMPOS ABAIXO DO PROJETO: 
    $campos = "&nbsp; srv_alteraranotacao/192 -   \$numprojeto = $numprojeto -- \$titulo_projeto  = $titulo_projeto <br> ";
    $campos .= "\$autor_projeto =  $autor_projeto - \$data_projeto = $data_projeto  -- \$anotacao = $anotacao ";       
        //
         
        */
     //  Selecionando a ANOTACAO do Projeto        
    $sqlcmd = "SELECT  a.numero as numero_anotacao, a.alteraant as altera, a.alteradapn as alterada, "
              ." a.titulo as titulo_anotacao, a.testemunha1, a.testemunha2, b.nome as autor_anotacao, "
              ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anotacao, "
              ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b "
              ."  WHERE a.autor=b.codigousp and a.projeto=$cip and a.numero=$anotacao  ";           
      ////     
     $resultado_anotacao = mysql_query($sqlcmd);
     if( ! $resultado_anotacao ) {
         /* $msg_erro .= "Selecionando Anota&ccedil;&atilde;o $anotacao do  Projeto: ".$numprojeto." - ".mysql_error().$msg_final;  
          echo $msg_erro;  */
         echo $funcoes->mostra_msg_erro("Select Tabelas anotacao e pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());          
         exit();
     }         
     ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     if( isset($array_nome) ) unset($array_nome);
     $array_nome=mysql_fetch_array($resultado_anotacao);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     if( isset($resultado_anotacao) ) mysql_free_result($resultado_anotacao);
     //  Selecionando os Nomes das Testemunhas da ANOTACAO
     if( strlen(trim($testemunha1))>=1 or strlen(trim($testemunha2))>=1  ) {
         if( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))>=1 ) {
             $in = " in($testemunha1,$testemunha2)";
         } elseif( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))<1 ) {
             $in = " in($testemunha1)";
         } elseif( strlen(trim($testemunha1))<1 and strlen(trim($testemunha2))>=1 ) {
               $in = " in($testemunha2)";
         } 
         ///  Selecionando as Testemunhas da Anotacao          
         $cmd_sql = "SELECT codigousp as cod_testemunha, nome as nome_testemunha  FROM  $bd_1.pessoa "
                   ."  WHERE  codigousp $in ";
          ///         
         $res_testemunhas = mysql_query($cmd_sql);
         if( ! $res_testemunhas ) {
             /* $msg_erro .= "Selecionando testesmunhas da  Anota&ccedil;&atilde;o. mysql = ".mysql_error().$msg_final;  
             echo $msg_erro;  */       
             echo $funcoes->mostra_msg_erro("Selecionando testemunhas da Anota&ccedil;&atilde;o -&nbsp;db/mysql:&nbsp;".mysql_error());
             exit();
         }        
         $num_regs = mysql_num_rows($res_testemunhas); $testemunhas="";
         for( $ntest=0 ; $ntest<$num_regs ; $ntest++ ) {
              $nome_testemunha[$ntest]= mysql_result($res_testemunhas,$ntest,"nome_testemunha");              
              $x_testemunha = (int) $ntest+1;
              $testemunhas .="<p style='text-align:center;font-size: medium;'>"
                    ."<b>Testemunha$x_testemunha</b>:&nbsp;".$nome_testemunha[$ntest]."</p>";              
         }
     }
     //   Projeto
     $confirmar0 ="<p style='text-align:center;font-size: medium;'>"
                     ."<b>Anota&ccedil;&atilde;o $numero_anotacao do Projeto $numprojeto </b><br>"
                     ."<b>Autor do Projeto</b>: $autor_projeto</p>";
     $confirmar0 .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo do Projeto</b>:<br>"                
                 ."$titulo_projeto </div>";
     $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                    ."<b>Data in&iacute;cio do Projeto</b>:&nbsp;$data_projeto </p>";
     // Anotacao do Projeto                    
     $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                 ."<b>Anota&ccedil;&atilde;o</b>: $numero_anotacao<br>"
                 ."<b>Anotador</b>: $autor_anotacao  </p>";
     $confirmar0 .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo da Anota&ccedil;&atilde;o</b>:<br>"                
                 ."$titulo_anotacao</div>";                                     
     $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                    ."<b>Data da Anota&ccedil;&atilde;o</b>:&nbsp;$data_anotacao </p>";                 
     $confirmar0 .= $testemunhas;                    
     $confirmar1 =$confirmar0."<div style='width: 100%; text-align: center;'>";                                         
     $confirmar1 .="<button  class='botao3d_menu_vert' style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: limpar_form();' >Ok";                                  
     $confirmar1 .="</button></div>";                                         
     echo $confirmar1;
     ///               
     exit();
}
/**********   Final -  ANOTACAO ESCOLHIDA -  DETALHES   **********/
///
///  RECEBENDO OS DADOS E ALTERANDO A ANOTACAO DO PROJETO - Fase Final
if( $opcao_maiusc=="SUBMETER" )  {
      /// 
      $m_erro=0;
      if( isset($array_temp) ) unset($array_temp); 
      if( isset($array_t_value) ) unset($array_t_value);
      if( isset($count_array_temp) ) unset($count_array_temp);
      if( isset($arr_nome_val) ) unset($arr_nome_val);
     ///
     $cpo_final="cancelar";
     ////  include("../includes/dados_campos_alterar_anotacao.php");
     include("{$incluir_arq}includes/dados_campos_alterar_anotacao.php");
     ///
     ///  Definindo os nomes dos campos recebidos do FORM - variavel arr_nome_val - IMPORTANTE
     foreach( $arr_nome_val as $key => $value )  $$key=$value;  
     ///
     $titulo=trim($titulo);
     ///
      mysql_set_charset('utf8');
      $titulo = utf8_encode($titulo);      
      ///    
     $result_alt_anot = mysql_query("SELECT * FROM  $bd_2.anotacao  "
                 ." WHERE projeto={$_SESSION["projeto_cip"]} and "
                 ." numero!={$_SESSION["n_anotacao"]} and trim(titulo)=\"$titulo\"   ");
     ///
     if( ! $result_alt_anot  ) {
          echo $funcoes->mostra_msg_erro("Select Tabela anotacao - db/mysql:&nbsp;".mysql_error());
          exit();
     }
     ///  Verificar se tem outra Anotacao desse mesmo Projeto com campos duplicados
     $n_registros=mysql_num_rows($result_alt_anot);
     if( intval($n_registros)>=1  ) {
           echo $funcoes->mostra_msg_erro("Duplicata:&nbsp;Outra Anota&ccedil;&atilde;o com o mesmo T&iacute;tulo");
           exit();          
     }
     ///  Continuacao Tabela anotacao para ALTERAR
     /*   MELHOR jeito de acertar a acentuacao - html_entity_decode     */    
     ///  essa variavel arq_pdf veio do FORM igual ao campo da tabela anotacao ->  relatext           
     $n_erro=0;
     ///  START a transaction - ex. procedure    
     mysql_query('DELIMITER &&'); 
     $commit = "commit";
     mysql_query('begin'); 
     ///  Execute the queries 
     ///  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
     ///   - Use mysql_select_db() ou mysql_query()
     mysql_query("LOCK TABLES $bd_2.anotacao  UPDATE ");
     ///  $sqlcmd="UPDATE $bd_2.projeto  (".$_SESSION["campos_nome"].") values(".$_SESSION["campos_valor"].") ";       
     $texto="Anota&ccedil;&atilde;o {$_SESSION["n_anotacao"]} do "
             ." Projeto {$_SESSION["numprojeto"]} do "
             ." Autor {$_SESSION["nome_autor_projeto"]} <b>N&Atilde;O</b> foi alterada.";
     ///
     $sqlcmd="UPDATE $bd_2.anotacao SET autor=$autor,titulo='$titulo',  "
                  ." testemunha1=$testemunha1,testemunha2=$testemunha2,data='$data'  "
                  ." WHERE projeto={$_SESSION["projeto_cip"]} and numero={$_SESSION["n_anotacao"]} ";
     ///                      
     $success=mysql_query($sqlcmd); 
     ///  Nota: Se voce esta usando transacoes, voce deve chamar mysql_affected_rows() apos sua query 
     ///        INSERT, UPDATE, ou DELETE, nao depois de commit.  - IMPORTANTE
     $numero_registros=mysql_affected_rows();
     ///  Complete the transaction 
     if( $success ) { 
          ///  Alterando os dados da Tabela anotacao
          ///  $numero_registros=mysql_num_rows($success);           
          $commit='commit';                                  
          if( $numero_registros<1 ) {
               $n_erro=1;
               $commit='rollback';
               echo $funcoes->mostra_msg_erro($texto);
          }
     } else {
         $n_erro=1;
         ///  $msg_erro .="&nbsp;Projeto <b>N&Atilde;O</b> foi alterado. ERRO#1 = ".mysql_error().$msg_final;                 
         $commit='rollback';                                  
         if( ! $success  ) {
              echo $funcoes->mostra_msg_erro("$texto - db/mysql:&nbsp; ".mysql_error());
         } else {
             ///  $numero_registros=mysql_num_rows($success);
             if( $numero_registros<1 ) {
                  echo $funcoes->mostra_msg_erro($texto);
             }
         }      
     } 
     /// Final - do IF success  Else                  
     mysql_query($commit);
     mysql_query("UNLOCK  TABLES");
     mysql_query('end'); 
     mysql_query('DELIMITER');
     ///
     ///  Correto para comparar tem que ser com  == 
     if( intval($n_erro)<1 ) {
          ///  Data de hoje e horario  
          $data_atual=date("Y-m-d H:i:s"); 
         //  Tabela anotacao alterada 
         // Antes
         /*
           $msg_ok .="<p class='titulo_alterar' >";"
           $msg_ok .="Anota&ccedil;&atilde;o {$_SESSION["n_anotacao"]} do Projeto $numprojeto do "
                     ." autor {$_SESSION["nome_autor_projeto"]} foi alterado.<br><br>";
           $msg_ok .="Arquivo:&nbsp; $relatproj original em formato PDF (Substituir?)</p>".$msg_final;
                          echo  $msg_ok."falta_arquivo_pdf".$numprojeto."&".$autor."&".$relatproj;
            */
         ///  Depois com Class  -  20120803
         $texto_ok ="<p class='titulo_alterar' >"
                  ."Anota&ccedil;&atilde;o {$_SESSION["n_anotacao"]} do "
                  ." Projeto {$_SESSION["numprojeto"]} do autor {$_SESSION["nome_autor_projeto"]} foi alterado.<br><br>";
         $texto_ok .="Arquivo:&nbsp; {$_SESSION["relatext_orig"]} original em formato PDF (Substituir?)</p>";
         $texto_ok .="falta_arquivo_pdf".$_SESSION["projeto_cip"]."&".$_SESSION["autor_projeto"]."&".$_SESSION["relatext_orig"]."&".$_SESSION["n_anotacao"];
         echo $funcoes->mostra_msg_ok($texto_ok);
         ///
         ///  echo  $msg_ok."falta_arquivo_pdf".$numprojeto."&".$autor."&".$relatproj;
         /// Efetiva a transa??o nos duas tabelas (anotacao e projeto)   
     }
}
#
ob_end_flush(); 
#
?>