<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentTypeCollection extends ResourceCollection
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
        'document_types' => $this->getCollection($this->collection),
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
             'id'      => (int) $data->id,
             'name'    => (string) $data->name,
             'slug'    => (string) $data->slug,
             'account_number' => (string) $data->account_number
            ];
        }); 

         return $collection;

        
    }
}
