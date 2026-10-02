<?php
//  Verificando se sseion_start - ativado ou desativado
if( !isset($_SESSION)) {
     session_start();
}
///
$captchacodigo = substr(md5(time()) ,0,5);

$_SESSION["captchacodigo"] = $captchacodigo;

$imagemCaptcha = imagecreatefrompng("captcha_fundop.png");

$fonteCaptcha = imageloadfont("captcha_anonymous.gdf");

$corCaptcha = imagecolorallocate($imagemCaptcha,127,127,127);

imagestring($imagemCaptcha,$fonteCaptcha,15,5,$captchacodigo,$corCaptcha);

header("Content-type: image/png");

imagepng($imagemCaptcha);
////   imagedestroy($imagemCaptcha);
///
?>