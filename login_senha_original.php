<?php
/*   Parte do arquivo authent_user.php  --  Desktop
      usuario e senha -  Iniciar permissao

*/
?>
<!-- PAGINA -->
<div class="pagina_ini"  >
<!-- Cabecalho -->
<div id="cabecalho">
<?php include("{$_SESSION["incluir_arq"]}script/cabecalho_rge.php");?>
</div>
<!-- Final Cabecalho -->
<!-- MENU HORIZONTAL -->
<?php
$_SESSION["function"]="doaction";
include("{$_SESSION["incluir_arq"]}includes/menu_horizontal.php");
///
?>                     
<!-- Final do MENU  --> 
<!-- CORPO -->
<div class="corpo_iniciando"  >
    <!-- Recebe mensagens -->
    <div  id="label_msg_erro"  >
   </div>
   <!-- Final - Recebe mensagens -->
<!-- Section - class section_inicio  -->   
<section class="section_inicio" >
   <article  class="article_inicio"  >
       <div class="usuario_senha"  >    
          <!--  Digitar  Usuario/EMail -->
             <label for="userid" class="label_campos" title="Digitar email" >
                <span>Login(Email):</span>
             </label>
              <input type="email" name="userid"  id="userid" style="width: 300px;"  maxlength="60" 
               required="required"  onkeypress="myFunction()" 
                onfocus="javascript: id_conteudo('liga','Digitar email');" 
                placeholder="nome@email.com ou código"  autocomplete="off"  tabindex="1" 
                 autofocus="autofocus"  title="Digitar email"  />
               <!-- Final -  Digitar  Usuario/EMail -->     
            </div>        
            <div class="usuario_senha" >    
               <!-- Digitar Senha -->
               <label for="userpassword" class="label_campos" ><span>Senha:</span></label>
                  <input type="password" name="userpassword"   id="userpassword" size="16" 
                   maxlength="14"  onfocus="javascript: id_conteudo('liga','Digitar senha');" 
                     required="required"  onkeypress="myFunction()" 
                       autocomplete="off"  tabindex="2"  title='Digitar senha'  />  
                <!-- Final - Digitar Senha -->       
            </div>    
     </article>   
     <article  class="article_inicio" >
          <div id="div_imagem_codigo" >
             <!-- Imagem do Codigo  -->
             <img src="captcha_criar.php" id="imagem_codigo"  alt="C&oacute;digo captcha" height="36" width="128" />
         </div>   
         <div class="article_div" >       
                <input type="hidden"  id="magica" name="magica" value=""  />
                <label for="confirm" class="label_campos" ><span>C&oacute;digo:</span></label>
                <input type="text"  name="confirm"  id="confirm"  style="width: 90px;" required="required"
                  onfocus="javascript: id_conteudo('liga','Digitar c&oacute;digo com 5 caracteres');"
                 onblur="javascript: id_conteudo('','');"  onkeypress="myFunction()"   
                 autocomplete="off"   style="cursor:pointer;margin-left:10px;"   tabindex="3" 
                  title="Digitar c&oacute;digo com 5 caracteres"  />
                <!-- Reiniciar imagem -->
                <input type="reset"  name="novocodigo"  id="novocodigo"  class="botao3d" 
                    style="width: auto; font-size:smaller;font-weight: normal;"  title="Novo c&oacute;digo" 
                      value="Novo c&oacute;digo"  alt="Novo c&oacute;digo"  
                     onclick="javascript: doaction(this.name); return false;" acesskey="N" />
         </div>          

         <div class="limpar_enviar"  >
            <!-- RESET/SUBMIT -->
              <input type="reset"  class="botao3d"   name="limpar" id="limpar" style="width: auto; font-size: small;"  
                  title="Limpar"  acesskey="L"  value="Limpar"  alt="Limpar" 
                   onfocus="javascript: limpar_campos('limpar','Limpar');"  onclick="javascript: doaction('RESET');" />
              <input type="submit"  name="enviar"  id="enviar" class="botao3d"  style="width: auto; font-size: small;"  acesskey="E"  value="Enviar"  tabindex="4"  alt="Enviar"  
                  onfocus="javascript: id_conteudo('liga','Enviar');" 
                  onclick="javascript: doaction('SUBMIT'); return false;"  title="Enviar"  />                  
           </div>
           <div id="conteudo" ></div> 
           <div id="inclusao"  style="display: none;text-align: center;" ></div>
     </article>
</section>          
<!-- Final - Section - class section_inicio  -->   
       
       <!-- Esqueceu a senha  - e -  Ainda nao e cadastrado  --> 
           <div class="opcoes_inicio"  style="float:left; ">    
               <a href="esqueci_senha.php"  style="text-decoration: none; cursor: pointer;" title="Clicar"  ><span style="color: #000000;"  >Esqueceu a senha?</span>&nbsp;Clique aqui.</a>
           </div>
           <div class="opcoes_inicio"  style="float:right;">    
               <a href="cadastrar_auto_por_email.php"  style="text-decoration: none; cursor: pointer;" title="Clicar" target="_parent"  >
               <span style="color: #000000;"  >Ainda n&atilde;o &eacute; cadastrado?</span>&nbsp;Clique aqui.</a>
           </div>
       <!--  Final - Esqueceu a senha  --  Ainda nao e cadastrado  --> 

</div>      
<!-- Final Corpo -->
<!-- Rodape -->
<div id="rodape"  >
<?php 
///  Rodape
include_once("{$incluir_arq}includes/rodape_index.php"); 
?>
</div>
<!-- Final do Rodape -->
</div>
<!-- Final da PAGINA -->
