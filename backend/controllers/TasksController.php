<?php

namespace backend\controllers;

use Yii;
use common\models\tables\Tasks;
use common\models\filters\TasksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\tables\User;
use common\models\tables\Status;
use common\models\tables\Project;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * AdminTasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user_id = Yii::$app->user->identity->id;
        $model = new Tasks();

        $users = User::find()->all();
        $usersList = ArrayHelper::map($users, 'id', 'username');

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        $project = Project::find()->all();
        $projectList = ArrayHelper::map($project, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usersList' => $usersList,
            'statusList' => $statusList,
            'projectList' => $projectList,
            'user_id' => $user_id
        ]);
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $users = User::find()->all();
        $usersList = ArrayHelper::map($users, 'id', 'username');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        $project = Project::find()->all();
        $projectList = ArrayHelper::map($project, 'id', 'name');

        return $this->render('update', [
            'model' => $model,
            'usersList' => $usersList,
            'statusList' => $statusList,
            'projectList' => $projectList
        ]);
    }

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
