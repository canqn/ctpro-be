<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_name',
        'price',
        'duration_days',
        'description',
    ];

    // Thiết lập mối quan hệ với bảng UserSubscription
    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    // Thiết lập mối quan hệ với bảng SubscriptionFeature
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'subscription_features');
    }
}
