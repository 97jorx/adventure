<?php

namespace tests\unit\models;

use app\models\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username',
            'contrasena' => 'not_existing_contrasena',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginWrongContrasena()
    {
        $this->model = new LoginForm([
            'username' => 'admin',
            'contrasena' => 'wrong_contrasena',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('contrasena');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'username' => 'admin',
            'contrasena' => 'admin',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('contrasena');
    }

}
