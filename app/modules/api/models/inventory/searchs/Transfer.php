<?php

namespace app\api\models\inventory\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\api\models\inventory\Transfer as TransferModel;

/**
 * Transfer represents the model behind the search form about `app\api\models\inventory\Transfer`.
 */
class Transfer extends TransferModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'branch_id', 'branch_dest_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['number', 'date', 'created_at', 'updated_at'], 'safe'],
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
        $query = TransferModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'branch_id' => $this->branch_id,
            'branch_dest_id' => $this->branch_dest_id,
            'date' => $this->date,
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
