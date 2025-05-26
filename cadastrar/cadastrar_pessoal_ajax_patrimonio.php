<?php
/***
*       Recebendo os dados para compilar     
*    Arquivo para CADASTRAR dados na Tabela pessoal
***/
ob_start(); /***   Evitando warning  ***/
///
///  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
/***
*    Header - Functions para busca de acentuacao - extract POST
*                  Verificando conexao
*    IMPORTANTE: Arquivo com comandos para corrigir acentuacao                  
***/  
require_once("{$_SESSION["incluir_arq"]}library/header_e_outros_ajax.php"); 
///
///   IMPORTANTE: Arquivo com comandos para corrigir acentuacao
///   require_once('php_include/patrimonio/library/corrigir_acentos.php');
///        
$post_array = array("data","val","m_array");
$count_post_array = count($post_array);
for( $i=0; $i<$count_post_array; $i++ ) {
    $xyz = trim($post_array[$i]);
    /***  Verificar strings com simbolos: # ou ,   
    *      para transformar em array PHP    
    ***/
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) {
         if( is_string($_POST[$xyz]) ) {
              $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);  
         } 
         ///
         if( $pos1 === false ) {
             ///  $$xyz=trim($_POST[$xyz]);
             ///   Para acertar a acentuacao - utf8_encode
             if( is_string($_POST[$xyz]) ) {
                 /// $$xyz = utf8_decode(trim($_POST[$xyz]));     
                 $$xyz = trim($_POST[$xyz]);     
             } else if( is_array($_POST[$xyz]) ) {               
                 $$xyz = $_POST[$xyz];
             } else {
                 $$xyz = (int) $_POST[$xyz];
             }          
         } else {
             $$xyz = explode($div_array_por,$_POST[$xyz]);
             ///  function para acetar acentuacao -  acentuacao.php
             ///  $$xyz=utf8_decode_all($$xyz);  
         } 
    }
}
/***  Final - for( $i=0; $i<$count_post_array; $i++ ) {  ***/
///
if( isset($_GET["data"]) ) {
    $m_data=trim($_GET["data"]);
}
if( isset($_POST["data"]) ) {
    $m_data=trim($_POST["data"]);
}
///
$_SESSION["sessao_data"]=$data;
$val_upper="";
if( ! isset($val) ) {
     $val=""; 
} elseif( isset($val) ) {
    if( is_string($val) ) {
         $val_upper=strtoupper($val);   
    }
    /// 
}
$_SESSION["val"]=$val;  
///
if( $data!='mostrar_resultado' or $data!='mostrar_resultado2' ) {
     $m_val=$val;       
} 
if ( $val=='coduspresp' ) $m_val="C&oacute;digo/USP" ;
///
///   Incluir variavel encontrar
require_once("{$_SESSION["incluir_arq"]}script/var_encontrar.php");
///
$m_linhas=0; 
if( $val_upper=="INICIANDO" ) {
    ///  FORMULARIO DA TABELA PESSOAL ENCONTRA NO ARQ.  cadastrar/cadastrar_pessoal.php
    exit();                                    
}  
///  FINAL do  if( $val_upper=="INICIANDO" ) {
///
///  Banco de Dados - BD/DB
if( ! isset($_SESSION["bd_1"]) ) {
     echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
     exit();
}
$bd_1 = $_SESSION["bd_1"];   
///
///    Caso a variavel data for Array
if( is_array($data) ) {
    ///
    ///  INCLUIR Dados na Tabela pessoal
    if( isset($data[0]) ) {
         $data1upper = strtoupper($data[1]);
        /// Iniciando Tabela
         $tabela = $_SESSION["tabela"] = trim($data[0]);            
         $data0_upper = strtoupper($tabela);
        if( $data0_upper=="PESSOAL" and $data1upper=="M_TABELA_INCLUIDA" ) {
            /// 
            // IMPORTANTE - Dados vindo dos campos de um FORM  - melhor maneira  
             /*********    ----  Alterado em 20191217  ---    ******/
            /// include("{$_SESSION["incluir_arq"]}includes/dados_cpos_form_recebidos.php");
            //// require_once("{$_SESSION["incluir_arq"]}includes/dados_cpos_form_recebidos_novo.php");
            /// require_once("{$_SESSION["incluir_arq"]}includes/dados_cpos_form_recebidos_novo.php");
            require_once("{$_SESSION["incluir_arq"]}includes/dados_form_recebidos.php");
            /// 
            /// Incluindo registro da Tabela depto
            $msg_erro='';  $html_inner='';    
            ///  Definindo os nomes dos campos recebidos do FORM - variavel arr_nome_val - IMPORTANTE
            ///  Atualizado em 20200128
            $conta=0;
            foreach( $arr_nome_val as $key => $value ) {
                  ///
                  $conta++;
                  $$key=$value;  
                  $nome_campo[$conta]=$key;
                  $valor_campo[$conta]=utf8_decode($value);
                  /// $valor_campo[$conta]=$value;
                   
                  $_SESSION[$key]=utf8_decode($value);
                 ///   $_SESSION[$key]=$value;
                   $array_seleciona[$key]=utf8_decode($value);
                 ////  $array_seleciona[$key]=$value;
                  ///
            }
            /// Fecha foreach 
            ///
            $nome_campo_1 =  trim($nome_campo[1]);
            $valor_campo_1 = trim($valor_campo[1]);
            ///
            ///  Definindo variaveis
            $erro_select=0; $duplicata=0; 
            $m_regs=0;
            $nome_cpo_where="codigousp";
             ///
            ///  Verificando Duplicata do codigousp
            $bd_1 = $_SESSION["bd_1"];
            ///
            /// Select/MySQL - selecionando pelo codigousp
            $mex="SELECT $nome_cpo_where FROM $bd_1.$tabela ";
            $mex.=" WHERE trim($nome_cpo_where)=trim(\"$codigousp\") ";
            $result1=mysqli_query($_SESSION["conex"],"$mex");
            ///
            /////  if( ! $result1 ) {
            if( mysqli_error($_SESSION["conex"]) ) {                    
                ////  $erro_select++;   
                $txt1="Consultando a Tabela $tabela campo $nome_cpo_where - db/mysqli:&nbsp;";
                echo $funcoes->mostra_msg_erro("$txt1".mysqli_error($_SESSION["conex"]));
                exit();             
            } else {
                ///  Nr. de registros
                $m_regs=mysqli_num_rows($result1);
                if( isset($result) ) mysqli_free_result($result1);
                ///
                ///  Verifica nr. de registros maior ou igual a 1 - Duplicatas
                if( intval($m_regs)>=1 ) $duplicata++;
                ///
            }             
            ///  Final -  Verificando codigo
            ///        
            ///  Caso NAO tenha duplicata
            if( intval($m_regs)<1  ) {
                $nome_cpo_where="nome"; 
                ///
                ///  Atualizado em 20200128  --  utf8_ecnode
                $nome = trim(preg_replace('/ +/',' ',utf8_encode($nome)));
                ///
                /***
                *     MELHOR MANEIRA DE ENVIAR DADOS DO PHP PARA MYSQL -  UTF8_DECODE
                *     IMPORTANTE 2013   
                *     
                *      $mex="SELECT $nome_cpo_where FROM  $bd_1.$data[0] ";
                *      $mex.=" WHERE trim($nome_cpo_where)='$nome' ";
                ****/
                $mex="SELECT $nome_cpo_where FROM  $bd_1.$data[0] ";
                $mex.=" WHERE acentos_upper($nome_cpo_where)=acentos_upper(\"$nome\") ";
                $result1=mysqli_query($_SESSION["conex"],"$mex");
                ///
                ////  if( ! $result1 ) {
                if( mysqli_error($_SESSION["conex"]) ) {                        
                    $erro_select++;   
                } else {
                    ///  Nr. de registros
                    $m_regs=mysqli_num_rows($result1);
                    if( isset($result1) )  mysqli_free_result($result1);
                    ///
                    ///  Verifica nr. de registros maior ou igual a 1 - Duplicatas             
                    if( intval($m_regs)>=1 ) {
                         $duplicata++;   
                    }
                    /// 
                }
                ///                
            }
            ///  Final -  Verificando nome      
            ///
            /// Verifica caso NAO tenha registro
            if( intval($m_regs)<1 and intval($erro_select)<1 ) {
                ///  
                /****      Verificando Duplicata do e_mail
                **      Atualizado em 20200128  --  utf8_ecnode
                ****/
                $nome_cpo_where="e_mail";                
                ///
                $e_mail = trim(preg_replace('/ +/',' ',utf8_encode($e_mail)));
                ///
                $mex="SELECT $nome_cpo_where FROM $bd_1.$data[0]  ";
                $mex.=" WHERE acentos_upper($nome_cpo_where)=acentos_upper(\"$e_mail\")  ";
                $result1=mysqli_query($_SESSION["conex"],"$mex");
                ////  if( ! $result1 ) {
                if( mysqli_error($_SESSION["conex"]) ) {                            
                    $erro_select++;   
                } else {
                    ///  Nr. de registros
                    $m_regs=mysqli_num_rows($result1);
                    if( isset($result1) ) mysqli_free_result($result1);
                    ///
                    ///  Verifica nr. de registros maior ou igual a 1 - Duplicatas
                    if( intval($m_regs)>=1 ) $duplicata++;
                    ///
                }   
                ///
            } 
            ///  Final -  Verificando e_mail   
            ///          
            ///  Caso ocorrido erro no Select
            if( intval($erro_select)>0 ) {
                /***  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysqli: ".mysql_error().$msg_final;  
                     echo $msg_erro;  
                ***/
                $txterr="Consultando a Tabela $data[0] campo $nome_cpo_where - db/mysqli:&nbsp;";
                echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($_SESSION["conex"]));
                exit();             
            }
            ///  Duplicata no campo
            if( intval($duplicata)>0 ) {
                 /*** $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;".$arr_nome_val['codigousp']." j&aacute; est&aacute; cadastrado.".$msg_final;
                 echo $msg_erro; 
                 ***/
                ////  $tit_pag = $_SESSION["tit_pag"];
                if( preg_match("/codigo|Código/i", $nome_cpo_where) ) $nome_cpo_where="Código";
                if( preg_match("/nome/i", $nome_cpo_where) ) $nome_cpo_where="Nome";
                if( preg_match("/mail/i", $nome_cpo_where) ) $nome_cpo_where="E_Mail";
                ///
                $txto="&nbsp;Nessa Tabela $tabela o campo $nome_cpo_where";
                $txto.="&nbsp;j&aacute; est&aacute; cadastrado.";
                echo $funcoes->mostra_msg_erro("$txto");
                exit();                                  
            }
            ///
           
/***
    echo  "ERRO: cadastrar_pessoal_ajax/197  --> E_MAIL = $e_mail  \$m_regs = <b>$m_regs</b> <<--  \$bd_1 = $bd_1  --->>>   \$nome_campo_1 = $nome_campo_1 <br/> \$valor_campo_1 = $valor_campo_1 
      <br/>1->   $nome_cpo_where FROM  $bd_1.$data[0]  <br/>  \$cpo_nome  =  $cpo_nome   <br/>2->  \$cpo_valor  =  $cpo_valor  ";
    exit();    
    ***/
    
            
            /***
                  MELHOR MANEIRA DE ENVIAR DADOS DO PHP PARA MYSQL -  UTF8_DECODE 
                  - //  IMPORTANTE 2013
                  if( isset($nome) ) $nome=utf8_decode($nome);          
            ***/
            ///
            ///  Banco de Dados - BD/DB
            $bd_1 = $_SESSION["bd_1"];
            ///  START  a transaction - ex. procedure    
            mysqli_query($_SESSION["conex"],'DELIMITER &&'); 
            $commit="commit";
            mysqli_query($_SESSION["conex"],'begin'); 
            ///  Execute the queries 
            ///  $success = mysqli_query($_SESSION["conex"],"insert into pessoa (".$campos.") values(".$campos_val.") "); 
            ///   mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
            ///   - Use mysql_select_db() ou mysqli_query($_SESSION["conex"],)
            ///
            mysqli_query($_SESSION["conex"],"LOCK TABLES  $bd_1.$tabela INSERT ");
            ///  Inserindo dados na Tabela
      /***      $success=mysqli_query($_SESSION["conex"],"INSERT INTO {$_SESSION["bd_1"]}.$data[0] values('$sigla','$unidade','$instituicao','$nome')");  
            ***/
            $txtsql="INSERT INTO $bd_1.$data[0] (".$cpo_nome.")  values(".$cpo_valor.") ";
            $success=mysqli_query($_SESSION["conex"],"$txtsql");
            ///
            //// if( ! $success ) {
            if( mysqli_error($_SESSION["conex"]) ) {                            
                $commit="rollback";
                $txt="Inserindo dados na Tabela $data[0] - db/mysqli:&nbsp;";
                echo $funcoes->mostra_msg_erro("$txt".mysqli_error($_SESSION["conex"]));
            } elseif( $success ) {
                echo $funcoes->mostra_msg_ok("Cadastro {$tabela} conclu&iacute;do<br/>");           
            }
            /*!40000 ALTER TABLE  ENABLE KEYS */
            mysqli_query($_SESSION["conex"],$commit);
            mysqli_query($_SESSION["conex"],"UNLOCK  TABLES");
            ///  Complete the transaction 
            mysqli_query($_SESSION["conex"],'end'); 
            mysqli_query($_SESSION["conex"],'DELIMITER');
            ///
        }    
        ///  Final - if( $data0_upper=="PESSOAL" and $data1upper=="M_TABELA_INCLUIDA" )
    }  
    ///  FINAL do IF  - INCLUIR Dados na Tabela pessoal
    exit();
}
/*******    Final - if( is_array($data) ) {*****/
///
////  Caso variavel for STRING
if( is_string($data) ) {
    ///
    ///  Destivando variaveis
    if( isset($cpo_nome) ) unset($cpo_nome);
    if( isset($cpo_valor) ) unset($cpo_valor);
    ///
    if( isset($_SESSION["campos_nome"]) ) {
        unset($_SESSION["campos_nome"]);
    }  
    if( isset($_SESSION["campos_valor"]) ) {
        unset($_SESSION["campos_valor"]);
    }  
    ///
    /// Verificando variavel m_array
    if(  !is_array($m_array) and strlen(trim($m_array))<1 ) {
         $txt="Variavel m_array vazia. Corrigir";
         echo $funcoes->mostra_msg_erro("$txt");
         exit();             
    }
    ///  Verifica caso for Array m_array
    if( is_array($m_array) ) {
        ///
        $elementos = count($m_array);
    } elseif( is_string($m_array) ) {
        ///
        $m_array = preg_split("/[,]|[;]/", "$m_array");
        $elementos = count($m_array);
    }
    ///
    $selinst=""; $divuni="";
    $selunid=""; $divdep="";
    ///
    /// Verificar caso Selecionado Instituicao
    if( stripos($data,"instituicao")!==false ) {
        ///
        ///  Nr. de elementos da variavel m_array
        if( intval($elementos)>1 ) {
            ///  Variavel de qual Instituicao selecionada
            $selinst = $m_array[0];
            ///   Variavel para habilitar tag Select Unidade
            $divuni = $m_array[1];
            ///
        }
        ///
        ///  Dados da Tabela unidade com relacionamento com a Tabela instituicao
        $txt="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS ";
        $txt.=" WHERE TABLE_SCHEMA = \"$bd_1\" AND TABLE_NAME = 'unidade'  ";
        $txt.=" AND COLUMN_NAME = \"$val\" ;";  
        $result1=mysqli_query($_SESSION["conex"],"$txt");
        ///
        ///  if( ! $result1 ) {
        $merro=0; $_SESSION["valcodinst"]="";
        if( mysqli_error($_SESSION["conex"]) ) {    
            /***  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysqli: ".mysql_error().$msg_final;  
                 echo $msg_erro;  ***/
             //// $txt="Consultando a Tabela $data[0] campo sigla - db/mysqli:&nbsp;";
             $txt="SELECT COLUMN_NAME TABLE unidade - db/mysqli:&nbsp;";
             $txt.=mysqli_error($_SESSION["conex"]);
             $merro=1;
        } else {
             ///  Nr. de registros
             $nregs=mysqli_num_rows($result1);
             ///
             /// Verifica campo da Tabela instituicao relacionada com Tabela unidade
             if( intval($nregs)<1 ) {
                 $txt="Falha grave campo id/codigo instituicao da Tabela unidade - corrigir.";
                 $merro=1;
             } else {
                 ///                  
                 while($row = mysqli_fetch_array($result1) ) {
                    $codinst[] = $row[0];
                 } 
                 ///  Nome do Campo instituicao na Tabela unidade
                 $_SESSION["valcodinst"] = $valcodinst = $codinst[0];
             }
             ///
        } 
        ///
        /// Caso houve Erro
        if( intval($merro)>0 ) {
             echo $funcoes->mostra_msg_erro("$txt");
             exit();             
        }
        ///  SESSION do valor instituicao
        $_SESSION["selinst"]="";
        ///
        ///   Select/MYSQLI - Tabela unidade
        $txt="SELECT codunidade FROM $bd_1.unidade ";
        $txt.=" WHERE acentos_upper($valcodinst)=acentos_upper(\"$selinst\") ";
        $txt.=" order by nome ";
        $rsqlun=mysqli_query($_SESSION["conex"],"$txt");
        //// if( ! $rsqlun ) {
        if( mysqli_error($_SESSION["conex"]) ) {    
             $txt="Select da Tabela unidade - db/mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txt".mysqli_error($_SESSION["conex"]));
             exit();
        }   
        /// Nr. de registros
        $nregs=mysqli_num_rows($rsqlun);
        if( intval($nregs)<1 ) {
             ///  Instituicao
             $xins=strtoupper(trim($selinst));
             $txt="Nenhuma Unidade encontrada dessa Instituição ($xins).";
             echo $funcoes->mostra_msg_erro("$txt");
             exit();
        } else {
            ///
             /// Nome do primeiro Campo da Tabela unidade
             $fldNmUnid = mysqli_fetch_field_direct($rsqlun, 0)->name;
             ///
             ///  SESSION Instituicao
             $_SESSION["selinst"]="$selinst";
             /****
             *     Tag Select UNIDADE
             ***/
             ///
            ?>
              <span class="td_informacao2" style="font-weight: bold;" >
                      Unidade:<br/>
                      <select name="<?php echo $fldNmUnid;?>"   class="cposel"    
                            id="<?php echo $fldNmUnid;?>"  onfocus="ofocusF(this);"  
                             onmousedown="ocultaid('label_msg_erro');"  
                           onchange="dochange('selunidade',this.id,this.value+',divdep');"   
                             title="Unidade" >
                        <option value='' onkeypress="keyhandler(event);"  >===   Unidade   ===</option>
                       <?php
                          ///        Alterado em  20230523
                          ///  while( $nln=mysqli_fetch_array($rsqlun) ) {   
                          while( $nln=$rsqlun->fetch_row() ) {   
                               /***  if( $nln['sigla']==$m_value_c[6]  ) { 
                               *     $unidade_selected = "selected='selected'";
                               *      } else $unidade_selected = ""; 
                               *      echo "<option $unidade_selected  value=".urlencode($nln['sigla'])." >";
                               ***/                     
                               $unidade_selected = "";                      
                               echo "<option $unidade_selected  value=".urlencode($nln[0])." >";
                               echo  trim($nln[0])."&nbsp;";
                               echo  "&nbsp;</option>" ;
                               ///
                          }
                         ///
                         ///  Desativar variaveis
                         if( isset($rsqlun) ) {
                               mysqli_free_result($rsqlun);  
                         }  
                         if( isset($nln) ) unset($nln);
                         ///
                     ?>
                     </select>
                     </span>
             <?php
        }
        /******   Final - if( intval($nregs)<1 ) {   ****/
        ///
    } 
    /****   Final -  if( stripos($data,"instituicao")!==false ) {****/
    ///
    ///  Verificar caso selecionado unidade
    if( stripos($data,"unidade")!==false ) {
        ///
        ///  Selecionada Unidade
        ///
        ///  Nr. de elementos da variavel m_array
        if( intval($elementos)>1 ) {
            ///  Variavel de qual Instituicao selecionada
            $selunid = $m_array[0];
            ///   Variavel para habilitar tag Select Depto
            $divdep = $m_array[1];
            ///
        }
        ///  Codigo instituicao
        $valcodinst = $_SESSION["valcodinst"];
         ///
        /***
        *    Dados da Tabela depto relacionamento com as 
        *        Tabelas instituicao  e  unidade
        ***/
        $txt="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS ";
        $txt.=" WHERE TABLE_SCHEMA = \"$bd_1\" AND TABLE_NAME = 'depto'  ";
        $txt.=" AND ( COLUMN_NAME=\"$val\" or COLUMN_NAME=\"$valcodinst\" );";
        $result1=mysqli_query($_SESSION["conex"],"$txt");
        ///
        ///  if( ! $result1 ) {
        $merro=0;
        if( mysqli_error($_SESSION["conex"]) ) {    
            /***  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysqli: ".mysql_error().$msg_final;  
                 echo $msg_erro;  ***/
            //// $txt="Consultando a Tabela $data[0] campo sigla - db/mysqli:&nbsp;";
            $txterr="SELECT COLUMN_NAME TABLE depto - db/mysqli:&nbsp;";
            $txterr.=mysqli_error($_SESSION["conex"]);
            $merro=1;
        } else {
            ///  Nr. de registros - Campos da Tabela depto
            $nregs=mysqli_num_rows($result1);
             /***
             *    A funcao mysqli_num_fields() retorna o numero de 
             *     campos (colunas) em um conjunto de resultados.
            ***/
            $ncpos=mysqli_num_fields($result1);
            /// Verifica campo da Tabela instituicao relacionada com Tabela unidade
            if( intval($nregs)<1 ) {
                 $txterr="Falha grave campo id/codigo da Tabela depto - corrigir.";
                 $merro=1;
            } else {                                           
                 ///                  
                 /// Nr. de campos por registro
                 if( intval($ncpos)==1 ) {
                     ///
                     while($row = mysqli_fetch_array($result1) ) {
                          if( stripos($row[0],"unid")!==false ) {
                                $codunid[] = $row[0];  
                          } 
                     } 
                     ///  Nome do Campo instituicao na Tabela unidade
                     $valcodinst = "";
                     if( isset($_SESSION["valcodinst"])) $valcodinst = $_SESSION["valcodinst"];
                     ///
                     $valcodunid = "";
                     if( isset($codunid[0]) ) {
                          $_SESSION["valcodunid"] = $valcodunid = $codunid[0];    
                     } else {
                         $txterr="Falha grave campo id/codigo instituicao da Tabela unidade";
                         $txterr.=" - corrigir.";
                         $merro=1;
                     }
                     ///
                 }
                 /****   Final - if( intval($ncpos)==1 ) {  ***/
                 ///
            }
            ///
            /// Caso houve Erro
            if( intval($merro)>0 ) {
                  echo $funcoes->mostra_msg_erro("$txterr");
                  exit();             
            }
            ///  SESSION do valor unidade
            $_SESSION["selunid"]="";
            ///
            ///   SESSION com a Instituicao selecionada
            if( isset($_SESSION["selinst"])  ) {
                 $selinst = $_SESSION["selinst"];   
            } else {
                 $txterr="Falha grave SESSION da Instituição indefinida - corrigir.";
                 echo $funcoes->mostra_msg_erro("$txterr");
                 exit();             
            }
            ///
            ///  Desativar variavel
            if( isset($result) ) {
                  mysqli_free_result($result);   
            } 
            ///
             ///   Depto/Departamento
             ///  
            $bd_1 = $_SESSION["bd_1"]; 
            $nregs=0;
            /***
                 $result=mysqli_query($_SESSION["conex"],"SELECT sigla,nome FROM $bd_1.depto order by sigla ");                    * 
            ***/
            ///    Select/MYSQLI - Tabela depto                       
            $txt="SELECT coddepto,nome FROM $bd_1.depto ";
            $txt.=" WHERE acentos_upper($valcodinst)=acentos_upper(\"$selinst\") ";
            $txt.=" AND ";
            $txt.="  acentos_upper($valcodunid)=acentos_upper(\"$selunid\") ";
            $txt.=" order by 1 ";
            $result=mysqli_query($_SESSION["conex"],"$txt");
            ////
            if( mysqli_error($_SESSION["conex"]) ) {    
                 $txt="ERRO: Select da Tabela depto - db/mysqli:&nbsp;";
                 echo "$txt".mysqli_error($_SESSION["conex"]);
                 exit();
            }                   
            ///
            /// Nr. de registros
            $nregs=mysqli_num_rows($result);
            ///
            if( intval($nregs)<1 ) {
                ///  Instituicao
                 $xinst=strtoupper(trim($selinst));
                 ///   Unidade
                 $xunid=strtoupper(trim($selunid));
                 ///
                 $txt="Nenhum Departamento encontrado dessa";
                 $txt.="&nbsp;Instituição ($xinst) e Unidade ($xunid).";
                 echo $funcoes->mostra_msg_erro("$txt");
                 exit();
            } else {
                 ///
                 /// Nome do primeiro Campo da Tabela depto
                 $fldNmDept = mysqli_fetch_field_direct($result, 0)->name;
                 ///
                 ///  SESSIONs de campos codigos
                 $_SESSION["valcodinst"] = $valcodinst;
                 $_SESSION["valcodunid"] = $valcodunid;
                 ///
                 ///  SESSIONs de valores dos campos acima
                 $_SESSION["selinst"] = $selinst;
                 $_SESSION["selunid"] = $selunid;
                 /****
                 *     Tag Select DEPTO
                 ***/
                 ///
                 ?>
                 <!--  DEPTO/Departamento  -->     
                 <span class="td_informacao2" style="font-weight: bold;" >
                     Departamento:<br/>                 
                   <select name="<?php echo $fldNmDept;?>"   class="cposel"      
                         id="<?php echo $fldNmDept;?>"   onfocus="ofocusF(this);"  
                           onmousedown="ocultaid('label_msg_erro');"  
                          onchange="dochange('seldepto',this.id,this.value+',divset');"  
                          title="Departamento"   >      
                 <option value='' onkeypress="keyhandler(event);"  >===   Departamento   ===</option>
                       <?php
                         /// 
                         while( $zln=mysqli_fetch_row($result) ) {   
                               /***  if( $zln['sigla']==$m_value_c[5]  ) { 
                               *     $depto_selected = "selected='selected'";
                               *    } else  $depto_selected = ""; 
                              ****/
                              $depto_selected = ""; 
                              echo "<option $depto_selected  value=".urlencode($zln[0])." >";
                              echo  trim($zln[0])."&nbsp;-";
                              ///  echo  "&nbsp;".htmlentities($zln['nome'])."</option>" ;
                              echo  "&nbsp;".$zln[1]."</option>" ;
                         }
                         ///   
                         ///  Desativando a variavel result
                         if( isset($result) ) {
                               mysqli_free_result($result);   
                         } 
                         ///
                     ?>
                   </select>
                 </span>
                <!--  Final - DEPTO/Departamento  -->
                <?php
            }
            ///
        }
        ///
    }
    /******  Final - if( stripos($data,"unidade")!==false ) {   ***/
    ///
    ///  Verificar caso selecionado departamento
    if( preg_match("/departamento|depto/ui",$data) ) {
        /****
        *      Selecionado Depto/Departamento
        ***/
        ///   Nr. elementos da variavel m_array
        if( intval($elementos)>1 ) {
            ///  Variavel de qual Instituicao selecionada
            $_SESSION["seldept"] = $seldept = $m_array[0];
            ///   Variavel para habilitar tag Select Depto
            $divset = $m_array[1];
            ///
        }
        ///
        $merro=0;
        ///  Codigo instituicao
        if( !isset($_SESSION["valcodinst"]) ) {
            $txterr="SESSION valcodinst indefinida - corrigir.";
            $merro=1;
        }
        ///  Codigo unidade
        if( !isset($_SESSION["valcodunid"]) ) {
            $txterr="SESSION valcodunid indefinida - corrigir.";
            $merro=1;
        }
        ////  Verificando se houve Erro
        if( intval($merro)>0 ) {
            echo $funcoes->mostra_msg_erro("$txterr");
            exit();
        }
        ///  Codigo instituicao
        $valcodinst = $_SESSION["valcodinst"];
        ///  Codigo unidade
        $valcodunid = $_SESSION["valcodunid"];
        ///
        ///  Codigo depto/departamento
         $valcoddept = "";
         if( isset($_SESSION["valcoddept"]) ) unset($_SESSION["valcoddept"]);
         if( strlen($val)<1  ) {
             $txt="Falha grave variavel val indefinida - Depto - corrigir.";
             echo $funcoes->mostra_msg_erro("$txt");
             exit();
         } 
         $_SESSION["valcoddept"] = $valcoddept = $val;
         ///
         /***
        *    Dados da Tabela setor relacionamento com as 
        *        Tabelas instituicao, unidade e depto
        ***/
        $txt="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS ";
        $txt.=" WHERE TABLE_SCHEMA = \"$bd_1\" AND TABLE_NAME = 'setor'  ";
        $txt.=" AND ( COLUMN_NAME=\"$valcoddept\" OR COLUMN_NAME=\"$valcodinst\" OR ";
        $txt.=" COLUMN_NAME=\"$valcodunid\"  );";
        $result1=mysqli_query($_SESSION["conex"],"$txt");
        ///
        ///  if( ! $result1 ) {
        $merro=0;
        if( mysqli_error($_SESSION["conex"]) ) {    
            /***  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysqli: ".mysql_error().$msg_final;  
            *     echo $msg_erro;  
            ***/
             //// $txt="Consultando a Tabela $data[0] campo sigla - db/mysqli:&nbsp;";
             $txterr="SELECT COLUMN_NAME TABLE setor - db/mysqli:&nbsp;";
             $txterr.=mysqli_error($_SESSION["conex"]);
             $merro=1;
        } else {
              ///  Nr. de registros - Campos da Tabela depto
             $nregs=mysqli_num_rows($result1);
             /***
             *       A funcao mysqli_num_fields() retorna o numero de 
             *     campos (colunas) em um conjunto de resultados.
             ***/
             $ncpos=mysqli_num_fields($result1);
             /// Verifica campo da Tabela instituicao relacionada com Tabela unidade
             if( intval($nregs)<1 ) {
                 $txterr="Falha grave campo id/codigo da Tabela setor - corrigir.";
                 $merro=1;
             }
             ///
        }
        ///
         ///   SESSION com a Instituicao selecionada - dados
         if( isset($_SESSION["selinst"])  ) {
             $selinst = $_SESSION["selinst"];   
         } else {
             $txterr="Falha grave SESSION da Instituição indefinida - corrigir.";
             $merro=1;
         }
         ///   SESSION com a Unidade selecionada - dados
         if( isset($_SESSION["selunid"])  ) {
             $selunid = $_SESSION["selunid"];   
         } else {
             $txterr="Falha grave SESSION da Unidade indefinida - corrigir.";
             $merro=1;
         }
         ///   SESSION com o Depto selecionado - dados
         if( isset($_SESSION["seldept"])  ) {
             $seldept = $_SESSION["seldept"];   
         } else {
             $txterr="Falha grave SESSION do Depto indefinida - corrigir.";
             $merro=1;
         }
         ///
         /// Caso houve Erro
         if( intval($merro)>0 ) {
             echo $funcoes->mostra_msg_erro("$txterr");
             exit();             
         }
         ///
         ///  Desativando a variavel result
         if( isset($result) )  mysqli_free_result($result); 
         ///
        ///  SETOR
         $bd_1 = $_SESSION["bd_1"]; 
         $regs=0;
         ///
         ///    Select/MYSQLI  - Tabela setor                       
         $txt="SELECT codsetor,nome FROM $bd_1.setor ";
         $txt.=" WHERE acentos_upper($valcodinst)=acentos_upper(\"$selinst\") ";
         $txt.=" AND ";
         $txt.="  acentos_upper($valcodunid)=acentos_upper(\"$selunid\") ";
         $txt.=" AND ";         
         $txt.="  acentos_upper($valcoddept)=acentos_upper(\"$seldept\") ";         
         $txt.=" order by 1 ";
         $ressql=mysqli_query($_SESSION["conex"],"$txt");
         ////  if( ! $result ) {
         if( mysqli_error($_SESSION["conex"]) ) {        
              $txt="ERRO: Select da Tabela setor - db/mysqli:&nbsp;";
              echo "$txt".mysqli_error($_SESSION["conex"]);
              exit();
         } 
        ///
        /// Nr. de registros
        $regs=mysqli_num_rows($ressql);
         ///
         ////  $regs = $ressql->num_rows;
         /// Tetorna o Nr. de campos do resultado - Select/Mysqli 
         /****
         $fieldcount=mysqli_num_fields($ressql);
         $dados="ERRO:  linha/736 ";
         while( $row = mysqli_fetch_row($ressql) ) {
             for( $i=0; $i<$fieldcount; $i++ ) {
                  $dados.=" {$row[$i]}  ";         
             }
             $dados.="<br/>";
         }
         ****/
        if( intval($regs)<1 ) {
            ///
            ///  Instituicao
            $xinst=strtoupper(trim($selinst));
            ///   Unidade
            $xunid=strtoupper(trim($selunid));
            ///   Depto/Departamento
            $xdept=strtoupper(trim($seldept));
            ///
            $txt="Nenhum Setor encontrado dessa";
            $txt.="&nbsp;Instituição ($xinst), Unidade ($xunid) e Departamento ($xdept).";
            echo $funcoes->mostra_msg_erro("$txt");
            exit();
        } else {
            ///
            /// Nome do primeiro Campo da Tabela depto
            $fieldNameSet = mysqli_fetch_field_direct($ressql, 0)->name;
            /***
            *      Tag Select SETOR
            ***/
             ///
             ?>
            <!--  SETOR  -->
             <span class="td_informacao2" style="font-weight: bold;" >
                  Setor:<br/>
               <select name="<?php echo $fieldNameSet;?>"   class="cposel"  
                       id="<?php echo $fieldNameSet;?>"  onfocus="ofocusF(this);"  
                        onmousedown="ocultaid('label_msg_erro');"  
                        onchange="dochange('selsetor',this.id,this.value+',semdiv');"  
                          title="Setor"  >      
                      <option value=''  onkeypress="keyhandler(event);"  >===   Setor   ===</option>
                       <?php
                          ///        Alterado em  20190827
                         /// while( $linha=mysqli_fetch_array($result) ) {   
                         while( $linha=mysqli_fetch_row($ressql) ) {   
                              /***   if ( $linha['sigla']==$m_value_c[4]  ) { 
                              *     $setor_selected = "selected='selected'";
                              *   } else  $setor_selected = ""; 
                             ***/                    
                             $setor_selected = "";                      
                             $setor_sigla=trim($linha[0]);
                             if( preg_match("/Chefia/i",$linha[1]) ) {
                                  continue;    
                             }
                             echo '<option $setor_selected  value="'.$setor_sigla.'" >';
                             echo  $setor_sigla."&nbsp;-";
                             ///  echo  "&nbsp;".htmlentities($linha['nome'])."</option>" ;
                             echo  "&nbsp;".$linha[1]."</option>" ;
                             ///
                         }
                     ///      
                     ///  Desativando variaveis
                     if( isset($ressql) ) {
                           mysqli_free_result($ressql);   
                     } 
                     if( isset($regs) ) unset($regs);        
                     ///
                    ?>
                    </select>
                   </span>
                  <!--  Final - SETOR  -->                    
             <?php
        }
        ///   Final - if( intval($nregs)<1 ) {
        ///
    }    
    /*****    Final - if( preg_match("/departamento|depto/ui",$data) ) { ****/
    ///
}
/******     FINAL - if( is_string($data) ) {  *******/
#
ob_end_flush(); 
#
?>