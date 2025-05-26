<?php
//
// Cadastrar Participante -  js
//
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
//
?>
<script language="JavaScript" type="text/javascript">
/*
     JavaScript Document  - 20180605
     arquivo participante_cadastrar_js
*/
/****  
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
///
///  funcrion acentuarAlerts - para corrigir acentuacao
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
/*****    PARA CADASTRAR  PARTICIPANTE - PROJETO/ANOTACAO      ******/
function enviar_dados_cad(source,val,string_array) {
    ///
    ///  Ocultando ID  e utilizando na tag input comando onkeypress
    exoc("label_msg_erro",0,""); 
    ///
   
   ///  Verificando variaveis
    if( typeof(source)=="undefined" ) var source=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";
    if( typeof(val)=="string" ) var val_upper=val.toUpperCase();
    
    // Verifica se a variavel e uma string
    var source_maiusc=""; var source_array_pra_string="";  
    if( typeof(source)=='string' ) {
       //  source = trim(string_array);
       //  string.replace - Melhor forma para eliminiar espa?os no comeco e final da String/Variavel
       source = source.replace(/^\s+|\s+$/g,"");        
       source_maiusc = source.toUpperCase();     
       var pos = source.indexOf(",");     
       if( pos!=-1 ) {  
           //  Criando um Array 
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
    /// Variavel source para maiuscula
    var opcao = source.toUpperCase();
     /****  
         Define o caminho HTTP    -  20180605
     ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       
    ///  SESSION caso for DESKTOP ou MOBILE
    var estilocss="<?php echo  $_SESSION["estilocss"];?>";       
    ///
     /*****    
     *   Reiniciar a pagina atual 
     *     - utilizar a variavel paginal_local
     */
     if( opcao=="RESET" ) {
         parent.location.href=pagina_local;                
         return;   
     }
     ///      
    ///   Criando os campos instituicao, unidade, departamento, setor 
	if( opcao=="ANOTACAO" ) { 
        //  AUTOR/ANOTADOR E  ORIENTADOR/SUPERVISOR
		var msa = trim(string_array);
		var voltar = 1; var enviar=0;
        // if( ( val.toUpperCase()=="PROJETO" || val.toUpperCase()=="AUTOR"  ) &&  msa.length>=1 ) {
        if( ( val.toUpperCase()=="PROJETO" ) &&  msa.length>=1 ) {
			  voltar=0; enviar=1;
		} else if( ( val.toUpperCase()=="ALTERA_COMPLEMENTA" ) &&  msa.length>=1 ) {
			if( msa=="0" ) {
                // document.getElementById("td_altera_complementa").style.display="none";
                document.getElementById("td_altera_complementa").innerHTML="";
                return;
            }    
			voltar=0;  enviar=1;
		}
		//   Desativando TD - ocorrendo erro
		if( voltar==1 ) {
    	   if( val.toUpperCase()=="PROJETO" )   document.getElementById("nr_anotacao").style.display="none";
           //  AUTOR/ANOTADOR E  ORIENTADOR/SUPERVISOR
		   //  if( val.toUpperCase()=="AUTOR" ) {
           // if( val.toUpperCase()=="SUPERVISOR" ) {    alterado:110905.1129
           if ( val.toUpperCase()=="PROJETO") {
			  if( document.getElementById("novo_td") ) document.getElementById("tr_coord_proj").removeChild("novo_td");
		   } 
		}
		if( enviar==1 ) {
    	      var m_array = string_array.split("|");
              var poststr="source="+encodeURIComponent(source)+"&val=";
			  poststr=poststr+encodeURIComponent(val)+"&m_array="+encodeURIComponent(m_array);
		}
		if( voltar==1 ) return;
	}
    ///    
    if( ( typeof(string_array)!='undefined') && ( opcao=="CONJUNTO" )  ) {
               //  IF Instituicao - Outra caso tiver na Tabela
               if( val.toUpperCase()=="OUTRA" ) {
                   source="PESSOAL";val="OUTRA";
                   if( document.getElementById("outros_campos") ) document.getElementById("outros_campos").style.display='none';
                   return;
               } 
               if( document.getElementById("outros_campos") ) document.getElementById("outros_campos").style.display='block';
			      var m_array = string_array.split("|");
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
                                  if( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                                       n_sel_opc=3;   
                                       var id_cpo_array = ["td_salatipo","td_sala"];                         
                                       for( var j=0; j<id_cpo_array.length; j++ ) {
                                            if( document.getElementById(id_cpo_array[j]) ) {
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
    
  /// alert("participante_cadastrar_js/87 -INICIO-  source = "+opcao+" -- val = "+val+" --  string_array = "+string_array);    
    
    
	if( opcao=="SUBMETER" ) {
         ///  FORM e elementos
		 var frm = string_array;
    	 var m_elements_total = frm.length; 
         //
         //  Desativar mensagem
     	 var m_erro = 0; var n_coresponsaveis= new Array(); 
		 var n_i_coautor=0;   var n_senhas=0;  var n_testemunhas=0; 
          var n_datas=0; var arr_dt_nome = new Array(); var arr_dt_val = new Array();
		  var campo_nome="";   var campo_value=""; var m_id_value="";
         for( i=0; i<=m_elements_total; i++ ) {      
		    //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
		    var m_id_name = frm.elements[i].name;
	        var m_id_type = frm.elements[i].type;
	        var m_id_title = frm.elements[i].title;
   // alert("cpo#"+i+"  nome="+m_id_name+"  tipo="+m_id_type+"  valor="+frm.elements[i].value)
       		 switch (m_id_type) {
                  case "undefined":
                  //  case "hidden":				 
                  case "button":
                  case "image":
                  case "reset":
                  continue;
             }
			 if( m_id_type== "checkbox" ) {
                  ///  Verifica se o checkbox foi selecionado
                  if( ! elements[i].checked ) var m_erro = 1;
             } else if( m_id_type=="password" ) {
                  /// Verifica ID tab_senha da tag table - Ativada ou Desativada
                  if( document.getElementById('tab_senha') ) {
                       var x = document.getElementById('tab_senha');
                       if( x.style.display==='none') {
                           continue;
                       }  else {
                           var cposenha_redigitar=document.getElementById(m_id_name);
                           /// LIberando os campos de senha - senha e redigitar
                           cposenha_redigitar.style.display="block";
                       }
                  }
                  /// Verifica se a Senha foi digitada
                  if( typeof(cposenha_redigitar)!="undefined" ) {
                      ///  Verificando se esta ativo
                       if( cposenha_redigitar.style.display==='block') {
                             var m_id_value = trim(document.getElementById(m_id_name).value);                   
                             if(  m_id_value.length<8 ) {
                                 var m_erro = 1;      
                             }  else {
                                 ///  Verficando se tem dois campos senha e outro para confirmar
                                 if( ( m_id_name.toUpperCase()=="SENHA" ) || ( m_id_name.toUpperCase()=="REDIGITAR_SENHA" ) ) {
                                      n_senhas=n_senhas+1;
                                 }                     
                             }                 
                       }  else {
                           alert(m_id_name+" desativado.")
                       }               
                  }
                  ///
             } else if( m_id_type=="text" ) {  
			      m_id_value = trim(document.getElementById(m_id_name).value);
				  if( m_id_value=="" ) {
                      var m_erro = 1;       
                  }  else {
                      //  Se campo for usuario ou  senha
                     if( ( m_id_name.toUpperCase()=="LOGIN" ) || ( m_id_name.toUpperCase()=="SENHA" ) ) {
                             if( m_id_value.length<8 )  var m_erro = 1;    
                     }
                     if( m_erro<1  ) {
                          //
                          //  Verificando o campo email                          
                          var m_email = /(EMAIL|E_MAIL|USER_EMAIL)/i;
                          if( m_email.test(m_id_name) ) {
                                 var resultado = validaEmail(m_id_name);  
                                 if( resultado===false  ) return;
                          }                      
                     }   
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
			 ////
             
///  alert(" LINHA/319  - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro);

			 //  Verificando diferentes dados nos campos de Senha ( Senha e a Confirmacao )
			 if( ( n_senhas>1 ) && ( m_erro<1 ) ) {
				 senha1 = document.getElementById("senha").value;
	             senha2 =  document.getElementById("redigitar_senha").value;
	             if( senha1!=senha2 ) {
					 m_id_title="SENHAS DIFERENTES";
					 m_erro=1;
				 }
			 }
			 //  IF quando encontrado Erro
             //  Quando for campo sem title passar sem erro
             if( m_id_title.length<1 ) m_erro=0;
             
             //  Verificando a data  FINAL
             var m_datas = /(datafinal|datafin|data_fin)/i;
             if( m_datas.test(m_id_name) )  {
                 if( m_id_value=="" ) m_erro=0;    
             } 
             //  Final da verificacao do campo data final
             
			 if( m_erro==1 ) {
	              document.getElementById("label_msg_erro").style.display="block";
               //   document.getElementById("msg_erro").style.display="block";
 			//	 document.getElementById("msg_erro").innerHTML="";
    		      var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
				  msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
     		      var final_msg_erro = "&nbsp;</span></span>";
				  m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
 				  msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
  				  ////  document.getElementById("msg_erro").innerHTML=msg_erro;	
                  document.getElementById("label_msg_erro").innerHTML=msg_erro;    
				  //  frm.m_id_name.focus();
				  //  document.getElementById(m_id_name).focus();
				  break;
			 }
             //                 
            //  MELHOR IF PARA NAO ACRESCENTAR O CAMPO - REDIGITAR_SENHA
             if( m_id_name.toUpperCase()!="REDIGITAR_SENHA"  )  {
                  campo_nome+=m_id_name+",";  
                  campo_value+=m_id_value+",";               
             }
      		 if( m_id_name.toUpperCase()=="ENVIAR" ) {
                   break; 
             }  
		 }		 
    	///  document.form.elements[i].disabled=true; 
		 if( m_erro==1 ) {
			  return false;
		 } else {
			  ///  Enviando os dados dos campos para o AJAX
               if( document.getElementById("codigousp") ) {
                   var string_array = document.getElementById("codigousp").value;                    
               } 
               var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value)+"&m_array="+encodeURIComponent(string_array);			 
              ///
		 }
         ///
    }  ///  FINAL do IF SUBMETER
    
    //   Participante do Projeto
    if( opcao=="PARTICIPANTE" ||  opcao=="GERAR_SENHA" ) {
         ///  Desativar campo do PA -  Permissao de Acesso 
         /* Exemplo do resultado  do  Permissao de Acesso - criando array
                      +-------------+--------+
                      | descricao   | codigo |
                      +-------------+--------+
                      | super       |      0 | 
                      | chefe       |     10 | 
                      | vice        |     15 | 
                      | aprovador   |     20 | 
                      | orientador |     30 | 
                      | anotador    |     50 | 
                      +-------------+--------+
          */
          if( opcao=="PARTICIPANTE" ) {
              if( document.getElementById("pa") ) {
                  document.getElementById('pa').options[0].selected=true;
                  document.getElementById('pa').options[0].selectedIndex=0;
              }                   
          }    
         
         
         var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array);                 
         ///
    }
  
    /*   Aqui eu chamo a class do AJAX */
	var myConn = new XHConn();
		
	/*  Um alerta informando da não inclus?o da biblioteca - AJAX   */
    if ( !myConn ) {
	      alert("XMLHTTP não dispon?vel. Tente um navegador mais novo ou melhor.");
		  return false;
    }
	///
	///  Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
    ///   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    var receber_dados = "participante_cadastrar_ajax.php";
    
    ///
	var inclusao = function (oXML) { 
                       ///  Recebendo os dados do arquivo ajax
                       ///  Importante ter trim no  oXML.responseText para tirar os espacos
                       var m_dados_recebidos = trim(oXML.responseText);
                       /// Caso houver erro 
                       var pos = m_dados_recebidos.search(/ERRO:|FALHA:/i);

 ////  alert("participante_cadastratr_js/299 -->>  pos = "+pos+"  -- opcao = "+opcao+"  \r\n m_dados_recebidos = "+m_dados_recebidos );                         
                         
                       /// Verifica se houve erro
                       if( pos!=-1 ) {
                           /// Mensagem de erro ativar
                           exoc("label_msg_erro",1,m_dados_recebidos);   
                           /*    document.getElementById('label_msg_erro').style.display="block";
                                      document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                 */
                           return;
                       }
                       ///         
      				   if(  opcao=="CONJUNTO" ) { 
						    ///  var m_elementos = "instituicao|unidade|depto|setor|bloco|salatipo|sala";
							var m_elementos = "instituicao|unidade|depto|setor|bloco|sala";
							var new_elements = m_elementos.split("|");
						    ///  Desativando alguns campos
							document.getElementById("label_msg_erro").style.display="none";
							if( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                                   limpar_campos(new_elements);
							}
							///  Verificando se tem proximo campo ou chegou no Final
							if( prox_cpo.length ) {
							    ///  Ativando a tag td com o campo
								var id_cpo = "td_"+prox_cpo;
								document.getElementById("tab_de_bens").innerHTML= "";
                                var lsinstituicao = m_dados_recebidos.search(/Institui??o/i);  
            	                var pos = m_dados_recebidos.search(/Nenhum|Erro/i);  
							    if( pos != -1 )  {
                                     if( lsinstituicao  == -1 ) {
								      	   limpar_campos(new_elements);
									       /// Voltar para o inicio da tag Select
					                       document.getElementById('instituicao').options[0].selected=true;
									       document.getElementById('instituicao').options[0].selectedIndex=0;
									       document.getElementById(id_cpo).style.display="none";
						                   mensg_erro(m_dados_recebidos,"label_msg_erro");
									       document.getElementById('instituicao').focus();
                                     }  
							    } else if( pos == -1 ) {
 							         if( n_sel_opc<=m_array_length ) {
                                            document.getElementById(id_cpo).style.display="block";
								            document.getElementById(id_cpo).innerHTML=m_dados_recebidos;
                                            ///                       
								     }
							    }
							}
                            ////
                       } else if( opcao=="PARTICIPANTE" ) {  /// Selecionado o Participante do Projeto
                              ///  Caso o participante NAO tenha senha
                             ///  IMPORTANTE: Verificar se o demilitador exista
                             var simbolo="#";
                             var m_dados_recebidos_lenght=m_dados_recebidos.length;
                             ///  var array_eu = m_dados_recebidos.split("#");     
                             var array_eu = m_dados_recebidos.split(simbolo);     
                             var array_eu_length=array_eu.length;
                             ///  Caso não tenha demilitador - simbolo #
                             var array_eu_length_0=array_eu[0].length;
                             ///  Comparando
                             if( parseInt(m_dados_recebidos_lenght)==parseInt(array_eu_length_0)  ) {
                                    var msg_erro="ERRO: variavel sem delimitador simbolo "+simbolo+" corrigir.";
                                    alert(msg_erro);
                                    /// Mensagem de erro ativar
                                    var m_dados_recebidos=msg_erro+"<br/>"+m_dados_recebidos;
                                    exoc("label_msg_erro",1,m_dados_recebidos);   
                                    return;
                                    ///
                             }                             

 ////  alert(" participante_cadastratr_js/364 -->>   opcao PARTICPANTE  <<-- "+m_dados_recebidos_lenght+" = "+ array_eu_length_0+"  E array_eu_length = "+array_eu_length+"  --- array_eu[2] ="+array_eu[2]+"   <->  \r\n m_dados_recebidos = "+m_dados_recebidos );                         
                                  
                             ///  Caso Participante contenha Senha na Tabela usuario
                             if( parseInt(array_eu_length)==3 ) {
                                  /// Desativar esse element ID tab_senha
                                   if( document.getElementById('tab_senha')  ) {
                                        var element_ts=document.getElementById('tab_senha');
                                        if( element_ts.style.display!="none"  ) {
                                              document.getElementById('tab_senha').style.display="none";
                                        }
                                   } 
                             }
                             /// Lista de emails para testar 
                             var n_emails=["email_participante","e_mail","email"];
                             ////  
                             for( j=0; j<n_emails.length ; j++ ) {
                                /// 
                                var tmp_email = n_emails[j];    
                                /// Verificando o nome do ID do email 
                                if( document.getElementById(tmp_email) ) {
                                    document.getElementById(tmp_email).style.display="block";
                                    document.getElementById(tmp_email).style.float="right";
                                    ///  Azul escuro
                                    document.getElementById(tmp_email).style.backgroundColor="#0300a0";
                                    /// atualizado em 20181130
                                    if( estilocss.toUpperCase()=="ESTILO.CSS" ) {
                                         document.getElementById(tmp_email).style.fontSize = "large";
                                    } else {
                                        document.getElementById(tmp_email).style.fontSize = "small";     
                                    }   
                                    document.getElementById(tmp_email).innerHTML=array_eu[0];
                                    break;
                                }
                             }    
                             ///
                             if( document.getElementById('tab_senha') ) {
                                  /// Variavel para ativar ou desativar ID - elemento
                                  var val_em_us=array_eu[1];
                                  ///  Ativa ou Deesativa o elemento ID tab_senha - block ou none
                                  ///  document.getElementById('tab_senha').style.display=array_eu[1];           
                                  document.getElementById('tab_senha').style.display=val_em_us;
                                        
                                  ///  Ativando
                                  ///  if( array_eu[1]=="block" ) var senha_value="";
                                 if( val_em_us=="block" ) {
                                      var senha_value="";  
                                      if( document.getElementById('senha') ) {
                                          document.getElementById('senha').value=senha_value;   
                                      } 
                                      if( document.getElementById('redigitar_senha') ) {
                                           document.getElementById('redigitar_senha').value=senha_value;         
                                      } 
                                 } 
                                 /// Caso none desativa 
                                 /// if( array_eu[1]=="none" ) var senha_value="**********";
                             }                                                               
                             ///
                       } else if( opcao=="GERAR_SENHA" ) {  /// Para Gerar Senha do Participante
                                 ///
                                var nova_senha = trim(m_dados_recebidos);
                                ///
  
  ////  alert(" participante_cadastrar_js.php/381 -  source = "+opcao+" -- val = "+val+"  -->>>  nova_senha = "+nova_senha)
                                
                               if( document.getElementById('senha') ) {
                                   document.getElementById('senha').value=nova_senha;   
                               }
                               if( document.getElementById('redigitar_senha') ) {
                                    document.getElementById('redigitar_senha').value=nova_senha; 
                               }
                               ////
					   } else {
                              ///                            
                              if( document.getElementById('corpo') ) {
                                     document.getElementById('corpo').style.display="block";  
                              } 
  					 	      document.getElementById('label_msg_erro').style.display="block";
                              
 ///  alert(" FINAL/PASSOU 487 - source = "+source+" - val = "+val+" - string_array = "+string_array+"  \r\n m_dados_recebidos = "+m_dados_recebidos);

   					 	          document.getElementById('label_msg_erro').style.display="none";	
								  if( opcao=="SUBMETER" ) {
   								         ////  document.getElementById('div_form').style.display="none";
                                        /*
                                        document.getElementById('label_msg_erro').style.display="block";    
                                        document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                        */
                                        ///  Ativando ID  label_msg_erro
                                        exoc("label_msg_erro",1,m_dados_recebidos); 
                                        
                                         ///  Retornar depois de cadastrado
                                         if( document.getElementById("div_form") ) {
                                               var parent = document.getElementById("div_form");                                     
                                               ///  Desativar FORM
                                               if( document.getElementById("form1") ) {
                                                    var child = document.getElementById("form1");
                                                    parent.removeChild(child);                                          
                                               }
                                               ///
                                               /// NOW CREATE AN INPUT BOX TYPE BUTTON USING createElement() METHOD.
                                                var button = document.createElement('input');

                                                // SET INPUT ATTRIBUTE 'type' AND 'value'.
                                                button.setAttribute('type', 'button');
                                                button.setAttribute('value', 'Retornar');
                                                button.setAttribute('class', 'botao3d');
                                           ////     button.setAttribute('style', 'margin-left: 50%; margin-right: 50%;');
                                                button.setAttribute('style', 'float: left: ');
                                                button.setAttribute('id', 'retornapagina');

                                                // ADD THE BUTTON's 'onclick' EVENT.
                                                /***
                                                var site='location.assign("http://sol.fmrp.usp.br")';
                                                button.setAttribute('onclick', site);
                                                ***/
                                                ///  var site="location.assign(pagina_local)";
                                                //// var site='location.assign("http://sol.fmrp.usp.br/rexp/mobile/cadastrar/pessoal_cadastrar.php")';
                                                ///  button.setAttribute('onclick', retornar_pagina(pagina_local));                                        
                                                
                                                // FINALLY ADD THE NEWLY CREATED TABLE AND BUTTON TO THE BODY.
                                               ///   document.body.appendChild(button);
                                                parent.appendChild(button);
                                                ///   Desse modo deu certo
                                                document.getElementById("retornapagina").onclick = function() { retornar_pagina(pagina_local);};
                                                ///
                                         }
                                         ///  Final - Retornar depois de cadastrado
                                        ///
								  } else {
                                       /*
                                         if( document.getElementById('corpo') ) {
                                              document.getElementById('corpo').innerHTML=oXML.responseText;     
                                         } 
                                         */
                                       ///  Ativando ID  corpo
                                       exoc("corpo",1,m_dados_recebidos); 
                                       ///
                                  }
                                  ///
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
//  Funcao para alinhar o campo
function alinhar_texto(id,valor) {
    var id_valor = document.getElementById(id).value;
    document.getElementById(id).value=trim(id_valor);
   return;
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
///
/****    Retornar pagina   *****/
function retornar_pagina(pagina_local) {
    /// Retornando 
    /// setTimeout(location.assign(pagina_local,99999999)   );    
    location.href=pagina_local;
}
/****  Final -  Retornar pagina   *****/
///
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
		    	//	return false;			
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