<?php
//  AJAX da opcao REMOVER  - Servidor PHP para remover Usuário
//
//  LAFB110831.1740
#
ob_start(); /* Evitando warning */
//
///  Verificando se session_start - ativado ou desativado
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
///  header("content-type: application/x-javascript; charset=iso-8859-1");
///  header("Content-Type: text/html; charset=ISO-8859-1",true);
/// IMPORTANTE: para acentuacao php
header("Content-type: text/html; charset=utf-8");

///  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

//
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  
/* Exemplo do resultado  do  Permissao de Acesso - criando array
+-------------+--------+
| descricao   | codigo |
+-------------+--------+
| super       |      0 | 
| chefe       |     10 | 
| vice        |     15 | 
| aprovador   |     20 | 
| orientador  |     30 | 
| anotador    |     50 | 
+-------------+--------+
*/

///
$opcao = $_POST['grupous'];
///
///   Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///
$incluir_arq="";
if( isset($_SESSION["incluir_arq"]) ) {
    $incluir_arq=$_SESSION["incluir_arq"];  
} else {
     $msg_erro .= "Sessão incluir_arq não está ativa.".$msg_final;  
     echo $msg_erro;
     exit();
}
///
//// CONECTAR
$elemento=5; $elemento2=6;
include("php_include/ajax/includes/conectar.php");     
require_once('php_include/ajax/includes/tabela_pa.php');
if( isset($_SESSION["array_pa"]) ) $array_pa=$_SESSION["array_pa"];        
////
//  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
////      
$opcao_maiusc = strtoupper(trim($opcao));

///  Arquivo da tabela de consulta projeto - importante
$arq_tab_remove_usuario="{$incluir_arq}includes/tabela_de_remocao_usuario.php";
///
/// IMPORTANTE: para acentuacao MySql
mysql_set_charset('utf8');

///  UPLOAD -  do Servidor para maquina local
if( $opcao_maiusc=="DESCARREGAR" )  {
    // Define o tempo m?ximo de execu??o em 0 para as conex?es lentas
    set_time_limit(0);
    $post_array = array("grupous","val","m_array");
    for( $i=0; $i<count($post_array); $i++ ) {
        $xyz = $post_array[$i];
        //  Verificar strings com simbolos: # ou ,   para transformar em array PHP
        $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
        if ( isset($_POST[$xyz]) ) {
            $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
            if ( $pos1 === false ) {
                ///  $$xyz=trim($_POST[$xyz]);
                ///   Para acertar a acentuacao - utf8_encode
                $$xyz = utf8_decode(trim($_POST[$xyz])); 
            } else {
                 $$xyz = explode($div_array_por,$_POST[$xyz]);    
            }
        }
    }    
    // $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];
    $pasta = "../doctos_img/A".$m_array[0];
    $pasta .= "/".$m_array[1]."/";     
    //  $output = shell_exec('for arq in `ls '.$pasta.'/*.*`; do mv $arq `echo $arq | tr  [:upper:] [:lower:] `; done');    
    ///  $host  = "http://".$_SERVER['HTTP_HOST']; 
    $arquivo = trim($val);
    ///   
    if( ! file_exists("{$pasta}".$arquivo) ) {
         $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
         echo $msg_erro;  
    }  else {
        echo $pasta."%".$arquivo; 
    }  
    exit();     
} 
/// elseif( $opcao=="TODOS" ) {
////  Mostrar todas as anotacoes de um Projeto
/// if( $opcao_maiusc=="TODOS" or $opcao_maiusc=="BUSCA_PROJ" ) {
if( preg_match("/^TODOS|^BUSCA_PROJ|^BUSCA_LETRAI/i",$opcao_maiusc) ) {
    /////
   $_SESSION['table_rm_usu'] = "$bd_2.temp_remover_usuario";    
   $table_rm_usu=$_SESSION['table_rm_usu'];
   
   ///  Removendo a tabela temporaria
   $sql_rm_usu = "DROP TABLE IF EXISTS  $table_rm_usu  ";  
   $drop_res = mysql_query($sql_rm_usu); 
   if( ! $drop_res  ) {
        $msg_erro .= "Falha removendo a tabela $table_rm_usu -&nbsp;db/mysql:&nbsp;".mysql_error().$msg_final;  
        echo $msg_erro;
        exit();        
   }
   ////
   ///  Caso for uma letra somente
   ///  $testcase=trim($opcao);
   $dados=trim($opcao);   
   if( $opcao_maiusc=="BUSCA_LETRAI" ) {
      if( isset($val) ) {
          if( strlen(trim($val))==1 ) $dados=trim($val);
      }    
   } 
   ///
   ///  Usuario conectado - codigo
   ///  USUARIO CONECTADO - CODIGO USP
   if( ! isset($_SESSION["usuario_conectado"]) ) {
        $msg_erro .= "Sessão usuario_conectado não está ativa.".$msg_final;  
        echo $msg_erro;
        exit();
   }
   $usuario_conectado=$_SESSION["usuario_conectado"];
   ///
   $parte_login="";
   ///  Variavel alfabetica
   if( ctype_alpha($dados) ) {
         ////  if( strlen(trim($opcao))==1 ) {
         /// $letra=strtoupper(trim($opcao));
         ///  ALteradoe em 20180608
        ///         $parte_login=" WHERE a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$array_pa["aprovador"];           
         $parte_login=" WHERE a.codigousp=b.codigousp and a.pa=c.codigo and a.codigousp!=$usuario_conectado  ";           
         if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) ) {
               ///  Caso tenha escolhido uma Letra do Login/Usuario por EMAIL
                if( strlen($dados)>1) {
                       /// $letra_login=" upper(a.login) like '$letra%'  and  ";
                       //// $letra_login=" upper(b.e_mail) like '$letra%'  and  ";
                       $email=trim($opcao);
                       $parte_login=" WHERE a.codigousp=b.codigousp and a.pa=c.codigo and a.pa>".$array_pa["aprovador"];
                 }      
                 ///  Caso tenha escolhido uma Letra do Login/Usuario
                 if( strlen($dados)==1) {
                       /// ALterado em 20170609
                       if( strlen($dados)==1 ) {
                            $letra="$dados";
                       } elseif( strlen($opcao)==1 ) {
                             $letra=trim($opcao);  
                       }    
                       ///  $parte_login.=" and upper(nome) like '$letra%'   ";
                       $parte_login.=" and upper(b.nome) like '$letra%'   ";
                 }    
                 ///
           }
           ////
    } elseif( ctype_digit($dados) )  {
          ///  Variavel $opcao numerica
          $parte_login=" WHERE codigousp=$opcao   ";
    }
    ///  Caso variavel NULA
    if( strlen(trim($parte_login))<1 ) {
        ////  Caso variavel SEM SER  TODOS ou TODAS
         ////  Caso variavel SEM SER  TODOS ou TODAS
         if( ! preg_match("/TODOS|TODAS|ordenar/i",$dados) )  {
              $msg_erro .= "&nbsp;Falha grave na variavel".$msg_final;
              echo $msg_erro;  
              exit();          
         }     
    }   
    ///
   $_SESSION["selecionados"]="";
   /*** 
   *      Selecionar os usuarios de acordo com a opcao  
   *         -- aletrado em 20180608
   ***/
   ////  Criando a Tabela Temporaria para selecionar o usuario - remover
   $sqlcmd="CREATE TABLE  IF NOT EXISTS $table_rm_usu  ";
   $sqlcmd .= "SELECT a.codigousp as cod,b.nome,b.categoria,b.e_mail as E_Mail, "
           ."  c.descricao as cargo FROM $bd_1.usuario a, $bd_1.pessoa b, $bd_2.pa c "
           ." $parte_login  ";
    ///
   ///   MOstrar todos usuarios      
   ///  if( strtoupper($opcao)=="TODOS" ) {
   if( preg_match("/TODOS|TODAS|ordenar/i",$opcao) ) {
        $_SESSION["selecionados"] = " - <b>Total</b>";
        if( isset($m_array) ) {
            if( strlen(trim($m_array))>0 ) {
                 $m_array= trim($m_array);
                 $m_array=preg_replace("/login/i", "a.login", $m_array);             
                 $m_array=preg_replace("/nome/i", "b.nome", $m_array);             
                 # Replace with case insensitive matching           
                 $m_array = preg_replace('/^data\s+|^datavalido/i', 'a.datavalido', $m_array);
                 $sqlcmd .=" order by $m_array  "; 
            }  
        } else {
            //// $sqlcmd .=" order by c.codigo,b.nome  ";    
            $sqlcmd .=" order by nome  ";    
        }
   } else {
        ///  Mostrar apenas as pessoas selecionados pela Letra inicial
        $_SESSION["selecionados"] = "";        
        $sqlcmd .=" order by nome asc";
   }
   ///  Executando o procedimento
   $result_usuarios=mysql_query($sqlcmd);   
   
///  echo "ERRO: srv_removerusuario/213  --->>> \$sqlcmd  =  $sqlcmd  ";   
///  exit();
   
    ///  Caso ocorreu erro
    if( ! $result_usuarios ) {
          $msg_erro .= "Falha consultando as tabelas usuario, pessoa e pa - letra inicial.&nbsp;db/mysql:&nbsp;".mysql_error().$msg_final;  
          echo $msg_erro;
          exit();            
    }
    ///  Selecionando todos os registros da Tabela temporaria
   $query2 = "SELECT * from  $table_rm_usu  ";
   $resultado_outro = mysql_query($query2);                                    
   if( ! $resultado_outro ) {
        $msg_erro .= "Falha na Tabela Tempor&aacute;ria $table_rm_usu -&nbsp;db/mysql:&nbsp;".mysql_error().$msg_final;  
        echo $msg_erro;
        exit();            
   }        
   ////  Pegando os nomes dos campos do primeiro Select
   $num_fields=mysql_num_fields($resultado_outro);  ///  Obtem o numero de campos do resultado
   $td_menu = $num_fields+1;   
   //  Total de registros
   $_SESSION["total_regs"] = mysql_num_rows($resultado_outro);
   $total_regs=$_SESSION["total_regs"];
   if( intval($total_regs)<1 ) {
        $msg_erro .= "&nbsp;Nenhum Usu&aacute;rio encontrado".$msg_final;
        echo $msg_erro;
        exit();
   }   
   ////
   $_SESSION['total_regs']==1 ? $lista_usuario=" <b>1</b> usu&aacute;rio " : $lista_usuario="<b>$total_regs</b> usu&aacute;rios ";     
   /// $_SESSION["titulo"]= '<p class="titulo_consulta"  style="text-align: left; margin: 0px 0px 0px 4px; padding: 0px; "  >';
   $_SESSION["titulo"]= "<p class='titulo'  style='text-align: left; margin: 0px 0px 0px 4px; padding: 0px; line-height: normal; '  >";
   $_SESSION["titulo"].= "Lista de $lista_usuario </p>"; 
   //  Buscando a pagina para listar os registros        
   $_SESSION["num_rows"]=$_SESSION["total_regs"];  $_SESSION["name_c_id0"]="codigousp";    
   if( isset($titulo_pag) ) $_SESSION["ucfirst_data"]=$titulo_pag; 
   $_SESSION["pagina"]=0;
   //  $_SESSION["m_function"]="remove_anotacao" ;  $_SESSION["conjunto"]="Anotacao#@=".$usuario_conectado."#@=".$cip;
   $_SESSION["m_function"]="remove_usuario" ;  
   //  ANTES COM os simbolos ->   $_SESSION["conjunto"]="Usuario#@=";
   $_SESSION["conjunto"]="Usuario";
   //// $_SESSION["opcoes_lista"] = "../includes/tabela_de_remocao_usuario.php?pagina=";
   $_SESSION["opcoes_lista"] = "{$arq_tab_remove_usuario}?pagina=";
   //// require_once("../includes/tabela_de_remocao_usuario.php");                      
   require_once("{$arq_tab_remove_usuario}");                      
   ///
} elseif( $opcao_maiusc=='LISTA' ) {
    /*  Dados enviandos pelo arquivo pessoal_cadastrar.php 
         - javascript function consulta_mostrapes
    */
    /// Vericando - caso Variavel opcao para LISTA
    if( ! isset($dados) ) {
        if( isset($val) )  $dados=$val;
    }
    $_SESSION["pagina"]= (int) $dados;
    /// include("../includes/tabela_de_paginacao.php");                      
    /// include("{$incluir_arq}includes/tabela_de_paginacao.php");                      
    $_SESSION["opcoes_lista"] = "{$arq_tab_remove_usuario}?pagina=";
    /// require_once("../includes/tabela_de_consulta_usuarios.php");                      
    require_once("{$arq_tab_remove_usuario}");                      
    ///
} else if($opcao_maiusc=="REMOVER") {
     /*
         DECIDIR SE REMOVE USUARIO - SIM OU NAO 
     */
     $nerro=0;
     /// Caso variavel val ativa
     if( isset($val) ) {
         if( trim($val)=="" ) {
             $nerro=1;
         } else {
             $usuario_autor=trim($val);
             $cod_usuario=trim($val);
             ///   Com o codigo acrescentar o nome,e_mail e categoria
             $cmd_sql="select nome,e_mail,(select categoria.descricao from categoria where categoria.codigo=pessoa.categoria) as categoria_user from $bd_1.pessoa where codigousp=$cod_usuario ";
             $res_select = mysql_query($cmd_sql);                   
             if( ! $res_select ) {
                   ///  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
                   /*   $msg_erro .= "Selecionando o Projeto para ser removido - db/mysql: ".mysql_error().$msg_final;  
                      echo $msg_erro;  
                   */
                   echo $funcoes->mostra_msg_erro("Selecionando o cadastro do usuário&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());
                   exit();                   
             }
             ///  Verifica se foi encontrado o usuario na tabela
             $n_user=mysql_num_rows($res_select);
             if( intval($n_user)<1  ) {
                  echo $funcoes->mostra_msg_erro("Usuário não encontrado na Tabela&nbsp;-&nbsp;db/mysql:&nbsp;");
                  exit();                   
             }
             ///// 
             $e_mail_user=""; $categoria_user="";
             /// Nome do usuario para ser removido
             $_SESSION["nome_user"]=mysql_result($res_select,0,0);         
             $_SESSION["e_mail_user"] = $e_mail_user = mysql_result($res_select,0,1);         
             $categoria_user=mysql_result($res_select,0,2);         
             ///              
         }
     }
     ///  Nome do USUARIO
     $nome_user="";
     if( isset($_SESSION["nome_user"]) ) $nome_user=$_SESSION["nome_user"];
     ///
     ///  Caso houve erro
     if( intval($nerro)>0 ) {
        /*  $msg_erro .= "Falha na variavel: val ".$msg_final;  
        echo $msg_erro;  */
        echo $funcoes->mostra_msg_erro("&nbsp;Falha na variavel: val ");                
        exit();       
    }

    ///  Verificando a permissao de acesso do Usuario
    ///  para remover um Projeto
    $where_cond="";
    if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
        if( strlen(trim($numprojeto))>0 &&  strlen(trim($orientador))>0  ) {
             $where_cond="  numprojeto=$numprojeto and autor=$orientador  ";    
        }
    } else if( $_SESSION["permit_pa"]<$array_pa['orientador'] )  {
          ///  $where_cond="  cip=$cip ";
          $where_cond="  b.autor=$usuario_autor  and a.codigousp=$usuario_autor  ";
    }
    ///  FALHA CORRIGIR
    if( strlen(trim($where_cond))<1 ) {
         /*  $msg_erro .="SEM PERMISS&Atilde;O PARA EXCLUIR PROJETO".$msg_final;
         echo  $msg_erro;     */
         echo $funcoes->mostra_msg_erro("&nbsp;SEM PERMISS&Atilde;O PARA EXCLUIR PROJETO");
         exit();           
    }
    ///
    /// IMPORTANTE:  VERIFICANDO SE ESSE USUARIO TEM PROJETOS  
    //  SELECIONANDO os dados do Projeto/Anotacoes para serem removidos
    /***
    $sqlcmd = "SELECT a.codigousp,a.nome as autor_projeto_nome,b.cip,b.autor,b.fonterec,b.fonteprojid,"
                 ."b.numprojeto,b.titulo as titulo_projeto,b.anotacao,b.coresponsaveis,"
                 ."(Select count(cip) as n_projeto from $bd_2.projeto WHERE cip=$cip  ) as n_proj  , "
                 ."(Select count(autor) as n_anot from $bd_2.anotacao WHERE autor=$cip  ) as n_anot  "     
                 ."  FROM $bd_1.pessoa a, $bd_2.projeto b  WHERE {$where_cond} "; 
    ****/
    $sqlcmd = "SELECT a.codigousp,a.nome as autor_projeto_nome,b.cip,"
             ." b.autor,b.fonterec,b.fonteprojid, "
            ." b.numprojeto,b.titulo as titulo_projeto,b.anotacao,b.coresponsaveis, "
            ."(Select count(cip) as n_projeto from  rexp.projeto WHERE autor=$usuario_autor ) as n_proj, "
            ."(Select count(autor) as n_anot from rexp.anotacao WHERE autor=$usuario_autor  ) as n_anot "
            ." FROM  $bd_1.pessoa a, $bd_2.projeto b  WHERE {$where_cond} ";
    ////                 
    $result_projeto = mysql_query($sqlcmd);                   
    if( ! $result_projeto ) {
          ///  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
          /*   $msg_erro .= "Selecionando o Projeto para ser removido - db/mysql: ".mysql_error().$msg_final;  
           echo $msg_erro;  */
          echo $funcoes->mostra_msg_erro("Selecionando o Projeto para ser removido - db/mysql:&nbsp;".mysql_error());
          exit();                   
     }
     /***
               Parte pra enviar mensagem depois de remover Usuario
     ***/
     $aprovador_email="{$_SESSION["gemac"]}";
     ///
     ///  $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
    /***
         $host = $_SESSION["http_host"];
         $a_link = html_entity_decode($host);
     ***/
     ///  LINK do site do programa REXP
     if( ! isset($_SESSION["url_central"]) ) {
          echo $funcoes->mostra_msg_erro("SESSION url_central desativada. CORRIGIR");
          exit();                              
     }  
     ///
     $a_link = $_SESSION["url_central"];
     $cod_user=$cod_usuario;
     ///
     ///  Usuario/Participante sem projeto
     $assunto =html_entity_decode("RGE/SISTAM - Usuário/Participante removido.");
     $_SESSION["assunto"]=$assunto;
     $corpo ="RGE/SISTAM - Usuário/Participante <b>$nome_user</b> removido.<br>";
     $_SESSION["corpo"]=$corpo;
     ///
     /******  FINAL - Parte pra enviar mensagem depois de remover Usuario   ***/
     ///
     /***
            Numero de projetos desse usuario/anotador/participante
     ***/
     $n_projetos=mysql_num_rows($result_projeto);
     ///  Caso esse usuario/participante NAO tem projeto     
     if( intval($n_projetos)<1 )  {
         ///  Removendo USUARIO e etc...
         ///  Definindo SESSAO de erro
         $_SESSION["lnerro"]=0;
         ///
         /// Removendo USUARIO seus Projetos e Anotacoes
         include("removendo_usuario.php");
         ///
         $lnerro=$_SESSION["lnerro"];
         ///
         ///  Caso NAO  houve erro         
         if( intval($lnerro)<1 ) {
               /************************************************************
                  *    REMOVER O DIRETORIO DO USUARIO  - PRINCIPAL
                  * 
                  *    DIRETORIO DO USUARIO COM PROJETOS E ANOTACOES
               ************************************************************/
               $output = array();
               $return_var = -1;
               ///  Variavel para remover o diretorio do usuario/autor
               if( isset($dir_autor) ) {
                    if( strlen(trim($dir_autor))>0 ) {
                        $var_rmdir = "/bin/rm -rf ".$dir_autor;
                         /// 
                        ///  Verificando se existe a Pasta do usuario/autor
                        if( is_dir($dir_autor) ) {
                             ////  system($var_rmdir,$return_var);
                             exec($var_rmdir, $output,$return_var);
                             /// Verficando se houve erro
                        }
                    }
               }
               ///
               ///  $_SESSION["gemac"]="tiao3701f@genbov.fmrp.usp.br";
               ///  $aprovador_email="gemac@genbov.fmrp.usp.br";
               ///  Enviando email para o Administrador/Supervisor/Usuario
               ///  Incluindo arquivo para enviar mensagem/email
               $_SESSION["res_mail"]=FALSE;
               include("{$incluir_arq}remover/usuario_remover_mail.php");
               ///  Tempo de espera 2 segundos
               ///   sleep(2);
               
               ///   MENSAGEM FINAL - Projeto e Anotacoes - Removido
               $confirmar0 ="<hr>";
               $confirmar0 .="<p  class='titulo_usp' style='text-align:center;' >"
                                 ."Usuário/Participante <b>$nome_user</b> foi removido.<br/>"
                                 ."</p>";
               ///  Verificando retorno do envio de email para o Supervisor/Administrador
               ///  Mensagem para Tela
               if( isset($_SESSION["res_mail"]) ) {
                     $res_envio_email = $_SESSION["res_mail"];
               } else {
                     $res_envio_email = "<br/>ERRO: SESSION res_mail desativada. CORRIGIR<br/>";
               }           
               ///
               $confirmar0 .="$res_envio_email";
               echo $confirmar0;        
               ///  
         }
         ///           
         exit();
         ///  
     }  
     ///  FINAL -  removendo usuario SEM projeto
     ///
     //// Procurando campo CIP
     $num_cpos = mysql_num_fields($result_projeto);
     if( intval($num_cpos)==0 ) {
         /// Nenhum campo encontrado
         echo $funcoes->mostra_msg_erro("Número de campos das tableas não encontrados.");         
         exit();
     }
     ///    
    $fval = mysql_fetch_row($result_projeto);
    if( $fval===false) {
         /// Nenhum campo encontrado
         echo $funcoes->mostra_msg_erro("Comando mysql_fetch_row");         
         exit();
     } 
     ///     
    ///  Definindo variaves
    $cpo_cip=FALSE;
    
    ///  Verificando se existe campo cip e valor
    $msgerr= "ERRO: ";         
    for( $az=0; $az<$n_projetos; ++$az ) {
         $i=0; 
         while( $i<$num_cpos )  {
              $fname[$i] = mysql_field_name($result_projeto,$i);           
              $ret[$i] = $fval[$i];            /// enum
              $fname[$i]." = ".$ret[''.$fname[$i].'']=$fval[$i];    /// assoc
              ///
              if( $fname[$i]=="cip" ) {
                   $cpo_cip=TRUE;
                   $array_cip[]=mysql_result($result_projeto,$az,"cip");                  
                   $i=9999;
              }
              $i++;
         }
         /// 
    }
     ///  Cibferindo se cip NAO existe
     if( ! $cpo_cip ) {
         /****  CAMPO CIP  -  NAO ENCONTRADO    ***/
         echo $funcoes->mostra_msg_erro("Campo cip não existe.");         
         exit();
     } 
     ///
     if( isset($result_projeto) ) unset($result_projeto);     
     $autor_projeto_cod="";
     if( isset($autor) ) $autor_projeto_cod=$autor;
     ///
     $coresp_dados="";
     ///
     //  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
     if( isset($array_nome) ) unset($array_nome);
     $anotacoes="";
     ///
     ///   INICIANDO - REMOVENDO  nas pastas os Arquivos do Projeto e Anotacoes        
     ///    Alterado em 20170808
     if( isset($cod_usuario) ) $orientador=$cod_usuario; 
     if( ! isset($orientador) ) {
          echo $funcoes->mostra_msg_erro("Falha grave orientador/codigousp.");
          exit();                   
     }
     ///  CONVERTER array para string
     $string_cip=implode(",",$array_cip);
     ///
     ///  Caminho da pasta  para remover projetos
     ///  $dir_proj_total="../doctos_img/A".$orientador."/projeto/P".$numprojeto."_*";
     $dir_proj_total="{$incluir_arq}doctos_img/A".$orientador."/projeto";
     /// Verifica se o diretorio existe
     if( ! is_dir($dir_proj_total) ) {
          ///   Caso o diretorio NAO exista 
          echo $funcoes->mostra_msg_erro("Esse diretório $dir_proj_total não existe. Projeto");
          exit();                   
    }
    /*****        
           Verificando se o Diretorio do usuario existe - DIR principal
    ***/
    ///  $dir_autor="/var/www/html/rexp/doctos_img/A{$orientador}";
    ///  $dir_autor="/var/www/html/rexp_responsivo/doctos_img/A{$orientador}";
    $dir_autor="{$incluir_arq}doctos_img/A{$orientador}";
    if( ! is_dir($dir_autor) ) {
         ///   Caso o diretorio NAO exista 
         echo $funcoes->mostra_msg_erro("Esse diretório $dir_autor não existe. Principal do autor");
         exit();                   
    }
    ///
    $output_anot = null; $retorno_anot = -1;
    ///  $dir_anot="../doctos_img/A{$orientador}/anotacao/";
    $dir_anot="{$incluir_arq}doctos_img/A{$orientador}/anotacao/";
    ///   $dir_anota_total="{$incluir_arq}doctos_img/A".$orientador."/anotacao/P".$numprojeto."A*";
    /// if( ! is_dir($dir_anot) ) {
         ///   Caso o diretorio NAO exista 
    ///        echo $funcoes->mostra_msg_erro("Esse diretório $dir_anot não existe. Anotação");
       ///      exit();                   
    ///  }
    ///
    /// Endereco do Diretorio Local
    $diretorio = getcwd(); 
    // Abre o Diret?rio
    $ponteiro  = opendir($dir_autor);
    // Monta os vetores com os itens encontrados na pasta
    while( $nome_itens = readdir($ponteiro)) $itens[] = $nome_itens;
    // Ordena o vetor de itens
    sort($itens);
    // Percorre o vetor para fazer a separacao entre arquivos e pastas
    $contador_itens = count($itens);
    $pastas= array(); $arquivos=array();
    $dir_pontos = array('.','..'); 
    for( $i=0; $i<$contador_itens; $i++ ) {
          // retira "./" e "../" para que retorne apenas pastas e arquivos
          //  if( $listar!="." && $listar!="..") { 
          //  if( $itens[$i]!="." && $itens[$i]!="..") { 
          if( in_array(strtolower($itens[$i]),$dir_pontos) ) continue;
          // checa se o tipo de arquivo encontrado ? uma pasta                    
          //  $dir_autor_pasta=$dir_autor."/".$listar;
          $dir_autor_pasta=$dir_autor."/".$itens[$i];
          //  if( is_dir($listar) ) { 
          if( is_dir($dir_autor_pasta) ) { 
                // caso VERDADEIRO adiciona o item ? vari?vel de pastas
                 // $pastas[]=$itens[$i];    
                // abrindo um diretorio  = opendir(dir);
                $ponteiro  = opendir($dir_autor_pasta);
               // Monta os vetores com os itens encontrados na pasta
               while( $nome_itens = readdir($ponteiro) ) {
                      ///   $itens[] = $nome_itens;
                      $arquivos[]=$dir_autor_pasta."/".$nome_itens;   
               } 
          } 
         // }  IF era if( $itens[$i]!="." && $itens[$i]!="..") {  
    }
    ///
    $remover_arquivo=array();
    ///  Total de  dados no array
    $contador_itens=count($arquivos);  $n_anotacoes=0;
    $sizeof_array_cip=sizeof($array_cip); 
    for( $nacip=0; $nacip<$sizeof_array_cip; $nacip++  ) {
         ///  Valor de cada array cip
         $numprojeto=$array_cip[$nacip];
         for( $i=0; $i<$contador_itens; $i++ ) {
               /// if( $arquivos[$i]!="." && $arquivos[$i]!="..") { 
               if( in_array(strtolower($arquivos[$i]),$dir_pontos) ) continue;
               ///  Verificando um arquivo PROJETO
               $arq_projeto= "/\/P{$numprojeto}\_/";
               $res_proj=preg_match($arq_projeto,$arquivos[$i]);
               if( $res_proj )  $remover_arquivo[]=$arquivos[$i];
               //  Verificando os arquivos Anotacoes do PROJETO
               $arqs_anot="/\/P{$numprojeto}A([0-9]{1,10})/";
               $res_anot=preg_match($arqs_anot,$arquivos[$i]);
               if( $res_anot ) {
                   $remover_arquivo[]=$arquivos[$i];
                   $n_anotacoes++;   
               }
              /// 
         }       
    }
    ///    
    /// Numero de arquivos para Remover
    $num_arqs = count($remover_arquivo);   
    if( intval($num_arqs)>0 ) {
        foreach( $remover_arquivo as $chave_array => $valor_array ) {
             ///  Removendo um arquivo
             if( file_exists($valor_array) ) unlink($valor_array);        
        }       
    }
    ///  FINAL da  remocao dos arquivos Projeto e as anotacoes   
    /************************************************************
    *    REMOVER O DIRETORIO DO USUARIO  - PRINCIPAL
    * 
    *    DIRETORIO DO USUARIO COM PROJETOS E ANOTACOES
    **********************************************************/
    $output = array();
    $return_var = -1;
    $lnerros=0;
    ///  Verificando diretorio 
    if( isset($dir_autor) ) {
        if( strlen(trim($dir_autor))>0 ) {
            ///  Variavel para remover o diretorio do usuario/autor
            $var_rmdir = "/bin/rm -rf ".$dir_autor;
            /// 
            ///  Verificando se existe a Pasta do usuario/autor
            if( is_dir($dir_autor) ) {
                ////  system($var_rmdir,$return_var);
                exec($var_rmdir, $output,$return_var);
                /// Verficando se houve erro
            }
        } else {
            $lnerros=1;  
        }
    } else {
       $lnerros=1;
    }        
    ///  
    ///   Verificando se houve ERRO para remover diretorio do USUARIO/AUTOR -  Projetos
    if( intval($lnerros)>0 ) {
         ///   Caso o diretorio primcipal do usuario/autor  NAO exister para ser removido
         echo $funcoes->mostra_msg_erro("Esse diretório $dir_autor não existe.");
         exit();                   
    } 
    ///
    ///  Nome do Autor do Projeto   
    $autor_projeto_nome="";
    if( isset($nome_user) )  $autor_projeto_nome=$nome_user;
    ///
    ///  Definindo a variavel de erro
    $lnerro=0;
    ////  Selecionando as ANOTACOES de cada PROJETO do usuario/autor       
    $sqlcmd = "SELECT  count(cia) as ncia  FROM $bd_2.anotacao  "
                 ." WHERE projeto in(".$string_cip.")  ";                
    ///                 
    $resultado_anotacao = mysql_query($sqlcmd);
    if( ! $resultado_anotacao ) {
         /* $msg_erro .= "Selecionando Anota&ccedil;&otilde;es do Projeto: ".$numprojeto." - db/mysql - ".mysql_error();
              echo $msg_erro.$msg_final;  */
         echo $funcoes->mostra_msg_erro("Selecionando Anota&ccedil;&otilde;es dos Projetos&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());
         exit();
    }         
    ///  Verificando numero de anotacoes  
    $num_anotacoes=mysql_result($resultado_anotacao,0,0);   
    ///  Variavel de erro  
    $lnerro=0;
    ///  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    ///  Execute the queries          
    ///   mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
    mysql_query("LOCK TABLES $bd_2.anotacao DELETE, $bd_2.corespproj DELETE, $bd_2.projeto DELETE ");
    /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;         
    /***
         *   Removendo as anotacoes dos Projetos e do AUTOR/USUARIO
     ****/
    /// $sqlcmd= "DELETE  from $bd_2.anotacao WHERE autor=$cod_usuario "; 
    if( intval($num_anotacoes)>0  ) {
         $sqlcmd= "DELETE  from $bd_2.anotacao WHERE projeto in(".$string_cip.")  "; 
         ///                  
         $res_anotacao =mysql_query($sqlcmd);      
         if( ! $res_anotacao ) { 
             ///  mysql_error() - para saber o tipo do erro
             /* $msg_erro .="&nbsp;Removendo anota&ccedil;&atilde;o do Projeto da Tabela anotacao  - db/mysql:&nbsp; "
                               .mysql_error().$msg_final;
                  echo $msg_erro;  */                    
              echo $funcoes->mostra_msg_erro("&nbsp;Removendo anota&ccedil;&otilde;es do Projeto da Tabela anotacao&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());
             $lnerro=1;
         } else {
             ///  Confirmando processos - ok
             mysql_query('commit'); 
         }
    }               
    ////  Removendo os Projetos e co-reponsaveis do AUTOR/USUARIO
    if( intval($lnerro)<1 ) {
        ///  Removendo co-responsaveis dos projetos desse  AUTOR/USUARIO 
        $sqlcmd= "DELETE from $bd_2.corespproj WHERE projetoautor=$cod_usuario "; 
        ///                  
        $res_projeto =mysql_query($sqlcmd);      
        if( ! $res_projeto ) { 
             ///  mysql_error() - para saber o tipo do erro
             /* $msg_erro .="&nbsp;Removendo o Projeto $numprojeto do Autor $autor_projeto_nome  - db/mysql:&nbsp; "
                           .mysql_error().$msg_final;
                  echo $msg_erro;  */                           
              echo $funcoes->mostra_msg_erro("&nbsp;Removendo co-responsaveis dos projetos do Autor $autor_projeto_nome&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());                    
              $lnerro=1;
        }                               
        /// Desativando variavel res_projeto
        if( isset($res_projeto) ) unset($res_projeto);
        ///
        ///  $sqlcmd= "DELETE  from $bd_2.projeto WHERE {$where_cond} "; 
        $sqlcmd= "DELETE  from $bd_2.projeto WHERE autor=$cod_usuario "; 
        ///                  
        $res_projeto =mysql_query($sqlcmd);      
        if( ! $res_projeto ) { 
            ///  mysql_error() - para saber o tipo do erro
            /* $msg_erro .="&nbsp;Removendo o Projeto $numprojeto do Autor $autor_projeto_nome  - db/mysql:&nbsp; "
                           .mysql_error().$msg_final;
                  echo $msg_erro;  */                           
            echo $funcoes->mostra_msg_erro("&nbsp;Removendo projetos do Autor $autor_projeto_nome&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());                    
            $lnerro=1;
        }                               
    }    
    ///
    if( intval($lnerro)<1 ) {
         ///  Confirmando processos - ok
         mysql_query('commit'); 
    } else {
         ///  Caso ocorrido ERRO - cancelando
         mysql_query('rollback'); 
    }   
    ///
    /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
    mysql_query("UNLOCK  TABLES");
    ///  Complete the transaction 
    mysql_query('end'); 
    mysql_query('DELIMITER');         
    ///  FINAL - remover projetos e anotacoes do autor/usuario
    ///               
    ///  REMOVER anotador
    ///  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    ///  Execute the queries          
    ////  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
    mysql_query("LOCK TABLES  $bd_2.anotador DELETE ");
    /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;         
    ///  Removendo o anotador dos Projetos - usuario/anotador 
    ///  $sqlcmd = "DELETE from $bd_2.anotador  WHERE cip=$cip  ";
    $sqlcmd = "DELETE from $bd_2.anotador  WHERE codigo=$cod_usuario  ";
    ///                  
    $res_anotador =  mysql_query($sqlcmd);
    if( ! $res_anotador ) { 
         ///  mysql_error() - para saber o tipo do erro
         /*   $msg_erro .="&nbsp;Removendo anotador do Projeto da Tabela anotador - db/mysql:&nbsp; ".mysql_error().$msg_final;
               echo $msg_erro;   */           
         echo $funcoes->mostra_msg_erro("&nbsp;Removendo anotador $autor_projeto_nome da Tabela anotador&nbsp;-&nbsp;db/mysql:&nbsp;".mysql_error());                    
         $lnerro=1;        
    }       
    ///
    if( intval($lnerro)<1 ) {
         ///  Confirmando processos - ok
         mysql_query('commit'); 
    } else {
         ///  Caso ocorrido ERRO - cancelando
         mysql_query('rollback'); 
    }   
    ///
    /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
    mysql_query("UNLOCK  TABLES");
    ///  Complete the transaction 
    mysql_query('end'); 
    mysql_query('DELIMITER');         
    ///  
    ///   MENSAGEM FINAL - Projeto e Anotacoes - Removido
    ///  CASO ocorreu ERRO 
    if( intval($lnerro)>0  ) {
        exit();
    } 
    ///  Definindo SESSAO de erro
    $_SESSION["lnerro"]=0;
    ///
    /// Removendo USUARIO seus Projetos e Anotacoes
    include("removendo_usuario.php");
    ///
    $lnerro=$_SESSION["lnerro"];
    ///
    ///  CASO ocorreu ERRO depois do script  removendo_usuario.php 
    if( intval($lnerro)>0  ) {
        exit();
    } 
    ///
    ///  Enviando email para o Administrador/Supervisor/Usuario
    ///  Incluindo arquivo para enviar mensagem/email
    $_SESSION["res_mail"]="";
    include("{$incluir_arq}remover/usuario_remover_mail.php");
    /// Tempo de espera 2 segundos
    ///  sleep(2);
    ///
    $texto_complementar="";
    if( intval($n_projetos)==1 ) {
         $$texto_complementar=" e seu projeto";
    } elseif(intval($n_projetos)>1) {
         $$texto_complementar=" e seus projetos";
    }
    ///  Mensagem para Tela
    if( isset($_SESSION["res_mail"]) ) {
        $res_envio_email = $_SESSION["res_mail"];
    } else {
        $res_envio_email = "<br/>ERRO: SESSION res_mail desativada. CORRIGIR<br/>";
    }           
    ///
    echo $funcoes->mostra_msg_ok("<p class='titulo_usp' >O usuário $autor_projeto_nome foi removido$texto_complementar.&nbsp;$res_envio_email</p>");
      
   /*     FINAL - REMOVENDO UM PROJETO/ANOTACOES      */
   ///   
} else if( $opcao_maiusc=="REMOVER_ACEITO" ) {
     /*
          ACEITOU REMOVER USUARIO 
     */
     $nerro=0;
     if( isset($val) ) {
         if( trim($val)=="" ) {
             $nerro=1;
         } else {
             $usuario_autor=trim($val);
         }
     }
     ///  Caso houve erro
     if( intval($nerro)>0 ) {
        /*  $msg_erro .= "Falha na variavel: val ".$msg_final;  
        echo $msg_erro;  */
        echo $funcoes->mostra_msg_erro("&nbsp;Falha na variavel: val ");                
        exit();       
    }
    ///  Verificando se esse usuario tem projetos
    //  SELECIONANDO os dados do Projeto/Anotacoes para serem removidos
   /***
    $sqlcmd = "SELECT a.codigousp,a.nome as autor_projeto_nome,b.cip,b.autor,b.fonterec,b.fonteprojid,"
                 ."b.numprojeto,b.titulo as titulo_projeto,b.anotacao,b.coresponsaveis,"
                 ."concat(substr(datainicio,9,2),'/',substr(datainicio,6,2),'/',substr(datainicio,1,4)) as data_inicio_projeto , "
                 ."(Select count(cip) as n_anot from $bd_2.anotador where cip=$cip  ) as n_anot  "     
                 ."  FROM $bd_1.pessoa a, $bd_2.projeto b  WHERE {$where_cond} "; 
    ***/                 
    ///                 
    ///  Verificando a permissao de acesso do Usuario
    ///   para remover um Projeto
    $where_cond="";
    if( $_SESSION["permit_pa"]==$array_pa['orientador'] )  {
         $where_cond="  numprojeto=$numprojeto and autor=$orientador  ";
    } else if( $_SESSION["permit_pa"]<$array_pa['orientador'] )  {
         $where_cond="  cip=$cip ";
    }  else {
         /*  $msg_erro .="SEM PERMISS&Atilde;O PARA EXCLUIR PROJETO".$msg_final;
         echo  $msg_erro;     */
         echo $funcoes->mostra_msg_erro("&nbsp;SEM PERMISS&Atilde;O PARA EXCLUIR PROJETO");   
         exit();           
    }
    ///
    ///  SELECIONANDO os dados do Projeto/Anotacoes para serem removidos
    $sqlcmd = "SELECT a.codigousp,a.nome as autor_projeto_nome,b.cip,b.autor,b.fonterec,b.fonteprojid,"
                 ."b.numprojeto,b.titulo as titulo_projeto,b.anotacao,b.coresponsaveis,"
                 ."concat(substr(datainicio,9,2),'/',substr(datainicio,6,2),'/',substr(datainicio,1,4)) as data_inicio_projeto , "
                 ."(Select count(cip) as n_anot from $bd_2.anotador where cip=$cip  ) as n_anot  "     
                 ."  FROM $bd_1.pessoa a, $bd_2.projeto b  WHERE {$where_cond} "; 
    ////                 
    $result_projeto = mysql_query($sqlcmd);                   
    if( ! $result_projeto ) {
     ///  die('ERRO: Selecionando os projetos autorizados para esse Usu&aacute;rio: '.mysql_error());  
         /*   $msg_erro .= "Selecionando o Projeto para ser removido - db/mysql: ".mysql_error().$msg_final;  
         echo $msg_erro;  */
         echo $funcoes->mostra_msg_erro("Selecionando o Projeto para ser removido - db/mysql:&nbsp; ".mysql_error());
         exit();                   
     }
     ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array - IMPORTANTE
     $array_projeto_cpos=mysql_fetch_array($result_projeto);
     foreach( $array_projeto_cpos as $chave_proj => $valor_proj ) {
              $$chave_proj=$valor_proj;
     }                  
     if( isset($result_projeto) )  unset($result_projeto);     
     $autor_projeto_cod="";
     if( isset($autor) ) $autor_projeto_cod=$autor;
     ///
     $coresp_dados="";
     if( intval($coresponsaveis)>=1 ) {
          if( $coresponsaveis==1 ) $tit_coresp="Corespons&aacute;vel";
          if( $coresponsaveis>1 ) $tit_coresp="Corespons&aacute;veis";
          /// Precisa iniciar zerando variavel @contador_regs
          $result_set=mysql_query("set @contador_regs=0;");
          if( ! $result_set ) {
              /* $msg_erro .= "set @contador_regs=0; -  db/mysql:  ".mysql_error().$msg_final;            
              echo  $msg_erro;  */
              echo $funcoes->mostra_msg_erro("set @contador_regs=0; -&nbsp;db/mysql:&nbsp;".mysql_error());
              exit();
          }         
          $result_coresp=mysql_query("SELECT @contador_regs:=@contador_regs+1 as n, "
                   ." b.nome as coresponsavel_nome FROM $bd_2.corespproj  a, "
                   ." $bd_1.pessoa b  WHERE a.projetoautor=$autor_projeto_cod and a.projnum=$numprojeto and "
                   ." b.codigousp=a.coresponsavel order by b.nome ");
          ///         
          if( ! $result_coresp ) {
               /* $msg_erro .= "Select tabelas corespproj e pessoa -  db/mysql:  ".mysql_error().$msg_final;            
              echo  $msg_erro;  */              
               echo $funcoes->mostra_msg_erro("Select Tabelas corespproj e pessoa -&nbsp;db/mysql:&nbsp;".mysql_error());              
               exit();
          }         
          $coresp_dados .="<div style='text-align:center;font-size: medium; overflow: auto;'>";
          $coresp_dados .="<p style='text-align:center;font-size: medium;'>"
                        ."<b>$tit_coresp:</b></p>";                              
          $nregs_coresp = mysql_num_rows($result_coresp);
          for( $nc=0; $nc<$nregs_coresp; $nc++ ) {
              //  $n=mysql_result($result_coresp,$nc,"n");
              $n=$nc+1;
              $coresponsavel_nome=mysql_result($result_coresp,$nc,"coresponsavel_nome");
              $coresp_dados .="<span style='text-align:center;font-size: medium;'>"
                     ."$n)&nbsp;$coresponsavel_nome</span><br>";                                              
          }                           
          $coresp_dados .="</div>";                        
    } 
    /// Final do IF( $coresponsaveis>=1 ) { 
    ///  Selecionando as ANOTACOES do PROJETO        
    $sqlcmd = "SELECT  a.numero as numero_anotacao, a.titulo as titulo_anotacao,  "
                 ." concat(substr(a.data,9,2),'/',substr(a.data,6,2),'/',substr(a.data,1,4)) as data_anotacao "
                 ." FROM $bd_2.anotacao a, $bd_1.pessoa b "
                 ." WHERE a.autor=b.codigousp and a.projeto=$cip  ";   
    ///                         
    $resultado_anotacao = mysql_query($sqlcmd);
    if( ! $resultado_anotacao ) {
          /* $msg_erro .= "Selecionando Anota&ccedil;&otilde;es do Projeto: ".$numprojeto." - db/mysql - ".mysql_error();
        echo $msg_erro.$msg_final;  */
          echo $funcoes->mostra_msg_erro("Selecionando Anota&ccedil;&otilde;es do Projeto: {$numprojeto} - db/mysql:&nbsp; ".mysql_error());
          exit();
    }         
    ///    
    ///  Definindo os nomes dos campos recebidos do MYSQL SELECT - mysql_fetch_array
    if( isset($array_nome) ) unset($array_nome);
    $num_anotacoes = mysql_num_rows($resultado_anotacao);
    $anotacoes="";
    ////
    if( intval($num_anotacoes)>=1  ) {
         $anotacoes ="<div style='width: 100%; overflow: auto;'  >";
         /*  Mostra Anotacao por Anotacao - Desativado
          while( $reg_anot=mysql_fetch_array($resultado_anotacao) ) {
              // Anotacao do Projeto                            
              $anotacoes .="<p style='text-align:center;font-size: medium;'>"
                 ."<b>Anota&ccedil;&atilde;o</b>:&nbsp;".$reg_anot['numero_anotacao']."&nbsp;-&nbsp;"
                 ."<b>Data da Anota&ccedil;&atilde;o</b>:&nbsp;".$reg_anot['data_anotacao']."</p>";
              $anotacoes .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo da Anota&ccedil;&atilde;o</b>:<br>"                
                 .$reg_anot['titulo_anotacao']."</div>";                                     
          }
          */
          $anotacoes .="<p style='text-align:center;font-size: medium;'>";
          $anotacoes .="Total de Anota&ccedil;&otilde;es desse Projeto:&nbsp;".$num_anotacoes."</p>";
          $anotacoes .="</div>" ;
          $texto_anotacoes="";
          if( $num_anotacoes==1 ) $texto_anotacoes="&nbsp;e Anota&ccedil;&atilde;o";
          if( $num_anotacoes>1 ) $texto_anotacoes="&nbsp;e Anota&ccedil;&otilde;es";
          
    }  
    ///  FINAL - Selecionando os dados do Projeto
    ///
    ///   INICIANDO - REMOVENDO  nas pastas os Arquivos do Projeto e Anotacoes        
    ///
    $dir_proj_total="../doctos_img/A".$orientador."/projeto/P".$numprojeto."_*";
    $dir_autor="/var/www/html/rexp/doctos_img/A{$orientador}";
    $output_anot = null; $retorno_anot = -1;
    $dir_anot="../doctos_img/A{$orientador}/anotacao/";
    $dir_anota_total="../doctos_img/A".$orientador."/anotacao/P".$numprojeto."A*";
    // Endere?o do Diret?rio Local
    $diretorio = getcwd(); 
    // Abre o Diret?rio
    $ponteiro  = opendir($dir_autor);
    // Monta os vetores com os itens encontrados na pasta
    while( $nome_itens = readdir($ponteiro)) $itens[] = $nome_itens;
    // Ordena o vetor de itens
    sort($itens);
    // Percorre o vetor para fazer a separacao entre arquivos e pastas
    $contador_itens = count($itens);
    $pastas= array(); $arquivos=array();
    $dir_pontos = array('.','..'); 
    for( $i=0; $i<$contador_itens; $i++ ) {
          // retira "./" e "../" para que retorne apenas pastas e arquivos
          //  if( $listar!="." && $listar!="..") { 
          //  if( $itens[$i]!="." && $itens[$i]!="..") { 
          if( in_array(strtolower($itens[$i]),$dir_pontos) ) continue;
          // checa se o tipo de arquivo encontrado ? uma pasta                    
          //  $dir_autor_pasta=$dir_autor."/".$listar;
          $dir_autor_pasta=$dir_autor."/".$itens[$i];
          //  if( is_dir($listar) ) { 
          if( is_dir($dir_autor_pasta) ) { 
                // caso VERDADEIRO adiciona o item ? vari?vel de pastas
                 // $pastas[]=$itens[$i];    
                // abrindo um diretorio  = opendir(dir);
                $ponteiro  = opendir($dir_autor_pasta);
               // Monta os vetores com os itens encontrados na pasta
               while( $nome_itens = readdir($ponteiro) ) {
                      ///   $itens[] = $nome_itens;
                      $arquivos[]=$dir_autor_pasta."/".$nome_itens;   
               } 
          } 
         // }  IF era if( $itens[$i]!="." && $itens[$i]!="..") {  
    }
    ///
    $remover_arquivo=array();
    ///  Total de  dados no array
    $contador_itens=count($arquivos);  $n_anotacoes=0;
    for( $i=0; $i<$contador_itens; $i++ ) {
           // if( $arquivos[$i]!="." && $arquivos[$i]!="..") { 
           if( in_array(strtolower($arquivos[$i]),$dir_pontos) ) continue;
           //  Verificando um arquivo PROJETO
           $arq_projeto= "/\/P{$numprojeto}\_/";
           $res_proj=preg_match($arq_projeto,$arquivos[$i]);
           if( $res_proj )  $remover_arquivo[]=$arquivos[$i];
           //  Verificando os arquivos Anotacoes do PROJETO
           $arqs_anot="/\/P{$numprojeto}A([0-9]{1,10})/";
           $res_anot=preg_match($arqs_anot,$arquivos[$i]);
           if( $res_anot ) {
               $remover_arquivo[]=$arquivos[$i];
               $n_anotacoes++;   
           }
          // }  IF era  if( $arquivos[$i]!="." && $arquivos[$i]!="..") { 
    }       
    /// Numero de arquivos para Remover
    $num_arqs = count($remover_arquivo);   
    if( $num_arqs>0 ) {
        foreach( $remover_arquivo as $chave_array => $valor_array ) {
             //  Removendo um arquivo
             if( file_exists($valor_array) )  unlink($valor_array);        
        }       
    }
    ///  FINAL da  remocao dos arquivos Projeto e as anotacoes   
    ///  Nome do Autor do Projeto   
    $autor_projeto_nome="";
    if( isset($_SESSION["autor_projeto_nome"]) ) {
          $autor_projeto_nome=$_SESSION["autor_projeto_nome"];  
    } 
    ///
    $lnerro=0;
    ///  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    ///  Execute the queries          
    ////  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
    mysql_query("LOCK TABLES $bd_2.projeto  DELETE, $bd_2.anotacao DELETE,  $bd_2.anotador DELETE ");
    /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;         
    ///  Removendo o anotador do Projeto  
    $sqlcmd = "DELETE from $bd_2.anotador  WHERE cip=$cip  ";
    ///                  
    $res_anotador =  mysql_query($sqlcmd);
    if( $res_anotador ) { 
        ///  Removendo as anotacoes do Projeto
        if( $n_anotacoes>0 ) {
             $sqlcmd= "DELETE  from $bd_2.anotacao WHERE projeto=$cip "; 
             ///                  
             $res_anotacao =mysql_query($sqlcmd);      
             if( ! $res_anotacao ) { 
                 ///  mysql_error() - para saber o tipo do erro
                 /* $msg_erro .="&nbsp;Removendo anota&ccedil;&atilde;o do Projeto da Tabela anotacao  - db/mysql:&nbsp; "
                               .mysql_error().$msg_final;
                    echo $msg_erro;  */                    
                  echo $funcoes->mostra_msg_erro("&nbsp;Removendo anota&ccedil;&atilde;o do Projeto da Tabela anotacao  - db/mysql:&nbsp;".mysql_error());
                   $lnerro=1;
             }                
        }
        ///  Removendo o Projeto
        if( intval($lnerro)<1 ) {
             $sqlcmd= "DELETE  from $bd_2.projeto WHERE {$where_cond} "; 
             ///                  
             $res_projeto =mysql_query($sqlcmd);      
             if( ! $res_projeto ) { 
                 ///  mysql_error() - para saber o tipo do erro
                 /* $msg_erro .="&nbsp;Removendo o Projeto $numprojeto do Autor $autor_projeto_nome  - db/mysql:&nbsp; "
                               .mysql_error().$msg_final;
                    echo $msg_erro;  */                           
                 echo $funcoes->mostra_msg_erro("&nbsp;Removendo o Projeto $numprojeto do Autor $autor_projeto_nome  - db/mysql:&nbsp; ".mysql_error());                    
                 $lnerro=1;
             }                               
        }    
        ///
    } else { 
        ///  mysql_error() - para saber o tipo do erro
        /* $msg_erro .="&nbsp;Removendo anotador do Projeto da Tabela anotador - db/mysql:&nbsp; ".mysql_error().$msg_final;
              echo $msg_erro; */           
        echo $funcoes->mostra_msg_erro("&nbsp;Removendo anotador do Projeto $numprojeto da Tabela anotador - db/mysql:&nbsp; ".mysql_error());                    
        $lnerro=1;        
    }       
    ///
    if( intval($lnerro)<1 ) {
         mysql_query('commit'); 
    } else {
        mysql_query('rollback'); 
    }   
    ///
    /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
    mysql_query("UNLOCK  TABLES");
    ///  Complete the transaction 
    mysql_query('end'); 
    mysql_query('DELIMITER');         
    ///  Caso Tabela acima foi aceita incluir dados na outra abaixo
    ///   MENSAGEM FINAL - Projeto e Anotacoes - Removido
    $confirmar0 ="<hr>";
    $confirmar0 .="<p class='titulo_usp' style='text-align:center;' >"
                     ."<b>Projeto $numprojeto foi removido{$texto_anotacoes}.</b><br>"
                     ."<b>Autor do Projeto</b>: $autor_projeto_nome</p>";
    $confirmar0 .="<div style='text-align:center;font-size: medium; overflow: auto;'>"
                 ."<b>T&iacute;tulo do Projeto</b>:<br>"                
                 ."$titulo_projeto </div>";
    $confirmar0 .="<p style='text-align:center;font-size: medium;'>"
                    ."<b>Data in&iacute;cio do Projeto</b>:&nbsp;$data_inicio_projeto </p>";
    $confirmar0 .=$coresp_dados;
    $confirmar0 .=$anotacoes;                   
    $confirmar1 =$confirmar0."<br>";
    $confirmar1 .="<div style='width: 100%; text-align: center;'>";                                         
    $confirmar1 .="<button class='botao3d_menu_vert'  style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: reiniciar_pagina();' >Retornar";                                  
    $confirmar1 .="</button></div>";                                         
    echo $confirmar1;               

     /*  FINAL - REMOVENDO UM PROJETO/ANOTACOES   */
     ///   
}
///
#
ob_end_flush(); 
#
?>