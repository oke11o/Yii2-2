<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<h2>Просмотр команды: <?= $name ?></h2>

<?php Pjax::begin(['enablePushState' => false]); ?>
    <?php if($error): ?>
        <h3><?= $error; ?></h3>
    <?php endif; ?>

    <?php if($role == 'admin'):?>
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => Url::to(['command/add-user', 'id' => $id]),
            'options' => ['data-pjax' => true ]
        ]); ?>

        <?= $form->field($commandUser, 'id_user')->textInput()->dropDownList($userList) ?>

        <?= $form->field($commandUser, 'id_command')->hiddenInput()->label(false) ?>

        <?= $form->field($commandUser, 'id_role_command')->textInput()->dropDownList($roleCommandList) ?>

        <div class="form-group">
            <?= Html::submitButton('Добавить пользователя в команду', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>

    <?php if($role): ?>
        <h4>Список пользователей команды:</h4>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id_user',
                [
                    'label' => 'UserName',
                    'value' => 'user.username'
                ],
                'id_role_command',
                [
                    'label' => 'Role Name',
                    'value' => 'roleCommand.name'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) use ($id, $role) {
                            if ($role == 'admin') {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                                    Url::to(['command/delete-user', 'id' => $id, 'id_user' => $model->id_user]));
                            } else {
                                return Html::a('<span class="glyphicon glyphicon-heart"></span>', 
                                    Url::to(['command/item', 'id' => $id]));
                            }
                        }
                    ]
                ],
            ],
        ]); ?>
    <?php else: ?>
        <h3>Просмотр команды запрещен, т.к. Вы не являетесь участником данной команды</h3>
    <?php endif; ?>

<?php Pjax::end(); ?>