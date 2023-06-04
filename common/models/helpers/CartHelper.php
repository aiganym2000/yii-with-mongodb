<?php

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

    public static function execInBackground($cmd) {
        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen("start /B ". $cmd, "r"));
        }
        else {
            exec($cmd . " > /dev/null &");
        }
    }
}