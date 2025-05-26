<?
//  Form da  Tabela  Usuario
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
//  Tabelas atributo, categoria, financiadora, grupo
// $type  = mysql_field_type($result, $i);
// $flags = mysql_field_flags($result, $i);
$name_c0 = $name_c_id[0];
$name_c1 = $name_c_id[1];
$name_c4 = $name_c_id[4];
if ( $name_c4 == "codigousp" ) $name_c4 = "C&oacute;digo";
$name_c5 = $name_c_id[5];
$m_onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();";
if ( $name_c_id[0]=="codigo" ) $name_c0 = "C&oacute;digo";
if ( $name_c_id[0]=="historico" ) $name_c0 = "Hist&oacute;rico";	   
if ( $name_c_id[1]=="descricao" ) $name_c1 = "Descri&ccedil;&atilde;o";
$marray_gp = array("grupo","pessoal");
$encontrar = trim($_SESSION["m_nome_id"]);
if ( in_array($encontrar,$marray_gp) ) $m_onkeyup="javascript:somente_numero(this);"; 
	     /* $len_c[0]   = mysql_field_len($result,0);
         $len_c[1]   = mysql_field_len($result,1);       */
     ?>
       <tr>
                <td width="161"  nowrap="nowrap" class="td_normal"  >
                <table>
                <tr>
                <td>
         <span class="td_informacao2"  ><?=ucfirst($name_c0);?>:<br />
          <input type="text" name="<?=$name_c_id[0];?>"   id="<?=$name_c_id[0];?>" size="32"  maxlength="<?=$len_c[0];?>"  class="td_select"  onKeyUp="this.value=trim(this.value);javascript:this.value=this.value.toLowerCase();"  onblur="validar()"   
		   value="<?=$m_value_c[0];?>"   <? if( $m_editando or $m_disabled=="disabled" ) echo "disabled"; ?>  title="<?=ucfirst($name_c0);?>&nbsp; no m&iacute;nimo 8 caracteres"   style="cursor: pointer;<?=$m_style_disabled;?>"  >
                 </span>
                         </td>
            <td width="517"  align="left" nowrap="nowrap"  class="td_normal"  >
            <!-- Senha -->
                  <span class="td_informacao2"   ><?=ucfirst($name_c1);?>:<br />
             <input type="password"  name="<?=$name_c_id[1];?>"  id="<?=$name_c_id[1];?>"  size="92"  maxlength="<?=$len_c[1];?>" class="td_select"    value="<?=$m_value_c[1];?>"  title="<?=ucfirst($name_c1);?>&nbsp; no m&iacute;nimo 8 caracteres"   onblur="validar()" <?=$m_disabled;?>  onKeyUp="this.value=trim(this.value);"  style="cursor: pointer;<?=$m_style_disabled;?>"  >
                </span>                 
                                </td>
                                </tr>
                                </table>
                          </td>    
                </tr>     
       <tr>
                <td width="161"  nowrap="nowrap" class="td_normal"  >
                <table>
                <tr>
                <td>
            <!-- Codigo/USP -->				
         <span class="td_informacao2"  ><?=ucfirst($name_c4);?>:<br />
          <input type="text"  id="<?=$name_c_id[4];?>" size="32"  maxlength="<?=$len_c[4];?>"  class="td_select"  onKeyUp="javascript:somente_numero(this);"  onblur="validar()"   
		   value="<?=$m_value_c[4];?>"   <? if( $m_editando or $m_disabled=="disabled" ) echo "disabled"; ?>  title="<?=ucfirst($name_c4);?>"   style="cursor: pointer;<?=$m_style_disabled;?>"  >
                 </span>
                         </td>
            <td width="517"  align="left" nowrap="nowrap"  class="td_normal"  >
            <!-- PA -->
                  <span class="td_informacao2"   ><?=ucfirst($name_c5);?>:<br />
             <input type="text" id="<?=$name_c_id[5];?>"  size="28"  maxlength="<?=$len_c[5];?>" class="td_select"    value="<?=$m_value_c[5];?>"  title="<?=ucfirst($name_c5);?>"   onblur="validar()" <?=$m_disabled;?>  onKeyUp="this.value=trim(this.value);javascript:somente_numero(this);"  style="cursor: pointer;<?=$m_style_disabled;?>"  >
                </span>                 
                                </td>
                                </tr>
                                </table>
                          </td>    
                </tr>     
