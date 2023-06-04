<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use common\widgets\Panel;
use common\models\Slider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('default', 'SLIDER');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">

    <?php Panel::begin([
        "title" => $this->title,
        "buttonsTemplate" => "{create}"
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
            [
                'attribute' => 'slider_position',
                'format' => 'text',
                'content' => function ($model) {
                    if ($model['slider_position'] == Slider::POSITION_TOP) {
                        $class = 'label-success';
                    } else if ($model['slider_position'] == Slider::POSITION_BOTTOM) {
                        $class = 'label-primary';
                    }
                    return Html::tag('span', Slider::getPositionLabel($model['slider_position']), ['class' => 'label ' . $class]);
                },
                'filter' => Slider::getPositionList()
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model['status'] == Slider::STATUS_ACTIVE) {
                        $class = 'label-success';
                    } else if ($model['status'] == Slider::STATUS_INACTIVE) {
                        $class = 'label-danger';
                    } else {
                        $class = 'label-warning';
                    }
                    return Html::tag('span',Slider::getStatusLabel($model['status']), ['class' => 'label ' . $class]);
                },
                'filter' => Slider::getStatusList()
            ],
//            [
//                'attribute' => 'created_at',
//                'filter' => DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'created_at',
//                    'type' => DatePicker::TYPE_INPUT,
//                    'pluginOptions' => [
//                        'autoclose' => true,
//                        'format' => 'yyyy-mm-dd'
//                    ]
//                ]),
//                'value' => function ($model) {
//                    return Yii::$app->formatter->asDatetime(strtotime($model['created_at']), 'short');
//                }
//            ],

            [
                'class' => '\common\components\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['slider/update', 'id' => $model['id']]);
                        return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>', $customurl,
                            ['title' => Yii::t('app', 'UPDATE'), 'data-pjax' => '0', 'class' => 'btn btn-sm btn-default']);
                    },
                    'view' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['slider/view', 'id' => $model['id']]);
                        return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path></svg>', $customurl,
                            ['title' => Yii::t('app', 'UPDATE'), 'data-pjax' => '0', 'class' => 'btn btn-sm btn-default']);
                    },
                    'delete' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['slider/delete', 'id' => $model['id']]);
                        return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>', $customurl,
                            ['title' => Yii::t('app', 'UPDATE'), 'data-pjax' => '0', 'class' => 'btn btn-sm btn-default']);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Panel::end() ?>

</div>
