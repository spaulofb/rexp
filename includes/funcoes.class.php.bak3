<?php
//  Verificando se session_start - ativado ou desativado
if(!isset($_SESSION)) {
   session_start();
}
///
/// Verifique se a classe existe antes de tentar usá-la
/// if( class_exists('funcoes') ) {
    /// 
    class funcoes {
         public $valor=100;
         public $deposito=200; 
         
         public $msg_erro = "<span class='texto_normal' style='color: #000; text-align: center; ' >ERRO:&nbsp;<span style='color: #FF0000; text-align: center; ' >";

         public $msg_ok = "<span class='texto_normal' style='color: #000; text-align: center;' ><span style='color: #FF0000; padding: 4px;' >";

         public $msg_final="</span></span>";   
      
         public $usuario_pa_nome;  
         
         public function mostraSaldo() {
             return "Meu saldo e&acute; de ".$this->valor;
         }
         
         public function mostra_msg_erro($mensagem=null) {
             return  $this->msg_erro.$mensagem.$this->msg_final;
         }    

         public function mostra_msg_ok($mensagem=null) {
             return  $this->msg_ok.$mensagem.$this->msg_final;
         }    

         
         public function usuario_pa_nome() {
             $this->usuario_pa_nome="Usu&aacute;rio";
             //  O melhor usar sempre -> $_SESSION
             if( $_SESSION["permit_pa"]==$_SESSION["array_pa"]['orientador'] ) $this->usuario_pa_nome="Orientador"; 
             if( $_SESSION["permit_pa"]==$_SESSION["array_pa"]['anotador'] ) $this->usuario_pa_nome="Anotador"; 
             //  return  $this->msg_erro.$mensagem.$this->msg_final;
         }    
    }
///  }
/*****  Final  -  Verifique se a classe existe antes de tentar usá-la   ******/
///
?>