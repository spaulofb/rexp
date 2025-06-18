<?php
//  AJAX da opcao CONSULTAR  - Servidor PHP para mostrar PROJETO
//
//  LAFB&SPFB110908.1151
#
ob_start(); /* Evitando warning */
//
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
// set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

//  header("content-type: application/x-javascript; charset=tis-620");
//  header("content-type: application/x-javascript; charset=iso-8859-1");
///  header("Content-Type: text/html; charset=ISO-8859-1",true);

///  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
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
///
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
    echo "Sessão incluir_arq não está ativa.";
    exit();
}
///  DEFININDO A PASTA PRINCIPAL 
/////  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
///  Verificando SESSION  pasta_raiz
if( ! isset($_SESSION["pasta_raiz"]) ) {
     $msg_erro .= utf8_decode("Sessão pasta_raiz não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
$pasta_raiz=$_SESSION["pasta_raiz"];
///
///  Definindo http ou https
///  Definindo http ou https - IMPORTANTE
///  Verificando protocolo do Site  http ou https   
$_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
$raiz_central=$_SESSION["url_central"];
///
$opcao = $_POST['grupoproj'];
///
if( isset($_SESSION["usuario_conectado"]) ) {
   //// $orientador = $_SESSION["usuario_conectado"];    
    $usuario_conectado = $_SESSION["usuario_conectado"];       
} else {
     $msg_erro .= utf8_decode("Sessão usuario_conectado não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
////  Mensagens
include_once("{$incluir_arq}mensagens.php");
//
$elemento=5; $elemento2=6;
include("php_include/ajax/includes/conectar.php");     
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"]; 
//
//  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
////      
$opcao_maiusc = strtoupper(trim($opcao));

///  Arquivo da tabela de consulta projeto - importante
$arq_tab_consulta_projeto="{$incluir_arq}includes/tabela_consulta_projeto.php";
///
///  UPLOAD -  do Servidor para maquina local
if( $opcao_maiusc=="DESCARREGAR" )  {
    // Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
    set_time_limit(0);
    $post_array = array("grupoproj","val","m_array");
    for( $i=0; $i<count($post_array); $i++ ) {
        $xyz = $post_array[$i];
        //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
        $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
        if ( isset($_POST[$xyz]) ) {
            $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
            if ( $pos1 === false ) {
                ///  $$xyz=trim($_POST[$xyz]);
                ///   Para acertar a acentuacao - utf8_encode
               /// $$xyz = utf8_decode(trim($_POST[$xyz])); 
                $$xyz = trim($_POST[$xyz]); 
            } else {
                 $$xyz = explode($div_array_por,$_POST[$xyz]);   
            }
        }
    }    
    ///
    ///  Verificando Array (usuario_conectado, projeto, autor_codigo)
    if( sizeof($m_array)==3 ) {
         $usuario_conectado=$m_array[0];
         $pasta_projeto=$m_array[1];
         $cod_autor_proj=$m_array[2];
    }   
    ///
    /// $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
    $pasta = "{$_SESSION["incluir_arq"]}doctos_img/A".$cod_autor_proj;   
    $pasta .= "/".$pasta_projeto."/";             
    ///
    $host  = $protocolo."://".$_SERVER['HTTP_HOST']; 
    ///
    setlocale(LC_ALL,'pt_BR.UTF8');
    mb_internal_encoding('UTF8'); 
    mb_regex_encoding('UTF8');
    ///  Arquivo do Projeto
    header('Content-Type: text/html; charset=utf-8');
    if( ! ini_set('default_charset', 'utf-8') ) {
         ini_set('default_charset', 'utf-8');
    } 
    ////
    $arquivo = trim($val);
    /****
    *     Acentuacao e espacos no arquivo PDF  --- ALterado em 20180613 
    *            utilizando  utf8_encode       
    */
    //// if( ! file_exists("{$pasta}".utf8_encode($arquivo)) ) {
    $dir_arq=utf8_decode("{$pasta}$arquivo");
    
    ///  Funcionando 100%    
    ////  if( ! file_exists("{$pasta}$arquivo") ) {
    if( ! file_exists("$dir_arq") ) {    
       /*  $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
         echo $msg_erro;  */  
       echo  $funcoes->mostra_msg_erro("&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor");
    } else {
        ///  Codigo %#sepa%#rar%#  para separar pasta e arquivo
        $_SESSION["arquivo_projeto"]=$arquivo;
        $_SESSION["pasta_arq_projeto"]=$pasta;
        ////  echo $pasta."%#sepa%#rar%#{$arquivo}"; 
        echo  "{$_SESSION["pasta_arq_projeto"]}%#sepa%#rar%#{$_SESSION["arquivo_projeto"]}"; 
    }  
    exit();     
}
////  Mostrar todas as anotacoes de um Projeto
if( $opcao_maiusc=="TODOS" or $opcao_maiusc=="BUSCA_PROJ" ) {
         /// Definindo SESSION
         if( ! isset($_SESSION['selecionados']) ) $_SESSION['selecionados']="";
        ///  Criando uma tabela Temporaria para consultar PROJETO
        $_SESSION['table_consultar_projeto'] = "$bd_2.temp_consultar_projeto";
        $sql_temp = "DROP TABLE IF EXISTS   ".$_SESSION['table_consultar_projeto']."    ";  
        $drop_result = mysql_query($sql_temp); 
        if( ! $drop_result  ) {
            // die('ERRO: Falha consultando a tabela '.$_SESSION['table_consultar_projeto'].' - '.mysql_error());         
            /*  $msg_erro .= "Removendo a Tabela {$_SESSION['table_consultar_projeto']} - db/mysql:&nbsp; ".mysql_error();
            echo $msg_erro.$msg_final;  */            
            echo $funcoes->mostra_msg_erro("Removendo a Tabela {$_SESSION['table_consultar_projeto']} -&nbsp;db/mysql:&nbsp;".mysql_error());            
            exit();       
        }
        $_SESSION["selecionados"]=""; $where_cond="";
        ///  Selecionar os Projetos de acordo com o opcao - Alterado em 20180418
        /***
        $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION['table_consultar_projeto']."   ";
        $sqlcmd .= "SELECT a.numprojeto as nr, a.titulo as Titulo, "
                 ." b.nome as Autor, a.cip as Detalhes, "
                 ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as Data, "
                 ." a.relatproj as Arquivo FROM $bd_2.projeto a, $bd_1.pessoa b  "
                 ." WHERE a.autor=b.codigousp   ";
        ***/
        /// Contador de linhas - resultado do Select/Mysql
        mysql_query("SET @xnr:=0");
        $sqlcmd ="CREATE TABLE IF NOT EXISTS ".$_SESSION['table_consultar_projeto']."   ";
        $sqlcmd .= "SELECT @xnr:=@xnr+1 as nr,a.numprojeto as np, a.titulo as Titulo, "
                 ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as Data, "
                 ." a.autor as codautor, b.nome as Autor, a.cip as Detalhes, "
                 ." a.relatproj as Arquivo FROM $bd_2.projeto a, $bd_1.pessoa b  "
                 ." WHERE a.autor=b.codigousp   ";
        /// 
        ///  Variavel caracteres maiusculos
        switch ($opcao_maiusc) {
           case "TODOS":
                   ///
                  if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"];           
                  if( isset($array_pa['orientador']) ) $orientador=$array_pa['orientador'];   
                  if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
                       ///  Verificano se o Usuario conectado no programa REXP 
                      if( isset($_SESSION["usuario_conectado"]) ) {
                          $usuario_conectado = $_SESSION["usuario_conectado"];       
                      }                      
                      /// Modificado em 20180327
                       ///  $where_cond = " and  a.autor=$orientador ";    
                       $where_cond = " and  a.autor=$usuario_conectado ";    
                  } else {
                       $where_cond .= "";                   
                  }
                  $_SESSION['selecionados']=" - <b>Total</b>";
                  break;
           case "BUSCA_PROJ":
                  $where_cond .= " and  cip=$val ";
                  break;    
           default:
                 $where_cond .= "";
                 break;
        }
        if( strtoupper($val)=="ORDENAR" ) {
             $m_array=preg_replace('/cip/i', 'a.cip', $m_array);              
             //// $m_array=preg_replace('/NoMe/i', 'b.nome', $m_array);             
             $m_array=preg_replace('/titulo/i', 'Titulo', $m_array);             
             $m_array=preg_replace('/datainicio/i', 'a.datainicio', $m_array);             
             $sqlcmd .= $where_cond." order by $m_array  "; 
        } else {
             $sqlcmd .= $where_cond." order by a.cip desc";    
        }
        ///
        ///  Execuntando o mysql_query
        $result_consult_projeto = mysql_query($sqlcmd);
        if( ! $result_consult_projeto ) {
            /// die('ERRO: Falha consultando a tabela anota&ccedil;&atilde;o  - op&ccedil;&atilde;o='.$opcao.' - '.mysql_error());
            /* $msg_erro .= "&nbsp;Criando a Tabela  {$_SESSION['table_consultar_projeto']} - db/mysql:&nbsp; ";
            echo  $msg_erro.mysql_error().$msg_final; */
             echo $funcoes->mostra_msg_erro("Criando a Tabela  {$_SESSION['table_consultar_projeto']}&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());                        
             exit();
        }       
        ////
        ///  Selecionando todos os registros da Tabela temporaria de consulta Anotacoes
        $query2 = "SELECT * from  ".$_SESSION['table_consultar_projeto']."  ";
        $resultado_outro = mysql_query($query2);                                    
        if( ! $resultado_outro ) {
             //  die("ERRO: Selecionando os Projetos - mysql =  ".$cip.mysql_error());  
            /*  $msg_erro .= "&nbsp;Selecionando os Projetos - db/mysql:&nbsp; ".mysql_error().$msg_final;
              echo  $msg_erro;  */
            echo $funcoes->mostra_msg_erro("Selecionando os Projetos -&nbsp;db/mysql:&nbsp;".mysql_error());            
            exit();
        }         
        ///
        ///  Total de registros
        $_SESSION["total_regs"] = $n_regs_projeto = mysql_num_rows($resultado_outro);
        ///  Caso NAO encontrou Projeto        
        if( intval($n_regs_projeto)<1 ) {
             /// $msg_erro .= "INICIA&nbsp;N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.FINAL".$msg_final;
             ///  echo  $msg_erro;
             echo $funcoes->mostra_msg_erro("N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.FINAL");
             exit();            
        }
        ///  Pegando os nomes dos campos do primeiro Select
        ///  Obtem o n?mero de campos do resultado
        $num_fields=mysql_num_fields($resultado_outro);  
        ///  $projeto_titulo = mysql_result($resultado_outro,0,"Titulo");
        $td_menu = $num_fields+1;   
        ///  Total de registros
        /*
        $_SESSION["total_regs"] = mysql_num_rows($resultado_outro);
        if( $_SESSION["total_regs"]<1 ) {
            $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto:&nbsp;<br>$projeto_titulo".$msg_final;
            echo $msg_erro;
            exit();
        } 
        */  
        $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> Projeto " : $lista_usuario="<b>".$_SESSION['total_regs']."</b> Projetos ";
        //// $_SESSION["titulo"]= '<p class="titulo_consulta"  style="text-align: left; margin: 0px 0px 0px 4px; padding: 0px;"  >';
        $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal; '  >";
        $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
        //  Buscando a pagina para listar os registros        
        $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
        if( isset($_SESSION["ucfirst_data"]) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
        $_SESSION["pagina"]=0;
        $_SESSION["m_function"]="consulta_projeto" ;  $_SESSION["conjunto"]="Projeto#@=".$usuario_conectado."#@=";
        $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_projeto}?pagina=";
        require_once("{$arq_tab_consulta_projeto}");  
        if( isset($cip) ) unset($cip);
        ///
}  elseif( $opcao_maiusc=="DETALHES" )  {
    //  MUITO IMPORTANTE PASSAR A VARIAVEL val para cip
    $cip=$val;
    //  Selecionando Projeto
     $sqlcmd = "SELECT a.numprojeto,a.titulo as  titulo_projeto,a.autor as autor_projeto_cod, "
                ." a.coresponsaveis, b.nome as autor_projeto_nome,  "
                ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as data_projeto, a.relatproj as Arquivo "
                ." FROM $bd_2.projeto a, $bd_1.pessoa b WHERE a.cip=$cip and a.autor=b.codigousp  ";
     ///           
     $resultado_projeto = mysql_query($sqlcmd);
     if( ! $resultado_projeto ) {
          /*  $msg_erro .= "Selecionando Projeto  db/mysql - ".mysql_error().$msg_final;            
          echo  $msg_erro;  */
          echo $funcoes->mostra_msg_erro("Selecionando o Projeto -&nbsp;db/mysql:&nbsp;".mysql_error());
          exit();
     }         
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array - IMPORTANTE
     $array_nome=mysql_fetch_array($resultado_projeto);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }                  
     if( isset($resultado_projeto) ) mysql_free_result($resultado_projeto);     
     ////
     $coresp_dados="";
     if( $coresponsaveis>=1 ) {
         if( $coresponsaveis==1 ) $tit_coresp="Corespons&aacute;vel";
         if( $coresponsaveis>1 ) $tit_coresp="Corespons&aacute;veis";
         // Precisa iniciar zerando variavel @contador_regs
         $result_set=mysql_query("set @contador_regs=0;");
         if( ! $result_set ) {
              /*  $msg_erro .= "set @contador_regs=0; -  db/mysql:  ".mysql_error().$msg_final;            
              echo  $msg_erro;  */
              
              echo $funcoes->mostra_msg_erro("set @contador_regs=0; -&nbsp;db/mysql:&nbsp;".mysql_error());              
              exit();
         }         
         $result_coresp=mysql_query("SELECT @contador_regs:=@contador_regs+1 as n, "
                   ." b.nome as coresponsavel_nome FROM $bd_2.corespproj  a, $bd_1.pessoa b "
                   ." WHERE a.projetoautor=$autor_projeto_cod and a.projnum=$numprojeto and "
                   ." b.codigousp=a.coresponsavel order by b.nome ");
         ///
         if( ! $result_coresp ) {
              /*  $msg_erro .= "Select tabelas corespproj e pessoa -  db/mysql:  ".mysql_error().$msg_final;            
              echo  $msg_erro;  */                
              echo $funcoes->mostra_msg_erro("Select Tabelas corespproj e pessoa - db/mysql:&nbsp; ".mysql_error());
              exit();
         }   
         ///// 
         $coresp_dados .="<div style='text-align:center;font-size:small; overflow: auto;margin:0;'>";
         $coresp_dados .="<p style='text-align:center;font-size:small;font-weight:bold;margin:0;' >"
                        ."$tit_coresp:&nbsp;</p>";                              
         ///               
         $nregs_coresp = mysql_num_rows($result_coresp);
         for( $nc=0; $nc<$nregs_coresp; $nc++ ) {
           //  $n=mysql_result($result_coresp,$nc,"n");
             $n=$nc+1;
             $coresponsavel_nome=mysql_result($result_coresp,$nc,"coresponsavel_nome");
             $coresp_dados .="<span style='text-align:center;font-size:small;' >"
                     ."$n)&nbsp;$coresponsavel_nome</span><br>";                                              
         }                           
         $coresp_dados .="</div>";                        
     }
               
     //  Selecionando as ANOTACOES do PROJETO        
    $sqlcmd = "SELECT  a.numero as numero_anotacao, a.titulo as titulo_anotacao,  "
                ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anotacao "
                ."  FROM $bd_2.anotacao a, $bd_1.pessoa b "
                ." WHERE a.autor=b.codigousp and a.projeto=$cip ";  
     ///                          
     $resultado_anotacao = mysql_query($sqlcmd);
     if( ! $resultado_anotacao ) {
          /*
          $msg_erro .= "Selecionando Anota&ccedil;&otilde;es do Projeto: ".$numprojeto."  db/mysql - ".mysql_error().$msg_final;
          echo $msg_erro;  */
          echo $funcoes->mostra_msg_erro("Selecionando Anota&ccedil;&otilde;es do Projeto: {$numprojeto} -&nbsp;db/mysql:&nbsp;".mysql_error());          
          exit();
     }         
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     if( isset($array_nome) ) unset($array_nome);
     $num_anotacoes = mysql_num_rows($resultado_anotacao);
     $anotacoes ="" ;
     if( intval($num_anotacoes)>=1  ) {
          $anotacoes ="<div style='width: 100%; overflow: auto;padding-top:2px;'  >";
         /*  Mostra Anotacao por Anotacao - Desativado
          while( $reg_anot=mysql_fetch_array($resultado_anotacao) ) {
              // Anotacao do Projeto                            
              $anotacoes .="<p style='text-align:center;font-size: medium;'>"
                 ."<b>Anota&ccedil;&atilde;o</b>:&nbsp;".$reg_anot['numero_anotacao']."&nbsp;-&nbsp;"
                 ."<b>Data da Anota&ccedil;&atilde;o</b>:&nbsp;".$reg_anot['data_anotacao']."</p>";
              $anotacoes .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo da Anota&ccedil;&atilde;o</b>:<br>"                
                 .$reg_anot['titulo_anotacao']."</div>";                                     
          }
          */
          $anotacoes .="<p style='text-align:center;font-size: small;padding-top:2px;' >";
          $anotacoes .="Total de Anota&ccedil;&otilde;es desse Projeto:&nbsp;";
          $anotacoes .="<span style='font-weight:bold;' >$num_anotacoes</span></p>";
          $anotacoes .="</div>" ;
     }
     ///   Projeto
     $confirmar0 ="<div class='confirmar0' >";
     $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
               ."<b>Projeto $numprojeto </b><br>"
               ."<span style='font-size:small;'>"
               ."<b>Autor do Projeto</b>: $autor_projeto_nome</span></p>";
     $confirmar0 .="<div style='text-align:center;font-size:small;' >"
                 ."<b>T&iacute;tulo do Projeto</b>:<br>"                
                 ."$titulo_projeto </div>";
     $confirmar0 .="<p style='text-align:center;font-size:small;padding-top:1em;'>"
                    ."<b>Data in&iacute;cio do Projeto</b>:&nbsp;$data_projeto </p>";
     $confirmar0 .="<p style='text-align:center;font-size: small;  margin-top:4px;'>"
                    ."<b>Arquivo do Projeto</b>:&nbsp;$Arquivo</p>";  
                    
     $confirmar0 .=$coresp_dados."<br/>";
     $confirmar0 .=$anotacoes;  
     ///
     ///  Verifica qual é o navegador
     if( isset($navegador) ) {
            $confirmar1 =$confirmar0;
            if( strtoupper($navegador)!="CHROME" ) {
                  $confirmar1 .="<div style='width: 100%; text-align: center;'>";                                         
                  $confirmar1 .="<button class='botao3d_menu_vert'  style='text-align:center; cursor: pointer;'  " 
                               ." onclick='javascript: limpar_form();' >Ok";                                  
                  $confirmar1 .="</button></div>";                  
            }
            ////                                       
           echo $confirmar1."</div>";               
     } else {
            ///  Precisa da variavel navegador - que indentifica
            echo $funcoes->mostra_msg_erro("Faltando a variavel navegador.");
     }    
     ///
}
//
ob_end_flush(); 
#
?>