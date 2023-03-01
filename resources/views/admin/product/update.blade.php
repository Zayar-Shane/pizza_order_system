@extends('admin.layouts.master')

@section('title')
    Edit Product
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
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
                                <h3 class="text-center title-2">Update Product</h3>
                            </div>
                            <hr>

                            <form action="{{ route('product#update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-5">
                                        <input type="hidden" value="{{ $pizza->id }}" name="pizzaId">
                                        <img src="{{ asset('storage/' . $pizza->image) }}" class="img-thumbnail">
                                        <input type="file" name="pizzaImage"
                                            class="form-control @error('pizzaImage')
                                            is-invalid
                                        @enderror">
                                        @error('pizzaImage')
                                            <div class="invlid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-dark text-white col-12"><i
                                                    class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="pizzaName" type="text"
                                                class="form-control @error('pizzaName')
                                                is-invalid
                                            @enderror"
                                                value="{{ old('pizzaName', $pizza->name) }}" aria-required="true"
                                                aria-invalid="false">
                                            @error('pizzaName')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea name="pizzaDescription" id="" cols="30" rows="10"
                                                class="form-control @error('pizzaDescription')
                                                is-invalid
                                            @enderror">{{ old('pizzaDescription', $pizza->description) }}</textarea>
                                            @error('pizzaDescription')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Category</label>
                                            <select name="pizzaCategory"
                                                class="form-select @error('pizzaCategory')
                                                is-invalid
                                            @enderror">
                                                <option value="">Select Product Category...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if ($category->id == $pizza->category_id) selected @endif>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('pizzaCategory')
                                                <div class="invalid-feedback">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="pizzaPrice" type="number"
                                                class="form-control @error('pizzaPrice')
                                                is-invalid
                                            @enderror"
                                                value="{{ old('pizzaPrice', $pizza->price) }}" aria-required="true"
                                                aria-invalid="false">
                                            @error('pizzaPrice')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-pament" name="waitingTime" type="number"
                                                class="form-control @error('waitingTime')
                                                is-invalid
                                            @enderror"
                                                value="{{ old('waitingTime', $pizza->waiting_time) }}" aria-required="true"
                                                aria-invalid="false">
                                            @error('waitingTime')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">View Count</label>
                                            <input id="cc-pament" name="" type="number" class="form-control"
                                                value="{{ $pizza->waiting_time }}" aria-required="true"
                                                aria-invalid="false" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Created at</label>
                                            <input id="cc-pament" name="" type="" class="form-control"
                                                value="{{ $pizza->created_at->format('j F Y') }}" aria-required="true"
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
