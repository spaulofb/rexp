<?php
//
//   Cadastrar Pessoa -  js
//
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
//
?>
<script language="JavaScript" type="text/javascript">
/**
     JavaScript Document  - 20180605
      arquivo pessoal_cadastrar_js 
*******************************************************/
/****  
        Define o caminho HTTP  -  20180605
***/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";    
///
///
charset="utf-8";
///
///  variavel quando ocorrer Erros
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
///
///   funcrion acentuarAlerts - para corrigir acentuacao
///  Criando a function  acentuarAlerts(mensagem)
function acentuarAlerts(mensagem) {
    //
    //  Paulo Tolentino
    /**   Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));   */
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
/***   PARA CADASTRAR - PESSOA - PROJETO/ANOTACAO    ***/
function enviar_dados_cad(source,val,string_array) {
    //
    //  Verificando se a function exoc existe 
    if( typeof exoc=="function" ) {
         /**
         *   Ocultando ID  e utilizando na tag input comando onkeypress
         */
         exoc("label_msg_erro",0);  
         //
    } else {
        //
        alert("funcion exoc não existe - ADMINISTRADOR CORRIGIR.");
        return;        
    }
    //
   
 //// alert(" Pessoal_cadastrar_js/9 --->>>  source = "+source+" -- val = "+val);   
 
    //
    //  Verificando variaveis
    var val_upper="";
    if( typeof source=="undefined" ) var source=""; 
    if( typeof val=="undefined" ) var val="";
    if( typeof string_array=="undefined" ) var string_array="";
    if( typeof val=="string" ) val_upper=val.toUpperCase();
    
    /// Verifica se a variavel e uma string
    var source_maiusc=""; 
    var source_array_pra_string="";  
    if( typeof source=='string' ) {
        //
        //  source = trim(string_array);
        //  string.replace - Melhor forma para eliminiar espaços no comeco e final da String/Variavel
        source = source.replace(/^\s+|\s+$/g,"");        
        source_maiusc = source.toUpperCase();     
        var pos = source.indexOf(",");     
        if( pos!=-1 ) {  
            //
            //  Criando um Array 
            var array_source = source.split(",");
            var teste_cadastro = array_source[1];
            var  pos = teste_cadastro.search("incluid");
        }
        //
    }  else if( typeof source=='number' && isFinite(source) )  {
          source = source.value;                
    } else if(source instanceof Array) {
          //  esse elemento definido como Array
          var source_array_pra_string=src.join("");
    }
    ///
    var opcao = source.toUpperCase();
    /**  
    *       Define o caminho HTTP    -  20250121
    */  
    var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
    var pagina_local="<?php echo  $_SESSION["protocolo"]."://{$_SERVER["HTTP_HOST"]}{$_SERVER['PHP_SELF']}";?>";       
    //
   
/**
 *    alert(" pessoal_cadastrar_js/139 -->>  INICIANDO enviar_dados_cad  -->>   source = "+opcao+" -- val = "+val); 
 */


   
     /**    
     *   Reiniciar a pagina atual 
     *     - utilizar a variavel paginal_local
     */
     if( opcao=="RESET" ) {
         parent.location.href=pagina_local;                
         return;   
     }
     ///      
    ///  Verificando Chefe/Orientador
    if( opcao=="CHEFE" ) { 
        //
        // Procurando
        var pos_chefe = val_upper.search(/OUTRO/i);
        ///  if( val_upper=="OUTRO_CHEFE" ) {  
        if( pos_chefe!=-1 ) {  
            //
            //  Ativando div ID  outro_chefe
            exoc("outro_chefe",1);
            exoc("novo_chefe",1);  
            if( document.getElementById("novo_chefe") ) {
                 document.getElementById("novo_chefe").disabled=false;
                 document.getElementById("novo_chefe").focus();
            }
            //
        } else {
            //
            if( document.getElementById("novo_chefe") ) {
                document.getElementById("novo_chefe").disabled=true;
            }
            //
            //  Desativando div ID  outro_chefe
            exoc("outro_chefe",0); 
            // exoc("novo_chefe",0); 
            //
       }   
       return;                
   }
   // 
   //  Verificando Novo Chefe/Orientador
   if( opcao=="NOVO_CHEFE" ) { 
       //
         if( typeof val=="undefined" ) {
              var val="";
              var valor = trim(document.getElementById("novo_chefe").value);
              document.getElementById("novo_chefe").value=valor+val;
              return;   
         }
         ////
         var m_browse_num=0;
         var nome_navegador_index_msi = navigator.appName.indexOf("Microsoft");
         var nome_navegador_index_firefox = navigator.userAgent.indexOf("Firefox");
         var navegador_usado="<?php echo $_SESSION["navegador"];?>";
         var m_submit=""; var m_nome="";
         var pos0 = navegador_usado.search(/IE|CHROME/i);
         ///  Melhor maneira de saber qual tecla foi pressionada
          var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
          var tecla = keyCode;
          ////
          if( navegador_usado.search(/IE|CHROME/i)!=-1 ) {
                  m_browse_num=2;
                  m_submit = window.event.srcElement.type;
                  var m_nome = window.event.srcElement.name;
          } else if( navegador_usado.search(/Firefox/i)!=-1  ) {  
                  m_browse_num=3;
                  m_submit = e.target.type;
                  var m_nome = e.target.name;
          } else if( navegador_usado.search(/Netscape/i)!=-1 ) {
                 //    if( navigator.appName=="Netscape" ) {
                  m_browse_num=1;
                  m_submit = e.target.type;
                  var m_nome = e.target.name;
          }
          //
          // Verificando as teclas
          var erro=0; 
          if( typeof tecla!="undefined"  ) {
              if( parseInt(tecla)==32 ) {
                  // erro=1;   
                  return;
              } else  var keyASCII=String.fromCharCode(tecla);             
              //
          } else erro=1;
          //
          if( erro==1 ) {
              var keyASCII="";  
              var valor_recebido=document.getElementById(m_nome).value;
              document.getElementById(m_nome).value=valor_recebido.replace(/^\s+|\s+$/g,"");
              return false;
          }
          //
          
     /**    
          alert(" pessoal_cadastrar_js.php/109  -- tecla = "+tecla+"  -->>>  m_nome = "+m_nome+"  --   m_browse_num = "+m_browse_num);
          return;
       */  
       
          //  Enviar dados para o AJAZ
          var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&m_array="+escape(string_array);
          //
   }   
   ///
   if(  opcao=="CONJUNTO" ) {
         //
         /**  Desativando div ID  outros_campos e tab_de_bens  */
         var idcposary = ["instituicao","unidade","depto","setor","bloco","salatipo","sala"];
         var idcposaryln = idcposary.length;
         //
         //  IF Instituicao - Outra caso tiver na Tabela
         if( val.toUpperCase()=="OUTRA" ) {
              //
              source="PESSOAL";
              val="OUTRA";
              /**
               if( document.getElementById("outros_campos") ) document.getElementById("outros_campos").style.display='none';
              */
               for( var zx=0; zx<idcposaryln; zx++ ) {
                        var nome_elemento=idcposary[zx];
                        exoc(nome_elemento,0,""); 
                        /*
                          if( document.getElementById(id_cpo_array[j]) ) {
                                           document.getElementById(id_cpo_array[j]).value="";
                                           document.getElementById(id_cpo_array[j]).style.display="none";
                                    } 
                        */            
               }                                             
               exoc("outros_campos",0,""); 
               exoc("tab_de_bens",0,""); 
               //
         } else {
             //
             //  Ativando div ID  outros_campos e tab_de_bens
             exoc("outros_campos",1); 
             exoc("tab_de_bens",1); 
             //
             var idnmtb = new Array(); // Cria um array vazio
             var idvltb = new Array(); // Cria um array vazio
             //
             var m_array = string_array.split("|");               
             //
             /**  Primeiro elemento valor   */
             var prielmv = m_array[0]; 
             //
             //  Buscar elemento
             var elementoBuscar = prielmv;
             let indice = idcposary.indexOf(elementoBuscar);
             //
             if( indice !== -1) {
                  //
                  if( idcposary.slice(indice+1) ) {
                      //
                       var xarr = idcposary.slice(indice+1);
                       var lenarr = xarr.length;
                       var list="";
                       for( var zx=0;zx<lenarr;zx++ ) {
                             var cpoids =  xarr[zx];
                             //
                             if( document.getElementById(cpoids) ) {
                                 //
                                 var lcelem=document.getElementById(cpoids);
                                 var tdisp =  lcelem.style.display;
                                 if( tdisp!="none" ) {
                                     lcelem.style.display="none";   
                                 }
                                 //
                             }
                             //
                       }
                       /**  Final - for( var zx=0;zx<lenarr;zx++ ) {  */
                       //
                  } 
                  /**  Final - if( idcposary.slice(indice+1) ) {  */
                  //
                  if( idcposary.slice(0,indice+1) ) {
                       //
                       var xarr=null;
                       var xarr = idcposary.slice(0,indice+1);
                       var lenarr = xarr.length;
                       var lst="";
                       //
                       for( var zx=0;zx<lenarr;zx++ ) {
                             //
                             var cpoids =  xarr[zx];
                             //
                             if( document.getElementById(cpoids) ) {
                                 //
                                 var lcelem=document.getElementById(cpoids);
                                 
                                 /**
                                 var tdisp =  lcelem.style.display;
                                 if( tdisp!="block" ) {
                                     lcelem.style.display="block";   
                                 }
                                 */
                                 idnmtb[zx] = cpoids;
                                 idvltb[zx] = lcelem.value;
                                 //
                             }
                             //
                       }
                       /**  Final - for( var zx=0;zx<lenarr;zx++ ) {  */
                       //
                  }
                  /**  Final - if( idcposary.slice(0,indice+1) ) {  */
                  //
             }
             /**   Final - if( indice !== -1) {  */
             //
             /**  Variavel para enviar dados para o Arquivo AJAX executar  */                      
             var poststr="source="+encodeURIComponent(source)+"&val=";
             poststr=poststr+encodeURIComponent(val)+"&m_array="+encodeURIComponent(m_array);
             //
             /**  poststr  - adicionando dados   */
             poststr+="&idnmtb="+encodeURIComponent(idnmtb);
             poststr+="&idvltb="+encodeURIComponent(idvltb);
             //
             //
             // Total dos dados no array - m_array
             var ttlen = m_array.length;
             var ult_element = ttlen-1; 

/**
 *  alert("LINHA/379  -->>  \poststr = "+poststr+" <br> <<-->>  idcposaryln = "+idcposaryln 
 *      +"  -->> m_array[0] = "+prielmv+"  -->>  indice = "+indice+"  -->> ttlen = "+ttlen);          
 */
  

             //
             if( typeof m_array=="object" &&  ttlen ) {
                   //
                   var strar = m_array.join(" ;");
                   //
                   //  Campo anterior
                   var cpo_ant = m_array[0]; 
                   if( opcao=="CONJUNTO" ) {
                        //
                        // Segunda posicao do cpo_ant no array - m_array
                        var z=0;
                        for( y=1; y<=ttlen; y++ ) {
                             //
                             var xmar = m_array[y];
                             if( m_array[y]==cpo_ant ) {
                                  z=y;  
                                  break; 
                             }
                             // 
                        }
                        /**  Final - for( y=1; y<=ttlen; y++ ) { */
                        //
                        
        /**
          alert("LINHA/354  -->>   strar = "+strar+"  -->> ttlen = "+ttlen+" -->> z = "+z);
           */
                        
                        
                        //
                        for( z; z<=ttlen; z++ ) {
                              //
                              if( z<ttlen ) {
                                   //
                                   var mzup = m_array[z].toUpperCase();
                                   if( cpo_ant.toUpperCase()==mzup ) {
                                         continue; 
                                   }  
                                   //
                                   /**  Criando uma variavel com o valor do nr. de elementos do array  */
                                   var n_sel_opc = z+1;
                                   //
                              }
                              //
                              //  Esse if pra definir o proximo campo
                               var m_array_length = ttlen;
                               var prox_cpo = "";  
                               //                            
                               if( n_sel_opc<=ttlen )  prox_cpo = m_array[z];
                               //
     
                      /**         
                        alert(" 295  -->>  prox_cpo = "+prox_cpo);
                      */         
                               
                               
                               //
                               if( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                                    n_sel_opc=3;   
                                    var id_cpo_array = ["td_salatipo","td_sala"];                         
                                    for( var j=0; j<id_cpo_array.length; j++ ) {
                                         if( document.getElementById(id_cpo_array[j]) ) {
                                                document.getElementById(id_cpo_array[j]).value="";
                                                document.getElementById(id_cpo_array[j]).style.display="none";
                                         } 
                                    }                        
                              }
                              //
                              /**  poststr  - adicionando dados   */
                              poststr+="&n_cpo="+encodeURIComponent(n_sel_opc);
                              poststr+="&cpo_final="+encodeURIComponent(m_array_length);
                              //
                              break; 
                              //
                          }
                          /**  Final - for( z; z<=ttlen; z++ ) {  */
                          //
                       
                       /**
                     alert("--->>>   LINHA/346  -->> poststr = "+poststr);
                     */
                          
                          
                     }
                     /**   Final - if( opcao=="CONJUNTO" ) {  */
                     //
             }
             /**  Final - if( typeof m_array=="object" &&  ttlen ) { */
             // 
          }
          /**
          *   if( document.getElementById("outros_campos") ) document.getElementById("outros_campos").style.display='block';
          */
          // 
     }               
     /**   FINAL - if( ( typeof string_array!='undefined') && ( opcao=="CONJUNTO" )    */
     //
     /**  SUBMETER - ENVIAR DADOS  */
     if( opcao=="SUBMETER" ) {
         //
         //  Verificando a variavel string_array
         if( typeof string_array=="undefined" ) {
              //
              alert("LINHA/225 - UNDEFINED string_array = "+string_array);
              //
         }       
         //
         var frm = string_array;
         //
         //   Antes de remover um  ID
         var m_elements_total = frm.length; 
         if( document.getElementById("tmpnovochefe") ) {
              var elem = document.getElementById("tmpnovochefe");
              elem.remove();
              //
         }
         //
         //   Depois de removido um  ID
         var m_elements_total = frm.length; 
         //
         /**  Ocultando ID  - Desativar mensagem  */
         exoc("label_msg_erro",0,""); 
         //
         var m_erro = 0; 
         var n_coresponsaveis= new Array(); 
         var n_i_coautor=0;   var n_senhas=0; 
         var n_testemunhas=0; 
         var n_datas=0; 
         var arr_dt_nome = new Array(); var arr_dt_val = new Array();
         var campo_nome=""; var campo_value=""; var m_id_value="";
         //
         //  Verificando todos os campos do FORM
         for( i=0; i<m_elements_total; i++ ) {      
               //
               if( typeof frm.elements[i]===undefined ) {
                    alert("  frm.elements  undefinied");
                    continue;  
               }
               // 
    
  /// alert("-> cpo#"+i+"  -- total = "+m_elements_total);

              /**  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)  */
              var m_id_name = frm.elements[i].name;
              var m_id_type = frm.elements[i].type;
              var m_id_title = frm.elements[i].title;
              /// var m_id_value = frm.elements[i].value;
              ///  var m_id_value = frm.elements[i].value;
              var m_id_value="";
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
              //   
              //  ALERT - para testar o FORM do EXPERIMENTO
             
  /**             
     alert("LINHA/274  -- m_id_name = "+m_id_name+" -  m_id_type = "+m_id_type);
   */
             
              if( m_id_type=="checkbox" ) {
                   //
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
                     /**  Verficando se tem dois campos senha e outro para confirmar  */
                     var midnmup = m_id_name.toUpperCase();
                     if( ( midnmup=="SENHA" ) || ( midnmup=="REDIGITAR_SENHA" ) ) {
                          n_senhas=n_senhas+1;
                     }                     
                     /**  Final - if( ( midnmup=="SENHA" ) || ( midnmup=="REDIGITAR_SENHA" ) ) {  */
                     //
                  }
                  //                 
              } else if(  m_id_type=="email" ) {  
                  //
                  var  m_id_value = trim(document.getElementById(m_id_name).value);
                  //  Verificando o campo email                          
                  var m_email = /(EMAIL|E_MAIL|USER_EMAIL)/i;
                  if( m_email.test(m_id_name) ) {
                       var resultado = validaEmail(m_id_name);  
                       if( resultado===false  ) return;
                  }
                  // 
              } else if( m_id_type=="text" ) {  
                  //
                  m_id_value = trim(document.getElementById(m_id_name).value);
                  if( m_id_value=="" ) {
                      //
                      var m_erro = 1;    
                      var posx = m_id_name.search(/TELEFONE|Telefone|FONE|fone|ramal|RAMAL|Ramal/i);
                      if( posx!=-1 ) {                        
                          m_erro = 0; 
                      }   
                  } else {
                      //
                      //  Se campo for usuario ou  senha
                      if( ( m_id_name.toUpperCase()=="LOGIN" ) || ( m_id_name.toUpperCase()=="SENHA" ) ) {
                             if( m_id_value.length<8 )  var m_erro = 1;    
                      }
                      //
                      //  Verifica se nao houve erro
                      if( m_erro<1 ) {
                           //
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
             } else if( m_id_type=="hidden"  ) {  
                    m_erro=0;
                    m_id_value = trim(document.getElementById(m_id_name).value);
             } else if( m_id_type=="number" ) {  
                    m_erro=0;
                    m_id_value = trim(document.getElementById(m_id_name).value);
             } else if( m_id_type=="textarea" ) {  
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value=="" ) var m_erro = 1;     
              }  else if( m_id_type=="select-one" ) {
                    var m_erro = 0; 
                    if( m_id_name=="anotacao_select_projeto" || m_id_name.toUpperCase()=="ALTERA_COMPLEMENTA" ) continue;
                    m_id_value = trim(document.getElementById(m_id_name).value);
                    if( m_id_value=="" )  m_erro = 1;    
                    ///
              } else if( m_id_type=="file" ) {  
                   m_id_value = trim(document.getElementById(m_id_name).value);
                   if( m_id_value==""  ) {
                          var m_erro = 1;    
                   } else {
                       var tres_caracteres = m_id_value.substr(-3);  
                       var pos = tres_caracteres.search(/pdf/i);
                       /// Verificando se o arquivo formato pdf
                       if( pos==-1 ) {
                            m_erro=1; m_id_title="Arquivo precisa ser no formato PDF.";
                       }
                   }
                   //
              }
              //
              //  Verificando os coautores ou colaboradores
              var pos = m_id_name.search(/ncoautor/i);
              if( pos!=-1 ) {
                   m_id_value = trim(document.getElementById(m_id_name).value);
                   n_coresponsaveis[n_i_coautor]=m_id_value;
                   n_i_coautor++;
              }              
              ///
             var copiar="SIM";
             //
             ///  Outro Chefe
             if( m_id_name.toUpperCase()=="CHEFE" ) {
                 //
                  var pos_chefe = m_id_value.search(/outro/i);
                  if( pos_chefe!=-1 ) {
                        var copiar="NAO";
                  } else {
                      //
                      // Alterado e m 20180703
                      // var m_id_value = trim(document.getElementById(m_id_name).value);
                      m_erro=0;
                      /***                          
                      if( m_id_value.length<1 )  {
                            m_erro=1;                          
                      }
                      ***/                      
                  } 
                  //
             }
             /**  FINAL - if( m_id_name.toUpperCase()=="CHEFE" ) {  */   
             //
             //  Caso escolheu OUTRO CHEFE
             if( m_id_name.toUpperCase()=="NOVO_CHEFE" ) {
                  //
                  // Verificando a tag SELECT do chefe
                  if( document.getElementById("chefe") ) {
                         var valor_chefe=document.getElementById("chefe").value;
                         var pos_chefe = valor_chefe.search(/outro/i);
                         m_erro=0;
                         if( pos_chefe==-1 ) {
                              var copiar="NAO";
                         } else {
                              var copiar="SIM";
                         }  
                  }
                  //
             }
             /**  FINAL -  if( m_id_name.toUpperCase()=="NOVO_CHEFE" ) {  */
             //
             //  IF quando encontrado Erro
             //  Quando for campo sem title passar sem erro
             if( m_id_title.length<1 ) m_erro=0;
         
   /**   
       alert("LINHA/405  -->>  m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+"  -- m_id_type = "+m_id_type)
      */
             
             //  Final da verificacao do campo data final
             if( parseInt(m_erro)==1 ) {
                 //
                 //   document.getElementById("label_msg_erro").style.display="block";
                 //   document.getElementById("msg_erro").style.display="block";
                 //     document.getElementById("msg_erro").innerHTML="";
                 var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
                 msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
                 var final_msg_erro = "&nbsp;</span></span>";
                 m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                 msg_erro = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                 //
                 //  document.getElementById("msg_erro").innerHTML=msg_erro;    
                 //  Ativando ID label_msg_erro
                 exoc("label_msg_erro",1,msg_erro); 
                 //
                 //  document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                 //  frm.m_id_name.focus();
                 //   document.getElementById(m_id_name).focus();
                 break;
                 //
             }
             /**  Final - if( parseInt(m_erro)==1 ) {  */
             //
             //             
             // Adiconar dados 
             if( copiar=="SIM" ) {
                  campo_nome+=m_id_name+",";  
                  campo_value+=m_id_value+",";
             }
             //
             if( m_id_name.toUpperCase()=="ENVIAR" )  break;
             //   
         } 
         //  FINAL - for( i=0; i<m_elements_total; i++ )
         //
         //  document.form.elements[i].disabled=true; 
         if( parseInt(m_erro)==1 ) {
              return false;
         } else {
             //
             //  Enviando os dados dos campos para o AJAX
             if( typeof m_value_coresponsaveis=="undefined" ) var m_value_coresponsaveis=0;
             if( parseInt(m_value_coresponsaveis)>0 ) {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);
                 poststr += "&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);
                 poststr += "&m_array="+encodeURIComponent(n_coresponsaveis);                 
             }  else {
                 var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);
                 poststr += "&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);             
             }
             //
         }     
         //   
             
    /**
       alert(" pessoal_cadastrar_js.php/490  --- \\\\   FINAL FOR  source = "+source+" ///// \r\n poststr = "+poststr);      
       */
    
         
    } 
    /**  Final - if( opcao=="SUBMETER" ) {  */
    //
    /**
     *     Criando a classe de conexao AJAX  
     */
    var myConn = new XHConn();
    //
    /**  Alerta verificando inclusao da biblioteca - AJAX   
    *   IMPORTANTE: descobrir erros nos comandos - try e catch 
    */
    // 
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
    /**       Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
     *    ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    */  
    var receber_dados = "pessoal_cadastrar_ajax.php";
    //
    
/**
 *   alert(" pessoal_cadastrar_js.php/407 -  source = "+opcao+" -- val = "+val+"  \r\n\r poststr = "+poststr); 
 */




   
     //  function para - Inicio do recebimento de dados do AJAX
     var inclusao = function (oXML) { 
                       //
                       //  Recebendo os dados do arquivo AJAX
                       /**  Importante ter trim no  oXML.responseText para tirar os espacos  */
                       var m_dados_recebidos = trim(oXML.responseText);
                       var pos = m_dados_recebidos.search(/ERRO:|FALHA:/ui);
                       
/**
 *    alert("pessoal_cadastrar_js/566  -->>  inclusao  pos = "+pos+"  -->>   \r\n m_dados_recebidos = "+m_dados_recebidos);              
 */
 

                       
                       if( pos!=-1 ) {
                           //
                           // Mensagem de erro ativar
                           //
                           var delay=3000; /// 3 segundos
                           setTimeout(function() {
                                /**
                                *   O codigo para ser executado depois de  3 segundos 
                                *    Mensagem de erro ativar e receber informacao
                                */
                                exoc("label_msg_erro",1,m_dados_recebidos);
                                //
                           },delay);
                           //
                           /**  
                           *    document.getElementById('label_msg_erro').style.display="block";
                           *    document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                           */
                           return;
                           //
                       }
                       /**  Final - if( pos!=-1 ) {  */
                       //                         
                       if( opcao=="NOVO_CHEFE" ) {
                            //
                            /**    alert(" pessoal_cadastrar_js.php/552  --  m_dados_recebidos =  "+m_dados_recebidos);  */
                            /**
                              if( document.getElementById("pagina") ) {
                                  document.getElementById("pagina").innerHTML=m_dados_recebidos;
                              }
                              */
                            /// Enviando tag Select para DIV ID pagina
                             exoc("pagina",1,m_dados_recebidos);  
                             return;
                             //
                       } 
                       /**  Final - if( opcao=="NOVO_CHEFE" ) {  */
                       //
                       // 
                       if( opcao=="CONJUNTO" ) { 
                             ///
                             m_elementos = "instituicao|unidade|depto|setor|bloco|salatipo|sala";
                             var new_elements = m_elementos.split("|");
                             //
                             
       /**                
          alert("pessoal_cadastrar_js/599  -->> new_elements = "+new_elements+"  -->> opcao = "+opcao
             +" -->> cpo_ant = "+cpo_ant+"   \r\n m_dados_recebidos = "+m_dados_recebidos);             
          */             
                             
                             
                             
                             /**  document.getElementById("label_msg_erro").style.display="none";  */
                             //  Ocultando ID  
                             exoc("label_msg_erro",0,""); 
                             ///
                             if( typeof cpo_ant!='undefined' ) {
                                   //
                                   if( cpo_ant.toUpperCase()=="INSTITUICAO" ) {
                                         limpar_campos(new_elements);
                                   }
                                   //
                             } else if( typeof cpo_ant==="undefined" ) {
                                   //
                                   // if( typeof(cpo_ant)==="undefined" ) {
                                   // if(  cpo_ant===undefined || cpo_ant===null ) {
                                   if( cpo_ant===undefined ) {                                   
                                       //
                                        if( val_upper=="OUTRA" ) {
                                             limpar_campos(new_elements);
                                             return;
                                        }
                                        //
                                   }
                                   //
                             }
                             ///  
                             /**   Verificando se tem proximo campo ou chegou no Final   */
                             var lenpcpo = prox_cpo.length;
                             
                             
       /**
          alert("pessoal_cadastrar_js/650  -->> ATENCAO  lenpcpo = "+lenpcpo+"  <<-->> new_elements = "+new_elements+"  -->> opcao = "+opcao
             +" -->> cpo_ant = "+cpo_ant+"   \r\n m_dados_recebidos = "+m_dados_recebidos);             
          */
                             
                             
                             
                             if( lenpcpo>0 ) {
                                  //
                                  //  Ativando a tag td com o campo
                                  var id_cpo = "td_"+prox_cpo;
                                  if( document.getElementById("tab_de_bens") ) {
                                      document.getElementById("tab_de_bens").innerHTML= "";    
                                  }
                                  //
                                  var lsinstituicao = m_dados_recebidos.search(/Instituição/ui);  
                                  var pos = m_dados_recebidos.search(/Nenhum|Erro/ui);   
                                  //
                                    
  /**                       
          alert("pessoal_cadastrar_js/668  -->>  pos = "+pos+"  <<-->> new_elements = "+new_elements+"  -->> opcao = "+opcao
             +" -->> lsinstituicao = "+lsinstituicao+"  <<-- cpo_ant = "+cpo_ant+"   \r\n m_dados_recebidos = "+m_dados_recebidos);             
     */                  
                                    
                                    
                                  if( pos != -1 )  {
                                       //
                                       // if( lsinstituicao==-1 )  {
                                       // Limpar elementos campos
                                       //    limpar_campos(new_elements);
                                       //
                                       // Voltar para o inicio da tag Select
                                       /**
                                       *  if( document.getElementById('instituicao') ) {
                                       *       document.getElementById('instituicao').options[0].selected=true;
                                       *       document.getElementById('instituicao').options[0].selectedIndex=0;
                                       *   }
                                       */
                                       //
                                       /**  Desativando div ID  outros_campos e tab_de_bens  */
                                       var idcposary = ["instituicao","unidade","depto","setor","bloco","salatipo","sala"];
                                       var idcposaryln = idcposary.length;
                                       //
                                       /**  Primeiro elemento valor   */
                                       var prielmv = m_array[0]; 
                                       //
                                       //  Buscar elemento
                                       var elementoBuscar = prielmv;
                                       let indice = idcposary.indexOf(elementoBuscar);
                                       //
                                       if( indice !== -1) {
                                             //
                                             if( idcposary.slice(indice+1) ) {
                                                  //
                                                  var xarr = idcposary.slice(indice+1);
                                                  var lenarr = xarr.length;
                                                  var list="";
                                                  for( var zx=0;zx<lenarr;zx++ ) {
                                                         var cpoids =  xarr[zx];
                                                         //
                                                         if( document.getElementById(cpoids) ) {
                                                             //
                                                             var lcelem=document.getElementById(cpoids);
                                                             var tdisp =  lcelem.style.display;
                                                             if( tdisp!="none" ) {
                                                                 lcelem.style.display="none";   
                                                             }
                                                             //
                                                         }
                                                         //
                                                  }
                                                  /**  Final - for( var zx=0;zx<lenarr;zx++ ) {  */
                                                  //
                                             } 
                                             /**  Final - if( idcposary.slice(indice+1) ) {  */
                                             //
                                             /**  Final - if( idcposary.slice(0,indice+1) ) {  */
                                             //
                                       }
                                       /**   Final - if( indice !== -1) {  */
                                       //
                                       /** Segunda posicao do cpo_ant no array - m_array  */
                                       var z=0;
                                       var ttlen = new_elements.length;
                                       //
                                       // Voltar para o inicio da tag Select
                                       /**
                                       *    document.getElementById('instituicao').options[0].selected=true;
                                       *    document.getElementById('instituicao').options[0].selectedIndex=0;
                                       */
                                       //
                                       // Mensagem de erro ativar
                                       //  exoc("label_msg_erro",1,m_dados_recebidos);   
                                       //
                                       mensg_erro(m_dados_recebidos,"label_msg_erro");
                                       //
                                       //  document.getElementById('instituicao').focus();
                                       //
                                       return;
                                        // 
                                  } else if( pos == -1 ) {
                                       //
                                       if( n_sel_opc<=m_array_length ) {
                                             document.getElementById(id_cpo).style.display="block";
                                             document.getElementById(id_cpo).innerHTML=m_dados_recebidos;
                                       }
                                       //
                                  }
                                  //
                             }
                             /**  Final - if( lenpcpo>0 ) {  */
                             //
                       } else if(opcao=="SUBMETER") {
                            //
                            if( val_upper=="PESSOAL" ) {
                                 //
                                 // Enviando tag Select para DIV ID pagina
                                 exoc("label_msg_erro",1,m_dados_recebidos);                                  
                                 ///
                                 ///  Retornar depois de cadastrado
                                 if( document.getElementById("div_form") ) {
                                     //
                                       var parent = document.getElementById("div_form");                                     
                                       ///  Desativar FORM
                                       if( document.getElementById("form1") ) {
                                            var child = document.getElementById("form1");
                                            parent.removeChild(child);                                          
                                       }
                                       ///
                                       /** NOW CREATE AN INPUT BOX TYPE BUTTON USING createElement() METHOD.  */
                                        var button = document.createElement('input');
                                        //
                                        // SET INPUT ATTRIBUTE 'type' AND 'value'.
                                        button.setAttribute('type', 'button');
                                        button.setAttribute('value', 'Retornar');
                                        button.setAttribute('class', 'botao3d');
                                   ////     button.setAttribute('style', 'margin-left: 50%; margin-right: 50%;');
                                        button.setAttribute('style', 'float: left: ');
                                        button.setAttribute('id', 'retornapagina');

                                        // ADD THE BUTTON's 'onclick' EVENT.
                                        /***
                                        var site='location.assign("http://sol.fmrp.usp.br")';
                                        button.setAttribute('onclick', site);
                                        ***/
                                        ///  var site="location.assign(pagina_local)";
                                        //// var site='location.assign("http://sol.fmrp.usp.br/rexp/mobile/cadastrar/pessoal_cadastrar.php")';
                                        ///  button.setAttribute('onclick', retornar_pagina(pagina_local));                                        
                                        
                                        // FINALLY ADD THE NEWLY CREATED TABLE AND BUTTON TO THE BODY.
                                       ///   document.body.appendChild(button);
                                        parent.appendChild(button);
                                        ///   Desse modo deu certo
                                        document.getElementById("retornapagina").onclick = function() { retornar_pagina(pagina_local);};
                                        ///
                                 }
                                 ///
                            }
                            /**  Final - if( val_upper=="PESSOAL" ) {  */
                            ///
                       }
                       // Final -  if( opcao=="CONJUNTO" ) 
                       //
 
           }; 
            /** 
               aqui é enviado mesmo para pagina receber.php 
               usando metodo post, + as variaveis, valores e a funcao   
            */
          var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
           /**  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
             porisso eu coloquei return false no form o php enviar sozinho                  
          */ 
       
}  
/**  FINAL da Function enviar_dados_cad para AJAX  */
//
/**
*     Function para o Donwload/Carregar  do Servidor para o Local
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
 //
//  Funcao para alinhar o campo
function alinhar_texto(id,valor) {
     var id_valor = document.getElementById(id).value;
     document.getElementById(id).value=trim(id_valor);
     return;
}
/**  Final - function alinhar_texto(id,valor) {  */
//
//   Nr. de coautores - enviar para cria-los
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
    //
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
///
/****    Retornar pagina   *****/
function retornar_pagina(pagina_local) {
    /// Retornando 
    /// setTimeout(location.assign(pagina_local,99999999)   );    
    location.href=pagina_local;
}
/****  Final -  Retornar pagina   *****/
//
/** VERIFICA SE DATA FINAL É MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)  */
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

	if( datInicio<=datFim ) {
		 /// alert('Cadastro Completo!');
		 m_erro = 0;
		 return m_erro;
		 ///  return true;
	} else {
		  alert('ATEN??O: Data Inicial é MAIOR que Data Final');
          /*
		  document.getElementById("label_msg_erro").style.display="block";
     	  document.getElementById("label_msg_erro").innerHTML="";
          */
 	      msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
		   final_msg_erro = '</span></p>';
    	  msg_erro = msg_erro+'Data Inicial é MAIOR que Data Final'+final_msg_erro;
		  ///  document.getElementById("label_msg_erro").innerHTML=msg_erro;
          /// Mensagem de erro ativar
          exoc("label_msg_erro",1,msg_erro);   
    	 ///  document.getElementById(dtini_nome).focus();	
 	      m_erro = 1;
	      ///	 return m_erro;
   }	
   //
}
//
/**
*       Funcao para incluir arquivo do Javascript
*/
function include_arq(arquivo){
    //  By Anônimo e Micox - http://elmicox.blogspot.com
    var novo = document.createElement("<script>");
    novo.setAttribute('type', 'text/javascript');
    novo.setAttribute('src', arquivo);
    document.getElementsByTagName('body')[0].appendChild(novo);
    // document.getElementsByTagName('head')[0].appendChild(novo);
    // apos a linha acima o navegador inicia o carregamento do arquivo
    // portanto aguarde um pouco até o navegador baixá-lo. :)
}
//
//  Limpar os campos do opcao=="CONJUNTO"
function limpar_campos(new_elements) {
		/**
        *  Método slice
		*    Obtém uma seleção de elementos de um array.
        */  
		var m_elems = new_elements.slice(1,new_elements.length);
      	for( x=0; x<m_elems.length; x++ ) {
		      var limpar_cpo = "td_"+m_elems[x];
              if( document.getElementById(limpar_cpo) ) {
                  var lcelem=document.getElementById(limpar_cpo);
                  var tdisp =  lcelem.style.display;
                  if( tdisp!="none" ) {
                       lcelem.style.display="none";   
                  }
                  ///
              }
              //
           /**  document.getElementById(limpar_cpo).style.display="none";  */
              //
    	}								     		 
        /**  Final - for( x=0; x<m_elems.length; x++ ) {  */
        //
}
/**  Final - function limpar_campos(new_elements) {  */
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
////
</script>