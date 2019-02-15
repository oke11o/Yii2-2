<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

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