<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'group' => [
                'id' => $this->group->id,
                'name' => $this->group->group_name,
            ],
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'alternate_number' => $this->alternate_number,
            'email' => $this->email,
            'company' => $this->company,
            'address' => $this->address,
            'notes' => $this->notes,
            'favorite' => $this->favorite,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
