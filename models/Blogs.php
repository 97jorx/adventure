<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blogs".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $descripcion
 * @property string|null $cuerpo
 * @property string $created_at
 *
 * @property Comentarios[] $comentarios
 */
class Blogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['cuerpo'], 'string'],
            [['created_at'], 'safe'],
            [['titulo', 'descripcion'], 'string', 'max' => 255],
            [['titulo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'cuerpo' => 'Cuerpo',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::class, ['id_comment_blog' => 'id'])->inverseOf('commentBlog');
    }
}
