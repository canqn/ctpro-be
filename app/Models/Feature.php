<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'feature_name',
        'description',
    ];

    // Thiết lập mối quan hệ với bảng SubscriptionFeature
    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'subscription_features');
    }
}
