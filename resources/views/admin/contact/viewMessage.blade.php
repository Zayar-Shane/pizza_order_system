@extends('admin.layouts.master')

@section('title')
    Update Category
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row justify-content-center mt-5">
                    <div class="col-13">
                        <a href="{{ route('contact#message') }}" class="text-decoration-none text-dark fs-5"><i
                                class="fa-solid fa-arrow-left-long"></i> back</a>
                        <div class="card p-5">
                            <div class="text-uppercase text-center fs-3">Message from user </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-3"><i class="fa fa-user me-1" aria-hidden="true"></i> Name</div>
                                <div class="col-8">{{ $message->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3"><i class="fa-solid fa-envelope me-1"></i> Email</div>
                                <div class="col-8">{{ $message->email }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3"><i class="fa-solid fa-comment-dots me-1"></i> Message</div>
                                <div class="col-8">{{ $message->message }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
