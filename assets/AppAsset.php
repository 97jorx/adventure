<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/masonry.css',
        'css/jquery-ui.css',
        'css/balloon.css',
        'css/parsley.css',
        'css/jquery.fancybox.min.css',
    ];
    public $js = [
        'js/imagesloaded.pkgd.js',
        'js/masonry.pkgd.min.js',
        'js/parsley.js',
        'js/jquery.efect.js',
        'js/masonrys.js',
        'js/anime.min.js',
        'js/jquery.fancybox.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}
