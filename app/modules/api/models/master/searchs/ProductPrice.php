<?php

namespace app\api\models\master\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\api\models\master\Product as ProductModel;
use app\api\models\master\Price;

/**
 * Product represents the model behind the search form about `app\api\models\master\Product`.
 */
class ProductPrice extends ProductModel
{
    public $price_category_id;
    public $price;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_category_id'], 'required'],
            [['id', 'group_id', 'category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'created_at', 'updated_at'], 'safe'],
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
        $query = ProductModel::find()
            ->select(['p.*', 'pc.*'])
            ->from(ProductModel::tableName() . ' p')
            ->joinWith(['prices' => function($q) {
                $q->from(Price::tableName() . ' pc');
            }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'p.id' => $this->id,
            'p.group_id' => $this->group_id,
            'p.category_id' => $this->category_id,
            'p.status' => $this->status,
            'pc.price_category_id' => $this->price_category_id
//            'p.created_at' => $this->created_at,
//            'p.created_by' => $this->created_by,
//            'p.updated_at' => $this->updated_at,
//            'p.updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}