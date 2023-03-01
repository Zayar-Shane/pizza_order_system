@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5" style="height: 520px">
                <table class="table table-light table-borderless table-hover text-center mb-0 priceList">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order code</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $o)
                            <tr>
                                <td class="align-middle">{{ $o->created_at->format('F-j-Y') }}
                                </td>
                                <td class="align-middle">{{ $o->order_code }} </td>
                                <td class="align-middle">{{ $o->total_price }} Kyats</td>
                                <td class="align-middle">
                                    @if ($o->status == 0)
                                        <span class="text-warning">Pending...</span>
                                    @elseif($o->status == 1)
                                        <span class="text-success">Success</span>
                                    @elseif ($o->status == 2)
                                        <span class="text-danger">Reject</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $order->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
