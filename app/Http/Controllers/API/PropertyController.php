<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PropertyCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProprtyType;
use App\Models\Property;

class PropertyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
         $properties = Property::query();

         if(request()->filled('s')){
            $searchTerm = request()->s;
            $properties->where('property_name', 'LIKE', "%{$searchTerm}%") 
            ->orWhere('property_address', 'LIKE', "%{$searchTerm}%")
            ->orWhere('city', 'LIKE', "%{$searchTerm}%")
            ->orWhere('state', 'LIKE', "%{$searchTerm}%")
            ->orWhere('country', 'LIKE', "%{$searchTerm}%")
            ->orWhere('zip_code', 'LIKE', "%{$searchTerm}%")
            ->orWhere('notes', 'LIKE', "%{$searchTerm}%");
         }  

         if(request()->filled('p')){
            $p = request()->p;
            $properties->whereHas('proprty_type', function($q) use ($p){
                $q->where('slug', $p);
            });
         } 
         

         $perPage = request()->filled('per_page') ? request()->per_page : (new Property())->perPage;

         $properties = $properties->with('proprty_type')->paginate($perPage);


         // return new PropertyCollection($properties);

         return response()->json([
                'status' => 200,
                'message' =>  'Success',
                'data' => new PropertyCollection($properties)
        ]);
    }
}
