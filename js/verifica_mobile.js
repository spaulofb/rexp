/*
     Indentifica o User Agent do navegador cliente
*/
var ua = navigator.userAgent.toLowerCase();
var uMobile = '';

// === REDIRECIONAMENTO PARA iPhone, Windows Phone, Android, etc. ===
// Lista de substrings a procurar para ser identificado como mobile WAP

uMobile = '';
uMobile += 'iphone;ipod;windows phone;android;iemobile 8';

// Sapara os itens individualmente em um array

v_uMobile = uMobile.split(';');

/// percorre todos os itens verificando se eh mobile
var boolMovel = false;
for( i=0;i<=v_uMobile.length;i++ ) {
    if (ua.indexOf(v_uMobile[i]) != -1)    {
        boolMovel = true;
    }
}
///  Caso for SmartPhone, celular etc...  Alterar rota
if( boolMovel==true ) {
      ////  location.href='http://www.adrianogianini.com.br/testeresponsivo/mobile';
       ////   location.href='http://www.google.com.br/';
        location.href='./mobile';      
}
/// 
