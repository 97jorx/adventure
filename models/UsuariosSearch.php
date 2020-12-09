<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;
use Yii;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'nombre', 'apellidos', 'email', 'rol', 'created_at', 'contrasena', 'auth_key', 'poblacion', 'provincia', 'pais'], 'safe'],
            [['followers'], 'safe']
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
    public function search($params, $id = null)
    {
        $propietario = Yii::$app->user->id;
        if (!isset($id)) {
            $query = Usuarios::find()
            ->select('usuarios.*', 'COUNT(s.id) AS followers')
            ->joinWith('seguidores s')
            ->groupBy('usuarios.id');
        } else {
            $query = Usuarios::find()
            ->joinWith('integrantes i')
            ->where(['i.comunidad_id' => $id])
            ->andWhere(['not in', 'i.usuario_id', [1, $propietario]]);
        }

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
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'apellidos', $this->apellidos])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'rol', $this->rol])
            ->andFilterWhere(['ilike', 'contrasena', $this->contrasena])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'poblacion', $this->poblacion])
            ->andFilterWhere(['ilike', 'provincia', $this->provincia])
            ->andFilterWhere(['ilike', 'pais', $this->pais]);

        return $dataProvider;
    }
}
