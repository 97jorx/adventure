<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favblogs".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $blog_id
 *
 * @property Blogs $blog
 * @property Usuarios $usuario
 */
class Favblogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favblogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'blog_id'], 'required'],
            [['usuario_id', 'blog_id'], 'default', 'value' => null],
            [['usuario_id', 'blog_id'], 'integer'],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blogs::className(), 'targetAttribute' => ['blog_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
        ];
    }

    /**
     * Gets query for [[Blog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blogs::className(), ['id' => 'blog_id'])->inverseOf('favblogs');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('favblogs');
    }
}
