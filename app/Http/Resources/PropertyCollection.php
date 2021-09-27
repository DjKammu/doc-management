<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

        return [
        'properties' => $this->getCollection($this->collection),
        'pagination' => [
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage()
            ]
        ];

    }

    public function getCollection($collection){
         
        $collection->transform(function ($data) {
            return [
             'id'     => (int) $data->id,
             'name'    => (string) $data->property_name,
             'address' => (string) $data->property_address,
             'city'    => (string) $data->city,
             'state'   => (string) $data->state,
             'country' => (string) $data->country,
             'zipCode' => (string) $data->zip_code,
             'notes'   => (string) $data->notes,
             'propertyType ' => (string) $data->proprty_type->name,
             'imageUrl'   => (string) url(\Storage::url($data->photo))
            ];
        }); 

         return $collection;

        
    }
}
