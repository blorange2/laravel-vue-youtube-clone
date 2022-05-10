@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit video</div>

                <div class="card-body">
                    <form action="{{ route('videos.update', $video) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $video->title) }}">

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ old('description', $video->description) }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="visibility">Visibility</label>
                            <select name="visibility" id="visibility" class="form-control">
                                @foreach (['private', 'unlisted', 'public'] as $visibility)
                                   <option value="{{ $visibility }}"{{ $video->visibility == $visibility ? 'selected' : '' }}>{{ ucfirst($visibility) }}</option> 
                                @endforeach
                            </select>

                            @error('visibility')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="allow_votes" class="form-check-input" id="allow_votes"{{ $video->votesAllowed() ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_votes">Allow votes</label>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="allow_comments" class="form-check-input" id="allow_comments"{{ $video->commentsAllowed() ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_comments">Allow comments</label>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Update" class="btn btn-primary">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
