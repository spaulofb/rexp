<?php
/*  javascript chamando PHP - para a OPCAO DA RAIZ - Ex.: Apresentacao/Logado como: 
    Verificando se sseion_start - ativado ou desativado
    Alterado em  20170922
*/
if( !isset($_SESSION)) {
     session_start();
}
////
$php_errormsg='';
/*** 
     Alterado em 20171009
***/
////  $_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
/////  $_SESSION["url_central"] = $_SESSION["http_host"];
///  Verificando caminho http e pasta principal
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
<script type="text/javascript">
///
charset="utf-8";
///
// /  Javascript - 20171020
/*
     Aumentando a Janela no tamanho da resolucao do video
*/
self.moveTo(-4,-4);
//  self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
//  self.resizeTo(1000,1000);
self.focus();
///   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
/*
if ( screen.width<1024 ) {
    alert("A resolução da tela do seu monitor para esse site é\n RECOMENDÁVEL no mínimo 1024x768 ")
}
*/
//  Desabilitar a funcao de voltar do Browser
javascript:window.history.forward(1);
/****  
   Definindo as  variaveis globais  -  20171020

        Define o caminho HTTP
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
///   Pasta principal
var pasta_raiz ="<?php echo $_SESSION["pasta_raiz"];?>"; 
///
/*
      Funcao principal para enviar dados via AJAX
*/
function dochange(source,val,m_array)  {
    /// Verificando se a function exoc existe 
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
        /// Variavel com letras maiusculas
         var val_upper=val.toUpperCase();
         /// IMPORTANTE: para retirar os acentos da palavra
         /////  var val=retira_acentos(val);
         var val_sem_acentos=retira_acentos(val);
         var val=val_sem_acentos;
         
         ///  Retirando acentos
          var  mlength=val.length;
          ///
          for(  i=0;  i<mlength-1;  i++  )   {
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

 ///  alert("domenu/58  --- INICIANDO  --- source = "+source+" -  val  = "+val+"   ---  m_array = "+m_array);

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
        ///  Retirando acentos
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
          ///  esse elemento definido como Array
          var source_array_pra_string=source.join("");
          /// IMPORTANTE: para retirar os acentos da palavra
          var source_sem_acentos=retira_acentos(source_array_pra_string);
          /// 
          var source=source_sem_acentos;
          //// 
    }
    ///
    /// Variavel com letras maiusculas
    var source_maiusc = source.toUpperCase();     
    /****  
         Define o caminho HTTP    -  20180228
     ***/  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
     
    ///  Variavel com letras minusculas
    var subcaminho = source.toLowerCase();

 ///  alert("  domenu.php/71  --->> raiz_central = "+raiz_central+"  --- source = "+source+" - val = "+val+"  -- m_array = "+m_array+"  -- source_maiusc =  "+source_maiusc); 

    ///  Sair do programa     
    if( source_maiusc=="SAIR" ) {
           ///   timedClose();
         /*   NAVEGADOR/Browser utilizado        */ 
         ///  Sair do Site fechando a Janela
         var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
         var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
         var navegador =navigator.appName;
         /***
                   Alterado em 20170922
         ****/
         var navegador_usado="<?php echo $_SESSION["navegador"];?>";
         var is_microsoft = navegador_usado.search(/microsoft|ie/gi);
         ///  if( pos!=-1 ) {
         ///  if( navegador.search(/microsoft/gi)!=-1 ) {        
         if( is_firefox!=-1 ) {
               //  Sair da pagina e ir para o Site da FMRP/USP
               /// location.replace('http://www.fmrp.usp.br/');      
               parent.location.href=raiz_central+"reiniciar.php";          
         } else if( is_chrome!=-1  || is_microsoft!=-1  ) {
              /// Melhor opcao para  sair do Chrome
              parent.location.href=raiz_central+"reiniciar.php";
              window.open('', '_self', ''); // bug fix
              window.close();            
         }
         ///
        return;     
    }
    ///  Pagina inicial do MENU
    if( source_maiusc=="APRESENTACAO" ) {
        /// top.location.href="../menu.php";
        location.href=raiz_central+"menu.php";
        return;     
    }
    ///
    /***  Alterado em 20170921    
     else if( source_sem_acentos=="ANOTACAO" ) {     
        //  ANOTACAO NOVA - 20170919
        /// top.location.href="../includes/anotacao_nova.php?m_titulo=Anota??es";
        location.href=raiz_central+"includes/anotacao_nova.php?m_titulo=Anotacoes";
        return;                       
    }  else if( source_sem_acentos=="ALTERAR_SENHA" ) {
        //  Apenas quando for o ANOTADOR
        //// top.location.href="../alterar/senha_alterar.php";
        location.href=raiz_central+"alterar/senha_alterar.php";
        return;                
    }    
    ***/
    
////  alert(" domenu.php/212 --->>>  source_sem_acentos = "+source_sem_acentos+"---  source = "+source+"  ---  val = "+val);        
    
    /***  Alterado em 20170921    ***/
    if( source_sem_acentos.toUpperCase()=="ANOTACAO" ) {     
         ///  ANOTACAO NOVA - 20181026
        /// top.location.href="../includes/anotacao_nova.php?m_titulo=Anotacoes";
        /***
             location.href=raiz_central+"includes/anotacao_nova.php?m_titulo=Anotacoes";
        ***/
        ////  Cadastrar/Alterar/Remover Anotacao feita pelo Anotador
        if( val.toUpperCase()=="CADASTRAR"  ) {
            location.href=raiz_central+"cadastrar/anotacao_cadastrar.php";
        } else if( val.toUpperCase()=="ALTERAR" ) {
            location.href=raiz_central+"alterar/anotacao_alterar.php";
        } else if( val.toUpperCase()=="CONSULTAR" ) {
            location.href=raiz_central+"consultar/anotacao_consultar.php";
        } else if( val.toUpperCase()=="REMOVER" ) {
            location.href=raiz_central+"remover/anotacao_remover.php";
        }    
        ///
        return;                       
        ///
    } else if( source_sem_acentos.toUpperCase()=="ALTERAR_SENHA" ) {
        //  Apenas quando for o ANOTADOR
        //// top.location.href="../alterar/senha_alterar.php";
        location.href=raiz_central+"alterar/senha_alterar.php";
        return;                
    }    
    ///
    /// LOGIN e SENHA 
    var login_down = "<?php echo $_SESSION['login_down'];?>";
    var senha_down = "<?php echo $_SESSION['senha_down'];?>";
    var n_upload = "<?php echo $_SESSION['n_upload'];?>";
    ///  Escolhido menu opcao: Cadastrar, Consultar
    ///  Encontra a variavel source_lista no arquivo menu.php e tb no includes/dochange.php
    /// var source_lista = "CADASTRAR CONSULTAR REMOVER ALTERAR LOGADO";        
    var source_lista = /CADASTRAR|CONSULTAR|REMOVER|ALTERAR|LOGADO/gi;        
    var temp_opcao =source_maiusc;
    var pos = temp_opcao.search(source_lista);
    /// 
 
///  alert(" domenu.php/222 - pos = "+pos+"  -->>  login_down = "+ login_down+"  --  senha_down = "+ senha_down+" --  source = "+source+"  -- val = "+val+" ---  raiz_central = "+raiz_central+"   ---   pasta_raiz = "+pasta_raiz+"  -->>> \r\n\n pagina_local = "+pagina_local+"  <<<---->>>   n_upload = "+ n_upload );     
///  alert(" domenu.php/222 - pos = "+pos+"  -->>  login_down = "+ login_down+"  --  senha_down = "+ senha_down+" --  source = "+source+"  -- val = "+val+" ---  raiz_central = "+raiz_central+"   ---   pasta_raiz = "+pasta_raiz);    
    
    if( pos!=-1  ) { 
         ///  Caso a variavel val NAO for vazia alterar para minuscula
         var val_length=val.length;
         if( val.length>0 ) {   
              var val = val.toLowerCase(); 
              ////    var opcao_selecionada = val.toLowerCase();
              var opcao_selecionada = encodeURI(val);
              var opcao_selecionada = unescape(val);
              var opcao_selecionada_maisc = val.toUpperCase();
              ///  Retirando os acentos da palavra
              if( opcao_selecionada_maisc=="USUARIO" ) {
                   opcao_selecionada="usuario";  
              } 
             //// var lnpos = val.search(/ANOTACAO/i);
             ///  var lnpos = opcao_selecionada.search(/ANOTACAO/i);
             if( opcao_selecionada_maisc=="ANOTACAO" ) {
                  opcao_selecionada="anotacao";                
             } 
             ///             
         }
        /*  Atribui a sua regex a uma vari?vel comum
        *    dentro dos [], voc? coloca os caracteres 
        *    ou sequ?ncia de caracteres que vai permitir
        */
        var lnpos = temp_opcao.search(/LOGADO/gi);
        if( lnpos!=-1  ) {                  
              ///  Opcao para trocar de  usuario  (Chefe, Orientador, Anotador e etc...) 
              /// top.location.href= caminho+"logar.php";  
              ////  location.href= caminho+"logar.php";  
              //// location.href=raiz_central+"logar.php";  
              location.href=raiz_central+"logar.php";  
        } else {
              /// location.href=caminho+subcaminho+"/"+opcao_selecionada+"_"+subcaminho+".php?m_titulo="+val.toLowerCase();
             
              ///  Retirando acentos - 20171005
              var  mlength=opcao_selecionada.length;
              ///
              for(  i=0;  i<mlength-1;  i++  )   {
                    /// Removendo acento
                    opcao_selecionada = opcao_selecionada.replace(/[âáàã]/,"a");
                    opcao_selecionada = opcao_selecionada.replace(/[éèê]/,"e");
                    opcao_selecionada = opcao_selecionada.replace(/[íìî]/,"i");
                    opcao_selecionada = opcao_selecionada.replace(/[ôõóò]/,"o");
                    opcao_selecionada = opcao_selecionada.replace(/[úùû]/,"u");
                    opcao_selecionada = opcao_selecionada.replace("ç","c");
                    opcao_selecionada = opcao_selecionada.replace(" ","-");    
                    ///
              }
              ///
              var val_lower=opcao_selecionada.toLowerCase();
              location.href=raiz_central+subcaminho+"/"+opcao_selecionada+"_"+subcaminho+".php?m_titulo="+val_lower;
              //
        }                
        ///
        return;
    }
    //// 
    m_array = "array_m_v_"+m_array;
    var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&login="+encodeURIComponent(login_down)+"&senha="+encodeURIComponent(senha_down)+"&m_array="+encodeURIComponent(m_array);
    ////
    /*   Aqui eu chamo a class  */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclus?o da biblioteca   */
    if( !myConn ) {
        alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
        return false;
    }
    ///   Arquivo AJAX para receber dados e retornar resultado
    var receber_dados = pasta_raiz+"menu_ajax.php";
    ///
    /*  Melhor usando display do que visibility - para ocultar e visualizar   */
    ///   document.getElementById('div1').style.visibility="visible";
    ///   document.getElementById(id).style.display="block";
    ///   document.getElementById('parte1').style.visibility="hidden";
    ///   document.getElementById(id).style.display="none";
    ////
    var inclusao = function (oXML) { 
                     ///  Verificando se nao tem a div do menu_vertical
                     var dados_recebidos = oXML.responseText;
                     /// Caso houver Erro 
                     var pos = dados_recebidos.search(/ERRO:|FALHA:/i);

 ///  alert(" domenu/312 -> pos = "+pos+" --inclusao--  raiz_central = "+raiz_central+" -- source_sem_acentos = "+source_sem_acentos+" - val = "+val+"  \r\n dados_recebidos = "+dados_recebidos);                         
                     
                        /// Verifica se houve erro
                        if( pos!=-1 ) {
                              /// Mensagem de erro ativar
                               exoc("label_msg_erro",1,dados_recebidos);   
                               /*    document.getElementById('label_msg_erro').style.display="block";
                                      document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                               */
                              return;
                        }
                       /// Final - IF se houver erro        
                       ///
                       if( source_sem_acentos.toUpperCase()=="SAIR" ) {
                              //   top.location.href=dados_recebidos;
                             /*    var newwindows=window.open(dados_recebidos);
                             newwindows.creator=self;
                             window.close();  */
                          //////   var raiz_central="<?php echo $http_host;?>";      
                             ///  Sair do Site fechando a Janela
                             var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
                             var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
                             var navegador =navigator.appName;
                             //
                             //  Alterado em 20131119
                             //  var is_microsoft = navegador.search(/microsoft/gi);
                             //
                             var navegador_usado="<?php echo $_SESSION["navegador"];?>";
                             var is_microsoft = navegador_usado.search(/microsoft|ie/gi);
                             //  if( pos!=-1 ) {
                             //  if( navegador.search(/microsoft/gi)!=-1 ) {        
                             if( is_firefox!=-1 ) {
                                   ///  Sair da pagina e ir para o Site da FMRP/USP
                                   /// location.replace('http://www.fmrp.usp.br/');      
                                   parent.location.href=raiz_central+"reiniciar.php";          
                             } else if( is_chrome!=-1  || is_microsoft!=-1  ) {
                                  /// 20120912 - Melhor opcao para  sair do Chrome
                                  parent.location.href=raiz_central+"reiniciar.php";
                                  window.open('', '_self', ''); // bug fix
                                  window.close();            
                             }
                             //
                       } else  if( source_sem_acentos.toUpperCase()=="LOGAR"  ) {            
                             ///  Primeira parte - escolher opcao
                             
                             /*
                             if( document.getElementById('corpo') ) {
                                 document.getElementById('corpo').innerHTML=dados_recebidos;
                             }
                             */
                              /// Dados recebidos pelo arquivo AJAX
                               exoc("div_form",1,dados_recebidos);   
                             ///
                       } else  if( source_sem_acentos.toUpperCase()=="PA_SELECIONADO"  ) {            
                             //  top.location.href="http://www-gen.fmrp.usp.br/rexp/menu.php"; 
                             // top.location.href="http://sol.fmrp.usp.br/rexp/menu.php"; 
                             ///// top.location.href="./menu.php"; 
                             ////  top.location.href=raiz_central+"menu.php"; 
                             location.href=raiz_central+"menu.php";
                             return;
                             ///
                       } else {
                           //    var pos = source_lista.indexOf(temp_opcao);
                           var pos = temp_opcao.search(source_lista);                       
                           if( pos!= -1  ) {            
                               top.location.href=dados_recebidos;
                           } else {
                               /*
                                 document.getElementById('corpo').style.display="block";
                                  document.getElementById('corpo').innerHTML= oXML.responseText;
                                ***/
                                /// Enviando dados
                                /// Dados recebidos pelo arquivo AJAX
                                exoc("corpo",1,dados_recebidos);   
                                ///
                           }     
                      }
               }; 
            /* 
              aqui ? enviado mesmo para pagina receber.php 
               usando metodo post, + as variaveis, valores e a funcao   */
        var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
        /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho   */
}
//
//     Tempo para fechar o site
// var timer;
// function timedClose() {
        //  clearTimeout(timer);
        //  timer = setTimeout("dochange('Sair')",tempo_exec);
       //      timer = setTimeout("dochange('Sair')",180000);
       //    return;
// }  
//  Final do timedClose
//
///   Nao aceitar o BACKSPACE - IMPORTANTE PARA NAO VOLTAR PAGINA
function no_backspace(event) {
         //  var e = (e)? e : event;
         var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
         var tecla = keyCode;
    //   if(  tecla==8   ) {
    if ( tecla==8 && ( event.srcElement.form==null || event.srcElement.isTextEdit==false )  ) {         
        event.cancelBubble = true;  
        event.returnValue = false;  
         return false;
    }
}
///
///
</script>