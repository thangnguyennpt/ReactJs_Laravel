<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Tin Tức</title>
</head>
<body>
    <nav>
        <a href="{{ route('posts.index') }}">Danh sách bài viết</a>
        <a href="{{ route('posts.create') }}">Thêm bài viết mới</a>
    </nav>

    <div>
        @yield('content')
    </div>
</body>
</html>
