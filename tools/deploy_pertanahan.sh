#!/usr/bin/env bash
# ============================================================
#  Deploy Buku C Pertanahan ke folder 'pertanahan' di edisuntoro
#  (edisuntoro.web.id = addon domain di akun khakim.web.id)
#
#  JALANKAN di server (SSH terminal):
#      bash deploy_pertanahan.sh
#  Auto-mencari docroot edisuntoro (yang berisi 'main'/Portal),
#  bikin folder pertanahan, tarik source dari GitHub, pasang.
# ============================================================
set -e

HOME_DIR=$(cd ~ && pwd)

find_docroot() {
    for c in \
        "$HOME_DIR/public_html" \
        "$HOME_DIR/edisuntoro.web.id" \
        "$HOME_DIR/edisuntoro" \
        "$HOME_DIR/domains/edisuntoro.web.id/public_html" \
        "$HOME_DIR/domains/edisuntoro/public_html"; do
        if [ -d "$c/main" ] || ls -A "$c" 2>/dev/null | grep -q '^main$'; then
            echo "$c"; return 0
        fi
    done
    local f
    f=$(find "$HOME_DIR" -maxdepth 4 -type d -name main 2>/dev/null | head -1)
    if [ -n "$f" ]; then
        echo "$(dirname "$f")"; return 0
    fi
    return 1
}

DOCROOT=$(find_docroot || true)
if [ -z "$DOCROOT" ]; then
    echo "!! Docroot edisuntoro tak otomatis ketemu. Cek dengan:"
    echo "   ls -la \$HOME"
    echo "   find \$HOME -maxdepth 3 -type d 2>/dev/null | grep -iE 'edisuntoro|public_html|main'"
    exit 1
fi
echo "== Docroot edisuntoro terdeteksi: $DOCROOT"

TARGET="$DOCROOT/pertanahan"
echo "== Target folder: $TARGET"
echo

echo "[1/4] Tarik source dari GitHub..."
rm -rf /tmp/bk-c-tmp
git clone --depth 1 https://github.com/genggong/edisuntoro.git /tmp/bk-c-tmp

echo "[2/4] Salin app/ ke $TARGET ..."
mkdir -p "$TARGET"
cp -rf /tmp/bk-c-tmp/app/. "$TARGET/"
rm -rf /tmp/bk-c-tmp

echo "[3/4] Atur izin file..."
find "$TARGET" -type d -exec chmod 755 {} \;
find "$TARGET" -type f -exec chmod 644 {} \;
mkdir -p "$TARGET/db" && chmod 775 "$TARGET/db"

echo "[4/4] Verifikasi..."
echo "   index.php : $([ -f "$TARGET/index.php" ] && echo OK || echo MASALAH)"
echo "   config.php: $([ -f "$TARGET/config.php" ] && echo OK-siap-mysql/sqlite || echo MASALAH)"

cat <<EOF

==========================================
SELESAI. Berkas di: $TARGET
1) Buka browser => https://edisuntoro.web.id/pertanahan/install.php
2) Setelah sukses, HAPUS installer:
       rm -f "$TARGET/install.php"
3) Login admin/admin123 (ganti password)
4) [phpMyAdmin/MySQL] buat DB di cPanel => isi "$TARGET/config.php"
   (driver 'mysql' + host/db/user/pass) => jalankan install.php sekali lagi
==========================================
EOF
