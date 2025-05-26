<!DOCTYPE html>
<html>
<head>
<link  type="text/css"  href="css/estilo.css" rel="stylesheet"  />
<link  type="text/css"   href="css/style_titulo.css" rel="stylesheet"  />
<script type="text/javascript">
//
function confirma_orientador(name,valor) {
    var ret = new Array(name, valor);
    alert(" ret[0] = "+ret[0]+"  -  ret[1] = "+ret[1])
    window.returnValue = ret;
    window.close();
}
//
function limpar_form() {   
    window.returnValue = "limpar_form" ;
    window.close();
}
//
function Init() {
    var omyArguments = window.dialogArguments;
     var array_dados = omyArguments.split('#@=');
//     document.write(array_dados[0]);
  /*   var poindex = omyArguments.indexOf('/USP:');
     var codigousp = omyArguments.substring(poindex+1,15);  */
     var codigousp = array_dados[1];
     var texto = array_dados[0];
  //   document.getElementById("resultado").value=texto;
     //  document.getElementById("div_res").value=texto;
     var pos = texto.indexOf('Orientador');
     document.write(texto);     
     
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
</body>
</html>
