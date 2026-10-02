#!/bin/bash

SITE="/var/www/html/rexp"
cd "$SITE" || { echo "Pasta não encontrada"; exit 1; }

# Detecta os arquivos que ainda têm alguma dessas chamadas
DET='ysqli_query\(.*(DELIMITER|'\''begin'\''|'\''end'\''|UNLOCK)|_SESSION\["conex"\]->query\(.*LOCK TABLES'

mapfile -t FILES < <(grep -rlE "$DET" --include='*.php' .)
echo ">> Arquivos a alterar: ${#FILES[@]}"
printf '   %s\n' "${FILES[@]}"
echo

for f in "${FILES[@]}"; do
  cp -a "$f" "$f.bak"

  # Remove SÓ a chamada (preserva o resto da linha)
  sed -i -E \
    -e "s/[a-z]*ysqli_query\([^;]*'DELIMITER[^']*'\);//g" \
    -e "s/[a-z]*ysqli_query\([^;]*'begin'\);//g" \
    -e "s/[a-z]*ysqli_query\([^;]*'end'\);//g" \
    -e "s/[a-z]*ysqli_query\([^;]*UNLOCK[^;]*\);//g" \
    -e "s/\$_SESSION\[\"conex\"\]->query\([^;]*LOCK TABLES[^;]*\);//g" \
    "$f"

  # Valida a sintaxe; se quebrar, reverte automaticamente
  if php -l "$f" >/dev/null 2>&1; then
     echo "OK    $f"
     rm -f "$f.bak"
  else
     echo "ERRO  $f  -> revertido"
     php -l "$f" 2>&1 | sed 's/^/        /'
     mv -f "$f.bak" "$f"
  fi
done

echo
echo "--- Re-checagem (não pode sobrar nada) ---"
if grep -rnE "$DET" --include='*.php' "$SITE"; then
   echo ">> Ainda há ocorrências nos arquivos acima (foram revertidos por erro de sintaxe)."
else
   echo ">> Nenhuma ocorrência restante. Concluído."
fi  





