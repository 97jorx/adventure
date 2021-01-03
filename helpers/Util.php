<?php

namespace app\helpers;

use app\models\Comunidades;
use Yii;
use app\models\Favcomentarios;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use Aws\S3\S3Client;

require '../vendor/autoload.php';
class Util  {


    /**
     * Cuenta los likes del comentario.
     *
     * @param [type] $cid ID del comentario pasado por parámetro.
     * @return integer
     */
    public static function countLikes($cid) {
        return Favcomentarios::find()
                ->where(['comentario_id' => $cid])
                ->count();
    }


    /**
     * Dame el nombre de la comunidad a partir de id.
     * Para evitar por ejemplo el crsf
     *
     * @param [string] $content
     */
    public static function comunidad(){
        $id = Yii::$app->request->get('actual');
        return Comunidades::find()
        ->select('denom')
        ->where(['id' => $id])
        ->scalar();
    }

    
    /**
     * Funcion para transformar las etiquetas html.
     * Para evitar por ejemplo el crsf
     *
     * @param [string] $content
     */
    public static function h($content){
        return Html::encode($content);
    }


    /**
     * Funcion para transformar las etiquetas html.
     * Para evitar por ejemplo el crsf
     *
     * @param [type] $content
     * @return void
     */
    public static function p($html){
        HtmlPurifier::process($html);
    }


    /**
     * Elimina la foto de AWS
     */
    public static function s3DeleteImage($name) {
        
        // Instantiate an Amazon S3 client.
        $s3 = new S3Client([
            'credentials' => [
                'key' => getenv('ID_KEY'),
                'secret' => getenv('SECRET_KEY'),
            ],
            'version' => 'latest',
            'region'  => 'us-east-2'
        ]);

        $s3->deleteObject([
            'Bucket' => 'yii-adventure',
            'Key' => $name,
        ]);

        
       
        // Upload a publicly accessible file. The file size and type are determined by the SDK.
        // try {
        //     $s3->putObject([
        //         'Bucket' => 'yii-adventure',
        //         'Key'    => $name,
        //         'Body'   => fopen($file, 'r'),
        //         'ACL'    => 'public-read',
        //     ]);
        // } catch (Aws\S3\Exception\S3Exception $e) {
        //     echo "There was an error uploading the file.\n";
        // }

    }


   



}