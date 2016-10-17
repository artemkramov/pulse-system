<?php

namespace common\models\search;

use backend\components\AccessHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer as CustomerModel;

/**
 * Customer represents the model behind the search form about `common\models\Customer`.
 */
class Customer extends CustomerModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['mac_address', 'name', 'notes', 'date_registrated'], 'safe'],
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
        $query = CustomerModel::find();

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
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'date_registrated' => $this->date_registrated,
        ]);

        $query->andFilterWhere(['like', 'mac_address', $this->mac_address])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        $params = [
            'viaTable'     => Customer::TABLE_CUSTOMER_OPERATOR,
            'primaryTable' => Customer::tableName(),
            'primaryField' => 'customer_id',
            'relateField'  => 'customer_id'
        ];

        $accessHelper = new AccessHelper();
        $accessHelper->filterSearchMultiple($query, $params);

        return $dataProvider;
    }
}
