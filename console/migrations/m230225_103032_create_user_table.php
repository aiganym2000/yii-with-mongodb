<?php

use common\models\User;

class m230225_103032_create_user_table extends \yii\mongodb\Migration
{
    public $collectionName = 'user';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createCollection($this->collectionName);
        $this->createIndex($this->collectionName, 'username', ['unique' => true]);
        $this->createIndex($this->collectionName, 'phone', ['unique' => true]);
        $this->createIndex($this->collectionName, 'id', ['unique' => true]);

        $this->batchInsert($this->collectionName, [
            [
                'id' => 1,
                'username' => 'admin',
                'fullname' => 'Admin Admin',
                'phone' => '+1234567890',
                'email' => 'admin@example.com',
                'role' => 1,
                'status' => User::STATUS_ACTIVE,
                'password_hash' => '$2y$13$HQXwsLWTYwXrLy/Dd5hLT.shamK/T1VnshuRPZzjBMLhItoqFXOym',
                'auth_key' => 'knrFK88QyEjIBMga3UlpuTeHyygLMMqk',
                'address' => [
                    'city' => 'Almaty',
                    'street' => 'Pushkina',
                    'house_number' => 123
                ],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropCollection($this->collectionName);
    }
}
