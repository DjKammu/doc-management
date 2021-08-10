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
            <option>Select Documents Type</option>
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
                <tr class="text-center col-lg-4 col-sm-6 odd" style="display: flex; flex-wrap: wrap;" role="row">
                   <td>
                      <a style="text-decoration: none; position: relative;" href="properties/{{ @$property->id }}">
                        <span class="cross"> 
                         <!-- <form 
                            method="post" 
                            action="{{route('properties.destroy',@$property->id)}}"> 
                             @csrf
                            {{ method_field('DELETE') }}

                            <button 
                              type="submit"
                              onclick="return confirm('Are you sure?')"
                              class="btn btn-neutral bg-transparent btn-icon" data-original-title="Delete Property Type" title="Delete Property Type"><i class="fa fa-trash text-danger"></i> </button>
                          </form> -->
                        </span>
                         <div class="card card-user card-table-item" style="width: 100%; height: 100%;">
                            <div class="card-body pb-0">
                               <div class="author mt-1">
                                  <img class="avatar border-gray" src="{{ asset('img/pdf.png') }}">                      
                                  <h5 class="title mb-0">{{ @$document->name }}</h5>
                               </div>
                            </div>
                         </div>
                      </a>
                   </td>
                </tr>
               
               @endforeach
            
             </tbody>
          </table>
    </div>
    {!! $documents->render() !!}
</div>
