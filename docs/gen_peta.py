#!/usr/bin/env python3
"""Generate skema peta titik koordinat Desa Sidamulya (PNG statis)."""
from PIL import Image, ImageDraw, ImageFont
import os

W, H = 720, 560
PAD = 60
wilayah = [[-6.92535, 109.00330], [-6.88535, 109.00330], [-6.88535, 109.04330], [-6.92535, 109.04330]]
tanah = [
    ('C-001', -6.9065, 109.0240), ('C-002', -6.9059, 109.0250), ('C-003', -6.9030, 109.0210),
    ('C-004', -6.9040, 109.0220), ('C-005', -6.9080, 109.0280), ('C-006', -6.9072, 109.0288),
    ('C-007', -6.9000, 109.0180), ('C-008', -6.9010, 109.0190), ('C-009', -6.9090, 109.0300),
    ('C-010', -6.9100, 109.0308), ('C-011', -6.9048, 109.0255), ('C-012', -6.9020, 109.0200),
]
pusat = (-6.90535, 109.02330)

lats = [p[0] for p in wilayah] + [t[1] for t in tanah] + [pusat[0]]
lons = [p[1] for p in wilayah] + [t[2] for t in tanah] + [pusat[1]]
minLat, maxLat = min(lats), max(lats)
minLon, maxLon = min(lons), max(lons)
spanLat = maxLat - minLat or 0.01
spanLon = maxLon - minLon or 0.01
k = min((W - 2 * PAD) / spanLon, (H - 2 * PAD) / spanLat)

def X(lon): return W / 2 + (lon - (minLon + maxLon) / 2) * k
def Y(lat): return H / 2 - (lat - (minLat + maxLat) / 2) * k

img = Image.new('RGB', (W, H), '#eef7ee')
d = ImageDraw.Draw(img)
try:
    fnt = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf", 15)
    fnts = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf", 17)
    fntxs = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf", 12)
except Exception:
    fnt = fnts = fntxs = ImageFont.load_default()

# grid
for g in range(0, 9):
    x = PAD + g * (W - 2 * PAD) / 8
    d.line([x, PAD, x, H - PAD], fill='#d6e6d6', width=1)
    y = PAD + g * (H - 2 * PAD) / 8
    d.line([PAD, y, W - PAD, y], fill='#d6e6d6', width=1)

# wilayah polygon
poly = [(X(p[1]), Y(p[0])) for p in wilayah]
d.polygon(poly, fill='rgba' if False else '#ecf5ec', outline='#14532d', width=3)
d.rectangle([0, H - 24, W, H], fill='#f4f7f4')
d.text((10, H - 22), "Koordinat wilayah Desa Sidamulya · Kec. Wanasari · Kab. Brebes (skema)", font=fntxs, fill='#374151')
d.text((6, 6), "109.043, -6.885", font=fntxs, fill='#14532d')

# pusat desa
d.ellipse([X(pusat[1]) - 8, Y(pusat[0]) - 8, X(pusat[1]) + 8, Y(pusat[0]) + 8], fill='#dc2626', outline='#ffffff', width=2)
d.text((X(pusat[1]) + 12, Y(pusat[0]) - 14), "Pusat Desa", font=fntxs, fill='#dc2626')

# titik tanah
for no, lat, lon in tanah:
    d.ellipse([X(lon) - 6, Y(lat) - 6, X(lon) + 6, Y(lat) + 6], fill='#2563eb', outline='#ffffff', width=1)
    d.text((X(lon) - 20, Y(lat) - 24), no, font=fntxs, fill='#1e40af')

img.save('/home/ubuntu/buku-c-pertanahan/docs/skema-peta-sidamulya.png')
print("saved", img.size)
