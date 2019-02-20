<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CommandAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/command.css',
    ];
    public $js = [
    ];
}
