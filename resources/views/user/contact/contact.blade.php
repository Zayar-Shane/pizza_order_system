@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        @if (session('contactSuccess'))
            <div class="col-5 offset-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle" aria-hidden="true"></i> {{ session('contactSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="row px-xl-5">
            <div class="col-lg-6 offset-3 table-responsive mb-5">
                <div class="card p-5 shadow-sm">
                    <h3 class="text-center">Contact To Admin Team</h3>
                    <hr>
                    <form action="{{ route('contact#contactToAdmin') }}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingName"
                                name="name" placeholder="Name" value="{{ old('name') }}">
                            <label for="floatingName">Name</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="floatingInput" name="email" placeholder="name@example.com"
                                value="{{ old('email') }}">
                            <label for="floatingInput">Email address</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">

                            <textarea class="form-control @error('message') is-invalid @enderror" name="message" placeholder="Leave a comment here"
                                id="floatingTextarea2" style="height: 200px">{{ old('message') }}</textarea>
                            <label for="floatingTextarea2">Type Your Message</label>
                            @error('message')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div>
                            <button type="submit" class="btn btn-warning"> Submit </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
