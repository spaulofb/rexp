<?php
/*** 
*      Verificando conexao CADASTRAR PROJETO  js
*           Alterado em  20250411
*/
///  Verificando se SESSION_START - ativado ou desativado  
if( !isset($_SESSION)) {
     session_start();
}
////
$php_errormsg='';
///
///  Verificando caminho http e pasta principal
if( isset($_SESSION["url_central"]) ) {
     $http_host = @trim($_SESSION["url_central"]);     
} else {
    //
    $xmsg="<p style='background-color: #000000;color:#FFFFFF;font-size:large;'>";
    $xmsg.="ERRO: grave falha na session url_central. Contato com Administrador.</p>";
    echo "$xmsg";
    exit();
}
///
if( ! empty($php_errormsg) ) {
    $http_host="../";
}
////
?>
<script language="JavaScript" type="text/javascript">
/**  
*       JavaScript Document
*       Cadastro de PROJETO                      
*   Definindo as  variaveis globais  -  20250331
*       Define o caminho HTTP
*/  
var raiz_central="<?php echo  $_SESSION["url_central"];?>";       
//
//   Pasta principal
var pasta_raiz ="<?php echo $_SESSION["pasta_raiz"];?>"; 
///
charset="utf-8";
///
///  variavel quando ocorrer Erros ou apenas enviar mensagem
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var  msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
/******  Final -  variavel quando ocorrer Erros ou apenas enviar mensagem  ****/
///
///   funcrion acentuarAlerts
/// Criando a function  acentuarAlerts(mensagem)
function acentuarAlerts(mensagem) {
        //
        //  Paulo Tolentino
        /**  Usar dessa forma: alert(acentuarAlerts('teste de acentuação, essência, carência, âê.'));  */
        //
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
/********   Final  -  Criando a function  acentuarAlerts(mensagem)  ******/
///
///  Enviando dados para AJAX
function enviar_dados_cad(source,val,m_array) {
    //
    // Verificando se a function exoc existe 
    if( typeof exoc=="function" ) {
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
    ///
    if( typeof(val)=="string" ) {
         //
         // Variavel com letras maiusculas
         var val_upper=val.toUpperCase();
         //
         /// IMPORTANTE: para retirar os acentos da palavra
         //
         //  var val=retira_acentos(val);
         var val_sem_acentos=retira_acentos(val);
         var val=val_sem_acentos;
         //
         ///  Retirando acentos
         var  mlength=val.length;
         //
         for( i=0; i<mlength-1; i++  ) {
               //
               // Removendo acento
               val = val.replace(/[âáàã]/,"a");
               val = val.replace(/[éèê]/,"e");
               val = val.replace(/[íìî]/,"i");
               val = val.replace(/[ôõóò]/,"o");
               val = val.replace(/[úùû]/,"u");
               val = val.replace("ç","c");
               val = val.replace(" ","-");    
               ///
         }
         /**  Final - for( i=0; i<mlength-1; i++  ) {  */
         //
         // Variavel com letras minusculas
         var val_lower=val.toLowerCase();
         // 
    } 
    /**  Final - if( typeof(val)=="string" ) {  */
    //
    // Verifica se a variavel e uma string
    var source_array_pra_string="";  
    if( typeof(source)=='string' ) {
         //
        //  source = trim(string_array);
        //  string.replace - Melhor forma para eliminiar espa?os no comeco e final da String/Variavel
        source = source.replace(/^\s+|\s+$/g,"");        
        //
        // IMPORTANTE: para retirar os acentos da palavra
        var source_sem_acentos=retira_acentos(source);
        // 
        var source=source_sem_acentos;
        //  Retirando acentos
        var  mlength=source.length;
        //
        for( i=0;  i<mlength-1;  i++  ) {
             //
             /// Removendo acento
             source = source.replace(/[âáàã]/,"a");
             source = source.replace(/[éèê]/,"e");
             source = source.replace(/[íìî]/,"i");
             source = source.replace(/[ôõóò]/,"o");
             source = source.replace(/[úùû]/,"u");
             source = source.replace("ç","c");
             source = source.replace(" ","-");    
             //
        }
        /**   Final - for(  i=0;  i<mlength-1;  i++  ) {  */
        ///
        var pos = source.indexOf(",");     
        if( pos!=-1 ) {  
            //
            //  Criando um Array 
            var array_source = source.split(",");
            var teste_cadastro = array_source[1];
            var  pos = teste_cadastro.search("incluid");
        }
        ///
    } else if( typeof(source)=='number' && isFinite(source) )  {
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
     
    ///  Variavel com letras minusculas
    var subcaminho = source.toLowerCase();

    /// IMPORTANTE: para retirar os acentos da palavra
    ////  var source_sem_acentos=retira_acentos(source_maiusc);

    /// IMPORTANTE: para retirar os acentos da palavra         
    //// var val_sem_acentos=retira_acentos(val);  
    //// var val=val_sem_acentos;
    
    /// Veriaveis para enviar mensagem de erro
//    var msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
//    msg_erro += "<span style='color: #FF0000;'>ERRO:&nbsp;";
//    var final_msg_erro = "&nbsp;</span></span>";
    //
    var opcao = source.toUpperCase();
    //
     
/**  
 alert(" projeto_cadastrar_js/243  -->>  INICIO    --->> opcao = "+opcao
         +"  -->> (1) - source = "+source+"  -- (2)  val = "+val+"  -- (3)  m_array = "+m_array);                  
   */
   
     
     /*****    
     *   Reiniciar a pagina atual 
     *     - utilizar a variavel paginal_local
     */
     if( opcao=="RESET" ) {
        //
        // parent.location.href=pagina_local;                
        parent.location.reload(); 
        //
        return;   
         //
     }
     ///      
     ///  Iniciando switch variavel opcao
    switch (opcao) {
        case "CORESPONSAVEIS":        
             ///
            var val = document.getElementById(source).value;
            var id_inc_pe = "incluindo_"+source;
            if( val<1 ) {
                //
                //  exoc("incluindo_coautores",0);
                //
                var m_tit_cpo = "Digitar número de Corresponsáveis caso tenha.";
                msg_erro = msg_ok_ini+m_tit_cpo+final_msg_ini;
                //
                // Mensagem de erro enviar
                exoc("label_msg_erro",1,msg_erro); 
                //
                exoc(id_inc_pe,0);
                return;
            } else {
                 exoc(id_inc_pe,1);
            }
            var m_array="";
            var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val);   
            //
            break;
        case "SUBMETER": 
             /**  
             *   INICIANDO O SUBMIT TERMINO DO FORM
             */
             ///  Desativar mensagem de erro
             //
             exoc("label_msg_erro",0);  
             //
             if( document.getElementById("form1") ) {
                  var frm = document.getElementById("form1");
             } else {
                 //
                  var frm = m_array;    
             }
             var elmstt = frm.length; 
             ///
             /**  VERIFICAR AS DATAS - INICIAL E FINAL DO PROJETO  */
             var array_data = []; /// Iniciando Array de datas
             var num_data=0;
             for( wq=0; wq<elmstt; wq++ ) {
                   //
                  if( frm.elements[wq].type ) {
                      /**  Tipo do elemento  */ 
                      var m_id_type = frm.elements[wq].type;      
                      //
                  }
                  /**  Final - if( frm.elements[wq].type ) {  */
                  //
                  //
                  if( m_id_type.toUpperCase()=="DATE" ) {
                       //
                       if( ! frm.elements[wq].id ) {
                           //
                            var mensag_erro="ERRO: Faltando ID no elemento DATA. Corrigir.";
                            //
                            alert(mensag_erro);
                            //
                            ///  Enviando a mensagem de erro 
                            exoc("label_msg_erro",1,mensag_erro);  
                            return;
                       }
                       var m_id_id = frm.elements[wq].id;
                       array_data[num_data]=m_id_id;
                       ++num_data;
                       ////
                  }
                  //
             } 
             /**  Final - for( wq=0; wq<elmstt; wq++ ) {  */
             //   
             /**    Verificar se esta faltando DATA 
             *       - Inicial ou a Final do Projeto
             */
             var total_de_datas=array_data.length;
             if( parseInt(total_de_datas)<2 ) {
                   //
                   var mensag_erro="ERRO: Faltando DATA - Inicial ou a Final do Projeto.  Corrigir.";    
                   //
                   alert(mensag_erro);
                   //
                   //  Enviando a mensagem de erro 
                   exoc("label_msg_erro",1,mensag_erro);  
                   return;
                   //
             }
             /**  Final - if( parseInt(total_de_datas)<2 ) {  */
             //
             if( parseInt(total_de_datas)>2 ) {
                  //
                  var mensag_erro="ERRO: Existem DATAS além das datas: Inicial e a Final do Projeto.  Corrigir.";    
                  alert(mensag_erro);
                  //  Enviando a mensagem de erro 
                  exoc("label_msg_erro",1,mensag_erro);  
                  //
                  return;
                  //
             }
             /**  Final - if( parseInt(total_de_datas)>2 ) {  **/
             //
             //  Caso somente as datas Inicial e Final estejam no FORM
             var nerro_datas=0;             
             if( parseInt(total_de_datas)==2 ) {
                 var data_nome=[];
                 var data_valor=[];
                 for( zx=0; zx<array_data.length; zx++ ) {
                      //
                      var m_id_name=array_data[zx];
                      var m_id_value = trim(document.getElementById(m_id_name).value);
                      // 
                      var m_erro = validatedate(m_id_value,m_id_name);
                      if( typeof m_erro=="undefined" ) var m_erro=0; 
                      //

/**  
  alert("LINHA387  -->>  "+zx+"  -->>>> m_erro = "+m_erro+" -->>  m_id_name =  "+m_id_name+" - "+m_id_value);
    */
   
                      // 
                      if( m_erro===false ) {
                           //
                           /**   Preparando para enviar a mensagem de erro e retornar  */
                           var m_id_title="Data formato inválido!";
                           if( document.getElementById(m_id_name).title ) {
                                var m_id_title=document.getElementById(m_id_name).title;
                           }
                           //
                           m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                           //
                           /**
                           *  msg_erro_ini = msg_erro+'&nbsp;Corrigir campo.'+m_tit_cpo+final_msg_erro;
                           *  msg_erro_ini
                           */
                           msg_erro = msg_ok_ini+m_tit_cpo+final_msg_ini;
                           //
                           // Mensagem de erro enviar
                           //  exoc("label_msg_erro",1,msg_erro); 
                           exoc("label_msg_erro",1,msg_erro); 
                           //
                           if( document.getElementById("enviar") ) {
                               document.getElementById("enviar").style.disabled=true;                                    
                           }
                           //  
                           document.getElementById(m_id_name).focus();
                           //
                           return;
                           //
                      }
                      /**  Final - if( m_erro===false ) {  */
                      //
                      data_nome[zx]=m_id_name;                                                 
                      data_valor[zx]=m_id_value;
                      ///    
                 }
                 /**  Final - for( zx=0; zx<array_data.length; zx++ ) {  */
                 //
                 /**   Mesclar dois Arrays  DATAS Inicio e Final  -  alterado 20180621  */ 
                 var dts_nomes_valores=data_nome.concat(data_valor);
                 //
                 ////  Compando as datas - Incial com a data Final
                 ///   var  nerro = verificadatas(dts_nomes_valores); 
                 var dts_n_v2 = dts_nomes_valores[2];
                 var dts_n_v3 = dts_nomes_valores[3];
                 //
                 //  Caso campo da Data Final vazia
                 var nerro_datas=false;
                 if( dts_n_v3.length>9 ) {
                      //
                      var nerro_datas = verificadatas(dts_nomes_valores[0],dts_nomes_valores[1],dts_n_v2,dts_n_v3); 
                      //
                      //  Caso deu erro
                      if( typeof nerro_datas=="undefined" ) var nerro_datas=false;    
                      //

               //    alert(" nerro_datas = "+nerro_datas);

                      if( parseInt(nerro_datas)>0 ) {
                           return false;
                      }
                      //  
                 }
                 /**  Final - if( dts_n_v3.length>9 ) {  */
                 //                 
             }    
             /**  FINAL - VERIFICAR AS DATAS - INICIAL E FINAL DO PROJETO   */
             //
             var m_erro = 0; 
             var n_coresponsaveis= new Array(); 
             var n_i_coautor=0;   
             var n_datas=0; 
             var arr_dt_nome = new Array(); 
             var arr_dt_val = new Array();
             var campo_nome="";   
             var campo_value=""; 
             var m_id_value="";
             //
             for( i=0; i<elmstt; i++ ) {      
                  //
                  //  Passando para variavel - nome,tipo,titulo (title tem que ter no campo)
                  var m_id_name = frm.elements[i].name;
                  var m_id_type = frm.elements[i].type;
                  var m_id_title = frm.elements[i].title;
                  //
                  var m_id_value = "";
                  //
                  switch (m_id_type) {
                       case "undefined":
                       case "image":
                       case "reset":
                       case "button":   
                           if( m_id_name.toUpperCase()=="ENVIAR") {
                               break;
                           } else {
                               continue;
                           }
                       case "checkbox": 
                            if( ! elements[i].checked ) var m_erro = 1;
                            break;
                       case "date":
                            //
                            m_id_value = trim(document.getElementById(m_id_name).value);
                            var m_erro = 0; 
                            m_erro = validatedate(m_id_value,m_id_name);
                            if( typeof m_erro=="undefined" ) var m_erro=0; 
                            //
                            if( m_erro===false ) {
                                /// if( ! m_erro ) {
                                var m_erro=1;  
                            } else if( m_erro ) {
                                 var m_erro=0;  
                            }    
                            break;
                       case "hidden":                                              
                       case "number":
                           m_id_value = trim(document.getElementById(m_id_name).value);
                           if( m_id_type=="number") {
                                if( m_id_value.length<1 ) m_id_value=0; 
                           }
                           break;
                           //
                       case "text":
                           //
                           m_id_value = trim(document.getElementById(m_id_name).value);
                           //  if( m_id_value=="" && m_id_name.toUpperCase()=="TITULO") {
                           if( m_id_value=="" ) {
                               //
                               var position = m_id_name.search(/^TITULO$|^fonterec$/ui);
                               //
                               if( position!=-1 ) {
                                   var m_erro = 1;   
                               }
                               /**  Final - if( ptf!=-1 ) {  */
                               //
                           }
                           /**  Final - if( m_id_value=="" ) {  */
                           //
                           /**
                                if( m_id_name.toUpperCase()=="CORESPONSAVEIS" ) {
                                      var confirm_text = "Co-Responsáveis";
                                }
                           */
                           break;
                       case "textarea":
                           //
                           m_id_value = trim(document.getElementById(m_id_name).value);
                           //
                           if( m_id_value==""  && m_id_name.toUpperCase()=="TITULO") {
                                  var m_erro = 1;
                           }    
                           break;              
                       case "select-one":
                           m_id_value = trim(document.getElementById(m_id_name).value);
                           if( m_id_value=="" ) {
                                 var m_erro = 1;
                           }
                           break;
                       case "file":
                           m_id_value = trim(document.getElementById(m_id_name).value);
                           if( m_id_value==""  ) {
                                var m_erro = 1;    
                           } else {
                               var tres_caracteres = m_id_value.substr(-3);  
                               var pos = tres_caracteres.search(/pdf/i);
                               //
                               /// Verificando se o arquivo formato pdf
                              if( pos==-1 ) {
                                   m_erro=1; m_id_title="Arquivo requerido deve estar no formato PDF.";
                              }
                           }
                           break;
                
                  }      
                  /**  Final - switch (m_id_type) {  */
                  //
                  //  Verificando os coautores ou colaboradores
                  var pos = m_id_name.search(/ncoautor/i);
                  if( pos!=-1 ) {
                       m_id_value = trim(document.getElementById(m_id_name).value);
                       n_coresponsaveis[n_i_coautor]=m_id_value;
                       n_i_coautor++;
                  }
                  //
                  //  Botao ENVIAR
                  if( m_id_name.toUpperCase()=="ENVIAR" ) {
                      //
                      if( parseInt(n_i_coautor)>1 ) {
                          //
                            ///  Verifica se existe duplicata
                           var duplicado = 0;
                           var sortedarray=n_coresponsaveis.sort(); 
                           for( k=0; k < (n_i_coautor-1); k++ ) { 
                                if( sortedarray[k]==sortedarray[k+1] ) {
                                    duplicado=1; 
                                     m_id_title="Duplicado: código "+sortedarray[k]; 
                                     m_erro=1;                                    
                                     break;
                                }
                                //                                 
                           }
                           /**  Final - for( k=0; k < (n_i_coautor-1); k++ ) {   */
                           //
                      }
                      /**  Final - if( parseInt(n_i_coautor)>1 ) {  */
                      //
                  }
                  ///  IF quando encontrado Erro
                  ///  Quando for campo sem title passar sem erro
                 if( m_id_title.length<1 ) m_erro=0;
                 
                 ///  Verificando a data  FINAL
                 ///   var m_datas = /(datafinal|datafin|data_fin)/i;
                 var posdatas = m_id_name.search(/datafinal|datafin|data_fin/i);            
                 //
                 //  if( m_datas.test(m_id_name) )  {
                 if( posdatas!=-1 )  {
                     if( m_id_value=="" ) m_erro=0;    
                 } 
                 /**  Final da verificacao do campo data final  */
                 //
                 ///  Verificando se houve ERRO
                 if( parseInt(m_erro)==1 ) {
                      //
                      /**   Preparando para enviar a mensagem de erro e retornar   */ 
                      m_tit_cpo = "<span style='color: #000000;'>&nbsp;&nbsp;"+m_id_title+"</span>";
                      /**
                       *   msg_erro = msg_erro_ini+"&nbsp;Corrigir campo."+m_tit_cpo+final_msg_ini;
                      */
                      //
                      msg_erro = msg_ok_ini+m_tit_cpo+final_msg_ini;
                      //
                      /**
                       *         Enviar a mensagem de ERRO  
                       *    document.getElementById("label_msg_erro").innerHTML=msg_erro;    
                      */
                      //  Mensagem de erro ativar
                      exoc("label_msg_erro",1,msg_erro);   
                      //
                      ///  frm.m_id_name.focus();
                      document.getElementById(m_id_name).focus();
                      //
                      //  alert("Corrigir: "+m_id_title);  
                      //
                      return;
                      //
                 }
                 /**  Final - if( parseInt(m_erro)==1 ) {  */
                 ///

                  
      // alert(i+") 634 m_id_name = "+m_id_name+" -- m_id_value = "+m_id_value);       


                 /**   Nomes e Valores dos campos da Tabela   */
                if( i<elmstt ) {
                    campo_nome+=m_id_name+",";  
                    campo_value+=m_id_value+",";
                } else {
                    campo_nome+=m_id_name;  
                    campo_value+=m_id_value;
                }
                 //
                 
                 
   /**
   var testecponv = campo_nome+"\r\n  "+campo_value;
   alert("LINHA 526 -->> m_id_name = "+m_id_name+" - m_id_value = "+m_id_value+" -  m_id_type = "
           +m_id_type+" - m_erro = "+m_erro+"\r\n\r\n"+testecponv);
           */

                  


             }  
             /**  Final - for( i=0; i<elmstt; i++ ) {   */
             //
             ///  document.form.elements[i].disabled=true; 
             if( m_erro==1 ) {
                 return false;
             } else {
                //
                ///  Enviando os dados dos campos para o AJAX
                if( parseInt(n_i_coautor)>0 ) {
                      var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value)+"&m_array="+encodeURIComponent(n_coresponsaveis);                 
                } else {
                      var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&campo_nome="+encodeURIComponent(campo_nome)+"&campo_value="+encodeURIComponent(campo_value);             
                }
             }
             /// 
         
  /**
   alert(" LINHA/536  -->> poststr = "+poststr);             
   */
             
             
              ///
             break;  
    }         
    ///  Final - switch (opcao) {
  
    /*   Aqui eu chamo a class do AJAX */
    var myConn = new XHConn();
        
    /*  Um alerta informando da não inclusão da biblioteca - AJAX   */
    if( !myConn ) {
          alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
          return false;
    }
    ////
    /****   Serve tanto para o arquivo projeto, anotacao e outros - Cadastrar
         ARQUIVO abaixo onde recebe os DADOS da PAGINA e EXECUTA os procedimentos e Retorna resultado
    ***/
    var receber_dados = raiz_central+"cadastrar/projeto_cadastrar_ajax.php";
    ///
    var inclusao = function (oXML) {
                      // 
                      //  Recebendo os dados do arquivo ajax
                      //  Importante ter trim no  oXML.responseText para tirar os espacos
                      var m_dados_recebidos = trim(oXML.responseText);
                          
                      ////  Verificando se houve ERRO
                      var pos = m_dados_recebidos.search(/ERRO:|FALHA:|Uncau|Fatal erro/ui);

 /**  
    alert(" projeto_cadastrar_js/521  -->>> INCLUSAO ->> pos = "+pos+" <--> receber_dados = "+receber_dados
        +" -  pasta_raiz = "+pasta_raiz+"  \r\n  opcao = "+opcao+" (1) - source = "+source+"  -- (2)  val = "
         +val+"  -- (3)  m_array = "+m_array);             
      */
         
                      
                      //
                      if( pos!=-1 ) {
                           //
                           /**   Caso tiver palavras de Cadastro ou Corrigir campo   */ 
                           var pnhm = m_dados_recebidos.search(/NENHUM|cadastrad(a|o){1}/ui);
                           if( pnhm!=-1 ) {
                                var m_dados_recebidos = m_dados_recebidos.replace(/ERRO:|Corrigir campo/uig,"");
                           }
                           /**  Final - if( pnhm!=-1 ) {  */
                           //
                           // Mensagem de erro ativar
                           exoc("label_msg_erro",1,m_dados_recebidos);   
                           /**
                           *    document.getElementById('label_msg_erro').style.display="block";
                           *     document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                           */
                           return;
                           //
                      }
                      /**  Final - if( pos!=-1 ) {  */
                      ///                         
                      if( ( opcao=="CORESPONSAVEIS" ) ||  ( opcao=="COLABS" ) ) {                            
                            //
                            //  document.getElementById('corpo').style.display="block";    
                            //  document.getElementById(id_inc_pe).innerHTML= oXML.responseText;
                            //   ativar ID id_inc_pe
                            exoc(id_inc_pe,1,m_dados_recebidos);                             
                            return;
                            //
                      } else if( opcao=="ANOTACAO" ) {
                            //
                            //  AUTOR/ANOTADOR E ORIENTADOR/SUPERVISOR
                            //  if( ( val.toUpperCase()=="AUTOR" ) &&  msa.length>=1 ) {
                            if( ( val.toUpperCase()=="PROJETO" ) &&  msa.length>=1 ) {
                                //
                                var pos = m_dados_recebidos.search(/ERRO:|NENHUM/i);
                                if( pos!=-1 ) {
                                    //
                                    /** Quando acontece erro ou nao existe dados  */    
                                    if( document.getElementById("novo_td") ) {
                                          //  Ocultando ID
                                          var idlme = document.getElementById("novo_td");
                                          var tdisp = idlme.style.display;
                                          if( tdisp!="none" ) {
                                                idlme.style.display="none";
                                          }
                                          //
                                          if( document.getElementById("nr_anotacao") ) {
                                              //
                                              //  Ocultando ID
                                              var idnra = document.getElementById("nr_anotacao");
                                              var dispt = idnra.style.display;
                                              if( dispt!="none" ) {
                                                   idnra.style.display="none";
                                              }
                                              //
                                          }
                                          //
                                    }
                                    /**  Final - if( document.getElementById("novo_td") ) {  */
                                    //                                    
                                    /// Enviando mensagens de ERRO
                                    exoc("label_msg_erro",1,m_dados_recebidos);
                                    ///                             
                                } else {
                                    //
                                    var array_dados = m_dados_recebidos.split("<label");                        
                                    array_dados[1]= "<label "+array_dados[1];
                                    array_dados[2]= "<label "+array_dados[2];
                                    //
                                    if( document.getElementById("nr_anotacao") ) {
                                        //
                                        var nraid = document.getElementById("nr_anotacao");
                                        var zdisp = nraid.style.display;
                                        //
                                        if( zdisp!="block" ) {
                                             nraid.style.display="block";
                                        }
                                        //
                                    }
                                    //
                                    document.getElementById("nr_anotacao").innerHTML=array_dados[1];
                                    //
                                    if( document.getElementById("sn_altera_complementa") ) {
                                        //
                                        /**
                                        *   Ativar ID sn_altera_complementa
                                        */
                                        var idsna = document.getElementById("sn_altera_complementa");
                                        var zdsp = idsna.style.display;
                                        //
                                        if( zdsp!="block" ) {
                                             idsna.style.display="block";
                                        }
                                        //
                                    }
                                    //
                                    document.getElementById("sn_altera_complementa").innerHTML=array_dados[2];  
                                    //
                                }
                                ///
                            } else if( ( val.toUpperCase()=="ALTERA_COMPLEMENTA" ) &&  msa.length>=1 ) {
                                //
                                var pos = m_dados_recebidos.search(/ERRO:/i);
                                //
                                if( document.getElementById('corpo') ) {
                                    /**
                                    *   Ativar ID sn_altera_complementa
                                    */
                                    var idcrp = document.getElementById('corpo');
                                    var zsp = idcrp.style.display;
                                    //
                                    if( zsp!="block" ) {
                                         idcrp.style.display="block";
                                    }
                                    //
                                }
                                //
                                if( pos!=-1 ) {
                                    //
                                    document.getElementById('altera_complementa').options[2].selected=true;
                                    //
                                    // Enviando mensagens de ERRO
                                    exoc("label_msg_erro",1,m_dados_recebidos);
                                    //                             
                                } else {
                                    /****
                                    *     document.getElementById("td_altera_complementa").style.display="block";
                                    *     document.getElementById("td_altera_complementa").innerHTML=m_dados_recebidos; 
                                    ****/
                                    ///   Enviando dados para ID  td_altera_complementa
                                    exoc("td_altera_complementa",1,m_dados_recebidos);
                                    ///                             
                                }
                                //
                            }
                            //
                      } else {
                          //
                          ///  Desativando ID label_msg_erro 
                          exoc("label_msg_erro",0,""); 
                          ///
                          if( opcao=="SUBMETER" ) {
                              //
                              ///  Desativando ID div_form
                              exoc("div_form",0,""); 
                              //
                              //  Recebendo o numprojeto e o num do autor
                              var test_array = m_dados_recebidos.split("falta_arquivo_pdf");
                              //
                              if( test_array.length>1 ) {
                                  //
                                  m_dados_recebidos=test_array[0];
                                  var n_co_autor = test_array[1].split("&");
                                  //
                                  ///  Passando valores para tag type hidden
                                  document.getElementById('nprojexp').value=n_co_autor[0];
                                  document.getElementById('autor_cod').value=n_co_autor[1];
                                  if( n_co_autor.length==3 ) {
                                      ///  ID da pagina anotacao_cadastrar.php
                                      document.getElementById('anotacao_numero').value=n_co_autor[2];
                                  }
                                  //
                              }
                              /**  Final - if( test_array.length>1 ) {  */
                              //
                              //  Mostrando a mensagem recebida
                              // document.getElementById('label_msg_erro').innerHTML=m_dados_recebidos;
                              exoc("label_msg_erro",1,m_dados_recebidos); 
                              //
                              // Verificar pra nao acusar erro
                              exoc("arq_link",1); 
                              //         
                          } else {
                              //
                              /// ativar ID  corpo
                              exoc("corpo",1,m_dados_recebidos);                             
                              ///
                          }
                          ///  FINAL -  if( opcao=="SUBMETER" ) {
                          //
                      } 
                      ///
      }; 
      //
      //   ENVIANDO OS DADOS DO FORM
      var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);                  
      //            
	  return;
      //
}  
/**   Final - function enviar_dados_cad(source,val,m_array) {  */
//
/**
*     Function para o Donwload/Carregar  do Servidor para o Local
*/
function download(m_id) {
    var m_id_val = document.getElementById(m_id).value;
	self.location.href='baixar.php?file='+m_id_val;
}
/**  Final - function download(m_id) {  */
//
///  Limitando o numero de caracteres no textarea
function limita_textarea(campo){
      var tamanho = document.form1[campo].value.length;
      var tex=document.form1[campo].value;
      if( tamanho>=255 ) {
          document.form1[campo].value=tex.substring(0,5);
      }
      return true;
} 
///  Funcao para alinhar o campo
function alinhar_texto(id,valor) {
    var id_valor = document.getElementById(id).value;
    document.getElementById(id).value=trim(id_valor);
    return;
}
///   Numero de coautores - enviar para cria-los
function n_coresponsaveis(field,event) {
     ///  var e = (e)? e : event;
	 var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
     var tecla = keyCode;
	 if( tecla==9  ) return;
    /*    Vamos utilizar o objeto event para identificar 
          quais teclas estão sendo pressionadas.       
          teclas 13 e 9 sao Enter e TAB
     */
    ///  Backspace
    if( tecla==8 ) return;
    
    if( !(tecla >= 48 && tecla <= 57 ) && !( tecla==13 || tecla==9 ) ) {
        //
       if( !(tecla >= 96 && tecla <= 105 )  ) {
           //
           /**   A propriedade keyCode revela o código ASCII da tecla pressionada. 
           *    Sabemos que os números de 0 a 9 estão compreendidos entre 
           *    os valores 48 e 57 da tabela referida. Então, caso os valores 
           *    não estejam(!) neste intervalo, a função retorna falso para quem
           *    a chamou.  Menos keyCode igual 13  
           */
           document.getElementById(field.id).value="";
           //
		   alert("Apenas NÚMEROS são aceitos!");
           //
		   field.focus();
           field.select();
           //
		   return false;
           //
	   }
       /**  Final - if( !(tecla >= 96 && tecla <= 105 )  ) {  */
       //
	}
    //
    if( tecla==13  || tecla==9 ) {  
         //
         alert(" ENTER OU TAB - field  = "+field +" - value = "+value+" - tecla = "+tecla)
         //
         return;
	}
    //
}
//
///  tag input type button - buscar coautores
function  buscacoresponsaveis(m_id) {
    var valor_id = document.getElementById(m_id).value;
    document.getElementById("busca_autores").disabled=true;
    if( valor_id>0 ) { 
         document.getElementById("busca_autores").disabled=false;
         document.getElementById("busca_autores").focus();
    }
}
/// Function retorna para o mesmo campo
function retornar_cpo(m_id) {
    document.getElementById(m_id).focus();
    return;
}
//
//
// VERIFICA SE DATA FINAL É MAIOR QUE INICIAL PARA USAR NO PATRIMONIO (BEM)
/**
*    Funcao para incluir arquivo do Javascript
*/
function include_arq(arquivo) {
    //
    //  By Anônimo e Micox - http://elmicox.blogspot.com
    var novo = document.createElement("<script>");
    novo.setAttribute('type', 'text/javascript');
    novo.setAttribute('src', arquivo);
    document.getElementsByTagName('body')[0].appendChild(novo);
    //
    ///  document.getElementsByTagName('head')[0].appendChild(novo);
    ///  apos a linha acima o navegador inicia o carregamento do arquivo
    //  portanto aguarde um pouco até o navegador baixá-lo. :)
    //
} 
/**  Final - function include_arq(arquivo) {  */
///
///  Limpar os campos da opcao=="CONJUNTO"
function limpar_campos(new_elements) {
	   /**      Método slice
		*    Obtém uma seleção de elementos de um array.
       */  
	   var m_elementos = new_elements.slice(1,new_elements.length);
       for( x=0; x<m_elementos.length; x++ ) {
		     var limpar_cpo = "td_"+m_elementos[x];
             document.getElementById(limpar_cpo).style.display="none";
       }  
       //								     		 
}
/**  Final - function limpar_campos(new_elements) {  */
//
function mensg_erro(dados,m_erro,array_ids) {
        ///
        if( typeof(array_ids)=="object" &&  array_ids.length ) {
        	 for( i=0; i<array_ids.length ; i++ ) {
                  document.getElementById(array_ids[i]).style.display="none";   
             }
        }
		///  Tem que ter esses  document.getElementById
        document.getElementById('label_msg_erro').style.display="block";
        document.getElementById(m_erro).innerHTML=dados;
      ///
}
/********************************************************************************************/
///
</script>