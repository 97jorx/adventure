<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $username
 * @property string $alias
 * @property string $nombre
 * @property string $apellidos
 * @property string $email
 * @property string $rol
 * @property string $created_at
 * @property string $fecha_nac
 * @property string $contrasena
 * @property string|null $auth_key
 * @property string|null $poblacion
 * @property string|null $provincia
 * @property string|null $pais
 * @property string|null $foto_perfil
 * @property string|null $bibliografia
 * @property int|null $valoracion
 *
 * @property Blogs[] $blogs
 * @property Bloqcomunidades[] $bloqcomunidades
 * @property Bloqueados[] $bloqueados
 * @property Bloqueados[] $bloqueados0
 * @property Comunidades[] $comunidades
 * @property Favblogs[] $favblogs
 * @property Favcomunidades[] $favcomunidades
 * @property Integrantes[] $integrantes
 * @property Notas[] $notas
 * @property Seguidores[] $seguidores
 * @property Seguidores[] $seguidores0
 * @property Visitas[] $visitas
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{

    const SCENARIO_CREAR = 'crear';

    public $password_repeat;
    private $_followers = null;
    private $_following = null;
    private $_valoracion = null;
    private $_imagen = null;
    private $_imagenUrl = null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'nombre', 'apellidos', 'email', 'fecha_nac', 'contrasena', 'alias'], 'required', 'message' => 'El campo {attribute} es obligatorio, no puede estar vacío.'],
            [['username', 'nombre', 'apellidos', 'email', 'poblacion', 'provincia', 'pais', 'alias'], 'trim'],
            [['created_at', 'fecha_nac'], 'safe'],
            [['alias'], 'unique'],
            [['alias'], 'string', 'max' => 35],
            [['alias'], 'checkAttributeName'],
            [['estado_id'], 'default', 'value' => 4],
            [['estado_id'], 'integer'],
            [['username'], 'unique'],
            [['username'], 'string', 'max' => 25],
            [['username'], 'checkAttributeName'],
            [['nombre'], 'match', 'pattern' => '/^(?=.{3,8}$)[a-zñA-ZÑ]*$/', 'message' => 'El {attribute} es incorrecto, vuelva a intentarlo.'],
            [['apellidos'], 'match', 'pattern' => '/^(?=.{3,40}$)[A-Z][a-z]+(?: [A-Z][a-zñáéíóú]+)?$/'],
            [['nombre', 'apellidos', 'email', 'contrasena', 'auth_key', 'poblacion', 'provincia', 'pais', 'foto_perfil', 'bibliografia'], 'string', 'max' => 255],
            [['foto_perfil'], 'string', 'max' => 255],
            [['rol'], 'string', 'max' => 30],
            [['email'],'unique'],
            ['fecha_nac', 'date', 'format' => 'php:d/m/Y'],
            ['email', 'email'],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['estado_id' => 'id']],
            
            [
                ['contrasena'],
                'trim',
                'on' => [self::SCENARIO_CREAR],
            ],
            [
                ['contrasena'],
                'match', 'pattern' => '/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!?¿()=.@#$%]).{8,15})/',
            ],
            [['password_repeat'], 

                'compare', 
                'compareAttribute' => 'contrasena',
                'on' => self::SCENARIO_CREAR,
                'skipOnEmpty' => false,

            ],
            [['password_repeat'],
            
                'required'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nombre de usuario',
            'alias' => 'Alias',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'fecha_nac' => 'Fecha Nacimiento', 
            'email' => 'Correo Electrónico',
            'rol' => 'Rol',
            'created_at' => 'Cuenta creada en',
            'contrasena' => 'Contraseña',
            'password_repeat' => 'Repetir contraseña',
            'auth_key' => 'Auth Key',
            'poblacion' => 'Poblacion',
            'provincia' => 'Provincia',
            'pais' => 'Pais',
            'foto_perfil' => 'Foto Perfil', 
            'bibliografia' => 'Bibliografia', 
            'valoracion' => 'Valoracion', 
        ];
    }



    public function checkAttributeName($attribute, $params)
	{
        $pattern = '/^[A-Za-z][A-Za-z0-9]{3,25}$/';
         if(!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'El '. $attribute .' es inválido.');
        }
        
	}

    /**
     * Gets query for [[Estado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estados::class, ['id' => 'estado_id'])->inverseOf('usuarios');
    }


    /**
     * Gets query for [[Bloqueados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueados()
    {
        return $this->hasMany(Bloqueados::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Bloqueados0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueados0()
    {
        return $this->hasMany(Bloqueados::class, ['bloqueado' => 'id'])->inverseOf('bloqueado0');
    }


     /**
     * Gets query for [[Seguidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores()
    {
        return $this->hasMany(Seguidores::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Seguidores0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores0()
    {
        return $this->hasMany(Seguidores::className(), ['seguidor' => 'id'])->inverseOf('seguidor0');
    }



    /**
     * Gets query for [[Seguidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiguiendo()
    {
        return $this->hasMany(Seguidores::class, ['seguidor' => 'id'])
        ->onCondition(['seguidor' => $this->id])
        ->inverseOf('usuario');
    }



    /**
     * Gets query for [[Comunidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComunidades()
    {
        return $this->hasMany(Comunidades::class, ['propietario' => 'id'])->inverseOf('propietario0');
    }


    /**    
     * Gets query for [[Blogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blogs::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }


    /**
     * Gets query for [[Favblogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavblogs()
    {
        return $this->hasMany(Favblogs::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }


    /**
     * Gets query for [[Bloqcomunidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqcomunidades()
    {
        return $this->hasMany(Bloqcomunidades::class, ['bloqueado' => 'id'])->inverseOf('bloqueado0');
    }

    /**
     * Gets query for [[Favcomunidades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavcomunidades()
    {
        return $this->hasMany(Favcomunidades::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }


    /**
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotas()
    {
        return $this->hasMany(Notas::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

     /**
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSumaNotas()
    {
        return Notas::find('nota')->where(['usuario_id' => $this->id]);
    }


     /**
     * Gets query for [[Visitas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visitas::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /** Gets query for [[Integrantes]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getIntegrantes()
   {
       return $this->hasMany(Integrantes::class, ['usuario_id' => 'id'])->inverseOf('usuario');
   }



    /**
     * SETTER DE @param followers
     * @return \yii\db\ActiveQuery
     */
    public function setFollowers($followers) {
        $this->_followers = $followers;
    }

    /**
     * GETTER DE @param followers
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers()
    {
        if ($this->_followers === null && !$this->isNewRecord) {
            $this->setFollowers($this->getSeguidores()->count());
        }
        return $this->_followers;
    }


    /**
     * SETTER DE @param followers
     * @return \yii\db\ActiveQuery
     */
    public function setFollowing($following) {
        $this->_following = $following;
    }

    /**
     * GETTER DE @param followers
     * @return \yii\db\ActiveQuery
     */
    public function getFollowing()
    {
        if ($this->_following === null && !$this->isNewRecord) {
            $this->setFollowing($this->getSiguiendo()->count());
        }
        return $this->_following;
    }


 
    /**
     * Gets query for [[Notas]].
     * SETTER DE @param valoracion
     * @return \yii\db\ActiveQuery
     */
    public function setValoracion($valoracion) {
        $this->_valoracion = $valoracion;
    }

    /**
     * Gets query for [[Notas]].
     * GETTER DE @param valoracion
     * @return \yii\db\ActiveQuery
     */
    public function getValoracion()
    {
        if ($this->_valoracion === null && !$this->isNewRecord) {
            $this->setValoracion($this->getSumaNotas()->SUM('nota'));
        }
        return $this->_valoracion;
    }

    /**
     * [[Seguidores]].
     * Compruebo si existe el seguidor del usuario actual.
     * @param alias el id de la comunidad.
     * @return boolean
     */
    public function existeSeguidor($alias)
    {
        $seguidor = Yii::$app->user->id;
        $usuarioid = self::find('id')->where(['alias' => $alias])->scalar();
        return Seguidores::find()
        ->where(['seguidor' => $seguidor])
        ->andWhere(['usuario_id' => $usuarioid])
        ->exists();        
    }


    /**
     * [[Seguidores]].
     * Compruebo si existe el usuario bloqueado por el usuario actual.
     * @param alias el id de la comunidad.
     * @return boolean
     */
    public function existeBloqueado($alias)
    {
        $bloqueador = Yii::$app->user->id;
        $bloqueado = self::find('id')->where(['alias' => $alias])->scalar();
        return Bloqueados::find()
        ->where(['bloqueado' => $bloqueado])
        ->andWhere(['usuario_id' => $bloqueador])
        ->exists();        
    }



    public function getImagen()
    {
        if ($this->_imagen !== null) {
            return $this->_imagen;
        }

        $this->setImagen(Yii::getAlias('@img/' . $this->id . '.jpg'));
        return $this->_imagen;
    }


    public function setImagen($imagen)
    {
        $this->_imagen = $imagen;
    }

    public function getImagenUrl()
    {
        if ($this->_imagenUrl !== null) {
            return $this->_imagenUrl;
        }

        $this->setImagenUrl(Yii::getAlias('@imgUrl/' . $this->id . '.jpg'));
        return $this->_imagenUrl;
    }

    public function setImagenUrl($imagenUrl)
    {
        $this->_imagenUrl = $imagenUrl;
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findPorNombre($nombre)
    {
        return static::findOne(['nombre' => $nombre]);
    }

    public function validateContrasena($contrasena)
    {
        return Yii::$app->security->validatePassword($contrasena, $this->contrasena);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }


        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREAR) {
                $security = Yii::$app->security;
                $this->auth_key = $security->generateRandomString();
                $this->contrasena = $security->generatePasswordHash($this->contrasena);
            }
        }

        return true;
    }


    /**
     * Consulta para mostrar Los bloqueados del usuarios actual
     * @return query
     */
    public static function usuariosBloqueados()
    {
        $uid = Yii::$app->user->id;
        $query =  static::find()
        ->joinWith('bloqueados0 b')
        ->where(['b.usuario_id' => $uid]);
        return $query;
    }
    
    /**
     * Consulta para mostrar Los seguidores del usuarios actual.
     * @return query
     */
    public static function usuariosSeguidores()
    {
        $uid = Yii::$app->user->id;
        $query =  static::find()
        ->joinWith('seguidores0 s')
        ->where(['s.usuario_id' => $uid]);
        return $query;
    }




}
