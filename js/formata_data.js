//
// colocar no evento onKeyUp passando o objeto como parametro
//
function formata(val,m_event)  {
	document.getElementById("label_msg_erro").style.display="none";
	document.getElementById("label_msg_erro").innerHTML='';			  
   	var pass = val.value;
	var expr = /[0123456789]/;
    var m_pass_length = pass.length;
	var whichCode = (window.Event) ? m_event.which : m_event.keyCode;
    
// alert("val="+val+"  window.Event="+window.Event+"  Key="+m_event.keyCode);

    if ( (( whichCode == 13 ) && ( m_pass_length<1)) || (whichCode == 8)) { 
       /*
        var nome_do_campo = val.name;
   	   if ( val.name == "datainicio") {
		   nome_do_campo = "datainicio";
	   } else if ( val.name == "datafinal" )  {
		   nome_do_campo = "datafinal";
	   }
       */
       document.getElementById(val.name).disabled = false;					
       return document.getElementById(val.name).focus();
	}
		
	for(i=0; i<pass.length; i++){
		// charAt -> retorna o caractere posicionado no índice especificado
		var lchar = val.value.charAt(i);
		var nchar = val.value.charAt(i+1);
	
		if(i==0){
		   // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
		   // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
		   // instStr.search(expReg);
		   if ((lchar.search(expr) != 0) || (lchar>3)){
			  val.value = "";
		   }
		   
		} else if(i==1){
			   
			   if(lchar.search(expr) != 0){
				  // substring(indice1,indice2)
				  // indice1, indice2 -> será usado para delimitar a string
				  var tst1 = val.value.substring(0,(i));
				  val.value = tst1;				
 				  continue;			
			   }
			   
			   if ((nchar != '/') && (nchar != '')){
				 	var tst1 = val.value.substring(0, (i)+1);
				
					if(nchar.search(expr) != 0) 
						var tst2 = val.value.substring(i+2, pass.length);
					else
						var tst2 = val.value.substring(i+1, pass.length);
	
					val.value = tst1 + '/' + tst2;
			   }

		 }else if(i==4){
			
				if(lchar.search(expr) != 0){
					var tst1 = val.value.substring(0, (i));
					val.value = tst1;
					continue;			
				}
		
				if	((nchar != '/') && (nchar != '')){
					var tst1 = val.value.substring(0, (i)+1);

					if(nchar.search(expr) != 0) 
						var tst2 = val.value.substring(i+2, pass.length);
					else
						var tst2 = val.value.substring(i+1, pass.length);
	
					val.value = tst1 + '/' + tst2;
				}
   		  }
		
		  if(i>=6){
			  if(lchar.search(expr) != 0) {
					var tst1 = val.value.substring(0, (i));
					val.value = tst1;			
			  }
		  }
	 }
     // if( pass.length>10) {
	 if( pass.length==10) {
		  val.value = val.value.substring(0, 10);
		//  str.value = val.value.substring(0, 10);
		//  dia = (str.value.substring(0,2)); 
		dia = (val.value.substring(0,2)); 
        //  mes = (str.value.substring(3,5)); 
		mes = (val.value.substring(3,5)); 
    	//  ano = (str.value.substring(6,10)); 
		ano = (val.value.substring(6,10)); 
    	cons = true; 
	// verifica se foram digitados números
	if (isNaN(dia) || isNaN(mes) || isNaN(ano)){
		alert("Preencha a data somente com números."); 
		str.value = "";
		str.focus(); 
		return false;
	}
		
    // verifica o dia valido para cada mes 
    if ( (dia < 01)||(dia < 01 || dia > 30) && 
			( mes == 04 || mes == 06 ||  mes == 09 || mes == 11 ) ||  dia > 31 ) { 
    	cons = false; 
	} 

	// verifica se o mes e valido 
	if (mes < 01 || mes > 12 ) {  
		cons = false; 
	} 

	// verifica se e ano bissexto 
	if (mes == 2 && ( dia < 01 || dia > 29 || 
	   ( dia > 28 &&  ( parseInt(ano / 4) != ano / 4 )))) { 
		cons = false; 
	} 
    data_atual_ano = new Date();
    ano_atual = data_atual_ano.getFullYear();
	//  Desativando: Verificando ano digitado com o ano atual no computador
	//  if ( ( cons == false ) || ( ano > ano_atual ) ) { 
	if ( cons==false )  { 	
		// alert("A data inserida não é válida: " + str.value); 
		alert("A data inserida não é válida: " + val.value); 
		//  str.value = "";
		val.value = "";
		//  str.focus(); 
		val.focus(); 
		return false;
	} else {
		   if ( val.name == "datainicio") {
				nome_do_campo = "datainicio"
		   } else if( val.name == "datafinal") {
			   nome_do_campo = "datafinal"
	       }
           document.getElementById(nome_do_campo).disabled = false;					
           return document.getElementById(nome_do_campo).focus();						    
	} 
 } 	
 	return true;
}
//
//
// VERIFICA SE DATA FINAL É MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)
var m_erro=0;
function verificadatas(dtinicial_nome, dtfinal_nome, dtInicial, dtFinal) {
    /// document.getElementById("label_msg_erro").style.display="none";
    //// document.getElementById("label_msg_erro").innerHTML='';              
    
    ///  Ocultando mensagem de erro
    exoc("label_msg_erro",0,"");

	var dtini_nome = dtinicial_nome;
	var dtfim_nome = dtfinal_nome;
	///  var dtini = dtInicial;
	///  var dtfim = dtFinal;
    
	////  if (( dtini=='' ) && ( dtfim=='' ) ) {
    ///  if ( ( dtini=='' ) || ( dtfim=='' ) ) {		
    if( ( dtInicial.length<10 ) || ( dtFinal.length<10 ) ) {        
		// alert('Complete os Campos.');
		//  campos.inicial.focus();
		//  return false;
		m_corrigir = confirm("Digitar as datas?"); 
        if ( m_corrigir ==true ) {   // testa se o usuario clicou em cancelar
  			document.getElementById("label_msg_erro").style.display="";
   		   msg_erro = '<span class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
		   final_msg_erro = '</span></span>';
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
	/*  Alterado em 20170127  
	datInicio = new Date(dtini.substring(6,10), 
						 dtini.substring(3,5), 
						 dtini.substring(0,2));
	datInicio.setMonth(datInicio.getMonth() - 1); 
	
	
	datFim = new Date(dtfim.substring(6,10), 
					  dtfim.substring(3,5), 
					  dtfim.substring(0,2));
					 
	datFim.setMonth(datFim.getMonth() - 1); 
    */
    
    /// Converte as datas em milisegundos
    var datInicio = new Date(dtInicial).getTime();
    var datFim = new Date(dtFinal).getTime();
    ///
	if( datInicio<=datFim ){
		 // alert('Cadastro Completo!');
		m_erro = 0;
		return m_erro;
		//  return true;
	} else {
		   alert('ATENÇÃO: Data Inicial é MAIOR que Data Final');
		  document.getElementById("label_msg_erro").style.display="block";
     	  document.getElementById("label_msg_erro").innerHTML="";
   		  var msg_erro = '<p class="texto_normal" style="color: #000; text-align: center; line-height: 10%;"><span style="color: #FF0000;">ERRO:';
     	  var final_msg_erro = '&nbsp;</span></p>';
		  m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;Data Inicial é MAIOR que Data Final</span>";
 		  msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
		  document.getElementById("label_msg_erro").innerHTML=msg_erro;				  
   	   	  document.getElementById(dtini_nome).focus();	
          m_erro = 1;
	      return m_erro;
   }	
}
//
// 2. VERIFICA SE DATA FINAL É MAIOR - 
function verifica_Datas_parte2(campo_inicial,dtInicial,campo_final,dtFinal){
	var dtini = dtInicial;
	var dtfim = dtFinal;
	if ((dtini == '') && (dtfim == '')) {
	  //	alert('Complete os Campos.');
	    resposta = confirm("Completar os campos?")
		if ( resposta==false) {  // testa se o usuario clicou em cancelar
            return true;
        } else {
    		campos.inicial.focus();
	    	return false;
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

	if( datInicio <= datFim ) {
		//  alert('Cadastro Completo!');
		return true;
	} else {
        alert('ATENÇÃO: Data Inicial é maior que Data Final');
		$("#"+campo_final.name).val("");
        $("#"+campo_final.name).focus();
        // $("#"+campo_final.name).select();
       // document.all.campos.final.focus();
	   //	document.all.campos.final.select();
		return false;
	}	
}
//
// VALIDA O CAMPO DATA PASSANDO O FOCO 
function verificaFoco(objeto,foco) {
	if (objeto.value.length == 10) {							
		foco.focus();
		return false;
	}
}
// colocar no evento onKeyUp passando o objeto como parametro
function FormatMesAno(val)
{
   	var strPass = val.value;
	var mikExp = /[0123456789]/;
		
	for(i=0; i<strPass.length; i++){
		// charAt -> retorna o caractere posicionado no índice especificado
		var lchar = val.value.charAt(i);
		var nchar = val.value.charAt(i+1);
	
		if(i==0){
		   // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
		   // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
		   // instStr.search(expReg);
		   if ((lchar.search(mikExp) != 0) || (lchar>3)){
			  val.value = "";
		   }
		   
		}else if(i==1){
			   
			   if(lchar.search(mikExp) != 0){
				  // substring(indice1,indice2)
				  // indice1, indice2 -> será usado para delimitar a string
				  var tst1 = val.value.substring(0,(i));
				  val.value = tst1;				
 				  continue;			
			   }
			   
			   if ((nchar != '/') && (nchar != '')){
				 	var tst1 = val.value.substring(0, (i)+1);
				
					if(nchar.search(mikExp) != 0) 
						var tst2 = val.value.substring(i+2, strPass.length);
					else
						var tst2 = val.value.substring(i+1, strPass.length);
	
					val.value = tst1 + '/' + tst2;
			   }

		 }else if(i==4){
			
				if(lchar.search(mikExp) != 0){
					var tst1 = val.value.substring(0, (i));
					val.value = tst1;
					continue;			
				}
		
				if	((nchar != '/') && (nchar != '')){
					var tst1 = val.value.substring(0, (i)+1);

					if(nchar.search(mikExp) != 0) 
						var tst2 = val.value.substring(i+2, strPass.length);
					else
						var tst2 = val.value.substring(i+1, strPass.length);
	
					val.value = tst1 + '/' + tst2;
				}
   		  }
		
		  if(i>=6){
			  if(lchar.search(mikExp) != 0) {
					var tst1 = val.value.substring(0, (i));
					val.value = tst1;			
			  }
		  }
	 }
	
     if(strPass.length>10)
		val.value = val.value.substring(0, 10);
	 	return true;
}
//
// Evento onKeyUp para verificar DATA - outra funcao - Parte 1
function verifica_data1(val)  {
   	var pass = val.value;
	var expr = /[0123456789]/;
    var m_pass_length = pass.length;
	/* var whichCode = (window.Event) ? m_event.which : m_event.keyCode;
    if ( ( whichCode == 13 ) && ( m_pass_length<1  ) ) { 
         return true;
	} */
	for(i=0; i<pass.length; i++){
		// charAt -> retorna o caractere posicionado no índice especificado
		var lchar = val.value.charAt(i);
		var nchar = val.value.charAt(i+1);
	
		if(i==0){
		   // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
		   // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
		   // instStr.search(expReg);
		   if ((lchar.search(expr) != 0) || (lchar>3)){
			  val.value = "";
		   }
		   
		}else if(i==1){
			   
			   if(lchar.search(expr) != 0){
				  // substring(indice1,indice2)
				  // indice1, indice2 -> será usado para delimitar a string
				  var tst1 = val.value.substring(0,(i));
				  val.value = tst1;				
 				  continue;			
			   }
			   
			   if ((nchar != '/') && (nchar != '')){
				 	var tst1 = val.value.substring(0, (i)+1);
				
					if(nchar.search(expr) != 0) 
						var tst2 = val.value.substring(i+2, pass.length);
					else
						var tst2 = val.value.substring(i+1, pass.length);
	
					val.value = tst1 + '/' + tst2;
			   }

		 }else if(i==4){
			
				if(lchar.search(expr) != 0){
					var tst1 = val.value.substring(0, (i));
					val.value = tst1;
					continue;			
				}
		
				if	((nchar != '/') && (nchar != '')){
					var tst1 = val.value.substring(0, (i)+1);

					if(nchar.search(expr) != 0) 
						var tst2 = val.value.substring(i+2, pass.length);
					else
						var tst2 = val.value.substring(i+1, pass.length);
	
					val.value = tst1 + '/' + tst2;
				}
   		  }
		
		  if(i>=6){
			  if(lchar.search(expr) != 0) {
					var tst1 = val.value.substring(0, (i));
					val.value = tst1;			
			  }
		  }
	 }
	
     if( pass.length==10 ) {
	   val.value = val.value.substring(0, 10);
	 	return true;
     }
	 //	return true;
}  // Final parte 1 - DATA onkeyup verifica_data
//
// Evento onKeyUp para verificar DATA - outra funcao - Parte 2
function verifica_data2(val)  {
		var str = val.value.substring(0, 10);
		str = str.toString();
		var val_id = val.id;		
		cons = true; 
		if ( str.length>=1 && str.length<10 ) {
			cons = false; 
		}
        if ( str=="" ) return true;		
		dia = (str.substring(0,2)); 
        mes = (str.substring(3,5)); 
        ano = (str.substring(6,10));     	
	   	// verifica se foram digitados números
    	if (isNaN(dia) || isNaN(mes) || isNaN(ano)){
	    	alert("Preencha a data somente com números."); 
		    // str.value = ""; str.focus(); 
    		//  return false;
			$("#"+val_id).val(''); 
		   // str.focus();
		   $("#"+val_id).focus();
		   //  event.returnValue=false;
 		   return false;
	    } 
		
	    // verifica o dia valido para cada mes 
        if ((dia < 01)||(dia < 01 || dia > 30) && 
	     	(mes == 04 || mes == 06 || 
		      mes == 09 || mes == 11 ) ||  dia > 31) { 
        	cons = false; 
	    } 
    	// verifica se o mes e valido 
	    if (mes < 01 || mes > 12 ) { 
		    cons = false; 
	    } 
    	// verifica se e ano bissexto 
	   if (mes == 2 && ( dia < 01 || dia > 29 || 
	       ( dia > 28 &&   (parseInt(ano / 4) != ano / 4)))) { 
		    cons = false; 
	   } 
       //
       if (cons == false) { 
		  alert("A data inserida não é válida: " + str); 
          $("#"+val_id).val(''); 
		  // str.focus();
		  $("#"+val_id).focus();
		//  event.returnValue=false;
		  return false;
	   } 
}
//
function verificaCEP(campo,valor){
  //  var CEP = document.form3.CEP.value;
  var CEP = valor;
  //  var valorCEP = isNaN(document.form3.CEP.value);  //verifica se só possui números
  var valorCEP = isNaN(document.getElementById(campo).value);  //verifica se só possui números
  var  msg_erro = "<span class='texto_normal' style='color: #000; text-align: center;' >ERRO:&nbsp;<span style='color: #FF0000;'>";
  if(  valorCEP || CEP.length != 8 ) {
        //  document.form3.CEP.style.backgroundColor = "#FF333A";
		if ( CEP.length < 1 ) {
			 m_corrigir = confirm("Digitar CEP com 8 números?"); 
             if ( m_corrigir == true ) {   // testa se o usuario clicou em cancelar
   			     msg_erro = msg_erro+'Digitar CEP com 8 n&uacute;meros</span></span>';
    		     document.getElementById("label_msg_erro").innerHTML=msg_erro;
               	 return document.getElementById(campo).focus();
             } else {
 			 	document.getElementById("label_msg_erro").style.display="none";
				 document.getElementById("label_msg_erro").innerHTML="";
			 }
		} else { 
    		document.getElementById(campo).backgroundColor = "#FF333A";
             //  document.form3.CEP.value = "";
            document.getElementById(campo).value="";
            alert("O CEP possui "+CEP.length+" dígitos.\nDigite somente números.");
		    return   document.getElementById(campo).focus();
		}
  } else {
        //  document.form3.CEP.style.backgroundColor = "transparent";
		document.getElementById(campo).backgroundColor = "transparent";
        var prefixo = CEP.substr(0, 5);
        var sufixo = CEP.substr(5, 7);
        //  document.form3.CEP.value = prefixo+"-"+sufixo+"";
		//  document.getElementById(campo).value = 	prefixo+"-"+sufixo+"";
		document.getElementById(campo).value = 	prefixo+sufixo+"";
  }
}

/* Function Pai de Mascaras */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
//  Final de settimeout

/* Function que Executa os objetos */
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

/* Function que Determina as expressões regulares dos objetos */
function leech(v){
     v=v.replace(/o/gi,"0")
     v=v.replace(/i/gi,"1")
     v=v.replace(/z/gi,"2")
     v=v.replace(/e/gi,"3")
     v=v.replace(/a/gi,"4")
     v=v.replace(/s/gi,"5")
     v=v.replace(/t/gi,"7")
     return v
}

// Validar E_Mail
function checkEmail(m_email_nome,m_email_valor) {
   var filtro=/^.+@.+\..{2,3}$/;
   // if ( filtro.test(document.form.email.value) == false ) {
  if ( m_email_valor.length<1 ) return true;	   
  if ( filtro.test(m_email_valor) == false ) {	
    alert("O e-mail informado não é válido");
    // document.form.email.focus();
    document.getElementById(m_email_nome).value="";
    return   document.getElementById(m_email_nome).focus();
  }
  return true;
}
/* Function que permite apenas numeros */
function soNumeros(v){
    return v.replace(/\D/g,"")
}
/* Function que padroniza telefone (11) 4184-1241 */
function telefone(v){
    v=v.replace(/\D/g,"")                 /// Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") /// Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    /// Coloca hífen entre o quarto e o quinto dígitos
    return v
}

function site(v){
    // Esse sem comentarios para que você entenda sozinho ;-)
    v=v.replace(/^http:\/\/?/,"")
    dominio=v
    caminho=""
    if(v.indexOf("/")>-1)
        dominio=v.split("/")[0]
        caminho=v.replace(/[^\/]*/,"")
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    caminho=caminho.replace(/([\?&])=/,"$1")
    if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    v="http://"+dominio+caminho
    return v
}

// adiciona mascara de cnpj
function MascaraCNPJ(cnpj) {
    if(mascaraInteiro(cnpj)==false){
        event.returnValue = false;
    }    
    return formataCampo(cnpj, '00.000.000/0000-00', event);
}


//valida numero inteiro com mascara
function mascaraInteiro(){
    if (event.keyCode < 48 || event.keyCode > 57){
        event.returnValue = false;
        return false;
    }
    return true;
}

// valida o CNPJ digitado
function ValidarCNPJ(ObjCnpj){
    var cnpj = ObjCnpj.value;
    var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
    var dig1= new Number;
    var dig2= new Number;
    
    exp = /\.|\-|\//g
    cnpj = cnpj.toString().replace( exp, "" ); 
    var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));
        
    for(i = 0; i<valida.length; i++){
        dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);    
        dig2 += cnpj.charAt(i)*valida[i];    
    }
    dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
    dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));
	    
    if ( cnpj.length<1 ) return true;
    if ( ( (dig1*10)+dig2 ) != digito ) {    
  	     alert('CNPJ Inválido!');
		 document.getElementById("cnpj").value="";
		 return document.getElementById("cnpj").focus();
	}        
}

// formata de forma generica os campos
function formataCampo(campo, Mascara, evento) { 
    var boleanoMascara; 
    
    var Digitato = evento.keyCode;
    exp = /\-|\.|\/|\(|\)| /g
    campoSoNumeros = campo.value.toString().replace( exp, "" ); 
   
    var posicaoCampo = 0;     
    var NovoValorCampo="";
    var TamanhoMascara = campoSoNumeros.length;; 
    
    if (Digitato != 8) { // backspace 
        for(i=0; i<= TamanhoMascara; i++) { 
            boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                                || (Mascara.charAt(i) == "/")) 
            boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(") 
                                || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 
            if (boleanoMascara) { 
                NovoValorCampo += Mascara.charAt(i); 
                  TamanhoMascara++;
            }else { 
                NovoValorCampo += campoSoNumeros.charAt(posicaoCampo); 
                posicaoCampo++; 
              }            
          }     
        campo.value = NovoValorCampo;
          return true; 
    }else { 
        return true; 
    }
}
//  Aceitando apenas - Numero e ponto
function somente_numero(campo)  {
	var digits="0123456789."   
	var campo_temp   
	chr = campo.value.length;
	maxchr = campo.getAttribute("maxlength");
	//
	for (var i=0;i<campo.value.length;i++){   
    	 campo_temp=campo.value.substring(i,i+1)   
	     if (digits.indexOf(campo_temp)==-1){   
            campo.value = campo.value.substring(0,i);   
	     }   
	}  
	if ( chr == maxchr) {
	   return mudando_de_campo(campo);	
	}
}
//
//  Mudando de campo conforte o  maxlength
function mudando_de_campo(obj) {
teste_name = obj.name ;	
chr = obj.value.length;
maxchr = obj.getAttribute("maxlength");
//  document.getElementById("caracteres").value = chr;
if ( chr == maxchr) {
        /*  Exemplo com o  id em sequencia ex.:  id=1 id=2
	      nextInput = parseInt(obj.id) + 1;
          document.getElementById(nextInput).focus();   */
	/*
	   var theForm = document.forms[0];
          m_theForm_length = theForm.elements.length;
	    for ( m_id=0; m_id<=m_theForm_length; m_id++ ) {
		     // m_elements_nome = document.forms[0].elements[m_id].id; 
			 m_elements_nome = theForm.elements[m_id].id; 
	 		 alert(" m_elements_nome =   "+m_elements_nome+" m_id = "+m_id)		 
    		 if ( m_elements_nome == teste_name ) {
				    m_id++
					break;
			 }
	    }
		// m_elements_nome = theForm.elements[m_id].id; 
		 alert(" m_theForm_length =  "+m_theForm_length+" m_id = "+m_id)		 
         m_nome_element = theForm.elements[m_id].id;
		 return  document.getElementById(m_nome_element).focus();
		 */
		 var i;
         for (i = 0; i <= obj.form.elements.length; i++)
                if (obj == obj.form.elements[i] ) break;
               // i = (i + 1) % obj.form.elements.length;
			    i = (i + 1);
				if ( obj.form.elements.length<i ) i =  obj.form.elements.length;
				if ( teste_name=="confirm" &&  maxchr==5 ) {
		            document.getElementById("imagems_src").focus();					
				} else  obj.form.elements[i].focus();
           return false;
}
}
//  SEXO
function  sexo_teste(campo)  {
    var digits="MF"   
    var campo_temp  = campo.toUpperCase()   
    //  campo.value = campo.value.toUpperCase()   
  //  for (var i=0;i<campo.value.length;i++){   
            //   campo_temp=campo.value.substring(i,i+1)   
             if ( digits.indexOf(campo_temp)==-1 ) {
               //  campo.value = campo.value.substring(0,i);   
			   campo.value = ""
			   return false
             } else {
				  return mudando_de_campo(campo)
    		   //  return true
	         }  
   // }
}

//  Funcoes  em javascript - mudar cor do objeto
//
function mudar_cor_botao(celula,opcao) {
	//  alert(" celula,opcao -  "+celula+" opcao  =  "+opcao);
   if( opcao ) {
      celula.style.background='#00FF00';
   } else { 	
     // celula.style.background='#FFFAFA';  //  Branco Neve   	   
	  celula.style.background='#CDCDCD';     	   	  
   }   
   return;
}
//   Somente numeros - corrigido em 20101008
function numerico(field,event) {
         //  var e = (e)? e : event;
		 var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
         var tecla = keyCode;
        /*    Vamos utilizar o objeto event para identificar 
              quais teclas estão sendo pressionadas.       
              teclas 13 e 9 sao Enter e TAB
         */
        if( !(tecla >= 48 && tecla <= 57 ) && !( tecla==13  ||  tecla==9 ) ) {
              /* A propriedade keyCode revela o código ASCII da tecla pressionada. 
                Sabemos que os números de 0 a 9 estão compreendidos entre 
                os valores 48 e 57 da tabela referida. Então, caso os valores 
                não estejam(!) neste intervalo, a Function retorna falso para quem
                a chamou.  Menos keyCode igual 13  */
		      alert("Apenas NÚMEROS são aceitos!");
			 field.focus();
               field.select();
		     return false;
		}
}

