<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "typepay".
 *
 * @property int $id
 * @property string $title
 *
 * @property Orders[] $orders
 */
class Typepay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'typepay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['type_pay_id' => 'id']);
    }

    // Метод для получения id типа оплаты по его заголовку
    public static function getTypepayId($title): int|null
    {
        return self::findOne(compact('title'))->id;
    }

    public static function getTypePays()
    {
        return self::find()
                    ->select('title')
                    ->indexBy('id')
                    ->column();
    }
}
