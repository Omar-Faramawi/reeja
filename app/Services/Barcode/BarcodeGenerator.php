<?php namespace Tamkeen\Ajeer\Services\Barcode;

class BarcodeGenerator
{
    /**
     * Return a SVG string representation of barcode.
     *
     * @param string $code code to print
     * @param int $w Minimum width of a single bar in user units.
     * @param int $h Height of barcode in user units.
     * @param string $color Foreground color (in SVG format) for bar elements (background is transparent).
     *
     * @return string SVG code.
     */
    public function generate($code, $w = 2, $h = 30, $color = 'black')
    {
        $code_array = $this->barcode_c128($code);

        // replace table for special characters
        $repstr = array("\0" => '', '&' => '&amp;', '<' => '&lt;', '>' => '&gt;');
        $svg = '<' . '?' . 'xml version="1.0" standalone="no"' . '?' . '>' . "\n";
        $svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . "\n";
        $svg .= '<svg width="' . round(($code_array['maxw'] * $w), 3) . '" height="' . $h . '" version="1.1" xmlns="http://www.w3.org/2000/svg">' . "\n";
        $svg .= "\t" . '<desc>' . strtr($code_array['code'], $repstr) . '</desc>' . "\n";
        $svg .= "\t" . '<g id="bars" fill="' . $color . '" stroke="none">' . "\n";
        // print bars
        $x = 0;
        foreach ($code_array['bcode'] as $k => $v) {
            $bw = round(($v['w'] * $w), 3);
            $bh = round(($v['h'] * $h / $code_array['maxh']), 3);
            if ($v['t']) {
                $y = round(($v['p'] * $h / $code_array['maxh']), 3);
                // draw a vertical bar
                $svg .= "\t\t" . '<rect x="' . $x . '" y="' . $y . '" width="' . $bw . '" height="' . $bh . '" />' . "\n";
            }
            $x += $bw;
        }
        $svg .= "\t" . '</g>' . "\n";
        $svg .= '</svg>' . "\n";

        return $svg;
    }

    /**
     * C128 barcodes. Very capable code, excellent density, high reliability; in very wide use world-wide.
     *
     * @param $code (string) code to represent.
     *
     * @return array barcode representation.
     */
    protected function barcode_c128($code)
    {
        $chr = [
            '212222', /* 00 */
            '222122', /* 01 */
            '222221', /* 02 */
            '121223', /* 03 */
            '121322', /* 04 */
            '131222', /* 05 */
            '122213', /* 06 */
            '122312', /* 07 */
            '132212', /* 08 */
            '221213', /* 09 */
            '221312', /* 10 */
            '231212', /* 11 */
            '112232', /* 12 */
            '122132', /* 13 */
            '122231', /* 14 */
            '113222', /* 15 */
            '123122', /* 16 */
            '123221', /* 17 */
            '223211', /* 18 */
            '221132', /* 19 */
            '221231', /* 20 */
            '213212', /* 21 */
            '223112', /* 22 */
            '312131', /* 23 */
            '311222', /* 24 */
            '321122', /* 25 */
            '321221', /* 26 */
            '312212', /* 27 */
            '322112', /* 28 */
            '322211', /* 29 */
            '212123', /* 30 */
            '212321', /* 31 */
            '232121', /* 32 */
            '111323', /* 33 */
            '131123', /* 34 */
            '131321', /* 35 */
            '112313', /* 36 */
            '132113', /* 37 */
            '132311', /* 38 */
            '211313', /* 39 */
            '231113', /* 40 */
            '231311', /* 41 */
            '112133', /* 42 */
            '112331', /* 43 */
            '132131', /* 44 */
            '113123', /* 45 */
            '113321', /* 46 */
            '133121', /* 47 */
            '313121', /* 48 */
            '211331', /* 49 */
            '231131', /* 50 */
            '213113', /* 51 */
            '213311', /* 52 */
            '213131', /* 53 */
            '311123', /* 54 */
            '311321', /* 55 */
            '331121', /* 56 */
            '312113', /* 57 */
            '312311', /* 58 */
            '332111', /* 59 */
            '314111', /* 60 */
            '221411', /* 61 */
            '431111', /* 62 */
            '111224', /* 63 */
            '111422', /* 64 */
            '121124', /* 65 */
            '121421', /* 66 */
            '141122', /* 67 */
            '141221', /* 68 */
            '112214', /* 69 */
            '112412', /* 70 */
            '122114', /* 71 */
            '122411', /* 72 */
            '142112', /* 73 */
            '142211', /* 74 */
            '241211', /* 75 */
            '221114', /* 76 */
            '413111', /* 77 */
            '241112', /* 78 */
            '134111', /* 79 */
            '111242', /* 80 */
            '121142', /* 81 */
            '121241', /* 82 */
            '114212', /* 83 */
            '124112', /* 84 */
            '124211', /* 85 */
            '411212', /* 86 */
            '421112', /* 87 */
            '421211', /* 88 */
            '212141', /* 89 */
            '214121', /* 90 */
            '412121', /* 91 */
            '111143', /* 92 */
            '111341', /* 93 */
            '131141', /* 94 */
            '114113', /* 95 */
            '114311', /* 96 */
            '411113', /* 97 */
            '411311', /* 98 */
            '113141', /* 99 */
            '114131', /* 100 */
            '311141', /* 101 */
            '411131', /* 102 */
            '211412', /* 103 START A */
            '211214', /* 104 START B */
            '211232', /* 105 START C */
            '233111', /* STOP */
            '200000' /* END */
        ];

        // ASCII characters for code A (ASCII 00 - 95)
        $keys_a = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_';
        $keys_a .= chr(0) . chr(1) . chr(2) . chr(3) . chr(4) . chr(5) . chr(6) . chr(7) . chr(8) . chr(9);
        $keys_a .= chr(10) . chr(11) . chr(12) . chr(13) . chr(14) . chr(15) . chr(16) . chr(17) . chr(18) . chr(19);
        $keys_a .= chr(20) . chr(21) . chr(22) . chr(23) . chr(24) . chr(25) . chr(26) . chr(27) . chr(28) . chr(29);
        $keys_a .= chr(30) . chr(31);

        // ASCII characters for code B (ASCII 32 - 127)
        $keys_b = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~' . chr(127);

        // special codes
        $fnc_a = [241 => 102, 242 => 97, 243 => 96, 244 => 101];
        $fnc_b = [241 => 102, 242 => 97, 243 => 96, 244 => 100];

        // array of symbols
        $code_data = [];

        // length of the code
        $len = strlen($code);

        // split code into sequences
        $sequence = [];

        // get numeric sequences (if any)
        $numseq = [];
        preg_match_all('/([0-9]{4,})/', $code, $numseq, PREG_OFFSET_CAPTURE);

        if (isset($numseq[1]) && !empty($numseq[1])) {
            $end_offset = 0;
            foreach ($numseq[1] as $val) {
                $offset = $val[1];
                if ($offset > $end_offset) {
                    // non numeric sequence
                    $sequence = array_merge($sequence, $this->get128ABsequence(substr($code, $end_offset, ($offset - $end_offset))));
                }
                // numeric sequence
                $slen = strlen($val[0]);
                if (($slen % 2) != 0) {
                    // the length must be even
                    --$slen;
                }
                $sequence[] = array('C', substr($code, $offset, $slen), $slen);
                $end_offset = $offset + $slen;
            }
            if ($end_offset < $len) {
                $sequence = array_merge($sequence, $this->get128ABsequence(substr($code, $end_offset)));
            }
        } else {
            // text code (non C mode)
            $sequence = array_merge($sequence, $this->get128ABsequence($code));
        }

        // process the sequence
        foreach ($sequence as $key => $seq) {
            switch ($seq[0]) {
                case 'A': {
                    if ($key == 0) {
                        $startid = 103;
                    } elseif ($sequence[($key - 1)][0] != 'A') {
                        if (($seq[2] == 1) && ($key > 0) && ($sequence[($key - 1)][0] == 'B') && (!isset($sequence[($key - 1)][3]))) {
                            // single character shift
                            $code_data[] = 98;
                            // mark shift
                            $sequence[$key][3] = true;
                        } elseif (!isset($sequence[($key - 1)][3])) {
                            $code_data[] = 101;
                        }
                    }
                    for ($i = 0; $i < $seq[2]; ++$i) {
                        $char = $seq[1]{$i};
                        $char_id = ord($char);
                        if (($char_id >= 241) && ($char_id <= 244)) {
                            $code_data[] = $fnc_a[$char_id];
                        } else {
                            $code_data[] = strpos($keys_a, $char);
                        }
                    }
                    break;
                }
                case 'B': {
                    if ($key == 0) {
                        $tmpchr = ord($seq[1]{0});
                        if (($seq[2] == 1) && ($tmpchr >= 241) && ($tmpchr <= 244) && isset($sequence[($key + 1)]) && ($sequence[($key + 1)][0] != 'B')) {
                            switch ($sequence[($key + 1)][0]) {
                                case 'A': {
                                    $startid = 103;
                                    $sequence[$key][0] = 'A';
                                    $code_data[] = $fnc_a[$tmpchr];
                                    break;
                                }
                                case 'C': {
                                    $startid = 105;
                                    $sequence[$key][0] = 'C';
                                    $code_data[] = $fnc_a[$tmpchr];
                                    break;
                                }
                            }
                            break;
                        } else {
                            $startid = 104;
                        }
                    } elseif ($sequence[($key - 1)][0] != 'B') {
                        if (($seq[2] == 1) && ($key > 0) && ($sequence[($key - 1)][0] == 'A') && (!isset($sequence[($key - 1)][3]))) {
                            // single character shift
                            $code_data[] = 98;
                            // mark shift
                            $sequence[$key][3] = true;
                        } elseif (!isset($sequence[($key - 1)][3])) {
                            $code_data[] = 100;
                        }
                    }
                    for ($i = 0; $i < $seq[2]; ++$i) {
                        $char = $seq[1]{$i};
                        $char_id = ord($char);
                        if (($char_id >= 241) AND ($char_id <= 244)) {
                            $code_data[] = $fnc_b[$char_id];
                        } else {
                            $code_data[] = strpos($keys_b, $char);
                        }
                    }
                    break;
                }
                case 'C': {
                    if ($key == 0) {
                        $startid = 105;
                    } elseif ($sequence[($key - 1)][0] != 'C') {
                        $code_data[] = 99;
                    }
                    for ($i = 0; $i < $seq[2]; $i+=2) {
                        $chrnum = $seq[1]{$i} . $seq[1]{$i + 1};
                        $code_data[] = intval($chrnum);
                    }
                    break;
                }
            }
        }
        // calculate check character
        $sum = $startid;
        foreach ($code_data as $key => $val) {
            $sum += ($val * ($key + 1));
        }
        // add check character
        $code_data[] = ($sum % 103);
        // add stop sequence
        $code_data[] = 106;
        $code_data[] = 107;
        // add start code at the beginning
        array_unshift($code_data, $startid);
        // build barcode array
        $bararray = ['code' => $code, 'maxw' => 0, 'maxh' => 1, 'bcode' => []];
        foreach ($code_data as $val) {
            $seq = $chr[$val];
            for ($j = 0; $j < 6; ++$j) {
                if (($j % 2) == 0) {
                    $t = true; // bar
                } else {
                    $t = false; // space
                }
                $w = $seq{$j};
                $bararray['bcode'][] = ['t' => $t, 'w' => $w, 'h' => 1, 'p' => 0];
                $bararray['maxw'] += $w;
            }
        }

        return $bararray;
    }

    /**
     * Split text code in A/B sequence for 128 code
     * @param $code (string) code to split.
     * @return array sequence
     * @protected
     */
    protected function get128ABsequence($code)
    {
        $len = strlen($code);
        $sequence = [];
        // get A sequences (if any)
        $numseq = [];

        preg_match_all('/([\0-\31])/', $code, $numseq, PREG_OFFSET_CAPTURE);

        if (isset($numseq[1]) && !empty($numseq[1])) {
            $end_offset = 0;
            foreach ($numseq[1] as $val) {
                $offset = $val[1];
                if ($offset > $end_offset) {
                    // B sequence
                    $sequence[] = ['B', substr($code, $end_offset, ($offset - $end_offset)), ($offset - $end_offset)];
                }
                // A sequence
                $slen = strlen($val[0]);
                $sequence[] = ['A', substr($code, $offset, $slen), $slen];
                $end_offset = $offset + $slen;
            }
            if ($end_offset < $len) {
                $sequence[] = ['B', substr($code, $end_offset), ($len - $end_offset)];
            }
        } else {
            // only B sequence
            $sequence[] = ['B', $code, $len];
        }

        return $sequence;
    }
}
