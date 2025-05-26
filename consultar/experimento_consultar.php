<?php 
/*   Iniciando conexao  - CONSULTAR EXPERIMENTO  */
#
//  @require_once('../inicia_conexao.php');  once = somente uma vez
include('../inicia_conexao.php');
#
//    MENU HORIZONTAL
include("../includes/array_menu.php");
//
$_SESSION["m_horiz"] = $array_projeto;
//
// $_SESSION['time_exec']=180000;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="pt-br" />
<meta name="author" content="Sebasti?o Paulo" />
<META http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE"> 
<META HTTP-EQUIV="Expires" CONTENT="-1" >
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE"> 
<!--  <link rel="shortcut icon"  href="imagens/agencia_contatos.ico"  type="image/x-icon" />  -->
<link rel="shortcut icon"  href="imagens/pe.ico"  type="image/x-icon" />  
<META http-equiv="imagetoolbar" content="no">  
<title>Exemplo Menu</title>
<script type="text/javascript">
//
//  Javascript - 20100621
/*
     Aumentando a Janela no tamanho da resolucao do video
*/
self.moveTo(-4,-4);
//  self.moveTo(0,0);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
//  self.resizeTo(1000,1000);
self.focus();
//   Verificando qual a resolucao do tela - tem que ser no minimo 1024x768
if ( screen.width<1024 ) {
    alert("A resolu??o da tela do seu monitor para esse site ?\n RECOMEND?VEL no m?nimo  1024x768 ")
}
//
function enviando() {
   document.getElementById("teste2").innerHTML="TESTANDO OK";
 //  document.getElementById("About").innerHTML="";
}
/*
      Funcao principal para enviar dados via AJAX
	  CONSULTAR EXPERIMENTO
*/
function dochange(source,val,m_array)  {
    //
	/* if ( source!="Sair" ) {
	     timedClose();
	} else 
	*/
    if ( source.toUpperCase()=="APRESENTA??O" ) {
	    top.location.href="../menu.php";
		return;	    
    }	
    var login_down = "";
	var senha_down = "";
	var n_upload = "";
	//  Escolhido menu opcao: Cadastrar, Consultar
    var source_lista = "CADASTRAR CONSULTAR";		
   	var temp =source.toUpperCase();
   	var pos = source_lista.indexOf(temp);
	//  var caminho="http://www-gen.fmrp.usp.br/rexp3/";
    if ( pos!= -1  ) {					  
	    var opcao_selecionada = val.toLowerCase();
        if( opcao_selecionada.toUpperCase()=="Usuário" ) opcao_selecionada="usuario";
        if ( source.toUpperCase()=="CADASTRAR" ) {
		    //  top.location.href= caminho+"cadastrar/"+opcao_selecionada+"_cadastrar.php?m_titulo="+val.toLowerCase();
		    top.location.href= "../cadastrar/"+opcao_selecionada+"_cadastrar.php?m_titulo="+val.toLowerCase();
		} else   if ( source.toUpperCase()=="CONSULTAR" ) {
		   	//  top.location.href= caminho+"consultar/"+opcao_selecionada+"_consultar.php?m_titulo="+val.toLowerCase();
			top.location.href= opcao_selecionada+"_consultar.php?m_titulo="+val.toLowerCase();
		}
        return;
	}
	//
/*	if( source.toUpperCase()=="SAIR" ) {
	    //     clearTimeout(timer);
   	   	   para  = document.getElementById("menu_principal");
           noPai = para.parentNode;
           noPai.removeChild(para);
	}  */
	//
    //  var poststr = "data="+encodeURI(source)+"&val="+encodeURI(val);
	var login = "";
	var senha = "";
	m_array = "array_m_v_"+m_array;
	var poststr = "source="+encodeURIComponent(source)+"&val="+encodeURIComponent(val)+"&login="+encodeURIComponent(login)+"&senha="+encodeURIComponent(senha)+"&m_array="+encodeURIComponent(m_array);
	//
    //   var id_incluir = "codigo_img";
    /*   Aqui eu chamo a class  */
	var myConn = new XHConn();
		
	/*  Um alerta informando da não inclus?o da biblioteca   */
    if ( !myConn ) {
	      alert("XMLHTTP não dispon?vel. Tente um navegador mais novo ou melhor.");
		  return false;
    }
	//  Arquivo Recebendo as opcoes desejadas: Cadastrar, Sair, etc...
	var receber_dados = "proj_exp_ajax.php";
	//
	/*  Melhor usando display do que visibility - para ocultar e visualizar   */
	//  	document.getElementById('div1').style.visibility="visible";
	// document.getElementById(id).style.display="block";
	//
    var inclusao = function (oXML) { 
						//  Verificando se nao tem a div do menu_vertical
    				    var dados_recebidos = oXML.responseText;
		                // 
					    var source_lista = "CADASTRAR CONSULTAR";		
                      	var temp =source.toUpperCase();
                      	var pos = source_lista.indexOf(temp);
					   if ( source.toUpperCase()=="SAIR" ) {
                  		    	login_down = "";
	                            senha_down = "";
							    top.location.href=dados_recebidos;
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
	    /*  uma coisa legal nesse script se o usuario não tiver suporte a JavaScript  
    	  porisso eu coloquei return false no form o php enviar sozinho   */
}
//
/*     Tempo para fechar o site
var timer;
function timedClose() {
        clearTimeout(timer);
        //  timer = setTimeout("dochange('Sair')",tempo_exec);
		   timer = setTimeout("dochange('Sair')",180000);
		return;
}  //  Final do timedClose
*/
//
</script>
<link  type="text/css"  href="../css/estilo.css" rel="stylesheet"  />
<link  type="text/css"   href="../css/style_titulo.css" rel="stylesheet"  />
<script  type="text/javascript" src="../js/XHConn.js" ></script>
<script type="text/javascript"  src="../js/functions.js" ></script>
<script type="text/javascript"  src="../js/cad_proj_expe.js" ></script>
<script  language="javascript"  type="text/javascript" src="../js/formata_data.js"></script>
<?php
$_SESSION["n_upload"]="ativando";
$_SESSION["login_down"]=$login_down;
$_SESSION["senha_down"]=$senha_down;
unset($login_down);unset($senha_down);
//
?>
</head>
<body  id="id_body"    oncontextmenu="return false" onselectstart="return false"  ondragstart="return false"   onkeydown="javascript: no_backspace(event);"  >
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" style="z-index:9999;"  >
<!-- Cabecalho -->
<div id="cabecalho" style="z-index:8888;" >
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
include("../includes/menu_horizontal.php");
?>
<!-- Final do MENU  -->
<!--  Corpo -->
<div  id="corpo" style="z-index:6666;" >
<?php 
//  CONSULTAR EXPERIMENTO
if( strlen(trim($_GET["m_titulo"]))>1 )  $_SESSION["m_titulo"]=$_GET["m_titulo"];  
if( strlen(trim($_POST["m_titulo"]))>1 )  $_SESSION["m_titulo"]=$_POST["m_titulo"];  
//		
$_SESSION["VARS_AMBIENTE"] = "instituicao|unidade|depto|setor|bloco|salatipo|sala";		   
$_SESSION["cols"]=4;		  
?>
<label  id="label_msg_erro" style="display:none; position: relative;width: 100%; text-align: center; overflow:hidden;" >
   <font  ></font>
</label>
<p class='titulo_usp' style="overflow:hidden;" ><b>Consultar/<?php echo ucfirst($_SESSION["m_titulo"]);?></b></p>
<div style="width:100%; overflow:auto; height: 392px; ">
<form name="form1" id="form1"  enctype="multipart/form-data"  method="post"  
 onsubmit="javascript: enviar_dados_cad('submeter','EXPERIMENTO',document.form1); return false"  >
  <table class="table_inicio" cols="<?php echo $_SESSION["cols"];?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; "  >
    <tr style="text-align: left;"  >
    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="autorexp"  style="vertical-align:bottom; cursor: pointer;"  title="Autor do Experimento" >Autor:&nbsp;</label><br />
        <!-- N. Funcional USP - Autor Experimento  -->
		<?php 
		    //  Verificando se session_start - ativado ou desativado
            if(!isset($_SESSION)) {
                session_start();
            }
            //
            $elemento=5;
			  //  Nao precisa chamar de novo o arquivo ja foi chamado
			 // @require_once("/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php");
   			// $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ",$db_array[$elemento]); 
           include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");			
   		   $result = mysql_query("SELECT codigousp,nome,categoria FROM pessoa  order by nome "); 
	       while($linha=mysql_fetch_assoc($result)) {
                $arr_cnc["codigousp"][]=htmlentities($linha['codigousp']);
                $arr_cnc["nome"][]=  ucfirst(htmlentities($linha['nome']));
                $arr_cnc["categoria"][]=$linha['categoria'];
          }
          $count_arr_cnc = count($arr_cnc["codigousp"])-1;
            //  Cod/Num_USP/Autor
           $m_linhas = mysql_num_rows($result);
           if ( $m_linhas<1 ) {
                   $autor="== Nenhum encontrado ==";
           } else {
		       /*
			   for( $jk=0; $jk<=$count_arr_cnc; $jk++ ) {
                           echo "<option  value=".$arr_cnc["codigousp"][$jk]." >&nbsp;";
                           echo  $arr_cnc["codigousp"][$jk]."&nbsp;-&nbsp;";
                           echo  $arr_cnc["nome"][$jk];
                           echo  "&nbsp;-&nbsp;".$arr_cnc["categoria"][$jk]."&nbsp;&nbsp;</option>" ;
               }
			   */
   			   for( $jk=0; $jk<=$count_arr_cnc; $jk++ ) {
                    if(  $_SESSION["codigousp_usu"]==$arr_cnc["codigousp"][$jk] ) {
					       $autor_codigousp=$arr_cnc["codigousp"][$jk];
						   $autor_nome=$arr_cnc["nome"][$jk];
						   $autor_categoria=$arr_cnc["categoria"][$jk];
					}
               }
              mysql_free_result($result2); 
           }
           // Final da Num_USP/Nome Responsavel
           ?>  
		   		   <input type="text" name="autor_nome"   id="autor_nome"   size="70" maxlength="100" title='Nome do Autor Respons?vel do Projeto'  readonly="readonly"     value="<?php echo $autor_nome;?>"  />
		  <input type="hidden"  name="autor_codigousp"   id="autor_codigousp"   size="80" maxlength="86"  value="<?php echo $autor_codigousp;?>"  />

        </td>

    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="projeto_exp"  style="vertical-align:bottom;  cursor: pointer;"  title="Código do Projeto de Pesquisa" >CIP/Projeto:&nbsp;</label><br />
        <!-- CIP/Projeto -->
		<?php 
            $elemento=6;
		    $result2=mysql_db_query($db_array[$elemento],"SELECT cip,titulo FROM projeto order by cip ");
		?>
        <select name="projeto_exp" id="projeto_exp" class="td_select"  title="Selecionar CIP/Projeto" >                   
         <?php
            //  Cod/Num_USP/Autor
           $m_linhas = mysql_num_rows($result2);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result2)) {       
                      echo "<option  value=".htmlentities($linha['cip'])." style='width: 15px; text-align: rigth;'  >"
					        ."&nbsp;".$linha['cip']."&nbsp;</option>" ;
			   }
          ?>
          </select>
          <?php
               mysql_free_result($result2); 
           }
           // Final do CIP/Projeto
           ?>  
        </td>	
    </tr>
	 <tr>
	   <!--  Titulo do Experimento -->
	    <td  class="td_inicio1" style="text-align: left;" colspan="<?php echo $_SESSION["cols"];?>"  >
      <label for="titulo_exp"  style="vertical-align: top;"  title="T?tulo do Experimento" >T&iacute;tulo:&nbsp;</label>
		<textarea rows="3" cols="72" name="titulo_exp" id="titulo_exp" onKeyPress="javascript:limita_textarea('titulo');" title="Digitar T&iacute;tulo do Experimento" style="cursor: pointer; overflow:auto;" onblur="javascript: alinhar_texto(this.id,this.value)"  ></textarea>     
		</td>
	   <!--  FINAL - Titulo do Experimento -->		
    </tr>	
	 <tr>
	   <!--  Indicador de continua??o do experimento. Código (ciexp) do experimento anterior. 
	         Zero se não for continua??o. -->
	    <td  class="td_inicio1" style="text-align: left;" colspan="<?php echo $_SESSION["cols"];?>"  >
      <label for="continuacao"  style="cursor: pointer; "  title="Indicador de continua??o do Experimento" >Continua??o (Sim/N&atilde;o)?&nbsp;</label>
	  <select name="continuacao"   id="continuacao" class="td_select">
	  <option value='' >== Selecionar ==</option>
  	  <option value='Sim' >Sim</option>
  	  <option value='N?o' >N?o</option>	  
	  </select>
		</td>
	   <!--  FINAL - Indicador de continua??o do experimento -->		
	      </tr>
		  <tr>
		   <!-- Data inicio do Experimento  -->
              <td  class="td_inicio1"  style="vertical-align: middle; text-align: left;"  colspan="2"  >
                 <label for="datainicio_exp"  title="Data do in?cio do Experimento" style="vertical-align: middle; cursor: pointer;"  >Data in&iacute;cio:&nbsp;</label>
			  <input type="text" name="datainicio_exp"   id="datainicio_exp"   size="12" maxlength="10"  
   title="Digitar Data in&iacute;cio - exemplo: 01/01/1998"   style="cursor: pointer;"   onkeyup="formata(this,event);"  />
          <!-- Final - Data inicio do Experimento -->
          <!-- Data Final do Experimento -->
                 <label for="datafinal_exp"   title="Data do final do Experimento" style="vertical-align: middle; cursor: pointer;" >Data final:&nbsp;</label>
			  <input type="text" name="datafinal_exp"   id="datafinal_exp"  size="12" maxlength="10" title="Digitar Data Final - exemplo: 01/01/1998"  style="cursor: pointer;"    onkeyup="formata(this,event);"    />
			 </td>
          <!-- Final - Data Final do Experimento -->
           <!-- Inclusao de Colaboradores  para escolher  -->
       <td  class="td_inicio1"  style="vertical-align: middle; text-align: left;" colspan="2"   >
                 <label for="colabs"  title="N. de colaboradores do Experimento" style="vertical-align: middle; cursor: pointer;"  >Nr. de colaboradores:&nbsp;</label>
			  <input type="text" name="colabs"   id="colabs" value="0"   size="5" maxlength="3" 
      title="N. de colaboradores do Experimento"  style="cursor: pointer;"
       onKeyup="javascript: n_coautores(this,event); "  onblur="javascript: if( this.value<1 ) exoc('incluindo_colaboradores',0);"  />
             <input  type="button"    onclick="javascript: enviar_dados_cad('colabs');"  id="busca_colabs" 
			          title='Clicar'  style="cursor: pointer; width: 110px;"  value="Listar" 
            class="botao3d"   >
			 </td>
          <!-- Final - Numero de Colabores para escolher -->
    </tr>
	   <!-- Inclusao de Colaboradores - caso tenha no N. colaboradores  -->
     <tr align="center" >
            <td align="center" colspan="<?php echo $_SESSION["cols"];?>" >
               <div id="incluindo_colabs" align="center"  ></div>
            </td>
          </tr>
           <!-- Final - Numero de Colaboradores escolhidos -->

	  <tr style="text-align: left;"  >
    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="testemunha1"  style="vertical-align:bottom; cursor: pointer;"  title="Código da Testemunha (1) da realiza??o " >Testemunha (1):&nbsp;</label>
      <br />
        <!-- Código da Testemunha (1) da realiza??o -->
		<?php 
            $elemento=5;
		    $result2=mysql_db_query($db_array[$elemento],"SELECT codigousp,nome,categoria FROM pessoa order by nome ");
		?>
        <select name="testemunha1" id="testemunha1" class="td_select"  >                   
         <?php
            //  Código da Testemunha (1) da realiza??o 
           $m_linhas = mysql_num_rows($result2);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result2)) {       
                      echo "<option  value=".htmlentities($linha['codigousp'])." >&nbsp;";
                      echo  $linha['codigousp']."&nbsp;-&nbsp;";
                      echo  ucfirst(htmlentities($linha['nome']));
                      echo  "&nbsp;-&nbsp;".$linha['categoria']."&nbsp;&nbsp;</option>" ;
               }
          ?>
          </select>
          <?php
               mysql_free_result($result2); 
           }
           // FINAL - Código da Testemunha (1) da realiza??o 
           ?>  
        </td>

    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="testemunha2"  style="vertical-align:bottom; cursor: pointer;"  title="Código da Testemunha (2) da realiza??o " >Testemunha (2):&nbsp;</label>
      <br />
        <!-- Código da Testemunha (2) da realiza??o -->
		<?php 
            $elemento=5;
		    $result=mysql_db_query($db_array[$elemento],"SELECT codigousp,nome,categoria FROM pessoa order by nome ");
		?>
        <select name="testemunha2" id="testemunha2" class="td_select"  >                   
         <?php
           $m_linhas = mysql_num_rows($result);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result)) {       
                      echo "<option  value=".htmlentities($linha['codigousp'])." >&nbsp;";
                      echo  $linha['codigousp']."&nbsp;-&nbsp;";
                      echo  ucfirst(htmlentities($linha['nome']));
                      echo  "&nbsp;-&nbsp;".$linha['categoria']."&nbsp;&nbsp;</option>" ;
               }
          ?>
          </select>
          <?php
               mysql_free_result($result); 
           }
           // FINAL - Código da Testemunha (2) da realiza??o 
           ?>  
        </td>
       </tr>
	
       <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td    class="td_inicio1" style="text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	      <table style="text-align: left;margin: 0px; padding: 0px;"  >
		   <tr>
	       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;" colspan="1"  >
      <label for="ambiente"  style="vertical-align: middle; cursor: pointer;"  title="Indicador de controle de ambiente" >Ambiente:&nbsp;</label>
        <!-- Ambiente -->
		<?php 
            $elemento=6;
		    $result=mysql_db_query($db_array[$elemento],"SELECT codigo,descricao FROM controle order by codigo ");
		?>
        <select name="ambiente" id="ambiente" class="td_select"  >                   
        <?php
           $m_linhas = mysql_num_rows($result);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result)) {       
                      echo "<option  value=".htmlentities($linha['codigo'])." >&nbsp;";
                      echo  $linha['codigo']."&nbsp;-&nbsp;";
                      echo  htmlentities($linha['descricao'])."&nbsp;&nbsp;</option>" ;
               }
          ?>
          </select>
          <?php
               mysql_free_result($result); 
           }
           // FINAL - Ambiente
           ?>  
        </td>

       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;" colspan="1"  >
      <label for="material"  style="vertical-align: middle; cursor: pointer;"  title="Indicador Descritivo de Material usado" >Material:&nbsp;</label>
        <!-- Material -->
		<?php 
            $elemento=6;
		    $result2=mysql_db_query($db_array[$elemento],"SELECT codigo,descricao FROM controle order by codigo ");
		?>
        <select name="material"  id="material" class="td_select"  >                   
        <?php
           $m_linhas = mysql_num_rows($result2);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result2)) {       
                      echo "<option  value=".htmlentities($linha['codigo'])." >&nbsp;";
                      echo  $linha['codigo']."&nbsp;-&nbsp;";
                      echo  htmlentities($linha['descricao'])."&nbsp;&nbsp;</option>" ;
               }
          ?>
          </select>
          <?php
               mysql_free_result($result2); 
           }
           // FINAL - Material
           ?>  
        </td>

       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;" colspan="1"  >
      <label for="metodo"  style="vertical-align: middle; cursor: pointer;"  title="Indicador Descritivo do M?todo usado" >M&eacute;todo:&nbsp;</label>
        <!-- Metodo -->
		<?php 
            $elemento=6;
		    $result=mysql_db_query($db_array[$elemento],"SELECT codigo,descricao FROM controle order by codigo ");
		?>
        <select name="metodo"  id="metodo" class="td_select"  >                   
        <?php
           $m_linhas = mysql_num_rows($result);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result)) {       
                      echo "<option  value=".htmlentities($linha['codigo'])." >&nbsp;";
                      echo  $linha['codigo']."&nbsp;-&nbsp;";
                      echo  htmlentities($linha['descricao'])."&nbsp;&nbsp;</option>" ;
               }
          ?>
          </select>
          <?php
               mysql_free_result($result); 
           }
           // FINAL - Metodo
           ?>  
        </td>
	   </tr>	
	   </table>
	   </td>
	   </tr>
	   <tr>
        <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="resultado"  style="vertical-align: middle; cursor: pointer;"  title="Indicador de ?xito do experimento" >Resultado:&nbsp;</label>
        <!-- Metodo -->
		<?php 
            $elemento=6;
		    $result2=mysql_db_query($db_array[$elemento],"SELECT codigo,descricao FROM resultado order by codigo ");
		?>
        <select name="resultado"  id="resultado" class="td_select"  >                   
        <?php
           $m_linhas = mysql_num_rows($result2);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result2)) {       
                      echo "<option  value=".htmlentities($linha['codigo'])." >&nbsp;";
                      echo  $linha['codigo']."&nbsp;-&nbsp;";
                      echo  htmlentities($linha['descricao'])."&nbsp;&nbsp;</option>" ;
               }
          ?>
          </select>
          <?php
               mysql_free_result($result2); 
           }
           // FINAL - Resultado
           ?>  
        </td>

        <td  class="td_inicio1" style="vertical-align: middle; text-align: left; " colspan="2"  >
      <label for="finalizado"  style="vertical-align: middle; cursor: pointer;"  title="Indicador de finaliza??o do experimento" >Finalizado (Sim/N&atilde;o)?&nbsp;</label>
           <!-- Finalizado -->
		    <select name="finalizado"   id="finalizado" class="td_select">
	  <option value='' >== Selecionar ==</option>
  	  <option value='Sim' >Sim</option>
  	  <option value='N?o' >N?o</option>	  
	  </select>
           <!--  FINAL - finalizado -->
        </td>
	   </tr>
	   
	  <tr  >
	   <td  class="td_inicio1"  colspan="<?php echo $_SESSION["cols"];?>"  style="text-align: left;"   >
           <label for="relatext" style="vertical-align: middle; cursor: pointer; " title="link para o Relat?rio Externo do Experimento"   >Relat&oacute;rio Externo (link):&nbsp;</label>
		<!--'	  <input type="text" name="relatproj"   id="relatproj"   size="80" maxlength="96" 
      title='Digitar  Relat&oacute;rio Externo do Experimento (link)'  style="cursor: pointer;" 
       onblur="javascript: alinhar_texto(this.id,this.value)"   /> -->
	      <input type="file" name="relatext"  id="relatext"  size="90" title="Relat?rio Externo do Experimento (link)"  style="cursor: pointer; vertical-align:middle; "  />
	  </td>
      </tr>
	  
	      <!-- Instituicao, Unidade, Depto, Setor, Bloco e Sala -->	  
		      <tr style="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td    class="td_inicio1" style="text-align: left;margin: 0px; padding: 0px;"  colspan="<?php echo $_SESSION["cols"];?>"  >
	      <table style="text-align: left;margin: 0px; padding: 0px;"  >
		   <tr>
	       <td  class="td_inicio1" style="vertical-align: middle; text-align: left;padding-right: 7px;" colspan="1"  >
 	    	<?php
				   //  INSTITUICAO
	             $elemento=3;
	            include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");				    
				$result=mysql_db_query($db_array[$elemento],"SELECT sigla,nome FROM instituicao order by nome ");
		     ?>
            <label for="instituicao"  style="vertical-align:bottom; padding-bottom: 1px; cursor:pointer;" title="Institui&ccedil;&atilde;o"   >Institui&ccedil;&atilde;o:</label>
			   <br /><br />
                 <select tabindex="1" name="instituicao" class="td_select" id="instituicao"  
				             onchange="enviar_dados_cad('CONJUNTO',this.value,this.name+'|'+'<?php echo $_SESSION["VARS_AMBIENTE"];?>');"  style="padding: 1px;" title="Institui&ccedil;&atilde;o"  >			
			   <?php
  				  //  INSTITUICAO
                 $m_linhas = mysql_num_rows($result);
                 if ( $m_linhas<1 ) {
                        echo "<option value='' >== Nenhum encontrado ==</option>";
                 } else {
				   ?>
 		           <option value='' >== Sigla ==</option>
					<?php
				     // Usando arquivo com while e htmlentities
 					 include("../includes/tag_select_tabelas.php");
					 ?>
	              </select>
	               </span>
					<?php
                    mysql_free_result($result_tb_temp1); 
                    mysql_free_result($result); 
                  }
 				  // Final da Unidade
				  ?>
			  </td>				  
				   <?php
				   $td_campos_array = explode("|",$_SESSION["VARS_AMBIENTE"]);
				   /* Dica sobre o count ou sizeof 
				      Evite de usar for($i=0; $i < count($_linhas); $i++. Use: 
                           $total = count($_linhas); 
				           for($i=0; $i < $total; $i++) 
                      Pois o for sempre ir? executar a fun??o count, 
					  pesando na velocidade do seu programa. 
                   */ 
				   // Nao comeca no Zero porque ja tem o primeiro campo acima - UNIDADE
				   $total_array = count($td_campos_array);
				   for( $x=1; $x<$total_array; $x++ ) {
	   				    $id_td = "td_".$td_campos_array[$x];
				   		echo  "<td  nowrap='nowrap'  class='td_inicio1' style='vertical-align: middle; text-align: left;padding-right: 7px;display:none; ' colspan='1'  "
						        ."   name=\"$id_td\"    id=\"$id_td\"    >";
				        echo '</td>';
					}
					?> 

	    </tr>	
		</table>
		</td>
		</tr>
          <!-- FINAL - Instituicao, Unidade, Depto, Setor, Bloco e Sala -->	  
		  
		  		
      <tr syle="margin: 0px; padding: 0px; line-height: 10px; "  >
	   <td  class="td_inicio1" style="vertical-align: middle; text-align: left;"  colspan="<?php echo $_SESSION["cols"];?>" >
   	      <!-- font indicando bens encontrados -->
             <font id="tab_de_bens" style="display: none;"  ></font>			  
   	      <!-- Final - font indicando bens encontrados -->		   
	    </td>
	  </tr>

		  
          
           <!--  TAGS  type reset e  submit  --> 
           <tr align="center" style="border: 2px solid #000000; vertical-align:top;  line-height:0px;" >
             <td colspan="<?php echo $_SESSION["cols"];?>" align="CENTER" nowrap style=" padding: 1px; text-align:center; border: none; line-height:0px;">
			  <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; line-height: 0px; margin:0px; border: none; vertical-align: top; " >
			    <tr style="border: none;">
				<td  align="CENTER" nowrap style="text-align:center; border:none;" >
			   <button name="limpar" id="limpar"  type="reset" onclick="javascript: document.getElementById('label_msg_erro').style.display='none';"  class="botao3d" style="cursor: pointer; "  title="Limpar"  acesskey="L"  alt="Limpar"     >    
      Limpar <img src="../imagens/limpar.gif" alt="Limpar" style="vertical-align:text-bottom;" >
   </button>
               <!-- Enviar -->				  
			      </td>
			   <td  align="center"  style="text-align: center; border:none; ">
			   <button name="enviar" id="enviar"   type="submit"  class="botao3d"  style="cursor: pointer; "  title="Enviar"  acesskey="E"  alt="Enviar"     >    
      Enviar&nbsp;<img src="../imagens/enviar.gif" alt="Enviar"  style="vertical-align:text-bottom;"  >
   </button>
			  </td>
              <!-- Final -Enviar -->
			   </tr>
              <!--  FINAL - TAGS  type reset e  submit  -->
			  </table>
			  </td>
            </tr>
         </table>
</form>
</div>
</div>
 <!-- Final Corpo -->
 <!-- Rodape -->
<div id="rodape" style="z-index:5555;"  >
<?php include_once("../includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>
