@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search results for {{ Request::get('q') }}</div>

                <div class="card-body">
                    @if($channels->count())
                        <h4>Channels</h4>

                        <div class="card">
                            @foreach ($channels as $channel)
                            <div class="media">
                                <div class="media-left">
                                    <a href="/channel/{{ $channel->slug }}">
                                        <img src="{{ $channel->getImage() }}" alt="" class="media-object">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a class="media-heading" href="/channel/{{ $channel->slug }}">{{ $channel->name }}</a>
                                    Subscription count
                                </div>
                            </div>
                            @endforeach
            
                        </div>
                    @endif

                    @if($videos->count())
                        @foreach ($videos as $video)
                            <div class="card">
                                @include('videos.partials._video_result', [
                                    'video' => $video
                                ])
                            </div>
                        @endforeach
                    @else
                        <p>No videos were found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
