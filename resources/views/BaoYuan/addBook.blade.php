<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://qiniu.yangbaoyuan.cn/bookPro.png" sizes="32x32" type="image/png">
    <script src="/js/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title>ADD-BOOK</title>
</head>
<body>
<div class="container">
    <br>
    <div class="alert alert-info" role="alert">
        <a class="nav-link active" href="/book/list">书库</a>
    </div>
    <form method="post" action="/book/add">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlTextarea1">请输入内容</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="body" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mb-2">确认</button>
    </form>
</div>
<script>

</script>
</body>
</html>
