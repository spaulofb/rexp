<?php
/*
*    Loteria Jogos - Validando login do usuario
*/
if( ! isset($_SESSION) ) {
     session_start();
}
///  Verificando Tabelas - usuario e senha
///
$n_usuario_senha=0;
////  Verificando usuario
if( isset($_SESSION["login_down"]) ) {       
    $usuario_recebido = trim($_SESSION["login_down"]);
    $n_usuario_senha=1;
} elseif( isset($_SESSION["login"]) ) {
    $usuario_recebido = $_SESSION["login"];
    $n_usuario_senha=1;
} elseif( isset($_SESSION["usuario"]) ) {
    $usuario_recebido = $_SESSION["usuario"];
    $n_usuario_senha=1;
}  
///
if( intval($n_usuario_senha)>0 )  {
    ////  Verificando senha
    if( isset($_SESSION["senha_down"]) ) {       
        $senha_recebido = trim($_SESSION["senha_down"]);
        $n_usuario_senha=1;
    } elseif( isset($_SESSION["userpassword"]) ) {
        $senha_recebido = $_SESSION["userpassword"];
        $n_usuario_senha=1;
    } elseif( isset($_SESSION["n_senha_down"]) ) {
        $senha_recebido = $_SESSION["n_senha_down"];
        $n_usuario_senha=1;
    }  
    ///
}      
///
/// Caso variavel NAO setada - usuario ou senha
/// if( ! isset($senha_recebido)  ) {
if( intval($n_usuario_senha)<1 ) {
    $msg_erro = "<span class='texto_normal' style='color: #000; text-align: center;' >";
    $msg_erro .= "<span style='color: #FF0000; padding: 4px;' >";
    $msg_final="</span></span>";
    $msg_erro .="ERRO: Usuário ou senha incorretos. Corrigir".$msg_final;
    ///  Verificando se sseion_start - ativado ou desativado
    
    echo  $msg_erro; 
    
    /// Eliminar todas as variaveis de sessions
    $_SESSION = array();
    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($login_down) ) unset($login_down);     
    if( isset($senha_down) )  unset($senha_down); 
    //
    // response.setHeader("Pragma","no-cache"); 
    //  response.setHeader("Cache-Control", "no-cache"); 
    //  response.setDateHeader("Expires",0); 
    exit();
}
///
///  Aqui fazemos a conexo ao banco de dados e verificando o usuario 
if( ! isset($elemento) ) {
    /// 
    $msg_erro = "<span class='texto_normal' style='color: #000; text-align: center;' >";
    $msg_erro .= "<span style='color: #FF0000; padding: 4px;' >";
    $msg_final="</span></span>";
    $msg_erro .="ERRO: FALTANDO DEFINIR VARIAVEL IMPORTANTE".$msg_final;
    ///  Verificando se sseion_start - ativado ou desativado
    echo  $msg_erro; 
    exit();
}
///
//// $db_array = array( 1=> "dadosbase", "ajax", "teste");
$db_array = array( 1=> "id7287264_dadosbase", "ajax", "teste"); 
/// mysql_select_db($db_array[$elemento]) or die("ERRO/Conectar bd");
///
///  Atualizado em 20181003
$banco_de_dados=$db_array[$elemento];
///
///  Verificando conexao com localhost,usuario,bd
if( ! isset($_SESSION["bd_conectado"]) ) {
    /// 
    $msg_erro = "<span class='texto_normal' style='background-color:#FFFFFF; color: #000; text-align: center;' >";
    $msg_erro .= "<span style='color: #cc0000; padding: 4px;' >";
    $msg_final="</span></span>";
    $msg_erro .="ERRO: SESSION bd_conectado indefinida. Corrigir".$msg_final;
    ///  Verificando se sseion_start - ativado ou desativado
    echo  $msg_erro; 
    exit();
}
///

////  echo "\$_SESSION[bd_conectado] = {$_SESSION["bd_conectado"]} ---- \$banco_de_dados = $banco_de_dados  ";

mysqli_select_db($_SESSION["bd_conectado"],$banco_de_dados) or die("ERRO/Conectar bd");
///
$erro_usu_sen=0;
///   Aceitou Usuario/Senha - verificando senha 
////  Desativando variavel
if( isset($sqlresult) )  mysql_free_result($sqlresult);
///
///  CORRIGIDO HOJE - 20181003
///  session us_ipid senha do usuario em MD5
$_SESSION["us_ipid"] = $md5_senha_recebido = md5($senha_recebido);
/***
$sqlcmd = "SELECT * FROM  $banco_de_dados.usuario  "
        ." WHERE upper(usuario)=upper(\"$usuario_recebido\") and  "
        ." trim(senha)=trim('".$md5_senha_recebido."') ";            

***/
////  Verificando Usuario 
$sqlcmd = "SELECT * FROM  $banco_de_dados.usuario  "
        ." WHERE upper(usuario)=upper(\"$usuario_recebido\")  ";            

///
$sql_usu_senha = mysqli_query($_SESSION["bd_conectado"],$sqlcmd);
/// Verifica erro no Select/MySQL
if( ! $sql_usu_senha ) {
    $erro_usu_sen=1;
    echo "ERRO: db/mysql = ".mysqli_error($_SESSION["bd_conectado"]);
    exit();
}
///
/// Numero de registros
$nregs=mysqli_num_rows($sql_usu_senha);
if( intval($nregs)<1 ) {
    ///    $usuario_erro="Re-digite campo Usu&aacute;rio ou Senha";
    $usuario_erro=1;
    $erro_usu_sen=1;
} else {
    /// Verifica senha 
    /// $tb_senha=mysql_result($sql_usu_senha,0,1);
    ///
    $senha_array=null;
    while( $linha = mysqli_fetch_array($sql_usu_senha) ) {
        /// Varias linhas com apenas a coluna senha
         $senha_array[] .= $linha[1];
    }
    /// Verificar  o numero de registros da coluna senha  
    if( count($senha_array)>0 ) {
         /// Linha 1 valor
         $tb_senha = $senha_array[0];
    }
    /***
        Esquema da linha 0 com a coluna 2
        $row = mysqli_fetch_array($sql_usu_senha);
        $tb_senha= $row[1];
    ***/
    if( ! $tb_senha  ) {
        echo "ERRO: db/mysql = ".mysqli_error($_SESSION["bd_conectado"]);
        exit();
    }
    ///
    /// Verificando a senha do usuario
    if( trim($tb_senha)!=trim($_SESSION["us_ipid"]) ) {
           $erro_usu_sen=1;  
         ///  $senha_erro = "Re-digite campo Senha";
         
         $_SESSION['tmp']=" 1) \$tb_senha = $tb_senha   ---  2) \$_SESSION[us_ipid] = {$_SESSION["us_ipid"]}  ";
         

           $senha_erro = 1;                
    }
    ///
}                                                                                              
///
///  Verificase houve erro
if( intval($erro_usu_sen)<1 ) {
    $_SESSION['total']=1;
    $_SESSION["ini_menu"]="jogos_loterica.php";
    $banco_de_dados=$_SESSION["banco_de_dados"];
} else {
    $_SESSION['total']=0;       
}
///                                                                                       
?>
