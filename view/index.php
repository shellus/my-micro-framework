<?php $title = '首页';?>
<?php $layout = 'layout';?>
<h1>我是<?=$name?></h1>

<ul>
    <?php foreach ($articles as $article):?>
    <li>
        <a>
            <?=$article->title?>
        </a>
    </li>
    <?php endforeach;?>
</ul>