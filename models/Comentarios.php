<?php

namespace app\models;

use app\helpers\Util;
use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int|null $blog_id
 * @property int $parent_id
 * @property string $texto
 * @property string $created_at
 *
 * @property Blogs $blog
 * @property Comentarios $reply
 * @property Comentarios[] $comentarios
 * @property Usuarios $usuario
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'texto'], 'required'],
            [['usuario_id', 'perfil', 'blog_id', 'parent_id'], 'default', 'value' => null],
            [['usuario_id', 'perfil', 'blog_id', 'parent_id'], 'integer'],
            [['created_at'], 'safe'],
            [['texto'], 'string', 'max' => 255],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blogs::class, 'targetAttribute' => ['blog_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'usuario_id' => 'Usuario ID',
            'blog_id' => 'Blog comentado',
            'parent_id' => 'Usuario respuesta',
            'texto' => 'Texto',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Blog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blogs::class, ['id' => 'blog_id'])->inverseOf('comentarios');
    }

    /**
     * Gets query for [[parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comentarios::class, ['id' => 'parent_id'])
                    ->alias('parent')
                    // ->from(Comentarios::tableName() . ' AS parent')
                    ->orderBy(['created_at' => SORT_DESC]);
        
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::class, ['parent_id' => 'id'])
        ->inverseOf('parent');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('comentarios');
    }

  /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function findResponses($id, $blogid = null)
    {
            return Comentarios::find()
            ->joinWith('comentarios c')
            ->joinWith('parent p')
            ->where(['p.blog_id' => $blogid])
            ->andWhere(['c.id' => $id])
            ->asArray()
            ->all();

    }

  

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function findResponsesById($id, $blogid = null)
    {
            return Comentarios::find()
            ->select(['usuarios.*', 'parent.*'])
            ->from('comentarios parent')
            ->leftJoin('comentarios', 'parent.parent_id = comentarios.id')
            ->leftJoin('usuarios', 'parent.usuario_id = usuarios.id')
            ->where(['parent.blog_id' => $blogid])
            ->andWhere(['comentarios.id' => $id])
            ->asArray()
            ->all();

    }

     /**
     * Después de que se inserte una fila en la tabla Comentarios 
     * se crea una fila en la tabla notificaciones, pasandole el 
     * el nombre del usuario que ha comentado ese blog y al id del 
     * usuario al que pertenece ese blog en notificaciones.usuario_id.
     *
     * @param [type] $insert
     * @return true
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->blog_id != null) {

            $usuario_alias = Usuarios::find()
            ->select('alias')
            ->where(['id' => $this->usuario_id])
            ->scalar();


            $blog_propietario = Blogs::find()
            ->select('usuario_id')
            ->where(['id' => $this->blog_id])
            ->scalar();

            $blog_titulo = Blogs::find()
            ->select('titulo')
            ->where(['id' => $this->blog_id])
            ->scalar();

             $mensaje = '<strong>'. $usuario_alias. '</strong>" ha comentado "<br><strong>
                        ' . Util::h($blog_titulo) . '</strong>"';

            $existe = Notificaciones::find()
            ->where(['usuario_id' => $blog_propietario])
            ->andWhere(['mensaje' => $mensaje])->exists();

            if (!$existe) {
                $n = new Notificaciones();
                $n->usuario_id = $blog_propietario;
                $n->mensaje = $mensaje;
                $n->save();
            }
        }
        return true;
    }


}
