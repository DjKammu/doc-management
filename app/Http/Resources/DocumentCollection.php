<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
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
        'documents' => $this->getCollection($this->collection),
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
             'id'       => (int) $data->id,
             'name'     => (string) ($data->name) ? $data->name 
                          :@$data->document->document_type()->first()->name,
             'tenant'  => (string) @$data->document->tenant()->first()->name,
             'fileName' => (string) $data->name,
             'year'     => (string) $data->year,
             'month'    => (string) $data->month,
             'date'     => (string) $data->year.'-'.sprintf("%02d", $data->month)
                         .'-'.sprintf("%02d", $data->date),
             'docUrl'  => (string) $data->file
            ];
        }); 

         return $collection;

        
    }
}
