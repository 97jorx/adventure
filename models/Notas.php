<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notas".
 *
 * @property int $id
 * @property int|null $nota
 * @property int $blog_id
 * @property int $usuario_id
 *
 * @property Blogs $blog
 * @property Usuarios $usuario
 */
class Notas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nota', 'blog_id', 'usuario_id'], 'default', 'value' => null],
            [['nota', 'blog_id', 'usuario_id'], 'integer'],
            [['blog_id', 'usuario_id'], 'required'],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blogs::class, 'targetAttribute' => ['blog_id' => 'id']],
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
            'nota' => 'Nota',
            'blog_id' => 'Blog ID',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * Gets query for [[Blog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blogs::class, ['id' => 'blog_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id']);
    }
}
