<?php
/*
*   REXP - REGISTRO DE EXPERIMENTO - ANOTAÇÃO DE PROJETO
* 
*       MODULO: index_ajax - complemento AJAX do index 
*  
*   LAFB/SPFB110827.1736 - Correções gerais
*/

ob_start(); /* Evitando warning */
#
//  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
} 
//
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
// extract: Importando variáveis POST para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE); 
///  Enviando o codigo
///  if( isset($_SESSION["captchacodigo"]) && ( ! isset($_SESSION["PASSOU"]) ) ) {
///  if( ! isset($_SESSION["PASSOU"]) ) {
////  echo $_SESSION["captchacodigo"];    
///  include("captcha_criar.php");
$captchacodigo = substr(md5(time()),0,5);
$_SESSION["captchacodigo"] = $captchacodigo;
$imagemCaptcha = imagecreatefrompng("captcha_fundop.png");
$fonteCaptcha = imageloadfont("captcha_anonymous.gdf");
$corCaptcha = imagecolorallocate($imagemCaptcha,127,127,127);
imagestring($imagemCaptcha,$fonteCaptcha,15,5,$captchacodigo,$corCaptcha);
header("Content-type: image/png");
imagepng($imagemCaptcha);
////
sleep(2);
              
/*  limpar o buffer  */
ob_end_flush(); 
///
?>
