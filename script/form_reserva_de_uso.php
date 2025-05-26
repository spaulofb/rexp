<!--  A sessao VARS_AMBIENTE foi incluido no arq script/incluir_tabela_campos  -->
<tr>
  <td class="td_normal"  >
  <table align="left" style="margin-top: 0px; padding-top: 0px;">
        <!-- CLP -->
         <tr>
            <td  align="left" nowrap="nowrap"  class="td_normal"  >
               <span class="td_informacao2" style="padding-left: 2px;"  >
                       <label for="CLP" style="cursor:pointer;" >CLP</label>:&nbsp;
                  <input type="text"  name="CLP" id="CLP"   size="<?php echo $len_c[0]+5;?>"   maxlength="<?php echo $len_c[0];?>" class="td_select"   value=""  <?php echo $m_disabled;?>    style="margin-top: 0;padding-top: 0; text-align:left; cursor: pointer; "   title='Digitar:&nbsp;CLP (<?php echo $len_c[0];?> caracteres) - Ex.: 17RGE1234567' onkeyup="this.value=trim(this.value);javascript:this.value=this.value.toUpperCase();"  onkeypress='keyhandler(this.name,this.value,"busca"); '   >    
                 </span>	
                </td>
		        <!-- FIM - CLP -->
			  <!--  Inciando Unidade, Deptro, etc...  -->
				 <td  class="td_normal"  nowrap="nowrap"  style="margin-left: 0px; padding-left: 0px; padding-top: 20px; position:relative;"  >
				 </td>
				 </tr>
				 <tr>
				 <td style="margin-leeft: 0px;" >
                  <span class="td_informacao2"  >&nbsp;<b>Ou</b>&nbsp;
                     <label for="unidade" style="cursor:pointer;" >Unidade</label>:&nbsp;
                 <select tabindex="1" name="unidade" class="td_select" id="unidade"  
				             onchange="dados_recebidos('CONJUNTO',this.value,this.name+'|'+'<?php echo $_SESSION["VARS_AMBIENTE"];?>');"  >			
			   <?php
			      //  UNIDADE
                 $result=mysql_db_query($dbname,"SELECT sigla FROM unidade order by nome ");
                 $m_linhas = mysql_num_rows($result);
                 if ( $m_linhas<1 ) {
                        echo "<option value='' >&nbsp;Nenhum encontrado&nbsp;</option>";
                 } else {
                     echo "<option value='>&nbsp;Selecionar&nbsp;' >&nbsp;Selecionar&nbsp;</option>";
               	     while($linha=mysql_fetch_array($result) ) {       
 			             if( $linha['sigla']==$_SESSION['unidade'] ) { 
    					      $inst_selected = "selected='selected'";
					     } else   $inst_selected = "";					  
 					     //  Desativando selected - opcao que fica selecionada
				         $inst_selected = "";					  
                         echo  "<option  $inst_selected "
					           ." value=".urlencode($linha['sigla'])."  style='cursor:pointer;' >&nbsp;";
                         echo  trim($linha['sigla'])."&nbsp;";
                         echo  "&nbsp;</option>" ;
                     }
					 ?>
	              </select>
	               </span>
					<?php
                    mysql_free_result($result_tb_temp1); 
                    mysql_free_result($result); 
                  }
 				  // Final da Unidade
				  ?>				  
				</td>
				   <?php
				   $td_campos_array = explode("|",$_SESSION["VARS_AMBIENTE"]);
				   /* Dica sobre o count ou sizeof 
				      Evite de usar for($i=0; $i < count($_linhas); $i++. Use: 
                           $total = count($_linhas); 
				           for($i=0; $i < $total; $i++) 
                      Pois o for sempre irá executar a função count, 
					  pesando na velocidade do seu programa. 
                   */ 
				   // Nao comeca no Zero porque ja tem o primeiro campo acima - UNIDADE
				   $total_array = count($td_campos_array);
				   for( $x=1; $x<$total_array; $x++ ) {
	   				    $id_td = "td_".$td_campos_array[$x];
				   		echo  "<td  nowrap='nowrap'  class='td_normal'  "
						        ."    id=\"$id_td\" style='display:none;'   >";
				        echo '</td>';
					}
					?>
              </tr>
			  <!--  Final - Unidade, Deptro, etc...  -->
  </table>
  </td>
  </tr>
  <tr>
    <td>
     <table align="left" style=" margin-top: 0px; padding-top: 0px; " >
			 <tr>
			   <!-- td - indicando erro -->
	 			 <td style="vertical-align: bottom; padding-left: 8px;" >
		     		  <font  id="msg_erro1" style="display: none; " ></font>			  
        		 </td>
			     <!-- Final - label indicando erro -->
             </tr>  

	 	    <!-- CONTROLADOR -->
         <tr  id="tr_controlador"   style="display: none; margin-top: 0px; padding-top: 0px; white-space: nowrap; position:relative;" nowrap="nowrap"  >
            <td   align="left" nowrap="nowrap"  class="td_normal"  >
               <span   class="td_informacao2" style="padding-left: 2px; white-space: nowrap;  "  >
                       Controlador:&nbsp;
	              <input type="text"   name="<?php echo $name_c_id[1];?>" id="<?php echo $name_c_id[1];?>"    size="<?php echo $len_c[1]+5;?>"   maxlength="<?php echo $len_c[1];?>" class="td_select"   value=""      style="margin-top: 0;padding-top: 0; text-align:left; cursor: pointer; white-space: nowrap;"   onfocus='javascript: keyhandler(document.getElementById("<?php echo $name_c_id[0];?>").name,document.getElementById("<?php echo $name_c_id[0];?>").value,"controlador"); '  title='Digitar:&nbsp;Controlador'    onkeypress='javascript: keyhandler(this.name,this.value,"busca");'   >    
                 </span>	
       <!-- FIM - Controlador -->
     </td>
	     <!-- label indicando erro -->
	 	 <td style="vertical-align: bottom; padding-left: 8px;" >
     		  <label for="<?php echo $name_c_id[1];?>"  id="msg_erro2" style="display: none; " >
                 <font  ></font>			  
          	  </label>
         </td>
	     <!-- Final - label indicando erro -->
	 </tr>

	 <tr >
  	    <td>
   	      <!-- font indicando bens encontrados -->
             <font id="tab_de_bens" style="display: none;"  ></font>			  
   	      <!-- Final - font indicando bens encontrados -->		   
	    </td>
	  </tr>
    </table>
  </td>                         
</tr>