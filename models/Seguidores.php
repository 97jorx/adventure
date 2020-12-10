<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguidores".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $seguidor
 *
 * @property Usuarios $usuario
 * @property Usuarios $seguidor0
 */
class Seguidores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguidores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'seguidor'], 'required'],
            [['usuario_id', 'seguidor'], 'default', 'value' => null],
            [['usuario_id', 'seguidor'], 'integer'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
            [['seguidor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['seguidor' => 'id']],
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
            'seguidor' => 'Seguidor',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('seguidores');
    }

    /**
     * Gets query for [[Seguidor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidor0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'seguidor'])->inverseOf('seguidores0');
    }
}