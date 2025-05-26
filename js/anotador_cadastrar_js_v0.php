<?php
//
// Verificando conexao  - PARA CADASTRAR - PROJETO/ANOTADOR   js
//
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
///
?>
<script language="JavaScript" type="text/javascript">
/**
     JavaScript Document  - 20250523
      - arquivo anotador_cadastrar_js
    Define o caminho HTTP  -  20180416
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
//
//   funcrion acentuarAlerts - para corrigir acentuacao
//  Criando a function  acentuarAlerts(mensagem)
function acentuarAlerts(mensagem) {
    //
    //  Paulo Tolentino
    /**  Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));  */
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
/***   Final  -- function acentuarAlerts(mensagem)   */
//
//   Dados pra enviar ao arquivo AJAX
function enviar_dados_cad(source,val,string_array) {
    //
    // Verificando se a function exoc existe 
    if(typeof exoc=="function" ) {
         ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc não existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
    //
    //  Verificando variaveis recebidas
    if( typeof(source)=="undefined" ) var source=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";
    if( typeof(val)=="string" ) var val_upper=val.toUpperCase();
    //
    // Verifica se a variavel e uma string
    var source_maiusc=""; var source_array_pra_string="";  
    if( typeof(source)=='string' ) {
        //  source = trim(string_array);
        //  string.replace - Melhor forma para eliminiar espa?os no comeco e final da String/Variavel
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
     //
     poststr="";
     //
     //  variavel opcao igual a  source maiuscula
     var opcao = source.toUpperCase();
     //
     // tag Select para retornar
     var quantidade=opcao.search(/PROJETO|RESET|LIMPAR/ui);  

 /**  
 alert(" anotador_cadastrar_js/132 - INICIO ->>  source = "+opcao+" -- val = "+val+"  -  string_array ="+string_array+" \r\n quantidade = "+quantidade);
      */    
     
     if( quantidade!=-1 ) {
         //
         var retornar=0;
         if( opcao=="PROJETO" ) {
             //
             //  Caso idopcao estiver  nula
             if( val.length<1 )  {
                 //  Retornar na pagina - reset 
                 var retornar=1;
             } else {
                //
                //  Ativando a Tag Select do Nome do novo Anotador
                //  exoc("codigousp",1);
                if( document.getElementById("codigousp") ) {
                    //
                    if( document.getElementById("codigousp").style.display=="none"  ) {
                         exoc("codigousp",1);
                    } else {
                        document.getElementById("codigousp").disabled=false;    
                    }
                    //
                } 
                // 
                return;          
                //
             }
             //
        }
        /**  Final - if( opcao=="PROJETO" ) { */  
        //
        //  if( opcao=="RESET" ) var retornar=1;
        if( opcao.search(/^(RESET|LIMPAR)/ui)!=-1 ) var retornar=1;
         /*****    
            *   Reiniciar a pagina atual 
            *     - utilizar a variavel paginal_local
         ***/
        if( retornar==1 ) {
             //
             /**  Desativando/Ocultando a Tag Select do Nome do novo Anotador  */  
             exoc("codigousp",0);  
             //
             //  Reiniciando a pagina
             //   parent.location.href=pagina_local;     
             parent.location.reload();            
             //
             return;
             //
        }    
        /**   Final - if( retornar==1 ) {  */
        //
     }
     /**  Final - if( quantidade!=-1 ) {  */    
     //
     if( opcao=="ANOTADOR" ) { 
        //
        if( val.toUpperCase()=="CODIGOUSP" ) {  
             //
             if( document.getElementById('td_proj_ou_expe') ) {
                 //
                var lcelem=ddocument.getElementById('td_proj_ou_expe');
                var tdisp =  lcelem.style.display;
                if( tdisp!="none" ) {
                    lcelem.style.display="none";   
                }
                //
                 if( document.getElementById('nome') ) {
                     document.getElementById('nome').title="";            
                 }
                 ///
            }
            //
            if( string_array.toUpperCase()=="OUTRO"  ) {
                //
                // Verificar pra nao acusar erro
                if( document.getElementById('td_proj_ou_expe') ) {
                      //
                      var lcelem=document.getElementById('td_proj_ou_expe');
                      var tdisp =  lcelem.style.display;
                      if( tdisp!="block" ) {
                           lcelem.style.display="block";   
                       }
                       //
                       if( document.getElementById('nome') ) {
                            document.getElementById('nome').title="Digitar nome";                                  
                       }
                       //
                }
                /**  Final - if( document.getElementById('td_proj_ou_expe') ) { */
                //
            
             } 
             /**  Final - if( document.getElementById('td_proj_ou_expe') ) {  */
             //
             var poststr ="source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);
             var poststr =+"&m_array="+escape(string_array);
             ///
        } 
        /**  Final - if( val.toUpperCase()=="CODIGOUSP" ) {  */  
        //
     }  
     /**  Final - if( opcao=="ANOTADOR" ) {   */
     //
   
     /**  
   alert(" LINHA241 -->> poststr="+poststr);
      */

     //
	 if( opcao=="SUBMETER" ) {
          //
	  	  var frm = string_array;
    	  var m_elements_total = frm.length; 
          ///
          var m_erro = 0; var n_coresponsaveis= new Array(); 
		  var n_i_coautor=0;   var n_senhas=0;  var n_testemunhas=0; 
          var n_datas=0; var arr_dt_nome = new Array(); var arr_dt_val = new Array();
		  var campo_nome="";   var campo_value=""; var m_id_value="";
          for( i=0; i<m_elements_total; i++ ) {      
		       ///  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
		       var m_id_name = frm.elements[i].name;
	           var m_id_type = frm.elements[i].type;
	           var m_id_title = frm.elements[i].title;
	           var m_id_value = frm.elements[i].value;
	
         /**  
        //// alert("cpo#"+i+"  nome="+m_id_name+"  tipo="+m_id_type+"  valor="+m_id_value);
            */

               
    		   switch (m_id_type) {
                    case "undefined":
                    ///  case "hidden":				 
                    case "button":
                    case "image":
                    case "reset":
                       continue;
               }
			   ////
			   if( m_id_type=="checkbox" ) {
                   ///  Verifica se o checkbox foi selecionado
                   if( ! elements[i].checked ) var m_erro = 1;
               } else if ( m_id_type=="password" ) {
                   /// Verifica se a Senha foi digitada
		           m_id_value = trim(document.getElementById(m_id_name).value);
                   if( m_id_value.length<8 ) {
                        var m_erro = 1;      
                   } else {
                       ///  Verficando se tem dois campos senha e outro para confirmar
                       if( ( m_id_name.toUpperCase()=="SENHA" ) || ( m_id_name.toUpperCase()=="REDIGITAR_SENHA" ) ) {
                             n_senhas=n_senhas+1;
                       }                     
                   }                 
               } else if( m_id_type=="text" ) {  
			       m_id_value = trim(document.getElementById(m_id_name).value);
				   if( m_id_value=="" ) {
                       var m_erro = 1;       
                   } else {
                       ///  Se campo for usuario ou  senha
                       if( ( m_id_name.toUpperCase()=="LOGIN" ) || ( m_id_name.toUpperCase()=="SENHA" ) ) {
                              if( m_id_value.length<8 )  var m_erro = 1;    
                       }
                       if( ( m_id_name.toUpperCase()=="CORESPONSAVEIS" ) || ( m_id_name.toUpperCase()=="COLABS" ) ) {
                           ///  if( ( m_id_name.toUpperCase()=="COAUTORES" ) ) {                     
                            var co_aut_col = "coresponsaveis";
                            if( m_id_name.toUpperCase()=="COLABS" ) co_aut_col="colabs" ;
                            if( co_aut_col=="colabs" ) {
                                  var confirm_text = "Colaboradores";
                            } else {
                                 var confirm_text = "Co-Respons?veis";
                            }
                            var m_value_coresponsaveis=0;
                            ///  "coresponsaveis"
                            m_value_coresponsaveis=document.getElementById(co_aut_col).value;
                            /// m_value_coresponsaveis=document.getElementById("coautores").value;    
                           if( ( parseInt(m_id_value)<1 ) || ( m_id_value=="" ) ) {
                                 m_value_coresponsaveis=0;
                                /*
                              var decisao = confirm("Digitar n?mero de "+confirm_text+"?");
                              if ( decisao ) {
                                  m_erro = 1;
                              } else {
                                 m_value_coresponsaveis=0;
                                 m_erro = 0;
                              }
                              */
                           } 
                           //
                       }  
                       ///  Final do IF  CORESPONSAVEIS ou COLABS 
                       //
                       if( m_erro<1 ) {
                           //
                           //  Verificando as datas
                           //
                           //  Verificando o campo email                          
                           var m_email = /(EMAIL|E_MAIL|USER_EMAIL)/i;
                           if( m_email.test(m_id_name) ) {
                                var resultado = validaEmail(m_id_name);  
                                if( resultado===false ) return;
                           }
                           //                      
                       }   
                       //
                  }				  
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
                            if( decisao ) {
							 	m_erro=1;
                            } else {
								m_erro=0;
                            }
					  } else {
						   n_testemunhas=n_testemunhas+1;
					  }
					  ///
				  }
                 ///
			 } else if( m_id_type=="file" ) {  
			      m_id_value = trim(document.getElementById(m_id_name).value);
				  if( m_id_value=="" ) {
					   var m_erro=1;	
				  } else {
					  var tres_caracteres = m_id_value.substr(-3);  
				      var pos = tres_caracteres.search(/pdf/i);
					  /// Verificando se o arquivo formato pdf
					  if( pos==-1 ) {
					  	  m_erro=1; m_id_title="Arquivo precisa ser no formato PDF.";
					  }
				  }
			 }
             //  Verificando os coautores ou colaboradores
             var pos = m_id_name.search(/ncoautor/i);
			 if( pos!=-1 ) {
 			         m_id_value = trim(document.getElementById(m_id_name).value);
					 n_coresponsaveis[n_i_coautor]=m_id_value;
					 n_i_coautor++;
             } 			 
 	 		 if( m_id_name.toUpperCase()=="ENVIAR" ) {
				 if( m_value_coresponsaveis>1 ) {
                      ///  You can define the comparing function here. 
					  ///  JS default uses a crappy string compare. 					 
					  var duplicado = 0;
                      var sorted1_arr=n_coresponsaveis.sort(); 
                      var tot_n_c=n_coresponsaveis.length;
                      for( var i=0; i<=tot_n_c; i++ ) { 
					 	   for( var y=0; y<=tot_n_c; y++ ) { 
						         if( ( sorted1_arr[i]==sorted1_arr[y] ) && ( i!=y ) ) {
									   duplicado=1; 
     	    					       m_id_title="Duplicado"; m_erro=1;									
									   break;
								 }
						   }
						   /*
                           if( duplicado==1 ) {
	    					  m_id_title="Duplicado"; m_erro=1;
							  break;
					       } 
						   */
                      } 
				 }
 				 ///  Verificando as testemunhas
			     if( ( n_testemunhas==2 ) && ( m_erro<1 ) ) {
                        ///  You can define the comparing function here. 
  					    ///  JS default uses a crappy string compare. 					 
					    var duplicado = 0;
                        var m_testemunha1=trim(document.getElementById("testemunha1").value); 
                        var m_testemunha2=trim(document.getElementById("testemunha2").value); 
                        if( m_testemunha1==m_testemunha2  ) {
	  					     duplicado=1;
	    				     var m_id_title="Duplicado"; 
						 	 var m_erro=1;
		    			} 
				 }
                 ///				 			 
			 }
			 ///
  			 ///  Verificando diferentes dados nos campos de Senha ( Senha e a Confirmacao )
			 if( ( n_senhas>1 ) && ( m_erro<1 ) ) {
				  senha1 = document.getElementById("senha").value;
	              senha2 =  document.getElementById("redigitar_senha").value;
	              if( senha1!=senha2 ) {
				 	   m_id_title="SENHAS DIFERENTES";
					   m_erro=1;
				  }
			 }
			 ///  IF quando encontrado Erro
             ///  Quando for campo sem title passar sem erro
             if( m_id_title.length<1 ) m_erro=0;
             
             ///  Verificando a data  FINAL
             var m_datas = /(datafinal|datafin|data_fin)/i;
             if( m_datas.test(m_id_name) )  {
                  if( m_id_value=="" ) m_erro=0;    
             } 
             ///  Final da verificacao do campo data final
             
			 if( m_erro==1 ) {
	              document.getElementById("label_msg_erro").style.display="block";
                  ///  document.getElementById("msg_erro").style.display="block";
 		          ///  document.getElementById("msg_erro").innerHTML="";
    		      var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
				  msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
     		      var final_msg_erro = "&nbsp;</span></span>";
				  m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
 				  msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
  				//  document.getElementById("msg_erro").innerHTML=msg_erro;	
                  document.getElementById("label_msg_erro").innerHTML=msg_erro;    
				  //  frm.m_id_name.focus();
				  //  document.getElementById(m_id_name).focus();
				  break;
			 }
			 ///
 		     campo_nome+=m_id_name+",";  
			 campo_value+=m_id_value+",";
             //
        /**    Teste    
            var testecponv = campo_nome+"\r\n  "+campo_value;
            alert("LINHA 311 - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro+"\r\n\r\n"+testecponv)            
         */   
	 		  if( m_id_name.toUpperCase()=="ENVIAR" )  break;
		 }		 
    	///  document.form.elements[i].disabled=true; 
		 if( m_erro==1 ) {
			   return false;
		 } else {
			  ///  Enviando os dados dos campos para o AJAX
			  if( m_value_coresponsaveis>0 ) {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value)+"&m_array="+encodeURIComponent(n_coresponsaveis);				 
			 } else {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);			 
             }
             ///
		 }  
         //
    }  
    /**   Final - if( opcao=="SUBMETER" ) {  */
    //
    /**    CODIGOUSP do ANOTADOR  para verificar se tem email  */
    if( opcao=="CODIGOUSP" ) {
         //
         var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);    
         //
 
       /**
        *     alert(" CODIGOUSP -  anotador_cadastrar_js/414 -  source = "+opcao+" -- opcao = "+opcao+"  --  val = "+val+" \r\n - poststr =  "+poststr);
        */  
    }
    /**  Final - if( opcao=="CODIGOUSP" )  { */
    //
    /**  Inicia a class do AJAX */
	var myConn = new XHConn();
    //
    /***  Um alerta informando da nao inclusao da biblioteca  
    *     IMPORTANTE: descobrir erros nos comandos - try e catch
    */
    try {
       if( !myConn ) {
            alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
            return false;
        }
    } catch(err) {
        //
        // Enviando mensagem de erro
        exoc("label_msg_erro",1,err.message);  
        //
    }
    //
    //  Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
    /** 
     *     ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
     */
     var receber_dados = "anotador_cadastrar_ajax.php";
     //
     /**   FUNCTION - PRINCIPAL NO RECEBIMENTO DE DADOS/RETONRO DO AJAX  */
	 var inclusao = function (oXML) { 
                  //
                  /**
                  *     Recebendo os dados do arquivo ajax
                  *    Importante ter trim no  oXML.responseText para tirar os espacos
                  */
                  var m_dados_recebidos = trim(oXML.responseText);
                  //
                  //  Verificando se houve ERRO
                  var pos = m_dados_recebidos.search(/ERRO:|FALHA:|Uncau|Fatal erro/ui);
                  //

/**  
  alert(" anotador_cadastrar_js.php/545 -->> INCLUSAO --  pos = "+pos+"  --- opcao = "+opcao+" - val = "+val+" -  \r\n m_dados_recebidos =  "+m_dados_recebidos);
      */                     
                      
                      if( pos!=-1 ) {
                           //
                           /**   Caso tiver palavras de Cadastro ou Corrigir campo   */ 
                           var pnhm = m_dados_recebidos.search(/NENHUM|cadastrad(a|o){1}/ui);
                           if( pnhm!=-1 ) {
                                var m_dados_recebidos = m_dados_recebidos.replace(/ERRO:|Corrigir campo/uig,"");
                           }
                           /**  Final - if( pnhm!=-1 ) {  */
                           //
                           /// Mensagem de erro ativar
                           var pos_porcent = m_dados_recebidos.search("%");
                           if( ! ( opcao=="CODIGOUSP" && pos_porcent!=-1 ) ) {     
                                //
                                exoc("label_msg_erro",1,m_dados_recebidos);   
                                return;
                           }     
                           //
                      }  
                      /**  Final - if( pos!=-1 ) {  */
                      //

/**  
  alert(" anotador_cadastrar_js.php/570 -->>  1) PARTE  --->> opcao = "+opcao+" - val = "+val
              +" -  \r\n m_dados_recebidos =  "+m_dados_recebidos) ;                        
     */          

                      //                         
                      // Verificando a opcao                        
                      if( opcao=="CODIGOUSP" ) {     
                          //
                          var array_e_mail = new Array('e_mail','email','e-mail','user_email');
                          var arr_e_mail_length = array_e_mail.length; 
                          //
                          //  Verificar que id pertence ao email
                          for( var i=0; i<arr_e_mail_length; i++ ) {
                               //
                               //  Verificando se existe id do e_mail
                               if( document.getElementById(array_e_mail[i]) ) {
                                    var e_mail=array_e_mail[i];   
                               }
                               //
                          }
                          /**  Final - for( var i=0; i<arr_e_mail_length; i++ ) {   */
                          //
                          /// Verificando caso encontrou erros
                          var pos = m_dados_recebidos.search(/ERRO:|NENHUM|FALHA/i);
                          
       /**  
  ///  alert(" anotador_cadastrar_js.php/513 -->>  pos = "+pos+"  --- opcao = "+opcao+" - val = "+val+" -  \r\n m_dados_recebidos =  "+m_dados_recebidos) ;                        
             */                               
                          
                          if( pos!=-1 ) {
                               //
                               // ERRO: campo nome ou e_mail
                               // document.getElementById('label_msg_erro').style.display="block";
                              var array_nome = m_dados_recebidos.split("%");
                              if( array_nome.length>1 ) { 
                                  // 
                                  var texto0=array_nome[0];
                                  //
                                  // Ativando o ID label_msg_erro com mensagem
                                  exoc("label_msg_erro",1,texto0);                                  
                                  //
                                  //  Verificando se existe id do tr_nome e id nome 
                                  var texto1=array_nome[1];
                               
       /**  
 ///    alert(" anotador_cadastrar_js.php/540 -->> div_nome ou limpa nome  ---  opcao = "+opcao+" - val = "+val+" -  \r\n  texto1 = "+texto1);  
          */                                 

                                  if( val==-999999999  ) {
                                      exoc("div_nome",1,texto1);
                                  } else {
                                     exoc("div_nome",0);
                                  }                                
                                  //  
                              }
                              /**  Final - if( array_nome.length>1 ) {  */
                              //
                              //  Caso elemento ID e_mail existir
                              if( document.getElementById(e_mail) ) {
                                  document.getElementById(e_mail).style.display="block";                                
                                  document.getElementById(e_mail).disabled=false;
                                  document.getElementById(e_mail).value="";
                              }
                              //
                          } else {                                
                              //
                              var array_nome_email = m_dados_recebidos.split("#");
                              ///  Verificando se existe id do tr_nome - 
                              ///  e id nome ocultar pois aparece na tag Select
                              exoc("div_nome",0,"");                                  
                              /*
                                if( document.getElementById("div_nome")  ) {
                                     document.getElementById("div_nome").style.display="none";
                                }
                                */
                              ///  Caso elemento ID e_mail existir
                              if( document.getElementById(e_mail) ) {
                                  document.getElementById(e_mail).style.display="block";
                                  document.getElementById(e_mail).value=array_nome_email[1];
                                  document.getElementById(e_mail).disabled=true;
                              } 
                              ///
                              return;
                              ///
                          }
                          //
                      } else if( opcao=="ANOTADOR" ) {     
                          ///
                          if( val.toUpperCase()=="CODIGOUSP" ) {  
                                //
                                document.getElementById('label_msg_erro').style.display="none";
                                var new_elements = m_dados_recebidos.split("|");
                                var temp = trim(new_elements[0]);
                                var campo_nome = temp.split(",");
                                var m_length = campo_nome.length;
                                var cpo_id="";
                                var x=0; var i=0; 
                                if( document.getElementById("senha") ) {
                                     document.getElementById("senha").disabled=false;   
                                }
                                if( document.getElementById("redigitar_senha") ) {
                                     document.getElementById("redigitar_senha").disabled=false;
                                }    
                                while( i<m_length ){
                                      cpo_id=campo_nome[i];
                                      x=i+1;                                             
                                      if( trim(new_elements[x])!="" ) {
                                            document.getElementById(cpo_id).value=new_elements[x];
                                            document.getElementById(cpo_id).disabled=true;
                                            ///  Verificando o login/username/user_name
                                            var m_login = /(LOGIN|USERNAME|USER_NAME|USUARIO)/i;
                                            if( m_login.test(cpo_id) ) {
                                                 if( document.getElementById("senha") ) {
                                                       document.getElementById("senha").disabled=true;
                                                 }
                                                 if( document.getElementById("redigitar_senha") ) {
                                                      document.getElementById("redigitar_senha").disabled=true;  
                                                 } 
                                            }                                                                     
                                      } else {
                                            document.getElementById(cpo_id).disabled=false;  
                                            document.getElementById(cpo_id).value="";
                                      }                                                     
                                      i++;
                                }
                          }  
                          //                                                                     
					  } else {
						  var pos = m_dados_recebidos.search(/ERRO:/i);
                          if( document.getElementById('corpo') ) {
                              document.getElementById('corpo').style.display="block";   
                          }
         		          if( pos!=-1 ) {
						      /// document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                              /// Ativando o ID label_msg_erro com mensagem
                              exoc("label_msg_erro",1,m_dados_recebidos);                                  
						  } else {
                              ///
 					          if( opcao=="SUBMETER" ) {
								  ///  Recebendo o numprojeto e o num do autor
								  var test_array = m_dados_recebidos.split("falta_arquivo_pdf");
								  if( test_array.length>1 ) {
    								   m_dados_recebidos=test_array[0];
									   var n_co_autor = test_array[1].split("&");
									   ///  Passando valores para tag type hidden
							  		   document.getElementById('nprojexp').value=n_co_autor[0];
     								   document.getElementById('autor_cod').value=n_co_autor[1];
                                       if(  n_co_autor.length==3 ) {
                                           ///  ID da pagina anotacao_cadastrar.php
                                           document.getElementById('anotacao_numero').value=n_co_autor[2];
                                       }
								  }
   								  /// document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                  /// Ativando o ID label_msg_erro com mensagem
                                  exoc("label_msg_erro",1,m_dados_recebidos);                                  
                                      
                                  /// Verificar pra nao acusar erro
                                  if( document.getElementById('arq_link') ) {
                                      document.getElementById('arq_link').style.display="block";        
                                  }
                                  ///
                                  ///  Desativando/Ocultando a Tag Select do Nome do novo Anotador
                                  exoc("codigousp",0);  
                                 
                                  ///  Campo email - desativando/ocultando
                                  var array_e_mail = new Array('e_mail','email','e-mail','user_email');
                                  var arr_e_mail_length = array_e_mail.length;
                                  ///  Verificar que id pertence ao email
                                  for( var i=0; i<arr_e_mail_length; i++ ) {
                                      ///  Verificando se existe id do e_mail
                                      if( document.getElementById(array_e_mail[i]) ) {
                                            var e_mail=array_e_mail[i];   
                                            ///  Caso exista ocultar
                                            exoc(e_mail,0);  
                                      }
                                  }
                                  ///  Reiniciando a tag Select do Projeto
                                  if( document.getElementById("projeto") ) {
                                        document.getElementById("projeto").selectedIndex="0";
                                  } 
                                  ///  document.getElementById('div_form').innerHTML=m_dados_recebidos;
                                  return;
							  } else  {
                                  if( document.getElementById('corpo') ) {
                                       document.getElementById('corpo').innerHTML=oXML.responseText;     
                                  } 
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
       ///
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
//  Funcao para alinhar o campo
function alinhar_texto(id,valor) {
    var id_valor = document.getElementById(id).value;
    document.getElementById(id).value=trim(id_valor);
   return;
}
//
//  Nr. de coautores - enviar para cria-los
function n_coresponsaveis(field,event) {
         // 
         //  var e = (e)? e : event;
		 var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
         var tecla = keyCode;
		 if( tecla==9  ) return;
         /**   Vamos utilizar o objeto event para identificar 
         *     quais teclas est?o sendo pressionadas.       
         *     teclas 13 e 9 sao Enter e TAB
         */
        if( !(tecla >= 48 && tecla <= 57 ) && !( tecla==13  ||  tecla==9 ) ) {
            //
           if( !(tecla >= 96 && tecla <= 105 )  ) {
               /**  A propriedade keyCode revela o Código ASCII da tecla pressionada. 
                  Sabemos que os n?meros de 0 a 9 est?o compreendidos entre 
                  os valores 48 e 57 da tabela referida. Ent?o, caso os valores 
                  não estejam(!) neste intervalo, a fun??o retorna falso para quem
                  a chamou.  Menos keyCode igual 13 
              */
               document.getElementById(field.id).value="";
               //
		       alert("Apenas NÚMEROS são aceitos!");
               //
			   field.focus();
               field.select();
		       return false;
		   }
           //
		}
        //
        if(  tecla==13  ||  tecla==9  ) {
             alert(" ENTER OU TAB - field  = "+field +" - value = "+value+" - tecla = "+tecla)
             return; 
    	} 
        //
}  
//
/**  tag input type button - buscar coautores  */
function  buscacoresponsaveis(m_id) {
    //
    var valor_id = document.getElementById(m_id).value;
    document.getElementById("busca_autores").disabled=true;
    if( valor_id>0 ) { 
         document.getElementById("busca_autores").disabled=false;
         document.getElementById("busca_autores").focus();
    }
    //
}
//
// Function retorna para o mesmo campo
function retornar_cpo(m_id) {
   document.getElementById(m_id).focus();
   return ;
}
//
//
/**   VERIFICA SE DATA FINAL ? MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)   */
var m_erro=0;
function verificar_datas(dtinicial_nome, dtfinal_nome, dtInicial, dtFinal) {
    //
	document.getElementById("label_msg_erro").style.display="none";
	document.getElementById("label_msg_erro").innerHTML='';			  
	var dtini_nome = dtinicial_nome;
	var dtfim_nome = dtfinal_nome;
	var dtini = dtInicial;
	var dtfim = dtFinal;
	//
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
		    	//	return false;			
		     m_erro = 1;
			 return m_erro;
        } else if( m_corrigir == false ) { 
		    m_erro = 0;
			return m_erro;
		}
        //
	}
	//
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
		alert('ATENÇÃO: Data Inicial ? MAIOR que Data Final');
		document.getElementById("label_msg_erro").style.display="block";
     	 document.getElementById("label_msg_erro").innerHTML="";
 	     msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
		   final_msg_erro = '</span></p>';
    	  msg_erro = msg_erro+'Data Inicial ? MAIOR que Data Final'+final_msg_erro;
		 document.getElementById("label_msg_erro").innerHTML=msg_erro;
   	   	 //  document.getElementById(dtini_nome).focus();	
	     m_erro = 1;
	  //	 return m_erro;
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
 //	}
}
///
</script>