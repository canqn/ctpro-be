<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $request->id,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'username' => $request->username,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'active' => $this->is_active,
            'role' => $this->role
        ];
    }
}
