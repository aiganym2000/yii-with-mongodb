<?php
/**
 * Created by PhpStorm.
 * User: фора
 * Date: 15.12.2020
 * Time: 09:59
 */

namespace common\models\helpers;

use Yii;

class CartHelper
{
    //количество товаров в корзине
    public static function getCount()
    {
        $models = Yii::$app->session->get('cart');
        $count = 0;
        if (isset($models['products'])) {
            foreach ($models['products'] as $model) {
                if (isset($model['count'])) {
                    $count += (int)$model['count'];
                }
            }
        }
        return $count;
    }
}