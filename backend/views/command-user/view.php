<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\tables\CommandUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Command Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="command-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id', 
            [
                'label' => 'User name',
                'value' => $model->user->username
            ],
            [
                'label' => 'Command name',
                'value' => $model->command->name
            ], 
            [
                'label' => 'Role name',
                'value' => $model->roleCommand->name
            ],
        ],
    ]) ?>

</div>
