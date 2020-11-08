<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bloqcomunidades".
 *
 * @property int $id
 * @property int $bloqueado
 * @property int $comunidad_id
 *
 * @property Comunidades $comunidad
 * @property Usuarios $bloqueado0
 */
class Bloqcomunidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bloqcomunidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloqueado', 'comunidad_id'], 'required'],
            [['bloqueado', 'comunidad_id'], 'default', 'value' => null],
            [['bloqueado', 'comunidad_id'], 'integer'],
            [['comunidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comunidades::class, 'targetAttribute' => ['comunidad_id' => 'id']],
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
            'bloqueado' => 'Bloqueado',
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
        return $this->hasOne(Comunidades::class, ['id' => 'comunidad_id'])->inverseOf('bloqcomunidades');
    }

    /**
     * Gets query for [[Bloqueado0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueado0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'bloqueado'])->inverseOf('bloqcomunidades');
    }
}
