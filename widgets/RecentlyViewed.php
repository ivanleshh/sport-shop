<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\Product;
use yii\helpers\VarDumper;

class RecentlyViewed extends Widget
{
    public function run()
    {
        $session = Yii::$app->session;
        $key = 'recently_viewed';
        $productIds = $session->get($key, []);

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
