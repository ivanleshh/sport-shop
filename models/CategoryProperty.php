<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_property".
 *
 * @property int $id
 * @property int $category_id
 * @property int $property_id
 * 
 * @property Category $category
 * @property Property $property
 */
class CategoryProperty extends \yii\db\ActiveRecord
{
    public $property_title;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['property_title'], 'string', 'max' => 255],
            [
                ['property_title'],
                'unique',
                'targetClass' => Property::class,
                'targetAttribute' => 'title',
                'message' => 'Характеристика с таким названием уже существует',
            ],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['property_title']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'property_id' => 'Характеристика',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }
}
