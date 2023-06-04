<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $fullname
 * @property string $password_hash
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $status
 * @property integer $role
 * @property integer $address
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $password_new
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;
    const STATUS_ACTIVE = 1;

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    public $_id;
    public $username;
    public $password_hash;
    public $password_new;

    public static function collectionName()
    {
        return ['yii-with-mongo', 'user'];
    }

    public function attributes()
    {
        return [
            '_id',
            'id',
            'auth_key',
            'username',
            'fullname',
            'phone',
            'email',
            'role',
            'status',
            'password_hash',
            'address',
            'created_at',
            'updated_at',
        ];
    }

    public function fields()
    {
        return [
            '_id' => function () {
                return (string)$this->_id;
            },
            'id',
            'auth_key',
            'username',
            'password_hash',
            'role',
        ];
    }

    public function rules()
    {
        return [
            [['username', 'id'], 'required'],
            ['username', 'unique'],
            ['id', 'unique'],
            [['status', 'role'], 'integer'],
            ['email', 'email'],
            [['password_hash', 'password_new', 'address', 'fullname', 'created_at', 'updated_at', 'phone', 'auth_key'], 'safe'],
        ];
    }

    public static function findOne($condition)
    {
        $query = new Query();
        $data = $query->from(static::collectionName())->where($condition)->one();
        if ($data) {
            $user = new User();
//            print_r($user);
            $user->id = $data['id'];
            $user->auth_key = $data['auth_key'];
            $user->username = $data['username'];
            $user->password_hash = $data['password_hash'];
            $user->fullname = $data['fullname'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            $user->role = $data['role'];
            $user->status = $data['status'];
            $user->address = $data['address'];
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
//        print_r($data);
//        print_r(1);
//        if ($data) {
//            $user = new User();
//            $user->id = $data['id'];
//            $user->auth_key = $data['auth_key'];
//            $user->username = $data['username'];
//            $user->password_hash = $data['password_hash'];
////            $user->role = $data['role'];
//
//            return $user;
//        } else
//            return null;
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
                $user = new User();
                $user->id = $d['id'];
                $user->auth_key = $d['auth_key'];
                $user->username = $d['username'];
                $user->password_hash = $d['password_hash'];
                $user->fullname = $d['fullname'];
                $user->phone = $d['phone'];
                $user->email = $d['email'];
                $user->role = $d['role'];
                $user->status = $d['status'];
                $user->address = $d['address'];
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
//    public static function tableName()
//    {
//        return '{{%user}}';
//    }

    /**
     * @inheritdoc
     */
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
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateId()
    {
        $this->id = rand(0, 100000);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    public static function getRoleLabel($id)
    {
        $user = User::findOne(['id' => $id]);
        if($user)
            return ArrayHelper::getValue(static::getRoleList(), $user->role);
        return null;
    }

    /**
     * @return array
     */
    public static function getRoleList()
    {
        return [
            self::ROLE_ADMIN => Yii::t('app', 'ROLE_ADMIN'),
            self::ROLE_USER => Yii::t('app', 'ROLE_USER'),
        ];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function getStatusLabel($id)
    {
        $user = User::findOne(['id' => $id]);
        if($user)
        return ArrayHelper::getValue(static::getStatusList(), $user->status);
        return null;
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('app', 'STATUS_INACTIVE'),
        ];
    }
}
