<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Blogs;
use Yii;

/**
 * BlogsSearch represents the model behind the search form of `app\models\Blogs`.
 */
class BlogsSearch extends Blogs
{

    /**
     * Variable de búsqueda.
     *
     * @var [String]
     */
    public $busqueda;

     /**
     * Variable de búsqueda.
     *
     * @var [String]
     */
    public $actual;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'comunidad_id', 'usuario_id'], 'integer'],
            [['titulo', 'descripcion', 'cuerpo', 'created_at'], 'safe'],
            [['usuario.nombre', 'comunidad.denom'], 'safe'],
            [['busqueda', 'actual'], 'safe'],
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


    public function attributes()
    {
        return array_merge(parent::attributes(), ['usuario.nombre', 'comunidad.denom']);
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
        $query = Blogs::allBlogs();
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['usuario.nombre'] = [
            'asc' => ['u.nombre' => SORT_ASC],
            'desc' => ['u.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['comunidad.denom'] = [
            'asc' => ['c.denom' => SORT_ASC],
            'desc' => ['c.denom' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        
    
        $query->andFilterWhere([
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'created_at' => $this->created_at,
            'comunidad_id' => $this->comunidad_id,
            'actual' => $this->actual
        ]);
       
        $query->orFilterWhere(['ilike', 'blogs.descripcion', $this->busqueda])
        ->orFilterWhere(['ilike', 'cuerpo', $this->busqueda])
        ->orFilterWhere(['ilike', 'u.nombre', $this->busqueda])
        ->orFilterWhere(['ilike', 'c.denom', $this->busqueda]);

        //  var_dump($query->createCommand()->getRawSql());
        //  die();

        // var_dump($_SESSION['actual']);
        // die();

        return $dataProvider;
    }
}