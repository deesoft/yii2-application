<?php

namespace rest\models\master\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use rest\models\master\Price as PriceModel;

/**
 * Price represents the model behind the search form about `rest\models\master\Price`.
 */
class Price extends PriceModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'price_category_id', 'created_by', 'updated_by'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = PriceModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'product_id' => $this->product_id,
            'price_category_id' => $this->price_category_id,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
