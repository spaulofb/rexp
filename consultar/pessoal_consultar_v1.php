<?php 
/**
    EDITANDO: LAFB/SPFB110903.0934

    REXP - CONSULTAR PESSOAL  
 
    LAFB/SPFB120220.2219
*/
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
   session_start();
}
//
//
/**     Verificar a Mensagem de Erro  
 *  Crucial ter as configurações de erro ativadas
*/ 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//
//  set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//
// Defina os cabeçalhos de controle de cache
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-type: text/html; charset=utf-8");
//
/**  Colocar as datas do Cadastro do Usuario e a validade   */  
date_default_timezone_set('America/Sao_Paulo');
//
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
//  setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
//
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
/**  extract: Importa variáveis para a tabela de símbolos a partir de um array   */ 
extract($_POST, EXTR_OVERWRITE);  
//
// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";
//
$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";
//
$msg_final="</span></span>";
//   FINAL - Mensagens para enviar
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
//
//   CASO OCORREU ERRO GRAVE
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
//
//  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) {
     $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
} 
// $_SESSION['time_exec']=180000;
//
/**
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
///
?>
<!DOCTYPE html >
<html lang="pt-br" >
<head>
<meta charset="UTF-8" />
<meta name="author" content="SPFB/LAFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta http-equiv="Expires" content="-1" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Consultar Pessoal</title>
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js"  charset="utf-8" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/1/jquery.min.js?ver=1.9.1" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script  language="javascript"  type="text/javascript" >
/**  
*      JavaScript Document  - 20180810
*      Define o caminho HTTP  -  20180416
*/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
charset="utf-8";
///
///  variaveis quando ocorrer Erros ou  quando estiver Ccorreto
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
///  
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
///
var final_msg_ini='</span></span>';
/**   Final - variaveis quando ocorrer Erros ou  quando estiver Ccorreto   */
// 
//
//  funcrion acentuarAlerts - para corrigir acentuacao
//  Criando a function  acentuarAlerts(mensagem)
function acentuarAlerts(mensagem) {
    //
    //  Paulo Tolentino
    /**    Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));  */
    //
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
/**  Final -- function acentuarAlerts(mensagem)  */
//
//  Dados para enviar em pagina AJAX
function consulta_mostrapes(tcopcao,dados,string_array) {
/**
*      Selecionar os Usuários de acordo com a opcao (todos ou pela primeira letra)
*
*      LAFB/SPFB110831.1127
*/
    // 
    // Verificando se a function exoc existe
    if(typeof exoc=="function" ) {
         //
         //  Ocultando ID
         exoc("label_msg_erro",0);  
    } else {
        alert("function exoc não existe");
    }
    //
    ///  Verificando variaveis
    if( typeof(tcopcao)=="undefined" ) var tcopcao=""; 
    if( typeof(dados)=="undefined" ) var dados=""; 
    if( typeof(string_array)=="undefined" ) var string_array=""; 
    //
    // Variavel para maiuscula 
    var lcopcao = tcopcao.toUpperCase();
    //
      
 alert("  pessoal_consultar.php/123 --  tcopcao = "+tcopcao+" - dados = "+dados+" - string_array = "+string_array);    

    /*****    
     *   Reiniciar a pagina atual 
     *     - utilizar a variavel paginal_local
    */
    if( lcopcao=="RESET" ) {
         parent.location.href=pagina_local;                
         return;   
    }
    //    
    // BOTAO - TODOS
    var lcopcao = tcopcao.toUpperCase();
    var quantidade= lcopcao.search(/TODOS|TODAS/ui);
    if( quantidade!=-1 ) {
        //
        if( document.getElementById("ordenar") ) {
            //
            var nraid = document.getElementById("ordenar");
            var zdisp = nraid.style.display;
            //
            if( zdisp!="block" ) {
                nraid.style.display="block";
                //
            }
            //
            document.getElementById("ordenar").selectedIndex="0";
             //
        } else {
             alert("Faltando document.getElementById(\"ordenar\") ");           
        }
        //
        if( document.getElementById("Busca_letrai") ) {
              document.getElementById("Busca_letrai").selectedIndex="0";
        }
        // 
        //  Desativando ID  div_out
        exoc("div_out",1,"");                   
        //
        return;
        //
    }  
    /**  Final - if( quantidade!=-1 ) {  */
    //
    /// tag Select para Ordenar o Botao Todos
    var quantidade=lcopcao.search(/ORDENAR/i);
    if( quantidade!=-1 ) {
         //
         //  var tmp=val;
         var tmp=dados;
         //  var val=lcopcao;
         var dados=lcopcao;
         var lcopcao=tmp;
         //
         ///  var string_array=string_array.replace(" ","");      
        if( document.getElementById("Busca_letrai") ) {
              document.getElementById("Busca_letrai").selectedIndex="0";
        }    
        //
    }   
    /**   Final - if( quantidade!=-1 ) {  */
    // 
    // tag Select para desativar o campo Select ordenar
    //  var quantidade=dados.search(/^BUSCA_PROJ|^busca_porcpo|^Busca_letrai/ui);
    var xpos=lcopcao.search(/^BUSCA_PROJ|^busca_porcpo|^Busca_letrai/ui);

/**   
    alert(" pessoal_consultar.php/291 -->> xpos = "+xpos+" -->>  lcopcao = "+lcopcao
      +" -->> dados = "+dados+" - string_array = "+string_array);
 */



    if( xpos!=-1 ) {
        //
        if( document.getElementById("ordenar") ) {
              document.getElementById("ordenar").selectedIndex="0";
              document.getElementById("ordenar").style.display="none";            
        }  
        //
    } 
    /**  Final - if( quantidade!=-1 ) {   */
    //    
    /**   Iniciando o AJAX para selecionar os usuarios desejados  */
    var xAJAX_mostraus = new XHConn();
    /**   Um alerta informando da nao inclusao da biblioteca  
    *     IMPORTANTE: descobrir erros nos comandos - try e catch
    */
    try {
       if( !xAJAX_mostraus ) {
            alert("XMLHTTP inativo. Tente um navegador mais novo ou melhor.");
            return false;
        }
    } catch(err) {
        //
        // Enviando mensagem de erro
        exoc("label_msg_erro",1,err.message);  
        //
    }
    //
    //
    /**   Define o procedimento para processamento dos resultados dp srv_php  */
    var fndone_mostraus = function (oXML) { 
        //
        //  Recebendo o resultado do php/ajax
        var srv_ret = oXML.responseText;
        var lnip = srv_ret.search(/Nenhum|ERRO:|Uncau|Fatal erro/ui);
 
        
  alert("  pessoal_consultar.php/257 -- lnip = "+lnip+"  <<--- tcopcao = "+tcopcao+" - dados = "+dados
               +" - string_array = "+string_array);    

            //
            if( lnip==-1 ) {
                //
                // if( lcopcao=="LISTA" ) {
                if( typeof(lcopcao)=="undefined" ) var lcopcao=""; 
                var pos=lcopcao.search(/LISTA|MOSTRAR/i);
                if( pos!=-1 ) {
                    //
                    if( document.getElementById('div_out') ) {
                        //
                        //  Mostrar dados no ID  div_out
                        exoc("div_out",1,srv_ret);  
                        //
                        return;
                        //
                    }  
                    //
                } else {
                    //
                    if( lcopcao=="TODOS" ) {    
                        if( document.getElementById('Busca_letrai') )  {
                             document.getElementById('Busca_letrai').options[0].selected=true;
                             document.getElementById('Busca_letrai').options[0].selectedIndex=0;    
                        }
                     }    
                     ///  document.getElementById('label_msg_erro').style.display="none";    
                     document.getElementById('div_out').innerHTML=srv_ret;                 
                }
                //    
            } else {
                //
                //  Mostrar erro no ID label_msg_erro
                /**  
                     document.getElementById('label_msg_erro').style.display="block";
                     document.getElementById('label_msg_erro').innerHTML=srv_ret;
                */
                exoc("label_msg_erro",1,srv_ret);  
                //
            }; 
            //
    };
    // 
    //  Define o servidor PHP para consulta do banco de dados
    var srv_php = "srv_mostrapessoal.php";
    var poststr = new String("");
    //
    var poststr = "grupous="+encodeURIComponent(lcopcao)+"&dados="+encodeURIComponent(dados);
    var poststr = "grupous="+encodeURIComponent(lcopcao)+"&dados="+encodeURIComponent(dados);
    poststr +="&m_array="+encodeURIComponent(string_array); 
    //
    xAJAX_mostraus.connect(srv_php, "POST", poststr, fndone_mostraus);   
    //
}  
/**  Final - function consulta_mostrapes(tcopcao,dados,string_array) {  */
//
</script>
<?php
//
//  Arquivo javascript em PHP - alterado em 20250610
//  
require_once("{$_SESSION["incluir_arq"]}js/pessoal_consultar_js.php");
//
require_once("{$_SESSION["incluir_arq"]}includes/domenu.php");
//
//   CONSULTAR PESSOAL
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//
?>
</head>
<body id="id_body" oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"      onkeydown="javascript: no_backspace(event);"   >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho"  >
<?php require_once("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
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
<div  id="corpo"  >
<!--  Mensagem de ERRO e Titulo  -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Consultar&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Mensagem de ERRO e Titulo  -->
<?php 
//
//   Verificano o PA - Privilegio de Acesso
/**
 *    if( ( $_SESSION["permit_pa"]>$_SESSION['array_usuarios']['superusuario']  and $_SESSION["permit_pa"]<=$_SESSION['array_usuarios']['orientador'] ) ) {    
 */
// 
if( ( $_SESSION["permit_pa"]>$array_pa['super']  and $_SESSION["permit_pa"]<=$array_pa['orientador'] ) ) {    
    ?>
<div id="div_form" class="div_form" style="overflow:auto;" >
<?php
//
//  CODIGO/USP
$elemento=5;
include("php_include/ajax/includes/conectar.php");     
//
/**   IMPORTANTE: para evitar problemas de acentuacao   */ 
mysqli_set_charset($_SESSION["conex"],'utf8');
//
//  Selecionar os usuarios pela primeira letra do nome
/**  
*  $sqlcmd = "SELECT upper(substr(nome,1,1)) as letra1,count(*) as n ";
*  $sqlcmd .= " FROM $bd_1.pessoa  group by 1";
 */
//          
$sqlcmd = "SELECT nome, codigousp, e_mail ";
$sqlcmd .= " FROM $bd_1.pessoa  order by nome ";
//
$result = mysqli_query($_SESSION["conex"],$sqlcmd);
if( ! $result ) {
    //
    /**  $terr="ERRO: Falha consultando a tabela pessoa  - letra inicial:&nbsp;db/mysqli&nbsp;";  */
    $terr="ERRO: Falha consultando a tabela pessoa:&nbsp;db/mysqli&nbsp;";
    die("$terr".mysqli_error($_SESSION["conex"]));  
    //
}  
//
//  Nr. de pessoas encontradas     
$lnletras = mysqli_num_rows($result);                
if( intval($lnletras)<1 ) {
    //
     ?>
     <script type="text/javascript">
          //
          var srv_ret = "Nenhuma pessoa encontrada.";
          //  Mostrar erro no ID label_msg_erro
          /** 
          *     document.getElementById('label_msg_erro').style.display="block";
          *     document.getElementById('label_msg_erro').innerHTML=srv_ret;
          */
           exoc("label_msg_erro",1,srv_ret);
           ///  
     </script>     
   <?php
} else {
    //
    /**   Salvar letrais iniciais em um conjunto para facilitar a busca   */
    //
?>
<!-- Todas pessoas -->
<div style="display: flex;"  >
 <div class='titulo_usp' style='margin-left: 30%; padding:2px 0 2px 2px; font-weight: bold;font-size:large;' >Mostrar:&nbsp;
 <span style="vertical-align:top;font-size: medium;  " >
<input type='button' id='todos' class='botao3d'  value='Todos' 
    title='Selecionar todos'  onclick='javascript:  consulta_mostrapes("Todos")' >
</span>
<span class="span_ord_proj" >
<!-- tag Select para ordenar  -->
<select  title="Ordernar" id="ordenar" class="ordenar"  onchange="javascript: consulta_mostrapes('ordenar',todos.value,this.value)" >
<option  value=""  >ordenar por</option>
<option  value="categoria asc"  >Categoria - asc</option>
<option  value="categoria desc" >Categoria - desc</option>
<option  value="nome asc"  >Nome - asc</option>
<option  value="nome desc" >Nome - desc</option>
<option  value="sexo,nome asc"  >Sexo,Nome - asc</option>
<option  value="sexo,nome desc" >Sexo,Nome - desc</option>
<option  value="unidade asc"  >Unidade - asc</option>
<option  value="unidade desc"  >Unidade - desc</option>
<option  value="unidade,setor asc"  >Unidade,Setor - asc</option>
<option  value="unidade,setor desc"  >Unidade,Setor - desc</option>
</select>
</span>
</div>
</div>
<!--  Final - Todas pessoas -->
<?php
}
/**   Final - if( intval($lnletras)<1 ) {   */
//
?>
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_lista" >ou pela letra inicial:&nbsp;</p>
</div>
<div  class="div_select_busca" >
<select name="Busca_letrai" id="Busca_letrai" class="Busca_letrai" title="Selecionar pessoa pela letra inicial" 
              onchange="consulta_mostrapes(this.id,this.value)" >
<?php
//
 if( intval($lnletras)<1 ) {
      echo "<option value='' >Nenhuma pessoa encontrada.</option>";
 } else {
    //
?>
<option value="" >Selecionar Pessoa pela letra inicial</option>
<?php
    //
    //  Com um ou mais registros 
    while( $linha=mysqli_fetch_array($result) ) {       
           //

           //  htmlentities - corrige poss?veis falhas de acentuacao de code page
           //   $letra= htmlentities($linha["letra1"]);  
           $nmusr=$linha["nome"];  
           $lncodigousp=$linha["codigousp"];  
           $lnemail=$linha["e_mail"];
           //
           /**
           *   echo "<option value=".urlencode($letra)." title='Clicar para Busca' >".$letra."</option>";
           */   
           echo "<option  value=\"$lncodigousp\"  title=\"Clicar para busca\"  >$nmusr</option>";  
           //
    } 
    /**  Final - while( $linha=mysqli_fetch_array($result) ) {   */
    //
?>
</select>
<?php 
   //
   /**  Desativar variavel   */
   if( isset($result) ) {
        //  mysql_free_result($result); 
        unset($result); 
        // 
   } 
   //
}
//
?>   
</div>
<p class="titulo_lista" ><b>Lista do Pessoal</b></p>
<?php
} else {
   echo  "<p class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
<div id="div_out" class="div_out" >
</div>
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