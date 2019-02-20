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
}