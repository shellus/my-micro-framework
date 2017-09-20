<?php
/**
 * Semantic UI
 * Includes previous and next buttons
 * @example $pages->links('pagination-advanced', ['paginator' => $pages])
 * @example @include('pagination-advanced', ['paginator' => $pages])
 *
 * @link https://semantic-ui.com/collections/menu.html#inverted Inverted styles
 * @see <div class="ui pagination inverted blue menu"> Inverted blue menu
 **/
/** @var \Sh\Page $paginator */
?>
<?php if ($paginator->hasPages()): ?>
    <div class="ui pagination menu">
        <?php if ($paginator->onFirstPage()): ?>
            <a class="item disabled"><span>&laquo;</span></a>
        <?php else: ?>
            <a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
        <?php endif; ?>
        <!-- Array Of Links -->
        <?php foreach ($elements as $element): ?>
            <?php if (is_array($element)): ?>
                <?php foreach ($element as $page => $url): ?>
                    <?php if ($page == $paginator->currentPage()): ?>
                        <a class="item active" href="<?=$url?>"><?=$page?></a>
                    <?php else: ?>
                        <a class="item" href="<?=$url?>"><?=$page?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Next Page Link -->
        <?php if ($paginator->hasMorePages()): ?>
            <a class="item" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
        <?php else: ?>
            <a class="item disabled"><span>&raquo;</span></a>
        <?php endif; ?>
    </div>
<?php endif; ?>