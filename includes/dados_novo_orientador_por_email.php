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
header("Content-Type: text/html; charset=ISO-8859-1",true);
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
//
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:</b>&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";

//  Conjunto de arrays 
include_once("array_menu.php");
// Conjunto de Functions
include("../script/stringparabusca.php");        

$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if ( isset($_POST[$xyz]) ) {
        $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
       if( $pos1 === false ) {
           ///  $$xyz=trim($_POST[$xyz]);
           ///   Para acertar a acentuacao - utf8_encode
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

$_SESSION["source"]=$source;       
$source_maiusc = strtoupper(trim($source));

if( $source_maiusc=="SAIR" ) {
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
} elseif( $source_maiusc=="SUBMETER" )  {
     /// Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
     include 'dbc.php';
     //
     set_time_limit(0); $m_erro=0;
     /*     
         AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
           e de depois usa o  - html_entity_decode 
     */
     unset($array_temp); unset($array_t_value);  $m_erro=0;
     unset($arr_nome_val); unset($count_array_temp);
     //  Arquivo importante definindo o array  \$arr_nome_val
     include("dados_campos_form_cadastrar_auto.php");
     //  Definindo os nomes dos campos recebidos do FORM
     foreach(  $arr_nome_val as $key => $value )  $$key =  $value;
     //  Array de emails
     $array_email = array("EMAIL","E_MAIL","E-MAIL","USER_EMAIL","EMAIL_USER");
     foreach( $arr_nome_val as $chave => $valor )  {
           $upper_email = strtoupper($chave);
           if( in_array($upper_email,$array_email) ) {
                 $key = $chave;
                 $upper_email = (string) strtoupper($valor);
                 break;
           }                         
     }
     //  Verificando campos 
     $elemento=5; ;$elemento2=6; $m_regs=0;
     /// include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");    
     include("php_include/ajax/includes/conectar.php");    
     if( strtoupper($val)=="ORIENTADOR_NOVO" ) {
          $m_erro="";   $lnerro=0;
          ///  Verifica se novo Orientador:  foi aprovado  ou NAO  Foi        
         if( isset($_SESSION["array_pa"]) ) {
               $array_pa=$_SESSION["array_pa"];       
               $orientador_pa=$array_pa["orientador"];                          
         }
         ///
         ///   $orientador_pa = $_SESSION["array_usuarios"]["orientador"];                                       
         if( strtoupper(trim($sn))=="NAO"  ) {
              ///  Start a transaction - ex. procedure    
              mysql_query('DELIMITER &&'); 
              mysql_query('begin'); 
              ///  Execute the queries          
              //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
              mysql_query("LOCK TABLES  $bd_1.usuario  DELETE, $bd_2.participante DELETE ");
              /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;         
              //  DELETE  particpante 
              $res_usuario = "DELETE from $bd_2.participante  WHERE codigousp=$codigousp and pa=$orientador_pa ";
               //                  
               $sqlcmd =  mysql_query($res_usuario);
               if( $sqlcmd ) { 
                   //  DELETE usuario
                   $res_pessoa= "DELETE  from $bd_1.usuario WHERE codigousp=$codigousp and pa=$orientador_pa "; 
                   $sqlcmd =  mysql_query($res_pessoa);      
                   if( $sqlcmd ) { 
                         //  Orientador nao foi aceito 
                         $m_erro=""; $lnerro=0;
                        ///  Concluindo as tabelas para Orientador Novo para ser aceito pelo Aprovador
                        $msg_ok .="<p style='font-size: medium; text-align:center; color: #000000;'>"
                                 ."<br>Orientador $nome n&atilde;o foi aceito pelo Aprovador.<br></p>".$msg_final;
                        mysql_query('commit'); 
                        echo $msg_ok;                    
                   } else { 
                        ///  mysql_error() - para saber o tipo do erro
                        $msg_erro .="&nbsp;Falha Tabela pessoa delete - ".mysql_error().$msg_final;
                        mysql_query('rollback'); 
                        echo $msg_erro;         
                        $lnerro=1;
                   }                
               } else { 
                  ///  mysql_error() - para saber o tipo do erro
                  $msg_erro .="&nbsp;Falha Cadastrar novo Orientador $nome - ".mysql_error().$msg_final;
                  mysql_query('rollback'); 
                  echo $msg_erro; 
                  $lnerro=1;        
               }       
               /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
               mysql_query("UNLOCK  TABLES");
               //  Complete the transaction 
               mysql_query('end'); 
               mysql_query('DELIMITER');         
               //  Caso Tabela acima foi aceita incluir dados na outra abaixo
               //   Mandar mensagem para o novo Orientador - cancelado
               if( $lnerro<1 ) {
                   $novo_orientador=$e_mail;
                   $host  = $_SERVER['HTTP_HOST'];
                   $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
                   //    $user=$arr_nome_val['codigousp'];
                   $user=$codigousp;
                   //  $m_local="ativar_orientador.php?user=".$user."&activ_code=".$activ_code."&pa=".$pa;
               //    $m_local="ativar_orientador.php?user=".$user."&activation_code=".$activation_code;
                   $m_local="ativar_orientador_por_email.php?user=".$user."&activation_code=".$activation_code;                
                   $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$retornar$m_local'  title='Clicar' >"
                             ."$retornar$m_local</a>"; 
                   //  $host_upper = strtoupper($host);           
                   $host_lower = strtolower($host);           
                   //  $assunto =html_entity_decode("Redefini??o de senha");    
                   //  $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
                   $assunto =html_entity_decode("RGE/SISTAM - Permiss?o para Orientador - Cancelada");                       
                   $corpo ="RGE/SISTAM - Permiss?o para Orientador - Cancelada<br>";
                   // $corpo .="$host_lower/rexp<br><br>";  //  Mostra o link do programa REXP  
                   $corpo .="<br><br>";    
                   $corpo .=html_entity_decode("Permiss&atilde;o como Orientador de Projeto.<br>N&atilde;o foi aprovada.\r\n");                    
                   $headers1  = "MIME-Version: 1.0\n";
                   //  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
                   $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
                   $headers1 .= "X-Priority: 3\n";
                   $headers1 .= "X-MSMail-Priority: Normal\n";
                   $headers1 .= "X-Mailer: php\n";
                   //  $headers1 .= "Return-Path: xxx@...\n";
                   //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
                   $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";
                   ///  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
                   ///  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
                   $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
                   
                   $message = "$corpo\n<br><br>
                   Nome: $nome<br>
                   Usuário/Email: $e_mail<br>
                   
                   ______________________________________________________<br>
                   Esta é uma mensagem automática.<br> 
                   *** não responda a este EMAIL ****
                   ";
                   mail($novo_orientador, $assunto, $message,$headers1);     
                   //
               }
               ///    FINAL _ NAO APROVANDO NOVO ORIENTADOR                   
         } elseif( strtoupper(trim($sn))=="SIM" ) {   //  Foi APROVADO como Orientador
             ////   Verifica se o  participante, pessoa e usuario  existe 
             $rs_check = mysql_query("SELECT a.codigousp,a.pa,a.aprovado,a.codigo_ativa,"
                           ." b.nome,b.e_mail,c.login,c.senha,c.aprovado as usu_aprovado "
                           ."  FROM  $bd_2.participante a, "
                           ." $bd_1.pessoa b, $bd_1.usuario c WHERE a.codigousp=$codigousp "
                           ."  and a.codigousp=b.codigousp and b.codigousp=c.codigousp "
                           ." and a.pa=$orientador_pa ");       
             //                       
             // Verificando se houve erro no Select Tabdla Usuario
             if( ! $rs_check ) {
                  die("ERRO: Select pessoal.usuario e campos  - ".mysql_error());
             }  
             /// Numero de registros
             $num = mysql_num_rows($rs_check);
             ///
             ///  Definindo os nomes dos campos recebidos do MYSQL SELECT
             $array_nome=mysql_fetch_array($rs_check);
             foreach( $array_nome as $key => $value )  $$key=$value;
             ///  Coincidir com linha encontrada com 1 ou mais resultados -  Usuário autenticado
             $activation_code = $_SESSION['activation_code'];
             ///
             if( intval($num)<=0 ) { 
                   $m_erro = "N&atilde;o existe Usuário/e_mail com o referido c&oacute;digo de ativação.";
             } elseif( intval($aprovado)>0 ) {   
                   ///  Esse Orientador ja esta cadastrado
                   $m_erro="";
                   $msg_ok  .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; '>"
                            ."<br>&nbsp;&nbsp;Esse Orientador:<br>"
                            ."<br>&nbsp;&nbsp;<b>".$nome."</b> e e_mail:&nbsp;<b>"
                            .$e_mail."</b> j&aacute est&aacute; cadastrado</span>".$msg_final;
                   echo $msg_ok;
             } else {
                   $m_login= trim($login);                   
                   /// if( $usu_aprovado<1 ) {
                       ///  Criando nova Senha
                       $new_pwd = GenPwd();
                    // }  
                    /*** 
                    *  Defina o campo aprovou (approved) como 1 e tambem 
                    *     activation_code para Ativar a Conta
                    */
                    $nerro=0;
                    ///  START a transaction - ex. procedure 
                    mysql_query('DELIMITER &&'); 
                    mysql_query('begin'); 
                    ///  Execute the queries          
                    mysql_query("LOCK TABLES $bd_1.usuario UPDATE, $bd_2.participante UPDATE  ");
                    if( $usu_aprovado<1  ) {
                          $sqlcmd = "UPDATE  $bd_1.usuario SET aprovado='1',"
                                  ." activation_code=$activation_code, "
                                  ." datacad='$datacad',datavalido='$datavalido', "
                                  ." senha=password('$new_pwd') "
                                  ."  WHERE  trim(codigousp)=$codigousp   ";
                          ///
                          $rs_activ = mysql_query($sqlcmd);     
                          /// Verificando se houve erro no update            
                          if( ! $rs_activ ) {
                              /*****
                              $m_erro = "N?o foi poss?vel efetivar o usuario/login. ".mysql_error();
                              ***/   
                              $m_erro = "N?o foi poss?vel efetivar o usuario/e_mail. ".mysql_error();
                              mysql_query('rollback'); 
                              $nerro=1;
                          } else {
                              mysql_query('commit'); 
                          }
                    }
                    /// Caso NAO houve erro
                    if( intval($nerro)<1 ) {
                        ///  UPDATE na tabela particiapnte
                        $sqlcmd = "UPDATE  $bd_2.participante SET aprovado='1',"
                                ." datacad='$datacad',datavalido='$datavalido', "
                                ." codigo_ativa=$activation_code   "
                                ." WHERE  trim(codigousp)=$codigousp and pa=$orientador_pa   ";
                        $rs_activ = mysql_query($sqlcmd);     
                       /// Verificando se houve erro no update            
                        if( ! $rs_activ ) {
                             $m_erro = "N?o foi poss?vel efetivar o usuario/e_mail. ".mysql_error();
                             mysql_query('rollback'); 
                             $nerro=1;
                        } else {
                             mysql_query('commit'); 
                        }
                    }
                    ///                   
                    mysql_query("UNLOCK  TABLES");
                    //  Complete the transaction 
                    mysql_query('end'); 
                    mysql_query('DELIMITER'); 
                    ///        
                   /***
                         Mandar mensagem para o novo Orientador - caso nao tenha erro               
                    ***/   
                   if( strlen(trim($m_erro))<1 ) {  // Enviar a mensagem por email
                         $senha_criada="Usar a mesma senha, caso esqueceu, clicar em: ";
                         $senha_criada.="Esqueceu a senha?";
                         if( intval($usu_aprovado)<1 ) {
                              $senha_criada="Senha: $new_pwd";
                         }
                         $senha_criada.='<br><br>';
                         $orientador_email=$e_mail;
                         $host  = $_SERVER['HTTP_HOST'];
                         ///  $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
                         $m_local = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
                         $user=$codigousp;
                         ///  $m_local="ativar_orientador.php?user=".$user."&activ_code=".$activ_code."&pa=".$pa;
                         ///  $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$retornar$m_local'  title='Clicar' >"
                         $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$m_local'  title='Clicar' >$m_local</a>"; 
                         ///  $host_upper = strtoupper($host);           
                         $host_lower = strtolower($host);           
                         ///  $assunto =html_entity_decode("Redefini??o de senha");    
                         ///  $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
                         ///  $assunto =html_entity_decode("RGE/SISTAM - Permiss?o para Orientador");    
                         $assunto =html_entity_decode("RGE/SISTAM - Permiss?o para Orientador - Aprovado");    
                         $corpo ="RGE/SISTAM - Permiss?o para Orientador - Aprovado<br>";
                         $corpo .="$host_lower/rexp<br><br>";
                         $corpo .=html_entity_decode("Aprovado como Orientador de Projeto.<br>Detalhes abaixo para acessar (Usu&aacute;rio/Senha).\r\n");                    
                         $from_email=$_SESSION["gemac"];
                         ///
                         $headers1  = "MIME-Version: 1.0\n";
                         ///  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
                         $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
                           $headers1 .= "X-Priority: 3\n";
                           $headers1 .= "X-MSMail-Priority: Normal\n";
                           $headers1 .= "X-Mailer: php\n";
                           ///  $headers1 .= "Return-Path: xxx@...\n";
                           ///  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
                         $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";
                         ///  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
                        ///  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";    
                        $headers1 .= "From: RGE/SISTAM < $from_email >";                    
                        ///
                        ///  $nome=utf8_encode($nome);
                        ///
                        $message = "$corpo\n<br><br>
                        Nome: $nome<br>
                        Usuário/Email: $e_mail<br>
                        $senha_criada

                        Clicar no link abaixo para acessar\n<br>

                        $a_link<br><br>

                     ______________________________________________________<br>
                     Esta é uma mensagem automática.<br> 
                     *** não responda a este EMAIL ****
                     ";
                     ///  mail($orientador_email, stripslashes(utf8_encode($assunto)), $message,$headers1);
                     ///
                     //// if( mail($orientador_email, stripslashes(utf8_encode($assunto)), $message,$headers1) ) {
                     if( mail($orientador_email, $assunto, $message,$headers1) ) {
                          $msg_ok .= "<span style='color: #000000; text-align: center; padding-left: 5px;font-size: medium; overflow: auto; '>"
                             ."&nbsp;&nbsp;Mensagem enviada para o novo Orientador:"
                             ."<br>&nbsp;&nbsp;<b>".utf8_encode($nome)."</b> no email informado:&nbsp;".$e_mail."</span>".$msg_final;
                           echo $msg_ok;                
                     } else {
                           $m_erro ="<span style='color: #000000; text-align: center; font-size: medium; overflow: auto; '>"
                              ."&nbsp;&nbsp;<b>Falha</b> no envio da mensagem para o novo Orientador:"
                              ."<br>&nbsp;Corrigir&nbsp;";
                           $m_erro .="<b>".utf8_encode($nome)."</b> no email informado:&nbsp;".$e_mail."</span>";
                          ///
                     }
                     ///
                }  ///  FINAL  do enviar a mensagem por email
             }
             ///            
          }  ///   FINAL - do sim ou nao da aprovacao do novo Orientador   
          ///
         ///  Caso foi encontrado ERRO         
         if( strlen(trim($m_erro))>=1 ) {
               $msg_erro .= $m_erro.$msg_final; 
               echo $msg_erro;
         }
    }  ///  FINAL do IF Permitir/Autorizar o acesso do usuario novo ORIENTADOR
   ///    
} 
#
ob_end_flush(); /* limpar o buffer */
#  
?>
