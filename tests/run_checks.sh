#!/usr/bin/env bash
# Cek kesehatan aplikasi: lint, DB, login, route, CSRF. Jalankan dari root repo.
set -u
cd "$(dirname "$0")/.."
APP=app
echo "== php -l =="
bad=0
for f in $(find "$APP" -name '*.php'); do
  php -l "$f" >/dev/null 2>&1 || { echo "SYNTAX ERROR: $f"; bad=1; }
done
[ $bad -eq 0 ] && echo "OK semua file lolos lint"

echo "== DB =="
[ -f "$APP/db/buku_c.db" ] && echo "OK db ada" || echo "jalankan dulu: php $APP/install.php"

echo "== HTTP smoke test (butuh server jalan) =="
PORT=${1:-8898}
B="http://127.0.0.1:$PORT"
if curl -s -o /dev/null "$B/login"; then
  curl -s -o /dev/null -w "login GET: %{http_code}\n" "$B/login"
  cj=$(mktemp)
  csrf=$(curl -s -c "$cj" "$B/login" | grep -oP 'name="csrf" value="\K[^"]+')
  curl -s -b "$cj" -c "$cj" -o /dev/null -w "login POST: %{http_code}\n" -X POST "$B/login" \
    --data-urlencode "username=admin" --data-urlencode "password=admin123" --data-urlencode "csrf=$csrf"
  for p in / /tanah /statistik /peta; do curl -s -b "$cj" -o /dev/null -w "GET $p: %{http_code}\n" "$B$p"; done
else
  echo "Server tidak jalan. Jalankan: cd $APP && php -S 0.0.0.0:$PORT"
fi
exit 0
