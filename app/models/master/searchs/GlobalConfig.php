<?php

namespace app\models\master\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\master\GlobalConfig as GlobalConfigModel;

/**
 * GlobalConfig represents the model behind the search form about `app\models\master\GlobalConfig`.
 */
class GlobalConfig extends GlobalConfigModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group'], 'required'],
            [['group', 'name', 'value', 'description', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
    public function search()
    {
        $query = GlobalConfigModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'group' => $this->group,
        ]);

        return $dataProvider;
    }
}