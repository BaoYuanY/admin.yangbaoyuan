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
        这都被你发现了   <a class="nav-link active" href="/password/index/add">添加账号</a>
    </div>

    <br>

    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">请输入平台</label>
            <input type="text" class="form-control" name="platform" aria-describedby="请输入对应平台" required>
            <small id="text" class="form-text text-muted">支持模糊搜索</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">请输入账号</label>
            <input type="text" class="form-control" name='account' autocomplete="off" required>
            <small id="text" class="form-text text-muted">支持模糊搜索</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">查询密码</label>
            <input type="password" class="form-control" name="salt" autocomplete="off" required>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary">查询</button>
    </form>


    <br>
    <br>

    <div id="table-container"></div>
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
                    // 构建表头
                    let table = `
                          <table class="table">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">平台</th>
                                <th scope="col">账号绑定手机号</th>
                                <th scope="col">绑定邮箱</th>
                                <th scope="col">密码</th>
                                <th scope="col">其他</th>
                              </tr>
                            </thead>
                            <tbody>
                        `;

                    // 添加表格内容
                    response.data.forEach(item => {
                        table += `
                            <tr>
                              <th>${item.platform}</th>
                              <th>${item.phone}</th>
                              <th>${item.email}</th>
                              <th>${item.password}</th>
                              <th>${item.salt}</th>
                            </tr>
                          `;
                                        });

                    // 关闭表格标签
                    table += `
                            </tbody>
                          </table>
                        `;
                    // 将表格插入到指定容器中
                    $('#table-container').html(table);
                },
                error: function(xhr, status, error) {
                    //location.reload()
                }
            });
        });
    });
</script>
</html>
