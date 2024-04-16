@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div id="message" class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first() }}
                    </div>
            @endif

            <div class="card">
                <div class="card-header">{{ auth()->user()->name}} products List</div>
                <div class="card-body">
                    <form action="{{route('orders.store')}}" method="post">
                        @csrf
                    <button type="submit" class="btn btn-success btn-sm my-2" onclick="return confirm('Do you want to place this order ?');"><i class="bi bi-plus-circle"></i> Place Order</button>
                    </form>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($cartProducts as $cartProduct)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{$cartProduct->product->name}}</td>
                                <td>{{$cartProduct->quantity}}</td>
                                <td>{{$cartProduct->product->price }}</td>
                                <td>
                                    <form action="{{ route('cart.destroy', $cartProduct->id) }}" method="post">

                                        @csrf
                                        @method('DELETE')


                                        <a href="{{ route('cart.show', $cartProduct->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                                        <a href="{{ route('cart.edit', $cartProduct->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product from cart?');"><i class="bi bi-trash"></i> Delete</button>

                                    </form>

                                </td>
                            </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No products found!</strong>
                                </span>
                            </td>
                        @endforelse
                        </tbody>
                        <td colspan="6">
                            <strong>Total: <span class="text-primary"> {{$total_price }}  €</span></strong>
                        </td>
                    </table>

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
