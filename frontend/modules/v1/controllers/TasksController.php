<?php
namespace frontend\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\tables\Tasks;
use common\models\tables\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use frontend\modules\v1\models\TaskFilter;

class TasksController extends ActiveController {
    public $modelClass = Tasks::class;

    public function actions() {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();

        /*$behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password) {
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($password)) {
                    return $user;
                }
                return null;
            }
        ];*/

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function actionIndex() {
        $filter = Yii::$app->request->get('filter');
        $query = Tasks::find();

        if($filter) {
            $query = (new TaskFilter($query))->addFilter($filter);
        }

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}