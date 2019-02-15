<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller as Controller;
use yii\data\ActiveDataProvider;
use common\models\tables\Tasks;
use common\models\tables\User;
use common\models\tables\Status;
use yii\helpers\ArrayHelper;
use common\models\DateForm;
use common\models\tables\Comments;
use yii\web\UploadedFile;
use common\models\tables\TaskComment;
use frontend\services\TaskLabel;
use common\models\tables\Chat;
use common\models\tables\Project;

class TaskController extends Controller {

    public function actionIndex() {
        $session = Yii::$app->session;
        if (Yii::$app->request->method == 'POST') {
            $dateModel = new DateForm();
            $dateModel->load(Yii::$app->request->post());
            $session->set('dateModel', $dateModel);
        } else {
            $dateModel = $session->has('dateModel') ? $session->get('dateModel') : new DateForm();
        }
        
        $query = Tasks::find()
            ->andFilterWhere(['>=', 'date', $dateModel->dateBegin])
            ->andFilterWhere(['<=', 'date', $dateModel->dateEnd]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dateModel' => $dateModel,
        ]);
    }

    public function actionItem($id) {
        $model = Tasks::findOne($id);
        $user_id = Yii::$app->user->identity->id;
        $modelComment = new Comments();

        $query = Comments::find()
            ->where(['task_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        $labelPage = new TaskLabel();
        $chatMessage = new Chat([
            'user_id' => $user_id,
            'channel' => 'Task_' . $id
        ]);

        $chatList = Chat::find()
            ->where(['channel' => 'Task_' . $id])
            ->all();

        $users = User::find()->all();
        $usersList = ArrayHelper::map($users, 'id', 'username');

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        $project = Project::find()->all();
        $projectList = ArrayHelper::map($project, 'id', 'name');

        return $this->render('item', [
            'model' => $model,
            'usersList' => $usersList,
            'statusList' => $statusList,
            'user_id' => $user_id,
            'modelComment' => new Comments(),
            'dataProvider' => $dataProvider,
            'labelPage' => $labelPage,
            'chatMessage' => $chatMessage,
            'chatList' => $chatList,
            'projectList' => $projectList
        ]);
    }

    public function actionComment($id) {
        $user_id = Yii::$app->user->identity->id;
        $labelPage = new TaskLabel();
        $modelComment = new Comments();

        if ($modelComment->load(Yii::$app->request->post())){
            $modelComment->user_id = $user_id;
            $modelComment->task_id = $id;
            
            if ($modelComment->img_path = UploadedFile::getInstance($modelComment, 'img_path')) {
                $modelComment->upload();
            }
            $modelComment->save();
        }

        $query = Comments::find()
            ->where(['task_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        return $this->renderAjax('_comment', [
            'user_id' => $user_id,
            'labelPage' => $labelPage,
            'modelComment' => $modelComment,
            'dataProvider' => $dataProvider,
            'id' => $id
        ]);
    }

    public function actionCreate() {
        $model = new Tasks();

        $users = User::find()->all();
        $usersList = ArrayHelper::map($users, 'id', 'username');

        $status = Status::find()->all();
        $statusList = ArrayHelper::map($status, 'id', 'name');

        $project = Project::find()->all();
        $projectList = ArrayHelper::map($project, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['item', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usersList' => $usersList,
            'statusList' => $statusList,
            'projectList' => $projectList
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        $model->save();
        return $this->renderAjax('_one', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}