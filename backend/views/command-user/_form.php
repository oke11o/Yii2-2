<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\tables\CommandUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="command-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->dropDownList($usersList) ?>

    <?= $form->field($model, 'id_command')->dropDownList($commandList) ?>

    <?= $form->field($model, 'id_role_command')->dropDownList($roleCommandList) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
