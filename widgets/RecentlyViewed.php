<?php

namespace app\widgets;

use app\models\Cart;
use Yii;
use yii\base\Widget;
use app\models\Product;
use yii\helpers\VarDumper;

class RecentlyViewed extends Widget
{
    public $excludeId = null;

    public function run()
    {
        $session = Yii::$app->session;
        $key = 'recently_viewed';
        $productIds = $session->get($key, []);

        if (isset($this->excludeId)) {
            $index = array_search($this->excludeId, $productIds);
            if ($index !== false) {
                unset($productIds[$index]);
            }
        }

        Cart::checkAndUpdate();

        if (empty($productIds)) {
            return '';
        }

        $products = Product::find()
            ->where(['in', 'id', $productIds])
            ->indexBy('id')
            ->all();

        $orderedProducts = [];
        foreach ($productIds as $id) {
            if (isset($products[$id])) {
                $orderedProducts[] = $products[$id];
            }
        }

        return $this->render('recently-viewed', [
            'products' => $orderedProducts,
        ]);
    }
}
