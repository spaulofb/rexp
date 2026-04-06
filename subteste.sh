#!/bin/bash
echo "Digite a palavra atual para mudar: "
read y
echo "Digite a palavra que vai substituir: "
read x

#  y='Coordenador'
# x='Orientador' 


#  Arquivos PHP
#  arquivos='/var/www/html/temp/lixo/*.php'
for i in  `find . -name '*.php' ` 
do 
sed  "s,$y,$x,g" $i  > $i.NEW 
mv $i.NEW  $i 
done

/bin/sleep 10 &

#  Arquivos JS
for j  in  `find . -name '*.js' ` 
do 
sed  "s,$y,$x,g" $j  > $j.NEW 
mv  $j.NEW  $j 
done

/bin/sleep 10 &


#  Arquivos TXT
for z  in  `find . -name '*.txt' ` 
do 
sed  "s,$y,$x,g" $z  > $z.NEW 
mv  $z.NEW  $z
done

/bin/sleep 10 &

#!/bin/ksh
# Loop through every file like this
#
# variedade="abc"
# echo $variedade
# find ./ -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$_SESSION\[abc\]/\$_SESSION\[\"abc\"\]/g' 
# find ./ -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$_SESSION\[\$variedade\]/\$_SESSION\[\"\$variedade\"\]/g' 


echo -e  "Digite a palavra - exemplo campos_nome : "
read x
echo "Essa palavra  "$x" foi incluido"
# 
# find . -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$_SESSION\['$x'\]/\$_SESSION\[\"$x\"\]/g'  
find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_SESSION\['$x'\]/\$_SESSION\[\"$x\"\]/g"  

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_SERVER\['$x'\]/\$_SERVER\[\"$x\"\]/g"  

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_GET\['$x'\]/\$_GET\[\"$x\"\]/g"

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_POST\['$x'\]/\$_POST\[\"$x\"\]/g"

# find . -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$linha\['$x'\]/\$linha\[\"$x\"\]/g'
find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/SESSION\['m_nome_id'\]/\SESSION\[\"m_nome_id\"\]/g"
 


#



