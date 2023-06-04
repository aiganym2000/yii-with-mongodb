<?php

use common\models\Category;
use common\models\Product;
use common\widgets\Panel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'PRODUCTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <?php Panel::begin([
        "title" => $this->title,
        "buttonsTemplate" => "{cancel}"
    ]) ?>

    <p>
        <?= Html::a(Yii::t('backen','Обновить'), ['update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return Html::a(Category::findOne(['id' => (int)$model['category_id']])['title'], Url::to('category/view?id=' . $model['category_id'], true));
                },
                'filter' => false,
                'format' => 'html',
            ],
            'price',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model['status'] == $model::STATUS_ACTIVE) {
                        $class = 'label-success';
                    } else if ($model['status'] == $model::STATUS_INACTIVE) {
                        $class = 'label-danger';
                    } else {
                        $class = '';
                    }
                    return Html::tag('span', Product::getStatusLabel((int)$model['status']), ['class' => 'label ' . $class]);
                },
                'filter' => Product::getStatusList()
            ],
            [
                'attribute' => 'images',
                'format' => 'raw',
                'value' => function ($model) {
                    $i = '';

                    foreach ($model['images'] as $image)
                        $i .= '<img ng-src="data:image/png;base64,'.$image.'" src="data:image/png;base64,'.$image.'" style="max-width:100px;max-height:100px;">';

                    return $i;
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => ['DateTime', 'php:Y-m-d H:i']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['DateTime', 'php:Y-m-d H:i']
            ],
        ],
    ]) ?>
    <!--    --><? //= DetailView::widget([
    //        'model' => $modelEn,
    //        'attributes' => [
    //            [
    //                'attribute' => 'title',
    //                'label' => 'Название на английском'
    //            ],
    //            [
    //                'attribute' => 'description',
    //                'label' => 'Описание на английском'
    //            ],
    //        ],
    //    ]) ?>
    <!--    --><? //= DetailView::widget([
    //        'model' => $modelKz,
    //        'attributes' => [
    //            [
    //                'attribute' => 'title',
    //                'label' => 'Название на казахском'
    //            ],
    //            [
    //                'attribute' => 'description',
    //                'label' => 'Описание на казахском'
    //            ],
    //        ],
    //    ]) ?>
    <?php Panel::end() ?>
</div>
