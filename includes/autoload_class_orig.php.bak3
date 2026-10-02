<?php
// nome do arquivo e class  tem que ser iguais
function __autoload($class) {
    /*
    if(file_exists("$class.class.php") ) {
        require_once("$class.class.php");
    } elseif(file_exists("../includes/$class.class.php") ) {
        echo "A classe $class.php n&atilde;o existe.";
    } elseif(file_exists("includes/$class.class.php") ) {
        echo "A classe $class.php n&atilde;o existe.";
    } else {
        
    }
     */
     
    $diretorios = array('includes/', '../includes/',"./");     
    $encontrado=0;
    foreach( $diretorios as $diretorio ) {  
          $arquivos = array($class,$class.".php",$class.".class.php");
          foreach( $arquivos as $arquivo ) {       
              if ( file_exists($diretorio.$arquivo) ) {  
                   $encontrado=1;
                   require_once($diretorio.$arquivo) ;   
                   break;       
              }
          }      
    }
    if( $encontrado<1  ) {
       echo "A classe $class n&atilde;o existe.";   
    }
}
/*

//  INCLUINDO CLASS - 
require_once '../includes/autoload_class.php';  

    
    $funcoes=new funcoes();
    echo $funcoes->mostra_msg_erro("FDDFS  FDLDFLSK LKDFKDSF LFDJDSKF");
    
    exit();
    

*/
?>