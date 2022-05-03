@extends('layouts.app')

@section('content')
    <video-upload 
        :user={{ auth()->user() ? auth()->user()->id : null }}
        :authenticated={{ auth()->check() ? 'true' : 'false' }}
    >
    </video-upload>
@endsection
