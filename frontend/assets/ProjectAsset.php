<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ProjectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/projects.css',
    ];
    public $js = [
    ];
}
