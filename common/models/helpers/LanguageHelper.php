<?php
/**
 * Created by PhpStorm.
 * User: фора
 * Date: 23.11.2020
 * Time: 16:35
 */

namespace common\models\helpers;

use Yii;
use common\models\Category;

class LanguageHelper
{
    //возвращает название поля в выбранном языке. Если язык не установлен или перевода нет, то выдаётся русский
    public static function getField($param, $field, $pre = 'product')
    {
        $language = Yii::$app->language;
        if($language == 'en')
            $language = $pre.'_en';
        else if($language == 'kz')
            $language = $pre.'_kz';
            if ($language != 'ru' && isset($param[$language][$field])) {
                return $param[$language][$field];
            } else {
                return $param[$field];
            }

    }

    public static function getCategoriesTree()
    {
        $i = 0;
        $baseCategories = Category::find()->all();//todo
        $allCategories = Category::find()->all();
        foreach ($allCategories as $ac) {
            foreach ($baseCategories as $bc) {
                if ($ac['parent_id'] == $bc['id']) {
                    $i++;
                    $categories[$bc['id']]['childs'][$i]['id'] = $ac['id'];
                    $categories[$bc['id']]['childs'][$i]['title'] = $ac['title'];
                    $categories[$bc['id']]['childs'][$i]['kz']['title'] = $ac['kz']['title'];
                    $categories[$bc['id']]['childs'][$i]['en']['title'] = $ac['en']['title'];
                } else {
                    $categories[$bc['id']]['id'] = $bc['id'];
                    $categories[$bc['id']]['title'] = $bc['title'];
                    $categories[$bc['id']]['kz']['title'] = $bc['kz']['title'];
                    $categories[$bc['id']]['en']['title'] = $bc['en']['title'];
                }
            }
        }
        return $categories;
    }
}