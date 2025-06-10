<?php
/****
*       Consultar - patrimonio/bem
****/
///  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
}
///
///   Verificando conexao - atualizado em 20240123
///
///  include_once("{$_SESSION["incluir_arq"]}iniciar_conexao.php");
require_once("{$_SESSION["incluir_arq"]}iniciar_conexao.php");
///
////  path e arquivo local   -  $_SERVER['REQUEST_URI']
$dirarq=$_SERVER['SCRIPT_FILENAME'];
///
/**        Atualizado em 20201215
      IMPORTANTE: Arquivo local -basename(__FILE__)
***/
$arqlocal = basename(__FILE__);
///
$dirprincipal = str_replace($arqlocal,'',$dirarq);
///
/****
*  A função dirname() retorna o caminho do diretório pai
*  Exemplo: /diretorio/arquivo  retorna  /diretorio  
*****/
$dirpri = dirname(__FILE__);
///
/// Definindo: consultar/consultar_ips.php
$arqlocal = str_replace($_SESSION["incluir_arq"],'',$dirarq);
///
///   Caminho e arquivo local
///  $_SESSION["m_juntos_link"] = $_SESSION["url_central"]."{$arqlocal}"; 
$_SESSION["m_juntos_link"] = "{$_SESSION["protocolo"]}://{$_SERVER["HTTP_HOST"]}{$_SERVER["SCRIPT_NAME"]}";
///
/***
echo " \$_SESSION[m_juntos_link] = {$_SESSION["m_juntos_link"]}  <br/> \$_SERVER[REQUEST_URI] = {$_SERVER['REQUEST_URI']}";
exit();
***/
///
$_SESSION["div_form"]="block";
///
///   include_once("{$_SESSION["incluir_arq"]}script/var_encontrar.php");
include_once("{$_SESSION["incluir_arq"]}script/var_tabpri.php");
///
 /// Select/MySQLI - SESSION da conexao
$conex =  $_SESSION["conex"];
///
///     Acentuacao UTF8
////  mysqli_set_charset($conex,'utf8');
$conex->set_charset('utf8');
///
///  Verifica GET - SESSION  e POST  - m_nome_id
if( isset($_GET["m_nome_id"]) ) {
    if( ! strlen(trim($_GET["m_nome_id"]))<1  ) {
         $m_nome_id=trim($_GET["m_nome_id"]);
    }   
} 
/****  Final - if( isset($_GET["m_nome_id"]) ) {   ****/
///
if( isset($_SESSION["m_nome_id"]) ) {
    if( ! strlen(trim($_SESSION["m_nome_id"]))<1  ) {
        $m_nome_id=trim($_SESSION["m_nome_id"]);
    }
}
/*****   Final - if( isset($_SESSION["m_nome_id"]) ) {  *****/
///    
if( isset($_POST["m_nome_id"]) ) {
    if( ! strlen(trim($_POST["m_nome_id"]))<1  ) {
        $m_nome_id=trim($_POST["m_nome_id"]);
    }
}
/*****   Final - if( isset($_SESSION["m_nome_id"]) ) {  *****/    
///
if( ! isset($m_nome_id) ) $m_nome_id="";
///
preg_match("/^bem$/i",$m_nome_id,$nrtab);
///if( ! preg_match("/^bem$/i",$m_nome_id) ) {
if( count($nrtab)<1 ) {
   $m_nome_id="bem";
    $tabpri = $tabela = "bem";
   $_SESSION["m_nome_id"]=$m_nome_id;    
}
///
 ///
/*****  VERIFICANDO SE BANCO DE DADOS DE TESTE ESTA ATIVO - patrimonio_teste   ******/
if( isset($_SESSION["patrimonioteste"]) ) {
    $_SESSION["bd_1"]=$_SESSION["patrimonioteste"];  
    $bd_1=$_SESSION["patrimonioteste"];  
}
/******   Final - if( isset($_SESSION["patrimonioteste"]) ) {   ******/
///
/***    INCLUINDO CLASS - 
* 
*       PHP 7 
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
///
///   ATUALIZADO EM 20201117
///       TABELA bem
if( isset($tabpri) ) {
    ///
    /// Verificando a variavel da Tabela
    if( strlen(trim($tabpri))<1 )  {
        $_SESSION["tabpri"] = $tabpri = "bem";
   }
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
     while( $fieldinfo = mysqli_fetch_field($respri) ) {
           ///  
           $nomecpo=$fieldinfo->name;
           $name_c_id[] = $nomecpo;
           ///
           /// Codigo Local do Patrimonio
           if( preg_match("/^clp$/ui",$nomecpo) ) {
                ///
                /// Nome da coluna  CLP  da Tabela  
                $_SESSION["codclp"] = $nomecpo;
           }
           ///
           if( preg_match("/instituicao|idinst|^codinst/i",$nomecpo) ) {
               ///
               /// Nome da coluna  INSTITUICAO  da Tabela  
               $_SESSION["codidinst"] = $nomecpo;
               /// $_SESSION["instituicao"] = $nomecpo;
          }
          ///
          if( preg_match("/unidade|^codunid|idunid/i",$nomecpo) ) {
               ///
               /// Nome da coluna UNIDADE  da Tabela  
               $_SESSION["codidunid"] = $nomecpo;
               ///  $_SESSION["unidade"] = $nomecpo;
          }
          ///
          if( preg_match("/departamento|^depto|^coddept|iddept/i",$nomecpo)  ) {  
               ///
               /// Nome da coluna DEPTO/DEPARTAMENTO da Tabela  
               $_SESSION["codiddept"] = $nomecpo;
               /// $_SESSION["depto"] = $nomecpo;
          }
          ///
          if( preg_match("/setor|^codsetor|idsetor/i",$nomecpo) ) {
               ///
               /// Nome da coluna SETOR da Tabela  
               $_SESSION["codidseto"] = $nomecpo;
               /// $_SESSION["setor"] = $nomecpo;
          }
          ///
           ///  printf("Table: %s\n",$fieldinfo->table);
           ///  $ntam = $len_c[]  = $fieldinfo->max_length;
           /// Tamanho do Campo length dividido por 3
           ///   $ntam = (int) $fieldinfo->length/3;
           $ntam = ($fieldinfo->max_length)*1.6;
           $len_c["$nomecpo"] = $ntam;
           ///
           ///  Tipo do Campo
           $xtype=$fieldinfo->type;
           ///  Tamanho do Campo
           $xlength=$fieldinfo->length;

           ///
     }
     ///
     ///  Copia do Array em SESSION
     $_SESSION["name_c_id"]=$name_c_id;
     $_SESSION["len_c"]=$len_c;
     ///
     /// Nr. de campos da Tabela bem
     if( sizeof($name_c_id)<2 ) {
        $txterr="Falha na Tabela $tabpri menos que 2 campos.";
         echo $funcoes->mostra_msg_erro("$txterr");    
         exit();
     }
     ///
     /// Campos principais da Tabela bem
     
     /***
     for( $ni=0;$ni<count($name_c_id); $ni++ ) {
          $word = $name_c_id[$ni]; 
          if( preg_match("/^clp$/i",$word)  )  {
              /// Nome da coluna  LOGIN  da Tabela  
              $_SESSION["codclp"] = $word;
          }
          ///
     }
     ***/
     
    ///
} elseif( ! isset($tabpri) ) {
    echo $funcoes->mostra_msg_erro("Falha na variavel da Tabela");    
    exit();                  
} 
///  FINAL - isset($tabpri)  - Tabela usuario
///
///  Arquivo CSS
if( isset($estilocss) )  $_SESSION["estilocss"] = $estilocss;
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
include_once("{$_SESSION["incluir_arq"]}js/jquery-1.2.6.php");
include_once("{$_SESSION["incluir_arq"]}js/funcoes_js.php");
include_once("{$_SESSION["incluir_arq"]}js/consultar_patrimonio_js.php");
///  IMPORTANTE para incluir js qdo tiver variavel de PHP
include_once("{$_SESSION["incluir_arq"]}js/conecta_ajax.php");
include_once("{$_SESSION["incluir_arq"]}js/menu_patrimonial.php");
///
?>
<script type="text/javascript" >
///
function criarJanela(id) {
     var element_id = document.getElementById(id); 
     var m_top = 100; 
     /// var left = -20; 
     var left = 500; 
     /// m_top += element_id.offsetTop; 
     ///  m_top += element_id_top; 
     /// left += element_id.offsetLeft; 
     ///
     janelaCriada = window.open("","_blank","toolbar=no, location=no, directories=no, status=no, scrollbars=no, resizable=no, width=300, height=10, top="+m_top+", left="+left);
     janelaCriada.document.write("<p align='center' ><b>Usar * para mostrar todos registros.</b></p>");   
     janelaCriada.setTimeout("self.close();",3000);    
}
///
/// function - Abrir campo CLP
function abricpo(idcpo) {
    //// Abrir campo do CLP
    if( document.getElementById(idcpo) ) {
        ///
        var ltdmr = document.getElementById(idcpo);
        ///
        var tdisp = ltdmr.style.display;
        ///
        if( tdisp!="block" ) {
            ltdmr.style.display="block";   
        }
        ///
    }
}
///
</script>
</head>
<body onload="abrircpo('lc_clp')"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);"   >  
<?php
///
///    Abertura da Pagina
require_once("{$_SESSION["incluir_arq"]}script/abertura_da_pagina.php"); 
/***
if( isset($_GET["m_nome_id"]) ) {
    $_SESSION["m_nome_id"]=$_GET["m_nome_id"];
} else {
    $_SESSION["m_nome_id"]="";
}
***/
/****
     Chamada da funcao das tabelas - array multidimensional
***/
///  require("{$_SESSION["incluir_arq"]}script/array_multi.php");
require_once("{$_SESSION["incluir_arq"]}script/array_multi.php");
$_SESSION["m_editando"]=false;
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
///  Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
$dia = date("d");
$mes = date("m");
$ano = date("Y"); 
$ano_validade=$ano+2;
$_SESSION['datacad']="$ano-$mes-$dia";
$_SESSION['datavalido']="$ano_validade-12-31";
///
if( isset($_GET["m_nome_id"]) ) $tabela=$_GET["m_nome_id"];  
if( strtoupper($tabela)=="PATRIMONIO" ) $tabela="bem"; 
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
///  Destaivando variaveis de excluir,consultar e editar
/***
$_SESSION["m_excluir"]=false;
$m_excluir = $_SESSION["m_excluir"];
$_SESSION["m_consultar"]=TRUE;
$m_consultar = $_SESSION["m_consultar"];
$_SESSION["m_editando"]=false;
$m_editando = $_SESSION["m_editando"];
***/
///
if( isset($_SESSION["m_excluir"]) ) unset($_SESSION["m_excluir"]);
if( isset($_SESSION["m_editando"]) ) unset($_SESSION["m_editando"]);
///
$_SESSION["m_consultar"]=true;
$m_consultar = $_SESSION["m_consultar"];
///
///  $tabela="bem";
/****
   Tabela principal do Banco de Dados
***/
$tabela="$tabpri";
$_SESSION["tabela"]=$tabela;
///
/// Titulo do Cabecalho
if( ! isset($_SESSION["tit_pag"]) ) {
    $_SESSION["tit_pag"]="Patrimonio";
} 
$tit_pag=$_SESSION["tit_pag"];
///
if( ! isset($_SESSION["tabela_salva"]) ) $_SESSION["tabela_salva"]="";
///
?>
<!-- CORPO -->
<div id="corpo" >
<!-- Mensagem de erro ou  -->
<div  id="label_msg_erro" >
</div>
<!-- Final - Mensagem de erro ou  -->
<p class="tr_cabecalho" style="overflow:hidden;" ><b>Consultar/<?php echo $tit_pag;?></b></p>
<hr style="border-bottom: 1px solid #000000; margin: 0px; padding: 0px;" />
<!--  DIV abaixo os Dados Antes de pedir o Arquivo para Upload   -->
<div id="div_form" style=" overflow: hidden; display:<?php echo $_SESSION["div_form"];?>;" >
<?php
///
    if( ! isset($m_onblur) ) $m_onblur="";
    $m_campo_chave="codigo"; $order_by="";  $n_fields="";
    ///
    if( strlen($tabela)>1 ) {
        ///
        ////   Atualizado  em  20190510
       $limit="";
        ///  sessao $_SESSION["m_nome_id"]  ->  nome da tabela ou $tabela
       if( preg_match("/^codigo|^codigousp/i",strtoupper(trim($m_campo_chave))) ) {
           $m_title="C&oacute;digo";  $m_nome_primeiro_campo="C&oacute;digo";
           $order_by=" order by {$m_campo_chave} ";   
           ///
       } elseif( strtoupper(trim($m_campo_chave))=="SIGLA" ) {
            $m_title="Sigla";   
       }
       ///
       if( preg_match("/^bem$/i",$tabela) ) {
            $m_campo_chave="clp"; $order_by=" order by $m_campo_chave ";     
            $tabela="bem"; 
            ////  $limit=" limit 5 ";
       }         
       ///
       ///  Banco de dados - BD/DB
       if( ! isset($_SESSION["bd_1"]) ) {
             echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
              exit();
       }
       $bd_1 = $_SESSION["bd_1"];  
       ///
       ///  Conexao BD/DB
       $conex = $_SESSION["conex"];
       ///
       ///  Select/MySQL
       $txt="SELECT * FROM $bd_1.$tabela  $order_by $limit ";
       $result=mysqli_query($conex,"$txt");
       ///
       /// if( ! $result ) {
       if( mysqli_error($_SESSION["conex"]) ) { 
           $txterr="Falha no select da Tabela $tabela - db/Mysqli:&nbsp;";
            echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
            //// echo "ERRO: Falha no select da Tabela ".$tabela.": ".mysql_error();
            exit();
       }
       ///
       ///   Nr. de registros
       $tol_regs = mysqli_num_rows($result);
       ///
       ///  Verifica numero de registros
       if( intval($tol_regs)<1 ) {
           $txterr="==== Nenhum registro encontrado dessa Tabela: $tabela ====";
           echo $funcoes->mostra_msg_erro("$txterr");    
           exit();      
       } 
       ///
           ///
            ///  numero de campos da Tabela
           ////
           $m_tit1_select = ucfirst($m_campo_chave); 
           $m_size=60; $m_maxlenght=60;
           ///
           ///
           ///  Array com nome de campos 
           $array_campo_nome=array( "clp"=> "CLP",  "chapausp" => "Chapa",
                       "serie"=>"Série", "descricao"=>"Descri&ccedil;&atilde;o", 
                       "sigla" => "Sigla", "codigo" => "Código", 
                       "instituicao" => "Instituição","unidade" => "Unidade", 
                       "depto"=>"Depto","setor"=>"Setor", 
                       "nome" => "Nome do Patrimonio/Bem",
                       "modelo"=>"Modelo","marca"=>"Marca", "situacao"=>"Situação", 
                       "titulo" => "Título", "vigenciai" => "Vigência Inicial", 
                       "vigenciaf" => "Vigência Final", "datacompra" => "Dt Compra", 
                       "bloco"=>"Bloco", "sala"=>"Sala","salatipo"=>"Sala Tipo" );
           ///
           $_SESSION["array_campo_nome"]=$array_campo_nome;
           ///
           /***
           for( $nir=0;$nir<$tol_regs;$nir++ ) {
                 for( $xyz=0; $xyz<$sz_name_c_id; $xyz++ ) { 
                       $nome_cpo=$name_c_id[$xyz];
                       $while_result["$nome_cpo"][$nir]=mysqli_result($result,$nir,$nome_cpo);
                 }
           }
           ***/
           ///   Criando o Array com campos e valores da Tabela selecionada
           $x = 0;
           while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {        
               ///  Nome dos campos da Tabela
               for( $nt=0; $nt<count($name_c_id); $nt++ ) {
                   $nomekey=$name_c_id[$nt];
                   $while_result["$nomekey"][$x] = $row["$nomekey"]; 
                   ///          
               }
               $x++;
           }
           ///
           if( preg_match("/^atributo|^categoria|^grupo/i",$tabela) ) {
                $m_tit1_select="C&oacute;digo"; 
                $m_nome_segundo_campo="Descri&ccedil;&atilde;o";
                $m_campo_ligacao = "descricao";
           }
           /// 
           $txt="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";
           $onkeyup="$txt";
           ///
           ///  $m_nome_primeiro_campo = ucfirst($_SESSION["m_nome_id"]);            
           if( $tabela=="bem" ) {   //  Tabela bem/patrimonio
                 $m_size=15; $m_maxlenght=12;
           } elseif( $tabela=="grupo" ) {
                 $m_title="Descri&ccedil;&atilde;o";   
           }     
           ///
           ///  Primeiro campo da Tabela
           if( isset($len_c[$name_c_id[0]]) ) {
                $tamanho_cpo=$len_c[$name_c_id[0]];   
           }
           ///
           /***   ALTERADO EM 20201118  
            *     Sessions da INSTITUICAO, UNIDADE, DEPARTAMENTO (depto) e SETOR
           ***/
           require_once("{$_SESSION["incluir_arq"]}script/iuds_locais.php");
           ///
           ///  INSTITUICAO
           $sigla_instituicao="";
           if( isset($_SESSION["instituicao"]) ) {
               $sigla_instituicao=$_SESSION["instituicao"];  
           } 
           ///  UNIDADE
           $sigla_unidade="";
           if( isset($_SESSION["unidade"]) ) {
               $sigla_unidade=$_SESSION["unidade"];   
           }
           ///  DEPTO
           $sigla_depto="";
           if( isset($_SESSION["depto"]) ) {
               $sigla_depto=$_SESSION["depto"];   
           }
           ///
           /// Campos para selecionar Consulta do BEM/PATRIMONIO
           require_once("{$_SESSION["incluir_arq"]}script/consultando_patrimonio.php");
           ///
       ?>
<hr style="top: 0px; color: #000000; height: 1px; margin: 0px; padding: 0px; border: 1px #000000 solid; " >
  <?php   

       ///
    }  
    ///  FINAL  -  IF strlen($tabela)>1
    ///
?>
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