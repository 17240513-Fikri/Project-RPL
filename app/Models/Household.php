<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Household extends Model
{
    use HasAttributeAliases, SoftDeletes;

    protected $table = 'kartu_keluarga';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';
    public const DELETED_AT = 'dihapus_pada';

    protected array $attributeAliases = [
        'family_card_number' => 'nomor_kk',
        'head_resident_id' => 'kepala_warga_id',
        'address' => 'alamat',
        'block' => 'blok',
        'city' => 'kota',
        'province' => 'provinsi',
        'postal_code' => 'kode_pos',
        'home_status' => 'status_rumah',
        'economic_status' => 'status_ekonomi',
        'notes' => 'catatan',
    ];

    protected $fillable = [
        'family_card_number',
        'nomor_kk',
        'head_resident_id',
        'kepala_warga_id',
        'address',
        'alamat',
        'rt',
        'rw',
        'block',
        'blok',
        'kelurahan',
        'kecamatan',
        'city',
        'kota',
        'province',
        'provinsi',
        'postal_code',
        'kode_pos',
        'home_status',
        'status_rumah',
        'economic_status',
        'status_ekonomi',
        'notes',
        'catatan',
    ];

    public function residents()
    {
        return $this->hasMany(Resident::class, 'kartu_keluarga_id');
    }

    public function head()
    {
        return $this->belongsTo(Resident::class, 'kepala_warga_id');
    }
}
