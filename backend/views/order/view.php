<?php

use common\models\Order;
use common\models\Product;
use common\widgets\Panel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'ORDERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <?php Panel::begin([
        'title' => $this->title,
        'buttonsTemplate' => '{cancel}'
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_amount',
            'last_name',
            'first_name',
            'phone',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::dropDownList('status-order', $model->status, Order::getStatusList(), ['id' => 'status_order', 'data-id' => $model->id]);
                }
            ],
            [
                'attribute' => 'order_item',
                'format' => 'html',
                'value' => function ($model) {
        $text = '';
        foreach ($model['order_item'] as $item){
            $text .= Html::a($item['title'], Url::to('product/view?id=' . $item['id'], true)).' '.$item['price'].'тг x '.$item['count']."<br>";
        }
        return $text;
                }
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
            'email',
        ],
    ]) ?>

    <?php Panel::end() ?>

</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    $('select#status_order').on('change', function () {
        var status = parseInt($(this).val());
        var id = $(this).attr('data-id');
        var param = $('meta[name=csrf-param]').attr("content");
        var token = $('meta[name=csrf-token]').attr("content");
        var data = {};
        data[param] = token;
        data['status'] = status;
        data['id'] = id;

        $.ajax({
            url: '/order/update-status',
            type: 'POST',
            data: data,
            error: function (error) {
            }
        }).done(function (result) {
            if (result.status) {
                location.reload();
            }

        });
    });
</script>