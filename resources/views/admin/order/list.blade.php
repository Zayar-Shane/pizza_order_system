@extends('admin.layouts.master')

@section('title')
    Category List
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left col-4">
                            <div class="overview-wrap">
                                <h2 class="title-1">User List</h2>

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <form action="{{ route('admin#orderStatus') }}" method="get">
                                    @csrf
                                    <div class=" col-8 input-group mb-3">

                                        <label class="input-group-text fs-5" for="inputGroupSelect02"><i
                                                class="fa-solid fa-database me-2"></i> {{ count($order) }}</label>
                                        <select class="form-select" name="orderStatus" id="inputGroupSelect02">
                                            <option value="" @if (request('orderStatus') == null) selected @endif>All
                                            </option>
                                            <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending
                                            </option>
                                            <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept
                                            </option>
                                            <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject
                                            </option>
                                        </select>
                                        <button class="btn btn-sm btn-dark input-group-text"type="submit"> <i
                                                class="fa-solid fa-magnifying-glass me-2"></i>Search</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>



                    @if (count($order) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User Id</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="dataList">
                                    @foreach ($order as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" id="orderId" value="{{ $o->id }}">
                                            <td>{{ $o->user_id }}</td>
                                            <td>{{ $o->user_name }}</td>
                                            <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('order#listInfo', $o->order_code) }}">{{ $o->order_code }}</a>
                                            </td>
                                            <td id="total">{{ $o->total_price }} Kyats</td>
                                            <td>
                                                <select name="status" class="form-select statusChange">
                                                    <option value="0"
                                                        @if ($o->status == 0) selected @endif>Pending</option>
                                                    <option value="1"
                                                        @if ($o->status == 1) selected @endif>Accept</option>
                                                    <option value="2"
                                                        @if ($o->status == 2) selected @endif>Reject</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center fs-4">
                            <h3 class="text-danger">There is no order list.</h3>
                        </div>
                    @endif
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
            // $('#orderStatus').change(function(event) {
            //     $status = $('#orderStatus').val();

            //     $.ajax({
            //         type: 'get',
            //         url: 'http://localhost:8000/order/ajax/status',
            //         data: {
            //             'status': $status
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             $list = '';
            //             for ($i = 0; $i < response.length; $i++) {

            //                 $month = ['January', 'February', 'March', 'April', 'May', 'June',
            //                     'July', 'August', 'September', 'October', 'November',
            //                     'December'
            //                 ];
            //                 console.log(response[$i].created_at);
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $finalDate = $month[$dbDate.getMonth()] + '-' + $dbDate.getDate() +
            //                     '-' + $dbDate.getFullYear();

            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `
        //                     <select name="status" class="form-select statusChange">
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>
        //                     `;
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `
        //                     <select name="status" class="form-select statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1" selected>Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>
        //                     `;
            //                 } else if (response[$i].status == 2) {
            //                     $statusMessage = `
        //                     <select name="status" class="form-select statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2" selected>Reject</option>
        //                     </select>
        //                     `;
            //                 }

            //                 $list += `
        //                     <tr class="tr-shadow">
        //                         <input type="hidden" id="orderId" value="${response[$i].id}">
        //                         <td>${response[$i].user_id}</td>
        //                         <td>${response[$i].user_name}</td>
        //                         <td>${$finalDate}</td>
        //                         <td>${response[$i].order_code}</td>
        //                         <td>${response[$i].total_price} Kyats</td>
        //                         <td>${$statusMessage}</td>
        //                     </tr>
        //                 `;

            //             }
            //             $('.dataList').html($list);
            //         }
            //     })
            // });

            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents('tr');
                $orderId = $parentNode.find('#orderId').val();
                console.log($orderId);
                $data = {
                    'status': $currentStatus,
                    'order_id': $orderId,
                };

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',

                });

            });
        });
    </script>
@endsection
