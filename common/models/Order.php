<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $full_amount
 * @property int $phone
 * @property int $payment_type
 * @property int $status
 * @property string $created_at
 * @property string $last_name
 * @property string $first_name
 * @property string $email
 * @property string $updated_at
 * @property array $address
 * @property array $order_item
 */
class Order extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_PROCESS = 2;
    const STATUS_SENT = 3;
    const STATUS_CANCELLED = 4;

    const PAYMENT_TYPE_BY_CARD = 1;
    const PAYMENT_TYPE_BY_CASH = 2;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'full_amount', 'phone', 'status', 'payment_type','email','last_name', 'first_name'], 'required'],
            [['full_amount', 'phone', 'status'], 'integer'],
            [['created_at', 'updated_at', 'payment_type'], 'safe'],
            [['email'], 'email'],
            [['last_name', 'first_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('default', 'ID'),
            'full_amount' => Yii::t('default', 'PRICE'),
            'last_name' => Yii::t('default', 'LAST_NAME'),
            'first_name' => Yii::t('default', 'FIRST_NAME'),
            'phone' => Yii::t('default', 'PHONE'),
            'status' => Yii::t('default', 'STATUS'),
            'created_at' => Yii::t('default', 'CREATED_AT'),
            'updated_at' => Yii::t('default', 'UPDATED_AT'),
            'address' => Yii::t('default', 'ADDRESS'),
            'email' => Yii::t('default', 'E-MAIL'),
            'payment_type' => Yii::t('default', 'PAYMENT_TYPE'),
            'order_item' => Yii::t('default', 'Товары'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $model = self::find()->orderBy([
                'id' => SORT_DESC
            ])->one();
            if(!$model)
                $this->id= 1;
            else
                $this->id = $model['id'] + 1;
        }else {

        }

        return parent::beforeSave($insert);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s')
            ]
        ];
    }

    /**
     * Get status label
     */
    public static function getStatusLabel($status)
    {
        return ArrayHelper::getValue(static::getStatusList(), $status);
    }

    /**
     * Get status list
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_NEW => Yii::t('default', 'NEW'),
            self::STATUS_IN_PROCESS => Yii::t('default', 'IN_PROCESS'),
            self::STATUS_SENT => Yii::t('default', 'SENT'),
            self::STATUS_CANCELLED => Yii::t('default', 'CANCELLED'),
        ];
    }

    /**
     * Get status label
     */
    public static function getPaymentTypeLabel($payment_type)
    {
        return ArrayHelper::getValue(static::getPaymentTypeList(), $payment_type);
    }

    /**
     * Get status list
     */
    public static function getPaymentTypeList()
    {
        return [
            self::PAYMENT_TYPE_BY_CARD => Yii::t('app', 'By card'),
            self::PAYMENT_TYPE_BY_CASH => Yii::t('app', 'By cash'),
        ];
    }

    public static function collectionName()
    {
        return 'order';
    }

    public function attributes()
    {
        return [
            '_id',
            'id',
            'payment_type',
            'status',
            'last_name',
            'first_name',
            'full_amount',
            'phone',
            'email',
            'address',
            'order_item',
            'created_at',
            'updated_at'
        ];
    }

    public static function findOne($condition)
    {
        $query = new Query();
        $data = $query->from(static::collectionName())->where($condition)->one();
        if ($data) {
            $user = new self();
            $user->id = $data['id'];
            $user->payment_type = $data['payment_type'];
            $user->status = $data['status'];
            $user->last_name = $data['last_name'];
            $user->first_name = $data['first_name'];
            $user->full_amount = $data['full_amount'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            $user->address = $data['address'];
            $user->order_item = $data['order_item'];
            $user->created_at = $data['created_at'];
            $user->updated_at = $data['updated_at'];

            return $user;
        } else
            return null;
    }

    public static function find()
    {
        $query = new Query();
        $data = $query->from(static::collectionName());
        return $data;
    }

    public static function findAll($condition = null)
    {
        $query = new Query();
        $data = $query->from(static::collectionName());

        if ($condition)
            $data = $data->where($condition);

        $data = $data->all();
        if ($data) {
            $users = [];
            foreach ($data as $d){
                $user = new self();
                $user->id = $d['id'];
                $user->payment_type = $d['payment_type'];
                $user->status = $d['status'];
                $user->last_name = $d['last_name'];
                $user->first_name = $d['first_name'];
                $user->full_amount = $d['full_amount'];
                $user->phone = $d['phone'];
                $user->email = $d['email'];
                $user->address = $d['address'];
                $user->order_item = $d['order_item'];
                $user->created_at = $d['created_at'];
                $user->updated_at = $d['updated_at'];
                $users[] = $user;
//            $user->role = $data['role'];
            }

            return $users;
        } else
            return null;
    }
}