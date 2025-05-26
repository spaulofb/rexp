     $array_nome_val=mysql_fetch_array($result_outro);
     ///  Caso tenha registros
     for( $i=0; $i<$n_fields ; $i++ )  {
          ///  Nome do campo da Tabela
          $name_c_id[$i] = trim(mysql_field_name($result_outro,$i));  
          $nomecpo=$name_c_id[$i];
          ///  Tamanho do campo da Tabela
          $len_c[$i] = mysql_field_len($result_outro,$i);
          ///  Criando array nome do campo e tamanho do campo
          $len_nomecpo[$nomecpo]=$len_c[$i];
          ///
          ///  Para colocar os dados na Lista da Consulta
          ///  $_SESSION["m_value_c"][$i] =  html_entity_decode(mysql_result($result_outro,0,$i)); 
          $_SESSION["m_value_c"][$i] =  mysql_result($result_outro,0,$i); 
     }
     ///
     $name_c_id[0]=trim(mysql_field_name($result_outro,$xc1));
     $name_c_id[1]=trim(mysql_field_name($result_outro,$xc2));
     $len_c[0]=mysql_field_len($result_outro,$xc1); 
     $len_c[1]=mysql_field_len($result_outro,$xc2);
     $_SESSION["m_value_c"][0] =  html_entity_decode(mysql_result($result_outro,0,$xc1)); 
     $_SESSION["m_value_c"][1] =  html_entity_decode(mysql_result($result_outro,0,$xc2));                  
     if( $_SESSION["m_nome_id"]=="atributo" ) $m_height=" 220";                   
     if( ! isset($name_c1) ) {
         $name_c1= ucfirst($name_c_id[$xc1]);  
         if( $name_c_id[0]=="historico" ) $name_c1="Hist&oacute;rico";                     
     } 
     if( ! isset($name_c2) ) {
         if( isset($name_c_id[$xc2]) ) $name_c2=ucfirst($name_c_id[$xc2]);                     
     }
