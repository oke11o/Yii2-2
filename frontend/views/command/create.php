<h2>Введите данные для создания нового проекта:</h2>

<?= $this->render('_form', [
        'model' => $model,
        'statusList' => $statusList
]) ?>