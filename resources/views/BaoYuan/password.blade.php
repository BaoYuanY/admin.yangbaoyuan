<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://baoyuan-one.oss-cn-shanghai.aliyuncs.com/password.png" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="/js/jquery-3.7.0.js"></script>
    <title>PASSWORD</title>
</head>
<body>
<div class="container">
    <br>
    <div class="alert alert-danger" role="alert">
        这都被你发现了
    </div>

    <br>

    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">请输入平台</label>
            <input type="text" class="form-control" name="platform" aria-describedby="请输入对应平台" autocomplete="off" required>
            <small id="text" class="form-text text-muted">支持模糊搜索</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">请输入账号</label>
            <input type="text" class="form-control" name='account' autocomplete="off" required>
            <small id="text" class="form-text text-muted">支持模糊搜索</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">加盐</label>
            <input type="text" class="form-control" name="salt" autocomplete="off" required>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary">查询</button>
    </form>

</div>
</body>
<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            // 防止表单的默认提交行为
            e.preventDefault();
            // 收集表单数据
            const formData = $(this).serialize();

            // 使用 AJAX 发送表单数据
            $.ajax({
                url: '/password/search', // 服务器端的接收URL
                type: 'POST', // 提交表单的HTTP方法
                data: formData, // 发送表单的数据
                dataType: 'json', // 预期从服务器返回的数据类型
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, // 添加 CSRF 令牌头
                success: function(response) {
                    // 请求成功的处理逻辑
                    console.log(response)
                },
                error: function(xhr, status, error) {
                    // 请求失败的处理逻辑
                    console.log('登录失败：', error);
                    console.log(response)
                }
            });
        });
    });
</script>
</html>
