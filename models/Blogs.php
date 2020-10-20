<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blogs".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $descripcion
 * @property string|null $cuerpo
 * @property int $comunidad_id
 * @property int $usuario_id
 * @property string $created_at
 *
 * @property Comunidades $comunidad
 * @property Usuarios $usuario
 * @property Comentarios[] $comentarios
 */
class Blogs extends \yii\db\ActiveRecord
{
   

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
            [['titulo', 'comunidad_id', 'usuario_id'], 'required'],
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
     * Consulta para mostrar Comunidad por su nombre 
     * y el Usuario por su nombre en Blogs
     *
     * @return query
     */
    public static function allBlogs()
    {

        return static::find()
            ->select(['blogs.*', '"u".nombre AS usuario', '"c".denom AS comunidad', '"c".descripcion AS eslogan'])
            ->joinWith('comunidad c')
            ->joinWith('usuario u')
            ->groupBy('blogs.id, u.nombre, c.denom, c.descripcion, c.id');
    }
  

    
 
}










