<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\assets\ProjectAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
ProjectAsset::register($this);
?>
<div class="projects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'view',
        'options' => [
            'class' => 'preview_projects'
        ],
    ]); 
    
    ?>

    <?= Html::beginForm(Url::to(['project/create'])) ?>
        <?= Html::submitButton('Создать новый проект', ['class' => 'btn btn-warning create_task_button']) ?>
    <?= Html::endForm() ?>
</div>
