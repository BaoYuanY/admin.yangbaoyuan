<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://baoyuan-one.oss-cn-shanghai.aliyuncs.com/password.png" sizes="32x32" type="image/png">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">--}}
    <script src="/js/jquery-3.7.0.js"></script>
    <link href="/css/select2.min.css" rel="stylesheet" />
    <script src="/js/select2.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title>PASSWORD</title>
</head>
<style>
    th {
        cursor: pointer;
    }
</style>
<body>
<div class="container">
    <br>
    <div class="alert alert-danger" role="alert">
        这都被你发现了   <a class="nav-link active" href="/pwd/add">添加账号</a>
    </div>

    <br>

    <form>
        <div class="form-group">
            <label for="platformSelect">请选择平台</label>
            <select class="form-control" id="platformSelect" name="platform" style="width: 100%;">
                <!-- 通过 loadPlatforms() 函数动态生成平台选项 -->
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">请输入账号</label>
            <input type="text" value="" class="form-control" name='account' autocomplete="off">
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
    function loadPlatforms() {
        $.ajax({
            url: '/pwd/getPlatforms', // 服务器端获取平台数据的地址
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const platformSelect = $('#platformSelect');

                // 遍历 JSON 数组中的每个平台，创建一个新的 option 元素并添加到选择框
                data.data.forEach(function(platform) {
                    const option = $('<option></option>')
                        .attr('value', platform.id)
                        .text(platform.name);
                    platformSelect.append(option);
                });

                // 当内容加载完毕后重新初始化 Select2
                platformSelect.select2({
                    placeholder: "请选择平台",
                    allowClear: true
                });
            },
            error: function() {
                console.error('Error fetching platforms.');
            }
        });
    }
    $(document).ready(function() {
        loadPlatforms();
        $('.select2').select2({
            placeholder: "请选择平台",
            allowClear: true
        });
        $('form').on('submit', function(e) {
            // 防止表单的默认提交行为
            e.preventDefault();
            // 收集表单数据
            const formData = $(this).serialize();

            // 使用 AJAX 发送表单数据
            $.ajax({
                url: '/pwd/search', // 服务器端的接收URL
                type: 'POST', // 提交表单的HTTP方法
                data: formData, // 发送表单的数据
                dataType: 'json', // 预期从服务器返回的数据类型
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, // 添加 CSRF 令牌头
                success: function(response) {
                    if (response.data == null) {
                        $('#table-container').html('无');
                        return;
                    }

                    // 构建表头
                    let table = `
                          <table class="table">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">平台</th>
                                <th scope="col">账号</th>
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
                              <th data-value=${item.platform}>${item.platform}</th>
                              <th data-value=${item.account}>${item.account}</th>
                              <th data-value=${item.phone}>${item.phone}</th>
                              <th data-value=${item.email}>${item.email}</th>
                              <th data-value=${item.copy}>${item.encryptPassword}</th>
                              <th data-value=${item.salt}>${item.salt}</th>
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

                    // 获取所有表格单元格
                    const tds = document.querySelectorAll('th');

                    // 为每个单元格添加点击事件监听器
                    tds.forEach(td => {
                        td.addEventListener('click', () => {
                            // 获取要复制的值
                            const value = td.getAttribute('data-value');

                            // 创建一个临时输入元素并将要复制的值设置为其值
                            const tempInput = document.createElement('input');
                            tempInput.value = value;
                            document.body.appendChild(tempInput);

                            // 选中并复制临时输入元素的值
                            tempInput.select();
                            document.execCommand('copy');

                            // 移除临时输入元素
                            document.body.removeChild(tempInput);

                        });
                    });

                },
                error: function(xhr, status, error) {
                    //location.reload()
                }
            });
        });
    });
</script>
</html>
