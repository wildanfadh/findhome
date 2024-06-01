<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferensi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preferensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'kriteria_id',
        'kriteria_kode',
        // 'sub_kriteria_id',
        'bobot'
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
