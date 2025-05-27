<?php
//
//  AJAX da opcao CONSULTAR usuario
#
ob_start(); /* Evitando warning */
//
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//
/**     Verificar a Mensagem de Erro  
 *  Crucial ter as configurações de erro ativadas
*/ 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//
//  set IE read from page only not read from cache
//  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//
// Defina os cabeçalhos de controle de cache
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-type: text/html; charset=utf-8");
//
/**  Colocar as datas do Cadastro do Usuario e a validade   */  
date_default_timezone_set('America/Sao_Paulo');
//
//  Melhor setlocale para acentuacao - strtoupper, strtolower, etc...
//  setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
//
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
/**  extract: Importa variáveis para a tabela de símbolos a partir de um array   */ 
extract($_POST, EXTR_OVERWRITE);  
//
//  Formato das mensagens para enviar 
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
//  Final - Formato das mensagens para enviar 
//
//  Verificando SESSION incluir_arq
if( ! isset($_SESSION["incluir_arq"]) ) {
     $msg_erro .= utf8_decode("Sessão incluir_arq não está ativa.").$msg_final;  
     echo $msg_erro;
     exit();
}
$incluir_arq=$_SESSION["incluir_arq"];
//
/**
*    Caso NAO houve ERRO  
*     INICIANDO CONEXAO - PRINCIPAL
*/
require_once("{$_SESSION["incluir_arq"]}inicia_conexao.php");
//
//  Conexao MYSQLI
$conex = $_SESSION["conex"];
//
//  Conjunto de arrays 
require_once("{$_SESSION["incluir_arq"]}includes/array_menu.php");
//
// Conjunto de Functions
require_once("{$_SESSION["incluir_arq"]}script/stringparabusca.php");		
///
$post_array = array("source","val","m_array");
$sizear=count($post_array);
for( $i=0; $i<$sizear; $i++ ) {
    //
    $xyz = $post_array[$i];
    //
    /**   Verificar strings com simbolos: # ou ,   para transformar em array PHP  */
    // 
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) { 
        //
   	    $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
 	    if( $pos1 === false ) {
	         ///  $$xyz=trim($_POST[$xyz]);
	         ///   Para acertar a acentuacao - utf8_encode
             $$xyz = utf8_decode(trim($_POST[$xyz])); 
	     } else {
             $$xyz = explode($div_array_por,$_POST[$xyz]);  
         } 
         //
    }
    //
} 
/**  Final - for( $i=0; $i<$sizear; $i++ ) {  */
//
//   Para acertar a acentuacao - utf8_encode
/**   $source = utf8_decode($source); $val = utf8_decode($val);  */
// 
if( isset($source) ) {
    //
    $source = trim($source);
    if( is_array($source) ) {
        /** Array para String */
         $source = implode(",",$source);
    } else {
        /** String  */
         $source = utf8_decode($source);
    }
    //
} else {
    $source = "";
}
//
if( isset($val) ) {
    //
    $val = trim($val);
    if( is_array($val) ) {
        /** Array para String */
         $val = implode(",",$val);
    } else {
        /** String  */
         $val = utf8_decode($val);
    }
    //
} else {
    $val = "";
}
if( strtoupper($val)=="SAIR" ) $source=$val;
//
/** Variavel $source como Maiuscula  */
$sourceup=strtoupper(trim($source));
//
$_SESSION["source"]=$source;
//
//  INCLUINDO CLASS - 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");  
if( class_exists('funcoes') ) {
    $funcoes=new funcoes();
}
//
/** Sair do Programa */
if( $sourceup=="SAIR" ) {
    //
    // Eliminar todas as variaveis de sessions
    $_SESSION = array();
    //
    session_destroy();
    if( isset($total) ) unset($total);
    if( isset($login_senha) ) unset($login_senha); 
    if( isset($login_down) ) unset($login_down);     
    if( isset($senha_down) )  unset($senha_down); 
    //
    response.setHeader( "Pragma", "no-cache" ); 
    response.setHeader( "Cache-Control", "no-cache" ); 
    response.setDateHeader( "Expires", 0 ); 
    #
    exit();
    #
} 
/**  Final - if( $sourceup=="SAIR" ) { */
//

echo "ERRO:  LINHA160  -->> \$sourceup = $sourceup  - \$val = $val - \$m_array = $m_array   <br />";
exit();


//
if( $sourceup=="DESCARREGAR" )  {
    //
    /**  Define o tempo m?ximo de execu??o em 0 para as conex?es lentas  */
    // 
    set_time_limit(0);
    //
    /**   $pasta = "/var/www/html/rexp3/doctos_img/A".$m_array[0];    */
    // 
    $pasta = "../doctos_img/A".$m_array[0];
    $pasta .= "/".$m_array[1]."/";     
    //
    $arquivo = trim($val);
    if( ! file_exists("{$pasta}".$arquivo) ) {
         $msg_erro .= "&nbsp;Esse Arquivo: ".$arquivo."  n&atilde;o tem no Servidor".$msg_final;
         echo $msg_erro;  
    } else {
         echo $pasta."%".$arquivo;
    } 
    exit();     
    //
} 
/**  Final - if( $sourceup=="DESCARREGAR" )  { */
//
if( $sourceup=="SELECIONAR" )  {
    //
    //  Depois de ter selecionado uma Letra ou Todos
    $array_simbolos = array(",","|");
    $simbolos_count = count($array_simbolos);
    for( $x=0; $x< $simbolos_count ; $x++ ) {
         if( stripos($m_array,$array_simbolos[$x]) ) {
              $achou=1;
              break;
         }
         //
    } 
    //
    if( $achou==1 ) {
        //
        if( stripos($m_array,",") ) $m_array = explode(",",$m_array);
        if( stripos($m_array,"|") ) $m_array = explode("|",$m_array);
        for( $i=0 ; $i<count($m_array); $i++ ) {
            $m_array_str.= '"'.$m_array[$i].'"';
            $m_array_str.= ",";
        }    
        $val_strlen = (int) strlen(trim($m_array_str))-1;
        $m_array_str=substr($m_array_str,0,$val_strlen);
        //
    } else {
        $m_array_str=$m_array;     
    } 
    if( stripos($val,"|") ) $val=explode("|",$val);
    //
    $elemento=$val[1];
    //  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
    require_once("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
    //
    // Para criar Tabela Temporaria
    $_SESSION["table_temp_usu"] = "temp_".$val[2];
    $_SESSION[$_SESSION['table_temp_usu']] = $_SESSION["table_temp_usu"];
    //
    if( strtoupper($val[2])=="USUARIO" ) {
         $_SESSION["where"] = "upper(a.codigousp) in(".$m_array_str.")";
         $m_select_campos=" a.codigousp,b.nome,b.categoria,a.pa  "; 
         $order=" b.nome ";
        /*
         $result = mysql_query("SELECT a.codigousp,b.nome,b.categoria FROM "
               ."  pessoal.usuario a, pessoal.pessoa b where "
               .$_SESSION["where"]." and ( a.codigousp=b.codigousp )  order by b.nome "); 
         */      
          
         $res_temp1 = mysql_query("DROP TABLE IF EXISTS  ".$_SESSION[$_SESSION['table_temp_usu']]."  ");
         $res_temp2 = mysql_query("CREATE TABLE  ".$_SESSION[$_SESSION['table_temp_usu']]."  Select "
                          .$m_select_campos." FROM  pessoal.usuario a, pessoal.pessoa b "
                          ." where ".$_SESSION['where']."  and ( a.codigousp=b.codigousp ) order by  $order  ");

          //       
          if( ! $res_temp2  ) {
                mysql_free_result($result);
                die('ERRO: CREATE TABLE  - falha: '.mysql_error());  
          }
          if ( $res_temp2 ) {
                mysql_free_result($res_temp1); mysql_free_result($res_temp2);
          }
          $result_outro = mysql_query("SELECT * from ".$_SESSION[$_SESSION['table_temp_usu']]);        
         //  CODIGO/Num_USP
         $titulo_pag="Usuário";
    }   
    if( ! $result_outro ) {
         mysql_free_result($result_outro);
         die('ERRO: Select  - falha: '.mysql_error());  
    }
    $m_linhas = mysql_num_rows($result_outro);     
    if( $m_linhas==1 )  {
           /*    PARTE NOVA VERIFICAR COM CERTEZA - 20081031   */
           //  Depois de selecionado encontrou apenas um
          echo "<table style='width: 80%;text-align: center;' align='center'   >";
          echo "<tr><td>";
          //  Alterado em  20110412
          //  require_once("../library/consulta_bem.php");
          require_once("sala_reservadeuso.php");
          echo "</td></tr>";
          echo "</table>";    
          mysql_free_result($result);
    } elseif( $m_linhas>1 )  {
          //  Tabela pessoal.usuario              
          if( strtoupper($val[2])=="USUARIO" ) {
                //  Todos ou varios registros de uma LETRA Selecionada
                /*  
                  $msg_erro .= "&nbsp;LINHA 135 - PASSANDO PELO SELECIONAR ";
                  $msg_erro .= "<br> \$source = $source - \$val = $val - \$m_array = $m_array - \$m_linhas = $m_linhas ";
                  $msg_erro .= "<br> \$val_strlen =  $val_strlen - \$m_array_str = $m_array_str - \$_SESSION["where"] =  ".$_SESSION["where"];
                  $msg_erro .= "<br> \$val[0] = ".$val[0]." - \$val[1] = ".$val[1]." - \$val[2] = ".$val[2]." - \$val[3] = ".$val[3];    
                  echo $msg_erro;  
                */  
               $_SESSION["selecionados"] = "<b>Todos</b>";
               if( strtoupper($val)!=="TODOS" ) $_SESSION["selecionados"] = "come&ccedil;ando com <b>".strtoupper($val[0])."</b>";
               //  $m_primeiro_carater = $_SESSION["m_primeiro_carater"];
               //  Buscando a pagina para listar os registros        
               $_SESSION["num_rows"]=$m_linhas;  $_SESSION["name_c_id0"]="codigousp";    
               $_SESSION["ucfirst_data"]=$titulo_pag; $_SESSION["pagina"]=0;
               $_SESSION["opcoes_lista"] = "../script/paginacao.php?pagina=";
               require_once("../script/paginacao.php");                      
          }          
    } 
    //  
    exit();       
    //
} 
/**  Final - if( $sourceup=="SELECIONAR" )  { */
//
if( $sourceup=="CONJUNTO" ) {
     //
     // PARTE PARA MUDANCA DE CAMPO - IMPORTANTE
	 $n_cpo = (int) $n_cpo; $cpo_final = (int) $cpo_final;
	 if( ! is_array($m_array) ) $m_array  = explode(",",$m_array);
	 if( $n_cpo<=$cpo_final ) { //  Inicio do IF principal
	     $cpo_where = $m_array[0];
		 //  $pos_encontrada = array_search($cpo_where,$m_array);
		 //  Definindo a posicao para o proximo campo 
         $_SESSION["key"]++;		 
		 $total_array=sizeof($m_array);
		 for( $j=1; $j<=$total_array; $j++ ) {
		     if( $cpo_where==$m_array[$j] )  $i=$j+1; 
		 }
		 if( strtoupper($cpo_where)=="INSTITUICAO" ) {
		      $i=2;  unset($_SESSION["campos_dados1"]);
			  unset($_SESSION["campos_dados2"]);
              $_SESSION["key"]=0;			  
		 } else {
			 //  Verifica se esse campo ja foi selecionado no array
			 //  remover o anterior
			 if( $_SESSION["campos_dados1"] ) {
			      $total = sizeof($_SESSION["campos_dados1"]); 
			      for( $ver=0; $ver<$total ; $ver++ ) {
				      if( $cpo_where==$_SESSION["campos_dados1"][$ver] or $j<$total  ) {
					       $_SESSION["key"]=$ver;  // Importante depois de achar duplicata
					       for( $ver; $ver<$total ; $ver++ ) {
						        unset($_SESSION["campos_dados1"][$ver]);
						        unset($_SESSION["campos_dados2"][$ver]);		
						   }							   
					  }  
				  }
			 }
		 }
		 //
         $table_atual = $m_array[$i]; $upper_val=strtoupper($val);
         $_SESSION["select_cpo"]="sigla";
		 $array2 = array("bloco","salatipo","sala");
		 //  Precisava passar a variavel 
		 if( strtoupper($cpo_where)=="SALA" ) $table_atual="sala";	
		 $chave = $_SESSION["key"];
	     $_SESSION["campos_dados1"][$chave]=$cpo_where;
         $_SESSION["campos_dados2"][$chave]=$val;
		 //  
		//  Precisava passar a variavel 
		if( strtoupper($table_atual)=="BLOCO" || strtoupper($table_atual)=="SALATIPO" || strtoupper($table_atual)=="SALA" ){ 		       //  Mudando a variavel - $table_atual
		        $_SESSION["select_cpo"]=$table_atual;  $table_atual="bem"; 
		} 						
		$_SESSION["where"]="";			
		$total_arrays = sizeof($_SESSION["campos_dados1"]);		
		for( $row = 0; $row < $total_arrays; $row++) {
		     $_SESSION["where"].= " upper(trim(".$_SESSION["campos_dados1"][$row]."))=";
			 $p2 = $_SESSION["campos_dados2"][$row];
			 $p2 = trim(urldecode($p2));
			 $_SESSION["where"].=  " \"$p2\" ";
			 if( $row<($total_arrays-1) ) $_SESSION["where"].=  " and ";
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
	    }  
        //  Final do IF - m_linhas<1						   
		//  Executar IF quando nao for o ultimo campo
		if( $i<$cpo_final ) {
				?>
	         <span class="td_informacao2"  >
		     <label for="<?php echo $table_atual;?>" style="cursor:pointer;" >&nbsp;<?php echo ucfirst($table_atual);?>:</label><br /><br />
       	     <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviar_dados_con('CONJUNTO',this.value,this.name+'|'+'<?php echo $_SESSION["VARS_AMBIENTE"];?>');" style="padding: 1px;" title="<?php echo ucfirst($cp_table_atual);?>"  >			
	    	 <?php
                 //          
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
                              $se_sigla= htmlentities($linha["sigla"]);  
                          	  $se_nome= htmlentities($linha["nome"]); 
							  $traco="-";				  
						  }	  
	                      echo  "<option $inst_selected   value=".$value."  title='$se_sigla $traco $se_nome'  >&nbsp;";
               		      echo  $nome."&nbsp;</option>" ;
   	              }  
                  /**  Final - while( $linha=mysql_fetch_array($result) ) { */
                  // 
	       	  ?>
	          </select>
	          </span>
			  <?php
                 //
                 mysql_free_result($result_tb_temp1); 
                 mysql_free_result($result); 
    	         // Final do SELECT
	    	 	// break;
		  } else {
            //
		     //  Executando o Mysql Select do ultimo campo
			 unset($m_linhas); 
		     //  echo   "\$m_linhas =   ".$m_linhas."  ---  \$_SESSION["where"] = ".$_SESSION['where'];
			 //   require_once("../cadastrar/reservadeuso_ajax_ifs.php");
		  } 
          //  FINAL DO - IF i < cpo_final
          //
     }  
     //  Final do IF principal
     //
}
/**  Final - if( $sourceup=="CONJUNTO" )  {  */
//
//
/**   Serve tanto para o arquivo projeto  quanto para o experimento   
 *  if(  ( strtoupper(trim($source))=="CORESPONSAVEIS" ) or  ( strtoupper(trim($source))=="COLABS" ) ) {	
 */
$pattern = '/^(CORESPONSAVEIS|COLABS)$/ui';
if( preg_match($pattern, $sourceup) ) {
      //
      //  $m_co = "Co-respons?veis";
      // $m_co = "Co-resp.";
      $m_co = "Co-resp.";
      //  if( strtoupper(trim($source))=="COLABS" ) $m_co = "Colaboradores";
      if( strtoupper(trim($source))=="COLABS" ) $m_co = "Colab.";
      //
      //  Cod/Num_USP/Coautor
      $elemento=5;
      /**    Atrapalha e muito essa programacao orientada a objeto
      *    include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
      *    $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ");
      */
      require_once("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
       //
      mysql_select_db($db_array[$elemento]);
      //
      /**   mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query() */
      // 
   $result=mysql_query("select codigousp,nome,categoria from pessoa  order by nome ");
   if( ! $result ) {
          mysql_free_result($result);
          die('ERRO: Select pessoal.pessoa - falha: '.mysql_error());  
   }
   $m_linhas = mysql_num_rows($result);
   if ( $m_linhas<1 ) {
       echo "Nenhum encontrado";
       exit();      
   }
   //
   while($linha=mysql_fetch_assoc($result)) {
         $arr["codigousp"][]=htmlentities($linha['codigousp']);
         $arr["nome"][]=  ucfirst(htmlentities($linha['nome']));
         $arr["categoria"][]=$linha['categoria'];
    }
     $count_arr = count($arr["codigousp"])-1;	 
   ?>
  <table class="table_inicio"  align="center" width="100"  cellpadding="1" border="2" cellspacing="1" style="font-weight:normal; text-align: center; background-color: #FFFFFF; margin: 0px; padding: 0px;vertical-align: middle; "  >      
     <?php 
          $x_float2 = (float) (.5);  $acrescentou=0;
          $n_tr = (float) ($val/2);
          if(  ! is_int($n_tr) ) {
              $n_tr=$n_tr+$x_float2;
              $acrescentou=1;
          }
           //  $n_y=0;$texto=0; $n_tr= (int) $val;
		   $n_y=0;$texto=0; $n_tr= (int) $n_tr;
          for( $x=1; $x<=$n_tr; $x++ ) {
                ?>
               <tr style='margin: 0px; padding: 0px;vertical-align: middle;' >
               <?php
               $n_y=$texto; $n_td=4;
             //  if( $n_tr==1 ) $n_td=2;
              // $n_td=2;
                $n_tot=$n_td/2;
               for( $y=1; $y<=$n_tot ; $y++ ) {
                   $texto=$n_y+$y;
                   if( ( $acrescentou==1 ) and  ( $texto>$val ) ) {
                         echo  "<td class='td_inicio1' colspan='2'  "
						       ." style='margin: 0px; padding: 0px;vertical-align: middle;' >&nbsp;</td>";    
                        //  echo "<td class='td_inicio1' >&nbsp;</td>"; 
                         continue;
                   } else  {
                         echo  "<td class='td_inicio1'   colspan='2' "
						       ." style='color: #000000; background-color: #FFFFFF; vertical-align: middle;' >"
                                 ."&nbsp;$m_co $texto:</td>";
                   }
                   $n_tot2=1;
                   for( $z=1; $z<=$n_tot2 ; $z++ ) {
                        ?>
                        <td class="td_inicio1" colspan="2" style="text-align: left;color: #000000; background-color: #FFFFFF; vertical-align: middle; "   >
                        <!-- N. Funcional USP - COautor ou Colaborador  -->
                       <select name="ncoautor[<?php echo $texto;?>]" id="ncoautor[<?php echo $texto;?>]"  class="td_select"    style="overflow:auto;font-size: small;"  title="<?php echo "$m_co $texto"; ?>"  >  
                       <?php
                     if ( $m_linhas<1 ) {
                            echo "<option value='' >== Nenhum encontrado ==</option>";
                      } else {
                      echo "<option value='' >== Selecionar ==</option>";
                     // for ( $jk=0 ; $jk<$m_linhas ; $jk++) {
                     for( $jk=0; $jk<=$count_arr; $jk++ ) {
                           echo "<option  value=".$arr["codigousp"][$jk]." >&nbsp;";
                           echo  $arr["codigousp"][$jk]."&nbsp;-&nbsp;";
                           echo  $arr["nome"][$jk];
                           echo  "&nbsp;-&nbsp;".$arr["categoria"][$jk]."&nbsp;&nbsp;</option>" ;
                      }
                      ?>
                      </select>
                      <?php
                          mysql_free_result($result); 
                      }
                      // Final da Num_USP/Coautor
                    ?>  
                   </td>
                    <?php                      
                  } // Final do If TD  - numero USP/Coautor
               }
               echo "</tr>";
           }            
     ?>
  </table>
  <?php
     exit();
}  //  FINAL do IF  strtoupper(trim($source))=="CORESPONSAVEIS"  or   strtoupper(trim($source))=="COLABS" 
//    CONSULTAR - Tabela  PROJETO
//  Para Selecionar  projetos  - IF  source == projeto
if( strtoupper($source)=="PROJETO" or strtoupper($source)=="ANOTACAO"  ) {
     //  
     if( strtoupper($val)=="S_COORD_ANOTA"   ) {  // Faz parte do arq anotacao_consultar.php  
         $apagar .=  " \$source =  ".$source." -  \$val =  $val  - \$m_array =  ".$m_array." - \$m_array[0] = ".$m_array[0]." - \$m_array[1] = ".$m_array[1];
         echo $apagar;
         exit();
     }
     //
 	 if( strtoupper($val)=="AUTOR" ) {
    	  ?>
		  <td  class="td_inicio1" style="text-align: left;"   >
          <label for="ano"  style="vertical-align:bottom;  cursor: pointer; text-align:right;"  title="Ano inicial do Projeto" >Ano inicial do Projeto:&nbsp;</label>
	   </td>
         <td class="td_inicio1" style="text-align: left;"   >
         <!-- ANO do Projeto -->
		<?php 
            $elemento=6; $m_linhas=0;
			include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
        	mysql_select_db($db_array[$elemento]);
		    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
			//  $result2=mysql_query("SELECT cip,titulo FROM projeto order by cip ");
			// $autor_codigousp=$_SESSION["autor_codigousp"];
			$result_ano=mysql_query("SELECT  year(datainicio) as ano,cip,numprojeto,autor,datainicio,titulo FROM "
			                       ." projeto where autor=".$m_array." group by 1 order by ano desc ");
			//
		   if( ! $result_ano ) {
                mysql_free_result($result_ano);
                die('ERRO: Select projeto ano - falha: '.mysql_error());  
           }	   
		   //  Registros encontrados no Select
           $m_linhas = mysql_num_rows($result_ano);
     	?>
        <select name="ano" id="ano" class="td_select"   title="Selecionar ano inicial do Projeto"    onchange="enviar_dados_con('<?php echo $source;?>','ano',this.value)"  >                   
         <?php
            //  Ano inicial do Projeto
           $m_linhas = mysql_num_rows($result_ano);
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result_ano)) {       
			          /*  Antes com CIP 
                      echo "<option  value=".htmlentities($linha['cip'])." style='width: 15px; text-align: rigth;'  >"
			        ."&nbsp;".$linha['cip']."&nbsp;</option>" ;  */
					  $_SESSION["cip_proj"]=htmlentities($linha["cip"]);  
					  $_SESSION["numprojeto"]=htmlentities($linha["numprojeto"]);
					  $autor_proj = htmlentities($linha["autor"]);  					  
					  $ano = $linha["ano"];							
					  $ano_autor = $ano."/".htmlentities($linha["autor"]);  
                      echo "<option  value=".$ano_autor."   "
					         ."  title='Autor: $autor_proj - Ano inicial: $ano'  >"
					        ."&nbsp;".$linha["ano"]."&nbsp;</option>" ;
		              //							
			   }
			   if ( $m_linhas>1 )  echo "<option value='Todos/$autor_proj' title='Todos os anos'  >Todos</option>";
          ?>
          </select>
          <?php
               mysql_free_result($result_ano); 
           }
           //  Final da tag  select Ano inicial do Projeto
          echo "</td>";
	      exit(); //  Final do IF  strtoupper($val)==AUTOR
	 }
     //  Para selecionar o  Projeto
	 if( strtoupper($val)=="ANO" ) {
		  $pos_ano_autor = strpos($m_array,"/");
		  $ano_proj = substr($m_array,0,$pos_ano_autor);
		  $autor_proj = substr($m_array,$pos_ano_autor+1,strlen($m_array));
		  $year_ano=" year(datainicio)='$ano_proj'  and  ";
		  if( strtoupper(trim($ano_proj))=="TODOS" ) $year_ano=' ';	  
		  ?>
	     <td  class="td_inicio1" style="text-align: left;"   >
         <label for="projeto"  style="vertical-align:bottom;  cursor: pointer; text-align:right;"  title="N&uacute;mero do Projeto de Pesquisa" >Nr. Projeto:&nbsp;</label>
	      </td>
           <td class="td_inicio1" style="text-align: left;"   >
         <!-- CIP/Nr. do Projeto -->
		<?php 
            $elemento=6; $m_linhas=0;
			include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
        	mysql_select_db($db_array[$elemento]);
		    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
			//  $result2=mysql_query("SELECT cip,titulo FROM projeto order by cip ");
			// $autor_codigousp=$_SESSION["autor_codigousp"];
			$result2=mysql_query("SELECT  cip,numprojeto,autor,datainicio,titulo FROM "
			                       ." projeto where $year_ano   autor=".$autor_proj." order by numprojeto DESC ");
			//
		   if( ! $result2 ) {
                mysql_free_result($result2);
                die('ERRO: Select projeto - falha: '.mysql_error());  
           }
		     $m_linhas = mysql_num_rows($result2);
	       	?>
            <select name="projeto" id="projeto" class="td_select"   title="Selecionar Nr. Projeto" 
	     	onchange="enviar_dados_con('<?php echo $source;?>','projeto',this.value)"  >                   
         <?php
           if ( $m_linhas<1 ) {
                   echo "<option value='' >== Nenhum encontrado ==</option>";
           } else {
               echo "<option value='' >== Selecionar ==</option>";
               while($linha=mysql_fetch_array($result2)) {       
			          /*  Antes com CIP 
                      echo "<option  value=".htmlentities($linha['cip'])." style='width: 15px; text-align: rigth;'  >"
					        ."&nbsp;".$linha['cip']."&nbsp;</option>" ;  */
					  $_SESSION["cip_proj"]=htmlentities($linha["cip"]);  
					  $_SESSION["numprojeto"]=htmlentities($linha["numprojeto"]);		
					  $nr_projeto = "Nr. Projeto: ".$_SESSION["numprojeto"];  
					  $autor_nr_proj = "Autor: ".htmlentities($linha["autor"]);  
					  $dt_inicio_proj = htmlentities($linha["datainicio"]);  
				  	  $dt_inicio_proj=substr($dt_inicio_proj,8,2)."/".substr($dt_inicio_proj,5,2)."/".substr($dt_inicio_proj,0,4);
					  $dt_inicio_proj = "Data in&iacute;cio: ".$dt_inicio_proj; 
                      $cip_numproj=htmlentities($linha["cip"]).",".$_SESSION["numprojeto"]; 
                      echo "<option  value=".$cip_numproj."  "
					         ."  title='$nr_projeto - $autor_nr_proj - $dt_inicio_proj'  >"
					        ."&nbsp;".$linha['numprojeto']."&nbsp;</option>" ;
		              //							
			   }
          ?>
          </select>
          <?php
               mysql_free_result($result2); 
           }
           // Final do CIP/Projeto
          echo  "</td>";
 		  exit();  //  Final do IF  strtoupper($val)==ANO
	 }
 	 //  Selecionado o Projeto 
     if( strtoupper($val)=="PROJETO"  ) {
		  //  Localizar o projeto com CIP,NUMPROJETO - $m_array
          //  Criando Array
          $m_array  = explode(",",$m_array);          
          $elemento=6;          
		  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
          mysql_select_db($db_array[$elemento]);
		  //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
          //     - Use mysql_select_db() ou mysql_query()
		  //  $result2=mysql_query("SELECT cip,titulo FROM projeto order by cip ");
		  //  $autor_codigousp=$_SESSION["autor_codigousp"];
          if( strtoupper($source)=="PROJETO" ) { 
    		    $result=mysql_query("SELECT  * FROM  projeto  where cip=".$m_array[0]);
                if( ! $result ) {
                     mysql_free_result($result);
                     die('ERRO: Select $source - falha: '.mysql_error());  
                }
         }  elseif(  strtoupper($source)=="ANOTACAO"  ) { 
                $result_anota=mysql_query("SELECT  a.cia,a.numero,a.projeto,a.autor,a.data,b.numprojeto FROM "
                                   ." anotacao a, projeto b where "
                                   ." a.projeto=".$m_array[0]." and b.cip=".$m_array[0]."   "
                                   ." order by a.numero DESC ");
                //
                if( ! $result_anota ) {
                     mysql_free_result($result_anota);
                     die('ERRO: Select rexp.projeto e anotacao - falha: '.mysql_error());  
                }
                //  $x_anot=mysql_result($result_anota,0,anotacao);
                //   $x_anot=mysql_result($result_anota,0,numero);
                $x_anotacao=mysql_num_rows($result_anota);       
                if( $x_anotacao<1 ) {
                     $msg_erro .= "&nbsp;Esse Projeto Nr. ".$m_array[1]." n&atilde;o tem "
                       ." Anota&ccedil;&otilde;es  ".$msg_final;
                     echo $msg_erro;
                } else {
                     ?>
                    <label for="select_anotacao"  style="vertical-align:middle;  cursor: pointer; text-align: left; color:#000000;"  title="Selecione Anota??o" >Anota&ccedil;&atilde;o:&nbsp;</label>
                    <select name="select_anotacao" id="select_anotacao" class="td_select"   title="Selecione Anota&ccedil;&atilde;o"  onchange="enviar_dados_con('<?php echo $source;?>','anotacao',this.value)"  >                   
                    <?php
                     //  Selecione ANOTACAO para consultar
                     echo "<option value='' >== Selecionar ==</option>";
                     for( $x=0; $x<$x_anotacao; $x++ ) {
                          $_SESSION["cia"]=htmlentities(mysql_result($result_anota,$x,"cia"));  
                          //  $_SESSION["numprojeto"]=htmlentities($linha[numprojeto]);        
                          $_SESSION["numprojeto"]=htmlentities(mysql_result($result_anota,$x,"projeto"));        
                          $nr_anotacao = "Nr. Anota&ccedil;&atilde;o: ".mysql_result($result_anota,$x,"numero");  
                          $nr_projeto = mysql_result($result_anota,$x,"numprojeto");
                          $autor_nr_proj = "Autor: ".mysql_result($result_anota,$x,"autor");
                          $numero_projeto = htmlentities(mysql_result($result_anota,$x,"numero")).",".$_SESSION["numprojeto"];
                          echo "<option  value=".$numero_projeto."  "
                                ."  title='$nr_anotacao do Projeto $nr_projeto \r\n$autor_nr_proj' >"
                                .mysql_result($result_anota,$x,"numero")."&nbsp;</option>" ;
                          //                            
                   }
                   ?>
                    </select>
                   <?php
                     mysql_free_result($result_anota);
                }
          }    
		 //  Pagina mostrando os dados 
		 if( strtoupper($source)=="PROJETO" ) {
             include("projeto_consultado.php");
    	     $val="";
		     exit();
         }
	 }  //  FINAL DO  IF Apresentando o Projeto selecionado
}
//  Mostrar a Tabela ANOTACAO
if( strtoupper($val)=="ANOTACAO" ) {
    $m_array  = explode(",",$m_array);          
    $numero_anotacao=$m_array[0];
    $cip_projeto=$m_array[1];
    include("anotacao_consultada.php");
    exit();
}    
//   

if( strtoupper($val)=="EXPERIMENTO" ) {
    /*            TABELA  EXPERIMENTO  	 

         Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
         AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
		 e de depois usa o  - html_entity_decode 
    */
	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp);
	 //  Criando o array com os campos enviados do form
	 for( $i=0; $i<$count_array_temp; $i++ )   $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
 	 //
    //   Vericando se o NOme se ja esta cadastrado  na Tabela usuario
    //   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
	$m_titulo=strtoupper(trim($arr_nome_val[tituloexp]));
	$m_autor=strtoupper(trim($arr_nome_val[autor]));
	$m_datainicio=$arr_nome_val[datainicio];
	$m_datainicio=substr($m_datainicio,6,4)."-".substr($m_datainicio,3,2)."-".substr($m_datainicio,0,2);
	//  Obtendo o cip e o numprojeto  da tabela projeto
  	$projeto = $arr_nome_val[projeto];
	$expnum = $arr_nome_val[expnum];
    //   Verificando campos 
	//   INICIO - colaboradores para incluir na Tabela colabexp
	$colab_resp = array("coresponsaveis","colaboradores","colabs");
	foreach( $arr_nome_val as $key => $valor ) {
	    if( in_array($key,$colab_resp) ) {
			 unset($colab_resp);
			 $colab_resp=$valor;
			 break;
		}
	}
	$m_erro=0;
	//  if( $arr_nome_val[colabs]>=1 ) {
	if( $colab_resp>=1 ) {
	    $n_co=explode(",",$m_array);
		$count_co = count($n_co);
		for( $z=0; $z<$count_co ; $z++ ) {
		    if( strlen($n_co[$z])<1 ) {
			    $m_erro=1;
				break;
			} 
		}
	}
	if( $m_erro==1 ) {
	      $msg_erro .= "&nbsp;Falta incluir $key ".$msg_final;
          echo $msg_erro;
		  exit();
	}
	//   FINAL - colaboradores para incluir na Tabela colabexp
 	$elemento=6; $m_regs=0;
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
	mysql_select_db($db_array[$elemento]);
    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
	$result=mysql_query("SELECT  cip,autor,numprojeto FROM projeto WHERE "
	        ."  numprojeto=".$expnum." and  autor='$m_autor' and datainicio='$m_datainicio'  ");
	$m_regs=mysql_num_rows($result);
    if( $m_regs>=1 ) {
           mysql_free_result($result);
          $msg_erro .= "&nbsp;Experimento com a mesma "
		            ." data inicial (".$arr_nome_val[datainicio].") do Projeto Nr. $projeto".$msg_final;
          echo $msg_erro;
		  exit();
    } elseif( ! $result ) {
         mysql_free_result($result);
         die('ERRO: Select projeto - falha: '.mysql_error());  
	} else {
          	$result=mysql_query("SELECT  ciexp,autor,projeto FROM experimento WHERE "
	               ."  projeto=".$expnum." and  autor='$m_autor'  ");
        	$m_regs=mysql_num_rows($result);
	        if( $m_regs>=1 ) {
                  mysql_free_result($result);
                  $msg_erro .= "&nbsp;J? existe Experimento com o mesmo Projeto Nr. $projeto e"
		               ." Autor (".$m_autor.")".$msg_final;
                  echo $msg_erro;
		          exit();
             } elseif( ! $result ) {
                  mysql_free_result($result);
                 die('ERRO: Select experimento - falha: '.mysql_error());  
         	} 
            //  Continuacao Tabela experimento - BD REXP
            /*   MELHOR jeito de acertar a acentuacao - html_entity_decode    */	
             //  Caso tenha coautores/coresponsaveis/colaboradores no Projeto/Experimento
             include("n_cos.php");
    	     //  SESSION abaixo para ser usada no include
    	     $_SESSION["tabela"]="experimento";
             include("dados_recebidos_arq_ajax.php");  
    	     //  Verificando o numero de coresponsaveis/coautores
			//  $_SESSION["campos_total"]=utf8_decode($_SESSION["campos_total"]); //  Total deu 186 caracteres
		  //  $_SESSION["campos_total"]=urldecode($_SESSION["campos_total"]);   //  Total deu 186 caracteres
          //  MELHOR MANEIRA DE CONSERTAR ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
	      //  $_SESSION["campos_total"]=html_entity_decode(trim($_SESSION["campos_total"]));  // Melhor  179
          //  INSERINDO 
		  //  Start a transaction - ex. procedure	
		   mysql_query('DELIMITER &&'); 
           mysql_query('begin'); 
           //  Execute the queries 
           //
           //  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
    	   	mysql_select_db($db_array[$elemento]);
          //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
		   $success=mysql_query("insert into "
		                         ." experimento (".$_SESSION["campos_nome"].") values(".$_SESSION["campos_valor"].") "); 
           //  Complete the transaction 
           if ( $success ) { 
			      mysql_query('commit'); 
           } else { 
			        //  mysql_error() - para saber o tipo do erro
       	            $msg_erro .="&nbsp;Experimento n&atilde;o foi cadastrado.".mysql_error().$msg_final;
			        mysql_query('rollback'); 
		            echo $msg_erro;	     
            }
            mysql_query('end'); 
   		    mysql_query('DELIMITER'); 
			//		
			if ( $success ) { 
	  		    if(  $colab_resp==1 ) {
   				     //  mysql_db_query - Esta funcao esta obsoleta, 
					 //       nao use esta funcao - Use mysql_select_db() ou mysql_query()
					$result=mysql_query("insert into colabexp set "
					                  ." projeto=".$projeto.", expnum=".$expnum.", colab=$m_array ");
				 }	elseif(  $colab_resp>1 ) {
        		        //  Cadastrando na tabela corespproj os coresponsaveis
		                for(  $x=0  ; $x<$count_co;  $x++ )  {
						    //  mysql_db_query - Esta funcao esta obsoleta, 
							//      nao use esta funcao - Use mysql_select_db() ou mysql_query()
						    $result=mysql_query("insert into  colabexp set "
							         ." projeto=".$projeto.", expnum=".$expnum.", colab=".$n_co[$x]);
				        }
				 }	
				 if( $result ) {
                     $msg_ok .="<p class='titulo_usp'>&nbsp;Para concluir o Experimento enviar "
					                ." o arquivo em formato PDF.</p>".$msg_final;
                     echo  $msg_ok."falta_arquivo_pdf".$_SESSION["numprojeto"]."&".$m_autor;
				  } else {
        	         $msg_erro .="&nbsp;".strtoupper($key)." n&atilde;o foi cadastrado.".mysql_error().$msg_final;
                     echo  $msg_erro;				     
				  }
            } 

	}
 	//  FINAL -  TABELA experimento  -  BD  REXP
} elseif( strtoupper($val)=="PESSOAL" ) {
     //  Tabela pessoa - BD PESSOAL
    /*	 
         Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
		 OU para MYSQL  tem que ser html_entity_decode
    */	
 	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp);
	 for( $i=0; $i<$count_array_temp; $i++ ) $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
	 //  Verificando campos 
    $elemento=5;  $m_regs=0;
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    //  Vericando se o Codigo/USP se ja esta cadastrado na Tabela pessoa
	mysql_select_db($db_array[$elemento]);
    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
	$result_usu=mysql_query("SELECT   codigousp,nome  FROM  pessoa where codigousp='".$arr_nome_val[codigousp]."'  ") ;
	if( ! $result_usu ) {
          mysql_free_result($result_usu);	      
		  die("Falha erro no Select".mysql_error());
	}
    $m_regs=mysql_num_rows($result_usu);
    mysql_free_result($result_usu);
    if(  $m_regs>=1 ) {
           $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;".$arr_nome_val[codigousp]." j&aacute; est&aacute; cadastrado.".$msg_final;
           echo $msg_erro;
    } else {
    	  $m_regs=0;
	      //   Vericando se o NOme se ja esta cadastrado  na Tabela usuario
		  //   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
		  $pessoa_nome=trim($arr_nome_val[nome]);

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
    	$texto=$pessoa_nome;
		for( $x=0; $x<$m_count ; $x++ ) {
             //   $str = str_replace($char1[$x],$char2[$x],$str);
	     	// First check if there is a "5" at position 0.
		    $offset = 0; // initial offset is 0
	        $fiveCounter = 0;
	        if( strpos($pessoa_nome, $char1[$x])==0 ) continue;

    		   // Check the rest of the string for 5's
		       while( $offset=strpos($pessoa_nome, $char1[$x],$offset+1) ) {
        		   $texto=substr_replace($texto,$char2[$x],$offset,1); 
				   $chars .=  $char1[$x]." - ";        
		       }
     	}
		*/
		//
		//   MELHOR JEITO PRA ACERTAR O CAMPO NOME
        //   function para caracteres com acentos passando para Maiusculas
		//  '/&aacute;/i' => '?',
        include("../script/stringparabusca.php");		
		$m_texto=strtoupper($pessoa_nome);
        $pessoa_nome = stringParaBusca2($m_texto);
        //  MELHOR MANEIRA DE CONSERTAR ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
		$pessoa_nome=html_entity_decode(trim($pessoa_nome)); 
        //  Select nao precisa do upper para verificar nome
		/*
		$result_pessoa=mysql_query("SELECT  nome,codigousp FROM pessoa WHERE replace(trim(nome),'  ',' ')=replace('$pessoa_nome','  ',' ')  ");
	    $m_regs=mysql_num_rows($result_pessoa);
        if( $m_regs>=1 ) {
              $msg_erro .= "&nbsp;Essa Pessoa:&nbsp;".$arr_nome_val[nome]." j&aacute; est&aacute; cadastrada.".$msg_final;
              echo $msg_erro;
          } elseif( ! $result_pessoa ) {
             die('Sem resultado - Select - falha: '.mysql_error());  
		  } else {
          */
		  
		      mysql_select_db($db_array[$elemento]);
			  //  SESSION abaixo para ser usada no include
	  		  $_SESSION["tabela"]="pessoa";
    		  include("dados_recebidos_arq_ajax.php");  
			  //
			  //  $_SESSION["campos_total"]=utf8_decode($_SESSION["campos_total"]); //  Total deu 186 caracteres
			  //  $_SESSION["campos_total"]=urldecode($_SESSION["campos_total"]);   //  Total deu 186 caracteres
              //  MELHOR MANEIRA DE CONSERTAR ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
			  //  $_SESSION["campos_total"]=html_entity_decode(trim($_SESSION["campos_total"]));  // Melhor  179
                //  INSERINDO 
			   //  Start a transaction - ex. procedure			   
			   mysql_query('DELIMITER &&'); 
               mysql_query('begin'); 
               //  Execute the queries 
               //
               //  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
			   $success = mysql_query("insert into pessoa set {$_SESSION["campos_total"]} "); 
               //  Complete the transaction 
               if ( $success ) { 
                    mysql_query('commit'); 
	 	            $msg_ok .="<p class='titulo_usp'>&nbsp;"
				              .$arr_nome_val[nome]." foi cadastrado.</p>".$msg_final;
		            echo $msg_ok;
               } else { 
                    mysql_query('rollback'); 
       	            $msg_erro .="&nbsp;".$arr_nome_val[nome]." n&atilde;o foi cadastrado.".$msg_final;
		            echo $msg_erro;	     
               } 
               mysql_query('end'); 
   			   mysql_query('DELIMITER'); 
		  }
          mysql_free_result($sucess);		  
	//  Final - Tabela pessoa 
}  elseif( strtoupper($val)=="USUARIO" ) {
     //  Tabela usuario - BD PESSOAL
    /*	 
         Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
    */	
 	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
  /*   $msg_erro .= "&nbsp;-- USUARIO -->**  LINHA 187   --> \$source = $source  - \$val = $val <->  <br> ";
	 $msg_erro .= "<br>  \$campo_nome = $campo_nome ";
     $msg_erro .= "<br> \$campo_value = $campo_value ";
     $msg_erro .= "<br> \$m_array = $m_array  ".$msg_final;  */
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp);
	 for( $i=0; $i<$count_array_temp; $i++ )   $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
	 //
	 //  Verificando campos 
    $elemento=5; 
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
	//  Verificando se nao existe Usuario com esse login  na Tabela usuario
    $result_usu = mysql_query("SELECT   login  FROM  usuario where trim(login)='".$arr_nome_val[login]."'  ") ;
    $m_regs = mysql_num_rows($result_usu);
	mysql_free_result($result_usu);
	if(  $m_regs>=1 ) {
         $msg_erro .= "&nbsp;Usu&aacute;rio:&nbsp;".$arr_nome_val[login]." j&aacute; cadastrado.".$msg_final;
         echo $msg_erro;
	} else {
     	   $m_regs=0;
	       //  Vericando se o Codigo/USP ja esta cadastrado  na Tabela usuario
	      $result_usu=mysql_query("SELECT  login,codigousp FROM usuario where codigousp='".$arr_nome_val[codigousp]."' ");
		  $m_regs=mysql_num_rows($result_usu);
	      mysql_free_result($result_usu);
	      if(  $m_regs>=1 ) {
	            $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;".$arr_nome_val[codigousp]." j&aacute; est&aacute; cadastrado.".$msg_final;
                echo $msg_erro;
	      } else {
		      /*
       	      $campos=""; $campos_val="";
	          for( $i=0; $i<$count_array_temp; $i++ ) {
	              $campos .= $array_temp[$i];
			      $cpo_val=$array_t_value[$i];
				  $campos = (string) $campos;
				  if( trim(strtoupper($array_temp[$i]))=="SENHA" ) {
				       $campos_val .= "password("."'$cpo_val'".")";
   				  } else  $campos_val .= "'$cpo_val'";
			      if( $i<$count_array_temp-1 ) {
     		           $campos .=",";
					   $campos_val.=",";
			      }
	         } */
			  //  SESSION abaixo para ser usada no include: dados_recebidos_arq_ajax.php
	  		  $_SESSION["tabela"]="usuario";
			 include("dados_recebidos_arq_ajax.php");
             //	
			 //  $_SESSION["campos_total"]=utf8_decode($_SESSION["campos_total"]); //  Total deu 186 caracteres
			 //  $_SESSION["campos_total"]=urldecode($_SESSION["campos_total"]);   //  Total deu 186 caracteres
             //  MELHOR MANEIRA DE CONSERTAR ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
			 //  $_SESSION["campos_total"]=html_entity_decode(trim($_SESSION["campos_total"]));  //  179
			 //  INCLUINDO
		     //  $result=mysql_query("insert into usuario (".$campos.") values(".$campos_val.") ");
			 $result=mysql_query("insert into usuario  set {$_SESSION["campos_total"]} "); 
			 if( $result ) {
    	         $msg_ok .="<p class='titulo_usp'>Usu&aacute;rio:&nbsp;"
				              .$arr_nome_val[login]." foi cadastrado.</p>".$msg_final;
		        echo $msg_ok;
			 } else {
    	         $msg_erro .="Usu&aacute;rio:&nbsp;"
				              .$arr_nome_val[login]." n&atilde;o foi cadastrado.".$msg_final;
		        echo $msg_erro;	     
			 }	
		 }	 
	}
} 
#
ob_end_flush(); /* limpar o buffer */
#
?>