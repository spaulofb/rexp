<?php
/***
*      ATUALIZADO EM 20210629
***/
///
////  function criar e salvar arquivo
if( ! function_exists("cr_sv_arq") ) {
    ///
    function cr_sv_arq($msgcmd) {
        ///
        /**   
       *   -  Caminho do diretorio apache    
       *   -     onde cria e salva arquivos
       *  atualizado em 20211119
       ***/
       $drtmp=$_SERVER["DOCUMENT_ROOT"]."/gemac/patrimonio/tmp/";
       ///
       ///  Pasta e Arquivo
       $file_path = "{$drtmp}msgres.txt";
       if( is_file("{$file_path}") ) {
            /// Remover arquivo 
            unlink($file_path);
       }
       ///
       ///    Crinado arquivo requerendo dados
       if( preg_match("/!%@!/ui",$msgcmd) ) {
           ///  Criando Array
           $arrx=explode("!%@!",$msgcmd);
           ///
           ///  Criando arquivo
           $f = fopen($file_path, 'a+');
           if( !  $f ) {
                die('Erro criando o arquivo: ' . $filename);
                exit();
           }
           ///
           foreach( $arrx as $xval ) {
                ////    fputs($f, $number);
                $elem="{$xval}\r\n";
                fwrite($f, $elem);
           }
           fclose($f);
           ///
       } else {
           /// Criando arquivo e recebendo dados
           file_put_contents("{$file_path}","$msgcmd");       
       }
       ///
    }
    ///
}
///   Final - if( ! function_exists("cr_sv_arq") ) {  
///
/****
*      function converte DATA YYYY-MM-DD PARA DD/MM/YYYY
*  Atualizado em  20220908
***/
if( ! function_exists("convert_data") ) {
     ///
     function convert_data($dataphp) {   
            ///
            $dtconv="";
           /// IMPORTANTE - Para converter data Mysql para PHP 
           ///
           //// DATA CONVERTER 
           $dataphp = trim($dataphp);
           $dataphp = str_replace("/","-","$dataphp");
           if( strlen($dataphp)>0 ) {
                $dtconv=explode("-",$dataphp);
                if( sizeof($dtconv)>2 ) {
                    $dtconv=$dtconv[2].'/'.$dtconv[1].'/'.$dtconv[0];    
                } else{
                    $dtconv='';   
                }
                
                /***
                if( strlen(trim($dtconv))<3 ) {
                    $dtconv='';  
                } 
                ***/
                
                ///
           } 
           ///  Final - if( strlen(trim($dataphp))>0 ) {               
           ///
           //  Caso formato igual 00/00/0000
           if( $dtconv=="00/00/0000"  ) {
               $dtconv="";
           }
           ///
           return $dtconv;
           ///
     }    
}    
///  Final - function conv_dt_ht5($dataphp) {   
///

/****
*      function converte data PHP para HTML5
*   input type date  value
***/
if( ! function_exists("conv_dt_ht5") ) {
     function conv_dt_ht5($dataphp) {   
           /// IMPORTANTE - Para converter data Mysql para PHP 
           if( preg_match("/-/",$dataphp) ) {
               $dataphp = explode("-",$dataphp);
               $dataphp = implode("/",array_reverse($dataphp));      
           } 
           /// Convertendo data pava HTML5 type date  value
           $time = strtotime($dataphp);
           return date('Y-m-d',$time);
     }    
}    
///  Final - function conv_dt_ht5($dataphp) {   
///
///   function get_ftp_mode($file) {   
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
}
/**  Final - if( ! function_exists("get_ftp_mode") ) {  */
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
//  Corrigindo o campo  username/login 
if( ! function_exists("isUserID") ) {
    function isUserID($username) {
        if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
            return true;
        } else {
            return false;
        }
    }   
}
/******  Final - if( ! function_exists("isUserID") ) {   *****/
///
function isWordAtEnd($text, $word) {
    ///
    /**** 
    **      Remove espaços em branco extras no final do texto   
    *   Atualizado em 20240528
    ****/
    $text1 = rtrim($text);
    ///
    $pstn=strripos($text1,$word);
    ///
    if( strlen(trim($pstn))>0 ) {
         ///
         $nchars=strlen($word);
         ///
         $xz=strlen($text1)-$nchars;
         ///
         if( intval($xz)==intval($pstn) ) {
             /// Substituir texto
             $text = substr($text1,0,$pstn);
         }
         /****  Final - if( intval($xz)==intval($pstn) ) {  ****/
         ///
         
     /*****    
         echo "ERRO: \$xz = $xz <<-->> \$pstn = $pstn  ";
         exit();
     *********/    
         
         ///                                            
    }
    /*****   Final - if( strlen(trim($pstn))>0 ) {  ****/
    ///
    return $text;
    ///
}
/***  Final - function isWordAtEnd($text, $word) {  *****/
///
/*****
*    IMPORTANTE: function exatamente como o
*                comando mysql_result no mysql 
*   Atualizado em 20240527  
****/
///  function mysqli_result($res, $row, $field=0) {
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
/****  Final - function mysqli_result($res, $row, $fldnm='') {  ****/
//
/**
*     extract: Importa variaveis para a tabela de simbolos a partir de um array 
*/
if( ! function_exists("mime_type") ) {  
    function mime_type($file) {
            
            $filetype = substr(strrchr($file,'.'),1);
            
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
                            "csv" => "text/csv",
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
    ///
}
///
///  Definindo o tamanho do arquivo
if( ! function_exists("tamanho_arquivo") ) {
    function tamanho_arquivo($valor) {
	    $i=0;
	    $tipos = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
	    while( ($valor/1024)>1 ) {
	        $valor=$valor/1024;
	        $i++;
	    }
	    //  return substr($valor,0,strpos($valor,'.')+4)."&nbsp;".$tipos[$i];
         return substr($valor,0,strpos($valor,',')+4)."&nbsp;".$tipos[$i];
	     
	     /*
          echo tamanho_arquivo(filesize("/tmp/spfbezer/downloads.zip"));
         */
    }
}
///
///  Corrigir acentos 
if( ! function_exists("trocar_acentos") ) {         
    function trocar_acentos($uploaded) {
        $uploaded = str_replace(' ','_',$uploaded);
        $uploaded = str_replace('?','a',$uploaded);
        $uploaded = str_replace('?','a',$uploaded);
        $uploaded = str_replace('?','a',$uploaded);
        $uploaded = str_replace('?','a',$uploaded);
        $uploaded = str_replace('?','e',$uploaded);
        $uploaded = str_replace('?','e',$uploaded);
        $uploaded = str_replace('?','i',$uploaded);
        $uploaded = str_replace('?','i',$uploaded);
        $uploaded = str_replace('?','o',$uploaded);
        $uploaded = str_replace('?','o',$uploaded);
        $uploaded = str_replace('?','u',$uploaded);
        $uploaded = str_replace('?','u',$uploaded);
        $uploaded = str_replace('(','',$uploaded);
        $uploaded = str_replace(')','',$uploaded);
        $uploaded = str_replace('?','c',$uploaded);
        $uploaded = str_replace('?','c',$uploaded);
        $uploaded = strtolower($uploaded);
        return $uploaded;
    }
}
///
/***
*          IMPORTANTE
*      Alterado em 20200116
*   function para definir Type/Tipo do campo da Tabela
***/
if( ! function_exists("getColumnDataType") ) {    
///     
    function getColumnDataType($info) {
         ///
        ///  DEFAULT DATA TYPES
        $mysql_data_type_hash = array(
        1=>'tinyint',
        2=>'smallint',
        3=>'int',
        4=>'float',
        5=>'double',
        7=>'timestamp',
        8=>'bigint',
        9=>'mediumint',
        10=>'date',
        11=>'time',
        12=>'datetime',
        13=>'year',
        16=>'bit',
        //252 is currently mapped to all text and blob types (MySQL 5.0.51a)
        253=>'varchar',
        254=>'char',
        246=>'decimal'
        );
        ///
        return $mysql_data_type_hash[$info];
        ///
    }
    ///
}
/*******   Final  -  function getColumnDataType($info) {  ****/
///
/// IPORTANTE: Function para verificar data - 2019-11-05
if( ! function_exists("ValidaData") ) {
    /***
    *    function ValidaData 
    *      exuste no arquivo header_e_outros_ajax.php
    ***/
    function ValidaData($dat) {
        ///  Criada em 20190516
        /// IMPORTANTE: ini_set pra acentuacao
        ini_set('default_charset','utf8');
        
        ///  Verificando os simbolos / ou -  na data
        ///  Verificando as datas
        $dat=trim($dat);
        $nlen_dat=strlen($dat);
        if( intval($nlen_dat)!=10  ) {
             ///  Verificando Data       
            switch ($dat)  {
                 case "":
                 case "//":
                 case "--":
                      $dat="0000-00-00";
                      break;
                 default:
                      $dat = "";
                      break;
            }
            /// echo $funcoes->mostra_msg_erro("Vigencia: Data Inicial errada. Corrigir");
            return $dat;
        }
        ///
        /// Verificando simbolo /
        $simb1pos=strpos($dat,"/");
        if( intval($simb1pos)>0 ) {
            if( substr_count($dat, '/')!=2  ) {
                return  "";
            } 
            ///
            $dat= preg_replace('/\//', '-', $dat); 
            ///
        }
        ///
        /// Verificando simbolo -
        $simb2pos=strpos($dat,"-");
        if( intval($simb2pos)>0 ) {
            if( substr_count($dat, '-')!=2  ) {
                 return  "";
            } 
            ///
            $arr_dat=explode("-",$dat);
            if( intval($simb2pos)==2 ) {
                $d = $arr_dat[0];
                $m = $arr_dat[1];
                $y = $arr_dat[2];
            } else {
                $d = $arr_dat[2];
                $m = $arr_dat[1];
                $y = $arr_dat[0];
            }     
            /// Verificar caso for 000000-00
            $dat = "$y-$m-$d";
            if( $dat=="0000-00-00" ) {
                return $dat;
            }
        } else {
            $dat = "";
        }
        ///
        if( strlen($dat)>0 ) {
             /*
                verifica se a data é válida!
                  1 = true (válida)
                  0 = false (inválida)
            */
            $res = checkdate($m,$d,$y);
            if( ! $res==1 ) {
                $dat = "";
            }
        }
        return $dat; 
        ///
    }
    ///
}
///  Final - function ValidaData($dat){
///
?>