<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        //return parent::toArray($request);

        return [
         'id'      => (int) $this->id,
         'name'    => (string) $this->name,
         'slug'    => (string) $this->slug,
         'account_number' => (string) $this->account_number
        ];
    }
}
