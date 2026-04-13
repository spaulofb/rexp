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
        
//
// Verifica class Autoload
/**
 * ALTERADO EM 2026 - Versão Corrigida
 * PHP 7+ / 8+
 */

if (!class_exists('Autoload')) {
    class Autoload {
        public function __construct() {
            // Registra o método 'load' desta classe como o autoloader oficial
            spl_autoload_register(array($this, 'load'));
        }

        private function load($className) {
            // Lista de diretórios para busca
            $diretorios = array('includes/', '../includes/', "./");
            // Possíveis extensões de arquivo
            $extensoes = array('.class.php', '.php');

            foreach ($diretorios as $diretorio) {
                foreach ($extensoes as $ext) {
                    $arquivo = $diretorio . $className . $ext;

                    if (file_exists($arquivo)) {
                        require_once($arquivo);
                        return; // Arquivo encontrado e carregado, sai da função
                    }
                }
            }

            // Se chegou aqui, não achou em nenhum lugar
            // Opcional: registrar em log, mas evite dar 'echo' em autoloaders
        }
    }

    // CRUCIAL: Instanciar a classe para ativar o registro!
    new Autoload();
}
/**   Final - if (!class_exists('Autoload')) {  */
//  
/// }
/*

//  INCLUINDO CLASS - 
require_once '../includes/autoload_class.php';  

    
    $funcoes=new funcoes();
    echo $funcoes->mostra_msg_erro("FDDFS  FDLDFLSK LKDFKDSF LFDJDSKF");
    
    exit();
    

*/
?>
