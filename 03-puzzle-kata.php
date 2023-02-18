<?php
error_reporting(0);

const ATAS_KIRI = 'atas kiri';
const KANAN_BAWAH = 'kanan bawah';

const ATAS_KANAN = 'atas kanan';
const KIRI_BAWAH = 'kiri bawah';

class PuzzleKata
{
    private array $papan = [
        ['J', 'Y', 'B', 'Y', 'Q', 'V', 'W', 'G', 'B', 'Q', 'F', 'D', 'D', 'U', 'L', 'H', 'M'],
        ['D', 'G', 'O', 'C', 'G', 'V', 'N', 'K', 'Z', 'C', 'R', 'U', 'B', 'A', 'O', 'I', 'K'],
        ['U', 'G', 'E', 'U', 'H', 'E', 'W', 'J', 'W', 'T', 'O', 'Y', 'N', 'U', 'M', 'N', 'V'],
        ['N', 'H', 'U', 'R', 'D', 'B', 'R', 'J', 'I', 'V', 'U', 'I', 'T', 'P', 'G', 'H', 'W'],
        ['I', 'H', 'H', 'O', 'O', 'I', 'E', 'M', 'Z', 'W', 'T', 'J', 'M', 'D', 'T', 'S', 'V'],
        ['T', 'M', 'V', 'O', 'I', 'P', 'O', 'U', 'A', 'N', 'B', 'E', 'D', 'X', 'T', 'W', 'X'],
        ['E', 'Z', 'H', 'B', 'B', 'Q', 'A', 'U', 'E', 'N', 'W', 'C', 'W', 'C', 'B', 'O', 'N'],
        ['D', 'L', 'U', 'S', 'A', 'D', 'F', 'G', 'N', 'R', 'Y', 'Y', 'G', 'W', 'W', 'S', 'R'],
        ['K', 'H', 'Y', 'I', 'I', 'R', 'R', 'M', 'N', 'I', 'P', 'H', 'A', 'B', 'R', 'W', 'P'],
        ['I', 'T', 'Q', 'M', 'S', 'A', 'H', 'I', 'M', 'I', 'R', 'U', 'N', 'Z', 'Y', 'H', 'S'],
        ['N', 'E', 'T', 'H', 'E', 'R', 'L', 'A', 'N', 'D', 'S', 'H', 'U', 'N', 'K', 'E', 'Z'],
        ['G', 'F', 'K', 'L', 'N', 'L', 'A', 'G', 'U', 'T', 'R', 'O', 'P', 'B', 'I', 'U', 'E'],
        ['D', 'C', 'P', 'G', 'O', 'G', 'G', 'A', 'R', 'U', 'P', 'U', 'E', 'O', 'P', 'K', 'M'],
        ['O', 'J', 'B', 'T', 'D', 'N', 'T', 'A', 'X', 'O', 'B', 'X', 'Z', 'M', 'J', 'C', 'C'],
        ['M', 'J', 'F', 'P', 'N', 'S', 'L', 'L', 'X', 'B', 'V', 'C', 'Y', 'W', 'T', 'K', 'E'],
        ['R', 'X', 'I', 'S', 'I', 'I', 'Z', 'W', 'A', 'M', 'K', 'S', 'L', 'N', 'H', 'V', 'S'],
        ['A', 'O', 'J', 'O', 'A', 'E', 'G', 'T', 'X', 'M', 'C', 'Z', 'P', 'C', 'I', 'O', 'U']
    ];
    private string $kata;

    // HORIZONTAL
    private string $indexKananKeKiriHorizontalStr = "";
    private string $indexKiriKeKananHorizontalStr = "";

    // VERTIKAL
    private string $indexAtasKeBawahVertikalStr = "";
    private string $indexBawahKeAtasVertikalStr = "";

    // DIAGONAL
    private string $indexDiagonalAtasKiriKeKananBawahStr = "";
    private string $indexDiagonalAtasKananKeKiriBawahStr = "";

    // DIAGONAL REVERSE
    private string $indexDiagonalAtasKiriKeBawahKananReverseStr = "";
    private string $indexDiagonalAtasKananKeKiriBawahReverseStr = "";

    public function cariKata($kata): void
    {
        $this->kata = strtoupper(str_replace(" ", "", $kata));
        $arrKata = str_split($this->kata);

        /** HORIZONTAL **/
        // kiri -> kanan
        $cariHorizontalKiriKeKanan = $this->cariHorizontal($arrKata);

        // kanan -> kiri
        $cariHorizontalKananKeKiri = $this->cariHorizontal($arrKata, true);

        if ($cariHorizontalKiriKeKanan || $cariHorizontalKananKeKiri) {
            echo "Kata: " . strtoupper($kata) . " ditemukan secara HORIZONTAL." . PHP_EOL;

            if ($cariHorizontalKiriKeKanan) {
                $index = $this->indexKiriKeKananHorizontalStr;
            } else {
                $index = explode(", ", $this->indexKananKeKiriHorizontalStr);
                $index = array_filter($index, static function ($arr) {
                    return $arr !== '';
                });

                $index = array_reverse($index);
                $index = implode(", ", $index);
            }

            echo "INDEX: [" . $index . "]" . PHP_EOL . PHP_EOL;
        }

        /** VERTIKAL **/
        // atas -> bawah
        $cariVertikalAtasKeBawah = $this->cariVertikal($arrKata);

        // bawah ke atas
        $cariVertikalBawahKeAtas = $this->cariVertikal($arrKata, true);

        if ($cariVertikalAtasKeBawah || $cariVertikalBawahKeAtas) {
            echo "Kata: " . strtoupper($kata) . " ditemukan secara VERTIKAL." . PHP_EOL;

            if ($cariVertikalAtasKeBawah) {
                $index = $this->indexAtasKeBawahVertikalStr;
            } else {
                $index = $this->reverseResultIndex($this->indexBawahKeAtasVertikalStr);
            }

            echo "INDEX: [" . $index . "]" . PHP_EOL . PHP_EOL;
        }

        /** DIAGONAL 1 **/
        // atas kiri -> kanan bawah (menurun)
        $cariDiagonalAtasKiriKeKananBawah = $this->cariDiagonal($arrKata);

        // atas kiri -> kanan bawah (menurun - reverse)
        $cariDiagonalAtasKiriKeKananBawahReverse = $this->cariDiagonal($arrKata, ATAS_KIRI, KANAN_BAWAH, true);

        if ($cariDiagonalAtasKiriKeKananBawah || $cariDiagonalAtasKiriKeKananBawahReverse) {
            echo "Kata: " . strtoupper($kata) . " ditemukan secara DIAGONAL." . PHP_EOL;

            if ($cariDiagonalAtasKiriKeKananBawahReverse) {
                $index = $this->reverseResultIndex($this->indexDiagonalAtasKiriKeBawahKananReverseStr);
            } else {
                $index = $this->indexDiagonalAtasKiriKeKananBawahStr;
            }

            echo "INDEX: [" . $index . "]" . PHP_EOL . PHP_EOL;
        }

        /** DIAGONAL 2 **/
        // atas kanan -> bawah kiri (menurun)
        $cariDiagonalAtasKananKeKiriBawah = $this->cariDiagonal($arrKata, ATAS_KANAN, KIRI_BAWAH);

        // atas kanan -> bawah kiri (menurun - reverse)
        $cariDiagonalAtasKananKeKiriBawahReverse = $this->cariDiagonal($arrKata, ATAS_KANAN, KIRI_BAWAH, true);

        if ($cariDiagonalAtasKananKeKiriBawah || $cariDiagonalAtasKananKeKiriBawahReverse) {
            echo "Kata: " . strtoupper($kata) . " ditemukan secara DIAGONAL." . PHP_EOL;

            if ($cariDiagonalAtasKananKeKiriBawahReverse) {
                $index = $this->reverseResultIndex($this->indexDiagonalAtasKananKeKiriBawahReverseStr);
            } else {
                $index = $this->indexDiagonalAtasKananKeKiriBawahStr;
            }

            echo "INDEX: [" . $index . "]" . PHP_EOL . PHP_EOL;
        }

    }

    public function printGrid()
    {
        echo "-------------------------------------------------------" . PHP_EOL;
        for ($baris = 0; $baris < $this->getPanjangElemen(); $baris++) {
            echo "| ";
            for ($kolom = 0; $kolom < $this->getPanjangElemen($baris); $kolom++) {
                $huruf = $this->papan[$baris][$kolom];
                echo $huruf . "  ";
            }
            echo "|" . PHP_EOL;
        }

        echo "-------------------------------------------------------" . PHP_EOL;
    }

    public function cariHorizontal(array $kata, bool $isReverse = false): bool
    {
        if ($isReverse) {
            $kata = array_reverse($kata);
        }

        $x = 0;
        for ($i = 0; $i < $this->getPanjangElemen(); $i++) {
            for ($j = 0; $j < $this->getPanjangElemen($i); $j++) {

                if ($this->papan[$i][$j] === $kata[$x]) {
                    $x++;

                    if ($isReverse) {
                        $this->indexKananKeKiriHorizontalStr .= $this->getIndex($i, $j);
                    } else {
                        $this->indexKiriKeKananHorizontalStr .= $this->getIndex($i, $j);
                    }

                    if ($x === count($kata)) {
                        return true;
                    }
                } else {

                    if ($isReverse) {
                        $this->indexKananKeKiriHorizontalStr = "";
                    } else {
                        $this->indexKiriKeKananHorizontalStr = "";
                    }

                    $x = 0;
                }
            }
        }

        return false;
    }

    public function cariVertikal(array $kata, bool $isReverse = false): bool
    {
        if ($isReverse) {
            $kata = array_reverse($kata);
        }

        $x = 0;
        for ($i = 0; $i < $this->getPanjangElemen(); $i++) {
            for ($j = 0; $j < $this->getPanjangElemen($i); $j++) {

                if ($this->papan[$j][$i] === $kata[$x]) {
                    $x++;

                    if ($isReverse) {
                        $this->indexBawahKeAtasVertikalStr .= $this->getIndex($i, $j);
                    } else {
                        $this->indexAtasKeBawahVertikalStr .= $this->getIndex($i, $j);
                    }

                    if ($x === count($kata)) {
                        return true;
                    }
                } else {

                    if ($isReverse) {
                        $this->indexBawahKeAtasVertikalStr = "";
                    } else {
                        $this->indexAtasKeBawahVertikalStr = "";
                    }

                    $x = 0;
                }
            }
        }

        return false;
    }

    public function cariDiagonal(array $kata, string $mulai = ATAS_KIRI, string $akhir = KANAN_BAWAH, bool $isReverse = false)
    {
        $panjangElemen = $this->getPanjangElemen();
        $panjangKata = count($kata);

        if ($isReverse) {
            $kata = array_reverse($kata);
        }

        for ($i = 0; $i <= $panjangElemen - $panjangKata; $i++) {
            for ($j = 0; $j <= $panjangElemen - $panjangKata; $j++) {
                $found = true;
                for ($k = 0; $k < $panjangKata; $k++) {
                    $indexHuruf = ($mulai === ATAS_KIRI) ? $this->papan[$i + $k][$j + $k] : $this->papan[$i + $k][$j - $k];

                    if ($indexHuruf !== $kata[$k]) {
                        $found = false;
                        break;
                    }
                }

                if ($found) {
                    for ($k = 0; $k < $panjangKata; $k++) {
                        $kolom = ($i + $k);
                        $baris = ($mulai === ATAS_KIRI) ? ($j + $k) : ($j - $k);

                        if ($isReverse) {
                            $this->indexDiagonalAtasKiriKeBawahKananReverseStr .= $this->getIndex($kolom, $baris);
                        } else {
                            $this->indexDiagonalAtasKiriKeKananBawahStr .= $this->getIndex($kolom, $baris);
                        }
                    }
                    return true;
                }
            }
        }

        return false;
    }

    private function getIndex($indexKolom, $indexBaris)
    {
        $strAwal = "[";
        $index = $indexBaris . "," . $indexKolom;
        $strAkhir = "], ";
        return $strAwal . $index . $strAkhir;
    }

    private function getPanjangElemen($index = null): int
    {
        if ($index !== null) {
            return count($this->papan[$index]);
        }
        return count($this->papan);
    }

    private function reverseResultIndex($resultIndex): string
    {
        $index = explode(", ", $resultIndex);
        $index = array_filter($index, static function ($arr) {
            return $arr !== '';
        });

        $index = array_reverse($index);
        return implode(", ", $index);
    }
}

$puzzle = new PuzzleKata();
$puzzle->printGrid();


echo "PENCARIAN HORIZONTAL: " . PHP_EOL;
$puzzle->cariKata("netherlands");
$puzzle->cariKata("portugal");

echo "======================" . PHP_EOL . PHP_EOL;

echo "PENCARIAN VERTIKAL: " . PHP_EOL;
$puzzle->cariKata("united kingdom");
$puzzle->cariKata("indonesia");

echo "======================" . PHP_EOL . PHP_EOL;

$puzzle->cariKata('germany');
$puzzle->cariKata('argentina');