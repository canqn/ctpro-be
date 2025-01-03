<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCompany extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $fillable = [
        'user_id',
        'account_mst',
        'account_password',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
