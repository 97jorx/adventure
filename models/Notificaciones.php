<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string|null $mensaje
 * @property bool|null $leido
 * @property string $created_at
 *
 * @property Usuarios $usuario
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'required'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['mensaje'], 'string'],
            [['leido'], 'boolean'],
            [['created_at'], 'safe'],
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
            'mensaje' => 'Mensaje',
            'leido' => 'Leido',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('notificaciones');
    }
}
