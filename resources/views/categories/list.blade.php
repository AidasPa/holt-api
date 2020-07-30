@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Categories
                        <a class="btn btn-primary btn-sm float-right text-white"
                           href="{{ route('categories.create') }}">+</a>
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
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>

                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        @if($item->image)
                                            <img width="100px"
                                                 src="{{ \Illuminate\Support\Facades\Storage::url($item->image) }}"/>
                                        @else
                                            No IMG
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary text-white"
                                           href="{{ route('categories.edit', ['category' => $item->id])  }}">Edit</a>
                                        <form method="post"
                                              action="{{ route('categories.destroy', ['category' => $item->id]) }}">
                                            @method('delete')
                                            @csrf
                                            <input type="submit" class="btn btn-sm btn-danger text-white" value="Delete"
                                                   onclick="return confirm('Do you really want to delete a record?');">
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
