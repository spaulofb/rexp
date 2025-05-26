<?php
///   Resultado de apenas um registro  faz parte do consultar/proj_exp_ajax.php
?>
	 <style type="text/css">
  	    .tabelas {  border-color: #990000;  border-style: double;
                   border-width: 4px;
          }         
/*       .tabelas th, .tabelas td {  */
      .tabelas th, .tabelas td  {
           border-bottom-color: #6633CC;
           border-bottom-style: solid;
           border-bottom-width: 1px;
	/*	   padding-right: 3px;  */
       }
	   .td_informacao_tab { font-family: Helvetica, Arial, Courier, Times,
       "Times New Roman", Verdana, serif,sans-serif, Georgia; 
	 background-color: #FFFFFF; color: #000; font-size: x-small; 
	 empty-cells: show;  border: 0; padding-left: 2px; text-align:left;
	   }
    .style1 {color: #0000FF}
     </style>
	 <div style="width:auto; text-align: center; height: 360px; overflow: hidden; margin: 0px; padding: 0px; " >
 <table align="center"  bgcolor="#FFFFFF"  border="0" cellspacing="2" class="tabelas"   
    style="text-align: center; width: 100%;"    >
	<caption class="style1" style="font-weight:bold; border-top: 2px solid #000;"  ><?php echo $titulo_pag;?></caption>
  <tr   >
    <td  class="td_informacao_tab" >
       <span class="style1" style="font-weight: bold;"   >Matr&iacute;cula</span>:&nbsp;<?php  echo mysql_result($result_outro,0,"codigousp"); ?>      
   </td>
   <td  class="td_informacao_tab" >
       <span class="style1" style="font-weight: bold;"   >Nome</span>:&nbsp;<?php  echo mysql_result($result_outro,0,"nome"); ?>      
   </td>
   <td  class="td_informacao_tab" >
       <span class="style1" style="font-weight: bold;"   >Categoria</span>:&nbsp;<?php  echo mysql_result($result_outro,0,"categoria"); ?>      
   </td>
  </tr>
 </table>
</div>
