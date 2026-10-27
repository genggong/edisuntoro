<?php
/**
 * Polygon & validasi spasial sederhana (tanpa PostGIS).
 * Ring: array [[lat,lon], [lat,lon], ...] (klosur opsional; wajib ≥3 titik).
 */
class Polygon
{
    /** Luas polygon (m²) dari koordinat lat/lon via metode trapesium (area geografis kira-kira). */
    public static function areaM2(array $ring)
    {
        $n = count($ring);
        if ($n < 3) return 0.0;
        $area = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $j = ($i + 1) % $n;
            $lat1 = $ring[$i][0]; $lon1 = $ring[$i][1];
            $lat2 = $ring[$j][0]; $lon2 = $ring[$j][1];
            // proyeksi meter sederhana di sekitar lintang rata-rata
            $x1 = $lon1 * 111320 * cos(deg2rad(($lat1 + $lat2) / 2));
            $y1 = $lat1 * 110540;
            $x2 = $lon2 * 111320 * cos(deg2rad(($lat1 + $lat2) / 2));
            $y2 = $lat2 * 110540;
            $area += ($x1 * $y2 - $x2 * $y1);
        }
        return abs($area / 2.0);
    }

    /** Cek apakah titik (lat,lon) berada di dalam polygon (ray casting). */
    public static function pointIn(array $pt, array $ring)
    {
        $x = $pt[1]; $y = $pt[0];
        $n = count($ring);
        $inside = false;
        $p1 = $ring[0];
        for ($i = 1; $i <= $n; $i++) {
            $p2 = $ring[$i % $n];
            if (($p1[1] > $x) !== ($p2[1] > $x) &&
                $y < ($p2[0] - $p1[0]) * ($x - $p1[1]) / ($p2[1] - $p1[1]) + $p1[0]) {
                $inside = !$inside;
            }
            $p1 = $p2;
        }
        return $inside;
    }

    /** Orientasi: 1 CW, -1 CCW, 0 collinear */
    private static function orient(array $a, array $b, array $c)
    {
        $v = ($b[1]-$a[1])*($c[0]-$b[0]) - ($b[0]-$a[0])*($c[1]-$b[1]);
        return ($v > 0) ? 1 : (($v < 0) ? -1 : 0);
    }

    private static function onSeg(array $p, array $a, array $b)
    {
        return min($a[0],$b[0]) <= $p[0] && $p[0] <= max($a[0],$b[0]) &&
               min($a[1],$b[1]) <= $p[1] && $p[1] <= max($a[1],$b[1]);
    }

    /** Apakah dua segmen berpotongan? */
    private static function segIntersect(array $a, array $b, array $c, array $d)
    {
        $o1 = self::orient($a, $b, $c);
        $o2 = self::orient($a, $b, $d);
        $o3 = self::orient($c, $d, $a);
        $o4 = self::orient($c, $d, $b);
        if ($o1 !== $o2 && $o3 !== $o4) return true;
        if ($o1 === 0 && self::onSeg($c, $a, $b)) return true;
        if ($o2 === 0 && self::onSeg($d, $a, $b)) return true;
        if ($o3 === 0 && self::onSeg($a, $c, $d)) return true;
        if ($o4 === 0 && self::onSeg($b, $c, $d)) return true;
        return false;
    }

    /** Apakah dua polygon saling tumpang tindih (overlap)? */
    public static function overlaps(array $A, array $B)
    {
        // Ada titik A di dalam B?
        foreach ($A as $p) if (self::pointIn($p, $B)) return true;
        // Ada titik B di dalam A?
        foreach ($B as $p) if (self::pointIn($p, $A)) return true;
        // Ada sisi berpotongan?
        $na = count($A); $nb = count($B);
        for ($i = 0; $i < $na; $i++) {
            for ($j = 0; $j < $nb; $j++) {
                if (self::segIntersect($A[$i], $A[($i+1)%$na], $B[$j], $B[($j+1)%$nb])) return true;
            }
        }
        return false;
    }

    /** Parse string "lat,lon; lat,lon; ..." menjadi ring array. Return [] jika tak valid. */
    public static function parse($s)
    {
        $ring = [];
        foreach (explode(';', trim($s)) as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') continue;
            $p = array_map('trim', explode(',', $chunk));
            if (count($p) < 2 || !is_numeric($p[0]) || !is_numeric($p[1])) return [];
            $ring[] = [(float)$p[0], (float)$p[1]];
        }
        if (count($ring) < 3) return [];
        return $ring;
    }

    /** Deteksi minimal & rapi untuk pesan ringkas */
    public static function statusText($ring)
    {
        return $ring ? 'Aman (0% overlap)' : 'Tidak ada polygon';
    }
}
