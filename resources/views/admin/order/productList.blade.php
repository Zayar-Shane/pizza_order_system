@extends('admin.layouts.master')

@section('title')
    Category List
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <a href="{{ route('order#list') }}" class="text-decoration-none text-dark ms-2 mb-3
                "> <i
                        class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>

                <div class="card mt-2 col-6">
                    <div class="card-body">
                        <h3><i class="fa fa-clipboard me-2" aria-hidden="true"></i>Order Info <small
                                class="text-warning">(include delivery
                                charge)</small></h3>
                        <hr>
                        <div class="row">
                            <div class="col"> <i class="fa fa-user me-1" aria-hidden="true"></i> Customer Name</div>
                            <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                        </div>
                        <div class="row">
                            <div class="col"><i class="fa fa-barcode me-1" aria-hidden="true"></i> Order Code</div>
                            <div class="col">{{ $orderList[0]->order_code }}</div>
                        </div>
                        <div class="row">
                            <div class="col"><i class="fa fa-clock-o me-1" aria-hidden="true"></i> Order Date</div>
                            <div class="col">{{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col"><i class="fa fa-money me-1" aria-hidden="true"></i> Total</div>
                            <div class="col">{{ $order->total_price }} Kyats</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    @if (count($orderList) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Order Id</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Order Date</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="dataList">
                                    @foreach ($orderList as $o)
                                        <tr class="tr-shadow">
                                            <td></td>
                                            <td>{{ $o->id }}</td>
                                            <td class="col-2"><img src="{{ asset('storage/' . $o->product_image) }}"
                                                    class="img-thumbnail">
                                            </td>
                                            <td>{{ $o->product_name }}</td>
                                            <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                            <td>{{ $o->qty }}</td>
                                            <td>{{ $o->total }}</td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-seconda fs-4">
                            There is no order list.
                        </div>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
