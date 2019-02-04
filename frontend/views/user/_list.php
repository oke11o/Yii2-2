<?= frontend\widgets\TaskWidget::Widget([
    'id' => $model->id,
    'title' => $model->name,
    'description' => $model->description,
    'user' => $model->user->username,
    'date' => $model->date
]); ?>