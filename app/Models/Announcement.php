<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasAttributeAliases, SoftDeletes;

    protected $table = 'pengumuman';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';
    public const DELETED_AT = 'dihapus_pada';

    protected array $attributeAliases = [
        'title' => 'judul',
        'category' => 'kategori',
        'content' => 'isi',
        'is_published' => 'terbit',
        'published_at' => 'terbit_pada',
        'created_by' => 'dibuat_oleh',
    ];

    protected $fillable = [
        'title',
        'judul',
        'slug',
        'category',
        'kategori',
        'content',
        'isi',
        'is_published',
        'terbit',
        'published_at',
        'terbit_pada',
        'created_by',
        'dibuat_oleh',
    ];

    protected $casts = [
        'terbit' => 'boolean',
        'terbit_pada' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
