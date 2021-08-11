<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\ProprtyType;
use App\Models\Property;
use Gate;


class DocumentController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(Gate::denies('view')) {
               return abort('401');
         } 

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
         
         $propertyTypes = ProprtyType::all(); 

         $properties = $properties->paginate((new Property())->perPage);

         return view('properties.index',compact('properties','propertyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('add')) {
               return abort('401');
         } 

         $id = request()->id;

        $documentsTypes = DocumentType::all(); 

        return view('properties.documents-create',compact('documentsTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
          if(Gate::denies('add')) {
               return abort('401');
        } 

        $data = $request->except('_token');

        $request->validate([
              'name' => [
                    'required',
                     Rule::unique('documents')->where(function ($query) use($id) {
                        return $query->where('property_id', $id);
                    }),
                ],
              'document_type_id' => 'required|exists:document_types,id',
               'file' => 'nullable|sometimes|mimes:pdf,doc,docx,jpeg,jpg,png,csv,xlsx,xls'
        ]);

        $slug = \Str::slug($request->name);

        $data['file'] = '';    
       
         $property = Property::with('proprty_type')->find($id);

         if(!$property){
            return redirect()->back();
        }
        
        $document_type = DocumentType::find($request->document_type_id);

        $propperty_slug = \Str::slug($property->property_name);

        $proprty_type = @$property->proprty_type;

        $proprty_type_slug = @$proprty_type->slug; 

        $document_type_slug = $document_type->slug;

        $public_path = public_path().'/';

        $folderPath = 'files/'.$proprty_type_slug.'/'.$propperty_slug.'/'.$document_type_slug;

        \File::makeDirectory($public_path.$folderPath, $mode = 0777, true, true);

        if($request->hasFile('file')){
               $file = $request->file('file');
               $fileName = $document_type_slug.'-'.time().'.'. $file->getClientOriginalExtension();
               $request->file('file')->storeAs($folderPath, $fileName, 'doc_upload');
               $data['file']  = $fileName;
        }

        $data['slug'] = $slug;
        
        $property->documents()->create($data);

        return redirect(route('properties.show',['property' => $id]))->with('message', 'Document Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          if(Gate::denies('edit')) {
               return abort('401');
          } 
          
          dd($id);
         // $propertyTypes = ProprtyType::all();
         // $property = Property::find($id);
         // return view('properties.edit',compact('propertyTypes','property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('update')) {
               return abort('401');
        } 

        dd($id);

       $data = $request->except('_token');

       $request->validate([
              'property_name' => 'required',
              'proprty_type_id' => 'required|exists:proprty_types,id'
       ]);

        $slug = \Str::slug($request->property_name);
         
        $property = Property::find($id);
        $oldSlug = \Str::slug($property->property_name);

        if(!$property){
            return redirect()->back();
        }

        $data['photo'] = $property->photo;    


        if($request->hasFile('photo')){
               $photo = $request->file('photo');
               $photoName = $slug.'-'.time() . '.' . $photo->getClientOriginalExtension();
              
               $data['photo']  = $request->file('photo')->storeAs('properties', $photoName, 'public');
        }
        
        $oldProprty_type = ProprtyType::find($property->proprty_type_id);
        
        if(($oldProprty_type->id != $request->proprty_type_id) || 
            ($slug != $oldSlug)){
             
             if($slug  != $oldSlug){
                 $path = public_path().'/files/'.$oldProprty_type->slug.'/';
                 @rename($path.$oldSlug, $path.$slug); 
             }

             $proprty_type = ProprtyType::find($request->proprty_type_id);

             if($oldProprty_type->id != $request->proprty_type_id)
             { 
               $path = public_path().'/files/';
               $propertyDir  = ($slug  != $oldSlug) ? $slug : $oldSlug;
             // dd($path.$proprty_type->slug.'/'.$propertyDir);
                \File::copyDirectory($path.$oldProprty_type->slug.'/'.$propertyDir,
                 $path.$proprty_type->slug.'/'.$propertyDir); 
               \File::deleteDirectory($path.$oldProprty_type->slug.'/'.$propertyDir);
             }
        }

         $property->update($data);

        return redirect('properties')->with('message', 'Property Updated Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(Gate::denies('delete')) {
               return abort('401');
          } 
         
         dd($id);

         $property = Property::find($id);
         $proprty_slug = \Str::slug($property->property_name);
         $proprty_type = @ProprtyType::find($property->proprty_type_id);

         $proprty_type_slug = @$proprty_type->slug;

         $path = @public_path().'/files/'.$proprty_type_slug.'/'.$proprty_slug;

         @\File::deleteDirectory($path);

         $property->delete();

        return redirect()->back()->with('message', 'Proprty Delete Successfully!');
    }
}