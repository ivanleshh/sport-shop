<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pickup".
 *
 * @property int $id
 * @property string $address
 *
 * @property Orders[] $orders
 */
class Pickup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pickup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address'], 'required'],
            [['address'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['pick_up_id' => 'id']);
    }

    public static function getPickups()
    {
        return self::find()
                    ->select('address')
                    ->indexBy('id')
                    ->column();
    }
}
