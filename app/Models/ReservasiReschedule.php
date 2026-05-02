<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservasiReschedule extends Model
{
    protected $table = 'reservasi_reschedule';
    protected $primaryKey = 'id_reservasi_reschedule';
    public $timestamps = false;

    protected $fillable = [
        'id_reservasi',
        'usulan_tanggal_reschedule',
        'usulan_jam_reschedule',
        'catatan_dokter',
        'status_tanggapan_pasien',
    ];

    protected function casts(): array
    {
        return [
            'usulan_tanggal_reschedule' => 'date',
        ];
    }
}
