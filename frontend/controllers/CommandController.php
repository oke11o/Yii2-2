<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller as Controller;
use common\models\tables\Command;
use yii\data\ActiveDataProvider;
use common\models\tables\User;
use common\models\tables\CommandUser;
use common\models\tables\RoleCommand;
use common\models\tables\Tasks;
use yii\helpers\ArrayHelper;
use common\models\filters\CommandUserSearch;

class CommandController extends Controller {
    public function actionIndex() {
        $query = Command::find();

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
        $model = Command::findOne($id);

        $user = User::find()
            ->all();
        $userList = ArrayHelper::map($user, 'id', 'username');

        $roleCommand = RoleCommand::find()
            ->all();
        $roleCommandList = ArrayHelper::map($roleCommand, 'id', 'name');

        $searchModel = new CommandUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        $user_id =  Yii::$app->user->identity->id;
        $role = (CommandUser::find()
            ->where([
                'id_command' => $id,
                'id_user' => $user_id
            ])->one())->roleCommand->name;

        return $this->render('item', [
            'name' => $model->name,
            'userList' => $userList,
            'roleCommandList' => $roleCommandList,
            'commandUser' => new CommandUser(['id_command' => $id]),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $role,
            'id' => $model->id      
        ]);
    }

    public function actionAddUser($id) {
        $user = User::find()
            ->all();
        $userList = ArrayHelper::map($user, 'id', 'username');
        $roleCommand = RoleCommand::find()
            ->all();
        $roleCommandList = ArrayHelper::map($roleCommand, 'id', 'name');

        $searchModel = new CommandUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        $model = new CommandUser();
        $model->load(Yii::$app->request->post());
        if (!$error = $model->save()) {
            $error = "Пользователь успешно добавлен в команду!";
        }

        $user_id =  Yii::$app->user->identity->id;
        $role = (CommandUser::find()
            ->where([
                'id_command' => $id,
                'id_user' => $user_id
            ])->one())->roleCommand->name;

        return $this->renderAjax('item', [
            'error' => $error,
            'userList' => $userList,
            'roleCommandList' => $roleCommandList,
            'commandUser' => new CommandUser(['id_command' => $id]),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
            'role' => $role
        ]);
    }

    public function actionDeleteUser($id, $id_user) {
        $model = CommandUser::find()
            ->where(['id_command' => $id, 'id_user' => $id_user])
            ->one();

        if ($model) {
            $model->delete();
            $error = "Удаление пользователя из команды прошло успешно";
        } else {
            $error = "Пользователь не найден";
        }

        $user = User::find()
            ->all();
        $userList = ArrayHelper::map($user, 'id', 'username');
        $roleCommand = RoleCommand::find()
            ->all();
        $roleCommandList = ArrayHelper::map($roleCommand, 'id', 'name');

        $searchModel = new CommandUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        $user_id =  Yii::$app->user->identity->id;
        $role = (CommandUser::find()
            ->where([
                'id_command' => $id,
                'id_user' => $user_id
            ])->one())->roleCommand->name;

        return $this->renderAjax('item', [
            'error' => $error,
            'userList' => $userList,
            'roleCommandList' => $roleCommandList,
            'commandUser' => new CommandUser(['id_command' => $id]),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
            'role' => $role
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