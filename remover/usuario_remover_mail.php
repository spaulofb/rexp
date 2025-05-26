<?php
/***    Script para enviar dados para o Administrador/Supervisor
*         20170720 
***/   
///
///  Verificando se session_start - ativado ou desativado
if( ! isset($_SESSION)) {
    session_start();
}
///  SESSIONS
if( ! isset($_SESSION["e_mail_user"]) ) {
    $_SESSION["res_mail"]="<br/>ERRO: Ocorreu um erro durante o envio do email.<br/>SESSION e_mail_user desativada. CORRIGIR<br/>";
} else {
    ///  SESSIONS
    if( isset($_SESSION["e_mail_user"]) )  $aprovador_email=$_SESSION["e_mail_user"];
    ///
    if( isset($_SESSION["gemac"]) )  $aprovador_email=$_SESSION["gemac"];
    if( isset($_SESSION["assunto"]) ) $assunto=$_SESSION["assunto"];
    if( isset($_SESSION["corpo"]) ) $corpo=$_SESSION["corpo"];
    ///
    $headers1  = "MIME-Version: 1.0\n";
    ///  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
    $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
    $headers1 .= "X-Priority: 3\n";
    $headers1 .= "X-MSMail-Priority: Normal\n";
    $headers1 .= "X-Mailer: php\n";
    ///  $headers1 .= "Return-Path: xxx@...\n";
    ///  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
    $headers1 .= "Return-Path: $aprovador_email\n";
    $headers1 .= "From: \"RGE/SISTAM\" <$aprovador_email>\r\n";   
    $message = "<p style='text-align:justify;' >$corpo<br>
               Nome: $nome_user<br>
               Código: $cod_user<br>
               Categoria: $categoria_user<br>
               Usuário/Email: $e_mail_user<br><br>
               <a href='#' click='$a_link' title='Clicar' target='_blank' style='cursor: point; text-decoration: none;'  >$a_link</a><br>
               ______________________________________________________<br>
               Esta é uma mensagem automática.<br> 
               *** Não responda a este EMAIL ****
             </p>";
    ////

/***
     echo "ERRO:  usuario_remover_mail/17  --->>>  \$e_mail_user = $e_mail_user  <<<---  \$aprovador_email = $aprovador_email -->>> \$assunto = $assunto  --- \$corpo = $corpo <br/> 2) \$message = $message   <br/> 3) \$headers1 = $headers1   <br/> \$_SESSION[url_central] = {$_SESSION["url_central"]} ";
    exit();
***/    

/***
    $res_mail=$_SESSION["res_mail"]=mail($aprovador_email, stripslashes(utf8_decode($assunto)), utf8_decode($message),$headers1);
***/    
    $res_mail=$_SESSION["res_mail"]=mail($e_mail_user, stripslashes(utf8_decode($assunto)), utf8_decode($message),$headers1);
    ///
    if( $res_mail ) {
        /**
       $msg_ok .="<br>Email enviado com sucesso!<br><br>";
       echo $msg_ok;
       ***/
       $_SESSION["res_mail"]="<br/>Email enviado com sucesso!<br/>";
    } else {
        /*
           $msg_ok .="<br>ERRO: Ocorreu um erro durante o envio do email.<br><br>";
           echo $msg_ok;        
           exit();            
       */
        $_SESSION["res_mail"]="<br/>ERRO: Ocorreu um erro durante o envio do email.<br/>";
        ///
    }
    /// 
}
////
?>