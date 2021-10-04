<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Property;
use App\Models\BussinessType;
use Gate;


class VendorController extends Controller
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
         
        $properties =  Property::all();

         $vendors = Vendor::with('property')->orderBy('name');


         if(request()->filled('property')){
            $property = request()->property;
            $tenants->whereHas('property', function($q) use ($property){
                $q->where('id', $property);
            });
         } 
         
         $perPage = request()->filled('per_page') ? request()->per_page : 
         (new Vendor())->perPage;
 
        $vendors = $vendors->paginate((new Vendor())->perPage); 
         
         return view('vendors.index',compact('vendors','properties'));
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

        $properties =  Property::all();

        return view('vendors.create',compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          if(Gate::denies('add')) {
               return abort('401');
        } 

        $data = $request->except('_token');

        $request->validate([
              'name' => 'required|unique:vendors',
              'property_id' => 'required|exists:properties,id',
        ]);
            
        Vendor::create($data);

        return redirect('vendors')->with('message', 'Vendor Created Successfully!');
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

         $vendor = Vendor::find($id);
         $properties =  Property::all();
         
         return view('vendors.edit',compact('vendor','properties'));
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

        $data = $request->except('_token');

        $request->validate([
              'name' => 'required|unique:vendors,name,'.$id,
              'property_id' => 'required|exists:properties,id'
        ]);


        $vendor = Vendor::find($id);
        
         if(!$vendor){
            return redirect()->back();
         }
          
         $vendor->update($data);

        return redirect('vendors')->with('message', 'Vendor Updated Successfully!');
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

         Vendor::find($id)->delete();

        return redirect()->back()->with('message', 'Vendor Delete Successfully!');
    }
}
