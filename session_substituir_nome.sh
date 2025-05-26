#!/bin/ksh
#
#  SESSION substituir o nome
#

echo "Digite a palavra - exemplo campos_nome : "
read x
echo "Essa palavra  "$x" será substituída por: "
read y
# 
/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_SESSION\['$x'\]/\$_SESSION\[\"$y\"\]/g"  
/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_SESSION\[\"$x\"\]/\$_SESSION\[\"$y\"\]/g"  

/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_SERVER\['$x'\]/\$_SERVER\[\"$y\"\]/g"  
/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_SERVER\[\"$x\"\]/\$_SERVER\[\"$y\"\]/g"  

/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_GET\['$x'\]/\$_GET\[\"$y\"\]/g"
/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_GET\[\"$x\"\]/\$_GET\[\"$y\"\]/g"

/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_POST\['$x'\]/\$_POST\[\"$y\"\]/g"
/bin/find . -name '*.*' -type f -print0 | xargs -0   /bin/sed -i  "s/\$_POST\[\"$x\"\]/\$_POST\[\"$y\"\]/g"


