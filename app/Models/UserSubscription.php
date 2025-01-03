<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'purchase_date',
        'start_date',
        'end_date',
        'driver_key',
        'is_active',
    ];

    // Thiết lập mối quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Thiết lập mối quan hệ với bảng Subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // Thiết lập mối quan hệ với bảng DeviceLog
    public function deviceLogs()
    {
        return $this->hasMany(DeviceLog::class);
    }
}
