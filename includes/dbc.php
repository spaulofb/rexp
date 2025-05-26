<?php
/*************** PHP LOGIN SCRIPT V 2.3*********************
(c) Balakrishnan 2010. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.

/******************** MAIN SETTINGS - PHP LOGIN SCRIPT V2.1 **********************
Please complete wherever marked xxxxxxxxx

/************* MYSQL DATABASE SETTINGS *****************
1. Specify Database name in $dbname
2. MySQL host (localhost or remotehost)
3. MySQL user name with ALL previleges assigned.
4. MySQL password

Note: If you use cpanel, the name will be like account_database
*************************************************************/
///  Verificando se sseion_start - ativado ou desativado
if( !isset($_SESSION)) {
     session_start();
}
////
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

///  Mensagens pra serem enviadas
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///
///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
////  config.php
#     TESTANDO
///  $elemento=8;
///  Muito MELHOR ESSE JEITO
$elemento=5; $elemento2=6; 
//// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
include("php_include/ajax/includes/conectar.php");
if( isset($_SESSION["bd_1"]) ) {
    $bd_1=$_SESSION["bd_1"];
} else {
    $msg_erro .= "Sessão bd_1 não está ativa.".$msg_final;  
    echo $msg_erro;
    exit();
}
/// mysql_select_db($elemento);
mysql_select_db($bd_1);

/*   Iniciando conexao - CADASTRAR PROJETO   */
//  @require_once('../inicia_conexao.php');  once = somente uma vez
//  include('../inicia_conexao.php');
#
/*  NUNCA USAR ISSO
     @require_once('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
     include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
*/
define ("DB_HOST", "xxxxxx"); // set database host
define ("DB_USER", "xxxxxx"); // set database user
define ("DB_PASS","xxxxxxx"); // set database password
define ("DB_NAME","xxxxxx"); // set database name

//  $link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
//  $db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
$link  = $lnkcon; //  conectamos ao mysql
//// $db = $lnkdb; // selecionamos o database escolhido
$db = $bd_1; // selecionamos o database escolhido
/* Registration Type (Automatic or Manual) 
   1 -> Automatic Registration (Users will receive activation code and they will be automatically approved after clicking activation link)
   0 -> Manual Approval (Users will not receive activation code and you will need to approve every user manually)
*/
$user_registration = 1;  // set 0 or 1

define("COOKIE_TIME_OUT", 10); //specify cookie timeout in days (default is 10 days)
define('SALT_LENGTH', 10); // salt for password
/// define ("ADMIN_NAME", "admin"); // sp

/*   Specify user levels    */
define("ADMIN_LEVEL", 5);
define("USER_LEVEL", 1);
define("GUEST_LEVEL", 0);

/*************** reCAPTCHA KEYS****************/
$publickey = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$privatekey = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
********************************************************/

function page_protect() {
     ////  session_start();
     global $db; 
    /* Secure against Session Hijacking by checking user agent */
    if( isset($_SESSION["HTTP_USER_AGENT"]) ) {
         if ( $_SESSION["HTTP_USER_AGENT"] != md5($_SERVER["HTTP_USER_AGENT"]) ) {
                logout();
                exit();
         }
    }
    //  Antes de que permitamos sess?es, temos de verificar a 
    //   chave de autentica??o - ckey e ctime fornecido no banco de dados
   /* If session not set, check for cookies set by Remember me */
    if ( !isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) ) {
	     if( isset($_COOKIE['user_id']) && isset($_COOKIE['user_key']) ) {
	           /* we double check cookie expiry time against stored in database */
	         	$cookie_user_id  = filter($_COOKIE['user_id']);
	            $rs_ctime = mysql_query("select `ckey`,`ctime` from `users` where `id` ='$cookie_user_id'") or die(mysql_error());
	            list($ckey,$ctime) = mysql_fetch_row($rs_ctime);
	            // coookie expiry
	            if( (time()-$ctime) > 60*60*24*COOKIE_TIME_OUT) {
                       logout();
		        }
                /* Security check with untrusted cookies - dont trust value stored in cookie. 		
/* We also do authentication check of the `ckey` stored in cookie matches that stored in database during login*/
                if( !empty($ckey) && is_numeric($_COOKIE['user_id']) && isUserID($_COOKIE['user_name']) && $_COOKIE['user_key'] == sha1($ckey)  ) {
            	 	  session_regenerate_id(); // Contra ataques de fixa??o de sess?o.
	        		  $_SESSION['user_id'] = $_COOKIE['user_id'];
		              $_SESSION['user_name'] = $_COOKIE['user_name'];
		              /* query user level from database instead of storing in cookies */	
		               list($user_level) = mysql_fetch_row(mysql_query("select user_level from users where id='$_SESSION[user_id]'"));
            		  $_SESSION['user_level'] = $user_level;
		              $_SESSION["HTTP_USER_AGENT"] = md5($_SERVER["HTTP_USER_AGENT"]);
        	   } else {
	               logout();
	           }

         } else {
             //   header("Location: auth_user.php");
	          exit();
	     }
   } else {
       echo "SETADOS";
       exit();
   }
}
//
function filter($data) {
    // strip_tags - Esta fun??o tenta retornar uma string retirando todas as tags HTML e PHP de str
	$data = trim(htmlentities(strip_tags($data)));
	
    //  get_magic_quotes_gpc() - Obtem a configuracao atual de magic quotes gpc
	if ( get_magic_quotes_gpc() ) $data = stripslashes($data);
	$data = mysql_real_escape_string($data);
	return $data;
}
//
function EncodeURL($url) {
    $new = strtolower(ereg_replace(' ','_',$url));
    return($new);
}
//
function DecodeURL($url) {
     $new = ucwords(ereg_replace('_',' ',$url));
     return($new);
}
//
function ChopStr($str, $len) {
    if ( strlen($str)<$len )  return $str;

    $str = substr($str,0,$len);
    if ( $spc_pos=strrpos($str," ") ) $str = substr($str,0,$spc_pos);
    return $str . "...";
}	
//
function isEmail($email) {
    return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}
//
//  Corrigindo o campo  $username 
function isUserID($username) {
	if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
		return true;
	} else {
		return false;
	}
}	
// 
function isURL($url) {
	if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
		return true;
	} else return false;
} 
//
function checkPwd($x,$y) {
    if( empty($x) || empty($y) ) { return false; }
    if (strlen($x) < 4 || strlen($y) < 4) { return false; }

    if (strcmp($x,$y) != 0) return false;
    return true;
}
//   Criando uma nova senha
//  function GenPwd($length = 7) {
include("gerar_senha.php");
//
function GenKey($length = 7) {
  $password = "";
  $possible = "0123456789abcdefghijkmnopqrstuvwxyz";  // nenhuma vogal
  
  $i = 0; 
  while ($i < $length) { 
     $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
     if (!strstr($password, $char)) { 
         $password .= $char;
         $i++;
     }
  }
  return $password;
}
//
function logout() {
    global $db;
    session_start();
    if( isset($_SESSION['user_id']) || isset($_COOKIE['user_id']) ) {
          mysql_query("update `users`  set `ckey`= '', `ctime`= '' 
			where `id`='$_SESSION[user_id]' OR  `id` = '$_COOKIE[user_id]'") or die(mysql_error());
    }			
    /************ Delete the sessions****************/
    unset($_SESSION['user_id']); unset($_SESSION['user_name']);
    unset($_SESSION['user_level']); unset($_SESSION["HTTP_USER_AGENT"]);
    session_unset();
    session_destroy(); 
    /* Delete the cookies*******************/
    setcookie("user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
    setcookie("user_name", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
    setcookie("user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
    header("Location: auth_user.php");
}

// Password and salt generation
function PwdHash($pwd, $salt = null) {
    if ( $salt===null ) {
           $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    } else  {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
}
//
function checkAdmin() {
   if( $_SESSION['user_level']==ADMIN_LEVEL) {
       return 1;
   } else  return 0 ;
}
?>