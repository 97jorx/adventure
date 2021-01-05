<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Galerias;
use Yii;

/**
 * GaleriasSearch represents the model behind the search form of `app\models\Galerias`.
 */
class GaleriasSearch extends Galerias
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'comunidad_id'], 'integer'],
            [['fotos'], 'safe'],
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
    public function search($params, $actual)
    {
        $query = Galerias::find()
        ->where(['comunidad_id' => $actual]);

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
            'comunidad_id' => $this->comunidad_id,
        ]);

        $query->andFilterWhere(['ilike', 'fotos', $this->fotos]);

        return $dataProvider;
    }
}
