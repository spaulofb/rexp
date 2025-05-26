<?php
///
/*********   Criado em 20190329               *******/   
///
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); /// sempre modificada
header("Pragma: no-cache"); // HTTP/1.0
header("Cache: no-cache");
header("http-equiv='Cache-Control' content='no-store, no-cache, must-revalidate'");

/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

/// header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0")

//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');
///
ini_set('default_charset','UTF-8');
///
?>