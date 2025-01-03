<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'feature_id',
    ];

    // Không cần thiết lập mối quan hệ ở model này vì đã thực hiện ở các model khác
}
