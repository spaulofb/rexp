<?php
//   Arquivo para CADASTRAR 
//
//  Funcao para busca com acentos
function stringParaBusca($str) {
    //Transformando tudo em min?sculas
    $str = trim(strtolower($str));

    //Tirando espa?os extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
    while ( strpos($str,"  ") )
        $str = str_replace("  "," ",$str);
    
    //Agora, vamos trocar os caracteres perigosos "?,?..." por coisas limpas "a"
    $caracteresPerigosos = array ("?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","!","?",",","?","?","-","\"","\\","/");
    $caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
    $str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
    
    //Agora que não temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
    //vamos montar a express?o regular para o MySQL
    $caractresSimples = array("a","e","i","o","u","c");
    $caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
    $str = str_replace($caractresSimples,$caractresEnvelopados,$str);
    $caracteresParaRegExp = array(
        "(a|?|?|?|?|?|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|?|?|?|?|?|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
        "(e|?|?|?|?|&eacute;|&egrave;|&euml;|&ecirc;|?|?|?|?|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
        "(i|?|?|?|?|&iacute;|&igrave;|&iuml;|&icirc;|?|?|?|?|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
        "(o|?|?|?|?|?|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|?|?|?|?|?|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
        "(u|?|?|?|?|&uacute;|&ugrave;|&uuml;|&ucirc;|?|?|?|?|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
        "(c|?|?|&ccedil;|&Ccedil;)" );
    $str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
    
    //Trocando espa?os por .*
    $str = str_replace(" ",".*",$str);
    
    //Retornando a String finalizada!
    return $str;
}
//
//  Funcao para minuscula para Maiuscula
function stringParaBusca2($str) {
 /*
     $a1 ="????????????????????????????";
     $a1_len = strlen($a1);
     $a2 ="????????????????????????????";
     //  $pessoa_nome2=trim($pessoa_nome);
    for( $i=0; $i<$a1_len; $i++ ) {
          $char1[]=substr($a1,$i,1);
            $char2[]=substr($a2,$i,1);
    }
    $m_count = count($char1);
    $texto=$str;
    for( $x=0; $x<$m_count ; $x++ ) {
        //   $str = str_replace($char1[$x],$char2[$x],$str);
         // First check if there is a "5" at position 0.
        $offset = 0; // initial offset is 0
        $fiveCounter = 0;
        if( strpos($str, $char1[$x])==0 ) continue;

       // Check the rest of the string for 5's
       while( $offset=strpos($str, $char1[$x],$offset+1) ) {
           $texto=substr_replace($texto,$char2[$x],$offset,1); 
           $chars .=  $char1[$x]." - ";        
       }
     //     $str = str_replace($char1,$char2,$str);
        //  $texto .= "<br>  - $str ".$char1." - ".$char2;
    
    
    }
  */
    //  Usar para substituir caracteres com acentos para Maiuscula
   $substituir = array(
                        '/&aacute;/i' => '?',
                        '/&Eacute;/i' => '?',
                        '/&Iacute;/i' => '?',
                        '/&Oacute;/i' => '?',
                        '/&Uacute;/i' => '?',
                        '/&Atilde;/i' => '?',
                        '/&Otilde;/i' => '?',
                        '/&Acirc;/i' => '?',
                        '/&Ecirc;/i' => '?',
                        '/&Icirc;/i' => '?',
                        '/&Ocirc;/i' => '?',
                        '/&Ucirc;/i' => '?',
                        '/&Ccedil;/i' => '?',
                        '/&Agrave;/i' => '?'
                        );
    
    
    
    //  $texto =strtoupper($str);
   $substituir0 = array(
                        '/?/' => '&aacute;',
                        '/?/' => '&eacute;',
                        '/?/' => '&iacute;',
                        '/?/' => '&oacute;',
                        '/?/' => '&uacute;',
                        '/?/' => '&atilde;',
                        '/?/' => '&otilde;',
                        '/?/' => '&acirc;',
                        '/?/' => '&ecirc;',
                        '/?/' => '&icirc;',
                        '/?/' => '&ocirc;',
                        '/?/' => '&ucirc;',
                        '/?/' => '&ccedil;',
                        '/?/' => '&Aacute;',
                        '/?/' => '&Eacute;',
                        '/?/' => '&Iacute;',
                        '/?/' => '&Oacute;',
                        '/?/' => '&Uacute;',
                        '/?/' => '&Atilde;',
                        '/?/' => '&Otilde;',
                        '/?/' => '&Acirc;',
                        '/?/' => '&Ecirc;',
                        '/?/' => '&Icirc;',
                        '/?/' => '&Ocirc;',
                        '/?/' => '&Ucirc;',
                        '/?/' => '&Ccedil;',
                        '/?/' => '&agrave;',
                        '/?/' => '&Agrave;'
                        );

/*
    $substituir2 = array('/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',
                        '/?/' => '?',                        
                        '/?/' => '?',                        
                        '/?/' => '?',                                                
                        '/?/' => '?',                                                                        
                        '/?/' => '?',                                                                                                
                        '/?/' => '?'
                    );
                    */
                    
        $substituir2 = array('?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',
                        '?' => '?',                        
                        '?' => '?',                        
                        '?' => '?',                                                
                        '?' => '?',                                                                        
                        '?' => '?',                                                                                                
                        '?' => '?'
                    );
                    
                        
  // $texto = preg_replace(array_keys($substituir2),array_values($substituir2),$str);
   $texto =  preg_replace(array_keys($substituir),array_values($substituir),$str);

    return $texto;
    
}

ob_start(); /* Evitando warning */
//  Verificando se session_start - ativado ou desativado
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
//   Colocar as datas do Cadastro do Usuario e a validade
date_default_timezone_set('America/Sao_Paulo');

//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");

//
// extract: Importa vari?veis para a tabela de s?mbolos a partir de um array 
extract($_POST, EXTR_OVERWRITE);  

$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";

///  Conjunto de arrays 
include_once("../includes/array_menu.php");

/// Conjunto de Functions
require_once("../includes/functions.php");    

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
	   } else  $$xyz = explode($div_array_por,$_POST[$xyz]);
	}
}
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source);
$source_upper=strtoupper($_SESSION["source"]);


if( $source_upper=="SAIR" ) {
    // Eliminar todas as variaveis de sessions
    $_SESSION = array();

    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($login_down) ) unset($login_down); 
    if( isset($senha_down) )  unset($senha_down); 
	//
	//  echo  "<a href='http://www-gen.fmrp.usp.br'  title='Sair' >Sair</a>";
    response.setHeader("Pragma", "no-cache"); 
    response.setHeader("Cache-Control", "no-cache"); 
    response.setDateHeader("Expires",0); 
	//  echo  "http://www-gen.fmrp.usp.br/";
	exit();
}
//
if( $source_upper=="PARTICIPANTE" ) {  //  Selecionando Participante do Projeto e o e_mail
     $elemento=5;
     include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    $res_pessoa=mysql_query("SELECT  e_mail FROM $bd_1.pessoa WHERE  codigousp=".$val);
    //                          
    if( ! $res_pessoa ) {
         mysql_free_result($res_pessoa);
         die('ERRO: Selecionando Participante - falha: '.mysql_error());  
    }
    $n_regs=mysql_num_rows($res_pessoa);
    if( $n_regs<1  ) {
        $msg_erro .="Nenhum encontrado";
        echo $msg_erro; 
    } else {
       $partes = mysql_result($res_pessoa,0,"e_mail")."#";    
       mysql_free_result($res_pessoa);
       $sqlcmd = "SELECT senha as senha_usu, pa as pa_usu, aprovado as aprovado_usu "
             ." FROM $bd_1.usuario where codigousp=$val ";
       $resultado_usuario=mysql_query($sqlcmd);                       
       $n_usu = mysql_num_rows($resultado_usuario);
       $aprovado_usu=9;
       if( $n_usu<1  ) {
          $partes .="block"; 
       } else $partes .="none"; 
       echo $partes;
       mysql_free_result($resultado_usuario);
    } 
} else if( $source_upper=="GERAR_SENHA" ) {  //  Gerar Senha para o Participante
     $elemento=5;
     include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
     include("../includes/gerar_senha.php");
     //  Criando nova Senha
     $new_pwd = GenPwd();
     $pwd_reset = trim($new_pwd);
     echo $pwd_reset;
} elseif( $source_upper=="CONJUNTO" )  {  //  Instituicao, Unidade e demais
     // PARTE PARA MUDANCA DE CAMPO - IMPORTANTE
	 $n_cpo = (int) $n_cpo; $cpo_final = (int) $cpo_final;
	 if( ! is_array($m_array) ) $m_array  = explode(",",$m_array);
	 if( $n_cpo<=$cpo_final ) { //  Inicio do IF principal
	     $cpo_where = $m_array[0];
		 //  $pos_encontrada = array_search($cpo_where,$m_array);
		 //  Definindo a posicao para o proximo campo 
         $_SESSION[key]++;		 
		 $total_array=sizeof($m_array);
		 for( $j=1; $j<=$total_array; $j++ ) {
		     if( $cpo_where==$m_array[$j] )  $i=$j+1; 
		 }
		 if( strtoupper($cpo_where)=="INSTITUICAO" ) {
		      $i=2;  unset($_SESSION[campos_dados1]);
			  unset($_SESSION[campos_dados2]);
              $_SESSION[key]=0;			  
		 } else {
			 //  Verifica se esse campo ja foi selecionado no array
			 //  remover o anterior
			 if( $_SESSION[campos_dados1] ) {
			      $total = sizeof($_SESSION[campos_dados1]); 
			      for( $ver=0; $ver<$total ; $ver++ ) {
				      if( $cpo_where==$_SESSION[campos_dados1][$ver] or $j<$total  ) {
					       $_SESSION["key"]=$ver;  // Importante depois de achar duplicata
					       for( $ver; $ver<$total ; $ver++ ) {
						        unset($_SESSION[campos_dados1][$ver]);
						        unset($_SESSION[campos_dados2][$ver]);		
						   }							   
					  }  
				  }
			 }
		 }
		 //
         $table_atual = $m_array[$i]; $upper_val=strtoupper($val);
         $_SESSION[select_cpo]="sigla";
		 $array2 = array("bloco","salatipo","sala");
		 //  Precisava passar a variavel 
		 if( strtoupper($cpo_where)=="SALA" ) $table_atual="sala";	
		 $chave = $_SESSION[key];
	     $_SESSION[campos_dados1][$chave]=$cpo_where;
         $_SESSION[campos_dados2][$chave]=$val;
		 //  
		//  Precisava passar a variavel 
		if( strtoupper($table_atual)=="BLOCO" || strtoupper($table_atual)=="SALATIPO" || strtoupper($table_atual)=="SALA" ){ 		       //  Mudando a variavel - $table_atual
		        $_SESSION["select_cpo"]=$table_atual;  $table_atual="bem"; 
		} 						
		$_SESSION[where]="";			
		$total_arrays = sizeof($_SESSION[campos_dados1]);		
		for( $row = 0; $row < $total_arrays; $row++) {
		     $_SESSION["where"].= " upper(trim(".$_SESSION[campos_dados1][$row]."))=";
			 $p2 = $_SESSION[campos_dados2][$row];
			 $p2 = trim(urldecode($p2));
			 $_SESSION[where].=  " \"$p2\" ";
			 if( $row<($total_arrays-1) ) $_SESSION[where].=  " and ";
		}
	    // Selecionando campo 	
       $elemento=3;
       include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");	
	   $tabs_sig_nome= array("instituicao","unidade","depto","setor");			    
	   $nome_cpo="";
	   if( in_array($table_atual,$tabs_sig_nome) ) $nome_cpo="nome,";
      //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
 	   $result=mysql_query("SELECT ".$_SESSION["select_cpo"].", $nome_cpo count(*) FROM "
    			         ." $table_atual where ".$_SESSION["where"]."  group by 1 order by  ".$_SESSION["select_cpo"]);
		//
		if( strtoupper($table_atual)=="BEM"  )   $table_atual=$_SESSION["select_cpo"]; 
  	    if( ! $result ) {
		       die('ERRO: Select - falha: '.mysql_error());
		   	   exit();
		}
        $m_linhas = mysql_num_rows($result);
		//
		$_SESSION["table_atual"]=$table_atual;
		$cp_table_atual=$table_atual; $cp_cpo_where=$cpo_where;
		if( strtoupper($cp_table_atual)=="INSTITUICAO" ) $cp_table_atual="institui??o";
		if( strtoupper($cp_cpo_where)=="INSTITUICAO" ) $cp_cpo_where="institui??o";
		if( strtoupper($cp_table_atual)=="DEPTO" ) $cp_table_atual="departamento";
		if( strtoupper($cp_cpo_where)=="DEPTO" ) $cp_cpo_where="departamento";  
        // 
		if( $m_linhas<1 )  {
		       /* echo "==== Nenhum(a) <b>".ucfirst($table_atual)."</b> desse(a) <b>"
									 .ucfirst($cpo_where)."</b> ====";	*/
		       echo "==== Nenhum(a) <b>".ucfirst($cp_table_atual)."</b> desse(a) <b>"
									 .ucfirst($cp_cpo_where)."</b> ====";	
		       exit();
	    }  //  Final do IF - m_linhas<1						   
		//  Executar IF quando nao for o ultimo campo
		if( $i<$cpo_final ) {
				?>
	         <span class="td_informacao2"  >
		     <label for="<?php echo $table_atual;?>" style="cursor:pointer;" >&nbsp;<?php echo ucfirst($table_atual);?>:</label><br /><br />
       	     <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviar_dados_cad('CONJUNTO',this.value,this.name+'|'+'<?php echo $_SESSION[VARS_AMBIENTE];?>');" style="padding: 1px;" title="<?php echo ucfirst($cp_table_atual);?>"  >			
	    	 <?php
          	     //  acrescentando opcoes
	             echo "<option value='' >&nbsp;Selecionar&nbsp;</option>";
                 while( $linha=mysql_fetch_array($result) ) {   //  WHILE  DA TAG SELECT    
    				      //  Desativando selected - opcao que fica selecionada
						  if( $linha['sigla'] ) {
			    			     $value = urlencode($linha['sigla']);
								 $nome = trim(htmlentities($linha['sigla']));
						  } elseif( in_array($table_atual,array("bloco","salatipo","sala")) ) {
						         $select_cpo=$_SESSION["select_cpo"];
			    			     //  $value = urlencode($linha[$select_cpo]);
								 $value = trim(htmlentities($linha[$select_cpo]));
								 $nome = trim(htmlentities($linha[$select_cpo]));						  
						  }
				          $inst_selected = "";	$traco="";
						  if( strlen($nome_cpo)>1 ) {
						      //  htmlentities - o melhor para transferir na Tag Select
                              $se_sigla= htmlentities($linha[sigla]);  
                          	  $se_nome= htmlentities($linha[nome]); 
							  $traco="-";				  
						  }	  
	                      echo  "<option $inst_selected   value=".$value."  title='$se_sigla $traco $se_nome'  >&nbsp;";
               		      echo  $nome."&nbsp;</option>" ;
   	              }  // FIM DO WHILE
	       	  ?>
	          </select>
	          </span>
			  <?php
                  ////  Desativando variaveis
                 if( isset($result_tb_temp1) )  mysql_free_result($result_tb_temp1); 
                 if( isset($result) )  mysql_free_result($result); 
    	         // Final do SELECT
	    	 	 break;
		  } else {
		     //  Executando o Mysql Select do ultimo campo
			 unset($m_linhas); 
		     //  echo   "\$m_linhas =   ".$m_linhas."  ---  \$_SESSION[where] = ".$_SESSION['where'];
			 //   require_once("reservadeuso_ajax_ifs.php");
		  } //  FINAL DO - IF i < cpo_final
     }  //  Final do IF principal
}  elseif( strtoupper($val)=="PARTICIPANTE" ) {  //  CADASTRANDO o Participante do Projeto         
     //  Tabela usuario 
     //
     unset($array_temp); unset($array_t_value); $m_erro=0;
     //    Dados vindo de um FORM   
     include("../includes/dados_campos_form.php");
     //  $conta =  sizeof($array_temp); 
      //   Vericando se o LOGIN/USUSAIO se ja esta cadastrado na Tabela usuario
     $m_usuario_arr = array('USUARIO','LOGIN','USER','USERID','USER_ID','M_LOGIN','M_USER');
     $m_senha_arr = array('SENHA','PASSWD','PASSWORD');
     $array_email = array("EMAIL","E_MAIL","USER_EMAIL","EMAIL_USER");
     //  Definindo os nomes dos campos e valores recebidos do FORM
     foreach(  $arr_nome_val as $key => $value ) {
              $$key =  $value;
              $campo_nome = strtoupper($key);
              if( in_array($campo_nome,$m_usuario_arr) ) {
                $login = trim($value);
                $upper_login = (string) strtoupper($value);
              }                
              if( in_array($campo_nome,$m_senha_arr) ) {
                $senha = $value;
                $upper_senha = (string) strtoupper($value);
              }
              if( in_array($campo_nome,$array_email) ) {
                $e_mail = $value; $login = substr($e_mail,0,strpos($e_mail,'@'));
                $upper_e_mail = (string) strtoupper($value);
              }                         
      }
      ///  Verificando campos 
      $elemento=5; $elemento2=6;
      ///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");       
      include("php_include/ajax/includes/conectar.php");
      /// Array - PA
      $array_pa=$_SESSION["array_pa"]; 
      $n_pa = trim($arr_nome_val['pa']);
      foreach( $array_pa as $chave => $valor )  { 
          if( $n_pa==$valor  ) {
                $descr_pa = $chave;
                break;
          }         
      }
      ///
      $where = " upper(trim(a.e_mail))='$upper_e_mail'  and "; 
      ///
      ///  SELECT da Tabela participante
      $sqlcmd = "SELECT a.codigousp,a.e_mail,c.aprovado,c.pa,  "
                 ."(Select nome from $bd_1.pessoa where codigousp=$codigousp ) as nome_pessoa from  "
                 ." $bd_1.pessoa a, $bd_1.usuario b, $bd_2.participante c where  "
                 ." $where  a.codigousp=b.codigousp and a.codigousp=c.codigousp and c.pa=".$pa;
      ///
      $resultado_pessoa = mysql_query($sqlcmd);               
      if( ! $resultado_pessoa ) {
            die('ERRO: SELECT Usu&aacute;rio/Paticipante: '.mysql_error());
      }
      ///  Numero de registros
      $n_regs = mysql_num_rows($resultado_pessoa);
      ///
      $aprovado="";
      if( $n_regs==1 ) {
          $aprovado= (int) mysql_result($resultado_pessoa,0,"aprovado");  
          $nome = mysql_result($resultado_pessoa,0,"nome_pessoa");
          if( $aprovado==1 ) {
              $msg_erro .="Participante:&nbsp;"
                      .$nome." j&aacute; cadastrado e aprovado<br>como ".ucfirst($descr_pa).".".$msg_final;
          } else if( $aprovado<1 ) {
               $msg_erro .="Participante:&nbsp;"
                      .$nome." j&aacute; cadastrado mas ainda "
                      ." <b>n&atilde;o</b> foi aprovado como "
                      .ucfirst($descr_pa).".<br>Consultar Aprovador".$msg_final;            
          } 
          echo $msg_erro;   
          $m_erro=1;                  
      } else if( intval($n_regs)<1 ) {
          ///  Desativando variavel  
          if( isset($resultado_pessoa) ) mysql_free_result($resultado_pessoa);
          $sqlcmd = "SELECT nome as nome_pessoa from $bd_1.pessoa where codigousp=$codigousp ";
          $resultado_pessoa = mysql_query($sqlcmd);                       
          ///  Nome do Novo Participante para ser incluido
          $nome = mysql_result($resultado_pessoa,0,"nome_pessoa");
          $participante_cadast=0;
           /// Caso variavel ativa - desativando 
          if( isset($resultado_pessoa) ) mysql_free_result($resultado_pessoa);
          $sqlcmd = "SELECT senha as senha_usu, pa as pa_usu, aprovado as aprovado_usu "
                   ." FROM $bd_1.usuario where codigousp=$codigousp ";
          $resultado_usuario=mysql_query($sqlcmd);                       
          $n_usu = mysql_num_rows($resultado_usuario);
          $aprovado_usu=9;
          ///  Caso encontrado 
          if( intval($n_usu)==1  ) {
               $senha_usu=mysql_result($resultado_usuario,0,"senha_usu");
               $pa_usu=mysql_result($resultado_usuario,0,"pa_usu");
               $aprovado_usu=mysql_result($resultado_usuario,0,"aprovado_usu");
               if( intval($aprovado_usu)<=1 )  {
                     $msg_erro .="Participante:&nbsp;"
                      .$nome." j&aacute; cadastrado e aprovado<br>como ".ucfirst($descr_pa).".".$msg_final;
                       echo $msg_erro;   
                       $m_erro=1;  
                       $usuario_inserir=0;
               } 
               ///  
          } else {
              $usuario_inserir=1;  
          }         
          if( isset($resultado_usuario) )  mysql_free_result($resultado_usuario);
          ///
    }   
    $success="";    
    if( intval($m_erro)<1 ) {
         ///  START  a transaction - ex. procedure    
        mysql_query('DELIMITER &&'); 
        $commit="commit";
        mysql_query('begin'); 
        //  Execute the queries 
        //  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
        //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
        //   - Use mysql_select_db() ou mysql_query()
        ///  mysql_query("LOCK TABLES  $bd_1.usuario  INSERT, $bd_2.participante INSERT ");
         mysql_query("LOCK TABLES  $bd_1.usuario  WRITE, $bd_2.participante WRITE ");
 
         /// Gera a ativação de codigo com 6 digitos
        if( $usuario_inserir==1 ) {
            /* $success=mysql_query("insert into  $bd_1.usuario "
                    ."  (".$cpo_nome.",activation_code) values(".$cpo_valor.",'$activ_code') "); 
           */
            $success=mysql_query("insert into  $bd_1.usuario "
                    ."  (login,senha,datacad,datavalido,codigousp,pa,aprovado,activation_code) "
                     ."  values('$login',password('$senha'),'$datacad','$datavalido',$codigousp,$pa,1,'$activ_code') ");                     
             if( ! $success ) {
                 $commit="rollback";  $m_erro=1;
             } 
        }
        if( $m_erro==1  ) {
            $msg_erro .="Usu&aacute;rio:&nbsp;$nome n&atilde;o foi cadastrado como "
                      .ucfirst($descr_pa).".<br>Falha: ".mysql_error().$msg_final;
            echo $msg_erro;               
        } else {           
            $success=mysql_query("insert into  $bd_2.participante "
                    ."  (codigousp,datacad,datavalido,pa,codigo_ativa,aprovado) "
                    ."  values($codigousp,'$datacad','$datavalido',$pa,'$activ_code',1) ");                     
            
            if( ! $success ) {
                $commit="rollback";  $m_erro=1;
                $msg_erro .="Participante:&nbsp;$nome n&atilde;o foi cadastrado como "
                      .ucfirst($descr_pa).".<br>Falha: ".mysql_error().$msg_final;
                echo $msg_erro;               
            }  else {          
                $msg_ok .="<p class='titulo_usp'>Participante:&nbsp;"
                         .$nome." foi cadastrado como ".ucfirst($descr_pa).".<br>";                     
               //  $msg_ok .="Ser&aacute; informado no seu e_mail:&nbsp;".$e_mail;    
                $msg_ok .="</p>".$msg_final;
            }
        }                  
        /*!40000 ALTER TABLE  ENABLE KEYS */;
        mysql_query($commit);
        mysql_query("UNLOCK  TABLES");
        //  Complete the transaction 
        mysql_query('end'); 
        mysql_query('DELIMITER');
        // 
    }        
    if( intval($m_erro)<1 ) {
            $usr_email=html_entity_decode($e_mail);
            $host  = $_SERVER['HTTP_HOST'];
            $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
            $user=$codigousp;
            $m_local="ativar.php?user=".$user."&activ_code=".$activ_code;
            /*
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br>"
            ."<a href='http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code'  title='Clicar' >"
            ."http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code</a>"; 
            */
            $a_link = "***** CONEXÃO DE ATIVAÇÃO ***** Endere?o (URL) de Acesso\n<br>"
                     ."<a href='$retornar'  title='Clicar' >$retornar</a>";             //
            //  $host_upper = strtoupper($host);           
            $host_lower = strtolower($host);                     
            //  $assunto =html_entity_decode("Redefini??o de senha");    
           // $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
            $assunto="RGE/SISTAM - Detalhes da Autentifica??o";    
            $corpo ="RGE/SISTAM - Permiss?o para ".ucfirst($descr_pa)."<br>";
            //  $corpo .="$host_lower/rexp<br><br>";    
            $corpo .=html_entity_decode("Seu cadastro como ".ucfirst($descr_pa)." foi realizado.<br>Detalhes do seu registro\r\n");                    
            //  $user_name = html_entity_decode($arr_nome_val['login']); 
            $headers1  = "MIME-Version: 1.0\n";
            //  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
            $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
            $headers1 .= "X-Priority: 3\n";
            $headers1 .= "X-MSMail-Priority: Normal\n";
            $headers1 .= "X-Mailer: php\n";
            //  $headers1 .= "Return-Path: xxx@...\n";
            //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
            $headers1 .= "Return-Path: {$_SESSION["gemac"]} \n";
            
            //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
            // $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
            $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
            
            if( $usuario_inserir==1 ) {
                $senha_criada="Usar a mesma senha, caso esqueceu, clicar em: Esqueceu a senha?";
                $senha_criada="Senha Provis?ria altere no primeiro acesso em Alterar -> Senha \n<br><br>";
                $senha_criada .="Senha: $senha \n<br>";
                $message = "$corpo ...\n<br><br>
                Usuário/Email: $usr_email \n<br>
                $senha_criada \n<br>

                $a_link<br><br>

                ______________________________________________________<br>
                Esta é uma mensagem automática.<br> 
                *** não responda a este EMAIL ****
                ";
            } else {
                $message = "$corpo ...\n<br><br>
                Usuário/Email: $usr_email \n<br><br>

                $a_link<br><br>

                ______________________________________________________<br>
                Esta é uma mensagem automática.<br> 
                *** não responda a este EMAIL ****
                ";                
            }
          //  mail($usr_email, stripslashes(utf8_encode($assunto)), $message,$headers1);
            mail($usr_email, stripslashes($assunto), $message,$headers1);

            //                          
            /*    $msg_ok .= "<p>Sua senha foi redefinida e uma nova senha foi enviada para seu endere?o de e-mail.<br>"
            ."<a href='$retornar' title='Clicar' >Retornar</a></p>";                         
            */
            $msg_ok .= "<p>Mensagem de Acesso enviada para o email:  $usr_email<br></p>";
            echo  $msg_ok;
    }
    exit();                  
}	 
#
ob_end_flush(); /* limpar o buffer */
#
?>