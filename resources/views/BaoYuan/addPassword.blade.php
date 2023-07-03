<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://baoyuan-one.oss-cn-shanghai.aliyuncs.com/password.png" sizes="32x32" type="image/png">
    <script src="/js/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title>ADD-PASSWORD</title>
</head>
<style>
    .btn-sm {
        margin-bottom: 10px;
    }
</style>
<body>
<div class="container">
    <br>
    <div class="alert alert-danger" role="alert">
        这都被你发现了 <a class="nav-link active" href="/pwd">查询账号</a>
    </div>

    <h3>随机生成密码</h3>
    <div class="form-row align-items-center">
        <div class="col-auto">
            <label class="sr-only" for="inlineFormInputGroup"></label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">请输入密码长度</div>
                </div>
                <input type="number" class="form-control" id="length" min="1" value="8" placeholder="密码长度">
            </div>
        </div>
    </div>
    <button onclick="generatePassword()" class="btn btn-primary btn-sm">生成全字符密码</button>
    <button onclick="generatePassword1()" class="btn btn-primary btn-sm">生成大小写字母加数字密码</button>
    <button onclick="copyPassword()" class="btn btn-primary btn-sm">复制密码</button>
    <br>
    <br>

    <textarea id="password" rows="2" cols="30" readonly></textarea>


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

    <div id="alertBox" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #09C7F7; border: 1px solid #f5c6cb; padding: 20px; color: #721c24; border-radius: 5px; text-align: center;">
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
                url: '/pwd/add', // 服务器端的接收URL
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
    function generatePassword() {
        var lengthInput = document.getElementById("length");
        var length = parseInt(lengthInput.value);

        var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        var password = '';
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * charset.length);
            password += charset[randomIndex];
        }

        var passwordInput = document.getElementById("password");
        passwordInput.value = password;
    }
    function generatePassword1() {
        var lengthInput = document.getElementById("length");
        var length = parseInt(lengthInput.value);

        var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var password = '';
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * charset.length);
            password += charset[randomIndex];
        }

        var passwordInput = document.getElementById("password");
        passwordInput.value = password;
    }

    function copyPassword() {
        var passwordInput = document.getElementById("password");
        passwordInput.select();
        document.execCommand("copy");
    }
</script>
</html>
