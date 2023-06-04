<?php

/* @var $this yii\web\View */

use common\models\helpers\LanguageHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Basket');
?>
    <div id="summa"></div>
<?php $form = ActiveForm::begin(); ?>
    <div class="cart-page">
        <div class="col-xs-12">
            <h1 class="basket-title">
                <b><?= Yii::t('app', 'Basket') ?></b>
            </h1>
        </div>
        <div class="col-xs-12 col-md-7 no-padding">
            <div class="cart-list">
                <div class='col-xs-12 border products-list'>
                    <?php if ($models && $models['products'] != null): foreach ($models['products'] as $model): ?>
                        <div style="height: 80px;">
                            <div class="cart-list-img"><img src="<?= $model['getImgPath'] ?>"></div>
                            <p style="position: relative">
                    <span class="mobile-font">
                        <b><a href="<?= Url::to(['/site/product', 'id' => $model['id']]) ?>"><?= LanguageHelper::getField($model, 'title') ?></a></b>
                        <a onclick="id_delete(<?= $model['id'] ?>, <?= $model['count'] ?>)" class="right circle circle-x">&times;</a>
                    </span>
                            </p>
                            <p>
                                <span class="left article"><?= Yii::t('app', 'Quantity') ?></span>
                                <a onclick="minus(<?= $model['id'] ?>, 1, <?= $model['price'] ?>)"
                                   class="left circle">-</a>
                                <span id="val<?= $model['id'] ?>" class="left box-btn"><?= $model['count'] ?></span>
                                <a onclick="plus(<?= $model['id'] ?>, <?= $model['price'] ?>)" class="left circle">+</a>
                            </p>
                        </div>
                        <hr>
                    <?php endforeach; else: ?>
                        <?= Yii::t('app', "There's no products in basket") ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12">
                <h1><b><?= Yii::t('app', 'Delivery method') ?></b></h1>
            </div>
            <b style="margin: 30px"><?= Yii::t('app', 'The delivery method is negotiated individually') ?></b>
            <div class="col-xs-12">
                <h1><b><?= Yii::t('app', 'Payment method') ?></b></h1>
            </div>
            <div class="col-xs-12 payment-type">
                <div class="col-xs-12 col-md-6">
                    <div class="form_radio_btn">
                        <input id="radio-1" type="radio" name="radio" value="1" checked>
                        <label for="radio-1">
                            <b><?= Yii::t('app', 'By card') ?></b>
                            <img src="/images/master card.png" class="hidden-md hidden-xs">
                            <img src="/images/visa.png" class="hidden-md hidden-xs">
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form_radio_btn">
                        <input id="radio-2" type="radio" name="radio" value="2">
                        <label for="radio-2"><b><?= Yii::t('app', 'By cash') ?></b></label>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <h1><b><?= Yii::t('app', 'Your data') ?></b></h1>
            </div>
            <div class="col-xs-12 data">
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($order, 'first_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'First name')])->label(Yii::t('app', 'First name') . '<sup>*</sup>') ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($order, 'last_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Last name')])->label(Yii::t('app', 'Last name') . '<sup>*</sup>') ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($order, 'phone')->textInput(['maxlength' => true, 'placeholder' => '+77777777777'])->label(Yii::t('app', 'Phone number') . '<sup>*</sup>') ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?= $form->field($order, 'email')->textInput(['maxlength' => true])->label(Yii::t('app', 'Mail')) ?>
                </div>
                <div class="col-xs-12">
                    <?= $form->field($order, 'address')->textInput(['maxlength' => true])->label(Yii::t('app', 'Address') . '<sup>*</sup>') ?>
                </div>
            </div>
        </div>
        <?php if ($models && $models['products'] != null): ?>
            <div class="col-xs-12 col-md-5 finish no-padding">
                <div class="border">
                    <?php if ($models):foreach ($models['products'] as $model): ?>
                        <div class="finish-text">
                            <p><?= LanguageHelper::getField($model, 'title') ?></p>
                            <p id="price"><?= ceil($model['price']) ?>₸</p>
                        </div>
                    <?php endforeach; endif; ?>
                    <div class="finish-text final" style="font-size: 28px;">
                        <p><?= Yii::t('app', 'For payment') ?></p>
                        <p>
                            <b id="finish">
                                <?php if ($models['amount']): ?><?= ceil($models['amount']) ?><?php endif; ?>
                            </b><b> ₸</b>
                        </p>
                    </div>
                    <div>
                        <?= Html::submitButton(Yii::t('app', 'Go to formalization')) ?>
                        <input id="all" type="checkbox" checked="checked">
                        <label for="all"><?= Yii::t('app', 'I agree to the terms') ?>
                            <a href=""><?= Yii::t('app', 'of use of the trading platform and refund rules') ?></a><label>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php ActiveForm::end(); ?>