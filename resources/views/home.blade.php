@extends('layouts.admin-app')

@section('title', 'Dashboard')

@section('content')

 <!-- Start Main View -->
                <!-- Dashboard Overview -->
<div class="row">

    <!-- Categories Overview -->
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-list-ul text-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Categories</p>
                            <p id="categories_count" class="card-title">0<p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <a href="/categories" class="text-muted"><i class="fa fa-eye"></i> View All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Trades Overview -->
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-wrench text-success"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Trades</p>
                            <p id="trades_count" class="card-title">0<p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <a href="/trades" class="text-muted"><i class="fa fa-eye"></i> View All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Subcontractors Overview -->
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-users text-danger"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Subcontractors</p>
                            <p id="subcontractors_count" class="card-title">0<p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <a href="/subcontractors" class="text-muted"><i class="fa fa-eye"></i> View All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Files Overview -->
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-building text-primary"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Projects</p>
                            <p id="projects_count" class="card-title">0<p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <a href="/projects" class="text-muted"><i class="fa fa-eye"></i> View All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Files Overview -->
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-folder text-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Files</p>
                            <p id="files_count" class="card-title">0<p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <a href="/file-manager" class="text-muted"><i class="fa fa-eye"></i> View All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Overview -->
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-address-card text-success"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Users</p>
                            <p id="users_count" class="card-title">0<p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <a href="/users" class="text-muted"><i class="fa fa-eye"></i> View All</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
