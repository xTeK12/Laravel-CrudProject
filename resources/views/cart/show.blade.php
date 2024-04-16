@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Product Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('cart.index', auth()->id()) }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cartProduct->product->name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end text-start"><strong>Quantity:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cartProduct->quantity }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start"><strong>Price:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cartProduct->product->price }}
                        </div>
                    </div>

                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('cart.edit', $cartProduct->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <h3 class="ml-auto p-1"><strong>Total product cost:</strong> {{ $cartProduct->quantity * $cartProduct->product->price}} €</h3>
                </div>
            </div>
        </div>

@endsection
