<?
\frontend\components\SeoHelper::setTitle($this, [
    'type' => 'post'
], $post);
$templateContactForm = '[contact-form]';
?>
<!-- article -->
<article id="post-<?= $post->id ?>"
         class="post-<?= $post->id ?> page type-page status-publish hentry <?= $post->alias ?>">
    <?
    $content = $post->content;
    $form = $this->render('templates/contact-form', [
        'model' => $contactForm
    ]);
    $content = str_replace($templateContactForm, $form, $content);
    echo $content;
    ?>
</article>
<!-- /article -->