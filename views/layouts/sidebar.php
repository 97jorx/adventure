<?php

use kartik\sidenav\SideNav;
use kartik\icons\Icon;
use yii\helpers\Html;

// echo SideNav::widget([
//     'type' => SideNav::TYPE_PRIMARY,
//     'heading' => 'Operations',
//     'items' => [
//         [
//             'url' => '#',
//             'label' => 'Search',
//             'icon' => 'search'
//         ],
//         [
//             'label' => 'Edit',
//             'icon' => 'edit',
//             'items' => [
//                 ['label' => 'About', 'icon'=>'info-sign', 'url'=>'#'],
//                 ['label' => 'Contact', 'icon'=>'phone', 'url'=>'#'],
//             ],
//         ],
//     ],
// ]);

?>
    
    <div class="row">
        <div class='img-container'>
            <?php $fakeimg = "https://picsum.photos/800/800?random=1";  ?>
            <?= Html::a(Html::img($fakeimg, ['class' => 'img'])) ?>
        </div>
    </div>
    <div class="row">
        <div class="masonry-title">
            <h5 itemprop="title">
                <?= ucfirst(Yii::$app->user->identity->alias) ?>
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="masonry-menu">
            <ul>
                <li>
                <i class="fa fa-home fa-2x"></i>
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
 

