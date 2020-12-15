<?php

namespace app\models;

use SplFixedArray;
use Yii;
use yii\helpers\ArrayHelper;
use \yii\db\Expression;

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

    // private $_mes = null;

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
    public static function likesEachMonth()
    {
        $id = Yii::$app->request->get('id');

        $likes_month =
        (new \yii\db\Query())
        ->select(["TO_CHAR(i, 'YY') as Year, DATE_PART('month', i) as mes, COUNT(favcomunidades.id) as favs_count"]) 
        ->from([new Expression("generate_series(NOW() - INTERVAL '1 year', NOW(), '1 month') as i")])
        ->leftJoin("favcomunidades", "TO_CHAR(i, 'YY') = TO_CHAR(favcomunidades.created_at, 'YY') AND TO_CHAR(i, 'MM') = TO_CHAR(favcomunidades.created_at, 'MM')")
        ->where(['favcomunidades.comunidad_id' => $id])
        ->orderBy([new Expression("DATE_PART('month', created_at)")])
        ->groupBy([new Expression("DATE_PART('month', created_at), i.i")])
        ->createCommand()
        ->queryAll();
        
           $likes = new SplFixedArray(12); 
           foreach($likes as $k => $val){
                $likes[$k] = 0;
           } 

           for ($i = 0; $i < count($likes_month); $i++) {
                $likes[$likes_month[$i]['mes']-1] = $likes_month[$i]['favs_count'];
           }


           return array_values($likes->toArray()); 
    }
  
}
