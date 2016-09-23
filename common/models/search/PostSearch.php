<?php

namespace common\models\search;

use common\models\Lang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'enabled'], 'integer'],
            [['created_at'], 'safe'],
            ['title', 'string']
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
        $query = Post::find();

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
            'id'         => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'enabled'    => $this->enabled,
        ]);

        /**
         * Filtering by the multilingual fields
         */
        $query->join('left join', $this->tableLang, $this->tableLang . '.post_id = ' . self::tableName() . '.id');

        $query->andFilterWhere([
            'like', 'title', $this->title,
        ])->andFilterWhere([
            'like', 'language', Lang::getCurrent()->url
        ]);

        return $dataProvider;
    }
}
