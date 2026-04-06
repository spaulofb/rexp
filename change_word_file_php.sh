#!/bin/bash
echo "Digite a palavra atual para mudar: "
read y
echo "Digite a palavra que vai substituir: "
read x

# 
# find . -name '*.*' -type f -print0 | xargs -0   sed -i  's/\$_SESSION\['$x'\]/\$_SESSION\[\"$x\"\]/g'  
/bin/find . -name '*.php' -type f -print0 | xargs -0   /bin/sed -i  "s/$y/$x/g"

/bin/find . -name '*.css' -type f -print0 | xargs -0   /bin/sed -i  "s/$y/$x/g"

  



#



