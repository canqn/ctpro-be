<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_subscription_id',
        'driver_key',
        'log_date',
        'action',
    ];

    // Thiết lập mối quan hệ với bảng UserSubscription
    public function userSubscription()
    {
        return $this->belongsTo(UserSubscription::class);
    }
}
