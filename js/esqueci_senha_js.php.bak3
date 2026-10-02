<?php
//
// Verificando conexao Consultar patrimonnio
//
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
///
?>
<script language="JavaScript" type="text/javascript">
/****
       Javascript - arquivo esqueci_senha_js.php
*******************************************************/
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
///
charset="utf-8";
///
///   funcrion acentuarAlerts - para corrigir acentuacao
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
/*****************  Final  -- function acentuarAlerts(mensagem)   ***************************/
///
//   Recebe os dados dos campos - FORM 
function enviar_dados(source,val,string_array) {
    ////   Criando os campos instituicao, unidade, departamento, setor 
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
    /// Verifica se a variavel e uma string
    var source_array_pra_string="";  
    if( typeof(source)=='string' ) {
        //  source = trim(string_array);
        //  string.replace - Melhor forma para eliminiar espaços no comeco e final da String/Variavel
        source = source.replace(/^\s+|\s+$/g,"");        
        source_maiusc = source.toUpperCase();     
        var pos = source.indexOf(",");     
        if( pos!=-1 ) {  
            ///  Criando um Array 
            var array_source = source.split(",");
            var teste_cadastro = array_source[1];
            var  pos = teste_cadastro.search("incluid");
        }
     }  else if( typeof(source)=='number' && isFinite(source) )  {
          source = source.value;                
     } else if(source instanceof Array) {
          //  esse elemento definido como Array
          var source_array_pra_string=src.join("");
     }
     ///  variavel source_maiusc igual a source maiuscula
     var source_maiusc=source.toUpperCase(); 
    
  ///  alert(" esqueci_senha_js/129  --->>   source = "+source+"  - val = "+val);
 
  ///  if( source.toUpperCase()=="SUBMETER" ) {
    if( source_maiusc=="SUBMETER" ) {        
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
         ///  Tirando o ultimo        
         for ( i=0; i<=m_elements_total; i++ ) {      
            //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
            var m_id_name = frm.elements[i].name;
            var m_id_type = frm.elements[i].type;
            var m_id_title = trim(frm.elements[i].title);
            // var m_id_value = frm.elements[i].value;
             //  var m_id_value = frm.elements[i].value;
             //  SWITCH para verificar o  type da  tag (campo)
             switch (m_id_type) {
                  case "undefined":
                  //  case "hidden":                 
                  case "button":
                  case "image":
                  case "reset":
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
                      var m_email = new Array('EMAIL','E_MAIL','USER_EMAIL','E-MAIL');
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
        //  document.form.elements[i].disabled=true; 
       //  alert("LINHA 145 - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro)        
         if( m_erro==1 ) {
              document.getElementById(m_id_name).focus();
              return false;
         } else {
             //  Enviando os dados dos campos para o AJAX
             //  alert("LINHA 122 - campo_nome =  "+campo_nome+" - campo_value =  "+campo_value)
             var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);             
         }
    }  //  FINAL do IF SUBMETER
    /*   Aqui eu chamo a class  */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca   */
    if( !myConn ) {
          alert("XMLHTTP não dispon?vel. Tente um navegador mais novo ou melhor.");
          return false;
    }
    //
    //  Serve tanto para o arquivo projeto  quanto para o experimento - Cadastrar
   // var receber_dados = "cadastrar/proj_exp_ajax.php";
    var receber_dados = "includes/esqueci_senha_ajax.php";
    
   // alert("LINHA 122 source = "+source+" - val = "+val+" -  campo_nome =  "+campo_nome+" - campo_value =  "+campo_value)
    
    /*  Melhor usando display do que visibility - para ocultar e visualizar   
        document.getElementById('div1').style.display="block";
        document.getElementById('div1').className="div1";
    */
     var inclusao = function (oXML) { 
                       ///  Recebendo os dados do arquivo ajax
                       var m_dados_recebidos = oXML.responseText;
                       ///  document.getElementById('label_msg_erro').style.display="none";
                       /// Verificando erro/falha 
                        var pos = m_dados_recebidos.search(/ERRO:|FALHA:/i);
                        /// document.getElementById('label_msg_erro').style.display="block";
    
 /////  alert(" LINHA/320  -->>>  pos = "+pos+"  --- source = "+source+" - val = "+val+" -  campo_nome =  "+campo_nome+" - campo_value =  "+campo_value)
                        
                        /// Caso houve erro ou nao                         
                         if( pos!=-1 ) {
                               ///   document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                               /* 
                               if( document.getElementById("label_msg_erro") ) {
                                   document.getElementById('label_msg_erro').style.display="block";
                                   document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                               }
                               */
                               /// Mensagem de erro ativar
                               exoc("label_msg_erro",1,m_dados_recebidos);   
                               return;
                         } else {
                              //// document.getElementById('label_msg_erro').style.display="none";    
                               if( source.toUpperCase()=="SUBMETER" ) {
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
                                      /// document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                      /// Mensagem para ID label_msg_erro - ativar
                                      exoc("label_msg_erro",1,m_dados_recebidos);   
                                      
                                      /// Verificar pra nao acusar erro
                                      if( document.getElementById('arq_link') ) {
                                           document.getElementById('arq_link').style.display="block";        
                                      }
                                       //   document.getElementById('div_form').innerHTML=m_dados_recebidos;
                               } else  {
                                     ///  Retorno de dados do arquivo AJAX para ID corpo 
                                     if( document.getElementById('corpo') ) {
                                           document.getElementById('corpo').innerHTML=oXML.responseText;      
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
       return;
}  //  FINAL da Function enviar_dados_cad para AJAX 
//
//  Sair do Programa
function dochange(source,val) {
    var lcopcao = source.toUpperCase();
    /*
    if( lcopcao=="VOLTAR" ) {
       top.location.href="http://www-gen.fmrp.usp.br/rexp/authent_user.php";
       return;     
    } 
    */  
    /*
       SAIR DO SITE
   */
   if( lcopcao=="SAIR" ) {
      var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
      var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
      var navegador =navigator.appName;
      var pos = navegador.search(/microsoft/gi);
      //  if( pos!=-1 ) {
      //  if( navegador.search(/microsoft/gi)!=-1 ) {        
      if( is_firefox!=-1 ) {
           //  Sair da pagina e ir para o Site da FMRP/USP
           location.replace('http://www.fmrp.usp.br/');                
           // window.open('','_parent','');window.close();    
            //  window.opener=null; 
            //  window.close();            
      } else if( is_chrome!=-1  || pos!=-1  ) {
              window.opener=null; 
              window.close();            
      }
      return;
   }  
   //  Voltar para a pagina inicial
   if( lcopcao=="VOLTAR" ) {
       // location.replace('http://sol.fmrp.usp.br/rexp');                
       location.replace('index.php'); 
      return;
   }        
}
///
</script>
