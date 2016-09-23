<div class="wpb_column vc_column_container vc_col-sm-6">
    <ul class="footer-list">
        <? foreach ($menuCollection as $menu): ?>
            <? if (!$menu['enabled']) continue; ?>
            <li>
                <? $item = \common\models\Menu::findOne($menu['id']); ?>
                <a href="<?= $item->getUrl() ?>" class="footer-link">
                    <?= $menu['title'] ?>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
</div>