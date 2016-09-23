<?

use common\modules\i18n\Module;
use common\models\Lang;

/**
 * @var \common\models\Country[] $countries
 * @var Lang $currentLanguage
 */

$currentLanguage = Lang::getCurrent();
$fieldName = 'title_' . $currentLanguage->url;

?>
<div class="js-target-container header-overlay overlay-country overlay-block">
    <div class="header-drop-down">
        <div class="content-container">
            <div class="inner-container">
                <form method="post" action="<?= \yii\helpers\Url::to('/website/default/change-country') ?> ">
                    <ol class="country-list">
                        <? foreach ($countries as $country): ?>
                            <li class="js-country" data-iso="">
                                <input type="radio" id="country-<?= $country->id ?>" name="selCountry" class="input-country" value="<?= $country->id ?>" />
                                <label for="country-<?= $country->id ?>"><?= $country->{$fieldName} ?></label>
                            </li>
                        <? endforeach; ?>
                    </ol>
                </form>
            </div>
        </div>
    </div>
</div>