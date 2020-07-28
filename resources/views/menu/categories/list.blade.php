@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Menu Categories
                        <a class="btn btn-primary btn-sm float-right text-white"
                           href="{{ route('restaurants.menu.categories.create', ['restaurant' => $restaurantId]) }}">+</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                            </tr>

                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <form method="post"
                                              action="{{ route('restaurants.menu.categories.destroy', ['restaurant' => $restaurantId, 'category' => $item->id]) }}">
                                            @csrf
                                            @method('delete')

                                            <input type="submit" value="Delete"
                                                   onclick="return confirm('Do you really want to delete a record?');"
                                                   class="btn btn-danger btn-sm"/>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('restaurants.edit', ['restaurant' => $restaurantId]) }}" class="btn btn-primary text-white">Back to Restaurant</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
