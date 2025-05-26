<?php
//    MOSTRAR CADASTRO ENCONTRADO NA CONSULTA
//  Cod_Num_USP/Autor Coautor e demais
$elemento=5; $m_linhas=0;
/*   Atrapalha e muito essa programacao orientada a objeto
       include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
       $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ");
*/
include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
mysql_select_db($db_array[$elemento]);
//  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
$result_nome=mysql_query("select codigousp,nome,categoria from pessoa  order by nome ");
if( ! $result_nome ) {
     mysql_free_result($result_nome);
     die('ERRO: Select pessoa - falha: '.mysql_error());  
}
$m_linhas = mysql_num_rows($result_nome);
if ( $m_linhas<1 ) {
       echo "Nenhum registro encontrado na tabela pessoa";
       exit();      
}
//
while($linha=mysql_fetch_assoc($result_nome)) {
         $arr["codigousp"][]=htmlentities($linha['codigousp']);
         $arr["nome"][]=  ucfirst(htmlentities($linha['nome']));
         $arr["categoria"][]=$linha['categoria'];
}
$count_arr = count($arr["codigousp"])-1;	 
$_SESSION["autor_codigousp"]=mysql_result($result,0,"autor");
//   Data Mysql para PHP
$datainicio=mysql_result($result,0,"datainicio");
$datainicio=substr($datainicio,8,2)."/".substr($datainicio,5,2)."/".substr($datainicio,0,4);
$datafinal=mysql_result($result,0,"datafinal");
$datafinal=substr($datafinal,8,2)."/".substr($datafinal,5,2)."/".substr($datafinal,0,4);
//  Numero de Coresponsaveis
$coresponsaveis = mysql_result($result,0,"coresponsaveis");
//  Num do Projeto
$numprojeto = mysql_result($result,0,"numprojeto");
//  Arquivo do relatorio do Projeto (link)
$posicao_enc = strpos(mysql_result($result,0,"relatproj"),"_");
$relatproj = mysql_result($result,0,"relatproj");
$arquivo_link="../doctos_img/A".$_SESSION["autor_codigousp"]."/projeto/".$relatproj;
$arq_relatorio_link = substr(mysql_result($result,0,"relatproj"),$posicao_enc+1,strlen(mysql_result($result,0,"relatproj")));

?>
  <table class="table_inicio" cols="4" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000;   "  >
    <tr style="text-align: left;"  >
    <td  class="td_inicio1" style="vertical-align: middle;text-align: right;" colspan="1"  >
      <label   title="Código do Autor Responsável"   >Autor Respons&aacute;vel:&nbsp;</label>
      </td>
      <td class="td_inicio1" style="text-align: left;"  colspan="3"  >
        <!-- N. Funcional USP - Autor -->
		<?php 
		   for( $jk=0; $jk<=$count_arr; $jk++ ) {
                  if(  $_SESSION["autor_codigousp"]==$arr["codigousp"][$jk] ) {
					      // $autor_codigousp=$arr_cnc["codigousp"][$jk];
						   $_SESSION["autor_codigousp"]=$arr["codigousp"][$jk];
						   $_SESSION["autor_nome"]=$arr["nome"][$jk];
						   $autor_categoria=$arr["categoria"][$jk];
					}
           }
         ?>  
     <span class='td_inicio1' style="border:none; color:#000000;" title='Nome do Autor Responsável do Projeto' >&nbsp;<?php echo $_SESSION["autor_nome"];?>&nbsp;</span>
     <span  class="td_inicio1" style="vertical-align: middle;text-align: left;" colspan="1"  >
      <label   title="N&uacute;mero do Projeto"   >Nr. do Projeto:&nbsp;</label>
     <span class='td_inicio1' style="border:none; color:#000000;" title='N&uacute;mero do Projeto' >&nbsp;<?php echo  $numprojeto;?>&nbsp;</span>
	  </span>
      </td>
    </tr>
	   <tr style="text-align: left;"  >
     <!--  Titulo do Projeto  -->
    <td  class="td_inicio1" colspan="4" style="text-align: left;  background-color: #32CD99; " >
      <label for="titulo"  style="vertical-align: top; color:#000000; background-color: #32CD99; cursor:pointer;" title="Título do Projeto"   >T&iacute;tulo:&nbsp;</label>
       <textarea rows="3" cols="85" name="titulo" id="titulo"  title='T&iacute;tulo do Projeto' style="cursor: pointer; overflow:auto;"  readonly="readonly"  ><?php echo mysql_result($result,0,"titulo");?></textarea>      
        </td>
     <!-- FINAL -  Titulo do Projeto  -->
    </tr>
	
     <tr style="text-align: left;"  >
     <!-- OBJETIVO  -->
	  <td  class="td_inicio1" style="vertical-align: middle; text-align: right;" colspan="1"  >
      <label for="objetivo"  style=" cursor:pointer;" title="Objetivo do Projeto"   >Objetivo:&nbsp;</label>
      </td>
      <td class="td_inicio1" style="text-align: left;"  colspan="3"  >
	     <?php 
           // Objetivo
           $elemento=6;
           include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
		  // $result_obj = $mySQL->runQuery("select codigo,descricao from objetivo order by codigo ",$db_array[$elemento]); 
          $result_obj = mysql_query("select codigo,descricao from objetivo "
		                              ."  where codigo=".mysql_result($result,0,"objetivo")); 
		 //							  
         if( ! $result_obj ) {
             mysql_free_result($result_obj);
             die('ERRO: Select objetivo - falha: '.mysql_error());  
         }
		 ?>
        <!-- Objetivo  -->
     <span class='td_inicio1' style="border:none; color:#000000;" title='Objetivo' >&nbsp;<?php echo mysql_result($result_obj,0,"descricao");?>&nbsp;</span>
	   <?php
            mysql_free_result($result_obj); 
           // Final objetivo
           ?>  
        </td>
    </tr>
        <tr  >
            <!--  Fonte Principal de Recurso -->
              <td  class="td_inicio1" style="vertical-align: middle; "  colspan="1"   >
                 <label for="fonterec" style="vertical-align: middle; cursor: pointer;" title="Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)"   >Fonte Principal de Recursos:&nbsp;</label>
			</td>
		      <td class="td_inicio1" style="text-align: left;"  colspan="3"  >	 
		      <span class='td_inicio1' style="border:none; color:#000000;" title='Fonte Principal de Recursos (Pr&oacute;prio, FAPESP, CNPQ, etc)' >&nbsp;<?php echo mysql_result($result,0,"fonterec");?>&nbsp;</span>
              </td  >
          <!-- Final - Fonte  Principal de Recurso -->
       </tr>
	   
	              <tr  >
            <!-- Identificacao do Projeto na Fonte de Recursos -->
              <td  class="td_inicio1"  style="vertical-align: middle; " colspan="1"  >
                 <label for="fonteprojid" style="vertical-align: middle; cursor: pointer;" title="Identifica&ccedil;&atilde;o do Projeto na Fonte de Recursos"  >Identifica&ccedil;&atilde;o do Projeto na Fonte de Recursos:&nbsp;</label>
              </td  >
			  <td class="td_inicio2"  colspan="3"  >
		      <span class='td_inicio1' style="border:none; color:#000000;"  title='Identifica&ccedil;&atilde;o do Projeto na Fonte de Recursos' >&nbsp;<?php echo mysql_result($result,0,"fonteprojid");?>&nbsp;</span>
			 </td>
            <!-- Final - Identificacao do Projeto na Fonte de Recursos -->
            </tr>
			
			           <tr  >
                <!-- Data inicio do Projeto -->
              <td  class="td_inicio1"  style="vertical-align: middle; "  >
                 <label for="datainicio" style="vertical-align: middle; cursor: pointer;" title="Data Início do Projeto"   >Data in&iacute;cio:&nbsp;</label>
              </td  >
			  <td class="td_inicio2" >
 		      <span class='td_inicio1' style="border:none; color:#000000;"  title='Data in&iacute;cio do Projeto' >&nbsp;<?php echo $datainicio;?>&nbsp;</span>
			 </td>
          <!-- Final - Data inicio do Projeto -->
          <!-- Data Final do Projeto -->
              <td  class="td_inicio1"   style="vertical-align: middle; "  >
                 <label for="datafinal" style="vertical-align: middle; cursor: pointer;" title="Data Final do Projeto"   >Data final:&nbsp;</label>
              </td  >
			  <td class="td_inicio2" >
 		      <span class='td_inicio1' style="border:none; color:#000000;"  title='Data Final do Projeto' >&nbsp;<?php echo $datafinal;?>&nbsp;</span>
			 </td>
            </tr>
			<tr>
            <td class="td_inicio1" style="text-align: left;"  colspan="4"  >     
            <table border="0" style="margin: 0px; padding: 0px; " >
			 <tr style="border: none;"  >
     <!-- Relatorio Externo (link) Projeto -->
        <td  class="td_inicio1" style="vertical-align: middle; "   colspan="1"    >
          <!--  Relatorio Externo (link) do Projeto  -->
         <label for="relatproj" style="cursor: pointer; " title="Relatório Externo do Projeto"   >Relat&oacute;rio Externo (link):&nbsp;</label>
        </td  >
	      <td  class="td_inicio1" style="vertical-align: middle; "   colspan="1"    >
		      <span class='td_inicio1' style="top: 2px; margin-top: 0px; padding-top: 0px; background-color: #FFFFFF; color:#000000;"  title='Relatório Externo do Projeto' >&nbsp;<?php echo $arq_relatorio_link;?>&nbsp;</span>
          <!-- Final - Relatorio Externo (link) Projeto -->
          </td>
       <td  class="td_inicio1" style="vertical-align: middle; "   colspan="1"    >
         <button name="buscar" id="buscar"   type="submit"  class="botao3d"  style=" cursor: pointer; "  title="Buscar"  acesskey="E"  alt="Buscar"  onclick="javascript: enviar_dados_con('DESCARREGAR','<?php echo $relatproj;?>','<?php echo $_SESSION["autor_codigousp"]."#projeto";?>');" >        
              Buscar&nbsp;<img src="../imagens/enviar.gif" alt="Buscar"    >
          </button>
        </td>          
		</tr>
        </table>
        </td>
		</tr>	
			
          <!-- Final - Data Final do Projeto -->
          <?php
		    //   Verificando se tem coresponsaveis do Projeto
			if( $coresponsaveis>=1 ) {
			    ?>
             <tr  >
              <!-- Numero de Coresponsaveis -->
               <td  class="td_inicio1" style="text-align: left; vertical-align: middle; " colspan="4"  >
                <label for="coresponsaveis" >N&uacute;mero de Co-Respons&aacute;veis:&nbsp;<?php echo $coresponsaveis;?></label>
              </td  >
	            <!-- Final - Numero de Coresponsaveis -->
			  </tr>
			  <tr>
	            <!-- Tabela com os Coresponsaveis -->
			   <td  class="td_inicio1" style="text-align: left; vertical-align: middle; " colspan="4"  >
			     <?php
    				$m_linhas=0; $num_fields=0; $m_ordenar="nome";
		            $elemento=6;
        			include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");
                	mysql_select_db($db_array[$elemento]);
					//  Criando uma tabela temporaria
					$temp_tabela="tmp_pessoa_nome";
                    $result_tb_temp1 = mysql_query("DROP TABLE IF EXISTS  $temp_tabela ");
					$result_tb_temp2 = mysql_query("CREATE TABLE $temp_tabela "
					               ." SELECT  a.coresponsavel,b.nome FROM "
			                       ." corespproj a, pessoal.pessoa b where "
								   ." ( a.projetoautor=".$_SESSION["autor_codigousp"]." and "
								   ."   a.projnum=".$numprojeto." ) and  "
								   ."   b.codigousp=a.coresponsavel  order by  b.nome ");
					//
					if( ! $result_tb_temp2 ) {
                         mysql_free_result($result_tb_temp2);
                         die('ERRO: Create Table $temp_tabela - falha: '.mysql_error());  								
					}			   
                    mysql_free_result($result_tb_temp1);					
                    mysql_free_result($result_tb_temp2);
             		$query=mysql_query("SELECT * FROM  $temp_tabela order by  $m_ordenar ");
					//
					if( ! $query )	{
                         mysql_free_result($query);
                         die('ERRO: Select $temp_tabela - falha: '.mysql_error());  				
					}		   
                    $m_linhas = mysql_num_rows($query);
                    // 	$titulo_atributos = $_SESSION['titulo_atributos'];
                  	//	Pegando os nomes dos campos  do primeiro Select
                    $num_fields=mysql_num_fields($query);  //  Obtem o número de campos do resultado
                 	$td_menu = $num_fields+1;				
                    //  Parte tentando pegar o tamanho maior da coluna (campo)
                 	for($i = 0;$i<$num_fields; $i++) { //  Pega o nome dos campos
             	          $fields[] = mysql_field_name($query,$i);
             			  //  Pegando o maximo do espaco ocupado de cada campo 
            			  //  vindo do primeiro Select - $query
            			  $max_length.= " MAX(LENGTH(TRIM($fields[$i]))) as campo$i ";
             			  if( $i<($num_fields-1) ) $max_length.= ", "; 
                 	}
                 	//   Selecionando o maximo espaco ocupado em cada campo da tabela
                    $result_max_length = mysql_query("SELECT ".$max_length." FROM  $temp_tabela  "
				                                     ." order  by  $m_ordenar  ");  		
					//
					if ( ! $result_max_length ) {
                         mysql_free_result($result_max_length);
                         die('ERRO: Select maximo tamanho dos campos da tb  $temp_tabela - falha: '.mysql_error());  				
					}	
					$num_rows = mysql_num_rows($query);
                    $num_rows = (int) strlen(trim($num_rows)); 
                    $campo_n=2;
                   /*  Como repetir uma string ou caractere 
				          um número determinado de vezes     */
                	$n_simbolo = "&nbsp;";	$n_simbolo = str_repeat($n_simbolo,$num_rows);
                 	if( $num_rows<=1 ) $n_simbolo = "";
                 	//  Final do tamanho do campo
	
            	    // Iniciando Tabela de dados
                 	?>	
                    <div  class="scrollTable"  style="height: 96px;"  >	
                   	<table class="header"  style=" margin-bottom: 1px; bottom: 1px; padding-bottom: 1px; overflow:hidden;  "  >
                  	  <tr style="margin: 0px; padding: 0px; "  >
                  	<?php
                      echo  "<th  style=\"color:#000000; background-color: #00FF00;  width:".$campo_n."%; \"  >n</th>";
               	  	  for( $i=0; $i < $num_fields; $i++) { //  Pega o nome dos campos - Cabecalho
          				   $campo_max_len=mysql_result($result_max_length,0,$i); 
			     		   $xyz[$i]= $campo_max_len; $abc= (int) strlen($fields[$i]);
     					   //  if( $xyz[$i]<$abc )  {
     					   if( $campo_max_len<$abc )  $campo_max_len=$abc;
         				   $cpo=$fields[$i]; 
               			   /*  Como repetir uma string ou caractere um número determinado de vezes   */
        				   $repetir_simbolo= $campo_max_len-strlen($cpo);
            				$m_simbolo = "&nbsp;";  $m_simbolo = str_repeat($m_simbolo,$repetir_simbolo);
    	         			if( $repetir_simbolo<=1 ) $m_simbolo = ""; 
				        	//  Unindo uma variavel na outra - usando ${}
        					$z_campo= ${"tb_".$temp_tabela."_array"};
        					//  $cpo=$z_campo[$i];
		         			//  
							if( strtoupper(trim($cpo))=="CORESPONSAVEL") $cpo='Co-Responsável';
             		       echo  "<th  "
    		                  ." style=\"color:#000000; text-align: justify; background-color: #00FF00; width:".$campo_max_len."%; \" >"
			                  .ucfirst(trim($cpo))."</th>";
                		    $tam_campo[$i]=$campo_max_len;	  
	                  }
	               ?>
                  </tr>		
               	</table>
                <div class="scroller" style="height: 70px; top: 0px; margin-top: 0px; padding-top: 0px;"  >
                <!--    Final do Cabecalho	 -->
            	<table  >
             	<?php			 
                // Iniciando os campos com dados
             	//  Numero do registro -  m_n
              	//  $m_n=$inicio;
              	while($r = mysql_fetch_array($query)) {
               		    $m_n++;
            		?>
          			<tr id="tr_itemOn" class="itemOn"  onmouseover="javascript: mouse_over_menu(this)" onmouseout="javascript: mouse_out_menu(this)"  style="overflow: scroll; "  >		
			      <?php
          			//  Primeiro campo - n   - contador de registros		 
         			echo  "<td  style=\"color:#000000; text-align: right; width: ".$campo_n."%; \" >".$m_n."</td>";
         			for($i = 0;$i < $num_fields; $i++) {
		    			  $campo_max_len=mysql_result($result_max_length,0,$i); 
			    		  $xyz[$i]= $campo_max_len; $abc= (int) strlen($fields[$i]);
				    	  if( $campo_max_len<$abc )  $campo_max_len=$abc;
    				      $cpo=htmlentities(trim($r[$fields[$i]])); $cpo=trim($cpo);
             			  /*  Como repetir uma string ou caractere um número determinado de vezes   */
	    				  $repetir_simbolo= $campo_max_len-strlen($cpo);
     	    			  $m_simbolo = "&nbsp;";  $m_simbolo = str_repeat($m_simbolo,$repetir_simbolo);
    		    		  if( $repetir_simbolo<=1 ) $m_simbolo = ""; 
    	 		    	  echo "<td    style=\"color:#000000; width: {$tam_campo[$i]}%; \"  >".trim($cpo)."</td>";
            		}
		    	?>
			    </tr>
			  <?php
	          }  
	          ?>
             </table>
	       </div>
           </div>
       	<!--  FINAL da Tabela de dados  -->
		   </td>
            <!-- FINAL - Tabela com os Coresponsaveis -->
		  </tr>
          <?php
		  }  //  Final do IF  coresponsaveis do Projeto
		  ?>
	
</table>

