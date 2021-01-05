<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favblogs".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $blog_id
 *
 * @property Blogs $blog
 * @property Usuarios $usuario
 */
class Favblogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favblogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'blog_id'], 'required'],
            [['usuario_id', 'blog_id'], 'default', 'value' => null],
            [['usuario_id', 'blog_id'], 'integer'],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blogs::class, 'targetAttribute' => ['blog_id' => 'id']],
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
            'blog_id' => 'Blog ID',
        ];
    }

    /**
     * Gets query for [[Blog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blogs::class, ['id' => 'blog_id'])->inverseOf('favblogs');
    }


    
    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('favblogs');
    }



    /**
     * Después de que se inserte una fila en la tabla Favblogs 
     * se crea una fila en la tabla notificaciones, pasandole el 
     * nombre del blog al que se le ha dado like y al usuario que 
     * tiene ese blog.
     *
     * @param [type] $insert
     * @return true
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $usuario = Usuarios::find()
        ->select('alias')
        ->where(['id' => Yii::$app->user->id])
        ->scalar();

        $blog_propietario = Blogs::find()
        ->select('usuario_id')
        ->where(['id' => $this->blog_id])
        ->scalar();

        $blog_titulo = Blogs::find()
        ->select('titulo')
        ->where(['id' => $this->blog_id])
        ->scalar();

        $mensaje = 'A <strong>' . $usuario . '</strong> le gusta tu blog <br>' . 
                    '"<strong>' . $blog_titulo . '</strong>".';

        $existe = Notificaciones::find()
        ->where(['usuario_id' => $blog_propietario])
        ->andWhere(['mensaje' => $mensaje])->exists();

        if(!$existe) {
            $n = new Notificaciones();
            $n->usuario_id = $blog_propietario;
            $n->mensaje = $mensaje;
            $n->save();
        }
        return true;
    }


}
