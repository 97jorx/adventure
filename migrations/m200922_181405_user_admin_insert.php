<?php

use yii\db\Migration;

/**
 * Class m200922_181405_user_admin_insert
 */
class m200922_181405_user_admin_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('usuarios', [
            'username' => 'adventure',
            'nombre' => 'adventure',
            'apellidos' => 'adventure',
            'email' => 'adminadventure@gmail.com',
            'rol' => 'administrador',
            'contrasena' => Yii::$app->security->generatePasswordHash('adventure'),
            'auth_key' => Yii::$app->security->generateRandomString(60),
            'poblacion' => 'Sanlúcar',
            'provincia' => 'Cádiz',
            'pais' => 'España',
            'foto_perfil' => 'foto.jpg',
            'bibliografia' => 'Soy el administrador de Adventure',
            'valoracion' => 5,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('usuarios', ['nombre' => 'adventure']);
    }

}
