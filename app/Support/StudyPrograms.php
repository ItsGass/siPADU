<?php

namespace App\Support;

final class StudyPrograms
{
    /**
     * Program studi yang tersedia di Universitas Pamulang Kampus Serang.
     *
     * @return array<int, string>
     */
    public static function all(): array
    {
        return [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknik Komputer',
            'Manajemen',
            'Akuntansi',
            'Perpajakan',
            'Ilmu Hukum',
            'Teknik Sipil',
            'Pendidikan Bahasa Inggris',
            'Sastra Inggris',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::all())
            ->mapWithKeys(fn (string $program) => [$program => $program])
            ->all();
    }
}
