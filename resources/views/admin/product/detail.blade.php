@extends('admin.layouts.master')

@section('title')
    Pizza Details
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
                            <div class="m-1">
                                <i class="fa-solid fa-arrow-left text-decoratio-none text-dark fs-4"
                                    onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Product Info</h3>
                            </div>
                            <hr>

                            <div class="row justify-content-around mb-4">
                                <div class="col-4 offset-1">
                                    <img src="{{ asset('storage/' . $pizza->image) }}" class="img-thumbnail">
                                </div>
                                <div class="col-7">
                                    <div class="btn btn-danger text-white fs-4"> {{ $pizza->name }}
                                    </div>
                                    <div class="my-2">
                                        <span class="btn btn-dark"><i
                                                class="fa-solid fa-clone me-2"></i>{{ $pizza->category_name }}
                                        </span>
                                        <span class="btn btn-dark"><i
                                                class="fa-solid fa-money-bill-1 me-2"></i>{{ $pizza->price }}</span>
                                        <span class="btn btn-dark"><i class="fa-solid fa-clock me-2"></i>
                                            {{ $pizza->waiting_time }} mins</span>

                                    </div>

                                    <div class="my-2">
                                        <span class="btn btn-dark"><i class="fa-solid fa-calendar-day me-2"></i>
                                            {{ $pizza->created_at->format('j M Y') }}
                                        </span>
                                    </div>

                                    <div>
                                        <div class="text-dark fs-5"><i class="fa-solid fa-file-lines me-2"></i> Details
                                        </div>
                                        <div>{{ $pizza->description }}</div>
                                    </div>

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
