@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div id="message" class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Orders List</div>
                <div class="card-body">
                    @foreach($userOrders as $userOrder)

                    <div class="row">
                        <div class="col-sm-6 mt-5">
                            <div class="card">
                                <div class="card-header d-flex justify-between align-items-center">
                                    <h3><strong>Order</strong> {{ $userOrder->id }}</h3>
                                    <form action="{{route('orders.destroy', $userOrder->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Do you want to place this order ?');"><i class="bi bi-dash-circle"></i> Refund Order</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    @foreach($userOrder->orderDetails as $orderDetail)
                                        <ul class="list-group list-group-flush mb-3">
                                            <li class="list-group-item">Product: {{$orderDetail->productDetails->name}}</li>
                                            <li class="list-group-item">Quantity: {{ $orderDetail->quantity }}</li>
                                            <li class="list-group-item">Price: {{ $orderDetail->productDetails->price }}€</li>
                                        </ul>
                                    @endforeach
                                        <div class="card-footer d-flex flex-row gap-2"><p class="text-primary">Total cost:</p> {{$userOrder->total_order_price}}€</div>
                                </div>
                            </div>

                        </div>
                    </div>
                        @endforeach
                </div>
                </div>
            </div>
        </div>
    <script>
        setTimeout(function()
        {
            document.getElementById('message').style.display = 'none';
        }, 3000);
    </script>

@endsection
