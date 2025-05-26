<?php
/*****
*       Recebendo os dados para compilar
*      Arquivo para EDITAR Tabela pessoal  
*****/
ob_start(); /*** Evitando warning ***/
/***  Verificando se SESSION_START - ativado ou desativado
    Header - Functions para busca de acentuacao - extract POST
    Verificando conexao
****/  
///  Verificando se SESSION_START - ativado ou desativado  
if(!isset($_SESSION)) {
   session_start();
}
/***
    Header - Functions para busca de acentuacao - extract POST
    Verificando conexao
****/  
require_once("{$_SESSION["incluir_arq"]}library/header_e_outros_ajax.php"); 
///
$post_array = array("data","val","m_array");
$count_post_array = count($post_array);
for( $i=0; $i<$count_post_array; $i++ ) {
    ///
    $xyz = trim($post_array[$i]);
    ///  Verificar strings com simbolos: # ou ,   para transformar em array PHP    
    $xyz=="m_array" ? $div_array_por = "#" : $div_array_por = ",";
    if( isset($_POST[$xyz]) ) {
       if( is_string($_POST[$xyz]) ) {
           $pos1 = stripos(trim($_POST[$xyz]),$div_array_por);   
       }
       ///
       /// Alterado em 20190610
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
          /// $$xyz=utf8_decode_all($$xyz);  
       } 
       ///
    }
    /****  Final - if( isset($_POST[$xyz]) ) {  ***/
    ///
}
/***  Final - for( $i=0; $i<$count_post_array; $i++ ) {  ****/
///
$m_data=""; $data_upper="";
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
if( $val=='coduspresp' ) $m_val="C&oacute;digo/USP" ;
///
///   Incluir variavel encontrar
require_once("{$_SESSION["incluir_arq"]}script/var_encontrar.php");
///
///  Iniciar o campo para consultar - codigo, descricao, etc...
///
///  VARIAVEL  E  SESSION IMPORTANTE PARA MOSTRAR TABELA NA TELA
$temp_array_element="Nome";
$temp_array= array( "historico"=>"Histórico", "descricao"=>"Descrição", 
              "codigo"=>"Código", "acao"=>"Ação", "sigla" => "Sigla", "codigousp"=>"Código",  
              "instituicao" => "Instituição", "unidade" => "Unidade", 
              "depto"=>"Departamento", "setor"=>"Setor", 
              "nome" => $temp_array_element,"categoria"=>"Categoria",  "e_mail" =>"E_Mail", 
              "sx"=>"Sexo", "sexo"=>"Sexo",  "codchapa"=>"Código", 
              "clp"=> "CLP (Identificação do Patrimonio/Bem)", "datacompra" => "Data da Compra", 
              "situacao" => "Situação do Patrimonio/Bem (Ativo, Baixado, Desativado, Inoperante)", 
              "chapausp" => "Chapa do Patrimonio/Bem", "bloco"=>"Bloco" );   
/// 
$_SESSION["temp_array"]=$temp_array;
///
///  Iniciar o campo para consultar - codigo, descricao, etc...
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
///  Final - if( $data_upper=="CAMPOS_TABELA" ) {
///
///  INICIANDO PAGINA
if( $val_upper=="INICIANDO" ) {
    ///
    $marray_gp = array("grupo","pessoal"); 
    if( ! isset($m_onblur) ) $m_onblur="";
    $m_campo_chave=""; $order_by="";
    // $ordernar_por="";
    //
    //  Banco de dados - BD/DB
    if( ! isset($_SESSION["bd_1"]) ) {
         echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
         exit();
    }
    $bd_1 = $_SESSION["bd_1"];  
    ///
    ///  Verificando nome dos campos da Tabela  pessoal
    $merro=0;
    /// Nome da coluna Sigla/ID/Codigo da Tabela 
    if( ! isset($_SESSION["codidpess"]) ) {
          $merro=1;   
    } else {
          ///
          $codidpess  = $_SESSION["codidpess"];
          /// Nome da coluna Nome/Descricao da Tabela 
          if( ! isset($_SESSION["nomepess"]) ) {
               $merro=1;   
          } else {
              $nomepess=$_SESSION["nomepess"];
              /// Nome da coluna EMAIL da Tabela 
              if( ! isset($_SESSION["mailpess"]) ) {
                   $merro=1; 
              } else {
                  $mailpess = $_SESSION["mailpess"]; 
              }   
          }
    }
    ///
    /// Verifica se Houve ERRO
    if( intval($merro)>0 ) {
         $txterr="Falha campo da Tabela $tabpri - corrigir.";
         echo $funcoes->mostra_msg_erro("$txterr");    
         exit();
    }
    ///  
     ///  $m_campo_chave="$codidpess";
     $m_campo_chave="$nomepess";
     ///  Ordenar Select/Mysqli
     if( strlen(trim($m_campo_chave))>1 ) {
         $order_by=" order by {$m_campo_chave} ";   
     }
     ///
     ///  sessao $_SESSION["m_nome_id"]  ->  nome da tabela ou $tabpri
     preg_match("/^pessoa/i",$tabpri,$n_array);
     if( count($n_array)>0  ) {
         ///  Array campos da tabela principal
         $arr_cpo_nome=array( "$codidpess" => "Código", 
                           "$nomepess" => "Nome", 
                           "$mailpess" => "E_Mail" );
         ////
        $_SESSION["array_campo_nome"]=$arr_cpo_nome;   
        ///
     } 
     ///

    ///  sessao $_SESSION["m_nome_id"]  ->  nome da tabela ou $tabpri
    /// if( isset($array_campo_nome) )  unset($array_campo_nome);
    /***
    if( preg_match("/^pessoal/i",$tabpri) ) {
        $m_campo_chave="nome"; $ordernar_por=" order by nome ";
        $array_campo_nome=array( "codigousp" => "Código", "nome" => "Nome", "e_mail" => "E_Mail" );
        $_SESSION["array_cpo_nome_pessoal"]=$array_campo_nome;
    }
    
    
        $n_fields="";
    ///
           if( preg_match("/^codigo|^codigousp/i",strtoupper(trim($m_campo_chave))) ) {
               $m_title="C&oacute;digo";  $m_nome_primeiro_campo="C&oacute;digo";
           } elseif( strtoupper(trim($m_campo_chave))=="SIGLA" ) $m_title = "Sigla";
    * 
    ***/
    ///

    
     /// Campos da Tabela  
     $cpos_tb="*";
     ///
     ///  Select/MYSQLI
     $txt="SELECT $cpos_tb FROM {$bd_1}.$tabpri  $order_by ";
     $respri=mysqli_query($_SESSION["conex"],"$txt");
     ///            
     if( mysqli_error($_SESSION["conex"]) ) { 
         $txterr="Falha no select da Tabela $tabpri -&nbsp;db/Mysqli:&nbsp;";
         echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($_SESSION["conex"]));    
         exit();
     }
     ///  Nr. de  Registros
     $nregs = mysqli_num_rows($respri);
     ///
     ////     $total_registros_encontrados = mysqli_num_rows($result);
    ///  Verificando registros     
     if( intval($nregs)<1 ) {
          /*** $txterr="==== Nenhum registro encontrado dessa Tabela: $tabpri ====";   
          *   echo $funcoes->mostra_msg_erro("$txterr");     
          ***/
          $txt="==== Nenhum registro encontrado ====";
          echo $funcoes->mostra_msg_ok("<center>$txt</center>");    
          exit();      
     }
     ///  Final -  if( intval($nregs)<1 ) {
     ///
     ///  Copia do Array em SESSION
     ///     SESSIONs definidas na pagina inicial
     if( !isset($_SESSION["name_c_id"]) || !isset($_SESSION["len_c"]) ) {
          $txterr="Falha grave SESSION indefinida - corrigir.";
          echo $funcoes->mostra_msg_erro("$txterr");    
          exit();      
     }
     ///
     $name_c_id=$_SESSION["name_c_id"];
     $len_c=$_SESSION["len_c"];
     ///
     ///   Criando o Array com campos e valores da Tabela selecionada
     $x = 0;
     while( $row = mysqli_fetch_array($respri, MYSQLI_ASSOC) ) {        
          ///  Nome dos campos da Tabela
          for( $nt=0; $nt<count($name_c_id); $nt++ ) {
               $nomekey=$name_c_id[$nt];
               $amfa[$x]["$nomekey"] = $row["$nomekey"];              
          }
          $x++;
     }
     ///
     $m_size=60; 
     $m_maxlenght=60;
     $txt="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";
     $onkeyup="$txt";
     ///
      ///    $m_tit1_select = ucfirst($m_campo_chave); 
    
    
/**********************
   echo "ERRO:  editar_pessoal_ajax/247  -->>  \$_SESSION[m_title] = {$_SESSION["m_title"]} <<<---  \$x = $x  <<--  \$nregs = $nregs -->> \$order_by = $order_by  <<-->> "
      ."  \$m_campo_chave = $m_campo_chave  <<-->> \$bd_1 = $bd_1  -- \$tabpri = $tabpri  ";
   exit();    
   **********************/


                  ///
      ?>
<!--  Campos para consultar da Tabela pessoal  -->           
  <table id="tabela_pessoal" style="margin: 0px; padding: 0px; line-height: 0px;"  >
    <tr style="border: none;" >
       <td  nowrap="nowrap" class="td_normal" style="margin: 0px; padding: 0px; line-height: 0px;"  >
         <Table style="border: none; margin: 0px; padding: 0px; line-height: 0px; " >
          <tr>
           <td>
           <label for="campos_tabela" class="td_informacao2" >
               Campos:&nbsp;</label>
                <span style="margin-left: 5px;" >
                <select name="campos_tabela" id="campos_tabela"  class="td_select"   
                           onfocus="ofocusF(this);"  
                           onmousedown="ocultaid('label_msg_erro');"  
                           onchange="javascript: dochange('campos_tabela',this.value);" 
                            style="font-size: small; cursor: pointer;">

                   <?php        
                    echo "<option value='0'>====   Selecionar   ====</option>";
                    //// $_SESSION["tamanho_do_campo"]="";
                    foreach( $name_c_id as $chave_cpo => $cpotab ) {       
                          ///
                          $m_title=$arr_cpo_nome["$cpotab"];         
                          $_SESSION["campos_tabela"]=$cpotab; 
                          ///
                          ////  $_SESSION["m_title"]=$m_title; 
                          $tam_cpo=$zxcampo_da_tabela["$cpotab"];
                          /***  IMPORTANTE - para os espacos e caracteres com acentos
                          *    option deve ser feito desse modo  
                          ***/
                          preg_match("/^sigla|^codigousp$|^codigo$|^e_mail|^email|nome/i",$cpotab,$na);
                          ///    
                          if( count($na)>0 ) {
                              ///
                               if( strtoupper($cpotab)=='NOME' ) $m_title="Nome";
                                $tam_cpo=$len_c["$cpotab"];  
                                ///
                                ///  Atualizado em 20200910
                                $nopt='<option value="'.$cpotab."#".$tam_cpo.'" >';
                                $nopt.="{$m_title}</option>";
                                echo  $nopt;
                                ///         
                          }   
                    }
                    /// Final - foreach( $name_c_id as $chave_cpo => $cpotab ) {       
                  ?>  
                  </select>
                  <!-- Final - campos para selecionar pesquisa -->
            </span>
       </td>
       <td  nowrap="nowrap" class="td_normal"  >
          <!--  Campo para digitar/procurar  -->
              <input type="text"  name="mostrar_resultado"  id="mostrar_resultado" 
                       class="cpoforn1"   onfocus="desativar(); ofocusF(this);"  
                       onmousedown="ocultaid('label_msg_erro');" 
                      onkeydown="javascript: backspace_yes(event); "
                     onkeyup="javascript: dochange('<?php echo  $tabpri.'\,mostrar_resultado';?>',this.value);" 
                        title="Digitar:&nbsp;"  style="display: none;" disabled="disabled" >
         <!--  Final - Campo para digitar/procurar  -->         
       </td>
           <td  class="td_normal"  id="td_mostrar_resultado" style="display: none;" >
              <!--  Informacao -->
               <button type="submit"  onmouseover="javascript: criarJanela('td_mostrar_resultado')" 
                       class="botao3d"  style="cursor: pointer; width:auto;"  ><b>?</b>
               </button>
             <!--  Final - Informacao -->
        </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr style="border: none; margin: 0px; padding: 0px; line-height: 0px; " >
      <td> 
       <table style="border: none; margin: 0px; padding: 0px; line-height: 0px; " >
        <tr>
         <td>
          <span class="td_informacao2" >
            Selecionar:&nbsp;
           <select name="mostrar_resultado2" id="mostrar_resultado2"    
                  class="cposel"  onfocus="desativar(); ofocusF(this);"   
                 onchange="dochange('<?php echo  $tabpri.'\,mostrar_resultado2';?>', this.value);"  >
           <?php        
             /***
              $pattern = "/^sigla$|^codigousp$|^codigo$/i";
              foreach( $while_result as $keychave => $valarray ) {
                    //  Chave no array bidimensional                  
                    if( preg_match($pattern,$keychave) ) {
                          break;
                    }
              }
              ***/
             ///// $campos_option=$arr_cpo_nome["$keychave"]."&nbsp;-&nbsp;".$arr_cpo_nome["nome"];
              ///  $campos_option=$arr_cpo_nome["nome"];
              $campos_option=$arr_cpo_nome["$nomepess"];
              echo "<option value='0'>====   $campos_option   ====</option>";
              for( $xn=0; $xn<$nregs; $xn++ ) {
                  //// $principal=$while_result["$keychave"][$xn];
                  $principal=$amfa[$xn]["$codidpess"];
                ////  $nome=$while_result["nome"][$xn];
                  $nome=$amfa[$xn]["$nomepess"];
                  if( preg_match("/^Chefia/i",$nome) ) continue;
                  $msg_echo =  '<option value="'.$principal.'" >'.htmlentities($nome);
                  $msg_echo .='&nbsp;</option>';
                  echo $msg_echo;
                  ///
             }    
             /// Final - for( $xn=0; $xn<$nregs; $xn++ ) {
           ?>
         </select>
          <!--  Final - Selecionar  -->
          </span>
          </td>
         </tr>
        </table>
      </td>  
    </tr>  
  </table>
  <!--  Final - Campos para consultar da Tabela pessoal  -->     
<hr style='color: #000000; height: 1px; margin: 0px; padding: 0px; border: 1px #000000 solid; ' >
   <?php 
     ///
    exit();                                    
}  
///  FINAL do  if( $val_upper=="INICIANDO" ) {
///
/// Verifica caso variavel data for Array
$array_tabelas=array("atributo","categoria","financiadora","grupo","hpadrao","instituicao","pessoal");
if( is_array($data) ) {
    ///
    /// if( preg_match("/mostrar_resultado|mostrar_resultado2/i",$data[1]) ) {
    
    
    if( preg_match("/^mostrar_resultado/i",$data[1]) ) {
        ///
        $_SESSION["mostra_resultado"]=$data[1];
        ///
        if( preg_match("/^mostrar_resultado2$/i",$data[1]) ) {
            if( isset($_SESSION["campo_selecionado"]) ) {
                 unset($_SESSION["campo_selecionado"]);   
            }
        } else {
            if( isset($_SESSION["campo_selecionado"]) ) {
                 $campo_selecionado=$_SESSION["campo_selecionado"];       
            }
        }
        ///
        
/****        
        echo "ERRO: editar_pessoal_ajax/405  -->>  \$data = tipo  ".gettype($data)
               ." -->> \\$data[0] = {$data[0]}  ----  \$data[1] = {$data[1]}  "
               ."<br/>  TIPO \$val =   ".gettype($val);
               exit();
     ***/   
        
        
        ///  Verifica variavel  ser string
        if( is_string($val) ) {
            ///
            ///  IMPORTANTE: necessita desse IF abaixo
            if( strlen(trim($val))<1 ) {
                $txterr="Digitar ou Selecionar:&nbsp;".ucfirst(strtolower($data[0]));
                 echo $funcoes->mostra_msg_erro("$txterr");
                 exit();                                      
            }
            ///  Final - if( strlen(trim($val))<1 ) {  
            /****    
             //  $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao","pessoal");
                
             ***/       
             ///   Array Tabelas                    
            $marray_gp = array("grupo","pessoal"); 
            ///
            
            ///   Verificando a variavel da Tabela principal
            if( ! isset($tabpri) ) {
                  echo $funcoes->mostra_msg_erro("Falha na variavel da Tabela");    
                  exit();                  
            }
             ///
            $txt="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";
            $m_onkeyup="$txt";
            ///
            ///  Copia do Array SESSION  pra variavel array
            $name_c_id = $_SESSION["name_c_id"];
            $len_c = $_SESSION["len_c"];
            ///
            $merro=0;
            if( isset($name_c_id[0]) && isset($name_c_id[1]) )  {
                  ///  Definindo  SESSION campo_selecionado 
                  ///     faz parte do Select ID campos_tabela
                  $varsel1="/^MOSTRAR_RESULTADO2|^SELECIONADO/i";
                  if( preg_match("$varsel1",$data[1]) ) {
                      $campo_selecionado = $name_c_id[0]; 
                  } else {
                      ///  Atualizado 20200815
                      if( is_array($m_array) ) {
                          $campo_selecionado = $m_array[0];    
                      } elseif( is_string($m_array) ) {
                          if( stripos("$m_array","#")>0 )  {
                              $newar = explode('#',$m_array);
                              $campo_selecionado = $newar[0];
                          } else {
                              $merro=1;
                              $txterr="Falha grave array m_array indefinida - corrigir.";
                          }
                      } else {
                          $merro=1;
                          $txterr="Falha grave array m_array indefinida - corrigir.";
                      }
                  }   
                  /// 
            } else{
                  $merro=1;
                 $txterr="Falha grave array nome dos campos da Tabela - corrigir.";
            }
            ///
            /// Verifica se Houve ERRO
            if( intval($merro)>0 ) {
                 echo $funcoes->mostra_msg_erro("$txterr");    
                 exit();                  
            }
            ///
            /// Nr. de campos da Tabela pessoal
            $_SESSION["num_cols"]=sizeof($name_c_id);  
            $num_cols=$_SESSION["num_cols"];
            if( in_array($tabpri,$marray_gp) ) {
                $m_onkeyup="javascript: acertar_espacos(this.id,this.value); somente_numero(this);";
            } 
            ///
            ///  Incluir a Tabela depois da CONSULTA
            $incluir_arq="{$_SESSION["incluir_arq"]}";
            $txt="{$incluir_arq}includes/inc_editar_pessoal_ajax.php";
           ////  include("$txt");


/***
   echo "ERRO:  editar_pessoal_ajax/461  -->>  \$txt = $txt  <br/> "
         ."  \$data[0] = {$data[0]}  E \$data[1] = {$data[1]} -->> <br/>"
         ."    \$campo_selecionado = $campo_selecionado <<--     \$val = $val  "
         ." <br/>  -->>  TIPO \$m_array =  ".gettype($m_array);
   exit();                 
***/
         

            require_once("$txt");
            ///
        } 
        /// Final - if( is_string($val) ) {
        ///
    } elseif( in_array($data[0],$array_tabelas) and strtoupper($data[1])=="M_TABELA_ALTERADA"  ) {
        ///
        /// Iniciando Tabela
        $_SESSION["tabela"]=$data[0];
        ///
        /// IMPORTANTE - Dados vindo dos campos de um FORM  - melhor maneira  
        $incluir_arq="{$_SESSION["incluir_arq"]}";
        ///
        /*****  
        *    Definindo os nomes dos campos recebidos do FORM - variavel arr_nome_val - IMPORTANTE  
        *  -  Desativar Array
        ****/
        if( isset($array_seleciona) ) unset($array_seleciona);
        ////
    ///    include("{$_SESSION["incluir_arq"]}includes/dados_campos_form_recebidos.php");    
        $lpwd="{$incluir_arq}includes/dados_recebidos_pessoal.php";
        require_once("{$lpwd}");        
        ///
        /// Incluindo registro da Tabela 
        $msg_erro = '';  $html_inner= '';    
        ///
        ///  Definindo os nomes dos campos recebidos do FORM - variavel arr_nome_val - IMPORTANTE
        /// include("{$_SESSION["incluir_arq"]}script/foreach_util.php");   
        require_once("{$_SESSION["incluir_arq"]}script/foreach_util.php");       
        /// Fecha foreach    
        ///    
        
/****        
  echo  "ERRO: editar_pessoal_ajax/553  -->>>  NOVO  \$lc_codigo = $lc_codigo <<-->> \$encontrar = $encontrar  <<-->> \$_SESSION[tabela] = {$_SESSION["tabela"]} "
       ."  <br/> \$incluir_arq = $incluir_arq  -->>  \$encontrar = $encontrar <br/>"
        ." \$cpo_nome = $cpo_nome <br/>  \$cpo_valor = $cpo_valor ";
  exit();        
**********/        
        
        
        
        /***    ATUALIZADO EM 20230922    ****/
        ///  E_MAIL enviado da pessoa 
        $lc_email = ""; 
        $lc_codigo = ""; 
        foreach( $array_seleciona as $chave => $valor ) {    
            ///
            ///  Procurando Codigo da Pessoa
            if( preg_match("/(matricula|codusp|codigo[usp]{0,3})/i",$chave, $matches) ) {
                 /*****
                 *   Nome do campo do Codigo/ID/Matricula da pessoa
                 ****/
                 $lc_codigo=$chave;  
                 ///
            } 
            ///
            ///  Procurando email  
            preg_match("/mail/ui",$chave, $matches1);
            if( count($matches1)>0 ) {
                 ///  EMail da pessoa
                 $lc_email=$chave;
            }
            ///
            ///  Procurando setor  
            preg_match("/^setor$|^codsetor$|idsetor$/ui",$chave, $matches2);
            if( count($matches2)>0 ) {
                 ///  pessoa  -  SETOR onde trabalha
                 $lc_setor=$chave;
                 $setor=$valor;
            }
            ///
            ///  Procurando departamento  
            preg_match("/^depto$|^coddepto$|iddepto$|^departamento/ui",$chave, $matches3);
            if( count($matches3)>0 ) {
                 ///
                 ///  pessoa  -  DEPTO onde trabalha
                 $lc_depto=$chave;
                 $depto=$valor;
            }
            ///
            ///  Procurando unidade  
            preg_match("/^unidade$|idunid|^codunid/ui",$chave, $matches3);
            if( count($matches3)>0 ) {
                 ///  pessoa  -  UNIDADE onde trabalha
                 $lc_unida=$chave;
                 $unidade=$valor;
                 $m_unidad="";
                 if( strlen(trim($unidade))>0 ) {
                     $m_unidad=" acentos_upper($lc_unida)=";
                     $m_unidad.="acentos_upper(\"$unidade\") ";
                 }
                 /***   Final - if( strlen(trim($unidade))>0 ) {  *****/
                 ///
            }
            ///
            ///  Procurando instiuicao  
            preg_match("/instituicao|^codinst|idinst/ui",$chave, $matches3);
            if( count($matches3)>0 ) {
                ///
                 ///  pessoa  -  INSTITUICAO onde trabalha
                 $lc_insti=$chave;
                 $instituicao=$valor;
                 $m_instit="";
                 if( strlen(trim($instituicao))>0 ) {
                     $m_instit=" acentos_upper($lc_insti)=";
                     $m_instit.="acentos_upper(\"$instituicao\")  and ";
                 }
                 /****  Final - if( strlen(trim($instituicao))>0 ) {   ****/
                 ///
            }
            /*****   Final - if( count($matches3)>0 ) {   ****/
            ///
        }  
        /***   Final - foreach( $array_seleciona as $chave => $valor ) {   ****/
        ///
        if( isset($matches) ) unset($matches);
        ///
        
        

/******************************        
  echo  "ERRO: editar_pessoal_ajax/620  -->>>  SEGUINDO NORMAL  <<<--- $lc_codigo = ".$array_seleciona["$lc_codigo"]
       ."  <<-->>   \$lc_codigo = $lc_codigo <<-->> \$encontrar = $encontrar  <<-->> \$_SESSION[tabela] = {$_SESSION["tabela"]} "
       ."  <br/> \$incluir_arq = $incluir_arq  -->>  \$encontrar = $encontrar <br/>"
        ." \$cpo_nome = $cpo_nome <br/>  \$cpo_valor = $cpo_valor ";
  exit();        
  ***************************/        
          
        
        
        
        
        
        
        
        ///
        ///  Tabela pessoal - alterar
        ////  if( isset($_SESSION["codigo_anterior"]) ) {
        $nerro=0;
        if( isset($_SESSION["cod_pessoal_ant"]) ) {  
             /// Codigo/Sigla da pessoa antes            
             $cod_pessoal_ant=$_SESSION["cod_pessoal_ant"];  
        } else {
            $txterr="Faltando SESSION codigo antes da pessoa.";
            $nerro=1;
        }
        /***
        *    Verifando se NAO HOUVE erro - codigo/sigla
        ****/
        if( intval($nerro)<1 ) {
            ///  
            if( isset($_SESSION["nome_pessoal_ant"]) ) {  
                 ///
                 /// Nome da pessoa antes            
                 $nome_pessoal_ant=$_SESSION["nome_pessoal_ant"];  
            } else {
                $txterr="Faltando SESSION nome antes da pessoa.";
                $nerro=1;
            }
            ///
        }
        ///
        /***
        *    Verifando se NAO HOUVE erro - Codigo/Sigla ou Nome
        ****/
        if( intval($nerro)<1 ) {
            ///  
            if( isset($_SESSION["email_pessoa_ant"]) ) {  
                 ///
                 /// EMail da pessoa antes            
                 $email_pessoa_ant=$_SESSION["email_pessoa_ant"];  
            } else {
                $txterr="Faltando SESSION e_mail antes da pessoa.";
                $nerro=1;
            }
            ///
        }
        ///
        ///  CASO HOUVE ERRO
        if( intval($nerro)>0 ) {
            echo $funcoes->mostra_msg_erro("$txterr");    
            exit();
        }
        
        ///  Banco de dados - BD/DB
        if( ! isset($_SESSION["bd_1"]) ) {
            echo $funcoes->mostra_msg_erro("Falha na SESSION bd_1 - corrigir.");    
            exit();
        }
        $bd_1 = $_SESSION["bd_1"];  
        ///
        ///    $banco_de_dados=$_SESSION["bd_1"];
        ///
        $nome_campo_1=""; $valor_campo_1="";
        $nome_campo_2=""; $valor_campo_2="";
        /****
        *     Campo Sigla/Codigo/ID e valor 
        *       da Tabela pessoal
        ****/
        if( isset($nome_campo[1]) )  $nome_campo_1=trim($nome_campo[1]);
        if( isset($valor_campo[1]) ) $valor_campo_1=trim($valor_campo[1]);
        ///
        if( ! isset($nome_campo_1) ) {
            echo $funcoes->mostra_msg_erro("Falha grave <b>variavel</b> campo nome sigla/código indefinida(o) - corrigir.");
            exit();
        }
        if( ! isset($valor_campo_1) ) {
            echo $funcoes->mostra_msg_erro("Falha grave <b>variavel</b> valor sigla/código indefinida(o) - corrigir.");
            exit();
        }
        if( strlen(trim($valor_campo_1))<1  ) {
            echo $funcoes->mostra_msg_erro("Falta sigla/código da pessoa - corrigir.");
            exit();
        }
        ///
        /********
        *       Campo  (nome) e valor 
        *     da Tabela pessoal
        ****/
        if( isset($nome_campo[2]) )  $nome_campo_2=trim($nome_campo[2]);
        if( isset($valor_campo[2]) ) $valor_campo_2=trim($valor_campo[2]);
        ///
        if( ! isset($nome_campo_2) ) {
            echo $funcoes->mostra_msg_erro("Falha grave <b>variavel</b> campo nome indefinida(o) - corrigir.");
            exit();
        }
        ///
        if( ! isset($valor_campo_2) ) {
            echo $funcoes->mostra_msg_erro("Falha grave <b>variavel</b> valor nome indefinida(o) - corrigir.");
            exit();
        }
        ///
        if( strlen(trim($valor_campo_2))<1  ) {
            echo $funcoes->mostra_msg_erro("Falta nome da pessoa - corrigir.");
            exit();
        }
        ///
        /******  Organizando os campos para alteracao na Tabela principal  *****/    
        $arycponm=explode(",",$cpo_nome);
        $arycpoval=explode(",",$cpo_valor);       
        ///
        $success_antes="UPDATE {$_SESSION["bd_1"]}.$data[0]  ";
        $success_antes.=" SET ";
        ///
        /****  Tipos dos campos da Tabela principal  ****/
        $xtypes="/^int$|^INTEGER$|^TINYINT$|^SMALLINT$|^MEDIUMINT$|^BIGINT$|^FLOAT$|^DOUBLE$|^DECIMAL$/ui";
        ///
        /// Nr. de elementos do Array
        $cntary=count($arycponm);
        for( $ne=0; $ne<$cntary; $ne++ ) {
             $m_nome_cpo=$arycponm[$ne];
             if( preg_match("$xtypes",$name_type[$m_nome_cpo]) )  {
                 $success_antes.=" $m_nome_cpo=$arycpoval[$ne] ";
             } else {
                 if( is_string($arycpoval[$ne]) )  {
                     ///  IMPORTANTE - Trocando esses simbolos por virgula na variavel STRING
                     $arycpoval[$ne]=preg_replace('/\|\#\&\>\|/',',',$arycpoval[$ne]); 
                 }
                 ///  IMPORTANTE USAR procedure clean_spaces para acertar espa?oes na variavel
                 $success_antes.="  $m_nome_cpo=$arycpoval[$ne]";
             }  
             ///  SEMPRE USAR -1 no TOTAL para nao adicionar na variavel , 
             if( $ne<$cntary-1 ) $success_antes.=", ";
             ///
        }
        /*****   Final - for( $ne=0; $ne<$cntary; $ne++ ) {  *****/
        ///
        ///  WHERE pelo codigo da Pessoa Cadastrada
        ///  Procurando pelo Array $arycponm  o nome da Tabela pessoal  do DEPARTAMENTO
        if( preg_match('/(departamento|depto)/ui', join(" ",$arycponm) ,$matches) ) {
             $nome_do_codigo=$matches[0];   
        } 
        if( isset($matches) ) unset($matches);
        ///
        /****  Variavel do codigo importante     ****/
        $codpri = $array_seleciona[$lc_codigo];
        $success_antes.=" WHERE acentos_upper($lc_codigo)=acentos_upper({$codpri}) ";
        ///
        ///  Verificando duplicata da Tabela - campos codigo,nome e email
        ///
        ///   Criando variavel para Tabela Temporaria
        ///  SELECT - SQL - Criando uma Tabela temporaria  
        if( isset($_SESSION["codigousp"]) ) { 
            $codigousp = $_SESSION["codigousp"];
        } else {
             $codigousp="9999999999";   
        }
        ///
        ///  Conexao BD/DB
        $conex = $_SESSION["conex"];
        /***
        *    Criando Tabela Temporaria
        ***/
        $tb_tmp_pessoal="tmp_pessoal_$codigousp";
        $_SESSION["tmp_edt_pessoal"] = "{$_SESSION["bd_1"]}.$tb_tmp_pessoal";
        $sql_editar_pessoal = "DROP TEMPORARY TABLE IF EXISTS  {$_SESSION["tmp_edt_pessoal"]} ";
        $res_edt=mysqli_query($_SESSION["conex"],$sql_editar_pessoal);
        ///  if( ! $res_edt ) {
        if( mysqli_error($_SESSION["conex"]) ) { 
             $txterr="Falha no DROP tabela $tb_tmp_pessoal -&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
             exit();
        }  
        ///
        ///  Desativando variavel             
        if( isset($res_edt) ) unset($res_edt);
        ///
        $tmp_edt_pessoal = "{$_SESSION["tmp_edt_pessoal"]}";
        ///
        ///  Criando tabela temporaria com codigos diferentes do codigo anterior da pessoa
        $rsql_edt= "CREATE TEMPORARY TABLE  IF NOT EXISTS {$tmp_edt_pessoal}  ";
        $rsql_edt.= "SELECT * FROM {$_SESSION["bd_1"]}.$tabpri   ";
        $rsql_edt.= " WHERE acentos_upper($lc_codigo)!=acentos_upper($cod_pessoal_ant)  ";
        ///     
        $create_tmp_tb = mysqli_query($_SESSION["conex"],$rsql_edt);            
        ///   if( ! $create_tmp_tb ) {
        if( mysqli_error($_SESSION["conex"]) ) { 
             $txterr="Falha no CREATE tabela {$_SESSION["tmp_edt_pessoal"]} -";
             $txterr.="&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
            exit();
        }       
        ///     Desativar variavel
        if( isset($create_tmp_tb) ) unset($create_tmp_tb);
        ///
        ///     Select/MYSQLI - VERIFICANDO CODIGO DA PESSOA
        $txt="SELECT * FROM {$tmp_edt_pessoal} ";
        $txt.=" WHERE  acentos_upper($lc_codigo)=acentos_upper(\"{$array_seleciona[$lc_codigo]}\") ";
        $result_pessoal=mysqli_query($_SESSION["conex"],"{$txt}");
        /***
        $result_pessoal=mysqli_query($_SESSION["conex"],"SELECT * FROM {$_SESSION["tmp_edt_pessoal"]} "
                 ." WHERE  clean_spaces($lc_codigo)={$array_seleciona[$lc_codigo]} ");
        ***/         
        /// if( ! $result_pessoal ) {
        if( mysqli_error($_SESSION["conex"]) ) { 
            /***  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysql: ".mysql_error().$msg_final;  
                 echo $msg_erro;  
            ****/
             $txterr="Consultando a Tabela $tmp_edt_pessoal -";
             $txterr.="&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
             exit();             
        }  
        ///  Nr. de Registros
        $m_regs=mysqli_num_rows($result_pessoal);
        ///  Desativando variavel 
        if( isset($result_pessoal) ) {
            mysqli_free_result($result_pessoal);  
        } 
        /***
        *    Verificando DUPLICATAS do CODIGO da pessoa    
        ***/
        if( intval($m_regs)>=1 ) {
            $temp_cpo_nome=$_SESSION["temp_array"]["$lc_codigo"];
            echo $funcoes->mostra_msg_erro("&nbsp;Esse&nbsp;"
                         ."$temp_cpo_nome:&nbsp;<b>{$array_seleciona[$lc_codigo]}</b>"
                         ."&nbsp;j&aacute; est&aacute; cadastrado(a).");
            exit();                      
        }
        ///
        ///     Select/MYSQLI -  VERIFICANDO EMAIL DA PESSOA
        $txt="SELECT * FROM {$tmp_edt_pessoal} ";
        $txt.=" WHERE  acentos_upper($lc_email)=acentos_upper(\"{$array_seleciona[$lc_email]}\") ";
        $res_pessoal=mysqli_query($_SESSION["conex"],"{$txt}");
        ////
        /// if( ! $res_pessoal ) {
        if( mysqli_error($_SESSION["conex"]) ) { 
            /***  $msg_erro .= "Falha consultando as tabelas projeto e pessoa  - db/mysql: ".mysql_error().$msg_final;  
                 echo $msg_erro;  
            ****/
             $txterr="Consultando a Tabela $tmp_edt_pessoal -";
             $txterr.="&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
             exit();             
        }  
        ///  Nr. de Registros
        $m_regs=mysqli_num_rows($res_pessoal);
        ///  Desativando variavel 
        if( isset($res_pessoal) ) {
            mysqli_free_result($res_pessoal);  
        } 
        /***
        *    Verificando DUPLICATAS do EMAIL da pessoa    
        ***/
        if( intval($m_regs)>=1 ) {
            $temp_cpo_nome=$_SESSION["temp_array"]["$lc_email"];
            echo $funcoes->mostra_msg_erro("&nbsp;Esse&nbsp;"
                         ."$temp_cpo_nome:&nbsp;<b>{$array_seleciona[$lc_email]}</b>"
                         ."&nbsp;j&aacute; est&aacute; cadastrado(a).");
            exit();                      
        }
        ///
        ///  Verificando o Setor de onde a Pessoa Trabalha
        if( isset($setor) ) {
            if( preg_match('/(Tod)[as|os|a|o]{0,3}/i',$setor) ) {
                $m_setor="";  
            } else {
               /// $m_setor=" and acentos_upper(setor)=acentos_upper(\"$setor\") "; 
                $m_setor=" and acentos_upper($lc_setor)=acentos_upper(\"$setor\") "; 
            }
        } else {
            $m_setor="";  
        } 
        /// 
        /**
        *      Verificando o Depto de onde a Pessoa Trabalha
        *  Procurando pelo Array $arycponm  o nome da Tabela pessoal  do DEPARTAMENTO  
        ***/
        
    /*******
        if( preg_match('/(departamento|depto)/i', join(" ",$arycponm) ,$matches) ) {
             $nome_do_depto=$matches[0];   
        } 
        if( isset($matches) ) unset($matches);
    *********/


///        if( isset($depto) or isset($departamento) ) {
        if( isset($depto)  ) {
            ///
            if( preg_match('/(Tod)[as|os|a|o]{0,3}/i',$depto) ) {
                $m_depto="";  $depto="";
            } else {
                ///
                //// $m_depto=" and clean_spaces($nome_do_depto)=clean_spaces('$depto') "; 
                 $m_depto=" and acentos_upper($lc_depto)=acentos_upper(\"$depto\") "; 
            }
        }  else {
            $m_depto="";  
        }
        /// 
        if(isset($result_pessoal)) unset($result_pessoal);
        /****
        *  Select/MYSQLI -  instituicao,unidade,depto e setor Tabela pessoal
        ***/
        $txt="SELECT $lc_insti,$lc_unida,$lc_depto,$lc_setor  ";
        $txt.=" FROM  {$_SESSION["bd_1"]}.$tabpri  ";
        $txt.=" WHERE  $m_instit $m_unidad $m_depto $m_setor  ";
        $result_pessoal=mysqli_query($_SESSION["conex"],"$txt");
        ///
        if( mysqli_error($_SESSION["conex"]) ) { 
             $txterr="Consultando a Tabela $tabpri -";
             $txterr.="&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
             exit();             
        }  
        ///
        /***
        $result_pessoal=mysqli_query($_SESSION["conex"],"SELECT instituicao,unidade,depto,setor  "
                  ." FROM  {$_SESSION["bd_1"]}.$tabpri  "
                 ." WHERE  clean_spaces(instituicao)=clean_spaces('$instituicao')  and  "
                 ." clean_spaces(unidade)=clean_spaces('$unidade')   "
                 ."  $m_depto    $m_setor  ");
        ***/         
        ///
        /***
        if( ! $result_pessoal ) {
            echo $funcoes->mostra_msg_erro("Consultando a Tabela $tabpri - db/mysql:&nbsp;".mysqli_error());
            exit();             
        }  
        ***/
        ///  Nr. de Registros
        $m_regs = mysqli_num_rows($result_pessoal);
        ///
        ////  Desativar variavel
        if( isset($result_pessoal) ) mysqli_free_result($result_pessoal);
        ///
        ///  Verificando caso HOUVE ERRO
        if( intval($m_regs)<1 ) {
            $temp_cpo_nome=$_SESSION["temp_array"]["$lc_codigo"];
            echo $funcoes->mostra_msg_erro("&nbsp;Nessa Tabela $tabpri os campos&nbsp;"
                         ."Institui&ccedil;&atilde;o:&nbsp;<b>$instituicao</b>,&nbsp;"
                         ."Unidade:&nbsp;<b>$unidade</b>&nbsp;e&nbsp;"
                         ."Departamento:&nbsp;<b>$depto</b>"
                         ."&nbsp;incorretos&nbsp;n&atilde;o&nbsp;se&nbsp;encaixam.");
            exit();                      
        }
        /*****   Final - if( intval($m_regs)<1 ) {   ***/
        ///  
        
        
/*********
  echo  "ERRO: library/editar_pessoal_ajax.php/993  -->>>  <b >CONTINUAR  FINAL</b>    "
             ." \$data[0] = {$data[0]}  - \$tabpri = $tabpri <<--  <br/>"
             ." \$_SESSION[tit_pag] = {$_SESSION["tit_pag"]} <br>"
                ." \$success_antes = <br> $success_antes ";
       exit();  
 ******/       

          
          
          
        ///
        ///    MELHOR MANEIRA DE ENVIAR DADOS DO PHP PARA MYSQL -  UTF8_DECODE  - //  IMPORTANTE 2013
        ///  $codigo = utf8_decode($codigo);
        ///   $descricao =utf8_decode($descricao);
        ///
        ///  START  a transaction - ex. procedure    
        mysqli_query($_SESSION["conex"],'DELIMITER &&'); 
        $commit="commit";
        mysqli_query($_SESSION["conex"],'begin'); 
        ///
        ///  Execute the queries 
        ///  $success = mysqli_query("insert into pessoa (".$campos.") values(".$campos_val.") "); 
        ///  mysqli_db_query - Esta funcao esta obsoleta, nao use esta funcao 
        ///   - Use mysqli_select_db() ou mysqli_query()
        mysqli_query($_SESSION["conex"],"LOCK TABLES  {$_SESSION["bd_1"]}.$data[0] UPDATE");
        ///
        ///  Alterando dados na Tabela pessoal
        /****  $success=mysqli_query("UPDATE $data[0] SET $nome_campo_1=clean_spaces('$valor_campo_1'), "
                              ." $nome_campo_2=clean_spaces('$valor_campo_2')  "
                              ." WHERE clean_spaces($nome_campo_1)=clean_spaces('$sigla_da_hpadrao') ");
        ****/
        $success=mysqli_query($_SESSION["conex"],$success_antes);                              
        ////
        ///  if( ! $success ) {
        if( mysqli_error($_SESSION["conex"]) ) { 
             ///  Ocorreu falha alterando cadastro
             $commit="rollback";
             $txterr="Alterando dados na Tabela $tabpri -";
             $txterr.="&nbsp;db/Mysqli:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($conex)); 
             ///
        } elseif( $success ) {
            /// Sucesso
            echo $funcoes->mostra_msg_ok("Cadastro alterado.");           
        }
        /*!40000 ALTER TABLE  ENABLE KEYS */;
        mysqli_query($_SESSION["conex"],$commit);
        mysqli_query($_SESSION["conex"],"UNLOCK  TABLES");
        ///  Complete the transaction 
        mysqli_query($_SESSION["conex"],'end'); 
        mysqli_query($_SESSION["conex"],'DELIMITER');
        ///
        exit();
        ///
  }
  /// 
}  
/// FINAL do IF array $data
///
/****
       $cmdhtml="<a href='#' onclick='javascript: dochange(\"SELECIONADO\",\"$tabpri\",\"$parte[0]#codigo\");return true;' class='linkum' title='Clicar' >";
***/
if( is_string($data) ) {
    ///
    ///
    ///  Retornar para a Tabela de registros encontrados
    if( preg_match("/^retornar$/i",$data) ) {
         if( isset($_SESSION["tabela_salva"]) ) {
              echo $_SESSION["tabela_salva"];    
         }
         exit();
    }    
    ///
    ///  SELECIONADO apenas um registro
    /// if( strtoupper(trim($data))=="SELECIONADO" ) {
    
    
             
      echo  "ERRO:  editar_pessoal_ajax/994  -->>  STRING "
            ."  \$data = $data --  \$val = $val  ---  \$tabela = $tabpri ";
         exit();
         
    
    
    if( preg_match("/^(SELECIONADO|IDMOSTRAR_RESULTADO2)$/i",trim($data)) ) {
        /// 
        $_SESSION["mostra_resultado"]="SELECIONADO";
        ///
        if( strtoupper(trim($data))=="IDMOSTRAR_RESULTADO2" ) {
            //  SESSION para guardar pagina
            if( isset($_SESSION["tabela_salva"]) ) unset($_SESSION["tabela_salva"]);
            //
        }    
        //  Nome da Tabela
        if( isset($val) ) {
            $tabela=trim($val);   
        } elseif( ! isset($val) ) {
             echo $funcoes->mostra_msg_erro("Falha na vari?vel");    
             exit();                              
        }
        //  Verificando falha na variavel da Tabela       
        if( strlen($tabela)<1 ) {
             echo $funcoes->mostra_msg_erro("Ocorreu uma falha na vari?vel.");    
             exit();                                          
        }
        //  Verifica  variavel  ofr array  com elementos:  campo e valor
        if( is_array($m_array) ) {
             $campo_selecionado=$m_array[0];
             $val=$m_array[1];
             ///
             ///   SELECT PARA VERIFICAR O TIPO DO CAMPO DA TABELA
            $result_tabela=mysqli_query($_SESSION["conex"],"SELECT * FROM {$_SESSION["bd_1"]}.$tabela  limit  1 ");
            if( ! $result_tabela ) {
                die('Select tabela $tabela - falha: '.mysqli_error());
                exit();
            }
            //
            $fields = mysqli_num_fields($result_tabela);
            $rows   = mysqli_num_rows($result_tabela);
            $table  = mysqli_field_table($result_tabela, 0);
            /*  echo "Your '" . $table . "' table has " . $fields . " fields and " . $rows . " record(s)\n";
                echo "The table has the following fields:\n";
            */    
            // Verificando o Tipo do Campo da Tabela
            for( $i=0; $i < $fields; $i++) {
                $type  = mysqli_field_type($result_tabela, $i);
                $name  = mysqli_field_name($result_tabela, $i);
                $len   = mysqli_field_len($result_tabela, $i);
                $flags = mysqli_field_flags($result_tabela, $i);
                $name_type[$name]=$type;
                //  QUAL O TIPO DESSA VARIAVEL DENTRO DO CAMPO DA TABELA
                if( strtoupper(trim($name))==strtoupper(trim($campo_selecionado)) ) {
                      switch ($name_type[$name]) {
                           case "string":
                              $where=" WHERE upper(clean_spaces($campo_selecionado))=upper(clean_spaces('$val'))";
                              break;
                           case "int":
                              $where=" WHERE  $campo_selecionado=$val ";       
                              break;
                           case "date":
                              if( strlen(trim($val))<3 ) {
                                  $val='0000-00-00';
                              } else {
                                  if( strlen(trim($val))>9 ) {
                                      $val=trim($val);
                                      $val=substr($val,6,4)."-".substr($val,3,2)."-".substr($val,0,2);    
                                  }
                              }
                              $where=" WHERE  $campo_selecionado='$val' ";       
                              break;
                           default:   
                              break;      
                      }
                      $i=99999999;
                      break;
                }
                //  
            }
            ///             
        }
        ///  
        $_SESSION["disabled"]='';
        ///
        ///  REGISTRO SELECIONADO
        $sqlcmd ="SELECT  * FROM {$_SESSION["bd_1"]}.$tabela   $where  ";
        $result_outro= mysqli_query($_SESSION["conex"],$sqlcmd);                                    
        ////  if( ! $result_outro ) {
        if( mysqli_error($_SESSION["conex"]) ) { 
            $txterr="Selecionando o registro da Tabela - db/Mysql:&nbsp;";
             echo $funcoes->mostra_msg_erro("$txterr".mysqli_error($_SESSION["conex"]));  
             exit();  
        } 
        ///
        
               
        ///                  
    /*    $m_linhas = mysqli_num_rows($result_outro);    
        $total_registros=$m_linhas;      
      */
        $total_registros = mysqli_num_rows($result_outro);    
        
        
  ///     echo "ERRO:  LINHA/644 --  \$total_registros = $total_registros  -- \$where = $where ";
     ///   exit();
           
        
        if( $total_registros<1 ) {
             echo $funcoes->mostra_msg_erro("Nenhum registro encontrado.");
             exit();      
        } else {
              //   Desativando a variavel 
              if( isset($array_nome_val) ) unset($array_nome_val);
              if( isset($nome_cpo_id) ) unset($nome_cpo_id);
              //  IMPORTANTE - Definindo os nomes dos campos recebidos do MYSQL SELECT - mysqli_fetch_array
              $array_nome_val=mysqli_fetch_array($result_outro);
              
               //  numero de campos
              $n_fields = mysqli_num_fields($result_outro);
              //   Criando array m_value_c
              for( $i=0; $i<100 ; $i++ ) $_SESSION["m_value_cpo"][$i] ="";   
              //    
              for( $i=0; $i<$n_fields ; $i++ )  {
                   $nome_cpo_id[$i] = trim(mysqli_field_name($result_outro,$i));   
                   $nome_do_cpo=$nome_cpo_id[$i];
                    //  Tamanho do campo da Tabela
                    $len_c[$i] = mysqli_field_len($result_outro,$i);
                   //  Criando array nome do campo e tamanho do campo
                   $len_nomecpo[$nome_do_cpo]=$len_c[$i];
                   //  $_SESSION["m_value_cpo"][$i] =  html_entity_decode(mysqli_result($result_outro,0,$i)); 
                   $_SESSION["m_value_cpo"][$i] =  mysqli_result($result_outro,0,$i); 
              }

              //  Caso tenha um registro
               if( isset($result_outro) ) {
                   //  $nome=mysqli_result($result_outro,0,"nome");
                   //  IMPORTANTE - Definindo os nomes dos campos recebidos do MYSQL SELECT - mysqli_fetch_array
                   foreach( $array_nome_val as $cpokey => $cpovalue ) $$cpokey=$cpovalue;
               } 
               include("{$_SESSION["incluir_arq"]}includes/resultado_editar_pessoal.php");
               //
               exit();
        }

         
        
        

            $n_fields="";
            //  $tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
            $marray_gp = array("grupo","pessoal"); 
            if( strlen($tabela)>1 ) {
                $result=mysqli_query($_SESSION["conex"],"SELECT * from  ".$tabela." limit 0 ");            
                if( ! $result ) {
                     echo $funcoes->mostra_msg_erro("Falha no select da Tabela $tabela - db/Mysql:&nbsp; ".mysqli_error());                     //  echo "ERRO: Falha no select da Tabela ".$tabela.": ".mysqli_error();
                     exit();
                } else  $n_fields = mysqli_num_fields($result);
            }

         if( $n_fields>=1 ) {
             for( $i=0; $i<$n_fields ; $i++ )  {
                  //  nome do campo da Tabela
                  $nome_cpo_id[$i] = trim(mysqli_field_name($result,$i));   
                  // Tamanho do campo da Tabela
                  $len_c[$i]  = mysqli_field_len($result,$i);
             }
         }
         //
         $_SESSION["num_cols"]=$n_fields; 
         if( isset($_SESSION["num_cols"]) ) $num_cols=$_SESSION["num_cols"];
         $m_onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";    
         if( in_array($tabela,$marray_gp) ) {
             $m_onkeyup="javascript: acertar_espacos(this.id,this.value); somente_numero(this);";
         } 
         
         
         echo "ERRO: \$data = $data --  \$val = $val  ---  \$tabela = $tabpri ";
         exit();
         
         
         //  Incluir a Tabela depois da CONSULTA       
         include("{$_SESSION["incluir_arq"]}includes/inc_editar_pessoal_ajax.php");
         //
    }
    ///
}       
///  Final - if( is_string($data) ) {
#
ob_end_flush(); 
#
?>