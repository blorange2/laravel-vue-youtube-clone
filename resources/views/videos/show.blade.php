@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            hrhbtfhg






            <div class="card mb-3">
                <div class="card-body">
                    <h4>{{ $video->title }}</h4>

                    <div class="float-right">
                    View count here.
                    </div>

                    <div class="media">
                        <a href="">
                            <img src="{{ $video->channel->getImage() }}" class="mr-3" alt="...">
                        </a>

                        <div class="media-body">
                            <h5 class="mt-0">{{ $video->channel->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    {{ $video->description ?? ' No description available.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
