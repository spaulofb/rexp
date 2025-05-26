//
//   Recebe os dados dos campos - FORM 
function enviar_dados(source,val,string_array) {
    //   Criando os campos instituicao, unidade, departamento, setor 
    
// alert(" dados_recebidos.js/6  -  source = "+source+"  - val = "+val)
    if( source.toUpperCase()=="SUBMETER" ) {
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
           //  Tirando o ultimo        
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
        
    /*  Um alerta informando da não inclusão da biblioteca   */
    if ( !myConn ) {
          alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    //
    //  Serve tanto para o arquivo projeto  quanto para o experimento - Cadastrar
   // var receber_dados = "cadastrar/proj_exp_ajax.php";
    var receber_dados = "includes/dados_recebidos.php";
    
   // alert("LINHA 122 source = "+source+" - val = "+val+" -  campo_nome =  "+campo_nome+" - campo_value =  "+campo_value)
    
    /*  Melhor usando display do que visibility - para ocultar e visualizar   
        document.getElementById('div1').style.display="block";
        document.getElementById('div1').className="div1";
    */
     var inclusao = function (oXML) { 
                         //  Recebendo os dados do arquivo ajax
                         var m_dados_recebidos = oXML.responseText;
                         document.getElementById('label_msg_erro').style.display="none";
                          // if( ( source.toUpperCase()=="COAUTORES" ) ||  ( source.toUpperCase()=="COLABS" ) ) {
                         var pos = m_dados_recebidos.search(/ERRO:/i);
                         document.getElementById('label_msg_erro').style.display="block";
                         if( pos!=-1 ) {
                               document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                         } else {
                               document.getElementById('label_msg_erro').style.display="none";    
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
                                       document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                      // Verificar pra nao acusar erro
                                      if( document.getElementById('arq_link') ) {
                                           document.getElementById('arq_link').style.display="block";        
                                      }
                                       //   document.getElementById('div_form').innerHTML=m_dados_recebidos;
                               } else  {
                                     if( document.getElementById('corpo') ) document.getElementById('corpo').innerHTML=oXML.responseText;   
                               }
                         }
                         
           }; 
            /* 
              aqui é enviado mesmo para pagina receber.php 
               usando metodo post, + as variaveis, valores e a funcao   */
        var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
        /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho   */
       //
       return;
}  //  FINAL da Function enviar_dados_cad para AJAX 
//
