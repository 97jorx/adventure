<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blogs".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $cuerpo
 * @property int $comunidad_id
 * @property int $usuario_id
 * @property string $created_at
 
 *
 * @property Comunidades $comunidad
 * @property Usuarios $usuario
 * @property Favblogs[] $favblogs
 * @property Notas[] $notas
 */
class Blogs extends \yii\db\ActiveRecord
{
   
    private $_favs = null;
    private $_valoracion = null;
    private $_visits = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'comunidad_id', 'cuerpo', 'descripcion', 'usuario_id'], 'required'],
            [['cuerpo'], 'string'],
            [['comunidad_id', 'usuario_id'], 'default', 'value' => null],
            [['comunidad_id', 'usuario_id'], 'integer'],
            [['created_at'], 'safe'],
            [['titulo', 'descripcion'], 'string', 'max' => 255],
            [['titulo'], 'unique'],
            [['comunidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comunidades::class, 'targetAttribute' => ['comunidad_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'cuerpo' => 'Cuerpo',
            'comunidad_id' => 'Comunidad',
            'usuario_id' => 'Usuario',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Comunidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComunidad()
    {
        return $this->hasOne(Comunidades::class, ['id' => 'comunidad_id'])->inverseOf('blogs');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('blogs');
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::class, ['id_comment_blog' => 'id'])->inverseOf('commentBlog');
    }


     /**
     * Gets query for [[Favblogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavblogs()
    {
        return $this->hasMany(Favblogs::class, ['blog_id' => 'id'])->inverseOf('blog');
    }



   /**
     * Gets query for [[Visitas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visitas::class, ['blog_id' => 'id'])->inverseOf('blog');
    }


    /**
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotas()
    {
        return $this->hasMany(Notas::class, ['blog_id' => 'id'])->inverseOf('blog');
    }


    /**
     * Gets query for [[Notas]].
     * SETTER DE @param favs
     * @return \yii\db\ActiveQuery
     */
    public function setFavs($favs) {
        $this->_favs = $favs;
    }

    /**
     * Gets query for [[Notas]].
     * GETTER DE @param favs
     * @return \yii\db\ActiveQuery
     */
    public function getFavs()
    {
        if ($this->_favs === null && !$this->isNewRecord) {
            $this->setFavs($this->getFavblogs()->count());
        }
        return $this->_favs;
    }


    /**
     * Gets query for [[Notas]].
     * SETTER DE @param visits
     * @return \yii\db\ActiveQuery
     */
    public function setVisits($visits) {
        $this->_visits = $visits;
    }


    /**
     * Gets query for [[Notas]].
     * GETTER DE @param visits
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        if ($this->_visits === null && !$this->isNewRecord) {
            $this->setVisits($this->getVisitas()->count());
        }
        return $this->_visits;
    }


    /**
     * Gets query for [[Notas]].
     * SETTER DE @param valoracion
     * @return \yii\db\ActiveQuery
     */
    public function setValoracion($valoracion) {
        $this->_valoracion = $valoracion;
    }

    /**
     * Gets query for [[Notas]].
     * GETTER DE @param valoracion
     * @return \yii\db\ActiveQuery
     */
    public function getValoracion()
    {
        if ($this->_valoracion === null && !$this->isNewRecord) {
            $this->setValoracion($this->getNotas()->sum('nota'));
        }
        return $this->_valoracion;
    }



    /**
     * Consulta para mostrar Comunidad por su nombre 
     * y el Usuario por su nombre en Blogs
     *
     * @return query
     */
    public static function blogsQuery()
    {

        return static::find()
            ->select([
                'blogs.*', 
                '"u".nombre AS usuario', 
                '"c".denom AS comunidad', 
                '"c".descripcion AS eslogan', 
                'COUNT(DISTINCT f.id) AS favs',
                'COUNT(DISTINCT v.id) AS visits',
                'SUM(DISTINCT n.nota) AS valoracion'
             ])
            ->joinWith('comunidad c')
            ->joinWith('usuario u')
            ->joinWith('favblogs f')
            ->joinWith('notas n')
            ->joinWith('visitas v')
            ->groupBy('blogs.id, u.nombre, c.denom, c.descripcion');
    }
  

 /**
     * Consulta para mostrar Comunidad por su nombre 
     * y el Usuario por su nombre en Blogs
     *
     * @return query
     */
    public static function blogsUserLikes()
    {

        return static::find()
            ->select([
                'blogs.*', 
                '"u".nombre AS usuario', 
                'COUNT(DISTINCT f.id) AS favs',
                'COUNT(DISTINCT v.id) AS visits',
                'SUM(DISTINCT n.nota) AS valoracion'
             ])
            ->joinWith('usuario u')
            ->joinWith('favblogs f')
            ->joinWith('notas n')
            ->joinWith('visitas v')
            ->where(['u.id' => Yii::$app->user->id])
            ->groupBy('blogs.id, u.nombre');
    }


    
 
}










