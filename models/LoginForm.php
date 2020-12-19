<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $contrasena;
    public $rememberMe = true;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'contrasena'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatepassword()
            ['contrasena', 'validatecontrasena'],
        ];
    }

     /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateContrasena($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validateContrasena($this->contrasena)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function validateSize($attribute, $params)
    {
        if(!$this->hasErrors())
             $imagen = $this->imagen;
         
        if ($this->imagen->size > $this->imagen->maxSize ) {
            $this->addError($attribute, 'La imagen que ha introducido pesa demasiado.');
        }
    }


    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
            
        $session = (new Query())
        ->select(['user_id'])
        ->from('session')
        ->scalar();
        
        $model = Usuarios::find()->where(['id' => $session]);
        $model->estado_id = 1;
        $model->save();

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findPorNombre($this->username);
        }

        return $this->_user;
    }
}
