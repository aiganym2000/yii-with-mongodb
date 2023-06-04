<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            '_id',
            'id',
            'auth_key',
            'username',
            'fullname',
            'phone',
            'email:email',
            [
                'attribute' => 'role',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::tag('span', User::getRoleLabel($model['id']));
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::tag('span', User::getStatusLabel($model['id']));
                },
            ],
            'password_hash',
            [
                'attribute' => 'address.city',
                'label' => 'City',
            ],
            [
                'attribute' => 'address.street',
                'label' => 'Street',
            ],
            [
                'attribute' => 'address.house_number',
                'label' => 'House Number',
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>