<?php
 //  Verificando se session_start - ativado ou desativado
if( !isset($_SESSION) ) {
   session_start();
}
//
if ( isset($_SESSION["i_codigousp"]) ) $i_codigo = $_SESSION["i_codigousp"];
$codigousp = strlen(trim($codigousp))>0 ? $codigousp : 0;   
if ( $codigousp==0 ) {
        $result=mysql_query("SELECT min(codigousp) as codigo_ult  FROM  $bd_1.pessoa where codigousp<0 ") ;
        if( ! $result ) {
            mysql_free_result($result);          
            $msg_erro .= "Falha erro no Select/Atribuir codigoUSP".mysql_error().$msg_final;
            echo $msg_erro;
            exit();
        }
        $m_regs=mysql_num_rows($result);
        if( $m_regs>0 ) $codigo_prx = mysql_result($result,0,'codigo_ult');
        if ( ! isset($codigo_prx) )  $codigo_prx = 0;
        $codigo_prx += -1;
        mysql_free_result($result);
        $codigousp = (int) $codigo_prx;
        $_SESSION["codigousp_novo"] = $codigousp;
        if( isset($i_codigo) ) {
           if( $i_codigo<0) {
                $msg_erro .= "Falha inesperada criando um NOVO codigo USP.".$msg_final;
                echo $msg_erro;
                exit();
           }            
        }
        $array_t_value[$i_codigousp] = $codigo_prx;
} else {
    $result_usu=mysql_query("SELECT codigousp,nome FROM $bd_1.pessoa where codigousp=".$codigousp) ;
    if( ! $result_usu ) {
         mysql_free_result($result_usu);          
         $msg_erro .= "Falha no Select pessoa campo codigousp - ".mysql_error().$msg_final;
         echo $msg_erro;     
         exit();
    }
    $m_regs=mysql_num_rows($result_usu);
    mysql_free_result($result_usu);
     if( $m_regs>=1 ) {
         $msg_erro .= "&nbsp;Esse C&oacute;digo:&nbsp;".$codigousp." j&aacute; est&aacute; cadastrado.".$msg_final;
         echo $msg_erro;
         exit();
     }    
} 
//
?>