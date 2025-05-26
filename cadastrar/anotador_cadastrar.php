<?php 
/*   REXP - CADASTRAR ANOTADOR   
*   
*   REQUISITO: O usuário deve ter PA>0 e PA<=30
* 
*   SPFB&LAFB110906.1704
*   SPFB&LAFB110907.0943   
*   SPFB&LAFB250523.0853   
*/
//  ==============================================================================================
//  ATENÇÃO: SENDO EDITADO POR LAFB
//  ==============================================================================================
//
//  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
//
//  Para exibir ERROS
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL);
//
//  IMPORTANTE:  Declarando em PHP - charset UTF-8
header('Content-type: text/html; charset=utf-8');
//
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
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
***/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");
//
/**
*  Conexao Mysqli
*/ 
$conex = $_SESSION["conex"];
//
//  Variavel recebida do script/arquivo - inicia_conexao.php 
$_SESSION["m_horiz"] = $array_projeto;
///
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
/// $_SESSION['time_exec']=180000;

////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
//
//
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
<title>REXP - Cadastrar Anotador</title>
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
//
//    Arquivo javascript em PHP
//  
require_once("{$_SESSION["incluir_arq"]}js/anotador_cadastrar_js.php");
//
require_once("{$_SESSION["incluir_arq"]}includes/domenu.php");
//
?>
</head>
<body id="id_body" oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" >
<!-- Cabecalho -->
<div id="cabecalho" >
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
//
require_once("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
//
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo" >
<?php 
//
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
<p class='titulo_usp' >Cadastrar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?><br/>
Atribuir Permiss&atilde;o para Usu&aacute;rio <br/>Realizar Anota&ccedil;&atilde;o de Projeto</p>
</section>
<!-- Final -  Mensagens e Titulo  -->
<div id="div_form"  class="div_form" >
<?php
//
/**   Definição das datas de controle para eventual registro (log)   */
//  
date_default_timezone_set('America/Sao_Paulo');
$timestampInSeconds = $_SERVER['REQUEST_TIME'];  
$_SESSION["datacad"]= date("Y-m-d H:i:s", $timestampInSeconds);  
//
/**   Verificando permissao para acesso Supervisor/Orientador    
 * 
 *   if( ( $_SESSION["permit_pa"]<=$_SESSION["array_usuarios"]["superusuario"] or  $_SESSION["permit_pa"]>=$pa_anotador ) ) {
*/
if( ( $_SESSION["permit_pa"]<=$array_pa["super"] or  $_SESSION["permit_pa"]>=$pa_anotador ) ) {    
     echo  "<p  class='titulo_usp' >Procedimento n&atilde;o autorizado.<br>"
               ."N&atilde;o consta como Orientador ou Superior.<br>Consultar seu Orientador ou Chefe</p>";      
    exit();
} 
//
$cols=4;
//
?>
<!--  DIV abaixo   -->
<div  id="arq_link" style="overflow: auto; height: auto;"  >
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: enviar_dados_cad('submeter','ANOTADOR',document.form1); return false"  >
  
<!-- div - ate antes do Limpar e Enviar -->
 <div class="parte_inicial" >
 
     <div class="div_nova"   >
          <!-- Identificação do Projeto [CIP][ - Titulo] -->
           <span>
           <label for="projeto"  title="Identificacao do Projeto" >Projeto:&nbsp;</label>
           </span>    
           <span>
        <!-- Identificação do Projeto [CIP][ - Titulo] -->
        <?php 
           //
           /**   IMPORTANTE: excelente para acentuacao da tag SELECT -  e tb  htmlentities   */
           //  
           //  Executando Select/MySQL
           //   Utilizado pelo Mysql/PHP - IMPORTANTE -20180615      
           /**
                *    O charset UTF-8  uma recomendacao, 
                *    pois cobre quase todos os caracteres e 
                *    símbolos do mundo
           */
           mysqli_set_charset($conex,'utf8');
           ///               
           /**   Select/MySQli - todos Projetos desse autor   */          
           $proc="SELECT b.cip,b.titulo FROM $bd_2.projeto b ";
           $proc.=" WHERE b.autor=$usuario_conectado  order by b.titulo ";
           $result = mysqli_query($_SESSION["conex"],"$proc"); 
           //                  
           if( ! $result ) {
               //
               $terr="ERRO: Selecionando os poss&iacute;veis projetos para esse Anotador -&nbsp;db/mysqli:&nbsp;";
               $terr.=mysqli_error($_SESSION["conex"]);
               die("$terr");  
           }
           //
           /**  Identificação da Fonte de Recurso  */ 
           $nprojetos = mysqli_num_rows($result);
           //
           ?>
           <!-- tag select para selecionar o Projeto -->
           <SELECT name="projeto"  id="projeto" class="td_select" title="Identificação do Projeto" 
               onchange="javascript: enviar_dados_cad(this.id,this.value)"  required="required" >
           <?php
            //
            /**  cASO NENHUM REGISTRO  */
           if( intval($nprojetos)<1 ) {
                $opcao_msg="N&atilde;o existe Projeto do atual Orientador/Superior.";
                ?>
                <option value='' >N&atilde;o existe Projeto do atual Orientador/Superior.</option>
                <?php
           } else {
               ?>
                <option value='' >Selecione o Projeto a ser acessado por esse Anotador</option>
              <?php
                  //
                while( $linha=mysqli_fetch_assoc($result) ) {
                      //  
                      //  echo "<option  value=".$linha['cip']."  >".$titulo."&nbsp;</option>";   
                      //  $titulo=$linha['titulo'];
                      // $titulo=html_entity_decode($linha['titulo'], ENT_QUOTES, "UTF-8");
                      $_SESSION["cip"]=$linha['cip'];
                      echo "<option  value=".$linha['cip']."  >".htmlentities($linha['titulo'],ENT_QUOTES,"UTF-8")."&nbsp;</option>";   
                     //      
                }
                /**  Final - while( $linha=mysqli_fetch_assoc($result) ) { */
               //
              ?>
            </select>
             <?php 
           }
           //
           /**  Desativar variavel  */
           if( isset($result) ) {
               unset($result);
           }
           /**  Final - if( isset($result) ) { */
           //
           ?>  
            <!--  Final - Identificação do Projeto [CIP][ - Titulo] -->
          </span>
        </div>
    
        <div class="div_nova"   >
          <!-- Anotador do Projeto escolhido -->
           <span>
               <label for="codigousp" title="Anotador">Anotador:&nbsp;</label>
           </span>    
           <span>
           <?php
               //
               //  Elementos para Bancos de Dados
               $elemento=5; $elemento2=6;
               require_once("php_include/ajax/includes/conectar.php");
               //
               /**   Incluir todos os anotadores e superiores (orientadores, etc)  //  ALTERANDO:LAFB110916.1515     */
               //
               //  Select/MYSQLI
               $sqlcmd = "SELECT 'Outro_PA' as tipo_pa, a.nome, a.codigousp,a.categoria, a.e_mail ";
               $sqlcmd .= " FROM $bd_1.pessoa a order by a.nome";
               //          
               $result = mysqli_query($_SESSION["conex"],$sqlcmd); 
               if( !$result ) {
                   //
                   $terr="ERRO: PRG/l&oacute;gica - select pessoa X usuario = Anotador. Informe SISTAM/REXP.&nbsp;db/mysqli:&nbsp;";
                   $terr.=mysqli_error($_SESSION["conex"]);
                   die("$terr");  
               }
               // Nr. de Registros 
               $m_linhas = mysqli_num_rows($result);
               //
               /** Caso Nr. de Registros maior que 0  */
               if( intval($m_linhas)>0  ) {
                    //
                  // Usando arquivo com while e htmlentities
                  //  include("../includes/tag_select_tabelas.php");
                  //
                  // Campo e_mail da Tabela
                  //  $e_mailname=mysql_field_name($result,3);  
                  $field_info = $result->fetch_field_direct(4);
                  $e_mailname=$field_info->name;
                  //
                  // Campo codigousp da Tabela 
                  // $codigo_sigla=mysql_field_name($result,2);
                  $field_info = $result->fetch_field_direct(2);
                  $codigo_sigla=$field_info->name;
                  //
                  // Campo nome da Tabela 
                  //  $cpo_nome_descr=mysql_field_name($result,1);
                  $field_info = $result->fetch_field_direct(1);
                  $cpo_nome_descr=$field_info->name;
                  //
                  // Campo pa da Tabela 
                  //  $cpo_tipo_pa = mysql_field_name($result,0);
                  $field_info = $result->fetch_field_direct(0);
                  $cpo_tipo_pa=$field_info->name;
                  //
               }  
               /**  Final -  if( intval($m_linhas)>0  ) { */
               //

  /**   
  echo "ERRO: 293)   \$m_linhas = $m_linhas -->> \$e_mailname = $e_mailname  <br> "
           ."  -->>  \$codigo_sigla = $codigo_sigla  -->>  \$cpo_nome_descr = $cpo_nome_descr <br>"
           ."  \$cpo_tipo_pa = $cpo_tipo_pa   ";
  exit();   
   */


               //
            ?>
            <!--  tag select para selecionar o Anotador para o Projeto selecionado -->
            <SELECT name="codigousp"  id="codigousp"  disabled="disabled"  
              required="required"  title="Selecione Anotador" 
             onchange="javascript: enviar_dados_cad('codigousp',this.value)"   >            
            <?php
               //
              if( intval($m_linhas)<1 || intval($nprojetos)<1) {
                  //
                  echo "<option value='' >Anotador N&atilde;o Dispon&iacute;vel.</option>";
              } else {
                ?>
                   <option value="" >Selecione Anotador</option>
                <?php
                   //
                  //  Usando arquivo com while e htmlentities
                  //  include("../includes/tag_select_tabelas.php");
                  //
                  if( isset($separador) ) unset($separador);
                  //
                  while( $linha=mysqli_fetch_array($result) ) {       
                         //
                         //  htmlentities - o melhor para transferir na Tag Select
                         $sigla= htmlentities($linha[$codigo_sigla]);  
                         //  $nome= htmlentities($linha[$cpo_nome_descr]);
                         $tipo_pa = htmlentities($linha[$cpo_tipo_pa]);
                         $e_mail = htmlentities($linha[$e_mailname]);
                         if( !isset($separador) ) {
                               $separador = $tipo_pa;
                         }
                         //
                         if( $separador!= $tipo_pa ) {
                               echo "<option  value='' >================================</option>" ;
                               $separador = $tipo_pa;
                         }  
                         //  
                        /**   IMPORTANTE:  na tag SELECT  htmlentities($linha[$cpo_nome_descr],ENT_QUOTES,"UTF-8")  */
                         echo "<option  value=".urlencode($linha['codigousp'])."  "
                               ."  title='Clicar'  >".htmlentities($linha[$cpo_nome_descr],ENT_QUOTES,"UTF-8")."</option>" ;
                        //
                  }  
                  /**  Final -  while( $linha=mysqli_fetch_array($result) ) {  */
                  ///
                  /*** Desativado a parte para inserir um Anotador que NAO esta cadastrado na tabela pessoal  ***/
                  echo "<option  value='-999999999'  title='Clicar' >* Outro (Digite o Nome/E-mail nos cpos. seguintes:)</option>" ;
                   ///
                ?>
                 </select>
                <?php
                   //
                   /** Desativar variavel  */
                   if( isset($result) ) {
                        //   mysql_free_result($result); 
                        unset($result); 
                   }  
                   //
              }
              //
              ?>   
            <!-- Final - Anotador do Projeto escolhido -->
           </span>
        </div>
 
         <div class="class="div_cadanotador""  >
             <!--  Anotador/NOME -->      
               <div id="div_nome" align="justify" ></div>
             <!-- Final - Anotador/Nome -->
        </div>

      <div class="div_nova" >
        <!--  Anotador/E_MAIL -->
          <span>
             <label for="e_mail" style="float: left; height: auto; padding-top: .2em;" >E_mail:&nbsp;</label>
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
 <!-- Final - div - ate antes do Limpar e Enviar -->
   
       <div class="reset_button" >
           <!--  TAGS  type reset e  submit  --> 
              <!-- Limpar campos  -->
                <span>
                   <button type="button"  name="limpar" id="limpar" class="botao3d"    
                       onclick="javascript: enviar_dados_cad('reset','<?php echo $pagina_local;?>'); return false;" 
                         title="Limpar"  acesskey="L"  alt="Limpar" >    
                     Limpar&nbsp;<img src="../imagens/limpar.gif" alt="Limpar" >
                   </button>
                </span>
                <!-- Final - Limpar campos -->
                <!-- Enviar/Cadastrar -->
                <span>
                   <button type="submit" name="enviar" id="enviar"   class="botao3d" 
                      title="Enviar"  acesskey="E"  alt="Enviar" >    
                   Enviar&nbsp;<img src="../imagens/enviar.gif" alt="Enviar"  >
                   </button>
                </span>
              <!-- Final - Enviar/Cadastrar -->
           <!--  FINAL - TAGS  type reset e  submit  -->
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
