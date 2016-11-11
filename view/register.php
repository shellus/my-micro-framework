<?php $this -> set('title', '注册');?>
<?php $layout = 'layout';?>



<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">注册</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="">

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">登录账号</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="" required autofocus>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">邮箱</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="" required>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">密码</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">确认密码</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                注册
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>