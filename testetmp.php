   ///  Depois qdo foi ACEITO o USUARIO
    if( ativ_desat_upper=="INICIAR" ) {
        var caminho_http="";
        limpar_campos("limpar");
        ////  Verificar  e desativar ID form
        if( document.getElementById("form") ) {
            ///  Ocultando ID
            exoc("form",0,""); 
        } 
        ///
        ///  Mudando de pagina
        var http_host = m_dados.split("#");
        var LARGURA = screen.width;
        var ALTURA = screen.height;
        var caminho_http=http_host[1];    
        /* Caso o navegador nao for microsoft
           var navegador =navigator.appName;
           var pos = navegador.search(/microsoft/gi);
         */           
         var navegador_usado="<?php echo $_SESSION["navegador"];?>";
         var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
         var is_microsoft = navegador_usado.search(/microsoft|ie/gi);
         
         ///  Verificando se o navegador eÂ´ IE ou CHROME
         ///  if( is_chrome!=-1  || is_microsoft!=-1  ) {
         if(  navegador_usado.toUpperCase()=="CHROME"  || navegador_usado.toUpperCase()=="IE"  ) {
             
////             alert(" CONTINUAR - LINHA/694 -  NAVEGADOR IE OU CHROME"+http_host[1]);
            
               location.replace(http_host[1]); 
               return;
         } else {
    
/*                        
                 alert("LINHA/488 -->> navegador_usado = "+navegador_usado+"  \r\n --caminho_http = "+caminho_http+"   -->>>  ativ_desat = "+ativ_desat+" - mensag = "+mensag+" - m_dados = "+m_dados)        
                  return;
  */                     
                       //  alert(" http_host[1] = "+http_host[1])
                       window.location.replace(http_host[1]);
                     
                       //     window.open('http://www-gen.fmrp.usp.br','_parent','');window.close(); 
                       // } else {
                        //   window.close();
                       //    var win_new = window.open(http_host[1]); 
                       //    win_new.focus();            
                       // }   
                        return;  
         }
    }    