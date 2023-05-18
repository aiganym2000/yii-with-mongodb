<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\User;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \backend\models\UserSearch */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
//                '_id',
                'id',
//                'auth_key',
                'username',
                'fullname',
                'phone',
                'email',
                [
                    'attribute' => 'role',
                    'format' => 'html',
                    'value' => function ($model) {
                        return Html::tag('span', User::getRoleLabel($model['id']));
                    },
                    'filter' => User::getRoleList()
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($model) {
                        return Html::tag('span', User::getStatusLabel($model['id']));
                    },
                    'filter' => User::getStatusList()
                ],
//                'password_hash',
//                'address',
                [
                    'attribute' => 'created_at',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'type' => DatePicker::TYPE_INPUT,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ],
                        'options' => [
                            'autocomplete' => 'off'
                        ]
                    ]),
                ],
//                'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>

<!--<div class="site-index">-->
<!--    <table class="table table-bordered">-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th>#</th>-->
<!--            <th>Username</th>-->
<!--            <th>Password</th>-->
<!--            <th>Aksi</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!---->
<!--        --><?php //$i = 1; foreach($model as $field){ ?>
<!--            <tr>-->
<!--                <td>--><?php //echo $i++; ?><!--</td>-->
<!--                <td>--><? //= $field->username; ?><!--</td>-->
<!--                <td>--><? //= $field->password_hash; ?><!--</td>-->
<!--                <td>-->
<!--                    <a href="--><?php //echo Url::to(['/home/editabout']).'?id='.$field->id;?><!--"> Update</a> |-->
<!--                    <a href="--><?php //echo Url::to(['/home/deleteabout']).'?id='.$field->id; ?><!--"> Delete</a>-->
<!--                </td>-->
<!--            </tr>-->
<!--        --><?php //} ?>
<!--        </tbody>-->
<!--    </table>-->
<!--</div>-->
