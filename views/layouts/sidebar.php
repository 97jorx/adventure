<?php

use kartik\icons\Icon;
use yii\helpers\Html;

?>
    <div class="row">
        <div class='img-container'>
            <?php $fakeimg = "https://picsum.photos/800/800?random=88";  ?>
            <?= Html::a(Html::img($fakeimg, ['class' => 'img'])) ?>
        </div>
    </div>
    <div class="row">
        <div class="masonry-title text-center" id="nav-title">
            <h5 itemprop="title">
                <?= ucfirst(Yii::$app->user->identity->alias) ?>
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="masonry-menu">
            <ul>
                <li>
                    <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('users');?></i>
                        </div>
                        <div class="col-6">
                            <a class="nav-text">
                                Seguidores
                            </a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('clipboard-check');?></i>
                        </div>
                        <div class="col-6">
                            <a class="nav-text">
                                Blogs
                            </a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('user-times');?></i>
                        </div>
                        <div class="col-6">
                            <a class="nav-text">
                                Bloqueados
                            </a>
                        </div>
                    </div>
                </li>
                <li>
                <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('images');?></i>
                        </div>
                        <div class="col-6">
                            <a class="nav-text">
                                Galerias
                            </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
 

