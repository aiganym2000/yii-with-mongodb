<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \common\widgets\Panel;
use \common\models\Review;
use common\models\Product;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Review */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main','Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="review-view">

    <?php Panel::begin([
        "title" => $this->title,
    ])?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',

            'fio',
            'content',
            [
                'attribute' => 'product_id',
                'value' => function ($model) {
                    return Product::findOne(['id' =>(int)$model['product_id']])->title;
                },
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
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime(strtotime($model->created_at), 'short');
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime(strtotime($model->updated_at), 'short');
                }
            ],
        ],
    ]) ?>

    <?php Panel::end() ?>

</div>
