<?php
use yii\helpers\Url;
?>

<div class='command-item bg-success text-center'>
    <a href=<?= Url::to(['command/item', 'id' => $model->id]) ?> class='text-success font-italic'>
        <h2><?= $model->name ?></h2>
    </a> 
</div>