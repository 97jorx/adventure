<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comunidades".
 *
 * @property int $id
 * @property string $denom
 * @property string|null $descripcion
 * @property string $created_at
 * @property int $propietario
 *
 * @property Blogs[] $blogs
 * @property Usuarios $propietario0
 * @property Integrantes[] $integrantes
 */
class Comunidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comunidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denom', 'propietario' ,'descripcion'], 'required'],
            [['descripcion'], 'string'],
            [['created_at'], 'safe'],
            [['propietario'], 'default', 'value' => null],
            [['propietario'], 'integer'],
            [['denom'], 'string', 'max' => 255],
            [['denom'], 'unique'],
            [['propietario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['propietario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denom' => 'Título',
            'descripcion' => 'Cuerpo',
            'created_at' => 'Fecha de creación',
            'propietario' => 'propietario',
        ];
    }

    /**
     * Gets query for [[Blogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blogs::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
    }

    /**
     * Gets query for [[Favcomunidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavcomunidades()
    {
        return $this->hasMany(Favcomunidades::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
    }

    /**
     * Gets query for [[propietario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropietario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'propietario'])->inverseOf('comunidades');
    }

    /**
     * Gets query for [[Integrantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrantes::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
    }

    /**
     * Gets query for [[Integrantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function existeIntegrante($cid)
    {
        $id = Yii::$app->user->id;
        return Integrantes::find()
        ->where(['usuario_id' => $id,])
        ->andWhere(['comunidad_id' => $cid])->exists();        
            
    }


    /**
     * Consulta para mostrar Comunidad por su nombre 
     * y el Usuario por su nombre en Blogs
     *
     * @return query
     */
    public static function comunidadesQuery()
    {

        return static::find()
            ->select([
                'COUNT(f.id) AS favs'
             ])
            ->joinWith('favcomunidades f')
            ->groupBy('blogs.id');
    }
  
}