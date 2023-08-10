<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://qiniu.yangbaoyuan.cn/clipboard.png" sizes="32x32" type="image/png">
    <script src="/js/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title>CLIPBOARD</title>
</head>
<body>
<div class="container">
    <br>
    <br>
    <br>
    <form method="post">
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
