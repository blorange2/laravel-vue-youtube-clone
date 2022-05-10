@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                @if($videos->count())
                    @foreach ($videos as $video)
                        <div class="card p-3">
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="">
                                        <img src="{{ $video->getThumbnail() }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <div class="col-sm-9">
                                    <a href="">{{ $video->title }}</a>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>
                                            @if(!$video->isProcessed())
                                                Processing ({{ $video->processedPercentage() ? $video->processedPercentage() . '%' : ' Starting up' }})
                                            @else
                                                <span>{{ $video->created_at->toDateTimeString() }}</span>
                                            @endif
                                            </p>
                                   

                                            <form action="{{ route('videos.delete', $video) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="{{ route('videos.edit', $video) }}" class="btn btn-primary">Edit</a>
                                                <input type="submit" value="Delete" class="btn btn-danger">
                                            </form>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <p>{{ ucfirst($video->visibility) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $videos->links() }}
                @else
                <p>You have no videos to display.</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
