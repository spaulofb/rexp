<?php
//  Verificando se session_start - ativado ou desativado
//  Alterado em  20121026
if(!isset($_SESSION)) {
   session_start();
}
///
$pessoal_array = array("Pessoal" ,"Docentes","Alunos","Funcionários","Pesquisadores");
$array_menu = array(  "Home", "Quem Somos", 
                      array(  "Serviços", "Web" , $pessoal_array ,"Gráfica", "Consultoria"),
					  array( "Produtos", "Site" , "Cartão" , "Loja Virtual"),
					  "Contato",
					  "Sair");
//
$array_m_v_1 = array(  "Home", "Quem Somos", 
                      array(  "Serviços", "Web" , $pessoal_array,"Gráfica", "Consultoria"),
					  array( "Produtos", "Site" , "Cartão" , "Loja Virtual"),
					  "Contato",
					  "Sair");
//
// 
$post_array = array("source","val","m_array");

$array_sair= array("Sair");
$array_vazio= array(" ");

$array_m_v_2 = array("Imprimir","Salvar","Remover");
//
$array_m_v_3 = array("Listar","Carregar","Descarregar","Remover","Sair");
//
//  $m_array_k3 = array("LISTAR","CARREGAR","REMOVER","REMOVENDO");
$m_array_k3 = array("LISTAR","DESCARREGAR","REMOVER","REMOVENDO");
#
if( isset($_SESSION["array_pa"]) ) {
    //  $array_usuarios = array("superusuario" => '0' ,"chefe" => '10',"vicechefe" => '15',"orientador" => '30',"anotador" => '50' );    
    //  Esse array_pa  vem de outro arquivo  
    $array_pa = $_SESSION["array_pa"];
   /* Exemplo do resultado  do  Permissao de Acesso - criando array
      +-------------+--------+
      | descricao   | codigo |
      +-------------+--------+
      | super       |      0 | 
      | chefe       |     10 | 
      | vice        |     15 | 
      | aprovador   |     20 | 
      | orientador |     30 | 
      | anotador    |     50 | 
      +-------------+--------+
    */
}
///
if( isset($_SESSION["permit_pa"]) )  {
    $array_pa = $_SESSION["array_pa"];    
    $codigo_pa= (int) $_SESSION["permit_pa"];  
    ///  Criar uma variavel da chave de um array
    ///  foreach( $array_usuarios as $chave => $valor )  { 
    foreach( $array_pa as $chave => $valor )  {    
         $field_name = ucfirst($chave);
         $valor = (int) $valor;
         if( $valor==$codigo_pa ) {
               $permit_pa = (int) $codigo_pa;
               $descricao_pa = $field_name;
               break;
         }                
    }
    ///
    $_SESSION["descricao_pa"]=$descricao_pa;
    ///  Mostra a opcao de Privilegio de Acesso
    $logado="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logado como:&nbsp;&nbsp;$descricao_pa&nbsp;&nbsp;";
    ///
    if( $_SESSION["permit_pa"]==$array_pa['orientador'] ) {
         ///  Opcao orientador
         $array_projeto = array("Apresenta&ccedil;&atilde;o", array( "Cadastrar", "Projeto" ,"Anota&ccedil;&atilde;o", "Anotador" ),array( "Consultar", "Projeto", "Anota&ccedil;&atilde;o" ,"Anotador"),array( "Remover", "Projeto","Anota&ccedil;&atilde;o","Anotador"),  array("Alterar","Projeto","Anota&ccedil;&atilde;o","Senha"),"Sair",$logado);
    } elseif( $_SESSION["permit_pa"]==$array_pa['anotador'] )  {
         ///  Opcao anotador
         /*  $array_projeto = array("Apresentação", array( "Cadastrar", "Anotação"),array( "Consultar", "Anotação"), array("Alterar","Senha"),"Sair",$logado);  */
        /// $array_projeto = array("Anota&ccedil;&atilde;o", "Alterar_Senha","Sair",$logado); 
         $array_projeto = array("Apresenta&ccedil;&atilde;o",array("Anota&ccedil;&atilde;o", "Cadastrar", "Alterar" ,"Consultar", "Remover"), "Alterar_Senha","Sair",$logado);                
         ///
    } else {
         /// Outra opcao
         $array_projeto = array("Apresenta&ccedil;&atilde;o", array( "Cadastrar","Pessoal", "Participante","Projeto", "Anota&ccedil;&atilde;o", "Anotador"),array( "Consultar", "Usu&aacute;rio","Pessoal","Projeto", "Anota&ccedil;&atilde;o","Anotador"),array( "Remover", "Usu&aacute;rio"), array("Alterar","Senha"),"Sair",$logado);        
    }       
}
///
$array_voltar= array("Voltar");
$array_vazio = array("                                                                         ");
///
?>
