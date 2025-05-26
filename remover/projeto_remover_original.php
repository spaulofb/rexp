<?php 
/*  
    EDITANDO: LAFB/SPFB120119.0934

    REXP - REMOVER PROJETO   
 
    LAFB/SPFB120119.2219
*/
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///
extract($_POST, EXTR_OVERWRITE); 
///
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
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
***/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");

///  Variavel recebida do script/arquivo - inicia_conexao.php 
$_SESSION["m_horiz"] = $array_projeto;
///
///   Alterado em 20180611
/////  if( isset($_SESSION["permit_pa"]) ) $permit_orientador = (int) $_SESSION["permit_pa"];  
////  if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado = $_SESSION["usuario_conectado"];
//
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
// $_SESSION['time_exec']=180000;

///  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
///
/*  UPLOAD: FILEFRAME section of the script
      verifica se o arquivo foi enviado      */
$_SESSION["display_arq"]='none';
$_SESSION["div_form"]="block";
$_SESSION["result"]=''; 
$_SESSION["msg_upload"]="";
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
///  fileframe - tag iframe  type hidden
if( isset($_POST['fileframe']) ) {
  $_SESSION["div_form"]="none";
   ///  include("../includes/functions.php");
  include("{$_SESSION["incluir_arq"]}includes/functions.php");  
  
  ///  NOME TEMPOR?RIO NO SERVIDOR
  if( isset($_FILES['relatproj']['tmp_name']) ) {
      $_SESSION["result"]='OK'; $erros="";
      $_SESSION["display_arq"]='block';
      /** Conjunto de arquivos - ver tamanho total dos arquivos ***/
      $tam_total_arqs=0; $files_array= array(); 
	  $conta_arquivos = count($_FILES['relatproj']['tmp_name']);	
	  //  Verificando se existe diretorio
      $msg_erro =  "<p "
			   ." style='text-align: center; font-size: small; font-family: Verdana, Arial, Helvetica, sans-serif, Times, Georgia; font-weight:bolder;' >";
      $msg_erro_final = "</p>";
     if( intval($conta_arquivos)<1 ) {
         $_SESSION["msg_upload"] = $msg_erro."ERRO: Falta INDICAR o arquivo.".$msg_erro_final;
	     $_SESSION["result"]='FALSE'; $erros="ERRO";
     }
	//    Esse For abaixo para acrescentar diretorios caso nao tenha
    //  if ( $tamanho_dir[0]<1  or  !file_exists($_SESSION[dir]) ) {  //  Tem que ser maior que 8 bytes
	for( $n=1; $n<3 ; $n++ ) {
       ///  if( $n==1 )	$_SESSION[dir] = "/var/www/html/rexp3/doctos_img/A".$_POST[autor_cod];
       if( $n==1 )  $_SESSION[dir] = "/var/www/html".$_SESSION[pasta_raiz]."doctos_img/A".$_POST[autor_cod];
       if( $n==2 )	$_SESSION[dir] .= "/projeto/";	   
	   if(  !file_exists($_SESSION[dir]) ) {  //  Verificando dir e sub-dir
            $r = mkdir($_SESSION[dir],0755);
	        if ( $r===false ) {
    			 //  echo  $msg_erro;
				 $_SESSION["msg_upload"] = $msg_erro."Erro ao tentar criar diret&oacute;rio".$msg_erro_final;
				 //  die("Erro ao tentar criar diret&oacute;rio");
			 	 $_SESSION["result"]='FALSE';  $erros='ERRO';
		    } else  chmod($_SESSION[dir],0755);							        			
	   }
	}   
    //
    $tamanho_dir = shell_exec("/usr/bin/du  ".$_SESSION[dir]);  // tamanho em bytes do diretorio
    $tamanho_dir = explode("/",$tamanho_dir);
    if( intval($conta_arquivos)>1 ) {
          for($i=0; $i < $conta_arquivos  ;$i++) $tam_total_arqs += $_FILES[relatproj][size][$i];   
     } else $tam_total_arqs = $_FILES[relatproj][size];
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
  		$max_file_size = 524288000; // bytes - B
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
	         $_SESSION["msg_upload"] = $msg_erro.$result_msg.$msg_erro_final;
		} 
        /** loop atraves do conjunto de arquivos ***/
        //  for($i=0; $i < count($_FILES['userfile']['tmp_name']);$i++)  {
        //  verifica se o arquivo esta no conjunto (array)
        if( !is_uploaded_file($_FILES[relatproj][tmp_name]) ) {
			   // $messages[]="Arquivo n&atilde;o armazenado\n"; 
			   $_SESSION["msg_upload"] = $msg_erro."Arquivo n&atilde;o armazenado\n".$msg_erro_final;
         		//  $erros[]='ERRO';
				$erros='ERRO';
        } elseif( $_FILES[relatproj][tmp_name] > $max_file_size )  {
              // verifica se o arquivo menor que o tamanho maximo permitido
              $_SESSION["msg_upload"]= $msg_erro."O arquivo excedeu o tamanho limite permitido $max_file_size $tipo_tamanho ";
			  $_SESSION["msg_upload"].=$msg_erro_final;
			  $erros = 'ERRO';
        } else {
                // copia o arquivo para o diretorio especificado
				 //  $filename=$_FILES['userfile']['name'][$i];
				 //  $filename=$_FILES[relatproj][name];
				 $filename="P".$_POST[nprojexp]."_".$_FILES[relatproj][name];
				 if( @copy($_FILES[relatproj][tmp_name],$_SESSION[dir].$filename) )  {
                     /*** give praise and thanks to the php gods ***/
					 $erros='';
                     //  $messages[] = $_FILES[relatproj][name].' armazenado&nbsp;'; 
                     $_SESSION["msg_upload"]= $msg_erro."Arquivo: ".$_FILES[relatproj][name].' foi armazenado&nbsp;';
         			 $_SESSION["msg_upload"].=$msg_erro_final;
					 $files_array[]=$_FILES[relatproj][name];
					 $files_size[]=$_FILES[relatproj][size];
					 //  filemtime ? Obt?m o tempo de modifica??o do arquivo
            	     $files_date[] = date('d/m/Y H:i:s', filemtime($_SESSION[dir].$filename));
					 $files_type[] = mime_type($filename);
					// Permissao do arquivo
					 chmod($_SESSION[dir].$filename,0755);									
                } else  {
                     /***  an error message  ***/
                     //  $messages[] = 'Armazenamento '.$_FILES[relatproj][name].' FALHA';
                     $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES[relatproj][name].' FALHA';
         			 $_SESSION["msg_upload"].=$msg_erro_final;
		     	     $erros = 'ERRO';
                }
		}
     } ///  FINAL - IF  \$_SESSION["result"]
	 //
     $_SESSION["erros"] = trim($erros);
	 //   Incluindo o nome do arquivo na tabela  projeto
     if( trim($erros)=='' ) {
           //  OCORREU  ERRO NESSA JANELA DO JAVASCRIPT
          //  OCORREU  echo "<p style='text-align: center;'>Aguarde um momento.</p>";
          //
	      	$elemento=5;  $elemento2=6; 
		    /// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
            include("php_include/ajax/includes/conectar.php");
			$db_select = mysql_select_db($db_array[$elemento],$lnkcon);
			//  $local_arq0 = $_SESSION[dir].$filename;
			$nprojexp = $_POST[nprojexp]; $autor_cod = $_POST[autor_cod];
			$local_arq  = html_entity_decode(trim($filename));
           //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
     	    $success = mysql_query("UPDATE  $bd_2.projeto SET relatproj='$local_arq'  "
			              ." where ( numprojeto=$nprojexp  and  autor=$autor_cod ) ");
			//
			if( ! $success ) {
                $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES[relatproj][name].' FALHA'.mysql_error();
   			    $_SESSION["msg_upload"].=$msg_erro_final;		
			} else {
                 mysql_free_result($success);
                 $success=mysql_query("SELECT nome from $bd_1.pessoa where codigousp=$autor_cod  ");
                 $_SESSION["msg_upload"] .= $msg_erro."Projeto $nprojexp do autor ".mysql_result($success,0,0)." foi conclu&iacute;do.";
				 $_SESSION["msg_upload"] .=$msg_erro_final;		    
            }		  
	}
  } // isset(\$_FILES[relatproj][tmp_name])
}  
///  FINAL do IF UPLOAD  
///
?>
<!DOCTYPE html>
<html lang="pt-BR" >
<head>
<meta charset="UTF-8" />
<meta name="author" content="Sebastião Paulo" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Remover Projeto</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
$_SESSION["n_upload"]="ativando";
///
?>
<script  language="javascript"  type="text/javascript" >
/* 
///      JavaScript Document
     PARA REMOVER PROJETO
*******************************************************/
///                                                                                                                         
/****  
    Define o caminho HTTP  -  20180611
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
/*****************  Final  -- function acentuarAlerts(mensagem)   ***************************/
///
///   Function principal para arquivo AJAX
function remove_projeto(idselecproj, idopcao,string_array) {
//
//  Selecionar o PROJETO de acordo com a op??o 
//
//  LAFB/SPFB120119.0917
//
//  Parametros:
//      idselecproj = Identifica??o do Select de escolha do projeto
//      idopcao     = Identifica??o da Op??o de sele??o das Anota??es (TODOS, select (ano_incio, ano_final, anota??o)
//
///  Prepara os parametros para ativacao  do srv_php
/// Determina qual opcao  do Select <idselecproj> foi selecionada:
   /// Verificando se a function exoc existe
    if( typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe");
    }
    ///  Desativando ID  projeto_escolhido
    exoc("projeto_escolhido",0,"");                   
    
///  alert("projeto_remover/296  -- idselecproj = "+idselecproj+"   - idopcao = "+idopcao+"  --- string_array = "+string_array);    

    ///
    ///  Verificando variaveis
    if( typeof idselecproj=="undefined" ) {        
         idselecproj="";
    }
    /// Copiando variavel
    var tcopcao=idselecproj; 
    ///    Parte importante para o programa com o arquivo AJAX
    if( typeof(idopcao)=="undefined" ) var idopcao=""; 
    if( idopcao.toUpperCase()!="LIMPAR" )  var val=idopcao;
    ///
    if( typeof(string_array)=="undefined" ) var string_array=""; 
    //// Verifica se a variavel e uma string
    var nr_projeto=0;
    if( typeof(string_array)=='string' ) {
           //  src = trim(string_array);
           //  string.replace - Melhor forma para eliminiar espa?os no comeco e final da String/Variavel
           var string_array = string_array.replace(/^\s+|\s+$/g,"");        
           var string_array_maiusc = string_array.toUpperCase();     
           var pos = string_array.indexOf("#@=");   
           if( pos!=-1 ) {  
               //  Criando um Array 
               var array_string_array = string_array.split("#@=");
               if(array_string_array.length==4) nr_projeto=array_string_array[3];
               /*  var teste_cadastro = array_string_array[1];
               var  pos = teste_cadastro.search("incluid");
                */
           }
    }  else if( typeof(string_array)=='number' && isFinite(string_array) )  {
           var string_array = string_array.value;                
    }
    ///  var opcao=idselecproj.toUpperCase();    
    var opcao_maiusc=idselecproj.toUpperCase();    
    /****  
         Define o caminho HTTP    -  20180605
    ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       

///  alert("projeto_remover/335  -- idselecproj = "+idselecproj+"   --->> idopcao = "+idopcao+"  --- string_array = "+string_array);         

    ///  Retornar pagina
    if( opcao_maiusc=="REINICIAR_PAGINA" ) {    
          location.reload();
          return;
    }        
    ///    
    /// BOTAO - TODOS
    var lcopcao = tcopcao.toUpperCase();
    var quantidade= lcopcao.search(/TODOS|TODAS/i);    
    if( quantidade!=-1 ) {
        if( document.getElementById("ordenar") ) {
            ///  Incluido em 20180419
            /// var melement=document.getElementById("ordenar");
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
    ///  
    /// tag Select para Ordenar o Botao Todos
    var quantidade=lcopcao.search(/ORDENAR/i);
    if( quantidade!=-1 ) {
         var tmp=val;
         var val=lcopcao;
         var lcopcao=tmp;
         ///  var string_array=string_array.replace(" ","");      
        if( document.getElementById("busca_proj") ) {
              document.getElementById("busca_proj").selectedIndex="0";
        }    
        if( document.getElementById("busca_porcpo") ) {
              document.getElementById("busca_porcpo").selectedIndex="0";
        }    
        ///
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
    ////   
    if( quantidade!=-1 ) {
        if( document.getElementById("busca_proj") ) {
              document.getElementById("busca_proj").selectedIndex="0";
        }    
    }  
    /// tag Select para desativar o campo Select ordenar
    var quantidade=lcopcao.search(/BUSCA_PROJ|busca_porcpo/i);
    if( quantidade!=-1 ) {
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
    ///    
    if( opcao_maiusc=="CAMPOS_OBRIGATORIOS"  ) {
             if( idopcao.toUpperCase()=="CPF"  ) {
                   var resultado = validarCPF(string_array,idopcao);    
                   if( ! resultado ) {
                        var m_id_title = document.getElementById(idopcao).title;                   
                        document.getElementById("label_msg_erro").style.display="block";
                        var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                        msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                        var final_msg_erro = "&nbsp;</span></span>";
                        m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                        msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                        ///  document.getElementById("msg_erro").innerHTML=msg_erro;    
                        document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                        document.getElementById(idopcao).focus();                   
                        return false;                   
                   }
             }
             var poststr = "source="+encodeURIComponent(source)+"&idopcao="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
             ////
    } 
    /*
     else if( opcao_maiusc!="DESCARREGAR"  ) {
             var op_selanot = idopcao.toUpperCase();
             if ( op_selanot=="TODOS" ){
                 //  var op_projcod = "";
                 var op_projcod = "";
                 var op_selcpoid = "";
                 var op_selcpoval = "";
                 if( document.getElementById('busca_proj') ) {
                      document.getElementById('busca_proj').options[0].selected=true;
                      document.getElementById('busca_proj').options[0].selectedIndex=0;
                  }
             } else {
                 if( document.getElementById(idopcao) ) {
                     var doc_elemto = document.getElementById(idopcao);    
                     var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
                     var op_selcpoid = op_selecionada.text;
                     var op_selcpoval = op_selecionada.value;                 
                 }
             }        
    } 
    */   
    ////   
    
////  alert(" projeto_remover.php/442 ---  opcao_maiusc = "+opcao_maiusc+" -->> idopcao = "+idopcao+"  --  string_array = "+string_array);       
    
    ///  Verificando o campo da tag Select para escolher Projeto
   if( opcao_maiusc!="REMOVER_PROJETO" ) {
             /// Verificando se cancelou para Remover o Projeto
             if( opcao_maiusc=="BUSCA_PROJ" && idopcao.toUpperCase()=="LIMPAR" ) {
                    parent.location.href=raiz_central+"remover/projeto_remover.php";
                    return;
                   /*
                    if( document.getElementById('div_form') ) {
                        //  Voltar para o inicio da Tag Select  id  - selectedindex
                         document.getElementById('busca_proj').options[0].selected=true;
                         document.getElementById('busca_proj').options[0].selectedIndex=0;
                         document.getElementById('div_form').style.display="block";                                             
                         document.getElementById('div_form').innerHTML="";                                                                  
                         document.getElementById('div_form').style.display="none";   
                         return;                                          
                    }
                    */           
               }
               ///
               /***
               if( opcao_maiusc!="TODOS"  ) {
                    //  Projeto foi  Selecionado  
                    if( opcao_maiusc=="SELECIONADO" ) {
                          opcao_maiusc="BUSCA_PROJ";
                          var grupoproj = opcao_maiusc;
                          var op_projcod = idopcao;
                    } else {
                         var cpo_val = document.getElementById("busca_proj").value;
                         var op_projcod = cpo_val;
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
                         }                 
                         //
                    } 
                    ///  Final do  if( opcao_maiusc=="SELECIONADO" )       
               }  
        }
        */
    }
    /// 
    
    /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca - AJAX   */
    if ( !myConn ) {
          alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    //
     //  Verifica qual Navegador sendo usado
     var m_isChrome=isChrome().toString();
     var m_isInternetExplorer=isInternetExplorer();
    
///  alert(" projeto_remover.php/500 -->>>  arq projeto_remover.php  - m_isChrome="+m_isChrome+"  --- opcao_maiusc = "+opcao_maiusc+" -  idopcao = "+idopcao+" - string_array = "+string_array);
    
    /// Define o procedimento para processamento dos resultados dp srv_php
    var inclusao = function (oXML) { 
          //  Recebendo o resultado do php/ajax
          var srv_ret = trim(oXML.responseText);
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);          
          
///  alert(" projeto_remover.php/471 --->> lnip = "+lnip+"  --- opcao_maiusc = "+opcao_maiusc+" - lcopcao = "+lcopcao+" === lnip = "+lnip+" \r\n - Recebendo resultado do srv_rmprojeto =  "+srv_ret)

          ///  Verifica se NAO houve erro 
          if( lnip==-1 ) {
              ///                
              if( opcao_maiusc=="ORDENAR" ) {
                       /// 
                      if( lcopcao.toUpperCase()=="TODOS" ) {
                          if( document.getElementById('busca_proj') ) {
                               document.getElementById('busca_proj').options[0].selected=true;
                               document.getElementById('busca_proj').options[0].selectedIndex=0;                   
                          }
                          ////
                          document.getElementById('div_out').innerHTML=srv_ret;                
                      }   
                    ///
              } else if( lcopcao=="DETALHES" ) {
                  var myArguments = trim(srv_ret);
                  
///   alert("  projeto_remover.php/537  myArguments = "+myArguments)
                  
                  ///     var showmodal =  window.showModalDialog("myArguments_anotacao.php?myArguments="+myArguments,myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                  if( window.showModalDialog ) { 
                       var showmodal = window.showModalDialog("myArguments_projeto.php",myArguments,"dialogWidth:760px;dialogHeight:600px;dialogTop: 50px;resizable:no;status:no;center:yes;help:no;");  
                  } else {
                      ///  Ativando ID projeto_escolhido
                      exoc("projeto_escolhido",1,myArguments);                   
                  }
                  ///
              } else if( opcao_maiusc=="BUSCA_PROJ" || opcao_maiusc=="TODOS" ) {

 ///    alert("-> projeto_remover.php/561 -  opcao_maiusc = "+opcao_maiusc+" - lnip = "+lnip+" - \idopcao = "+idopcao+" - idopcao  - Recebendo resultado do srv_mostraanot="+srv_ret)
                    
                   if( document.getElementById('div_form') ) {
                        if( idopcao.toUpperCase()=="LIMPAR" ) {
                             ///  Voltar para o inicio da Tag Select  id  - selectedindex
                             document.getElementById('busca_proj').options[0].selected=true;
                             document.getElementById('busca_proj').options[0].selectedIndex=0;
                             ///  Ocultar id div_form 
                             exoc("div_form",0,'');
                        }
                   }
                   ///  Ativando id div_out
                   exoc("div_out",1,srv_ret);
                   ////
             } else if( opcao_maiusc=="REMOVER_PROJETO" ) { 
                    ///  Depois que foi removido o Projeto  
                    ////  if( document.getElementById('inicio_pagina_cab') ) document.getElementById('inicio_pagina_cab').innerHTML=srv_ret;
                    ///  Enviar dados pra ID div_form 
                    exoc("div_form",1,srv_ret);
             } else if( opcao_maiusc=="REMOVER" ) {     
                 /// Alterado 20180828
                  var  myArguments = string_array; 
                  var pos = srv_ret.search(/NENHUM|ERRO:/i);
                  if( pos!=-1 ) {
                        var pos = srv_ret.search(/APROVADO|NAOAPROVADO/);
                        if( pos!=-1 ) {                                            
                              var array_modal = showmodal.split("#");
                              if( document.getElementById('div_form')  ) {
                                     document.getElementById('div_form').style.display="block";
                                     if( document.getElementById('id_body')  ) {
                                          document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                     }    
                                     //  document.getElementById('div_form').innerHTML=array_modal[0];
                                     document.getElementById('div_form').innerHTML=showmodal;
                              }                                                                                           
                        }
                  } else if( pos==-1 ) {
                        if( showmodal=="excluido" ) {        
                            alert("Projeto excluído. Verificar.")                                                 
                            document.location.reload(true);  
                        }
                        /// Enviar dados id div_form 
                        exoc("div_form",1,srv_ret);
                        return;             
                  }      
             }  else {
                    if( opcao_maiusc=="CAMPOS_OBRIGATORIOS"  ) {
                         var pos = m_dados_recebidos.search(/Nenhum|ERRO:/i);
                         if( trim(m_dados_recebidos)!="" && pos==-1 ) {
                               var myArguments = m_dados_recebidos;
                               if( document.getElementById('id_body')  ) {
                                    document.getElementById('id_body').setAttribute('style','background-color: #007FFF');
                               }    
                               var showmodal=window.showModalDialog("myArguments.php",myArguments,"dialogWidth:600px;dialogHeight:500px;resizable:no;status:no;center:yes;help:no;");  
                               if( showmodal != null) {                                                                           
                                 ///  alert("LINHA 151 - cadastrar_auto.php  =  "+m_dados_recebidos)
                                   var pos = m_dados_recebidos.search(/APROVADO|NAOAPROVADO/);
                                   if( pos!=-1 ) {                                            
                                       var array_modal = showmodal.split("#");
                                       if( document.getElementById('div_form')  ) {
                                           document.getElementById('div_form').style.display="block";
                                           if( document.getElementById('id_body')  ) {
                                                document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                           }    
                                           //  document.getElementById('div_form').innerHTML=array_modal[0];
                                           document.getElementById('div_form').innerHTML=showmodal;
                                       }                                                                                           
                                   }                                        
                               }       
                         } else if(pos!=-1 ) {
                              document.getElementById('label_msg_erro').style.display="block";
                              document.getElementById('label_msg_erro').innerHTML=srv_ret;                                      
                         }                                         
                               //                             
                    } else {
                          document.getElementById('label_msg_erro').style.display="block";    
                          document.getElementById('div_out').innerHTML=srv_ret;
                    }       
             }
          } else {
                  //  Ocultar id div_form 
                  ///  if( document.getElementById('div_form')) document.getElementById('div_form').style.display="none";
                  //// exoc('div_form',0,'');
                  //  Ativando id  label_msg_erro
                  //// exoc("label_msg_erro",1,srv_ret);
                   
                  if( lcopcao=="TODOS"  || lcopcao=="BUSCA_PROJ" )  {
                        /// Separando a mensagem recebida
                        var pos1 = srv_ret.search(/INICIA/i);
                        var pos2 = srv_ret.search(/FINAL/i);
                        if( pos1!=-1 && pos1!=-2  ) {
                             srv_ret = srv_ret.replace(/ERRO:|CORRIGIR_ERRO:|INICIA|FINAL/ig,"");                      
                        }
                  }
                  /*
                     document.getElementById('label_msg_erro').style.display="block";
                     document.getElementById('label_msg_erro').innerHTML=srv_ret;
                  */
                  ///  Ativando ID mensagem de erro
                   exoc("label_msg_erro",1,srv_ret);                   
                  ///               
           }; 
    };
    ///   Define o servidor PHP para remover 
    ///    do banco de dados - anotacao do projeto desejado
    var srv_php = "srv_rmprojeto.php";   
    var poststr = new String("");

/// alert(" -->>  projeto_remover.php/674   ---  - opcao_maiusc = "+opcao_maiusc+" -  idopcao = "+idopcao+" - string_array = "+string_array)    

    ////  DESCARREGAR - UPLOAD abrindo o arquivo pdf
    if( opcao_maiusc=="DESCARREGAR" || opcao_maiusc=="DETALHES"  ) {
          var poststr = "grupoproj="+encodeURIComponent(opcao_maiusc)+"&idopcao="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
           var browser="";
           if( typeof navegador=="function" ) {
                  var browser=navegador();
           }  
           var poststr = "grupoproj="+encodeURIComponent(opcao_maiusc)+"&idopcao="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array)+"&navegador="+browser;           
          ////
    } else if( opcao_maiusc=="REMOVER_PROJETO" ) {  
           /// REMOVER Projeto
          ///  Depois que foi selecionado o Projeto para remover 
          /// var resposta = confirm('Tem certeza em remover esse Projeto, \n\nent?o clique em (Sim/OK).\n\nSen?o clique em (N?o/Cancelar)');
          var resposta = para_confirm('Tem certeza em remover esse Projeto?');
          if( resposta!==true) { 
               location.reload();
               return;
          } 
          ///
          var poststr = "grupoproj="+encodeURIComponent(opcao_maiusc)+"&val="+encodeURIComponent(idopcao);
          ///
    } else if( opcao_maiusc=="BUSCA_PROJ" ) {  
         //// var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoproj="+encodeURIComponent(opcao_maiusc)+"&op_selcpoid="+encodeURIComponent(string_array) ;
          var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
    } else if( opcao_maiusc=="TODOS" ) {     
          var poststr = "grupoproj="+encodeURIComponent(opcao_maiusc);     
    } else if( opcao_maiusc=="ORDENAR" ) {     
            ///      var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val);    
           var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
    } else {
            if( typeof(op_projcod)=="undefined" )  {
                 var poststr = "grupoproj="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array)+"&cip="+encodeURIComponent(val);       
            }  else {
                 var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoproj="+encodeURIComponent(op_selanot)+"&op_selcpoid="+encodeURIComponent(string_array) ;                
            }
    }
    ///

 ///  alert(" projeto_remover/706  --   Ativando srv_mostraanot com poststr = "+poststr);

     /* 
         aqui ? enviado mesmo para pagina receber.php 
         usando metodo post, + as variaveis, valores e a funcao   */
     var conectando_dados = myConn.connect(srv_php, "POST", poststr, inclusao);   
     /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho            */
}
/******    Final - Function principal para arquivo AJAX  ********/
///
///  Verifica se foi selecionado o Projeto
function ativar(projeto_selec)  {
    projeto_selec = trim(projeto_selec);
    if( projeto_selec.length>0 ) {
        document.getElementById("label_msg_erro").style.display="none";    
        document.getElementById('id_anotacao').style.display="block";
    } else {
        document.getElementById("label_msg_erro").style.display="block";    
        document.getElementById('id_anotacao').style.display="none";       
    }      
}
///  Final -   ativar(projeto_selec)
///
</script>
</head>
<body  id="id_body"   oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"     >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
//// Parte do MENU
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<?php
///     Alterado em 20170925  - MENU 
///   require_once("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

///   REMOVER PROJETO
//  $m_titulo="Projeto";
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//   
?>
<!--  Titulo e Mensagem  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Remover&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Titulo e Mensagem  -->
<?php
///
///   IP do usuario conectado
if ( isset($_SERVER["REMOTE_ADDR"]) )    {
    $usuario_ip = $_SERVER["REMOTE_ADDR"];
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
    $usuario_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    $usuario_ip = $_SERVER["HTTP_CLIENT_IP"];
} 
//  $ips_permitidos = array("143.107.143.231","143.107.143.232","189.123.108.225",$usuario_ip);
$ips_permitidos = array("143.107.143.231","143.107.143.232",$usuario_ip);
//  if( $indice ) {
if( ! in_array($usuario_ip, $ips_permitidos) ) {
    ?>
    <script type="text/javascript">
       /* <![CDATA[ */
       alert("Página em construção.")       
      /* ]]> */
   </script>
   <?php
   echo "<p style='text-align: center; font-size: medium;' >P&aacute;gina em constru&ccedil;&atilde;o</p>";
   echo "<p style='text-align: center; font-size: x-small;' >";
   ?>
   <a  href="http://sol.fmrp.usp.br/rexp/authent_user.php"  name="voltar" id="voltar"   class="botao3d"  style="font-size: 10px; height: 160px; cursor: pointer; "  title="Voltar"  acesskey="V"  alt="Voltar" >    
      Voltar&nbsp;<img src="imagens/enviar.gif" alt="Voltar"   style="vertical-align:text-bottom;"  >
   </a>
   <?php
   echo "</p>";
   exit();
}
///
$m_erro=0;
//  Verificando permissao para acesso Supervisor/Orientador
// include("../includes/orientador_pa.php");
//
//  PA:  super-usuario,  chefe,  subchefe, orientador, anotador  -  includes/array_menu.php
//  if( ( $_SESSION["permit_pa"]=="0"  or $_SESSION["permit_pa"]=="10"  or $m_pa_coord=="30" ) and $m_erro=="0"  ) {    
//  INVES de superusuario e?  super
//  if( ( $_SESSION["permit_pa"]<=$array_pa["superusuario"]  or $_SESSION["permit_pa"]>$array_pa["orientador"] ) and $m_erro=="0"  ) {    
if( ( $_SESSION["permit_pa"]<=$array_pa["super"]  or $_SESSION["permit_pa"]>$array_pa["orientador"] ) and $m_erro=="0"  ) {        
    echo  "<p  class='titulo_usp' >Procedimento n&atilde;o autorizado.<br>"
                ."N&atilde;o consta como Orientador ou Superior</p>";
} else {
    if( strlen(trim($_SESSION["msg_upload"]))>1 ) {
    ?>
        <script type="text/javascript" language="javascript">
            document.getElementById('label_msg_erro').style.display="block";              
            //  document.getElementById('msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";
            document.getElementById('label_msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";              
        </script>
    <?php
        if( strlen(trim($_SESSION["erros"]))<1 ) $_SESSION["display_arq"]='none';
    }       
    ///
    ?>        
     <!-- Iniciando div - div_form  -->
<div id="div_form" class="div_form" style="overflow:auto;" >
<?php
///  CODIGO/USP
$elemento=5; $elemento2=6;
include("php_include/ajax/includes/conectar.php");     
//
//  Selecionar os projetos pelo campo desejado
$opcao_cpos = Array("fonterec","objetivo","ano_inicio","ano_final","anotacao") ;
$opcao_ncpos = count($opcao_cpos);                
///
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
    ///   die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
    $msg_erro .= "Selecionando os projetos autorizados para esse {$_SESSION["usuario_pa_nome"]}. db/mysql: ".mysql_error().$msg_final;
    echo $msg_erro;
    exit();
}
///  Numero de Projetos Selecionados
$nprojetos = mysql_num_rows($result);
///
?> 
<!--  div style=display: flex;   -->
<div style="display: flex; "  >
 <div class='titulo_usp' style='margin-left: 30%; padding:2px 0 2px 2px; font-weight: bold; font-size:large;' >
   Mostrar:&nbsp;
   <span style="vertical-align:top;font-size: medium;  " >
  <input type='button' id='todos' class='botao3d'  value='Todos' title='Selecionar todos'  onclick='javascript:    remove_projeto("Todos")' >
<!-- remove_projeto("Todos","TODOS")' -->  
</span>
<span class="span_ord_proj" >
<!-- tag Select para ordenar  -->
<select   title="Ordernar"  id="ordenar"  class="ordenar"  onchange="javascript:  remove_projeto('ordenar',todos.value,this.value)"  >
<option  value=""  >ordenar por</option>
<option  value="datainicio asc"  >Data início - asc</option>
<option  value="datainicio desc"  >Data início - desc</option>
<option  value="datafinal asc"  >Data final - asc</option>
<option  value="datafinal desc"  >Data final - desc</option>
<option  value="titulo asc"  >Título - asc</option>
<option  value="titulo desc"  >Título - desc</option>
</select>
<!-- Final - tag Select para ordenar  -->
</span>
  </div>
</div>   
<!--  Final - div style=display: flex;   -->
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" >Selecionar:</p>
</div>
<div style="text-align: center;padding-top:0px; padding-bottom: 5px;" >
<select  name="busca_proj" id="busca_proj"  class="Busca_letrai"  title="Selecione o Projeto" onchange="javascript:  remove_projeto('busca_proj',this.value)"  >
    <!-- Identifica??o do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
<?php    
if( intval($nprojetos)<1 ) {
      $opcao_msg="N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.";
      echo "<option value='' >N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.</option>";
} else {
   echo "<option value='' style='cursor:pointer;' >Projeto a ser acessado por esse {$_SESSION["usuario_pa_nome"]}</option>";
   ///
   while( $linha=mysql_fetch_assoc($result) ) {
          $_SESSION["cip"]=$linha['cip'];
          $_SESSION["anotacao_numero"]=$linha['anotacao']+1;
          $autor_nome = $linha['nome'];  
          $fonterec=htmlentities($linha['fonterec']);
          $fonteprojid=ucfirst(htmlentities($linha['fonteprojid']));         
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
              //      $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
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
          //  $titulo_projeto .= $titulo;
          $titulo_projeto .= trim($projeto_titulo_parte);
          ///  Usando esse option para incluir espaco sobre linhas
          ///  echo  "<option value='' disabled ></option>";                  
          echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >"
                .$titulo_projeto."&nbsp;&nbsp;</option>";   
          ///      
   }       
   if( isset($result) ) mysql_free_result($result); 
}            
?>                
</select>
</div>
<p class='titulo_usp' >Lista dos Projetos</p>
<!-- Tabela dos Projetos  -->
<div id="div_out"  style="margin: 0 auto; width: 100%; overflow:auto; height:auto; ">
</div>
<!--  Final  -  Tabela dos Projetos  -->
<!--  Projeto escolhido -->
 <div class='titulo_usp' id="projeto_escolhido" style='text-align: justify;display: none;margin-top:0;padding-top:.2em;padding-bottom:.2em;'>
</div>
<!-- Final - Projeto escolhido -->
</div>
<!-- Final - div - div_form  -->   
     
<?php
} 
/// FINAL do else do IF de Permissao de Acesso
?>     
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
