<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller as Controller;
use common\models\tables\Project;
use yii\data\ActiveDataProvider;
use common\models\tables\Status;
use common\models\tables\Tasks;
use yii\helpers\ArrayHelper;
use common\models\filters\TasksSearch;
use yii\db\Expression;

class ProjectController extends Controller {
    public function actionIndex() {

        $query = Project::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionItem($id) {
        $model = Project::findOne($id);

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('item', [
            'model' => $model,
            'statusList' => $statusList,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate() {
        $model = new Project();

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['item', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'statusList' => $statusList
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        $model->save();
        return $this->render('item', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStatictic() {
        $project = Project::find()->all();
        $projectList = ArrayHelper::map($project, 'id', 'name');

        if (!$id = Yii::$app->request->post('id')) {
            $id = $project[0]['id'];
        }

        $tasksProject = Tasks::find()
            ->where(['project_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $tasksProject
        ]);

        $tasksOverdue = Tasks::find()
            ->where(['and', ['project_id' => $id], 
                ['or', 
                    ['and', ['!=', 'id_status', 3], new Expression('`date` < NOW()')],
                    ['and', ['id_status' => 3], new Expression('`date` < `execution_date`')]
                ]
            ]
        );
        $dataProviderOverdue = new ActiveDataProvider([
            'query' => $tasksOverdue
        ]);

        $tasksClosed = Tasks::find()
            ->where(['and', ['project_id' => $id], 
                ['and', ['id_status' => 3], new Expression('execution_date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)')]
            ]
        );
        $dataProviderClosed = new ActiveDataProvider([
            'query' => $tasksClosed
        ]);

        return $this->render('statictic', [
            'projectList' => $projectList,
            'id' => $id,
            'dataProvider' => $dataProvider,
            'dataProviderOverdue' => $dataProviderOverdue,
            'dataProviderClosed' => $dataProviderClosed
        ]);
    }
}