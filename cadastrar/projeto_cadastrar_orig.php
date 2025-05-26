<?php 
/**  
*
*    EDITANDO: LAFB/SPFB110903.0934
*
*    REXP - CADASTRAR PROJETO   
*
*    LAFB/SPFB110901.2219
*/
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
//
//  Para exibir ERROS
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL);
//
/**  Tamanho Maximo do Arquivo  no php.ini  */
//  echo ini_get('upload_max_filesize');
//
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
      ///  Alterado em 20180621
     $msg_erro .= "<br/>Ocorrido na parte: $n_erro.".$msg_final;  
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
/// $_SESSION['time_exec']=180000;
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) {
     $_SESSION["titulo_cabecalho"]= utf8_decode("Registro de Anotação") ;  
} 
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
///
///
/*  UPLOAD: FILEFRAME section of the script
      verifica se o arquivo foi enviado      */
///  $_SESSION["display_arq"]='none';
$_SESSION["display_arq"]='none';
$_SESSION["div_form"]="block";
$_SESSION["result"]=''; 
$_SESSION["msg_upload"]="";
//
/** Caso METODO POST utilizado  */
if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    //
    $_SESSION["div_form"]="none";
    //
    /// include("../includes/functions.php");
    include("{$_SESSION["incluir_arq"]}includes/functions.php");
    //
    //  NOME TEMPORÃ?RIO NO SERVIDOR
    if( isset($_FILES['relatproj']['tmp_name']) ) {
        //
        $_SESSION["result"]='OK'; $erros="";
        $_SESSION["display_arq"]='block';
        //
        /** Conjunto de arquivos - ver tamanho total dos arquivos ***/
        $tam_total_arqs=0; 
        $files_array= array(); 
        //
        /**  Verifique caso for array de múltiplos arquivos  */
        if( is_array($_FILES['relatproj']['tmp_name'])) {
            //
            // Se for um array (vários arquivos)
            $conta_arquivos = count($_FILES['file']['tmp_name']);
            //
        } else {
            //
            // Se for apenas um arquivo
            $conta_arquivos=1;
        } 
        ///
        //
    	//  Verificando se existe diretorio
         $msg_erro =  "<p "
			   ." style='text-align: center; font-size: small; font-family: Verdana, Arial, Helvetica, sans-serif, Times, Georgia; font-weight:bolder;' >";
        $msg_erro_final = "</p>";
        //
        if( intval($conta_arquivos)<1 ) {
             //
             $_SESSION["msg_upload"] = $msg_erro."ERRO: Falta INDICAR o arquivo.".$msg_erro_final;
	         $_SESSION["result"]='FALSE'; $erros="ERRO";
        }
        /**  Final - if( intval($conta_arquivos)<1 ) {  */
        //
    	/**    Esse For abaixo para ACRESCENTAR diretorios caso NAO tenha  
        *    if ( $tamanho_dir[0]<1  or  !file_exists($_SESSION["dir"]) ) {  
        *    Tem que ser maior que 8 bytes
        */
	    for( $n=1; $n<3 ; $n++ ) {
             //
             if( intval($n)==1 ) {
                 $_SESSION["dir"] ="{$_SESSION["incluir_arq"]}doctos_img/A".$_POST["autor_cod"];  
             } 
             //        
             if( intval($n)==2 ) $_SESSION["dir"] .= "/projeto/";	   
             //
	         if( !file_exists($_SESSION["dir"]) ) {  //  Verificando dir e sub-dir
                  //
                  $r = mkdir($_SESSION["dir"],0755);
	              if( $r===false ) {
                      //
    			     ///  echo  $msg_erro;
				     $_SESSION["msg_upload"] = $msg_erro."Erro ao tentar criar diret&oacute;rio".$msg_erro_final;
                     //
				     ///  die("Erro ao tentar criar diret&oacute;rio");
			 	     $_SESSION["result"]='FALSE';  $erros='ERRO';
		          } else {
                     chmod($_SESSION["dir"],0755);                                                   
                  }
                  //
	         }
             /**  Final - if( !file_exists($_SESSION["dir"]) ) {  */
             //
	    }   
        /**  Final - for( $n=1; $n<3 ; $n++ ) {  */
        //
        //
        $tamanho_dir = shell_exec("/usr/bin/du  ".$_SESSION["dir"]);  // tamanho em bytes do diretorio
        $tamanho_dir = explode("/",$tamanho_dir);
        //
        if( intval($conta_arquivos)>1 ) {
           	for( $i=0; $i < $conta_arquivos; $i++) {
                  $tam_total_arqs += $_FILES["relatproj"]["size"][$i];     
            } 
        } else {
           $tam_total_arqs = $_FILES["relatproj"]["size"];   
        }
        //
        //
        $tamdir= (int) $tamanho_dir[0];
        $tot_dirarq = (int) $tamdir+$tam_total_arqs;
        //
	    /**   O Tamanho maximo no arquivo configurado no  php.ini   */
        /*   $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
        *       $upload_max = ($ini_max * 1024)*1000000;
        */
        /***   an array to hold messages     ***/
        //  $messages=array(); 
	    $files_size= array(); $files_date= array();
        /**  check if a file has been submitted   */
        //
        if( $_SESSION["result"]=='OK' ) {
            //
		    /***  tamanho maximo do arquivo admitido em bytes   ***/
  		    $max_file_size = 524288000; /// bytes - B
            //
/**            
  echo "LINHA/191 -->> \$max_file_size = $max_file_size  <<-->>  \$tamanho_dir[0] = ".$tamanho_dir[0];
  exit();            
  */
  
            // 
		    $espaco_em_disco = (int) $max_file_size-$tamdir;
		    if ( $espaco_em_disco<1024 ) $tipo_tamanho = "bytes";
            //
		    if( $espaco_em_disco>1024 and  $espaco_em_disco<1024000 ) {
		         $tipo_tamanho = "KB"; $espaco_em_disco= intval($espaco_em_disco/1024);
	   	    } else if ( $espaco_em_disco>=1024000 ) {
	   	         $tipo_tamanho = "MB"; $espaco_em_disco= intval($espaco_em_disco/1024000);
		    }
		    //
	        if( intval($tot_dirarq)>intval($max_file_size) ) {
                //
	             $erros='ERRO';
			     $result_msg= "No tem espa&ccedil;o no disco para esse arquivo. Cancelado\\n";
			     $result_msg .= " espa&ccedil;o disponvel no disco de ".$espaco_em_disco." $tipo_tamanho\\n";
	             $_SESSION["msg_upload"] = $msg_erro.$result_msg.$msg_erro_final;
                 //
		    } 
            /**  Final - if( $tot_dirarq > $max_file_size ) {  */
            //
            /** loop atraves do conjunto de arquivos ***/
            //  verifica se o arquivo esta no conjunto (array)
            if( !is_uploaded_file($_FILES["relatproj"]['tmp_name']) ) {
                //
			    // $messages[]="Arquivo n&atilde;o armazenado\n"; 
		  	    $_SESSION["msg_upload"] = $msg_erro."Arquivo n&atilde;o armazenado\n".$msg_erro_final;
         		//  $erros[]='ERRO';
				$erros='ERRO';
                //
            } elseif( $_FILES["relatproj"]['tmp_name'] > $max_file_size )  {
                //
                /**  verifica se o arquivo menor que o tamanho maximo permitido  */
                $_SESSION["msg_upload"]= $msg_erro."O arquivo excedeu o tamanho limite permitido $max_file_size $tipo_tamanho ";
	   		    $_SESSION["msg_upload"].=$msg_erro_final;
			    $erros = 'ERRO';
                //
            } else {
                //
                /**
                *          COPIA o arquivo para o diretorio especificado
                *     IMPORTANTE: usar utf8_decode pra UPLOAD - 20250328
                *  $filename="P".$_POST["nprojexp"]."_".utf8_decode(trim($_FILES["relatproj"]["name"]));
               */
                $flnnew= preg_replace('/\s+/', '_',trim($_FILES["relatproj"]["name"]));
		    	$filename="P".$_POST["nprojexp"]."_"."{$flnnew}";
                //
                //  IMPORTANTE:  trocar espacos por hifen
                //  $filename=preg_replace("/\s+/","_",$filename);
			  /**  if( @copy($_FILES["relatproj"]['tmp_name'],$_SESSION["dir"].$filename) ) {  */
                if( @move_uploaded_file($_FILES["relatproj"]['tmp_name'],$_SESSION["dir"]."$filename") ) {    
                    //
                    /*** give praise and thanks to the php gods ***/
					$erros='';
                    //
                    $_SESSION["msg_upload"]= $msg_erro."Arquivo: ";
                    //  .$_FILES["relatproj"]["name"].' foi armazenado&nbsp;';
                    $_SESSION["msg_upload"].="$flnnew foi armazenado&nbsp;";
         			$_SESSION["msg_upload"].=$msg_erro_final;
					$files_array[]=$_FILES["relatproj"]["name"];
					$files_size[]=$_FILES["relatproj"]["size"];
					//  filemtime â€” ObtÃ©m o tempo de modificaÃ§Ã£o do arquivo
            	    $files_date[] = date('d/m/Y H:i:s', filemtime($_SESSION["dir"].$filename));
					$files_type[] = mime_type($filename);
                    //
					// Permissao do arquivo
					chmod($_SESSION["dir"].$filename,0755);									
                    //
                } else  {
                    //
                    /***  an error message  ***/
                    $_SESSION["msg_upload"]= $msg_erro.'Armazenamento '.$_FILES["relatproj"]["name"].' FALHA';
         			$_SESSION["msg_upload"].=$msg_erro_final;
		     	    $erros = 'ERRO';
                }
                //
		    }
            //
        }
        /**  Final - if( $_SESSION["result"]=='OK' ) { */
        // 
        //
        $_SESSION["erros"] = trim($erros);
        //
	    /**   Incluindo o nome do arquivo na tabela  projeto  */
        if( trim($erros)=='' ) {
             //
             /**
             *      OCORREU  ERRO NESSA JANELA DO JAVASCRIPT
             *   OCORREU  echo "<p style='text-align: center;'>Aguarde um momento.</p>";
             */
	         $elemento=5; $elemento2=6;  
             include("php_include/ajax/includes/conectar.php");
             //
             /**  COnexao MYSQLI  */
             $conex = $_SESSION["conex"];
             //
		     //  $local_arq0 = $_SESSION["dir"].$filename;
	         $nprojexp = $_POST["nprojexp"];
             $autor_cod = $_POST["autor_cod"];  ///  Codigo do Autor do Projeto  
             /***  
             *     IMPORTANTE: alterado em 20180727
             *         toda parte de acentuacao PHP?MYSQL
             *      mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - 
             *        Use mysql_select_db() ou mysql_query()
             ***/   
             ini_set('default_charset','utf8');
             /***
            *    O charset UTF-8  uma recomendacao, 
            *    pois cobre quase todos os caracteres e 
            *    símbolos do mundo
            ***/
            //  mysql_query("SET NAMES 'utf8'"); 
            $_SESSION["conex"]->set_charset("utf8");
            //
            //  mysql_query('SET character_set_connection=utf8'); 
            //  mysql_query('SET character_set_client=utf8'); 
            //  mysql_query('SET character_set_results=utf8'); 
            //  mysql_set_charset('utf8');
            //
            //  $local_arq = utf8_decode($local_arq); 
            $local_arq = utf8_encode($filename); 
            //
            //  UPDATE Projeto/Arquito
            $proc="UPDATE $bd_2.projeto SET relatproj='$local_arq' ";
            $proc.=" WHERE  numprojeto=$nprojexp and autor=$autor_cod  ";
            $success = $conex->query("$proc");
            //
            //  Verificando se houve falha ou nao no UPDATE
            if( ! $success ) {
                //
                $terr=$msg_erro.'Armazenamento '.$_FILES["relatproj"]["name"].' FALHA:&nbsp;db/mysqli:&nbsp;';
                $_SESSION["msg_upload"]= "$terr";
                $_SESSION["msg_upload"].=mysqli_error($_SESSION["conex"]).$msg_erro_final;
                //
            } else {
                //
                /**  Select/MYSQLI -   Selecionando o nome do autor   */
                $proc="SELECT nome FROM  $bd_1.pessoa WHERE codigousp=$autor_cod  ";
                $success=mysqli_query($_SESSION["conex"],"$proc");
                //
                if( ! $success  ) {
                    //
                    $terr=$msg_erro.'Selecionando o nome do autor do Projeto - FALHA:&nbsp;db/mysql:&nbsp;';
                    $_SESSION["msg_upload"]="$terr";
                    $_SESSION["msg_upload"].=mysqli_error($_SESSION["conex"]).$msg_erro_final;
                    //
                } else {
                   //
                   //  Nr. de registros 
                   $nregs=mysqli_num_rows($success);
                   //
                   // Verificando 
                   if( intval($nregs)>0 ) { 
                       //
                       //  Caso encontrou nome do autor
                       // $autor_proj=htmlentities(mysql_result($success,0,0),ENT_QUOTES,"UTF-8");
                       /**
                       *   $linha = $resultado->fetch_assoc();
                       *     $nome = $linha['nome']; // Acessa o valor do campo 'nome'
                       */
                       $autor_proj=mysqli_result($success,0,"nome");
                       //
                       $_SESSION["msg_upload"] .= $msg_erro."Projeto $nprojexp do autor ".$autor_proj;
                       $_SESSION["msg_upload"] .= " foi conclu&iacute;do.";
                       $_SESSION["msg_upload"] .=$msg_erro_final;            
                       //
                   } else {
                       //
                      ///  Caso NAO encontrou nome do autor
                      $_SESSION["msg_upload"]= $msg_erro.'Nome do autor do Projeto não encontrado.';
                      $_SESSION["msg_upload"].=$msg_erro_final;
                   }
                   //
                }
                //
            }     
            //     
            //
	    }
        /**  FInal - if( trim($erros)=='' ) {  */
        //
     
    }
    /**  Final - if( isset($_FILES['relatproj']['tmp_name']) ) {  */ 
    //
}
/**  Final - if( $_SERVER["REQUEST_METHOD"] == "POST" ) {  */
//
$http_host="";
if( isset($_SESSION["http_host"]) ) {
     $http_host=$_SESSION["http_host"];  
} 
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
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Cadastrar Projeto</title>
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
//
//  Arquivo javascript em PHP
//  
include("{$_SESSION["incluir_arq"]}js/projeto_cadastrar_js.php");
//
$_SESSION["n_upload"]="ativando";
//
//   Para mudar de pagina no MENU usando  dochange.php  ou  domenu.php
//  require("{$_SESSION["incluir_arq"]}includes/dochange.php");
require("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" >
<!-- onkeydown="javascript: no_backspace(event);" >  -->
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" >
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
<div  id="corpo" style="overflow: hidden; "  >
<?php
//   CADASTRAR PROJETO
//  $m_titulo="Projeto";
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//
if( isset($_SESSION["usuario_conectado"]) ) $usuario_conectado = $_SESSION["usuario_conectado"];
//  Definindo valores nas variaveis
if( isset($_SESSION["permit_pa"]) ) $permit_pa=$_SESSION["permit_pa"]; 
///   
?>
<!--  Mensagens e Titulo  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Cadastrar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final -  Mensagens e Titulo  -->
<?php
    $m_erro=0;
///  Verificando permissao para acesso Supervisor/Orientador
/// include("../includes/orientador_pa.php");
///
///  PA:  superusuario,  chefe,  subchefe, orientador, anotador  -  includes/array_menu.php
///  if( ( $_SESSION["permit_pa"]=="0"  or $_SESSION["permit_pa"]=="10"  or $m_pa_coord=="30" ) and $m_erro=="0"  ) {    
///  if( ( $_SESSION["permit_pa"]=="0"  or $_SESSION["permit_pa"]=="10"  ) and $m_erro=="0"  ) {    
/// if( ( $_SESSION["permit_pa"]<=$_SESSION["array_usuarios"]["superusuario"]  or $_SESSION["permit_pa"]>$_SESSION["array_usuarios"]["orientador"] ) and $m_erro=="0"  ) {    
if( ( $_SESSION["permit_pa"]<=$array_pa["super"]  or $_SESSION["permit_pa"]>$array_pa["orientador"] ) and $m_erro=="0"  ) {    
    //
    echo  "<p  class='titulo_usp' >Procedimento n&atilde;o autorizado.<br>"
                ."N&atilde;o consta como Orientador ou Superior</p>";
    exit() ;
}
//
if( strlen(trim($_SESSION["msg_upload"]))>1 ) {
    //
?>
<script type="text/javascript" language="javascript">
    document.getElementById('label_msg_erro').style.display="block";              
    ////  document.getElementById('msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";
    document.getElementById('label_msg_erro').innerHTML="<?php echo $_SESSION["msg_upload"]; ?>";              
</script>
<?php
    if( strlen(trim($_SESSION["erros"]))<1 ) $_SESSION["display_arq"]='none';
}       
///
?>        
<!-- Parte do arquivo PDF - Relatorio do Projeto  -->
<div id="arq_link"  style="display: none;" >
  <form name="form_arq_link"  method="post"  enctype="multipart/form-data"  action="<?php echo $pagina_local; ?>" onsubmit="javascript: enviar_dados_cad('submeter','<?php echo $_SESSION["onsubmit_tabela"];?>',document.form1); return false" >
     <table border='0' cellpading='0' cellspacing='0' width='90%'>
       <tr  >
         <!-- Relatorio Externo (link) Projeto -->
          <td  class="td_inicio1" style="vertical-align: middle; "  colspan="1" >
            <label for="relatproj" style="vertical-align: middle; cursor: pointer; " title="link para o Arquivo do Projeto" >
             <span class="asteristico" >*</span>&nbsp;Arquivo (link):&nbsp;</label>
          </td  >
           <td class="td_inicio2" style="vertical-align: middle; " colspan="1"  >
               <!-- Target of the form is set to hidden iframe -->
               <!-- From will send its post data to fileframe section of this PHP script (see above) -->
               <input type="file" name="relatproj"  id="relatproj"  size="90" 
                     title="Relatório Externo do Projeto (link)" required="required" 
                     style="cursor: pointer; vertical-align:middle; " onChange="javascript: jsUpload(this);" />
               <input  type="hidden"  id="nprojexp" name="nprojexp"  />
               <input  type="hidden"  id="autor_cod" name="autor_cod" />       
               <input  type="hidden"  id="m_titulo" name="m_titulo"  value="<?php echo $_SESSION["m_titulo"];?>" />
            </td>
         <!-- FINAL - Relatorio Externo (link) Projeto -->
     </tr>
     <tr>
      <!--  Aviso na espera do processo -->
      <td  id="aguarde_arq"  style="display:block; text-align: center; background-color: #FFFFFF; color: #000000;;"   colspan="2"    >
         Aguarde. Esse processo pode demorar...   
      </td>
      <!-- Final - Aviso na espera do processo -->   
     </tr>    
     <!--  Enviar Relatorio/Arquivo Projeto  -->
     <tr>
       <td  align="center"  style="text-align: center; border:none;" colspan="2" >
         <button  type="submit" name="enviar_arq" id="enviar_arq" class="botao3d" 
            style="width: 160px; cursor: pointer;" title="Enviar"  acesskey="E"  alt="Enviar" 
               onclick="javascript: if( trim(document.getElementById('relatproj').value)=='' ) { alert('Importante: informar o arquivo do Projeto.'); document.getElementById('relatproj').focus(); return false; } " >
             Enviar arquivo&nbsp;<img src="../imagens/enviar.gif" alt="Enviar Arquivo"  style="vertical-align:text-bottom;"  >
          </button>
        </td>
    </tr>
    <tr>
        <td  style="display:block; text-align: left; background-color: #FFFFFF; color: #000000;;"   colspan="2"    >
          <span class="asteristico" >*</span>&nbsp;<b>Campo obrigat&oacute;rio</b>    
       </td>
    </tr>       
    <!-- Final - Enviar Relatorio/Arquivo Projeto  -->   
   </table>
 </form>
  <script type="text/javascript">
    //
   /** This function is called when user selects file in file dialog */
    function jsUpload(upload_field) {
            //
            /**  Apenas um exemplo de verificacao de extensoes de arquivo   */
            //  var re_text = /\.txt|\.xml|\.zip/i;
            var re_text = /\.pdf/i;
            /**
            *   Nome do Arquivo
            */
            var filename = upload_field.value;
            //
            /**
            *   Tamanho do arquivo em bytes
            */
             var xsize = upload_field.files[0].size;            

        /**    
            alert(" filename =  "+filename+"  -->>  xsize = "+xsize);
           */ 
            
            //
            /** Checking file type */
             var merro=0;
             if( filename.search(re_text)==-1)  {
                  //
                  //  alert("File does not have text(txt, xml, zip) extension");
                  alert("ERRO: Esse arquivo não tem formato PDF");
                  //  upload_field.form.reset();
                  merro=1;
             } else {
                 //
                 var n = filename.search(/[%*/$#@&]/);
                 if( n!=-1 ) {
                     alert("ERRO: Nome do arquivo não pode conter símbolos como: %*/$#@& \r\nCorrigir renomear.");
                     merro=1;
                 }
                 /**  Final - if( n!=-1 ) { */
                 //
             }
             //
             /**   1 MB (megabyte)  igual a 1.048.576 bytes.   */
             //  if( size > 3145728) {    // 3 MB         
             //  if( xsize > 2097152  ) { // 2 MB   
             if( xsize > 10485760 ) { // 10 MB   
                 //
                 //  Acima do Limite
                 alert('Não permitido arquivo acima de 10 MB - Corrigir.');  
                 merro=1;
             }
             /**  Final - if( xsize > 10485760 ) {  */
             //
             if( xsize < 1 ) { //  Arquivo Vazio   
                 //
                 //  Acima do Limite
                 alert('Arquivo Vazio - Corrigir.');  
                 merro=1;
             }
             /**  Final - if( xsize < 1 ) {  */
             //
             ///  Verifica se houve erro
             if( parseInt(merro)>0 ) {
                 /**
                 *   HOUVE ERRO
                 */
                  document.getElementById('relatproj').value="";
                  document.getElementById('relatproj').InnerHTML="";
                  document.getElementById('relatproj').focus();
                  //
                  return false;
             }
             /**  FInal - if( parseInt(merro)>0 ) {  */
             //
             /**
                upload_field.form.submit();
                document.getElementById('upload_status').value = "uploading file...";
                upload_field.disabled = true;
                return true;
             */
    }
    /**  Final - function jsUpload(upload_field) {  */
    //
  </script>
</div>
<!--  Final - Parte do arquivo PDF - Relatorio do Projeto  -->
<!--  DIV abaixo os dados antes de pedir arquivo para upload   -->
<div id="div_form" class="div_form" >
   <form name="form1" id="form1"  method="post" enctype="multipart/form-data" style="height: auto;"  >
      <!-- div - ate antes do Limpar e Enviar -->
      <div class="parte_inicial"  >

        <div class="div_nova" >
           <!-- N. Funcional USP - Autor/Orientador -->
           <span>
              <label title="Orientador do Projeto">Orientador:&nbsp;</label>
           </span>
           <span>
           <?php 
                //
                ///  Verificando se session_start - ativado ou desativado
                $elemento=5; $elemento2=6;
                include("php_include/ajax/includes/conectar.php");                                    
                //
                /**  COnexao MYSQLI  */
                $conex = $_SESSION["conex"];
                //
                /***          
                *     mysql_query("SET NAMES 'utf8'");
                *     mysql_query('SET character_set_connection=utf8');
                *     mysql_query('SET character_set_client=utf8');
                *     mysql_query('SET character_set_results=utf8');
                ***/
                //  Executando Select/MySQL
                ///   Utilizado pelo Mysql/PHP - IMPORTANTE -20180615      
                /***
                    *    O charset UTF-8  uma recomendacao, 
                    *    pois cobre quase todos os caracteres e 
                    *    símbolos do mundo
                ***/
                $_SESSION["conex"]->set_charset("utf8");
                //
                //  Select/MYSQLI usando duas Tabelas
                $sqlcmd="SELECT distinct a.codigousp,a.nome,a.categoria FROM "
                          ." $bd_1.pessoa a, $bd_1.usuario b WHERE "
                          ." a.codigousp=b.codigousp and a.codigousp=$usuario_conectado and "
                          ." b.pa<=".$array_pa["orientador"]." order by a.nome "; 
                //
                $result = mysqli_query($_SESSION["conex"],"$sqlcmd");
                if( ! $result ) {
                     //
                     $terr="ERRO: Select tabelas pessoa e usuario -&nbsp;db/mysqli:&nbsp;";
                     die("$terr".mysqli_error($_SESSION["conex"]));  
                }
                //
                //  Cod/Num_USP/Autor
                $m_linhas = mysqli_num_rows($result);
                if( intval($m_linhas)<1 ) {
                     $autor="== Nenhum encontrado ==";
                } else {
                   //
                   $_SESSION["autor_codigousp"]=$usuario_conectado;
                   $autor_nome=mysqli_result($result,0,"nome");
                   $autor_nome=htmlentities($autor_nome,ENT_QUOTES,"UTF-8");
                   $autor_categoria=mysqli_result($result,0,"categoria");;
                   //
                }
                //
                /**  Desativar variavel  */
                if( isset($result) ) {
                    //
                    mysqli_free_result($result);   
                } 
                /**  FInal - if( isset($result) ) {  */
                //
                /**
                *      Final da Num_USP/Nome Responsavel
                *   echo "<span class='td_inicio1' title='Nome do Autor ResponsÃ¡vel do Projeto' >$autor_nome</span>";
                *         Numero do novo PROJETO
                */
                // 
                //  Verificando campos 
                $m_regs=0;
                //
                //   SELECT MYSQLI
                $xautorcod="";
                if( isset($_SESSION['autor_codigousp']) ) {
                    $xautorcod=$_SESSION['autor_codigousp'];
                }
                //
                $proc="SELECT  max(numprojeto) as n FROM $bd_2.projeto ";
                $proc.=" WHERE trim(autor)=$xautorcod "; 
                $result_projetos=$conex->query("$proc");
                //
                // verificando 
                if( ! $result_projetos ) {
                     //
                     $terr="ERRO: Consultando n&uacute;mero do &uacute;ltimo projeto -&nbsp;db/mysqli:&nbsp;";
                     die("$terr".mysqli_error($_SESSION["conex"]));
                     exit();
                }
                //
                //  Nr. de Projetos  
                $num_projs = (int) mysqli_result($result_projetos,0,"n");
                //
                $_SESSION["numprojeto"]=$num_projs+1;
                //
                /**  Desativar variavel  */
                if( isset($result_projetos) ) {
                      mysqli_free_result($result_projetos);  
                } 
                //  htmlentities($descricao,ENT_QUOTES,"UTF-8")
                //
           ?>  
             <span class='td_inicio1' style="height: auto; border:none; background-color:#FFFFFF; color:#000000;" title='Nome do Autor Responsável do Projeto' >
                 &nbsp;<?php echo $autor_nome; ?>&nbsp;
             </span>
              <input type="hidden" name="autor" id="autor" size="80" maxlength="86"  value="<?php echo $_SESSION["autor_codigousp"];?>" />
                  <span class="td_inicio1" style="margin-left: 6px;" >
                      <label  title="N&uacute;mero do Projeto" >Nr. do Projeto:&nbsp;</label>
                           <span class='td_inicio1' style="padding: 0; overflow: hidden; border:none; background-color:#FFFFFF; color:#000000;" title='N&uacute;mero do Projeto' >
                                &nbsp;<?php echo $_SESSION["numprojeto"];?>&nbsp;
                           </span>
                           <input type="hidden" name="numprojeto" id="numprojeto"  value="<?php echo $_SESSION["numprojeto"];?>" />
                      </span>
                  </span>   
        </div>
        
        <div class="div_nova" >
           <!-- Titulo do Projeto  -->
           <span class="span_float" >
               <label for="titulo"  style="vertical-align: top; color:#000000; background-color: #32CD99; cursor:pointer;"   title="Título do Projeto" >
                   <span class="asteristico" style="color: #000000;vertical-align: top;" >*</span>&nbsp;T&iacute;tulo:&nbsp;
               </label>
           </span>
           <span>    
               <textarea rows="3" name="titulo" id="titulo"  
                    onKeyPress="javascript:exoc('label_msg_erro',0,'');limita_textarea('titulo');" 
                     title="Digitar T&iacute;tulo do Projeto"   required="required"
                    style="cursor: pointer; overflow:auto;"  onblur="alinhar_texto(this.id,this.value);"  >
               </textarea>      
           </span>
           <!-- Final - Titulo do Projeto  -->
        </div>
        
           
           
        <div class="div_nova" >
            <!-- Objetivo  -->
            <span>
                <label for="objetivo"  title="Objetivo do Projeto" >
                    <span class="asteristico" style="color: #000000;vertical-align: top;" >*</span>
                    &nbsp;Objetivo:&nbsp;
                </label>
            </span>
            <span>
               <?php 
                  //
                  //  Objetivo
                  // 
                  /**
                  *    $result2 = $mySQL->runQuery("select codigo,descricao from objetivo order by codigo ",$db_array[$elemento]); 
                  */
                  // 
                  $proc="SELECT codigo,descricao FROM $bd_2.objetivo  order by codigo  ";
                  $result2 = mysqli_query($_SESSION["conex"],"$proc"); 
                    ////
                    if( ! $result2 ) {
                        //
                        $terr="ERRO: Select codigo,descricao from objetivo -&nbsp;db/mysqli:&nbsp;";
                        die("$terr".mysqli_error($_SESSION["conex"]));  
                    }
                    /**  Final -if( ! $result2 ) {  */
                    ///
                    //  Nr. de Registros
                    $m_linhas=mysqli_num_rows($result2);
                    //
                    
                ?>
                  <!-- Objetivo  -->
                   <select name="objetivo" id="objetivo"  title="Selecionar Objetivo"  required="required"   >                   
                    <?php
                          //
                         /// Verifica o numero de registros
                         if( intval($m_linhas)<1 ) {
                              echo "<option value='' >== Nenhum encontrado ==</option>";
                         } else {
                             //
                              echo "<option value='' >== Selecionar ==</option>";
                              while( $linha=mysqli_fetch_array($result2) ) {       
                                      //
                                     $descricao=htmlentities($linha['descricao'],ENT_QUOTES,"UTF-8");
                                     echo "<option value=".$linha['codigo']." >";
                                     echo  ucfirst($descricao)."&nbsp;</option>" ;
                              }
                              /**  Final - while( $linha=mysqli_fetch_array($result2) ) {  */
                              //
                          ?>
                              </select>
                          <?php
                          }
                          //
                          /**  Desativar variavel  */
                          if( isset($result2) ) {
                                mysqli_free_result($result2);   
                          } 
                          /// Final objetivo
                    ?>  
                </span>          
           <!-- Final - Objetivo  -->
        </div>
           
        <div class="div_nova" >
           <!--  Fonte de Recurso -->
           <span>
         <label for="fonterec"  title="Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)"   >Fonte Principal de Recursos:&nbsp;</label>
           </span>
           <span>
            <input type="text" name="fonterec" id="fonterec"  class="fontrec"  maxlength="16" 
             title="Digitar Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, CAPES etc)"  
              onkeypress="javascript:exoc('label_msg_erro',0,'');" required="required"  
              onblur="javascript: alinhar_texto(this.id,this.value); soLetrasMA(this.id)" />
           </span>   
         <!-- Final - Fonte de Recurso -->
       </div>
  
       
       <div class="div_nova" >
          <!-- Nr. Processo  -->
            <span>
               <label for="fonteprojid"  title="Nr. Processo" >Nr. Processo:&nbsp;</label>
            </span>
            <span>
               <input type="text" name="fonteprojid" id="fonteprojid" class="fonteprojid" 
                 maxlength="24"   onkeypress="javascript:exoc('label_msg_erro',0,'');" 
                 title="Digitar Nr. Processo"  onblur="javascript: alinhar_texto(this.id,this.value)"   />
            </span>
          <!-- Final - Nr. Processo --> 
       </div>

    
       <div class="div_nova" >
         <!-- Data inicio do Projeto -->
          <span class="nleft" >
            <label for="datainicio"  title="Data de Início do Projeto" >
               Data in&iacute;cio:&nbsp;
            </label>
            <input type="date" name="datainicio"  id="datainicio" class="data"
                  title="Digitar Data in&iacute;cio - exemplo: 01/01/1998"  required="required" />
               <!-- Final - Data inicio do Projeto -->
            </span>
            <span class="nright" >
            <!-- Data Final do Projeto -->
            <label for="datafinal"  title="Data Final do Projeto" >Data final:&nbsp;</label>
               <input type="date" name="datafinal" id="datafinal"  class="data" 
                  title="Digitar Data Final - exemplo: 01/01/1998" />
               <!-- Final - Data Final do Projeto -->
            </span>   
       </div>


   
      <div class="div_nova" >
       <div>
       <!-- Numero de Coautores -->
        <span>
           <label for="coresponsaveis"  >N&uacute;mero de Co-Respons&aacute;veis:&nbsp;</label>
        </span>
        <input type="number" name="coresponsaveis" id="coresponsaveis" min="0"
           max="99"  pattern="[0-9]" 
           maxlength="3" title="Digitar  N&uacute;mero de Co-Respons&aacute;veis" 
            onkeypress="javascript:exoc('label_msg_erro',0,'');" 
           onKeyup="javascript: n_coresponsaveis(this,event); "  value="" 
            style="padding: 1px; font-weight: bold;" 
            onblur="javascript: if( this.value<1 ) exoc('incluindo_coresponsaveis',0);" />
            &nbsp;
        <input  type="button"  onclick="javascript: enviar_dados_cad('coresponsaveis');"  id="busca_coresponsaveis" 
          title='Clicar'  style="cursor: pointer; width: 60px;"   onkeypress="javascript:exoc('label_msg_erro',0,'');" 
            value="Indicar"  class="botao3d"  >
       <!-- Final - Numero de Coautores -->
       </div>
       <!-- Inclusao de Coautores - caso tenha no Projeto - fica Oculto sem Coresponsaveis -->
           <div id="incluindo_coresponsaveis" ></div>
       <!-- Final - Inclusao de Coautores -->           
   </div>    
                           
   </div>
   <!-- Final - div - ate antes do Limpar e Enviar -->

                            
    <!--  TAGS  type reset e  submit  -->                                        
        <div class="reset_button" >
           <!-- Limpar campos -->                  
            <span>
               <button type="button"  name="limpar" id="limpar" class="botao3d"  
                    onclick="javascript: enviar_dados_cad('reset','<?php echo "{$_SESSION["pagina_local"]}";?>'); return false;"  
                       title="Limpar"  acesskey="L"  alt="Limpar" >
                    Limpar&nbsp;<img src="../imagens/limpar.gif" alt="Limpar" >
               </button>
           </span>   
           <!-- Final - Limpar  -->
           <!-- Enviar -->                  
           <span>
              <button type="button" name="enviar" id="enviar" class="botao3d"    
                  title="Enviar"  acesskey="E"  alt="Enviar" 
                 onclick="javascript: enviar_dados_cad('submeter','PROJETO',this.form);return false;" >
                 Enviar&nbsp;<img src="../imagens/enviar.gif" alt="Enviar" >
              </button>
           </span>
           <!-- Final -Enviar -->
        </div>
        <!--  FINAL - TAGS  type reset e  submit  -->    

     </form>
  </div>
<!-- Final - DIV class div_form   -->
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
