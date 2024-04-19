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
                <div class="card-header">Offer List</div>
                <div class="card-body">
                    @foreach($offers as $offer)

                        <div class="row">
                            <div class="col-sm-6 mt-5">
                                <div class="card">
                                    <div class="card-header d-flex justify-between align-items-center">
                                        @if($offer->user_id === auth()->id())
                                            <h3><strong>Offer</strong> {{ $offer->id }} (Sent)</h3>
                                        @endif
                                        @if($offer->user_id !== auth()->id())
                                            <h3><strong>Offer</strong> {{ $offer->id }} (Received)</h3>
                                        @endif

                                        @if($offer->user_id === auth()->id())
                                            <form action="{{route('offer.destroy', $offer->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want remove this offer ?');"><i class="bi bi-dash-circle"></i> Remove Offer</button>
                                            </form>
                                        @endif

                                            @if($offer->user_id !== auth()->id())
                                        <div class="d-flex gap-1">
                                            <form action="{{route('offer.destroy', $offer->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want remove this offer ?');"><i class="bi bi-dash-circle"></i> Remove Offer</button>
                                            </form>

                                            <form action="{{route('offer.accept', $offer->id)}}" method="post">
                                                @csrf

                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Do you want accept this offer ?');"><i class="bi bi-dash-circle"></i> Accept Offer</button>
                                            </form>
                                                @endif
                                        </div>
                                    </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush mb-3">
                                                    <li class="list-group-item">Product: {{$offer->product->name}}</li>
                                                    <li class="list-group-item">Quantity: {{ $offer->quantity }}</li>
                                                    <li class="list-group-item">Total Price: {{ $offer->price }}€</li>
                                                </ul>
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
