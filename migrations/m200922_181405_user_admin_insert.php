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
            'alias' => 'adventure',
            'nombre' => 'adventure',
            'apellidos' => 'adventure',
            'email' => 'adminadventure@gmail.com',
            'rol' => 'administrador',
            'fecha_nac' => '2020-11-01',
            'contrasena' => Yii::$app->security->generatePasswordHash('adventure'),
            'auth_key' => Yii::$app->security->generateRandomString(60),
        ]);
    }
    // , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
    // , fecha_nac    timestamp(0)   NOT NULL
    // , contrasena   varchar(255)   NOT NULL
    // , auth_key     varchar(255)
    // , poblacion    varchar(255)
    // , provincia    varchar(255)
    // , pais         varchar(255)
    // , foto_perfil  varchar(255)
    // , bibliografia varchar(255)
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('usuarios', ['nombre' => 'adventure']);
    }

}
