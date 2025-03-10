<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property string $title
 *
 * @property CategoryProperty[] $categoryProperties
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['title','unique', 'targetClass' => self::class, 'message' => 'Характеристика уже существует'],
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
     * Gets query for [[CategoryProperties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryProperties()
    {
        return $this->hasMany(CategoryProperty::class, ['property_id' => 'id']);
    }
}
