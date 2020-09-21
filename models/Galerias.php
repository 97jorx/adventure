<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "galerias".
 *
 * @property int $id
 * @property string|null $fotos
 *
 * @property Tablones[] $tablones
 */
class Galerias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galerias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fotos'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fotos' => 'Fotos',
        ];
    }

    /**
     * Gets query for [[Tablones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTablones()
    {
        return $this->hasMany(Tablones::class, ['galerias_id' => 'id'])->inverseOf('galerias');
    }
}
