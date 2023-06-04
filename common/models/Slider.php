<?php

namespace common\models;

use Yii;
use vova07\fileapi\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\mongodb\Query;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string $title Имя слайдера
 * @property string $image Путь к слайдеру
 * @property int $slider_position Позиция слайдера. Может быть вверху страницы или внизу
 * @property int $status Активный/неактивный
 * @property string $created_at Время создания
 */
class Slider extends \yii\mongodb\ActiveRecord
{
    const POSITION_TOP = 1;
    const POSITION_BOTTOM = 2;

    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    const IMG_PATH = 'slider';

    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return 'slider';
    }

    public function attributes()
    {
        return [
            '_id',
            'id',
            'title',
            'image',
            'slider_position',
            'status',
            'created_at',
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
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'image', 'slider_position', 'status'], 'required'],
            [['slider_position', 'status'], 'integer'],
            [['created_at', 'image'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('default', 'ID'),
            'title' => Yii::t('default', 'TITLE'),
            'image' => Yii::t('default', 'IMAGE'),
            'slider_position' => Yii::t('default', 'SLIDER_POSITION'),
            'status' => Yii::t('default', 'STATUS'),
            'created_at' => Yii::t('default', 'CREATED_AT'),
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
            self::STATUS_ACTIVE => Yii::t('default', 'ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('default', 'INACTIVE'),
        ];
    }

    /**
     * Get position label
     */
    public static function getPositionLabel($slider_position)
    {
        return ArrayHelper::getValue(static::getPositionList(), $slider_position);
    }

    /**
     * Get position list
     */
    public static function getPositionList()
    {
        return [
            self::POSITION_BOTTOM => Yii::t('default', 'BOTTOM'),
            self::POSITION_TOP => Yii::t('default', 'TOP'),
        ];
    }

    /**
     * @return string
     */
    public static function getImgPath()
    {
        return Yii::$app->params['staticDomain'] .'images/'. self::IMG_PATH . '/';
    }

    /**
     * @return string
     */
    public static function getImgUrl($image)
    {
        return $image ? self::getImgPath() . $image : self::getImgPath() . 'default.png';
    }

    public static function findOne($condition)
    {
        $query = new Query();
        $data = $query->from(static::collectionName())->where($condition)->one();
        if ($data) {
            $user = new self();
            $user->id = $data['id'];
            $user->title = $data['title'];
            $user->image = $data['image'];
            $user->status = (int)$data['status'];
            $user->created_at = $data['created_at'];
            $user->slider_position = (int)$data['slider_position'];

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
                $user->id = (int)$d['id'];
                $user->title = $d['title'];
                $user->image = $d['image'];
                $user->status = (int)$d['status'];
                $user->created_at = $d['created_at'];
                $user->slider_position = (int)$d['slider_position'];

                $users[] = $user;
//            $user->role = $data['role'];
            }

            return $users;
        } else
            return null;
    }
}
