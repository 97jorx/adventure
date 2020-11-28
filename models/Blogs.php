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
 * @property int|null $visitas
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
            [['comunidad_id', 'usuario_id', 'visitas'], 'default', 'value' => null],
            [['comunidad_id', 'usuario_id', 'visitas'], 'integer'],
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
            'visitas' => 'Visitas', 
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
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotas()
    {
        return $this->hasMany(Notas::class, ['blog_id' => 'id'])->inverseOf('blog');
    }



    public function setFavs($favs) {
        $this->_favs = $favs;
    }

    public function getFavs()
    {
        if ($this->_favs === null && !$this->isNewRecord) {
            $this->setFavs($this->getFavblogs()->count());
        }
        return $this->_favs;
    }


    public function setValoracion($valoracion) {
        $this->_valoracion = $valoracion;
    }

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
                'COUNT(f.id) AS favs',
                'SUM(n.nota) AS valoracion'
             ])
            ->joinWith('comunidad c')
            ->joinWith('usuario u')
            ->joinWith('favblogs f')
            ->joinWith('notas n')
            ->groupBy('blogs.id, u.nombre, c.denom, c.descripcion');
    }
  

    
 
}










