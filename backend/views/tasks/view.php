<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Tasks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tasks-view">

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
            'name',
            'date',
            'description:ntext',
            [
                'label' => 'Responsible UserName',
                'value' => $model->user->username
            ],
            [
                'label' => 'Status',
                'value' => $model->status->name
            ],
            [
                'label' => 'Project Name',
                'value' => $model->project->name
            ],
            [
                'label' => 'Creator Username',
                'value' => $model->createUser->username
            ],
            'execution_date',
            'created_at',
            'update_at'
        ],
    ]) ?>

</div>
