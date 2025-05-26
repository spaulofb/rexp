<!DOCTYPE html>
<html>
<head>
<style>
.mystyle {
    width: 300px;
    height: 50px;
    text-align: center;
    background-color: coral;
    color: white;
    margin-bottom: 10px;
}
</style>
</head>
<body>

<p>In this example, we search for the first div element in the document. Then, if the div element has an id of "myDIV" - change its font size.</p>

<div id="myDIV" class="mystyle">
I am a DIV element
</div>

<div id="myDIV2" class="mystyle">
I am a DIV element
</div>

<button onclick="myFunction()">Try it</button>

<script>
function myFunction() {
    /// var x = document.getElementsByTagName("div")[0];
    var x = document.getElementsByTagName("DIV");
    var xn = document.getElementsByTagName("DIV").length;
    
    var xid = x[0].id;    
    alert("xn = "+xn+"  -- x = "+x+" --->>> x[0].id = "+xid);

    var n_emails=["myDIV0","myDIV","myDIV9"];
    ////  for( j=0; j<xn ; j++ ) {
    for( j=0; j<n_emails.length ; j++ ) {
        /// var xid = x[j].id;    
        var tmp_email = n_emails[j];    
        if( document.getElementById(tmp_email)   ) {
            ////  alert(j+" -- OKOK  "+xid);               
            alert(j+" -- OKOK  "+tmp_email);               
            break;
        }
    }    
    
      
    
    
    
}
</script>

</body>
</html>