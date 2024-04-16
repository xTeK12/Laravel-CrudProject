@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            @if($errors->any())
                <div id="message" class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Product Information
                    </div>
                    <div class="float-end">
                        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>Code:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->code }}
                        </div>
                    </div>
                    <div class="row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>OwnerID:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->ownerID }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end text-start"><strong>Quantity:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->quantity }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start"><strong>Price:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->price }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->description }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="media" class="col-md-4 col-form-label text-md-end text-start"><strong>Image:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            <img src="{{ asset(str_replace('public', 'storage', $product->media->path)) }}"
                                 alt="product image" style="object-fit: cover; width: 150px; height: 160px;">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('cart.buyProduct', $product->id) }}" class="btn btn-success btn-sm">Buy now</a>
                    <a href="{{ route('wishlist.addProduct', $product->id) }}" class="btn btn-dark btn-sm"><i class="bi bi-heart"></i> Add to Favorite</a>
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
