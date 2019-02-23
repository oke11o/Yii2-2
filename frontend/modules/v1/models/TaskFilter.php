<?php
namespace frontend\modules\v1\models;

class TaskFilter {
    private $filterSearch = [
        'responsible_id',
        'create_user_id',
        'month'
    ];

    public $query;

    public function __construct($query = null) {
        $this->query = $query;
    }

    public function addFilter($filter)
    {
        foreach($this->filterSearch as $oneFilter) {
            if ($oneFilter != 'month') {
                $this->query->andFilterWhere([$oneFilter => $filter[$oneFilter]]);
            } else {
                if ($filter[$oneFilter]>=1 && $filter[$oneFilter]<=12) {
                    $this->query->andFilterWhere(['MONTH(date)' => $filter[$oneFilter]]);
                }
            }
        }

        return $this->query;
    }
}

