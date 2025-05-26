//   JavaScript Document
/*   PARA CADASTRAR - PROJETO/ANOTACAO         */
function enviar_dados_cad(source,val,string_array) {
    ///
    ///  Ocultando ID  e utilizando na tag input comando onkeypress
    exoc("label_msg_erro",0,""); 
    ///
   
  ///  alert(" cad_proj_expe.js/9 --->>>  source = "+opcao+" -- val = "+val);   
   
   ///  Verificando variaveis
    var val_upper="";
    if( typeof(source)=="undefined" ) var source=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";
    if( typeof(val)=="string" ) val_upper=val.toUpperCase();
    
    // Verifica se a variavel e uma string
    var source_maiusc=""; var source_array_pra_string="";  
    if( typeof(source)=='string' ) {
       //  source = trim(string_array);
       //  string.replace - Melhor forma para eliminiar espaços no comeco e final da String/Variavel
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
    ///
    var opcao = source.toUpperCase();
   
 ///  alert(" cad_proj_expe.js/39 -  source = "+opcao+" -- val = "+val);
    
    
    /// Reiniciar a pagina atual
    if( opcao=="RESET" ) {
         parent.location.href=val;                
         return;   
    }
      
    ///  Verificando Chefe/Orientador
    if( opcao=="CHEFE" ) { 
      
        alert(" cad_proj_exe.js/44  -- opcao =  "+opcao+"  -- val_upper = "+val_upper);
        var pos_chefe = val_upper.search(/OUTRO/i);
        ////  if( val_upper=="OUTRO_CHEFE" ) {  
        if( pos_chefe!=-1 ) {  
             ///  Ativando div ID  outro_chefe
            exoc("outro_chefe",1);
            exoc("novo_chefe",1);  
            ///
        } else {
            ///  Desativando div ID  outro_chefe
            exoc("outro_chefe",0); 
            exoc("novo_chefe",0); 
            ///
       }   
       return false;
   }
   ///
   if( opcao=="ANOTADOR" ) { 
      if( val.toUpperCase()=="CODIGOUSP" ) {  
          if( document.getElementById('td_proj_ou_expe') ) {
              document.getElementById('td_proj_ou_expe').style.display="none";        
              document.getElementById('nome').title="";        
          }
          if( string_array.toUpperCase()=="OUTRO"  ) {
              // Verificar pra nao acusar erro
              if( document.getElementById('td_proj_ou_expe') ) {
                  document.getElementById('td_proj_ou_expe').style.display="block";        
                  document.getElementById('nome').title="Digitar nome";        
              }
           //   return;
          } // else {
         var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+escape(string_array);
          // }
       }   
   }
    //   Criando os campos instituicao, unidade, departamento, setor 
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
		}  else if(  val.toUpperCase()=="VERIFICANDO"  ) {
            alert(" cad_proj_expe.js/44 -  source = "+opcao+" -- val = "+val);
            voltar=0; enviar=1;
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
    if ( ( typeof(string_array)!='undefined') && ( opcao=="CONJUNTO" )  ) {
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
     /*  
	        IF para projeto (coautores) ou experimento (colaboradores)         */
   //    if( ( opcao=="COAUTORES" ) ||  ( opcao=="COLABS" ) ) {
    if( ( opcao=="CORESPONSAVEIS" ) ||  ( opcao=="COLABS" ) ) {	   
        //  val = document.getElementById("coautores").value;
    	val = document.getElementById(source).value;
		var id_inc_pe = "incluindo_"+source;
        if( val<1 ) {
             //  exoc("incluindo_coautores",0);
			 exoc(id_inc_pe,0);
 			 return;
        } else {
             exoc(id_inc_pe,1);
		}
		var m_array="";
       /*		var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+escape(m_array)+"&pagina=projeto"; 
	   */
		var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);
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
         for ( i=0; i<=m_elements_total; i++ ) {      
		    //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
		    var m_id_name = frm.elements[i].name;
	        var m_id_type = frm.elements[i].type;
	        var m_id_title = frm.elements[i].title;
	        // var m_id_value = frm.elements[i].value;
			 //  var m_id_value = frm.elements[i].value;
			 //  SWITCH para verificar o  type da  tag (campo)
	
// alert("cpo#"+i+"  nome="+m_id_name+"  tipo="+m_id_type+"  valor="+frm.elements[i].value)

    		 switch (m_id_type) {
                  case "undefined":
                  //  case "hidden":				 
                  case "button":
                  case "image":
                  case "reset":
                  continue;
             }
			 //  ALERT - para testar o FORM do EXPERIMENTO
	         //  alert(" m_id_name = "+m_id_name+" -  m_id_type = "+m_id_type)
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
             } else if( m_id_type=="text" ) {  
			      m_id_value = trim(document.getElementById(m_id_name).value);
				  if( m_id_value=="" ) {
                      var m_erro = 1;       
                  }  else {
                      //  Se campo for usuario ou  senha
                     if( ( m_id_name.toUpperCase()=="LOGIN" ) || ( m_id_name.toUpperCase()=="SENHA" ) ) {
                             if( m_id_value.length<8 )  var m_erro = 1;    
                     }
                     if( ( m_id_name.toUpperCase()=="CORESPONSAVEIS" ) || ( m_id_name.toUpperCase()=="COLABS" ) ) {
                         //  if( ( m_id_name.toUpperCase()=="COAUTORES" ) ) {                     
                         var co_aut_col = "coresponsaveis";
                         if( m_id_name.toUpperCase()=="COLABS" ) co_aut_col="colabs" ;
                         if( co_aut_col=="colabs" ) {
                              var confirm_text = "Colaboradores";
                         } else {
                              var confirm_text = "Co-Responsáveis";
                         }
                         var m_value_coresponsaveis=0;
                         //  "coresponsaveis"
                         m_value_coresponsaveis=document.getElementById(co_aut_col).value;
                         // m_value_coresponsaveis=document.getElementById("coautores").value;    
                         if( ( parseInt(m_id_value)<1 ) || ( m_id_value=="" ) ) {
                              m_value_coresponsaveis=0;
                             /*
                              var decisao = confirm("Digitar número de "+confirm_text+"?");
                              if ( decisao ) {
                                  m_erro = 1;
                              } else {
                                 m_value_coresponsaveis=0;
                                 m_erro = 0;
                              }
                              */
                         } 
                     }  //  Final do IF  CORESPONSAVEIS ou  COLABS 
                     if( m_erro<1  ) {
                          //  Verificando as datas
                          /*
                          var m_datas = /(datainicio|dataini|data_ini|datafinal|datafin|data_fin)/i;
                          if( m_datas.test(m_id_name) )  {
                               n_datas++;
                               arr_dt_nome[n_datas]=m_id_name;
                               arr_dt_val[n_datas] =m_id_value;   
                          }           
                          alert("n_datas = "+n_datas)                   
                          if( n_datas==2 ) {
                              alert("cad_proj_expe.js/204 - arr_dt_nome[1] = "+arr_dt_nome[1]+" - arr_dt_val[1] = "+arr_dt_val[1])
                              var resultado=verificadatas(arr_dt_nome[1],arr_dt_val[1],arr_dt_nome[2],arr_dt_val[2]);    
                              if( resultado===false  ) return;                 
                          }
                          */
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
             ///
             ////  Verificando os coautores ou colaboradores
             var pos = m_id_name.search(/ncoautor/i);
			 if( pos!=-1 ) {
 			         m_id_value = trim(document.getElementById(m_id_name).value);
					 n_coresponsaveis[n_i_coautor]=m_id_value;
					 n_i_coautor++;
             } 			 
 	 		 if( m_id_name.toUpperCase()=="ENVIAR" ) {
				 if( m_value_coresponsaveis>1 ) {
                      //  You can define the comparing function here. 
					  //  JS default uses a crappy string compare. 					 
					 var duplicado = 0;
                     var sorted1_arr=n_coresponsaveis.sort(); 
                     var tot_n_c=n_coresponsaveis.length;
                     for (var i = 0; i <= tot_n_c; i++ ) { 
					 	   for (var y = 0; y <= tot_n_c; y++ ) { 
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
 				 //  Verificando as testemunhas
			     if( ( n_testemunhas==2 ) && ( m_erro<1 ) ) {
                        //  You can define the comparing function here. 
  					    //  JS default uses a crappy string compare. 					 
					    var duplicado = 0;
                        var m_testemunha1=trim(document.getElementById("testemunha1").value); 
                        var m_testemunha2=trim(document.getElementById("testemunha2").value); 
                        if( m_testemunha1==m_testemunha2  ) {
	  					    duplicado=1;
	    				    var m_id_title="Duplicado"; 
							var m_erro=1;
		    			} 
				 }
                 //				 			 
			 }
			 ///
             
///   alert("LINHA 240 - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro)
  
			 ///  Verificando diferentes dados nos campos de Senha ( Senha e a Confirmacao )
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
  				//  document.getElementById("msg_erro").innerHTML=msg_erro;	
                  document.getElementById("label_msg_erro").innerHTML=msg_erro;    
				  //  frm.m_id_name.focus();
				  //  document.getElementById(m_id_name).focus();
				  break;
			 }
			 //
 		    campo_nome+=m_id_name+",";  
			campo_value+=m_id_value+",";
        /*   Teste    
            var testecponv = campo_nome+"\r\n  "+campo_value;
            alert("LINHA 311 - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro+"\r\n\r\n"+testecponv)            
         */   
             if( m_id_name.toUpperCase()=="ENVIAR" )  break;
		 }		 
    	//  document.form.elements[i].disabled=true; 
		 if( m_erro==1 ) {
			  return false;
		 } else {
			 //  Enviando os dados dos campos para o AJAX
			 if( m_value_coresponsaveis>0 ) {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value)+"&m_array="+encodeURIComponent(n_coresponsaveis);				 
			 } else {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);			 
             }
		 }
         
         alert(" cad_proj_expe.js/417 -  source = "+opcao+" -- val = "+val+"  \r\n\r poststr = "+poststr);
         return;
         
    }  //  FINAL do IF SUBMETER
    
    //   Participante do Projeto
    if( opcao=="PARTICIPANTE" )  {
        var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array);                 
    }
    
   
    /*   Aqui eu chamo a class do AJAX */
	var myConn = new XHConn();
		
	/*  Um alerta informando da não inclusão da biblioteca - AJAX   */
    if( !myConn ) {
	      alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
		  return false;
    }
	//
	//  Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
   //   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    var receber_dados = "proj_exp_ajax.php";
    //
    
 ///  alert(" cad_proj_expe.js/407 -  source = "+opcao+" -- val = "+val+"  \r\n\r poststr = "+poststr);

    
    ///
	 var inclusao = function (oXML) { 
                         //  Recebendo os dados do arquivo ajax
                         //  Importante ter trim no  oXML.responseText para tirar os espacos
                         var m_dados_recebidos = trim(oXML.responseText);
		 	            /// document.getElementById('label_msg_erro').style.display="none";
                         var pos = m_dados_recebidos.search(/ERRO:|FALHA:/i);
                         if( pos!=-1 ) {
                                 /// Mensagem de erro ativar
                                  exoc("label_msg_erro",1,m_dados_recebidos);   
                                /*    document.getElementById('label_msg_erro').style.display="block";
                                      document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                 */
                                 return;
                         }
                         ///                         
                         
						  /// if( ( opcao=="COAUTORES" ) ||  ( opcao=="COLABS" ) ) {
                        if( ( opcao=="CORESPONSAVEIS" ) ||  ( opcao=="COLABS" ) ) {							
						 	  document.getElementById('corpo').style.display="block";	
							  document.getElementById(id_inc_pe).innerHTML= oXML.responseText;
      				    } else  if(  opcao=="CONJUNTO"   ) { 
						       // var m_elementos = "<?php echo $_SESSION['VARS_AMBIENTE'];?>";
							   //  var m_elementos = "instituicao|unidade|depto|setor|bloco|salatipo|sala";
							   var m_elementos = "instituicao|unidade|depto|setor|bloco|sala";
								var new_elements = m_elementos.split("|");
						        // Desativando alguns campos
								document.getElementById("label_msg_erro").style.display="none";
								if ( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                                     limpar_campos(new_elements);
								}
								//  Verificando se tem proximo campo ou chegou no Final
								if ( prox_cpo.length ) {
							       //  Ativando a tag td com o campo
								   var id_cpo = "td_"+prox_cpo;
								   document.getElementById("tab_de_bens").innerHTML= "";
                                   var lsinstituicao = m_dados_recebidos.search(/Instituição/i);  
            	                   var pos = m_dados_recebidos.search(/Nenhum|Erro/i);  
							       if( pos != -1 )  {
                                      if( lsinstituicao  == -1 )  {
								      	 limpar_campos(new_elements);
									     // Voltar para o inicio da tag Select
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
								      }
							       }
							  }
                        } else  if(  opcao=="ANOTADOR"   ) {     
                               if( val.toUpperCase()=="CODIGOUSP" ) {  
                                       document.getElementById('label_msg_erro').style.display="none";
                                       var new_elements = m_dados_recebidos.split("|");
                                       var temp = trim(new_elements[0]);
                                       var campo_nome = temp.split(",");
                                       var m_length = campo_nome.length;
                                       var cpo_id="";
                                       var x=0; var i=0; 
                                       if( document.getElementById("senha") ) document.getElementById("senha").disabled=false;
                                       if( document.getElementById("redigitar_senha") ) document.getElementById("redigitar_senha").disabled=false;
                                       while( i<m_length ){
                                             cpo_id=campo_nome[i];
                                             x=i+1;                                             
                                             if( trim(new_elements[x])!="" ) {
                                                 document.getElementById(cpo_id).value=new_elements[x];
                                                 document.getElementById(cpo_id).disabled=true;
                                                 //  Verificando o login/username/user_name
                                                 var m_login = /(LOGIN|USERNAME|USER_NAME|USUARIO)/i;
                                                 if( m_login.test(cpo_id) ) {
                                                      if( document.getElementById("senha") ) document.getElementById("senha").disabled=true;
                                                      if( document.getElementById("redigitar_senha") ) document.getElementById("redigitar_senha").disabled=true;
                                                 }                                                                     
                                             } else {
                                                  document.getElementById(cpo_id).disabled=false;  
                                                  document.getElementById(cpo_id).value="";
                                             }                                                     
                                             i++;
                                       }
                               }                                                                       
      				    } else  if(  opcao=="ANOTACAO"   ) { 							
                                //  AUTOR/ANOTADOR E  ORIENTADOR/SUPERVISOR
    		                    //  if( ( val.toUpperCase()=="AUTOR" ) &&  msa.length>=1 ) {
                                if( ( val.toUpperCase()=="PROJETO" ) &&  msa.length>=1 ) {
                                     var pos = m_dados_recebidos.search(/ERRO:|NENHUM/i);
                                      if( pos!=-1 ) {
                                           // Quando acontece erro ou nao existe dados	
                                           if( document.getElementById("novo_td") ) {
                                              document.getElementById("novo_td").style.display="none";    
                                              if( document.getElementById("nr_anotacao") ) {
                                                  document.getElementById("nr_anotacao").style.display="none";
                                              }
                                           }									
         					 	           document.getElementById('label_msg_erro').style.display="block";
  					 	                   document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
									  } else {
                                            var array_dados = m_dados_recebidos.split("<label");                        
                                            array_dados[1]= "<label "+array_dados[1];
                                            array_dados[2]= "<label "+array_dados[2];
                                            //     alert("cad_proj_expe.js PROJETO -  m_dados_recebidos = "+m_dados_recebidos+" - array_dados[1]= "+array_dados[1]+" - array_dados[2] = "+array_dados[2])
                                            document.getElementById("nr_anotacao").style.display="block";
                                            document.getElementById("nr_anotacao").innerHTML=array_dados[1];                                              
                                            document.getElementById("sn_altera_complementa").innerHTML=array_dados[2];  
									  }
							   } else if( ( val.toUpperCase()=="ALTERA_COMPLEMENTA" ) &&  msa.length>=1 ) {
								    	var pos = m_dados_recebidos.search(/ERRO:/i);
                                //     alert("cad_proj_expe.js ALTERA_COMPLEMENTA -  m_dados_recebidos = "+m_dados_recebidos)
                                        document.getElementById('corpo').style.display="block";
         					 	        document.getElementById('label_msg_erro').style.display="block";
                                        if( pos!=-1 ) {
                                            document.getElementById('altera_complementa').options[2].selected=true; 											
            								document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
					            	    } else {
       								        document.getElementById("td_altera_complementa").style.display="block";
									        document.getElementById("td_altera_complementa").innerHTML=m_dados_recebidos; 
										}
                         	   }
                        } else  if( opcao=="PARTICIPANTE" ) {  // Selecionado o Participante do Projeto
                             var pos = m_dados_recebidos.search(/ERRO|Nenhum/i);
                              if( pos!=-1 ) {
                                  if( document.getElementById('label_msg_erro') ) {
                                       document.getElementById('label_msg_erro').style.display="block";    
                                       document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                  }
                              } else {
                                  if( document.getElementById('email_participante') )  {
                             alert(" cad_proj_expe.js/512 -  source = "+opcao+" -- val = "+val+"  -  m_dados_recebidos = "+m_dados_recebidos);                                      
                                     document.getElementById('email_participante').innerHTML="teste@hotmail.com";                                         
                                  }
                                    
                              }                                  
                                                                                                                        
						}  else {
						      var pos = m_dados_recebidos.search(/ERRO:/i);
                              if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";
  					 	      document.getElementById('label_msg_erro').style.display="block";
         					  if( pos!=-1 ) {
// alert("PASSOU 484 - pos = "+pos+"m_dados_recebidos="+m_dados_recebidos)
								  document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
							  } else {
// alert("PASSOU 487 - source = "+source+" - val = "+val+" - m_dados_recebidos = "+m_dados_recebidos+" -  pos = "+pos)
   					 	          document.getElementById('label_msg_erro').style.display="none";	
								  if( opcao=="SUBMETER" ) {
						 	          document.getElementById('label_msg_erro').style.display="block";	
   								      document.getElementById('div_form').style.display="none";
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
              quais teclas estão sendo pressionadas.       
              teclas 13 e 9 sao Enter e TAB
         */
        if( !(tecla >= 48 && tecla <= 57 ) && !( tecla==13  ||  tecla==9 ) ) {
           if( !(tecla >= 96 && tecla <= 105 )  ) {
              /* A propriedade keyCode revela o código ASCII da tecla pressionada. 
                Sabemos que os números de 0 a 9 estão compreendidos entre 
                os valores 48 e 57 da tabela referida. Então, caso os valores 
                não estejam(!) neste intervalo, a função retorna falso para quem
                a chamou.  Menos keyCode igual 13  */
               document.getElementById(field.id).value="";
		       alert("Apenas NÚMEROS são aceitos!");
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
// VERIFICA SE DATA FINAL É MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)
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
		alert('ATENÇÃO: Data Inicial é MAIOR que Data Final');
		document.getElementById("label_msg_erro").style.display="block";
     	 document.getElementById("label_msg_erro").innerHTML="";
 	     msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
		   final_msg_erro = '</span></p>';
    	  msg_erro = msg_erro+'Data Inicial é MAIOR que Data Final'+final_msg_erro;
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
    //  By Anônimo e Micox - http://elmicox.blogspot.com
   var novo = document.createElement("<script>");
   novo.setAttribute('type', 'text/javascript');
   novo.setAttribute('src', arquivo);
     document.getElementsByTagName('body')[0].appendChild(novo);
  // document.getElementsByTagName('head')[0].appendChild(novo);
   //apos a linha acima o navegador inicia o carregamento do arquivo
   //portanto aguarde um pouco até o navegador baixá-lo. :)
}
//
//  Limpar os campos do opcao=="CONJUNTO"
function limpar_campos(new_elements) {
		/*  Método slice
		    Obtém uma seleção de elementos de um array.
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
//
