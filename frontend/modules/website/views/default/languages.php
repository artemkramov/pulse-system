<?

use common\modules\i18n\Module;
use common\models\Lang;

/**
 * @var \common\models\Lang[] $languages
 * @var Lang $currentLanguage
 */



$currentLanguage = Lang::getCurrent();


?>
<div class="js-target-container header-overlay overlay-language overlay-block">
    <div class="header-drop-down">
        <div class="content-container">
            <div class="inner-container">
                <ol class="language-list">
                    <? foreach ($languages as $language): ?>
                        <li class="js-language" data-iso="">
                            <input type="radio" id="language-<?= $language->id ?>" name="selLanguage" class="input-country" value="<?= $language->url ?>" />
                            <label for="language-<?= $language->id ?>"><?= $language->name ?></label>
                        </li>
                    <? endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
</div>