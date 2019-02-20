<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tables\CommandUser */

$this->title = 'Update Command User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Command Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="command-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usersList' => $usersList,
        'roleCommandList' => $roleCommandList,
        'commandList' => $commandList
    ]) ?>

</div>
