<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tablones".
 *
 * @property int $id
 * @property int $blogs_id
 * @property int|null $blogs_destacados_id
 * @property int|null $galerias_id
 *
 * @property Comunidades[] $comunidades
 * @property Galerias $galerias
 */
class Tablones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tablones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blogs_id'], 'required'],
            [['blogs_id', 'blogs_destacados_id', 'galerias_id'], 'default', 'value' => null],
            [['blogs_id', 'blogs_destacados_id', 'galerias_id'], 'integer'],
            [['galerias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Galerias::class, 'targetAttribute' => ['galerias_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blogs_id' => 'Blogs ID',
            'blogs_destacados_id' => 'Blogs Destacados ID',
            'galerias_id' => 'Galerias ID',
        ];
    }

    /**
     * Gets query for [[Comunidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComunidades()
    {
        return $this->hasMany(Comunidades::class, ['tablon_id' => 'id'])->inverseOf('tablon');
    }

    /**
     * Gets query for [[Galerias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGalerias()
    {
        return $this->hasOne(Galerias::class, ['id' => 'galerias_id'])->inverseOf('tablones');
    }
}
