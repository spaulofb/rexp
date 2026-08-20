<?php
//  ALterado em 20120504 - Patrimonio
//  Verificando se sseion_start - ativado ou desativado
if( !isset($_SESSION)) {
     session_start();
}
//
$useragent = $_SERVER['HTTP_USER_AGENT'];
$nao_aceitar=1;
//
$http_host = $_SERVER["HTTP_HOST"];
//  $http_host = str_replace('_','-',$http_host);
//  $http_host = str_replace('-','_',$http_host);
// $_SESSION["pasta_raiz"]='/gemac/patrimonio/';
//
//
if( preg_match('|MSIE ([0-9]{1,2}.[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'IE';
    $nao_aceitar=0;
    $http_host = str_replace('_','-',$http_host);
    $_SERVER["HTTP_HOST"]=$http_host;
    //
} elseif( preg_match('/Trident\/7\.0; rv:11\.0/i',$_SERVER['HTTP_USER_AGENT'],$matched) ) {
    //  $browser_version=$matched[1];
    $browser = 'IE';
    $nao_aceitar=0;
    $http_host = str_replace('_','-',$http_host);
    $_SERVER["HTTP_HOST"]=$http_host;
    //
} elseif (preg_match( '|Opera/([0-9]{1,2}.[0-9]{1,2})|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Opera';
             $http_host = str_replace('-','_',$http_host);
} elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Firefox';
            $nao_aceitar=0;
            $http_host = str_replace('-','_',$http_host);    
} elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Chrome';
             $nao_aceitar=0;
             $http_host = str_replace('-','_',$http_host);
} elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Safari';
            $http_host = str_replace('-','_',$http_host);
} else {
    // browser not recognized!
    $browser_version = 0;
    $browser= 'other';
}
//  Verifica se Navegador foi aceito
if( $nao_aceitar==1  ) {
    ?>
    <p style="text-align: center; font-size: larger; font-weight: bold;" >Esse Navegador/Browser: <?php echo $browser;?>  n&atilde;o &eacute; aceito no programa.</p> 
    <?php
     //  Navegador e versao
     //  print "browser: $browser $browser_version";
     exit();
}
//
if( isset($browser) ) $_SESSION["navegador"]=trim($browser);
//
$_SESSION["http_host"]=$http_host;
?>