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

            [
                'class' => '\common\components\grid\ActionColumn',
                'template' => '{view}{update}{delete}'
            ],
        ],
    ]); ?>

    <?php Panel::end() ?>

</div>
