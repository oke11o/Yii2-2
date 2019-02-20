<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\filters\CommandUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Command Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="command-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Command User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id', 
            'id_user', 
            [
                'label' => 'User name',
                'value' => 'user.username'
            ], 
            'id_command', 
            [
                'label' => 'Command name',
                'value' => 'command.name'
            ],
            'id_role_command', 
            [
                'label' => 'Role name',
                'value' => 'roleCommand.name'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
