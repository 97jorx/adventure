<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comunidades".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $created_at
 * @property int $tablon_id
 *
 * @property Tablones $tablon
 * @property UsuarioComunidad[] $usuarioComunidads
 */
class Comunidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comunidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'tablon_id'], 'required'],
            [['descripcion'], 'string'],
            [['created_at'], 'safe'],
            [['tablon_id'], 'default', 'value' => null],
            [['tablon_id'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
            [['tablon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tablones::class, 'targetAttribute' => ['tablon_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'tablon_id' => 'Tablon ID',
        ];
    }

    /**
     * Gets query for [[Tablon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTablon()
    {
        return $this->hasOne(Tablones::class, ['id' => 'tablon_id'])->inverseOf('comunidades');
    }

    /**
     * Gets query for [[UsuarioComunidads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioComunidads()
    {
        return $this->hasMany(UsuarioComunidad::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
    }
}
