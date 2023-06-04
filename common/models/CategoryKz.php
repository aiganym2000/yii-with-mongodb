<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;
use Yii;
use yii\helpers\ArrayHelper;
use vova07\fileapi\behaviors\UploadBehavior;

/**
 * This is the model class for table "category".
 *
 * @property string $title Заголовок
 * @property string $description Описание
 */
class CategoryKz extends ActiveRecord
{
    public static function collectionName()
    {
        return 'category_kz';
    }

    public function attributes()
    {
        return [
            '_id',
            'description',
            'title',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['description','title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('default', 'TITLE'),
            'description' => Yii::t('default', 'DESCRIPTION'),
        ];
    }
}