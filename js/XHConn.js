/** XHConn - Simple XMLHTTP Interface - bfults@gmail.com - 2005-04-08        **
 ** Code licensed under Creative Commons Attribution-ShareAlike License      **
 ** http://creativecommons.org/licenses/by-sa/2.0/                           **/
//
/*  XHConn() - a class para iniciar  */
function  XHConn() {
    //  Variaveis: xmlhttp para XMLHttp  e  bComplete para acompanhar processo
    var xmlhttp; bComplete = false;
	   
    /*  xmlhttp
       Já vimos que para nos comunicarmos com um documento web via AJAX 
	   devemos criar o objeto XMLHttpRequest:                        */

     try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
    	  catch (e) { try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	      catch (e) { try { xmlhttp = new XMLHttpRequest(); }
	      catch (e) { xmlhttp = false; }}}       
	
     //  Caso ocorreu erro na xmlhttp rertonando nulo
     if (!xmlhttp) return null;
	 
	 if ( xmlhttp.overrideMimeType ) {
             // Se possível, ignora cabecalho usado pelo servidor e forca o padrao "text/xml". 
             // Alguns navegadores exigem esse padrao e pode dar erro se o servidor nao utilizar ele
             xmlhttp.overrideMimeType('text/xml');
     }
	 
     /*   --  IMPORTANTE  ---         
          sURL      -  para onde sao enviados os dados para serem analizados
	     sMethod   -  Metodo que esta sendo usado GET ou POST
	     sVars     -  Variaveis e valores enviados
	     fnDone    -  Function enviada para executar
     */
	   
     this.connect = function(sURL, sMethod, sVars, fnDone)  {
                  //  Caso ocorreu erro na xmlhttp rertonando false
		          if (!xmlhttp) return false;
     		   	  bComplete = false; 
      			  //  Variavel sMethod passando para Maiuscula - GET ou POST
     		 	  sMethod = sMethod.toUpperCase();
						   
        		 //  Iniciando try para enviar os Dados para pagina AJAX
			try {
			      /*  Verificando Metodo variavel sMethod caso for
				      GET  senao POST                                */
	    	      if ( sMethod == "GET" ) {
     				   xmlhttp.open(sMethod, sURL+"?"+sVars, true);
	     			   sVars = "";
			      } else if ( sMethod == "POST" ) {
          		           xmlhttp.open(sMethod, sURL, true);
		         		   xmlhttp.setRequestHeader("Method", "POST "+sURL+" HTTP/1.1");
						   xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			      } else {
      				   //  NENHUM METODO INFORMADO
        			   alert("NENHUM METODO INFORMADO - sMethod incorreto")
		    		   return false;
			      }
                                  
			      /*  Nesta função você irá inserir uma função(callback)
                      para que toda vez que o estado da requisição mude 
                      esta seja chamada "de volta".                      */
			      xmlhttp.onreadystatechange = function() {
			            if ( xmlhttp.readyState==4 && !bComplete) {
						    // Verificando erro 
                            var m_erro=0;
                            if (xmlhttp.status == 403) {
                                   alert("Diretório não encontrado") // Diretório não encontrado
                                   m_erro=1;
                            } else if (xmlhttp.status == 404) {
                                  alert("Problema de permissão") // Problema de permissão
                                  m_erro=1;
                            } else if ( xmlhttp.status == 500) {
                                  alert("Erro interno do servidor")
                                   m_erro=1;
                            }
                            if ( m_erro==1 ) return false;
                            //
                 		    // Tudo OK abaixo - caso nao ocorra erro
					       if ( xmlhttp.status==200 ) {	   
					            bComplete = true;
						        /* fnDone - funcao que foi enviada para executar */
								fnDone(xmlhttp);
						 
						        /*  aqui a input hidden de id=”dados” 
                                    recebe um valor que dinâmicamente 
                                    via código Javascript: cria um 
                                    objeto de referência à  tag input hidden   */
           	                     //  var objetoDados=document.getElementById(magica)
         	                     //  altera o atributo value desta tag
                   				 //  objetoDados.value = x_function[1]
		                    }
                        }
		            };
                    xmlhttp.send(sVars);  //  sVars -  Variaveis e valores enviados para sURL
            } catch(z) { 
		    		return false; 
			}  // FINAL do try para enviar os Dados para pagina AJAX
			    return true;
	};
  return this;
}
