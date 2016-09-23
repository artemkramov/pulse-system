<?
$this->title = \Yii::$app->name;
?>
<!-- article -->
<article id="post-<?= $post->id ?>" class="post-<?= $post->id ?> page type-page status-publish hentry post-main">
    <div id="slider-wrapper">
        <div class="owl-carousel" id="owl">
            <?
            $slider = $extraData['slider'];
            foreach ($slider->sliderItems as $item):?>
                <div style="background-image: url(<?= \yii\helpers\Url::base() . $item->image
                ?>)" class="slider-item">
                    <? if (!empty($item->url)) {
                        echo \yii\helpers\Html::a('',  \frontend\components\FrontendUrl::to($item->url));
                    } ?>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</article>
<!-- /article -->