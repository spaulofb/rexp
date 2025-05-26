<?php
/*
*   REXP - REGISTRO DE EXPERIMENTO - ANOTAÇÃO DE PROJETO
* 
*       MODULO: index_ajax - complemento AJAX do index 
*  
*   LAFB/SPFB110827.1736 - Correções gerais
*/

ob_start(); /* Evitando warning */
#
//  Verificando se sseion_start - ativado ou desativado
if( ! isset($_SESSION)) {
     session_start();
} 
//
if( isset($_SESSION["login_down"]) ) unset($_SESSION["login_down"]);
if( isset($_SESSION["senha_down"]) ) unset($_SESSION["senha_down"]);
if( isset($_SESSION["total"]) )  unset($total);
#
/* Não gravar em cache */
#
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=iso-8859-1");
#
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
// extract: Importando variáveis POST para a tabela de símbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE); 

$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
//
//    Varios arrays
include("includes/array_menu.php");
//
//  $_SESSION['array_usuarios'] = $array_usuarios;  // CORRIGIDO:LAFB110825.2215
$elemento=5; $elemento2=6;
/*  NUNCA USAR ISSO
    @require_once('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
  include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
*/
//  Muito MELHOR ESSE JEITO
include("php_include/ajax/includes/conectar.php");
/*   Processando Codigo     */
///  $codimg_atual = $m_cod_img;
///  Privilegio de Acesso - PA
///  if( strlen(trim($permit_pa))<1  ) {
$opcao_upper="";
if( isset($_POST["opcao"]) ) {
    $opcao_upper=strtoupper(trim($_POST["opcao"])) ;
}
///
if( $opcao_upper="SUBMIT" ) {
    $procedimento_upper="";
    if( isset($_POST["procedimento"]) ) $procedimento_upper=strtoupper(trim($_POST["procedimento"]));
    if( $procedimento_upper="CAPTCHA_CRIAR" ) {
          ///  Enviando o codigo
          if( isset($_SESSION["captchacodigo"]) && ( ! isset($_SESSION["PASSOU"]) ) ) {
              echo $_SESSION["captchacodigo"];    
              $_SESSION["PASSOU"]=1;
              ///  unset($_SESSION["captchacodigo"]);
               unset($opcao_upper);
               unset($procedimento_upper);
               ///
          }
    }
    //// 
}
///
if( ! isset($permit_pa)  ) {
    ///
    if( isset($_POST["m_cod_img"]) ) {
        $codimg_atual=$_POST["m_cod_img"];
    }  else {
        if( isset($_SESSION["captchacodigo"]) ) {
            $codimg_atual = $_SESSION["captchacodigo"];       
        }
    }
    ///
    // if( !$login_down || !$senha_down  ) {
    if( isset($_POST["login_down"]) ) $login_down=$_POST["login_down"] ;
    if( isset($_POST["senha_down"]) ) $senha_down=$_POST["senha_down"] ;
    if( isset($_POST["codigo_down"]) ) $codigo_down=$_POST["codigo_down"] ;
    $login_down= trim($login_down); $senha_down= trim($senha_down); $codigo_down= trim($codigo_down);    
    if( strlen($login_down)<1 || strlen($senha_down)<1  || strlen($codigo_down)<1    ) {
         echo "<p  style=\"font-size:medium;font-weight:bold;\" >&nbsp;";
         echo "Os Campos s&atilde;o obrigat&oacute;rios</p>";
         exit();
    }
    ///
    if( $codimg_atual!==$codigo_down ) {
         echo "<p style=\"font-size:medium;font-weight:bolder;\" >";
         echo "O c&oacute;digo est&aacute; errado -  $codimg_atual!==$codigo_down </p>";
         exit();
    }
    /* 
        proteção sql injection escarpando as aspas 
    */
    $login_down=addslashes($login_down);
    $senha_down=addslashes($senha_down);
    $codigo_down=addslashes($codigo_down);
    #
    $aval_teste = "Projeto_RExp";
    //  @require_once('/var/www/cgi-bin/php_include/ajax/includes/avaliando_ajax.php');
    //  include('/var/www/cgi-bin/php_include/ajax/includes/avaliando_ajax.php');
    $login_recebido = $login_down; $senha_recebido= $senha_down;    
    $_SESSION['login_down'] =$login_down;
    $_SESSION['senha_down'] =$senha_down;        
    //  login ou e_mail -  Tabela pessoal.usuario(login) e pessoal.pessoa(e_mail)
    if( strpos($login_down,'@')===false ) {
         ///  login  como  codigousp da Tabela usuario
        $testar_login= (int) trim($login_down);
        ///  $_SESSION['user_cond']  =" a.login=$testar_login ";
         $_SESSION['user_cond']  =" a.codigousp=$testar_login ";
    } else  {
        ///  $email=$login_down;
         $testar_login=strtoupper(trim($login_down));
         $_SESSION['user_cond'] =" upper(trim(b.e_mail))='$testar_login'";   
    }
    //
    $email=$login_down;
    $mail_correcto=0;
    ///
    //  Verificando Tabelas - login e senha
    include('php_include/ajax/includes/verificando.php');
    if (! isset($_SESSION["total"])) $_SESSION["total"]=-1;     // Ocorreu algum erro na busca do usuario
    if( $_SESSION["total"]<1 ) {
         $m_erro=0;
         if( isset($email_erro) ) {
              if( strlen(trim($email_erro))>1  ) {
                   $m_erro=$m_erro+1;
                   $msg_erro .="Re-digite o campo Login/Email".$msg_final;   
                   unset($email_erro);
              }
        }
        if( isset($senha_erro) ) { 
             if( strlen(trim($senha_erro))>1  ) {
                  $m_erro=$m_erro+1;
                  ///  $msg_erro .=$senha_erro.$msg_final;
                  $msg_erro .="Re-digite campo Senha".$msg_final;                
                  unset($senha_erro);       
             }
        }
        if( $m_erro>1 ) $msg_erro .= "Re-digite campos: Login/Email e Senha".$msg_final;
        echo  $msg_erro;
        exit();      
    }
    /* Exemplo do resultado  do  Permissao de Acesso
      +-------------+--------+
      | descricao   | codigo |
      +-------------+--------+
      | super       |      0 | 
      | chefe       |     10 | 
      | vice        |     15 | 
      | aprovador   |     20 | 
      | orientador |     30 | 
      | anotador    |     50 | 
      +-------------+--------+
    */
    ///
    $cmdsql="SELECT lower(substring_index(substring_index(descricao,'-',1),' ',1)) as descricao, "
               ." codigo from $bd_2.pa order by codigo ";
    ///   
    $resultado_pa=mysql_query($cmdsql);
    if( ! $resultado_pa  ) {
         $msg_erro .="SELECT participante/pessoa: ".mysql_error().$msg_final;
         echo $msg_erro; 
         exit();
    } else {
         while ($row = mysql_fetch_array($resultado_pa, MYSQL_ASSOC)) {
               $descricao=$row["descricao"];
               $array_pa[$descricao]=$row["codigo"];
        }
        ///
        if( isset($resultado_pa) )  mysql_free_result($resultado_pa);
        $_SESSION["array_pa"]=$array_pa;
   }
   ///   
}
/*  Consulta verifica se existe usuario
           com o login_down passado e senha          
*/
if( ! isset($_SESSION["total"])  )  $_SESSION["total"]="";
if( $_SESSION["total"]==1 and ( ! isset($permit_pa) ) ) {         
            //
            if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];
            //  login ou e_mail -  Tabela pessoal.usuario(login) e pessoal.pessoa(e_mail)
            if( strpos($login_down,'@')===false ) {
                //  login  como  codigousp da Tabela usuario
                $testar_login= (int) trim($login_down);
                //  $_SESSION['user_cond']  =" a.login=$testar_login ";
                $_SESSION['user_cond']  =" a.codigousp=$testar_login ";
            } else  {
               //  $email=$login_down;
               $testar_login=strtoupper(trim($login_down));
               $_SESSION['user_cond'] =" upper(trim(b.e_mail))='$testar_login'";   
            }
            $usuario_email=$testar_login; 
            $_SESSION["n_login_down"]=trim($_SESSION["login_down"]); 
            $_SESSION["n_senha_down"]=trim($_SESSION["senha_down"]);         
           //  Alterado 20121204
           /*
            $cmdsql="SELECT a.pa FROM $bd_2.participante a, $bd_1.pessoa b "
                     ." WHERE (a.codigousp=b.codigousp ) and trim(b.e_mail)=\"$usuario_email\" order by a.pa  ";
             */        
            $cmdsql="SELECT a.pa FROM $bd_2.participante a, $bd_1.pessoa b "
                     ." WHERE (a.codigousp=b.codigousp ) and ".$_SESSION['user_cond']." order by a.pa  ";
            //   
            $result_pa=mysql_query($cmdsql);
            if( ! $result_pa  ) {
                $msg_erro .= "SELECT participante/pessoa: ".mysql_error().$msg_final;
                echo $msg_erro; 
                exit();  
            }
            $regs = mysql_num_rows($result_pa);
            if( $regs>1 ) {
                     //   $num_pas = count($array_usuarios);         
                    $num_pas= (int) count($array_pa);  
                    /* 
                        ABAIXO tag Select - Selecionar Chefe, Orientador, Orientado etc...
                         sendo enviado para a function pa_selecionado - arq. authent_user.php                                                 
                    */   
               ?>
                <p class="titulo_usuario"  >Usu&aacute;rio aceito</p>
                
                <span  class="td_inicio1" style="background-color: #FFFFFF; color: #000000; border: none; vertical-align: middle; " >
                     Selecione para logar como:&nbsp;&nbsp;
                <select  name="permit_pa"  id="permit_pa" class="td_select"  onchange="javascript: pa_selecionado('pa_selecionado',this.value);"  title="Selecionar Privil&eacute;gio de Acesso (PA)"  >            
                <option value="" >Selecione</option>
                <?php
                 while($linha=mysql_fetch_array($result_pa)) {       
                        //  htmlentities - o melhor para transferir na Tag Select
                        $codigo_pa= (int) $linha["pa"];  
                        //  foreach( $array_usuarios as $chave => $valor )  { 
                        foreach( $array_pa as $chave => $valor )  {                
                            $campo_nome = ucfirst($chave);
                            $valor= (int) $valor;
                            if( $valor==$codigo_pa ) {
                                echo "<option  value=".$valor." title='Clicar'  >";
                                echo  $campo_nome."&nbsp;</option>" ;
                            }                
                        }
                 }
                ?>
                </select>
                </span>
                <?php
                 if( isset($result_pa) )  mysql_free_result($result_pa);
                exit();
            } else if( $regs==1 ) {
                $permit_pa="";
                if( $result_pa ) {
                    //   $permit_pa=mysql_result($resultado_pa,0,"pa");
                    $permit_pa=mysql_result($result_pa,0,"pa");   
                    $opcao="PA_SELECIONADO";
                }
                //       
            } else if( $regs<1 ) {
                /*  Caso o total seja zero sair com exit() 
                     destroy qualquer session                */
                include("php_include/ajax/includes/sair.php");        
                exit();
            }    
           ////
}
//    
//  if( $_SESSION["total"]==1 and isset($permit_pa) )  {  
if( $_SESSION["total"]==1 ) {
   ///
   if( strtoupper(trim($opcao))=="PA_SELECIONADO" )  {  
        /*    if( isset($_SESSION["array_pa"]) )  {
               $array_pa= (int) $_SESSION["array_pa"];    
               $permit_pa= (int) $_SESSION["array_pa"];
            }
            
                $msg_erro .= " authent_user_ajax.php/255  -  \$permit_pa =  $permit_pa ";
            echo $msg_erro;
            exit(); 

            
          * 
          * 
          */  
        if( strlen(trim($_SESSION["n_login_down"]))>0  )  {
            $len_val = strlen(trim($_SESSION["n_login_down"]));          
        } elseif( strlen(trim($_SESSION["login_down"]))>0  )  {
            $len_val = strlen(trim($_SESSION["login_down"]));          
        }    
  
        $_SESSION["permit_pa"]=$permit_pa; 
        $_SESSION["login_down"]=trim($_SESSION["n_login_down"]);   
        $_SESSION["senha_down"] = trim($_SESSION["n_senha_down"]);    
        /* Armazenando as variaveis na nossa Session */
        unset($total); 
        //  unset($login_down);    unset($senha_down);    unset($codigo_down);
        $navegador = $_SERVER["HTTP_USER_AGENT"];
        $pos = strpos($_SERVER["HTTP_USER_AGENT"],'MSIE');
        if( isset($parte1) ) unset($parte1); 
        if( isset($parte2) ) unset($parte2); 
        if( isset($_POST) ) {
           $_POST = array(); unset($_POST);     
        }  
        $_SESSION["len_val"]=$len_val;
        $_SESSION["action"]="projetos_rexp";
 //       $pasta_raiz='/rexp/'; 
   //     $_SESSION["pasta_raiz"]=$pasta_raiz;
        include('php_include/ajax/includes/exec_ie_firefox.php');      
        exit();   
   }
} else if( $_SESSION["total"]<>1 ) {
     //  session_destroy();    
     /*  Caso o total seja zero sair com exit() 
          destroy qualquer session                */
    include("php_include/ajax/includes/sair.php");        
}
//  print'<a href=formulario.php >'.'<h2 class="aviso">Senha Invalida</h2>'.'</a>';
//  $msg_erro .= "Falha na autentica&ccedil;&atilde;o do Usu&aacute;rio/Login".$msg_final;
//  echo $msg_erro;
#
/* Informarmos senha invalida */
#
ob_end_flush(); /* limpar o buffer */
#
?>
