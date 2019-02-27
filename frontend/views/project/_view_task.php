<?php 
use yii\grid\GridView;
use yii\helpers\{Html, Url};
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'name',
        'date',
        'description:ntext',
        [
            'label' => 'Responsible User Name',
            'value' => 'user.username'
        ],
        [
            'label' => 'Status',
            'value' => 'status.name'
        ],
        'execution_date',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
                        Url::to(['task/item', 'id' => $model->id]));
                }
            ]
        ],
    ],
]); ?>