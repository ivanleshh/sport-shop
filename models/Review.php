<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $text
 * @property string|null $stars
 * @property int|null $parent_id
 * @property string $created_at
 *
 * @property Review $parent
 * @property Product $product
 * @property Review[] $reviews
 * @property User $user
 */
class Review extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STARS_1 = '1';
    const STARS_2 = '2';
    const STARS_3 = '3';
    const STARS_4 = '4';
    const STARS_5 = '5';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stars', 'parent_id'], 'default', 'value' => null],
            [['user_id', 'product_id', 'text'], 'required'],
            [['user_id', 'product_id', 'parent_id'], 'integer'],
            [['text', 'stars'], 'string'],
            [['created_at'], 'safe'],
            ['stars', 'in', 'range' => array_keys(self::optsStars())],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'text' => 'Text',
            'stars' => 'Stars',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Review::class, ['id' => 'parent_id']);
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
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['parent_id' => 'id']);
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


    /**
     * column stars ENUM value labels
     * @return string[]
     */
    public static function optsStars()
    {
        return [
            self::STARS_1 => '1',
            self::STARS_2 => '2',
            self::STARS_3 => '3',
            self::STARS_4 => '4',
            self::STARS_5 => '5',
        ];
    }

    /**
     * @return string
     */
    public function displayStars()
    {
        return self::optsStars()[$this->stars];
    }

    /**
     * @return bool
     */
    public function isStars1()
    {
        return $this->stars === self::STARS_1;
    }

    public function setStarsTo1()
    {
        $this->stars = self::STARS_1;
    }

    /**
     * @return bool
     */
    public function isStars2()
    {
        return $this->stars === self::STARS_2;
    }

    public function setStarsTo2()
    {
        $this->stars = self::STARS_2;
    }

    /**
     * @return bool
     */
    public function isStars3()
    {
        return $this->stars === self::STARS_3;
    }

    public function setStarsTo3()
    {
        $this->stars = self::STARS_3;
    }

    /**
     * @return bool
     */
    public function isStars4()
    {
        return $this->stars === self::STARS_4;
    }

    public function setStarsTo4()
    {
        $this->stars = self::STARS_4;
    }

    /**
     * @return bool
     */
    public function isStars5()
    {
        return $this->stars === self::STARS_5;
    }

    public function setStarsTo5()
    {
        $this->stars = self::STARS_5;
    }
}
