<?php 
use yii\widgets\Pjax;
use yii\helpers\Html;

$script = <<<JS
setInterval(function() {
    $("#btn-refresh").click();
}, 1000);
JS;

$this->registerJS($script);
Pjax::begin(); ?>
<div class="message-container">
<?php echo Html::a("Refresh", ["telegram/receive"], [
    'id' => 'btn-refresh',
    'class' => 'hidden'
]);
foreach ($messages as $message): ?>
<div>
    <strong><?= $message['username'] ?>: </strong>
    <?= $message['text'] ?>
</div>
<?php endforeach; ?>
</div>
<?php Pjax::end(); ?>