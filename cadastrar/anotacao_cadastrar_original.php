<?php 
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
     $msg_erro .= "<br/>Erro ocorrido na parte: $n_erro.".$msg_final;  
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
//   Definindo a sessao 
if( ! isset($_SESSION["projeto_autor_nome"]) ) $_SESSION["projeto_autor_nome"]="";
///
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
// $_SESSION['time_exec']=180000;
///
////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
$ncols="122";
if( $estilocss=="estilo_mobile.css" ) {
    $ncols="68";    
} 
///
///
/*  UPLOAD: FILEFRAME section of the script
      verifica se o arquivo foi enviado      */
$_SESSION["display_arq"]='none';
$_SESSION["div_form"]="block";
$_SESSION["result"]=''; 
$_SESSION["msg_upload"]="";
///  fileframe - tag iframe  type hidden
if( isset($_POST['fileframe']) ) {
  $_SESSION["div_form"]="none";
  ////  include("../includes/functions.php");
  include("{$_SESSION["incluir_arq"]}includes/functions.php");
  //  NOME TEMPOR??RIO NO SERVIDOR
  if( isset($_FILES['relatext']['tmp_name']) ) {
      //// Definindo as variaveis
      if( isset($_POST["nprojexp"]) ) $nprojexp=$_POST["nprojexp"];        
      //
      if( isset($_POST["autor_cod"]) ) {
         if( strlen(trim($_POST["autor_cod"]))>0 ) $autor_cod=$_POST["autor_cod"];  ///  Autor da Anotacao  
      }
      ///
      ///  Conectar  BD
      $elemento=5; $elemento2=6; 
      ////  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
      include("php_include/ajax/includes/conectar.php");
      
      $db_select = mysql_select_db($db_array[$elemento],$lnkcon);
      ///
      if( isset($nprojexp) ) {
          if( strlen(trim($nprojexp)>0) ) $cip=$nprojexp;
      }
      if( ! isset($cip) ) {
         if( isset($_SESSION["cip"]) ) $cip=$_SESSION["cip"];  
      }
      ///
      $select_numprojeto = mysql_query("SELECT numprojeto,autor FROM $bd_2.projeto  WHERE cip=$cip ");
      if( ! $select_numprojeto ) {
            die('ERRO: Select projeto campo numprojeto - falha:&nbsp;db/mysql:&nbsp;'.mysql_error());  
            exit();
      }
      ///
      $_SESSION["numprojeto"]=mysql_result($select_numprojeto,0,"numprojeto");
      $projeto_autor=mysql_result($select_numprojeto,0,"autor");
      $numprojeto=$_SESSION["numprojeto"];
      /// 
      if( isset($select_numprojeto) ) mysql_free_result($select_numprojeto);      
      $_SESSION["result"]='OK'; $erros="";
      $_SESSION["display_arq"]='block';
      /** Conjunto de arquivos - ver tamanho total dos arquivos ***/
      $tam_total_arqs=0; $files_array= array(); 
	  $conta_arquivos = count($_FILES['relatext']['tmp_name']);	
	  ///  Verificando se existe diretorio
      $msg_erro =  "<p "
			   ." style='text-align: center; font-size: small; font-family: Verdana, Arial, Helvetica, sans-serif, Times, Georgia; font-weight:bolder;' >";
      $msg_erro_final = "</p>";
      ///
     if( intval($conta_arquivos)<1 ) {
          $_SESSION["msg_upload"] = $msg_erro."ERRO: Falta enviar arquivo.".$msg_erro_final;
	      $_SESSION["result"]='FALSE'; $erros="ERRO";
     }
	///    Esse For abaixo para acrescentar diretorios caso nao tenha
    ///  if( $tamanho_dir[0]<1  or !file_exists($_SESSION["dir"]) ) { // Tem que ser maior que 8 bytes
	for( $n=1; $n<3 ; $n++ ) {                
         ///  if( $n==1 ) $_SESSION["dir"] = "/var/www/html/rexp3/doctos_img/A".$_POST["autor_cod"];
        ///   if( $n==1 ) $_SESSION["dir"] = "/var/www/html".$_SESSION["pasta_raiz"]."doctos_img/A".$_POST["autor_cod"];
       if( intval($n)==1 )  $_SESSION["dir"]="{$_SESSION["incluir_arq"]}doctos_img/A".$projeto_autor;
       if( intval($n)==2 )	$_SESSION["dir"] .= "/anotacao/";	   
	   if( ! file_exists($_SESSION["dir"]) ) {  //  Verificando dir e sub-dir
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
    $tamanho_dir = shell_exec("/usr/bin/du  ".$_SESSION["dir"]);  /// tamanho em bytes do diretorio
    $tamanho_dir = explode("/",$tamanho_dir);
    if( intval($conta_arquivos)>1 ) {
    	for($i=0; $i < $conta_arquivos  ;$i++) $tam_total_arqs += $_FILES["relatext"]["size"][$i];   
     } else {
         $tam_total_arqs = $_FILES["relatext"]["size"];   
     }
    ///
    $total_dir_arq = $tamanho_dir[0]+$tam_total_arqs;
	///
	/*** o tamanho maximo no arquivo configurado no  php.ini ***/
    /* $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
          $upload_max = ($ini_max * 1024)*1000000;
    */
    /***  an array to hold messages   ***/
   ///  $messages=array(); 
	$files_size= array(); $files_date= array();     	
    /*** check if a file has been submitted ***/                                       	
    if( $_SESSION["result"]=='OK' )  {
		/***  tamanho maximo do arquivo admitido em bytes   ***/
  		$max_file_size = 524288000; /// bytes - B
		$espaco_em_disco = $max_file_size-$tamanho_dir[0];
		if( intval($espaco_em_disco)<1024 ) $tipo_tamanho = "bytes";
		if( $espaco_em_disco>1024 and $espaco_em_disco<1024000 ) {
		     $tipo_tamanho = "KB"; $espaco_em_disco= intval($espaco_em_disco/1024);
	   	} else if( intval($espaco_em_disco)>=1024000 ) {
	   	     $tipo_tamanho = "MB"; $espaco_em_disco= intval($espaco_em_disco/1024000);
		}
		///
	    if( $total_dir_arq > $max_file_size ) {
	         $erros='ERRO';
			 $result_msg= "No tem espa&ccedil;o no disco para esse arquivo. Cancelado\\n";
			 $result_msg .= "       espa&ccedil;o disponvel no disco  de ".$espaco_em_disco." $tipo_tamanho\\n";
	         $_SESSION["msg_upload"] = $msg_erro.$result_msg.$msg_erro_final;
		}      
        /**   loop atraves do conjunto de arquivos   ***/
        ///  verifica se o arquivo esta no conjunto (array)
        if( !is_uploaded_file($_FILES['relatext']['tmp_name']) ) {
			  /// $messages[]="Arquivo n&atilde;o armazenado\n"; 
			  $_SESSION["msg_upload"] = $msg_erro."Arquivo n&atilde;o armazenado\n".$msg_erro_final;
         	  ///  $erros[]='ERRO';
			  $erros='ERRO';
        } elseif( $_FILES['relatext']['tmp_name'] > $max_file_size )  {
              // verifica se o arquivo menor que o tamanho maximo permitido
              $_SESSION["msg_upload"]= $msg_erro."O arquivo excedeu o tamanho limite permitido $max_file_size $tipo_tamanho ";
			  $_SESSION["msg_upload"].=$msg_erro_final;
			  $erros = 'ERRO';
        } else {
              /// copia o arquivo para o diretorio especificado
              ///  Arquivo comecando com a Letra A (Anotacao) e P (Projeto)
              $nprojexp=$cip; 
              ///   Anotacao numero total - mesmo com alguma removida                 
              if( isset($_POST["anotacao_numero"]) )  {
                  if( strlen(trim($_POST["anotacao_numero"]))>0 ) $anotacao_numero=$_POST["anotacao_numero"];
              }               
              if( ! isset($anotacao_numero) ) {
                  if( isset($_SESSION["anotacao_numero"]) )  {
                       if( strlen(trim($_SESSION["anotacao_numero"]))>0 ) $anotacao_numero=$_SESSION["anotacao_numero"];
                  }              
              }
              ///
              /***   Anteriores
			           $filename="P".$_SESSION["numprojeto"]."A".$anotacao_numero."_".$_FILES['relatext']['name'];
                     $filename="P".$_SESSION["numprojeto"]."A".utf8_decode($anotacao_numero."_".$_FILES['relatext']['name']);                       
              **/
              ////  
              $filename="P".$_SESSION["numprojeto"]."A".$anotacao_numero."_";
              $filename .=utf8_decode($_FILES['relatext']["name"]); 
              ///
              $dir_filename=$_SESSION["dir"].$filename;
              $relatext_tmp_name=$_FILES['relatext']['tmp_name'];
			  if( @copy($_FILES['relatext']['tmp_name'],$_SESSION["dir"].$filename) )  {
                  /*** give praise and thanks to the php gods ***/
			       $erros='';
                   $_SESSION["msg_upload"]= $msg_erro."Arquivo: ".$_FILES['relatext']['name'].' foi armazenado&nbsp;';
         	       $_SESSION["msg_upload"].=$msg_erro_final;
				   $files_array[]=$_FILES['relatext']['name'];
				   $files_size[]=$_FILES["relatext"]["size"];
				   ///  $date = date('r', filemtime($upload_dir.'/'.$filename));
            	   $files_date[] = date('d/m/Y H:i:s', filemtime($_SESSION["dir"].$filename));
				   $files_type[] = mime_type($filename);
				   /// Permissao do arquivo
				   chmod($_SESSION["dir"].$filename,0755);									
              } else  {
                  /***  an error message  ***/
                   $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES['relatext']['name'].' FALHA';
         		   $_SESSION["msg_upload"].=$msg_erro_final;
		     	   $erros = 'ERRO';
              }
		}
     } 
     ///  FINAL - IF  \$_SESSION["result"]
	 ///
     $_SESSION["erros"] = trim($erros);
	 ///   Incluindo o nome do arquivo na tabela  projeto
     if( trim($erros)=='' ) {
		  ///  $local_arq0 = $_SESSION["dir"].$filename;                 
		  ///  $nprojexp=$_POST["nprojexp"]; 
          ///  $anotacao_numero=$_POST["anotacao_numero"];
          mysql_query("SET NAMES 'utf8'"); 
          mysql_query('SET character_set_connection=utf8'); 
          mysql_query('SET character_set_client=utf8'); 
          mysql_query('SET character_set_results=utf8'); 
          mysql_set_charset('utf8');
          
          ///  $local_arq = utf8_decode($local_arq); 
          ///  $local_arq=html_entity_decode(trim($filename));
          $local_arq = utf8_encode($filename); 
          ///
          ///  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
          ///                 - Use mysql_select_db() ou mysql_query()
     	  $nupdate = mysql_query("UPDATE $bd_2.anotacao SET relatext='$local_arq'  "
			              ." WHERE  projeto=$nprojexp  and  numero=$anotacao_numero ");
		  ///
		  if( ! $nupdate ) {
                $_SESSION["msg_upload"]= $msg_erro.'FALHA no armazenamento do arquivo: '.$_FILES['relatext']['name'].'<br/>';
				$_SESSION["msg_upload"].= mysql_error();
   			    $_SESSION["msg_upload"].=$msg_erro_final;		
			} else {
                
                 ///  Selecionando a Anotacao do Projeto 
                 $success=mysql_query("SELECT numero as nanotacao, projeto as nprojeto,autor as autor_anotacao  FROM $bd_2.anotacao WHERE  projeto=$nprojexp  and  numero=$anotacao_numero  ");
                 ///
                 if( ! $success ) {
                         /// Ocorreu ERRO/FALHA no Select da Anotacao do Projeto
                         $_SESSION["msg_upload"]= $msg_erro."Selecionando a Anotação $anotacao_numero do Projeto - FALHA:&nbsp;db/mysql:&nbsp;";
                         $_SESSION["msg_upload"].=mysql_error().$msg_erro_final;
                         ///
                  } else {
                      /// Número de registros 
                      $nregs=mysql_num_rows($success);
                      /// Verificando 
                      if( intval($nregs)>0 ) { 
                           ///  
                           ///  Anotacao incluida no Projeto
                           $_SESSION["msg_upload"] .= $msg_erro."Anota&ccedil;&atilde;o $anotacao_numero do Projeto ".$_SESSION["numprojeto"]."  foi conclu&iacute;da.";
                           $_SESSION["msg_upload"] .=$msg_erro_final;        
                           ///
                      } else {
                          ///  Caso NAO encontrou Anotacao do Projeto
                          $_SESSION["msg_upload"]= $msg_erro."Anotação $anotacao_numero do Projeto ".$_SESSION["numprojeto"]."  não encontrada.";
                          $_SESSION["msg_upload"].=$msg_erro_final;
                      }
                  }  
			}
            /// Final - if( ! $nupdate ) {		  
	}
  } /// isset(\$_FILES['relatext']['tmp_name'])
}  
///  FINAL - IF UPLOAD  
///
?>
<!DOCTYPE html>
<html lang="pt-BR" >
<head>
<meta charset="UTF-8" />
<meta name="author" content="Sebasti?o Paulo" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Cadastrar Anotação</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
/***    Arquivo javascript em PHP - alterado em 20171005
***/  
include("{$_SESSION["incluir_arq"]}js/anotacao_cadastrar_js.php");
///
$_SESSION["n_upload"]="ativando";

///  Alterado em 20171023
require("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"  >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("{$incluir_arq}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
$_SESSION["data_de_hoje"]=date("d/m/Y");
$_SESSION["datetime"]=date('Y-m-d H:i:s')
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<?php 
///   CADASTRAR ANOTACAO
//  Definindo TITULO da pagina
$_SESSION["m_titulo"]="Anota&ccedil;&atilde;o";
///		
//  Definindo valores nas variaveis
if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"]; 
//
// $_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|salatipo|sala";		   
$_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|sala";		   
$cols=4;	
?>
<!--  Mensagens e Titulo  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro" >
</div>
<p class="titulo_usp" >Cadastrar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final -  Mensagens e Titulo  -->
<?php
//  Verificando permissao para acesso Supervisor/Anotador
//  Permissao para Cadastrar e Consular - ANOTACAO
// include("../includes/select_anotador.php");
//
//  PA:  superusuario,  chefe,  subchefe, orientador, anotador  -  includes/array_menu.php
// if( ( $_SESSION[permit_pa]=="0" or $_SESSION[permit_pa]=="10" or $m_cip_anot=="30" or $m_cip_anot=="40" )  and $m_erro=="0"  ) {
//  if( ( $_SESSION["permit_pa"]<=$_SESSION["array_usuarios"]["superusuario"] or  $_SESSION["permit_pa"]>$_SESSION["array_usuarios"]["anotador"] ) ) {
if( ( $_SESSION["permit_pa"]<=$array_pa["super"] or  $_SESSION["permit_pa"]>$array_pa["anotador"] ) ) {
     ///    
     echo  "<p  class='titulo_usp' >Procedimento n&atilde;o autorizado.<br>"
            ."N&atilde;o consta como Anotador ou Superior.<br>Consultar seu Orientador ou Chefe</p>";
    exit();
}   
if( strlen(trim($_SESSION["msg_upload"]))>1 ) {
?>
<script type="text/javascript" language="javascript">
    document.getElementById('label_msg_erro').style.display="block";	  		
   ///     document.getElementById('msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";
    document.getElementById('label_msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";
</script>
<?php
    if( strlen(trim($_SESSION["erros"]))<1 ) $_SESSION["display_arq"]='none';
} 
///
?>		
<!--  DIV abaixo para enviar o ARQUIVO da ANOTACAO   -->
<div  id="arq_link" style="display: <?php echo $_SESSION['display_arq'];?>;"  >
 <form name="form_arq_link" method="POST"  enctype="multipart/form-data"  action="<?php echo $pagina_local; ?>"  >
  <table border='0' cellpading='0' cellspacing='0' width='90%'>
    <tr>
     <!-- Relatorio Externo (link) Projeto -->
      <td class="td_inicio1" style="vertical-align: middle; "   colspan="1" >
         <label for="relatext" style="vertical-align: middle; cursor: pointer; " title="link para o Arquivo da Anotação"   >
               <span class="asteristico" >*</span>&nbsp;Arquivo (link):&nbsp;</label>
      </td>
	  <td class="td_inicio2" style="vertical-align: middle; " colspan="1"  >
	      <input type="hidden" name="fileframe" value="true">
           <!-- Target of the form is set to hidden iframe -->
           <!-- From will send its post data to fileframe section of this PHP script (see above) -->
        <input type="file" name="relatext"  id="relatext"  size="90" 
          title="Relatório Externo da Anotação (link)" style="cursor: pointer; vertical-align:middle;" 
          onChange="javascript: jsUpload(this);"  required="required"  />
	      <input type="hidden"  id="nprojexp"  name="nprojexp" />
	      <input type="hidden"  id="autor_cod"  name="autor_cod"  />	   
          <input type="hidden"  id="anotacao_numero"  name="anotacao_numero" />                 
	      <input type="hidden"  id="m_titulo"  name="m_titulo"  value="<?php echo $_SESSION["m_titulo"];?>" />	   		  
		</td>
        <!-- FINAL - Relatorio Externo (link) Projeto -->
     </tr>
     <tr>
       <!--  Aviso na espera do processo -->
       <td id="aguarde_arq" style="text-align: center; border: 3px double #000000; width:100%;"  colspan="3" >
            Aguarde. Esse processo pode demorar...   
       </td>
       <!-- Final - Aviso na espera do processo -->   
    </tr>    
    <tr>
      <!--  Enviar Relatorio/Arquivo Projeto  -->
      <td  align="center"  style="text-align: center; border:none; "  colspan="2" >
		<button  type="submit" name="enviar_arq" id="enviar_arq" class="botao3d" 
          style="width: 160px; cursor: pointer;" title="Enviar" acesskey="E"  alt="Enviar" 
            onclick="javascript: if( trim(document.getElementById('relatext').value)=='' ) { alert('Importante: informar o arquivo da Anotação do Projeto.'); document.getElementById('relatext').focus(); return false; } "     >    
         Enviar arquivo&nbsp;<img src="../imagens/enviar.gif" alt="Enviar Arquivo"  style="vertical-align:text-bottom;"  >
       </button>
	  </td>
      <!-- Final - Enviar Relatorio/Arquivo Projeto  -->   
	</tr>		  
    <tr>
      <td style="display:block; text-align: left; background-color: #FFFFFF; color: #000000;;"  colspan="2" >
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
          document.getElementById('relatext').value="";
          document.getElementById('relatext').focus();
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
<!--  Final - Parte do arquivo PDF - Relatorio da Anotacao do Projeto  -->
<!--  DIV abaixo os Dados Antes de pedir o Arquivo para Upload   -->
<div  id="div_form"  class="div_form" >
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: enviar_dados_cad('submeter','ANOTACAO',document.form1); return false"  >
 
<!-- div - ate antes do Limpar e Enviar -->
   <div class="parte_inicial"  >
   
           <div class="div_nova" >
           <!-- Titulo do Anotador  -->
           <span>
               <label title="Anotador" >Anotador:&nbsp;</label>               
           </span>
           <!-- Final - Titulo do Anotador  -->
           <span>    
                <!-- N. Funcional USP/Matricula - Autor/ANOTADOR -->
                <?php 
                    //// Conectar - BD
                    $elemento=5; $elemento2=6;
                    include("php_include/ajax/includes/conectar.php");
                    /////           
                    mysql_query("SET NAMES 'utf8'");
                    mysql_query('SET character_set_connection=utf8');
                    mysql_query('SET character_set_client=utf8');
                    mysql_query('SET character_set_results=utf8');
                    ///                         
                   ///  IMPORTANTE: passar SESSION para uma variavel
                   $usuario_conectado=$_SESSION["usuario_conectado"];
                   $res_anotador = mysql_query("SELECT codigousp,nome,categoria FROM  $bd_1.pessoa  "
                                     ."  WHERE codigousp=$usuario_conectado  order by nome "); 
                   ///
                   if( ! $res_anotador ) {
                         die('ERRO: Select pessoal.pessoa - falha: '.mysql_error());  
                    }
                    ////  Cod/Num_USP/Autor/Anotador
                    $m_linhas = mysql_num_rows($res_anotador);
                    if( intval($m_linhas)<1 ) {
                        $autor="== Nenhum encontrado ==";
                    } else {
                         $_SESSION["anotador_codigousp"]=mysql_result($res_anotador,0,"codigousp");
                         ///  IMPORTANTE:  pra acentuacao htmlentities
                         ///  $anotador_nome=mysql_result($res_anotador,0,"nome");
                         ///  $anotador_nome=htmlentities(mysql_result($res_anotador,0,"nome"),ENT_QUOTES,"UTF-8");
                         $anotador_nome=mysql_result($res_anotador,0,"nome");
                         $_SESSION["anotador_nome"]=$anotador_nome;
                         $anotador_categoria=mysql_result($res_anotador,0,"categoria");                    
                         if( isset($res_anotador) )  mysql_free_result($res_anotador); 
                    }
                    /// Final da Num_USP/Nome Autor/Anotador 
                     ///  echo  utf8_decode($anotador_nome);
                     ///  echo  htmlentities($anotador_nome);   
                     ///  echo  htmlentities($anotador_nome,ENT_QUOTES,"UTF-8");
                     ////
               ?>  
               <span class='td_inicio1' style="height: auto; border:none; background-color:#FFFFFF; color:#000000;" title='Nome do Autor Responsável do Projeto' >
                      &nbsp;<?php echo htmlentities($anotador_nome,ENT_QUOTES,"UTF-8");?>&nbsp;
               </span>
               <input type="hidden" name="autor" id="autor" size="80" maxlength="86" 
                   value="<?php echo $_SESSION["anotador_codigousp"];?>" />

           </span>
           <!-- Final - Titulo do Projeto  -->
        </div>

       <div class="div_nova" style="margin: .4em 0 .4em 0;" >
         <!-- Identificação do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
            <span>
               <label title="Título do Projeto" >
               <span class="asteristico" style="color: #000000;vertical-align: top;" >*</span>&nbsp;Projeto:&nbsp;
               </label>
           </span>
        <?php  
           ////   Primeira Parte  da  Anotacao  selecionando  o Projeto
            /////           
            mysql_query("SET NAMES 'utf8'");
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');
            ///                         
           $_SESSION["orientador"]="supervisor";
           $_SESSION["anotacao_numero"]=0;
           ////
            if ( $permit_pa==$array_pa["chefe"] or $permit_pa==$array_pa["vice"]  ) {
                $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
                    ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
                    ." a.codigousp=".$_SESSION["usuario_conectado"]." order by b.titulo ";
                    ///
            }        
            if ( $permit_pa==$array_pa["anotador"] ) {
                   $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo, "
                                 ." b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b, $bd_2.anotador c "
                                 ." where a.codigousp=b.autor and "
                                 ." b.cip=c.cip and c.codigo=".$_SESSION['anotador_codigousp']." order by b.titulo "; 
                   ///              
            } elseif( $permit_pa==$array_pa["orientador"] ) {          
                   $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo, "
                                 ." b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b "
                                 ." where a.codigousp=b.autor and "
                                 ." b.autor=".$_SESSION["usuario_conectado"]." order by b.titulo ";               
                   ///              
            }  
            ///
            $result_pessoa=mysql_query($sqlcmd);
            ///                  
            if( ! $result_pessoa ) {
                    $msg_erro .= "Selecionando os projetos autorizados para esse Anotador - falha no mysql/query:&nbsp;"
                                  .mysql_error().$msg_final;
                    echo $msg_erro;
                    exit();
            }
            /// $count_arr_cnc = count($arr_cnc["fonterec"])-1;
            ///  Identificação da Fonte de Recurso
            $m_linhas = mysql_num_rows($result_pessoa);
       ?>
       <select name="projeto"  id="projeto"  class="td_select" 
               title="Identificação do Projeto"   required="required"  
           onchange="javascript:  enviar_dados_cad('anotacao',this.id,this.value)"  
            style="font-size: 1.2em; padding: 1px 0 1px 0;">                   
    <?php
        /// Verificando o numero de registros
        if( intval($m_linhas)<1 ) {
            $autor="== Nenhum encontrado ==";
            echo  "<option value='' >== Nenhum encontrado ==</option>";                  
        } else {
            ?>
            <option value='' >Selecione o Projeto que corresponde essa Anota&ccedil;&atilde;o &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
            <?php
              $nconta=1;
              while( $linha=mysql_fetch_assoc($result_pessoa) ) {
                    $fonterec=htmlentities($linha['fonterec']);
                    $fonteprojid=ucfirst(htmlentities($linha['fonteprojid']));
                    ///  PARTES do Titulo do Projeto - dividindo em sete partes 
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
                           ///    $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
                             break;
                         }
                    }
                    $titulo_projeto="";
                    if( strlen(trim($fonterec))>=1 ) $titulo_projeto.= $fonterec."/";
                    if( strlen(trim($fonteprojid))>=1 ) $titulo_projeto.= $fonteprojid.": ";
                    $_SESSION["cip"]=$linha['cip'];
                    $cip=$_SESSION["cip"];
                    ///  $_SESSION["anotacao_numero"]=$linha['anotacao'];
                    $autor_nome =$linha['nome'];
                    $titulo_projeto .= trim($projeto_titulo_parte);
                    ///  Usando esse option para incluir espaco sobre linhas
                    ////   echo  "<option value='' disabled ></option>";                  
                    echo  "<option value=".$linha['cip']." title='Orientador do Projeto: $autor_nome' >"
                             .$nconta.")&nbsp;".htmlentities($titulo_projeto,ENT_QUOTES,"UTF-8")."&nbsp;&nbsp;</option>";   
                    ///
                    ++$nconta;
                    ///            
              }
            ?>
             </select>
            <?php 
               if( isset($result_pessoa) ) mysql_free_result($result_pessoa); 
        }
        ?>  
        <!-- Final da Num_USP/Nome Responsavel  -->
     </div>
 
      <div class="div_nova" >
      <!-- Orientador do Projeto - inicia oculto  -->
        <div id="tr_projeto_autor_nome" class="td_inicio1" style="display: none; vertical-align: middle; text-align: justify;  margin: 0px; border: none;"  >
            <label>Orientador desse Projeto:&nbsp;</label>
            <span class='td_inicio1' id="span_proj_autor_nome" style="text-align: left; border:none;  background-color:#FFFFFF; color: #000000;vertical-align: top; font-weight: normal;" >             
           </span>
        </div>
        <!--  Final - Orientador do Projeto  -->
       </div>
 

    <div  class="div_nova" style="float: left; clear: both; width: 100%; " >
       <article class="anotacaoarticle1" style="text-align: center; max-width: 99.2%; alignment-adjust: central;"  >
          <table class="table_inicio" style="margin: 0px; "  >
            <tr class="td_inicio1"  >
              <!--  Nr. Anotacao -->      
              <td  class="td_inicio1" style="vertical-align: middle; text-align: right; background-color:#FFFFFF; color:#000000; padding-right: 1em;" >
                  Anota&ccedil;&atilde;o#
              </td>
             <td id="nr_anotacao"  class="td_inicio1" style="vertical-align: top; background-color:#FFFFFF; color:#000000;"  ><?php echo $_SESSION["anotacao_numero"];?>
             </td>
             <!--  Data da Anotacao  -->
               <td class="td_inicio1" style="vertical-align: middle;text-align: left; background-color:#FFFFFF; color:#000000;"  >&nbsp;Data:&nbsp;<?php echo $_SESSION["data_de_hoje"];?></td>
            </tr>
          </table>
       </article>      
     </div>

   <div class="div_nova" >
     <article class="anotacaoarticle1"  >
       <!--  Titulo Anotacao  -->
       <span class="span_float" >
          <label for="titulo"  style="vertical-align: top; color:#000000; background-color: #32CD99; cursor:pointer;"  title="Título do Projeto" >
               <span class="asteristico" style="color: #000000;vertical-align: top;" >*</span>
               &nbsp;T&iacute;tulo da Anota&ccedil;&atilde;o:&nbsp;
          </label>
       </span>
       <div>
          <textarea rows="6"  name="titulo" id="titulo" 
                onKeyPress="javascript:limita_textarea('titulo');" 
                 title="Digitar T&iacute;tulo da Anota&ccedil;&atilde;o" 
                  style="cursor: pointer; overflow:auto;"   
                  onblur="javascript: alinhar_texto(this.id,this.value)"  >
          </textarea>     
        <!--  FINAL - Titulo Anotacao -->        
     </div>
        
     <!--  Altera ou Complementa o Projeto.  Nulo ou zero, caso negativo. -->
     <div   style="height:2.4em; text-align: left; vertical-align: bottom; display: flex; margin: 0px; width: 100%;" >
       <span id="sn_altera_complementa" class="td_inicio1" style="width: 100%; text-align: left; border:  1px solid #000000; display: none;padding:6px 2px 2px 4px;overflow:hidden; " colspan="<?php echo $cols/2;?>"  >
       </span>
       <span  id="td_altera_complementa" class="td_inicio1"  style="width: 100%; text-align: left; border:  1px solid #000000; display: none;padding:6px 2px 2px 4px;overflow:hidden; "  colspan="<?php echo $cols/2;?>" >
       </span>
        <!--  FINAL - Indicador de continuação do experimento -->        
     </div>
   </article>
 </div>

 
 <div  class="div_nova" >
    <article class="anotacaoarticle1"   >
      <div  class="td_inicio1" style="text-align: left; margin-top: 0px; margin-bottom: 2px;padding-top: 0px;" >
      <label for="testemunha1"  style="vertical-align:bottom; cursor: pointer; "  title="Código da Testemunha (1) da realização " >Testemunha (1):&nbsp;</label>
      <br />
        <!-- Código da Testemunha (1) da realização -->
        <?php 
            ///  Conectar
            $elemento=5; $elemento2=6;
            ///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");    
            include("php_include/ajax/includes/conectar.php");    
            $result2=mysql_query("SELECT codigousp,nome,categoria FROM  $bd_1.pessoa order by nome ");
        ?>
        <select onfocus="javascript: document.getElementById('label_msg_erro').style.display='none';" name="testemunha1" id="testemunha1" class="td_select"  title="Código da Testemunha (1) da realização " >
        <?php
               //  Código da Testemunha (1) da realização 
               $testemunhas_result = $result2;
               ///  include("../includes/testemunhas.php"); 
               include("{$_SESSION["incluir_arq"]}includes/testemunhas.php"); 
               ////
          ?>
          </select>
          <?php
            if( isset($result2) )  mysql_free_result($result2); 
           /// FINAL - Código da Testemunha (1) da realização 
           ?>  
      </div>
      <div  class="td_inicio1" style="text-align: left;margin-top: 0px;"  >
      <label for="testemunha2"  style="vertical-align:top; cursor: pointer; padding-top: 4px; padding-bottom: 4px;"  title="Código da Testemunha (2) da realização "  >Testemunha (2):&nbsp;</label>
      <br/>
        <!-- Código da Testemunha (2) da realização -->
        <?php 
            $elemento=5;
            ///  mysql_db_query -  essa funcao esta desativada usar mysql_query
            ///  $result=mysql_db_query($db_array[$elemento],"SELECT codigousp,nome,categoria FROM pessoa order by nome ");
            $result=mysql_query("SELECT codigousp,nome,categoria FROM pessoa order by nome ");
            if( ! $result ) {
                $msg_erro .= "SELECT Tabela pessoa -  db/mysql: ".mysql_error().$msg_final;
                echo $msg_erro;
                exit();  
            }
        ?>
        <select name="testemunha2" id="testemunha2" class="td_select" title="Código da Testemunha (2) da realização" >
        <?php
               ////  Código da Testemunha (2) da realização 
               $testemunhas_result = $result;
               include("{$_SESSION["incluir_arq"]}includes/testemunhas.php"); 
          ?>
          </select>
          <?php
             if( isset($result) ) mysql_free_result($result); 
             /// FINAL - Código da Testemunha (2) da realização 
           ?>  
          <input  type="hidden"  id="data"  name="data"  value="<?php echo $_SESSION["datetime"];?>" />
    </div>
    
   </article>
 </div>
 
</div>
<!-- Final - div - ate antes do Limpar e Enviar -->


 <!--  TAGS  type reset e  submit  -->                                        
      <div class="reset_button" >
        <!-- Limpar campos -->                  
          <span>
             <button  type="button"  name="limpar" id="limpar"  class="botao3d"   
               onclick="javascript: enviar_dados_cad('reset','<?php echo $pagina_local;?>'); return false;" 
                  title="Limpar"  acesskey="L"  alt="Limpar" >
               Limpar&nbsp;<img src="../imagens/limpar.gif" alt="Limpar" >
             </button>
           </span>   
           <!-- Final - Limpar  -->
           <!-- Enviar -->                  
           <span>
              <button  type="submit"  name="enviar" id="enviar" class="botao3d"    
                 title="Enviar"  acesskey="E"  alt="Enviar"   >
               Enviar&nbsp;<img src="../imagens/enviar.gif" alt="Enviar" >
             </button>
           </span>
           <!-- Final -Enviar -->
      </div>
   <!--  FINAL - TAGS  type reset e  submit  -->    

       <div class="reset_button" >
       <!--  Mensagem  --> 
         <span>
              <span class="asteristico" >*</span>&nbsp;<b>Campo obrigat&oacute;rio</b>
         </span>
       </div> 
   
</form>
</div>
<!-- Final - div_form -->
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
