<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\helpers\LanguageHelper;
use common\models\helpers\CartHelper;

AppAsset::register($this);
$categories = LanguageHelper::getCategoriesTree();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="row">
    <div id="dropdown">
        <div class="background"></div>
        <div id="menuDropdown" class="dropdown-content">
            <ul class="catalog__list">
                <?php foreach ($categories as $category): ?>
                    <li class="catalog__item">
                        <a href="<?= Url::to(['site/category-search', 'id' => $category['id']]) ?>"><?= LanguageHelper::getField($category, 'title', 'category') ?></a>
                        <div class="catalog__subcatalog">
                            <?php if (isset($category['childs'])): ?>
                                <?php foreach ($category['childs'] as $categoryChilds): ?>
                                    <a href="<?= Url::to(['site/category-search', 'id' => $categoryChilds['id']]) ?>"><?= LanguageHelper::getField($categoryChilds, 'title', 'category') ?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="hidden-lg hidden-md lang"><?= Html::a('ENG', array_merge(
                    \Yii::$app->request->get(),
                    [\Yii::$app->controller->route, 'language' => 'en']
                )); ?>
                <?= Html::a('KZ', array_merge(
                    \Yii::$app->request->get(),
                    [\Yii::$app->controller->route, 'language' => 'kz']
                )); ?>
                <?= Html::a('RU', array_merge(
                    \Yii::$app->request->get(),
                    [\Yii::$app->controller->route, 'language' => 'ru']
                )); ?></div>
        </div>
    </div>
    <header class="first-navbar hidden-sm hidden-xs navbar-fixed">
        <ul>
            <li class="left"><a href=""><?= Yii::t('app', 'About')//todo ?></a></li>
            <li class="right call"><img src="/images/outgoing-call 1.png"><a>+7 777 777 77 77</a></li>
        </ul>
    </header>
    <header class="second-navbar hidden-sm hidden-xs navbar-fixed">
        <ul>
            <li class="left catalog">
                <button onclick="dropdown()" class="dropbtn">
                    <img src="/images/catalog.png">
                    <b><?= Yii::t('app', 'Product catalog') ?></b>
                </button>
            </li>
            <li class="left logo">
                <a href="/">ЛОГО<?php //todo delete <img src="/images/logo.png"> ?></a>
            </li>
            <li class="left search-input">
                <form action="<?= Url::to(['site/search']) ?>" method="get">
                    <input name="search" type="search" class="search"
                           placeholder="<?= Yii::t('app', 'Find a product') ?>...">
                    <button class="button" type="submit">
                        <img src="/images/search.png">
                    </button>
                </form>
            </li>
            <li class="right eng"><?= Html::a('ENG', array_merge(
                    \Yii::$app->request->get(),
                    [\Yii::$app->controller->route, 'language' => 'en']
                )); ?></li>
            <li class="right kz"><?= Html::a('KZ', array_merge(
                    \Yii::$app->request->get(),
                    [\Yii::$app->controller->route, 'language' => 'kz']
                )); ?></li>
            <li class="right ru"><?= Html::a('RU', array_merge(
                    \Yii::$app->request->get(),
                    [\Yii::$app->controller->route, 'language' => 'ru']
                )); ?></li>
            <?php if (!strpos(Url::current(), '/site/cart')): ?>
                <li class="right eng">
                    <a href="/site/cart"><img src="/images/shopping-cart.png">
                        <p id="span1" class="quantity"><?= CartHelper::getCount() ?></p></a>
                </li>
            <?php endif; ?>
        </ul>
    </header>
    <header class="second-navbar mobile hidden-lg hidden-md">
        <ul>
            <li class="left mobile-catalog">
                <button onclick="dropdown()" class="dropbtn">
                    <img src="/images/catalog.png">
                </button>
            </li>
            <li class="left center mobile-logo">
                <a href="/">ЛОГО</a>
            </li>
            <?php if (!strpos(Url::current(), '/site/cart')): ?>
                <li class="left">
                    <a href="/site/cart"><img src="/images/shopping-cart.png">
                        <p id="span2" class="quantity"><?= CartHelper::getCount() ?></p></a>
                </li>
            <?php endif; ?>
            <li class="left mobile-search-input">
                <form action="<?= Url::to(['site/search']) ?>" method="get">
                    <input name="search" type="search" class="search"
                           placeholder="<?= Yii::t('app', 'Find a product') ?>...">
                    <button class="button" type="submit">
                        <img src="/images/search.png">
                    </button>
                </form>
            </li>
        </ul>
    </header>
    <div class="content">
        <?= $content ?>
    </div>
    <footer class="footer">
        <div class='col-xs-4 col-md-4'>
            <ul>
                <li><a href=""><?= Yii::t('app', 'About')//todo ?></a></li>
            </ul>
        </div>
        <div class="hidden-xs hidden-sm col-md-4 center" style="color:white; font-size: 50px">
            ЛОГО<?php //todo delet<img src="/images/Group 7.png"> ?>
        </div>
        <div class='col-xs-8 col-md-4'>
            <ul>
                <li class="end"><a><?= Yii::t('app', 'Contacts') ?></a></li>
                <li class="end"><a>+7 777 777 77 77</a></li>
                <li class="end"><a>example@mail.ru</a></li>
            </ul>
        </div>
        <div class="col-xs-12 hidden-md hidden-lg center" style="color:white; font-size:50px">
            ЛОГО
        </div>
        <div class='hidden-xs hidden-sm' id="scrollToTop"><?= Yii::t('app', 'To Top') ?></div>
<!--        <div class="hidden-md hidden-lg agreement">Пользовательское соглашение</div>-->
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
