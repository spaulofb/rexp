<?php
/***
*     Verificando conexao Consultar patrimonnio/bem  - Editar     
* Atualizado em 20220525 
***/
///  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
///    SESSION Total de Registros 
if( ! isset($_SESSION["total_regs"]) ) $_SESSION["total_regs"]=0;
////
///   if( ! isset($_SESSION["tabela_salva"]) ) $_SESSION["tabela_salva"]="";
///     
?>
<script language="JavaScript" type="text/javascript">
/***
*        ATUALIZADO EM 20220525     
***/  
///  Definindo a Tabela principal    
//// var nome_tabela_id="";
var nometb="<?php echo $_SESSION["tabpri"];?>";        
///
///    Define o caminho HTTP - url_central   
var url_central = "<?php echo $_SESSION["url_central"];?>";
///
///
charset="utf-8";
///************************************************************
///
//  variavel quando ocorrer Erros
var  msg_erro_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow: auto;">';
msg_erro_ini+='ERRO:&nbsp;<span style="color: #FF0000;">';
//  variavel quando estiver Ccorreto
var msg_ok_ini='<span class="texto_normal" style="color: #000; text-align: center;overflow:auto;">';
msg_ok_ini+='<span style="color: #FF0000;">';
//
var final_msg_ini='</span></span>';
///
///  Final - variavel quando ocorrer Erros  
///
///
/****   ABAIXO  CAMPOS  DA  TABELA bem  
 * Atualizado em 20220525 
 *****/  
/// Nome da coluna  INSTITUICAO da Tabela  setor 
var  codidinst = "<?php echo $_SESSION["codidinst"];?>";  
///
/// Nome da coluna UNIDADE  da Tabela  
var  codidunid = "<?php echo $_SESSION["codidunid"];?>";  
///
/// Nome da coluna DEPTO/DEPARTAMENTO da Tabela  
var  codiddept = "<?php echo $_SESSION["codiddept"];?>";  
///
/// Nome da coluna SETOR da Tabela  
var  codidseto = "<?php echo $_SESSION["codidseto"];?>";  
///
///   funcrion acentuarAlerts - para corrigir acentuacao
/// Criando a function  acentuarAlerts(mensagem)
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
    ///
}
/********************************************************************************/
///
///
///   Incluindo Atributo
function atributo(var_nome,var_cod,var_clp,var_atributo,var_atrib_descricao) {
          ///
         ///  Verificando parametros
         if( typeof(var_nome)=="undefined" ) var_nome=""; 
         if( typeof(var_cod)=="undefined" ) var var_cod="";
         if( typeof(var_clp)=="undefined" ) var var_clp="";

         ///  Verificano o ID label_msg_erro e ocultando
         /****
         if( document.getElementById("label_msg_erro")  ) {
             if( document.getElementById("label_msg_erro").style.display="block"  ) {
                 document.getElementById("label_msg_erro").style.display="none";   
             } 
         }
         ****/
         ///  Ocultar ID  label_msg_erro 
         exoc("label_msg_erro",0);                     
         ///
         var m_valor_clp="";
         var valor1=""; 
         var valor2 = "";
         ///
         var element_value="";
         var element_length="";
         ///
         if( document.getElementById(var_clp) ) {
             m_valor_clp = document.getElementById(var_clp).value;                         
         }
         ///
         
/*****
  alert(" editar_patrimonio_js.php/43  --->> function atributo  <<- INICIO ->>  var_nome = "+var_nome+"  --  var_cod = "+var_cod+"  - var_clp = "+var_clp);
****/



         
        ///  if ( document.getElementById(var_cod).value=="INCLUIR") {
        /// if ( var_cod.toString()=="INCLUIR" ) {
        ///
        if( document.getElementById(var_atributo) ) {
            valor1=document.getElementById(var_atributo).value;    
        }
        ///
        if( document.getElementById(var_atrib_descricao) ) {
            valor2=document.getElementById(var_atrib_descricao).value;
        }
        ///  
        ///
        var var_nomeup=var_nome.toUpperCase()
        
/****         
 alert(" editar_patrimonio_js.php/172  --->> function atributo  <<-  SEGUNDA -->> var_nomeup = "+
     var_nomeup+" <br/>\r\n  var_nome = "+var_nome+"  --  var_cod = "+var_cod+"  - var_clp = "+var_clp+" -->> element_length = "+element_length+" -->> element_value = "+element_value);
****/

        
        
        if( var_nomeup=="INCLUIR" ) {
            ///
            /***  INCLUIR ATRIBUTO   ***/
            if( document.getElementById('atributo') ) {
                var elatr=document.getElementById('atributo');
                var element_value=trim(elatr.value);    
                var element_length=parseInt(elatr.value.length);
            }
            /***  Final - if( document.getElementById('atributo') ) {  ***/
            ///
            var elvallwr = trim(element_value.toLowerCase());
            ///
            if( ( element_length>1 ) && ( elvallwr!=="outro" ) ) {
                 ///
                 ///  var_atributo="atributo";
                 if( element_value!="outro" ) {
                      valor1=element_value;    
                 }
                 /***
                 *     function verificar_clp  
                 ****/
                 verificar_clp("incluir_atributo");             
                 ///
             }
             ///
        }
        ///  Final - if( var_nomeup=="INCLUIR" ) {  
        ///
        

/***         
 alert(" editar_patrimonio_js.php/172  --->> function atributo  <<-  TERCEIRA -->> var_nomeup = "+
     var_nomeup+" <br/>\r\n  var_nome = "+var_nome+"  --  var_cod = "+var_cod+"  - var_clp = "+var_clp);
***/


        ///
        if( var_nomeup=="EDITAR" ) {
            ///
            /***  EDITAR ATRIBUTO   ***/           
            if( document.getElementById("m_editar_salvar_atributo") ) {
                var m_esa=document.getElementById("m_editar_salvar_atributo");
            } else {
                ///  Ocorreu ERRO
                var msgerr="Variavel EDITAR indefinida - corrigir.";
                ///
                alert(msgerr);
                ///
                /// Mensagem de erro ativar
                exoc("label_msg_erro",1,msgerr);                                         
                ///
                return;
                ///
            }
            ////
            /***
            *  m_value_ed_sa=document.getElementById("m_editar_salvar_atributo"); 
            *    m_value_ed_sa = m_value_ed_sa.toString();
            ***/
             m_value_ed_sa = m_esa.toString();
             /////  var pos=m_value_ed_sa.search("m_edit_atributo");
             var pos=m_value_ed_sa.search(/m_edit_atributo/ui);
             ////
             ////
         ///    if( pos!=-1 ) {            
                 ///  if( m_value_ed_sa.search(/m_edit_atributo/i) != -1 ) {
                 verificar_clp("editar_atributo");
         ///    }
             /// 
        }
        ///  Final - if( var_nomeup=="EDITAR" ) {  
        ///
        if( var_nomeup=="REMOVER" ) {         
            ///
            /***  REMOVER ATRIBUTO   ***/           
            valor1=document.getElementById(var_atributo).value;
            valor2=document.getElementById(var_atrib_descricao).value;                
            ///
            var tt="Remover esse atributo?  OK/Sim ou Cancel/Não \nAtributo: ";
            m_corrigir=confirm(tt+valor1+" - Descrição: "+valor2); 
            ///
            if( m_corrigir==true ) {
                verificar_clp("remover_atributo");
            } else if( m_corrigir==false ) {
                ///
                if( document.getElementById("label_msg_erro") ) {
                     ///
                     var xlme = document.getElementById("label_msg_erro"); 
                     var tdisp =  xlme.style.display;
                     if( tdisp!="block" ) {
                          xlme.style.display="block";                         
                     }
                     ///
                }
                /// 
                ///  Mensagem de ERRO
                var msg_erro='<p class="texto_normal" style="color: #000; text-align: center;">CANCELADA:&nbsp;<span style="color: #FF0000;">';
                var final_msg_erro = '</span></p>';
                msg_erro=msg_erro+'a remoção desse atributo: '+valor1;
                msg_erro+=" - Descrição: "+valor2+final_msg_erro;
                ///
                document.getElementById("label_msg_erro").innerHTML=msg_erro;
                ///
                /// verificar_clp("remover_atributo");
                var_cod=""; var_nome="";
                ///
                return document.getElementById("label_msg_erro").focus();
                ///
            }
            ///          
        }
        ///  Final - if( var_nomeup=="REMOVER" ) { 
        ///        
        ///
         m_verificando_campos=true;
         
/***
 alert(" editar_patrimonio_js.php/326  --->> function atributo  <<- SETIMO -->>  "
     +"  -->> verificando_clp = "+verificando_clp+"   <<<---  elvallwr = "
        +elvallwr+" \r\n<br/> -->> valor1 = "+valor1+" <<-->> valor2 = "+valor2
        +"  <<<--- var_nomeup = "+var_nomeup
        +" <br/>\r\n  var_nome = "+var_nome+"  --  var_cod = "+var_cod
        +"  - var_clp = "+var_clp+"  \r\n -->> var_atributo = "+var_atributo);
****/

         
         
         if( verificando_clp ) { 
             /***
             if( document.getElementById("label_msg_erro") ) {
                  if( document.getElementById("label_msg_erro").style.display="none" ) {
                       document.getElementById("label_msg_erro").style.display="block";
                  }     
             } 
             ***/
             var msg_erro = '<p class="texto_normal" style="color: #000; text-align: center;">ERRO:&nbsp;<span style="color: #FF0000;">';
             var final_msg_erro = '</span></p>';
             ///
             /// Verificando Campo 1
             if( valor1=="" ) {
                 ///
                m_verificando_campos=false;
                var tt="ATRIBUTO N&Atilde;O INCLU&Iacute;DO FALTANDO:&nbsp;";
                tt+="Digitar atributo";
                ////
                msg_erro = msg_erro+tt+final_msg_erro;
                /// Mensagem de erro ativar
                ///  document.getElementById("label_msg_erro").innerHTML=msg_erro;                
                exoc("label_msg_erro",1,msg_erro);                                         
                ///
                if( document.getElementById(var_atributo) ) {
                     return document.getElementById(var_atributo).focus();
                }
                return;                          
                ///
             }
             /// Final - if( valor1=="" ) {  
             ///
             /// Verificando Campo 2  
             if( valor2=="" ) {
                ///
                m_verificando_campos=false;
                ///
                var tt="ATRIBUTO N&Atilde;O INCLU&Iacute;DO FALTANDO:&nbsp;";
                tt+="Digitar descri&ccedil;&atilde;o do atributo";
                ///           
                msg_erro = msg_erro+tt+final_msg_erro;
                ///
                ///    Mensagem de erro ativar
                /// document.getElementById("label_msg_erro").innerHTML=msg_erro;                
                exoc("label_msg_erro",1,msg_erro);                                         
                /// 
                if( document.getElementById(var_atributo) ) {
                    if( document.getElementById(var_atrib_descricao) ) {
                         document.getElementById(var_atrib_descricao).focus();
                    }
                }
                ///
                return;                        
                ///
             }
             ///  Final - if( valor2=="" ) { 
             ///
         } else {
              m_verificando_campos=false;
         }
         ///
         
/*****
 alert(" editar_patrimonio_js.php/326  --->> function atributo  <<- OITAVO -->>  "
        +" -->> m_verificando_campos = "+m_verificando_campos+"  <<-->> elvallwr = "
        +elvallwr+" \r\n<br/> -->> valor1 = "+valor1+" <<-->> valor2 = "+valor2
        +"  <<<--- var_nomeup = "+var_nomeup
        +" <br/>\r\n  var_nome = "+var_nome+"  --  var_cod = "+var_cod
        +"  - var_clp = "+var_clp+"  \r\n -->> var_atributo = "+var_atributo);
      return;     
****/
                  
         
         ///
         if( m_verificando_campos ) {
             ///
             ///  if ( var_cod.toString()=="INCLUIR" ) {            
             var conta_atributos=0;
             var meuarray = new Array();
             ///  var meuarray = [];
             meuarray[0]=conta_atributos; 
             meuarray[1]=m_valor_clp;
             meuarray[2]=valor1; 
             meuarray[3]=valor2;
             ///
            ///  m_var_cod = var_cod.toString();             
            /// if ( var_cod.toString()=="INCLUIR" ) { 
            if( var_nome.toUpperCase()=="INCLUIR" ) { 
                 m_var_cod="INCLUIR";
                 conta_atributos++;
                 if( conta_atributos>1 ) {
                     var marinc=document.getElementById("m_atributo_incluidos");
                     tab_incluindo_atributos= marinc.innerHTML; 
                     ///
                 }     
                 ///
                 meuarray[0]=conta_atributos;
                 meuarray[4] = "tab_incluindo_atributos";
                 meuarray[5] = "INCLUIR";
                 ///
                 /*****  enviando dados INCLUIR  pra function dochange  *****/
                 dochange("incluir_atributo",meuarray); 
                 ///
            }
            /*** Final - if( var_nome.toUpperCase()=="INCLUIR" ) {  ***/
            ///
            if( var_nome.toUpperCase()=="EDITAR" ) { 
                 meuarray[4] = "tab_editar_atributos";             
                 meuarray[5] = var_cod;
                 ///
                 /*** enviando dados EDITAR pra function dochange  ***/
                 dochange("editar_atributo",meuarray);
                 ///
            }
            /***  Final - if( var_nome.toUpperCase()=="EDITAR" ) {  ***/
            ///
            if( var_nome.toUpperCase()=="REMOVER" ) { 
                 meuarray[4] = "tab_remover_atributos";             
                 meuarray[5] = var_cod;
                 ///
                 /*** enviando dados REMOVER pra function dochange  ***/
                 dochange("remover_atributo",meuarray);
                 ///
            }
            /***  Final - if( var_nome.toUpperCase()=="REMOVER" ) {  ***/
            ///             
         }
         ///  Final - if( m_verificando_campos ) {  
         ///
         return;
         ///
}
///  Final -  function atributo
///
///  function cposdeptosetor    
/****  function cposdeptosetor(m_element,m_element_value,val_mres) {   ****/
function cposdeptosetor(m_elm,m_elm_val,val_mres) {     
      /***
      *        ATUALIZADO EM 20230810  
      ****/
      ///
      ///   Select do campo DEPTO
      ///
      var m_mostrar_result = "";
      var m_array  = "";
      ///
      /// Verifica caso Select for SETOR
      var xid = (/^setor|codsetor|codidseto/ui);
      /// var posids =  src[1].toString().search(xid); 
      var posids =  m_elm.search(xid); 
      ///

/*************      
  alert(" js/editar_patrimonio_js.php/458  ---> cposdeptosetor   -->>  posids = "+posids
        +" -->> tb  nometb = "+nometb+"  <<<---  url_central = "+url_central
        +"  <<--  m_elm = "+m_elm+" - m_elm_val ="+m_elm_val
        +"  --  val_mres = "+val_mres);  
 ***********/
         
          
          
      if( posids==-1 ) {
          ///
          ///   Caso NAO for Select SETOR
          ///  Ocultar Select Setor
          var array_campos = new Array("setor","codsetor","codiddept");
          ///
          var lenarr = array_campos.length;
          for( nx=0; nx < lenarr; nx++ ) {
               var campo_do_array = array_campos[nx];
               if( document.getElementById(campo_do_array) ) {
                    var nxid = document.getElementById(campo_do_array);
                    var tdisp = nxid.style.display;
                    if( tdisp!="none" ) {
                        nxid.style.display="none";   
                    }
                    ///
               }     
          }
          ///  Final -  Ocultar Select Setor
      }
      ///  Final - if( posids==-1 ) {
      ///
      ///  Definindo valores das variaveis 
       var instituicao="Todas"; var unidade="Todas";  
       var departamento="Todos"; var setor="Todos";
       ///
       /// Nome da coluna  INSTITUICAO  da Tabela setor
       /// if( document.getElementById("instituicao") ) {
       var pn=(/instituicao|codinstituicao|codidinst/i);
       var pinst = m_elm.search(pn); 
       ///
       if( document.getElementById(codidinst) ) {
           ///
            var tmpc = document.getElementById(codidinst);
            instituicao=trim(tmpc.value);
            if( instituicao.length<1 ) instituicao="Todas"; 
            ///
            /// Valor dos campos para variavel m_mostrar_result
            ///  m_mostrar_result+=instituicao+"#";
                m_mostrar_result1=instituicao+"#";
               /// Nome dos campos para variavel m_array
               ///  m_array+=codidinst+"#";   
                 m_array1=codidinst+"#";  
               ///  
       }
       ///  Final - if( document.getElementById(codidinst) ) {
       ///
       /// Nome da coluna UNIDADE  da Tabela  
       /// if( document.getElementById("unidade") ) {
       var pn=(/unidade|codunidade|codidunid/i);
       var punid = m_elm.search(pn);   
       if( document.getElementById(codidunid) ) {
             var tmpc = document.getElementById(codidunid);
             unidade=trim(tmpc.value);
             if( unidade.length<1 ) unidade="Todas"; 
             m_mostrar_result2=unidade+"#";
             m_array2=codidunid+"#";  
             ///
       } 
       /****  Final - if( document.getElementById(codidunid) ) {  ****/
       ///
       /// Nome da coluna DEPTO/DEPARTAMENTO da Tabela  
       ///  if( document.getElementById("departamento") ) {
       var pn=(/departametno|coddepto|codiddept/i);
       var pdept = m_elm.search(pn);   
       if( document.getElementById(codiddept) ) {
            var tmpcd = document.getElementById(codiddept);
            var tdisp = tmpcd.style.display;
            if( tdisp!="none" ) {
                departamento=trim(tmpcd.value);
                if( departamento.length<1 ) departamento="Todas";  
                /// Valor dos campos para variavel m_mostrar_result
                 m_mostrar_result3=departamento+"#"; 
                 ///
                 /// Nome dos campos para variavel m_array
                 m_array3=codiddept+"#";  
                 ///
            }
            ///
       } 
       /// Final -  if( document.getElementById(codiddept) ) { 
       ///
       /// Nome da coluna SETOR da Tabela  
       var pn=(/setor|codseto|codidseto/ui);
       var pseto = m_elm.search(pn);   
       if( document.getElementById(codidseto) ) {
             ///
             var tmpcd = document.getElementById(codidseto);
             var tdisp = tmpcd.style.display;
             if( tdisp!="none" ) {
                  setor=trim(tmpcd.value);
                  if( setor.length<1 ) setor="Todos";  
                  /// Valor dos campos para variavel m_mostrar_result
                  m_mostrar_result4=setor+"#"; 
                  ///
                  /// Nome dos campos para variavel m_array
                  m_array4=codidseto+"#";  
                  ///
             }
             ///
       } 
       /****   Final - if( document.getElementById(codidseto) ) {  *****/
       ///
       /// 1 - Select INSTITUICAO
       if( pinst!=-1 ) {
            m_mostrar_result+=m_mostrar_result1;
            m_array+=m_array1;   
       }
       /// 2 - Select UNIDADE
       if( punid!=-1 ) {
             m_mostrar_result+=m_mostrar_result1+m_mostrar_result2;
              m_array+=m_array1+m_array2;   
       }
       ///
       /// 3 - Select DEPTO
       if( pdept!=-1 ) {
             m_mostrar_result+=m_mostrar_result1+m_mostrar_result2;
             m_mostrar_result+=m_mostrar_result3;
             m_array+=m_array1+m_array2;  
             m_array+=m_array3; 
       }
       ///
      /// 4 - Select SETOR
       if( pseto!=-1 ) {
             m_mostrar_result+=m_mostrar_result1+m_mostrar_result2;
             m_mostrar_result+=m_mostrar_result3+m_mostrar_result4;
             m_array+=m_array1+m_array2+m_array3;  
             m_array+=m_array4; 
       }
       ///  FINAL dos Selects Instituicao,  Unidade , Depto e Setor
       ///
       ///    Campo Slect ID  campos_tabela
       if( document.getElementById("campos_tabela") ) {
            ///
            /// IMPORTANTE - Javascript - Voltando para o inicio da tag Select
            var zelem = document.getElementById("campos_tabela");
            zelem.options[0].selected=true;
            zelem.options[0].selectedIndex=0;  
            ///
            ///  Ocultano ID mostrar_resultado ou mostrar_resultado2
            var xarray = ["mostrar_resultado","mostrar_resultado2"];
            ///
            for( xn=0;xn<xarray.length; xn++ ) {
                 ///  Ocultando IDs desse Array xarray
                 if( document.getElementById(xarray[xn]) ) {
                      var xmr = document.getElementById(xarray[xn]);
                      var tdisp = xmr.style.display;
                      if( tdisp!="none" ) {
                          xmr.style.display="none";   
                      }
                 }    
            }
            ///  Final - for( xn=0;xn<xarray.length; xn++ ) {
            ///
            ///  Ocultano ID td_mostrar_resultado
            if( document.getElementById("td_mostrar_resultado") ) {
                 var xqo = document.getElementById("td_mostrar_resultado");
                 var tdisp = xqo.style.display;
                 if( tdisp!="none" ) {
                     xqo.style.display="none";   
                 }
                 /****
               document.getElementById("td_mostrar_resultado").style.display="none";
               ***/
            }
            ///
      } 
      /***  Final -  if( document.getElementById("campos_tabela") ) {  ****/
      ///
      ///  var m_mostrar_result=instituicao+"#"+unidade+"#"+departamento;      
      var nrx = m_mostrar_result.lastIndexOf("#"); 
      if( nrx!=-1 ) {
          var  m_mostrar_result = m_mostrar_result.substring(0,nrx);   
      } 
      ///
      var nrx = m_array.lastIndexOf("#"); 
      if( nrx!=-1 ) {
          var  m_array = m_array.substring(0,nrx);   
      } 
      ///
      ///
      if( m_mostrar_result.length<1 ) {
           m_mostrar_result=m_elm_val;  
      } 
      ///
      /// Definindo Array com a Tabela e variavel 
      var array=[nometb,m_elm];  
      ///
      ///  Enviando dados para outra function dochange

      
/**********
  alert(" js/editar_patrimonio_js.php/658   ---> function cposdeptosetor   -->> FINAL    posids = "+posids
        +" nometb = "+nometb+"  <<<---  url_central = "+url_central+" \r\n m_array = "+m_array
        +"  <<-->>  m_elm = "+m_elm+" - m_elm_val ="+m_elm_val
        +"  --  val_mres = "+val_mres+"\r\n  --->>> 1) codidinst = "+codidinst
        +"  2) codidunid = "+codidunid+"  3) codiddept = "+codiddept+"  4) codidseto = "+codidseto
        +"  \r\n  -->>  m_mostrar_result = "+m_mostrar_result);  
 *****/        



      dochange(array,m_mostrar_result,m_array);
      ///
      return;    
      ///
}
/***   FINAL  - function cposdeptosetor() { ***/
///
///  Desativando todos os campos do Atributo 
function desativar_atributo() {
       /****
       if( document.getElementById("label_msg_erro") ) {
           if(  document.getElementById("label_msg_erro").style.display="block" ) {
                document.getElementById("label_msg_erro").style.display="none";
           }     
       }
       
              //  
       if( document.getElementById('tab_atrib')  ) {
           if( document.getElementById('tab_atrib').style.display="block" ) {
                document.getElementById('tab_atrib').style.display="none";                           
           }
       }

       if( document.getElementById('m_atributo')  ) {
           if( document.getElementById('m_atributo').style.display="block" ) {
                document.getElementById('m_atributo').style.display="none";                           
           }
       }             
        
       ****/
       ///       
       ///  DESATIVANDO VARIOS CAMPOS DOS ATRIBUTOS
       ///    Ocultar ID  label_msg_erro e outros 
       exoc("label_msg_erro",0,"");                     
       exoc("tab_atrib",0,"");                
       exoc("m_atributo",0,"");                         
       ///
       ///
       if( document.getElementById('m_incluir_atributo') ) {
            /*** Caso ID  estiver Ativado - DESAtivar elemento/ID  ***/
            var dbyid=document.getElementById('m_incluir_atributo');
            var tdispd = dbyid.disabled; 
            if( tdispd!=true ) {
                 dbyid.value = "";   
                 dbyid.disabled = true;
            }   
            ///
            /****
            var tdispt = dbyid.style.display;
            if( tdispt!="none" ) {
                 dbyid.style.display="none";                         
            }
            ****/
            ///
           /****
           if( document.getElementById('m_incluir_atributo').disabled==false  ) {
              document.getElementById('m_incluir_atributo').disabled = true;                       
           }
           ****/ 
       }
       ///      
       if( document.getElementById('m_limpar_atributo')  ) {
            /*** Caso ID  estiver Ativado - DESAtivar elemento/ID  ***/
            var dbyid=document.getElementById('m_limpar_atributo');
            var tdispd = dbyid.disabled; 
            if( tdispd!=true ) {
                 dbyid.value = "";   
                 dbyid.disabled = true;
            }   
            ///
            /*****
            var tdispt = dbyid.style.display;
            if( tdispt!="none" ) {
                 dbyid.style.display="none";                         
            }
            *****/
            ///
          /*****
          if( document.getElementById('m_limpar_atributo').disabled==false  ) {
             document.getElementById('m_limpar_atributo').disabled = true;                       
          } 
           ****/
       }  
       ///
       ///    ATUALIZADO EM 20220804
       /*****
       exoc("label_incluir_atributo",0);
       exoc("label_limpar_atributo",0);                             
       ****/
       /***
       *  tr) trincatr  -  Desativando BOTOES:
       *     td) label_incluir_atributo
       *     td) label_limpar_atributo          
       ***/
       exoc("trincatr",0);
       ///
       /// Desativar Campo para digitar - Descricao Atributo
       if( document.getElementById('tab_descr') ) {
            /**  Verifica caso estiver DESAtivado - 
            *     DESATIVAR Eelemento/ID tab_atrib
            ***/  
            var r_tmt = document.getElementById('tab_descr');
            var tdisp =  r_tmt.style.display;
            if( tdisp!="none" ) {
                r_tmt.style.display="none";                         
            }
            ///
       }
       /***  Final - if( document.getElementById('tab_descr') ) {  ***/     
       ///
       if( document.getElementById('m_atrib_descr') ) {
           ///
            /***  Verifica caso estiver Ativado - DESAtivar elemento/ID  ***/
            var dbyid=document.getElementById('m_atrib_descr');
            var tdispd = dbyid.disabled; 
            if( tdispd!=true ) {
                 dbyid.value = "";   
                 dbyid.disabled = true;
            }   
            ///
            /*****
            var tdisp =  dbyid.style.display;
            if( tdisp!="block" ) {
                dbyid.style.display="block";                         
            }
            ****/
            ///

            
            
            
           /***   
            if( document.getElementById('m_atrib_descr').disabled==false  ) {
                document.getElementById('m_atrib_descr').value = "";                
               document.getElementById('m_atrib_descr').disabled = true;                       
            }
            ***/
       }
       /**  Final - if( document.getElementById('m_atrib_descr') ) {  **/  
       ///
       ///    
       if( document.getElementById('atributo') ) {
            /***  Verifica caso estiver Ativado - DESAtivar elemento/ID  ***/
            var dbyidx=document.getElementById('atributo');
            var tdispd = dbyidx.disabled; 
            if( tdispd!=true ) {
                 dbyidx.value = "";   
                 dbyidx.disabled = true;
            }   
            ///
            /****
           if( document.getElementById('atributo').disabled==false  ) {
               document.getElementById('atributo').value = "";                
               document.getElementById('atributo').disabled = true;                       
           } 
           ****/
       }
       /**  Final - if( document.getElementById('atributo') ) {  **/  
       ///     
       /// 
       if( document.getElementById('m_atributo') ) {
           /***  Verifica caso estiver Ativado - DESAtivar elemento/ID  ***/
           var dbyidz=document.getElementById('m_atributo');
           var tdispd = dbyidz.disabled; 
           if( tdispd!=true ) {
                 dbyidz.value = "";   
                 dbyidz.disabled = true;
           }   
           ///
           /***
             if( document.getElementById('m_atributo').disabled==false  ) {
                  document.getElementById('m_atributo').disabled = true;                       
             }
           ***/
       }      
       /***  Final - if( document.getElementById('m_atributo') ) {  **/
       ///
       if( document.getElementById('m_botao_atributo') ) {
           /***  
           *    DEFINA O ESTADO  MARCADO DE UMA CAIXA DE SELECAO  
           *   Verifica caso estiver DESAtivado - ATIVAR elemento/ID  
           *         Elemento type="checkbox"
           ***/
           var dbyid=document.getElementById('m_botao_atributo');
           var tdispd = dbyid.disabled; 
           if( tdispd!=false ) {
               dbyid.disabled = false;
           }   
           ///
           var tcheck = dbyid.checked; 
           if( tcheck!=false ) {
               dbyid.checked = false;
           }   
           ///
           /***
           if( document.getElementById('m_botao_atributo').checked  ) {
                document.getElementById('m_botao_atributo').checked = false;                       
           }
           *****/
           /// 
       }      
       /****  Final - if( document.getElementById('m_botao_atributo') ) { ****/
       ///
}
/*****  FINAL - Desativando todos os campos do Atributo  *********/
///
/***
      Funcao principal para enviar dados via AJAX
***/
function dochange(src,val,m_array)  {
     ///
     /// Verificando se a function exoc existe 
     if(typeof exoc==="function" ) {
          ///  Ocultando ID  e utilizando na tag input comando onkeypress
          exoc("label_msg_erro",0);  
     } else {
          /***  IMPORTANTE: essa function acentuarAlerts
         *        para acentuacao
         ***/
         var mensagem=acentuarAlerts("funcion exoc não existe - ADMINISTRADOR CORRIGIR.");
         ///
         alert(mensagem);
         ///  alert("funcion exoc nao existe - ADMINISTRADOR CORRIGIR.");
         return;        
         ///
     }
     /// 
     if( typeof(src)==="undefined" ) var src=""; 
     if( typeof(val)==="undefined" ) var val="";
     if( typeof(m_array)==="undefined" ) var m_array="";
     if( typeof(pos)==="undefined" ) var pos=-1;
     if( typeof(val)==="string" ) var val_upper=val.toUpperCase();
     ///
     ///  Verifica se a variavel e uma string
     var src_maiusc=""; var src_array_pra_string="";  
     var m_src_um="";
     if( typeof(src)=='string' ) {
           ///  src = trim(string_array);
           /***  
           *   string.replace - Melhor forma para eliminiar espaços no comeco e final da String/Variavel  
           *  
           *****/
           src = src.replace(/^\s+|\s+$/g,"");        
           src_maiusc = src.toUpperCase();     
           var pos = src.indexOf(",");     
           if( pos!=-1 ) {  
               //  Criando um Array 
               var array_src = src.split(",");
               var teste_cadastro = array_src[1];
               var  pos = teste_cadastro.search("incluid");
               var m_src_um = array_src[1];
           }
           ///
     } else if( typeof(src)=='number' && isFinite(src) )  {
          src = src.value;                
     } else if( Array.isArray(src) ) {
          ///
          var pos_src1=-1;                    
          ///  esse elemento definido como Array
          if( src.length>=1 ) {
              ///
              ///  Caso encontrar - mostrar_resultado ou  mostrar_resultado2    
              var temp_search =/^clp$|^mostrar_resultado|^selecionado|^instituicao|^unidade|^depto|^setor/ui; 
              var pos_src1=src[1].search(temp_search); 
              var m_src_um=src[1];                     
          }
          ///
     }
     ///


 alert(" js/editar_patrimonio_js.php/932 -->>  INICIO dochange  -->> pos = "+pos
        +"  --->> src = "+src+" -->>  val =  "
        +val+"  -->>  m_array = "+m_array+" \r\n  src_maiusc = "+src_maiusc);    


    
    ///  Variavel poststr    
    var poststr="";
    if( pos!=-1 ) {
        var poststr="val="+encodeURIComponent(val);
    } else if( pos==-1 ) {
        /// 
        ///  if( src_maiusc=="RETORNAR" ) {
        if( src_maiusc.search(/retornar/ui)!=-1 ) {
            ///
            /****  EDITAR CANCELAMENTO  ****/ 
            if( m_array.replace(/\s/g,'').length<1  ) {
                location.reload();     
                return;
                ///            
            } else {
                ///
                var tab_salva=m_array;            
                if( typeof(tab_salva)=="undefined" ) {
                      var tab_salva="";  
                } 
                ///
                ///  Ativando IDs do Cabecalho
                exoc("p_cabecalho",1);  
                exoc("hr_cabecalho",1);  
                ///
                var poststr="";
                if( tab_salva.length>0 ) {
                    if( m_array=="tabela_consultada"  ) {
                         var poststr="data="+unescape(src)+"&val="+encodeURIComponent(m_array);
                    } else {
                         tab_salva="";
                    }
                } 
                /// Caso variavel tab_salva menor 1 caracter
                if( tab_salva.length<1 ) {
                    if( val.search(/http/i)!=-1 ) {
                        parent.location.href=val;                
                    } else {
                        parent.location.href=url_central+val;                
                    }
                    ///
                }    
                ///            
            }
            ///
        }
        /****  Final - if( src_maiusc.search(/retornar/ui)!=-1 ) {  ****/
        ///
        /***  Procurando pela Tabela e Campo selecionado  ****/
        var texto_src= src.toString();
        var pos_src = texto_src.search(/bem(\s)*,(\s)*clp(\s)*/ui);
        ///                     
        var aqui = texto_src.lastIndexOf(","); 
        ///
        
/***
 alert(" js/editar_patrimonio_js.php/458  -> CONTINUAR 2) - dochange  VER m_src_um = "
       +m_src_um+"  <<<--- src = "+src+"  <<<---   src_array_pra_string = "
       +src_array_pra_string+"   --->>> pos_src = "+pos_src+"  \r\n src = "+src
       +" -  val =  "+val+"  -  m_array = "+m_array);    
    ***/


       
        if( src_maiusc=="SELECIONADO" || pos_src!=-1 ) {
            ///
            var passou=0;
            ///
             ///  Procurando por IP ou CLP 
             var n = texto_src.lastIndexOf(",");
             if( parseInt(n)>0 ) {
                 var result = texto_src.substr(n+1);
                 ///
                 /// Caso for IP limpar o campo clp/lc_clp/m_clp
                 if( result.toUpperCase()=="IP" ) {
                        /// 
                        passou=1;
                        ///
                        var m_array = "ip";
                       ///  Caso exista o campo clp - Limpar
                        var bem_sel = {a:"clp", b:"lc_clp", c:"m_clp"}; 
                        var xzp;
                        for( xzp in  bem_sel ) {
                            var idclp = bem_sel[xzp];
                            if( document.getElementById(idclp) ) {
                                 document.getElementById(idclp).value="";
                            }    
                        }
                        ///
                 }
                 /***  Final - if( result.toUpperCase()=="IP" ) {   ***/
                 ///
                 /// Caso for CLP limpar o campo ip/lc_ip/m_ip
                 if( result.toUpperCase()=="CLP" ) {
                     ///
                     passou=1;
                     ///
                     var m_array = "clp"; 
                     ///  Caso exista o campo clp -  limpar
                     var bem_sel = {a:"ip", b:"lc_ip", c:"m_ip"}; 
                     var xzp;
                     for( xzp in  bem_sel ) {
                           var idclp = bem_sel[xzp];
                           if( document.getElementById(idclp) ) {
                                 document.getElementById(idclp).value="";
                           }    
                     }
                     ///
                 }
                 ///
                 ///  Caso for campo IP ou CLP utilizado
                 var array_sels=["codiddept","depto","iddepto","coddepto","setor","codsetor"];
                 for( zn=0; zn<array_sels.length; zn++ ) {
                      ////
                      if( document.getElementById(array_sels[zn]) ) {
                          /***
                          *      IMPORTANTE - javascript 
                          *     verifica o tipo do elemento 
                          ***/
                          var lncpo = document.getElementById(array_sels[zn]);
                          var tipode=lncpo.type;   
                          if( tipode=="select-one" ) {
                              /**
                              *    IMPORTANTE - Javascript 
                              *     - Voltando para o inicio da tag Select
                              ***/
                              lncpo.options[0].selected=true;
                              lncpo.options[0].selectedIndex=0;
                              ///
                          } else if( tipode=="text" ) {
                              lncpo.value="";
                          }
                          ///
                          ///  Caso for campo Select  setor
                          var xlset = lncpo.id;
                          var possetor = xlset.search(/setor|codsetor/ui);
                          if( possetor!=-1 ) {
                              exoc(xlset,0,"");
                          }
                          ///    
                      }
                      /// 
                 }
                 ///  Final - for( zn=0; zn<array_sels.length; zn++ ) {
                 ///
             }
             ///  Final - if( parseInt(n)>0 ) {
             ///
             //// Selecionando bem  ou  escolhendo CLP
             var poststr="data="+unescape(src)+"&val="+val+"&m_array="+encodeURIComponent(m_array);

/****
  alert(" editar_patrimonio_js/783  --->> dochange parte 1)  src = "+src
             +" -->> val = "+val+" -->> m_array = "+m_array
             +" -->> m_src_um = "+m_src_um+"  <<--   \r\n    poststr = "+poststr);           
****/
                
             ///
             /// Final - if( src_maiusc=="SELECIONADO" || pos_src!=-1 ) {
             ///
             
        } else if( src_maiusc=="CAMPOS_TABELA"  ) {
            ///
            ///  Ocultar esses campos no Array
            var pos = val.search(/^clp#|^nome#|^situacao#|^datacompra#|^coduspresp#/i);
            if( pos==-1 ) {
                var obj = {
                            'var_id' : ['instituicao', 'unidade'],
                            'var_nome' : ['Instituição', 'Unidade']
                          };
                ///
                var obj_id = obj.var_id[0];
                var obj_nome = obj.var_nome[0];
               //  obj.var_nome[0];
               //  obj.var_nome[1];
                var obj_length = obj.var_id.length;
                var inst_unid = new Array();
                for( wz=0; wz<obj_length; wz++ ) {
                     // Verificando campos
                     var id_var = obj.var_id[wz];
                     var nome_var = obj.var_nome[wz];
                     if( document.getElementById(id_var) ) {
                         var m_typeof = document.getElementById(id_var);
                         //  if( typeof(m_typeof)=="select-one" ) {
                         var testar="";
                         if( m_typeof instanceof Object ) testar="OK";
                         if( m_typeof instanceof String )  testar="OK";
                         if( testar=="OK" ) {  
                             var midvar=document.getElementById(id_var);
                             var texto = trim(midvar.value);
                             if( texto.length<1 ) {
                                 ///
                                 msg_erro=msg_erro_ini+'Falta '+nome_var+final_msg_ini;
                                 /***
                                 if( document.getElementById("label_msg_erro") ) {
                                     document.getElementById("label_msg_erro").style.display="block";
                                     document.getElementById("label_msg_erro").innerHTML=msg_erro;               
                                 }
                                 ***/
                                 ///  Mensagem pra ID  label_msg_erro
                                 exoc("label_msg_erro",1,msg_erro);  
                                 
                                 ///  Desativando campo ID campos_tabela  e  ocultando outros
                                 if( document.getElementById("campos_tabela") ) {  
                                      /***
                                      *   IMPORTANTE - Javascript - Voltando para o      
                                      *         inicio da tag Select
                                      ***/
                                      var mct=document.getElementById('campos_tabela');
                                      mct.options[0].selected=true;
                                      mct.options[0].selectedIndex=0;  
                                      ////
                                      ///  Ocultando o campo ID mostrar_resultado
                                      /****
                                       if( document.getElementById("mostrar_resultado") ) {
                                           if( document.getElementById("mostrar_resultado").style.display="block" ) {
                                                document.getElementById("mostrar_resultado").style.display="none";   
                                           }   
                                       }
                                      ***/
                                      exoc("mostrar_resultado",0);  
                                      ///
                                      ///  Ocultando botao ? para informar
                                      if( document.getElementById("td_mostrar_resultado") ) {
                                           /****
                                           if( document.getElementById("td_mostrar_resultado").style.display="block" ) {
                                                document.getElementById("td_mostrar_resultado").style.display="none";   
                                           }   
                                           ******/
                                           var ob= document.getElementById("td_mostrar_resultado");
                                           var tdisp = ob.style.display;
                                           if( tdisp!="none" ) {
                                                ob.style.display="none";                         
                                           }
                                           ///
                                      }
                                      ///          
                                 }
                                 /****  Final - if( document.getElementById("campos_tabela") ) {   ****/ 
                                 /// 
                                 midvar.focus();                         
                                 ///
                                 return;
                                 ///
                             } else {
                                 inst_unid[wz]=texto;             
                             }
                             /// 
                         }
                     }
                     /// Final - if( document.getElementById(id_var) ) {
                }
                ///
            }   
            ///  Final - if( pos==-1 ) {
            ///
            ///  Ocultando a Lista de registros 
            if( document.getElementById("mostrar_tabela") ) {
                 /***
                 if( document.getElementById("mostrar_tabela").style.display="block"  ) {
                     document.getElementById("mostrar_tabela").style.display="none";                        
                 }
                 ***/
                 ///  Alterado em 20220623
                 var r_mt = document.getElementById("mostrar_tabela");
                 var tdisp =  r_mt.style.display;
                 if( tdisp!="none" ) {
                     r_mt.style.display="none";                         
                 }
                 ///
             }
             ///
             if( document.getElementById("mostrar_resultado2") ) {
                 /*** IMPORTANTE - Javascript - Voltando para o inicio da tag Select  ***/
                  var elmr=document.getElementById('mostrar_resultado2');
                  elmr.options[0].selected=true;
                  elmr.options[0].selectedIndex=0;  
             }    
             ///
             if( document.getElementById("mostrar_resultado") ) {
                  ///
                  ///  Mensagem para informacao
                  if( document.getElementById("td_mostrar_resultado") ) {
                       /****
                         if( document.getElementById("td_mostrar_resultado").style.display="none" ) {
                              document.getElementById("td_mostrar_resultado").style.display="block";
                         }
                       ****/   
                       ///  Alterado em 20220623
                       var r_tmt = document.getElementById("td_mostrar_resultado");
                       var tdisp =  r_tmt.style.display;
                       if( tdisp!="block" ) {
                            r_tmt.style.display="block";                         
                       }
                       ///
                  }
                  ///
                  ///  Ativando  campo para digitar                   
                  if( document.getElementById("mostrar_resultado") ) {
                       ///
                       var xtmt = document.getElementById("mostrar_resultado");
                       var tdisp =  xtmt.style.display;
                       if( tdisp!="block" ) {
                            xtmt.style.display="block";                         
                       }
                       ///
                       xtmt.focus();
                  }  
                  ///
                  var tamanho_campo="";
                  var pos_val=val.search(/\#/);
                  if( pos_val!=-1 ) {
                        //  esse elemento definido como Array
                        //  Criando um Array 
                        var array_val = val.split("#");
                        var tamanho_campo = array_val[1];
                  }
                  ///
                  var poststr="data="+unescape(src)+"&val="+val;
                  poststr+="&m_array="+encodeURIComponent(texto);                     
                  ///
             }
             ///
        } else {
            ///
            ///  Primeiro verificar caso for Select Depto/Departamento
            var abcx="";
            if( Array.isArray(src) ) {
                /***
                *      Javascript comando filter 
                *    Remover elementos que são Falsas , que incluem 
                *   uma cadeia vazia "", 0, NaN, null, undefined, e false 
                ***/
                var src = src.filter(function(el) { return el; });
                var lensrc = src.length;
                if( lensrc==1 ) {
                    var abcx = trim(src[0]);
                }
                ///
            } else {
               var abcx = trim(src);    
            } 
            ////
            /*****
            *          Atualizado em 20230814
            *    Verificando caso Select for Depto ou Setor   
            ****/
            var cposdept = (/departamento|^depto|^coddept|^codiddept|setor|codseto|codidseto/ui);
         ///   var  posdepto = src.toString().search(cposdept);     
            var  posdepto = trim(abcx).search(cposdept);    
            var possrcum = m_src_um.search(cposdept);    



  alert("  editar_patrimonio_js/909  -->> AQUI  posdepto = "+posdepto+" -->> possrcum = "
               +possrcum+"  <<<---  \r\n -->> m_src_um = "+ m_src_um+"  <<<---- src = "+src
               +" -- abcx = "+abcx+"  <<--  val = "+val+" -->>  m_array = "+m_array);


            
            if( posdepto!=-1 || possrcum!=-1 ) {
                ///
                /// Quando acontece erro ou Nao existe dados    
                var xn_array = ["campos_tabela","mostrar_tabela",
                                  "mostrar_resultado","td_mostrar_resultado"];
                ///
                for( xn=0;xn<xn_array.length; xn++ ) {
                     ///
                     ///  Ocultando IDs desse Array xn_array
                     if( document.getElementById(xn_array[xn]) ) {
                          var xmr = document.getElementById(xn_array[xn]);
                          var tdisp = xmr.style.display;
                          if( tdisp!="none" ) {
                              xmr.style.display="none";   
                          }
                     }    
                }
                ///  Final - for( xn=0;xn<xn_array.length; xn++ ) {
                ///
                /// Limpar campos IP e CLP
                var xn_array = ["ip","lc_ip","clp","lc_clp"];
                for( xn=0;xn<xn_array.length; xn++ ) {
                     ///  Limpar campos
                     if( document.getElementById(xn_array[xn]) ) {
                          var xmr = document.getElementById(xn_array[xn]);
                          xmr.value="";   
                     }    
                }
                ///
            }
            ///  Final -  if( posdepto!=-1 || possrcum!=-1 ) {  
            ///    
            ///  make connection
            var m_val = val;
            ///
            var xyid = (/^(INCLUIR_ATRIBUTO|EDITAR_ATRIBUTO|REMOVER_ATRIBUTO)/ui);
            var vsmsrch = src_maiusc.search(xyid);
            if( vsmsrch==-1 ) {
                ///
                if( m_val.search(',@#%&@%,')!=-1  ) {
                     var array_val=m_val.split(",@#%&@%,");
                 } else if( m_val.search('@#$')!=-1  ) { 
                     var array_val=m_val.split("@#$");
                 } else {
                     var array_val=""  ;
                 }
                 ///    
            }
            ///  Final - if( vsmsrch==-1 ) {
            ///
            ///   SESSION:  Total de Registros
            var total_regs ="<?php echo $_SESSION["total_regs"];?>"; 
            ///    
            var idyz=(/^(INCLUIR_ATRIBUTO|EDITAR_ATRIBUTO|REMOVER_ATRIBUTO|M_PATRIMONIO_EDITADO)/ui);
            var psrc_maiusc=src_maiusc.search(idyz);
            ///


    alert(" js/editar_patrimonio_js/1346  -->> src_maiusc = "+src_maiusc
                +" ==>> psrc_maiusc = "+psrc_maiusc+" \r\n  -->>>   m_src_um = "+m_src_um+"  <<-->>   m_val = "+m_val
             +"  <<--- \r\n --->>> src = "+src+"\r\n val = "
             +val+" -- m_array = "+m_array+" \r\n  -->>  array_val = "+array_val);

            
            
             ///  
             if( psrc_maiusc!=-1 ) {
                 ///
                 if( src_maiusc=="M_PATRIMONIO_EDITADO" ) {
                      var val_pos=m_array.search("[%@#$&%]");
                      if( val_pos!=-1 ) {
                           var poststr="data="+unescape(src)+"&val="+unescape(val);
                           poststr+="&campo_nome="+encodeURIComponent(array_val[0]);
                           poststr+="&campo_value="+array_val[1];
                           poststr+="&m_array="+encodeURIComponent(m_array);  
                           ///
                      }
                      ///  Finasl - if( val_pos!=-1 ) { 
                      ///    
                 } else {
                       var poststr="data="+unescape(src)+"&val="+m_val;
                       poststr+="&m_array="+encodeURIComponent(m_array);
                 }
                 ///
             } else {
                 /***
                 *       ATUALIZADO EM 20220622
                 ****/
                 ///
                 /// Propriedades no campo da Tag Select id campos_tabela 
                 var pos_opcao=val.search(/ordenar_por/gi); 
                 
                 

    alert(" js/editar_patrimonio_js/1002  ==>> pos_opcao = "+pos_opcao+" <<-- psrc_maiusc="
               +psrc_maiusc+" -->> total_regs = "
            +total_regs+" \r\n --> src_maiusc = "+src_maiusc+"  <<--- src = "+src
            +" \r\n val = "+val+" -- m_array = "+m_array+" <<<--- \r\n  -->>  array_val = "+array_val);


                 /****
                 *   ATUALIZADO EM 20220623
                 ****/
                 if( pos_opcao!=-1  ) { 
                      ///       
                      /****
                      *      Verificando campo mostrar-resultado
                      *    20220715
                      ****/
                      var msu_up = m_src_um.toUpperCase();
                      if( msu_up=="MOSTRAR_RESULTADO" ) {
                          if( document.getElementById("mostrar_resultado") ) {
                              var elemr = document.getElementById("mostrar_resultado");
                              var valmr = trim(elemr.value);
                              var lenmr = valmr.length;
                              if( lenmr>0 ) {
                                   ///  Ocultando ID  label_msg_erro
                                   exoc("label_msg_erro",0,"");
                                   ///
                              }
                              ////
                          }
                      }
                      ///  Final - if( msu_up=="MOSTRAR_RESULTADO" ) {  
                      ///
                      ///   POSTSTR
                      var poststr=opcao_selecionada(src,val,m_array);   
                      ///  
                 } else {
                     ///
                     ///  Caso selecionado campo SETOR
                     ///  Caso encontrar - mostrar_resultado ou  mostrar_resultado2    
                     var tmp_search =/^codseto|^setor$|^codidseto|^idseto/ui; 
                     var texto_src = src.toString();
                     var posset=texto_src.search(tmp_search); 
                     if( posset!=-1  ) {
                         ///  Tabela bem, mostrar_resultado e campo SETOR
                         var src = ["bem","mostrar_resultado",src]; 
                     }
                     ///
                     /*****
                     var poststr="data="+unescape(src)+"&val="+m_val;
                     poststr+="&campo_nome="+array_val[0]+"&campo_value="+array_val[1];
                     poststr+="&m_array="+encodeURIComponent(m_array);          
                     ****/
                     var poststr="data="+unescape(src)+"&val="+m_val;
                     ///
                     ///  Verfica variavel array_val
                     if( typeof(array_val[0])!=="undefined" )  {
                         poststr+="&campo_nome="+array_val[0]+"&campo_value="+array_val[1];    
                     }
                     poststr+="&m_array="+encodeURIComponent(m_array);          
                     ///
                 }    
                 ///
             }
             ///
             


   alert("  js/editar_patrimonio_js/1453  -->>  POSTSTR ->  2)  src = "+src
          +"  --  val = "+val+" -- m_array = "+m_array
          +" \r\n m_src_um = "+m_src_um+"  \r\n    poststr =  "+poststr);

 

             
             
             ///
             ///       
        }
        ///
    }
    //
    //
    /*****   Aqui eu chamo a class  *****/
    var myConn = new conecta_ajax();      
    /***  Um alerta informando da não inclus?o da biblioteca   ***/
    /// IMPORTANTE: descobrir erros nos comandos - try e catch
    try {
       if( !myConn ) {
            alert("XMLHTTP não disponível. Tente um navegador mais novo ou melhor.");
            return false;
        }
    } catch(err) {
          /// Enviando mensagem de erro
          exoc("label_msg_erro",1,err.message);  
    }
    //
    //  Arquivo para executar dados no AJAX   
    var receber_dados = url_central+"library/editar_patrimonio_ajax.php";        
    ///
    
    ///
    /***  Melhor usando display do que visibility - para ocultar e visualizar   ***/
    ///   document.getElementById('div1').style.visibility="visible";
    ///   document.getElementById(id).style.display="block";
    ///   document.getElementById('parte1').style.visibility="hidden";
    ///   document.getElementById(id).style.display="none";
    ///   document.getElementById('corpo').style.display="none";
    ///
    var inclusao = function (oXML) { 
                 /**** 
                 *       Recebendo os dados do AJAX
                 *   var  m_texto_recebido = req_novo.responseText;   
                 ****/
                 var  m_texto_recebido = oXML.responseText;   
                 ///  Verificando se houve ERRO
                 var pos = m_texto_recebido.search(/ERRO:|FALHA:/i);
                 
                 

  alert("  js/editar_patrimonio_js.php/1504  --->>> <b>INCLUSAO</b> inicio -->> "
         +" -->> pos = "+pos+" <br/>  <<-->>  m_src_um = "+m_src_um
         +"\r\n  -->>  src = "+src+" --->> src_maiusc = "
         +src_maiusc+"  -  src[1] = "+src[1]+"  -  val = "+val
             +" --m_array = "+m_array+" \r\n  m_texto_recebido = "+m_texto_recebido);  


                 
                 
                 
                 if( pos!=-1 ) {
                      ///
                      ///    Quando acontece Erro ou Nao existe dados    
                      /****  
                      *        ATUALIZADO EM 20230807
                      *
                      *    document.getElementById('label_msg_erro').style.display="block";
                      *    document.getElementById('label_msg_erro').innerHTML=m_texto_recebido;
                      ***/
                      ///  Caso tiver palavras Nenhum(a)
                      var pnhm = m_texto_recebido.search(/NENHUM/ui);
                      if( pnhm!=-1 ) {
                          var m_texto_recebido = m_texto_recebido.replace(/ERRO:/uig,"");
                      }
                      ///
                      ///
                      var delay=3000; /// 3 segundos
                      setTimeout(function() {
                           /// O codigo para ser executado depois de  3 segundos 
                           /// Mensagem de erro ativar e receber informacao
                           exoc("label_msg_erro",1,m_texto_recebido);
                      },delay);
                      ///
                      /***  Atualizado em 20220811     ***/
                      ///  Limpar Tabela/Lista
              ////        exoc("mostrar_tabela",0,"");
                      ///
                      return;
                      ///
                  }
                  ///  Final -  if( pos!=-1 ) {
                  ///
                  ///  DADOS enviandos pelo SELECT DEPTO        
                  var arrcposp = (/depto|codiddept|coddepto/ui);
                  ///
                  /// CAMPOS Select depto
                  ///   var posix=m_array.toString().search(arrcposp);
                  var posix=src.toString().search(arrcposp);
                  ///
                  ///  Caso encontrou habilitar Select Setor
                  if( posix != -1 ) {
                       ///
                       /// Mostrar campo Select Setor - Ativar
                       exoc("idsetor",1,m_texto_recebido);
                       return;
                  }
                  /****   Final - if( posix != -1 ) {  *****/
                  ///
                  ///  Dados enviandos pelo Select SETOR        
                  var arrcposp = (/setor|codidseto|codseto/ui);
                  /// Campos Select setor
                  var posix=src.toString().search(arrcposp);
                  ///
                  

 alert(" js/editar_patrimonio_js.php/1544 -->> inclusao -->>  1) posix = "+posix
            +" <<-- m_src_um = "+m_src_um+"  <<-->>  src_maiusc = "+src_maiusc
            +" \r\n  -->>> src = "+src+" -  val =  "+val
           +"  -  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);


                  
                  
                  ///  Caso encontrou
                 if( posix != -1 ) {
                     /// Mostrar campo Select Unidade
                     /// Mensagem de erro ativar e receber informacao
                     exoc("campos_tabela",1);
                     return;
                 }
                 ///
                 ///  Verificando variaveis src - 20171121
                 if( typeof src==="undefined" ) var srv="";
                 ///
                 ///  Verificando se variavel indefinida 
                 var pos_clp_mr="";
                 if( typeof(src[1])=="undefined" ) {
                       src[1]=" ";    
                 } else {
                      /// Procura campos clp ou mostrar_resultado
                      var pos_clp_mr=src[1].search(/clp|^mostrar_resultado$/i);   
                 }
                 ///
                 if( src_maiusc=="M_PATRIMONIO_EDITADO" ) var srv=""; 
                 ///
                 
                 
/***********************
 alert(" js/editar_patrimonio_js.php/1615 -->> inclusao -->>  2) pos_clp_mr = "+pos_clp_mr
            +" <<-- m_src_um = "+m_src_um+"  <<-->>  src_maiusc = "+src_maiusc
            +" \r\n  -->>> src = "+src+" -  val =  "+val
           +"  -  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);
   ***********************/
                 
                 
                 
                 if( pos_clp_mr!=-1 || src_maiusc=="SELECIONADO" ) {
                     ///
                     var smr = src_maiusc.replace(/\s+/gm,'');
                     if( smr=="SELECIONADO" ) {
                         ///
                         /***  CASO patrimonio/bem foi selecionado para EDITAR  ****/
                         ///
                         ///  Desativando ID mostrar_tabela
                         ///  Ocultar ID div_form
                         setTimeout(exoc("div_form",0),3000) ;      
                         ///
                         ///  Ativando IDs
                         exoc("mostrar_tabela",1,m_texto_recebido);               
                         /// exoc("div_form",1,m_texto_recebido);               
                         ///                     
                         return;
                         ///
                     }
                     /****  Final - if( src_maiusc=="SELECIONADO" ) {  ****/
                     ///
                     if( smr.length<1 ) {
                         ///
                         if( document.getElementById("mostrar_tabela") ) {
                             var elmt=document.getElementById("mostrar_tabela");
                             var tdisp = elmt.style.display;
                             if( tdisp!="block" ) {
                                  elmt.style.display="block";                         
                             }
                             elmt.innerHTML=m_texto_recebido;        
                             ///
                         }   
                         /***  Final - if( document.getElementById("mostrar_tabela") ) { ***/
                         ///
                         return;
                         ///
                     }
                     ///
                 }
                 /****  Final - if( pos_clp_mr!=-1 || src_maiusc=="SELECIONADO" ) {  ***/
                 ///

                 
                 

 alert(" js/editar_patrimonio_js.php/1598  -->> inclusao -->>  2) m_src_um = "+m_src_um
            +"  <<-->>  src_maiusc = "+src_maiusc
            +" \r\n  -->>> src = "+src+" -  val =  "+val
           +"  -  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);

                 
                 
                 ///
                 /****  ATIVANDO o campo mostrar_resultado   ****/
                 if( typeof(src_maiusc)!="undefined" ) {
                     ///
                     /// Retornando a Tabela dos registros encontrados
                     if( src_maiusc=="RETORNAR" ) {
                          ///  Desativar  ID div_form
                          exoc("div_form",0); 
                          ///
                          ///  Ativar  ID div_form
                          if( document.getElementById("div_form") ) {
                               var eldf=document.getElementById("div_form");
                               var tdisp = eldf.style.display;
                               if( tdisp!="block" ) {
                                   eldf.style.display="block";                         
                               }
                               ///
                          }
                          ///
                          ///  Enviando para o ID mostrar_tabela
                          if( document.getElementById("mostrar_tabela")  ) {
                                exoc("mostrar_tabela",1,m_texto_recebido)
                          } 
                          return;
                          ///
                     }    
                     ///  Final - if( src_maiusc=="RETORNAR" ) {  
                     ///
                     if( src_maiusc=="CAMPOS_TABELA" ) {
                         ///
                         /// Mensagem para informação
                         if( document.getElementById("div_mostrar_resultado") ) {
                             ///
                              ///  Ativar ID div_mostrar_resultado
                              var eldmr=document.getElementById("div_mostrar_resultado");
                              var tdisp = eldmr.style.display;
                              if( tdisp!="block" ) {
                                  eldmr.style.display="block";                         
                              }
                              ///
                              /// Visualizar ID  div_mostrar_resultado  
                              var tdispx = eldmr.style.visibility;
                              if( tdispx!="visible" ) {
                                   eldmr.style.visibility="visible";   
                              }
                              ///
                         }
                         /****  Final - if( document.getElementById("div_mostrar_resultado") ) {  ****/
                         ///
                         ///
                         if( document.getElementById("td_mostrar_resultado") ) {
                              ///
                              ///  Ativar ID td_mostrar_resultado
                              var eltmr=document.getElementById("td_mostrar_resultado");
                              var tdisp = eltmr.style.display;
                              if( tdisp!="block" ) {
                                   eltmr.style.display="block";                         
                              }
                              ///
                              /// Array campos_dessa_tabela 
                               var campos_dessa_tabela = new Array(['clp','CLP (Identificação do Patrimonio/Bem)'],['codigousp','Código'],
                                           ['codigo','Código'],['nome','Nome do Patrimonio/Bem'],
                                           ['situacao','Situação do Patrimonio/Bem (Ativo, Baixado, Desativado, Inoperante)'],
                                           ['datacompra','Ano da Compra (Exemplo: 1985)'],['sexo','Sexo'],['categoria','Categoria'],
                                           ['setor','Setor'],['depto','Departamento'],['unidade','Unidade'],['instituicao','Instituição']);
                               ///
                               var title="Digitar"
                               if( val.search(/#/)!=-1 ) {
                                   ///
                                   var marrayval=val.split("#");
                                   var mlength=campos_dessa_tabela.length;
                                   for( iz=0; iz<mlength;iz++ ) {
                                        var string1 = campos_dessa_tabela[iz][0].toString();
                                        var string2 = marrayval[0].toString();
                                        ///
                                        var cdtup=campos_dessa_tabela[iz][0].toUpperCase();
                                        if( cdtup===marrayval[0].toUpperCase() ) {
                                            ///
                                            if( document.getElementById("mostrar_resultado") ) {
                                                var xmr="mostrar_resultado";
                                                var elmr=document.getElementById(xmr);
                                                ///
                                                elmr.setAttribute("title","Digirar "+campos_dessa_tabela[iz][1]);
                                                ///                                               
                                            }
                                            ///
                                        }
                                        /// 
                                   }
                                   ///  Final - for( iz=0; iz<mlength;iz++ ) {  
                                   ///
                               }
                               /****  Final -  if( val.search(/#/)!=-1 ) {  *****/
                               ///
                           }  
                           /****  Final - if( document.getElementById("td_mostrar_resultado") ) {  ****/
                           ///
                           ///  Campo para digitar  -  Ativar ID  mostrar_resultado
                           exoc("mostrar_resultado",1);
                           ///
                           document.getElementById("mostrar_resultado").disabled=false;
                           document.getElementById("mostrar_resultado").value="";
                           var tamanho_cpo_tab=document.getElementById("campos_tabela").length;
                           var campo_selecionado=document.getElementById("mostrar_resultado");
                           ///
                           ///  IMPORTANTE no javascript - setAttribute
                           tamanho_cpo_tab+=10;
                           campo_selecionado.setAttribute("style","left: "+tamanho_cpo_tab+"px");
                           campo_selecionado.setAttribute("size", m_texto_recebido);
                           campo_selecionado.setAttribute("maxlength", m_texto_recebido);
                           campo_selecionado.focus();
                           return;    
                           ///                   
                      }  
                      /****  Final - if( src_maiusc=="CAMPOS_TABELA" ) {   ****/
                      ///
                }  
                /****  Final - if( typeof(src_maiusc)!="undefined" ) {   ****/
                ///

                

  alert(" js/editar_patrimonio_js.php/1718  -->> inclusao 3) src_maiusc = "+src_maiusc
            +" <<-- m_src_um = "+m_src_um
            +" \r\n  -->>> src = "+src+"  -->>  val =  "+val
           +"  -  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);

                
                
                
                ///  LISTA da Tabela mostrada na Tela    
                if( src_maiusc=="LISTA" ) {
                     //     
                     if( document.getElementById("mostrar_tabela") ) {
                         ///  Ativar ID div_mostrar_resultado
                         var elmtb=document.getElementById("mostrar_tabela");
                         var tdisp = elmtb.style.display;
                         if( tdisp!="block" ) {
                              elmtb.style.display="block";                         
                         }
                         ///
                         elmtb.innerHTML=m_texto_recebido;        
                         return;
                     }
                }
                ///  Final - if( src_maiusc=="LISTA" ) {  
                ///
                if( m_src_um=="" )  pos_src1=-1;                    
                ///
                /****
                *     NESSE  IF caso NAO foi encontrado  - mostrar_resultado ou  mostrar_resultado2
                ****/  



  alert(" js/editar_patrimonio_js.php/1770  -->> inclusao 4) pos_src1 = "+pos_src1+" <<--  src_maiusc = "+src_maiusc
            +" <<-- m_src_um = "+m_src_um+" \r\n  -->>> src = "+src+"  -->>  val =  "+val
           +"  -  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);

                
                
                  
                if( pos_src1==-1 ) {
                    ///
                     ///   Caso tenha ERRO
                     var pos = m_texto_recebido.search(/ERRO:|NENHUM/i); 
                     if( src_maiusc!="SELECIONADO"  ) {
                         ///
                         if(  src_maiusc!="M_PATRIMONIO_EDITADO" ) {
                             if( pos!=-1 ) {
                                  /// Parte dos Atributos
                                  var ps=src_maiusc.search(/^(INCLUIR_ATRIBUTO|EDITAR_ATRIBUTO)/i);
                                  ///
                                  /// Quando acontece erro ou nao existe dados   
                                  if( ps==-1 ) {      
                                      ///
                                      if( document.getElementById("mostrar_tabela") ) {
                                          var xmt=document.getElementById("mostrar_tabela");
                                          var tdisp = xmt.style.display;
                                          if( tdisp!="none" ) {
                                              xmt.style.display="none";                         
                                          }
                                          ///
                                      }
                                  }
                                  ///  ATIVAR ID  label_msg_erro 
                                  exoc("label_msg_erro",1,m_texto_recebido);                     
                                  ///
                                  return;
                             }  
                             /// Final do IF ( pos!=-1 )                         
                         }
                         ///
                     }
                     ///  Final - if( src_maiusc!="SELECIONADO"  ) {  
                     ///
                }  
                /****  Final - if( pos_src1==-1 ) {   ***/
                ///
                ///
                ///  Iniciando a pagina ou mostrando resultado da consulta - OK
                var pos = m_texto_recebido.search(/CONSULTADO/i);
                var m_pos_src=m_src_um.search(/^clp$|^MOSTRAR_RESULTADO$/i);
                ///
                


  alert(" js/editar_patrimonio_js.php/1812  -->> inclusao 5) pos = "+pos+" <<--  m_pos_src = "+m_pos_src
            +" <<-- m_src_um = "+m_src_um+" \r\n  -->>> src = "+src+"  -->>  val =  "+val
           +" -->> val_upper = "+val_upper+" <<<---  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);

                
                
                
                
                if( ( val_upper=="INICIANDO" && src_maiusc!="SELECIONADO" ) || ( m_pos_src!=-1 && pos!=-1 ) ) {
                     ///
                     if( document.getElementById("mostrar_tabela") ) {
                          var el_mt=document.getElementById("mostrar_tabela");
                          var tdisp = el_mt.style.display;
                          if( tdisp!="none" ) {
                                el_mt.style.display="none";   
                          }
                     }
                     /***  Final - if( document.getElementById("mostrar_tabela") ) {   ****/
                     ///
                     if( document.getElementById('div_form') ) {
                         var el_df=document.getElementById('div_form');
                         var tdisp = el_df.style.display;
                         if( tdisp!="block" ) {
                              el_df.style.display="block";   
                         }
                         ////
                         el_df.innerHTML=m_texto_recebido;        
                         ///
                         return;
                     }
                     ///
                 } 
                 ///
                 ///  Tabelas categoria, depto
                 var outra_tabela = true;
                 var mytabelas = new Array("atributo","categoria","depto","financiadora",
                                           "fornecedor","grupo","hpadrao","instituicao",
                                           "pessoal","projeto","setor","unidade","usuario");
                 /////
                 var length_mytabelas=mytabelas.length;
                 for( var i=0; i<length_mytabelas; i++) {
                     if( src instanceof Array) {
                          if( src[0]==mytabelas[i] ) outra_tabela = false;
                     }  
                 }             
                 ///  Final - for( var i=0; i<length_mytabelas; i++) { 
                 ///
                 
/****
   alert(" js/editar_patrimonio_js.php/1781 ---->>> INCLUSAO  3) -->> pos_src1 = "+pos_src1
       +"  <<<---  src_maiusc = "+src_maiusc+"  --- src = "+src+" -  val =  "
       +val+"  -  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);  
*****/
                     
                
                 
                 
                 /** Caso encontrar - mostrar_resultado ou  mostrar_resultado2  **/    
                 if( pos_src1!=-1 || src_maiusc=="SELECIONADO" ) {
                     ///
                     ///  Duas opcoes para Selecionar apenas um registro 
                     var msuup=m_src_um.toUpperCase();
                     var msusr=m_src_um.search(temp_search);
                     if( msuup=="MOSTRAR_RESULTADO2" || src_maiusc=="SELECIONADO" || msusr!=-1 ) {
                         ///
                         /// CASO tenha ERRO
                         var xid = (/ERRO:|Nenhum\s+registro\s+da\s+tabela/ui);
                         /****
                         var pos = m_texto_recebido.search(/ERRO:|Nenhum\s+registro\s+da\s+tabela/i);
                         *****/
                         var pos = m_texto_recebido.search(xid);   
                         ///
                         if( pos!=-1 && m_src_um.toUpperCase()!="MOSTRAR_RESULTADO" ) {
                             ///
                             var campos_selected0=new Array("instituicao","unidade","depto",
                                                          "departamento","setor");
                             ////
                             var len_cpos=campos_selected0.length;
                             for( var zt=0; zt<len_cpos; zt++ ) {
                                 var cpo_id_nome=campos_selected0[zt];
                                 if( document.getElementById(cpo_id_nome) ) {
                                     var campo_type=document.getElementById(cpo_id_nome).type;
                                     if( campo_type.toUpperCase()=="SELECT-ONE" ) {
                                         ////
                                         /*** IMPORTANTE - Javascript - Voltando para o inicio da tag Select
                                         ****/
                                         var cin=document.getElementById(cpo_id_nome);
                                         cin.options[0].selected=true;
                                         cin.options[0].selectedIndex=0;  
                                         ///
                                     }
                                     ///
                                 }
                                 ///    
                             }  
                             /****  Final - for( var zt=0; zt<len_cpos; zt++ ) {  ****/
                             ///
                         }
                         /***  Final - if( pos!=-1 && m_src_um.toUpperCase()!="MOSTRAR_RESULTADO" ) {  ***/
                         ////                              
                         if( pos==-1 ) {   
                             ////
                             /// Exclusivo da Tag Select depto para mostrar Tag Select Setor
                             if( m_src_um.toUpperCase()=="DEPTO" ) {
                                 ///
                                 if( document.getElementById("div_setor") ) {
                                     var elds=document.getElementById("div_setor");
                                     var tdisp = elds.style.display;
                                     if( tdisp!="block" ) {
                                          elds.style.display="block";   
                                     }
                                     ////
                                     elds.innerHTML=m_texto_recebido;
                                     ///
                                     return;
                                 }
                             }
                             /***  Final - if( m_src_um.toUpperCase()=="DEPTO" ) {  ***/
                             ///
                         }  
                         /****  Final - if( pos==-1 ) {   ***/ 
                         ////
                     }  
                     /*****  Final - if( msuup=="MOSTRAR_RESULTADO2" || src_maiusc=="SELECIONADO" || msusr!=-1 ) {  ***/
                     ///
                     ///  VERIFICANDO Variavel pos!=-1 ou ..... - alterado em 20171121


   alert(" js/editar_patrimonio_js.php/1943  - 9) pos_clp_mr = "+pos_clp_mr
        +" -- src_maiusc = "+src_maiusc+"  --->>>  val_upper = "+val_upper
        +"  \r\n --> src = "+src+" --> val = "+val+"  -->  m_array = "+m_array
        +"  \r\n m_texto_recebido = "+m_texto_recebido);                     



                     
                     if( pos_clp_mr!=-1 || src_maiusc=="SELECIONADO" ) {
                         ///
                         ///  CASO patrimonio/bem foi selecionado para EDITAR
                         if( src_maiusc=="SELECIONADO"  ) {
                             ///  Desativando ID mostrar_tabela
                             ///  Ocultar ID div_form
                             setTimeout(exoc("div_form",0),3000) ;                     
                             ///  Ativando IDs
                             exoc("mostrar_tabela",1,m_texto_recebido);               
                             /// exoc("div_form",1,m_texto_recebido);               
                             ///                     
                         } else {
                             ////
                             if( document.getElementById("mostrar_tabela") ) {
                                 var elmt=document.getElementById("mostrar_tabela");
                                 var tdisp = elmt.style.display;
                                 if( tdisp!="block" ) {
                                       elmt.style.display="block";                         
                                 }
                                 elmt.innerHTML=m_texto_recebido;        
                                 ///
                             }   
                             /***  Final - if( document.getElementById("mostrar_tabela") ) { ***/
                             ///
                         }
                         ///
                         return;
                         ///
                     }
                     /****  Final - if( pos_clp_mr!=-1 || src_maiusc=="SELECIONADO" ) {  ***/
                     ///
                     ///
                     if( document.getElementById("div_form") ) {
                          if( document.getElementById("mostrar_tabela") ) {
                               var el_mtb=document.getElementById("mostrar_tabela");
                               var tdisp = el_mtb.style.display;
                               if( tdisp!="none" ) {
                                    el_mtb.style.display="none";                         
                               }
                               ////
                          }
                          ///
                          var eldvfr=document.getElementById("div_form");
                          var tdisp = eldvfr.style.display;
                          if( tdisp!="block" ) {
                               eldvfr.style.display="block";                         
                          }
                          ///
                          eldvfr.innerHTML=m_texto_recebido;        
                          ///
                          return;
                          ///
                     }
                     ///  Final - if( document.getElementById("div_form") ) {  
                     ///
                 }
                 /**   Final -   if( pos_src1!=-1 || src_maiusc=="SELECIONADO" ) {  **/       
                 ///
                 

/*****
   alert(" js/editar_patrimonio_js.php/1889 ---->>> INCLUSAO  4) -->> pos_src1 = "+pos_src1
       +"  <<<-->>  src_maiusc = "+src_maiusc+"  <<--- src = "+src+" -  val =  "
       +val+"  -  m_array = "+m_array+"  \r\n m_texto_recebido = "+m_texto_recebido);  
      *****/               
                 
                 
                 
                 /***   INCLUINDO ATRIBUTO DO PATRIMONIO/BEM - SELECIONADO   
                 * Atualizado em 20220812
                 ***/
                 if( src_maiusc=='INCLUIR_ATRIBUTO' ) {
                     ///
                     pos = m_texto_recebido.search("CORRIGIR_ERRO");
                     ///
                     if( pos==-1 ) {
                         ///
                         /// exoc("m_input_sala",1);
                         val2 = val[2];  
                         val3 = val[3];
                         ///
                         ///  Verificando ID  num_atributos  
                         if( document.getElementById('num_atributos') ) {
                             ///
                             /// ID num_atributos - encontrado/Ativo
                             var id_natr = document.getElementById('num_atributos');
                             ///
                         } else {
                             //// Ocorreu ERRO
                             var msgerr="Falha grave elemento ID num_atributos indefinido -";
                             msgerr+="&nbsp;corrigir.";
                             ///
                             alert(msgerr);
                             ///
                             ///  ATIVAR ID label_msg_erro 
                             exoc("label_msg_erro",1,msgerr);                     
                             ///
                             return;
                             ///
                         }
                         ///
                         ///  n_total_atributos += 1;
                         /****
                         var n_tot_atrts = parseInt(document.getElementById('num_atributos').value)+1; 
                         ******/
                         var n_tot_atrts = parseInt(id_natr.value)+1; 
                         id_natr.value.value = parseInt(n_tot_atrts);
                         ///
                         var msgt="Foi acrescentado novo atributo nesse Patrimonio.\nAtributo: ";
                         msgt+=val2+" - Descrição: "+val3;
                         msgt+="\r\n -  Total  de atributos = "+n_tot_atrts;
                         ///
                         alert(msgt);
                         ///
                         /// Desativar alguns campos - Atributo
                         desativar_atributo();
                         ///
                         /*** ATUALIZANDO TABELA DOS ATRIBUTOS  ***/
                         ///  if( document.getElementById('tabela_atributos') ) {
                         if( document.getElementById('tbatrbbem') ) {
                             ///
                             ///  var idtbat=document.getElementById('tabela_atributos');
                             var idtbat=document.getElementById('tbatrbbem');
                             var tdisp =  idtbat.style.display;
                             if( tdisp!="block" ) {
                                   idtbat.style.display="block";   
                             }
                             ///
                             idtbat.innerHTML=m_texto_recebido;
                             ///
                         }
                         ///    
                         ///  Enviando dados para ID num_atributos  
                         id_natr.focus();
                         ///
                         ///
                         ///  Ativando Botoes SALVAR e CANCELAR - Patrimonio/Bem
                         ///
                         var sc_bts_bem=new Array("label_salvar_patrimonio",
                                                  "label_cancelar_patrimonio",
                                                  "m_salvar_patrimonio",
                                                  "m_cancelar_patrimonio");
                         ///
                         var cposlen=sc_bts_bem.length;
                         for( var zt=0; zt<cposlen; zt++ ) {
                             ///
                             var cpo_id_nome=sc_bts_bem[zt];
                             ///
                            if( document.getElementById(cpo_id_nome) ) {
                                ///
                                var elcin=document.getElementById(cpo_id_nome);
                                var tdisp = elcin.style.display;
                                if( tdisp!="block" ) {
                                     elcin.style.display="block";   
                                }
                                ///
                                
                                var tdispd = elcin.disabled; 
                                if( tdispd!=false ) {
                                    elcin.disabled = false;
                                }   
                                ///
                            }
                            ///
                         }
                         /***  Final - for( var zt=0; zt<cposlen; zt++ ) { ***/
                         ///

      
      
                         
                         
                         
                         
                         /***  Atualizar HTML tag Select -  SELECIONAR ATRIBUTO   ****/        
                         dochange("selecionar_atributo");
                         ////
                         return;
                         ///
                     } else if( pos!=-1 ) {
                         ///
                         ////  Ocorreu ERRO
                         if( document.getElementById("label_atributo_incluidos")  ) {
                             ///  Ocultando ID label_atributo_incluidos
                             var idlai=document.getElementById("label_atributo_incluidos");
                             var tdisp = idlai.style.display;
                             if( tdisp!="none" ) {
                                 idlai.style.display="none";   
                             }
                             ///
                         }
                         ///
                         var tab_incluindo_atributos=m_texto_recebido;
                         atributos_length = tab_incluindo_atributos.length;
                         ///
                         /***   Desativando agluns campos - Atributo   ***/
                         desativar_atributo();                      
                         ///
                     }
                     ///        
                 }
                 ///  Final - if( src_maiusc=='INCLUIR_ATRIBUTO' ) {   
                 ///
                 ///   EDITANDO OU REMOVENDO ATRIBUTO   
                 if( src_maiusc=='EDITAR_ATRIBUTO'  || src_maiusc=='REMOVER_ATRIBUTO'  ) {
                      ///
                      pos = m_texto_recebido.search("CORRIGIR_ERRO");
                      if( pos==-1 ) {
                           /// exoc("m_input_sala",1);
                           val2 = val[2];  
                           val3=val[3];
                           ////
                           ///  Verificando ID  num_atributos  
                           if( document.getElementById('num_atributos') ) {
                               ///
                               /// ID num_atributos - encontrado/Ativo
                               var id_natr = document.getElementById('num_atributos');
                               ///
                           } else {
                                //// Ocorreu ERRO
                               var msgerr="Falha grave elemento ID num_atributos indefinido -";
                               msgerr+="&nbsp;corrigir.";
                               ///
                               alert(msgerr);
                               ///
                               ///  ATIVAR ID label_msg_erro 
                               exoc("label_msg_erro",1,msgerr);                     
                               ///
                               return;
                               ///
                           }
                           ///
                           ///  Valor do ID  num_atributos   
                           var  n_tot_atrts = parseInt(id_natr.value);
                           ///
                           if( src_maiusc=='REMOVER_ATRIBUTO' ) {
                                n_tot_atrts -= 1; 
                           }
                           ///  
                           id_natr.value=n_tot_atrts;
                           ///
                           if( src_maiusc=='EDITAR_ATRIBUTO' ) {
                                var msgt="Atributo alterado nesse Patrimonio.\nAtributo: ";
                                msgt+=val2+" - Descrição: "+val3;
                                msgt+=" -  Total  de atributos = "+n_tot_atrts;
                                ///
                                alert(msgt);
                                ///
                           } else if( src_maiusc=='REMOVER_ATRIBUTO' ) {
                                var msgt="Atributo removido nesse Patrimonio.\nAtributo: ";
                                msgt+=val2+" - Descrição: "+val3;
                                msgt+=" -  Total  de atributos = "+n_tot_atrts;
                                ///
                                alert(msgt);
                                ///                                      
                           }
                           ///
                           /***   Desativando agluns campos - Atributo   ***/
                           desativar_atributo();
                           ///
                           /*****
                           if( document.getElementById('tabela_atributos')  ) {
                                if( document.getElementById('tabela_atributos').style.display="none" ) {
                                    document.getElementById('tabela_atributos').value="";
                                     document.getElementById('tabela_atributos').style.display="block";
                                }
                                document.getElementById("tabela_atributos").innerHTML=m_texto_recebido;    
                            } 
                            *****/
                            ///
                            /*** ATUALIZANDO TABELA DOS ATRIBUTOS  ***/
                            if( document.getElementById('tbatrbbem') ) {
                                ////  var idtbat=document.getElementById('tabela_atributos');
                                var idtbat=document.getElementById('tbatrbbem');
                                var tdisp =  idtbat.style.display;
                                if( tdisp!="block" ) {
                                     idtbat.style.display="block";   
                                }
                                ///
                                idtbat.innerHTML=m_texto_recebido;
                                ///
                           }
                           ///
                           ///  Focando no  ID num_atributos   
                            id_natr.focus();
                            ///
                            return;
                            ///
                        } else if( pos!=-1 ) {
                            ///
                            ////  Ocorreu ERRO
                            if( document.getElementById("label_atributo_incluidos")  ) {
                                 ///  Ocultando ID label_atributo_incluidos
                                 var idlai=document.getElementById("label_atributo_incluidos");
                                 var tdisp = idlai.style.display;
                                 if( tdisp!="none" ) {
                                     idlai.style.display="none";   
                                 }
                                 ///
                            }
                            ///
                            var tab_incluindo_atributos=m_texto_recebido;
                            atributos_length = tab_incluindo_atributos.length;
                            ///
                            /***   Desativando agluns campos - Atributo   ***/
                            desativar_atributo();                      
                            ///
                       }
                       ///             
                   }
                   /**  FINAL - if( src=='editar_atributo'  || src=='remover_atributo' )  ***/  
                   ///
                   ///
                   ////  Selecionar ATRIBUTO principal
                   if( src_maiusc=='SELECIONAR_ATRIBUTO' ) {
                       ///
                       ///   ATUALIZADO EM  20220901   
                       ///  Ativando ID slcnratr    
                       exoc("slcnratr",1,m_texto_recebido);                     
                       ///   
                       /*** 
                       *   ATIVAR BOTOES SALVAR E CANCELAR - ATRIBUTO 
                       ***/
       
       
       
                       
                       /****
                        if( document.getElementById("trincatr") ) {
                            var idtbat=document.getElementById("trincatr");
                            var tdisp =  idtbat.style.display;
                            if( tdisp!="block" ) {
                                 idtbat.style.display="block";   
                            }
                       }
                       ****/
                       ///
                                                ///
                         ///  Ativando Botoes SALVAR e CANCELAR - Patrimonio/Bem
                         ///
                         var sc_bts_bem=new Array("label_salvar_patrimonio",
                                                  "label_cancelar_patrimonio",
                                                  "m_salvar_patrimonio",
                                                  "m_cancelar_patrimonio");
                         ///
                         var cposlen=sc_bts_bem.length;
                         for( var zt=0; zt<cposlen; zt++ ) {
                             ///
                             var cpo_id_nome=sc_bts_bem[zt];
                             ///
                            if( document.getElementById(cpo_id_nome) ) {
                                ///
                                var elcin=document.getElementById(cpo_id_nome);
                                var tdisp = elcin.style.display;
                                if( tdisp!="block" ) {
                                     elcin.style.display="block";   
                                }
                                ///
                                
                                var tdispd = elcin.disabled; 
                                if( tdispd!=false ) {
                                    elcin.disabled = false;
                                }   
                                ///
                            }
                            ///
                         }
                         /***  Final - for( var zt=0; zt<cposlen; zt++ ) { ***/
                         ///
                         return;
                         ///
                   }
                   /***  Final - if( src_maiusc=='SELECIONAR_ATRIBUTO' ) {   ***/
                   ///
                   ///  BEM/PATRIMONIO  EDITADO
                   if( src_maiusc=="M_PATRIMONIO_EDITADO" ) { 
                       ///
                       ///  Bem/Patrimonio/Atributos - Alterado                        
                       var pos = m_texto_recebido.search(/CORRIGIR_ERRO|ERRO:|Notice/i);
                       ///
                       if( pos==-1 ) {    
                           ///
                           var campos_by_id=new Array("label_salvar_patrimonio",
                                          "label_cancelar_patrimonio",
                                          "label_patrimonio_incluido","label_msg_erro");
                           ///
                           var cposlen=campos_by_id.length;
                           for( var zt=0; zt<cposlen; zt++ ) {
                                ///
                                var cpo_id_nome=campos_by_id[zt];
                                ///
                                if( document.getElementById(cpo_id_nome) ) {
                                    ///
                                    var elcin=document.getElementById(cpo_id_nome);
                                    var tdisp = elcin.style.display;
                                    if( tdisp!="none" ) {
                                         elcin.style.display="none";   
                                    }
                                    ///
                                }
                                ///
                           }
                           /***  Final - for( var zt=0; zt<cposlen; zt++ ) { ***/
                           ///
                           ///  Mostrando Bem/Patrimonio alterado na DIV id=bem_alterado 
                           ///  Ocultar IDs
                           exoc("p_cabecalho",0);  
                           exoc("hr_cabecalho",0);  
                           exoc("div_form",0);                     
                           ///
                           ///  Ativando IDs
                           exoc("mostrar_tabela",1,m_texto_recebido);                     
                           ///   
                           return;
                           ///
                        } else if( pos!=-1 ) {
                             if( m_texto_recebido.search(/tabela setor/i) != -1 ) {
                                    m_element = "instituicao";       
                             } else if( m_texto_recebido.search(/tabela financiadora/i) != -1 ) {
                                     m_element = "fonteposse";       
                             }
                             msg_erro = msg_erro_ini+m_texto_recebido+final_msg_ini;
                             ///
                             ///  Mensagem de erro ativar
                             if( document.getElementById("label_msg_erro") ) {
                                  var  ellme=document.getElementById("label_msg_erro");
                                  var tdisp = ellme.style.display;
                                  if( tdisp!="block" ) {
                                       ellme.style.display="block";   
                                  }
                                  ///
                                  ellme.innerHTML=msg_erro;
                                  ///
                                  exoc("div_form",0);
                                  ///
                                  src="";
                                  ///
                             }
                             /***  IMPORTANTE: essa function acentuarAlerts
                                       para acentuacao  - alterado em 20171121
                             ***/
                             var terr="ERRO: Patrimonio não alterado - Corrigir.";
                             var mensagem=acentuarAlerts(terr);
                             ///
                             alert(mensagem);
                              ////   alert("ERRO: Patrimonio não alterado - Corrigir.");                             
                        }
                        /// FINAL do IF pos==-1
                   }
                   ///  FINAL DO BEM/PATRIMONIO  EDITADO
                   ///
                 
                 ///  Retornando pagina
                 if( src_maiusc=="RETORNAR_PAGINA" ) {
                     ///
                      var m_juntos_link="<?php isset($_SESSION["m_juntos_link"]) ? print $_SESSION["m_juntos_link"] : print "";?>";  
                      ///
                      parent.location.href=m_juntos_link;
                      return;
                 }
                 ////                             
                 if( typeof src!="undefined" ) {
                     ///
                       if ( src=='chapa_usp' ) {
                           var camada=document.getElementById("mensagem_final"); 
                           camada.style.display="inline"; 
                           camada.style.visibility="visible"; 
                           exoc("mensagem_final",1);
                           src= "mensagem_final";
                       } else if( src=='clp' ) {
                           // exoc("mensagem_final",1); 
                           // src= "mensagem_final";
                           m_texto_recebido = "";
                           m_texto_recebido = m_texto_recebido;    
                               pos = m_texto_recebido.search("Nenhum");
                          if ( pos == -1 ) {    
                                window.location.href=m_texto_recebido;    
                                ///
                            } else {
                                ////
                                exoc("digitar_outro",1);
                                ////
                                var eldigout=document.getElementById("digitar_outro");
                                
                                document.getElementById("digitar_outro").style.display="block";  
                                
                                eldigout.innerHTML=m_texto_recebido;    
                                ////
                           }
                           ////
                       }  
                       ///
                   }
                   ///  Final - if( typeof src!="undefined" ) {   
                   ///
                  
    }; 
    /*** 
        Aqui é enviado mesmo para pagina receber.php 
          usando metodo post, + as variaveis, valores e a funcao   
    ****/
    var conectando_dados = myConn.connect(receber_dados, "POST", poststr, inclusao);   
    /*****  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
          porisso eu coloquei return false no form o php enviar sozinho   
    ****/
    /////
}
/*************   Final - function dochange    ********************************/
///
/***  
*    Envia mensagem para o cabecalho - alterado em 20171121
***/   
var i_exoc=0;
function exoc(id,i_exoc,msg) {
    ///
    ///  Atualizado em 20200801
    ///     Desativando ID
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
        } else {
            ///  Elemento ID nao encontrado
            alert("Elemento ID: "+id+" desencontrado."); 
        }
        ///
    }
    ///  Final  -  Desativando ID
    ///
    ///  Ativando o  ID
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
       } else {
            ///  Elemento ID nao encontrado
            alert("Elemento ID: "+id+" desencontrado."); 
        } 
        i_exoc=0;
    }
    ///  Final - Ativando o  ID
    return;
}
/*********   Final - function exocx(id,i_exoc,msg) {  ******/
///
// document.myForm.myField.onkeypress = keyhandler; 
document.onkeypress = keyhandler;
function keyhandler(e) {
    //    alert(e.which);
    //    if (document.layers) 
    navegador_utilizado();
     //
     //  Caso a tecla for ENTER ou  TAB
     if(  tecla==13  ||  tecla==9  ) {
         validar(m_nome);
     } 
}
//
function limpar_id() {
      document.getElementById('mensagem_final').innerHTML='';
      return;
}
//
///  NAVEGADOR sendo usado no momento
tecla="";m_nome=""; 
function navegador_utilizado() {
    var m_browse_num=0;
    var nome_navegador_index_msi = navigator.appName.indexOf("Microsoft");
    var nome_navegador_index_firefox = navigator.userAgent.indexOf("Firefox");
    var navegador_usado="<?php echo $_SESSION["navegador"];?>";
    var m_submit=""; var m_nome="";
    var pos0 = navegador_usado.search(/IE|CHROME/i);
    //  Melhor maneira de saber qual tecla foi pressionada
    var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    var tecla = keyCode;
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
     //  if( m_nome.toUpperCase()=="MOSTRAR_RESULTADO"  )  {
     if( m_nome!=null ) {
         if( m_nome.search(/^mostrar_resultado/i)!=-1 ) {
             var erro=0; 
             if( typeof(tecla)!="undefined"  ) {
                if( tecla==32 ) {
                    erro=1;   
                } else {
                    // IMPORTANTE - usando na tag INPUT type text  onkeypress e onkeyup
                    var keyASCII=String.fromCharCode(tecla);
                    var valor_recebido=keyASCII;  
                    return false;                                
                }              
             } else erro=1;
             // Verificando se houve erro ou nao
             if( erro==1 ) {
                var keyASCII="";  
                //  var valor_recebido=document.getElementById(m_nome).value;           
                // document.getElementById(m_nome).value=valor_recebido.replace(/^\s+|\s+$/g,"");
                return false;
             } else if( erro<1 && tecla==13  ) {
                 if( trim(valor_recebido)=="" ) {
                    document.getElementById(m_nome).value='*';
                    valor_recebido = document.getElementById(m_nome).value;
                 } 
             }
             //
             validar(m_nome,keyASCII,valor_recebido);
             return;
         }   
     }
      
     return tecla,m_nome;    
}
/*******   FINAL - function navegador_utilizado   ***********/
///
///
///  Opcao selecionada no campo tag Select id campos_tabela
function opcao_selecionada(src,val,m_array) {
         ///
         var campo_nome="";
         var campo_value="";
         ///  Dados desses campos no Array
         /***
         var ocultar_cpos=new Array("inst","instituicao","unid","unidade","depto","departamento","setor");
         ***/
         var ocultar_cpos=new Array(codidinst,codidunid,codiddept,codidseto);
         ///          
         var length_cpos=ocultar_cpos.length;
         for( var que=0; que<length_cpos; que++ ) {
               var cpo_id_name=ocultar_cpos[que];
               if( document.getElementById(cpo_id_name) ) {
                    var nome_campo_id=document.getElementById(cpo_id_name).name;
                    campo_nome+=unescape(nome_campo_id+",");     
                    ///                           
                    /// IMPORTANTE quando o campo conter a virgula global mudar para simbolos
                    var m_element_value=document.getElementById(cpo_id_name).value;
                    var outro_element_value=m_element_value;
                    var trocar_virgula=outro_element_value.replace(/,/g,'|<;=;>|');
                    var elements_val=trocar_virgula;
                    campo_value+=unescape(elements_val+","); 
                    ///
               }
         }
         var cpo_nome = campo_nome.substr(0,campo_nome.length-1);
         var cpo_value = campo_value.substr(0,campo_value.length-1);
         var m_array = cpo_nome+",@#%&@%,"+cpo_value;
         ///           
         return   "data="+unescape(src)+"&val="+unescape(val)+"&campo_nome="+encodeURIComponent(cpo_nome)+"&campo_value="+cpo_value+"&m_array="+encodeURIComponent(m_array);
         ///
}
/**********   FINAL - function opcao_selecionada   ******************/
///
///
////  Salvando alteracao no Patrimonio/Bem
function salvar_patrimonio_bem(m_element) {
    ///
    ///  Verificando variavel m_element
    if( typeof(m_element)=="undefined" ) {
          var m_element="";   
    } 
    ///
    var m_elements_total = document.form.length; 
    ///
    ///  var m_elements_nome = new Array(m_elements_total);
    var m_elements_nome = new Array();
    ///
    ///  var m_elements_value= new Array(m_elements_total);
    var m_elements_value= new Array();
    ///
    ///  Ocultar ID  label_msg_erro 
    /***
    if( document.getElementById("label_msg_erro") ) {
        if( document.getElementById("label_msg_erro").style.display="block" ) {
             document.getElementById("label_msg_erro").style.display="none";
        }     
    } 
    ****/
    exoc("label_msg_erro",0,"");                     
    ///
    var sessaocad='<?php echo $_SESSION['codigo_sessao'];?>';  
    //
    var src = 'm_patrimonio_editado';
    ///
    ///  var url = "editar_bd_patrimonio.php?data="+src;
    var url1="";
    var url2="";
    var campo_nome="";
    var campo_value=""; var m_element_value="";
    var array_datas_id=["notadata","garantiai","garantiaf",
                        "datacompra","instaldata","acaodata","baixadata"];
    ///
    var array_datas_nome=["Nota Data","Garantia Inicial","Garantia Final",
                            "Data Compra","Data da Instalação","Data Ação","Data Baixa"];    
    ///
    ///
    ///  Teste com os principais campos - CONSISTENCIA  - Alterado em 20160916
    /***
    ///  var ary_cps= ["instituicao","unidade","depto","departamento","setor","bloco","sala","coduspresp","grupo","nome","modelo","fonteposse","situacao","acao","acaodata","acaomotivo","baixadata","baixapor","baixamotivo","baixadest"];
    ***/
    var ary_cps= ["instituicao","unidade","depto","departamento","setor",
                                "bloco","sala","coduspresp","grupo","nome","fonteposse",
                                "situacao","acao","acaodata","acaomotivo","baixadata",
                                "baixapor","baixamotivo","baixadest"];
    ///
    ///  Array da SITUACAO
    var situacao_itens=["BAIXA","BAIXADO","DESATIVADO","INOPERANTE","REPARANDO"];
    ///
    ///  Campos que dependem da SITUACAO
    var dependedasituacao = ["acao","acaodata","acaomotivo","baixadata",
                            "baixapor","baixamotivo","baixadest"];
    ///
    ///  AS DATAS QUE PODEM SER COMPARADAS
    var asdatas  = {notadata:'Nota Data Fiscal',garantiai:'Data da Garantia Inicial',
                garantiaf:'Data da Garantia Final',instaldata:'Data da Instalação',
                datacompra:'Data da Compra',acaodata:'Data da Ação',
                baixadata:'Data da Baixa'};
    ///
    /***  Todos os campos do FORM que presentes no array ndatas  
    *      - IMPORTANTE PARA JAVASCRIPT MULTIDIMENSIONAL
    ****/
    var ndatas={};   
    

/*****    
 alert("function salvar_patrimonio_bem/2432  -->> INICIO <<-- m_element = "+m_element+" <<-->> m_elements_total = "+m_elements_total);    
 ****/

    
    ///
    for( z=0; z<=m_elements_total; z++ ) {      
        ///          
        if( document.form.elements[z].name )  {
            var element_nome=document.form.elements[z].name;
        } else {
            continue;
        }
        var  m_id_type=document.form.elements[element_nome].type;
        if( m_id_type!="date" ) continue;
        ///
         element_valor=document.form.elements[element_nome].value; 
         ///
         /// Desativando FOR  na data datacompra
         ndatas[element_nome]=element_valor;
         if( element_nome.toUpperCase()=="DATACOMPRA" ) {
                break;
         } 
        ///
    }
    /// Final - for( z=0; z<=m_elements_total; z++ ) {  
    ///  
    ///  FOR para o total dos elementos no FORM
    var m_erro = false; 
    for( i=0; i<=m_elements_total; i++ ) {   
         ///
         if( i<=m_elements_total ) {
               if( ! document.form.elements[i] ) continue; 
               if( ! document.form.elements[i].name ) continue; 
               if( typeof(document.form.elements[i].name)=="undefined" ) {
                    continue;   
               } 
         }
         ///
         ///          
         var m_id_type=document.form.elements[i].type;
         ///
          ///  m_elements_value[i] = document.form.elements[i].value; 
          switch(m_id_type) {
                case "undefined":
                //  case "hidden":   precisa de dados as vezes              
                case "button":
                case "image":
                case "reset":
                case "submit":
                continue;
          }
          ///  Final - switch(m_id_type) {  
          ///
          ///  if( typeof(document.form.elements[i].name)=="undefined" ) continue; 
          ///   if( ! document.form.elements[i].name ) continue; 
          m_elements_nome[i] = document.form.elements[i].name; 
          nome_campo_id = m_elements_nome[i];
          ///
          
          if( document.form.elements[i] ) {
              ///
              m_elements_nome[i] = document.form.elements[i].name; 
              var nome_campo_id = m_elements_nome[i];         
              ///  m_elements_value[i] = document.form.elements[i].value; 
              /// if ( document.getElementById(nome_campo_id)!="" ) { 
              if( nome_campo_id!="" ) { 
                  ///
                  /***  m_elements_value[i] = document.getElementById(nome_campo_id).value;
                     var m_length = document.getElementById(nome_campo_id).value.length;  
                  ***/                       
                  var ncpoid=document.getElementById(nome_campo_id);
                  m_element_value = trim(ncpoid.value);
                  ///
                  
/****                  
  alert("LINHA/2530 -->> "+i+") nome_campo_id = "+nome_campo_id+"  <-> m_element_value = "+m_element_value);                  
  ****/
                  
                  
                  ///  Numero de caractere no m_element_value 
                  var m_length = m_element_value.length;                          
                  ///
                  if( ( nome_campo_id=='instituicao' ) && ( m_length<1 ) ) {
                         m_erro=true;    
                  } 
                  ///
                  ///  Teste com os principais campos - CONSISTENCIA  
                  if( ary_cps.indexOf(nome_campo_id)!=-1 ) {
                       var opcao=0;
                       ///
                       if( dependedasituacao.indexOf(nome_campo_id)!=-1 ) {
                            ///
                            /**  Caso NAO for nenhum desses itens da SITUACAO  **/
                            var situacao_value = "";
                            if( document.getElementById("situacao") ) {
                                var msit=document.getElementById("situacao");
                                 situacao_value = trim(msit.value);
                            }
                            ///
                            ///  NESSE ITEM CASO A SITUACAO FOR ATIVO 
                            ///   - NAO CONSISTE ARRAY  dependedasituacao        
                            if( situacao_itens.indexOf(situacao_value)==-1 ) {
                                 opcao=1;
                            }
                            ///    
                       }
                       ///    
                       ///  Verificando os campos - consistencia
                       if( opcao==0 ) {
                           var m_nenhum = m_element_value.search(/^nenhum$|^nenhuma$/i);
                           if( m_length<1 || m_nenhum!=-1 ) {
                                 m_erro=true;
                             }    
                       }
                       ///    
                       ///
                  }
                  ///  Final - if( ary_cps.indexOf(nome_campo_id)!=-1 ) {  
                  ///
                  /***     
                        if( ( nome_campo_id=='instituicao' ) && ( m_length<1 ) ) m_erro=true ;
                        if( ( nome_campo_id=='unidade' ) && ( m_length<1 ) ) m_erro=true ;
                        if( ( nome_campo_id=='depto' ) && ( m_length<1 ) ) m_erro=true ;    
                        if( ( nome_campo_id=='setor' ) && ( m_length<1 ) ) m_erro=true ;    
                  ****/
                  ///  var pos_indexof=array_datas_id.indexOf(nome_campo_id);
                  var pos_indexof=nome_campo_id.search(/^(notadata|garantiai|garantiaf|datacompra|instaldata|acaodata|baixadata)$/i);
                  if( pos_indexof!=-1 ) {
                      var ncpoid=document.getElementById(nome_campo_id);
                      var data1 = trim(ncpoid.value);
                      if( ! ( data1=="//" || data1=="" ) ) {
                          ///
                          if( data1.length!=10 ) {
                              ///
                              var nng=' Data inválida <b>'+data1+'</b> digitar novamente';
                              var mensag_erro=acentuarAlerts(nng);
                              /*** msg_erro_aqui=msg_erro_ini+' Data inválida <b>'+data1+'</b> digitar novamente'+final_msg_ini;
                              * ***/
                              msg_erro_aqui=msg_erro_ini+mensag_erro+final_msg_ini;
                              ///
                              ///  Ativar ID label_msg_erro 
                              exoc("label_msg_erro",1,msg_erro_aqui);                     
                              ///
                              var nng="ERRO: Data inválida "+data1+" digitar novamente.";
                              var mensag_erro=acentuarAlerts(nng);
                              ///
                              alert(mensag_erro);
                              ///
                              return document.getElementById(nome_campo_id).focus();
                              ///
                          }
                          ///  Final - if( data1.length!=10 ) {  
                          ///
                      }
                      ///  Final - if( ! ( data1=="//" || data1=="" ) ) {  
                      ///
                      if( data1=="//"  ||  data1=="" ) {
                          document.getElementById(nome_campo_id).value="00/00/0000" ;
                      }
                      ///
                  }
                  ///  Final - if( pos_indexof!=-1 ) {
                  /// 
                  ///
                  if(  nome_campo_id=='clp'   ) {
                       if( m_length<1 ) {
                            m_erro=true;     
                       } else {
                            var m_clp_antigo=m_element_value;
                       }
                  }
                  ///
                  /// TESTE com os campos datas - Garantia  
                  var ncpoidup=nome_campo_id.toUpperCase();
               
    /***
alert("LINHA/2623  -->>  ncpoidup = "+ncpoidup);
    *****/              
                  
                  if( ( ncpoidup=='GARANTIAF' ) && ( m_erro==false ) ) {
                      ///
                      dt_inicial_nome = 'garantiai';
                      dt_final_nome = 'garantiaf';
                      dt_Inicial =  document.getElementById("garantiai").value;
                      dt_Final =   document.getElementById("garantiaf").value;
                      if( dt_Inicial.length<1 && dt_Final.length<1 ) {
                            m_erro=false; 
                      } else {   
                          ///
                          ///  Caso Data Final maior que 9 caracteres - ex.:  02/01/2011 
                          var dt_Final_length= dt_Final.length;
                          if( dt_Final_length>9 ) { 
                              ///
                              m_erro=verificadatas(dt_inicial_nome,dt_final_nome,dt_Inicial,dt_Final);
                              ///   
                              if( m_erro==true ) {
                                  nome_campo_id = "garantiai";
                                  /***  IMPORTANTE: essa function acentuarAlerts
                                                     para acentuacao  - alterado em 20171121
                                  ***/
                                  var terr="\nERRO: PATRIMONIO NÃO INCLUÍDO.\nGarantia corrigir.";
                                  var mensag_erro=acentuarAlerts(terr);
                                  ///
                                  alert(mensag_erro);
                                  ///
                                  document.getElementById(nome_campo_id).focus();
                                  ///
                                  ///  Verificando novamente
                                  verificando_campos(nome_campo_id,m_length_cpo);                
                                  ///
                              }
                              /// Final - if( m_erro==true ) {  
                              ///
                          }
                          ///  Final - if( dt_Final_length>9 ) {   
                          /// 
                      }
                      ///
                  } else if( ( ncpoidup=='DATACOMPRA' ) && ( m_erro==false ) ) {
                      /// 
                      ///  TESTE com a Data da Compra e outras datas
                      ///  NECESSARIO DATA COM 10 CARACTERES
                      ///  dtcompra
                      var nomedtcompraupper=nome_campo_id.toUpperCase();
                      ///
                      ///  var dtcompra = m_elements_value[i];
                      var dtcompra = document.getElementById(nome_campo_id).value;
                      var dtcompra_length =dtcompra.length;
                      if( dtcompra.length==10 ) {
                          ///
                          var resultado = dtcompra.search(/^\d{4}[-]\d{2}[-]\d{2}$/);
                          if( resultado!=-1 ) {
                              ////  var valor2 = dtcompra.replace(/-/g,'');
                              var m_datacompra = dtcompra.replace(/-/g,'');
                          } else {                
                              var dtcx=dtcompra.substring(6,10);
                              var m_datacompra =dtcx+dtcompra.substring(3,5);
                              m_datacompra +=dtcompra.substring(0,2);                   
                              ///                 
                          }   
                          ///                    
                          ///  m_datacompra.setMonth(m_datacompra.getMonth() - 1); 
                          for( key in ndatas ) {
                              ///
                               if( nomedtcompraupper!=key.toUpperCase() ) {
                                   ///
                                   ///  Caso a Data da Compra for Superior
                                   if( ndatas[key].length==10 ) {
                                       ///
                                       var resultado = ndatas[key].search(/^\d{4}[-]\d{2}[-]\d{2}$/);
                                       if( resultado!=-1 ) {
                                           ///
                                           ///  var valor2 = dtcompra.replace(/-/g,'');
                                           var outradata = ndatas[key].replace(/-/g,'');
                                           ///
                                       } else {
                                           ///
                                           var xds=ndatas[key].substring(6,10);
                                           var outradata = xds+ndatas[key].substring(3,5);
                                           outradata += ndatas[key].substring(0,2);
                                           ///
                                       }
                                       ///   
                                       ///  Verifcando a Data da Compra com outras datas
                                       if( outradata<m_datacompra ) {
                                           ///
                                           m_erro=true;
                                           /// Mensagem de erro ativar
                                           var terr="\nERRO: PATRIMONIO NÃO INCLUÍDO.\n";
                                           terr+=asdatas.datacompra+" superior a "+asdatas[key];
                                           ///
                                           alert(terr);
                                           ///
                                           var xerr="\nERRO: PATRIMONIO NÃO INCLUÍDO.\n";
                                           xerr+=asdatas.datacompra+" superior a "+asdatas[key];
                                           ///
                                           exoc("label_msg_erro",1,xerr);
                                           ///   
                                           ///  Indo para a DATA INCORRETA
                                           document.getElementById(key).focus();
                                           ///  
                                       } 
                                       /// Final - if( outradata<m_datacompra ) {  
                                       ///
                                   }
                                   ///  Final - if( ndatas[key].length==10 ) {
                                   ///
                               }
                               /// 
                               ///  Caso encontrado erro cancelar -> for( key in ndatas ) {
                               if( m_erro==true ) break;
                               ///
                          }
                          /// Final - for( key in ndatas ) {    
                          ///
                      } else {
                          ///  Limpando a Data da Compra
                          var dtcompra="" ;
                          var m_datacompra;
                      }
                      ///
                  } else {
                      ///
                      ///  ACONTECEU ERRO EM ALGUM DESSES CAMPOS ABAIXO
                      if( m_erro==true ) {
                          ///
                          var ncpoidup=nome_campo_id.toUpperCase();
                          ///
                          var ncid01=nome_campo_id.substr(0,1);
                          var campo_digitar=ncid01.toUpperCase()+nome_campo_id.substr(1);
                          ///
                          if( ncpoidup=="INSTITUICAO" ) campo_digitar="Instituição";
                          if( ncpoidup=="DEPTO" ) campo_digitar="Departamento";
                          if( ncpoidup=="CLP" ) campo_digitar="CLP";
                          if( ncpoidup=="SALATIPO" ) campo_digitar="Sala Tipo";
                          if( ncpoidup=="CODUSPRESP" ) campo_digitar="Nome_Responsável";
                          if( ncpoidup=="FONTEPOSSE" ) campo_digitar="Fonte de Posse";
                          if( ncpoidup=="ACAODATA" ) campo_digitar="Data Ação";
                          if( ncpoidup=="ACAOMOTIVO" ) campo_digitar="Ação Morivo/Detalhamento";
                          if( ncpoidup=="BAIXAPOR" ) campo_digitar="Baixa por";
                          if( nome_campo_id.search(/situacao/ui)!=-1 ) {
                                campo_digitar="Situação Atual";                        
                          }
                          ///
                          var pos_sel=nome_campo_id.search(/instituicao|unidade|depto|setor|coduspresp|grupo|fonteposse|situacao/ui);
                          ///
                          /***  IMPORTANTE: essa function acentuarAlerts
                                             para acentuacao  - alterado em 20171121
                          ***/
                          var campo_digitar=acentuarAlerts(campo_digitar); 
                          if( pos_sel!=-1 ) {
                              var terr="\nERRO: PATRIMONIO NÃO INCLUÍDO.\nFaltando incluir: ";
                              var mensag_erro=acentuarAlerts(terr);
                              ///
                              alert(mensag_erro+campo_digitar);
                              ///
                          } else {
                              ///
                              var terr="\nERRO: PATRIMONIO NÃO INCLUÍDO.\nFaltando digitar: ";
                              var mensag_erro=acentuarAlerts(terr); 
                              ///
                              alert(mensag_erro+campo_digitar);
                              ///
                          }
                          ///
                          ///  Verificando novamente
                          document.getElementById(nome_campo_id).focus();                         
                          ///
                          verificando_campos(nome_campo_id,m_length_cpo);    
                          ///
                      }
                      ///  Final - if( m_erro==true ) { 
                      ///   
                  }  
                  /*** FINAL -> if( ( nome_campo_id.toUpperCase()=='GARANTIAF' ) && ( m_erro==false ) ) {  
                  * 
                  ***/
                  ///
                  /// Visualizar m_erro 
                  /***
                     if( m_erro==true ) {
                           ///  alert("ERRO: PATRIMONIO NÃO ALTERADO.\nFaltando digitar: "+nome_campo_id.substr(0,1).toUpperCase()+nome_campo_id.substr(1));
                           ///  document.getElementById(nome_campo_id).focus();
                           var resultado =  verificando_campos(nome_campo_id,m_length);                
                           if( resultado==false  ) {
                                break;   
                           } else {
                                m_erro=false;    
                           }
                     } 
                  ****/
                  ///
                  ///   NAO HOUVE ERRO
                  if( m_erro==false ) {
                      ///
                      /*** ATUALIZADO EM  20220823    ***/
                      /// Alterar campo ID DEPTO
                      if( nome_campo_id.search(/^depto$|^cpodepto$|^iddept/ui)!=-1 ) {
                           nome_campo_id=codiddept;                        
                      }
                      ///
                     /***
                      *  IMPORTANTE quando o campo conter a virgula global mudar para simbolos
                      ***/
                      var outro_element_value=m_element_value;
                      var trocar_virgula=outro_element_value.replace(/,/g,'|<;=;>|');
                      var elements_val=trocar_virgula;
                      campo_nome+=unescape(nome_campo_id+",");  
                      campo_value+=unescape(elements_val+","); 
                      ///
                      temporario = unescape("%26"+nome_campo_id+"=")+m_element_value;
                      url2 += temporario;
                      ///
                  }
                  ///  FINAL - if( m_erro==false ) {
                  ///
               }
               // FINAL -  if( nome_campo_id!="" ) {  
          }   
          /// Final - if( document.form.elements[i] ) {  
          ///
          if( m_erro==true ) break;          
          ///  
     }  
     ///  FINAL DO IF for( i=0; i<=m_elements_total; i++ )
     ///
     if( m_erro==false )  {
         /****   url2 += unescape("%26sessaocad=")+sessaocad;
                 url2 += unescape("%26m_clp_antigo=")+m_clp_antigo;  
         ****/
         ///
         url2 = sessaocad+"#"+m_clp_antigo;
         ///
         ///  url2 += unescape("%26m_clp_antigo=")+m_clp_antigo;
         ///
          
          var cpo_nome = campo_nome.substr(0,campo_nome.length-1);
          var cpo_value = campo_value.substr(0,campo_value.length-1);
          /// url += url2;
          var url1 = cpo_nome+",@#%&@%,"+cpo_value;
          /// 
          if( m_element=='m_salvar_patrimonio' ) {
              ///
               ///  Enviando para o arquivo  AJAX - para EDITAR
               
/******
 alert("function salvar_patrimonio_bem/2432  -->> FINAL  <<-- m_element = "+m_element+" <<-->> m_elements_total = "+m_elements_total+"\r\n url1 = "+url1+"  -->> url2 = "+url2);    
 *****/

               
               
              dochange('m_patrimonio_editado',url1,url2);
              ///
          }
          /**** Final - if( m_element=='m_salvar_patrimonio' ) {  ****/
          /// 
    }       
    ///
}   
///  FINAL - IF  Salvar Patrimonio          
///           
/*****  function validar   ******/
function validar(m_element,m_element_value,val_mres) {       
     ///
     /***
     *      Atualizado em 20230807
     *     Caso a tecla for Backspace
     ***/
     var key = event.keyCode || event.charCode;
     if( key == 8 ){
        ///  backspace pressed 
        if( document.getElementById(val_mres) ) {
            var cpoele = document.getElementById(val_mres);
            var strval = trim(cpoele.value);
            var clen = strval.length-1;
            var valor = "";
            if( parseInt(clen)>0 ) {
                var valor = strval.substring(0,clen);    
            }
            ///
            cpoele.value=valor;
         ////   document.getElementById(val_mres).value=valor;
            cpoele.innerHTML=valor;
            cpoele.focus();
          ///  document.getElementById(val_mres).click();
            ///
            ///  Limpar mensagem de erro
            exoc("label_msg_erro",0,""); 
            ///
            /// Atualizando valor
            var m_element_value=valor;
            ////  return;
        }
        ///
     }
     ///  Final - tecla Backspace
     ///
     /// Verificando se a function exoc existe 
     if( typeof exoc==="function" ) {
          ///  Ocultando ID  e utilizando na tag input comando onkeypress
          exoc("label_msg_erro",0);  
     } else {
           /***  IMPORTANTE: essa function acentuarAlerts
                 para acentuacao
           ***/
           var mtxt="funcion exoc inexistente - ADMINISTRADOR CORRIGIR.";
           var mensagem=acentuarAlerts(mtxt);
           ///
           alert(mensagem);
           ///
           return;        
     }
     ///
     /// Verificando elemento principal - atualizado em 20171123
     if( typeof(m_element)=="undefined" ) {
          ///  Ativar ID  e utilizando na tag input comando onkeypress
          var txterr="ERRO: Falha grave elemento não foi definido.";
          var mensagem=acentuarAlerts(txterr);
          exoc("label_msg_erro",1,mensagem);  
          return;
     }
     ///  Final - if( typeof(m_element)=="undefined" ) {  
     ///
    ///
     if( typeof(m_element_value)=="undefined" ) {
          var m_element_value="";   
     } 
     ///
     if( typeof(val_mres)=="undefined" ) var val_mres="";
     ///
     
     
/*******
  alert(" js/editar_patrimonio_js.php/1314 -> INICIO validar  --->>> "
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
***************/
     
     
     

     ///
     var m_element_length=0;
     ///
     /// Caso variavel m_element definida/ativa
     if( typeof(m_element)!="undefined"  ) {
         ///
         /// N. de caracteres no valor do campo
         var m_element_length = m_element_value.length;
         ///
         /*** Verifica se ID m_element existe  OU  campo ID lc_clp selecionado  ****/
         var xv=val_mres.search(/lc_clp|lc_setor/ui);

/******
  alert(" js/editar_patrimonio_js.php/3209 -> validar  1)  -> xvh = "+xv
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
*******************/



         if( document.getElementById(m_element) || xv!=-1 ) {
             ///
             var procd='/^clp$|instituicao|unidade|depto|setor|^lc_setor$';
             procd+='|mostrar_resultado|orientador|ano_inicial/ui';
             /***
             var pos_search=m_element.search(/^clp$|instituicao|unidade|depto|setor|^lc_setor$|mostrar_resultado|orientador|ano_inicial/i);
             ***/
             var pos_search=m_element.search(procd);
             ///
             
             
/*****
  alert(" js/editar_patrimonio_js.php/3225 -> validar  2)  -> pos_search =  "+pos_search
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
      **************************************/

                          
             
             
             if( m_element=='m_descr_adic' ) {
                 m_element_value  = document.getElementById(m_element).checked;
                 ///
             } else if( m_element.search(/^atributo|^m_botao_atributo/i)!=-1  )  {
                 ///
                 var mel=document.getElementById(m_element);
                 if( m_element=='m_botao_atributo' ) {
                     m_element_value=mel.checked;    
                 } else {
                      m_element_value=mel.value;   
                 }
                 verificando_campos(m_element,m_element_value);
                 ///
                 return;
                 ///
             } else if( pos_search!=-1 ) {
                 ///
                 /// Verificando as Tags Selects depto, setor/lc_setor
                 var achou=m_element.search(/depto|setor|^lc_setor$/ui);
                 ///
                 
                 
/****************
  alert(" js/editar_patrimonio_js.php/3005 -> validar  2) -->> achou =  "+achou
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
 ***********/
                                  
                 
                 
                 ///  Caso achou
                 if( achou!=-1 ) {
                     ///
                     /// DIV 
                     if( document.getElementById("div_mostrar_resultado") ) {
                         /***
                            if( document.getElementById("div_mostrar_resultado").style.display=="block" ) { 
                                 document.getElementById("div_mostrar_resultado").style.display="nome";
                            } 
                            if( document.getElementById("div_mostrar_resultado").visibility=="visible" ) { 
                                 document.getElementById("div_mostrar_resultado").style.visibility="hidden";
                            } 
                         ***/   
                         exoc("div_mostrar_resultado",0);
                         ///
                     }    
                     ///  FIm da DIV
                     ///
                     ///
                     var posa = m_element.search(/setor|codsetor/ui);
                     var posb = val_mres.search(/setor|codsetor/ui);
                     if( posa!=-1 && posb!=-1 ) {
                         ///
                         cposdeptosetor(m_element,m_element_value,val_mres);
                         return;
                         ///
                     }
                     ///  FINAL - if( posa!=-1 && posb!=-1 ) {
                     ///    
                     ///  Caso exista o campo clp -  limpar
                     var bem_sel = {a:"clp", b:"lc_clp", c:"m_clp"}; 
                     var xzp;
                     for( xzp in  bem_sel ) {
                          var idclp = bem_sel[xzp];
                          ///  if( document.getElementById("clp") ) {
                          if( document.getElementById(idclp) ) {
                               document.getElementById(idclp).value="";
                          }    
                     }
                     ///  Final - for( xzp in  bem_sel ) {  
                     ///
                     ///  Ocultando a lista do resultado
                     var pos_editando=val_mres.search(/editando/i);    
                     
/**********************
  alert(" js/editar_patrimonio_js.php/3289   --> validar  -->> DENTRO  pos_editando =  "+pos_editando
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
  ****************/        


                     
                     
                     if( pos_editando==-1 ) {
                         ///
                         /***  Desativando campo ID campos_tabela  e Ocultando outros  ***/
                         var psetor=m_element.search(/setor|m_setor|^lc_setor$/ui);
                         
                         
/******************************
  alert(" js/editar_patrimonio_js.php/3073 -> validar  3)  -->> psetor =  "+psetor
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
  ************************/
             
                         
                         /***  Verifica caso encontrou elemento ID SETOR  ***/
                         if( psetor!=-1 ) {
                             ///
                             if( document.getElementById("campos_tabela") ) {
                                 var idct=document.getElementById("campos_tabela");
                                 var tdisp = idct.style.display;
                                 if( tdisp!="block" ) {
                                      idct.style.display="block";   
                                 }
                                 idct.options[0].selected=true;
                                 idct.options[0].selectedIndex=0;
                                 idct.focus();  
                                 ///
                                 ///  Ocultando o campo ID mostrar_resultado
                                 exoc("mostrar_resultado",0,"");                     
                                 ///
                                 ///  Ocultando botao ? para informar
                                 exoc("td_mostrar_resultado",0,"");                     
                                 ///          
                             }    
                             ///
                             return;
                         }
                         ///  Final - if( psetor!=-1 ) {  
                         ///
                     }
                     /// Final - verificando Tags Selects 
                     ///
                 }
                 ////  Final - if( achou!=-1 ) {
                 ///
                 /******
                 *         Atualizado em 20230815
                 *           Verificando caso 
                 *     for m_element = mostrar_resultado ou  mostrar_resultado2
                 *****/
                 ///  
                 var posmrs = m_element.search(/^mostrar_resultado/ui);
                 if( posmrs!=-1 ) {
                     ///
                     ///  Elemento ID m_element
                     var m_src_um = m_element; 
                     ///
                     /// Valor do elemento 
                     var m_element_value = trim(m_element_value.trim());
                     /// Caso valor do elemento for NULO/VAZIO
                     if( m_element_value=="" ) { 
                          ///
                          /// Caso for campo ID mostrar_resultado2
                          if( m_src_um.toUpperCase()=="MOSTRAR_RESULTADO2" ) {
                              ///
                              var idmr2=document.getElementById(m_src_um);
                              var valid = trim(idmr2.value); 
                              document.getElementById(m_src_um).value=valid;
                              var trs="Digitar novamente";
                              var result = msg_erro_ini+trs+final_msg_ini;  
                              ///
                              document.getElementById(m_src_um).focus();
                              ///
                              return false;
                              ///
                          }
                          ///    
                          /***
                          *    Atualizado em 20211021
                          *       Ocultando IDs
                          ***/
                          var ocultarids = new Array("mostrar_resultado2","mostrar_tabela");
                          /***   function idsocultar   ***/
                          idsocultar(ocultarids);
                          ///  
                          ///  Primeira letra da Tabela como Maiuscula   
                          var resto = nome_tb.length-1;
                          var minusc=nome_tb.substr(1,resto).toLowerCase();
                          var tb_nome1L = nome_tb.charAt(0).toUpperCase()+minusc;
                          /// 
                          /// Caso Tabela for hpadrao
                          if( tb_nome1L.search(/bem/ui)!=-1 ) {
                              tb_nome1L="Patrimonio";
                          }
                          /***  Final - if( tb_nome1L.search(/bem/ui)!=-1 ) {  ***/
                          ///
                          var trs="Digitar ou Selecionar "+tb_nome1L;
                          ////   var result = msg_erro_ini+trs+final_msg_ini;  
                          var result = msg_ok_ini+trs+final_msg_ini;  
                          ///
                          /// Quando acontece erro ou nao existe dados    
                          ///
                          var delay=1000; /// 3 segundos
                          setTimeout(function() {
                                /// O codigo para ser executado depois de  3 segundos 
                                /// Mensagem de erro ativar e receber informacao
                                exoc("label_msg_erro",1,result);
                          },delay);
                          ///
                          /***  Volta para retornar ao campo origem  ***/
                          document.getElementById(m_src_um).focus();
                          ///
                          return  false;
                          ///
                          if( typeof(valor_mostrar_resultado)!="undefined" ) { 
                                var m_element_value=valor_mostrar_resultado;
                          } else {
                              ///
                              if( document.getElementById("mostrar_tabela") ) {
                                   var xnd = document.getElementById("mostrar_tabela");
                                   var m_element_value=xnd.value;
                              }
                              ///
                          }
                          ///
                     }
                     ///  Final - if( m_element_value=="" ) {   
                     ///
                     /// Caso for campo ID mostrar_resultado
                     if( m_src_um.toUpperCase()=="MOSTRAR_RESULTADO" ) {
                          ///
                          /// Variavel idmr do campo ID mostrar_resultado  
                          var idmr=document.getElementById("mostrar_resultado");
                          ///
                          ///   Atualizado em 20211014   
                          var elval=idmr.value; 
                          ///  Verifica busca come esses simbolos
                          var patt = /,|#/ui;
                          if( elval.match(patt) ) {
                               ///
                               var result = elval.match(patt);   
                               ///  
                               /// Enviando mensagem de erro
                               var err_msg = "Não aceita "+result;
                               ///
                               /// Enviando mensagem de erro
                               exoc("label_msg_erro",1,err_msg);  
                               ///
                               var delay=3000; /// 2 segundos
                               setTimeout(function(){
                                    alert(err_msg);
                                    /// O codigo para ser executado depois de  3 segundos 
                               },delay);
                               ///
                               idmr.value="";
                               ///  idmr.InnerHTML="";
                               idmr.focus();
                               ///
                               ///  Desativar Tabela de resultados - Ocultar
                               exoc("mostrar_tabela",0);  
                               ///
                               return;
                               ///
                          }
                          ///  Final - if( elval.match(patt) ) {
                          ///                      
                      }
                      /// Final - if( m_src_um.toUpperCase()=="MOSTRAR_RESULTADO" ) {  
                      ///
                 }
                 ///  Final - if( posmrs!=-1  ) {
                 ///
             }
             ///                 
         }
         /***  Final - if( document.getElementById(m_element) || xv!=-1 ) {  ***/
         ///
      } else {
          m_element=""; 
      } 
      ///  Final - if( typeof(m_element)!="undefined"  ) 
      ///
      ///
      ///  Definindo a Tabela principal    
    ////      var  nometb="<php  echo $_SESSION["tabpri"];?>";                
     /***
     *         Atualizado
     *     Verificar ID do Select Depto ou Setor
     ***/
     var posa = m_element.search(/depto|codiddept|setor|codsetor/ui);
     var posb = val_mres.search(/depto|codiddept|setor|codsetor/ui);
     
     


  alert(" js/editar_patrimonio_js.php/3529 -> validar INICIO --->>  1)  -->>   "
        +" nometb = "+nometb+"  <<<---  posa = "+posa+" -->> posb = "+posb
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  


     
     ///
     if( posa!=-1 && posb!=-1 ) {
          ///
          ///   Select do campo DEPTO
          ///
          var m_mostrar_result = "";
          var m_array  = "";
          ///
          /// Verifica caso Select for SETOR
          var xid = (/^setor|codsetor|codidseto/ui);
          /// var posids =  src[1].toString().search(xid); 
          var posids =  m_element.search(xid); 
          ///
          
 
/*******************
  alert(" js/editar_patrimonio_js.php/3551  -->>   validar  2)  -->>  posids = "+posids
        +" <<-->> nometb = "+nometb+"  <<<---  url_central = "+url_central+"  <<<--- posa = "+posa+" -->> posb = "+posb
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
  *******************/

         
          
          
          if( posids==-1 ) {
              ///
              ///   Caso NAO for Select SETOR
              ///  Ocultar Select Setor
              var array_campos = new Array("setor","codsetor","codiddept");
              ///
              var lenarr = array_campos.length;
              for( nx=0; nx < lenarr; nx++ ) {
                   var campo_do_array = array_campos[nx];
                   if( document.getElementById(campo_do_array) ) {
                        var nxid = document.getElementById(campo_do_array);
                        var tdisp = nxid.style.display;
                        if( tdisp!="none" ) {
                            nxid.style.display="none";   
                        }
                        ///
                   }     
              }
              ///  Final -  Ocultar Select Setor
          }
          ///  Final - if( posids==-1 ) {
          ///
          ///  Definindo valores das variaveis 
          var instituicao="Todas"; var unidade="Todas";  
          var departamento="Todos"; 
          var setor="Todos";
          ///
          /// Nome da coluna  INSTITUICAO  da Tabela setor
          /// if( document.getElementById("instituicao") ) {
          var pn=(/instituicao|codinstituicao|codidinst/i);
          var pinst = m_element.search(pn); 
          ///
          if( document.getElementById(codidinst) ) {
               ///
                var tmpc = document.getElementById(codidinst);
                instituicao=trim(tmpc.value);
                if( instituicao.length<1 ) instituicao="Todas"; 
                ///
                /// Valor dos campos para variavel m_mostrar_result
                ///  m_mostrar_result+=instituicao+"#";
                    m_mostrar_result1=instituicao+"#";
                   /// Nome dos campos para variavel m_array
                   ///  m_array+=codidinst+"#";   
                     m_array1=codidinst+"#";  
                   ///  
          }
          ///  Final - if( document.getElementById(codidinst) ) {
          ///
          /// Nome da coluna UNIDADE  da Tabela  
          /// if( document.getElementById("unidade") ) {
          var pn=(/unidade|codunidade|codidunid/i);
          var punid = m_element.search(pn);   
          if( document.getElementById(codidunid) ) {
                var tmpc = document.getElementById(codidunid);
                unidade=trim(tmpc.value);
                   if( unidade.length<1 ) unidade="Todas"; 
                   m_mostrar_result2=unidade+"#";
                   m_array2=codidunid+"#";  
          } 
          /// Final - if( document.getElementById(codidunid) ) {
          ///
          /// Nome da coluna DEPTO/DEPARTAMENTO da Tabela  
          ///  if( document.getElementById("departamento") ) {
          ///  var pn=(/departamento|coddept|codiddept/i);
          var pn=(/departamento|coddept|codiddept|depto/ui);
          var pdept = m_element.search(pn);   
          ////
          ///
          if( document.getElementById(codiddept) ) {
              ///
              var tmpcd = document.getElementById(codiddept);
              var tdisp = tmpcd.style.display;
              if( tdisp!="none" ) {
                  departamento=trim(tmpcd.value);
                  if( departamento.length<1 ) {
                       departamento="Todas";     
                  }
                  ///
                  /// Valor dos campos para variavel m_mostrar_result
                  m_mostrar_result3=departamento+"#"; 
                  ///
                  /// Nome dos campos para variavel m_array
                  m_array3=codiddept+"#";  
                  ///
              }
              ///
          } 
          /// Final -  if( document.getElementById(codiddept) ) { 
          ///
           
           
  /*****
  alert(" js/editar_patrimonio_js.php/1752 -> validar  INICIO  -->>  m_mostrar_result3 = "
           +m_mostrar_result3+"  -->>  m_array3 = "+m_array3
        +" <br/> -->> nometb = "+nometb+"  <<<---  url_central = "+url_central
        +"  <<<--- posa = "+posa+" -->> posb = "+posb
        +"  <<--  m_element = "+m_element+" - m_element_value ="+m_element_value
        +"  --  val_mres = "+val_mres);  
        ****/

           
           
           
           /// Nome da coluna SETOR da Tabela  
           var pn=(/setor|codseto|codidseto/ui);
           var pseto = m_element.search(pn);   
           if( document.getElementById(codidseto) ) {
                 ///
                 var tmpcd = document.getElementById(codidseto);
                 var tdisp = tmpcd.style.display;
                 if( tdisp!="none" ) {
                       setor=trim(tmpcd.value);
                       if( setor.length<1 ) setor="Todos";  
                       /// Valor dos campos para variavel m_mostrar_result
                       m_mostrar_result4=setor+"#"; 
                       ///
                       /// Nome dos campos para variavel m_array
                        m_array4=codidseto+"#";  
                        ///
                 }
                 ///
           } 
           /****    Final - if( document.getElementById(codidseto) ) {  ****/
           ///
           /// 1 - Select INSTITUICAO
           if( pinst!=-1 ) {
                m_mostrar_result+=m_mostrar_result1;
                m_array+=m_array1;   
           }
           /// 2 - Select UNIDADE
           if( punid!=-1 ) {
                 m_mostrar_result+=m_mostrar_result1+m_mostrar_result2;
                  m_array+=m_array1+m_array2;   
           }
           ///
           /// 3 - Select DEPTO
           if( pdept!=-1 ) {
                 m_mostrar_result+=m_mostrar_result1+m_mostrar_result2;
                 m_mostrar_result+=m_mostrar_result3;
                 m_array+=m_array1+m_array2;  
                 m_array+=m_array3; 
           }
           ///
           /// 4 - Select SETOR
           if( pseto!=-1 ) {
                 m_mostrar_result+=m_mostrar_result1+m_mostrar_result2;
                 m_mostrar_result+=m_mostrar_result3+m_mostrar_result4;
                 m_array+=m_array1+m_array2+m_array3;  
                 m_array+=m_array4; 
           }
           /*****   FINAL dos Selects Instituicao,  Unidade,  Depto e Setor   ****/
           ///
           ///    Campo Slect ID  campos_tabela
           if( document.getElementById("campos_tabela") ) {
                ///
                /// IMPORTANTE - Javascript - Voltando para o inicio da tag Select
                var zelem = document.getElementById("campos_tabela");
                zelem.options[0].selected=true;
                zelem.options[0].selectedIndex=0;  
                ///
                ///  Ocultano ID mostrar_resultado ou mostrar_resultado2
                var xarray = ["mostrar_resultado","mostrar_resultado2"];
                ///
                for( xn=0;xn<xarray.length; xn++ ) {
                     ///  Ocultando IDs desse Array xarray
                     if( document.getElementById(xarray[xn]) ) {
                          var xmr = document.getElementById(xarray[xn]);
                          var tdisp = xmr.style.display;
                          if( tdisp!="none" ) {
                              xmr.style.display="none";   
                          }
                     }
                     ///    
                }
                /****  Final - for( xn=0;xn<xarray.length; xn++ ) {  ****/
                ///
                ///  Ocultano ID td_mostrar_resultado
                if( document.getElementById("td_mostrar_resultado") ) {
                     var xqo = document.getElementById("td_mostrar_resultado");
                     var tdisp = xqo.style.display;
                     if( tdisp!="none" ) {
                         xqo.style.display="none";   
                     }
                     /****
                   document.getElementById("td_mostrar_resultado").style.display="none";
                   ***/
                }
                ///
           } 
           ///  Final -  if( document.getElementById("campos_tabela") ) {
           ///
           ///  var m_mostrar_result=instituicao+"#"+unidade+"#"+departamento;      
           var nrx = m_mostrar_result.lastIndexOf("#"); 
           if( nrx!=-1 ) {
              var  m_mostrar_result = m_mostrar_result.substring(0,nrx);   
           } 
           ///
           var nrx = m_array.lastIndexOf("#"); 
           if( nrx!=-1 ) {
              var  m_array = m_array.substring(0,nrx);   
           } 
           ///
           ///
           if( m_mostrar_result.length<1 ) {
               m_mostrar_result=m_element_value;  
           } 
           ///
           /// Definindo Array com a Tabela e variavel 
           var array=[nometb,m_element];  
           ///
           ///  Enviando dados para outra function dochange


alert(" js/editar patrimonio_js/3794  -->> function validar --->> FINAL 1) -->> nometb = "
       +nometb+"  <<-- m_element = "+m_element+"  -- m_element_value = "
       +m_element_value+" \r\n  -->>  array = "
       +array+"  -- m_mostrar_result = "+m_mostrar_result);  



           dochange(array,m_mostrar_result,m_array);
           ///
           return;
           ///
     }
     ///  Final - if( posa!=-1 && posb!=-1 ) {
     ///
     ///   Definindo Tabela principal 
     if( nometb.toUpperCase()=="PATRIMONIO" ) {
          nometb="bem";  
     } 
     ///


     /**********************
alert(" js/editar patrimonio_js/3813  -->> function validar --->> FINAL DEPOIS DO DOCHANGE()  -->> nometb = "
       +nometb+"  <<-- m_element = "+m_element+"  <<-->> m_element_value = "
       +m_element_value+" \r\n val_mres = "+val_mres+"  --->>>  posids = "+posids);  
      *************************/
       


      /****  Caso for diferente do campo ID MOSTRAR_RESULTADO   *****/
      if( m_element.toUpperCase()!="MOSTRAR_RESULTADO" ) {
           ///
           /***
           *    Desativando os campos - Select campos_tabela e Tag text td_mostrar_resultado
           ****/
           ///   Ocultando a Lista de registros 
           exoc("mostrar_tabela",0,"");                     
           ///
           ///  Ocultar campo do Setor
           var bem_sel = {a:"setor", b:"lc_setor", c:"m_setor"}; 
           var xzp;
           for( xzp in  bem_sel ) {
                var idsetor = bem_sel[xzp];
                ///  if( document.getElementById("clp") ) {
                if( document.getElementById(idsetor) ) {
                    ///
                    /// document.getElementById(idsetor).value="";
                    /*****************
                        document.getElementById(idsetor).options[0].selected=true;
                        document.getElementById(idsetor).options[0].selectedIndex=0;  
                    ************************/
                     
                     var cpotype=document.getElementById(idsetor).type;
                     if( cpotype.toUpperCase()=="SELECT-ONE" ) {
                         ////
                         /*** IMPORTANTE - Javascript - Voltando para o inicio da tag Select
                         ****/
                         var cin=document.getElementById(idsetor);
                         cin.options[0].selected=true;
                         cin.options[0].selectedIndex=0;  
                         ///
                     }
                     /****  Final - if( cpotype.toUpperCase()=="SELECT-ONE" ) {  *****/
                     ///
                }    
                /****  Final - if( document.getElementById(idsetor) ) {   ****/
                ///
           }
           /****   Final - for( xzp in  bem_sel ) {  *****/
           ///
           /*****  Ocultando o campo de Selecionar propriedades da Tabela    ****/
           if( document.getElementById("campos_tabela") ) {
               ///
               /****  IMPORTANTE - Javascript - Voltando para o inicio da tag Select  *****/
               var cpostb = document.getElementById("campos_tabela");
               var cpotype=cpostb.type;  
               if( cpotype.toUpperCase()=="SELECT-ONE" ) {
                    ///
                    /*** IMPORTANTE - Javascript - Voltando para o inicio da tag Select
                    ****/
                    cpostb.options[0].selected=true;
                    cpostb.options[0].selectedIndex=0;  
                    ///
               }
               /****  Final - if( cpotype.toUpperCase()=="SELECT-ONE" ) {  *****/
               ///
               /*********
               *         document.getElementById('campos_tabela').options[0].selected=true;
               *         document.getElementById('campos_tabela').options[0].selectedIndex=0;  
               ***************/
                var tdisp = cpostb.style.display;
                if( tdisp!="none" ) {
                    cpostb.style.display="none";   
                }
                ///
           } 
           /****   Final - if( document.getElementById("campos_tabela") ) {  *****/
           ///           
           ///  Ocultando o campo ID mostrar_resultado
           exoc("mostrar_resultado",0,"");                     
           ///
           ///  Ocultando botao ? para informar
           exoc("td_mostrar_resultado",0,"");                     
          ///          
      }    
      /*****   Final - if( m_element.toUpperCase()!="MOSTRAR_RESULTADO" ) {  ****/
      ///
      ///  Campos para Selecionar -  Tags - Text ou Select - alterado em 20230815
      var pos_campos="";                 
      var pos_element=m_element.search(/^clp$|^instituicao$|^unidade$|^depto$|^codiddept|^coddept|^setor$|^lc_setor$|^mostrar_resultado$|^mostrar_resultado2$|^orientador$/ui);     

      
/******************
alert(" function validar -->> LINHA/3906 -->> 1) pos_element = "+pos_element
        +"   <<--- m_element = "+m_element+"  <<-->> m_element_value = "
        +m_element_value+"  --- m_element_length = "+m_element_length);      
   *****************/
      
      
      /*****  if( m_element=='mostrar_resultado'  ||  m_element=='mostrar_resultado2' ) {  ****/
      if( pos_element!=-1 ) {
          ///
          var m_mostrar_result="";          
          if( document.getElementById('mensagem_final') ){
               var xmf = document.getElementById('mensagem_final');
               var tdisp =  xmf.style.display;
               if( tdisp!="none" ) {
                    xmf.style.display="none";                         
               }
               ///
          } 
          ///
          /***   Verificando value do mostrar_resultado2  ****/                      
          if( parseInt(m_element_length)>=1 ) { 
                ///
                var pos_campos=/^clp$|^instituicao$|^unidade$|^depto$|^setor$|^lc_setor$|^mostrar_resultado$|^mostrar_resultado2$/ui;
                var achou = m_element.search(/^mostrar_resultado_desativado$/ui);
                ///
                
/********************
 alert(" js/editar_patrimonio_js.php/3934  ->>> validar  OITAVO  -->> achou = "+achou
         +" ---   m_element="+m_element+"  <<<--- m_element_value ="+m_element_value
         +" -->> m_element_length = "+m_element_length+"  <<<--  val_mres = "+val_mres);
  ***************************/
                
                
                
                if( achou!=-1 ) { 
                    ///
                    /***   
                    *           ATUALIZADO EM  20230815
                    *     var m_mostrar_result= trim(document.getElementById('mostrar_resultado').value);   
                    ***/
                    ///
                    /// document.getElementById('mostrar_resultado2').value  = "";  
                    if( document.getElementById('mostrar_resultado') ) {
                         var msres = document.getElementById('mostrar_resultado');  
                         var m_mostrar_result= trim(msres.value);     
                         ///
                    } else if( document.getElementById('mostrar_resultado2') ) {
                        ///  var zkl = document.getElementById('mostrar_resultado2'); 
                        var msres = document.getElementById('mostrar_resultado2'); 
                        ///   var m_mostrar_result=msres.checked;  
                        var xnt = msres.selectedIndex;
                        var m_mostrar_result = msres.options[xnt].value;
                        ///
                    }             
                    ///    var m_mostrar_result= trim(zkl.value);      
                    ///

    /***
 alert(" js/editar_patrimonio_js.php/2733  ->>>  ACHOU  -->> m_mostrar_result = "
         +m_mostrar_result+" ---   m_element="+m_element+" <<<--- m_element_value ="
       +m_element_value+" -->> m_element_length = "+m_element_length
       +"  <<<--  val_mres = "+val_mres);
        ***/
                      
                    
                    ///  campos recebidos dados
                    var obj = {
                           'var_id' : ['instituicao', 'unidade'],
                            'var_nome' : ['Instituição', 'Unidade']
                    };
                    ///
                      var obj_length = obj.var_id.length;
                      var inst_unid = new Array();
                      for( wz=0; wz<obj_length; wz++ ) {
                           // Verificando campos
                          var id_var = obj.var_id[wz];
                          var nome_var = obj.var_nome[wz];
                          if( document.getElementById(id_var) ) {
                               var m_typeof = document.getElementById(id_var);
                               var testar="";
                               if( m_typeof instanceof Object ) testar="OK";
                               if( m_typeof instanceof String )  testar="OK";
                               if( testar=="OK" ) {  
                                   var texto = trim(document.getElementById(id_var).value);
                                   if( texto.length<1 ) {
                                        msg_erro=msg_erro_ini+'Falta '+nome_var+final_msg_ini;
                                        if( document.getElementById("label_msg_erro") ) {
                                            /****
                                            if( document.getElementById("label_msg_erro").style.display=="none" ) {  
                                                 document.getElementById("label_msg_erro").style.display="block";
                                            } 
                                            ***/
                                            var xlme=document.getElementById("label_msg_erro");
                                            var tdisp = xlme.style.display;
                                            if( tdisp!="block" ) {
                                                xlme.style.display="block";     
                                            } 
                                            ///    
                                            xlme.innerHTML=msg_erro;                
                                        }
                                        ///
                                        if( document.getElementById("campos_tabela") ) {
                                            /*** IMPORTANTE - Javascript - Voltando para o inicio da tag Select  ***/
                                             var xctb=document.getElementById("campos_tabela");
                                             xctb.options[0].selected=true;
                                             xctb.options[0].selectedIndex=0;  
                                        } 
                                        ///
                                        document.getElementById(id_var).focus();                         
                                        return;
                                        ///
                                   } else {
                                       inst_unid[wz]=texto;             
                                   }
                                   ///
                               }
                               /// Final - if( testar=="OK" ) {   
                               ///
                          }
                          ///
                      }
                      ///  Final - for( wz=0; wz<obj_length; wz++ ) {   
                      ///
                } 
                /****  Final - if( achou!=-1 ) {  ****/
                ///
                var m_campos_tabela="";
                var m_e_up=m_element.toUpperCase();
                var pmels= m_element.search(pos_campos);
                  
                  
 /***********************
 alert(" js/editar_patrimonio_js.php/4039  --->>> validar  NONO  -->> 1) posmrs = "
         +posmrs+" ---- 2) pmels = "
         +pmels+"  -->>> 3) m_e_up = "+m_e_up+"  <<<--- \r\n  m_element="+m_element+" <<<--- m_element_value ="
       +m_element_value+"  --  val_mres = "+val_mres);
  ********************/
                  
                  
                /***  
                *          Atualizado em 20230815
                *   if( pmels!=-1 || m_e_up=="MOSTRAR_RESULTADO" ) {
                *******/    
                if( pmels!=-1 || posmrs!=-1 ) {
                       ///  
                       if( m_element.toUpperCase()=="DEPTO" ) {
                           var array_ids=["instituicao","unidade","depto"];
                       } else  {
                           var array_ids=["instituicao","unidade","depto","setor","lc_setor"];
                       }
                       ///
                       ///  IMPORTANTE para converter array em string
                       if( typeof(array_ids)!="undefined" ) {
                            var caracteres=array_ids.toString();
                            var teste = caracteres.search(m_element);
                       } else {
                           var teste=-1;   
                       } 
                       ///
                       /** if( teste!=-1  || m_e_up=="MOSTRAR_RESULTADO" ) { **/
                       if( teste!=-1 || posmrs!=-1 ) {    
                           ///
                           var m_mostrar_result="";                         
                           var array_ids_length=array_ids.length;
                           for( conta=0; conta<array_ids_length; conta++ )  {
                                /// 
                                var valor_cpo="Todas";
                                var id_nome=array_ids[conta];
                                if( document.getElementById(id_nome) ) {
                                    ///
                                    ///  Verifica se os campos sao DEPTO ou SETOR
                                    if( id_nome.search(/depto|setor|^lc_setor$/i)!=-1  ) {
                                        ///
                                        if( id_nome==m_element ) valor_cpo=m_element_value; 
                                        if( id_nome!=m_element ) {
                                               var xidnm=document.getElementById(id_nome);
                                               valor_cpo=trim(xidnm.value); 
                                        } 
                                        ///
                                    } else {
                                          var xidnm=document.getElementById(id_nome);
                                          valor_cpo=trim(xidnm.value); 
                                    }
                                    ///                                  
                                    ///  Caso variavel valor_cpo vazia   
                                    if( valor_cpo.length<1 ) {
                                         var m_id_nsearch = id_nome.search(/^depto$|^departamento$|^setor$|^lc_setor$/i);
                                          if( m_id_nsearch!=-1 ) { 
                                              valor_cpo="Todos";      
                                          } else { 
                                              valor_cpo="Todas";        
                                          } 
                                    }
                                    ///
                                    m_mostrar_result+=valor_cpo;
                                    if( conta<array_ids_length-1 ) {
                                          m_mostrar_result+="#";   
                                    }
                                } else {
                                    continue;  
                                }
                                /// 
                           }
                           ///    
                            var valor_cpo="";
                           ///
                           if( document.getElementById("ordenar_por") ) {
                                var valor_cpo=trim(document.getElementById("ordenar_por").value); 
                           }
                           /// m_mostrar_result+="#ordenar_por="+valor_cpo;
                           m_mostrar_result+=valor_cpo;
                           ///
                      }
                      /****  Final - if( teste!=-1 || posmrs!=-1 ) {  *****/ 
                      ///
                      
                      
  /**********************            
 alert(" js/editar_patrimonio_js.php/4125  --->>> SEGUE NONO  -->> posmrs = "+posmrs+" ---- 1) codidinst = "
         +codidinst+" -->> codidunid = "+codidunid+" \r\n  -->>  codiddept = "+codiddept+" -->>  codidseto = "+codidseto
         +"  \r\n  -->>> 2) m_e_up = "+m_e_up+"  <<<--- \r\n  m_element = "+m_element+" <<<--- m_element_value = "
       +m_element_value+"  -->>> m_mostrar_result = "+m_mostrar_result+" <<<--- val_mres = "+val_mres);
  *******************/            
                      
                      
                      ///
                      /// if( m_element.toUpperCase()=="MOSTRAR_RESULTADO"  ) {
                      if( posmrs!=-1 ) {
                           ////
                           var array_campos = new Array(codidinst,codidunid,codiddept,
                                     codidseto,"instituicao","unidade",
                                     "depto","setor","lc_setor");
                           ///                          
                           var new_array=new Array(); 
                           var m_mostrar_result="";
                           ///
                           var lenarr = array_campos.length;
                           ///
                           for( nx=0; nx < lenarr; nx++ ) {
                                 var campo_do_array = array_campos[nx];
                                 if( document.getElementById(campo_do_array) ) {
                                      var nxid = document.getElementById(campo_do_array);
                                      new_array[nx] = trim(nxid.value);
                                 } 
                                 ///
                                 ///  Caso NAO for indefinida
                                 if( typeof(new_array[nx])!=="undefined" ) {
                                      if( new_array[nx].length<1 ) {
                                           new_array[nx]="Todas";      
                                      } 
                                      m_mostrar_result+=new_array[nx]+"#";
                                 }
                                 ///
                           }
                           /***   Final - for( nx=0; nx < lenarr; nx++ ) {  ***/
                           ///
                           ///  Verifica campo ID campos_tabela
                           if( document.getElementById('campos_tabela') ) {
                                var xctb=document.getElementById('campos_tabela');
                           } else {
                                ///
                                var m_txt = "Falha ID campos_tabela indefinido - corrigir ";
                               ///
                               alert(m_txt)
                               ///
                               var delay=3000; /// 3 segundos
                               setTimeout(function() {
                                     /// O codigo para ser executado depois de  3 segundos 
                                    /// Mensagem de erro ativar e receber informacao
                                    exoc("label_msg_erro",1,m_txt);
                               },delay);
                               ///
                               return;
                               ///
                           }
                           ///
                           ///  Valor do campo ID campos_tabela
                           var temp_campos_tabela = xctb.value;
                           var m_campos_tabela = temp_campos_tabela.split("#");
                           var inst_unid=m_campos_tabela[0];
                           ///
                          ///   var msres = document.getElementById("mostrar_resultado");
                           /// Elemento Ativo mostrar_resultado ou mostrar_resultado2 
                           if( m_element=="mostrar_resultado" ) {
                               if( document.getElementById('mostrar_resultado') ) {
                                    var msres = document.getElementById('mostrar_resultado'); 
                                    var total_var = trim(msres.value);       
                               }  
                           } else if( m_element=="mostrar_resultado2" ) {
                               if( document.getElementById('mostrar_resultado2') ) {
                                    ///  var zkl = document.getElementById('mostrar_resultado2'); 
                                    var msres = document.getElementById('mostrar_resultado2');
                                    ////   var total_var = msres.checked; 
                                    var xnt = msres.selectedIndex;
                                    var total_var = msres.options[xnt].value;
                                    ///
                               } 
                               /// 
                           }    
                           ///     
                           m_mostrar_result+=total_var;  
                           if( m_mostrar_result.length<1 || m_element_length<1 ) {
                               /// Quando acontece erro ou nao existe dados    
                               if( document.getElementById("mostrar_tabela") ) {
                                   ///  Ocultar ID mostrar_tabela
                                   var lcelem = document.getElementById("mostrar_tabela");
                                   var tdisp =  lcelem.style.display;
                                   if( tdisp!="none" ) {
                                       lcelem.style.display="none";   
                                   }
                                   ///
                               }
                               ///
                           }
                           ///   
                           var xctb = document.getElementById('campos_tabela');
                           var cps_tb = xctb.value;
                           var m_campos_tabela = cps_tb.split("#");
                           var inst_unid=m_campos_tabela[0];
                           ///
                           m_mostrar_result+="#ordenar_por="+inst_unid+"#"+total_var;
                           ///
                           
                           
/***********************
 alert(" js/editar_patrimonio_js.php/4231  --->>> DECIMO  -->> posmrs = "+posmrs
        +" ---- 1) total_var = "+total_var+"  -->>> 2) m_e_up = "+m_e_up
        +"  <<<--- \r\n  m_element="+m_element+" <<<--- m_element_value ="
       +m_element_value+"  -->>> m_mostrar_result = "+m_mostrar_result
       +"  <<<---  val_mres = "+val_mres);
  *****************/
                           
                           
                           
                           ///
                      }
                      ///  Final - if( posmrs!=-1 ) {     
                      ///
                  }
                  /****   Final - if( pmels!=-1 || posmrs!=-1 ) {  ****/
                  ///
                  if( m_mostrar_result.length<1 ) {
                        m_mostrar_result=m_element_value;   
                  }
                  ///
                  ///  Verifica se variavel inst_unid NAO foi definida
                  if( typeof inst_unid=="undefined"  ) {
                        var inst_unid="";    
                  }
                  ///
                  ///
                  var re = RegExp(/^IP$|^CLP$/,'gi');          
                  var resultado = m_element.match(re);
                  if( resultado ) {
                      /// var inst_unid="CLP";   
                      if( m_element.search(/^CLP$/i)!=-1 ) {
                           var inst_unid="CLP";  
                      }  
                      if( m_element.search(/^IP$/i)!=-1 ) {
                           var inst_unid="IP"; 
                      }    
                      var m_mostrar_result = m_element_value;
                      ///
                  } 
                  /***   Final - if( resultado ) {  ****/
                  ///
                  ///
     
/*****************
  alert(" editar_patrimonio_js.php/4275  --.. validar -->>   m_element = "+m_element
          +"  -->>  m_element_value = "+m_element_value+"  ---   array = "
          +array+"  -- m_mostrar_result = "+m_mostrar_result+"  -->>  inst_unid = "+inst_unid);
 *******************/
  
                  
                 if( typeof inst_unid!="undefined"  ) {
                       ///
                       /// Caso for id/name  MOSTRAR_RESULTADO  
                       var array=[nometb,m_element,inst_unid];
                  } else {
                       /// Caso for mostrar_resultado2
                       var array=[nometb,m_element];                      
                  }  
                  ///
                  /****  Encaminhando parametros para outra function   ****/
                  ///


   alert(" js/editar_patrimonio_js.php/4307  -->> FINAL validar  <<-->> 1) nometb = "+nometb
        +" 2) -->>  m_element = "+m_element+"  -->> 3) m_element_value = "+m_element_value
        +"  ---> 4)  array = "+array
        +"  -->  5) m_mostrar_result = "+m_mostrar_result);
        

                  
                  dochange(array,m_mostrar_result);
                  ///
             }
             /****  Final - if( parseInt(m_element_length)>=1 ) {   ****/
             ///
      }
      /*****  Final - if( pos_element!=-1 ) {  *****/
      ///
      return;
      ///
} 
/*****   Final -  function validar(m_element,m_element_value,val_mres) {  ****/     
///
///  Editando um Patrimonio/Bem
function validar_editando(m_element,m_element_value,val_mres,id_tmp) {  
      ///
      if( typeof(m_element)=="undefined" ) {
          var m_element="";
      }
      ///
      if( typeof(m_element_value)=="undefined" ) {
          var m_element_value="";   
      } else {
          ///
         if( typeof(m_element_value)=='string' ) {
              ///  src = trim(string_array);
              /***
              *      string.replace - Melhor forma para eliminiar espaços 
              *    no comeco e final da String/Variavel
              ***/
              /// 
              m_element_value = m_element_value.replace(/^\s+|\s+$/g,"");        
              ///
         } 
      }
      if( typeof(val_mres)=="undefined" ) {
           var val_mres="";   
      }
      ///
      var m_element_length=0;
      ///

/****
 alert(" js/editar_patrimonio_js.php/3359 -->>  validar_editando  INICIO  <<-- m_element="
             +m_element+" - m_element_value ="+m_element_value);      
             ******/


      

     if( typeof(m_element)!="undefined"  ) {
          ///
         if( document.getElementById(m_element) ) {
             ///
             var elid = document.getElementById(m_element);
             if( m_element=='m_descr_adic' ) {
                  m_element_value  = elid.checked;
             } else if( m_element.search(/^atributo|^m_botao_atributo/i)!=-1 ) {
                 if( m_element=='m_botao_atributo' ) {
                     m_element_value=elid.checked;    
                 } else {
                     m_element_value=elid.value;   
                 }
                 ///
                 /***
                 *     Enviando dados pra 
                 *    function verificando_campos
                 * Atualizado em 20220805
                 ***/

/****
 alert(" js/editar_patrimonio_js.php/4361 -->>  validar_editando   <<-- m_element="
             +m_element+" - m_element_value ="+m_element_value);      
****/



                 verificando_campos(m_element,m_element_value);
                 ///
                 return;
                 ///
             } else {
                 ///
                 /***
                 *  if( m_element.search(/instituicao|unidade|depto|setor|mostrar_resultado|orientador|ano_inicial/i)!=-1 )  {
                 ******/
                 ///
                 ///  Campos da tabela bem
                 var cps_tb = new Array(['instituicao','Instituição'],
                                       ['unidade','Unidade'],['depto','Departamento'],
                                       ['departamento','Departamento'],['setor','Setor'],
                                       ['bloco','Bloco'],['sala','Sala'],
                                       ['salatipo','Sala Tipo'],['coduspresp','Responsável'],
                                       ['clp','Código local do Patrimonio'],
                                       ['chapausp','Chapa USP'],['grupo','Grupo'],
                                       ['nome','Nome'],['modelo','Modelo'],['marca','Marca'],
                                       ['serie','Série'],['partede','Parte do CLP'],
                                       ['fornecedor','Fornecedor'],['notafiscal','Nota Fiscal'],
                                       ['notadata','Nota Data'],['valor','Valor'],
                                       ['garantiai','Garantia Inicial'],
                                       ['garantiaf','Garantia Final'],
                                       ['nuprocesso','Número do Processo'],
                                       ['identdocto','Documento identificação'],
                                       ['datacompra','Data da Compra'],['tipoposse','Tipo posse'],
                                       ['fonteposse','Fonte posse'],
                                       ['identposse','Identificação da posse'],
                                       ['instaldata','Data da instalação'],['situacao','Situação'],
                                       ['acao','Ação'],['acaomotivo','Motivo da ação'],
                                       ['acaodata','Data da ação'],['baixadata','Data da baixa'],
                                       ['baixamot','Motivo da baixa'],
                                       ['baixapor','Responsável (Código USP) pela baixa'],
                                       ['baixadocto','Documento da baixa'],
                                       ['baixadest','Baixa destino'],['sessaocad','Sessão cadastrado'],
                                       ['sessaoalt','Sessão alteração'],['pale','pale'],
                                       ['paes','paes']);                                
                 ///
                 m_element_length = m_element_value.length;
                 ///
                 /// Verificando as Tags Selects depto, setor
                 var xdsbsc=m_element.search(/depto|setor|bloco|sala|chapausp/ui);
                 if( xdsbsc!=-1 ) {
                     ///
                     var pnhm=m_element_value.search(/nenhum|nenhuma/i);
                     if( m_element_length<1 || pnhm!=-1 ) {
                         ///
                         /// Variavel definida para corrigir campo
                         var corrigir=1;
                         var perguntar=m_element.search(/bloco|sala|salatipo|chapausp/i);
                         if( perguntar!=-1 ) {
                             /// var resposta=confirm("Digitar novamente S/N?");
                             /// if( !resposta ) var corrigir=0;
                             ///  Perguntando
                             var ncf = "" ;
                             for( x=0; x < cps_tb.length; x++ ) {
                                  if( cps_tb[x][0]==m_element ) {
                                       var ncf = cps_tb[x][1];
                                       break;
                                  }
                             }
                             /*** Final - for( x=0; x < cps_tb.length; x++ ) {  **/
                             ///
                             if( ncf.length>0 ) {
                                 ///
                                 var m_id_type = document.getElementById(m_element).type;
                                 ///
                                 ///  Tipo do campo
                                 var it=m_id_type.search(/checkbox|password|text|hidden|textarea/i);
                                 if( it!=-1 ) {
                                      var  mensagem = "Digitar campo "+ncf;
                                      mensagem += " novamente?";
                                 } else if(m_id_type.search(/select-one|select-multiple/i)!=-1 ) {  
                                     ///
                                      var  mensagem = "Selecionar no campo "+ncf;
                                      mensagem += " opção?";
                                      ///
                                 } else {
                                      var  mensagem = "Corrigir o campo "+ncf+"?";
                                 }
                                 ///
                                 if( document.getElementById(id_tmp) ) {
                                      var elidtmp=document.getElementById(id_tmp);
                                      var tdisp = elidtmp.style.display;
                                      if( tdisp!="none" ) {
                                          elidtmp.style.display="none";   
                                      }
                                      ///
                                 }
                                 ////  
                                 ShowModal(mensagem,m_element,mensagem,id_tmp);
                                 ///
                                 /*888    if( document.getElementById(id_tmp) ) {
                                               if( document.getElementById(id_tmp).style.display=="none" ) {
                                                   document.getElementById(id_tmp).style.display="block";
                                               }               
                                            }                                 
                                 *****/
                                 ////    
                             }
                             ///  Final - if( ncf.length>0 ) {  
                             ///
                             return;
                             ///
                         } else {
                             alert("ERRO: Campo "+m_element+" corrigir.");                         
                         }
                         ///
                         if( corrigir>0 ) {
                              ///  IMPORTANTE:  Para retornar elemento no Javascript  -  return 
                                  window.setTimeout(function() {
                                        document.getElementById(m_element).focus();
                                  },0);
                                  ///
                         }
                         ////
                         return;
                         ///
                     }                    
                     /// Final - if( m_element_length<1 || pnhm!=-1 ) {  
                     ///
                 }
                 ///  Final - if( xdsbsc!=-1 ) {
                 ///
                 if( m_element.search(/^mostrar_resultado$/i)!=-1  ) {
                      if( m_element_value=="" ) {
                          if( typeof(val_mres)!="undefined" ) { 
                               var m_element_value=val_mres;
                          } else {
                              if( document.getElementById("mostrar_tabela") ) {
                                   var mtx=document.getElementById("mostrar_tabela");
                                   var m_element_value=mtx.value;
                              }
                          }
                      }
                      /// Final - if( m_element_value=="" ) {
                 }
                 ///
                    //

                 ///  Final - if( document.getElementById(m_element) ) {  
                 ///    
            }
            ///                 
         }
         /// Final - if( document.getElementById(m_element) ) { 
         ///
     } else {
          m_element="";   
     }
     ///
     if( document.getElementById("label_msg_erro") ) {
          /******
          if( document.getElementById("label_msg_erro").style.display=="block" ) {
                document.getElementById("label_msg_erro").style.display="none";   
          }    
          
          var m_obj = document.getElementById("label_msg_erro");
          var tdisp =  m_obj.style.display;
          if( tdisp!="none" ) {
                 m_obj.style.display="none";                         
          }
          *****/
          ///  Ocultar ID  label_msg_erro 
          exoc("label_msg_erro",0);                     
          ///
     }
     ///
     ///  Definindo a Tabela principal    
     var nome_tabela_id="";
     nome_tabela_id="<?php  echo $_SESSION["m_nome_id"];?>";                
     if( nome_tabela_id.toUpperCase()=="PATRIMONIO" ) nome_tabela_id="bem";
     ///
     
     
/****
   alert(" js/editar_patrimonio_js.php/4471 -   <<-- m_element="+m_element+" - m_element_value ="+m_element_value);      
*****/
     
     
     
     /***
      if( m_element.toUpperCase()!="MOSTRAR_RESULTADO"  ) {
           //  Desativando os campos - Select campos_tabela e Tag text td_mostrar_resultado
           if( document.getElementById("campos_tabela") ) {
               // IMPORTANTE - Javascript - Voltando para o inicio da tag Select
               document.getElementById('campos_tabela').options[0].selected=true;
               document.getElementById('campos_tabela').options[0].selectedIndex=0;  
           } 
           //  Ocultando a Lista de registros 
           if( document.getElementById("mostrar_tabela") ) {
               if( document.getElementById("mostrar_tabela").style.display=="block" ) {
                    document.getElementById("mostrar_tabela").style.display="none";   
               }   
           }
      }    
      ****/
      //
      //  Campos para Selecionar -  Tags - Text ou Select
      //   var pos_element=m_element.search(/^instituicao$|^unidade$|^departamento$|^mostrar_resultado$|^mostrar_resultado2$|^orientador$/i);
      var pos_campos="";
      var pos_element=m_element.search(/^instituicao$|^unidade$|^depto$|^setor$|^mostrar_resultado$|^mostrar_resultado2$|^orientador$/ui);     
      ///
      if( pos_element!=-1 ) {
          var m_mostrar_result="";          
          if( document.getElementById('mensagem_final') ) {
               document.getElementById('mensagem_final').innerHTML="none";   
          }
          ///
          /// Verificando value do mostrar_resultado2                     
          if( m_element_length>=1 ) { 
                // if( m_element=='mostrar_resultado' ) { 
                var pos_campos=/^instituicao$|^unidade$|^depto$|^setor$|^mostrar_resultado$|^mostrar_resultado2$/i;
                if( m_element.search(/^mostrar_resultado_desativado$/i)!=-1 ) { 
                     /// document.getElementById('mostrar_resultado2').value  = "";                
                     var m_mostrar_result= trim(document.getElementById('mostrar_resultado').value);
                     ///      
                      ///  campos recebidos dados
                      var obj = {
                           'var_id' : ['instituicao', 'unidade'],
                            'var_nome' : ['Instituição', 'Unidade']
                      };
                      var obj_length = obj.var_id.length;
                      var inst_unid = new Array();
                      for( wz=0; wz<obj_length; wz++ ) {
                           /// Verificando campos
                           var id_var = obj.var_id[wz];
                           var nome_var = obj.var_nome[wz];
                           if( document.getElementById(id_var) ) {
                               var m_typeof = document.getElementById(id_var);
                               var testar="";
                               if( m_typeof instanceof Object ) testar="OK";
                               if( m_typeof instanceof String )  testar="OK";
                               if( testar=="OK" ) {  
                                   var elid_var=document.getElementById(id_var);
                                   var texto = trim(elid_var.value);
                                   if( texto.length<1 ) {
                                        msg_erro=msg_erro_ini+'Falta '+nome_var+final_msg_ini;
                                        if( document.getElementById("label_msg_erro") ) {
                                            var xlme=document.getElementById("label_msg_erro");
                                            var tdisp = xlme.style.display;
                                            if( tdisp!="block" ) {
                                                xlme.style.display="block";                         
                                            }
                                            ///
                                            xlme.innerHTML=msg_erro;
                                            ///
                                       }
                                       ///
                                       if( document.getElementById("campos_tabela") ) {
                                            ///
                                            var mctb=document.getElementById("campos_tabela"); 
                                            mctb.options[0].selected=true;
                                            mctb.options[0].selectedIndex=0;  
                                           ///
                                       } 
                                       ///
                                       elid_var.focus();
                                       return;
                                   } else {
                                       inst_unid[wz]=texto;             
                                   }
                                   ///
                               }
                               ///  Final - if( testar=="OK" ) {  
                               ///
                           }
                          ///
                      }
                      ///  Final - for( wz=0; wz<obj_length; wz++ ) {   
                  ///  } else if( m_element=='mostrar_resultado2' ) {
                  } 
                  ///  Final do IF  m_element.search(/^mostrar_resultado_desativado$/i)!=-1
                  ///
                  var m_campos_tabela="";
                  var pmesrch=m_element.search(pos_campos);
                  if( pmesrch!=-1  || m_element.toUpperCase()=="MOSTRAR_RESULTADO" ) {
                      ///  
                      if( m_element.toUpperCase()=="DEPTO" ) {
                          var array_ids=["instituicao","unidade","depto"];
                      } else  {
                          var array_ids=["instituicao","unidade","depto","setor"];
                      }
                      ///
                      ///  IMPORTANTE para converter array em string
                      if( typeof(array_ids)!="undefined" ) {
                           var caracteres=array_ids.toString();
                           var teste = caracteres.search(m_element);
                      } else var teste=-1; 
                      ///
                      if( teste!=-1 || m_element.toUpperCase()=="MOSTRAR_RESULTADO" ) {
                           var m_mostrar_result="";                         
                           var array_ids_length=array_ids.length;
                           for( conta=0; conta<array_ids_length; conta++ )  {
                                var valor_cpo="Todas";
                                var id_nome=array_ids[conta];
                                if( document.getElementById(id_nome) ) {
                                    ///
                                    /// Verifica se os campos sao DEPTO ou SETOR
                                    if( id_nome.search(/depto|setor/i)!=-1  ) {
                                         if( id_nome==m_element ) valor_cpo=m_element_value; 
                                         if( id_nome!=m_element ) {
                                             var xelm=document.getElementById(id_nome);
                                             valor_cpo=trim(xelm.value); 
                                         } 
                                     } else {
                                         var xelm=document.getElementById(id_nome);
                                         valor_cpo=trim(xelm.value); 
                                     }                                  
                                     ///    
                                     if( valor_cpo.length<1 ) {
                                         var zy=id_nome.search(/^depto$|^departamento$|^setor$/i);
                                         if( zy!=-1 ) { 
                                             valor_cpo="Todos";      
                                         } else {
                                             valor_cpo="Todas";      
                                         }
                                     }
                                     m_mostrar_result+=valor_cpo;
                                     if( conta<array_ids_length-1 ) {
                                           m_mostrar_result+="#";   
                                     }
                                     ///
                               } else {
                                    continue;   
                               }
                               ///
                           }
                           ///    
                            var valor_cpo="";
                           ///
                           if( document.getElementById("ordenar_por") ) {
                               var valor_cpo=trim(document.getElementById("ordenar_por").value); 
                           }
                           /// m_mostrar_result+="#ordenar_por="+valor_cpo;
                           m_mostrar_result+=valor_cpo;
                           ///
                           ///
                      }
                      ///
                      ///   
                      if( m_element.toUpperCase()=="MOSTRAR_RESULTADO"  ) {
                           var array_campos = new Array("instituicao","unidade","depto","setor");
                           var new_array=new Array(); 
                           /*
                           for( nx=0; nx<array_campos.length; nx++ ) {
                               var campo_do_array=array_campos[nx];
                               // Verificando se existe
                               if( document.getElementById(campo_do_array) ) {
                                   //  Verifica o typeof element
                                   if( document.getElementById(campo_do_array).type=="select-one" ) {
                                         document.getElementById(campo_do_array).options[0].selected=true;
                                         document.getElementById(campo_do_array).options[0].selectedIndex=0;  
                                   }      
                               } 
                           }
                           */
                           var cps_tb = document.getElementById('campos_tabela').value;
                           var m_campos_tabela = cps_tb.split("#");
                           var inst_unid=m_campos_tabela[0];
                           //  Melhor maneira para receber o valor do campo
                           var total_var=document.getElementById('mostrar_resultado').value;
                           ///
                           ///  total_var+=m_element_value;
                           ///  m_mostrar_result+=total_var;      
                           m_mostrar_result+="#ordenar_por="+inst_unid+"#"+total_var;
                           /// m_mostrar_result+=m_element_value;                
                           ///   document.getElementById('mostrar_resultado').value="";
                          /****
                           if( trim(total_var)==""  ) {
                                alert("ERRO: Falta digitar");
                                document.getElementById("mostrar_resultado").focus();
                                return;
                           }
                           */
                      }
                  }
                  //
                  if( m_mostrar_result.length<1 ) m_mostrar_result=m_element_value;
                  if( nome_tabela_id.toUpperCase()=="PATRIMONIO" ) nome_tabela_id="bem";
                  if( typeof(inst_unid)!=""  ) {
                        // Caso for id/name  MOSTRAR_RESULTADO  
                        var array=[nome_tabela_id,m_element,inst_unid];
                  } else {
                       // Caso for mostrar_resultado2
                       var array=[nome_tabela_id,m_element];                      
                  }  
                  //
                //  dochange(array,m_mostrar_result);
                  //
             }
      }
      //  Final  - if pos_element!=-1
      return;
      //
} 
/// FINAL da function  validar_editando
///
///
///  INICIANDO - function para verificar campos principais
function verificando_campos(m_element,m_element_length) {
           ///
           ///  Caso variaveis indefinidas
            if( typeof(m_element)=="undefined" ) {
                 var m_element="";    
            }
            ///
            ///  Valor do conteudo do elemento
            var m_element_value="";
            if( document.getElementById(m_element) ) {
                var elmid=document.getElementById(m_element);
                m_element_value = trim(elmid.value); 
            }
            ///
            ///  Numero de caracteres no valor do elemento
            if( typeof(m_element_length)=="undefined" ) {
                 var m_element_length="";   
            }
            ///
            ///  Campos que dependem da SITUACAO
            var dependedasituacao = ["acao","acaodata","acaomotivo",
                                "baixadata","baixamotivo","baixadest"];
            ///                                
            var situacaoobrigatoria = ["acao","acaodata","baixapor"];
            ///

/****           
alert(" verificando_campos/3752 - INICIO ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
     ****/      


            
            //  Array da SITUACAO
            var situacao_itens=["BAIXA","BAIXADO","DESATIVADO","INOPERANTE","REPARANDO"];
            //
            //  Campos da tabela bem
            var cps_tb = new Array(['instituicao','Instituição'],['unidade','Unidade'],
                         ['depto','Departamento'],['departamento','Departamento'],
                         ['setor','Setor'],['bloco','Bloco'],['sala','Sala'],
                         ['salatipo','Sala Tipo'],['coduspresp','Responsável'],
                         ['clp','Código local do Patrimonio'],['chapausp','Chapa USP'],
                         ['grupo','Grupo'],['nome','Nome'],['modelo','Modelo'],
                         ['marca','Marca'],['serie','Série'],['partede','Parte do CLP'],
                         ['fornecedor','Fornecedor'],['notafiscal','Nota Fiscal'],
                         ['notadata','Nota Data'],['valor','Valor'],
                         ['garantiai','Garantia Inicial'],['garantiaf','Garantia Final'],
                         ['nuprocesso','Número do Processo'],
                         ['identdocto','Documento identificação'],
                         ['datacompra','Data da Compra'],['tipoposse','Tipo posse'],
                         ['fonteposse','Fonte posse'],['identposse','Identificação da posse'],
                         ['instaldata','Data da instalação'],['situacao','Situação'],
                         ['acao','Ação'],['acaomotivo','Motivo da ação'],
                         ['acaodata','Data da ação'],['baixadata','Data da baixa'],
                         ['baixamot','Motivo da baixa'],
                         ['baixapor','Responsável (Código USP) pela baixa'],
                         ['baixadocto','Documento da baixa'],['baixadest','Baixa destino'],
                         ['sessaocad','Sessão cadastrado'],
                         ['sessaoalt','Sessão alteração'],['pale','pale'],['paes','paes']);
            ///
            /****
               if( document.getElementById("label_msg_erro") ) {
                   if( document.getElementById("label_msg_erro").style.display=="block" ) {
                       document.getElementById("label_msg_erro").style.display="none";
                   }     
               }
            ****/
            ///
            ////  Ocultar ID  label_msg_erro 
            exoc("label_msg_erro",0,"");                     
            ///
            ///  Mensagem de Erro            
            msg_erro='<p class="texto_normal" style="color: #000000;text-align: center;">';
            msg_erro+='ERRO:&nbsp;<span style="color: #FF0000;">';
            ///
            ///  Final da Mensagem - Erro ou OK
            final_msg_erro = '</span></p>';
            ///
            ///  instituicao
            /// if( document.getElementById('instituicao').value=="" ) {
            ///  if( ( m_element=='instituicao' ) && ( m_element_length<1 ) ) {
            if( ( m_element.search(/instituicao/i)!=-1 ) && ( m_element_length<1 ) ) {
                ///
                  document.getElementById('unidade').disabled = true;                
                  document.getElementById('depto').disabled = true;
                  document.getElementById('setor').disabled = true;
                  ///
                  msg_erro = msg_erro+'Selecionar Institui&ccedil;&atilde;o'+final_msg_erro;
                  ///
                  /// Mensagem de erro ativar
                  /***
                  if( document.getElementById("label_msg_erro") ) {
                      if( document.getElementById("label_msg_erro").style.display="none" ) {
                           document.getElementById("label_msg_erro").style.display="block";
                      }     
                      document.getElementById("label_msg_erro").innerHTML=msg_erro;
                  }
                  *****/
                  exoc("label_msg_erro",1,msg_erro);        
                  ///             
                  return document.getElementById('instituicao').focus();
                  ///
            }
            /// Final - instituicao
            ///
            
/*****           
alert(" verificando_campos/3752 - PRIMEIRA ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
      ****/     
            
            
            /// UNIDADE
            //  if( document.getElementById("unidade").value=="" ) {
            if( ( m_element.search(/unidade/i)!=-1  ) && ( m_element_length<1 ) ) {          
                  ///
                  /// alert(" Selecionar Unidade ");
                  msg_erro = msg_erro+'Selecionar Unidade'+final_msg_erro;
                  ///
                  /// Mensagem de erro ativar
                  exoc("label_msg_erro",1,msg_erro);                     
                  ///
                  document.getElementById(m_element).focus();
                  return false;
                  ///
            }
            ///
            /****
             else if( document.getElementById("unidade").value!==""  && m_element=="unidade" ) {
                   //  document.getElementById('depto').checked = true;
                   return proximo_campo(m_element);
            } 
            ****/
            ///  Final - Unidade
            ///
            ///    DEPARTAMENTO
            ///  if( document.getElementById("depto").value=="" ) {
            if( ( m_element.search(/depto/i)!=-1 ) && ( m_element_length<1 ) ) {          
                 ///
                 ///  alert(" Selecionar Departamento ");
                 msg_erro = msg_erro+'Selecionar Departamento'+final_msg_erro;
                 /// Mensagem de erro ativar
                 exoc("label_msg_erro",1,msg_erro);         
                 ///
                 document.getElementById(m_element).focus();            
                 return false;
                 ///
            } 
            /// Final do Departamento
            ///
            ///   SETOR
            ////if( document.getElementById("setor").value=="" ) {
            if( document.getElementById(codidseto) ) {    
                var idsetor=document.getElementById(codidseto);
                if( idsetor.value=="" ) {  
                    ///
                    ///  alert(" Selecionar Setor ");
                    msg_erro = msg_erro+'Selecionar Setor'+final_msg_erro;
                    ///
                    /// Mensagem de erro ativar
                    exoc("label_msg_erro",1,msg_erro);         
                    ///
                    document.getElementById(m_element).focus();
                    return false;
                    ///
                }
           } 
           /// Final do Setor
           ///
           //  BLOCO
           //  if( m_element=='bloco' ) {
           if( ( m_element.search(/^bloco$/i)!=-1 ) && ( m_element_length<1 ) ) {          
                var msgm="ERRO: PATRIMONIO NÃO ALTERADO.\nDigitar bloco? ";
                msgm+=" OK/Sim ou Cancel/Não ";
                m_corrigir = window.confirm(msgm); 
                /// Testa se o usuario clicou em Ok
                if( m_corrigir==true ) { 
                    ///
                    msg_erro = msg_erro+'Digitar bloco'+final_msg_erro;
                    /// Mensagem de erro ativar - ID label_msg_erro
                    exoc("label_msg_erro",1,msg_erro);                                         
                    ///
                    /// Retornando ao campo bloco
                    document.getElementById(m_element).focus();    
                    return false;            
                    ///
                }
                ///   Final - if( m_corrigir==true ) { 
           }
           /***
            else {    
                 if( ( m_element_length!=="" ) || ( ! m_corrigir ) ) return proximo_campo(m_element);
           }
           ****/
           /// Final - Bloco
           ///

/****           
alert(" verificando_campos/3752 - SEGUNDA ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
     ***/      
           
           
           
           //  Num_USP/Nome_Responsavel
           //  if( m_element=='coduspresp' ) {
           if( m_element.search(/coduspresp/i)!=-1 && ( m_element_length<1 )  ) {
                  ///
                 msg_erro = msg_erro+'Selecionar Respons&aacute;vel'+final_msg_erro;
                 ///
                 /// Mensagem de erro ativar
                 exoc("label_msg_erro",1,msg_erro);    
                 document.getElementById('m_element').focus();    
                 return false;
                 ///
           }
           /*****
            else {
                 return proximo_campo(m_element);
           }
           ***/
           /// Final Num_USP/Nome_Responsavel
           ///
           ///  CLP - Codigo Local do Patrimonio
           ////  if( m_element=='clp' ) {
           if( m_element.search(/^clp$/i)!=-1 ) {               
               if( m_element_length<1 ) {
                    document.getElementById('chapausp').disabled = true;
                    msg_erro+="Digitar CLP - C&oacute;digo Local do Patrimonio<br>";
                    msg_erro+="Ex.: 17RGE1234567";
                    msg_erro+=final_msg_erro;
                    ///
                    /// Mensagem de erro ativar
                    exoc("label_msg_erro",1,msg_erro);    
                    ///
                    return document.getElementById('clp').focus();
               } else {
                    dochange("clp_cadastro",m_element_length);         
                   /// return proximo_campo(m_element);
                   return;
               }
           }
           /// Final - CLP
           ///
           

/***
alert(" verificando_campos/3752 - TERCEIRA ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
****/
           
           
           ///  Chapa USP - Chapa do Patrimonio USP
           /// if( m_element=='chapausp' ) {            
           if( m_element=='chapausp' ) {
               ////
               if( m_element_length<1 ) {
                   var txt="Digitar Chapa Patrimonio USP?  OK/Sim ou Cancel/Não ";
                   m_corrigir = confirm(txt); 
                   ////
                   /// Testa se o usuario clicou em cancelar
                   if( m_corrigir==true ) {   
                        msg_erro=msg_erro+'Digitar Chapa Patrimonio USP.'+final_msg_erro;
                        ///
                        /// Mensagem de erro ativar
                        exoc("label_msg_erro",1,msg_erro);    
                        ///
                        document.getElementById(m_element).focus();    
                        return false;            
                        ///
                   } 
                   ///  Final - if( m_corrigir==true ) {   
                   /****
                    else if( m_corrigir == false ) {
                         return proximo_campo(m_element);                            
                   }
                   ****/
               } else if( m_element_length!=="" ) {    
                    var elchp=document.getElementById('chapausp');
                    m_element_length = elchp.value;
                    dochange("chapausp",m_element_length);         
                    ///  return proximo_campo(m_element);             
                    return;             
               }      
               ///             
           } 
           /// Final - Chapa do Patrimonio - USP
           ///
           ///  GRUPO 
           if(  m_element.search(/^grupo/i)!=-1 ) {
                ///
                if( m_element_length<1 ) {
                    ///
                    ///  alert(" Selecionar Grupo ");
                    msg_erro = msg_erro+'Selecionar Grupo'+final_msg_erro;
                    ///
                    /// Mensagem de erro ativar
                    exoc("label_msg_erro",1,msg_erro);    
                    return document.getElementById(m_element).focus();    
                    //
                }
                /***
                   else {
                    //  exoc("chapausp",1);
                    return proximo_campo(m_element);
                }  
                ***/                  
           }
           /// FINAL  - GRUPO
           ///
           ///
           ///  NOME 
           ///  if( m_element=='nome' ) {
           if(  m_element.search(/^nome/i)!=-1 ) {
               if( m_element_length<1 ) {
                    ///  alert(" Digitar Nome do Patrimonio ");
                    msg_erro = msg_erro+'Digitar Nome do Patrimonio'+final_msg_erro;
                    ///
                   // Mensagem de erro ativar
                    exoc("label_msg_erro",1,msg_erro);    
                    document.getElementById(m_element).focus();    
                    return false;
               }
               /*
                else {
                   //  exoc("chapausp",1);
                   return proximo_campo(m_element);
               } 
               */                  
           }  
           /// Final - NOME 
           ///
           
/****           
alert(" verificando_campos/3752 - QUARTA  ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
     ****/      

           
           //
           ///  MODELO
           if(  m_element.search(/^modelo$/i)!=-1 ) {
               ///
               if( m_element_length<1 ) {
                   var elmod="Digitar Modelo?  OK/Sim ou Cancel/Não ";
                   m_corrigir = confirm(elmod); 
                   /// testa se o usuario clicou em cancelar
                   if( m_corrigir==true ) {  
                       msg_erro=msg_erro+'Digitar Modelo.'+final_msg_erro;
                       ///
                       /// Mensagem de erro ativar
                       exoc("label_msg_erro",1,msg_erro);    
                       document.getElementById(m_element).focus();    
                       return false;            
                       ///
                   }
                   /// 
               }                   
           } 
           /// Final -  Modelo
           ///
           /// Selecionar FORNECEDOR
           ///  if( m_element=='fornecedor' ) { 
           var pfncd=m_element.search(/^fornecedor/ui);

/***           
alert(" verificando_campos/4908 - FORNECEDOR ->>  pfncd = "+pfncd+"   <<--  m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
*****/
           
           
           
           if( pfncd!=-1 ) {
               ///
               if( m_element_length<1 ) {
                   ///  
                   var elforn="Selecionar Fornecedor";
                   msg_erro = msg_erro+elforn+final_msg_erro;
                   ///
                   /// Mensagem de erro ativar
                   exoc("label_msg_erro",1,msg_erro);    
                   ///
                   document.getElementById(m_element).focus();    
                   ///
                   return false;
                   ///
               } else {
                   ///    INserir Outor fornecedor
                   if( document.getElementById(m_element).value=="outro" ) {
                        /***
                        *     ATUALIZADO EM 20220825
                        ***/
                     ///   document.getElementById('m_fornecedor').disabled = false;               
                        var elmf = document.getElementById('m_fornecedor');
                        var tdispd = elmf.disabled; 
                        if( tdispd!=false ) {
                            elmf.disabled = false;
                        }
                        ///   
                      ///  document.getElementById('tab_fornecedor').style.display = "";
                        var eltbfrn=document.getElementById('tab_fornecedor');
                        var tdisp = eltbfrn.style.display;
                        if( tdisp!="block" ) {
                            eltbfrn.style.display="block";
                        }
                        ///
                    ///  document.getElementById('m_fornecedor').style.display = "";   
                        var elfrn=document.getElementById('m_fornecedor');
                        var tdisp = elfrn.style.display;
                        if( tdisp!="block" ) {
                            elfrn.style.display="block";
                        }
                        ///
                        ///  Mensagem de erro ativar
                       //// msg_erro = msg_erro+'Digitar Fornecedor'+final_msg_erro;
                       var msgtit="Atenção: Digitar Fornecedor";
                        msg_ok= msg_ok_ini+msgtit+final_msg_ini;
                        ///
                        ///  exoc("label_msg_erro",1,msg_erro);    
                        exoc("label_msg_erro",1,msg_ok);    
                       /*** 
                       *     IMPORTANTE: essa function acentuarAlerts
                       ***/
                       var mensagem=acentuarAlerts(msgtit);
                       ///
                       alert(mensagem);
                        ///    alert("Atenção: Digitar Fornecedor");
                       ///
                       return document.getElementById('m_fornecedor').focus();
                       /// 
                   } else {
                       ///
                       /// Desativar IDs
                       ///  document.getElementById('tab_fornecedor').style.display = "none";
                       exoc("tab_fornecedor",0);    
                       exoc("m_fornecedor",0);    
                       ///
                       if( document.getElementById('m_fornecedor') ) {
                           ///
                           ///  Desativar ID m_fornecedor -  DISABLED   
                           var idmf=document.getElementById('m_fornecedor');
                           var tdisp = idmf.disabled;
                           if( tdisp!=true ) {
                                idmf.disabled = true;  
                           } 
                           ///
                       }
                       /***  Final - if( document.getElementById('m_fornecedor') ) {  ***/
                       ///
                       if( document.getElementById('notafiscal') ) {
                           ///
                           ///  Ativar ID m_fornecedor -  DISABLED   
                           var idntfsl=document.getElementById('notafiscal');
                           var tdisp = idntfsl.disabled;
                           if( tdisp!=false ) {
                                idntfsl.disabled = false;  
                           } 
                           ///
                       }
                       /** Final - if( document.getElementById('notafiscal') ) {  **/
                   }
                   ///
               }                   
           } 
           /// FINAL - FORNECEDOR
           ///
           
/*****           
alert(" verificando_campos/3752 - QUINTO - CONTINUAR ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
           ****/
           
           
           
           
           /// DIGITAR  campo FORNECEDOR
          /// if( m_element=='m_fornecedor' ) {
          if( m_element.search(/^m_fornecedor/i)!=-1 ) {
               if( m_element_length<1 ) {
                   ///
                   /// alert(" Selecionar Unidade ");
                   msg_erro = msg_erro+'Digitar Fornecedor'+final_msg_erro;
                   ///
                   /// Mensagem de erro ativar
                   exoc("label_msg_erro",1,msg_erro);    
                   ///
                   document.getElementById(m_element).focus();    
                   return false;
               } else {
                   verificar_clp(m_element);
                   if( verificando_clp )      {
                       /// Mensagem de erro ativar                                           
                       msg=acentuarAlerts("Atenção: Digitar Nota Fiscal");                          
                       msg_erro = msg_erro+msg+final_msg_erro;
                       ///
                       exoc("label_msg_erro",1,msg_erro);    
                       document.getElementById('notafiscal').disabled = false;
                       ///
                       return document.getElementById('notafiscal').focus();
                   } else {
                       document.getElementById('notafiscal').value = "";                
                       ///  document.getElementById('notafiscal').disabled = true;
                       document.getElementById('notafiscal').disabled = false;
                   }
                   /// 
               } 
           } 
           /// FINAL - Digitar  Fornecedor     
           ///
           

/***           
alert(" verificando_campos/3752 - SEXTO - CONTINUAR ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
    ****/       
           
           
           
           ///  NOTA FISCAL 
           ///  if( m_element=='notafiscal' ) {
           if( m_element.search(/^notafiscal/i)!=-1 ) {               
               ///
               if( m_element_length<1 ) {
                   
                   var elcfm="Digitar Nota Fiscal do Patrimonio?  OK/Sim ou Cancel/Não ";
                   m_corrigir=confirm(elcfm); 
                   ///
                   /// testa se o usuario clicou em cancelar
                   if( m_corrigir==true ) {
                       var tx='Digitar Nota Fiscal do Patrimonio.';   
                       msg_erro = msg_erro+tx+final_msg_erro;
                       ///
                       ///  Mensagem de erro ativar                                           
                       exoc("label_msg_erro",1,msg_erro);    
                       ///
                       document.getElementById('m_element').focus();    
                       return false;            
                       ///
                   }
                   /// 
                } 
                ///
           }  
           /// FINAL - NOTA FISCAL 
           ///

/****           
alert(" verificando_campos/4250 - SETIMO - CONTINUAR ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
     ****/      



           ///  NUM PROCESSO - 
           if( m_element.search(/^nuprocesso/i)!=-1 ) {                              
               ///
               if( m_element_length<1 ) {
                   var elnpr="Digitar Número do Processo do Patrimonio?  OK/Sim ou ";
                   elnpr+="Cancel/Não ";
                   m_corrigir = confirm(elnpr); 
                   ///
                   /// testa se o usuario clicou em OK 
                   if( m_corrigir ==true ) {  
                       var dnp='Digitar Número do Processo do Patrimonio';
                       msg_erro = msg_erro+dnp+final_msg_erro;
                       ///
                       /// Mensagem de erro ativar                                           
                       exoc("label_msg_erro",1,msg_erro);    
                       ///
                       document.getElementById(m_element).focus();    
                       return false;            
                       ///
                   } 
               } 
               ///
           }  
           /// Final - if( m_element.search(/^nuprocesso/i)!=-1 ) { 
           ///
           
           
           
/*****           
alert(" verificando_campos/4250 - OITAVO - CONTINUAR ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
      *****/     
           
           
           
           ///  DOCTO IDENTIFICACAO - 
           ////  if( m_element=='identdocto' ) {
           if( m_element.search(/^identdocto/i)!=-1 ) {    
                ///                                         
                if( m_element_length<1 ) {
                    var eliddoc="Digitar Documento de Identificação do Patrimonio?  OK/Sim ou ";
                    eliddoc+="Cancel/Não";
                    m_corrigir = confirm(eliddoc); 
                    ///
                    /// testa se o usuario clicou em cancelar
                    if( m_corrigir ==true ) {   
                        ///
                        var tt='Digitar Documento de Identificação do Patrimonio';
                        msg_erro=msg_erro+tt+final_msg_erro;
                        /// 
                        /// Mensagem de erro ativar                                           
                        exoc("label_msg_erro",1,msg_erro);    
                        ///
                        document.getElementById(m_element).focus();    
                        return false;            
                        ///
                    } 
                    ///
                } 
                ///
           }  
           /// FINAL  - DOCTO IDENTIFICACAO
           ///
           
/****
alert(" verificando_campos/4250 - NONO - CONTINUAR ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
****/
           
           
           ///  DATA COMPRA - 
           /// FINAL DATA COMPRA
           ///   
           /// PARTE DO CLP    
           /// if( m_element=='partede' ) {            
           /***
           if( m_element=='partede' ) {
               if( m_element_length<1 ) {
                    //  m_corrigir = confirm("Digitar Parte do CLP?"); 
                    return proximo_campo(m_element);    
               } else if( m_element_length!=="" )  {    
                    m_element_length = document.getElementById('partede').value;
                    dochange("partede",m_element_length);         
                    return proximo_campo(m_element);             
               }                   
           } 
           *****/
           /// Final - Parte do CLP
           ///
           ///  TIPO POSSE - 
           if( m_element.search(/^tipoposse$/i)!=-1 ) {
               ///                                                            
               if( m_element_length<1 ) {
                   var eltp="Digitar Tipo de Posse do Patrimonio?  OK/Sim ou ";
                   eltp+="Cancel/Não" 
                   m_corrigir = confirm(eltp); 
                   /// testa se o usuario clicou em cancelar
                   if( m_corrigir ==true ) { 
                       var tt='Digitar Tipo de Posse do Patrimonio';
                       msg_erro = msg_erro+tt+final_msg_erro;
                       ///
                       ///   Mensagem de erro ativar                                           
                       exoc("label_msg_erro",1,msg_erro);    
                       document.getElementById(m_element).focus();    
                       return false;            
                       ///
                   }
                   /// 
               } 
               ///
           }
           // FINAL - TIPO POSSE
           ///  
           

/****
alert(" verificando_campos/4250 - DECIMO - CONTINUAR ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
****/
           
           
           
           ///  FONTE DE POSSE - 
           ///  if( m_element=='fonteposse' ) {
           if( m_element.search(/^fonteposse$/i)!=-1 ) {  
               ///
               if( m_element_length<1 ) {
                   var elfp="Digitar Fonte de Posse do Patrimonio (sigla) ";
                   elfp+="- Exemplo: USP? OK/Sim ou Cancel/Não "
                   m_corrigir = confirm(elfp);
                   /// testa se o usuario clicou em cancelar 
                   if( m_corrigir==true ) {   
                       var tt='Digitar Fonte de Posse do Patrimonio';
                       msg_erro = msg_erro+tt+final_msg_erro;
                       ///
                       /// Mensagem de erro ativar
                       exoc("label_msg_erro",1,msg_erro);    
                       document.getElementById(m_element).focus();    
                       return false;            
                       ///
                   } 
                   ///
                } 
                ///
           }
           /// FINAL - FONTE DE POSSE
           ///
           ///  Docto Identific. DE POSSE - 
           ///  if( m_element=='identposse' ) {
           if( m_element.search(/^identposse$/i)!=-1 ) {                 
               ///
               if( m_element_length<1 ) {
                   var elidp="Digitar Docto. Identificação de Posse?  OK/Sim ou ";
                   elidp+="Cancel/Não ";
                   ///
                   m_corrigir = confirm(elidp);
                   /// testa se o usuario clicou em cancelar 
                   if( m_corrigir==true ) {   
                        var tt='Digitar Docto. Identifica&ccedil;&atilde;o de Posse';
                        msg_erro=msg_erro+tt+final_msg_erro;
                        ///
                        /// Mensagem de erro ativar
                        exoc("label_msg_erro",1,msg_erro);    
                        ///
                        document.getElementById(m_element).focus();    
                        ///
                        return false;            
                        ///
                   }
                   ///  Final - if( m_corrigir==true ) {     
               } 
               ///
           }  
           /// FINAL - Docto Identific. DE POSSE
           ///
           ///  Campos caso a SITUACAO DO BEM NAO FOR  ATIVO
           var pdsiti=dependedasituacao.indexOf(m_element);
           ///
           if( pdsiti!=-1 ) {
               ///
               ///  Caso NAO for nenhum desses itens da SITUACAO
               var situacao_value = "";
               if( document.getElementById("situacao") ) {
                   var eledsit=document.getElementById("situacao");
                   situacao_value = trim(eledsit.value);
               }
               ///
               ///  NESSE ITEM CASO A SITUACAO NAO FOR ATIVO 
               ///     -  CONSISTE ARRAY  dependedasituacao   
               if( document.getElementById(m_element) ) {
                   ///
                   var pos_itens_ver = situacao_itens.indexOf(situacao_value);
                   if( pos_itens_ver!=-1 ) {
                       ///
                       ///  Verificando os campos - consistencia
                       var m_nenhum = m_element_value.search(/^nenhum$|^nenhuma$|^selecio/i);
                       ///  if( m_length<1 || m_nenhum!=-1 ) {
                       if( m_element_length<1 || m_nenhum!=-1 ) {
                           ///
                           ///   var situacaoobrigatoria = ["acao","acaodata"];    
                           ///  Definindo o nome do campo.  Ex.: acao -> Ação 
                           var ncf = "" ;
                           for( x=0; x < cps_tb.length; x++ ) {
                                if( cps_tb[x][0]==m_element ) {
                                       var ncf = cps_tb[x][1];
                                       break;
                                }
                           }
                           ///    
                           if( situacaoobrigatoria.indexOf(m_element)!=-1 ) {
                                var m_corrigir=true;          
                           } else {
                                var m_corrigir=confirm("Digitar/Selecionar "+ncf+"?  OK/Sim ou Cancel/Não"); 
                           }
                           ////
                           if( m_corrigir==true ) {   // testa se o usuario clicou em OK/Sim
                                msg_erro=msg_erro+'Digitar/Selecionar '+ncf+final_msg_erro;
                                ///
                                /// Mensagem de erro ativar
                                exoc("label_msg_erro",1,msg_erro);    
                                ///
                                document.getElementById(m_element).focus();    
                                ///
                                return false;            
                           }
                           /// 
                       }
                       ///    
                    }
                    /// Final - if( pos_itens_ver!=-1 ) {
               }
               ///
           }    
           ///  Final - if( pdsiti!=-1 ) {   
           ///
           ///  DESCRICAO ADICIONAL ATRIBUTO-  Botao Ativar      
           var pmbatr=m_element.search(/^m_botao_atributo/ui);
           ///
           
           
/****
alert(" verificando_campos/4496 - QUATORZE -->>   pmbatr = "+pmbatr+"  ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length);           
****/
           
           
             
           ///   if( m_element=='m_botao_atributo' ) {
           if( pmbatr!=-1 ) {
               ///
               if( ! m_element_length ) {
                    desativar_atributo();         
               } 
               ///    
               if( m_element_length ) {
                    ///
                    var resultado = verificar_clp(m_element);
                    if( resultado ) {
                        ///
                        if( document.getElementById('atributo') ) {
                            ///
                            /// Verifica caso estiver DESAtivado - Ativar elemento
                            var deid=document.getElementById('atributo');  
                            var tdispd = deid.disabled; 
                            if( tdispd!=false ) {
                                 deid.disabled = false;
                            }   
                            ///
                            deid.focus();
                            ///
                        }
                        ///
                    } else {
                        ///
                        if( document.getElementById('m_incluir_atributo') ) {
                            ///
                            /// Verifica caso estiver Ativado - DESAtivar elemento
                            var deid=document.getElementById('m_incluir_atributo');  
                            var tdispd = deid.disabled; 
                            if( tdispd!=true ) {
                                 deid.disabled = true;
                            }   
                            ///
                        }
                        ///
                        if( document.getElementById('m_atrib_descr') ) {
                            /***  Verifica caso estiver Ativado - DESAtivar elemento/ID  ***/
                            var dbyid=document.getElementById('m_atrib_descr');
                            var tdispd = dbyid.disabled; 
                            if( tdispd!=true ) {
                                 dbyid.value = "";   
                                 dbyid.disabled = true;
                            }   
                            ///
                        }
                        ///  
                        if( document.getElementById('m_atributo') ) {
                              /// Verifica caso estiver Ativado - DESAtivar elemento
                              var dbyidx=document.getElementById('m_atributo');
                              var tdispd = dbyidx.disabled; 
                              if( tdispd!=true ) {
                                   dbyidx.value = "";   
                                   dbyidx.disabled = true;
                              }   
                              ///
                        }
                        ///
                        if( document.getElementById('atributo') ) {
                            ///
                            /// Verifica caso estiver Ativado - DESAtivar elemento
                            var xbyid=document.getElementById('atributo');
                            var tdispd = xbyid.disabled; 
                            if( tdispd!=true ) {
                                 xbyid.disabled = true;
                            }   
                            ///
                        }
                        ///
                    }
                    ///
                    return;                
               }
               ///  Final - if( m_element_length ) {                   
           }  
           ///  FINAL - Botao Ativando - Atributo         
           ///
           ///  Selecionar Atributo
           var psatbt = m_element.search(/^atributo/ui);
           ///
           ///   if( m_element.search(/^atributo/ui)!=-1 ) {              
           if( psatbt!=-1 ) {                
                ///
               if( m_element_length<1 ) {
                   ///  
                   /****  NENHUM VALOR RECEBIDO     ****/
                   msg_erro = msg_erro+'Selecionar Atributo'+final_msg_erro;
                   /// Mensagem de erro ativar
                   exoc("label_msg_erro",1,msg_erro);                                         
                   document.getElementById(m_element).focus();    
                   ///
                   return false;
                   ///
               } else {
                   ///
                   /*** ATUALIZADO em 20220902
                   *       -  Ativando os botoes de Salvar e limpar Atributos  
                   *   document.getElementById('label_incluir_atributo').style.display = "";  
                   *    
                   ***/
                   
                   /*****
                   exoc("label_incluir_atributo",1);                                         
                   exoc("label_limpar_atributo",1);     
                   exoc("trincatr",1);    * 
                   ****/
                   /****
                   *     ATIVAR BOTOES PARA INCLUIR  OU 
                   *  CANCELAR INCLUSAO DO ATRIBUTO  
                   ***/
                   ///
                   if( document.getElementById("trincatr") ) {
                       ///
                       var xlme = document.getElementById("trincatr"); 
                       var tdisp = xlme.style.display;
                       if( tdisp!="block" ) {
                            xlme.style.display="block";                         
                       }
                       ///
                   }
                   ///   xlme.setAttribute("class", "tdic");
                   ///  FINAL  -  if( document.getElementById("trincatr") ) {   
                   ///
                   ///  
                   if( document.getElementById('m_incluir_atributo') ) {
                       /**  Ativar Botao Incluir Atributo  **/
                        var elmiat=document.getElementById('m_incluir_atributo');
                        var tdispd = elmiat.disabled; 
                        if( tdispd!=false ) {
                             elmiat.disabled = false;
                        }   
                        ///
                       /*** 
                        if( document.getElementById('m_incluir_atributo').disabled ) {
                           document.getElementById('m_incluir_atributo').disabled = false;        
                        }
                        ****/
                   }
                   ///
                   if( document.getElementById('m_limpar_atributo') ) {
                        /**  Ativar Botao Limpar/Cancelar Atributo  **/
                        var mlat=document.getElementById('m_limpar_atributo');
                        var tdispd = mlat.disabled; 
                        if( tdispd!=false ) {
                             mlat.disabled = false;
                        }   
                        ///
                        /***** 
                        if( document.getElementById('m_limpar_atributo').disabled ) {
                           document.getElementById('m_limpar_atributo').disabled = false;        
                        }
                        ******/
                   }
                   ///
                   ///   Verifica se for outro atributo  fora da tabela
                   ///  
                   var poutro=m_element_length.search(/^outro/ui);
                   ///
                   ///  if( m_element_length.search(/^outro/ui)!=-1 ) {  
                   if( poutro!=-1 ) {                                    
                       ///
                       /****
                       *   Caso Selecionado opcao Outro Atributo
                       ****/
                       if( document.getElementById('m_atributo') ) {
                           /**  Verifica caso estiver DESAtivado - Ativar Eelemento/ID  **/
                              var dbyidx=document.getElementById('m_atributo');
                              var tdispd = dbyidx.disabled; 
                              if( tdispd!=false ) {
                                  dbyidx.value = "";   
                                  dbyidx.disabled = false;
                              }   
                              ///
                              /*****
                             if( document.getElementById('m_atributo').disabled ) {
                                 document.getElementById('m_atributo').disabled = false;        
                             }
                             ****/
                       }
                       ///
                       ///
                       /// ATIVAR - IDs
                       exoc("tab_atrib",1);
                       exoc("m_atributo",1);
                       exoc("tab_descr",1);
                       exoc("m_atrib_descr",1);
                       ///
                       alert("Atenção: Digitar atributo");                       
                       ///
                       /// Mensagem de erro ativar
                       exoc("label_msg_erro",1,"Atenção: Digitar atributo");
                       ///
                       ///  ATIVANDO IDs 
                       if( document.getElementById("tab_descr") ) {
                           ///
                           var xlme = document.getElementById("tab_descr"); 
                           var tdisp =  xlme.style.display;
                           if( tdisp!="block" ) {
                                xlme.style.display="block";                         
                           }
                           ///
                           var tdispd = xlme.disabled; 
                           if( tdispd!=false ) {
                               xlme.disabled = false;
                           }   
                           ///
                       }
                       ///
                       if( document.getElementById("m_atrib_descr") ) {
                           ///
                           var xlme = document.getElementById("m_atrib_descr"); 
                           var tdisp =  xlme.style.display;
                           if( tdisp!="block" ) {
                                xlme.style.display="block";                         
                           }
                           ///
                           var tdispd = xlme.disabled; 
                           if( tdispd!=false ) {
                               xlme.disabled = false;
                           }   
                           ///
                       }
                       ////
                       ///
                       if( document.getElementById('m_atributo')  ) {
                            ///
                            /// Digitar o novo Atributo
                            document.getElementById('m_atributo').focus();
                       }
                       ////
                       return; 
                       ///
                   } else {
                       ///
                       ///  ATRIBUTO DA LISTA DIGITAR DESCRICAO
                       ///  Ocultar IDs
                       ///                        


/***
   alert(" verificando_campos/4706 - DEZOITO -->> ELSE poutro = "+poutro
           +"  ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length); 
***/

                     
                       /**  Verifica caso estiver Ativado -   
                       *     DESAtivar elemento/ID tab_atrib
                       **/  
                       exoc("tab_atrib",0,""); 
                       ///
                       /****
                       *     Atualizado em  20220803                    
                       ***/
                       ///
                       if( document.getElementById('m_atributo') ) {
                           ///
                           /** Verifica caso estiver Ativado - DESAtivar elemento  **/
                            var dbyidx=document.getElementById('m_atributo');
                            var tdispd = dbyidx.disabled; 
                            if( tdispd!=true ) {
                                 dbyidx.value = "";   
                                 dbyidx.disabled = true;
                            }   
                            ///
                            /*****
                            if( document.getElementById('m_atributo').disabled==false ) {
                                  document.getElementById('m_atributo').disabled = true;
                             }
                            ******/
                            ///
                             exoc("m_atributo",0,"");                     
                             ///
                       }
                       ///
                       ///
                       /// Ativar Campo para digitar - Descricao Atributo
                       if( document.getElementById('tab_descr') ) {
                            /**  Verifica caso estiver DESAtivado - 
                            *     ATIVAR Eelemento/ID tab_atrib
                            ***/  
                            var r_tmt = document.getElementById('tab_descr');
                            var tdisp =  r_tmt.style.display;
                            if( tdisp!="block" ) {
                                r_tmt.style.display="block";                         
                            }
                            ///
                       }
                       ///  
                       /****
                       *     ATIVAR BOTOES PARA INCLUIR  OU 
                       *   CANCELAR INCLUSAO DO ATRIBUTO  
                       ***/
                       ///
                       if( document.getElementById("trincatr") ) {
                           ///
                           var eltri =document.getElementById("trincatr"); 
                           var tdisp = eltri.style.display;
                           if( tdisp!="block" ) {
                                eltri.style.display="block";                         
                           }
                           ///
                       }
                       ////   eltri.setAttribute("class", "tdic");
                       ///  FINAL -  if( document.getElementById("trincatr") ) {   
                       ///
                       ///
                       if( document.getElementById('m_incluir_atributo') ) {
                            /*** Caso ID  estiver Ativado - DESAtivar elemento/ID  ***/
                            var dbyid=document.getElementById('m_incluir_atributo');
                            var tdispd = dbyid.disabled; 
                            if( tdispd!=true ) {
                                 dbyid.value = "";   
                                 dbyid.disabled = true;
                            }   
                            ///
                            /****
                            var tdispt = dbyid.style.display;
                            if( tdispt!="none" ) {
                                 dbyid.style.display="none";                         
                            }
                            ****/
                            ///
                           /****
                           if( document.getElementById('m_incluir_atributo').disabled==false  ) {
                              document.getElementById('m_incluir_atributo').disabled = true;                       
                           }
                           ****/ 
                       }
                       ///      
                       if( document.getElementById('m_limpar_atributo')  ) {
                            /*** Caso ID  estiver Ativado - DESAtivar elemento/ID  ***/
                            var dbyid=document.getElementById('m_limpar_atributo');
                            var tdispd = dbyid.disabled; 
                            if( tdispd!=true ) {
                                 dbyid.value = "";   
                                 dbyid.disabled = true;
                            }   
                            ///
                            /*****
                            var tdispt = dbyid.style.display;
                            if( tdispt!="none" ) {
                                 dbyid.style.display="none";                         
                            }
                            *****/
                            ///
                          /*****
                          if( document.getElementById('m_limpar_atributo').disabled==false  ) {
                             document.getElementById('m_limpar_atributo').disabled = true;                       
                          } 
                           ****/
                       }  
                       ///
                       ///
                       if( document.getElementById('m_atrib_descr') ) {
                           ///
                           /**  Verifica caso estiver DESAtivado - Ativar Eelemento/ID  **/
                           var dbyidx=document.getElementById('m_atrib_descr');
                           var tdispd = dbyidx.disabled; 
                           if( tdispd!=false ) {
                                 dbyidx.disabled = false;
                           }
                           ///
                           var tdisp = dbyidx.style.display;
                           if( tdisp!="block" ) {
                                dbyidx.style.display="block";                         
                           }
                           ///
                           /***
                            document.getElementById('m_atrib_descr').value = "";   
                            document.getElementById('m_atrib_descr').focus();
                           ****/
                           dbyidx.value = "";   
                           ///
                           dbyidx.focus();
                           ///
                       }
                       /** Final - if( document.getElementById('m_atrib_descr') ) {  **/
                       ///
                       /***
                       if( document.getElementById('m_atrib_descr') ) {
                            document.getElementById('m_atrib_descr').focus();
                       }
                       ***/
                       

                       
                       
                       ///
                       msg="Atenção: Digitar descrição do atributo";                        
                       ///
                       /// Mensagem de erro ativar
                       exoc("label_msg_erro",1,msg);                                         
                       ///
                       return;
                       ///
                   }
                   ///
               }
               ///                   
           }  
           /// Final - Selecionando Atributo
           ///
           
           
           /// DIGITAR  Campo Atributo           
           
           var pmat = m_element.search(/^m_atributo/ui);
           
/****
   alert(" verificando_campos/4773 - DEZENOVE -->> pmat = "+pmat
           +"  ->> m_element = "+m_element+" -->> m_element_length = "+m_element_length); 
*****/
           
           
           
           ///  if( m_element=='m_atributo' ) {
           ////  if( m_element.search(/^m_atributo/i)!=-1 ) {   
           if( pmat!=-1 ) {       
                ///                           
                if( m_element_length<1 ) {
                    ///
                    /// alert(" Selecionar Unidade ");
                    msg_erro = msg_erro+'Digitar Atributo'+final_msg_erro;
                    ///
                    /// Mensagem de erro ativar
                    exoc("label_msg_erro",1,msg);
                    document.getElementById(m_element).focus();    
                    return false;
                    ///
                } else {
                    ///
                    var resultado = verificar_clp(m_element);
                    ///
                    /// if( verificando_clp ) {
                    if( resultado ) {
                        ///
                        msg = "Atenção: Digitar descrição do atributo";
                        ///
                        /// Mensagem de erro ativar
                        exoc("label_msg_erro",1,msg);
                        ///
                        /***
                        *    Verifica caso estiver DESAtivado - Ativar Eelemento/ID   
                        ***/
                        if( document.getElementById('m_atrib_descr') ) {
                            var dbyidx=document.getElementById('m_atrib_descr');
                            var tdispd = dbyidx.disabled; 
                            if( tdispd!=false ) {
                                 dbyidx.disabled = false;
                                 dbyidx.value = "";   
                            }   
                            ///
                            return document.getElementById('m_atrib_descr').focus();
                            ///
                        } else {
                            ///
                            var terr="ID m_atrib_descr inexistente - corrigir.";
                            ///
                            msg_erro=msg_erro+terr+ncf+final_msg_erro;
                            ///
                            ///   Mensagem de erro ativar
                            exoc("label_msg_erro",1,msg_erro);    
                            ///
                            return false;
                            ///
                        }
                        ///
                    } else {
                        ///
                        /***
                        *    Verifica caso estiver Ativado - DESAtivar Eelemento/ID   
                        ***/
                        if( document.getElementById('m_atrib_descr') ) {
                            ///
                            var dbyidx=document.getElementById('m_atrib_descr');
                            var tdispd = dbyidx.disabled; 
                            if( tdispd!=true ) {
                                 dbyidx.value = "";   
                                 dbyidx.disabled = true;
                            }   
                            ///
                        } 
                        ///  
                    }
                     /// 
                }
                /// 
           } 
           /// Final - Digitar  Atributo     
           ///
           
           
           
           
           
           // Digitar  Descricao Atributo           
           
          /*
           if( m_element=='m_atrib_descr' ) {
             if( m_element_length<1 ) {
                msg_erro = msg_erro+'Digitar Descri&ccedil;&atilde;o do Atributo'+final_msg_erro;
                return false;
            } else {
                       verificar_clp(m_element);
                    if ( verificando_clp )      {
                        m_element="";
                        // return document.getElementById('m_atrib_descr').focus();
                        document.getElementById('label_incluir_atributo').style.display = "";
                        document.getElementById('label_limpar_atributo').style.display = "";
                        document.getElementById('m_incluir_atributo').disabled = false;
                        document.getElementById('m_limpar_atributo').disabled = false;
                    } else {
                        document.getElementById('label_incluir_atributo').style.display = "none";
                        document.getElementById('label_limpar_atributo').style.display = "none";                        
                        document.getElementById('m_atrib_descr').value = "";                
                    }
             } 
           } // Final - Digitar  Descricao do Atributo
           // Botao para incluir Atributo/Descricao na tabela           
           if( m_element=='m_incluir_atributo' ) {
             if( m_element_length<1 ) {
                msg_erro = msg_erro+'Digitar Descri&ccedil;&atilde;o do Atributo'+final_msg_erro;
                return false;
            } else {
                  document.getElementById('m_incluir_atributo').disabled = false;
                return document.getElementById('m_incluir_atributo').focus();
             } 
           } // Final - Botao para incluir Atributo/Descricao na tabela
           */
           
 ///     alert("FINAL -  function verificando_campos - m_element = "+m_element)           
           
                   
           return true;
}
//  FINAL -  function verificando_campos(m_element,m_element_length)
//
//  Verificando o campo CLP - Codigo Local do Patrimonio
function verificar_clp(nome_do_elemento) {
      ///
      if( typeof(nome_do_elemento)=="undefined" ) {
            var nome_do_elemento="";    
      }
      verificando_clp = true;      
      var m_valor_clp_length=0;  
      ///
      if( document.getElementById('clp') ) {
          m_valor_clp = document.getElementById('clp').value;
          m_valor_clp_length = m_valor_clp.length;
      }
      //      
      msg_erro='<p class="texto_normal" style="color: #000; text-align: center;">';
      msg_erro+='ERRO:&nbsp;<span style="color: #FF0000;">';
      final_msg_erro = '</span></p>';
      ///   

/****      
alert(" function verificar_clp -->> linha/5248  -->> nome_do_elemento = "
      +nome_do_elemento+" <<<--- m_valor_clp_length = "+m_valor_clp_length);      
****/      
      
      
      ///
      if( m_valor_clp_length<1 ) {
          ///
          verificando_clp = false;
          ///
          /***
           if( document.getElementById("label_msg_erro") ) {
                if(  document.getElementById("label_msg_erro").style.display=="none" ) {
                     document.getElementById("label_msg_erro").style.display="block";
                }     
           } 
          ***/  
          ///
           if( nome_do_elemento=="incluir_atributo" ) {
               ///
               var terr="ATRIBUTO N&Atilde;O INCLU&Iacute;DO FALTANDO:&nbsp;";
               terr+="Digitar CLP - C&oacute;digo Local do Patrimonio<br/>";
               terr+="Ex.: 17RGE1234567";
               ///
               msg_erro=msg_erro+terr+final_msg_erro;
               ///   
           } else {
               ///
               var terr="Digitar CLP - C&oacute;digo Local do Patrimonio<br/>";
               terr+="Ex.: 17RGE1234567";
               ///
               msg_erro=msg_erro+terr+final_msg_erro;
               if( document.getElementById(nome_do_elemento) ) {
                   var xnmel=document.getElementById(nome_do_elemento);
                   xnmel.value = "";
                   xnmel.focus();
               }
               ///
           }
           ///
           if( nome_do_elemento=="m_botao_atributo" ) {
                document.getElementById(nome_do_elemento).checked=false;  
           } 
           ///
           ///  document.getElementById("label_msg_erro").innerHTML=msg_erro;                
           ///  Mostrar mensagem de erro ativar ID  label_msg_erro 
           exoc("label_msg_erro",1,msg_erro);                     
           ///
           document.getElementById('clp').focus();
           //
           ////  return verificando_clp;    
      }
      //
      return verificando_clp;
}
///  Final - function  verificar_clp
///
///
</script>