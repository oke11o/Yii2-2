<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */

$script = <<<JS
    var statusSelect =  document.getElementById('tasks-id_status');
    var dateExecBlock = document.getElementsByClassName('field-tasks-execution_date')[0];
    var dateExec = document.getElementById('tasks-execution_date');

    if (statusSelect.value == 3) {
        dateExecBlock.style.display = 'block';
    } else {
        dateExecBlock.style.display = 'none';
        dateExec.value = null;
    }
    statusSelect.addEventListener('click', function() {
        if (statusSelect.value == 3) {
            dateExecBlock.style.display = 'block';
        } else {
            dateExecBlock.style.display = 'none';
            dateExec.value = null;
        }
    })
JS;

$this->registerJS($script);
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <?php if ($user_id) {
        echo $form->field($model, 'create_user_id')->hiddenInput(['value' => $user_id])->label(false);
    } ?>

    <?= $form->field($model, 'execution_date')->widget(DateTimePicker::className(),[
        'name' => 'dp_1',
        'type' => DateTimePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Ввод даты/времени...'],
        'convertFormat' => true,
        'value'=> date("d.m.Y h:i",(integer) $model->execution_date),
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd HH:mm:ss',
            'autoclose'=>true,
            'weekStart'=>1,
            'startDate' => '2015-05-01 00:00:00',
            'todayBtn'=>true,
        ]
    ]) ?>       

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
