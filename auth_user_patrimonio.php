<?php
//
// Formulario Patrimonio 
//
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // sempre modificada
header("Pragma: no-cache"); // HTTP/1.0
header("Cache: no-cache");
//  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
// Força a recarregamento do site toda vez que o navegador entrar na página
header("http-equiv='Cache-Control' content='no-store, no-cache, must-revalidate'");
//  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0")
srand((double)microtime()*1000000);
$randval = rand();
//  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
     if( isset($recebe) ) unset($recebe);
} 
//
//  USANDO O  patrimonio - TESTE - RETIRAR DEPOIS
///  $_SESSION["patrimonioteste"]="patrimonio2";
$_SESSION["patrimonioteste"]="patrimonio";
if( isset($_SESSION["patrimonioteste"]) ) unset($_SESSION["patrimonioteste"]);
///  $_SESSION["patrimonioteste"]="patrimonio_teste";

//  Metodo POST
if( isset($_POST["http_host"]) ) $_SESSION["http_host"] = $_POST["http_host"];
if( isset($_POST["pasta_raiz"]) ) $_SESSION["pasta_raiz"] = $_POST["pasta_raiz"];
//
//    Inclusão da biblioteca especial para o patrimonio
include("php_include/patrimonio/bibesp1.php");
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
//
if( isset($_POST['x_y']) ) {
   $_SESSION['x_y'] = $_POST['x_y'];
} elseif( isset($_SESSION['x_y'])  ) {
    $_POST['x_y'] = $_SESSION['x_y'];
}
//
if( isset($_POST['x_y_z']) ) {
   $_SESSION['x_y_z'] = $_POST['x_y_z'];
} elseif( isset($_SESSION['x_y_z'])  ) {
    $_POST['x_y_z'] = $_SESSION['x_y_z'];
}
//
if( ! isset($_SESSION['x_y']) ) {
  exit();  
}
if( ! isset($_SESSION['x_y_z']) ) {
  exit();  
}
//
$x1= $_SESSION['x_y'];
$x2= $_SESSION['x_y_z'];
if( isset($_POST["codimgsys"]) ) {
      $codimgsys=$_POST["codimgsys"];   
}  else $codimgsys="";
//
// require_once("{$_SESSION["incluir_arq"]}includes/navegador_permitido.php");
require_once('php_include/patrimonio/library/navegador_usado.php');

$_SESSION["url_central"] = "http://".$_SESSION["http_host"].$_SESSION["pasta_raiz"];
///
//  if( ! isset($_SESSION["codimgsys"]) ) $_SESSION["codimgsys"]="";
//
//    ATENÇÃO - NÃO PODE TER <ECHO "qualquer coisa"> QUANDO ESTIVER USANDO SAJAX
//              ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";
$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";
$msg_final="</span></span>";
//
//  echo "codimgsys=".$codimgsys."  ---  session_codimgsys=".$_SESSION["codimgsys"]."<br><br>";
if( $codimgsys!=""  ) {
    //
    //    1. Criar registro de log de entrada do usuário
    //    2. Ativar a página inicial do patrimonio
    //
    //    include("/var/www/cgi-bin/php_include/patrimonio/campos_php.php");  
    include("php_include/patrimonio/campos_php.php");  
    //  session_register("edUsuario","edSenha","x_y","res4");
    if( isset($edUsuario) ) $_SESSION["edUsuario"] = $edUsuario;
    if( isset($edSenha) ) $_SESSION["edSenha"] = $edSenha;
    if( isset($x_y) ) $_SESSION["x_y"] = $x_y;
    if( isset($res4) ) $_SESSION["res4"] = $res4;
    //
    if( isset($codimgsys) ) $_SESSION["codimgsys"] = $codimgsys;
    $x_y=2;
    $x_y = $campos_patrimonio[$x_y];
    $retcod = nova($x_y);
    //
    //  unset($userid,$userpassword);
    exit();
}
//  $n_vezes =  $_SESSION['n_vezes']  ;  
$n_vezes =  1;
if( isset($_POST['keynum']) ) {
   $_SESSION['keynum'] = $_POST['keynum'];
} elseif( isset($_SESSION['keynum'])  ) {
    $_POST['keynum'] = $_SESSION['keynum'];
}

$keynum = $_SESSION['keynum'];
//
if ( $x1===$x2 ) {
    //
    //  Fontes CSS - 20080415
    include("css/css_cadastro_equipamento.php");
    $teste_style = $_SESSION["teste_style"] ;
   //
} else {
  echo "CANCELADO - Sem registro";
  exit;
}
//
function nova($recebe) {
  if( $recebe ) {
     // 
     $sqlret =   db_connect('patrimonio');
     $data = date("Y-m-d");
     $hora = date("H:i:s");
     $novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
     $novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
     //  $mysqldate = date('Y-m-d H:i:s',$phpdate);
     $mysqldate = date('Y-m-d H:i:s');
     $phpdate = strtotime($mysqldate);
     if( isset($_SESSION['codigousp']) ) $codigousp = intval($_SESSION['codigousp']);
     $timestamp = time();
     $ipint = $_SESSION['ipacesso'];
     $codimgsys = $_SESSION['codimgsys'];   
     include("php_include/patrimonio/conectando.php");
     if( isset($_SESSION['dbname']) ) $dbname=$_SESSION['dbname'];     
      // Melhor jeito da data e hora atual
     $result_dthora = mysql_query("SELECT now()");
     $datetime =mysql_result($result_dthora,0,0);
     //    $sqlcmd = "INSERT INTO $dbname.sessao (datahorai,usuario,ipacesso,codacesso) values(now(),$codigousp,$ipint,'$codimgsys') ";
    //  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    //  Execute the queries 
    //  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
    mysql_select_db($dbname);
    //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
    //   - Use mysql_select_db() ou mysql_query()
    $sqlcmd = "INSERT INTO $dbname.sessao (datahorai,usuario,ipacesso,codacesso) values('$datetime',$codigousp,$ipint,'$codimgsys') ";
     $success=mysql_query($sqlcmd); 
    //  Complete the transaction 
    if ( $success ) { 
         //  Inserindo dados na Tabela Sessao do usuario cadastrado
         mysql_query('commit'); 
    } else {
         $msg_erro .="&nbsp;INSERT INTO TABELA SESSAO - Falha db/mysql: ".mysql_error().$msg_final;
         mysql_query('rollback'); 
    }
    mysql_query('end'); 
    mysql_query('DELIMITER');
   //  FINAL -  TABELA ANOTACAO  -  BD  REXP
   if( $success ) { 
         //
         
       //  $dbname="patrimonio_teste";
         
         //  Alterado corrigido em  20131107
         //  $sqlcmd2 = "SELECT * from  $dbname.sessao where codigo=LAST_INSERT_ID()"; // consulta
         $sqlcmd2 = "SELECT * FROM  $dbname.sessao  WHERE usuario=$codigousp and "
                   ." clean_spaces(codacesso)=clean_spaces('$codimgsys') and "
                   ." clean_spaces(datahorai)=clean_spaces('$datetime')   "; // consulta  
         //                       
         $sqlret2 = mysql_query($sqlcmd2);
         if( ! $sqlret2 ) {
             $msg_erro .="PROBLEMAS NO SELECT TABELA SESSAO  - FALHA DB/MYSQL: ".mysql_error().$msg_final;      
             echo $msg_erro;         
             exit();         
         }
         $num_regs=mysql_num_rows($sqlret2);
         if( $num_regs>=1  ) {
              $_SESSION["codigo_sessao"] = mysql_result($sqlret2,0,"codigo");
              $_SESSION['datahorai'] = mysql_result($sqlret2,0,"datahorai");
         }
         //
         $_SESSION['codigousp'] = $codigousp;
         $_SESSION['datahorai'] = $datetime;
         $_SESSION['ipint'] = $ipint;
         //
        // $http_host = "http://".$_SERVER["HTTP_HOST"]."/gemac/patrimonio/".$recebe;
         $http_host = "http://".$_SERVER["HTTP_HOST"]."{$_SESSION["pasta_raiz"]}".$recebe;
         $_SESSION["http_host_auth_user"]=$http_host;
         //  
   } else {
         echo $msg_erro;                
         exit();
   }
   ?>
    <script language="JavaScript" type="text/javascript"  >
       //  echo "window.parent.frame.location.href=".$http_host." ;";
      //     window.parent.location.href= ;
      //    parent.location.href = '  echo $http_host; ?>';
      // var LARGURA = screen.width-10;
      // var ALTURA = screen.height-57;
      var LARGURA = screen.width;
      var ALTURA = screen.height;
      var teste = "<?php echo $http_host; ?>";
      //  Verificando o Navegador
      var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome'); 
      var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox'); 
      var navegador =navigator.appName;
      //
      //  Alterado em 20131119
      //  var is_microsoft = navegador.search(/microsoft/gi);
      //
      //  Essa SESSION navegador  vem do arquivo navegador_usado.php
      var navegador_usado="<?php echo $_SESSION["navegador"];?>";
      var is_microsoft = navegador_usado.search(/microsoft|ie/gi);      
      //  alert(" LINHA/208 - navegador_usado = "+navegador_usado+"  - is_chrome = "+is_chrome)
      
      var m_http_host="<?php echo $http_host;?>";
      //  if( navegador.search(/microsoft/gi)!=-1 ) {        
      // if( is_firefox!=-1 ) {
      if( navegador_usado.toUpperCase()=="FIREFOX" ) {  ///  Navegador Firefox  
            // netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserWrite");
            var abertura=window.open(m_http_host,"_self","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");        
            //  window.location.replace(m_http_host);
            //   self.location.href=m_http_host;        
            //  self.location.href="inicio_firefox.php";
            window.open('','_parent','');
            //  window.close();                  
            ///  document.location.reload(true);
            setTimeout("",500);
            self.close();
      } else if( is_chrome!=-1  ) {   //  Navegador Google Chrome  
             //  Navegador google chrome
            //  window.location.replace(m_http_host);
            //  IMPORTANTE - PARA FECHAR NAVEGADOR

            var abertura=window.open("<?php echo $http_host; ?>","_self","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");
            window.open('','_parent','');
            setTimeout("",500);
            ///           
      }  else if( is_microsoft!=-1  ) {  //   Navegador Microsoft 
             //  IMPORTANTE - PARA FECHAR NAVEGADOR
             var abertura=window.open("<?php echo $http_host; ?>","_self","closable=no,minimizable=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=no,menubar=no,width="+LARGURA+",height="+ALTURA+",left=0,top=0,maximize:yes,screenX=0,screenY=0");
             window.open('','_parent','');
             setTimeout("",500);
             //
      }
    /*
      if( newWindow ) {
        abriu=true;
        window.opener="SISTAM";
        window.open('','_parent','');
        window.close();
      }
      */ 
      // fim do if(newWindow)       
        //  parent.location.href(newWindow);
       //   window.close();
    </script> 
     <?php
    if( isset($recebe)  ) {
       unset($recebe);
       if( isset($http_host) ) unset($http_host);
       if( isset($_POST['x_y']) ) unset($_POST['x_y']);
       exit();
    }  
  }   
}
//
//    Incluímos a classe Sajax ao nosso projeto
require("php_include/Sajax.php");

//
//    Função para gerar código alfanumerico com imagem
// require("../../../php_include/codigo/codimage.php");
function codimage($arqimagem) {
    //    Gera um código alfanumérico de tamanho 5 caracteres com a respectiva
    //    imagem (gif) com o nome dado pelo $arqimagem ou ../../temp/codimage.gif, 
    //    se $arqimagem for vazio.
    //    
     // Gera a Imagem de código de acesso
     //  Pasta tmp permissao obrigatoria 0777 -  leitura, escrita e execucao
     // $_SESSION["arqimagegif"] = "../images/senha.gif";
     $rm = "/usr/bin/find  tmp/  -name  'senha_*.gif' -cmin +40 -delete ";
     shell_exec($rm);
     //
     $loop = true;
     while ( $loop ) {
            // $date_brazilian = date("Ymd").time(); 
            $time_start = microtime(true);
            $date_brazilian = date("Ymd").$time_start; 
            //  $arqimagem="imagens/senha.gif";
            $arqimagem =  "tmp/senha_".$date_brazilian.".gif";
            $loop = file_exists($arqimagem);
     }

    $alfanums = "abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $codimgsys = "";
    for ( $i = 0; $i < 5; $i++ ) {
        $p = rand(0, strlen($alfanums)-1);
        if (rand(0,1)==1)  $codimgsys .= " ";
        $codimgsys .= substr($alfanums, $p, 1);
    }
    $_SESSION['codigo'] = $codimgsys; 
    //
    // Local do arquivo de imagem gerada:
    if ( strlen($arqimagem)>1 ) {
        $arquivo = $arqimagem;
    } else $arquivo = "tmp/codimage.gif";
    // unset($_SESSION["arqimagegif"]);
    // unset($arqimagegif);
    // $imagem = imagecreate(80, 30);
    $imagem = imagecreate(100, 50);
    $m_cor_fundo1 = rand(0,255);
    $corPreto = imagecolorallocate($imagem, $m_cor_fundo1, 0, 0);
    $corBranco = imagecolorallocate($imagem, 255, 255, 255);
    $m_linha_x = rand(0,10);
    $m_linha_y1 = rand(0,90);
    $m_linha_y2 = rand(90,150);    
    $corLinha1 = imagecolorallocate($imagem, 0, 0, 0);
    $corLinha2 = imagecolorallocatealpha($imagem, 132, 132, 132, 80);
    imageline($imagem, $m_linha_x, $m_linha_y1, $m_linha_y2, $m_linha_x, $corLinha1);     
    imageline($imagem, rand(0,10),rand(0,90),rand(90,150),rand(0,10), $corLinha2);
    // escolhe uma cor para o elipse
    $col_ellipse1 = imagecolorallocate($imagem, rand(0,255), 255, 255);
    $col_ellipse2 = imagecolorallocate($imagem, rand(0,255), 255, rand(0,255));
    // desenha o elipse
    $m_ellipse1 = rand(0,200);
    $m_ellipse2 = rand(0,250);
    imageellipse($imagem, $m_ellipse1, rand(0,150), rand(150,300), $m_ellipse1, $col_ellipse1);      
    imageellipse($imagem, $m_ellipse2, rand(0,150), rand(150,300), $m_ellipse2, $col_ellipse2);
    $string_x = rand(2,4);
    $string_y = rand(2,34);
    imagestring($imagem, 18, $string_x, $string_y, $codimgsys, $corBranco);
    imagegif($imagem,$arquivo);
    // imagegif($imagem);
    imagedestroy($imagem);
    return $codimgsys."<#>".$arquivo;
}
//
//    Funções externas
//
//    Função usada para o login do usuário
function login( $login, $senha, $codimgusr ) {
     require("script/ipfunctions.php");
     //  require("../../../php_include/conectalixo.php");
     //    Inclusão da biblioteca especial para o patrimonio
    //   require("/var/www/cgi-bin/php_include/patrimonio/bibesp1.php");
     //    Inclusão da biblioteca especial para o patrimonio
     $idbanco="patrimonio";
     //  include("/var/www/cgi-bin/php_include/patrimonio/bibesp1.php");
     require("php_include/patrimonio/bibespn.php");
     // db_connect("patrimonio");  
    //
    $returncod='';
    // Aqui fazemos a conexão ao banco e dados e validamos o login
    $login =  trim($login); $senha= trim($senha); 
    //
    //  login ou e_mail -  Tabela pessoal.usuario(login) e pessoal.pessoa(e_mail)
    if( strpos($login,'@')===false ) {
        //  login  como  codigousp da Tabela usuario
        $testar_login= trim($login);
        //  $_SESSION['user_cond']  =" a.login=$testar_login ";
        $_SESSION['user_cond'] =" a.login='$testar_login' ";
    } else  {
        //  $email=$login_down;
        $testar_login=strtoupper(trim($login));
        $_SESSION['user_cond'] =" upper(trim(b.e_mail))='$testar_login' ";   
    }

    //  $_SESSION["bd_1"]="patrimonio_teste";
    if( ! isset($_SESSION["bd_1"]) ) {
        if( isset($dbname) ) $_SESSION["bd_1"]=$dbname;   
    } elseif( isset($_SESSION["bd_1"]) ) {
        $dbname=$_SESSION["bd_1"];
    }    
    /*   $q=mysql_query("SELECT * FROM usuario where trim(login)='".$login."' and trim(senha)=password('{$senha}') ") or die("Erro: Usu&aacute;rio ou Senha.".mysql_error);  

          Verificando USUARIO/E_MAIL                 
    */     
    $ver_usuario = mysql_query("SELECT a.login, a.codigousp, b.e_mail "
            ." FROM  {$_SESSION["bd_1"]}.usuario a, {$_SESSION["bd_1"]}.pessoal b "
            ." WHERE  ( a.codigousp=b.codigousp ) and  (".$_SESSION['user_cond'].")  ");
    //    
    if( ! $ver_usuario ) {
         return "Erro: Usuário/E_mail - db/mysql:&nbsp; ".mysql_error();
    }       
    $n_regs=mysql_num_rows($ver_usuario);
    if( $n_regs<1 ) return "Erro: Usuário/E_mail  inválido.";
    if( isset($ver_usuario) ) mysql_free_result($ver_usuario);
    //  $senha=sha1($senha);
    $senha=hash('sha1', $senha);
    /*
           Verificando SENHA

     $q =   mysql_query("SELECT a.login, a.codigousp, b.e_mail  FROM  usuario a, pessoal b  "
            ." WHERE  ( clean_spaces(a.codigousp)=clean_spaces(b.codigousp) ) and  "
            ." ( trim(a.senha)=password('$senha')  )  ");
           */             
      //      
     $q = mysql_query("SELECT a.login, a.codigousp, b.e_mail  "
              ."  FROM  $_SESSION[bd_1].usuario a, $_SESSION[bd_1].pessoal b  "
              ." WHERE  ( clean_spaces(a.codigousp)=clean_spaces(b.codigousp) ) and  "
              ." ( clean_spaces(a.senha)=clean_spaces('$senha')  )  ");     
     //
     if( ! $q ) return "Erro: Senha  - db/mysql:&nbsp; ".mysql_error();                
     $qry=mysql_num_rows($q);
    /*  Apos a verificacao, retornamos 0 ou 1 a funcao login_js em 
        Javascript, que irá tratar a resposta ao usuário               */
     if( intval($qry)>0 ) {
         // Login válido
         //
         $login=mysql_result($q,0,"login");
         $e_mail=mysql_result($q,0,"e_mail");
         $_SESSION["e_mail"]=$e_mail;
         //    Salva userid e userpassword
         $_SESSION["userid"]=$login;  $_SESSION["userpassword"]=$senha;
         //  Verificar campo imagem - codimgusr
         $partes =explode("<#>",str_replace(" ","",$_SESSION['codigo']));
         $codigo = $partes[0];  $_SESSION["codigo"]=$codigo;
         if( $codimgusr!==$codigo ) {
              $returncod ='ERRO: Código inválido.';
              return $returncod;
         }
         //
        /**
        *** Salvar codigo do usuario
        **/
         $_SESSION['codigousp'] = mysql_result($q,0,"codigousp");
        /**
        ***    Pegar o IP do equipamento de acesso
        **/
         $ipacesso = $_SERVER['REMOTE_ADDR'];
         $ipint = str2ip($ipacesso);
         $_SESSION['ipacesso'] = $ipint;
         /**
           ***    Verifica se o IP está autorizado a acesso restrito
           ***
           ***    1 - Atraves da tabela hosts.allow
         **/
         $myFileIn = "/etc/hosts.allow";
         $filectrl = @fopen($myFileIn, "r");
         $ipok=0;
         if( $filectrl) {
         while( !feof($filectrl) ) {
                $linhastr = fgets($filectrl, 4096);
                if (substr($linhastr,0,1)=="#") continue;
                $pos = strpos($linhastr,":");
                $ipstr = trim(substr($linhastr,$pos+1,64));
                if( $ipstr===$ipacesso) {
                    $ipok = 1;
                    break;
                } else {
                    $ipok = 0;
                }
            }
            fclose($filectrl);
         }
         ///  IP NAO encontrado ou desativado no arquivo /etc/hosts.allow
         if( intval($ipok)<1 ) $returncod ='OK: IP Desconhecido.';
        /**
        ***    2 - Atraves da tabela sessao
        **/
         if( ! $ipok ) {
              $sqlcmd = "SELECT * from sessao where ipacesso=$ipint";
              $result = mysql_query($sqlcmd);     
              $nregs = mysql_num_rows($result);
              $tabcpos = mysql_fetch_array($result);
              if( $nregs>0 ) $ipok=1;
         }
        /**
        ***    Se o IP for desconhecido, então verificar a possibilidade de autorizar automaticamente
        **/
         if( ! $ipok) {
             $sqlcmd = "SELECT * FROM pessoal WHERE codigousp=".$_SESSION['codigousp'];
             $result = mysql_query($sqlcmd);
             $nregs = mysql_num_rows($result);
             if( ! $result ) $nregs=0;
             if( intval($nregs)<1 ) {
                  $returncod ='ERRO: Falha no Select pessoal: '.mysql_error().'.';
                  return $returncod;
             }  
             $_SESSION['e_mail'] = trim(mysql_result($result,0,"e_mail"));
             if( is_null($_SESSION['e_mail']) or (strlen($_SESSION['e_mail'])==0)) {
                  $returncod ='ERRO: Sem e-mail cadastrado.';
                 return $returncod;
             } else {
                  $returncod ='OK: IP Desconhecido.';
            }
         }
         ////         
     } else {
         // SENHA - inválida
         $returncod ="ERRO: Senha inválida.";
     }       
     return $returncod;
}
//  Funcao para o header do email
function PostRequest($url, $referer, $_data) {
 
    // convert variables array to string:
    $data = array();    
    while(list($n,$v) = each($_data)){
        $data[] = "$n=$v";
    }    
    $data = implode('&', $data);
    // format --> test1=a&test2=b etc.
 
    // parse the given URL
    $url = parse_url($url);
    if( $url['scheme'] != 'http') { 
        die('Only HTTP request are supported !');
    }
 
    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];
                                        //
    // open a socket connection on port 80
    $fp = fsockopen($host, 80);
 
    // send the request headers:
    fputs($fp, "POST $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp, "Referer: $referer\r\n");
    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: ". strlen($data) ."\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $data);
 
    $result = ''; 
    while(!feof($fp)) {
        // receive the results of the request
        $result .= fgets($fp, 128);
    }
 
    // close the socket connection:
    fclose($fp);
 
    // split the result header from the content
    $result = explode("\r\n\r\n", $result, 2);
 
    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';
 
    // return as array:
    return array($header, $content);
}
//
function maillib($login,$codigo_img) {
    /// Conectar BD
    $sqlret =   db_connect('patrimonio');
    $codacesso = "*".str_replace(" ","*",(string) rand(0,9999)).chr(rand(97,122));
    $codigousp = $_SESSION['codigousp'] ;
    $sqlcmd = "SELECT e_mail from pessoal where codigousp=$codigousp ";
    $sqlret = mysql_query($sqlcmd) or die("ERRO/CONSULTA pessoal; ".mysql_error());      
    $e_mail = mysql_result($sqlret,0,"e_mail");
    //
    $_SESSION['codigo_img'] = $codigo_img;
    $_SESSION["e_mail"]=$e_mail;
    ///    
    /// if( $e_mail!="" ) {
    /// if(  strlen(trim($e_mail))>0 ) {
    if( preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU',$e_mail) ) {
          require("/var/www/cgi-bin/php_include/patrimonio/maillercode.php");
          $maillercode = $_SESSION["maillercode"];
          /// submit these variables to the server:
          /// para o envio em formato HTML
          $headerst = "MIME-Version: 1.0\r\n Content-type: text/html charset=iso-8859-1\r\n";
          /// endereço do remitente
          $headerst .= "From: SISTAM  <gemac@genbov.fmrp.usp.br>\r\n";
          // endereço de resposta, se queremos que seja diferente a do remitente
          // $headers .= "Reply-To: gemac@genbov.fmrp.usp.br\r\n";
          // endereços que receberão uma copia $headers .= "Cc: manel@desarrolloweb.com\r\n"; 
         // endereços que receberão uma copia oculta
         $headerst .= "Bcc: gemac@genbov.fmrp.usp.br\r\n";
         /// $corpot = "<html> <head> <title>SISTAM - código de acesso</title> </head>";
         // $corpot .= "<body><h1>MENSAGEM AUTOMÁTICA - NÃO RESPONDER</h1>";
         // $corpot .= "<p><b>Código de liberação de acesso a IP desconhecido=</b>". $codacesso ;
         // $corpot .= "</p></body></html>"; 
         $corpot = "SISTAM - código de acesso\r\n\r\n";
         $corpot .= "MENSAGEM AUTOMÁTICA - NÃO RESPONDER\r\n\r\n";
         $corpot .= "Código de Liberação de Acesso= ". $codacesso ;
         $corpot .= "\r\n\r\n"; 
         $data = array(
              'fncode' => $maillercode,
              'e_mail' => $e_mail,
              'assunto' => 'Sistam',
              'headers' => $headerst,
              'corpo' => $corpot,
              'urlback' => 'http://sol.fmrp.usp.br/gemac/patrimonio/mail_enviado.php');
       
        // SEND a request to example.com (referer = jonasjohn.de)
        list($header, $content) = PostRequest(
              "http://genbov.fmrp.usp.br/mailler.php",
              "http://sol.fmrp.usp.br/",
              $data
        );
        // print the result of the whole request:
       if( substr(trim($content),0,2)!="OK" ) {
            // print "Falha no envio do e_mail: " . $content;
            $codacesso = "ERRO: Mail";
        } 
    } else $codacesso = "";
    $_SESSION['codacesso']= $codacesso;
    return $codacesso;
}
function loadimg($arqimagem) {
     $_SESSION["codigo"]=codimage($arqimagem);
     $teste_cod = $_SESSION["codigo"];
     return $teste_cod;
}
//    Instanciamos a classe
sajax_init();

//    Declaramos as funções que usaremos com SAJAX
sajax_export("login");
sajax_export("maillib");
sajax_export("loadimg");

//    Declaração obrigatória
sajax_handle_client_request();

?>                    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" >
<meta name="author" content="SPFB&LAFB" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">
<meta http-equiv="Cache-Control" content=" no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="ROBOTS" content="NONE"> 
<meta name="GOOGLEBOT" content="NOARCHIVE"> 
<link rel="shortcut icon"  href="imagens/sistam.ico"  type="image/x-icon" />  
<meta http-equiv="imagetoolbar" content="no">  
<title>Controle de Bem Patrimonial</title>
<link  type="text/css"  href="css/estilo_patrimonio.css" rel="stylesheet"  />
<link  type="text/css"   href="css/style_titulo_patrimonio.css" rel="stylesheet"  />
<script type="text/javascript"  src="js/jquery-1.2.6.js" charset="utf-8"></script>
<script type="text/javascript" src="js/tecla_enter_input.js"></script>
<script type="text/javascript" src="js/funcoes.js"></script>
<script type="text/javascript" >
// Tamanho do video
self.moveTo(-4,-4);
self.resizeTo(screen.availWidth + 8,screen.availHeight + 8);
self.focus();
/*
if ( screen.width<1024 ) {
     window.alert('Esse site fica melhor com\na resolução do vídeo: 1024x768 pixels');
}
*/
//
<?php 
    // Declaração obrigatória
    sajax_show_javascript(); 
?>
<!-- Função que recebe a entrada do formulário -->
function do_login() {
        var usuario
        var senha
        var codimgusr
        usuario = document.getElementById('login').value
        senha = document.getElementById('password').value
        codimgusr = document.getElementById('codimgusr').value
        x_login(usuario, senha, codimgusr, login_js )        
}
function do_maillib(codigo_img) {
        var usuario
        var senha
        usuario = document.getElementById('login').value
        x_maillib(usuario,codigo_img, maillib_js )        
}
function do_loadimg() {
    //  Pasta tmp permissao obrigatoria 0777 -  leitura, escrita e execucao      
    document.getElementById("img_codimgusr").src="tmp/senhav0.gif"
    // x_loadimg("tmp/senha.gif",loadimg_js )        
    x_loadimg("",loadimg_js)        
}
function do_libacesso(response) {
    var formName = document.forms[0].name
    var theForm = document.getElementById(formName)
    var codlibusr = document.getElementById('codlibusr').value
    var x_codacesso = document.getElementById('msg3').value
    if ( response=="Cancelar" ) {
        parent.location.href="http://sol.fmrp.usp.br"    
        return
    } 
    if ( codlibusr=="" ) {
        alert("Código em branco. Redigite.")
        document.getElementById('codlibusr').focus()
        return 
    } else  if( codlibusr==x_codacesso ) {
        theForm.submit()
        return
    } else {
        alert("Código diferente do e_mail. Redigite.")
        document.getElementById('codlibusr').focus()
        return 
    } 
}
<!-- Função que recebe a resposta da função login em php -->
function login_js(response) {
    var respcod
    var formName = document.forms[0].name
    var theForm = document.getElementById(formName)
    // respcod = response.substr(0,7)
    respcod = trim(response)
    if (respcod=="") {
        theForm.submit()
    }
/*
     alert(" auth_user.php/684 - respcod = "+respcod)    
     return;  
*/   
    if( respcod.search(/ERRO|Nenhum/i)!=-1  ) {
        // if(respcod=="ERRO: L") {
        if( respcod.search(/LOGIN|usuário|USUARIO|EMAIL|E_MAIL/i)!=-1 ) {
             // document.getElementById("msg1").innerHTML="Login Inv&aacute;lido. Obs. Após 3 tentativas, 30 min de bloqueio."
             document.getElementById("msg1").innerHTML="Usu&aacute;rio/E_mail Inv&aacute;lido. Obs. Após 3 tentativas, 30 min de bloqueio."
             alert("Usuário/E_mail Inválido. Obs. Após 3 tentativas, 30 min de bloqueio.")
             document.getElementById('login').value=""
             document.getElementById('password').value=""
             document.getElementById('codimgusr').value=""
             document.getElementById('imagems_src').setAttribute("src","imagens/botao_ok0.gif")
          ///   document.getElementById('imagems_src').src.replace(/imagens/botao_ok1.gif/i, 'imagens/botao_ok0.gif')
             document.getElementById('login').focus()
        }
        //  SENHA
        if( respcod.search(/senha/gi)!=-1 ) {
            // document.getElementById("msg1").innerHTML="Login Inv&aacute;lido. Obs. Após 3 tentativas, 30 min de bloqueio."
             document.getElementById("msg1").innerHTML="Senha Inv&aacute;lida. Obs. Após 3 tentativas, 30 min de bloqueio."
             alert("Senha Inválida. Obs. Após 3 tentativas, 30 min de bloqueio.")
             document.getElementById('password').value=""
             document.getElementById('codimgusr').value=""
             document.getElementById('imagems_src').setAttribute("src","imagens/botao_ok0.gif")
          ///  document.getElementById('imagems_src').src.replace(/imagens/botao_ok1.gif/i, 'imagens/botao_ok0.gif')
             document.getElementById('password').focus()
        }
        ///   CODIGO        
        // if( respcod=="ERRO: C") {
        if( respcod.search(/Codigo|código/i)!=-1 ) {
             //  Código inválido
             alert(response);
             document.getElementById("msg1").innerHTML=response
             $("#codimgusr").val("");
             $("#codimgusr").focus();
             return
        }
    } else {
        //  if(respcod=="OK: IP ") {
        if( respcod.search(/OK/i)!=-1 ) {
              document.getElementById("msg1").innerHTML="Acesso Requer Autorização por e-mail. Continuar?"
              document.getElementById('msg1btn').style.visibility = "visible";
             <!--  alert('Login válido');  -->
        }
    }
}          
<!-- Função que recebe a resposta da função maillib em php -->
function maillib_js(response) {
    var codlib=""
    // var formName = document.forms[0].name
    // var theForm = document.getElementById(formName)
    var codacesso= response
    document.getElementById('msg3').value=response
    if( response=="" ) {
        document.getElementById("msg1").innerHTML="E_Mail não cadastrado ou Inválido. Providencie cadastramento."
        document.getElementById('msg1btn').style.visibility = "hidden"
        alert("E_Mail não cadastrado ou Inválido. Providencie cadastramento.")
    }
    if( (response.length>0) && (response.substr(0,6)!="ERRO: ")) {
        document.getElementById("msg1").innerHTML="Informe o código de autorização enviado ao seu e-mail:"   
        //  document.getElementById('msg1btn').style.visibility = "hidden"
        document.getElementById('msg1btn').innerHTML = "<input type='text' name='codlibusr' id='codlibusr' size='8' >&nbsp;&nbsp;&nbsp;<input type='submit' name='btncodlib' id='btncodlib' value='Seguir' onclick='do_libacesso(this.value)'  style='cursor: pointer;' >&nbsp;<input type='submit' name='btncancelcodlib' id='btncancelcodlib' value='Cancelar' onclick='do_libacesso(this.value)' style='cursor: pointer;' >";
        return
         // if (codlib!="") {
        //      theForm.submit()
        //        return 
        //}
    }
    if(response.substr(0,6)=="ERRO: ") {
        alert('Mail inválido ou não cadastrado. Providencie cadastramento: '+response);
    }
    alert('Autorização cancelada.')
    parent.location.href="http://sol.fmrp.usp.br"    
}
<!-- Função que recebe a resposta da função loadimg em php -->
var partes;
function loadimg_js( response )  {
    partes = response.split("<#>");
    //  $('#codimgsys').val(response) 
    var busca = " ";
    var strbusca = eval('/'+busca+'/g');
    partes[0] = partes[0].replace(strbusca,"");
    $('#codimgsys').val(partes[0]); 
    document.getElementById("img_codimgusr").src=partes[1];
}
function putFocus() {
    document.getElementById("img_codimgusr").src="tmp/senhav0.gif"
    $('#codimgusr').val("");
    $('#password').val("");
    $('#login').val("");
    $('#login').focus();
}
function refreshimg() {
    document.getElementById("img_codimgusr").src="tmp/senha.gif" 
    //  document.getElementById("img_codimgusr").src=partes[1];
    if( document.getElementById("login") ) document.getElementById("login").focus()
    document.getElementById("msg1").innerHTML=""
}
function trim(str){
    return str.replace(/^\s+|\s+$/g,"");
}
//
function limpar_enviar(id1,id2) {
       document.getElementById(id1).setAttribute('src','imagens/botao_ok0.gif')
       document.getElementById(id2).setAttribute('src','imagens/botao_ok0.gif')
}
//  Limpar campos
function limpar_campos(tipo) {
    var tipo_maiusc= tipo.toUpperCase();
       var elements = document.getElementsByTagName("input");
    for (var i = 0; i < elements.length; i++) {
            var m_id_name = elements.item(i).name;
            var m_id_type = elements[i].type;
            if(( typeof m_id_name=='undefined' ) || ( typeof m_id_type=='undefined' ) ) continue;
            if ( m_id_type=='button' || m_id_type=='image' || m_id_type=='reset' || m_id_type=='submit'  ) continue;
            var m_id_value =  elements[i].value;
            //  LIMPAR todos os campos ou  usar o  TRIM
            if( tipo=="limpar" ) {
                document.getElementById(m_id_name).value="";
                //  document.getElementById(m_id_name).value="";
            } else if( tipo=="trim" ) {
                document.getElementById(m_id_name).value=trim(document.getElementById(m_id_name).value);
            }
    } 
    //  Limpar essas - DIVs 
    if(  document.getElementById("conteudo") ) document.getElementById("conteudo").style.display="none";
    if(  document.getElementById("inclusao") ) document.getElementById("inclusao").style.display="none";    
    if( tipo_maiusc=="TRIM" ) return true;
    if( tipo_maiusc=="LIMPAR" ) {
       if( document.getElementById("login") ) document.getElementById("login").focus();         
    }
    return false;
}   
//
</script>
</head>
<body name="body"  onLoad='refreshimg();putFocus();'  oncontextmenu="return false" onselectstart="return false"  ondragstart="return false">
<!--
As funções que serão chamadas por Sajax tem o prefixo "x_". 
Neste caso, quando o formulário for submetido, os valores contidos nos campos login e password irão para a função login (em php).
login_js é a função em Javascript que tratará o retorno ao usuário.
 -->
<?php
//  require para o Navegador que nao tenha ativo o Javascript
include("js/noscript.php");
//
?>
<!-- PAGINA -->
<div class="pagina_ini"  id="pagina_ini" >
<!-- Cabecalho  -->
<!--  <div id="cabecalho" style="z-index:2; border: none;" > -->
<div id="cabecalho" style="z-index:2; border: none;" >
<?php include("script/cabecalho_patrimonio.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
//  Menu Horizontal
include_once("includes/array_menu.php");
// unset($_SESSION["m_horiz"]);
$_SESSION["m_horiz"] = $array_vazio;
///  $_SESSION["m_horiz"] = "";
$_SESSION["function"]="auth_user";
include("includes/menu_horizontal_patrimonio.php");
$_SESSION["function"]="";
?>
<!-- Final do MENU  -->
<!-- CORPO -->
<div id="corpo" style="text-align: center; width: 100%;"  >
<?php 
// Arquivo para definir o tamanho do texto na pagina
include_once("library/tamanho_texto.php");
?>
<table border="1" width="740pt" cellpadding="1" align="center" style="<?php echo $body_style;?>;"   >
   <tr>
     <td class="td_inicio1" width="22%"   >
            <label for="login" class="label_campos" >&nbsp;Usu&aacute;rio/E_mail:&nbsp;</label>
     </td>
     <td class="td_inicio1"  nowrap style="text-align: left;" >
         <input type="text" name="login" id="login"  required="required" onfocus="limpar_enviar('imagems_src','imagems_limpar_src');$('#msg_info_campo').html('Digitar usu&aacute;rio');"   onblur="$('#msg_info_campo').html('');"  autocomplete="off" size="74" maxlength="68"  tabindex="1" onKeyUp="if (this.value.length==68) password.focus()" />
     </td>
   </tr>
   <tr>
     <td class="td_inicio1"  >
         <label for="password" class="label_campos" >Senha:&nbsp;</label>
     </td>
     <td class="td_inicio1" nowrap style="text-align: left;" >
       <input type="PASSWORD" name="password" id="password"  required="required" onfocus="do_loadimg();$('#msg_info_campo').html('Digitar senha');"       onblur="$('#msg_info_campo').html('');" autocomplete="off" size="12" maxlength="12" title='Digitar senha'  tabindex="2"  onKeyUp="if (this.value.length==10) codimgusr.focus()" />
     </td>
   </tr>
   <tr valign="middle" >
       <th  align="RIGHT" valign="middle"  > 
           <img src="tmp/senhav0.gif"  style="width: 100%;" style="vertical-align: middle" id="img_codimgusr" /> 
       </th>
       <td  class="td_inicio1" style="text-align: left; vertical-align: middle;" >
           <label  for="codimgusr" class="label_campos" >&nbsp;C&oacute;digo:&nbsp;</label>
           <input type="text" name="codimgusr" id="codimgusr" size="8"   required="required"   maxlength="5"  onfocus="limpar_enviar('imagems_src','imagems_limpar_src');$('#msg_info_campo').html('Digitar c&oacute;digo com 5 caracteres');"  onblur="$('#msg_info_campo').html('');"  title="Digitar c&oacute;digo com 5 caracteres" autocomplete="off" style="cursor:pointer;"   tabindex="3"   />
       </td>
   </tr>
   <tr style="margin: 0px; padding: 0px; line-height: 0px;" >
       <td colspan="2" align="CENTER" nowrap style=" vertical-align: bottom; text-align:center; border: none;">
         <table  cellpadding="1" cellspacing="1" align="center" style="margin: 0px;  padding: 0px; width: 100%; border: 1px solid #000000;" >
            <tr>
               <td align="CENTER" nowrap style="text-align:center; border: none;" >
                  <input type="reset" class="botao3d" style="height:auto; font-size: medium;cursor: pointer; border: 1px solid #000000; "  name="image" id="imagems_limpar_src"  title="Limpar"  acesskey="L"  value="Limpar"  alt="Limpar"  onfocus="javascript: limpar_campos('limpar','Limpar');"  onclick="javascript: putFocus();"/>
               </td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <td align="center" style="text-align: center; border:none; ">
                   <input type="submit" class="botao3d"  style="height:auto; font-size: medium;  cursor: pointer; border:  1px solid #000000;"  id="imagems_src" name="imagems_src" title="Enviar"  acesskey="E"  value="Enviar"  tabindex="4"  alt="Enviar" onclick="javascript: do_login();"    />
               </td>
            </tr>
      <!--  <tr>
            <td colspan="2" align="center" >
            <span id="msg_info_campo" style="text-align: center;" ></span>
            </td> 
            </tr>   -->
         </table>
     </td>
     </tr>
</table>
<div id='msg1btn' style="visibility: hidden; text-align: center;width: 100%; ">
    <input type="submit" name="msg1btn1" id="msg1btn1" title="Continuar"  style="padding-right: 2px;"
           value="Sim" onClick="do_maillib($('#codimgusr').val())"    style="cursor: pointer;"  />
    <input type="submit" name="msg1btn2" id="msg1btn2" title="Cancelar" 
           value="Não" onClick="location.href='../../index.php'"    style="cursor: pointer;" />
</div>    
<form name="frmauth" id="frmauth" method="post">
    <div id='msg2' style="text-align: center;">
         <input type="hidden" id="codimgsys" name="codimgsys" value="" />
    </div>    
</form>
<div id='msg3' style="text-align: center;"  >
</div>
<div id='msg1' style="height:auto;" >
</div>
</div>      
<!-- Final Corpo -->
<!-- Rodape -->
<div id="rodape"   >
<?php include_once("includes/rodape_index.php"); ?>
</div>
<!-- Final do  Rodape -->
</div>
<!-- Final da PAGINA -->
</body>
</html>      