<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comunidades;

/**
 * ComunidadesSearch represents the model behind the search form of `app\models\Comunidades`.
 */
class ComunidadesSearch extends Comunidades
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'propietario'], 'integer'],
            [['denom', 'descripcion', 'created_at'], 'safe'],
            [['favs'],'safe']
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
    public function search($params)
    {
        $query = Comunidades::comunidadesQuery();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'favs' => SORT_DESC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['favs'] = [
            'asc' => ['COUNT(f.id)' => SORT_ASC],
            'desc' => ['COUNT(f.id)' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'propietario' => $this->propietario,
        ]);

        $query->andFilterWhere(['ilike', 'denom', $this->denom])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}