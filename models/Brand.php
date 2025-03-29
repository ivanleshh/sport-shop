<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $photo
 * @property string $title
 *
 * @property Product[] $products
 */
class Brand extends \yii\db\ActiveRecord
{
    const IMG_PATH = '/images/brands/';
    const NO_PHOTO = '/images/noPhoto.jpg';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo', 'title'], 'required'],
            [['photo', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'photo' => 'Логотип',
            'title' => 'Название',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['brand_id' => 'id']);
    }
}
