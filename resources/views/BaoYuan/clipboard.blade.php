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
    <div class="alert alert-info" role="alert">
        <a class="nav-link active" href="/clipboard/add">添加内容</a>
    </div>
{{--    <button style="display: none" id="pwa" type="button" class="btn btn-dark" onclick="pwaEvent.prompt()">安装应用</button>--}}
{{--    <script>--}}
{{--        let pwaEvent = null--}}
{{--        window.addEventListener('beforeinstallprompt', e => {--}}
{{--            pwaEvent = e--}}
{{--            pwa.style.display = 'block'--}}
{{--        })--}}
{{--    </script>--}}
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">内容</th>
            <th scope="col">创建时间</th>
            <th scope="col">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clipboards as $clipboard)
            <tr>
                <th scope="row"> {{$clipboard->id}} </th>
                <td class="content">{{$clipboard->content}}</td>
                <td> {{$clipboard->created_at}} </td>
                <td><button type="button" class="btn btn-success copy-btn">复制</button>
                    <button type="button" class="btn btn-danger delete-btn" data-id="{{$clipboard->id}}">删除</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.copy-btn').click(function() {
            let content = $(this).closest('tr').find('.content').text().trim();
            let temp = $('<textarea>');
            $('body').append(temp);
            temp.val(content).select();
            document.execCommand('copy');
            temp.remove();
        });

        $('.delete-btn').click(function() {
            let clipboardId = $(this).data('id');
            let row = $(this).closest('tr');
            row.remove();
            $.ajax({
                url: `/clipboard/${clipboardId}`, // 这里应该是您的删除API的URL
                type: 'DELETE', // 如果您的API使用的是DELETE请求，否则更改为所需的类型
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                },
                error: function() {

                }
            });
        });
    });
</script>
</body>
</html>
