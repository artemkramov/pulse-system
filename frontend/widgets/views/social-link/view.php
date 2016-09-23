<div class="social-icons">
    <? foreach ($links as $link): ?>
        <a href="<?= $link->url ?>" target="_blank" title="<?= $link->name ?>" class="social-icons__<?= $link->alias ?>"></a>
    <? endforeach; ?>
</div>