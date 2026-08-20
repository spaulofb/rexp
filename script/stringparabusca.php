<?php
//
//  Funcao para busca com acentos
function stringParaBusca($str) {
	//Transformando tudo em minúsculas
	$str = trim(strtolower($str));

	//Tirando espaços extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
	while ( strpos($str,"  ") )
		$str = str_replace("  "," ",$str);
	
	//Agora, vamos trocar os caracteres perigosos "ã,á..." por coisas limpas "a"
	$caracteresPerigosos = array ("Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","!","?",",","“","”","-","\"","\\","/");
	$caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
	$str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
	
	//Agora que não temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
	//vamos montar a expressão regular para o MySQL
	$caractresSimples = array("a","e","i","o","u","c");
	$caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
	$str = str_replace($caractresSimples,$caractresEnvelopados,$str);
	$caracteresParaRegExp = array(
		"(a|ã|á|à|ä|â|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|Ã|Á|À|Ä|Â|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
		"(e|é|è|ë|ê|&eacute;|&egrave;|&euml;|&ecirc;|É|È|Ë|Ê|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
		"(i|í|ì|ï|î|&iacute;|&igrave;|&iuml;|&icirc;|Í|Ì|Ï|Î|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
		"(o|õ|ó|ò|ö|ô|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|Õ|Ó|Ò|Ö|Ô|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
		"(u|ú|ù|ü|û|&uacute;|&ugrave;|&uuml;|&ucirc;|Ú|Ù|Ü|Û|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
		"(c|ç|Ç|&ccedil;|&Ccedil;)" );
	$str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
	
	//Trocando espaços por .*
	$str = str_replace(" ",".*",$str);
	
	//Retornando a String finalizada!
	return $str;
}
//
//  Funcao para minuscula para Maiuscula
function stringParaBusca2($str) {
 /*
     $a1 ="àáâãäåæçèéêëìíîïñòóôõöøùúûüý";
     $a1_len = strlen($a1);
     $a2 ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝ";
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
                        '/&aacute;/i' => 'Á',
                        '/&Eacute;/i' => 'É',
                        '/&Iacute;/i' => 'Í',
                        '/&Oacute;/i' => 'Ó',
                        '/&Uacute;/i' => 'Ú',
                        '/&Atilde;/i' => 'Ã',
                        '/&Otilde;/i' => 'Õ',
                        '/&Acirc;/i' => 'Â',
                        '/&Ecirc;/i' => 'Ê',
                        '/&Icirc;/i' => 'Î',
                        '/&Ocirc;/i' => 'Ô',
                        '/&Ucirc;/i' => 'Û',
                        '/&Ccedil;/i' => 'Ç',
                        '/&Agrave;/i' => 'À'
                        );
	
	
	
	//  $texto =strtoupper($str);
   $substituir0 = array(
                        '/á/' => '&aacute;',
                        '/é/' => '&eacute;',
                        '/í/' => '&iacute;',
                        '/ó/' => '&oacute;',
                        '/ú/' => '&uacute;',
                        '/ã/' => '&atilde;',
                        '/õ/' => '&otilde;',
                        '/â/' => '&acirc;',
                        '/ê/' => '&ecirc;',
                        '/î/' => '&icirc;',
                        '/ô/' => '&ocirc;',
                        '/û/' => '&ucirc;',
                        '/ç/' => '&ccedil;',
                        '/Á/' => '&Aacute;',
                        '/É/' => '&Eacute;',
                        '/Í/' => '&Iacute;',
                        '/Ó/' => '&Oacute;',
                        '/Ú/' => '&Uacute;',
                        '/Ã/' => '&Atilde;',
                        '/Õ/' => '&Otilde;',
                        '/Â/' => '&Acirc;',
                        '/Ê/' => '&Ecirc;',
                        '/Î/' => '&Icirc;',
                        '/Ô/' => '&Ocirc;',
                        '/Û/' => '&Ucirc;',
                        '/Ç/' => '&Ccedil;',
                        '/à/' => '&agrave;',
                        '/À/' => '&Agrave;'
                        );

/*
	$substituir2 = array('/á/' => 'Á',
                        '/é/' => 'É',
                        '/í/' => 'Í',
                        '/ó/' => 'Ó',
                        '/ú/' => 'Ú',
                        '/ã/' => 'Ã',
                        '/õ/' => 'Õ',
                        '/â/' => 'Â',
                        '/ê/' => 'Ê',
                        '/î/' => 'Î',
                        '/ô/' => 'Ô',
                        '/û/' => 'Û',
                        '/ç/' => 'Ç',
                        '/ñ/' => 'Ñ',
						'/ò/' => 'Ò',
						'/ò/' => 'Ò',						
						'/ö/' => 'Ö',						
						'/ø/' => 'Ø',												
                        '/ù/' => 'Ù',																		
                        '/ü/' => 'Ü',																								
					    '/ý/' => 'Ý'
                    );
					*/
					
		$substituir2 = array('á' => 'Á',
                        'é' => 'É',
                        'í' => 'Í',
                        'ó' => 'Ó',
                        'ú' => 'Ú',
                        'ã' => 'Ã',
                        'õ' => 'Õ',
                        'â' => 'Â',
                        'ê' => 'Ê',
                        'î' => 'Î',
                        'ô' => 'Ô',
                        'û' => 'Û',
                        'ç' => 'Ç',
                        'ñ' => 'Ñ',
						'ò' => 'Ò',
						'ò' => 'Ò',						
						'ö' => 'Ö',						
						'ø' => 'Ø',												
                        'ù' => 'Ù',																		
                        'ü' => 'Ü',																								
					    'ý' => 'Ý'
                    );
					
						
  // $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
   $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);

	return $texto;
	
} 

//	
?>
