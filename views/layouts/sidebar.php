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
                        Seguidores
                    </span>
                </li>
                <li>
                <i><?= Icon::show('clipboard-check');?></i>
                    <span class="nav-text">
                        Blogs favoritos
                    </span>
                </li>
                <li>
                <i><?= Icon::show('user-times');?></i>
                    <span class="nav-text">
                        Bloqueados
                    </span>
                </li>
                <li>
                <i><?= Icon::show('images');?></i>
                    <span class="nav-text">
                        Galerias
                    </span>
                </li>
            </ul>
        </div>
    </div>
 

