<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $password
 * @property string $auth_key
 * @property string $telefono
 * @property string $poblacion
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
            [['username', 'nombre', 'apellidos', 'email'], 'required'],
            [['created_at'], 'safe'],
            [['username'], 'string', 'max' => 25],
            [['nombre', 'apellidos', 'email', 'contrasena', 'auth_key', 'poblacion', 'provincia', 'pais'], 'string', 'max' => 255],
            [['rol'], 'string', 'max' => 30],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['password_repeat'], 'required', 'on' => self::SCENARIO_CREAR],
            [['password_repeat'], 'compare', 'compareAttribute' => 'contrasena'],
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
            'email' => 'Email',
            'rol' => 'Rol',
            'created_at' => 'Created At',
            'contrasena' => 'Contrasena',
            'password_repeat' => 'Repetir contraseña',
            'auth_key' => 'Auth Key',
            'poblacion' => 'Poblacion',
            'provincia' => 'Provincia',
            'pais' => 'Pais',
        ];
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::class, ['user_id_comment' => 'id'])->inverseOf('userIdComment');
    }

    /**
     * Gets query for [[Perfils]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfiles()
    {
        return $this->hasMany(Perfil::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[UsuarioComunidads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioComunidades()
    {
        return $this->hasMany(UsuarioComunidad::class, ['usuario_id' => 'id'])->inverseOf('usuario');
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


    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario === self::SCENARIO_CREAR) {
            parent::afterSave($insert, $changedAttributes);
            $perfil = new Perfil;
            $perfil->usuario_id = $this->id;
            return $perfil->save();
        }
            return false;
    }


}
