<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bloqueados".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $bloqueado
 *
 * @property Usuarios $usuario
 * @property Usuarios $bloqueado0
 */
class Bloqueados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bloqueados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'bloqueado'], 'required'],
            [['usuario_id', 'bloqueado'], 'default', 'value' => null],
            [['usuario_id', 'bloqueado'], 'integer'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
            [['bloqueado'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['bloqueado' => 'id']],
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
            'bloqueado' => 'Bloqueado',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('bloqueados');
    }

    /**
     * Gets query for [[Bloqueado0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueado0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'bloqueado'])->inverseOf('bloqueados0');
    }


 
}
