<?php

use yii\helpers\{Html, URL};
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\tables\CommandUser */

$this->title = 'Ошибка при сохранении записи' . $id;
$this->params['breadcrumbs'][] = ['label' => 'Command Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="command-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $error ?>

    <?= Html::beginForm(Url::to(['/command-user/index']), 'post') ?>

    <div class="form-group">
        <?= Html::submitButton('Назад', ['class' => 'btn btn-success']) ?>
    </div>

    <?= Html::endForm() ?>
</div>
