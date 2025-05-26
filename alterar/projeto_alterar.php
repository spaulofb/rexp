<?php 
/*   REXP - ALTERAR PROJETO
*   
*   REQUISITO: O Usuário deve ter PA>0 e PA<=30
* 
*   SPFB&LAFB110908.0959
*/
//  ==============================================================================================
//  PROJETO ALTERAR
//  ==============================================================================================

///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

// include('inicia_conexao.php');
extract($_POST, EXTR_OVERWRITE); 

///  Verificando SESSION incluir_arq - 20180618
$n_erro=0; $incluir_arq="";
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
    ///  echo $msg_erro;
    ///  exit();
    $n_erro=1;
} else {
    $incluir_arq=trim($_SESSION["incluir_arq"]);    
}
if( strlen($incluir_arq)<1 ) $n_erro=1;
///
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
     $msg_erro .= "Erro ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
/***
*     Caso NAO houve ERRO  
*      INICIANDO CONEXAO - PRINCIPAL
***/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");

///  Variavel recebida do script/arquivo - inicia_conexao.php 
$_SESSION["m_horiz"] = $array_projeto;
///
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
/// $_SESSION['time_exec']=180000;
/*  UPLOAD: FILEFRAME section of the script
      verifica se o arquivo foi enviado      */
//  $_SESSION["display_arq"]='none';
$_SESSION["display_arq"]='none';
$_SESSION["div_form"]="block";
$_SESSION["result"]=''; 
$_SESSION["msg_upload"]="";
///
/// Mensagens
include_once("{$_SESSION["incluir_arq"]}mensagens.php");
///
//  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
/*
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$usuario_pa_nome=$funcoes->usuario_pa_nome;
*/ 
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
///
if( ! isset($_SESSION["relatproj_orig"]) ) $_SESSION["relatproj_orig"]="";
//  fileframe - tag iframe  type hidden
if( isset($_POST['fileframe']) ) {
   /* 
   $_SESSION["div_form"]="none";
   $_SESSION["msg_upload"] .= $msg_erro."PASSOU POR AQUI - 1 - {$_SESSION["relatproj_orig"]} - 2 - {$_FILES['relatproj']['tmp_name']} ";
   $_SESSION["msg_upload"] .=$msg_erro_final;                  
   break;
   */
   include("{$_SESSION["incluir_arq"]}includes/functions.php");
   ///  NOME TEMPORARIO NO SERVIDOR
   if( isset($_FILES['relatproj']['tmp_name']) ) {
          $_SESSION["result"]='OK'; 
          $erros="";
          $_SESSION["display_arq"]='block';
          /**   Conjunto de arquivos - ver tamanho total dos arquivos   ***/
          $tam_total_arqs=0; $files_array= array(); 
          $conta_arquivos = count($_FILES['relatproj']['tmp_name']);    
          ///  Verificando se existe diretorio
          $msg_erro =  "<p "
                   ." style='text-align: center; font-size: small; font-family: Verdana, Arial, Helvetica, sans-serif, Times, Georgia; font-weight:bolder;' >";
          $msg_erro_final = "</p>";
          ///  Verifica se houve Falha/Erro
          if( intval($conta_arquivos)<1 ) {
               $_SESSION["msg_upload"] = $msg_erro."ERRO: Falta INDICAR o arquivo.".$msg_erro_final;
               $_SESSION["result"]='FALSE'; 
               $erros="ERRO";
          }
          ///    Esse For abaixo para acrescentar diretorios caso nao tenha  --- 20180921
          ///  if ( $tamanho_dir[0]<1  or  !file_exists($_SESSION["dir"]) ) {  ///  Tem que ser maior que 8 bytes
          for( $n=1; $n<3 ; $n++ ) {
               ///  if( $n==1 )    $_SESSION["dir"] = "/var/www/html/rexp3/doctos_img/A".$_POST["autor_cod"];
               if( intval($n)==1 ) $_SESSION["dir"] ="{$_SESSION["incluir_arq"]}doctos_img/A".$_POST["autor_cod"];
               if( intval($n)==2 ) $_SESSION["dir"] .= "/projeto/";       
               if(  !file_exists($_SESSION["dir"]) ) {  ///  Verificando dir e sub-dir
                    $r = mkdir($_SESSION["dir"],0755);
                    if( $r===false ) {
                         ///  echo  $msg_erro;
                         $_SESSION["msg_upload"] = $msg_erro."Erro ao tentar criar diret&oacute;rio".$msg_erro_final;
                         ///  die("Erro ao tentar criar diret&oacute;rio");
                         $_SESSION["result"]='FALSE';  $erros='ERRO';
                    } else {
                         chmod($_SESSION["dir"],0755);                                                   
                    }
               }
          }   
          ///
          /// tamanho em bytes do diretorio
          $tamanho_dir = shell_exec("/usr/bin/du  ".$_SESSION["dir"]);  
          $tamanho_dir = explode("/",$tamanho_dir);
          if( intval($conta_arquivos)>1 ) {
              for($i=0; $i < $conta_arquivos  ;$i++) $tam_total_arqs += $_FILES["relatproj"]["size"][$i];   
          } else {
              $tam_total_arqs = $_FILES["relatproj"]["size"];   
          }
          ///
          $total_dir_arq = $tamanho_dir[0]+$tam_total_arqs;
          /***   o tamanho maximo no arquivo configurado no  php.ini 
                $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
                 $upload_max = ($ini_max * 1024)*1000000;
          
              an array to hold messages
               $messages=array(); 
          */
          $files_size= array(); $files_date= array();    
         /*** check if a file has been submitted ***/  
          if( $_SESSION["result"]=='OK' )  {
               /***  tamanho maximo do arquivo admitido em bytes   ***/
               $max_file_size = 524288000; /// bytes - B
               $espaco_em_disco = $max_file_size-$tamanho_dir[0];
               if( intval($espaco_em_disco)<1024 ) $tipo_tamanho = "bytes";
               if( intval($espaco_em_disco)>1024 and  intval($espaco_em_disco)<1024000 ) {
                    $tipo_tamanho = "KB"; $espaco_em_disco= intval($espaco_em_disco/1024);
               } else if( intval($espaco_em_disco)>=1024000 ) {
                    $tipo_tamanho = "MB"; $espaco_em_disco= intval($espaco_em_disco/1024000);
               }
               ///
              if( intval($total_dir_arq)>intval($max_file_size) ) {
                  $erros='ERRO';
                  $result_msg= "N&atilde;o tem espa&ccedil;o no disco para esse arquivo. Cancelado\\n";
                  $result_msg .= " espa&ccedil;o disponvel no disco  de ".$espaco_em_disco." $tipo_tamanho\\n";
                  $_SESSION["msg_upload"] = $msg_erro.$result_msg.$msg_erro_final;
              } 
              /**  loop atraves do conjunto de arquivos  ***/
              ///  verifica se o arquivo esta no conjunto (array)
              if( !is_uploaded_file($_FILES["relatproj"]['tmp_name']) ) {
                    /// $messages[]="Arquivo n&atilde;o armazenado\n"; 
                    $_SESSION["msg_upload"] = $msg_erro."Arquivo n&atilde;o armazenado\n".$msg_erro_final;
                    ///  $erros[]='ERRO';
                    $_SESSION["erros"] = $erros='ERRO';
              } elseif( $_FILES["relatproj"]['tmp_name'] > $max_file_size )  {
                    /// verifica se o arquivo menor que o tamanho maximo permitido
                    $_SESSION["msg_upload"]= $msg_erro."O arquivo excedeu o tamanho limite permitido $max_file_size $tipo_tamanho ";
                    $_SESSION["msg_upload"].=$msg_erro_final;
                    $_SESSION["erros"] = $erros = 'ERRO';
               } else {
                   ///  OCORREU  ERRO NESSA JANELA DO JAVASCRIPT
                   ///  OCORREU  echo "<p style='text-align: center;'>Aguarde um momento.</p>";
                   ///  REMOVENDO O ARQUIVO ANTERIOR CASO EXISTA  --- 20180614
                   if( isset($_SESSION["relatproj_orig"]) ) {
                      if( strlen(trim($_SESSION["relatproj_orig"]))>2 ) {
                           $dir_relatproj_orig = "{$_SESSION["dir"]}{$_SESSION["relatproj_orig"]}";
                           ///                 
                           if( file_exists(utf8_decode("$dir_relatproj_orig")) ) {
                               ///  Removendo o arquivo anterior  do Projeto
                               ///  unlink("$dir_relatproj_orig");
                               unlink(utf8_decode("$dir_relatproj_orig")); 
                           }
                      }
                   }           
                   ///
                   /// COPIA o arquivo para o diretorio especificado
                   $filename="P".$_POST["nprojexp"]."_".utf8_decode($_FILES["relatproj"]["name"]);
                   if( @copy($_FILES["relatproj"]['tmp_name'],$_SESSION["dir"].$filename) )  {
                         /*** give praise and thanks to the php gods ***/
                         $erros='';
                         $_SESSION["msg_upload"]= $msg_erro."Arquivo: ".$_FILES["relatproj"]["name"].' foi armazenado&nbsp;';
                          $_SESSION["msg_upload"].=$msg_erro_final;
                         $files_array[]=$_FILES["relatproj"]["name"];
                         $files_size[]=$_FILES["relatproj"]["size"];
                         //  filemtime ? Obt?m o tempo de modifica??o do arquivo
                         $files_date[] = date('d/m/Y H:i:s', filemtime($_SESSION["dir"].$filename));
                         $files_type[] = mime_type($filename);
                        /// Permissao do arquivo
                        chmod($_SESSION["dir"].$filename,0755);                                    
                   } else {
                        /***  an error message  ***/
                        $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES["relatproj"]["name"].' FALHA';
                        $_SESSION["msg_upload"].=$msg_erro_final;
                        $_SESSION["erros"] = $erros = 'ERRO';
                   }
               }
          } 
          ///  FINAL - IF  \$_SESSION["result"]
          ///
          $_SESSION["erros"] = trim($erros);
          ///   Alterando o nome do arquivo na tabela  projeto
          if( trim($erros)=='' ) {
              /// extract: Importa variaveis para a tabela de simbolos a partir de um array 
              extract($_POST, EXTR_OVERWRITE);  
              ///   
              $elemento=5; $elemento2=6;  
              include("php_include/ajax/includes/conectar.php");
              $db_select = mysql_select_db($db_array[$elemento],$lnkcon);
              ///  $local_arq0 = $_SESSION["dir"].$filename;
              $nprojexp = $_POST["nprojexp"]; 
              $autor_cod = $_POST["autor_cod"];
              /***  
                 *     IMPORTANTE: alterado em 20180727
                 *         toda parte de acentuacao PHP?MYSQL
                 *      mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - 
                         Use mysql_select_db() ou mysql_query()
              ***/   
              ini_set('default_charset','utf8');
              /***
                    *    O charset UTF-8  uma recomendacao, 
                    *    pois cobre quase todos os caracteres e 
                    *    símbolos do mundo
              ***/
              mysql_query("SET NAMES 'utf8'"); 
              mysql_query('SET character_set_connection=utf8'); 
              mysql_query('SET character_set_client=utf8'); 
              mysql_query('SET character_set_results=utf8'); 
              mysql_set_charset('utf8');
                  
              ///  $local_arq = utf8_decode($local_arq); 
              ///  $local_arq  = html_entity_decode(trim($filename));
              $local_arq = utf8_encode($filename); 

              /****  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao 
              *          - Use mysql_select_db() ou mysql_query()
              ***/
              ///  Recebendo as sessoes enviadas do arquivo projeto_alterar_ajax.php
              $cip=""; $autor_cod="";$nprojexp="";
              if( isset($_SESSION["cip"]) ) {
                  $cip=$_SESSION["cip"];
              }
              ///
              ///  Selecionar os Projetos de acordo com o op??o
              $sqlcmd = "SELECT numprojeto as nprojexp,autor as autor_cod "
                      ."  FROM $bd_2.projeto  WHERE cip=$cip ";
              ///
              $result_consult_projeto = mysql_query($sqlcmd);
              /***
              if( ! $result_consult_projeto ) {
                   $msg_erro .= "Falha consultando a tabela anota&ccedil;&atilde;o  - op&ccedil;&atilde;o=".$opcao.' - '.mysql_error().$msg_final;  
                   echo $msg_erro;                
                   exit();
              }
              ***/
              ///
              if( ! $result_consult_projeto ) {
                    $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES["relatproj"]["name"].' FALHA: ';
                    $_SESSION["msg_upload"].=mysql_error().$msg_erro_final;
              } else {
                  ///
                  $n_regs=mysql_num_rows($result_consult_projeto);
                  /// Caso encontador o Projeto
                  if( $n_regs==1 ) {
                      ///  Definindo os nomes dos campos recebidos do MYSQL SELECT
                      if( isset($array_nome) ) unset($array_nome);
                      $array_nome=mysql_fetch_array($result_consult_projeto);
                      foreach( $array_nome as $chave_cpo => $valor_cpo ) {
                                $$chave_cpo=$valor_cpo;
                      }
                  }
                  //// 
                  ///  Verificando a variavel cip - Codigo da Informacao do Projeto
                  if( strlen(trim($cip))>0 ) {
                        ///  START a transaction - ex. procedure  
                        $n_erro=0;  
                        mysql_query('DELIMITER &&'); 
                        mysql_query('begin'); 
                        mysql_query("LOCK TABLES $bd_2.projeto UPDATE ");
                        //// $success = mysql_query("UPDATE $bd_2.projeto SET relatproj='$local_arq'  WHERE numprojeto=$nprojexp and autor=$autor_cod  ");
                        $success = mysql_query("UPDATE $bd_2.projeto SET relatproj='$local_arq' 
                                          WHERE cip=$cip ");
                        ///
                        if( ! $success ) {
                              ///  Ocorreu ERRO
                             $n_erro=1;  
                             $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES["relatproj"]["name"].' FALHA'.mysql_error();
                             $_SESSION["msg_upload"].=$msg_erro_final;
                             mysql_query('rollback'); 
                        } else {
                             mysql_query('commit'); 
                        }
                        mysql_query("UNLOCK  TABLES");
                        mysql_query('end'); 
                        mysql_query('DELIMITER');
                        ///
                        /// Caso NAO Ocorreu erro
                        if( intval($n_erro)<1 ) {
                             /// Select/Mysql -  nome do usuario/autor
                             ///   Utilizado pelo Mysql/PHP        
                             mysql_query("SET NAMES 'utf8'");
                             mysql_query('SET character_set_connection=utf8');
                             mysql_query('SET character_set_client=utf8');
                             mysql_query('SET character_set_results=utf8');
                             ///                         
                             $success=mysql_query("SELECT nome from $bd_1.pessoa WHERE codigousp=$autor_cod  ");
                             /// Verificando se houve erro no Select Tabela pessoa
                             if( ! $success ) {
                                  /*  $msg_erro .= "Select tabela objetivo - falha: ".mysql_error().$msg_final;
                                      echo $msg_erro;  */
                                  echo $funcoes->mostra_msg_erro("Select tabela pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());
                             } else {
                                 ///  Variavel autor_nome com o nome do usuario/autor
                                 $autor_nome= trim(mysql_result($success,0,0)); 
                                 $_SESSION["msg_upload"] .= $msg_erro."Projeto $nprojexp do autor $autor_nome foi alterado.";
                                 $_SESSION["msg_upload"] .= $msg_erro_final;                           
                             } 
                        }
                        ////
                  } else {
                       $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES["relatproj"]["name"].' FALHA. Contado Administrador';
                       $_SESSION["msg_upload"].=$msg_erro_final;                  
                  }
                  ///
              }      
              ///              
          }  
   } else {
        /// Ocorreu erro 
        $_SESSION["msg_upload"] .= $msg_erro."Nenhum arquivo Selecionado";
        $_SESSION["msg_upload"] .= $msg_erro_final;                  
   }
} 
///  FINAL do IF UPLOAD  
///
?>
<!DOCTYPE html >
<html lang="pt-br" >
<head>
<meta charset="UTF-8" />
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Alterar Projeto</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/functions.js" charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<!-- <script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script> -->
<script  language="javascript"  type="text/javascript" >
///
///   JavaScript Document - para Alterar Projeto selecionado
///
/****  
    Define o caminho HTTP  -  20180416
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
charset="utf-8";
///
///
///  variavel quando ocorrer Erros ou apenas enviar mensagem
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
/******  Final -  variavel quando ocorrer Erros ou apenas enviar mensagem  ****/
///
///   funcrion acentuarAlerts - para corrigir acentuacao
///  Criando a function  acentuarAlerts(mensagem)
function acentuarAlerts(mensagem) {
    ///  Paulo Tolentino
    ///  Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));
    ///
    mensagem = mensagem.replace('á', '\u00e1');
    mensagem = mensagem.replace('à', '\u00e0');
    mensagem = mensagem.replace('â', '\u00e2');
    mensagem = mensagem.replace('ã', '\u00e3');
    mensagem = mensagem.replace('ä', '\u00e4');
    mensagem = mensagem.replace('Á', '\u00c1');
    mensagem = mensagem.replace('À', '\u00c0');
    mensagem = mensagem.replace('Â', '\u00c2');
    mensagem = mensagem.replace('Ã', '\u00c3');
    mensagem = mensagem.replace('Ä', '\u00c4');
    mensagem = mensagem.replace('é', '\u00e9');
    mensagem = mensagem.replace('è', '\u00e8');
    mensagem = mensagem.replace('ê', '\u00ea');
    mensagem = mensagem.replace('ê', '\u00ea');
    mensagem = mensagem.replace('É', '\u00c9');
    mensagem = mensagem.replace('È', '\u00c8');
    mensagem = mensagem.replace('Ê', '\u00ca');
    mensagem = mensagem.replace('Ë', '\u00cb');
    mensagem = mensagem.replace('í', '\u00ed');
    mensagem = mensagem.replace('ì', '\u00ec');
    mensagem = mensagem.replace('î', '\u00ee');
    mensagem = mensagem.replace('ï', '\u00ef');
    mensagem = mensagem.replace('Í', '\u00cd');
    mensagem = mensagem.replace('Ì', '\u00cc');
    mensagem = mensagem.replace('Î', '\u00ce');
    mensagem = mensagem.replace('Ï', '\u00cf');
    mensagem = mensagem.replace('ó', '\u00f3');
    mensagem = mensagem.replace('ò', '\u00f2');
    mensagem = mensagem.replace('ô', '\u00f4');
    mensagem = mensagem.replace('õ', '\u00f5');
    mensagem = mensagem.replace('ö', '\u00f6');
    mensagem = mensagem.replace('Ó', '\u00d3');
    mensagem = mensagem.replace('Ò', '\u00d2');
    mensagem = mensagem.replace('Ô', '\u00d4');
    mensagem = mensagem.replace('Õ', '\u00d5');
    mensagem = mensagem.replace('Ö', '\u00d6');
    mensagem = mensagem.replace('ú', '\u00fa');
    mensagem = mensagem.replace('ù', '\u00f9');
    mensagem = mensagem.replace('û', '\u00fb');
    mensagem = mensagem.replace('ü', '\u00fc');
    mensagem = mensagem.replace('Ú', '\u00da');
    mensagem = mensagem.replace('Ù', '\u00d9');
    mensagem = mensagem.replace('Û', '\u00db');
    mensagem = mensagem.replace('ç', '\u00e7');
    mensagem = mensagem.replace('Ç', '\u00c7');
    mensagem = mensagem.replace('ñ', '\u00f1');
    mensagem = mensagem.replace('Ñ', '\u00d1');
    mensagem = mensagem.replace('&', '\u0026');
    mensagem = mensagem.replace('\'', '\u0027');
    ///
    return mensagem;
    ///
}
/********  Final  -- function acentuarAlerts(mensagem)   **********/
///
/****   Cadastro de PROJETO   ****/
function altera_projeto(source,val,string_array) {
     ///
    /// Verificando se a function exoc existe 
    if(typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
    
    ///  Verificando variaveis recebidas
    if( typeof(source)=="undefined" ) var source=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";
    if( typeof(val)=="string" ) var val_upper=val.toUpperCase();
    
    /// Verifica se a variavel e uma string
    var source_maiusc=""; var source_array_pra_string="";  
    if( typeof(source)=='string' ) {
        ///  source = trim(string_array);
        ///  string.replace - Melhor forma para eliminiar espa?os no comeco e final da String/Variavel
        source = source.replace(/^\s+|\s+$/g,"");        
        source_maiusc = source.toUpperCase();     
        var pos = source.indexOf(",");     
        if( pos!=-1 ) {  
            ///  Criando um Array 
            var array_source = source.split(",");
            var teste_cadastro = array_source[1];
            var  pos = teste_cadastro.search("incluid");
        }
     }  else if( typeof(source)=='number' && isFinite(source) )  {
          source = source.value;                
     } else if(source instanceof Array) {
          //  esse elemento definido como Array
          var source_array_pra_string=src.join("");
     }
     ///  Variavel com letras maiusculas
     var lcopcao = source.toUpperCase();
    /****  
         Define o caminho HTTP    -  20180612
    ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       

//// alert(" projeto_alterar.php/256 - INICIO - source= "+source+" val= "+val+" string_array="+string_array);

    /// BOTAO - TODOS
    var quantidade= lcopcao.search(/TODOS|TODAS/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("ordenar") ) {
            ///  Incluido em 20180419
           //// var melement=document.getElementById("ordenar");
           var stdis= document.getElementById("ordenar");
           if( stdis.style.display==="none" || stdis.style.display==="" ) {
                document.getElementById("ordenar").style.display="block";
            }             
            document.getElementById("ordenar").selectedIndex="0";            
        } else {
            alert("Faltando document.getElementById(\"ordenar\") ");           
        }
        if( document.getElementById("busca_proj") ) {
             document.getElementById("busca_proj").selectedIndex="0";
        } 
        ///  Desativando ID  div_out
        exoc("div_out",1,"");                   
        ///
        return;
    }
    /// tag Select para Ordenar o Botao Todos - Importante - 20180419
    var quantidade=lcopcao.search(/ORDENAR/i);
    if( quantidade!=-1 ) {
         var tmp=val;
         var val=lcopcao;
         ///  Usado tambem na pagina  consultar/projeto_consultar.php         
         ///  var lcopcao=tmp;  
         var source=tmp;
         ///  var string_array=string_array.replace(" ","");      
         if( document.getElementById("busca_proj") ) {
              document.getElementById("busca_proj").selectedIndex="0";
         }    
         if( document.getElementById("busca_porcpo") ) {
              document.getElementById("busca_porcpo").selectedIndex="0";
         }    
    } 
    ///
    /// tag Select para desativar outros campos
    var quantidade=lcopcao.search(/BUSCA_PROJ/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("busca_porcpo") ) {
              document.getElementById("busca_porcpo").selectedIndex="0";
        }    
    }
    /// tag Select para desativar outros campos
    var quantidade=lcopcao.search(/busca_porcpo/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("busca_proj") ) {
             document.getElementById("busca_proj").selectedIndex="0";
        }    
    }
    /// tag Select para desativar o campo Select ordenar
    var quantidade=lcopcao.search(/BUSCA_PROJ|busca_porcpo/i);
    if( quantidade!=-1 ) {
         ///  Caso val estiver  nula
         if( val.length<1 )  {
             ///  Retornar na pagina - reset 
             location.href=pagina_local;
              return;
         }
        /// 
        if( document.getElementById("ordenar") ) {
             ///  Incluido em 20180419
            var melement=document.getElementById("ordenar");
            if( melement.style.display==="block" || melement.style.display==="" ) {
                 document.getElementById("ordenar").selectedIndex="0";
                 document.getElementById("ordenar").style.display="none";            
            }
        }  
    }
    ///    
    ///  variavel opcao igual a  source maiuscula
    var opcao = source.toUpperCase();
    
    ///  SAIR do programa     
    if( opcao=="SAIR" ) {
        ///   timedClose();
        /*  Navegador/Browser utilizado
           var navegador =navigator.appName;
           var pos = navegador.search(/microsoft/gi);
       */ 
        ///  Sair do Site fechando a Janela
        var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
        var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
        var navegador =navigator.appName;
        var pos = navegador.search(/microsoft/gi);
        ///  if( pos!=-1 ) {
        ///  if( navegador.search(/microsoft/gi)!=-1 ) {        
        if( is_firefox!=-1 ) {
            ///  Sair da pagina e ir para o Site da FMRP/USP
            location.replace('http://www.fmrp.usp.br/');                
            /// window.open('','_parent','');window.close();    
            ///  window.opener=null; 
            ///  window.close();            
        } else if( is_chrome!=-1  || pos!=-1  ) {
            /// ALterado em 20120625 - correto
            ///   window.opener=null; 
            window.open('', '_self', ''); // bug fix
            window.close();                            
        }
        return;     
    }
    /// SWITCH
    switch (opcao) {
        case "APRESENTACAO":        
            //// Caso tenha cancelado a alteracao no Projeto do arquivo PDF
            if( val.toUpperCase()=="VOLTAR" ) {
                 /// RETORNAR A PAGINA ALTERAR PROJETO
                 location.href=pagina_local;
            } else {
                /// top.location.href="../menu.php";
                location.href=raiz_central+"menu.php";
            }
            return;        
            break;    
        case "ORDENAR":            
            var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
            break;    
        case "BUSCA_PROJ":            
            //// Caso tenha cancelado a alteracao no Projeto
            if( val.toUpperCase()=="LIMPAR" ) {
                 /// Ocultando ID label_msg_erro - mensagem de erro
                 exoc("label_msg_erro",0);  
                 ///
                 ///  Voltar para o inicio da Tag Select  id  - selectedindex
                 if( document.getElementById('busca_proj') ) {
                        document.getElementById('busca_proj').options[0].selected=true;
                        document.getElementById('busca_proj').options[0].selectedIndex=0;
                 }
                 ///
                 /*** 
                   if( document.getElementById('div_out') ) {
                        document.getElementById('div_out').innerHTML="";                                                                  
                        document.getElementById('div_out').style.display="none";                                        
                   }
                 ***/
                 /// Ocultando ID div_out 
                 exoc("div_out",0,"");  
                 return;
            } else  {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
            }
            break;    
        case "CORESPONSAVEIS":        
            var valor_anterior = val;
            ///  Numero de Responsaveis
            var nr_de_respons=0;
            if( document.getElementById(source) ) {
                 var nr_de_respons = document.getElementById(source).value;   
            }
            if( nr_de_respons<1 ) {
                 m_id_title="Faltando Co-Responsável.";
                 m_erro=1;
                 var resposta = para_confirm(m_id_title+' Corrigir?');
                 if( resposta ) { 
                     var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                     msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                     var final_msg_erro = "&nbsp;</span></span>";
                     m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                     msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                     ///  document.getElementById("msg_erro").innerHTML=msg_erro;    
                     ////  document.getElementById("label_msg_erro").innerHTML=msg_erro;  
                     exoc("label_msg_erro",1,msg_erro);
                     ///  frm.m_id_name.focus();
                     document.getElementById(source).focus();
                     return;
                 }                
            } else {
                  ///  Alterando Co-Responsaveis
                 var id_inc_pe = "incluindo_"+source;
                 decisao = confirm("Modificar os Co-Responsáveis?\r\n( Sim/Ok ou Não/Cancel )");
                 if( ! decisao ) {
                     /***
                    if( document.getElementById(id_inc_pe) ) {
                         document.getElementById(id_inc_pe).style.display="none";
                    }
                    ***/
                     ////  Desativando ID   
                     exoc(id_inc_pe,0,"");
                     return document.getElementById(source).value=valor_anterior;
                 }
                 var val = document.getElementById(source).value;
                 var id_inc_pe = "incluindo_"+source;
                 if( val<1 ) {
                     ///  exoc("incluindo_coautores",0);
                     exoc(id_inc_pe,0);
                     return;
                 } else {
                     exoc(id_inc_pe,1);
                 }
                 ///  Desativando ID iddivcoresp - Alterado em 20180425
                 exoc("iddivcoresp",0,"");
                 if( document.getElementById("iddivcoresp") ) {
                      ///  Removendo um elemento 
                      var item = document.getElementById("iddivcoresp");
                      item.parentNode.removeChild(item);
                 }
                 ///
                 var m_array="";
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val); 
                 ///
            }
            break;
        case "TODOS":        
            var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array);  
            break;
        case "SUBMETER": 
            var frm = string_array;
            var m_elements_total = frm.length; 
     /*
    oForm = string_array;
    str = "Elementos do form " + oForm.name + " \n"
    for (i = 0; i < oForm.length; i++) {
        str += oForm.elements[i].name + " = "+oForm.elements[i].value+oForm.elements[i].type+"\n"
    }
    alert(str)
*/       
            ///  Desativar mensagem
           //// if( document.getElementById('label_msg_erro') ) document.getElementById('label_msg_erro').style.display="none";
            /// Definindo as variaveis
            var m_erro = 0; 
            var n_coresponsaveis= new Array(); 
            var n_coresp_novo= new Array(); 
            var n_i_coautor=0;   
            var n_i_coautor_novo=0;   
            var n_datas=0; 
            var arr_dt_nome = new Array(); 
            var arr_dt_val = new Array();
            var campo_nome="";   
            var campo_value=""; 
            var m_id_value="";
            ///  Iniciando o FOR dos campos do FORM
            for( i=0; i<m_elements_total; i++ ) {      
                 ///  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
                 var m_id_name = frm.elements[i].name;
                 var m_id_type = frm.elements[i].type;
                 var m_id_title = frm.elements[i].title;
    
 /// alert("cpo#"+i+"  nome="+m_id_name+"  tipo="+m_id_type+"  valor="+frm.elements[i].value+"  m_id_title="+m_id_title)

                  ///  SWITCH
                 switch (m_id_type) {
                    case "undefined":
                       ///  case "hidden":                 
                    case "button":   
                       ///  Alterado em 20120412
                       var pos = m_id_name.search(/ENVIAR|ALTERAR/i);
                       if( pos!=-1  ) {
                           break;
                       } else {
                          continue;
                       }
                       break;
                    case "image":
                    case "reset":
                       continue;
                    case "checkbox": 
                       if( ! elements[i].checked ) var m_erro = 1;
                       break;
                    case "text":
                       m_id_value = trim(document.getElementById(m_id_name).value);
                       if( m_id_value=="" && m_id_name.toUpperCase()=="TITULO") {
                            var m_erro = 1;
                       }
                      /*
                    if( m_id_name.toUpperCase()=="CORESPONSAVEIS" ) {
                        var confirm_text = "Co-Respons?veis";
                    }
                    */
                      break;
                   case "hidden":
                       m_id_value = trim(document.getElementById(m_id_name).value);
                       break;
                   case "textarea":
                       m_id_value = trim(document.getElementById(m_id_name).value);
                       if( m_id_value==""  && m_id_name.toUpperCase()=="TITULO") {
                           var m_erro = 1;
                       }    
                       break;              
                   case "select-one":
                       m_id_value = trim(document.getElementById(m_id_name).value);
                       if( m_id_value=="" ) {
                          var m_erro = 1;
                       }
                       break;
                   case "file":
                       m_id_value = trim(document.getElementById(m_id_name).value);
                      if( m_id_value=="" ) {
                           var m_erro = 1;    
                      } else {
                          var tres_caracteres = m_id_value.substr(-3);  
                          var pos = tres_caracteres.search(/pdf/i);
                          /// Verificando se o arquivo formato pdf
                          if( pos==-1 ) {
                              m_erro=1; m_id_title="Arquivo requerido deve estar no formato PDF.";
                          }
                      }
                      break;
            }      
            /// Final - switch            

             ///  Verificando os coautores ou colaboradores
             var pos = m_id_name.search(/ncoautor/i);  ///  ATUAIS
             if( pos!=-1 ) {
                 m_id_value = trim(document.getElementById(m_id_name).value);
                 n_coresponsaveis[n_i_coautor]=m_id_value;
                 n_i_coautor++;
             }   
             ///  MODIFICANDO
             var n_pos = m_id_name.search(/ncoautor_novo/i);  

 ///  alert("LINHA 130 -->>  n_pos =  = "+n_pos+"   <<<---  \r\n campo_nome = "+campo_nome+"  \r\n campo_value = "+campo_value+"  \r\n m_id_name="+m_id_name+" - value="+m_id_value+" - type="+m_id_type+" - m_erro="+m_erro+" msgErro="+m_id_title+" n_coresp="+n_i_coautor)
             
             if( n_pos!=-1 ) {
                 m_id_value = trim(document.getElementById(m_id_name).value);
                 if( m_id_value==""  ) {
                     m_erro=1; m_id_title="Selecionar Co-Resp.";
                 } else {
                    n_coresp_novo[n_i_coautor_novo]=m_id_value;
                    n_i_coautor_novo++;                    
                 }
             }
             
             /*   Alterado em 20120412
                  if( m_id_name.toUpperCase()=="ENVIAR" ) {   
             */  
             var pos = m_id_name.search(/ENVIAR|ALTERAR/i);
             if( pos!=-1  ) {
                 ///  Verificando duplicata do coautor/colaborador 
                /* 
                if( n_i_coautor>1 ) {   //  ATUAIS
                      //  Verifica se existe duplicata
                     var duplicado = 0;
                     var sortedarray=n_coresponsaveis.sort(); 
                     for (k = 0; k < (n_i_coautor-1); k++ ) { 
                        if( sortedarray[k]==sortedarray[k+1] ) {
                            duplicado=1; 
                            m_id_title="Duplicado: Co-Resp. "+sortedarray[k]; 
                            m_erro=1;                                    
                            break;
                        }
                     }
                }
                */
                if( n_i_coautor_novo>1 ) {   ///  MODIFICAR
                    ///  Verifica se existe duplicata
                    var duplicado = 0;
                    var sortedarray=n_coresp_novo.sort(); 
                    for( k=0; k < (n_i_coautor_novo-1); k++ ) { 
                        if( sortedarray[k]==sortedarray[k+1] ) {
                            duplicado=1; 
                            ///  m_id_title="Duplicado: "+sortedarray[k]; 
                            m_id_title="Duplicado:  Co-Resp. "+sortedarray[k]; 
                            m_erro=1;                                    
                            break;
                        }
                    }
                    var n_coresponsaveis =  n_coresp_novo;
                    var coresponsaveis =  n_i_coautor_novo;
                    ///  ALTERADO EM 20120712 - n_i_coautor como n_i_coautor_novo
                    var n_i_coautor=n_i_coautor_novo;
                }
             }

//// alert("LINHA 130 - m_id_name="+m_id_name+" - value="+m_id_value+" - type="+m_id_type+" - m_erro="+m_erro+" msgErro="+m_id_title+" n_coresp="+n_i_coautor)

             ///  IF quando encontrado Erro
             ///  Quando for campo sem title passar sem erro
             if( m_id_title.length<1 ) m_erro=0;
             
             ///  Verificando a data  FINAL
             var m_datas = /(datafinal|datafin|data_fin)/i;
             if( m_datas.test(m_id_name) )  {
                 if( m_id_value=="" ) m_erro=0;    
             } 
             ///  Final da verificacao do campo data final
             
             if( m_erro==1 ) {
                   ////  document.getElementById("label_msg_erro").style.display="block";
                  //   document.getElementById("msg_erro").style.display="block";
                  //     document.getElementById("msg_erro").innerHTML="";
                   var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                   msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                   var final_msg_erro = "&nbsp;</span></span>";
                   m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                   ///  document.getElementById("msg_erro").innerHTML=msg_erro;    
                  
                   ////  document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                   exoc("label_msg_erro",1,msg_erro);
                   ///  frm.m_id_name.focus();
                   ///  document.getElementById(m_id_name).focus();
                    ///   alert("Corrigir: "+m_id_title);
                   return;
             }
             ///
            campo_nome+=m_id_name+",";  
            campo_value+=m_id_value+",";
            /*   Teste    
            var testecponv = campo_nome+"\r\n  "+campo_value;
            alert("LINHA 311 - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro+"\r\n\r\n"+testecponv)            
         */   
         } 
         /// endfor dos campos do SUBMETER

         ///  document.form.elements[i].disabled=true; 
         if( m_erro==1 ) {
             return false;
         } else {
            ///  Enviando os dados dos campos para o AJAX
            if( n_i_coautor>0 ) {
                var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value)+"&m_array="+encodeURIComponent(n_coresponsaveis);                 
            } else {
                var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);             
            }
            ///             

 /// alert("DENTRO ---->>>  poststr = "+poststr+"   \r\n\r  m_array = "+m_array+"  <<<--- \r\n opcao = "+opcao+" - val = "+val+"  \r\n n_i_coautor = "+n_i_coautor+" - n_i_coautor_novo = "+n_i_coautor_novo+" \r\n - campo_nome = "+campo_nome+" - \r\n campo_value =  "+campo_value)                          
            
         }
    }         
    /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca - AJAX   */
    if ( !myConn ) {
        var msgtxt=acentuarAlerts("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor."); 
        ////  alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
         alert(msgtxt);
         return false;
    }
    //
    //  Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
   //   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    var receber_dados = raiz_central+"alterar/projeto_alterar_ajax.php";
    ///

    var inclusao = function (oXML) { 
                       //  Recebendo os dados do arquivo ajax
                       //  Importante ter trim no  oXML.responseText para tirar os espacos
                       var m_dados_recebidos = trim(oXML.responseText);
                       var lnip = m_dados_recebidos.search(/Nenhum|ERRO:/i);
   
 ///   alert("---> projeto_alterar.php/914 -->> opcao = "+opcao+"  <<-- source = "+source+" - val = "+val+" - m_dados_recebidos "+m_dados_recebidos);                                
   
                       ///  Caso encontrado:  Nenhum|ERRO:
                       if( lnip!=-1 ) {
                            if( opcao=="TODOS" || opcao=="BUSCA_PROJ" )  {
                                /// Separando a mensagem recebida
                                var pos1 = m_dados_recebidos.search(/INICIA/i);
                                var pos2 = m_dados_recebidos.search(/FINAL/i);
                                if( pos1!=-1 && pos1!=-2  ) {
                                    m_dados_recebidos=m_dados_recebidos.replace(/ERRO:|CORRIGIR_ERRO:|INICIA|FINAL/ig,"");                      
                                }
                            }
                            /*
                                document.getElementById('label_msg_erro').style.display="block";
                                document.getElementById('label_msg_erro').innerHTML=srv_ret;
                            */
                            ///  Ativando ID label_msg_erro mensagem de erro
                            exoc("label_msg_erro",1,m_dados_recebidos); 
                            return;                  
                            ///               
                       }
                       /// if( ( opcao=="COAUTORES" ) ||  ( opcao=="COLABS" ) ) {
                       if( ( opcao=="CORESPONSAVEIS" ) ||  ( opcao=="COLABS" ) ) {                            
                              ///  VERIFICA se retornou ERRO  
                              var pos = m_dados_recebidos.search(/ERRO|Nenhum/i);
                              
 ///    alert("---> projeto_alterar.php/939 -->> CORESPONSAVEIS/COLABS  <<<---  "+pos+"  --- opcao = "+opcao+"  <<-- source = "+source+" - val = "+val+"  \r\n\r\n - m_dados_recebidos "+m_dados_recebidos);                                                                       
                              
                              if( pos!=-1 ) {
                                  /***
                                  if( document.getElementById('label_msg_erro') ) {
                                       document.getElementById('label_msg_erro').style.display="block";    
                                       document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;                                          
                                  }
                                  ***/
                                  ///  Ativando ID label_msg_erro mensagem de erro
                                  exoc("label_msg_erro",1,m_dados_recebidos); 
                                 return;                  
                                 ///               
                              } else {
                                  ///  id=corpo  div central da pagina 
                                  if( document.getElementById('corpo') ) {
                                      var stdis=document.getElementById('corpo');
                                      if( stdis.style.display==="none" || stdis.style.display==="" ) {
                                           document.getElementById('corpo').style.display="block";                                          
                                      }    
                                  }
                                  ///  document.getElementById(id_inc_pe).innerHTML= oXML.responseText;
                                  /// Mensagem de dados ID id_inc_pe - ativar
                                  exoc(id_inc_pe,1,m_dados_recebidos);   
                                  return;
                                   ///
                              }    
                       } else if( opcao=="BUSCA_PROJ"  ) {
                                 ///  VERIFICA se retornou ERRO  
                                 var pos = m_dados_recebidos.search(/ERRO|Nenhum/i);
                                  if( pos!=-1 ) {
                                       /***
                                       if( document.getElementById('label_msg_erro') ) {
                                           document.getElementById('label_msg_erro').style.display="block";    
                                           document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;                                          
                                       }
                                       ***/
                                      /// Mensagem de erro ID id_inc_pe - ativar
                                      exoc("label_msg_erro",1,m_dados_recebidos);   
                                      ///
                                  } else {
                                     // Caso tenha cancelado a Alteracao - LIMPAR
                                     if( val.toUpperCase()=="LIMPAR" ) {
                                        //  Voltar para o inicio da Tag Select  id  - selectedindex
                                        document.getElementById('busca_proj').options[0].selected=true;
                                        document.getElementById('busca_proj').options[0].selectedIndex=0;
                                        if( document.getElementById('div_out') ) {
                                            document.getElementById('div_out').innerHTML="";                                                                  
                                            document.getElementById('div_out').style.display="none";                                        
                                        }
                                     } else {
                                        if( document.getElementById('div_out') ) {
                                            document.getElementById('div_out').style.display="block";
                                            document.getElementById('div_out').innerHTML=m_dados_recebidos;
                                        }
                                     }
                                  } 
                        } else if( opcao=="TODOS"  ) {
                                if( document.getElementById('busca_proj') ) {
                                     document.getElementById('busca_proj').options[0].selected=true;
                                     document.getElementById('busca_proj').options[0].selectedIndex=0;                   
                                }
                                // document.getElementById('div_out').style.display="none";
                                document.getElementById('div_out').innerHTML=m_dados_recebidos;                
                                //                           
                        } else {
                              var pos = m_dados_recebidos.search(/ERRO:|CORRIGIR_ERRO:|FALHA:/i);
                              if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";
                              document.getElementById('label_msg_erro').style.display="block";
                              if( pos!=-1 ) {
                                    ///  Ocorreu erros na Alteracao do Projeto
                                    /// alert("PASSOU 484 - pos = "+pos+"m_dados_recebidos="+m_dados_recebidos)
                                    ///  Ocultando ID                                          
                                    /// exoc("label_msg_erro",1,m_dados_recebidos); 
                                    exoc("div_out",1,m_dados_recebidos);
                                    return;
                              } else {

 ///  alert(" FINAL --->> opcao = "+opcao+"  --- source = "+source+" - val = "+val+" \r\n -->> m_dados_recebidos = "+m_dados_recebidos);

                                  if( opcao=="SUBMETER" ) {
                                       document.getElementById('label_msg_erro').style.display="block";    
                                       //  OCULTANDO as divs:  div_form e div_out
                                       if( document.getElementById('div_form') ) {
                                           document.getElementById('div_form').style.display="none";  
                                           if( document.getElementById('div_out') ) document.getElementById('div_out').style.display="none";  
                                       }                                            
                                       ///  Recebendo o numprojeto e o num do autor
                                       var test_array = m_dados_recebidos.split("falta_arquivo_pdf");
                                       if( test_array.length>1 ) {
                                            m_dados_recebidos=test_array[0];
                                            var n_co_autor = test_array[1].split("&");
                                            ///  Passando valores para tag type hidden
                                            document.getElementById('nprojexp').value=n_co_autor[0];
                                            document.getElementById('autor_cod').value=n_co_autor[1];
                                            //  Nome do Arquivo em PDF - campo relatproj
                                            var arquivo_pdf = n_co_autor[2];
                                            /* 
                                          if(  n_co_autor.length>2 ) {
                                               //  ID da pagina anotacao_cadastrar.php
                                               if( document.getElementById('anotacao_numero') ) {
                                                  document.getElementById('anotacao_numero').value=n_co_autor[2];                                               
                                               }  
                                          }
                                          */
                                       } else {
                                            m_dados_recebidos=test_array[0];  
                                       } 
                                       document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                       /// Verificar pra nao acusar erro
                                       if( document.getElementById('arq_link') ) {
                                           document.getElementById('arq_link').style.display="block";        
                                       }
                                       ///  document.getElementById('div_form').innerHTML=m_dados_recebidos;
                                  } else if( opcao.search(/TODOS|TODAS/i)!=-1 ) {
                                         if( document.getElementById('busca_proj') ) {
                                             var melem=document.getElementById('busca_proj');
                                             melem.options[0].selected=true;
                                             melem.options[0].selectedIndex=0;                   
                                         }
                                        ////  document.getElementById('label_msg_erro').style.display="block";    
                                       /// document.getElementById('div_out').style.display="none";
                                        document.getElementById('div_out').innerHTML=srv_ret;                
                                  } else {
                                      if( document.getElementById('corpo') ) document.getElementById('corpo').innerHTML=oXML.responseText;   
                                  }
                              }
                         }
                        
           }; 
          /* 
              aqui ? enviado mesmo para pagina receber_dados (arquivo Ajax) 
               usando Metodo Post, + as variaveis, valores e a Funcao (retorno)   */
               
        var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
        /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho   */
 
        return;
        ///   
}  
///  FINAL - Function enviar_dados_cad para AJAX 
///
/*
     Function para o Donwload/Carregar  do Servidor para o Local
*/
function download(m_id) {
     var m_id_val = document.getElementById(m_id).value;
     self.location.href='baixar.php?file='+m_id_val;
}
///  Limitando o numero de caracteres no textarea
function limita_textarea(campo){
      var tamanho = document.form1[campo].value.length;
      var tex=document.form1[campo].value;
      if( tamanho>=255 ) {
          document.form1[campo].value=tex.substring(0,5);
      }
      return true;
}
/// 
///  Funcao para alinhar o campo
function alinhar_texto(id,valor) {
     var id_valor = document.getElementById(id).value;
     document.getElementById(id).value=trim(id_valor);
     return;
}
///
///   Numero de coautores - enviar para cria-los
function n_coresponsaveis(field,event) {
         ///  var e = (e)? e : event;
         var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
         var tecla = keyCode;
         if( tecla==9 ) return;
        /*    Vamos utilizar o objeto event para identificar 
              quais teclas est?o sendo pressionadas.       
              teclas 13 e 9 sao Enter e TAB
         */
         /// Backspace
        if( tecla==8 ) return;
         
        if( !(tecla >= 48 && tecla <= 57 ) && !( tecla==13  ||  tecla==9 ) ) {
           if( !(tecla >= 96 && tecla <= 105 )  ) {
              /* A propriedade keyCode revela o Código ASCII da tecla pressionada. 
                Sabemos que os n?meros de 0 a 9 est?o compreendidos entre 
                os valores 48 e 57 da tabela referida. Ent?o, caso os valores 
                não estejam(!) neste intervalo, a fun??o retorna falso para quem
                a chamou.  Menos keyCode igual 13  */
               document.getElementById(field.id).value="";
               alert("Apenas N?MEROS s?o aceitos!");
               field.focus();
               field.select();
               return false;
           }
        }
        if(  tecla==13  ||  tecla==9  ) {
            alert(" ENTER OU TAB - field  = "+field +" - value = "+value+" - tecla = "+tecla)
            return;
        }
}
/**********  Final -   Numero de coautores - enviar para cria-los  ****************/
///
///  tag input type button - buscar coautores
function  buscacoresponsaveis(m_id) {
    var valor_id = document.getElementById(m_id).value;
    document.getElementById("busca_autores").disabled=true;
    if( valor_id>0 ) { 
         document.getElementById("busca_autores").disabled=false;
         document.getElementById("busca_autores").focus();
    }
}
/// Function retorna para o mesmo campo
function retornar_cpo(m_id) {
     document.getElementById(m_id).focus();
     return ;
}
///
/// VERIFICA SE DATA FINAL MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)
var m_erro=0;
function verificar_datas(dtinicial_nome, dtfinal_nome, dtInicial, dtFinal) {
    document.getElementById("label_msg_erro").style.display="none";
    document.getElementById("label_msg_erro").innerHTML='';              
    var dtini_nome = dtinicial_nome;
    var dtfim_nome = dtfinal_nome;
    var dtini = dtInicial;
    var dtfim = dtFinal;
    
    if((dtini == '') && (dtfim == '')) {
        // alert('Complete os Campos.');
        //  campos.inicial.focus();
        ///  return false;
        m_corrigir = confirm("Digitar as datas?"); 
        if ( m_corrigir ==true ) {   /// testa se o usuario clicou em cancelar
              document.getElementById("label_msg_erro").style.display="block";
              msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
           final_msg_erro = '</span></p>';
              msg_erro = msg_erro+'&nbsp;Digitar as datas'+final_msg_erro;
                document.getElementById("label_msg_erro").innerHTML=msg_erro;
                document.getElementById(dtini_nome).focus();    
                //    return false;            
             m_erro = 1;
             return m_erro;
        } else if( m_corrigir == false ) { 
            m_erro = 0;
            return m_erro;
        }
    }
    
    datInicio = new Date(dtini.substring(6,10), 
                         dtini.substring(3,5), 
                         dtini.substring(0,2));
    datInicio.setMonth(datInicio.getMonth() - 1); 
    
    
    datFim = new Date(dtfim.substring(6,10), 
                      dtfim.substring(3,5), 
                      dtfim.substring(0,2));
                     
    datFim.setMonth(datFim.getMonth() - 1); 

    if(datInicio <= datFim){
         // alert('Cadastro Completo!');
        m_erro = 0;
        return m_erro;
        //  return true;
    } else {
        alert('ATEN??O: Data Inicial ? MAIOR que Data Final');
        document.getElementById("label_msg_erro").style.display="block";
          document.getElementById("label_msg_erro").innerHTML="";
          msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
           final_msg_erro = '</span></p>';
          msg_erro = msg_erro+'Data Inicial ? MAIOR que Data Final'+final_msg_erro;
         document.getElementById("label_msg_erro").innerHTML=msg_erro;
               ///  document.getElementById(dtini_nome).focus();    
         m_erro = 1;
      ///     return m_erro;
   }    
}
/*******  Final - VERIFICA SE DATA FINAL MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)  *******/
/*
       Funcao para incluir arquivo do Javascript
*/
function include_arq(arquivo){
     ///  By An?nimo e Micox - http://elmicox.blogspot.com
     var novo = document.createElement("<script>");
     novo.setAttribute('type', 'text/javascript');
     novo.setAttribute('src', arquivo);
     document.getElementsByTagName('body')[0].appendChild(novo);
     /// document.getElementsByTagName('head')[0].appendChild(novo);
     ///  apos a linha acima o navegador inicia o carregamento do arquivo
     ///  portanto aguarde um pouco at? o navegador baix?-lo. :)
}
///
///  Limpar os campos do opcao=="CONJUNTO"
function limpar_campos(new_elements) {
        /*  M?todo slice
            Obt?m uma sele??o de elementos de um array.
        */  
        var m_elementos = new_elements.slice(1,new_elements.length);
        for( x=0; x<m_elementos.length; x++ )  {
              var limpar_cpo = "td_"+m_elementos[x];
              document.getElementById(limpar_cpo).style.display="none";
        }                                              
}
///
function mensg_erro(dados,m_erro,array_ids) {
 //   if( m_erro=="msg_erro1" ) {
         if( typeof(array_ids)=="object" &&  array_ids.length ) {
             for( i=0 ; i<array_ids.length ; i++ ) {
                  document.getElementById(array_ids[i]).style.display="none";   
             }
         }
         ///  Tem que ter esses  document.getElementById
         document.getElementById('label_msg_erro').style.display="block";
         document.getElementById(m_erro).innerHTML=dados;
 //    }
}
///
</script>
<?php
///     Alterado em 20170925   
///   require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

///   Alterar - PROJETO
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//
//  Definindo valores nas variaveis
if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"]; 
if( isset($array_pa['orientador']) ) $permit_orientador=$array_pa['orientador'];  
//
?>
</head>
<body id="id_body" oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);" >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
///
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"   >
<!--  Mensagens e Titulo  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro" class="div_msg_erro" >
</div>
<p class='titulo_usp' >Alterar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final -  Mensagens e Titulo  -->
<?php 
///
/// IP do usuario conectado 
if ( isset($_SERVER["REMOTE_ADDR"]) )    {
    $usuario_ip = $_SERVER["REMOTE_ADDR"];
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
    $usuario_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    $usuario_ip = $_SERVER["HTTP_CLIENT_IP"];
}
///  Usuarios permitidos pelo IP 
$ips_permitidos = array("143.107.143.231","143.107.143.232","189.123.108.225",$usuario_ip);
///  $ips_permitidos = array("143.107.143.231","143.107.143.232");
///  if( $indice ) {
if( ! in_array($usuario_ip, $ips_permitidos) ) {
    ?>
    <script type="text/javascript">
       /* <![CDATA[ */
       alert("Página em construção")       
      /* ]]> */
   </script>
   <?php
   $pagprincipal="{$_SESSION["url_central"]}"; 
   echo "<p style='text-align: center; font-size: medium;' >P&aacute;gina em constru&ccedil;&atilde;o</p>";
   echo "<p style='text-align: center; font-size: x-small;' >";
   ?>
   <a href="<?php echo $pagprincipal;?>authent_user.php" name="voltar" id="voltar" class="botao3d" 
    style="font-size: 10px; height: 160px; cursor: pointer;" title="Voltar" acesskey="V" alt="Voltar" >
      Voltar&nbsp;<img src="imagens/enviar.gif" alt="Voltar"   style="vertical-align:text-bottom;" >
   </a>
   <?php
   echo "</p>";
   exit();
}
///     Verificano o PA - Privilegio de Acesso
/// if( ( $_SESSION["permit_pa"]>$_SESSION['array_usuarios']['superusuario']  and $_SESSION["permit_pa"]<=$_SESSION['array_usuarios']['orientador'] ) ) {    
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {    
    if( strlen(trim($_SESSION["msg_upload"]))>1 ) {
    ?>
    <script type="text/javascript" language="javascript">
         ///  Enviar mensagem na tela - cabecalho
         exoc("label_msg_erro",1,"<?php echo $_SESSION["msg_upload"]; ?>");      
          ///
    </script>
    <?php
        if( strlen(trim($_SESSION["erros"]))<1 ) $_SESSION["display_arq"]='none';
    }       
///
?>        
<div id="arq_link" style="display: <?php echo $_SESSION['display_arq'];?>;">
  <p class="paragrafo_centrar" style="font-size: medium;" >Para substituir o arquivo original clicar abaixo.</p>
  <form  name="form_arq_link"  method="post"  enctype="multipart/form-data"  action="<?php echo $pagina_local;?>"  >
     <table border='0' cellpading='0' cellspacing='0' width='90%'>
       <tr>
         <!-- Relatorio Externo (link) Projeto -->
          <td  class="td_inicio1" style="vertical-align: middle;" colspan="1" >
            <label for="relatproj" style="vertical-align: middle; cursor: pointer; " title="link para o Arquivo do Projeto" >
                <span class="asteristico" >*</span>&nbsp;Arquivo (link):&nbsp;</label>
          </td>
           <td class="td_inicio2" style="vertical-align: middle; " colspan="1"  >
              <input type="hidden" name="fileframe" value="true">
               <!-- Target of the form is set to hidden iframe -->
               <!-- From will send its post data to fileframe section of this PHP script (see above) -->
               <input type="file" name="relatproj"  id="relatproj" 
                   size="90" title="Relatório Externo do Projeto (link)" 
                   style="cursor: pointer; vertical-align:middle;" onChange="javascript: jsUpload(this);" />
               <input  type="hidden"  id="nprojexp"  name="nprojexp"    />
               <input  type="hidden"  id="autor_cod"  name="autor_cod"  />       
               <input  type="hidden"  id="m_titulo"  name="m_titulo"  value="<?php echo $_SESSION["m_titulo"];?>" />                     </td>
           <!-- FINAL - Relatorio Externo (link) Projeto -->
       </tr>
       <tr>
      <!--  Aviso na espera do processo -->
    </tr>    
    <tr align="center">
       <td align="center" style="width: 100%; display:block; text-align: center; background-color: #FFFFFF; color: #000000;"  colspan="2" >
            <div id="aguarde_arq" align="center"></div>
       </td>
    </tr>
     <tr>
       <td  align="center"  style="text-align: center; border:none; "  colspan="2"  >
          <!-- Cancelar para substituir o arquivo do Projeto - retornar -->                         
          <button name="cancelar" id="cancelar"  type="button"  class="botao3d" style="cursor: pointer; width: 120px; " 
           onClick="javascript: altera_projeto('APRESENTACAO','VOLTAR');" title="Cancelar" acesskey="C" >    
               Cancelar&nbsp;<img src="../imagens/limpar.gif" alt="Cancelar" style="vertical-align:text-bottom;" >
          </button>
          <!-- Final - Cancelar para substituir o arquivo da Anotacao -->                         
          <!-- Substituir o arquivo do Projeto -->                  
          <button type="submit" name="enviar_arq" id="enviar_arq"  class="botao3d"  style="width: 160px; cursor: pointer;" 
            onclick="javascript: if( trim(document.getElementById('relatproj').value)=='') { alert('Importante: informar arquivo para alterar!'); document.getElementById('relatproj').focus(); return false; }" 
               title="Enviar"  acesskey="E"  alt="Enviar" >    
            Enviar arquivo&nbsp;<img src="../imagens/enviar.gif" alt="Enviar Arquivo"  style="vertical-align:text-bottom;"  >
          </button>
          <!-- Final - Substituir o arquivo da Anotacao -->                  
        </td>
    </tr>
    <tr>
        <td  style="display:block; text-align: left; background-color: #FFFFFF; color: #000000;;"   colspan="2"    >
          <span class="asteristico" >*</span>&nbsp;<b>Campo obrigat&oacute;rio</b>    
       </td>
    </tr>       
   </table>
  </form>
<script type="text/javascript">
   /* This function is called when user selects file in file dialog */
   function jsUpload(upload_field) {
         /// Este e apenas um exemplo de verificacao de extensoes de arquivo
         ///  var re_text = /\.txt|\.xml|\.zip/i;
            var re_text = /\.pdf/i;
            var filename = upload_field.value;
            /* Checking file type */
             var merro=0;
             if( filename.search(re_text)==-1)  {
                  ///  alert("File does not have text(txt, xml, zip) extension");
                  alert("ERRO: Esse arquivo não tem formato PDF");
                  ///  upload_field.form.reset();
                   merro=1;
             }  else {
                 var n = filename.search(/[%*/$#@&]/);
                 if( n!=-1)  {
                     alert("ERRO: Nome do arquivo não pode conter símbolos como: %*/$#@& \r\nCorrigir renomear.");
                     merro=1;
                 }    
             }
             ///  Verifica se houve erro
             if( parseInt(merro)>0 ) {
                  document.getElementById('relatproj').value="";
                  document.getElementById('relatproj').focus();
                  return false;
             }
             /*
                 upload_field.form.submit();
                 document.getElementById('upload_status').value = "uploading file...";
                 upload_field.disabled = true;
                 return true;
             */
   }
   /// 
</script>
</div>
<!--  div - div_form  -->
<div id="div_form" class="div_form" style="overflow:auto;" >
<?php
///  CODIGO/USP
$elemento=5; $elemento2=6;
include("php_include/ajax/includes/conectar.php");     
///
///  Selecionar os projetos pelo campo desejado
$opcao_cpos = Array("fonterec","objetivo","ano_inicio","ano_final","anotacao") ;
$opcao_ncpos = count($opcao_cpos);                
///  TAG Select
# Aqui está o segredo
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
///
if ( $permit_pa<=$permit_orientador ) {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." a.codigousp=".$usuario_conectado." order by b.titulo ";
} else {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." b.cip in (select distinct cip from  $bd_2.anotador "
        ." where codigo=".$usuario_conectado.")  order by b.titulo ";
}
$result = mysql_query($sqlcmd); 
///                  
if( ! $result ) {
   /*  $msg_erro .= "Selecionando os projetos autorizados para esse Usu&aacute;rio. db/mysql: ".mysql_error().$msg_final;
    echo $msg_erro; */    
   echo $funcoes->mostra_msg_erro("Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} -&nbsp;db/mysql:&nbsp;".mysql_error());
    exit();    
}
///  N?mero de Projetos Selecionados
$nprojetos = mysql_num_rows($result);
///
?>
<!--  Todos Projetos -->   
<div style="display: flex;"  >
 <div class='titulo_usp' style='margin-left: 30%; padding:2px 0 2px 2px; font-weight: bold;font-size:large;' >
   Mostrar:&nbsp;
   <span style="vertical-align:top;font-size: medium;  " >
  <input type='button' id='todos' class='botao3d'  value='Todos' title='Selecionar todos'  onclick='javascript: altera_projeto("Todos")' >
</span>
  <span class="span_ord_proj" >
<!-- tag Select para ordenar  -->
<select   title="Ordernar"  id="ordenar"  class="ordenar"  onchange="javascript:  altera_projeto('ordenar',todos.value,this.value)"  >
<option  value=""  >ordenar por</option>
<option  value="datainicio asc"  >Data início - asc</option>
<option  value="datainicio desc"  >Data início - desc</option>
<option  value="datafinal asc"  >Data final - asc</option>
<option  value="datafinal desc"  >Data final - desc</option>
<option  value="titulo asc"  >Título - asc</option>
<option  value="titulo desc"  >Título - desc</option>
</select>
</span>
</div>
</div>
<!--  Final - Todos Projetos -->   
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" >Selecionar:</p>
</div>

<div  class="div_select_busca"  >
<Select name="busca_proj" id="busca_proj"  class="Busca_letrai"  title="Selecione o Projeto"  onchange="javascript:  altera_projeto('busca_proj',this.value)"  >
        <!-- Identifica??o do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
    <!-- Identifica??o do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
<?php    
///  Verificando o numero de projetos
if( intval($nprojetos)<1 ) {
    /* $opcao_msg="N&atilde;o existe Projeto vinculado a esse Usu&aacute;rio.";
      echo "<option value='' >N&atilde;o existe Projeto vinculado a esse Usu&aacute;rio.</option>";  */
    echo "<option value='' >N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.</option>";
} else {
    echo "<option value='' >Selecione o Projeto a ser acessado por esse {$_SESSION["usuario_pa_nome"]} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
    ///
    while($linha=mysql_fetch_assoc($result)) {
             $_SESSION["cip"]=$linha['cip'];
             $_SESSION["anotacao_numero"]=$linha['anotacao']+1;
             $autor_nome = $linha['nome'];  
             $fonterec=htmlentities($linha['fonterec']);
             $fonteprojid=  ucfirst(htmlentities($linha['fonteprojid']));         
             //  PARTES do Titulo do Projeto - dividindo em sete partes 
              $partes_antes=6;
              $projeto_titulo_parte="";
              $palavras_titulo = explode(" ",trim($linha['titulo']));
              $contador_palavras=count($palavras_titulo);
              for( $i=0; $i<$contador_palavras; $i++  ) {
                   $projeto_titulo_parte .="{$palavras_titulo[$i]} ";
                   if( $i==$partes_antes and $contador_palavras>$partes_antes  ) {
                        $projeto_titulo_parte=trim($projeto_titulo_parte);
                        $tamanho_campo=strlen($projeto_titulo_parte);
                        if( $tamanho_campo>40  ) $projeto_titulo_parte.="...";
                  ///      $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
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
              ///  Usando esse option para incluir espaco sobre linhas
              ////  echo  "<option value='' disabled ></option>";       
              /* IMPORTANTE: Detectar codificacao  de caracteres  - 20171005   */
              $codigo_caracter=mb_detect_encoding($titulo_projeto);
              if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
                  echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >"
                          .$titulo_projeto."&nbsp;&nbsp;</option>";  
              } else {
                  echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >"
                          .$titulo_projeto."&nbsp;&nbsp;</option>";                                   
              }
           
      }       
}            
?>                
</select>      
</div>
<!-- Final - div - div_form  -->
<p class="titulo_usp" >Lista dos Projetos</p>
<!-- Tabela dos Projetos  -->
<div id="div_out"  style="margin: 0 auto; width: 100%; overflow:auto; height:auto; ">
</div>
<!--  Final  -  Tabela dos Projetos  -->
<!--  Projeto escolhido -->
 <div class='titulo_usp2' id="projeto_escolhido" style='text-align: justify;display: none;margin-top:0;padding-top:.2em;padding-bottom:.2em;'>
</div>
<!-- Final - Projeto escolhido -->

<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
<div id="div_out" style="margin: 0px; padding: 0px; top: 0px; width: 99%; overflow: auto; height: auto; ">
</div>
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("{$_SESSION["incluir_arq"]}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
