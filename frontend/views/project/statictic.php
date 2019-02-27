<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\assets\ProjectAsset;

ProjectAsset::register($this);
?>

<h2>Отчетность по проектам</h2>

<h5>Выберите проект, по которому хотите получить отчет</h5>

<?= Html::beginForm(Url::to(['project/statictic'])) ?>
    <?= Html::dropDownList('id', $id, $projectList, [
        'class' => projectSelect
    ]) ?> 
    <?= Html::submitButton('Изменить проект', ['class' => 'btn btn-success']) ?>
<?= Html::endForm() ?>

<h3>Общий список задач</h3>
<?= $this->render('_view_task', ['dataProvider' => $dataProvider]); ?>

<h3>Список просроченных задач: </h3>
<?= $this->render('_view_task', ['dataProvider' => $dataProviderOverdue]); ?>

<h3>Список задач, закрытых за последнюю неделю: </h3>
<?= $this->render('_view_task', ['dataProvider' => $dataProviderClosed]); ?>