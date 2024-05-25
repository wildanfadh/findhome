<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerumahanImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perumahan_image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'perumahan_id',
        'path',
        'name',
        'original_name',
        'mime',
    ];

    public function perumahan()
    {
        return $this->belongsTo(Perumahan::class, 'id', 'perumahan_id');
    }
}
