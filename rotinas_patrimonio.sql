DELIMITER ;;
CREATE DEFINER=`*`@`localhost` PROCEDURE `sessao_regs`()
BEGIN


    DECLARE CheckExists int;  
    SET CheckExists = 0;


SELECT  count(*) INTO CheckExists  FROM  patrimonio.sessao WHERE  codigo>2000  ORDER BY codigo ASC;


IF (CheckExists > 0) THEN 
    
    
   
    
    
    
    DROP TABLE IF EXISTS patrimonio.sessao_anterior;
    
    
    
    CREATE TABLE  patrimonio.sessao_anterior like patrimonio.sessao;
    commit;
    
    
    insert into patrimonio.sessao_anterior   Select * from patrimonio.sessao;
    commit;
    
    
    
    
    
    
    
    
    DROP TABLE  if exists patrimonio.sessaotmp;
    commit;
    
    
    
   CREATE TABLE  patrimonio.sessaotmp like patrimonio.sessao;
   commit;
   
   
   INSERT  into patrimonio.sessaotmp  select * from patrimonio.sessao  WHERE  codigo>2000;
   commit;
   
   
   
   
   SET FOREIGN_KEY_CHECKS = 0; 
   
   TRUNCATE TABLE  patrimonio.sessao ;
   commit;
   
   SET FOREIGN_KEY_CHECKS = 1; 
   
   
   
   ALTER TABLE  patrimonio.sessao  AUTO_INCREMENT=1;
   commit;
   
   
   
   
   INSERT INTO patrimonio.sessao ( datahorai,datahoraf,usuario,ipacesso,codacesso)  select datahorai,datahoraf,usuario,ipacesso,codacesso from patrimonio.sessaotmp order by codigo;
   commit;





END IF; 



END ;;
DELIMITER ;

