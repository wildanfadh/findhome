<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembang extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengembang';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'alamat',
        'is_verified',
    ];

    public function akun()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function file()
    {
        return $this->hasOne(PengembangSertifikat::class, 'pengembang_id', 'id');
    }

    public function perumahans()
    {
        return $this->hasMany(Perumahan::class, 'pengembang_id', 'id');
    }
}
