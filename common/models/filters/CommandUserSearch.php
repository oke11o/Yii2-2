<?php

namespace common\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tables\CommandUser;

/**
 * CommandUserSearch represents the model behind the search form of `common\models\tables\CommandUser`.
 */
class CommandUserSearch extends CommandUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_command', 'id_role_command'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $idCommand = null)
    {
        if ($idCommand) {
            $query = CommandUser::find()
                ->where(['id_command' => $idCommand]);
        } else {
            $query = CommandUser::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'id_command' => $this->id_command,
            'id_role_command' => $this->id_role_command,
        ]);

        return $dataProvider;
    }
}
