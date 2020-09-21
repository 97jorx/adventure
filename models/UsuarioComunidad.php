<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_comunidad".
 *
 * @property int $id
 * @property int $usuario_id
 * @property bool $creador
 * @property int $comunidad_id
 *
 * @property Comunidades $comunidad
 * @property Usuarios $usuario
 */
class UsuarioComunidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_comunidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'creador', 'comunidad_id'], 'required'],
            [['usuario_id', 'comunidad_id'], 'default', 'value' => null],
            [['usuario_id', 'comunidad_id'], 'integer'],
            [['creador'], 'boolean'],
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
            'usuario_id' => 'Usuario ID',
            'creador' => 'Creador',
            'comunidad_id' => 'Comunidad ID',
        ];
    }

    /**
     * Gets query for [[Comunidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComunidad()
    {
        return $this->hasOne(Comunidades::class, ['id' => 'comunidad_id'])->inverseOf('usuarioComunidads');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('usuarioComunidads');
    }
}
