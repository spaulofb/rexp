//
function enviando() {
   document.getElementById("teste2").innerHTML="TESTANDO OK";
 //  document.getElementById("About").innerHTML="";
}
/*
      Funcao principal para enviar dados via AJAX
*/
function dochange(source,val,m_array)  {
    var source_maiusc = source.toUpperCase();   
    
//  alert("dochange.php/36 -  source = "+source+" - val = "+val)                  
    
    //  Sair do programa     
    if ( source_maiusc=="SAIR" ) {
        //   timedClose();
        /*  Navegador/Browser utilizado
           var navegador =navigator.appName;
           var pos = navegador.search(/microsoft/gi);
       */ 
       //  Sair do Site fechando a Janela
       var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
       var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
       var navegador =navigator.appName;
       var pos = navegador.search(/microsoft/gi);
       //  if( pos!=-1 ) {
       //  if( navegador.search(/microsoft/gi)!=-1 ) {        
       if( is_firefox!=-1 ) {
           //  Sair da pagina e ir para o Site da FMRP/USP
           location.replace('http://www.fmrp.usp.br/');                
           // window.open('','_parent','');window.close();    
            //  window.opener=null; 
            //  window.close();            
       } else if( is_chrome!=-1  || pos!=-1  ) {
              window.opener=null; 
              window.close();            
       }
       return;     
    }
    if( source_maiusc=="APRESENTAÇÂO" ) {
        top.location.href="../menu.php";
        return;        
    }    
 
    var login_down = "";
    var senha_down = "";
    var n_upload = "";
    //  Escolhido MENU opcao: Cadastrar, Consultar, etc...
    //  Encontra a variavel source_lista no arquivo menu.php e tb no includes/dochange.php
    /*
    var source_lista = "CADASTRAR CONSULTAR REMOVER ALTERAR";        
    var array_menu_pri = ["CADASTRAR","CONSULTAR","REMOVER","ALTERAR"];    
    var array_length = array_menu_pri.length;
    */
    var source_lista = /CADASTRAR|CONSULTAR|REMOVER|ALTERAR|LOGADO/gi;        
       var temp_opcao =source.toUpperCase();
       //  var pos = source_lista.indexOf(temp_opcao);
    var pos = temp_opcao.search(source_lista);
    var pasta_raiz ="<?php echo $_SESSION["pasta_raiz"];?>"; 
    //  var caminho="http://www-gen.fmrp.usp.br/rexp/";
    var caminho="<?php echo 'http://'.$_SERVER['HTTP_HOST'];?>"+pasta_raiz;
 // alert("dochange.php/62 -> FORA DO IF -  temp_opcao = "+temp_opcao+" - pos = "+pos)              
    if ( pos!= -1  ) {      
        if( typeof(val)!="undefined" ) {   
            var opcao_selecionada = val.toLowerCase();
            if( opcao_selecionada.toUpperCase()=="USU?RIO" ) opcao_selecionada="usuario";
            if( opcao_selecionada.toUpperCase()=="ANOTA??O" ) opcao_selecionada="anotacao";                
        }
        var subcaminho = source.toLowerCase();
        /*  Atribui a sua regex a uma vari?vel comum
        *    dentro dos [], voc? coloca os caracteres 
        *    ou sequ?ncia de caracteres que vai permitir
        */        
        var lnpos = temp_opcao.search(/LOGADO/gi);
 //  alert("dochange.php -> LINHA 73 - IF -  temp_opcao = "+temp_opcao+" - lnpos = "+lnpos)                      
        if ( lnpos != -1  ) {                
            //  alert(" menu.php - lnpos - LOGAR ou LOGADO -  caminho =  "+caminho+" -  subcaminho = "+subcaminho)            
            top.location.href= caminho+"logar.php";
        } else {
            window.parent.location.href= caminho+subcaminho+"/"+opcao_selecionada+"_"+subcaminho+".php?m_titulo="+val.toLowerCase();
        }    
        return;
    }
    //
    m_array = "array_m_v_"+m_array;
//    var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&login="+encodeURIComponent(login)+"&senha="+encodeURIComponent(senha)+"&m_array="+encodeURIComponent(m_array);
    var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+encodeURIComponent(m_array);
    //
    /*   Aqui eu chamo a class  */
    var myConn = new XHConn();
        
    /*  Um alerta informando da n?o inclus?o da biblioteca   */
    if ( !myConn ) {
          alert("XMLHTTP n?o dispon?vel. Tente um navegador mais novo ou melhor.");
          return false;
    }
    //
    //  Arquivo Recebendo as opcoes desejadas: Cadastrar, Sair, etc...
    var receber_dados = "proj_exp_ajax.php";
    //
    /*  Melhor usando display do que visibility - para ocultar e visualizar   */
    //      document.getElementById('div1').style.visibility="visible";
    // document.getElementById(id).style.display="block";
    //  document.getElementById('parte1').style.visibility="hidden";
    //  document.getElementById(id).style.display="none";
    //  document.getElementById('corpo').style.display="none";
    //
    var inclusao = function (oXML) { 
                        //  Verificando se nao tem a div do menu_vertical
                        var dados_recebidos = oXML.responseText;
                        // 
                        //    var pos = source_lista.indexOf(temp_opcao);
                       var pos = temp_opcao.search(source_lista);                        
                       if ( source.toUpperCase()=="SAIR" ) {
                               /*    login_down = "";
                                senha_down = "";
                                top.location.href=dados_recebidos;
                                */
                                     //  Sair do Site e abrir outrar janela nova  
                             /*   var newwindows=window.open(dados_recebidos);
                                 newwindows.creator=self;
                                 window.close();
                             */
                              //  Sair do Site fechando a Janela
                              window.open('','_parent','');window.close();    
                           //  } else if ( source.toUpperCase()=="CADASTRAR" ) {            
                       } else if ( pos!= -1  ) {            
                               top.location.href=dados_recebidos;
                          } else {
                                  document.getElementById('corpo').style.display="block";
                                document.getElementById('corpo').innerHTML= oXML.responseText;
                      }
               }; 
            /* 
              aqui ? enviado mesmo para pagina receber.php 
               usando metodo post, + as variaveis, valores e a funcao   */
        var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
        /*  uma coisa legal nesse script se o usuario n?o tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho   */
}
//
//   Tempo para fechar o site
// var timer;
// function timedClose() {
        //  clearTimeout(timer);
        //  timer = setTimeout("dochange('Sair')",tempo_exec);
        //  timer = setTimeout("dochange('Sair')",180000);
        //	return;
// }  
//  Final do timedClose
//

