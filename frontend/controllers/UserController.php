<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller as Controller;
use yii\data\ActiveDataProvider;
use common\models\tables\Tasks;
use common\models\tables\User;
use yii\helpers\Url;

class UserController extends Controller {

    public function actionIndex() {
        if (!$user_id = Yii::$app->user->identity->id) {
            return $this->redirect(Url::to(['/site/logout']));
        }

        $user = User::findOne($user_id);

        $query = Tasks::find()
            ->where(['responsible_id' => $user_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        Yii::$app->db->cache(function () use ($dataProvider) {
            return $dataProvider->prepare();
        }, 60);
    
        return $this->render('index', [
            'user' => $user,
            'dataProvider' => $dataProvider
        ]);
    }
}