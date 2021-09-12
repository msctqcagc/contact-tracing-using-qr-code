<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResidentResource extends JsonResource
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
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'birthday' => $this->getBirthday(),
            'contact_number' => $this->contact_number,
            'barangay' => ($this->barangay) ? $this->barangay->name : '',
            'address' => $this->address,
            'status' => $this->status,
            'documents' => DocumentResource::collection($this->documents),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }

    private function getBirthday() {
        $date = strtotime($this->date_of_birth);
        return date('F d, Y', $date);
    }
}
