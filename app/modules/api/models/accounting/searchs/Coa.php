<?php

namespace app\api\models\accounting\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\api\models\accounting\Coa as CoaModel;

/**
 * Coa represents the model behind the search form about `app\api\models\accounting\Coa`.
 */
class Coa extends CoaModel {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'parent_id', 'type', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'normal_balance', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = CoaModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['code' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'normal_balance', $this->normal_balance]);

        return $dataProvider;
    }

}
