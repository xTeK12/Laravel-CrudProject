@extends('layouts.app')
@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if($errors->any())
        <div id="message" class="alert alert-danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif
    <div class="container mt-8">
        <div class="row">
            @foreach($dashboardProducts->chunk(4) as $chunk)
                <div class="row no-gutters">
                    @foreach($chunk as $dashboardProduct)
                        <div class="col-3 mb-4">
                            <div class="card cardDashboard  h-100 mb-2 productShow" data-product-id="{{ $dashboardProduct->id }}">
                                <a  href="{{ route('wishlist.addProduct', $dashboardProduct->id) }}" class="d-flex flex-row-reverse mr-2 mt-2"><i class="bi bi-heart"></i></a>
                                <img class="card-img-top img-fluid"
                                     src="{{ asset(str_replace('public', 'storage', $dashboardProduct->media->path)) }}"
                                     alt="product image" style="object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-between">
                                        <h5 class="card-title"><strong>{{ $dashboardProduct->name }}</strong></h5>
                                        @if($dashboardProduct->quantity > 0)
                                            <p class="card-text text-success"><strong>In Stock</strong></p>
                                        @else
                                            <p class="card-text text-danger"><strong>sold out</strong> </p>
                                        @endif
                                    </div>
                                    <p class="card-text mb-2 mt-auto">{{ $dashboardProduct->description }}</p>
                                    <p class="animate-charcter card-text mt-auto">
                                        {{ $dashboardProduct->price }} €</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('cart.buyProduct', $dashboardProduct->id) }}" class="btn btn-primary"><i
                                                class="bi bi-cart mr-2"></i>Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.querySelectorAll('.productShow').forEach(function(element) {
            element.addEventListener('click', function() {
                var productId = this.getAttribute('data-product-id');
                var url = "{{ route('products.show', ':productId') }}".replace(':productId', productId);
                window.location.href = url;
            });
        });

        setTimeout(function()
        {
            document.getElementById('message').style.display = 'none';
        }, 3000);

    </script>

@endsection
