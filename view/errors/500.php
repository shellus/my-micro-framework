<?php $layout = 'errors/layout'; ?>
<?php $title = '500 Server Error'; ?>
<?php /** @var $e Exception */ ?>
异常：
<p>
    <?= pathinfo($e->getFile(), PATHINFO_BASENAME) ?>(<?= $e->getLine() ?>): <?= $e->getMessage() ?>
</p>
调用栈：
<p>
    <?= nl2br($e->getTraceAsString()) ?>
</p>
