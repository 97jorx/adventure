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
     * Subir una imagen a partir del local.
     * 
     * @param mixed $name el nombre del archivo a eliminar del bucket.
     * 
     * Documentación de los métodos utilizados.
     * https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.S3.S3Client.html#_getObjectUrl
     * 
     */
    public static function uploadImage($name) {
        
        // Instantiate an Amazon S3 client.
        
    }

    

    /**
     * Elimina la imagen del bucket de AWS.
     * 
     * @param mixed $name el nombre del archivo a eliminar del bucket.
     * 
     * Documentación de los métodos utilizados.
     * https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.S3.S3Client.html#_getObjectUrl
     * 
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


        try {
            $s3->deleteObject([
                'Bucket' => 'yii-adventure',
                'Key' => $name,
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
    }


    /**
    * Sube una foto a AWS a partir de la ruta y el nombre.
    *
    * @param $file es la ruta del archivo en local
    * @param $name es el nombre del archivo
    *
    * Documentación de los métodos utilizados.
    * https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-mediastore-data-2017-09-01.html#putobject
    *
    */
     public static function s3UploadImage($file, $name) {
        
        // Instantiate an Amazon S3 client.
        $s3 = new S3Client([
            'credentials' => [
                'key' => getenv('ID_KEY'),
                'secret' => getenv('SECRET_KEY'),
            ],
            'version' => 'latest',
            'region'  => 'us-east-2'
        ]);

       
        // Upload a publicly accessible file. The file size and type are determined by the SDK.
        try {
            $s3->putObject([
                'Bucket' => 'yii-adventure',
                'Key'    => $name,
                'Body'   => fopen($file, 'r'),
                'ACL'    => 'public-read',
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }

    }

    /**
    * Devuelvo la ruta de la imagen desde el bucket.
    * @param mixed $name nombre de la imagen.
    *
    * Documentación de los métodos utilizados.
    * https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.S3.S3Client.html#_getObjectUrl
    *
    */
    public static function s3GetImage($name) {
        // Instantiate an Amazon S3 client.
        $s3 = new S3Client([
            'credentials' => [
                'key' => getenv('ID_KEY'),
                'secret' => getenv('SECRET_KEY'),
            ],
            'version' => 'latest',
            'region'  => 'us-east-2'
        ]);

        try {
            // Get the object.
            $result = $s3->getObjectUrl('yii-adventure', $name);
            // Display the object in the browser.
            return $result;
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

    }

}