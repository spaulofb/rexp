<?php 
/*   REXP - CADASTRAR ANOTADOR   
*   
*   REQUISITO: O usuário deve ter PA>0 e PA<=30
* 
*   SPFB&LAFB110906.1704
*   SPFB&LAFB110907.0943    
*/
//  ==============================================================================================
//  ATENÇÃO: SENDO EDITADO POR LAFB - REMOVER ANOTADOR
//  ==============================================================================================
//
//  Verificando se session_start - ativado ou desativado
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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" >
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
<title>REXP - Remover Anotador</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
///    Arquivo javascript em PHP
////  
include("{$_SESSION["incluir_arq"]}js/anotador_remover_js.php");
///  
require("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" >
<!-- Cabecalho -->
<div id="cabecalho" >
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo" >
<?php 
//   CADASTRAR ANOTADOR
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//				  
?>
<!--  Mensagens e Titulo  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Remover&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?><br/>
Para realizar Anota&ccedil;&atilde;o de Projeto</p>
</section>
<!-- Final -  Mensagens e Titulo  -->
<div id="div_form"  class="div_form" >
<?php
//   Definição das datas de controle para eventual registro (log)
date_default_timezone_set('America/Sao_Paulo');
$timestampInSeconds = $_SERVER['REQUEST_TIME'];  
$_SESSION["datacad"]= date("Y-m-d H:i:s", $timestampInSeconds);  
//
//  Verificando permissao para acesso Supervisor/Orientador
//  if( ( $_SESSION["permit_pa"]<=$_SESSION["array_usuarios"]["superusuario"] or  $_SESSION["permit_pa"]>=$pa_anotador ) ) {
if( ( $_SESSION["permit_pa"]<=$array_pa["super"] or  $_SESSION["permit_pa"]>=$pa_anotador ) ) {    
     echo  "<p  class='titulo_usp' >Procedimento n&atilde;o autorizado.<br>"
               ."N&atilde;o consta como Orientador ou Superior.<br>Consultar seu Orientador ou Chefe</p>";      
    exit();
} 
///
$cols=4;
?>
<!--  DIV abaixo   -->
<div  id="arq_link" style="overflow: auto; height: auto;"  >
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: enviar_dados_anotador('submeter','ANOTADOR',document.form1); return false;"  >

<!-- div - ate antes do Cancelar e  Remover -->
<div class="parte_inicial" >

   <div class="div_nova"   >
        <!-- Identificação do Projeto [CIP][ - Titulo] -->
        <span>
           <label for="projeto"  title="Identificacao do Projeto"   >
              Projeto:&nbsp;
           </label>
        </span>
        <span>
        <!-- Identificação do Projeto [CIP][ - Titulo] -->
        <?php 
          /////   IMPORTANTE: excelente para acentuacao da tag SELECT -  e tb  htmlentities        
            mysql_query("SET NAMES 'utf8'");
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');
           ///                         
            ///  Selecionando o Projeto desse Anotador
           $result = mysql_query("SELECT b.cip,b.titulo FROM $bd_2.projeto b WHERE b.autor=".
            $usuario_conectado." order by b.titulo "); 
           //                  
           if( ! $result ) {
                if( isset($result) ) mysql_free_result($result);
                die('ERRO: Selecionando os poss&iacute;veis projetos para esse Anotador: '.mysql_error());  
           }
           //  $count_arr_cnc = count($arr_cnc["fonterec"])-1;
            //  Identificação da Fonte de Recurso
           $nprojetos = mysql_num_rows($result);
           ?>
           <!-- tag select para selecionar o Projeto -->
           <SELECT name="projeto"  id="projeto" class="td_select" title="Identificação do Projeto" 
               onchange="javascript: enviar_dados_anotador(this.id,this.value)"  required="required" >
           <?php
           if( intval($nprojetos)<1 ) {
                $opcao_msg="N&atilde;o existe Projeto do atual Orientador/Superior.";
                ?>
                <option value='' >N&atilde;o existe Projeto do atual Orientador/Superior.</option>
                <?php
           } else {
               ?>
                <option value='' >Selecione o Projeto a ser acessado por esse Anotador a ser removido&nbsp;</option>
                <?php
                while( $linha=mysql_fetch_assoc($result) ) {
                      ///  
                      ////  echo "<option  value=".$linha['cip']."  >".$titulo."&nbsp;</option>";   
                      ///  $titulo=$linha['titulo'];
                       /// $titulo=html_entity_decode($linha['titulo'], ENT_QUOTES, "UTF-8");
                      $_SESSION["cip"]=$linha['cip'];
                      echo "<option  value=".$linha['cip']."  >".htmlentities($linha['titulo'],ENT_QUOTES,"UTF-8")."&nbsp;</option>";   
                     ////      
               }
              ?>
            </select>
             <?php 
           }
           ?>  
           <!-- Final da Num_USP/Nome Responsavel  -->
       </span>
   </div>    

   
      <table  class="div_nova"  style="border: none; margin:0; padding: 0;;">
       <tr>
        <td>
         <!-- Anotador do Projeto escolhido -->
            <label for="codigousp"  style="vertical-align: middle; cursor: pointer; font-weight: bold;"  title="Anotador">Anotador:&nbsp;</label>
         <!-- Final - Anotador do Projeto escolhido -->
        </td>
        <td>
           <span id="codigousp" name="codigousp"  ></span> 
         </td>
       </tr>
      </table>
       <!-- Final - Anotador do Projeto escolhido -->
   

         <div class="class="div_cadanotador""  >
             <!--  Anotador/NOME -->      
               <div id="div_nome" align="justify" ></div>
             <!-- Final - Anotador/Nome -->
        </div>
      
      
      <div class="div_nova"  >
        <!--  Anotador/E_MAIL -->
          <span>
             <label for="e_mail" style="float: left; height: auto; " >E_mail:&nbsp;</label>
          </span>
          <!-- STYLE/CSS dentro do arquivo participante_cadastrar_js.php - atualizado em 20181203 -->
          <span>
              <input type="email" name="e_mail" id="e_mail" class="email"  maxlength="64" 
                  title="Digitar E_MAIL/Anotador"  onKeyUp="this.value=trim(this.value);" 
                  onkeydown="javascript: backspace(event,this)" 
                   required="required"  autocomplete="off" 
                    style="display: none;" />
            
          </span>            
          <!-- Final - Anotador/E_MAIL -->     
       </div>

      
  </div>
  <!-- Final - div - ate antes do Cancelar e  Remover -->   
  
     
     <div class="reset_button" >
           <!--  TAGS  type Cancelar e  Remover  -->                                              
             <span>
                <!-- Cancelar -->                  
                  <button type="submit" name="limpar" id="limpar"   class="botao3d"   
                   onclick="javascript: enviar_dados_anotador('reset','<?php echo $pagina_local;?>'); return false;"  title="Cancelar"  acesskey="C"  alt="Cancelar" >    
      Cancelar&nbsp;<img src="../imagens/limpar.gif" alt="Cancelar"  >
                      </button>
                  </span>    
                 <!-- Final - Cancelar  -->
                 <!-- Remover -->         
                   <span>        
                     <button  type="submit"  name="enviar" id="enviar"  class="botao3d" 
                      title="Remover" acesskey="R" alt="Remover" >    
      Remover&nbsp;<img src="../imagens/enviar.gif" alt="Remover"  >
                      </button>
                    </span>  
               <!-- Final - Remover -->
           <!--  FINAL - TAGS  type Cancelar e Remover  -->
      </div>
</form>
</div>
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
