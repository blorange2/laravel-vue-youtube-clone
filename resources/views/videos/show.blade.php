@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if($video->isPrivate() && auth()->check() && $video->ownedByUser(auth()->user()))
                <div class="alert alert-info">
                    Your video is currently private. Only you can see it.
                </div>
            @endif

            @if($video->isProcessed() && $video->canBeAccessed(auth()->user()))
                <video-player video-uid="{{ $video->uid }}" video-url="{{ $video->getStreamUrl() }}" thumbnail-url={{ $video->getThumbnail() }}></video-player>
            @endif

            @if (!$video->isProcessed())
                <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is processing.
                    </div>
                </div>
            @elseif(!$video->canBeAccessed(auth()->user()))
                <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is private.
                    </div>
                </div>
            @endif

            <div class="card mb-3">
                <div class="card-body">
                    <h4>{{ $video->title }}</h4>

                    <div class="float-right">
                        <div class="video__views">
                            {{ $video->viewCount() }} views
                        </div>

                        @if($video->votesAllowed())
                        <video-voting video-uid="{{ $video->uid }}"></video-voting>
                        @endif
                    </div>

                    <div class="media">
                        <a href="">
                            <img src="{{ $video->channel->getImage() }}" class="mr-3" alt="...">
                        </a>

                        <div class="media-body">
                            <a class="media-title" href="{{ route('channels.edit', $video->channel) }}">{{ $video->channel->name }}</a>
                            Subscribe
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    {{ $video->description ?? ' No description available.' }}
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if ($video->commentsAllowed())
                        Comments
                    @else
                        Comments are disabled.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
