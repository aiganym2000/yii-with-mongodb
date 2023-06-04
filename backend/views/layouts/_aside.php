<?php

use yii\helpers\Url;
use common\widgets\Sidebar;

?>
<aside class="main-sidebar">
    <a href="<?= Url::to(['/']) ?>" class="mini-logo visible-xs">
        <span class="logo-lg"><?= Yii::t('default', 'ADMIN') ?></span>
    </a>
    <section class="sidebar">
        <?= Sidebar::widget(
            [
                'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
                'linkTemplate' => '<a href="{url}">{icon} {label}</a>',
                'activeCssClass' => 'active',
                'items' => [
                    [
                        'label' => Yii::t('default', 'MENU'),
                        'options' => [
                            'class' => 'header'
                        ],
                    ],
                    [
                        'label' => Yii::t('default', 'HOME'),
                        'url' => ['/site/index'],
                        'icon' => 'fa-link',
                        'void' => true,
                    ],
                    [
                        'label' => Yii::t('default', 'CATEGORIES'),
                        'url' => ['/category/index'],
                        'icon' => 'fa-link',
                        'void' => true,
                    ],
                    [
                        'label' => Yii::t('default', 'PRODUCTS'),
                        'url' => ['/product/index'],
                        'icon' => 'fa-link',
                        'void' => true,
                    ],
                    [
                        'label' => 'Отзывы',
                        'url' => ['/review/index'],
                        'icon' => 'fa-link',
                        'void' => true,
                    ],
                    [
                        'label' => Yii::t('default', 'ORDERS'),
                        'url' => ['/order/index'],
                        'icon' => 'fa-link',
                        'void' => true,
                    ],

                    [
                        'label' => Yii::t('default', 'SLIDER'),
                        'url' => ['/slider/index'],
                        'icon' => 'fa-link',
                        'void' => true,
                    ],

                    /*[
                        'label' => Yii::t('app', 'Matching'),
                        'icon' => 'fa-compress aria-hidden="true"',
                        'url' => '',
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Medicament'),
                                'url' => ['/matching/index'],
                                'icon' => 'none',
                            ],
                        ]
                    ],*/
                ]
            ]
        );
        ?>
    </section>
    <div class="aside-footer-menu">
        <ul class="aside-footer-menu__list">
            <li class="aside-footer-menu__item">
                <a class="aside-footer-menu__link" href="<?= Url::to(['/site/about']) ?>">
                    <i class="fa fa-copyright"></i>
                </a>
            </li>
            <li class="aside-footer-menu__item">
                <a class="aside-footer-menu__link" href="<?= Url::to(['/site/logout']) ?>" data-method="post">
                    <i class="fa fa-power-off"></i>
                </a>
            </li>
        </ul>
    </div>
</aside>