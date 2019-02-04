<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionIndex()
    {
        $authManager = Yii::$app->authManager;

        $admin = $authManager->createRole('admin');
        $watcher = $authManager->createRole('watcher');
        $authManager->add($admin);
        $authManager->add($watcher);

        $permissionAccessAdminModule = $authManager->createPermission('AccessAdminModule');
        $permissionCommentAddDenied = $authManager->createPermission('CommentAddDenied');
        $authManager->add($permissionAccessAdminModule);
        $authManager->add($permissionCommentAddDenied);

        $authManager->addChild($admin, $permissionAccessAdminModule);
        $authManager->addChild($watcher, $permissionCommentAddDenied);

        $authManager->assign($admin, 1);
        $authManager->assign($watcher, 2);
    }
}
