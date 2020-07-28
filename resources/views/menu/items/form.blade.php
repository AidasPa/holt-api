@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        @if(isset($item->id))
                            Edit
                        @else
                            New
                        @endif
                        Menu Item
                    </div>

                    <form method="post"
                          action="{{ route('restaurants.menu.items.store', ['restaurant' => $restaurantId]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" value="{{ old('title') }}" name="title" id="title"/>

                                @error('title')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"
                                          id="description">{{ old('description') }}</textarea>

                                @error('description')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input class="form-control" value="{{ old('price' ?? 0.1) }}"
                                       name="price" type="text"
                                       min="0.1"
                                       id="price"/>

                                @error('price')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="menu_category">Menu Category</label>
                                <select name="menu_category" id="menu_category" class="form-control">
                                    @foreach($menuCategories as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>

                                @error('menu_category')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
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
