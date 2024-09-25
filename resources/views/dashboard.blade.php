@extends('layouts.master')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->


        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            @if (auth()->user()->role == 'Administration')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <a href="{{route('dynamic_form.create')}}" style="text-decoration: none">
                                Dynamic Form Create
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <a href="{{route('dynamic_form.index')}}" style="text-decoration: none">
                                Form List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
