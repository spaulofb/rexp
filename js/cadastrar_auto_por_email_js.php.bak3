<?php
/* 
     Verificando conexao  - PARA CADASTRAR - PROJETO/ANOTACAO  - js
*/
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
/// $_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
if( ! isset($_SESSION["url_central"]) ) {
     echo "ERRO: Sessão raiz_central não declarada. Corrigir ";
     exit();
}
$raiz_central=$_SESSION["url_central"];
///
?>
<script language="JavaScript" type="text/javascript">
///
///   JavaScript Document
///
/****
       PARA CADASTRAR - NOVO ORIENTADOR/ANOTACAO         
****/
///
charset="utf-8";
/****  
   Definindo as  variaveis globais  -  20181029

        Define o caminho HTTP
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
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
/********  Final  -- function acentuarAlerts(mensagem)   ********/
///
///   Funcao para verificar alguns campos do arq cadastrar_auto.php
function campos_obrigatorios(source,val,string_array)  { 
   ///
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
     ///  variavel opcao igual a  source maiuscula
     var opcao=source.toUpperCase();
    /****  
         Define o caminho HTTP    -  20180615
    ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       

     

/*     
 alert(" cadastrar_auto_por_email_js.php/55 ->>> raiz_central = "+raiz_central+"  -=-- opcao = "+opcao+"  - val = "+val+" -- string_array =  "+string_array);
 return;
*/

     var resultado=true;
     ///  Array -  m_email - para verificar o campo de email
     var m_email = new Array('EMAIL','E_MAIL','USER_EMAIL','E-MAIL');
     if( typeof(source)!='undefined' ) {
           var pos= source.search(/EMAIL|E_MAIL|USER_EMAIL|E-MAIL/i);
           if( pos!=-1  ) {
                val = val.replace(/^\s+|\s+$/g,"");
                document.getElementById(source).value=val;
                resultado = validaEmail(source);   
                /// Caso ocorreu ERRO                  
                if( resultado===false  ) return;                
           }
     }
     ///      
    if( opcao=="CAMPOS_OBRIGATORIOS"  ) {
        if( val.toUpperCase()=="CPF"  ) {
              resultado = validarCPF(string_array,val);  
              resultado=true
        }
        if( val.toUpperCase()=="CODIGOUSP" ) {
             var val_codigousp = document.getElementById("codigousp").value;
             val_codigousp = trim(val_codigousp);
             if( val_codigousp.length<1 ) {
                  alert("Caso não tenha o Código/USP é necessário digirar 0")
                  resultado=false;   
             }
        }
        m_tit_cpo=val.toUpperCase();
    }
    ///
    if( resultado==false ) {
         var m_id_title = document.getElementById(val).title;                   
         document.getElementById("label_msg_erro").style.display="block";
         var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
         msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
         var final_msg_erro = "&nbsp;</span></span>";
         m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
         msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
         ///  document.getElementById("msg_erro").innerHTML=msg_erro;    
         document.getElementById("label_msg_erro").innerHTML=msg_erro;    
         document.getElementById(val).focus();                   
         return false;                   
    } else if(  typeof resultado=="undefined" ) {
         var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array);        
    }
 
 /*   
  alert(" cadastrar_auto_por_email_js.php/116 - opcao = "+opcao+"  - val = "+val+" -- string_array =  "+string_array+" \r\n poststr =   "+poststr)   
*/
  
   /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca - AJAX   */
    if ( !myConn ) {
          alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    ////   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    var receber_dados = raiz_central+"includes/cadastrar_auto_por_email_ajax.php";
/*  
 alert(" cadastrar_auto_por_email_js.php/55 ->>> receber_dados = "+receber_dados+"  \r\n raiz_central = "+raiz_central+"  -=-- opcao = "+opcao+"  - val = "+val+" -- string_array =  "+string_array);
 return;
  */
    
    ////
    var inclusao = function (oXML) { 
                         //  Recebendo os dados do arquivo ajax
                         //  Importante ter trim no  oXML.responseText para tirar os espacos
                         var dados_recebidos = trim(oXML.responseText);
                         document.getElementById('label_msg_erro').style.display="none";
                         //// Verificando se houve Erro
                         var pos = dados_recebidos.search(/Nenhum|Erro/i);  
                         if( pos!=-1 ) {
                               /*
                                  document.getElementById('label_msg_erro').style.display="block";
                                  document.getElementById('label_msg_erro').innerHTML=dados_recebidos;
                              */
                               /// Mensagem de erro ativar
                               exoc("label_msg_erro",1,dados_recebidos);   
                               return;
                         }
                         var source_pos = source.search(/EMAIL|E_MAIL|USER_EMAIL|E-MAIL/i);
                         
  ///  alert(" cadastrar_auto_por_email_js.php/154 - opcao = "+opcao+"  \r\n - dados_recebidos = "+dados_recebidos);
  
                         if( opcao=="CAMPOS_OBRIGATORIOS"  ) {
                                 ///
                                 var pos = dados_recebidos.search(/Nenhum|ERRO:/i);
                                 if( trim(dados_recebidos)!="" && pos==-1 ) {
                                      var myArguments = dados_recebidos;
                                      /*   Desativando window.showModalDialog    
                                      if( document.getElementById('id_body')  ) {
                                          document.getElementById('id_body').setAttribute('style','background-color: #007FFF');
                                      }
                                      
                                      var showmodal=window.showModalDialog("myArguments.php",myArguments,"dialogWidth:600px;dialogHeight:500px;resizable:no;status:no;center:yes;help:no;");  
                                      if( showmodal != null) {                                                                                                   
                                          //  alert("LINHA 151 - cadastrar_auto.php  =  "+dados_recebidos)
                                          var pos = dados_recebidos.search(/APROVADO|NAOAPROVADO/);
                                          if( pos!=-1 ) {                                            
                                              var array_modal = showmodal.split("#");
                                              if( document.getElementById('div_form')  ) {
                                                 if( document.getElementById('id_body')  ) {
                                                     document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                                 }    
                                                 document.getElementById('div_form').innerHTML=showmodal;
                                              }                                                                                      
                                          }                                        
                                      }
                                      */       
                                 } else if(pos!=-1 ) {
                                     var posicao = dados_recebidos.search(/cadastre-se/i);     
                                     if( posicao==-1 ) {
                                          document.getElementById('label_msg_erro').style.display="block";
                                          document.getElementById('label_msg_erro').innerHTML=dados_recebidos;                                      
                                     }
                                 }                                         
                               //                             
                         } else if( source_pos!=-1  ) { //  Encontrou source com email ou outro nome
                                //   Somente digitando o campo E_MAIL 
                                 var posini = dados_recebidos.search(/PREENCHA|Nenhum|ERRO:/i);
    //    alert(" cadastrar_auto_por_email.js/73 - opcao = "+opcao+" -  posini = "+posini+"   **--** \r\n - dados_recebidos = "+dados_recebidos)                                                          
                                 if( trim(dados_recebidos)!="" && posini==-1 ) {
                                      //  Caso o novo Orientador ja foi APROVADO
                                      var pos = dados_recebidos.search(/APROVADO|NAOAPROVADO/i);
                                      if(  document.getElementById('div_form') ) {
                                                document.getElementById('div_form').style.display="block";  
                                                document.getElementById('div_form').setAttribute("style","text-align: center;");      
                                                document.getElementById('div_form').innerHTML=dados_recebidos;        
                                       }                                   
                                      /*
                                      if( pos!=-1 ) {                                            
                                          var myArguments = dados_recebidos;
                                          if( document.getElementById('id_body')  ) {
                                              document.getElementById('id_body').setAttribute('style','background-color: #007FFF');
                                          }    
                                          var showmodal=window.showModalDialog("myArguments.php",myArguments,"dialogWidth:600px;dialogHeight:500px;resizable:no;status:no;center:yes;help:no;");  
                                          if( showmodal != null) {                                                                                                   
                                              //  alert("LINHA 151 - cadastrar_auto.php  =  "+dados_recebidos)
                                              if( pos!=-1 ) {                                            
                                                  var array_modal = showmodal.split("#");
                                                  if( document.getElementById('div_form')  ) {
                                                     if( document.getElementById('id_body')  ) {
                                                         document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                                     }    
                                                     document.getElementById('div_form').innerHTML=showmodal;
                                                  }                                                                                      
                                              }                                        
                                          }   
                                      } else { //  Final do Caso o novo Orientador ja foi APROVADO
                                            // Verificar pra nao acusar erro
                                            if(  document.getElementById('div_form') ) {
                                                document.getElementById('div_form').style.display="block";  
                                                document.getElementById('div_form').setAttribute("style","text-align: center;");      
                                                document.getElementById('div_form').innerHTML=dados_recebidos;        
                                           }
                                      } 
                                      */                                     
                                     //
                                 } else if( posini!=-1 ) { //  Caso ocorreu algum ERRO
                                // document.getElementById("codigo_img").src = "../imagens/loading.gif";
                                     document.getElementById('label_msg_erro').style.display="block";
                                     
 //   alert(" cadastrar_auto_por_email.js/149 - opcao = "+opcao+"  ** \r\n - dados_recebidos = "+dados_recebidos)                                                          
                                     
                                     var partes = dados_recebidos.split("#");
                                     var imagem_src= partes[0];
                                     //  Tem retirar do caminho imagem_src (path) 3 carateres ->   ../
                                     var cod_img_src = imagem_src.substring(3,imagem_src.length); 
                                     var cod_img_value = partes[1];
                                     //  Mensagem no cabecalho da div corpo
                                     document.getElementById('label_msg_erro').innerHTML=trim(partes[2]); 
                                     // 
                                     if( document.getElementById('form_novo_orientador') )  {
                                         document.getElementById('form_novo_orientador').style.display="none";   
                                         var pos = dados_recebidos.search(/PREENCHA/i);     
                                         if( pos!=-1 ) {
                                             //  Para Preencher o Formulario o novo Orientador
                                            document.getElementById('form_novo_orientador').style.display="block";
                                            document.getElementById("codigo_img").setAttribute('src',cod_img_src);
                                            //  aqui a input hidden de id=?magica? recebe um valor 
                                             //   din?micamente  via Código Javascript cria um objeto de refer?ncia 
                                            if( document.getElementById("magica") ) {
                                                var objetoDados = document.getElementById("magica");
                                                //  altera o atributo value desta tag
                                                objetoDados.value = cod_img_value;     
                                            }
                                            var e_mail_val = document.getElementById(source).value;   
                                            if(document.getElementById('email') ) document.getElementById('email').value=e_mail_val;
                                         }   
                                     }                                     
                                 }                                         
                         } else {
                              var pos = dados_recebidos.search(/Nenhum|ERRO:/i);
                              if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";
                                 document.getElementById('label_msg_erro').style.display="block";
                               if( pos!=-1 ) {
                                   ///
                                   var pos = dados_recebidos.search(/ERRO:/i);
                                   if( pos!=-1 ) {
                                       var pos = dados_recebidos.search(/cadastrado|cadastrada/gi);
                                       if( pos!=-1 ) {
                                           ///  top.location.href("../includes/showmodaldialog.php?teste="+dados_recebidos,"CADASTRADO","dialogWidth:255px;dialogHeight:250px");
                                           ///  openDialog("dados_recebidos");                                         
                                           ///   Desativando window.showModalDialog    
                                           /*
                                          var myArguments = new Object();
                                           myArguments.param1 = dados_recebidos;
                                window.showModalDialog("myArguments.php?myArguments="+dados_recebidos,myArguments,"dialogWidth:600px;dialogHeight:700px;center:yes;"); 
                                          document.getElementById(val).focus();
                                          return false;
                                          */
                                      }
                                  } else {
                                      document.getElementById('label_msg_erro').innerHTML=dados_recebidos;                                      
                                  }
                              } else {
// alert("PASSOU 487 - source = "+source+" - val = "+val+" - dados_recebidos = "+dados_recebidos+" -  pos = "+pos)
                                  document.getElementById('label_msg_erro').style.display="none";    
                                  if( document.getElementById('div_form') ) {
                                      document.getElementById('div_form').setAttribute("style","padding-top: 2px; text-align: center;font-size: medium;");
                                      document.getElementById('div_form').innerHTML=dados_recebidos;      
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
}
//
//  Funcao para enviar os DADOS dos cmapos do FORM - arq cadastrar_auto.php
function enviando_dados(source,val,string_array) {
   //
   var opcao = source.toUpperCase();
   
//  alert("cadastrar_auto_por_email.js/206 -  source = "+opcao+" -- val = "+val+" -string_array = "+string_array);

     if( opcao=="CAMPOS_OBRIGATORIOS"  ) {
         if( val.toUpperCase()=="CPF"  ) {
               var resultado = validarCPF(string_array,val);    
               resultado=true; 
               if( ! resultado ) {
                   var m_id_title = document.getElementById(val).title;                   
                   document.getElementById("label_msg_erro").style.display="block";
                   var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                   msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                   var final_msg_erro = "&nbsp;</span></span>";
                   m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                   //  document.getElementById("msg_erro").innerHTML=msg_erro;    
                   document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                   document.getElementById(val).focus();                   
                   return false;                   
               }
         }
         var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array); 
     }
    //
    if ( ( typeof(string_array)!='undefined') && ( opcao=="CONJUNTO" )  ) {
        //  IF Instituicao - Outra caso tiver na Tabela
        if( val.toUpperCase()=="OUTRA" ) {
            source="PESSOAL";val="OUTRA";
            if( document.getElementById("outros_campos") ) document.getElementById("outros_campos").style.display='none';
            return;
        } 
        if( document.getElementById("outros_campos") ) document.getElementById("outros_campos").style.display='block';
        var m_array = string_array.split("|");                 
        var opcao0 = m_array[0];
        var poststr="source="+encodeURIComponent(source)+"&val=";
        poststr=poststr+encodeURIComponent(val)+"&m_array="+encodeURIComponent(m_array);
        // Total dos dados no array - m_array
        var total_lenght = m_array.length;
        var ult_element = total_lenght-1; 
        if ( typeof(m_array)=="object" &&  total_lenght ) {
            //  Campo anterior
            var cpo_ant = m_array[0]; 
            if( opcao=="CONJUNTO" ) {
                // Segunda posicao do cpo_ant no array - m_array
                var z=0;
                for( y=1; y<=total_lenght; y++ ) {
                    if( m_array[y]==cpo_ant )  z=y; 
                }
                for( z; z<=total_lenght; z++ ) {
                    if( z<total_lenght ) {
                        if( cpo_ant.toUpperCase()==m_array[z].toUpperCase() ) continue;
                        //  criando uma variavel com o valor do num de elementos do array
                        var n_sel_opc = z+1;
                    }
                    //  Esse if pra definir o proximo campo
                    var m_array_length = total_lenght;
                    var prox_cpo = "";                              
                    if( n_sel_opc<=total_lenght )  prox_cpo = m_array[z];
                    //
                    if( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                         n_sel_opc=3;   
                         var id_cpo_array = ["td_salatipo","td_sala"];                         
                         for( var j=0; j<id_cpo_array.length; j++ ){
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
    //
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
                
  //   alert("cpo#"+i+"  nome="+m_id_name+"  tipo="+m_id_type+"  valor="+frm.elements[i].value)
                
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
                /*
                   if ( m_id_type== "checkbox" ) {
                       if( ! elements[i].checked   ) var m_erro = 1;
                   }   else if ( m_id_type=="password" ) {
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
                   } 
                */
                if( m_id_type=="text" ) {  
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    //  Verificando o campo NOME                          
                    var m_nome = /(NOME|NAME|TXTNOME|NOME_TXT|NOME_TXT)/i;
                    if( m_id_value=="" && m_nome.test(m_id_name) ) {
                        var m_erro = 1;       
                    }  
                    /*
                       else {
                        //  Se campo for usuario ou  senha

                        if( ( m_id_name.toUpperCase()=="LOGIN" ) || ( m_id_name.toUpperCase()=="SENHA" ) ) {
                            if( m_id_value.length<8 )  var m_erro = 1;    
                        }
                        if( m_id_name.toUpperCase()=="CODIGOUSP" ) {
                            if( m_id_value.length<1 )  var m_erro = 1;    
                        }                       
                        if( m_erro<1  ) {
                            //  Verificando o campo email                          
                            var m_email = /(EMAIL|E_MAIL|E-MAIL|USER_EMAIL)/i;
                            //  
                            if( m_email.test(m_id_name) ) {
                               var resultado = validaEmail(m_id_name);  
                               if( resultado===false  ) {
                                   document.getElementById(m_id_name).focus();
                                   return;  
                               } 
                            }
                        } 
                    
                    }
                    */                    
                }  else if( m_id_type=="hidden" ) {  
                    m_erro=0;
                    m_id_value = trim(document.getElementById(m_id_name).value);
                } else if( m_id_type=="textarea" ) {  
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value=="" ) var m_erro = 1;     
                }  else if( m_id_type=="select-one" ) {  
                    // Verifica se o checkbox foi selecionado - ex. SEXO e etc... Categoria, Instituicao
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value=="" && m_id_name.toUpperCase()=="SEXO"  ) var m_erro = 1;    
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
               //  As variaveis que serao enviadas nome do campo e valor
               campo_nome+=m_id_name+",";  
               campo_value+=m_id_value+",";                   
               if( m_id_name.toUpperCase()=="ENVIAR" )  break;  
            } // Final do For
            //  
            //  Verificando se Nao ouve erro
            if( m_erro<1 ) {
                //  Enviando os dados dos campos para o AJAX
                var cpo_nome = campo_nome.substr(0,campo_nome.length-1);
                var cpo_value = campo_value.substr(0,campo_value.length-1);
                var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(cpo_nome)+"&campo_value="+encodeURIComponent(cpo_value);             
           }
    } // Final do IF submeter 
   
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
//    var receber_dados = "includes/cadastrar_auto_ajax.php";
    var receber_dados = "includes/cadastrar_auto_por_email_ajax.php";
    
//  alert(" -> cadastrar_auto_por_email.js/406 - source = "+source+" -  val = "+val+" - poststr = "+poststr)
    
    //
     var inclusao = function (oXML) { 
                         //  Recebendo os dados do arquivo ajax
                         //  Importante ter trim no  oXML.responseText para tirar os espacos
                         var dados_recebidos = trim(oXML.responseText);
                         document.getElementById('label_msg_erro').style.display="none";
                         if(  opcao=="CONJUNTO"   ) { 
                               var m_elementos = "instituicao|unidade|depto|setor|bloco|sala";
                                var new_elements = m_elementos.split("|");
                                // Desativando alguns campos
                                document.getElementById("label_msg_erro").style.display="none";
                                if ( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                                     limpar_campos(new_elements);
                                }  else if( cpo_ant.toUpperCase()=="SALA" ) {
                                      n_sel_opc = 0;
                                      cpo_ant="instituicao";      
                                }
                                //  Verificando se tem proximo campo ou chegou no Final
                                if ( prox_cpo.length>0 ) {
                                   //  Ativando a tag td com o campo
                                   var id_cpo = "td_"+prox_cpo;
                                   document.getElementById("tab_de_bens").innerHTML= "";
                                   var lsinstituicao = dados_recebidos.search(/Institui??o/i);  
                                   var pos = dados_recebidos.search(/Nenhum|Erro/i);  
                                   if( pos != -1 )  {
                                      if( lsinstituicao== -1 )  {
                                           limpar_campos(new_elements);
                                         //   Voltar para o inicio da Tag Select  id - selectedindex
                                         document.getElementById('instituicao').options[0].selected=true;
                                        document.getElementById('instituicao').options[0].selectedIndex=0;
                                        document.getElementById(id_cpo).style.display="none";
                                        mensg_erro(dados_recebidos,"label_msg_erro");
                                        //  Erro limpar font ID = tab_de_bens  - display: none
                                        if( document.getElementById('tab_de_bens') ) document.getElementById('tab_de_bens').style.display="none";
                                         document.getElementById('instituicao').focus();
                                     }  
                                   } else if( pos == -1 ) {
                                       if( n_sel_opc<=m_array_length ) {
                                           document.getElementById(id_cpo).style.display="block";
                                           document.getElementById(id_cpo).innerHTML=dados_recebidos;
                                      }
                                   }
                              }
                         } else if( opcao=="CAMPOS_OBRIGATORIOS"  ) {
                                 //
                                 var pos = dados_recebidos.search(/Nenhum|ERRO:/i);
                                 if( trim(dados_recebidos)!=""  &&  pos==-1 ) {
                                     // var myArguments = new Object();
                                    //  var myArguments = {};
                                      //   myArguments.param1 = dados_recebidos;
                                      var myArguments = dados_recebidos;
                                      // var myArguments = teste;
                 /*             window.showModalDialog("myArguments.php?myArguments="+dados_recebidos,myArguments,"dialogWidth:600px;dialogHeight:700px;edge:raised;status:no;help:no;resizable:no;");  */
                                   //
                                   /*   DESATIVANDO ->  window.showModalDialog                                           
                                   if( document.getElementById('id_body')  ) {
                                       document.getElementById('id_body').setAttribute('style','background-color: #007FFF');
                                   }                                 
                                   var showmodal =  window.showModalDialog("myArguments.php",myArguments,"dialogWidth:600px;dialogHeight:500px;resizable:no;status:no;center:yes;help:no;");  
                                   if ( showmodal != null)  {
                                      if(  dados_recebidos.search(/APROVADO|NAOAPROVADO/)!=-1 ) {
                                          var array_modal = showmodal.split("#");
                                          if( document.getElementById('div_form')  ) {
                                                if( document.getElementById('id_body')  ) {
                                                     document.getElementById('id_body').setAttribute('style','background-color: #FFFFFF');
                                                }    
                                                //  document.getElementById('div_form').innerHTML=array_modal[0];
                                                document.getElementById('div_form').innerHTML=showmodal;
                                          }                                                                                           
                                      }                                        
                                   }
                                   */       
                                 } else if(pos!=-1 ) {
                                     document.getElementById('label_msg_erro').style.display="block";
                                     document.getElementById('label_msg_erro').innerHTML=dados_recebidos;                                      
                                 }                                         
                               //                             
                         } else {
                              var pos = dados_recebidos.search(/ERRO:/i);
                              if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";
                                 document.getElementById('label_msg_erro').style.display="block";
                               if( pos!=-1 ) {
 //  alert("PASSOU 484 - source = "+source+" -  pos = "+pos+" -  dados_recebidos="+dados_recebidos)
                                  document.getElementById('label_msg_erro').innerHTML=dados_recebidos;
                              } else {
//  alert("PASSOU 487 - source = "+source+" - val = "+val+" - dados_recebidos = "+dados_recebidos+" -  pos = "+pos)
                                  document.getElementById('label_msg_erro').style.display="none";    
                                  if( opcao=="SUBMETER" ) {
                                     // Verificar pra nao acusar erro
                                     if(  document.getElementById('div_form') ) {
                                         document.getElementById('div_form').value="";
                                           document.getElementById('div_form').style.display="none";  
                                          /* document.getElementById('div_form').style.display="block";  
                                           document.getElementById('div_form').setAttribute("style","text-align: center;");      
                                           document.getElementById('div_form').innerHTML=dados_recebidos;        
                                           */
                                           document.getElementById('label_msg_erro').style.display="block";    
                                           document.getElementById('label_msg_erro').innerHTML=dados_recebidos;        
                                     }
                                  } else  {
                                     if( document.getElementById('corpo') ) document.getElementById('corpo').innerHTML=oXML.responseText;   
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
/*
     Function para o Donwload/Carregar  do Servidor para o Local
*/
function download(m_id) {
   var m_id_val = document.getElementById(m_id).value;
    self.location.href='baixar.php?file='+m_id_val;
}
//  Limitando o numero de caracteres no textarea
function limita_textarea(campo){
      var tamanho = document.form1[campo].value.length;
      var tex=document.form1[campo].value;
      if (tamanho>=255) {
         document.form1[campo].value=tex.substring(0,5);
      }
      return true;
 } 
//   Numero de coautores - enviar para cria-los
function n_coresponsaveis(field,event) {
         //  var e = (e)? e : event;
         var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
         var tecla = keyCode;
         if( tecla==9  ) return;
        /*    Vamos utilizar o objeto event para identificar 
              quais teclas est?o sendo pressionadas.       
              teclas 13 e 9 sao Enter e TAB
         */
        if( !(tecla >= 48 && tecla <= 57 ) && !( tecla==13  ||  tecla==9 ) ) {
           if( !(tecla >= 96 && tecla <= 105 )  ) {
              /* A propriedade keyCode revela o Código ASCII da tecla pressionada. 
                Sabemos que os n?meros de 0 a 9 est?o compreendidos entre 
                os valores 48 e 57 da tabela referida. Ent?o, caso os valores 
                não estejam(!) neste intervalo, a fun??o retorna falso para quem
                a chamou.  Menos keyCode igual 13  */
               document.getElementById(field.id).value="";
               alert("Apenas N?MEROS s?o aceitos!");
               field.focus();
               field.select();
               return false;
           }
        }
     if(  tecla==13  ||  tecla==9  ) {
         alert(" ENTER OU TAB - field  = "+field +" - value = "+value+" - tecla = "+tecla)
         return;
    }
}
//  tag input type button - buscar coautores
function  buscacoresponsaveis(m_id) {
    var valor_id = document.getElementById(m_id).value;
    document.getElementById("busca_autores").disabled=true;
    if( valor_id>0 ) { 
         document.getElementById("busca_autores").disabled=false;
         document.getElementById("busca_autores").focus();
    }
}
// Function retorna para o mesmo campo
function retornar_cpo(m_id) {
   document.getElementById(m_id).focus();
   return ;
}
//
//
// VERIFICA SE DATA FINAL ? MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)
var m_erro=0;
function verificar_datas(dtinicial_nome, dtfinal_nome, dtInicial, dtFinal) {
    document.getElementById("label_msg_erro").style.display="none";
    document.getElementById("label_msg_erro").innerHTML='';              
    var dtini_nome = dtinicial_nome;
    var dtfim_nome = dtfinal_nome;
    var dtini = dtInicial;
    var dtfim = dtFinal;
    
    if ((dtini == '') && (dtfim == '')) {
        // alert('Complete os Campos.');
        //  campos.inicial.focus();
        //  return false;
        m_corrigir = confirm("Digitar as datas?"); 
        if ( m_corrigir ==true ) {   // testa se o usuario clicou em cancelar
              document.getElementById("label_msg_erro").style.display="block";
              msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
           final_msg_erro = '</span></p>';
              msg_erro = msg_erro+'&nbsp;Digitar as datas'+final_msg_erro;
                document.getElementById("label_msg_erro").innerHTML=msg_erro;
                document.getElementById(dtini_nome).focus();    
                //    return false;            
             m_erro = 1;
             return m_erro;
        } else if( m_corrigir == false ) { 
            m_erro = 0;
            return m_erro;
        }
    }
    
    datInicio = new Date(dtini.substring(6,10), 
                         dtini.substring(3,5), 
                         dtini.substring(0,2));
    datInicio.setMonth(datInicio.getMonth() - 1); 
    
    
    datFim = new Date(dtfim.substring(6,10), 
                      dtfim.substring(3,5), 
                      dtfim.substring(0,2));
                     
    datFim.setMonth(datFim.getMonth() - 1); 

    if(datInicio <= datFim){
         // alert('Cadastro Completo!');
        m_erro = 0;
        return m_erro;
        //  return true;
    } else {
        alert('ATEN??O: Data Inicial ? MAIOR que Data Final');
        document.getElementById("label_msg_erro").style.display="block";
          document.getElementById("label_msg_erro").innerHTML="";
          msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
           final_msg_erro = '</span></p>';
          msg_erro = msg_erro+'Data Inicial ? MAIOR que Data Final'+final_msg_erro;
         document.getElementById("label_msg_erro").innerHTML=msg_erro;
               //  document.getElementById(dtini_nome).focus();    
         m_erro = 1;
      //     return m_erro;
   }    
}
/*
       Funcao para incluir arquivo do Javascript
*/
function include_arq(arquivo){
    //  By An?nimo e Micox - http://elmicox.blogspot.com
   var novo = document.createElement("<script>");
   novo.setAttribute('type', 'text/javascript');
   novo.setAttribute('src', arquivo);
     document.getElementsByTagName('body')[0].appendChild(novo);
  // document.getElementsByTagName('head')[0].appendChild(novo);
   //apos a linha acima o navegador inicia o carregamento do arquivo
   //portanto aguarde um pouco at? o navegador baix?-lo. :)
}
//
//  Limpar os campos do opcao=="CONJUNTO"
function limpar_campos(new_elements) {
        /*  M?todo slice
            Obt?m uma sele??o de elementos de um array.
        */  
        var m_elementos = new_elements.slice(1,new_elements.length);       
          for( x=0; x<m_elementos.length; x++ ) {
              var limpar_cpo = "td_"+m_elementos[x];
              document.getElementById(limpar_cpo).style.display="none";
         }                                              
}
//
function mensg_erro(dados,m_erro,array_ids) {
 //   if( m_erro=="msg_erro1" ) {
         if ( typeof(array_ids)=="object" &&  array_ids.length ) {
             for ( i=0 ; i<array_ids.length ; i++ ) document.getElementById(array_ids[i]).style.display="none";
         }
         //  Tem que ter esses  document.getElementById
         document.getElementById('label_msg_erro').style.display="block";
         document.getElementById(m_erro).innerHTML=dados;
 //    }
}
///
</script>