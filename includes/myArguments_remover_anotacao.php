<?php
//   Conectar
$elemento=5; $elemento2=6;
/*  EVITAR ESSA FORMA DE USO:
     @require_once('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
     include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
*/
//  FORMA ADEQUADA:
require_once("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="pt-br" />
<meta name="author" content="LAFB/SPFB" />
<META http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE"> 
<META HTTP-EQUIV="Expires" CONTENT="-1" >
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<link rel="shortcut icon"  href="../imagens/pe.ico"  type="image/x-icon" />  
<META http-equiv="imagetoolbar" content="no">  
<link  type="text/css"  href="../css/estilo.css" rel="stylesheet"  />
<link  type="text/css"   href="../css/style_titulo.css" rel="stylesheet"  />
<script  type="text/javascript" src="../js/XHConn.js" ></script>
<script type="text/javascript"  src="../js/functions.js" ></script>
<script type="text/javascript">
//
function confirma_orientador(name,valor) {
    var ret = new Array(name, valor);
  //  alert(" ret[0] = "+ret[0]+"  -  ret[1] = "+ret[1])
    window.returnValue = ret;
    window.close();
}
//
function limpar_form(dados) {  
    window.returnValue = dados ;
    window.close();
}
//
function Init(nome,valor) {
    var poststr = "";  var opcao="";
    
// alert("  myArguments_remover_anotacao.php/38 -  nome = "+nome+" - valor = "+valor)    
    
   //  Verificando a variavel nome vazia   
   if ( nome==undefined ) {    
         var omyArguments = window.dialogArguments;
         var array_dados = omyArguments.split('#@=');
         var array = new Array(); y=0;
         var n_dados=""; var m_length = array_dados.length;         
         for( i=0; i<m_length ; i++ ) {
            if( i==0 ) {
                var opcao = array_dados[i].toUpperCase();
                poststr +="source="+encodeURIComponent(array_dados[i]);    
            }  else if( i==1 ){
                poststr +="&val="+encodeURIComponent(array_dados[i]);     
            } else {
              //   poststr +="&m_array["+y+"]="+array_dados[i];             
                 n_dados+=trim(array_dados[i]);
                 if( i<m_length ) n_dados+='#@=';
                 y=y+1;             
            }
         }
         poststr +="&m_array="+n_dados;             
   } else if( nome.toUpperCase()=="ANOTACAO" ) {
       var opcao = "anotacao"; var m_val = "anotacao";
   } else if( nome.toUpperCase()=="PROJETO" ) {
       var opcao = "projeto"; var m_val = "projeto";
   }  
   if(  nome!=undefined ) {
     if( nome.toUpperCase()=="ANOTACAO" &&  valor.toUpperCase()=="EXCLUIR"   ) { 
          // ETAPA PARA REMOVER A ANOTACAO DE UM PROJETO NO ARQ. anotacao_remover_ajax.php 
           var opcao="EXCLUIR"; 
           poststr +="source=EXCLUIR&val="+m_val;           
     }
   }

//  alert(" myArguments_remover_anotacao.php/71  -  nome = "+nome+" - valor = "+valor+" - opcao = "+opcao+"  --  poststr = "+poststr)
   
   /*   Aqui eu chamo a class do AJAX */
   var myConn = new XHConn();
        
   /*  Um alerta informando da não inclusão da biblioteca - AJAX   */
   if ( !myConn ) {
        alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
        return false;
   }
   //
   //  Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
   //   ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
     
   var receber_dados = "anotacao_remover_ajax.php";
   
//  alert(" LINHA 86 - arq myArguments_remover_anotacao.php - poststr = "+poststr+" - opcao =  "+opcao+" - receber_dados =  "+receber_dados)   
   
   //
    var inclusao = function (oXML) { 
                     //  Recebendo os dados do arquivo ajax
                     //  Importante ter trim no  oXML.responseText para tirar os espacos
                     var m_dados_recebidos = trim(oXML.responseText);
                     if( document.getElementById("erro_remover") ) document.getElementById('erro_remover').style.display="none";
  //   alert(" myArguments_remover_anotacao.php/96 -  opcao = "+opcao+" \r\n --  m_dados_recebidos =  "+m_dados_recebidos)                          
                     if( opcao=="ANOTACAO" ) {                             
                            //  AUTOR/ANOTADOR E  ORIENTADOR/SUPERVISOR
                            //  if( ( val.toUpperCase()=="AUTOR" ) &&  msa.length>=1 ) {
   // alert("LINHA 144 - arq myArguments_remover.php -  ANOTACAO -  m_dados_recebidos = "+m_dados_recebidos)
                            var pos = m_dados_recebidos.search(/ERRO:|NENHUM/i);
                            if( pos!=-1 ) {
                                // Quando acontece erro ou nao existe dados    
                                if( document.getElementById("corpo_remover") ) {
                                      document.getElementById("corpo_remover").style.display="none";    
                                      if( document.getElementById("erro_remover") ) {
                                          document.getElementById('erro_remover').style.display="block";
                                          document.getElementById("erro_remover").innerHTML=m_dados_recebidos;
                                      }
                                }                                    
                            } else {
                                  //  Dados recebidos sem erro
                                  if( document.getElementById("corpo_remover") ) {
                                         document.getElementById("corpo_remover").style.display="block";    
                                         document.getElementById("corpo_remover").innerHTML=m_dados_recebidos;
                                  }    
                            }
                     } else if( opcao=="EXCLUIR" ) { 
                          //  Depois de ter excluido uma Anotacao de um Projeto
                // alert("DENTEO DO IF opcao  = "+opcao+"  -  m_dados_recebidos = "+ m_dados_recebidos)
                                                 
                            limpar_form("excluido");
                     }  else {
                            var pos = m_dados_recebidos.search(/ERRO:/i);
                            if( document.getElementById('corpo') ) document.getElementById('corpo').style.display="block";
                            document.getElementById('erro_remover').style.display="block";
                            if( pos!=-1 ) {
 //  alert("PASSOU 484 - pos = "+pos+"m_dados_recebidos="+m_dados_recebidos)
                                 // document.getElementById('erro_remover').innerHTML=m_dados_recebidos;
                                 limpar_form("ERRO: excluido");
                            } else {
 //  alert("PASSOU 487 -> m_dados_recebidos = "+m_dados_recebidos+" -  pos = "+pos)
                                  document.getElementById('erro_remover').style.display="none";    
                                  if( opcao=="SUBMETER" ) {
                                        document.getElementById('erro_remover').style.display="block";    
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
                                       document.getElementById('erro_remover').innerHTML=m_dados_recebidos;
                                       // Verificar pra nao acusar erro
                                       if( document.getElementById('arq_link') ) {
                                             document.getElementById('arq_link').style.display="block";        
                                       }
                                       //   document.getElementById('div_form').innerHTML=m_dados_recebidos;
                                  } else  {
                                       if( document.getElementById('corpo') ) {
                                          document.getElementById('corpo').innerHTML=oXML.responseText;      
                                       }  else {
                                           limpar_form("excluido");
                                       }
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
    
        /*
   //  if( pos!= -1 ) {
      if(  texto.search(/APROVADO/)!=-1 ) {
          alert("PASSOU")
          // alert("pos = "+pos)
          //  var fechar = document.createElement("p");
          // var fechar = document.getElementById("div_res");
          // fechar.setAttribute('style','text-align:center;font-size:medium');
          //  fechar.innerHTML = "<input type='button'   class='botao3d' id='Não'  style='cursor: pointer; '  onclick='javascript: window.close();' value='Não' >"; 
      
        //  var newRadioButton = document.createElement("<input type='button'   class='botao3d' id='Não'  style='text-align:center; cursor: pointer; '  onclick='javascript: window.close();' value='Não' >");
        //  document.body.insertBefore(newRadioButton);
          var newRadioButton = document.createElement("<input type='button'   class='botao3d' style='text-align:center; cursor: pointer; '  onclick='javascript: aprovado(\"Teste\");' value='Ok' >");
          var newDiv = document.createElement("<div>");
          document.body.insertBefore(newDiv);
          newDiv.setAttribute('style','text-align:center;');
         //   p = document.createElement("p");
          //  text = document.createTextNode("Confirma? ");
          //  p.appendChild(text)
          //  newDiv.appendChild(p);
          newDiv.appendChild(newRadioButton);        
          //
     }
     */
     return;          
     /*
     var fechar = document.createElement("p");
     fechar.setAttribute('id', "fechar");
     fechar.setAttribute('text-align',"center");
     fechar.setAttribute('font-size',"medium");
     fechar.innerHTML = "<input type='button'   class="botao3d"  style="cursor: pointer; "  onclick='javascript: window.close();' value='Não' >"; 
     */
        
   //   var valor = omyArguments.dados;
      //  var valor = omyArguments;
    //   Criando os campos instituicao, unidade, departamento, setor 
}  //  FINAL da Function Init
//
</script>
<style type="text/css">
<!--
.style1 {
    color: #000000;
    font-weight: bold;
}
.style6 {color: #000000; font-size: 14px; }
.style14 {color: #000000; font-weight: bold; font-size: 14px; }
.style15 {font-size: 14px}
-->
</style>                                              
</head>
<body  style="font-family: arial; font-size: 14pt; "  >
<label  id="erro_remover" style="display:none; position: relative;width: 100%; text-align: center; overflow:hidden;" >
   <font  ></font>
</label>
<script type="text/javascript">
function  aprovado(texto) {
    var omyArguments = window.dialogArguments;
    var array_dados = omyArguments.split('<div ');
     var texto2 = array_dados[0];
     var texto2 = texto2.toString();
    window.returnValue = texto2;
    window.close();
}
//
Init();
</script>
<div id="corpo_remover">
</div>
</body>
</html>
