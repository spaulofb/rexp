<?php
//  AJAX da opcao CONSULTAR 
///  - Servidor PHP para mostrar ANOTACOES do PROJETO
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
///  Par?metros de controle para esse processo:
if( isset($_POST['cip']) ) $cip = $_POST['cip'];
if( isset($_SESSION["usuario_conectado"]) ) $anotador = $_SESSION["usuario_conectado"];
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado = $_SESSION["usuario_conectado"];
if( isset($_POST['grupoanot']) ) $opcao = $_POST['grupoanot'];
if( isset($_POST['op_selcpoid']) ) $op_selcpoid = $_POST['op_selcpoid'];
if( isset($_POST['op_selcpoval']) ) $op_selcpoval = $_POST['op_selcpoval'];
//
$elemento=5; $elemento2=6;
///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"]; 
////
///  INCLUINDO CLASS - 
///  require_once('../includes/autoload_class.php');  
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
// $funcoes->usuario_pa_nome();
// $_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
//
$opcao_maiusc =strtoupper(trim($opcao)); 
///  Arquivo da tabela de consulta projeto - importante
$arq_tab_consulta_anotacao="{$incluir_arq}includes/tabela_consulta_anotacao.php";
///
///  UPLOAD -  do Servidor para maquina local
if( $opcao_maiusc=="DESCARREGAR" )  {
    /// Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
    set_time_limit(0);
    $post_array = array("grupoanot","val","m_array");
    for( $i=0; $i<count($post_array); $i++ ) {
        $xyz = $post_array[$i];
        //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
        $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
        if ( isset($_POST[$xyz]) ) {
            $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
            if( $pos1 === false ) {
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
    ///  Verificar se variavel m_array definida como ARRAY
    /// $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
    if( ! isset($_SESSION["projeto_autor"]) )   $projeto_autor=""; 
    if( isset($_SESSION["projeto_autor"]) )   $projeto_autor = trim($_SESSION["projeto_autor"]);
    ///
    ///  Verificando Permissao de Acesso do USUARIO
    /* Exemplo do resultado  do  Permissao de Acesso 
          - criando array
          +-------------+--------+
          | descricao   | codigo |
          +-------------+--------+
          | super       |      0 | 
          | chefe       |     10 | 
          | vice        |     15 | 
          | aprovador   |     20 | 
          | orientador  |     30 | 
          | anotador    |     50 | 
          +-------------+--------+
    ****/
    ///  Caso for super,chefe ou vice
    ///
 
    ///  $pasta = "../doctos_img/A".$m_array[0];
    ///  $pasta = "../doctos_img/A".$projeto_autor;
    $pasta = "{$_SESSION["incluir_arq"]}doctos_img/A".$projeto_autor;
    $pasta .= "/".$m_array[1]."/";     
    ///  $output = shell_exec('for arq in `ls '.$pasta.'/*.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done');    
    ///  Definindo http ou https
    ///  Definindo http ou https - IMPORTANTE
    ///  Verificando protocolo do Site  http ou https   
    $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
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
    /// Arquivo da Anotacao do Projeto - 20180913
    $val = utf8_decode(trim($val)); 
    $arquivo = trim($val);
   ///  $arquivo = trim($arq_anotacao);
    
////  $dir_arq=utf8_decode("{$pasta}$arquivo"); 
    $dir_arq="{$pasta}{$arquivo}";
    ///  $dir_arq=utf8_decode("{$pasta}$arquivo");
    
    ///  Funcionando 100%    
    ///  $resultado=@file_exists("{$pasta}".preg_replace('\\','',$arquivo));
    ////  $resultado=@file_exists(utf8_decode("{$pasta}$arquivo"));
    $resultado=file_exists("$dir_arq");
    if( ! $resultado ) {
         /* $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
         echo $msg_erro;  
         */
          echo  $funcoes->mostra_msg_erro("&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor");         
    }  else {
        ///  SESSIONs para diretorio e arquivo - Anotacao do Projeto
        ///  echo $pasta."%".$arquivo;  
        $_SESSION["arquivo_anotacao"]=utf8_encode($arquivo);
        $_SESSION["pasta_arq_anotacao"]=$pasta;
        ////  echo $pasta."%#sepa%#rar%#{$arquivo}"; 
        echo  "{$_SESSION["pasta_arq_anotacao"]}%#sepa%#rar%#{$_SESSION["arquivo_anotacao"]}"; 
        ///
    } 
    exit();     
}
/*******  Final -  UPLOAD -  do Servidor para maquina local  *******/
///
///  Botao Busca Projeto
if( $opcao_maiusc=="BUSCA_PROJ" )  {
     ///  Verifica se existe ANOTACOES para o PROJETO escolhido
      $sqlcmd = "SELECT sum(anotacao) as nanotacoes FROM  $bd_2.projeto  "
                 ." WHERE cip=$val  ";
      ///           
      $result_consult_anotacao = mysql_query($sqlcmd);
      if( ! $result_consult_anotacao ) {
            echo $funcoes->mostra_msg_erro("Selecionando ".utf8_decode("Anotação")." na tabela  -&nbsp;db/mysql:&nbsp;".mysql_error());            
            exit();        
      } 
      $nanotacoes=mysql_result($result_consult_anotacao,0,0);     
      if( intval($nanotacoes)<1 ) {
            echo $funcoes->mostra_msg_erro("Nenhuma ".utf8_decode("Anotação")." desse Projeto.");            
            exit();        
      } 
      ///
}
//
//  Mostrar todas as anotacoes de um Projeto
///  if( $opcao_maiusc=="TODOS" )  {
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
     $table_consultar_anotacao = $_SESSION["table_consultar_anotacao"] = "$bd_2.temp_consultar_anotacao";
     $sql_temp = "DROP TABLE IF EXISTS  $table_consultar_anotacao  ";  
     $drop_result = mysql_query($sql_temp); 
     if( ! $drop_result  ) {
         ///  NAO USAR DIE  TEM  FALHA
         ///  die('ERRO: Falha consultando a tabela '.$_SESSION["table_consultar_anotacao"].' - '.mysql_error());         
         /* $msg_erro .= "Consultando a tabela ".$_SESSION["table_consultar_anotacao"]." - Falha: ".mysql_error().$msg_final;
            echo $msg_erro; */
         echo $funcoes->mostra_msg_erro("Removendo a Tabela {$_SESSION["table_consultar_anotacao"]} -&nbsp;db/mysql:&nbsp;".mysql_error());            
         exit();        
     }
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
          } else {
              echo $funcoes->mostra_msg_erro(utf8_decode("Variável val não definida. Corrigir."));
              exit();        
          }
     }
     //// 
     ////  Selecionar os usuarios de acordo com o opcao - Criando Tabela Temporaria
     /***
        $sqlcmd ="CREATE TABLE  IF NOT EXISTS ".$_SESSION["table_consultar_anotacao"]."   ";
        $sqlcmd .= "SELECT a.numero as nr, a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as titulo, b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data, "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." a.relatext as Arquivo, c.autor as projeto_autor FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
         ***/        
     /// Contador de linhas - resultado do Select/Mysql
     mysql_query("SET @xnr:=0");
     $sqlcmd ="CREATE TABLE  IF NOT EXISTS  $table_consultar_anotacao  ";
     /******
        $sqlcmd .= "SELECT @xnr:=@xnr+1 as nr,  a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as titulo, b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data, "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." a.relatext as Arquivo, c.autor as projeto_autor FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
         ***/                   
     $sqlcmd .= "SELECT @xnr:=@xnr+1 as nr, a.numero as na, a.titulo as titulo, "
                 ." b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data, "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." a.relatext as Arquivo, c.autor as projeto_autor "
                 ." FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
     ///                  
     /***
        *      Alterado em 20180607
        *      Super, Chefe e Vice     
     ***/
     if( $_SESSION["permit_pa"]<$array_pa['aprovador'] )  {
           $where_cond = "  a.projeto=$cip   ";    
     } elseif( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
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
     ///  Executando procedimento
     $result_consult_anotacao = mysql_query($sqlcmd);
     if( ! $result_consult_anotacao ) {
          /*  $msg_erro .= "Criando a Tabela {$_SESSION["table_consultar_anotacao"]}  - Falha: ".mysql_error().$msg_final;
               echo $msg_erro; */
           echo $funcoes->mostra_msg_erro("Criando a tabela {$_SESSION["table_consultar_anotacao"]} -&nbsp;db/mysql:&nbsp;".mysql_error());            
           exit();        
     } 
     ////  Selecionando todos os registros da Tabela temporaria de consulta Anotacoes
     $table_consultar_anotacao = $_SESSION["table_consultar_anotacao"];
     $query2 = "SELECT * FROM $table_consultar_anotacao  ";
     ///
     $resultado_outro = mysql_query($query2);                                    
     if( ! $resultado_outro ) {
          /* $msg_erro .= "Selecionando as Anota&ccedil;&otilde;es do Projeto  - Falha: ".mysql_error().$msg_final;
             echo $msg_erro;    */     
          echo $funcoes->mostra_msg_erro("Selecionando as Anota&ccedil;&otilde;es do Projeto -&nbsp;db/mysql:&nbsp;".mysql_error());
          exit();
     }         
     ////  Total de registros
     $_SESSION["total_regs"] = $total_regs = mysql_num_rows($resultado_outro);
     if( intval($total_regs)<1 ) {
          /*  $msg_erro .= "&nbsp;Nenhuma Anota&ccedil;&atilde;o para esse Projeto.".$msg_final;
            echo $msg_erro; */
           echo $funcoes->mostra_msg_erro("Nenhuma Anota&ccedil;&atilde;o para esse Projeto.");
           exit();
     } 
     ////  Pegando os nomes dos campos do primeiro Select
     $num_fields=mysql_num_fields($resultado_outro);  ///  Obtem o numero de campos do resultado
     $td_menu = $num_fields+1;   
     $projeto_titulo = mysql_result($resultado_outro,0,"projeto_titulo");
     $projeto_autor = mysql_result($resultado_outro,0,"projeto_autor");
     $_SESSION["projeto_autor"] = $projeto_autor; 
     ////  Total de registros
     $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> Anota&ccedil;&atilde;o " : $lista_usuario="<b>".$_SESSION['total_regs']."</b> Anota&ccedil;&otilde;es ";     
     ///  $_SESSION["titulo"]= "<p  class='titulo_consulta'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; '  >";
     $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal; '  >";
     $_SESSION["titulo"].= "Lista de $lista_usuario ".$_SESSION['selecionados']."</p>"; 
     ///  Buscando a pagina para listar os registros        
     $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
     if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag;
     $_SESSION["pagina"]=0;
     $_SESSION["m_function"]="remove_anotacao" ;  $_SESSION["conjunto"]="Anotacao#@=".$usuario_conectado."#@=".$cip;
     $_SESSION["opcoes_lista"] = "{$arq_tab_consulta_anotacao}?pagina=";
     require_once("{$arq_tab_consulta_anotacao}");                      
     /*
         $msg_erro .= " srv_mostraanot.php/122 -  \$resultado_outro = $resultado_outro ";
        echo  $msg_erro;
        ***/
     exit();     
     ///
} elseif( $opcao_maiusc=="DETALHES" )  {
    ///  ANOTACAO A VARIAVEL val = array para Projeto e Anotacao
    if( strpos($val,"#")!==false ) $array_proj_anot = explode("#",$val);
    if( isset($array_proj_anot) ) {
          $cip=$array_proj_anot[0];
         $anotacao=$array_proj_anot[1];        
    } else {
         echo $funcoes->mostra_msg_erro(utf8_decode("Array: array_proj_anot não definido."));            
         exit();
    }
    ///  Selecionando Projeto
     $sqlcmd  = "SELECT a.numprojeto, a.titulo as  titulo_projeto, b.nome as autor_projeto,  "
           ." concat(substr(a.datainicio,9,2),'/',substr(a.datainicio,6,2),'/',substr(a.datainicio,1,4)) as data_projeto "
              ." FROM $bd_2.projeto a, $bd_1.pessoa b WHERE a.cip=$cip and a.autor=b.codigousp  ";
     ///
     $resultado_projeto = mysql_query($sqlcmd);
     if( ! $resultado_projeto ) {
         /// die("ERRO: Selecionando Projeto: cip = ".$cip." - ".mysql_error());  
         /* $msg_erro .= "Selecionando Tabela projeto  - db/mysql:&nbsp; ".mysql_error().$msg_final;
             echo $msg_erro; */
         echo $funcoes->mostra_msg_erro("Selecionando Tabela projeto  -&nbsp;db/mysql:&nbsp;".mysql_error());
         exit();
     }         
     ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     $array_nome=mysql_fetch_array($resultado_projeto);
     ///  Validando as variaveis enviandos pelos campos do SELECT/MySql
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     if( isset($resultado_projeto) ) mysql_free_result($resultado_projeto);     
     /*    
      a.numero as nr, a.alteraant as Altera, alteradapn as Alterada, "
                 ." a.titulo as T?tulo, b.nome as Autor, c.titulo as projeto_titulo,  "
                 ." concat($cip,'#',a.numero) as Detalhes, "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as Data, "
                 ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b, $bd_2.projeto c "
                 ." WHERE a.autor=b.codigousp and  c.cip=$cip and ";
         
     CAMPOS ABAIXO DO PROJETO: 
    $campos = "&nbsp; srv_mostraanot.php/192 -   \$numprojeto = $numprojeto -- \$titulo_projeto  = $titulo_projeto <br> ";
    $campos .= "\$autor_projeto =  $autor_projeto - \$data_projeto = $data_projeto  -- \$anotacao = $anotacao ";       
        //
         
        */
     ///  Selecionando a ANOTACAO do Projeto        
     $sqlcmd = "SELECT a.numero as numero_anotacao, a.alteraant as altera, a.alteradapn as alterada,"
                ." a.titulo as titulo_anotacao, a.testemunha1, a.testemunha2, b.nome as autor_anotacao,"
                ."concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anotacao,"
                ." a.relatext as Arquivo FROM $bd_2.anotacao a, $bd_1.pessoa b "
                ." WHERE a.autor=b.codigousp and a.projeto=$cip and a.numero=$anotacao  ";                
     ///            
     $resultado_anotacao = mysql_query($sqlcmd);
     if( ! $resultado_anotacao ) {
          /* $msg_erro .= "Selecionando Anota&ccedil;&atilde;o $anotacao do  Projeto: ".$numprojeto." - ".mysql_error().$msg_final;  
          echo $msg_erro;  */
          echo $funcoes->mostra_msg_erro("Selecionando Anota&ccedil;&atilde;o $anotacao do Projeto: $numprojeto -&nbsp;db/mysql:&nbsp;".mysql_error());            
          exit();
     } 
     ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     if( isset($array_nome) ) unset($array_nome);
     $array_nome=mysql_fetch_array($resultado_anotacao);
     foreach( $array_nome as $key => $value ) {
              $$key=$value;
     }             
     //// Desativando variavel
     if( isset($resultado_anotacao) ) mysql_free_result($resultado_anotacao);   
     ////  Selecionando os Nomes das Testemunhas da ANOTACAO
     if( strlen(trim($testemunha1))>=1 or strlen(trim($testemunha2))>=1  ) {
         if( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))>=1 ) {
               $in=" in($testemunha1,$testemunha2)";
         } elseif( strlen(trim($testemunha1))>=1 and strlen(trim($testemunha2))<1 ) {
               $in=" in($testemunha1)";
         } elseif( strlen(trim($testemunha1))<1 and strlen(trim($testemunha2))>=1 ) {
               $in=" in($testemunha2)";
         } 
         //  Selecionando as Testemunhas da Anotacao          
         $cmd_sql = "SELECT codigousp as cod_testemunha, nome as nome_testemunha  FROM  $bd_1.pessoa where codigousp $in ";
         $res_testemunhas = mysql_query($cmd_sql);
         if( ! $res_testemunhas ) {
             /* $msg_erro .= "Selecionando testesmunhas da  Anota&ccedil;&atilde;o. mysql = ".mysql_error().$msg_final;  
             echo $msg_erro;  */
             echo $funcoes->mostra_msg_erro("Selecionando testesmunhas da Anota&ccedil;&atilde;o -&nbsp;db/mysql:&nbsp;".mysql_error());
             exit();
         }        
         $testemunhas="";
         /////  Numero de registros
         $num_regs = mysql_num_rows($res_testemunhas); 
         for( $ntest=0 ; $ntest<$num_regs ; $ntest++ ) {
              $nome_testemunha[$ntest]= mysql_result($res_testemunhas,$ntest,"nome_testemunha");
              $x_testemunha = (int) $ntest+1;
              $testemunhas .="<p class='testemunhas' >"
                    ."<b>Testemunha$x_testemunha</b>:&nbsp;".$nome_testemunha[$ntest]."</p>";
              ///                    
         }
     }
     ////   Projeto e Anotacao
     $confirmar0 ="<div class='confirmar0' >";
     $confirmar0 .="<p class='autorprojeto' >"
                     ."<b>Anota&ccedil;&atilde;o $numero_anotacao do Projeto $numprojeto </b><br>"
                     ."<b>Autor do Projeto</b>: $autor_projeto<br/>";
     ///
     $confirmar0 .="<br/><b>T&iacute;tulo do Projeto</b>:";
     $confirmar0 .="<br>"."$titulo_projeto</p>";
     ///
     $confirmar0 .="<p class='dtiniproj' >"
                    ."<b>Data in&iacute;cio do Projeto</b>:&nbsp;$data_projeto </p>";
     ///               
     /// Anotacao do Projeto                    
     $confirmar0 .="<p class='anotacaon' >"
                 ."<b>Anota&ccedil;&atilde;o</b>: $numero_anotacao<br>"
                 ."<b>Anotador</b>: $autor_anotacao  </p>";
     ///            
     $confirmar0 .="<p  class='titanotacao' >"
                 ."<b>T&iacute;tulo da Anota&ccedil;&atilde;o</b>:<br>"                
                 ."$titulo_anotacao</p>";  
     ///                                               
     $confirmar0 .="<p class='dtanotacao' >"
                    ."<b>Data da Anota&ccedil;&atilde;o</b>:&nbsp;$data_anotacao </p>";
     $confirmar0 .="<p class='arqanotacao' >"
                    ."<b>Arquivo da Anota&ccedil;&atilde;o</b>:&nbsp;$Arquivo</p>";  
     ///               
     $confirmar0 .= $testemunhas;                    
     /*
     $confirmar1 =$confirmar0."<div style='width: 100%; text-align: center;'>";                                         
     $confirmar1 .="<button  class='botao3d_menu_vert' style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: limpar_form();' >Ok";                                  
     $confirmar1 .="</button></div>";  
     */
     ///  Verifica qual é o navegador
     if( isset($navegador) ) {
            $confirmar1 =$confirmar0;
            if( strtoupper($navegador)!="CHROME" ) {
                $confirmar1 .="<div style='width: 100%; text-align: center;'>";
                $confirmar1 .="<button class='botao3d_menu_vert'  style='text-align:center; cursor: pointer;'  onclick='javascript: limpar_form();' >Ok";
                $confirmar1 .="</button></div>";                  
            }
            ////                                       
           echo $confirmar1."</div>";               
     } else {
            ///  Precisa da variavel navegador - que indentifica
            echo $funcoes->mostra_msg_erro("Faltando a variavel navegador.");
     }    
     ///
     ///  echo $confirmar1;               
}
#
ob_end_flush(); 
#
?>