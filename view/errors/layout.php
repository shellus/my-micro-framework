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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?=$title?> <small> <?=$message?> </small></h1>
            </div>
            <?=$body?>
        </div>
    </div>

</div>
</body>
</html>