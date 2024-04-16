@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Order Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>product name: </strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $order->productName }}
                        </div>
                    </div>
                    <div class="row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>product quantity: </strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $order->productQuantity }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>product price: </strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $order->productPrice }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end text-start"><strong>product description: </strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $order->productDescription }}
                        </div>
                    </div>
                    <div class="card-footer">
                        <h3>Total: {{ $order->total }}</h3>
                    </div>
                    </div>

                </div>
            </div>
        </div>

@endsection
