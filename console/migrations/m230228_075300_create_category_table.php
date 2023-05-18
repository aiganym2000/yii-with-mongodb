<?php

class m230228_075300_create_category_table extends \yii\mongodb\Migration
{
    public $tableName = 'category';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createCollection($this->tableName);

        $this->insert($this->tableName, [
            'id' => 1,
            'parent_id' => null,
            'title' => 'Всё',
            'description' => '',
            'img' => '',
            'category_en' => [
                'title' => 'All',
                'description' => '',
            ],
            'category_kz' => [
                'title' => 'Бәрі',
                'description' => '',
            ],
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropCollection($this->tableName);
    }
}
