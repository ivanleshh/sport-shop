<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $photo
 * @property string $title
 * @property string $description
 * @property int|null $parent_id
 *
 * @property Category[] $categories
 * @property CategoryProperty[] $categoryProperties
 * @property Category $parent
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    const IMG_PATH = '/images/categories/';
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            ['photo', 'safe'],
            [['description'], 'string'],
            [['parent_id'], 'integer'],
            [['photo', 'title'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parent_id' => 'id']],

            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'imageFile' => 'Фото категории',
            'title' => 'Title',
            'description' => 'Description',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[CategoryProperties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryProperties()
    {
        return $this->hasMany(CategoryProperty::class, ['category_id' => 'id']);
    }

    public function getProperties()
    {
        return $this->hasMany(Property::class, ['id' => 'property_id'])->viaTable('category_property', ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    // Возвращает информацию о дочерних категориях данной категории
    public function getChildren()
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id']);
    }

    public static function getAllCategories()
    {
        return self::find()
            ->select('title')
            ->indexBy('id')
            ->column();
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = Yii::$app->user->id
                . '_'
                . time()
                . '_'
                . Yii::$app->security->generateRandomString()
                . '.'
                . $this->imageFile->extension;
            $this->imageFile->saveAs('images/categories/' . $fileName);
            $this->photo = $fileName;
            return true;
        } else {
            return false;
        }
    }
}
