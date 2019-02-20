<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tables\CommandUser */

$this->title = 'Create Command User';
$this->params['breadcrumbs'][] = ['label' => 'Command Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="command-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usersList' => $usersList,
        'roleCommandList' => $roleCommandList,
        'commandList' => $commandList
    ]) ?>

</div>
