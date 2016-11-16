<?php $layout = 'layout';?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><?=$title = "登录"?></div>
            <div class="panel-body">
                <form id="form-login" class="form-horizontal" role="form" method="POST" action="">
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">邮箱</label>

                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control" name="email" value="">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">密码</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                登录
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>