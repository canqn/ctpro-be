<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceLogResource extends JsonResource
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
            'user_subscription_id' => $this->user_subscription_id,
            'driver_key' => $this->driver_key,
            'action' => $this->action,
            'log_date' => $this->log_date->toDateString(),
        ];
    }
}
