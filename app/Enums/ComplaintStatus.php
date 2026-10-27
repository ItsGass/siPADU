<?php

namespace App\Enums;

enum ComplaintStatus: string
{
    case Baru = 'baru';
    case Diverifikasi = 'diverifikasi';
    case Diproses = 'diproses';
    case Selesai = 'selesai';
    case Ditolak = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Baru => 'Baru',
            self::Diverifikasi => 'Diverifikasi',
            self::Diproses => 'Diproses',
            self::Selesai => 'Selesai',
            self::Ditolak => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Baru => 'blue',
            self::Diverifikasi => 'sky',
            self::Diproses => 'amber',
            self::Selesai => 'green',
            self::Ditolak => 'red',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Baru => 'inbox-arrow-down',
            self::Diverifikasi => 'check-badge',
            self::Diproses => 'arrow-path',
            self::Selesai => 'check-circle',
            self::Ditolak => 'x-circle',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Baru => 'Pengaduan telah diterima dan menunggu ditinjau oleh pengelola.',
            self::Diverifikasi => 'Pengaduan telah diverifikasi dan akan diteruskan ke unit terkait.',
            self::Diproses => 'Pengaduan sedang ditindaklanjuti oleh unit terkait.',
            self::Selesai => 'Pengaduan telah selesai ditindaklanjuti.',
            self::Ditolak => 'Pengaduan ditolak karena tidak memenuhi ketentuan.',
        };
    }

    public function isFinal(): bool
    {
        return in_array($this, [self::Selesai, self::Ditolak], true);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->value => $status->label()])
            ->all();
    }
}
