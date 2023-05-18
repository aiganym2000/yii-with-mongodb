<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\mongodb\Query;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property string $fio
 * @property string $content
 * @property int $product_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 */
class Review extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_NOT_PUBLISHED = 1;
    const STATUS_PUBLISHED = 2;


    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return 'review';
    }

    public function attributes()
    {
        return [
            '_id',
            'id',
            'fio',
            'content',
            'product_id',
            'status',
            'created_at',
            'updated_at',
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id','status'], 'integer'],
            [['fio', 'content'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['fio', 'content'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public static function getStatusLabel($status)
    {
        return ArrayHelper::getValue(static::getStatuses(), $status);
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PUBLISHED => Yii::t('backend', 'PUBLISHED'),
            self::STATUS_NOT_PUBLISHED => Yii::t('backend', 'NOT PUBLISHED')
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s')
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => Yii::t('default', 'FIO'),
            'content' => Yii::t('default', 'CONTENT'),
            'product_id' => Yii::t('default', 'PRODUCT_ID'),
            'status' => Yii::t('default', 'STATUS'),
            'created_at' => Yii::t('default', 'CREATED_AT'),
            'updated_at' => Yii::t('default', 'UPDATED_AT'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }


    public static function findOne($condition)
    {
        $query = new Query();
        $data = $query->from(static::collectionName())->where($condition)->one();
        if ($data) {
            $user = new self();
            $user->id = $data['id'];
            $user->fio = $data['fio'];
            $user->content = $data['content'];
            $user->product_id = $data['product_id'];
            $user->status = (int)$data['status'];
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

    public static function remove($id)
    {
        $collection = Yii::$app->db->getCollection(self::collectionName());
        print_r($collection->remove(['id' => $id]));//todo
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
                $user->fio = $d['fio'];
                $user->product_id = $d['product_id'];
                $user->content = $d['content'];
                $user->status = (int)$d['status'];
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
