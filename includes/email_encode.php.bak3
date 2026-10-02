<?php
function Email_Encode($String = '', $Caracteres = 'ISO-8859-1') {
      // Quoted-printed (Q)
      if (function_exists('quoted_printable_encode')) { 
          $String = quoted_printable_encode($String);     
          $RT = '=?'.$Caracteres.'?Q?'.$String.'?=';   
      } else  {
         // IMAP 8bit (Q)
         if (function_exists('imap_8bit')) {  
            $String = imap_8bit($String);     
            $RT = '=?'.$Caracteres.'?Q?'.$String.'?=';   
         } else {
            // Base64 (B)  
            $String = base64_encode($String);     
            $RT = '=?'.$Caracteres.'?B?'.$String.'?=';   
         }  
     }
     Return $RT;     
}     
?>
