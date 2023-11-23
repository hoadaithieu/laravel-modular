<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->ID,
            'first_name' => $this->FIRST_NAME,
            'last_name' => $this->LAST_NAME,
            'email' => $this->EMAIL,
            'phone' => $this->PHONE,
            'companies' => CompanyResource::collection($this->whenLoaded('companies')),
        ];

        //return parent::toArray($request);
    }
}
