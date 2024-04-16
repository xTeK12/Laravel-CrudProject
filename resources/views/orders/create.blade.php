@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            @if ($message = Session::get('success'))
                <div id="message" class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Add {{$product->name}} to Cart
                    </div>
                    <div class="float-end">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                  <form action="{{ route('orders.store') }}" method="post">
                        @csrf

                      <!-- Code Field -->
                      <div class="mb-3 row">
                          <label for="code" class="col-md-4 col-form-label text-md-end text-start">Code</label>
                          <div class="col-md-6">
                              <input type="text" class="form-control" id="code" name="code" value="{{ $product->code }}" readonly>
                          </div>
                      </div>

                      <!-- Name Field -->
                      <div class="mb-3 row">
                          <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                          <div class="col-md-6">
                              <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" readonly>
                          </div>
                      </div>

                      <!-- Quantity Field -->
                      <div class="mb-3 row">
                          <label for="quantity" class="col-md-4 col-form-label text-md-end text-start">Quantity({{ $product->quantity }}) </label>
                          <div class="col-md-6">
                              <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                              @if ($errors->has('quantity'))
                                  <span class="text-danger">{{ $errors->first('quantity') }}</span>
                              @endif
                          </div>
                      </div>

                      <!-- Price Field -->
                      <div class="mb-3 row">
                          <label for="price" class="col-md-4 col-form-label text-md-end text-start">Price</label>
                          <div class="col-md-6">
                              <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}" readonly>
                          </div>
                      </div>

                      <!-- Description Field -->
                      <div class="mb-3 row">
                          <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                          <div class="col-md-6">
                              <textarea class="form-control" id="description" name="description" readonly>{{ $product->description }}</textarea>
                          </div>
                      </div>

                      <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-success" value="Buy Product">
                        </div>

                    </form>
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
