<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
?>

<?php if($user_id && !\Yii::$app->user->can('CommentAddDenied')): ?>
<h4><?= $labelPage->addCommentLabel ?></h4>
<?php Pjax::begin(['enablePushState' => false]); ?>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::to(['task/comment', 'id' => $id]),
    'options' => ['data-pjax' => true ]
]); ?>

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