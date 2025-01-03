<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'is_active',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
