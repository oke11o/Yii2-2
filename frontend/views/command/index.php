<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\assets\CommandAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Команды';
$this->params['breadcrumbs'][] = $this->title;
CommandAsset::register($this);
?>
<div class="projects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'view',
        'options' => [
            'class' => 'preview_command'
        ],
    ]); 
    
    ?>

</div>
