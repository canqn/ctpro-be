<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadLimit extends Model
{
    use HasFactory;

    protected $table = 'download_limits';
    protected $fillable = [
        'user_id',
        'download_limit',
        'download_bought',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
