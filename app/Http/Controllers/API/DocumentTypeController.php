<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProprtyType;
use App\Models\DocumentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentTypeCollection;
use App\Http\Resources\DocumentTypeResource;

class DocumentTypeController extends Controller
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

         $documentTypes = DocumentType::orderBy('account_number');

         $documentTypes = $documentTypes->paginate((new DocumentType())->perPage); 

         return response()->json([
                'status' => 200,
                'message' =>  'Success',
                'data' => new DocumentTypeCollection($documentTypes)
        ]);
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->except('_token');

        $validator = \Validator::make($request->all(),[
              'name' => 'required|unique:document_types',
              'account_number' => 'required|unique:document_types',
        ]);

        if ($validator->fails()) {
              return response()->json([
              'status' => 401,
              'message' =>  @$validator->errors()->first()
              ]);
        }
        
        $data['slug'] = \Str::slug($request->name);
            
        $documentType = DocumentType::create($data);

        return response()->json([
                'status' => 200,
                'message' =>  'Success',
                'data' => new DocumentTypeResource($documentType)
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $type = DocumentType::find($id);
         return;
         return view('document_types.edit',compact('type'));
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
    
        $data = $request->except('_token');

        $validator = \Validator::make($request->all(),[
              'name' => 'required|unique:document_types,name,'.$id,
              'account_number' => 'required|unique:document_types,account_number,'.$id,
        ]);

        if ($validator->fails()) {
              return response()->json([
              'status' => 401,
              'message' =>  @$validator->errors()->first()
              ]);
        }

        $data['slug'] = \Str::slug($request->name);

        $type = DocumentType::find($id);
       
        $type->update($data);

        return response()->json([
                'status' => 200,
                'message' =>  'Success',
                'data' => new DocumentTypeResource($type)
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $type = DocumentType::find($id);
         
         if (!$type) {
                  return response()->json([
                  'status' => 401,
                  'message' =>  'Document Type not exists'
                  ]);
         }
     
         $type->delete();
          
         return response()->json([
                'status' => 200,
                'message' =>  'Document Type Delete Successfully!',
        ]);
    }
}
