<?php
/***
*    EDITAR - Tabela projeto
***/
///  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
}
///
///   Verificando conexao
///
////  include_once("{$_SESSION["incluir_arq"]}iniciar_conexao.php");
require_once("{$_SESSION["incluir_arq"]}iniciar_conexao.php");
///
///  Recebe GET e passa SESSION  - m_nome_id
if( isset($_GET["m_nome_id"]) ) {
    $_SESSION["m_nome_id"]=$_GET["m_nome_id"];
} else {
    $_GET["m_nome_id"]="";
    $_SESSION["m_nome_id"]="";
}
///
///      ATUALIZADO EM  20210714
///  Caminho da pagina local - substr retirar primeiro caracter / (barra)
////  path e arquivo local   -  $_SERVER['REQUEST_URI']
$dirarq=$_SERVER['SCRIPT_FILENAME'];
///
/**        Atualizado em 20201215
      IMPORTANTE: Arquivo local -basename(__FILE__)
***/
$arqlocal =  basename(__FILE__);
///
$dirprincipal = str_replace($arqlocal,'',$dirarq);
///
/// Definindo: consultar/consultar_ips.php
$arqlocal = str_replace($_SESSION["incluir_arq"],'',$dirarq);
///
///   Caminho e arquivo local 
$protocolo = $_SESSION["protocolo"];
///  $_SESSION["m_juntos_link"] = $_SESSION["url_central"]."{$arqlocal}"; 
$m_juntos_link = "{$protocolo}://{$_SERVER["HTTP_HOST"]}{$_SERVER["SCRIPT_NAME"]}";
$_SESSION["m_juntos_link"] = $m_juntos_link;
///
$_SESSION["div_form"]="block";
///
///   include_once("{$_SESSION["incluir_arq"]}script/var_encontrar.php");
require_once("{$_SESSION["incluir_arq"]}script/var_tabpri.php");
///
/// Select/MySQLI - SESSION da conexao
$conex =  $_SESSION["conex"];
///
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
///
///   Acentuacao UTF8
mysqli_set_charset($conex,'utf8');
 ///
 ///   Atualizado 20210616
///  Tabela projeto
if( isset($tabpri) ) {
    ///
    ///  Select/MYSQLI
    ////      $txt="SELECT * FROM {$bd_1}.$tabpri $where $order_by ";
    $cpos_tb="*"; $where=""; $order_by="";
    $txt="SELECT $cpos_tb FROM {$bd_1}.$tabpri $where $order_by  ";
    $respri=mysqli_query($_SESSION["conex"],"$txt");
    ///
    ///   if( ! $respri ) {
    if( mysqli_error($_SESSION["conex"]) ) { 
        $txterr="Falha no select da Tabela $tabpri -&nbsp;db/Mysqli:&nbsp;";
        echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($_SESSION["conex"]));    
        exit();
    }
    ///
   ///  Nr. de  Registros
    $nregs = mysqli_num_rows($respri);
     /// 
     ///    numero de campos - nome e tamnho 
     ///   $n_fields = mysqli_num_fields($respri);
    /// Desativando variaveis -  array name_c_id e len_c 
     if( isset($name_c_id) )  unset($name_c_id);
     if( isset($len_c) )  unset($len_c);
     if( isset($_SESSION["name_c_id"]) ) unset($_SESSION["name_c_id"]);
     if( isset($_SESSION["len_c"]) ) unset($_SESSION["len_c"]);     
     ///
     /// Atualizado em 20210607
     while( $fieldinfo = mysqli_fetch_field($respri) ) {
           ///  
           $nomecpo=$fieldinfo->name;
           $name_c_id[] = $nomecpo;
           /// Tamanho do Campo length dividido por 3
           $ntam = ($fieldinfo->length);
           ////  $len_c["$nomecpo"] = number_format($ntam,2);
           /***
           *     Atualizado em 20210607
           *    Verificando o tipo do campo da Tabela
           *       Definir tamanho do campo
           ****/
           
           switch ($fieldinfo->type) {
             case 3:
             case 4:
                /// Campos numericos
                $len_c["$nomecpo"] = number_format($ntam,0);
                 break;
             default:
                /// Campos caracteres
                $len_c["$nomecpo"] = number_format($ntam/3,0);
                 break;
          }
          ///
          ///  $len_c[] = number_format($ntam,2) ;
          ///
     }
     ///
     ///  Copia do Array em SESSION
     $_SESSION["name_c_id"]=$name_c_id;
     $_SESSION["len_c"]=$len_c;
     ///
     /// Nr. de campos da Tabela pessoal
     if( sizeof($name_c_id)<2 ) {
        $txterr="Falha na Tabela $tabpri menos que 2 campos.";
         echo $funcoes->mostra_msg_erro("$txterr");    
         exit();
     }
     ///
     /// Nome da coluna processo da Tabela projeto 
     ///$_SESSION["colproce"] = $name_c_id[1];
     ///
     /// Nome da coluna financiadora da Tabela projeto
     ///  $_SESSION["colfinan"] = $name_c_id[2];
     ///
     $nsize=count($name_c_id);
     for( $ni=0;$ni<$nsize; $ni++ ) {
         ///
         ///  Campo/Coluna da Tabela projeto
          $word = $name_c_id[$ni]; 
          ///
          /// Nome da coluna processo da Tabela projeto 
          if( preg_match("/processo/ui",$word)  )  {
              /// 
              $_SESSION["colproce"] = $word;
          }
          ///
          /// Nome da coluna financiadora da Tabela projeto
          if( preg_match("/finan/ui",$word)  )  {
              /// 
              $_SESSION["colfinan"] = $word;
          }
          ///
          /// Nome da coluna coordenador da Tabela projeto
          if( preg_match("/coordenad|orientad|responsavel/ui",$word)  )  {
              /// 
              $_SESSION["colcoord"] = $word;
          }
          ///
          /// Nome da coluna data inicio da Tabela projeto
          if( preg_match("/vigenciai|dtini|dataini|inidt|inidata/ui",$word)  )  {
              ///  Vigencia inicial do projeto
              $_SESSION["colvigei"] = $word;
          }
          ///
          /// Nome da coluna data final da Tabela projeto
          if( preg_match("/vigenciaf|dtfim|datafim|fimdt|fimdata/ui",$word)  )  {
              ///  Vigencia final do projeto
              $_SESSION["colvigef"] = $word;
          }
          ///
     }
     ///  Final - for( $ni=0;$ni<$nsize; $ni++ ) {  
    ///
} elseif( ! isset($tabpri) ) {
    echo $funcoes->mostra_msg_erro("Falha na variavel da Tabela");    
    exit();                  
} 
///  FINAL - isset($tabpri)
///
?>
<!DOCTYPE html >
<html lang="pt-br" >
<head>
<meta charset="UTF-8" />
<meta name="author" content="LAFB&SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA"  content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <meta http-equiv="Expires" content="-1">  -->
<meta http-equiv="imagetoolbar" content="no">  
<link rel="shortcut icon" href="<?php echo $url_central;?>imagens/GEMAC.ICO" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no, maximum-scale=1, minimum-scale=1"  >
<title>Controle de Bem Patrimonial</title>
<link rel="preload"   type="text/css" href="<?php echo $url_central;?>css/<?php echo $estilocss;?>"  as="style" onload="this.onload=null;this.rel='stylesheet'" >
<link rel="preload"   type="text/css" href="<?php echo $url_central;?>css/style_titulo_patrimonio.css"  as="style" onload="this.onload=null;this.rel='stylesheet'" >
<?php
//// Buscar  arquivo  js   como  php
require_once("{$_SESSION["incluir_arq"]}js/jquery-1.2.6.php");
require_once("{$_SESSION["incluir_arq"]}js/funcoes_js.php");
require_once("{$_SESSION["incluir_arq"]}js/editar_projeto_js.php");
///  IMPORTANTE para incluir js qdo tiver variavel de PHP
require_once("{$_SESSION["incluir_arq"]}js/conecta_ajax.php");
require_once("{$_SESSION["incluir_arq"]}js/menu_patrimonial.php");
///
?>
<script type="text/javascript" >
/* <![CDATA[ */
function criarJanela(id) {
     var ele = document.getElementById(id); 
     var m_top = 100; 
     var left = -20; 
     m_top += ele.offsetTop; 
     left += ele.offsetLeft; 
     //
     janelaCriada = window.open("","_blank","toolbar=no, location=no, directories=no, status=no, scrollbars=no, resizable=no, width=300, height=10, top="+m_top+", left="+left);
     janelaCriada.document.write("<p align='center' ><b>Usar * para mostrar todos registros.</b></p>");   
     janelaCriada.setTimeout("self.close();",3000);    
}
/* ]]> */
</script>
</head>
<body  oncontextmenu="return false" onselectstart="return false" onload="javascript: dochange('<?php echo $_GET["m_nome_id"];?>','iniciando')"  ondragstart="return false"  
 onkeydown="javascript: no_backspace(event);"   >
<?php
///      Abertura da pagina
require_once("{$_SESSION["incluir_arq"]}script/abertura_da_pagina.php"); 
///
/***
     Chamada da funcao das tabelas - array multidimensional
***/
///  require("{$_SESSION["incluir_arq"]}script/array_multi.php");
require_once("{$_SESSION["incluir_arq"]}script/array_multi.php");
///
///  Require para o Navegador que nao tenha ativo o Javascript
///   Posicao do arquivo noscript.php tem que ser depois da tag  BODY
///  require("{$_SESSION["incluir_arq"]}js/noscript.php");
require_once("{$_SESSION["incluir_arq"]}js/noscript.php");
///  Menu Horizontal
require_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
/// unset($_SESSION["m_horiz"]);
$_SESSION["m_horiz"] = $array_patrimonial;
///
?>
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho  -->
<div id="cabecalho" style="z-index:2; border: none;" >
<?php require_once("{$_SESSION["incluir_arq"]}script/cabecalho_patrimonio.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
$_SESSION["function"]="dopatrim";
require_once("{$_SESSION["incluir_arq"]}includes/menu_horizontal_patrimonio.php");
///
///  Destaivando variaveis de excluir e consultar 
/***
$_SESSION["m_excluir"]=false;
$m_excluir = $_SESSION["m_excluir"];
***/
if( isset($_SESSION["m_excluir"]) ) unset($_SESSION["m_excluir"]);
/***
$_SESSION["m_consultar"]=false;
$m_consultar = $_SESSION["m_consultar"];
***/
if( isset($_SESSION["m_consultar"]) ) unset($_SESSION["m_consultar"]);
////
$_SESSION["m_editando"]=true;
$m_editando = $_SESSION["m_editando"];
////
///  Titulo da Tabela
if( isset($_SESSION["tit_pag"])  ) {
    $tit_pag = $_SESSION["tit_pag"];
} else {
   echo $funcoes->mostra_msg_erro("Falha no SESSION tit_pag - Corrigir");    
   exit();
}
///
?>
<!-- CORPO -->
<div id="corpo" >
<!--  Mensagens e Titulo  -->
<div  id="label_msg_erro" >
</div>
<!-- Final -  Mensagens e Titulo  -->
<p class="tr_cabecalho" style="overflow:hidden;" >
<b>Editar/<?php echo $tit_pag;?></b>
</p>
<hr style="border-bottom: 1px solid #000000; margin: 0px; padding: 0px;" />
<!--  DIV abaixo os Dados Antes de pedir o Arquivo para Upload   -->
<div id="div_form" style="overflow: hidden; display:<?php echo $_SESSION["div_form"];?>;" >
</div>
<!-- Final da div id=div_form  -->
<!-- div id=campos_selecionado  -->
<div id="campos_selecionado" style="width:100%; display: none;" >
</div>
<!-- Final div id=campos_selecionado  -->
<!-- div id=mostrar_tabela  -->
<div id="mostrar_tabela" style="width:100%; display: none;" >
</div>
<!-- Final div id=mostrar_tabela  -->
<!-- Rodape -->
<div id="rodape"   >
<?php require_once("{$_SESSION["incluir_arq"]}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>      
<!-- Final Corpo -->
</div>
<!-- Final da PAGINA - class=pagina_ini   -->
</body>
</html>