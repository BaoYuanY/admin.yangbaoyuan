<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://baoyuan-blog.oss-cn-shanghai.aliyuncs.com/upload.png" sizes="32x32" type="image/png">
    <script src="/js/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title>UPLOAD</title>
</head>
<body>
<div class="container">
    <br>
    <form method="post" action="/upload/save" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="input-group is-invalid">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="validatedInputGroupSelect">请选择上传平台</label>
                </div>
                <select name="type" class="custom-select" id="validatedInputGroupSelect" required>
                    @foreach($select as $key => $item)
                        <option value={{ $key }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text">请输入文件名称</div>
            </div>
            <input name="name" autocomplete="off" type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="默认为上传时的名称">
        </div>

        <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" name="file" id="validatedCustomFile" required>
            <label class="custom-file-label" for="validatedCustomFile">请选择文件</label>
        </div>
        <button type="submit" class="btn btn-primary" id="liveToastBtn">上传</button>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('#validatedCustomFile').on('change', function(){
            var fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').html(fileName);
        });
    });
</script>
</body>
</html>
