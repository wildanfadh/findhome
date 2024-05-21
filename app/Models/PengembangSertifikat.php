<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembangSertifikat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengembang_sertifikat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pengembang_id',
        'path',
        'name',
        'original_name',
        'mime',
    ];

    public function akun()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
