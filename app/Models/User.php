<?php

namespace App\Models;

use App\Models\Concerns\HasAttributeAliases;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasAttributeAliases, HasFactory, Notifiable;

    protected $table = 'pengguna';

    public const CREATED_AT = 'dibuat_pada';
    public const UPDATED_AT = 'diperbarui_pada';

    protected array $attributeAliases = [
        'resident_id' => 'warga_id',
        'name' => 'nama',
        'password' => 'kata_sandi',
        'role' => 'peran',
        'remember_token' => 'token_ingat',
        'email_verified_at' => 'email_terverifikasi_pada',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'resident_id',
        'warga_id',
        'name',
        'nama',
        'email',
        'password',
        'kata_sandi',
        'role',
        'peran',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'kata_sandi',
        'token_ingat',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_terverifikasi_pada' => 'datetime',
        'kata_sandi' => 'hashed',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'warga_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function getRememberTokenName()
    {
        return 'token_ingat';
    }
}
