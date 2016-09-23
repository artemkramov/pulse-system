<?
\frontend\components\SeoHelper::setTitle($this, [
    'type' => 'post'
], $post);
?>
<!-- article -->
<article id="post-<?= $post->id ?>" class="post-<?= $post->id ?> page type-page status-publish hentry">
    <?= $post->content ?>
</article>
<!-- /article -->