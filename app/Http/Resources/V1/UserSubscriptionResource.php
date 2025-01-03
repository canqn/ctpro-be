<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'subscription' => [
                'id' => $this->subscription->id,
                'name' => $this->subscription->subscription_name,
                'price' => $this->subscription->price,
                'duration_days' => $this->subscription->duration_days,
            ],
            'purchase_date' => $this->purchase_date->toDateString(),
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'driver_key' => $this->driver_key,
            'is_active' => $this->is_active,
        ];
    }
}
