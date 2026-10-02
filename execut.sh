cd /var/www/html/rexp   # ajuste para a raiz do seu site

# 1. Lista os arquivos afetados ANTES de mexer
grep -rlF "htmlentities(mb_convert_encoding(" . --include='*.php' > /tmp/afetados.txt
cat /tmp/afetados.txt

# 2. Backup só dos afetados
tar czf ~/backup-htmlent-$(date +%F-%H%M).tar.gz -T /tmp/afetados.txt

# 3. Aplica o fix (sed -E com (.*) greedy — NUNCA [^)]*, por causa de parênteses aninhados)
while IFS= read -r f; do
  sed -E -i \
    "s/htmlentities\(mb_convert_encoding\((.*)\), *'ISO-8859-1', *'UTF-8'\)/htmlentities(mb_convert_encoding(\1, 'ISO-8859-1', 'UTF-8'))/g" \
    "$f"
done < /tmp/afetados.txt

# 4. Verifica sintaxe de cada um
while IFS= read -r f; do php -l "$f"; done < /tmp/afetados.txt

# 5. Confirma que o padrão quebrado sumiu
grep -rnF "htmlentities(mb_convert_encoding(" . --include='*.php'




