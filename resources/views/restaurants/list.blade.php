@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Restaurants
                        <a class="btn btn-primary btn-sm float-right text-white"
                           href="{{ route('restaurants.create') }}">+</a>
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
                                <th>Phone Number</th>
                                <th>Rating</th>
                                <th>Actions</th>
                            </tr>

                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>{{ $item->rating }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary text-white"
                                           href="{{ route('restaurants.edit', ['restaurant' => $item->id]) }}">Edit</a>
                                        <form action="{{ route('restaurants.destroy', ['restaurant' => $item->id]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="submit"
                                                   onclick="return confirm('Do you really want to delete a record?');"
                                                   class="btn btn-sm btn-danger" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
