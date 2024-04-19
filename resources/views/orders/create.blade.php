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
                        Add order details
                    </div>
                    <div class="float-end">
                        <a href="{{ route('cart.index', auth()->id()) }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                  <form action="{{ route('orders.store') }}" method="post">
                        @csrf

                          <div class="form-group mb-2">
                              <label for="inputAddress">Address</label>
                              <input type="text" class="form-control" id="inputAddress" @error('adress') is-invalid @enderror placeholder="1234 Main St" name="adress" value="{{ old('adress') }}">
                              @if ($errors->has('adress'))
                                  <span class="text-danger">{{ $errors->first('adress') }}</span>
                              @endif
                          </div>
                          <div class="form-group">
                              <div class="form-check">
                                  @foreach($payments as $payment)
                                      <div>
                                          <input class="form-check-input" type="checkbox" @error('payment') is-invalid @enderror name ="payment" onclick="uncheckAndCheck(event)" value="{{ $payment }}">
                                          @if ($errors->has('payment'))
                                              <span class="text-danger">{{ $errors->first('payment') }}</span>
                                          @endif
                                          <label class="form-check-label" for="gridCheck">
                                              {{$payment}}
                                          </label>
                                      </div>
                                  @endforeach
                              </div>
                          </div>
                          <button type="submit" class="btn btn-primary">Place Order</button>
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

        function uncheckAndCheck(event)
        {
            document.querySelectorAll( "input[type='checkbox'][name^='payment']" ).forEach( checkbox => {
                checkbox.checked = false;
            });

            event.target.checked = true;
        }
    </script>


@endsection
