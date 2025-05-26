#!/bin/ksh
# Loop through every file like this
#
# variedade="abc"
# echo $variedade
# find ./ -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$_SESSION\[abc\]/\$_SESSION\[\"abc\"\]/g' 
# find ./ -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$_SESSION\[\$variedade\]/\$_SESSION\[\"\$variedade\"\]/g' 


echo "Digite a palavra - exemplo campos_nome : "
read x
echo "Essa palavra  "$x" foi incluido"
# 
# find . -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$_SESSION\['$x'\]/\$_SESSION\[\"$x\"\]/g'  
find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_SESSION\['$x'\]/\$_SESSION\[\"$x\"\]/g"  

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_GET\['$x'\]/\$_GET\[\"$x\"\]/g"

find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/\$_POST\['$x'\]/\$_POST\[\"$x\"\]/g"

# find . -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$linha\['$x'\]/\$linha\[\"$x\"\]/g'
find . -name '*.*' -type f -print0 | xargs -0   sed -i  "s/SESSION\['m_nome_id'\]/\SESSION\[\"m_nome_id\"\]/g"
 


#



