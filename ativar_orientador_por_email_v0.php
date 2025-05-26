<?php 
/*   REXP - Permissao de novo Orientador
* 
*   LAFB&SPFB120420.1146   
*/
//  ==============================================================================================
//  
//  ==============================================================================================
///

//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///************************************************************************************
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // sempre modificada
header("Pragma: no-cache"); // HTTP/1.0
header("Cache: no-cache");
//  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
// For?a a recarregamento do site toda vez que o navegador entrar na p?gina
header("http-equiv='Cache-Control' content='no-store, no-cache, must-revalidate'");
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

//  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0")
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
///
ini_set('default_charset','UTF-8');

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
///
///  Navegador permitido  e  Definindo a Raiz do Projeto
//// require_once('/var/www/cgi-bin/php_include/ajax/includes/navegador_permitido.php');
require_once('php_include/ajax/includes/navegador_permitido.php');
//
//    MENU HORIZONTAL
$elemento=5; $elemento2=6;
///  require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
require_once('php_include/ajax/includes/tabela_pa.php');

if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];    
include("includes/array_menu.php");
//  $_SESSION["permit_pa"]=$array_usuarios['orientador'];
$_SESSION["permit_pa"]=$array_pa['orientador'];
//  $_SESSION["m_horiz"] = $array_voltar;
//  $_SESSION["m_horiz"] = $array_sair;
//
///  require_once('/var/www/cgi-bin/php_include/ajax/includes/novo_orientador.php');
require_once('php_include/ajax/includes/novo_orientador.php');
if( $m_linhas<1 ) exit();
//
// $_SESSION['time_exec']=180000;
//  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]="Registro de Anotação";
unset($_SESSION["m_horiz"]);
///
///  EMAIL GEMAC  atual - 20170719
/***
     $_SESSION["gemac"]="gemac_sol@sol.fmrp.usp.br";
     $_POST["gemac"]="gemac_sol@sol.fmrp.usp.br";

    $_SESSION["gemac"]='bezerralaf@gmail.com; spfbezer@fmrp.usp.br';
    $_SESSION["gemac"]="gemac@sol.fmrp.usp.br";
****/
///  IMPORTANTE: Funcionando - alterado em 01/09/2017
$_SESSION["gemac"]="gemac@genbov.fmrp.usp.br";
$_POST["gemac"]="gemac@genbov.fmrp.usp.br";

////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
?>
<!DOCTYPE html >
<head>
<meta charset="utf-8" >
<meta name="language" content="pt-br" />
<meta name="author" content="LAFB&SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<!--  <meta name="ROBOTS" content="NONE">  -->
<meta name="ROBOTS" content="ALL" >
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no"> 
<title>Cadastrar Pessoa</title>
<!-- <script type="text/javascript"  language="javascript"   src="includes/dochange.php" ></script>    -->
<link  type="text/css"  href="css/estilo.css" rel="stylesheet"  />
<!--  <link  type="text/css"   href="css/style_titulo.css" rel="stylesheet" />  -->
<script  type="text/javascript" src="js/XHConn.js" ></script>
<script  type="text/javascript"  src="js/functions.js" ></script>
<script  type="text/javascript" src="js/formata_data.js"></script>
<script  type="text/javascript"  src="js/ativar_orientador_por_email.js" ></script> 
<script type='text/javascript' src='js/1/jquery.min.js?ver=1.9.1'></script>
<script  type="text/javascript"  src="js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="js/resize.js" ></script>
<script type="text/javascript" src="js/verifica_mobile.js" ></script>
<script type="text/javascript">
/* <![CDATA[ */
//
//  Javascript - 20100621
/*
     Aumentando a Janela no tamanho da resolucao do video
*/
self.moveTo(-4,-4);
//  self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
//  self.resizeTo(1000,1000);
self.focus();
//   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
if ( screen.width<1024 ) {
    alert("A resolu??o da tela do seu monitor para esse site ?\n RECOMEND?VEL no m?nimo  1024x768 ")
}
//
//   Recebe os dados dos campos - FORM 
var btnWhichButton="";  // vari?vel global 
function ativando_dados(source,val,string_array) {
    /// Verificando se a function exoc existe 
    if(typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
    ///  Verificando variaveis recebidas
    if( typeof(source)=="undefined" ) var source=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";
    if( typeof(val)=="string" ) var val_upper=val.toUpperCase();

    
    ///   Criando os campos instituicao, unidade, departamento, setor 
    var source_upper=source.toUpperCase(); 
    
 /// alert(" ativar_orientador_por_email.php/89  - source = "+source+"  - val = "+val+" - string_array = "+string_array)
    /// 
    if( source_upper=="SUBMETER" ) {
        var pos_val = val.indexOf("#");
        if( pos_val!=-1 ) {
            var val_array = val.split("#");
            var val;
            val = val_array[0];
            sn  = val_array[1];
        }
        //  FORM enviado na variavel string_array 
        var frm = string_array;
         //  var frm = document.form1;
         var m_elements_total = frm.length; 
         //  var elements = document.getElementsByTagName("input");
         m_elements_nome = new Array(m_elements_total);
         m_elements_value= new Array(m_elements_total);
          var m_erro = 0; var n_coresponsaveis= new Array(); 
         var n_i_coautor=0;   var n_senhas=0;  var n_testemunhas=0;
          var campo_nome="";   var campo_value=""; var m_id_value=""; 
         if( document.getElementById("label_msg_erro") ) document.getElementById("label_msg_erro").style.display="none";
         //  ATENCAO:  i tem que ser menor que o total de campos
         for ( i=0; i<m_elements_total; i++ ) {      
            //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
            var m_id_name = frm.elements[i].name;
            var m_id_type = frm.elements[i].type;
            var m_id_title = trim(frm.elements[i].title);
            // var m_id_value = frm.elements[i].value;
             //  var m_id_value = frm.elements[i].value;
             //  SWITCH para verificar o  type da  tag (campo)
             switch (m_id_type) {
                  case "undefined":
                  //  case "hidden":   precisa de dados as vezes             
                  case "button":
                  case "image":
                  case "reset":
                  case "submit":                  
                  continue;
             }
             //  ALERT - para testar o FORM do EXPERIMENTO
             //  alert(" LINHA 35 -  source = "+source+" - val = "+val+" - m_id_name = "+m_id_name+" -  m_id_type = "+m_id_type)
   
             if ( m_id_type== "checkbox" ) {
                //Verifica se o checkbox foi selecionado
                if( ! elements[i].checked ) var m_erro = 1;
             } else if ( m_id_type=="password" ) {
                 // Verifica se a Senha foi digitada
                 m_id_value = trim(document.getElementById(m_id_name).value);
                 if( m_id_value.length<8 )  var m_erro=1;  
                 if( m_id_value.length>3 && m_id_name.toUpperCase()=="ACTIV_CODE" ) var m_erro=0;
                 //  Verficando se tem dois campos senha e outro para confirmar
                 if( m_erro<1 ) {
                     if( ( m_id_name.toUpperCase()=="SENHA" ) || ( m_id_name.toUpperCase()=="REDIGITAR_SENHA" ) ) {
                          n_senhas=n_senhas+1;
                     }                          
                 }
             } else if( m_id_type=="text" ) {  
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value=="" ) {
                       var m_erro = 1;       
                  } else {
                      //  Verificando o campo email
                      var m_email = new Array('EMAIL','E_MAIL','USER_EMAIL');
                      for(key in m_email) {  
                          if ( m_email[key]===m_id_name.toUpperCase() ) {
                               var resultado = validaEmail(m_id_name);  
                               if( resultado===false  ) return;
                          }                            
                      } 
                      //  Verificando o campo usuario/login
                      var m_login = new Array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
                      for(key in m_login) {  
                          if ( m_login[key]===m_id_name.toUpperCase() ) {
                              if( m_id_value.length<5 ) {
                                 var m_erro = 1;       
                                 break;                                   
                              }
                          }                            
                      }                                              
                  }
                  //  Se campo for usuario ou  senha
             } else if( m_id_type=="hidden" ) {  
                  m_erro=0;
                  m_id_value = trim(document.getElementById(m_id_name).value);
             } else if( m_id_type=="textarea" ) {  
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value=="" ) var m_erro = 1;     
             }  else if( m_id_type=="select-one" ) {  
                  if( m_id_name=="anotacao_select_projeto" || m_id_name.toUpperCase()=="ALTERA_COMPLEMENTA" ) continue;
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value=="" ) var m_erro = 1;    
                   // Verificando os campos das testemunhas do Experimento
                    if( ( m_id_name.toUpperCase()=="TESTEMUNHA1" ) || ( m_id_name.toUpperCase()=="TESTEMUNHA2" ) ) {
                        if( m_id_name.toUpperCase()=="TESTEMUNHA1" ) {
                           var confirm_text = "Testemunha1";
                      } else if( m_id_name.toUpperCase()=="TESTEMUNHA2" ) {
                             var confirm_text = "Testemunha2";
                      }
                        if( m_id_value=="" ) {      
                            var decisao = confirm("Selecionar "+confirm_text+"?");
                            if ( decisao ) {
                                m_erro = 1;
                            } else {
                                m_erro = 0;
                            }
                      } else {
                          n_testemunhas=n_testemunhas+1;
                      }
                      //
                  }
                 //
             } else if( m_id_type=="file" ) {  
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value==""  ) {
                      var m_erro = 1;    
                  } else {
                    var tres_caracteres = m_id_value.substr(-3);  
                    var pos = tres_caracteres.search(/pdf/i);
                    // Verificando se o arquivo formato pdf
                    if( pos==-1 ) {
                        m_erro=1; m_id_title="Arquivo precisa ser no formato PDF.";
                    }
                  }
             }
             //
             //  IF quando encontrado Erro
             //  Quando for campo sem title passar sem erro
             if( m_id_title.length<1 ) m_erro=0;
             //  Verificando diferentes dados nos campos de Senha ( Senha e a Confirmacao )
             if( ( n_senhas>1 ) && ( m_erro<1 ) ) {
                 senha1 = document.getElementById("senha").value;
                 senha2 =  document.getElementById("redigitar_senha").value;
                 if( senha1!=senha2 ) {
                     m_id_title="SENHAS DIFERENTES";
                     m_erro=1;
                 }
             }
             if( m_erro==1 ) {
                  document.getElementById("label_msg_erro").style.display="block";
                  document.getElementById("label_msg_erro").innerHTML="";
                  var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                  msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                  var final_msg_erro = "&nbsp;</span></span>";
                  m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                  msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                  document.getElementById("label_msg_erro").innerHTML=msg_erro;
                  //  frm.m_id_name.focus();
                  //  document.getElementById(m_id_name).focus();
                  break;
             }
             //                 
             if( campo_nome.toUpperCase()!="REDIGITAR_SENHA"  )  {
                      campo_nome+=m_id_name+",";  
                      campo_value+=m_id_value+",";               
             }                 
            if( m_id_name.toUpperCase()=="ENVIAR" )  break;
         }         
        ///  document.form.elements[i].disabled=true; 
 ///   alert("LINHA 145 - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro)        
         if( m_erro==1 ) {
              document.getElementById(m_id_name).focus();
              return false;
         } else {
              ///  Enviando os dados dos campos para o AJAX
              var cpo_nome = campo_nome.substr(0,campo_nome.length-1);
              var cpo_value = campo_value.substr(0,campo_value.length-1);
              var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(cpo_nome)+"&campo_value="+encodeURIComponent(cpo_value)+"&sn="+encodeURIComponent(sn);             
         }
    }  //  FINAL do IF SUBMETER
    /*   Aqui eu chamo a class  */
    var myConn = new XHConn();
    /*  Um alerta informando da não inclus?o da biblioteca   */
    if ( !myConn ) {
          alert("XMLHTTP não dispon?vel. Tente um navegador mais novo ou melhor.");
          return false;
    }
    ///
    ///  Serve tanto para o arquivo projeto  quanto para o experimento - Cadastrar
    var receber_dados = "includes/dados_novo_orientador_por_email.php";
                             
 /// alert(" ativar_orientador_por_email.php/303  ->  source_upper = "+source_upper+" - val = "+val+" \r\n  poststr = "+poststr);
        
    /*  Melhor usando display do que visibility - para ocultar e visualizar   
        document.getElementById('div1').style.display="block";
        document.getElementById('div1').className="div1";
    */
     var inclusao = function (oXML) { 
                         //  Recebendo os dados do arquivo ajax
                         var m_dados_recebidos = oXML.responseText;
                         document.getElementById('label_msg_erro').style.display="none";
                         //// 
                         var pos = m_dados_recebidos.search(/ERRO:|FALHA:/i);
                             
  ////  alert(" ativar_orientador_por_email.php/312  -->> pos = "+pos+"  --- source_upper = "+source_upper+" - val = "+val+" \r\n m_dados_recebidos = "+m_dados_recebidos);
                     
                         ///  Caso ocorreu ERRO
                         if( pos!=-1 ) {
                              /// 
                             /*
                                 document.getElementById('label_msg_erro').style.display="block";
                                 document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                             */
                              /// Ativando o ID label_msg_erro com mensagem
                              exoc("label_msg_erro",1,m_dados_recebidos);                                                             /// 
                         } else {
    //  alert(" ativar_orientador.php/313  ->  source_upper = "+source_upper+" - val = "+val+" \r\n m_dados_recebidos = "+m_dados_recebidos)
                               document.getElementById('label_msg_erro').style.display="none";    
                               if( source_upper=="SUBMETER" ) {                              
                                    if( val.toUpperCase()=="ORIENTADOR_NOVO" ) {
                                         if( document.getElementById('div_form') )  {
                                               //  Remover o elemento filho de um elemento Pai
                                            /*  var pai = document.getElementById("corpo");
                                              var filho = document.getElementById("div_form");
                                              pai.removeChild(filho);
                                              */
                                             document.getElementById('div_form').innerHTML="";
                                             document.getElementById('div_form').style.display="none";   
                                           //   document.getElementById('div_form').setAttribute("style","padding-top: 2px; text-align: center;font-size: medium;");
              //   alert(" ativar_orientador.php/324  ->  source_upper = "+source_upper+" - val = "+val+" \r\n m_dados_recebidos = "+m_dados_recebidos)                                           
                                            // document.getElementById('div_form').innerHTML=m_dados_recebidos;   
                                             document.getElementById('label_msg_erro').style.display="block";
                                             document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;                                             
                                         }   
                                    } else {
                                          document.getElementById('label_msg_erro').style.display="block";    
                                          //  Recebendo o numprojeto e o num do autor
                                          var test_array = m_dados_recebidos.split("falta_arquivo_pdf");
                                          if( test_array.length>1 ) {
                                              m_dados_recebidos=test_array[0];
                                              var n_co_autor = test_array[1].split("&");
                                              //  Passando valores para tag type hidden
                                              document.getElementById('nprojexp').value=n_co_autor[0];
                                              document.getElementById('autor_cod').value=n_co_autor[1];
                                              if(  n_co_autor.length==3 ) {
                                                  //  ID da pagina anotacao_cadastrar.php
                                                  document.getElementById('anotacao_numero').value=n_co_autor[2];
                                              }
                                          }
                                          document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                          // Verificar pra nao acusar erro
                                          if( document.getElementById('arq_link') ) {
                                              document.getElementById('arq_link').style.display="block";        
                                          }
                                          //   document.getElementById('div_form').innerHTML=m_dados_recebidos;
                                    }
                               } else  {
                                   if( val.toUpperCase()!="ORIENTADOR_NOVO" ) {
                                     if( document.getElementById('corpo') ) document.getElementById('corpo').innerHTML=m_dados_recebidos;   
                                   }  
                               }
                         }
                         
           }; 
            /* 
              aqui ? enviado mesmo para pagina receber.php 
               usando metodo post, + as variaveis, valores e a funcao   */
        var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
        /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho   */
       //
}  //  FINAL da Function enviar_dados_cad para AJAX 
//
function button(botao) {
    //  onsubmit="javascript: ativando_dados('submeter','orientador_novo',document.form1); return false;"
//    var botao_selecionado = 'orientador_novo'+botao;
    // document.form1.submit();
    alert("botao = "+botao)
    //  document.myform.submit();
}
//
/* ]]> */
</script>
<?php
$_SESSION["n_upload"]="ativando";
//
?>
</head>
<body  id="id_body" onload="document.getElementById('div_form').style.display='block'"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"    onkeydown="javascript: no_backspace(event);"    >
<?php
//  require para o Navegador que nao tenha ativo o Javascript
require("js/noscript.php");
//
include_once("includes/array_menu.php");
//  $_SESSION["m_horiz"] = $array_sair;
?>
<!-- PAGINA -->
<div class="pagina_ini" >
<!-- Cabecalho -->
<div id="cabecalho">
<?php include("script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
//  include("includes/menu_horizontal.php");
include("includes/menu_horizontal_index.php");
?>
<!-- Final do MENU  -->
<!-- CORPO -->
<div id="corpo" style="text-align: center; width: 100%;"  >
<?php 
//   CADASTRAR PESSOAL
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=trim($_GET["m_titulo"]);    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=trim($_POST["m_titulo"]);      
}  
//   
$_SESSION["cols"]=4;	
//  Tabela PESSOA mas passa como PESSOAL
$_SESSION["onsubmit_tabela"]="PESSOAL";

if ( isset($_SERVER["REMOTE_ADDR"]) )    {
    $usuario_ip = $_SERVER["REMOTE_ADDR"];
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
    $usuario_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    $usuario_ip = $_SERVER["HTTP_CLIENT_IP"];
} 
$ips_permitidos = array("143.107.143.231","143.107.143.232","189.123.108.225",$usuario_ip);
//  if( $indice ) {
if( ! in_array($usuario_ip, $ips_permitidos) ) {
    ?>
    <script type="text/javascript">
       /* <![CDATA[ */
       alert("P?gina em constru??o")       
      /* ]]> */
   </script>
   <?php
   echo "<p style='text-align: center; font-size: medium;' >P&aacute;gina em constru&ccedil;&atilde;o</p>";
   echo "<p style='text-align: center; font-size: x-small;' >";
   ?>
   <a  href="http://www-gen.fmrp.usp.br/rexp/authent_user.php"  name="voltar" id="voltar"   class="botao3d"  style="font-size: 10px; height: 160px; cursor: pointer; "  title="Voltar"  acesskey="V"  alt="Voltar" >    
      Voltar&nbsp;<img src="imagens/enviar.gif" alt="Voltar"   style="vertical-align:text-bottom;"  >
   </a>
   <?php
   echo "</p>";
   exit();
}
$_SESSION["m_titulo"]="orientador";
//  @require_once('../inicia_conexao.php');  once = somente uma vez
//  include('inicia_conexao.php');
# 
?>
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro"  >
</div>
<p class='titulo_usp' >Permiss&atilde;o para novo&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?>&nbsp;de Projeto</p>
</section>
<div id="div_form"  style="width: 100%; overflow:auto; height: 416px; " >
<?php
//
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
//  Formatando a Data no formato para o Mysql
$dia = date("d");
$mes = date("m");
$ano = date("Y"); 
$ano_validade=$ano+2;
$_SESSION["datacad"]="$ano-$mes-$dia";
$_SESSION["datavalido"]="$ano_validade-12-31";
$_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|salatipo|sala";		   
//
//  PA:  superusuario,  chefe,  subchefe, orientador, anotador  -  includes/array_menu.php
//  if( $_SESSION["permit_pa"]=="0" or $_SESSION["permit_pa"]=="10"  ) {
//  if( $_SESSION[permit_pa]>=$_SESSION[array_usuarios][superusuario]  and  $_SESSION[permit_pa]<=$_SESSION["array_usuarios"]["orientador"]  ) {
if( $_SESSION["permit_pa"]<=$array_pa['orientador']  ) {
  ?>
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"   >
 <table class="table_inicio" cols="<?php echo $_SESSION["cols"];?>" align="center"   cellpadding="1"  cellspacing="1" style="font-weight:normal;color: #000000; width: 100%; border: none;"  >
      <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td    class="td_inicio1" style="text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	      <table style="text-align: left;margin: 0px; padding: 0px;"  >
         <tr>
            <!--  Nome da Pessoa -->
	       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" colspan="2"  >
              <label for="nome" style="vertical-align:bottom; padding-bottom: 1px;cursor: pointer;" title="Nome"   >Nome:&nbsp;</label>
			   <br /><br />
			  <input type="text" name="nome"   id="nome"   size="85"  maxlength="64"  value="<?php echo utf8_encode($nome);?>" readonly="readonly" />
              <input type="hidden"  name="codigousp"  id="codigousp"  value="<?php echo $_SESSION['codigousp'];?>"  />
			 </td>
          <!-- Final - Nome -->
          <!-- SEXO -->
	       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
             <label for="sexo" style="vertical-align:bottom; padding-bottom: 1px;cursor: pointer;" title="Sexo"  >Sexo:&nbsp;</label>
		      <br /><br />
              <input type="text" name="sexo"   id="sexo"  size="2"   value="<?php echo trim($sexo);?>" readonly="readonly" />
             <!-- Final - Sexo -->
			 </td>
            </tr>
          </table>
		  </td>
		  </tr>

        <tr align="left"  >
         <td  class="td_inicio1" style="text-align: left; vertical-align: middle; " colspan="<?php echo $_SESSION["cols"];?>" >
           <table style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
              <tr style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
               <td    class="td_inicio1" style="vertical-align: middle; text-align: left;"   >
              <!--  CPF  -->
               <label for="cpf" style="vertical-align: middle; cursor: pointer;" title="Digitar CPF"   >CPF:&nbsp;</label>
               <input type="text" name="cpf" id="cpf" size="15" value="<?php echo $cpfcerto;?>" readonly="readonly" />
             <!-- Final - CPF -->
             </td>
             <td    class="td_inicio1" style="vertical-align: middle; text-align: left;"   >
             <!--  PASSAPORTE -->
              <label for="passaporte" style=" padding-left: 4px; vertical-align: middle; cursor: pointer;" title="Digitar passaporte"   >PASSAPORTE:&nbsp;</label>
              <input type="text" name="passaporte"   id="passaporte"  value="<?php echo $passaporte;?>" readonly="readonly"    />
             <!-- Final - PASSAPORTE -->
             </td>
            <td    class="td_inicio1" style="vertical-align: middle; text-align: left;"   >
           <!--   Categoria  -->
          <span class="td_informacao2"  >
              <label for="categoria"  style="vertical-align: middle; cursor: pointer;" title="Categoria"    >Categoria:</label>
              <input type="text" name="categoria"   id="categoria"  style="width: 260px;"  value="<?php echo utf8_encode($descr_categ);?>" readonly="readonly" />             
             </span>
              <!--  FINAL - Categoria  -->
              </td>
              </tr>
           </table>
        </td>
       </tr>
       <?php
            ////  INSTITUICAO  -->  Sigla e Descricao
            if( ! isset($instituicao) ) $instituicao="";
            $resultado=mysql_query("Select nome from patrimonio.instituicao  
                                  WHERE upper(trim(sigla))='".$instituicao."'  ");
           ///
           if( ! $resultado ) {
                echo $funcoes->mostra_msg_erro("Falha no select da Tabela instituicao&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error());
                ////  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                exit();
           }
           ///  Numero de Registros 
           $n_regs=mysql_num_rows($resultado);
           $nome_instituicao="";
           $onmouse="";
           if( intval($n_regs)==1 ) {
               $nome_instituicao=mysql_result($resultado,0,0);
               $onmouse="  title='".utf8_encode($nome_instituicao)."'  ";
           } 
           ///
       ?>
	   <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td  class="td_inicio1" style="border: 1px solid #000000;text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	      <table style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
		   <tr  >
	       <td  class="td_instituicao" style="vertical-align: middle; text-align: left;padding-right: 7px;"  >
             <!--   INSTITUICAO  -->
             <span class="td_informacao2"  >
            <label for="instituicao"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Institui&ccedil;&atilde;o"   >Institui&ccedil;&atilde;o:</label>
			   <br /><br />
               <input type="text" name="instituicao"   size="14"  <?php echo "$onmouse";?>  id="instituicao"  value="<?php echo $instituicao;?>" readonly="readonly" />             
               </span>
    		  <!--  Final da instituicao  -->
			  </td>				  
              <?php
               ///  Campo UNIDADE e os outros
               if( strlen(trim($unidade))>=1  ) {
                    ////  UNIDADE  -->  Sigla e Descricao
                    if( ! isset($unidade) ) $unidade="";
                    $resultado=mysql_query("Select nome from patrimonio.unidade  
                                          WHERE upper(trim(sigla))='".$unidade."'  ");
                   ///
                   if( ! $resultado ) {
                        echo $funcoes->mostra_msg_erro("Falha no select da Tabela unidade&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error());
                        ////  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                        exit();
                   }
                   ///  Numero de Registros 
                   $n_regs=mysql_num_rows($resultado);
                   $nome_unidade="";
                   $onmouse="";
                   if( intval($n_regs)==1 ) {
                       $nome_unidade=mysql_result($resultado,0,0);
                       $onmouse="  title='".utf8_encode($nome_unidade)."'  ";
                   } 
                   ///
               ?>
                   <td  class="td_instituicao" style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;'  >
                     <!--   UNIDADE  -->
                     <span class="td_informacao2"  >
                      <label for="unidade"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Unidade" >Unidade:</label>
                      <br /><br />
                      <input type="text" name="unidade"  id="unidade"  <?php echo "$onmouse";?>  size="13"  value="<?php echo $unidade;?>" readonly="readonly" />             
                    </span>
                    <!--  Final da unidade  -->
                  </td>                  
                  <?php
                   ///  Campo DEPTO
                  if( strlen(trim($depto))>=1  ) {
                         ////  DEPTO  -->  Sigla e Descricao
                        if( ! isset($depto) ) $depto="";
                        $resultado=mysql_query("Select nome from patrimonio.depto  
                                              WHERE upper(trim(sigla))='".$depto."'  ");
                       ///
                       if( ! $resultado ) {
                            echo $funcoes->mostra_msg_erro("Falha no select da Tabela depto&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error());
                            ////  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                            exit();
                       }
                       ///  Numero de Registros 
                       $n_regs=mysql_num_rows($resultado);
                       $nome_depto="";
                       $onmouse="";
                       if( intval($n_regs)==1 ) {
                           $nome_depto=mysql_result($resultado,0,0);
                           $onmouse="  title='".utf8_encode($nome_depto)."'  ";
                       } 
                       ///
                    ?>
                     <td  class="td_instituicao" style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;'  >
                        <!--   DEPTO  -->
                        <span class="td_informacao2"  >
                          <label for="depto"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Departamento" >Depto:</label>
                          <br /><br />
                          <input type="text" name="depto"  id="depto"   <?php echo "$onmouse";?>  size="10"  value="<?php echo $depto;?>" readonly="readonly" />             
                        </span>
                        <!--  Final do depto  -->
                        </td>                  
                     <?php                      
                  }   
                  //// SETOR
                  if( strlen(trim($setor))>=1  ) {
                         ////  Setor  -->  Sigla e Descricao
                        if( ! isset($setor) ) $setor="";
                        $resultado=mysql_query("Select nome from patrimonio.setor  
                                              WHERE upper(trim(sigla))='".$setor."'  ");
                       ///
                       if( ! $resultado ) {
                            echo $funcoes->mostra_msg_erro("Falha no select da Tabela setor&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error());
                           ////  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                            exit();
                       }
                       ///  Numero de Registros 
                       $n_regs=mysql_num_rows($resultado);
                       $nome_setor="";
                       $onmouse="";
                       if( intval($n_regs)==1 ) {
                           $nome_setor=mysql_result($resultado,0,0);
                           $onmouse="  title='".utf8_encode($nome_setor)."'  ";
                       } 
                       ///
                     ?>
                     <td  class="td_instituicao" style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;'  >
                        <!--   SETOR  -->
                        <span class="td_informacao2"  >
                          <label for="setor"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Setor" >Setor:</label>
                          <br /><br />
                          <input type="text" name="setor" id="setor"  <?php echo "$onmouse";?>  size="10"   value="<?php echo $setor;?>" readonly="readonly" />             
                        </span>
                        <!--  Final do setor  -->
                        </td>                  
                     <?php                      
                  }   
                  
                  if( strlen(trim($bloco))>=1  ) {
                     ?>
                     <td  class="td_instituicao" style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;'  >
                        <!--   BLOCO  -->
                        <span class="td_informacao2"  >
                          <label for="bloco"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Bloco" >Bloco:</label>
                          <br /><br />
                          <input type="text" name="bloco" id="bloco"  size="8"   value="<?php echo $bloco;?>" readonly="readonly" />             
                        </span>
                        <!--  Final do bloco  -->
                        </td>                  
                     <?php                      
                  }   
                  
                  if( strlen(trim($salatipo))>=1  ) {
                     ?>
                     <td  class="td_instituicao" style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;'  >
                        <!--   SALATIPO  -->
                        <span class="td_informacao2"  >
                          <label for="salatipo"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Salatipo" >Salatipo:</label>
                          <br /><br />
                          <input type="text" name="salatipo" id="salatipo"  size="15"   value="<?php echo $salatipo;?>" readonly="readonly" />             
                        </span>
                        <!--  Final do salatipo  -->
                        </td>                  
                     <?php                      
                  }   

                  if( strlen(trim($sala))>=1  ) {
                     ?>
                     <td  class="td_instituicao" style='position: relative; float: left; vertical-align: middle; text-align: left;padding-right: 7px;'  >
                        <!--   SALA  -->
                        <span class="td_informacao2"  >
                          <label for="sala"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Sala" >Sala:</label>
                          <br /><br />
                          <input type="text" name="sala" id="sala"  size="8"   value="<?php echo $sala;?>" readonly="readonly" />             
                        </span>
                        <!--  Final do salatipo  -->
                        </td>                  
                     <?php                      
                  }   
                  ///
               }  ///  FINAL  - IF  UNIDADE
               ?>
	    </tr>	
		</table>
		</td>
		</tr>

      <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td  class="td_inicio1" style="border: 1px solid #000000; text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	     <table style="border: none; text-align: left;margin: 0px; padding: 0px;"  >
		   <tr style="border: none;" >
          <!--  EMAIL -->
	       <td  class="td_inicio1" style="border: none; vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
              <label for="e_mail" style="vertical-align:bottom; padding-bottom: 1px;cursor: pointer;" title="E_MAIL"   >E_MAIL:&nbsp;</label>
			   <br /><br />
			  <input type="text" name="e_mail" id="e_mail" size="60" value="<?php echo $e_mail;?>" />
               <!-- Final - EMAIL -->
			 </td>
        <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
          <!-- Telefone - digitar -->
           <label for="fone" style="vertical-align:bottom; padding-bottom: 1px;cursor: pointer;"  title="Telefone" >Telefone (dd)-fone:&nbsp;</label>
           <br /><br />
            <input type="text" name="fone"  id="fone"  size="26"  value="<?php echo $fone;?>" />
           <!-- Final - fone -->
             </td>     


	    <td  class="td_inicio1" style=" vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
		   <!-- RAMAL - digitar -->
           <label for="ramal" style="vertical-align:bottom; padding-bottom: 1px;cursor: pointer;"  title="Ramal" >Ramal:&nbsp;</label>
	       <br /><br />
	        <input type="text" name="ramal" id="ramal" size="12"   value="<?php echo $ramal;?>" />
			<!-- Final - ramal -->
               <!-- PA do Orientador -->
               <input type="hidden"  name="pa" id="pa" value="<?php echo $pa;?>" />
               <!-- Final do pa do Orientador -->
               <input type="hidden" name="activation_code" id="activation_code"  value="<?php echo $_SESSION['activation_code'];?>"  />
               <input type="hidden" name="datacad" id="datacad" value="<?php echo $_SESSION['datacad'];?>"  />
               <input type="hidden" name="datavalido" id="datavalido" value="<?php echo $_SESSION['datavalido'];?>"  />
             </td>     
            </tr>
          </table>
		  </td>
		  </tr>  

           <!--  TAGS  Type Reset e  Submit  --> 
           <tr align="center" style="border: none; vertical-align:top; line-height: 0px;" >
             <td colspan="<?php echo $_SESSION["cols"];?>" style="border: 1px solid #000000; padding: 1px; text-align:center; line-height:0px;" align="CENTER" nowrap >
			  <table border="0" cellpadding="0" cellspacing="0" align="center" style=" border: none; width: 100%; line-height: 0px; margin:0px; padding: 2px 0 2px 0; vertical-align: top; " >            
			    <tr style="border: none;">
                <td  align="right" nowrap style="padding-top: 2px; vertical-align: middle; width: 40%;  text-align: right; border:none;" >
                <span class="td_inicio1" style=" vertical-align: middle; text-align: right; color: #000000;" >Conceder permiss&atilde;o:&nbsp;</span>
                </td>
                <td  nowrap style="width: 10%;  padding-left: 10px; vertical-align: middle; text-align: left; border:none;" >
                <!-- SIM -->                  
               <button  type="submit" name="sim" id="sim" class="botao3d"  style="cursor: pointer; "  title="Sim"  acesskey="S" alt="Sim"  onclick="javascript: ativando_dados('submeter','orientador_novo#sim',document.form1); return false; "    >    
                 Sim&nbsp;&nbsp;<img src="imagens/enviar.gif" alt="Sim"  style="vertical-align:text-bottom;"  >
             </button>
              <!-- Final - SIM -->
              </td>
              <td     nowrap style="padding-left: 0px; vertical-align: middle; text-align: left; border: none; " >
                <!-- NAO -->                  
			   <button type="submit" name="nao" id="nao"  class="botao3d" style="cursor: pointer;" title="N?o" acesskey="N" alt="N?o"  onclick="javascript: ativando_dados('submeter','orientador_novo#nao',document.form1); return false;" >Não&nbsp;&nbsp;<img src="imagens/limpar.gif" alt="N?o" style="vertical-align:text-bottom;" >
               </button>
               <!-- Final - NAO -->
		      </td>
			   </tr>
              <!--  FINAL - ids  sim e  nao  -->
			  </table>
			  </td>
            </tr>
         </table>
</form>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
</div>
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
