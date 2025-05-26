<?php 
/*   REXP - CONSULTAR ANOTA??O DE PROJETO
*   
*   REQUISITO: O Usuário deve ter PA>0 e PA<=50 
* 
*   LAFB&SPFB110908.1629
*/
//  ==============================================================================================
//  ANOTACAO ALTERAR
//  ==============================================================================================
//
// Dica: #*funciona?*# Se o que quer ? apenas for?ar uma visualiza??o direta no navegador use
// header("Content-Disposition: inline; filename=\"nome_arquivo.pdf\";"); 
//
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
///  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');
/***
*    O charset UTF-8 é uma recomendação, 
*    pois cobre quase todos os caracteres e 
*    símbolos do mundo
***/
////  ini_set( 'default_charset', 'utf-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

/// include('inicia_conexao.php');
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
      verifica se o arquivo foi enviado        */
///  $_SESSION["display_arq"]='none';
$_SESSION["display_arq"]='none';
$_SESSION["div_form"]="block";
$_SESSION["result"]=''; 
$_SESSION["msg_upload"]="";
//

/// $_SESSION['time_exec']=180000;
/// Mensagens
include_once("{$_SESSION["incluir_arq"]}mensagens.php");
//
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
//  
if( ! isset($_SESSION["relatext_orig"]) ) $_SESSION["relatext_orig"]="";
//  fileframe - tag iframe  type hidden
if( isset($_POST['fileframe']) ) {
   $_SESSION["div_form"]="none";
   include("{$_SESSION["incluir_arq"]}includes/functions.php");  
  ///  NOME TEMPOR?RIO NO SERVIDOR
  if( isset($_FILES['relatext']['tmp_name']) ) {
      ///
      // Definindo as variaveis
      $_SESSION["result"]='OK'; $erros="";
      $nprojexp=$_POST["nprojexp"];        
      $autor_cod=$_POST["autor_cod"];    ///  Autor da Anotacao
      ///  Conectar  BD
      /***
      $elemento=5; $elemento2=6; 
      include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
      $db_select = mysql_select_db($db_array[$elemento],$lnkcon);
      ***/
      ///
      $select_numprojeto = mysql_query("SELECT numprojeto,autor FROM $bd_2.projeto 
                                           WHERE cip=$nprojexp  ");
      ///
      if( ! $select_numprojeto ) {
            ///  die('ERRO: Select projeto campo numprojeto - falha: '.mysql_error());              
           ///  Partes Class - includes/autoload_class.php  e  funcoes.class.php  - IMPORTANTE
           echo $funcoes->mostra_msg_erro("Select projeto campo cip -&nbsp;db/mysql:&nbsp;".mysql_error());
           exit();
      }
      ///
      $_SESSION["numprojeto"]=mysql_result($select_numprojeto,0,"numprojeto");
      $numprojeto=$_SESSION["numprojeto"];
      $projeto_autor=mysql_result($select_numprojeto,0,"autor");
      /// 
      if( isset($select_numprojeto) ) mysql_free_result($select_numprojeto);      
      $_SESSION["display_arq"]='block';
      /** Conjunto de arquivos - ver tamanho total dos arquivos ***/
      $tam_total_arqs=0; $files_array= array(); 
      $conta_arquivos = count($_FILES['relatext']['tmp_name']);    
      //  Verificando se existe diretorio
      $msg_txt_erro =  "<p "
               ." style='text-align: center; font-size: small; font-family: Verdana, Arial, Helvetica, sans-serif, Times, Georgia; font-weight:bolder;' >";
      $msg_txt_erro_final = "</p>";
     if( intval($conta_arquivos)<1 ) {
         $_SESSION["msg_upload"] = $msg_txt_erro."ERRO: Falta enviar arquivo.".$msg_txt_erro_final;
         $_SESSION["result"]='FALSE'; 
         $erros="ERRO";
     }
    ///    Esse For abaixo para acrescentar diretorios caso nao tenha
    ///  if ( $tamanho_dir[0]<1  or  !file_exists($_SESSION["dir"]) ) {  //  Tem que ser maior que 8 bytes
    for( $n=1; $n<3 ; $n++ ) {                
        ///  if( $n==1 )    $_SESSION["dir"] = "/var/www/html/rexp3/doctos_img/A".$_POST["autor_cod"];
        ///  if( $n==1 )  $_SESSION["dir"] = "/var/www/html".$_SESSION["pasta_raiz"]."doctos_img/A".$_POST["autor_cod"];
        if( intval($n)==1 ) {
             ///  $_SESSION["dir"] = "/var/www/html".$_SESSION["pasta_raiz"]."doctos_img/A".$projeto_autor;  
               $_SESSION["dir"] = "{$_SESSION["incluir_arq"]}doctos_img/A".$projeto_autor;  
        } 
        if( intval($n)==2 ) {
            $_SESSION["dir"] .= "/anotacao/";        
        }  
        if( ! file_exists($_SESSION["dir"]) ) {  ///  Verificando dir e sub-dir
            $r = mkdir($_SESSION["dir"],0755);
            if( $r===false ) {
                 ///  echo  $msg_txt_erro;
                 $_SESSION["msg_upload"] = $msg_txt_erro."Erro ao tentar criar diret&oacute;rio".$msg_txt_erro_final;
                 ///  die("Erro ao tentar criar diret&oacute;rio");
                 $_SESSION["result"]='FALSE';  $erros='ERRO';
            } else {
                 chmod($_SESSION["dir"],0755);                                                  
            } 
        }
    }
    ///    
    ///// tamanho em bytes do diretorio
    $tamanho_dir = shell_exec("/usr/bin/du  ".$_SESSION["dir"]);  
    $tamanho_dir = explode("/",$tamanho_dir);
    if( intval($conta_arquivos)>1 ) {
        for( $i=0; $i < $conta_arquivos; $i++) $tam_total_arqs += $_FILES["relatext"]["size"][$i];   
     } else {
         $tam_total_arqs = $_FILES["relatext"]["size"];   
     }
    ///
    $total_dir_arq = $tamanho_dir[0]+$tam_total_arqs;
    //
    /*** o tamanho maximo no arquivo configurado no  php.ini ***/
    /* $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
          $upload_max = ($ini_max * 1024)*1000000;
    */
    /***  an array to hold messages   ***/
   //  $messages=array(); 
    $files_size= array(); $files_date= array();         
    /*** check if a file has been submitted ***/                                           
    if( $_SESSION["result"]=='OK' )  {
        /***  tamanho maximo do arquivo admitido em bytes   ***/
        $max_file_size = 524288000; /// bytes - B
        $espaco_em_disco = $max_file_size-$tamanho_dir[0];
        if ( $espaco_em_disco<1024 ) $tipo_tamanho = "bytes";
        if ( $espaco_em_disco>1024 and  $espaco_em_disco<1024000 ) {
             $tipo_tamanho = "KB"; $espaco_em_disco= intval($espaco_em_disco/1024);
           } else if ( $espaco_em_disco>=1024000 ) {
                $tipo_tamanho = "MB"; $espaco_em_disco= intval($espaco_em_disco/1024000);
        }
        ///
        if( $total_dir_arq > $max_file_size ) {
             $erros='ERRO';
             $result_msg= "No tem espa&ccedil;o no disco para esse arquivo. Cancelado\\n";
             $result_msg .= "       espa&ccedil;o disponvel no disco  de ".$espaco_em_disco." $tipo_tamanho\\n";
             $_SESSION["msg_upload"] = $msg_txt_erro.$result_msg.$msg_txt_erro_final;
        }      
        /** loop atraves do conjunto de arquivos ***/
        //  verifica se o arquivo esta no conjunto (array)
        if( !is_uploaded_file($_FILES['relatext']['tmp_name']) ) {
               /// $messages[]="Arquivo n&atilde;o armazenado\n"; 
               $_SESSION["msg_upload"] = $msg_txt_erro."Arquivo n&atilde;o armazenado\n".$msg_txt_erro_final;
               ///  $erros[]='ERRO';
                $_SESSION["erros"] = $erros='ERRO';
        } elseif( $_FILES['relatext']['tmp_name'] > $max_file_size )  {
              /// verifica se o arquivo menor que o tamanho maximo permitido
              $_SESSION["msg_upload"]= $msg_txt_erro."O arquivo excedeu o tamanho limite permitido $max_file_size $tipo_tamanho ";
              $_SESSION["msg_upload"].=$msg_txt_erro_final;
               $_SESSION["erros"] = $erros='ERRO';
        } else {
              /****
                   $local_arq0 = $_SESSION["dir"].$filename;                 
                   $nprojexp=$_POST["nprojexp"]; 
                   $anotacao_numero=$_POST["anotacao_numero"];         ***/
              ///  REMOVENDO O ARQUIVO DA ANOTACAO/PDF  ANTERIOR CASO EXISTA
              if( isset($_SESSION["relatext_orig"])  ) {
                   if( strlen(trim($_SESSION["relatext_orig"]))>2 ) {
                       $dir_relatext_orig = "{$_SESSION["dir"]}{$_SESSION["relatext_orig"]}";                      
                       ///  Primeiro verifica se o arquivo anterior existe para depois remover
                       if( file_exists($dir_relatext_orig) ) {
                              unlink($dir_relatext_orig);
                       }
                   }
              }
              ///  Final -  REMOVENDO O ARQUIVO DA ANOTACAO/PDF ANTERIOR CASO EXISTA        
              /// copia o arquivo para o diretorio especificado
              ///  Arquivo comecando com a Letra A (Anotacao) e P (Projeto)
             $ver_num_anotacaook=0; 
              if( isset($_POST["anotacao_numero"]) ) {
                 if( strlen(trim($_POST["anotacao_numero"]))>0 ) {
                      $ver_num_anotacaook=1; 
                      $anotacao_numero=$_POST["anotacao_numero"];
                 } 
              }
              if( intval($ver_num_anotacaook)<1 ) {
                  if( isset($_SESSION["n_anotacao"]) ) {
                     if( strlen(trim($_SESSION["n_anotacao"]))>0 ) {
                          $ver_num_anotacaook=1; 
                          $anotacao_numero=$_SESSION["n_anotacao"];
                     } 
                  }
              }
              ///   Caso NAO numero da Anotacao
              if( intval($ver_num_anotacaook)<1 ) {
                     echo "ERRO GRAVE CONSULTAR ADMINISTRADOR/PROGRAMADOR.";
                     exit();     
              }    
              ///  Numero do Projeto dessa Anotacao
              $nprojexp=$_POST["nprojexp"]; 
              /***
              $filename="P".$_SESSION["numprojeto"]."A".$anotacao_numero."_".$_FILES['relatext']['name'];
              ***/
              $filename="P".$_SESSION["numprojeto"]."A".$anotacao_numero."_";
              $filename .=utf8_decode($_FILES['relatext']["name"]); 
              $dir_filename=$_SESSION["dir"].$filename;
              $relatext_tmp_name=$_FILES['relatext']['tmp_name'];
              $arqnovook=$_SESSION["dir"].$filename;
              if( @copy($_FILES['relatext']['tmp_name'],$_SESSION["dir"].$filename) )  {
                     /*** give praise and thanks to the php gods ***/
                     $erros='';
                     $_SESSION["msg_upload"]= $msg_txt_erro."Arquivo: ".$_FILES['relatext']['name'].' foi armazenado&nbsp;';
                      $_SESSION["msg_upload"].=$msg_txt_erro_final;
                     $files_array[]=$_FILES['relatext']['name'];
                     $files_size[]=$_FILES["relatext"]["size"];
                     //  $date = date('r', filemtime($upload_dir.'/'.$filename));
                     $files_date[] = date('d/m/Y H:i:s', filemtime($_SESSION["dir"].$filename));
                     $files_type[] = mime_type($filename);
                     /// Permissao do arquivo
                     chmod($_SESSION["dir"].$filename,0755);                                    
              } else  {
                     /***  an error message  ***/
                     $_SESSION["msg_upload"]= $msg_txt_erro.'Armazenamento '.$_FILES['relatext']['name'].' FALHA';
                     $_SESSION["msg_upload"].=$msg_txt_erro_final;
                     $_SESSION["erros"] = $erros = 'ERRO';
              }
        }
     } 
     ///  FINAL - IF  \$_SESSION["result"]
     ///
     $_SESSION["erros"] = trim($erros);
     //   Incluindo o nome do arquivo na tabela  projeto
     if( trim($erros)=='' ) {
         ///           
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
          ///
           ///  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
           ///                 - Use mysql_select_db() ou mysql_query()
           $success = mysql_query("UPDATE $bd_2.anotacao SET relatext='$local_arq'  "
                          ." where ( projeto=$nprojexp  and  autor=$autor_cod and  numero=$anotacao_numero  ) ");
           ///
           if( ! $success ) {
                $_SESSION["msg_upload"]= $msg_txt_erro.'FALHA no armazenamento do arquivo: '.$_FILES['relatext']['name'].'<br>';
                $_SESSION["msg_upload"].= mysql_error();
                $_SESSION["msg_upload"].=$msg_txt_erro_final;        
            } else {
                 $_SESSION["msg_upload"] .= $msg_txt_erro."Anotação $anotacao_numero do Projeto ".$_SESSION["numprojeto"]."  foi conclu&iacute;do.";
                 $_SESSION["msg_upload"] .=$msg_txt_erro_final;            
            }          
    }
  } /// isset(\$_FILES['relatext']['tmp_name'])
}  
///  FINAL - IF UPLOAD  
//
?>
<!DOCTYPE html >
<html lang="pt-br" >
<head>
<meta charset="utf-8" />
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<title>REXP - Alterar Anotação</title>
<!--  <script type="text/javascript"  language="javascript"   src="../includes/dochange.php" ></script> -->
<link  type="text/css"  href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />
<script  type="text/javascript" src="../js/XHConn.js" ></script>
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/verifica_mobile.js" ></script>
<script  language="javascript"  type="text/javascript" >
///
//
///   JavaScript Document - para Alterar Anotacao de um Projeto 
///
/****  
    Define o caminho HTTP  -  20180416
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
charset="utf-8";
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
/************  Final  -- function acentuarAlerts(mensagem)   ***********/
///
///  Verifica se foi selecionado o Projeto
function ativar(projeto_selec) {
    /// Verificando parametro projeto_selec
    if( typeof(projeto_selec)=='undefined' ) var projeto_selec="";
    projeto_selec = trim(projeto_selec);
    /**
    if( document.getElementById("div_out") )  {
         document.getElementById("div_out").innerHTML="";
         document.getElementById("div_out").style.display="none";      
    }
     ***/
    ///  Ocultando ID  e utilizando na tag input comando onkeypress
    exoc("div_out",0);  
    ///
    if( document.getElementById("div_form") ) {
        if( document.getElementById("div_form").style.display="none"  ) {
             document.getElementById("div_form").style.display="block";                    
        }     
    } 
    ///
    ////  Ativando ID id_anotacao - caso exista
    if( document.getElementById("id_anotacao") ) {
        if( document.getElementById("id_anotacao").style.display="none"  ) {
            document.getElementById("id_anotacao").style.display="block";   
        }     
         /// Caso exista ID ordernar - Ativar
         if( document.getElementById("ordenar") ) {
             if( document.getElementById("ordenar").style.display="none"  ) {
                 document.getElementById("ordenar").style.display="block";   
             }     
         }
         ///  
    }
    ///
}
/****************  FINAL -  function  ativar(projeto_selec)  *************************/
///
/****   Cadastro da Anotacao de um  PROJETO   ****/
function  consulta_alteraranot(idselecproj, idopcao,string_array){
//
//  Selecionar as ANOTACOES DE PROJETOS de acordo com a opcao (todos ou pelo campo desejado)
//
//  LAFB/SPFB110831.1127
//  LAFB/SPFB110909.0917
//
//  Parametros:
//      idselecproj = Identificacao do Select de escolha do projeto
//      idopcao     = Identificacao da Opcao de selecao das Anotacoes (TODOS, select (ano_incio, ano_final, anotacao)
//
//  Prepara os parametros para ativacao do srv_php
/// Determina qual opcao do Select <idselecproj> foi selecionada:
    /// Verificando se a function exoc existe 
    if(typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
    ///
    ///  Verificando variaveis recebidas
    if( typeof(idselecproj)=="undefined" ) var idselecproj=""; 
    if( typeof(idopcao)=="undefined" ) var idopcao="";
    if( typeof(string_array)=="undefined" ) var string_array="";
    ///
    if( typeof(idopcao)=="string" ) {
         var idopcao=trim(idopcao);
         var idopcao_upper=idopcao.toUpperCase();  
    } 
    /****  
         Define o caminho HTTP    -  20180615
    ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       


 ///   alert("anotacao_alterar.php/456 - idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array);
    
    ///  Voltando para o Menu
    if( idselecproj.toUpperCase()=="APRESENTACAO" ) {                 
         //// Caso tenha cancelado a alteracao no Projeto do arquivo PDF
         if( idopcao.toUpperCase()=="VOLTAR" ) {
             /// RETORNAR A PAGINA ALTERAR ANOTACAO DO PROJETO
             location.href=pagina_local;
         } else {
             /// top.location.href="../menu.php";
             location.href=raiz_central+"menu.php";
         }
         return;        
    }        

    /// Caso tenha cancelado a Anotacao - LIMPAR
    if( idselecproj.toUpperCase()=="CANCELAR" ) {                 
         /// Caso tenha cancelado a alteracao da Anotacao do Projeto
         if( idopcao.toUpperCase()=="LIMPAR" ) {
              /// RETORNAR A PAGINA ALTERAR ANOTACAO DO PROJETO
              location.href=pagina_local;
         } else {
              ///  Voltar para o inicio da Tag Select  id  - selectedindex
              if( document.getElementById('busca_proj') ) {
                    document.getElementById('busca_proj').options[0].selected=true;
                    document.getElementById('busca_proj').options[0].selectedIndex=0;
              }
              ///
              if( document.getElementById('div_out') ) {
                    document.getElementById('div_out').innerHTML="";                                                                  
                    document.getElementById('div_out').style.display="none";                                        
              }
         }
         return;
     }
     ///
     /// tag Select para desativar o campo Select ordenar
     var quantidade=idselecproj.search(/BUSCA_PROJ|busca_porcpo/i);
     if( quantidade!=-1 ) {
         ///  Caso idopcao estiver  nula
         if( idopcao.length<1 )  {
             ///  Retornar na pagina - reset 
             location.href=pagina_local;
              return;
         }
         /// Limpando o cabecalho da pagina  
         if( document.getElementById("label_msg_erro") ) {
              document.getElementById("label_msg_erro").style.display="block";
              document.getElementById("label_msg_erro").innerHTML="";                                                                                                                              
         }    
         ///
         if( document.getElementById("ordenar") ) {
              document.getElementById("ordenar").selectedIndex="0";
              document.getElementById("ordenar").style.display="none";            
         }  
     }    
     ///
     /// BOTAO - TODAS ANOTACOES
     if( idselecproj.toUpperCase()=="TODAS" ) {
         var lcopcao = idopcao.toUpperCase();
         var quantidade= lcopcao.search(/TODOS|TODAS/i);
         if( quantidade!=-1 ) {
             if( document.getElementById("ordenar") ) {
                  document.getElementById("ordenar").style.display="block";            
             } else {
                 alert("Faltando document.getElementById(\"ordenar\") ");           
             }
            /*
            if( document.getElementById("busca_proj") ) {
                  document.getElementById("busca_proj").selectedIndex="0";
            } 
            */
            ///
            return;
         }
     }
     /// 
    var idselecproj_pos = idselecproj.search(/DESCARREGAR|DETALHES|SUBSTITUIR|SUBMETER|BUSCA_PROJ|Ordenar/i); 
    /// if( idselecproj!="DESCARREGAR" &&  idselecproj!="DETALHES"  &&  idselecproj!="SUBSTITUIR"  ) {
    
////  alert("AQUI LINHA/513  <<<<<<<<  idselecproj_pos  = "+idselecproj_pos);    
    
    if( idselecproj_pos==-1  ) {
       if( typeof(idopcao)=='undefined' ) var op_selanot="";
       if( typeof(idopcao)!='undefined' ) var op_selanot=idopcao.toUpperCase();
       if( op_selanot=="TODOS" ) {
            var op_selcpoid = "";
            var op_selcpoval = "";
            var doc_elemto = document.getElementById(idselecproj);    
            var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
            var op_projcod = op_selecionada.value;
            var op_projdesc = op_selecionada.text;
       } else {
            var doc_elemto = document.getElementById(idopcao);    
            var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
            var op_selcpoid = op_selecionada.text;
            var op_selcpoval = op_selecionada.value;
       }        

    }
    ///    
    ///  Enviando os dados
    if( idselecproj.toUpperCase()=="SUBMETER" ) {
         var frm = string_array;
         var m_elements_total = frm.length; 
         ///
         ///  Desativar mensagem
         if( document.getElementById('label_msg_erro') ) {
             document.getElementById('label_msg_erro').style.display="none";   
         }
         var m_erro = 0; var n_coresponsaveis= new Array(); 
         var n_i_coautor=0;   var n_senhas=0;  var n_testemunhas=0; 
         var n_datas=0; var arr_dt_nome = new Array(); var arr_dt_val = new Array();
         var campo_nome="";  var campo_value=""; var m_id_value="";
         for( i=0; i<=m_elements_total; i++ ) {      
            //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
            var m_id_name = frm.elements[i].name;
            var m_id_type = frm.elements[i].type;
            var m_id_title = frm.elements[i].title;
            // var m_id_value = frm.elements[i].value;
            //  var m_id_value = frm.elements[i].value;
            //   Descartando o titulo do Projeto                     
            if( m_id_name.toUpperCase()=="PROJETO_TITULO" ) continue;
    
 ///  alert("anotacao_alterar.php/326 -  cpo#"+i+"  nome="+m_id_name+"  tipo="+m_id_type+"  valor="+frm.elements[i].value)
 
            ///  SWITCH para verificar o  type da  tag (campo)            
             switch (m_id_type) {
                  case "undefined":
                  //  case "hidden":                 
                  //  case "button":
                  case "image":
                  case "reset":
                  continue;
             }
             //  ALERT - para testar o FORM do EXPERIMENTO
             //  alert(" m_id_name = "+m_id_name+" -  m_id_type = "+m_id_type)
             if ( m_id_type== "checkbox" ) {
                //Verifica se o checkbox foi selecionado
                if( ! elements[i].checked ) var m_erro = 1;
             } else if ( m_id_type=="password" ) {
                 // Verifica se a Senha foi digitada
                 m_id_value = trim(document.getElementById(m_id_name).value);
                 if( m_id_value.length<8 ) {
                     var m_erro = 1;      
                 }                 
             } else if( m_id_type=="text" ) {  
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value=="" ) {
                      var m_erro = 1;       
                  }                  
             } else if( m_id_type=="hidden" ) {  
                  m_erro=0;
                  m_id_value = trim(document.getElementById(m_id_name).value);
             } else if( m_id_type=="button" ) {  
                  if( m_id_name.toUpperCase()=="SUBSTITUIR" ) continue;
             } else if( m_id_type=="textarea" ) {  
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value=="" ) var m_erro = 1;     
             }  else if( m_id_type=="select-one" ) {  
                  var m_id_name_upper=m_id_name.toUpperCase();
                  if( m_id_name=="anotacao_select_projeto" || m_id_name_upper=="ALTERA_COMPLEMENTA" ) continue;
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value=="" ) var m_erro = 1;    
                  /// Verificando os campos das testemunhas do Experimento
                  if( ( m_id_name_upper=="TESTEMUNHA1" ) || ( m_id_name_upper=="TESTEMUNHA2" ) ) {
                      if( m_id_name_upper=="TESTEMUNHA1" ) {
                           var confirm_text = "Testemunha1";
                      } else if( m_id_name_upper=="TESTEMUNHA2" ) {
                           var confirm_text = "Testemunha2";
                      }
                      if( m_id_value=="" ) {      
                            var decisao = confirm("Selecionar "+confirm_text+"?");
                            if ( decisao ) {
                                m_erro = 1;
                            } else {
                                m_erro = 0;
                            }
                      } else {
                          n_testemunhas=n_testemunhas+1;
                      }
                      ///
                  }
                 //
             } else if( m_id_type=="file" ) {  
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value==""  ) {
                      var m_erro = 1;    
                  } else {
                    var tres_caracteres = m_id_value.substr(-3);  
                    var pos = tres_caracteres.search(/pdf/i);
                    // Verificando se o arquivo formato pdf
                    if( pos==-1 ) {
                        m_erro=1; m_id_title="Arquivo precisa ser no formato PDF.";
                    }
                  }
             }
             /*  Verificando os coautores ou colaboradores
             var pos = m_id_name.search(/ncoautor/i);
             if( pos!=-1 ) {
                      m_id_value = trim(document.getElementById(m_id_name).value);
                     n_coresponsaveis[n_i_coautor]=m_id_value;
                     n_i_coautor++;
             }              
             */
             //  Verifica botao final
             var pos_botao_final = m_id_name.search(/ALTERAR|ENVIAR/i);            
             //  if( m_id_name.toUpperCase()=="ENVIAR" ) {
             //  if( m_id_name.toUpperCase()=="ENVIAR" || m_id_name.toUpperCase()=="ALTERAR" )  {           
             if( pos_botao_final!=-1 ) {
                  //  Verificando as testemunhas
                 if( ( n_testemunhas==2 ) && ( m_erro<1 ) ) {
                        //  You can define the comparing function here. 
                          //  JS default uses a crappy string compare.                      
                        var duplicado = 0;
                        var m_testemunha1=trim(document.getElementById("testemunha1").value); 
                        var m_testemunha2=trim(document.getElementById("testemunha2").value); 
                        if( m_testemunha1==m_testemunha2  ) {
                              duplicado=1;
                            var m_id_title="Duplicado"; 
                            var m_erro=1;
                        } 
                 }
                 //                              
             }
             //
             //  IF quando encontrado Erro
             //  Quando for campo sem title passar sem erro
             if( m_id_title.length<1 ) m_erro=0;
             
             //  Verificando a data  FINAL
             var m_datas = /(datafinal|datafin|data_fin)/i;
             if( m_datas.test(m_id_name) )  {
                 if( m_id_value=="" ) m_erro=0;    
             } 
             //  FINAL da verificacao do campo data final
             if( m_erro==1 ) {
                  document.getElementById("label_msg_erro").style.display="block";
               //   document.getElementById("msg_erro").style.display="block";
             //     document.getElementById("msg_erro").innerHTML="";
                  var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                  msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                   var final_msg_erro = "&nbsp;</span></span>";
                  m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                  //  document.getElementById("msg_erro").innerHTML=msg_erro;    
                  document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                  //  frm.m_id_name.focus();
                  //  document.getElementById(m_id_name).focus();
                  break;
             }
             ///
             campo_nome+=m_id_name+",";  
             campo_value+=m_id_value+",";

             /*            var testecponv = campo_nome+"\r\n  "+campo_value;
           alert("anotacao_alterar.php/462 -  pos_botao_final = "+ pos_botao_final+" - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro+"\r\n\r\n"+testecponv)            
*/
             
             ///  if( m_id_name.toUpperCase()=="ENVIAR" )  break;
             /// if( m_id_name.toUpperCase()=="ENVIAR" || m_id_name.toUpperCase()=="ALTERAR" )  {           
             if( pos_botao_final!=-1 )  break;   
         }         
        //  document.form.elements[i].disabled=true; 
         if( m_erro==1 ) {
              return false;
         }
    }  
    ///  FINAL do IF SUBMETER
        
    
/// alert(" anotacao_alterar.php/473 -  idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array)         
 
     ///  Verificando o campo da tag Select para escolher Projeto
     /***
    if( document.getElementById("busca_proj") ) {
       var cpo_val = document.getElementById("busca_proj").value;
       if( cpo_val=="" ) {
              //  ERRO
              var m_id_title="Selecione primeiro o Projeto";
              document.getElementById("label_msg_erro").style.display="block";
              document.getElementById("label_msg_erro").innerHTML="";
              var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
              msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
              var final_msg_erro = "&nbsp;</span></span>";
              var m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
              msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
              document.getElementById("label_msg_erro").innerHTML=msg_erro;    
              return false;
       } else {
             document.getElementById("label_msg_erro").innerHTML="";
             document.getElementById("label_msg_erro").style.display="none";    
       }
    }
     ***/

 ///  alert(" anotacao_alterar.php/495 -  idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array+" \r\n  ")      
          
    /*   Iniciando o AJAX para selecionar os usuarios desejados  */
    var xAJAX_alteraranot = new XHConn();
        
    if ( !xAJAX_alteraranot ) {
          alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    //
    // Define o procedimento para processamento dos resultados dp srv_php
    var fndone_alteraranot = function (oXML) { 
          //  Recebendo o resultado do php/ajax
          var srv_ret = trim(oXML.responseText);
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);
          
////  alert(" anotacao_alterar.php/510 -  lnip =  "+lnip+"  \r\n idselecproj = "+idselecproj+"\r\n\r\n - Recebendo resultado do srv_alteraranot="+srv_ret)
          
          if( lnip==-1 ) {
              if( idselecproj=="DESCARREGAR" ) {
                  if( document.getElementById("div_out") ) {
                      document.getElementById("div_out").style.display="block";                  
                      document.getElementById('div_out').innerHTML=srv_ret;
                  }                 
                 /*
                 alert("\r\nCaso o Internet Explorer bloqueie o download, fa?a o seguinte:\r\n\r\n Op??o - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Op??es do Internet Explorer e clique na aba Seguran?a.\r\n 2 - Clique no bot?o N?vel Personalizado e dentro de Configura??es de Seguran?a, localize o recurso Downloads \r\n3 - Em: Aviso autom?tico para downloads de arquivo e selecione Habilitar")
                 srv_ret = trim(srv_ret);
                 var array_arq = srv_ret.split("%");
                 self.location.href="../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                 */
              } else if( idselecproj=="DETALHES" ) {
                  var myArguments = trim(srv_ret);
                  
 ////    alert("  anotacao_alterar.php/322 -  CORRIFIR  ---  idselecproj = "+idselecproj+"\r\n ->  myArguments = "+myArguments);
          
                 return;
                 
             ////   var showmodal =  window.showModalDialog("myArguments_anotacao.php?myArguments="+myArguments,myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                  if( window.showModalDialog ) { 
                       var showmodal =  window.showModalDialog("myArguments_anotacao.php",myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                  } else {
                       ///  Ativando ID anotacao_escolhida
                       exoc("anotacao_escolhida",1,myArguments);                   
                  }                       
                  /***
                  if ( showmodal != null)  {                                                                                                                
                       var array_modal = showmodal.split("#");
                       if( document.getElementById('div_form')  ) {
                             if( document.getElementById('id_body')  ) {
                                  document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                             }    
                             document.getElementById('div_form').innerHTML=showmodal;
                       }                                                                                           
                  } 
                  ***/   
              }  else  if( idselecproj.toUpperCase()=="BUSCA_PROJ" ) {
                     ///  Ativando function ativar
                    ativar(srv_ret);
                    return;
              } else if( idselecproj=="SUBSTITUIR" ) { 
                    //  Recebe os dados do Anotador Substituto - codigousp e nome
                    // sempre fazer desse jeito o search definindo posicao
                    var pos = srv_ret.search(/#/); 
                    if( pos!=-1 ) {
                        var partes=srv_ret.split("#");
                        
          ////      alert("  anotacao_alterar.php/355 - idselecproj = "+idselecproj+"\r\n ->   \r\n \r\n   srv_ret = "+srv_ret+" -- partes[0] = "+partes[0]+" -- partes[1] = "+partes[1]);   
                
                        if( document.getElementById("substituir") ) {
                            document.getElementById("substituir").style.display="none";                  
                        }                    
                        //
                        if( document.getElementById("autor") ) document.getElementById("autor").value=partes[0];
                        if( document.getElementById("anotador_nome") ) document.getElementById("anotador_nome").innerHTML=partes[1];
                    }   
              } else  if( idselecproj.toUpperCase()=="SUBMETER" ) {                  
                    //  Depois de Alterada a Anotacao
                   document.getElementById('label_msg_erro').style.display="block";    
                   //  OCULTANDO as divs:  div_form e div_out
                   if( document.getElementById('div_form') ) {
                         document.getElementById('div_form').style.display="none";  
                         if( document.getElementById('div_out') ) document.getElementById('div_out').style.display="none";  
                   }     
                   //  Recebendo o Nr. Projeto, Nr. Autor Projeto,  nome do arquivo em PDF e Nr. da Anotacao
                   var test_array = srv_ret.split("falta_arquivo_pdf");
                   if( test_array.length>1 ) {
                          var m_dados_recebidos=test_array[0];
                          var n_co_autor = test_array[1].split("&");
                          
                           //  Passando valores para tag type hidden
                           document.getElementById('nprojexp').value=n_co_autor[0];
                           document.getElementById('autor_cod').value=n_co_autor[1];
                           //  Nome do Arquivo em PDF - campo relatext
                           var arquivo_pdf = n_co_autor[2];
                          /*   FORA
                          if(  n_co_autor.length>2 ) {
                               //  ID da pagina anotacao_cadastrar.php
                               if( document.getElementById('anotacao_numero') ) {
                                  document.getElementById('anotacao_numero').value=n_co_autor[2];                                               
                               }  
                          }
                          */
                   } else  m_dados_recebidos=test_array[0];
                   ///
                   document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                   //    srv_ret=test_array[0];
                   //    document.getElementById('label_msg_erro').innerHTML=srv_ret;
                   // Verificar pra nao acusar erro
                   if( document.getElementById('arq_link') ) {
                        document.getElementById('arq_link').style.display="block";        
                   }

 /*
         alert(" anotacao_alterar.php/648  CONTINUAR DAQUI -  lnip =  "+lnip+"  \r\n idselecproj = "+idselecproj+"\r\n\r\n - Recebendo resultado do srv_alteraranot="+srv_ret+"  \r\n\n  n_co_autor =  "+n_co_autor+"  -  n_co_autor[0] = "+n_co_autor[0]+"  -  n_co_autor[1] = "+n_co_autor[1]+"  -  n_co_autor[2] = "+n_co_autor[2]+"  -  n_co_autor[3] = "+n_co_autor[3])
                   */       
              } else {
                   document.getElementById('label_msg_erro').style.display="block";    
                   // document.getElementById('div_out').style.display="none";
                   if( document.getElementById("div_out") ) {
                       document.getElementById("div_out").style.display="block";                  
                       document.getElementById('div_out').innerHTML=srv_ret;
                   }                 
              }
          } else {
                 ///
                if( idselecproj.toUpperCase()=="TODOS"  || idselecproj.toUpperCase()=="BUSCA_PROJ" )  {
                     /// Separando a mensagem recebida
                     var pos1 = srv_ret.search(/INICIA/i);
                     var pos2 = srv_ret.search(/FINAL/i);
                     if( pos1!=-1 && pos1!=-2  ) {
                          srv_ret = srv_ret.replace(/ERRO:|CORRIGIR_ERRO:|INICIA|FINAL/ig,"");                      
                     }
                }
                ///
                if( idselecproj.toUpperCase()=="BUSCA_PROJ" ) { 
                     if( document.getElementById("div_form") ) {
                          document.getElementById("div_form").style.display="block";
                     } 
                     ///
                    ///  Ocutando ID id_anotacao - CASO EXISTA
                    if( document.getElementById("id_anotacao") ) {
                        if( document.getElementById("id_anotacao").style.display="block"  ) {
                              document.getElementById("id_anotacao").style.display="none";   
                        }     
                    }
                    ///
                } else {
                    var pos3 = srv_ret.search(/DUPLICATA:/i);
                    if( pos3!=-1 ) {
                        srv_ret = srv_ret.replace(/DUPLICATA:/ig,"");                      
                        if( document.getElementById("div_form") ) {
                              document.getElementById("div_form").style.display="block";   
                        }
                    }
                    /****
                     else {

                        if( document.getElementById("div_form") ) {
                             document.getElementById("div_form").style.display="none";   
                        }
                    } 
                    ***/
                    ///
                }   
               /// if( document.getElementById("div_out") )   document.getElementById("div_out").style.display="none";
                ///
                document.getElementById('label_msg_erro').style.display="block";
                document.getElementById('label_msg_erro').innerHTML=srv_ret;
         }; 
    };
    /// 
    ///  Define o servidor PHP para consulta do banco de dados
    var srv_php = "srv_alteraranotacao.php";
    var poststr = new String("");
    /*
    if( idselecproj.toUpperCase()=="DETALHES" ) {
        alert(" Final  anotacao_consultar.php/170 -  idselecproj = "+idselecproj+" --  idopcao  =  "+idopcao+" - string_array = "+string_array)      
    } */
        
   //  alert("anotacao_alterar.php/641 -idselecproj.toUpperCase() = "+idselecproj.toUpperCase())

    //  DESCARREGAR - UPLOAD abrindo o arquivo pdf e  Detalhes da Anotacao do Projeto
    // if( idselecproj.toUpperCase()=="DESCARREGAR" || idselecproj.toUpperCase()=="DETALHES"   ) {
    var encontrado=idselecproj.search(/BUSCA_PROJ|ordenar/i);  
    ///  Caso encontrou um dos tres nomes 
    if( encontrado!=-1 ) {
           var browser="";
           if( typeof navegador=="function" ) {
                  var browser=navegador();
           }  
           ///
           var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array)+"&navegador="+browser; 
    } else {
        if( idselecproj.toUpperCase()!="SUBMETER" )  {
            if( idselecproj_pos!=-1  ) {
                 var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
            }  else {
                var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoanot="+encodeURIComponent(op_selanot)+"&op_selcpoid="
                        +encodeURIComponent(op_selcpoid)+"&op_selcpoval=" +encodeURIComponent(op_selcpoval) ;
            }
        } else {
             ///  Enviando os dados dos campos para o AJAX
            /// if( m_value_coresponsaveis>0 ) {
             if( n_testemunhas>0 ) {
                 var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value)+"&m_array="+encodeURIComponent(n_testemunhas);
             } else {
                 var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);             
             }
        }
    }
    ///    

 ///  alert("Ativando final - srv_alteraranot com poststr="+poststr)

    xAJAX_alteraranot.connect(srv_php, "POST", poststr, fndone_alteraranot);   
    ///
}
///  Verifica se foi selecionado o Projeto
/****
function ativar(projeto_selec)  {
    projeto_selec = trim(projeto_selec);
    if( document.getElementById("div_out") )  {
                document.getElementById("div_out").innerHTML="";
                document.getElementById("div_out").style.display="none";      
    } 
    //
    if( document.getElementById("div_form") )   document.getElementById("div_form").style.display="block";                  
    //
    if( projeto_selec.length>0 ) {       
        document.getElementById("label_msg_erro").style.display="none";    
        document.getElementById('id_anotacao').style.display="block";
    } else {
        document.getElementById("label_msg_erro").style.display="block";    
        document.getElementById('id_anotacao').style.display="none";       
    }      
}
****/
///
</script>
<?php
///     Alterado em 20170925   
///   require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

////     Consultar Anotacao
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];    
}
///  Definindo TITULO da pagina
$_SESSION["m_titulo"]="Anota&ccedil;&atilde;o";
////        
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);" >
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
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro" >
</div>
<p class="titulo_usp" >Alterar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Mensagem de ERRO e Titulo    -->
<?php
//     Verificano o PA - Privilegio de Acesso
// if( ( $permit_pa>$_SESSION['array_usuarios']['superusuario']  and $permit_pa<=$permit_anotador ) ) {    
if( ( $permit_pa>$array_pa['super']  and $permit_pa<=$permit_anotador ) ) {    
if( strlen(trim($_SESSION["msg_upload"]))>1 ) {
?>
<script type="text/javascript" language="javascript">
    document.getElementById('label_msg_erro').style.display="block";              
    document.getElementById('label_msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";
</script>
<?php
    if( strlen(trim($_SESSION["erros"]))<1 ) $_SESSION["display_arq"]='none';
} else {
?>
<script type="text/javascript" language="javascript">
    ///  Usado somente no Cadastro de Anotacao quando inicia pagina
    ///  importante("Anotacao"); 
</script>    
<?php     
}
?>        
<!--  DIV abaixo para enviar o ARQUIVO da ANOTACAO   -->
<div  id="arq_link" style="display: <?php echo $_SESSION['display_arq'];?>;"  >
<p class="paragrafo_centrar" style="font-size: medium;" >Para substituir o arquivo original clicar abaixo.</p>
 <form name="form_arq_link" method="POST"  enctype="multipart/form-data"  action="<?php echo $pagina_local; ?>"  >
  <table border='0' cellpading='0' cellspacing='0' width='90%'>
    <tr  >
     <!-- Relatorio Externo (link) Projeto -->
      <td  class="td_inicio1" style="vertical-align: middle;"  colspan="1" >
         <label for="relatext" style="vertical-align: middle; cursor: pointer; " title="link para o Arquivo da Anota??o"   ><span class="asteristico" >*</span>&nbsp;Arquivo (link):&nbsp;</label>
        </td  >
        <td class="td_inicio2" style="vertical-align: middle; " colspan="1"  >
       <input type="hidden" name="fileframe" value="true">
           <!-- Target of the form is set to hidden iframe -->
           <!-- From will send its post data to fileframe section of this PHP script (see above) -->
     <input type="file" name="relatext"  id="relatext"  size="90" title="Relatório Externo da Anotação (link)"  style="cursor: pointer; vertical-align:middle; " onChange="javascript: jsUpload(this);"  />
           <input  type="hidden"  id="nprojexp"  name="nprojexp"    />
           <input  type="hidden"  id="autor_cod"  name="autor_cod"  />       
           <input  type="hidden"  id="anotacao_numero"  name="anotacao_numero"  />                 
           <input  type="hidden"  id="m_titulo"  name="m_titulo"  value="<?php echo $_SESSION["m_titulo"];?>" />                         </td>
       <!-- FINAL - Relatorio Externo (link) Projeto -->
     </tr>
     <tr>
      <!--  Aviso na espera do processo -->
      <td  id="aguarde_arq"  style="display:block; text-align: center; background-color: #FFFFFF; color: #000000;;"   colspan="2" >Aguarde. Esse processo pode demorar...   
       </td>
    </tr>    
    <tr>
      <td  align="center"  style="text-align: center; border:none; "  colspan="2" >
        <!-- Cancelar para substituir o arquivo da Anotacao -->                         
          <button name="cancelar" id="cancelar"  type="button"  onClick="javascript: consulta_alteraranot('APRESENTACAO','VOLTAR');"  class="botao3d" style="cursor: pointer;  width: 120px; "  title="Cancelar"  acesskey="C"  >    
               Cancelar&nbsp;<img src="../imagens/limpar.gif" alt="Cancelar" style="vertical-align:text-bottom;" >
          </button>
        <!-- Substituir o arquivo da Anotacao -->                  
          <button  type="submit" name="enviar_arq" id="enviar_arq"  class="botao3d" 
             style="width: 160px; cursor: pointer;"  
             onclick="javascript: if( trim(document.getElementById('relatext').value)=='') { alert('Importante: informar arquivo para alterar'); document.getElementById('relatext').focus(); return false; }"              
             title="Enviar"  acesskey="E"  alt="Enviar"     >    
         Enviar arquivo&nbsp;<img src="../imagens/enviar.gif" alt="Enviar Arquivo"  style="vertical-align:text-bottom;"  >
         </button>
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
    // Este e apenas um exemplo de verificacao de extensoes de arquivo
    //  var re_text = /\.txt|\.xml|\.zip/i;
    var re_text = /\.pdf/i;
    var filename = upload_field.value;

    /* Checking file type */
    if (filename.search(re_text) == -1)  {
        //  alert("File does not have text(txt, xml, zip) extension");
        alert("ERRO: Esse arquivo não tem formato PDF");
       document.getElementById('relatext').focus();
        //  upload_field.form.reset();
        return false;
    }
  /*
    upload_field.form.submit();
    document.getElementById('upload_status').value = "uploading file...";
    upload_field.disabled = true;
    return true;
    */
}
</script>
</div>
<!--  DIV abaixo os Dados Antes de pedir o Arquivo para Upload   -->
<div id="div_form" class="div_form" style="overflow:auto;" >
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" style="text-align: center; width:100%;font-size:medium;font-weight: bold;" >Selecione o Projeto:&nbsp;
</p>
</div>
<?php 
/// Selecionando o Projeto do Orientador/Usuario
# Aqui está o segredo
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
///
if( $permit_pa<=$permit_orientador ) {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." a.codigousp=".$usuario_conectado." order by b.titulo ";
} else {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." b.cip in (select distinct cip from $bd_2.anotador "
        ." where codigo=".$usuario_conectado.")  order by b.titulo ";
}
$result = mysql_query($sqlcmd); 
///  Verificando se houve erro no Select/MySql                  
if( ! $result ) {
    //  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
    /* $msg_erro .= "Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} - db/mysql:&nbsp; ".mysql_error();
    echo $msg_erro.$msg_final;  */            
    //  Parte do Class                
    echo $funcoes->mostra_msg_erro("Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} - db/mysql:&nbsp; ".mysql_error());
    exit();                  
}
///  Numero de Projetos Selecionados
$nprojetos = mysql_num_rows($result);
///
?>
<div class="div_select_busca"  >
<select name="busca_proj" id="busca_proj"  title="Selecione o Projeto para Busca de Anota&ccedil;&otilde;es" 
   onchange="javascript: consulta_alteraranot(this.id, this.value,this.value);"  >
    <!-- Identificacao do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
    <?php 
        /// Verifica se NAO tem projeto  ou 
        if( intval($nprojetos)<1 ) {
              echo "<option value='' >N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.</option>";
        } else {
              echo "<option value='' >Selecione o Projeto a ser acessado por esse {$_SESSION["usuario_pa_nome"]} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
              ////
              while( $linha=mysql_fetch_assoc($result) ) {
                        $_SESSION["cip"]=$linha['cip'];
                        $_SESSION["anotacao_numero"]=$linha['anotacao']+1;
                        $autor_nome = $linha['nome'];
                        /*  Desativado por nao ter valores nos campos fonterec e fonteprojid
                        $titulo_projeto = htmlentities($linha['fonterec'])."/".ucfirst(htmlentities($linha['fonteprojid']))
                                          .": ".$linha['titulo'];   */
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
                                  //  $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
                                    break;
                               }
                         }
                         ///  Definindo o Titulo do Projeto
                         $titulo_projeto="";
                         if( strlen(trim($fonterec))>=1  ) {
                               $titulo_projeto.= $fonterec."/";
                         }
                         if( strlen(trim($fonteprojid))>=1  ) {
                              $titulo_projeto.= $fonteprojid.": ";
                         }
                         $titulo_projeto .= trim($projeto_titulo_parte);                    
                        ///  Usando esse option para incluir espaco sobre linhas
                        ///  echo  "<option value='' disabled ></option>";                  
                        /*
                        echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >"
                               .utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";   
                        */
                        echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >";
                        /* IMPORTANTE: Detectar codificacao  de caracteres  - 20171005   */
                        $codigo_caracter=mb_detect_encoding($titulo_projeto);
                      ///  if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
                            //// echo utf8_decode(htmlentities($titulo_projeto))."&nbsp;&nbsp;</option>";
                           ///     echo  htmlentities("$titulo_projeto")."&nbsp;&nbsp;</option>";
                             ///   echo  $titulo_projeto."&nbsp;&nbsp;</option>";
                             /// echo utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";
                              echo $titulo_projeto."&nbsp;&nbsp;</option>";
                             /***
                        } else {
                            echo  $titulo_projeto."&nbsp;&nbsp;</option>";                                  
                        }
                        ***/
                        ////    
              }
        }
        ?>
        </select>
</div>
<?php
///   Conectar - CODIGO/USP
///  $elemento=5; $elemento2=6;
///
//  Selecionar as anotacoes de projeto pelo campo desejado
$opcao_cpos = Array("ano_inicio","ano_final","anotacao") ;
$opcao_ncpos = count($opcao_cpos);                
//
///  Salvar letrais iniciais em um conjunto para facilitar a busca
/////  $m_anotacoes=utf8_decode("Anotações");
$m_anotacoes="Anotações";
///
?>
<div id="id_anotacao" style="display: none;text-align: center;" >
<p class="titulo_usp2" >
Mostrar&nbsp;<?php echo $m_anotacoes;?>&nbsp;</p>
<div align="center" style="padding-top:0px; padding-bottom: 5px;margin-left: 40%;margin-right: 40%;" >
 <!-- tag Select para ordenar  -->
<select  title="Ordernar"  id="ordenar" class="ordenar"   onchange="javascript:  consulta_alteraranot('ordenar',busca_proj.value,this.value)"  >
<option  value=""  >Ordenar por</option>
<option  value="data asc"  >Data - asc</option>
<option  value="data desc"  >Data - desc</option>
<option  value="titulo asc"  >Título - asc</option>
<option  value="titulo desc"  >Título - desc</option>
</select>
<!--  Final - tag Select para ordenar  -->
</div>   
<p class='titulo_usp2' style='margin: 0px; padding: 2px 0px 0px; line-height:normal;' >Lista de Anota&ccedil;&otilde;es de Projeto</p>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
<div  style="position:relative;  display:flex; ">
<!-- id div_out  -->
<section style="float: left;width:100%;" >
<article id="div_out" style="width:100%; overflow: auto; ">
</article>
<!-- Final - id div_out  -->
<!--  ID - Anotacao escolhida -->
<article  id="anotacao_escolhida" >
</article>
</section>
<!-- Final - Anotacao escolhida -->
</div>
</div>
<!-- Final - id id_anotacao -->
</div>
<!-- Final div_form  -->
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("{$incluir_arq}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>


