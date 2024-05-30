<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perumahan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perumahan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode',
        'pengembang_id',
        'nama',
        'alamat',
        'keterangan',
        'is_verified',
    ];

    public function pengembang()
    {
        return $this->belongsTo(Pengembang::class, 'pengembang_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(PerumahanImage::class, 'perumahan_id', 'id');
    }

    public function kriteriaPerumahan()
    {
        return $this->hasMany(KriteriaPerumahan::class, 'perumahan_id', 'id');
    }
}
