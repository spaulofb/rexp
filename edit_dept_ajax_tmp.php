<?php
//  Recebendo os dados para compilar
//
//   Arquivo para EDITAR/ALTERAR - Tabela depto  (Departamento)
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
$m_data=""; $data_upper="";  $where="";
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
$m_linhas=0; 
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
    if( isset($val_upper) ) unset($val_upper); 
    echo  "{$_SESSION["tamanho_do_campo"]}";
    exit();    
}
//
if( $val_upper=="INICIANDO" ) {
    if( ! isset($m_onblur) ) $m_onblur="";
    $m_campo_chave=""; $order_by="";  $n_fields="";
    if( isset($encontrar) ) {
        if( strlen($encontrar)>1 ) {
            //  sessao $_SESSION["m_nome_id"]  ->  nome da tabela ou $encontrar
           if( preg_match("/^depto/i",$encontrar) ) {
                $m_campo_chave="sigla";  
                //  INSTITUICAO
                $sigla_instituicao="";
                if( isset($_SESSION["instituicao"]) ) $sigla_instituicao=trim($_SESSION["instituicao"]);
                //  UNIDADE
                $sigla_unidade="";
                if( isset($_SESSION["unidade"]) ) $sigla_unidade=trim($_SESSION["unidade"]);
                if( strlen($sigla_instituicao)>=1 && strlen($sigla_unidade)>=1 ) {
                   $where=" WHERE clean_spaces(instituicao)=clean_spaces('$sigla_instituicao') and "
                               ." clean_spaces(unidade)=clean_spaces('$sigla_unidade')   ";                    
                } elseif( strlen($sigla_instituicao)>=1 && strlen($sigla_unidade)<1 ) { 
                   $where=" WHERE clean_spaces(instituicao)=clean_spaces('$sigla_instituicao') ";                    
                } elseif( strlen($sigla_instituicao)<1 && strlen($sigla_unidade)>=1 ) { 
                   $where=" WHERE clean_spaces(unidade)=clean_spaces('$sigla_unidade') ";                    
                }
                //
           } 
           if( strlen(trim($m_campo_chave))>1 ) $order_by=" order by instituicao,unidade,{$m_campo_chave},nome ";
           if( preg_match("/^codigo|^codigousp/i",strtoupper(trim($m_campo_chave))) ) {
               $m_title="C&oacute;digo";  $m_nome_primeiro_campo="C&oacute;digo";
           } elseif( strtoupper(trim($m_campo_chave))=="SIGLA" ) $m_title="Sigla";
           //
           $result=mysql_query("SELECT * FROM {$_SESSION["bd_1"]}.$encontrar $where $order_by ");
           //
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
                        $name_c_id[$i] = trim(mysql_field_name($result,$i));   
                        $nome_do_cpo=$name_c_id[$i];
                        $len_c[$name_c_id[$i]] = mysql_field_len($result,$i);                                               
                  }
                  $m_tit1_select = ucfirst($m_campo_chave); $m_size=60; $m_maxlenght=60;
                  $array_campo_nome=array( "sigla" => "Sigla", "unidade" => "Unidade", "instituicao" => "Instituição", "nome" => "Nome do Departamento" );
                  //  Criando array com nome e valor do campo da Tabela 
                  $count_name_c_id=count($name_c_id); 
                  for( $nir=0;$nir<$total_registros_encontrados;$nir++ ) {
                      for( $xyz=0; $xyz<$count_name_c_id; $xyz++ ) { 
                          $nome_do_cpo=$name_c_id[$xyz];
                          $while_result["$nome_do_cpo"][$nir]=mysql_result($result,$nir,$nome_do_cpo);
                      }
                  }
                  //
                  if( preg_match("/^atributo|^categoria|^grupo/i",$encontrar) ) {
                      $m_tit1_select="C&oacute;digo";  $m_nome_segundo_campo="Descri&ccedil;&atilde;o";
                      $m_campo_ligacao = "descricao";
                  } 
                  $onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";
                  //  $m_nome_primeiro_campo = ucfirst($_SESSION["m_nome_id"]);            
                  if( $encontrar=="fornecedor" or $encontrar=="pessoal"  ) { 
                         $m_nome_segundo_campo = "Nome"; $m_title="Nome";     
                         $m_nome_primeiro_campo = "Nome";  $m_tit1_select  = "C&oacute;digo";
                         $onkeyup='javascript:this.value=this.value.toUpperCase();';
                         if( $encontrar=="pessoal" ) $m_campo_chave="codigousp";
                  } elseif( $encontrar=="bem" ) {   //  Tabela bem/patrimonio
                         $m_size=15; $m_maxlenght=12;
                  } elseif( $encontrar=="grupo" ) $m_title="Descri&ccedil;&atilde;o";     
                   //
                   //  Primeiro campo 
                   if( isset($len_c[$name_c_id[0]]) ) $tamanho_cpo=$len_c[$name_c_id[0]];
                  //
               ?>
    <TABLE id="tabela_depto" width="100%"  >
      <tr style="border: none; vertical-align: middle; " >
        <td align="left" nowrap="nowrap" class="td_normal">
          <TABLE style="margin: 0px; padding: 0px;" >
            <tr style="border: none; vertical-align: middle; " >
              <td  nowrap="nowrap" class="td_normal"  >
                <!--  INSTITUICAO  --> 
                 <span class="td_informacao2" >
                   Institui&ccedil;&atilde;o:<br />
                   <SELECT name="instituicao"  id="instituicao"  class="td_select" 
                     onchange="javascript: validar('instituicao',this.value);" >
                     <?php
                       //  INSTITUICAO
                      //  Esta funcao mysql_db_query esta obsoleta  usar  mysql_query
                      //  $result=mysql_db_query($dbname,"SELECT sigla FROM instituicao order by nome ");
                      $result=mysql_query("SELECT sigla,nome FROM {$_SESSION["bd_1"]}.instituicao  "
                                           ." WHERE  clean_spaces(sigla)=clean_spaces('$sigla_instituicao') "
                                           ." order by sigla,nome ");
                      //
                      if( ! $result ) {
                           echo $funcoes->mostra_msg_erro("Falha no Select tabela instituicao&nbsp;- db/Mysql:&nbsp; ".mysql_error());
                           exit();
                      }
                      //
                      $m_linhas=mysql_num_rows($result);
                      if ( $m_linhas<1 ) {
                          echo "<option value='' >==== Nenhum(a) encontrado(a) ====</option>";
                      } else {
                       ?>
                       <option value='<?php echo $sigla_instituicao;?>' >=== Sigla - Nome ===</option>
                       <?php
                        while($linha=mysql_fetch_array($result)) {
                            $sigla_instituicao=$linha['sigla'];   
                           /*  IMPORTANTE - para os espacos e caracteres com acentos
                                option deve ser feito desse modo  */ 
                            $select_inst=' selected=\"selected\"  ';                                 
                            echo '<option "'.$select_inst.'" value="'.$sigla_instituicao.'" >';
                            echo  htmlentities($sigla_instituicao)."&nbsp;-&nbsp;".htmlentities(trim($linha["nome"]));
                            echo "</option>";
                        }
                      ?>
                          <!--   <option value='todas' >Todas</option>  -->
                       </SELECT>
                      </span>
                     <?php
                    }
                    if( isset($result) ) mysql_free_result($result); 
                   // Final do Instituicao
                  ?>
                  </td>
                  <td align="left" nowrap="nowrap" class="td_normal">
                    <!--  UNIDADE  --> 
                    <span class="td_informacao2" >
                      Unidade:<br />
                     <SELECT name="unidade" id="unidade"  class="td_select"  onchange="javascript: validar('unidade',this.value);"   >
                 <?php
                  //  UNIDADE
                  //  Esta funcao mysql_db_query esta obsoleta  usar  mysql_query
                  //  $result=mysql_db_query($dbname,"SELECT sigla FROM unidade order by nome ");
                  $result=mysql_query("SELECT sigla,nome FROM {$_SESSION["bd_1"]}.unidade "
                                      ." WHERE clean_spaces(instituicao)=clean_spaces('$sigla_instituicao') and "
                                      ." clean_spaces(sigla)=clean_spaces('$sigla_unidade') "
                                      ." order by sigla,nome ");
                  //                                      
                  if( ! $result ) {
                       echo $funcoes->mostra_msg_erro("Falha no Select tabela unidade&nbsp;- db/Mysql:&nbsp; ".mysql_error());
                       exit();
                  }
                  //  
                  $m_linhas = mysql_num_rows($result);
                  if( $m_linhas<1 ) {
                     echo "<option value='' >==== Nenhum encontrado ====</option>";
                  } else {
                 ?>
                   <option value='<?php echo $sigla_unidade;?>' >===   Sigla - Nome   ===</option>
                 <?php
                   if( isset($linha) ) unset($linha);
                   while($linha=mysql_fetch_array($result)) {       
                         $sigla_unidade=$linha['sigla'];   
                         $nome_unidade=trim($linha["nome"]);
                         /*  IMPORTANTE - para os espacos e caracteres com acentos
                                option deve ser feito desse modo  */ 
                          $select_unidade=' selected=\"selected\"  ';                                       
                          echo '<option "'.$select_unidade.'"   value="'.$sigla_unidade.'" >';
                          echo  trim($linha['sigla'])."&nbsp;-&nbsp;".htmlentities($nome_unidade);
                          echo "</option>" ;
                   }
                 ?>
                  <!--   <option value='todas' >Todas</option>  -->
                  </select>
                  </span>
                 <?php
                   if( isset($result) ) mysql_free_result($result); 
                 }
                 // Final da Unidade
                 ?>                  
              </td>
            </tr> 
          </TABLE>
        </td>
       </tr>   
       <tr style="border: none; vertical-align: top; margin: 0px; padding: 0px; " >
         <td align="left" nowrap="nowrap" class="td_normal">
           <TABLE style="margin: 0px; padding: 0px;" >
             <tr style="border: none; vertical-align: middle; " >
               <td  nowrap="nowrap" class="td_normal"  >
                 <!-- DEPARTAMENTO - escolher campo  -->
                 <span  class="td_informacao2"  >
                       Departamento:<br>
                  <SELECT name="campos_tabela" id="campos_tabela"  class="td_select"   
                     onchange="javascript: dochange('campos_tabela',this.value);" style="font-size: small;cursor: pointer;">
                  <?php        
                    echo "<option value='0'>====   Selecionar Campo   ====</option>\n";
                    $_SESSION["tamanho_do_campo"]="";
                    foreach( $name_c_id as $chave_cpo => $campo_da_tabela ) {       
                          $m_title="";
                          /*
                          if( preg_match("/^descricao/i",$campo_da_tabela) ) {
                              $m_title="Descri&ccedil;&atilde;o";  $m_nome_primeiro_campo="Descri&ccedil;&atilde;o";
                              $_SESSION["campos_tabela"]=$campo_da_tabela;
                              // $_SESSION["campo_da_tabela"]["$campo_da_tabela"]=$len_c[$name_c_id[$chave_cpo]];         
                              $zxcampo_da_tabela["$campo_da_tabela"]=$len_c[$name_c_id[$chave_cpo]];         
                          }                           
                          */
                          $m_title=$array_campo_nome["$campo_da_tabela"];         
                          $m_nome_primeiro_campo=$array_campo_nome["$campo_da_tabela"]; 
                          $_SESSION["campos_tabela"]=$campo_da_tabela;
                          $zxcampo_da_tabela["$campo_da_tabela"]=$len_c[$name_c_id[$chave_cpo]];                                                       $_SESSION["m_title"]=$m_title; 
                          /*  IMPORTANTE - para os espacos e caracteres com acentos
                              option deve ser feito desse modo  */
                          if( preg_match("/^sigla|^nome/i",$campo_da_tabela)  ) {
                               if( strtoupper($campo_da_tabela)=='NOME' ) $m_title="Nome";
                               $tamanho_do_campo=$zxcampo_da_tabela["$campo_da_tabela"];
                               echo  '<option value="'.$_SESSION["campos_tabela"]."#".$tamanho_do_campo.'" >'
                                        .$m_title.'</option>\n';
                          }   
                    }
                  ?>  
                  </SELECT>
                  </span>
                </td>
                <td  nowrap="nowrap" class="td_normal"  >
                    <br>
                    <INPUT type="text"  name="mostrar_resultado"  id="mostrar_resultado"  
                      size="<?php echo $_SESSION["tamanho_do_campo"];?>"  maxlength="<?php echo $_SESSION["tamanho_do_campo"];?>"  
                     onkeydown="javascript: backspace_yes(event); "
                         onkeyup="javascript: this.value=this.value.replace(/^\s+|\s+$/g,'');  navegador_utilizado(); "  
                            class="texto_normal_negrito"  title="Digitar:&nbsp;<?php echo  $_SESSION["m_title"];?>" 
                             style="cursor: pointer;display: none;" disabled="disabled"  >
                </td>
                <td nowrap="nowrap" class="td_normal"  id="td_mostrar_resultado" style="display: none;" >
                   <br>
                   <button type="submit" id="ajuda" onmouseover="javascript: criarJanela('td_mostrar_resultado')"  class="botao3d"  style="cursor: pointer; width:auto;" ><b>?</b>
                   </button>
                </td>
              </tr>
           </TABLE> 
         </td>
       </tr>     
       <tr style="border: none; margin: 0px; padding: 0px;"  >
         <td  nowrap="nowrap" class="td_normal"  style="margin: 0px; padding: 10px 0px 0px 0px;  border-top: 1px #000000 solid;"  >                  
           <label for="mostrar_resultado2" class="td_informacao2" >
             Selecionar:&nbsp;</label>
             <span>
             <SELECT name="mostrar_resultado2" id="mostrar_resultado2"  class="td_select"   
                onchange="javascript: validar('mostrar_resultado2',this.value);"  style="cursor: pointer;">
             <?php        
                $campos_option=$array_campo_nome["instituicao"]."&nbsp;-&nbsp;".$array_campo_nome["unidade"]."&nbsp;-&nbsp;".$array_campo_nome["sigla"]."&nbsp;-&nbsp;".$array_campo_nome["nome"];
                echo "<option value='0'>====   {$campos_option}   ====</option>\n";
                // while( $linha=mysql_fetch_array($result) ) {    
                //  IMPORTANTE - variavel do  mysql_fetch_array   para saber os valores dos campos da Tabela
                //  $count_while_result=count($while_result);
                for( $nir=0; $nir<$total_registros_encontrados; $nir++  ) {
                      $opcao_selecionada=$while_result["instituicao"][$nir]."#".$while_result["unidade"][$nir];
                      $opcao_selecionada.="#".$while_result["sigla"][$nir];
                      $instituicao=$while_result["instituicao"][$nir];
                      $unidade=$while_result["unidade"][$nir];
                      $sigla_depto=$while_result["sigla"][$nir];
                      echo  '<option value="'.$opcao_selecionada.'" >';
                      echo  $instituicao."&nbsp;-&nbsp;"; 
                      echo  $unidade."&nbsp;-&nbsp;"; 
                      echo  $sigla_depto."&nbsp;-&nbsp;"
                            .htmlentities($while_result["nome"][$nir]);
                      echo  "&nbsp;</option>\n" ;                                
                }                        
              ?>  
             </select>
           </span>
         </td>         
       </tr>         
      </table> 
      <hr style='color: #000000; height: 1px; margin: 0px; padding: 0px; border: 1px #000000 solid; ' >
      <?php   
           }
        }  //  FINAL  -  IF strlen($encontrar)>1
        //
    } elseif( ! isset($encontrar) ) {
        echo $funcoes->mostra_msg_erro("Falha na variável");    
        exit();                  
    } 
    //  FINAL - isset($encontrar)
    
    exit();                                    
}  //  FINAL do  if( $val_upper=="INICIANDO" ) {
//
$array_tabelas=array("atributo","categoria","depto","grupo");
if( is_array($data) ) {
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
                    // $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
                    // $marray_gp = array("grupo","pessoal"); 
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
                        echo $funcoes->mostra_msg_erro("Falha na variável");    
                        exit();                  
                     }
                     if( $n_fields>=1 ) {
                         for( $i=0; $i<$n_fields ; $i++ )  {
                             //  nome do campo da Tabela
                              $name_c_id[$i] = trim(mysql_field_name($result,$i));   
                              // Tamanho do campo da Tabela
                              $len_c[$i]  = mysql_field_len($result,$i);
                         }
                     }
                     $_SESSION['num_cols']=$n_fields;  
                     if( isset($_SESSION['num_cols']) ) $num_cols=$_SESSION['num_cols'];
                     $m_onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";    
                     //  Incluir a Tabela depois da CONSULTA
                     include("{$_SESSION["incluir_arq"]}includes/inc_editar_depto_ajax.php");
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
        //
        if( isset($descricao) ) $descricao=html_entity_decode($descricao);
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
        //  Tabela depto - testando a sigla do DEPTO
        if( isset($codigo) ) $m_codigo=strtoupper(trim($codigo)); 
        if( isset($descricao) ) $m_descricao=trim($descricao);
        if( isset($_SESSION["sigla_do_depto"]) ) $sigla_do_depto = $_SESSION["sigla_do_depto"];
        if( isset($_SESSION["instituicao"]) ) $instituicao=$_SESSION["instituicao"];
        if( isset($_SESSION["unidade"]) ) $unidade=$_SESSION["unidade"];
        //  Tabela depto
        $banco_de_dados=$_SESSION["bd_1"];
         //   Organizando os campos para alteracao na Tabela projeto            
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
                 //  IMPORTANTE USAR procedure clean_spaces para acertar espaçoes na variavel
                 //  NAO USAR NO UPDATE SET  'clean_spaces'  no campo da Tabela
                 $success_antes.="  $m_nome_cpo=$array_cpo_valor[$ne]";
             }  
             //  SEMPRE USAR -1 no TOTAL para nao adicionar na variavel , 
             if( $ne<$count_array_cpo_nome-1 ) $success_antes.=", ";
        }
        $success_antes.=" WHERE clean_spaces($nome_campo_1)=clean_spaces('$sigla_do_depto')  ";
        //
        // Verificando duplicata da sigla do DEPTO
        //
       //  Criando variavel para Tabela Temporaria
        //  SELECT - SQL - Criando uma Tabela temporaria  
        if( isset($_SESSION['codigousp']) ) { 
            $codigousp = $_SESSION['codigousp'];
        } else $codigousp="9999999999";
        //
        $m_tabela_temp="temp_lista_depto_$codigousp";
        $_SESSION["table_temp_editar_depto"] = "{$_SESSION["bd_1"]}.$m_tabela_temp";
        $sql_temp_editar = "DROP TEMPORARY TABLE IF EXISTS   {$_SESSION["table_temp_editar_depto"]}    ";
        //  $sql_temp = "DROP TABLE IF EXISTS   ".$_SESSION['table_temp_usu']."    ";
        $result_editar_depto=mysql_query($sql_temp_editar);
        if( ! $result_editar_depto ) {
            echo $funcoes->mostra_msg_erro("Falha no DROP tabela $m_tabela_temp - db/Mysql:&nbsp; ".mysql_error());    
            exit();
        }                
        if( isset($result_editar_depto) ) unset($result_editar_depto);
        $sqlcmd_editar= "CREATE TEMPORARY TABLE  IF NOT EXISTS {$_SESSION["table_temp_editar_depto"]}  ";
        $sqlcmd_editar.= "SELECT instituicao,unidade,sigla FROM {$_SESSION["bd_1"]}.$encontrar   "
                      ." WHERE clean_spaces(sigla)!=clean_spaces('$sigla_do_depto') and  "
                      ." clean_spaces(instituicao)=clean_spaces('$instituicao') and  "
                      ." clean_spaces(unidade)=clean_spaces('$unidade') ";
        //     
        $res_create_tab_editar_depto = mysql_query($sqlcmd_editar);            
        if( ! $res_create_tab_editar_depto ) {
            echo $funcoes->mostra_msg_erro("Falha no CREATE tabela {$_SESSION["table_temp_editar_depto"]} -"
                          ."&nbsp;db/Mysql:&nbsp; ".mysql_error());    
            exit();
        }       
        //
        $result1=mysql_query("SELECT sigla FROM {$_SESSION["table_temp_editar_depto"]} "
                 ." WHERE  clean_spaces(sigla)=clean_spaces('$sigla') ");
        //
        if( ! $result1 ) {
            /*  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysql: ".mysql_error().$msg_final;  
                 echo $msg_erro;  */
            echo $funcoes->mostra_msg_erro("Consultando a Tabela $data[0] - db/mysql:&nbsp;".mysql_error());
            exit();             
        }  
        $m_regs=mysql_num_rows($result1);
        if( isset($result1) ) mysql_free_result($result1);
        if( $m_regs>=1 ) {
            echo $funcoes->mostra_msg_erro("&nbsp;Nessa Tabela $data[0] os campos $instituicao,$unidade&nbsp;"
                         ." e&nbsp;Sigla:&nbsp;<b>$sigla</b>"
                         ."&nbsp;j&aacute; est&atilde;o cadastrado(a)s.");
            exit();                      
       }
       
  /*
   echo  "ERRO: library/editar_depto_ajax.php/457  ->>   <br>  "
            ." - \$success_antes =   <br>"
         ." $success_antes  <br>  \$valor_campo_1 = <b>$valor_campo_1</b>   ";
     exit();         
     */
       
       
       //  MELHOR MANEIRA DE ENVIAR DADOS DO PHP PARA MYSQL -  UTF8_DECODE  - //  IMPORTANTE 2013
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
        mysql_query("LOCK TABLES  {$_SESSION["bd_1"]}.$data[0] UPDATE ");
        //  Alterando dados na Tabela
        /*  $success=mysql_query("UPDATE $data[0] SET $nome_campo_1=clean_spaces('$valor_campo_1'), "
                             ." $nome_campo_2=clean_spaces('$valor_campo_2') "
                             ." WHERE clean_spaces($nome_campo_1)=clean_spaces('$sigla_do_depto') ");
          */                   
        $success=mysql_query($success_antes);           
        //
        if( ! $success ) {
            $commit="rollback";
            /* $msg_erro .="Usu&aacute;rio:&nbsp;$nome n&atilde;o foi cadastrado como "
                      .ucfirst($descr_pa).".<br>Falha: ".mysql_error().$msg_final;
            echo $msg_erro;       */
            echo $funcoes->mostra_msg_erro("Alterando dados na Tabela $data[0] - db/mysql:&nbsp; ".mysql_error());
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
  }
  exit();
}

/*
       $cmdhtml="<a href='#' onclick='javascript: dochange(\"SELECIONADO\",\"$encontrar\",\"$parte[0]#codigo\");return true;' class='linkum' title='Clicar' >";
*/                  
if( is_string($data) ) {
    //  SELECIONADO apenas um registro
    if( strtoupper(trim($data))=="SELECIONADO" ) {
        $_SESSION["mostra_resultado"]="SELECIONADO";
        //  nome da tabela
        if( isset($val) ) {
            $encontrar=trim($val);   
        } elseif( ! isset($val) ) {
             echo $funcoes->mostra_msg_erro("Falha na variável");    
             exit();                              
        }
        $n_fields="";
        // $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
        //  $marray_gp = array("grupo","pessoal"); 
        if( strlen($encontrar)>1 ) {
            $result=mysql_query("SELECT * from  ".$encontrar." limit 0 ");            
            if( ! $result ) {
                 echo $funcoes->mostra_msg_erro("Falha no select da Tabela $encontrar - db/Mysql:&nbsp; ".mysql_error());                     //  echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
                 exit();
            } else  $n_fields = mysql_num_fields($result);
        } else {
             echo $funcoes->mostra_msg_erro("Ocorreu uma falha na variável.");    
             exit();                                          
        }
         if( $n_fields>=1 ) {
             for( $i=0; $i<$n_fields ; $i++ )  {
                  //  nome do campo da Tabela
                  $name_c_id[$i] = trim(mysql_field_name($result,$i));   
                  // Tamanho do campo da Tabela
                  $len_c[$i]  = mysql_field_len($result,$i);
             }
         }
         $_SESSION['num_cols']=$n_fields; 
         if( isset($_SESSION['num_cols']) ) $num_cols=$_SESSION['num_cols'];
         $m_onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";    
         if( isset($marray_gp) ) {
              if( in_array($encontrar,$marray_gp) ) {
                 $m_onkeyup="javascript:somente_numero(this);";                
              } 
         }
         //  Incluir a Tabela depois da CONSULTA    
         include("{$_SESSION["incluir_arq"]}includes/inc_editar_depto_ajax.php");
         //
/* echo  "ERRO: library/consultar_atr_cat_gru_ajax.php/35 -  \$data = $data - \$data[0] = $data[0]  <br>"
             ."  -   \$_SESSION[num_cols] = {$_SESSION['num_cols']}  -   \$val = $val  - \$m_array - $m_array   --  <br>"
             ."   \$m_array[0] = $m_array[0]  --   \$m_array[1] = $m_array[1]  -  \$encontrar = $encontrar ";
        exit();   */
    }
}       

#
ob_end_flush(); 
#
?>