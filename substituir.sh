#!/bin/bash
#
#     ATUALIZADO EM 20230127
##
/bin/echo -e  "Digite a palavra atual para mudar: "
read y
/bin/echo -e  "Digite a palavra que vai substituir: "
read x

#  Arquivos extensoes do Array
# 
# declare an array called array and define values
array=( php js txt inc html )
#
#for ext  in "${array[@]}"
#do
#    arquivo=*.$ext
#    /bin/echo -e $arquivo
#done
#


# for para array
for ext  in "${array[@]}"
do
    #
    arquivo=*.$ext
    #
    # for i in  `find . -name '*.$ext' `
    for i in  `/bin/find . -iname "$arquivo"   ` 
    do 
        #  Modificando a palavra do arquivo com as extensoes  
     	/bin/sed -i -- "s:$y:$x:gi" $i  

        #       
    done
done
