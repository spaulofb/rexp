<?php



///  $the_string0 = 'Photosynthesis and jeopardize are big words.';
////  $the_string = 'synthesis';
 ///  $the_string = 'synthesis abacaxi';
  $the_string = ' abacaxis ';
 
/// $the_word = 'synthesis';
////  $the_word = 'synthesis abacaxi';

//// Output ? The word "synthesis" has an exact match in given string. [FALSE positive]
////  if( preg_match('/^synthesis$|^abacaxi$/', $the_string) ) {
if( preg_match('/^(synthesis|abacaxi)$/', trim($the_string)) ) {
  echo 'The word "synthesis" has an exact match in given string. [FALSE positive] - OK';
} else {
   echo 'The word "synthesis" <b> NOT </b> has an exact match in given string. [FALSE positive]'; 
} 
?>
<html>
<head>
<title>Teste</title>
</head>
<body>
<select>
<option  >Nada</option>
<option value="17" onclick="alert(this.value)" selected="selected">Tudo Certo
</option>
<option value="2" >Tudo</option>
</select>
</body>
</html>
