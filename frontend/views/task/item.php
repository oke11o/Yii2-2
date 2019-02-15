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

<?= $this->render('_one', [
    'model' => $model,
    'labelPage' => $labelPage,
    'usersList' => $usersList,
    'statusList' => $statusList,
    'projectList' => $projectList
]) ?>

<?= $this->render('_comment', [
    'user_id' => $user_id,
    'labelPage' => $labelPage,
    'modelComment' => $modelComment,
    'dataProvider' => $dataProvider,
    'id' => $model->id
]) ?>

<?= $this->render('_chat', [
    'user_id' => $user_id,
    'chatMessage' => $chatMessage,
    'chatList' => $chatList
]) ?>