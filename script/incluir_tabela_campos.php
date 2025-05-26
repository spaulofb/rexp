<?php
 //  CAMPOS DAS TABELAS atributo, categoria,depto
$tabelas_array = array("atributo","categoria","financiadora","grupo","hpadrao","instituicao");
$encontrar=trim($_SESSION["m_nome_id"]);
$script_name = $_SERVER["SCRIPT_NAME"];  $http_host = $_SERVER["HTTP_HOST"];
$m_juntos_link = "http://".$http_host.$script_name;
$_SERVER["m_juntos_link"] = $m_juntos_link;
// if para verificar se a variavel e' do tipo Boolean
if( ( ! is_bool($m_consultar)) or ( ! is_bool($m_editando))  or ( ! is_bool($m_excluir))  ) {
       trim($m_consultar)=="0" or strlen(trim($m_consultar))<1 ? $m_consultar=false : $m_consultar=true;
    trim($m_editando)=="0" or strlen(trim($m_editando))<1 ? $m_editando=false : $m_editando=true;
	trim($m_excluir)=="0" or strlen(trim($m_excluir))<1 ? $m_excluir=false : $m_excluir=true;
}
if( ! $reservadodeuso_ajax  ) echo "<form name='nome_form'  method='get'  >";
//
if ( strlen(trim($_SESSION["m_nome_id"]))<1 ) { 
   echo "N&atilde;o tem tabela ".$_SESSION["m_nome_id"];
} elseif ( strlen(trim($_SESSION["m_nome_id"]))>=1 )  {
    if( $m_consultar===false ) $m_disabled = ""; 
	/*
	$m_value_c0 =""; $m_value_c1 = "";
    $m_value_instit = ""; $m_value_unidade = ""; $m_value_sigla = ""; $m_value_nome = "";
	*/
	for ( $i=0; $i<100 ; $i++ ) $m_value_c[$i] ="";  				
  //  if ( $_SESSION['m_editando']===true  ) {
   if ( $m_consultar===true or $m_editando===true  or  $m_excluir===true  ) {  
    	$m_juntos_link = "selecionar_todos.php";
	   $m_style_disabled1='';  $m_style_disabled='';		
   	   if ( $m_consultar===true or $m_excluir===true  ) {  
            $m_disabled = "disabled"; $m_style_disabled=' background-color:#000; color: #FFF;';
		    $m_style_disabled1=' background-color:#000; color: #FFF;';
			?>
			<script type="text/javascript" >
			   $('select:disabled'); 
			</script>
			<?
        } elseif( $m_editando===true )  {
		   $m_disabled="";
		   $m_style_disabled1=' background-color:#000; color: #FFF;';
		   $m_style_disabled='';
		}
      $n_fields = mysql_num_fields($result);
	  for ( $i=0; $i<$n_fields ; $i++ ) {
	     $m_value_c[$i] =  htmlentities(mysql_result($result,0,$i)); 
	  }
	} else {
         mysql_free_result($result); 
		 if( strlen($encontrar)>1 ) {
	        $result=mysql_db_query($dbname,"select * from  ".$encontrar." limit 0 ");
    	    if (!$result) {
	    	     echo "ERRO: Falha no select da Tabela ".$encontrar.": ".mysql_error();
	         } else {
    	     	 $n_fields = mysql_num_fields($result);
	    	 }	 
	     }
    }
    if ( $n_fields>=1 ) {
	     for ( $i=0; $i<$n_fields ; $i++ )  {
             $name_c_id[$i] = trim(mysql_field_name($result,$i));   
              $len_c[$i]  = mysql_field_len($result,$i);
	     }
    }
    //  Tabelas atributo, categoria, financiadora, grupo
    //  if( $m_consultar===true ) require_once("../consultar/patrimonio_consultado.php");
    if( $m_consultar===true or $m_excluir===true ) {  
		  $m_disabled = "disabled"; $m_editando=false;
		  $m_style_disabled=' background-color:#000; color: #FFF;';
	} else $m_consultar=false;
	//
	if (  in_array($encontrar,$tabelas_array)  ) {
          require("form_tabelas_atr_cat_fin.php");
          //  Tabela depto - Departamento
	} elseif(  strtoupper(trim($_SESSION["m_nome_id"]))=="BEM" ) {
		  $m_nome_da_tabela="bem"; $m_linhas=1; 
		 // Editando - Tabela bem/patrimonio  
	     if($m_editando===true) {
        		// $_GET['clp']=$m_clp;
				if( $nome_campo_1!=="nome" ) {
				    $val=$m_clp; $data='clp'; 
				}
		       require_once("../editar/selecionar_bd_patrimonio.php");
		 }
		 //  Consultando - Tabela bem/patrimonio  
	    if( $m_consultar===true )  {
	   	 	  unset($src);  $src="encontrado"; $executou = 0;
	          $_SESSION["m_consultar"] = $m_consultar;
	          $m_http_host = $_SERVER["HTTP_HOST"];
 	          if ( trim($data[1])=="consulta_registro_selecionado" ) {
                       $m_clp=$val; $src='clp'; $data='clp';
              }
              $s_cons="http://www-gen.fmrp.usp.br/gemac/patrimonio/consultar";
    	      $s_cons.="/bd_patrimonio_novo.php";
			  //  $s_cons.="/patrimonio_consultado.php";
			  // s_cons.="?val="+m_mostrar_result+"&executou="+executou;
    	      $novo_link=$s_cons."?src=".$src."&executou=".$executou."&val=".$m_clp."&m_consultar=".$m_consultar;
		      //		  "http://$m_http_host/gemac/patrimonio/consultar/patrimonio_consultado.php?src=".$src; 
    	      echo $novo_link;
	    }
	  	exit();
    } elseif(  strtoupper(trim($_SESSION["m_nome_id"]))=="BEMPARTILHADO" ) {
	     //  if  RESERVADEUSO 
	    if( str_ireplace(" ","",strtoupper(trim($tit_pag)))=="RESERVADEUSO" )  {
		      //   $_SESSION["VARS_AMBIENTE"] = "unidade|depto|setor|bloco|salatipo|sala";		   
              require("form_reserva_de_uso.php");		
	    }
    } elseif(  trim($_SESSION["m_nome_id"])=="depto" ) {
        require("form_tabela_depto.php");		
    }  elseif(  trim($_SESSION["m_nome_id"])=="fornecedor" ) {
        require("form_tabela_fornecedor.php");
    } elseif(  trim($_SESSION["m_nome_id"])=="pessoal" ) {
        require("form_tabela_pessoal.php");		   
	} elseif(  trim($_SESSION["m_nome_id"])=="projeto" ) {
        // $m_value_c[5] = implode("/",array_reverse(echo explode("-",$m_value_c[5])));
        // $m_value_c[6] = implode("/",array_reverse(echo explode("-",$m_value_c[6])));
        require("form_tabela_projeto.php");		   
	} elseif(  trim($_SESSION["m_nome_id"])=="setor" ) {
        require("form_tabela_setor.php");		
    } elseif(  trim($_SESSION["m_nome_id"])=="unidade" ) {
        require("form_tabela_unidade.php");		
    } elseif(  trim($_SESSION["m_nome_id"])=="usuario" ) {
        require("form_tabela_usuario.php");		
    } 
}
//   Verifica se nao e' consultar e nao for da tabela  bempartilhado      
if ( $m_consultar===false && strtoupper(trim($_SESSION["m_nome_id"]))!="BEMPARTILHADO"  ) {
?>      
<tr align="center" style="position: relative; text-align:center;" >
         <!--  Botoes para Salvar ou Cancelar Patrimonio -->
         <td align="center" valign="top"  nowrap="nowrap"  class="td_normal" style="width: 140px; margin: 0px; paddin
g: 0px; white-space:nowrap; "  >
                                  <table align="left">
                                  <tr>
                                  <td>
                   <span  class="botao3d_maior"  style="width: 120px; margin-top: 0px; vertical-align:top;" >
                <a href="javascript:salvar_tabela('m_salvar_<?=$_SESSION["m_nome_id"];?>')" 
                        id="m_salvar_<?=$_SESSION["m_nome_id"];?>"   title="Clicar"   >Salvar</a></span>
                </td>
                  <td  >
                <span class="botao3d_maior"  style="width: 120px; margin-top: 0px; vertical-align:top; " ><a href="<?=$m_juntos_link;?>?m_nome_
id=<?=$_SESSION["m_nome_id"];?>" id="m_cancelar_<?=$_SESSION["m_nome_id"];?>"    title="Clicar"   >Cancelar</a></span>
                </td>
                </tr>
                </table>
                </td>
        </tr>
<?php
}	
if( ! $reservadodeuso_ajax  ) echo "</form>";
//  Arquivo da Listagem 
if(  trim($_SESSION["m_nome_id"])=="depto" ) {
   require("listagem_tabela_depto.php");
} elseif( trim($_SESSION["m_nome_id"])=="usuario" ) {
    require("listagem_tabela_usuario.php");
} else {
    //  Importante para o arquivo reservadeuso.php
    if( strtoupper(trim($_SESSION["m_nome_id"]))!="BEMPARTILHADO" ) require("listagem_algumas_tabelas.php");
}  
?>