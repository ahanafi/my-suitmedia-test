<?php

interface KlasemenAbs
{
    public function catatPermainan(string $klubKandang, string $klubTandang, string $skor): void;

    public function cetakKlasemen(): array;

    public function ambilPeringkat(int $nomorPeringkat): string;
}

/**
 * Klasemen implement KlasemenAbs
 */
class Klasemen implements KlasemenAbs {
    private array $arrayKlub;

    public function __construct(array $klub)
    {
        $this->arrayKlub = $klub;

        $this->setPoinKlub();
    }

    /**
     * @return void
     * @note Mengatur klub dan masing-masing nilai poin awal
     */
    private function setPoinKlub(): void
    {
        if (count($this->arrayKlub) === 0) {
            throw new \RuntimeException('Tidak ada klub yang terdaftar!');
            exit();
        }

        $newArrayKlub = [];
        foreach ($this->arrayKlub as $klub) {
            $newArrayKlub[] = [
                'tim' => $klub,
                'poin' => 0
            ];
        }

        $this->arrayKlub = $newArrayKlub;
    }

    /**
     * @param string $namaKlub
     * @return int|bool
     * @note Mendapatkan index suatu klub berdasarkan nama klubnya
     */
    private function getIndexKlub(string $namaKlub): int|bool
    {
        return array_search($namaKlub, array_column($this->arrayKlub, 'tim'), true);
    }

    /**
     * @return void
     * @note Mengatur peringkat klub dengan mengurutkan pada poin terbesar (DESC)
     */
    private function aturPeringkatKlub(): void
    {
        $currentArr = $this->arrayKlub;

        usort($currentArr, function ($a, $b) {
            return $b['poin'] <=> $a['poin'];
        });

        $this->arrayKlub = $currentArr;
    }

    /**
     * @param string $klubKandang
     * @param string $klubTandang
     * @param string $skor
     * @return void
     * @note Mencatat hasil permainan yang selesai berjalan
     */
    public function catatPermainan(string $klubKandang, string $klubTandang, string $skor): void
    {
        // get index klub
        $indexKlubKandang = $this->getIndexKlub($klubKandang);
        $indexKlubTandang = $this->getIndexKlub($klubTandang);

        // validate club
        if ($indexKlubKandang === false || $indexKlubTandang === false) {
            throw new \RuntimeException('Klub tandang atau klub kandang tidak terdaftar!');
            exit();
        }

        // validate skor
        if (!str_contains($skor, ':')) {
            throw new \RuntimeException('Penulisan skor tidak valid! Contoh: 2:1');
            exit();
        }

        $skors = explode(':', $skor);
        $skorKlubKandang = $skors[0];
        $skorKlubTandang = $skors[1];

        if ((int) $skorKlubKandang === (int) $skorKlubTandang) {
            $this->arrayKlub[$indexKlubKandang]['poin'] += 1;
            $this->arrayKlub[$indexKlubTandang]['poin'] += 1;
        } else if ((int) $skorKlubKandang > (int) $skorKlubTandang) {
            $this->arrayKlub[$indexKlubKandang]['poin'] += 3;
        } else if ((int) $skorKlubKandang < (int) $skorKlubTandang) {
            $this->arrayKlub[$indexKlubTandang]['poin'] += 3;
        }

        $this->aturPeringkatKlub();
    }

    /**
     * @return array
     * @note Mencetak hasil klasemen berdasarkan nilai poin
     */
    public function cetakKlasemen(): array
    {
        $newArrayKlub = [];
        foreach ($this->arrayKlub as $klub) {
            $namaKlub = $klub['tim'];
            $poinKlub = $klub['poin'];
            $newArrayKlub[$namaKlub] = $poinKlub;
        }

        return $newArrayKlub;
    }

    /**
     * @param int $nomorPeringkat
     * @return string
     * @note Mengambil peringkat klub
     */
    public function ambilPeringkat(int $nomorPeringkat): string
    {
        return $this->arrayKlub[$nomorPeringkat - 1]['tim'];
    }
}

/**
 * Test Case
**/
$klasemen = new Klasemen(['Liverpool', 'Chelsea', 'Arsenal']);

$klasemen->catatPermainan('Arsenal', 'Liverpool', '2:1');
$klasemen->catatPermainan('Arsenal', 'Chelsea', '1:1');
$klasemen->catatPermainan('Chelsea', 'Arsenal', '0:3');
$klasemen->catatPermainan('Chelsea', 'Liverpool', '3:2');
$klasemen->catatPermainan('Liverpool', 'Arsenal', '2:2');
$klasemen->catatPermainan('Liverpool', 'Chelsea', '0:0');

// mengembalikan hasil ['Arsenal'=>8, 'Chelsea'=>5, 'Liverpool'=>2]
print_r($klasemen->cetakKlasemen());
// returns 'Chelsea'
echo $klasemen->ambilPeringkat(2) . PHP_EOL;