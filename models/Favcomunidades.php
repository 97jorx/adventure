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
     * Devuelve un array con la cuenta de los likes. Si @param condicion es 0.
     * Devuelve un array con los meses. Si @param condicion es 1.
     * @return Array
     */
    public static function likesEachMonth($condicion)
    {
        $id = Yii::$app->request->get('id');

        $var =  ($condicion) ? 
        (static::find()->select(["TO_CHAR(TO_DATE(DATE_PART('month', created_at)::text, 'MM'), 'Month') as mes"])) : 
        (static::find()->select(['COUNT(id) as favs_count']));

        $likes_month =  $var
        ->where(['comunidad_id' => $id])
        ->groupBy('created_at')
        ->orderBy('created_at')
        ->column();
        
        return  $likes_month;
    }
  
}
