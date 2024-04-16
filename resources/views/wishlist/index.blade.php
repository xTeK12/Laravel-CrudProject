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
                <div class="card-header">{{ auth()->user()->name}} Wishlist</div>
                <div class="card-body">
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
                        <tbody>
                        @forelse ($wishlistProducts as $wishlistProduct)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{$wishlistProduct->ProductInfo->name}}</td>
                                <td>{{$wishlistProduct->ProductInfo->quantity}}</td>
                                <td>{{$wishlistProduct->ProductInfo->price }}</td>
                                <td>
                                    <form action="{{ route('wishlist.destroy', $wishlistProduct->ProductInfo->id) }}" method="post">

                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('cart.buyProduct', $wishlistProduct->ProductInfo->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-cart"> Add to cart</i></a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product from wishlist?');">
                                            <i class="bi bi-trash"></i> Delete</button>

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
