<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $username
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
 * @property Comunidades[] $comunidades
 * @property Favblogs[] $favblogs
 * @property Favcomunidades[] $favcomunidades
 * @property Integrantes[] $integrantes
 * @property Notas[] $notas
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{

    const SCENARIO_CREAR = 'crear';

    public $password_repeat;


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
            [['username', 'nombre', 'apellidos', 'email', 'fecha_nac', 'contrasena'], 'required'],
            [['username', 'nombre', 'apellidos', 'email', 'poblacion', 'provincia', 'pais'], 'trim'],
            [['created_at', 'fecha_nac'], 'safe'],
            ['fecha_nac', 'date', 'format' => 'php:Y/m/d'],
            [['valoracion'], 'default', 'value' => null],
            [['valoracion'], 'integer'],
            [['username'], 'string', 'max' => 25],
            [['nombre', 'apellidos', 'email', 'contrasena', 'auth_key', 'poblacion', 'provincia', 'pais', 'foto_perfil', 'bibliografia'], 'string', 'max' => 255],
            [['rol'], 'string', 'max' => 30],
            [['email'],'unique'],
            ['email', 'email'],
            [['username'], 'unique'],
            [
                ['contrasena'],
                'trim',
                'on' => [self::SCENARIO_CREAR],
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
            'username' => 'Username',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'fecha_nac' => 'Fecha Nac', 
            'email' => 'Email',
            'rol' => 'Rol',
            'created_at' => 'Created At',
            'contrasena' => 'Contrasena',
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



    /**
    * Gets query for [[Comunidades]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getComunidades()
    {
        return $this->hasMany(Comunidades::class, ['propietario' => 'id'])->inverseOf('propietario');
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



    /** Gets query for [[Integrantes]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getIntegrantes()
   {
       return $this->hasMany(Integrantes::class, ['usuario_id' => 'id'])->inverseOf('usuario');
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
