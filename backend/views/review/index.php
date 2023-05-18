<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\Review;
use common\widgets\Panel;
use common\models\Product;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('main', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <?php Panel::begin([
        "title" => $this->title,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'fio',
            'content',
            [
                'attribute' => 'product_id',
                'value' => function ($model) {
                    return Product::findOne(['id' =>(int)$model['product_id']])->title;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'product_id',
                    'data' => ArrayHelper::map(\common\models\Product::find()->all(), 'id', 'title'),
                    'value' => 'title',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите продукт'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'selectOnClose' => true,
                    ]
                ])
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'format' => 'html',
                'value' => function ($model) {
                    $class = null;
                    if ($model['status'] == Review::STATUS_PUBLISHED) {
                        $class = 'label-success';
                    } else if ($model['status'] == Review::STATUS_NOT_PUBLISHED) {
                        $class = 'label-warning';
                    }
                    return Html::tag('span', Review::getStatusLabel((int)$model['status']), ['class' => 'label ' . $class]);
                },
                'filter' => Review::getStatuses()
            ],
            //'created_at',
            //'updated_at',

            [
                'class' => '\common\components\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['review/view', 'id' => $model['id']]);
                        return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path></svg>', $customurl,
                            ['title' => Yii::t('app', 'UPDATE'), 'data-pjax' => '0', 'class' => 'btn btn-sm btn-default']);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Panel::end() ?>
</div>
