<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\widgets\Panel;
use common\models\Order;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('default', 'ORDERS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php Panel::begin([
        'title' => $this->title,
        'buttonsTemplate' => ''
    ]) ?>
    <br><br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'last_name',
            'first_name',
            'phone',
            'full_amount',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model['status'] == Order::STATUS_NEW) {
                        $class = 'label-success';
                    } else if ($model['status'] == Order::STATUS_CANCELLED) {
                        $class = 'label-danger';
                    } else {
                        $class = 'label-warning';
                    }
                    return Html::tag('span', Order::getStatusLabel($model['status']), ['class' => 'label ' . $class]);
                },
                'filter' => Order::getStatusList()
            ],
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime(strtotime($model['created_at']), 'short');
                }
            ],
            'email',
            [
                'attribute' => 'payment_type',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::tag('span', Order::getPaymentTypeLabel($model['payment_type']), ['class' => 'label label-success']);
                },
                'filter' => Order::getPaymentTypeList()
            ],
//            'updated_at',

            [
                'class' => '\common\components\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['order/view', 'id' => $model['id']]);
                        return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path></svg>', $customurl,
                            ['title' => Yii::t('app', 'UPDATE'), 'data-pjax' => '0', 'class' => 'btn btn-sm btn-default']);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Panel::end() ?>
</div>
