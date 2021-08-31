@extends('layouts.admin-app')

@section('title', 'Search Documents')

@section('content')
      <!-- Start Main View -->
  <div class="card p-2">
    <div class="row">
        <div class="col-md-12">

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <h4 class="mt-0 text-left">Search Document</h4>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                      <form>
                        <select style="height: 26px;" name="property_type"> 
                        <option value="">Select Property Type</option>
                        @foreach($propertyTypes as $type)
                           <option value="{{ $type->slug }}" {{ (@request()->property_type == $type->slug) ? 'selected' : ''}}> {{ $type->name }}</option>
                        @endforeach
                        </select>
                        <select style="height: 26px;" name="property"> 
                        <option value="">Select Property</option>
                        @foreach($properties as $property)
                           <option value="{{ $property->id }}" {{ (@request()->property == $property->id) ? 'selected' : ''}}> {{ $property->property_name }}</option>
                        @endforeach
                        </select>
                        <select style="height: 26px;" name="document_type"> 
                        <option value="">Select Document Type</option>
                        @foreach($documentTypes as $type)
                           <option value="{{ $type->slug }}" {{ (@request()->document_type == $type->slug) ? 'selected' : ''}}> {{ $type->name }}</option>
                        @endforeach
                        </select>
                        <select style="height: 26px;"  id="year" name="year"> 
                          <option value=""> Select Year</option>

                          @for($i = date('Y'); $i >= date('Y') - 50; $i--)
                            <option value="{{ $i }}" 
                            {{ (@request()->year == $i) ? 'selected' : ''}}
                            >{{ $i }}
                           </option>
                          @endfor

                        </select>
                        <select  style="height: 26px;" id="month" name="month"> 
                          <option value=""> Select Month</option>
                          @for ($i=1; $i<=12; $i++)
                            <option value="{{  $i }}"  {{ (@request()->month == $i ) ? 'selected' : ''}} >{{ date('F', mktime(0, 0, 0, $i, 1)) }}
                           </option>
                          @endfor
                        </select>
                        
                          @php
                          
                          $days = \Carbon\Carbon::now()->daysInMonth;

                          @endphp

                         <select style="height: 26px;" id="date" name="date"> 
                            <option value=""> Select Date</option>

                            @for ($i=1; $i<=$days; $i++)
                              <option value="{{ $i }}" {{ (@request()->date == $i) ? 'selected' : ''}}>{{ sprintf("%02d", $i) }}
                             </option>
                            @endfor

                          </select>

                        <input type="text" name="s" value="{{ @request()->s }}" id="inputSearch" >
                        <button type="submit" id="search">Search</button>
                        </form>
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
                                       
                                         <div class="card card-table-item" style="width: 100%; height: 100%;">
                                            <div class="card-body pb-0">
                                               <div class="author mt-1">
                                              
                                                 <a  href="{{ ($document->file) ? $document->file : route('properties.documents.show', ['id' => request()->property, 'document' => $document->id ]) }}" {{ ($document->file) ? 'target="_blank"' : '' }} >
                                                  <img class="avatar border-gray" src="{{ asset('img/pdf.png') }}">  
                                                   </a>
                                                  <!-- <a href="/properties/{{ \Str::slug($document->document->property->id)}}/documents/{{ $document->id }}">   -->                   
                                                  <h6 class="title mb-0">{{ @$document->name ?? @$document->document->name }}</h6>
                                                   <!-- </a> -->
                                                   <span class="doc-type"> 
                                                    {{  @$document->document->document_type->name }}</span>
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
        </div>
    </div>
</div>

@endsection

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