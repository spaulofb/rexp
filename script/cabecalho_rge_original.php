<?php
///  Cabecalho - Topo 
/// session_save_path('/home/gemac/tmp'); 
if( ! isset($_SESSION)) {
     session_start();
}
////
//// Mensagens para enviar
$msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >";
$msg_erro .= "ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

$msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' >";
$msg_ok .= "<span style='color: #FF0000; padding: 4px;' >";

$msg_final="</span></span>";
///   FINAL - Mensagens para enviar
///
///  Verifica se a SESSION url_central existe
if( isset($_SESSION["url_central"]) ) {
     $raiz_imagem=$_SESSION["url_central"];
} else {
     $msg_erro .= "Sessão url_central não está ativa. Corrigir".$msg_final;  
     echo $msg_erro;
     exit();
}
///
?>
<table cellSpacing="0" cellPadding="0" border="0" >
  <tr>
     <td>
        <a href="#">
           <img class="img_cabecalho"  src="<?php echo $raiz_imagem;?>imagens/topo_rge_nova.gif"  height="80" >    
        </a>
     </td>
  </tr>
  <tr>
     <td  background="<?php echo $raiz_imagem;?>imagens/b1.gif"  height="21"  style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#FFFFFF;">
        <?php echo $_SESSION["titulo_cabecalho"];  ?>
    </td>
    </tr>
</table> 

