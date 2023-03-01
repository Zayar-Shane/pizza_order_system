@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0 priceList">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr>
                                <td><img src="{{ asset('storage/' . $c->image) }}" class="img-thumbnail shadow-sm"
                                        style="width: 50px;">
                                </td>
                                <td class="align-middle">{{ $c->product_name }}
                                    <input type="hidden" id="orderId" value="{{ $c->id }}">
                                    <input type="hidden" id="productId" value="{{ $c->product_id }}">
                                    <input type="hidden" id="userId" value="{{ $c->user_id }}">
                                </td>
                                <td class="align-middle" id="price">{{ $c->product_price }} Kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $c->qty }}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle" id="total">{{ $c->product_price * $c->qty }} Kyats</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotal">{{ $totalPrice }} Kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 Kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalTotal">{{ $totalPrice + 3000 }} Kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To
                            Checkout</button>

                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3 " id="removeBtn">Cancel
                            Cart
                            Items</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection


@section('scriptSouce')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        $orderList = [];
        $random = Math.floor(Math.random() * 1000000001);
        $('#orderBtn').click(function() {

            $('.priceList tbody tr').each(function(index, row) {
                $orderList.push({
                    'user_id': $(row).find('#userId').val(),
                    'product_id': $(row).find('#productId').val(),
                    'qty': $(row).find('#qty').val(),
                    'total': $(row).find('#total').text().replace("Kyats", "") * 1,
                    'order_code': 'POS' + $random
                });
            });

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/order',
                data: Object.assign({}, $orderList),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.href = "http://localhost:8000/user/homePage";
                    }
                }
            })
        });

        $('#removeBtn').click(function() {
            $('#subTotal').html(0 + "Kyats");
            $('#finalTotal').html(0 + 3000 + "Kyats") + 3000;
            $userId =
                $('.priceList tbody tr').remove();

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/clear/cart',
                dataType: 'json',
            })
        });

        // when cross button click
        $(".btnRemove").click(function() {
            $parentNode = $(this).parents("tr");
            $productId = $parentNode.find('#productId').val();
            $orderId = $parentNode.find('#orderId').val();
            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/clear/currentItem',
                data: {
                    'product_id': $productId,
                    'order_id': $orderId
                },
                dataType: 'json',
            })
            $parentNode.remove();
            $subTotal = 0;
            $('.priceList tbody tr').each(function(index, row) {
                $subTotal += Number($(row).find('#total').text().replace("Kyats", ""));
            });
            $('#subTotal').html(`${$subTotal} Kyats`);
            $('#finalTotal').html(`${$subTotal + 3000} Kyats`);
        });
    </script>
@endsection
