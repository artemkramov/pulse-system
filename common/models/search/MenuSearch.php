<?php

namespace common\models\search;

use common\models\Lang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Menu;

/**
 * MenuSearch represents the model behind the search form about `common\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'sort', 'parent_id', 'bean_id', 'enabled', 'menu_type_id'], 'integer'],
            [['bean_type', 'url'], 'safe'],
            [['title'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Menu::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'           => $this->id,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'sort'         => $this->sort,
            'parent_id'    => $this->parent_id,
            'bean_id'      => $this->bean_id,
            'enabled'      => $this->enabled,
            'menu_type_id' => $this->menu_type_id,
        ]);

        $query->andFilterWhere(['like', 'bean_type', $this->bean_type])
            ->andFilterWhere(['like', 'url', $this->url]);

        /**
         * Filtering by the multilingual fields
         */
        $query->join('left join', $this->tableLang, $this->tableLang . '.menu_id = ' . self::tableName() . '.id');

        $query->andFilterWhere([
            'like', 'title', $this->title,
        ])->andFilterWhere([
            'like', 'language', Lang::getCurrent()->url
        ]);

        return $dataProvider;
    }
}
