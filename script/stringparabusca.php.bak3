<?php
//
//  Funcao para busca com acentos (MySQL REGEXP)
if (!function_exists("stringParaBusca")) {
    function stringParaBusca($str) {
        // Transformando tudo em minúsculas (UTF-8)
        $str = trim(mb_strtolower($str, 'UTF-8'));

        // Tirando espaços extras
        $str = preg_replace('/\s+/', ' ', $str);

        // Montar expressão REGEXP para o MySQL com tolerância a acentos
        $mapa = array(
            'a' => '(a|á|à|ã|â|ä|Á|À|Ã|Â|Ä|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)',
            'e' => '(e|é|è|ê|ë|É|È|Ê|Ë|&eacute;|&egrave;|&euml;|&ecirc;|&Eacute;|&Egrave;|&Euml;|&Ecirc;)',
            'i' => '(i|í|ì|î|ï|Í|Ì|Î|Ï|&iacute;|&igrave;|&iuml;|&icirc;|&Iacute;|&Igrave;|&Iuml;|&Icirc;)',
            'o' => '(o|ó|ò|õ|ô|ö|Ó|Ò|Õ|Ô|Ö|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)',
            'u' => '(u|ú|ù|û|ü|Ú|Ù|Û|Ü|&uacute;|&ugrave;|&uuml;|&ucirc;|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)',
            'c' => '(c|ç|Ç|&ccedil;|&Ccedil;)',
        );

        // Primeiro: normalizar acentos para letras simples
        $str = Normalizer::normalize($str, Normalizer::FORM_D);
        // Remover os combining marks (diacritics)
        $str = preg_replace('/\pM/u', '', $str);

        // Agora substituir letras simples pelos padrões REGEXP
        $str = str_replace(array_keys($mapa), array_values($mapa), $str);

        // Trocando espaços por .*
        $str = str_replace(' ', '.*', $str);

        return $str;
    }
}

//
//  Funcao para minuscula para Maiuscula (conversão com acentos)
if (!function_exists("stringParaBusca2")) {
    function stringParaBusca2($str) {
        // Converter entidades HTML para caracteres reais
        $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Converter para maiúsculas respeitando UTF-8
        $str = mb_strtoupper($str, 'UTF-8');

        return $str;
    }
}
//
?>
