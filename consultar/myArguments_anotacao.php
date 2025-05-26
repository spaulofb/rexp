<?php
// require_once("conexao_remover.php");   
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
    var poststr = "";
   //  Verificando a variavel nome vazia  
   var omyArguments = window.dialogArguments;
   
 // Add the HTML to the body
    theBody = document.getElementsByTagName('BODY')[0];
    popmask = document.createElement('div');
    popmask.id = 'popupMask';
    popcont = document.createElement('div');
    popcont.id = 'popupContainer';
    popcont.innerHTML = '' +
        '<div id="popupInner">' +omyArguments + '</div>';
    theBody.appendChild(popmask);
    theBody.appendChild(popcont);
    
    gPopupMask = document.getElementById("popupMask");
    gPopupContainer = document.getElementById("popupContainer");
    gPopFrame = document.getElementById("popupFrame");    
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
//
Init();
</script>
</body>
</html>
