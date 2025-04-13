<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property int $category_id
 * @property int $count
 * @property int $brand_id
 *
 * @property Brand $brand
 * @property CartItem[] $cartItems
 * @property Category $category
 * @property Comment[] $comments
 * @property OrderItem[] $orderItems
 */
class Product extends \yii\db\ActiveRecord
{
    const IMG_PATH = '/images/products/';
    const NO_PHOTO = '/images/noPhoto.jpg';
    public $imageFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'price', 'category_id', 'brand_id'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            ['count', 'default', 'value' => 0],
            [['category_id', 'count', 'brand_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],

            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, webp, jpeg', 'maxFiles' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
            'category_id' => 'Категория',
            'count' => 'Количество',
            'brand_id' => 'Бренд',
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
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
     * Gets query for [[ProductProperties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductProperties()
    {
        return $this->hasMany(ProductProperty::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[CompareProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompareProducts()
    {
        return $this->hasMany(CompareProducts::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[FavouriteProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavouriteProducts()
    {
        return $this->hasMany(FavouriteProducts::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    public function getCountReviews()
    {
        $count = 0;
        foreach ($this->reviews as $review) {
            if (isset($review->stars)) {
                $count++;
            }
        }
        return $count;
    }

    // Метод, определяющий среднюю оценку товара по оценкам в отзывах клиентов
    public function getMediumStars()
    {
        $result = 0;
        $count = 0;
        $arrayStars = [];
        if ($reviews = $this->reviews) {
            foreach ($reviews as $review) {
                if (isset($review->stars)) {
                    $arrayStars[] = $review->stars;
                    $count++;
                }
            }
            $result = round(array_sum($arrayStars) / $count, 2);
        }
        return $result;
    }
}
