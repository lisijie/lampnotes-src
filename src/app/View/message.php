<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>提示信息</title>
</head>
<body style="background:#f0f0f0;text-align:center;font-family:Verdana;">
<div style="background:#fff;width:500px;margin:50px auto;font-size:14px;">
    <h1 style="font-size:14px;padding:8px;background:#CF682D;color:#ffffff;">提示信息</h1>
    <div style="text-align:left;padding:8px;"><?=$msg?></div>
    <div style="padding:8px;"><a href="<?=($redirect ? : '/')?>">如果您的浏览器没自动跳转，请点击这里</a></div>
</div>
</body>
</html>