<?php

namespace App\Http\Resources;

use App\Models\Resident;
use Illuminate\Http\Resources\Json\JsonResource;

class ScannedResidentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'resident' => new ResidentResource($this->resident),
            'scanner' => new ScannerResource($this->scanner),
            'is_active_case' => $this->is_active_case,
            'created_at' => $this->created_at->format("Y-m-d H:i:s"),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
