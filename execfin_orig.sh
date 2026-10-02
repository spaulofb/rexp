!#/bin/bash  


PAT='ysqli_query\(.*(DELIMITER|'\''begin'\''|'\''end'\''|UNLOCK)|_SESSION\["conex"\]->query\(.*LOCK TABLES'  

# Remove só nos arquivos que ainda têm o padrão, com .bak individual
for f in $(grep -rlE "$PAT" --include='*.php' .); do
  cp -a "$f" "$f.bak"
  sed -i -E "/$PAT/d" "$f"
  echo "Alterado: $f"
  php -l "$f"      # mostra o erro pré-existente, mas NÃO reverte
done  







