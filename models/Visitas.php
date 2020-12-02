<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitas".
 *
 * @property int $id
 * @property int|null $visitas
 * @property int $usuario_id
 * @property int $blog_id
 * @property string $created_at
 *
 * @property Blogs $blog
 * @property Usuarios $usuario
 */
class Visitas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visitas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'blog_id'], 'default', 'value' => null],
            [['usuario_id', 'blog_id'], 'integer'],
            [['usuario_id', 'blog_id'], 'required'],
            [['created_at'], 'safe'],
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
            'usuario_id' => 'Usuario ID',
            'blog_id' => 'Blog ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Blog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blogs::class, ['id' => 'blog_id'])->inverseOf('visitas');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('visitas');
    }
}
