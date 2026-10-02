<?php
/**   
*      Verificando conexao  - PARA CADASTRAR - PROJETO/ANOTACAO  - js
*  Atualizado em 20250520
*/
//  Verificando se SESSION_START - ativado ou desativado  
if( !isset($_SESSION)) {
     session_start();
}
//
$php_errormsg='';
//
//  Verificando caminho http e pasta principal
if( isset($_SESSION["url_central"]) ) {
     $http_host = @trim($_SESSION["url_central"]);     
} else {
    echo "<p style='background-color: #000000;color:#FFFFFF;font-size:large;'> ERRO: grave falha na session url_central. Contato com Administrador.</p>";
    exit();
}
///
if( ! empty($php_errormsg) ) {
    $http_host="../";
}
///
?>
<script language="JavaScript" type="text/javascript">
//                                                               
/****  
    Define o caminho HTTP  -  20180611
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
charset="utf-8";
///
///  variavel quando ocorrer Erros ou apenas enviar mensagem
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
/******  Final -  variavel quando ocorrer Erros ou apenas enviar mensagem  ****/
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
///  FUNCTION enviar_dados_cad - Ajax
function enviar_dados_cad(source,val,m_array) {
    //
    // Verificando se a function exoc existe 
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
    if( typeof(val)=="string" ) {
         //
         // Variavel com letras maiusculas
         var val_upper=val.toUpperCase();
         //
         // IMPORTANTE: para retirar os acentos da palavra
         //  var val=retira_acentos(val);
         var val_sem_acentos=retira_acentos(val);
         var val=val_sem_acentos;
         //
         //  Retirando acentos - 20171005
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
        for(  i=0;  i<mlength-1;  i++  )   {
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
          // 
          //  esse elemento definido como Array
          var source_array_pra_string=source.join("");
          //
          // IMPORTANTE: para retirar os acentos da palavra
          var source_sem_acentos=retira_acentos(source_array_pra_string);
          /// 
          var source=source_sem_acentos;
          // 
    }
    ///
    /// Variavel com letras maiusculas
    var source_maiusc = source.toUpperCase();     
    //
    /// IMPORTANTE: para retirar os acentos da palavra
    ///  var source_sem_acentos=retira_acentos(source_maiusc);
    
    ///
    var opcao = source.toUpperCase();
     /*****    
     *   Reiniciar a pagina atual 
     *     - utilizar a variavel paginal_local
     */
     if( opcao=="RESET" ) {
         /**
          *   Retornar a pagina
          *   parent.location.href=pagina_local;                
          */
         parent.location.reload(); 
         return;   
         //
     }  
     /**  Final - if( opcao=="RESET" ) {  */
     //      
   
 alert(" anotacao_cadastrar_js.php/216 - INICIO -->>  source = "+opcao+" -- val = "+val+" -  m_array = "+m_array);


    /**  Criando os campos instituicao, unidade, departamento, setor   */
	if( opcao=="ANOTACAO" ) { 
        //
        /**   AUTOR/ANOTADOR E  ORIENTADOR/SUPERVISOR   */
		var msa = trim(m_array);
		var voltar = 1; var enviar=0;
        /// if( ( val.toUpperCase()=="PROJETO" || val.toUpperCase()=="AUTOR"  ) &&  msa.length>=1 ) {
        if( ( val.toUpperCase()=="PROJETO" ) &&  msa.length>=1 ) {
			  voltar=0; enviar=1;
		} else if( ( val.toUpperCase()=="ALTERA_COMPLEMENTA" ) &&  msa.length>=1 ) {
			if( msa=="0" ) {
                //
                //  Ocultando ID 
                 exoc("td_altera_complementa",0);  
                 return;
            }    
			voltar=0;  enviar=1;
		}  else if(  val.toUpperCase()=="VERIFICANDO"  ) {
             voltar=0; enviar=1;
        }
		//   Desativando TD - ocorrendo erro
		if( voltar==1 ) {
    	   if( val.toUpperCase()=="PROJETO" )   document.getElementById("nr_anotacao").style.display="none";
           ///  AUTOR/ANOTADOR E  ORIENTADOR/SUPERVISOR
		   ///  if( val.toUpperCase()=="AUTOR" ) {
           /// if( val.toUpperCase()=="SUPERVISOR" ) {    alterado:110905.1129
           if( val.toUpperCase()=="PROJETO" ) {
			  if( document.getElementById("novo_td") ) document.getElementById("tr_coord_proj").removeChild("novo_td");
		   } 
		}
		if( enviar==1 ) {
    	      var m_array = m_array.split("|");
              var poststr="source="+encodeURIComponent(source)+"&val=";
			  poststr=poststr+encodeURIComponent(val)+"&m_array="+encodeURIComponent(m_array)+"&cip="+encodeURIComponent(m_array);
		}
        //
		if( voltar==1 ) return;
        //
	}  
    /**  Final - if( opcao=="ANOTACAO" ) {   */
    //
    /**   Colaboradores ou Coautores   */
    ///    if( ( opcao=="COAUTORES" ) ||  ( opcao=="COLABS" ) ) {
    if( ( opcao=="CORESPONSAVEIS" ) || ( opcao=="COLABS" ) ) {	   
          //
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
          //
          var m_array="";
          //
          var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);
          //
    }   
    /**  Final - if( ( opcao=="CORESPONSAVEIS" ) || ( opcao=="COLABS" ) ) {	 */
    //
	//  Variavel opcao SUBMETER
	if( opcao=="SUBMETER" ) {
         //
		 var frm = m_array;
    	 var m_elements_total = frm.length; 
         //
     	 var m_erro = 0; var n_coresponsaveis= new Array(); 
		 var n_i_coautor=0;   var n_senhas=0;  var n_testemunhas=0; 
         var n_datas=0; var arr_dt_nome = new Array(); var arr_dt_val = new Array();
		 var campo_nome="";   var campo_value=""; var m_id_value="";
         for( i=0; i<=m_elements_total; i++ ) {      
              // 
              /** Passando para variavel - nome,tipo,titulo (title tem que ter no campo)  */
		      // 
		      var m_id_name = frm.elements[i].name;
	          var m_id_type = frm.elements[i].type;
	          var m_id_title = frm.elements[i].title;
	          //  var m_id_value = frm.elements[i].value;
			  //  var m_id_value = frm.elements[i].value;
              //
			  //  SWITCH para verificar o  type da  tag (campo)
    		  switch (m_id_type) {
                   case "undefined":
                   ///  case "hidden":				 
                   case "button":
                   case "image":
                   case "reset":
                   continue;
              }
              /**  Final - switch (m_id_type) { */
              //
			  //  ALERT - para testar o FORM do EXPERIMENTO
	          //  alert(" m_id_name = "+m_id_name+" -  m_id_type = "+m_id_type)
		 	  if( m_id_type=="checkbox" ) {
                    //  Verifica se o checkbox foi selecionado
                    if( ! elements[i].checked ) var m_erro = 1;
              } else if ( m_id_type=="password" ) {
                   //
                   // Verifica se a Senha foi digitada
		           m_id_value = trim(document.getElementById(m_id_name).value);
                   if( m_id_value.length<8 ) {
                       var m_erro = 1;      
                   } else {
                       //
                       /**   Verficando se tem dois campos senha e outro para confirmar   */
                       var midnmup=m_id_name.toUpperCase();
                       if( ( midnmup=="SENHA" ) || ( midnmup=="REDIGITAR_SENHA" ) ) {
                            n_senhas=n_senhas+1;
                       }
                       //                     
                  }  
                  //               
             } else if( m_id_type=="text" ) {  
                  //
			      m_id_value = trim(document.getElementById(m_id_name).value);
                  //
				  if( m_id_value=="" ) {
                      var m_erro = 1;       
                  } else {
                     //
                     //  Se campo for usuario ou senha
                     var midnmup=m_id_name.toUpperCase();
                     if( ( midnmup=="LOGIN" ) || ( midnmup=="SENHA" ) ) {
                          if( m_id_value.length<8 )  var m_erro = 1;    
                     }
                     //
                     if( ( midnmup=="CORESPONSAVEIS" ) || ( midnmup=="COLABS" ) ) {
                         //
                         //  if( ( m_id_name.toUpperCase()=="COAUTORES" ) ) {                     
                         var co_aut_col = "coresponsaveis";
                         if( midnmup=="COLABS" ) co_aut_col="colabs" ;
                         //
                         if( co_aut_col=="colabs" ) {
                              var confirm_text = "Colaboradores";
                         } else {
                              var confirm_text = "Co-Responsáveis";
                         }
                         var m_value_coresponsaveis=0;
                         //
                         //  "coresponsaveis"
                         m_value_coresponsaveis=document.getElementById(co_aut_col).value;
                         //
                         // m_value_coresponsaveis=document.getElementById("coautores").value;    
                         if( ( parseInt(m_id_value)<1 ) || ( m_id_value=="" ) ) {
                              m_value_coresponsaveis=0;
                         } 
                         //
                     }  
                     /**  Final - if( ( midnmup=="CORESPONSAVEIS" ) || ( midnmup=="COLABS" ) ) { */
                     //
                     if( intval(m_erro)<1  ) {
                          //
                          //  Verificando as datas
                          //  Verificando o campo email                          
                          var m_email = /(EMAIL|E_MAIL|USER_EMAIL)/i;
                          if( m_email.test(m_id_name) ) {
                                 var resultado = validaEmail(m_id_name);  
                                 if( resultado===false  ) return;
                          }                      
                          //
                     }   
                     //
                  }				  
                  //
			 } else if( m_id_type=="hidden" ) {  
			      m_erro=0;
			      m_id_value = trim(document.getElementById(m_id_name).value);
			 } else if( m_id_type=="textarea" ) {  
			      m_id_value = trim(document.getElementById(m_id_name).value);
				  if( m_id_value=="" ) var m_erro = 1;	 
			 }  else if( m_id_type=="select-one" ) {  
                  //
                  var midnmup=m_id_name.toUpperCase();
                  //
			      if( m_id_name=="anotacao_select_projeto" || midnmup=="ALTERA_COMPLEMENTA" ) continue;
			      m_id_value = trim(document.getElementById(m_id_name).value);
				  if( m_id_value=="" ) var m_erro = 1;	
                  //
                  /**   Verificando os campos das testemunhas do Experimento   */
  				  if( ( midnmup=="TESTEMUNHA1" ) || ( midnmup=="TESTEMUNHA2" ) ) {
                      //
  					  if( midnmup=="TESTEMUNHA1" ) {
						   var confirm_text = "Testemunha1";
					  } else if( midnmup=="TESTEMUNHA2" ) {
  						   var confirm_text = "Testemunha2";
					  }
  					  if( m_id_value=="" ) {	  
                           //
    					   var decisao = confirm("Selecionar "+confirm_text+"?");
                           if( decisao ) {
					      	  m_erro = 1;
                           } else {
							  m_erro = 0;
                           }
                           //
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
             //  Verificando os coautores ou colaboradores
             var pos = m_id_name.search(/ncoautor/i);
			 if( pos!=-1 ) {
 			         m_id_value = trim(document.getElementById(m_id_name).value);
					 n_coresponsaveis[n_i_coautor]=m_id_value;
					 n_i_coautor++;
             } 			 
 	 		 if( m_id_name.toUpperCase()=="ENVIAR" ) {
				 if( m_value_coresponsaveis>1 ) {
                      //
                      //  You can define the comparing function here. 
					  //  JS default uses a crappy string compare. 					 
					  var duplicado = 0;
                      var sorted1_arr=n_coresponsaveis.sort(); 
                      var tot_n_c=n_coresponsaveis.length;
                      for (var i = 0; i <= tot_n_c; i++ ) { 
                           // 
					 	   for (var y = 0; y <= tot_n_c; y++ ) { 
						        if( ( sorted1_arr[i]==sorted1_arr[y] ) && ( i!=y ) ) {
									duplicado=1; 
     	    					    m_id_title="Duplicado"; m_erro=1;									
									break;
								}
						   }
                           //
                      }
                      // 
				 }  
                 //
 				 //  Verificando as testemunhas
			     if( ( n_testemunhas==2 ) && ( m_erro<1 ) ) {
                        //
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
             //
			 if( m_erro==1 ) {
                 //
                 /**
                  *   document.getElementById("label_msg_erro").style.display="block";
                 */
                 //
                 if( document.getElementById("label_msg_erro") ) {
                    //
                    var nraid = document.getElementById("label_msg_erro");
                    var zdisp = nraid.style.display;
                    //
                    if( zdisp!="block" ) {
                        nraid.style.display="block";
                    }
                    //
                 }  
                 /**  Final - if( document.getElementById("label_msg_erro") ) {  */
                 //
                 //  Atualizado em 20250521
     		 	 //	 
                 var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
				 // msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                 msg_erro += "<span style='color: #FF0000;'>";
                 //
     		     var final_msg_erro = "&nbsp;</span></span>";
				 m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
 				 // msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                 msg_erro = msg_erro+'&nbsp;Corrigir campo:'+m_tit_cpo+final_msg_erro;
  				 document.getElementById("label_msg_erro").innerHTML=msg_erro;    
				 //  frm.m_id_name.focus();
				 //  document.getElementById(m_id_name).focus();
				 break;
                 //
			 }  
             /**  Final - if( m_erro==1 ) {   */
			 //
 		     campo_nome+=m_id_name+",";  
		     campo_value+=m_id_value+",";
             //

             /**     Teste     */   
             var testecponv = campo_nome+"\r\n  "+campo_value;       

  /**  
  *  alert("LINHA 517 - m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro+"\r\n\r\n"+testecponv);            
  */    


   
	         if( m_id_name.toUpperCase()=="ENVIAR" )  break;
             //
		 }	
         /**   Final - for( i=0; i<=m_elements_total; i++ ) {  */
         //	 
    	 //  document.form.elements[i].disabled=true; 
		 if( m_erro==1 ) {
			  return false;
		 } else {
			 //  Enviando os dados dos campos para o AJAX
			 if( m_value_coresponsaveis>0 ) {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);
                 poststr += "&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);
                 poststr += "&m_array="+encodeURIComponent(n_coresponsaveis);				 
			 } else {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);
                 poststr += "&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);			 
             }
             //

/**  
  alert("LINHA576 -->>   poststr = "+poststr);            
   */

             //
		 }
         //
    }  
    /**  Final - if( opcao=="SUBMETER" ) {   */
    //
    /**  Aqui eu chamo a class do AJAX */
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
    /**
     *     Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
     *   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
     *   var receber_dados = "proj_exp_ajax.php";
     */
    var receber_dados = "anotacao_cadastrar_ajax.php";
    //
    
 ///  alert(" anotacao_cadastrar_js/407 -  source = "+opcao+" -- val = "+val);
    
    ///  Function - retornando dados do arquivo ajax
	 var inclusao = function (oXML) { 
                      //
                      //  Recebendo os dados do arquivo ajax
                      //  Importante ter trim no  oXML.responseText para tirar os espacos
                      var m_dados_recebidos = trim(oXML.responseText);
                          
                      ////  Verificando se houve ERRO
                      var pos = m_dados_recebidos.search(/ERRO:|FALHA:|Uncau|Fatal erro/ui);
                      //
                      if( document.getElementById("tr_projeto_autor_nome") ) {
                           document.getElementById("tr_projeto_autor_nome").style.display="none";
                      } 
                      //


    alert(" anotacao_cadastrar_js/364 -->>  INCLUSAO - pos = "+pos+"  -->>  source = "+opcao+" -- val = "+val
            +" -  m_array = "+m_array+" \r\n\n m_dados_recebidos =  "+m_dados_recebidos);                         


                      
                      //
                      if( pos!=-1 ) {
                           //
                           /**   Caso tiver palavras de Cadastro ou Corrigir campo   */ 
                           var pnhm = m_dados_recebidos.search(/NENHUM|cadastrad(a|o){1}/ui);
                           if( pnhm!=-1 ) {
                                var m_dados_recebidos = m_dados_recebidos.replace(/ERRO:|Corrigir campo/uig,"");
                           }
                           /**  Final - if( pnhm!=-1 ) {  */
                           //
                           // Mensagem de erro ativar
                           exoc("label_msg_erro",1,m_dados_recebidos);   
                           /**
                           *    document.getElementById('label_msg_erro').style.display="block";
                           *     document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                           */
                           return;
                           //
                      }
                      /**  Final - if( pos!=-1 ) {  */
                      //                         


    alert(" anotacao_cadastrar_js/364 -->>  INCLUSAO - pos = "+pos+"  -->>  source = "+opcao+" -- val = "+val
            +" -  m_array = "+m_array+" \r\n\n m_dados_recebidos =  "+m_dados_recebidos);                         



                      //   
					  //  if( ( opcao=="COAUTORES" ) ||  ( opcao=="COLABS" ) ) {
                      if( ( opcao=="CORESPONSAVEIS" ) ||  ( opcao=="COLABS" ) ) {							
						    document.getElementById('corpo').style.display="block";	
						    document.getElementById(id_inc_pe).innerHTML= oXML.responseText;
                            //
      				  } else if( opcao=="ANOTACAO" ) { 							
                            //
                            //  AUTOR/ANOTADOR E  ORIENTADOR/SUPERVISOR
    		                //  if( ( val.toUpperCase()=="AUTOR" ) &&  msa.length>=1 ) {
                            if( ( val.toUpperCase()=="PROJETO" ) &&  msa.length>=1 ) {
                                  var pos = m_dados_recebidos.search(/ERRO:|NENHUM/i);
                                  if( pos!=-1 ) {
                                      //// Quando acontece erro ou nao existe dados	
                                      /*
                                          if( document.getElementById("novo_td") ) {
                                              document.getElementById("novo_td").style.display="none";    
                                              if( document.getElementById("nr_anotacao") ) {
                                                  document.getElementById("nr_anotacao").style.display="none";
                                              }
                                           }									
                                      */
                                      ////  Ocultando IDs
                                      exoc("novo_td",0,"");
                                      exoc("nr_anotacao",0,"");
                                      ////
                                      if( document.getElementById("div_form") ) {
                                          if( document.getElementById("div_form").style.display="block" ) {
                                              document.getElementById("div_form").style.display="none";
                                          }     
                                          //
                                      } 
                                      //
         					 	      // document.getElementById('label_msg_erro').style.display="block";
  					 	              //  document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                      //  Ativando os ID de mensagem de erro
                                      exoc("label_msg_erro",1,m_dados_recebidos);  
                                      //
								  } else {
                                      //
                                      var array_dados = m_dados_recebidos.split("<label");                        
                                      array_dados[1]= "<label "+array_dados[1];
                                      array_dados[2]= "<label "+array_dados[2];
                                            
                                  alert(" anotacao_cadastrar_js/365 -  array_dados[3] = "+array_dados[3]);                                                                                                          
                                     

                                      //  Ativando os IDs
                                      exoc("nr_anotacao",1,array_dados[1]);  
                                      exoc("sn_altera_complementa",1,array_dados[2]);  
                                      ///
                                      var len_dados=trim(array_dados[3]);
                                      if( len_dados.length>0 ) {
                                          if( document.getElementById("tr_projeto_autor_nome") ) {
                                              document.getElementById("tr_projeto_autor_nome").style.display="block";
                                              if( document.getElementById("span_proj_autor_nome") ) {
                                                  document.getElementById("span_proj_autor_nome").innerHTML=len_dados;
                                              } 
                                          }
                                      }
                                      ///
								 }
                                 //
							} else if( ( val.toUpperCase()=="ALTERA_COMPLEMENTA" ) &&  msa.length>=1 ) {
							      var pos = m_dados_recebidos.search(/ERRO:/i);
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
                            //
                      } else {
                           //
						   var pos = m_dados_recebidos.search(/ERRO:/i);
                           if( document.getElementById('corpo') ) {
                                document.getElementById('corpo').style.display="block";
                           } 
                           // 
  					 	   document.getElementById('label_msg_erro').style.display="block";
                           //
         			       if( pos!=-1 ) {
								document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                           } else {
                               //
					 	       document.getElementById('label_msg_erro').style.display="none";	
							   if( opcao=="SUBMETER" ) {
                                    //
						 	        document.getElementById('label_msg_erro').style.display="block";	
   								    document.getElementById('div_form').style.display="none";
								    ///  Recebendo o numprojeto e o num do autor
									var test_array = m_dados_recebidos.split("falta_arquivo_pdf");
									if( test_array.length>1 ) {
    								    m_dados_recebidos=test_array[0];
										var n_co_autor = test_array[1].split("&");
										///  Passando valores para tag type hidden
							  		    document.getElementById('nprojexp').value=n_co_autor[0];
     								    document.getElementById('autor_cod').value=n_co_autor[1];
                                        if( n_co_autor.length==3 ) {
                                            ///  ID da pagina anotacao_cadastrar.php
                                            document.getElementById('anotacao_numero').value=n_co_autor[2];
                                        }
									}
   								    document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                                    /// Verificar pra nao acusar erro
                                    if( document.getElementById('arq_link') ) {
                                         document.getElementById('arq_link').style.display="block";        
                                    }
                                 	///   document.getElementById('div_form').innerHTML=m_dados_recebidos;
								} else  {
                                     if( document.getElementById('corpo') ) document.getElementById('corpo').innerHTML=oXML.responseText;   
                                }
						   }
                           //
          			  }
                      //
 		  }; 
	   	 /**  
		      aqui é enviado mesmo para pagina receber.php 
		       usando metodo post, + as variaveis, valores e a funcao   
         */
	    var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
	    /**    uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
        	  porisso eu coloquei return false no form o php enviar sozinho            
        */
       ///
	   return;
       //
}  
/**   FINAL da Function enviar_dados_cad para AJAX     */
//
/**  
8     Function para o Donwload/Carregar  do Servidor para o Local
*/
function download(m_id) {
    var m_id_val = document.getElementById(m_id).value;
	self.location.href='baixar.php?file='+m_id_val;
}
//
//  Limitando o numero de caracteres no textarea
function limita_textarea(campo){
      var tamanho = document.form1[campo].value.length;
      var tex=document.form1[campo].value;
      if (tamanho>=255) {
         document.form1[campo].value=tex.substring(0,5);
      }
      return true;
} 
///  Funcao para alinhar o campo
function alinhar_texto(id,valor) {
    var id_valor = document.getElementById(id).value;
    document.getElementById(id).value=trim(id_valor);
   return;
}
///   Numero de coautores - enviar para cria-los
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
///  tag input type button - buscar coautores
function  buscacoresponsaveis(m_id) {
    var valor_id = document.getElementById(m_id).value;
    document.getElementById("busca_autores").disabled=true;
    if( valor_id>0 ) { 
         document.getElementById("busca_autores").disabled=false;
         document.getElementById("busca_autores").focus();
    }
}
/// Function retorna para o mesmo campo
function retornar_cpo(m_id) {
   document.getElementById(m_id).focus();
   return ;
}
///
///
/// VERIFICA SE DATA FINAL É MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)
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
///
///  Limpar os campos do opcao=="CONJUNTO"
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
///
function mensg_erro(dados,m_erro,array_ids) {
 ///   if( m_erro=="msg_erro1" ) {
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