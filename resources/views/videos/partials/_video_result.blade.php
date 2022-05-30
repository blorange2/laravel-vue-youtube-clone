<div class="row">
    <div class="col-sm-3">
        <a href="">
            <img src="{{ $video->getThumbnail() }}" alt="" class="img-fluid">
        </a>
    </div>

    <div class="col-sm-9 my-3">
        <a href="{{ route('videos.show', $video) }}">{{ $video->title }}</a>

        @if($video->description)
        <p>{{ $video->description }}</p>
        @endif

        <ul class="list-inline">
            <li class="list-inline-item"><a href="">{{ $video->channel->name }}</a></li>
            <li class="list-inline-item">{{ $video->created_at->diffForHumans() }}</li>
            <li class="list-inline-item">{{ $video->viewCount() }} views</li>
        </ul>
    </div>
</div>