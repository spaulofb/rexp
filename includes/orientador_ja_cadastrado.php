<?php
///  Primeiro verificar se ele ja esta cadastrado como Orientador
if( intval($n_regs)>=1 ) {
   //  Definindo os nomes dos campos recebidos do FORM
   //    foreach( $arr_nome_val as $chave => $valor )  { 
   /*
   while ( $arr_nome_val = mysql_fetch_array($result_usu,MYSQL_ASSOC) ) { 
        foreach( $arr_nome_val   as $chave => $valor )  { 
            $nome_campo = strtoupper($chave);
            if( in_array($nome_campo,$m_usuario_arr) ) {
                $login = trim($valor);
                $upper_login = (string) strtoupper($valor);
            }                
            if( in_array($nome_campo,$m_senha_arr) ) {
                $senha = $valor;
                $upper_senha = (string) strtoupper($valor);
            }
            if( in_array($nome_campo,$array_email) ) {
                $e_mail = $valor;
                $upper_email = (string) strtoupper($valor);
            }                         
            $$chave =  $valor;         
        }
   } 
   */        
   ///  Caso estaja aprovado ou nao
    if( intval($aprovado)==1 ) {
         $confirmar1="";
         $confirmar0 ="<p style='text-align:center;font-size: medium;'>"
               ."<b>J&aacute; est&aacute; cadastrado como Orientador</b>";
         ///       ."Para acessar, basta fazer o seu login.</p>";
         $confirmar1 .=$confirmar0."<div style='width: 100%; text-align: center;'>";            
         if( strtoupper($sexo)=="M" ) $texto = "Já está cadastrado e aprovado como Orientador";
         if( strtoupper($sexo)=="F" ) $texto = "Já está cadastrada e aprovada como Orientadora";
        /*
        $confirmar1 .="<button  style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: aprovado(\"$texto#APROVADO\");' >Ok";                                  
        */                  
         $confirmar1 .="</button>";
         $confirmar1 .="</div>";               
    } elseif( intval($aprovado)<1 ) {
       //  Nao foi aprovado ainda
        $confirmar1="";
        if( strtoupper($sexo)=="M" ) $texto = "NÃO foi Aprovado,<br> Consultar o Aprovador";
        if( strtoupper($sexo)=="F" ) $texto = "NÃO foi Aprovada,<br> Consultar o Aprovador";                                                  
        $confirmar0 ="<p style='text-align:center;font-size: medium; padding-top:1em;' >"
                     ."<b>J&aacute; Cadastrado mas ainda&nbsp;".utf8_decode($texto)."</b>.</p>";
        $confirmar1 .=$confirmar0."<div style='width: 100%; text-align: center;'>";                                         
        /*
        $confirmar1 .="<button  style='text-align:center; cursor: pointer;'  " 
                  ." onclick='javascript: aprovado(\"$texto#NAOAPROVADO\");' >Ok";                                  
        $confirmar1 .="</button>";
        */
        $confirmar1 .="</div>";                             
        ///  $msg_ok .= "N&atilde;o foi aprovado ainda como Orientador.<br>"; 
    }                                               
    ///           
    $msg_ok .= "<span style='color: #000000;margin-left: 2px; padding-left: 4px; font-size: large;' >"
               ."<br>&nbsp;Nome: <b>$nome</b>";
               ///  ."<br><br>CPF: $cpf"
    $msg_ok .= "<br/>&nbsp;C&oacute;digo/USP: <b>$codigousp</b> ";
            //   ."<br><br>&nbsp;Usu&aacute;rio/Login: <b>$login</b> "
    $msg_ok .= "<br/>&nbsp;Usu&aacute;rio: <b>$e_mail</b></span>";
   // $msg_ok .= $confirmar1.$msg_final."#@=".$codigousp;                   
    $msg_ok .=  "<br/>".utf8_encode($confirmar1).$msg_final;                   
    echo  $msg_ok;               
    ////
} else {
   ///  Verificando se esse e_mail existi na Tabela Pessoa
   $upper_e_mail=strtoupper(trim($val));
   $where = " upper(trim(a.e_mail))='$upper_e_mail' "; 
   ///  MySql - SELECT
   $sqlcmd = "SELECT a.* FROM $bd_1.pessoa a WHERE  $where   ";
   //
   $result_pessoa = mysql_query($sqlcmd);               
   if( ! $result_pessoa ) {
       $msg_erro .="&nbsp;SELECT Tabela Pessoa:&nbsp; - ".mysql_error().$msg_final;
       echo $msg_erro;
       exit();  
   }
   /// Numero de registros
   $numero_regs = mysql_num_rows($result_pessoa);
   ///  Caso não encontrou registro
   if( intval($numero_regs)<1 ) {
         /// Caso nao tenha Cadastro na Tabela Pessoa
         ///   IMPORTANTE: Na Pasta para imagens criadas tem  que ser do usuario e grupo  -  apache.apache
         $rm = "/usr/bin/find imagens/img_temp/  -name  'senha_*.gif' -cmin +40 -delete ";
         shell_exec($rm);
         //
         $loop = true;
         while( $loop ) {
               /// $date_brazilian = date("Ymd").time(); 
               $time_start = microtime(true);
               $date_brazilian = (string) gmdate("Ymd").$time_start;
               
               $padrao = "[\,]"; // aqui sua express?o regular
               $trocar = "."; // aqui o conteudo que deseja substituir
               
               $date_brazilian = preg_replace($padrao,$trocar,$date_brazilian) ; 
              /*   IMPORTANTE: Na Pasta para imagens criadas tem  que ser do usuario e grupo  -  apache.apache
                                e tb no caminho aqui precisa de ../   pois a pasta local aqui  raiz/includes/
              */
               $arqimagem =  "../imagens/img_temp/senha_".$date_brazilian.".gif";
               $loop = file_exists($arqimagem);
         }
         ///
         $mensagem="Para proceder com o seu cadastramento, <b>PREENCHA</b> o formul&aacute;rio abaixo:";  
         /// $codigo_imagem =  @include("/var/www/cgi-bin/php_include/ajax/codigo/codimage_ajax.php"); 
         $codigo_imagem =  @include("php_include/ajax/codigo/codimage_ajax.php"); 
         ///  $msg_erro = $mensagem."#".$codigo_imagem;
         ///  Corrigindo:  Retirando o ultimo caracter que aparece sempre o numero 1
        $codigo_imagem =  substr($codigo_imagem,0,-1);
        $msg_erro = $codigo_imagem."#".$mensagem;
        echo $msg_erro;  
        /// Retornar     
        exit();
        ///
   } 
   $pessoa_array = mysql_fetch_array($result_pessoa);
   //  Definindo os nomes dos campos recebidos do FORM
   foreach( $pessoa_array as $key => $value ) {
           $$key = $value;
   }   
   if( isset($result_pessoa) ) mysql_free_result($result_pessoa);
   ///  ramal definido como inteiro porisso caso vazio acrescentar ZERO
   if( isset($ramal) ) {
       if( strlen(trim($ramal))<1 ) $ramal=(int) 0;       
   }
   /// Gera a ativação de codigo com 6 digitos
   $activation_code = rand(100000,999999);
  /// MySql - Select
  $cmdsql = mysql_query("select activation_code  from $bd_1.usuario where codigousp=".$codigousp);
   if( ! $cmdsql ) {
       $msg_erro .="&nbsp;SELECT Tabela Usuario:&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
       echo $msg_erro;     
       exit();  
   }
   ///  NUmero de registros
   $nregs= mysql_num_rows($cmdsql);
   /// Caso encontrado um ou mais registros   
   if( intval($nregs)>=1 ) $codigo_ativa= (int) mysql_result($cmdsql,0,"activation_code");
   ///   Colocar as datas do Cadastro do Usuario e a validade
   date_default_timezone_set('America/Sao_Paulo');
   
   ///  Formatando a Data no formato para o Mysql
   $dia=date("d");  $mes=date("m"); $ano=date("Y"); 
   $ano_validade=$ano+2;
   $datacad="$ano-$mes-$dia";
   $datavalido="$ano_validade-12-31";
   $lnerro=0;  $aprovado=0; $participante_erro=0;
   ///
   if( intval($nregs)<1 ) {
        /// Gera a ativacao de codigo com 6 digitos
        $codigo_ativa = rand(100000,999999);
        ///  Fazendo o LOGIN com e_mail
        list($login) = explode("@", $e_mail);
        
       ///  START a transaction - ex. procedure    
       mysql_query('DELIMITER &&'); 
       $commit = "commit";
       mysql_query('begin'); 
       ///  Execute the queries          
       ///  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
       mysql_query("LOCK TABLES $bd_1.usuario WRITE  ");
       /*!40000 ALTER TABLE `orientador` DISABLE KEYS */;            
       //  INSERT - usuario
       $res_usu = "insert into  $bd_1.usuario ";
       $res_usu .="  (login,datacad,datavalido,codigousp,pa,aprovado,activation_code)  "
                         ." values('$login','$datacad','$datavalido',$codigousp,$orientador_pa,$aprovado,$codigo_ativa) "; 
       ///                  
       $sqlcmd = mysql_query($res_usu);      
       if( $sqlcmd ) { 
            if( isset($sqlcmd) ) unset($sqlcmd);
            ///  Concluindo a tabela usuario para Orientador Novo para ser aceito pelo Aprovador
            $commit="commit";                           
       } else { 
           ///  Falha inserindo novo Orientador na Tabela usuario
           $commit = "rollback";
           $msg_erro .="&nbsp;Falha Tabela usuario insert&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
           $lnerro=1; $participante_erro=1;
       }                
       /*!40000 ALTER TABLE `orientador` ENABLE KEYS */;
       mysql_query($commit);
       mysql_query("UNLOCK  TABLES");
       //  Complete the transaction 
       mysql_query('end'); 
       mysql_query('DELIMITER');         
       
       ///  Caso Tabela acima foi aceita incluir dados na outra abaixo
       if( isset($sqlcmd) ) unset($sqlcmd);
       ////
   }         
   //// FINAL - if  Nenhum registro encontrado
   ///
   /// Caso NAO ocorreu  erro
   if( intval($participante_erro)<1 )  {
       ///  INSERINDO PARTICIPANTE
       ///
       ///  Start a transaction - ex. procedure    
       mysql_query('DELIMITER &&'); 
       $commit = "commit";
       mysql_query('begin'); 
       //  Execute the queries          
       //  mysql_db_query - Esta funcao e obsoleta, nao use esta funcao - Use mysql_select_db() ou mysql_query()
       mysql_query("LOCK TABLES $bd_2.participante WRITE  ");
       ///  INSERT
       $res_participante = "insert into  $bd_2.participante ";
       $res_participante .="  (codigousp,datacad,datavalido,pa,codigo_ativa,aprovado,chefe)  "
                         ." values($codigousp,'$datacad','$datavalido',$orientador_pa,$codigo_ativa,$aprovado,0) "; 
       ///                  
       $sqlcmd =  mysql_query($res_participante);      
       if( $sqlcmd ) { 
           if( isset($sqlcmd) )  unset($sqlcmd);
           ///  Concluindo a tabela Participante para Orientador Novo para ser aceito pelo Aprovador
           $commit  ="commit";                           
       } else { 
           ///  Falha inserindo novo Orientador
           $commit = "rollback";
           $lnerro=1;
       }         
       mysql_query($commit);
       mysql_query("UNLOCK  TABLES");
       ///  Complete the transaction 
       mysql_query('end'); 
       mysql_query('DELIMITER');    
       ///
       if( strtoupper($commit)=="COMMIT" ) {
           ///  IMPORTANTE:  acentuacao correto com htmlentities e utf8_decode
            $nome_insert_mysql=utf8_encode($nome);
           ///  
           $msg_ok  .="<span style='text-align:center; color: #000000;'>";
           $msg_ok  .="<br>Orientador <b>";
           $msg_ok  .=$nome_insert_mysql."</b>.<br>Encaminhado para o <b>Aprovador</b>.";
           $msg_ok  .="<br>Caso aprovado, receberá e_mail com instruções.</span>".$msg_final;
       } elseif( strtoupper($commit)=="ROLLBACK" ) {
           $msg_erro .="&nbsp;Falha Tabela participante insert&nbsp;-&nbsp;db/Mysql:&nbsp;".mysql_error().$msg_final;
           echo $msg_erro;         
       }
          
       ///   Mandar mensagem para o Aprovador - caso nao tenha erro
       if( intval($lnerro)<1 ) {
              ////  Caso Tabela acima foi aceita incluir dados na outra abaixo
              if( isset($sqlcmd) ) unset($sqlcmd);
              ///  Verificando descricao na  tabela categoria 
              $categoria = strtoupper(trim($categoria));
              $res_categoria=mysql_query("SELECT descricao FROM $bd_1.categoria where "
                      ." upper(trim(codigo))='$categoria' ");
              ///        
              if( ! $res_categoria ) {
                   $msg_erro .="&nbsp;Select categoria campo codigo$lnerro".mysql_error().$msg_final;
                   echo $msg_erro;         
                   exit();
              }  
              ///  Numero de registros
              $num_linhas=mysql_num_rows($res_categoria);           
              if( intval($num_linhas)<1 ) {
                   $descr_categ = "Outra";
              } else {
                   $descr_categ = mysql_result($res_categoria,0,"descricao")."&nbsp;($categoria)"; 
                   $descr_categ = utf8_encode($descr_categ);
              }
              if( isset($res_categoria) ) mysql_free_result($res_categoria); 
              $activation_code=$codigo_ativa;
              ///  $aprovador_email="gemac@genbov.fmrp.usp.br";
              $aprovador_email="{$_SESSION["gemac"]}";
              /////  Esse email nessa variavel apenas pra teste - tiao37....
              /////  $aprovador_email="tiao3701f@genbov.fmrp.usp.br";
              
               ///  $host  = $_SERVER['HTTP_HOST'];
               $host = $_SESSION["http_host"];
               $retornar = html_entity_decode("http://".$host.$_SESSION["pasta_raiz"]);
               ///  $user=$arr_nome_val['codigousp'];
               $user=$codigousp;
              ///  $m_local="ativar_orientador.php?user=".$user."&activ_code=".$activ_code."&pa=".$pa;
              /// $m_local="ativar_orientador.php?user=".$user."&activation_code=".$codigo_ativa;
              $m_local="ativar_orientador_por_email.php?user=".$user."&activation_code=".$codigo_ativa."&pa=".$orientador_pa;
              $a_link = "***** CONEXÃO DE ATIVAÇÃO *****\n<br><a href='$retornar$m_local'  title='Clicar' >"
                       ."$retornar$m_local</a>"; 
              ///  $host_upper = strtoupper($host);           
              $host_lower = strtolower($host);           
               ///  $assunto =html_entity_decode("Redefini??o de senha");    
               ///  $assunto =html_entity_decode("RGE/SISTAM - Detalhes da Autentifica??o");    
               $assunto =html_entity_decode("RGE/SISTAM - Permissão para Orientador");           
               $corpo ="RGE/SISTAM - Permissão para Orientador<br>";
               $corpo .="$host_lower/rexp<br><br>";    
               $corpo .=html_entity_decode("O usuário abaixo solicita permissão como Orientador de Projeto.<br>Providenciar análise e aprovação se for devida.\r\n");                    
               $headers1  = "MIME-Version: 1.0\n";
                ///  $headers1 .= "Content-type: text/html; charset=UTF-8\n";                    
               $headers1 .= "Content-type: text/html; charset=iso-8859-1\n";                  
               $headers1 .= "X-Priority: 3\n";
               $headers1 .= "X-MSMail-Priority: Normal\n";
               $headers1 .= "X-Mailer: php\n";
               ///  $headers1 .= "Return-Path: xxx@...\n";
               ///  $headers1 .= "Return-Path: gemac@genbov.fmrp.usp.br\n";
               $headers1 .= "Return-Path: {$_SESSION["gemac"]}\n";
           
               ///  $headers1 .= "From: \"Registro Membro\" <auto-reply@$host>\r\n";                    
               ///  $headers1 .= "From: \"RGE/SISTAM\" <gemac@genbov.fmrp.usp.br>\r\n";    
               $headers1 .= "From: \"RGE/SISTAM\" <{$_SESSION["gemac"]}>\r\n";                    
               $nome=utf8_encode($nome);
           
               $message = "$corpo\n<br><br>
               Nome: $nome<br>
               Usuário/Email: $e_mail<br>
               Categoria: $descr_categ\n<br>
           
               Telefone: $fone \n<br>

               Código de ativação: $activation_code \n<br><br>

               $a_link<br><br>

               ______________________________________________________<br>
               Esta é uma mensagem automática.<br> 
               *** Não responda a este EMAIL ****
             ";
              ///  Enivar por email
              ///  $res_mail=mail($aprovador_email, stripslashes(utf8_encode($assunto)), utf8_encode($message),$headers1);
              ///$res_mail=mail($aprovador_email, $assunto, $message,$headers1);    
              sleep(2);
              ////             
              $res_mail=mail($aprovador_email, stripslashes(utf8_decode($assunto)), utf8_decode($message),$headers1);
              if( $res_mail ) {
                   $msg_ok .="<br>Email enviado com sucesso para o Aprovador!<br><br>";
                   echo $msg_ok;
              } else {
                   $msg_ok .="<br>Ocorreu um erro durante o envio do email para o Aprovador.<br><br>";
                   echo $msg_ok;                    
              }
             ///               
       }     
   } else {
       echo $msg_erro;         
   }
} 
////     
?>
