<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $product_id
 * @property int $count
 */
class OrderItem extends \yii\db\ActiveRecord
{
    public static function collectionName()
    {
        return 'order_item';
    }

    public function attributes()
    {
        return [
            '_id',
            'product_id',
            'count',
        ];
    }

    public function rules()
    {
        return [
            [['product_id', 'count'], 'required'],
            [['product_id', 'count'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'PRODUCT_ID'),
            'count' => Yii::t('app', 'count'),
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_item']);
    }
}
