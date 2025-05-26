<?php
//  Recebendo os dados para compilar
//
//   Arquivo para EDITAR Tabela instituicao
//
ob_start(); /* Evitando warning */
/*  Verificando se SESSION_START - ativado ou desativado
    Header - Functions para busca de acentuacao - extract POST
    Verificando conexao
*/  
//  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
/*
    Header - Functions para busca de acentuacao - extract POST
    Verificando conexao
*/  
include("{$_SESSION["incluir_arq"]}library/header_e_outros_ajax.php");  
//
$post_array = array("data","val","m_array");
$count_post_array = count($post_array);
for( $i=0; $i<$count_post_array; $i++ ) {
    $xyz = trim($post_array[$i]);
    //  Verificar strings com simbolos: # ou ,   para transformar em array PHP    
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) {
       if( is_string($_POST[$xyz]) ) $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);
       if ( $pos1 === false ) {
           //  $$xyz=trim($_POST[$xyz]);
           //   Para acertar a acentuacao - utf8_encode
           if( is_string($_POST[$xyz]) ) {
               $$xyz = utf8_decode(trim($_POST[$xyz]));     
           } else if( is_array($_POST[$xyz]) ) {               
               $$xyz = $_POST[$xyz];
           } else {
               $$xyz = (int) $_POST[$xyz];
           }          
       } else {
           $$xyz = explode($div_array_por,$_POST[$xyz]);
           //  function para acetar acentuacao -  acentuacao.php
           $$xyz=utf8_decode_all($$xyz);  
       } 
    }
}
//
$m_data=""; $data_upper="";
if( isset($_GET['data']) ) {
    $m_data=trim($_GET['data']);
}
if( isset($_POST['data']) ) {
    $m_data=trim($_POST['data']);
}
if( isset($m_data) ) {
   if( is_string($m_data)) { 
       $data_upper=strtoupper($m_data);
   }    
}
/*
$pos1 = stripos($m_data,",");
if( $pos1>=0 ) {
     # $array is your array
     $data = explode(",",$m_data); 
} else $data=$m_data;
*/
//
$_SESSION["sessao_data"]=$data;
$val_upper="";
if( ! isset($val) ) {
   $val=""; 
} elseif( isset($val) ) {
   if( is_string($val) ) $val_upper=strtoupper($val); 
}
$_SESSION["val"]=$val;  
//
if( $data!='mostrar_resultado' or $data!='mostrar_resultado2' ) $m_val=$val;     
if ( $val=='coduspresp' ) $m_val="C&oacute;digo/USP" ;
//
//   Incluir variavel encontrar
include("{$_SESSION["incluir_arq"]}script/var_encontrar.php");
//
$total_registros_encontrados=0; 
//  Iniciar o campo para consultar - codigo, descricao, etc...
if( $data_upper=="CAMPOS_TABELA" ) {
    if( isset($val) ) {
       if( is_string($val) ) {
           if( preg_match('/\#/',$val) ) {
               $array_val=explode("#",$val);
               //  Campo selecionado e tamanho do campo
               $_SESSION["campo_selecionado"]=$array_val[0];
               $_SESSION["tamanho_do_campo"]=$array_val[1]."px";
           }
       }    
    }
    //  Enviando o tamanho do Campo
    echo  "{$_SESSION["tamanho_do_campo"]}";
    exit();    
}
//
if( $val_upper=="INICIANDO" ) {
    $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
    $marray_gp = array("grupo","pessoal"); 
    if( ! isset($m_onblur) ) $m_onblur="";
    $m_campo_chave=""; $order_by=""; $where="";
    if( isset($encontrar) ) {
        $n_fields="";
        if( strlen($encontrar)>1 ) {
            //  sessao $_SESSION["m_nome_id"]  ->  nome da tabela ou $encontrar
           if( preg_match("/^instituicao/i",$encontrar) ) $m_campo_chave="sigla";
           if( preg_match("/^codigo|^codigousp/i",strtoupper(trim($m_campo_chave))) ) {
               $m_title="C&oacute;digo";  $m_nome_primeiro_campo="C&oacute;digo";
           } elseif( strtoupper(trim($m_campo_chave))=="SIGLA" ) $m_title = "Sigla";
           if( strlen(trim($m_campo_chave))>1 ) $order_by=" order by $m_campo_chave ";           
           //
           if( $encontrar=="grupo" ) { 
                 //   $m_campo_chave="concat(length(SUBSTRING_INDEX(codigo,'.',1)),codigo)"  ; 
                 $m_nome_primeiro_campo="Descri&ccedil;&atilde;o"; 
                 $m_nome_segundo_campo ="Descri&ccedil;&atilde;o"; 
                 $result=mysql_query("SELECT * FROM  {$_SESSION["bd_1"]}.$encontrar order by  "
                       ."  concat(length(SUBSTRING_INDEX(codigo,'.',1)),codigo)  ");           
           } else {
                 //  Select para a Tabela instituicao
                 if( isset($_SESSION["instituicao"]) ) {
                      $lc_instituicao=$_SESSION["instituicao"];
                      $where="  WHERE  clean_spaces(sigla)=clean_spaces('$lc_instituicao') ";  
                 } 
                 $result=mysql_query("SELECT * FROM {$_SESSION["bd_1"]}.$encontrar  $where ");
           }
           if( ! $result ) {
                echo $funcoes->mostra_msg_erro("Falha no select da Tabela $encontrar - db/Mysql:&nbsp; ".mysql_error());
                //  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                exit();
           }
           $total_registros_encontrados = mysql_num_rows($result);
           if( $total_registros_encontrados<1 ) {
               echo $funcoes->mostra_msg_erro("==== Nenhum registro encontrado dessa Tabela: $encontrar ====");    
               exit();      
           }  else {
                   //  numero de campos
                  $n_fields = mysql_num_fields($result);
                  for( $i=0; $i<$n_fields ; $i++ )  {
                        $nome_cpo_id[$i] = trim(mysql_field_name($result,$i));   
                        $nome_do_cpo=$nome_cpo_id[$i];
                        //  Tamanho do campo da Tabela
                        $len_c[$i] = mysql_field_len($result,$i);
                       //  Criando array nome do campo e tamanho do campo
                       $len_nomecpo[$nome_do_cpo]=$len_c[$i];
                        //  Para colocar os dados na Lista da Consulta
                       //  $_SESSION["m_value_cpo"][$i]=mysql_result($result_outro,0,$i); 
                  }
                  //   Instituicao do usuario 
                  if( isset($_SESSION["instituicao"]) ) {
                          $sigla=mysql_result($result,0,"sigla");
                          $nome=mysql_result($result,0,"nome");
                          echo $funcoes->mostra_msg_ok("==== Institui??o: $sigla - $nome (Altera??o não permitida) ====");    
                          exit();      
                  }    
                  //
                  $m_tit1_select = ucfirst($m_campo_chave); $m_size=60; $m_maxlenght=60;
                  $array_campo_nome=array( "sigla" => "Sigla", "nome" => "Nome da Institui??o");
                  $_SESSION["array_cpo_nome_instit"]=$array_campo_nome;
                  //  Criando array com nome e valor do campo da Tabela 
                  $count_name_c_id=count($nome_cpo_id); 
                  for( $nir=0;$nir<$total_registros_encontrados;$nir++ ) {
                      for( $xyz=0; $xyz<$count_name_c_id; $xyz++ ) { 
                          $nome_do_cpo=$nome_cpo_id[$xyz];
                          $while_result["$nome_do_cpo"][$nir]=mysql_result($result,$nir,$nome_do_cpo);
                      }
                  }
                  //
                  $onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";
                  //  $m_nome_primeiro_campo = ucfirst($_SESSION["m_nome_id"]);            
                  if( $encontrar=="hpadrao" ) { 
                        $m_nome_segundo_campo="Descri&ccedil;&atilde;o";     
                        $m_nome_primeiro_campo="Hist&oacute;rico";  $m_title="Hist&oacute;rico";     
                  } elseif( $encontrar=="usuario" ) { 
                        $m_nome_segundo_campo="C&oacute;digo"; $m_title="Login";     
                        $m_nome_primeiro_campo="Login";    $m_tit1_select="Login";
                        $m_campo_ligacao = "codigousp";                 
                  } elseif( $encontrar=="fornecedor" or $encontrar=="pessoal"  ) { 
                         $m_nome_segundo_campo = "Nome"; $m_title="Nome";     
                         $m_nome_primeiro_campo = "Nome";  $m_tit1_select  = "C&oacute;digo";
                         $onkeyup='javascript:this.value=this.value.toUpperCase();';
                         if( $encontrar=="pessoal" ) $m_campo_chave="codigousp";
                  }
                   //
                   if( isset($len_c[$nome_cpo_id[0]]) ) $tamanho_cpo=$len_c[$nome_cpo_id[0]];
                  //
             ?>
   <TABLE id="tabela_finaciadora"  >
      <tr style="border: none; vertical-align: middle; " >
        <td  nowrap="nowrap" class="td_normal"  >
          <Table style="border: none; margin: 0px; padding: 0px; line-height: 0px; " >
            <tr>
              <td>
                <label for="campos_tabela" class="td_informacao2" >
                  Campos:&nbsp;</label>
                  <span style="margin-left: 5px;" >
                   <SELECT name="campos_tabela" id="campos_tabela"  class="td_select"   
                     onchange="javascript: dochange('campos_tabela',this.value);"  style="font-size: small; cursor: pointer;">
                  <?php        
                    echo "<option value='0'>====   Selecionar   ====</option>\n";
                    $_SESSION["tamanho_do_campo"]="";
                    foreach( $nome_cpo_id as $chave_cpo => $campo_da_tabela ) {       
                          $m_title="";
                          $m_title=$array_campo_nome["$campo_da_tabela"];         
                          $m_nome_primeiro_campo=$array_campo_nome["$campo_da_tabela"]; 
                          $_SESSION["campos_tabela"]=$campo_da_tabela;
                          $zxcampo_da_tabela["$campo_da_tabela"]=$len_c[$nome_cpo_id[$chave_cpo]];                                                    $_SESSION["m_title"]=$m_title; 
                          /*  IMPORTANTE - para os espacos e caracteres com acentos
                              option deve ser feito desse modo  */
                          // if( preg_match("/^si|^descricao/i",$campo_da_tabela)  ) {
                               if( strtoupper($campo_da_tabela)=='NOME' ) $m_title="Nome";
                               $tamanho_do_campo=$zxcampo_da_tabela["$campo_da_tabela"];
                               echo  '<option value="'.$_SESSION["campos_tabela"]."#".$tamanho_do_campo.'" >'
                                        .$m_title.'</option>\n';
                         // }   
                    }
                  ?>  
                  </SELECT>
                  </span>
                  </td>
                  <td  nowrap="nowrap" class="td_normal"  >
                  <!--  mostrar_resultado -->
                    <INPUT type="text"  name="mostrar_resultado"  id="mostrar_resultado" size="<?php echo $_SESSION["tamanho_do_campo"];?>"  maxlength="<?php echo $_SESSION["tamanho_do_campo"];?>" 
                    onkeydown="javascript: backspace_yes(event); "
                      onkeyup="javascript: this.value=this.value.replace(/^\s+|\s+$/g,'');  navegador_utilizado(); "  
                       class="texto_normal_negrito"  title="Digitar:&nbsp;<?php echo  $_SESSION["m_title"];?>" 
                        style="cursor: pointer;display: none;" disabled="disabled"  >
                   </td>
                    <td  nowrap="nowrap" class="td_normal"  id="td_mostrar_resultado" style="display: none;" >
                      <button type="submit"  onmouseover="javascript: criarJanela('td_mostrar_resultado')"  class="botao3d"  style="cursor: pointer; width:auto;"  ><b>?</b>
                      </button>
                </td>
             </tr>
           </table>
        </td>
      </tr> 
     <tr style="border: none; margin: 0px; padding: 0px; line-height: 0px; " >
      <td  > 
       <Table style="border: none; margin: 0px; padding: 0px; line-height: 0px; " >
        <tr>
         <td>
           <label for="mostrar_resultado2" class="td_informacao2" >                    
              Selecionar:&nbsp;</label>
              <span >                      
                <SELECT name="mostrar_resultado2" id="mostrar_resultado2"  class="td_select"   
                     onchange="javascript: validar('mostrar_resultado2',this.value);"  style="cursor: pointer;">
                  <?php        
                     if( strtoupper($encontrar)=="INSTITUICAO"  ) {
                         $campos_option=$array_campo_nome["sigla"]."&nbsp;-&nbsp;".$array_campo_nome["nome"];    
                     } elseif( strtoupper($encontrar)=="HPADRAO"  ) {
                         $campos_option=$array_campo_nome["historico"]."&nbsp;-&nbsp;".$array_campo_nome["descricao"];    
                     }    
                     //
                     echo "<option value='0'>====   $campos_option   ====</option>";
                     for( $xn=0; $xn<$total_registros_encontrados; $xn++ ) {
                          $sigla=$while_result["sigla"][$xn];
                          $nome=$while_result["nome"][$xn];
                          $tempx='<option value="'.sigla."#".$sigla.'" >'.htmlentities($sigla);
                          $tempx.='&nbsp;-&nbsp;'.htmlentities($nome).'&nbsp;</option>\n';
                          echo $tempx;
                     }    
                  ?>  
                </select>
              </span>
          </td>
        </tr>
       </table>
      </td>  
    </tr>  
                

</TABLE>
   <?php 
             echo "<hr  style='color: #000000; height: 1px;margin: 0px; padding: 0px;border: 1px #000000 solid;' >";
          }
       }  //  FINAL  -  IF strlen($encontrar)>1
       //
    } elseif( ! isset($encontrar) ) {
          echo $funcoes->mostra_msg_erro("Falha na vari?vel");    
          exit();                  
    } 
    //  FINAL - isset($encontrar)
    exit();                                    
}  //  FINAL do  if( $val_upper=="INICIANDO" ) {
//
$array_tabelas=array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
//
if( is_array($data) ) {
    // if( preg_match("/mostrar_resultado|mostrar_resultado2/i",$data[1]) ) {
    if( preg_match("/^mostrar_resultado/i",$data[1]) ) {
        //  Verifica se a variavel esta setada
        if( isset($val) ) {
            $_SESSION["mostra_resultado"]=$data[1];
            if( preg_match("/^mostrar_resultado2$/i",$data[1]) ) {
                if( isset($_SESSION["campo_selecionado"]) ) unset($_SESSION["campo_selecionado"]);
            } else {
                if( isset($_SESSION["campo_selecionado"]) ) $campo_selecionado=$_SESSION["campo_selecionado"];    
            }
            //  Verifica variavel  ser string
           if( is_string($val) ) {
                if( strlen(trim($val))<1 ) {
                     echo $funcoes->mostra_msg_erro("Digitar ou Selecionar:&nbsp;".ucfirst(strtolower($data[0])));
                     exit();                                      
                }  else {
                     $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
                     $marray_gp = array("grupo","pessoal"); 
                     if( isset($encontrar) ) {
                        $n_fields="";
                        if( strlen($encontrar)>1 ) {
                             $result=mysql_query("SELECT * from  ".$encontrar." limit 0 ");            
                             if( ! $result ) {
                                 echo $funcoes->mostra_msg_erro("Falha no select da Tabela $encontrar - db/Mysql:&nbsp; ".mysql_error());    
                                 //  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                                 exit();
                             } else  $n_fields = mysql_num_fields($result);
                        }
                     } elseif( ! isset($encontrar) ) {
                        echo $funcoes->mostra_msg_erro("Falha na vari?vel");    
                        exit();                  
                     }
                     for( $i=0; $i<$n_fields ; $i++ )  {
                          //  nome do campo da Tabela
                          $nome_cpo_id[$i] = trim(mysql_field_name($result,$i));   
                         // Tamanho do campo da Tabela
                         $len_c[$i]  = mysql_field_len($result,$i);
                     }
                     //
                     $_SESSION['num_cols']=$n_fields;  
                     if( isset($_SESSION['num_cols']) ) $num_cols=$_SESSION['num_cols'];
                     $m_onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";    
                     if( in_array($encontrar,$marray_gp) ) $m_onkeyup="javascript:somente_numero(this);"; 
                     //  Incluir a Tabela depois da CONSULTA
                     include("{$_SESSION["incluir_arq"]}includes/inc_editar_instituicao_ajax.php");
                     //
                }             
           } 
        }
    } elseif( in_array($data[0],$array_tabelas) and strtoupper($data[1])=="M_TABELA_ALTERADA"  ) {
        // Iniciando Tabela
        $_SESSION["tabela"]=$data[0];
        // IMPORTANTE - Dados vindo dos campos de um FORM  - melhor maneira  
        include("{$_SESSION["incluir_arq"]}includes/dados_campos_form_recebidos.php");        
        // Incluindo registro da Tabela atributo, categoria, depto
        $msg_erro = '';  $html_inner= '';    
        //  Definindo os nomes dos campos recebidos do FORM - variavel arr_nome_val - IMPORTANTE
        include("{$_SESSION["incluir_arq"]}script/foreach_util.php");        
        // Fecha foreach 
        $nome_campo_1=""; $valor_campo_1="";
        $nome_campo_2=""; $valor_campo_2="";
        if( isset($nome_campo[1]) ) $nome_campo_1=trim($nome_campo[1]);
        if( isset($valor_campo[1]) ) $valor_campo_1=trim($valor_campo[1]);
        if( isset($nome_campo[2]) ) $nome_campo_2=trim($nome_campo[2]);
        if( isset($valor_campo[2]) ) $valor_campo_2=trim($valor_campo[2]);
        //  Tabela grupo verificando se tem um ponto no final
        if( $data[0]=="grupo"  ) {
            if( isset($codigo) ) {
                 $codigo = utf8_decode(trim($codigo));
                 $length_cod = strlen($codigo);
                 if( $length_cod>=1 ) {
                     // IMPORTANTE - usando regex para buscar somente numeros e pontos
                     preg_match("/[^0-9.]/",$codigo, $resultado); //  Se existe letras
                     if( isset($resultado[0]) ) {
                          echo $funcoes->mostra_msg_erro("Digitar esse C&oacute;digo novamente.");
                          exit();                                      
                     }
                     if( substr($codigo,$length_cod)!="."  ) $codigo=trim($codigo).'.';
                     $valor_campo_1 = $codigo;                                 
                 }
            }            
        }
        //
        //  Tabela financiadora - alterar
        if( isset($_SESSION["sigla_da_instituicao"]) ) $sigla_da_instituicao=$_SESSION["sigla_da_instituicao"];
        $banco_de_dados=$_SESSION["bd_1"];
         //   Organizando os campos para alteracao na Tabela fornecedor     
        $array_cpo_nome=explode(",",$cpo_nome);
        $array_cpo_valor=explode(",",$cpo_valor);       
        $success_antes="UPDATE {$_SESSION["bd_1"]}.$data[0]  ";
        $success_antes.=" SET ";
        $count_array_cpo_nome=count($array_cpo_nome);
        for( $ne=0; $ne<$count_array_cpo_nome; $ne++ ) {
             $m_nome_cpo=$array_cpo_nome[$ne];
             if( preg_match("/^int$|^INTEGER$|^TINYINT$|^SMALLINT$|^MEDIUMINT$|^BIGINT$|^FLOAT$|^DOUBLE$|^DECIMAL$/i",$name_type[$m_nome_cpo]) )  {
                $success_antes.=" $m_nome_cpo=$array_cpo_valor[$ne] ";
             }  else {
                 if( is_string($array_cpo_valor[$ne]) )  {
                     //  IMPORTANTE - Trocando esses simbolos por virgula na variavel STRING
                     $array_cpo_valor[$ne]=preg_replace('/\|\#\&\>\|/',',',$array_cpo_valor[$ne]); 
                 }
                 //  IMPORTANTE USAR procedure clean_spaces para acertar espa?oes na variavel
                 $success_antes.="  $m_nome_cpo=$array_cpo_valor[$ne] ";
             }  
             //  SEMPRE USAR -1 no TOTAL para nao adicionar na variavel , 
             if( $ne<$count_array_cpo_nome-1 ) $success_antes.=", ";
        }
        $success_antes.=" WHERE clean_spaces(sigla)=clean_spaces('$sigla_da_instituicao') ";
        //
        //  Verificando duplicata do codigo das Tabelas atributo,  categoria e grupo
        //
       //   Criando variavel para Tabela Temporaria
        //  SELECT - SQL - Criando uma Tabela temporaria  
        if( isset($_SESSION['codigousp']) ) { 
            $codigousp = $_SESSION['codigousp'];
        } else $codigousp="9999999999";
        //
        $tab_temp_institui="temporar_hpadrao_$codigousp";
        $_SESSION["t_temp_editar_instituic"] = "{$_SESSION["bd_1"]}.$tab_temp_institui";
        $sql_editar_institui = "DROP TEMPORARY TABLE IF EXISTS  {$_SESSION["t_temp_editar_instituic"]} ";
        $res_editar_institui=mysql_query($sql_editar_institui);
        if( ! $res_editar_institui ) {
            echo $funcoes->mostra_msg_erro("Falha no DROP tabela $tab_temp_institui - db/Mysql:&nbsp; ".mysql_error());
            exit();
        }                
        if( isset($res_editar_institui) ) unset($res_editar_institui);
        $sq_editar_institui= "CREATE TEMPORARY TABLE  IF NOT EXISTS {$_SESSION["t_temp_editar_instituic"]}  ";
        $sq_editar_institui.= "SELECT * FROM {$_SESSION["bd_1"]}.$encontrar   "
                              ." WHERE clean_spaces($nome_campo_1)!=clean_spaces('$sigla_da_instituicao') ";
        //     
        $create_temp_tab_institui = mysql_query($sq_editar_institui);            
        if( ! $create_temp_tab_institui ) {
            echo $funcoes->mostra_msg_erro("Falha no CREATE tabela {$_SESSION["t_temp_editar_instituic"]} -"
                          ."&nbsp;db/Mysql:&nbsp; ".mysql_error());    
            exit();
        }       
        //
        $result_instituicao=mysql_query("SELECT * FROM {$_SESSION["t_temp_editar_instituic"]} "
                 ." WHERE  clean_spaces($nome_campo_1)=clean_spaces('$valor_campo_1') ");
        //
        if( ! $result_instituicao ) {
            /*  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysql: ".mysql_error().$msg_final;  
                 echo $msg_erro;  */
            echo $funcoes->mostra_msg_erro("Consultando a Tabela $data[0] - db/mysql:&nbsp;".mysql_error());
            exit();             
        }  
        $m_regs=mysql_num_rows($result_instituicao);
        // 
        if( isset($result_instituicao) ) mysql_free_result($result_instituicao);
        if( $m_regs>=1 ) {
            $temp_cpo_nome=$_SESSION["temp_array"]["$nome_campo_1"];
            echo $funcoes->mostra_msg_erro("&nbsp;Nessa Tabela $encontrar o campo&nbsp;"
                         ."$temp_cpo_nome:&nbsp;<b>$valor_campo_1</b>"
                         ."&nbsp;j&aacute; est&aacute; cadastrado(a).");
            exit();                      
        }
        
   /*
   echo  "ERRO: library/editar_instituicao_ajax.php/437 - <br>  "
            ." - \$success_antes =   <br>"
         ." $success_antes  <br> ";
     exit();         
      */
        
        
        //  
       // MELHOR MANEIRA DE ENVIAR DADOS DO PHP PARA MYSQL -  UTF8_DECODE  - //  IMPORTANTE 2013
       //  $codigo = utf8_decode($codigo);
       //  $descricao =utf8_decode($descricao);
       //
        //  START  a transaction - ex. procedure    
        mysql_query('DELIMITER &&'); 
        $commit="commit";
        mysql_query('begin'); 
        //  Execute the queries 
        //  $success = mysql_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
        //  mysql_db_query - Esta funcao esta obsoleta, nao use esta funcao 
        //   - Use mysql_select_db() ou mysql_query()
        mysql_query("LOCK TABLES  {$_SESSION["bd_1"]}.$data[0] UPDATE");
        //  Alterando dados na Tabela instituicao
      /*  $success=mysql_query("UPDATE $data[0] SET $nome_campo_1=clean_spaces('$valor_campo_1'), "
                              ." $nome_campo_2=clean_spaces('$valor_campo_2')  "
                              ." WHERE clean_spaces($nome_campo_1)=clean_spaces('$sigla_da_hpadrao') ");
                              */
        $success=mysql_query($success_antes);                              
        //
        if( ! $success ) {
            $commit="rollback";
            echo $funcoes->mostra_msg_erro("Alterando dados na Tabela $encontrar - db/mysql:&nbsp; ".mysql_error());
        } elseif( $success ) {
            echo $funcoes->mostra_msg_ok("Cadastro alterado: <br>$valor_campo_1,$valor_campo_2");           
        }
        /*!40000 ALTER TABLE  ENABLE KEYS */;
        mysql_query($commit);
        mysql_query("UNLOCK  TABLES");
        //  Complete the transaction 
        mysql_query('end'); 
        mysql_query('DELIMITER');
        //
        exit();
  }
}  // FINAL do IF array $data

/*
       $cmdhtml="<a href='#' onclick='javascript: dochange(\"SELECIONADO\",\"$encontrar\",\"$parte[0]#codigo\");return true;' class='linkum' title='Clicar' >";
*/
if( is_string($data) ) {
    //  SELECIONADO apenas um registro
    if( strtoupper(trim($data))=="SELECIONADO" ) {
        $_SESSION["mostra_resultado"]="SELECIONADO";
        //  nome da tabela
        $encontrar=$val;
        if( isset($encontrar) ) {
            $n_fields="";
            $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
            $marray_gp = array("grupo","pessoal"); 
            if( strlen($encontrar)>1 ) {
                $result=mysql_query("SELECT * from  ".$encontrar." limit 0 ");            
                if( ! $result ) {
                     echo $funcoes->mostra_msg_erro("Falha no select da Tabela $encontrar - db/Mysql:&nbsp; ".mysql_error());                     //  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                     exit();
                } else  $n_fields = mysql_num_fields($result);
            }
        } elseif( ! isset($encontrar) ) {
             echo $funcoes->mostra_msg_erro("Falha na vari?vel");    
             exit();                  
        }
         if( $n_fields>=1 ) {
             for( $i=0; $i<$n_fields ; $i++ )  {
                  //  nome do campo da Tabela
                  $nome_cpo_id[$i] = trim(mysql_field_name($result,$i));   
                  // Tamanho do campo da Tabela
                  $len_c[$i]  = mysql_field_len($result,$i);
             }
         }
         //
         $_SESSION['num_cols']=$n_fields; 
         if( isset($_SESSION['num_cols']) ) $num_cols=$_SESSION['num_cols'];
         $m_onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";    
         if( in_array($encontrar,$marray_gp) ) $m_onkeyup="javascript:somente_numero(this);"; 
         //  Incluir a Tabela depois da CONSULTA       
         include("{$_SESSION["incluir_arq"]}includes/inc_editar_hpadrao_ajax.php");
         //
    }
}       

#
ob_end_flush(); 
#
?>