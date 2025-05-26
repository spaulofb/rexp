///
///    Funcoes do Javascript - 20160420  
///
///
charset="utf-8";
//
//   URL PRINCIPAL - 20250325
function cortarTexto(urlall, simbolo,n) {
    //
    // Divide o texto usando o símbolo como delimitador
    const partes = urlall.split(simbolo); 
    //
  
   //  alert("aqui ok  partes = "+partes);
  
    if( partes.length >= 4) {
         //
        // Pega as 4 primeiras partes e junta com o símbolo
        const parteCorte = partes.slice(0, n).join(simbolo); 
        return parteCorte+"/";
        //
    } else {
        //
        /** Retorna o texto original se não houver 4 ocorrências do símbolo  */
        return urlall; 
        //
    }
    //
}
/**   Final - function cortarTexto(texto, simbolo,n) {  */
//

var localurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
const simbolo = "/";
const baseUrl = cortarTexto(localurl, simbolo,4);
//
//
///   Corrigindo acentuacao
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
}
//********************************************************
//
//  Liberando elemento ID caso exista
function aguarde_arq(x_id) {
    if( document.getElementById(x_id)  ) {
        document.getElementById(x_id).style.display="block";                    
    }
    return;
}
//
//  Funcao para alinhar o campo - NOVO TRIM - 20170515
function alinhar_texto(id) {
    var id_valor = document.getElementById(id).value;
    var id_valor = trim(id_valor);
    var strtrim = id_valor.replace(/^\s+|\s{2,9}|\s+$/gm," ");    
    document.getElementById(id).value=strtrim;
   return;
}
//********************************************************
/*
   Ativar ou desativar ID  */
function ativa_ou_desativa_id(opcao,m_id) {
   if ( opcao=='ativar' ) {
       gebi(m_id).style.visibility="visible"; 
   } else   if ( opcao=='desativar' ) {
       gebi(m_id).style.visibility="hidden"; 
   }
}   
//
//   ACEITAR o BACKSPACE - 
function backspace(event,nome_id) {
    var navegador =navigator.appName;
    var pos = navegador.search(/microsoft/gi);
    if( pos!=-1 )  return;
}
//
//  Verifica se o campo NAO esta vazio
function campo_n_vazio(m_id,msg) {
    var id_valor = trim(document.getElementById(m_id).value);
    if( id_valor.length>0 ) {
         //  Desativar mensagem
         if( document.getElementById(msg) ) document.getElementById(msg).style.display="none";
         return;
    }
}
//
//  zoom style property
// function ChangeZoom(selectTag) {
function ChangeZoom(indexValue) {
      /*
     // Returns the index of the selected option
    var whichSelected = selectTag.selectedIndex;

    // Returns the text of the selected option
    var indexValue = selectTag.options[whichSelected].text;
    */
       
    //  var div = document.getElementById ("myDiv");
    var div = document.getElementById ("id_body");

    if( 'zoom' in div.style) {
       //  div.style.zoom = indexValue;
 //      div.style.zoom = "120%";
       div.style.zoom = indexValue;
    } else {
       alert ("Esse navegador não suporta style zoom!");
    }
}
//
//// Validar E_Mail
function checkEmail(m_email_nome,m_email_valor) {
   var filtro=/^.+@.+\..{2,3}$/;
   // if ( filtro.test(document.form.email.value) == false ) {
  if ( m_email_valor.length<1 ) return true;       
  if( filtro.test(m_email_valor) == false ) {    
        ///  alert("O e-mail informado não é válido");
        var mensagem=acentuarAlerts("não é válido");
        alert("O e-mail informado "+mensagem);
        //// document.form.email.focus();
    document.getElementById(m_email_nome).value="";
    return   document.getElementById(m_email_nome).focus();
  }
return true;
}
///
//  Iniciando no primeiro campo do FORM
function cpo1_focus(frm) {
     var m_elements_total = frm.length; 
     for( i=0; i<m_elements_total; i++ ) {      
            //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
            var m_id_name = frm.elements[i].name;
            var m_id_type = frm.elements[i].type;
            var m_id_title = frm.elements[i].title;
            switch (m_id_type) {
                    case "undefined":
                    case "hidden":
                    case "button":
                    case "image":
                    case "reset":
                    case "submit":
                    continue;
           }
           var array_form_cpos = /text|password|checkbox|textarea|select-one|file/gi;
           var pos = m_id_type.search(array_form_cpos);
           if( pos!= -1  ) {      
               i=9999;
               ///
               if( m_id_type.toUpperCase()=="TEXT" ) {    
                   document.getElementById(m_id_name).readOnly = false;
               }    
               document.getElementById(m_id_name).focus();
               break;
           }    
     }
}
//

//
/*
    Utilizado para evitar de digitar: document.getElementById toda hora, 
    tornando o processo mais prático       */
function gebi(ID) {
        return document.getElementById(ID);
}

// Utilizado para evitar de digitar: document.getElementsByTagName toda hora, tornando o processo mais prático
function gebtn(tag) {
        return document.getElementsByTagName(tag);
}
//
// Processando tecla especial
// incluir: <body onKeyPress="ENTER();">
function ENTER() {
    var tecla=window.event.keyCode;
    if (tecla==13) {
        FuncProcEnter();
    }// fim do if (tecla==13)
    return true;
}// fim do function ENTER()

//  ************************************************************************
//
// Exemplo:
/*
<form name="form1" action="form action procedure" onSubmit="return false">
Digite seu Nome:<input type="text" name="nome">
<input type="submit" value="ok" onClick="envia(this.form)" >
//  usar type="submit" ou "button" ???? 
// parece melhor usar: <input type="button" value="ok" onClick="envia(this.form)" >
*/
//  Alternativa 2
function enterkey(e) {
    /*  Suprimir a tecla enter */
  tecla = (document.all) ? e.keyCode :e.which;
  return (tecla!=13);
} 
/*
Exemplo:
<input type="text" name="fonteprojid"   id="fonteprojid"   size="36" maxlength="24" onkeypress="return enterkey(event);" title='Digitar Nr. Processo'  style="cursor: pointer;"   onblur="javascript: alinhar_texto(this.id,this.value)"   />
*/
//  ************************************************************************

///   Sair - voltar ao servidor
function id_sair(ativ_desat,mensag) {
        if( ativ_desat=="Sair" ) {
               // gebi("form").innerHTML="";  //  Deu Certo
               // gebi("form").style.display="none";  //  Deu Certo       
               //  Saindo do programa
               document.getElementById("saindo").submit();
        }       
}
//**************************************************************************************

///  Utilizando o comando onkeypress
function myFunction() {
    ///  Ocultando ID  e utilizando na tag input comando onkeypress
    exoc("label_msg_erro",0,""); 
     ///
}
///
/**
*      Proximo Campo  
*/
function proximoCampo(objeto,e) {
    //
    var e = (e) ? e : event;    
    var  maxchr = objeto.getAttribute("maxlength");
    var teste_name = objeto.name;
    gebi(teste_name).value =  trim(gebi(teste_name).value);
    var id_chr = gebi(teste_name).value;
    if( id_chr.length==maxchr ) {
         var i;
         for (i = 0; i <= objeto.form.elements.length; i++)  if (objeto == objeto.form.elements[i] ) break;
             // i = (i + 1) % objeto.form.elements.length;
                 i = (i + 1);
                  var m_id_type = objeto.form.elements[i].type;  // Quando tag  type=hidden  passar
                  if ( m_id_type=="hidden" || objeto.form.elements[i].id=="limpar"  ) i++;
                 if ( objeto.form.elements.length<i ) i =  objeto.form.elements.length;
                 //teste_name = objeto.form.elements[i].id;
                 if ( typeof(objeto.form.elements[i].id)!="undefined"  ) {
                   //  objeto.form.elements[i].id.focus();
                           //  var campo_focus = objeto.form.elements[i].id;
                           //  campo_focus.focus();
                           //  alert(" -> PASSOU AQUI LINHA 67  - objeto.form.elements[i].id = "+objeto.form.elements[i].id);   
                           // objeto.form.elements[i].id.focus();
                           teste_name = objeto.form.elements[i].id;
                           //  setTimeout(function() { gebi(teste_name).focus(); }, 1000);
                           gebi(teste_name).focus();
                  }
                 //  e.keyCode=9;
                 //  objeto.form.elements[i].id.focus();
                 //  return true;
   }
}
//*******   Final - Proximo Campo   ***************************
//


function xramal(xid,xidval) {
    //
    var lenx = document.getElementById(xid).value.length;

//    alert(" xidval = "+xidval+"  -->> lenx = "+lenx);
      if( lenx < 1 ) {
          return;
      }
      //
      if( lenx != 4) {
           //
           alert("Digitar somente 4 números no Ramal - corrigir.");
           //  this.value = this.value.slice(0, 4); // Limita a 4 caracteres
           document.getElementById(xid).value="";
           document.getElementById(xid).focus();
           //
           return false;
           //
      }
      //
}  
//
//  Sleep como no PHP
function sleep(milliseconds) {
      var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
    //
}
//
/**
*      Aumentar ou diminuir tamanho do texto todos elementos
*/ 
function tamanho_texto(tam_texto) {
    var todos_elementos = document.getElementsByTagName('*');
        tam_texto=="aumentar" ?  x_texto="Aumentando" :  x_texto="Diminuindo";
        alert(x_texto+" o tamanho do texto");
        for( var x = 0; x < todos_elementos.length ; x++) {
          if( todos_elementos[x].id=="tamanho_texto" || todos_elementos[x].id=="a_pequeno" || todos_elementos[x].id=="a_maior"    || todos_elementos[x].id=="tit_historico" ) continue;
                        if (  tam_texto=="aumentar" ) {
                                //  todos_elementos[x].className = "aumentar_texto";
                                todos_elementos[x].style.fontSize = "medium";
                        } else if (  tam_texto=="diminuir" ) {
                                // todos_elementos[x].className = "diminuir_texto";
                                todos_elementos[x].style.fontSize = "small";
                        }
        }
        
        
        
        // gebi("a_pequeno").setAttribute("style","font-size: x-small");
        //  gebi("a_maior").setAttribute("style","font-size: small");     
}
/**  Final - function tamanho_texto(tam_texto) {  */
//
/**
      Aumentar ou diminuir elemento BOdy
*/ 
function zoomIn() {
    alert("zoomin");
    var Page = document.getElementById('body');
    var zoom = parseInt(Page.style.zoom) + 10 +'%'
    Page.style.zoom = zoom;
    return false;
}
//
 
function zoomOut() {
    alert("zoomOut");
    var Page = document.getElementById('body');
    var zoom = parseInt(Page.style.zoom) - 10 +'%'
    Page.style.zoom = zoom;
    return false;
}
//********************************************************************************
//
/*   Maneiras de remover um elemento ID   */
function  remover_elemento(obj_pai,obj_filho) {
    //
   var pai = document.getElementById(obj_pai);
   var filho = document.getElementById(obj_filho);
   var removido = pai.removeChild(filho);  
}
//
/**
*      Exemplo do método: insertAfter - criando elemento
*/ 
function insertTag(what,ref,n_elementos) {
	// 1º
	/*
	var newElement = document.createElement(what);
	// 2º
	newElement.setAttribute('id','div1');
	newElement.setAttribute('class','menu_vertical');
	newElement.appendChild(document.createTextNode("div1"));
	// 3º
	var referencia = document.getElementById(ref);
	// 4º
	var parentTag = referencia.parentNode;
	// 5º
	parentTag.insertBefore(newElement, referencia.nextSibling);
	//
	*/
    var obj_pai = document.getElementById(ref);
   obj_pai.style.clear='none';		
	var obj_filho = document.createElement(what);
    obj_pai.appendChild(obj_filho);
	//   obj_filho.setAttribute('id','div1');
    if ( n_elementos==1 ) {
 	     if ( ref=="id_body" ) {
	 	    obj_filho.setAttribute('id','div1');
		    obj_pai.style.clear='both';		
            obj_filho.setAttribute('class','dentro_corpo');		
		 } else {
	        obj_filho.setAttribute('id','parte1');
		    obj_filho.className='m_vertical';		
		 }
	} else if( n_elementos>1 ) {
    	 // 1
        //  obj_filho.setAttribute('class','menu_vertical');
        obj_filho.setAttribute('id','parte1');
		obj_filho.setAttribute('overflow','hidden');
		 obj_filho.className='m_vertical';		
        /* obj_filho.appendChild(document.createTextNode("DIV1")); */
		//  obj_filho.appendChild(document.createTextNode(m_menu_vertical));
        // obj_filho.style.border="2px solid #000000";
         // 2
		 var obj_filho2 =  document.createElement(what);
        //  obj_filho2.appendChild(document.createTextNode("DIV2"));
          obj_filho2.setAttribute('id','div2');
          obj_pai.appendChild(obj_filho2);
          //  obj_filho2.setAttribute('class','class_div2');
		  obj_filho2.className='class_div1';
		  obj_filho2.style.overflow="auto";
          obj_filho2.style.border="4px  double #000000";
	}
}
//
//  Verificar duplicatas em array - 
//  
function unique(a) {
   var r = new Array();
   o:for(var i = 0, n = a.length; i < n; i++) {
      for(var x = 0, y = r.length; x < y; x++)  {
		 var m_r = r[x].toString(); var m_a=a[i].toString();
		m_r = m_r.toUpperCase();  m_a=m_a.toUpperCase();
		 if( m_r==m_a ) continue o;
      }
      r[r.length] = a[i];
	 // r[r.length] = m_a;
   }
   r.sort();
   return r;
}
//
//  Usar function  email_link  para  mostrar email
function email_link(link_http, usuario_email, nome_do_campo) {
    var teste = "Se a janela não está abrindo talvez seja porque voce tenha um "
    teste =  teste+"programa bloqueador de pop-up! \n Observação » O windows XP "
    teste =  teste+"service pack 2 bloqueia pop-ups!";
    ///
    //  janela2 = window.open(link_http,'GEMAC','toolbar=no,location=no,"directories=no,status=no, scrollbars=yes, resizable=yes,menubar=yes');
   if ( nome_do_campo == "email" ) { 
        janela2 = window.open('gen_bl_c/email.php?m_nome='+link_http+'&m_email='+usuario_email,'EMail','resizable=no,toolbar=no,status=no,menubar=no,scrollbars=no,top=1,width=800,height=100');
        janela2.moveTo(5,5);
        //      janela2.resizeTo(80,200);
        janela2.setTimeout("self.close();",25000);
   } else if ( nome_do_campo == "link" ) { 
        janela2 = window.open('http://'+usuario_email,'Link','status=no,toolbar=no,location=no,directories=no,statusbar=no,title=no,resizable=no,menubar=no,scrollbars=yes,fullscreen=no,top=1,left=1,width=800,height=600');
        janela2.moveTo(5,5);
        janela2.setTimeout("self.close();",25000);
        //  window.location.href="http://www-gen.fmrp.usp.br" ;
   }
}
//
//   Ativar ou Desativar  -  ID
var i_exoc=0;
function exoc(id,i_exoc,msg) {
    //
    //  Atualizado em 20250122
    //   Desativando ID
    if( parseInt(i_exoc)<1 ) {
        if( document.getElementById(id) ) {
            /***
              if( document.getElementById(id).style.display="block"  ) {
                    document.getElementById(id).style.display="none";                   
               }
            ***/
            ////  Atualizado em 20200128
            /// Verifica caso estiver Ativo - Ocultar elemento
            var tdisp =  document.getElementById(id).style.display;
            if( tdisp!="none" ) {
                document.getElementById(id).style.display="none";
            }
            /// Verifica caso estiver Ativado - desativar elemento  
            var tdispd = document.getElementById(id).disabled; 
            if( tdispd!=true ) {
                document.getElementById(id).disabled = true;
            }   
            ///
        }
        //
    }
    //  Final  -  Desativando ID
    //
    //  Ativando o  ID
    if( parseInt(i_exoc)>=1 ) {
        ///
        if( document.getElementById(id) ) {
            ///  Ativar ID
            /***
             if( document.getElementById(id).style.display="none"  ) {
                 document.getElementById(id).style.display="block";
             }
            ***/
            /// Verifica caso estiver Oculto - Ativar elemento
            var tdisp =  document.getElementById(id).style.display;
            if( tdisp!="block" ) {
                document.getElementById(id).style.display="block";
            }
            /// Verifica caso estiver Desativao - ativar elemento
            var tdispd = document.getElementById(id).disabled; 
            if( tdispd!=false ) {
                document.getElementById(id).disabled = false;
            } 
            ///
            ///  Caso tendo mensagem para adicionar
            if( typeof msg!="undefined" ) {
                document.getElementById(id).innerHTML=msg;
            }   
            ///
       } 
       // 
        i_exoc=0;
    }
    //  Final - Ativando o  ID
    //
    return;
    //
}
/*****   Final - function exoc(id,i_exoc,msg) {  **/
//
//
//  Caso telefone ou fax - 
function fone_fax(id) {
   var m_valor =  trim(document.getElementById(id).value);
   if( m_valor.length<6 && m_valor.length>=1  ) {
       alert("ERRO: Faltando dígitos.\r\nDigitar novamente")
       document.getElementById(id).value="";
       return false;
   }  
   //  m_valor ="";  
   return document.getElementById(id).value; 
}
//
//
/*
      Tempo para fechar o site 
*/
// var timer;
// function timedClose() {
        //  clearTimeout(timer);
        //  timer = setTimeout("dochange('Sair')",tempo_exec);
		/*
		    Dentro da pagina precisa do arquivo XHConn.js
			e tambem da function dochange
		*/	
		//  timer = setTimeout("dochange('Sair','Sair')",180000);
        //	timer = setTimeout("dochange('Sair','Sair')",360000);
        //	return;
// }
//    FInal do timedClose
/** 
      Tag Select Multiple - para selecionar multiplas opcoes 
*/
// var arSelected = new Array(); 
function getMultiple(mySelect) { 
    var arSelected = new Array(); 
    for( var iy = 0; iy < mySelect.options.length; iy++) {
          if ( mySelect.options[iy].selected ) arSelected[iy] = mySelect.options[iy].text;  
    } // You can use the arSelected array for further processing. 
    return arSelected.toString();
}
//
//
function importante(m_texto) {
    if (m_texto.toUpperCase()=="PROJETO") {
        var msgparte1 = "o seu "+m_texto;
    } else {
        var msgparte1 = "a sua "+m_texto;
    }
    alert("AVISO IMPORTANTE: \r\n Certifique-se que tenha disponivel em seu computador \r\n o arquivo (PDF) que descreve "+msgparte1)
}
//  Final - Verificar duplicatas em array
//
/**     Para verficar qual Navegador esta sendo usado
*/
///  Verifica se o Navegador Chrome
function isChrome() {  
   if(navigator.userAgent.toLowerCase().indexOf("safari") >= 0 && navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) 
        return true;   
   else     
       return false;     
}
//
//   Verifica se o Navegador Firefox
function isFirefoxSimilar() {     
      if(navigator.userAgent.toLowerCase().indexOf("firefox") >= 0)     
             return true;   
      else     
             return false;     
}
//
//
//  Verifica se o Navegador Internet Explrer
function isInternetExplorer() {  
     if(navigator.userAgent.toLowerCase().indexOf("msie") >= 0 || navigator.userAgent.toLowerCase().indexOf("trident") >= 0) 
         return true;   
     else     
         return false;     
}
//
//
//  Abrindo janela de Aguarde 
function janela_aguarde() {
    var LEFT = (screen.width/2)-100;
    var TOP = (screen.height/2)-200;
   /*
      var x = window.open("imagens/aguardar.gif","myWin","status=no,width=0,
        height=200,screenX=0,screenY=75,left="+LEFT+",top="+TOP);
   */
    var x = window.open("../script/aguarde.html","myWin","status=no,width=0, height=200,left="+LEFT+",top="+TOP);
     //  janela2.moveTo(5,5);
    x.resizeTo(10,200);
    //  janela2.setTimeout("self.close();",20000);
    x.setTimeout("self.close();",25000);
}
//***********************************************************************************************************
//
//  You should have received a copy of the GNU General Public License
//  along with this program. If not, see <http://www.gnu.org/licenses/>.
// ***************************************************************************
// Return new array with duplicate values removed
Array.prototype.unique = function() {
    var a = [];
    var l = this.length;
    for(var i=0; i<l; i++) {
      for(var j=i+1; j<l; j++) {
           // If this[i] is found later in the array
          if( this[i]===this[j])
              j = ++i;
          }
          a.push(this[i]);
    }
    return a;
};
//****************************************************************
///
///  Descobrir o navegador
function navegador() {
      var agente = window.navigator.userAgent;
      var navegadores = ["Chrome", "Firefox", "Safari", "Opera", "Trident", "MSIE", "Edge"];
      for(var i in navegadores){
          if( agente.indexOf( navegadores[i]) != -1 ) {
                 return navegadores[i];
          }
      }
}
//
//
/// Funcao para o confirm do Javascript
function para_confirm(msg) {
     var resposta = confirm(msg+"\n (SIM/OK ou NÃO/Cancel) ");
     return resposta;
}
//
//
//  Colocando ponto e traco no CPF
function mascara_cpf(cpf,event) {
   //  Verificar se a tecla foi o Backspace    
   var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
   var tecla = keyCode;
   if ( tecla==8 ) return;
    
    var mycpf='';
    mycpf = mycpf + cpf;
    if (mycpf.length == 3) {
        mycpf = mycpf + '.';
        document.forms[0].cpf.value = mycpf;
    }
    if (mycpf.length == 7) {
        mycpf = mycpf + '.';
        document.forms[0].cpf.value = mycpf;
    }
    if (mycpf.length == 11) {
        mycpf = mycpf + '-';
        document.forms[0].cpf.value = mycpf;
    }
    if (mycpf.length==14) {
    }
}
//*************************************************************
//
//  Passando o Mouse em uma TAG
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
//
//   NAO aceitar o BACKSPACE - IMPORTANTE PARA NAO VOLTAR PAGINA
function no_backspace(event) {
    //   comando pra verificar se o navegador e  google chrome
    var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
    //  Verifica se navegador google chrome  nao executar IF
    if( is_chrome == -1  ) {
        //  var e = (e)? e : event;
        var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
        var tecla = keyCode;
        //   if(  tecla==8   ) {
        var navegador =navigator.appName;
        var pos = navegador.search(/microsoft/gi);
        if( pos!=-1 ) {
             if( tecla==8 && ( event.srcElement.form==null || event.srcElement.isTextEdit==false ) ) {               
                  event.cancelBubble = true;  
                  event.returnValue = false;  
                  return false;
             }
        } else {
            //  if (  tecla==8  && ( event.target==null  ) ) {               
            // if (  tecla==8  && ( event.target==null  ) ) {               
            if( tecla==8  ) {       
                 event.stopPropagation();    
                 event.cancelBubble = true;  
                 event.returnValue = false;      
                 return false;
            }

        }     
    } //  Final do IF pra verificar se navegador NAO e google chrome
}
//*************************************************************************************
//
//   Nao aceitar o simbolo arroba
function sem_arroba(field,event) {
      /*
          ASCII ( American Standard Code for Information Interchange, que em português significa
             "Código Padrão Americano para o Intercâmbio de Informação" ) é um conjunto de códigos
             para  o computador representar números, letras, pontuação e outros caracteres. 
             Surgido em 1961, um dos seus inventores foi Robert W. Bemer.  
      */
      var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
      var tecla = keyCode;
      /*    Vamos utilizar o objeto event para identificar 
            quais teclas estão sendo pressionadas.       
            teclas 64 no caso o simbolo @
      
            Retorna uma string (não objeto String) com os caracteres dados pelos
             valores ASCII car1, ..., carN.  
             Deve ser sempre usado na forma String.fromCharCode(...) em vez de
              um objeto string criado.
      */
      var key = String.fromCharCode(keyCode);
      //  Melhor jeito de usar search
      var str = field.value;
      var pos = str.search("@");
      if( pos != -1  ) {  //   Caso encontrou arroba
            /*  A propriedade keyCode revela o código ASCII da tecla pressionada. 
                  Funcao retorna falso para quem digitou a tecla arroba @
            */
            field.value="";
            field.focus();
            field.select();
            alert("Não digitar o símbolo @ (arroba)");
            return;
       }
}
//*******************************************************************
//
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
        olho.src = baseUrl+"imagens/olho_14pixels.png";
        senha.type = "text";
    } else {
        ///
        olho.src = baseUrl+"imagens/olho_fechado_14pixels.png";
        senha.type = "password";
    }
    ///
}
/****   Final - function show(idsenha) {  ****/
//
//  Desativando os campos de mensagens no TOP da pagina
function refreshimg(cpo1,cpo2) {
   // document.getElementById('label_id_erro').style.display="none";            
   // document.getElementById("id_erro").innerHTML="";
   if( document.getElementById(cpo1) )  document.getElementById(cpo1).style.display="none";            
   if( document.getElementById(cpo2) )document.getElementById(cpo2).innerHTML="";
}
//
//  Retorna letra maiuscula
function soLetrasMA(id) { 
    document.getElementById(id).value=document.getElementById(id).value.toUpperCase(); 
    return;
} // Maiúsculas
//
// 
function remove(str, sub) {
     i = str.indexOf(sub);
     r = "";
     if (i == -1) return str;
     r += str.substring(0,i) + remove(str.substring(i + sub.length), sub);
     return r;
}
//  Final - verificando CPF
//  
function down_char(lstr) { // converte maiusculas em minusculas
   var str=document.getElementById(lstr).value;  // obtem o valor
   document.getElementById(lstr).value=str.toLowerCase(); // converte as strings e retorna ao campo   
}
//
//
function doPopups() {
if ( !document.getElementsByTagName ) return false;
	var links = document.getElementsByTagName("a"); 
	for( var i=0; i < links.length; i++ ) { 
		if ( links[i].className.match("popup") ) { 
	           links[i].onclick = function() { 
			    	//  document.getElementsByTagName("corpo").innerHTML = window.open(this.href); 
					gebi("corpo").innerHTML = "self.parent.location='this.href'";
	    			return false; 
		       } 
		} 
	} 
} 
window.onload = doPopups;
//
//  Desativando o botado direito do mouse
function click() {
    if (event.button==2||event.button==3) {
         oncontextmenu='return false';
    }
}
document.onmousedown=click;
document.oncontextmenu = new Function("return false;");
///
///  ALTERADO em 20170918 -  antes era do arquivo: domenu.php
///  Retirando a acentuação de um Input de texto
function retira_acentos(palavra) {
    ///
    com_acento = "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
    sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
    nova="";
    var palavra_length=palavra.length;
   
    for( i=0; i<palavra_length; i++) {
       /// if( com_acento.search(palavra.substr(i,1))>=0) {
        if( com_acento.search(palavra.substr(i,1))!=-1 ) {
            nova+=sem_acento.substr(com_acento.search(palavra.substr(i,1)),1);
        } else {
            nova+=palavra.substr(i,1);
        }
    }
    return nova;
}
///  FINAL - Retirando a acentuação de um Input de texto
//
///  Mpstra total de caracteres no elemento escolhido
function tamanho_campo(campo) {
    len = campo.length;
    alert(" campo = "+campo+" - len = "+len+" - campo.innerHTML = "+campo.innerHTML)
}
// ***************************************************************
//
////  Tecla ENTER ou TAB
function tecla_enter(e,elementid) {
        var e = (e)? e : event;
        // var t =(e.target)? e.target : e.srcElement;
        if( e.keyCode==13  && !gebi(elementid).type=="textarea" ) {
            e.keyCode = 9;
            gebi(elementid).value = trim(gebi(elementid).value);
            if( elementid.toUpperCase()=="NOME" ) UcWords(elementid);
        } 
} 
//**************************************************************************
///
// Forma alternativa para submeter um form quando o ENTER foi desabilitado
//  Alternativa 1
function terminar(oForm) {  
    /* Somente para teste e visualização dos campos do form 
    str = "Elementos do form " + oForm.name + " \n"
    for (i = 0; i < oForm.length; i++)
        str += oForm.elements[i].name + " = "+oForm.elements[i].value+"\n"
    alert(str)
    */
    enviar_dados_cad('submeter','PROJETO',oForm);
    // oForm.submit();
}
//************************************************************************
//
//  Procurando palavra com expressoes regulares
//  aceita somente aqueles nomes maisc ou minusc
function teste_re(m_id_name) {
       //  var m_id_name='email';
       var m_email = /(EMAIL|E_MAIL|USER_EMAIL)/i;
       if( m_email.test(m_id_name) ) {
           alert(" ACHOU ")
       } else {
          alert(" NAO  ACHOU ") 
       }
}
//********************************************************************************
//
//  Alinhar Texto - como o TRIM do php
//  Removendo os espacos antes e depois 
//  Alterado para o HTML5  aceitar - 20170515
function trim(str) { 
     var texto = str.replace(/^\s+|\s+$/g,""); 
     var texto = texto.replace(/^\s+|\s{2,9}|\s+$/gm," ");    
     var i=9999;
     var resultado = "";
     var x = texto.indexOf("  ");
     if( x!=-1 ) {
         while( i>0 ) {
              texto = texto.replace("  "," "); 
              var n = texto.indexOf("  ");
              /// 
              if( n==-1) {
                  break;
              } else {
                  resultado = texto;              
              }
              i--;
         } 
         return resultado; 
     }
     return texto;
}
/***********  final -  function trim(str) **************/
///
///  TRIM - 20170207 - usado com tag input text onkeypress
function trimnovo(el) {
     el.value = el.value.
       replace(/(^\s*)|(\s*$)/, "").   /// removes leading and trailing spaces
       replace(/[ ]{2,}/gi," ").       /// replaces multiple spaces with one space 
       replace(/\n +/,"\n");           /// Removes spaces after newlines
    return;
}


/*
       FUNCAO PARA MAIUSCULA A PRIMEIRA LETRA
*/
function UcWords(campo) {
        //  Esse trim esta no arquivo js/alinhar_texto.js
    var val = trim(gebi(campo).value);
    newVal = val
        .toLowerCase()
        .replace(/[^A-Za-záâàãäéêèëíîìïóõòôöúùûü][A-Za-záâàãäéêèëíîìïóõòôöúùûü]/g, function(m){return m.toUpperCase()})
        .replace(/[0-9][A-Za-záâàãäéêèëíîìïóõòôöúùûü]/g, function(m){return m.toUpperCase()})
        .replace(/( (da|das|e|de|do|dos|para|na|nas|no|nos) )/gi, function(m){return m.toLowerCase()})
        .replace(/^./, function(m){return m.toUpperCase()})
    if (val != newVal) {
        gebi(campo).value = newVal;
    }
}
//  FINAL - FUNCAO PARA MAIUSCULA A PRIMEIRA LETRA
//
function unique2(a) {
   var r = new Array();
   o:for(var i = 0, n = a.length; i < n; i++) {
      for(var x = i + 1 ; x < n; x++ ) {
          if(a[x]==a[i]) continue o;
      }
      r[r.length] = a[i];
   }
   return r;
}
//*******************************************************************************
//
//  Funcoes para converterm caracteres minusculas e maiusculas
function up_char(lstr) { // converte minusculas em maiusculas
    var str=document.getElementById(lstr).value;  // obtem o valor
    document.getElementById(lstr).value=str.toUpperCase(); // converte as strings e retorna ao campo   
}
//********************************************************************
///
//  function para verificar o EMAIL
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
      //
      var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
      msg_erro += "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";
      var msg_final="</span></span>";
      //
      alert("E_MAIL inválido");      
      //
      document.getElementById('label_msg_erro').style.display="block";
      msg_erro +="E_MAIL inv&aacute;lido"+msg_final;
      document.getElementById('label_msg_erro').innerHTML=msg_erro;
      document.getElementById(cpo_id).focus();
      //
      return false;
      //
  } else  {
     document.getElementById('label_msg_erro').innerHTML="";    
  }
  return;
}
//****************************************************************************************
//
//  VERificando CPF
function validarCPF(valor,id) {
 //  var cpf = document.cadastro.cpf.value;
   var cpf = valor; 
   var idret = document.getElementById(id);
   var filtro = /^\d{3}.\d{3}.\d{3}-\d{2}$/i;
   if( !filtro.test(cpf) ){
       window.alert("CPF inválido. Digite novamente.");
       idret.value="";
       idret.focus();
       return false;
   }
   
   cpf = remove(cpf, ".");
   cpf = remove(cpf, "-");
    
   if(cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
      cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
      cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
      cpf == "88888888888" || cpf == "99999999999") {
         window.alert("CPF inválido. Tente novamente.");
         idret.value="";
         idret.focus();
         return false;
   }

   soma = 0;
   for(i = 0; i < 9; i++)
        soma += parseInt(cpf.charAt(i)) * (10 - i);
   resto = 11 - (soma % 11);
   if(resto == 10 || resto == 11)
     resto = 0;
   if(resto != parseInt(cpf.charAt(9))){
        window.alert("CPF inválido. Digite novamente.");
        idret.value="";
        idret.focus();
        return false;
   }
   soma = 0;
   for(i = 0; i < 10; i ++)
     soma += parseInt(cpf.charAt(i)) * (11 - i);
   resto = 11 - (soma % 11);
   if(resto == 10 || resto == 11)
     resto = 0;
   if(resto != parseInt(cpf.charAt(10))){
        window.alert("CPF inválido. Digite novamente.");
        idret.value="";
        idret.focus();
        return false;
   }
   return true;
   //
}  
/**  Final - function validarCPF(valor,id) {  */
//
/**  VERIFICA SE DATA FINAL É MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)  */ 
var m_erro=0;
function verificadatas(dtinicial_nome, dtfinal_nome, dtInicial, dtFinal) {
    /**
    *      Alterado em 20250515
    */
    //  Ocultando mensagem de erro
    exoc("label_msg_erro",0,"");
     ////
     var final_msg_erro = '</span></pan>';        
    
     //
     // Mensagens para enviar
     var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
     msg_erro =+ "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

     var msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
     msg_ok += "<span style='color: #FF0000; padding: 4px;' >";

     var msg_final="</span></span>";
     //   FINAL - Mensagens para enviar
     //

     //
     var m_erro=0;    
     //
     //  Verificando variaveis
    if( typeof(dtinicial_nome)=="undefined" ) {
           var dtinicial_nome="";    
           m_erro = 1;
    }
    ///
    if( typeof(dtfinal_nome)=="undefined" ) {
           var dtfinal_nome="";    
           m_erro = 1;
    }
    //
    if( parseInt(m_erro)==1 ) var mensag_erro="Faltando ID e NAME nas datas.";
    /**  
    *    Atualizado em 20170503   
    */
     //  Caso ocorreu NAO erros 
    if( parseInt(m_erro)<1 ) {
         //
         //  IMPORTANTE: para verificar validade     
         var isValid = document.getElementById(dtfinal_nome).validity.valid;    
         var m_ok=1;
         if( ! isValid ) m_ok=0;    
         //
         //  Caso o elemento ID dtfinal_nome  NAO esta valida
         if( parseInt(m_ok)<1 ) {
             //
            var m_title="Digitar Data Final - exemplo: 01/01/1998";
            if( document.getElementById(dtfinal_nome).title ) {
                var m_title=document.getElementById(dtfinal_nome).title;
            }
            var mensag_erro=m_title;
            m_erro = 1;
        }
        //
    }    
    /**  Final - if( parseInt(m_erro)<1 ) {  */
    //
    ///  Caso ocorreu erros
    if( parseInt(m_erro)>0 ) {
        //
        // Mensagem de Erro
        msg_erro = msg_erro+'&nbsp;'+mensag_erro+final_msg_erro;
        //
        //  document.getElementById("label_msg_erro").innerHTML=msg_erro;
        //  Ativando mensagem de erro
        exoc("label_msg_erro",1,msg_erro);
        if( parseInt(m_ok)<1 ) {
            document.getElementById(dtfinal_nome).focus();
        }    
        return false;        
        //
    }
    //
    //  var dtini = dtInicial;
    //  var dtfim = dtFinal;
    //  if (( dtini=='' ) && ( dtfim=='' ) ) {
    // if( ( dtInicial.length<10 ) || ( dtFinal.length<10 ) ) {        
    if( ( dtInicial.length<10 )  ) {        
        //
        //  alert('Complete os Campos.');
        //  campos.inicial.focus();
        //  return false;
        m_corrigir = confirm("Digitar as datas?"); 
        if( m_corrigir==true ) {   /// testa se o usuario clicou em cancelar
             //
             // Mensagem de Erro
             msg_erro = msg_erro+'&nbsp;Digitar as datas'+final_msg_erro;
             //
             //  Ativando mensagem de erro
             exoc("label_msg_erro",1,msg_erro);
             //
             document.getElementById(dtinicial_nome).focus();    
             //    return false;            
             m_erro = 1;
             //
        } else if( m_corrigir==false ) { 
            m_erro = 0;
        }
        return m_erro;
        //
    }
    ///  Anterior de 20250515
    /// Converte as datas em milisegundos
    var datInicio = new Date(dtInicial).getTime();
    var datFim = new Date(dtFinal).getTime();
    ///
    if( datInicio<=datFim ) {
        //
        // alert('Cadastro Completo!');
        m_erro = 0;
        return m_erro;
        //  return true;
    } else {
        //
        //  A function acentuarAlerts para corrigir acentuacao
        var mensag_erro=acentuarAlerts("ATENÇÃO: Data Inicial é MAIOR que Data Final");
        alert(mensag_erro);
        // 
        /**    ATUALIZADO EM 20250515
         *   msg_erro = msg_erro+'&nbsp;Corrigir campo.'+mensag_erro+final_msg_erro;
         */
        var msgerr = msg_ok+mensag_erro+msg_final;
        //
        //  Inserindo mensagem de erro no ID  label_msg_erro
        //  document.getElementById("label_msg_erro").innerHTML=msg_erro;                  
        exoc("label_msg_erro",1,msgerr);           
        //
        document.getElementById(dtinicial_nome).focus();    
        //
        m_erro = 1;
        //
        return m_erro;
        //
   } 
   //
   return;   
   //
}
/**  Final - function verificadatas(dtinicial_nome, dtfinal_nome, dtInicial, dtFinal) {   */
//
//   Forca da Senha
function verificaForca(campo) {
    var div=document.getElementById('div_forca_senha');
    var valor = campo.value;
    var contemNumeros = /[0-9]/;
    var contemLetras = /[a-z]/i;
    var contemEspecial = /[@#$%;*&+]/;
    var contagem = 0;
    //
    if ( valor.length > 0 ) {
        if (contemNumeros.test(valor)) contagem++;
        if (contemLetras.test(valor)) contagem++;
        if (contemEspecial.test(valor)) contagem++;

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
    }
} 
//
/**  
*          20170203  --  functions para Telefone,CPF,CEP    
*/
///   Function prinicipal que inicia
function Mascara(o,f){
        v_obj=o
        v_fun=f
        setTimeout("execmascara()",1)
}
/*  Função que Executa os objetos  */
function execmascara(){
        v_obj.value=v_fun(v_obj.value)
}
///
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
///
///
function Integer(v){
    return v.replace(/\D/g,"")
}
///
/*  Função que padroniza telefone (11) 4184-1241  */
function Telefone(v){
    v=v.replace(/\D/g,"")                 
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") 
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    
    return v
}
/*  Função que padroniza telefone (11) 41841241   */
function TelefoneCall(v){
    v=v.replace(/\D/g,"")                 
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2")    
    return v
}
/*  Função que padroniza CPF  */
function Cpf(v){
    v=v.replace(/\D/g,"")                    
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") 
    return v
}
/*  Função que padroniza CEP  */
function Cep(v){
    v=v.replace(/D/g,"")                
    v=v.replace(/^(\d{5})(\d)/,"$1-$2") 
    return v
}
/*  Função que padroniza CNPJ  */
function Cnpj(v){
    v=v.replace(/\D/g,"")                   
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")     
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") 
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              
    return v
}
/*  Função que permite apenas numeros Romanos  */
function Romanos(v){
    v=v.toUpperCase()             
    v=v.replace(/[^IVXLCDM]/g,"") 
    while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="")
        v=v.replace(/.$/,"")
    return v
}
/*  Função que padroniza o Site  */
function Site(v){
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
/*  Função que padroniza DATA  */
function Data(v){
    v=v.replace(/\D/g,"") 
    v=v.replace(/(\d{2})(\d)/,"$1/$2") 
    v=v.replace(/(\d{2})(\d)/,"$1/$2") 
    return v
}
/* Função que padroniza DATA  */
function Hora(v){
    v=v.replace(/\D/g,"") 
    v=v.replace(/(\d{2})(\d)/,"$1:$2")  
    return v
}
/* Função que padroniza valor monétario */
function Valor(v){
    v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
    v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
    //v=v.replace(/(\d{3})(\d)/g,"$1,$2")
    v=v.replace(/(\d)(\d{2})$/,"$1.$2") //Coloca ponto antes dos 2 últimos digitos
    return v
}
/* Função que padroniza Area  */
function Area(v){
    v=v.replace(/\D/g,"") 
    v=v.replace(/(\d)(\d{2})$/,"$1.$2") 
    return v
}
/******* FINAL - 20170203  --  functions para Telefone,CPF,CEP    ******/
///
///  Verificando a Data - Instalado em 20170503
function validatedate(inputValue,nomeId) {
      //
      //  var dateformat = /^(0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\-]\d{4}$/;  
      //  IMPORTANTE: para verificar validade     
      var isValid = document.getElementById(nomeId).validity.valid;    
      //
      // Ou  var isValid = document.getElementById('email').checkValidity();

 /**  
  alert("LINHA/695 \r\n   validatedate(inputValue,nomeId) -->>  nomeId = "+nomeId+" - inputValue = "+inputValue+" ---   isValid = "+isValid);      
   */         

      //
      var m_ok=1;
      if( ! isValid ) m_ok=0;     
      //
      //  Definindo mensagem de erro
      //  var mensag_erro="ERRO: Data formato inv&aacute;lido!";                        
      var mensag_erro=acentuarAlerts("ERRO: Data formato inválido!");
      //
      //  Caso campo DATA maior que 10 caracteres - padrao 12/12/2013
      if( inputValue.length>10  ) {
            var m_ok=0;
      }
      //
      // Match the date format through regular expression  
      // Combine o formato da data com a expressão regular
      if( parseInt(m_ok)==1 ) {
           //
           //   if( inputValue.value.match(dateformat) ) {  
           //   document.form1.text1.focus();  
           //  Test which seperator is used  '/' or '-'  
           //  TESTA qual seperator é usado   '/' ou '-'  
           var opera1 = inputValue.split('/');  
           var opera2 = inputValue.split('-');  
           //
           /**   Nesse esquema caso for Objeto - inputValue
           *    var opera1 = inputValue.value.split('/');  
           *    var opera2 = inputValue.value.split('-');  
           */  
           var lopera1 = opera1.length;  
           var lopera2 = opera2.length;  
           //
           //  Extract the string into month, date and year  
           //   Extrair a cadeia em mês, data e ano
           var num_barra="";
           if( lopera1>1 )  {  
                //
                //  var pdate = inputValue.value.split('/');  
                var num_barra=inputValue.match(/\//gi).length;
                if( parseInt(num_barra)==2 ) {
                    var pdate = inputValue.split('/');       
                } else {
                    var pdate="";
                    var m_ok=0; 
                }
                //
           } else if (lopera2>1) {  
                //
                // var pdate = inputValue.value.split('-');  
                var num_barra=inputValue.match(/\-/gi).length;
                if( parseInt(num_barra)==2 ) {
                    var pdate = inputValue.split('-');  
                } else {
                    var pdate=""; 
                    var m_ok=0; 
                }
                //
           } 
           //
           //  Total de caracteres da variavel pdate
           var lc_retornar="NAO";
           if( typeof pdate==undefined ) {
                //
                document.getElementById(nomeId).value="DD/MM/YYYY";    
                var lc_retornar="SIM";
            }
            //
            if( parseInt(num_barra)!=2 ) {
                document.getElementById(nomeId).value="DD/MM/YYYY";    
                var lc_retornar="SIM";
            }
            //
            //  Verificar para retornar
            if( lc_retornar.toUpperCase()=="SIM" ) return;
            //
            //  Caso NAO obteve erro - verificar DATA
            if( parseInt(m_ok)==1 ) {
                //
                  
///    alert("LINHA/740 <SEGUINDO> m_ok = "+m_ok+" \r\n   validatedate(inputValue,nomeId) -->>  nomeId = "+nomeId+" - inputValue = "+inputValue);
              
                  ///
                  var coluna1=parseInt(pdate[0]);
                  if( coluna1.length<3 ) {
                      var dd = parseInt(pdate[0]);  
                      var mm = parseInt(pdate[1]);  
                      var yy = parseInt(pdate[2]);  
                  } else if( coluna1.length>=4 ) {
                      var yy = parseInt(pdate[0]);  
                      if( y.length>4 ) y=y.substring(0,4); 
                      var mm = parseInt(pdate[1]);  
                      var dd = parseInt(pdate[2]);  
                  }
                  //
                  /**   Create list of days of a month [assume there is no leap year by default]  */ 
                  /**  Criar lista de dias de um mês [assumir que não há ano bissexto por padrão]  */  
                  var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];  
                  if( mm==1 || mm>2 ) {   
                       //
                       if( dd>ListofDays[mm-1 ]) {  
                           //  alert('Data formato inválido!');  
                           m_ok=0;
                           //  return false;  
                       }  
                       //
                  }  
                  //
                  if( mm==2 ) {  
                      //
                      var lyear = false;  
                      if( ( !(yy % 4) && yy % 100) || !(yy % 400) ) {  
                           lyear = true;  
                      }
                      //  
                        if(( lyear==false) && (dd>=29) ) {  
                            ///  alert('Data formato inválido!');  
                            m_ok=0;
                            ///  return false;  
                        }  
                        if(( lyear==true) && (dd>29) ) {  
                            ///  alert('Data formato inválido!');  
                              ///  return false;  
                              m_ok=0;
                        }  
                  }
              }  
              /**  Final - if( parseInt(m_ok)==1 ) { */    
              //
      ///  } 
          
      } 
      ///  Caso ocooreu erro
      if( m_ok<1 ) {  
           //
           //  Mensagem de ERRO
           alert(mensag_erro);  
           //
           //   document.getElementById(nomeId).value="DD/MM/YYYY";    
           document.getElementById(nomeId).focus();    
           //  document.form1.text1.focus();  
           //  Mensagem de erro ativar
           //    exoc("label_msg_erro",1,mensag_erro);   
           //    
           return false;  
           //
      }
      //  
}   
/**  Final - function validatedate(inputValue,nomeId) { */
//  Final verficando a data
//
