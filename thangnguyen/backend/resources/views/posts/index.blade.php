@extends('layout')

@section('content')
    <h1>Danh sách bài viết</h1>
    @foreach ($posts as $post)
        <div>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="200">
            @endif
        </div>
    @endforeach
@endsection
