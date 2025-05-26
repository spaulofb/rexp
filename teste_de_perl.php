<?php
///  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
}
/*
        testecharset.html
        
        Copyright 2008 Marco Antonio <coyote@work>
        
        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.
        
        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
        
        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
        MA 02110-1301, USA.
*/        
/// ini_set("/var/www/cgi-bin");
/// ini_set("include_path", ".:/var/www/cgi-bin");

// Funciona a partir do PHP 4.3.0
get_include_path();

////  require_once('php_include/phpinfo.php');
///  require_once('php_include/cgi.pl');
$_POST["script"]="hashes.pl";
///  $_POST["script"]="foo.pl";

require("perl/executar_perl.php");

////   passthru("/usr/bin/perl -w /var/www/cgi-bin/i_perl/hashes.pl ");
///passthru("/usr/bin/perl -w .:perl/foo.pl ");

?>
