<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use frontend\assets\OneTaskAsset;
use yii\widgets\Pjax;

OneTaskAsset::register($this);
?>
<p class="invisible_block" id="taskId"><?= $model->id; ?></p>

<h2><?=$labelPage->nameLabel ?><?= $model->name ?></h2>
<p><?= $labelPage->descriptionLabel ?><?= $model->description ?></p>
<div><?= $labelPage->dateLabel ?><?= $model->date ?></div>
<div><?= $labelPage->responsibleLabel ?><?= $model->user->username ?></div>
<div><?= $labelPage->statusLabel ?><?= $model->status->name ?></div>

<?= Html::beginForm(['task/update', 'id' => $model->id]) ?>
    <?= Html::submitButton($labelPage->buttonChange, ['class' => 'btn btn-warning create_task_button']) ?>
<?= Html::endForm() ?>

<?php if($user_id && !\Yii::$app->user->can('CommentAddDenied')): ?>
<h4><?= $labelPage->addCommentLabel ?></h4>
<?php $form = ActiveForm::begin(); ?>

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

<h4>Чат:</h4>
<?php if($user_id): ?>
    <?php $form1 = ActiveForm::begin([
        'id' => 'chat_form',
        //'action' => '#'//Url::to(['task/chat', 'id' => $chatMessage->task_id]),
        //'method' => 'post'
    ]); ?>

        <?= $form1->field($chatMessage, 'msg')->textArea() ?>

        <?= $form1->field($chatMessage, 'task_id', ['options' => ['id'=>'chat_task']])->hiddenInput()->label(false) ?>

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
<?php //Pjax::end(); ?>