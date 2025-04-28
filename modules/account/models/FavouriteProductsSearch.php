<?php

namespace app\modules\account\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FavouriteProducts;
use Yii;

/**
 * FavouriteProductsSearch represents the model behind the search form of `app\models\FavouriteProducts`.
 */
class FavouriteProductsSearch extends FavouriteProducts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = FavouriteProducts::find()->where(['user_id' => Yii::$app->user->id])->joinWith([
            'product' => fn($q) => $q->joinWith('category'),
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => Yii::$app->user->id,
            'product_id' => $this->product_id,
            'status' => 1,
        ]);

        return $dataProvider;
    }
}
