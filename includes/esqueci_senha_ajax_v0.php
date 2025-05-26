<?php
//  AJAX da opcao CONSULTAR
#
ob_start(); /* Evitando warning */
//  Verificando se sseion_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
// set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control","no-store, no-cache, must-revalidate");
header("Cache-Control","post-check=0, pre-check=0");
header("Pragma", "no-cache");

//  header("content-type: application/x-javascript; charset=tis-620");
//  header("content-type: application/x-javascript; charset=iso-8859-1");
///  header("Content-Type: text/html; charset=ISO-8859-1",true);
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

////  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

include("email_encode.php");
//
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar

///  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Session incluir_arq desativada.".$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
///
///  Conjunto de arrays 
include_once("array_menu.php");

/// Conjunto de Functions
include("{$_SESSION["incluir_arq"]}script/stringparabusca.php");        

$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if ( isset($_POST[$xyz]) ) {
        $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
       if ( $pos1 === false ) {
           //  $$xyz=trim($_POST[$xyz]);
           //   Para acertar a acentuacao - utf8_encode
           $$xyz = utf8_decode(trim($_POST[$xyz])); 
       } else {
           $$xyz = explode($div_array_por,$_POST[$xyz]);   
       } 
    }
}
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source);
//
$elemento=5; $elemento2=6;
///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     

//// require_once('/var/www/cgi-bin/php_include/ajax/includes/tabela_pa.php');
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];        

////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();

///  Caso  sair do programa
if( strtoupper($source)=="SAIR" ) {
    // Eliminar todas as variaveis de sessions
    $_SESSION = array();

    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($senha_down) )  unset($senha_down); 
    //
    //  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
    echo  "http://www-gen.fmrp.usp.br/";
    exit();
    #
} elseif( strtoupper(trim($source))=="SUBMETER" )  {
      ///  ALTERADO EM 20170706
      ///  Verificando campos 
     $elemento=5; ;$elemento2=6; 
     ////  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");    
     include("php_include/ajax/includes/conectar.php");    
     ///  mysql_select_db($db_array[$elemento]);    
     /// Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
      include 'dbc.php';
      ////
      set_time_limit(0); $m_erro=0;
      /*     
             AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
              e de depois usa o  - html_entity_decode 
         */
    /*         
      $campo_nome = htmlentities(utf8_decode($campo_nome));
      $campo_value = htmlentities(utf8_decode($campo_value));
      $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));      
      $array_temp = explode(",",$campo_nome);        
      $count_array_temp = sizeof($array_temp);         
      $array_value = explode(",",$campo_value);
      for( $w=0; $w<$count_array_temp; $w++ ) {
           $array_t_value[]=$array_value[$w];
      }
     // for( $i=0; $i<$count_array_temp; $i++ ) $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
      for( $i=0; $i<$count_array_temp; $i++ ) {
         $arr_nome_val[$array_temp[$i]]=html_entity_decode($array_t_value[$i]);   
      }
      */
     //  SUBMETER 
     //
     if( isset($array_temp) ) unset($array_temp); 
     if( isset($array_t_value) )unset($array_t_value); 
     $m_erro=0;
     //    Dados vindo de um FORM   
     include("dados_campos_form.php");
     ////
     /// $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
     if( strtoupper($val)=="LOGIN" ) {
         $m_login = strtoupper(trim($arr_nome_val[login]));
         $m_senha = strtoupper(trim($arr_nome_val[senha]));
         $m_erro=""; unset($m_email_arr);
         if( strlen($m_login)<8 or strlen($m_senha)<8   ) {
            $m_erro= "Campo usu&aacuterio/senha tem que ter no m&iacute;nimo 8 caracteres.";              
         } elseif( $m_login==$m_senha  ) {
             //  Duplicados - login e senha
             $m_erro= "Campos usu&aacuterio e senha com dados iguais: ".$arr_nome_val[login].$msg_final;             
         }
         //
         if( strlen(trim($m_erro))<1 ) {
             $user_email = $m_login;   $pass = trim($arr_nome_val[senha]);
             if( strpos($user_email,'@')===false ) {
                  $user_cond = "upper(trim(user_name))='$user_email'";
             } else {
                  $user_cond="upper(trim(user_email))='$user_email'";   
             }
             ///
             ///   Select - MySQL
             $res_acesso = mysql_query("SELECT `id`,`pwd`,`full_name`,`approved`,`user_level` FROM users "
                                         ." WHERE $user_cond AND "
                                         ." trim(`pwd`)=password('$pass')  AND  `banned`='0'  ");
             ///
             // Verificando se houve erro no Select
             if( ! $res_acesso ) {
                  mysql_free_result($res_acesso);
                  //  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
                  die("ERRO: Select users e campos  - ".mysql_error());
             }  
             $num = mysql_num_rows($res_acesso);
             //  Match row found with more than 1 results  - the user is authenticated. 
             //  Caso encontrado 1 ou mais resultados - usuario autentico 
             if ( $num>0 ) { 
                 list($id,$pwd,$full_name,$approved,$user_level) = mysql_fetch_row($res_acesso);
                 if( ! $approved ) {
                      // $msg = urlencode("Account not activated. Please check your email for activation code");
                      //  $err[] = "Account not activated. Please check your email for activation code";
                      $m_erro = "Conta não ativada. Por favor verifique seu e-mail para o Código de ativação";
                 }
             } else $m_erro = "Esse Usu&aacute;rio n&atilde;o existe";        
             mysql_free_result($res_acesso);
             // check against salt
             //  if ( $pwd===PwdHash($pass,substr($pwd,0,9))) { 
            //  $m_pwd = PwdHash($pass,trim($arr_nome_val[senha]));
             $pwd=trim($arr_nome_val[senha]);
             // if ( $pwd===PwdHash($pass,$arr_nome_val[senha]) and strlen(trim($m_erro))<1 ) { 
             if ( strlen(trim($m_erro))<1 ) {  
                     // this sets session and logs user in  
                     //  Verificando se sseion_start - ativado ou desativado
                     if(!isset($_SESSION)) {
                            session_start();
                     }
                     session_regenerate_id(true); // Impedindo contra ataques de fixa??o de sess?o.
                     // this sets variables in the session 
                    $_SESSION['user_id']= $id;  $_SESSION['user_name'] = $full_name;
                    $_SESSION['user_level'] = $user_level;
                    $_SESSION["HTTP_USER_AGENT"] = md5($_SERVER["HTTP_USER_AGENT"]);
                    ///  update the timestamp and key for cookie
                    $stamp = time();  $ckey = GenKey();
                    $result_update= mysql_query("Update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id' ");
                    // Verificando se houve erro no Update            
                    if( ! $result_update ) {
                          mysql_free_result($result_update);
                          die("ERRO: Update users e campos  - ".mysql_error());
                    }
                    header("Location: ../myaccount.php");
            } 
         }
         ///
         if( strlen(trim($m_erro))>=1 ) {
              $msg_erro .= $m_erro.$msg_final; 
              echo $msg_erro;
         }
         exit();  
     } 
     ///  FINAL DO LOGIN - primeira pagina           
    
    //   Fazendo o Cadastro do Usuário
    if( strtoupper($val)=="REGISTRO" ) {
            $nome = trim($arr_nome_val[nome]); $m_erro="";
            if( empty($nome) || strlen($nome) < 9) {
                $m_erro= "Nome inv?lido. Por favor digite 8 ou mais carateres do seu nome";                                      
                //  $err[] = "Nome inv?lido. Por favor digite 3 ou mais carateres do seu nome";
            }
            //  Validate User Name
            //  if (!isUserID($data['user_name'])) {
            if ( ( ! isUserID($arr_nome_val[login]) ) and ( strlen(trim($m_erro))<1  )  ) {
               // $err[] = "ERRO - Usu&aacute;rio invuser name. It can contain alphabet, number and underscore.";
                $m_erro= "Usu&aacute;rio inv?lido. Por favor digitar usu&aacute;rio com 8 a 10 caracteres";                                      
            }
            //  Validate Email
            // if( ( ! isEmail($data['usr_email']) )  and ( strlen(trim($m_erro))<1  )   ) {
            if( ( ! isEmail($arr_nome_val[email]) )  and ( strlen(trim($m_erro))<1  )   ) {
                 // $err[] = "ERRO - Invalid email address.";   
                 $m_erro= "Endere&ccedil;o de email inv&aacute;lido";   
            }
           // Check User Passwords
            // if (!checkPwd($data['pwd'],$data['pwd2'])) {
            if ( ( !checkPwd($arr_nome_val[senha],$arr_nome_val[redigitar_senha]) )  and ( strlen(trim($m_erro))<1  ) ) {
                  //  $err[] = "ERRO - Invalid Password or mismatch. Enter 5 chars or more";
                  $m_erro= "Senha inv&aacute;lida ou incompatibilidade. Digitar Senha com 8 a 10 caracteres";
            }
            ///  SEM ERRO EXECUTAR IF
            if( strlen(trim($m_erro))<1   ) {
                $user_ip = $_SERVER['REMOTE_ADDR'];
                // stores sha1 of password
                // $sha1pass = PwdHash($data['pwd']);
                //  Melhor SENHA COM  Mysql  password
            //    $sha1pass = PwdHash($arr_nome_val[senha]);
                // Recolhe automaticamente: hostname or domain  like example.com) 
                $host  = $_SERVER['HTTP_HOST'];  $host_upper = strtoupper($host);
                $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                // Gera a ativação de codigo com 6 digitos
                $activ_code = rand(100000,999999);

                /* $usr_email = $data['usr_email'];
                    $user_name = $data['user_name'];   */
                $usr_email = $arr_nome_val[email];
                $nome = trim($arr_nome_val[nome]);
                /************ USER EMAIL CHECK ************************************
                    This code does a second check on the server side 
                    if the email already exists. 
                    It  queries the database and if it has any existing 
                    email it throws user email already exists
                *******************************************************************/
                $nome=str_replace("  "," ",$nome);
                $user_name_array = explode(" ",$nome);
                $contador = sizeof($user_name_array);
                if( $contador==1 ) {
                    $m_user_name = $user_name_array[0];   
                } else {
                    for($i=0; $i<$contador; $i++ ) {
                        if( strlen(trim($user_name_array[$i]))>=1  ) {
                            $m_user_name .= trim($user_name_array[$i])." ";          
                        }           
                    } 
                }
                $nome = strtoupper(trim($m_user_name));
                $arr_nome_val[nome]=trim($m_user_name);
                //
                $email = strtoupper(trim($usr_email));
                $user_name=trim($arr_nome_val[login]);
                $rs_duplicate = mysql_query("SELECT count(*) as total from login_senha.users where "
                          ."  upper(trim(user_name))='$login'");
                //
                if( ! $rs_duplicate  ) {
                    ///  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
                    die("ERRO: Select users e campo user_name  - ".mysql_error());
                }  
                list($total) = mysql_fetch_row($rs_duplicate);
                if( isset($rs_duplicate) ) mysql_free_result($rs_duplicate);
                if( intval($total)>0) {
                     $m_erro= "O usu&aacute;rio ".$m_user_name." j? existe.&nbsp;<br>"
                          ."Por favor tente novamente como outro usu&aacute;rio.";
                } else {
                    unset($total);
                    $rs_duplicate=mysql_query("SELECT count(*) as total from users where "
                           ." upper(trim(user_email))='$email' ");
                    //
                    if( ! $rs_duplicate  ) {
                          mysql_free_result($rs_duplicate);
                         //  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
                         die("Falha Select users e campo user_email - ".mysql_error());
                    }
                    list($total) = mysql_fetch_row($rs_duplicate);
                    if( isset($rs_duplicate) ) mysql_free_result($rs_duplicate);
                    if( intval($total)>0) {
                        $m_erro= "O email j? existe.&nbsp;<br>"
                            ."Por favor tente novamente com outro email (correio eletronico).";
                    }
               }   
               if( $arr_nome_val[redigitar_senha] ) unset($arr_nome_val[redigitar_senha]);
               /******************* Filtragem de entrada ****************************/
               foreach( $arr_nome_val as $key => $value ) $data[$key] = html_entity_decode(filter($value));   
               //  Start a transaction - ex. procedure    
               mysql_query('DELIMITER &&'); 
               mysql_query('begin'); 
               //  Execute the queries 
               $sql_insert = mysql_query("INSERT into `users`
                 (`full_name`,`user_email`,`pwd`,`address`,`tel`,`fax`,`website`,`date`,`users_ip`,`activation_code`,`country`,`user_name`)
                   VALUES ('$data[nome]','$usr_email',password('$arr_nome_val[senha]'),'$data[endereco]','$data[telefone]','$data[fax]','$data[web]'
                       ,now(),'$user_ip','$activ_code','$data[pais]','$user_name')");
               //  Complete the transaction 
               //  Falha no insert
               if( ! $sql_insert  ) { 
                    //  mysql_error() - para saber o tipo do erro
                    $m_erro="&nbsp;Ocorreu uma falha no Insert users - &nbsp;".mysql_error();
                    mysql_query('rollback'); 
               }
               //  Sucesso no Insert
               if( $sql_insert )  {
                   //  mysql_insert_id() - tem ser antes do mysql_query(commit)
                   $user_id = mysql_insert_id();      
                   mysql_query('commit');                    
               }
               mysql_query('end'); 
               mysql_query('DELIMITER'); 
               ///
               ///        
               if( $sql_insert ) {
                    $md5_id = md5($user_id);
                    $res_update = mysql_query("update users set md5_id='$md5_id' where id='$user_id'");
                   //  Falha no Update
                   if( ! $res_update )  $m_erro="&nbsp;Ocorreu uma falha no Update users - &nbsp;".mysql_error();
                   if( $res_update  and ( strlen(trim($m_erro))<1  ) ) {
                       //    echo "<h3>Obrigado</h3> Recebemos sua apresentacao.";
                       if( $user_registration )  {
                              $new_path = preg_replace('/\/includes/i','',$path);
                              $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br>"
                              ."<a href='http://$host$new_path/ativar.php?user=$md5_id&activ_code=$activ_code'  title='Clicar' >"
                              ."http://$host$new_path/ativar.php?user=$md5_id&activ_code=$activ_code</a>"; 
                       } else {
                              // $a_link = "Your account is *PENDING APPROVAL* and will be soon activated the administrator.";
                              $a_link = "A sua conta ser&aacute; ativada pelo administrador/orientador";
                        }
                        $user_name = html_entity_decode($user_name); 
                       $usr_email = html_entity_decode($usr_email);
                       $corpo=html_entity_decode("Seu cadastro foi realizado. Detalhes do seu registro\r\n");
                       //  $assunto =html_entity_decode("Detalhes da Autentifica??o");
                       $assunto =utf8_encode("Detalhes da Autentifica??o");
                       $headers1  = "MIME-Version: 1.0\n";
                      // $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
                       $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
                       //  $headers1 .= "X-Priority: 3\n";
                       $headers1 .= "X-Priority: 1\n";
                       //  $headers1 .= "X-MSMail-Priority: Normal\n";
                       $headers1 .= "X-MSMail-Priority: High\n";           
                       $headers1 .= "X-Mailer: php\n";
                      //   $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
                       //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
                       //  From e  Bcc  (Para e Copia Oculta)                    
                      // $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
                       $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";
                       //  $headers1 .= "Bcc: gemac@genbov.fmrp.usp.br\r\n";   
                       $headers1 .= "Bcc: {$_SESSION["gemac"]} \r\n";   
                       
                       $message = "$corpo ...\n<br><br>
                            Usuário: $user_name<br>
                            Email: $usr_email \n<br>
                            Senha: $data[senha] \n<br>
                            
                            Código de ativação: $activ_code \n<br><br>
                            
                            $a_link<br><br>
                            
                            Administrador/Orientador<br>
                            $host_upper<br><br>
                            ______________________________________________________<br>
                            Esta é uma resposta automática.<br> 
                            *** não responder a este EMAIL ****
                            ";
                       mail($usr_email, $assunto, $message,$headers1);
                       //  header("Location: thankyou.php");  
                       ?>
                       <div style="width: 700px;">
                       <table width="100%" align="center" border="0" cellspacing="0" cellpadding="5" class="main">
                         <tr> 
                         <td width="680" valign="top">
                            <h4>Cadastro desse Usuário foi conclu&iacute;do!</h4>
                            <p style="font-family: Arial, Helvetica, sans-serif, Times, Courier; ">
                             Um e-mail de ativação foi enviado para seu endere?o de e-mail (n?o se esque?a de verificar sua pasta de spam).<br>
                             Por favor verifique seu e-mail e clique no link de ativação para acesso.
                           </p>
                         </td>
                        </tr>
                      </table>
                      </div>
                       <?php
                       exit();                           
                   }                                  
               }                 
               if( isset($sql_insert) )  unset($sql_insert);                 
            }   //  FINAL - IF strlen(trim($m_erro))<1
            if( strlen(trim($m_erro))>=1 ) {
                  $msg_erro .= $m_erro.$msg_final; 
                  echo $msg_erro;
            }
            exit();                                         
    }  //  Final - if strtoupper($val)==REGISTRO
    
    ///   CASO tenha ESQUECIDO a SENHA
    if( strtoupper($val)=="SENHA" ) {
          $cpo_final="senha";
          ///  incluindo arquivo dados_campos_form_alterar_auto.php
          include_once("dados_campos_form_alterar_auto.php");
          
          ///  Verificando campos 
          $m_regs=0;
          //  Vericando se o Codigo/USP se ja esta cadastrado na Tabela pessoa
          if( isset($arr_nome_val['codigousp']) )  {
                $arr_nome_val['codigousp'] = (int) trim($arr_nome_val['codigousp']);  
          } 
          //  Definindo os nomes dos campos recebidos do FORM
          foreach(  $arr_nome_val as $key => $value ) $$key =  $value;
          //      
         if( isset($m_email_arr) ) unset($m_email_arr); 
         $m_erro="";  
         // Verificando campo email
         $m_email_arr = array('email','e_mail','e-mail','user_email');
         $count_email = count($m_email_arr);
         for( $i=0; $i<$count_email ; $i++ ) {
              $cpo_email =  $m_email_arr[$i];
             if( array_key_exists($cpo_email,$arr_nome_val) ) break;
         }
         //  if( ! isEmail($data['user_email'])) {     
         if( ! isEmail($arr_nome_val[$cpo_email]) ) {
             // $err[] = "ERROR - Please enter a valid email"; 
              ///   $m_erro= "Por favor introduza um correio eletronico v?lido";
               $msg_erro .= "Por favor introduza um correio eletronico válido".$msg_final;
               echo  $msg_erro;
               exit();
         }
         ///
         // Verificando usuario/login        
         $m_usuario_arr = array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
         $count_usuario = count($m_usuario_arr);
         for( $i=0; $i<$count_usuario ; $i++ ) {
              $cpo_usuario =  $m_usuario_arr[$i];
             if( array_key_exists($cpo_usuario,$m_usuario_arr) ) break;
         }

         
         /*
         foreach( $cpos_nome as $key ) {
             $nome_campo = strtoupper($key); 
             for( $i=0; $i<$count_usuario; $i++ ) {
                 if( $nome_campo==$m_usuario_arr[$i] ) {
                    $cpo_usuario=$key;
                     break;  
                 }                
             }
         }
         */
         /*   Verificando se esse Usuario esta cadastrado com esse e_mail
         *    nas Tabelas pessoa e no usuario para conectar
         */
         $rs_check=mysql_query("Select a.codigousp,b.pa,a.nome from  $bd_1.pessoa a, $bd_1.usuario b  "
                       ." where a.codigousp=b.codigousp and  upper(trim(a.e_mail))=upper('$user_email')  ");
         //
         if( ! $rs_check  ) {
               ///  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
               $msg_erro .= "ERRO: Select Tabela  pessoa  e campo e_mail  - ".mysql_error().$msg_final;
               echo  $msg_erro;
               exit();
         }  
         $num = mysql_num_rows($rs_check);
         ////  Caso esse email NAO seja encontrado
         if( intval($num)<1 ) { 
               $m_erro = "N&atilde;o existe conta cadastrada com<br> esse <b>e_mail</b>: ".$user_email;    
               $msg_erro .= $m_erro.$msg_final; 
               echo $msg_erro;
               exit();                    
         }
         ///  Caso email encontrado
         if( intval($num)==1 ) {
             ///      $lnpa = (int) trim($arr_nome_val["pa"]);      
             $lnpa = (int) mysql_result($rs_check,0,"pa");
             $codigousp= (int) mysql_result($rs_check,0,"codigousp");
             $nome= (string) mysql_result($rs_check,0,"nome");
             ///   MySql - Select procurando codigo PA
             $sqlselect ="select descricao from $bd_2.pa where codigo=$lnpa ";
             $result_pa=mysql_query($sqlselect);
             if( ! $result_pa ) {
                 ////  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
                  $msg_erro .= "ERRO: Select Tabela  pa  - ".mysql_error().$msg_final;
                  echo  $msg_erro;
                  exit();
             }  
             $descricao_pa = trim(mysql_result($result_pa,0,"descricao"));
            if( isset($result_pa) )  mysql_free_result($result_pa);
             ///
         } 
         ///
         ///  Criando nova Senha
         $new_pwd = GenPwd();
         /// $pwd_reset = PwdHash($new_pwd);
         $pwd_reset = trim($new_pwd);
          /*
           $rs_activ = mysql_query("update $bd_1.usuario set senha=password('$pwd_reset') WHERE "
                            ." upper(trim(login))='$user_login' ");
           ********************************************************************************/  
           $lnerro=0;
           ///  Start a transaction - ex. procedure    
           mysql_query('DELIMITER &&'); 
           mysql_query('begin'); 
           ///  Execute the queries          
           ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
           mysql_query("LOCK TABLES $bd_1.usuario  UPDATE ");
           $rs_activ = mysql_query("update $bd_1.usuario set senha=password('$pwd_reset') WHERE  codigousp=$codigousp ");
           ////            
           if( ! $rs_activ ) {
                 $lnerro=1;
                ///  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
                $msg_erro .= "Atualizando senha  - ".mysql_error().$msg_final;
                mysql_query('rollback'); 
           } else {
               mysql_query('commit'); 
           }
           /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
           mysql_query("UNLOCK  TABLES");
           ///  Complete the transaction 
           mysql_query('end'); 
           mysql_query('DELIMITER');         
           /***********************************
               Caso houve erro 
           */
           If( intval($lnerro)>0 ) {
               echo  $msg_erro;
               exit();                          
           }       
           ///
           $host  = $_SERVER['HTTP_HOST'];
           $data_hoje=date("d/m/Y"); $horario=date("H:i");
           $retornar = html_entity_decode("http://$host$_SESSION[pasta_raiz]");                 
           //  $host_upper = strtoupper($host);           
           $host_lower = strtolower($host);           
           ///  $assunto =html_entity_decode("Redefini??o de senha");    
           ///  $assunto =html_entity_decode("RGE/SISTAM - Informativo e Provid?ncia");    
           $assunto ='RGE/SISTAM/REXP - Informativo e Providencia';    
           //  $assunto = utf8_encode("RGE/SISTAM - Informativo e Provid?ncia");    
           //  $corpo=html_entity_decode("Aqui est?o os seus dados da nova senha como ".ucfirst($nome_key));
        //   $corpo=html_entity_decode("Aqui est?o os seus dados da nova senha provis?ria");
           $corpo=html_entity_decode("RGE/SISTAM/REXP - Registro de Anotações");

       ////    $headers1  = "MIME-Version: 1.0\n";
         //   $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
       ////    $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
           //  $headers1 .= "X-Priority: 3\n";
       ////    $headers1 .= "X-Priority: 1\n";
           //  $headers1 .= "X-MSMail-Priority: Normal\n";
       ////    $headers1 .= "X-MSMail-Priority: High\n";           
       ////    $headers1 .= "X-Mailer: php\n";
           //  $headers1 .= "Return-Path: xxx@...\n";
           //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
            //  $headers1 .= "Return-Path: bezerralaf@gmail.com; spfbezer@fmrp.usp.br\n";
            //  $headers1 .= "Return-Path: bezerralaf@gmail.com; spfbezer@fmrp.usp.br\n";
        ////    $headers1 .= "Return-Path: {$_SESSION["gemac"]} \n";
            
           //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
           //  $headers1 .= "From: \"RGE/SISTAM/REXP\" <gemac@genbov.fmrp.usp.br>\r\n";   
       ////    $headers1 .= "From: \"RGE/SISTAM/REXP\" <{$_SESSION["gemac"]}>\r\n";   
           
         //  $headers1 .= "Bcc: gemac@genbov.fmrp.usp.br\r\n";                    
          // $headers1 .= "Bcc: bezerralaf@gmail.com; spfbezer@fmrp.usp.br \r\n";                    
        ////   $headers1 .= "Bcc: {$_SESSION["gemac"]} \r\n";                    
           
           /// send email
           $message = $corpo."\n<br>
           <br>
           Nome: ".utf8_encode($nome)."<br/>
           NOVA senha (provisória): $new_pwd \n<br/><br/>

           Emitida em: $data_hoje às $horario <br>
           ______________________________________________________<br>
           Esta é uma mensagem automática.<br> 
           *** Não responda a este EMAIL ****
           ";
           ////  Enviando mensagem para email atribuido
                     
             /****************** 
                Certifique-se de utilizar o MIME 1.1, pois é o mais atual. A versão 1.0 não é recomendado.         
                $headers = "MIME-Version: 1.1\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
            *******/ 
                $headers = "MIME-Version: 1.1\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
            
            $lc_gemac= $_SESSION["gemac"];
            ///
            ///  FROM/Emissor
            $headers .= "From: RGE/SISTAM/REXP <$lc_gemac>  \n";

            /// return-path. Precisa ser uma caixa postal do mesmo dominio da hospedagem
            /// $headers .= "Return-Path: RGE/SISTAM/REXP <$lc_gemac>  \n"; 
            $headers .= "Return-Path: RGE/SISTAM/REXP <$lc_gemac>  \n"; 
            /// $headers .= "Return-Path: gemac@genbov.fmrp.usp.br  \n"; 
            ///
            //// Com COPIA para
            ///  $headers .= 'Cc: spfbezer@gmail.com>' . "\n"; 

            /// Cópia OCULTA para
            ///  $headers .= 'Bcc: GEMAC <spfbezer@gmail.com>' . "\n";
            ///  $headers .= 'Bcc: GEMACS <paulo_todos@genbov.fmrp.usp.br>  \n '; 
            ///  $headers .= "Bcc: RGE/SISTAM/REXP <gemac@genbov.fmrp.usp.br>   \n"; 
             $headers .= "Bcc: RGE/SISTAM/REXP <$lc_gemac>   \n"; 

            /// SUBJECT/Assunto
            ///  $subject = "Testando o PHP Mail"; 
            $subject =$assunto ='RGE/SISTAM/REXP - Informativo e Providencia';    
            ///
            ///  TO/Destinatario
            ///   destinatário. Você pode configurar uma variável para coletar o endereço preenchido no formulário
            ///  $to = "Sebastião <spaulfb@hotmail.com>";
           ////      $user_email = "Sebasti&atilde;o <spaulfb@hotmail.com>";
            $to = "$user_email";

      ///   $enviado = mail($user_email, $assunto,utf8_decode($message), utf8_decode($headers1));
           $enviado = mail($to,$subject, utf8_decode($message), utf8_decode($headers));      
           ////         
           if( $enviado  ) {
               ///  Mensagem de envio da nova SENHA
               $msg_ok .= "Sua senha foi redefinida e uma nova senha foi enviada para seu endereço de e-mail.<br>"
                    ."<a href=\"$retornar\"  title=\"Clicar\" >Retornar</a>".$msg_final;                            
           } else {
                $m_erro="Erro para criar nova senha. MAIL envio.";   
           }               
          ///
          if( strlen(trim($m_erro))>=1 ) {
               $msg_erro .= $m_erro.$msg_final; 
               echo $msg_erro;
          } else {
               echo $msg_ok;
          }
          exit();
    } 
    /// FInal - IF Redefinir SENHA
    ///
    ///   Autorizar o acesso do usuario novo
    if( strtoupper($val)=="AUTORIZAR" ) {
         $m_array_temp = implode(",",$array_temp);        
         $m_array_t_value = implode(",",$array_t_value);
         $m_erro="";  unset($m_email_arr);
         /// Verificando campo email
         $m_email_arr = array('email','e_mail','user_email');
         $count_email = count($m_email_arr);
         for( $i=0; $i<$count_email ; $i++ ) {
              $cpo_email =  $m_email_arr[$i];
              if( array_key_exists($cpo_email,$arr_nome_val) ) break;
         }
         ///  if( ! isEmail($data['user_email'])) {     
         if( ! isEmail($arr_nome_val[$cpo_email]) ) {
              /// $err[] = "ERROR - Please enter a valid email"; 
              $m_erro= "Informe um e-mail v?lido";
         }
         ///
         if( strlen(trim($m_erro))<1 ) {
               $user = mysql_real_escape_string($arr_nome_val[codigousp]);
               $activ = mysql_real_escape_string($arr_nome_val[activ_code]);
               $upper_email=strtoupper(trim($arr_nome_val[$cpo_email]));
               // Verifique se o Usuário ? um Código v?lido e ativo
          /*     $rs_check = mysql_query("Select  id from users "
                        ." where upper(trim(user_email))='$upper_email' and "
                        ." md5_id='$user' and activation_code='$activ' ");
            */
                        
               $rs_check = mysql_query("Select  a.codigousp,a.login,a.pa,b.e_mail from "
                                     ." pessoal.usuario a,  pessoal.pessoa b where  "
                                      ." trim(a.codigousp)=$user and a.activation_code='$activ' and "
                                      ."  upper(trim(b.e_mail))='$upper_email'  and  a.codigousp=b.codigousp  ");
               //                       
               // Verificando se houve erro no Select Tabdla Usuario
               if( ! $rs_check ) {
                     mysql_free_result($rs_check);
                     //  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
                     die("ERRO: Select pessoal.usuario e campos  - ".mysql_error());
                }  
                $num = mysql_num_rows($rs_check);
                $n_pa = mysql_result($rs_check,0,pa);
                foreach( $array_usuarios as $key =>$valor ) {
                      if( $n_pa==$valor  ) {
                          $nome_key = $key;
                          break;
                      }
                }
               //  Coincidir com linha encontrada com 1 ou mais resultados - o Usuário ? autenticado
               if ( $num<=0 ) { 
                     //  $err[] = "Sorry no such account exists or activation code invalid.";
                     $m_erro = "ERRO: não existe usuário/login com o referido código de ativação.";
                    //header("Location: activate.php?msg=$msg");
                    //exit();
               }  else {
                    $m_login= trim(mysql_result($rs_check,0,login));                   
                    // defina o campo aprovou (approved) como 1 para ativar a conta
                    $rs_activ = mysql_query("Update pessoal.usuario set aprovado='1' WHERE "
                               ." trim(codigousp)=$user  AND  activation_code=$activ ");
                    // Verificando se houve erro no update            
                    if( ! $rs_activ ) {
                          ///  die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
                          die("ERRO: Não foi possível efetivar o usuario/login. ".mysql_error());
                    }
                    // Recolhe automaticamente: hostname or domain  like example.com) 
                    $host  = $_SERVER['HTTP_HOST'];  $host_upper = strtoupper($host);
                    $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                     $new_path = preg_replace('/\/includes/i','',$path);
                    //  $msg[] = "Thank you. Your account has been activated.";
                    echo  "Sua conta <b> $m_login </b>como <b>".ucfirst($nome_key)."</b> foi ativada com sucesso.<br><br>"
                            ."Para utilizar os recursos dispon&iacute;veis, acesse a p&aacute;gina do SISTAM/REXP ou clique "
                            ."<a href='http://$host$new_path/' title='Clicar' style='cursor: pointer;' > aqui</a>.<br>";

               }
         }             
         //
         if( strlen(trim($m_erro))>=1 ) {
              $msg_erro .= $m_erro.$msg_final; 
              echo $msg_erro;
         }
         exit();                                         
    }  //  FINAL do IF Autorizar o acesso do usuario novo
   //    
} 
#
ob_end_flush(); /* limpar o buffer */
#  
?>
