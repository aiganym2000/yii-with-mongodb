<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $description Описание
 * @property int $category_id Категория
 * @property string $price Цена
 * @property int $status Статус
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 * @property array $images Изображение
 * @property array $product_en
 * @property array $product_kz
 */
class Product extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const IMG_PATH = 'product';

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $model = self::find()->orderBy([
                'id' => SORT_DESC
            ])->one();
            if (!$model)
                $this->id = 1;
            else
                $this->id = $model['id'] + 1;
        } else {

        }

        return parent::beforeSave($insert);
    }

    public static function collectionName()
    {
        return 'product';
    }

    public function attributes()
    {
        return [
            '_id',
            'id',
            'description',
            'category_id',
            'status',
            'price',
            'title',
            'product_en',
            'product_kz',
            'img',
            'images',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['images'], 'safe'],
            [['title', 'category_id', 'price', 'description', 'status'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    public function getProductEn()
    {
        return $this->hasOne(ProductEn::className(), ['id' => 'product_en']);
    }

    public function getProductKz()
    {
        return $this->hasOne(ProductKz::className(), ['id' => 'product_kz']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public static function findOne($condition)
    {
        $query = new Query();
        $data = $query->from(static::collectionName())->where($condition)->one();
        if ($data) {
            $user = new self();
            $user->id = $data['id'];
            $user->description = $data['description'];
            $user->images = $data['images'];
            $user->product_en = $data['product_en'];
            $user->product_kz = $data['product_kz'];
            $user->category_id = $data['category_id'];
            $user->status = $data['status'];
            $user->price = $data['price'];
            $user->title = $data['title'];
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
            foreach ($data as $d) {
                $user = new self();
                $user->id = $d['id'];
                $user->description = $d['description'];
                $user->images = $d['images'];
                $user->product_en = $data['product_en'];
                $user->product_kz = $data['product_kz'];
                $user->category_id = $d['category_id'];
                $user->status = $d['status'];
                $user->price = $d['price'];
                $user->title = $d['title'];
                $user->created_at = $d['created_at'];
                $user->updated_at = $d['updated_at'];
                $users[] = $user;
//            $user->role = $data['role'];
            }

            return $users;
        } else
            return null;
    }

    /**
     * {@inheritdoc}
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
            'id' => Yii::t('default', 'ID'),
            'title' => Yii::t('default', 'TITLE'),
            'description' => Yii::t('default', 'DESCRIPTION'),
            'category_id' => Yii::t('default', 'CATEGORY'),
            'price' => Yii::t('default', 'PRICE'),
            'status' => Yii::t('default', 'STATUS'),
            'img' => Yii::t('default', 'IMAGE'),
            'images' => Yii::t('default', 'IMAGE'),
            'product_en' => Yii::t('default', 'PRODUCT_EN'),
            'product_kz' => Yii::t('default', 'PRODUCT_KZ'),
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
     * Get status list
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('default', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('default', 'STATUS_INACTIVE'),
        ];
    }

    public static function getCategoryLabel($category_id)
    {
        return Category::findOne(['id' => $category_id]);
    }

    /**
     * @return string
     */
    public static function getImgPath()
    {
        return Yii::$app->params['staticDomain'] . 'images/' . self::IMG_PATH . '/';
    }

    /**
     * @return string
     */
    public static function getImgUrl($img)
    {
        return $img ? self::getImgPath() . $img : self::getImgPath() . 'default.png';
    }

    public static function getParentCategory($id, $categories = [], $i = 1)
    {
        $language = Yii::$app->language;
        $category = Category::findOne(['id' => (int)$id]);
        if (isset($category) && $category['parent_id'] > 0) {
            if ($language == 'kz')
                $title = $category['category_kz']['title'];
            else if ($language == 'en')
                $title = $category['category_en']['title'];
            if ($language != 'ru' && isset($title)) {
                $categories[$i] = ['title' => $title, 'id' => $id];
            } else {
                $categories[$i] = ['title' => $category['title'], 'id' => $id];
            }
            $i++;
            return self::getParentCategory($category['parent_id'], $categories, $i);
        } else {
            return array_reverse($categories);
        }
    }
}