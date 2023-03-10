@extends('admin.layouts.master')

@section('title')
    Product List
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add Product
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-5 offset-7">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h5 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h5>
                        </div>
                        <div class="col-3 offset-1">
                            <div class="bg-light w-50 text-center shadow text-dark">
                                <i class="fa-solid fa-database fs-3"></i> <span
                                    class="fs-3 fw-bold">{{ $pizza->total() }}</span>
                            </div>
                        </div>
                        <div class="col-4 offset-1">
                            <form action="{{ route('product#listPage') }}" method="get">
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" value="{{ request('key') }}"
                                        placeholder="Search...">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (count($pizza) != 0)
                        <div class="table-responsive table-responsive-data2 mt-2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($pizza as $p)
                                        <tr class="tr-shadow">
                                            <td class="col-2"><img src="{{ asset('storage/' . $p->image) }}"
                                                    class="img-thumbnail"></td>
                                            <td>{{ $p->name }}</td>
                                            <td>{{ $p->price }}</td>
                                            <td>{{ $p->category_name }}</td>
                                            <td> <i class="zmdi zmdi-eye"> {{ $p->view_count }}</td>

                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('product#detail', $p->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="View">
                                                            <i class="zmdi zmdi-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#updatePage', $p->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#delete', $p->id) }}">
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
                    @else
                        <h4 class="text-center mt-5 text-danger">There is no product item.</h4>
                    @endif
                    <div class="mt-3">
                        {{ $pizza->links() }}
                        {{-- {{ $categories->appends(request()->query())->links() }} --}}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
