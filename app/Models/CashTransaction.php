<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasAttributeAliases;

    protected $table = 'transaksi_kas';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';

    protected array $attributeAliases = [
        'transaction_code' => 'kode_transaksi',
        'type' => 'jenis',
        'category' => 'kategori',
        'amount' => 'jumlah',
        'transaction_date' => 'tanggal_transaksi',
        'description' => 'keterangan',
        'payment_method' => 'metode_bayar',
        'reference' => 'referensi',
        'recorded_by' => 'dicatat_oleh',
    ];

    protected $fillable = [
        'transaction_code',
        'kode_transaksi',
        'type',
        'jenis',
        'category',
        'kategori',
        'amount',
        'jumlah',
        'transaction_date',
        'tanggal_transaksi',
        'description',
        'keterangan',
        'payment_method',
        'metode_bayar',
        'reference',
        'referensi',
        'recorded_by',
        'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function recorder()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
