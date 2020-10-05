<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsuarioComunidad;

/**
 * UsuarioComunidadSearch represents the model behind the search form of `app\models\UsuarioComunidad`.
 */
class UsuarioComunidadesSearch extends UsuarioComunidades
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'comunidad_id'], 'integer'],
            [['creador'], 'boolean'],
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
        $query = UsuarioComunidad::find();

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
            'usuario_id' => $this->usuario_id,
            'creador' => $this->creador,
            'comunidad_id' => $this->comunidad_id,
        ]);

        return $dataProvider;
    }
}
