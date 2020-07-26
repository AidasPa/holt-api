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

                    <form method="post" action="{{ route('categories.store') }}">
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
