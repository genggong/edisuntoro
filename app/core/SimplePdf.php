<?php
/**
 * SimplePdf - generator PDF minimal tanpa library eksternal.
 * Mendukung: header, paragraf, dan tabel dengan wrap + page-break.
 */
class SimplePdf
{
    private $objs = [];      // object pool
    private $pages = [];     // content streams (list of strings)
    private $cur;            // current content
    private $W = 595.28;     // A4 portrait width pt
    private $H = 841.89;
    private $ML = 36, $MR = 36, $MT = 48, $MB = 42;
    private $y;              // current y
    private $page = 0;

    public function __construct()
    {
        $this->newPage();
    }

    private function newPage()
    {
        $this->pages[] = '';
        $this->cur = &$this->pages[count($this->pages) - 1];
        $this->page++;
        $this->y = $this->H - $this->MT;
    }

    private function text($x, $y, $s, $size = 10, $bold = false)
    {
        $s = iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', (string)$s);
        $f = $bold ? 'F2' : 'F1';
        $this->cur .= "BT /$f $size Tf $x $y Td (".$this->esc($s).") Tj ET\n";
    }

    private function line($x1, $y1, $x2, $y2)
    {
        $this->cur .= "$x1 $y1 m $x2 $y2 l S\n";
    }

    private function rect($x, $y, $w, $h, $fill = false)
    {
        if ($fill) {
            $this->cur .= "$x $y $w $h re f\n";
        } else {
            $this->cur .= "$x $y $w $h re S\n";
        }
    }

    private function esc($s)
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $s);
    }

    public function addTitle($title, $subtitle = '')
    {
        $this->ensureSpace(40);
        $this->text($this->ML, $this->y, $title, 15, true);
        $this->y -= 5; // space after titleline (approx)
        $this->line($this->ML, $this->y - 8, $this->W - $this->MR, $this->y - 8);
        if ($subtitle !== '') {
            $this->y -= 18;
            $this->text($this->ML, $this->y, $subtitle, 10);
        }
        $this->y -= 12;
    }

    private function ensureSpace($need)
    {
        if ($this->y - $need < $this->MB) {
            $this->newPage();
        }
    }

    /**
     * @param array $headers string[]
     * @param array $rows array[] of cells
     */
    public function table(array $headers, array $rows)
    {
        $cols = count($headers);
        $cw = ($this->W - $this->ML - $this->MR) / $cols;

        // header row
        $this->ensureSpace(40);
        $hx = $this->ML; $hy = $this->y;
        $this->rect($hx, $hy - 26, ($this->W - $this->ML - $this->MR), 26, false);
        foreach ($headers as $i => $h) {
            $this->text($hx + 4, $hy - 17, $h, 8, true);
            $hx += $cw;
        }
        $this->line($this->ML, $hy - 26, $this->W - $this->MR, $hy - 26);
        $this->y = $hy - 26;

        // data rows
        foreach ($rows as $r) {
            // compute needed height (wrap) -> assume 1 line per row for simplicity + pagination
            $this->ensureSpace(34);
            $ry = $this->y;
            $this->line($this->ML, $ry, $this->W - $this->MR, $ry);
            $x = $this->ML;
            foreach ($r as $i => $cell) {
                $val = (string)$cell;
                $this->text($x + 4, $ry - 14, $this->trunc($val, $cw, 8), 8, false);
                $x += $cw;
            }
            $this->y = $ry - 26;
        }
        $this->line($this->ML, $this->y, $this->W - $this->MR, $this->y);
    }

    private function trunc($s, $cw, $size)
    {
        $max = (int)floor(($cw - 8) / ($size * 0.5));
        if (mb_strlen($s) > $max) {
            return mb_substr($s, 0, max(0, $max - 1)) . '~';
        }
        return $s;
    }

    public function note($s)
    {
        $this->ensureSpace(16);
        $this->text($this->ML, $this->y, $s, 8);
        $this->y -= 14;
    }

    public function output($filename)
    {
        $id = (fn() => $this->unqid())();
        $objs = [];
        $n = 1;
        // pages
        $pageObjs = [];
        $kids = [];
        foreach ($this->pages as $i => $stream) {
            $contentId = $n + 2 * ($i + 1);
            // content object
            $objs[$contentId] = "<< /Length " . strlen($stream) . " >>\nstream\n" . $stream . "\nendstream";
            // page object
            $pageObj = ($i + 1) * 3;
            $objs[$pageObj] = "<< /Type /Page /Parent 1 0 R /MediaBox [0 0 {$this->W} {$this->H}] /Resources 2 0 R /Contents $contentId 0 R >>";
            $kids[] = "$pageObj 0 R";
        }
        // catalog
        $objs[1] = "<< /Type /Pages /Kids [".implode(' ', $kids)."] /Count " . count($kids) . " >>";
        // resources
        $objs[2] = "<< /Font << /F1 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> /F2 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >> >> >>";

        ksort($objs);
        $pdf = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objs as $on => $body) {
            $offsets[$on] = strlen($pdf);
            $pdf .= "$on 0 obj\n$body\nendobj\n";
        }
        $xrefPos = strlen($pdf);
        $max = max(array_keys($objs));
        $pdf .= "xref\n0 ".($max + 1)."\n0000000000 65535 f \n";
        for ($i = 1; $i <= $max; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", isset($offsets[$i]) ? $offsets[$i] : 0);
        }
        $pdf .= "trailer\n<< /Size ".($max + 1)." /Root 1 0 R >>\nstartxref\n$xrefPos\n%%EOF\n";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $pdf;
        exit;
    }

    private function unqid() { return md5(uniqid((string)mt_rand(), true)); }
}
