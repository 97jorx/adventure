<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "favcomunidades".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $comunidad_id
 *
 * @property Blogs $comunidad
 * @property Usuarios $usuario
 */
class Favcomunidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favcomunidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'comunidad_id'], 'required'],
            [['usuario_id', 'comunidad_id'], 'default', 'value' => null],
            [['usuario_id', 'comunidad_id'], 'integer'],
            [['comunidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comunidades::class, 'targetAttribute' => ['comunidad_id' => 'id']],
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
        return $this->hasOne(Comunidades::class, ['id' => 'comunidad_id'])->inverseOf('favcomunidades');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('favcomunidades');
    }


  /**
     * Devuelve un array con los likes de las comunidades de cada mes 
     * y el total de integrantes de cada comunidad
     * @return Array
     */
    public static function likesEachMonth()
    {
        $id = Yii::$app->request->get('id');
        
        //    SELECT COUNT(id), TO_CHAR(TO_DATE(date_part('month', created_at)::text, 'MM'), 'Month') as date 
        //      FROM favcomunidades 
        //     WHERE comunidad_id = :id
        // GROUP BY date_part('month', created_at);
        
        $likes_month =  static::find()
        ->select([
            'COUNT(id) as favs_count', 
            "TO_CHAR(TO_DATE(DATE_PART('month', created_at)::text, 'MM'), 'Month') as mes",
        ])
        // ->where(['comunidad_id' => $id])
        ->groupBy('created_at')
        ->orderBy('created_at')
        ->asArray()
        ->all();


        return $likes_month;

    }

}
