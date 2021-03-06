@extends('layouts.admin-app')

@section('title', 'Vendors')

@section('content')
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
                        <h4 class="mt-0 text-left">Vendors List</h4>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn-danger mt-0"  onclick="return window.location.href='{{ route("vendors.create")}}'">Add Vendor
                        </button>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                       <select style="height: 26px;" onchange="return window.location.href = '?property='+this.value"> 
                      <option>Select Property </option>
                      @foreach($properties as $property)
                         <option value="{{ $property->id }}" {{ (@request()->property == $property->id) ? 'selected' : ''}}> {{ $property->property_name }}</option>
                      @endforeach
                      </select>
                    </div>
                    <div class="col-6 text-right">
                       <label>Per Page </label>
                      <select style="height: 26px;" name="per_page"  onchange="selectPerpage(this.value)"> 
                        <option value="">Per Page</option>
                        <option value="25" {{ (request()->per_page == 25) ? 'selected' : ''}}>25</option>
                        <option value="50" {{ (request()->per_page == 50) ? 'selected' : ''}}>50</option>
                        <option value="100" {{ (request()->per_page == 100) ? 'selected' : ''}}> 100</option>
                        <option value="150" {{ (request()->per_page == 150) ? 'selected' : ''}}>150</option>
                        </select>
                    </div>
                </div>
                <!-- Categories Table -->
                <div class="table-responsive">
                    <table id="project-types-table" class="table table-hover text-center">
                        <thead>
                        <tr class="text-danger">
                            <th>Vendor</th>
                            <th>Property</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($vendors as $tenant)
                         <tr>
                           <td>{{ $tenant->name }}</td>
                           <td>{{ @$tenant->property->property_name }}</td>
                           <td>        
                            <button onclick="return window.location.href='vendors/{{$tenant->id}}'" rel="tooltip" class="btn btn-neutral bg-transparent btn-icon" data-original-title="Edit Bussiness Type" title="Edit Bussiness Type">            <i class="fa fa-edit text-success"></i>        </button> 
                          </td>
                          <td>
                             <form 
                              method="post" 
                              action="{{route('vendors.destroy',$tenant->id)}}"> 
                               @csrf
                              {{ method_field('DELETE') }}

                              <button 
                                type="submit"
                                onclick="return confirm('Are you sure?')"
                                class="btn btn-neutral bg-transparent btn-icon" data-original-title="Delete Bussiness Type" title="Delete Bussiness Type"><i class="fa fa-trash text-danger"></i> </button>
                            </form>
                           </td>
                         </tr> 
                         @endforeach
                        <!-- Project Types Go Here -->
                        </tbody>
                    </table>
                </div>
                 {!! $vendors->render() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('pagescript')

<script type="text/javascript">
function selectPerpage(perPage){
   var fullUrl = window.location.href;
   let isPerpage = '{{ Request::input("per_page")}}';

   if(!isPerpage){
     window.location.href = fullUrl+(fullUrl.includes('?')?'&':'?')+'per_page='+perPage;
   }
   else if(isPerpage != perPage){
     window.location.href = fullUrl.replace(isPerpage, perPage)
   }
} 
</script>
@endsection