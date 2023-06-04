<?php

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
        $baseCategories = Category::findAll(['parent_id' => (string)1]);
        $allCategories = Category::find()
        ->where(['!=', 'parent_id', null])
        ->andWhere(['!=', 'parent_id', 1])
        ->all();
        foreach ($allCategories as $ac) {
            foreach ($baseCategories as $bc) {
                if ($ac['parent_id'] == $bc['id']) {
                    $i++;
                    $categories[$bc['id']]['childs'][$i]['id'] = $ac['id'];
                    $categories[$bc['id']]['childs'][$i]['title'] = $ac['title'];
                    $categories[$bc['id']]['childs'][$i]['category_kz']['title'] = $ac['category_kz']['title'];
                    $categories[$bc['id']]['childs'][$i]['category_en']['title'] = $ac['category_en']['title'];
                } else {
                    $categories[$bc['id']]['id'] = $bc['id'];
                    $categories[$bc['id']]['title'] = $bc['title'];
                    $categories[$bc['id']]['category_kz']['title'] = $bc['category_kz']['title'];
                    $categories[$bc['id']]['category_en']['title'] = $bc['category_en']['title'];
                }
            }
        }
        return $categories;
    }
}