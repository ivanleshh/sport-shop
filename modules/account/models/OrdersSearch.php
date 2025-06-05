<?php

namespace app\modules\account\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;
use Yii;

/**
 * OrdersSearch represents the model behind the search form of `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_pay_id', 'pick_up_id', 'product_amount', 'status_id', 'user_id'], 'integer'],
            [['name', 'email', 'phone', 'address', 'date_delivery', 'time_delivery', 'comment', 'created_at', 'updated_at', 'delay_reason', 'new_date_delivery'], 'safe'],
            [['total_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = Orders::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with(['pickUp', 'status', 'orderItems']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type_pay_id' => $this->type_pay_id,
            'pick_up_id' => $this->pick_up_id,
            'date_delivery' => $this->date_delivery,
            'time_delivery' => $this->time_delivery,
            'total_amount' => $this->total_amount,
            'product_amount' => $this->product_amount,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'new_date_delivery' => $this->new_date_delivery,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'delay_reason', $this->delay_reason]);

        return $dataProvider;
    }
}
