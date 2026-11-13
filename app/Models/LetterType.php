<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasAttributeAliases;

    protected $table = 'jenis_surat';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';

    protected array $attributeAliases = [
        'name' => 'nama',
        'code' => 'kode',
        'description' => 'deskripsi',
        'template_body' => 'template_isi',
        'required_documents' => 'dokumen_wajib',
        'is_active' => 'aktif',
    ];

    protected $fillable = [
        'name',
        'nama',
        'code',
        'kode',
        'description',
        'deskripsi',
        'template_body',
        'template_isi',
        'required_documents',
        'dokumen_wajib',
        'is_active',
        'aktif',
    ];

    protected $casts = [
        'dokumen_wajib' => 'array',
        'aktif' => 'boolean',
    ];

    public function requests()
    {
        return $this->hasMany(LetterRequest::class, 'jenis_surat_id');
    }
}
