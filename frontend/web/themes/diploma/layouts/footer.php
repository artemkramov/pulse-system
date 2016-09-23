<?
use common\modules\i18n\Module;
use yii\helpers\Url;

?>
<footer class="footer">
    <section>
        <div class="footer-content">
            <div class=""></div>
            <div class="vc_row wpb_row vc_row-fluid footer-menu-wrapper">
                <div class="wpb_column vc_column_container vc_col-sm-8">
                    <div class="vc_row wpb_row vc_row-fluid footer-links-title-wrap">
                        <div class="wpb_column vc_column_container vc_col-sm-12">
                            <div
                                class="footer-links-title vc_toggle vc_toggle_square vc_toggle_color_default  vc_toggle_size_sm">
                                <?= Module::t('Useful Information') ?>
                                <i class="vc_toggle_icon footer-menu-icon"></i>
                            </div>
                        </div>
                    </div>
                    <?= \frontend\widgets\MenuFooterWidget::widget() ?>
                </div>
                <div class="wpb_column vc_column_container vc_col-sm-4">
                    <div
                        class="footer-links-title vc_toggle vc_toggle_square vc_toggle_color_default  vc_toggle_size_sm">
                        <?= Module::t('Stay in touch') ?>
                    </div>
                    <?= \yii\helpers\Html::beginForm(\Yii::$app->user->isGuest ?
                        Url::to('/' . \common\models\Lang::getCurrent()->url . '/cabinet/default/signup')
                        : Url::to('/' . \common\models\Lang::getCurrent()->url . '/cabinet/account/profile'), 'get', [

                    ]); ?>
                    <div class="form-container">
                        <? $inputName = Yii::$app->user->isGuest ? 'SignupForm[email]' : 'Profile[email]'; ?>
                        <? if (!Yii::$app->user->isGuest) {
                            echo \yii\helpers\Html::hiddenInput('Profile[subscription]', 1);
                        } ?>
                        <?= \yii\helpers\Html::textInput($inputName, '', [
                            'class'       => 'form-input form-input-subscribe',
                            'placeholder' => Module::t('Sign up for news'),
                            'type'        => 'email',
                            'required'    => true,
                        ]) ?>
                        <?= \yii\helpers\Html::submitInput('', [
                            'class'       => 'email-submit invalid icon-arrow_right-active',
                        ])?>
                    </div>
                    <?= \yii\helpers\Html::endForm(); ?>
                </div>

            </div>
            <div class="copyright">
                <span>© <?= date('Y') . ' ' . \Yii::$app->name ?></span>
            </div>
        </div>
    </section>
</footer>