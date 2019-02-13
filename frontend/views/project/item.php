<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\grid\GridView;
//use frontend\assets\OneTaskAsset;

//OneTaskAsset::register($this);
?>

<h2>При необходимости ниже можно изменить информацию о проекте:</h2>

<div class="project-form">
<?php Pjax::begin(['enablePushState' => false]); ?>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => Url::to(['project/update', 'id' => $model->id]),
        'options' => ['data-pjax' => true ]]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'status_id')->textInput()->dropDownList($statusList) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить проект', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<h4>Список задач, связанных с проектом:</h4>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'name',
        'date',
        'description:ntext',
        'responsible_id',
        [
            'label' => 'Responsible User Name',
            'value' => 'user.username'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
                        Url::to(['task/item', 'id' => $model->id]));
                }
            ]
        ],
    ],
]); ?>