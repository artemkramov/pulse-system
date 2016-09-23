<li
    class="qtranxs-lang-menu qtranxs-lang-menu-ru menu-item menu-item-type-custom menu-item-object-custom current-menu-parent menu-item-has-children menu-item-3800">
    <a title="<?= $current->url ?>" href="#"><?= mb_strtoupper($current->url) ?></a>
    <ul class="sub-menu">
        <? foreach ($languages as $language): ?>
            <li class="qtranxs-lang-menu-item menu-item menu-item-type-custom menu-item-object-custom">
                <a title="<?= $language->url ?>" href="<?= '/' . $language->url . \Yii::$app->getRequest()->getLangUrl()?>">
                    <?= mb_strtoupper($language->url) ?>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
</li>