@extends('layout')

@section('content')
    <h1>Thêm bài viết mới</h1>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">Tiêu đề</label>
        <input type="text" name="title" id="title" required>

        <label for="content">Nội dung</label>
        <textarea name="content" id="content" required></textarea>

        <label for="image">Hình ảnh</label>
        <input type="file" name="image" id="image">

        <button type="submit">Tạo bài viết</button>
    </form>
@endsection
