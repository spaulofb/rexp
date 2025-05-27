<?php
//
// Verificando conexao - consultar usuario - PROJETO  js
//
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
//
?>
<script language="JavaScript" type="text/javascript">
/*  
       JavaScript Document
       Consultar Usuario                      
*/
/****  
    Define o caminho HTTP  -  20180416
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
///
charset="utf-8";
///
///  variavel para enviar mensagens 
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
///
var final_msg_ini='</span></span>';
///  Final -  variavel para enviar mensagens 

///  funcrion acentuarAlerts - para corrigir acentuacao
///  Criando a function  acentuarAlerts(mensagem) 
function acentuarAlerts(mensagem) {
    ///  Paulo Tolentino
    ///  Usar dessa forma: alert(acentuarAlerts('teste de acentua??o, ess?ncia, car?ncia, ??.'));
    ///
    mensagem = mensagem.replace('?', '\u00e1');
    mensagem = mensagem.replace('?', '\u00e0');
    mensagem = mensagem.replace('?', '\u00e2');
    mensagem = mensagem.replace('?', '\u00e3');
    mensagem = mensagem.replace('?', '\u00e4');
    mensagem = mensagem.replace('?', '\u00c1');
    mensagem = mensagem.replace('?', '\u00c0');
    mensagem = mensagem.replace('?', '\u00c2');
    mensagem = mensagem.replace('?', '\u00c3');
    mensagem = mensagem.replace('?', '\u00c4');
    mensagem = mensagem.replace('?', '\u00e9');
    mensagem = mensagem.replace('?', '\u00e8');
    mensagem = mensagem.replace('?', '\u00ea');
    mensagem = mensagem.replace('?', '\u00ea');
    mensagem = mensagem.replace('?', '\u00c9');
    mensagem = mensagem.replace('?', '\u00c8');
    mensagem = mensagem.replace('?', '\u00ca');
    mensagem = mensagem.replace('?', '\u00cb');
    mensagem = mensagem.replace('?', '\u00ed');
    mensagem = mensagem.replace('?', '\u00ec');
    mensagem = mensagem.replace('?', '\u00ee');
    mensagem = mensagem.replace('?', '\u00ef');
    mensagem = mensagem.replace('?', '\u00cd');
    mensagem = mensagem.replace('?', '\u00cc');
    mensagem = mensagem.replace('?', '\u00ce');
    mensagem = mensagem.replace('?', '\u00cf');
    mensagem = mensagem.replace('?', '\u00f3');
    mensagem = mensagem.replace('?', '\u00f2');
    mensagem = mensagem.replace('?', '\u00f4');
    mensagem = mensagem.replace('?', '\u00f5');
    mensagem = mensagem.replace('?', '\u00f6');
    mensagem = mensagem.replace('?', '\u00d3');
    mensagem = mensagem.replace('?', '\u00d2');
    mensagem = mensagem.replace('?', '\u00d4');
    mensagem = mensagem.replace('?', '\u00d5');
    mensagem = mensagem.replace('?', '\u00d6');
    mensagem = mensagem.replace('?', '\u00fa');
    mensagem = mensagem.replace('?', '\u00f9');
    mensagem = mensagem.replace('?', '\u00fb');
    mensagem = mensagem.replace('?', '\u00fc');
    mensagem = mensagem.replace('?', '\u00da');
    mensagem = mensagem.replace('?', '\u00d9');
    mensagem = mensagem.replace('?', '\u00db');
    mensagem = mensagem.replace('?', '\u00e7');
    mensagem = mensagem.replace('?', '\u00c7');
    mensagem = mensagem.replace('?', '\u00f1');
    mensagem = mensagem.replace('?', '\u00d1');
    mensagem = mensagem.replace('&', '\u0026');
    mensagem = mensagem.replace('\'', '\u0027');
    ///
    return mensagem;
    ///
}
/*****************  Final  -- function acentuarAlerts(mensagem)   ***************************/
///
/****   PARA CONSULTAR - PROJETO/ANOTACAO/EXPERIMENTO    ******/
function enviar_dados_con(source,val,string_array) {
    /// Verificando se a function exoc existe
    if(typeof exoc=="function" ) {
        ///  Ocultando ID  e utilizando na tag input comando onkeypress
         exoc("label_msg_erro",0);  
    } else {
        alert("funcion exoc nao existe. Corrigir");
        return
    }
    /// Veriaveis para enviar mensagem de erro
    var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
    msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
    var final_msg_erro = "&nbsp;</span></span>";
    

     ///  Verificando variaveis
    if( typeof(source)=="undefined" ) var source=""; 
    if( typeof(val)=="undefined" ) var val="";
    if( typeof(string_array)=="undefined" ) var string_array="";
    if( typeof(val)=="string" ) var val_upper=val.toUpperCase();
    
    /// Verifica se a variavel e uma string
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
    ///
    /// Variavel source para maiuscula
    var opcao = source.toUpperCase();
    /****  
         Define o caminho HTTP    -  20180605
     ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       
     
      /*****    
     *   Reiniciar a pagina atual 
     *     - utilizar a variavel paginal_local
     */
     if( opcao=="RESET" ) {
         parent.location.href=pagina_local;                
         return;   
     }
     ///      
     
 ///// alert(" consultar_usuario_js/34  --  source = "+source+"  --  val = "+val+"  --  string_array = "+string_array);
   
    ///   Criando os campos instituicao, unidade, departamento, setor 
    if( source.toUpperCase()=="DESCARREGAR" || source.toUpperCase()=="SELECIONAR"  ) {
        //          var m_array = string_array.split("#");
        //  var pasta = "/var/www/html/rexp3/doctos_img/A"+m_array[0];
        //  pasta += "/"+m_array[1]+"/";     
        //  $output = shell_exec('for arq in `ls '.$pasta.'/*.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done');    
        //  var arquivo = pasta+trim(val);
        //  download(arquivo); 
        /*
        if( ! file_exists("{$pasta}".$arquivo) ) {
             $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
             echo $msg_erro;  
             exit();     
        }  else {
             echo  "{$pasta}".$arquivo;
             exit();
        }  
    
          return;    
        */
        var poststr="source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array);
    }
    ///
    if( ( typeof(string_array)!='undefined') && ( source.toUpperCase()=="CONJUNTO" ) ) {
			      var m_array = string_array.split("|");
                  var poststr="source="+encodeURIComponent(source)+"&val=";
				  poststr=poststr+encodeURIComponent(val)+"&m_array="+encodeURIComponent(m_array);
				  // Total dos dados no array - m_array
				  var total_lenght = m_array.length;
				  var ult_element = total_lenght-1; 
                  if ( typeof(m_array)=="object" &&  total_lenght ) {
				       //  Campo anterior
				      var cpo_ant = m_array[0]; 
			          if( source.toUpperCase()=="CONJUNTO" ) {
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
								  poststr+="&n_cpo="+encodeURIComponent(n_sel_opc);
								  poststr+="&cpo_final="+encodeURIComponent(m_array_length);
	     			   		      break; 
						 }
				     }
				  }

			 }
     /*  
	        IF para projeto (coautores) ou experimento (colaboradores)         */
   //    if( ( source.toUpperCase()=="COAUTORES" ) ||  ( source.toUpperCase()=="COLABS" ) ) {
    if( ( source.toUpperCase()=="CORESPONSAVEIS" ) ||  ( source.toUpperCase()=="COLABS" ) ) {	   
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
	if( source.toUpperCase()=="SUBMETER" ) {
		 var frm = string_array;
		 //  var frm = document.form1;
    	 var m_elements_total = frm.length; 
		 //  var elements = document.getElementsByTagName("input");
       	 m_elements_nome = new Array(m_elements_total);
    	 m_elements_value= new Array(m_elements_total);
	 	 var m_erro = 0; var n_coresponsaveis= new Array(); 
		 var n_i_coautor=0;   var n_senhas=0;  var n_testemunhas=0;
		  var campo_nome="";   var campo_value="";
         for ( i=0; i<=m_elements_total; i++ ) {      
		    //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
		    var m_id_name = frm.elements[i].name;
	        var m_id_type = frm.elements[i].type;
	        var m_id_title = frm.elements[i].title;
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
			 //  alert(" m_id_name = "+m_id_name+" -  m_id_type = "+m_id_type)
			 if ( m_id_type== "checkbox" ) {
                //Verifica se o checkbox foi selecionado
                if( ! elements[i].checked ) var m_erro = 1;
             } else if ( m_id_type=="password" ) {
                 // Verifica se a Senha foi digitada
		         m_id_value = trim(document.getElementById(m_id_name).value);
                 if( m_id_value.length<8 )  var m_erro = 1;	
				 //  Verficando se tem dois campos senha e outro para confirmar
				 if( ( m_id_name.toUpperCase()=="SENHA" ) || ( m_id_name.toUpperCase()=="REDIGITAR_SENHA" ) ) {
					   n_senhas=n_senhas+1;
				  }	 
             } else if( m_id_type=="text" ) {  
			      m_id_value = trim(document.getElementById(m_id_name).value);
				  if( m_id_value=="" ) var m_erro = 1;	
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
  						   var confirm_text = "Co-Respons?veis";
					  }
		   			   var m_value_coresponsaveis=0;
           			   //  "coresponsaveis"
             		   m_value_coresponsaveis=document.getElementById(co_aut_col).value;
			          // m_value_coresponsaveis=document.getElementById("coautores").value;	
					  if( ( parseInt(m_id_value)<1 ) || ( m_id_value=="" ) ) {
    						var decisao = confirm("Digitar n?mero de "+confirm_text+"?");
                            if ( decisao ) {
								m_erro = 1;
                            } else {
							    m_value_coresponsaveis=0;
								m_erro = 0;
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
             //  Verificando os coautores ou colaboradores
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
	    				    m_id_title="Duplicado"; m_erro=1;
						    break;
		    			} 
				 }
                 //				 			 
			 }
             //
		     //  alert(" m_id_name = "+m_id_name+" -  m_id_type = "+m_id_type+" - m_erro = "+m_erro)
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
			 if( parseInt(m_erro)==1 ) {
                   ///  Preparando para enviar a mensagem de erro e retornar
                   var  m_id_title="Ocorreu erro em "+m_id_name;
                   if( document.getElementById(m_id_name).title ) {
                       var m_id_title=document.getElementById(m_id_name).title;
                   }
                   ///
				   m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
 				   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
  				   document.getElementById("label_msg_erro").innerHTML=msg_erro;	
				   ///  frm.m_id_name.focus();
				   ///  document.getElementById(m_id_name).focus();
				   break;
			 }
			 //
 		    campo_nome+=m_id_name+",";  
			campo_value+=m_id_value+",";
	 		if( m_id_name.toUpperCase()=="ENVIAR" )  break;
			 /*
			 if( m_id_name.toUpperCase()=="DATAFINAL" ) {
				 var value_dtinicio = trim(document.getElementById("datainicio").value);
				 var value_dtfinal = trim(document.getElementById("datafinal").value);				 
			     m_erro=verificar_datas("datainicio","datafinal",value_dtinicio,value_dtfinal);
				 alert(" m_erro =  "+m_erro) 
			} 
			*/
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
    }  //  FINAL do IF SUBMETER
	/*
	     Escolhido o Autor para encontrar seus projetos ou  experimentos
	*/
	var myreg = /projeto|anotacao|experimento/i;
    var m_val = /autor|ano|projeto|anotacao/i;
	var pos_autor = source.search(myreg);
    var pos_val =   val.search(m_val);
    // alert(" pos_autor = "+pos_autor)
   //  if( ( pos_autor!=-1 ) && ( val.toUpperCase()=="AUTOR" || val.toUpperCase()=="ANO" || val.toUpperCase()=="PROJETO" ) ) {
   if( ( pos_autor!=-1 ) && ( pos_val!=-1 ) ) {   
          if( val.toUpperCase()=="AUTOR" || val.toUpperCase()=="ANO"  ) {      
     			document.getElementById('arq_link').style.display="none"; 
               //  Removendo a tag TD referente a  TR (tr_opcoes)
			   if( document.getElementById("tr_opcoes") ) {
    			    var referencia = document.getElementById("tr_opcoes"); 
				   if( document.getElementById("novo_td") ) {
					    newElement=document.getElementById("novo_td"); 
                        referencia.removeChild(newElement);  
				   } 
                   if( document.getElementById("novo_td_anotacao") ) referencia.removeChild("novo_td_anotacao"); 
			   }
		  }
		 string_array = trim(string_array);
		 if( string_array=="" ) {
              //  options[0].selected  -> Usada para selecionar a tag Select (select-one)
			  //                          Posicao desejada no caso abaixo a primeira opcao
			  document.getElementById('autor').options[0].selected=true;  
  			  document.getElementById('arq_link').style.display="none"; 
	          document.getElementById('td_proj_ou_expe').style.display="none"; 
			  return;					  
		 }
		 var poststr="source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(string_array);
    } 
    /*   Aqui eu chamo a class  */
	var myConn = new XHConn();
		
	/*  Um alerta informando da não inclus?o da biblioteca   */
    if ( !myConn ) {
	      alert("XMLHTTP não dispon?vel. Tente um navegador mais novo ou melhor.");
		  return false;
    }
	//
	//  Serve tanto para o arquivo projeto  quanto para o experimento - CONSULTAR
   // var receber_dados = arquivo php na pasta consultar
   //// var receber_dados = "proj_exp_ajax.php";
    var receber_dados = "usuario_consultar_ajax.php";
    
    
	/*  Melhor usando display do que visibility - para ocultar e visualizar   
    	document.getElementById('div1').style.display="block";
	    document.getElementById('div1').className="div1";
    */
	 var inclusao = function (oXML) { 
                       ///  Recebendo os dados do arquivo ajax
                       var m_dados_recebidos = oXML.responseText;
                       if( document.getElementById('label_msg_erro') ) {
                            document.getElementById('label_msg_erro').style.display="none";   
                       }
                       
   ///    alert(" usuario_consultar_js/341 - source = "+source+" - m_dados_recebidos = "+m_dados_recebidos)                         
         
                        /// if( ( source.toUpperCase()=="COAUTORES" ) ||  ( source.toUpperCase()=="COLABS" ) ) {
                        if( ( source.toUpperCase()=="CORESPONSAVEIS" ) ||  ( source.toUpperCase()=="COLABS" ) ) {							
                              if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";	
							  document.getElementById(id_inc_pe).innerHTML= oXML.responseText;
                        } else  if( source.toUpperCase()=="DESCARREGAR"   ) { 
                              var pos = m_dados_recebidos.search(/Nenhum|ERRO:/i);
                               if( pos!=-1 ) {
                                      document.getElementById('label_msg_erro').style.display="block";
                                      document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                               } else {
                                     // download(m_dados_recebidos); 
                                     // alert(m_dados_recebidos)
                                     alert("\r\nCaso o Internet Explorer bloqueie o download, fa?a o seguinte:\r\n\r\n Op??o - Via Ferramentas do Internet Explorer\r\n 1 - Abra o Op??es do Internet Explorer e clique na aba Seguran?a.\r\n 2 - Clique no bot?o N?vel Personalizado e dentro de Configura??es de Seguran?a, localize o recurso Downloads \r\n3 - Em: Aviso autom?tico para downloads de arquivo e selecione Habilitar")
                                      var array_arq = m_dados_recebidos.split("%");
                                     // window.open("../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]));
                                      //  self.location.href="../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                                     // window.open("../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]),"SISTAM/REXP");
                                      self.location.href="../includes/baixar.php?pasta="+encodeURIComponent(array_arq[0])+"&file="+encodeURIComponent(array_arq[1]);
                                }
                        } else  if(  source.toUpperCase()=="SELECIONAR" ) {                                 
                                //  Depois de ter selecionado uma Letra ou Todos na pesquisa
                                //  alert(" m_dados_recebidos =  "+m_dados_recebidos)
                                document.getElementById('tab_de_bens').style.display="block";                              
                                document.getElementById('tab_de_bens').innerHTML=m_dados_recebidos;                                
      				    } else  if(  source.toUpperCase()=="CONJUNTO"   ) { 
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
            	                   var pos = m_dados_recebidos.search(/Nenhum|Erro/i);  
							       if( pos != -1 )  {
									   limpar_campos(new_elements);
									   // Voltar para o inicio da tag Select
					                   document.getElementById('instituicao').options[0].selected=true;
									   document.getElementById('instituicao').options[0].selectedIndex=0;
									   document.getElementById(id_cpo).style.display="none";
						               mensg_erro(m_dados_recebidos,"label_msg_erro");
									   document.getElementById('instituicao').focus();
							       } else if( pos == -1 ) {
 							          if( n_sel_opc<=m_array_length ) {
								           document.getElementById(id_cpo).style.display="block";
								           document.getElementById(id_cpo).innerHTML=m_dados_recebidos;
								      }
							       }
							  }
						}  else  if( source.toUpperCase()=="PROJETO" || source.toUpperCase()=="ANOTACAO" ) { 
                               //
                               var pos = m_dados_recebidos.search(/ERRO:/i);
                               if( pos!=-1 ) {
                                      if( document.getElementById('arq_link') ) document.getElementById('arq_link').style.display="none";
                                      document.getElementById('label_msg_erro').style.display="block";
                                      document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                               } else {
                                      document.getElementById('label_msg_erro').style.display="none";
                                    //  document.getElementById('msg_erro').style.display="block";     
                                    if( val.toUpperCase()=="S_COORD_ANOTA" ) {
                                        var array_dados = string_array.split("+");
                                        return;  
                                   } else if( val.toUpperCase()=="AUTOR" ) {
                                          document.getElementById('td_proj_ou_expe').style.display="block";
                                          document.getElementById('td_proj_ou_expe').innerHTML=m_dados_recebidos;
							       } else if( val.toUpperCase()=="ANO" ) {
        								  //  Criando um Elemento TD filho de uma TR (id=tr_opcoes)
    	      				 	       document.getElementById('td_proj_ou_expe').style.display="block";
				     				   //  document.getElementById('td_proj_ou_expe').innerHTML=m_dados_recebidos;
					    		  	   // 1
                                       var newElement = document.createElement("TD"); 
	                                  // 2
    								  newElement.id = "novo_td"; 
    								  newElement.className="td_inicio1";
    								  newElement.style.textAlign = "left";
                                      // 3
                               	      var referencia = document.getElementById("tr_opcoes"); 
                                      // 4
    							      referencia.appendChild(newElement);
							          document.getElementById('novo_td').innerHTML=m_dados_recebidos;								
							      } else if( val.toUpperCase()=="PROJETO" && source.toUpperCase()=="PROJETO" ) {
					    	          document.getElementById('arq_link').style.display="block";
							          document.getElementById('arq_link').innerHTML=m_dados_recebidos;
							      }  else if( val.toUpperCase()=="PROJETO" && source.toUpperCase()=="ANOTACAO" ) {
                                      //  Criando um Elemento TD filho de uma TR (id=tr_opcoes)
                                      //    document.getElementById('td_proj_ou_expe').style.display="block";
                                      //  document.getElementById('td_proj_ou_expe').innerHTML=m_dados_recebidos;
                                      // 1
                                       var newElement = document.createElement("TD"); 
                                      // 2
                                      newElement.id = "novo_td_anotacao"; 
                                      newElement.className="td_inicio1";
                                      newElement.style.textAlign = "left";
                                      // 3
                                         var referencia = document.getElementById("tr_opcoes"); 
                                      // 4
                                      referencia.appendChild(newElement);
                                      document.getElementById('novo_td_anotacao').innerHTML=m_dados_recebidos;                                
                                 } else if( val.toUpperCase()=="ANOTACAO" && source.toUpperCase()=="ANOTACAO" ) {
                                      document.getElementById('arq_link').style.display="block";
                                      document.getElementById('arq_link').innerHTML=m_dados_recebidos;
                                 }
                               }    
						} else {
						      var pos = m_dados_recebidos.search(/ERRO:/i);
                              //  Verficar se o elemento existe
					 	      if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";
							  if( pos!=-1 ) {
                                   document.getElementById('label_msg_erro').style.display="block";
                                   document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
							  } else {
   					 	          document.getElementById('label_msg_erro').style.display="none";	
								  if( source.toUpperCase()=="SUBMETER" ) {
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
									  }
    								  document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
									  if( document.getElementById('arq_link') ) document.getElementById('arq_link').style.display="block";
									  //   document.getElementById('div_form').innerHTML=m_dados_recebidos;
								  } else {
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
}  //  FINAL da Function enviar_dados_con para AJAX 
//
/*
     Function para o Donwload/Carregar  do Servidor para o Local
*/
function download(m_id) {
   //  var m_id_val = document.getElementById(m_id).value;
	//  self.location.href='baixar.php?file='+m_id_val;
    self.location.href='../includes/baixar.php?file='+m_id;
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
  			document.getElementById("label_msg_erro").style.display="";
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
//  Limpar os campos do source.toUpperCase()=="CONJUNTO"
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