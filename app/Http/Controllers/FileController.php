<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ProprtyType;
use App\Models\DocumentType;
use App\Models\Property;
use Auth;

class FileController extends Controller
{
    CONST PROPERTIES = 'properties';
    CONST PROPERTY = 'property';
    CONST USERS = 'users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $directory = null)
    {
       $directories = [
        self::PROPERTIES,  
        // self::PROPERTY,  
        // self::USERS  
       ];

       $files = [];
        
      if($directory == self::PROPERTIES) {
           
         $directories = $this->getDirectoies(self::PROPERTY);
         return view('files.files',compact('directories'));
      } 
      elseif(in_array($directory,$directories)) {
         $files = \Storage::disk('public')->files($directory);
      }
      
      return view('files.index',compact('directories','files')); 

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function propertyType(Request $request, $directory, $propertyType)
    {
         $directory = self::PROPERTY;
         $files = [];
         $directories = $this->getDirectoies($directory, true, $directory.'/'.$propertyType);

         return view('files.files',compact('directories','files'));
    
    }


    public function property(Request $request, $directory, $propertyType,$property)
    {
         $directory = self::PROPERTY;
         $files = [];
         $directories = $this->getDirectoies($directory, true, $directory.'/'.$propertyType.'/'.$property);
    
         return view('files.files',compact('directories','files'));
    
    }

    public function docType(Request $request, $directory, $propertyType,$property,$docType)
    {
         $directory = self::PROPERTY;
         $directories = [];
         $files = $this->getDirectoies($directory, true, $directory.'/'.$propertyType.'/'.$property.'/'.$docType);

         return view('files.files',compact('directories','files'));
    
    }

    public function getDirectoies($dir, $rescurive = false, $dirname = null){

        $directories = \Storage::disk('doc_upload')->listContents($dir,$rescurive);
 
        if($dirname) {
            $directories = collect($directories)->where('dirname',$dirname)->all();
        }

        return $directories;
    }
    

}
