<?php 
/*   REXP - REMOVER ANOTA??O DE PROJETO
*   
*   REQUISITO: O Usuário deve ter PA>0 e PA<=50 
* 
*   LAFB&SPFB110908.1629
*/
///  ==============================================================================================
///  ATENCAO: SENDO EDITADO POR LAFB - ANOTACAO REMOVER - ANOTADOR
///  ==============================================================================================
///
/// Dica: #*funciona?*# Se o que quer ? apenas for?ar uma visualiza??o direta no navegador use
/// header("Content-Disposition: inline; filename=\"nome_arquivo.pdf\";"); 
///
///  Verificando se session_start - ativado ou desativado
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
///
if( isset($_SESSION["permit_pa"]) ) $permit_pa = $_SESSION["permit_pa"];

echo "<p>anotacao_remover_nova/67  -- \$permit_pa = $permit_pa  </p>";


///
///  Titulo do Cabecalho - Topo
if( ! isset($_SESSION["titulo_cabecalho"]) ) $_SESSION["titulo_cabecalho"]=utf8_decode("Registro de Anotação");
/// $_SESSION['time_exec']=180000;
///
///  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
$funcoes=new funcoes();
$funcoes->usuario_pa_nome();
$_SESSION["usuario_pa_nome"]=$funcoes->usuario_pa_nome;
///
/***
*    Depois do arquivo inicia_conexao.php 
*      - definido Desktop ou Mobile (aplicativo movel)
*/
$estilocss = $_SESSION["estilocss"];
///
if( ! isset($_SESSION["anotacao_cip_altexc"]) ) $_SESSION["anotacao_cip_altexc"]="";
///
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="pt-br" />
<meta name="author" content="LAFB/SPFB" />
<META http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE"> 
<META HTTP-EQUIV="Expires" CONTENT="-1" >
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<META http-equiv="imagetoolbar" content="no">  
<title>Projeto</title>
<link  type="text/css"  href="../css/estilo.css" rel="stylesheet"  />
<link  type="text/css"   href="../css/style_titulo.css" rel="stylesheet"  />
<script  type="text/javascript" src="../js/XHConn.js" ></script>
<script type="text/javascript"  src="../js/functions.js" ></script>
<script  language="javascript"  type="text/javascript" src="../js/formata_data.js"></script>
<script  language="javascript"  type="text/javascript" >
<!--
function remove_anotacao(idselecproj, idopcao,string_array) {
//
//  Selecionar as ANOTA??ES DE PROJETOS de acordo com a op??o (todos ou pelo campo desejado)
//
//  LAFB/SPFB110831.1127
//  LAFB/SPFB110909.0917
//
//  Parametros:
//      idselecproj = Identifica??o do Select de escolha do projeto
//      idopcao     = Identifica??o da Op??o de sele??o das Anota??es (TODOS, select (ano_incio, ano_final, anota??o)
//
//  Prepara os par?metros para ativação do srv_php
// Determina qual op??o do Select <idselecproj> foi selecionada:
    // Verifica se a variavel e uma string
    if( typeof(idselecproj)=='string' ) {
        //  string.replace - Melhor forma para eliminiar espa?os no comeco e final da String/Variavel
        idselecproj = idselecproj.replace(/^\s+|\s+$/g,""); 
    }
    //
    var opcao=idselecproj.toUpperCase();    
    
//   alert("LINHA 78 - arq anotacao_remover_nova.php/86 -  idselecproj = "+idselecproj+"  --  opcao (Maisc) = "+opcao+" -  idopcao = "+idopcao+" - string_array = "+string_array)
  
    if( opcao=="CAMPOS_OBRIGATORIOS"  ) {
         if( idopcao.toUpperCase()=="CPF"  ) {
               var resultado = validarCPF(string_array,idopcao);    
               if( ! resultado ) {
                   var m_id_title = document.getElementById(idopcao).title;                   
                   document.getElementById("label_msg_erro").style.display="block";
                   var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                   msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                   var final_msg_erro = "&nbsp;</span></span>";
                   m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                   //  document.getElementById("msg_erro").innerHTML=msg_erro;    
                   document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                   document.getElementById(idopcao).focus();                   
                   return false;                   
               }
         }
         var poststr = "source="+encodeURIComponent(source)+"&idopcao="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
     } else if( opcao!="DESCARREGAR"  ) {
          if( opcao!="ANOTACAO_NOVA" ) {    
             var op_selanot = idopcao.toUpperCase();
             if ( op_selanot=="TODOS" ){
                 //  var op_projcod = "";
                 var op_projcod = "";
                 var op_selcpoid = "";
                 var op_selcpoval = "";
             } else {
                 if( document.getElementById(idopcao) ) {
                     var doc_elemto = document.getElementById(idopcao);    
                     var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
                     var op_selcpoid = op_selecionada.text;
                     var op_selcpoval = op_selecionada.value;                 
                 }
             }
          } else {
             var op_selcpoid="";
             var op_selcpoval="";
             if( idopcao.toUpperCase()=="PROJETO" ||  idopcao.toUpperCase()=="ANOTACAO"  ) {
                 var op_projcod = string_array;
                 var op_selanot="TODOS";
             }
          }             
     }    
    
     //  Verificando o campo da tag Select para escolher Projeto
    // if( document.getElementById("busca_proj")  ) {
    if( document.getElementById("busca_proj")  && opcao!="ANOTACAO_NOVA"   ) {
       var cpo_val = document.getElementById("busca_proj").value;
       var op_projcod = cpo_val;
       if( cpo_val=="" ) {
              //  ERRO
              var m_id_title="Selecione primeiro o Projeto";
              document.getElementById("label_msg_erro").style.display="block";
              document.getElementById("label_msg_erro").innerHTML="";
              var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
              msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
              var final_msg_erro = "&nbsp;</span></span>";
              var m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
              msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
              document.getElementById("label_msg_erro").innerHTML=msg_erro;    
              return false;
       } else {
             document.getElementById("label_msg_erro").style.display="none";    
       }
    }
    
    /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca - AJAX   */
    if ( !myConn ) {
          alert("XMLHTTP não dispon?vel. Tente um navegador mais novo ou melhor.");
          return false;
    }
    //
   // Define o procedimento para processamento dos resultados dp srv_php
    var inclusao = function (oXML) { 
          //   Limpando a linha dos erros e etc.... no Cabecalho   
          document.getElementById("label_msg_erro").innerHTML="";
          document.getElementById('label_msg_erro').style.display="none";
          //  Recebendo o resultado do php/ajax
          var srv_ret = trim(oXML.responseText);
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);

     
  alert(" arq.  anotacao_remover_nova.php/180 -  idselecproj = "+idselecproj+"  --  opcao (Maisc) = "+opcao+" -  idopcao = "+idopcao+" - lnip = "+lnip+" - string_array = "+string_array+" \r\n\r\n Recebendo resultado do srv_alteraranot="+srv_ret)
           
          if( lnip==-1 ) {
              //  Faz parte do arquivo  includes/anotacao_nova.php
              if( idselecproj.toUpperCase()=="ANOTACAO_NOVA"   ) {
                   var partes=srv_ret.split(",");
                  // if( partes[1]=="ANOTACAO" ) var partes0="DESCARREGAR";
                   
  ///    alert(" anotacao_remover_nova.php/183 -   \r\n idselecproj = "+idselecproj+"\r\n\r\n - --->    partes[0] = "+partes[0]+" - partes[1] = "+partes[1]+" - partes[2] = "+partes[2]+" \r\n\r\n Recebendo resultado do srv_alteraranot="+srv_ret)    
                   
                 //  alteraranotacao(partes0,partes[1],partes[2]);
                   //  consulta_alteraranot(partes[0],partes[1],partes[2]);
                 //  remove_anotacao(partes0,partes[1],partes[2]);
                   remove_anotacao(partes[0],partes[1],partes[2]);
                   return;
              } else if( opcao=="DESCARREGAR" ) {
                 alert("\r\nCaso o Internet Explorer bloqueie o download, fa?a o seguinte:\r\n\r\n Op??o - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Op??es do Internet Explorer e clique na aba Seguran?a.\r\n 2 - Clique no bot?o N?vel Personalizado e dentro de Configura??es de Seguran?a, localize o recurso Downloads \r\n3 - Em: Aviso autom?tico para downloads de arquivo e selecione Habilitar")
                 srv_ret = trim(srv_ret);
                 var array_arq = srv_ret.split("%");
                 self.location.href="../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
             } else if( idopcao=="TODOS" ) {
                 
    //   alert("LINHA 155 -> arq anotacao_remover.php -  opcao = "+opcao+" -  idopcao = "+idopcao+" - string_array = "+string_array+" - lnip = "+lnip)                               
                 
                   document.getElementById('label_msg_erro').style.display="none";
                   if( document.getElementById('div_form') ) {
                       document.getElementById('div_form').style.display="block";
                      document.getElementById('div_form').innerHTML=srv_ret;                                         
                   }
             }  else if( opcao=="REMOVER" ) {     
                 var  myArguments = string_array; 
                 var showmodal=window.showModalDialog("../includes/myArguments_remover_anotacao_nova.php",myArguments,"dialogWidth:920px;dialogHeight:480px;resizable:no;status:no;center:yes;help:no;");  
                 var pos = showmodal.search(/NENHUM|ERRO:/i);
               //  if( trim(showmodal) != null) {                                                                           
               //   if( showmodal != "undefined" ) {
                  if( pos != -1 ) {
                        var pos = srv_ret.search(/APROVADO|NAOAPROVADO/);
                        if( pos!=-1 ) {                                            
                              var array_modal = showmodal.split("#");
                              if( document.getElementById('div_form')  ) {
                                     document.getElementById('div_form').style.display="block";
                                     if( document.getElementById('id_body')  ) {
                                          document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                     }    
                                     //  document.getElementById('div_form').innerHTML=array_modal[0];
                                     document.getElementById('div_form').innerHTML=showmodal;
                              }                                                                                           
                        }
                  } else if( pos==-1 ) {
                        if( showmodal=="excluido" ) {        
                            alert("Anota??o exclu?da. Verificar.")                                                 
                        } else {
                            alert("Anota??o não foi exclu?da.")                                                 
                        }
                        var anotacao_cip_altexc ="<?php echo  $_SESSION["anotacao_cip_altexc"];?>";
                        if( typeof(anotacao_cip_altexc)!="undefined" ) { 
                            anotacao_cip_altexc=trim(anotacao_cip_altexc);
                           if( anotacao_cip_altexc.length>=1 )  {
                               //  ANOTACAO NOVA - 20121113
                               top.location.href="../includes/anotacao_nova.php?m_titulo=Anotações";      
                           } else {
                               document.location.reload(true);        
                           }                                                        
                        }                         
                  }      
             }  else {
                    if( opcao=="CAMPOS_OBRIGATORIOS"  ) {
                         var pos = m_dados_recebidos.search(/Nenhum|ERRO:/i);
                         if( trim(m_dados_recebidos)!="" && pos==-1 ) {
                               var myArguments = m_dados_recebidos;
                               if( document.getElementById('id_body')  ) {
                                    document.getElementById('id_body').setAttribute('style','background-color: #007FFF');
                               }    
                               var showmodal=window.showModalDialog("myArguments.php",myArguments,"dialogWidth:600px;dialogHeight:500px;resizable:no;status:no;center:yes;help:no;");  
                               if( showmodal != null) {                                                                           
                                 //  alert("LINHA 151 - cadastrar_auto.php  =  "+m_dados_recebidos)
                                   var pos = m_dados_recebidos.search(/APROVADO|NAOAPROVADO/);
                                   if( pos!=-1 ) {                                            
                                       var array_modal = showmodal.split("#");
                                       if( document.getElementById('div_form')  ) {
                                           document.getElementById('div_form').style.display="block";
                                           if( document.getElementById('id_body')  ) {
                                                document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                           }    
                                           //  document.getElementById('div_form').innerHTML=array_modal[0];
                                           document.getElementById('div_form').innerHTML=showmodal;
                                       }
                                   }                                        
                               }       
                         } else if(pos!=-1 ) {
                              document.getElementById('label_msg_erro').style.display="block";
                              document.getElementById('label_msg_erro').innerHTML=srv_ret;
                         }                                         
                          //                             
                    } else {
                          document.getElementById('label_msg_erro').style.display="block";    
                          document.getElementById('div_out').innerHTML=srv_ret;
                    }       
             }
          } else {
              //
             // if( opcao=="TODOS"  || opcao=="BUSCA_PROJ" )  {
                   // Separando a mensagem recebida
                   var pos1 = srv_ret.search(/INICIA/i);
                   var pos2 = srv_ret.search(/FINAL/i);
                   if( pos1!=-1 && pos1!=-2  ) {
                       srv_ret = srv_ret.replace(/ERRO:|CORRIGIR_ERRO:|INICIA|FINAL/ig,"");                      
                   }
             //  }
               //                                                             
               if( document.getElementById('div_form')) document.getElementById('div_form').style.display="none";
               document.getElementById('label_msg_erro').style.display="block";
               document.getElementById('label_msg_erro').innerHTML=srv_ret;
           }; 
    };
    //   Define o servidor PHP para remover 
    //    do banco de dados - anotacao do projeto desejado
    var srv_php = "srv_rmanot_nova.php";
    var poststr = new String("");
    //  DESCARREGAR - UPLOAD abrindo o arquivo pdf
    if( opcao=="DESCARREGAR"  ) {
        
 //  alert(" arq  anotacao_remover_nova.php/285  -- idselecproj =  "+idselecproj+" - idopcao = "+idopcao+"  -  string_array = "+string_array)   
           
         var poststr = "grupoanot="+encodeURIComponent(opcao)+"&idopcao="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
    }  else {
         if( idopcao.toUpperCase()=="ANOTACAO" ) {            
             var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
         }  else {      
           /* var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoanot="+encodeURIComponent(op_selanot)+"&op_selcpoid="
                +encodeURIComponent(op_selcpoid)+"&op_selcpoval=" +encodeURIComponent(op_selcpoval) ;
       */
            var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoanot="+encodeURIComponent(op_selanot)+"&op_selcpoid="
                +encodeURIComponent(string_array) ;
        }        
    }

// alert("Ativando srv_mostraanot com poststr="+poststr)
     /* 
         aqui ? enviado mesmo para pagina receber.php 
         usando metodo post, + as variaveis, valores e a funcao   */
     var conectando_dados = myConn.connect(srv_php, "POST", poststr, inclusao);   
     /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho            */
}
//  Verifica se foi selecionado o Projeto
function ativar(projeto_selec)  {
    projeto_selec = trim(projeto_selec);
    if( projeto_selec.length>0 ) {
        document.getElementById("label_msg_erro").style.display="none";    
        document.getElementById('id_anotacao').style.display="block";
    } else {
        document.getElementById("label_msg_erro").style.display="block";    
        document.getElementById('id_anotacao').style.display="none";       
    }      
}
-->
</script>
<?php
///  Alterado em 20171023
require("{$_SESSION["incluir_arq"]}includes/domenu.php");
///
?>
</head>
<body  id="id_body"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);"   >
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
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo"  >
<?php 
//  MENU
require_once("../includes/dochange.php");
//     CONSULTAR  Anotacao
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}  
//    
?>
<label  id="label_msg_erro" style="display:none; position: relative;width: 100%; text-align: center; overflow:hidden;" >
   <font  ></font>
</label>
<p class='titulo_usp' style="overflow:hidden;  " ><b>Remover&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></b></p>
<?php
//     Verificano o PA - Privilegio de Acesso
//  INVES de superusuario e?  super
//  if( ( $permit_pa>$array_pa['superusuario']  and $permit_pa<=$permit_anotador ) ) {    
if( ( $permit_pa>$array_pa['super']  and $permit_pa<=$permit_anotador ) ) {    
?>
<p class='titulo_usp' style='margin: 2px 0px 0px; padding: 2px 0px 0px; line-height:normal; ' ><b>Selecione o Projeto: </b>
<!--  <select name="busca_proj" id="busca_proj" title="Selecione o Projeto para Busca de Anota&ccedil;&otilde;es" onchange="javascript: ativar(this.value)"  >  -->
<select name="busca_proj" id="busca_proj" title="Selecione o Projeto para Busca de Anota&ccedil;&otilde;es" style=" padding: 3px 0 3px 0; "   onchange="javascript: remove_anotacao(this.value,'TODOS',<?php echo $usuario_conectado;?>)"  >
    <!-- Identifica??o do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
    <?php 
      //  SESSION do arquivo tabela_consulta_anotacao_nova.php
      if( isset($_SESSION["anotacao_cip_altexc"]) ) {
          if( strlen(trim($_SESSION["anotacao_cip_altexc"])) ) {
              $cip_escolhido = $_SESSION["anotacao_cip_altexc"];
              ?>
                <script  type="text/javascript">
                   /* <![CDATA[ */
                   remove_anotacao('anotacao_nova','projeto','<?php echo $cip_escolhido;?>');
                   /* ]]> */
                </script>
              <?php              
          }
      }
      //
      if ($permit_pa<=$permit_orientador) {
           $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
                ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
                ." a.codigousp=".$usuario_conectado." order by b.titulo ";
      } else {
           $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
                ."b.anotacao FROM pessoal.pessoa a, rexp.projeto b where a.codigousp=b.autor and "
                ." b.cip in (select distinct cip FROM $bd_2.anotador "
                ." where codigo=".$usuario_conectado.")  order by b.titulo ";
      }
      $result = mysql_query($sqlcmd); 
      //                  
      if( ! $result ) {
          // die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
          //  Parte do Class                
          echo $funcoes->mostra_msg_erro("Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} - db/mysql:&nbsp; ".mysql_error());
          exit();                  
      }
      //  Numero de Projetos Selecionados
      $nprojetos = mysql_num_rows($result);
      if ( $nprojetos<1 ) {
          /* $opcao_msg="N&atilde;o existe Projeto vinculado a esse Usu&aacute;rio.";
              <option value='' >$opcao_msg</option> */
          echo "<option value='' >N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.</option>";
      } else {
          echo "<option value='' >Selecione o Projeto&nbsp;</option>";
          while($linha=mysql_fetch_assoc($result)) {
              $_SESSION["cip"]=$linha['cip'];
              $_SESSION["anotacao_numero"]=$linha['anotacao']+1;
              $autor_nome = $linha['nome'];
             /*  Desativado por nao ter valores nos campos fonterec e fonteprojid
            $titulo_projeto = htmlentities($linha['fonterec'])."/".ucfirst(htmlentities($linha['fonteprojid']))
                              .": ".$linha['titulo'];   */
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
              $titulo_projeto .= trim($projeto_titulo_parte);                    
              //   Criando uma linha sem dados para separacao                  
              echo "<option value='' disabled ></option>";
              $selected_projeto="";
              if( isset($_SESSION["anotacao_cip_altexc"]) ) {
                  if( $cip_escolhido==$_SESSION["cip"] ) $selected_projeto="selected='selected'";
              }                                   
              echo "<option  value=".$linha['cip']."   $selected_projeto title='Orientador do Projeto: $autor_nome' >"
                          .$titulo_projeto."&nbsp;&nbsp;</option>";   
         }
         mysql_free_result($result); 
      }
      ?>
      </select>
</p>
<br />
<div id="div_form" style="width:100%; margin: 2px 0px 0px; overflow: hidden; height: 360px; ">
<?php
//  CODIGO/USP
$elemento=5; $elemento2=6;
include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
//
//  Selecionar as anota??es de projeto pelo campo desejado
$opcao_cpos = Array("ano_inicio","ano_final","anotacao") ;
$opcao_ncpos = count($opcao_cpos);                
//
//  Salvar letrais iniciais em um conjunto para facilitar a busca
?>
<div id="id_anotacao" style="display: none;" >
<p class='titulo_usp' style='margin: 0px; padding: 2px 0px 0px; line-height:normal; '  ><b>Mostrar: </b>
<input class='botao3d' type='button' value='Todas' title='Selecionar todas'  onclick='javascript: remove_anotacao("busca_proj", "TODOS")' >
<span class='titulo_usp' style='margin: 0px; padding: 0px; line-height:normal; '  ><b>ou pelo seguinte campo: </b></span>
<select name="busca_porcpo" id="busca_porcpo" title="Selecione Campo para Busca de Anota&ccedil;&atilde;o de Projeto&nbsp;" onchange="javascript: remove_anotacao('busca_proj',this.id);" >
<?php
    if ( $opcao_ncpos<1 ) {
        echo "<option value='' >Nenhum Campo Definido</option>";
    } else {
       echo  "<option value=''  >Selecione Campo para Consulta de Projetos</option>";
       for ($i=0; $i<$opcao_ncpos; $i++) {       
            //  htmlentities - corrige poss?veis falhas de acentua??o de code page
            $opcao_cpo= $opcao_cpos[$i];  
            echo "<option  value=".urlencode($opcao_cpo)."  "
                    ."  title='Selecione esse campo para Busca de Projeto'  >".$opcao_cpo."</option>" ;
       }
    }
?>   
</select>
</p>
<p class='titulo_usp' style='margin: 0px; padding: 2px 0px 0px; line-height:normal; '  ><b>Lista de Anota&ccedil;&otilde;es de Projeto</b></p>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
<div id="div_out" style="width:100%; overflow: scroll; height: 280px; ">
</div>
</div>
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