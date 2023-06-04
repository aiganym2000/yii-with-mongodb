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
 * @property int $id
 * @property string $title Заголовок
 * @property string $description Описание
 * @property int $parent_id Родительская категория
 * @property int $status Статус
 * @property int $img Изображение
 * @property string $created_at Время создания
 * @property string $updated_at Время обновления
 * @property array $category_en
 * @property array $category_kz
 */
class Category extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const IMG_PATH = 'category';

    public static function collectionName()
    {
        return 'category';
    }

    public function attributes()
    {
        return [
            '_id',
            'id',
            'parent_id',
            'category_en',
            'category_kz',
            'description',
            'img',
            'status',
            'title',
            'created_at',
            'updated_at'
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
            [['description', 'img'], 'string'],
            [['parent_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'parent_id','description','img','title'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'uploadBehavior' => [
//                'class' => UploadBehavior::className(),
//                'attributes' => [
//                    'img' => [
//                        'path' => '@static/web/images/' . self::IMG_PATH . '/',
//                        'tempPath' => '@static/temp/',
//                        'url' => $this->getImgPath()
//                    ]
//                ]
//            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s')
            ]
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
            'parent_id' => Yii::t('default', 'PARENT_CATEGORY'),
            'status' => Yii::t('default', 'STATUS'),
            'img' => Yii::t('default', 'IMAGE'),
            'is_delivery' => Yii::t('default', 'IS_DELIVERY'),
            'created_at' => Yii::t('default', 'CREATED_AT'),
            'updated_at' => Yii::t('default', 'UPDATED_AT'),
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
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('default', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('default', 'STATUS_INACTIVE'),
        ];
    }

//    /**
//     * @return string
//     */
//    public function getImgPath()
//    {
//        return Yii::$app->params['staticDomain'] .'images/'. self::IMG_PATH . '/';
//    }
//
//    /**
//     * @return string
//     */
//    public static function getImg()
//    {
//        return Yii::$app->params['staticDomain'] .'images/'. self::IMG_PATH . '/';
//    }

    /**
     * @return string
     */
    public function getImgUrl()
    {
        return $this->img ? $this->getImgPath() . $this->img : $this->getImgPath() . 'default.png';
    }

    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    public function generateId()
    {
        $this->id = rand(0, 100000);
    }

    public static function findOne($condition)
    {
        $query = new Query();
        $data = $query->from(static::collectionName())->where($condition)->one();
        if ($data) {
            $user = new Category();
            $user->id = $data['id'];
            $user->parent_id = $data['parent_id'];
            $user->title = $data['title'];
            $user->description = $data['description'];
            $user->img = $data['img'];
            $user->category_en = $data['category_en'];
            $user->category_kz = $data['category_kz'];
            $user->status = $data['status'];
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
        $collection = Yii::$app->mongodb->getCollection('category');
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
                $user = new Category();
                $user->id = $d['id'];
                $user->parent_id = $d['parent_id'];
                $user->title = $d['title'];
                $user->description = $d['description'];
                $user->img = $d['img'];
                $user->category_en = $d['category_en'];
                $user->category_kz = $d['category_kz'];
                $user->status = $d['status'];
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