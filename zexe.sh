cd /var/www/html/rexp
sed -E -i \
  -e '/(\/\/|\/\*|\*\/|#)/! s@\bmysql_(fetch_row|fetch_array|fetch_assoc|num_rows|num_fields)\(@mysqli_\1(@g' \
  -e '/(\/\/|\/\*|\*\/|#)/! s@\bmysql_real_escape_string\(@mysqli_real_escape_string($_SESSION["conex"], @g' \
  includes/dbc.php
echo "=== php -l ==="; php -l includes/dbc.php
echo "=== diff ==="; diff includes/dbc.php.bak3 includes/dbc.php
echo "=== legado restante ==="; grep -nE "\bmysql_[a-z_]+\(" includes/dbc.php   





