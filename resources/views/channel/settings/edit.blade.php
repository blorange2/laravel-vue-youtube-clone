@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Channel settings') }}</div>

                <div class="card-body">
                    <form action="{{ route('channels.update', $channel) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" value="{{ old('name', $channel->name) }}">

                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ config('app.url') }}</span>
                                </div>
                                <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" id="slug" value="{{ old('slug', $channel->slug) }}">

                                @if ($errors->has('slug'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" cols="30" rows="10">{{ old('description', $channel->description) }}</textarea>

                            @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">Channel image</label>
                            <input class="form-control {{ $errors->has('channel_image') ? 'is-invalid' : '' }}" type="file" name="channel_image" id="channel_image">

                            @if ($errors->has('channel_image'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('channel_image') }}</strong>
                            </span>
                            @endif
                        </div>
            
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
