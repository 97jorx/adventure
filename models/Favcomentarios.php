<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favcomentarios".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $comentario_id
 * @property string $created_at
 *
 * @property Comentarios $comentario
 * @property Usuarios $usuario
 */
class Favcomentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favcomentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'comentario_id'], 'required'],
            [['usuario_id', 'comentario_id'], 'default', 'value' => null],
            [['usuario_id', 'comentario_id'], 'integer'],
            [['created_at'], 'safe'],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::class, 'targetAttribute' => ['comentario_id' => 'id']],
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
            'comentario_id' => 'Comentario ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Comentario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentarios::class, ['id' => 'comentario_id'])->inverseOf('favcomentarios');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('favcomentarios');
    }
}
