<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $fillable = [
        'user_id',
        'driver_name',
        'driver_size',
        'driver_type',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
