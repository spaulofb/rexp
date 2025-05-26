<?php
/***
*      Recebendo os dados para compilar
*    Arquivo para EDITAR - Tabela setor
***/
ob_start();   /***   Evitando warning    ***/
///
///  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
///  Incluindo SESSION incluir_arq  --  Alterado em 20200917
///    Verificando conexao
require_once("php_include/patrimonio/conectando.php");
///  Caminho principal com os diretorios
$incluir_arq = $_SESSION["incluir_arq"];
///
/***    INCLUINDO CLASS - 
* 
*    Alterado em 20200910
*       PHP 7 
*       Deprecated: __autoload() is deprecated, 
*             use spl_autoload_register() 
****/
///    IMPORTANTE: variavel de erro
$php_errormsg="";
///     Class para funcoes de mensagens 
require_once("{$_SESSION["incluir_arq"]}includes/autoload_class.php");
if( strlen(trim($php_errormsg))>0  )  {
    echo "ERRO: OCORREU UM ERRO ".$php_errormsg;
    exit();
}
$autoload = new Autoload();
$funcoes=new funcoes();
///
extract($_POST, EXTR_OVERWRITE);   
///
$post_array = array("data","val","m_array");
$count_post_array = count($post_array);
for( $i=0; $i<$count_post_array; $i++ ) {
    $xyz = trim($post_array[$i]);                                          
    ///  Verificar strings com simbolos: # ou ,   para transformar em array PHP      
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) {
       if( is_string($_POST[$xyz]) ) {
             $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);   
       }
       ///
       if ( $pos1 === false ) {
           //  $$xyz=trim($_POST[$xyz]);
           //   Para acertar a acentuacao - utf8_encode
           if( is_string($_POST[$xyz]) ) {
               ///  Atualizado em 20200819
               /// $$xyz = utf8_decode(trim($_POST[$xyz]));     
                /// $$xyz = utf8_decode($_POST[$xyz]);     
                $$xyz = $_POST[$xyz];     
           } else if( is_array($_POST[$xyz]) ) {               
               $$xyz = $_POST[$xyz];
           } else {
               $$xyz = (int) $_POST[$xyz];
           }          
       } else {
           $$xyz = explode($div_array_por,$_POST[$xyz]);
           ///  function para acetar acentuacao -  acentuacao.php
           ///   $$xyz=utf8_decode_all($$xyz);  
       } 
    }
}
///                              
$m_data=""; $data_upper=""; $where="";
if( isset($_GET["data"]) ) {
    $m_data=trim($_GET["data"]);
}
if( isset($_POST["data"]) ) {
    $m_data=trim($_POST["data"]);
}
if( isset($m_data) ) {
   if( is_string($m_data)) { 
       $data_upper=strtoupper($m_data);
   }    
}
///
$_SESSION["sessao_data"]=$data;
$val_upper="";
if( ! isset($val) ) {
   $val=""; 
} elseif( isset($val) ) {
   if( is_string($val) ) $val_upper=strtoupper($val); 
}
$_SESSION["val"]=$val;  
///
if( $data!='mostrar_resultado' or $data!='mostrar_resultado2' ) $m_val=$val;     
if ( $val=='coduspresp' ) $m_val="C&oacute;digo/USP" ;
///
/***     Atualizado em  20200929
   ---   Incluir variavel encontrar/tabpri
***/
///   include_once("{$_SESSION["incluir_arq"]}script/var_encontrar.php");
require_once("{$_SESSION["incluir_arq"]}script/var_tabpri.php");
 /// Select/MySQLI - SESSION da conexao
$conex =  $_SESSION["conex"];
///   Acentuacao UTF8
mysqli_set_charset($conex,'utf8');
///
///  Iniciar o campo para consultar - codigo, descricao, etc...
if( $data_upper=="CAMPOS_TABELA" ) {
    /****
    *       ATUALIZADO EM 20210802
    ****/
    $_SESSION["mtit"]="";
    ///
    /// Variavel  val for String
    if( is_string($val) ) {
        ///
        if( preg_match('/\#/',$val) ) {
             $array_val=explode("#",$val);
             ///
             ///  Campo selecionado e tamanho do campo
             $cposel=$array_val[0];
             $_SESSION["campo_selecionado"]=$array_val[0];
             $_SESSION["tam_cpo"]=$array_val[1]."px";
             ///
             ///  Caso for campo Sigla/Codigo
             $_SESSION["mtit"]="{$cposel}";
             preg_match("/^codigo|^ID$|setor/ui",$cposel,$np);
             if( count($np)>0 ) {
                 $_SESSION["mtit"]="sigla";
             }
             ///
        }
    }    
    ///
    ///  Enviando o tamanho do Campo
    if( isset($val_upper) ) unset($val_upper); 
    echo  "{$_SESSION["tam_cpo"]}";
    exit();    
    ///
}
///  Final - if( $data_upper=="CAMPOS_TABELA" ) {
///
///   INICIANDO
if( $val_upper=="INICIANDO" ) {
    ///
    if( ! isset($m_onblur) ) {
        $m_onblur="";    
    } 
    $where="";
    $m_campo_chave="codigo"; 
    $order_by=""; 
    //// $n_fields="";
    ///
    ///  sessao $_SESSION["m_nome_id"]  ->  nome da tabela ou $encontrar
    ///
    /// Nome da coluna  codigo SETOR  da Tabela  
    $codidseto = $_SESSION["codidseto"] ;
    ///
    /// Nome da coluna  nome SETOR  da Tabela  
    $nomeseto = $_SESSION["nomeseto"];
    ///
    /// Nome da coluna  INSTITUICAO  da Tabela  
    $codidinst = $_SESSION["codidinst"];
    ///
    /// Nome da coluna UNIDADE  da Tabela  
    $codidunid = $_SESSION["codidunid"];
    ///
    /// Nome da coluna DEPTO/DEPARTAMENTO da Tabela  
    $codiddept = $_SESSION["codiddept"];
    ///
    ///  INSTITUICAO - valor
    $sig_inst="";
    if( isset($_SESSION["instituicao"]) ) {
        $sig_inst=trim($_SESSION["instituicao"]);  
    } 
    ///
    ///  UNIDADE - valor
    $sig_unid="";
    if( isset($_SESSION["unidade"]) ) {
         $sig_unid=trim($_SESSION["unidade"]);   
    }
    /// 
    if( strlen($sig_inst)>=1 && strlen($sig_unid)>=1 ) {
        /***
       $where=" WHERE clean_spaces(instituicao)=clean_spaces('$sig_inst') and "
                   ." clean_spaces(unidade)=clean_spaces('$sig_unid')   ";                    
       ***/                   
       $where=" WHERE acentos_upper($codidinst)=acentos_upper(\"$sig_inst\") and "
                   ." acentos_upper($codidunid)=acentos_upper(\"$sig_unid\")   ";
       ///            
    } elseif( strlen($sig_inst)>=1 && strlen($sig_unid)<1 ) { 
       $where=" WHERE acentos_upper($codidinst)=acentos_upper(\"$sig_inst\") ";
       ///                    
    } elseif( strlen($sig_inst)<1 && strlen($sig_unid)>=1 ) { 
         $where=" WHERE acentos_upper($codidunid)=acentos_upper(\"$sig_unid\") ";
         ///
    }
    ///
    ///  DEPTO - Departamento
    $sigla_depto="";
    if( isset($_SESSION["depto"]) ) {
         $sigla_depto=trim($_SESSION["depto"]);  
    } 
    ///
    /// Verifica caso NAO encontrar palavra
    if( ! preg_match("/where /i",trim($where)) ) {
         /***  $where=" WHERE clean_spaces(depto)=clean_spaces('$sigla_depto') ";    ***/
          $where=" WHERE acentos_upper($codiddept)=acentos_upper(\"$sigla_depto\") ";  
        ///                
    } elseif( preg_match("/where /i",trim($where)) ) {
       /***   $where.=" and clean_spaces(depto)=clean_spaces('$sigla_depto') ";   ***/
         $where.=" and acentos_upper($codiddept)=acentos_upper(\"$sigla_depto\") ";
        
        ///
    }
    ///
    /***
    $m_campo_chave="sigla";  $order_by=" order by sigla,nome ";     
    ***/
    
    $m_campo_chave="$codidseto";  
    $order_by=" order by $codidseto,$nomeseto ";   
    ///
    $m_campo_chave = trim($m_campo_chave);
    if( preg_match("/^codigo|^codigousp/ui",$m_campo_chave) ) {
         $m_title="C&oacute;digo"; 
         $m_nome_primeiro_campo="C&oacute;digo";
         $order_by=" order by {$m_campo_chave} ";   
         ///
              ////       } elseif( strtoupper(trim($m_campo_chave))=="SIGLA" ) {
    } elseif( preg_match("/sigla|^codset|setor/ui",$m_campo_chave) ) {
         $m_title="Sigla";  
    } 
    ///
    ///
    ///  Banco de dados - BD/DB
    if( ! isset($_SESSION["bd_1"]) ) {
         echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
         exit();
    }
    $bd_1 = $_SESSION["bd_1"];  
    ///
    ///  Conexao BD/DB
    $conex = $_SESSION["conex"];
    ///
    ///  Select/MYSQLI
    $result=mysqli_query($_SESSION["conex"],"SELECT * FROM {$bd_1}.$tabpri  $order_by ");
    ///
    ///  if( ! $result ) {
    if( mysqli_error($conex) ) { 
         $txterr="Falha no select da Tabela $tabpri -&nbsp;db/Mysqli:&nbsp;";
         echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex));   
         exit();
    }
    ///  Nr. Registros
    $tregs = mysqli_num_rows($result);
    ///
    ///  Caso nenhum registro encontrado
    ///  $m_sem_nada="==== Nenhum registro da tabela <b>$tabpri</b> encontrado ====";
    $m_sem_nada="==== Nenhum registro encontrado ====";
    ///
    ///  Verifica Nenhum registro
    if( intval($tregs)<1 ) {
        /***
        *    echo $funcoes->mostra_msg_erro("==== Nenhum registro encontrado dessa Tabela: $tabpri ====");    
        ***/
        ///   $txt="==== Nenhum registro encontrado dessa Tabela: $tabpri ====";
        ////  echo $funcoes->mostra_msg_erro("$txt");    
        echo $funcoes->mostra_msg_ok("<center>$m_sem_nada</center>");    
        exit();      
        ///
    }
    /***  Final -  if( intval($tregs)<1 ) {  ***/ 
    ///
    ///
    ///   $n_fields = mysqli_num_fields($result);
    /// Desativando variaveis -  array name_c_id e len_c 
     if( isset($name_c_id) )  unset($name_c_id);
     if( isset($len_c) )  unset($len_c);
     if( isset($_SESSION["name_c_id"]) ) unset($_SESSION["name_c_id"]);
     if( isset($_SESSION["len_c"]) ) unset($_SESSION["len_c"]);     
     ///
     /// Atualizado em 20230606
     while( $fieldinfo = $result->fetch_field() ) {
             ///  
             $nomecpo=$fieldinfo->name;
             $name_c_id[] = $nomecpo;
             /// Tamanho do Campo length dividido por 3
             $ntam = ($fieldinfo->length);
             ///  $len_c["$nomecpo"] = number_format($ntam,2);
             /***
               *     Atualizado em 20210607
               *    Verificando o tipo do campo da Tabela
               *       Definir tamanho do campo
             ****/
             switch ($fieldinfo->type) {
                 case 3:
                 case 4:
                    /// Campos numericos
                    $len_c["$nomecpo"] = number_format($ntam,0);
                     break;
                 default:
                    /// Campos caracteres
                    $len_c["$nomecpo"] = number_format($ntam/3,0);
                     break;
             }
             /*** Final - switch ($fieldinfo->type) { ***/
             ///
     }
     /**** Final - while( $fieldinfo = $result->fetch_field() ) {  ***/
     ///
     ///  Copia do Array em SESSION
     $_SESSION["name_c_id"]=$name_c_id;
     $_SESSION["len_c"]=$len_c;
     ///
     $m_tit1_select = ucfirst($m_campo_chave); 
     $m_size=60; $m_maxlenght=60;
      ///
      ///  Array campos
      /****
       *       $array_campo_nome=array( "sigla" => "Sigla", "codigo" => "C?digo", 
       *                                "unidade" => "Unidade", "instituicao" => "Institui??o", 
       *                                "nome" => "Nome do Setor", "titulo" => "T?tulo", 
       *                                "vigenciai" => "Vig?ncia Inicial","vigenciaf" => "Vig?ncia Final" );
      ****/    
      $ar_cpo_nm=array( "$codidseto" => "Sigla", "sigla" => "Sigla", "codigo" => "Código", 
                       "$codidunid" => "Unidade", "$codidinst" => "Instituição", 
                       "$nomeseto" => "Nome do Setor", "titulo" => "Título", 
                       "$codiddept" => "Depto",
                       "vigenciai" => "Vigencia Inicial","vigenciaf" => "Vigencia Final" );
      ///
      $_SESSION["ar_cpo_nm"] = $ar_cpo_nm;
      ///
      ///     ATUALIZADO 20230606
      ///
      ///   Criando o Array com campos e valores da Tabela selecionada
      $x = 0;
      if( isset($while_res) ) unset($while_res);
      ///
      ///  Contagem de campos da  Tabela 
      $nr_ncid = count($name_c_id);
      ////   while( $row = mysqli_fetch_array($result_outro, MYSQLI_ASSOC) ) {      
      while( $row = $result->fetch_array(MYSQLI_ASSOC) ) {     
             ///
            ///  Nome dos campos da Tabela
            for( $nt=0; $nt<$nr_ncid; $nt++ ) {
                  $nomekey=$name_c_id[$nt];
                  $valelem = $row["$nomekey"];
                  ////  $while_res["$nomekey"][$x] = $valelem;       
                  $while_res[$x]["$nomekey"] = $valelem;       
            }
            $x++;
      }
      ///
      ///  Primeiro campo da Tabela setor
      if( isset($len_c[$name_c_id[0]]) ) {
           $tamanho_cpo=$len_c[$name_c_id[0]];  
      } 
      /***
      *       ATUALIZADO EM  20230606
      ****/
      ////
?>
<!--  Formulario selecionar Setor  -->                   
    <table id="tabela_setor" width="100%"  >
      <tr style="border: none; vertical-align: middle; " >
        <td align="left" nowrap="nowrap" class="td_normal">
          <table style="margin: 0px; padding: 0px;" >
            <tr style="border: none; vertical-align: middle; " >
              <td  nowrap="nowrap" class="td_normal" style="padding-right: 1.2em;" >
                <!--  INSTITUICAO  --> 
                 <label for="opc_instituicao"  class="td_informacao2" >
                   Institui&ccedil;&atilde;o:</label><br/>
                   <?php
                       ///
                       ///  instituicao
                       /***
                       *      Esta funcao mysql_db_query esta obsoleta  usar  mysql_query
                     ** $result=mysql_db_query($dbname,"SELECT sigla FROM instituicao order by nome");
                     * 
                     *     $result=mysqli_query($_SESSION["conex"],"SELECT sigla,nome FROM {$_SESSION["bd_1"]}.instituicao  "
                                           ." WHERE  clean_spaces(sigla)=clean_spaces('$sig_inst') "
                                           ." order by sigla,nome ");

                     * *****/
                      ///
                     //// Select/MySQLI 
                      $bd_1 = $_SESSION["bd_1"];
                      $txt="SELECT $codidinst,nome FROM {$bd_1}.instituicao ";
                      $txt.=" WHERE acentos_upper($codidinst)=acentos_upper(\"$sig_inst\") ";
                      $txt.=" order by $codidinst,nome ";
                      $result=mysqli_query($_SESSION["conex"],"$txt");
                      ///
                      ///  if( ! $result ) {
                      $conex = $_SESSION["conex"];
                      if( mysqli_error($_SESSION["conex"]) ) {         
                          $txterr="Falha no Select tabela instituicao&nbsp;- db/Mysqli:&nbsp;";
                          echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
                          exit();
                      }
                      ///  Nr. Registros
                      $m_linhas=mysqli_num_rows($result);
                      ///
                   ?>
                   <select name="opc_instituicao"  id="opc_instituicao"  
                         class="cposel"  onfocus="ofocusF(this);"  tabindex="1"   >
                     <?php
                       ////  Caso NAO tenha registro
                      if(  intval($m_linhas)<1 ) {
                          echo "<option value='' >==== Nenhum(a) encontrado(a) ====</option>";
                      } else {
                          /***
                       *  <option value='<?php echo $sig_instit;?>' >=== Sigla - Nome ===</option>
                          ***/
                          ///
                         while( $linha=mysqli_fetch_array($result) ) {
                             ///  $sig_inst=$linha['sigla'];   
                              $sig_inst=$linha["$codidinst"];  
                             /***  IMPORTANTE - para os espacos e caracteres com acentos
                                option deve ser feito desse modo 
                             ***/ 
                              $vn=htmlentities(trim($linha["nome"]));    
                              ///
                              $msgopt="<option value=\"$sig_inst\"  ";
                              $msgopt.=" title=\"{$sig_inst}&nbsp;-&nbsp;$vn\" >";
                              $msgopt.="{$sig_inst}";
                              $msgopt.="</option>";
                              echo  "{$msgopt}"; 
                              ///
                         }
                         /// Final - while( $linha=mysqli_fetch_array($result) ) {
                         ///
                      ?>
                       </select>
                     <?php
                    }
                    ///  Desativando variavel 
                    if( isset($result) ) {
                         mysqli_free_result($result);   
                    } 
                   /// Final -INSTITUICAO
                  ?>
             </td>
                      
             <td align="left" nowrap="nowrap" class="td_normal">
               <!--  UNIDADE  --> 
                 <?php
                     ///
                    ///  UNIDADE
                    ///
                    ///  Select/MYSQLI  - UNIDADE
                      $txt="SELECT $codidunid,nome FROM {$bd_1}.unidade ";
                      $txt.=" WHERE acentos_upper($codidinst)=acentos_upper(\"$sig_inst\") ";
                      $txt.=" and  acentos_upper($codidunid)=acentos_upper(\"$sig_unid\") ";
                      $txt.=" order by $codidinst,$codidunid,nome ";
                      ///
                      $result=mysqli_query($_SESSION["conex"],"$txt");
                      /// 
                      ///  if( ! $result ) {  
                      $conex = $_SESSION["conex"];
                      if( mysqli_error($_SESSION["conex"]) ) {         
                           $txterr="Falha no Select tabela unidade&nbsp;- db/Mysqli:&nbsp;";    
                           echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
                           exit();
                      }
                      ///
                      ///  Nr. Registors
                      $m_linhas = mysqli_num_rows($result);
                      ///
                 ?>
                    <label for="opc_unidade"  class="td_informacao2" >
                      Unidade:</label><br/>
                      <select name="opc_unidade" id="opc_unidade"  
                          class="cposel"  onfocus="ofocusF(this);" tabindex="2" >
                 <?php
                 ////
                  ////  Caso NAO tenha registro
                  if( intval($m_linhas)<1 ) {
                     echo "<option value='' >==== Nenhum(a) encontrado(a) ====</option>";
                  } else {
                      /***
                      *   <option value='<?php echo $sig_unid;?>' >===   Sigla - Nome   ===</option>
                      *****/
                      ///
                      if( isset($linha) ) unset($linha);
                       while( $linha=mysqli_fetch_array($result) ) {       
                              ///   $sig_unid=$linha['sigla'];   
                              $sig_unid=$linha["$codidunid"];  
                              $nome_unidade=trim($linha["nome"]);
                              /****  IMPORTANTE - para os espacos e caracteres com acentos
                                    option deve ser feito desse modo 
                               ****/ 
                               $mopt="<option value=\"$sig_unid\"  ";
                               $mopt.=" title=\"{$sig_unid}&nbsp;-&nbsp;{$nome_unidade}}\" >";
                               $mopt.="{$sig_unid}&nbsp;-&nbsp;{$nome_unidade}";
                               $mopt.="</option>";
                               echo "{$mopt}";
                               ///
                       }
                       ///  Final -  WHILE
                       ///
                 ?>
                  </select>
                 <?php
                     if( isset($result) ) {
                          mysqli_free_result($result);   
                     } 
                     ///
                 }
                 /// FINAL - UNIDADE
                 ///
               ?>                  
              </td>
              </tr>
          </table>
        </td>
       </tr>   
              
       <tr>       
          <td>    
          <table>   
            <tr>
             <td  align="left" nowrap="nowrap"  class="td_normal" style="padding-right: 1.2em;"  >
               <label for="opc_depto"  class="td_informacao2" >
                Departamento:</label><br/>
                  <?php
                      ///
                     ///  DEPARTAMENTO
                     /***
                     *    $result=mysqli_query($_SESSION["conex"],"SELECT sigla,nome FROM {$_SESSION["bd_1"]}.depto order by sigla ");
                     ****/
                     ///  Select/MYSQLI
                     $txt="SELECT $codiddept,nome FROM {$bd_1}.depto WHERE ";
                     $txt.=" acentos_upper($codidinst)=acentos_upper(\"$sig_inst\") and ";
                     $txt.=" acentos_upper($codidunid)=acentos_upper(\"$sig_unid\") and ";
                     $txt.=" acentos_upper($codiddept)=acentos_upper(\"$sigla_depto\")  ";
                     $txt.=" order by $codiddept,nome "; 
                     $result=mysqli_query($_SESSION["conex"],"{$txt}");
                     ///                                
                     /////  if( ! $result ) {
                     if( mysqli_error($_SESSION["conex"]) ) {         
                           $txterr="Falha no Select tabela depto&nbsp;- db/Mysqli:&nbsp;";    
                           echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
                           exit();
                      }
                      ///
                      ///  Nr. Registors
                     $m_linhas = mysqli_num_rows($result);
                     ///
                  ?>
                 <select name="opc_depto" id="opc_depto" 
                       class="cposel"  onfocus="ofocusF(this);" tabindex="3" >
                  <?php
                      ////
                      ///  Caso NAO tenha registro
                     if( intval($m_linhas)<1 ) {
                          echo "<option value='' >==== Nenhum(a) encontrado(a) ====</option>";
                     } else {
                         /***
                         *    <option value='' >=== Sigla - Nome ===</option>
                         ***/
                         ///
                         while( $linha=mysqli_fetch_array($result)) {   
                                ///
                                 /*** if( $linha['sigla']==$m_value_c[7] ) { 
                                     $depto_selected = "selected='selected'";
                                 } else  $depto_selected = "";  
                                 ***/                    
                                 $depto_selected=" selected='selected' ";
                                 /**** 
                                 *     IMPORTANTE - para os espacos e caracteres com acentos 
                                 *      option deve ser feito desse modo  
                                 * 
                                 *  $sigla_depto=$linha['sigla'];
                                 ***/
                                 $sigla_depto=trim($linha["$codiddept"]);    
                                 $nome_depto=trim($linha["nome"]);
                                 /***
                                 *      IMPORTANTE - para os espacos e caracteres com acentos
                                 *       option deve ser feito desse modo 
                                  ***/ 
                                 $msg_opt="<option $depto_selected value=\"$sigla_depto\" ";
                                 $msg_opt.=" title=\"{$sigla_depto}&nbsp;-&nbsp;{$nome_depto}\" >";
                                 $msg_opt.="{$sigla_depto}&nbsp;-&nbsp;{$nome_depto}";
                                 $msg_opt.="</option>";
                                  
                                 /***  
                                  echo '<option  "'.$depto_selected.'"  value="'.$sigla_depto.'" >';
                                  echo  trim($linha['sigla'])."&nbsp;-&nbsp;".htmlentities($nome_depto);
                                  echo "</option>" ;
                                  ***/
                                  echo "{$msg_opt}";
                                  ///
                         }
                         ///  Final - while
                         if( isset($result) ) {
                             mysqli_free_result($result);   
                         }
                         /// 
                     }
                     ///
                     ?>
                    </Select>
               <!--   Final - DEPARTAMENTO   -->             
             </td>
             </tr>
             
             <tr>
             <td  align="left" nowrap="nowrap"  class="td_normal"  >
               <label  for="opc_setor"  class="td_informacao2" >
                Setor:</label><br/>
                   <?php
                      ///                          
                     ///       SETOR
                     ///   Select/MYSQLI
                     /***
                     $result=mysqli_query($_SESSION["conex"],"SELECT sigla,nome FROM {$_SESSION["bd_1"]}.setor "
                                ." WHERE clean_spaces(instituicao)=clean_spaces('$sigla_instituicao') and "
                                ." clean_spaces(unidade)=clean_spaces('$sigla_unidade') and "
                                ."  clean_spaces(depto)=clean_spaces('$sigla_depto') "                                
                                ." order by sigla,nome ");
                     ****/
                     ////           
                     $txt="SELECT $codidseto,$nomeseto FROM {$bd_1}.setor WHERE ";
                     $txt.=" acentos_upper($codidinst)=acentos_upper(\"$sig_inst\") and ";
                     $txt.=" acentos_upper($codidunid)=acentos_upper(\"$sig_unid\") and ";
                     $txt.=" acentos_upper($codiddept)=acentos_upper(\"$sigla_depto\")  ";
                     $txt.=" order by $codidseto,$nomeseto "; 
                     $sqlset=mysqli_query($_SESSION["conex"],"{$txt}");
                     ///  
                    /////  if( ! $sqlset ) {
                     if( mysqli_error($_SESSION["conex"]) ) {         
                           $txterr="Falha no Select tabela setor&nbsp;- db/Mysqli:&nbsp;";    
                           echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
                           exit();
                      }
                      ///
                     ///  Nr. Registros                                  
                     $m_linhas = mysqli_num_rows($sqlset);
                     ///
                   ?>
                    <select name="opc_setor" id="opc_setor"  title="Setor"  onchange="validar('opc_setor',this.value);"      
                       class="cposel"  onfocus="ofocusF(this);" tabindex="4" >
                    <?php
                      ////
                      ///  Caso NAO tenha registro
                     if( intval($m_linhas)<1 ) {
                          echo "<option value='' >==== Nenhum(a) encontrado(a) ====</option>";
                     } else {
                         ?>
                          <option value='' >=== Sigla - Nome ===</option>
                          <?php
                             ///
                            while( $linha=$sqlset->fetch_array(MYSQLI_BOTH) ) {   
                                  /***
                                  *    if( $linha['sigla']==$m_value_c[7] ) { 
                                  *          $depto_selected = "selected='selected'";
                                  *    } else  $depto_selected = ""; 
                                  *
                                  **   IMPORTANTE - para os espacos e caracteres com acentos
                                  **    option deve ser feito desse modo  
                                  ****/
                                  ///  $sigla_setor=$linha['sigla'];   
                                  $sigla_setor=trim($linha["$codidseto"])  ;   
                                 ///  $nome_setor=trim($linha["nome"]);
                                  $nome_setor=trim($linha["$nomeseto"]);
                                  ///
                                  $setor_selected="";
                                  ///
                                  /***  IMPORTANTE - para os espacos e caracteres com acentos
                                  *       option deve ser feito desse modo  
                                  * 
                                  *    echo '<option  value="'.$sigla_setor.'" >';
                                  *    echo  trim($linha['sigla'])."&nbsp;-&nbsp;".htmlentities($nome_setor);
                                  *   echo "</option>" ;
                                  ****/
                                  $msg_opt="<option $setor_selected value=\"$sigla_setor\" ";
                                  $msg_opt.=" title=\"{$sigla_setor}&nbsp;-&nbsp;{$nome_setor}\" >";
                                  $msg_opt.="{$sigla_setor}&nbsp;-&nbsp;{$nome_setor}";
                                  $msg_opt.="</option>";
                                  echo "{$msg_opt}";
                                  ////
                             }
                             /***  Final - while( $linha=$sqlset->fetch_array(MYSQLI_BOTH) ) {   ****/
                             ///
                             /// Desativando variavel
                             if( isset($sqlset) ) {
                                 mysqli_free_result($sqlset);   
                             } 
                             ///
                         }
                         ///
                        ?>
                    </Select>
                 <!--  Final - SETOR  -->             
             </td>             
           </tr> 
         </table>
        </td>
       </tr>   
       
       
       <tr style="border: none; vertical-align: top; margin: 0px; padding: 0px; " >
         <td align="left" nowrap="nowrap" class="td_normal">
           <table style="margin: 0px; padding: 0px;" >
             <tr style="border: none; vertical-align: middle; " >
               <td  nowrap="nowrap" class="td_normal"  >
              <label for="campos_tabela" class="td_informacao2" >
               Campos do Setor:&nbsp;</label>
                <span style="margin-left: 5px;" >
                 <select  name="campos_tabela" id="campos_tabela" 
                        class="cposel"  onfocus="ofocusF(this);"     
                      onchange="dochange('campos_tabela',this.value);" 
                       style=" font-size: small; cursor: pointer;" >
                  <?php 
                     ///       
                    echo "<option value='0'>====   Selecionar   ====</option>";
                    ///
                    $_SESSION["tam_cpo"]="";
                    foreach( $name_c_id as $chave_cpo => $cpo_tb ) {       
                          ///
                          $m_title=$ar_cpo_nm["$cpo_tb"];     
                          ///    
                          $_SESSION["campos_tabela"]=$cpo_tb;
                          $zxcampo_da_tabela["$cpo_tb"]=$len_c[$cpo_tb];
                          $_SESSION["m_title"]=$m_title; 
                          /****
                          *  $zxcampo_da_tabela["$cpo_tb"]=$len_c[$name_c_id[$chave_cpo]];                     $_SESSION["m_title"]=$m_title; 
                          *
                          *     IMPORTANTE - para os espacos e caracteres com acentos
                          *    option deve ser feito desse modo  
                          *    
                          ****/
                          if( preg_match("/$codidseto|^sigla|$nomeseto|^nome/i",$cpo_tb) ) {
                               ///
                               ///  Caso campo for nome
                               if( strtoupper($cpo_tb)=='NOME' ) {
                                    $_SESSION["m_title"] = $m_title="Nome";  
                               } 
                               ///
                               $lencpo=$zxcampo_da_tabela["$cpo_tb"];
                               ///
                               $mval="{$cpo_tb}#{$lencpo}";
                               $lcopt="<option value=\"{$mval}\" >";
                               $lcopt.="{$m_title}</option>";
                               echo "{$lcopt}";
                               ///
                          }   
                          ///
                    }
                    ///  Final - foreach( $name_c_id as $chave_cpo => $cpo_tb ) {
                    ///
                  ?>  
                  </select>
            </span>
         </td>



                      
   <?php
          /***
  echo "ERRO: editar_setor_ajax/620 -->>  SETOR  \$name_c_id count = ".count($name_c_id)." <<<--- \$m_linhas = $m_linhas  <<<---"
         ." \$codidseto = $codidseto  <<-- "
       ."   \$tregs =  = $tregs = <<<---"
     ."   \$bd_1 = $bd_1  <<<---  \$m_title = $m_title  <br/>"
     ." \$m_campo_chave = $m_campo_chave  <<<--- \$where = $where  <br/>  \$sig_inst = $sig_inst  <<--  \$tabpri = $tabpri -->>  \$_SESSION[codidinst] = {$_SESSION["codidinst"]} -->>  {} ";
  exit();
  ****/
                    
                ?>             
             


        
            <td  nowrap="nowrap" class="td_normal"  >
              <!--  Campo para digitar/procurar  -->
                <input type="text"  name="mostrar_resultado"  id="mostrar_resultado" 
                    class="cpoforn1"  onfocus="desativar(); ofocusF(this);"  
                    onkeydown="backspace_yes(event);"   
                      onkeyup="validar('mostrar_resultado', this.value);"    
                     title="Digitar:&nbsp;<?php echo ucfirst($_SESSION["m_title"]);?>" 
                      style="display: none;width: 22em;" 
                        disabled="disabled"  >
               <!--  Final - Campo para digitar/procurar  -->                  
            </td>

            <td nowrap="nowrap" class="td_normal"  id="td_mostrar_resultado" style="display: none;" >
               <!--  Informacao -->
                  <button type="submit" onmouseover="javascript: criarJanela('td_mostrar_resultado')"  class="botao3d"  style="cursor: pointer; width:auto;" ><b>?</b>
                  </button>
               <!--  Final - Informacao -->
            </td>
          </tr>
        </table> 
      </td>
    </tr>   
  </table> 
      <hr style='color: #000000; height: 1px; margin: 0px; padding: 0px; border: 1px #000000 solid; ' >
   <?php   
      ///
      exit();   
     ///                                 
}  
///  FINAL - if( $val_upper=="INICIANDO" ) {
///
$array_tabelas=array("atributo","categoria","depto","grupo","projeto","setor");
if( is_array($data) ) {
    /****
    *    Caso variavel $data for Array 
    ***/
    ////
    $data1_up="";
    if( isset($data[1]) ) {
        $data1_up = strtoupper(trim($data[1]));     
    }
    ///
    ///    Elementos para busca
    $ncpos="/^mostrar_resultado|^opc_(instituicao|unidade|depto|departamento|setor)$/ui";
    if( preg_match("{$ncpos}",$data[1]) ) {
        ///
        ///  Verifica se a variavel esta setada
        $_SESSION["mostra_resultado"]=$data[1];
        ///
        $ncps="/^mostrar_resultado2$|^opc_(instituicao|unidade|depto|departamento|setor)$/ui";    
        if( preg_match("$ncps",$data[1]) ) {
            if( isset($_SESSION["campo_selecionado"]) ) {
                unset($_SESSION["campo_selecionado"]);  
            } 
        } else {
            if( isset($_SESSION["campo_selecionado"]) ) {
                $campo_selecionado=$_SESSION["campo_selecionado"];   
            }    
        }
        ///
        ///  Caso variavel for String
        if( is_string($val) ) {
            ///
            ///  Verifica variavel $val Vazia
            if( strlen(trim($val))<1 ) {
                $terr="Digitar ou Selecionar:&nbsp;";
                $terr.=ucfirst(strtolower($data[0]));
                echo $funcoes->mostra_msg_erro("{$terr}");
                exit();                                      
            } else {
                ///
                ///  Copia do Array SESSION  pra variavel array
                $name_c_id = $_SESSION["name_c_id"];
                $len_c = $_SESSION["len_c"];
                ///
                $txt="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";
                $m_onkeyup="$txt";    
                ///


                     
        /********      
        * 
        *  echo  "ERRO: editar_setor_ajax/846 -->>  SETOR   <<<--- \$campo_selecionado = $campo_selecionado <br/>"
        *         ." \$data[0] = {$data[0]} -->> \$data[1] = {$data[1]}   <<-- "
        *         ." -->> \$val = <b>$val</b> <<<---<br/> \$data1_up = $data1_up  <->  \$bd_1 = $bd_1  <<<---<br/>"
        *         ."  \$tabpri = $tabpri -->>  \$_SESSION[codidinst] = {$_SESSION["codidinst"]} <br/> \$name_c_id count = ".count($name_c_id);
        *     exit();
        * 
        ************/
                     
                     
                     
                     ///  Incluir a Tabela depois da CONSULTA
                     $incluir_arq="{$_SESSION["incluir_arq"]}";
                     $txt="{$incluir_arq}includes/inc_editar_setor_ajax.php";
                     ///  include("$txt");
                     require_once("$txt");
                     ///
                }
                ///             
           }  
           /****  Final - if( is_string($val) ) {  ****/
           ///
    } elseif( in_array($data[0],$array_tabelas) and $data1_up=="M_TABELA_ALTERADA"  ) {
        ///
        ///   Iniciando Tabela
        /***
        *       ALTERANDO DADOS DA  TABELA 
        ****/
        ///  Banco de Dados - BD
        if( ! isset($_SESSION["bd_1"]) ) {
              echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
              exit();
        } 
        $bd_1 = $_SESSION["bd_1"];  
        ///
        /// Conexao do BD/DB
        $conex = $_SESSION["conex"];
        ///
        ////  Definindo SESSION
        $_SESSION["erro"]="";
        ///
        /// Iniciando Tabela
        $_SESSION["tabela"]=$data[0];
        ///
        /// IMPORTANTE - Dados vindo dos campos de um FORM  - melhor maneira  
        $incluir_arq="{$_SESSION["incluir_arq"]}";
        /***
        include("{$_SESSION["incluir_arq"]}includes/dados_campos_form_recebidos.php");    
        ***/
        
        
/***
   echo "ERRO: editar_setor_ajax/897  -->> \$_SESSION[tabela] = {$_SESSION["tabela"]} <br/>"
         ."  \$campo_nome = $campo_nome  <br?> 
                \$campo_value = $campo_value  ";
                exit();
****/

        
        /////   Incluindo arquivo para formatar Dados
        $lpwd="{$incluir_arq}includes/dados_recebidos_setor.php";
        require_once("{$lpwd}");        
        ///
        ///   Verificando ERRO
        if( strlen(trim($_SESSION["erro"]))>0 ) {
            echo  $funcoes->mostra_msg_erro("{$_SESSION["erro"]}");
            exit();
        }
        ///  Final - if( strlen(trim($_SESSION["erro"]))>0 ) {  
        ///
        /// Incluindo registro da Tabela atributo, categoria, depto
        $msg_erro = '';  
        $html_inner= '';    
        /****
        *    Definindo os nomes dos campos recebidos do FORM - variavel arr_nome_val - IMPORTANTE
        ****/
        /// 
        require_once("{$_SESSION["incluir_arq"]}script/foreach_util.php");        
        /// Fecha foreach 
        ///
        ///  Tabela grupo verificando se tem um ponto no final
        if( $data[0]=="grupo"  ) {
            if( isset($codigo) ) {
                 $codigo = utf8_decode(trim($codigo));
                 $length_cod = strlen($codigo);
                 if( intval($length_cod)>=1 ) {
                     ///
                     /// IMPORTANTE - usando regex para buscar somente numeros e pontos
                     preg_match("/[^0-9.]/",$codigo, $resultado); //  Se existe letras
                     if( isset($resultado[0]) ) {
                          echo $funcoes->mostra_msg_erro("Digitar esse C&oacute;digo novamente.");
                          exit();                                      
                     }
                     if( substr($codigo,$length_cod)!="." ) {
                          $codigo=trim($codigo).'.';  
                     } 
                     $valor_campo_1 = $codigo;                                 
                 }
                 ///
            }            
        }
        ///
        /***
        **   Campos da Tabela setor  sigla(setor), depto, unidade e instituicao
        *      dados anteriores
        ***/
        ///  Sigla/Codigo anterior
        $sig_setor_ant="";
        if( isset($_SESSION["sigla_do_setor"]) ) {
            $sig_setor_ant=$_SESSION["sigla_do_setor"];  
        } 
        ///
        ///  Depto anterior
        $depto_do_setor_ant="";
        if( isset($_SESSION["depto_do_setor"]) ) {
            $depto_do_setor_ant=$_SESSION["depto_do_setor"];  
        }
        /// 
        ///  Unidade anterior
        $unid_do_setor_ant="";
        if( isset($_SESSION["unidade_do_setor"]) ) {
            $unid_do_setor_ant=$_SESSION["unidade_do_setor"];  
        } 
        ///
        ///  Instituicao anterior
        $inst_do_setor_ant="";
        if( isset($_SESSION["instituicao_do_setor"]) ) {
             $inst_do_setor_ant=$_SESSION["instituicao_do_setor"];   
        }
        ///
        ///  Banco de dados - BD/DB
        if( ! isset($_SESSION["bd_1"]) ) {
             echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
             exit();
        }
        $bd_1 = $_SESSION["bd_1"];  
        ///
        ///  Conexao BD/DB
        $conex = $_SESSION["conex"];
        ///
        ///  Nome da coluna sigla/codigo na Tabela setor
        $codidseto = $_SESSION["codidseto"];
        ///
        ///  Nome da coluna depto na Tabela setor
        $codiddept = $_SESSION["codiddept"];
        ///
        ///   Nome da coluna unidade na Tabela setor
        $codidunid = $_SESSION["codidunid"];
        ///
        ///   Nome da coluna instituicao na Tabela setor
        $codidinst = $_SESSION["codidinst"];
        ///
        ///   Organizando os campos para alteracao na Tabela projeto            
        $array_cpo_nome=explode(",",$cpo_nome);
        $array_cpo_valor=explode(",",$cpo_valor);       
        $success_antes="UPDATE {$_SESSION["bd_1"]}.$data[0]  ";
        $success_antes.=" SET ";
        $nary_cponome=count($array_cpo_nome);
        for( $ne=0; $ne<$nary_cponome; $ne++ ) {
             ///
             $m_nome_cpo=$array_cpo_nome[$ne];
             if( preg_match("/^int$|^INTEGER$|^TINYINT$|^SMALLINT$|^MEDIUMINT$|^BIGINT$|^FLOAT$|^DOUBLE$|^DECIMAL$/i",$name_type[$m_nome_cpo]) )  {
                  $success_antes.=" $m_nome_cpo=$array_cpo_valor[$ne] ";
             } else {
                 ///
                 if( is_string($array_cpo_valor[$ne]) )  {
                     ///  IMPORTANTE - Trocando esses simbolos por virgula na variavel STRING
                     $array_cpo_valor[$ne]=preg_replace('/\|\#\&\>\|/',',',$array_cpo_valor[$ne]); 
                 }
                 ///  IMPORTANTE USAR procedure clean_spaces para acertar espa?oes na variavel
                 ///  NAO USAR NO UPDATE SET  'clean_spaces'  no campo da Tabela
                 $success_antes.="  $m_nome_cpo=$array_cpo_valor[$ne]";
             }  
             ///  SEMPRE USAR -1 no TOTAL para nao adicionar na variavel , 
             if( $ne<$nary_cponome-1 ) $success_antes.=", ";
        }
        ///  Final - for( $ne=0; $ne<$nary_cponome; $ne++ ) {
        ///
        ///  WHERE pelo codigo da Pessoa Cadastrada
        ///  Procurando pelo Array array_cpo_nome  o nome da Tabela pessoal  do DEPARTAMENTO
        if( preg_match('/(departamento|depto)/i', join(" ",$array_cpo_nome) ,$matches) ) {
             $nome_do_codigo=$matches[0];   
        } 
        ///
        if( isset($matches) ) unset($matches);
        ///
        /// Nome do campo sigla/codigo na Tabela setor
        $codidseto = $_SESSION["codidseto"];
        ///
        /// Nome do campo depto na Tabela setor 
        $codiddept = $_SESSION["codiddept"];
        ///
        /// Nome do campo unidade na Tabela setor 
        $codidunid = $_SESSION["codidunid"];
        ///
        ///  Nome do campo instituicao na Tabela setor 
        $codidinst = $_SESSION["codidinst"];
        ///
        ///  Parte do UPDATE
        $success_antes.=" WHERE ";
        $success_antes.=" acentos_upper({$codidseto})=acentos_upper(\"$sig_setor_ant\") and ";
        $success_antes.=" acentos_upper({$codiddept})=acentos_upper(\"$depto_do_setor_ant\") and  ";
        $success_antes.=" acentos_upper({$codidunid})=acentos_upper(\"$unid_do_setor_ant\") and  ";
        $success_antes.=" acentos_upper({$codidinst})=acentos_upper(\"$inst_do_setor_ant\")   ";
        ///
        /// Verificando se existe duplicata no sigla do setor, depto, unidade e instituicao
     ////   $tab_temp_setor="temporar_setor_sigla";
        $tb_tmp_setor="tmp_tb_setor";
   ////     $_SESSION["t_temp_editar_setor"] = "{$_SESSION["bd_1"]}.$tb_tmp_setor";
        $_SESSION["tmp_edit_setor"] = "{$_SESSION["bd_1"]}.$tb_tmp_setor";
        /***
        *     Caso existir remover Tabela Temporaria
        ****/
        $sql_editar_setor = "DROP TEMPORARY TABLE IF EXISTS  {$_SESSION["tmp_edit_setor"]} ";
        $res_editar_setor=mysqli_query($conex,$sql_editar_setor);
        ////   if( ! $res_editar_setor ) {
        if( mysqli_error($conex) ) { 
             $txterr="Falha no DROP tabela $tb_tmp_setor -&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($_SESSION["conex"]));   
             exit();
        }
        ////  Desativando variavel  $res_editar_setor
        if( isset($res_editar_setor) ) unset($res_editar_setor);
        ///
        ///  Criando Tabela Temporaria
        $sql_es= "CREATE TEMPORARY TABLE  IF NOT EXISTS {$_SESSION["tmp_edit_setor"]}  ";
        $sql_es.="SELECT * FROM {$_SESSION["bd_1"]}.$tabpri ";
        $sql_es.=" WHERE acentos_upper($codidseto)!=acentos_upper(\"$sig_setor_ant\")  and ";
        $sql_es.=" (  acentos_upper($codiddept)=acentos_upper(\"$coddepto\")  and  ";
        $sql_es.="  acentos_upper($codidunid)=acentos_upper(\"$codunidade\")  and ";
        $sql_es.="  acentos_upper($codidinst)=acentos_upper(\"$codinstituicao\") )";
        ///
        $creat_tb_tmp = mysqli_query($_SESSION["conex"],$sql_es);            
        ///  if( ! $creat_tb_tmp ) {
        if( mysqli_error($conex) ) {   
             $txterr="Falha no CREATE TEMPORARY tabela {$_SESSION["tmp_edit_setor"]} -";
             $txterr.="&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($_SESSION["conex"]));   
             exit();              
        }  
        ///
        ///    Select/MYSQLI
        ///
        $txt="SELECT * FROM {$_SESSION["tmp_edit_setor"]} ";
        $txt.=" WHERE  ";
        $txt.=" acentos_upper($codidseto)=acentos_upper(\"$codsetor\")  and  ";
        $txt.=" acentos_upper($codiddept)=acentos_upper(\"$coddepto\")  and  ";
        $txt.="  acentos_upper($codidunid)=acentos_upper(\"$codunidade\")  and ";
        $txt.="  acentos_upper($codidinst)=acentos_upper(\"$codinstituicao\") ";
        
        $result_setor=mysqli_query($_SESSION["conex"],"{$txt}");
        ///
        ///   if( ! $result_setor ) {
        if( mysqli_error($conex) ) {       
            ///
            $txterr="Consultando a Tabela {$_SESSION["tmp_edit_setor"]} -";
            $txterr.="&nbsp;db/Mysqli:&nbsp;";
            echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($_SESSION["conex"]));   
            exit();             
        }  
        ///  Nr. Registros
        $m_regs=mysqli_num_rows($result_setor);
        /// 
        ///  Desativando variavel
        if( isset($result_setor) ) {
             mysqli_free_result($result_setor);  
        } 
        ///
        ///  Caso for um ou varios registros
        if( intval($m_regs)>=1 ) {
            echo $funcoes->mostra_msg_erro("&nbsp;Existe outro Setor com os campos:&nbsp;<br>"
                         ."Setor:&nbsp;<b>$codsetor</b>,&nbsp;"
                         ."Depto:&nbsp;<b>$coddepto</b>,&nbsp;"
                         ."Unidade:&nbsp;<b>$codunidade</b>,&nbsp;"
                         ."Instituição:&nbsp;<b>$codinstituicao</b>"
                         ."&nbsp;j&aacute; est&aacute; cadastrado.");
            exit();                      
        }
        ///

        
                /***
  echo   "  editar_setor_ajax/1111 -->> Continuar  \$m_regs = <b>$m_regs</b>  <<-- <br/>"
         ."  <b>$codinstituicao  -->> $codunidade -->> $coddepto  -->> $codsetor </b>  <<-- "
       ."   \$data[0] = $data[0] --  \$data[1] = $data[1]  <<<---  \$codidseto = $codidseto  <<--"
     ."   \$bd_1 = $bd_1  <<<--- \$sig_setor_ant = <b>$sig_setor_ant</b>   <br/>"
     ." \$depto_do_setor_ant = <b>$depto_do_setor_ant</b>  <<<--- <br/>"
     ." \$unid_do_setor_ant = $unid_do_setor_ant  <<-->> \$inst_do_setor_ant = $inst_do_setor_ant   <<--"
     ."<br/> <b>{$_SESSION["codidseto"]}</b>   \$tabpri = $tabpri -->>  \$_SESSION[codidinst] = {$_SESSION["codidinst"]} -->>  ";
  exit();

   echo  "ERRO: library/editar_setor_ajax.php/539 - <br>  "
            ." - \$success_antes =   <br>"
         ." $success_antes  <br> ";
     exit();         
                         ***/
        


     
        ///  Banco de dados - BD/DB
        if( ! isset($_SESSION["bd_1"]) ) {
             echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
             exit();
        }
        $bd_1 = $_SESSION["bd_1"];  
        ///
        ///  Conexao BD/DB
        $conex = $_SESSION["conex"];
        ///
        /***                                   
        *  - ///  IMPORTANTE 2013
        *     MELHOR MANEIRA DE ENVIAR DADOS DO PHP PARA MYSQL -  UTF8_DECODE  
        *          $codigo = utf8_decode($codigo);
        *          $descricao =utf8_decode($descricao);
        ***/
        /// 
        ///  START  a transaction - ex. procedure    
        mysqli_query($_SESSION["conex"],'DELIMITER &&'); 
        $commit="commit";
        mysqli_query($_SESSION["conex"],'begin'); 
        ///
        ///  Execute the queries 
        /****
        *   $success = mysqli_query($_SESSION["conex"],"insert into pessoa (".$campos.") values(".$campos_val.") "); 
        *     mysqli_db_query - Esta funcao esta obsoleta, nao use esta funcao 
        *       - Use mysqli_select_db() ou mysqli_query()
        ****/
        mysqli_query($_SESSION["conex"],"LOCK TABLES  {$bd_1}.$data[0] UPDATE ");
        ///
        ///  Alterando dados na Tabela
        $success=mysqli_query($_SESSION["conex"],$success_antes);           
        ///
        /// if( ! $success ) {
        if( mysqli_error($_SESSION["conex"]) ) {                                         
            $commit="rollback";
            $txterr="Alterando dados na Tabela $data[0] -&nbsp;db/mysqli:&nbsp;";
            echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex));
            ///
        } elseif( $success ) {
            echo $funcoes->mostra_msg_ok("Cadastro setor alterado.");           
        }
        /*!40000 ALTER TABLE  ENABLE KEYS */;
        mysqli_query($_SESSION["conex"],$commit);
        mysqli_query($_SESSION["conex"],"UNLOCK  TABLES");
        //  Complete the transaction 
        mysqli_query($_SESSION["conex"],'end'); 
        mysqli_query($_SESSION["conex"],'DELIMITER');
        ///
    }
    ///
    exit();
    ///
}
/***  FINAL - if( is_array($data) ) {  ****/
///
///  Caso variavel $data for String
if( is_string($data) ) {
    ///                
    ///  SELECIONADO apenas um registro
    $dataup=strtoupper(trim($data));
    if( $dataup=="SELECIONADO" ) {
        ///
        $_SESSION["mostra_resultado"]="SELECIONADO";
        ///
        ///  nome da tabela
        if( isset($val) ) {
            $tabpri=trim($val);   
        } elseif( ! isset($val) ) {
             echo $funcoes->mostra_msg_erro("Falha na vari?vel");    
             exit();                              
        }
        ///
        ///     $n_fields="";
        /***
        *       Atualizado em 20210930                 
        *
        *   $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
        *   $marray_gp = array("grupo","pessoal");   
        ****/
        ///
        ///  Banco de Dados - BD
        if( ! isset($_SESSION["bd_1"]) ) {
             echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
             exit();
        } 
        $bd_1 = $_SESSION["bd_1"];  
        ///
        /// Conexao
        $conex = $_SESSION["conex"];
        ///
        ///  if( strlen($tabpri)>1 ) {
        ///
        ///  Select/MYSQLI
        $result=mysqli_query($conex,"SELECT * from {$bd_1}.$tabpri limit 0 ");            
        ////   if( ! $result ) {
        if( mysqli_error($conex) ) {     
             $txt="Falha no select da Tabela $tabpri -&nbsp;db/Mysql:&nbsp;";
             echo $funcoes->mostra_msg_erro("{$txt}".mysqli_error($conex)); 
             ////  echo "ERRO: Falha no select da Tabela ".$tabpri.": ".mysqli_error();
             exit();
        }
        /*****
         else {
             ///  Nr. de campos da Tabela
            $n_fields =  mysqli_num_fields($result); 
        }
        *****/
        /////////////////////////////
         /****     
        } else {
             echo $funcoes->mostra_msg_erro("Ocorreu uma falha na vari?vel.");    
             exit();                                          
        }
        ***/
        ///
        ///     ATUALIZADO EM 20210930
        if( isset($name_c_id) )  unset($name_c_id);
        if( isset($len_c) )  unset($len_c);
        if( isset($_SESSION["name_c_id"]) ) unset($_SESSION["name_c_id"]);
        if( isset($_SESSION["len_c"]) ) unset($_SESSION["len_c"]);    
        if( isset($_SESSION["m_value_c"]) ) unset($_SESSION["m_value_c"]);    
        ///
        ///   while( $fieldinfo = mysqli_fetch_field($result) ) {
        while( $fieldinfo = $result->fetch_field() )  {              
                /// Nome do campo
                //// $nome_cpo = $fieldinfo->name;
                $nomecpo = $fieldinfo->name;
                $name_c_id[]  = $nomecpo;
                ///
                /// tamanho do campo
                ///  $ntam = $fieldinfo->max_length;
                /// tamanho do campo
                /// $ntam = $fieldinfo->max_length;
                $ntam = $fieldinfo->length;
                ///   $len_c[] = number_format($ntam*2,2);
                /***
                   *           Correto 
                   *     Atualizado em 20210929
                   *    Verificando o tipo do campo da Tabela
                   *       Definir tamanho do campo
                ****/
                switch ($fieldinfo->type) {
                         case 3:
                         case 4:
                             /// Campos numericos
                            $len_c[] = $tlen = number_format($ntam,0);
                            break;
                         default:
                            /// Campos caracteres
                            $len_c[] = $tlen = number_format($ntam/3,0);
                            break;
                }
                ///  Final - switch ($fieldinfo->type) {
                /// 
                ///  Criando array nome do campo e tamanho do campo
                ////  $len_nomecpo[$nomecpo]=$tlen;
                ///
        } 
        /// Final - while( $row = $rsql->fetch_array() )  { 
        ///  Copia do Array em SESSION
        $_SESSION["name_c_id"]=$name_c_id;
        $_SESSION["len_c"] = $len_c;
        ///
         
         ///
         /****
         $_SESSION["num_cols"]=$n_fields; 
         if( isset($_SESSION["num_cols"]) ) $num_cols=$_SESSION["num_cols"];  
         ****/
         
         
         ////
         $txt="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();"; 
         $m_onkeyup="{$txt}";    
         
         
  /****      
  echo "ERRO: editar_setor_ajax/1175 -->>  COUNT \$name_c_id = ".count($name_c_id)." <<-- \$name_c_id count = ".count($name_c_id)
      ." <<<--- \$len_c = ".sizeof($len_c)."   <<<--- <br/>\r\n "
         ."  <b>\$val = $val  -->>  \$tabpri = $tabpri </b>  <<-- \$codidseto = $codidseto  <<-- "
       ."   \$marray_gp =  = $marray_gp = <<<---"
     ."   \$bd_1 = $bd_1  <<<---  \$m_title = $m_title  <br/>"
     ." \$m_campo_chave = $m_campo_chave  <<<--- \$where = $where  <br/>  \$sig_inst = $sig_inst  <<--  \$tabpri = $tabpri -->>  \$_SESSION[codidinst] = {$_SESSION["codidinst"]} -->>  {} ";
  exit();
  ****/

         
         
         
         
         if( isset($marray_gp) ) {
              if( in_array($tabpri,$marray_gp) ) {
                   $m_onkeyup="javascript:somente_numero(this);";                
              } 
         }
         ///
         //  Incluir a Tabela depois da CONSULTA       
         //// if( strtoupper($tabpri)=="SETOR" ) {
             ///
             $txt="includes/inc_editar_setor_ajax.php";
             ///  include("{$_SESSION["incluir_arq"]}$txt");             
             require_once("{$_SESSION["incluir_arq"]}$txt");             
             ///
         /****    
         } else {
             include("{$_SESSION["incluir_arq"]}includes/inc_consultar_projeto_ajax.php");             
         }
          ****/
         ///
/*****
    echo  "ERRO: library/consultar_atr_cat_gru_ajax.php/35 -  \$data = $data - \$data[0] = $data[0]  <br>"
             ."  -   \$_SESSION[num_cols] = {$_SESSION["num_cols"]}  -   \$val = $val  - \$m_array - $m_array   --  <br>"
             ."   \$m_array[0] = $m_array[0]  --   \$m_array[1] = $m_array[1]  -  \$tabpri = $tabpri ";
        exit();   
        *****/  
        ///
    }
    /*****  Final - if( $dataup=="SELECIONADO" ) {  ***/
    ///
}  
/****   Final -  if( is_string($data) ) {   ***/
#
ob_end_flush(); 
#
?>