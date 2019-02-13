<?php
use yii\helpers\Url;
?>

<div class='projects-item bg-success text-center'>
    <a href=<?= Url::to(['project/item', 'id' => $model->id]) ?> class='text-success font-italic'>
        <h2><?= $model->name ?></h2>    
        <p><?= $model->description ?></p>
        <div class="one_preview_projects">
            <div>Статус проекта:</div>
            <div><?= $model->status->name ?></div>
        </div>
    </a> 
</div>