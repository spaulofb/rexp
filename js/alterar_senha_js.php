<?php
/* 
     Verificando conexao  - PARA ALTERAR SENHA - js
*/
//  Verificando se SESSION_START - ativado ou desativado  
if( !isset($_SESSION)) {
     session_start();
}
////
?>
<script language="JavaScript" type="text/javascript">
/*********************************************** 
        JavaScript Document  - 20180611
************************************************/
///
/****  
   Definindo as  variaveis globais  -  20171020

        Define o caminho HTTP
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
///
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
/***  FUNCTION PARA ALTERAR SENHA       ***/
function enviando_dados(source,val,string_array) {
     ///
     /// Verificando se a function exoc existe 
     if(typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
     } else {
         alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
         return;        
     }
     ///

     ///  Verificando variaveis
     if( typeof(source)=="undefined" ) var source=""; 
     if( typeof(val)=="undefined" ) var val="";
     if( typeof(m_array)=="undefined" ) var m_array="";
     ///
     var val_upper="";
     if( typeof(val)=="string" ) {
          /// Variavel com letras maiusculas
          var val_upper=val.toUpperCase();
          /// IMPORTANTE: para retirar os acentos da palavra
          /////  var val=retira_acentos(val);
          var val_sem_acentos=retira_acentos(val);
          var val=val_sem_acentos;
         
          ///  Retirando acentos - 20171005
          var  mlength=val.length;
          ///
          for( i=0;  i<mlength-1;  i++  )   {
               /// Removendo acento
               val = val.replace(/[âáàã]/,"a");
               val = val.replace(/[éèê]/,"e");
               val = val.replace(/[íìî]/,"i");
               val = val.replace(/[ôõóò]/,"o");
               val = val.replace(/[úùû]/,"u");
               val = val.replace("ç","c");
               val = val.replace(" ","-");    
              ///
          }
          /// Variavel com letras minusculas
          var val_lower=val.toLowerCase();
          /// 
     } 
     ///
     /// Verifica se a variavel e uma string
     var source_array_pra_string="";  
     if( typeof(source)=='string' ) {
         ///  source = trim(string_array);
         ///  string.replace - Melhor forma para eliminiar espa?os no comeco e final da String/Variavel
         source = source.replace(/^\s+|\s+$/g,"");        
          /// IMPORTANTE: para retirar os acentos da palavra
         var source_sem_acentos=retira_acentos(source);
         /// 
         var source=source_sem_acentos;
         ///  Retirando acentos - 20171005
         var  mlength=source.length;
         ///
         for(  i=0; i<mlength-1;  i++  )   {
               /// Removendo acento
               source = source.replace(/[âáàã]/,"a");
               source = source.replace(/[éèê]/,"e");
               source = source.replace(/[íìî]/,"i");
               source = source.replace(/[ôõóò]/,"o");
               source = source.replace(/[úùû]/,"u");
               source = source.replace("ç","c");
               source = source.replace(" ","-");    
               ///
         }
         ///
         var pos = source.indexOf(",");     
         if( pos!=-1 ) {  
              ///  Criando um Array 
              var array_source = source.split(",");
              var teste_cadastro = array_source[1];
              var  pos = teste_cadastro.search("incluid");
         }
        ///
     }  else if( typeof(source)=='number' && isFinite(source) )  {
           source = source.value;                
     } else if(source instanceof Array) {
           ///  esse elemento definido como Array
           var source_array_pra_string=source.join("");
           /// IMPORTANTE: para retirar os acentos da palavra
           var source_sem_acentos=retira_acentos(source_array_pra_string);
           /// 
           var source=source_sem_acentos;
          //// 
     }
     ///
     /// Variavel com letras maiusculas
     var source_maiusc = source.toUpperCase();     
     var opcao = source.toUpperCase();
     /****  
         Define o caminho HTTP    -  20180605
     ***/  
     var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
     var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       
   
//// alert("alterar_senha_js.php/7 -  source = "+opcao+" -- val = "+val+" -string_array = "+string_array);
 
      /*****    
     *   Reiniciar a pagina atual 
     *     - utilizar a variavel paginal_local
     */
     if( opcao=="RESET" ) {
          ///  Desativando Notao limpar  -  20180615         
         if( document.getElementById("limpar") ) {
             document.getElementById("limpar").disabled=true;
         }
         ///  Reiniciando
         parent.location.href=pagina_local;                
         return;   
     }
     ///
     if( ( typeof(string_array)!='undefined') && ( opcao=="CONJUNTO" )  ) {
           ///  IF Instituicao - Outra caso tiver na Tabela
          if( val.toUpperCase()=="OUTRA" ) {
                source="PESSOAL"; val="OUTRA";
                /***
                if( document.getElementById("outros_campos") ) {
                    document.getElementById("outros_campos").style.display='none';  
                } 
                ***/
               ///  Ocultando ID  outros_campos
               exoc("outros_campos",0);  
               return;
          }
          /*** 
          if( document.getElementById("outros_campos") ) {
               document.getElementById("outros_campos").style.display='block'; 
          }  
          ***/
          ///  Ativando ID  outros_campos
          exoc("outros_campos",1);  
          var m_array = string_array.split("|");                 
          var opcao0 = m_array[0];
          var poststr="source="+encodeURIComponent(source)+"&val=";
          poststr=poststr+encodeURIComponent(val)+"&m_array="+encodeURIComponent(m_array);
          /// Total dos dados no array - m_array
          var total_lenght = m_array.length;
          var ult_element = total_lenght-1; 
          if( typeof(m_array)=="object" &&  total_lenght ) {
               ///  Campo anterior
               var cpo_ant = m_array[0]; 
               if( opcao=="CONJUNTO" ) {
                    /// Segunda posicao do cpo_ant no array - m_array
                    var z=0;
                    for( y=1; y<=total_lenght; y++ ) {
                        if( m_array[y]==cpo_ant )  z=y; 
                    }
                    for( z; z<=total_lenght; z++ ) {
                        if( z<total_lenght ) {
                            if( cpo_ant.toUpperCase()==m_array[z].toUpperCase() ) continue;
                            ///  criando uma variavel com o valor do num de elementos do array
                            var n_sel_opc = z+1;
                        }
                        ///  Esse if pra definir o proximo campo
                        var m_array_length = total_lenght;
                        var prox_cpo = "";                              
                        if( n_sel_opc<=total_lenght )  prox_cpo = m_array[z];
                        ///
                        if( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                            n_sel_opc=3;   
                            var id_cpo_array = ["td_salatipo","td_sala"];                         
                             for( var j=0; j<id_cpo_array.length; j++ ) {
                                  if( document.getElementById(id_cpo_array[j]) )  {
                                      document.getElementById(id_cpo_array[j]).value="";
                                      document.getElementById(id_cpo_array[j]).style.display="none";
                                  } 
                             }                        
                        }              
                        poststr+="&n_cpo="+encodeURIComponent(n_sel_opc);
                        poststr+="&cpo_final="+encodeURIComponent(m_array_length);
                        break; 
                    }
               }
          }
     }
     ///
     if( opcao=="SUBMETER" ) {
            var frm = string_array;
            var m_elements_total = frm.length; 
            //
            //  Desativar mensagem
            if( document.getElementById('label_msg_erro') ) document.getElementById('label_msg_erro').style.display="none";
            var m_erro = 0; var n_coresponsaveis= new Array(); 
            var n_i_coautor=0;   var n_senhas=0;  var n_testemunhas=0; 
            var n_datas=0; var arr_dt_nome = new Array(); var arr_dt_val = new Array();
            var campo_nome="";   var campo_value=""; var m_id_value="";
            //  ATENCAO:  i tem que ser menor que o total de campos
            for( i=0; i<m_elements_total; i++ ) {      
                //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
                var m_id_name = frm.elements[i].name;
                var m_id_type = frm.elements[i].type;
                var m_id_title = frm.elements[i].title;
                switch (m_id_type) {
                    case "undefined":
                    //  case "hidden":   precisa de dados as vezes              
                    case "button":
                    case "image":
                    case "reset":
                    case "submit":
                    continue;
                }
                //  Verificando campos do FORM somente acusar erro aquelas com TITLE
                if ( m_id_type== "checkbox" ) {
                    //Verifica se o checkbox foi selecionado
                    if( ! elements[i].checked ) var m_erro = 1;
                } else if ( m_id_type=="password" ) {
                    // Verifica se a Senha foi digitada
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value.length<8 ) {
                        var m_erro = 1;      
                    }  else {
                        //  Verficando se tem dois campos senha e outro para confirmar
                        if( ( m_id_name.toUpperCase()=="SENHA" ) || ( m_id_name.toUpperCase()=="REDIGITAR_SENHA" ) ) {
                            n_senhas=n_senhas+1;
                        }                     
                    }                 
                }  else if( m_id_type=="text" ) {  
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value=="" ) {
                        var m_erro = 1;       
                    }  else {
                        //  Se campo for usuario ou  senha
                        if( ( m_id_name.toUpperCase()=="LOGIN" ) || ( m_id_name.toUpperCase()=="SENHA" ) ) {
                            if( m_id_value.length<8 )  var m_erro = 1;    
                        }
                        if( m_erro<1  ) {
                            //  Verificando o campo email                          
                            var m_email = /(EMAIL|E_MAIL|USER_EMAIL)/i;
                            /*
                            if( m_email.test(m_id_name) ) {
                            var resultado = validaEmail(m_id_name);  
                            if( resultado===false  ) {
                            document.getElementById(m_id_name).focus();
                            return;  
                            } 
                            }
                            */                      
                        }   
                    }                  
                }  else if( m_id_type=="hidden" ) {  
                    m_erro=0;
                    m_id_value = trim(document.getElementById(m_id_name).value);
                } else if( m_id_type=="textarea" ) {  
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value=="" ) var m_erro = 1;     
                }  else if( m_id_type=="select-one" ) {  
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value=="" ) var m_erro = 1;    
                    //
                }  else if( m_id_type=="file" ) {  
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
                //  Verificando diferentes dados nos campos de Senha ( Senha e a Confirmacao )
                if( ( n_senhas>1 ) && ( m_erro<1 ) ) {
                     senha1 = document.getElementById("senha").value;
                     senha2 =  document.getElementById("redigitar_senha").value;
                     if( senha1!=senha2 ) {
                         m_id_title="SENHAS DIFERENTES";
                         m_erro=1;
                     }
                }
                //  IF quando encontrado Erro com Title
               //  Quando for campo SEM Title passar sem erro
               if( m_id_title.length<1 ) m_erro=0;
               if( m_erro==1 ) {
                   document.getElementById("label_msg_erro").style.display="block";
                   //   document.getElementById("msg_erro").style.display="block";
                   //     document.getElementById("msg_erro").innerHTML="";
                   var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                   msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                   var final_msg_erro = "&nbsp;</span></span>";
                   m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                   //  document.getElementById("msg_erro").innerHTML=msg_erro;    
                   document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                   //  frm.m_id_name.focus();
                   document.getElementById(m_id_name).focus();
                   return;
               }       
               //
               if( m_id_name.toUpperCase()=="REDIGITAR_SENHA" ) continue;
               //  As variaveis que serao enviadas nome do campo e valor
               campo_nome+=m_id_name+",";  
               campo_value+=m_id_value+",";                   
               if( m_id_name.toUpperCase()=="ENVIAR" )  break;  
            } 
            ///  Final do For
            ///  
            ///  Verificando se Nao ouve erro
            if( m_erro<1 ) {
                //  Enviando os dados dos campos para o AJAX
                var cpo_nome = campo_nome.substr(0,campo_nome.length-1);
                var cpo_value = campo_value.substr(0,campo_value.length-1);
               var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(cpo_nome)+"&campo_value="+encodeURIComponent(cpo_value);             
           }
     } 
     /// Final do IF submeter 
   
    /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca - AJAX   */
    if ( !myConn ) {
          alert("XMLHTTP não dispon?vel. Tente um navegador mais novo ou melhor.");
          return false;
    }
    //
    //  Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
   //   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    var receber_dados = raiz_central+"includes/alterar_senha_ajax.php";
    ///
     var inclusao = function (oXML) { 
                    ///  Recebendo os dados do arquivo ajax
                    ///  Importante ter trim no  oXML.responseText para tirar os espacos
                    var m_dados_recebidos = trim(oXML.responseText);
                    
 //// alert(" alterar_senha_js/352  - opcao = "+opcao+"  -->>> source = "+source+" - val = "+val+" \r\n  m_dados_recebidos = "+m_dados_recebidos);
                    
                    ///
                    var pos = m_dados_recebidos.search(/Nenhum|ERRO:/i);
                    if( document.getElementById('corpo') ) {
                          document.getElementById('corpo').style.display="block"; 
                    }  
                    ///  Caso ocorreu erro
                    if( pos!=-1 ) {
                         ///  document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                         /// ativar ID label_msg_erro
                         exoc("label_msg_erro",1,m_dados_recebidos);                             
                         ///
                    } else {
                         ///
                         if( opcao=="SUBMETER" ) {
                             ///  Senha alterada
                             if( val_upper=="SENHA" ) {
                                 /// ativar ID label_msg_erro - mensagem
                                 exoc("label_msg_erro",1,m_dados_recebidos);                             
                                 ///                                 
                                 limpar_campos();
                                 ///
                             }
                         } else {
                             if( document.getElementById('div_form') ) {
                                   //// document.getElementById('div_form').setAttribute("style","padding-bottom: 4px; text-align: center; font-size: large;color:#FF00FF;");
                                  document.getElementById("div_form").style.fontSize='x-large';
                                  document.getElementById("div_form").style.color='#000000';
                                  document.getElementById("div_form").style.textAlign='center';
                                  document.getElementById("div_form").style.paddingBottom='.5em';
                                  document.getElementById('div_form').innerHTML=m_dados_recebidos;      
                             }
                             ///
                         }     
                         ///
                    }
                    ///
           }; 
            /* 
              aqui ? enviado mesmo para pagina receber.php 
               usando metodo post, + as variaveis, valores e a funcao   */
        var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
        /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho   */
       //
       return;
}  
////  FINAL da Function enviar_dados_cad para AJAX 
///
///  LImpar os campos de um FORM
function limpar_campos() {
    ///  Verifica se existe FORM
    var y = document.forms;
    if( typeof y=="undefined" ) {
         alert("Falha grave, faltando FORM/Formulário. Corrigir"); 
         return;
    } 
    ///
    
    
   var frm=document.forms[0]
   var m_elements_total = frm.length; 
   ///
   ///  Desativar mensagem
   for( i=0; i<m_elements_total; i++ ) {      
         ///  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
         var m_id_name = frm.elements[i].id;
         var m_id_type = frm.elements[i].type;
         ///                
         switch (m_id_type) {
                    case "undefined":
                    case "hidden": /// precisa de dados as vezes                    
                    case "image":
                    case "reset":
                    continue;
         }
         ///
                
  ///   alert(" i = "+i+"  ---   m_id_name = "+ m_id_name+"  -- m_id_type = "+m_id_type);   
                
         if( m_id_type=="submit" ) {
              ///  Botao submit
              ///  alert("campo submit ");
              document.getElementById(m_id_name).disabled = false;
              ///
         } else if( m_id_type== "button" ) {
              ///  Botao button
              /// alert("campo button ");
              document.getElementById(m_id_name).disabled = false;
              ///
         } else  if( m_id_type== "checkbox" ) {
              /// Verifica se o checkbox foi selecionado
              if( ! elements[i].checked ) var m_erro = 1;
              ///
         } else if ( m_id_type=="password" ) {
              /// Verifica se a Senha foi digitada
              ///  alert("campo password ");
              document.getElementById(m_id_name).value="";
              ///
         } else if( m_id_type=="text" ) {  
             ///  alert("campo text ");
              ///  Se campo for usuario ou  senha
              var pos = m_id_name.search(/LOGIN|usuario/i);
              if( pos==-1 ) {
                   document.getElementById(m_id_name).value="";
              }
              ///
         }  else if( m_id_type=="textarea" ) {  
             ///  alert("campo textarea ");
             document.getElementById(m_id_name).value="";
             ////
         }  else if( m_id_type=="select-one" ) {  
             ///  alert("campo select-one ");
             ///
         }  else if( m_id_type=="file" ) {  
             /// alert("campo file "); 
         }                
         ///  Verificando diferentes dados nos campos de Senha ( Senha e a Confirmacao )
   } 
   /// Final do For
   ///  
}
/****  Final  -  LImpar os campos de um FORM    *****/  
///
</script>

