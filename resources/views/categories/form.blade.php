@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        @if(isset($item->id))
                            New
                        @else
                            Edit
                        @endif
                        Category
                    </div>

                    <form method="post" action="{{ route(isset($item->id) ? 'categories.update' : 'categories.store', ['category' => $item->id ?? null]) }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($item->id))
                            @method('put')
                        @endif
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" value="{{ old('title', $item->title ?? '') }}" name="title"
                                       id="title"/>

                                @error('title')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            @if(isset($item->id))
                                <img width="40%"
                                     src="{{ \Illuminate\Support\Facades\Storage::url($item->image) }}"/>
                            @endif
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input class="form-control-file" name="image" id="image" type="file"/>

                                @error('image')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror

                            </div>
                            @if(isset($item->id))
                                <div class="form-group">
                                    <label for="image_blurhash">Image Blurhash</label>
                                    <input disabled value="{{ $item->image_blurhash }}" class="form-control" name="image_blurhash" id="image_blurhash" type="text"/>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <input type="submit" class="btn btn-success" value="Save"/>
                                </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
