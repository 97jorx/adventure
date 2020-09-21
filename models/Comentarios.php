<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property int $user_id_comment
 * @property int $id_comment_blog
 * @property string|null $texto
 * @property string $created_at
 *
 * @property Blogs $commentBlog
 * @property Usuarios $userIdComment
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id_comment', 'id_comment_blog'], 'required'],
            [['user_id_comment', 'id_comment_blog'], 'default', 'value' => null],
            [['user_id_comment', 'id_comment_blog'], 'integer'],
            [['created_at'], 'safe'],
            [['texto'], 'string', 'max' => 255],
            [['id_comment_blog'], 'exist', 'skipOnError' => true, 'targetClass' => Blogs::class, 'targetAttribute' => ['id_comment_blog' => 'id']],
            [['user_id_comment'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['user_id_comment' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id_comment' => 'User Id Comment',
            'id_comment_blog' => 'Id Comment Blog',
            'texto' => 'Texto',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[CommentBlog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommentBlog()
    {
        return $this->hasOne(Blogs::class, ['id' => 'id_comment_blog'])->inverseOf('comentarios');
    }

    /**
     * Gets query for [[UserIdComment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserIdComment()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'user_id_comment'])->inverseOf('comentarios');
    }
}
