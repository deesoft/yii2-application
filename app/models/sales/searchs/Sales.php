<?php

namespace app\models\sales\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\sales\Sales as SalesModel;

/**
 * Sales represents the model behind the search form about `app\models\sales\Sales`.
 */
class Sales extends SalesModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'branch_id', 'customer_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['number', 'date', 'created_at', 'updated_at'], 'safe'],
            [['value', 'discount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params)
    {
        $query = SalesModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'branch_id' => $this->branch_id,
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'value' => $this->value,
            'discount' => $this->discount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }
}
