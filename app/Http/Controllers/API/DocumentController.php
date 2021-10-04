<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\DocumentFile;
use App\Models\ProprtyType;
use App\Models\Property;
use App\Models\Document;
use App\Models\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentCollection;


class DocumentController extends Controller
{
  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $docsIds  = [];

         $documents = DocumentFile::query();

         if(request()->filled('property_type')){
          $property_type = ProprtyType::where('slug',request()->property_type)
                           ->with('properties')->first(); 

          $properties = @$property_type->properties->pluck('id');

          $docsIds = Document::propertyIds($properties)->pluck('id');

         }

         if(request()->filled('property')){
          $property = Property::where('id',request()->property)
                           ->with('documents')->first(); 

          $pDocsIds = @$property->documents->pluck('id');

          if($docsIds){

            $docsIds = $docsIds->filter(function ($value, $key) use ($pDocsIds){
                return $pDocsIds->contains($value);
            });            

          }
          else{
             $docsIds = $pDocsIds->merge($docsIds); 
          }
         }

         if(request()->filled('document_type')){
          $document_type = DocumentType::where('slug',request()->document_type)
                           ->with('documents')->first(); 
          
          $dDocsIds = $document_type->documents->pluck('id');

          if($docsIds){

            $docsIds = $docsIds->filter(function ($value, $key) use ($dDocsIds){
                return $dDocsIds->contains($value);
            });            

          }
          else{
             $docsIds = $dDocsIds->merge($docsIds); 
          }

         }
          
         $docsIds =    ($docsIds) ? @$docsIds->unique() : []; 

         if($docsIds){
            $documents->docIds($docsIds);
         }

         if(request()->filled('tenant')){

           $documents = $documents->whereHas('document', function ($query) {
                  $query->where('tenant_id', request()->tenant);
           });
         } 

         if(request()->filled('year')){
           $documents = $documents->where('year',request()->year);
         }

        if(request()->filled('month')){
           $documents =  $documents->where('month',request()->month);
         }
        
        if(request()->filled('date')){
           $documents =  $documents->where('date',request()->date);
         }

          if(request()->filled('s')){
            $searchTerm = request()->s;
            $documents->where('file', 'LIKE', "%{$searchTerm}%") 
            ->orWhere('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('date', 'LIKE', "%{$searchTerm}%")
            ->orWhere('month', 'LIKE', "%{$searchTerm}%")
            ->orWhere('year', 'LIKE', "%{$searchTerm}%");
         }  

        $perPage = request()->filled('per_page') ? request()->per_page : (new DocumentFile())->perPage;

      $documents = $documents->with('document')->paginate($perPage);

       $documents->filter(function($doc){
         
         $property = @$doc->document->property()->first();
        
        $property_slug = \Str::slug($property->property_name);

        $document_type = $doc->document->document_type()->pluck('slug')->first();

        $property_type_slug = @ProprtyType::find($property->proprty_type_id)->slug;

        $folderPath = Document::PROPERTY."/";

        $property_type_slug = ($property_type_slug) ? $property_type_slug : Document::ARCHIEVED;  
        $folderPath .= "$property_type_slug/$property_slug/$document_type/";

        $doc->file = url($folderPath.$doc->file);

         return $doc->file;
       
     });


      return response()->json([
                'status' => 200,
                'message' =>  'Success',
                'data' => new DocumentCollection($documents)
        ]);

      
    }



}
