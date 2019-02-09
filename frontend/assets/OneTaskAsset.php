<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class OneTaskAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/one_task.css',
    ];
    public $js = [
        '/js/client.js'
    ];
    public $depens = [
        JqueryAsset::class,
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset'
    ];
}
