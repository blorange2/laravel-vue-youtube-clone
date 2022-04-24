@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Channel settings') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('channels.update', $channel) }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="form-group{{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}">
                        </div>

                        <div class="form-group{{ $errors->has('slug') ? 'has-error' : '' }}">
                            <label for="slug">Slug</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">{{ config('app.url') }}</span>
                                </div>
                                <input type="text" class="form-control" id="slug" value="{{ old('slug') }}">
                            </div>
     
                        </div>

                        <div class="form-group{{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group{{ $errors->has('channel_image') ? 'has-error' : '' }}">
                            <label for="description">Channel image</label>
                            <input class="form-control" type="file" name="channel_image" id="channel_image">
                        </div>
            
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
