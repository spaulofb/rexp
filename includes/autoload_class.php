<?php
/***
*       ALTERADO EM 20191210
*      PHP 7 
*       Deprecated: __autoload() is deprecated, 
*             use spl_autoload_register() 
*       
*****/
// nome do arquivo e class  tem que ser iguais
/// if( ! function_exists("__autoload") ) {
///     function __autoload($class) {
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
 
/***
        $diretorios = array('includes/', '../includes/',"./");     
        $encontrado=0;
        foreach( $diretorios as $diretorio ) {  
              $arquivos = array($class,$class.".php",$class.".class.php");
              foreach( $arquivos as $arquivo ) {       
                  if ( file_exists($diretorio.$arquivo) ) {  
                       $encontrado=1;
                       //  Alterado em 20160815
                       ///  require_once($diretorio.$arquivo) ;   
                       include($diretorio.$arquivo);
                       break;       
                  }
              }      
        }
        if( $encontrado<1  ) {
           echo "A classe $class n&atilde;o existe.";   
        }
 * 
 ****/
        
///
/// Verifica class Autoload
if( ! class_exists('Autoload') ) {
    ///        
    class Autoload {
        public function __construct() {
            spl_autoload_extensions('.class.php');
            spl_autoload_register(array($this, 'load'));
        
        }
        private function load($className) {
            $extension = spl_autoload_extensions();
            $diretorios = array('includes/', '../includes/',"./");     
            $encontrado=0;
            foreach( $diretorios as $diretorio ) {  
                  $arquivos = array($className,$className.".php",$className.".class.php");
                  foreach( $arquivos as $arquivo ) {       
                      if ( file_exists($diretorio.$arquivo) ) {  
                           $encontrado=1;
                           //  Alterado em 20160815
                           ///  require_once($diretorio.$arquivo) ;   
                         ////  include($diretorio.$arquivo);
                           ////  require_once(__DIR__ . '/' . $className . $extension);
                           require_once("$diretorio". $className . $extension);
                           break;       
                      }
                  }      
            }
            if( intval($encontrado)<1  ) {
                 echo "A classe $class n&atilde;o existe.";   
            }
        }
    }      
    /// Final - class Autoload {
}
///  
/// }
/*

//  INCLUINDO CLASS - 
require_once '../includes/autoload_class.php';  

    
    $funcoes=new funcoes();
    echo $funcoes->mostra_msg_erro("FDDFS  FDLDFLSK LKDFKDSF LFDJDSKF");
    
    exit();
    

*/
?>
