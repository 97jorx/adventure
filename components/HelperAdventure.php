<?php

namespace app\components;

use yii\base\Component;


class HelperAdventure extends Component
{
    /**
     * Crea un enlace que ordena los blogs a partir del ActiveDataProvider 
     * @param ActiveDataProvider $provider el objeto ActiveDataProvider recibido del BlogsSearch
     * @param string $elem el nombre de la columna a ordenar 
     * @param string $name nombre del enlace
     * @return link
     */
    public static function ordenarBlog($provider, $elem, $name)
    {
        return $provider->sort->link($elem, 
        [
         'class'     => 'sort',
         'label'     =>  $name,
        ]);
    }
}
