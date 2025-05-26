       
       
       
       //  Continuacao Tabela projeto - BD PESSOAL
         /**   MELHOR jeito de acertar a acentuacao - html_entity_decode    */    
         //  Caso tenha coautores/coresponsaveis no Projeto
         //  include("n_cos.php");
         require_once("n_cos.php");
         //
         //  SESSION abaixo para ser usada no include
         $_SESSION["tabela"]="$bd_2.projeto";
         //
         /**    Arquivo importante codificar dados  
         *   Atualizado em 20250516
         *   include("dados_recebidos_arq_ajax.php"); 
         */

$_SESSION["xres"]="ERRO: passou -->>  ";



         require_once("dds_rcbs_arq_ajax_proj.php"); 
         //

echo  "ERRO: {$_SESSION["xres"]}";
exit();

