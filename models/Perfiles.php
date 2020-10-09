<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfiles".
 *
 * @property int $id
 * @property string|null $foto_perfil
 * @property string|null $bibliografia
 * @property int|null $valoracion
 * @property int $usuario_id
 *
 * @property Usuarios $usuario
 */
class Perfiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valoracion', 'usuario_id'], 'default', 'value' => null],
            [['valoracion', 'usuario_id'], 'integer'],
            [['usuario_id'], 'required'],
            [['foto_perfil', 'bibliografia'], 'string', 'max' => 255],
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
            'foto_perfil' => 'Foto Perfil',
            'bibliografia' => 'Bibliografia',
            'valoracion' => 'Valoracion',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('perfiles');
    }
}
