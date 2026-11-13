<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;

class CommunityProfile extends Model
{
    use HasAttributeAliases;

    protected $table = 'profil_wilayah';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';

    protected array $attributeAliases = [
        'name' => 'nama',
        'address' => 'alamat',
        'city' => 'kota',
        'province' => 'provinsi',
        'postal_code' => 'kode_pos',
        'phone' => 'telepon',
        'chairman_name' => 'nama_ketua',
        'vice_chairman_name' => 'nama_wakil_ketua',
        'secretary_name' => 'nama_sekretaris',
        'treasurer_name' => 'nama_bendahara',
        'vision' => 'visi',
        'mission' => 'misi',
    ];

    protected $fillable = [
        'name',
        'nama',
        'rt',
        'rw',
        'address',
        'alamat',
        'kelurahan',
        'kecamatan',
        'city',
        'kota',
        'province',
        'provinsi',
        'postal_code',
        'kode_pos',
        'phone',
        'telepon',
        'email',
        'chairman_name',
        'nama_ketua',
        'vice_chairman_name',
        'nama_wakil_ketua',
        'secretary_name',
        'nama_sekretaris',
        'treasurer_name',
        'nama_bendahara',
        'vision',
        'visi',
        'mission',
        'misi',
    ];

    protected $casts = [
        'misi' => 'array',
    ];
}
