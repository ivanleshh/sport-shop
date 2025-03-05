<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $title
 * @property string $color
 *
 * @property Orders[] $orders
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'color'], 'required'],
            [['title', 'color'], 'string', 'max' => 255],
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
            'color' => 'Color'
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['status_id' => 'id']);
    }

    // Метод для получения id статуса по его заголовку
    public static function getStatusId($title): int|null
    {
        return self::findOne(compact('title'))->id;
    }

    public static function getStatuses()
    {
        return self::find()
                    ->select('title')
                    ->indexBy('id')
                    ->column();
    }
}
