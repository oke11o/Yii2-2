<?php

namespace backend\controllers;

use Yii;
use common\models\tables\CommandUser;
use common\models\tables\User;
use common\models\tables\RoleCommand;
use common\models\tables\Command;
use common\models\filters\CommandUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CommandUserController implements the CRUD actions for CommandUser model.
 */
class CommandUserController extends Controller
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
        ];
    }

    /**
     * Lists all CommandUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommandUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CommandUser model.
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
     * Creates a new CommandUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CommandUser();

        $users = User::find()->all();
        $usersList = ArrayHelper::map($users, 'id', 'username');

        $roleCommand = RoleCommand::find()->all();
        $roleCommandList = ArrayHelper::map($roleCommand, 'id', 'name');

        $command = Command::find()->all();
        $commandList = ArrayHelper::map($command, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && ($error = $model->save()) === true) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else if ($error) {
            return $this->render('error', [
                'error' => $error,
                'id' => $model->id
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'usersList' => $usersList,
            'roleCommandList' => $roleCommandList,
            'commandList' => $commandList
        ]);
    }

    /**
     * Updates an existing CommandUser model.
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

        $roleCommand = RoleCommand::find()->all();
        $roleCommandList = ArrayHelper::map($roleCommand, 'id', 'name');

        $command = Command::find()->all();
        $commandList = ArrayHelper::map($command, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'usersList' => $usersList,
            'roleCommandList' => $roleCommandList,
            'commandList' => $commandList
        ]);
    }

    /**
     * Deletes an existing CommandUser model.
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
     * Finds the CommandUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CommandUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommandUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
