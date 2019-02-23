<?php
namespace frontend\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\tables\Tasks;
use common\models\tables\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

class TasksController extends ActiveController {
    public $modelClass = Tasks::class;

    private $filterSearch = [
        'responsible_id',
        'create_user_id',
        'month'
    ];

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
            $filterName = array_keys($filter);

            foreach($filterName as $oneFilter) {
                if (!in_array($oneFilter, $this->filterSearch)) {
                    unset($filter[$oneFilter]);
                } else if ($oneFilter == 'month') {
                    if ($filter[$oneFilter]>=1 && $filter[$oneFilter]<=12) {
                        $query->andFilterWhere(['MONTH(date)' => $filter[$oneFilter]]);
                    }

                    unset($filter[$oneFilter]);
                }
            }
            $query->andFilterWhere($filter);
        }

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}