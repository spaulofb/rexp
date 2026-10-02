#!/usr/bin/env bash
set -uo pipefail

SITE="/var/www/html/rexp"   # <-- ajuste para a raiz do seu site
PAT='ysqli_query\(.*(DELIMITER|'\''begin'\''|'\''end'\''|UNLOCK)|_SESSION\["conex"\]->query\(.*LOCK TABLES'
STAMP=$(date +%F-%H%M%S)

# 1) Backup completo do site
tar czf "$HOME/backup-site-$STAMP.tar.gz" -C "$SITE" . \
  && echo "Backup criado: $HOME/backup-site-$STAMP.tar.gz"

# 2) Arquivos que serão alterados
mapfile -t FILES < <(grep -rlE "$PAT" --include='*.php' "$SITE")
echo ">> Arquivos afetados: ${#FILES[@]}"
printf '   %s\n' "${FILES[@]}"

# 3) Remove as linhas (gera .bak por arquivo) e valida a sintaxe
for f in "${FILES[@]}"; do
  sed -i.bak -E "/$PAT/d" "$f"
  if php -l "$f" >/dev/null 2>&1; then
     echo "OK   $f"
     rm -f "$f.bak"
  else
     echo "ERRO de sintaxe em $f -> revertendo"
     mv -f "$f.bak" "$f"
  fi
done

# 4) Re-checagem: não pode sobrar nada
echo "--- Re-checagem ---"
if grep -rnE "$PAT" --include='*.php' "$SITE"; then
   echo "ATENCAO: ainda há ocorrências (veja acima)"
else
   echo "Nenhuma ocorrência restante. OK."
fi  






