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
    public $imageFile;
    const SCENARIO_CREATE = 'create';
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
            [['title'], 'required'],
            [['photo', 'title'], 'string', 'max' => 255],
            ['photo', 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

            ['imageFile', 'required', 'on' => self::SCENARIO_CREATE],
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
            'imageFile' => 'Логотип',
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

    public function upload()
    {
        if ($this->validate()) {
            $imagePath = Yii::$app->user->id . '_' . Yii::$app->security->generateRandomString()
            . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('images/brands/' . $imagePath);
            $this->photo = $imagePath;
            return true;
        } else {
            return false;
        }
    }
}
