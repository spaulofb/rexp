#!/bin/bash
#
#   BACKUP MYSQL
#
clear   
#
#  VERIFICANDO  se o diretorio mysql backup existe
mysql_bak=/var/bak/mysql/
if [ ! -d "$mysql_bak" ]
then
    # Criando o diretorio mysql backup
    /bin/mkdir $mysql_bak
    #
fi
/bin/chown -R gemacadm.gemacadm  $mysql_bak
#
#   Array Databases
#   array_mysql=("ipconectar bioinfc")
string_original=("ajax alunos bookedscheduler busca cadastro caobi cew2015 cidade dblinks downloads imasters intranet jogo lancon login_senha patrimonio_tb_tmp producao reservas sas sfsman siteweb tensino teste bdpalavras cew2014 genetica_bl_c loja patrimonio pessoal rexp testando grupoemail ipconectar bioinfc")


# Converter string em array (separar por espaços)
read -ra array_original <<< "$string_original"

#
# Ordenar e criar novo array
array_mysql=()
while IFS= read -r item; do
    array_mysql+=("$item")
done < <(printf "%s\n" "${array_original[@]}" | sort)



#  echo "Array ordenado:"
#  printf '%s\n' "${array_mysql[@]}"

echo -e  "  "

#  exit

#
# Dir do MYSQL
mysql_dir0=/var/lib/mysql/
# 
# Variável com anomesdia (yyyymmdd)
anomesdia=$(date +%Y%m%d)

# Variável com o nome completo do arquivo
arquivo="nome_${anomesdia}_sql.gz"

#  echo "Data: $anomesdia"
#   echo "Arquivo: $arquivo"

echo -e  "  "

# exit


# Usando For para Array
#  /sbin/service mysqld restart
for xarr in  ${array_mysql[@]}
do
   #
   mysql_dir1=$mysql_dir0$xarr
   if [ -d "$mysql_dir1" ]
   then
       #
       m_gzip_mysql=$mysql_bak"bk_"$xarr"_v${anomesdia}_sql.gz"

 #      /usr/bin/mysqldump --routines    -u soldbm -p'@%!_sol_dbm' $xarr  | gzip > $m_gzip_mysql
  
    
     echo -e  $m_gzip_mysql

     echo -e  " "

      /usr/bin/mysqldump --routines -u soldbm -p'lexus2P5W1!'  --add-drop-database -B  $xarr  | gzip > $m_gzip_mysql
       #
   fi
   #
done
/bin/chown -R gemacadm.gemacadm $mysql_bak


