<?

use common\modules\i18n\Module;

/**
 * @var array $menuCollection
 */

?>


<ul class="nav-links">
    <? foreach ($menuCollection as $menu): ?>
        <? if (!$menu['enabled']) continue; ?>
        <li>
            <? $item = \common\models\Menu::findOne($menu['id']); ?>
            <a href="<?= $item->getUrl() ?>" class="nav-level-1">
                <?= $menu['title'] ?>
            </a>
            <? if (array_key_exists('children', $menu)): ?>
                <div class="nav-level-2 visibility-fix template-two-lists">
                    <div class="nav-level-2-inner">
                        <div class="nav-level-2-container max-girdle-width">
                            <div class="nav-level-back"><?= Module::t('Back') ?></div>
                            <span class="line-break"></span>
                            <div class="list-container">
                                <ul class="sub-menu">
                                    <? foreach ($menu['children'] as $children): ?>
                                        <? if (!$children['enabled']) continue; ?>
                                        <li>
                                            <? $item = \common\models\Menu::findOne($children['id']); ?>
                                            <a href="<?= array_key_exists('directUrl', $children) ? $children['directUrl'] : $item->getUrl() ?>">
                                                <?= $children['title'] ?>
                                            </a>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            <? endif; ?>
        </li>
    <? endforeach; ?>
</ul>