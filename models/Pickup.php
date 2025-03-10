<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pickup".
 *
 * @property int $id
 * @property string $address
 * @property string $work_from
 * @property string $work_to
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
            [['address', 'work_from', 'work_to'], 'required'],
            [['work_from', 'work_to'], 'safe'],
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
            'work_from' => 'Work From',
            'work_to' => 'Work To',
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
