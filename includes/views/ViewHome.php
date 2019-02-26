<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo SITE_NAME ?></title>
</head>
<body>
<h1>Home</h1>
<form action="upload" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit">
</form>
</body>
</html>