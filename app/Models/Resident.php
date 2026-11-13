<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasAttributeAliases, SoftDeletes;

    protected $table = 'warga';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';
    public const DELETED_AT = 'dihapus_pada';

    protected array $attributeAliases = [
        'household_id' => 'kartu_keluarga_id',
        'name' => 'nama',
        'gender' => 'jenis_kelamin',
        'birth_place' => 'tempat_lahir',
        'birth_date' => 'tanggal_lahir',
        'religion' => 'agama',
        'education' => 'pendidikan',
        'occupation' => 'pekerjaan',
        'marital_status' => 'status_perkawinan',
        'family_status' => 'status_keluarga',
        'citizenship' => 'kewarganegaraan',
        'blood_type' => 'golongan_darah',
        'phone' => 'telepon',
        'address_on_id' => 'alamat_ktp',
        'resident_status' => 'status_warga',
        'arrival_date' => 'tanggal_masuk',
        'departure_date' => 'tanggal_keluar',
        'notes' => 'catatan',
    ];

    protected $fillable = [
        'household_id',
        'kartu_keluarga_id',
        'nik',
        'name',
        'nama',
        'gender',
        'jenis_kelamin',
        'birth_place',
        'tempat_lahir',
        'birth_date',
        'tanggal_lahir',
        'religion',
        'agama',
        'education',
        'pendidikan',
        'occupation',
        'pekerjaan',
        'marital_status',
        'status_perkawinan',
        'family_status',
        'status_keluarga',
        'citizenship',
        'kewarganegaraan',
        'blood_type',
        'golongan_darah',
        'phone',
        'telepon',
        'email',
        'address_on_id',
        'alamat_ktp',
        'resident_status',
        'status_warga',
        'arrival_date',
        'tanggal_masuk',
        'departure_date',
        'tanggal_keluar',
        'notes',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function household()
    {
        return $this->belongsTo(Household::class, 'kartu_keluarga_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'warga_id');
    }

    public function letterRequests()
    {
        return $this->hasMany(LetterRequest::class, 'warga_id');
    }
}
