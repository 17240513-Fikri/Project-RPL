<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;

class LetterRequest extends Model
{
    use HasAttributeAliases;

    protected $table = 'pengajuan_surat';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';

    protected array $attributeAliases = [
        'letter_type_id' => 'jenis_surat_id',
        'resident_id' => 'warga_id',
        'requested_by' => 'diajukan_oleh',
        'processed_by' => 'diproses_oleh',
        'request_number' => 'nomor_surat',
        'purpose' => 'keperluan',
        'additional_data' => 'data_tambahan',
        'notes' => 'catatan',
        'rejection_reason' => 'alasan_ditolak',
        'approved_at' => 'disetujui_pada',
        'completed_at' => 'selesai_pada',
    ];

    protected $fillable = [
        'letter_type_id',
        'jenis_surat_id',
        'resident_id',
        'warga_id',
        'requested_by',
        'diajukan_oleh',
        'processed_by',
        'diproses_oleh',
        'request_number',
        'nomor_surat',
        'purpose',
        'keperluan',
        'additional_data',
        'data_tambahan',
        'status',
        'notes',
        'catatan',
        'rejection_reason',
        'alasan_ditolak',
        'approved_at',
        'disetujui_pada',
        'completed_at',
        'selesai_pada',
    ];

    protected $casts = [
        'data_tambahan' => 'array',
        'disetujui_pada' => 'datetime',
        'selesai_pada' => 'datetime',
    ];

    public function type()
    {
        return $this->belongsTo(LetterType::class, 'jenis_surat_id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'warga_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'diajukan_oleh');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
