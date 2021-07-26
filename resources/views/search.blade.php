@extends('layouts.app')

@include('layouts.nav')

@section('content')

     <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="searchInputBox">
                    <input type="text" class="form-control search"  value="{{ @$search }}" placeholder="Search ">
                    <span><i class="fa fa-search"></i></span>
                </div>
                <nav class="mt-5">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Rechnung</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Lieferschein</button>
                    </div>
                </nav>
                <div class="tab-content mt-4 text-center" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                       @foreach(@$beleges as $belege)
                        <div class="menz-pdf-box">
                          <div class="menz-pdf">
                            <i class="far fa-file-pdf"></i>
                          </div>
                          <div class="menz-card-body">
                            <a class="menz-view" href="#">View rechnung</a>
                            <p> {{ \Carbon\Carbon::parse($belege->Dateidatum)->format('d F, Y') }}</p>
                          </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        @foreach(@$rechnung as $belege)
                        <div class="menz-pdf-box">
                          <div class="menz-pdf">
                            <i class="far fa-file-pdf"></i>
                          </div>
                          <div class="menz-card-body">
                            <a class="menz-view" href="#">View rechnung</a>
                            <p> {{ \Carbon\Carbon::parse($belege->Dateidatum)->format('d F, Y') }}</p>
                          </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                       @foreach(@$lieferschein as $belege)
                      <div class="menz-pdf-box">
                        <div class="menz-pdf">
                          <i class="far fa-file-pdf"></i>
                        </div>
                        <div class="menz-card-body">
                          <a class="menz-view" href="#">View rechnung</a>
                          <p> {{ \Carbon\Carbon::parse($belege->Dateidatum)->format('d F, Y') }}</p>
                        </div>
                      </div>
                      @endforeach
                    </div>
                </div>
            </div>

              {!! $beleges->render() !!}

        </div>
    </div>
@endsection
