<?php 
//  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

/// include('inicia_conexao.php');
extract($_POST, EXTR_OVERWRITE); 

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///  HOST mais a pasta principal do site
$host_pasta="";
if( isset($_SESSION["host_pasta"]) ) $host_pasta=$_SESSION["host_pasta"];

///
///  Verificando SESSION incluir_arq
$n_erro=0;
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=trim($_SESSION["incluir_arq"]);
if( strlen($incluir_arq)<1 ) $n_erro=1;
///
/***
*    Caso NAO houve ERRO  
***/
if( intval($n_erro)<1 )  {
    ////   CONECTANDO
    include("{$_SESSION["incluir_arq"]}inicia_conexao.php");
    ///
    ///  HOST mais a pasta principal do site - host_pasta
    if( ! isset($_SESSION["host_pasta"]) ) {
         $msg_erro .= utf8_decode("Sessão host_pasta não está ativa.").$msg_final;  
         echo $msg_erro;
         exit();
    }
    $host_pasta=trim($_SESSION["host_pasta"]);
    if( strlen($host_pasta)<1 ) $n_erro=2;
    ///
    /***
    *    Caso NAO houve ERRO  
    */
    if( intval($n_erro)<1 )  {
        ///  DEFININDO A PASTA PRINCIPAL 
        /////  $_SESSION["pasta_raiz"]="/rexp_responsivo/";     
        ///  Verificando SESSION  pasta_raiz
        if( ! isset($_SESSION["pasta_raiz"]) ) {
             $msg_erro .= "Sessão pasta_raiz não está ativa.".$msg_final;  
             echo $msg_erro;
             exit();
        }
        $pasta_raiz=trim($_SESSION["pasta_raiz"]);
        ///
        ///  Definindo http ou https
        ///  Definindo http ou https - IMPORTANTE
        ///  Verificando protocolo do Site  http ou https   
        $_SESSION["protocolo"] = $protocolo =  (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $_SESSION["url_central"] = $url_central = $protocolo."://".$_SERVER['HTTP_HOST'].$_SESSION["pasta_raiz"];
        $raiz_central=$_SESSION["url_central"];
        ///
        ///    MENU HORIZONTAL
        ///  include("../includes/array_menu.php");
        include("{$incluir_arq}includes/array_menu.php");
        if( isset($_SESSION["array_pa"]) ) {
            $array_pa = $_SESSION["array_pa"];       
            $permit_anotador = $array_pa['anotador'];
            $permit_orientador = $array_pa['orientador'];
        }
    }
    ////    
}
/******  FINAL - if( intval($n_erro)<1 ) **********************/  
///
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
     $msg_erro .= "Erro ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
///
$_SESSION["m_horiz"] = $array_projeto;
///
///   Definindo a sessao 
if( ! isset($_SESSION["projeto_autor_nome"]) ) $_SESSION["projeto_autor_nome"]="";
///
///  $_SESSION['time_exec']=180000;
///   Caminho da pagina local
$pagina_local=$_SESSION["protocolo"]."://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]= utf8_decode("Registro de Anotação") ;

/*  UPLOAD: FILEFRAME section of the script
      verifica se o arquivo foi enviado      */
$_SESSION["display_arq"]='none';
$_SESSION["div_form"]="block";
$_SESSION["result"]=''; 
$_SESSION["msg_upload"]="";
//  fileframe - tag iframe  type hidden
if( isset($_POST['fileframe']) ) {
  $_SESSION["div_form"]="none";
  include("../includes/functions.php");
  //  NOME TEMPOR?RIO NO SERVIDOR
  if( isset($_FILES['relatext']['tmp_name']) ) {
      // Definindo as variaveis
      $nprojexp=$_POST["nprojexp"];        
      $autor_cod=$_POST["autor_cod"];    //  Autor da Anotacao
      //  Conectar  BD
      $elemento=5; $elemento2=6; 
      include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
      $db_select = mysql_select_db($db_array[$elemento],$lnkcon);
      $select_numprojeto = mysql_query("SELECT numprojeto,autor  from $bd_2.projeto  WHERE cip=$nprojexp  ");
      if( ! $select_numprojeto ) {
            mysql_free_result($select_numprojeto);
            die('ERRO: Select projeto campo numprojeto - falha: '.mysql_error());  
            exit();
      }
      //
      $_SESSION["numprojeto"]=mysql_result($select_numprojeto,0,"numprojeto");
      $projeto_autor=mysql_result($select_numprojeto,0,"autor");
      $numprojeto=$_SESSION["numprojeto"];
      // 
      mysql_free_result($select_numprojeto);      
      $_SESSION["result"]='OK'; $erros="";
      $_SESSION["display_arq"]='block';
      /** Conjunto de arquivos - ver tamanho total dos arquivos ***/
      $tam_total_arqs=0; $files_array= array(); 
	  $conta_arquivos = count($_FILES['relatext']['tmp_name']);	
	  //  Verificando se existe diretorio
      $msg_erro =  "<p "
			   ." style='text-align: center; font-size: small; font-family: Verdana, Arial, Helvetica, sans-serif, Times, Georgia; font-weight:bolder;' >";
      $msg_erro_final = "</p>";
     if( $conta_arquivos<1 ) {
         $_SESSION["msg_upload"] = $msg_erro."ERRO: Falta enviar arquivo.".$msg_erro_final;
	     $_SESSION["result"]='FALSE'; $erros="ERRO";
     }
	//    Esse For abaixo para acrescentar diretorios caso nao tenha
    //  if ( $tamanho_dir[0]<1  or  !file_exists($_SESSION["dir"]) ) {  //  Tem que ser maior que 8 bytes
	for( $n=1; $n<3 ; $n++ ) {                
       //  if( $n==1 )	$_SESSION["dir"] = "/var/www/html/rexp3/doctos_img/A".$_POST["autor_cod"];
     //  if( $n==1 )  $_SESSION["dir"] = "/var/www/html".$_SESSION["pasta_raiz"]."doctos_img/A".$_POST["autor_cod"];
       if( $n==1 )  $_SESSION["dir"] = "/var/www/html".$_SESSION["pasta_raiz"]."doctos_img/A".$projeto_autor;
       if( $n==2 )	$_SESSION["dir"] .= "/anotacao/";	   
	   if(  !file_exists($_SESSION["dir"]) ) {  //  Verificando dir e sub-dir
            $r = mkdir($_SESSION["dir"],0755);
	        if ( $r===false ) {
    			 //  echo  $msg_erro;
				 $_SESSION["msg_upload"] = $msg_erro."Erro ao tentar criar diret&oacute;rio".$msg_erro_final;
				 //  die("Erro ao tentar criar diret&oacute;rio");
			 	 $_SESSION["result"]='FALSE';  $erros='ERRO';
		    } else  chmod($_SESSION["dir"],0755);							        			
	   }
	}   
    //
    $tamanho_dir = shell_exec("/usr/bin/du  ".$_SESSION["dir"]);  // tamanho em bytes do diretorio
    $tamanho_dir = explode("/",$tamanho_dir);
    if ( $conta_arquivos>1 ) {
    	for($i=0; $i < $conta_arquivos  ;$i++) $tam_total_arqs += $_FILES["relatext"]["size"][$i];   
     } else $tam_total_arqs = $_FILES["relatext"]["size"];
    //
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
		//
	    if( $total_dir_arq > $max_file_size ) {
	         $erros='ERRO';
			 $result_msg= "No tem espa&ccedil;o no disco para esse arquivo. Cancelado\\n";
			 $result_msg .= "       espa&ccedil;o disponvel no disco  de ".$espaco_em_disco." $tipo_tamanho\\n";
	         $_SESSION["msg_upload"] = $msg_erro.$result_msg.$msg_erro_final;
		}      
        /** loop atraves do conjunto de arquivos ***/
        //  verifica se o arquivo esta no conjunto (array)
        if( !is_uploaded_file($_FILES['relatext']['tmp_name']) ) {
			   // $messages[]="Arquivo n&atilde;o armazenado\n"; 
			   $_SESSION["msg_upload"] = $msg_erro."Arquivo n&atilde;o armazenado\n".$msg_erro_final;
         		//  $erros[]='ERRO';
				$erros='ERRO';
        } elseif( $_FILES['relatext']['tmp_name'] > $max_file_size )  {
              // verifica se o arquivo menor que o tamanho maximo permitido
              $_SESSION["msg_upload"]= $msg_erro."O arquivo excedeu o tamanho limite permitido $max_file_size $tipo_tamanho ";
			  $_SESSION["msg_upload"].=$msg_erro_final;
			  $erros = 'ERRO';
        } else {
                 // copia o arquivo para o diretorio especificado
                 //  Arquivo comecando com a Letra A (Anotacao) e P (Projeto)
                 $nprojexp=$_POST["nprojexp"]; $anotacao_numero=$_POST["anotacao_numero"];
                 //
			     $filename="P".$_SESSION["numprojeto"]."A".$anotacao_numero."_".$_FILES['relatext']['name'];
                 $dir_filename=$_SESSION["dir"].$filename;
                 $relatext_tmp_name=$_FILES['relatext']['tmp_name'];
				 if( @copy($_FILES['relatext']['tmp_name'],$_SESSION["dir"].$filename) )  {
                     /*** give praise and thanks to the php gods ***/
					 $erros='';
                     $_SESSION["msg_upload"]= $msg_erro."Arquivo: ".$_FILES['relatext']['name'].' foi armazenado&nbsp;';
         			 $_SESSION["msg_upload"].=$msg_erro_final;
					 $files_array[]=$_FILES['relatext']['name'];
					 $files_size[]=$_FILES["relatext"]["size"];
					 //  $date = date('r', filemtime($upload_dir.'/'.$filename));
            	     $files_date[] = date('d/m/Y H:i:s', filemtime($_SESSION["dir"].$filename));
					 $files_type[] = mime_type($filename);
					// Permissao do arquivo
					 chmod($_SESSION["dir"].$filename,0755);									
                } else  {
                     /***  an error message  ***/
                     $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES['relatext']['name'].' FALHA';
         			 $_SESSION["msg_upload"].=$msg_erro_final;
		     	     $erros = 'ERRO';
                }
		}
     } //  FINAL - IF  \$_SESSION["result"]
	 //
     $_SESSION["erros"] = trim($erros);
	 //   Incluindo o nome do arquivo na tabela  projeto
     if( trim($erros)=='' ) {
			//  $local_arq0 = $_SESSION["dir"].$filename;                 
			//  $nprojexp=$_POST["nprojexp"]; 
            //  $anotacao_numero=$_POST["anotacao_numero"];
            
			$local_arq=html_entity_decode(trim($filename));
            //
           //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
           //                 - Use mysql_select_db() ou mysql_query()
     	    $success = mysql_query("UPDATE $bd_2.anotacao SET relatext='$local_arq'  "
			              ." where ( projeto=$nprojexp  and  autor=$autor_cod and  numero=$anotacao_numero  ) ");
			//
			if( ! $success ) {
                $_SESSION["msg_upload"]= $msg_erro.'FALHA no armazenamento do arquivo: '.$_FILES['relatext']['name'].'<br>';
				$_SESSION["msg_upload"].= mysql_error();
   			    $_SESSION["msg_upload"].=$msg_erro_final;		
			} else {
                 $_SESSION["msg_upload"] .= $msg_erro."Anota??o $anotacao_numero do Projeto ".$_SESSION["numprojeto"]."  foi conclu&iacute;do.";
				 $_SESSION["msg_upload"] .=$msg_erro_final;		    
			}		  
	}
  } // isset(\$_FILES['relatext']['tmp_name'])
}  //  FINAL do IF UPLOAD  
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="pt-br" />
<meta name="author" content="Sebasti?o Paulo" />
<META http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE"> 
<META HTTP-EQUIV="Expires" CONTENT="-1" >
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<META http-equiv="imagetoolbar" content="no">  
<title>Cadastrar Anota??o</title>
<link  type="text/css"  href="../css/estilo.css" rel="stylesheet"  />
<link  type="text/css"   href="../css/style_titulo.css" rel="stylesheet"  />
<script  type="text/javascript" src="../js/XHConn.js" ></script>
<script type="text/javascript"  src="../js/functions.js" ></script>
<script type="text/javascript"  src="../js/anotacao_cadastrar_nova.js" ></script>
<script  language="javascript"  type="text/javascript" src="../js/formata_data.js"></script>
<?php
$_SESSION["n_upload"]="ativando";
require_once("../includes/dochange.php");
//
?>
</head>
<body  id="id_body" onload="javascript: dochange('anotacao','verificando')"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"  >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php include("../script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("../includes/menu_horizontal.php");
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
$_SESSION["data_de_hoje"]=date("d/m/Y");
$_SESSION["datetime"]=date('Y-m-d H:i:s')
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<?php 
//   CADASTRAR ANOTACAO
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//		
//  Definindo valores nas variaveis
if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"]; 
//
// $_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|salatipo|sala";		   
$_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|sala";		   
$cols=4;	
?>
<label  id="label_msg_erro" style="display:none; position: relative;width: 100%; text-align: center; overflow:hidden;" >
   <font  ></font>
</label>
<p class='titulo_usp' style="overflow:hidden;" ><b>Cadastrar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></b></p>
<?php
//  Verificando permissao para acesso Supervisor/Anotador
//  Permissao para Cadastrar e Consular - ANOTACAO
// include("../includes/select_anotador.php");
//
//  PA:  superusuario,  chefe,  subchefe, orientador, anotador  -  includes/array_menu.php
// if( ( $_SESSION[permit_pa]=="0" or $_SESSION[permit_pa]=="10" or $m_cip_anot=="30" or $m_cip_anot=="40" )  and $m_erro=="0"  ) {
//  if( ( $_SESSION["permit_pa"]<=$_SESSION["array_usuarios"]["superusuario"] or  $_SESSION["permit_pa"]>$_SESSION["array_usuarios"]["anotador"] ) ) {
if( ( $_SESSION["permit_pa"]<=$array_pa["super"] or  $_SESSION["permit_pa"]>$array_pa["anotador"] ) ) {    
     echo  "<p  class='titulo_usp' >Procedimento n&atilde;o autorizado.<br>"
               ."N&atilde;o consta como Anotador ou Superior.<br>Consultar seu Orientador ou Chefe</p>";      
    exit();
}   
if( strlen(trim($_SESSION["msg_upload"]))>1 ) {
  ?>
   <script type="text/javascript" language="javascript">
    document.getElementById('label_msg_erro').style.display="block";	  		
    //  Alterado em  20121101 
   // document.getElementById('label_msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";
    document.write("<?php echo $_SESSION["msg_upload"]; ?>");
   </script>
<?php
    if( strlen(trim($_SESSION["erros"]))<1 ) $_SESSION["display_arq"]='none';
} else {
  ?>
    <script type="text/javascript" language="javascript">
       importante("Anota??o");
    </script>	
   <?php	 
}
?>		
<!--  DIV abaixo para enviar o ARQUIVO da ANOTACAO   -->
<div  id="arq_link" style="display: <?php echo $_SESSION['display_arq'];?>;"  >
 <form name="form_arq_link" method="POST"  enctype="multipart/form-data"  ACTION="<?php echo $pagina_local; ?>"  >
  <table border='0' cellpading='0' cellspacing='0' width='90%'>
    <tr  >
     <!-- Relatorio Externo (link) Projeto -->
      <td  class="td_inicio1" style="vertical-align: middle; "   colspan="1"    >
         <label for="relatext" style="vertical-align: middle; cursor: pointer; " title="link para o Arquivo da Anota??o"   ><span class="asteristico" >*</span>&nbsp;Arquivo (link):&nbsp;</label>
        </td  >
		<td class="td_inicio2" style="vertical-align: middle; " colspan="1"  >
	   <input type="hidden" name="fileframe" value="true">
           <!-- Target of the form is set to hidden iframe -->
           <!-- From will send its post data to fileframe section of this PHP script (see above) -->
     <input type="file" name="relatext"  id="relatext"  size="90" title="Relat?rio Externo da Anota??o (link)"  style="cursor: pointer; vertical-align:middle; " onChange="javascript: jsUpload(this);"  />
	      <input  type="hidden"  id="nprojexp"  name="nprojexp"    />
	      <input  type="hidden"  id="autor_cod"  name="autor_cod"  />	   
          <input  type="hidden"  id="anotacao_numero"  name="anotacao_numero"  />                 
	      <input  type="hidden"  id="m_titulo"  name="m_titulo"  value="<?php echo $_SESSION["m_titulo"];?>" />	   		  
		    </td>
            <!-- FINAL - Relatorio Externo (link) Projeto -->
     </tr>
     <tr>
      <!--  Aviso na espera do processo -->
      <td id="aguarde_arq" style="display:block; text-align: center; background-color: #FFFFFF; color: #000000;;" colspan="2">
         Aguarde. Esse processo pode demorar...   
       </td>
    </tr>    
    <tr>
      <td  align="center"  style="text-align: center; border:none; "  colspan="2" >
		 <button name="enviar_arq" id="enviar_arq"   type="submit"  class="botao3d"  style="width: 160px; cursor: pointer;"   title="Enviar"  acesskey="E"  alt="Enviar"   onclick="javascript: if(  trim(document.getElementById('relatext').value)=='' ) { document.getElementById('relatext').focus(); return false; } "     >    
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
<div  id="div_form"   style="width:100%; overflow:auto; height: 392px; display:<?php echo $_SESSION["div_form"];?>;" >
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: cad_dados_anotacao('submeter','ANOTACAO',document.form1); return false"  >
  <table class="table_inicio" cols="<?php echo $cols;?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; margin-bottom: 0px; padding-bottom: 0px; "  >
   <tr style="vertical-align: middle;  margin: 1px; padding: 2px; line-height: 10px; height: 30px; "  >
    <td  class="td_inicio1" style="vertical-align: middle; text-align: left;margin: 0px; padding: 0px;" colspan="<?php echo $cols;?>"  >
     <table  style="text-align: left;margin: 0px; padding: 0px;"   >
       <tr style="text-align: left; border: none; margin: 0px; padding: 0px; line-height: 10px; "  >
      <td  class="td_inicio1" style=" border: none; vertical-align: middle;text-align: left;" colspan="1"  >
      <label   title="Anotador"   >Anotador:&nbsp;</label>
      </td>
      <td class="td_inicio1" style="height: 20px;  vertical-align: middle; text-align: left; border: none;"  colspan="3"  >
        <!-- N. Funcional USP/Matricula - Autor/ANOTADOR -->
        <?php 
            //  Verificando se sseion_start - ativado ou desativado
            if(!isset($_SESSION)) {
                session_start();
            }
            //  SESSION do arquivo tabela_consulta_anotacao_nova.php
            if( isset($_SESSION["anotacao_nova"]) ) {
                $cip_escolhido = $_SESSION["anotacao_nova"];
                ?>
                <script type=" text/javascript">
                     /* <![CDATA[ */
                    cad_dados_anotacao('anotacao','projeto','<?php echo $cip_escolhido;?>');
                   /* ]]> */
                   </script>
                  <?php
            }
            //  CONECTAR
            //  Nao precisa chamar de novo o arquivo ja foi chamado
            // @require_once("/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php");
            // $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ",$db_array[$elemento]); 
            $elemento=5; $elemento2=6;
            include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
            $res_anotador = mysql_query("SELECT codigousp,nome,categoria FROM pessoa where "
                             ."  codigousp=".$_SESSION["usuario_conectado"]." order by nome "); 
            if( ! $res_anotador ) {
                mysql_free_result($res_anotador);
                die('ERRO: Select pessoal.pessoa - falha: '.mysql_error());  
            }
            //  Cod/Num_USP/Autor/Anotador
            $m_linhas = mysql_num_rows($res_anotador);
            if ( $m_linhas<1 ) {
                $autor="== Nenhum encontrado ==";
            } else {
                $_SESSION["anotador_codigousp"]=mysql_result($res_anotador,0,"codigousp");
                $anotador_nome=mysql_result($res_anotador,0,"nome");
                $anotador_categoria=mysql_result($res_anotador,0,"categoria");                    
                mysql_free_result($res_anotador); 
            }
            // Final da Num_USP/Nome Autor/Anotador
         ?>  
     <span class='td_inicio1' style=" vertical-align: middle; text-align: left; border:none;  background-color:#FFFFFF; color: #000000;" title='Nome do Anotador do Projeto' >
             <?php echo $anotador_nome;?>
       </span>
       <input type="hidden" name="autor" id="autor" size="80" maxlength="86"  value="<?php echo $_SESSION["anotador_codigousp"];?>" />
      </td>
    </tr>
   </table>
   </td>
   </tr>
  
   <tr style="margin: 0px; padding: 0px;  "  >
    <td  class="td_inicio1" style="text-align: left;margin: 0px; padding: 0px;" colspan="<?php echo $cols;?>"  >
	 <table style="text-align: left;margin: 0px; padding: 0px;"  >
    <tr id="tr_coord_proj" style="text-align: left; vertical-align:middle;background-color:#FFFFFF; color: #000000; "  >
    <td  class="td_inicio1" style="vertical-align: middle; text-align: left; background-color:#FFFFFF; color: #000000;"  >
	   <label style="vertical-align: middle; cursor: pointer;text-align: left; background-color:#FFFFFF; color: #000000;"  ><span class="asteristico" style="vertical-align: middle;" >*</span>&nbsp;<span style="vertical-align: baseline;" >Projeto:</span>&nbsp;</label>
        <!-- Identifica??o do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
		<?php  
           //   Primeira Parte  da  Anotacao  selecionando  o Projeto
           $_SESSION["orientador"]="supervisor";
           $_SESSION["anotacao_numero"]=0;
           /*
   		   $result_pessoa = mysql_query("SELECT codigousp,nome,categoria FROM pessoal.pessoa "
                            ." where upper(categoria)='DOC' order by nome "); 
           */    
//           $anotador_cip = $_SESSION['anotador_cip'];
//           $result_pessoa = mysql_query("SELECT a.codigousp,a.nome,a.categoria FROM pessoal.pessoa a, "
//                             ." rexp.projeto b where a.codigousp=b.autor and "
//                             ." b.cip=$anotador_cip order by a.nome "); 
     /*
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
        */
        if ( $permit_pa==$array_pa["chefe"] or $permit_pa==$array_pa["vice"]  ) {
            $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
                ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b WHERE a.codigousp=b.autor and "
                ." a.codigousp=".$_SESSION["usuario_conectado"]." order by b.titulo ";

        }        
        if ( $permit_pa==$array_pa["anotador"] ) {
             //  SESSION do arquivo tabela_consulta_anotacao_nova.php
             $anotacao_inserir="";
             if( isset($_SESSION["anotacao_nova"]) ) $anotacao_inserir=" b.cip=$cip_escolhido and ";
             $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo, "
                             ." b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b, $bd_2.anotador c "
                             ." WHERE a.codigousp=b.autor and  "
                             ." b.cip=c.cip and c.codigo=".$_SESSION['anotador_codigousp']." order by b.titulo "; 
        } elseif( $permit_pa==$array_pa["orientador"] ) {          
               $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo, "
                             ." b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b "
                             ." WHERE a.codigousp=b.autor and "
                             ." b.autor=".$_SESSION["usuario_conectado"]." order by b.titulo ";               
        }  
        //
        $result_pessoa=mysql_query($sqlcmd);
        //                  
		if( ! $result_pessoa ) {
                $msg_erro .= "Selecionando os projetos autorizados para esse Anotador - falha no mysql/query:"
                              .mysql_error().$msg_final;
                echo $msg_erro;
                exit();
        }
        // $count_arr_cnc = count($arr_cnc["fonterec"])-1;
        //  Identifica??o da Fonte de Recurso
        $m_linhas = mysql_num_rows($result_pessoa);
	   ?>
       <select name="projeto"  id="projeto" class="td_select"  title="Identificacao do Projeto" onchange="javascript:  cad_dados_anotacao('anotacao',this.id,this.value)"    >                   
          <?php
           if ( $m_linhas<1 ) {
                   $autor="== Nenhum encontrado ==";
           } else {
		       ?>
			    <option value='' >Selecione o Projeto que corresponde essa Anota&ccedil;&atilde;o &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
			    <?php
                  while($linha=mysql_fetch_assoc($result_pessoa)) {
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
                      $_SESSION["cip"]=$linha['cip'];
                      $cip=$_SESSION["cip"];
                      //  $_SESSION["anotacao_numero"]=$linha['anotacao'];
                      $autor_nome =$linha['nome'];
                      $titulo_projeto .= trim($projeto_titulo_parte);
                      //  Usando esse option para incluir espaco sobre linhas
                      echo  "<option value='' disabled ></option>";                  
                      $selected_projeto="";
                      if( isset($_SESSION["anotacao_nova"]) ) {
                          if( $cip_escolhido==$cip ) $selected_projeto="selected='selected'";
                          if( isset($_SESSION["anotacao_numero_nova"]) ) $_SESSION["anotacao_numero"]=1; 
                      }                                   
                      echo  "<option  value=".$linha['cip']."  $selected_projeto  title='Orientador do Projeto: $autor_nome' >"
                                  .$titulo_projeto."&nbsp;&nbsp;</option>";   
                  }
			   ?>
			   </select>
			  <?php 
              mysql_free_result($result_pessoa); 
           }
           ?>  
           <!-- Final da Num_USP/Nome Responsavel  -->
        </td>
  		<!-- aqui vair ser incluida uma TD -->			
    </tr>
	</table>
	</td>
	</tr>
  </table>
  <table class="table_inicio" cols="<?php echo $cols;?>" align="center"   cellpadding="1"  cellspacing="1" style=" border: 1px solid #000000; margin: 0; padding: 0; font-weight: normal; color: #000000; "  >
   <tr id="tr_projeto_autor_nome" class="td_inicio1" style="display: none; vertical-align: middle; text-align: justify;  margin: 0px; border: none;"  >
    <td  id="td_projeto_autor_nome" class="td_inicio1" style="vertical-align: middle; text-align: left; border: none;" colspan="<?php echo $cols;?>"  >
         <label >Orientador desse Projeto:&nbsp;</label>
           <span class='td_inicio1' id="span_proj_autor_nome" style=" vertical-align: middle; text-align: left; border:none;  background-color:#FFFFFF; color: #000000;" >             
          </span>
   </td>
   </tr>
  </table>
   
  <table class="table_inicio" cols="<?php echo $cols;?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; "  >
    <tr class="td_inicio1" >
     <td class="td_inicio1"  colspan="2" style="text-align: right; background-color:#FFFFFF; color:#000000;" >Anota&ccedil;&atilde;o#</td>
     <!--  Nr. Anotacao 
        <td id="nr_anotacao" class="td_inicio1"  style="vertical-align:middle; text-align: left;  background-color:#FFFFFF; color:#000000; " >&nbsp; 
        </td>
     -->
     <td id="nr_anotacao" class="td_inicio1" style="text-align: left; background-color:#FFFFFF; color:#000000;"  >
         <?php echo $_SESSION["anotacao_numero"];?>
     </td>
     <!--  Data da Anotacao  -->
       <td class="td_inicio1" style="text-align: left; background-color:#FFFFFF; color:#000000;"  >Data:&nbsp;<?php echo $_SESSION["data_de_hoje"];?></td>
    </tr>
    
	 <tr  >     
	 <td class="td_inicio1" colspan="4" >
	 <table style="text-align: left;margin: 0px; padding: 0px;" width="100%"  >
    <tr style="text-align: left; vertical-align:middle;"  >
	   <!--  Titulo Anotacao -->
	    <td class="td_inicio1" style="vertical-align: top;text-align: left;"  >
          <label for="titulo"  style="vertical-align: top;"  title="T&iacute;tulo da Anota&ccedil;&atilde;o" >
             <span class="asteristico" >*</span>&nbsp;T&iacute;tulo da Anota&ccedil;&atilde;o:&nbsp;
          </label>
		<textarea rows="3" cols="72" name="titulo" id="titulo" onKeyPress="javascript:limita_textarea('titulo');"  title="Digitar T&iacute;tulo da Anota&ccedil;&atilde;o" style="vertical-align: top;cursor: pointer; overflow:auto;" onblur="javascript: alinhar_texto(this.id,this.value)"  ></textarea>     
		</td>
	   <!--  FINAL - Titulo Anotacao -->		
    </tr>	
   </table>
    </td>
	</tr>
	    
	 <tr>
	   <!--  Altera ou Complementa o Projeto.  Nulo ou zero, caso negativo. -->
	    <td id="sn_altera_complementa"   class="td_inicio1" style="text-align: left;" colspan="<?php echo $cols/2;?>"  >
	</td>
	  <td  id="td_altera_complementa" class="td_inicio1"  style="text-align:left; "  colspan="<?php echo $cols/2;?>" >
	  </td>
	   <!--  FINAL - Indicador de continua??o do experimento -->		
     </tr>
     
   <tr style="text-align: left;"  >
    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="testemunha1"  style="vertical-align:bottom; cursor: pointer;"  title="Código da Testemunha (1) da realiza??o " >Testemunha (1):&nbsp;</label>
      <br />
        <!-- Código da Testemunha (1) da realiza??o -->
		<?php 
            //  Conectar
            $elemento=5; $elemento2=6;
            include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");	
		    $result2=mysql_query("SELECT codigousp,nome,categoria FROM  $bd_1.pessoa order by nome ");
		?>
        <select onfocus="javascript: document.getElementById('label_msg_erro').style.display='none';" name="testemunha1" id="testemunha1" class="td_select"  title="Código da Testemunha (1) da realiza??o " >
		<?php
               //  Código da Testemunha (1) da realiza??o 
	           $testemunhas_result = $result2;
    		   include("../includes/testemunhas.php"); 
          ?>
          </select>
          <?php
            mysql_free_result($result2); 
           // FINAL - Código da Testemunha (1) da realiza??o 
           ?>  
        </td>

    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="testemunha2"  style="vertical-align:bottom; cursor: pointer;"  title="Código da Testemunha (2) da realiza??o "  >Testemunha (2):&nbsp;</label>
      <br />
        <!-- Código da Testemunha (2) da realiza??o -->
		<?php 
            $elemento=5;
            //  mysql_db_query -  essa funcao esta desativada usar mysql_query
		    //  $result=mysql_db_query($db_array[$elemento],"SELECT codigousp,nome,categoria FROM pessoa order by nome ");
            $result=mysql_query("SELECT codigousp,nome,categoria FROM pessoa order by nome ");
            if( ! $result ) {
                $msg_erro .= "SELECT Tabela pessoa -  db/mysql: ".mysql_error().$msg_final;
                echo $msg_erro;
                exit();  
            }
		?>
        <select name="testemunha2" id="testemunha2" class="td_select" title="Código da Testemunha (2) da realiza??o" >
		<?php
             //  Código da Testemunha (2) da realiza??o 
	         $testemunhas_result = $result;
      	     include("../includes/testemunhas.php"); 
          ?>
          </select>
          <?php
             mysql_free_result($result); 
             // FINAL - Código da Testemunha (2) da realiza??o 
           ?>  
	      <input  type="hidden"  id="data"  name="data"  value="<?php echo $_SESSION["datetime"];?>" />
         </td>
       </tr>
	
          <!--  TAGS  type reset e  submit  --> 
           <tr align="center" style="border: none; vertical-align:top; " >
             <td colspan="5" align="CENTER" nowrap style="text-align:center; border: none;" >
			  <table border="1" cellpadding="1" cellspacing="1" align="center" style="width: 100%; vertical-align: top; " >
			    <tr style="border:none; " >
				<td  align="CENTER" nowrap style="text-align:center; border:none;" >
			   <button name="limpar" id="limpar"  type="reset" onclick="javascript: document.getElementById('msg_erro').style.display='none';"  class="botao3d" style="cursor: pointer; "  title="Limpar"  acesskey="L"  alt="Limpar"     >    
      Limpar <img src="../imagens/limpar.gif" alt="Limpar" style="vertical-align:text-bottom;" >
   </button>
               <!-- Enviar -->				  
			      </td>
			   <td  align="center"  style="text-align: center; border:none; ">
			   <button name="enviar" id="enviar"   type="submit"  class="botao3d"  style="cursor: pointer; "  title="Enviar"  acesskey="E"  alt="Enviar"     >    
      Enviar&nbsp;<img src="../imagens/enviar.gif" alt="Enviar"  style="vertical-align:text-bottom;"  >
   </button>
			  </td>
              <!-- Final -Enviar -->
			   </tr>
              <!--  FINAL - TAGS  type reset e  submit  -->
              <tr style="margin: 0px;"  >
                <td align="left" colspan="2"  >
                 <span class="asteristico" >*</span>&nbsp;<b>Campo obrigat&oacute;rio</b>    
                </td>
              </tr>
			  </table>
		     </td>
          </tr>
       </table>
</form>
</div>
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("../includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
