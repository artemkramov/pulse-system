<?php

namespace common\models\Search;

use backend\components\AccessHelper;
use common\models\Customer;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Threat;

/**
 * ThreatSearch represents the model behind the search form about `common\models\Threat`.
 */
class ThreatSearch extends Threat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'bpm'], 'integer'],
            [['created_at', 'alias'], 'safe'],
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
        $query = Threat::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'                               => $this->id,
            self::tableName() . '.customer_id' => $this->customer_id,
            'created_at'                       => $this->created_at,
            'bpm'                              => $this->bpm,
        ]);

        if (!User::isAdmin()) {
            $accessHelper = new AccessHelper();
            $customers = $accessHelper->getFilter();
            $query->andWhere([
                'in', self::tableName() . '.customer_id', $customers
            ]);
        }

        $query->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
