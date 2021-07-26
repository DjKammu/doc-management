<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProprtyType;

class ProprtyTypeController extends Controller
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
         $propertyTypes = ProprtyType::paginate((new ProprtyType())->perPage); 
         return view('property_types.index',compact('propertyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name');

        $request->validate([
              'name' => 'required',
        ]);

        $data['slug'] = \Str::slug($request->name);
            
        ProprtyType::create($data);

        return redirect('property-types')->with('message', 'Proprty Type Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $type = ProprtyType::find($id);
         return view('property_types.edit',compact('type'));
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

        $data = $request->only('name');

        $request->validate([
              'name' => 'required',
        ]);

        $data['slug'] = \Str::slug($request->name);

         $type = ProprtyType::find($id);

         if(!$type){
            return redirect()->back();
         }
          
        $type->update($data);
          
        return redirect('property-types')->with('message', 'Proprty Type Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         ProprtyType::find($id)->delete();

        return redirect()->back()->with('message', 'Proprty Type Delete Successfully!');
    }
}
