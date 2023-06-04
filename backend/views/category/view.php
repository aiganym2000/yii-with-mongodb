<?php

use common\models\User;
use common\widgets\Panel;
use yii\widgets\DetailView;
use common\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'CATEGORIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <?php Panel::begin([
        'title' => $this->title,
        'buttonsTemplate' => '{cancel}'
    ]) ?>

    <p>
        <?= Html::a(Yii::t('main', 'Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    if ($model['parent_id']) {
                        return Html::a(Category::findOne(['id' => (int)$model['parent_id']])['title'], Url::to('category/view?id=' . $model['parent_id'], true));
                    } else {
                        return Yii::t('default', 'NOT_SET');
                    }

                },
                'format' => 'html',
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model['status'] == Category::STATUS_ACTIVE) {
                        $class = 'label-success';
                    } else if ($model['status'] == Category::STATUS_INACTIVE) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }
                    return Html::tag('span', Category::getStatusLabel($model['status']), ['class' => 'label ' . $class]);
                },
                'filter' => Category::getStatusList()
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<img ng-src="data:image/png;base64,'.$model['img'].'" src="data:image/png;base64,'.$model['img'].'">';
             }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <?php Panel::end() ?>

</div>
