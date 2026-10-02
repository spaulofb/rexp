<?php
//
//  Funcao para busca com acentos
if( ! function_exists("stringParaBusca") ) {
    function stringParaBusca($str) {
        //Transformando tudo em min�sculas
        $str = trim(strtolower($str));

        //Tirando espa�os extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
        while ( strpos($str,"  ") )
            $str = str_replace("  "," ",$str);
        
        //Agora, vamos trocar os caracteres perigosos "�,�..." por coisas limpas "a"
        $caracteresPerigosos = array ("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","!","?",",","�","�","-","\"","\\","/");
        $caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
        $str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
        
        //Agora que n�o temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
        //vamos montar a express�o regular para o MySQL
        $caractresSimples = array("a","e","i","o","u","c");
        $caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
        $str = str_replace($caractresSimples,$caractresEnvelopados,$str);
        $caracteresParaRegExp = array(
            "(a|�|�|�|�|�|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|�|�|�|�|�|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
            "(e|�|�|�|�|&eacute;|&egrave;|&euml;|&ecirc;|�|�|�|�|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
            "(i|�|�|�|�|&iacute;|&igrave;|&iuml;|&icirc;|�|�|�|�|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
            "(o|�|�|�|�|�|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|�|�|�|�|�|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
            "(u|�|�|�|�|&uacute;|&ugrave;|&uuml;|&ucirc;|�|�|�|�|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
            "(c|�|�|&ccedil;|&Ccedil;)" );
        $str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
        
        //Trocando espa�os por .*
        $str = str_replace(" ",".*",$str);
        
        //Retornando a String finalizada!
        return $str; 
        //
    }
}
//
//  Funcao para minuscula para Maiuscula   
if( ! function_exists("stringParaBusca2") ) {
    function stringParaBusca2($str) {
    /*
        $a1 ="����������������������������";
        $a1_len = strlen($a1);
        $a2 ="����������������������������";
        //  $pessoa_nome2=trim($pessoa_nome);
        for( $i=0; $i<$a1_len; $i++ ) {
            $char1[]=substr($a1,$i,1);
            $char2[]=substr($a2,$i,1);
        }
        $m_count = count($char1);
        $texto=$str;
        for( $x=0; $x<$m_count ; $x++ ) {
            //   $str = str_replace($char1[$x],$char2[$x],$str);
            // First check if there is a "5" at position 0.
            $offset = 0; // initial offset is 0
            $fiveCounter = 0;
            if( strpos($str, $char1[$x])==0 ) continue;

        // Check the rest of the string for 5's
        while( $offset=strpos($str, $char1[$x],$offset+1) ) {
            $texto=substr_replace($texto,$char2[$x],$offset,1); 
            $chars .=  $char1[$x]." - ";        
        }
        //	 $str = str_replace($char1,$char2,$str);
            //  $texto .= "<br>  - $str ".$char1." - ".$char2;
        
        
        }
    */
        //  Usar para substituir caracteres com acentos para Maiuscula
    $substituir = array(
                            '/&aacute;/i' => '�',
                            '/&Eacute;/i' => '�',
                            '/&Iacute;/i' => '�',
                            '/&Oacute;/i' => '�',
                            '/&Uacute;/i' => '�',
                            '/&Atilde;/i' => '�',
                            '/&Otilde;/i' => '�',
                            '/&Acirc;/i' => '�',
                            '/&Ecirc;/i' => '�',
                            '/&Icirc;/i' => '�',
                            '/&Ocirc;/i' => '�',
                            '/&Ucirc;/i' => '�',
                            '/&Ccedil;/i' => '�',
                            '/&Agrave;/i' => '�'
                            );
        
        
        
        //  $texto =strtoupper($str);
    $substituir0 = array(
                            '/�/' => '&aacute;',
                            '/�/' => '&eacute;',
                            '/�/' => '&iacute;',
                            '/�/' => '&oacute;',
                            '/�/' => '&uacute;',
                            '/�/' => '&atilde;',
                            '/�/' => '&otilde;',
                            '/�/' => '&acirc;',
                            '/�/' => '&ecirc;',
                            '/�/' => '&icirc;',
                            '/�/' => '&ocirc;',
                            '/�/' => '&ucirc;',
                            '/�/' => '&ccedil;',
                            '/�/' => '&Aacute;',
                            '/�/' => '&Eacute;',
                            '/�/' => '&Iacute;',
                            '/�/' => '&Oacute;',
                            '/�/' => '&Uacute;',
                            '/�/' => '&Atilde;',
                            '/�/' => '&Otilde;',
                            '/�/' => '&Acirc;',
                            '/�/' => '&Ecirc;',
                            '/�/' => '&Icirc;',
                            '/�/' => '&Ocirc;',
                            '/�/' => '&Ucirc;',
                            '/�/' => '&Ccedil;',
                            '/�/' => '&agrave;',
                            '/�/' => '&Agrave;'
                            );

    /*
        $substituir2 = array('/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',
                            '/�/' => '�',						
                            '/�/' => '�',						
                            '/�/' => '�',												
                            '/�/' => '�',																		
                            '/�/' => '�',																								
                            '/�/' => '�'
                        );
                        */
                        
            $substituir2 = array('�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',
                            '�' => '�',						
                            '�' => '�',						
                            '�' => '�',												
                            '�' => '�',																		
                            '�' => '�',																								
                            '�' => '�'
                        );
                        
                            
    // $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
    $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);

        return $texto;
        
    } 
}
//	
?>
