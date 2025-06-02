<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compare_products".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $status
 *
 * @property Product $product
 * @property User $user
 */
class CompareProducts extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compare_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 0],
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id', 'status'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function getCountAdded()
    {
        return self::find()->where(['user_id' => Yii::$app->user->id, 'status' => 1])->count();
    }

    // Метод для получения сгруппированных товаров, добавленных в избранное
    public static function getGroupedProducts($dataProvider)
    {
        $groupedProducts = [];
        foreach ($dataProvider->models as $compareProduct) {
            if ($compareProduct->product && $compareProduct->product->category) {
                $category_id = $compareProduct->product->category->id;
                $groupedProducts[$category_id][] = $compareProduct;
            }
        }
        return $groupedProducts;
    }

    // Метод для получения сгруппированных характеристик товаров, добавленных в избранное
    public static function getGroupedProperties($groupedProducts)
    {
        $properties = [];
        foreach ($groupedProducts as $products) {
            foreach ($products as $compareProduct) {
                $productProperties = ProductProperty::find()->where(['product_id' => $compareProduct->product_id])->joinWith('property')->all();
                foreach ($productProperties as $prop) {
                    $properties[$compareProduct->product_id][$prop->property->title] = $prop->property_value;
                }
            }
        }
        return $properties;
    }
}
