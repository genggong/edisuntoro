#!/usr/bin/env python3
"""Flowchart alur aplikasi Buku C Pertanahan (PIL)."""
from PIL import Image, ImageDraw, ImageFont

W, H = 920, 1580
BG = "#f6f8f6"
img = Image.new("RGB", (W, H), BG)
d = ImageDraw.Draw(img)

def F(sz, bold=False):
    p = "/usr/share/fonts/truetype/dejavu/DejaVuSans%s.ttf" % ("-Bold" if bold else "")
    return ImageFont.truetype(p, sz)

f_title = F(30, True)
f_node = F(21)
f_node_b = F(21, True)
f_small = F(17)
f_tiny = F(15)

GREEN = "#14532d"; GREEN_L = "#dcfce7"
BLUE = "#1d4ed8"; BLUE_L = "#dbeafe"
AMBER = "#b45309"; AMBER_L = "#fef3c7"
TEAL = "#0f766e"; TEAL_L = "#ccfbf1"
INK = "#1f2937"

def cx(w): return (W - w) // 2

def arrow(x, y1, y2, color=GREEN, wdt=4):
    d.line([x, y1, x, y2], fill=color, width=wdt)
    d.polygon([(x, y2 + 4), (x - 10, y2 - 12), (x + 10, y2 - 12)], fill=color)

def node(x, y, w, h, lines, fill, outline, tcol=INK, radius=18):
    d.rounded_rectangle([x, y, x + w, y + h], radius, fill=fill, outline=outline, width=3)
    th = 24
    for (txt, fnt, col) in lines:
        tw = d.textlength(txt, font=fnt)
        d.text((x + (w - tw) / 2, y + th), txt, font=fnt, fill=col)
        th += fnt.size + 6
    return (x, y, w, h)

AX = 40
CX = W // 2

# Title
t = "ALUR APLIKASI BUKU C PERTANAHAN"
d.text((cx(d.textlength(t, font=f_title)), 28), t, font=f_title, fill=GREEN)
st = "Desa Sidamulya · Kec. Wanasari · Kab. Brebes"
d.text((cx(d.textlength(st, font=f_small)), 76), st, font=f_small, fill="#6b7280")

top = 130
# Start
sx, sy, sw, sh = node(cx(300), top, 300, 70, [("MULAI / BUKA APLIKASI", f_node_b, INK)], GREEN_L, GREEN)
arrow(CX, sy + sh + 4, sy + sh + 60)

# Login
ly = sy + sh + 66
lx, lyy, lw, lh = node(cx(600), ly, 600, 100, [
    ("LOGIN (admin / admin123)", f_node_b, INK),
    ("username & password benar?", f_node, "#374151"),
], BLUE_L, BLUE)
d.text((lx + lw - 190, lyy + 22), "GAGAL", font=f_small, fill="#dc2626")
d.line([lx + lw - 10, lyy + 62, 890, lyy + 62], fill="#dc2626", width=3)
d.line([890, lyy + 62, 878, lyy + 50], fill="#dc2626", width=3)
d.text((896 - 150, lyy + 66), "kembali ke login", font=f_tiny, fill="#dc2626")
arrow(CX, lyy + lh + 4, lyy + lh + 60)

# Beranda
by = lyy + lh + 66
bx, byy, bw, bh = node(cx(740), by, 740, 120, [
    ("BERANDA", f_node_b, INK),
    ("Ringkasan: jumlah bidang · total luas (m² / Ha)", f_node, "#374151"),
    ("Rekap per jenis tanah · data terbaru", f_node, "#374151"),
], "#ffffff", GREEN)
arrow(CX, byy + bh + 4, byy + bh + 56)
ml = "PILIH MENU"
d.text((cx(d.textlength(ml, font=f_node_b)), byy + bh + 66), ml, font=f_node_b, fill=AMBER)

# 4 menu boxes
menu_y = byy + bh + 104
menu_h = 200
gap = 22
mw = (W - 2 * AX - 3 * gap) // 4
menus = [
    ("📋 BUKU C", ["Tambah","Edit","Hapus","Cari data"], BLUE, BLUE_L),
    ("📊 REKAP", ["Per jenis tanah","Per blok / dusun"], GREEN, GREEN_L),
    ("🗺 PETA", ["Skema titik koordinat","wilayah + bidang"], AMBER, AMBER_L),
    ("⬇ EKSPOR", ["Unduh CSV","semua data"], TEAL, TEAL_L),
]
for i, (title, items, col, fill) in enumerate(menus):
    x = AX + i * (mw + gap)
    d.rounded_rectangle([x, menu_y, x + mw, menu_y + menu_h], 18, fill=fill, outline=col, width=3)
    tw = d.textlength(title, font=f_node_b)
    d.text((x + (mw - tw) / 2, menu_y + 20), title, font=f_node_b, fill=col)
    iy = menu_y + 20 + f_node_b.size + 16
    for it in items:
        itw = d.textlength(it, font=f_small)
        d.text((x + (mw - itw) / 2, iy), it, font=f_small, fill="#374151")
        iy += f_small.size + 8
    d.line([CX, byy + bh + 92, x + mw // 2, menu_y], fill=GREEN, width=3)

# converge
ny = menu_y + menu_h
conv_y = ny + 30
d.line([(AX + mw // 2, ny), (AX + mw // 2, conv_y)], fill=GREEN, width=3)
d.line([(W - AX - mw // 2, ny), (W - AX - mw // 2, conv_y)], fill=GREEN, width=3)
d.line([(AX + mw // 2, conv_y), (W - AX - mw // 2, conv_y)], fill=GREEN, width=3)
arrow(CX, conv_y + 2, conv_y + 48)

# End
endy = conv_y + 54
node(cx(420), endy, 420, 110, [
    ("SELESAI / LOGOUT", f_node_b, INK),
    ("Data terekam di SQLite", f_small, "#6b7280"),
], GREEN_L, GREEN)

fd = "Buku C terekam per bidang · titik koordinat tampil di menu Peta"
d.text((cx(d.textlength(fd, font=f_tiny)), H - 32), fd, font=f_tiny, fill="#9ca3af")

img.save("/home/ubuntu/buku-c-pertanahan/docs/flowchart-alur-buku-c.png")
print("saved", img.size)
