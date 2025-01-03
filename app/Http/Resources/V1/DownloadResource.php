<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DownloadResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $request->user_id,
            // /'account_id' => $this->account_id,
            'driver_id' => $request->driver_id,
            'driver_info' => $this->driver_info,
            'total_download' => $this->total_download,
            'download_date' => $this->download_date,
        ];
    }
}
