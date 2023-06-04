<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\widgets\Panel;
use common\models\Slider;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'SLIDER'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="slider-view">

    <?php Panel::begin([
        "title" => $this->title,
        "buttonsTemplate" => "{update}{delete}"
    ]) ?>

    <p>
        <?= Html::a(Yii::t('backen','Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<img ng-src="data:image/png;base64,'.$model['image'].'" src="data:image/png;base64,'.$model['image'].'">';
                }
            ],
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
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime(strtotime($model->created_at), 'short');
                }
            ],
        ],
    ]) ?>

    <?php Panel::end() ?>

</div>
