<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use frontend\assets\OneTaskAsset;
use yii\widgets\Pjax;
use kartik\datetime\DateTimePicker;

OneTaskAsset::register($this);
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

<?php Pjax::begin(); ?>
<?php if($user_id && !\Yii::$app->user->can('CommentAddDenied')): ?>
<h4><?= $labelPage->addCommentLabel ?></h4>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

<?= $form->field($modelComment, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($modelComment, 'content')->textArea() ?>

<?= $form->field($modelComment, 'img_path')->fileInput() ?>

<?= Html::submitButton('Оставить комментарий', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
<?php else: ?>
<h4><?= $labelPage->commentLoginLabel ?></h4>
<?php endif; ?>

<h4><?= $labelPage->commentsTaskLabel ?></h4>
<?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'options' => [
            'class' => 'view_comments'
        ],
        'summary' => false,
        'emptyText' => 'Нет комментариев',
        'viewParams' => [
            'userLabel' => $labelPage->userLabel,
            'nameCommentLabel' => $labelPage->nameCommentLabel,
            'commentLabel' => $labelPage->commentLabel
        ]
    ]);
?>
<?php Pjax::end(); ?>

<h4>Чат:</h4>
<?php if($user_id): ?>
    <?php $form1 = ActiveForm::begin(['id' => 'chat_form']); ?>

        <?= $form1->field($chatMessage, 'msg')->textArea() ?>

        <?= $form1->field($chatMessage, 'channel', ['options' => ['id'=>'chat_task']])->hiddenInput()->label(false) ?>

        <?= $form1->field($chatMessage, 'user_id', ['options' => ['id'=>'chat_user']])->hiddenInput()->label(false) ?>

        <?= Html::hiddeninput('username', $chatMessage->user->username, ['id' => 'chat_username']) ?>

        <?= Html::submitButton('Отправить сообщение', [
            'class' => 'btn btn-success',
            'id' => 'chat_form_btn'
            ]) ?>

    <?php ActiveForm::end(); ?>
<?php else: ?>
    <h5>Для того, чтобы оправить сообщение в чат, необходимо авторизоваться.</h5>
<?php endif; ?>
    <hr>
    <h5>История сообщенией:</h5>
    <div id="root_chat">
        <?php foreach($chatList as $message): ?>
            <p>
                <?= $message->user->username ?>:<br>
                <?= $message->msg ?><br>
            </p>
        <?php endforeach; ?>
    </div>
<script>
    channel = '<?= $chatMessage->channel ?>'
</script>