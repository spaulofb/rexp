<?php 
/**   
*      REXP - CADASTRAR PESSOAL   
*   LAFB&SPFB110906.1146 - Incluindo campo PA 
* 
*/
//  
//  ==============================================================================================
//  Caso sseion_start desativada - ativar  
if(!isset($_SESSION)) {
   session_start();
}
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");
//
// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
//   FINAL - Mensagens para enviar
//
//
extract($_POST, EXTR_OVERWRITE); 
//
//  Verificando SESSION incluir_arq - 20180618
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
/**
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
*/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");

///  Variavel recebida do script/arquivo - inicia_conexao.php 
$_SESSION["m_horiz"] = $array_projeto;
///
/// $_SESSION['time_exec']=180000; 
///   Caminho da pagina local
$_SESSION["pagina_local"] = $pagina_local=$_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";

///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]= utf8_decode("Registro de Anotação") ;
///
///  Alterado em  20180604 - Funcionu no Windows e no Linux - Acentuacao   
////  INCLUINDO CLASS 
//  require_once("{$incluir_arq}includes/autoload_class.php");  
//  if( class_exists('funcoes') ) {
//    $funcoes=new funcoes();
//  }
///
/***    INCLUINDO CLASS - 
* 
*    Alterado em 20250108
*       Deprecated: __autoload() is deprecated, 
*             use spl_autoload_register() 
****/
///    IMPORTANTE: variavel de erro
$php_errormsg="";
///     Class para funcoes de mensagens 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");
if( strlen(trim($php_errormsg))>0  )  {
    echo "ERRO: OCORREU UM ERRO ".$php_errormsg;
    exit();
}
$autoload = new Autoload();
$funcoes=new funcoes();
//
//   SESSION conjunto com os valores dos campos: instituicao,unidade,setor e etc....
$_SESSION["conjunto"]="";
//
/**
*  Caminho url principal
*/
$url_central = $_SESSION["url_central"];
$limpar="{$url_central}imagens/limpar.gif";
$enviar="{$url_central}imagens/enviar.gif";
//
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
//
/**  Segundo Banco de Dados/DB  */
$bd_2 = "patrimonio";
//
//  Atualizado em 20250113
//    Tabela setor
$tbsetor="setor";
//
//   Select/MYSQLI
// Consulta SQL para listar as colunas
$sql = "SHOW COLUMNS FROM $bd_2.$tbsetor ";
$respri = $conex->query($sql);
if( mysqli_error($_SESSION["conex"]) ) { 
    $terr="Falha no SHOW COLUMNS da Tabela $tbsetor -&nbsp;db/Mysqli:&nbsp;";
    echo $funcoes->mostra_msg_erro("$terr".mysqli_error($_SESSION["conex"]));    
    exit();
}
//
//  Nr. Registros
$nregs = mysqli_num_rows($respri);
//
// Exibindo os resultados
unset($arrcpos);
$arrcpos = array();
if( intval($nregs)>0 ) {
    //
    if( isset($_SESSION["nmcpoid"]) ) {
         unset($_SESSION["nmcpoid"]); 
    }  
    //
    while( $row = $respri->fetch_assoc()) {
           //
           // echo $row["Field"] . "<br>";
           $nomecpo=$row["Field"];
           //
           if( preg_match("/codigo|codsetor|idsetor|sigla|sigsetor/ui",$nomecpo)  )  {
               //
               // Nome da coluna  codigo SETOR  da Tabela  
               $_SESSION["codidseto"] = $nomecpo;
               $arrcpos[4]= $nomecpo;
               //
          }
          //
          if( preg_match("/instituicao|idinst|^codinst/ui",$nomecpo)  )  {
              //
              // Nome da coluna  INSTITUICAO  da Tabela  
              $_SESSION["codidinst"] = $nomecpo;
              $arrcpos[1]= $nomecpo;
          }
          //
          if( preg_match("/unidade|^codunid|idunid/ui",$nomecpo)  )  {
               //
               // Nome da coluna UNIDADE  da Tabela  
               $_SESSION["codidunid"] = $nomecpo ;
               $arrcpos[2]= $nomecpo;
          }
                    ///
          if( preg_match("/departamento|^depto|^coddept|iddept/ui",$nomecpo)  )  {
              /// Nome da coluna DEPTO/DEPARTAMENTO da Tabela  
              $_SESSION["codiddept"] = $nomecpo ;
              $arrcpos[3]= $nomecpo;
          }
          ///
    }
    /**  Final - while( $row = $respri->fetch_assoc()) {  */
    //
}
/**  Final - if( intval($nregs)>0 ) {   */
//
if( isset($arrcpos) ) {
     $_SESSION["arrcpos"] = $arrcpos;    
} 
//
//
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
<meta charset="utf-8" />
<meta name="author" content="Sebastiao Paulo" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" CONTENT="NO-CACHE">
<meta name="ROBOTS" CONTENT="NONE"> 
<meta http-equiv="Expires" CONTENT="-1" >
<meta name="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Cadastrar Pessoa</title>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script  type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js" charset="utf-8"  ></script>
<script type='text/javascript'  src='<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1'></script>
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/resize.js" ></script>
<?php
//
///  Arquivo javascript em PHP
include("{$_SESSION["incluir_arq"]}js/pessoal_cadastrar_js.php");
///
$_SESSION["n_upload"]="ativando";
/****
*    Alterado em 20171004
***/
require("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"   >
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
<div id="corpo" >
<?php 
///   CADASTRAR PESSOAL
/*
if( strlen(trim($_GET["m_titulo"]))>1 )  $_SESSION["m_titulo"]=$_GET["m_titulo"];  
if( strlen(trim($_POST["m_titulo"]))>1 )  $_SESSION["m_titulo"]=$_POST["m_titulo"];  
*/
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//   
$_SESSION["cols"]=4;	
$lc_cols=$_SESSION["cols"];
//  Tabela PESSOA mas passa como PESSOAL
$_SESSION["onsubmit_tabela"]="PESSOAL";	  
?>
<!--  Mensagem de ERRO  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<!-- Final -  Mensagens e Titulo  -->
<p class='titulo_usp' >Cadastrar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Mensagem de ERRO     -->
<div id="div_form" class="div_form"  style="overflow:scroll;" >
<?php
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
//  Formatando a Data no formato para o Mysql
$dia = date("d");
$mes = date("m");
$ano = date("Y"); 
$ano_validade=$ano+2;
$_SESSION['datacad']="$ano-$mes-$dia";
$_SESSION['datavalido']="$ano_validade-12-31";
$_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|salatipo|sala";		 
$vars_ambiente=$_SESSION["VARS_AMBIENTE"];
//
//  PA:  superusuario,  chefe,  subchefe, orientador, anotador  -  includes/array_menu.php
//  if( $_SESSION[permit_pa]>=$_SESSION[array_usuarios][superusuario]  and  $_SESSION[permit_pa]<=$_SESSION["array_usuarios"]["orientador"]  ) {
//  if( $_SESSION["permit_pa"]<=$_SESSION["array_usuarios"]["orientador"]  ) {
if( $_SESSION["permit_pa"]<=$array_pa["orientador"]  ) {        
  ?>
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post" 
 onsubmit="javascript: enviar_dados_cad('submeter','<?php echo $_SESSION["onsubmit_tabela"];?>',document.form1);return false;"   >
 <!-- div - ate antes do Cancelar e  Remover -->
 <div class="parte_inicial"  >
     <div class="div_nova" >
           <!-- CODIGO/USP - digitar -->
           <span>
              <label for="codigousp"  >C&oacute;digo/USP:&nbsp;</label><br/>
              <input type="number" name="codigousp" id="codigousp"  pattern="[0-9]{1,14}" 
                 class="codigousp"  maxlength="14"  onblur="javascript: this.value=trim(this.value);" 
                 title="Código/USP"   autocomplete="off"  autofocus="autofocus"  />
           </span>
           <span class="example" >
               *Obs. C&oacute;digo sem d&iacute;gito. Caso n&atilde;o tenha, deixar vazio
           </span>   
           <!-- Final - CODIGO/USP -->      
        </div>

       <div class="div_nova"  >
           <!--  Nome da Pessoa -->
           <span>
              <label for="nome"  >Nome:&nbsp;</label><br />
              <input type="text" name="nome" id="nome" value="" class="nome"        
                 maxlength="64"   title="Digitar Nome"  required="required"
                 onkeypress="javascript: trimnovo(this);"   autocomplete="off"   />
           </span>
           <!-- Final - Nome -->
        </div>
        

       <div class="div_nova"  >
          <!-- SEXO -->
           <span>
            <label for="sexo" >Sexo:</label>
                <select name="sexo" id="sexo"  title="Selecionar Sexo" required="required" >
                      <option value="" >Selecione... </option>
                      <option value="F" >Feminino</option>
                      <option value="M" >Masculino</option>
                </select>   
           </span>
           <!-- Final - Sexo -->
        </div>


       <div class="div_nova"  >
          <?php
              //
              //  CATEGORIA => Cargo/Fun??o
              $elemento=5;
              //
              //  include("php_include/ajax/includes/conectar.php");  
              require_once("php_include/ajax/includes/conectar.php");  
              //
              /**  Conexao MYSQLI  */
              $conex = $_SESSION["conex"]; 
              //           
              mysqli_query($conex,"SET NAMES 'utf8'");
              mysqli_query($conex,'SET character_set_connection=utf8');
              mysqli_query($conex,'SET character_set_client=utf8');
              mysqli_query($conex,'SET character_set_results=utf8');
              //
              //  SELECT/MYSQLI                       
              $result=$conex->query("SELECT codigo,descricao FROM  $bd_1.categoria order by codigo ");
              //
              if( mysqli_error($_SESSION["conex"]) ) {         
                  $terr="Falha no Select tabela categoria&nbsp;- db/Mysqli:&nbsp;";    
                  echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex)); 
                  exit();
              }
              //  Nr. Registros
              $m_linhas = mysqli_num_rows($result);
              //
              $_SESSION["msgr"]="";
              //

  /******
                   include("{$_SESSION["incluir_arq"]}includes/tag_select_tabelas.php");
                     echo "ERRO: LINHA/271 -->> {$_SESSION["incluir_arq"]}  $m_linhas \$_SESSION[msgr] = {$_SESSION["msgr"]} ";
           exit();
         ************/

              
          ?>
          <span class="td_informacao2"  >
              <label for="categoria"  >Categoria:</label>
              <select name="categoria" class="td_select" id="categoria"  title="Selecionar Categoria" required="required"  >
                  <?php
                      //
                      //  Categoria
                      if( intval($m_linhas)<1 ) {
                          echo "<option value='' >Nenhuma Categoria definida.</option>";
                      } else {
                      ?>
                      <option value='' >Selecione...</option>
                      <?php
                           //
                           // Usando arquivo com while e htmlentities
                           $_SESSION["siglaounome"]="CATEGORIA";
                           //
                           include("{$_SESSION["incluir_arq"]}includes/tag_select_tabelas.php");
                           //
                           $_SESSION["siglaounome"]="";
                           //
                      ?>
                  </select>
              </span>
              <?php
              }
              // FINAL - Categoria
              //
              /** Desativar variavel */
              if( isset($result) ) {
                  mysqli_free_result($result);   
              } 
              //
          ?>  
       </div>

       <div class="div_nova"  >
          <table style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
           <tr style="margin: 0;padding:0;">
           <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" >
             <?php
                 //
                 //  INSTITUICAO
                 $elemento=3;
                 //
                 //  include("php_include/ajax/includes/conectar.php");  
                 include("php_include/ajax/includes/conectar.php");  
                 //
                 //  Select/MYSQLI
                 /**
                 *  $result=$conex->query("SELECT sigla,nome FROM $bd_1.instituicao order by nome ");
                 */              
                 ini_set('default_charset', 'UTF-8');
                 
                 // Set the character set to UTF-8
                 $conex->set_charset("utf8");
                 //
                 $result=$conex->query("SELECT  codinstituicao,nome FROM $bd_1.instituicao order by nome ");                 
                 //
                 if( mysqli_error($_SESSION["conex"]) ) {         
                      $terr="Falha no Select tabela instituicao&nbsp;- db/Mysqli:&nbsp;";    
                      echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex)); 
                      exit();
                 }
                 //
                 /**
                 *   if( ! $result ) {
                 *        die('ERRO: Select - falha: '.mysql_error());
                 *        exit();
                 *    }
                 * 
                 */
                 //  Nr. Registros
                 $nrgs = mysqli_num_rows($result);
                 //
                 //  Nome do primeiro campo da Tabela 
                 $nmcpopri  = mysqli_field_name($result,0);                 
                 $_SESSION["nmcpopri"]=$nmcpopri;
                 //

/**                 
                 echo "ERRO: LINHA/351  -->> \$vars_ambiente = $vars_ambiente ->> \$nmcpopri = $nmcpopri ";
                 exit();
   */
                 
                 
             ?>
            <label for="instituicao" >Institui&ccedil;&atilde;o:</label><br />
              <select name="instituicao" id="instituicao" class="td_select"   
          onchange="enviar_dados_cad('CONJUNTO',this.value,this.name+'|'+'<?php echo $vars_ambiente;?>'+'|'+'<?php echo $nmcpopri;?>');"  style="padding: 1px;" title="Institui&ccedil;&atilde;o" required="required"  >            
               <?php
                  //
                  //  INSTITUICAO
                 //
                 if( intval($nrgs)<1 ) {
                      echo "<option value='' >Nenhuma Institui&ccedil;&atilde;o encontrada.</option>";
                 } else {
                   ?>
                    <option value='' >Selecione...</option>
                    <?php
                        //
                        //  Usando arquivo com while e htmlentities
                        include("{$_SESSION["incluir_arq"]}includes/tag_select_tabelas.php");
                        //
                    ?>
                     <option value='Outra' >Outra</option>
                  </select>
                    <?php
                       //
                  }
                   // Final da Instituicao
                   //
                   //  Desativando variavel 
                   if( isset($result) ) {
                       mysqli_free_result($result);   
                   } 
                   /**  Final - if( isset($result) ) {  */
                   //
                  ?>
              </td>                  
               <?php
                  //
                  /**
                  *    Criando um Array
                  */
                  $td_campos_array = explode("|",$_SESSION["VARS_AMBIENTE"]);
                  /** 
                    *   Evite de usar for($i=0; $i < count($_linhas); $i++. Use: 
                    *    $total = count($_linhas); 
                    *      for($i=0; $i < $total; $i++) 
                    *      Pois o for sempre vai executar a funcao count 
                    *       pesando na velocidade do seu programa. 
                  */ 
                  /**  Nao comeca no Zero porque ja tem o primeiro campo acima - UNIDADE  */
                  $tarray = count($td_campos_array);
                  for( $x=1; $x<$tarray; $x++ ) {
                          //
                          $id_td = "td_".$td_campos_array[$x];
                          echo  "<td  nowrap='nowrap'  class='td_inicio1' style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;display:none; ' "
                                ."   name=\"$id_td\"    id=\"$id_td\"  >";
                          echo '</td>';
                   }
                   /**  Final - for( $x=1; $x<$tarray; $x++ ) {  */
                   //
                 ?> 
                <td  class="td_inicio1" style="border: none; vertical-align: middle; text-align: left;"  colspan="<?php echo $lc_cols;?>" >
               <!-- font indicando bens encontrados -->
               <div id="tab_de_bens"  style="display: none; margin: 0;padding: 0;" ></div>              
              <!-- Final - font indicando bens encontrados -->           
            </td>
          </tr>    
        </table>             
       </div>       

       <div class="div_nova"  >
          <!-- EMAIL -->
          <span><label for="e_mail" >E_mail:&nbsp;</label></span>
           <br/>
           <input type="email" name="e_mail" id="e_mail"  required="required"  class="email"  
             maxlength="64" title='Digitar E_MAIL'  onkeyup="this.value=trim(this.value)" 
              onblur="javascript: checkEmail(this.id,this.value);" autocomplete="off" />
              <br/>
           <!-- Final - EMAIL -->
         
         <!-- TABLE - Telefone/Ramal e Chefe -->
         <table style="margin-top: .4em;"  >
           <tr>
             <td style="padding-right: .6em;" >
             <!-- Telefone - digitar -->
             <span>
      <label for="Telefone"  >Telefone (dd)-fone:&nbsp;</label>
      </span>
             </td>
             <td>
               <!-- RAMAL - digitar -->
               <span>
             <label for="ramal" style="vertical-align:bottom; padding-bottom: 1px;cursor: pointer;"  title="Ramal" >Ramal:&nbsp;</label>
             </span>
             </td>
           </tr>
           <tr>
             <td style="padding-right: 1.8em;" >
      <input type="text" name="fone"  id="fone"  class="telefone" 
           onKeyDown="Mascara(this,Telefone);" 
           onKeyPress="Mascara(this,Telefone);" onKeyUp="Mascara(this,Telefone);" 
           placeholder="(xx) xxxx-xxxx"  pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}"  
           style="padding:1px;"  onblur="javascript: exoc('label_msg_erro',0,'');" 
           title="Digitar telefone somente n&uacute;mero incluindo dd" >
            <!-- Final - Telefone -->                       
             </td>
             <td>
          <input type="number" name="ramal" id="ramal"  min="1"  class="ramal" 
             maxlength="10" onKeyUp="this.value=trim(this.value);" 
            onblur="javascript: alinhar_texto(this.id,this.value)" 
              autocomplete="off"    />
               <!-- Final - Ramal -->                           
             </td>
           </tr>
           
           
           <tr>
           <td colspan="2" style="padding: .6em 0 .6em;" >
            <?php 
               //
               //  <!--  Chefe/Orientador   --> 
               $elemento=5; $elemento2=6;
               //
               include("php_include/ajax/includes/conectar.php");    
               //                                
               /** Select/MYSQLI   */
               mysqli_query($conex,"SET NAMES 'utf8'");
               mysqli_query($conex,'SET character_set_connection=utf8');
               mysqli_query($conex,'SET character_set_client=utf8');
               mysqli_query($conex,'SET character_set_results=utf8');
               //
               $sqlcmd="SELECT distinct chefecodusp,nome FROM  $bd_1.chefe  order by nome "; 
               $result = mysqli_query($_SESSION["conex"],$sqlcmd);
               // Verifica se houve erro
                if( ! $result ) {
                    //
                    // die('ERRO: Select tabela chefe - falha: '.mysql_error());  
                    $terr="Falha no Select tabela chefe&nbsp;- db/Mysqli:&nbsp;";    
                    echo $funcoes->mostra_msg_erro("$terr".mysqli_error($conex)); 
                    exit();
                } else {
                      /**   Chefe/Orientador da pessoa para cadastrar   */
                  ?>
                  <span>
                  <label for="chefe"  >Chefe:&nbsp;</label>
                  </span>
                  <span>
                  <select name="chefe"  id="chefe" class="td_select" 
                    title="Selecionar Chefe/Orientador" 
                    onchange="javascript: enviar_dados_cad(this.name,this.value);"  >
                         <?php
                            //
                            //  Chefe/Orientador 
                            $m_linhas = mysqli_num_rows($result);
                             if( intval($m_linhas)<1 ) {
                                  echo "<option value='' >Lista vazia. Contactar Administrador.</option>";
                             } else {
                                ?>
                                   <option value='' >Selecione...</option>   
                               <?php
                               /// Usando arquivo com while e htmlentities
                                $_SESSION["siglaounome"]="CATEGORIA";
                                //
                                include("{$_SESSION["incluir_arq"]}includes/tag_select_tabelas.php");
                                //
                                $_SESSION["siglaounome"]="";
                                //
                                echo  "<option value='outro_chefe' >Outro</option>";
                                //
                             }
                             //
                           ?>
                              </select>
                           <!-- Final do Chefe/Orientador -->
                           <?php
                }
                //   
                /** Desativar variavel */
                if( isset($result) ) {
                     mysqli_free_result($result);   
                } 
                //
                // FINAL - Chefe/Orientador
             ?>
             </span> 
                     
             <!-- Caso optou por Outro - Cadastrar novo Chefe/Orientador na Tabela pessoal.pessoa -->
                <div id="outro_chefe" style="display: none; margin: 0;">
                   <!--  Novo Chefe/Orientador -->
                     <br/>
                      <label for="novo_chefe" >Novo Chefe:&nbsp;</label><br />
                        <input type="text" name="novo_chefe"   id="novo_chefe"  size="75" class="nome"
                         maxlength="64"  title='Digitar novo chefe'  onkeypress="javascript: trimnovo(this);" 
                          onkeyup="enviar_dados_cad('novo_chefe',this.value);"  disabled="disabled"  autocomplete="off" />
                       <!-- APRESENTANDO O RESULTADO DA BUSCA DINAMICA.. OU SEJA OS NOMES -->
                       <div id="pagina"></div>
                   <!-- Final - novo Chefe/Orientador -->
                </div>
             </td>
           </tr>
         </table>
         <!-- Final - TABLE - Telefone/Ramal e Chefe -->
       </div>

    </div>
      <!-- Final - div - ate antes do Cancelar e  Remover -->

      <!--  TAGS  type reset e  submit  -->                                              
         <div class="reset_button" >
           <!-- Limpar campos -->                  
             <span>
                 <button  type="button"  name="limpar" id="limpar"  class="botao3d"    
                      onclick="javascript: enviar_dados_cad('reset','<?php echo $pagina_local;?>'); return false;"  
                      title="Limpar"  acesskey="L"  alt="Limpar" >    
                  Limpar&nbsp;<img src="<?php echo $limpar;?>" alt="Limpar" >
                 </button>
             </span>   
           <!-- Final - Limpar  -->
           <!-- Enviar -->                  
           <span>
              <button  type="submit"  name="enviar" id="enviar"  class="botao3d" 
                  title="Enviar"  acesskey="E" alt="Enviar"  >
                Enviar&nbsp;<img src="<?php echo $enviar;?>" alt="Enviar" >
              </button>
           </span>
           <!-- Final -Enviar -->
        </div>
       <!--  FINAL - TAGS  type reset e  submit  -->
</form>



<?php
} else {
    echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
//
?>
</div>
<!-- Final  div_form -->
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php require_once("{$_SESSION["incluir_arq"]}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
