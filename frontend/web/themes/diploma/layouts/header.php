<?

use common\modules\i18n\Module;
use common\models\Lang;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\FrontendHelper;

/**
 * @var \common\models\Country $currentCountry
 * @var Lang $currentLanguage
 * @var \backend\models\Currency $currentCurrency
 * @var \common\models\Address $address
 * @var string $directoryAsset
 */

$currentLanguage = Lang::getCurrent();
$countryField = 'title_' . $currentLanguage->url;
$user = Yii::$app->user;
$address = !$user->isGuest ? \common\models\User::findOne($user->id)->getAddress() : null;
/**
 * @var \common\models\Setting $setting
 */
$setting = \common\models\Setting::find()->one();

?>
<!-- HEADER -->
<div class="header-wrapper">
    <header class="girdle-header js-girdle-header">
        <div class="inner max-girdle-width">
            <div class="menu-icon js-target-container">
                <div class="side-nav-toggle js-side-nav-toggle" title="<?= Module::t('Open menu') ?>">
                    <div class="icon icon-menu_burger"></div>
                </div>
            </div>

            <!-- SITE PREFERENCES -->
            <div class="site-preferences">
                <div class="currency-language">
                    <div class="js-language">
                        <form method="post" action="<?= \yii\helpers\Url::to('/website/default/change-language') ?>">
                            <?= Html::hiddenInput('pathInfo', Yii::$app->request->pathInfo) ?>
                            <a href="#" class="overlay-link" data-group="overlay-language">
                                <?= $currentLanguage->name ?>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SITE PREFERENCES -->

            <!-- SHOPPING ICONS -->
            <div class="shopping-icons">
                <div class="inner">

                    <!-- SEARCH -->
                    <div class="site-search js-site-search">
                        <span class="search-text"><?= Module::t('Search') ?></span>
                        <div class="icon-search" aria-label="<?= Module::t('Search') ?>"></div>
                    </div>
                    <!-- END SEARCH -->

                    <!-- ACCOUNT -->
                    <?= $this->render('chunks/header-account', [
                        'address' => $address,
                        'user'    => $user,
                    ]); ?>
                    <!-- END ACCOUNT -->
                </div>
            </div>
            <!-- END SHOPPING ICONS -->

            <!-- LOGO -->
            <div class="logo-strapline">
                <div class="logo" itemscope="" itemtype="http://schema.org/Organization">
                    <meta itemprop="telephone" content="<?= $setting->phone ?>">
                    <meta itemprop="url" content="<?= Url::base(true) ?>">
                    <a href="<?= Url::base(true) . '/' . $currentLanguage->url ?>" title="<?= Yii::$app->name ?>"
                       target="_top" itemprop="name" content="<?= Yii::$app->name ?>">
                        <h2 style="margin-top: 0px"><?= Yii::$app->name ?></h2>
                    </a>
                </div>
            </div>
            <!-- END LOGO -->

        </div>
    </header>

    <!-- MENU NAVIGATION -->
    <div class="main-nav js-target-container">
        <div class="inner max-girdle-width">
            <div class="nav-links-container">
                <?= \frontend\widgets\MenuTopWidget::widget(); ?>

                <!-- STANDARD SEARCH -->
                <div class="nav-search">
                    <form class="searchbox" autocomplete="off" action="<?= FrontendHelper::formLink('/search') ?>" method="get">
                        <input type="search" onfocus="this.placeholder = '<?= Module::t('Search') ?>'"
                               onblur="this.placeholder = ''"
                               name="keywords" class="searchbox-input" required>
                        <span class="searchbox-icon icon-search"></span>
                    </form>
                </div>
                <!-- END STANDARD SEARCH -->

                <div class="profile-mobile">
                    <?= $this->render('chunks/header-account', [
                        'address' => $address,
                        'user'    => $user,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END MENU NAVIGATION -->

    <!-- MOBILE SEARCH FORM -->
    <form role="search" method="get" class="mobile-product-search" action="<?= FrontendHelper::formLink('/search') ?>">
        <!--label class="screen-reader-text" for="s"></label-->

        <input class="search-field" placeholder="<?= Module::t('Search') ?>" value="" name="keywords"
               title="<?= Module::t('Search') ?>" type="search">
        <input style="position: absolute; right: -99999px" value="<?= Module::t('Search') ?>" type="submit">
        <button class="close">
            <span class="close-line"></span>
            <span class="close-line"></span>
        </button>
    </form>
    <!-- END MOBILE SEARCH FORM -->

</div>

<!-- MODAL WINDOW -->
<div class="">
    <?= $this->render('chunks/modal') ?>
</div>
<!-- END MODAL WINDOW -->

<div>
    <? $javascriptLabels = \common\models\Lang::getJavascriptLabels();?>
</div>

<script type="text/javascript">
    var siteUrl = '<?= Yii::$app->request->hostInfo . '/' . \common\models\Lang::getCurrent()->url ?>';
    var javascriptJSONLabels = '<?= json_encode($javascriptLabels) ?>';
</script>
<!-- END HEADER -->