@extends('layouts.admin-app')

@section('title', 'Document')

@section('content')

@include('includes.back')

      <!-- Start Main View -->
  <div class="card p-2">
    <div class="row">
        <div class="col-md-12">
              <!-- Start Main View -->
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show">
                  <strong>Success!</strong> {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            @endif

             @if ($errors->any())
               <div class="alert alert-warning alert-dismissible fade show">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Error!</strong>  
                   {{implode(',',$errors->all() )}}
                </div>
             @endif

            <div class="card-body">
              <div class="row mb-2">
                    <div class="col-6">
                        <h4 class="mt-0 text-left">Edit Document</h4>
                    </div>
                </div>

               <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <form   method="post" 
                              action="{{ route('documents.update',[ 'document' => request()->document ]) }}"
                               enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                  @csrf

                                    <!-- Current Password -->
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">Name 
                                                </label>
                                                <input  name="name" value="{{ @$document->name }}" type="text" class="form-control" placeholder="Document Name" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">Document Type
                                                </label>
                                                <select class="form-control" name="document_type_id"> 
                                                  <option value=""> Select Document Type</option>
                                                  @foreach($documentsTypes as $type)
                                                   <option value="{{ $type->id }}" {{ 
                                                      (@$document->document_type_id == $type->id) ? 'selected=""' : ''}} >{{ $type->name}}
                                                   </option>
                                                  @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">
                                                  File Name
                                                </label>
                                                <input  name="dname[]" class="form-control"  
                                                type="text" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">File 
                                                </label>
                                                <input  name="file[]"  type="file" multiple="" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="add_button">
                                       <div class="col-lg-5 col-md-6 mx-auto">
                                       <a href="javascript:void(0);" class="add_button" title="Add field">+</a>
                                     </div>
                                    </div>
                             
                              <!-- Submit Button -->
                              <div class="col-12 text-center">
                                  <button type="submit" class="btn btn-danger">Update Document Type
                                  </button>
                              </div>

                                </form>
                            </div>
                             
                             <div class="row mb-2">
                                <div class="col-6">
                                    <h4 class="mt-0 text-left">Files</h4>
                                </div>
                            </div>

                              <div class="table-responsive">           
                                <table id="subcontractors-table" class="table card-table dataTable no-footer" role="grid" aria-describedby="subcontractors-table_info">
                                 <thead class="d-none">
                                    <tr role="row">
                                       <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"></th>
                                    </tr>
                                 </thead>
                                 <tbody class="row">
                                  @foreach($document->files as $file)
                                    <tr class="text-center col-lg-2 col-sm-3 odd" style="display: flex; flex-wrap: wrap;" role="row">
                                       <td>
                                            <span class="cross"> 
                                             <form 
                                                method="post" 
                                                action="{{route('documents.file.destroy',$file->id)}}?path={{$file->file}}"> 
                                                 @csrf
                                                {{ method_field('DELETE') }}

                                                <button 
                                                  type="submit"
                                                  onclick="return confirm('Are you sure?')"
                                                  class="btn btn-neutral bg-transparent btn-icon" data-original-title="Delete Property Type" title="Delete Property Type"><i class="fa fa-trash text-danger"></i> </button>
                                              </form>
                                            </span>
                                             <div class="card card-table-item" 
                                             style="width: 100%;">
                                                <div class="card-body pb-0">
                                                   <div class="author mt-1">
                                                    <a href="{{ url($file->file) }}" target="_blank">
                                                      <p> {{ @$file->name }} </p>
                                                      <img class="avatar border-gray" src="{{ asset('img/pdf.png') }}">
                                                      </a>                   
                                                   </div>
                                                </div>
                                             </div>
                                       </td>
                                    </tr>

                                    @endforeach
                                 </tbody>
                              </table>
                                </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('pagescript')

<script type="text/javascript">
$(document).ready(function(){
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('#add_button'); //Input field wrapper
    var fieldHTML = '<div style="position:relative;"> <a href="javascript:void(0);" class="remove_button">X</a>  <div class="row"> <div class="col-lg-5 col-md-6 mx-auto"> <div class="form-group"> <label class="text-dark" for="password"> File Name </label> <input name="dname[]" class="form-control" type="text" required> </div> </div> </div> <div class="row"> <div class="col-lg-5 col-md-6 mx-auto"> <div class="form-group"> <label class="text-dark" for="password">File </label> <input name="file[]" type="file" multiple="" required=""> </div> </div> </div></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).before(fieldHTML); //Add field html
    });
    
    //Once remove button is clicked
    $(document).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>

<style type="text/css">
  
span.cross{
    position: absolute;
    z-index: 10;
    right: 30px;
    display: none;
}
tr:hover span.cross{
  display: block;
}
button.btn.btn-neutral.bg-transparent.btn-icon{
  background-color: transparent !important;
}
td{
  width: 100%;
}

.add_button {
    height: 35px;
    width: 30px;
    border: 2px solid;
    text-align: center;
    font-size: 23px;
    display: block;
    font-weight: 900;
}.remove_button{
    position: absolute;
    right: 49px;
    font-weight: 900;
    height: 20px;
    width: 20px;
    border: 1px solid;
    text-align: center;
}
</style>
@endsection