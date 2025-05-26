<?php
/*
*   REXP - REGISTRO DE EXPERIMENTO - ANOTA??O DE PROJETO
* 
*       MODULO: index_ajax - complemento AJAX do index 
*  
*   LAFB/SPFB110827.1736 - Corre??es gerais
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
/* não gravar em cache */
#
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=iso-8859-1");
///
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");
#
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
// extract: Importando vari?veis POST para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE); 

///  Enviar mensagens 
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
/// Final - Mensagens para enviar 
///

///  Verificando POST userid
///     campo para digitar usuario
if( ! isset($_POST["login_down"]) ) {
    ////  path e arquivo local
     $msg_erro .= "POST login_down não está ativa. Corrigir".$msg_final;  
     echo $msg_erro;
     exit();
    ///
}
$_SESSION["usuario_conectado"] = $usuario_conectado = $_POST["login_down"];
///
///   Atualizado 20180928 - Correto
///  Diretorio principal exe /var/www/html/aqui
///  $dir_principal=__DIR__;
///
///  Verificando SESSION dir_principal
if( ! isset($_SESSION["dir_principal"]) ) {
    ////  path e arquivo local
     $msg_erro .= "Sessão dir_principal não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
    ///
}
$dir_principal = $_SESSION["dir_principal"];
///
$n_erro=0;
if( strlen($dir_principal)<1 ) $n_erro=1;
///
///   CASO OCORREU ERRO GRAVE
if( intval($n_erro)>0 ) {
     $msg_erro .= "Erro ocorrido na parte: $n_erro.".$msg_final;  
     echo $msg_erro;
     exit();
}
/***
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
***/
require_once("{$_SESSION["dir_principal"]}inicia_conexao.php");
///
////  path e arquivo local
$dirarq=$_SERVER['SCRIPT_FILENAME'];

////  Arquivo local  -- Correto
$arqlocal =  basename(__FILE__);
///
///  Conectando BD
$_SESSION["msg_erro"]="";
include("{$_SESSION["pasta_ligacao"]}includes/conectar_bd.php");
if( strlen($_SESSION["msg_erro"])>0 ) {
    echo "<br/>".$_SESSION["msg_erro"];
    exit();
}
/********   Final -   Conectando BD    *******/ 
///
/*   Processando Codigo     */
///  $codimg_atual = $m_cod_img;
///  Privilegio de Acesso - PA
////  INCLUINDO CLASS - 
require_once("{$_SESSION["pasta_ligacao"]}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
///
$m_onload = "";
if( isset($_POST["m_onload"]) ) $m_onload = $_POST["m_onload"]; 
////
if( strtoupper(trim($m_onload))=="SUBMIT"  ) {
    ///
    if( isset($_POST["m_cod_img"]) ) {
        $codimg_atual=$_POST["m_cod_img"];
    }  else {
        if( isset($_SESSION["captchacodigo"]) ) {
            $codimg_atual = $_SESSION["captchacodigo"];       
        }
    }
    ///
    /// 
    $login_down=""; $senha_down=""; $codigo_down="";    
    if( isset($_POST["login_down"]) ) $login_down=trim($_POST["login_down"]);
    if( isset($_POST["senha_down"]) ) $senha_down=trim($_POST["senha_down"]) ;
    if( isset($_POST["codigo_down"]) ) $codigo_down=trim($_POST["codigo_down"]);

    ///  Verificando usuario, senha e codigo
    if( strlen($login_down)<1 || strlen($senha_down)<1  || strlen($codigo_down)<1 ) {
         ////  $msg_erro .="Os Campos s&atilde;o obrigat&oacute;rios.".$msg_final; 
         echo $funcoes->mostra_msg_erro("Os Campos s&atilde;o obrigat&oacute;rios.");
         exit();
    }
    ///
    if( ! isset($codimg_atual) ) $codimg_atual="";
    if( strlen($codigo_down)<1 and strlen($codimg_atual)<1  ) {
          $msg_erro .= "Falha grave reiniciar.".$msg_final;  
          echo  $msg_erro;
          exit();
    }
    ///
    ///  Comparando variaveis de Codigo
    if( $codimg_atual!==$codigo_down ) {
         /***  echo "<p style=\"font-size:medium;font-weight:bolder;\" >";
                 echo "O c&oacute;digo est&aacute; errado.</p>";    
         ***/
         echo $funcoes->mostra_msg_erro("O c&oacute;digo est&aacute; errado.");
         exit();
    }
    /* 
        protecao sql injection escarpando as aspas 
    */
    $login_down=addslashes($login_down);
    $senha_down=addslashes($senha_down);
    $codigo_down=addslashes($codigo_down);
    #
    ///  Variaveis para SESSION´s
    $_SESSION["login_down"] = $login_down;
    $_SESSION["senha_down"] = $senha_down;        
    ///
    ///  Verificando Tabelas - login e senha
    $elemento=1;
    require("{$_SESSION["pasta_ligacao"]}includes/verificando.php");
    ///
    ///  Verificando retorno - usuario
    if( ! isset($_SESSION["total"])) $_SESSION["total"]=-1;   /// Ocorreu algum erro na busca do usuario
    if( intval($_SESSION["total"])<1 ) {
         $m_erro=0;
         ///  Verifica usuario
         if( isset($usuario_erro) ) {
             /// if( strlen(trim($usuario_erro))>1  ) {
              if( intval($usuario_erro)>0  ) {
                   $m_erro=$m_erro+1;
                   $msg_erro .= utf8_decode("Re-digite o campo Usu&aacute;rio").$msg_final;   
                   unset($usuario_erro);
              }
        }
        ///  Verifica senha
        if( isset($senha_erro) ) { 
             /// if( strlen(trim($senha_erro))>1 ) {
              if( intval($senha_erro)>0  ) {
                  $m_erro=$m_erro+1;
                  ///  $msg_erro .=$senha_erro.$msg_final;
                  $msg_erro .= utf8_decode("Re-digite campo Senha").$msg_final;                
                  unset($senha_erro);       
             }
        }
        ////  Verifica se houve erro nos dois campos usuario e senha
        if( intval($m_erro)>1 ) {
            $msg_erro .= utf8_decode("Re-digite campos: Usu&aacute;rio e Senha").$msg_final;   
        }
        echo  $msg_erro;
        exit();      
    }
   ///   
}
/* 
       Consulta verifica se existe usuario
           com o usuario e a senha          
*/
////  IMPORTANTE: SESSION total
if( ! isset($_SESSION["total"])  )  $_SESSION["total"]="";
if( intval($_SESSION["total"])==1 ) {         
        ///
        
        
        
        ///  login ou e_mail -  Tabela pessoal.usuario(login) e pessoal.pessoa(e_mail)
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
        ///   
        $result_pa=mysql_query($cmdsql);
        if( ! $result_pa  ) {
            $msg_erro .= "SELECT participante/pessoa: ".mysql_error().$msg_final;
            echo $msg_erro; 
            exit();  
        }
        $regs = mysql_num_rows($result_pa);
        if( intval($regs)>1 ) {
              ///   $num_pas = count($array_usuarios);         
              $num_pas= (int) count($array_pa);  
              /* 
                    ABAIXO tag Select - Selecionar Chefe, Orientador, Orientado etc...
                     sendo enviado para a function pa_selecionado - arq. authent_user.php                                                 
                */   
           ?>
            <p id="conteudo"  >Usu&aacute;rio aceito</p>
            <span  class="loginresultado"  >
                Selecione para logar como:&nbsp;&nbsp;
            <select  name="permit_pa"  id="permit_pa" class="td_select"  onchange="javascript: pa_selecionado('pa_selecionado',this.value);"  title="Selecionar Privil&eacute;gio de Acesso (PA)"  >            
            <option value="" >Selecione</option>
            <?php
             while( $linha=mysql_fetch_array($result_pa)) {       
                    ///  htmlentities - o melhor para transferir na Tag Select
                    $codigo_pa= (int) $linha["pa"];  
                    ///  foreach( $array_usuarios as $chave => $valor )  { 
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
        } else if( intval($regs)==1 ) {
            $permit_pa="";
            if( $result_pa ) {
                //   $permit_pa=mysql_result($resultado_pa,0,"pa");
                $permit_pa=mysql_result($result_pa,0,"pa");   
                $opcao="PA_SELECIONADO";
            }
            ///       
        } else if( intval($regs)<1 ) {
            /*  Caso o total seja zero sair com exit() 
                 destroy qualquer session                */
            include("php_include/ajax/includes/sair.php");        
            exit();
        }    
       ////
}
//    
///  if( $_SESSION["total"]==1 and isset($permit_pa) )  {  
if(  intval($_SESSION["total"])==1 ) {
   ///
   if( strtoupper(trim($opcao))=="PA_SELECIONADO" )  {  
         ///  
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
         ///  unset($login_down);    unset($senha_down);    unset($codigo_down);
         $navegador = $_SERVER["HTTP_USER_AGENT"];
         $pos = strpos($_SERVER["HTTP_USER_AGENT"],'MSIE');
         if( isset($parte1) ) unset($parte1); 
         if( isset($parte2) ) unset($parte2); 
         if( isset($_POST) ) {
            $_POST = array(); unset($_POST);     
         }  
         $_SESSION["len_val"]=$len_val;
         $_SESSION["action"]="projetos_rexp";
         include('php_include/ajax/includes/exec_ie_firefox.php');      
         exit();   
   }
} else if( intval($_SESSION["total"])<>1 ) {
      ///  session_destroy();    
     /*  Caso o total seja zero sair com exit() 
          destroy qualquer session                */
     include("php_include/ajax/includes/sair.php");        
}
///  print'<a href=formulario.php >'.'<h2 class="aviso">Senha Invalida</h2>'.'</a>';
///  $msg_erro .= "Falha na autentica&ccedil;&atilde;o do Usu&aacute;rio/Login".$msg_final;
///  echo $msg_erro;
#
/* Informarmos senha invalida */
#
ob_end_flush(); /* limpar o buffer */
#
?>
