<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'title' => $this->TITLE,
            'description' => $this->DESCRIPTION,
        ];

        //return parent::toArray($request);
    }
}
