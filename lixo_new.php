<?php

$pasta="/var/www/html/rexp/doctos_img/A2416911/anotacao/";

///  mb_convert_encoding("file_å.txt", "UTF-8")
///  $resultado=@file_exists(mb_convert_encoding("{$pasta}P2A1_LIVRO programação.pdf","UTF-8"));
///  $winfilename= iconv('utf-8', 'cp1252', $utffilename);
////  $resultado=@file_exists("{$pasta}".'P2A1_LIVRO programação.pdf');
//// $utffilename="P2A1_LIVRO programação.pdf";
///   $arquivo="P2A1_LIVRO programação.pdf";
$utffilename='P2A1_LIVRO Programação  %de Dispositivos  $Móveis  Módulo_3_2_melhores_lances.pdf'; 
$utffilename=preg_replace('$','\$',"P2A1_LIVRO Programação  %de Dispositivos  $Móveis  Módulo_3_2_melhores_lances.pdf") ; 
////   $arquivo=$utffilename; 


/// $utffilename="P2A1_LIVRO Programação  %de Dispositivos  $Móveis  Módulo_3_2_melhores_lances.pdf"; 
echo  "<p>".quotemeta($utffilename)."</p><br/>";
$arquivo=quotemeta($utffilename);

/// $arquivo="P2A1_LIVRO programação.pdf";
$utffilename="P2A1_LIVRO Programação  %de Dispositivos  $Móveis  Módulo_3_2_melhores_lances.pdf"; 
//// $arquivo=preg_replace("~$~","\$","$utffilename"); 
$arquivo=preg_replace("$","\\$","$utffilename"); 
$dir_arq="{$pasta}{$arquivo}";

echo "<br/>----->>>>> \$dir_arq = $dir_arq <<<----- <br/>";

$resultado=@file_exists("$dir_arq");
///  $resultado=@file_exists("{$pasta}".'P1A2_Capitulo2.pdf');
if( ! $resultado ) {

/// if( ! file_exists("{$pasta}{$arquivo}") ) {
/// if( ! file_exists(utf8_decode("$dir_arq")) ) {
////  if( ! file_exists("$dir_arq") ) {             
     /* $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
     echo $msg_erro;  
     */
      echo  "<b> Não encontrado <<--  </b>";         
}  else {
    echo "<p style='color: #00FF09;text-align:center;font-weight:bold;' >OK - ENCONTRADO:<br/>$arquivo</p>";
    exit();
    ///
} 



$arq='P2A1_Anotação Apresentação Programação $Nova -% Cópia.pdf';
/////  $dir_arq="/var/www/html/rexp/doctos_img/A2416911/anotacao/P2A1_SIMPÓSIO DE MUTAGENESE E ONCOLOGIA  GENÉTICA  - Cópia.pdf";
$dir_arq="/var/www/html/rexp/doctos_img/A2416911/anotacao/$arq";
$dir="/var/www/html/rexp/doctos_img/A2416911/anotacao/";
////  $arq="P2A1_SIMPÓSIO DE MUTAGENESE E ONCOLOGIA  GENÉTICA  - Cópia.pdf";
$teste="/bin/find $dir -name $arq ";
$output = shell_exec("$teste");
echo "<pre>1)  $output<br/><br/></pre>";

exec("ls $dir_arq ",$x,$output);
echo "<pre>2)  $output<br/><br/></pre>";

$xfile = glob("$dir_arq");

echo "<br/><b> $xfile count =  ".count($xfile)."</b><br/>";

exec($teste,$out,$status);
echo "<b> \$out = $out  --->>> \$status = $status </b> <br/><br/>";
if( isset($out[0]) ) {
     echo "ACHOU ".$out[0]."<br/><br/>";
} else {
     echo "<b>NÃO</b>  ACHOU <br/><br/>";
}
$file1=scandir($dir);
/////  print_r($file1);

if( in_array($arq,$file1) ) {
    echo    "<p>ACHO NO ARRAY OKOK  </p>";
}


///

if( ! file_exists(utf8_decode("$dir_arq")) ) {
      $msg_erro = "&nbsp;Esse Arquivo: ".$dir_arq."  n&atilde;o tem no Servidor";
         echo $msg_erro;  
}  else {
    echo "$dir_arq  -->>  EXISTE    ";           
}
///
?>
<html>
<head>
<title>Teste</title>
<link     >
</head>
<body>



</body>
</html>

