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
    <title>ADD-PASSWORD</title>
</head>
<body>
<div class="container">
    <br>
    <div class="alert alert-danger" role="alert">
        这都被你发现了 <a class="nav-link active" href="/password/index">查询账号</a>
    </div>

    <br>

    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">请输入平台</label>
            <input type="text" class="form-control" name="platform" aria-describedby="请输入对应平台" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">请输入账号</label>
            <input type="text" class="form-control" name='account' autocomplete="off" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">请输入手机号</label>
            <input type="text" class="form-control" name="phone" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">请输入邮箱</label>
            <input type="email" class="form-control" name="email" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">请输入密码</label>
            <input type="text" class="form-control" name="password" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">其他</label>
            <input type="text" class="form-control" name="salt" autocomplete="off">
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary">添加</button>
    </form>

    <div id="alertBox" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 20px; color: #721c24; border-radius: 5px; text-align: center;">
        添加成功
    </div>

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
                url: '/password/add', // 服务器端的接收URL
                type: 'POST', // 提交表单的HTTP方法
                data: formData, // 发送表单的数据
                dataType: 'json', // 预期从服务器返回的数据类型
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, // 添加 CSRF 令牌头
                success: function() {
                    // 请求成功的处理逻辑
                    $('#alertBox').show();

                    // 1秒后自动消失
                    setTimeout(function () {
                        $('#alertBox').fadeOut();
                    }, 2000);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // 请求失败的处理逻辑
                }
            });
        });
    });
</script>
</html>
