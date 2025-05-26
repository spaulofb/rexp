<?php
/**
*   Arquivo para CADASTRAR ANOTACAO AJAX -  20250411    
*/
//
ob_start(); /* Evitando warning */
////  Verificando se SESSION_START - ativado ou desativado
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
//   Para acertar a acentuacao
//  $_POST = array_map(utf8_decode, $_POST);
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
///  Formato das mensagens para enviar 
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///  Final - Formato das mensagens para enviar 
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
///  Conjunto de arrays 
include_once("{$incluir_arq}includes/array_menu.php");
if( isset($_SESSION["array_pa"]) ) $array_pa = $_SESSION["array_pa"];    

/// Conjunto de Functions
require_once("{$_SESSION["incluir_arq"]}includes/functions.php"); 

///  INCLUINDO CLASS - 
require_once("{$incluir_arq}includes/autoload_class.php");  
$funcoes=new funcoes();
///
$post_array = array("source","val","m_array");
for( $i=0; $i<count($post_array); $i++ ) {
    $xyz = $post_array[$i];
    ///  Verificar strings com simbolos: # ou ,   para transformar em array PHP    
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) {
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
if( ! isset($m_array) ) $m_array="";
///
/*  Conectar -  FORMA ADEQUADA: */
$elemento=5; $elemento2=6;
///  include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");     
include("php_include/ajax/includes/conectar.php");     
//
//   Para acertar a acentuacao - utf8_encode
//   $source = utf8_decode($source); $val = utf8_decode($val); 

if( strtoupper($val)=="SAIR" ) $source=$val;

$_SESSION["source"]=trim($source);
$source_upper=strtoupper($_SESSION["source"]);
///
if( $source_upper=="SAIR" ) {
    // Eliminar todas as variaveis de sessions
    $_SESSION=array();
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
///  Final - SAIR DO PROGRAMA 

///
if( strtoupper(trim($source))=="CONJUNTO" )  {
      //
     /// PARTE PARA MUDANCA DE CAMPO - IMPORTANTE
     $n_cpo = (int) $n_cpo; $cpo_final = (int) $cpo_final;
     unset($m_linhas); $m_vars_ambiente = $_SESSION['VARS_AMBIENTE'];     
     if( isset($m_array) ) {
          if( ! is_array($m_array) ) $m_array  = explode(",",$m_array);         
     } else {
         $m_array="";
     }
     //
     if( ! isset($_SESSION["key"]) ) $_SESSION["key"]=0;    
     if( $n_cpo<=$cpo_final ) {   ///  Inicio do IF principal
         $cpo_where = "";
         if( is_array($m_array) ) {
              $cpo_where = trim($m_array[0]);
              $cpo_where_upper=strtoupper($cpo_where);
         }
         //  $pos_encontrada = array_search($cpo_where,$m_array);
         //  Definindo a posicao para o proximo campo 
         $_SESSION["key"]= (int) $_SESSION["key"]+1;                  
         $total_array=sizeof($m_array);
         ///  if( strtoupper($cpo_where)=="INSTITUICAO" ) {
         if( $cpo_where_upper=="INSTITUICAO" ) {
              $i=2;  unset($_SESSION['campos_dados1']);
              unset($_SESSION['campos_dados2']);
              $_SESSION["key"]=0;              
         } else {
              $i=0;
              for( $j=1; $j<$total_array; $j++ ) {
                  if( $cpo_where==$m_array[$j] ) {
                      $i=$j+1;             
                      break;
                  }
            
              }
             //  Verifica se esse campo ja foi selecionado no array
             //  remover o anterior
             if( $_SESSION['campos_dados1'] ) {
                  $total = sizeof($_SESSION['campos_dados1']); 
                  for( $ver=0; $ver<$total ; $ver++ ) {
                      if( $cpo_where==$_SESSION['campos_dados1'][$ver] or $j<$total  ) {
                           $_SESSION["key"]=$ver;  // Importante depois de achar duplicata
                           for( $ver; $ver<$total ; $ver++ ) {
                                unset($_SESSION['campos_dados1'][$ver]);
                                unset($_SESSION['campos_dados2'][$ver]);        
                           }                               
                      }  
                  }
             }
         }
         ///
         $table_atual = $m_array[$i]; $upper_val=strtoupper($val); 
         $_SESSION["select_cpo"]="sigla";
         $array2 = array("bloco","salatipo","sala");
         ///  Precisava passar a variavel 
         if( $cpo_where_upper=="SALA" ) $table_atual="sala";    
         $chave = $_SESSION["key"];
         $_SESSION['campos_dados1'][$chave]=$cpo_where;
         $_SESSION['campos_dados2'][$chave]=$val;
         //  
        //  Precisava passar a variavel 
        //  Mudando a variavel - $table_atual       
       if( $cpo_where_upper=="INSTITUICAO" && strtoupper(trim($table_atual))=="SALATIPO"  ) {
            ////   if(  strtoupper(trim($table_atual))=="SALATIPO"  ) {
            $msg_erro .= "-> cadastrar_auto_ajax.php/305  - FALHA GRAVE ";
            echo  $msg_erro;   
            exit();
       }
       $select_cpo=$_SESSION["select_cpo"];
       if( strtoupper($table_atual)=="BLOCO" || strtoupper($table_atual)=="SALATIPO" || strtoupper($table_atual)=="SALA" ) { 
               $_SESSION["select_cpo"]=$table_atual; 
               $select_cpo=$_SESSION["select_cpo"];
               $table_atual="bem"; 
               $apagaressavar="";
       }                         
       $_SESSION["where"]="";            
       $total_arrays = sizeof($_SESSION['campos_dados1']);        
        for( $row = 0; $row < $total_arrays; $row++) {
             $_SESSION["where"].= " upper(trim(".$_SESSION['campos_dados1'][$row]."))=";
             $p2 = $_SESSION['campos_dados2'][$row];
             $_SESSION["where"].=  " \"$p2\" ";
             if( $row<($total_arrays-1) ) $_SESSION["where"].=  " and ";
        }
        $where=$_SESSION["where"];        
        /// Selecionando campo     
       //  elemento define o bd_1  e o elemento2  o  bd_2
       $elemento=3;
       include("php_include/ajax/includes/conectar.php");    
       $tabs_sig_nome= array("instituicao","unidade","depto","setor");                
       $nome_cpo="";
       if( in_array($table_atual,$tabs_sig_nome) ) $nome_cpo="nome,";
       
      //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
     /*
       $result=mysql_query("SELECT ".$_SESSION["select_cpo"].", $nome_cpo count(*) FROM "
                         ." $table_atual where ".$_SESSION["where"]."  group by 1 order by  ".$_SESSION["select_cpo"]);
                          
       */
       //  $sqlcmd="SELECT $select_cpo, $nome_cpo count(*) FROM  $table_atual where $where   group by 1  order by $select_cpo ";
       $sqlcmd="SELECT $select_cpo, $nome_cpo count(*) FROM  $bd_1.$table_atual WHERE $where  GROUP BY 1 ORDER BY $select_cpo ";
       $result=mysql_query($sqlcmd);
       ///
        if( strtoupper($table_atual)=="BEM" ) $table_atual=$_SESSION["select_cpo"]; 
        if( ! $result ) die('ERRO: Select - falha: '.mysql_error());
        $m_linhas = mysql_num_rows($result);
        ///
        $_SESSION["table_atual"]=$table_atual;
        $cp_table_atual=$table_atual; $cp_cpo_where=$cpo_where;
        if( strtoupper($cp_table_atual)=="INSTITUICAO" ) $cp_table_atual="instituição";
        if( strtoupper($cp_cpo_where)=="INSTITUICAO" ) $cp_cpo_where="instituição";
        if( strtoupper($cp_table_atual)=="DEPTO" ) $cp_table_atual="departamento";
        if( strtoupper($cp_cpo_where)=="DEPTO" ) $cp_cpo_where="departamento";  
        /// 
        if( $m_linhas<1 )  {
               /* echo "==== Nenhum(a) <b>".ucfirst($table_atual)."</b> desse(a) <b>"
                                     .ucfirst($cpo_where)."</b> ====";    */
               echo "==== Nenhum(a) <b>".ucfirst($cp_table_atual)."</b> desse(a) <b>"
                                     .ucfirst($cp_cpo_where)."</b> ====";    
               exit();
        }  //  Final do IF - m_linhas<1                           
        //  Executar IF quando nao for o ultimo campo
        if( $i<$cpo_final ) {
             ?>
            <span class="td_informacao2"  >
             <label for="<?php echo $table_atual;?>" >&nbsp;<?php echo ucfirst($table_atual);?>:</label><br />
           <!--  Tag Select com title para ser verificada                   
             <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviar_dados_cad('CONJUNTO',this.value,this.name+'|'+'<?php echo $m_vars_ambiente;?>');" style="padding: 1px;" title="<?php echo ucfirst($cp_table_atual);?>"  >            
            -->
             <select  class="td_select"  name="<?php echo $table_atual;?>"  id="<?php echo $table_atual;?>" 
                onchange="enviar_dados_cad('CONJUNTO',this.value,this.name+'|'+'<?php echo $m_vars_ambiente;?>');" style="padding: 1px;" >            
             <?php
                   //  acrescentando opcoes
                 echo "<option value='' >&nbsp;Selecionar&nbsp;</option>";
                 while( $linha=mysql_fetch_array($result) ) {   //  WHILE  DA TAG SELECT    
                          //  Desativando selected - opcao que fica selecionada
                          if( isset($linha["sigla"]) ) {
                                 $value = urlencode($linha["sigla"]);
                                 $nome = trim(htmlentities($linha["sigla"]));
                          } elseif( in_array($table_atual,array("bloco","salatipo","sala")) ) {
                                 $select_cpo=$_SESSION["select_cpo"];
                                 //  $value = urlencode($linha[$select_cpo]);
                                 $value = trim(htmlentities($linha[$select_cpo]));
                                 $nome = trim(htmlentities($linha[$select_cpo]));                          
                          }
                          $inst_selected = "";    $traco="";
                          $se_sigla=""; $se_nome="";
                          if( strlen($nome_cpo)>1 ) {
                              //  htmlentities - o melhor para transferir na Tag Select
                              if( isset($linha["sigla"]) ) $se_sigla= htmlentities($linha["sigla"]);  
                                if( isset($linha["nome"]) ) $se_nome= htmlentities($linha["nome"]); 
                              $traco="-";                  
                          }      
                          $title_sigla=$se_sigla."&nbsp;".$traco."&nbsp;".$se_nome;
                          echo  "<option $inst_selected   value=".$value."  title=".$title_sigla." >";
                          echo  $nome."&nbsp;</option>" ;
                     }  
                     /// FIM DO WHILE
                 ?>
              </select>
              </span>
              <?php
                  if( isset($result) ) mysql_free_result($result); 
                 /// Final do SELECT
                 if( strtoupper(trim($_SESSION["select_cpo"]))=="SALA" ) {
                       $cpo_final=0; $n_cpo=0; unset($m_array); unset($m_linhas); unset($source);
                       unset($_SESSION["where"]);  unset($_SESSION["select_cpo"]);
                 }
          } else {
              ///  Executando o Mysql Select do ultimo campo
              if( isset($m_linhas) ) unset($m_linhas); 
          } 
          ///  FINAL DO - IF i < cpo_final
     }  
     ///  Final do IF principal
}
//// FINAL  if( strtoupper(trim($source))=="CONJUNTO" )
///

///  Colaboradores ou Coautores da Anotacao
///  if(  ( $source_upper=="COAUTORES" ) or  ( $source_upper=="COLABS" ) ) {	
if( ( $source_upper=="CORESPONSAVEIS" ) or ( $source_upper=="COLABS" ) ) {	
   /*    $m_co = "Co-respons?veis";
          $m_co = "Co-resp.";         
   */
  $m_co = "Co-resp.";
   //  if( $source_upper=="COLABS" )    $m_co = "Colaboradores";
   if( $source_upper=="COLABS" ) $m_co = "Colab.";
   ///  Cod/Num_USP/Coautor
   mysql_select_db($db_array[$elemento]);
   ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
   $result=mysql_query("Select codigousp,nome,categoria from $bd_1.pessoa  order by nome ");
   if( ! $result ) {
         // die('ERRO: Select pessoa - falha: '.mysql_error());  
         $msg_erro .= "Select Tabela pessoa - db/mysql:&nbsp;".mysql_error().$msg_final;
         echo $msg_erro;
         exit();        
   }
   ///  Nr. de regitros
   $m_linhas = mysql_num_rows($result);
   if( intval($m_linhas)<1 ) {
       echo "Nenhum encontrado";
       exit();      
   }
   ///
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
               echo "<tr style='margin: 0px; padding: 0px;vertical-align: middle;' >";
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
                       if( $m_linhas<1 ) {
                            echo "<option value='' >== Nenhum encontrado ==</option>";
                       } else {
                           echo "<option value='' >== Selecionar ==</option>";
                           /// for ( $jk=0 ; $jk<$m_linhas ; $jk++) {
                           for( $jk=0; $jk<=$count_arr; $jk++ ) {
		      			        $m_codigousp = htmlentities($arr["codigousp"][$jk]);
     				            $m_categ = "Categ.: ".$arr["categoria"][$jk];	
                               ///  $m_nome=ucfirst(htmlentities($arr["nome"][$jk])); 
                               $m_nome=ucfirst(html_entity_decode($arr["nome"][$jk]));  
        					   if( intval($m_codigousp)>=1 ) {
                                     echo "<option  value=".$m_codigousp." >".$m_nome;
                                     echo  "&nbsp;-&nbsp;".$m_categ."&nbsp;</option>" ;
				    		   }	   
                           }
                      ?>
                      </select>
                      <?php
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
}  
///  FINAL do IF  $source_upper=="CORESPONSAVEIS"  or   $source_upper=="COLABS" 
///
///  Primeira PARTE da TABELA ANOTACAO
if( $source_upper=="ANOTACAO" ) { ////  IF  - Tabela ANOTACAO 
     /// if( strtoupper(trim($val))=="AUTOR" ) {
    ///  Tabela PROJETO - verificando se existe para cadastrar Anotacao
    ///
    if( strtoupper(trim($val))=="VERIFICANDO" ) {
       if( $_SESSION["permit_pa"]==$array_pa["orientador"]  )  {
           $result_proj=mysql_query("SELECT  numprojeto FROM $bd_2.projeto  WHERE autor=".$_SESSION["usuario_conectado"]);
           /// Verificando FALHA no MySql SELECT
           if( ! $result_proj ) {
                $msg_erro .= "Select Tabela projeto - falha: ".mysql_error().$msg_final;
                echo $msg_erro;
                exit();        
           }
           /// Numero de registros
           $n_regs = mysql_num_rows($result_proj);
           if( intval($n_regs)<1 ) {
               $msg_erro .="Nenhum PROJETO cadastrado.".$msg_final;
               echo $msg_erro;
               exit();                       
           }
       }
    }      
    ////  Tabela PROJETO
    if( strtoupper(trim($val))=="PROJETO" ) {
            $cip_codigouso = explode(",",$m_array);
            $regs=0;
            ///
            ///  Quando usar esse Select necessita do GROUP
           $result_anotacao=mysql_query("SELECT  a.anotacao, a.cip, a.numprojeto,"
                          ." b.nome as projeto_autor_nome "
                          ." FROM $bd_2.projeto a, $bd_1.pessoa b  "
                          ." WHERE a.autor=b.codigousp  and  cip=".$cip_codigouso[0]);
           ///
           if( ! $result_anotacao ) {
                $msg_erro .= "Select Tabelas projeto e anotacao - falha: ".mysql_error().$msg_final;
                echo $msg_erro;
                exit();        
           }
           ///
           $array_nome0=mysql_fetch_array($result_anotacao);
           foreach( $array_nome0 as $cpo_nome => $cpo_valor ) {
                    $$cpo_nome=$cpo_valor;
           }
           $_SESSION["cip"]=$cip_codigouso[0];
           ///
           ///  CORRIGIDO  sabado - 20110709
           /* $_SESSION[$anotacao]= (int)  mysql_result($result_anotacao,0,"anotacao")+1;
           $anotacao=$_SESSION[$anotacao]; */
           $anotacao = (int) mysql_result($result_anotacao,0,"anotacao")+1;          
           $_SESSION["anotacao"]=$anotacao;
           $_SESSION["cia_proj"]=mysql_result($result_anotacao,0,"cip");
           $_SESSION["projeto_autor_nome"]=mysql_result($result_anotacao,0,"projeto_autor_nome");
           $dados = "<label  style='vertical-align:middle;  cursor: pointer; text-align: left; background-color:#FFFFFF; color:#000000;'  title='N&uacute;mero da Anota&ccedil;&atilde;o' >$anotacao</label>";
////           $dados .= "<label for='altera_complementa'  style='cursor: pointer; '  title='Altera ou Complementa o Projeto' >Altera/Complementa (Sim/N&atilde;o)?&nbsp;</label>";
           $dados .= "<label for='altera_complementa'  style='cursor: pointer; '  title='Altera ou Complementa o Projeto' >Altera/Complementa (Sim/N&atilde;o)?&nbsp;</label>";

           $dados .= "<select name='altera_complementa'   id='altera_complementa' class='td_select'  title='Altera ou Complementa o Projeto' onchange='javascript: enviar_dados_cad(\"anotacao\",\"altera_complementa\",this.value)'  >";
           $dados .= "<option value='' >== Selecionar ==</option>";
           $dados .= "<option value='1,$cip_codigouso[0]' >Sim</option>";
           $dados .= "<option value='0' >Não</option>";
           $dados .= "</select>";
           //// echo $dados."<label".$_SESSION["projeto_autor_nome"];
           ///IMPORTANTE:  htmlentities e utf8_decode - transfere dados PHP para HTML
           $xz=htmlentities($_SESSION["projeto_autor_nome"],ENT_QUOTES,"UTF-8");  
           echo  utf8_decode($dados)."<label".$xz;
   } elseif( strtoupper(trim($val))=="ALTERA_COMPLEMENTA" ) {
            $array_altera = explode(",",$m_array);
            if( $array_altera[0]==1 ) {
    			///  Quando usar esse Select necessita do GROUP
    	    	/*	$result_altera=mysql_query("SELECT  a.anotacao, a.cip,a.numprojeto, "
			                       ." a.autor,b.nome FROM "
			                       ." projeto a, $bd_1.pessoa b where "
								   ."  a.cip=".$array_altera[1]."  and b.codigousp=a.autor   "
								   ." order by a.cip ");	  
                */
                $result_altera=mysql_query("SELECT  a.cia,a.numero,a.projeto,a.autor,a.data,b.numprojeto "
                                   ." FROM $bd_2.anotacao a, $bd_2.projeto b WHERE "
                                   ." a.projeto=".$array_altera[1]." and b.cip=".$array_altera[1]."   "
                                   ." order by a.numero DESC ");
                //
                if( ! $result_altera ) {
                     $msg_erro .= "Select Tabelas projeto e anotacao - falha: ".mysql_error().$msg_final;
                     echo $msg_erro;
                     exit();                     
                }
				///  $x_anot=mysql_result($result_altera,0,anotacao);
                ///   $x_anot=mysql_result($result_altera,0,numero);
                $x_anot=mysql_num_rows($result_altera);
                $_SESSION["cia_proj"]=$array_altera[1];
 				if( intval($x_anot)<1 ) {
                     $msg_erro .= "&nbsp;N&atilde;o tem Anota&ccedil;&atilde;o anterior.".$msg_final;
                     echo $msg_erro;
              		 exit();
				} else {
                     ///  Altera/Complementa Anotacao anterior
                     echo "<option value='' >== Selecionar ==</option>";
	 		    	 for( $x=0; $x<$x_anot; $x++ ) {
    					  $_SESSION["cia"]=htmlentities(mysql_result($result_altera,$x,"cia"));  
    					  ///  $_SESSION["numprojeto"]=htmlentities($linha["numprojeto"]);
	    				  $_SESSION["numprojeto"]=htmlentities(mysql_result($result_altera,$x,"projeto"));		
		    			  $nr_anotacao = "Nr. Anota&ccedil;&atilde;o: ".mysql_result($result_altera,$x,"numero");  
                          $nr_projeto = mysql_result($result_altera,$x,"numprojeto");
			    		  $autor_nr_proj = "Autor: ".mysql_result($result_altera,$x,"autor");
                          $dt_anot = htmlentities(mysql_result($result_altera,$x,"data"));  
                          $dt_anot=substr($dt_anot,8,2)."/".substr($dt_anot,5,2)."/".substr($dt_anot,0,4);
                          $dt_anot = "Data: ".$dt_anot;  
					      //  $autor_nome_proj = "Autor: ".htmlentities(mysql_result($result_altera,$x,nome));  
                          echo "<option  value=".htmlentities(mysql_result($result_altera,$x,"numero"))."  "
					            ."  title='$nr_anotacao do Projeto $nr_projeto \r\n$dt_anot \r\n$autor_nr_proj' >"
    					        .mysql_result($result_altera,$x,"numero")."&nbsp;</option>" ;
	    	              //							
		    	   }
                    ?>
                    </select> 
                   <?php
				}	  	
			}
   }
   if( isset($val) ) unset($val);
   exit();
}  
/// FINAL  IF  - source_upper==ANOTACAO
///
///  SEGUNDA PARTE da TABELA ANOTACAO
if( strtoupper($val)=="ANOTACAO" ) {
     /*   
           Recebendo Dados do FORM e INSERINDO/ADICIONANDO
              nas Tabelas ANOTACAO e  PROJETO
     */
	 unset($array_temp); unset($array_t_value);
     ////
     include("{$_SESSION["incluir_arq"]}cadastrar/dados_campos_form.php");
     ////  Caso tenha coautores/coresponsaveis/colaboradores no Projeto/Experimento
     include("{$_SESSION["incluir_arq"]}cadastrar/n_cos.php");
     ///     
   	///  mysql_select_db($db_array[$elemento]);
	$_SESSION["tabela"]="$bd_2.anotacao";
    include("{$_SESSION["incluir_arq"]}cadastrar/dados_recebidos_arq_ajax.php");
    ///
    $projeto=$arr_nome_val['projeto'];
    ///   Essa SESSION  vindo da parte acima
	$result_anot=mysql_query("SELECT  anotacao,autor as projeto_autor "
                             ." FROM $bd_2.projeto  WHERE cip=$projeto  ");
    ///
    if( ! $result_anot ) {
         //  die('ERRO: Select $bd_2.projeto e campo anotacao - falha: '.mysql_error());  
         $msg_erro .= "Select Tabela projeto e campo anotacao - db/mysql:&nbsp;".mysql_error().$msg_final;
         echo $msg_erro;
         exit();        
     }
     ///  CORRIGIDO  sabado - 20110709
     $_SESSION["anotacao"]=mysql_result($result_anot,0,"anotacao")+1;
     $_SESSION["projeto_autor"]=mysql_result($result_anot,0,"projeto_autor");
      //
      if( ! isset($_SESSION["anotacao"]) ) $anotacao="";
      if( isset($_SESSION["anotacao"]) ) $anotacao=$_SESSION["anotacao"];
     ///     
     $anotacao=$_SESSION["anotacao"];
     if( isset($result_anot) ) mysql_free_result($result_anot);
     ///
     ///   Campo numero na Tabela anotacao e  anotacao na TB projeto
	 $_SESSION["campos_nome"].=",numero";
	 $_SESSION["campos_valor"].=",".$anotacao;           
     
     
     ///
    //  $_SESSION[campos_total]=utf8_decode($_SESSION[campos_total]); //  Total deu 186 caracteres
    //  $_SESSION[campos_total]=urldecode($_SESSION[campos_total]);   //  Total deu 186 caracteres
    //  MELHOR MANEIRA DE CONSERTAR ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
    //  $_SESSION[campos_total]=html_entity_decode(trim($_SESSION[campos_total]));  // Melhor  179
    //  INSERINDO DADOS NAS TABELAS ANOTACAO E PROJETO
    /////           
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    ///                         
    $campos_nome=$_SESSION["campos_nome"];
    ///  IMPORTANTE:  html_entity_decode para variavel PHP para MySql
    $campos_valor=html_entity_decode($_SESSION["campos_valor"], ENT_QUOTES, "UTF-8");
    

/***
 echo  " anotacao_cadastrar_ajax/715 -- \$source_upper = $source_upper   -- strtoupper(val)==ANOTACAO   -- \$m_array = $m_array  <br/>  \$campos_nome = $campos_nome <br/>
      \$campos_valor =  $campos_valor ";

 exit();    
***/
    
    
    ///
    ///  START a transaction - ex. procedure  -  inserindo nova Anotacao no Projeto   
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    ///  Execute the queries 
    ///  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
    mysql_select_db($db_array[$elemento]);
    //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
    //   - Use mysql_select_db() ou mysql_query()
    mysql_query("LOCK TABLES $bd_2.anotacao INSERT, $bd_2.projeto UPDATE ");
    ///
    ////  $sqlcmd="INSERT INTO  $bd_2.anotacao(".$_SESSION["campos_nome"].")  values(".$_SESSION["campos_valor"].") ";
    $sqlcmd="INSERT INTO  $bd_2.anotacao  (".$campos_nome.") values(".utf8_encode($campos_valor).") ";
    $success=mysql_query($sqlcmd); 
    //  Complete the transaction 
    if( $success ) { 
        //  mysql_db_query - Esta funcao esta obsoleta, 
        //       nao use esta funcao - Use mysql_select_db() ou mysql_query()
        //  UPDATE no campo anotacao da Tabela Projeto do campo numero TB ANOTACAO
        $result=mysql_query("UPDATE $bd_2.projeto SET anotacao=$anotacao  WHERE  cip=$projeto  ");
        if( $result ) {
            /*  $autor=$arr_nome_val['autor'];
            if( ! isset($_SESSION["projeto_autor"]) ) $projeto_autor="";
            if( isset($_SESSION["projeto_autor"]) ) $projeto_autor=$_SESSION["projeto_autor"];
            */
            $anotacao_autor=$arr_nome_val['autor'];
            ///  Incluindo arquivo para a Anotacao do Projeto 
            ///  projeto, autor/orientador e numero da anotacao
            $msg_ok .="<p class='titulo_usp'>&nbsp;Para concluir Anotação enviar "
                       ." o arquivo em formato PDF.</p>".$msg_final;
            $msg_ok .= "falta_arquivo_pdf";
            ///  $msg_ok .= $projeto."&".$autor."&".$anotacao;
            /// $msg_ok .= $projeto."&".$projeto_autor."&".$anotacao;
            $msg_ok .= $projeto."&".$anotacao_autor."&".$anotacao;
            echo  utf8_decode($msg_ok);
            ///
            $_SESSION["anotacao_numero"]=$anotacao;
            /// Efetiva a transa??o nos duas tabelas (anotacao e projeto)
            mysql_query('commit'); 
        } else { 
           ///  mysql_error() - para saber o tipo do erro
           $msg_erro .="&nbsp;Anota&ccedil;&atilde;o <b>N&Atilde;O</b> foi cadastrada. Update projeto".mysql_error().$msg_final;
           mysql_query('rollback'); 
           echo $msg_erro;         
        }
    } else {
        $msg_erro .="&nbsp;Anota&ccedil;&atilde;o <b>N&Atilde;O</b> foi cadastrada. Insert anotacao " .mysql_error().$msg_final;
        mysql_query('rollback'); 
        echo $msg_erro;         
    }
    mysql_query("UNLOCK  TABLES");
    mysql_query('end'); 
    mysql_query('DELIMITER');
   ///  FINAL -  TABELA ANOTACAO  -  BD  REXP
   ///
}
//    Tabela do ORIENTADOR 
if( strtoupper($val)=="ORIENTADOR" ) {
     ///  Recebendo dados do FORM e Inserindo
     ///  nas Tabelas ANOTACAO e  PROJETO
     unset($array_temp); unset($array_t_value);
     ///
     include("dados_campos_form.php");
     ///  Caso tenha coautores/coresponsaveis/colaboradores no Projeto/Experimento
     include("n_cos.php");
     
    
 echo " anotacao_cadastrar_ajax/828 -- \$source_upper = $source_upper   -- strtoupper(val) == ORIENTADOR   -- \$m_array = $m_array  ";
 exit();    
    
     
     
     
    $_SESSION["tabela"]="$bd_2.orientador";
    include("dados_recebidos_arq_ajax.php");
    //  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    //  Execute the queries 
    mysql_select_db($db_array[$elemento]);
   //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
   $session_tabela = $_SESSION["tabela"];
   mysql_query("LOCK TABLES ".$session_tabela." WRITE  ");
   /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;
   $res_coord = mysql_query("INSERT into ".$session_tabela." (".$_SESSION["campos_nome"].") values(".$_SESSION["campos_valor"].") "); 
   /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
   mysql_query("UNLOCK  TABLES");
   //  Complete the transaction 
   if ( $res_coord ) { 
         $msg_ok .="<p class='titulo_usp'>&nbsp;Orientador cadastrado</p>".$msg_final;
         echo  $msg_ok;
         mysql_query('commit'); 
   } else { 
        //  mysql_error() - para saber o tipo do erro
        $msg_erro .="&nbsp;Orientador n&atilde;o foi cadastrado. ERRO = ".mysql_error().$msg_final;
         mysql_query('rollback'); 
         echo $msg_erro;         
   }
   mysql_query('end'); 
   mysql_query('DELIMITER');         
   exit();
}
//
//   Tabela do ANOTADOR  cadastrado pelo Orientador  -  variavel source
if( $source_upper=="ANOTADOR" ) {
    if( strtoupper(trim($val))=="CODIGOUSP" ) {
        if( strtoupper(trim($m_array))=="OUTRO"  ) {
            echo  "usuario,e_mail| | ";   
        } else {
            $elemento=6;
            include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
            mysql_select_db($db_array[$elemento]);
            $res_pessoa=mysql_query("SELECT  e_mail,"
                                   ."(Select login from $bd_1.usuario where codigousp=".$m_array." ) "
                                   ." as login  FROM $bd_1.pessoa where  "
                                   ."   codigousp=".$m_array);
            //                          
            if( ! $res_pessoa ) {
                //  die('ERRO: Select $bd_1.pessoa - falha: '.mysql_error());  
                $msg_erro .= "Select Tabela pessoa - db/mysql:&nbsp;".mysql_error().$msg_final;
                echo $msg_erro;
                exit();        
            }
            echo  'usuario,e_mail|'.mysql_result($res_pessoa,0,login)."|".mysql_result($res_pessoa,0,e_mail);
            if( isset($res_pessoa) )  mysql_free_result($res_pessoa);
        }
        exit();        
    }
}
///    Tabela do ANOTADOR  cadastrado pelo Orientador  -  variavel val
if( strtoupper($val)=="ANOTADOR" ) {      
     ///  Recebendo dados do FORM e Inserindo
     ///  nas Tabelas ANOTACAO e  PROJETO
     unset($array_temp); unset($array_t_value); $m_erro="";
     $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario     
     ///  $pa_anotador = $_SESSION["array_usuarios"]["anotador"];                 
     $pa_anotador = $array_pa["anotador"];
     include("../includes/dados_campos_form.php");   
     ///  SESSION abaixo para ser usada no include
    $elemento=6;
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    mysql_select_db($db_array[$elemento]);
    $_SESSION["tabela"]="$bd_2.anotador";
    ///   CAMPOS do FORM anotador_cadastrar.php
    $lnprojeto = $arr_nome_val["projeto"]; $lncodigousp = $arr_nome_val["codigousp"];
    $sqlcmd = "Select codigo,(select nome from $bd_1.pessoa where codigousp=$lncodigousp ) as nome "
               ." FROM $bd_2.anotador where codigo=$lncodigousp and cip=$lnprojeto ";
    $resultado = mysql_query($sqlcmd);
    if( ! $resultado ) {
        ///  die('ERRO: Select tabelas anotador e pessoa - falha: '.mysql_error());  
        $msg_erro .= "Select Tabelas anotador e pessoa - db/mysql:&nbsp;".mysql_error().$msg_final;
        echo $msg_erro;
        exit();        
     } 
     $nregs=mysql_num_rows($resultado);
     if( $nregs==1 ) {
         $nome_anotador=mysql_result($resultado,0,"nome");
         $msg_erro .="&nbsp;Esse Anotador: $nome_anotador j&aacute; est&aacute; cadastrado nesse Projeto.".$msg_final;
         echo $msg_erro;               
         exit();                                          
     }  
     ///
    ///  Start a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    ///  Execute the queries 
    ///  mysql_select_db($db_array[$elemento]);
   ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
   $session_tabela = $_SESSION["tabela"];
   mysql_query("LOCK TABLES ".$session_tabela." WRITE  ");
   /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;
   $res_coord = mysql_query("INSERT into ".$session_tabela." (cip,codigo,pa,data) "
            ."  values($lnprojeto,$lncodigousp,$pa_anotador,'$data_atual') "); 
   /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
   mysql_query("UNLOCK  TABLES");
   ///  Complete the transaction 
   if ( $res_coord ) { 
    $lnprojeto = $arr_nome_val["projeto"]; $lncodigousp = $arr_nome_val["codigousp"];
    $sqlcmd = "Select codigo,(select nome from $bd_1.pessoa where codigousp=$lncodigousp ) as nome "
               ." From $bd_2.anotador where codigo=$lncodigousp and cip=$lnprojeto ";
    $resultado = mysql_query($sqlcmd);
    if( ! $resultado ) {
          ///   die('ERRO: Select tabelas anotador e pessoa apos INSERT - falhou: '.mysql_error());  
          $msg_erro .= "Select Tabelas anotador e pessoa apos INSERT - db/mysql:&nbsp;".mysql_error().$msg_final;
          echo $msg_erro;
          exit();        
     } 
     $nregs=mysql_num_rows($resultado);
     if( $nregs==1 ) {
         $nome_anotador=mysql_result($resultado,0,"nome");
         $msg_ok .="<p class='titulo_usp'><br>Anotador:<b> $nome_anotador </b> cadastrado com <b>sucesso</b> nesse Projeto</p><br>".$msg_final;
         echo  $msg_ok;
     }
   } else { 
        ///  mysql_error() - para saber o tipo do erro
        $msg_erro .="&nbsp;Anotador <b>N&Atilde;O</b> foi cadastrado. ERRO = ".mysql_error().$msg_final;
         mysql_query('rollback'); 
         echo $msg_erro;         
   }
   mysql_query('end'); 
   mysql_query('DELIMITER');         
   exit();
}
//    
if( strtoupper($val)=="PROJETO" ) {
    /*	 
         AGORA o Melhor jeito de acertar a acentuacao - htmlentities(utf8_decode
		 e de depois usa o  - html_entity_decode 
    */
	 $campo_nome = htmlentities(utf8_decode($campo_nome));
	 $campo_value = htmlentities(utf8_decode($campo_value));
	 $campo_nome = substr($campo_nome,0,strpos($campo_nome,",enviar"));
	 $array_temp = explode(",",$campo_nome);
 	 $array_t_value = explode(",",$campo_value);
	 $count_array_temp = sizeof($array_temp);
	 for( $i=0; $i<$count_array_temp; $i++ )   $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
	 ///
    ///   Vericando se o NOme se ja esta cadastrado  na Tabela usuario
    ////   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
	$m_titulo=strtoupper(trim($arr_nome_val['titulo']));
	$fonterec=strtoupper(trim($arr_nome_val['fonterec']));	
    $fonteprojid=strtoupper(trim($arr_nome_val['fonteprojid']));    
	$m_autor=strtoupper(trim($arr_nome_val['autor']));
	$_SESSION["numprojeto"]=strtoupper(trim($arr_nome_val['numprojeto']));
	///   MELHOR JEITO PRA ACERTAR O CAMPO NOME
    ///   function para caracteres com acentos passando para Maiusculas
    ///  '/&aacute;/i' => '?',
	///  $m_texto=strtoupper($pessoa_nome);
    $m_titulo = stringParaBusca2($m_titulo);
    $fonterec = stringParaBusca2($fonterec);	
	$m_autor=stringParaBusca2($m_autor);
    $m_titulo =html_entity_decode(trim($m_titulo));
	$fonterec =html_entity_decode(trim($fonterec));
    $fonteprojid=strtoupper(trim($arr_nome_val['fonteprojid']));    
    $m_autor =html_entity_decode(trim($m_autor));

     ///  Corrigir onde tiver strtotime - usado somente para ingles       
     $data_de_hoje = date('d/m/Y');
     $data_de_hoje = explode('/',$data_de_hoje);
     $time_atual = mktime(0, 0, 0,$data_de_hoje[1], $data_de_hoje[0], $data_de_hoje[2]);
     // Usa a fun??o criada e pega o timestamp das duas datas:
     $dt_inicio = explode('/',$arr_nome_val["datainicio"]);
     $time_inicial = mktime(0, 0, 0,$dt_inicio[1], $dt_inicio[0], $dt_inicio[2]);
     ///  $time_final = geraTimestamp($data_final);
     ///  $dt_atual= strtotime($data_de_hoje);
     ///  $dt_inicio= strtotime($arr_nome_val["datainicio"]);
     ///  Variavel para incluir na Tabela anotador no campo PA
     $lnpa = $_SESSION["permit_pa"];
    ///  if( $dt_inicio>$dt_atual ) {
    /*
    if( $time_inicial>$time_atual ) {
        $msg_erro .= "Data do in&iacute;cio do Projeto posterior a data atual.  Corrigir".$msg_final;
        echo $msg_erro;
        exit();
    }
    */
 	/* Converter Data PHP para Mysql   */
	$m_datainicio=$arr_nome_val['datainicio'];
	$m_datainicio=substr($m_datainicio,6,4)."-".substr($m_datainicio,3,2)."-".substr($m_datainicio,0,2);
    $m_final=$arr_nome_val['datafinal'];
    $m_final=substr($m_final,6,4)."-".substr($m_final,3,2)."-".substr($m_final,0,2);
    ///  Verificando campos 
	///  coresponsaveis para incluir na Tabela corespproj
	$m_erro=0;
    $coresponsaveis =$arr_nome_val["coresponsaveis"];  
	if( $coresponsaveis>=1 ) {
	    $n_coresponsaveis=explode(",",$m_array);
		$count_coresp = count($n_coresponsaveis);
		for( $z=0; $z<$count_coresp ; $z++ ) {
		    if( strlen($n_coresponsaveis[$z])<1 ) {
			    $m_erro=1;
				break;
			} 
		}                
	}
	if( $m_erro==1 ) {
	      $msg_erro .= "&nbsp;Falta incluir co-respons&aacute;vel.".$msg_final;
          echo $msg_erro;
		  exit();
	}
	//
	$elemento=5; $elemento2=6; $m_regs=0;
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    ///
	/// Banco de dados
    mysql_select_db($db_array[$elemento]);
	///
    ///  Select -  MySQL
    $result=mysql_query("SELECT  cip,autor FROM $bd_2.projeto WHERE "
	                 ." trim(fonterec)=trim('".$fonterec."')  and  "
					 ." trim(fonteprojid)=trim('".$fonteprojid."') and "
                     ." autor=".$m_autor." and datainicio='$m_datainicio'  ");
	///				 
    /// Verificando se houve erro no Select Tabdla Usuario
    if( ! $result ) {
        /// die("ERRO: Select Tabela projeto  - ".mysql_error());
        $msg_erro .= "Select Tabela projeto - db/mysql:&nbsp;".mysql_error().$msg_final;
        echo $msg_erro;
        exit();        
    }  
    $m_regs=mysql_num_rows($result);
    if( $m_regs>=1 ) {
          $msg_erro .= "&nbsp;Projeto (autor, fonte, processo_no., data_inicio):&nbsp; j&aacute; est&aacute; cadastrado.".$msg_final;
          echo $msg_erro;
		  exit();
 	} else {
    	  //  Continuacao Tabela projeto - BD PESSOAL
          /*   MELHOR jeito de acertar a acentuacao - html_entity_decode    */	
	      mysql_free_result($result);
          //  Caso tenha coautores/coresponsaveis no Projeto
          include("n_cos.php");
		  //  SESSION abaixo para ser usada no include
	      $_SESSION["tabela"]="$bd_2.projeto";
          include("dados_recebidos_arq_ajax.php");  
		  //  Verificando o numero de coresponsaveis/coautores
		  //  INSERIR USUARIO  
    	  mysql_select_db($db_array[$elemento]);
	      //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
		  $result_usu = mysql_query("SELECT codigousp from  $bd_1.usuario where codigousp=$m_autor   ");
          // Verificando se houve erro no Select Tabdla Usuario
          if( ! $result_usu ) {
                //  die("ERRO: Select Tabela usuario   - ".mysql_error());
                $msg_erro .= "Select Tabela usuario - db/mysql:&nbsp;".mysql_error().$msg_final;
                echo $msg_erro;
                exit();        
          }  
		  $m_regs = mysql_num_rows($result_usu); 
          if ( $m_regs<1 ) { 
              $msg_erro .= "Orientador n&atilde;o cadastrado.".$msg_final;
              echo $msg_erro;
              exit();          
          } else {
                $n_erro=0;
                ///  START a transaction - ex. procedure    
                mysql_query('DELIMITER &&'); 
                mysql_query('begin'); 
                //  Execute the queries 
                mysql_select_db($db_array[$elemento]);
                //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
                //   - Use mysql_select_db() ou mysql_query()
                mysql_query("LOCK TABLES $bd_2.projeto WRITE, $bd_2.corespproj WRITE ");
                $sqlcmd="INSERT into $bd_2.projeto  (".$_SESSION["campos_nome"].") values(".$_SESSION["campos_valor"].") ";       
                $success=mysql_query($sqlcmd); 
                //  Complete the transaction 
                if ( $success ) { 
                      ///  Cadastrando na tabela corespproj os coresponsaveis
                      for( $x=0; $x<$count_coresp;  $x++ ) {
                           $result=mysql_query("INSERT into $bd_2.corespproj values(".$m_autor.", ".$_SESSION["numprojeto"].", ".$n_coresponsaveis[$x].")");
                           if( !$result ) {
                                mysql_query('rollback'); 
                                $msg_erro .="&nbsp;CORESP. n&atilde;o foi cadastrado (autor/projeto/coresp):".$m_autor.", ".$_SESSION["numprojeto"].", ".$n_coresponsaveis[$x].mysql_error().$msg_final;
                                mysql_query('rollback'); 
                                echo  $msg_erro;
                           }
                     }
                    if( $result ) {
                         mysql_query('commit');                                  
                    } else { 
                        $n_erro=1;
                        mysql_query('rollback'); 
                    }
                } else {
                    $n_erro=1;
                    mysql_query('rollback'); 
                }              
                mysql_query("UNLOCK  TABLES");
                mysql_query('end'); 
                mysql_query('DELIMITER');
                ///
                if( $n_erro==1 ) {
                     $msg_erro .="&nbsp;Projeto <b>N&Atilde;O</b> foi cadastrado. ERRO#1 = ".mysql_error().$msg_final;
                     echo $msg_erro;               
                     exit();                                  
                } else {
                     //  Incluindo arquivo para a Anotacao do Projeto 
                    //  projeto, autor/orientador e numero da anotacao
                    $m_regs=0;
                    $result_proj=mysql_query("SELECT  cip,autor FROM $bd_2.projeto WHERE "
                                ." trim(fonterec)=trim('".$fonterec."')  and  "
                                ." trim(fonteprojid)=trim('".$fonteprojid."') and "
                                ." autor=".$m_autor." and datainicio='$m_datainicio' and datafinal='$m_final'  ");
                    //                 
                    $m_regs=mysql_num_rows($result_proj);
                    if( $m_regs=1 ) {
                         $projeto_cip=mysql_result($result_proj,0,"cip");       
                         mysql_free_result($result_proj);                       
                         $data_atual=date("Y-m-d H:i:s"); //  Data de hoje e horario  
                         $sqlcmd="INSERT into $bd_2.anotador (cip,codigo,pa,data) values($projeto_cip,$m_autor,$lnpa,'$data_atual')";
                         $res_anotador=mysql_query($sqlcmd); 
                         if( $res_anotador )  {
                              $msg_ok .="<p class='titulo_usp'>&nbsp;Para concluir o Projeto enviar o arquivo em formato PDF.</p>".$msg_final;
                              echo  $msg_ok."falta_arquivo_pdf".$_SESSION["numprojeto"]."&".$m_autor;
                             // Efetiva a transa??o nos duas tabelas (anotacao e projeto)                                    
                         } else {
                            $msg_erro .="&nbsp;Anotador <b>N&Atilde;O</b> foi cadastrado.".mysql_error().$msg_final;
                            echo $msg_erro;                                   
                            exit();
                         }                   
                    } else {
                         $msg_erro .="&nbsp;Projeto <b>N&Atilde;O</b> encontrado.".mysql_error().$msg_final;
                         echo $msg_erro;                                   
                         exit();                          
                    }
                }
                //  FINAL -  TABELA PROJETO  -  BD  REXP
       }                     
    }
	//  FINAL IF TABELA projeto  -  BD  REXP
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
     $i_codigousp =-1;
	 for( $i=0; $i<$count_array_temp; $i++ ) {
         $arr_nome_val[$array_temp[$i]]=$array_t_value[$i];
         // Salvando a posi??o do campo codigousp para criar codigo <0 para usuario de fora da USP
         if (strtoupper(trim($array_temp[$i]))=="CODIGOUSP") $i_codigousp=$i;
     }
	 //  Verificando campos 
    $elemento=5;  $m_regs=0;
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    //  Vericando se o Codigo/USP se ja esta cadastrado na Tabela pessoa
	mysql_select_db($db_array[$elemento]);
    //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
    
    $arr_nome_val['codigousp'] = strlen(trim($arr_nome_val['codigousp']))>0 ? 
            $arr_nome_val['codigousp'] : 0;    
    if ( $arr_nome_val['codigousp']==0) {
        $result=mysql_query("SELECT min(codigousp) as codigo_ult  FROM  $bd_1.pessoa where codigousp<0 ") ;
        if( ! $result ) {
            mysql_free_result($result);          
            die("Falha erro no Select/Atribuir codigoUSP".mysql_error());
        }
        $m_regs=mysql_num_rows($result);
        if ($m_regs>0) {
            $codigo_prx = mysql_result($result,0,'codigo_ult');
        } 
        if (!isset($codigo_prx)) {
            $codigo_prx = 0;
        }
        $codigo_prx += -1;
        mysql_free_result($result);
        $arr_nome_val['codigousp'] = $codigo_prx;
        if( $i_codigousp<0 ) {
            die("ERRO: Falha inesperada criando um NOVO codigo USP.");
        }
        $array_t_value[$i_codigousp] = $codigo_prx;
    }
    
	$result_usu=mysql_query("SELECT codigousp,nome FROM $bd_1.pessoa where codigousp=".$arr_nome_val['codigousp']) ;
	if( ! $result_usu ) {
          mysql_free_result($result_usu);	      
		  die("Falha erro no Select".mysql_error());
	}
    $m_regs=mysql_num_rows($result_usu);
    mysql_free_result($result_usu);
    if(  $m_regs>=1 ) {
           $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;".$arr_nome_val['codigousp']." j&aacute; est&aacute; cadastrado.".$msg_final;
           echo $msg_erro;
    } else {
           ///   Vericando se o NOme se ja esta cadastrado  na Tabela pessoa
           ///   Importante no PHP strtoupper, str trim  e no MYSQL  replace,upper,trim
           ///    Remover os espacos do nome deixando apenas um entre as palavras
           $arr_nome_val['nome'] = trim(preg_replace('/ +/',' ',$arr_nome_val['nome']));            
           ///   ACERTAR O CAMPO NOME, retirando acentua??o e passando para maiusculas
           $pessoa_nome=stringParaBusca2(strtoupper(trim($arr_nome_val['nome'])));
           ///  
           ///  Acertando ACENTOS DO HTML PARA PHP/MYSQL - html_entity_decode
           $pessoa_nome=html_entity_decode(trim($pessoa_nome)); 

           mysql_select_db($db_array[$elemento]);
           ///  SESSION abaixo para ser usada no include
           $_SESSION["tabela"]="pessoa";          
           include("dados_recebidos_arq_ajax.php");  
           ///
           ///  INSERINDO 
           ///  Start a transaction - ex. procedure			   
           mysql_query('DELIMITER &&'); 
           mysql_query('begin'); 
           ///
           $success=mysql_query("insert into $bd_1.pessoa  (".$cpo_nome.") values(".$cpo_valor.") "); 
           ///  Complete the transaction 
           if ( $success ) { 
               mysql_query('commit'); 
               $msg_ok .="<p class='titulo_usp'>&nbsp;".$arr_nome_val['nome']." foi cadastrado.</p>".$msg_final;
               echo $msg_ok;
           } else { 
               mysql_query('rollback'); 
               $msg_erro .="&nbsp;".$arr_nome_val['nome']." n&atilde;o foi cadastrado.".$msg_final;
               echo $msg_erro;	     
           } 
           mysql_query('end'); 
           mysql_query('DELIMITER'); 
		  }
	///  Final - Tabela pessoa 
}  elseif( strtoupper($val)=="USUARIO" ) {
     //  Tabela usuario - BD PESSOAL  Tabela usuario
     //
     unset($array_temp); unset($array_t_value); $m_erro=0;
     //    Dados vindo de um FORM   
     include("../includes/dados_campos_form.php");
     $conta =  sizeof($array_temp);
     //  Verificando campos 
    $elemento=5; 
    include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
    //  Verificando Login e Senha 
    if( strtoupper(trim($arr_nome_val['login']))==strtoupper(trim($arr_nome_val['senha']))  ) {
         $msg_erro .= "ERRO:  Usuário/Login e Senha iguais - corrigir ".$msg_final;
         echo  $msg_erro;
         exit(); 
    }
	 //  Verificando campos 
	//  Verificando se nao existe Usuario com esse login  na Tabela usuario
    $result_usu = mysql_query("SELECT   login  FROM  usuario where "
                        ."  trim(login)=trim('".$arr_nome_val['login']."')");
    if ( ! $result_usu ) {
        $msg_erro .= "&nbsp;Usu&aacute;rio:&nbsp;".$arr_nome_val[login]." - falha no mysql/query:".mysql_error().$msg_final;
         echo $msg_erro;
         exit();
    }
    $m_regs = mysql_num_rows($result_usu);
	mysql_free_result($result_usu);
	if(  $m_regs>=1 ) {
         $msg_erro .= "&nbsp;Usu&aacute;rio:&nbsp;".$arr_nome_val[login]." j&aacute; cadastrado.".$msg_final;
         echo $msg_erro;
	} 
    //  SESSION Tabela para ser usada no include: dados_recebidos_arq_ajax.php
    //  DEsativando
    if( isset($_SESSION["campos_nome"]) )  unset($_SESSION["campos_nome"]);
    if( isset($_SESSION["campos_valor"]) )  unset($_SESSION["campos_valor"]);
    //  Acertando os campos para inserir dados
    $_SESSION["tabela"]="usuario";
    include("dados_recebidos_arq_ajax.php");
    //	
    mysql_select_db($db_array[$elemento]);
    $n_pa = trim($arr_nome_val['pa']);
    //  foreach( $array_usuarios as $key =>$valor ) {
    foreach( $array_pa as $key =>$valor ) {        
          if( $n_pa==$valor  ) {
               $nome_key = $key;
               break;
          }
    }
    //  START  a transaction - ex. procedure    
    mysql_query('DELIMITER &&'); 
    mysql_query('begin'); 
    //  Execute the queries 
    //  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
    //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
    //   - Use mysql_select_db() ou mysql_query()
    // Gera a ativação de codigo com 6 digitos
    $activ_code = rand(100000,999999);

    // echo "cpo_nome=".$cpo_nome."<br>  cpo_valor=".$cpo_valor."<br><br>";
    // exit();
    $success=mysql_query("insert into  usuario "
                ."  (".$cpo_nome.",activation_code) values(".$cpo_valor.",'$activ_code') "); 
    //  Complete the transaction 
    if ( $success ) { 
        $msg_ok .="<p class='titulo_usp'>Usu&aacute;rio:&nbsp;"
        .$arr_nome_val['login']." foi cadastrado.</p>".$msg_final;
        $m_erro=0;      
        mysql_query('commit'); 
    } else { 
        $msg_erro .="Usu&aacute;rio:&nbsp;"
        .$arr_nome_val['login']." n&atilde;o foi cadastrado.".$msg_final;
        echo $msg_erro;   
        $m_erro=1;      
        mysql_query('rollback'); 
    }
    mysql_query('end'); 
    mysql_query('DELIMITER');
    // 
    if( $m_erro<1 ) {
        $res_email = mysql_query("Select e_mail from $bd_1.pessoa where codigousp=".$arr_nome_val['codigousp']." ");
        if( ! $res_email ) {
            mysql_free_result($res_email);          
            die("ERRO: Select pessoa campo e_mail falha: ".mysql_error());
        }  else {
            $usr_email=html_entity_decode(trim(mysql_result($res_email,0,'e_mail')));
            $data['senha'] = $arr_nome_val['senha'];
            mysql_freeresult($res_email);
            //
            $host  = $_SERVER['HTTP_HOST'];
            $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
            $user=$arr_nome_val['codigousp'];
            $m_local="ativar.php?user=".$user."&activ_code=".$activ_code;
            /*
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br>"
            ."<a href='http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code'  title='Clicar' >"
            ."http://$host$new_path/ativar.php?user=$user&activ_code=$activ_code</a>"; 
            */
            $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br>"
                     ."<a href='$retornar$m_local'  title='Clicar' >$retornar$m_local</a>"; 

            //
            //  $host_upper = strtoupper($host);           
            $host_lower = strtolower($host);                     
            //  $assunto =html_entity_decode("Redefini??o de senha");    
            $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
            $corpo ="RGE/SISTAM - Anota??o<br>";
            $corpo .="$host_lower<br><br>";    
            $corpo .=html_entity_decode("Seu cadastro como ".ucfirst($nome_key)." foi realizado.<br>Detalhes do seu registro\r\n");                    
            $user_name = html_entity_decode($arr_nome_val['login']); 
            $headers1  = "MIME-Version: 1.0\n";
            //  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
            $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
            $headers1 .= "X-Priority: 3\n";
            $headers1 .= "X-MSMail-Priority: Normal\n";
            $headers1 .= "X-Mailer: php\n";
            //  $headers1 .= "Return-Path: xxx@...\n";
            //  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
            $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";
            
            //  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
            //  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";                    
            $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
                       
            $message = "$corpo ...\n<br><br>
            Usuário: $user_name<br>
            Email: $usr_email \n<br>
            Senha: $data[senha] \n<br>

            Código de ativação: $activ_code \n<br><br>

            $a_link<br><br>

            ______________________________________________________<br>
            Esta é uma mensagem automática.<br> 
            *** não responda a este EMAIL ****
            ";
            mail($usr_email, stripslashes(utf8_encode($assunto)), $message,$headers1);

            //                          
            /*    $msg_ok .= "<p>Sua senha foi redefinida e uma nova senha foi enviada para seu endere?o de e-mail.<br>"
            ."<a href='$retornar' title='Clicar' >Retornar</a></p>";                         
            */
            $msg_ok .= "<p>Mensagem de Acesso enviada para o email:  $usr_email<br></p>";                         


            echo  $msg_ok;

        }

    }
    exit();                  
}	 
#
ob_end_flush(); /* limpar o buffer */
#
?>