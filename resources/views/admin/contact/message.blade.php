@extends('admin.layouts.master')

@section('title')
    Message List
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-12">
                    <!-- DATA TABLE -->


                    @if (session('deleteSuccess'))
                        <div class="col-5 offset-7">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h3 class="text-secondary">Total Message - {{ count($data) }}</h3>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $a)
                                    <tr class="tr-shadow">
                                        <td>{{ $a->id }}</td>
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->email }}</td>
                                        <td>{{ Str::words($a->message, 8, '...') }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('contact#viewMessage', $a->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="view">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('contact#deleteMessage', $a->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
