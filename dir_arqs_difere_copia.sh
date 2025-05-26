#!/bin/bash 
#
#  Diretorios com arquivos diferentes
#
echo -e  "Digite o diretorio para comparar entre desktop e mobile: "
read dir

dir1=dir_$dir'1.txt'
dir2=dir_$dir'2.txt'

#  Diretorio 1 - mobile - cheio
/bin/ls  -l    /var/www/html/rexp/mobile/$dir/ | awk '{print $9}' | grep -v "^$"   > $dir1

#  Diretorio 2  - desktop  - principal 
/bin/ls  -l    /var/www/html/rexp/$dir/ | awk '{print $9}' | grep -v "^$"   > $dir2 

/usr/bin/diff  $dir2  $dir1  > arqs_difere_$dir.txt

echo -e "\r\n   $dir2   E   $dir1 \r\n "

/bin/cat  arqs_difere_$dir.txt

filename=arqs_difere_$dir.txt

#   linhas=$(/usr/bin/wc -l ${filename}  | /bin/awk "{print $0}"  )
linhas=$(/bin/cat ${filename} |  /usr/bin/wc -l  )

if [[ $linhas < 1 ]]
then
  echo -e "Nenhum arquivo diferente - OK"
  exit
else
  echo -e "Encontrado arquivos diferentes - corrigir"
fi

unset linhas
linhas=$(/bin/grep -c  '^>' ${filename} )

echo -e "Total de Arquivos: "$linhas

/bin/mv  arqs_difere_$dir.txt /var/www/html/rexp/mobile/$dir/removerarqsdifere.sh 

removerarqsdifere=/var/www/html/rexp/mobile/$dir/removerarqsdifere.sh

temparqs=/var/www/html/rexp/mobile/$dir/temparqs.txt

#  /bin/sed   '1s/^/#!\/bin\/bash \n/'  /var/www/html/rexp/mobile/$dir/removerarqsdifere.sh > $temparqs
/bin/sed   '1s/^/#!\/bin\/bash \n/' $removerarqsdifere > $temparqs

# /bin/mv  $temparqs   /var/www/html/rexp/mobile/$dir/removerarqsdifere.sh
 /bin/mv  $temparqs   $removerarqsdifere


# /bin/grep -v '^[0-9]*a' removerarqsdifere.sh > $temparqs
/bin/grep -v '^[0-9]*a' $removerarqsdifere  > $temparqs 

# /bin/sed 's/^>/\/bin\/rm -i /g'  $temparqs  > removerarqsdifere.sh   
 /bin/sed 's/^>/\/bin\/rm -i /g'  $temparqs  > $removerarqsdifere  
  
#  Removendo arquivo temporario 
/bin/rm $temparqs

/bin/chmod 0700   $removerarqsdifere  

 
