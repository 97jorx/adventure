<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comunidades".
 *
 * @property int $id
 * @property string $denom
 * @property string $descripcion
 * @property string $created_at
 * @property int $propietario
 *
 * @property Blogs[] $blogs
 * @property Bloqcomunidades[] $bloqcomunidades
 * @property Usuarios $propietario0
 * @property Favcomunidades[] $favcomunidades
 * @property Integrantes[] $integrantes
 */
class Comunidades extends \yii\db\ActiveRecord
{

    private $_favs = null;
    private $_members = null;

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
     * Gets query for [[Bloqcomunidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqcomunidades()
    {
        return $this->hasMany(Bloqcomunidades::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
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
    public function getPropietario0()
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
     * Setter que añade a $favs el valor correspondiente.
     * @param $favs recibe la variable favoritos.
     * @return void.
     */
    public function setFavs($favs) {
        $this->_favs = $favs;
    }

    /**
     * Getter que devuelve  el valor correspondiente de $favs.
     * @return string
     */
    public function getFavs()
    {
        if ($this->_favs === null && !$this->isNewRecord) {
            $this->setFavs($this->getFavcomunidades()->count());
        }
        return $this->_favs;
    }
    

    public function setMembers($members) {
        $this->_members = $members;
    }

    public function getMembers()
    {
        if ($this->_members === null && !$this->isNewRecord) {
            $this->setMembers($this->getIntegrantes()->count());
        }
        return $this->_members;
    }

    /**
     * Gets query for [[Integrantes]].
     * Compruebo si existe el usuario dentro de la comunidad.
     * @param id el id de la comunidad.
     * @return boolean
     */
    public function existeIntegrante($cid)
    {
        $id = Yii::$app->user->id;
        return Integrantes::find()
        ->where(['usuario_id' => $id,])
        ->andWhere(['comunidad_id' => $cid])->exists();        
    }

   /**
     * Devuelve el propietario a partir del id de la comunidad seleccionada.
     * @return Boolean retorna un booleano dependiendo si el usuario actual 
     * es propietario de la comunidad
     */
    public static function esPropietario(){
        $id = Yii::$app->request->get('id');
        $propietario = Comunidades::find()
        ->select('propietario')
        ->where(['id' => $id])->scalar();

        return $propietario === Yii::$app->user->id;
    }

    /**
     * Devuelve un boolean si el usuario actualo esta bloqueado en esa comunidad.
     * @return Boolean retorna un booleano.
     */
    public static function estaBloqueado(){
        $id = Yii::$app->request->get('id');
        $uid = Yii::$app->user->id;
        return Bloqcomunidades::find()
        ->where(['bloqueado' => $uid])
        ->andWhere(['comunidad_id' => $id])
        ->exists();
    }


    /**
     * Consulta para las Comunidades en el index, se calcula el total de favoritos 
     * y el total de integrantes de cada comunidad
     * @return \yii\db\ActiveQuery
     */
    public static function comunidadesQuery()
    {

        return static::find()
            ->select([
                'comunidades.*',
                'COUNT(DISTINCT f.id) AS favs',
                'COUNT(DISTINCT i.id) AS members'
             ])
            ->joinWith('favcomunidades f')
            ->joinWith('integrantes i')
            ->groupBy('comunidades.id');
    }
  

  

}