@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        @if(isset($restaurant->id))
                            Edit
                        @else
                            New
                        @endif
                        Restaurant
                    </div>

                    <form method="post" action="{{
                                            isset($restaurant->id)
                                            ? route('restaurants.update', ['restaurant' => $restaurant->id])
                                            : route('restaurants.store')
                                                 }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if(isset($restaurant->id))
                                <div class="row">
                                    <hr/>
                                    <div class="col-6">
                                        <a href="{{ route('restaurants.menu.categories.index', ['restaurant' => $restaurant->id]) }}"
                                           class="btn btn-primary w-100 text-white">Menu Categories</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('restaurants.menu.items.index', ['restaurant' => $restaurant->id]) }}"
                                           class="btn btn-primary w-100 text-white">Menu Items</a>
                                    </div>
                                </div>
                                <hr/>

                            @endif
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" value="{{ old('title', $restaurant->title ?? '') }}"
                                       name="title" id="title"/>

                                @error('title')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"
                                          id="description">{{ old('description', $restaurant->description ?? '') }}</textarea>

                                @error('description')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <input class="form-control" value="{{ old('rating', $restaurant->rating ?? 0.1) }}"
                                       name="rating" type="text"
                                       min="0" max="10"
                                       id="rating"/>

                                @error('rating')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="avg_delivery_time">Average delivery time</label>
                                <input class="form-control"
                                       value="{{ old('avg_delivery_time', $restaurant->avg_delivery_time ?? '') }}"
                                       name="avg_delivery_time" type="number"
                                       id="avg_delivery_time"/>

                                @error('avg_delivery_time')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone number</label>
                                <input class="form-control"
                                       value="{{ old('phone_number', $restaurant->phone_number ?? '') }}"
                                       name="phone_number"
                                       type="text"
                                       id="phone_number"/>

                                @error('phone_number')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input class="form-control" value="{{ old('address', $restaurant->address ?? '') }}"
                                       name="address"
                                       type="text"
                                       id="address"/>

                                @error('address')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                @if(isset($restaurant->id))
                                    @method('put')
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($restaurant->image) }}"
                                         width="50%"/>
                                @endif
                                <br/>
                                <label for="image">Image</label>
                                <input class="form-control-file"
                                       name="image"
                                       type="file"
                                       id="image"/>

                                @error('image')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>
                            <div class="form-group">
                                @if(isset($restaurant->id))
                                    @method('put')
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($restaurant->banner) }}"
                                         width="50%"/>
                                @endif
                                <br/>
                                <label for="banner">Banner</label>
                                <input class="form-control-file"
                                       name="banner"
                                       type="file"
                                       id="banner"/>

                                @error('banner')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="categories">Categories</label>
                                <br/>
                                @foreach($categories as $id => $category)
                                    <input type="checkbox" id="categories" name="categories[]"
                                           value="{{ $id }}"
                                           @if(in_array($id, old('categories', $categoryIds ?? []))) checked @endif
                                    > {{ $category }}
                                @endforeach
                            </div>
                            @if(isset($restaurant->id))
                                <div class="form-group">
                                    <label for="image_blurhash">Image Blurhash</label>
                                    <br/>
                                    <input type="text" id="image_blurhash" disabled
                                           class="form-control"
                                           value="{{ $restaurant->image_blurhash }}"/>
                                </div>
                                <div class="form-group">
                                    <label for="banner_blurhash">Banner Blurhash</label>
                                    <br/>
                                    <input type="text" id="banner_blurhash" disabled
                                           class="form-control"
                                           value="{{ $restaurant->banner_blurhash }}"/>
                                </div>
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
