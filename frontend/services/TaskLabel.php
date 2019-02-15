<?php
namespace frontend\services;
use Yii;

class TaskLabel {
    public $commentLoginLabel;
    public $commentsTaskLabel;
    public $userLabel;
    public $nameCommentLabel;
    public $commentLabel;
    public $buttonSave;
    public $labelChange;

    public function __construct() {
        $this->commentLoginLabel = Yii::t('taskItem', 'commentLoginLabel');
        $this->commentsTaskLabel = Yii::t('taskItem', 'commentsTaskLabel');
        $this->userLabel = Yii::t('taskItem', 'userLabel');
        $this->nameCommentLabel = Yii::t('taskItem', 'nameCommentLabel');
        $this->commentLabel = Yii::t('taskItem', 'commentLabel');
        $this->addCommentLabel = Yii::t('taskItem', 'addCommentLabel');
        $this->buttonSave = Yii::t('taskItem', 'buttonSave');
        $this->labelChange = Yii::t('taskItem', 'labelChange');
    }
}