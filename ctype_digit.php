<?php
/*
     ctype_digit - Verifica variavel numerica
*/
$strings = array('122.50', '1004', 'foo!#$bar');
   
foreach ($strings as $test) {
      if( ctype_digit($test) ) {
         echo "$test consists of all digits. \n <br />";
      } else {
         echo "$test does not have all digits. \n <br />";
      }
}
///   
?>