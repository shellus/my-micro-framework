<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$title?></title>
    <link href="bootstrap-3.3.0-dist/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="jquery-2.2.4/dist/jquery.min.js"></script>
    <script src="bootstrap-3.3.0-dist/dist/js/bootstrap.min.js"></script>
</head>
<body>
<?php require 'nav.php'?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">.col-md-1</div>
        <div class="col-md-10">
            <?=$body?>
        </div>
    </div>

</div>

</body>
</html>