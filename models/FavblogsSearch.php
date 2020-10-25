<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Favblogs;

/**
 * FavblogsSearch represents the model behind the search form of `app\models\Favblogs`.
 */
class FavblogsSearch extends Favblogs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'blog_id'], 'integer'],
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
        $query = Favblogs::find();

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
            'blog_id' => $this->blog_id,
        ]);

        return $dataProvider;
    }
}
