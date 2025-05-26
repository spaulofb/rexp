<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Lang" content="en">
<meta name="author" content="">
<meta http-equiv="Reply-to" content="@.com">
<meta name="generator" content="PhpED 6.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="creation-date" content="06/01/2011">
<meta name="revisit-after" content="15 days">
<style type="text/css">
div.scrollTable{
    background: #ffffff;
    border: 1px solid#888;
}

div.scrollTable table.header, div.scrollTable div.scroller table{
      width:100%; 
      _width:100%; 
/*    width:1000px;
    _width:1000px;
    */
    border-collapse: collapse;
}

div.scrollTable table.header th, div.scrollTable div.scroller table td{
    border: 1px solid #444;
    padding: 3px 5px;
    font-family: "Times New Roman", Times,  Arial, Geneva, Helvetica, sans-serif, 'Courier New', Courier, monospace, Verdana,   Garamond, Georgia, serif;
}

div.scrollTable table.header th{
    background: #ddd;
}

div.scrollTable div.scroller{
    height: 200px;
    overflow: auto;
 }

div.scrollTable .coluna75px{
    width: 75px;
}

div.scrollTable .coluna100px{
    width: 100px;
}

div.scrollTable .coluna150px{
    width: 150px;
}
</style>
<title>Untitled</title>
<link rel="stylesheet" type="text/css" href="my.css">
<link  type="text/css"  href="css/estilo.css" rel="stylesheet"  />
</head>
<body>
<!DOCTYPE html>
<html>
<body>
<div id="div_form">
<form id="form1" >
<input type="text" value="Nome" ><br/>
</form>

</div>


<p>Click the "Try it" button to create a BUTTON element with a LINK</p>

<button onclick="myFunction()">Try it</button>

                     <button  type="submit"  name="enviar" id="enviar" class="botao3d" 
                       onclick="executar();"
                      style="cursor: pointer; "  title="Enviar"  acesskey="E"  alt="Enviar"     >    
      Enviar&nbsp;
                      </button>

<p id="demo"></p>


<script type="text/javascript" >
function executar() {
   /// Desativando botao Enviar
   var cars = ["Enviar", "Volvo", "Saab", "Ford", "Fiat", "Audi"];
    var text = "";
    var i;
    for (i = 0; i < cars.length; i++) {
        text += cars[i] + "<br>";
    }
    document.getElementById("demo").innerHTML = text;
           
}
///
function myFunction() {
 /***   document.getElementById("form1").value="";
    document.getElementById("form1").InnerHTML="";
    document.getElementById("form1").style.display="none";
    ***/
    
    
    var parent = document.getElementById("div_form");
     var child = document.getElementById("form1");
     ////  Remover  tag  FORM
      parent.removeChild(child);

    
    
       /// NOW CREATE AN INPUT BOX TYPE BUTTON USING createElement() METHOD.
        var button = document.createElement('input');

        // SET INPUT ATTRIBUTE 'type' AND 'value'.
        button.setAttribute('type', 'button');
        button.setAttribute('value', 'Retornar');
        button.setAttribute('class', 'botao3d');

        // ADD THE BUTTON's 'onclick' EVENT.
        var site='location.assign("http://sol.fmrp.usp.br")';
        button.setAttribute('onclick', site);

        // FINALLY ADD THE NEWLY CREATED TABLE AND BUTTON TO THE BODY.
        
     ///   document.body.appendChild(button);
        div_form.appendChild(button);
   
}
</script>

</body>
</html>
