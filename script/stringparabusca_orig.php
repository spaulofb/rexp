<?php
//  Funcao para busca com acentos
function stringParaBusca($str) {
	//Transformando tudo em minъsculas
	$str = trim(strtolower($str));

	//Tirando espaзos extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
	while ( strpos($str,"  ") )
		$str = str_replace("  "," ",$str);
	
	//Agora, vamos trocar os caracteres perigosos "г,б..." por coisas limpas "a"
	$caracteresPerigosos = array ("Г","г","Х","х","б","Б","й","Й","н","Н","у","У","ъ","Ъ","з","З","а","А","и","И","м","М","т","Т","щ","Щ","д","Д","л","Л","п","П","ц","Ц","ь","Ь","В","К","О","Ф","Ы","в","к","о","ф","ы","!","?",",","“","”","-","\"","\\","/");
	$caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
	$str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
	
	//Agora que nгo temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
	//vamos montar a expressгo regular para o MySQL
	$caractresSimples = array("a","e","i","o","u","c");
	$caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
	$str = str_replace($caractresSimples,$caractresEnvelopados,$str);
	$caracteresParaRegExp = array(
		"(a|г|б|а|д|в|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|Г|Б|А|Д|В|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
		"(e|й|и|л|к|&eacute;|&egrave;|&euml;|&ecirc;|Й|И|Л|К|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
		"(i|н|м|п|о|&iacute;|&igrave;|&iuml;|&icirc;|Н|М|П|О|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
		"(o|х|у|т|ц|ф|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|Х|У|Т|Ц|Ф|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
		"(u|ъ|щ|ь|ы|&uacute;|&ugrave;|&uuml;|&ucirc;|Ъ|Щ|Ь|Ы|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
		"(c|з|З|&ccedil;|&Ccedil;)" );
	$str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
	
	//Trocando espaзos por .*
	$str = str_replace(" ",".*",$str);
	
	//Retornando a String finalizada!
	return $str;
}
//
//  Funcao para minuscula para Maiuscula
function stringParaBusca2($str) {
 /*
     $a1 ="абвгдежзийклмнопстуфхцшщъыьэ";
     $a1_len = strlen($a1);
     $a2 ="АБВГДЕЖЗИЙКЛМНОПСТУФХЦШЩЪЫЬЭ";
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
                        '/&aacute;/i' => 'Б',
                        '/&Eacute;/i' => 'Й',
                        '/&Iacute;/i' => 'Н',
                        '/&Oacute;/i' => 'У',
                        '/&Uacute;/i' => 'Ъ',
                        '/&Atilde;/i' => 'Г',
                        '/&Otilde;/i' => 'Х',
                        '/&Acirc;/i' => 'В',
                        '/&Ecirc;/i' => 'К',
                        '/&Icirc;/i' => 'О',
                        '/&Ocirc;/i' => 'Ф',
                        '/&Ucirc;/i' => 'Ы',
                        '/&Ccedil;/i' => 'З',
                        '/&Agrave;/i' => 'А'
                        );
	
	
	
	//  $texto =strtoupper($str);
   $substituir0 = array(
                        '/б/' => '&aacute;',
                        '/й/' => '&eacute;',
                        '/н/' => '&iacute;',
                        '/у/' => '&oacute;',
                        '/ъ/' => '&uacute;',
                        '/г/' => '&atilde;',
                        '/х/' => '&otilde;',
                        '/в/' => '&acirc;',
                        '/к/' => '&ecirc;',
                        '/о/' => '&icirc;',
                        '/ф/' => '&ocirc;',
                        '/ы/' => '&ucirc;',
                        '/з/' => '&ccedil;',
                        '/Б/' => '&Aacute;',
                        '/Й/' => '&Eacute;',
                        '/Н/' => '&Iacute;',
                        '/У/' => '&Oacute;',
                        '/Ъ/' => '&Uacute;',
                        '/Г/' => '&Atilde;',
                        '/Х/' => '&Otilde;',
                        '/В/' => '&Acirc;',
                        '/К/' => '&Ecirc;',
                        '/О/' => '&Icirc;',
                        '/Ф/' => '&Ocirc;',
                        '/Ы/' => '&Ucirc;',
                        '/З/' => '&Ccedil;',
                        '/а/' => '&agrave;',
                        '/А/' => '&Agrave;'
                        );

/*
	$substituir2 = array('/б/' => 'Б',
                        '/й/' => 'Й',
                        '/н/' => 'Н',
                        '/у/' => 'У',
                        '/ъ/' => 'Ъ',
                        '/г/' => 'Г',
                        '/х/' => 'Х',
                        '/в/' => 'В',
                        '/к/' => 'К',
                        '/о/' => 'О',
                        '/ф/' => 'Ф',
                        '/ы/' => 'Ы',
                        '/з/' => 'З',
                        '/с/' => 'С',
						'/т/' => 'Т',
						'/т/' => 'Т',						
						'/ц/' => 'Ц',						
						'/ш/' => 'Ш',												
                        '/щ/' => 'Щ',																		
                        '/ь/' => 'Ь',																								
					    '/э/' => 'Э'
                    );
					*/
					
		$substituir2 = array('б' => 'Б',
                        'й' => 'Й',
                        'н' => 'Н',
                        'у' => 'У',
                        'ъ' => 'Ъ',
                        'г' => 'Г',
                        'х' => 'Х',
                        'в' => 'В',
                        'к' => 'К',
                        'о' => 'О',
                        'ф' => 'Ф',
                        'ы' => 'Ы',
                        'з' => 'З',
                        'с' => 'С',
						'т' => 'Т',
						'т' => 'Т',						
						'ц' => 'Ц',						
						'ш' => 'Ш',												
                        'щ' => 'Щ',																		
                        'ь' => 'Ь',																								
					    'э' => 'Э'
                    );
					
						
  // $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
   $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);

	return $texto;
	
}	
?>