<?php 
/*   REXP - REMOVER ANOTA??O DE PROJETO
*   
*   REQUISITO: O Usuário deve ter PA>0 e PA<=50 
* 
*   LAFB&SPFB110908.1629
*/
//  ==============================================================================================
//  ATENCAO: SENDO EDITADO POR LAFB  - REMOVER ANOTACAO
//  ==============================================================================================
//
/// Dica: #*funciona?*# Se o que quer e´ apenas forcar uma visualizacao  direta no navegador use
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
///   Caso recebendo o Projeto para remover a Anotacao
////  if( ! isset($_SESSION["anotacao_cip_altexc"]) ) $_SESSION["anotacao_cip_altexc"]="";
///
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="LAFB/SPFB" />
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="pragma"  content="no-cache">
<meta name="robots" content="none"> 
<meta http-equiv="Expires" content="-1" >
<meta name="gooblebot" content="noarchive"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REXP - Remover Anotação</title>
<script type="text/javascript"  language="javascript"   src="<?php echo $host_pasta;?>includes/dochange.php" ></script>
<!--  <link type="text/css" href="<?php echo $host_pasta;?>css/estilo.css" rel="stylesheet"  />  -->
<link type="text/css" href="<?php echo $host_pasta;?>css/<?php echo $estilocss;?>" rel="stylesheet" />
<script  type="text/javascript" src="<?php echo $host_pasta;?>js/XHConn.js" ></script>
<script type="text/javascript"  src="<?php echo $host_pasta;?>js/functions.js" charset="utf-8"  ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/responsiveslides.min.js" ></script>
<script type="text/javascript" src="<?php echo $host_pasta;?>js/resize.js" ></script>
<script  language="javascript"  type="text/javascript"  charset="utf-8" >
///
///   JavaScript Document
///
/****  
    Define o caminho HTTP  -  20180403
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
charset="utf-8";
///
///  variavel quando ocorrer Erros
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
///
///   function  acentuarAlerts - para corrigir acentuacao
///  Criando a function  acentuarAlerts(mensagem)
function acentuarAlerts(mensagem) {
    ///  Paulo Tolentino
    ///  Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));
    ///
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
/*************  Final  -- function acentuarAlerts(mensagem)   ************/
///
///  Verifica se foi selecionado o Projeto
function ativar(projeto_selec) {
    /// Verificando parametro projeto_selec
    if( typeof(projeto_selec)=='undefined' ) var projeto_selec="";
    projeto_selec = trim(projeto_selec);
    /**
    if( document.getElementById("div_out") )  {
         document.getElementById("div_out").innerHTML="";
         document.getElementById("div_out").style.display="none";      
    }
     ***/
    ///  Ocultando ID  e utilizando na tag input comando onkeypress
    exoc("div_out",0);  
    ///
    if( document.getElementById("div_form") ) {
        if( document.getElementById("div_form").style.display="none" ) {
             document.getElementById("div_form").style.display="block";                    
        }     
    } 
    ///
    ////  Ativando ID id_anotacao - caso exista
    if( document.getElementById("id_anotacao") ) {
        if( document.getElementById("id_anotacao").style.display="none" ) {
            document.getElementById("id_anotacao").style.display="block";   
        }     
         /// Caso exista ID ordernar - Ativar
         if( document.getElementById("ordenar") ) {
             if( document.getElementById("ordenar").style.display="none" ) {
                 document.getElementById("ordenar").style.display="block";   
             }     
         }
         ///  
    }
     ///
}
/****************  FINAL -  function  ativar(projeto_selec)  *************************/
///
///   Remover Anotacao        
function remove_anotacao(idselecproj, idopcao,string_array) {
//
//  Selecionar as ANOTACOES DE PROJETOS de acordo com a op??o (todos ou pelo campo desejado)
//
//  LAFB/SPFB110831.1127
//  LAFB/SPFB110909.0917
//
//  Parametros:
//      idselecproj = Identifica??o do Select de escolha do projeto
//      idopcao     = Identifica??o da Op??o de sele??o das Anota??es (TODOS, select (ano_incio, ano_final, anota??o)
//
//  Prepara os par?metros para ativação do srv_php
//  Determina qual opcao do Select <idselecproj> foi selecionada:
    /// Verificando se a function exoc existe 
    if(typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
    ///
    var poststr="";
    ///  Verificando variaveis
    if( typeof(idselecproj)=="undefined" ) var tcopcao=""; 
    if( typeof(idopcao)=="undefined" ) var val=""; 
    if( typeof(string_array)=="undefined" ) var string_array=""; 
    
    /// Verificando variavel string_array existe
    if(typeof string_array=="undefined") {
           var string_array="";
    }
         
    /// Verifica se a variavel e uma string    
    var nr_anotacao=0;
    if( typeof(string_array)=='string' ) {
           ///  src = trim(string_array);
           ///  string.replace - Melhor forma para eliminiar espacos no comeco e 
           ///                   final da String/Variavel
           var string_array = string_array.replace(/^\s+|\s+$/g,"");        
           var string_array_maiusc = string_array.toUpperCase();     
           var pos = string_array.indexOf("#@=");   
           if( pos!=-1 ) {  
               ///  Criando um Array 
               var array_string_array = string_array.split("#@=");
               if(array_string_array.length==4) {
                   /// cip = codigo da ident. do Projeto
                   var  op_projcod=array_string_array[2];  
                   ///  Numero da anotacao do Projeto
                   var  nr_anotacao=array_string_array[3];  
               } 
               /*   var teste_cadastro = array_string_array[1];
                    var  pos = teste_cadastro.search("incluid");
               */
           }
    }  else if( typeof(string_array)=='number' && isFinite(string_array) )  {
           var string_array = string_array.value;                
    } else if(string_array instanceof Array) {
          ///  esse elemento definido como Array
    }
    /*  document.getElementById("label_msg_erro").innerHTML="";
        document.getElementById('label_msg_erro').style.display="none";  
    */
    var opcao=idselecproj.toUpperCase();    
    /****  
             Define o caminho HTTP  -  20180612
     ***/  
     var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
     var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       
    
/// alert(" arq anotacao_remover.php/296 --->>  idselecproj = "+idselecproj+" -  idopcao = "+idopcao+"  --  opcao = "+opcao+" - string_array = "+string_array);
 
    /// tag Select para desativar o campo Select ordenar
    var quantidade=idselecproj.search(/BUSCA_PROJ|busca_porcpo/i);
    if( quantidade!=-1 ) {
         ///  Caso idopcao estiver  nula
         if( idopcao.length<1 ) {
              ///  Retornar na pagina - reset 
              location.href=pagina_local;
              return;
         }
         /// Limpando o cabecalho da pagina  
         if( document.getElementById("label_msg_erro") ) {
              document.getElementById("label_msg_erro").style.display="block";
              document.getElementById("label_msg_erro").innerHTML="";
         }    
         ///
         if( document.getElementById("ordenar") ) {
              document.getElementById("ordenar").selectedIndex="0";
              document.getElementById("ordenar").style.display="none";            
         }  
    }    
    ///
    /// BOTAO - TODAS ANOTACOES
    if( idselecproj.toUpperCase()=="TODAS" ) {
        var lcopcao = idopcao.toUpperCase();
        var quantidade= lcopcao.search(/TODOS|TODAS/i);
        if( quantidade!=-1 ) {
            if( document.getElementById("ordenar") ) {
                 document.getElementById("ordenar").style.display="block";            
            } else {
                 alert("Faltando document.getElementById(\"ordenar\") ");           
            }
            ///
            return;
        }
    }
    /// 
    ///  if( idselecproj!="DESCARREGAR" &&  idselecproj!="DETALHES" ) {
    var buscar=idselecproj.search(/DESCARREGAR|DETALHES|BUSCA_PROJ|Ordenar/i);       
    ///  Caso NAO encontrou nenhum dos tres nomes 
    if( buscar==-1 ) {
        if( typeof(idopcao)=='undefined' ) var op_selanot="";
        if( typeof(idopcao)!='undefined' ) var op_selanot=idopcao.toUpperCase();
        if( op_selanot=="TODOS" ){
            var op_selcpoid = "";
            var op_selcpoval = "";
            var doc_elemto = document.getElementById(idselecproj);    
            var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
            var op_projcod = op_selecionada.value;
            var op_projdesc = op_selecionada.text;
       }
       /***
        else {
            var doc_elemto = document.getElementById(idopcao);    
            var op_selecionada = doc_elemto.options[doc_elemto.options.selectedIndex];
            var op_selcpoid = op_selecionada.text;
            var op_selcpoval = op_selecionada.value;
       }   
       ***/     
    }    
    /// 
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
                   ///  document.getElementById("msg_erro").innerHTML=msg_erro;    
                   document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                   document.getElementById(idopcao).focus();                   
                   return false;                   
               }
         }
         var poststr = "source="+encodeURIComponent(source)+"&idopcao="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
         ///
     } else if( opcao!="DESCARREGAR"  ) {
         var op_selanot = idopcao.toUpperCase();
         if( op_selanot=="TODOS" ){
              ///  var op_projcod = "";
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
     }    
     ///
    /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca - AJAX   */
    if( !myConn ) {
        var msgtxt=acentuarAlerts("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor."); 
        ////  alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
         alert(msgtxt);
         return false;
    }
    ///
    ///  Verifica qual Navegador sendo usado
    var m_isChrome=isChrome().toString();
    var m_isInternetExplorer=isInternetExplorer();

    /// Define o procedimento para processamento dos resultados dp srv_php
    var inclusao = function (oXML) { 
          ///  Recebendo o resultado do php/ajax
          var srv_ret = trim(oXML.responseText);
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);
          ///

          /***
  alert("anotacao_remover.php/410  --->  1) -- lnip = "+lnip+"  -->>  idselecproj = "+idselecproj+"  <<-- idopcao = "+idopcao+"  -- opcao = "+opcao+" \r\n  -  Recebendo resultado do srv_mostraanot="+srv_ret);   
  ***/       

         ///  Caso ocorreu erro
         if( parseInt(lnip)!=-1 ) {
              /*   Caso receber esses dados - centro da pagina:
                   Nenhuma Anota&ccedil;&atilde;o desse Projeto 
                   IMPORTANTE: javascript regular expression                             
              */
             /// if( m_dados_recebidos.search(/Nenhuma/i)==-1  ) {
              if( srv_ret.search(/Nenhuma\s{1,}([A-Za-z&;$#@()*%!]+)\s{1,}desse\s{1,}projeto/i)==-1  ) {    
                  ///  Ativando ID mensagem de erro
                  exoc("label_msg_erro",1,srv_ret);
                  return;                   
              }
         }
         ///  Caso NAO encontrou nem:  Nenhum|ERRO:
         if( lnip==-1 ) {

///   alert("anotacao_remover.php/405   --->>   2)  --- opcao = "+opcao+"  --- idopcao = "+idopcao+"  -- lnip = "+lnip+" - \r\n  Recebendo resultado do srv_mostraanot="+srv_ret);          
              
             if( opcao=="DESCARREGAR" ) {
                  var msgtxt=acentuarAlerts("\r\nCaso o Internet Explorer bloqueie o download, faça o seguinte:\r\n\r\n Opção - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Opções do Internet Explorer e clique na aba Segurança.\r\n 2 - Clique no botão Nível Personalizado e dentro de Configurações de Segurança, localize o recurso Downloads \r\n3 - Em: Aviso automático para downloads de arquivo e selecione Habilitar");    
                  alert(msgtxt);
                  srv_ret = trim(srv_ret);
                  var array_arq = srv_ret.split("%");
                ////  self.location.href="../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                  self.location.href=raiz_central+"includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                  ///
             }  else if( opcao=="BUSCA_PROJ" ) {
                        ///  Ativando function ativar
                       ativar(srv_ret);
             } else if( opcao.search(/Ordenar/i)!=-1 ) {
                       ///  Mostrar Anotacoes 
                      ///  Ativando ID div_out - enviando dados
                       exoc("div_out",1,srv_ret);           
                      ///          
             } else if( idopcao=="TODOS" ) {
                 
 ///   alert("anotacao_remover.php  --  LINHA/339   --->> opcao = "+opcao+"  --- idopcao = "+idopcao+"  -- lnip = "+lnip+" - \r\n  Recebendo resultado do srv_mostraanot="+srv_ret);                           
                   /***
                   if( document.getElementById('div_form') ) {
                        document.getElementById('div_form').style.display="block";
                        document.getElementById('div_form').innerHTML=srv_ret;                                         
                   }
                   ***/
                   /// Enviando dados para ID id_out - ativar
                  if( document.getElementById('div_out') ) {
                        document.getElementById('div_out').style.display="block";
                        document.getElementById('div_out').innerHTML=srv_ret;                                         
                   }
                  //// exoc("div_out",1,srv_ret);   
                   return;
             }  else if( opcao=="REMOVER" ) {     
                 ///
                   var  myArguments = string_array; 
                    ///  Navegador Google Chrome
                   if( m_isChrome ) {
                           ///   Verificando erro/falha
                           var pos = srv_ret.search(/NENHUM|ERRO:/i);                           
                           if( pos!=-1 ) {                                            
                               alert(srv_ret);
                           }  else {
                                /// Verificando ID div_form - Ocultar 
                                /***
                                if( document.getElementById("div_form") ) {
                                    if(document.getElementById('div_form').style.display="block") {
                                       document.getElementById('div_form').style.display="none"; 
                                    }
                                }  
                                 ***/
                                 exoc("div_form",1,srv_ret);           
                                 ///
                           }
                           return;
                   } else if(m_isInternetExplorer) {
                         ///
                     ///   var showmodal=window.showModalDialog("../includes/myArguments_remover_anotacao.php",myArguments,"dialogWidth:920px;dialogHeight:480px;resizable:no;status:no;center:yes;help:no;");  
                        var showmodal=window.showModalDialog(raiz_central+"includes/myArguments_remover_anotacao.php",myArguments,"dialogWidth:920px;dialogHeight:480px;resizable:no;status:no;center:yes;help:no;");                       
                        var pos = showmodal.search(/NENHUM|ERRO:/i);
                        ///
                   } else {
                        alert("Usar Navegador Google Chrome ou Internet Explorer");
                        return
                   }
                   if( pos!=-1 ) {
                        var pos = srv_ret.search(/APROVADO|NAOAPROVADO/);
                        if( pos!=-1 ) {                                            
                              var array_modal = showmodal.split("#");
                              if( document.getElementById('div_form')  ) {
                                     document.getElementById('div_form').style.display="block";
                                     if( document.getElementById('id_body')  ) {
                                          document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                     }    
                                     ///  document.getElementById('div_form').innerHTML=array_modal[0];
                                     document.getElementById('div_form').innerHTML=showmodal;
                              }                                                                                           
                        }
                    } else if( pos==-1 ) {
                        if( showmodal=="excluido" ) {        
                             /***  IMPORTANTE: essa function acentuarAlerts
                                     para acentuacao
                             ***/
                             var mensagem=acentuarAlerts("Anotação excluída. Verificar.");
                             alert(mensagem);
                             document.location.reload(true);  
                             ///
                        }
                    }
                    /// 
             }  else if( opcao.toUpperCase()=="ANOTACAO" &&  idopcao.toUpperCase()=="EXCLUINDO"  ) {            ///                
                    //// Recebendo a mensagem do arquivo srv_rmanotacao.php - sobre excluir ANOTACAO
                    ///  alert("Anotação removida.");
                    /***  IMPORTANTE: essa function acentuarAlerts
                            para acentuacao
                    ***/
                    ////  var mensagem=acentuarAlerts("Anotação removida."+srv_ret);
                    var mensagem=acentuarAlerts(srv_ret);
                    alert(mensagem);
                    ///               
                    location.reload();
                    return;
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
                 /// Separando a mensagem recebida
                 var pos1 = srv_ret.search(/INICIA/i);
                 var pos2 = srv_ret.search(/FINAL/i);
                 if( pos1!=-1 && pos1!=-2  ) {
                       srv_ret = srv_ret.replace(/ERRO:|CORRIGIR_ERRO:|INICIA|FINAL/ig,"");                      
                 }
                /*                                                             
                if( document.getElementById('div_form')) {
                    document.getElementById('div_form').style.display="none";  
                } 
                document.getElementById('label_msg_erro').style.display="block";
                document.getElementById('label_msg_erro').innerHTML=srv_ret;
                */
                /// Mensagem de erro ID label_msg_erro - ativar
                exoc("label_msg_erro",1,srv_ret);   
           }; 
           return;
    };
    ///   Define o servidor PHP para remover 
    ///    do banco de dados - anotacao do projeto desejado
    var srv_php = "srv_rmanotacao.php";
    var poststr = new String("");
        /// if( idselecproj.toUpperCase()=="DESCARREGAR" || idselecproj.toUpperCase()=="DETALHES" ) {
    var encontrado=idselecproj.search(/DESCARREGAR|DETALHES|BUSCA_PROJ|ordenar/i);    
     ///  Caso encontrou um dos tres nomes 
    if( encontrado!=-1 ) {
           var browser="";
           if( typeof navegador=="function" ) {
                  var browser=navegador();
           }  
           ///
           var poststr = "grupoanot="+encodeURIComponent(idselecproj)+"&val="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array)+"&navegador="+browser; 
    } else {
        ///  DESCARREGAR - UPLOAD abrindo o arquivo pdf
        if( opcao=="DESCARREGAR"  ) {
            var poststr = "grupoanot="+encodeURIComponent(opcao)+"&idopcao="+encodeURIComponent(idopcao)+"&m_array="+encodeURIComponent(string_array); 
        }  else {
             ///  Caso opcao REMOVER e o navegador for Google Chrome
             if( (opcao.toUpperCase()=="REMOVER") && m_isChrome )  {
                    var poststr = "idopcao="+encodeURIComponent(opcao)+"&cip="+encodeURIComponent(op_projcod)+"&grupoanot="+encodeURIComponent(op_selanot)+"&op_selcpoid="
                          +encodeURIComponent(string_array)+"&nr_anotacao="+nr_anotacao;
                     ///   
             } else if( opcao.toUpperCase()=="ANOTACAO" &&  idopcao.toUpperCase()=="EXCLUINDO" ) { 
                    /*
                         ETAPA PARA REMOVER A ANOTACAO DE UM PROJETO NO ARQ. srv_rmanotacao.php 
                         utilizando a function para_confirm do arquivo functions.js
                     */    
                     var remover = para_confirm("Remover tem certeza?");
                     if( remover ) {
                           //  Iniciando excclusao da Anotacao escolhida
                           var poststr = "idopcao="+encodeURIComponent(idopcao)+"&op_selcpoval="+encodeURIComponent(opcao)+"&cia="+encodeURIComponent(string_array);                     
                     } else {
                          //  Cancelado
                          location.reload();
                          return;
                     }
                    ///   poststr +="source=EXCLUIR&val="+m_val;           
             } else {
                  var poststr = "cip="+encodeURIComponent(op_projcod)+"&grupoanot="+encodeURIComponent(op_selanot)+"&op_selcpoid="
                            +encodeURIComponent(string_array) ;           
             }    
        }
    }   
    ///
     /* 
         aqui ? enviado mesmo para pagina receber.php 
         usando metodo post, + as variaveis, valores e a funcao   */
     var conectando_dados = myConn.connect(srv_php, "POST", poststr, inclusao);   
     /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho            */
}
/*********   Final -function remove_anotacao(idselecproj, idopcao,string_array)   **********/
///
</script>
</head>
<body  id="id_body"  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false" onkeydown="javascript: no_backspace(event);"  onload="javascript: consulta_alteraranot('TESTEAANDOAPENAS');"   >
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
<div  id="corpo"  >
<?php 
///     Alterado em 20170925  - MENU 
require("{$_SESSION["incluir_arq"]}includes/domenu.php");

////     CONSULTAR  Anotacao
if( isset($_GET["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_GET["m_titulo"];    
} elseif( isset($_POST["m_titulo"]) ) {
   $_SESSION["m_titulo"]=$_POST["m_titulo"];      
}
///  Definindo TITULO da pagina
$_SESSION["m_titulo"]="Anota&ccedil;&atilde;o";
////        
?>
<!--  Mensagem de ERRO e Titulo    -->
<section class="merro_e_titulo" >
<div  id="label_msg_erro" >
</div>
<p class="titulo_usp" >Remover&nbsp;<?php echo ucfirst($_SESSION["m_titulo"]);?></p>
</section>
<!-- Final - Mensagem de ERRO e Titulo    -->
<?php
//     Verificano o PA - Privilegio de Acesso
//  INVES de superusuario e?  super
//  if( ( $permit_pa>$array_pa['superusuario']  and $permit_pa<=$permit_anotador ) ) {    
if( ( $permit_pa>$array_pa['super']  and $permit_pa<=$permit_anotador ) ) {    
?>
<div id="div_form" class="div_form" style="overflow:auto;" >
<div style="padding-top: .5em;text-align: center;background-color: #FFFFFF;" >
<p class="titulo_usp" style="text-align: center; width:100%;font-size:medium;font-weight: bold;" >Selecione o Projeto:&nbsp;
</p>
</div>
<?php 
/// Selecionando o Projeto do Orientador/Usuario
# Aqui está o segredo
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
///
if ($permit_pa<=$permit_orientador) {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." a.codigousp=".$usuario_conectado." order by b.titulo ";
} else {
    $sqlcmd = "SELECT a.codigousp,a.nome,b.cip,b.fonterec,b.fonteprojid,b.numprojeto,b.titulo,"
        ."b.anotacao FROM $bd_1.pessoa a, $bd_2.projeto b where a.codigousp=b.autor and "
        ." b.cip in (select distinct cip from $bd_2.anotador "
        ." where codigo=".$usuario_conectado.")  order by b.titulo ";
}
$result = mysql_query($sqlcmd); 
///  Verificando se houve erro no Select/MySql                  
if( ! $result ) {
    //  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
    /* $msg_erro .= "Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} - db/mysql:&nbsp; ".mysql_error();
    echo $msg_erro.$msg_final;  */            
    //  Parte do Class                
    echo $funcoes->mostra_msg_erro("Selecionando os Projetos autorizados para esse {$_SESSION["usuario_pa_nome"]} - db/mysql:&nbsp; ".mysql_error());
    exit();                  
}
///  Numero de Projetos Selecionados
$_SESSION["nprojetos"] = $nprojetos = mysql_num_rows($result);
///
if( intval($_SESSION["nprojetos"])>0 ) {
    ///  SESSION do Projeto Selecionado para alterar ANotacao
    if( isset($_SESSION["anotacao_cip_altexc"]) ) {
         $cip_anotacao_escolhida = $_SESSION["anotacao_cip_altexc"];
         
         if( strlen(trim($cip_anotacao_escolhida))>0 ) {
                ?>
                 <script  type="text/javascript">
                     /* <![CDATA[ */
                    remove_anotacao('REMOVER','<?php echo $cip_anotacao_escolhida;?>','<?php echo  $cip_anotacao_escolhida;?>');
                    /* ]]> */
                 </script>
              <?php
         }
         ///       
    }
    ///
}
///
?>
<div class="div_select_busca"  >
<select name="busca_proj" id="busca_proj" class="Busca_letrai" title="Selecione o Projeto para Busca de Anota&ccedil;&otilde;es"  onchange="javascript: remove_anotacao(this.id,this.value,'<?php echo $usuario_conectado;?>')"  >
    <!-- Identificacao do Projeto [Fonte][ProcessoNo.][ - Titulo] -->
    <?php 
        /// Verifica se NAO tem projeto  ou 
        if( intval($nprojetos)<1 ) {
              echo "<option value='' >N&atilde;o existe Projeto vinculado a esse {$_SESSION["usuario_pa_nome"]}.</option>";
        } else {
              echo "<option value='' >Selecione o Projeto a ser acessado por esse {$_SESSION["usuario_pa_nome"]} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>";
              ////
              while( $linha=mysql_fetch_assoc($result) ) {
                    $_SESSION["cip"]= (int) $linha['cip'];
                    $_SESSION["anotacao_numero"]=$linha['anotacao']+1;
                    $autor_nome = $linha['nome'];
                    /*  Desativado por nao ter valores nos campos fonterec e fonteprojid
                    $titulo_projeto = htmlentities($linha['fonterec'])."/".ucfirst(htmlentities($linha['fonteprojid']))
                                      .": ".$linha['titulo'];   */
                    $fonterec=htmlentities($linha['fonterec']);
                    $fonteprojid=  ucfirst(htmlentities($linha['fonteprojid']));         
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
                              //  $projeto_titulo_parte .="<span style='font-weight: bold;font-size: large;' >...</span>";
                                break;
                           }
                     }
                     ///  Definindo o Titulo do Projeto
                     $titulo_projeto="";
                     if( strlen(trim($fonterec))>=1  ) {
                           $titulo_projeto.= $fonterec."/";
                     }
                     if( strlen(trim($fonteprojid))>=1  ) {
                          $titulo_projeto.= $fonteprojid.": ";
                     }
                     $titulo_projeto .= trim($projeto_titulo_parte);                    
                    ///  Usando esse option para incluir espaco sobre linhas
                    ///  echo  "<option value='' disabled ></option>";                  
                    /*
                    echo "<option  value=".$linha['cip']."  title='Orientador do Projeto: $autor_nome' >"
                           .utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";   
                    */            
                    $selected_projeto="";
                    ///   Caso recebendo o Projeto para remover a Anotacao
                    if( ! isset($_SESSION["anotacao_cip_altexc"]) ) $_SESSION["anotacao_cip_altexc"]="";
                    if( isset($_SESSION["anotacao_cip_altexc"]) ) {
                         $cip_escolhido=$_SESSION["anotacao_cip_altexc"];
                         if( intval($cip_escolhido)==intval($_SESSION["cip"]) ) {
                               $selected_projeto="selected='selected'";   
                         }
                    }                                   

                    echo "<option  value=".$linha['cip']."  $selected_projeto title='Orientador do Projeto: $autor_nome' >";
                    /* IMPORTANTE: Detectar codificacao  de caracteres  - 20171005   */
                    $codigo_caracter=mb_detect_encoding($titulo_projeto);
                  /// if( trim(strtoupper($codigo_caracter))!="UTF8" ) {
                       ////   echo utf8_decode(htmlentities($titulo_projeto))."&nbsp;&nbsp;</option>";
                        ///     echo  htmlentities("$titulo_projeto")."&nbsp;&nbsp;</option>";
                         ///    echo  $titulo_projeto."&nbsp;&nbsp;</option>";
                          ///  echo utf8_decode($titulo_projeto)."&nbsp;&nbsp;</option>";
                            echo  $titulo_projeto."&nbsp;&nbsp;</option>";                                  
                         /***
                    } else {
                        echo  $titulo_projeto."&nbsp;&nbsp;</option>";                                  
                    }
                    ***/
                    ////    
              }
        }
        ?>
        </select>
</div>
<?php
///   Conectar - CODIGO/USP
///  $elemento=5; $elemento2=6;
///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
//
//  Selecionar as anota??es de projeto pelo campo desejado
$opcao_cpos = Array("ano_inicio","ano_final","anotacao") ;
$opcao_ncpos = count($opcao_cpos);                
//
///  Salvar letrais iniciais em um conjunto para facilitar a busca
///  $m_anotacoes=utf8_decode("Anotações");
$m_anotacoes="Anotações";
///
?>
<div id="id_anotacao" style="display: none;text-align: center;" >
<p class="titulo_usp" >
Mostrar&nbsp;Anota&ccedil;&otilde;es&nbsp;</p>
<div align="center" style="padding-top:0px; padding-bottom: 5px;margin-left: 40%;margin-right: 40%;" >
 <!-- tag Select para ordenar  -->
<select  title="Ordernar"  id="ordenar"  class="ordenar"   onchange="javascript:  remove_anotacao('ordenar',busca_proj.value,this.value)"  >
<option  value=""  >Ordenar por</option>
<option  value="data asc"  >Data - asc</option>
<option  value="data desc"  >Data - desc</option>
<option  value="titulo asc"  >Título - asc</option>
<option  value="titulo desc"  >Título - desc</option>
</select>
<!--  Final - tag Select para ordenar  -->
</div>   
<p class="titulo_usp" >Lista de Anota&ccedil;&otilde;es desse Projeto</p>
<?php
} else {
   echo  "<p  class='titulo_usp' >Usu&aacute;rio n&atilde;o autorizado</p>";
}
?>
<div  style="position:relative;  display:flex; ">
<!-- id div_out  -->
<section style="float: left;width:100%;" >
<article id="div_out" style="width:100%; overflow: auto; ">
</article>
<!-- Final - id div_out  -->
<!--  ID - Anotacao escolhida -->
<article  id="anotacao_escolhida" >
</article>
</section>
<!-- Final - Anotacao escolhida -->
</div>
</div>
<!-- Final - id id_anotacao -->
</div>
<!-- Final div_form  -->
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape"  >
<?php include_once("{$incluir_arq}includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
