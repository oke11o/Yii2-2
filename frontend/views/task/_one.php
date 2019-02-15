<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\datetime\DateTimePicker;
?>

<h2><?= $labelPage->labelChange ?></h2>

<div class="tasks-form">
<?php Pjax::begin(['enablePushState' => false]); ?>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => Url::to(['task/update', 'id' => $model->id]),
        'options' => ['data-pjax' => true ]]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->widget(DateTimePicker::className(),[
        'name' => 'dp_1',
        'type' => DateTimePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Ввод даты/времени...'],
        'convertFormat' => true,
        'value'=> date("d.m.Y h:i",(integer) $model->date),
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd HH:mm:ss',
            'autoclose'=>true,
            'weekStart'=>1,
            'startDate' => '2015-05-01 00:00:00',
            'todayBtn'=>true,
        ]
    ]) ?>

    <?= $form->field($model, 'description')->textArea() ?>

    <?= $form->field($model, 'responsible_id')->dropDownList($usersList) ?>

    <?= $form->field($model, 'id_status')->dropDownList($statusList) ?>

    <?= $form->field($model, 'project_id')->dropDownList($projectList) ?>

    <div class="form-group">
        <?= Html::submitButton($labelPage->buttonSave, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>