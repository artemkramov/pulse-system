<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/6/2016
 * Time: 11:48 AM
 */

namespace frontend\components;
use backend\models\Product;
use common\models\Lang;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class SearchSite
 * @package frontend\models
 */
class SearchSite
{

    /**
     * @var \phpMorphy
     */
    private $phpMorphy;

    /**
     * SearchSite constructor.
     * @param null $languageLocal
     */
    public function __construct($languageLocal = null)
    {
        require_once __DIR__ . '/phpmorphy/src/common.php';
        $dictionaryPath = __DIR__ . '/phpmorphy/dicts';
        $lang = $languageLocal;
        $this->phpMorphy = new \phpMorphy($dictionaryPath, $lang, [
            'storage' => PHPMORPHY_STORAGE_FILE,
        ]);
    }

    /**
     * @param $keywords
     * @return array
     */
    public function word2BaseForm($keywords)
    {
        $words = preg_split('#\s|[,.:;!?"\'()]#', $keywords, -1, PREG_SPLIT_NO_EMPTY);
        $bulkWords = array();
        foreach ($words as $word) {
            if (strlen($word) > 2) {
                $bulkWords[] = mb_strtoupper($word, 'UTF-8');
            }
        }
        $baseForm = $this->phpMorphy->getBaseForm($bulkWords);
        $fullList = [];
        if (is_array($baseForm) && count($baseForm)) {
            foreach ($baseForm as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $v1) {
                        if (strlen($v1) > 2) {
                            $fullList[$v1] = 1;
                        }
                    }
                }
            }
        }
        $words = join(' ', array_keys($fullList));
        return $words;
    }

    /**
     * @param $keywords
     * @return array
     */
    public function word2AllForms($keywords)
    {
        $words = preg_split('#\s|[,.:;!?"\'()]#', $keywords, -1, PREG_SPLIT_NO_EMPTY);

        $bulkWords = array();
        foreach ($words as $v)
            if (strlen($v) > 2)
                $bulkWords[] = mb_strtoupper($v, 'utf-8');

        return $this->phpMorphy->getAllForms($bulkWords);
    }

    /**
     * @param $keywords
     * @return array
     */
    public function search($keywords)
    {
        /**
         * @var Lang $currentLanguage
         */
        $currentLanguage = Lang::getCurrent();
        $words = $this->word2AllForms($keywords);
        $text = '';
        foreach ($words as $keyword => $wordForms) {
            $text .= ' ';
            if (empty($wordForms)) {
                $text .= $keyword;
            }
            else {
                $text .= implode(' ', $wordForms);
            }
        }
        $text = trim($text);
        $product = new Product();
        $query = (new Query())
            ->select('*')
            ->from($product->tableLang)
            ->where(
                "MATCH(search_text) AGAINST ('" . $text . "')"
            )
            ->andWhere([
                'language' => $currentLanguage->url,
            ])
            ->all();
        $productIds = ArrayHelper::getColumn($query, 'product_id');
        return $productIds;
    }

}