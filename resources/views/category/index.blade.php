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
                <div class="card-header"> Category List</div>
                <div class="card-body">
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('category.create') }}" class="btn btn-sm btn-info"><i class="bi bi-plus-circle"></i> Add new category</a>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name Category</th>
                            <th scope="col">ID</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{$category->name}}</td>
                                <td>{{$category->id}}</td>
                                <td>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="post">

                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
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
