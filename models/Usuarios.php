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
            [['valoracion'], 'default', 'value' => null],
            [['valoracion'], 'integer'],
            [['alias'], 'unique'],
            [['alias'], 'string', 'max' => 35],
            [['alias'], 'checkAttributeName'],
            [['username'], 'unique'],
            [['username'], 'string', 'max' => 25],
            [['username'], 'checkAttributeName'],
            [['nombre'], 'match', 'pattern' => '/^(?=.{3,8}$)[a-zñA-ZÑ]*$/', 'message' => 'El {attribute} es incorrecto, vuelva a intentarlo.'],
            [['apellidos'], 'match', 'pattern' => '/^(?=.{3,40}$)[A-Z][a-z]+(?: [A-Z][a-zñáéíóú]+)?$/'],
            [['nombre', 'apellidos', 'email', 'contrasena', 'auth_key', 'poblacion', 'provincia', 'pais', 'foto_perfil', 'bibliografia'], 'string', 'max' => 255],
            [['rol'], 'string', 'max' => 30],
            [['email'],'unique'],
            ['fecha_nac', 'date', 'format' => 'php:d/m/Y'],
            ['email', 'email'],
            
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
            'created_at' => 'Created At',
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
     * Gets query for [[Bloqueados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloqueados()
    {
        return $this->hasMany(Bloqueados::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }


    /**
     * Gets query for [[Seguidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores()
    {
        return $this->hasMany(Seguidores::class, ['usuario_id' => 'id'])->inverseOf('usuario');
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
            $this->setFollowers($this->getFollowers()->count());
        }
        return $this->_followers;
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



}
