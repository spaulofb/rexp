#!/bin/ksh
#
#  SESSION substituir o nome
#

echo "Digite a palavra - exemplo campos_nome : "
read x
echo "Essa palavra  "$x" será substituído por: "
read y
# 
find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_SESSION\['$x'\]/\$_SESSION\[\"$x\"\]/g"  

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_SERVER\['$x'\]/\$_SERVER\[\"$x\"\]/g"  

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_GET\['$x'\]/\$_GET\[\"$x\"\]/g"

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_POST\['$x'\]/\$_POST\[\"$x\"\]/g"

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/SESSION\['m_nome_id'\]/\SESSION\[\"m_nome_id\"\]/g"
 


#



