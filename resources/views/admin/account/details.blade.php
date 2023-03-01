@extends('admin.layouts.master')

@section('title')
    Create Category
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-8 offset-4">
                @if (session('upateSuccess'))
                    <div class="col-6 offset-4">
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-check-double me-2"></i>{{ session('upateSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                {{-- <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div> --}}
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>
                            <hr>

                            <div class="row justify-content-around mb-4">
                                <div class="col-4">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{ asset('images/default_user.png') }}" class="img-thumbnail">
                                        @else
                                            <img src="{{ asset('images/default_female.jpg') }}" class="img-thumbnail">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" class="img-thumbnail">
                                    @endif
                                </div>
                                <div class="col-5 my-2">
                                    <h4 class="my-2"><i class="fa-solid fa-user-pen me-2"></i> {{ Auth::user()->name }}
                                    </h4>
                                    <h4 class="my-2"><i class="fa-solid fa-envelope me-2"></i> {{ Auth::user()->email }}
                                    </h4>
                                    <h4 class="my-2"><i class="fa-solid fa-phone me-2"></i> {{ Auth::user()->phone }}</h4>
                                    <h4 class="my-2"><i class="fa-solid fa-venus-mars me-2"></i>
                                        {{ Auth::user()->gender }}</h4>
                                    <h4 class="my-2"><i class="fa-solid fa-address-card me-2"></i>
                                        {{ Auth::user()->address }}
                                    </h4>
                                    <h4 class="my-2"><i class="fa-solid fa-user-clock me-2"></i>
                                        {{ Auth::user()->created_at->format('j F Y') }}
                                    </h4>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-3">
                                    <a href="{{ route('admin#edit') }}">
                                        <button class="btn btn-dark"><i
                                                class="fa-sharp fa-solid fa-pen-to-square me-2"></i>Edit
                                            Profile</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
