<?php

use kartik\icons\Icon;
use yii\helpers\Html;

?>
    
    <div class="row">
        <div class='img-container'>
            <?php $fakeimg = "https://picsum.photos/800/800?random=1";  ?>
            <?= Html::a(Html::img($fakeimg, ['class' => 'img'])) ?>
        </div>
    </div>
    <div class="row">
        <div class="masonry-title text-center">
            <h5 itemprop="title" class="masonry-title">
                <?= ucfirst(Yii::$app->user->identity->alias) ?>
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="masonry-menu">
            <ul>
                <li>
                <i><?= Icon::show('users');?></i>
                    <span class="nav-text">
                        Mis seguidores
                    </span>
                </li>
                <li>
                <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Mis blogs favoritos
                    </span>
                </li>
                <li>
                <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Lista de bloqueados
                    </span>
                </li>
                <li>
                <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Galerias
                    </span>
                </li>
            </ul>
        </div>
    </div>
 

