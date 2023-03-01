@extends('user/layouts/master')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Profile</h3>
                            </div>
                            <hr>
                            @if (session('upateSuccess'))
                                <div class="col-6 offset-6">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('upateSuccess') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('profile#update', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-3 offset-1">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{ asset('images/default_user.png') }}"
                                                    class="img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{ asset('images/default_female.jpg') }}"
                                                    class="img-thumbnail shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                class="img-thumbnail shadow-sm">
                                        @endif
                                        <input type="file" name="image" class="form-control">

                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-dark text-white col-12"><i
                                                    class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                                        </div>
                                    </div>
                                    <div class="col-6 offset-1 ">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text"
                                                class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                                value="{{ old('name', Auth::user()->name) }}" aria-required="true"
                                                aria-invalid="false">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="email"
                                                class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                                value="{{ old('email', Auth::user()->email) }}" aria-required="true"
                                                aria-invalid="false">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="number"
                                                class="form-control @error('phone')
                                            is-invalid
                                        @enderror"
                                                value="{{ old('phone', Auth::user()->phone) }}" aria-required="true"
                                                aria-invalid="false">
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Gender</label>
                                            <select name="gender"
                                                class="form-control @error('gender')
                                            is-invalid
                                        @enderror">
                                                <option value="null">Choose gender... </option>
                                                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea name="address" id="" cols="10" rows="3"
                                                class="form-control @error('address')
                                            is-invalid
                                        @enderror">{{ old('address', Auth::user()->address) }}</textarea>
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <input id="cc-pament" name="role" type="text" class="form-control"
                                                value="{{ old('role', Auth::user()->role) }}" aria-required="true"
                                                aria-invalid="false" disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
