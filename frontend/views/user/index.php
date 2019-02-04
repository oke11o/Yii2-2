<?php
    use yii\widgets\ListView;
    use yii\grid\GridView;
    use frontend\assets\TasksAsset;

    TasksAsset::register($this);
?>

<h2><?= $user->username ?>, добро пожаловать в личный кабинет!</h2>
<h4>Задачи, которые назначены на Вас: </h4>

<?php

//if ($this->beginCache("user_tasks_{$user->id}", ['duration' => 60])) {
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'options' => [
            'class' => 'preview_tasks'
        ],
        'summary' => false
    ]);
    
    //$this->endCache();
//}
?>
