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
/* N?o gravar em cache */
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
///  Verificando SESSION incluir_arq - 20180618
$incluir_arq="";
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
    echo $msg_erro;
    exit();
}
///
///    Varios arrays
///  include("includes/array_menu.php");
include_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
///
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
////  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
///
///  if( strlen(trim($permit_pa))<1  ) {
////
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
    ///  Verificando os campos
    if( strlen($login_down)<1 || strlen($senha_down)<1  || strlen($codigo_down)<1 ) {
        /***  echo "<p  style=\"font-size:medium;font-weight:bold;\" >&nbsp;";
         echo "Os Campos s&atilde;o obrigat&oacute;rios</p>";    ***/
         ////  $msg_erro .="Os Campos s&atilde;o obrigat&oacute;rios.".$msg_final; 
         echo $funcoes->mostra_msg_erro("Os Campos s&atilde;o obrigat&oacute;rios.");
         exit();
    }
    ///
    if( ! isset($codigo_down) ) $codigo_down="";
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
         echo "O c&oacute;digo est&aacute; errado.</p>";    ***/
         echo $funcoes->mostra_msg_erro("O c&oacute;digo est&aacute; errado.");
         exit();
    }
    /****
 echo "ERRO: authent_user/96 - $codimg_atual/captchacodigo  e  $codigo_down  ";
 exit();   
    *****/
    
    /* 
        prote??o sql injection escarpando as aspas 
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
    ///
    $email=$login_down;
    $mail_correcto=0;
    ///
    ///  Verificando Tabelas - login e senha
    include('php_include/ajax/includes/verificando.php');
    ///
    if( ! isset($_SESSION["total"]) ) $_SESSION["total"]=-1;  /// Ocorreu algum erro na busca do usuario
    if( intval($_SESSION["total"])<1 ) {
         $m_erro=0;
         if( isset($email_erro) ) {
              if( strlen(trim($email_erro))>1  ) {
                   $m_erro=$m_erro+1;
                   $msg_erro .= utf8_decode("Re-digite o campo Login/Email").$msg_final;   
                   unset($email_erro);
              }
        }
        if( isset($senha_erro) ) { 
             if( strlen(trim($senha_erro))>1 ) {
                  $m_erro=$m_erro+1;
                  ///  $msg_erro .=$senha_erro.$msg_final;
                  $msg_erro .= utf8_decode("Re-digite campo Senha").$msg_final;                
                  unset($senha_erro);       
             }
        }
        ////  Verifica se houve erro
        if( intval($m_erro)>1 ) {
            $msg_erro .= utf8_decode("Re-digite campos: Login/Email e Senha").$msg_final;   
        }
        echo  $msg_erro;
        exit();      
    }
    ///  Verifica se a SESSION email_usuario foi enviada pelo arquivo verificando.php
    $num_erros=0;
    if( ! $_SESSION["email_usuario"] ) {
         $msg_erro .= utf8_decode("SESSION email_usuario indefinida. Consulte administrador.").$msg_final;   
         $num_erros=1;
    }
    ///  Pesquisando o email do usuario
    $email=$_SESSION["email_usuario"];
    if( strpos($email,'@')===false ) {
         $msg_erro .= utf8_decode("Esse usuário não contém email cadastrado. Consulte administrador.").$msg_final;   
         $num_erros=2;
    }
    /// Caso houve erro
    if( intval($num_erros)>0 ) {
         echo  $msg_erro;
         exit();      
    } 
    ///  Repassando importante
    $_SESSION['login_down'] = $login_down = $_SESSION["email_usuario"];
    ///
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
               ." codigo FROM $bd_2.pa order by codigo ";
    ///   
    $resultado_pa=mysql_query($cmdsql);
    if( ! $resultado_pa  ) {
         $msg_erro .="SELECT participante/pessoa:&nbsp;db/mysql:&nbsp;".mysql_error().$msg_final;
         echo $msg_erro; 
         exit();
    } else {
         /// Numero de registros
        $_SESSION["regs_pa"] = $regs_pa = mysql_num_rows($resultado_pa);
        ///     
        if( intval($regs_pa)<1 ) {
              $msg_erro .= utf8_decode("Esse usuário não tem permissão de acesso.").$msg_final;   
              echo  $msg_erro;
              exit();      
        }
        ///
        while( $row = mysql_fetch_array($resultado_pa, MYSQL_ASSOC) ) {
               $descricao=$row["descricao"];
               $array_pa[$descricao]=$row["codigo"];
        }
        ///
        if( isset($resultado_pa) )  mysql_free_result($resultado_pa);
        if( isset($array_pa) ) $_SESSION["array_pa"]=$array_pa;
   }
   ///   
}
/*  Consulta verifica se existe usuario
           com o login_down passado e senha          
*/
if( ! isset($_SESSION["total"])  )  $_SESSION["total"]="";
if( $_SESSION["total"]==1 and ( ! isset($permit_pa) ) ) {         
      ///
      ///  if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];
      ///
      /*
        $cmdsql="SELECT a.pa FROM $bd_2.participante a, $bd_1.pessoa b "
                 ." WHERE (a.codigousp=b.codigousp ) and trim(b.e_mail)=\"$usuario_email\" order by a.pa  ";
      */        
      $cmdsql="SELECT a.pa FROM $bd_2.participante a, $bd_1.pessoa b "
                 ." WHERE (a.codigousp=b.codigousp ) and ".$_SESSION['user_cond']." order by a.pa  ";
      ///   
      $result_pa=mysql_query($cmdsql);
      if( ! $result_pa  ) {
          $msg_erro .= "SELECT participante/pessoa:&nbsp;db/mysql:&nbsp;".mysql_error().$msg_final;
          echo $msg_erro; 
          exit();  
      }
      ///  Numero de Participantes e  PA
      $regs = mysql_num_rows($result_pa);
      ///
      ///  Numero de registros - PA  
      if( intval($regs)>1 ) {
           ///   $num_pas = count($array_usuarios);         
           $num_pas= (int) count($array_pa);  
           /* 
                ABAIXO tag Select - Selecionar Chefe, Orientador, Orientado etc...
                sendo enviado para a function pa_selecionado - arq. authent_user.php                                               */   
        ?>
          <p id="conteudo"  >Usu&aacute;rio aceito</p>
            <span  class="loginresultado">
                Selecione para logar como:&nbsp;&nbsp;
            <select  name="permit_pa"  id="permit_pa" class="td_select"  onchange="javascript: pa_selecionado('pa_selecionado',this.value);"  title="Selecionar Privil&eacute;gio de Acesso (PA)"  >            
              <option value="" >Selecione</option>
              <?php
               while( $linha=mysql_fetch_array($result_pa) ) {       
                      ///
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
             if( isset($array_pa) ) $_SESSION["array_pa"]=$array_pa;
             exit();
        } else if( intval($regs)==1 ) {
            $permit_pa="";
            if( $result_pa ) {
                ///   $permit_pa=mysql_result($resultado_pa,0,"pa");
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
///    
///  if( $_SESSION["total"]==1 and isset($permit_pa) )  {  
if( intval($_SESSION["total"])==1 ) {
    ////
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
          if( strlen(trim($_SESSION["n_login_down"]))>0 ) {
                $len_val = strlen(trim($_SESSION["n_login_down"]));          
          } elseif( strlen(trim($_SESSION["login_down"]))>0 ) {
                $len_val = strlen(trim($_SESSION["login_down"]));          
          }    
          ///
          $_SESSION["permit_pa"]=$permit_pa; 
          $_SESSION["login_down"]=trim($_SESSION["n_login_down"]);   
          $_SESSION["senha_down"] = trim($_SESSION["n_senha_down"]);    
          /* Armazenando as variaveis na nossa Session */
          if( isset($total) ) unset($total); 
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
//  print'<a href=formulario.php >'.'<h2 class="aviso">Senha Invalida</h2>'.'</a>';
//  $msg_erro .= "Falha na autentica&ccedil;&atilde;o do Usu&aacute;rio/Login".$msg_final;
//  echo $msg_erro;
#
/* Informarmos senha invalida */
#
ob_end_flush(); /* limpar o buffer */
#
?>
