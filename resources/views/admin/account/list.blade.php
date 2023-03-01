@extends('admin.layouts.master')

@section('title')
    Category List
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

                    <div class="row">
                        <div class="col-3">
                            <h5 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h5>
                        </div>
                        <div class="col-3 offset-1">
                            <div class="bg-light w-50 text-center shadow text-dark">
                                <i class="fa-solid fa-database fs-3"></i> <span
                                    class="fs-3 fw-bold">{{ $data->total() }}</span>
                            </div>
                        </div>
                        <div class="col-4 offset-1">
                            <form action="{{ route('admin#list') }}" method="get">
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

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address </th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $a)
                                    <tr class="tr-shadow">
                                        <input type="hidden" id="userId" value="{{ $a->id }}">
                                        <td class="col-2">
                                            @if ($a->image == null)
                                                @if ($a->gender == 'male')
                                                    <img src="{{ asset('images/default_user.png') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{ asset('images/default_female.jpg') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $a->image) }}"
                                                    class="img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->email }}</td>
                                        <td>{{ $a->gender }}</td>
                                        <td>{{ $a->phone }}</td>
                                        <td>{{ $a->address }}</td>
                                        <td class="col-12">
                                            @if (Auth::user()->id != $a->id)
                                                <select class="form-control statusChange">
                                                    <option value="user"
                                                        @if ($a->role == 'user') selected @endif>User</option>
                                                    <option value="admin"
                                                        @if ($a->role == 'admin') selected @endif>Admin</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                @if (Auth::user()->id != $a->id)
                                                    <a href="{{ route('admin#delete', $a->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="mt-3">
                        {{ $data->links() }}
                        {{-- {{ $categories->appends(request()->query())->links() }} --}}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents('tr');
                $userId = $parentNode.find('#userId').val();
                $data = {
                    'role': $currentStatus,
                    'user_id': $userId
                };

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/admin/ajax/role/change',
                    data: $data,
                    dataType: 'json',
                });
                location.reload();
            });
        });
    </script>
@endsection
