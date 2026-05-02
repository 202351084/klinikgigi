<?php

namespace App\Enums;

enum StatusReservasi: string
{
    case Menunggu = 'menunggu';
    case Terjadwal = 'terjadwal';
    case Ditolak = 'ditolak';
    case MenungguKonfirmasiPasien = 'menunggu_konfirmasi_pasien';
    case Dibatalkan = 'dibatalkan';
    case Selesai = 'selesai';

    public static function aktif(): array
    {
        return [
            self::Menunggu->value,
            self::Terjadwal->value,
            self::MenungguKonfirmasiPasien->value,
        ];
    }
}
