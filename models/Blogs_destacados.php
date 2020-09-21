<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blogs_destacados".
 *
 * @property int $id
 * @property string|null $titulo
 * @property int|null $likes
 * @property int|null $comments
 * @property string $created_at
 */
class Blogs_destacados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogs_destacados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['likes', 'comments'], 'default', 'value' => null],
            [['likes', 'comments'], 'integer'],
            [['created_at'], 'safe'],
            [['titulo'], 'string', 'max' => 255],
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
            'likes' => 'Likes',
            'comments' => 'Comments',
            'created_at' => 'Created At',
        ];
    }
}
