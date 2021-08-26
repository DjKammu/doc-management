 <div class="tab-pane" id="documents" role="tabpanel" aria-expanded="true">
                           
    <div class="row mb-2">
        <div class="col-6">
            <h4 class="mt-0 text-left">Documents List </h4>
        </div>
        <div class="col-6 text-right">
            <button type="button" class="btn btn-danger mt-0"  onclick="return window.location.href='{{ route("properties.documents",['id' => request()->property ])  }}'">Add Document
            </button>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            
        </div>
        <div class="col-6 text-right">
            <select style="height: 26px;" onchange="return window.location.href = '?p='+this.value"> 
            <option value="">Select Documents Type</option>
            @foreach($documentTypes as $type)
               <option value="{{ $type->slug }}" {{ (@request()->p == $type->slug) ? 'selected' : ''}}> {{ $type->name }}</option>
            @endforeach
            </select>
            <input type="text" name="s" value="{{ @request()->s }}" id="inputSearch" >
            <button id="search">Search</button>
        </div>
    </div>
    <!-- Categories Table -->
    <div class="table-responsive">

      <table id="subcontractors-table" class="table card-table dataTable no-footer" role="grid" aria-describedby="subcontractors-table_info">
             <thead class="d-none">
                <tr role="row">
                   <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"></th>
                </tr>
             </thead>
             <tbody class="row">
               @foreach($documents as $document)
                <tr class="text-center col-lg-2 col-sm-3 odd" style="display: flex; flex-wrap: wrap;" role="row">
                   <td>
                        <span class="cross">
                          <form 
                            method="post" 
                            action="{{route('documents.destroy',$document->id)}}"> 
                             @csrf
                            {{ method_field('DELETE') }}

                            <button 
                              type="submit"
                              onclick="return confirm('Are you sure?')"
                              class="btn btn-neutral bg-transparent btn-icon" data-original-title="Delete Property Type" title="Delete Property Type"><i class="fa fa-trash text-danger"></i> </button>
                          </form> 
                        </span>
                         <div class="card card-table-item" style="width: 100%; height: 100%;">
                            <div class="card-body pb-0">
                               <div class="author mt-1">
                              
                                 <a  href="{{ ($document->file) ? $document->file : route('properties.documents.show', ['id' => request()->property, 'document' => $document->id ]) }}" {{ ($document->file) ? 'target="_blank"' : '' }} >
                                  <img class="avatar border-gray" src="{{ asset('img/pdf.png') }}">  
                                   </a>
                                  <a href="{{ request()->property }}/documents/{{ $document->id }}">                     
                                  <h6 class="title mb-0">{{ @$document->name }}</h6>
                                   </a>
                                   <span class="doc-type"> 
                                    {{  @$document->document_type->name }}</span>
                                    <span class="doc_type_m">{{ (!$document->file) ? 'Multiple' : '' }}</span>
                                    
                               </div>
                            </div>
                         </div>
                     
                   </td>
                </tr>
               
               @endforeach
            
             </tbody>
          </table>
    </div>
    {!! $documents->render() !!}
</div>

@section('pagescript')

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

span.doc-type{
 font-size: 12px;
 padding-top: 8px;
 display: block;
}

span.doc_type_m{
 font-size: 10px;
 padding-top: 3px;
 display: block;
}

</style>
@endsection