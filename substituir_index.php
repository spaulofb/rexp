#!/bin/bash
# echo "Digite a palavra atual para mudar: "
# read y
# echo "Digite a palavra que vai substituir: "
# read x

#  y='Coordenador'
# x='Orientador' 


#  Arquivos PHP
#  arquivos='/var/www/html/temp/lixo/*.php'
for i in  `find . -name '*.php' ` 
do 
sed 's/\/www\/php_include/\/www\/cgi-bin\/php_include/g'    $i  > $i.NEW 
mv $i.NEW  $i 
done

/bin/sleep 10 &

#  Arquivos JS
for j  in  `find . -name '*.js' ` 
do 
sed  's/\/www\/php_include/\/www\/cgi-bin\/php_include/g'    $j  > $j.NEW 
mv  $j.NEW  $j 
done

/bin/sleep 10 &


#  Arquivos TXT
for z  in  `find . -name '*.txt' ` 
do 
sed 's/\/www\/php_include/\/www\/cgi-bin\/php_include/g'    $z  > $z.NEW 
mv  $z.NEW  $z
done

/bin/sleep 10 &
