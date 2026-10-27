<?php

namespace App\Enums;

enum ComplaintCategory: string
{
    case Akademik = 'akademik';
    case Fasilitas = 'fasilitas';
    case Pelayanan = 'pelayanan';
    case Keuangan = 'keuangan';
    case Dosen = 'dosen';
    case Lainnya = 'lainnya';

    public function label(): string
    {
        return match ($this) {
            self::Akademik => 'Akademik',
            self::Fasilitas => 'Fasilitas Kampus',
            self::Pelayanan => 'Pelayanan Administrasi',
            self::Keuangan => 'Keuangan & Pembayaran',
            self::Dosen => 'Dosen & Pembelajaran',
            self::Lainnya => 'Lainnya',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Akademik => 'academic-cap',
            self::Fasilitas => 'building-office-2',
            self::Pelayanan => 'user-group',
            self::Keuangan => 'banknotes',
            self::Dosen => 'presentation-chart-bar',
            self::Lainnya => 'ellipsis-horizontal-circle',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Akademik => 'Nilai, jadwal, KRS, dan layanan akademik',
            self::Fasilitas => 'Gedung, ruang kelas, laboratorium, dan sarana kampus',
            self::Pelayanan => 'Layanan administrasi dan staf kampus',
            self::Keuangan => 'Pembayaran, tagihan, dan beasiswa',
            self::Dosen => 'Proses belajar mengajar dan dosen',
            self::Lainnya => 'Permasalahan lain yang belum tercakup',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $category) => [$category->value => $category->label()])
            ->all();
    }
}
