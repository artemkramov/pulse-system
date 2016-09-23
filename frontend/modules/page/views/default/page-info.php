<?php
/**
 * @var \common\models\Post $post
 * @var array $extraData
 */
\frontend\components\SeoHelper::setTitle($this, [
    'type' => 'post'
], $post);
?>
<!-- article -->
<article id="post-<?= $post->id ?>" class="post-<?= $post->id ?> page type-page status-publish hentry">
    <?= $post->content ?>
    <div class="vc_row wpb_row vc_row-fluid">
        <div class="wpb_column vc_column_container vc_col-sm-12">
            <? foreach ($extraData['posts'] as $subPost): ?>
            <div class="vc_toggle vc_toggle_square vc_toggle_color_default  vc_toggle_size_sm">
                <div class="vc_toggle_title">
                    <h4><?= mb_strtoupper($subPost->title, 'UTF-8'); ?></h4>
                    <i class="vc_toggle_icon"></i>
                </div>
                <div class="vc_toggle_content">
                    <?= $subPost->content; ?>
                </div>
            </div>
            <? endforeach; ?>
            <div class="vc_toggle vc_toggle_square vc_toggle_color_default  vc_toggle_size_sm where-to-buy">
                <div class="vc_toggle_title">
                    <h4><?= mb_strtoupper(\common\modules\i18n\Module::t('Where to buy'), 'UTF-8'); ?></h4>
                    <i class="vc_toggle_icon"></i>
                </div>
                <div class="vc_toggle_content">
                    <div>
                        <? foreach ($extraData['stocks'] as $stock): ?>
                            <div>
                                <h3 class="partner-title"><?= $stock->title ?></h3>
                                <div class="partner-content">
                                    <?= $stock->content ?>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
<!-- /article -->
