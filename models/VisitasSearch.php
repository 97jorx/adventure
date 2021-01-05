<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visitas;

/**
 * VisitasSearch representa el modelo detrás de la forma de búsqueda de `app\models\Visitas`.
 */
class VisitasSearch extends Visitas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'visitas', 'usuario_id', 'blog_id'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = Visitas::find();

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
            'visitas' => $this->visitas,
            'usuario_id' => $this->usuario_id,
            'blog_id' => $this->blog_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
