<?php
//    MOSTRAR ANOTACAO ENCONTRADA NA CONSULTA
//
$_SESSION["cols"]=4;
?>
  <table class="table_inicio" cols="<?php echo $_SESSION["cols"];?>" align="center"   cellpadding="2"  cellspacing="2" style="font-weight:normal;color: #000000; "  >
   <tr style="margin: 0px; padding: 0px; "   >
       <td  class="td_inicio1" style="vertical-align: middle;text-align: left;" colspan="<?php echo $_SESSION["cols"];?>" >
       <table style="text-align: left;margin: 0px; padding: 0px;"  >
        <tr>
         <td  class="td_inicio1" style="vertical-align: middle;text-align: left;background-color:#FFFFFF;" colspan="1" >
        <label style="vertical-align: middle; cursor: pointer;text-align: right; background-color:#FFFFFF; color: #000000;"  title="Orientador do Projeto" >Orientador do Projeto:&nbsp;</label>
        <!-- N. Funcional USP/Nome - Orientador do Projeto  -->
             <?php 
             $elemento=6; $m_linhas=0;          
             //  Nao precisa chamar de novo o arquivo ja foi chamado
             // @require_once("/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php");
             // $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ",$db_array[$elemento]); 
             include("/var/www/cgi-bin/php_include/ajax/includes/conectar.php");            
             /*   Atrapalha e muito essa programacao orientada a objeto
                    include('/var/www/cgi-bin/php_include/ajax/includes/class.MySQL.php');
                   $result = $mySQL->runQuery("select codigousp,nome,categoria from pessoa  order by nome ");
             */
             mysql_select_db($db_array[$elemento]);  
             $result_pessoa = mysql_query("SELECT a.autor,a.numprojeto,b.nome FROM rexp.projeto a, pessoal.pessoa b "
                                          ." where a.cip=".$cip_projeto."  and "
                                          ." a.autor=b.codigousp  order by b.nome "); 
           if( ! $result_pessoa ) {
                mysql_free_result($result_pessoa);
                die('ERRO: Select projeto e pessoal.pessoa - falha: '.mysql_error());  
           }
           $m_linhas=mysql_num_rows($result_pessoa);
            //  Cod/Num_USP/Autor   
           if ( $m_linhas<1 ) {
                 //   $autor="== Nenhum encontrado ==";
                  $msg_erro .= "&nbsp;Nenhum encontrado".$msg_final;
                  echo $msg_erro;
           } else {
                 $numprojeto=mysql_result($result_pessoa,0,"numprojeto");
                 $orientador_nome=mysql_result($result_pessoa,0,"nome");
                 $orientador_codigo=mysql_result($result_pessoa,0,"autor");
                ?>
                <span class='td_inicio1' style="border:none; background-color:#FFFFFF; color:#000000;" title='Nome do Orientador do Projeto' ><?php echo $orientador_nome;?>&nbsp;</span>
                <?php         
                 mysql_free_result($result_pessoa); 
                 $result_anot_dt=mysql_query("select data,titulo,relatext from anotacao "
                                               ." where numero=$numero_anotacao and "
                                               ." projeto=$cip_projeto ");
                 //
                if( ! $result_anot_dt ) {
                    mysql_free_result($result_anot_dt);
                    die('ERRO: Select anotacao e campo data - falha: '.mysql_error());  
                }
                $m_regs=mysql_num_rows($result_anot_dt);
                if( $m_regs>=1 ) { 
                     //  recebe o parâmetro e armazena em um array separado por 
                     $titulo =  mysql_result($result_anot_dt,0,"titulo");
                     //  Arquivo do relatorio do Anotacao (link)
                     $posicao_enc = strpos(mysql_result($result_anot_dt,0,"relatext"),"_");
                     $relatext=mysql_result($result_anot_dt,0,"relatext");
                     $arq_rel_link = substr($relatext,$posicao_enc+1,strlen($relatext));
                     $dt_anotacao=  explode(' ', mysql_result($result_anot_dt,0,"data"));  
                     $data_anotacao=  explode('-', $dt_anotacao[0]);  
                    //  armazena na variavel data os valores do vetor data e concatena 
                    $data_anotacao = $data_anotacao[2].'/'.$data_anotacao[1].'/'.$data_anotacao[0];             
                }
                mysql_free_result($result_anot_dt);
           }
           ?>  
           <!-- Final da Num_USP/Nome Responsavel  -->
         </td>
        <td  class="td_inicio1" style="vertical-align: middle;text-align: left;background-color:#FFFFFF;" colspan="1"  >
          <!-- CIP/Numero do Projeto -->
           <label  style="vertical-align:middle;  cursor: pointer; text-align: left; background-color: #FFFFFF; color:#000000;"  title="N&uacute;mero do Projeto de Pesquisa" >Nr. do Projeto:&nbsp;</label>
      <span  class="td_inicio1" style="vertical-align: middle; text-align: left; background-color: #FFFFFF; color:#000000; border: none;"   ><?php echo $numprojeto;?>
           </span>  
           </td>
           <td  class="td_inicio1" style="vertical-align: middle;text-align: left;background-color:#FFFFFF;" colspan="1"  >
      <label style="vertical-align:middle;  cursor: pointer; text-align: left; background-color:#FFFFFF; color:#000000;"  title="N&uacute;mero da Anota&ccedil;&atilde;o" >Nr. da Anota&ccedil;&atilde;o:&nbsp;</label>
         <span  class="td_inicio1" style="vertical-align: middle; text-align: left;  background-color:#FFFFFF; color:#000000; border: none;"  >
                 <?php echo $numero_anotacao;?>
         </span>
         </td>
         <td  class="td_inicio1" style="vertical-align: middle;text-align: left;background-color:#FFFFFF;" colspan="1"  >
      <label style="vertical-align:middle;  cursor: pointer; text-align: left; background-color:#FFFFFF; color:#000000;"  title="Data da Anota&ccedil;&atilde;o" >Data:&nbsp;
      </label>
       <span  class="td_inicio1" style="vertical-align: middle; text-align: left;  background-color:#FFFFFF; color:#000000; border: none;"  >
         <?php echo $data_anotacao;?>
          </span>
         </td>
        </tr>
        </table>
      </td>
      </tr>  
   <tr style="text-align: left;"  >
     <!--  Titulo da Anotacao  -->
    <td  class="td_inicio1" colspan="4" style="text-align: left;  background-color: #32CD99; " >
      <label for="titulo"  style="vertical-align: top; color:#000000; background-color: #32CD99; cursor:pointer;" title="Título  da Anotação"   >T&iacute;tulo da Anota&ccedil;&atilde;o:&nbsp;</label>
       <textarea rows="3" cols="85" name="titulo" id="titulo"  title='T&iacute;tulo  da Anotação' style="cursor: pointer; overflow:auto;"  readonly="readonly"  ><?php echo $titulo;?></textarea>      
        </td>
     <!-- FINAL -  Titulo da Anotacao -->
    </tr>
    
          <tr style="text-align: left;"  >
    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <?php
       //  MYSQL - Como receber dois nomes de dois codigos de dois BD e duas Tabelas
       $result_dois_nomes = mysql_query("select b.nome as testemunha1_nome, c.nome as testemunha2_nome from "
                   ."  rexp.anotacao a, pessoal.pessoa b, pessoal.pessoa c where "
                   ."  ( a.projeto=$cip_projeto and a.numero=$numero_anotacao ) and "
                   ." a.testemunha1=b.codigousp and a.testemunha2=c.codigousp ");
        //  Resultado dos campos codigos para nomes de outro BD - pessoal.pessoa
        if( ! $result_dois_nomes ) {
                    mysql_free_result($result_dois_nomes);
                    die('ERRO: Select rexp.anotacao e pessoal.pessoa  - falha: '.mysql_error());  
         }
         $testemunha1_nome = mysql_result($result_dois_nomes,0,"testemunha1_nome");
         $testemunha2_nome = mysql_result($result_dois_nomes,0,"testemunha2_nome");                  
       ?>    
      <label style="vertical-align:bottom; cursor: pointer;"  title="Testemunha (1) da Anotação" >Testemunha (1):&nbsp;</label>
        <!-- Testemunha (1) da Anotacao -->
       <span class='td_inicio1' style="border:none; background-color: #FFFFFF; color:#000000;"  title='Testemunha (1) da Anotação' >&nbsp;<?php echo $testemunha1_nome;?>&nbsp;</span>
        </td>

    <td  class="td_inicio1" style="text-align: left;" colspan="2"  >
      <label for="testemunha2"  style="vertical-align:bottom; cursor: pointer;"  title="Testemunha (2) da Anotação"  >Testemunha (2):&nbsp;</label>
        <!-- Testemunha (2) da Anotacao -->
       <span class='td_inicio1' style="border:none;  background-color: #FFFFFF; color:#000000;"  title='Testemunha (2) da Anotação' >&nbsp;<?php echo $testemunha2_nome;?>&nbsp;</span>        
        </td>
       </tr>  
           
       <tr>
         <td class="td_inicio1" style="text-align: left;"  colspan="4"  >     
         <table border="0" style="margin: 0px; padding: 0px; " >
         <tr style="border: none;"  >
     <!-- Relatorio Externo (link) Anotacao  -->
      <td  class="td_inicio1" style="vertical-align: middle; "   colspan="1"    >
         <label  style="vertical-align: middle; cursor: pointer; " title="Relatório Externo da Anotação"   >Relat&oacute;rio Externo (link):&nbsp;</label>
        </td  >
         <td class="td_inicio2" style="vertical-align: middle; "   colspan="1"  >
            <span class='td_inicio1' style="vertical-align: middle;border:none; background-color: #FFFFFF; color:#000000;"  title='Relatório Externo da Anotação' >&nbsp;<?php echo $arq_rel_link;?>&nbsp;</span>
         </td>
         <td class="td_inicio2" style="vertical-align: middle; "   colspan="1"  >            
         <button name="buscar" id="buscar"   type="submit"  class="botao3d"  style="vertical-align: bottom;cursor: pointer; "  title="Buscar"  acesskey="E"  alt="Buscar"   onclick="javascript: enviar_dados_con('DESCARREGAR','<?php echo $relatext;?>','<?php echo $orientador_codigo."#anotacao";?>');" >     
              Buscar&nbsp;<img src="../imagens/enviar.gif" alt="Buscar"  style="vertical-align: bottom;"  >
          </button>
         </td>
          <!-- Final - Relatorio Externo (link) Anotacao -->
        </tr>
       </table>
       </td>
       </tr>
</table>