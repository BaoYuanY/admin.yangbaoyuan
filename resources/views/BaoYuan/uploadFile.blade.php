<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://baoyuan-blog.oss-cn-shanghai.aliyuncs.com/upload.png" sizes="32x32" type="image/png">
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">--}}
    <script src="/js/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title>UPLOAD</title>
</head>
<body>
<div class="container">
    <br>
    <form>
        <div class="mb-3">
            <div class="input-group is-invalid">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="validatedInputGroupSelect">请选择上传平台</label>
                </div>
                <select class="custom-select" id="validatedInputGroupSelect" required>
                    <option value="1">七牛云</option>
                    <option value="2">阿里云</option>
                    <option value="3">腾讯云</option>
                </select>
            </div>
        </div>

        <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" name="file" id="validatedCustomFile" required>
            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
            <div class="invalid-feedback">Example invalid custom file feedback</div>
        </div>
    </form>
</div>
</body>
</html>
