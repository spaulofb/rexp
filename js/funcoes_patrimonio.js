///
///   JavaScript Document
///
/****
*      O canvas é uma área retangular onde o usuário, via JavaScript, 
*      vai poder controlar todos os pixels, além de desenhar vários 
*      elementos gráficos como círculo, retângulo, elipse, linha, texto, imagens, etc. 
*      Para usar um elemento canvas no documento, além da inclusão da tag, 
*      temos que manipular o elemento via JavaScript:
*****/
///
if( document.getElementById("myCanvas") ) {
    var myCanvas = document.getElementById("myCanvas");
    var canvas =  myCanvas.getContext("2d");
    canvas.fill("#FF0000");
    canvas.fillRect(0,0,100,100);
}
charset="utf-8";
///
/****  --------------------------------------------------   ******/
/****
*            Funcoes  em javascript
****/
///   Corrigir os campos retirando os Espacos Desnecessários 
function acertar_espacos(campo,campo_value) {
    //  verificando os espacos no campo nome 
    var teste =   campo_value.replace(/ +/g," ");
    // document.getElementById(campo).value=trim(teste);  trim = teste.replace(/^\s+|\s+$/g,"")
    document.getElementById(campo).value=teste.replace(/^\s+|\s+$/g,"");
    return;
}
/****************************************************************************/
///
///  Funcao para alinhar o campo
function alinhar_texto(id,valor) {
    if( document.getElementById(id) ) {
       if( typeof document.getElementById(id)=='string'  )  {
            alert("PASSOU FUNCOES.JS")
            var id_valor = document.getElementById(id).value;
            document.getElementById(id).value=trim(id_valor);
           ///
       }
    }
    ///
    return;
    ///
}
/****    Final - function alinhar_texto(id,valor) {  ****/
///
///  Desativar elemento de mensagem
function desat_msg(a,b) {
    if( document.getElementById(a) ) {
         document.getElementById(a).style.display="none";  
    } 
    if( document.getElementById(b) ) {
          document.getElementById(b).style.display="none";  
    }
    /// 
}
/****  Final - function desat_msg(a,b) {  ****/
///
///
/******   function desativar() - desativar alguns IDs   ********/
function desativar() {
     ///
     /****  Ativando a opcao m_botao_atributo - para incluir atributo   *****/
     if( document.getElementById('m_botao_atributo') ) {
          ///
          /// Verifica caso estiver Desativado - ativar elemento
          ///  document.getElementById('m_botao_atributo').disabled = false;  
          var tdisp = document.getElementById('m_botao_atributo').disabled;
          if( tdisp!=false ) {
                 document.getElementById('m_botao_atributo').disabled = false;  
          } 
          ///
          ///  elemento checked false
          ///  document.getElementById('m_botao_atributo').checked=false;
          var tdisp = document.getElementById('m_botao_atributo').checked;
          if( tdisp!=false ) {
              document.getElementById('m_botao_atributo').checked=false;
          } 
          ///
     } 
     /****   Final - if( document.getElementById('m_botao_atributo') ) {  ****/
     ///
     if( document.getElementById('label_salvar_patrimonio') ) {
          var lsp = document.getElementById('label_salvar_patrimonio');
       /*****     document.getElementById('label_salvar_patrimonio').style.display = "block";  *****/
          var tdisp =  lsp.style.display;
          if( tdisp!="block" ) {
               lsp.style.display="block";   
          }
          ///
         if( document.getElementById('m_salvar_patrimonio') ) { 
             document.getElementById('m_salvar_patrimonio').disabled = false;
         }
         /****   Final - if( document.getElementById('m_salvar_patrimonio') ) {   *****/
         ///
     }  
     /****   Final - if( document.getElementById('label_salvar_patrimonio') ) {  ****/
     ///
     
/***     
    alert("function desativar  -->> LINHA/256  <<<--- ");     
***/     
     
     if( document.getElementById('label_cancelar_patrimonio') ) { 
       /*****  document.getElementById('label_cancelar_patrimonio').style.display="block";    ****/
          var lcp = document.getElementById('label_cancelar_patrimonio');
          var xdisp =  lcp.style.display;
          if( xdisp!="block" ) {
               lcp.style.display="block";   
          }
          ///
          if( document.getElementById('m_cancelar_patrimonio') ) { 
              document.getElementById('m_cancelar_patrimonio').disabled = false;
          }
          ///
     } 
     ///
     if( document.getElementById('atributo') ) {
          /// Verifica caso estiver Ativado - desativar elemento
          /// document.getElementById('atributo').disabled=true;           
          var tdisp = document.getElementById('atributo').disabled; 
          if( tdisp!=true ) {
               document.getElementById('atributo').disabled = true;
          } 
          ///
     } 
     ///
     if( document.getElementById("label_m_atributo") ) {
          /// document.getElementById('label_m_atributo').style.display="none";   
          exoc("label_m_atributo",0);    
     }
     if( document.getElementById('m_atributo') ) document.getElementById('m_atributo').disabled=true;         
     if( document.getElementById('m_atrib_descr') ) document.getElementById('m_atrib_descr').disabled=true;     
     ///
     desativar_atributo();
     return;
}
/********  Final - function desativar() - desativar alguns IDs    ********/
///
///
function dv11(NumDado, NumDig, LimMult) {
    ///
    ///  ------------------------------------------------------------------
    ///					CalculaDigitoMod11
    ///  dv11(Dado, NumDig, LimMult)
    ///  Retorna o(s) NumDig Dígitos de Controle Módulo 11 do NumDado
    ///  limitando o Valor de Multiplicação em LimMult:
    /// 
    ///  Números Comuns:     NumDig     LimMult
    ///       CPF               2           12
    ///       CNPJ              2            9
    ///       PIS,C/C,Age       1            9
    ///  ------------------------------------------------------------------
	var Dado = NumDado;
	var n;
	var dv="";
	for(n=1; n<=NumDig; n++) {
		var Soma = 0;
		var Mult = 2;
		var i;
		for(i=Dado.length - 1; i>=0; i--){
			Soma += Mult * parseInt(Dado.substr(i,1));
			if(++Mult > LimMult) Mult = 2;
		}
		var digito = ((Soma * 10)%11)%10 ;
		dv += digito.toString();
		Dado += digito.toString();
    }
    return dv;
    ///
}
/****   Final - function dv11(NumDado, NumDig, LimMult) {  ***/
///
///   Ativar ou Desativar  -  ID
var i_exoc=0;
function exoc(id,i_exoc,msg) {
    ///
   if( parseInt(i_exoc)<1 ) {
       if( document.getElementById(id) ) {
           if( document.getElementById(id).style.display="block"  ) {
                 document.getElementById(id).style.display="none";                   
           }
       } 
   }
   ///
   if( parseInt(i_exoc)>=1 ) {
       if( document.getElementById(id) ) {
           // Ativar ID
           if( document.getElementById(id).style.display="none"  ) {
               document.getElementById(id).style.display="block";
           }
           ///  Caso tendo mensagem para adicionar
           if( typeof msg!="undefined" ) {
               document.getElementById(id).innerHTML=msg;
           }
           ///
       } 
       i_exoc=0;
   }
   return;
}
/****   Final - function exoc(id,i_exoc,msg) {   *****/
///
///  Limpar todos os Objetos HTML da Página com JavaScript
function limpar_elements(div, subdivs) {
    //div = document.getElementById(div).firstChild;
    // div = document.getElementById(div).firstChild.nodeValue;
	var elements = document.getElementById(div).getElementsByTagName("*");
	var m_name_recebido = "";
    for (var i = 0; i < elements.length; i++) {
	        var m_id_name = elements.item(i).name;
	        var m_id_type = elements[i].type;
	        if( ( typeof m_id_name == 'undefined' ) || ( typeof m_id_type == 'undefined' ) ) continue;
	        if( ( m_id_name == m_name_recebido ) && ( typeof m_id_type == 'undefined' ) ) continue;			
			m_name_recebido = elements.item(i).name;
			field_type = m_id_type.toString();
		    switch(field_type) { 
	            case "text":  
    	        case "password":  
        	    case "textarea": 
            	case "hidden":     
                	elements[i].value = "";  
	                break; 
    	        case "radio": 
 				case "checkbox": 
					if ( elements[i].checked ) { 
                	    elements[i].checked = false;  
	                } 
    	            break; 
        	    case "select-one": 
	            case "select-multi": 
    	            elements[i].selectedIndex = 0; 
	                break; 
	            default:  
    	            break; 
            } 
	}
}
///
/****
*      Proximo Campo  
****/
function proximoCampo(objeto,e) {
    var e = (e) ? e : event;    
    var  maxchr = objeto.getAttribute("maxlength");
    var teste_name = objeto.name;
    document.getElementById(teste_name).value =  trim(document.getElementById(teste_name).value);
    var id_chr = document.getElementById(teste_name).value;
    if( id_chr.length==maxchr ) {
         var i;
         for (i = 0; i <= objeto.form.elements.length; i++)  if (objeto == objeto.form.elements[i] ) break;
                 i = (i + 1);
                  var m_id_type = objeto.form.elements[i].type;  // Quando tag  type=hidden  passar
                  if ( m_id_type=="hidden" || objeto.form.elements[i].id=="limpar"  ) i++;
                 if ( objeto.form.elements.length<i ) i =  objeto.form.elements.length;
                 if ( typeof(objeto.form.elements[i].id)!="undefined"  ) {
                           teste_name = objeto.form.elements[i].id;
                           document.getElementById(teste_name).focus();
                  }
   }
}
///   Final - Proximo Campo
///
///  Passando o Mouse em uma TAG
function mouse_over_menu(obj) {
        obj.className = 'itemOver';
        // document.getElementById(obj).className = 'itemOver';
        // document.getElementById(obj).style.color = "#000000";
        // document.getElementById(obj).style.background="#FFFFFF";
}

function mouse_out_menu(obj)  {
          obj.className = 'itemOn';
        // document.getElementById(obj).className = 'itemOn';
        // document.getElementById(obj).style.color = "#000000";
        // document.getElementById(obj).style.background="#7CFC00";
}
///
/****   Nao aceitar o BACKSPACE - IMPORTANTE PARA NAO VOLTAR PAGINA  *****/
function no_backspace(event) {
     ///
     ///  var e = (e)? e : event;
     var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
     var tecla = keyCode;
     ///   if(  tecla==8   ) {
     if( tecla==8 && ( event.srcElement.form==null || event.srcElement.isTextEdit==false )  ) {         
          event.cancelBubble = true;  
          event.returnValue = false;  
         return false;
     }
     ///
}
/*****   Final - function no_backspace(event) {  ****/
///
///
/****  function ofocusF    ****/
function ofocusF(e) {
    ///
    
    alert("ofocusF");
    
    ///  Funcao quando inicia campo alterar cor do fundo
    /// Focus = Changes the background color of input to yellow
     e.style.background='#ffff00';

     ///  setInterval(e.style.background='#ffffff',1000);
   
     window.setInterval(function() { e.style.background="#ffffff"; },5000);
   
    /// e.style.background="#ffffff";
}
/****  Final - function ofocusF    ****/
///
/**** function para Senha   ****/
function show(idolho,idsenha) {
    ///
    /*****
    *    Figura pra converter type password para text  
    *****/
    var olho = document.getElementById(idolho);
    var senha = document.getElementById(idsenha);
    ///
    if( senha.type==="password") {
        ///
        olho.src = "imagens/olho_14pixels.png";
        senha.type = "text";
    } else {
        ///
        olho.src = "imagens/olho_fechado_14pixels.png";
        senha.type = "password";
    }
    ///
}
/****   Final - function show(idsenha) {  ****/
///
///  Retirando a acentuação de um Input de texto
function retira_acentos(palavra) {
    com_acento = "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
    sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
    nova="";
    for(i=0;i<palavra.length;i++) {
        if( com_acento.search(palavra.substr(i,1))>=0) {
            nova+=sem_acento.substr(com_acento.search(palavra.substr(i,1)),1);
        } else {
            nova+=palavra.substr(i,1);
        }
    }
    return nova;
}
/****   Final - function retira_acentos(palavra) {   ***/
///




///   Só aceita letras
function soLetras(obj){
     var tecla = (window.event) ? event.keyCode : obj.which;
     if(( tecla>65 && tecla<90) || ( tecla>97 && tecla<122 ) ) {
          return true;
     } else {
          alert("Usar somente letras");
          return false;
     }
}
///
///   Somente letras - [a-z][A-Z]
function somente_letras(id,dados) {
    var string = dados.replace(/([^a-zA-Z])/g,""); 
    var pos =  dados.search(/([^a-zA-Z])/g);
    if( pos!=-1  ) {
        document.getElementById(id).value=string;        
        alert("ERRO: Digitar somente letras.");
        return false;
    }
    return;
}
///
///
function str_repeat(string,nrep) {
    var n;
    var stringf = "";
    for(n=1; n<=nrep; n++){
        stringf += string;
    }
    return stringf;
}
///
/*    
function trim(str)  {
  if ( str ) {
    if(str.length < 1)
      return "";
    str = RTrim(str);
    str = LTrim(str);    

    if(str == "")
      return "";
    else
      return str;
  } else {
    return "";
  }
}
function RTrim(str) {
    var espaco = String.fromCharCode(32);
    var tamanho = str.length;
    var temp = "";
    if(tamanho < 0)
      return "";
  
    var temp2 = tamanho - 1;
    while(temp2 > -1){
      if(str.charAt(temp2) == espaco){
        // não faz nada
     } else {
        temp = str.substring(0, temp2 + 1);
        break;
      }
      temp2--;
    }
    return temp;
}
function LTrim(str){
    var espaco = String.fromCharCode(32);
    var tamanho = str.length;
    var temp = "";
    if(tamanho < 0)  return "";
    var temp2 = 0;
    while(temp2 < tamanho){
      if(str.charAt(temp2) == espaco)  {
          
      }  else{
         temp = str.substring(temp2, tamanho);
         break;
      }
      temp2++;
    }
    return temp;
}
//  Final alinhar texto sem espacos

//  Duas funcoes para o campo ID hora
//  1 - Verifica o numero de caracteres HORA   
function mascara_hora(hora,m_id,minutos) { 
          var myhora=''; 
          hora = trim(hora);
          document.getElementById(m_id).value = hora;
          myhora = myhora + hora; 
          if ( myhora.length==2 ) { 
                 myhora=myhora+':';
                 if( ! minutos ) myhora=myhora+"00";
                 // document.forms[0].hora.value = myhora; 
                document.getElementById(m_id).value = myhora;                 
          } 
          if ( myhora.length==5 ) verifica_hora(m_id);  
} 
//  2 - Verifica valores numericos recebido - HORA
*/
///
/*
      Tempo para fechar o site 
*/
var timer;
function timedClose() {
        clearTimeout(timer);
        //  timer = setTimeout("dochange('Sair')",tempo_exec);
                /*
                    Dentro da pagina precisa do arquivo XHConn.js
                        e tambem da function dochange
                */      
                //  timer = setTimeout("dochange('Sair','Sair')",180000);
         timer = setTimeout("dochange('Sair','Sair')",1080000);
         return;
}
//
///  Alinhar Texto - como o TRIM do  PHP
//    Removendo os espacos antes e depois
function trim(str) { return str.replace(/^\s+|\s+$/g,""); }
///
///
///  function para verificar o EMAIL
function validaEmail(cpo_id) {   
   //  emailRE = new RegExp("^([a-zA-Z0-9_\.\-])+\@([a-zA-Z0-9\-])+\.+([a-zA-Z0-9]{2,4})+$");
  var emailRE = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  var email = document.getElementById(cpo_id).value;
  email = trim(email);
 /* if( email.length<1 ) {
       decisao = confirm("Digitar "+cpo_id+"?");
       if ( ! decisao ) return; 
  } */
  if ( ! emailRE.test(email)  ) {
      var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
      msg_erro += "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";
      var msg_final="</span></span>";
      alert("E_MAIL inválido");      
      document.getElementById('label_msg_erro').style.display="block";
      msg_erro +="E_MAIL inv&aacute;lido"+msg_final;
      document.getElementById('label_msg_erro').innerHTML=msg_erro;
      document.getElementById(cpo_id).focus();
      return false;
  } else  {
     document.getElementById('label_msg_erro').innerHTML="";    
  }
  return;
}
//****************************************************************************************
///
function verifica_hora(hora_id) { 
          /***    hrs = (document.forms[0].hora.value.substring(0,2)); 
                min = (document.forms[0].hora.value.substring(3,5)); 
          ****/
          var hrs = (document.getElementById(hora_id).value.substring(0,2)); 
          var min = (document.getElementById(hora_id).value.substring(3,5)); 
  
          /****    alert('hrs '+ hrs); 
               alert('min '+ min); 
          ****/
           
          situacao=""; 
          ///
          /// verifica data e hora 
          if ( ( hrs==00 ) || ( hrs < 00 ) || ( hrs > 23 ) || ( min < 00 ) || ( min > 59 ) ) { 
              var m_hora = document.getElementById(hora_id).value;
              situacao = "falsa"; 
          } 
           
          ///  if (document.forms[0].hora.value == "") { 
          if ( document.getElementById(hora_id).value=="" ) { 
              situacao = "falsa"; 
          } 

          if ( situacao=="falsa" ) { 
               alert("Hora inválida: "+m_hora); 
               //  document.forms[0].hora.focus(); 
                  document.getElementById(hora_id).value="";
               document.getElementById(hora_id).focus();
          } 
          ///
} 
/****   Final - function verifica_hora(hora_id) {   ******/
///
///   Forca da Senha
function verificaForca(campo) {
    ///
    var div=document.getElementById('div_forca_senha');
    var valor = campo.value;
    var contemNumeros = /[0-9]/;
    var contemLetras = /[a-z]/i;
    var contemEspecial = /[@#$%;*&+]/;
    var contagem = 0;
    ///
    if( valor.length > 0 ) {
        if (contemNumeros.test(valor)) contagem++;
        if (contemLetras.test(valor)) contagem++;
        if (contemEspecial.test(valor)) contagem++;
        ///
        switch ( contagem ) {
            case 1: {
                 div.style.background ="#CCCCCC";
                 div.innerHTML = "Senha Fraca!";
            } break;
            case 2: {
             //   div.style.background ="#009900";
                 div.style.background ="#FFFF00";
                 div.innerHTML = "Senha Mediana!";
            } break;
            case 3: {
              //  div.style.background = "#FF0000";
                 div.style.background = "#00FF00";
                 div.innerHTML = "Senha Forte!";
            } break;
            default: {
                 div.style.background="#FFFFFF";
                 div.innerHTML = "ERRO n&atilde;o esperado. Informe ao Analista/Programador. ";
            }
        }
        /*****   Final - switch ( contagem ) {  *****/
        ///
    }
    ///
} 
/*****   Final - function verificaForca(campo) {  *****/
///
