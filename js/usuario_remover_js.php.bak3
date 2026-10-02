<?php
/* 
     Verificando conexao  - PARA REMOVER USUARIO -  js
*/
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
//
?>
<script language="JavaScript" type="text/javascript">
////
///          JavaScript Document - 20180611
/****
           SCRIPT - PARA REMOVER USUARIO               
****/
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
///   Corrigindo acentuacao
///
function AlertAcentuar(mensagem) {
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
}
//********************************************************
///
/***      FUNCTION PARA REMOVER USUARIO         ***/
function remove_usuario(tcopcao,dados,string_array) {
/*
    Selecionar os Usuários de acordo com a op??o (todos ou pela primeira letra)

    LAFB/SPFB110831.1127
*/
    /// Verificando se a function exoc existe
    if(typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe");
    }
    ///
     ///  Verificando variaveis
    if( typeof(tcopcao)=="undefined" ) var tcopcao=""; 
    if( typeof(dados)=="undefined" ) var dados=""; 
    if( typeof(string_array)=="undefined" ) var string_array="";  
    var val=dados;
    /// tcopcao - letras maiusculas
    var lcopcao = tcopcao.toUpperCase();
    /****  
         Define o caminho HTTP    -  20180605
    ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       

    
///  alert("usuario_remover/118 --->>  tcopcao = "+tcopcao+"  ---  dados = "+dados+"  \r\n\r string_array = "+string_array);

     
     if( lcopcao=="REMOVER" ) {
         var marray = string_array.split("#@=");  
         var totarray = marray.length;
         if( parseInt(totarray)==3 ) {
             var codigo=marray[1];
             var nome=marray[2];
             var resposta = confirm("Remover esse usuário: Código/"+codigo+" - Nome/"+nome+"?\r\n( Sim/Ok ou Não/Cancel )\r\nObs.: Caso tenha Projetos serão removidos.");
             if( ! resposta ) { 
                 return;
             }       
             ////             
         }
         ///
     }
     ///
    /// BOTAO - TODOS
    var quantidade= lcopcao.search(/TODOS|TODAS/i);
    if( quantidade!=-1 ) {
        if( document.getElementById("ordenar") ) {
             document.getElementById("ordenar").style.display="block";            
        } else {
             alert("Faltando document.getElementById(\"ordenar\") ");           
        }
        if( document.getElementById("Busca_letrai") ) {
              document.getElementById("Busca_letrai").selectedIndex="0";
        } 
        ///  Desativando ID  div_out
        exoc("div_out",1,"");                   
        ///
        return;
    }
    /// tag Select para Ordenar o Botao Todos
    var quantidade=lcopcao.search(/ORDENAR/i);
    if( quantidade!=-1 ) {
         var tmp=val;
         var val=lcopcao;
         var lcopcao=tmp;
         ///  var string_array=string_array.replace(" ","");      
         if( document.getElementById("Busca_letrai") ) {
             document.getElementById("Busca_letrai").selectedIndex="0";
         }    
         ///
    }   
    //// 
    /// tag Select para desativar o campo Select ordenar
    var posx=lcopcao.search(/^BUSCA_PROJ|^busca_porcpo|^Busca_letrai/i);
    if( posx!=-1 ) {
        /// Ocultar o ID ordenar
        if( document.getElementById("ordenar") ) {
              document.getElementById("ordenar").selectedIndex="0";
              document.getElementById("ordenar").style.display="none";            
        }  
    }    
    /*   Iniciando o AJAX para selecionar os usuarios desejados  */
    var xAJAX_removerus = new XHConn();
    if( !xAJAX_removerus ) {
          alert("XMLHTTP/AJAX não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    ///
    /// Define o procedimento para processamento dos resultados dp srv_php
    var fndone_removerus = function(oXML) { 
          //  Recebendo o resultado do php/ajax
          var srv_ret = oXML.responseText;
          var lnip = srv_ret.search(/Nenhum|ERRO:/i);
          
///   alert("usuario_remover/169 --->>  lnip = "+lnip+"  \r\n\r srv_ret = "+ srv_ret);
          
          ////  Nao encontrado  -1
          if( lnip==-1 ) {
              if( lcopcao.toUpperCase()=="REMOVER" ) {     
                   var  myArguments = string_array; 
                    /////  var pos = showmodal.search(/NENHUM|ERRO:/i);
                    var pos = myArguments.search(/NENHUM|ERRO:/i);

 ////   alert(" usuario_remover/181 -->>  pos = "+pos+"  --->>>  showmodal= = "+showmodal);   
                                                          
                  ///  Encontrou ERRO                  
                  if( pos!=-1 ) {
                        var pos = srv_ret.search(/APROVADO|NAOAPROVADO/i);
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
                           ///  window.showModal 
                           ///  if( window.showModalDialog) { 
                           if(  showmodal!=null ) { 
                                 var showmodal=window.showModalDialog("../includes/myArguments_remover_usuario.php",myArguments,"dialogWidth:920px;dialogHeight:480px;resizable:no;status:no;center:yes;help:no;");  
                           } else {
                               ///  REMOVER ISSO TEMPORARIO -- srv_ret=USUARIO REMOVIDO   ///
                               ///  var arrayaqui = srv_ret.split("#");
                                ///  Ativando ID  usuario_remove
                                var pos = srv_ret.search(/REMOVIDO/i);
                                if( pos!=-1 ) {
                                      ///  IMPORTANTE:  acentuacao - function AlertAcentuar
                                      ///  alert(acentuarAlerts("Usuário removido."));
                                      alert(AlertAcentuar("Usuário removido."));
                                      ///  Mostrar mensagem
                                      exoc("label_msg_erro",1,srv_ret);    
                                      ///  Verificando ID div_out para ocultar
                                     /***
                                        if( document.getElementById("div_out")  ) {
                                             document.getElementById("div_out").style.display="none";
                                        }
                                     ***/    
                                     ///  Reiniciando ID Busca_letrai      
                                     /*
                                     if( document.getElementById("Busca_letrai") ) {
                                          document.getElementById("Busca_letrai").selectedIndex="0";
                                     }
                                     */   
                                     ///  Reiniciando ID ordenar      
                                     /*
                                     if( document.getElementById("ordenar") ) {
                                          document.getElementById("ordenar").selectedIndex="0";
                                          document.getElementById("ordenar").style.display="none";            
                                     } 
                                     */ 
                                     /***
                                           usuario/participante sem projeto
                                           enviando a mensagem no cabecalho
                                     */
                                     ///  Tempo de 3 segundos para reiniciar pagina
                                     /// SetTimeout(location.reload(),3);                                     
                                     
                                     ///  Reiniciar a pagina
                                     /// location.reload(); 
                                     //  setTimeout("location.href='usuario_remover.php';", 5000 );   
                                     ///  Pagina atual - principal
                                     var pagina_local = location.pathname.split("/").slice(-1);
                                     ///
                                     /// URl - Localizador Uniforme de Recursos
                                      setTimeout(function () {
                                            top.location.href = pagina_local
                                      },7000);
                                     ////
                                } else {
                                     exoc("usuario_remove",1,myArguments);
                                }
                                ////
                           }
                           ////                    
                           if( showmodal=="excluido" ) {        
                                 alert("Anotação excluída. Verificar.")                                                 
                                document.location.reload(true);  
                           }
                  }      
              }  else {
                    //// document.getElementById('label_msg_erro').style.display="block";    
                    //// document.getElementById('div_out').style.display="none";
                    ///  document.getElementById('div_out').innerHTML=srv_ret;                
                    exoc("div_out",1,srv_ret);                       
             }
          } else {              
                /*
                   document.getElementById('label_msg_erro').style.display="block";
                    document.getElementById('label_msg_erro').innerHTML=srv_ret;
                 */
                  ///  Mostrar erro no ID label_msg_erro
                  
          ///  alert("LINHA/188 ----->>>>> encontrou erros  -->>  srv_ret = "+srv_ret);
                  
                  exoc("label_msg_erro",1,srv_ret);  

           }; 
    };
    // 
    //  Define o servidor PHP para consulta do banco de dados
    var srv_php = "srv_removerusuario.php";
    var poststr = new String("");
    if( typeof(lcopcao)=="undefined" ) {
        if( typeof(tcopcao)!="undefined" ) var lcopcao=tcopcao; 
    } 
    ///
    var browser="";
    if( typeof navegador=="function" ) {
        var browser=navegador();
    }  
    ///
    var posrm = lcopcao.search(/REMOVENDO/gi);
    /////  var posrm = tcopcao.search(/REMOVENDO/gi);
    if( posrm!=-1 ) {
        var poststr = "grupous="+encodeURIComponent(opcao)+"&val="+encodeURIComponent(dados)+"&m_array="+encodeURIComponent(string_array)+"&navegador="+browser; 
    } else {
        var poststr = "grupous="+encodeURIComponent(lcopcao)+"&val="+encodeURIComponent(dados)+"&m_array="+encodeURIComponent(string_array);
    }   
    ///
    
 //// alert(" usuario_remover_js.php -->>>  LINHA/299  --  Ativando srv_removerusuario com poststr="+poststr)

    xAJAX_removerus.connect(srv_php, "POST", poststr, fndone_removerus);   
}
///  Final - function remove_usuario
/***************************************************************************/
///
</script>