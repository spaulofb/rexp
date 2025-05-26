<?php
/**
*      FUNTCION PHP
*  v20250411
*/
///  function_exists - verifica se a function NAO esta ativa
if( ! function_exists("get_ftp_mode") ) {
     function get_ftp_mode($file) {   
        $path_parts = pathinfo($file);
	    
        if ( !isset($path_parts['extension']) ) return FTP_BINARY;
        switch (strtolower($path_parts['extension'])) {
            case 'am':case 'asp':case 'bat':case 'c':case 'cfm':case 'cgi':case 'conf':
            case 'cpp':case 'css':case 'dhtml':case 'diz':case 'h':case 'hpp':case 'htm':
            case 'html':case 'in':case 'inc':case 'js':case 'm4':case 'mak':case 'nfs':
            case 'nsi':case 'pas':case 'patch':case 'php':case 'php3':case 'php4':case 'php5':
            case 'phtml':case 'pl':case 'po':case 'py':case 'qmail':case 'sh':case 'shtml':
            case 'sql':case 'tcl':case 'tpl':case 'txt':case 'vbs':case 'xml':case 'xrc':
                return FTP_ASCII;
        }
        return FTP_BINARY;
    }
    /// Final - function get_ftp_mode  --  extensao do arquivo selecionado
}    
///********************************************************************************************/
///   extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
///   extract($_POST, EXTR_OVERWRITE);  
if( ! function_exists("mime_type") ) {
    function mime_type($file) {
        ///
        $filetype = substr(strrchr($file,'.'),1);
        ///
        $mimetypes = array(
                        "ez" => "application/andrew-inset",
                        "atom" => "application/atom+xml",
                        "hqx" => "application/mac-binhex40",
                        "cpt" => "application/mac-compactpro",
                        "doc" => "application/msword",
                        "lha" => "application/octet-stream",
                        "lzh" => "application/octet-stream",
                        "exe" => "application/octet-stream",
                        "so" => "application/octet-stream",
                        "dms" => "application/octet-stream",
                        "class" => "application/octet-stream",
                        "bin" => "application/octet-stream",
                        "dll" => "application/octet-stream",
                        "oda" => "application/oda",
                        "pdf" => "application/pdf",
                        "ps" => "application/postscript",
                        "eps" => "application/postscript",
                        "ai" => "application/postscript",
                        "smi" => "application/smil",
                        "smil" => "application/smil",
                        "mif" => "application/vnd.mif",
                        "xls" => "application/vnd.ms-excel",
                        "ppt" => "application/vnd.ms-powerpoint",
                        "wbxml" => "application/vnd.wap.wbxml",
                        "wmlc" => "application/vnd.wap.wmlc",
                        "wmlsc" => "application/vnd.wap.wmlscriptc",
                        "bcpio" => "application/x-bcpio",
                        "vcd" => "application/x-cdlink",
                        "pgn" => "application/x-chess-pgn",
                        "cpio" => "application/x-cpio",
                        "csh" => "application/x-csh",
                        "dir" => "application/x-director",
                        "dxr" => "application/x-director",
                        "dcr" => "application/x-director",
                        "dvi" => "application/x-dvi",
                        "spl" => "application/x-futuresplash",
                        "gtar" => "application/x-gtar",
                        "gz" => "application/x-gzip",
                        "hdf" => "application/x-hdf",
                        "php" => "application/x-httpd-php",
                        "phps" => "application/x-httpd-php-source",
                        "js" => "application/x-javascript",
                        "skm" => "application/x-koan",
                        "skt" => "application/x-koan",
                        "skp" => "application/x-koan",
                        "skd" => "application/x-koan",
                        "latex" => "application/x-latex",
                        "cdf" => "application/x-netcdf",
                        "nc" => "application/x-netcdf",
                        "sh" => "application/x-sh",
                        "shar" => "application/x-shar",
                        "swf" => "application/x-shockwave-flash",
                        "sit" => "application/x-stuffit",
                        "sv4cpio" => "application/x-sv4cpio",
                        "sv4crc" => "application/x-sv4crc",
                        "tar" => "application/x-tar",
                        "tcl" => "application/x-tcl",
                        "tex" => "application/x-tex",
                        "texi" => "application/x-texinfo",
                        "texinfo" => "application/x-texinfo",
                        "roff" => "application/x-troff",
                        "t" => "application/x-troff",
                        "tr" => "application/x-troff",
                        "man" => "application/x-troff-man",
                        "me" => "application/x-troff-me",
                        "ms" => "application/x-troff-ms",
                        "ustar" => "application/x-ustar",
                        "src" => "application/x-wais-source",
                        "xht" => "application/xhtml+xml",
                        "xhtml" => "application/xhtml+xml",
                        "zip" => "application/zip",
                        "au" => "audio/basic",
                        "snd" => "audio/basic",
                        "midi" => "audio/midi",
                        "kar" => "audio/midi",
                        "mid" => "audio/midi",
                        "mp3" => "audio/mpeg",
                        "mp2" => "audio/mpeg",
                        "mpga" => "audio/mpeg",
                        "aifc" => "audio/x-aiff",
                        "aif" => "audio/x-aiff",
                        "aiff" => "audio/x-aiff",
                        "m3u" => "audio/x-mpegurl",
                        "rm" => "audio/x-pn-realaudio",
                        "ram" => "audio/x-pn-realaudio",
                        "rpm" => "audio/x-pn-realaudio-plugin",
                        "ra" => "audio/x-realaudio",
                        "wav" => "audio/x-wav",
                        "pdb" => "chemical/x-pdb",
                        "xyz" => "chemical/x-xyz",
                        "bmp" => "image/bmp",
                        "gif" => "image/gif",
                        "ief" => "image/ief",
                        "jpe" => "image/jpeg",
                        "jpeg" => "image/jpeg",
                        "jpg" => "image/jpeg",
                        "png" => "image/png",
                        "tif" => "image/tiff",
                        "tiff" => "image/tiff",
                        "djvu" => "image/vnd.djvu",
                        "djv" => "image/vnd.djvu",
                        "wbmp" => "image/vnd.wap.wbmp",
                        "ras" => "image/x-cmu-raster",
                        "pnm" => "image/x-portable-anymap",
                        "pbm" => "image/x-portable-bitmap",
                        "pgm" => "image/x-portable-graymap",
                        "ppm" => "image/x-portable-pixmap",
                        "rgb" => "image/x-rgb",
                        "xbm" => "image/x-xbitmap",
                        "xpm" => "image/x-xpixmap",
                        "xwd" => "image/x-xwindowdump",
                        "igs" => "model/iges",
                        "iges" => "model/iges",
                        "mesh" => "model/mesh",
                        "silo" => "model/mesh",
                        "msh" => "model/mesh",
                        "vrml" => "model/vrml",
                        "wrl" => "model/vrml",
                        "css" => "text/css",
                        "htm" => "text/html",
                        "html" => "text/html",
                        "asc" => "text/plain",
                        "txt" => "text/plain",
                        "rtx" => "text/richtext",
                        "rtf" => "text/rtf",
                        "sgml" => "text/sgml",
                        "sgm" => "text/sgml",
                        "tsv" => "text/tab-separated-values",
                        "wml" => "text/vnd.wap.wml",
                        "wmls" => "text/vnd.wap.wmlscript",
                        "etx" => "text/x-setext",
                        "xml" => "text/xml",
                        "xsl" => "text/xml",
                        "mpe" => "video/mpeg",
                        "mpeg" => "video/mpeg",
                        "mpg" => "video/mpeg",
                        "mov" => "video/quicktime",
                        "qt" => "video/quicktime",
                        "mxu" => "video/vnd.mpegurl",
                        "avi" => "video/x-msvideo",
                        "movie" => "video/x-sgi-movie",
                        "ice" => "x-conference/x-cooltalk"
                         );

         //  return implode('', array_keys(array_flip($mimetypes),$filetype));
		 return  $filetype." => ".$mimetypes[$filetype];
   }
}
///**********************************************************************************/
//
/**  function igual ao cmoando mysql_field_name  */
if( ! function_exists("mysqli_field_name") ) {
    //
   function mysqli_field_name($result, $field_offset) { 
       //
       $properties = mysqli_fetch_field_direct($result, $field_offset);
       return is_object($properties) ? $properties->name : null;    
   }   
   //
}
/**  Final - if( ! function_exists("mysqli_field_name") ) {  */
//
/*****
*    IMPORTANTE: function exatamente como o
*                comando mysql_result no  MYSQLI 
*   Atualizado em 20240527  
****/
///  function mysqli_result($res, $row, $field=0) {
if( ! function_exists("mysqli_result") ) {
    //
    function mysqli_result($res, $row, $fldnm='') {
          //
          mysqli_data_seek($res, $row);
          //
          /**
          *     return mysqli_fetch_array($res)[$field];
          */
         return mysqli_fetch_assoc($res)[$fldnm];
         //
    }
}
/****  Final - function mysqli_result($res, $row, $fldnm='') {   */
//
//  Primeiro verifica se a function nao existe
if( ! function_exists("stringParaBusca") ) {
    //
    //  Funcao para busca com acentos em MySQL
    function stringParaBusca($str) {
        //
        //// Transformando tudo em minusculas
        $str = trim(strtolower($str));

        ///  Tirando espa?os extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
        while ( strpos($str,"  ") )
            $str = str_replace("  "," ",$str);
        
        /// Agora, vamos trocar os caracteres perigosos "?,?..." por coisas limpas "a"
        $caracteresPerigosos = array ("?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","!","?",",","?","?","-","\"","\\","/");
        $caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
        $str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
        
        /* Agora que nao temos mais nenhum acento em nossa string, 
              vamos montar a expressao regular para o MySQL                                             */
        $caractresSimples = array("a","e","i","o","u","c");
        $caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
        $str = str_replace($caractresSimples,$caractresEnvelopados,$str);
        $caracteresParaRegExp = array(
            "(a|?|?|?|?|?|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|?|?|?|?|?|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
            "(e|?|?|?|?|&eacute;|&egrave;|&euml;|&ecirc;|?|?|?|?|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
            "(i|?|?|?|?|&iacute;|&igrave;|&iuml;|&icirc;|?|?|?|?|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
            "(o|?|?|?|?|?|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|?|?|?|?|?|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
            "(u|?|?|?|?|&uacute;|&ugrave;|&uuml;|&ucirc;|?|?|?|?|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
            "(c|?|?|&ccedil;|&Ccedil;)" );
        $str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
        
        ///  Trocando espacos por .*
        $str = str_replace(" ",".*",$str);
        
        //Retornando a String finalizada!
        return $str;
        ///
    }
    /**  Final - function stringParaBusca($str) {  */
    //
}
/**  Final - if( ! function_exists("stringParaBusca") ) {   */
//
//  Primeiro verifica se a function nao existe
if( ! function_exists("stringParaBusca2") ) {
     //
    //  Funcao para modificar minuscula para Maiuscula
    function stringParaBusca2($str) {
         // 
         //  Usar para substituir caracteres com acentos para Maiuscula
         $substituir = array(
                        '/&aacute;/i' => '?',
                        '/&Eacute;/i' => '?',
                        '/&Iacute;/i' => '?',
                        '/&Oacute;/i' => '?',
                        '/&Uacute;/i' => '?',
                        '/&Atilde;/i' => '?',
                        '/&Otilde;/i' => '?',
                        '/&Acirc;/i' => '?',
                        '/&Ecirc;/i' => '?',
                        '/&Icirc;/i' => '?',
                        '/&Ocirc;/i' => '?',
                        '/&Ucirc;/i' => '?',
                        '/&Ccedil;/i' => '?',
                        '/&Agrave;/i' => '?'
         );
        
         ///  $texto =strtoupper($str);
         $substituir0 = array(
                            '/?/' => '&aacute;',
                            '/?/' => '&eacute;',
                            '/?/' => '&iacute;',
                            '/?/' => '&oacute;',
                            '/?/' => '&uacute;',
                            '/?/' => '&atilde;',
                            '/?/' => '&otilde;',
                            '/?/' => '&acirc;',
                            '/?/' => '&ecirc;',
                            '/?/' => '&icirc;',
                            '/?/' => '&ocirc;',
                            '/?/' => '&ucirc;',
                            '/?/' => '&ccedil;',
                            '/?/' => '&Aacute;',
                            '/?/' => '&Eacute;',
                            '/?/' => '&Iacute;',
                            '/?/' => '&Oacute;',
                            '/?/' => '&Uacute;',
                            '/?/' => '&Atilde;',
                            '/?/' => '&Otilde;',
                            '/?/' => '&Acirc;',
                            '/?/' => '&Ecirc;',
                            '/?/' => '&Icirc;',
                            '/?/' => '&Ocirc;',
                            '/?/' => '&Ucirc;',
                            '/?/' => '&Ccedil;',
                            '/?/' => '&agrave;',
                            '/?/' => '&Agrave;'
         );
         ///
         $substituir2 = array('?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',
                            '?' => '?',                        
                            '?' => '?',                        
                            '?' => '?',                                                
                            '?' => '?',                                                                        
                            '?' => '?',                                                                                                
                            '?' => '?'
         );
         ////                            
         /// $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
         $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);
         ///
         return $texto;
         ///
    }
    /**  Final - function stringParaBusca2($str) {  */
    //
}
/**  Final - if( ! function_exists("stringParaBusca2") ) {  */
//
/**  function_exists - verifica se a  function NAO esta ativa  */
if( ! function_exists("tamanho_arquivo") ) {
    //
    ///  Definindo o tamanho do arquivo
    function tamanho_arquivo($valor) {
	      $i=0;
 	      $tipos = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
	      while( ($valor/1024)>1 ) {
	           $valor=$valor/1024;
	           $i++;
	      }
	      ///  return substr($valor,0,strpos($valor,'.')+4)."&nbsp;".$tipos[$i];
          return substr($valor,0,strpos($valor,',')+4)."&nbsp;".$tipos[$i];
          /*
          echo tamanho_arquivo(filesize("/tmp/spfbezer/downloads.zip"));
         */
     }
}
/**  Final - if( ! function_exists("tamanho_arquivo") ) {  */
//
///  function_exists - verifica se a  function NAO esta ativa
if( ! function_exists("isUserID") ) {
    ///  Corrigindo o campo  username/login 
    function isUserID($username) {
        if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
            return true;
        } else {
            return false;
        }
    } 
}
/***********************************************************************************/
///
///  function_exists - verifica se a  function NAO esta ativa
if( ! function_exists("TirarAcento") ) {
    //
    //  Tirar acentos da palavra
    function TirarAcento($Palavra) {
        $Palavra = $Palavra;
        ///
        $ComAcento = " àáâãäèéêëìíîïòóôõöùúûüÀÁÂÃÄÈÉÊËÌÍÎÒÓÔÕÖÙÚÛÜçÇñÑ";
        $SemAcento = " aaaaaeeeeiiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUcCnN";
        $Texto = "";
        if( $Palavra!="" ) {
             for( $i=0;$i<=strlen($Palavra); $i++ ) {
                 $midPalavra = substr($Palavra, $i,1);
                 $Pos_Acento = strpos($ComAcento,$midPalavra);
                 if( intval($Pos_Acento)>0 ) { 
                     $midPalavra = substr($SemAcento, $Pos_Acento,1);
                 }
                 $Texto = $Texto . $midPalavra;
             }
             $TirarAcento = $Texto;
        }
        return utf8_encode($Texto);
    }
    ///  Final -    Tirar acento da palavra
}
/*******************************************************************************************/
///
/***
///  function_exists - verifica se a  function NAO esta ativa  - 20171004
***/
if( ! function_exists("TrocarAcento") ) {
    function TrocarAcento($var) {
            /// Alterar variavel para minuscula
            /// $var = strtolower($var);

            ///  $ComAcento = " àáâãäèéêëìíîïòóôõöùúûüÀÁÂÃÄÈÉÊËÌÍÎÒÓÔÕÖÙÚÛÜçÇñÑ";
        
            ////  $var = preg_replace("[ÀÁÂÃÄ]","A",$var);    
            ///  $var = preg_replace("[ÀÁÂÃÄ]","A",$var);
            /***     FUNCIONA TAMBEM 
                $var = preg_replace("/(À|Á|Â|Ã|Ä)/","A",$var);    
                $var = preg_replace("/à|á|â|ã|ä|ª/","a",$var);    
                $var = preg_replace("[ÈÉÊË]","E",$var);    
                $var = preg_replace("[èéêë]","e",$var);    
                $var = preg_replace("[ÒÓÔÕÖ]","O",$var);    
                $var = preg_replace("[òóôõöº]","o",$var);    
                $var = preg_replace("[ÙÚÛÜ]","U",$var);    
                $var = preg_replace("[ùúûü]","u",$var);    
                $var = str_replace("Ç","C",$var);
                $var = str_replace("ç","c",$var);
                
                ///  Simbolos diferentes
                $var = preg_replace("[Ñ]","N",$var);    
                $var = preg_replace("[ñ]","n",$var);    
           ****/
        
          /// Alterando acentos em UTF-8
          $map = array(
                    'á' => 'a',
                    'à' => 'a',
                    'ã' => 'a',
                    'â' => 'a',
                    'é' => 'e',
                    'ê' => 'e',
                    'è' => 'e',                    
                    'í' => 'i',
                    'ì' => 'i',                    
                    'ó' => 'o',
                    'ô' => 'o',
                    'õ' => 'o',
                    'ò' => 'o',                    
                    'ú' => 'u',
                    'ü' => 'u',
                    'ç' => 'c',
                    'Á' => 'A',
                    'À' => 'A',
                    'Ã' => 'A',
                    'Â' => 'A',
                    'É' => 'E',
                    'Ê' => 'E',
                    'Í' => 'I',
                    'Ó' => 'O',
                    'Ô' => 'O',
                    'Õ' => 'O',
                    'Ú' => 'U',
                    'Ü' => 'U',
                    'Ç' => 'C',
                    'Ñ' => 'N',
                    'ñ' => 'n',
                    'Ý' => 'Y',
                    'ý' => 'y'
          );
          ////
          return strtr($var, $map);  //// funciona corretamente
        ///
    }
    ///  Final -  function  TrocarAcento
} 
///
///  function_exists - verifica se a  function function NAO esta ativa
if( ! function_exists("ValidaData") ) {
    /// Verificando a Data 
     function ValidaData($dat){
            ///  Verificando formato da Data com barra
            if( preg_match("/\//",$dat) ) {
                 $data = explode("/","$dat"); ///  Divide  a string $dat em pedados, usando / como referência
            }
            ///  Verificando formato da Data com hifen
            if( preg_match("/\-/",$dat) ) {
                 $data = explode("-","$dat"); ///  Divide  a string $dat em pedados, usando - como referência
            }
            $res=1;  ///  1 = true (valida)
            $coluna1=$data[0];
            if( strlen($coluna1)<3 ) {
                $d = $data[0];
                $m = $data[1];
                $y = $data[2];
            } elseif( strlen($coluna1)==4 ) {
                $y = $data[0];
                $m = $data[1];
                $d = $data[2];
            }
            if( intval($y)>2100 ) $res=0;  ///  0 = false (vinalida)
            /*
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];
              */
           /// Veerifica se a data é válida!
            /// 1 = true (válida)
             /// 0 = false (inválida)
             //// if( intval($res)==1 )  $res = checkdate($m,$d,$y);
            if( intval($res)==1 ) {
                 $res = checkdate($m,$d,$y); 
            }  
            ///
            /*
               if( $res==1 ) {
                    echo "<br/>data ok! dia=$d - mes=$m - ano=$y ";
               } else {
                     echo "<br/>data inválida!";
               }
              */ 
            ////
            return $res;
     }
     ///  Final - verificando a data
}
////
?>